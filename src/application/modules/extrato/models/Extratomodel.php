<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Extratomodel extends CI_Model {

    public function __construct(){
        parent::__construct();

        $this->userid = $this->session->userdata('myuserid');
    }

    public function ultimasMovimentacoes($quantidade){

        $this->db->limit($quantidade);
        $this->db->order_by('data_criacao', 'DESC');
        $this->db->where('id_usuario', $this->userid);
        $query = $this->db->get('extrato');

        if($query->num_rows() > 0){
            
            return $query->result();
        }

        return false;
    }

    public function MeuExtrato($categoria = null){

        $this->load->library('rediscache');

        $this->rediscache->select('0');

        // $exists = $this->rediscache->exists('Extrato_'.$this->userid);

        $exists = false;

        if($exists){

            // $extracts = $this->rediscache->get('Extrato_'.$this->userid);
            // $extracts = json_decode($extracts, true);

            // if(!is_null($categoria)){

            //     $extracts = array_filter($extracts, function ($extract) use ($categoria) {

            //         return (isset($extract['categoria']) && $extract['categoria'] == $categoria);
            //     });
            // }

            // return json_decode(json_encode($extracts), false);

        }else{

            if(!is_null($categoria)){
                $this->db->where('categoria', $categoria);
            }
            $this->db->where('id_usuario', $this->userid);
            $this->db->order_by('id', 'DESC');
            $query = $this->db->get('extrato');
    
            if($query->num_rows() > 0){
                
                // $this->rediscache->set('Extrato_'.$this->userid, json_encode($query->result()));

                return $query->result();
            }
    
            return false;
        }
    }
}
