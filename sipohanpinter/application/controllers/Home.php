<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Home extends CI_Controller {
	function __construct() {
		parent::__construct();
		$this->load->library('session');

		if(!$this->session->userdata('user')){
			redirect('login');
		}

		$this->load->model('Hukuman_model','hukuman');

  }

	public function index()
	{
      $data['title'] = 'Siphanpinter::Dashboard';
      $data['page']   = 'home/view_dashboard';
			//print_r($this->session->userdata('user'));
      $this->load->view('layout',$data);

	}
}
