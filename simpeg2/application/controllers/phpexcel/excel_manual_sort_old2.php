<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require '/etc/php/7.2/apache2/vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

class excel_manual_sort extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('phptoexcel');
    }

    public function index($idskpd_tujuan, $jbtn_eselon, $a, $b, $c, $d, $e, $f, $g, $filter, $pend, $keywordCari)
    {
        $this->export_data_excel($idskpd_tujuan, $jbtn_eselon, $a, $b, $c, $d, $e, $f, $g, $filter, $pend, $keywordCari);
    }

    public function export_data_excel($idskpd_tujuan, $jbtn_eselon, $a, $b, $c, $d, $e, $f, $g, $filter, $pend, $keywordCari)
    {
        // Create new Spreadsheet object
        $spreadsheet = new Spreadsheet();

        // Set document properties
        $spreadsheet->getProperties()->setCreator("SIMPEG Kota Bogor")
            ->setLastModifiedBy("SIMPEG Kota Bogor")
            ->setTitle("Daftar Rekomendasi Pejabat Struktural")
            ->setSubject("Daftar Rekomendasi Pejabat Struktural")
            ->setDescription("Daftar Rekomendasi Pejabat Struktural, hasil penelusuran pada database SIMPEG")
            ->setKeywords("pelantikan pejabat struktural")
            ->setCategory("Rekomendasi Pejabat");

        // Create the worksheet
        $spreadsheet->setActiveSheetIndex(0);
        $spreadsheet->getActiveSheet()->setCellValue('A1', 'NO.')
            ->setCellValue('B1', 'NIP')
            ->setCellValue('C1', 'NAMA')
            ->setCellValue('D1', 'GOLONGAN')
            ->setCellValue('E1', 'JABATAN')
            ->setCellValue('F1', 'UNIT KERJA')
            ->setCellValue('G1', 'MASA KERJA')
            ->setCellValue('H1', 'UMUR')
            ->setCellValue('I1', 'ESELON')
            ->setCellValue('J1', 'PENDIDIKAN')
            ->setCellValue('K1', 'JURUSAN')
            ->setCellValue('L1', 'PENGALAMAN ESELON')
            ->setCellValue('M1', 'TMT.BUP');

        $orderby_query_string = "";
        $andKlausa = " AND jenjab = 'Struktural' ";
        if($a!='0'){
            if($a=='tk_pendidikan'){
                $orderby_query_string.= " ORDER BY level_p ASC";
            }else{
                $orderby_query_string.= " ORDER BY ".$a." DESC";
            }
        }
        if($b!='0'){
            $orderby_query_string.= ", ".$b." DESC";
        }
        if($c!='0'){
            $orderby_query_string.= ", ".$c." DESC";
        }
        if($d!='0'){
            $orderby_query_string.= ", ".$d." DESC";
        }
        if($e!='0'){
            $orderby_query_string.= ", ".$e." DESC";
        }
        if($f!='0'){
            $orderby_query_string.= ", ".$f." DESC";
        }
        if($g!='0'){
            $orderby_query_string.= ", ".$g." DESC";
        }
        if($filter == 'Promosi'){
            switch (strtolower($jbtn_eselon)) {
                case 'iib' :
                    $andKlausa .= "AND eselon = 'IIIA' AND pengalaman_eselon_current >= 2";
                    break;
                case 'iiia' :
                    $andKlausa .= "AND eselon = 'IIIB' AND pengalaman_eselon_current >= 2";
                    break;
                case 'iiib' :
                    $andKlausa .= "AND eselon = 'IVA' AND pengalaman_eselon_current >= 2";
                    break;
                case 'iva' :
                    $andKlausa .= "AND ((eselon = 'IVB' AND pengalaman_eselon_current >= 2) OR
              (eselon = 'V' AND pengalaman_eselon_current >= 2) OR eselon = '')";
                    break;
                case 'ivb' :
                    $andKlausa .= "AND ((eselon = 'V' AND pengalaman_eselon_current >= 2) OR eselon = '')";
                    break;
            }
        }elseif($filter == 'Rotasi'){
            $andKlausa .= " AND eselon = '".$jbtn_eselon."' ";
        }
        if($pend!='0'){
            $andKlausa .= " AND id_bidang = ".$pend;
        }
        if (!(trim($keywordCari)== "") && !(trim($keywordCari)== "0") && !(trim($keywordCari)== "-")){
            $andKlausa = " AND (nip_baru LIKE '%".$keywordCari."%'
								OR nama LIKE '%".$keywordCari."%'
								OR unit LIKE '%".$keywordCari."%'
								OR jabatan LIKE '%".$keywordCari."%')".$andKlausa;
        }

        $sql = "SELECT FCN_ROW_NUMBER() as no_urut, b.*, CONCAT(\"'\",b.nip_baru) as nip FROM
                (SELECT a.*, GROUP_CONCAT(h.keterangan,' (',YEAR(h.tmt),') ',' | ') AS hukuman  FROM
                (SELECT dps.*,
                DATE_FORMAT(DATE_SUB(
                LAST_DAY(
                    DATE_ADD(DATE_ADD(CONCAT(SUBSTRING(nip_baru,1,4),'-',SUBSTRING(nip_baru,5,2),'-',SUBSTRING(nip_baru,7,2)), INTERVAL (SELECT CASE WHEN (eselon = 'IIA' OR eselon = 'IIB') THEN 60 ELSE 58 END) YEAR), INTERVAL 1 MONTH)
                ),
                INTERVAL DAY(
                    LAST_DAY(
                        DATE_ADD(DATE_ADD(CONCAT(SUBSTRING(nip_baru,1,4),'-',SUBSTRING(nip_baru,5,2),'-',SUBSTRING(nip_baru,7,2)), INTERVAL (SELECT CASE WHEN (eselon = 'IIA' OR eselon = 'IIB') THEN 60 ELSE 58 END) YEAR), INTERVAL 1 MONTH)
                    )
                )-1 DAY
            ),  '%d/%m/%Y')AS tmt_bup, level_p
            FROM draft_pelantikan_sort_manual dps, kategori_pendidikan kp
            WHERE dps.tk_pendidikan = kp.nama_pendidikan AND idskpd_tujuan = ".$idskpd_tujuan.$andKlausa.$orderby_query_string.
            ")a LEFT JOIN hukuman h ON a.id_pegawai = h.id_pegawai GROUP BY a.id_pegawai)b".$orderby_query_string;

        $query = $this->db->query($sql);
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
                $dataArray[$i] = array($i+1,$data[$i]->nip,$data[$i]->nama,$data[$i]->pangkat_gol,
                    $data[$i]->jabatan,$data[$i]->unit,$data[$i]->masa_kerja,$data[$i]->umur,$data[$i]->eselon,
                    $data[$i]->tk_pendidikan,$data[$i]->jurusan_pendidikan,$data[$i]->pengalaman_eselon_current,
                    $data[$i]->tmt_bup);
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

        //Redirect output to a client’s web browser (Excel2007)
        //clean the output buffer
        ob_end_clean();

        $writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="data_rekomendasi_pegawai.xlsx"');
        header('Cache-Control: max-age=0');
        $writer->save("php://output");

    }

}