<?php
use Authy\AuthyApi;

class Ajaxmodel extends CI_Model{

    protected $datas;
    protected $tempDates;
    protected $indicatesLeft = 0;
    protected $indicatesRight = 0;

    public function __construct(){

        parent::__construct();

        $this->userid = $this->session->userdata('myuserid');

        /* Libraries Load */
        $this->load->library('coinpayments');
        
        /* Models Load */
        $this->load->model('faturas/faturasmodel', 'FaturasModel');
    }

    public function NetworkAffiliates($id_sponsor, $binary_key){

        $this->db->where('id_patrocinador_rede', $id_sponsor);
        $this->db->where('chave_binaria', $binary_key);
        $query = $this->db->get('rede');

        if($query->num_rows() > 0){

            foreach($query->result() as $result){

                if($binary_key == 1){

                    $this->indicatesLeft++;
                }else{
                    $this->indicatesRight++;
                }

                $this->NetworkAffiliates($result->id_usuario, $binary_key);
            }
        }
    }

    public function DirectAffiliates($id_sponsor){

        $this->db->where('id_patrocinador_direto', $id_sponsor);
        $query = $this->db->get('rede');

        return $query->num_rows();
    }
    
    public function WhoIsSponsorHTML($id_affiliate){

        $this->db->where('id_usuario', $id_affiliate);
        $query = $this->db->get('rede');

        if($query->num_rows() > 0){

            $row = $query->row();

            if($row->id_patrocinador_direto == $this->userid){

                return $this->lang->line('ajax_network_you_sponsor');
            }

            return sprintf($this->lang->line('ajax_network_sponsor'), UserInfo('login', $row->id_patrocinador_direto));
        }

        return $this->lang->line('ajax_network_sponsor_not_found');
    }

    public function ShowInfoAffiliate(){

        $id_patrocinador = $this->input->post('id_patrocinador');

        $this->db->where('id', $id_patrocinador);
        $query = $this->db->get('usuarios_cadastros');

        if($query->num_rows() > 0){

            $row = $query->row();

            $this->db->where('id_usuario', $id_patrocinador);
            $this->db->select('*');
            $this->db->select_max('valor');
            $this->db->where('status', 1);
            $this->db->where('data_pagamento IS NOT NULL' , null, false);
            $this->db->limit(1);
            $query_plano_ativo = $this->db->get('faturas');

            $linhaPlanoAtivo = $query_plano_ativo->row(); 

            if($query_plano_ativo->num_rows() > 0 && !is_null($linhaPlanoAtivo->id)){
               
                $plano = $query_plano_ativo->result();
                $plano_id = $plano[0]->id_plano;
                $plano_data_ativacao = $plano[0]->data_pagamento;

                $this->db->where('id', $plano_id);
                $this->db->limit(1);
                $query_plano_nome = $this->db->get('planos')->result();
                $plano_nome = $query_plano_nome[0]->nome;

            }

            $indicadosDiretos = $this->DirectAffiliates($id_patrocinador);
            $indicadosEsquerda = $this->NetworkAffiliates($id_patrocinador, 1);
            $indicadosDireita = $this->NetworkAffiliates($id_patrocinador, 2);
            
            $patrocinador = $this->WhoIsSponsorHTML($id_patrocinador);

            return json_encode(array(
                'success'=>'ok',
                'data'=>array(
                    'patrocinador'=>$patrocinador,
                    'avatar'=>AvatarLoad($id_patrocinador),
                    'nome'=>$row->nome,
                    'celular'=>$row->celular,
                    'data_cadastro'=>date('d/m/Y H:i:s', strtotime($row->data_cadastro)),
                    'ultimo_login'=>date('d/m/Y H:i:s', strtotime($row->ultimo_login)),
                    'binario_ativo'=>$row->binario_ativo,
                    'cadastro_ativo'=>$row->plano_ativo,
                    'indicados_diretos'=>$indicadosDiretos,
                    'indicados_esquerda'=>$this->indicatesLeft,
                    'indicados_direita'=>$this->indicatesRight,
                    'plano_ativo' => ($query_plano_ativo->num_rows() > 0 && !is_null($linhaPlanoAtivo->id)) ? $plano_nome : '',
                    'plano_ativo_ativacao' => ($query_plano_ativo->num_rows() > 0 && !is_null($linhaPlanoAtivo->id)) ? $plano_data_ativacao : ''
                )
            ));
        }

        return json_encode(array(
            'success'=>'no',
            'error'=>$this->lang->line('ajax_search_affiliate_not_found_error')
        ));
    }

