<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css"> 
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.dataTables.min.css"> 
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">

                <h4 class="card-title">Visão Geral - <?php echo $nome_pagina;?></h4>
                <p class="card-title-desc">Encontre abaixo uma tabela com a <?php echo $nome_pagina;?></p>
                <h1>Tabela Teste</h1>
                <div>
                
                    <?php if($this->session->flashdata('usuarios_message')) echo $this->session->flashdata('usuarios_message'); ?>
                
                    <div class="table-responsive">
                        <?php
                        if($usuarios !== false){
                        ?>
                        
                        <table id="mytable" class="table table-striped simpletable">
                            <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Login</th>
                                <th>Celular</th>
                                <th>Documento</th>
                                <th>Último Login</th>
                                <th>Ação</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            foreach($usuarios as $usuario){

                                $rotaUsuarioVisualizar = str_replace(array('(:num)', '(:any)'), array($usuario->id, $usuario->id), $rotas->admin_usuarios_visualizar);
                                $rotaUsuarioBackoffice = str_replace(array('(:num)', '(:any)'), array($usuario->id, $usuario->id), $rotas->admin_usuarios_backoffice);
                                $rotaUsuarioEditar = str_replace(array('(:num)', '(:any)'), array($usuario->id, $usuario->id), $rotas->admin_usuarios_editar);
                                $rotaUsuarioExcluir = str_replace(array('(:num)', '(:any)'), array($usuario->id, $usuario->id), $rotas->admin_usuarios_excluir);
                                
                            ?>
                            <tr>
                                <th><?php echo $usuario->nome;?></th>
                                <td><?php echo $usuario->login;?></td>
                                <td><?php echo $usuario->celular;?></td>
                                <td><?php echo $usuario->documento;?></td>
                                <td><?php echo date('d/m/Y H:i:s', strtotime($usuario->ultimo_login));?></td>
                                <td>
                                    <?php
                                    if($permitidoVisualizar){
                                    ?>
                                    <a href="<?php echo base_url($rotaUsuarioVisualizar);?>" class="btn btn-success">Visualizar</a>
                                    <?php
                                    }
                                    ?>

                                    <?php
                                    if(EnabledMasterKey()){
                                    ?>
                                    <?php
                                    if($permitidoBackoffice){
                                    ?>
                                    <a href="<?php echo base_url($rotaUsuarioBackoffice);?>" class="btn btn-warning" target="_blank">Backoffice</a>
                                    <?php
                                    }
                                    ?>

                                    <?php
                                    if($permitidoEditar){
                                    ?>
                                    <a href="<?php echo base_url($rotaUsuarioEditar);?>" class="btn btn-info">Editar</a>
                                    <?php
                                    }
                                    ?>

                                    <?php
                                    if($permitidoExcluir){
                                    ?>
                                    <a href="<?php echo base_url($rotaUsuarioExcluir);?>" class="btn btn-danger">Excluir</a>
                                    <?php
                                    }
                                    ?>
                                    
                                    <?php
                                    }
                                    ?>
                                </td>
                            </tr>
                            <?php
                            }
                            ?>
                            </tbody>
                        </table>
                        <?php
                        }else{
                            echo alerts('Não há nenhum usuário cadastrado.', 'info');
                        }
                        ?>
                    </div>

                </div>

            </div>
        </div>
    </div> <!-- end col -->
</div> <!-- end row -->
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.print.min.js"></script>

<script>
    $('#myTable').DataTable( {
    buttons: [
        {
            extend: 'copy',
            text: 'Copy to clipboard'
        },
        'excel',
        'pdf'
    ]
} );
</script>