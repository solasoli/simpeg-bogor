<?php defined('BASEPATH') OR exit('No direct script access allowed');

Class adminbkpsda extends MX_Controller
{
    public $data;
    public $layout;

    public function __construct(){
        parent::__construct();
        $this->load->library('pager');
        $this->layout = 'home';
        $this->load->model('Ekinerja_model','ekinerja');

    }

    public function index(){
        $this->sidebar_header();
        $modul = 'dashboard';
        $this->data['title'] = 'Dashboard Admin BKPSDA';
        $this->data['page'] = $modul;
        $this->data['main_view'] = $modul;
        $this->load->view($this->layout, $this->data);
    }

    public function sidebar_header(){
        $this->data['ses_nama'] = $this->session->userdata('nama');
        $this->data['ses_nip'] = $this->session->userdata('nip');
        $this->data['ses_unit'] = $this->session->userdata('unit_kerja');
        $this->data['ses_lvl_name'] = $this->session->userdata('user_level_name');
    }

    public function input_laporan_kinerja(){
        $this->sidebar_header();
        $modul = 'input_laporan_kinerja';
        $this->data['title'] = 'Laporan Kinerja';
        $this->data['page'] = $modul;
        $this->data['view_type'] = 'hmvc';
        $this->data['main_view'] = Modules::run('publicpegawai/vw_input_laporan_kinerja', 'adminbkpsda');
        $this->load->view($this->layout, $this->data);
    }

    public function tipe_lokasi_kerja(){
      $this->sidebar_header();
      $modul = 'tipe_lokasi_kerja';
      $this->data['title'] = 'Tipe dan Lokasi Unit Kerja';
      $this->data['page'] = $modul;
      $this->data['usr'] = 'adminopd';
      $this->data['main_view'] = $modul;
      $this->load->view($this->layout, $this->data);
    }

    public function data_lokasi_kerja(){
      $pages = new Paginator;
      $pagePaging = $_POST['page'];
      $ipp = $_POST['ipp'];

      if($pagePaging==0 or $pagePaging==""){
          $pagePaging = 1;
      }
      if($ipp==0 or $ipp==""){
          $ipp = $pages->default_ipp;
      }
      $_SESSION['ippPager'] = $ipp;
      $_SESSION['pagePager'] = $pagePaging;
      $keyword = $this->input->post('keywordCari');
      $jmlData = $this->ekinerja->get_jml_pegawai_tipe_lokasi($this->session->userdata('id_skpd_enc'), $keyword);
      $jmlData = $jmlData[0]->jumlah;
      if($jmlData>0){
          $pages->items_total = $jmlData;
          $pages->paginate();
          $pgDisplay = $pages->display_pages();
          $curpage = ($pages->current_page==0?1:$pages->current_page);
          $numpage = $pages->num_pages;
      }else{
          $pgDisplay = '';
          $curpage = '';
          $numpage = '';
      }

      if($pagePaging == 1){
          $start_number = 0;
      }else{
          $ipp = explode("&&", $ipp);
          $ipp = $ipp[0];
          $start_number = ($pagePaging * $ipp) - $ipp;
      }
      if($pages->current_page==0){
          $pages->limit = 'LIMIT 0,10';
      }

      $drop_data = $this->ekinerja->daftar_pegawai_tipe_lokasi($start_number,$this->session->userdata('id_skpd_enc'), $keyword, $pages->limit);
      $this->load->view('load_list_tipe_lokasi_pegawai', array(
          'drop_data_list'=> $drop_data,
          'pgDisplay' => $pgDisplay,
          'curpage' => $curpage,
          'numpage' => $numpage,
          'jmlData' => $jmlData,
          'start_number' => $start_number,
          'usr' => 'adminopd'
      ));
    }

    public function monitoring_kinerja_pegawai(){
        $this->sidebar_header();
        $modul = 'monitoring_kinerja_pegawai';
        $this->data['title'] = 'Monitoring Kinerja Pegawai';
        $this->data['page'] = $modul;
        $this->data['usr'] = 'adminbkpsda';
        $this->data['main_view'] = $modul;
        $this->load->view($this->layout, $this->data);
    }

    public function data_opd(){
      $pages = new Paginator;
      $pagePaging = $_POST['page'];
      $ipp = $_POST['ipp'];

      if($pagePaging==0 or $pagePaging==""){
          $pagePaging = 1;
      }
      if($ipp==0 or $ipp==""){
          $ipp = $pages->default_ipp;
      }
      $_SESSION['ippPager'] = $ipp;
      $_SESSION['pagePager'] = $pagePaging;
      $keyword = $this->input->post('keywordCari');
      $jmlData = $this->ekinerja->get_jml_pegawai_tipe_lokasi($this->session->userdata('id_skpd_enc'), $keyword);
      $jmlData = $jmlData[0]->jumlah;
      if($jmlData>0){
          $pages->items_total = $jmlData;
          $pages->paginate();
          $pgDisplay = $pages->display_pages();
          $curpage = ($pages->current_page==0?1:$pages->current_page);
          $numpage = $pages->num_pages;
      }else{
          $pgDisplay = '';
          $curpage = '';
          $numpage = '';
      }

      if($pagePaging == 1){
          $start_number = 0;
      }else{
          $ipp = explode("&&", $ipp);
          $ipp = $ipp[0];
          $start_number = ($pagePaging * $ipp) - $ipp;
      }
      if($pages->current_page==0){
          $pages->limit = 'LIMIT 0,10';
      }

      $drop_data = $this->ekinerja->daftar_pegawai_tipe_lokasi($start_number,$this->session->userdata('id_skpd_enc'), $keyword, $pages->limit);
      $this->load->view('load_list_tipe_lokasi_pegawai', array(
          'drop_data_list'=> $drop_data,
          'pgDisplay' => $pgDisplay,
          'curpage' => $curpage,
          'numpage' => $numpage,
          'jmlData' => $jmlData,
          'start_number' => $start_number,
          'usr' => 'adminopd'
      ));
    }


}
