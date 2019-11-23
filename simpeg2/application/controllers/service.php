<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Service extends CI_Controller{
	
	
	public function __construct(){
		
		$this->load->model('pegawai_model','pegawai');
		$this->load->model('jabatan_model','jabatan');
	}
	
	public function find_by_nip(){
		
		$nip = $this->input->get('nip');
		$api_key = $this->input->get('api_key');
		
		echo $nip;
		
	}
}
