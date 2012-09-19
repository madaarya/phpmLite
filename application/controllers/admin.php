<?php
/*
  Modul      :
  Tipe       :
  Lokasi     :
  programmer : Mada Aryakusumah
  email      : lokermada@gmail.com
  deskripsi  :
 */

class Admin extends MY_Controller {

  var $tabel = array(
      'table_open' => '<table class="table table-hover table-striped table-bordered">',
      'heading_row_start' => '<tr>',
      'heading_row_end' => '</tr>',
      'heading_cell_start' => '<th style="text-align:center">',
      'heading_cell_end' => '</th>',
      'row_start' => '<tr>',
      'row_end' => '</tr>',
      'cell_start' => '<td style="text-align:center">',
      'cell_end' => '</td>',
      'row_alt_start' => '<tr>',
      'row_alt_end' => '</tr>',
      'cell_alt_start' => '<td style="text-align:center">',
      'cell_alt_end' => '</td>',
      'table_close' => '</table>'
  );
  var $image_edit = array(
      'src' => 'assets/images/edit.png',
      'alt' => 'Edit',
  );
  var $image_delete = array(
      'src' => 'assets/images/delete.png',
      'alt' => 'Delete',
  );

  function __construct() {
    parent::__construct();
    $this->load->model(array('Surat', 'User'));


    if ($this->session->userdata('login') == NULL) {
      redirect('login');
    }
  }

// ----------------------------- Surat keluar CRUD module --------------------------------------

  function index() {
    if ($this->session->userdata('status_upload') == 1) {
      $this->upload_berkas();
    } else {
      $data['departement'] = $this->db->get_where('departement',array('dDepartementid'=>$this->session->userdata('departement')))->row('dKeterangan');
      $data['announce'] = $this->db->get_where('announce',array('aAnnounceid'=>1))->row('aAnnounce_content');
      $this->tampilan->tampil_admin('admin/home_admin', $data);
    }
  }

  function home() {
    $this->index();
  }

  // list surat keluar
  function surat_keluar($offset=null, $order_column=NULL, $order_type=NULL) {
    if ($this->session->userdata('status_upload') == 1) {
      $this->upload_berkas();
    } else {
      $this->load->helper('text');
      $id_departement = $this->session->userdata("departement");
      $jabatan = $this->session->userdata("jabatan");

      $id_user = $this->session->userdata('userid');
      $this->load->library('pagination');
      $config['base_url'] = site_url('admin/surat_keluar');
      $config['total_rows'] = $this->Surat->jumlah_surat_keluar($id_departement, $id_user, $jabatan)->num_rows();
      $config['per_page'] = 9;
      $config['num_links'] = 3;
      $config['uri_segment'] = 3;
      $config['next_link'] = '»';
      $config['prev_link'] = '«';
      $config['first_tag_open'] = '<li>';
      $config['first_tag_close'] = '</li>';

      $config['last_tag_open'] = '<li>';
      $config['last_tag_close'] = '</li>';

      $config['full_tag_open'] = '<div class="pagination"><ul>';
      $config['full_tag_close'] = '</div>';
      $config['num_tag_open'] = '<li>';
      $config['num_tag_close'] = '</li>';
      $config['cur_tag_open'] = '<li class="active"><a>';
      $config['cur_tag_close'] = '</a></li>';

      $this->pagination->initialize($config);
      $offset = $this->uri->segment(3);
      if (empty($offset)) {
        $offset = 0;
        $i = 1;
      } else {
        $i = $offset + 1;
      }

      if (empty($order_column))
        $order_column = 'sWaktu_pembuatan';
      if (empty($order_type))
        $order_type = 'asc';
      $new_order = ($order_type == 'asc' ? 'desc' : 'asc');

      $surat = $this->Surat->surat_keluar($config['per_page'], $offset, $id_departement, $id_user, $jabatan, $order_column, $order_type);

      $hak = $this->db->get_where('hak_akses', array('uIDuser' => $id_user));
      $akses = $hak->row();

      $arr_surat = explode("|", $akses->uSurat_keluar);
      if (in_array("n", $arr_surat)) {
        $data['tombol_new'] = anchor("admin/tambah_surat_keluar", '<i class="icon-plus icon-white"></i> Tambah Surat', 'class="btn btn-primary"');
      } else {
        $data['tombol_new'] = '';
      }
      // action button				
      $this->table->set_template($this->tabel);

      if (in_array("e", $arr_surat) or in_array("e", $arr_surat)) {
        $this->table->set_heading('No', anchor('admin/surat_keluar/' . $offset . '/sJudul/' . $new_order, 'Perihal'), anchor('admin/surat_keluar/' . $offset . '/sIDformat_nomor/' . $new_order, 'Jenis Surat'), anchor('admin/surat_keluar/' . $offset . '/sNomorfull/' . $new_order, 'Nomor'), 'File', 'Action');
      } else {
        $this->table->set_heading('No', anchor('admin/surat_keluar/' . $offset . '/sJudul/' . $new_order, 'Perihal'), anchor('admin/surat_keluar/' . $offset . '/sIDformat_nomor/' . $new_order, 'Jenis Surat'), anchor('admin/surat_keluar/' . $offset . '/sNomorfull/' . $new_order, 'Nomor'), 'File');
      }

      foreach ($surat->result() as $s) {

        if (in_array("e", $arr_surat)) {
          $tombol_edit = anchor("admin/edit_surat_keluar/" . base64_encode($s->sSurat_keluarid), img($this->image_edit), array("rel" => "tooltip", "title" => "Edit"));
        } else {
          $tombol_edit = '';
        }

        if (in_array("d", $arr_surat)) {
          $tombol_delete = anchor("admin/hapus_surat_keluar/" . base64_encode($s->sSurat_keluarid), img($this->image_delete), array("onClick" => "return confirm('anda yakin tuk menghapus surat ini?')", "rel" => "tooltip", "title" => "Delete"));
        } else {
          $tombol_delete = '';
        }

        $this->table->add_row(
                $i++, word_limiter(anchor("admin/detail_surat_keluar/" . base64_encode($s->sSurat_keluarid), $s->sJudul), 5), $s->fJenis_surat, $s->sNomorfull, anchor("admin/ambil/" . $s->sBerkas, $s->sBerkas), $tombol_edit . nbs(5) . $tombol_delete
        );
      }
      $data['surat'] = $this->table->generate();

      $this->tampilan->tampil_admin('admin/surat_keluar', $data);
    }
  }

  function cari_surat() {
    $kategori = $this->input->get('kategori');
    $kata = $this->input->get('kata');

    $id_departement = $this->session->userdata("departement");
    $jabatan = $this->session->userdata("jabatan");
    $id_user = $this->session->userdata('userid');

    if ($kategori == 'sIDformat_nomor') {
      $query = $this->db->get_where('format_nomor', array('fJenis_surat' => $kata));
      if ($query->num_rows() == 0) {
        $kode = 'kosong';
      } else {
        $kode = $query->row('fFormat_nomorid');
      }
    } else {
      $kode = NULL;
    }

    $surat = $this->Surat->cari_surat($kategori, $kata, $id_departement, $id_user, $jabatan, $kode);

    $jml = $surat->num_rows();

    if ($jml == 0) {
      $data['surat'] = 'maaf data yang anda cari tidak ada';
    } else {

      $hak = $this->db->get_where('hak_akses', array('uIDuser' => $id_user));
      $akses = $hak->row();

      $arr_surat = explode("|", $akses->uSurat_keluar);
      if (in_array("n", $arr_surat)) {
        $data['tombol_new'] = anchor("admin/tambah_surat_keluar", '<i class="icon-plus icon-white"></i> Tambah Surat', 'class="btn btn-primary"');
      } else {
        $data['tombol_new'] = '';
      }
      // action button				
      $this->table->set_template($this->tabel);
      $this->table->set_heading('Judul', 'Jenis Surat', 'Nomor', 'File', 'Action');
      foreach ($surat->result() as $s) {

        if (in_array("e", $arr_surat)) {
          $tombol_edit = anchor("admin/edit_surat_keluar/" . base64_encode($s->sSurat_keluarid), img($this->image_edit), array("rel" => "tooltip", "title" => "Edit"));
        } else {
          $tombol_edit = '';
        }

        if (in_array("d", $arr_surat)) {
          $tombol_delete = anchor("admin/hapus_surat_keluar/" . base64_encode($s->sSurat_keluarid), img($this->image_delete), array("onClick" => "return confirm('anda yakin tuk menghapus surat ini?')", "rel" => "tooltip", "title" => "Delete"));
        } else {
          $tombol_delete = '';
        }
        //$i = 0+$offset;
        $this->table->add_row(
                anchor("admin/detail_surat_keluar/" . base64_encode($s->sSurat_keluarid), $s->sJudul), $s->fJenis_surat, $s->sNomorfull, anchor("admin/ambil/" . $s->sBerkas, $s->sBerkas), $tombol_edit . nbs(5) . $tombol_delete
        );
      }
      $data['surat'] = $this->table->generate();
    }

    $this->tampilan->tampil_admin('admin/cari_surat', $data);
  }

