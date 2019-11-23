<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


	/**
	* 
	* 
	*/
class Testing extends CI_Controller{

	function __construct(){
	
		parent::__construct();
		
				
	}
	
	function test_riwayat_jabatan(){
	
		$this->load->model('riwayat_jabatan_model','rj');
		
		$riwayat_jabatan = $this->rj->get(2400);
		
		print_r($riwayat_jabatan);
	}
	
}