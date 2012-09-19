<div class="row">
    <div class="span5 offset3">
        <?php
        if (isset($sukses)) {
            ?>
            <div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <?php echo $sukses; ?>
            </div>
            <?php
        }
        ?>

        <?php
        if (isset($error)) {
            ?>
            <div class="alert alert-error">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <?php echo $error; ?>
            </div>
            <?php
        }
        ?>

        <?php echo validation_errors('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button>', '</div>'); ?>

        <form method="POST" action="<?php echo site_url('admin/update_akun'); ?>" class="form-horizontal">

            <?php echo form_hidden('id_user', $id_user); ?>
            <div class="control-group">
                <label class="control-label">Nama</label>
                <div class="controls">
                    <input type="text" class="text" name="nama" value="<?php echo $nama; ?>" />
                </div>
            </div>


            <div class="control-group">
                <label class="control-label">Departement</label>
                <div class="controls" style="padding-top: 5px"><?php echo $dept; ?></div>
            </div>
            
             <div class="control-group">
                <label class="control-label">Position</label>
                <div class="controls" style="padding-top: 5px"><?php echo $position; ?></div>
            </div>


            <div class="control-group">
                <label class="control-label">Username</label>
                <div class="controls">	
                    <input type="text" class="text" name="username" value="<?php echo $username; ?>" <?php if($this->session->userdata('username') == 'admin') { echo "readonly='readonly'"; } ?> />
                    
                </div>
            </div>

            <div class="control-group">
                <div class="controls">
                    <button type="submit" class="btn btn-primary"><i class="icon-ok"></i> Submit</button>
                    <button type="reset" class="btn"><i class="icon-repeat"></i> Reset</button>
                </div>  
            </div>
            <?php echo form_close(); ?>
    </div>
</div>