  function detail_surat_keluar($id_surat) {
    $id = base64_decode($id_surat);
    $data['surat_keluar'] = $this->Surat->detail_surat_keluar($id);
    $this->tampilan->tampil_admin('admin/detail_surat_keluar', $data);
  }

  function ambil($nama) {
    header('Content-type: document/doc');

    header('Content-Disposition: attachment; filename="' . $nama . '"');

    readfile('./assets/documents/' . $nama);
  }

  // hapus surat keluar
  function hapus_surat_keluar($id_surat) {
    $id = base64_decode($id_surat);
    /*
      $berkas = $this->db->get_where("surat_keluar",array("sSurat_keluarid"=>$id_surat))->row("sBerkas");

      unlink("./assets/documents/".$berkas);
     */
    $this->db->delete('surat_keluar', array('sSurat_keluarid' => $id));
    $this->session->set_flashdata('sukses', 'data berhasil di hapus');
    redirect('admin/surat_keluar');
  }

  // tambah surat keluar
  function tambah_surat_keluar($data=null) {
    $id_departement = $this->session->userdata("departement");
    $id_user = $this->session->userdata('userid');
    $data['jenis_surat'] = $this->Surat->pilihan_format($id_departement);

    if ($this->session->userdata('status_special') == 1) {
      $data['departement'] = $this->User->departement_user_spesial($id_user);
    }


    $this->tampilan->tampil_admin('admin/tambah_surat', $data);
  }

  // proses tambah surat keluar
  function proses_tambah_surat_keluar() {
    $data['jenis_surat'] = $this->input->post('jenis_surat');
    $data['tanggal'] = $this->input->post('tanggal');
    $data['keterangan'] = $this->input->post('keterangan');
    $data['dari'] = $this->input->post('dari');
    $data['judul'] = $this->input->post('judul');
    $data['kepada'] = $this->input->post('kepada');
    $data['tembusan'] = $this->input->post('tembusan');

    if ($this->session->userdata('status_special') == 1) {
      $data['id_departement'] = $this->input->post('departement');
      $this->form_validation->set_rules('departement', 'Departement', 'required');
    }


    $this->form_validation->set_rules('judul', 'Judul', 'required|min_length[4]|max_length[30]');
    $this->form_validation->set_rules('jenis_surat', 'Jenis Surat', 'required');
    $this->form_validation->set_rules('tanggal', 'Tanggal surat', 'required');
    $this->form_validation->set_rules('kepada', 'Tujuan surat', 'required|min_length[4]|max_length[30]');
    $this->form_validation->set_rules('dari', 'Pengirim surat', 'required|min_length[4]|max_length[30]');


    if ($this->form_validation->run() == FALSE) {
      //$this->tambah_surat_keluar();
      echo validation_errors();
    } else {
      //$this->form_kirim_surat($data);
      //$this->konfirmasi_suratkeluar($data);
      $surat_baru = array('jenis_surat' => $data['jenis_surat'],
          'tanggal' => $data['tanggal'],
          'keterangan' => $data['keterangan'],
          'dari' => $data['dari'],
          'judul' => $data['judul'],
          'kepada' => $data['kepada'],
          'tembusan' => $data['tembusan']
      );
      if ($this->session->userdata('status_special') == 1) {
        $surat_baru['id_departement'] = $data['id_departement'];
      }
      $this->session->set_userdata($surat_baru);
      echo "1";
    }
  }

  function konfirmasi_suratkeluar($data=NULL) {

    $id_jenis = $this->session->userdata("jenis_surat");
    $data['jenis_surat'] = $this->db->get_where("format_nomor", array("fFormat_nomorid" => $id_jenis))->row("fJenis_surat");
    $data['id_jenis'] = $id_jenis;

    $data['tanggal'] = $this->session->userdata('tanggal');
    $data['keterangan'] = $this->session->userdata('keterangan');
    $data['dari'] = $this->session->userdata('dari');
    $data['judul'] = $this->session->userdata('judul');
    $data['kepada'] = $this->session->userdata('kepada');

    $data['tembusan'] = $this->session->userdata('tembusan');

    if ($this->session->userdata('status_special') == 1) {
      $data['departement'] = $this->db->get_where('departement', array('dDepartementid' => $this->session->userdata('id_departement')))->row('dKeterangan');
    } else {
      $data['departement'] = $this->db->get_where('departement', array('dDepartementid' => $this->session->userdata('departement')))->row('dKeterangan');
    }

    //$this->tampilan->tampil_admin('admin/konfirmasi_suratkeluar',$data);
    $this->load->view('admin/konfirmasi_suratkeluar', $data);
  }

  function form_kirim_surat($data=NULL) {
    $data['jenis_surat'] = $this->session->userdata("jenis_surat");
    $data['tanggal'] = $this->session->userdata('tanggal');
    $data['keterangan'] = $this->session->userdata('keterangan');
    $data['dari'] = $this->session->userdata('dari');
    $data['judul'] = $this->session->userdata('judul');
    $data['kepada'] = $this->session->userdata('kepada');

    $data['id_user'] = $this->session->userdata('userid');

    $data['tembusan'] = $this->session->userdata('tembusan');
    //$data['id_departement'] = $this->session->userdata('departement');

    if ($this->session->userdata('status_special') == 1) {
      $data['departement'] = $this->session->userdata('id_departement');
    } else {
      $data['departement'] = $this->session->userdata('departement');
    }

    $id_format = $data['jenis_surat'];
    $data['hasil'] = $this->Surat->get_format($id_format);
    $data['count'] = count($data['hasil']);

    $data['id_nomor_session'] = $this->Surat->tambah_sementara_nomor($id_format, $data);
    $this->User->update_status($data['id_user'], $data['id_nomor_session']);

    $data['jenis'] = "asal";

    $this->tampilan->tampil_upload('admin/form_kirim_surat', $data);
  }

  function update_session_surat() {
    $id_session = $this->input->post('id_session');
    $nomor_full = $this->input->post('nomor_full');

    $this->Surat->update_session_surat($id_session, $nomor_full);
    echo "1";
  }

  function upload_berkas() {
    $id_format = $this->session->userdata("nomor_session");
    $d = $this->db->get_where("nomor_session", array("nNomor_sessionid" => $id_format));
    $w = $d->row();

    $se = explode("-", $w->nTanggal);
    $waktu = $se[2] . "/" . $se[1] . "/" . $se[0];

    $data['jenis_surat'] = $w->nIDformat_nomor;
    $data['tanggal'] = $waktu;
    $data['keterangan'] = $w->nKeterangan;
    $data['dari'] = $w->nDari;
    $data['judul'] = $w->nJudul;
    $data['kepada'] = $w->nKepada;
    $data['tembusan'] = $w->nTembusan;
    $data['departement'] = $w->nIDdepartement;
    $data['id_user'] = $w->nIDuser;

    $data['nomor_full'] = $w->nNomor_full;
    $data['jenis'] = "window_close";

    $this->tampilan->tampil_upload('admin/form_kirim_surat', $data);
  }

  function proses_confirm_surat_keluar() {
    //$data['nomor_surat'] = $this->input->post('nomor_surat');
    $data['nomor_full'] = $this->input->post('format_full');

    $data['jenis_surat'] = $this->input->post('jenis_surat');
    $data['tanggal'] = $this->input->post('tanggal');
    $data['keterangan'] = $this->input->post('keterangan');
    $data['dari'] = $this->input->post('dari');
    $data['judul'] = $this->input->post('judul');
    $data['kepada'] = $this->input->post('kepada');

    $data['tembusan'] = $this->input->post('tembusan');
    $data['id_user'] = $this->input->post('id_user');
    $data['id_departement'] = $this->input->post('id_departement');

    $config['upload_path'] = './assets/documents/';
    $config['allowed_types'] = 'doc|docx|xls|pdf|xlsx';
    $config['max_size'] = '2048';

    $this->load->library('upload', $config);
    $this->upload->initialize($config);
    $m = $this->upload->do_upload('berkas');
    $data['file'] = $this->upload->file_name;

    if (!$m) {
      $data['error'] = $this->upload->display_errors();
      $data['jenis'] = "window_close";
      $data['departement'] = $data['id_departement'];
      $this->tampilan->tampil_admin('admin/form_kirim_surat', $data);
    } else {
      $id_user = $this->session->userdata("userid");
      $masuk = $this->Surat->tambah_surat_keluar($data);
      $this->User->update_upload($id_user);
      $this->session->unset_userdata('status_upload');

      if ($masuk) {
        $this->session->set_flashdata('sukses', 'data baru berhasil di tambah');
        redirect('admin/surat_keluar');
      }
    }
  }

  // edit surat keluar
  function edit_surat_keluar($id_surat) {
    $id = base64_decode($id_surat);
    $data['surat'] = $this->Surat->detail_surat_keluar($id);
    $this->tampilan->tampil_admin('admin/edit_surat_keluar', $data);
  }

