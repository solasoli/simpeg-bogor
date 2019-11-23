<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Inpassing_jfu extends CI_Controller{

	function __construct(){
		
		parent::__construct();
		
		$this->load->model('pegawai_model','pegawai');
		$this->load->model('jabatan_model','jabatan');
		$this->load->library('format');
	}
	
	function index(){
			
		$this->load->library('pdf');
		//$this->pdf->SetHeaderMargin(0);
		$this->pdf->SetMargins(20,47,20); //left, top, right
		$this->pdf->setPrintFooter(false);
		
		
		$per_opd = $this->pegawai->get_list_id_pegawai_by_opd_staff($this->input->get('skpd'));
		
		foreach($per_opd as $peg){
		$this->pegawai->set_id_pegawai($peg->id_pegawai);
		//$this->pegawai->set_nip('198506182010011007');
		$pegawai =& $this->pegawai->get_pegawai();
		
		// data header
		$this->pdf->SetFont('times', 'B', 13);
		$this->pdf->AddPage('P','FOLIO');	
       	//$this->pdf->ln(45);
        $this->pdf->Cell(0, 5, 'PETIKAN', 0, 0, 'C');        
        $this->pdf->ln();
		$this->pdf->Cell(0, 5, 'KEPUTUSAN WALIKOTA BOGOR', 0, 0, 'C');        
        $this->pdf->ln();
		$this->pdf->SetFont('times', '', 12);
		$this->pdf->Cell(0, 5, 'Nomor : '.$this->input->get('no'), 0, 1, 'C');        
		$this->pdf->ln(3);
		$this->pdf->SetFont('times', 'B', 12);
		$this->pdf->Cell(0, 5, 'Tentang', 0, 1, 'C');      
		$this->pdf->ln(2);
		$this->pdf->Cell(0, 5, 'PENYESUAIAN JABATAN FUNGSIONAL UMUM PEGAWAI NEGERI SIPIL', 0, 1, 'C');      
		$this->pdf->Cell(0, 5, 'DI LINGKUNGAN PEMERINTAH KOTA BOGOR', 0, 0, 'C');      
		$this->pdf->ln(10);
		$this->pdf->Cell(0, 5, 'DENGAN RAHMAT TUHAN YANG MAHA ESA', 0, 1, 'C');      
		$this->pdf->ln(5);
		$this->pdf->Cell(0, 5, 'WALIKOTA BOGOR,', 0, 1, 'C');      
		//$this->pdf->ln();
		$w = 60;
		$w1 = 30;
		$h = $h_jab = $h_uk = 6;
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
		$this->pdf->ln(5);
		$this->pdf->SetFont('times', '', 11);
		
        $this->pdf->Cell($w1, 5, 'Menetapkan ', 0, 0, 'L');
		$this->pdf->Cell(0, 5, ' : ', 0 , 1, 'L'); 	
		$this->pdf->Cell($w1, 5, 'KESATU ', 0 , 0, 'L'); 	
		$this->pdf->Cell(5, 5, ' : ', 0 , 0, 'L'); 	
		$this->pdf->Multicell(0, $h, 'Terhitung mulai tanggal '.$this->format->date_full($this->input->get('tmt'),"d M Y").' menyesuaikan Jabatan Fungsional Umum Calon Pegawai Negeri Sipil / Pegawai Negeri Sipil sebagai berikut:'."\n", 0, 'J',0, 1);
		$this->pdf->SetFont('times', '', 11);
		$this->pdf->ln(2);
		$this->pdf->Cell($w1+5, $h, '', 0, 0, 'L');		
		$this->pdf->Cell($w, $h, 'Nama', 0, 0, 'L');
		$this->pdf->Cell(0, $h, ': '.$pegawai->nama, 0, 1, 'L');
		
		$this->pdf->Cell($w1+5, $h, '', 0, 0, 'L');		
		$this->pdf->Cell($w, $h, 'NIP', 0, 0, 'L');
		$this->pdf->Cell(0, $h, ': '.$pegawai->nip_baru, 0, 1, 'L');
		
		$this->pdf->Cell($w1+5, $h, '', 0, 0, 'L');		
		$this->pdf->Cell($w, $h, 'Tempat, tanggal lahir', 0, 0, 'L');
		$this->pdf->Cell(0, $h, ': '.$pegawai->tempat_lahir.', '.$this->format->date_full($this->format->date_dmY($pegawai->tgl_lahir)), 0, 1, 'L');
		
		$this->pdf->Cell($w1+5, $h, '', 0, 0, 'L');		
		$this->pdf->Cell($w, $h, 'Pangkat, Golongan ruang', 0, 0, 'L');
		$this->pdf->Cell(0, $h, ': '.$pegawai->pangkat.', '.$pegawai->golongan, 0, 1, 'L');
		
		$jabatan = $pegawai->id_j ? $s.$this->jabatan->get_jabatan($pegawai->id_j)->jabatan : $pegawai->jabatan;
		if(strlen($jabatan) > 40 && strlen($jabatan) <80){
			$h_jab = $h;
		}elseif(strlen($jabatan) > 80){
			$h_jab = $h+10;
		}else{
			$h_jab = $h;
		}
		
		$this->pdf->Cell($w1+5, $h_jab, '', 0, 0, 'L');		
		$this->pdf->Cell($w, $h_jab, 'Jabatan lama', 0, 0, 'L');		
		$this->pdf->Cell(0, $h_jab, ': '.$jabatan, 0, 1, 'L');
		
		$this->pdf->Cell($w1+5, $h, '', 0, 0, 'L');		
		$this->pdf->Cell($w, $h, 'Jabatan baru', 0, 0, 'L');
		$this->pdf->Cell(0, $h, ': '.$this->pegawai->get_jabatan(0,$pegawai->id_pegawai) , 0, 1, 'L');
		
				
		if(strlen($pegawai->nama_baru) > 43){
			$h_uk = $h+5;
		}else{
			$h_uk = $h;
		}
		
		$this->pdf->Cell($w1+5, $h_uk, '', 0, 0, 'L');		
		$this->pdf->Cell($w, $h_uk, 'Unit Kerja', 0, 0, 'L');
		$this->pdf->Multicell(0, $h_uk, ': '.$pegawai->nama_baru, 0, 'L',0, 1);
		
				
		$this->pdf->ln(5);
		$this->pdf->Cell($w1, $h, 'KEDUA', 0, 0, 'L');
		$this->pdf->Cell(5, 5, ':', 0, 0, 'L');
		$kedua = 'Apabila dikemudian hari terdapat kekeliruan dalam keputusan ini akan diadakan perbaikan sebagaimana mestinya.';
		$this->pdf->Multicell(0, $h, $kedua."\n", 0, 'J',0, 1);
		
		$this->pdf->ln(2);
		$this->pdf->Cell($w1, $h, 'KETIGA', 0, 0, 'L');
		$this->pdf->Cell(5, 5, ':', 0, 0, 'L');
		$kedua = 'Asli Surat Keputusan ini diberikan kepada Calon Pegawai Negeri Sipil / Pegawai Negeri Sipil yang bersangkutan untuk diketahui dan dipergunakan sebagaimana mestinya.';
		$this->pdf->Multicell(0, $h, $kedua."\n", 0, 'J',0, 1);
		
		$this->pdf->ln(5);
		
		$this->pdf->Cell(120, 5, '', 0, 0, 'L');
		$this->pdf->Cell(0, 5, 'Ditetapkan di Bogor', 0, 1, 'L');
		$this->pdf->Cell(120, 5, '', 0, 0, 'L');
		$this->pdf->Cell(0, 5, 'pada tanggal : '.$this->format->date_full($this->input->get('tgl')), 0, 1, 'L');
		
		$this->pdf->Cell(100, $h-2, 'Sesuai dengan aslinya,', 0, 0, 'C');
		$this->pdf->Cell(0, $h-2, '', 0, 1, 'C');
		
		$this->load->model('sk_model');
		$pengesah = $this->sk_model->get_pengesah_sk($pegawai->pangkat_gol);
		//print_r($pengesah);
		//echo "<br>";
		$this->pdf->SetFont('times', '', 11);
		
		if(strpos(strtolower($pengesah[0]->jabatan),'pada')){
			$jabatan_pengesah = substr($pengesah[0]->jabatan, 0, strpos(strtolower($pengesah[0]->jabatan), 'pada'));
						
		}else{
			$jabatan_pengesah =  $pengesah[0]->jabatan;			
		}
		
		if(strpos(strtolower($jabatan_pengesah),'badan')){
			$jabatan_pengesah = substr($jabatan_pengesah, 0, strpos(strtolower($jabatan_pengesah), 'badan'));
						
		}else{
			$jabatan_pengesah =  $jabatan_pengesah;			
		}
		
		
		$this->pdf->Cell(100, $h, trim($jabatan_pengesah) === 'Kepala' ? strtoupper($jabatan_pengesah).',' : 'A.n. KEPALA' , 0, 0, 'C');
		$this->pdf->Cell(0, $h, 'WALIKOTA BOGOR,', 0, 1, 'C');
		
		
						
		$this->pdf->SetFont('times', '', 11);
		$this->pdf->Multicell(10, $h, '', 0, 'C',0,0);
		$this->pdf->Multicell(80, $h, trim($jabatan_pengesah) === 'Kepala' ? '': $jabatan_pengesah.',', 0, 'C', 0,1);
		$this->pdf->Multicell(10, $h, '', 0, 'C',0,0);
		$this->pdf->Multicell(90, $h, '', 0, 'C',0,0);
		$this->pdf->Multicell(0, $h, 'Ttd', 0, 'C',0,1);
		
		$this->pdf->ln(10);
		$this->pdf->SetFont('times', 'BU', 11);
		$this->pdf->Cell(100, $h, $pengesah[0]->nama, 0, 0, 'C');
		$this->pdf->SetFont('times', 'B', 11);
		$this->pdf->Cell(0, $h, 'DIANI BUDIARTO', 0, 1, 'C');
		$this->pdf->SetFont('times', '', 11);
		
				
		$this->pdf->Cell(100, 5, $this->pegawai->get_pangkat_by_gol($pengesah[0]->pangkat_gol), 0, 0, 'C');
		$this->pdf->Cell(0, 5, '', 0, 1, 'C');
		$this->pdf->Cell(100, 5, 'NIP. '.$pengesah[0]->nip_baru, 0, 0, 'C');
		$this->pdf->Cell(0, 5, '', 0, 1, 'C');
		
		
		//tembusan
		$this->pdf->Cell(0, 5, 'Tembusan :', 0, 1, 'L');
		$this->pdf->Cell(0, 5, '1. Kepala Badan Kepegawaian Negara', 0, 1, 'L');
		$this->pdf->Cell(0, 5, '    u.p. Deputi Tata Usaha Kepegawaian di Jakarta;', 0, 1, 'L');
		$this->pdf->Cell(0, 5, '2. Kepala Kantor Regional III BKN Jawa Barat di Bandung;', 0, 1, 'L');
		$this->pdf->Cell(0, 5, '3. Kepala Badan Pengelolaan Keuangan dan Aset Daerah Kota Bogor.', 0, 1, 'L');
		//Close and output PDF document		
		}
		
        $this->pdf->Output('inpassing_jfu_'.$this->input->get('skpd').'.pdf');
	}
}