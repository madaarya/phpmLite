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
        });

        $(".tidak_spesial").click(function(){
            $("#pilih_departement").fadeOut();
		
        });
	
    });

</script>
<div class="row">
    <div class="span7 offset3">
        <?php echo validation_errors('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button>', '</div>'); ?>
        <form method="POST" action="<?php echo site_url('admin/proses_tambah_user'); ?>" class="form-horizontal">

            <div class="control-group">	   
                <label class="control-label">Nama</label>
                <div class="controls">
                    <input type="text" class="text" name="nama" value="<?php echo set_value('nama'); ?>" />
                </div>
            </div>    

            <div class="control-group">    
                <label class="control-label">Departement</label>
                <div class="controls">
                    <select name="departement">
                        <option value="">Choice</option>
                        <?php foreach ($departement->result() as $r) { ?>
                            <option value="<?php echo $r->dDepartementid; ?>"><?php echo $r->dKeterangan; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            
            
            <div class="control-group">
                <label class="control-label">Jabatan</label>
                <div class="controls">
                    <select name="jabatan">
                        <option value="">Choice</option>
                        <option value="1">manager</option>
                        <option value="0">staff</option>
                    </select>
                </div>
            </div>


            <div class="control-group">
                <label class="control-label">Username</label>
                <div class="controls">
                    <input type="text" class="text" name="username" value="<?php echo set_value('username'); ?>" />
                </div>
            </div>    

            <div class="control-group">    
                <label class="control-label">Password</label>
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
                        <input type="radio" name="special" value="yes" class="spesial" />Ya
                    </label>
                    <label class="radio inline">
                        <input type="radio" name="special" value="no" class="tidak_spesial" checked="checked" />Tidak
                    </label>
                </div>
            </div>
            
            <div class="control-group" id="pilih_departement">    
                <label class="control-label">Pilih depertement</label>
                <div class="controls">
                    <?php foreach ($departement->result() as $r) { ?>
                     <label class="checkbox"><input type="checkbox" name="special_departement[]" value="<?php echo $r->dDepartementid; ?>" /><?php echo $r->dKeterangan . br(); ?></label>
                    <?php } ?>
                </div>
            </div>

            <div class="row-fluid">
                <div class="span7" style="padding-top: 30px;">
                    <label>Hak akses</label><br />
                    <?php echo $hak_akses; ?>
                </div>
            </div>

            <br class="clear" />

            <div class="control-group">
                <div class="controls">
                    <button type="submit" class="btn btn-primary"><i class="icon-ok"></i> Submit</button>
                    <button type="reset" class="btn"><i class="icon-repeat"></i> Reset</button>
                </div>  
            </div>	

            <?php echo form_close(); ?>
    </div>
</div>
