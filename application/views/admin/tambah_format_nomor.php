<style>
    #bulan_manual
    {
        display:none;
    }

    #tahun_manual
    {
        display:none;
    }

</style>

<script>
    $(document).ready(function(){

        $(".manual_bulan").click(function(){
            $("#bulan").val("");
            $("#bulan").removeAttr("readonly");		
        });

        $(".sistem_bulan").click(function(){
            $("#bulan").val("otomatis");
            $("#bulan").attr("readonly","readonly");
		
        });
	
        $(".manual_tahun").click(function(){
            $("#tahun").val("");
            $("#tahun").removeAttr("readonly");
        });

        $(".sistem_tahun").click(function(){
            $("#tahun").val("otomatis");
            $("#tahun").attr("readonly","readonly");
		
        });
    });

</script>
<div class="row">
    <div class="span7 offset3">
        <?php echo validation_errors('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button>', '</div>'); ?>

        <?php if (isset($error_wajib)) { ?>
            <div class="alert alert-error">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <?php echo $error_wajib; ?></div>
        <?php } ?>


        <?php
        if (isset($error)) {
            for ($i = 0; $i < $jumlah_error; $i++) {
                ?>
                <div class="alert alert-error">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <?php echo $error[$i]; ?></div>
                    <?php
                }
            }
            ?>
        <?php echo form_open('admin/proses_tambah_format_nomor'); ?>

        <div class="row">
            <div class="span1"> No Urut</div> 
            <div class="span2">Content</div> 
            <div class="span1">Delimiter</div>
        </div>

        <div class="row">
            <div class="span1">  
                <input type="text" class="input-mini" name="field_satu" value="<?php echo set_value('field_satu'); ?>" />
            </div>
            <div class="span2">
                <input type="text" name="field_isi_satu" class="input-medium" value="<?php echo set_value('field_isi_satu'); ?>" />
            </div>
            <div class="span1">
                <input type="text" class="input-mini" name="field_delimiter_satu" value="<?php echo set_value('field_delimiter_satu'); ?>" />
            </div>
            <div class="span2">
                * Jenis Surat
            </div>	
        </div>

        <div class="row">
            <div class="span1">
                <input type="text" class="input-mini" name="field_dua" value="<?php echo set_value('field_dua'); ?>" />
            </div>
            <div class="span2">
                <input type="text" class="input-medium" name="field_isi_dua" value="otomatis" readonly="readonly" />
            </div>
            <div class="span1">
                <input type="text" class="input-mini" name="field_delimiter_dua" value="<?php echo set_value('field_delimiter_dua'); ?>" />
            </div>

            <div class="span2">
                <span class="prepend-1">* Kode departement</span>
            </div>

        </div>

        <!-- bulan -->
        <div class="row">
            <div class="span1">
                <input type="text" class="input-mini" name="field_tiga" value="<?php echo set_value('field_tiga'); ?>" />
            </div>

            <div class="span2">
                <input type="text" class="input-medium" id="bulan" name="field_isi_tiga" value="<?php echo set_value('field_isi_tiga'); ?>" />
            </div>

            <div class="span1">
                <input type="text" class="input-mini" name="field_delimiter_tiga" value="<?php echo set_value('field_delimiter_tiga'); ?>" />
            </div>

            <div class="span2">* Format bulan</div>

        </div>


        <div class="row">
            <div class="span1"><?php echo nbs(3) ?></div>

            <div class="span2">
                <label class="radio inline">
                    <input type="radio" name="bulan" value="sistem" class="sistem_bulan" />Sistem
                </label>
                <label class="radio inline">
                    <input type="radio" name="bulan" class="manual_bulan" checked="checked" />Manual
                </label>
            </div>

        </div>
        <br>
        <!-- tahun -->

        <div class="row">
            <div class="span1">
                <input type="text" class="input-mini" name="field_empat" value="<?php echo set_value('field_empat'); ?>" />
            </div>

            <div class="span2">
                <input type="text" class="input-medium" id="tahun" name="field_isi_empat" value="<?php echo set_value('field_isi_empat'); ?>" />
            </div>

            <div class="span1">
                <input type="text" class="input-mini" name="field_delimiter_empat" value="<?php echo set_value('field_delimiter_empat'); ?>" />
            </div>
            <div class="span2">
                * Format tahun
            </div>

        </div>


        <div class="row">
            <div class="span1"><?php echo nbs(3) ?></div>
            <div class="span2">
                <label class="radio inline">
                    <input type="radio" name="tahun" value="sistem" class="sistem_tahun" />Sistem
                </label>
                <label class="radio inline">
                    <input type="radio" name="tahun" class="manual_tahun" checked="checked" />Manual
                </label>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="span1">
                <input type="text" class="input-mini" name="field_lima" value="<?php echo set_value('field_lima'); ?>" />
            </div>
            <div class="span2">
                <input type="text" class="input-medium" name="field_isi_lima" value="<?php echo set_value('field_isi_lima'); ?>" />
            </div>

            <div class="span1">
                <input type="text" class="input-mini" name="field_delimiter_lima" value="<?php echo set_value('field_delimiter_lima'); ?>" />
            </div>
            <div class="span3">* Nomor (definisi start number)</div>
        </div>

        <div class="row">
            <div class="span4">
                <label class="control-label">Deskripsi </label>    
                <input type="text" class="input-medium" name="deskripsi" value="<?php echo set_value('deskripsi'); ?>" />
            </div>
        </div>


        <div class="row">
            <div class="span4">
                <label class="control-label">Hak Akses </label>
                    <?php foreach ($departement->result() as $r) { ?>
                     <label class="checkbox"><input type="checkbox" name="departement[]" value="<?php echo $r->dDepartementid; ?>" />  <?php echo $r->dKeterangan . br(); ?></label>
                    <?php } ?>
            </div>
        </div>

        <br>
        <button type="submit" class="btn btn-primary"><i class="icon-ok"></i> Submit</button>

        <?php echo form_close(); ?>
    </div>
</div>

