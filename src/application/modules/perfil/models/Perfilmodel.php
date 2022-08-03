<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Perfilmodel extends CI_Model {

    public function __construct(){
        parent::__construct();

        $this->userid = $this->session->userdata('myuserid');

        $this->load->library('upload');
    }

    public function MeusDadosPessoais(){

        $this->db->where('id', $this->userid);
        $query = $this->db->get('usuarios_cadastros');

        return $query->row();
    }

    public function AtualizarDadosPessoais(){

        $this->load->library('rediscache');

        $config['upload_path'] = 'uploads';
        $config['allowed_types'] = 'jpg|jpeg|png|gif';
        $config['encrypt_name'] = true;

        $nome = $this->input->post('nome', true);
        $nascimento = $this->input->post('nascimento', true);
        $celular = $this->input->post('celular', true);
        $cep = $this->input->post('cep', true);
        $sexo = $this->input->post('sexo', true);
        $endereco = $this->input->post('endereco', true);
        $bairro = $this->input->post('bairro', true);
        $cidade = $this->input->post('cidade', true);
        $estado = $this->input->post('estado', true);

        $arrayDados = array(
            'nome'=>$nome,
            'celular'=>$celular,
            'sexo'=>$sexo,
            'cep'=>$cep,
            'endereco'=>$endereco,
            'bairro'=>$bairro,
            'cidade'=>$cidade,
            'estado'=>$estado,
            'data_atualizacao'=>date('Y-m-d H:i:s')
        );

        if(isset($_FILES['avatar']['tmp_name']) && !empty($_FILES['avatar']['tmp_name'])){

            $this->upload->initialize($config);

            if($this->upload->do_upload('avatar')){

                $dataUpload = $this->upload->data();

                $login = UserInfo('login');
                $result = UploadS3($login.'/avatar/'.$dataUpload['file_name'], $config['upload_path'].'/'.$dataUpload['file_name'], 'nftcash-comprovantes-novo');

                $arrayDados['avatar'] = $result['ObjectURL'];

                @unlink($config['upload_path'].'/'.$dataUpload['file_name']);
            }

            return alerts(sprintf($this->lang->line('perf_m_erro_upload_foto'), $this->upload->display_errors()), 'danger');
        }

        if(!empty($nascimento)){
            $arrayDados['data_nascimento'] = InverseDate($nascimento);
        }

        $this->db->where('id', $this->userid);
        $update = $this->db->update('usuarios_cadastros', $arrayDados);

        if($update){

            $this->rediscache->select('0');
            $this->rediscache->del('UserInfo_'.$this->userid);

            CreateLog($this->userid, 'O usuário atualizou os dados pessoais.');

            return alerts($this->lang->line('perf_m_dados_atualizados_ok'), 'success');
        }

        return alerts($this->lang->line('perf_m_dados_atualizados_error'), 'danger');
    }

    public function AtualizarSenha(){

        $senha_atual = $this->input->post('senha_atual');
        $senha_nova = $this->input->post('senha_nova');
        $senha_confirmar = $this->input->post('senha_confirmar');
        
        $senhaBancoDados = UserInfo('senha');

        if(password_verify($senha_atual, $senhaBancoDados)){

            if($senha_nova == $senha_confirmar){

                $this->db->where('id', $this->userid);
                $this->db->update('usuarios_cadastros', array(
                    'senha'=>password_hash($senha_nova, PASSWORD_DEFAULT)
                ));

                CreateLog($this->userid, 'O usuário atualizou a senha dele com sucesso!');

                return alerts($this->lang->line('perf_m_senha_alterada_ok'), 'success');
            }

            return alerts($this->lang->line('perf_m_senha_novas_incompativeis'), 'danger');
        }

        return alerts($this->lang->line('perf_m_senha_antigas_incompativeis'), 'danger');
    }
}
