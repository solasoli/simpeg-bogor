<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Disiplin extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this->load->library('session');
		$this->load->model('Hukuman_model','hukuman');
    $this->load->library('format');
  }

	public function index()
	{
      $data['title']  = 'Sipohanpinter::Disiplin';
      $data['page']   = 'disiplin/list';
      $data['pelanggaran'] = $this->hukuman->get_pelanggar();

      $this->load->view('layout',$data);

	}

  public function detail($id_pegawai){

    $data['title']  = 'Sipohanpinter::Disiplin';
    $data['page']   = 'disiplin/detail';
    $data['pelanggar'] = $this->hukuman->get_pelanggar_by_id_pegawai($id_pegawai);

    $this->load->view('layout',$data);
  }
}
