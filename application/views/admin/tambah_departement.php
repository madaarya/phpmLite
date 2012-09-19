<div class="row">
    <div class="span5 offset3">
        <?php echo validation_errors('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button>', '</div>'); ?>
        <form method="POST" action="<?php echo site_url('admin/proses_tambah_departement'); ?>" class="form-horizontal">

            <div class="control-group">
                <label class="control-label">Kode Departement</label>
                <div class="controls">
                    <input type="text" class="text" name="kode" value="<?php echo set_value('kode'); ?>" />
                </div>
            </div>

            <div class="control-group">
                <label class="control-label">Nama Departement</label>
                <div class="controls">
                    <input type="text" class="text" name="nama" value="<?php echo set_value('nama'); ?>" />
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
