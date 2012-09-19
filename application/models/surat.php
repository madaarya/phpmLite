<?php

class Surat extends CI_Model {

  function __construct() {
    parent::__construct();
  }

// ----------------- surat keluar -------------------------------------------//
  function surat_keluar($page, $offset, $id_departement, $id_user, $jabatan, $order_column, $order_type) {
    if ($jabatan == 0 or $jabatan == 1) {
      $this->db->where("sIDdepartement", $id_departement);
      $this->db->or_where('sIDuser', $id_user);
    }
    $this->db->join('format_nomor', 'format_nomor.fFormat_nomorid = surat_keluar.sIDformat_nomor');
    $this->db->limit($page, $offset);
    $this->db->order_by($order_column, $order_type);
    return $this->db->get('surat_keluar');
  }

  function cari_surat($kategori, $kata, $id_departement, $id_user, $jabatan, $kode=NULL) {
    if ($jabatan == 0 or $jabatan == 1) {
      $this->db->where("sIDdepartement", $id_departement);
      $this->db->or_where('sIDuser', $id_user);
    }
    $this->db->join('format_nomor', 'format_nomor.fFormat_nomorid = surat_keluar.sIDformat_nomor');
    if ($kategori == 'sIDformat_nomor' and $kode != 'kosong') {
        $this->db->where('sIDformat_nomor', $kode);
    } else {
      $this->db->like($kategori, $kata);
    }
    return $this->db->get('surat_keluar');
  }

  function jumlah_surat_keluar($id_departement, $id_user, $jabatan) {
    if ($jabatan == 0 or $jabatan == 1) {
      $this->db->where("sIDdepartement", $id_departement);
    }
    return $this->db->get('surat_keluar');
  }

  function pilihan_format($id_departement) {
    $this->db->join('akses_format_nomor', 'akses_format_nomor.aIDformat_nomor = format_nomor.fFormat_nomorid');
    $this->db->where("aIDdepartement", $id_departement);
    return $this->db->get("format_nomor");
  }

  function tambah_surat_keluar($data) {
    $waktu = $this->ubah_format_date($data['tanggal']);
    $waktu_pembuatan = date("Y-m-d H:i:s");

    $data = array(
        'sJudul' => $data['judul'],
        'sBerkas' => $data['file'],
        'sKeterangan' => $data['keterangan'],
        'sWaktu' => $waktu,
        'sIDformat_nomor' => $data['jenis_surat'],
        'sKepada' => $data['kepada'],
        'sNomorfull' => $data['nomor_full'],
        'sDari' => $data['dari'],
        'sWaktu_pembuatan' => $waktu_pembuatan,
        'sIDdepartement' => $data['id_departement'],
        'sIDuser' => $data['id_user'],
        'sTembusan' => $data['tembusan']
    );

    $x = $this->db->insert('surat_keluar', $data);
    return $x;
  }

  function detail_surat_keluar($id) {
    $this->db->join('format_nomor', 'format_nomor.fFormat_nomorid = surat_keluar.sIDformat_nomor');
    $this->db->join('user', 'user.uUserid = surat_keluar.sIDuser');
    $this->db->where("sSurat_keluarid", $id);
    return $this->db->get("surat_keluar");
  }

  function edit_surat_keluar($data, $id_surat) {
    $waktu = $this->ubah_format_date($data['tanggal']);

    $waktu_pembuatan = date("Y-m-d H:i:s");

    if (empty($data['file'])) {
      $data = array(
          'sJudul' => $data['judul'],
          'sKeterangan' => $data['keterangan'],
          'sWaktu' => $waktu,
          'sKepada' => $data['kepada'],
          'sDari' => $data['dari'],
          'sTembusan' => $data['tembusan'],
          'sWaktu_pembuatan' => $waktu_pembuatan
      );
    } else {
      $data = array(
          'sJudul' => $data['judul'],
          'sBerkas' => $data['file'],
          'sKeterangan' => $data['keterangan'],
          'sWaktu' => $waktu,
          'sKepada' => $data['kepada'],
          'sDari' => $data['dari'],
          'sTembusan' => $data['tembusan'],
          'sWaktu_pembuatan' => $waktu_pembuatan
      );
    }

    $this->db->where('sSurat_keluarid', $id_surat);
    return $this->db->update('surat_keluar', $data);
  }

// ----------------- end surat keluar --------------------------------------//    	
// ----------------- penomoran surat -------------------------------------------//
  function format_nomor($page, $offset, $id_departement, $jabatan, $order_column, $order_type) {
    if ($jabatan == 0 or $jabatan == 1) {
      $this->db->join('akses_format_nomor', 'akses_format_nomor.aIDformat_nomor = format_nomor.fFormat_nomorid');
      $this->db->where("aIDdepartement", $id_departement);
    }

    $this->db->limit($page, $offset);
    $this->db->order_by($order_column, $order_type);
    $q = $this->db->get('format_nomor');
    return $q;
  }

  function hitung_format_nomor($id_departement, $jabatan) {
    if ($jabatan == 0 or $jabatan == 1) {
      $this->db->join('akses_format_nomor', 'akses_format_nomor.aIDformat_nomor = format_nomor.fFormat_nomorid');
      $this->db->where("aIDdepartement", $id_departement);
    }

    $q = $this->db->get('format_nomor');
    return $q;
  }

  function ambil_format($id) {
    $this->db->join('multiple_format_nomor', 'multiple_format_nomor.mIDformat_nomor = format_nomor.fFormat_nomorid');
    $this->db->where("fFormat_nomorid", $id);
    return $this->db->get("format_nomor");
  }

  function tambah_format_nomor($jenis_surat, $deskripsi=null) {
    $data = array(
        'fDeskripsi' => $deskripsi,
        'fJenis_surat' => $jenis_surat
    );

    $this->db->insert('format_nomor', $data);
    return $this->db->insert_id();
  }

