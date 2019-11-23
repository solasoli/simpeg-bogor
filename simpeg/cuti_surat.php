<?php
session_start();
include("konek.php");
include ("BarcodeGenerator.php");
include ("BarcodeGeneratorJPG.php");

function intPart($float)
{
    if ($float < -0.0000001)
        return ceil($float - 0.0000001);
    else
        return floor($float + 0.0000001);
}


function Greg2Hijri($day, $month, $year, $string = false)
{
    $day   = (int) $day;
    $month = (int) $month;
    $year  = (int) $year;


    if (($year > 1582) or (($year == 1582) and ($month > 10)) or (($year == 1582) and ($month == 10) and ($day > 14)))
    {
        $jd = intPart((1461*($year+4800+intPart(($month-14)/12)))/4)+intPart((367*($month-2-12*(intPart(($month-14)/12))))/12)-
        intPart( (3* (intPart(  ($year+4900+    intPart( ($month-14)/12)     )/100)    )   ) /4)+$day-32075;
    }
    else
    {
        $jd = 367*$year-intPart((7*($year+5001+intPart(($month-9)/7)))/4)+intPart((275*$month)/9)+$day+1729777;
    }


    $l = $jd-1948440+10632;
    $n = intPart(($l-1)/10631);
    $l = $l-10631*$n+354;
    $j = (intPart((10985-$l)/5316))*(intPart((50*$l)/17719))+(intPart($l/5670))*(intPart((43*$l)/15238));
    $l = $l-(intPart((30-$j)/15))*(intPart((17719*$j)/50))-(intPart($j/16))*(intPart((15238*$j)/43))+29;
    
    $month = intPart((24*$l)/709);
    $day   = $l-intPart((709*$month)/24);
    $year  = 30*$n+$j-30;
    
    $date = array();
    $date['year']  = $year;
    $date['month'] = $month;
    $date['day']   = $day;


    if (!$string)
        return $date;
    else
        return "{$year}-{$month}-{$day}";
}

function monthName($bln){
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
};

