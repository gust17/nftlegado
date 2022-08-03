<?php
function CheckSystemMaintenance(){
    
    $_this =& get_instance();

    if(SystemInfo('manutencao') == 1){

        $id_user = $_this->session->userdata('myuserid');

        $contas_liberadas = SystemInfo('contas_liberadas');


        if(!in_array($id_user, json_decode($contas_liberadas, true))){

            show_error('Manutenção', 'Site em manutenção', 'error_manutencao', 503);
        }
    }
}
function CheckAcessServer($controller, $function = ''){

    $_this =& get_instance();

    $ipServer = SystemInfo('ip_servidor');

    if($ipServer == $_this->input->ip_address()){
        return true;
    }

    if($controller == 'cron'){

        CreateLogSystem(
            'O CRON tentou executar mas ocorreu erro decorrente a autorização do IP. IP do servidor cadastrado: '.$ipServer.' - IP de execução: '.$_this->input->ip_address()
        );
        
        return exit('O CRON só pode ser executado internamente pelo servidor.');

    }elseif($controller == 'ajax'){

        $is_ajax = 'xmlhttprequest' == strtolower( $_SERVER['HTTP_X_REQUESTED_WITH'] ?? '' );

        if(!$is_ajax){

            CreateLogSystem(
                'Não foi possível realizar a chamada AJAX da função '.$function.' pois o IP do servidor de acesso é diferente do permitido. IP do servidor cadastrado: '.$ipServer.' - IP de execução: '.$_this->input->ip_address()
            );
            
            return exit('O AJAX só pode ser solicitado internamente pelo servidor.');

        }
    }
}

function SystemInfo($column){

    $config = [];

    $_this =& get_instance();

    $_this->load->library('rediscache');

    $_this->rediscache->select('0');

    $exists = $_this->rediscache->exists('SystemInfo');

    if($exists){

        $config = json_decode($_this->rediscache->get('SystemInfo'), true);

        if(isset($config[$column])){

            return $config[$column];
        }
    }

    $_this->db->limit(1);
    $_this->db->order_by('id', 'ASC');
    $query = $_this->db->get('configuracoes_sistema');

    $row = $query->row();

    $config[$column] = $row->$column;

    $_this->rediscache->set('SystemInfo', json_encode($config));

    return $row->$column;
}

function GenerateCode($size = 15){
    $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuwxyz0123456789";
    $randomString = '';
    for($i = 0; $i < $size; $i = $i+1){
        $randomString .= $chars[mt_rand(0,60)];
    }
    return $randomString;
}

function InvoiceInfo($id, $column){

    $_this =& get_instance();

    $_this->db->where('id', $id);
    $query = $_this->db->get('faturas');

    if($query->num_rows() > 0){

        return $query->row()->$column;
    }

    return false;
}

function PlanInfo($id, $column){

    $_this =& get_instance();

    $_this->db->where('id', $id);
    $query = $_this->db->get('planos');

    if($query->num_rows() > 0){

        return $query->row()->$column;
    }

    return false;
}

function RegisterExtractItem($id_user, $descricao, $valor, $tipo_saldo, $categoria, $referencia = null, $date = null){

    if(is_null($date)){
        $date = date('Y-m-d H:i:s');
    }

    $_this =& get_instance();

    $dadosExtrato = array(
        'id_usuario'=>$id_user,
        'descricao'=>$descricao,
        'valor'=>$valor,
        'tipo_saldo'=>$tipo_saldo,
        'categoria'=>$categoria,
        'referencia'=>$referencia,
        'data_criacao'=>$date
    );

    $_this->db->insert('extrato', $dadosExtrato);

    $idExtratoCriado = $_this->db->insert_id();

    $_this->SystemModel->AddItemExtractCache($id_user, $idExtratoCriado);

    return $idExtratoCriado;
}