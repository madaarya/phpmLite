<link type="text/css" href="<?php echo base_url(); ?>assets/js/jquery/themes/smoothness/ui.all.css" rel="stylesheet" />   
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery/ui/ui.core.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery/ui/ui.datepicker.js"></script>

<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery/ui/i18n/ui.datepicker-id.js"></script>

<script type="text/javascript"> 
    $(document).ready(function(){
        $("#tanggal").datepicker({        
            showOn          : "button",
            buttonImage     : "<?php echo base_url(); ?>assets/images/calendar.gif",
            buttonImageOnly : true				
        });
        
        $("#new_file").click(function(){
            $("#new_upload").slideToggle();
        });

        
    });
</script>
<div class="row">
    <div class="span7 offset3">    
        <?php
        if (isset($error)) {
            ?>
            <div class="alert alert-error">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <?php echo $error; ?></div>
            <?php
        }
        ?>
        <?php echo validation_errors('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button>', '</div>'); ?>
        <?php foreach ($surat->result() as $s) { ?>
            <?php echo form_open_multipart('admin/proses_edit_surat_keluar'); ?>
            <?php echo form_hidden('id_surat', $s->sSurat_keluarid); ?>
            <p>
                <label>Nomor Surat</label>
                <?php echo $s->sNomorfull; ?>
            </p>

            <p>
                <label>Tanggal</label>
                <input type="text" readonly="readonly" id="tanggal" class="text" name="tanggal" value="<?php echo format_edit_surat($s->sWaktu); ?>" />
            </p>


            <p>
                <label>Perihal</label>
 	    	<textarea rows="3" id="judul" name="judul"><?php echo $s->sJudul; ?></textarea>
            </p>

            <p>
                <label>Kepada</label>
                <input type="text" class="text" name="kepada" value="<?php echo $s->sKepada; ?>" />
            </p>

            <p>
                <label>Dari</label>
                <input type="text" class="text" name="dari" value="<?php echo $s->sDari; ?>" />
            </p>

            <p>
                <label>Keterangan</label>
                <textarea rows="3" id="keterangan" name="keterangan"><?php echo $s->sKeterangan; ?></textarea>
            </p>
            
            <p>
                <label>Tembusan</label>
                <textarea rows="3" id="tembusan" name="tembusan"><?php echo $s->sTembusan; ?></textarea>
            </p>

            <p>
                <label>File</label>
                <?php echo anchor("admin/ambil/" . $s->sBerkas, $s->sBerkas) . nbs(3); ?>
                <a href="#" id="new_file">Upload new document</a>
            </p>

            <p style="display:none" id="new_upload">
                <label>Berkas</label>
                <input type="file" name="berkas" /><span class="help-inline">* Format extension : pdf, doc, docx, xls  </span>
            </p>
        <? } ?>
        <p>
            <button type="submit" class="btn btn-primary"><i class="icon-ok"></i> Submit</button>
            <button type="reset" class="btn"><i class="icon-repeat"></i> Reset</button>

        </p>
        <?php echo form_close(); ?>

    </div>
</div>	