    public function ChangeBinaryKey(){

        $key = $this->input->post('chave_binaria');

        $this->db->where('id', $this->userid);
        $this->db->update('usuarios_cadastros', array(
            'chave_binaria'=>$key
        ));

        return json_encode(array(
            'success'=>'ok'
        ));
    }

    public function GenerateNewWallet($coin = 'BTC'){

        $idPlan = $this->input->post('id_plano');

        $fatura = $this->FaturasModel->MinhaFatura($idPlan);

        if($fatura !== false){

            if($fatura->status == 0){

                $createWallet = $this->coinpayments->CreateTransactionSimple(
                    $fatura->valor,
                    'BRL',
                    $coin,
                    UserInfo('email'),
                    base_url('webhooks/coinpayments')
                );

                if($createWallet['error'] == 'ok'){

                    $data = array(
                        'id_usuario'=>$this->userid,
                        'id_fatura'=>$fatura->id,
                        'id_transacao'=>$createWallet['result']['txn_id'],
                        'wallet'=>$createWallet['result']['address'],
                        'valor'=>$fatura->valor,
                        'currency1'=>'BRL',
                        'currency2'=>$coin,
                        'status'=>0,
                        'data_criacao'=>date('Y-m-d H:i:s')
                    );
        
                    $this->db->insert('transacoes_criptomoedas', $data);
                    $insertRecord = $this->db->insert_id();

                    if($insertRecord > 0){

                        CreateLog($this->userid, 'Gerou uma nova carteira '.$coin.' para pagamento da fatura ID #'.$fatura->id);

                        return json_encode(array(
                            'success'=>1,
                            'wallet'=>$createWallet['result']['address'],
                            'fracao'=>sprintf('%.08f', $createWallet['result']['amount']).' '.$coin."'s",
                            'qrcode'=>$createWallet['result']['qrcode_url']
                        ));

                    }

                    return json_encode(array(
                        'success'=>0,
                        'error'=>$this->lang->line('ajax_gerar_wallet_db_error')
                    ));
                }

                return json_encode(array(
                    'success'=>0,
                    'error'=>$createWallet['error']
                ));
            }

            return json_encode(array(
                'success'=>0,
                'error'=>alerts($this->lang->line('ajax_gerar_wallet_fat_error'), 'danger')
            ));
        }

        return json_encode(array(
            'success'=>0,
            'error'=>alerts($this->lang->line('ajax_gerar_wallet_fat_inex_error'), 'danger')
        ));
    }

    /* Código que obtem um intervalo de datas e entradas e saidas do sistema para montar o gráfico no admin */

    public function GetDatesLastDaysExtract($interval, $year = false){

        $dates = [];

        $date = date('Y-m-d', (time()-(60*60*24*$interval)));

        for($i=0;$i<$interval;$i++){

            $dateFormater = date('Y-m-d', (strtotime($date)+(60*60*24*$i)));

            if($year){
                $dates[] = date('d/m/Y', strtotime($dateFormater));
            }else{
                $dates[] = date('d/m', strtotime($dateFormater));
            }

            $this->tempDates[] = date('d/m/Y', strtotime($dateFormater));
        }

        return json_encode($dates);
    }

