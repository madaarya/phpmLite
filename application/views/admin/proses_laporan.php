<script type="text/javascript">
    $(document).ready(function(){
 
 $("#back").click(function(){	
            window.history.back();	
        });
        
  $("#print").click(function(){
  	var tgl_awal = $("#tanggal_awal").val();
  	var tgl_akhir = $("#tanggal_akhir").val();
  	window.open("<?php echo site_url('admin/cetak_laporan'); ?>/"+tgl_awal+"/"+tgl_akhir,"Cetak Laporan");	
  	

            //window.print();	
        });      
         });
</script>
<input type="hidden" value="<?php echo format_indo_strip($tanggal_awal); ?>" id="tanggal_awal"  />
<input type="hidden" value="<?php echo format_indo_strip($tanggal_akhir); ?>" id="tanggal_akhir"  />
<p>Laporan surat keluar ( <?php echo format_indo_laporan($tanggal_awal); ?> s/d <?php echo format_indo_laporan($tanggal_akhir); ?> )</p>         
<?php echo $laporan.br(); ?>
<button class="btn" id="back"><i class="icon-chevron-left"></i> Back</button>

<?php if($this->session->userdata('tombol_print') and $tombol_print == TRUE) { ?>
<button id="print" class="btn btn-primary"><i class="icon-print icon-white"></i> Cetak</button>
<?php } ?>