  function tambah_akses_nomor($idformat_nomor, $id_departement) {
    $data = array(
        'aIDformat_nomor' => $idformat_nomor,
        'aIDdepartement' => $id_departement
    );

    $this->db->insert('akses_format_nomor', $data);
  }

  function hapus_akses_lama($id_format) {
    $this->db->delete('akses_format_nomor', array('aIDformat_nomor' => $id_format));
  }

  function update_session_surat($id_session, $nomor_full) {
    $data = array(
        'nNomor_full' => $nomor_full
    );

    $this->db->where("nNomor_sessionid", $id_session);
    $this->db->update('nomor_session', $data);
  }

  function update_format_nomor($id_format, $jenis_surat, $deskripsi=null) {
    $data = array(
        'fDeskripsi' => $deskripsi,
        'fJenis_surat' => $jenis_surat
    );

    $this->db->where("fFormat_nomorid", $id_format);
    $this->db->update('format_nomor', $data);
  }

  function hapus_format_nomor_lama($id_format) {
    $this->db->delete('multiple_format_nomor', array('mIDformat_nomor' => $id_format));
  }

  function tambah_multiple($nomor_urut, $delimiter, $isi, $id_masuk) {
    $data = array(
        'mIDformat_nomor' => $id_masuk,
        'mDelimiter' => $delimiter,
        'mUrutan' => $nomor_urut,
        'mIsi' => $isi
    );

    $this->db->insert('multiple_format_nomor', $data);
  }

  /* function update_multiple($nomor_urut,$delimiter,$isi,$id_format,$id_multiple)
    {
    $data = array(
    'mIDformat_nomor' => $id_format,
    'mDelimiter' => $delimiter,
    'mUrutan' => $nomor_urut,
    'mIsi' => $isi
    );

    $this->db->where("mMultiple_format_nomor",$id_multiple);
    $this->db->where("mIDformat_nomor",$id_format);
    $this->db->update('multiple_format_nomor', $data);

    } */

  function get_format($id_format) {
    $this->db->order_by("mUrutan", "asc");
    $this->db->where("mIDformat_nomor", $id_format);
    return $this->db->get("multiple_format_nomor")->result();
  }

  function ambil_kode_dept($id) {
    $kode = $this->db->get_where("departement", array("dDepartementid" => $id))->row("dCode_departement");
    return $kode;
  }

  function ambil_nomor_akhir($id_format) {
    $no = $this->ambil_nomor_max($id_format)->row('nJumlah');
    return $no + 1;
  }

  function ambil_nomor_terakhir($id_format) {
    $no_session = $this->ambil_nomor_max($id_format)->row('nJumlah');
    $no_start = $this->ambil_nomor_start($id_format);

    if ($no_session == null) {
      return $no_start;
    } else {
      return $no_session;
    }
  }

  function ambil_nomor_max($id_format) {
    $this->db->select_max('nJumlah');
    $this->db->where('nJenis_surat', $id_format);
    return $this->db->get('nomor_session');
  }

  function ambil_nomor_start($id_format) {
    $hasil = $this->db->get_where('multiple_format_nomor', array("mIDformat_nomor" => $id_format));
    foreach ($hasil->result() as $h) {
      $f = explode('+', $h->mIsi);

      if ($f[0] == 'start') {
        $nomor = $f[1];
      }
    }

    return (int) $nomor;
  }

  function cek_nomor($id_format) {
    $r = $this->ambil_nomor_max($id_format)->row('nJumlah');
    if ($r == null) {
      return false;
    } else {
      return true;
    }
  }

  function tambah_sementara_nomor($id_format, $data) {
    $cek = $this->cek_nomor($id_format);
    if ($cek) {
      $no = $this->ambil_nomor_akhir($id_format);
    } else {
      $no = $this->ambil_nomor_start($id_format);
    }

    $tanggal = $this->ubah_format_date($data['tanggal']);

    $data = array(
        'nJenis_surat' => $id_format,
        'nJumlah' => $no,
        'nIDformat_nomor' => $data['jenis_surat'],
        'nTanggal' => $tanggal,
        'nJudul' => $data['judul'],
        'nKepada' => $data['kepada'],
        'nDari' => $data['dari'],
        'nKeterangan' => $data['keterangan'],
        'nIDdepartement' => $data['departement'],
        'nIDuser' => $data['id_user'],
        'nTembusan' => $data['tembusan']
    );

    $this->db->insert('nomor_session', $data);

    return $this->db->insert_id();
  }

// ----------------- end format nomor --------------------------------------//  
// -------------------- Laporam nodule ----------------------------//

  function laporan($tanggal_awal, $tanggal_akhir) {
    $tgl_awal = $this->ubah_format_date($tanggal_awal);
    $tgl_akhir = $this->ubah_format_date($tanggal_akhir);

    $this->db->where('sWaktu >=', $tgl_awal);
    $this->db->where('sWaktu <=', $tgl_akhir);

    return $this->db->get("surat_keluar");
  }

  function print_laporan($tanggal_awal, $tanggal_akhir) {

    $this->db->where('sWaktu >=', $tanggal_awal);
    $this->db->where('sWaktu <=', $tanggal_akhir);

    return $this->db->get("surat_keluar");
  }

  function tambah_user_special($id_user, $id_departement) {
    $data = array(
        'uIDuser' => $id_user,
        'uIDdepartement' => $id_departement,
    );

    $this->db->insert('user_special', $data);
  }

  function ubah_format_date($date) {
    $w = explode("/", $date);
    $waktu = $w[2] . "-" . $w[1] . "-" . $w[0];
    return $waktu;
  }

}
