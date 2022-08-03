<div class="pcoded-content">
    <div class="card">
        <div class="card-header">
            <h5><?php echo $this->lang->line('con_newpay_titulo');?></h5>
        </div>
        <div class="card-body">

            <?php if(isset($message)) echo $message; ?>

            <form action="" method="post">
                <div class="form-group">
                    <label><?php echo $this->lang->line('con_newpay');?></label>
                    <input type="text" class="form-control" name="newpay" value="<?php echo (isset($newpay['newpay'])) ? $newpay['newpay'] : '';?>" placeholder="<?php echo $this->lang->line('con_newpay_informe');?>" required>
                </div>
                <button type="submit" name="submit" value="Atualizar" class="btn btn-success"><?php echo $this->lang->line('con_newpay_button');?></button>
                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" />
            </form>
        </div>
    </div>
</div>