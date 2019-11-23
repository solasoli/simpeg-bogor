<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class excel_rekapabsen_all_opd extends CI_Controller{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('phptoexcel');
    }

    public function index($bln, $thn){
        $this->export_data_excel($bln, $thn);
    }

    public function export_data_excel($bln, $thn){
        // Create new PHPExcel object
        $objPHPExcel = new PHPExcel();

        // Set document properties
        $objPHPExcel->getProperties()->setCreator("SIMPEG Kota Bogor")
            ->setLastModifiedBy("SIMPEG Kota Bogor")
            ->setTitle("Laporan Absensi Pegawai")
            ->setSubject("Laporan Absensi Pegawai")
            ->setDescription("Laporan Absensi Pegawai, created by SIMPEG")
            ->setKeywords("laporan absensi pegawai")
            ->setCategory("Laporan Absensi");

        // Create the worksheet
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_LEGAL);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setFitToPage(true);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setFitToWidth(1);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setFitToHeight(0);
        $this->load->model('report_absensi_model');
        $this->load->model('Terbilang_model');
        $hari = $this->Terbilang_model->getNamaHari("Y/m/d");
        $bulan = $this->Terbilang_model->getNamaBulan(date("m"));
        $objPHPExcel->getActiveSheet()->setCellValue('A1', 'PEMERINTAH KOTA BOGOR');
        $objPHPExcel->getActiveSheet()->setCellValue('A2', 'REKAPITULASI ABSENSI PEGAWAI');
        $objPHPExcel->getActiveSheet()->setCellValue('A3', $hari.', '.date("d").' '.$bulan.' '.date("Y"));

        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(8);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(8);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(8);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(8);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(8);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(8);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(8);
        $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(8);
        $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(8);
        $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(8);
        $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(8);
        $objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(8);
        $objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(8);
        $objPHPExcel->getActiveSheet()->getColumnDimension('R')->setWidth(8);
        $objPHPExcel->getActiveSheet()->getColumnDimension('S')->setWidth(8);
        $objPHPExcel->getActiveSheet()->getColumnDimension('T')->setWidth(8);
        $objPHPExcel->getActiveSheet()->getColumnDimension('U')->setWidth(8);
        $objPHPExcel->getActiveSheet()->getColumnDimension('V')->setWidth(8);
        $objPHPExcel->getActiveSheet()->getColumnDimension('W')->setWidth(8);
        $objPHPExcel->getActiveSheet()->getColumnDimension('X')->setWidth(8);
        $objPHPExcel->getActiveSheet()->getRowDimension('6')->setRowHeight(15);

        $styleArray = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        );

        $objPHPExcel->getActiveSheet()->getStyle('A5:X5')->applyFromArray($styleArray);
        $objPHPExcel->getActiveSheet()->getStyle('A6:X6')->applyFromArray($styleArray);
        $objPHPExcel->getActiveSheet()->getStyle('A7:X7')->applyFromArray($styleArray);

        $objPHPExcel->getActiveSheet()->getStyle('A5:W5'.$objPHPExcel->getActiveSheet()->getHighestRow())->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle('A5:D5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A5:D5')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('E6:X6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('E6:X6')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

        $objPHPExcel->getActiveSheet()->getStyle('E5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('I5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A7:X7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('E6:X6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('M5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('O5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('Q5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('S5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('U5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('W5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        $objPHPExcel->getActiveSheet()->mergeCells('A5:A6');
        $objPHPExcel->getActiveSheet()->mergeCells('B5:B6');
        $objPHPExcel->getActiveSheet()->mergeCells('C5:C6');
        $objPHPExcel->getActiveSheet()->mergeCells('D5:D6');
        $objPHPExcel->getActiveSheet()->mergeCells('E5:H5');
        $objPHPExcel->getActiveSheet()->mergeCells('I5:L5');
        $objPHPExcel->getActiveSheet()->mergeCells('M5:N5');
        $objPHPExcel->getActiveSheet()->mergeCells('O5:P5');
        $objPHPExcel->getActiveSheet()->mergeCells('Q5:R5');
        $objPHPExcel->getActiveSheet()->mergeCells('S5:T5');
        $objPHPExcel->getActiveSheet()->mergeCells('U5:V5');
        $objPHPExcel->getActiveSheet()->mergeCells('W5:X5');

        $objPHPExcel->getActiveSheet()->setCellValue('A5', 'NO')
            ->setCellValue('B5', "OPD")
            ->setCellValue('C5', "JML PEGAWAI")
            ->setCellValue('D5', 'JML HARI KERJA')
            ->setCellValue('E5', 'KETIDAKHADIRAN')
            ->setCellValue('E6', 'PEGAWAI')
            ->setCellValue('F6', '%')
            ->setCellValue('G6', 'HARI')
            ->setCellValue('H6', '%')
            ->setCellValue('I5', 'KEHADIRAN')
            ->setCellValue('I6', 'PEGAWAI')
            ->setCellValue('J6', '%')
            ->setCellValue('K6', 'HARI')
            ->setCellValue('L6', '%')
            ->setCellValue('M5', 'C')
            ->setCellValue('M6', 'PEGAWAI')
            ->setCellValue('N6', 'HARI')
            ->setCellValue('O5', 'DL')
            ->setCellValue('O6', 'PEGAWAI')
            ->setCellValue('P6', 'HARI')
            ->setCellValue('Q5', 'DI')
            ->setCellValue('Q6', 'PEGAWAI')
            ->setCellValue('R6', 'HARI')
            ->setCellValue('S5', 'I')
            ->setCellValue('S6', 'PEGAWAI')
            ->setCellValue('T6', 'HARI')
            ->setCellValue('U5', 'S')
            ->setCellValue('U6', 'PEGAWAI')
            ->setCellValue('V6', 'HARI')
            ->setCellValue('W5', 'TK')
            ->setCellValue('W6', 'PEGAWAI')
            ->setCellValue('X6', 'HARI');

        $objPHPExcel->getActiveSheet()->setCellValue('A7', '1')
            ->setCellValue('B7', '2')
            ->setCellValue('C7', '3')
            ->setCellValue('D7', '4')
            ->setCellValue('E7', '5')
            ->setCellValue('F7', '6')
            ->setCellValue('G7', '7')
            ->setCellValue('H7', '8')
            ->setCellValue('I7', '9')
            ->setCellValue('J7', '10')
            ->setCellValue('K7', '11')
            ->setCellValue('L7', '12')
            ->setCellValue('M7', '13')
            ->setCellValue('N7', '14')
            ->setCellValue('O7', '15')
            ->setCellValue('P7', '16')
            ->setCellValue('Q7', '17')
            ->setCellValue('R7', '18')
            ->setCellValue('S7', '19')
            ->setCellValue('T7', '20')
            ->setCellValue('U7', '21')
            ->setCellValue('V7', '22')
            ->setCellValue('W7', '23')
            ->setCellValue('X7', '24');

        $this->db->trans_begin();
        $query = $this->db->query("CALL PRCD_ABSENSI_CETAK_ALL_OPD($bln, $thn)");

        if ($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
        }else{
            $this->db->trans_commit();
            $data = null;
            $i = 0;
            foreach ($query->result() as $row)
            {
                $data[$i] = $row;
                $dataArray[$i] = array($data[$i]->no_urut,$data[$i]->nama_baru,$data[$i]->jmlPegawai,$data[$i]->jmlHariKerja,
                    $data[$i]->jml_pegawai_absen,$data[$i]->persen_jml_pegawai_absen,$data[$i]->jml_hari_absen,$data[$i]->persen_jml_hari_absen,
                    $data[$i]->jml_pegawai_hadir,$data[$i]->persen_jml_pegawai_hadir,$data[$i]->jml_hari_hadir,$data[$i]->persen_jml_hari_hadir,
                    $data[$i]->org_C,$data[$i]->hari_C,$data[$i]->org_DL,$data[$i]->hari_DL,$data[$i]->org_DI,$data[$i]->hari_DI,
                    $data[$i]->org_I,$data[$i]->hari_I,$data[$i]->org_S,$data[$i]->hari_S,$data[$i]->org_TK,$data[$i]->hari_TK);
                $i++;
            }
        }

        $objPHPExcel->getActiveSheet()->getStyle('A8:X'.(($i+7)))->applyFromArray($styleArray);
        unset($styleArray);

        $objPHPExcel->getActiveSheet()->getStyle('A8:A'.($i+7))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A8:A'.($i+7))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('B8:B'.($i+7))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('C8:C'.($i+7))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('D8:D'.($i+7))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('E8:E'.($i+7))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('F8:F'.($i+7))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('G8:G'.($i+7))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('H8:H'.($i+7))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('I8:I'.($i+7))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('J8:J'.($i+7))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('K8:K'.($i+7))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('L8:L'.($i+7))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('M8:M'.($i+7))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('N8:N'.($i+7))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('O8:O'.($i+7))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('P8:P'.($i+7))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('Q8:Q'.($i+7))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('R8:R'.($i+7))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('S8:S'.($i+7))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('T8:T'.($i+7))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('U8:U'.($i+7))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('V8:V'.($i+7))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('W8:W'.($i+7))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('X8:X'.($i+7))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

        // Add some data
        $objPHPExcel->getActiveSheet()->fromArray($dataArray, NULL, 'A8');
        $dataArray = null;
        // Rename worksheet (worksheet, not filename)
        $objPHPExcel->getActiveSheet()->setTitle('Data');
        // Set title row bold
        $objPHPExcel->getActiveSheet()->getStyle('A1:A2')->getFont()->setBold(true);
        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $objPHPExcel->setActiveSheetIndex(0);

        //Redirect output to a client’s web browser (Excel2007)
        //clean the output buffer
        ob_end_clean();

        //this is the header given from PHPExcel examples. but the output seems somewhat corrupted in some cases.
        //header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        //so, we use this header instead.
        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="laporan_absensi_pegawai.xlsx"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
    }
}

?>