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
                    <button type="button" class="close" data-dismiss="alert">×</button><?php echo $error[$i]; ?></div>
                <?php
            }
        }
        ?>
        <?php echo form_open('admin/proses_edit_format_nomor'); ?>
        <?php echo form_hidden('id_format', $id_format); ?>

        <div class="row">
            <div class="span1"> No Urut</div> 
            <div class="span2">Content</div> 
            <div class="span1">Delimiter</div>
        </div>

        <div class="row">
            <div class="span1"> 
                <input type="text" class="input-mini" name="field_satu" value="<?php
        if (isset($satu)) {
            echo $satu;
        }
        if (isset($urutan_jenis)) {
            echo $urutan_jenis;
        } else {
            echo set_value('field_satu');
        }
        ?>" />
            </div>

            <div class="span2">  
                <input type="text" class="input-medium" name="field_isi_satu" value="<?php 
        if (isset($isi_jenis)) {
            echo $isi_jenis;
        } else {
            echo set_value('field_isi_satu');
        } ?>" />
            </div>

            <div class="span1"> 
                <input type="text" class="input-mini" name="field_delimiter_satu" value="<?php if (isset($delimiter_jenis)) {
            echo $delimiter_jenis;
        } else {
            echo set_value('field_delimiter_satu');
        } ?>" />
            </div>

            <div class="span2">* Jenis Surat</div>

        </div>

        <div class="row">
            <div class="span1"> 
                <input type="text" class="input-mini" name="field_dua" value="<?php
        if (isset($dua)) {
            echo $dua;
        }
        if (isset($urutan_dept)) {
            echo $urutan_dept;
        } else {
            echo set_value('field_dua');
        }
        ?>" />
            </div>
            <div class="span2"> 
                <input type="text" class="input-medium" name="field_isi_dua" value="otomatis" readonly="readonly" />
            </div>

            <div class="span1"> 
                <input type="text" class="input-mini" name="field_delimiter_dua" value="<?php if (isset($delimiter_dept)) {
            echo $delimiter_dept;
        } else {
            echo set_value('field_delimiter_dua');
        } ?>" />
            </div>

            <div class="span2"> * Kode departement</div>

        </div>

        <!-- bulan -->
        <div class="row">
            <div class="span1"> 
                <input type="text" class="input-mini" name="field_tiga" value="<?php
        if (isset($tiga)) {
            echo $tiga;
        }
        if (isset($urutan_bulan)) {
            echo $urutan_bulan;
        } else {
            echo set_value('field_tiga');
        }
        ?>" />
            </div>
            <div class="span2">
                <input type="text" class="input-medium" id="bulan" name="field_isi_tiga" value="<?php if (isset($isi_bulan)) {
            echo $isi_bulan;
        } else {
            echo set_value('field_isi_tiga');
        } ?>" <?php if (isset($isi_bulan) && ($isi_bulan == 'otomatis')) {
            echo 'readonly="readonly"';
        } ?> />
            </div>
            <div class="span1">
                <input type="text" class="input-mini" name="field_delimiter_tiga" value="<?php if (isset($delimiter_bulan)) {
            echo $delimiter_bulan;
        } else {
            echo set_value('field_delimiter_tiga');
        } ?>" />
            </div>
            <div class="span2">* Format bulan</div>

        </div>

        <div class="row">
            <div class="span1"><?php echo nbs(3) ?></div>
            <div class="span2">
                <label class="radio inline">
                    <input type="radio" name="bulan" value="sistem" class="sistem_bulan" <?php if (isset($isi_tahun) && ($isi_tahun == 'otomatis')) {
            echo 'checked ="checked"';
        } ?> />Sistem
                </label>
                <label class="radio inline">
                    <input type="radio" name="bulan" class="manual_bulan" <?php if (isset($isi_tahun) && ($isi_tahun != 'otomatis')) {
            echo 'checked ="checked"';
        } ?> />Manual
                </label>
            </div>
        </div>
        <br>
        <!-- tahun -->

        <div class="row">
            <div class="span1">
                <input type="text" class="input-mini" name="field_empat" value="<?php 
        if (isset($empat)) {
            echo $empat;
        } 
        if (isset($urutan_tahun)) {
            echo $urutan_tahun;
        } else {
            echo set_value('field_empat');
        } ?>" />
            </div>

            <div class="span2">
                <input type="text" class="input-medium" id="tahun" name="field_isi_empat" value="<?php if (isset($isi_tahun)) {
            echo $isi_tahun;
        } else {
            echo set_value('field_isi_empat');
        } ?>" <?php if (isset($isi_tahun) && ($isi_tahun == 'otomatis')) {
                        echo 'readonly="readonly"';
                    } ?> />
            </div>

            <div class="span1">
                <input type="text" class="input-mini" name="field_delimiter_empat" value="<?php 
                if (isset($delimiter_tahun)) { echo $delimiter_tahun;
                           } else {
                               echo set_value('field_delimiter_empat');
                           } ?>"  />
            </div>
            <div class="span2">* Format tahun</div>

        </div>

        <div class="row">
            <div class="span1"><?php echo nbs(3) ?></div>
            <div class="span2">
                <label class="radio inline">
                    <input type="radio" name="tahun" value="sistem" class="sistem_tahun" <?php if (isset($isi_tahun) && ($isi_tahun == 'otomatis')) {
                               echo 'checked ="checked"';
                           } ?> />Sistem
                </label>
                <label class="radio inline">
                    <input type="radio" name="tahun" class="manual_tahun" <?php if (isset($isi_tahun) && ($isi_tahun != 'otomatis')) {
                               echo 'checked ="checked"';
                           } ?> />Manual
                </label>
            </div>
        </div>
        <br>


        <div class="row">
            <div class="span1">
                <input type="text" class="input-mini" name="field_lima" value="<?php if (isset($lima)) {
                               echo $lima;
                           } if (isset($urutan_nomor)) {
                               echo $urutan_nomor;
                           } else {
                               echo set_value('field_lima');
                           } ?>" />
            </div>
            <div class="span2">
                <input type="text" class="input-medium" name="field_isi_lima" value="<?php if (isset($isi_nomor)) {
                               echo $isi_nomor;
                           } else {
                               echo set_value('field_isi_lima');
                           } ?>" />
            </div>
            <div class="span1">
                <input type="text" class="input-mini" name="field_delimiter_lima" value="<?php if (isset($delimiter_nomor)) {
                               echo $delimiter_nomor;
                           } else {
                               echo set_value('field_delimiter_lima');
                           } ?>" />
            </div>
            <div class="span3">* Nomor (definisi start number)</div>

        </div>

        <div class="row">
            <div class="span4">
                <label class="control-label">Deskripsi </label>  
                <input type="text" class="input-medium" name="deskripsi" value="<?php echo $deskripsi; ?>" />
            </div>
        </div>

        <div class="row">
            <div class="span4">
                <label class="control-label">Hak Akses </label>       
                
<?php foreach ($departement->result() as $r) { ?>
                        <label class="checkbox"><input type="checkbox" name="departement[]" value="<?php echo $r->dDepartementid; ?>" 
    <?php foreach ($hak_akses->result() as $h) { ?>
        <?php if ($r->dDepartementid == $h->aIDdepartement) { ?>
                                       checked ="checked"
        <?php }
    } ?>
                               />  <?php echo $r->dKeterangan . br(); ?></label>
<?php } ?>
                
            </div>
        </div>

        <br>
        <button type="submit" class="btn btn-primary"><i class="icon-ok"></i> Submit</button>

<?php echo form_close(); ?>
    </div>
</div>
