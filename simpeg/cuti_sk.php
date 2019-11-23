<?php
session_start();
include("konek.php");


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

$tgl_cuti = $data['tgl_usulan'].' '.monthName($data['bln_usulan']).' '.$data['thn_usulan'];
ob_start();
?>

<page backtop="5mm" backbottom="14mm" backleft="10mm" backright="10mm" style="font-size: 11pt">
<img src="./images/klop.png" />
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td width="500">&nbsp;</td>
        <td>Bogor,<u> <?php echo @$tgl_cuti; ?></u><br>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<?php // echo @$tgl_cuti_hijriyah; ?></td>
      </tr>
      </table></td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
  </tr>
  <tr>
    <td width="750" align="center"><B><U>SURAT IZIN CUTI TAHUNAN</U></B></td>
  </tr>
  <tr>
    <td align="center">Nomor : 851/ &nbsp;&nbsp;&nbsp;&nbsp;    -IAK</td>
  </tr>
  </table>


<table  border="0" align="left" cellpadding="0" cellspacing="0" style="position:absolute; top:250px; left:62px;" >
    <tr>
        <td >&nbsp;</td>
        <td>&nbsp;</td>
        <td >&nbsp;</td>
    </tr>
    <TR><td colspan="3">Diberikan cuti <?php echo @$jeniscuti; ?> untuk tahun <?php echo @$tahun; ?> kepada Pegawai Negeri Sipil :</td> </TR>
    <tr>
      <td align="left" valign="bottom" style="padding-bottom:10px;">&nbsp;</td>
      <td align="left" valign="bottom" style="padding-bottom:10px;">&nbsp;</td>
      <td align="left" valign="bottom" style="padding-bottom:10px;">&nbsp;</td>
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
<br /><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<div align="justify" style="line-height:1.5; width:600px;" >Selama <?php echo $data['lama_cuti']; ?> <?php echo "(".terbilang($data['lama_cuti'], $style=3).")";?> hari Kerja terhitung mulai tanggal <?php echo $data['tmt_akhir']; ?> s.d. <?php echo $data['tmt_akhir']; ?> dengan ketentuan sebagai berikut:
 </div><br />
 <ol style="padding-left:40px;">
 <li style="line-height:1.5; padding-bottom:10px;">Sebelum menjalankan cuti <?php echo @$jenis_cuti; ?>, wajib menyerahkan pekerjaan kepada atasan langsungnya; </li>
 <li style="line-height:1.5; " >Setelah selesai menjalankan cuti <?php echo @$jenis_cuti; ?>, wajib melaporkan diri kepada atasan langsungya dan bekerja kembali sebagaimana biasa  </li>
 </ol>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<div align="justify" style="line-height:1.5; width:600px;" >Demikian Surat Izin Cuti <?php echo @$jenis_cuti; ?> ini dibuat untuk dapat digunakan sebagaimana mestinya. </div>
<div align="justify"> </div>
<div style="margin-left:500px;">Hormat Saya </div>
<br />
<br />
<br />
<br /><?php
if(strlen($data['nama'])<8)
$panjang=515;
else
$panjang=450;
?>
<div style="margin-left:<?php echo $panjang; ?>px;"><strong><?php echo @$data['nama'];?></strong></div><div style="margin-left:450px;"><div style="width:180px;" align="center"><?php echo @$data['pangkat_p'];?></div>NIP.<?php echo @$data['nip_baru']; ?> </div><br /><br /><br />
</page>

<div align="left" style="padding-left:55px;"><u><b>Tembusan disampaikan kepada:  </b></u> </div>
<div align="left">
<ol style="padding-left:40px;">
<li>Yth Inspektur Kota Bogor </li>
<li>Yth Kepala BKPP Kota Bogor </li>
<li>Pegawai Negeri Sipil yang bersangkutan </li>
</ol>

</div>
<?php
$content = ob_get_clean();

require_once('html2pdf.class.php');
try
{
    $html2pdf = new HTML2PDF('P', 'Legal', 'fr', true, 'UTF-8', 0);
    $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
    //attachment
    //$html2pdf->Output('bookmark.pdf',F);
    //inline
    $html2pdf->Output('contoh.pdf');
}
catch(HTML2PDF_exception $e) {
    echo $e;
    exit;
}
?>