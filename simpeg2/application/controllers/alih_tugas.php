<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Alih_tugas extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/alih_tugas
	 *	- or -  
	 * 		http://example.com/index.php/alih_tugas/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscores will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{		
		$rekap = null;
		$rekap = '';
		
		$this->load->model('alih_tugas_model');
		$rekap = $this->alih_tugas_model->recap_per_tahun();		
		
		$this->load->view('layout/header', array( 'title' => 'KGB Pegawai Negeri Sipil'));
		$this->load->view('alih_tugas/header');
		$this->load->view('alih_tugas/index', array('rekap' => $rekap											 
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
		$this->load->view('alih_tugas/header');
		$this->load->view('alih_tugas/daftar_pegawai', array('skpd' => $skpd, 'kgb' => $kgb));
		$this->load->view('alih_tugas/footer');
	}
	
	public function laporan(){				
		$kgb = null;
		
		$this->load->model("skpd_model");
		$skpd = $this->skpd_model->get_all();
		
		if($this->input->get('skpd') != null){
			$this->load->model('alih_tugas_model');
			$alih_tugas = $this->alih_tugas_model->get_laporan_alih_tugas(
				$this->input->get('skpd'),
				$this->input->get('tahun'),
				$this->input->get('bulan')
			);				
			$this->load->view('layout/report_header');	
			$this->load->view('alih_tugas/laporan', array('skpd' => $skpd, 'alih_tugas' => $alih_tugas));
			$this->load->view('layout/report_footer');	
		}	
		else{
			$this->load->view('layout/header');
			$this->load->view('alih_tugas/header');
			$this->load->view('alih_tugas/laporan', array('skpd' => $skpd, 'alih_tugas' => $alih_tugas));
			$this->load->view('layout/footer');
		}								
	}
	
	public function registrasi($id_pegawai=null){
		authenticate($this->session->userdata('user'), "CUTI_ADD");		
		
		$pegawai = null;		
		$riwayat_alih_tugas = null;
		$tahun_pp = null;
		$dasar_sk = null;
		$pengesah = null;
		$unit_kerja = null;
		$atas_nama = null;
		
		if($id_pegawai){
			$this->load->model('pegawai_model');
			$pegawai = $this->pegawai_model->get_by_id($id_pegawai);
				
			$this->load->model('alih_tugas_model');
			$riwayat_alih_tugas = $this->alih_tugas_model->get_by_id_pegawai($id_pegawai);
			
			$this->load->model('gapok_model');
			$tahun_pp = $this->gapok_model->get_tahun();		
			
			$this->load->model('skpd_model');
			$unit_kerja = $this->skpd_model->get_all_unit_kerja();		
			
			if($this->input->get('ids')){
				$this->load->model('sk_model');
				$dasar_sk = $this->sk_model->get_by_id_sk($this->input->get('ids'));				
				$pengesah = $this->sk_model->get_pengesah_sk($pegawai->pangkat_gol);
			}					
		}
					
		$this->load->view('layout/header', array( 'title' => 'KGB PNS'));
		$this->load->view('alih_tugas/header');
		$this->load->view('alih_tugas/registrasi', array('pegawai' => $pegawai,
							   'riwayat_alih_tugas' => $riwayat_alih_tugas,
							   'tahun_pp' => $tahun_pp,							    
							   'dasar_sk' => $dasar_sk,   								       
							   'pengesah' => $pengesah[0],
							   'atas_nama' => $atas_nama[1],
							   'unit_kerja' => $unit_kerja,   								       
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
		$pengesah = $this->sk_model->get_pengesah_sk($pegawai->pangkat_gol);
		
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
/* Location: ./application/controllers/alih_tugas.php */