function kekata($x) {
    $x = abs($x);
    $angka = array("", "satu", "dua", "tiga", "empat", "lima",
        "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
    $temp = "";
    if ($x <12) {
        $temp = " ". $angka[$x];
    } else if ($x <20) {
        $temp = kekata($x - 10). " belas";
    } else if ($x <100) {
        $temp = kekata($x/10)." puluh". kekata($x % 10);
    } else if ($x <200) {
        $temp = " seratus" . kekata($x - 100);
    } else if ($x <1000) {
        $temp = kekata($x/100) . " ratus" . kekata($x % 100);
    } else if ($x <2000) {
        $temp = " seribu" . kekata($x - 1000);
    } else if ($x <1000000) {
        $temp = kekata($x/1000) . " ribu" . kekata($x % 1000);
    } else if ($x <1000000000) {
        $temp = kekata($x/1000000) . " juta" . kekata($x % 1000000);
    } else if ($x <1000000000000) {
        $temp = kekata($x/1000000000) . " milyar" . kekata(fmod($x,1000000000));
    } else if ($x <1000000000000000) {
        $temp = kekata($x/1000000000000) . " trilyun" . kekata(fmod($x,1000000000000));
    }
    return $temp;
}


function terbilang($x, $style=4) {
    if($x<0) {
        $hasil = "minus ". trim(kekata($x));
    } else {
        $hasil = trim(kekata($x));
    }
    switch ($style) {
        case 1:
            $hasil = strtoupper($hasil);
            break;
        case 2:
            $hasil = strtolower($hasil);
            break;
        case 3:
            $hasil = ucwords($hasil);
            break;
        default:
            $hasil = ucfirst($hasil);
            break;
    }
    return $hasil;
}

//$hijriDate = Greg2Hijri(date("d"), date("m"), date("Y"));
//$hijriMonth = array ("Muharram", "Safar", "(Rabīal-Awwal", "Rabī ath-Thānī ", "Jumādā al-Ula", "Jumādā ath-Thāniya", "Rajab", "Sha'ban", "Ramadan", "Shawwal", "Dhū al-Qa'da", "Dhū al-Hijjah");
$hijriMonth = array ("Muharram", "Safar", "(Rabi'ul Awal", "Rabi'ul Akhir", "Jumadil Awal", "Jumadil Akhir", "Rajab", "Sya'ban", "Ramadhan", "Syawal", "Dzulqa'dah", "Dzulhijjah");
//$year = $hijriDate["year"];
//$month = $hijriMonth[$hijriDate["month"]-1];
//$day = $hijriDate["day"];
//$tgl_cuti = date('d').' '.monthName(date('m')).' '.date('Y');
//$tgl_cuti_hijriyah = $day.' '.$month.' '.$year;

$sql_list_cuti = "SELECT cuti_pegawai.*, g.pangkat as pangkat_pjbt
                  FROM
                  (SELECT cuti_pegawai.*, g.pangkat AS pangkat_atsl FROM
                  (SELECT cuti_pegawai.*, CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
                  p.nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(', ',p.gelar_belakang) END) as nama, p.nip_baru,
                  DATE_FORMAT(cuti_pegawai.tgl_usulan_cuti,  '%d') AS tgl_usulan,
                  DATE_FORMAT(cuti_pegawai.tgl_usulan_cuti,  '%m') AS bln_usulan,
                  DATE_FORMAT(cuti_pegawai.tgl_usulan_cuti,  '%Y') AS thn_usulan,
                  DATE_FORMAT(cuti_pegawai.tmt_awal,  '%d/%m/%Y') AS tmt_awal_cuti,
                  DATE_FORMAT(cuti_pegawai.tmt_akhir,  '%d/%m/%Y') AS tmt_akhir_cuti,
                  CASE
                  WHEN (p.ponsel IS NULL = 0 AND p.ponsel != '') AND (p.telepon IS NULL = 0 AND p.telepon != '') THEN
                    CONCAT(p.ponsel, ' / ',p.telepon)
                  ELSE
                    CASE WHEN (p.ponsel IS NULL = 0 AND p.ponsel != '') THEN p.ponsel ELSE
                      CASE WHEN (p.telepon IS NULL = 0 AND p.telepon != '') THEN p.telepon ELSE '' END
                    END
                  END AS nokontak
                     FROM
                     (SELECT cm.*, rs.status_cuti, cj.deskripsi, g.pangkat AS pangkat_p FROM cuti_master cm, ref_status_cuti rs, cuti_jenis cj, golongan g
                     WHERE cm.id_status_cuti = rs.idstatus_cuti AND cm.id_jenis_cuti = cj.id_jenis_cuti AND cm.last_gol = g.golongan
                      AND cm.id_pegawai = $_SESSION[id_pegawai] AND cm.id_cuti_master = ".$_GET['idcm'].") as cuti_pegawai, pegawai p
                    WHERE cuti_pegawai.id_pegawai = p.id_pegawai AND p.id_pegawai = $_SESSION[id_pegawai]) AS cuti_pegawai
                    LEFT JOIN golongan g ON cuti_pegawai.last_atsl_gol = g.golongan) AS cuti_pegawai
                    LEFT JOIN golongan g ON cuti_pegawai.last_pjbt_gol = g.golongan";

$query_row_cuti_master = mysql_query($sql_list_cuti);
$data = mysql_fetch_array($query_row_cuti_master);

$nip = $data["nip_baru"];
$tgl_cuti = $data['tgl_usulan'].' '.monthName($data['bln_usulan']).' '.$data['thn_usulan'];
$hijriDate = Greg2Hijri($data[36], $data[37], $data[38]);
$tgl_cuti_hijriyah = $hijriDate["day"].' '.$hijriMonth[$hijriDate["month"]-1].' '.$hijriDate["year"];

ob_start();
?>

<page backtop="14mm" backbottom="14mm" backleft="10mm" backright="10mm" style="font-size: 11pt">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="500">&nbsp;</td>
        <td>Bogor,<u> <?php echo @$tgl_cuti; ?></u><br>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<?php // echo @$tgl_cuti_hijriyah; ?></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>Kepada</td>
      </tr>
      <tr>
        <td align="right">Yth </td>
        <td>&nbsp;&nbsp; Kepala BKPSDA Kota Bogor</td>
      </tr>
      <tr>
        <td align="left">Perihal : <span style="text-decoration: underline">Permohonon <?php echo @$data['deskripsi']; ?></span></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td align="left">&nbsp;</td>
        <td>&nbsp;&nbsp; Di -</td>
      </tr>
      <tr>
        <td align="left">&nbsp;</td>
        <td>&nbsp;&nbsp; Bogor</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
  </tr>
  <tr>
    <td align="center">Yang bertanda tangan di bawah ini:</td>
  </tr>
  </table>