  // proses edit surat keluar
  function proses_edit_surat_keluar($data=null) {
    $data['tanggal'] = $this->input->post('tanggal');
    $data['keterangan'] = $this->input->post('keterangan');
    $data['dari'] = $this->input->post('dari');
    $data['judul'] = $this->input->post('judul');
    $data['kepada'] = $this->input->post('kepada');
    $data['tembusan'] = $this->input->post('tembusan');
    $id_surat = $this->input->post('id_surat');

    $this->form_validation->set_rules('judul', 'Judul', 'required|min_length[4]|max_length[30]');
    $this->form_validation->set_rules('tanggal', 'Tanggal surat', 'required');
    $this->form_validation->set_rules('kepada', 'Tujuan surat', 'required|min_length[4]|max_length[30]');
    $this->form_validation->set_rules('dari', 'Pengirim surat', 'required|min_length[4]|max_length[30]');

    if ($this->form_validation->run() == FALSE) {
      $id = base64_encode($id_surat);
      $this->edit_surat_keluar($id);
    } else {
      $config['upload_path'] = './assets/documents/';
      $config['allowed_types'] = 'doc|docx|xls|pdf';
      $config['max_size'] = '2048';

      $this->load->library('upload', $config);
      $this->upload->initialize($config);
      $m = $this->upload->do_upload('berkas');
      $data['file'] = $this->upload->file_name;
      $masuk = $this->Surat->edit_surat_keluar($data, $id_surat);
      if ($masuk) {
        $this->session->set_flashdata('sukses', 'data berhasil di perbaharui');
        redirect('admin/surat_keluar');
      }
    }
  }

// ----------------------------- end module surat keluar --------------------------------------------	
// ----------------------------- Surat format surat CRUD module --------------------------------------
  // list format nomor
  function format_nomor($offset=null, $order_column=NULL, $order_type=NULL) {
    if ($this->session->userdata('status_upload') == 1) {
      $this->upload_berkas();
    } else {
      $this->load->helper('text');
      $id_departement = $this->session->userdata("departement");
      $jabatan = $this->session->userdata("jabatan");
      $id_user = $this->session->userdata('userid');

      $this->load->library('pagination');
      $config['base_url'] = site_url('admin/format_nomor');
      $config['total_rows'] = $this->Surat->hitung_format_nomor($id_departement, $jabatan)->num_rows();
      $config['per_page'] = 9;
      $config['num_links'] = 3;
      $config['uri_segment'] = 3;
      $config['next_link'] = '»';
      $config['prev_link'] = '«';
      $config['first_tag_open'] = '<li>';
      $config['first_tag_close'] = '</li>';

      $config['last_tag_open'] = '<li>';
      $config['last_tag_close'] = '</li>';

      $config['full_tag_open'] = '<div class="pagination"><ul>';
      $config['full_tag_close'] = '</div>';
      $config['num_tag_open'] = '<li>';
      $config['num_tag_close'] = '</li>';
      $config['cur_tag_open'] = '<li class="active"><a>';
      $config['cur_tag_close'] = '</a></li>';
      $this->pagination->initialize($config);
      $offset = $this->uri->segment(3);
      if (empty($offset)) {
        $offset = 0;
      }

      if (empty($order_column))
        $order_column = 'fJenis_surat';
      if (empty($order_type))
        $order_type = 'asc';
      $new_order = ($order_type == 'asc' ? 'desc' : 'asc');

      $nomor = $this->Surat->format_nomor($config['per_page'], $offset, $id_departement, $jabatan, $order_column, $order_type);

      $hak = $this->db->get_where('hak_akses', array('uIDuser' => $id_user));
      $akses = $hak->row();

      $arr_format = explode("|", $akses->uFormat_surat);
      if (in_array("n", $arr_format)) {
        $data['tombol_new'] = anchor("admin/tambah_format_nomor", '<i class="icon-plus icon-white"></i> Tambah format nomor', 'class="btn btn-primary"');
      } else {
        $data['tombol_new'] = '';
      }


      $this->table->set_template($this->tabel);
      if (in_array("e", $arr_format) or in_array("e", $arr_format)) {
        $this->table->set_heading(anchor('admin/format_nomor/' . $offset . '/fJenis_surat/' . $new_order, 'Jenis Surat'), 'Deskripsi', 'Action');
      } else {
        $this->table->set_heading(anchor('admin/format_nomor/' . $offset . '/fJenis_surat/' . $new_order, 'Jenis Surat'), 'Deskripsi');
      }

      foreach ($nomor->result() as $n) {

        if (in_array("e", $arr_format)) {
          $tombol_edit = anchor("admin/edit_format_nomor/" . $n->fFormat_nomorid, img($this->image_edit), array("rel" => "tooltip", "title" => "Edit"));
        } else {
          $tombol_edit = '';
        }

        if (in_array("d", $arr_format)) {
          $tombol_delete = anchor("admin/hapus_format_nomor/" . $n->fFormat_nomorid, img($this->image_delete), array("onClick" => "return confirm('anda yakin tuk menghapus format nomor ini?')", "rel" => "tooltip", "title" => "Delete"));
        } else {
          $tombol_delete = '';
        }


        $this->table->add_row(
                $n->fJenis_surat, word_limiter($n->fDeskripsi, 10), $tombol_edit . nbs(5) . $tombol_delete
        );
      }
      $data['nomor'] = $this->table->generate();

      $this->tampilan->tampil_admin('admin/format_nomor', $data);
    }
  }

  // hapus format nomor
  function hapus_format_nomor($id) {
    $id_departement = $this->session->userdata("departement");
    $jabatan = $this->session->userdata("jabatan");

    if ($jabatan == 0 or $jabatan == 1) {
      $this->db->delete('akses_format_nomor', array('aIDformat_nomor' => $id, 'aIDdepartement' => $id_departement));
    } else {
      $this->db->delete('multiple_format_nomor', array('mIDformat_nomor' => $id));
      $this->db->delete('format_nomor', array('fFormat_nomorid' => $id));
    }

    $this->session->set_flashdata('sukses', 'data berhasil di hapus');
    redirect('admin/format_nomor');
  }

  // tambah format nomor
  function tambah_format_nomor($data=null) {
    $data['departement'] = $this->db->get('departement');
    $this->tampilan->tampil_admin('admin/tambah_format_nomor', $data);
  }

