<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends MX_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model('Supermodel');
		$this->load->model('login_model');
		$this->load->library('form_validation');
	}

	function index() {

		if($this->session->userdata('logged_indg')!=""):
			redirect('Dashboard');
		else:
			//echo "redirecting...";
			//redirect('http://'.$_SERVER['HTTP_HOST'].'/simpeg/index3.php','refresh');

			$this->load->view('login');
		endif;

	}

	public function masuq() {


		$user = $this->input->post('userx');
		$pass = $this->input->post('passx');

			$sup = $this->login_model->asupcoy($user, $pass);

			if($sup){
				foreach($sup as $asli){
					$lias['logged_indg'] = "yesAigetLogin";
					$lias['username'] = $asli['nip'];

					$lias['status'] = "member";
					$lias['user_id'] = $asli['id_pegawai'];
					$lias['kolom'] = $asli['kolom'];
					$lias['isi_kolom'] = $asli['isi_kolom'];
					$lias['id_unit_kerja'] = $asli['id_unit_kerja'];

					$lias['nip'] = $asli['nip'];
					$lias['nama'] = $asli['nama'];
					$lias['email'] = '-';
					$lias['tlp'] = '-';
					$lias['foto'] = 'http://simpeg.kotabogor.go.id/simpeg/foto/'.$asli['id_pegawai'];

					$this->session->set_userdata($lias);
					$arraya = array('islogin'=>1);
					$return = array('status' => 'SUCCESS' , 'msg' => 'OK');
					echo json_encode($return);
				}
			}
		else{
			echo json_encode(array('status'=>'FAILED','msg'=>'Login Gagal'));
		}
	}

	public function out(){

		$arraya = array('islogin'=>0);
	//	$this->supermodel->updateData('user', 'user_id', $this->session->userdata('user_id'), $arraya);
		//inputLast('Logout');
		$this->input->set_cookie('true','',time()-10000);
		$this->input->set_cookie('890','',time()-10000);
		$this->input->set_cookie('412','',time()-10000);
		$this->session->sess_destroy();
		redirect('Welcome');
		session_destroy();
	}

}
