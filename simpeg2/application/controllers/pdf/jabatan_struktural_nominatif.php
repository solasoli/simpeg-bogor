<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

Class Jabatan_struktural_nominatif extends CI_Controller{

	function __Construct(){
	
		parent::__construct();
		
		//load library
		$this->load->library('format');
		
		//load model		
		$this->load->model('pegawai_model');	
		$this->load->model('jabatan_model');
		
		$this->load->model('gapok_model');
				
		$this->load->model('draft_pelantikan_model');
		
	}	
	
	
	
	function Index($id_draft){
	
		$this->load->library('pdf');
		$this->pdf->SetHeaderMargin(0);
		$this->pdf->setPrintFooter(false);
		
		$this->pdf->AddPage('P','FOLIO');	
		
		// data header
		$this->pdf->SetFont('times', 'B', 14);
       	$this->pdf->ln(5);
        $this->pdf->Cell(0, 5, 'DRAFT DAFTAR NOMINATIF', 0, 0, 'C');        
        $this->pdf->ln();
		$this->pdf->Cell(0, 5, 'PELANTIKAN JABATAN STRUKTURAL', 0, 0, 'C');        
        $this->pdf->ln(10);
		//$style = array('width' => 1, 'cap' => 'round', 'join' => 'round', 'color' => array(0, 0, 0));
		$this->pdf->line($this->pdf->getX(),$this->pdf->getY(),$this->pdf->getX()+190,$this->pdf->getY());
		//GARIS DISINI
		$this->pdf->ln(5);
		$this->pdf->SetFont('times', '', 11);
		
		$eselons = $this->draft_pelantikan_model->get_eselon_pelantikan($id_draft);
		
		foreach($eselons as $eselon){
					
			$jabatan = $this->draft_pelantikan_model->nominatif_by_id($id_draft, $eselon->eselon);
			
			$this->pdf->Cell(10, 10, 'Eselon '.$eselon->eselon, 0, 1, 'L');
			$this->pdf->Cell(10, 10, 'NO', 1, 0, 'C');
			$this->pdf->Multicell(50, 10, "Nama", 1,'C',0,0);
			$this->pdf->Multicell(50, 10, "Jabatan Sebelumnya", 1,'C',0,0);
			$this->pdf->Multicell(15, 10, "Eselon", 1,'C',0,0);
			$this->pdf->Multicell(50, 10, "Jabatan", 1,'C',0,0);
			$this->pdf->Multicell(0, 10, "Keterangan", 1,'C',0,1);
			
			$no = 1;
			$h = 10;
			foreach($jabatan as $pejabat){
			
				if (strpos($pejabat->jabatan_awal, 'pada') !== false) {
					list($jabatan_awal,$unit_kerja) = explode('pada',$pejabat->jabatan_awal);
				}else{
					$jabatan_awal = $pejabat->jabatan_awal;
				}
							
				
				if (strpos($pejabat->jabatan, 'pada') !== false) {
					list($jabatan, $unit_kerja) = explode('pada',$pejabat->jabatan);
				}else{
					$jabatan = $pejabat->jabatan;
				}
				
				if(strlen($jabatan_awal) > 60 || strlen($jabatan) > 60 ){
					$h = 15;
				}elseif(strlen($jabatan_awal) > 70 || strlen($jabatan) > 70 ){
					$h = 20;
				}
				
				$this->pdf->Cell(10, $h, $no++, 1, 0, 'C');
				$this->pdf->Multicell(50, $h, $pejabat->nama , 1,'L',0,0);
				$this->pdf->Multicell(50, $h, $jabatan_awal, 1,'C',0,0);
				$this->pdf->Multicell(15, $h, $pejabat->eselon_awal, 1,'C',0,0);
				$this->pdf->Multicell(50, $h, $jabatan, 1,'C',0,0);
				$this->pdf->Multicell(0,  $h, $pejabat->keterangan, 1,'C',0,1);
			}
			$this->pdf->ln(5);
		}
		
		
		$this->pdf->Output();
	}
}