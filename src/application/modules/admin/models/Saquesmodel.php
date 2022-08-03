<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Mpdf\QrCode\QrCode;
use Mpdf\QrCode\Output;

class Saquesmodel extends CI_Model {

    protected $rotas;

    public function __construct(){
        parent::__construct();

        $this->rotas = MinhasRotas();

        $this->userid = $this->session->userdata('admin_myuserid_92310');

        $this->load->library('pix');
    }

    public function SaidasTotais(){

        $this->db->select_sum('valor_receber');
        $this->db->from('saques');
        $this->db->where('status', 1);
        $query = $this->db->get();

        if($query->num_rows() > 0){

            return $query->row()->valor_receber;
        }

        return 0;
    }

    public function SaquesStatus($status = 1){
        
        $this->db->where('status', $status);
        $query = $this->db->get('saques');

        return $query->num_rows();
    }

    public function TodosSaques($status = false, $limit = false){

        $this->db->select('s.*, u.nome, u.login');
        $this->db->from('saques AS s');
        $this->db->join('usuarios_cadastros AS u', 'u.id = s.id_usuario', 'inner');
        $this->db->where('u.data_exclusao IS NULL', null, false);
        $this->db->order_by('s.data_solicitacao', 'DESC');

        if($status !== false){
            $this->db->where('s.status', $status);
        }

        if($limit){
            $this->db->limit($limit);
        }

        $query = $this->db->get();

        if($query->num_rows() > 0){

            return $query->result();
        }

        return false;
    }

    public function SaquesPorPlataformas(){

        $query = $this->db->query("SELECT meio_recebimento, COUNT(*) AS quantidade, (SELECT COUNT(*) as qtd FROM saques) AS total_saques FROM saques GROUP BY meio_recebimento");
        
        if($query->num_rows() > 0){

            return $query->result();
        }

        return false;
    }

    public function InformacaoSaque($id){

        $this->db->where('id', $id);
        $query = $this->db->get('saques');

        if($query->num_rows() > 0){

            return $query->row();
        }

        return false;
    }

    public function ExcluirSaque($id){

        $this->db->where('id', $id);
        $this->db->update('saques', array('data_exclusao'=>date('Y-m-d H:i:s')));
        // $this->db->delete('saques');

        CreateLog($this->userid, 'Excluiu o saque ID #'.$id, true);

        $this->session->set_flashdata('saques_message', alerts('Saque excluído com sucesso!', 'success'));

        redirect($this->rotas->admin_saques_todos);
    }

    public function DarBaixa($id){

        $this->db->where('id', $id);
        $this->db->update('saques', array('status'=>1));

        $this->db->select('u.email, u.celular, s.valor_receber, s.id_usuario');
        $this->db->from('saques AS s');
        $this->db->join('usuarios_cadastros AS u', 'u.id = s.id_usuario', 'inner');
        $this->db->where('s.id', $id);
        $query = $this->db->get();

        $row = $query->row();

        $message = $this->load->view('emails/saque_pago', array(
            'id'=>$id,
            'valor'=>$row->valor_receber
        ), TRUE);

        EnviarEmail($row->email, 'Sua solicitação de saque foi PAGA!', $message);

        CreateLog($this->userid, 'Deu baixa no saque ID #'.$id, true);

        CreateRegisterBox(null, 'Pagamento do saque #'.$id.' do usuário <b>'.UserInfo('login', $row->id_usuario).'</b>', 2, $row->valor_receber);

        EnviarSMS($row->celular, '['.NOME_SITE.'] Seu saque ID #'.$id.' no valor de '.MOEDA.' '.number_format($row->valor_receber, 2, ',', '.').' foi pago com sucesso. Em alguns instantes já estará em sua conta.', 'saque_pago');

        $this->session->set_flashdata('saques_message', alerts('Baixa no saque dada com sucesso!', 'success'));

        redirect($this->rotas->admin_saques_todos);
    }