  // proses tambah format nomor
  function proses_tambah_format_nomor() {
    $departement = $this->input->post("departement");
    $jumlah_dept = count($departement);

    $nol = $this->input->post("field_satu");
    $satu = $this->input->post("field_dua");
    $dua = $this->input->post("field_tiga");
    $tiga = $this->input->post("field_empat");
    $empat = $this->input->post("field_lima");

    $this->form_validation->set_rules('departement[]', 'Hak akses depertement', 'required');
    $this->form_validation->set_rules('field_satu', 'Nomor Urut Jenis Surat', 'required|is_natural_no_zero|less_than[6]');
    $this->form_validation->set_rules('field_isi_satu', 'Jenis Surat', 'required|callback_cek_title');
    $this->form_validation->set_rules('field_dua', 'Nomor urut departement', 'required|is_natural_no_zero|less_than[6]');

    $this->form_validation->set_rules('field_delimiter_satu', 'Delimiter jenis surat', 'max_length[7]');
    $this->form_validation->set_rules('field_delimiter_dua', 'Delimiter kode departement', 'max_length[7]');
    $this->form_validation->set_rules('field_delimiter_tiga', 'Delimiter format bulan', 'max_length[7]');
    $this->form_validation->set_rules('field_delimiter_empat', 'Delimiter format tahun', 'max_length[7]');
    $this->form_validation->set_rules('field_delimiter_lima', 'Delimiter nomor', 'max_length[7]');

    $this->form_validation->set_rules('field_isi_tiga', 'Format bulan', 'max_length[20]');
    $this->form_validation->set_rules('field_isi_empat', 'Format tahun', 'max_length[20]');
    $this->form_validation->set_rules('field_isi_lima', 'Format nomor', 'is_natural');

    $this->form_validation->set_rules('field_tiga', 'Nomor urut format bulan', 'is_natural_no_zero|less_than[6]');
    $this->form_validation->set_rules('field_empat' . 'Nomor urut format tahun', 'is_natural_no_zero|less_than[6]');
    $this->form_validation->set_rules('field_lima', 'Nomor urut nomor', 'is_natural_no_zero|less_than[6]');
    $this->form_validation->set_rules('deskripsi', 'Deskripsi', 'max_length[30]');

    if (!empty($nol)) {
      $field[0] = $nol;
    }

    if (!empty($satu)) {
      $field[1] = $satu;
    }

    if (!empty($dua)) {
      $field[2] = $dua;
    }

    if (!empty($tiga)) {
      $field[3] = $tiga;
    }

    if (!empty($empat)) {
      $field[4] = $empat;
    }

    $jenis_surat = $this->input->post("field_isi_satu");

    $fieldtampung_isi[0] = $this->input->post("field_isi_satu");
    $fieldtampung_isi[1] = $this->input->post("field_isi_dua");
    $fieldtampung_isi[2] = $this->input->post("field_isi_tiga");
    $fieldtampung_isi[3] = $this->input->post("field_isi_empat");
    $fieldtampung_isi[4] = $this->input->post("field_isi_lima");

    $deskripsi = $this->input->post("deskripsi");

    if (isset($field)) {
      $arr_unik = array_unique($field);
      $jml_unik = count($arr_unik);
      $field_masuk = count($field);
    }

    for ($i = 0; $i < 5; $i++) {
      if (!empty($field[$i]) && empty($fieldtampung_isi[$i])) {
        $data['error'][$i] = "field isi pada nomor urut " . $field[$i] . " harus di isi";
      }
    }

    if (empty($nol) && empty($satu) && empty($dua) && empty($tiga) && empty($empat) && empty($fieldtampung_isi[2]) && empty($fieldtampung_isi[3]) && empty($fieldtampung_isi[4])) {
      $this->tambah_format_nomor();
    } elseif ($this->form_validation->run() == FALSE) {
      $this->tambah_format_nomor();
    } elseif ($jml_unik != $field_masuk) {
      $data['error_wajib'] = "Maaf Nomor urut tidak dapat duplikat";
      $this->tambah_format_nomor($data);
    } elseif (isset($data['error'])) {
      $data['jumlah_error'] = count($data['error']);
      $this->tambah_format_nomor($data);
    } elseif (!empty($fieldtampung_isi[4])) {
      $split = str_split($fieldtampung_isi[4]);
      if (!preg_match('/^[0-9]+$/', $fieldtampung_isi[4])) {
        $data['error_wajib'] = "Maaf field nomor hanya dapat di isi oleh angka";
        $this->tambah_format_nomor($data);
      } elseif ($split[0] == 0 and $split[1] == 0 and $split[2] == 0 and $split[3] == 0 and $split[4] == 0) {
        $data['error_wajib'] = "Maaf angka nol di depan angka utama di field nomor maksimal berjumlah 4";
        $this->tambah_format_nomor($data);
      } else {
        $id_masuk = $this->Surat->tambah_format_nomor($jenis_surat, $deskripsi);

        if ($jumlah_dept > 0) {
          for ($i = 0; $i < $jumlah_dept; $i++) {
            $this->Surat->tambah_akses_nomor($id_masuk, $departement[$i]);
          }
        }

        $field_delimiter[0] = $this->input->post("field_delimiter_satu");
        $field_delimiter[1] = $this->input->post("field_delimiter_dua");
        $field_delimiter[2] = $this->input->post("field_delimiter_tiga");
        $field_delimiter[3] = $this->input->post("field_delimiter_empat");
        $field_delimiter[4] = $this->input->post("field_delimiter_lima");

        $field_isi[0] = "jenis+" . $fieldtampung_isi[0];
        $field_isi[1] = "dept+" . $fieldtampung_isi[1];
        $field_isi[2] = "bulan+" . $fieldtampung_isi[2];
        $field_isi[3] = "tahun+" . $fieldtampung_isi[3];
        $field_isi[4] = "start+" . $fieldtampung_isi[4];

        for ($i = 0; $i < 5; $i++) {
          if (!empty($field[$i])) {
            $this->Surat->tambah_multiple($field[$i], $field_delimiter[$i], $field_isi[$i], $id_masuk);
          }
        }

        $this->session->set_flashdata('sukses', 'data berhasil di tambah');
        redirect('admin/format_nomor');
      }
    } else {
      $id_masuk = $this->Surat->tambah_format_nomor($jenis_surat, $deskripsi);

      if ($jumlah_dept > 0) {
        for ($i = 0; $i < $jumlah_dept; $i++) {
          $this->Surat->tambah_akses_nomor($id_masuk, $departement[$i]);
        }
      }

      $field_delimiter[0] = $this->input->post("field_delimiter_satu");
      $field_delimiter[1] = $this->input->post("field_delimiter_dua");
      $field_delimiter[2] = $this->input->post("field_delimiter_tiga");
      $field_delimiter[3] = $this->input->post("field_delimiter_empat");
      $field_delimiter[4] = $this->input->post("field_delimiter_lima");

      $field_isi[0] = "jenis+" . $fieldtampung_isi[0];
      $field_isi[1] = "dept+" . $fieldtampung_isi[1];
      $field_isi[2] = "bulan+" . $fieldtampung_isi[2];
      $field_isi[3] = "tahun+" . $fieldtampung_isi[3];
      $field_isi[4] = "start+" . $fieldtampung_isi[4];

      for ($i = 0; $i < 5; $i++) {
        if (!empty($field[$i])) {
          $this->Surat->tambah_multiple($field[$i], $field_delimiter[$i], $field_isi[$i], $id_masuk);
        }
      }
      $this->session->set_flashdata('sukses', 'data berhasil di tambah');
      redirect('admin/format_nomor');
    }
  }

  // edit surat keluar
  function edit_format_nomor($id_format, $data=null) {

    $data['departement'] = $this->db->get('departement');
    $nomor = $this->Surat->ambil_format($id_format);

    foreach ($nomor->result() as $n) {
      $j = explode("+", $n->mIsi);
      $jenis = $j[0];
      $isi = $j[1];

      if ($jenis == "jenis") {
        $data['urutan_jenis'] = $n->mUrutan;
        $data['isi_jenis'] = $isi;
        $data['delimiter_jenis'] = $n->mDelimiter;
      }
      if ($jenis == "dept") {
        $data['urutan_dept'] = $n->mUrutan;
        $data['isi_dept'] = $isi;
        $data['delimiter_dept'] = $n->mDelimiter;
      }
      if ($jenis == "bulan") {
        $data['urutan_bulan'] = $n->mUrutan;
        $data['isi_bulan'] = $isi;
        $data['delimiter_bulan'] = $n->mDelimiter;
      }
      if ($jenis == "tahun") {
        $data['urutan_tahun'] = $n->mUrutan;
        $data['isi_tahun'] = $isi;
        $data['delimiter_tahun'] = $n->mDelimiter;
      }
      if ($jenis == "start") {
        $data['urutan_nomor'] = $n->mUrutan;
        $data['isi_nomor'] = $isi;
        $data['delimiter_nomor'] = $n->mDelimiter;
      }

      $data['id_format'] = $n->fFormat_nomorid;
      $data['deskripsi'] = $n->fDeskripsi;
    }

    $data['hak_akses'] = $this->db->get_where('akses_format_nomor', array('aIDformat_nomor' => $id_format));

    $this->tampilan->tampil_admin('admin/edit_format_nomor', $data);
  }

