<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ipasn extends CI_Controller {



	public function __construct(){
		
		parent::__construct();
		$this->load->model('skpd_model');
		
	}
	
	public function json_get_current_all()
	{
		
		$data = $this->skpd_model->get_all();
		echo json_encode($data);
	}	
	
	// unit kerja -------
	function index(){
		$data['daftarUnitKerja'] = $this->skpd_model->get_all_unit_kerja();
		$this->load->view('master/ipasn',$data);
	}
	
	public function save()
	{
	
	$idj= $this->input->post('idj');
	$skpd= $this->input->post('skpd');
	$no= $this->input->post('no');
	
	if(is_numeric($this->input->post('pendidikan')) and is_numeric($this->input->post('pengalaman')) and is_numeric($this->input->post('pelatihan')) and is_numeric($this->input->post('administrasi')))
	{
	
	$cek=$this->skpd_model->cek_ipasn($idj);
		if($cek->jumlah==0){
			$this->skpd_model->insert_ipasn($idj);
			redirect("ipasn/daftar_pejabat/$skpd");
		}else{
			$this->skpd_model->update_ipasn($idj);
			redirect("ipasn/daftar_pejabat/$skpd#a$no");
		}

	}
	
	echo("<br>");
	
	
	}


	public function daftar_pejabat($id_skpd = NULL){
	
		$this->load->model('pegawai_model','pegawai');
		$this->load->model('jabatan_model');
		if(!$id_skpd){
			$id_skpd = $this->session->userdata('user')->id_skpd;
		}
		$data['list'] = $this->pegawai->get_list_id_pejabat_by_unitkerja($id_skpd);
		$data['nama_opd'] = $this->skpd_model->get_by_id($id_skpd)->nama_baru;
		$data['id_skpd'] = $id_skpd;
		//$data = array('list'=>$list);
		$this->load->view('layout/header');
		$this->load->view('master/opd_daftar_pejabat',$data);
		$this->load->view('layout/footer');
	}
	
	// end of unit kerja

	public function list_report_ipp(){
		$this->load->view('layout/header', array( 'title' => '', 'idproses' => 1));
		$this->load->view('master/header_ipasn');
		$this->load->model('ipp_asn_model');
		$list_data = $this->ipp_asn_model->listOPDforReport();
		$this->load->view('master/list_opd_for_report', array('list_data' => $list_data));
		$this->load->view('layout/footer');
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
