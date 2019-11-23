<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require '/etc/php/7.2/apache2/vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

class excel_ipp_asn extends CI_Controller
{
    public function __construct(){
        parent::__construct();
    }

    public function index($idopd){
        $this->export_data_excel($idopd);
    }

    public function export_data_excel($idopd){
        // Create new Spreadsheet object
        $spreadsheet = new Spreadsheet();

        // Set document properties
        $spreadsheet->getProperties()->setCreator('SIMPEG Kota Bogor')
            ->setLastModifiedBy("SIMPEG Kota Bogor")
            ->setTitle("Laporan Indeks Profesional Pegawai")
            ->setSubject("Laporan Indeks Profesional Pegawai")
            ->setDescription("Laporan Indeks Profesional Pegawai, created by SIMPEG")
            ->setKeywords("laporan Indeks Profesional Pegawai")
            ->setCategory("Laporan Indeks Profesional Pegawai");

        // Create the worksheet
        $spreadsheet->setActiveSheetIndex(0);
        $spreadsheet->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
        $spreadsheet->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_LEGAL);
        $spreadsheet->getActiveSheet()->getPageSetup()->setFitToPage(true);
        $spreadsheet->getActiveSheet()->getPageSetup()->setFitToWidth(1);
        $spreadsheet->getActiveSheet()->getPageSetup()->setFitToHeight(0);

        // Load Model
        $this->load->model('ipp_asn_model');
        $nama_skpd = $this->ipp_asn_model->getNamaSKPD($idopd);
        $list_pjbt = $this->ipp_asn_model->getListPejabat($idopd);

        print_r($nama_skpd);

        //$writer = new Xlsx($spreadsheet);
        //$writer->save('hello world.xlsx');
    }
}
?>