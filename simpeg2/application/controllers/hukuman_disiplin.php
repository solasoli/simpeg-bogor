<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Hukuman_disiplin extends CI_Controller {

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

		$this->load->model('hukuman_model');
		$rekap = $this->hukuman_model->recap_tingkat_hukuman_per_tahun();				
		
		$this->load->view('layout/header', array( 'title' => 'Hukuman Disiplin Pegawai'));
		$this->load->view('hukuman_disiplin/header');
		$this->load->view('hukuman_disiplin/index', array('rekap' => $rekap));
		$this->load->view('layout/footer');
	}
	
	public function daftar_pegawai(){
		$this->load->model('hukuman_model');
		$hukuman = $this->hukuman_model->get_terhukum();
		
		$this->load->view('layout/header');
		$this->load->view('hukuman_disiplin/header');
		$this->load->view('hukuman_disiplin/daftar_pegawai', array('hukuman' => $hukuman));
		$this->load->view('layout/footer');
	}
	
	public function penjatuhan($id_pegawai=null)
	{
		authenticate($this->session->userdata('user'), "HUKDIS_PENJATUHAN");		
		$pegawai = null;
		$jenis_hukuman = null;		
		$riwayat_hukuman = null;
		if($id_pegawai){
			$this->load->model('pegawai_model');
			$pegawai = $this->pegawai_model->get_by_id($id_pegawai);
			
			$this->load->model('jenis_hukuman_model');
			$jenis_hukuman = $this->jenis_hukuman_model->get_by_tingkat('RINGAN');					
		
			$this->load->model('hukuman_model');
			$riwayat_hukuman = $this->hukuman_model->get_by_id_pegawai($id_pegawai);
		}
		
		$this->load->view('layout/header', array( 'title' => 'Hukuman Disiplin Pegawai'));
		$this->load->view('hukuman_disiplin/header');
		$this->load->view('hukuman_disiplin/penjatuhan', array('pegawai' => $pegawai,
								       'riwayat_hukuman' => $riwayat_hukuman,
								       'jenis_hukuman' => $jenis_hukuman,								       
		));
		$this->load->view('layout/footer');
	}

	public function save(){
		authenticate($this->session->userdata('user'), "HUKDIS_SAVE");
		if($this->input->post('idPegawai')){
			/*$id_pegawai					= $this->input->post('idPegawai');
			$jenis_hukuman 				= $this->input->post('cboJenisHukuman');
			$no_keputusan 				= $this->input->post('txtNoKeputusan');
			$tanggal_penetapan 			= $this->input->post('txtNoKeputusan');
			$tmt 						= $this->input->post('txtTmt');
			$pejabat_pemberi_hukuman 	= $this->input->post('txtPejabatPemberiHukuman');
			$jabatan				 	= $this->input->post('txtJabatan');
			$keterangan				 	= $this->input->post('txtKeterangan');*/
			
			switch($this->input->post('cboJenisHukuman')){
				case 1	:
					//$pegawai = '';
					//$this->load->library('hukuman_disiplin/hukuman', array($pegawai));
					
					break;	
				case 2	:
					break;	
				case 3	:
					break;	
				case 4	:
					break;
				case 5	:
					break;	
				case 6	:
					break;	
				case 7	:
					break;
				case 8	:
					break;	
				case 9	:
					break;	
				case 10 :
					break;	
				case 11 :					
					break;				
			}
			//$this->load->library('hukuman', array($pegawai));
			
			$this->load->model('hukuman_model');
			$this->hukuman_model->insert();
			$this->penjatuhan($this->input->post('idPegawai'));
		}
		else{
			$this->penjatuhan();
		}
	}

	public function delete($id_hukuman){
		authenticate($this->session->userdata('user'), "HUKDIS_DELETE");
		$this->load->model('hukuman_model');		
		$this->hukuman_model->delete($id_hukuman);
	
		redirect('hukuman_disiplin/penjatuhan/'.$this->input->get('idp'));		
	}
	
	public function json_get_by_tingkat()
	{
		authenticate($this->session->userdata('user'), 'HUKDIS_VIEW_JENIS');
		$this->load->model("jenis_hukuman_model");
		$data = $this->jenis_hukuman_model->get_by_tingkat($this->input->post('tingkat'));
			
		echo json_encode($data);
	}
}

/* End of file hukuman_disiplin.php */
/* Location: ./application/controllers/hukuman_disiplin.php */