    public function AdminGraphIncomeAndExits($interval){

        $inputs = array();
        $outputs = array();

        $datesOriginal = $this->GetDatesLastDaysExtract($interval, true);
        $dates = json_decode($datesOriginal, TRUE);

        foreach($dates as $date){

            $valorEntrada = 0;
            $valorSaida = 0;

            $split = explode('/', $date);
            $newDate = $split[2].'-'.$split[1].'-'.$split[0];

            $this->db->select_sum('valor');
            $this->db->from('faturas');
            $this->db->where('DATE(data_pagamento) = "'.$newDate.'"', null, false);
            $this->db->group_start();
            $this->db->where('status', 1);
            $this->db->or_where('status', 2);
            $this->db->group_end();
            $query = $this->db->get();

            if($query->num_rows() > 0){
                $valorEntrada = $query->row()->valor;
            }

            $inputs[] = (float)round($valorEntrada, 2);

            $this->db->select_sum('valor_receber');
            $this->db->from('saques');
            $this->db->where('DATE(data_atualizacao) = "'.$newDate.'"', null, false);
            $this->db->where('status', 1);
            $query = $this->db->get();

            if($query->num_rows() > 0){
                $valorSaida = $query->row()->valor_receber;
            }

            $outputs[] = round($valorSaida,2);
        
        }

        $graph = array(
            'dados'=>array(
                array(
                    'name'=>'Entradas',
                    'type'=>'column',
                    'data'=>$inputs
                ),
                array(
                    'name'=>'Saídas',
                    'type'=>'area',
                    'data'=>$outputs
                )
            ),
            'datas'=>json_decode($datesOriginal, true)
        );

        return json_encode($graph);
    }


    public function UsersAll(){

        $this->db->select('u.*');
        $this->db->from('usuarios_cadastros AS u');
        $this->db->where('u.is_admin', 0);
        $query = $this->db->get();

        if($query->num_rows() > 0){

            foreach($query->result() as $result){

                echo $result->id.','.$result->nome.','.$result->email.','.$result->celular.'<br />';
            }
        }
    }

    public function UsersActives(){

        $this->db->select('u.*, f.valor');
        $this->db->from('faturas AS f');
        $this->db->join('usuarios_cadastros AS u', 'u.id = f.id_usuario', 'inner');
        $this->db->where('f.status', 1);
        $this->db->where('u.is_admin', 0);
        $query = $this->db->get();

        if($query->num_rows() > 0){

            foreach($query->result() as $result){

                echo $result->id.','.$result->nome.','.$result->email.','.$result->celular.','.$result->valor.'<br />';
            }
        }
    }

    public function DeleteExtract(){

        $id = $this->input->post('idExtract');

        $this->db->where('id', $id);
        $delete = $this->db->delete('extrato');

        if($delete){

            return json_encode(array('status'=>1));
        }

        return json_encode(array('status'=>0));
    }

    public function AddExtract(){

        $id_usuario = $this->input->post('id_usuario', true);
        $descricao = $this->input->post('descricao', true);
        $valor = $this->input->post('valor', true);
        $tipo_saldo = $this->input->post('tipo_saldo', true);
        $categoria = $this->input->post('categoria', true);
        $referencia = $this->input->post('referencia', true);
        $liberado = $this->input->post('liberado', true);
        $data_criacao_original = $this->input->post('data_criacao', true);

        $this->db->where('id', $id_usuario);
        $query = $this->db->get('usuarios_cadastros');

        if($query->num_rows() > 0){

            $splitDataCriacao = explode('T', $data_criacao_original);
            $data_criacao = InverseDate($splitDataCriacao[0]).' '.$splitDataCriacao[1];

            if($tipo_saldo == 1){
                $color = 'success';
            }else{
                $color = 'danger';
            }

            $insert = $this->db->insert('extrato', array(
                'id_usuario'=>$id_usuario,
                'descricao'=>$descricao,
                'valor'=>$valor,
                'tipo_saldo'=>$tipo_saldo,
                'categoria'=>$categoria,
                'referencia'=>$referencia,
                'liberado'=>$liberado,
                'data_criacao'=>$data_criacao
            ));

            if($insert){

                return json_encode(array(
                    'status'=>1,
                    'id'=>$this->db->insert_id(),
                    'descricao'=>$descricao,
                    'cor_descricao'=>$color,
                    'valor'=>number_format($valor, 2, ',', '.'),
                    'tipo_saldo'=>'<span class="badge badge-'.$color.' badge-pill">'.TipoExtrato($tipo_saldo).'</span>',
                    'categoria'=>CategoriaExtrato($categoria),
                    'referencia'=>$referencia,
                    'liberado'=>$liberado,
                    'data_criacao'=>date('d/m/Y H:i:s', strtotime($data_criacao_original))
                ));
            }

            return json_encode(array(
                'status'=>0,
                'error'=>'Não foi possível fazer atualização. Tente novamente.'
            ));
        }

        return json_encode(array(
            'status'=>0,
            'error'=>'O usuário que você está tentando editar o extrato não existe.'
        ));
    }

