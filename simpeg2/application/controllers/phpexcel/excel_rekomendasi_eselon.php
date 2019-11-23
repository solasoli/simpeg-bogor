<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require '/var/www/html/vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

class excel_rekomendasi_eselon extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index($idskpd_tujuan, $jbtn_eselon, $limit_banyaknya, $tipe_rekomendasi)
    {
        $this->export_data_excel($idskpd_tujuan, $jbtn_eselon, $limit_banyaknya, $tipe_rekomendasi);
    }

    public function export_data_excel($idskpd_tujuan, $jbtn_eselon, $limit_banyaknya, $tipe_rekomendasi)
    {
        // Create new Spreadsheet object
        $spreadsheet = new Spreadsheet();

        // Set document properties
        $spreadsheet->getProperties()->setCreator("SIMPEG Kota Bogor")
            ->setLastModifiedBy("SIMPEG Kota Bogor")
            ->setTitle("Daftar Rekomendasi Pejabat Struktural Eselon")
            ->setSubject("Daftar Rekomendasi Pejabat Struktural Eselon")
            ->setDescription("Daftar Rekomendasi Pejabat Struktural Eselon, hasil penelusuran data pada aplikasi SIMPEG")
            ->setKeywords("pejabat struktural eselon")
            ->setCategory("Rekomendasi");

        // Create the worksheet
        $spreadsheet->setActiveSheetIndex(0);
        $spreadsheet->getActiveSheet()->setCellValue('A1', 'NO.')
            ->setCellValue('B1', 'NIP')
            ->setCellValue('C1', 'NAMA')
            ->setCellValue('D1', 'TGL.LAHIR')
            ->setCellValue('E1', 'GOLONGAN')
            ->setCellValue('F1', 'JABATAN')
            ->setCellValue('G1', 'MASA KERJA')
            ->setCellValue('H1', 'UMUR')
            ->setCellValue('I1', 'JENIS JABATAN')
            ->setCellValue('J1', 'PENDIDIKAN')
            ->setCellValue('K1', 'ESELON')
            ->setCellValue('L1', 'PENGALAMAN ESELON');

        if($tipe_rekomendasi == 'bayesnet') {
            $this->db->trans_begin();
            if($jbtn_eselon == 'IIB') {
                $orderby_query_string = " ORDER BY dpb.bayes_val_total DESC,
                    dpb.eselonering ASC, dpb.pengalaman_eselon_current DESC, dpb.pangkat,
                    dpb.jml_diklat_pim_2 DESC, dpb.jenis_jbtn DESC, dpb.tk_pendidikan,
                    dpb.pengalaman_uk DESC, dpb.masa_kerja DESC, dpb.umur DESC ";
            }elseif($jbtn_eselon == 'IVB') {
                $orderby_query_string = " ORDER BY dpb.bayes_val_total DESC,
                    dpb.eselonering ASC, dpb.pengalaman_eselon_current DESC,
                    dpb.masa_kerja DESC, dpb.jenis_jbtn DESC, dpb.pengalaman_uk DESC,
                    dpb.pangkat, dpb.tk_pendidikan, jml_diklat_pim_4 DESC,
                    dpb.umur DESC ";
            }elseif($jbtn_eselon == 'V'){
                $orderby_query_string = " ORDER BY dpb.bayes_val_total DESC,
                    dpb.eselonering ASC, dpb.pengalaman_eselon_current DESC,
                    dpb.masa_kerja DESC, dpb.jenis_jbtn DESC, dpb.pengalaman_uk DESC,
                    dpb.pangkat, dpb.tk_pendidikan, dpb.umur DESC";
            }
            $this->db->query("SET @andKlause = FCN_ONE_UNDER_ESELONDESTINY('".$jbtn_eselon."', 'for_droping')");
            $query_andklause  = $this->db->query("SELECT @andKlause as andklause");
            $data = null;
            foreach ($query_andklause->result() as $row)
            {
                $data[] = $row;
            }

            $query = $this->db->query("
            SELECT
            @row_number_vw:=@row_number_vw+1 AS no_urut, view_dt_bayes.nip, view_dt_bayes.nama,
            p.tgl_lahir, view_dt_bayes.pangkat, p.jabatan, view_dt_bayes.masa_kerja, view_dt_bayes.umur,
            view_dt_bayes.jenis_jbtn, kpend.nama_pendidikan, view_dt_bayes.eselonering, view_dt_bayes.pengalaman_eselon
            FROM
            (SELECT jbtn_eselon, idpegawai,
            CONCAT(\"'\",nip) as nip, dpb.nama, skpd, pangkat, masa_kerja, umur, jenis_jbtn,
            tk_pendidikan, jml_diklat_pim_2, jml_diklat_pim_3, jml_diklat_pim_4, pengalaman_uk,
             bayes_val_total, CASE WHEN j.jabatan IS NULL = 1 THEN '' ELSE j.jabatan END AS jabatan,
            dpb.eselonering, dpb.pengalaman_eselon_current AS pengalaman_eselon
            FROM draft_pelantikan_base_bayes dpb, pegawai p LEFT JOIN jabatan j ON p.id_j = j.id_j
            WHERE dpb.idskpd_tujuan = " . $idskpd_tujuan . " AND dpb.idpegawai = p.id_pegawai
            AND dpb.jbtn_eselon = '" . $jbtn_eselon . $data[0]->andklause . $orderby_query_string . "LIMIT 0," . $limit_banyaknya . ")
            as view_dt_bayes, unit_kerja uk, pegawai p, kategori_pendidikan kpend, (SELECT @row_number_vw:=0) AS t
            WHERE uk.id_unit_kerja = view_dt_bayes.skpd AND p.id_pegawai = view_dt_bayes.idpegawai AND
            kpend.level_p = view_dt_bayes.tk_pendidikan");
        }else{
            if($jbtn_eselon == 'IIIA') {
                $orderby_query_string = " ORDER BY dpb.jml_diklat_pim_3 DESC, dpb.jenis_jbtn DESC, dpb.tk_pendidikan ASC, dpb.pangkat DESC,
               dpb.pengalaman_uk DESC, dpb.umur DESC, dpb.masa_kerja DESC ";
            }elseif($jbtn_eselon == 'IIIB') {
                $orderby_query_string = " ORDER BY dpb.pangkat DESC, dpb.tk_pendidikan ASC, dpb.jml_diklat_pim_4 DESC,
               dpb.jenis_jbtn DESC, dpb.pengalaman_uk DESC, dpb.masa_kerja DESC, dpb.umur DESC ";
            }elseif($jbtn_eselon == 'IVA'){
                $orderby_query_string = " ORDER BY dpb.jenis_jbtn DESC, dpb.pangkat DESC, dpb.jml_diklat_pim_4 DESC,
               dpb.tk_pendidikan ASC, dpb.pengalaman_uk DESC, dpb.masa_kerja DESC, dpb.umur DESC";
            }
            $this->db->query("SET @andKlause = FCN_ONE_UNDER_ESELONDESTINY('".$jbtn_eselon."', 'for_droping')");
            $query_andklause  = $this->db->query("SELECT @andKlause as andklause");
            $data = null;
            foreach ($query_andklause->result() as $row)
            {
                $data[] = $row;
            }
            $query = $this->db->query("SET @row_number := 0;");
            $query = $this->db->query("
            SELECT
            view_dt_cruise.nip, view_dt_cruise.nama,
            p.tgl_lahir, view_dt_cruise.pangkat, p.jabatan, view_dt_cruise.masa_kerja, view_dt_cruise.umur,
            view_dt_cruise.jenis_jbtn, kpend.nama_pendidikan, view_dt_cruise.eselonering, view_dt_cruise.pengalaman_eselon
            FROM
            (SELECT FCN_ROW_NUMBER() as no_urut, jbtn_eselon, idpegawai,
            CONCAT(\"'\",nip) as nip, dpb.nama, skpd, pangkat, masa_kerja, umur, jenis_jbtn,
            tk_pendidikan, jml_diklat_pim_2, jml_diklat_pim_3, jml_diklat_pim_4, pengalaman_uk,
            CASE WHEN j.jabatan IS NULL = 1 THEN '' ELSE j.jabatan END AS jabatan,
            dpb.eselonering, dpb.pengalaman_eselon_current AS pengalaman_eselon
            FROM draft_pelantikan_base_cruise dpb, pegawai p LEFT JOIN jabatan j ON p.id_j = j.id_j
            WHERE dpb.idskpd_tujuan = " . $idskpd_tujuan . " AND dpb.idpegawai = p.id_pegawai
            AND dpb.jbtn_eselon = '" . $jbtn_eselon . $data[0]->andklause . $orderby_query_string . "LIMIT 0," . $limit_banyaknya . ")
            as view_dt_cruise, unit_kerja uk, pegawai p, kategori_pendidikan kpend
            WHERE uk.id_unit_kerja = view_dt_cruise.skpd AND p.id_pegawai = view_dt_cruise.idpegawai AND
            kpend.level_p = view_dt_cruise.tk_pendidikan ORDER BY view_dt_cruise.no_urut");
        }
        if ($this->db->trans_status() === FALSE)
        {
            $this->db->trans_rollback();
        }else{
            $this->db->trans_commit();
            $data = null;
            $i = 0;
            foreach ($query->result() as $row)
            {
                $data[$i] = $row;
                $dataArray[$i] = array($i+1,$data[$i]->nip,$data[$i]->nama,$data[$i]->tgl_lahir,
                    $data[$i]->pangkat,$data[$i]->jabatan,$data[$i]->masa_kerja,$data[$i]->umur,$data[$i]->jenis_jbtn,
                    $data[$i]->nama_pendidikan,$data[$i]->eselonering,$data[$i]->pengalaman_eselon);
                $i++;
            }
        }

        // Add some data
        $spreadsheet->getActiveSheet()->fromArray($dataArray, NULL, 'A2');
        $dataArray = null;
        // Rename worksheet (worksheet, not filename)
        $spreadsheet->getActiveSheet()->setTitle('Data');
        // Set title row bold
        $spreadsheet->getActiveSheet()->getStyle('A1:L1')->getFont()->setBold(true);
        // Set autofilter
        $spreadsheet->getActiveSheet()->setAutoFilter($spreadsheet->getActiveSheet()->calculateWorksheetDimension());
        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $spreadsheet->setActiveSheetIndex(0);

        // Redirect output to a client’s web browser (Excel2007)
        //clean the output buffer
        ob_end_clean();

        $writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="data_rekomendasi_pegawai.xlsx"');
        header('Cache-Control: max-age=0');
        $writer->save("php://output");

    }

}