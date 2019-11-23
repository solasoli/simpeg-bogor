<style>
    .fileUpload {
        position: relative;
        overflow: hidden;
        margin: 10px;
    }

    .fileUpload input.upload {
        position: absolute;
        top: 0;
        right: 0;
        margin: 0;
        padding: 0;
        font-size: 20px;
        cursor: pointer;
        opacity: 0;
        filter: alpha(opacity=0);
    }
</style>
<script src="js/bootstrapValidator.js"></script>
<?php

error_reporting(E_ALL);
extract($_POST);
extract($_GET);

$connection = ssh2_connect('103.14.229.15');
ssh2_auth_password($connection, 'rommonz', 'mony3Tmony3T');
$sftp = ssh2_sftp($connection);

$tglPerm = date("d-m-Y");
$uploaddir = '/var/www/html/simpeg/berkas/';

if (isset($_GET['od'])) {
    $idp = $_GET['od'];
} else {
    $idp = $_SESSION['id_pegawai'];
}

$sql = "SELECT p.nama, p.nip_baru FROM pegawai p WHERE p.id_pegawai = " . $idp;
$q = $mysqli->query($sql);
while ($oto = $q->fetch_array(MYSQLI_NUM)) {
    $nama_p = $oto[0];
    $nip_p = $oto[1];
}

/* Rekap Jumlah Tunjangan */
$sql = "SELECT CASE WHEN sk.status_keluarga IS NULL THEN 'Jumlah' ELSE
            sk.status_keluarga END AS uraian, a.jumlah_tot, a.jml_dapat, a.jml_tdk_dapat FROM
            (SELECT k.id_status, COUNT(k.id_keluarga) AS jumlah_tot,
            SUM(IF(k.dapat_tunjangan = 1,1,0)) as jml_dapat,
            SUM(IF(k.dapat_tunjangan = 0,1,0)) as jml_tdk_dapat
            FROM keluarga k
            WHERE k.id_pegawai = $idp /*AND k.dapat_tunjangan = 1*/ AND
            (k.id_status = 9 OR k.id_status = 10)
            GROUP BY k.id_status
            WITH ROLLUP) a LEFT JOIN status_kel sk
            ON a.id_status = sk.id_status";
$queryRekap = $mysqli->query($sql);
if ($queryRekap->num_rows > 0) {
    $jmlPasangan = 0;
    $jmlPasanganDpt = 0;
    $jmlAnak = 0;
    $jmlAnakDpt = 0;
    $jmlTotalKel = 0;
    $jmlTotalKelDpt = 0;
    while ($oto = $queryRekap->fetch_array(MYSQLI_NUM)) {
        if ($oto[0] == 'Istri/Suami') {
            $jmlPasangan = $oto[1];
            $jmlPasanganDpt = $oto[2];
        } elseif ($oto[0] == 'Anak') {
            $jmlAnak = $oto[1];
            $jmlAnakDpt = $oto[2];
        } elseif ($oto[0] == 'Jumlah') {
            $jmlTotalKel = $oto[1];
            $jmlTotalKelDpt = $oto[2];
        }
    }
}

/* Kepala OPD */
$opd = $_SESSION['id_skpd'];
$sql = "SELECT gf.*, p.nip_baru as nip_plt, CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
        p.nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(' ',p.gelar_belakang) END) AS nama_plt, g.pangkat as pangkat_plt,
        p.id_j as id_j_plt, j.jabatan as jabatan_plt, g.golongan as gol_plt
        FROM (
        SELECT f.*, jplt.id_pegawai as idp_plt FROM
        (SELECT c.*, CASE WHEN g.pangkat IS NULL THEN '-' ELSE g.pangkat END AS pangkat  FROM
        (SELECT b.*,
        CASE b.unit_kerja WHEN @curUk THEN @curRow := @curRow + 1 ELSE @curRow := 1 END AS rank,
        @curUk := b.unit_kerja AS opd FROM
        (SELECT p.id_pegawai, p.nip_baru, CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
        nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(' ',p.gelar_belakang) END) AS nama, p.pangkat_gol,
        a.jabatan, a.eselon, a.nama_baru as unit_kerja, a.id_j, a.id_bos
        FROM (SELECT uk.id_unit_kerja, uk.nama_baru, j.jabatan, j.eselon, j.id_j, j.id_bos
        FROM unit_kerja uk, jabatan j
        WHERE uk.tahun = (SELECT MAX(tahun) FROM unit_kerja)
        AND uk.id_unit_kerja = $opd
        and uk.id_unit_kerja = uk.id_skpd and uk.id_unit_kerja = j.id_unit_kerja AND
        j.jabatan != 'Walikota Bogor' AND j.jabatan != 'Wakil Walikota Bogor'
        order by uk.nama_baru ASC) a LEFT JOIN pegawai p ON a.id_j = p.id_j
        ORDER BY a.id_unit_kerja ASC, a.eselon ASC) b JOIN (SELECT @curRow := 0, @curUk := '') r) c
        LEFT JOIN golongan g ON c.pangkat_gol = g.golongan
        WHERE c.rank = 1 ORDER BY c.opd) f LEFT JOIN jabatan_plt jplt ON f.id_j = jplt.id_j) gf
        LEFT JOIN pegawai p ON gf.idp_plt = p.id_pegawai
        LEFT JOIN golongan g ON p.pangkat_gol = g.golongan
        LEFT JOIN jabatan j ON p.id_j = j.id_j";
//echo $sql;
$queryKepala = $mysqli->query($sql);
if ($queryKepala->num_rows > 0) {
    while ($oto = $queryKepala->fetch_array(MYSQLI_NUM)) {
        if($oto[0]!=''){
            $id_kepala = $oto[0];
            $idj_kepala = $oto[7];
            $nmKepala = $oto[2];
            $nipKepala = $oto[1];
            $pangkatKepala = "$oto[11] - $oto[3]";
        }else{
            $id_kepala = $oto[12];
            $idj_kepala = $oto[16];
            $nmKepala = $oto[14];
            $nipKepala = $oto[13];
            $pangkatKepala = "$oto[18] - $oto[15]";
        }
    }
}

