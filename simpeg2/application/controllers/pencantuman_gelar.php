<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pencantuman_gelar extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/pencantuman_gelar
	 *	- or -  
	 * 		http://example.com/index.php/pencantuman_gelar/index
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
		$rekap = null;
		$rekap = '';
		
		$this->load->model('pencantuman_gelar_model');
		$rekap = $this->pencantuman_gelar_model->recap_per_tahun();
		//$cltn  = $this->cuti_model->get_by_id_jenis_cuti("CLTN");
		
		$this->load->view('layout/header', array( 'title' => 'Pencantuman Gelar'));
		$this->load->view('pencantuman_gelar/header');
		$this->load->view('pencantuman_gelar/index', array('rekap' => $rekap											 
		));
		$this->load->view('layout/footer');
	}
	
	public function get_gapok(){
		$golongan 	= $this->input->post('golongan');
		$masa_kerja = $this->input->post('masa_kerja');
		$tahun = $this->input->post('tahun');
		
		$this->load->model('gapok_model');
		$gapok = $this->gapok_model->get_gapok($golongan, $masa_kerja, $tahun);
		if(is_numeric($gapok->gaji))
			echo $gapok->gaji;
		else
			echo 'error';
	}
	
	public function json_get_gapok(){
		$golongan 	= $this->input->post('golongan');
		$masa_kerja = $this->input->post('masa_kerja');
		$tahun = $this->input->post('tahun');
		
		$this->load->model('gapok_model');
		$gapok = $this->gapok_model->get_gapok($golongan, $masa_kerja, $tahun);
		if(is_numeric($gapok->gaji))
			echo json_encode($gapok);
		else
			echo 'error';
	}
	
	public function nominatif(){				
		$kgb = null;
		
		$this->load->model("skpd_model");
		$skpd = $this->skpd_model->get_all();
		
		if($this->input->get('skpd') != null){
			$this->load->model('kgb_model');
			$kgb = $this->kgb_model->get_daftar_kgb(
				$this->input->get('skpd'),
				$this->input->get('tahun'),
				$this->input->get('bulan')
			);
		}
		
		$this->load->view('layout/header');
		$this->load->view('kgb/header');
		$this->load->view('kgb/daftar_pegawai', array('skpd' => $skpd, 'kgb' => $kgb));
		$this->load->view('layout/footer');
	}
	
	public function laporan(){				
		$kgb = null;
		
		$this->load->model("skpd_model");
		$skpd = $this->skpd_model->get_all();
		
		$this->load->model('kgb_model');
		$list_tahun = $this->kgb_model->get_list_tahun_sk();
			
		if($this->input->get('skpd') != null){		
			$kgb = $this->kgb_model->get_laporan_kgb(
				$this->input->get('skpd'),
				$this->input->get('tahun'),
				$this->input->get('bulan')
			);			
				
			$this->load->view('layout/report_header');	
			$this->load->view('kgb/laporan', array(
							'skpd' => $skpd, 
							'list_tahun' => $list_tahun,
							'kgb' => $kgb));
			$this->load->view('layout/report_footer');	
		}	
		else{
			$this->load->view('layout/header');
			$this->load->view('kgb/header');
			$this->load->view('kgb/laporan', array(
							'skpd' => $skpd, 
							'list_tahun' => $list_tahun,
							'kgb' => $kgb));
			$this->load->view('layout/footer');
		}								
	}
	
	public function registrasi($id_pegawai=null){
		authenticate($this->session->userdata('user'), "PENCANTUMAN_GELAR_ADD");		
		
		$pegawai = '';		
		$riwayat_pendidikan = null;
		$daftar_sk = null;
		
		if($id_pegawai){
			$this->load->model('pegawai_model');
			$pegawai = $this->pegawai_model->get_by_id($id_pegawai);
			
			$this->load->model('pendidikan_model');			
			$riwayat_pendidikan = $this->pendidikan_model->get_by_id_pegawai($id_pegawai);
						
			$this->load->model('sk_model');
			$daftar_sk = $this->sk_model->get_sk_pegawai_by_kategori($id_pegawai,5);
			$sk_gelar = $this->sk_model->get_sk_pegawai_by_kategori($id_pegawai,27);
		
			if($sk_gelar)
				$daftar_sk = array_merge($daftar_sk, $sk_gelar);										
		}
					
		$this->load->view('layout/header', array( 'title' => 'Pencantuman Gelar'));
		$this->load->view('pencantuman_gelar/header');
		$this->load->view('pencantuman_gelar/registrasi', array('pegawai' => $pegawai,
							   'riwayat_pendidikan' => $riwayat_pendidikan,
								'daftar_sk' => $daftar_sk,				       			   								      
		));
		$this->load->view('layout/footer');
	}

	public function view($id_sk){
		$this->load->model('sk_model');
		$this->load->model('pegawai_model');
		
		$sk = $this->sk_model
				   ->get_by_id_sk($id_sk);
				   
		$dasar_sk = $this->sk_model
				         ->get_by_id_sk($sk->id_dasar_sk);
				
		$pegawai = $this->pegawai_model->get_by_id($sk->id_pegawai);
		
		$pengesah = $this->sk_model->get_pengesah_sk($pegawai);
		
		$this->load->view('kgb/sk', array(
			'dasar_sk' => $dasar_sk,
			'sk' => $sk,
			'pegawai' => $pegawai,
			'pengesah' => $pengesah[0],
			'atas_nama' => $pengesah[1]
		));
	}
	
	public function reprint($id_sk){
		authenticate($this->session->userdata('user'), "CUTI_ADD");				
		$this->view($id_sk);
	}
	
	public function save(){
		authenticate($this->session->userdata('user'), "CUTI_SAVE");
		if($this->input->post('idPegawai')){
			$last_id = 0;
			
			$this->load->model('sk_model');
			
			if($this->input->post('add_dasar') == 1){
				
			}else{
				// VALIDATE
				
				// UPDATE DASAR SK
				$dasar_sk = $this->sk_model
					->get_by_id_sk($this->input->post('id_dasar_sk'));
				
				$this->sk_model->id_sk 			= $dasar_sk->id_sk;
				$this->sk_model->id_pegawai 	= $dasar_sk->id_pegawai;
				$this->sk_model->id_kategori_sk = $dasar_sk->id_kategori_sk;
				$this->sk_model->no_sk 			= $this->input->post('txtNoDasarSk');
				$this->sk_model->tgl_sk 		= $this->input->post('txtTanggalDasarSk');
				$this->sk_model->pemberi_sk 	= $this->input->post('txtPemberiSk');
				$this->sk_model->pengesah_sk 	= $dasar_sk->pengesah_sk;
				$this->sk_model->keterangan 	= $this->input->post('cboGolonganDasarSk').",".
												  $this->input->post('makerDasarTahun').",".
												  $this->input->post('makerDasarBulan');
				$this->sk_model->tmt 			= $this->input->post('txtTmtDasarSk');
				$this->sk_model->id_j 			= $dasar_sk->id_j;
				$this->sk_model->id_berkas 		= $dasar_sk->id_berkas;
				$this->sk_model->id_gapok 		= $this->input->post('id_gapok_dasar');
				$this->sk_model->id_dasar_sk	= $dasar_sk->id_dasar_sk;	
				$this->sk_model->id_unit_kerja 	= '0';			
				$this->sk_model->update();
								
				// INSERT KGB BARU				
				$this->sk_model->id_sk 			= 0;
				$this->sk_model->id_pegawai 	= $dasar_sk->id_pegawai;
				$this->sk_model->id_kategori_sk = 9;
				$this->sk_model->no_sk 			= $this->input->post('txtNoSk');
				$this->sk_model->tgl_sk 		= $this->input->post('txtTanggalSk');
				$this->sk_model->pemberi_sk 	= $this->input->post('pemberi_sk');
				$this->sk_model->pengesah_sk 	= $this->input->post('pengesah_sk');
				$this->sk_model->keterangan 	= $this->input->post('cboGolongan').",".
												  $this->input->post('makerTahun').",".
												  $this->input->post('makerBulan');
				$this->sk_model->tmt 			= $this->input->post('txtTmtm');
				$this->sk_model->id_j 			= 0;
				$this->sk_model->id_berkas 		= 0;
				$this->sk_model->id_gapok 		= $this->input->post('id_gapok');
				$this->sk_model->id_dasar_sk	= $this->input->post('id_dasar_sk');
				$this->sk_model->id_unit_kerja	= $this->input->post('id_unit_kerja');
				$last_id = $this->sk_model->insert();
				
			}											
			
			if($this->input->post('simpan') == 'Simpan')
				$this->registrasi($this->input->post('idPegawai'));
			else
				$this->view($last_id);
		}
		else{
			$this->registrasi();
		}
	}

	public function delete($id_sk){
		authenticate($this->session->userdata('user'), "CUTI_DELETE");
		
		$this->load->model('sk_model');		
		$this->sk_model->delete($id_sk);
	
		redirect('kgb/registrasi/'.$this->input->get('idp'));		
	}
	
	public function json_get_by_tingkat(){
		authenticate($this->session->userdata('user'), 'CUTI_VIEW_JENIS');
		$this->load->model("jenis_hukuman_model");
		$data = $this->jenis_hukuman_model->get_by_tingkat($this->input->post('tingkat'));
		
		echo json_encode($data);
	}

	public function pengaktifan(){
		$cltn = null;
		
		$this->load->model('cuti_model');
		$cltn = $this->cuti_model->get_by_status_lapor(0);
		
		$this->load->view('layout/header');
		$this->load->view('cuti/header');
		$this->load->view('cuti/pengaktifan', array('cltn' => $cltn));
		$this->load->view('layout/footer');
	}
	
	public function cetak_surat($id_cuti_pegawai){
		$this->load->model('cuti_model');
		$cuti = $this->cuti_model->get_by_id_cuti_pegawai($id_cuti_pegawai);
		$this->load->view('cuti/surat_cuti', array('cuti' => $cuti));
	}
}

/* End of file kgb.php */
/* Location: ./application/controllers/kgb.php */