    public function InfoExtract(){

        $id = $this->input->post('idExtract');

        $this->db->where('id', $id);
        $query = $this->db->get('extrato');

        if($query->num_rows() > 0){

            $row = $query->row();

            return json_encode(array(
                'status'=>1,
                'descricao'=>$row->descricao,
                'valor'=>$row->valor,
                'tipo_saldo'=>$row->tipo_saldo,
                'categoria'=>$row->categoria,
                'referencia'=>$row->referencia,
                'liberado'=>$row->liberado,
                'data_criacao'=>date('Y-m-d\TH:i:s', strtotime($row->data_criacao))
            ));
        }

        return json_encode(array('status'=>0));
    }

    public function SaveExtract(){

        $id = $this->input->post('idExtract');

        $descricao = $this->input->post('descricao', true);
        $valor = $this->input->post('valor', true);
        $tipo_saldo = $this->input->post('tipo_saldo', true);
        $categoria = $this->input->post('categoria', true);
        $referencia = $this->input->post('referencia', true);
        $liberado = $this->input->post('liberado', true);
        $data_criacao_original = $this->input->post('data_criacao', true);

        $this->db->where('id', $id);
        $query = $this->db->get('extrato');

        if($query->num_rows() > 0){

            $splitDataCriacao = explode('T', $data_criacao_original);
            $data_criacao = InverseDate($splitDataCriacao[0]).' '.$splitDataCriacao[1];

            if($tipo_saldo == 1){
                $color = 'success';
            }else{
                $color = 'danger';
            }

            $this->db->where('id', $id);
            $update = $this->db->update('extrato', array(
                'descricao'=>$descricao,
                'valor'=>$valor,
                'tipo_saldo'=>$tipo_saldo,
                'categoria'=>$categoria,
                'referencia'=>$referencia,
                'liberado'=>$liberado,
                'data_criacao'=>$data_criacao
            ));

            if($update){

                return json_encode(array(
                    'status'=>1,
                    'descricao'=>$descricao,
                    'valor'=>number_format($valor, 2, ',', '.'),
                    'tipo_saldo'=>'<span class="badge badge-'.$color.' badge-pill">'.TipoExtrato($tipo_saldo).'</span>',
                    'categoria'=>CategoriaExtrato($categoria),
                    'referencia'=>$referencia,
                    'liberado'=>$liberado,
                    'data_criacao'=>date('d/m/Y H:i:s', strtotime($data_criacao_original))
                ));
            }

            return json_encode(array(
                'status'=>0,
                'error'=>'Não foi possível fazer atualização. Tente novamente.'
            ));
        }

        return json_encode(array(
            'status'=>0,
            'error'=>'Registro do extrato não encontrado. Atualize a página e tente novamente'
        ));
    }

