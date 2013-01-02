<!DOCTYPE html> 
<html lang="en"> 
    <head> 
        <meta charset="utf-8"> 
        <title>PhpMSuratLite</title> 
        <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
        <meta name="description" content="PhpMSuratLite"> 
        <meta name="author" content="Mada Aryakusumah | me@madaarya.com"> 

        <!-- Le styles --> 
        <link href="<?php echo base_url(); ?>assets/twitter-bootstrap/css/bootstrap.min.css" rel="stylesheet" /> 
        <style type="text/css"> 
            body {
                padding-top: 60px;
                padding-bottom: 40px;
            }
        </style> 
        <link href="<?php echo base_url(); ?>assets/twitter-bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" /> 
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery-1.7.min.js"></script>
        <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements --> 
        <!--[if lt IE 9]>
          <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]--> 
    </head> 

    <body> 

        <div class="navbar navbar-inverse navbar-fixed-top"> 
            <div class="navbar-inner"> 
                <div class="container"> 
                    <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse"> 
                        <span class="icon-bar"></span> 
                        <span class="icon-bar"></span> 
                        <span class="icon-bar"></span> 
                    </a> 
                    <a class="brand" href="#">PhpMSuratLite</a> 
                    <div class="nav-collapse collapse"> 
                        <ul class="nav"> 
                            <li class="<?php echo $this->User->page_active('home'); ?>"><?php echo anchor('admin/home', 'Home'); ?></li> 
                            <?php if ($this->session->userdata('menu_surat') != NULL) { ?>
                                <li class="<?php echo $this->User->page_active('surat_keluar'); ?>">
                                    <?php echo anchor('admin/surat_keluar', 'Nomor Surat'); ?></li>
                            <?php } ?>
                            <?php if ($this->session->userdata('menu_format') != NULL) { ?>
                                <li class="<?php echo $this->User->page_active('format_nomor'); ?>">
                                    <?php echo anchor('admin/format_nomor', 'Format Nomor'); ?></li>
                            <?php } ?>

                            <?php if ($this->session->userdata('menu_laporan') != NULL) { ?>
                                <li class="<?php echo $this->User->page_active('laporan'); ?>">
                                    <?php echo anchor('admin/laporan', 'Laporan'); ?></li>
                            <?php } ?>

                            <?php if ($this->session->userdata("jabatan") == '1' or $this->session->userdata("jabatan") == '3') { ?>
                                <li class="<?php echo $this->User->page_active('daftar_user'); ?>">
                                    <?php echo anchor('admin/daftar_user', 'Manajemen User'); ?></li>
                            <?php } ?>

                            <?php if ($this->session->userdata('username') == 'admin') { ?>
                                <li class="<?php echo $this->User->page_active('departement'); ?>">
                                    <?php echo anchor('admin/departement', 'Departement'); ?></li>
                                <li class="<?php echo $this->User->page_active('announce'); ?>">
                                    <?php echo anchor('admin/announce', 'Announce'); ?></li>
                            <?php } ?>
                            
                            

                        </ul>  
                    </div><!--/.nav-collapse -->
                    <div class="nav-collapse collapse pull-right"> 
                        <ul class="nav">
                            <li class="dropdown"> 
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Akun <b class="caret"></b></a> 
                                <ul class="dropdown-menu pull-right"> 
                                    <?php if ($this->session->userdata('menu_akun') != NULL) { ?>
                                        <li><a href="<?php echo site_url('admin/akun'); ?>"><i class="icon-user"></i> Akun saya</a></li>
                                    <?php } ?>
                                    <?php if ($this->session->userdata('menu_password') != NULL) { ?>	
                                        <li><a href="<?php echo site_url('admin/mypassword'); ?>"><i class="icon-lock"></i> Kelola Password</a></li>
                                    <?php } ?>
                                    <li class="divider"></li>
                                    <li><a href="<?php echo site_url('admin/logout'); ?>" onclick="return confirm('anda yakin untuk keluar ?')"><i class="icon-off"></i> Logout</a></li> 
                                </ul> 
                            </li>
                        </ul> 
                    </div> <!--/.nav-collapse right -->
                </div> 
            </div> 
        </div> 

        <div class="container"> 

            <?php echo $konten; ?>

            <hr> 

            <footer> 
                <p>&copy; Elnusa Petrofin <?php echo date('Y'); ?>. All Rights Reserved. Designed by <a href="http://madaarya.com" rel="tooltip" title="young web application developer" target="_blank">Mada Arya</a></p> 
            </footer> 

        </div> <!-- /container --> 

        <!-- Le javascript
        ================================================== --> 
        <!-- Placed at the end of the document so the pages load faster -->  
        <script src="<?php echo base_url(); ?>assets/twitter-bootstrap/js/bootstrap-alert.js"></script> 
        <script src="<?php echo base_url(); ?>assets/twitter-bootstrap/js/bootstrap-modal.js"></script> 
        <script src="<?php echo base_url(); ?>assets/twitter-bootstrap/js/bootstrap-dropdown.js"></script> 
        <script src="<?php echo base_url(); ?>assets/twitter-bootstrap/js/bootstrap-tooltip.js"></script>
        <script src="<?php echo base_url(); ?>assets/twitter-bootstrap/js/bootstrap-button.js"></script>   

    </body> 
</html> 
