<?php

class User extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function cek_user($username, $password) {
        $this->db->join('departement', 'departement.dDepartementid = user.uIDdepartement');
        $this->db->where('uUsername', $username);
        $this->db->where('uPassword', $password);

        return $this->db->get('user');
    }

    function detail_akun($id_user) {
        $this->db->join('departement', 'departement.dDepartementid = user.uIDdepartement');
        $this->db->where('uUserid', $id_user);
        return $this->db->get('user');
    }

    function update_akun($id, $nama, $username) {
        $data = array
            (
            'uUsername' => $username,
            'uNama' => $nama
        );

        $this->db->where('uUserid', $id);
        return $this->db->update('user', $data);
    }

    function update_password($id_user, $password) {
        $new_password = sha1($password);
        $data = array
            (
            'uPassword' => $new_password
        );

        $this->db->where('uUserid', $id_user);
        return $this->db->update('user', $data);
    }

    function daftar_user_paging($page, $offset, $id_user, $username, $id_departement, $jabatan, $order_column, $order_type) {
        $this->db->join('departement', 'departement.dDepartementid = user.uIDdepartement');
        $this->db->limit($page, $offset);
        $this->db->where('uUsername !=', 'admin');

        if ($username != 'admin' and $jabatan == 1) {
            $this->db->where('uIDdepartement', $id_departement);
            $this->db->where('uPosition', 0);
        }

        $this->db->where('uUserid !=', $id_user);
        $this->db->order_by($order_column, $order_type);
        return $this->db->get('user');
    }

    function daftar_user($id_user, $username, $id_departement, $jabatan) {
        $this->db->join('departement', 'departement.dDepartementid = user.uIDdepartement');
        $this->db->where('uUsername !=', 'admin');

        if ($username != 'admin' and $jabatan == 1) {
            $this->db->where('uIDdepartement', $id_departement);
            $this->db->where('uPosition', 0);
        }

        $this->db->where('uUserid !=', $id_user);

        return $this->db->get('user');
    }

    function cari_user($kata, $id_user, $username) {
        $this->db->join('departement', 'departement.dDepartementid = user.uIDdepartement');
        $this->db->where('uUsername !=', 'admin');

        if ($username != 'admin') {
            $this->db->where('dLevel !=', 1);
        }

        $this->db->where('uUserid !=', $id_user);
        $this->db->like('uNama', $kata);

        return $this->db->get('user');
    }

    function tambah_user($nama, $username, $departement, $password, $jabatan) {
        $pass = sha1($password);
        $data = array
            (
            'uUsername' => $username,
            'uPassword' => $pass,
            'uNama' => $nama,
            'uIDdepartement' => $departement,
            'uPosition' => $jabatan
        );

        $this->db->insert('user', $data);
        return $this->db->insert_id();
    }

    function update_user($id, $nama, $username, $departement, $password_new, $jabatan) {

        $pass = sha1($password_new);

        if (empty($password_new)) {
            $data = array
                (
                'uUsername' => $username,
                'uNama' => $nama,
                'uIDdepartement' => $departement,
                'uPosition' => $jabatan
            );
        } else {
            $data = array
                (
                'uUsername' => $username,
                'uPassword' => $pass,
                'uNama' => $nama,
                'uIDdepartement' => $departement,
                'uPosition' => $jabatan
            );
        }

        $this->db->where('uUserid', $id);
        return $this->db->update('user', $data);
    }

    function tambah_departement($kode, $nama) {
        $data = array
            (
            'dCode_departement' => $kode,
            'dKeterangan' => $nama
        );

        return $this->db->insert('departement', $data);
    }

    function update_departement($id, $kode, $nama) {
        $data = array
            (
            'dCode_departement' => $kode,
            'dKeterangan' => $nama
        );

        $this->db->where('dDepartementid', $id);
        return $this->db->update('departement', $data);
    }

    function update_status($id_user, $id_session) {
        $data = array
            (
            'uIDnomor_session' => $id_session,
            'uStatus' => 1
        );

        $this->db->where('uUserid', $id_user);
        return $this->db->update('user', $data);
    }

    function update_upload($id_user) {
        $data = array
            (
            'uStatus' => 0
        );

        $this->db->where('uUserid', $id_user);
        return $this->db->update('user', $data);
    }

    function tambah_akses($id_user, $akses) {
        $data = array
            (
            'uUser' => $akses['user'],
            'uPassword' => $akses['pass'],
            'uFormat_surat' => $akses['format'],
            'uSurat_keluar' => $akses['surat'],
            'uLaporan' => $akses['laporan'],
            'uIDuser' => $id_user
        );

        return $this->db->insert('hak_akses', $data);
    }

    function update_akses($id_user, $akses) {
        $data = array
            (
            'uUser' => $akses['user'],
            'uPassword' => $akses['pass'],
            'uFormat_surat' => $akses['format'],
            'uSurat_keluar' => $akses['surat'],
            'uLaporan' => $akses['laporan'],
        );

        $this->db->where('uIDuser', $id_user);
        return $this->db->update('hak_akses', $data);
    }

    function page_active($page) {
        if ($this->uri->segment(2) == $page) {
            return "active";
        } else {
            return "";
        }
    }

    function update_special_user($id_user, $code_special) {
        $data = array
            (
            'uSpecial' => $code_special
        );

        $this->db->where('uUserid', $id_user);
        return $this->db->update('user', $data);
    }

    function hapus_special_user($id) {
        $this->db->delete('user_special', array('uIDuser' => $id));
    }

    function departement_user_spesial($id_user) {
        $this->db->join('departement', 'departement.dDepartementid = user_special.uIDdepartement');
        $this->db->where('uIDuser', $id_user);
        return $this->db->get('user_special');
    }
    
    function hapusdept_edit_user($id_dept)
    {   
    	$data = array(
               'uIDdepartement' => ''
            );
            
	$this->db->where('uIDdepartement', $id_dept);
	$this->db->update('user', $data);     
    }
    
    function daftar_departement()
    {
        $this->db->where('dCode_departement !=', 'ADMIN');
        return $this->db->get('departement');
    
    }
    
    function update_announce($anoounce) {
        $data = array
            (
            'aAnnounce_content' => $anoounce
        );

        $this->db->where('aAnnounceid', 1);
        return $this->db->update('announce', $data);
    }

}

?>
