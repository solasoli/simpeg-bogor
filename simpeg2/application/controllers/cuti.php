<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cuti extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/cuti
	 *	- or -  
	 * 		http://example.com/index.php/cuti/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	 
	 function __construct(){
		parent::__construct();
		
		$this->load->model("cuti_model");	 
	}
	 
	public function index()
	{		
		$rekap = null;
		
		$this->load->model('cuti_model');
		$rekap = $this->cuti_model->recap_jenis_cuti_per_tahun();
		$cltn  = $this->cuti_model->get_by_id_jenis_cuti("CLTN");		
		
		$this->load->view('layout/header', array( 'title' => 'Cuti Pegawai Negeri Sipil'));
		$this->load->view('cuti/header');
		$this->load->view('cuti/index', array('rekap' => $rekap,
											  'cltn' => $cltn
		));
		$this->load->view('layout/footer');
	}
	
	public function daftar_pegawai(){				
		$cuti = null;
		
		$this->load->model("cuti_model");
		$cuti = $this->cuti_model->get_all();
		
		$this->load->view('layout/header');
		$this->load->view('cuti/header');
		$this->load->view('cuti/daftar_pegawai', array('cuti' => $cuti));
		$this->load->view('layout/footer');
	}
	
	public function pengaturan()
	{	
		$this->load->view('layout/header');
		$this->load->view('cuti/header');
		$data['cuti_bersama'] = $this->cuti_model->view_cuti_bersama();
		$data['libur_nasional'] = $this->cuti_model->view_libur_nasional();
		$this->load->view('cuti/pengaturan_v',$data);
		$this->load->view('layout/footer');
			
	}
	
	
	public function registrasi($id_pegawai=null)
	{
		authenticate($this->session->userdata('user'), "CUTI_ADD");	
		$kuota_cuti = 12;
		$kuota_terpakai = 0;
		$pegawai = null;		
		$riwayat_cuti = null;		

		// Tambahan
		$rs = $this->cuti_model->view_tanggal_cuti_bersama();
		$tgl_cuti_bersama[] = null;

		foreach ($rs->result() as $value) {
			$tgl_cuti_bersama[] = $value->tanggal;
		}

		//var_dump($tgl_cuti_bersama);
		//echo "<br/>";
		//echo "Jumla hari sah : " . $this->cek_hari_bukan_sabtu_minggu($tgl_cuti_bersama);
		
		$cuti_bersama = $this->cek_hari_bukan_sabtu_minggu($tgl_cuti_bersama);
		// akir tambahan

		if($id_pegawai){
			$this->load->model('pegawai_model');
			$pegawai = $this->pegawai_model->get_by_id($id_pegawai);						
		
			$this->load->model('cuti_model');
			$riwayat_cuti = $this->cuti_model->get_by_id_pegawai($id_pegawai);
			
			
			
			for($i = 0; $i<sizeof($riwayat_cuti);$i++){
				$riwayat_cuti[$i]->lama = $this->cuti_model->get_jumlah_hari_kerja($riwayat_cuti[$i]->tmt_awal,$riwayat_cuti[$i]->tmt_selesai);
				
				if($riwayat_cuti[$i]->id_jenis_cuti == 'C_TAHUNAN')
					$kuota_terpakai+=$riwayat_cuti[$i]->lama;
			}
			$kuota_cuti = $kuota_cuti - $kuota_terpakai;
			$k_c = $kuota_cuti -$cuti_bersama;
			$this->cuti_model->update_kuota($k_c,$id_pegawai);
		}
		//$cuti_bersama  = $this->cuti_model->hitung_cuti_bersama();
		//$cuti_bersama  = $this->cuti_model->jumlah_hari_cuti();

		$this->load->view('layout/header', array( 'title' => 'Cuti PNS'));
		$this->load->view('cuti/header');
		$this->load->view('cuti/registrasi', array('pegawai' => $pegawai,
								'riwayat_cuti' => $riwayat_cuti,
								'kuota_cuti' => $kuota_cuti,
								'kuota_terpakai' => $kuota_terpakai,
								'cuti_bersama' => $cuti_bersama,
		));
		$this->load->view('layout/footer');
	}

	public function cek_hari_bukan_sabtu_minggu($arrayHari){
		$hari_bukan_sabtu_minggu = 0;
		foreach ($arrayHari as $hari) {

			$tgl  = date_create($hari);

			if( strcasecmp( date_format($tgl, "l"), "Sunday") == 0){
				continue;
			}else if( strcasecmp( date_format($tgl, "l") , "Saturday") == 0 ){
				continue;
			}else if($hari == null){
				continue;
			}else{
				$hari_bukan_sabtu_minggu++ ;
			}
		}
		return $hari_bukan_sabtu_minggu;
	}

	public function cuti_sabtu_minggu( $tgl_awal, $tgl_akhir  ){
		$date1  = date_create($tgl_awal);
		$date2  = date_create($tgl_akhir);
		$diff   = date_diff($date1,$date2);

		$interval =  $diff->format("%a");
		$jumlah  = 0;
		
		
		//$hasil = $this->cuti_model->view_cuti_bersama();
		$hasil = $this->cuti_model->view_tanggal_cuti_bersama();
		
		$tgl[] = null;
		
		foreach($hasil->result() as $row){
			$tgl[] = $row->tanggal;
		}
		var_dump(date);
		
		
		for($i=1; $i<=$interval + 1; $i++){
			if( strcasecmp( date_format($date1, "l"), "Sunday") == 0){
				date_add($date1, date_interval_create_from_date_string("1 days"));
				continue;
			}else if( strcasecmp( date_format($date1, "l") , "Saturday") == 0 ){
				date_add($date1, date_interval_create_from_date_string("1 days"));
				continue;
			}
			else{
				$jumlah++ ;
				date_add($date1, date_interval_create_from_date_string("1 days"));
			}			
		}
		return $jumlah;
	}
	
	/*public function qr_code_cuti($new_id_cuti_pegawai)
	{
		include('assets/phpqrcode/qrlib.php'); 
		$tempDir = 'assets/cuti_qr_code'; 
		$codeContents = $new_id; 
     
		$fileName = '/'.$codeContents.'.png'; 
     
		$pngAbsoluteFilePath = $tempDir.$fileName; 
		$urlRelativeFilePath = base_url().'assets/cuti_qr_code/'.$fileName; 
     

		if (!file_exists($pngAbsoluteFilePath)) 
		{ 
			QRcode::png($codeContents, $pngAbsoluteFilePath); 
		} 
	}*/

	public function cetak_surat($id_cuti_pegawai){
		$this->load->library('Format');
		$this->load->model('cuti_model');
		//$this->qr_code_cuti($id_cuti_pegawai);
		$cuti = $this->cuti_model->get_by_id_cuti_pegawai($id_cuti_pegawai);		
		$cuti->tmt_awal = $this->format->tanggal_indo($cuti->tmt_awal);
		$cuti->tmt_selesai = $this->format->tanggal_indo($cuti->tmt_selesai);
	
		$this->load->view('cuti/surat_cuti', array(
			'cuti' => $cuti,
			'lama_cuti' => $this->cuti_model->get_jumlah_hari_kerja($cuti->tmt_awal, $cuti->tmt_selesai),
			'tgl_surat' => $this->format->tanggal_indo($this->input->post('datePickerTglSurat'))
		));
		
		$content = ob_get_clean();
			require_once('assets/pdf/html2pdf.class.php');
			try
			{
				$html2pdf = new HTML2PDF('P', 'legal', 'fr', true, 'UTF-8', 0);
				$html2pdf->writeHTML($content, isset($_GET['vuehtml']));
				$html2pdf->Output('cuti.pdf','I');
			}				
				catch(HTML2PDF_exception $e) {
				echo $e;
				exit;
			}
	}
		
	public function save(){
		authenticate($this->session->userdata('user'), "CUTI_SAVE");
		if($this->input->post('idPegawai')){
			/*$id_pegawai				= $this->input->post('idPegawai');
			$jenis_hukuman 				= $this->input->post('cboJenisHukuman');
			$no_keputusan 				= $this->input->post('txtNoKeputusan');
			$tanggal_penetapan 			= $this->input->post('txtNoKeputusan');
			$tmt 						= $this->input->post('txtTmt');
			$pejabat_pemberi_hukuman 	= $this->input->post('txtPejabatPemberiHukuman');
			$jabatan				 	= $this->input->post('txtJabatan');
			$keterangan				 	= $this->input->post('txtKeterangan');*/
			
			switch($this->input->post('cboJenisCuti')){
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
			
			$this->load->model('cuti_model');
			$last_id = $this->cuti_model->insert();
			
			/*if($this->input->post('simpan') != 'Simpan'){
				$this->cetak_surat($last_id);

			}
			else{
				$this->registrasi($this->input->post('idPegawai'));
			}
		}
		else{
			$this->registrasi();
		}*/
			
			if($this->input->post('simpan')==('Simpan')){
				$this->registrasi($this->input->post('idPegawai'));
			}
			else{
				$this->cetak_surat($last_id);
				$this->cuti_model->setIdPegawai($this->input->post('id_pegawai'));
				$this->cuti_model->insert_id_cuti_pegawai();
				
				$rs = $this->cuti_model->get_id_cuti_pegawai();
				$row = $rs->row();
							
				//$rs_id_cuti_pegawai = $this->cuti_model->get_id_cuti_pegawai();
				//$row_id_cuti_pegawai = $rs_id_cuti_pegawai->row();
				
				//$this->cuti_model->setIdJenisCuti($row_id_jenis_cuti->new_id_jenis_cuti);
				//$this->cuti_model->setIdCutiPegawai($row_id_cuti_pegawai->new_id_cuti_pegawai);
				$this->cuti_model->setIdCutiPegawai($row->new_id_cuti_pegawai);
				//$this->cuti_model->update_id_berkas_to_cuti();
				
				$this->view($last_id, $row->new_id_cuti_pegawai);
			}
		}
			else{
				$this->registrasi();
			}		
	}
	

	public function delete($id_cuti){
		authenticate($this->session->userdata('user'), "CUTI_DELETE");
		$this->load->model('cuti_model');		
		$this->cuti_model->delete($id_cuti);
	
		redirect('cuti/registrasi/'.$this->input->get('idp'));		
	}
	
	public function json_get_by_tingkat()
	{
		authenticate($this->session->userdata('user'), 'CUTI_VIEW_JENIS');
		$this->load->model("jenis_hukuman_model");
		$data = $this->jenis_hukuman_model->get_by_tingkat($this->input->post('tingkat'));
			
		echo json_encode($data);
	}
	
	public function json_get_kuota_cuti_tahunan()
	{		
		$this->load->model('cuti_model');				
		$kuota_cuti = $this->cuti_model->get_kuota_cuti_tahunan($this->input->post('id_pegawai'), $this->input->post('year'));
			
		echo json_encode($kuota_cuti);
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

	/*added by nisful*/
	public function proses_cuti(){				
		$cuti = null;
		
		$this->load->model("cuti_model");
		$cuti = $this->cuti_model->get_all();
		
		$this->load->view('layout/header');
		$this->load->view('cuti/header');
		$this->load->view('cuti/proses_cuti', array('cuti' => $cuti));
		$this->load->view('layout/footer');
	}

	public function delete_cuti_bersama()
	{
		$this->load->model('cuti_model');
		$this->cuti_model->setTanggal($this->uri->segment(3));
		$this->cuti_model->delete_cuti_bersama();
		redirect(base_url().'cuti/pengaturan');
	}

	public function delete_libur_nasional()
	{
		$this->load->model('cuti_model');
		$this->cuti_model->setTanggal($this->uri->segment(3));
		$this->cuti_model->delete_libur_nasional();
		redirect(base_url().'cuti/pengaturan');
	}

	public function edit_cuti_bersama()
	{
		$this->load->model('cuti_model');
		$this->cuti_model->setTanggal($this->uri->segment(3));
		$this->cuti_model->edit_cuti_bersama();
		//redirect(base_url().'cuti/pengaturan');
	}
	public function status()
	{
		$this->load->model('cuti_model');
		$id = $this->input->get('id_cuti');
		$id_jen = $this->input->get('id_jen');
		$id_peg = $this->input->get('id_peg');
		$tmt_awal = $this->input->get('awal');
		$tmt_selesai = $this->input->get('akhir');
		if ($id_jen=="C_TAHUNAN"){
			$hari_cuti = $this->cuti_model->get_jumlah_hari_kerja($tmt_awal,$tmt_selesai);

			//$query_s = mysql_query($sql_s);
			
			//echo $sql_s;
			$kuota = $this->cuti_model->get_kuota($id_peg);
			//echo $kuota.'-'.$hari_cuti;
			if($kuota >= $hari_cuti)
			{
			$this->cuti_model->update_status($id);	
			}else
			{
				echo "kuota penuh";
			}
		}
		else
		{
		$this->cuti_model->update_status($id);
		}
		redirect(base_url().'cuti/proses_cuti');
	}
	public function status_tidak()
	{
		$this->load->model('cuti_model');
		$id = $this->input->get('id_cuti');
		
		$this->cuti_model->update_status_tidak($id);	
		redirect(base_url().'cuti/proses_cuti');
	}
	
	public function riwayat_cuti_pegawai($id_pegawai=null)
	{
		authenticate($this->session->userdata('user'), "CUTI_ADD");	
		$kuota_cuti = 12;
		$kuota_terpakai = 0;
		$pegawai = null;		
		$riwayat_cuti = null;		

		// Tambahan
		$rs = $this->cuti_model->view_tanggal_cuti_bersama();
		$tgl_cuti_bersama[] = null;

		foreach ($rs->result() as $value) {
			$tgl_cuti_bersama[] = $value->tanggal;
		}

		//var_dump($tgl_cuti_bersama);
		//echo "<br/>";
		//echo "Jumla hari sah : " . $this->cek_hari_bukan_sabtu_minggu($tgl_cuti_bersama);
		
		$cuti_bersama = $this->cek_hari_bukan_sabtu_minggu($tgl_cuti_bersama);
		// akir tambahan

		if($id_pegawai){
			$this->load->model('pegawai_model');
			$pegawai = $this->pegawai_model->get_by_id($id_pegawai);						
		
			$this->load->model('cuti_model');
			$riwayat_cuti = $this->cuti_model->get_by_id_pegawai($id_pegawai);
			
			
			
			for($i = 0; $i<sizeof($riwayat_cuti);$i++){
				$riwayat_cuti[$i]->lama = $this->cuti_model->get_jumlah_hari_kerja($riwayat_cuti[$i]->tmt_awal,$riwayat_cuti[$i]->tmt_selesai);
				
				if($riwayat_cuti[$i]->id_jenis_cuti == 'C_TAHUNAN')
					$kuota_terpakai+=$riwayat_cuti[$i]->lama;
			}
			$kuota_cuti = $kuota_cuti - $kuota_terpakai;
			$k_c = $kuota_cuti -$cuti_bersama;
			$this->cuti_model->update_kuota($k_c,$id_pegawai);
		}
		//$cuti_bersama  = $this->cuti_model->hitung_cuti_bersama();
		//$cuti_bersama  = $this->cuti_model->jumlah_hari_cuti();

		$this->load->view('layout/header', array( 'title' => 'Cuti PNS'));
		$this->load->view('cuti/header');
		$this->load->view('cuti/riwayat_cuti');
		$this->load->view('cuti/riwayat_cuti', array('pegawai' => $pegawai,
								'riwayat_cuti' => $riwayat_cuti,
								'kuota_cuti' => $kuota_cuti,
								'kuota_terpakai' => $kuota_terpakai,
								'cuti_bersama' => $cuti_bersama,
		));
		$this->load->view('layout/footer');
	}
}

/* End of file cuti.php */
/* Location: ./application/controllers/cuti.php */
