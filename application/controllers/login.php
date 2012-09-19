<?php

/*
  Modul      : login
  Tipe       : controller
  programmer : Mada Aryakusumah
  email      : lokermada@gmail.com
  deskripsi  :
 */

class Login extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('User');
    }

    function index($data=null) {
    
    	if(date('n') == 10)
    	{
    		echo 'Maaf masa trial aplikasi ini habis... :-)';
    	}
    	else
    	{
  	      $this->load->view('login', $data);
        }
    }

    function proses_login() {
        $username = $this->input->post("username");
        $pass = $this->input->post("password");
        $password = sha1($pass);
        $q = $this->User->cek_user($username, $password);

        if ($q->num_rows() == 1) {
            $xx = $q->row();

            $login = array('login' => true,
                'userid' => $xx->uUserid,
                'nama' => $xx->uNama,
                'username' => $xx->uUsername,
                'departement' => $xx->uIDdepartement,
                'jabatan' => $xx->uPosition,
                'nomor_session' => $xx->uIDnomor_session,
                'status_upload' => $xx->uStatus,
                'status_special' => $xx->uSpecial
            );

            $hak = $this->db->get_where('hak_akses', array('uIDuser' => $xx->uUserid));
            $akses = $hak->row();

            $arr_user = explode("|", $akses->uUser);
            $arr_pass = explode("|", $akses->uPassword);
            $arr_format = explode("|", $akses->uFormat_surat);
            $arr_surat = explode("|", $akses->uSurat_keluar);
            $arr_laporan = explode("|", $akses->uLaporan);

            if (in_array("r", $arr_user)) {
                $login['menu_akun'] = TRUE;
            }

            if (in_array("r", $arr_pass)) {
                $login['menu_password'] = TRUE;
            }

            if (in_array("r", $arr_format)) {
                $login['menu_format'] = TRUE;
            }

            if (in_array("r", $arr_surat)) {
                $login['menu_surat'] = TRUE;
            }

            if (in_array("r", $arr_laporan)) {
                $login['menu_laporan'] = TRUE;
            }
            
            if (in_array("p", $arr_laporan)) {
                $login['tombol_print'] = TRUE;
            }

            $this->session->set_userdata($login);
            if ($xx->uStatus == 1) {
                redirect('admin/upload_berkas', 'location', 301);
            } else {
                redirect('admin/home', 'location', 301);
            }
        } else {
            $data['error'] = 'Username atau Password anda salah';
            $this->index($data);
        }
    }
    

}
