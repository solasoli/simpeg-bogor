<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Unit_kerja extends CI_Controller {



	public function __construct(){
		
		parent::__construct();
		$this->load->model('skpd_model');
		$this->load->library('format');
	}
	
	public function json_get_current_all()
	{
		
		$data = $this->skpd_model->get_all();
		echo json_encode($data);
	}	
	
	// unit kerja -------
	function daftar(){
		
		$data['daftarUnitKerja'] = $this->skpd_model->get_all_unit_kerja();
		$this->load->view('master/opd_daftar',$data);
	}

	// opd -------
	public function daftar_opd(){
		$this->load->view('layout/header', array( 'title' => '', 'idproses' => 1));
		$this->load->view('master/header_unit_kerja');
		$this->load->model('unit_kerja_model', 'Unit_kerja_model');
		$list_data = $this->Unit_kerja_model->listOPD();
		$this->load->view('master/list_opd', array('list_data' => $list_data));
		$this->load->view('layout/footer');
	}
	
	public function daftar_pegawai($id_skpd = NULL){
	
		$this->load->model('pegawai_model','pegawai');
		$this->load->model('jabatan_model');
		if(!$id_skpd){
			$id_skpd = $this->session->userdata('user')->id_skpd;
		}
		$data['list'] = $this->pegawai->get_list_id_pegawai_by_unitkerja($id_skpd);
		$data['nama_opd'] = $this->skpd_model->get_by_id($id_skpd)->nama_baru;
		//$data = array('list'=>$list);
		$this->load->view('layout/header');
		$this->load->view('master/opd_daftar_pegawai',$data);
		$this->load->view('layout/footer');
	}
	
	public function daftar_kp(){
	
		$this->load->model('pegawai_model','pegawai');
				
		$data['list'] = $this->pegawai->get_list_kp();
		$this->load->view('layout/header');
		$this->load->view('master/kp_daftar_pegawai',$data);
		$this->load->view('layout/footer');
	}
	
	public function simpan_kp(){
	
		
		 $idp=$this->input->post('idp');
		 $status=$this->input->post('radio');
		$this->load->model('pegawai_model','pegawai');
		$this->pegawai->save_kp($idp,$status);		
		$data['list'] = $this->pegawai->get_list_kp();
		$this->load->view('layout/header');
		$this->load->view('master/kp_daftar_pegawai',$data);
		$this->load->view('layout/footer');
	}
	
	
	
	
	
	// end of unit kerja
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