  // proses edit format nomor
  function proses_edit_format_nomor($data=null) {
    $departement = $this->input->post("departement");
    $jumlah_dept = count($departement);

    $nol = $this->input->post("field_satu");
    $satu = $this->input->post("field_dua");
    $dua = $this->input->post("field_tiga");
    $tiga = $this->input->post("field_empat");
    $empat = $this->input->post("field_lima");

    $id_format = $this->input->post('id_format');

    $title_database = $this->db->get_where('format_nomor', array("fFormat_nomorid" => $id_format))->row('fJenis_surat');

    $this->form_validation->set_rules('field_isi_satu', 'Jenis Surat', 'required');

    $this->form_validation->set_rules('departement[]', 'Hak akses depertement', 'required');
    $this->form_validation->set_rules('field_satu', 'Nomor Urut Jenis Surat', 'required|is_natural_no_zero|less_than[6]');

    $this->form_validation->set_rules('field_dua', 'Nomor urut departement', 'required|is_natural_no_zero|less_than[6]');

    $this->form_validation->set_rules('field_delimiter_satu', 'Delimiter jenis surat', 'max_length[7]');
    $this->form_validation->set_rules('field_delimiter_dua', 'Delimiter kode departement', 'max_length[7]');
    $this->form_validation->set_rules('field_delimiter_tiga', 'Delimiter format bulan', 'max_length[7]');
    $this->form_validation->set_rules('field_delimiter_empat', 'Delimiter format tahun', 'max_length[7]');
    $this->form_validation->set_rules('field_delimiter_lima', 'Delimiter nomor', 'max_length[7]');

    $this->form_validation->set_rules('field_isi_tiga', 'Format bulan', 'max_length[20]');
    $this->form_validation->set_rules('field_isi_empat', 'Format tahun', 'max_length[20]');
    $this->form_validation->set_rules('field_isi_lima', 'Format nomor', 'is_natural');

    $this->form_validation->set_rules('field_tiga', 'Nomor urut format bulan', 'is_natural_no_zero|less_than[6]');
    $this->form_validation->set_rules('field_empat' . 'Nomor urut format tahun', 'is_natural_no_zero|less_than[6]');
    $this->form_validation->set_rules('field_lima', 'Nomor urut nomor', 'is_natural_no_zero|less_than[6]');
    $this->form_validation->set_rules('deskripsi', 'Deskripsi', 'max_length[30]');

    if (!empty($nol)) {
      $field[0] = $nol;
    }

    if (!empty($satu)) {
      $field[1] = $satu;
    }

    if (!empty($dua)) {
      $field[2] = $dua;
    }

    if (!empty($tiga)) {
      $field[3] = $tiga;
    }

    if (!empty($empat)) {
      $field[4] = $empat;
    }

    $jenis_surat = $this->input->post("field_isi_satu");

    $fieldtampung_isi[0] = $this->input->post("field_isi_satu");
    $fieldtampung_isi[1] = $this->input->post("field_isi_dua");
    $fieldtampung_isi[2] = $this->input->post("field_isi_tiga");
    $fieldtampung_isi[3] = $this->input->post("field_isi_empat");
    $fieldtampung_isi[4] = $this->input->post("field_isi_lima");

    $deskripsi = $this->input->post("deskripsi");

    if (isset($field)) {
      $arr_unik = array_unique($field);
      $jml_unik = count($arr_unik);
      $field_masuk = count($field);
    }

    for ($i = 0; $i < 5; $i++) {
      if (!empty($field[$i]) && empty($fieldtampung_isi[$i])) {
        $data['error'][$i] = "field isi pada nomor urut " . $field[$i] . " harus di isi";
      }
    }

    if (empty($nol) && empty($satu) && empty($dua) && empty($tiga) && empty($empat) && empty($fieldtampung_isi[2]) && empty($fieldtampung_isi[3]) && empty($fieldtampung_isi[4])) {
      $this->edit_format_nomor($id_format);
    } elseif ($this->form_validation->run() == FALSE) {
      $this->edit_format_nomor($id_format);
    } elseif ($fieldtampung_isi[0] != $title_database and $this->cek_title($fieldtampung_isi[0]) == FALSE) {
      $data['error_wajib'] = "Maaf " . $fieldtampung_isi[0] . " sudah ada, mohon di ganti";
      $this->edit_format_nomor($id_format, $data);
    } elseif ($jml_unik != $field_masuk) {
      $data['error_wajib'] = "Maaf Nomor urut tidak dapat duplikat";
      $this->edit_format_nomor($id_format, $data);
    } elseif (isset($data['error'])) {
      $data['jumlah_error'] = count($data['error']);

      $this->edit_format_nomor($id_format, $data);
    } elseif (!empty($fieldtampung_isi[4])) {
      $split = str_split($fieldtampung_isi[4]);
      if (!preg_match('/^[0-9]+$/', $fieldtampung_isi[4])) {
        $data['error_wajib'] = "Maaf field nomor hanya dapat di isi oleh angka";
        $this->edit_format_nomor($id_format, $data);
      } elseif ($split[0] == 0 and $split[1] == 0 and $split[2] == 0 and $split[3] == 0 and $split[4] == 0) {
        $data['error_wajib'] = "Maaf angka nol di depan angka utama di field nomor maksimal berjumlah 4";
        $this->tambah_format_nomor($data);
      } else {
        $this->Surat->update_format_nomor($id_format, $jenis_surat, $deskripsi);
        $this->Surat->hapus_akses_lama($id_format);
        $this->Surat->hapus_format_nomor_lama($id_format);

        $field_delimiter[0] = $this->input->post("field_delimiter_satu");
        $field_delimiter[1] = $this->input->post("field_delimiter_dua");
        $field_delimiter[2] = $this->input->post("field_delimiter_tiga");
        $field_delimiter[3] = $this->input->post("field_delimiter_empat");
        $field_delimiter[4] = $this->input->post("field_delimiter_lima");

        $field_isi[0] = "jenis+" . $fieldtampung_isi[0];
        $field_isi[1] = "dept+" . $fieldtampung_isi[1];
        $field_isi[2] = "bulan+" . $fieldtampung_isi[2];
        $field_isi[3] = "tahun+" . $fieldtampung_isi[3];
        $field_isi[4] = "start+" . $fieldtampung_isi[4];

        for ($i = 0; $i < 5; $i++) {
          if (!empty($field[$i])) {
            $this->Surat->tambah_multiple($field[$i], $field_delimiter[$i], $field_isi[$i], $id_format);
          }
        }


        for ($i = 0; $i < $jumlah_dept; $i++) {
          $this->Surat->tambah_akses_nomor($id_format, $departement[$i]);
        }

        $this->session->set_flashdata('sukses', 'data berhasil di perbaharui');
        redirect('admin/format_nomor');
      }
    } else {
      $this->Surat->update_format_nomor($id_format, $jenis_surat, $deskripsi);
      $this->Surat->hapus_format_nomor_lama($id_format);
      $this->Surat->hapus_akses_lama($id_format);

      $field_delimiter[0] = $this->input->post("field_delimiter_satu");
      $field_delimiter[1] = $this->input->post("field_delimiter_dua");
      $field_delimiter[2] = $this->input->post("field_delimiter_tiga");
      $field_delimiter[3] = $this->input->post("field_delimiter_empat");
      $field_delimiter[4] = $this->input->post("field_delimiter_lima");

      $field_isi[0] = "jenis+" . $fieldtampung_isi[0];
      $field_isi[1] = "dept+" . $fieldtampung_isi[1];
      $field_isi[2] = "bulan+" . $fieldtampung_isi[2];
      $field_isi[3] = "tahun+" . $fieldtampung_isi[3];
      $field_isi[4] = "start+" . $fieldtampung_isi[4];

      for ($i = 0; $i < $jumlah_dept; $i++) {
        $this->Surat->tambah_akses_nomor($id_format, $departement[$i]);
      }

      for ($i = 0; $i < 5; $i++) {
        if (!empty($field[$i])) {
          $this->Surat->tambah_multiple($field[$i], $field_delimiter[$i], $field_isi[$i], $id_format);
        }
      }

      $this->session->set_flashdata('sukses', 'data berhasil di perbaharui');
      redirect('admin/format_nomor');
    }
  }

  function cek_title($str) {
    $c = $this->db->get_where('format_nomor', array('fJenis_surat' => $str))->num_rows();

    if ($c > 0) {
      $this->form_validation->set_message('cek_title', 'Jenis surat ' . $str . ' sudah ada, mohon di ganti');
      return FALSE;
    } else {
      return TRUE;
    }
  }

// ----------------------------- end module format nomor --------------------------------------------	
// ----------------------------- Management user module --------------------------------------

  function daftar_user($offset=null, $order_column=NULL, $order_type=NULL) {
    if ($this->session->userdata('status_upload') == 1) {
      $this->upload_berkas();
    } else {
      $id_user = $this->session->userdata('userid');
      $username = $this->session->userdata('username');
      $id_departement = $this->session->userdata('departement');
      $jabatan = $this->session->userdata('jabatan');

      $this->load->helper('text');

      $this->load->library('pagination');
      $config['base_url'] = site_url('admin/daftar_user');
      $config['total_rows'] = $this->User->daftar_user($id_user, $username, $id_departement, $jabatan)->num_rows();
      $config['per_page'] = 9;
      $config['num_links'] = 3;
      $config['uri_segment'] = 3;
      $config['next_link'] = '»';
      $config['prev_link'] = '«';
      $config['first_tag_open'] = '<li>';
      $config['first_tag_close'] = '</li>';

      $config['last_tag_open'] = '<li>';
      $config['last_tag_close'] = '</li>';

      $config['full_tag_open'] = '<div class="pagination"><ul>';
      $config['full_tag_close'] = '</div>';
      $config['num_tag_open'] = '<li>';
      $config['num_tag_close'] = '</li>';
      $config['cur_tag_open'] = '<li class="active"><a>';
      $config['cur_tag_close'] = '</a></li>';
      $this->pagination->initialize($config);
      $offset = $this->uri->segment(3);
      if (empty($offset)) {
        $offset = 0;
        $i = 1;
      } else {
        $i = $offset + 1;
      }

      if (empty($order_column))
        $order_column = 'uNama';
      if (empty($order_type))
        $order_type = 'asc';
      $new_order = ($order_type == 'asc' ? 'desc' : 'asc');


      $user = $this->User->daftar_user_paging($config['per_page'], $offset, $id_user, $username, $id_departement, $jabatan, $order_column, $order_type);

      $this->table->set_template($this->tabel);
      $this->table->set_heading('No', anchor('admin/daftar_user/' . $offset . '/uNama/' . $new_order, 'Nama'), 'Departement', 'Action');
      foreach ($user->result() as $u) {
        $this->table->add_row(
                $i++, word_limiter($u->uNama, 5), $u->dKeterangan, anchor("admin/edit_user/" . base64_encode($u->uUserid), img($this->image_edit), array("rel" => "tooltip", "title" => "Edit")) . nbs(5) . anchor("admin/hapus_user/" . base64_encode($u->uUserid), img($this->image_delete), array("onClick" => "return confirm('anda yakin tuk menghapus user ini?')", "rel" => "tooltip", "title" => "Delete"))
        );
      }
      $data['user'] = $this->table->generate();


      $this->tampilan->tampil_admin('admin/daftar_user', $data);
    }
  }

  function cari_user() {
    $kata = $this->input->get('kata');
    $id_user = $this->session->userdata('userid');
    $username = $this->session->userdata('username');
    $user = $this->User->cari_user($kata, $id_user, $username);

    $jml = $user->num_rows();

    if ($jml == 0) {
      $data['user'] = "Maaf data tidak ada";
    } else {

      $this->table->set_template($this->tabel);
      $this->table->set_heading('Nama', 'Departement', 'Action');
      foreach ($user->result() as $u) {
        $this->table->add_row(
                $u->uNama, $u->dKeterangan, anchor("admin/edit_user/" . base64_encode($u->uUserid), img($this->image_edit), array("rel" => "tooltip", "title" => "Edit")) . nbs(5) . anchor("admin/hapus_user/" . base64_encode($u->uUserid), img($this->image_delete), array("onClick" => "return confirm('anda yakin tuk menghapus user ini?')", "rel" => "tooltip", "title" => "Delete"))
        );
      }
      $data['user'] = $this->table->generate();
    }

    $this->tampilan->tampil_admin('admin/cari_user', $data);
  }

