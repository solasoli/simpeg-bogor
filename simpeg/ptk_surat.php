<?php
session_start();
include("konek.php");
function monthName($bln)
{
    switch ($bln) {
        case '01':
            $namabln = 'Januari';
            break;
        case '02':
            $namabln = 'Februari';
            break;
        case '03':
            $namabln = 'Maret';
            break;
        case '04':
            $namabln = 'April';
            break;
        case '05':
            $namabln = 'Mei';
            break;
        case '06':
            $namabln = 'Juni';
            break;
        case '07':
            $namabln = 'Juli';
            break;
        case '08':
            $namabln = 'Agustus';
            break;
        case '09':
            $namabln = 'September';
            break;
        case '10':
            $namabln = 'Oktober';
            break;
        case '11':
            $namabln = 'November';
            break;
        case '12':
            $namabln = 'Desember';
            break;
    }
    return $namabln;
}

;

function intPart($float)
{
    if ($float < -0.0000001)
        return ceil($float - 0.0000001);
    else
        return floor($float + 0.0000001);
}

function Hijri2Greg($day, $month, $year, $string = false)
{
    $day = (int)$day;
    $month = (int)$month;
    $year = (int)$year;

    $jd = intPart((11 * $year + 3) / 30) + 354 * $year + 30 * $month - intPart(($month - 1) / 2) + $day + 1948440 - 385;

    if ($jd > 2299160) {
        $l = $jd + 68569;
        $n = intPart((4 * $l) / 146097);
        $l = $l - intPart((146097 * $n + 3) / 4);
        $i = intPart((4000 * ($l + 1)) / 1461001);
        $l = $l - intPart((1461 * $i) / 4) + 31;
        $j = intPart((80 * $l) / 2447);
        $day = $l - intPart((2447 * $j) / 80);
        $l = intPart($j / 11);
        $month = $j + 2 - 12 * $l;
        $year = 100 * ($n - 49) + $i + $l;
    } else {
        $j = $jd + 1402;
        $k = intPart(($j - 1) / 1461);
        $l = $j - 1461 * $k;
        $n = intPart(($l - 1) / 365) - intPart($l / 1461);
        $i = $l - 365 * $n + 30;
        $j = intPart((80 * $i) / 2447);
        $day = $i - intPart((2447 * $j) / 80);
        $i = intPart($j / 11);
        $month = $j + 2 - 12 * $i;
        $year = 4 * $k + $n + $i - 4716;
    }

    $data = array();
    $date['year'] = $year;
    $date['month'] = $month;
    $date['day'] = $day;

    if (!$string)
        return $date;
    else
        return "{$year}-{$month}-{$day}";
}

function Greg2Hijri($day, $month, $year, $string = false)
{
    $day = (int)$day;
    $month = (int)$month;
    $year = (int)$year;

    if (($year > 1582) or (($year == 1582) and ($month > 10)) or (($year == 1582) and ($month == 10) and ($day > 14))) {
        $jd = intPart((1461 * ($year + 4800 + intPart(($month - 14) / 12))) / 4) + intPart((367 * ($month - 2 - 12 * (intPart(($month - 14) / 12)))) / 12) -
            intPart((3 * (intPart(($year + 4900 + intPart(($month - 14) / 12)) / 100))) / 4) + $day - 32075;
    } else {
        $jd = 367 * $year - intPart((7 * ($year + 5001 + intPart(($month - 9) / 7))) / 4) + intPart((275 * $month) / 9) + $day + 1729777;
    }

    $l = $jd - 1948440 + 10632;
    $n = intPart(($l - 1) / 10631);
    $l = $l - 10631 * $n + 354;
    $j = (intPart((10985 - $l) / 5316)) * (intPart((50 * $l) / 17719)) + (intPart($l / 5670)) * (intPart((43 * $l) / 15238));
    $l = $l - (intPart((30 - $j) / 15)) * (intPart((17719 * $j) / 50)) - (intPart($j / 16)) * (intPart((15238 * $j) / 43)) + 29;

    $month = intPart((24 * $l) / 709);
    $day = $l - intPart((709 * $month) / 24);
    $year = 30 * $n + $j - 30;

    $date = array();
    $date['year'] = $year;
    $date['month'] = $month;
    $date['day'] = $day;

    if (!$string)
        return $date;
    else
        return "{$year}-{$month}-{$day}";
}

