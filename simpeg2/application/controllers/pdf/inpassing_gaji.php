<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Inpassing_gaji extends CI_Controller{

	function __construct(){
		
		parent::__construct();
		
		$this->load->model('pegawai_model','pegawai');
		$this->load->model('jabatan_model','jabatan');
		$this->load->library('format');
	}
	
	function index(){
			
		$this->load->library('pdf');
		$this->pdf->SetHeaderMargin(0);
		$this->pdf->setPrintFooter(false);
		
		
		$per_opd = $this->pegawai->get_list_id_pegawai_by_opd($this->input->get('skpd'));
		
		foreach($per_opd as $peg){
		$this->pegawai->set_id_pegawai($peg->id_pegawai);
		//$this->pegawai->set_nip('198506182010011007');
		$pegawai =& $this->pegawai->get_pegawai();
		
		// data header
		$this->pdf->SetFont('times', 'B', 13);
		$this->pdf->AddPage('P','FOLIO');	
       	$this->pdf->ln(40);
        $this->pdf->Cell(0, 5, 'PETIKAN', 0, 0, 'C');        
        $this->pdf->ln();
		$this->pdf->Cell(0, 5, 'KEPUTUSAN WALIKOTA BOGOR', 0, 0, 'C');        
        $this->pdf->ln();
		$this->pdf->SetFont('times', '', 12);
		$this->pdf->Cell(0, 5, 'Nomor : '.$this->input->get('no'), 0, 1, 'C');        
		$this->pdf->SetFont('times', 'B', 12);
		$this->pdf->Cell(0, 5, 'Tentang', 0, 0, 'C');      
		$this->pdf->ln(5);
		$this->pdf->Cell(0, 5, 'PENYESUAIAN GAJI POKOK PEGAWAI NEGERI SIPIL', 0, 1, 'C');      
		$this->pdf->Cell(0, 5, 'DI LINGKUNGAN PEMERINTAH KOTA BOGOR', 0, 0, 'C');      
		$this->pdf->ln(5);
		$this->pdf->Cell(0, 5, 'DENGAN RAHMAT TUHAN YANG MAHA ESA', 0, 1, 'C');      
		$this->pdf->ln(5);
		$this->pdf->Cell(0, 5, 'WALIKOTA BOGOR', 0, 1, 'C');      
		//$this->pdf->ln();
		$w = 70;
		$w1 = 30;
		$h = $h_jab = $h_uk = 7;
		$s = ' ';
		$this->pdf->SetFont('times', '', 11);
		$this->pdf->Cell(30, 5, 'Menimbang', 0 , 0, 'L');
		$this->pdf->Cell(5, 5, ' : ', 0 , 0, 'L'); 		
		$this->pdf->Cell(0, 5, ' dst;', 0 , 1, 'L'); 		
		$this->pdf->Cell(30, 5, 'Mengingat', 0 , 0, 'L');
		$this->pdf->Cell(5, 5, ' : ', 0 , 0, 'L'); 		
		$this->pdf->Cell(0, 5, ' dst;', 0 , 1, 'L'); 			
		$this->pdf->SetFont('times', 'B', 11);
		$this->pdf->Cell(0, 5, 'MEMUTUSKAN', 0 , 1, 'C');
		$this->pdf->SetFont('times', '', 11);
		
        $this->pdf->Cell($w1, 5, 'Menetapkan ', 0, 0, 'L');
		$this->pdf->Cell(0, 5, ' : ', 0 , 1, 'L'); 	
		$this->pdf->Cell($w1, 5, 'KESATU ', 0 , 0, 'L'); 	
		$this->pdf->Cell(5, 5, ' : ', 0 , 0, 'L'); 	
		$this->pdf->Multicell(0, $h, 'Terhitung mulai tanggal '.$this->format->date_Ymd($this->input->get('tmt'),"d M Y").' menyesuaikan Gaji Pokok Calon Pegawai Negeri Sipil / Pegawai Negeri Sipil sebagai berikut:', 0, 'L',0, 1);
		$this->pdf->SetFont('times', '', 11);
		//$this->pdf->ln();
		/*
		$this->pdf->Cell($w1+5, $h, '', 0, 0, 'L');
		$this->pdf->Cell($h, $h, '1.', 1, 0, 'C');
		$this->pdf->Cell($w, $h, $s.'No. Urut', 1, 0, 'L');
		$this->pdf->Cell(0, $h, $s.'....', 1, 1, 'L');
		*/
		$this->pdf->Cell($w1+5, $h, '', 0, 0, 'L');
		$this->pdf->Cell($h, $h, '1.', 1, 0, 'C');
		$this->pdf->Cell($w, $h, $s.'Nama', 1, 0, 'L');
		$this->pdf->Cell(0, $h, $s.$pegawai->nama, 1, 1, 'L');
		
		$this->pdf->Cell($w1+5, $h, '', 0, 0, 'L');
		$this->pdf->Cell($h, $h, '2.', 1, 0, 'C');
		$this->pdf->Cell($w, $h, $s.'NIP', 1, 0, 'L');
		$this->pdf->Cell(0, $h, $s.$pegawai->nip_baru, 1, 1, 'L');
		
		$this->pdf->Cell($w1+5, $h, '', 0, 0, 'L');
		$this->pdf->Cell($h, $h, '3.', 1, 0, 'C');
		$this->pdf->Cell($w, $h, $s.'Tempat, tanggal lahir', 1, 0, 'L');
		$this->pdf->Cell(0, $h, $s.$pegawai->tempat_lahir.', '.$this->format->date_dmY($pegawai->tgl_lahir,"d M Y"), 1, 1, 'L');
		
		$this->pdf->Cell($w1+5, $h, '', 0, 0, 'L');
		$this->pdf->Cell($h, $h, '4.', 1, 0, 'C');
		$this->pdf->Cell($w, $h, $s.'Pangkat, Golongan ruang', 1, 0, 'L');
		$this->pdf->Cell(0, $h, $s.$pegawai->pangkat.' - '.$pegawai->golongan, 1, 1, 'L');
		
		$this->pdf->Cell($w1+5, $h, '', 0, 0, 'L');
		$this->pdf->Cell($h, $h, '5.', 1, 0, 'C');
		$this->pdf->Cell($w, $h, $s.'Masa Kerja Golongan', 1, 0, 'L');
		// unit test
		$tmt_cpns = $this->pegawai->get_tmt_cpns($pegawai->id_pegawai);
		$mk = $this->pegawai->hitung_masakerja($tmt_cpns,3,0);	
		//$mk_gol = $this->pegawai->hitung_masakerja_golongan($mk,)
		$this->pdf->Cell(0, $h, $s.$mk['tahun'].' Tahun '. $mk['bulan'].' Bulan', 1, 1, 'L');
		
		$this->pdf->Cell($w1+5, $h, '', 0, 0, 'L');
		$this->pdf->Cell($h, $h, '6.', 1, 0, 'C');
		$this->pdf->Cell($w, $h, $s.'Gaji pokok lama', 1, 0, 'L');		
		$this->pdf->Cell(0, $h, 'Rp.'.$this->format->currency($this->pegawai->get_gaji_pokok($this->input->get('tahun')-2 , $pegawai->golongan , $mk['tahun'])->gaji), 1, 1, 'L');
		
		$this->pdf->Cell($w1+5, $h, '', 0, 0, 'L');
		$this->pdf->Cell($h, $h, '7', 1, 0, 'C');
		$this->pdf->Cell($w, $h, $s.'Gaji pokok baru', 1, 0, 'L');
		$this->pdf->Cell(0, $h, 'Rp.'.$this->format->currency($this->pegawai->get_gaji_pokok($this->input->get('tahun')-1 , $pegawai->golongan , $mk['tahun'])->gaji), 1, 1, 'L');
		
		/******/
		$gol;
		if(preg_match("[III/]",$pegawai->golongan) or preg_match("[IV/]",$pegawai->golongan)){
			$gol = 'GENAP';
			$mk_next['tahun'] = ($mk['tahun']%2);
			$mk_next['bulan'] = abs($mk['bulan']-12);
		}else{
			$gol = "GANJIL";
			$mk_next['tahun'] = abs(($mk['tahun']%2));
			$mk_next['bulan'] = abs($mk['bulan']-12);
		}
		
		
		/*******/	
		
		$this->pdf->Cell($w1+5, $h+5, '', 0, 0, 'L');
		$this->pdf->Cell($h, $h+5, '8.', 1, 0, 'C');
		$this->pdf->Multicell($w, $h+5, $s.'Masa kerja golongan untuk kenaikan gaji berikutnya', 0, 'L',0, 0);		
		
		$this->pdf->Cell(0, $h+5, $mk_next['tahun'].' Tahun '.($mk_next['bulan']).' Bulan', 1, 1, 'L');
		
		$this->pdf->Cell($w1+5, $h, '', 0, 0, 'L');
		
		
		$jabatan = $pegawai->id_j ? $s.$this->jabatan->get_jabatan($pegawai->id_j)->jabatan : $pegawai->jabatan;
		if(strlen($jabatan) > 40 && strlen($jabatan) <80){
			$h_jab = $h+5;
		}elseif(strlen($jabatan) > 80){
			$h_jab = $h+10;
		}else{
			$h_jab = $h;
		}
		
		$this->pdf->Cell($h, $h_jab, '9.', 1, 0, 'C');
		$this->pdf->Cell($w, $h_jab, $s.'Jabatan', 1, 0, 'L');
		$this->pdf->Multicell(0, $h_jab, $jabatan , 1, 'L',0, 1);	
		//$this->pdf->Cell(0, $h_jab, $s.$pegawai->jabatan, 1, 1, 'L');
		
		if(strlen($pegawai->nama_baru) > 43){
			$h_uk = $h+5;
		}else{
			$h_uk = $h;
		}
		
		$this->pdf->Cell($w1+5, $h_uk, '', 0, 0, 'L');
		$this->pdf->Cell($h, $h_uk, '10.', 1, 0, 'C');
		$this->pdf->Cell($w, $h_uk, $s.'Unit Kerja', 1, 0, 'L');
		$this->pdf->Multicell(0, $h_uk, $s.$pegawai->nama_baru, 1, 'L',0, 1);
		//$this->pdf->Cell(0, $h_uk, $s.$pegawai->nama_baru, 1, 1, 'L');
		
		$this->pdf->Cell($w1+5, $h, '', 0, 0, 'L');
		$this->pdf->Cell($h, $h, '11.', 1, 0, 'C');
		$this->pdf->Cell($w, $h, $s.'Kenaikan gaji berkala yang akan datang', 1, 0, 'L');
		$this->pdf->Cell(0, $h, $s.$this->format->date_dmY($this->format->add_date($this->input->get('tmt'),$mk_next['tahun'],$mk_next['bulan'],0)), 1, 1, 'L');
		$this->pdf->ln(2);
		$this->pdf->Cell($w1, $h, 'KEDUA', 0, 0, 'L');
		$this->pdf->Cell(5, 5, ':', 0, 0, 'L');
		$kedua = 'Apabila dikemudian hari terdapat kekeliruan dalam keputusan ini akan diadakan perbaikan perhitungan kembali sebagaimana mestinya.';
		$this->pdf->Multicell(0, $h, $kedua, 0, 'L',0, 1);
		
		$this->pdf->ln(2);
		$this->pdf->Cell($w1, $h, 'KETIGA', 0, 0, 'L');
		$this->pdf->Cell(5, 5, ':', 0, 0, 'L');
		$kedua = 'Asli Surat Keputusan ini diberikan kepada Pegawai Negeri Sipil yang bersangkutan untuk diketahui dan dipergunakan sebagaimana mestinya.';
		$this->pdf->Multicell(0, $h, $kedua, 0, 'L',0, 1);
		
		$this->pdf->ln(5);
		
		$this->pdf->Cell(100, $h, '', 0, 0, 'L');
		$this->pdf->Cell(0, $h, 'Ditetapkan di Bogor', 0, 1, 'L');
		$this->pdf->Cell(100, $h, '', 0, 0, 'L');
		$this->pdf->Cell(0, $h, 'Pada tanggal '.date('d M Y'), 0, 1, 'L');
		
		$this->pdf->Cell(100, $h+5, '', 0, 0, 'L');
		$this->pdf->Multicell(0, $h+5, 'An KEPALA BADAN KEPEGAWAIAN, PENDIDIKAN, DAN PELATIHAN KOTA BOGOR', 0, 'C',0, 1);
		$this->pdf->Cell(0, $h+5, '', 0, 1, 'L'); /*space tanda tangan*/
		$this->pdf->Cell(100, $h, 'Tembusan :', 0, 0, 'L');
		$this->pdf->Cell(100, $h, '', 0, 1, 'L');
		$this->pdf->Cell(100, $h, '1. Kepala Badan Kepegawaian Negara', 0, 0, 'L');
		$this->pdf->SetFont('times', 'BU', 11);
		
		//penandatangan
		
		//$pejabat = $this->pegawai_model->get_by_jabatan('10954');
		
		$this->pdf->Cell(100, 5, $this->pegawai->get_by_jabatan('1095')->nama, 0, 1, 'C');
		$this->pdf->SetFont('times', '', 11);
		$this->pdf->Cell(100, 5, '    u.p. Deputi Tata Usaha Kepegawaian di Jakarta', 0, 0, 'L');
		$this->pdf->Cell(100, 5, 'Penata', 0, 1, 'C');
		$this->pdf->Cell(100, 5, '2. Kepala Kantor Regional III BKN Jawa Barat di Bandung', 0, 0, 'L');		
		$this->pdf->Cell(100, 5, 'NIP. '.$this->pegawai->get_by_jabatan('1095')->nip_baru, 0, 1, 'C');
		$this->pdf->Cell(100, 5, '3. Kepala Badan Pengelolaan Keuangan dan Aset Daerah Kota Bogor', 0, 0, 'L');		
		//Close and output PDF document
		
		}
		
        $this->pdf->Output();
	}
}