<div class="pcoded-content">

    <div class="row">
        <div class="col-md-6">
            <div class="card prod-p-card bg-info">
                <div class="card-body">
                    <div class="row align-items-center m-b-25">
                        <div class="col">
                            <h6 class="m-b-5 text-white"><?php echo $this->lang->line('saq_todos_saques_totais');?></h6>
                            <h3 class="m-b-0 text-white"><?php echo MOEDA;?> <?php echo number_format($solicitacao_total, 2, ',', '.');?></h3>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign text-white"></i>
                        </div>
                    </div>
                    <p class="m-b-0 text-white"><?php echo $this->lang->line('saq_todos_saques_totais_desc');?></p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card prod-p-card bg-success">
                <div class="card-body">
                    <div class="row align-items-center m-b-25">
                        <div class="col">
                            <h6 class="m-b-5 text-white"><?php echo $this->lang->line('saq_todos_saques_pagos');?></h6>
                            <h3 class="m-b-0 text-white"><?php echo MOEDA;?> <?php echo number_format($solicitacao_paga, 2, ',', '.');?></h3>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign text-white"></i>
                        </div>
                    </div>
                    <p class="m-b-0 text-white"><?php echo $this->lang->line('saq_todos_saques_pagos_desc');?></p>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h5><?php echo $nome_pagina;?></h5>
        </div>
        <div class="card-body table-border-style">
            <div class="table-responsive dt-responsive">
                <table class="table simpletable_order_by_0_desc">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th><?php echo $this->lang->line('saq_todos_form_tipo_saque');?></th>
                            <th><?php echo $this->lang->line('saq_todos_form_valor_solicitado');?></th>
                            <th><?php echo $this->lang->line('saq_todos_form_valor_receber');?></th>
                            <th><?php echo $this->lang->line('saq_todos_form_data_solicitacao');?></th>
                            <th><?php echo $this->lang->line('saq_todos_form_limite_recebimento');?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if($saques !== false){
                            foreach($saques as $saque){

                                $dataDiasUteis = DiasUteis($saque->data_solicitacao, $dias_pagamento_saque);
                                $horarioSolicitacao = date('H:i:s', strtotime($saque->data_solicitacao));

                                $dataLimite = date('Y/m/d', strtotime($dataDiasUteis)).' '.$horarioSolicitacao;
                        ?>
                        <tr>
                            <td><?php echo $saque->id;?></td>
                            <td><?php echo CategoriaExtrato($saque->tipo_saque);?></td>
                            <td><?php echo MOEDA;?> <?php echo number_format($saque->valor_solicitado, 2, ',', '.');?></td>
                            <td><?php echo MOEDA;?> <?php echo number_format($saque->valor_receber, 2, ',', '.');?></td>
                            <td><?php echo date('d/m/Y H:i:s', strtotime($saque->data_solicitacao));?></td>
                            <td><span class="countdown" data-final="<?php echo $dataLimite;?>"></span></td>
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