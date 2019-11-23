<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class excel_ipp_asn extends CI_Controller{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('phptoexcel');
    }

    public function index($idopd){
        $this->export_data_excel($idopd);
    }

    public function export_data_excel($idopd){
        // Create new PHPExcel object
        $objPHPExcel = new PHPExcel();

        // Set document properties
        $objPHPExcel->getProperties()->setCreator("SIMPEG Kota Bogor")
            ->setLastModifiedBy("SIMPEG Kota Bogor")
            ->setTitle("Laporan Indeks Profesional Pegawai")
            ->setSubject("Laporan Indeks Profesional Pegawai")
            ->setDescription("Laporan Indeks Profesional Pegawai, created by SIMPEG")
            ->setKeywords("laporan Indeks Profesional Pegawai")
            ->setCategory("Laporan Indeks Profesional Pegawai");

        // Create the worksheet
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_LEGAL);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setFitToPage(true);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setFitToWidth(1);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setFitToHeight(0);

        // Load Model
        $this->load->model('ipp_asn_model');
        $nama_skpd = $this->ipp_asn_model->getNamaSKPD($idopd);
        $list_pjbt = $this->ipp_asn_model->getListPejabat($idopd);

        $styleArray = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        );
        // Rename sheet 1
        $objPHPExcel->setActiveSheetIndex(0)->setTitle('1. Kompetensi');
        $objPHPExcel->getActiveSheet()->mergeCells('A1:N1');
        $objPHPExcel->getActiveSheet()->getStyle('A1:N1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('A1:N1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A1:N1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue('A1', 'Metode Perhitungan Kompetensi');
        $objPHPExcel->getActiveSheet()->setCellValue('A2', 'Unit : '.$nama_skpd);
        $objPHPExcel->getActiveSheet()->setCellValue('A4', 'No');
        $objPHPExcel->getActiveSheet()->mergeCells('A4:A5');
        $objPHPExcel->getActiveSheet()->setCellValue('B4', 'Jabatan');
        $objPHPExcel->getActiveSheet()->mergeCells('B4:B5');
        $objPHPExcel->getActiveSheet()->setCellValue('C4', 'Fungsi');
        $objPHPExcel->getActiveSheet()->mergeCells('C4:C5');
        $objPHPExcel->getActiveSheet()->setCellValue('D4', 'Nama Pejabat');
        $objPHPExcel->getActiveSheet()->mergeCells('D4:D5');
        $objPHPExcel->getActiveSheet()->setCellValue('E4', 'NIP');
        $objPHPExcel->getActiveSheet()->mergeCells('E4:E5');
        $objPHPExcel->getActiveSheet()->setCellValue('F4', 'Pendidikan');
        $objPHPExcel->getActiveSheet()->mergeCells('F4:G4');
        $objPHPExcel->getActiveSheet()->setCellValue('G5', 'Y/N');
        $objPHPExcel->getActiveSheet()->setCellValue('H4', 'Pelatihan');
        $objPHPExcel->getActiveSheet()->mergeCells('H4:I4');
        $objPHPExcel->getActiveSheet()->setCellValue('I5', 'Y/N');
        $objPHPExcel->getActiveSheet()->setCellValue('J4', 'Pengalaman');
        $objPHPExcel->getActiveSheet()->mergeCells('J4:K4');
        $objPHPExcel->getActiveSheet()->setCellValue('K5', 'Y/N');
        $objPHPExcel->getActiveSheet()->setCellValue('L4', 'Administrasi');
        $objPHPExcel->getActiveSheet()->mergeCells('L4:M4');
        $objPHPExcel->getActiveSheet()->setCellValue('M5', 'Y/N');
        $objPHPExcel->getActiveSheet()->setCellValue('N4', '*Penilaian Objektif');
        $objPHPExcel->getActiveSheet()->setCellValue('N5', 'Gaps');
        $objPHPExcel->getActiveSheet()->getStyle('A4:N5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A4:N5')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5); // No
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15); // Jabatan
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(30); // Fungsi
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20); // Nama Pejabat
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20); // NIP
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15); // Pendidikan
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(5); //
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15); // Pelatihan
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(5); //
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(15); // Pengalaman
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(5); //
        $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(15); // Administrasi
        $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(5); //
        $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(15); // Penilaian
        $objPHPExcel->getActiveSheet()->getStyle('N4:N4'.$objPHPExcel->getActiveSheet()->getHighestRow())->getAlignment()->setWrapText(true);
        $i = 0;
		$real = 0;
        $dataArray = null;
        $dataArrayKinerja = null;
        $jmlFlgPendidikan = 0;
        $jmlFlgPelatihan = 0;
        $jmlFlgPengalaman = 0;
        $jmlFlgAdministrasi = 0;
        $jmlSkorGapAsn = 0;
        $jmlNilaiSKP = 0;
        foreach ($list_pjbt as $row){
            $dataKompetensi = $this->ipp_asn_model->getKompetensiKinerja($idopd,$row->id_j,$row->id_pegawai);
            $dataArray[$i] = array($i+1, $dataKompetensi['jabatan'], $dataKompetensi['tugas'], $dataKompetensi['nama'],
                $dataKompetensi['nip_baru'],$dataKompetensi['pendidikan'],$dataKompetensi['flag_pendidikan'],$dataKompetensi['pelatihan'],
                $dataKompetensi['flag_pelatihan'],$dataKompetensi['pengalaman'],$dataKompetensi['flag_pengalaman'],$dataKompetensi['administrasi'],
                $dataKompetensi['flag_administrasi'],$dataKompetensi['skor_gap_asn']);
            $dataArrayKinerja[$i] = array('','','','','','','',
                $i+1,$dataKompetensi['jabatan'],$dataKompetensi['nama'],$dataKompetensi['nilai_skp']);
            $i++;
            if($dataKompetensi['flag_pendidikan']=='Y'){
                $jmlFlgPendidikan++;
            }
            if($dataKompetensi['flag_pelatihan']=='Y'){
                $jmlFlgPelatihan++;
            }
            if($dataKompetensi['flag_pengalaman']=='Y'){
                $jmlFlgPengalaman++;
            }
            if($dataKompetensi['flag_administrasi']=='Y'){
                $jmlFlgAdministrasi++;
            }
            if($dataKompetensi['skor_gap_asn'] > 0){
                $jmlSkorGapAsn += $dataKompetensi['skor_gap_asn'];
            }
            $jmlNilaiSKP += $dataKompetensi['nilai_skp'];
			
			if($dataKompetensi['nilai_skp']!=NULL and $dataKompetensi['nilai_skp']>0)
			$real++;
			
        }
		$jml_pejabat=$i;
        $rataRataSKP = ($jmlNilaiSKP/$real);
        $objPHPExcel->getActiveSheet()->getStyle('A6:A'.(5+$i))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('B6:F'.(5+$i))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $objPHPExcel->getActiveSheet()->getStyle('G6:G'.(5+$i))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('I6:I'.(5+$i))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('K6:K'.(5+$i))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('M6:M'.(5+$i))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('N6:N'.(5+$i))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A6:N'.(5+$i))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
        $objPHPExcel->getActiveSheet()->getStyle('A6:N'.(5+$i).$objPHPExcel->getActiveSheet()->getHighestRow())->getAlignment()->setWrapText(true);

        $objPHPExcel->getActiveSheet()->setCellValue('L'.(5+$i+1), 'Jumlah');
        $objPHPExcel->getActiveSheet()->mergeCells('L'.(5+$i+1).':M'.(5+$i+1));
        $objPHPExcel->getActiveSheet()->setCellValue('L'.(5+$i+2), 'Gaps');
        $objPHPExcel->getActiveSheet()->mergeCells('L'.(5+$i+2).':M'.(5+$i+2));
        $objPHPExcel->getActiveSheet()->setCellValue('N'.(5+$i+1), round($jmlSkorGapAsn,2));
        $objPHPExcel->getActiveSheet()->setCellValue('N'.(5+$i+2), round(($jmlSkorGapAsn/$i),2));

        $objPHPExcel->getActiveSheet()->setCellValue('F'.(5+$i+3), 'Y');
        $objPHPExcel->getActiveSheet()->setCellValue('F'.(5+$i+4), 'N');
        $objPHPExcel->getActiveSheet()->setCellValue('G'.(5+$i+3), $jmlFlgPendidikan);
        $objPHPExcel->getActiveSheet()->setCellValue('G'.(5+$i+4), ($i-$jmlFlgPendidikan));

        $objPHPExcel->getActiveSheet()->setCellValue('H'.(5+$i+3), 'Y');
        $objPHPExcel->getActiveSheet()->setCellValue('H'.(5+$i+4), 'N');
        $objPHPExcel->getActiveSheet()->setCellValue('I'.(5+$i+3), $jmlFlgPelatihan);
        $objPHPExcel->getActiveSheet()->setCellValue('I'.(5+$i+4), ($i-$jmlFlgPelatihan));

        $objPHPExcel->getActiveSheet()->setCellValue('J'.(5+$i+3), 'Y');
        $objPHPExcel->getActiveSheet()->setCellValue('J'.(5+$i+4), 'N');
        $objPHPExcel->getActiveSheet()->setCellValue('K'.(5+$i+3), $jmlFlgPengalaman);
        $objPHPExcel->getActiveSheet()->setCellValue('K'.(5+$i+4), ($i-$jmlFlgPengalaman));

        $objPHPExcel->getActiveSheet()->setCellValue('L'.(5+$i+3), 'Y');
        $objPHPExcel->getActiveSheet()->setCellValue('L'.(5+$i+4), 'N');
        $objPHPExcel->getActiveSheet()->setCellValue('M'.(5+$i+3), $jmlFlgAdministrasi);
        $objPHPExcel->getActiveSheet()->setCellValue('M'.(5+$i+4), ($i-$jmlFlgAdministrasi));

        $objPHPExcel->getActiveSheet()->getStyle('A4:N'.(5+$i+4))->applyFromArray($styleArray);
        $objPHPExcel->getActiveSheet()->freezePane('A6');
        $objPHPExcel->getActiveSheet()->getSheetView()->setZoomScale(85);

        // Add some data
        $objPHPExcel->getActiveSheet()->fromArray($dataArray, NULL, 'A6');
        $dataArray = null;
        //----------------------------------------------

        // Add new sheet 2
        $objWorkSheet = $objPHPExcel->createSheet(1); //Setting index when creating
        // Rename sheet
        $objWorkSheet->setTitle('2. Kompensasi');
        $objWorkSheet->mergeCells('A1:G1');
        $objWorkSheet->getStyle('A1:G1')->getFont()->setBold(true);
        $objWorkSheet->getStyle('A1:G1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objWorkSheet->getStyle('A1:G1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objWorkSheet->setCellValue('A1', 'Metode Perhitungan Kompensasi');
        $objWorkSheet->setCellValue('A2', 'Unit : '.$nama_skpd);
        $objWorkSheet->setCellValue('A4', 'No');
        $objWorkSheet->setCellValue('B4', 'Eselon');
        $objWorkSheet->setCellValue('C4', 'Jumlah Pejabat');
        $objWorkSheet->setCellValue('D4', 'Tertinggi');
        $objWorkSheet->setCellValue('E4', 'Terrendah');
        $objWorkSheet->setCellValue('F4', 'Selisih');
        $objWorkSheet->setCellValue('G4', 'Selisih terhadap Terrendah');
        $objWorkSheet->getStyle('A4:G4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objWorkSheet->getStyle('A4:G4')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objWorkSheet->getColumnDimension('A')->setWidth(5); // No
        $objWorkSheet->getColumnDimension('B')->setWidth(10); // Eselon
        $objWorkSheet->getColumnDimension('C')->setWidth(15); // Jumlah Pejabat
        $objWorkSheet->getColumnDimension('D')->setWidth(20); // Tertinggi
        $objWorkSheet->getColumnDimension('E')->setWidth(20); // Terrendah
        $objWorkSheet->getColumnDimension('F')->setWidth(20); // Selisih
        $objWorkSheet->getColumnDimension('G')->setWidth(20); // Selisih terhadap Terrendah
        $objWorkSheet->getStyle('A4:G4'.$objPHPExcel->getActiveSheet()->getHighestRow())->getAlignment()->setWrapText(true);
        $i = 0;
        $data = null;
        $jmlPersenSelisih = 0;
        $list_kompensasi = $this->ipp_asn_model->getKompensasi($idopd);
        foreach ($list_kompensasi as $row){
            $data[$i] = $row;
            $dataArray[$i] = array($i+1, $data[$i]->eselon, $data[$i]->jml_pegawai, $data[$i]->tertinggi,
                $data[$i]->terendah, $data[$i]->selisih, $data[$i]->persentase);
            $jmlPersenSelisih += $data[$i]->persentase;
            $i++;
        }
		
        $objWorkSheet->getStyle('A5:A'.($i+4))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objWorkSheet->getStyle('B5:B'.($i+4))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objWorkSheet->getStyle('C5:C'.($i+4))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objWorkSheet->getStyle('D5:F'.($i+4))->getNumberFormat()->setFormatCode('#,##0.00');
        $objWorkSheet->setCellValue('B'.($i+4+1), 'Jumlah');
        $objWorkSheet->setCellValue('G'.($i+4+1), $jmlPersenSelisih);
        $objWorkSheet->getStyle('A4:G'.($i+4+1))->applyFromArray($styleArray);

        // Add some data
        $objWorkSheet->fromArray($dataArray, NULL, 'A5');
        $dataArray = null;
        //----------------------------------------------

        // Add new sheet 3
        $objWorkSheet = $objPHPExcel->createSheet(2); //Setting index when creating
        // Rename sheet
        $objWorkSheet->setTitle('3. Kinerja');
        $objWorkSheet->mergeCells('A1:K1');
        $objWorkSheet->getStyle('A1:K1')->getFont()->setBold(true);
        $objWorkSheet->getStyle('A1:K1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objWorkSheet->getStyle('A1:K1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objWorkSheet->setCellValue('A1', 'Metode Perhitungan Kinerja');
        $objWorkSheet->setCellValue('A2', 'Unit : '.$nama_skpd);
        $objWorkSheet->mergeCells('A4:C4');
        $objWorkSheet->setCellValue('A4', 'Rata-rata Kinerja (SKP)');
        $objWorkSheet->mergeCells('D4:F4');
        $objWorkSheet->getStyle('A4:D4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objWorkSheet->getStyle('A4:D4')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objWorkSheet->getStyle('A4:F4')->applyFromArray($styleArray);

        $objWorkSheet->setCellValue('H4', 'No');
        $objWorkSheet->setCellValue('I4', 'Jabatan');
        $objWorkSheet->setCellValue('J4', 'Nama');
        $objWorkSheet->setCellValue('K4', 'Nilai SKP');
        $objWorkSheet->getStyle('H4:K4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objWorkSheet->getStyle('H4:K4')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objWorkSheet->getColumnDimension('H')->setWidth(5); // No
        $objWorkSheet->getColumnDimension('I')->setWidth(50); // Jabatan
        $objWorkSheet->getColumnDimension('J')->setWidth(30); // Nama
        $objWorkSheet->getColumnDimension('K')->setWidth(15); // Nilai SKP
        $objWorkSheet->getRowDimension('4')->setRowHeight(25);
        $objWorkSheet->getStyle('H5:H'.(count($dataArrayKinerja)+4))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objWorkSheet->getStyle('H5:K'.(count($dataArrayKinerja)+4))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
        $objWorkSheet->getStyle('I5:J'.(count($dataArrayKinerja)+4).$objPHPExcel->getActiveSheet()->getHighestRow())->getAlignment()->setWrapText(true);
        $objWorkSheet->freezePane('A5');
        $objWorkSheet->setCellValue('I'.(count($dataArrayKinerja)+4+1), 'Jumlah');
        $objWorkSheet->setCellValue('I'.(count($dataArrayKinerja)+4+2), 'Rata-rata');
        $objWorkSheet->setCellValue('K'.(count($dataArrayKinerja)+4+1), round($jmlNilaiSKP,2));
        $objWorkSheet->setCellValue('K'.(count($dataArrayKinerja)+4+2), round($rataRataSKP,2));
        $objWorkSheet->getStyle('H4:K'.(count($dataArrayKinerja)+4+2))->applyFromArray($styleArray);
        $objWorkSheet->setCellValue('D4', round($rataRataSKP,2));

        // Add some data
        $objWorkSheet->fromArray($dataArrayKinerja, NULL, 'A5');
        $dataArrayKinerja = null;

        //----------------------------------------------

        // Add new sheet 4
        $objWorkSheet = $objPHPExcel->createSheet(3); //Setting index when creating
        // Rename sheet
        $objWorkSheet->setTitle('4. Disiplin');
        $objWorkSheet->setCellValue('A1', 'Metode Perhitungan Disiplin');
        $objWorkSheet->setCellValue('A2', 'Unit : '.$nama_skpd);
		 $objWorkSheet->setCellValue('A4', 'No');
        $objWorkSheet->setCellValue('B4', 'Jenis Pelanggaran');
        $objWorkSheet->setCellValue('C4', 'Jumlah');
		$objWorkSheet->setCellValue('D4', 'Total');
        $objWorkSheet->getStyle('A4:D4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objWorkSheet->getStyle('A4:D4')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objWorkSheet->getColumnDimension('A')->setWidth(5); // No
        $objWorkSheet->getColumnDimension('B')->setWidth(40); // Jenis Pelanggaran
        $objWorkSheet->getColumnDimension('C')->setWidth(15); // Jumlah
        $objWorkSheet->getColumnDimension('D')->setWidth(20); // Total
        $objWorkSheet->getStyle('A4:D5'.$objPHPExcel->getActiveSheet()->getHighestRow())->getAlignment()->setWrapText(true);
		 $objWorkSheet->setCellValue('A5', '1');
		 $objWorkSheet->setCellValue('A6', '2');
		 $objWorkSheet->setCellValue('A7', '3');
		 $objWorkSheet->setCellValue('A8', '');
		 $objWorkSheet->setCellValue('A9', '');
		 
		 $objWorkSheet->setCellValue('B5', 'Ringan');
		 $objWorkSheet->setCellValue('B6', 'Sedang');
		 $objWorkSheet->setCellValue('B7', 'Berat');
		 $objWorkSheet->setCellValue('B8', 'Total Karyawan');
		 $objWorkSheet->setCellValue('B9', '');
		
		
		$hukdis = $this->ipp_asn_model->getHukuman($idopd);
		
		if ($hukdis->ringan!=NULL)
		$ringan=$hukdis->ringan;
		else
		$ringan=0;
		
		if ($hukdis->sedang!=NULL)
		$sedang=$hukdis->sedang;
		else
		$sedang=0;
		
		if ($hukdis->berat!=NULL)
		$berat=$hukdis->berat;
		else
		$berat=0;
		
		
		 $objWorkSheet->setCellValue('C5', $ringan);
		 $objWorkSheet->setCellValue('C6', $sedang);
		 $objWorkSheet->setCellValue('C7', $berat);
		 $objWorkSheet->setCellValue('C8', $jml_pejabat);
		 
		 
		 $objWorkSheet->setCellValue('D5', $ringan);
		 $objWorkSheet->setCellValue('D6', $sedang*2);
		 $objWorkSheet->setCellValue('D7', $berat*3);
		 $objWorkSheet->setCellValue('D8', $ringan+($sedang*2)+($berat*3));
		 
		 $thukdis=($ringan+($sedang*2)+($berat*3))/$jml_pejabat;
		 
		 $objWorkSheet->setCellValue('C9', 'Pelanggaran');
		  $objWorkSheet->setCellValue('C10', $thukdis);
        //----------------------------------------------

        // Add new sheet 5
        $objWorkSheet = $objPHPExcel->createSheet(4); //Setting index when creating
        // Rename sheet
        $objWorkSheet->setTitle('Cetak IPP');
        $objWorkSheet->setCellValue('A1', ' Indeks Profesional Pegawai (IPP)');
        $objWorkSheet->setCellValue('A2', 'Unit : '.$nama_skpd);
        //----------------------------------------------

        //Redirect output to a client’s web browser (Excel2007)
        //clean the output buffer
        ob_end_clean();

        //this is the header given from PHPExcel examples. but the output seems somewhat corrupted in some cases.
        //header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        //so, we use this header instead.
        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Laporan_IPP.xlsx"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');

    }
}

?>