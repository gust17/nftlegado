<!DOCTYPE html>
<html lang="en">

<head>

	<title><?php echo $this->lang->line('login_titulo');?> - <?php echo NOME_SITE;?></title>
	<!-- HTML5 Shim and Respond.js IE11 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 11]>
		<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
		<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
		<![endif]-->
	<!-- Meta -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />

	<!-- font css -->
	<link rel="stylesheet" href="<?php echo base_url();?>assets/cliente/default/assets/fonts/font-awsome-pro/css/pro.min.css">
	<link rel="stylesheet" href="<?php echo base_url();?>assets/cliente/default/assets/fonts/feather.css">
	<link rel="stylesheet" href="<?php echo base_url();?>assets/cliente/default/assets/fonts/fontawesome.css">

	<!-- vendor css -->
	<link rel="stylesheet" href="<?php echo base_url();?>assets/cliente/default/assets/css/style.css">
	<link rel="stylesheet" href="<?php echo base_url();?>assets/cliente/default/assets/css/customizer.css">

    <?php echo SystemInfo('google_analytics');?>
</head>

<!-- [ auth-signup ] start -->
<div class="auth-wrapper auth-v3" style="background-image:url(<?php echo base_url();?>assets/bg-login.jpg);background-size:cover;">
	<div class="auth-content">
        <div class="card">
            <div class="row align-items-stretch text-center">
                <div class="col-md-6" style="display: flex !important; justify-content:center !important; align-items:center !important">

                    <div style="">
                        <div class="" style="display: flex !important; justify-content:center !important; align-items:center !important">
                            <!-- <img src="<?php echo base_url(LOGO_DESKTOP);?>" alt="" class="img-fluid"> -->
                            <img src="<?php echo base_url();?>assets/NFTCASH-BRANCO.png" alt="" class="img-fluid p-4 m-4">
                        </div>
                        <div class="text-center" style="display: flex !important; justify-content:center !important; align-items:center !important">
                            <!-- <h4 class="mb-3 text-white f-w-600"><?php echo sprintf($this->lang->line('login_bemvindo'), NOME_SITE);?></h4> -->
                            <p class="text-white text-center mb-4"><?php echo $this->lang->line('login_inst');?></p>
                        </div>
                    </div>

                </div>
				<div class="col-md-6">
					<div class="card-body">
                        <form action="<?php echo base_url($rotas->login.$redirect);?>" method="post">                            
                            <?php if(isset($message)) echo $message; ?>

                            <div class="">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i data-feather="user"></i></span>
                                    </div>
                                    <input type="text" name="login" class="form-control" placeholder="<?php echo $this->lang->line('login_login_informe');?>" required>
                                </div>
                                <div class="input-group mb-4">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i data-feather="lock"></i></span>
                                    </div>
                                    <input type="password" name="senha" class="form-control" placeholder="<?php echo $this->lang->line('login_senha_informe');?>" required>
                                </div>
                                <div class="form-group text-left my-2">
                                    <div class="float-right">
                                        <a href="<?php echo base_url($rotas->recuperar_senha);?>" class="text-primary"><span><?php echo $this->lang->line('login_esqueceu_senha');?></span></a>
                                    </div>
                                </div>
                            </div>
                            <br />
                            <br />

                            <?php echo $this->recaptcha->getWidget();?>

                            <div class="text-right">
                                <button type="submit" name="submit" value="Fazer Login" class="btn btn-primary mt-2 btn-block"><?php echo $this->lang->line('login_fazer_login_button');?></button>
                                <a href="<?php echo base_url($rotas->cadastro);?>" class="btn btn-light-primary mt-2 btn-block"><?php echo $this->lang->line('login_criar_cadastro_button');?></a>
                            </div>

                            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                        </form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- [ auth-signup ] end -->

<!-- Required Js -->
<script src="<?php echo base_url();?>assets/cliente/default/assets/js/vendor-all.min.js"></script>
<script src="<?php echo base_url();?>assets/cliente/default/assets/js/plugins/bootstrap.min.js"></script>
<script src="<?php echo base_url();?>assets/cliente/default/assets/js/plugins/feather.min.js"></script>
<script src="<?php echo base_url();?>assets/cliente/default/assets/js/pcoded.min.js"></script>
<?php echo $this->recaptcha->getScriptTag();?>

</body>

</html>
