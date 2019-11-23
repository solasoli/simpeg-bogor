<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Home extends CI_Controller {

	function __construct(){

		parent::__construct();
		//$this->load->library('access');
		$this->load->library('session');

	}

	public function index()
	{

		$this->load->view('login');

	}

	public function login(){
		$this->load->model('pegawai_model');

		$pegawai = $this->pegawai_model->get_login(
			$this->input->post('txtNip'),
			$this->input->post('txtPassword')
		);

		if($pegawai != null){
			//echo "<pre>";
			//print_r($pegawai);
			//echo "</pre>";

			$this->session->set_userdata('user', $pegawai);

			//echo "<pre>";
			//print_r($this->session->userdata('user'));
			//echo "</pre>";


			//$this->dashboard();
			redirect('home/dashboard','refresh');
		}else{
			redirect('home','refresh');
			//$this->load->view('login');
		}
	}

	public function dashboard(){
		$this->load->view('layout/header');
		$this->load->view('home');
		//$this->load->view('layout/footer');
	}
}

/* End of file home.php */
/* Location: ./application/controllers/home.php */