  function tambah_user($data=null) {
    $data['departement'] = $this->User->daftar_departement();

    $this->table->set_template($this->tabel);
    $this->table->set_heading('Menu', 'New', 'Read', 'Edit', 'Delete', 'Print');

    $u[0] = array(
        'User',
        '<input type="checkbox" name="user_new" value="n" />',
        '<input type="checkbox" name="user_read" value="r" />',
        '<input type="checkbox" name="user_edit" value="e" />',
        '<input type="checkbox" name="user_delete" value="d" />',
        nbs(2)
    );

    $u[1] = array(
        'Password',
        nbs(2),
        '<input type="checkbox" name="password_read" value="r" checked="checked" />',
        '<input type="checkbox" name="password_edit" value="e" checked="checked" />',
        nbs(2),
        nbs(2)
    );

    $u[2] = array(
        'Format Nomor',
        '<input type="checkbox" name="format_new" value="n" />',
        '<input type="checkbox" name="format_read" value="r" />',
        '<input type="checkbox" name="format_edit" value="e" />',
        '<input type="checkbox" name="format_delete" value="d" />',
        nbs(2)
    );

    $u[3] = array(
        'Nomor surat',
        '<input type="checkbox" name="surat_new" value="n" checked="checked" />',
        '<input type="checkbox" name="surat_read" value="r" checked="checked" />',
        '<input type="checkbox" name="surat_edit" value="e" />',
        '<input type="checkbox" name="surat_delete" value="d" />',
        nbs(2)
    );

    $u[4] = array(
        'Laporan',
        nbs(),
        '<input type="checkbox" name="laporan_read" value="r" />',
        nbs(2),
        nbs(2),
        '<input type="checkbox" name="laporan_print" value="p" />'
    );


    for ($i = 0; $i < 5; $i++) {
      $this->table->add_row($u[$i]);
    }

    $data['hak_akses'] = $this->table->generate();

    $this->tampilan->tampil_admin('admin/tambah_user', $data);
  }

  function proses_tambah_user() {
    $nama = $this->input->post("nama");
    $username = $this->input->post("username");
    $password = $this->input->post("password");
    $departement = $this->input->post("departement");
    $jabatan = $this->input->post("jabatan");

    $format_new = "|" . $this->input->post('format_new');
    $format_read = "|" . $this->input->post('format_read');
    $format_edit = "|" . $this->input->post('format_edit');
    $format_delete = "|" . $this->input->post('format_delete');

    $akses['format'] = $format_new . $format_read . $format_edit . $format_delete;

    $user_new = "|" . $this->input->post('user_new');
    $user_read = "|" . $this->input->post('user_read');
    $user_edit = "|" . $this->input->post('user_edit');
    $user_delete = "|" . $this->input->post('user_delete');

    $akses['user'] = $user_new . $user_read . $user_edit . $user_delete;

    //$pass_new = "|".$this->input->post('password_new');	
    $pass_read = "|" . $this->input->post('password_read');
    $pass_edit = "|" . $this->input->post('password_edit');
    //$pass_delete = "|".$this->input->post('password_delete');

    $akses['pass'] = $pass_read . $pass_edit;

    $surat_new = "|" . $this->input->post('surat_new');
    $surat_read = "|" . $this->input->post('surat_read');
    $surat_edit = "|" . $this->input->post('surat_edit');
    $surat_delete = "|" . $this->input->post('surat_delete');

    $akses['surat'] = $surat_new . $surat_read . $surat_edit . $surat_delete;

    //$laporan_new = "|".$this->input->post('laporan_new');	
    $laporan_read = "|" . $this->input->post('laporan_read');
    //$laporan_edit = "|".$this->input->post('laporan_edit');
    //$laporan_delete = "|".$this->input->post('laporan_delete');
    $laporan_print = "|" . $this->input->post('laporan_print');

    $akses['laporan'] = $laporan_read . $laporan_print;

    $departement = $this->input->post("departement");
    $special_status = $this->input->post("special");

    if ($special_status == 'yes') {
      $this->form_validation->set_rules('special_departement[]', 'Pilih departement wajib jika user spesial di pilih', 'required');
    }

    $this->form_validation->set_rules('nama', 'Nama lengkap', 'required|max_length[30]|min_length[3]');
    $this->form_validation->set_rules('jabatan', 'Jabatan', 'required');
    $this->form_validation->set_rules('username', 'Username', 'required|max_length[12]|min_length[3]|callback_cek_username');
    $this->form_validation->set_rules('password', 'password', 'required');
    $this->form_validation->set_rules('departement', 'departement', 'required');
    $this->form_validation->set_rules('repassword', 'retype password', 'required|matches[password]');

    if ($this->form_validation->run() == FALSE) {
      $this->tambah_user();
    } else {

      $id_user = $this->User->tambah_user($nama, $username, $departement, $password, $jabatan);
      if ($id_user) {
        $this->User->tambah_akses($id_user, $akses);


        if ($special_status == 'yes') {
          $special_departement = $this->input->post("special_departement");
          $jumlah_dept = count($special_departement);

          for ($i = 0; $i < $jumlah_dept; $i++) {
            $this->Surat->tambah_user_special($id_user, $special_departement[$i]);
          }
          $code_special = 1; //special
          $this->User->update_special_user($id_user, $code_special);
        }

        $this->session->set_flashdata('sukses', 'data baru berhasil di tambah');
        redirect('admin/daftar_user');
      }
    }
  }

  function edit_user($id_user, $data=null) {
    $id = base64_decode($id_user);
    $user = $this->db->get_where('user', array('uUserid' => $id));
    $u = $user->row();

    $hak = $this->db->get_where('hak_akses', array('uIDuser' => $id));
    $akses = $hak->row();

    $arr_user = explode("|", $akses->uUser);
    $arr_pass = explode("|", $akses->uPassword);
    $arr_format = explode("|", $akses->uFormat_surat);
    $arr_surat = explode("|", $akses->uSurat_keluar);
    $arr_laporan = explode("|", $akses->uLaporan);

    $this->table->set_template($this->tabel);
    $this->table->set_heading('Menu', 'New', 'Read', 'Edit', 'Delete', 'Print');

    if (in_array("n", $arr_user)) {
      $user_new = '<input type="checkbox" name="user_new" value="n" checked="checked" />';
    } else {
      $user_new = '<input type="checkbox" name="user_new" value="n" />';
    }

    if (in_array("r", $arr_user)) {
      $user_read = '<input type="checkbox" name="user_read" value="r" checked="checked" />';
    } else {
      $user_read = '<input type="checkbox" name="user_read" value="r" />';
    }

    if (in_array("e", $arr_user)) {
      $user_edit = '<input type="checkbox" name="user_edit" value="e" checked="checked" />';
    } else {
      $user_edit = '<input type="checkbox" name="user_edit" value="e" />';
    }

    if (in_array("d", $arr_user)) {
      $user_delete = '<input type="checkbox" name="user_delete" value="d" checked="checked" />';
    } else {
      $user_delete = '<input type="checkbox" name="user_read" value="d" />';
    }

    $a[0] = array(
        'User',
        $user_new,
        $user_read,
        $user_edit,
        $user_delete,
        nbs()
    );

    /* if(in_array("n",$arr_pass))
      {
      $pass_new = '<input type="checkbox" name="password_new" value="n" checked="checked" />';
      }
      else
      {
      $pass_new = '<input type="checkbox" name="password_new" value="n" />';
      } */

    if (in_array("r", $arr_pass)) {
      $pass_read = '<input type="checkbox" name="password_read" value="r" checked="checked" />';
    } else {
      $pass_read = '<input type="checkbox" name="password_read" value="r" />';
    }

    if (in_array("e", $arr_pass)) {
      $pass_edit = '<input type="checkbox" name="password_edit" value="e" checked="checked" />';
    } else {
      $pass_edit = '<input type="checkbox" name="password_edit" value="e" />';
    }

    /* if(in_array("d",$arr_pass))
      {
      $pass_delete = '<input type="checkbox" name="password_read" value="d" checked="checked" />';
      }
      else
      {
      $pass_delete = '<input type="checkbox" name="password_read" value="d" />';
      } */

    $a[1] = array(
        'Password',
        nbs(),
        $pass_read,
        $pass_edit,
        nbs(),
        nbs()
    );

    if (in_array("n", $arr_format)) {
      $format_new = '<input type="checkbox" name="format_new" value="n" checked="checked" />';
    } else {
      $format_new = '<input type="checkbox" name="format_new" value="n" />';
    }

    if (in_array("r", $arr_format)) {
      $format_read = '<input type="checkbox" name="format_read" value="r" checked="checked" />';
    } else {
      $format_read = '<input type="checkbox" name="format_read" value="r" />';
    }

    if (in_array("e", $arr_format)) {
      $format_edit = '<input type="checkbox" name="format_edit" value="e" checked="checked" />';
    } else {
      $format_edit = '<input type="checkbox" name="format_edit" value="e" />';
    }

    if (in_array("d", $arr_format)) {
      $format_delete = '<input type="checkbox" name="format_delete" value="d" checked="checked" />';
    } else {
      $format_delete = '<input type="checkbox" name="format_delete" value="d" />';
    }

    $a[2] = array(
        'Format Nomor',
        $format_new,
        $format_read,
        $format_edit,
        $format_delete,
        nbs()
    );

    if (in_array("n", $arr_surat)) {
      $surat_new = '<input type="checkbox" name="surat_new" value="n" checked="checked" />';
    } else {
      $surat_new = '<input type="checkbox" name="surat_new" value="n" />';
    }

    if (in_array("r", $arr_surat)) {
      $surat_read = '<input type="checkbox" name="surat_read" value="r" checked="checked" />';
    } else {
      $surat_read = '<input type="checkbox" name="surat_read" value="r" />';
    }

    if (in_array("e", $arr_surat)) {
      $surat_edit = '<input type="checkbox" name="surat_edit" value="e" checked="checked" />';
    } else {
      $surat_edit = '<input type="checkbox" name="surat_edit" value="e" />';
    }

    if (in_array("d", $arr_surat)) {
      $surat_delete = '<input type="checkbox" name="surat_delete" value="d" checked="checked" />';
    } else {
      $surat_delete = '<input type="checkbox" name="surat_delete" value="d" />';
    }

    $a[3] = array(
        'Nomor surat',
        $surat_new,
        $surat_read,
        $surat_edit,
        $surat_delete,
        nbs()
    );


    if (in_array("r", $arr_laporan)) {
      $laporan_read = '<input type="checkbox" name="laporan_read" value="r" checked="checked" />';
    } else {
      $laporan_read = '<input type="checkbox" name="laporan_read" value="r" />';
    }

    if (in_array("p", $arr_laporan)) {
      $laporan_print = '<input type="checkbox" name="laporan_print" value="p" checked="checked" />';
    } else {
      $laporan_print = '<input type="checkbox" name="laporan_print" value="p" />';
    }

    $a[4] = array(
        'Laporan',
        nbs(),
        $laporan_read,
        nbs(),
        nbs(),
        $laporan_print
    );

    for ($i = 0; $i < 5; $i++) {
      $this->table->add_row($a[$i]);
    }

    $data['hak_akses'] = $this->table->generate();

    $data['id_user'] = $u->uUserid;
    $data['username'] = $u->uUsername;
    $data['nama'] = $u->uNama;
    $data['dept'] = $u->uIDdepartement;
    $data['status_special'] = $u->uSpecial;
    $data['jabatan'] = $u->uPosition;

    $data['departement'] = $this->User->daftar_departement();

    $data['special'] = $this->db->get_where('user_special', array('uIDuser' => $u->uUserid));

    $this->tampilan->tampil_admin('admin/edit_user', $data);
  }