$blnHijriyah = array(1 => 'Muharram', 'Safar', 'Rabiul awal', 'Rabiul akhir', 'Jumadil awal', 'Jumadil akhir', 'Rajab', 'Sya\'ban', 'Ramadhan', 'Syawal', 'Dzulkaidah', 'Dzulhijjah');

$ada = false;
$idptk = $_GET['idptk'];
$sql = "SELECT pm.id_ptk,
            DATE_FORMAT(pm.tgl_input_pengajuan,  '%d') AS tgl_usulan,
            DATE_FORMAT(pm.tgl_input_pengajuan,  '%m') AS bln_usulan,
            DATE_FORMAT(pm.tgl_input_pengajuan,  '%Y') AS thn_usulan,
            pm.nomor, pm.sifat, pm.lampiran, pjp.jenis_pengajuan, p.nip_baru,
            CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
            nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(' ',p.gelar_belakang) END) AS nama, p.tempat_lahir,
            DATE_FORMAT(p.tgl_lahir, '%d-%m-%Y') AS tgl_lahir, p.jenjab, pm.last_gol, g.pangkat, pm.last_jabatan, pm.last_id_unit_kerja, p.alamat,
            pm.last_jml_pasangan, pm.last_jml_anak, pm.id_jenis_pengajuan, pm.id_pegawai_pemohon
            FROM ptk_master pm LEFT JOIN golongan g ON pm.last_gol = g.golongan,
            ptk_jenis_pengajuan pjp, pegawai p
            WHERE pm.id_ptk = $idptk AND pm.id_jenis_pengajuan = pjp.id_jenis_pengajuan AND pm.id_pegawai_pemohon = p.id_pegawai";

