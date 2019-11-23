<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Inpassing extends CI_Controller{

	function __construct(){
	
		parent::__construct();
		$this->load->model("skpd_model");
		$this->load->model("pegawai_model","pegawai");
		$this->load->model("jabatan_model","jabatan");
	}
	
	function index(){
		
		/*$this->load->view('layout/header', array( 'title' => 'Inpassing'));
		$this->load->view('inpassing/header');		
		$this->load->view('layout/footer');
		*/
		$this->gaji();
	}
	
	public function gaji(){				
		$kgb = null;
				
		$skpd = $this->skpd_model->get_all();
		
		if($this->input->get('skpd') != null){
			$this->load->model('kgb_model');
			$kgb = $this->kgb_model->get_laporan_kgb(
				$this->input->get('skpd'),
				$this->input->get('tahun'),
				$this->input->get('bulan')
			);				
			$this->load->view('layout/report_header');	
			$this->load->view('kgb/laporan', array('skpd' => $skpd, 'kgb' => $kgb));
			$this->load->view('layout/report_footer');	
		}	
		else{
			$this->load->view('layout/header');
			//$this->load->view('inpassing/header');
			$this->load->view('inpassing/laporan', array('skpd' => $skpd, 'kgb' => $kgb));
			$this->load->view('layout/footer');
		}								
	}
	
	public function jfu($id_skpd=NULL){
		
		$skpd = $this->skpd_model->get_all();
		if($id_skpd){
			
			$data = $this->pegawai->get_list_id_pegawai_by_opd_staff($id_skpd);
			$this->load->view('layout/header');
			$this->load->view('inpassing/header');
			$this->load->view('inpassing/jfu',array('skpd' => $skpd,'pegawai'=>$data));
			$this->load->view('layout/footer');
		}else{
							
			$this->load->view('layout/header');
			$this->load->view('inpassing/header');
			$this->load->view('inpassing/jfu',array('skpd' => $skpd));
			$this->load->view('layout/footer');
		}
	}
	
	public function rekap_jfu($kode_jabatan=NULL){
	
		$this->load->model('jabatan_model','jabatan');
		if($kode_jabatan){
			//echo $kode_jabatan;
			$data = array('list_jfu'=>$this->jabatan->get_list_jfu_existing(),'list_pegawai'=>$this->jabatan->get_list_pegawai_by_jfu($kode_jabatan));
		}else{
			
			$data = array('list_jfu'=>$this->jabatan->get_list_jfu_existing());			
		}
		
		$this->load->view('layout/header');
		$this->load->view('inpassing/header');
		$this->load->view('inpassing/rekap_jfu',$data);
		$this->load->view('layout/footer');
	}
	
	public function nominatif_jfu(){
		$this->load->model('jabatan_model','jabatan');
		$data = array('nominatifs'=>$this->jabatan->get_list_pegawai_by_jfu());
		$this->load->view('layout/header');
		$this->load->view('inpassing/header');
		$this->load->view('inpassing/nominatif_jfu',$data);
		$this->load->view('layout/footer');
	}
	
	
}
