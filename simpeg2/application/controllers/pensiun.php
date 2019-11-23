<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pensiun extends CI_Controller{

	function __construct(){	
		parent::__construct();				
	}
	
	
	function index(){
	
		
		$this->load->view('pensiun/daftar_bup');
		
	}
	
	function json_list_pejabat(){
		$this->load->model('pensiun_model');
		$r = $this->pensiun_model->list_pejabat();
		
		header("Content-Type: 'application/json'");
		echo json_encode($r);		
	}
	
	function list_pejabat_dataTable(){
		$this->load->model('pensiun_model');
		$result = $this->pensiun_model->list_pejabat();
		$rows = array();		
		foreach($result as $row){
			$rows[] = array(
				$row->nama, 
				$row->nip,
				$row->golongan,
				$row->unit_kerja,
				$row->jabatan,
				$row->eselon,
				$row->tgl_lahir,
				$row->bup
			);
		}
		$data = array('data' => $rows);
		
		header("Content-Type: 'application/json'");
		echo json_encode($data);
	}
}
