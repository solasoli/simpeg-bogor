<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Sipohanadmin extends MX_Controller {
	function __construct() {
		parent::__construct();

		$this->load->library('format');

		$this->load->library('form_validation');
		Modules::Run('Dashboard/ceklog');
	}

  function pasal_pelanggaran(){

    $data['title'] = "Daftar Pasal Pelanggaran";
		$data['konten'] = 'list_pasal';
		$data['pasal'] = $this->db->get('hukuman_pasal_pelanggaran')->result();
		$this->load->view('Layout/_layout',$data);
  }

}
