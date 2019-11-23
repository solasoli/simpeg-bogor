<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
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
			$this->session->set_userdata('user', $pegawai);
			$this->dashboard();
		}else{
			$this->index();
		}
	
		
	
	}
	
	public function dashboard(){
		$this->load->view('layout/header');
		$this->load->view('home');
		$this->load->view('layout/footer');
	}
}

/* End of file home.php */
/* Location: ./application/controllers/home.php */