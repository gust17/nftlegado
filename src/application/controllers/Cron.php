<?php
class Cron extends MY_Controller{

    public function __construct(){
        parent::__construct();

        // CheckAcessServer('cron');

        $this->load->model('cronmodel', 'Cron');
    }

    public function pay_bonification(){

        echo $this->Cron->payBonification();
    }

    public function change_profile(){

        echo $this->Cron->changeProfile();
    }

    public function check_pix(){

        echo $this->Cron->CheckPix();
    }

    public function clear_redis(){

        $this->load->library('rediscache');
        $this->rediscache->flushall();
    }
}