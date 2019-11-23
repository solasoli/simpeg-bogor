<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Anjungan extends CI_Controller{

	function __construct(){

		parent::__construct();
	}

	function index(){
		
		$this->load->view('anjungan/anjungan_home');
	
	}


}
/** end of file anjungan.php */
