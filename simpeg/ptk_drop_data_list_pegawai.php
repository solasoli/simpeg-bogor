<div class="row" style="margin: 10px;">
<?php

include "konek.php";
include "paginator.class.php";
$pages = new Paginator;
$pagePaging = $_POST['page'];
if($pagePaging==0 or $pagePaging==""){
    $pagePaging = 1;
}
$ipp = $pages->items_per_page;
$idskpd = $_POST['idskpd'];
$txtKeyword = $_POST['txtKeyword'];
$eselon = $_POST['eselon'];
$stsVerif = $_POST['stsVerif'];

$whereKlause1 = "WHERE a.id_pegawai IS NOT NULL";
$whereKlause2 = "";
if($eselon!='0'){
    $whereKlause1 .= " AND a.eselon = '".$eselon."'";
}
if($stsVerif!='0'){
    $whereKlause2 = " WHERE d.status_verifikasi = '".$stsVerif."' ";
}
if (!(trim($txtKeyword)== "") && !(trim($txtKeyword)== "0")){
    $whereKlause1 .= " AND (a.nip_baru LIKE '%".$txtKeyword."%'
                                        OR a.nama_pegawai LIKE '%".$txtKeyword."%'
                                        OR a.jabatan LIKE '%".$txtKeyword."%')";
}
$sqlCountAll = "SELECT COUNT(e.id_pegawai) AS jumlah FROM
            (SELECT d.*, COUNT(pm.id_ptk) AS jml_ptk FROM
            (SELECT c.id_pegawai, c.nip_baru, c.nama_pegawai, c.pangkat_gol, c.jabatan, c.eselon,
            SUM(IF(c.id_status = 9,1,0)) as jml_pasangan, SUM(IF(c.id_status = 10,1,0)) as jml_anak,
            SUM(IF((c.id_status <> 9 AND c.id_status <> 10),1,0)) as jml_lainnya,
            COUNT(c.id_keluarga) AS jml_keluarga,
            SUM(IF(c.status_validasi = 'Valid',1,0)) as jml_valid,
            SUM(IF(c.status_validasi = 'Belum Valid / Tunjangan di Pasangan',1,0)) as jml_non_valid,
            SUM(IF(c.id_status = 9 AND c.status_validasi = 'Valid' AND c.status_tunjangan_skum = 'Dapat',1,0)) as pasangan_valid_dapat,
            SUM(IF(c.id_status = 10 AND c.status_validasi = 'Valid' AND c.status_tunjangan_skum = 'Dapat',1,0)) as anak_valid_dapat,
            CASE WHEN SUM(IF(c.status_validasi = 'Belum Valid / Tunjangan di Pasangan',1,0)) = 0 THEN
            1 ELSE (CASE WHEN
              (SUM(IF(c.id_status = 9 AND c.status_validasi = 'Valid' AND c.status_tunjangan_skum = 'Dapat',1,0)) +
              SUM(IF(c.id_status = 10 AND c.status_validasi = 'Valid' AND c.status_tunjangan_skum = 'Dapat',1,0))) = 3
              THEN 1 ELSE (CASE WHEN
                (SUM(IF(c.id_status = 9 AND c.status_validasi = 'Valid' AND c.status_tunjangan_skum = 'Dapat',1,0)) +
                SUM(IF(c.id_status = 10 AND c.status_validasi = 'Valid' AND c.status_tunjangan_skum = 'Dapat',1,0))) = 0
              THEN 2 ELSE (CASE WHEN
              (SUM(IF(c.id_status = 9 AND c.status_validasi = 'Valid' AND c.status_tunjangan_skum = 'Dapat',1,0)) <= 1 AND
              SUM(IF(c.id_status = 10 AND c.status_validasi = 'Valid' AND c.status_tunjangan_skum = 'Dapat',1,0)) <= 2 AND
              SUM(IF(c.id_status = 10,1,0)) > 2)
              THEN 1 ELSE 3 END)END)
              END)
            END as status_verifikasi
            FROM (SELECT b.*,
              CASE WHEN b.status_tunjangan_skum = 'Dapat' AND (b.id_status_verifikasi = 1 OR b.id_status_verifikasi = 4
              OR b.id_status_verifikasi = 5) THEN 'Valid' ELSE
              (CASE WHEN b.status_tunjangan_skum = 'Tidak Dapat' AND (b.id_status_verifikasi = 2 OR b.id_status_verifikasi = 3
              OR b.id_status_verifikasi = 6 OR b.id_status_verifikasi = 7 OR b.id_status_verifikasi = 8 OR b.id_status_verifikasi = 9
              OR b.id_status_verifikasi = 10 OR b.id_status_verifikasi = 11)
              THEN 'Valid' ELSE 'Belum Valid / Tunjangan di Pasangan' END)
              END AS status_validasi
              FROM
            (SELECT a.id_pegawai, a.nip_baru, a.nama_pegawai, a.pangkat_gol, a.jabatan, a.eselon,
            a.id_keluarga, a.id_status, a.status_keluarga, a.nama, a.tempat_lahir, a.tgl_lahir, a.pekerjaan,
            CASE WHEN a.jk = 1 THEN 'Laki-laki' ELSE 'Perempuan' END AS jenis_kelamin,
            CASE WHEN a.dapat_tunjangan = 0 THEN 'Tidak Dapat' ELSE 'Dapat' END AS status_tunjangan_skum, a.usia,
            CASE WHEN a.id_status = 9 THEN
            (CASE WHEN a.tgl_meninggal IS NOT NULL THEN 'Meninggal (Tidak Dapat)' ELSE
              (CASE WHEN a.tgl_cerai IS NOT NULL THEN 'Cerai (Tidak Dapat)' ELSE
                (CASE WHEN a.tgl_menikah IS NOT NULL THEN 'Menikah (Dapat)' ELSE 'Tgl. Menikah Blm Diisi' END) END) END)
            ELSE
            (CASE WHEN a.tgl_meninggal IS NOT NULL THEN 'Meninggal (Tidak Dapat)' ELSE
              (CASE WHEN a.id_status = 10 THEN
                  (CASE WHEN a.usia < 21 THEN (CASE WHEN a.tgl_menikah IS NOT NULL THEN 'Anak < 21 Thn Menikah (Tidak Dapat)' ELSE
            (CASE WHEN a.sudah_bekerja = 1 THEN 'Anak < 21 Thn Bekerja (Tidak Dapat)' ELSE 'Anak < 21 Thn (Dapat)' END) END) ELSE
                (CASE WHEN (a.usia >= 21 AND a.usia < 25) THEN
                  (CASE WHEN a.kuliah = 1 THEN (CASE WHEN a.tgl_lulus IS NULL THEN 'Anak kuliah (Dapat)' ELSE 'Anak lulus kuliah (Tidak Dapat)' END) ELSE
                    'Anak tidak kuliah (Tidak Dapat)' END) ELSE 'Anak > 25 Thn (Tidak Dapat)' END) END)
              ELSE 'Bukan Cakupan'END)
             END)END AS status_verifikasi_data,
            CASE WHEN a.id_status = 9 THEN
            (CASE WHEN a.tgl_meninggal IS NOT NULL THEN DATE_FORMAT(a.tgl_meninggal, '%d/%m/%Y') ELSE
              (CASE WHEN a.tgl_cerai IS NOT NULL THEN DATE_FORMAT(a.tgl_cerai, '%d/%m/%Y') ELSE
                (CASE WHEN a.tgl_menikah IS NOT NULL THEN DATE_FORMAT(a.tgl_menikah, '%d/%m/%Y') ELSE NULL END) END) END)
            ELSE
            (CASE WHEN a.tgl_meninggal IS NOT NULL THEN DATE_FORMAT(a.tgl_meninggal, '%d/%m/%Y') ELSE
              (CASE WHEN a.usia < 21 THEN (CASE WHEN a.tgl_menikah IS NOT NULL THEN a.tgl_menikah ELSE
            (CASE WHEN a.sudah_bekerja = 1 THEN NULL ELSE NULL END) END) ELSE
                (CASE WHEN (a.usia >= 21 AND a.usia < 25) THEN
                  (CASE WHEN a.kuliah = 1 THEN (CASE WHEN a.tgl_lulus IS NULL THEN NULL ELSE DATE_FORMAT(a.tgl_lulus, '%d/%m/%Y') END) ELSE
                    NULL END) ELSE NULL END) END) END)
            END AS ref_tanggal,
            CASE WHEN a.id_status = 9 THEN
            (CASE WHEN a.tgl_meninggal IS NOT NULL THEN a.akte_meninggal ELSE
              (CASE WHEN a.tgl_cerai IS NOT NULL THEN a.akte_cerai ELSE
                (CASE WHEN a.tgl_menikah IS NOT NULL THEN a.akte_menikah ELSE NULL END) END) END)
            ELSE
            (CASE WHEN a.tgl_meninggal IS NOT NULL THEN a.akte_meninggal ELSE
              (CASE WHEN a.usia < 21 THEN (CASE WHEN a.tgl_menikah IS NOT NULL THEN a.akte_menikah ELSE
            (CASE WHEN a.sudah_bekerja = 1 THEN a.akte_kerja ELSE NULL END) END) ELSE
                (CASE WHEN (a.usia >= 21 AND a.usia < 25) THEN
                  (CASE WHEN a.kuliah = 1 THEN (CASE WHEN a.tgl_lulus IS NULL THEN NULL ELSE NULL END) ELSE
                    NULL END) ELSE NULL END) END) END)
            END AS ref_keterangan,
            CASE WHEN a.id_status = 9 THEN
            (CASE WHEN a.tgl_meninggal IS NOT NULL THEN 2 ELSE
              (CASE WHEN a.tgl_cerai IS NOT NULL THEN 3 ELSE
                (CASE WHEN a.tgl_menikah IS NOT NULL THEN 1 ELSE 0 END) END) END)
            ELSE
            (CASE WHEN a.tgl_meninggal IS NOT NULL THEN 6 ELSE
              (CASE WHEN a.usia < 21 THEN (CASE WHEN a.tgl_menikah IS NOT NULL THEN 10 ELSE
            (CASE WHEN a.sudah_bekerja = 1 THEN 11 ELSE 4 END) END) ELSE
                (CASE WHEN (a.usia >= 21 AND a.usia < 25) THEN
                  (CASE WHEN a.kuliah = 1 THEN (CASE WHEN a.tgl_lulus IS NULL THEN 5 ELSE 7 END) ELSE
                    8 END) ELSE 9 END) END) END)
            END AS id_status_verifikasi
            FROM
            (SELECT p.id_pegawai, p.nip_baru, p.nama as nama_pegawai, p.pangkat_gol,
            CASE WHEN p.jenjab = 'Fungsional' THEN p.jabatan ELSE CASE WHEN p.id_j IS NULL THEN
            (SELECT jm.nama_jfu AS jabatan
             FROM jfu_pegawai jp, jfu_master jm
             WHERE jp.kode_jabatan = jm.kode_jabatan AND jp.id_pegawai = p.id_pegawai LIMIT 1)
            ELSE j.jabatan END END AS jabatan, CASE WHEN j.eselon IS NULL THEN 'Z' ELSE j.eselon END AS eselon,
            k.id_keluarga, k.id_status, sk.status_keluarga, k.nama, k.tempat_lahir, k.tgl_lahir, k.pekerjaan, k.jk, k.dapat_tunjangan,
            ROUND(DATEDIFF(CURRENT_DATE, DATE_FORMAT(k.tgl_lahir, '%Y/%m/%d'))/365,2) AS usia,
            k.tgl_menikah, k.akte_menikah, k.tgl_meninggal, k.akte_meninggal, k.tgl_cerai, k.akte_cerai,
            k.kuliah, k.tgl_lulus, k.sudah_bekerja, k.akte_kerja 
            FROM pegawai p LEFT JOIN keluarga k ON p.id_pegawai = k.id_pegawai
            LEFT JOIN jabatan j ON p.id_j = j.id_j, status_kel sk, current_lokasi_kerja clk, unit_kerja uk
            WHERE k.id_status = sk.id_status AND p.id_pegawai = clk.id_pegawai AND clk.id_unit_kerja = uk.id_unit_kerja
            AND uk.id_skpd = $idskpd AND p.flag_pensiun = 0) a ".$whereKlause1.") b
            INNER JOIN keluarga k ON b.id_keluarga = k.id_keluarga
            ORDER BY b.id_status, b.tgl_lahir, b.nama) c
            GROUP BY c.id_pegawai, c.nip_baru, c.nama_pegawai
            ORDER BY c.eselon, c.pangkat_gol DESC, c.nama_pegawai ASC) d
            LEFT JOIN ptk_master pm ON d.id_pegawai = pm.id_pegawai_pemohon ".$whereKlause2."
            GROUP BY d.id_pegawai ORDER BY d.eselon, d.pangkat_gol DESC, d.nama_pegawai ASC) e";

    $query = $mysqli->query($sqlCountAll);
    if ($query->num_rows > 0) {
        while ($data = $query->fetch_array(MYSQLI_NUM)) {
            $jmlData = $data[0];
        }
    }

    if ($jmlData > 0) {
        $pages->items_total = $jmlData;
        $pages->paginate();
        $pgDisplay = $pages->display_pages();
        $itemPerPage = $pages->display_items_per_page();
        $curpage = $pages->current_page;
        $numpage = $pages->num_pages;
        $jumppage = $pages->display_jump_menu();
        $rowperpage = $pages->display_items_per_page();
    }else{
        $pgDisplay = '';
        $itemPerPage = '';
        $curpage = '';
        $numpage = '';
        $jumppage = '';
        $rowperpage = '';
    }
    if($pagePaging == 1){
        $start_number = 0;
    }else{
        $start_number = ($pagePaging * $ipp) - $ipp;
    }
    $sqlData = "SELECT d.*, COUNT(pm.id_ptk) AS jml_ptk FROM
                (SELECT c.id_pegawai, c.nip_baru, c.nama_pegawai, c.pangkat_gol, c.jabatan, c.eselon,
                SUM(IF(c.id_status = 9,1,0)) as jml_pasangan, SUM(IF(c.id_status = 10,1,0)) as jml_anak,
                SUM(IF((c.id_status <> 9 AND c.id_status <> 10),1,0)) as jml_lainnya,
                COUNT(c.id_keluarga) AS jml_keluarga,
                SUM(IF(c.status_validasi = 'Valid',1,0)) as jml_valid,
                SUM(IF(c.status_validasi = 'Belum Valid / Tunjangan di Pasangan',1,0)) as jml_non_valid,
                SUM(IF(c.id_status = 9 AND c.status_validasi = 'Valid' AND c.status_tunjangan_skum = 'Dapat',1,0)) as pasangan_valid_dapat,
                SUM(IF(c.id_status = 10 AND c.status_validasi = 'Valid' AND c.status_tunjangan_skum = 'Dapat',1,0)) as anak_valid_dapat,
                CASE WHEN SUM(IF(c.status_validasi = 'Belum Valid / Tunjangan di Pasangan',1,0)) = 0 THEN
                1 ELSE (CASE WHEN
                  (SUM(IF(c.id_status = 9 AND c.status_validasi = 'Valid' AND c.status_tunjangan_skum = 'Dapat',1,0)) +
                  SUM(IF(c.id_status = 10 AND c.status_validasi = 'Valid' AND c.status_tunjangan_skum = 'Dapat',1,0))) = 3
                  THEN 1 ELSE (CASE WHEN
                    (SUM(IF(c.id_status = 9 AND c.status_validasi = 'Valid' AND c.status_tunjangan_skum = 'Dapat',1,0)) +
                    SUM(IF(c.id_status = 10 AND c.status_validasi = 'Valid' AND c.status_tunjangan_skum = 'Dapat',1,0))) = 0
                  THEN 2 ELSE (CASE WHEN
                  (SUM(IF(c.id_status = 9 AND c.status_validasi = 'Valid' AND c.status_tunjangan_skum = 'Dapat',1,0)) <= 1 AND
                  SUM(IF(c.id_status = 10 AND c.status_validasi = 'Valid' AND c.status_tunjangan_skum = 'Dapat',1,0)) <= 2 AND
                  SUM(IF(c.id_status = 10,1,0)) > 2)
                  THEN 1 ELSE 3 END)END)
                  END)
                END as status_verifikasi
                FROM (SELECT b.*,
                  CASE WHEN b.status_tunjangan_skum = 'Dapat' AND (b.id_status_verifikasi = 1 OR b.id_status_verifikasi = 4
                  OR b.id_status_verifikasi = 5) THEN 'Valid' ELSE
                  (CASE WHEN b.status_tunjangan_skum = 'Tidak Dapat' AND (b.id_status_verifikasi = 2 OR b.id_status_verifikasi = 3
                  OR b.id_status_verifikasi = 6 OR b.id_status_verifikasi = 7 OR b.id_status_verifikasi = 8 OR b.id_status_verifikasi = 9
                  OR b.id_status_verifikasi = 10 OR b.id_status_verifikasi = 11)
                  THEN 'Valid' ELSE 'Belum Valid / Tunjangan di Pasangan' END)
                  END AS status_validasi
                  FROM
                (SELECT a.id_pegawai, a.nip_baru, a.nama_pegawai, a.pangkat_gol, a.jabatan, a.eselon,
                a.id_keluarga, a.id_status, a.status_keluarga, a.nama, a.tempat_lahir, a.tgl_lahir, a.pekerjaan,
                CASE WHEN a.jk = 1 THEN 'Laki-laki' ELSE 'Perempuan' END AS jenis_kelamin,
                CASE WHEN a.dapat_tunjangan = 0 THEN 'Tidak Dapat' ELSE 'Dapat' END AS status_tunjangan_skum, a.usia,
                CASE WHEN a.id_status = 9 THEN
                (CASE WHEN a.tgl_meninggal IS NOT NULL THEN 'Meninggal (Tidak Dapat)' ELSE
                  (CASE WHEN a.tgl_cerai IS NOT NULL THEN 'Cerai (Tidak Dapat)' ELSE
                    (CASE WHEN a.tgl_menikah IS NOT NULL THEN 'Menikah (Dapat)' ELSE 'Tgl. Menikah Blm Diisi' END) END) END)
                ELSE
                (CASE WHEN a.tgl_meninggal IS NOT NULL THEN 'Meninggal (Tidak Dapat)' ELSE
                  (CASE WHEN a.id_status = 10 THEN
                      (CASE WHEN a.usia < 21 THEN (CASE WHEN a.tgl_menikah IS NOT NULL THEN 'Anak < 21 Thn Menikah (Tidak Dapat)' ELSE
                (CASE WHEN a.sudah_bekerja = 1 THEN 'Anak < 21 Thn Bekerja (Tidak Dapat)' ELSE 'Anak < 21 Thn (Dapat)' END) END) ELSE
                    (CASE WHEN (a.usia >= 21 AND a.usia < 25) THEN
                      (CASE WHEN a.kuliah = 1 THEN (CASE WHEN a.tgl_lulus IS NULL THEN 'Anak kuliah (Dapat)' ELSE 'Anak lulus kuliah (Tidak Dapat)' END) ELSE
                        'Anak tidak kuliah (Tidak Dapat)' END) ELSE 'Anak > 25 Thn (Tidak Dapat)' END) END)
                  ELSE 'Bukan Cakupan'END)
                 END)END AS status_verifikasi_data,
                CASE WHEN a.id_status = 9 THEN
                (CASE WHEN a.tgl_meninggal IS NOT NULL THEN DATE_FORMAT(a.tgl_meninggal, '%d/%m/%Y') ELSE
                  (CASE WHEN a.tgl_cerai IS NOT NULL THEN DATE_FORMAT(a.tgl_cerai, '%d/%m/%Y') ELSE
                    (CASE WHEN a.tgl_menikah IS NOT NULL THEN DATE_FORMAT(a.tgl_menikah, '%d/%m/%Y') ELSE NULL END) END) END)
                ELSE
                (CASE WHEN a.tgl_meninggal IS NOT NULL THEN DATE_FORMAT(a.tgl_meninggal, '%d/%m/%Y') ELSE
                  (CASE WHEN a.usia < 21 THEN (CASE WHEN a.tgl_menikah IS NOT NULL THEN a.tgl_menikah ELSE
                (CASE WHEN a.sudah_bekerja = 1 THEN NULL ELSE NULL END) END) ELSE
                    (CASE WHEN (a.usia >= 21 AND a.usia < 25) THEN
                      (CASE WHEN a.kuliah = 1 THEN (CASE WHEN a.tgl_lulus IS NULL THEN NULL ELSE DATE_FORMAT(a.tgl_lulus, '%d/%m/%Y') END) ELSE
                        NULL END) ELSE NULL END) END) END)
                END AS ref_tanggal,
                CASE WHEN a.id_status = 9 THEN
                (CASE WHEN a.tgl_meninggal IS NOT NULL THEN a.akte_meninggal ELSE
                  (CASE WHEN a.tgl_cerai IS NOT NULL THEN a.akte_cerai ELSE
                    (CASE WHEN a.tgl_menikah IS NOT NULL THEN a.akte_menikah ELSE NULL END) END) END)
                ELSE
                (CASE WHEN a.tgl_meninggal IS NOT NULL THEN a.akte_meninggal ELSE
                  (CASE WHEN a.usia < 21 THEN (CASE WHEN a.tgl_menikah IS NOT NULL THEN a.akte_menikah ELSE
                (CASE WHEN a.sudah_bekerja = 1 THEN a.akte_kerja ELSE NULL END) END) ELSE
                    (CASE WHEN (a.usia >= 21 AND a.usia < 25) THEN
                      (CASE WHEN a.kuliah = 1 THEN (CASE WHEN a.tgl_lulus IS NULL THEN NULL ELSE NULL END) ELSE
                        NULL END) ELSE NULL END) END) END)
                END AS ref_keterangan,
                CASE WHEN a.id_status = 9 THEN
                (CASE WHEN a.tgl_meninggal IS NOT NULL THEN 2 ELSE
                  (CASE WHEN a.tgl_cerai IS NOT NULL THEN 3 ELSE
                    (CASE WHEN a.tgl_menikah IS NOT NULL THEN 1 ELSE 0 END) END) END)
                ELSE
                (CASE WHEN a.tgl_meninggal IS NOT NULL THEN 6 ELSE
                  (CASE WHEN a.usia < 21 THEN (CASE WHEN a.tgl_menikah IS NOT NULL THEN 10 ELSE
                (CASE WHEN a.sudah_bekerja = 1 THEN 11 ELSE 4 END) END) ELSE
                    (CASE WHEN (a.usia >= 21 AND a.usia < 25) THEN
                      (CASE WHEN a.kuliah = 1 THEN (CASE WHEN a.tgl_lulus IS NULL THEN 5 ELSE 7 END) ELSE
                        8 END) ELSE 9 END) END) END)
                END AS id_status_verifikasi
                FROM
                (SELECT p.id_pegawai, p.nip_baru, p.nama as nama_pegawai, p.pangkat_gol,
                CASE WHEN p.jenjab = 'Fungsional' THEN p.jabatan ELSE CASE WHEN p.id_j IS NULL THEN
                (SELECT jm.nama_jfu AS jabatan
                 FROM jfu_pegawai jp, jfu_master jm
                 WHERE jp.kode_jabatan = jm.kode_jabatan AND jp.id_pegawai = p.id_pegawai LIMIT 1)
                ELSE j.jabatan END END AS jabatan, CASE WHEN j.eselon IS NULL THEN 'Z' ELSE j.eselon END AS eselon,
                k.id_keluarga, k.id_status, sk.status_keluarga, k.nama, k.tempat_lahir, k.tgl_lahir, k.pekerjaan, k.jk, k.dapat_tunjangan,
                ROUND(DATEDIFF(CURRENT_DATE, DATE_FORMAT(k.tgl_lahir, '%Y/%m/%d'))/365,2) AS usia,
                k.tgl_menikah, k.akte_menikah, k.tgl_meninggal, k.akte_meninggal, k.tgl_cerai, k.akte_cerai,
                k.kuliah, k.tgl_lulus, k.sudah_bekerja, k.akte_kerja
                FROM pegawai p LEFT JOIN keluarga k ON p.id_pegawai = k.id_pegawai
                LEFT JOIN jabatan j ON p.id_j = j.id_j, status_kel sk, current_lokasi_kerja clk, unit_kerja uk
                WHERE k.id_status = sk.id_status AND p.id_pegawai = clk.id_pegawai AND clk.id_unit_kerja = uk.id_unit_kerja
                AND uk.id_skpd = $idskpd AND p.flag_pensiun = 0) a ".$whereKlause1.") b
                INNER JOIN keluarga k ON b.id_keluarga = k.id_keluarga
                ORDER BY b.id_status, b.tgl_lahir, b.nama) c
                GROUP BY c.id_pegawai, c.nip_baru, c.nama_pegawai
                ORDER BY c.eselon, c.pangkat_gol DESC, c.nama_pegawai ASC) d
                LEFT JOIN ptk_master pm ON d.id_pegawai = pm.id_pegawai_pemohon ".$whereKlause2."
                GROUP BY d.id_pegawai ORDER BY d.eselon, d.pangkat_gol DESC, d.nama_pegawai ASC ".$pages->limit;

    $query = $mysqli->query($sqlData);

    if ($query->num_rows > 0) {
        if ($numpage > 0) {
            echo "Halaman ke $curpage dari $numpage | Jumlah Data : $jmlData | $jumppage | $rowperpage<br>";
            echo $pgDisplay;
        }
        $i = 0;
?>

        <table id="list_pegawai" cellspacing="0" width="100%" class="table table-striped" style="margin-top: 10px;">
            <thead>
            <tr style='border-bottom: solid 2px #2cc256;border-top: solid 2px #000000;'>
                <td>No</td>
                <td style="text-align: center;">NIP</td>
                <td>Nama</td>
                <td>Gol</td>
                <td>Eselon</td>
                <td style="text-align: center;">Jabatan</td>
                <td>Jml Keluarga</td>
                <td>Sesuai</td>
                <td>Anomali</td>
            </tr>
            </thead>
            <tbody>
            <?php
            while ($oto = $query->fetch_array(MYSQLI_NUM)) {
                $i++;
                echo "<tr>";
                echo "<td>".((int)$start_number+$i)."</td><td><strong>$oto[1]</strong><br>
                        <a href='index3.php?x=ptk.php&od=$oto[0]' class='btn btn-success btn-xs' style='width: 100%;margin-bottom: 3px;' target='_blank'>Pengubahan Tunjangan <span class=\"badge\">$oto[15]</span></a><br>
                        <a href='index3.php?x=box.php&od=$oto[0]' class='btn btn-primary btn-xs' style='width: 100%;' target='_blank'>Ubah Data Keluarga</a>
                        </td><td>$oto[2]<input id=\"txtNama$oto[0]\" name=\"txtNama$oto[0]\" type=\"hidden\" value=\"$oto[2]\" /></td><td>$oto[3]</td><td>".($oto[5]=='Z'?'':$oto[5])."</td><td>$oto[4]</td>
                        <td><a href=\"javascript:void(0);\" onclick=\"viewKeluarga($oto[0]);\" style=\"text-decoration: none\" >
                        <strong>$oto[9]</strong> (Istri/Suami: $oto[6], Anak: $oto[7], Lainnya: $oto[8])</a></td>
                        <td>$oto[10]</td><td>$oto[11]&nbsp;".
                    ($oto[14]==1?'<span class="label label-success">&nbsp;&nbsp;&nbsp;</span>':
                        ($oto[14]==2?'<span class="label label-warning">&nbsp;&nbsp;&nbsp;</span>':
                            ($oto[14]==3?'<span class="label label-danger">&nbsp;&nbsp;&nbsp;</span>':'')));
                echo "</td></tr>";
            }
            ?>
            </tbody>
        </table>
        <div class="modal fade" id="modalKeluarga" role="dialog">
            <div class="modal-dialog modal-lg" style="max-height: 350px;">
                <div class="modal-content">
                    <div class="modal-header" style="border-bottom: 2px solid darkolivegreen;">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 id="jdlTabel" class="modal-title" style="border: 0px;">Daftar Keluarga Pegawai</h4>
                    </div>
                    <div class="modal-body" style="height: 350px; width: 100%; overflow-y: scroll;">
                        <div id="winInfoKeluarga" style="margin-top: -10px;"></div>
                    </div>
                    <div class="modal-footer">
                        <button id="btnClose" type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

<?php
        if($numpage > 0){
            echo "Halaman ke $curpage dari $numpage | Jumlah Data : $jmlData | $jumppage | $rowperpage<br>";
            echo $pgDisplay;
        }
    }else{
        echo '<div style="padding: 10px;">Tidak ada data</div>';
    }
?>
</div>

<script>
    function viewKeluarga(idp){
        $("#winInfoKeluarga").html("Loading...");
        var nama = $("#txtNama" + idp).val();
        $("#jdlTabel").html('Daftar Keluarga Pegawai a.n. '+nama);
        var request = $.get("info_keluarga_pegawai.php?idp="+idp);
        request.pipe(
            function( response ){
                if (response.success){
                    return( response );
                }else{
                    return(
                        $.Deferred().reject( response )
                    );
                }
            },
            function( response ){
                return({
                    success: false,
                    data: null,
                    errors: [ "Unexpected error: " + response.status + " " + response.statusText ]
                });
            }
        );
        request.then(
            function( response ){
                $("#winInfoKeluarga").html(response);
            }
        );
        $("#modalKeluarga").modal('show');
    }
</script>