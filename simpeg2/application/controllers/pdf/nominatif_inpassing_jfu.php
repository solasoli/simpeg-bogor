<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Nominatif_inpassing_jfu extends CI_Controller{

	function __construct(){
		
		parent::__construct();
		
		$this->load->model('pegawai_model','pegawai');
		$this->load->model('jabatan_model','jabatan');
		$this->load->library('format');
	}
	
	function index(){
			
		$this->load->library('pdf');
		//$this->pdf->SetHeaderMargin(0);
		$this->pdf->SetMargins(10,20,10); //left, top, right
		$this->pdf->setPrintFooter(false);
		
		
		$per_opd = $this->pegawai->get_list_id_pegawai_by_opd_staff();
		
		// data header
		$this->pdf->SetFont('times', 'B', 11);
		$this->pdf->AddPage('L','FOLIO');	
		
		
		$this->pdf->Cell(0, 7, 'LAMPIRAN SURAT PERINTAH', 0, 1, 'L');
		$this->pdf->SetFont('times', '', 11);
		$this->pdf->Cell(10, 5, 'NOMOR', 0, 0, 'L');
		$this->pdf->Cell(2, 5, ':', 0, 0, 'L');
		$this->pdf->Cell(0, 5, '', 0, 1, 'L');
		$this->pdf->Cell(0, 5, 'TANGGAL', 0, 0, 'L');
		$this->pdf->Cell(2, 5, ':', 0, 0, 'L');
		$this->pdf->Cell(0, 5, '', 0, 1, 'L');
		$this->pdf->ln();
		
		$this->pdf->Cell(10, 7, 'No', 1, 0, 'C');
		$this->pdf->Cell(60, 7, 'Nama', 1, 0, 'C');
		$this->pdf->Cell(40, 7, 'NIP', 1, 0, 'C');
		$this->pdf->Cell(40, 7, 'Tempat, Tgl Lahir', 1, 0, 'C');
		$this->pdf->Cell(40, 7, 'Pangkat, Gol/Ruang', 1, 0, 'C');
		$this->pdf->Cell(35, 7, 'Jabatan Lama', 1, 0, 'C');
		$this->pdf->Cell(40, 7, 'Jabatan Baru', 1, 0, 'C');
		$this->pdf->Cell(0, 7, 'Unit Kerja', 1, 1, 'C');
		$x=1;
		foreach($per_opd as $peg){
		$this->pegawai->set_id_pegawai($peg->id_pegawai);
		//$this->pegawai->set_nip('198506182010011007');
		$pegawai =& $this->pegawai->get_pegawai();
		$this->pdf->SetFont('times', '', 11);       				
		
		if($this->pegawai->get_jabatan(0,$pegawai->id_pegawai)){
			$new_jfu = $this->pegawai->get_jabatan(0,$pegawai->id_pegawai);
		}else{
			$new_jfu = 'Pengadministrasi Umum';
		}
		
		$pangkat_gol = $pegawai->pangkat.', '.$pegawai->pangkat_gol;
		
		$h_uk = 20;
		/*if((strlen($new_jfu) > 20 && strlen($new_jfu) <= 40 ) || strlen($pegawai->nama_baru) > 50 || strlen($pangkat_gol) > 22 ){
			$h_uk = 10;
		}elseif(strlen($new_jfu) > 40){
			$h_uk = 15;
		}else{
			$h_uk = 5;
		}*/
		
		
		
		$this->pdf->Multicell(10, $h_uk, $x++ , 1, 'L',0, 0);
		$this->pdf->Multicell(60, $h_uk, $pegawai->nama, 1, 'L',0, 0);
		$this->pdf->Multicell(40, $h_uk, $pegawai->nip_baru, 1, 'C',0, 0);
		$this->pdf->Multicell(40, $h_uk, strtoupper($pegawai->tempat_lahir).', '.$this->format->date_dmY($pegawai->tgl_lahir,'d/m/Y'), 1, 'C',0, 0);
		$this->pdf->Multicell(40, $h_uk, $pangkat_gol, 1, 'C',0, 0);
		$this->pdf->Multicell(35, $h_uk, $pegawai->jabatan, 1, 'C',0, 0);
		
		
		
		$this->pdf->Multicell(40, $h_uk, $new_jfu, 1, 'L',0, 0);
		$this->pdf->Multicell(0, $h_uk, $pegawai->nama_baru, 1, 'L',0, 1);
        
		//Close and output PDF document		
		}
		
        $this->pdf->Output('inpassing_jfu_'.$this->input->get('skpd').'.pdf');
	}
}