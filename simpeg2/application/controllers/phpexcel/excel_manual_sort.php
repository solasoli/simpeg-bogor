<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require '/var/www/html/vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

class excel_manual_sort extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
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
            ->setCellValue('M1', 'TMT.BUP')
            ->setCellValue('N1', 'SKP')
            ->setCellValue('O1', 'ALAMAT')
            ->setCellValue('P1', 'KOTA');

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
                    $andKlausa .= "AND eselon = 'IIIB' AND pengalaman_eselon_current >= 2 AND d.tgl_diklat <> ''";
                    break;
                case 'iiib' :
                    $andKlausa .= "AND eselon = 'IVA' AND pengalaman_eselon_current >= 2 AND d.tgl_diklat <> ''";
                    break;
                case 'iva' :
                    $andKlausa .= "AND ((eselon = 'IVB' AND pengalaman_eselon_current >= 2) 
                    OR (eselon = 'V' AND pengalaman_eselon_current >= 2) 
                    OR eselon = '' OR eselon IS NULL = 1)";
                    break;
                case 'ivb' :
                    $andKlausa .= "AND ((eselon = 'V' AND pengalaman_eselon_current >= 2) 
                    OR eselon = '' OR eselon IS NULL = 1)";
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

        /*$sql = "SELECT FCN_ROW_NUMBER() as no_urut, b.*, CONCAT(\"'\",b.nip_baru) as nip FROM
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
            FROM draft_pelantikan_sort_manual dps 
            LEFT JOIN diklat d ON dps.id_pegawai = d.id_pegawai AND d.id_jenis_diklat = 3 AND d.nama_diklat LIKE '%Sertifikasi Pengadaan Barang dan Jasa%', 
            kategori_pendidikan kp
            WHERE dps.tk_pendidikan = kp.nama_pendidikan AND idskpd_tujuan = ".$idskpd_tujuan.$andKlausa.$orderby_query_string.
            ")a LEFT JOIN hukuman h ON a.id_pegawai = h.id_pegawai GROUP BY a.id_pegawai)b".$orderby_query_string; */

        $sql = "SELECT FCN_ROW_NUMBER() as no_urut, e.*, 
                GROUP_CONCAT(CONCAT('Thn.', e.tahun_skp,\" (\",e.periode_awal,\") :: \", \"Orientasi Pelayanan=\", sh.orientasi_pelayanan, \", Integritas=\", sh.integritas, \", Komitmen=\", sh.komitmen, \", Disiplin=\", sh.disiplin, \", Kerjasama=\", sh.kerjasama, \", Kepemimpinan=\", (CASE WHEN sh.kepemimpinan IS NULL = 1 THEN 0 ELSE sh.kepemimpinan END), \", Rata-rata Perilaku = \", 
                ROUND( ((sh.orientasi_pelayanan + sh.integritas + sh.komitmen + sh.disiplin + sh.kerjasama + (CASE WHEN sh.kepemimpinan IS NULL = 1 THEN 0 ELSE sh.kepemimpinan END)) / (CASE WHEN sh.kepemimpinan IS NULL = 1 THEN (CASE WHEN e.eselon = 'Z' THEN 5 ELSE 6 END) ELSE 6 END)) ,2), \", Capaian SKP (60%) = \", (0.6*e.rata_rata_pencapaian_skp), \", Capaian Perilaku (40%) = \", (0.4*(ROUND( ((sh.orientasi_pelayanan + sh.integritas + sh.komitmen + sh.disiplin + sh.kerjasama + (CASE WHEN sh.kepemimpinan IS NULL = 1 THEN 0 ELSE sh.kepemimpinan END)) / (CASE WHEN sh.kepemimpinan IS NULL = 1 THEN (CASE WHEN e.eselon = 'Z' THEN 5 ELSE 6 END) ELSE 6 END)) ,2))), \",
                Nilai Akhir SKP = \", ((0.6*e.rata_rata_pencapaian_skp) + (0.4*(ROUND( ((sh.orientasi_pelayanan + sh.integritas + sh.komitmen + sh.disiplin + sh.kerjasama + (CASE WHEN sh.kepemimpinan IS NULL = 1 THEN 0 ELSE sh.kepemimpinan END)) / (CASE WHEN sh.kepemimpinan IS NULL = 1 THEN (CASE WHEN e.eselon = 'Z' THEN 5 ELSE 6 END) ELSE 6 END)) ,2))) ) ) SEPARATOR \"
                \") AS skp, p.alamat, p.kota FROM (SELECT d.*, MAX(sh.id_skp) AS id_skp 
                FROM (SELECT c.no_reg, c.idskpd_tujuan, c.id_pegawai, c.nip_baru, c.nip, c.nama, c.unit, c.id_skpd, c.pangkat_gol, c.masa_kerja, c.umur, c.jenjab, c.jabatan, c.eselon, c.tk_pendidikan, 
                c.id_bidang, c.jurusan_pendidikan, c.jml_diklat_pim_2, c.jml_diklat_pim_3, c.jml_diklat_pim_4, c.pengalaman_uk, c.pengalaman_eselon_current, c.tmt_bup, c.level_p, c.tgl_diklat_barjas, 
                c.hukuman, c.tahun_skp, MAX(c.periode_awal) AS periode_awal, ROUND(AVG(c.rata_rata_pencapaian_skp),2) AS rata_rata_pencapaian_skp 
                FROM (SELECT b.*, YEAR(sh.periode_awal) AS tahun_skp, sh.periode_awal, sh.periode_akhir, st.id_skp, ROUND(AVG(CASE WHEN st.nilai_capaian IS NULL = 1 THEN 0 ELSE st.nilai_capaian END),2) AS rata_rata_pencapaian_skp, CONCAT(\"'\",b.nip_baru) as nip FROM
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
            ),  '%d/%m/%Y')AS tmt_bup, level_p, GROUP_CONCAT(DATE_FORMAT(d.tgl_diklat, '%d-%m-%Y') SEPARATOR \", \") AS tgl_diklat_barjas 
            FROM draft_pelantikan_sort_manual dps 
            LEFT JOIN diklat d ON dps.id_pegawai = d.id_pegawai AND d.id_jenis_diklat = 3 AND d.nama_diklat LIKE '%Sertifikasi Pengadaan Barang dan Jasa%', 
            kategori_pendidikan kp
            WHERE dps.tk_pendidikan = kp.nama_pendidikan AND idskpd_tujuan = ".$idskpd_tujuan.$andKlausa.
            "GROUP BY dps.id_pegawai ".$orderby_query_string.
            ")a LEFT JOIN hukuman h ON a.id_pegawai = h.id_pegawai GROUP BY a.id_pegawai)b LEFT JOIN skp_header sh ON b.id_pegawai = sh.id_pegawai AND ((YEAR(sh.periode_awal) = 2018 AND YEAR(sh.periode_akhir) = 2018) OR (YEAR(sh.periode_awal) = 2017 AND YEAR(sh.periode_akhir) = 2017)) 
            LEFT JOIN skp_target st ON sh.id_skp = st.id_skp GROUP BY b.id_pegawai, st.id_skp) c GROUP BY c.id_pegawai, c.tahun_skp ) d 
            LEFT JOIN skp_header sh ON d.periode_awal = sh.periode_awal AND d.id_pegawai = sh.id_pegawai AND sh.orientasi_pelayanan > 0 and sh.integritas > 0 
            GROUP BY d.id_pegawai, d.tahun_skp) e 
            LEFT JOIN skp_header sh ON e.id_skp = sh.id_skp LEFT JOIN pegawai p ON e.id_pegawai = p.id_pegawai 
            GROUP BY id_pegawai ".$orderby_query_string;

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
                    $data[$i]->tmt_bup,$data[$i]->skp,$data[$i]->alamat,$data[$i]->kota);
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