<style>
    #pilih_departement
    {
        display:none;
    }
</style>
<script>
    $(document).ready(function(){

        $(".spesial").click(function(){
            $("#pilih_departement").fadeIn();
            $("#pilih_ada").fadeIn();
        });

        $(".tidak_spesial").click(function(){
            $("#pilih_departement").fadeOut();
            $("#pilih_ada").fadeOut();
        });
	
    });

</script>
<div class="row">
    <div class="span7 offset3">
        <?php
        if ($this->session->flashdata('error')) {
            ?>
            <div class="alert alert-error">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <?php echo $this->session->flashdata('error'); ?>
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
        <form method="POST" action="<?php echo site_url('admin/proses_edit_user'); ?>" class="form-horizontal">
            <?php echo form_hidden('id_user', $id_user); ?>

            <div class="control-group">
                <label class="control-label">Nama</label>
                <div class="controls">
                    <input type="text" class="text" name="nama" value="<?php echo $nama; ?>" />
                </div>
            </div>  


            <div class="control-group">
                <label class="control-label">Departement</label>
                <div class="controls">
                    <select name="departement">
                        <option value="">Choice</option>
                        <?php foreach ($departement->result() as $r) { ?>
                            <?php if ($r->dDepartementid == $dept) { ?>
                                <option value="<?php echo $r->dDepartementid; ?>" selected="selected"><?php echo $r->dKeterangan; ?></option>
                            <?php } else { ?>
                                <option value="<?php echo $r->dDepartementid; ?>"><?php echo $r->dKeterangan; ?></option>
                            <?php }
                        } ?>
                    </select>
                </div>
            </div>
            
             
            <div class="control-group">
                <label class="control-label">Jabatan</label>
                <div class="controls">
                    <select name="jabatan">
                        <option value="">Choice</option>
                        <option value="1" <?php if($jabatan == 1) { echo 'selected="selected"'; } ?>>manager</option>
                        <option value="0" <?php if($jabatan == 0) { echo 'selected="selected"'; } ?>>staff</option>
                    </select>
                </div>
            </div>


            <div class="control-group">
                <label class="control-label">Username</label>
                <div class="controls">
                    <input type="text" class="text" name="username" value="<?php echo $username; ?>" />
                </div>
            </div>

            <div class="control-group">
                <label class="control-label">New Password</label>
                <div class="controls">
                    <input type="password" class="text" name="password" />
                </div>
            </div>

            <div class="control-group">
                <label class="control-label">Retype password</label>
                <div class="controls">
                    <input type="password" class="text" id="dummy3" name="repassword" />
                </div>
            </div>
            
            <div class="control-group">    
                <label class="control-label">User Special</label>
                <div class="controls">
                    <label class="radio inline">
                        <input type="radio" name="special" value="yes" class="spesial" <?php if($status_special == 1) { ?> checked="checked" <?php } ?> />Ya
                    </label>
                    <label class="radio inline">
                        <input type="radio" name="special" value="no" class="tidak_spesial" <?php if($status_special == 0) { ?> checked="checked" <?php } ?>  />Tidak
                    </label>
                </div>
            </div>
            
            <div class="control-group" id="<?php if($status_special == 1) { ?>pilih_ada<?php } else { ?>pilih_departement<?php } ?>">    
                <label class="control-label">Pilih depertement</label>
                <div class="controls">
                    <?php foreach ($departement->result() as $r) { ?>
                     <label class="checkbox"><input type="checkbox" name="special_departement[]" value="<?php echo $r->dDepartementid; ?>" 
    <?php foreach ($special->result() as $s) { ?>
        <?php if ($r->dDepartementid == $s->uIDdepartement) { ?>
                                       checked ="checked"
        <?php }
    } ?>
                               /><?php echo $r->dKeterangan . br(); ?></label>
<?php } ?>
                </div>
            </div>

            <div class="row-fluid">
                <div class="span7" style="padding-top: 30px;">
                    <label>Hak akses</label><br />
                    <?php echo $hak_akses; ?>
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

