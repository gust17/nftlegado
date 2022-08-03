<div class="pcoded-content">
    <div class="card">
        <div class="card-header">
            <h5><?php echo $nome_pagina;?></h5>
        </div>

        <div class="card-body table-border-style">
            <div class="row">
                <div class="col-md-12">
                    <div class="card feed-card">
                        <div class="card-body p-t-0 p-b-0">
                            <div class="row">
                                <div class="col-2 bg-dark border-feed">
                                    <img class="img-fluid" src="<?php echo base_url()?>/assets/icons_plans/13.png" alt="">
                                </div>
                                <div class="col-10">
                                    <div class="p-t-25 p-b-25">
                                        <p class="text-white m-0">
                                            <span class="text-white f-w-400">
                                                <input type="text" class="form-control" id="linkIndicacao" value="<?php echo base_url();?><?php echo $rotas->cadastro;?>?<?php echo SystemInfo('query_string_patrocinador');?>=<?php echo UserInfo('codigo_patrocinio');?>" disabled />
                                                <button class="btn btn-success btn-block text-uppercase copiarLink"><i data-feather="file"></i> <?php echo $this->lang->line('copiar_link_indicacao');?></button>
                                            </span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card table-card review-card">
                <div class="card-body">
                    <div class="review-block">
                        <div class="row">
                            <div class="col-sm-auto p-r-0">
                                <img src="<?php echo base_url();?>assets/pages/img/sponsor.png" alt="Patrocinador" class="img-radius profile-img cust-img m-b-15">
                            </div>
                            <div class="col">
                                <h6 class="m-b-15"><?php echo sprintf($this->lang->line('ind_relatorio_seu_patrocinador'), $patrocinador->nome);?></h6>
                                <p class="m-t-15 m-b-15 text-white">
                                    <?php echo sprintf($this->lang->line('ind_relatorio_contato_patrocinador_ins_1'), $patrocinador->nome, date('d/m/Y \à\s H:i', strtotime(UserInfo('data_cadastro'))));?>
                                </p>
                                <a href="https://api.whatsapp.com/send?phone=<?php echo str_replace(array(' ', '.', '-', '(', ')', '+'), array('', '', '', '', '', ''), $patrocinador->celular);?>&text=Olá, estou cadastrado em sua rede na <?php echo NOME_SITE;?> e preciso de ajuda." class="m-r-30 text-white" target="_blank"><i class="feather icon-thumbs-up m-r-15"></i><?php echo $this->lang->line('ind_relatorio_contato_patrocinador_button');?></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-8">
                    <div class="card flat-card">
                        <div class="row-table">
                            <div class="col-sm-6 card-body br">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <i class="icon feather icon-navigation text-primary mb-1 d-block"></i>
                                    </div>
                                    <div class="col-sm-8 text-md-center">
                                        <h5><?php echo $clicksLink;?></h5>
                                        <span><?php echo $this->lang->line('ind_relatorio_cliques_link');?></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 card-body">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <i class="icon feather icon-user-check text-primary mb-1 d-block"></i>
                                    </div>
                                    <div class="col-sm-8 text-md-center">
                                        <h5><?php echo $indicadosAtivos;?></h5>
                                        <span><?php echo $this->lang->line('ind_relatorio_cadastros_ativos');?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row-table">
                            <div class="col-sm-6 card-body br">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <i class="icon feather icon-user-x text-primary mb-1 d-block"></i>
                                    </div>
                                    <div class="col-sm-8 text-md-center">
                                        <h5><?php echo $indicadosPendentes;?></h5>
                                        <span><?php echo $this->lang->line('ind_relatorio_cadastros_pendentes');?></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 card-body">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <i class="icon feather icon-repeat text-primary mb-1 d-blockz"></i>
                                    </div>
                                    <div class="col-sm-8 text-md-center">
                                        <h5>
                                        <?php
                                        if($clicksLink > 0){
                                            echo round((($indicadosAtivos * 100)/$clicksLink), 2);
                                        }else{
                                            echo '0';
                                        }
                                        ?>
                                        %
                                        </h5>
                                        <span><?php echo $this->lang->line('ind_relatorio_conversao');?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card profile-view">
                        <div class="card-body">
                            <div class="p-t-50 p-b-50 text-center">
                                <i class="fas fa-users f-50"></i>
                            </div>
                            <div class="row">
                                <div class="col-6 text-center">
                                    <p class="text-white m-b-0"><?php echo $this->lang->line('ind_relatorio_cliques');?></p>
                                    <h3 class="my-2 text-success"><?php echo $clicksLink;?></h3>
                                </div>
                                <div class="col-6 text-center">
                                    <p class="text-white m-b-0"><?php echo $this->lang->line('ind_relatorio_cadastros');?></p>
                                    <h3 class="my-2 text-primary"><?php echo ($indicadosAtivos+$indicadosPendentes);?></h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-header bg-primary">
                <h5 class="text-white"><?php echo $this->lang->line('ind_relatorio_ultimos_cadastrados');?></h5>
            </div>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th><?php echo $this->lang->line('ind_relatorio_form_nome');?></th>
                            <th><?php echo $this->lang->line('ind_relatorio_form_celular');?></th>
                            <th><?php echo $this->lang->line('ind_relatorio_form_cadastro_ativo');?></th>
                            <th><?php echo $this->lang->line('ind_relatorio_form_data_cadastro');?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if($cadastros !== false){
                            foreach($cadastros as $indicado){
                        ?>
                        <tr>
                            <td><?php echo $indicado->nome;?></td>
                            <td><?php echo $indicado->celular;?></td>
                            <td><?php echo ($indicado->plano_ativo == 1) ? strtoupper($this->lang->line('sim')) : strtoupper($this->lang->line('nao'));?></td>
                            <td><?php echo date('d/m/Y H:i:s', strtotime($indicado->data_cadastro));?></td>
                        </tr>
                        <?php
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>