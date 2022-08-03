<?php

use Mpdf\QrCode\QrCode;
use Mpdf\QrCode\Output;
use Authy\AuthyApi;
use Twilio\Rest\Client;

class Tests extends MY_Controller{

    public function __construct(){
        parent::__construct();
    }

    public function lista_usrs(){

        $this->db->select('u.*');
        $this->db->from('usuarios_cadastros AS u');
        $this->db->where('u.is_admin', 0);
        $query = $this->db->get();

        if($query->num_rows() > 0){

            foreach($query->result() as $result){

                echo $result->id.','.$result->nome.','.$result->email.','.$result->celular.'<br />';
            }
        }
    }

    public function lista_ativos(){

        $this->db->select('u.*, f.valor');
        $this->db->from('faturas AS f');
        $this->db->join('usuarios_cadastros AS u', 'u.id = f.id_usuario', 'inner');
        $this->db->where('f.status', 1);
        $this->db->where('u.is_admin', 0);
        $query = $this->db->get();

        if($query->num_rows() > 0){

            foreach($query->result() as $result){

                echo $result->id.','.$result->nome.','.$result->email.','.$result->celular.','.$result->valor.'<br />';
            }
        }
    }

    public function redis(){

        print_r($this->rediscache->get('sessao')).'<br />';


        echo '<hr />';

        echo '<pre>';

        print_r($this->rediscache->info());

        // echo 'REDIS <hr />';

        // $this->load->driver('cache', array('adapter' => 'redis', 'backup' => 'file'));

        //     $cached = $this->cache->rediscache->get('key');
        //     if($cached != null){
        //         echo 'COM CACHE! <br />';
        //         echo $cached;
        //     }
        //     else{
        //         echo 'SEM CACHE - GRAVANDO...';
        //         $this->cache->rediscache->save('key', 'Some Value', 60);
        //     }
    }

    public function telegram(){

        $this->load->library('telegram');

        print_r($this->telegram->sendMessage('Mensagem enviada via API Codeigniter'));
    }

    public function dias(){

        echo InverseDate('02/01/1971');
    }

    public function twilio_sms(){

        $sid    = ""; 
        $token  = ""; 
        $twilio = new Client($sid, $token); 
        
        $message = $twilio->messages 
                        ->create("+5511947772188", // to 
                                array(  
                                    "messagingServiceSid" => "MG4ac560e4f4d526d1594958e5c0c58d0d",      
                                    "body" => "testeee" 
                                ) 
                        ); 
        
        print($message->sid);
    }

    public function generate_qrcode_authenticator($id){

        $secretFactory = new \Dolondro\GoogleAuthenticator\SecretFactory();
        $secret = $secretFactory->create(NOME_SITE, UserInfo('login', $id));
        $secretKey = $secret->getSecretKey();

        $qrImageGenerator = new \Dolondro\GoogleAuthenticator\QrImageGenerator\EndroidQrImageGenerator();
        $url = $qrImageGenerator->generateUri($secret);

        $this->db->where('id', $id);
        $this->db->update('usuarios_cadastros', array('admin_authenticator_code'=>$secretKey));

        echo '<p>';
        echo 'Token gerado com sucesso. Escaneie o QRCode abaixo para finalizar a configuração: <br />';
        echo '<img src="'.$url.'" />';
    }

    public function emaillayout($layout){

        $this->load->view('emails/'.$layout, array(
            'id'=>'329',
            'valor'=>831.93
        ));
    }

    public function pix(){

        $this->load->library('pix');

        $request = [
            'calendario'=>[
                'expiracao'=>3600
            ],
            'devedor'=>[
                'cpf'=>'123',
                'nome'=>'Alisson Acioli'
            ],
            'valor'=>[
                'original'=>'10.00'
            ],
            'chave'=>'123',
            'solicitacao'=>'Pagamento Fatura 123'
        ];

        $createCharge = $this->pix->createCharge('ABC12032WJFAL00000000000001', $request);

        $pixMount = $this->pix->setMerchantName('Bruno Ferreira')
                         ->setMerchantCity('SAO PAULO')
                         ->setTxid($createCharge['txid'])
                         ->setAmount($createCharge['valor']['original'])
                         ->setUrlDynamicPayload($createCharge['location'])
                         ->setUniquePayment(true);
        
        $infoCode = $pixMount->getCode();

        $newQRCode = new QrCode($infoCode);
        $imageQRCode = (new Output\Png)->output($newQRCode, 300);

        // header('Content-type: image/png');

        echo '<img src="data:image/png;base64, '.base64_encode($imageQRCode).'" />';

        // echo $imageQRCode;
    }

    public function authy_signup(){

        $api = new AuthyApi(SystemInfo('authy_token'), 'https://api.authy.com');

        $userEmail = '';
        $userPhone = '';
        $userCountryCode = 55;
        $user = $api->registerUser($userEmail, $userPhone, $userCountryCode);

        if ($user->ok()) {
            echo 'Authy ID for user "'.$userEmail.'": '.$user->id()."\n";
        } else {
            foreach ($user->errors() as $field => $error){
                echo 'Error on '.$field.': '.$error;
            }
        }
    }
}