if (@$issubmit == 'true') {
    if (!empty($_POST['chkPilihKeluarga']) and !empty($_POST['optTipePengubahan']) and $_FILES['uploadFileSyarat']) {
        $all_query_ok = true;
        if (!empty($_POST['optTipePengubahan'])) {
            $optTipePengubahanNew = "";
            foreach ($optTipePengubahan as $key => $n) {
                if ($optTipePengubahan[$key] > 0) {
                    //echo '[' . $key . ']' . $optTipePengubahan[$key] . ',  ';
                    $optTipePengubahanNew = $optTipePengubahanNew . ',' . $optTipePengubahan[$key];
                    $optTipePengubahan2[$key] = $optTipePengubahan[$key];
                }
            }
        }
        if ($_FILES['uploadFileSyarat']) {
            $file_ary = $_FILES['uploadFileSyarat'];
            /*foreach ($file_ary['name'] as $key => $n){
                print "File Name ".$key.": " . $file_ary['name'][$key];
            }*/
        }
        /* Jenis Pengajuan */
        $sqlCekJenis = "SELECT a.*, CASE WHEN (a.jml_penambahan > 0 AND a.jml_pengurangan > 0) THEN 3 ELSE
            (CASE WHEN a.jml_penambahan > 0 THEN 1 ELSE 2 END) END AS id_jenis_pengajuan
            FROM (SELECT
            SUM(IF(ptp.kategori_pengubahan = 'Penambahan Jiwa',1,0)) as jml_penambahan,
            SUM(IF(ptp.kategori_pengubahan = 'Pengurangan Jiwa',1,0)) as jml_pengurangan
            FROM ptk_tipe_pengubahan ptp
            WHERE ptp.id_tipe_pengubahan_tunjangan IN (" . substr($optTipePengubahanNew, 1, strlen($optTipePengubahanNew) - 1) . ")) a";
        $query = $mysqli->query($sqlCekJenis);
        if (isset($query)) {
            if ($query->num_rows > 0) {
                while ($oto = $query->fetch_array(MYSQLI_NUM)) {
                    $id_tipe_jenis = $oto[2];
                }
            }
        }

        $sql = "SELECT p.id_pegawai, p.nip_baru, CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
                nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(' ',p.gelar_belakang) END) AS nama, p.alamat, 
                CASE WHEN p.jenis_kelamin = 1 THEN 'Laki-laki' ELSE 'Perempuan' END AS jenis_kelamin,
                p.jenjab, p.id_j, p.pangkat_gol,
                CASE WHEN p.jenjab = 'Fungsional' THEN (jafung.kode_jabatan_jafung) ELSE
                CASE WHEN p.id_j IS NULL THEN (jfu.kode_jabatan_jfu) ELSE j.id_j END END AS kode_jabatan,
                CASE WHEN p.jenjab = 'Fungsional' THEN (jafung.kelas_jabatan_jafung) ELSE
                CASE WHEN p.id_j IS NULL THEN (jfu.kelas_jabatan_jfu) ELSE j.kelas_jabatan END END AS kelas_jabatan,
                CASE WHEN p.jenjab = 'Fungsional' THEN (jafung.nilai_jabatan_jafung) ELSE
                CASE WHEN p.id_j IS NULL THEN (jfu.nilai_jabatan_jfu) ELSE j.nilai_jabatan END END AS nilai_jabatan,
                CASE WHEN p.jenjab = 'Fungsional' THEN (CASE WHEN jafung.nama_jafung IS NULL THEN p.jabatan ELSE jafung.nama_jafung END) ELSE
                CASE WHEN p.id_j IS NULL THEN (jfu.nama_jfu) ELSE j.jabatan END END AS jabatan,
                CASE WHEN j.eselon IS NULL THEN 'Staf' ELSE j.eselon END AS eselon2, uk.id_unit_kerja, uk.nama_baru AS unit, uk.id_skpd
                 FROM pegawai p
                LEFT JOIN jabatan j ON p.id_j = j.id_j
                LEFT JOIN (
                SELECT b.id_pegawai, jm.id_jfu as kode_jabatan_jfu, jm.kelas_jabatan as kelas_jabatan_jfu,
                jm.nilai_jabatan as nilai_jabatan_jfu, jm.nama_jfu
                FROM (SELECT a.*, jp.id_jfu FROM
                (SELECT jp.id_pegawai, MAX(jp.id) as id_jfu_pegawai FROM jfu_pegawai jp,
                (SELECT id_pegawai, MAX(tmt) as max_tmt FROM jfu_pegawai WHERE tmt IS NOT NULL GROUP BY id_pegawai) x
                WHERE jp.id_pegawai = x.id_pegawai AND jp.tmt = x.max_tmt
                GROUP BY jp.id_pegawai) a
                INNER JOIN jfu_pegawai jp ON a.id_jfu_pegawai = jp.id) b
                INNER JOIN jfu_master jm ON b.id_jfu = jm.id_jfu) jfu ON jfu.id_pegawai = p.id_pegawai
                LEFT JOIN (
                SELECT b.id_pegawai, jm.id_jafung as kode_jabatan_jafung, jm.kelas_jabatan as kelas_jabatan_jafung,
                jm.nilai_jabatan as nilai_jabatan_jafung, jm.nama_jafung
                FROM (SELECT a.*, jp.id_jafung FROM
                (SELECT jp.id_pegawai, MAX(jp.id) as id_jafung_pegawai FROM jafung_pegawai jp,
                (SELECT id_pegawai, MAX(tmt) as max_tmt FROM jafung_pegawai WHERE tmt IS NOT NULL GROUP BY id_pegawai) x
                WHERE jp.id_pegawai = x.id_pegawai AND jp.tmt = x.max_tmt
                GROUP BY jp.id_pegawai) a
                INNER JOIN jafung_pegawai jp ON a.id_jafung_pegawai = jp.id) b
                INNER JOIN jafung jm ON b.id_jafung = jm.id_jafung) jafung ON jafung.id_pegawai = p.id_pegawai
                INNER JOIN current_lokasi_kerja clk ON p.id_pegawai = clk.id_pegawai
                INNER JOIN unit_kerja uk ON clk.id_unit_kerja = uk.id_unit_kerja
                WHERE p.flag_pensiun = 0 AND p.id_pegawai = $idp
                ORDER BY eselon2 ASC, p.pangkat_gol DESC";
        
        $query = $mysqli->query($sql);
        if (isset($query)) {
            if ($query->num_rows > 0) {
                while ($oto = $query->fetch_array(MYSQLI_NUM)) {
                    $gol = $oto[7];
                    $jab = $oto[11];
                    $alamat = $oto[3];
                    $idUnit = $oto[13];
                    $id_j = $oto[6];
                    if ($id_j == '') {
                        $id_j = 'NULL';
                    }
                }
            }
        }

        // Cek SK Pangkat Terakhir ======================
        $sqlSkBerkas = "SELECT s.id_berkas FROM sk s
            WHERE s.id_pegawai = $idp AND s.id_kategori_sk = 5
            ORDER BY s.tmt DESC LIMIT 1";
        $query = $mysqli->query($sqlSkBerkas);

        if (isset($query)) {
            if ($query->num_rows > 0) {
                while ($berkas = $query->fetch_array(MYSQLI_NUM)) {
                    $idberkasSK = $berkas[0];
                }
                $sqlCekBerkas = "SELECT ib.file_name, b.created_by, DATE_FORMAT(b.created_date,  '%d/%m/%Y %H:%i:%s') AS created_date, p.nip_baru, p.nama, b.id_kat
                    FROM berkas b LEFT JOIN pegawai p ON b.created_by = p.id_pegawai, isi_berkas ib
                    WHERE b.id_berkas = ib.id_berkas AND b.id_berkas = $idberkasSK";
                //echo $sqlCekBerkas;
                $query = $mysqli->query($sqlCekBerkas);
                if (isset($query)) {
                    if ($query->num_rows > 0) {
                        while ($berkas = $query->fetch_array(MYSQLI_NUM)) {
                            $asli = basename($berkas[0]);
                            //if (file_exists(str_replace("\\", "/", getcwd()) . '/berkas/' . trim($asli))) {
                                $idberkasSK = $idberkasSK;
                            //} else {
                            //    $idberkasSK = 'NULL';
                            //}
                        }
                    } else {
                        $idberkasSK = 'NULL';
                    }
                } else {
                    $idberkasSK = 'NULL';
                }
            } else {
                $idberkasSK = 'NULL';
            }
        } else {
            $idberkasSK = 'NULL';
        }
        //==============================================

        $sqlInsertMaster = "INSERT INTO ptk_master(tgl_input_pengajuan, tgl_update_pengajuan, nomor, sifat, lampiran,
                    id_jenis_pengajuan, last_jml_pasangan, last_jml_anak, id_pegawai_pemohon, last_id_unit_kerja,
                    last_gol, last_jabatan, last_alamat, id_pegawai_kepala_opd, last_idj_kepala, idstatus_ptk, last_idj_pemohon, id_berkas_sk_pangkat_last)
                    VALUES (NOW(),NOW(),'$nomor','$sifat','$lampiran',$id_tipe_jenis,$jmlPasanganDpt,$jmlAnakDpt,
                    $idp,$idUnit,'$gol','$jab','$alamat',$id_kepala,$idj_kepala,1,$id_j,$idberkasSK)";

        //echo $sqlInsertMaster;
        $mysqli->autocommit(FALSE);
        if ($mysqli->query($sqlInsertMaster) === TRUE) {
            $last_id = $mysqli->insert_id;
            if (!empty($_POST['chkPilihKeluarga'])) {
                foreach ($chkPilihKeluarga as $key => $n) {
                    //echo '['.$key.']'.$chkPilihKeluarga[$key].',  <br>';
                    $sqlKeluarga = "SELECT id_keluarga,id_status,nama,tempat_lahir,tgl_lahir,pekerjaan,jk,dapat_tunjangan,
                        tgl_menikah,akte_menikah,tgl_meninggal,akte_meninggal,tgl_cerai, akte_cerai,kuliah,tgl_lulus,akte_kelahiran,no_ijazah,
                        nama_sekolah,tgl_akte_kelahiran,tgl_akte_menikah,tgl_akte_meninggal,tgl_akte_cerai, sudah_bekerja, nama_perusahaan, akte_kerja
                        FROM keluarga WHERE id_keluarga = " . $chkPilihKeluarga[$key];
                    //echo $sqlKeluarga.'<br>';
                    $query = $mysqli->query($sqlKeluarga);
                    if (isset($query)) {
                        if ($query->num_rows > 0) {
                            while ($oto = $query->fetch_array(MYSQLI_NUM)) {
                                $jk = ($oto[6] == '' ? 'NULL' : $oto[6]);
                                $job = ($oto[5] == '' ? 'NULL' : $oto[5]);
                                $sqlInsertPtkKeluarga = "INSERT INTO ptk_keluarga(id_tipe_pengubahan_tunjangan, last_id_status_keluarga,
                                    last_nama,last_tempat_lahir,last_tgl_lahir,last_pekerjaan,last_jk,last_status_tunjangan,
                                    id_ptk,last_id_keluarga) VALUES (" . $optTipePengubahan2[$key] . ",$oto[1],'".addslashes($oto[2])."',
                                    '$oto[3]','$oto[4]','$job',$jk,$oto[7],$last_id,$oto[0])";
                                //echo $sqlInsertPtkKeluarga.'<br>';
                                if ($optTipePengubahan2[$key] == 1 or $optTipePengubahan2[$key] == 10 or $optTipePengubahan2[$key] == 12 or $optTipePengubahan2[$key] == 16) { //Nikah Pasangan & Nikah Anak & Pengalihan Tunj. ke Pasangan
                                    $tglref = ($oto[8] == '' ? 'NULL' : "'" . $oto[8] . "'");
                                    $ketref = $oto[9];
                                    $tglAkte = ($oto[20] == '' ? 'NULL' : "'" . $oto[20] . "'");
                                    $sekolah = '';
                                } elseif ($optTipePengubahan2[$key] == 2 or $optTipePengubahan2[$key] == 6) { //Meninggal
                                    $tglref = ($oto[10] == '' ? 'NULL' : "'" . $oto[10] . "'");
                                    $ketref = $oto[11];
                                    $tglAkte = ($oto[21] == '' ? 'NULL' : "'" . $oto[21] . "'");
                                    $sekolah = '';
                                } elseif ($optTipePengubahan2[$key] == 3) { //Cerai
                                    $tglref = ($oto[12] == '' ? 'NULL' : "'" . $oto[12] . "'");
                                    $ketref = $oto[13];
                                    $tglAkte = ($oto[22] == '' ? 'NULL' : "'" . $oto[22] . "'");
                                    $sekolah = '';
                                } elseif ($optTipePengubahan2[$key] == 4 or $optTipePengubahan2[$key] == 8 or $optTipePengubahan2[$key] == 9 or $optTipePengubahan2[$key] == 13 or $optTipePengubahan2[$key] == 15) { //Kelahiran & Pengalihan Tunj. Anak & Hsl Pernikahan Lalu
                                    $tglref = ($oto[4] == '' ? 'NULL' : "'" . $oto[4] . "'");
                                    $ketref = $oto[16];
                                    $tglAkte = ($oto[19] == '' ? 'NULL' : "'" . $oto[19] . "'");
                                    $sekolah = '';
                                } elseif ($optTipePengubahan2[$key] == 5) { //Masih kuliah
                                    $tglref = 'NULL';
                                    $ketref = '';
                                    $tglAkte = 'NULL';
                                    $sekolah = $oto[18];
                                } elseif ($optTipePengubahan2[$key] == 7 or $optTipePengubahan2[$key] == 14) { //Lulus kuliah
                                    $tglref = ($oto[15] == '' ? 'NULL' : "'" . $oto[15] . "'");
                                    $ketref = $oto[17];
                                    $tglAkte = 'NULL';
                                    $sekolah = $oto[18];
                                } elseif ($optTipePengubahan2[$key] == 11) { //Sudah Bekerja
                                    $tglref = 'NULL';
                                    $ketref = $oto[25];
                                    $tglAkte = 'NULL';
                                    $sekolah = $oto[24];
                                }
                                if ($mysqli->query($sqlInsertPtkKeluarga)) {
                                    $last_idptk_kel = $mysqli->insert_id;
                                    $sqlInsertSyarat = "INSERT INTO ptk_syarat(last_tgl_references,last_keterangan_reference,last_tgl_akte,
                                        nama_sekolah,id_ptk_keluarga)
                                        VALUES ($tglref,'$ketref',$tglAkte,'$sekolah',$last_idptk_kel)";
                                    //echo $sqlInsertSyarat.'<br><br>';
                                    if ($mysqli->query($sqlInsertSyarat)) {
                                        $last_idptk_syarat = $mysqli->insert_id;
                                        if (isset($file_ary)) {
                                            if ($file_ary['name'][$key] <> "") {
                                                if ($file_ary['type'][$key] == 'binary/octet-stream' or $file_ary['type'][$key] == "application/pdf") {
                                                    $uploadfile = $uploaddir . basename($file_ary['name'][$key]);
                                                  //  if (move_uploaded_file($file_ary['tmp_name'][$key], $uploadfile)) {
                                                  if(ssh2_scp_send($connection, $file_ary['tmp_name'][$key], $uploadfile, 0644)){
                                                        $sql = "SELECT ptp.id_kat_berkas_syarat, ptp.nama_berkas_syarat
                                                            FROM ptk_tipe_pengubahan ptp
                                                            WHERE ptp.id_tipe_pengubahan_tunjangan = " . $optTipePengubahan2[$key];
                                                        $qryTipe = $mysqli->query($sql);
                                                        while ($d = $qryTipe->fetch_array(MYSQLI_NUM)) {
                                                            $idkat_berkas = $d[0];
                                                            $nm_berkas = $d[1];
                                                        }
                                                        $sqlInsertBerkas = "insert into berkas (id_pegawai,id_kat,nm_berkas,tgl_upload,created_by,created_date,ket_berkas) " .
                                                            "values (" . $idp . ",$idkat_berkas,'$nm_berkas',DATE(NOW()),'" . $idp . "',NOW(),$last_idptk_syarat)";
                                                        if ($mysqli->query($sqlInsertBerkas)) {
                                                            //echo $sqlInsertBerkas.'<br>';
                                                            $last_id_berkas = $mysqli->insert_id;
                                                            $sqlUpdateBerkas = "update ptk_syarat set id_berkas_syarat = $last_id_berkas where id_syarat=" . $last_idptk_syarat;
                                                            //echo $sqlUpdateBerkas.'<br>';
                                                            if ($mysqli->query($sqlUpdateBerkas)) {
                                                                $sqlInsertIsi = "insert into isi_berkas (id_berkas, ket) values ($last_id_berkas, '$nm_berkas')";
                                                                //echo $sqlInsertIsi.'<br>';
                                                                if ($mysqli->query($sqlInsertIsi)) {
                                                                    $last_idisi = $mysqli->insert_id;
                                                                    $nf = $_SESSION['nip_baru'] . "-" . $last_id_berkas . "-" . $last_idisi . ".pdf";
                                                                    $sqlUpdateIsi = "update isi_berkas set file_name='$nf' where id_isi_berkas=$last_idisi";
                                                                    //echo $sqlUpdateIsi.'<br>';
                                                                    if ($mysqli->query($sqlUpdateIsi)) {
                                                                        //rename($uploadfile, "berkas/" . $nf);
                                                                        ssh2_sftp_rename($sftp, $uploadfile,$uploaddir.$nf);
                                                                    } else {
                                                                        $all_query_ok = false;
                                                                    }
                                                                } else {
                                                                    $all_query_ok = false;
                                                                }
                                                            } else {
                                                                $all_query_ok = false;
                                                            }
                                                        } else {
                                                            $all_query_ok = false;
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    } else {
                                        $all_query_ok = false;
                                    }
                                } else {
                                    //echo $mysqli->error.'<br>';
                                    //echo 'Failed'.'<br><br>';
                                    $all_query_ok = false;
                                }
                            }
                        }
                    }
                }
            }
        } else {
            $all_query_ok = false;
        }
        if ($all_query_ok) {
            $mysqli->commit();
            echo("<div align=center style='background-color: #83c868;font-weight: bold;color: #ffffff; padding-top: 5px;padding-bottom: 5px;'> Data Permohonan Pengubahan Tunjangan Berhasil disimpan </div>");
        } else {
            $mysqli->rollback();
            echo("<div align=center style='background-color:#c8271b;font-weight: bold;color: #ffffff; padding-top: 5px;padding-bottom: 5px;'> Error: Tidak dapat menyimpan data" . "<br>" . $conn->error . "</div>");
        }
    }
}
?>
<h3>Administrasi Permohonan Pengubahan Tunjangan Keluarga (SIPUJANGGA)</h3>
<div role="tabpanel">
    <ul class="nav nav-tabs" role="tablist" id="myTab_PTK">
        <li role="presentation" class="<?php echo($issubmit == 'true' ? '' :
            ((isset($btnAjukanPtk) or isset($btnAjukanUlangPtk) or isset($btnBatalkanPtk)
                or isset($btnHapusPtk) or isset($btnUpdatePtk)) ? '' : 'active')); ?>">
            <a href="#form_ptk" aria-controls="form_ptk" role="tab" data-toggle="tab">Form Registrasi</a></li>
        <li role="presentation" class="<?php echo($issubmit == 'true' ? 'active' :
            ((isset($btnAjukanPtk) or isset($btnAjukanUlangPtk) or isset($btnBatalkanPtk)
                or isset($btnHapusPtk) or isset($btnUpdatePtk)) ? 'active' : '')); ?>">
            <a href="#list_ptk" aria-controls="list_ptk" role="tab" data-toggle="tab">Status Pengajuan PTK</a></li>
    </ul>
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane <?php echo($issubmit == 'true' ? '' :
            ((isset($btnAjukanPtk) or isset($btnAjukanUlangPtk) or isset($btnBatalkanPtk)
                or isset($btnHapusPtk) or isset($btnUpdatePtk)) ? '' : 'active')); ?>" id="form_ptk">
            <?php
            if (isset($btnUbahKeluarga)) {
                $tglLahir = explode("-", $tglLahir);
                $tglLahir = "'" . $tglLahir[2] . '-' . $tglLahir[1] . '-' . $tglLahir[0] . "'";
                $tglLahirAkte = explode("-", $tglLahirAkte);
                $tglLahirAkte = "'" . $tglLahirAkte[2] . '-' . $tglLahirAkte[1] . '-' . $tglLahirAkte[0] . "'";
                if ($optStatusNikah == 1) {
                    $tglNikah = explode("-", $tglNikah);
                    $tglNikah = "'" . $tglNikah[2] . '-' . $tglNikah[1] . '-' . $tglNikah[0] . "'";
                    $txtNoAkteNikah = "'" . $txtNoAkteNikah . "'";
                    $tglNikahAkte = explode("-", $tglNikahAkte);
                    $tglNikahAkte = "'" . $tglNikahAkte[2] . '-' . $tglNikahAkte[1] . '-' . $tglNikahAkte[0] . "'";
                } else {
                    $tglNikah = 'NULL';
                    $txtNoAkteNikah = 'NULL';
                    $tglNikahAkte = 'NULL';
                }
                if ($optStatusCerai == 1) {
                    $tglCerai = explode("-", $tglCerai);
                    $tglCerai = "'" . $tglCerai[2] . '-' . $tglCerai[1] . '-' . $tglCerai[0] . "'";
                    $txtNoAkteCerai = "'" . $txtNoAkteCerai . "'";
                    $tglCeraiAkte = explode("-", $tglCeraiAkte);
                    $tglCeraiAkte = "'" . $tglCeraiAkte[2] . '-' . $tglCeraiAkte[1] . '-' . $tglCeraiAkte[0] . "'";
                } else {
                    $tglCerai = 'NULL';
                    $txtNoAkteCerai = 'NULL';
                    $tglCeraiAkte = 'NULL';
                }
                if ($optStatusKuliah == 1) {
                    if ($tglLulus == '') {
                        $tglLulus = 'NULL';
                    } else {
                        $tglLulus = explode("-", $tglLulus);
                        $tglLulus = "'" . $tglLulus[2] . '-' . $tglLulus[1] . '-' . $tglLulus[0] . "'";
                    }
                    if ($txtNoIjazah == '') {
                        $txtNoIjazah = 'NULL';
                    } else {
                        $txtNoIjazah = "'" . $txtNoIjazah . "'";
                    }
                    $txtInstitusi = "'" . $txtInstitusi . "'";
                } else {
                    $tglLulus = 'NULL';
                    $txtNoIjazah = 'NULL';
                    $txtInstitusi = 'NULL';
                }
                if ($optStatusDie == 1) {
                    $tglDie = explode("-", $tglDie);
                    $tglDie = "'" . $tglDie[2] . '-' . $tglDie[1] . '-' . $tglDie[0] . "'";
                    $txtNoAkteDie = "'" . $txtNoAkteDie . "'";
                    $tglDieAkte = explode("-", $tglDieAkte);
                    $tglDieAkte = "'" . $tglDieAkte[2] . '-' . $tglDieAkte[1] . '-' . $tglDieAkte[0] . "'";
                } else {
                    $tglDie = 'NULL';
                    $txtNoAkteDie = 'NULL';
                    $tglDieAkte = 'NULL';
                }
                if ($optStatusKel == 10) {
                    if ($optStatusPenghasilan == 1) {
                        $sudahkerja = '1';
                        $nmperusahaan = "'" . $txtNamaPerusahaan . "'";
                        $txtNoAkteKerja = "'" . $txtNoAkteKerja . "'";
                    } else {
                        $sudahkerja = '0';
                        $nmperusahaan = 'NULL';
                        $txtNoAkteKerja = 'NULL';
                    }
                } else {
                    $sudahkerja = 'NULL';
                    $nmperusahaan = 'NULL';
                    $txtNoAkteKerja = 'NULL';
                }
                $all_query_ok = true;
                $mysqli->autocommit(FALSE);
                if ($isAdd) {
                    $sql = "insert into keluarga (id_pegawai, id_status, nama, tempat_lahir, tgl_lahir, akte_kelahiran, tgl_akte_kelahiran,
                                tgl_menikah, akte_menikah, tgl_akte_menikah, tgl_meninggal, akte_meninggal, tgl_akte_meninggal, tgl_cerai, akte_cerai, tgl_akte_cerai,
                                no_karsus, pekerjaan, jk, dapat_tunjangan, nik, kuliah, tgl_lulus, no_ijazah, nama_sekolah, sudah_bekerja, nama_perusahaan, akte_kerja)
                                values ($idp, $optStatusKel, '$txtNama', '$txtTempatLahir', $tglLahir, '$txtNoAkteLahir', $tglLahirAkte,
                                $tglNikah, $txtNoAkteNikah, $tglNikahAkte, $tglDie, $txtNoAkteDie, $tglDieAkte, $tglCerai, $txtNoAkteCerai, $tglCeraiAkte,
                                '$txtNoKarisu', '$txtPekerjaan', $optJk, $optStatusTunj, '$txtNik', $optStatusKuliah, $tglLulus, $txtNoIjazah, $txtInstitusi,$sudahkerja,$nmperusahaan,$txtNoAkteKerja)";
                } else {
                    $sql = "update keluarga set id_status=$optStatusKel, nama='$txtNama', tempat_lahir='$txtTempatLahir',tgl_lahir=$tglLahir,
                                akte_kelahiran='$txtNoAkteLahir', tgl_akte_kelahiran=$tglLahirAkte, tgl_menikah=$tglNikah, akte_menikah=$txtNoAkteNikah, tgl_akte_menikah=$tglNikahAkte,
                                tgl_meninggal=$tglDie, akte_meninggal=$txtNoAkteDie, tgl_akte_meninggal=$tglDieAkte, tgl_cerai=$tglCerai, akte_cerai=$txtNoAkteCerai, tgl_akte_cerai=$tglCeraiAkte,
                                no_karsus='$txtNoKarisu', pekerjaan='$txtPekerjaan', jk=$optJk, dapat_tunjangan=$optStatusTunj, nik='$txtNik',
                                kuliah=$optStatusKuliah, tgl_lulus=$tglLulus, no_ijazah=$txtNoIjazah, nama_sekolah=$txtInstitusi, sudah_bekerja=$sudahkerja, nama_perusahaan=$nmperusahaan, akte_kerja=$txtNoAkteKerja
                                where id_keluarga = $idkeluarga";
                }
                //echo $sql;
                if ($mysqli->query($sql) === TRUE) {
                } else {
                    $all_query_ok = false;
                }
                if ($all_query_ok) {
                    $mysqli->commit();
                    echo("<div align=center style='background-color: #83c868;font-weight: bold;color: #ffffff; padding-top: 5px;padding-bottom: 5px;'> Data Keluarga Berhasil disimpan </div>");
                } else {
                    $mysqli->rollback();
                    echo("<div align=center style='background-color:#c8271b;font-weight: bold;color: #ffffff; padding-top: 5px;padding-bottom: 5px;'> Error: Tidak dapat menyimpan data" . "<br>" . $conn->error . "</div>");
                }
            }
            ?>
            <div id="divInfo"></div>
            <form role="form" class="form-horizontal" action="index3.php?x=ptk.php&od=<?php echo $idp; ?>" method="post"
                  enctype="multipart/form-data" name="frmReqPTK" id="frmReqPTK" style="margin-top: 20px;">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="form-group">
                                    <!--<label class="control-label col-lg-4" for="selectJenPengajuan">Jenis Pengajuan :</label>-->
                                    <div class="col-lg-12">
                                        <span style="color: #919191; font-size: small;">
                                        Jenis pengajuan :
                                            <?php
                                            $qdj = mysqli_query($mysqli,"SELECT * FROM ptk_jenis_pengajuan");
                                            $i = 1;
                                            $text = "";
                                            while ($data = mysqli_fetch_array($qdj)) {
                                                $text .= "$i) $data[1], ";
                                                $i++;
                                            }
                                            echo substr($text, 0, strlen($text) - 2) . ". Disesuaikan dengan pemilihan pada daftar keluarga.";
                                            ?>
                                        </span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-lg-4" for="tglPermintaan">Tgl. Pengajuan :</label>

                                    <div class="col-lg-6"><input type="text" class="form-control" id="tglPermintaan"
                                                                 name="tglPermintaan" value="<?php echo $tglPerm; ?>"
                                                                 readonly="readonly"></div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-lg-4" for="nomor">Nomor :</label>

                                    <div class="col-lg-6"><input type="text" class="form-control" id="nomor"
                                                                 name="nomor" value="-"></div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-lg-4" for="sifat">Sifat :</label>

                                    <div class="col-lg-6"><input type="text" class="form-control" id="sifat"
                                                                 name="sifat" value="-"></div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-lg-4" for="lampiran">Lampiran :</label>

                                    <div class="col-lg-6"><input type="text" class="form-control" id="lampiran"
                                                                 name="lampiran" value="-"></div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="panel panel-default">
                            <div class="panel-heading">Rekapitulasi Berds. SKUM</div>
                            <div class="panel-body">
                                Nama Pemohon : <?php echo "<strong>$nama_p</strong>" . ' (' . $nip_p . ')'; ?><br>
                                Jumlah jiwa yang mendapat tunjangan : <br>
                                <?php
                                $jmlJiwaValid = "";
                                if ($jmlTotalKel > 0) {
                                    ?>
                                    <table>
                                        <tr>
                                            <td>Suami/Istri</td>
                                            <td>&nbsp&nbsp:&nbsp&nbsp</td>
                                            <td><?php echo $jmlPasanganDpt ?> orang</td>
                                        </tr>
                                        <tr>
                                            <td>Anak</td>
                                            <td>&nbsp&nbsp:&nbsp&nbsp</td>
                                            <td><?php echo $jmlAnakDpt ?> orang</td>
                                        </tr>
                                        <tr>
                                            <td>Jumlah</td>
                                            <td>&nbsp&nbsp:&nbsp&nbsp</td>
                                            <td><?php echo $jmlTotalKelDpt ?> orang</td>
                                        </tr>
                                    </table>
                                    <?php
                                    if ($jmlTotalKelDpt > 3) {
                                        $jmlJiwaValid = "Jumlah jiwa keluarga yang ditanggung lebih dari 3 orang";
                                    } else {
                                        $jmlJiwaValid = "";
                                    }
                                } else {
                                    $jmlJiwaValid = "Belum ada data keluarga";
                                }
                                ?>
                                <hr>
                                <?php
                                    if ($nmKepala <> "") {
                                        echo "Kepala OPD : <br> $nmKepala <br> $nipKepala <br> $pangkatKepala";
                                    }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <strong>Daftar Keluarga</strong><br>
                                <span style="color: #919191;font-size: small;">Silahkan tentukan dahulu Tipe Pengubahan dan Pilih keluarga yang akan diubah tunjangannya, kemudian lampirkan berkas persyaratan keluarga.
                                <br>Ukuran file berkas syarat, maksimal 2 MB dan bertipe PDF.
                                    Nama file jangan sama.</span><br>
                                <span style="color: #919191;font-size: small;">Simpan dan Lihat Status Pengajuan PTK. Periksa kembali file yang sudah terupload dan
                                lampirkan berkas persyaratan lainnya lalu Kirim Usulan.</span><br>
                                <span style="color: #919191;font-size: small;">Untuk menambah anggota pada Daftar Keluarga
                                    <a href="javascript:void(0);"
                                       onclick="ubahDataKeluarga(-1,<?php echo $idp; ?>);"><strong>Klik Disini</strong></a></span>.
                                <span style="color: #919191;font-size: small;">Untuk mencetak SKUM-PTK
                                    <a href="/simpeg2/pdf/skum_pdf/index/<?php echo $idp; ?>"
                                       target="_blank"><strong>Download Disini</strong></a>.</span>
                                <span style="color: #919191;font-size: small;">Untuk mengubah data keluarga dan atau menyesuaikan data SKUM klik icon bergambar
                                    <img src="images/pencil.png" alt="Ubah Data Keluarga" title='Ubah Data Keluarga' style="width:16px;height:16px;border:0;">
                                    di samping nama pada Daftar Keluarga.</span><br><br>
                                <div id="div2">
                                    <?php
                                    $sql = "SELECT
                                              c.*,
                                              ptp.nama_berkas_syarat
                                            FROM (SELECT
                                                b.*
                                              FROM (SELECT
                                                  a.id_keluarga,
                                                  a.id_status,
                                                  a.status_keluarga,
                                                  a.nama,
                                                  a.tempat_lahir,
                                                  DATE_FORMAT(a.tgl_lahir, '%d/%m/%Y') AS tgl_lahir,
                                                  a.pekerjaan,
                                                  CASE WHEN a.jk = 1 THEN 'Laki-laki' ELSE 'Perempuan' END AS jenis_kelamin,
                                                  CASE WHEN a.dapat_tunjangan = 0 THEN 'Tidak Dapat' ELSE 'Dapat' END AS status_tunjangan_skum,
                                                  a.usia,
                                                  CASE WHEN a.id_status = 9 THEN (CASE WHEN a.tgl_meninggal IS NOT NULL THEN 'Meninggal (Tidak Dapat)' ELSE (CASE WHEN a.tgl_cerai IS NOT NULL THEN 'Cerai (Tidak Dapat)' ELSE (CASE WHEN a.tgl_menikah IS NOT NULL THEN 'Menikah (Dapat)' ELSE 'Tgl. Menikah Blm Diisi' END) END) END) ELSE (CASE WHEN a.tgl_meninggal IS NOT NULL THEN 'Meninggal (Tidak Dapat)' ELSE (CASE WHEN a.usia < 21 THEN (CASE WHEN a.tgl_menikah IS NOT NULL THEN 'Anak < 21 Thn Sdh Menikah (Tidak Dapat)' ELSE (CASE WHEN a.sudah_bekerja = 1 THEN 'Anak < 21 Thn Sdh Bekerja (Tidak Dapat)' ELSE 'Anak < 21 Thn (Dapat)' END) END) ELSE (CASE WHEN (a.usia >= 21 AND
                                                                  a.usia < 25) THEN (CASE WHEN a.kuliah = 1 THEN (CASE WHEN a.tgl_lulus IS NULL THEN 'Anak kuliah (Dapat)' ELSE 'Anak lulus kuliah (Tidak Dapat)' END) ELSE (CASE WHEN a.tgl_menikah IS NOT NULL THEN 'Anak sudah menikah (Tidak Dapat)' ELSE 'Anak tidak kuliah (Tidak Dapat)' END) END) ELSE 'Anak > 25 Thn (Tidak Dapat)' END) END) END) END AS status_verifikasi_data,
                                                  CASE WHEN a.id_status = 9 THEN (CASE WHEN a.tgl_meninggal IS NOT NULL THEN DATE_FORMAT(a.tgl_meninggal, '%d/%m/%Y') ELSE (CASE WHEN a.tgl_cerai IS NOT NULL THEN DATE_FORMAT(a.tgl_cerai, '%d/%m/%Y') ELSE (CASE WHEN a.tgl_menikah IS NOT NULL THEN DATE_FORMAT(a.tgl_menikah, '%d/%m/%Y') ELSE NULL END) END) END) ELSE (CASE WHEN a.tgl_meninggal IS NOT NULL THEN DATE_FORMAT(a.tgl_meninggal, '%d/%m/%Y') ELSE (CASE WHEN a.usia < 21 THEN (CASE WHEN a.tgl_menikah IS NOT NULL THEN DATE_FORMAT(a.tgl_menikah, '%d/%m/%Y') ELSE (CASE WHEN a.sudah_bekerja = 1 THEN NULL ELSE NULL END) END) ELSE (CASE WHEN (a.usia >= 21 AND
                                                                  a.usia < 25) THEN (CASE WHEN a.kuliah = 1 THEN (CASE WHEN a.tgl_lulus IS NULL THEN NULL ELSE DATE_FORMAT(a.tgl_lulus, '%d/%m/%Y') END) ELSE (CASE WHEN a.tgl_menikah IS NOT NULL THEN a.tgl_menikah ELSE NULL END) END) ELSE NULL END) END) END) END AS ref_tanggal,
                                                  CASE WHEN a.id_status = 9 THEN (CASE WHEN a.tgl_meninggal IS NOT NULL THEN a.akte_meninggal ELSE (CASE WHEN a.tgl_cerai IS NOT NULL THEN a.akte_cerai ELSE (CASE WHEN a.tgl_menikah IS NOT NULL THEN a.akte_menikah ELSE NULL END) END) END) ELSE (CASE WHEN a.tgl_meninggal IS NOT NULL THEN a.akte_meninggal ELSE (CASE WHEN a.usia < 21 THEN (CASE WHEN a.tgl_menikah IS NOT NULL THEN a.akte_menikah ELSE (CASE WHEN a.sudah_bekerja = 1 THEN a.nama_perusahaan ELSE NULL END) END) ELSE (CASE WHEN (a.usia >= 21 AND
                                                                  a.usia < 25) THEN (CASE WHEN a.kuliah = 1 THEN (CASE WHEN a.tgl_lulus IS NULL THEN NULL ELSE NULL END) ELSE (CASE WHEN a.tgl_menikah IS NOT NULL THEN a.akte_menikah ELSE NULL END) END) ELSE NULL END) END) END) END AS ref_keterangan,
                                                  CASE WHEN a.id_status = 9 THEN (CASE WHEN a.tgl_meninggal IS NOT NULL THEN 2 ELSE (CASE WHEN a.tgl_cerai IS NOT NULL THEN 3 ELSE (CASE WHEN a.tgl_menikah IS NOT NULL THEN 1 ELSE 0 END) END) END) ELSE (CASE WHEN a.tgl_meninggal IS NOT NULL THEN 6 ELSE (CASE WHEN a.usia < 21 THEN (CASE WHEN a.tgl_menikah IS NOT NULL THEN 10 ELSE (CASE WHEN a.sudah_bekerja = 1 THEN 11 ELSE 4 END) END) ELSE (CASE WHEN (a.usia >= 21 AND
                                                                  a.usia < 25) THEN (CASE WHEN a.kuliah = 1 THEN (CASE WHEN a.tgl_lulus IS NULL THEN 5 ELSE 7 END) ELSE (CASE WHEN a.tgl_menikah IS NOT NULL THEN 16 ELSE 8 END) END) ELSE 9 END) END) END) END AS id_status_verifikasi
                                                FROM (SELECT
                                                    k.id_keluarga,
                                                    k.id_status,
                                                    sk.status_keluarga,
                                                    k.nama,
                                                    k.tempat_lahir,
                                                    k.tgl_lahir,
                                                    k.pekerjaan,
                                                    k.jk,
                                                    k.dapat_tunjangan,
                                                    ROUND(DATEDIFF(current_date, DATE_FORMAT(k.tgl_lahir, '%Y/%m/%d')) / 365, 2) AS usia,
                                                    k.tgl_menikah,
                                                    k.akte_menikah,
                                                    k.tgl_meninggal,
                                                    k.akte_meninggal,
                                                    k.tgl_cerai,
                                                    k.akte_cerai,
                                                    k.kuliah,
                                                    k.tgl_lulus,
                                                    k.sudah_bekerja,
                                                    k.nama_perusahaan
                                                  FROM keluarga k,
                                                       status_kel sk
                                                  WHERE k.id_pegawai = $idp
                                                  AND k.id_status = sk.id_status) a) b
                                                INNER JOIN keluarga k
                                                  ON b.id_keluarga = k.id_keluarga
                                              ORDER BY b.id_status, b.tgl_lahir, b.nama) c
                                              LEFT JOIN ptk_tipe_pengubahan ptp
                                                ON c.id_status_verifikasi = ptp.id_tipe_pengubahan_tunjangan";
                                    //echo $sql;
                                    $query = $mysqli->query($sql);
                                    if ($query->num_rows > 0) {
                                        $i = 0;
                                        $e = 0;
                                        $label = "";
                                        echo "<table class='table'>";
                                        echo "<tr style='border-bottom: solid 2px #2cc256'>";
                                        echo "<th>No</th><th style='text-align: center'>Nama</th><th>Tempat,<br>Tgl.Lahir</th><th>Tunjangan <br>di SKUM</th>
                                            <th>Usia</th><th>Status Verifikasi <br> Data SKUM</th><th>Tipe <br>Pengubahan</th><th>Pilih</th><th>Berkas Syarat</th></tr>";
                                        while ($oto = $query->fetch_array(MYSQLI_NUM)) {
                                            $i++;
                                            if ($label == "") {
                                                $label = $oto[2];
                                                echo "<tr><td colspan='9' style='background-color:#f7f8ef;text-align: center;color: blue; font-weight: bold;'>$oto[2]</td></tr>";
                                            } else {
                                                if ($label == $oto[2]) {
                                                    echo "";
                                                } else {
                                                    echo "<tr><td colspan='9' style='background-color:#f7f8ef;text-align: center;color: blue; font-weight: bold;'>$oto[2]</td></tr>";
                                                    $label = $oto[2];
                                                    $i = 1;
                                                }
                                            }
                                            echo "<tr>";
                                            echo "<td>$i.</td><td>$oto[3] <a href=\"javascript:void(0);\" onclick=\"ubahDataKeluarga($oto[0],$idp);\">
                                        <img src=\"images/pencil.png\" alt=\"Ubah Data Keluarga\" title='Ubah Data Keluarga' style=\"width:16px;height:16px;border:0;\"></a>
                                                </td><td>$oto[4],<br>$oto[5]</td>
                                                <td>$oto[8]</td><td>$oto[9]</td><td>$oto[10]<br>$oto[11]" . ($oto[12] == '' ? '' : ' Ket. ' . $oto[12]) . "</td>";
                                            $sql2 = "SELECT * FROM ptk_tipe_pengubahan WHERE id_status_keluarga = $oto[1]
                                                    ORDER BY kategori_pengubahan, tipe_pengubahan_tunjangan";
                                            $query2 = $mysqli->query($sql2);
                                            echo "<td><select id='optTipePengubahan$oto[0]' name='optTipePengubahan[]' class=\"form-control\" style='width: 140px;'>";
                                            echo("<option value=-1 selected>Silahkan Pilih</option>");
                                            while ($oto2 = $query2->fetch_array(MYSQLI_NUM)) {
                                                echo("<option value=$oto2[0]>$oto2[2] krn $oto2[1]</option>");
                                            }
                                            echo "</select></td>";
                                            echo "<td><input type=\"checkbox\" id='chkPilihKeluarga$oto[0]' name='chkPilihKeluarga[$e]' onchange=\"pilihKeluarga('$oto[8]','$oto[13]',document.getElementById('optTipePengubahan$oto[0]').value,'chkPilihKeluarga$oto[0]','$oto[14]','uploadFileSyarat$oto[0]','lblBerkas$oto[0]')\" value=\"$oto[0]\" style='margin-left:13px;'></label></td>";
                                            echo "<td>";
                                            echo "<div id='divBtnFile$oto[0]' class=\"fileUpload btn btn-default\" style='margin-top: -2px;text-align: center'>
                                                            <span id='judulFile$oto[0]'>Browse</span>
                                                            <input id=\"uploadFileSyarat$oto[0]\" name='uploadFileSyarat[$e]' type=\"file\" class=\"upload\" accept=\".pdf\" />
                                                        </div><br><span id='lblBerkas$oto[0]' style='margin-top: -10px;font-size: small;'></span>";
                                            ?>
                                            <script>
                                                document.getElementById("optTipePengubahan<?php echo $oto[0];?>").onchange = function () {
                                                    var $form = $('form[name="frmReqPTK"]');
                                                    $form.bootstrapValidator('disableSubmitButtons', false);
                                                    if (document.getElementById("chkPilihKeluarga<?php echo $oto[0];?>").checked) {
                                                        document.getElementById("chkPilihKeluarga<?php echo $oto[0];?>").checked = false;
                                                    }
                                                    document.getElementById("uploadFileSyarat<?php echo $oto[0];?>").disabled = true;
                                                    $("#judulFile<?php echo $oto[0];?>").text('Browse');
                                                    $('#lblBerkas<?php echo $oto[0];?>').html('');
                                                    $("#uploadFileSyarat<?php echo $oto[0];?>").val("");
                                                };

                                                document.getElementById("uploadFileSyarat<?php echo $oto[0];?>").disabled = true;

                                                $('#uploadFileSyarat<?php echo $oto[0];?>').bind('change', function () {
                                                    var $form = $('form[name="frmReqPTK"]');
                                                    $form.bootstrapValidator('disableSubmitButtons', false);
                                                    var fileUsulanSize<?php echo $oto[0];?> = 0;
                                                    fileUsulanSize<?php echo $oto[0];?> = this.files[0].size;
                                                    if (parseFloat(fileUsulanSize<?php echo $oto[0];?>) > 2138471) {
                                                        alert('Ukuran file terlalu besar');
                                                        $("#judulFile<?php echo $oto[0];?>").text('Browse');
                                                        $('#lblBerkas<?php echo $oto[0];?>').html('');
                                                        $("#uploadFileSyarat<?php echo $oto[0];?>").val("");
                                                        document.getElementById("chkPilihKeluarga<?php echo $oto[0];?>").checked = false;
                                                    } else {
                                                        $("#judulFile<?php echo $oto[0];?>").text('Satu File');
                                                        $("#lblBerkas<?php echo $oto[0];?>").css({'color': 'black'});
                                                    }
                                                });
                                                //document.getElementById("uploadFileSyarat<?php //echo $oto[0];?>").onchange = function () {};
                                            </script>
                                            <?php
                                            echo "</td>";
                                            echo "</tr>";
                                            $e++;
                                        }
                                        echo "</table>";
                                    }

                                    $sql = "SELECT COUNT(*) AS jumlah FROM keluarga k
                                           WHERE k.id_pegawai = $idp AND k.id_status = 9 AND
                                          (LOWER(k.pekerjaan) LIKE '%pns%'
                                           OR LOWER(k.pekerjaan) LIKE '%pegawai negeri sipil%'
                                           OR LOWER(k.pekerjaan) LIKE '%tni%'
                                           OR LOWER(k.pekerjaan) LIKE '%polri%'
                                           OR LOWER(k.pekerjaan) LIKE '%p n s%')";
                                            $qRekap2 = $mysqli->query($sql);
                                            while ($r2 = $qRekap2->fetch_array(MYSQLI_NUM)) {
                                                $jmlPasanganPNS = $r2[0];
                                            }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <input id="issubmit" name="issubmit" type="hidden" value="true"/>
                        <input type="submit" onclick="return confirm('Anda yakin akan menyimpan permohonan ini?');"
                               name="btnSimpanPTK" id="btnSimpanPTK" class="btn btn-primary"
                               value="Simpan" <?php echo(($jmlJiwaValid == "") ? "" : 'disabled'); ?> />
                        <span style="color: red"><?php echo(($jmlJiwaValid == "") ? "" : $jmlJiwaValid); ?></span>
                    </div>
                </div>
            </form>
            <br><br>
        </div>
        <div role="tabpanel" class="tab-pane <?php echo($issubmit == 'true' ? 'active' :
            ((isset($btnAjukanPtk) or isset($btnAjukanUlangPtk) or isset($btnBatalkanPtk)
                or isset($btnHapusPtk) or isset($btnUpdatePtk)) ? 'active' : '')); ?>" id="list_ptk">
            <?php
            if (isset($btnAjukanPtk)) {
                foreach ($btnAjukanPtk as $key => $n) {
                    $idptk = $key;
                }
                $sqlSkBerkas = "SELECT id_berkas_sk_pangkat_last, id_berkas_kk_last, id_berkas_pengajuan,
                                id_berkas_skum, id_berkas_daftar_gaji_last, id_berkas_daftar_gaji_pasangan_pns
                                FROM ptk_master WHERE id_ptk = $idptk";
                $query = $mysqli->query($sqlSkBerkas);
                if (isset($query)) {
                    if ($query->num_rows > 0) {
                        while ($berkas = $query->fetch_array(MYSQLI_NUM)) {
                            $idberkasSK = $berkas[0];
                            $idberkasKK = $berkas[1];
                            $idberkasUsul = $berkas[2];
                            $idberkasSKUM = $berkas[3];
                            $idberkasGaji = $berkas[4];
                            $idberkasGajiPasangan = $berkas[5];
                        }
                        if ($idberkasSK <> "") {
                            $sqlCekBerkas = "SELECT ib.file_name, b.created_by, DATE_FORMAT(b.created_date,  '%d/%m/%Y %H:%i:%s') AS created_date, p.nip_baru, p.nama, b.id_kat
                                FROM berkas b LEFT JOIN pegawai p ON b.created_by = p.id_pegawai, isi_berkas ib
                                WHERE b.id_berkas = ib.id_berkas AND b.id_berkas = $idberkasSK";
                            $query = $mysqli->query($sqlCekBerkas);
                            if (isset($query)) {
                                if ($query->num_rows > 0) {
                                    while ($berkas = $query->fetch_array(MYSQLI_NUM)) {
                                        $asli = basename($berkas[0]);
                                        //if (file_exists(str_replace("\\", "/", getcwd()) . '/berkas/' . trim($asli))) {
                                            $idberkasSK = $idberkasSK;
                                        //} else {
                                        //    $idberkasSK = 'NULL';
                                        //}
                                    }
                                }
                            }
                        } else {
                            $idberkasSK = 'NULL';
                        }

                        if ($idberkasKK <> "") {
                            $sqlCekBerkas = "SELECT ib.file_name, b.created_by, DATE_FORMAT(b.created_date,  '%d/%m/%Y %H:%i:%s') AS created_date, p.nip_baru, p.nama, b.id_kat
                                FROM berkas b LEFT JOIN pegawai p ON b.created_by = p.id_pegawai, isi_berkas ib
                                WHERE b.id_berkas = ib.id_berkas AND b.id_berkas = $idberkasKK";
                            $query = $mysqli->query($sqlCekBerkas);
                            if (isset($query)) {
                                if ($query->num_rows > 0) {
                                    while ($berkas = $query->fetch_array(MYSQLI_NUM)) {
                                        $asli = basename($berkas[0]);
                                        //if (file_exists(str_replace("\\", "/", getcwd()) . '/berkas/' . trim($asli))) {
                                            $idberkasKK = $idberkasKK;
                                        //} else {
                                        //    $idberkasKK = 'NULL';
                                        //}
                                    }
                                }
                            }
                        } else {
                            $idberkasKK = 'NULL';
                        }

                        if ($idberkasUsul <> "") {
                            $sqlCekBerkas = "SELECT ib.file_name, b.created_by, DATE_FORMAT(b.created_date,  '%d/%m/%Y %H:%i:%s') AS created_date, p.nip_baru, p.nama, b.id_kat
                                FROM berkas b LEFT JOIN pegawai p ON b.created_by = p.id_pegawai, isi_berkas ib
                                WHERE b.id_berkas = ib.id_berkas AND b.id_berkas = $idberkasUsul";
                            $query = $mysqli->query($sqlCekBerkas);
                            if (isset($query)) {
                                if ($query->num_rows > 0) {
                                    while ($berkas = $query->fetch_array(MYSQLI_NUM)) {
                                        $asli = basename($berkas[0]);
                                        //if (file_exists(str_replace("\\", "/", getcwd()) . '/berkas/' . trim($asli))) {
                                            $idberkasUsul = $idberkasUsul;
                                        //} else {
                                        //    $idberkasUsul = 'NULL';
                                        //}
                                    }
                                }
                            }
                        } else {
                            $idberkasUsul = 'NULL';
                        }

                        if ($idberkasSKUM <> "") {
                            $sqlCekBerkas = "SELECT ib.file_name, b.created_by, DATE_FORMAT(b.created_date,  '%d/%m/%Y %H:%i:%s') AS created_date, p.nip_baru, p.nama, b.id_kat
                                FROM berkas b LEFT JOIN pegawai p ON b.created_by = p.id_pegawai, isi_berkas ib
                                WHERE b.id_berkas = ib.id_berkas AND b.id_berkas = $idberkasSKUM";
                            $query = $mysqli->query($sqlCekBerkas);
                            if (isset($query)) {
                                if ($query->num_rows > 0) {
                                    while ($berkas = $query->fetch_array(MYSQLI_NUM)) {
                                        $asli = basename($berkas[0]);
                                        //if (file_exists(str_replace("\\", "/", getcwd()) . '/berkas/' . trim($asli))) {
                                            $idberkasSKUM = $idberkasSKUM;
                                        //} else {
                                        //    $idberkasSKUM = 'NULL';
                                        //}
                                    }
                                }
                            }
                        } else {
                            $idberkasSKUM = 'NULL';
                        }

                        if ($idberkasGaji <> "") {
                            $sqlCekBerkas = "SELECT ib.file_name, b.created_by, DATE_FORMAT(b.created_date,  '%d/%m/%Y %H:%i:%s') AS created_date, p.nip_baru, p.nama, b.id_kat
                                FROM berkas b LEFT JOIN pegawai p ON b.created_by = p.id_pegawai, isi_berkas ib
                                WHERE b.id_berkas = ib.id_berkas AND b.id_berkas = $idberkasGaji";
                            $query = $mysqli->query($sqlCekBerkas);
                            if (isset($query)) {
                                if ($query->num_rows > 0) {
                                    while ($berkas = $query->fetch_array(MYSQLI_NUM)) {
                                        $asli = basename($berkas[0]);
                                        //if (file_exists(str_replace("\\", "/", getcwd()) . '/berkas/' . trim($asli))) {
                                            $idberkasGaji = $idberkasGaji;
                                        //} else {
                                        //    $idberkasGaji = 'NULL';
                                        //}
                                    }
                                }
                            }
                        } else {
                            $idberkasGaji = 'NULL';
                        }

                        if ($idberkasGajiPasangan <> "") {
                            $sqlCekBerkas = "SELECT ib.file_name, b.created_by, DATE_FORMAT(b.created_date,  '%d/%m/%Y %H:%i:%s') AS created_date, p.nip_baru, p.nama, b.id_kat
                                FROM berkas b LEFT JOIN pegawai p ON b.created_by = p.id_pegawai, isi_berkas ib
                                WHERE b.id_berkas = ib.id_berkas AND b.id_berkas = $idberkasGajiPasangan";
                            $query = $mysqli->query($sqlCekBerkas);
                            if (isset($query)) {
                                if ($query->num_rows > 0) {
                                    while ($berkas = $query->fetch_array(MYSQLI_NUM)) {
                                        $asli = basename($berkas[0]);
                                        //if (file_exists(str_replace("\\", "/", getcwd()) . '/berkas/' . trim($asli))) {
                                            $idberkasGajiPasangan = $idberkasGajiPasangan;
                                        //} else {
                                        //    $idberkasGajiPasangan = 'NULL';
                                        //}
                                    }
                                }
                            }
                        } else {
                            $idberkasGajiPasangan = 'NULL';
                        }

                    } else {
                        $idberkasSK = 'NULL';
                        $idberkasKK = 'NULL';
                        $idberkasUsul = 'NULL';
                        $idberkasSKUM = 'NULL';
                        $idberkasGaji = 'NULL';
                        $idberkasGajiPasangan = 'NULL';
                    }
                } else {
                    $idberkasSK = 'NULL';
                    $idberkasKK = 'NULL';
                    $idberkasUsul = 'NULL';
                    $idberkasSKUM = 'NULL';
                    $idberkasGaji = 'NULL';
                    $idberkasGajiPasangan = 'NULL';
                }

                if(isset($_FILES["uploadFileSyaratPengantar$idptk"])){
                    $uploadfilePengantar = $uploaddir . basename($_FILES["uploadFileSyaratPengantar$idptk"]['name']);
                }
                if(isset($_FILES["uploadFileSyaratSkum$idptk"])){
                    $uploadfileSkum = $uploaddir . basename($_FILES["uploadFileSyaratSkum$idptk"]['name']);
                }
                if(isset($_FILES["uploadFileSyaratSK$idptk"])){
                    $uploadfileSK = $uploaddir . basename($_FILES["uploadFileSyaratSK$idptk"]['name']);
                }
                if(isset($_FILES["uploadFileSyaratGaji$idptk"])){
                    $uploadfileGaji = $uploaddir . basename($_FILES["uploadFileSyaratGaji$idptk"]['name']);
                }
                if(isset($_FILES["uploadFileSyaratKK$idptk"])){
                    $uploadfileKK = $uploaddir . basename($_FILES["uploadFileSyaratKK$idptk"]['name']);
                }
                if(isset($_FILES["uploadFileSyaratGajiPasangan$idptk"])){
                    $uploadfileGajiPasangan = $uploaddir . basename($_FILES["uploadFileSyaratGajiPasangan$idptk"]['name']);
                }

                $mysqli->autocommit(FALSE);
                if (isset($_FILES["uploadFileSyaratPengantar$idptk"])) {
                    if ($_FILES["uploadFileSyaratPengantar$idptk"]['name'] <> "") {
                      //  if (move_uploaded_file($_FILES["uploadFileSyaratPengantar$idptk"]['tmp_name'], $uploadfilePengantar)) {
                      if(ssh2_scp_send($connection, $_FILES["uploadFileSyaratPengantar$idptk"]['tmp_name'], $uploadfilePengantar, 0644)){
                            $sqlInsert = "insert into berkas (id_pegawai,id_kat,nm_berkas,tgl_upload,created_by,created_date,ket_berkas) " .
                                "values (" . $idp . ", 40,'Surat Pengantar dari OPD', DATE(NOW()), '" . $idp . "', NOW(), 'Surat Pengantar dari OPD')";
                            if ($mysqli->query($sqlInsert)) {
                                $last_id_berkas_usulan = $mysqli->insert_id;
                                $sqlInsertIsi = "insert into isi_berkas (id_berkas, ket) values ($last_id_berkas_usulan, 'Berkas Usulan PTK')";
                                if ($mysqli->query($sqlInsertIsi)) {
                                    $last_idisi = $mysqli->insert_id;
                                    $nf = $_SESSION['nip_baru'] . "-" . $last_id_berkas_usulan . "-" . $last_idisi . ".pdf";
                                    $sqlUpdateIsi = "update isi_berkas set file_name='$nf' where id_isi_berkas=$last_idisi";
                                    if ($mysqli->query($sqlUpdateIsi)) {
                                        //rename($uploadfilePengantar, "berkas/" . $nf);
                                        ssh2_sftp_rename($sftp, $uploadfilePengantar,$uploaddir.$nf);
                                        $sqlUpdate = "update ptk_master
                                            set id_berkas_pengajuan = $last_id_berkas_usulan where id_ptk=" . $idptk;
                                        if ($mysqli->query($sqlUpdate)) {
                                            $qryBerkas1 = 1;
                                            $upBerkas1 = 1;
                                            $mysqli->commit();
                                        } else {
                                            $qryBerkas1 = 0;
                                            $upBerkas1 = 1;
                                        }
                                    } else {
                                        $qryBerkas1 = 0;
                                        $upBerkas1 = 1;
                                    }
                                } else {
                                    $qryBerkas1 = 0;
                                    $upBerkas1 = 1;
                                }
                            } else {
                                $qryBerkas1 = 0;
                                $upBerkas1 = 1;
                            }
                        } else {
                            if ($idberkasUsul <> 'NULL') {
                                $qryBerkas1 = 1;
                                $upBerkas1 = 1;
                            } else {
                                $qryBerkas1 = 0;
                                $upBerkas1 = 0;
                            }
                        }
                    } else {
                        if ($idberkasUsul <> 'NULL') {
                            $qryBerkas1 = 1;
                            $upBerkas1 = 1;
                        } else {
                            $qryBerkas1 = 0;
                            $upBerkas1 = 0;
                        }
                    }
                } else {
                    if ($idberkasUsul <> 'NULL') {
                        $qryBerkas1 = 1;
                        $upBerkas1 = 1;
                    } else {
                        $qryBerkas1 = 0;
                        $upBerkas1 = 0;
                    }
                }

                $mysqli->autocommit(FALSE);
                if (isset($_FILES["uploadFileSyaratSkum$idptk"])) {
                    if ($_FILES["uploadFileSyaratSkum$idptk"]['name'] <> "") {
                      //  if (move_uploaded_file($_FILES["uploadFileSyaratSkum$idptk"]['tmp_name'], $uploadfileSkum)) {
                      if(ssh2_scp_send($connection, $_FILES["uploadFileSyaratSkum$idptk"]['tmp_name'], $uploadfileSkum, 0644)){
                            $sqlInsert = "insert into berkas (id_pegawai,id_kat,nm_berkas,tgl_upload,created_by,created_date,ket_berkas) " .
                                "values (" . $idp . ", 45,'SKUM', DATE(NOW()), '" . $idp . "', NOW(), 'SKUM')";
                            if ($mysqli->query($sqlInsert)) {
                                $last_id_berkas_skum = $mysqli->insert_id;
                                $sqlInsertIsi = "insert into isi_berkas (id_berkas, ket) values ($last_id_berkas_skum, 'SKUM')";
                                if ($mysqli->query($sqlInsertIsi)) {
                                    $last_idisi = $mysqli->insert_id;
                                    $nf = $_SESSION['nip_baru'] . "-" . $last_id_berkas_skum . "-" . $last_idisi . ".pdf";
                                    $sqlUpdateIsi = "update isi_berkas set file_name='$nf' where id_isi_berkas=$last_idisi";
                                    if ($mysqli->query($sqlUpdateIsi)) {
                                      //  rename($uploadfileSkum, "berkas/" . $nf);
                                      ssh2_sftp_rename($sftp, $uploadfileSkum,$uploaddir.$nf);
                                        $sqlUpdate = "update ptk_master
                                                        set id_berkas_skum = $last_id_berkas_skum where id_ptk=" . $idptk;
                                        if ($mysqli->query($sqlUpdate)) {
                                            $qryBerkas2 = 1;
                                            $upBerkas2 = 1;
                                            $mysqli->commit();
                                        } else {
                                            $qryBerkas2 = 0;
                                            $upBerkas2 = 1;
                                        }
                                    } else {
                                        $qryBerkas2 = 0;
                                        $upBerkas2 = 1;
                                    }
                                } else {
                                    $qryBerkas2 = 0;
                                    $upBerkas2 = 1;
                                }
                            } else {
                                $qryBerkas2 = 0;
                                $upBerkas2 = 1;
                            }
                        } else {
                            if ($idberkasSKUM <> 'NULL') {
                                $qryBerkas2 = 1;
                                $upBerkas2 = 1;
                            } else {
                                $qryBerkas2 = 0;
                                $upBerkas2 = 0;
                            }
                        }
                    } else {
                        if ($idberkasSKUM <> 'NULL') {
                            $qryBerkas2 = 1;
                            $upBerkas2 = 1;
                        } else {
                            $qryBerkas2 = 0;
                            $upBerkas2 = 0;
                        }
                    }
                } else {
                    if ($idberkasSKUM <> 'NULL') {
                        $qryBerkas2 = 1;
                        $upBerkas2 = 1;
                    } else {
                        $qryBerkas2 = 0;
                        $upBerkas2 = 0;
                    }
                }

                $mysqli->autocommit(FALSE);
                if (isset($_FILES["uploadFileSyaratSK$idptk"]) or $idberkasSK <> 'NULL') {
                    if ((isset($_FILES["uploadFileSyaratSK$idptk"]) and $_FILES["uploadFileSyaratSK$idptk"]['name'] <> "") or $idberkasSK <> 'NULL') {
                      //  if (move_uploaded_file(isset($_FILES["uploadFileSyaratSK$idptk"])?$_FILES["uploadFileSyaratSK$idptk"]['tmp_name']:'', isset($uploadfileSK)?$uploadfileSK:'') or $idberkasSK <> 'NULL') {
                        if(ssh2_scp_send($connection, $_FILES["uploadFileSyaratSK$idptk"]?$_FILES["uploadFileSyaratSK$idptk"]['tmp_name']:'', isset($uploadfileSK)?$uploadfileSK:'', 0644) or $idberkasSK <> 'NULL'){
                            if ($idberkasSK == 'NULL') {
                                $sqlInsert = "insert into berkas (id_pegawai,id_kat,nm_berkas,tgl_upload,created_by,created_date,ket_berkas) " .
                                    "values (" . $idp . ", 2,'SK Pangkat Terakhir', DATE(NOW()), '" . $idp . "', NOW(), 'SK Pangkat Terakhir')";
                                if ($mysqli->query($sqlInsert)) {
                                    $last_id_berkas_sk = $mysqli->insert_id;
                                    $sqlInsertIsi = "insert into isi_berkas (id_berkas, ket) values ($last_id_berkas_sk, 'SK Pangkat Terakhir')";
                                    if ($mysqli->query($sqlInsertIsi)) {
                                        $last_idisi = $mysqli->insert_id;
                                        $nf = $_SESSION['nip_baru'] . "-" . $last_id_berkas_sk . "-" . $last_idisi . ".pdf";
                                        $sqlUpdateIsi = "update isi_berkas set file_name='$nf' where id_isi_berkas=$last_idisi";
                                        if ($mysqli->query($sqlUpdateIsi)) {
                                            //rename($uploadfileSK, "berkas/" . $nf);
                                            ssh2_sftp_rename($sftp, $uploadfileSK,$uploaddir.$nf);
                                            $sqlUpdate = "update ptk_master
                                                        set id_berkas_sk_pangkat_last = $last_id_berkas_sk where id_ptk=" . $idptk;
                                            if ($mysqli->query($sqlUpdate)) {
                                                $qryBerkas3 = 1;
                                                $upBerkas3 = 1;
                                                $mysqli->commit();
                                            } else {
                                                $qryBerkas3 = 0;
                                                $upBerkas3 = 1;
                                            }
                                        } else {
                                            $qryBerkas3 = 0;
                                            $upBerkas3 = 1;
                                        }
                                    } else {
                                        $qryBerkas3 = 0;
                                        $upBerkas3 = 1;
                                    }
                                } else {
                                    $qryBerkas3 = 0;
                                    $upBerkas3 = 1;
                                }
                            } else {
                                $qryBerkas3 = 1;
                                $upBerkas3 = 1;
                            }
                        } else {
                            if ($idberkasSK <> 'NULL') {
                                $qryBerkas3 = 1;
                                $upBerkas3 = 1;
                            } else {
                                $qryBerkas3 = 0;
                                $upBerkas3 = 0;
                            }
                        }
                    } else {
                        if ($idberkasSK <> 'NULL') {
                            $qryBerkas3 = 1;
                            $upBerkas3 = 1;
                        } else {
                            $qryBerkas3 = 0;
                            $upBerkas3 = 0;
                        }
                    }
                } else {
                    if ($idberkasSK <> 'NULL') {
                        $qryBerkas3 = 1;
                        $upBerkas3 = 1;
                    } else {
                        $qryBerkas3 = 0;
                        $upBerkas3 = 0;
                    }
                }

                $mysqli->autocommit(FALSE);
                if (isset($_FILES["uploadFileSyaratGaji$idptk"])) {
                    if ($_FILES["uploadFileSyaratGaji$idptk"]['name'] <> "") {
                      //  if (move_uploaded_file($_FILES["uploadFileSyaratGaji$idptk"]['tmp_name'], $uploadfileGaji)) {
                        if(ssh2_scp_send($connection, $_FILES["uploadFileSyaratGaji$idptk"]['tmp_name'], $uploadfileGaji, 0644)){
                            $sqlInsert = "insert into berkas (id_pegawai,id_kat,nm_berkas,tgl_upload,created_by,created_date,ket_berkas) " .
                                "values (" . $idp . ", 46,'Daftar Gaji', DATE(NOW()), '" . $idp . "', NOW(), 'Daftar Gaji')";
                            if ($mysqli->query($sqlInsert)) {
                                $last_id_berkas_gaji = $mysqli->insert_id;
                                $sqlInsertIsi = "insert into isi_berkas (id_berkas, ket) values ($last_id_berkas_gaji, 'Daftar Gaji')";
                                if ($mysqli->query($sqlInsertIsi)) {
                                    $last_idisi = $mysqli->insert_id;
                                    $nf = $_SESSION['nip_baru'] . "-" . $last_id_berkas_gaji . "-" . $last_idisi . ".pdf";
                                    $sqlUpdateIsi = "update isi_berkas set file_name='$nf' where id_isi_berkas=$last_idisi";
                                    if ($mysqli->query($sqlUpdateIsi)) {
                                        //rename($uploadfileGaji, "berkas/" . $nf);
                                        ssh2_sftp_rename($sftp, $uploadfileGaji,$uploaddir.$nf);
                                        $sqlUpdate = "update ptk_master
                                                        set id_berkas_daftar_gaji_last = $last_id_berkas_gaji where id_ptk=" . $idptk;
                                        if ($mysqli->query($sqlUpdate)) {
                                            $qryBerkas4 = 1;
                                            $upBerkas4 = 1;
                                            $mysqli->commit();
                                        } else {
                                            $qryBerkas4 = 0;
                                            $upBerkas4 = 1;
                                        }
                                    } else {
                                        $qryBerkas4 = 0;
                                        $upBerkas4 = 1;
                                    }
                                } else {
                                    $qryBerkas4 = 0;
                                    $upBerkas4 = 1;
                                }
                            } else {
                                $qryBerkas4 = 0;
                                $upBerkas4 = 1;
                            }
                        } else {
                            if ($idberkasGaji <> 'NULL') {
                                $qryBerkas4 = 1;
                                $upBerkas4 = 1;
                            } else {
                                $qryBerkas4 = 0;
                                $upBerkas4 = 0;
                            }
                        }
                    } else {
                        if ($idberkasGaji <> 'NULL') {
                            $qryBerkas4 = 1;
                            $upBerkas4 = 1;
                        } else {
                            $qryBerkas4 = 0;
                            $upBerkas4 = 0;
                        }
                    }
                } else {
                    if ($idberkasGaji <> 'NULL') {
                        $qryBerkas4 = 1;
                        $upBerkas4 = 1;
                    } else {
                        $qryBerkas4 = 0;
                        $upBerkas4 = 0;
                    }
                }

                $mysqli->autocommit(FALSE);
                if (isset($_FILES["uploadFileSyaratKK$idptk"]) or $idberkasKK <> 'NULL') {
                    if ($_FILES["uploadFileSyaratKK$idptk"]['name'] <> "" or $idberkasKK <> 'NULL') {
                      //  if ((move_uploaded_file($_FILES["uploadFileSyaratKK$idptk"]['tmp_name'], $uploadfileKK) or $idberkasKK <> 'NULL')) {
                        if(ssh2_scp_send($connection, $_FILES["uploadFileSyaratKK$idptk"]['tmp_name'],$uploadfileKK, 0644) or $idberkasKK <> 'NULL'){
                            if ($idberkasKK == 'NULL') {
                                $sqlInsert = "insert into berkas (id_pegawai,id_kat,nm_berkas,tgl_upload,created_by,created_date,ket_berkas) " .
                                    "values (" . $idp . ", 14,'Kartu Keluarga', DATE(NOW()), '" . $idp . "', NOW(), 'Kartu Keluarga')";
                                if ($mysqli->query($sqlInsert)) {
                                    $last_id_berkas_kk = $mysqli->insert_id;
                                    $sqlInsertIsi = "insert into isi_berkas (id_berkas, ket) values ($last_id_berkas_kk, 'Kartu Keluarga')";
                                    if ($mysqli->query($sqlInsertIsi)) {
                                        $last_idisi = $mysqli->insert_id;
                                        $nf = $_SESSION['nip_baru'] . "-" . $last_id_berkas_kk . "-" . $last_idisi . ".pdf";
                                        $sqlUpdateIsi = "update isi_berkas set file_name='$nf' where id_isi_berkas=$last_idisi";
                                        if ($mysqli->query($sqlUpdateIsi)) {
                                            //rename($uploadfileKK, "berkas/" . $nf);
                                            ssh2_sftp_rename($sftp, $uploadfileKK,$uploaddir.$nf);
                                            $sqlUpdate = "update ptk_master
                                                        set id_berkas_kk_last = $last_id_berkas_kk where id_ptk=" . $idptk;
                                            if ($mysqli->query($sqlUpdate)) {
                                                $qryBerkas5 = 1;
                                                $upBerkas5 = 1;
                                                $mysqli->commit();
                                            } else {
                                                $qryBerkas5 = 0;
                                                $upBerkas5 = 1;
                                            }
                                        } else {
                                            $qryBerkas5 = 0;
                                            $upBerkas5 = 1;
                                        }
                                    } else {
                                        $qryBerkas5 = 0;
                                        $upBerkas5 = 1;
                                    }
                                } else {
                                    $qryBerkas5 = 0;
                                    $upBerkas5 = 1;
                                }
                            } else {
                                $qryBerkas5 = 1;
                                $upBerkas5 = 1;
                            }
                        } else {
                            if ($idberkasKK <> 'NULL') {
                                $qryBerkas5 = 1;
                                $upBerkas5 = 1;
                            } else {
                                $qryBerkas5 = 0;
                                $upBerkas5 = 0;
                            }
                        }
                    } else {
                        if ($idberkasKK <> 'NULL') {
                            $qryBerkas5 = 1;
                            $upBerkas5 = 1;
                        } else {
                            $qryBerkas5 = 0;
                            $upBerkas5 = 0;
                        }
                    }
                } else {
                    if ($idberkasKK <> 'NULL') {
                        $qryBerkas5 = 1;
                        $upBerkas5 = 1;
                    } else {
                        $qryBerkas5 = 0;
                        $upBerkas5 = 0;
                    }
                }

                /* Pasangan PNS */
                /* ================ */
                /*$sql = "SELECT COUNT(*) AS jumlah
                        FROM ptk_keluarga pk
                        WHERE pk.id_ptk = $idptk AND (LOWER(pk.last_pekerjaan) = 'pns'
                        OR LOWER(pk.last_pekerjaan) = 'pegawai negeri sipil'
                        OR LOWER(pk.last_pekerjaan) = 'tni'
                        OR LOWER(pk.last_pekerjaan) = 'polri') AND pk.last_id_status_keluarga = 9";
                $qRekap = $mysqli->query($sql);
                while ($r = $qRekap->fetch_array(MYSQLI_NUM)) {
                    $jmlPasanganPNS = $r[0];
                }*/

                if($jmlPasanganPNS > 0){
                    $mysqli->autocommit(FALSE);
                    if (isset($_FILES["uploadFileSyaratGajiPasangan$idptk"])) {
                        if ($_FILES["uploadFileSyaratGajiPasangan$idptk"]['name'] <> "") {
                            //if (move_uploaded_file($_FILES["uploadFileSyaratGajiPasangan$idptk"]['tmp_name'], $uploadfileGajiPasangan)) {
                            if(ssh2_scp_send($connection, $_FILES["uploadFileSyaratGajiPasangan$idptk"]['tmp_name'], $uploadfileGajiPasangan, 0644)){
                                $sqlInsert = "insert into berkas (id_pegawai,id_kat,nm_berkas,tgl_upload,created_by,created_date,ket_berkas) " .
                                    "values (" . $idp . ", 52,'Daftar Gaji Pasangan PNS/TNI/POLRI', DATE(NOW()), '" . $idp . "', NOW(), 'Daftar Gaji Pasangan PNS/TNI/POLRI')";
                                if ($mysqli->query($sqlInsert)) {
                                    $last_id_berkas_gaji = $mysqli->insert_id;
                                    $sqlInsertIsi = "insert into isi_berkas (id_berkas, ket) values ($last_id_berkas_gaji, 'Daftar Gaji Pasangan PNS/TNI/POLRI')";
                                    if ($mysqli->query($sqlInsertIsi)) {
                                        $last_idisi = $mysqli->insert_id;
                                        $nf = $_SESSION['nip_baru'] . "-" . $last_id_berkas_gaji . "-" . $last_idisi . ".pdf";
                                        $sqlUpdateIsi = "update isi_berkas set file_name='$nf' where id_isi_berkas=$last_idisi";
                                        if ($mysqli->query($sqlUpdateIsi)) {
                                            //rename($uploadfileGajiPasangan, "berkas/" . $nf);
                                            ssh2_sftp_rename($sftp, $uploadfileGajiPasangan,$uploaddir.$nf);
                                            $sqlUpdate = "update ptk_master
                                                        set id_berkas_daftar_gaji_pasangan_pns = $last_id_berkas_gaji where id_ptk=" . $idptk;
                                            if ($mysqli->query($sqlUpdate)) {
                                                $qryBerkas6 = 1;
                                                $upBerkas6 = 1;
                                                $mysqli->commit();
                                            } else {
                                                $qryBerkas6 = 0;
                                                $upBerkas6 = 1;
                                            }
                                        } else {
                                            $qryBerkas6 = 0;
                                            $upBerkas6 = 1;
                                        }
                                    } else {
                                        $qryBerkas6 = 0;
                                        $upBerkas6 = 1;
                                    }
                                } else {
                                    $qryBerkas6 = 0;
                                    $upBerkas6 = 1;
                                }
                            } else {
                                if ($idberkasGajiPasangan <> 'NULL') {
                                    $qryBerkas6 = 1;
                                    $upBerkas6 = 1;
                                } else {
                                    $qryBerkas6 = 0;
                                    $upBerkas6 = 0;
                                }
                            }
                        } else {
                            if ($idberkasGajiPasangan <> 'NULL') {
                                $qryBerkas6 = 1;
                                $upBerkas6 = 1;
                            } else {
                                $qryBerkas6 = 0;
                                $upBerkas6 = 0;
                            }
                        }
                    } else {
                        if ($idberkasGajiPasangan <> 'NULL') {
                            $qryBerkas6 = 1;
                            $upBerkas6 = 1;
                        } else {
                            $qryBerkas6 = 0;
                            $upBerkas6 = 0;
                        }
                    }
                }else{
                    $upBerkas6 = 1;
                    $qryBerkas6 = 1;
                }

                $mysqli->autocommit(FALSE);
                if ($upBerkas1 == 1 and $upBerkas2 == 1 and $upBerkas3 == 1 and $upBerkas4 == 1 and $upBerkas5 == 1 and $upBerkas6 == 1) {
                    if ($qryBerkas1 == 1 and $qryBerkas2 == 1 and $qryBerkas3 == 1 and $qryBerkas4 == 1 and $qryBerkas5 == 1 and $qryBerkas6 == 1) {
                        $sqlInsert_Approved_Hist = "INSERT INTO ptk_historis_approve(tgl_approve_hist, approved_by_hist, id_status_ptk, approved_note_hist, id_ptk)
                            VALUES (NOW()," . $idp . ",2,'" . $txtCatatan[$idptk] . "'," . $idptk . ")";
                        if ($mysqli->query($sqlInsert_Approved_Hist) == TRUE) {
                            $sqlUpdatePtk = "UPDATE ptk_master set idstatus_ptk=2, tgl_approve=NOW(),
                                    approved_by=" . $idp . ",approved_note= '" . $txtCatatan[$idptk] . "'
                                    where id_ptk=" . $idptk;
                            if ($mysqli->query($sqlUpdatePtk) == TRUE) {
                                $mysqli->commit();
                                echo("<div align=center style='background-color: #83c868;font-weight: bold;color: #ffffff; padding-top: 5px;padding-bottom: 5px;'> Pengajuan Pengubahan Tunjangan Keluarga Berhasil Terkirim </div>");
                            } else {
                                $mysqli->rollback();
                                echo("<div align=center style='background-color:#c8271b;font-weight: bold;color: #ffffff; padding-top: 5px;padding-bottom: 5px;'> Error: Tidak dapat menyimpan data. Silahkan coba lagi." . "<br></div>");
                            }
                        }else{
                            echo("<div align=center style='background-color:#c8271b;font-weight: bold;color: #ffffff; padding-top: 5px;padding-bottom: 5px;'> Error: Tidak dapat menyimpan data. Silahkan coba lagi." . "<br></div>");
                        }
                    } else {
                        echo("<div align=center style='background-color:#c8271b;font-weight: bold;color: #ffffff; padding-top: 5px;padding-bottom: 5px;'>Terdapat data yang tidak tersimpan atau ada persyaratan yang tidak terupload. </div>");
                    }
                } else {
                    echo("<div align=center style='background-color:#c8271b;font-weight: bold;color: #ffffff; padding-top: 5px;padding-bottom: 5px;'>Lengkapi dahulu berkas persyaratan</div>");
                    //echo("<div align=center style='background-color:#c8271b;font-weight: bold;color: #ffffff; padding-top: 5px;padding-bottom: 5px;'>Ada perbaikan aplikasi. Silahkan coba lagi nanti.</div>");
                }
            }

            if (isset($btnAjukanUlangPtk)) {
                foreach ($btnAjukanUlangPtk as $key => $n) {
                    $idptk = $key;
                }

                $sqlSkBerkas = "SELECT id_berkas_sk_pangkat_last, id_berkas_kk_last, id_berkas_pengajuan,
                                id_berkas_skum, id_berkas_daftar_gaji_last, id_berkas_daftar_gaji_pasangan_pns
                                FROM ptk_master WHERE id_ptk = $idptk";
                $query = $mysqli->query($sqlSkBerkas);
                if (isset($query)) {
                    if ($query->num_rows > 0) {
                        while ($berkas = $query->fetch_array(MYSQLI_NUM)) {
                            $idberkasSK = ($berkas[0] == '' ? 'NULL' : $berkas[0]);
                            $idberkasKK = ($berkas[1] == '' ? 'NULL' : $berkas[1]);
                            $idberkasUsul = ($berkas[2] == '' ? 'NULL' : $berkas[2]);
                            $idberkasSKUM = ($berkas[3] == '' ? 'NULL' : $berkas[3]);
                            $idberkasGaji = ($berkas[4] == '' ? 'NULL' : $berkas[4]);
                            $idberkasGajiPasangan = ($berkas[5] == '' ? 'NULL' : $berkas[5]);

                            if ($idberkasSK <> "NULL") {
                                $sqlCekBerkas = "SELECT ib.file_name, b.created_by, DATE_FORMAT(b.created_date,  '%d/%m/%Y %H:%i:%s') AS created_date, p.nip_baru, p.nama, b.id_kat
                                FROM berkas b LEFT JOIN pegawai p ON b.created_by = p.id_pegawai, isi_berkas ib
                                WHERE b.id_berkas = ib.id_berkas AND b.id_berkas = $idberkasSK";
                                $query = $mysqli->query($sqlCekBerkas);
                                if (isset($query)) {
                                    if ($query->num_rows > 0) {
                                        while ($berkas = $query->fetch_array(MYSQLI_NUM)) {
                                            $asli = basename($berkas[0]);
                                            //if (file_exists(str_replace("\\", "/", getcwd()) . '/berkas/' . trim($asli))) {
                                                $idberkasSK = $idberkasSK;
                                            //} else {
                                            //    $idberkasSK = 'NULL';
                                            //}
                                        }
                                    }
                                }
                            } else {
                                $idberkasSK = 'NULL';
                            }

                            if ($idberkasKK <> "NULL") {
                                $sqlCekBerkas = "SELECT ib.file_name, b.created_by, DATE_FORMAT(b.created_date,  '%d/%m/%Y %H:%i:%s') AS created_date, p.nip_baru, p.nama, b.id_kat
                                FROM berkas b LEFT JOIN pegawai p ON b.created_by = p.id_pegawai, isi_berkas ib
                                WHERE b.id_berkas = ib.id_berkas AND b.id_berkas = $idberkasKK";
                                $query = $mysqli->query($sqlCekBerkas);
                                if (isset($query)) {
                                    if ($query->num_rows > 0) {
                                        while ($berkas = $query->fetch_array(MYSQLI_NUM)) {
                                            $asli = basename($berkas[0]);
                                            //if (file_exists(str_replace("\\", "/", getcwd()) . '/berkas/' . trim($asli))) {
                                                $idberkasKK = $idberkasKK;
                                            //} else {
                                            //    $idberkasKK = 'NULL';
                                            //}
                                        }
                                    }
                                }
                            } else {
                                $idberkasKK = 'NULL';
                            }

                            if ($idberkasUsul <> "NULL") {
                                $sqlCekBerkas = "SELECT ib.file_name, b.created_by, DATE_FORMAT(b.created_date,  '%d/%m/%Y %H:%i:%s') AS created_date, p.nip_baru, p.nama, b.id_kat
                                FROM berkas b LEFT JOIN pegawai p ON b.created_by = p.id_pegawai, isi_berkas ib
                                WHERE b.id_berkas = ib.id_berkas AND b.id_berkas = $idberkasUsul";
                                $query = $mysqli->query($sqlCekBerkas);
                                if (isset($query)) {
                                    if ($query->num_rows > 0) {
                                        while ($berkas = $query->fetch_array(MYSQLI_NUM)) {
                                            $asli = basename($berkas[0]);
                                            //if (file_exists(str_replace("\\", "/", getcwd()) . '/berkas/' . trim($asli))) {
                                                $idberkasUsul = $idberkasUsul;
                                            //} else {
                                            //    $idberkasUsul = 'NULL';
                                            //}
                                        }
                                    }
                                }
                            } else {
                                $idberkasUsul = 'NULL';
                            }

                            if ($idberkasSKUM <> "NULL") {
                                $sqlCekBerkas = "SELECT ib.file_name, b.created_by, DATE_FORMAT(b.created_date,  '%d/%m/%Y %H:%i:%s') AS created_date, p.nip_baru, p.nama, b.id_kat
                                FROM berkas b LEFT JOIN pegawai p ON b.created_by = p.id_pegawai, isi_berkas ib
                                WHERE b.id_berkas = ib.id_berkas AND b.id_berkas = $idberkasSKUM";
                                $query = $mysqli->query($sqlCekBerkas);
                                if (isset($query)) {
                                    if ($query->num_rows > 0) {
                                        while ($berkas = $query->fetch_array(MYSQLI_NUM)) {
                                            $asli = basename($berkas[0]);
                                            //if (file_exists(str_replace("\\", "/", getcwd()) . '/berkas/' . trim($asli))) {
                                                $idberkasSKUM = $idberkasSKUM;
                                            //} else {
                                            //    $idberkasSKUM = 'NULL';
                                            //}
                                        }
                                    }
                                }
                            } else {
                                $idberkasSKUM = 'NULL';
                            }

                            if ($idberkasGaji <> "NULL") {
                                $sqlCekBerkas = "SELECT ib.file_name, b.created_by, DATE_FORMAT(b.created_date,  '%d/%m/%Y %H:%i:%s') AS created_date, p.nip_baru, p.nama, b.id_kat
                                FROM berkas b LEFT JOIN pegawai p ON b.created_by = p.id_pegawai, isi_berkas ib
                                WHERE b.id_berkas = ib.id_berkas AND b.id_berkas = $idberkasGaji";
                                $query = $mysqli->query($sqlCekBerkas);
                                if (isset($query)) {
                                    if ($query->num_rows > 0) {
                                        while ($berkas = $query->fetch_array(MYSQLI_NUM)) {
                                            $asli = basename($berkas[0]);
                                            //if (file_exists(str_replace("\\", "/", getcwd()) . '/berkas/' . trim($asli))) {
                                                $idberkasGaji = $idberkasGaji;
                                            //} else {
                                            //    $idberkasGaji = 'NULL';
                                            //}
                                        }
                                    }
                                }
                            } else {
                                $idberkasGaji = 'NULL';
                            }

                            if ($idberkasGajiPasangan <> "NULL") {
                                $sqlCekBerkas = "SELECT ib.file_name, b.created_by, DATE_FORMAT(b.created_date,  '%d/%m/%Y %H:%i:%s') AS created_date, p.nip_baru, p.nama, b.id_kat
                                FROM berkas b LEFT JOIN pegawai p ON b.created_by = p.id_pegawai, isi_berkas ib
                                WHERE b.id_berkas = ib.id_berkas AND b.id_berkas = $idberkasGajiPasangan";
                                $query = $mysqli->query($sqlCekBerkas);
                                if (isset($query)) {
                                    if ($query->num_rows > 0) {
                                        while ($berkas = $query->fetch_array(MYSQLI_NUM)) {
                                            $asli = basename($berkas[0]);
                                            //if (file_exists(str_replace("\\", "/", getcwd()) . '/berkas/' . trim($asli))) {
                                                $idberkasGajiPasangan = $idberkasGajiPasangan;
                                            //} else {
                                            //    $idberkasGajiPasangan = 'NULL';
                                            //}
                                        }
                                    }
                                }
                            } else {
                                $idberkasGajiPasangan = 'NULL';
                            }

                        }
                    } else {
                        $idberkasSK = 'NULL';
                        $idberkasKK = 'NULL';
                        $idberkasUsul = 'NULL';
                        $idberkasSKUM = 'NULL';
                        $idberkasGaji = 'NULL';
                        $idberkasGajiPasangan = 'NULL';
                    }
                } else {
                    $idberkasSK = 'NULL';
                    $idberkasKK = 'NULL';
                    $idberkasUsul = 'NULL';
                    $idberkasSKUM = 'NULL';
                    $idberkasGaji = 'NULL';
                    $idberkasGajiPasangan = 'NULL';
                }

                //echo $idberkasSK.'-'.$idberkasKK.'-'.$idberkasUsul.'-'.$idberkasSKUM.'-'.$idberkasGaji.'-';

                $mysqli->autocommit(FALSE);
                $qryBerkasPtk = 1;
                $upBerkasPtk = 1;
                if ($_FILES['uploadFilePTK' . $idptk]) {
                    $file_ary_ptk = $_FILES['uploadFilePTK' . $idptk];
                    foreach ($file_ary_ptk['name'] as $key => $n) {
                        if ($file_ary_ptk['name'][$key] != '') { //ekos
                            if ($file_ary_ptk['type'][$key] == 'binary/octet-stream' or $file_ary_ptk['type'][$key] == "application/pdf") {
                                $uploadfile = $uploaddir . basename($file_ary_ptk['name'][$key]);
                              //  if (move_uploaded_file($file_ary_ptk['tmp_name'][$key], $uploadfile)) {
                              if(ssh2_scp_send($connection, $file_ary_ptk['tmp_name'][$key], $uploadfile, 0644)){
                                    $key = explode('-', $key); //[0] = ptk_syarat, [1] = kat_berkas
                                    $sql = "SELECT * FROM kat_berkas kb
                                                WHERE id_kat_berkas = " . $key[1];
                                    $qryBerkas = $mysqli->query($sql);
                                    while ($d = $qryBerkas->fetch_array(MYSQLI_NUM)) {
                                        $idkat_berkas = $d[0];
                                        $nm_berkas = $d[1];
                                    }
                                    $sqlInsertBerkas = "insert into berkas (id_pegawai,id_kat,nm_berkas,tgl_upload,created_by,created_date,ket_berkas) " .
                                        "values (" . $idp . ",$idkat_berkas,'$nm_berkas',DATE(NOW()),'" . $idp . "',NOW()," . $key[0] . ")";
                                    if ($mysqli->query($sqlInsertBerkas)) {
                                        $last_id_berkas = $mysqli->insert_id;
                                        $sqlUpdateBerkas = "update ptk_syarat set id_berkas_syarat = $last_id_berkas where id_syarat=" . $key[0];
                                        if ($mysqli->query($sqlUpdateBerkas)) {
                                            $sqlInsertIsi = "insert into isi_berkas (id_berkas, ket) values ($last_id_berkas, '$nm_berkas')";
                                            if ($mysqli->query($sqlInsertIsi)) {
                                                $last_idisi = $mysqli->insert_id;
                                                $nf = $_SESSION['nip_baru'] . "-" . $last_id_berkas . "-" . $last_idisi . ".pdf";
                                                $sqlUpdateIsi = "update isi_berkas set file_name='$nf' where id_isi_berkas=$last_idisi";
                                                if ($mysqli->query($sqlUpdateIsi)) {
                                                  //  rename($uploadfile, "berkas/" . $nf);
                                                  ssh2_sftp_rename($sftp, $uploadfile,$uploaddir.$nf);
                                                    $qryBerkasPtk = 1;
                                                    $upBerkasPtk = 1;
                                                } else {
                                                    $qryBerkasPtk = 0;
                                                    $upBerkasPtk = 0;
                                                    break;
                                                }
                                            } else {
                                                $qryBerkasPtk = 0;
                                                $upBerkasPtk = 0;
                                                break;
                                            }
                                        } else {
                                            $qryBerkasPtk = 0;
                                            $upBerkasPtk = 0;
                                            break;
                                        }
                                    } else {
                                        $qryBerkasPtk = 0;
                                        $upBerkasPtk = 0;
                                        break;
                                    }
                                } else {
                                    $qryBerkasPtk = 0;
                                    $upBerkasPtk = 0;
                                    break;
                                }
                            } else {
                                $qryBerkasPtk = 0;
                                $upBerkasPtk = 0;
                                break;
                            }
                        } else {
                            $qryBerkasPtk = 1;
                            $upBerkasPtk = 1;
                        }
                    }
                } else {
                    $qryBerkasPtk = 1;
                    $upBerkasPtk = 1;
                }

                if(isset($_FILES["uploadFileSyaratPengantar$idptk"])){
                    $uploadfilePengantar = $uploaddir . basename($_FILES["uploadFileSyaratPengantar$idptk"]['name']);
                }
                if(isset($_FILES["uploadFileSyaratSkum$idptk"])){
                    $uploadfileSkum = $uploaddir . basename($_FILES["uploadFileSyaratSkum$idptk"]['name']);
                }
                if(isset($_FILES["uploadFileSyaratSK$idptk"])){
                    $uploadfileSK = $uploaddir . basename($_FILES["uploadFileSyaratSK$idptk"]['name']);
                }
                if(isset($_FILES["uploadFileSyaratGaji$idptk"])){
                    $uploadfileGaji = $uploaddir . basename($_FILES["uploadFileSyaratGaji$idptk"]['name']);
                }
                if(isset($_FILES["uploadFileSyaratKK$idptk"])){
                    $uploadfileKK = $uploaddir . basename($_FILES["uploadFileSyaratKK$idptk"]['name']);
                }
                if(isset($_FILES["uploadFileSyaratGajiPasangan$idptk"])){
                    $uploadfileGajiPasangan = $uploaddir . basename($_FILES["uploadFileSyaratGajiPasangan$idptk"]['name']);
                }

                if (isset($_FILES["uploadFileSyaratPengantar$idptk"])) {
                    if ($_FILES["uploadFileSyaratPengantar$idptk"]['name'] <> "") {
                        //if (move_uploaded_file($_FILES["uploadFileSyaratPengantar$idptk"]['tmp_name'], $uploadfilePengantar)) {
                        if(ssh2_scp_send($connection, $_FILES["uploadFileSyaratPengantar$idptk"]['tmp_name'], $uploadfilePengantar, 0644)){
                            $sqlInsert = "insert into berkas (id_pegawai,id_kat,nm_berkas,tgl_upload,created_by,created_date,ket_berkas) " .
                                "values (" . $idp . ", 40,'Surat Pengantar dari OPD', DATE(NOW()), '" . $idp . "', NOW(), 'Surat Pengantar dari OPD')";
                            if ($mysqli->query($sqlInsert)) {
                                $last_id_berkas_usulan = $mysqli->insert_id;
                                $sqlInsertIsi = "insert into isi_berkas (id_berkas, ket) values ($last_id_berkas_usulan, 'Berkas Usulan PTK')";
                                if ($mysqli->query($sqlInsertIsi)) {
                                    $last_idisi = $mysqli->insert_id;
                                    $nf = $_SESSION['nip_baru'] . "-" . $last_id_berkas_usulan . "-" . $last_idisi . ".pdf";
                                    $sqlUpdateIsi = "update isi_berkas set file_name='$nf' where id_isi_berkas=$last_idisi";
                                    if ($mysqli->query($sqlUpdateIsi)) {
                                        //rename($uploadfilePengantar, "berkas/" . $nf);
                                        ssh2_sftp_rename($sftp, $uploadfilePengantar,$uploaddir.$nf);
                                        $sqlUpdate = "update ptk_master
                                            set id_berkas_pengajuan = $last_id_berkas_usulan where id_ptk=" . $idptk;
                                        if ($mysqli->query($sqlUpdate)) {
                                            $qryBerkas1 = 1;
                                            $upBerkas1 = 1;
                                        } else {
                                            $qryBerkas1 = 0;
                                            $upBerkas1 = 1;
                                        }
                                    } else {
                                        $qryBerkas1 = 0;
                                        $upBerkas1 = 1;
                                    }
                                } else {
                                    $qryBerkas1 = 0;
                                    $upBerkas1 = 1;
                                }
                            } else {
                                $qryBerkas1 = 0;
                                $upBerkas1 = 1;
                            }
                        } else {
                            if ($idberkasUsul <> 'NULL') {
                                $qryBerkas1 = 1;
                                $upBerkas1 = 1;
                            } else {
                                $qryBerkas1 = 0;
                                $upBerkas1 = 0;
                            }
                        }
                    } else {
                        if ($idberkasUsul <> 'NULL') {
                            $qryBerkas1 = 1;
                            $upBerkas1 = 1;
                        } else {
                            $qryBerkas1 = 0;
                            $upBerkas1 = 0;
                        }
                    }
                } else {
                    if ($idberkasUsul <> 'NULL') {
                        $qryBerkas1 = 1;
                        $upBerkas1 = 1;
                    } else {
                        $qryBerkas1 = 0;
                        $upBerkas1 = 0;
                    }
                }

                if (isset($_FILES["uploadFileSyaratSkum$idptk"])) {
                    if ($_FILES["uploadFileSyaratSkum$idptk"]['name'] <> "") {
                        //if (move_uploaded_file($_FILES["uploadFileSyaratSkum$idptk"]['tmp_name'], $uploadfileSkum)) {
                        if(ssh2_scp_send($connection, $_FILES["uploadFileSyaratSkum$idptk"]['tmp_name'], $uploadfileSkum, 0644)){
                            $sqlInsert = "insert into berkas (id_pegawai,id_kat,nm_berkas,tgl_upload,created_by,created_date,ket_berkas) " .
                                "values (" . $idp . ", 45,'SKUM', DATE(NOW()), '" . $idp . "', NOW(), 'SKUM')";
                            if ($mysqli->query($sqlInsert)) {
                                $last_id_berkas_skum = $mysqli->insert_id;
                                $sqlInsertIsi = "insert into isi_berkas (id_berkas, ket) values ($last_id_berkas_skum, 'SKUM')";
                                if ($mysqli->query($sqlInsertIsi)) {
                                    $last_idisi = $mysqli->insert_id;
                                    $nf = $_SESSION['nip_baru'] . "-" . $last_id_berkas_skum . "-" . $last_idisi . ".pdf";
                                    $sqlUpdateIsi = "update isi_berkas set file_name='$nf' where id_isi_berkas=$last_idisi";
                                    if ($mysqli->query($sqlUpdateIsi)) {
                                        //rename($uploadfileSkum, "berkas/" . $nf);
                                        ssh2_sftp_rename($sftp, $uploadfileSkum,$uploaddir.$nf);
                                        $sqlUpdate = "update ptk_master
                                                        set id_berkas_skum = $last_id_berkas_skum where id_ptk=" . $idptk;
                                        if ($mysqli->query($sqlUpdate)) {
                                            $qryBerkas2 = 1;
                                            $upBerkas2 = 1;
                                        } else {
                                            $qryBerkas2 = 0;
                                            $upBerkas2 = 1;
                                        }
                                    } else {
                                        $qryBerkas2 = 0;
                                        $upBerkas2 = 1;
                                    }
                                } else {
                                    $qryBerkas2 = 0;
                                    $upBerkas2 = 1;
                                }
                            } else {
                                $qryBerkas2 = 0;
                                $upBerkas2 = 1;
                            }
                        } else {
                            if ($idberkasSKUM <> 'NULL') {
                                $qryBerkas2 = 1;
                                $upBerkas2 = 1;
                            } else {
                                $qryBerkas2 = 0;
                                $upBerkas2 = 0;
                            }
                        }
                    } else {
                        if ($idberkasSKUM <> 'NULL') {
                            $qryBerkas2 = 1;
                            $upBerkas2 = 1;
                        } else {
                            $qryBerkas2 = 0;
                            $upBerkas2 = 0;
                        }
                    }
                } else {
                    if ($idberkasSKUM <> 'NULL') {
                        $qryBerkas2 = 1;
                        $upBerkas2 = 1;
                    } else {
                        $qryBerkas2 = 0;
                        $upBerkas2 = 0;
                    }
                }

                if (isset($_FILES["uploadFileSyaratSK$idptk"]) or $idberkasSK <> 'NULL') {
                    if ((isset($_FILES["uploadFileSyaratSK$idptk"]) and $_FILES["uploadFileSyaratSK$idptk"]['name'] <> "") or $idberkasSK <> 'NULL') {
                      //  if (move_uploaded_file(isset($_FILES["uploadFileSyaratSK$idptk"])?$_FILES["uploadFileSyaratSK$idptk"]['tmp_name']:'', isset($uploadfileSK)?$uploadfileSK:'') or $idberkasSK <> 'NULL') {
                        if(ssh2_scp_send($connection, isset($_FILES["uploadFileSyaratSK$idptk"])?$_FILES["uploadFileSyaratSK$idptk"]['tmp_name']:'', isset($uploadfileSK)?$uploadfileSK:'', 0644) or $idberkasSK <> 'NULL'){
                            //if ($idberkasSK == 'NULL') {
                                $sqlInsert = "insert into berkas (id_pegawai,id_kat,nm_berkas,tgl_upload,created_by,created_date,ket_berkas) " .
                                    "values (" . $idp . ", 2,'SK Pangkat Terakhir', DATE(NOW()), '" . $idp . "', NOW(), 'SK Pangkat Terakhir')";
                                if ($mysqli->query($sqlInsert)) {
                                    $last_id_berkas_sk = $mysqli->insert_id;
                                    $sqlInsertIsi = "insert into isi_berkas (id_berkas, ket) values ($last_id_berkas_sk, 'SK Pangkat Terakhir')";
                                    if ($mysqli->query($sqlInsertIsi)) {
                                        $last_idisi = $mysqli->insert_id;
                                        $nf = $_SESSION['nip_baru'] . "-" . $last_id_berkas_sk . "-" . $last_idisi . ".pdf";
                                        $sqlUpdateIsi = "update isi_berkas set file_name='$nf' where id_isi_berkas=$last_idisi";
                                        if ($mysqli->query($sqlUpdateIsi)) {
                                            //rename($uploadfileSK, "berkas/" . $nf);
                                            ssh2_sftp_rename($sftp, $uploadfileSK,$uploaddir.$nf);
                                            $sqlUpdate = "update ptk_master
                                                            set id_berkas_sk_pangkat_last = $last_id_berkas_sk where id_ptk=" . $idptk;
                                            if ($mysqli->query($sqlUpdate)) {
                                                $qryBerkas3 = 1;
                                                $upBerkas3 = 1;
                                            } else {
                                                $qryBerkas3 = 0;
                                                $upBerkas3 = 1;
                                            }
                                        } else {
                                            $qryBerkas3 = 0;
                                            $upBerkas3 = 1;
                                        }
                                    } else {
                                        $qryBerkas3 = 0;
                                        $upBerkas3 = 1;
                                    }
                                } else {
                                    $qryBerkas3 = 0;
                                    $upBerkas3 = 1;
                                }
                            //} else {
                            //    $qryBerkas3 = 1;
                            //    $upBerkas3 = 1;
                            //}
                        } else {
                            if ($idberkasSK <> 'NULL') {
                                $qryBerkas3 = 1;
                                $upBerkas3 = 1;
                            } else {
                                $qryBerkas3 = 0;
                                $upBerkas3 = 0;
                            }
                        }
                    } else {
                        if ($idberkasSK <> 'NULL') {
                            $qryBerkas3 = 1;
                            $upBerkas3 = 1;
                        } else {
                            $qryBerkas3 = 0;
                            $upBerkas3 = 0;
                        }
                    }
                } else {
                    if ($idberkasSK <> 'NULL') {
                        $qryBerkas3 = 1;
                        $upBerkas3 = 1;
                    } else {
                        $qryBerkas3 = 0;
                        $upBerkas3 = 0;
                    }
                }

                if (isset($_FILES["uploadFileSyaratGaji$idptk"])) {
                    if ($_FILES["uploadFileSyaratGaji$idptk"]['name'] <> "") {
                        //if (move_uploaded_file($_FILES["uploadFileSyaratGaji$idptk"]['tmp_name'], $uploadfileGaji)) {
                        if(ssh2_scp_send($connection, $_FILES["uploadFileSyaratGaji$idptk"]['tmp_name'], $uploadfileGaji, 0644)){
                            $sqlInsert = "insert into berkas (id_pegawai,id_kat,nm_berkas,tgl_upload,created_by,created_date,ket_berkas) " .
                                "values (" . $idp . ", 46,'Daftar Gaji', DATE(NOW()), '" . $idp . "', NOW(), 'Daftar Gaji')";
                            if ($mysqli->query($sqlInsert)) {
                                $last_id_berkas_gaji = $mysqli->insert_id;
                                $sqlInsertIsi = "insert into isi_berkas (id_berkas, ket) values ($last_id_berkas_gaji, 'Daftar Gaji')";
                                if ($mysqli->query($sqlInsertIsi)) {
                                    $last_idisi = $mysqli->insert_id;
                                    $nf = $_SESSION['nip_baru'] . "-" . $last_id_berkas_gaji . "-" . $last_idisi . ".pdf";
                                    $sqlUpdateIsi = "update isi_berkas set file_name='$nf' where id_isi_berkas=$last_idisi";
                                    if ($mysqli->query($sqlUpdateIsi)) {
                                        //rename($uploadfileGaji, "berkas/" . $nf);
                                        ssh2_sftp_rename($sftp, $uploadfileGaji,$uploaddir.$nf);
                                        $sqlUpdate = "update ptk_master
                                                        set id_berkas_daftar_gaji_last = $last_id_berkas_gaji where id_ptk=" . $idptk;
                                        if ($mysqli->query($sqlUpdate)) {
                                            $qryBerkas4 = 1;
                                            $upBerkas4 = 1;
                                        } else {
                                            $qryBerkas4 = 0;
                                            $upBerkas4 = 1;
                                        }
                                    } else {
                                        $qryBerkas4 = 0;
                                        $upBerkas4 = 1;
                                    }
                                } else {
                                    $qryBerkas4 = 0;
                                    $upBerkas4 = 1;
                                }
                            } else {
                                $qryBerkas4 = 0;
                                $upBerkas4 = 1;
                            }
                        } else {
                            if ($idberkasGaji <> 'NULL') {
                                $qryBerkas4 = 1;
                                $upBerkas4 = 1;
                            } else {
                                $qryBerkas4 = 0;
                                $upBerkas4 = 0;
                            }
                        }
                    } else {
                        if ($idberkasGaji <> 'NULL') {
                            $qryBerkas4 = 1;
                            $upBerkas4 = 1;
                        } else {
                            $qryBerkas4 = 0;
                            $upBerkas4 = 0;
                        }
                    }
                } else {
                    if ($idberkasGaji <> 'NULL') {
                        $qryBerkas4 = 1;
                        $upBerkas4 = 1;
                    } else {
                        $qryBerkas4 = 0;
                        $upBerkas4 = 0;
                    }
                }

                if (isset($_FILES["uploadFileSyaratKK$idptk"]) or $idberkasKK <> 'NULL') {
                    if ($_FILES["uploadFileSyaratKK$idptk"]['name'] <> "" or $idberkasKK <> 'NULL') {
                      //  if (move_uploaded_file($_FILES["uploadFileSyaratKK$idptk"]['tmp_name'], $uploadfileKK)) {
                      if(ssh2_scp_send($connection, $_FILES["uploadFileSyaratKK$idptk"]['tmp_name'], $uploadfileKK, 0644)){
                            $sqlInsert = "insert into berkas (id_pegawai,id_kat,nm_berkas,tgl_upload,created_by,created_date,ket_berkas) " .
                                "values (" . $idp . ", 14,'Kartu Keluarga', DATE(NOW()), '" . $idp . "', NOW(), 'Kartu Keluarga')";
                            if ($mysqli->query($sqlInsert)) {
                                $last_id_berkas_kk = $mysqli->insert_id;
                                $sqlInsertIsi = "insert into isi_berkas (id_berkas, ket) values ($last_id_berkas_kk, 'Kartu Keluarga')";
                                if ($mysqli->query($sqlInsertIsi)) {
                                    $last_idisi = $mysqli->insert_id;
                                    $nf = $_SESSION['nip_baru'] . "-" . $last_id_berkas_kk . "-" . $last_idisi . ".pdf";
                                    $sqlUpdateIsi = "update isi_berkas set file_name='$nf' where id_isi_berkas=$last_idisi";
                                    if ($mysqli->query($sqlUpdateIsi)) {
                                      //  rename($uploadfileKK, "berkas/" . $nf);
                                      ssh2_sftp_rename($sftp, $uploadfileKK,$uploaddir.$nf);
                                        $sqlUpdate = "update ptk_master
                                                        set id_berkas_kk_last = $last_id_berkas_kk where id_ptk=" . $idptk;
                                        if ($mysqli->query($sqlUpdate)) {
                                            $qryBerkas5 = 1;
                                            $upBerkas5 = 1;
                                        } else {
                                            $qryBerkas5 = 0;
                                            $upBerkas5 = 1;
                                        }
                                    } else {
                                        $qryBerkas5 = 0;
                                        $upBerkas5 = 1;
                                    }
                                } else {
                                    $qryBerkas5 = 0;
                                    $upBerkas5 = 1;
                                }
                            } else {
                                $qryBerkas5 = 0;
                                $upBerkas5 = 1;
                            }
                        } else {
                            if ($idberkasKK <> 'NULL') {
                                $qryBerkas5 = 1;
                                $upBerkas5 = 1;
                            } else {
                                $qryBerkas5 = 0;
                                $upBerkas5 = 0;
                            }
                        }
                    } else {
                        if ($idberkasKK <> 'NULL') {
                            $qryBerkas5 = 1;
                            $upBerkas5 = 1;
                        } else {
                            $qryBerkas5 = 0;
                            $upBerkas5 = 0;
                        }
                    }
                } else {
                    if ($idberkasKK <> 'NULL') {
                        $qryBerkas5 = 1;
                        $upBerkas5 = 1;
                    } else {
                        $qryBerkas5 = 0;
                        $upBerkas5 = 0;
                    }
                }

                /* Pasangan PNS */
                /* ================ */
                /*$sql = "SELECT COUNT(*) AS jumlah
                        FROM ptk_keluarga pk
                        WHERE pk.id_ptk = $idptk AND (LOWER(pk.last_pekerjaan) = 'pns'
                        OR LOWER(pk.last_pekerjaan) = 'pegawai negeri sipil'
                        OR LOWER(pk.last_pekerjaan) = 'tni'
                        OR LOWER(pk.last_pekerjaan) = 'polri') AND pk.last_id_status_keluarga = 9";
                $qRekap = $mysqli->query($sql);
                while ($r = $qRekap->fetch_array(MYSQLI_NUM)) {
                    $jmlPasanganPNS = $r[0];
                }*/

                if($jmlPasanganPNS > 0){
                    $mysqli->autocommit(FALSE);
                    if (isset($_FILES["uploadFileSyaratGajiPasangan$idptk"])) {
                        if ($_FILES["uploadFileSyaratGajiPasangan$idptk"]['name'] <> "") {
                            //if (move_uploaded_file($_FILES["uploadFileSyaratGajiPasangan$idptk"]['tmp_name'], $uploadfileGajiPasangan)) {
                            if(ssh2_scp_send($connection, $_FILES["uploadFileSyaratGajiPasangan$idptk"]['tmp_name'], $uploadfileGajiPasangan, 0644)){
                                $sqlInsert = "insert into berkas (id_pegawai,id_kat,nm_berkas,tgl_upload,created_by,created_date,ket_berkas) " .
                                    "values (" . $idp . ", 52,'Daftar Gaji Pasangan PNS/TNI/POLRI', DATE(NOW()), '" . $idp . "', NOW(), 'Daftar Gaji Pasangan PNS/TNI/POLRI')";
                                if ($mysqli->query($sqlInsert)) {
                                    $last_id_berkas_gaji = $mysqli->insert_id;
                                    $sqlInsertIsi = "insert into isi_berkas (id_berkas, ket) values ($last_id_berkas_gaji, 'Daftar Gaji Pasangan PNS/TNI/POLRI')";
                                    if ($mysqli->query($sqlInsertIsi)) {
                                        $last_idisi = $mysqli->insert_id;
                                        $nf = $_SESSION['nip_baru'] . "-" . $last_id_berkas_gaji . "-" . $last_idisi . ".pdf";
                                        $sqlUpdateIsi = "update isi_berkas set file_name='$nf' where id_isi_berkas=$last_idisi";
                                        if ($mysqli->query($sqlUpdateIsi)) {
                                            //rename($uploadfileGajiPasangan, "berkas/" . $nf);
                                            ssh2_sftp_rename($sftp, $uploadfileGajiPasangan,$uploaddir.$nf);
                                            $sqlUpdate = "update ptk_master
                                                        set id_berkas_daftar_gaji_pasangan_pns = $last_id_berkas_gaji where id_ptk=" . $idptk;
                                            if ($mysqli->query($sqlUpdate)) {
                                                $qryBerkas6 = 1;
                                                $upBerkas6 = 1;
                                                $mysqli->commit();
                                            } else {
                                                $qryBerkas6 = 0;
                                                $upBerkas6 = 1;
                                            }
                                        } else {
                                            $qryBerkas6 = 0;
                                            $upBerkas6 = 1;
                                        }
                                    } else {
                                        $qryBerkas6 = 0;
                                        $upBerkas6 = 1;
                                    }
                                } else {
                                    $qryBerkas6 = 0;
                                    $upBerkas6 = 1;
                                }
                            } else {
                                if ($idberkasGajiPasangan <> 'NULL') {
                                    $qryBerkas6 = 1;
                                    $upBerkas6 = 1;
                                } else {
                                    $qryBerkas6 = 0;
                                    $upBerkas6 = 0;
                                }
                            }
                        } else {
                            if ($idberkasGajiPasangan <> 'NULL') {
                                $qryBerkas6 = 1;
                                $upBerkas6 = 1;
                            } else {
                                $qryBerkas6 = 0;
                                $upBerkas6 = 0;
                            }
                        }
                    } else {
                        if ($idberkasGajiPasangan <> 'NULL') {
                            $qryBerkas6 = 1;
                            $upBerkas6 = 1;
                        } else {
                            $qryBerkas6 = 0;
                            $upBerkas6 = 0;
                        }
                    }
                }else{
                    $upBerkas6 = 1;
                    $qryBerkas6 = 1;
                }

                if ($upBerkasPtk == 1 and $upBerkas1 == 1 and $upBerkas2 == 1 and $upBerkas3 == 1 and $upBerkas4 == 1 and $upBerkas5 == 1 and $upBerkas6 == 1) {
                    if ($qryBerkasPtk and $qryBerkas1 == 1 and $qryBerkas2 == 1 and $qryBerkas3 == 1 and $qryBerkas4 == 1 and $qryBerkas5 == 1 and $qryBerkas6 == 1) {
                        $sqlInsert_Approved_Hist = "INSERT INTO ptk_historis_approve(tgl_approve_hist, approved_by_hist, id_status_ptk, approved_note_hist, id_ptk)
                            VALUES (NOW()," . $idp . ",2,'" . $txtCatatan[$idptk] . "'," . $idptk . ")";
                        if ($mysqli->query($sqlInsert_Approved_Hist) == TRUE) {
                            $sqlUpdatePtk = "UPDATE ptk_master set idstatus_ptk=2, tgl_approve=NOW(),
                                    approved_by=" . $idp . ",approved_note= '" . $txtCatatan[$idptk] . "'
                                    where id_ptk=" . $idptk;
                            if ($mysqli->query($sqlUpdatePtk) == TRUE) {
                                $mysqli->commit();
                                echo("<div align=center style='background-color: #83c868;font-weight: bold;color: #ffffff; padding-top: 5px;padding-bottom: 5px;'> Revisi Pengubahan Tunjangan Keluarga Berhasil Terkirim </div>");
                            } else {
                                $mysqli->rollback();
                                echo("<div align=center style='background-color:#c8271b;font-weight: bold;color: #ffffff; padding-top: 5px;padding-bottom: 5px;'> Error: Tidak dapat menyimpan data. Silahkan coba lagi." . "<br></div>");
                            }
                        }
                    } else {
                        echo("<div align=center style='background-color:#c8271b;font-weight: bold;color: #ffffff; padding-top: 5px;padding-bottom: 5px;'>Terdapat data yang tidak tersimpan atau ada persyaratan yang tidak terupload. Silahkan coba lagi.</div>");
                    }
                } else {
                    //echo("<div align=center style='background-color:#c8271b;font-weight: bold;color: #ffffff; padding-top: 5px;padding-bottom: 5px;'>Ada perbaikan aplikasi. Silahkan coba lagi nanti.</div>");
                    echo("<div align=center style='background-color:#c8271b;font-weight: bold;color: #ffffff; padding-top: 5px;padding-bottom: 5px;'>Pengiriman ulang usulan tidak dilakukan. Terdapat data yang tidak tersimpan atau ada persyaratan yang tidak terupload. Silahkan coba lagi.</div>");
                }

            }

            if (isset($btnBatalkanPtk)) {
                foreach ($btnBatalkanPtk as $key => $n) {
                    $idptk = $key;
                }
                $sqlUpdate = "update ptk_master set idstatus_ptk=7, tgl_approve=NOW(),
                                approved_by=" . $idp . ",approved_note= '" . $txtCatatan[$idptk] . "'
                                where id_ptk=" . $idptk;
                if ($mysqli->query($sqlUpdate)) {
                    echo("<div align=center style='background-color: #83c868;font-weight: bold;color: #ffffff; padding-top: 5px;padding-bottom: 5px;'> Data Pengajuan Pengubahan Tunjangan Keluarga Dibatalkan </div>");
                    $sqlInsert_Approved_Hist = "INSERT INTO ptk_historis_approve(tgl_approve_hist, approved_by_hist, id_status_ptk, approved_note_hist, id_ptk)
                                VALUES (NOW()," . $idp . ",7,'" . $txtCatatan[$idptk] . "'," . $idptk . ")";
                    $mysqli->query($sqlInsert_Approved_Hist);
                } else {
                    echo("<div align=center style='background-color:#c8271b;font-weight: bold;color: #ffffff; padding-top: 5px;padding-bottom: 5px;'> Error: Tidak dapat mengubah data. Silahkan coba lagi." . "<br></div>");
                }
            }

            if (isset($btnHapusPtk)) {
                foreach ($btnHapusPtk as $key => $n) {
                    $idptk = $key;
                }
                $sqlDelete = "delete from ptk_master where id_ptk=" . $idptk;
                if ($mysqli->query($sqlDelete)) {
                    echo("<div align=center style='background-color: #83c868;font-weight: bold;color: #ffffff; padding-top: 5px;padding-bottom: 5px;'> Data Pengajuan Pengubahan Tunjangan Keluarga Berhasil Dihapus </div>");
                } else {
                    echo("<div align=center style='background-color:#c8271b;font-weight: bold;color: #ffffff; padding-top: 5px;padding-bottom: 5px;'> Error: Tidak dapat menghapus data. Silahkan coba lagi." . "<br></div>");
                }
            }

            if (isset($btnUpdatePtk)) {
                foreach ($btnUpdatePtk as $key => $n) {
                    $idptk = $key;
                }
                $sqlUpdate = "update ptk_master set tgl_update_pengajuan=NOW(),
                                nomor='" . $txtNomor[$idptk] . "',sifat='" . $txtSifat[$idptk] . "',lampiran='" . $txtLampiran[$idptk] . "'
                                where id_ptk=" . $idptk;
                if ($mysqli->query($sqlUpdate)) {
                    echo("<div align=center style='background-color: #83c868;font-weight: bold;color: #ffffff; padding-top: 5px;padding-bottom: 5px;'> Data Pengajuan Pengubahan Tunjangan Keluarga Berhasil Diubah </div>");
                } else {
                    echo("<div align=center style='background-color:#c8271b;font-weight: bold;color: #ffffff; padding-top: 5px;padding-bottom: 5px;'> Error: Tidak dapat mengubah data. Silahkan coba lagi." . "<br></div>");
                }
            }

            $sqlList = "SELECT a.*, p.nama as approve_by, p.nip_baru AS nip_approver FROM
                (SELECT pm.id_ptk, pm.tgl_input_pengajuan, pm.nomor, pm.sifat, pm.lampiran, pjp.jenis_pengajuan, pm.last_jml_pasangan,
                pm.last_jml_anak, p.nama, p.nip_baru, pm.last_gol, pm.last_jabatan, uk.nama_baru AS unit, rsp.status_ptk,
                pm.id_berkas_pengajuan, pm.id_berkas_skum, pm.id_berkas_sk_pangkat_last, pm.id_berkas_daftar_gaji_last,
                pm.idstatus_ptk, pm.tgl_approve, pm.approved_note, pm.approved_by, pm.id_berkas_ptk, pm.id_berkas_kk_last, pm.id_berkas_daftar_gaji_pasangan_pns
                FROM ptk_master pm, ptk_jenis_pengajuan pjp, pegawai p, unit_kerja uk, ref_status_ptk rsp
                WHERE pm.id_jenis_pengajuan = pjp.id_jenis_pengajuan AND pm.id_pegawai_pemohon = p.id_pegawai AND
                pm.last_id_unit_kerja = uk.id_unit_kerja AND pm.idstatus_ptk = rsp.id_status_ptk AND pm.id_pegawai_pemohon = $idp) a
                LEFT JOIN pegawai p ON a.approved_by = p.id_pegawai ORDER BY a.tgl_input_pengajuan DESC";
            $queryList = $mysqli->query($sqlList);
            if ($queryList->num_rows > 0) {
                ?>
                <table class='table'>
                    <?php
                    $i = 1;
                    while ($oto = $queryList->fetch_array(MYSQLI_NUM)) {
                        $idptk = $oto[0];
                        $idstatus_ptk = $oto[18];
                        $idberkas1 = $oto[14]; //Usulan
                        $idberkas2 = $oto[15]; //SKUM
                        $idberkas3 = $oto[16]; //SK Pangkat
                        $idberkas4 = $oto[17]; //Daftar Gaji Pegawai
                        $idberkas5 = $oto[23]; //KK
                        $idberkas6 = $oto[24]; //Daftar Gaji Pasangan PNS
                        ?>
                        <tr style='border-bottom: solid 2px #2cc256;border-top: solid 2px #000'>
                            <td>No</td>
                            <td style="width: 18%;">Waktu Permohonan</td>
                            <td>Nomor</td>
                            <td>Sifat</td>
                            <td>Lampiran</td>
                            <td style="width: 25%;">Jenis Pengajuan</td>
                            <td style="width: 15%;">Jml. Akhir Pasangan</td>
                            <td style="width: 15%;">Jml. Akhir Anak</td>
                        </tr>
                        <?php if ($idstatus_ptk == 1): ?>
                            <form role="form" class="form-horizontal"
                                  action="index3.php?x=ptk.php&od=<?php echo $idp; ?>" method="post"
                                  enctype="multipart/form-data" name="frmReqPTKUpdate" id="frmReqPTKUpdate">
                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $oto[1]; ?></td>
                                    <td><input id="txtNomor[<?php echo $idptk; ?>]"
                                               name="txtNomor[<?php echo $idptk; ?>]"
                                               type="text" value="<?php echo $oto[2]; ?>" style="width: 100%;"></td>
                                    <td><input id="txtSifat[<?php echo $idptk; ?>]"
                                               name="txtSifat[<?php echo $idptk; ?>]"
                                               type="text" value="<?php echo $oto[3]; ?>" style="width: 100%;"></td>
                                    <td><input id="txtLampiran[<?php echo $idptk; ?>]"
                                               name="txtLampiran[<?php echo $idptk; ?>]"
                                               type="text" value="<?php echo $oto[4]; ?>" style="width: 100%;">
                                        <input type="submit" name="btnUpdatePtk[<?php echo $idptk; ?>]"
                                               id="btnUpdatePtk[<?php echo $idptk; ?>]"
                                               class="btn btn-xs btn-info" value="Update"
                                               style="margin-top: 3px;width: 100%;"/>
                                    </td>
                                    <td><?php echo $oto[5]; ?></td>
                                    <td><?php echo $oto[6]; ?> orang</td>
                                    <td><?php echo $oto[7]; ?> orang</td>
                                </tr>
                            </form>
                        <?php else: ?>
                            <tr>
                                <td><?php echo $i; ?></td>
                                <td><?php echo $oto[1]; ?></td>
                                <td><?php echo $oto[2]; ?></td>
                                <td><?php echo $oto[3]; ?></td>
                                <td><?php echo $oto[4]; ?></td>
                                <td><?php echo $oto[5]; ?></td>
                                <td><?php echo $oto[6]; ?> orang</td>
                                <td><?php echo $oto[7]; ?> orang</td>
                            </tr>
                        <?php endif; ?>
                        <tr>
                            <td></td>
                            <td colspan="7">
                                Status Pengajuan : <span style="font-size: medium; color: #0c199c;">
                                <?php
                                echo $oto[13];

                                if ($oto[22] <> "" and $oto[22] <> "0") {

                                    $sqlCekBerkas = "SELECT ib.file_name, b.created_by, DATE_FORMAT(b.created_date,  '%d/%m/%Y %H:%i:%s') AS created_date, p.nip_baru, p.nama, b.id_kat
                                                FROM berkas b LEFT JOIN pegawai p ON b.created_by = p.id_pegawai, isi_berkas ib
                                                WHERE b.id_berkas = ib.id_berkas AND b.id_berkas = $oto[22]";
                                    $query = $mysqli->query($sqlCekBerkas);
                                    if (isset($query)) {
                                        if ($query->num_rows > 0) {
                                            while ($otof = $query->fetch_array(MYSQLI_NUM)) {
                                                $asli = basename($otof[0]);
                                                //if (file_exists(str_replace("\\", "/", getcwd()) . '/berkas/' . trim($asli))) {
                                                    $ext[] = explode(".", $asli);
                                                    $linkBerkasUsulan = "<a href='http://103.14.229.15/simpeg/berkas/$asli' target='_blank' class=\"btn-sm btn-success\">Download Berkas Pengajuan PTK ke BPKAD</a>";
                                                    $tglUpload = $otof[2] . ' oleh ' . $otof[4] . ' (' . $otof[3] . ')';
                                                    unset($ext);
                                                //}
                                            }
                                        }
                                        echo "<br>".$linkBerkasUsulan;
                                        echo "<small class=\"form-text text-muted\">";
                                        echo " Tgl.Upload : " . $tglUpload . "</small>";
                                    }
                                }
                                ?></span>
                                <?php
                                if ($oto[19] <> '' and ($oto[22] == "" or $oto[22] == "0")) {
                                    echo "<br>Tanggal Status: $oto[19] Oleh : $oto[25] ($oto[26]). Catatan: $oto[20]";
                                }
                                ?>
                                <br><br>

                                <div class="row">
                                    <form role="form" class="form-horizontal"
                                          action="index3.php?x=ptk.php&od=<?php echo $idp; ?>" method="post"
                                          enctype="multipart/form-data" name="frmReqPTKAjukan" id="frmReqPTKAjukan">
                                        <div class="col-lg-6">
                                            <?php
                                            $sql = "SELECT pk.id_ptk_keluarga, ptp.id_tipe_pengubahan_tunjangan, ptp.kategori_pengubahan, ptp.tipe_pengubahan_tunjangan,
                                        sk.status_keluarga, pk.last_nama, pk.last_tempat_lahir, pk.last_tgl_lahir, pk.last_pekerjaan,
                                        CASE WHEN pk.last_jk = 1 THEN 'Laki-laki' ELSE 'Perempuan' END AS last_jk,
                                        CASE WHEN pk.last_status_tunjangan = 0 THEN 'Tidak Dapat' ELSE 'Dapat' END AS last_status_tunjangan,
                                        ps.last_tgl_references, ps.last_keterangan_reference, ps.id_berkas_syarat, ptp.nama_berkas_syarat, ps.id_syarat
                                        FROM ptk_keluarga pk, ptk_tipe_pengubahan ptp, status_kel sk, ptk_syarat ps
                                        WHERE pk.id_ptk = $oto[0] AND pk.id_tipe_pengubahan_tunjangan = ptp.id_tipe_pengubahan_tunjangan AND
                                        pk.last_id_status_keluarga = sk.id_status AND pk.id_ptk_keluarga = ps.id_ptk_keluarga
                                        ORDER BY pk.last_id_status_keluarga, pk.last_nama";
                                            $query2 = $mysqli->query($sql);
                                            if ($query2->num_rows > 0) {
                                                ?>
                                                <table class="table">
                                                    <tr style='border-bottom: solid 2px #d29d4e'>
                                                        <td>No</td>
                                                        <td>Pengubahan Keluarga</td>
                                                        <td>Status Tunjangan</td>
                                                    </tr>
                                                    <?php
                                                    $x = 1;
                                                    while ($oto2 = $query2->fetch_array(MYSQLI_NUM)) {
                                                        ?>
                                                        <tr>
                                                            <td><?php echo $x; ?></td>
                                                            <td><?php echo $oto2[2] . ' krn ' . $oto2[3]; ?></td>
                                                            <td><?php echo $oto2[10] ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td></td>
                                                            <td>
                                                                <?php echo "$oto2[4] : <strong>$oto2[5]</strong> <br> Jenis Kelamin : $oto2[9]<br>Kelahiran : $oto2[6], $oto2[7]<br>Pekerjaan : $oto2[8]"; ?>
                                                                <?php
                                                                    if($oto2[4]=='Istri/Suami'){
                                                                        $pekerjaan_pasangan = str_replace(' ', '', strtolower($oto2[8]));
                                                                    }
                                                                ?>
                                                            </td>
                                                            <td>
                                                                <?php
                                                                if ($oto2[13] <> '' and $oto2[13] <> '0') {
                                                                    $sqlCekBerkas = "SELECT ib.file_name, b.created_by, DATE_FORMAT(b.created_date,  '%d/%m/%Y %H:%i:%s') AS created_date, p.nip_baru, p.nama, b.id_kat
                                                         FROM berkas b LEFT JOIN pegawai p ON b.created_by = p.id_pegawai, isi_berkas ib
                                                         WHERE b.id_berkas = ib.id_berkas AND b.id_berkas = " . $oto2[13];
                                                                    $query = $mysqli->query($sqlCekBerkas);
                                                                    if (isset($query)) {
                                                                        if ($query->num_rows > 0) {
                                                                            while ($oto = $query->fetch_array(MYSQLI_NUM)) {
                                                                                $asli = basename($oto[0]);
                                                                                //if (file_exists(str_replace("\\", "/", getcwd()) . '/berkas/' . trim($asli))) {
                                                                                    $ext[] = explode(".", $asli);
                                                                                    $linkBerkasUsulan = "<a href='http://103.14.229.15/simpeg/berkas/$asli' target='_blank'>Berkas Syarat</a>";
                                                                                    $tglUpload = $oto[2] . "<br>$oto2[14]<br>$oto2[11]" . ($oto2[12] == '' ? '' : ' ' . $oto2[12]);
                                                                                    $pengUpload = $oto[4] . ' (' . $oto[3] . ')';
                                                                                    $idkat_berkas = $oto[5];
                                                                                    unset($ext);
                                                                                //}
                                                                            }
                                                                        }
                                                                        if (@$linkBerkasUsulan <> "") {
                                                                            echo "$linkBerkasUsulan";
                                                                            echo "<small class=\"form-text text-muted\">";
                                                                            echo "<br>Tgl.Upload : " . $tglUpload . "</small>";
                                                                            if ($idstatus_ptk == 3) { ?>
                                                                                <div id='divFile'
                                                                                     class="fileUpload btn btn-default"
                                                                                     style='margin-top: 0px;text-align: center; margin-bottom: -3px; margin-left: -1px;'>
                                                                                    <span
                                                                                        id='judulFile<?php echo $idptk . $oto2[15] . $idkat_berkas; ?>'>Browse</span>
                                                                                    <input
                                                                                        id="uploadFilePTK<?php echo $idptk; ?>[<?php echo($oto2[15] . '-' . $idkat_berkas); ?>]"
                                                                                        name="uploadFilePTK<?php echo $idptk; ?>[<?php echo($oto2[15] . '-' . $idkat_berkas); ?>]"
                                                                                        type="file" accept=".pdf"
                                                                                        class="upload uploadFilePTK<?php echo $idptk . '-' . $oto2[15] . '-' . $idkat_berkas; ?>"/>
                                                                                </div>
                                                                                <script>
                                                                                    $('.uploadFilePTK<?php echo $idptk.'-'.$oto2[15].'-'.$idkat_berkas; ?>').bind('change', function () {
                                                                                        var fileUsulanSizePtk<?php echo $idptk.$oto2[15].$idkat_berkas;?> = 0;
                                                                                        fileUsulanSizePtk<?php echo $idptk.$oto2[15].$idkat_berkas;?> = this.files[0].size;
                                                                                        if (parseFloat(fileUsulanSizePtk<?php echo $idptk.$oto2[15].$idkat_berkas;?>) > 2138471) {
                                                                                            alert('Ukuran file terlalu besar');
                                                                                            $("#judulFile<?php echo $idptk.$oto2[15].$idkat_berkas;?>").text('Browse');
                                                                                            $(".uploadFilePTK<?php echo $idptk.'-'.$oto2[15].'-'.$idkat_berkas; ?>").val("");
                                                                                        } else {
                                                                                            $("#judulFile<?php echo $idptk.$oto2[15].$idkat_berkas;?>").text('Satu File');
                                                                                        }
                                                                                    });
                                                                                </script>
                                                                            <?php }
                                                                        }
                                                                    }
                                                                }else{

                                                                }
                                                                ?>
                                                            </td>
                                                        </tr>
                                                        <?php $x++;
                                                    } ?>
                                                </table>
                                            <?php } ?>
                                        </div>
                                        <div class="col-lg-6">
                                            <table class="table">
                                                <tr style='border-bottom: solid 2px #d25e52'>
                                                    <td>No</td>
                                                    <td>Persyaratan Lainnya</td>
                                                    <td></td>
                                                </tr>
                                                <?php
                                                // LOAD BERKAS
                                                if ($idberkas1 == '') {
                                                    $idberkas1 = -1;
                                                }
                                                if ($idberkas2 == '') {
                                                    $idberkas2 = -1;
                                                }
                                                if ($idberkas3 == '') {
                                                    $idberkas3 = -1;
                                                }
                                                if ($idberkas4 == '') {
                                                    $idberkas4 = -1;
                                                }
                                                if ($idberkas5 == '') {
                                                    $idberkas5 = -1;
                                                }
                                                if ($idberkas6 == '') {
                                                    $idberkas6 = -1;
                                                }
                                                $sqlCekBerkas = "SELECT ib.file_name, b.created_by, DATE_FORMAT(b.created_date,  '%d/%m/%Y %H:%i:%s') AS created_date, p.nip_baru, p.nama, b.id_kat
                                                FROM berkas b LEFT JOIN pegawai p ON b.created_by = p.id_pegawai, isi_berkas ib
                                                WHERE b.id_berkas = ib.id_berkas AND b.id_berkas IN ($idberkas1,$idberkas2,$idberkas3,$idberkas4,$idberkas5,$idberkas6)";
                                                //echo $sqlCekBerkas;
                                                $query = $mysqli->query($sqlCekBerkas);
                                                if (isset($query)) {
                                                    if ($query->num_rows > 0) {
                                                        while ($oto3 = $query->fetch_array(MYSQLI_NUM)) {
                                                            $asli = basename($oto3[0]);
                                                            //if (file_exists(str_replace("\\", "/", getcwd()) . '/berkas/' . trim($asli))) {
                                                                $ext[] = explode(".", $asli);
                                                                switch ($oto3[5]) {
                                                                    case 40: //Surat Pengantar dari OPD
                                                                        $linkBerkasUsulan1 = "<a href='http://103.14.229.15/simpeg/berkas/$asli' target='_blank'>Berkas Syarat</a>";
                                                                        $tglUpload1 = $oto3[2];
                                                                        break;
                                                                    case 45: //SKUM
                                                                        $linkBerkasUsulan2 = "<a href='http://103.14.229.15/simpeg/berkas/$asli' target='_blank'>Berkas Syarat</a>";
                                                                        $tglUpload2 = $oto3[2];
                                                                        break;
                                                                    case 2: //SK Pangkat Terakhir
                                                                        $linkBerkasUsulan3 = "<a href='http://http://103.14.229.15/simpeg/berkas/$asli' target='_blank'>Berkas Syarat</a>";
                                                                        $tglUpload3 = $oto3[2];
                                                                        break;
                                                                    case 46: //Daftar Gaji
                                                                        $linkBerkasUsulan4 = "<a href='http://http://103.14.229.15/simpeg/berkas/$asli' target='_blank'>Berkas Syarat</a>";
                                                                        $tglUpload4 = $oto3[2];
                                                                        break;
                                                                    case 14: //Kartu Keluarga
                                                                        $linkBerkasUsulan5 = "<a href='http://http://103.14.229.15/simpeg/berkas/$asli' target='_blank'>Berkas Syarat</a>";
                                                                        $tglUpload5 = $oto3[2];
                                                                        break;
                                                                    case 52: //Daftar Gaji Pasangan PNS
                                                                        $linkBerkasUsulan6 = "<a href='http://http://103.14.229.15/simpeg/berkas/$asli' target='_blank'>Berkas Syarat</a>";
                                                                        $tglUpload6 = $oto3[2];
                                                                        break;
                                                                }
                                                                unset($ext);
                                                            /*} else {
                                                                switch ($oto3[5]) {
                                                                    case 40: //Surat Pengantar dari OPD
                                                                        $linkBerkasUsulan1 = "";
                                                                        break;
                                                                    case 45: //SKUM
                                                                        $linkBerkasUsulan2 = "";
                                                                        break;
                                                                    case 2: //SK Pangkat Terakhir
                                                                        $linkBerkasUsulan3 = "";
                                                                        break;
                                                                    case 46: //Daftar Gaji
                                                                        $linkBerkasUsulan4 = "";
                                                                        break;
                                                                    case 14: //Kartu Keluarga
                                                                        $linkBerkasUsulan5 = "";
                                                                        break;
                                                                    case 52: //Daftar Gaji Pasangan PNS
                                                                        $linkBerkasUsulan6 = "";
                                                                        break;
                                                                }
                                                            }*/
                                                        }
                                                    }
                                                }
                                                ?>
                                                <tr>
                                                    <td>1.</td>
                                                    <td style="width: 60%">Usulan / Pengantar OPD <br><a
                                                            href="/simpeg/ptk_surat.php?idptk=<?php echo $idptk; ?>"
                                                            target="_blank">Download Format Surat</a></td>
                                                    <td>
                                                        <?php if (@$idberkas1 <> "" and @$idberkas1 <> "0" and @$idberkas1 <> -1 and @$linkBerkasUsulan1 <> "") {
                                                            echo "$linkBerkasUsulan1";
                                                            echo "<small class=\"form-text text-muted\">";
                                                            echo "<br>Tgl.Upload : " . $tglUpload1 . "</small>";
                                                            ?>
                                                            <?php if ($idstatus_ptk == 3): ?>
                                                            <div id='divBtnFile1' class="fileUpload btn btn-default"
                                                                 style='margin-top: 0px;text-align: center; margin-bottom: -3px; margin-left: -1px;'>
                                                                <span id='judulFile1<?php echo $idptk; ?>'>Browse</span>
                                                                <input
                                                                    id="uploadFileSyaratPengantar<?php echo $idptk; ?>"
                                                                    name='uploadFileSyaratPengantar<?php echo $idptk; ?>'
                                                                    type="file" class="upload" accept=".pdf"/>
                                                            </div>
                                                            <script>
                                                                $('#uploadFileSyaratPengantar<?php echo $idptk;?>').bind('change', function () {
                                                                    var fileUsulanSize1<?php echo $idptk;?> = 0;
                                                                    fileUsulanSize1<?php echo $idptk;?> = this.files[0].size;
                                                                    if (parseFloat(fileUsulanSize1<?php echo $idptk;?>) > 2138471) {
                                                                        alert('Ukuran file terlalu besar');
                                                                        $("#judulFile1<?php echo $idptk;?>").text('Browse');
                                                                        $("#uploadFileSyaratPengantar<?php echo $idptk;?>").val("");
                                                                    } else {
                                                                        $("#judulFile1<?php echo $idptk;?>").text('Satu File');
                                                                    }
                                                                });
                                                            </script>
                                                        <?php endif; ?>
                                                        <?php }else{ ?> <!-- ekos -->
                                                            <div id='divBtnFile1' class="fileUpload btn btn-default"
                                                                 style='margin-top: 0px;text-align: center; margin-bottom: -3px; margin-left: -1px;'>
                                                                <span id='judulFile1<?php echo $idptk; ?>'>Browse</span>
                                                                <input
                                                                    id="uploadFileSyaratPengantar<?php echo $idptk; ?>"
                                                                    name='uploadFileSyaratPengantar<?php echo $idptk; ?>'
                                                                    type="file" class="upload" accept=".pdf"/>
                                                            </div>
                                                            <script>
                                                                $('#uploadFileSyaratPengantar<?php echo $idptk;?>').bind('change', function () {
                                                                    var fileUsulanSize1<?php echo $idptk;?> = 0;
                                                                    fileUsulanSize1<?php echo $idptk;?> = this.files[0].size;
                                                                    if (parseFloat(fileUsulanSize1<?php echo $idptk;?>) > 2138471) {
                                                                        alert('Ukuran file terlalu besar');
                                                                        $("#judulFile1<?php echo $idptk;?>").text('Browse');
                                                                        $("#uploadFileSyaratPengantar<?php echo $idptk;?>").val("");
                                                                    } else {
                                                                        $("#judulFile1<?php echo $idptk;?>").text('Satu File');
                                                                    }
                                                                });
                                                            </script>
                                                        <?php } ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>2.</td>
                                                    <td>SKUM<br><a
                                                            href="/simpeg2/pdf/skum_pdf/index/<?php echo $idp; ?>"
                                                            target="_blank">Download SKUM</a></td>
                                                    <td>
                                                        <?php if ($idberkas2 <> "" and $idberkas2 <> "0" and $idberkas2 <> -1 and $linkBerkasUsulan2 <> "") {
                                                            echo "$linkBerkasUsulan2";
                                                            echo "<small class=\"form-text text-muted\">";
                                                            echo "<br>Tgl.Upload : " . $tglUpload2 . "</small>";
                                                            ?>
                                                            <?php if ($idstatus_ptk == 3): ?>
                                                            <div id='divBtnFile2' class="fileUpload btn btn-default"
                                                                 style='margin-top: 0px;text-align: center; margin-bottom: -3px; margin-left: -1px;'>
                                                                <span id='judulFile2<?php echo $idptk; ?>'>Browse</span>
                                                                <input id="uploadFileSyaratSkum<?php echo $idptk; ?>"
                                                                       name='uploadFileSyaratSkum<?php echo $idptk; ?>'
                                                                       type="file" class="upload" accept=".pdf"/>
                                                            </div>
                                                            <script>
                                                                $('#uploadFileSyaratSkum<?php echo $idptk;?>').bind('change', function () {
                                                                    var fileUsulanSize2<?php echo $idptk;?> = 0;
                                                                    fileUsulanSize2<?php echo $idptk;?> = this.files[0].size;
                                                                    if (parseFloat(fileUsulanSize2<?php echo $idptk;?>) > 2138471) {
                                                                        alert('Ukuran file terlalu besar');
                                                                        $("#judulFile2<?php echo $idptk;?>").text('Browse');
                                                                        $("#uploadFileSyaratSkum<?php echo $idptk;?>").val("");
                                                                    } else {
                                                                        $("#judulFile2<?php echo $idptk;?>").text('Satu File');
                                                                    }
                                                                });
                                                            </script>
                                                        <?php endif; ?>
                                                        <?php }else{ ?>
                                                            <div id='divBtnFile2' class="fileUpload btn btn-default"
                                                                 style='margin-top: 0px;text-align: center; margin-bottom: -3px; margin-left: -1px;'>
                                                                <span id='judulFile2<?php echo $idptk; ?>'>Browse</span>
                                                                <input id="uploadFileSyaratSkum<?php echo $idptk; ?>"
                                                                       name='uploadFileSyaratSkum<?php echo $idptk; ?>'
                                                                       type="file" class="upload" accept=".pdf"/>
                                                            </div>
                                                            <script>
                                                                $('#uploadFileSyaratSkum<?php echo $idptk;?>').bind('change', function () {
                                                                    var fileUsulanSize2<?php echo $idptk;?> = 0;
                                                                    fileUsulanSize2<?php echo $idptk;?> = this.files[0].size;
                                                                    if (parseFloat(fileUsulanSize2<?php echo $idptk;?>) > 2138471) {
                                                                        alert('Ukuran file terlalu besar');
                                                                        $("#judulFile2<?php echo $idptk;?>").text('Browse');
                                                                        $("#uploadFileSyaratSkum<?php echo $idptk;?>").val("");
                                                                    } else {
                                                                        $("#judulFile2<?php echo $idptk;?>").text('Satu File');
                                                                    }
                                                                });
                                                            </script>
                                                        <?php } ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>3.</td>
                                                    <td>SK. Kenaikan Pangkat Terakhir
                                                    <?php if ($idberkas3 == "" or $idberkas3 == "0" or $idberkas3 == -1 or $linkBerkasUsulan3 == ""){
                                                        echo '<br><span style="color:darkgoldenrod">Pastikan berkas tersedia dan dapat dilihat</span>';
                                                    } ?>
                                                    </td>
                                                    <td>
                                                        <?php if ($idberkas3 <> "" and $idberkas3 <> "0" and $idberkas3 <> -1 and $linkBerkasUsulan3 <> "") {
                                                            echo "$linkBerkasUsulan3";
                                                            echo "<small class=\"form-text text-muted\">";
                                                            echo "<br>Tgl.Upload : " . $tglUpload3 . "</small>";
                                                            ?>
                                                            <?php if ($idstatus_ptk == 3): ?>
                                                            <div id='divBtnFile3' class="fileUpload btn btn-default"
                                                                 style='margin-top: 0px;text-align: center; margin-bottom: -3px; margin-left: -1px;'>
                                                                <span id='judulFile3<?php echo $idptk; ?>'>Browse</span>
                                                                <input id="uploadFileSyaratSK<?php echo $idptk; ?>"
                                                                       name='uploadFileSyaratSK<?php echo $idptk; ?>'
                                                                       type="file" class="upload" accept=".pdf"/>
                                                            </div>
                                                            <script>
                                                                $('#uploadFileSyaratSK<?php echo $idptk;?>').bind('change', function () {
                                                                    var fileUsulanSize3<?php echo $idptk;?> = 0;
                                                                    fileUsulanSize3<?php echo $idptk;?> = this.files[0].size;
                                                                    if (parseFloat(fileUsulanSize3<?php echo $idptk;?>) > 2138471) {
                                                                        alert('Ukuran file terlalu besar');
                                                                        $("#judulFile3<?php echo $idptk;?>").text('Browse');
                                                                        $("#uploadFileSyaratSK<?php echo $idptk;?>").val("");
                                                                    } else {
                                                                        $("#judulFile3<?php echo $idptk;?>").text('Satu File');
                                                                    }
                                                                });
                                                            </script>
                                                        <?php endif; ?>
                                                        <?php }else{ ?>
                                                            <div id='divBtnFile3' class="fileUpload btn btn-default"
                                                                 style='margin-top: 0px;text-align: center; margin-bottom: -3px; margin-left: -1px;'>
                                                                <span id='judulFile3<?php echo $idptk; ?>'>Browse</span>
                                                                <input id="uploadFileSyaratSK<?php echo $idptk; ?>"
                                                                       name='uploadFileSyaratSK<?php echo $idptk; ?>'
                                                                       type="file" class="upload" accept=".pdf"/>
                                                            </div>
                                                            <script>
                                                                $('#uploadFileSyaratSK<?php echo $idptk;?>').bind('change', function () {
                                                                    var fileUsulanSize3<?php echo $idptk;?> = 0;
                                                                    fileUsulanSize3<?php echo $idptk;?> = this.files[0].size;
                                                                    if (parseFloat(fileUsulanSize3<?php echo $idptk;?>) > 2138471) {
                                                                        alert('Ukuran file terlalu besar');
                                                                        $("#judulFile3<?php echo $idptk;?>").text('Browse');
                                                                        $("#uploadFileSyaratSK<?php echo $idptk;?>").val("");
                                                                    } else {
                                                                        $("#judulFile3<?php echo $idptk;?>").text('Satu File');
                                                                    }
                                                                });
                                                            </script>
                                                        <?php } ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>4.</td>
                                                    <td>Daftar Gaji Pegawai</td>
                                                    <td>
                                                        <?php if (@$idberkas4 <> "" and @$idberkas4 <> "0" and @$idberkas4 <> -1 and @$linkBerkasUsulan4 <> "") {
                                                            echo "$linkBerkasUsulan4";
                                                            echo "<small class=\"form-text text-muted\">";
                                                            echo "<br>Tgl.Upload : " . $tglUpload4 . "</small>"; ?>
                                                            <?php if ($idstatus_ptk == 3): ?>
                                                            <div id='divBtnFile4' class="fileUpload btn btn-default"
                                                                 style='margin-top: 0px;text-align: center; margin-bottom: -3px; margin-left: -1px;'>
                                                                <span id='judulFile4<?php echo $idptk; ?>'>Browse</span>
                                                                <input id="uploadFileSyaratGaji<?php echo $idptk; ?>"
                                                                       name='uploadFileSyaratGaji<?php echo $idptk; ?>'
                                                                       type="file" class="upload" accept=".pdf"/>
                                                            </div>
                                                            <script>
                                                                $('#uploadFileSyaratGaji<?php echo $idptk;?>').bind('change', function () {
                                                                    var fileUsulanSize4<?php echo $idptk;?> = 0;
                                                                    fileUsulanSize4<?php echo $idptk;?> = this.files[0].size;
                                                                    if (parseFloat(fileUsulanSize4<?php echo $idptk;?>) > 2138471) {
                                                                        alert('Ukuran file terlalu besar');
                                                                        $("#judulFile4<?php echo $idptk;?>").text('Browse');
                                                                        $("#uploadFileSyaratGaji<?php echo $idptk;?>").val("");
                                                                    } else {
                                                                        $("#judulFile4<?php echo $idptk;?>").text('Satu File');
                                                                    }
                                                                });
                                                            </script>
                                                        <?php endif; ?>
                                                        <?php }else{ ?>
                                                            <div id='divBtnFile4' class="fileUpload btn btn-default"
                                                                 style='margin-top: 0px;text-align: center; margin-bottom: -3px; margin-left: -1px;'>
                                                                <span id='judulFile4<?php echo $idptk; ?>'>Browse</span>
                                                                <input id="uploadFileSyaratGaji<?php echo $idptk; ?>"
                                                                       name='uploadFileSyaratGaji<?php echo $idptk; ?>'
                                                                       type="file" class="upload" accept=".pdf"/>
                                                            </div>
                                                            <script>
                                                                $('#uploadFileSyaratGaji<?php echo $idptk;?>').bind('change', function () {
                                                                    var fileUsulanSize4<?php echo $idptk;?> = 0;
                                                                    fileUsulanSize4<?php echo $idptk;?> = this.files[0].size;
                                                                    if (parseFloat(fileUsulanSize4<?php echo $idptk;?>) > 2138471) {
                                                                        alert('Ukuran file terlalu besar');
                                                                        $("#judulFile4<?php echo $idptk;?>").text('Browse');
                                                                        $("#uploadFileSyaratGaji<?php echo $idptk;?>").val("");
                                                                    } else {
                                                                        $("#judulFile4<?php echo $idptk;?>").text('Satu File');
                                                                    }
                                                                });
                                                            </script>
                                                        <?php } ?>
                                                    </td>
                                                </tr>

                                                <?php if(@$pekerjaan_pasangan=='pns' or @$pekerjaan_pasangan=='pegawainegerisipil' or @$pekerjaan_pasangan=='tni' or @$pekerjaan_pasangan=='polri' or @$pekerjaan_pasangan=='p n s' or @$jmlPasanganPNS > 0): ?>
                                                <tr>
                                                    <td></td>
                                                    <td>Daftar Gaji Pasangan/Surat Keterangan<br><span style="color:darkgoldenrod;font-size: small;">Bagi PNS/Pegawai Negeri Sipil/TNI/POLRI</span></td>
                                                    <td>
                                                        <?php if ($idberkas6 <> "" and $idberkas6 <> "0" and $idberkas6 <> -1 and $linkBerkasUsulan6 <> "") {
                                                            echo "$linkBerkasUsulan6";
                                                            echo "<small class=\"form-text text-muted\">";
                                                            echo "<br>Tgl.Upload : " . $tglUpload6 . "</small>"; ?>
                                                            <?php if ($idstatus_ptk == 3): ?>
                                                            <div id='divBtnFile6' class="fileUpload btn btn-default"
                                                                 style='margin-top: 0px;text-align: center; margin-bottom: -3px; margin-left: -1px;'>
                                                                <span id='judulFile6<?php echo $idptk; ?>'>Browse</span>
                                                                <input id="uploadFileSyaratGajiPasangan<?php echo $idptk; ?>"
                                                                       name='uploadFileSyaratGajiPasangan<?php echo $idptk; ?>'
                                                                       type="file" class="upload" accept=".pdf"/>
                                                            </div>
                                                            <script>
                                                                $('#uploadFileSyaratGajiPasangan<?php echo $idptk;?>').bind('change', function () {
                                                                    var fileUsulanSize6<?php echo $idptk;?> = 0;
                                                                    fileUsulanSize6<?php echo $idptk;?> = this.files[0].size;
                                                                    if (parseFloat(fileUsulanSize6<?php echo $idptk;?>) > 2138471) {
                                                                        alert('Ukuran file terlalu besar');
                                                                        $("#judulFile6<?php echo $idptk;?>").text('Browse');
                                                                        $("#uploadFileSyaratGajiPasangan<?php echo $idptk;?>").val("");
                                                                    } else {
                                                                        $("#judulFile6<?php echo $idptk;?>").text('Satu File');
                                                                    }
                                                                });
                                                            </script>
                                                        <?php endif; ?>
                                                        <?php }else{ ?>
                                                            <div id='divBtnFile6' class="fileUpload btn btn-default"
                                                                 style='margin-top: 0px;text-align: center; margin-bottom: -3px; margin-left: -1px;'>
                                                                <span id='judulFile6<?php echo $idptk; ?>'>Browse</span>
                                                                <input id="uploadFileSyaratGajiPasangan<?php echo $idptk; ?>"
                                                                       name='uploadFileSyaratGajiPasangan<?php echo $idptk; ?>'
                                                                       type="file" class="upload" accept=".pdf"/>
                                                            </div>
                                                            <script>
                                                                $('#uploadFileSyaratGajiPasangan<?php echo $idptk;?>').bind('change', function () {
                                                                    var fileUsulanSize6<?php echo $idptk;?> = 0;
                                                                    fileUsulanSize6<?php echo $idptk;?> = this.files[0].size;
                                                                    if (parseFloat(fileUsulanSize6<?php echo $idptk;?>) > 2138471) {
                                                                        alert('Ukuran file terlalu besar');
                                                                        $("#judulFile6<?php echo $idptk;?>").text('Browse');
                                                                        $("#uploadFileSyaratGajiPasangan<?php echo $idptk;?>").val("");
                                                                    } else {
                                                                        $("#judulFile6<?php echo $idptk;?>").text('Satu File');
                                                                    }
                                                                });
                                                            </script>
                                                        <?php } ?>
                                                    </td>
                                                </tr>
                                                <?php endif; ?>

                                                <tr>
                                                    <td>5.</td>
                                                    <td>Kartu Keluarga</td>
                                                    <td>
                                                        <?php if ($idberkas5 <> "" and $idberkas5 <> "0" and $idberkas5 <> -1 and @$linkBerkasUsulan5 <> "") {
                                                            echo "$linkBerkasUsulan5";
                                                            echo "<small class=\"form-text text-muted\">";
                                                            echo "<br>Tgl.Upload : " . $tglUpload5 . "</small>";
                                                            ?>
                                                            <?php if ($idstatus_ptk == 3): ?>
                                                            <div id='divBtnFile5' class="fileUpload btn btn-default"
                                                                 style='margin-top: 0px;text-align: center; margin-bottom: -3px; margin-left: -1px;'>
                                                                <span id='judulFile5<?php echo $idptk; ?>'>Browse</span>
                                                                <input id="uploadFileSyaratKK<?php echo $idptk; ?>"
                                                                       name='uploadFileSyaratKK<?php echo $idptk; ?>'
                                                                       type="file" class="upload" accept=".pdf"/>
                                                            </div>
                                                            <script>
                                                                $('#uploadFileSyaratKK<?php echo $idptk;?>').bind('change', function () {
                                                                    var fileUsulanSize5<?php echo $idptk;?> = 0;
                                                                    fileUsulanSize5<?php echo $idptk;?> = this.files[0].size;
                                                                    if (parseFloat(fileUsulanSize5<?php echo $idptk;?>) > 2138471) {
                                                                        alert('Ukuran file terlalu besar');
                                                                        $("#judulFile5<?php echo $idptk;?>").text('Browse');
                                                                        $("#uploadFileSyaratKK<?php echo $idptk;?>").val("");
                                                                    } else {
                                                                        $("#judulFile5<?php echo $idptk;?>").text('Satu File');
                                                                    }
                                                                });
                                                            </script>
                                                        <?php endif; ?>
                                                        <?php }else{ ?>
                                                            <div id='divBtnFile5' class="fileUpload btn btn-default"
                                                                 style='margin-top: 0px;text-align: center; margin-bottom: -3px; margin-left: -1px;'>
                                                                <span id='judulFile5<?php echo $idptk; ?>'>Browse</span>
                                                                <input id="uploadFileSyaratKK<?php echo $idptk; ?>"
                                                                       name='uploadFileSyaratKK<?php echo $idptk; ?>'
                                                                       type="file" class="upload" accept=".pdf"/>
                                                            </div>
                                                            <script>
                                                                $('#uploadFileSyaratKK<?php echo $idptk;?>').bind('change', function () {
                                                                    var fileUsulanSize5<?php echo $idptk;?> = 0;
                                                                    fileUsulanSize5<?php echo $idptk;?> = this.files[0].size;
                                                                    if (parseFloat(fileUsulanSize5<?php echo $idptk;?>) > 2138471) {
                                                                        alert('Ukuran file terlalu besar');
                                                                        $("#judulFile5<?php echo $idptk;?>").text('Browse');
                                                                        $("#uploadFileSyaratKK<?php echo $idptk;?>").val("");
                                                                    } else {
                                                                        $("#judulFile5<?php echo $idptk;?>").text('Satu File');
                                                                    }
                                                                });
                                                            </script>
                                                        <?php } ?>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td colspan="4">
                                                    <span style="color: #919191;font-size: small;">
                                                        Ukuran file berkas syarat maksimal 2 MB dan bertipe PDF. <br>Nama file jangan sama. Cek kembali file yang sudah terupload.
                                                    </span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="3">
                                                        <label class="control-label col-lg-1"
                                                               for="txtCatatan<?php echo $idptk; ?>">Catatan:</label>
                                                        <input id="txtCatatan[<?php echo $idptk; ?>]"
                                                               name="txtCatatan[<?php echo $idptk; ?>]" type="text"
                                                               value="" style="width: 100%;" class="form-control">
                                                        <br>
                                                        <input type="submit"
                                                               onclick="return confirm('Anda yakin akan menghapus data?');"
                                                               name="btnHapusPtk[<?php echo $idptk; ?>]"
                                                               id="btnHapusPtk[<?php echo $i; ?>]"
                                                               class="btn btn-danger"
                                                               value="Hapus" <?php if ($idstatus_ptk != 1) echo 'disabled' ?> />
                                                        <input type="submit"
                                                               onclick="return confirm('Anda yakin akan membatalkan permohonan ini?');"
                                                               name="btnBatalkanPtk[<?php echo $idptk; ?>]"
                                                               id="btnBatalkanPtk[<?php echo $idptk; ?>]"
                                                               class="btn btn-warning"
                                                               value="Batalkan" <?php echo(($idstatus_ptk != 1 and $idstatus_ptk != 2 and $idstatus_ptk != 3) ? "disabled" : ""); ?> />
                                                        <?php if ($idstatus_ptk == 3): ?>
                                                            <input type="submit"
                                                                   onclick="return confirm('Anda yakin akan mengirim ulang usulan ini?');"
                                                                   name="btnAjukanUlangPtk[<?php echo $idptk; ?>]"
                                                                   id="btnAjukanUlangPtk[<?php echo $idptk; ?>]"
                                                                   class="btn btn-success" value="Kirim Ulang Usulan"/>
                                                        <?php else: ?>
                                                            <input type="submit"
                                                                   onclick="return confirm('Anda yakin akan mengirim usulan ini?');"
                                                                   name="btnAjukanPtk[<?php echo $idptk; ?>]"
                                                                   id="btnAjukanPtk[<?php echo $idptk; ?>]"
                                                                   class="btn btn-success"
                                                                   value="Kirim Usulan" <?php echo(($idstatus_ptk != 1 and $idstatus_ptk != 3) ? "disabled" : ""); ?> />
                                                        <?php endif; ?>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        <?php
                        $sqlHist = "select nama,DATE_FORMAT(tgl_approve_hist,  '%d/%m/%Y %H:%m:%s') as tgl_approve_hist,
                                approved_note_hist,status_ptk
                                from ptk_historis_approve inner join pegawai on ptk_historis_approve.approved_by_hist=pegawai.id_pegawai
                                inner join ref_status_ptk on ref_status_ptk.id_status_ptk = ptk_historis_approve.id_status_ptk
                                where id_ptk=$idptk ";
                        $qrun = $mysqli->query($sqlHist);
                        if ($qrun->num_rows > 0) {
                            ?>
                            <tr>
                                <td></td>
                                <td colspan="7">
                                    <?php
                                    echo("Riwayat Status Pengajuan : <br><ul>");
                                    while ($otoy = $qrun->fetch_array(MYSQLI_NUM)) {
                                        echo("<li>Status : $otoy[3] Diproses oleh $otoy[0] tanggal $otoy[1] catatan: $otoy[2] </li>");
                                    }
                                    echo("</ul>");
                                    ?>
                                </td>
                            </tr>
                        <?php }
                        $i++;
                    }
                    ?>
                </table>
                <?php
            } else {
                echo '<div style="padding: 10px;">Belum ada data</div>';
            }
            ?>
        </div>
    </div>