    public function InfoInvoice(){

        $id = $this->input->post('idFatura');

        $this->db->where('id', $id);
        $query = $this->db->get('faturas');

        if($query->num_rows() > 0){

            $row = $query->row();

            $data_pagamento = (!is_null($row->data_pagamento)) ? date('Y-m-d\TH:i:s', strtotime($row->data_pagamento)) : '';
            $data_primeiro_recebimento = (!is_null($row->data_primeiro_recebimento)) ? date('Y-m-d', strtotime($row->data_primeiro_recebimento)) : '';
            $data_expiracao = (!is_null($row->data_expiracao)) ? date('Y-m-d\TH:i:s', strtotime($row->data_expiracao)) : '';
            $data_ultimo_pagamento = (!is_null($row->data_ultimo_pagamento_feito)) ? date('Y-m-d\TH:i:s', strtotime($row->data_ultimo_pagamento_feito)) : '';

            return json_encode(array(
                'status'=>1,
                'renovacao'=>$row->renovacao,
                'id_plano'=>$row->id_plano,
                'valor'=>$row->valor,
                'dia_util'=>$row->dia_util,
                'percentual_pago'=>$row->percentual_pago,
                'quantidade_pagamentos_fazer'=>$row->quantidade_pagamentos_fazer,
                'quantidade_pagamentos_realizados'=>$row->quantidade_pagamentos_realizados,
                'valor_recebido'=>$row->valor_recebido,
                'valor_liberado'=>$row->valor_liberado,
                'cortesia'=>$row->cortesia,
                'meio_pagamento'=>$row->meio_pagamento,
                'meio_pagamento_detalhes'=>$row->meio_pagamento_detalhes,
                'status'=>$row->status,
                'status_saque_raiz'=>$row->status_saque_raiz,
                'data_criacao'=>date('Y-m-d\TH:i:s', strtotime($row->data_criacao)),
                'data_pagamento'=>$data_pagamento,
                'data_primeiro_recebimento'=>$data_primeiro_recebimento,
                'data_expiracao'=>$data_expiracao,
                'data_ultimo_pagamento_feito'=>$data_ultimo_pagamento
            ));
        }

        return json_encode(array('status'=>0));
    }

