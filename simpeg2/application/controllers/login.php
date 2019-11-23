<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_controller{

function __construct(){
	
		parent::__construct();
		//$this->load->library('access');
		$this->load->library('session');
		
	}
	
	function index(){
	
		$this->logout();
		$this->login();
	}
	
	function login(){
	
		//$this->load->view('login');
		$this->load->model('pegawai_model');
		
		$pegawai = $this->pegawai_model->get_login(
			$this->input->post('txtNip'),
			$this->input->post('txtPassword')
		);

		if($pegawai){
			//$this->session->set_userdata('user', $pegawai);
			//$this->dashboard();
			redirect('home/dashboard','refresh');
		}else{
			redirect('login','refresh');
			//echo "you are not authorized to access this page";
		}
		
	}
	
	function logout(){
				
		$this->session->sess_destroy();
		redirect('','refresh');
	}
	
	function check_login(){
		
		$username = $this->input->post('username',TRUE);
		$password = $this->input->post('password',TRUE);
		
		$login = $this->access->login($username,$password);
		//echo $loginuser_id;
		if($login){
			
			return TRUE;
		}else{
			
			$this->form_validation->set_message('check_login','Username atau password anda salah !!!');
			return FALSE;
		}
		
	}
}
