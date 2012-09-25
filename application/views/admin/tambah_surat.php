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
        
        $("#reset").click(function(){
            $("#jenis").val("");
            $("#tanggal").val("");
            $("#judul").val("");
            $("#kepada").val("");
            $("#dari").val("");
            $("#keterangan").val("");
            $("#kode_departement").val("");
            $("#tembusan").val("");	
        });
        
        
        $('#submit').click(function(){
		
            var jenis = $("#jenis").val();
            var tanggal = $("#tanggal").val();
            var judul = $("#judul").val();
            var kepada = $("#kepada").val();
            var dari = $("#dari").val();
            var keterangan = $("#keterangan").val();
            var kode_dept = $("#kode_departement").val();
            var tembusan = $("#tembusan").val();
		
		
            $.ajax({
                type:"POST",
                url: "<? echo site_url('admin/proses_tambah_surat_keluar'); ?>",
                data: "jenis_surat="+jenis+"&tanggal="+tanggal+"&judul="+judul+"&kepada="+kepada+"&dari="+dari+"&keterangan="+keterangan+"&departement="+kode_dept+"&tembusan="+tembusan,
                success:function(pesan){
                    if (pesan==1)
                    {
                        $.fancybox({
                            'width'         : 750,
                            'height'        : 450,
                            'title'         : 'Confirmation',
                            'transitionIn' : 'fade',
                            'transitionOut' : 'elastic',
                            'overlayColor' : '#000',
                            'overlayOpacity' : 0.9,
                            'href'          : "<?php echo site_url('admin/konfirmasi_suratkeluar'); ?>",
                            'type'          : 'iframe'  
                        });					
                    }
                    else
                    {
                        $("#error-validation").show();
                        $("#error-message").html(pesan);
  							 
                    }
                }										
            });	
        	
        });
        
    });
      
      
</script>
<div class="row">
    <div class="span5 offset3">
        <div id="error-validation" style="display:none">
            <div class="alert alert-error" id="error-message"></div>
        </div>
        <?php #echo form_open('admin/proses_tambah_surat_keluar'); ?>

        <p>
            <label>Jenis Surat</label>
            <select name="jenis_surat" title="Jenis surat is required" id="jenis">
                <option value="">Pilih</option>
                <?php foreach ($jenis_surat->result() as $j) { ?>
                    <option value="<?php echo $j->fFormat_nomorid; ?>"><?php echo $j->fJenis_surat; ?></option>
                <?php } ?>
            </select>
        </p>

        <?php if(isset($departement)) { ?>
        <p>
            <label>Departement</label>
            <select name="departement" id="kode_departement">
                <option value="">Pilih</option>
                <?php foreach ($departement->result() as $d) { ?>
                    <option value="<?php echo $d->uIDdepartement; ?>"><?php echo $d->dKeterangan; ?></option>
                <?php } ?>
            </select>
        </p>
        <?php } ?>
        
        <p>
            <label>Tanggal</label>
            <input type="text" readonly="readonly" id="tanggal" class="text required" name="tanggal" value="<?php echo set_value('tanggal'); ?>" title="Tanggal is required" />
        </p>


        <p>
            <label>Perihal</label>
 	    <textarea rows="3" id="judul" name="judul"><?php echo set_value('judul'); ?></textarea>
        </p>

        <p>
            <label>Kepada</label>
            <input type="text" class="text required" title="Tujuan is required" name="kepada" value="<?php echo set_value('kepada'); ?>" id="kepada" />
        </p>

        <p>
            <label>Dari</label>
            <input type="text" class="text required" name="dari" title="Pengirim surat is required" value="<?php echo set_value('dari'); ?>" id="dari" />
        </p>

        <p>
            <label>Keterangan</label>
            <textarea rows="3" id="keterangan" name="keterangan"><?php echo set_value('keterangan'); ?></textarea>
        </p>
        
        <p>
            <label>Tembusan</label>
            <textarea rows="3" id="tembusan" name="tembusan"><?php echo set_value('tembusan'); ?></textarea>
        </p>

        <p>
            <button type="submit" class="btn btn-primary" id="submit"><i class="icon-ok"></i> Submit</button>
            <button type="reset" id="reset" class="btn"><i class="icon-repeat"></i> Reset</button>   
        </p>
    </div>
</div>    

<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/js/fancybox/jquery.fancybox-1.3.4.css" media="screen" />        
