<!DOCTYPE html>
<html lang="en">

<head>

	<title><?php echo $this->lang->line('criar_cadastro');?> - <?php echo NOME_SITE;?></title>
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

<!-- [ signin-img ] start -->
<div class="auth-wrapper align-items-stretch aut-bg-img" style="background:url(<?php echo base_url();?>assets/BACKGROUND-Lcadastro.jpg) no-repeat;">
	<div class="flex-grow-1">
		<div class="h-100 d-md-flex align-items-end auth-side-img">
			<div class="col-sm-10 auth-content w-auto">
				<img src="<?php echo base_url(LOGO_DESKTOP);?>" alt="" class="img-fluid">
				<h1 class="text-white my-4"><?php echo $this->lang->line('c_bem_vindo_investidor');?></h1>
				<h4 class="text-white font-weight-normal"><?php echo $this->lang->line('c_descricao_cadastro');?></h4>
			</div>
		</div>
		<div class="auth-side-form">
			<div class=" auth-content">
                <form action="" method="post">
                    <img src="<?php echo base_url();?>assets/cliente/default/assets/images/auth/auth-logo-dark.svg" alt="" class="img-fluid mb-4 d-block d-xl-none d-lg-none">
                    <h4 class="mb-3 f-w-400"><?php echo $this->lang->line('c_cadastrarme');?></h4>
                    
                    <?php if(isset($message)) echo $message; ?>

                    <div class="input-group mb-3">
                        <input type="text" class="form-control" name="patrocinador" value="<?php echo $this->lang->line('c_f_patrocinador');?>: <?php echo $patrocinador['nome'];?>" readonly>
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i data-feather="file-text"></i></span>
                        </div>
                        <select name="tipo_cadastro" class="form-control">
                            <?php
                            foreach(TiposCadastro() as $nTipo=>$tipo){
                            ?>
                            <option value="<?php echo $nTipo;?>"><?php echo $tipo;?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i data-feather="smile"></i></span>
                        </div>
                        <input type="text" class="form-control" name="nome" placeholder="<?php echo $this->lang->line('c_f_nome');?>" required>
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i data-feather="mail"></i></span>
                        </div>
                        <input type="email" class="form-control" name="email" placeholder="<?php echo $this->lang->line('c_f_email');?>" required>
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i data-feather="phone"></i></span>
                        </div>
                        <input type="text" class="form-control" name="celular" placeholder="<?php echo $this->lang->line('c_f_celular');?>" required>
                    </div>
                    
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i data-feather="file-text"></i></span>
                        </div>
                        <input type="text" class="form-control" name="documento" placeholder="<?php echo $this->lang->line('c_f_documento');?>" required>
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i data-feather="file-text"></i></span>
                        </div>
                        <select name="sexo" class="form-control" required>
                            <option value="1" selected><?php echo $this->lang->line('c_f_s_masculino');?></option>
                            <option value="2"><?php echo $this->lang->line('c_f_s_feminino');?></option>
                            <option value="3"><?php echo $this->lang->line('c_f_s_nao_informar');?></option>
                        </select>
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i data-feather="user"></i></span>
                        </div>
                        <input type="text" class="form-control" name="login" placeholder="<?php echo $this->lang->line('c_f_login');?>" required>
                    </div>
                    <div class="input-group mb-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i data-feather="lock"></i></span>
                        </div>
                        <input type="password" class="form-control" name="senha" placeholder="<?php echo $this->lang->line('c_f_senha');?>" required>
                    </div>
                    <div class="input-group mb-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i data-feather="lock"></i></span>
                        </div>
                        <input type="password" class="form-control" name="senha_confirmar" placeholder="<?php echo $this->lang->line('c_f_senha_confirmar');?>">
                    </div>
                    <button type="submit" name="submit" value="Cadastrar-me" class="btn btn-primary btn-block mb-4 btn-escuro"><?php echo $this->lang->line('c_button_cadastrar');?></button>
                    <div class="text-center">
                        <div class="saprator my-4"><span><?php echo $this->lang->line('c_f_ou');?></span></div>
                        <p class="mt-4"><?php echo $this->lang->line('c_tem_cadastro');?> <a href="<?php echo base_url($rotas->login);?>" class="f-w-400"><?php echo $this->lang->line('c_acesse_conta');?></a></p>
                    </div>

                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                </form>
			</div>
		</div>
	</div>
</div>
<!-- [ signin-img ] end -->

<!-- Required Js -->
<script src="<?php echo base_url();?>assets/cliente/default/assets/js/vendor-all.min.js"></script>
<script src="<?php echo base_url();?>assets/cliente/default/assets/js/plugins/bootstrap.min.js"></script>
<script src="<?php echo base_url();?>assets/cliente/default/assets/js/plugins/feather.min.js"></script>
<script src="<?php echo base_url();?>assets/cliente/default/assets/js/pcoded.min.js"></script>
<script src="<?php echo base_url();?>assets/plugins/maskedinput/jquery.maskedinput.min.js"></script>
<script>
$(document).ready(function(){

    $(document).on('change', '[name="tipo_cadastro"]', function(){

        let tipo_cadastro = $('[name="tipo_cadastro"] option:selected').val();

        if(tipo_cadastro == 1){
            $('[name="documento"]').mask('999.999.999-99');
            $('[name="celular"]').mask('+55 (99) 9.9999-9999');
        }else{
            $('[name="documento"]').unmask();
            $('[name="celular"]').unmask();
        }
    });

    $('[name="celular"]').mask('+55 (99) 9.9999-9999');
    $('[name="documento"]').mask('999.999.999-99');
    $('[name="login"]').keyup(function() {
        $(this).val(this.value.replace(/[^a-zA-Z0-9]+/g, ''));
    });
});
</script>

</body>

</html>
