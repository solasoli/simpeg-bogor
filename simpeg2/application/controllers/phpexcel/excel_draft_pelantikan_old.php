<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class excel_draft_pelantikan extends CI_Controller {
    public function __construct(){
        parent::__construct();
        $this->load->library('phptoexcel');
    }

    public function index($iddraft,$eselon)
    {
        $this->export_data_excel($iddraft,$eselon);
    }

    public function export_data_excel($iddraft,$eselon){
        $sql = "SELECT id_baperjakat, no_sk, DATE_FORMAT(tgl_pengesahan,  '%d/%m/%Y') as tgl_pengesahan,
                wkt_pengesahan, ruang_pengesahan
                FROM draft_pelantikan_pengesahan WHERE id_draft = $iddraft";
        $query = $this->db->query($sql);
        $dataPengesahan = null;
        foreach ($query->result() as $row) {
            $dataPengesahan = $row;
        }
        if(isset($dataPengesahan->id_baperjakat) == FALSE){
            $message = 'Pengaturan pengesahan masih kosong';
            echo "<script type='text/javascript'>alert('$message');</script>";
            die();
        }

        // Create new PHPExcel object
        $objPHPExcel = new PHPExcel();

        // Set document properties
        $objPHPExcel->getProperties()->setCreator("SIMPEG Kota Bogor")
            ->setLastModifiedBy("SIMPEG Kota Bogor")
            ->setTitle("Draft Pelantikan Pejabat Struktural")
            ->setSubject("Draft Pelantikan Pejabat Struktural")
            ->setDescription("Draft Pelantikan Pejabat Struktural, created by SIMPEG")
            ->setKeywords("draft pelantikan pejabat struktural")
            ->setCategory("Draft Pelantikan");

        // Create the worksheet
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_LEGAL);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setFitToPage(true);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setFitToWidth(1);
        $objPHPExcel->getActiveSheet()->getPageSetup()->setFitToHeight(0);

        $sql = "select * from baperjakat where id_baperjakat = $dataPengesahan->id_baperjakat";
        $query = $this->db->query($sql);
        $dataBaperjakat = null;
        foreach ($query->result() as $row) {
            $dataBaperjakat = $row;
        }
        $sql = "SELECT p.nip_baru, CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
                nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(' ',p.gelar_belakang) END) AS nama, j.jabatan
                FROM baperjakat_detail bd, pegawai p, jabatan j
                WHERE bd.idpegawai = p.id_pegawai AND bd.id_j = j.id_j AND bd.id_baperjakat = $dataBaperjakat->id_baperjakat
                ORDER BY bd.idstatus_keanggotaan ASC";
        $query = $this->db->query($sql);
        $dataDetailBaperjakat = null;
        $i = 0;
        foreach ($query->result() as $row) {
            $dataDetailBaperjakat[$i] = $row;
            $i++;
        }
        $this->load->model('Baperjakat_model');
        $this->load->model('Terbilang_model');
        $parseTglPengesahan = explode("/", $dataPengesahan->tgl_pengesahan);
        $tglPengesahan = $parseTglPengesahan[0];
        $blnPengesahan = $this->Terbilang_model->getNamaBulan($parseTglPengesahan[1]);
        $thnPengesahan = $parseTglPengesahan[2];
        $hari = $this->Terbilang_model->getNamaHari($parseTglPengesahan[2].'/'.$parseTglPengesahan[1].'/'.$parseTglPengesahan[0]);

        $objPHPExcel->getActiveSheet()->setCellValue('A1', 'PEMERINTAH KOTA BOGOR');
        $objPHPExcel->getActiveSheet()->setCellValue('A2', 'BADAN PERTIMBANGAN JABATAN DAN KEPANGKATAN');
        $objPHPExcel->getActiveSheet()->setCellValue('A3', 'Nomor : '.$dataPengesahan->no_sk);
        $objPHPExcel->getActiveSheet()->setCellValue('A4', 'Tanggal : '.$dataPengesahan->tgl_pengesahan);
        $objPHPExcel->getActiveSheet()->setCellValue('A5', 'Pada hari ini '.$hari.' tanggal '.$this->Terbilang_model->Terbilang((int)$tglPengesahan).' bulan '.$blnPengesahan.' tahun '.$this->Terbilang_model->Terbilang((int)$thnPengesahan).' ('.$dataPengesahan->tgl_pengesahan.'), Kami Badan Pertimbangan Jabatan dan Kepangkatan ( Baperjakat )');
        $objPHPExcel->getActiveSheet()->setCellValue('A6', 'Pemerintah Kota Bogor yang dibentuk dengan Keputusan '.$dataBaperjakat->pengesah_sk.' Nomor '.$dataBaperjakat->no_sk.' yang terdiri dari :');
        $objPHPExcel->getActiveSheet()->setCellValue('C7', '1. Ketua :');
        $objPHPExcel->getActiveSheet()->setCellValue('C8', '2. Sekretaris :');
        $objPHPExcel->getActiveSheet()->setCellValue('C9', '3. Anggota :');
        $objPHPExcel->getActiveSheet()->setCellValue('D7', $dataDetailBaperjakat[0]->jabatan);
        $objPHPExcel->getActiveSheet()->setCellValue('D8', $dataDetailBaperjakat[1]->jabatan);
        $objPHPExcel->getActiveSheet()->setCellValue('D9', $dataDetailBaperjakat[2]->jabatan);
        $objPHPExcel->getActiveSheet()->setCellValue('D10', $dataDetailBaperjakat[3]->jabatan);
        $objPHPExcel->getActiveSheet()->setCellValue('D11', $dataDetailBaperjakat[4]->jabatan);
        $objPHPExcel->getActiveSheet()->setCellValue('D12', $dataDetailBaperjakat[5]->jabatan);
        $objPHPExcel->getActiveSheet()->setCellValue('D13', $dataDetailBaperjakat[6]->jabatan);
        $objPHPExcel->getActiveSheet()->setCellValue('A14', 'telah melaksanakan rapat untuk memberikan Pertimbangan Kelayakan Pengangkatan dan alih tugas Pegawai Negeri Sipil dalam Jabatan Struktural di lingkungan Pemerintah');
        $objPHPExcel->getActiveSheet()->setCellValue('A15', 'Kota Bogor, antara lain :');
        for ($x = 0; $x < 4; $x++) {
            $objPHPExcel->getActiveSheet()->mergeCells('A'.($x+1).':G'.($x+1));
        }
        for ($x = 0; $x <= 3; $x++) {
            $objPHPExcel->getActiveSheet()->getStyle('A'.($x+1))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        }
        $objPHPExcel->getActiveSheet()->getStyle('A5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $objPHPExcel->getActiveSheet()->getStyle('A6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $objPHPExcel->getActiveSheet()->getStyle('A14')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $objPHPExcel->getActiveSheet()->getStyle('A15')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

        $objPHPExcel->getActiveSheet()->getStyle('A17')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A17')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('B17')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('B17')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('C17')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('C17')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('D17')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('D17')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('E17')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('E17')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('F17')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('F17')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('G17')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('G17')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(40);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(40);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(10);

        $styleArray = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        );
        $objPHPExcel->getActiveSheet()->getStyle('A17:G17')->applyFromArray($styleArray);
        $objPHPExcel->getActiveSheet()->getStyle('A18:G18')->applyFromArray($styleArray);
        unset($styleArray);

        $objPHPExcel->getActiveSheet()->getStyle('A17:G17'.$objPHPExcel->getActiveSheet()->getHighestRow())->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle('A18:G18')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        $objPHPExcel->getActiveSheet()->setCellValue('A17', 'NO.')
            ->setCellValue('B17', "NAMA \r\n NIP \r\n TANGGAL LAHIR")
            ->setCellValue('C17', "PANGKAT \r\n GOL. RUANG")
            ->setCellValue('D17', 'JABATAN LAMA')
            ->setCellValue('E17', 'JABATAN BARU')
            ->setCellValue('F17', 'ESELON')
            ->setCellValue('G17', 'KET');

        $objPHPExcel->getActiveSheet()->setCellValue('A18', '1')
            ->setCellValue('B18', '2')
            ->setCellValue('C18', '3')
            ->setCellValue('D18', '4')
            ->setCellValue('E18', '5')
            ->setCellValue('F18', '6')
            ->setCellValue('G18', '7');

           $this->db->trans_begin();
            $sql = "
          SELECT
          draft_struktural.nip,
          draft_struktural.gelar_depan, draft_struktural.nama, draft_struktural.gelar_belakang,
          draft_struktural.tgl_lahir, draft_struktural.pangkat_gol, draft_struktural.pangkat,
          draft_struktural.jabatan_baru, draft_struktural.unit_baru, draft_struktural.eselon_baru,
          CASE WHEN draft_struktural.jabatan_lama IS NULL THEN
            CONCAT('Fungsional Umum pada ', draft_struktural.unit_lama)
          ELSE
            (CASE WHEN draft_struktural.eselon_lama IS NULL THEN CONCAT(draft_struktural.jabatan_lama,' pada ',draft_struktural.unit_lama)
            ELSE draft_struktural.jabatan_lama END)
          END AS jabatan_lama,
          draft_struktural.unit_lama, draft_struktural.eselon_lama FROM (SELECT
              jab_baru.id_draft, p.nip_baru AS nip,
                 p.gelar_depan,
                 p.nama,
                 p.gelar_belakang,
                 DATE_FORMAT(p.tgl_lahir,  '%d/%m/%Y') AS tgl_lahir,
                 p.pangkat_gol,
                 g.pangkat,
                 jab_baru.jabatan_baru,
                 jab_baru.unit_baru,
                 jab_baru.eselon_baru,
                 CASE WHEN p.jenjab = 'Fungsional' THEN p.jabatan ELSE CASE WHEN p.id_j IS NULL THEN
                (SELECT jm.nama_jfu AS jabatan
                 FROM jfu_pegawai jp, jfu_master jm
                 WHERE jp.kode_jabatan = jm.kode_jabatan AND jp.id_pegawai = p.id_pegawai LIMIT 1)
                ELSE j.jabatan END END AS jabatan_lama,
                 ukl.nama_baru AS unit_lama,
                 j.eselon AS eselon_lama
            FROM (SELECT
                     dpdl.id_draft,
                     dj_baru.idp_baru AS idpegawai,
                     dj_baru.idj_baru,
                     dpdl.id_j AS idj_lama,
                     j.jabatan AS jabatan_baru,
                     uk.nama_baru AS unit_baru,
                     j.eselon AS eselon_baru
                   FROM (SELECT
                            dpd.id_j AS idj_baru,
                            dpd.id_pegawai AS idp_baru
                          FROM draft_pelantikan_detail dpd
                          WHERE (dpd.id_pegawai <> dpd.id_pegawai_awal OR (dpd.id_pegawai IS NOT NULL AND dpd.id_pegawai_awal IS NULL))
                            AND dpd.id_draft = ".$iddraft.") AS dj_baru
                            LEFT JOIN draft_pelantikan_detail dpdl ON dj_baru.idp_baru = dpdl.id_pegawai_awal AND dpdl.id_draft = ".$iddraft.",
                            jabatan j,
                            unit_kerja uk
                   WHERE
                   dj_baru.idj_baru = j.id_j
                       AND j.id_unit_kerja = uk.id_unit_kerja) AS jab_baru
                       LEFT JOIN jabatan j ON j.id_j = jab_baru.idj_lama
                       /*LEFT JOIN unit_kerja ukl ON j.id_unit_kerja = ukl.id_unit_kerja,*/
                       INNER JOIN current_lokasi_kerja clk ON jab_baru.idpegawai = clk.id_pegawai
                       INNER JOIN unit_kerja ukl ON clk.id_unit_kerja = ukl.id_unit_kerja,
                 pegawai p,
                 golongan g
            WHERE p.id_pegawai = jab_baru.idpegawai
            AND p.pangkat_gol = g.golongan AND jab_baru.eselon_baru = '".$eselon."'
            ORDER BY jab_baru.unit_baru ASC) AS draft_struktural";

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
                $ket = ($data[$i]->eselon_baru == $data[$i]->eselon_lama ? 'Rotasi' : 'Promosi');
                $dataArray[$i] = array($i+1,$data[$i]->gelar_depan.' '.$data[$i]->nama.' '.$data[$i]->gelar_belakang."\r\n".$data[$i]->nip."\r\n".$data[$i]->tgl_lahir,
                $data[$i]->pangkat_gol."\r\n".$data[$i]->pangkat,
                $data[$i]->jabatan_lama,$data[$i]->jabatan_baru, $data[$i]->eselon_baru, $ket);
                $i++;
            }
        }

        //."\r\n".$data[$i]->unit_baru
        $rows = count($data);

        if($rows == 0){
            $message = 'Jumlah data draft pelantikan masih kosong';
            echo "<script type='text/javascript'>alert('$message');</script>";
            die();
        }

        $objPHPExcel->getActiveSheet()->getStyle('A19:A'.(19+$rows))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A19:A'.(19+$rows))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
        $objPHPExcel->getActiveSheet()->getStyle('B19:B'.(19+$rows))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
        $objPHPExcel->getActiveSheet()->getStyle('C19:C'.(19+$rows))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
        $objPHPExcel->getActiveSheet()->getStyle('D19:D'.(19+$rows))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
        $objPHPExcel->getActiveSheet()->getStyle('E19:E'.(19+$rows))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
        $objPHPExcel->getActiveSheet()->getStyle('F19:F'.(19+$rows))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('F19:F'.(19+$rows))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
        $objPHPExcel->getActiveSheet()->getStyle('G19:G'.(19+$rows))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);


        $styleArray = array(
            'borders' => array(
                'left' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                ),
                'right' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        );
        $objPHPExcel->getActiveSheet()->getStyle('A19:A'.(19+$rows-1))->applyFromArray($styleArray);
        $objPHPExcel->getActiveSheet()->getStyle('B19:B'.(19+$rows-1))->applyFromArray($styleArray);
        $objPHPExcel->getActiveSheet()->getStyle('C19:C'.(19+$rows-1))->applyFromArray($styleArray);
        $objPHPExcel->getActiveSheet()->getStyle('D19:D'.(19+$rows-1))->applyFromArray($styleArray);
        $objPHPExcel->getActiveSheet()->getStyle('E19:E'.(19+$rows-1))->applyFromArray($styleArray);
        $objPHPExcel->getActiveSheet()->getStyle('F19:F'.(19+$rows-1))->applyFromArray($styleArray);
        $objPHPExcel->getActiveSheet()->getStyle('G19:G'.(19+$rows-1))->applyFromArray($styleArray);
        unset($styleArray);

        $styleArray = array(
            'borders' => array(
                'top' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        );
        $objPHPExcel->getActiveSheet()->getStyle('A'.(19+$rows))->applyFromArray($styleArray);
        $objPHPExcel->getActiveSheet()->getStyle('B'.(19+$rows))->applyFromArray($styleArray);
        $objPHPExcel->getActiveSheet()->getStyle('C'.(19+$rows))->applyFromArray($styleArray);
        $objPHPExcel->getActiveSheet()->getStyle('D'.(19+$rows))->applyFromArray($styleArray);
        $objPHPExcel->getActiveSheet()->getStyle('E'.(19+$rows))->applyFromArray($styleArray);
        $objPHPExcel->getActiveSheet()->getStyle('F'.(19+$rows))->applyFromArray($styleArray);
        $objPHPExcel->getActiveSheet()->getStyle('G'.(19+$rows))->applyFromArray($styleArray);
        unset($styleArray);

        // Add some data
        $objPHPExcel->getActiveSheet()->fromArray($dataArray, NULL, 'A19');
        $dataArray = null;

        $objPHPExcel->getActiveSheet()->getStyle('A'.(19+$rows).':A'.$objPHPExcel->getActiveSheet()->getHighestRow())->getAlignment()->setWrapText(false);
        $objPHPExcel->getActiveSheet()->getStyle('A'.(19+$rows))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $objPHPExcel->getActiveSheet()->getStyle('B'.(19+$rows).':B'.(19+$rows+20))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('B'.(19+$rows).':B'.(19+$rows+20))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
        $objPHPExcel->getActiveSheet()->getStyle('B'.(19+$rows).':D'.(19+$rows+20))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('B'.(19+$rows).':D'.(19+$rows+20))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
        $objPHPExcel->getActiveSheet()->getStyle('B'.(19+$rows).':E'.(19+$rows+20))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('B'.(19+$rows).':E'.(19+$rows+20))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);

        $styleArray_UL = array(
            'font' => array(
                'underline' => PHPExcel_Style_Font::UNDERLINE_SINGLE
            )
        );

        $objPHPExcel->getActiveSheet()->setCellValue('A'.(19+$rows), 'Demikian Hasil Rapat Badan Pertimbangan Jabatan dan Kepangkatan Pemerintah Kota Bogor telah ditutup dan ditanda tangani oleh Ketua, Sekretaris dan Anggota pada');
        $objPHPExcel->getActiveSheet()->setCellValue('A'.(19+$rows+1), 'dan tanggal tersebut diatas pukul '.$dataPengesahan->wkt_pengesahan.' WIB. di '.$dataPengesahan->ruang_pengesahan);
        $objPHPExcel->getActiveSheet()->setCellValue('B'.(19+$rows+3), 'Ketua,');
        $objPHPExcel->getActiveSheet()->setCellValue('B'.(19+$rows+4), $dataDetailBaperjakat[0]->jabatan);
        $objPHPExcel->getActiveSheet()->setCellValue('B'.(19+$rows+7), $dataDetailBaperjakat[0]->nama);
        $objPHPExcel->getActiveSheet()->setCellValue('B'.(19+$rows+8), "'".$dataDetailBaperjakat[0]->nip_baru);
        $objPHPExcel->getActiveSheet()->getStyle('B'.(19+$rows+7))->applyFromArray($styleArray_UL);

        $objPHPExcel->getActiveSheet()->setCellValue('B'.(19+$rows+10), '1. '.$dataDetailBaperjakat[2]->jabatan);
        $objPHPExcel->getActiveSheet()->setCellValue('B'.(19+$rows+13), $dataDetailBaperjakat[2]->nama);
        $objPHPExcel->getActiveSheet()->setCellValue('B'.(19+$rows+14), "'".$dataDetailBaperjakat[2]->nip_baru);
        $objPHPExcel->getActiveSheet()->getStyle('B'.(19+$rows+13))->applyFromArray($styleArray_UL);

        $objPHPExcel->getActiveSheet()->setCellValue('B'.(19+$rows+16), '2. '.$dataDetailBaperjakat[3]->jabatan);
        $objPHPExcel->getActiveSheet()->setCellValue('B'.(19+$rows+19), $dataDetailBaperjakat[3]->nama);
        $objPHPExcel->getActiveSheet()->setCellValue('B'.(19+$rows+20), "'".$dataDetailBaperjakat[3]->nip_baru);
        $objPHPExcel->getActiveSheet()->getStyle('B'.(19+$rows+19))->applyFromArray($styleArray_UL);

        $objPHPExcel->getActiveSheet()->setCellValue('D'.(19+$rows+9), 'ANGGOTA,');
        $objPHPExcel->getActiveSheet()->getStyle('D'.(19+$rows+9))->getFont()->setBold(true);

        $objPHPExcel->getActiveSheet()->setCellValue('D'.(19+$rows+10), '5. '.$dataDetailBaperjakat[6]->jabatan);
        $objPHPExcel->getActiveSheet()->setCellValue('D'.(19+$rows+13), $dataDetailBaperjakat[6]->nama);
        $objPHPExcel->getActiveSheet()->setCellValue('D'.(19+$rows+14), "'".$dataDetailBaperjakat[6]->nip_baru);
        $objPHPExcel->getActiveSheet()->getStyle('D'.(19+$rows+13))->applyFromArray($styleArray_UL);

        $objPHPExcel->getActiveSheet()->setCellValue('E'.(19+$rows+3), 'Sekretaris,');
        $objPHPExcel->getActiveSheet()->setCellValue('E'.(19+$rows+4), $dataDetailBaperjakat[1]->jabatan);
        $objPHPExcel->getActiveSheet()->setCellValue('E'.(19+$rows+7), $dataDetailBaperjakat[1]->nama);
        $objPHPExcel->getActiveSheet()->setCellValue('E'.(19+$rows+8), "'".$dataDetailBaperjakat[1]->nip_baru);
        $objPHPExcel->getActiveSheet()->getStyle('E'.(19+$rows+7))->applyFromArray($styleArray_UL);

        $objPHPExcel->getActiveSheet()->setCellValue('E'.(19+$rows+10), '3. '.$dataDetailBaperjakat[4]->jabatan);
        $objPHPExcel->getActiveSheet()->setCellValue('E'.(19+$rows+13), $dataDetailBaperjakat[4]->nama);
        $objPHPExcel->getActiveSheet()->setCellValue('E'.(19+$rows+14), "'".$dataDetailBaperjakat[4]->nip_baru);
        $objPHPExcel->getActiveSheet()->getStyle('E'.(19+$rows+13))->applyFromArray($styleArray_UL);

        $objPHPExcel->getActiveSheet()->setCellValue('E'.(19+$rows+16), '4. '.$dataDetailBaperjakat[5]->jabatan);
        $objPHPExcel->getActiveSheet()->setCellValue('E'.(19+$rows+19), $dataDetailBaperjakat[5]->nama);
        $objPHPExcel->getActiveSheet()->setCellValue('E'.(19+$rows+20), "'".$dataDetailBaperjakat[5]->nip_baru);
        $objPHPExcel->getActiveSheet()->getStyle('E'.(19+$rows+19))->applyFromArray($styleArray_UL);

        unset($styleArray_UL);
        // Rename worksheet (worksheet, not filename)
        $objPHPExcel->getActiveSheet()->setTitle('Data');
        // Set title row bold
        $objPHPExcel->getActiveSheet()->getStyle('A1:G1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('A2:G2')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('A17:G17')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('A18:G18')->getFont()->setBold(true);
        // Set autofilter
        //$objPHPExcel->getActiveSheet()->setAutoFilter($objPHPExcel->getActiveSheet()->calculateWorksheetDimension());
        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $objPHPExcel->setActiveSheetIndex(0);

        // Redirect output to a client’s web browser (Excel2007)
        //clean the output buffer
        ob_end_clean();

        //this is the header given from PHPExcel examples. but the output seems somewhat corrupted in some cases.
        //header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        //so, we use this header instead.
        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="draft_pelantikan_pejabat.xlsx"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
    }
}