<table  border="0" align="left" cellpadding="0" cellspacing="0" style="position:absolute; top:175px; left:62px;" >
    <tr>
        <td >&nbsp;</td>
        <td>&nbsp;</td>
        <td >&nbsp;</td>
    </tr>
    <tr>
    <td align="left" valign="bottom" style="padding-bottom:10px;">Nama</td>
    <td align="left" valign="bottom" style="padding-bottom:10px;">:</td>
    <td align="left" valign="bottom" style="padding-bottom:10px;"><b><?php echo @$data['nama']; ?></b></td>
  </tr>
  <tr>
    <td align="left" valign="bottom" style="padding-bottom:10px;">NIP</td>
    <td align="left" valign="bottom" style="padding-bottom:10px;">:</td>
    <td align="left" valign="bottom" style="padding-bottom:10px;"><?php echo @$data['nip_baru']; ?></td>
  </tr>
  <tr>
    <td align="left" valign="bottom" style="padding-bottom:10px;">Pangkat / Gol.Ruang</td>
    <td align="left" valign="bottom" style="padding-bottom:10px;">:</td>
    <td align="left" valign="bottom" style="padding-bottom:10px;"><?php echo @$data['pangkat_p'].", ".$data[6]; ?></td>
  </tr>
  <tr>
    <td align="left" valign="top" style="padding-bottom:10px;">Jabatan</td>
    <td align="left" valign="top" style="padding-bottom:10px;">:</td>
    <td width="480" align="left" valign="top" style="word-break: break-all !important;padding-bottom:10px;"><?php echo @$data[5]; ?></td>
  </tr>
  <tr>
    <td align="left" valign="top" style="padding-bottom:10px;">Unit Kerja</td>
    <td align="left" valign="top" style="padding-bottom:10px;">:</td>
    <td width="480" align="left" valign="top" style="word-break: break-all !important;padding-bottom:10px;"><?php echo @$data['last_unit_kerja']; ?></td>
  </tr>
</table>
<br /><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<div align="justify" style="line-height:1.5; width:600px;" >Dengan ini mengajukan permohonan <?php echo @$data['deskripsi']; ?>  <?php echo($data['is_cuti_mundur']==1?' (Cuti Mundur)':'');?> selama <?php echo $data['lama_cuti']; ?> <?php echo "(".terbilang($data['lama_cuti'], $style=3).")";?> hari Kerja terhitung mulai tanggal <?php echo $data['tmt_awal_cuti']; ?> s.d. <?php echo $data['tmt_akhir_cuti']; ?>, Selama menjalankan cuti alamat saya di <?php echo $data['keterangan']; ?>. Nomor telp yang bisa dihubungi <?php

$nomor=explode(' ',$data['nokontak']);
echo $nomor[0]; ?>. </div><br />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<div align="justify" style="line-height:1.5; width:600px;" >Demikian permohonan ini saya buat untuk dapat dipertimbangkan sebagaimana mestinya. </div>
<br />

    <table  border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#000" style="width: 90%;">
        <tr>
            <td style="width: 50%;"></td>
            <td style="width: 50%; text-align: center">
                Hormat Saya, <br /><br /><br /><br />
                <strong><?php echo @$data['nama'];?></strong><br/>
                <?php echo @$data['pangkat_p'];?><br/>
                NIP.<?php echo @$data['nip_baru']; ?>
            </td>
        </tr>
    </table>

    <br /><br /><br />