  function proses_edit_user() {
    $nama = $this->input->post("nama");
    $username = $this->input->post("username");
    $password_new = $this->input->post("password");
    $repassword = $this->input->post("repassword");
    $departement = $this->input->post("departement");
    $id = $this->input->post("id_user");
    $jabatan = $this->input->post('jabatan');

    $username_database = $this->db->get_where('user', array("uUserid" => $id))->row('uUsername');

    $id_user = base64_encode($id);

    if (!empty($password_new) && $password_new != $repassword) {
      ?>
      <script language="javascript">
        alert("Maaf password konf salah!");
        window.location.href="<?php echo base_url(); ?>index.php/admin/edit_user/<?php echo $id_user; ?>";
      </script>
      <?
    }
    $special_status = $this->input->post("special");
    if ($special_status == 'yes') {
      $this->form_validation->set_rules('special_departement[]', 'Pilih departement', 'required');
    }

    $this->form_validation->set_rules('nama', 'Nama lengkap', 'required|max_length[30]|min_length[3]');
    $this->form_validation->set_rules('jabatan', 'Jabatan', 'required');
    $this->form_validation->set_rules('username', 'Username', 'required|max_length[12]|min_length[3]');
    $this->form_validation->set_rules('departement', 'departement', 'required');

    if ($this->form_validation->run() == FALSE) {
      $data['error'] = validation_errors();
      $this->edit_user($id_user, $data);
    } else {
      $format_new = "|" . $this->input->post('format_new');
      $format_read = "|" . $this->input->post('format_read');
      $format_edit = "|" . $this->input->post('format_edit');
      $format_delete = "|" . $this->input->post('format_delete');

      $akses['format'] = $format_new . $format_read . $format_edit . $format_delete;

      $user_new = "|" . $this->input->post('user_new');
      $user_read = "|" . $this->input->post('user_read');
      $user_edit = "|" . $this->input->post('user_edit');
      $user_delete = "|" . $this->input->post('user_delete');

      $akses['user'] = $user_new . $user_read . $user_edit . $user_delete;

      //$pass_new = "|".$this->input->post('password_new');	
      $pass_read = "|" . $this->input->post('password_read');
      $pass_edit = "|" . $this->input->post('password_edit');
      //$pass_delete = "|".$this->input->post('password_delete');

      $akses['pass'] = $pass_read . $pass_edit;

      $surat_new = "|" . $this->input->post('surat_new');
      $surat_read = "|" . $this->input->post('surat_read');
      $surat_edit = "|" . $this->input->post('surat_edit');
      $surat_delete = "|" . $this->input->post('surat_delete');

      $akses['surat'] = $surat_new . $surat_read . $surat_edit . $surat_delete;

      //$laporan_new = "|".$this->input->post('laporan_new');	
      $laporan_read = "|" . $this->input->post('laporan_read');
      //$laporan_edit = "|".$this->input->post('laporan_edit');
      //$laporan_delete = "|".$this->input->post('laporan_delete');
      $laporan_print = "|" . $this->input->post('laporan_print');

      $akses['laporan'] = $laporan_read . $laporan_print;

      if ($username != $username_database) {
        $t = $this->cek_username($username);
        if (!$t) {
          $data['error'] = 'username ' . $username . ' has already exist';
          $this->edit_user($id_user, $data);
        } else {
          $this->User->update_user($id, $nama, $username, $departement, $password_new, $jabatan);
          $this->User->update_akses($id, $akses);
          $this->User->hapus_special_user($id);

          $special_departement = $this->input->post("special_departement");
          $jumlah_dept = count($special_departement);

          if ($special_status == 'yes') {

            //cek apakah dy sebelumnya ada datanya
            $cek = $this->db->get_where('user_special', array('uIDuser' => $id_user))->num_rows();

            if ($cek > 0) {
              $this->db->delete('user_special', array('uIDuser' => $id_user));
            }

            for ($i = 0; $i < $jumlah_dept; $i++) {
              $this->Surat->tambah_user_special($id_user, $special_departement[$i]);
            }
            $code_special = 1; //special
            $this->User->update_special_user($id_user, $code_special);
          }

          if ($special_status == 'no') {
            $code_special = 0; //special
            $this->User->update_special_user($id_user, $code_special);
          }

          $this->session->set_flashdata('sukses', 'user dengan username ' . $username . ' berhasil di perbaharui');
          redirect('admin/daftar_user');
        }
      } else {
        $this->User->update_user($id, $nama, $username, $departement, $password_new, $jabatan);
        $this->User->update_akses($id, $akses);
        $this->User->hapus_special_user($id);

        $special_departement = $this->input->post("special_departement");

        $jumlah_dept = count($special_departement);
        if ($special_status == 'yes') {
          for ($i = 0; $i < $jumlah_dept; $i++) {
            $this->Surat->tambah_user_special($id, $special_departement[$i]);
          }
          $code_special = 1; //special
          $this->User->update_special_user($id, $code_special);
        }

        if ($special_status == 'no') {
          $code_special = 0; //special
          $this->User->update_special_user($id, $code_special);
        }

        $this->session->set_flashdata('sukses', 'user dengan username ' . $username . ' berhasil di perbaharui');
        redirect('admin/daftar_user');
      }
    }
  }

  // hapus user
  function hapus_user($id_user) {
    $id = base64_decode($id_user);
    $this->db->delete('user', array('uUserid' => $id));
    $this->db->delete('hak_akses', array('uIDuser' => $id));
    $this->session->set_flashdata('sukses', 'data berhasil di hapus');
    redirect('admin/daftar_user');
  }

// ----------------------------- end module management user --------------------------------------------	
//---------------------------------- departement CRUD module ------------------------------------

  function departement($data=null) {
    if ($this->session->userdata('status_upload') == 1) {
      $this->upload_berkas();
    } else {
      $dept = $this->User->daftar_departement();

      $this->table->set_template($this->tabel);
      $this->table->set_heading('Kode Departement', 'Keterangan', 'Action');
      foreach ($dept->result() as $d) {
        $this->table->add_row(
                $d->dCode_departement, $d->dKeterangan, anchor("admin/edit_departement/" . base64_encode($d->dDepartementid), img($this->image_edit), array("rel" => "tooltip", "title" => "Edit")) . nbs(5) . anchor("admin/hapus_departement/" . base64_encode($d->dDepartementid), img($this->image_delete), array("onClick" => "return confirm('anda yakin tuk menghapus departement ini? Semua user yang berada di departement ini akan terhapus juga')", "rel" => "tooltip", "title" => "Delete"))
        );
      }
      $data['departement'] = $this->table->generate();

      $this->tampilan->tampil_admin('admin/departement', $data);
    }
  }