    public function SaveInvoice(){

        $id = $this->input->post('idFatura');

        $id_plano = $this->input->post('id_plano', true);
        $valor = $this->input->post('valor', true);
        $final_semana = $this->input->post('final_semana', true);
        $porcentagem = $this->input->post('porcentagem', true);
        $dias_pagos = $this->input->post('dias_pagos', true);
        $dias_totais_pagar = $this->input->post('dias_totais_pagar', true);
        $valor_liberado = $this->input->post('valor_liberado', true);
        $cortesia = $this->input->post('cortesia', true);
        $meio_pagamento = $this->input->post('meio_pagamento', true);
        $meio_pagamento_detalhes = $this->input->post('meio_pagamento_detalhes', true);
        $status = $this->input->post('status', true);
        $status_raiz = $this->input->post('status_raiz', true);
        $data_geracao = $this->input->post('data_geracao', true);
        $data_pagamento = $this->input->post('data_pagamento', true);
        $data_primeiro_recebimento = $this->input->post('data_primeiro_recebimento', true);
        $data_ultimo_pagamento = $this->input->post('data_ultimo_pagamento', true);
        $data_expirado = $this->input->post('data_expirado', true);

        $this->db->where('id', $id);
        $query = $this->db->get('faturas');

        if($query->num_rows() > 0){

            $splitDataGeracao = explode('T', $data_geracao);
            $data_geracao = InverseDate($splitDataGeracao[0]).' '.$splitDataGeracao[1];

            $splitDataPagamento = explode('T', $data_pagamento);
            $data_pagamento = InverseDate($splitDataPagamento[0]).' '.$splitDataPagamento[1];

            $data_primeiro_recebimento = InverseDate($data_primeiro_recebimento);

            if(!empty($data_ultimo_pagamento)){
                $splitDataUltimoPagamento = explode('T', $data_ultimo_pagamento);
                $data_ultimo_pagamento = InverseDate($splitDataUltimoPagamento[0]).' '.$splitDataUltimoPagamento[1];
            }

            if(!empty($data_expirado)){
                $splitDataExpiracao = explode('T', $data_expirado);
                $data_expirado = InverseDate($splitDataExpiracao[0]).' '.$splitDataExpiracao[1];
            }

            if($status == 0){
                $color = 'warning';
                $statusText = 'Pendente';
            }elseif($status == 1){
                $color = 'success';
                $statusText = 'Pago';
            }else{
                $color = 'danger';
                $statusText = 'Expirado';
            }

            $dados = array(
                'id_plano'=>$id_plano,
                'valor'=>$valor,
                'dia_util'=>$final_semana,
                'percentual_pago'=>$porcentagem,
                'quantidade_pagamentos_fazer'=>$dias_totais_pagar,
                'quantidade_pagamentos_realizados'=>$dias_pagos,
                'valor_liberado'=>$valor_liberado,
                'cortesia'=>$cortesia,
                'meio_pagamento'=>$meio_pagamento,
                'meio_pagamento_detalhes'=>$meio_pagamento_detalhes,
                'status'=>$status,
                'status_saque_raiz'=>$status_raiz,
                'data_criacao'=>$data_geracao
            );

            if(!empty($data_pagamento)){
                $dados['data_pagamento'] = $data_pagamento;
                $data_pagamento = date('d/m/Y H:i:s', strtotime($data_pagamento));
            }

            if(!empty($data_primeiro_recebimento)){
                $dados['data_primeiro_recebimento'] = $data_primeiro_recebimento;
                $data_primeiro_recebimento = date('d/m/Y', strtotime($data_primeiro_recebimento));
            }

            if(!empty($data_expirado)){
                $dados['data_expiracao'] = $data_expirado;
                $data_expirado = date('d/m/Y H:i:s', strtotime($data_expirado));
            }

            if(!empty($data_ultimo_pagamento_feito)){
                $dados['data_ultimo_pagamento_feito'] = $data_ultimo_pagamento_feito;
                $data_ultimo_pagamento = date('d/m/Y H:i:s', strtotime($data_ultimo_pagamento));
            }

            if(empty($valor_liberado)){
                $valor_liberado = 0;
            }

            $this->db->where('id', $id);
            $update = $this->db->update('faturas', $dados);

            if($update){

                return json_encode(array(
                    'status'=>1,
                    'plano'=>PlanInfo($id_plano, 'nome'),
                    'valor'=>MOEDA.' '.number_format($valor, 2, ',', '.'),
                    'dia_util'=>(($final_semana == 1) ? 'Sim' : 'Não'),
                    'percentual_pago'=>$porcentagem,
                    'pagamentos'=>($dias_pagos.' / '.$dias_totais_pagar),
                    'valor_liberado'=>MOEDA.' '.number_format($valor_liberado, 2, ',', '.'),
                    'cortesia'=>(($cortesia == 1) ? 'Sim' : 'Não'),
                    'meio_pagamento'=>$meio_pagamento,
                    'meio_pagamento_detalhes'=>$meio_pagamento_detalhes,
                    'status_fatura'=>'<span class="badge badge-'.$color.' badge-pill">'.$statusText.'</span>',
                    'status_raiz'=>(($status_raiz == 1) ? 'Sim' : 'Não'),
                    'data_criacao'=>date('d/m/Y H:i:s', strtotime($data_geracao)),
                    'data_pagamento'=>$data_pagamento,
                    'data_primeiro_recebimento'=>$data_primeiro_recebimento,
                    'data_ultimo_pagamento'=>$data_ultimo_pagamento,
                    'data_expiracao'=>$data_expirado
                ));
            }

            return json_encode(array(
                'status'=>0,
                'error'=>'Não foi possível fazer atualização. Tente novamente.'
            ));
        }

        return json_encode(array(
            'status'=>0,
            'error'=>'Fatura não encontrada no banco de dados. Atualize a página e tente novamente'
        ));
    }

