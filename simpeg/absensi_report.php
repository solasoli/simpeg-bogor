<?php
session_start();
include("konek.php");
include ("BarcodeGenerator.php");
include ("BarcodeGeneratorJPG.php");
include ("class/unit_kerja.php");
include 'class/cls_absensi.php';
require_once('html2pdf.class.php');

include "QrCode/src/Exception/QrCodeException.php";
include "QrCode/src/Exception/InvalidPathException.php";
include "QrCode/src/QrCodeInterface.php";
include "QrCode/src/QrCode.php";
include "QrCode/php-enum-master/src/Enum.php";
include "QrCode/src/ErrorCorrectionLevel.php";
include "QrCode/src/LabelAlignment.php";
include "QrCode/src/Writer/WriterInterface.php";
include "QrCode/src/Writer/AbstractWriter.php";
include "QrCode/src/Writer/BinaryWriter.php";
include "QrCode/src/Writer/DebugWriter.php";
include "QrCode/BaconQrCode/Renderer/Color/ColorInterface.php";
include "QrCode/BaconQrCode/Renderer/Color/Rgb.php";
include "QrCode/BaconQrCode/Common/AbstractEnum.php";
include "QrCode/BaconQrCode/Common/ErrorCorrectionLevel.php";
include "QrCode/src/Traits/BaconConversionTrait.php";
include "QrCode/src/Writer/EpsWriter.php";
include "QrCode/src/WriterRegistryInterface.php";
include "QrCode/BaconQrCode/Renderer/RendererInterface.php";
include "QrCode/BaconQrCode/Renderer/Image/RendererInterface.php";
include "QrCode/BaconQrCode/Renderer/Image/AbstractRenderer.php";
include "QrCode/BaconQrCode/Renderer/Image/Png.php";
include "QrCode/BaconQrCode/Common/Mode.php";
include "QrCode/BaconQrCode/Common/BitArray.php";
include "QrCode/BaconQrCode/Common/CharacterSetEci.php";
include "QrCode/BaconQrCode/Common/EcBlock.php";
include "QrCode/BaconQrCode/Common/EcBlocks.php";
include "QrCode/BaconQrCode/Common/Version.php";
include "QrCode/BaconQrCode/Common/ReedSolomonCodec.php";
include "QrCode/BaconQrCode/Encoder/BlockPair.php";
include "QrCode/BaconQrCode/Encoder/QrCode.php";
include "QrCode/BaconQrCode/Encoder/ByteMatrix.php";
include "QrCode/BaconQrCode/Encoder/MatrixUtil.php";
include "QrCode/BaconQrCode/Common/BitUtils.php";
include "QrCode/BaconQrCode/Encoder/MaskUtil.php";
include "QrCode/BaconQrCode/Encoder/Encoder.php";
include "QrCode/BaconQrCode/Writer.php";
include "QrCode/src/Writer/PngWriter.php";
include "QrCode/src/Writer/SvgWriter.php";
include "QrCode/src/WriterRegistry.php";

use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\LabelAlignment;
use Endroid\QrCode\Factory\QrCodeFactory;
use Endroid\QrCode\QrCode;

$html2pdf = new HTML2PDF('L', 'Legal', 'en', true, 'UTF-8', 0);
$oAbsensi = new Absensi();
$unit_kerja = new Unit_kerja;


$sql = "SELECT MAX(uk.id_unit_kerja) AS id_unit_kerja, uk.nama_baru FROM unit_kerja uk
		WHERE uk.nama_baru LIKE '%Sekretariat Daerah%' AND uk.tahun = (SELECT MAX(tahun) FROM unit_kerja uk1)";
$query = $mysqli->query($sql);
$dataSekret = $query->fetch_array(MYSQLI_BOTH);
if($_SESSION['id_skpd'] == $dataSekret[0]){
    $idunit = $_SESSION['id_skpd'];
}else{
    $idunit = $_SESSION['id_unit'];
}
$db = Database::getInstance();
$mysqli = $db->getConnection();

$id_skpd = $_SESSION['id_skpd'];
if($_SESSION['id_skpd'] == $dataSekret[0]){
    $auth = 0;
}else {
    if (in_array(2, $_SESSION['role'])) {
        $sqlCountUnit = "SELECT COUNT(uk.id_unit_kerja) AS jmlUnit
                         FROM unit_kerja uk WHERE uk.id_skpd = " . $id_skpd . " AND uk.id_unit_kerja <> uk.id_skpd AND
                         uk.tahun = (SELECT MAX(tahun) FROM unit_kerja uk1)";

        $query = $mysqli->query($sqlCountUnit);
        $data = $query->fetch_array(MYSQLI_BOTH);
        if ((int)$data[0] > 0) {
            $auth = 1;
        } else {
            $auth = 0;
        }
    }else if (in_array(7, $_SESSION['role'])){
        $auth = 1;
    }else{
        $auth = 0;
    }
}