</div>
<div class="modal fade" id="modalUbahKeluarga" role="dialog">
    <div class="modal-dialog modal-lg" style="max-height: 420px;">
        <div class="modal-content">
            <div class="modal-header" style="border-bottom: 2px solid darkolivegreen;">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 id="jdlTabel" class="modal-title" style="border: 0px;">Form Data Keluarga</h4>
            </div>
            <div class="modal-body" style="height: 420px; width: 100%;">
                <div id="winInfoUbahKeluarga" style="margin-top: -10px;"></div>
            </div>
            <div class="modal-footer">
                <!--<button id="btnClose" type="button" class="btn btn-default" data-dismiss="modal">Close</button>-->
            </div>
        </div>
    </div>
</div>

<script>
    function pilihKeluarga(sts_tunj_skum, id_verifikasi_data, tipe_pengubahan, checkbox, berkas, kompberkas, lblberkas) {
        var $form = $('form[name="frmReqPTK"]');
        $form.bootstrapValidator('disableSubmitButtons', false);
        if ((document.getElementById(checkbox).checked) == true) {
            //alert(sts_tunj_skum + ' '+id_verifikasi_data + ' ' + tipe_pengubahan + ' ' + checkbox);
            if (id_verifikasi_data == tipe_pengubahan) {
                if (sts_tunj_skum == 'Dapat' && (tipe_pengubahan == 1 || tipe_pengubahan == 4 || tipe_pengubahan == 5)) {
                    //alert('Dapat');
                    document.getElementById(kompberkas).disabled = false;
                    $('#' + lblberkas).html(berkas);
                    $('#' + lblberkas).css({'color': 'black'});
                } else if (sts_tunj_skum == 'Tidak Dapat' && (tipe_pengubahan == 2 || tipe_pengubahan == 3 || tipe_pengubahan == 6 ||
                    tipe_pengubahan == 7 || tipe_pengubahan == 8 || tipe_pengubahan == 9 || tipe_pengubahan == 10 || tipe_pengubahan == 11 ||
                    tipe_pengubahan == 12 || tipe_pengubahan == 13 || tipe_pengubahan == 16)) {
                    //alert('Tidak Dapat' + kompberkas);
                    if (tipe_pengubahan == 12) {
                        document.getElementById(kompberkas).disabled = false;
                        $('#' + lblberkas).html('Daftar Gaji Pasangan');
                        $('#' + lblberkas).css({'color': 'black'});
                    } else if (tipe_pengubahan == 13) {
                        document.getElementById(kompberkas).disabled = false;
                        $('#' + lblberkas).html('Akta Kelahiran');
                        $('#' + lblberkas).css({'color': 'black'});
                    } else {
                        document.getElementById(kompberkas).disabled = false;
                        $('#' + lblberkas).html(berkas);
                        $('#' + lblberkas).css({'color': 'black'});
                    }
                } else {
                    alert('Cek Kembali Status Tunjangan pada SKUM');
                    document.getElementById(checkbox).checked = false;
                    document.getElementById(kompberkas).disabled = true;
                }
            } else {
                if (tipe_pengubahan == 11 || tipe_pengubahan == 12 || tipe_pengubahan == 13 || tipe_pengubahan == 14 || tipe_pengubahan == 15) {
                    if (sts_tunj_skum == 'Tidak Dapat') {
                        if (tipe_pengubahan == 12) {
                            document.getElementById(kompberkas).disabled = false;
                            $('#' + lblberkas).html('Daftar Gaji Pasangan');
                            $('#' + lblberkas).css({'color': 'black'});
                        } else if (tipe_pengubahan == 11) {
                            document.getElementById(kompberkas).disabled = false;
                            $('#' + lblberkas).html('Surat Keterangan Kerja');
                            $('#' + lblberkas).css({'color': 'black'});
                        } else if (tipe_pengubahan == 13) {
                            document.getElementById(kompberkas).disabled = false;
                            $('#' + lblberkas).html('Akta Kelahiran');
                            $('#' + lblberkas).css({'color': 'black'});
                        } else if (tipe_pengubahan == 14) {
                            document.getElementById(kompberkas).disabled = false;
                            $('#' + lblberkas).html('Ijazah');
                            $('#' + lblberkas).css({'color': 'black'});
                        } else if (tipe_pengubahan == 15) {
                            alert('Cek Kembali Status Tunjangan pada SKUM');
                            document.getElementById(checkbox).checked = false;
                            document.getElementById(kompberkas).disabled = true;
                        }
                    } else {
                        if (tipe_pengubahan == 15) {
                            document.getElementById(kompberkas).disabled = false;
                            $('#' + lblberkas).html(berkas);
                            $('#' + lblberkas).css({'color': 'black'});
                        } else {
                            alert('Cek Kembali Status Tunjangan pada SKUM');
                            document.getElementById(checkbox).checked = false;
                            document.getElementById(kompberkas).disabled = true;
                        }
                    }
                } else {
                    alert('Cek Kembali Pilihan Tipe Pengubahan');
                    document.getElementById(checkbox).checked = false;
                    document.getElementById(kompberkas).disabled = true;
                }
            }
        } else {
            $('#' + lblberkas).html('');
            document.getElementById(kompberkas).disabled = true;
        }
    }

    function ubahDataKeluarga(idkeluarga, idpegawai) {
        $("#winInfoUbahKeluarga").html("Loading...");
        var request = $.get("ubah_keluarga_pegawai.php?idkel=" + idkeluarga + "&od=" + idpegawai);
        request.pipe(
            function (response) {
                if (response.success) {
                    return ( response );
                } else {
                    return (
                        $.Deferred().reject(response)
                    );
                }
            },
            function (response) {
                return ({
                    success: false,
                    data: null,
                    errors: ["Unexpected error: " + response.status + " " + response.statusText]
                });
            }
        );
        request.then(
            function (response) {
                $("#winInfoUbahKeluarga").html(response);
            }
        );
        $("#modalUbahKeluarga").modal('show');
    }

