<!DOCTYPE html>
<html lang="en">

<head>

	<title><?php echo $this->lang->line('recuperar_titulo');?> - <?php echo NOME_SITE;?></title>
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


</head>

<!-- [ auth-signup ] start -->
<div class="auth-wrapper auth-v3">
	<div class="auth-content">
		<div class="card">
			<div class="row align-items-stretch text-center">
				<div class="col-md-6 img-card-side">
					<img src="<?php echo base_url();?>assets/cliente/default/assets/images/auth/auth-side1.jpg" alt="" class="img-fluid">
					<div class="img-card-side-content">
						<img src="<?php echo base_url(LOGO_DESKTOP);?>" alt="" class="img-fluid">
					</div>
				</div>
				<div class="col-md-6">
					<div class="card-body">
                        <form action="" method="post">
                            <div class="text-left">
                                <h4 class="mb-3 f-w-600"><?php echo $this->lang->line('recuperar_trocar_senha');?></h4>
                                <p class="text-muted mb-4"><?php echo $this->lang->line('recuperar_informe_nova_senha_inst');?></p>
                            </div>
                            
                            <?php if(isset($message)) echo $message; ?>

                            <?php
                            if(isset($checkCode)){

                                if($checkCode['success'] == 1){
                            ?>

                            <div class="">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i data-feather="lock"></i></span>
                                    </div>
                                    <input type="password" name="senha" class="form-control" placeholder="<?php echo $this->lang->line('recuperar_nova_senha');?>">
                                </div>
                            </div>

                            <div class="">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i data-feather="lock"></i></span>
                                    </div>
                                    <input type="password" name="senha_confirmar" class="form-control" placeholder="<?php echo $this->lang->line('recuperar_confirmar_nova_senha');?>">
                                </div>
                            </div>
                            <br />

                            <div class="text-right">
                                <button type="submit" name="submit" value="Recuperar Senha" class="btn btn-primary mt-2 btn-block"><?php echo $this->lang->line('recuperar_trocar_senha_button');?></button>
                            </div>

                            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                            <?php
                                }else{
                                    echo $checkCode['error'];
                                }
                            }
                            ?>
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

</body>

</html>
