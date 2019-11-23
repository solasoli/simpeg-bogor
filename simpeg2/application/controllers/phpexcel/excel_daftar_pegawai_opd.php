<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require '/etc/php/7.2/apache2/vendor/autoload.php';
require '/etc/php/7.2/apache2/vendor/cache/apcu-adapter/ApcuCachePool.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

class excel_daftar_pegawai_opd extends CI_Controller{
    public function __construct(){
        parent::__construct();
        $this->load->library('cache');
    }

    public function index($idopd){
        $pool = new \Cache\Adapter\Apcu\ApcuCachePool();
        $simpleCache = new \Cache\Bridge\SimpleCache\SimpleCacheBridge($pool);
        \PhpOffice\PhpSpreadsheet\Settings::setCache($simpleCache);
        $this->export_data_excel($idopd);
    }

    public function export_data_excel($idopd){
        // Create new Spreadsheet object
        $spreadsheet = new Spreadsheet();

        // Set document properties
        $spreadsheet->getProperties()->setCreator("SIMPEG Kota Bogor")
            ->setLastModifiedBy("SIMPEG Kota Bogor")
            ->setTitle("Daftar Pegawai OPD")
            ->setSubject("Daftar Pegawai OPD")
            ->setDescription("Daftar Pegawai OPD, created by SIMPEG")
            ->setKeywords("Daftar Pegawai OPD")
            ->setCategory("Daftar Pegawai OPD");

        // Create the worksheet
        $spreadsheet->setActiveSheetIndex(0);
        $spreadsheet->getActiveSheet()->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
        $spreadsheet->getActiveSheet()->getPageSetup()->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_LEGAL);
        $spreadsheet->getActiveSheet()->getPageSetup()->setFitToPage(true);
        $spreadsheet->getActiveSheet()->getPageSetup()->setFitToWidth(1);
        $spreadsheet->getActiveSheet()->getPageSetup()->setFitToHeight(0);

        // Load Model
        $this->load->model('unit_kerja_model');
        $nama_skpd = $this->unit_kerja_model->getNamaSKPD($idopd);
        $list_data = $this->unit_kerja_model->get_daftar_pegawai_opd($idopd);
        
        $styleArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ];

        $styleArrayHeader = [
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'color' => ['argb' => '4F81BD'],
            ],
            'font' => [
                'bold' => true,
                'color' => ['argb' => 'FFFFFF'],
                'size' => 11,
            ],
        ];

        // Rename sheet 1
        $spreadsheet->setActiveSheetIndex(0)->setTitle('Data');
        $spreadsheet->getActiveSheet()->mergeCells('A1:E1');
        $spreadsheet->getActiveSheet()->mergeCells('A2:E2');
        $spreadsheet->getActiveSheet()->getStyle('A1:E2')->getFont()->setBold(true);
        $spreadsheet->getActiveSheet()->getStyle('A1:E2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $spreadsheet->getActiveSheet()->getStyle('A1:E2')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $spreadsheet->getActiveSheet()->setCellValue('A1', 'Daftar Pegawai');
        $spreadsheet->getActiveSheet()->setCellValue('A2', $nama_skpd);
        $spreadsheet->getActiveSheet()->setCellValue('A4', 'No');
        $spreadsheet->getActiveSheet()->setCellValue('B4', 'Nama');
        $spreadsheet->getActiveSheet()->setCellValue('C4', 'NIP');
        $spreadsheet->getActiveSheet()->setCellValue('D4', 'Gol');
        $spreadsheet->getActiveSheet()->setCellValue('E4', 'Jabatan');
        $spreadsheet->getActiveSheet()->getStyle('A4:E4')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $spreadsheet->getActiveSheet()->getStyle('A4:E4')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $spreadsheet->getActiveSheet()->getStyle('A4:E4')->applyFromArray($styleArrayHeader);
        $spreadsheet->getActiveSheet()->getRowDimension('4')->setRowHeight(21);
        $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(7); // No
        $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(35); // Nama
        $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(20); // Nip
        $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(10); // Gol
        $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(51); // Jabatan

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
        $spreadsheet->getActiveSheet()->fromArray($dataArray, NULL, 'A5');

        $spreadsheet->getActiveSheet()->getStyle('A5:A'.($i+4))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $spreadsheet->getActiveSheet()->getStyle('B5:C'.($i+4))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $spreadsheet->getActiveSheet()->getStyle('D5:D'.($i+4))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $spreadsheet->getActiveSheet()->getStyle('E5:E'.($i+4))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $spreadsheet->getActiveSheet()->getStyle('A5:E'.($i+4))->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP);
        $spreadsheet->getActiveSheet()->getStyle('A5:E'.($i+4).$spreadsheet->getActiveSheet()->getHighestRow())->getAlignment()->setWrapText(true);
        $spreadsheet->getActiveSheet()->getStyle('A4:E'.($i+4))->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->freezePane('A5');
        $spreadsheet->getActiveSheet()->getSheetView()->setZoomScale(100);
        //----------------------------------------------

        $writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="Daftar_Pegawai_'.$nama_skpd.'.xlsx"');
        header('Cache-Control: max-age=0');
        $writer->save("php://output");
        
    }
}