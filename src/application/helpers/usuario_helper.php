<?php
function isLogged(){

    $_this =& get_instance();

    $rotas = MinhasRotas();

    $link = uri_string();

    if(!$_this->session->userdata('myuserid')){

        redirect($rotas->login.'?redirect=/'.$link);
        exit;
    }
}

function isLoggedAdmin(){

    $_this =& get_instance();

    $rotas = MinhasRotas();

    $link = uri_string();

    if(!$_this->session->userdata('admin_myuserid_92310')){
        redirect($rotas->admin_login);
        exit;
    }
}

function EnabledMasterKey($show_error = false){

    $_this =& get_instance();
    
    $mk = $_this->session->userdata('mkey_accept_login_admin');

    if($mk === true){
        return true;
    }else{
        if(!$show_error){
            return false;
        }

        show_error('Acesso não permitido', 403, 'error_not_permited');
        exit;
    }
}

function UserInfo($column = 'id', $id = null){

    $configList = [];

    $_this =& get_instance();

    $_this->load->library('rediscache');

    if(!is_null($id)){
        $id = $id;
    }else{
        $id = $_this->session->userdata('myuserid');
    }

    $_this->rediscache->select('0');
    
    $exists = $_this->rediscache->exists('UserInfo_'.$id);
    
    if($exists){

        $configList = json_decode($_this->rediscache->get('UserInfo_'.$id), true);

        if(isset($configList[$column])){

            return $configList[$column];

        }
    }

    $_this->db->where('id', $id);
    $query = $_this->db->get('usuarios_cadastros');

    if($query->num_rows() > 0){

        $row = $query->row();

        $configList[$column] = $row->$column;

        $_this->rediscache->set('UserInfo_'.$id, json_encode($configList));

        return $row->$column;
    }

    return false;
}

function PerfilUsuario($id){

    $_this =& get_instance();

    $perfis = array(
        1=>$_this->lang->line('perfil_investidor'),
        2=>$_this->lang->line('perfil_lider')
    );

    return $perfis[$id];
}

function AvatarLoad($id_usuario = false){

    $_this =& get_instance();

    if(!$id_usuario){
        $id_usuario = $_this->session->userdata('myuserid');
    }

    $avatar = UserInfo('avatar', $id_usuario);
    $sexo = UserInfo('sexo', $id_usuario);

    if(is_null($avatar) || empty($avatar)){

        if($sexo == 1){
            $icon = 1;
        }elseif($sexo == 2){
            $icon = 2;
        }else{
            $icon = 3;
        }

        $avatar = base_url('assets/pages/img/avatar-'.$icon.'.png');
    }

    return $avatar;
}

function validaCPF($cpf) {
 
    // Extrai somente os n���meros
    $cpf = preg_replace( '/[^0-9]/is', '', $cpf );
     
    // Verifica se foi informado todos os digitos corretamente
    if (strlen($cpf) != 11) {
        return false;
    }

    // Verifica se foi informada uma sequ���ncia de digitos repetidos. Ex: 111.111.111-11
    if (preg_match('/(\d)\1{10}/', $cpf)) {
        return false;
    }

    // Faz o calculo para validar o CPF
    for ($t = 9; $t < 11; $t++) {
        for ($d = 0, $c = 0; $c < $t; $c++) {
            $d += $cpf[$c] * (($t + 1) - $c);
        }
        $d = ((10 * $d) % 11) % 10;
        if ($cpf[$c] != $d) {
            return false;
        }
    }
    return true;

}