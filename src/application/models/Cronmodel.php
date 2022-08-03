<?php
class Cronmodel extends CI_Model{

    public function __construct(){

        parent::__construct();

        $this->load->library('pix');
    }

    public function payBonification(){

        $pagamentoRaiz = SystemInfo('pagamento_raiz');

        $payments = 0;

        $isBusinessDay = (date('w') != 6 && date('w') != 0) ? true : false;

        $this->db->select('f.*, u.celular, p.nome AS nome_plano');
        $this->db->from('faturas AS f');
        $this->db->join('usuarios_cadastros AS u', 'u.id = f.id_usuario', 'inner');
        $this->db->join('planos AS p', 'p.id = f.id_plano', 'inner');
        $this->db->where('f.quantidade_pagamentos_realizados < ', 'f.quantidade_pagamentos_fazer', false);
        $this->db->where('f.data_primeiro_recebimento <= ', date('Y-m-d'));
        $this->db->where('f.status', 1);
        $query = $this->db->get();

        if($query->num_rows() > 0){

            foreach($query->result() as $row){

                /* Verifica se a fatura foi marcada para pagamento somente em dia útil */

                if($row->dia_util == 1){
                    if(!$isBusinessDay){
                        break;
                    }
                }
                
                $this->db->select_sum('valor');
                $this->db->from('extrato');
                $this->db->where('referencia', $row->ciclo.'_fatura_'.$row->id);
                $this->db->where('tipo_saldo', 1);
                $this->db->where('categoria', 1);
                $this->db->where('id_usuario', $row->id_usuario);
                $queryExtractPaysPercent = $this->db->get();
                
                $totalPagoMomento = $queryExtractPaysPercent->row()->valor;
                
                $porcentagensPlano = json_decode($row->percentual_pago, true);
                $ultimoDiaPagamento = $row->quantidade_pagamentos_realizados;
                
                $proximoPagamento = $ultimoDiaPagamento+1;
                
                $totalPagamentoHoje = $porcentagensPlano[$proximoPagamento];

                /* Faz o pagamento dos rendimentos diários */

                $percentPayPerDay = $totalPagamentoHoje/100;

                if($pagamentoRaiz == 1){
                    $percentPayPerDay += (100/100); //100% referente ao plano raiz
                }
                
                $valuePay = ($row->valor * $percentPayPerDay) - $totalPagoMomento;

                $newValueReleased = $row->valor_liberado;

                if($row->cortesia == 0){
                    $newValueReleased = $newValueReleased + $valuePay;
                }
                $newValueReceived = $row->valor_recebido + $valuePay;
                $newQuantityPayments = $row->quantidade_pagamentos_realizados + 1;

                $record = RegisterExtractItem(
                    $row->id_usuario,
                    'Bonificação diária referente a plano <b>'.$row->nome_plano.'</b> ('.$totalPagamentoHoje.'%)',
                    $valuePay,
                    1,
                    1,
                    $row->ciclo.'_fatura_'.$row->id
                );

                if($record > 0){

                    $this->db->where('id', $row->id);
                    $this->db->update('faturas', array(
                        'quantidade_pagamentos_realizados'=>$newQuantityPayments,
                        'valor_liberado'=>$newValueReleased,
                        'valor_recebido'=>$newValueReceived,
                        'data_ultimo_pagamento_feito'=>date('Y-m-d H:i:s')
                    ));

                    EnviarSMS($row->celular, '['.NOME_SITE.'] Você recebeu '.MOEDA.' '.number_format($valuePay, 2, ',', '.').' do rendimento do seu plano', 'recebimento_rendimento');
                }

                /* Caso foi o último pagamento, ele expira o plano */

                if($row->quantidade_pagamentos_fazer == $newQuantityPayments){

                    $this->db->where('id', $row->id);
                    $this->db->update('faturas', array(
                        'status'=>2,
                        'valor_liberado'=>($newValueReleased),
                        'data_expiracao'=>date('Y-m-d H:i:s')
                    ));

                    CreateNotification($row->id_usuario, 'Ahhh, que pena! Seu plano #'.$row->id.' acabou de expirar. Continue ganhando com a '.NOME_SITE.', faça um novo aporte agora mesmo!');
                    CreateLog($row->id_usuario, 'O plano #'.$row->id.' acabou de expirar.');
                    EnviarSMS($row->celular, '['.NOME_SITE.'] Seu plano ID #'.$row->id.' acabou de expirar. Faça a renovação para continuar ganhando!', 'plano_finalizado');
                }

                $payments++;
            }

            return json_encode(array(
                'status'=>1,
                'message'=>'Cron acabou de finalizar os pagamentos. Houve o pagamento de '.$payments.' faturas.'
            ));
        }

        return json_encode(array(
            'status'=>0,
            'message'=>'Não existe faturas a serem pagas.'
        ));
    }

    public function changeProfile(){

        $quantity = 0;

        $this->db->where('perfil', 1);
        $query = $this->db->get('usuarios_cadastros');

        if($query->num_rows() > 0){

            foreach($query->result() as $row){

                $this->db->select('COUNT(*) AS quantidade');
                $this->db->from('rede AS r');
                $this->db->join('usuarios_cadastros AS u', 'u.id = r.id_usuario', 'inner');
                $this->db->where('r.id_patrocinador_direto', $row->id);
                $this->db->where('u.plano_ativo', 1);
                $queryNetwork = $this->db->get();

                if($queryNetwork->num_rows() > 0){

                    $rowNetwork = $queryNetwork->row();

                    if($rowNetwork->quantidade >= 2){

                        $this->db->where('id', $row->id);
                        $this->db->update('usuarios_cadastros', array(
                            'perfil'=>2
                        ));

                        $quantity++;
                    }
                }
            }

            return json_encode(array(
                'status'=>1,
                'message'=>'Atualização realizada com sucesso. Houve a atualização de '.$quantity.' perfils.'
            ));
        }
    }

    public function CheckPix(){

        $this->db->where('status', 0);
        $query = $this->db->get('transacoes_pix');

        if($query->num_rows() > 0){

            foreach($query->result() as $result){

                $totalPaid = 0;

                $request = $this->pix->consultCharge($result->txid);

                if(isset($request['status']) && $request['status'] == 'CONCLUIDA'){

                    if(isset($request['pix'])){

                        foreach($request['pix'] as $data){

                            $totalPaid += $data['valor'];
                        }
                    }

                    if($totalPaid >= $result->valor){

                        $this->db->where('id', $result->id);
                        $this->db->update('transacoes_pix', array('status'=>1));

                        $this->SystemModel->AtivarFatura($result->id_fatura, 'Pix', 'Pagamento via Pix Recebido automaticamente');
                    }
                }
            }
        }
    }
}