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
        
         $("#tanggal2").datepicker({    
          showOn          : "button",
          buttonImage     : "<?php echo base_url(); ?>assets/images/calendar.gif",
          buttonImageOnly : true				
        });
        
      });  
</script>        
 <div class="row">
 <div class="span8 offset2">
 <?php echo validation_errors('<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">×</button>', '</div>'); ?>       
 <form method="POST" action="<?php echo site_url('admin/proses_laporan'); ?>" class="form-horizontal">

 
 <div class="row-fluid">
  	<div class="span1">	   
              Tanggal
        </div>
        <div class="span3">      
               <input type="text" readonly="readonly" id="tanggal" class="input-small" name="tanggal_awal" value="<?php echo set_value('tanggal_awal'); ?>" title="Tanggal is required" />      
        </div>
              
        <div class="span1">
                 s/d
        </div>
        <div class="span3">      
               <input type="text" readonly="readonly" id="tanggal2" class="input-small" name="tanggal_akhir" value="<?php echo set_value('tanggal_akhir'); ?>" title="Tanggal is required" />        
        </div>
</div>             

<?php echo br(2); ?>

 <div class="control-group">
        	<div class="controls">
              <button type="submit" class="btn btn-primary"><i class="icon-ok"></i> Submit</button>
  		<button type="reset" class="btn"><i class="icon-repeat"></i> Reset</button>
  		</div>  
  	</div>	              
</form> 
 </div>
 </div>

