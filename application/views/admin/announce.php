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
        <?php echo validation_errors('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button>', '</div>'); ?>
        <form method="POST" action="<?php echo site_url('admin/proses_announce'); ?>" class="form-horizontal">

            <div class="control-group">
                <label class="control-label">Konten announce</label>
                <div class="controls">
                    <textarea rows="3" name="announce"><?php echo $content; ?></textarea>
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
