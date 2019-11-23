<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


	/**
	* 
	* 
	*/
class Jabatan extends CI_Controller{

	function __construct(){
	
		parent::__construct();
		
		$this->load->model('user_model','user');
		$this->load->model('pegawai_model','pegawai');
		$this->load->model('jabatan_model','jabatan');
		
	}
	
	function jfu_list(){
	
		$data = array('lists'=>$this->jabatan->get_list_jfu());
		$this->load->view('layout/header');
		$this->load->view('master/jfu_list',$data);
		$this->load->view('layout/footer');
	}
	
	function add_jfu(){
		
		if($this->input->post()){
			if($this->jabatan->add_jfu($this->input->post('kode_jfu'),$this->input->post('nama_jfu'))){
				redirect('jabatan/jfu_list');
			}else{
				echo "gagal";
			}
		}
	}
	
	function jfu_list_existing(){
	
		$sql = 'SELECT DISTINCT jfu_pegawai.kode_jabatan, jfu_master.nama_jfu
				FROM jfu_pegawai, jfu_master
				WHERE jfu_master.kode_jabatan = jfu_pegawai.kode_jabatan';
				
	}
}