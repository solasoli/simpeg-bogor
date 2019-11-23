<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Drh extends CI_Controller{


	public function __construct(){
	
		parent::__construct();
				
		//authenticate($this->session->userdata('user'), "PEGAWAI_VIEW");	
		$this->load->model('pegawai_model','pegawai');
		$this->load->model('jabatan_model','jabatan');
	}
	
	public function view($id_pegawai){
	
		$this->load->view('drh/drh');
	}
}