</script>

<script src="js/moment.js"></script>
<script src="js/bootstrapValidator.js"></script>
<script type="text/javascript">
    $("#frmReqPTK").bootstrapValidator({
        message: "This value is not valid",
        excluded: ':disabled',
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            nomor: {
                feedbackIcons: "false",
                validators: {notEmpty: {message: "*"}}
            },
            sifat: {
                feedbackIcons: "false",
                validators: {notEmpty: {message: "*"}}
            },
            lampiran: {
                feedbackIcons: "false",
                validators: {notEmpty: {message: "*"}}
            }
        }
    }).on("error.field.bv", function (b, a) {
        a.element.data("bv.messages").find('.help-block[data-bv-for="' + a.field + '"]').hide()
    }).on('success.form.bv', function (e) {
        var checkboxes = $("#div2 input:checkbox");
        var jmlCheck = 0;
        var jmlFile = 0;
        for (var i = 0; i < checkboxes.length; i++) {
            if (checkboxes[i].checked == true) {
                var fileExist = $("#uploadFileSyarat" + checkboxes[i].value).val();
                if (fileExist == '') {
                    $('#lblBerkas' + checkboxes[i].value).css({'color': 'red'});
                } else {
                    jmlFile++;
                }
                jmlCheck++;
            }
        }
        if (jmlCheck == 0) {
            alert('Tidak ada anggota keluarga yang dipilih');
            var $form = $(e.target);
            $form.bootstrapValidator('disableSubmitButtons', false);
            return false;
        } else {
            if (jmlCheck > jmlFile) {
                alert('Ada ' + (parseInt(jmlCheck) - parseInt(jmlFile)) + ' berkas persyaratan yang belum dilengkapi');
                var $form = $(e.target);
                $form.bootstrapValidator('disableSubmitButtons', false);
                return false;
            }
        }
    });

</script>
