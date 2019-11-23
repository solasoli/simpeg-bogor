<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

Class Skum_pdf extends CI_Controller{

	function __construct(){

		parent::__construct();

		//load library
		$this->load->library('format');

		//load model
		$this->load->model('pegawai_model');
		$this->load->model('jabatan_model');
		//$this->load->model('golongan_model');
		$this->load->model('gapok_model');
		//$this->load->model('riwayat_pelatihan_model');

		$this->load->library('pdf');
		$this->pdf->SetHeaderMargin(0);
		$this->pdf->setPrintFooter(false);

	}


	function Index($id_pegawai,$tanggal=null){

		$this->skum($id_pegawai,$tanggal);
		$this->cetak();
	}



	function skum($id_pegawai,$tanggal){

       // $pegawai = $this->pegawai_model->get_by_id($this->uri->segment(4));
		$pegawai = $this->pegawai_model->get_by_id($id_pegawai);


		//foreach($pegawai->result() as $peg){
        //$this->pegawai_model->set_nip($peg->nip);
		//$obj = $this->pegawai_model->get_obj($peg->nip);
		//$this->pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
		$this->pdf->setBarcode(date('Y-m-d H:i:s'));
        $this->pdf->AddPage('P','FOLIO');

        // data header
		$this->pdf->SetFont('times', 'B', 14);
       	$this->pdf->ln(5);
        $this->pdf->Cell(0, 5, 'SURAT KETERANGAN', 0, 0, 'C');
        $this->pdf->ln();
		$this->pdf->Cell(0, 5, 'UNTUK MENDAPATKAN PEMBAYARAN TUNJANGAN KELUARGA', 0, 0, 'C');
        $this->pdf->ln(10);
		//$style = array('width' => 1, 'cap' => 'round', 'join' => 'round', 'color' => array(0, 0, 0));
		$this->pdf->line($this->pdf->getX(),$this->pdf->getY(),$this->pdf->getX()+190,$this->pdf->getY());
		//GARIS DISINI
		$this->pdf->ln(5);
		$w = 50;
		$h = 7;

		$this->pdf->SetFont('times', '', 12);
		$this->pdf->Cell(0, 10, 'Yang bertanda tangan di bawah ini   :', 0, 1, 'L');
        $this->pdf->Cell($w, $h, 'Nama ', 0, 0, 'L');
		$this->pdf->Cell(5,$h, ' : ', 0, 0, 'L');
		$this->pdf->SetFont('times', 'B', 12);
		//print_r($pegawai);exit;
		$this->pdf->Cell(0, $h, $this->pegawai_model->get_fullname($id_pegawai), 0, 1, 'L');
		$this->pdf->SetFont('times', '', 12);
		$this->pdf->Cell($w, $h, 'N I P ', 0, 0, 'L');
		$this->pdf->Cell(5, $h, ' : ', 0, 0, 'L');
		$this->pdf->Cell(0, $h, $pegawai->nip_baru, 0, 1, 'L');
		 $this->pdf->Cell($w, $h, 'Pangkat - Gol/Ruang ', 0, 0, 'L');
		$this->pdf->Cell(5, $h, ' : ', 0, 0, 'L');

		$gol_pangkat = $this->pegawai_model->get_last_pangkat($id_pegawai);
		//list($gol,$mk_tahun,$mk_bulan) = explode(',',$gol_pangkat->keterangan);

		$gol = $gol_pangkat->gol;
		$mk_tahun = $gol_pangkat->mk_tahun;
		$mk_bulan = $gol_pangkat->mk_bulan;

		$this->pdf->Cell(0, $h, $this->pegawai_model->get_pangkat_by_gol($gol).' - '.$gol, 0, 1, 'L');
		$this->pdf->Cell($w, $h, 'Terhitung Mulai Tanggal ', 0, 0, 'L');
		$this->pdf->Cell(5, $h, ' : ', 0, 0, 'L');
		$this->pdf->Cell(0, $h, $this->format->tanggal_indo($gol_pangkat->tmt), 0, 1, 'L');
		$this->pdf->Cell($w, $h, 'Tempat / Tanggal Lahir', 0, 0, 'L');
		$this->pdf->Cell(5, $h, ' : ', 0, 0, 'L');
		$this->pdf->Cell(0, $h, $pegawai->tempat_lahir.' , '.$this->format->tanggal_indo($pegawai->tgl_lahir), 0, 1, 'L');
		$this->pdf->Cell($w, $h, 'Jenis Kelamin ', 0, 0, 'L');
		$this->pdf->Cell(5, $h, ' : ', 0, 0, 'L');

		$this->pdf->Cell(0, $h, $pegawai->jenis_kelamin == '1' ? 'Laki-laki' : ($pegawai->jenis_kelamin == '2' ? 'Perempuan' : 'undefined') , 0, 1, 'L');
		$this->pdf->Cell($w, $h, 'Agama', 0, 0, 'L');
		$this->pdf->Cell(5, $h, ' : ', 0, 0, 'L');
		$this->pdf->Cell(0, $h, $pegawai->agama, 0, 1, 'L');
		$this->pdf->Cell($w, $h, 'Status Kepegawaian', 0, 0, 'L');
		$this->pdf->Cell(5, $h, ' : ', 0, 0, 'L');
		$this->pdf->Cell(0, $h, ''.$pegawai->status_pegawai, 0, 1, 'L');
      	$this->pdf->Cell($w, $h, 'Jenis Kepegawaian', 0, 0, 'L');
		$this->pdf->Cell(5, $h, ' : ', 0, 0, 'L');
		$this->pdf->Cell(0, $h, ''.$pegawai->jenis_pegawai, 0, 1, 'L');
		$this->pdf->Cell($w, $h, 'Jabatan', 0, 0, 'L');
		$this->pdf->Cell(5, $h, ' : ', 0, 0, 'L');

		$jab = $this->jabatan_model->get_jabatan_pegawai($id_pegawai);

		if(!$jab){
			echo "Jabatan tidak ditemukan"; die;
		}

		if (strpos($jab,'pada') !== false) {
			list($_jab, $uk) = explode("pada",$jab);
		}else{
			$_jab = $jab;
		}

		if(strlen($_jab) > 50){
			$this->pdf->SetFont('times', '', 10);
		}

		$this->pdf->Cell(0, $h, $_jab, 0, 1, 'L');
		$this->pdf->SetFont('times', '', 12);
		$this->pdf->Cell($w, $h, 'Unit Kerja', 0, 0, 'L');
		$this->pdf->Cell(5, $h, ' : ', 0, 0, 'L');
		$this->pdf->Cell(0, $h, $pegawai->nama_baru, 0, 1, 'L');
		$this->pdf->Cell($w, $h, 'Gaji Pokok / PP', 0, 0, 'L');
		$this->pdf->Cell(5, $h, ' : ', 0, 0, 'L');

		//kalo cpns gak ada hitung masa kerja dari tmt pns ajah
		if($this->pegawai_model->get_cpns($id_pegawai)){
			$baris = $this->pegawai_model->get_cpns($id_pegawai);

		}elseif($this->pegawai_model->get_pns($id_pegawai)){
			$baris = $this->pegawai_model->get_pns($id_pegawai);
		}else{
			echo "<div class='error'>DATA CPNS/PNS TIDAK DITEMUKAN ..<div>";
			exit;
		}


		//print_r($baris);exit;

			//list($gol_cpns,$thn,$bln) = explode(',', $baris->keterangan);

			$gol_cpns = $baris->gol;
			$thn = $baris->mk_tahun;
			$bln = $baris->mk_bulan;


		$mk = $this->pegawai_model->hitung_masakerja($baris->tmt,$thn,$bln);
		$mk_gol = $this->pegawai_model->hitung_masakerja_golongan($mk,$gol_cpns,$gol);

		if($mk_gol < 0){

			// belom kepikiran;
		}

		$query_pmk = "select * from sk where id_kategori_sk = 25 and id_pegawai = ".$id_pegawai;

		if($pmk = $this->db->query($query_pmk)->row()){
			$mk_gol['tahun'] += $pmk->mk_tahun;
			$mk_gol['bulan'] += $pmk->mk_bulan;

			$mk['tahun'] += $pmk->mk_tahun;
			$mk['bulan'] += $pmk->mk_bulan;

			if($sel_mk_gol = $mk_gol['bulan'] % 12  > 0){
				$mk_gol['bulan'] -= 12;
				$mk_gol['tahun'] += $sel_mk_gol;

				$mk['bulan'] -= 12;
				$mk['tahun'] += $sel_mk_gol;
			}


		}
		//echo $mk_gol['tahun'];exit;

        $sqlMaxMasaKerja = "SELECT pangkat_gol, MAX(masa_kerja) as max_masa_kerja
            FROM gaji_pokok WHERE tahun = 2019
            GROUP BY pangkat_gol";
        $query = $this->db->query($sqlMaxMasaKerja);
        $rsMaxMk = $query->result();

        $mk_gol_tahun = $mk_gol['tahun'];
        foreach($rsMaxMk as $datamk){
            if($datamk->pangkat_gol==$gol){
                if(abs($mk_gol['tahun']) >= $datamk->max_masa_kerja){
                    $mk_gol_tahun = $datamk->max_masa_kerja;
                }
                break;
            }
        }


		$gapok = $this->gapok_model->get_last_gapok($gol, abs($mk_gol_tahun))->row();

		if($pegawai->status_pegawai == 'CPNS'){
			$gapok_cpns = (int) $gapok->gaji * 0.8;
		}


		if($pegawai->status_pegawai == 'CPNS'){

			$this->pdf->Cell(0,$h,"Rp".$this->format->currency($gapok->gaji)." x 80% = ".$this->format->currency($gapok_cpns)." / ".$gapok->peraturan." Tahun ".$gapok->tahun, 0, 1, 'L');
		}else{
			//$this->pdf->Cell(0, $h, "Rp".$this->format->currency($gapok->gaji)." / ".$gapok->peraturan." Tahun ".$gapok->tahun, 0, 1, 'L');
			$this->pdf->Cell(0, $h, "Rp".$this->format->currency($gapok->gaji)." / ".$gapok->peraturan." Tahun ".$gapok->tahun, 0, 1, 'L');

		}


		$this->pdf->Cell($w, $h, 'Masa Kerja Golongan', 0, 0, 'L');
		$this->pdf->Cell(5, $h, ' : ', 0, 0, 'L');

		$this->pdf->Cell(0, $h, abs($mk_gol['tahun']).' Tahun '.$mk_gol['bulan']. ' Bulan', 0, 1, 'L');
		$this->pdf->Cell($w, $h, 'Masa Kerja Keseluruhan ', 0, 0, 'L');
		$this->pdf->Cell(5, $h, ' : ', 0, 0, 'L');
		$this->pdf->Cell(0, $h, $mk['tahun'].' Tahun '.$mk['bulan'].' Bulan', 0, 1, 'L');
		$this->pdf->Cell($w, $h, 'Alamat Lengkap', 0, 0, 'L');
		$this->pdf->Cell(5, $h, ' : ', 0, 0, 'L');
		$this->pdf->Multicell(0, $h, $pegawai->alamat, 0, 'L',0, 0);

		$this->pdf->ln(10);
		$this->pdf->SetFont('times', 'B', 14);
		$this->pdf->Cell(0, $h, 'TANGGUNGAN KELUARGA', 0, 1, 'C');
		$this->pdf->SetFont('times', '', 11);

		/** daftar keluarga */
		$this->load->model('keluarga_model');


		$this->pdf->Cell(10, 10, 'NO', 1, 0, 'C');
		$this->pdf->Multicell(70, 10, "Nama\n Anak/Isteri/Suami", 1,'C',0,0);
		$this->pdf->Multicell(20, 10, "Tanggal \n Lahir", 1,'C',0,0);
		$this->pdf->Multicell(20, 10, "Tanggal \n Menikah", 1,'C',0,0);
		$this->pdf->Multicell(25, 10, "Pekerjaan/ \n Sekolah", 1,'C',0,0);
		$this->pdf->Multicell(25, 10, "Dapat/ \n Tidak Dapat", 1,'C',0,0);
		$this->pdf->Multicell(25, 10, "Keterangan", 1,'C',0,1);

		$xt1 = $this->pdf->getX();
		$yt1 = $this->pdf->getY();

		$is_have_istri = FALSE;
		$is_have_anak 	= FALSE;

		$this->keluarga_model->id_pegawai = $id_pegawai;

		//echo $this->keluarga_model->id_pegawai; exit;

		if($istri = $this->keluarga_model->get_istri_suami()){
			$pegawai->jenis_kelamin == '1' ? $istri_or_suami = 'Istri : ' : $istri_or_suami = 'Suami :' ;
			//cek ada tanggal menikahnya gak?
			//if()

			//print_r($istri); exit;
			$is_have_istri = TRUE;
			//Baris keterangan istri atao suami
			$this->pdf->Cell(10, $h, ' ', 0, 0, 'C');
			$this->pdf->Cell(70, $h, ' '.$istri_or_suami, 0, 0, 'L');
			$this->pdf->Cell(20, $h, ' ', 0, 0, 'L');
			$this->pdf->Cell(20, $h, ' ', 0, 0, 'L');
			$this->pdf->Cell(25, $h, ' ', 0, 0, 'L');
			$this->pdf->Cell(25, $h, ' ', 0, 0, 'L');
			$this->pdf->Cell(25, $h, ' ', 0, 1, 'L');

			//baris Istri or Suami
			$this->pdf->Cell(10, $h, ' 1', 0, 0, 'C');
			$this->pdf->MultiCell(70, $h, ' '.$istri[0]->nama, 0, 'L',0, 0);

			if(! isset($istri[0]->tgl_lahir)){

				echo "Mohon lengkapi tanggal lahir Istri/Suami <br>";
			}

			if(! isset($istri[0]->tgl_menikah)){

				echo "Mohon lengkapi tanggal menikah ";
				exit;
			}



			$this->pdf->Cell(20, $h, ' '.$this->format->date_dmY($istri[0]->tgl_lahir), 0, 0, 'C');
			//$this->pdf->Cell(25, $h, ' '.(isset($istri->tgl_menikah) && $istri->tgl_menikah != '') ? $this->format->date_dmY($istri->tgl_menikah) : '-', 0, 0, 'C');
			$this->pdf->Cell(20, $h, ' '.$this->format->date_dmY($istri[0]->tgl_menikah), 0, 0, 'C');
			$this->pdf->MultiCell(25, $h, ' '.$istri[0]->pekerjaan, 0, 'C', 0, 0);
			$this->pdf->Cell(25, $h, ' '.$istri[0]->dapat_tunjangan == 1 ? ' Dapat' : ' Tidak Dapat', 0, 0, 'C');
			$this->pdf->MultiCell(25, $h, ' '.($istri[0]->keterangan ? $istri[0]->keterangan : ' ') , 0, 'C',0,1);
		}
		// -----------


		//cek punya anak gak? kalo punya tampilin dong.
		$anak = FALSE;
		if($anak = $this->keluarga_model->get_anak($id_pegawai)){
			$is_have_anak = TRUE;
			//Baris keterangan anak
			$this->pdf->Cell(10, $h, ' ', 0, 0, 'C');
			//$this->pdf->MultiCell(10, $h, ' ', 1, 'L', 0, 0);
			$this->pdf->Cell(70, $h, ' Anak :', 0, 0, 'L');
			$this->pdf->Cell(20, $h, ' ', 0, 0, 'L');
			$this->pdf->Cell(20, $h, ' ', 0, 0, 'L');
			$this->pdf->Cell(25, $h, ' ', 0, 0, 'L');
			$this->pdf->Cell(25, $h, ' ', 0, 0, 'L');
			$this->pdf->Cell(25, $h, ' ', 0, 1, 'L');

			if($is_have_istri){
				$y = 2;
			}else{
				$y = 1;
			}


			foreach($this->keluarga_model->get_anak($id_pegawai) as $keluargaku){

				if(! isset($keluargaku->tgl_lahir)){
					echo "Mohon lengkapi tanggal lahir anak";
					exit;
				}

				$this->pdf->Cell(10, $h, ' '.$y++, 0, 0, 'C');
				$this->pdf->MultiCell(70, $h, ' '.$keluargaku->nama, 0, 'L', 0, 0);
				$this->pdf->Cell(20, $h, ' '.$this->format->date_dmY($keluargaku->tgl_lahir), 0, 0, 'C');
				$this->pdf->Cell(20, $h, ' -', 0, 0, 'C');
				$this->pdf->Cell(25, $h, ' '.$keluargaku->pekerjaan, 0, 0, 'C');
				$this->pdf->Cell(25, $h, ' '.$keluargaku->dapat_tunjangan == 1 ? ' Dapat' : ' Tidak Dapat', 0, 0, 'C');
				$this->pdf->Cell(25, $h, ' '.$keluargaku->keterangan.' ', 0, 1, 'C');
			}

		}

		if(!$istri && !$anak){

			$this->pdf->Cell(10, $h, ' - ', 1, 0, 'C');
			$this->pdf->Cell(70, $h, ' - ', 1, 0, 'C');
			$this->pdf->Cell(20, $h, ' - ', 1, 0, 'C');
			$this->pdf->Cell(20, $h, ' - ', 1, 0, 'C');
			$this->pdf->Cell(25, $h, ' - ', 1, 0, 'C');
			$this->pdf->Cell(25, $h, ' - ', 1, 0, 'C');
			$this->pdf->Cell(25, $h, ' - ', 1, 1, 'C');
		}

		/*
		}else{

		}*/


			$xt2 = $this->pdf->getX();
			$yt2 = $this->pdf->getY();
			$yy = $yt2-$yt1;

			$this->pdf->Rect($xt1, $yt1, 10, $yy, 'D');
			$this->pdf->Rect($xt1+10, $yt1, 70, $yy, 'D');
			$this->pdf->Rect($xt1+80, $yt1, 20, $yy, 'D');
			$this->pdf->Rect($xt1+100, $yt1, 20, $yy, 'D');
			$this->pdf->Rect($xt1+120, $yt1, 25, $yy, 'D');
			$this->pdf->Rect($xt1+145, $yt1, 25, $yy, 'D');
			$this->pdf->Rect($xt1+170, $yt1, 25, $yy, 'D');


		//$this->pdf->ln();
		$note = 'Keterangan ini saya buat dengan sesungguhnya dan apabila keterangan ini tidak benar, saya bersedia dituntut dimuka pengadilan berdasarkan Undang-Undang yang berlaku, dan bersedia mengembalikan semua tunjangan yang telah saya terima yang seharusnya bukan menjadi hak saya';
		$this->pdf->Multicell(0, 0, $note."\n", 0,'J',0,1);


		$this->load->model('unit_kerja_model','uk');
		//echo $pegawai->id_pegawai;
		//echo "test ".$pegawai->id_unit_kerja;

		if($pegawai->id_skpd == 5266 ){ //sekretariat daerah
			$id_unit = $pegawai->id_unit_kerja;
			//echo $id_unit;
		}else{
			$id_unit = $pegawai->id_skpd;
		}

		//echo $id_unit;exit;
		$penandatangan = $this->uk->get_penandatangan($id_unit);
		//print_r($penandatangan);exit;

		if(!isset($penandatangan)){
			echo "PEJABAT PENANDATANGAN TIDAK DITEMUKAN";
			exit;
		}


		//

		if($penandatangan->id_pegawai == $id_pegawai){

			$penandatangan = $this->uk->get_sekda();
		}

		//echo "test ".$penandatangan->id_pegawai;

		//print_r($penandatangan);
		if($ptg = $this->pegawai_model->get_last_pangkat($penandatangan->id_pegawai)){
			//print_r($this->pegawai_model->get_last_pangkat($penandatangan->id_pegawao));
			//list($gol_penandatangan,$mk_tahun_p,$mk_bulan_p) = explode(',',$this->pegawai_model->get_last_pangkat($penandatangan->id_pegawai)->keterangan);
			$gol_penandatangan = $ptg->gol;

		}else{
			$gol_penandatangan = "";
		}

		$this->pdf->Cell(90, $h, 'Mengetahui,', 0, 0, 'C');


        if($tanggal!=''){
            $tanggal = explode("-",$tanggal);
            $tgla = '';
            $blna = $tanggal[1];
            $thna = $tanggal[2];
			switch ($blna){
				case '01':
					$blna = 'Januari';
					break;
				case '02':
					$blna = 'Februari';
					break;
				case '03':
					$blna = 'Maret';
					break;
				case '04':
					$blna = 'April';
					break;
				case '05':
					$blna = 'Mei';
					break;
				case '06':
					$blna = 'Juni';
					break;
				case '07':
					$blna = 'Juli';
					break;
				case '08':
					$blna = 'Agustus';
					break;
				case '09':
					$blna = 'September';
					break;
				case '10':
					$blna = 'Oktober';
					break;
				case '11':
					$blna = 'November';
					break;
				case '12':
					$blna = 'Desember';
					break;
			}
			$this->pdf->Cell(0, $h, 'Bogor,      '.$tgla.' '.$blna.' '.$thna, 0, 1, 'C');
		}else{
			//$this->pdf->Cell(0, $h, 'Bogor,       Agustus 2017', 0, 1, 'C');
			$this->pdf->Cell(0, $h, 'Bogor,      '.$this->format->tanggal_indo(date('Y-m-d'), "MY"), 0, 1, 'C');
		}
		$this->pdf->MultiCell(90, 5, $penandatangan->jabatan, 0,'C',0,0);
		$this->pdf->Cell(0, 5, 'Yang Menerangkan', 0, 1, 'C');
		$this->pdf->Cell(90, 5, '', 0, 0, 'C');
		$this->pdf->Cell(0, 5, '', 0, 1, 'C');
		$this->pdf->Cell(90, 5, '', 0, 0, 'C');
		$this->pdf->Cell(0, 5, '', 0, 1, 'C');
		$this->pdf->ln(10);
		$this->pdf->SetFont('times', 'BU', 11);

		$this->pdf->Cell(90, 5, $this->pegawai_model->get_fullname($penandatangan->id_pegawai), 0, 0, 'C');
		$this->pdf->Cell(0, 5, $this->pegawai_model->get_fullname($id_pegawai), 0, 1, 'C');
		$this->pdf->SetFont('times', '', 11);
		$this->pdf->Cell(90, 5,$this->pegawai_model->get_pangkat_by_gol($gol_penandatangan) , 0, 0, 'C');
		$this->pdf->Cell(0, 5, 'NIP. '.$pegawai->nip_baru, 0, 1, 'C');

		//print_r($penandatangan);exit;
		if($penandatangan->flag_pensiun == 0){
			$this->pdf->Cell(90, 5, 'NIP. '.$penandatangan->nip_baru, 0, 0, 'C');
		}else{
			$this->pdf->Cell(90, 5, '', 0, 0, 'C');
		}
		$this->pdf->Cell(0, 5, '', 0, 1, 'C');
		$this->pdf->ln(5);

		if(sizeof($anak) < 4) {
		$this->pdf->Cell(100, 5, 'Catatan :', 0, 1, 'L');
		$this->pdf->Multicell(100, 0, 'Pekerjaan Suami/Istri bila Pegawai Negeri Sipil/TNI disebutkan Instansinya dalam kolom keterangan', 0,'L',0,0);
		//$this->pdf->ln();
		$this->pdf->SetFont('helvetica', '', 10);
		}
		// define barcode style
		$style = array(
			'position' => '',
			'align' => 'C',
			'stretch' => true,
			'fitwidth' => true,
			'cellfitalign' => '',
			'border' => true,
			'hpadding' => 'auto',
			'vpadding' => 'auto',
			'fgcolor' => array(0,0,0),
			'bgcolor' => false, //array(255,255,255),
			'text' => true,
			'font' => 'helvetica',
			'fontsize' => 5,
			'stretchtext' => 4
		);
		$this->pdf->Cell(40, 5, '', 0, 0, 'L');
		//echo $pegawai->nip_baru;exit;
		$this->pdf->Multicell(100, 0, $this->pdf->write1DBarcode($pegawai->nip_baru, 'I25', '', '', '', 18, 0.4, $style, 'N'), 0,'R',0,1);

		//$this->pdf->write1DBarcode($pegawai->nip_baru, 'I25', '', '', '', 18, 0.4, $style, 'N');



		//
		//Close and output PDF document




	}


	public function cetak(){
		$this->pdf->Output();
	}


	public function all($id_pegawai){

		$this->load->model('unit_kerja_model','uk');
		//$this->index(11301);
		//foreach($this->uk->get_daftar_pegawai($))
		$id_uk = $this->pegawai_model->get_by_id($id_pegawai)->id_skpd;

		foreach($this->uk->get_daftar_pegawai($id_uk) as $peg){

			//echo $peg->id_pegawai."<br>";
			$this->skum($peg->id_pegawai);
			$this->cetak();
		}
	}


}