    public function EstornarSaque($id){

        $motivo = $this->input->get('motivo');
        $motivo = urldecode($motivo);

        $this->db->where('id', $id);
        $query = $this->db->get('saques');

        if($query->num_rows() > 0){

            $row = $query->row();

            $referencia_faturas = json_decode($row->referencia_faturas, true);

            if($row->tipo_saque == 1){

                if(!empty($referencia_faturas)){

                    foreach($referencia_faturas as $id_fatura=>$valor){

                        $this->db->where('id', $id_fatura);
                        $queryFatura = $this->db->get('faturas');

                        if($query->num_rows() > 0){

                            $rowFatura = $queryFatura->row();

                            $novoValorLiberado = $rowFatura->valor_liberado + $valor;

                            $this->db->where('id', $id_fatura);
                            $this->db->update('faturas', array('valor_liberado'=>$novoValorLiberado));
                        }
                    }

                    $this->session->set_flashdata('saques_message', alerts('Saque estornado com sucesso!', 'success'));

                }else{
                    $this->session->set_flashdata('saques_message', alerts('Não é possível realizar o estorno desse saque pois as faturas atraladas a esse saque não estão sendo localizadas. Entre em contato com o programador e informe o ID desse saque.', 'danger'));
                }
            }else{
                $this->session->set_flashdata('saques_message', alerts('Saque estornado com sucesso!', 'success'));
            }

            /* Caso for saque de raiz */
            if($row->tipo_saque == 3){
                if(!empty($referencia_faturas)){

                    foreach($referencia_faturas as $id_fatura=>$valor){

                        $this->db->where('id', $id_fatura);
                        $this->db->update('faturas', array(
                            'status_saque_raiz'=>0
                        ));
                    }
                }
            }else{

                /* Só grava no extrato se não for raiz */
                RegisterExtractItem($row->id_usuario, 'Estorno do saque ID #'.$id, $row->valor_solicitado, $row->tipo_saque, 1);
            }

            /* Ações padrões de estorno */

            $this->db->select('u.email, u.celular, s.valor_receber');
            $this->db->from('saques AS s');
            $this->db->join('usuarios_cadastros AS u', 'u.id = s.id_usuario', 'inner');
            $this->db->where('s.id', $id);
            $query = $this->db->get();

            $rowSendEmail = $query->row();

            $message = $this->load->view('emails/saque_estornado', array(
                'id'=>$id,
                'valor'=>$rowSendEmail->valor_receber,
                'motivo'=>$motivo
            ), TRUE);

            EnviarEmail($rowSendEmail->email, 'Sua solicitação de saque foi ESTORNADA :(', $message);

            $this->db->where('id', $id);
            $this->db->update('saques', array('status'=>2));

            CreateLog($this->userid, 'Estornou o valor de '.MOEDA.' '.number_format($row->valor_solicitado, 2, ',', '.').' referente ao saque ID #'.$id.'.Motivo: '.$motivo, true);
            CreateLog($row->id, 'Recebeu o estorno do saque ID #'.$id.'.Motivo: '.$motivo);

            CreateNotification($row->id_usuario, 'Seu saque ID #'.$id.' foi estornado para sua conta. Motivo: '.$motivo);

            EnviarSMS($rowSendEmail->celular, '['.NOME_SITE.'] Seu saque ID #'.$id.' no valor de '.MOEDA.' '.number_format($row->valor_receber, 2, ',', '.').' foi estornado. Veja o motivo em suas notificações.', 'saque_estornado');

        }else{

            $this->session->set_flashdata('saques_message', alerts('O saque que você está tentando dar baixa não existe mais no banco de dados.', 'danger'));
        }

        redirect($this->rotas->admin_saques_todos);
    }

    public function GerarQRCodePix($id){

        $saque = $this->InformacaoSaque($id);

        if($saque !== false){

            if($saque->meio_recebimento == 5){

                $account = json_decode($saque->conta_recebimento);

                $pix = $this->pix->setMerchantName(NOME_SITE)
                            ->setMerchantCity('BRASIL')
                            ->setTxid('PAG. DO SAQUE #'.$id)
                            ->setAmount($saque->valor_receber)
                            ->setPixKey($account->pix);
            
                $infoCode = $pix->getCode();

                $newQRCode = new QrCode($infoCode);
                $imageQRCode = (new Output\Png)->output($newQRCode, 250);

                return base64_encode($imageQRCode);
            }

            return false;
        }

        return false;
    }
}