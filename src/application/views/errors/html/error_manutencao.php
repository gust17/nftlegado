<!DOCTYPE html>
<html lang="en">
<head>
    <title>Backoffice em manutenção - <?php echo NOME_SITE;?></title>
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
<!-- [ offline-ui ] start -->
<div class="auth-wrapper maintance">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="text-center">
                    <img src="<?php echo base_url();?>assets/cliente/default/assets/images/maintance/maintance.png" alt="" class="img-fluid">
                    <h5 class="text-muted my-4">Nosso Backoffice se encontra em manutenção no momento. Em breve estaremos de volta! <br /> Para mais informações, fique atento nos grupos.</h5>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- [ offline-ui ] end -->
<!-- Required Js -->
<script src="<?php echo base_url();?>assets/cliente/default/assets/js/vendor-all.min.js"></script>
<script src="<?php echo base_url();?>assets/cliente/default/assets/js/plugins/bootstrap.min.js"></script>

</body>
</html>
