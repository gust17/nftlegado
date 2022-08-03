<div class="pcoded-content">
    <div class="card">
        <div class="card-header">
            <h5><?php echo $this->lang->line('con_pix_titulo');?></h5>
        </div>
        <div class="card-body">

            <?php if(isset($message)) echo $message; ?>

            <form action="" method="post">
                <div class="form-group">
                    <label><?php echo $this->lang->line('con_pix_chave');?></label>
                    <input type="text" class="form-control" name="pix" value="<?php echo (isset($pix['pix'])) ? $pix['pix'] : '';?>" placeholder="<?php echo $this->lang->line('con_pix_chave_informe');?>" required>
                </div>
                <div class="form-group">
                    <label><?php echo $this->lang->line('con_pix_banco');?></label>
                    <select name="banco" class="form-control" required>
                        <?php
                        foreach(ListaBancos() as $codigo=>$banco){

                            $selected = (isset($pix['banco']) && $pix['banco'] == $codigo) ? 'selected' : '';

                            echo '<option value="'.$codigo.'" '.$selected.'>'.$codigo.' - '.$banco.'</option>';
                        }
                        ?>
                    </select>
                </div>
                <button type="submit" name="submit" value="Atualizar" class="btn btn-success"><?php echo $this->lang->line('con_pix_button');?></button>
                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
            </form>
        </div>
    </div>
</div>