$bln = $_GET['bln'];
$thn = $_GET['thn'];

if(isset($bln) and $bln!='' and $bln!='0'){

}else{
    $bln = date("m");
}

$a_date = "$thn-$bln-01";
$maxday = date("t", strtotime($a_date));

if(isset($thn) and $thn!='' and $thn!='0'){

}else{
    $thn = date("Y");
}

if($auth==1){
    if (in_array(7, $_SESSION['role'])){
        $id_unit_kerja = $_SESSION['id_unit'];
    }else{
        if(isset($_GET['id_unit'])){
            $id_unit_kerja = $_GET['id_unit'];
        }else{
            $id_unit_kerja = $_SESSION['id_unit'];
        }
    }
}else{
    $id_unit_kerja = $_SESSION['id_unit'];
}

//$id_unit_kerja = $_GET['id_unit'];

function smart_wordwrap($string, $width = 75, $break = "<br>") {
// split on problem words over the line length
    $pattern = sprintf('/([^ ]{%d,})/', $width);
    $output = '';
    $words = preg_split($pattern, $string, -1, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);

    foreach ($words as $word) {
        // normal behaviour, rebuild the string
        if (false !== strpos($word, ' ')) {
            $output .= $word;
        } else {
            // work out how many characters would be on the current line
            $wrapped = explode($break, wordwrap($output, $width, $break));
            $count = $width - (strlen(end($wrapped)) % $width);

            // fill the current line and add a break
            $output .= substr($word, 0, $count) . $break;

            // wrap any remaining characters from the problem word
            $output .= wordwrap(substr($word, $count), $width, $break, true);
        }
    }

    // wrap the final output
    return wordwrap($output, $width, $break);
}

ob_start();

?>