  function tambah_departement($data=null) {
    $this->tampilan->tampil_admin('admin/tambah_departement', $data);
  }

  function proses_tambah_departement() {
    $kode = $this->input->post("kode");
    $nama = $this->input->post("nama");

    $this->form_validation->set_rules('nama', 'Nama departement', 'required|max_length[30]|min_length[3]');
    $this->form_validation->set_rules('kode', 'Kode departement', 'required|max_length[12]|min_length[3]');

    if ($this->form_validation->run() == FALSE) {
      $this->tambah_departement();
    } else {
      $r = $this->User->tambah_departement($kode, $nama);
      if ($r) {
        $data['sukses'] = 'Departement dengan nama ' . $nama . ' berhasil di tambah';
        $this->departement($data);
      }
    }
  }

  function edit_departement($id_dept) {
    $id = base64_decode($id_dept);
    $d = $this->db->get_where('departement', array('dDepartementid' => $id));
    $u = $d->row();

    $data['id_dept'] = $u->dDepartementid;
    $data['kode'] = $u->dCode_departement;
    $data['nama'] = $u->dKeterangan;

    $data['departement'] = $this->db->get('departement');

    $this->tampilan->tampil_admin('admin/edit_departement', $data);
  }

  function proses_edit_departement() {
    $kode = $this->input->post("kode");
    $nama = $this->input->post("nama");
    $id = $this->input->post("id_dept");

    $this->form_validation->set_rules('nama', 'Nama departement', 'required');
    $this->form_validation->set_rules('kode', 'Kode departement', 'required');

    if ($this->form_validation->run() == FALSE) {
      $this->tambah_departement();
    } else {
      $r = $this->User->update_departement($id, $kode, $nama);
      if ($r) {
        $data['sukses'] = 'Departement dengan nama ' . $nama . ' berhasil di perbaharui';
        $this->departement($data);
      }
    }
  }

  function hapus_departement($id_dept) {
    $id = base64_decode($id_dept);
    $username = $this->session->userdata('username');

    $this->db->delete('departement', array('dDepartementid' => $id));
    $this->db->delete('akses_format_nomor', array('aIDdepartement' => $id));
    $this->User->hapusdept_edit_user($id, $username);
    $this->session->set_flashdata('sukses', 'data berhasil di hapus');
    redirect('admin/departement');
  }

//-------------------------------- end module departement module ---------------------------	

  function akun($data=NULL) {
    if ($this->session->userdata('status_upload') == 1) {
      $this->upload_berkas();
    } else {
      $id = $this->session->userdata('userid');
      $user = $this->User->detail_akun($id);
      $u = $user->row();

      $data['id_user'] = $u->uUserid;
      $data['username'] = $u->uUsername;
      $data['nama'] = $u->uNama;
      $data['dept'] = $u->dKeterangan;

      $akun = $u->uPosition;

      switch ($akun) {
        case '1':
          $data['position'] = 'Manager';
          break;
        case '0':
          $data['position'] = 'Staff';
          break;
        default:
          $data['position'] = 'Admin';
          break;
      }

      $this->tampilan->tampil_admin('admin/akun', $data);
    }
  }

  function update_akun() {
    $nama = $this->input->post("nama");
    $username = $this->input->post("username");
    $id = $this->input->post("id_user");

    $username_database = $this->db->get_where('user', array("uUserid" => $id))->row('uUsername');

    $this->form_validation->set_rules('nama', 'Nama', 'required|max_length[30]|min_length[3]');
    $this->form_validation->set_rules('username', 'Username', 'required|max_length[30]|min_length[3]');

    if ($this->form_validation->run() == FALSE) {
      $this->akun();
    } else {
      if ($username != $username_database) {
        $t = $this->cek_username($username);
        if (!$t) {
          $data['error'] = 'username ' . $username . ' has already exist';
          $this->akun($data);
        } else {
          $this->User->update_akun($id, $nama, $username);
          $data['sukses'] = 'Akun anda berhasil di perbaharui';
          $this->akun($data);
        }
      } else {
        $this->User->update_akun($id, $nama, $username);
        $data['sukses'] = 'Akun anda berhasil di perbaharui';
        $this->akun($data);
      }
    }
  }

  function mypassword($data=NULL) {
    if ($this->session->userdata('status_upload') == 1) {
      $this->upload_berkas();
    } else {
      $id_user = $this->session->userdata("userid");
      $data['username'] = $this->db->get_where('user', array('uUserid' => $id_user))->row('uUsername');
      $this->tampilan->tampil_admin('admin/mypassword', $data);
    }
  }

  function update_password() {
    $password = $this->input->post("password");
    $repassword = $this->input->post("repassword");
    $id_user = $this->session->userdata("userid");

    $this->form_validation->set_rules('password', 'password', 'required');
    $this->form_validation->set_rules('repassword', 'retype password', 'required|matches[password]');

    if ($this->form_validation->run() == FALSE) {
      $this->mypassword();
    } else {
      $r = $this->User->update_password($id_user, $password);
      if ($r) {
        $offset = 0;
        $data['sukses'] = 'Akun anda berhasil di perbaharui';
        $this->mypassword($data);
      }
    }
  }

  // logout function
  function logout() {
    $this->session->sess_destroy();
    redirect('login', 'refresh');
  }

  function cek_username($str) {
    $user = $this->db->get_where("user", array("uUsername" => $str));
    if ($user->num_rows() == 1) {
      $this->form_validation->set_message('cek_username', 'Username ' . $str . ' is already exsist');
      return FALSE;
    } else {
      return TRUE;
    }
  }
  
  function announce($data=NULL)
  {
     $data['content'] = $this->db->get_where('announce',array('aAnnounceid'=> 1))->row('aAnnounce_content');
     $this->tampilan->tampil_admin('admin/announce', $data);
  }
  
  function proses_announce()
  {
     $announce = $this->input->post("announce");

     $this->form_validation->set_rules('announce', 'announce', 'required');

    if ($this->form_validation->run() == FALSE) {
      $this->announce();
    } else {
      $r = $this->User->update_announce($announce);
      if ($r) {
        $offset = 0;
        $data['sukses'] = 'Announce berhasil di perbaharui';
        $this->announce($data);
      }
    }
  }

  /* ^************ Laporan Module *********************************** */

  function laporan($data=NULL) {
    $this->tampilan->tampil_admin('admin/laporan', $data);
  }

  function proses_laporan($offset=NULL) {
    $data['tanggal_awal'] = $this->input->post("tanggal_awal");
    $data['tanggal_akhir'] = $this->input->post("tanggal_akhir");

    $this->form_validation->set_rules('tanggal_awal', 'Tanggal awal', 'required');
    $this->form_validation->set_rules('tanggal_akhir', 'Tanggal akhir', 'required');

    if ($this->form_validation->run() == FALSE) {
      $this->laporan();
    } else {

      $laporan = $this->Surat->laporan($data['tanggal_awal'], $data['tanggal_akhir']);
      $jml = $laporan->num_rows();

      if ($jml == 0) {
        $data['laporan'] = 'Maaf data tidak ditemukan';
        $data['tombol_print'] = FALSE;
      } else {
        $i = 1;
        $this->table->set_template($this->tabel);
        $this->table->set_heading('No', 'Tanggal', 'Nomor', 'Kepada', 'Perihal');
        foreach ($laporan->result() as $l) {
          $this->table->add_row(
                  $i++, format_indo($l->sWaktu), $l->sNomorfull, $l->sKepada, $l->sJudul
          );
        }
        $data['laporan'] = $this->table->generate();

        if ($this->session->userdata('tombol_print') != NULL) {
          $data['tombol_print'] = TRUE;
        } else {
          $data['tombol_print'] = FALSE;
        }
      }
      $this->tampilan->tampil_admin('admin/proses_laporan', $data);
    }
  }

  function cetak_laporan($tanggal_awal, $tanggal_akhir) {
    $laporan = $this->Surat->print_laporan($tanggal_awal, $tanggal_akhir);
    $i = 1;
    $this->table->set_template($this->tabel);
    $this->table->set_heading('No', 'Tanggal', 'Nomor', 'Kepada', 'Perihal');
    foreach ($laporan->result() as $l) {
      $this->table->add_row(
              $i++, format_indo($l->sWaktu), $l->sNomorfull, $l->sKepada, $l->sJudul
      );
    }

    $data['tanggal_awal'] = $tanggal_awal;
    $data['tanggal_akhir'] = $tanggal_akhir;
    $data['laporan'] = $this->table->generate();
    $data['nama_user'] = $this->session->userdata("nama");
    $data['waktu_sekarang'] = date("Y-m-d H:i:s");

    $this->load->view('admin/cetak_laporan', $data);
  }

}
