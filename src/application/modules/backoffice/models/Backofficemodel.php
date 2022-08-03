<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Backofficemodel extends CI_Model {

    public function __construct(){
        parent::__construct();

        $this->userid = $this->session->userdata('myuserid');
    }

    public function Logout(){

        $rotas = MinhasRotas();

        $this->session->unset_userdata('myuserid');
        
        redirect($rotas->login);
    }
}
