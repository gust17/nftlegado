<?php
class Webhooks extends CI_Model{

    public function __construct(){

        parent::__construct();

        $this->load->library('coinpayments');
    }

    public function ActiveAccountCoinPayments(){

        if($this->input->post('merchant') && $this->input->post('merchant') == SystemInfo('coinpayments_merchant')){
    
            $id_transaction = $this->input->post('txn_id');
            $criptomoeda = $this->input->post('currency2');
            $status = $this->input->post('status');
    
            $this->db->where('id_transacao', $id_transaction);
            $query = $this->db->get('transacoes_criptomoedas');
    
            if($query->num_rows() > 0){
    
                $rowCoinpayments = $query->row();
    
                if($rowCoinpayments->currency2 == $criptomoeda){
    
                    if($status >= 100 || $status == 2){
    
                        $active = $this->SystemModel->AtivarFatura($rowCoinpayments->id_fatura, $criptomoeda, 'Pagamento recebido via coinpayments');

                        if($active){

                            $this->db->where('id_transacao', $id_transaction);
                            $this->db->update('transacoes_criptomoedas', array(
                                'status'=>1,
                                'data_atualizacao'=>date('Y-m-d H:i:s')
                            ));

                            CreateLog($rowCoinpayments->id_usuario, 'Ativou a fatura ID #'.$rowCoinpayments->id_fatura.' com '.$criptomoeda.' via CoinPayments');
                        }
                    }
                }
            }
        }
        
    }

    public function ActiveAccountAsaas(){
        
        $headers = $this->input->request_headers();

        $input = file_get_contents('php://input');
        $data = json_decode($input);

        $status = array(
            'PAYMENT_CREATED'=>0,
            'PAYMENT_RECEIVED'=>1,
            'PAYMENT_OVERDUE'=>2,
            'PAYMENT_CHARGEBACK_REQUESTED'=>3,
            'PAYMENT_CHARGEBACK_DISPUTE'=>4,
            'PAYMENT_AWAITING_CHARGEBACK_REVERSAL'=>5
        );

        $idBilling = $data->payment->id;

        if($data->event == 'PAYMENT_RECEIVED'){

            $this->db->where('id_boleto', $idBilling);
            $query = $this->db->get('transacoes_asaas');

            if($query->num_rows() > 0){

                $row = $query->row();

                $this->db->where('id_boleto', $idBilling);
                $this->db->update('transacoes_asaas', array(
                    'status'=>$status['PAYMENT_RECEIVED'],
                    'data_atualizacao'=>date('Y-m-d H:i:s')
                ));
                
                $this->db->where('id', $row->id_fatura);
                $this->db->where('status', 0);
                $queryInvoice = $this->db->get('faturas');
                
                if($queryInvoice->num_rows() > 0){
                    
                    $this->db->where('id_fatura', $row->id_fatura);
                    $this->db->update('faturas_comprovantes', array(
                        'ativado'=>1,
                        'data_ativacao'=>date('Y-m-d H:i:s')
                    ));

                    $this->SystemModel->AtivarFatura($row->id_fatura, 'BOLETO BANCÁRIO', 'Pagamento via boleto bancário Asaas');
                    
                    return 'Fatura Ativada';
                }
            }
            
        }else{

            if(isset($status[$data->event])){

                $this->db->where('id_boleto', $idBilling);
                $this->db->update('transacoes_asaas', array(
                    'status'=>$status[$data->event],
                    'data_atualizacao'=>date('Y-m-d H:i:s')
                ));
            }

            return $data->event;
        }
    }
}