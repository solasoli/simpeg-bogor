<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
header('Access-Control-Allow-Origin: http://simpegdev.kotabogor.go.id', false);

class Login extends CI_Controller {
	function __construct() {
		parent::__construct();

		$this->load->library('session');
		$this->load->model('Hukuman_model','hukuman');

  }

	public function index()
	{
		if($this->session->userdata('user')){
				redirect('home');
		}else{
				$this->load->view('home/view_login');
		}

	}

	public function do_login(){

		$pegawai = $this->hukuman->get_login(
			$this->input->post('userx'),
			$this->input->post('passx')
		);

		if($pegawai){
			//echo "<pre>";
			//print_r($pegawai);
			//echo "</pre>";

			$this->session->set_userdata('user', $pegawai);
			$json['status'] = 'SUCCESS';
			$json['data']		= $pegawai;

			echo json_encode($json);

		}else{
			//$this->session->set_flashdata('FAILED','Log in Gagal, periksa kembali username dan pass anda, atau anda tidak memiliki kewenangan');
			//redirect('home','refresh');
			$json['status'] = 'FAILED';
			$json['data']		= '';
			echo json_encode($json);
		}
	}

	public function do_logout(){

		$this->session->sess_destroy();
		redirect('login');
	}

}
