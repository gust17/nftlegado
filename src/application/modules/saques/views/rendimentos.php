<div class="pcoded-content">
    
    <?php if(isset($message)) echo $message; ?>
    
    <?php
    $i = 0;
    if(UserInfo('saque_liberado') == 1 && SystemInfo('saque_liberado') == 1){
        if($quantidadeDiasRendidos > 0){
    ?>
    <div class="row">
        <div class="col-md-12">
            <div class="card prod-p-card bg-success">
                <div class="card-body">
                    <div class="row align-items-center m-b-25">
                        <div class="col">
                            <h6 class="m-b-5 text-white"><?php echo $this->lang->line('saq_valor_liberado');?></h6>
                            <h3 class="m-b-0 text-white"><?php echo MOEDA;?> <?php echo number_format($saldo_disponivel, 2, ',', '.');?></h3>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign text-white"></i>
                        </div>
                    </div>
                    <p class="m-b-0 text-white"><?php echo $this->lang->line('saq_valor_liberado_desc');?></p>
                </div>
            </div>
        </div>
    </div>
    
    <?php
    if(!$pagamentosTotais){
        echo alerts('<h3 class="text-center">Atenção!</h3><br /><p>Esse plano ainda não recebeu os rendimentos completos, caso você saque agora só poderá sacar os valores rendidos até o momento e após isso o seu plano voltará a render a partir do 1 dia.</p>', 'warning');
    }
    ?>

    <div class="card">
        <div class="card-header">
            <h5><?php echo $this->lang->line('saq_selecione_valor');?></h5>
        </div>
        <div class="card-body table-border-style">
            <form action="" method="post">
                <div class="row">
                    <div class="col-md-3 col-sm-12">
                        <ul class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                            <?php
                            if(!empty($bankon) && $bankon != '{}' && (isset($meio_disponivel['bankon']) && $meio_disponivel['bankon'] == true)){
                            ?>
                            <li><a class="nav-link text-left select_account" id="v-pills-bankon-tab" data-toggle="pill" href="#v-pills-bankon" role="tab" aria-controls="v-pills-bankon" aria-selected="true" data-account="1"><?php echo $this->lang->line('saq_tipo_bankon');?></a></li>
                            <?php
                                $i++;
                            }
                            ?>

                             <?php
                            if(!empty($newpay) && $newpay != '{}' && (isset($meio_disponivel['newpay']) && $meio_disponivel['newpay'] == true)){
                            ?>
                            <li><a class="nav-link text-left select_account" id="v-pills-newpay-tab" data-toggle="pill" href="#v-pills-newpay" role="tab" aria-controls="v-pills-newpay" aria-selected="false" data-account="2"><?php echo $this->lang->line('saq_tipo_newpay');?></a></li>
                            <?php
                                $i++;
                            }
                            ?>

                            <?php
                            if(!empty($conta_bancaria) && $conta_bancaria != '{}' && (isset($meio_disponivel['conta_bancaria']) && $meio_disponivel['conta_bancaria'] == true)){
                            ?>
                            <li><a class="nav-link text-left select_account" id="v-pills-conta_bancaria-tab" data-toggle="pill" href="#v-pills-conta_bancaria" role="tab" aria-controls="v-pills-conta_bancaria" aria-selected="false" data-account="3"><?php echo $this->lang->line('saq_tipo_conta_bancaria');?></a></li>
                            <?php
                                $i++;
                            }
                            ?>

                            <?php
                            if(!empty($carteira_bitcoin) && $carteira_bitcoin != '{}' && (isset($meio_disponivel['carteira_bitcoin']) && $meio_disponivel['carteira_bitcoin'] == true)){
                            ?>
                            <li><a class="nav-link text-left select_account" id="v-pills-carteira_bitcoin-tab" data-toggle="pill" href="#v-pills-carteira_bitcoin" role="tab" aria-controls="v-pills-carteira_bitcoin" aria-selected="false" data-account="4"><?php echo $this->lang->line('saq_tipo_carteira_bitcoin');?></a></li>
                            <?php
                                $i++;
                            }
                            ?>

                            <?php
                            if(!empty($pix) && $pix != '{}' && (isset($meio_disponivel['pix']) && $meio_disponivel['pix'] == true)){
                            ?>
                            <li><a class="nav-link text-left select_account" id="v-pills-pix-tab" data-toggle="pill" href="#v-pills-pix" role="tab" aria-controls="v-pills-pix" aria-selected="false" data-account="5"><?php echo $this->lang->line('saq_tipo_pix');?></a></li>
                            <?php
                                $i++;
                            }
                            ?>

                            <?php
                            if(!empty($simplepay) && $simplepay != '{}' && (isset($meio_disponivel['simplepay']) && $meio_disponivel['simplepay'] == true)){
                            ?>
                            <li><a class="nav-link text-left select_account" id="v-pills-simplepay-tab" data-toggle="pill" href="#v-pills-simplepay" role="tab" aria-controls="v-pills-simplepay" aria-selected="false" data-account="6"><?php echo $this->lang->line('saq_tipo_simplepay');?></a></li>
                            <?php
                                $i++;
                            }
                            ?>
                        </ul>
                    </div>
                    <div class="col-md-9 col-sm-12">
                        <div class="tab-content" id="v-pills-tabContent">
                            <?php
                            if(!empty($bankon) && $bankon != '{}' && (isset($meio_disponivel['bankon']) && $meio_disponivel['bankon'] == true)){
                            ?>
                            <div class="tab-pane fade" id="v-pills-bankon" role="tabpanel" aria-labelledby="v-pills-bankon-tab">

                                <?php echo alerts($this->lang->line('saq_aviso_antes_solicitar'), 'info');?>

                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <tr>
                                            <td><strong><?php echo $this->lang->line('saq_form_bankon');?></strong></td>
                                            <td>
                                            <?php
                                            $bankonArray = json_decode($bankon, true);
                                            echo $bankonArray['bankon'];
                                            ?>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <?php
                            }
                            ?>

                            <?php
                            if(!empty($newpay) && $newpay != '{}' && (isset($meio_disponivel['newpay']) && $meio_disponivel['newpay'] == true)){
                            ?>
                            <div class="tab-pane fade" id="v-pills-newpay" role="tabpanel" aria-labelledby="v-pills-newpay-tab">
                                <?php echo alerts($this->lang->line('saq_aviso_antes_solicitar'), 'info');?>

                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <tr>
                                            <td><strong><?php echo $this->lang->line('saq_form_newpay');?></strong></td>
                                            <td>
                                            <?php
                                            $newpayArray = json_decode($newpay, true);
                                            echo $newpayArray['newpay'];
                                            ?>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <?php
                            }
                            ?>

                            <?php
                            if(!empty($conta_bancaria) && $conta_bancaria != '{}' && (isset($meio_disponivel['conta_bancaria']) && $meio_disponivel['conta_bancaria'] == true)){

                                $bancoArray = json_decode($conta_bancaria, true);
                            ?>
                            <div class="tab-pane fade" id="v-pills-conta_bancaria" role="tabpanel" aria-labelledby="v-pills-conta_bancaria-tab">
                                <?php echo alerts($this->lang->line('saq_aviso_antes_solicitar'), 'info');?>

                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <tr>
                                            <td><strong><?php echo $this->lang->line('saq_form_banco');?></strong></td>
                                            <td>
                                            <?php
                                            echo BancoID($bancoArray['banco']);
                                            ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong><?php echo $this->lang->line('saq_form_agencia');?></strong></td>
                                            <td>
                                            <?php
                                            echo $bancoArray['agencia'];
                                            ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong><?php echo $this->lang->line('saq_form_conta');?></strong></td>
                                            <td>
                                            <?php
                                            echo $bancoArray['conta'];
                                            ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong><?php echo $this->lang->line('saq_form_tipo_conta');?></strong></td>
                                            <td>
                                            <?php
                                            echo ($bancoArray['tipo'] == 1) ? $this->lang->line('saq_form_tipo_conta_corrente') : $this->lang->line('saq_form_tipo_conta_poupanca');
                                            ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong><?php echo $this->lang->line('saq_form_titular');?></strong></td>
                                            <td>
                                            <?php
                                            echo $bancoArray['titular'];
                                            ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong><?php echo $this->lang->line('saq_form_documento');?></strong></td>
                                            <td>
                                            <?php
                                            echo $bancoArray['documento'];
                                            ?>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <?php
                            }
                            ?>

                            <?php
                            if(!empty($carteira_bitcoin) && $carteira_bitcoin != '{}' && (isset($meio_disponivel['carteira_bitcoin']) && $meio_disponivel['carteira_bitcoin'] == true)){
                            ?>
                            <div class="tab-pane fade" id="v-pills-carteira_bitcoin" role="tabpanel" aria-labelledby="v-pills-carteira_bitcoin-tab">
                                <?php echo alerts($this->lang->line('saq_aviso_antes_solicitar'), 'info');?>

                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <tr>
                                            <td><strong><?php echo $this->lang->line('saq_form_carteira_bitcoin');?></strong></td>
                                            <td>
                                            <?php
                                            $carteiraBTCArray = json_decode($carteira_bitcoin, true);
                                            echo $carteiraBTCArray['carteira_bitcoin'];
                                            ?>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <?php
                            }
                            ?>

                            <?php
                            if(!empty($pix) && $pix != '{}' && (isset($meio_disponivel['pix']) && $meio_disponivel['pix'] == true)){
                            ?>
                            <div class="tab-pane fade" id="v-pills-pix" role="tabpanel" aria-labelledby="v-pills-pix-tab">
                                <?php echo alerts($this->lang->line('saq_aviso_antes_solicitar'), 'info');?>

                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <tr>
                                            <td><strong><?php echo $this->lang->line('saq_form_pix');?></strong></td>
                                            <td>
                                            <?php
                                            $pixArray = json_decode($pix, true);
                                            echo $pixArray['pix'];
                                            ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong><?php echo $this->lang->line('saq_form_pix_conta');?></strong></td>
                                            <td>
                                            <?php
                                            $pixArray = json_decode($pix, true);
                                            echo BancoID($pixArray['banco']);
                                            ?>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <?php
                            }
                            ?>

                            <?php
                            if(!empty($simplepay) && $simplepay != '{}' && (isset($meio_disponivel['simplepay']) && $meio_disponivel['simplepay'] == true)){
                            ?>
                            <div class="tab-pane fade" id="v-pills-simplepay" role="tabpanel" aria-labelledby="v-pills-simplepay-tab">
                                <?php echo alerts($this->lang->line('saq_aviso_antes_solicitar'), 'info');?>

                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <tr>
                                            <td><strong><?php echo $this->lang->line('saq_form_simplepay');?></strong></td>
                                            <td>
                                            <?php
                                            $simplepayArray = json_decode($simplepay, true);
                                            echo $simplepayArray['simplepay'];
                                            ?>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <?php
                            }
                            ?>

                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-12">
                        <?php
                        if($i > 0){
                        ?>
                        <?php echo $this->recaptcha->getWidget();?>
                        <button type="submit" name="submit" value="Solicitar" class="btn btn-success btn-block text-uppercase" load-button="on" load-text="<?php echo $this->lang->line('saq_solicitar_saque_andamento_button');?>" disabled><?php echo $this->lang->line('saq_solicitar_saque_button');?></button>
                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                        <input type="hidden" name="conta" value="0" />
                        <?php
                        }else{
                            echo alerts('Cadastre ao menos uma conta para realizar seu saque.', 'danger');
                        }
                        ?>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <?php
        }else{
            if(!isset($message)){
                echo alerts('Você não pode sacar nada referente a esse plano pois ele ainda não rendeu nada.', 'danger');
            }
        }
    }else{
        echo alerts($this->lang->line('saq_conta_nao_habilitada'), 'danger');
    }
    ?>
</div>

<?php echo $this->recaptcha->getScriptTag();?>