<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class excel_daftar_pegawai_opd extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('phptoexcel');
    }

    public function index($idopd)
    {
        ini_set('memory_limit','2048M');
        $cacheMethod = PHPExcel_CachedObjectStorageFactory:: cache_to_phpTemp;
        $cacheSettings = array('memoryCacheSize ' => '1024MB', 'cacheTime' => 6000);
        PHPExcel_Settings::setCacheStorageMethod($cacheMethod, $cacheSettings);
        $this->export_data_excel($idopd);
    }

    public function export_data_excel($idopd){
        // Create new PHPExcel object
        $objPHPExcel = new PHPExcel();

        // Set document properties
        $objPHPExcel->getProperties()->setCreator("SIMPEG Kota Bogor")
            ->setLastModifiedBy("SIMPEG Kota Bogor")
            ->setTitle("Daftar Pegawai OPD")
            ->setSubject("Daftar Pegawai OPD")
            ->setDescription("Daftar Pegawai OPD, created by SIMPEG")
            ->setKeywords("Daftar Pegawai OPD")
            ->setCategory("Daftar Pegawai OPD");

        // Create the worksheet
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_LEGAL);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setFitToPage(true);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setFitToWidth(1);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setFitToHeight(0);

        // Load Model
        $this->load->model('unit_kerja_model');
        $nama_skpd = $this->unit_kerja_model->getNamaSKPD($idopd);
        $list_data = $this->unit_kerja_model->get_daftar_pegawai_opd($idopd);

        $styleArray = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        );

        $styleArrayHeader = array(
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => '4F81BD')
            ),
            'font' => array(
                'bold'  => true,
                'color' => array('rgb' => 'FFFFFF'),
                'size'  => 11
            )
        );

        // Rename sheet 1
        $objPHPExcel->setActiveSheetIndex(0)->setTitle('Data');
        $objPHPExcel->getActiveSheet()->mergeCells('A1:E1');
        $objPHPExcel->getActiveSheet()->mergeCells('A2:E2');
        $objPHPExcel->getActiveSheet()->getStyle('A1:E2')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('A1:E2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A1:E2')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue('A1', 'Daftar Pegawai');
        $objPHPExcel->getActiveSheet()->setCellValue('A2', $nama_skpd);
        $objPHPExcel->getActiveSheet()->setCellValue('A4', 'No');
        $objPHPExcel->getActiveSheet()->setCellValue('B4', 'Nama');
        $objPHPExcel->getActiveSheet()->setCellValue('C4', 'NIP');
        $objPHPExcel->getActiveSheet()->setCellValue('D4', 'Gol');
        $objPHPExcel->getActiveSheet()->setCellValue('E4', 'Jabatan');
        $objPHPExcel->getActiveSheet()->getStyle('A4:E4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A4:E4')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A4:E4')->applyFromArray($styleArrayHeader);
        $objPHPExcel->getActiveSheet()->getRowDimension('4')->setRowHeight(21);
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(7); // No
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(35); // Nama
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20); // Nip
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(10); // Gol
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(51); // Jabatan

        $i = 0;
        $dataArray = null;
        //echo "<pre>";
        //print_r($list_data);
        //echo "</pre>";
        foreach ($list_data as $row){
            $dataArray[$i] = array($i+1,$row->nama,$row->nip_baru,$row->pangkat_gol,$row->jabatan);
            $i++;
        }
        // Add some data
        $objPHPExcel->getActiveSheet()->fromArray($dataArray, NULL, 'A5');

        $objPHPExcel->getActiveSheet()->getStyle('A5:A'.($i+4))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('B5:C'.($i+4))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $objPHPExcel->getActiveSheet()->getStyle('D5:D'.($i+4))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('E5:E'.($i+4))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $objPHPExcel->getActiveSheet()->getStyle('A5:E'.($i+4))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
        $objPHPExcel->getActiveSheet()->getStyle('A5:E'.($i+4).$objPHPExcel->getActiveSheet()->getHighestRow())->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle('A4:E'.($i+4))->applyFromArray($styleArray);
        $objPHPExcel->getActiveSheet()->freezePane('A5');
        $objPHPExcel->getActiveSheet()->getSheetView()->setZoomScale(100);

        //Redirect output to a client’s web browser (Excel2007)
        //clean the output buffer
        ob_end_clean();

        //this is the header given from PHPExcel examples. but the output seems somewhat corrupted in some cases.
        //header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        //so, we use this header instead.
        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Daftar_Pegawai_'.$nama_skpd.'.xlsx"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');

    }

}