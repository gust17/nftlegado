<div class="pcoded-content">
    <div style="display: flex; justify-content: center; align-items: center; margin: 50px 0;">
        <!-- Slider main container -->
        <div class="swiper-container">
            <!-- Additional required wrapper -->
            <div class="swiper-wrapper">

                <?php
                if($planos !== false){
                    foreach($planos as $k=>$plano){
                ?>
                <div class="swiper-slide bgColor-nft">
                    <div class="picture bgColor-nft">
                        <img src="<?php echo base_url();?>/assets/icons_plans/<?php echo ($k+1);?>.png" alt="">
                    </div>
                    <div class="detail font-decorative">
                        <h2 class="font-decorative text-capitalize text-color-nft"><?php echo strtoupper($plano->nome);?></h2>
                        <h4 class="p-2 text-white"><?php echo MOEDA;?> <?php echo number_format($plano->valor, 2, ',', '.');?> <br> <small>
                        <?php
                        $decodePercents = json_decode($plano->percentual_pago, true);
                        $last = end($decodePercents);
                        echo $last;
                        ?>
                        % / <?php echo $plano->quantidade_dias;?> dias</small></h4>
                        <h5 class="text-white pb-3"><small>
                        <?php
                        $decodeNiveis = json_decode($plano->niveis_indicacao, true);
                        $nivel = array_key_last($decodeNiveis);
                        echo sprintf($this->lang->line('plan_form_indicacao_ate'), $nivel);
                        ?>
                        </small></h5>
                        <form action="<?php echo base_url($rotas->planos_comprar);?>" method="post">
                            <button type="submit" name="submit" value="submit" class="btn btn-light btn-lg btn-block text-lowercase mb-4">Comprar agora</button>
                            <input type="hidden" name="id_plano" value="<?php echo $plano->id;?>" />
                            <input type="hidden" name="<?php echo $csrfName;?>" value="<?php echo $csrfHash;?>" />
                        </form>
                    </div>
                </div>
                <?php
                    }
                }
                ?>
            </div>
            <!-- If we need pagination -->
            <div class="swiper-pagination"></div>

            <!-- If we need navigation buttons -->
                <!-- <div class="swiper-button-prev"></div> -->
                <!-- <div class="swiper-button-next"></div> -->

            <!-- If we need scrollbar -->
            <div class="swiper-scrollbar"></div>
        </div>
    </div>

    <!-- [ Main Content ] start -->
    <div class="row">
        <!-- [ daily sales section ] start -->
        <div class="col-md-6 col-xl-6">
            <div class="card review-project saldoRendimento">
                <div class="card-header">
                    <h5><img class="img-fluid" src="<?php echo base_url()?>/assets/icons_plans/13.png" width="32" alt="">&nbsp;<?php echo $this->lang->line('meus_rendimentos');?></h5>
                </div>
                <div class="card-body">
                    <h2><?php echo MOEDA;?> <?php echo number_format($saldoRendimento, 2, ',', '.');?></h2>
                    <p class="text-color-nft  m-b-10"><?php echo $this->lang->line('subtotal_meus_rendimentos');?></p>
                    <div class="row">
                        <div class="col-sm-6 col-xs-12">
                            <p class="text-success f-16 m-0 f-w-400"><?php echo MOEDA;?> <?php echo number_format($saldoRendimentoEntrada24, 2, ',', '.');?></p>
                            <span class="text-color-nft "><?php echo $this->lang->line('entradas_24h');?></span>
                        </div>
                        <div class="col-sm-6 col-xs-12">
                            <p class="text-danger f-16 m-0 f-w-400"><?php echo MOEDA;?> <?php echo number_format($saldoRendimentoSaida24, 2, ',', '.');?></p>
                            <span class="text-color-nft "><?php echo $this->lang->line('saidas_24h');?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- [ daily sales section ] end -->
        <!-- [ Monthly  sales section ] start -->
        <div class="col-md-6 col-xl-6">
            <div class="card review-project saldoRede">
                <div class="card-header">
                    <h5><img class="img-fluid" src="<?php echo base_url()?>/assets/icons_plans/13.png" width="32" alt="">&nbsp;<?php echo $this->lang->line('saldo_rede');?></h5>
                </div>
                <div class="card-body">
                    <h2><?php echo MOEDA;?> <?php echo number_format($saldoRede, 2, ',', '.');?></h2>
                    <p class="text-color-nft  m-b-10"><?php echo $this->lang->line('subtotal_saldo_rede');?></p>
                    <div class="row">
                        <div class="col-sm-6 col-xs-12">
                            <p class="text-success f-16 m-0 f-w-400"><?php echo MOEDA;?> <?php echo number_format($saldoRedeEntrada24, 2, ',', '.');?></p>
                            <span class="text-color-nft "><?php echo $this->lang->line('entradas_24h');?></span>
                        </div>
                        <div class="col-sm-6 col-xs-12">
                            <p class="text-danger f-16 m-0 f-w-400"><?php echo MOEDA;?> <?php echo number_format($saldoRedeSaida24, 2, ',', '.');?></p>
                            <span class="text-color-nft "><?php echo $this->lang->line('saidas_24h');?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- [ Monthly  sales section ] end -->
        <div class="col-md-12">
            <div class="card feed-card">
                <div class="card-header bg-secondary">
                    <h5 class="text-white"><img class="img-fluid" src="<?php echo base_url()?>/assets/icons_plans/13.png" width="32" alt="">&nbsp;Link</h5>
                </div>
                <div class="card-body">
                    <p class=""> 
                        <span class="text-danger f-w-400">
                            <input type="text" class="form-control" id="linkIndicacao" value="<?php echo base_url();?><?php echo $rotas->cadastro;?>?<?php echo SystemInfo('query_string_patrocinador');?>=<?php echo UserInfo('codigo_patrocinio');?>" disabled />
                        </span>
                        <button class="btn btn-success btn-block text-uppercase copiarLink"><i data-feather="file"></i> <?php echo $this->lang->line('copiar_link_indicacao');?></button>
                    </p>
                </div>
            </div>
        </div>
        <!-- [ year  sales section ] start -->
        <div class="col-md-12 col-xl-12">
            <div class="card app-design">
                <div class="card-body">
                    <a href="<?php echo base_url($rotas->indicados_unilevel);?>" class="btn btn-primary float-right"><?php echo $this->lang->line('mostrar_todos');?></a>
                    <h6 class="f-w-400 text-color-nft "><?php echo $this->lang->line('minha_rede_unilevel');?></h6>
                    <p class="text-primary f-w-400"><?php echo $this->lang->line('dados_unilevel');?></p>
                    <div class="design-description d-inline-block m-r-40">
                        <h3 class="f-w-400"><?php echo $infoUnilevel['total'];?></h3>
                        <p class="text-color-nft "><?php echo $this->lang->line('cadastrados');?></p>
                    </div>
                    <div class="design-description d-inline-block m-r-40">
                        <h3 class="f-w-400"><?php echo $infoUnilevel['diretos'];?></h3>
                        <p class="text-color-nft "><?php echo $this->lang->line('diretos');?></p>
                    </div>
                    <div class="design-description d-inline-block m-r-40">
                        <h3 class="f-w-400"><?php echo $infoUnilevel['ativos'];?></h3>
                        <p class="text-color-nft "><?php echo $this->lang->line('ativos');?></p>
                    </div>
                    <div class="design-description d-inline-block">
                        <h3 class="f-w-400"><?php echo $infoUnilevel['pendentes'];?></h3>
                        <p class="text-color-nft "><?php echo $this->lang->line('pendentes');?></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-12 col-md-12">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card flat-card">
                        <div class="row-table">
                            <div class="col-sm-3 card-body br">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <i class="icon feather icon-eye text-primary mb-1 d-block"></i>
                                    </div>
                                    <div class="col-sm-8 text-md-center">
                                        <h5><?php echo $clicksLink;?></h5>
                                        <span><?php echo $this->lang->line('cliques_no_seu_link');?></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3 card-body br">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <i class="icon feather icon-download-cloud text-primary mb-1 d-block"></i>
                                    </div>
                                    <div class="col-sm-8 text-md-center">
                                        <h5><?php echo $planosAtivos;?></h5>
                                        <span><?php echo $this->lang->line('planos_ativos');?></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 d-none d-md-table-cell d-lg-table-cell d-xl-table-cell card-body">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <i class="icon feather icon-file-text text-primary mb-1 d-block"></i>
                                    </div>
                                    <div class="col-sm-8 text-md-center">
                                        <h5><?php echo $saquesEfetuados;?></h5>
                                        <span><?php echo $this->lang->line('saques_efetuados');?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="card table-card">
                <div class="card-header bg-secondary">
                    <h5 class="text-white"><?php echo $this->lang->line('ultimas_movimentacoes');?></h5>
                </div>
                <div class="card-body px-0 py-0">
                    <div class="table-responsive">
                        <div class="product-scroll" style="height:295px;position:relative;">
                            <table class="table table-hover m-b-0">
                                <thead>
                                    <tr>
                                        <th><?php echo $this->lang->line('table_data');?></th>
                                        <th><?php echo $this->lang->line('table_descricao');?></th>
                                        <th><?php echo $this->lang->line('table_valor');?></th>
                                        <th><?php echo $this->lang->line('table_tipo');?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                if($ultimasMovimentacoes !== false){
                                    foreach($ultimasMovimentacoes as $ultima){
                                ?>
                                    <tr>
                                        <td><?php echo date('d/m/Y H:i:s', strtotime($ultima->data_criacao));?></td>
                                        <td>
                                            <?php echo $ultima->descricao;?>
                                        </td>
                                        <td>
                                            <?php echo MOEDA;?> <?php echo number_format($ultima->valor, 2, ',', '.'); ?>
                                        </td>
                                        <td>
                                            <?php
                                            if($ultima->tipo_saldo == 1){
                                                echo '<span class="badge badge-success">'.$this->lang->line('entrada').'</span>';
                                            }else{
                                                echo '<span class="badge badge-danger">'.$this->lang->line('saida').'</span>';
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                <?php
                                    }
                                }else{
                                    echo '<tr><td colspan="4" align="center">'.alerts($this->lang->line('nenhuma_movimentacao'), 'info').'</td></tr>';
                                }
                                ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="card text-right">
                <div class="card-body">
                    <blockquote class="blockquote mb-0">
                        <p>"Daqui a 20 anos você estará mais decepcionado pelas coisas que você não fez, do que pelas que fez. Então, jogue fora suas amarras, navegue para longe do porto seguro, pegue os ventos em suas velas. Explore, sonhe, descubra."</p>
                        <footer class="blockquote-footer">
                            <small class="text-color-nft "><cite title="Mark Twain">Mark Twain</cite></small>
                        </footer>
                    </blockquote>
                </div>
            </div>
        </div>
        
    </div>
    <!-- [ Main Content ] end -->
</div>
<?php
if($modalStatus == 1){
?>
<div class="modal fade modal-aviso" tabindex="-1" role="dialog" aria-labelledby="avisoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title h4" id="avisoModalLabel"><?php echo $this->lang->line('atencao');?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <?php echo SystemInfo('modal_backoffice_editor');?>
            </div>
        </div>
    </div>
</div>
<?php
}
?>

<!-- Javascript need page -->
<script>
    var paymentBusinessDay = '<?php echo SystemInfo('rendimento_dias_uteis');?>';
    var horaRendimento = '<?php echo SystemInfo('rendimento_hora');?>';
</script>