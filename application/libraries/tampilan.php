<?php

class Tampilan {

    protected $_ci;

    function __construct() {
        $this->_ci = &get_instance();
    }

    function tampil_admin($template, $data=null) {
        $data['konten'] = $this->_ci->load->view($template, $data, true);
        //$this->_ci->load->view('template/template',$data);
        $this->_ci->load->view('template/template_bootstrap', $data);
    }

    function tampil_admin_surat($template, $data=null) {
        $data['konten'] = $this->_ci->load->view($template, $data, true);
        //$this->_ci->load->view('template/template',$data);
        $this->_ci->load->view('template/template_surat', $data);
    }

    function tampil_upload($template, $data=null) {
        $data['konten'] = $this->_ci->load->view($template, $data, true);
        //$this->_ci->load->view('template/upload',$data);
        $this->_ci->load->view('template/upload_bootstrap', $data);
    }

}

?>