<page orientation="L" backtop="10mm" backbottom="10mm" backleft="15mm" backright="10mm" style="font-size: 8pt">
    <table border="0" cellspacing="0" cellpadding="0"
           style="width: 100%;">
        <tr>
            <td style="padding-right: 10px;">
                <img src="images/logokotabogor_gray.gif" width="50" height="60">
            </td>
            <td style="width: 88%;">
                <span style="font-size: large;font-weight: bold;">REKAPITULASI WAKTU KEHADIRAN ABSENSI PEGAWAI
                </span><br><span style="font-size:14px;"><?php echo $unit_kerja->get_unit_kerja((($_GET['id_unit']=='undefined' or $_GET['id_unit']=='')?$_SESSION['id_unit']:$_GET['id_unit']))->nama_baru ?><br>
                    Periode : <?php echo $oAbsensi->monthName($bln).' '.$thn; ?>
                </span>
            </td>
            <td style="text-align: right;">
                <!-- QR Code -->
                <?php
                $qrCode = new QrCode($_SERVER['REQUEST_URI']);
                $qrCode->setSize(75);
                $qrCode->setWriterByName('png');
                $qrCode->setMargin(10);
                $qrCode->setEncoding('UTF-8');
                $qrCode->setErrorCorrectionLevel(ErrorCorrectionLevel::HIGH);
                $qrCode->setForegroundColor(['r' => 0, 'g' => 0, 'b' => 0]);
                $qrCode->setBackgroundColor(['r' => 255, 'g' => 255, 'b' => 255]);
                //$qrCode->setLabel('Pindai Kode QR', 6, getcwd().'/images/noto_sans.otf', LabelAlignment::CENTER);
                $qrCode->setLogoPath(getcwd().'/images/bkpsda.png');
                $qrCode->setLogoWidth(50);
                $qrCode->setValidateResult(false);
                $qrCode->writeFile(getcwd().'/images/qrcode.png');
                ?>
                <img src="images/qrcode.png" width="75" height="75">
            </td>
        </tr>
    </table>
    <?php

    //echo 'CEK :'.$id_skpd.'-'.$dataSekret[0];
    if($id_skpd == $dataSekret[0]){
        //$str = "uk.id_skpd = $id_skpd";
        $sts_daftar = 'opd';
        $unit = $id_skpd;
    }else{
        //$str = "uk.id_unit_kerja = ".$id_unit_kerja;
        $sts_daftar = 'unit';
        $unit = $id_unit_kerja;
    }

    $sqlCall = "CALL PRCD_ABSEN_JADWAL_KHUSUS(".$id_skpd.",".$bln.",".$thn.");";
    $qrysqlCall = $mysqli->query($sqlCall);

    $sqlCall = "CALL PRCD_ABSEN_REPORT('".$sts_daftar."',".$unit.", '".$thn."-$bln"."',".$id_skpd.");";
    $qrysqlCall = $mysqli->query($sqlCall);
    if (!is_object($qrysqlCall)) {
        print 'object is expected in param1, ' . gettype($qrysqlCall) . ' is given';
        return NULL;
    }
    $qrysqlCall->data_seek(0);
    while ($row = $qrysqlCall->fetch_row()){
        $strSQLAbsen = $row[0];
    }
    $qrysqlCall->close();
    $mysqli->next_result();
    $resultData = $mysqli->query($strSQLAbsen);
    //print_r($strSQLAbsen);
    if (!$resultData) {
        trigger_error('Invalid query: ' . $mysqli->error);
    }
    if ($resultData->num_rows > 0) {
        echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" style=\"width: 100%;margin-top: 10px;\">";
        echo "<thead style=\"display:table-header-group;\">";
        echo "<tr>
                <td rowspan=\"2\" style=\"padding:5px; padding-bottom:10px; vertical-align: middle; text-align: center; border-left: 1px solid black; border-top: 1px solid black;border-bottom: 2px solid black;\">No</td>
                <td rowspan=\"2\" style=\"vertical-align: middle; text-align: center;border-left: 1px solid black;border-top: 1px solid black;border-bottom: 2px solid black; width: 100px;\">Nama/NIP</td>
                <td rowspan=\"2\" style='padding: 5px;border-left: 1px solid black;border-bottom: 2px solid black;border-top: 1px solid black;'>&nbsp;Status</td>
                <td style=\"padding-left:10px;text-align: center;border-left: 1px solid black;border-top: 1px solid black;border-bottom: 1px solid black;border-right: 1px solid black;border-right: 1px solid black;\" colspan=\"".($maxday)."\">Tanggal</td>
              
              </tr>";
        echo "<tr style='text-align: center;'>";
        for($i=1;$i<=$maxday;$i++) {
            if($i==$maxday){
                $border = 'border-right: 1px solid black;';
            }else{
                $border = '';
            }
            echo("<td style='padding:5px; width=8; border-left: 1px solid black;border-bottom: 2px solid black;$border'>$i</td>");
        }
        echo "</tr>";
        echo "</thead>";
        $no=1;
        $b=0;
        while ($report = $resultData->fetch_array(MYSQLI_BOTH)) {
            echo "<tr><td rowspan=\"2\" align=\"center\" style='vertical-align: middle; text-align: center;border-left: 1px solid black;border-bottom: 1px solid black;'>$no</td>";
            echo "<td rowspan=\"2\" valign=\"top\" style=\"word-wrap: break-word; padding:5px;border-left: 1px solid black;border-bottom: 1px solid black;\">".smart_wordwrap($report['nama'],34)."<br>$report[nip_baru]</td>";
            echo "<td style='border-left: 1px solid black;border-bottom: 1px solid black;'>&nbsp;Masuk&nbsp;</td>";
            for ($i = 1; $i <= ($maxday); $i++){
                $tempDate = "$thn-$bln-$i";
                $dayN = date('D', strtotime( $tempDate));
                $index=$i;
                if($dayN=='Sun' or $dayN=='Sat') {
                    $latar=" bgcolor=#d3d3d3 ";
                }else{
                    $latar=" ";
                }
                if($i==$maxday){
                    $border = 'border-right: 1px solid black;';
                }else{
                    $border = '';
                }
                echo "<td $latar style='text-align: center;padding-left: 2px;padding-right: 2px;border-left: 1px solid black;border-bottom: 1px solid black;$border'>".(strlen($report['min_'.$index])==8?substr($report['min_'.$index], 0, strlen($report['min_'.$index]) - 3):$report['min_'.$index])."</td>";
            }
            echo "</tr>";
            echo "<tr style='text-align: center;'>";
            echo "<td style='border-left: 1px solid black;border-bottom: 1px solid black;'>&nbsp;Pulang&nbsp;</td>";
            for ($i = 1; $i <= ($maxday); $i++){
                $tempDate = "$thn-$bln-$i";
                $dayN = date('D', strtotime( $tempDate));
                $index=$i;
                if($dayN=='Sun' or $dayN=='Sat') {
                    $latar=" bgcolor=#d3d3d3 ";
                }else{
                    $latar=" ";
                }
                if($i==$maxday){
                    $border = 'border-right: 1px solid black;';
                }else{
                    $border = '';
                }
                echo "<td $latar style='text-align: center;padding-left: 2px;padding-right: 2px;border-left: 1px solid black;border-bottom: 1px solid black;$border'>".(strlen($report['max_'.$index])==8?substr($report['max_'.$index], 0, strlen($report['max_'.$index]) - 3):$report['max_'.$index])."</td>";
            }
            echo "</tr>";
            $no++;
        }
        echo "</table>";
    }else{
        echo "Tidak Ada Data";
    }
    ?>

    <?php
    //echo 'CEK : '.$dataSekret[0].'-'.$_SESSION['id_skpd'];
    if ($dataSekret[0] == $_SESSION['id_skpd']) { //%Bagian Umum Setda Kota Bogor%
        //echo $unit;

        $sql = "SELECT e.*, p.nip_baru as nip_plt, CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
                    p.nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(' ',p.gelar_belakang) END) AS nama_plt, g.pangkat as pangkat_plt
                    FROM (SELECT d.*, jplt.id_pegawai as idp_plt FROM
                    (SELECT b.*, j.jabatan as jabatan_2 FROM
                    (SELECT p.id_pegawai, p.nip_baru, CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
                    nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(' ',p.gelar_belakang) END) AS nama,
                    p.pangkat_gol, g.pangkat, c.* FROM pegawai p,
                    (SELECT j.id_j, j.jabatan, j.id_bos, b.* FROM jabatan j
                    INNER JOIN unit_kerja uker ON j.id_unit_kerja = uker.id_unit_kerja
                    INNER JOIN
                    (SELECT a.*, uk.nama_baru, uk.Alamat, uk.telp FROM
                    (SELECT uk.id_unit_kerja, uk.id_skpd FROM unit_kerja uk
                    WHERE uk.nama_baru LIKE '".$dataSekret[1]."' AND uk.tahun =
                    (SELECT MAX(tahun) FROM unit_kerja uk1)) a
                    INNER JOIN unit_kerja uk ON a.id_skpd = uk.id_unit_kerja) b ON uker.id_skpd = b.id_unit_kerja
                    WHERE j.jabatan LIKE '%Kepala Bagian Umum%') c, golongan g WHERE p.id_j = c.id_j AND p.pangkat_gol = g.golongan) b
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
                        <strong>".($data['idp_plt']==''?'':'Plt. ')."Kepala Bagian Umum"."</strong>";
            }
        }
    } else {
        $sekdaAtasan = true;
        $sql = "SELECT p.id_j, j.eselon
                    FROM pegawai p LEFT JOIN jabatan j ON p.id_j = j.id_j
                    WHERE p.id_pegawai =null";
        $query = $mysqli->query($sql);
        if (@$query->num_rows > 0) {
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

        if ($dataSekret[0] != $_SESSION['id_skpd']) {
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
                        if(strpos($data[1],'camat')){
                            $judulKep = 'Camat';
                        }else{
                            if (strpos($data[19],'Sekretaris') !== false) {
                                $jab = '<br>Sekretaris';
                            }else{
                                $jab = ucfirst(substr($data[19],0,strpos($data[19],' pada')));
                                if($jab!=''){
                                    $jab = '<br>'.$jab;
                                }
                            }
                            $judulKep = ($data[15]==''?'':'Plt. ').'Kepala'.$jab;
                        }
                        $judulKep = ($data[15]==''?'':'Plt. ').'Kepala'.$jab;
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
    ?>
    <br><br><br><br>
    <table border="0" cellspacing="0" cellpadding="0" style="width: 100%;">
        <tr>
            <td style="width: 70%"></td>
            <td style="width: 30%">
                <strong><?php echo $judulKep; ?></strong>, <br><br><br><br><br><br><br>
                <span style="text-decoration: none;font-weight: bold;"><?php echo $nmKepOpd; ?></span>
                <?php if (is_numeric($nipKepOpd)): ?>
                    <br>
                    <?php echo $pangkatKepOpd; ?><br>
                    NIP. <?php echo $nipKepOpd; ?>
                <?php endif; ?>
            </td>
        </tr>
    </table>

</page>

<?php

$content = ob_get_clean();
try
{
    $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
    $html2pdf->Output('Laporan_Absensi_Pegawai.pdf');
}catch(HTML2PDF_exception $e) {
    echo $e;
    exit;
}

?>
