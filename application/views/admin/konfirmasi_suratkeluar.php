<link href="<?php echo base_url(); ?>assets/twitter-bootstrap/css/bootstrap.css" rel="stylesheet"> 
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery-1.7.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/js/fancybox/jquery.fancybox-1.3.4.css" media="screen" />

<script type="text/javascript">
    $(document).ready(function(){
        $("#kembali").click(function(){
            parent.$.fancybox.close();
        });
	
        $("#submit").click(function(){
		
            self.parent.location.href="<?php echo site_url('admin/form_kirim_surat'); ?>";	
			
        });
    });
</script>
<div style="margin-left:50px">
    <label><b>Perihal</label></b>
<?php echo $jenis_surat; ?>
<br><br>

<?php if(isset($departement)) { ?>
<label><b>Departement</b></label>
<?php echo $departement; ?>
<br><br>
<?php } ?>

<label><b>Tanggal</b></label>
<?php echo $tanggal; ?>
<br><br>

<label><b>Judul Surat</b></label>
<?php echo $judul; ?>
<br><br>
<label><b>Kepada</b></label>
<?php echo $kepada; ?>
<br><br>
<label><b>Dari</b></label>
<?php echo $dari; ?>
<br><br>
<label><b>Keterangan</b></label>
<?php
if (isset($keterangan)) {
    echo $keterangan;
} else {
    echo "-";
}
?>
<br><br>
<label><b>Tembusan</b></label>
<?php
if (isset($tembusan)) {
    echo $tembusan;
} else {
    echo "-";
}
?>
<br><br>


<button type="reset" class="btn" id="kembali"><i class="icon-arrow-left"></i> Back</button>   

<button type="submit" class="btn btn-primary" id="submit"><i class="icon-ok"></i> Submit</button>

</div>
