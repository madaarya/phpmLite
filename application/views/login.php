<!DOCTYPE html> 
<html lang="en"> 
    <head> 
        <meta charset="utf-8"> 
        <title>PhpMSuratLite</title> 
        <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
        <meta name="description" content="PhpMSuratLite"> 
        <meta name="author" content="Mada Aryakusumah | me@madaarya.com"> 

        <!-- Le styles --> 
        <link href="<?php echo base_url(); ?>assets/twitter-bootstrap/css/bootstrap.css" rel="stylesheet"> 
         <style type="text/css">
      /* Override some defaults */
      html, body {
        background-color: #eee;
      }
      body {
        padding-top: 40px; 
      }
      .container {
        width: 280px;
      }

      /* The white background content wrapper */
      .content {
	width: 450px;
        background-color: #fff;
        padding: 20px;
        margin: 0; 
        -webkit-border-radius: 10px 10px 10px 10px;
           -moz-border-radius: 10px 10px 10px 10px;
                border-radius: 10px 10px 10px 10px;
        -webkit-box-shadow: 0 1px 2px rgba(0,0,0,.15);
           -moz-box-shadow: 0 1px 2px rgba(0,0,0,.15);
                box-shadow: 0 1px 2px rgba(0,0,0,.15);
      }

    .login-form {
      margin-left: 65px;
    }
  
    legend {
      margin-right: -50px;
      font-weight: bold;
      color: #404040;
    }

    </style>
 
        <link href="<?php echo base_url(); ?>assets/twitter-bootstrap/css/bootstrap-responsive.css" rel="stylesheet"> 
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery-1.7.min.js"></script>
        <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements --> 
        <!--[if lt IE 9]>
          <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]--> 
    </head> 

    <body> 
        <div class="container"> 
	<div class="content offset3">
<?php
if (isset($error)) {
    ?>
    <div class="alert alert-error">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <?php echo $error; ?> 
    </div>
    <?php
}
?>
            <div class="row">
              <div class="span3 offset1" style="padding-left:10px">
                <img src="<?php echo base_url(); ?>assets/images/logo.png" style="padding-bottom: 20px" >  
                  <?php echo form_open('login/proses_login'); ?>
                      <fieldset>
                          <div class="clearfix">
                              <input type="text"  name="username" placeholder="Username">
                          </div>
                          <div class="clearfix">
                              <input type="password" name="password" placeholder="Password">
                          </div>
                          <button class="btn primary" type="submit"><i class="icon-ok"></i> Login</button>
			  <button class="btn btn-danger" type="reset"><i class="icon-remove"></i> Reset</button>
                      </fieldset>
                  </form>
              </div>
          </div>
	</div>
        </div> <!-- /container --> 

        <!-- Le javascript
        ================================================== --> 
        <!-- Placed at the end of the document so the pages load faster -->  
        <script src="<?php echo base_url(); ?>assets/twitter-bootstrap/js/bootstrap-alert.js"></script> 
        <script src="<?php echo base_url(); ?>assets/twitter-bootstrap/js/bootstrap-modal.js"></script> 
        <script src="<?php echo base_url(); ?>assets/twitter-bootstrap/js/bootstrap-dropdown.js"></script> 
        <script src="<?php echo base_url(); ?>assets/twitter-bootstrap/js/bootstrap-scrollspy.js"></script> 
        <script src="<?php echo base_url(); ?>assets/twitter-bootstrap/js/bootstrap-tab.js"></script> 
        <script src="<?php echo base_url(); ?>assets/twitter-bootstrap/js/bootstrap-tooltip.js"></script> 
        <script src="<?php echo base_url(); ?>assets/twitter-bootstrap/js/bootstrap-popover.js"></script> 
        <script src="<?php echo base_url(); ?>assets/twitter-bootstrap/js/bootstrap-button.js"></script> 
        <script src="<?php echo base_url(); ?>assets/twitter-bootstrap/js/bootstrap-collapse.js"></script>  

       
    </body> 
</html> 
