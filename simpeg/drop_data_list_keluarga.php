
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
    $stsSkum = $_POST['stsSkum'];
    $stsValidasi = $_POST['stsValidasi'];
    $stskeluarga = $_POST['stskeluarga'];
    $operator = $_POST['operator'];
    $umur = $_POST['umur'];

    $whereKlause1 = "";
    $whereKlause2 = "";
    $whereKlause3 = "";
    $andKlausa = "";
    if($stsSkum!='0'){
        $whereKlause1 = " WHERE b.status_tunjangan_skum = '".$stsSkum."'";
    }
    if($stsValidasi!='0'){
        $whereKlause2 = " WHERE family.status_validasi = '".$stsValidasi."'";
    }
    if($stskeluarga!='0'){
        $andKlausa .= " AND k.id_status = ".$stskeluarga;
    }
    if (!(trim($txtKeyword)== "") && !(trim($txtKeyword)== "0")){
        $andKlausa .= " AND (p.nip_baru LIKE '%".$txtKeyword."%'
                                    OR p.nama LIKE '%".$txtKeyword."%'
                                    OR k.nama LIKE '%".$txtKeyword."%')";
    }
    if($operator!='0' and $umur!=0 and $umur!=''){
        if(is_numeric($umur)){
            $whereKlause3 = " WHERE a.usia".$operator.$umur;
        }
    }
    $sqlCountAll = "SELECT COUNT(family.id_pegawai) AS jumlah
        FROM (SELECT b.*,
          CASE WHEN b.status_tunjangan_skum = 'Dapat' AND (b.id_status_verifikasi = 1 OR b.id_status_verifikasi = 4
          OR b.id_status_verifikasi = 5) THEN 'Valid' ELSE
          (CASE WHEN b.status_tunjangan_skum = 'Tidak Dapat' AND (b.id_status_verifikasi = 2 OR b.id_status_verifikasi = 3
          OR b.id_status_verifikasi = 6 OR b.id_status_verifikasi = 7 OR b.id_status_verifikasi = 8 OR b.id_status_verifikasi = 9)
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
              (CASE WHEN a.usia <= 21 THEN 'Anak < 21 Thn (Dapat)' ELSE
            (CASE WHEN (a.usia > 21 AND a.usia < 25) THEN
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
          (CASE WHEN a.usia <= 21 THEN NULL ELSE
            (CASE WHEN (a.usia > 21 AND a.usia < 25) THEN
              (CASE WHEN a.kuliah = 1 THEN (CASE WHEN a.tgl_lulus IS NULL THEN NULL ELSE DATE_FORMAT(a.tgl_lulus, '%d/%m/%Y') END) ELSE
                NULL END) ELSE NULL END) END) END)
        END AS ref_tanggal,
        CASE WHEN a.id_status = 9 THEN
        (CASE WHEN a.tgl_meninggal IS NOT NULL THEN a.akte_meninggal ELSE
          (CASE WHEN a.tgl_cerai IS NOT NULL THEN a.akte_cerai ELSE
            (CASE WHEN a.tgl_menikah IS NOT NULL THEN a.akte_menikah ELSE NULL END) END) END)
        ELSE
        (CASE WHEN a.tgl_meninggal IS NOT NULL THEN a.akte_meninggal ELSE
          (CASE WHEN a.usia <= 21 THEN NULL ELSE
            (CASE WHEN (a.usia > 21 AND a.usia < 25) THEN
              (CASE WHEN a.kuliah = 1 THEN (CASE WHEN a.tgl_lulus IS NULL THEN NULL ELSE NULL END) ELSE
                NULL END) ELSE NULL END) END) END)
        END AS ref_keterangan,
        CASE WHEN a.id_status = 9 THEN
        (CASE WHEN a.tgl_meninggal IS NOT NULL THEN 2 ELSE
          (CASE WHEN a.tgl_cerai IS NOT NULL THEN 3 ELSE
            (CASE WHEN a.tgl_menikah IS NOT NULL THEN 1 ELSE 0 END) END) END)
        ELSE
        (CASE WHEN a.tgl_meninggal IS NOT NULL THEN 6 ELSE
          (CASE WHEN a.usia <= 21 THEN 4 ELSE
            (CASE WHEN (a.usia > 21 AND a.usia < 25) THEN
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
        k.kuliah, k.tgl_lulus
        FROM pegawai p LEFT JOIN keluarga k ON p.id_pegawai = k.id_pegawai
        LEFT JOIN jabatan j ON p.id_j = j.id_j, status_kel sk, current_lokasi_kerja clk, unit_kerja uk
        WHERE k.id_status = sk.id_status AND p.id_pegawai = clk.id_pegawai AND clk.id_unit_kerja = uk.id_unit_kerja
        AND uk.id_skpd = $idskpd AND p.flag_pensiun = 0 $andKlausa
        ORDER BY eselon, pangkat_gol DESC, nama_pegawai ASC, k.id_status, k.tgl_lahir, k.nama) a $whereKlause3 ) b
        INNER JOIN keluarga k ON b.id_keluarga = k.id_keluarga
        $whereKlause1
        ORDER BY b.eselon, b.pangkat_gol DESC, b.nama_pegawai ASC, b.id_status, b.tgl_lahir, b.nama) family
        $whereKlause2";

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
    $mysqli->query("SET @row_number := $start_number");
    $sqlData = "SELECT FCN_ROW_NUMBER() as no_urut, family.* FROM (SELECT b.*,
          CASE WHEN b.status_tunjangan_skum = 'Dapat' AND (b.id_status_verifikasi = 1 OR b.id_status_verifikasi = 4
          OR b.id_status_verifikasi = 5) THEN 'Valid' ELSE
          (CASE WHEN b.status_tunjangan_skum = 'Tidak Dapat' AND (b.id_status_verifikasi = 2 OR b.id_status_verifikasi = 3
          OR b.id_status_verifikasi = 6 OR b.id_status_verifikasi = 7 OR b.id_status_verifikasi = 8 OR b.id_status_verifikasi = 9
          OR b.id_status_verifikasi = 10 OR b.id_status_verifikasi = 11)
          THEN 'Valid' ELSE 'Belum Valid / Tunjangan di Pasangan' END)
          END AS status_validasi
          FROM
        (SELECT a.id_pegawai, a.nip_baru, a.nama_pegawai, a.pangkat_gol, a.jabatan, a.eselon,
        a.id_keluarga, a.id_status, a.status_keluarga, a.nama, a.tempat_lahir, DATE_FORMAT(a.tgl_lahir, '%d-%m-%Y') AS tgl_lahir, a.pekerjaan,
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
        AND uk.id_skpd = $idskpd AND p.flag_pensiun = 0 $andKlausa
        ORDER BY eselon, pangkat_gol DESC, nama_pegawai ASC, k.id_status, k.tgl_lahir, k.nama) a $whereKlause3 ) b
        INNER JOIN keluarga k ON b.id_keluarga = k.id_keluarga
        $whereKlause1
        ORDER BY b.eselon, b.pangkat_gol DESC, b.nama_pegawai ASC, b.id_status, b.tgl_lahir, b.nama) family
        $whereKlause2 ".$pages->limit;
    $query = $mysqli->query($sqlData);

    if ($query->num_rows > 0) {
        if($numpage > 0){
            echo "Halaman ke $curpage dari $numpage | Jumlah Data : $jmlData | $jumppage | $rowperpage<br>";
            echo $pgDisplay;
        }
        $i = 0;
        echo "<table class='table' style='border-bottom: 1px solid #cdcfc7;margin-top: 10px;'>";
        echo "<tr style='border-bottom: solid 2px #2cc256;border-top: solid 2px #000000;'>";
        echo "<th>No</th><th>Nama</th>
        <th>Status</th><th>J.Kelamin</th>
        <th>Tempat/Tgl.Lahir</th><th>Usia</th>
        <th>Pekerjaan</th><th>Pegawai</th></tr>";
        while ($data = $query->fetch_array(MYSQLI_NUM)) {
            $i++;
            echo "<tr ".(($i%2)==0?"style='background-color:#FFFFFF'":"style='background-color: ##F9F9F9'")."><td>$data[0].</td><td>$data[10]</td><td>$data[9]</td><td>$data[14]</td>
            <td>$data[11], $data[12]</td><td>$data[16] thn</td><td>$data[13]</td>
            <td>$data[3]</td></tr>";
            echo "<tr ".(($i%2)==0?"style='background-color:#FFFFFF'":"style='background-color: ##F9F9F9'")."><td style='border-top: 0px;'></td>
            <td colspan='7' style='border-top: 0px;text-align: right;font-size: small; color: saddlebrown;font-style: italic;'>
            Tunjangan SKUM: $data[15],
            Hasil Verifikasi: $data[17],
            Status Validasi: $data[21]</td></tr>";
        }
        echo "</table>";
        if($numpage > 0){
            echo "Halaman ke $curpage dari $numpage | Jumlah Data : $jmlData | $jumppage | $rowperpage<br>";
            echo $pgDisplay;
        }
    }else{
        echo '<div style="padding: 10px;">Tidak ada data</div>';
    }
?>
</div>
<br>