    public function RenovationContract(){

        $pagamento_raiz = SystemInfo('pagamento_raiz');

        $id = $this->input->post('id');

        $this->db->where('id', $id);
        $this->db->where('id_usuario', $this->userid);
        $query = $this->db->get('faturas');

        if($query->num_rows() > 0){

            $row = $query->row();

            if($row->status_saque_raiz == 0){

                if($pagamento_raiz == 0){

                    $this->db->where('id', $id);
                    $this->db->update('faturas', array(
                        'status_saque_raiz'=>2
                    ));

                    $this->db->insert('faturas', array(
                        'id_usuario'=>$this->userid,
                        'renovacao'=>1,
                        'id_plano'=>$row->id_plano,
                        'valor'=>$row->valor,
                        'niveis_indicacao'=>$row->niveis_indicacao,
                        'dia_util'=>$row->dia_util,
                        'percentual_pago'=>$row->percentual_pago,
                        'quantidade_pagamentos_fazer'=>$row->quantidade_pagamentos_fazer,
                        'quantidade_pagamentos_realizados'=>0,
                        'valor_recebido'=>0,
                        'valor_liberado'=>0,
                        'status'=>0,
                        'status_saque_raiz'=>0,
                        'data_criacao'=>date('Y-m-d H:i:s')
                    ));

                    $id_fatura = $this->db->insert_id();

                    $this->SystemModel->AtivarFatura($id_fatura, 'Renovação', 'Renovação feita do plano #'.$id, $row->cortesia);

                    CreateLog($this->userid, 'Usuário fez a renovação do plano #'.$id.'. O ID do novo plano é: #'.$id_fatura);
                    CreateNotification($this->userid, 'Você acabou de fazer a renovação do seu plano #'.$id.'. Agora você continuará ganhando com a nossa empresa!!!');

                    return json_encode(array(
                        'status'=>1
                    ));
                }

                return json_encode(array(
                    'status'=>0,
                    'error'=>$this->lang->line('ajax_renovation_disabled')
                ));
            }

            return json_encode(array(
                'status'=>0,
                'error'=>$this->lang->line('ajax_renovation_raiz_error')
            ));
        }

        return json_encode(array(
            'status'=>0,
            'error'=>$this->lang->line('ajax_renovation_fat_error')
        ));
    }

    public function DeleteCode(){

        $id = $this->input->post('id');

        $this->db->where('id', $id);
        $delete = $this->db->delete('transacoes_bankon');

        if($delete){

            return json_encode(array('status'=>1));
        }

        return json_encode(array('status'=>0));
    }

    public function CreateUserAuthy(){
        
        $adminID = $this->session->userdata('admin_myuserid_92310');
        $id_usuario = $this->input->post('id_usuario');

        $isAdmin = UserInfo('is_admin', $id_usuario);

        if($isAdmin == 0){
            
            return json_encode(array(
                'status'=>0,
                'error'=>'O usuário não é administrador. Para cadastrar o Authy, primeiramente torne o usuário um administrador'
            ));
        }

        $api = new AuthyApi(SystemInfo('authy_token'), 'https://api.authy.com');

        $userEmail = UserInfo('email', $id_usuario);
        $userPhone = str_replace(array('+55', ' ', '.', '-', ')', '('), array('', '', '', '', '', ''), UserInfo('celular', $id_usuario));
        $userCountryCode = 55;
        $user = $api->registerUser($userEmail, $userPhone, $userCountryCode);

        if ($user->ok()) {

            $this->db->where('id', $id_usuario);
            $this->db->update('usuarios_cadastros', array(
                'admin_authy_code'=>$user->id()
            ));

            CreateLog($adminID, 'Cadastrou um token do Authy para o usuário <b>'.UserInfo('login', $id_usuario).'</b>', true);

            return json_encode(array(
                'status'=>1
            ));
            
        } else {

            $errors = '';
            foreach ($user->errors() as $field => $error){
                $errors .= $field.': '.$error.PHP_EOL;
            }

            return json_encode(array(
                'status'=>0,
                'error'=>$errors
            ));
        }
    }

    public function SeeReceiptLog(){

        $adminID = $this->session->userdata('admin_myuserid_92310');
        $comprovanteID = $this->input->post('id', true);
        $login = $this->input->post('login', true);

        CreateLog($adminID, 'Visualizou o comprovante ID #'.$comprovanteID.' do usuário <b>'.$login.'</b>', true);

        return json_encode(array('status'=>1));
    }
}