<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class skp extends CI_Controller{
	
	function __construct(){
		parent::__construct();
		$this->load->model("skp_model");
	}
	
	public function index($tahun=NULL){
		
		$tahun = isset($tahun) ? $tahun : date('Y');
		$getSKPD = $this->skp_model->get_rekap_tahun($tahun);
		
		$data['list_skpd'] = $getSKPD;
		
		
		
		$this->load->view('layout/header');
		$this->load->view('skp/home', $data);
		$this->load->view('layout/footer');
		
	}
	
	public function blocked(){
		
		$getSKPD = $this->skp_model->get_opd();
		$data['list_skpd'] = $getSKPD;
		$data['status_all'] = $this->skp_model->get_status_all();
		$i = 0;
		foreach($data['list_skpd'] as $skpd){
			$data['list_skpd'][$i]->status = $this->skp_model->get_status_opd($skpd->id_unit_kerja);
			$i++;
		}
		
		$this->load->view('layout/header');
		$this->load->view('skp/blocked',$data);
		$this->load->view('layout/footer');
	}
	
	public function toggle(){
				
		if($this->skp_model->toggle()){
			echo "BERHASIL";
		}else{
			echo "GAGAL";
		}
		
	}
	
	public function toggle_opd(){
				
		if($this->skp_model->toggle_opd($this->input->post('id_skpd'))){
			echo "BERHASIL";
		}else{
			echo "GAGAL";
		}
		
	}
	
	public function toggle_pegawai(){
		if($this->skp_model->toggle_pegawai($this->input->post('id_pegawai'))){
			echo "BERHASIL";
		}else{
			echo "GAGAL";
		}
	}
	
	public function blocked_detail($id_opd){
		
		if(!$id_opd){
			redirect('skp');
		}
		
		$data['pegawais'] = $this->skp_model->get_detail($id_opd);
		$i=0;
		foreach($data['pegawais'] as $pns){
			$data['pegawais'][$i]->status = $this->skp_model->get_status_pegawai($pns->id_pegawai);
			$i++;
		}
		
		$this->load->view('layout/header');
		$this->load->view('skp/blocked_detail', $data);
		$this->load->view('layout/footer');
	}
}