$query = $mysqli->query($sql);
if ($query->num_rows > 0) {
    $ada = true;
    while ($data = $query->fetch_array(MYSQLI_NUM)) {
        $idptk = $data[0];
        $tglUsulan = $data[1];
        $blnUsulan = $data[2];
        $thnUsulan = $data[3];
        $nomor = $data[4];
        $sifat = $data[5];
        $lampiran = $data[6];
        $jenis = $data[7];
        $nip = $data[8];
        $nama = $data[9];
        $tmptLahir = $data[10];
        $tglLahir = $data[11];
        $pangkat = "$data[14] - $data[13]";
        $jabatan = $data[15];
        $idunit = $data[16];
        $alamat = $data[17];
        $jmlPasangan = $data[18];
        $jmlAnak = $data[19];
        $idjenis = $data[20];
        $jk = substr($nip, 14, 1);
        $idp_pemohon = $data[21];
    }
    $sql = "SELECT uk.nama_baru FROM unit_kerja uk WHERE uk.id_unit_kerja = $idunit";
    $query = $mysqli->query($sql);
    if ($query->num_rows > 0) {
        while ($data = $query->fetch_array(MYSQLI_NUM)) {
            $unit = $data[0];
        }
    }

    $sql = "SELECT uk.id_unit_kerja FROM unit_kerja uk
                WHERE uk.nama_baru LIKE '%Sekretariat Daerah Kota Bogor%' AND uk.tahun = (SELECT MAX(tahun) FROM unit_kerja uk1)";
    $query = $mysqli->query($sql);
    if ($query->num_rows > 0) {
        while ($data = $query->fetch_array(MYSQLI_NUM)) {
            $idunitSekda = $data[0];
        }
    }
    //echo $idunitSekda.'-'.$_SESSION['id_skpd'];

    if ($idunitSekda == $_SESSION['id_skpd']) { //%Bagian Umum Setda Kota Bogor%
        $sql = "SELECT e.*, p.nip_baru as nip_plt, CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
        p.nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(' ',p.gelar_belakang) END) AS nama_plt, g.pangkat as pangkat_plt
        FROM (SELECT d.*, jplt.id_pegawai as idp_plt FROM
        (SELECT b.*, j.jabatan as jabatan_2 FROM
        (SELECT p.id_pegawai, p.nip_baru, CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
          nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(' ',p.gelar_belakang) END) AS nama,
          p.pangkat_gol, g.pangkat, c.* FROM pegawai p,
          (SELECT j.id_j, j.jabatan, j.id_bos, b.* FROM jabatan j INNER JOIN
            (SELECT a.*, uk.nama_baru, uk.Alamat, uk.telp FROM
              (SELECT uk.id_unit_kerja, uk.id_skpd FROM unit_kerja uk
              WHERE uk.nama_baru LIKE '".$unit."' AND uk.tahun =
              (SELECT MAX(tahun) FROM unit_kerja uk1)) a
              INNER JOIN unit_kerja uk ON a.id_skpd = uk.id_unit_kerja) b ON j.id_unit_kerja = b.id_unit_kerja
          WHERE j.jabatan LIKE '%Kepala Bagian%') c, golongan g WHERE p.id_j = c.id_j AND p.pangkat_gol = g.golongan) b
        LEFT JOIN jabatan j ON b.id_bos = j.id_j) d LEFT JOIN jabatan_plt jplt ON d.id_j = jplt.id_j) e
        LEFT JOIN pegawai p ON e.idp_plt = p.id_pegawai
        LEFT JOIN golongan g ON p.pangkat_gol = g.golongan";
        //echo $sql;


        $query = $mysqli->query($sql);
        if ($query->num_rows > 0) {
            while ($data = $query->fetch_array(MYSQLI_BOTH)) {
                $nmOpd = $data['nama_baru'];
                $alamatOpd = $data['Alamat'];
                $telpOpd = $data['telp'];
                $nipKepOpd = ($data['idp_plt']==''?$data['nip_baru']:$data['nip_plt']);
                $nmKepOpd = ($data['idp_plt']==''?$data['nama']:$data['nama_plt']);
                $pangkatKepOpd = ($data['idp_plt']==''?$data['pangkat']:$data['pangkat_plt']);
                $jabatan2 = substr($data['jabatan_2'],0,strpos($data['jabatan_2'], 'Setda')-1);
                $judulKep = 'A.n. Sekretaris Daerah<br>Asisten Administrasi Umum<br>u.b.<br>Kepala Bagian Umum';
                $judulKep = "<span style=\"margin-left: -30px;\">a.n. </span><strong>Sekretaris Daerah</strong><br>
                    <strong>$jabatan2</strong>,<br><span style=\"margin-left: 20px;\">u.b.</span><br>
                    <strong>".($data['idp_plt']==''?'':'Plt. ')."Kepala ".substr($unit,0,strpos($unit, 'Setda')-1)."</strong>";
            }
        }
    } else {
        $sekdaAtasan = true;
        $sql = "SELECT p.id_j, j.eselon
                FROM pegawai p LEFT JOIN jabatan j ON p.id_j = j.id_j
                WHERE p.id_pegawai = $idp_pemohon";
        $query = $mysqli->query($sql);
        if ($query->num_rows > 0) {
            while ($data = $query->fetch_array(MYSQLI_NUM)) {
                $idj = $data[0];
                $eselon = $data[1];
                if ($idj == '') {
                    $sekdaAtasan = false;
                } else {
                    if ($eselon == 'IIB') {
                        $sql = "SELECT p.nip_baru, CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
                                nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(' ',p.gelar_belakang) END) AS nama,
                                g.golongan, g.pangkat
                                FROM pegawai p, golongan g
                                WHERE p.id_j = (SELECT j.id_j FROM jabatan j
                                WHERE j.jabatan LIKE '%Sekretaris Daerah%' AND j.Tahun = (SELECT MAX(Tahun) FROM jabatan))
                                AND p.pangkat_gol = g.golongan";
                        $query = $mysqli->query($sql);
                        if ($query->num_rows > 0) {
                            while ($data = $query->fetch_array(MYSQLI_NUM)) {
                                $nipKepOpdSekda = $data[0];
                                $nmKepOpdSekda = $data[1];
                                $pangkatKepOpdSekda = "$data[3]";
                                $judulKepSekda = 'Sekretaris Daerah';
                            }
                        }
                        $sekdaAtasan = true;
                    } else {
                        $sekdaAtasan = false;
                    }
                }
            }
        } else {
            $sekdaAtasan = false;
        }

        if ($idunitSekda != $_SESSION['id_skpd']) {
            $sql = "SELECT gf.*, p.nip_baru as nip_plt, CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
                    p.nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(' ',p.gelar_belakang) END) AS nama_plt, g.pangkat as pangkat_plt,
                    p.id_j as id_j_plt, j.jabatan as jabatan_plt
                    FROM (
                    SELECT f.*, jplt.id_pegawai as idp_plt FROM
                    (SELECT e.*, CASE WHEN g.pangkat IS NULL THEN '-' ELSE g.pangkat END AS pangkat  FROM
                    (SELECT d.*, CASE d.unit_kerja WHEN @curUk THEN @curRow := @curRow + 1 ELSE @curRow := 1 END AS rank,
                    @curUk := d.unit_kerja AS opd FROM
                    (SELECT c.*, p.id_pegawai, p.nip_baru, CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
                    nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(' ',p.gelar_belakang) END) AS nama, p.pangkat_gol FROM
                    (SELECT b.*, j.jabatan, j.eselon, j.id_j FROM
                    (SELECT uk.id_unit_kerja, uk.nama_baru as unit_kerja, uk.Alamat, uk.telp FROM
                    (SELECT uk.id_skpd FROM unit_kerja uk
                    WHERE uk.tahun = (SELECT MAX(tahun) FROM unit_kerja uk1)
                    AND uk.id_unit_kerja = $idunit) a, unit_kerja uk
                    WHERE a.id_skpd = uk.id_unit_kerja) b, jabatan j
                    WHERE b.id_unit_kerja = j.id_unit_kerja AND j.jabatan != 'Walikota Bogor' AND j.jabatan != 'Wakil Walikota Bogor') c
                    LEFT JOIN pegawai p ON c.id_j = p.id_j ORDER BY c.id_unit_kerja ASC, c.eselon ASC) d
                    JOIN (SELECT @curRow := 0, @curUk := '') r) e
                    LEFT JOIN golongan g ON e.pangkat_gol = g.golongan
                    WHERE e.rank = 1 ORDER BY e.opd) f LEFT JOIN jabatan_plt jplt ON f.id_j = jplt.id_j) gf
                    LEFT JOIN pegawai p ON gf.idp_plt = p.id_pegawai
                    LEFT JOIN golongan g ON p.pangkat_gol = g.golongan
                    LEFT JOIN jabatan j ON p.id_j = j.id_j";

            //echo $sql;
            $query = $mysqli->query($sql);
            if ($query->num_rows > 0) {
                while ($data = $query->fetch_array(MYSQLI_NUM)) {
                    if($data[9]==''){
                        if($data[15]!=''){
                            $nipKepOpd = $data[15];
                            $nmKepOpd = $data[16];
                            $pangkatKepOpd = "$data[17]";
                        }
                    }else{
                        $nipKepOpd = $data[8];
                        $nmKepOpd = $data[9];
                        $pangkatKepOpd = "$data[13]";
                    }
                    $nmOpd = $data[1];
                    $alamatOpd = $data[2];
                    $telpOpd = $data[3];
                    if(strpos($data[1],'camat')){
                        $judulKep = 'Camat';
                    }else{
                        if (strpos($data[19],'Sekretaris') !== false) {
                            //$jab = '<br>Sekretaris';
                        }else{
                            $jab = ucfirst(substr($data[19],0,strpos($data[19],' pada')));
                            if($jab!=''){
                                $jab = '<br>'.$jab;
                            }
                        }
                        $judulKep = ($data[15]==''?'':'Plt. ').($_SESSION['id_skpd'] == 5347 ? 'Direktur' : 'Kepala').@$jab;
                    }
                }
                if ($_SESSION['id_skpd'] == 5350) {
                    $judulKep = 'Kepala Pelaksana BPBD';
                }
            }
        }


        if($sekdaAtasan==true){
            $nipKepOpd = $nipKepOpdSekda;
            $nmKepOpd = $nmKepOpdSekda;
            $pangkatKepOpd = $pangkatKepOpdSekda;
            $judulKep = $judulKepSekda;
        }

        if (!is_numeric($nipKepOpd)){
            $judulKep = 'Direktur';
        }

        if($nipKepOpd==''){
            $judulKep = 'Kepala';
        }
    }
}
ob_start();
?>

    <page backtop="14mm" backbottom="10mm" backleft="10mm" backright="14mm" style="font-size: 10pt">
        <table border="0" cellspacing="0" cellpadding="0" style="width: 100%;">
            <tr>
                <td style="width: 10%; border-bottom: double 2px black; padding-bottom: 10px;">
                    <img src="images/logokotabogor_gray.gif" style="width: 70px;">
                </td>
                <td style="width: 70%; text-align: center; vertical-align: top; border-bottom: double 2px black; padding-top: 0px;">
                    <span style="font-size: 120%;">PEMERINTAH KOTA BOGOR</span><br>
                    <span style="font-weight: bold;font-size:130%;"><?php echo strtoupper($nmOpd); ?></span><br>
                    <span><?php echo $alamatOpd; ?></span><br>B O G O R
                </td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: right">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: right">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="2">
                    <table border="0" cellspacing="0" cellpadding="0" style="width: 100%;margin-top: 20px;">
                        <tr>
                          <td style="width: 60%; vertical-align: top;">&nbsp;</td>
                          <td style="width: 40%;text-align: left;"><span style="text-align: right"><span style="text-align: right;margin-top: 15px; text-decoration: underline;">Bogor, <?php echo $tglUsulan . ' ' . monthName($blnUsulan) . ' ' . $thnUsulan ?></span></span></td>
                        </tr>
                        <tr>
                          <td style="width: 60%; vertical-align: top;">&nbsp;</td>
                          <td style="width: 40%;text-align: left;"><span style="text-align: left">
                            <?php
                    $hijriyah = Greg2Hijri($tglUsulan, $blnUsulan, $thnUsulan);
                    echo $hijriyah['day'] . ' ' . $blnHijriyah[(Int)$hijriyah['month']] . ' ' . $hijriyah['year'];
                    ?>
                          </span></td>
                        </tr>
                        <tr>
                            <td style="width: 60%; vertical-align: top;">
                                <table border="0" cellspacing="0" cellpadding="0" style="width: 100%;">
                                    <tr>
                                        <td style="width: 18%">Nomor</td>
                                        <td style="width: 2%">:</td>
                                        <td style="width: 60%"><?php echo $nomor; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Sifat</td>
                                        <td>:</td>
                                        <td><?php echo $sifat; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Lampiran</td>
                                        <td>:</td>
                                        <td><?php echo $lampiran; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Perihal</td>
                                        <td>:</td>
                                        <td style="width:60%">
                                            <span style="font-weight: normal;"><u>Permohonan <?php echo $jenis; ?></u></span>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                            <td style="width: 40%;text-align: left;">
                                Kepada <br>
                                Yth. Bapak Sekretaris Daerah Kota Bogor<br>
                                melalui<br>
                                Kepala Badan Kepegawaian dan Pengembangan Sumber Daya Aparatur <br>Kota Bogor<br>
                                di<br>                                B O G O R
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <table border="0" cellspacing="0" cellpadding="0" style="width: 100%;margin-top: 20px;">
                        <tr>
                            <td style="width: 77%; vertical-align: top;">
                                <table border="0" cellspacing="0" cellpadding="0" style="width: 100%;">
                                    <tr>
                                        <td style="width: 12%"></td>
                                        <td style="width: 2%"></td>
                                        <td style="width: 100%">
                                            Berdasarkan permohonan yang bersangkutan perihal <?php echo $jenis; ?> atas
                                            nama Pegawai Negeri Sipil
                                            tersebut di bawah ini : <br>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <table border="0" cellspacing="0" cellpadding="0"
                           style="width: 100%;margin-top: 20px;margin-left: 20px;">
                        <tr>
                            <td style="width: 15%;" rowspan="7"></td>
                            <td style="width: 25%; text-align: left;vertical-align: top;">Nama</td>
                            <td style="width: 2%;vertical-align: top;">:</td>
                            <td style="width: 55%;text-align: left;"><strong><?php echo "$nama"; ?></strong></td>
                        </tr>
                        <tr>
                            <td style="width: 25%; text-align: left;">Tempat / Tanggal Lahir</td>
                            <td style="width: 2%;vertical-align: top;">:</td>
                            <td style="width: 55%;text-align: left;"><?php echo "$tmptLahir, $tglLahir"; ?></td>
                        </tr>
                        <tr>
                            <td style="width: 25%; text-align: left;">NIP</td>
                            <td style="width: 2%;vertical-align: top;">:</td>
                            <td style="width: 55%;text-align: left;"><?php echo $nip; ?></td>
                        </tr>
                        <tr>
                            <td style="width: 25%; text-align: left;">Pangkat/Golongan</td>
                            <td style="width: 2%;vertical-align: top;">:</td>
                            <td style="width: 55%;text-align: left;"><?php echo $pangkat; ?></td>
                        </tr>
                        <tr>
                            <td style="width: 25%; text-align: left;vertical-align: top;">Jabatan</td>
                            <td style="width: 2%;vertical-align: top;">:</td>
                            <td style="width: 55%;text-align: left;"><?php echo $jabatan; ?></td>
                        </tr>
                        <tr>
                            <td style="width: 25%; text-align: left;vertical-align: top;">Unit Kerja</td>
                            <td style="width: 2%;vertical-align: top;">:</td>
                            <td style="width: 55%;text-align: left;"><?php echo $unit; ?></td>
                        </tr>
                        <tr>
                            <td style="width: 25%; text-align: left;vertical-align: top;">Alamat</td>
                            <td style="width: 2%;vertical-align: top;">:</td>
                            <td style="width: 55%;text-align: left;"><?php echo "$alamat"; ?></td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <table border="0" cellspacing="0" cellpadding="0" style="width: 100%;margin-top: 20px;">
                        <tr>
                            <td style="width: 77%; vertical-align: top;">
                                <table border="0" cellspacing="0" cellpadding="0" style="width: 100%;">
                                    <tr>
                                        <td style="width: 12%"></td>
                                        <td style="width: 2%"></td>
                                        <td style="width: 100%">
                                            Dengan ini kami mohon kiranya berkenan memberikan <?php echo $jenis ?> yang
                                            bersangkutan dengan data
                                            sebagai berikut :
                                            <br>
                                            <?php
                                            if ($idjenis == 3) {
                                                $syarat = array();
                                                $i = 0;
                                                echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" style=\"width: 87%;margin-top: 20px;\">";
                                                echo "<tr><td style='width: 50%'>";
                                                $sql = "SELECT ptp.kategori_pengubahan, sk.id_status, sk.status_keluarga, ptp.tipe_pengubahan_tunjangan,
                                                pk.last_nama, DATE_FORMAT(pk.last_tgl_lahir, '%d-%m-%Y') AS last_tgl_lahir, pk.last_pekerjaan, ps.last_tgl_references, ps.last_keterangan_reference,
                                                ptp.nama_berkas_syarat
                                                FROM ptk_keluarga pk, ptk_tipe_pengubahan ptp, status_kel sk, ptk_syarat ps
                                                WHERE pk.id_ptk = $idptk AND pk.id_tipe_pengubahan_tunjangan = ptp.id_tipe_pengubahan_tunjangan AND
                                                pk.last_id_status_keluarga = sk.id_status AND pk.id_ptk_keluarga = ps.id_ptk_keluarga
                                                AND ptp.kategori_pengubahan = 'Penambahan Jiwa'
                                                ORDER BY ptp.kategori_pengubahan, sk.id_status";
                                                $query = $mysqli->query($sql);
                                                if ($query->num_rows > 0) {
                                                    echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" style=\"width: 100%;\">";
                                                    echo "<tr><td colspan='4' style='font-weight: bold;'>Penambahan Jiwa : </td></tr>";
                                                    while ($data = $query->fetch_array(MYSQLI_NUM)) {
                                                        echo "<tr><td style='width: 2%;'></td>
                                                    <td style='width:35%'>Status Keluarga</td>
                                                    <td style='width:2%;'>:</td>
                                                    <td>$data[2]</td>
                                                </tr>";
                                                        echo "<tr><td style='width: 5%;'></td>
                                                    <td>Nama</td>
                                                    <td>:</td>
                                                    <td style='width:58%'>$data[4]</td>
                                                </tr>";
                                                        echo "<tr><td style='width: 5%;'></td>
                                                    <td>Tanggal Lahir</td>
                                                    <td>:</td>
                                                    <td>$data[5]</td>
                                                </tr>";
                                                        echo "<tr><td style='width: 5%;'></td>
                                                    <td>Alasan Pengajuan</td>
                                                    <td>:</td>
                                                    <td>$data[3]</td>
                                                </tr>";
                                                        echo "<tr><td colspan='4'>&nbsp;</td></tr>";
                                                        $syarat[$i] = $data[9];
                                                        $i++;
                                                    }
                                                    echo "</table>";
                                                }
                                                echo "</td><td style='width: 50%'>";
                                                $sql = "SELECT ptp.kategori_pengubahan, sk.id_status, sk.status_keluarga, ptp.tipe_pengubahan_tunjangan,
                                                pk.last_nama, DATE_FORMAT(pk.last_tgl_lahir, '%d-%m-%Y') AS last_tgl_lahir, pk.last_pekerjaan, ps.last_tgl_references, ps.last_keterangan_reference,
                                                ptp.nama_berkas_syarat
                                                FROM ptk_keluarga pk, ptk_tipe_pengubahan ptp, status_kel sk, ptk_syarat ps
                                                WHERE pk.id_ptk = $idptk AND pk.id_tipe_pengubahan_tunjangan = ptp.id_tipe_pengubahan_tunjangan AND
                                                pk.last_id_status_keluarga = sk.id_status AND pk.id_ptk_keluarga = ps.id_ptk_keluarga
                                                AND ptp.kategori_pengubahan = 'Pengurangan Jiwa'
                                                ORDER BY ptp.kategori_pengubahan, sk.id_status";
                                                $query = $mysqli->query($sql);
                                                if ($query->num_rows > 0) {
                                                    echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" style=\"width: 100%;\">";
                                                    echo "<tr><td colspan='4' style='font-weight: bold;'>Pengurangan Jiwa : </td></tr>";
                                                    while ($data = $query->fetch_array(MYSQLI_NUM)) {
                                                        echo "<tr><td style='width: 2%;'></td>
                                                    <td style='width:35%'>Status Keluarga</td>
                                                    <td style='width:2%;'>:</td>
                                                    <td>$data[2]</td>
                                                </tr>";
                                                        echo "<tr><td style='width: 5%;'></td>
                                                    <td>Nama</td>
                                                    <td>:</td>
                                                    <td style='width:58%'>$data[4]</td>
                                                </tr>";
                                                        echo "<tr><td style='width: 5%;'></td>
                                                    <td>Tanggal Lahir</td>
                                                    <td>:</td>
                                                    <td>$data[5]</td>
                                                </tr>";
                                                        echo "<tr><td style='width: 5%;'></td>
                                                    <td>Alasan Pengajuan</td>
                                                    <td>:</td>
                                                    <td>$data[3]</td>
                                                </tr>";
                                                        echo "<tr><td colspan='4'>&nbsp;</td></tr>";
                                                        $syarat[$i] = $data[9];
                                                        $i++;
                                                    }
                                                    echo "</table>";
                                                }
                                                echo "</td>";
                                                echo "</tr></table>";
                                            } else {
                                                $sql = "SELECT ptp.kategori_pengubahan, sk.id_status, sk.status_keluarga, ptp.tipe_pengubahan_tunjangan,
                                        pk.last_nama, DATE_FORMAT(pk.last_tgl_lahir, '%d-%m-%Y') AS last_tgl_lahir, pk.last_pekerjaan, ps.last_tgl_references, ps.last_keterangan_reference,
                                        ptp.nama_berkas_syarat
                                        FROM ptk_keluarga pk, ptk_tipe_pengubahan ptp, status_kel sk, ptk_syarat ps
                                        WHERE pk.id_ptk = $idptk AND pk.id_tipe_pengubahan_tunjangan = ptp.id_tipe_pengubahan_tunjangan AND
                                        pk.last_id_status_keluarga = sk.id_status AND pk.id_ptk_keluarga = ps.id_ptk_keluarga
                                        ORDER BY ptp.kategori_pengubahan, sk.id_status";
                                                $query = $mysqli->query($sql);
                                                if ($query->num_rows > 0) {
                                                    $label = "";
                                                    $syarat = array();
                                                    $i = 0;
                                                    echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" style=\"width: 87%;margin-top: 20px;\">";
                                                    while ($data = $query->fetch_array(MYSQLI_NUM)) {
                                                        if ($label == "") {
                                                            $label = $data[0];
                                                            echo "<tr><td colspan='4' style='font-weight: bold;'>$data[0] : </td></tr>";
                                                        } else {
                                                            if ($label == $data[0]) {
                                                                echo "";
                                                            } else {
                                                                echo "<tr><td colspan='4' style='font-weight: bold;'>$data[0] :</td></tr>";
                                                                $label = $data[0];
                                                            }
                                                        }
                                                        echo "<tr><td style='width: 2%;'></td>
                                                    <td style='width:20%'>Status Keluarga</td>
                                                    <td style='width:2%;'>:</td>
                                                    <td style='width:76%'>$data[2]</td>
                                                </tr>";
                                                        echo "<tr><td style='width: 10%;'></td>
                                                    <td>Nama</td>
                                                    <td>:</td>
                                                    <td style='width:76%'>$data[4]</td>
                                                </tr>";
                                                        echo "<tr><td style='width: 10%;'></td>
                                                    <td>Tanggal Lahir</td>
                                                    <td>:</td>
                                                    <td style='width:76%'>$data[5]</td>
                                                </tr>";
                                                        echo "<tr><td style='width: 10%;'></td>
                                                    <td>Alasan Pengajuan</td>
                                                    <td>:</td>
                                                    <td style='width:76%'>$data[3]</td>
                                                </tr>";
                                                        echo "<tr><td colspan='4'>&nbsp;</td></tr>";
                                                        $syarat[$i] = $data[9];
                                                        $i++;
                                                    }
                                                    echo "</table>";
                                                }
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <table border="0" cellspacing="0" cellpadding="0" style="width: 100%;">
                        <tr>
                            <td style="width: 77%; vertical-align: top;">
                                <table border="0" cellspacing="0" cellpadding="0" style="width: 100%;">
                                    <tr>
                                        <td style="width: 12%"></td>
                                        <td style="width: 2%"></td>
                                        <td style="width: 100%">
                                            Sehingga jumlah jiwa yang mendapat tunjangan keluarga
                                            menjadi <?php echo((int)$jmlPasangan + (int)$jmlAnak); ?> orang,
                                            yaitu <?php
                                            if ($jmlPasangan <> 0 and $jmlAnak <> 0) {
                                                echo "$jmlPasangan orang " . ($jk == 1 ? 'Istri' : 'Suami') . " dan $jmlAnak orang anak.";
                                            } else {
                                                if ($jmlPasangan <> 0) {
                                                    echo "$jmlPasangan orang " . ($jk == 1 ? 'Istri' : 'Suami') . ".";
                                                }
                                                if ($jmlAnak <> 0) {
                                                    echo "$jmlAnak orang anak.";
                                                }
                                            }
                                            ?> Sebagai bahan pertimbangan bersama ini kami lampirkan : <br>
                                            <table border="0" cellspacing="0" cellpadding="0"
                                                   style="width: 100%;margin-top: 10px;">
                                                <tr>
                                                    <td style="width:10%"></td>
                                                    <td style="width:3%">1.</td>
                                                    <td>Soft Copy SKUM PTK</td>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td>2.</td>
                                                    <td>Soft Copy SK. Pangkat Terakhir</td>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td>3.</td>
                                                    <td>Soft Copy Daftar Gaji Nominal Bulan Terakhir</td>
                                                </tr>
                                                <?php
                                                for ($i = 0; $i < sizeof($syarat); $i++) {
                                                    echo "<tr><td></td>
                            <td>" . ($i + 4) . ".</td>
                            <td>Soft Copy $syarat[$i]</td></tr>";
                                                }
                                                ?>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <table border="0" cellspacing="0" cellpadding="0" style="width: 100%;margin-top: 20px;">
                        <tr>
                            <td style="width: 77%; vertical-align: top;">
                                <table border="0" cellspacing="0" cellpadding="0" style="width: 100%;">
                                    <tr>
                                        <td style="width: 12%"></td>
                                        <td style="width: 2%"></td>
                                        <td style="width: 100%">
                                            Atas perhatian dan izin serta terkabulnya permohonan ini, kami sampaikan
                                            terimakasih.
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <table border="0" cellspacing="0" cellpadding="0" style="width: 100%;margin-top: 40px;">
                        <tr>
                            <td style="width:60%"></td>
                            <td style="width:40%">
                                <strong><?php echo $judulKep; ?></strong>, <br><br><br><br><br>
                                <span style="text-decoration: none;font-weight: bold;"><?php echo ($nmKepOpd==''?'Belum ada data':$nmKepOpd); ?></span>
                                <?php if (is_numeric($nipKepOpd)): ?>
                                    <br>
                                    <?php echo $pangkatKepOpd; ?><br>
                                    NIP. <?php echo $nipKepOpd; ?>
                                <?php endif; ?>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </page>
<?php

$content = ob_get_clean();

require_once('html2pdf.class.php');
try {
    $html2pdf = new HTML2PDF('P', 'Legal', 'en', true, 'UTF-8', 0);
    $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
    $html2pdf->Output('ptk_surat.pdf');
} catch (HTML2PDF_exception $e) {
    echo $e;
    exit;
}

?>
