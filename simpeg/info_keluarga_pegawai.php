<?php
include 'konek.php';
$idp = $_GET['idp'];

$sql = "SELECT b.*,
          CASE WHEN b.status_tunjangan_skum = 'Dapat' AND (b.id_status_verifikasi = 1 OR b.id_status_verifikasi = 4
          OR b.id_status_verifikasi = 5) THEN 'Valid' ELSE
          (CASE WHEN b.status_tunjangan_skum = 'Tidak Dapat' AND (b.id_status_verifikasi = 2 OR b.id_status_verifikasi = 3
          OR b.id_status_verifikasi = 6 OR b.id_status_verifikasi = 7 OR b.id_status_verifikasi = 8 OR b.id_status_verifikasi = 9
          OR b.id_status_verifikasi = 10 OR b.id_status_verifikasi = 11)
          THEN 'Valid' ELSE 'Belum Valid' END)
          END AS status_validasi
          FROM
        (SELECT a.id_pegawai, a.id_keluarga, a.id_status, a.status_keluarga, a.nama, a.tempat_lahir, a.tgl_lahir, a.pekerjaan,
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
                    (CASE WHEN a.sudah_bekerja = 1 THEN CONCAT(a.akte_kerja,' - ',a.nama_perusahaan) ELSE NULL END) END) ELSE
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
        END AS id_status_verifikasi,
        a.akte_kelahiran, DATE_FORMAT(a.tgl_akte_kelahiran, '%d/%m/%Y') AS tgl_akte_kelahiran,
        DATE_FORMAT(a.tgl_menikah, '%d/%m/%Y') AS tgl_menikah, a.akte_menikah, DATE_FORMAT(a.tgl_akte_menikah, '%d/%m/%Y') AS tgl_akte_menikah,
        DATE_FORMAT(a.tgl_meninggal, '%d/%m/%Y') AS tgl_meninggal, a.akte_meninggal, DATE_FORMAT(a.tgl_akte_meninggal, '%d/%m/%Y') AS tgl_akte_meninggal,
        DATE_FORMAT(a.tgl_cerai, '%d/%m/%Y') AS tgl_cerai, a.akte_cerai, DATE_FORMAT(a.tgl_akte_cerai, '%d/%m/%Y') AS tgl_akte_cerai,
        a.no_ijazah, a.nama_sekolah, DATE_FORMAT(a.tgl_lulus, '%d/%m/%Y') AS tgl_lulus
        FROM
        (SELECT k.id_pegawai, k.id_keluarga, k.id_status, sk.status_keluarga, k.nama, k.tempat_lahir,
        DATE_FORMAT(k.tgl_lahir, '%d-%m-%Y') AS tgl_lahir, k.pekerjaan, k.jk, k.dapat_tunjangan,
        ROUND(DATEDIFF(CURRENT_DATE, DATE_FORMAT(k.tgl_lahir, '%Y/%m/%d'))/365,2) AS usia,
        k.tgl_menikah, k.akte_menikah, k.tgl_meninggal, k.akte_meninggal, k.tgl_cerai, k.akte_cerai,
        k.kuliah, k.tgl_lulus, k.akte_kelahiran, k.tgl_akte_kelahiran, k.tgl_akte_menikah,
        k.tgl_akte_meninggal, k.tgl_akte_cerai, k.no_ijazah, k.nama_sekolah, k.sudah_bekerja, k.akte_kerja, k.nama_perusahaan
        FROM keluarga k, status_kel sk
        WHERE k.id_pegawai = $idp AND k.id_status = sk.id_status) a) b
        INNER JOIN keluarga k ON b.id_keluarga = k.id_keluarga
        ORDER BY b.id_status, b.tgl_lahir, b.nama";

$query = $mysqli->query($sql);
if ($query->num_rows > 0) {
    $i = 0;
    $e = 0;
    $label = "";
    echo "<table class='table'>";
    echo "<tr style='border-bottom: solid 2px #2cc256'>";
    echo "<th style='width:2%;'>No</th><th style='width:15%;'>Nama</th>
    <th style='width:43%;'>Biodata</th><th style='width:30%;'>Keterangan</th>
    <th style='width:10%;'>Status</th></tr>";
    while ($oto = $query->fetch_array(MYSQLI_NUM)) {
        $i++;
        if($label==""){
            $label = $oto[3];
            echo "<tr><td colspan='5' style='background-color:#f7f8ef;text-align: center;color: blue; font-weight: bold;'>$oto[3]</td></tr>";
        }else{
            if($label==$oto[3]){
                echo "";
            }else{
                echo "<tr><td colspan='5' style='background-color:#f7f8ef;text-align: center;color: blue; font-weight: bold;'>$oto[3]</td></tr>";
                $label = $oto[3];
                $i = 1;
            }
        }
        echo "<tr><td>$i. </td><td><strong>$oto[4]</strong></td><td>
            Jenis Kelamin : $oto[8]<br>
            Tempat, Tgl.Lahir : $oto[5], $oto[6]<br>
            Usia : $oto[10] thn<br>
            Pekerjaan : $oto[7] <br><a href='javascript:void(0);'
            data-toggle=\"collapse\" data-target=\"#collapse$oto[1]\">Detail</a>
            <div id=\"collapse$oto[1]\" class=\"collapse\">
            <span style='text-decoration: underline;'>Kelahiran</span> <span class=\"glyphicon glyphicon-arrow-right\"></span>
            No.Akte: ".($oto[15]==''?'-':$oto[15]).", Tgl.Akte: ".($oto[16]==''?'-':$oto[16])."<br>
            <span style='text-decoration: underline;'>Pernikahan</span> <span class=\"glyphicon glyphicon-arrow-right\"></span>
            Tgl.Nikah: ".($oto[17]==''?'-':$oto[17]).", No.Akte: ".($oto[18]==''?'-':$oto[18]).", Tgl.Akte: ".($oto[19]==''?'-':$oto[19])."<br>
            <span style='text-decoration: underline;'>Perceraian</span> <span class=\"glyphicon glyphicon-arrow-right\"></span>
            Tgl.Cerai: ".($oto[23]==''?'-':$oto[23]).", No.Akte: ".($oto[24]==''?'-':$oto[24]).", Tgl.Akte: ".($oto[25]==''?'-':$oto[25])."<br>
            <span style='text-decoration: underline;'>Kematian</span> <span class=\"glyphicon glyphicon-arrow-right\"></span>
            Tgl.Meninggal: ".($oto[20]==''?'-':$oto[20]).", No.Akte: ".($oto[21]==''?'-':$oto[21]).", Tgl.Akte: ".($oto[22]==''?'-':$oto[22])."<br>
            <span style='text-decoration: underline;'>Sekolah</span> <span class=\"glyphicon glyphicon-arrow-right\"></span>
            No.Ijazah: ".($oto[26]==''?'-':$oto[26]).", Institusi: ".($oto[27]==''?'-':$oto[27]).", Tgl.Lulus: ".($oto[28]==''?'-':$oto[28])."
            </div>
            </td><td>
            Tunjangan di SKUM : $oto[9]<br>
            Verifikasi : $oto[11]<br>$oto[12] $oto[13]
            </td><td>$oto[29]</td>
            </tr>";
        $e++;
    }
    echo "</table>";
}

?>