<table  border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#000" style="width: 80%;">
          <tr>
            <td style="width: 50%;padding: 10px;vertical-align: middle;">Catatan Kepegawaian</td>
            <td style="width: 50%;padding: 10px;vertical-align: middle;" align="center">Catatan Pertimbangan</td>
          </tr>
          <tr>
            <td style="padding: 10px;width: 50%;">Cuti yang telah diambil dalam tahun <br />yang bersangkutan :<br />
            <ol>
            <li> Cuti Tahunan </li>
            <li> Cuti Besar </li>
            <li> Cuti Sakit </li>
            <li> Cuti Bersalin </li>
            <li> Cuti Karena Alasan Penting </li>
            <li> Keterangan lain-lain </li>
            </ol>
            </td>
            <td valign="top" style="padding-top:10px;padding:10px;width: 50%;"><div align="center">Atasan Langsung</div>
                <?php
                    $sql = "SELECT pjbt.*, j.jabatan FROM
                            (SELECT atsl.*, jp.id_j FROM
                            (SELECT p.id_pegawai as idp_atasan
                            FROM pegawai p WHERE nip_baru = '".@$data['last_atsl_nip']."') atsl
                            LEFT JOIN jabatan_plt jp ON atsl.idp_atasan = jp.id_pegawai) pjbt
                            LEFT JOIN jabatan j ON pjbt.id_j = j.id_j";
                    $query_row_atsl = mysql_query($sql);
                    $data_atsl = mysql_fetch_array($query_row_atsl);
                ?>
                <div align="center" style="width:400px;" >
                    <?php
                        if($data_atsl['id_j']==''){
                            echo @$data['last_atsl_jabatan'];
                        }else{
                            echo 'Plh. '.$data_atsl['jabatan'];
                        }
                    ?>
                </div>
                <br /><br /><br /><br /><br /><br />
                <div align="center"><u><b><?php echo @$data['last_atsl_nama']; ?> </b></u><br />
                    <?php echo @$data['pangkat_atsl'] ?><br />
                    <?php
                        if (is_numeric($data['last_atsl_nip'])){
                            echo 'NIP. '.@$data['last_atsl_nip'];
                        }

                    ?></div>
            </td>
          </tr>
          <tr>
            <td valign="bottom" style="padding-top:10px;padding:10px;width: 50%;text-align: center;">
                <?php
                    $generator = new Picqer\Barcode\BarcodeGeneratorJPG();
                    //echo '<img src="data:image/jpg;base64,' . base64_encode($generator->getBarcode(@$data['id_pegawai'].'-'.$_GET['idcm'], $generator::TYPE_CODE_128)) . '">';
                    echo '<img src="data:image/jpg;base64,' . base64_encode($generator->getBarcode(@$nip, $generator::TYPE_INTERLEAVED_2_5)) . '">';
                    echo '<br><small>'.$nip.'-'.$_GET['idcm'].'</small>';
                ?>
            </td>
            <?php
                if(strlen($data['last_pjbt_jabatan'])<=35 and strlen($data['last_pjbt_jabatan'])>15 ) {
                    $lebar=260;
                    $margin=0;
                } elseif(strlen($data['last_pjbt_jabatan'])<=15) {
                    $lebar=140;
                    $margin=-68;
                } else {
                    $lebar=400;
                    $margin=0;
                }
			
			?>
            <td valign="top" style="padding-top:10px;padding:10px;width: 50%;text-align: center;">
                Pejabat yang berwenang memberikan ijin cuti<br>
                <?php
                    $sql = "SELECT pjbt.*, j.jabatan FROM
                                (SELECT atsl.*, jp.id_j FROM
                                (SELECT p.id_pegawai as idp_atasan
                                FROM pegawai p WHERE nip_baru = '".@$data['last_pjbt_nip']."') atsl
                                LEFT JOIN jabatan_plt jp ON atsl.idp_atasan = jp.id_pegawai) pjbt
                                LEFT JOIN jabatan j ON pjbt.id_j = j.id_j";
                    $query_row_atsl = mysql_query($sql);
                    $data_atsl = mysql_fetch_array($query_row_atsl);
                    if($data_atsl['id_j']==''){
                        echo @$data['last_pjbt_jabatan'];
                    }else{
                        echo 'Plh. '.$data_atsl['jabatan'];
                    }
                ?>
                <br /><br /><br /><br /><br /><br />
                <u><b><?php echo @$data['last_pjbt_nama']; ?> </b></u><br />
                <?php if($data['pangkat_pjbt']!='-') echo @$data['pangkat_pjbt']; ?><br />
                <?php if($data['pangkat_pjbt']!='-' AND $data['pangkat_pjbt']!='')
                    echo ("NIP. $data[last_pjbt_nip]"); ?>
             </td>
          </tr>
        </table>
</page>


<?php
$content = ob_get_clean();

require_once('html2pdf.class.php');
try
{
    $html2pdf = new HTML2PDF('P', 'Legal', 'fr', true, 'UTF-8', 0);
    $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
    $html2pdf->Output('contoh.pdf');
}
catch(HTML2PDF_exception $e) {
    echo $e;
    exit;
}
?>