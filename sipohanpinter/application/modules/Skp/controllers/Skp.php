<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Skp extends MX_Controller {
	function __construct() {
		parent::__construct();

		$this->load->library('format');
		$this->load->model('skp_model','skp');

		$this->load->library('form_validation');
		Modules::Run('Dashboard/ceklog');
	}

  function index(){
    //print_r($this->session->userdata());
    $data['title'] = 'Sasaran Kerja Pegawai';
    $data['konten'] = 'tahun';
    $id_pegawai = $this->session->userdata('user_id');
    $daftar_tahun = $this->skp->get_list_tahun($id_pegawai);

    $data['daftar_tahun'] = $daftar_tahun;

    $this->load->view('Layout/_layout',$data);
    //print_r($daftar_tahun);
  }

}
