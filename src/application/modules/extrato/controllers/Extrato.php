<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Extrato extends MY_Controller {

    public function __construct(){
        parent::__construct();
        isLogged();
        CheckSystemMaintenance();

        $this->load->model('extratomodel', 'ExtratoModel');
    }

	public function index(){

        CheckInitializeRoutes(__FUNCTION__, __CLASS__);

        $data['nome_pagina'] = $this->lang->line('ext_geral_titulo');

        $data['cssLoader'] = array(
            'assets/cliente/default/assets/css/plugins/dataTables.bootstrap4.min.css'
        );

        $data['jsLoader'] = array(
            'assets/plugins/datatables/jquery.dataTables.min.js',
            'assets/plugins/datatables/dataTables.bootstrap4.min.js',
            'assets/plugins/datatables/config-datatables.js'
        );

        $data['transacoes'] = $this->ExtratoModel->MeuExtrato(null);

		$this->template->load('cliente/template', 'extrato', $data);
    }
    
    public function rendimentos(){

        CheckInitializeRoutes(__FUNCTION__, __CLASS__);

        $data['nome_pagina'] = $this->lang->line('ext_rendimentos_titulo');

        $data['cssLoader'] = array(
            'assets/cliente/default/assets/css/plugins/dataTables.bootstrap4.min.css'
        );

        $data['jsLoader'] = array(
            'assets/plugins/datatables/jquery.dataTables.min.js',
            'assets/plugins/datatables/dataTables.bootstrap4.min.js',
            'assets/plugins/datatables/config-datatables.js'
        );

        $data['transacoes'] = $this->ExtratoModel->MeuExtrato(1);

		$this->template->load('cliente/template', 'extrato', $data);
    }
    
    public function rede(){

        CheckInitializeRoutes(__FUNCTION__, __CLASS__);

        $data['nome_pagina'] = $this->lang->line('ext_rede_titulo');

        $data['cssLoader'] = array(
            'assets/cliente/default/assets/css/plugins/dataTables.bootstrap4.min.css'
        );

        $data['jsLoader'] = array(
            'assets/plugins/datatables/jquery.dataTables.min.js',
            'assets/plugins/datatables/dataTables.bootstrap4.min.js',
            'assets/plugins/datatables/config-datatables.js'
        );

        $data['transacoes'] = $this->ExtratoModel->MeuExtrato(2);

		$this->template->load('cliente/template', 'extrato', $data);
	}
}
