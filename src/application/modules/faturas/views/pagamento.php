<div class="pcoded-content">
    <div class="card">
        <div class="card-header">
            <h5><?php echo $nome_pagina;?></h5>
        </div>
        <div class="card-body table-border-style">

            <?php
            if($fatura !== false){
            ?>

            <?php
            if(isset($message)) echo $message;
            ?>

            <?php
            if($contas !== false){
                foreach($contas as $conta){
            ?>
            <a class="btn btn-primary m-t-5" data-toggle="collapse" href="#banco_<?php echo $conta->banco;?>" role="button" aria-expanded="false" aria-controls="banco_<?php echo $conta->banco;?>"><?php echo BancoID($conta->banco);?></a>
            <?php
                }
            }
            ?>

            <?php
            if($pixHabilitado == 1){
            ?>
            <a class="btn btn-primary m-t-5" data-toggle="collapse" href="#pix" role="button" aria-expanded="false" aria-controls="pix"><?php echo $this->lang->line('fat_pagamento_pix');?></a>
            <?php
            }
            ?>
            
            <?php
            if(!empty($cryptosDB) && $coinpaymentsHabilitado == 1){
                foreach($cryptosDB as $cryptoValue=>$cryptoName){
            ?>
            <a class="btn btn-primary m-t-5" data-toggle="collapse" href="#<?php echo $cryptoValue;?>" role="button" aria-expanded="false" aria-controls="<?php echo $cryptoName?>"><?php echo $cryptoName?></a>
            <?php
                }
            }
            ?>

            <?php
            if($asaasHabilitado == 1){
            ?>
            <a class="btn btn-primary m-t-5" data-toggle="collapse" href="#boleto" role="button" aria-expanded="false" aria-controls="Boleto"><?php echo $this->lang->line('fat_pagamento_boleto');?></a>
            <?php
            }
            ?>

            <?php
            if($bankonHabilitado == 1){
            ?>
            <a class="btn btn-primary m-t-5" data-toggle="collapse" href="#bankOn" role="button" aria-expanded="false" aria-controls="bankOn"><?php echo $this->lang->line('fat_pagamento_bankon');?></a>
            <?php
            }
            ?>


            <?php
            if($contas !== false){
                foreach($contas as $conta){
                    
                    $centavos = substr($fatura->id, -2);
                    $centavos = (strlen($centavos) >= 2) ? $centavos : '0'.$centavos;
                    $centavos = $centavos/100;
                    
                    $valorPagar = $fatura->valor + $centavos;
            ?>
            <div class="collapse" id="banco_<?php echo $conta->banco;?>">
                <div class="card-body">
                    <form action="" method="post" enctype="multipart/form-data">

                        <h2><?php echo sprintf($this->lang->line('fat_pagamento_via_conta_bancaria'), BancoID($conta->banco));?></h2>

                        <?php echo sprintf($this->lang->line('fat_pagamento_via_conta_bancaria_desc_1'), BancoID($conta->banco));?>
                        <?php echo sprintf($this->lang->line('fat_pagamento_via_conta_bancaria_desc_2'), MOEDA.' '.number_format($valorPagar, 2, ',', '.'));?>
                        <?php echo $this->lang->line('fat_pagamento_via_conta_bancaria_desc_3'); ?>

                        <div class="table-responsive dt-responsive">
                            <table class="table table-striped table-bordered">
                                <tr>
                                    <td class="font-weight-bold"><?php echo $this->lang->line('fat_pagamento_via_conta_bancaria_banco');?></td>
                                    <td><?php echo BancoID($conta->banco);?></td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold"><?php echo $this->lang->line('fat_pagamento_via_conta_bancaria_agencia');?></td>
                                    <td><?php echo $conta->agencia;?></td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold"><?php echo $this->lang->line('fat_pagamento_via_conta_bancaria_conta');?></td>
                                    <td><?php echo $conta->conta;?></td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold"><?php echo $this->lang->line('fat_pagamento_via_conta_bancaria_tipo');?></td>
                                    <td><?php echo ($conta->conta_tipo == 1) ? $this->lang->line('fat_pagamento_via_conta_bancaria_corrente') : $this->lang->line('fat_pagamento_via_conta_bancaria_poupanca');?></td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold"><?php echo $this->lang->line('fat_pagamento_via_conta_bancaria_titular');?></td>
                                    <td><?php echo $conta->titular;?></td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold"><?php echo $this->lang->line('fat_pagamento_via_conta_bancaria_documento');?></td>
                                    <td><?php echo $conta->documento;?></td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold"><?php echo $this->lang->line('fat_pagamento_via_conta_bancaria_valor_depositar');?></td>
                                    <td><?php echo MOEDA;?> <?php echo number_format($valorPagar, 2, ',', '.');?></td>
                                </tr>
                                </tr>
                            </table>
                            <?php echo $this->lang->line('fat_pagamento_via_conta_bancaria_obs');?>
                        </div>

                        <br />

                        <h3 class="text-center"><?php echo $this->lang->line('fat_pagamento_enviar_comprovante');?></h3>

                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend"><span class="input-group-text"><i data-feather="file"></i></span></div>
                                <input type="file" name="comprovante" class="form-control" required />
                            </div>
                        </div>

                        <?php echo $this->recaptcha->getWidget();?>
                        
                        <button type="submit" name="EnviarComprovante" value="<?php echo BancoID($conta->banco);?>" class="btn btn-success btn-block"><?php echo $this->lang->line('fat_pagamento_enviar_comprovante_button');?></button>
                        <input type="hidden" name="<?php echo $csrf_name;?>" value="<?php echo $csrf_hash;?>" />
                        <input type="hidden" name="banco" value="<?php echo $conta->banco;?>" />
                    </form>
                </div>
            </div>
            <?php
                }
            }
            ?>

            <!-- payment via cryptocurrency -->
            <?php
            if(!empty($cryptosDB) && $coinpaymentsHabilitado == 1){
                foreach($cryptosDB as $cryptoValue=>$cryptoName){
            ?>
            <div class="collapse" id="<?php echo $cryptoValue;?>">
                <div class="card-body">

                    <div class="instrucoes_crypto" data-crypto="<?php echo $cryptoValue;?>">

                        <h2><?php echo sprintf($this->lang->line('fat_pagamento_via_cripto'), $cryptoName);?></h2>

                        <?php $this->lang->line('fat_pagamento_via_cripto_desc_1');?>
                        <?php echo sprintf($this->lang->line('fat_pagamento_via_cripto_desc_2'), $cryptoValue);?>

                        <p>
                            <ol>
                                <li><?php echo sprintf($this->lang->line('fat_pagamento_via_cripto_desc_li_1'), $cryptoName);?></li>
                                <li><?php echo sprintf($this->lang->line('fat_pagamento_via_cripto_desc_li_2'), $cryptoValue);?></li>
                                <li><?php echo $this->lang->line('fat_pagamento_via_cripto_desc_li_3');?></li>
                                <li><?php echo $this->lang->line('fat_pagamento_via_cripto_desc_li_4');?></li>
                            </ol>
                        </p>
                    </div>

                    <div class="table-responsive pagamento_crypto" data-crypto="<?php echo $cryptoValue;?>" style="display:none;">

                        <h3><?php echo $this->lang->line('fat_pagamento_via_cripto_ins_titulo');?></h3>

                        <table class="table table-striped table-bordered">
                            <tr>
                                <td><?php echo $this->lang->line('fat_pagamento_via_cripto_carteira');?></td>
                                <td class="crypto_carteira"></td>
                            </tr>
                            <tr>
                                <td><?php echo $this->lang->line('fat_pagamento_via_cripto_valor_exato');?></td>
                                <td class="crypto_fracao"></td>
                            </tr>
                            <tr>
                                <td><?php echo $this->lang->line('fat_pagamento_via_cripto_via_qrcode');?></td>
                                <td>
                                    <img class="img-thumbnail img-fluid crypto_qrcode" style="width:200px;" />
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2"><?php echo sprintf($this->lang->line('fat_pagamento_via_cripto_desc_obs'), $cryptoValue);?></td>
                            </tr>
                        </table>
                    </div>
                    <button type="button" name="viaCrypto" value="GerarCarteira" data-crypto="<?php echo $cryptoValue;?>" class="btn btn-success text-uppercase btn-block gerarCarteira"><i data-feather="refresh-cw"></i>&nbsp; <?php echo $this->lang->line('fat_pagamento_via_cripto_gerar_button');?></button>
                    <input type="hidden" name="id_plano" value="<?php echo $fatura->id;?>" />
                </div>
            </div>
            <?php
                }
            }
            ?>

            <?php
            if($asaasHabilitado == 1){
            ?>
            
            <!-- payment via boleto -->
            <div class="collapse" id="boleto">
                <div class="card-body">
                    <form action="" method="post">
                        <h2><?php echo $this->lang->line('fat_pagamento_via_boleto');?></h2>

                        <?php echo $this->lang->line('fat_pagamento_via_boleto_desc_1');?>
                        <?php echo $this->lang->line('fat_pagamento_via_boleto_desc_2');?>
                        <?php echo $this->lang->line('fat_pagamento_via_boleto_desc_3');?>
                        

                        <button type="submit" name="GerarBoletoAsaas" value="Gerar" class="btn btn-success btn-block"><i class="fa fa-print"></i> <?php echo $this->lang->line('fat_pagamento_via_boleto_gerar_button');?></button>
                        <input type="hidden" name="<?php echo $csrf_name;?>" value="<?php echo $csrf_hash;?>" />
                    </form>
                </div>
            </div>

            <?php
            }
            ?>

            <?php
            if($bankonHabilitado == 1){
            ?>
            <!-- payment via bankOn -->
            <div class="collapse" id="bankOn">
                <div class="card-body">
                    <form action="" method="post">
                        <h2><?php echo $this->lang->line('fat_pagamento_via_bankon');?></h2>

                        <?php echo $this->lang->line('fat_pagamento_via_bankon_desc_1');?>
                        <?php echo $this->lang->line('fat_pagamento_via_bankon_desc_2');?>
                        
                        <p><h2 class="text-center"><?php echo $this->lang->line('fat_pagamento_via_bankon_bankon');?>: <span class="badge badge-info"><?php echo SystemInfo('conta_bankon');?></span></h2></p>
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend"><span class="input-group-text"><i data-feather="check-circle"></i></span></div>
                                <input type="text" name="codigo_bankon" class="form-control" placeholder="<?php echo $this->lang->line('fat_pagamento_via_bankon_codigo_transacao');?>" />
                            </div>
                        </div>

                        <?php echo $this->recaptcha->getWidget();?>

                        <button type="submit" name="AtivarBankOn" value="Ativar" class="btn btn-success btn-block"><?php echo $this->lang->line('fat_pagamento_via_bankon_ativacao_button');?></button>
                        <input type="hidden" name="<?php echo $csrf_name;?>" value="<?php echo $csrf_hash;?>" />
                    </form>
                </div>
            </div>
            <?php
            }
            ?>

            <?php
            if($simplepayHabilitado == 1){
            ?>
            <!-- payment via SimplePay -->
            <div class="collapse" id="simplepay">
                <div class="card-body">
                    <form action="" method="post">
                        <h2><?php echo $this->lang->line('fat_pagamento_via_simplepay');?></h2>
                        
                        <?php echo $this->lang->line('fat_pagamento_via_simplepay_desc_1');?>
                        <?php echo $this->lang->line('fat_pagamento_via_simplepay_desc_2');?>

                        <p><h2 class="text-center"><?php echo $this->lang->line('fat_pagamento_via_simplepay_simplepay');?>: <span class="badge badge-info"><?php echo SystemInfo('conta_simplepay');?></span></h2></p>
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend"><span class="input-group-text"><i data-feather="check-circle"></i></span></div>
                                <input type="text" name="codigo_simplepay" class="form-control" placeholder="<?php echo $this->lang->line('fat_pagamento_via_simplepay_codigo_transacao');?>" />
                            </div>
                        </div>

                        <?php echo $this->recaptcha->getWidget();?>

                        <button type="submit" name="AtivarSimplepay" value="Ativar" class="btn btn-success btn-block"><?php echo $this->lang->line('fat_pagamento_via_simplepay_ativacao_button');?></button>
                        <input type="hidden" name="<?php echo $csrf_name;?>" value="<?php echo $csrf_hash;?>" />
                    </form>
                </div>
            </div>
            <?php
            }
            ?>

            <?php
            if($pixHabilitado == 1){
            ?>
            <!-- payment via pix -->
            <div class="collapse" id="pix">
                <div class="card-body">
                    <form action="" method="post" enctype="multipart/form-data">
                        <h2><?php echo $this->lang->line('fat_pagamento_via_pix');?></h2>

                        <?php echo $this->lang->line('fat_pagamento_via_pix_desc_1');?>
                        
                        <div align="center">
                            <?php
                            if($qrcode !== false){

                                //echo '<img src="data:image/png;base64, '.$qrcode.'" /> <br />';
                            ?>
                            <h2>
                            <strong><?php echo $this->lang->line('fat_pagamento_via_pix_chave');?>:</strong> <?php echo SystemInfo('chave_pix');?>
                            </h2>
                        </div>

                        <hr />

                        <h3 class="text-center"><?php echo $this->lang->line('fat_pagamento_enviar_comprovante');?></h3>

                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend"><span class="input-group-text"><i data-feather="file"></i></span></div>
                                <input type="file" name="comprovante" class="form-control" required />
                            </div>
                        </div>

                        <?php echo $this->recaptcha->getWidget();?>

                        <button type="submit" name="AtivarPix" value="Ativar" class="btn btn-success btn-block"><?php echo $this->lang->line('fat_pagamento_enviar_comprovante_button');?></button>
                        <input type="hidden" name="<?php echo $csrf_name;?>" value="<?php echo $csrf_hash;?>" />
                        <input type="hidden" name="banco" value="pix" />
                        <?php
                        }else{
                            echo alerts($this->lang->line('fat_pagamento_via_pix_qrcode_error'), 'danger');
                        }
                        ?>
                    </form>
                </div>
            </div>
            <?php
            }
            ?>
            <?php
            }else{
                echo alerts($this->lang->line('fat_pagamento_error_visualizar_fatura'), 'danger');
            }
            ?>
        </div>
    </div>
</div>
<?php echo $this->recaptcha->getScriptTag();?>