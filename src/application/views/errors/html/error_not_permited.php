
<!doctype html>
<html lang="en">

    <head>
        
        <meta charset="utf-8" />
        <title>Acesso não permitido - <?php echo NOME_SITE;?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!-- Bootstrap Css -->
        <link href="<?php echo base_url();?>assets/admin/assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="<?php echo base_url();?>assets/admin/assets/css/icons.min.css" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="<?php echo base_url();?>assets/admin/assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />

    </head>

    <body class="authentication-bg">

        <div class="my-5 pt-sm-5">
            <div class="container">

                <div class="row">
                    <div class="col-md-12">
                        <div class="text-center">
                            <div>
                                <div class="row justify-content-center">
                                    <div class="col-sm-4">
                                        <div class="error-img">
                                            <img src="<?php echo base_url();?>assets/admin/assets/images/404-error.png" alt="" class="img-fluid mx-auto d-block">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <h4 class="text-uppercase mt-4">Acesso não permitido!</h4>
                            <p class="text-muted">Você não tem permissão suficiente para acessar essa página. Para acessar você precisa utilizar a <b>MasterKey</b>.</p>
                            <div class="mt-5">
                                <a class="btn btn-primary waves-effect waves-light" href="<?php echo base_url(MinhasRotas('SPEC', 'admin_dashboard'));?>">Voltar para o admin</a>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>

        <!-- JAVASCRIPT -->
        <script src="<?php echo base_url();?>assets/admin/assets/libs/jquery/jquery.min.js"></script>
        <script src="<?php echo base_url();?>assets/admin/assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="<?php echo base_url();?>assets/admin/assets/libs/metismenu/metisMenu.min.js"></script>
        <script src="<?php echo base_url();?>assets/admin/assets/libs/simplebar/simplebar.min.js"></script>
        <script src="<?php echo base_url();?>assets/admin/assets/libs/node-waves/waves.min.js"></script>
        <script src="<?php echo base_url();?>assets/admin/assets/libs/waypoints/lib/jquery.waypoints.min.js"></script>
        <script src="<?php echo base_url();?>assets/admin/assets/libs/jquery.counterup/jquery.counterup.min.js"></script>

        <script src="<?php echo base_url();?>assets/admin/assets/js/app.js"></script>

    </body>
</html>
