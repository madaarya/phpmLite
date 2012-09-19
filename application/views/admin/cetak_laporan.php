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
            body {
                padding-bottom: 40px;
            }
        </style> 
        <link href="<?php echo base_url(); ?>assets/twitter-bootstrap/css/bootstrap-responsive.css" rel="stylesheet">
    </head> 

    <body onLoad="window.print()"> 
        <div class="container"> 
            <div class="row">
                <div class="span5"><img src="<?php echo base_url(); ?>assets/images/logo.png" /></div>
                <div class="span4 pull-right"><h2>Laporan Surat Keluar</h2></div>
            </div>
            <hr>
            <div class="span4">Periode <?php echo format_indo_laporanstrip($tanggal_awal); ?> s/d <?php echo format_indo_laporanstrip($tanggal_akhir) . br(2); ?></div> 
            <?php echo $laporan; ?>
            <div class="span4 pull-right">Print oleh <?php echo $nama_user . ' ' . format_indo_full($waktu_sekarang); ?></div>
            <br>
            <hr> 

            <footer> 
                <p>&copy; Elnusa Petrofin  <?php echo date('Y'); ?>. All Rights Reserved. Designed by <a href="http://madaarya.com" rel="tooltip" title="young web application developer" target="_blank">Mada Arya</a></p> 
            </footer> 

        </div> <!-- /container --> 
    </body> 
</html> 
