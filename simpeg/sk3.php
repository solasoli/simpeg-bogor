<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?
include("konek.php");
$s=0;
$ket=0;
extract($_GET);
extract($_POST);
if($s==NULL)
$s=0;

if($ket==NULL )
{
$ket=0;
$were="and jabatan.jabatan not like '%ahli%' ";
}
else
{
if($ket=='Ahli')
$were="and jabatan.jabatan like '%ahli%' ";	

if($ket=='u')
$were="and jabatan.jabatan like '%UPTD%' ";	

if($ket=='w')
$were="and (jabatan.jabatan like '%kelurahan%' or jabatan.jabatan like '%kecamatan%') ";	

if($ket=='0')
$were="and jabatan.jabatan not like '%ahli%' and jabatan.jabatan not like '%UPTD%' and jabatan.jabatan not like '%kelurahan%' and jabatan.jabatan not like '%kecamatan%' ";	
	
	
}

?></title>
<style type="text/css">
<!--
body,td,th {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 14pt;
}
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
#Layer1 {
	position:absolute;
	left:383px;
	top:240px;
	width:175px;
	height:24px;
	z-index:1;
}
.style1 {
	font-family: "Times New Roman", Times, serif;
	font-size: 13pt;
}
.style2 {
	font-size: 12pt;
}
-->
</style>
<script type="text/JavaScript">
<!--
function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}
//-->
</script>
</head>

<body onload="window.print() "><?


$tgl=substr($tmt,0,2);
$bln=substr($tmt,3,2);
$thn=substr($tmt,6,4);

$tgl2=substr($tsk,0,2);
$bln2=substr($tsk,3,2);
$thn2=substr($tsk,6,4);

$bulan=array('tes','Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','Nopember','Desember');

if(substr($bln,0,1)=='0')
$bul=substr($bln,1,1);
else
$bul=$bulan[$bul];

if(substr($bln2,0,1)=='0')
$bul2=substr($bln2,1,1);

$bul2=$bulan[$bul2];


$qp=mysqli_query($mysqli,"Select nama,jabatan.jabatan,pegawai.id_pegawai,eselon,tunjangan,jabatan.id_j,nip_baru,pegawai.pangkat_gol,agama from mutasi_jabatan inner join jabatan on jabatan.id_j=mutasi_jabatan.id_j inner join pegawai on pegawai.id_pegawai=mutasi_jabatan.id_pegawai where eselon='$s' $were");

while($data=mysqli_fetch_array($qp))
{
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td></td>
  </tr>
  <tr>
    <td><table width="846" height="1250" border="0" cellspacing="0" cellpadding="0">
     
      <tr>
        <td background="images/kop.png" height="200" colspan="2" align="center" valign="top"><h1>&nbsp;</h1></td>
        </tr>
      <tr>
        <td height="20">&nbsp;</td>
        <td width="747" height="30" align="left" valign="top">&nbsp; </td>
      </tr>
      <tr>
        <td height="30" colspan="2" align="center"><strong><u>S U R A T&nbsp;&nbsp;  P E R  N Y A T A A N &nbsp;&nbsp;P E L A N T I K A N</u></strong></td>
        </tr>
      <tr>
        <td width="99">&nbsp;</td>
        <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="3">
          <tr>
            <td width="14%">&nbsp;</td>
            <td width="15%">Nomor</td>
            <td width="2%">:</td>
            <td width="69%"><? echo($nolantik); ?></td>
          </tr>
          </table></td>
      </tr>
      <tr>
        <td colspan="2" align="center" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td>&nbsp;</td>
            <td colspan="5">&nbsp;</td>
            </tr>
          <tr>
            <td width="11%">&nbsp;</td>
            <td colspan="5">Yang bertanda tangan di bawah ini:</td>
            </tr>
          <tr>
            <td>&nbsp;</td>
            <td width="3%">&nbsp;</td>
            <td width="34%">&nbsp;</td>
            <td width="3%">&nbsp;</td>
            <td colspan="2">&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="2">Nama</td>
            <td>:</td>
            <td colspan="2"><? echo("<b>$lantik</b>"); ?></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="2">&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="2">J a b a t a n</td>
            <td>:</td>
            <td colspan="2"><?
            
			if(substr($lantik,0,1)=='D')
			echo("<b>Walikota Bogor</b>");
			else
			echo("<b>Wakil Walikota Bogor</b>");
			?></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="2">&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="5">Menyatakan dengan sesungguhnya bahwa</td>
            </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="2">&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="2">&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="2">Nama</td>
            <td>:</td>
            <td colspan="2"><? echo("<b>$data[0]</b>"); ?></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="2">&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="2">&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="2">N I P</td>
            <td>:</td>
            <td colspan="2"><? echo(substr($data[6],0,8));
			echo(" ");
			echo(substr($data[6],8,6));
			echo(" ");
			echo(substr($data[6],14,1));
			echo(" ");
			echo(substr($data[6],-3));
			
			
			 ?></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="2">&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="2">Pangkat-Golongan/Ruang</td>
            <td>:</td>
            <td colspan="2"><? 
			
			$pang=$data[7];
			if($pang=='I/a')
			$pang="Juru Muda - $pang";
			elseif($pang=='I/b')
			$pang="Juru Muda Tingkat I - $pang";
			elseif($pang=='I/c')
			$pang="Juru - $pang";
			elseif($pang=='I/d')
			$pang="Juru Tingkat I - $pang";
			elseif($pang=='II/a')
			$pang="Pengatur Muda - $pang";
			elseif($pang=='II/b')
			$pang="Pengatur Muda Tingkat I - $pang";
			elseif($pang=='II/c')
			$pang="Pengatur - $pang";
			elseif($pang=='II/d')
			$pang="Pengatur Tingkat I - $pang";
			elseif($pang=='III/a')
			$pang="Penata Muda - $pang";
			elseif($pang=='III/b')
			$pang="Penata Muda Tingkat I - $pang";
			elseif($pang=='III/c')
			$pang="Penata - $pang";
			elseif($pang=='III/d')
			$pang="Penata Tingkat I  - $pang";
			elseif($pang=='IV/a')
			$pang="Pembina - $pang";
			elseif($pang=='IV/b')
			$pang="Pembina  Tingkat I - $pang";
			elseif($pang=='IV/c')
			$pang="Pembina Utama Muda - $pang";
			elseif($pang=='IV/d')
			$pang="Pembina Utama Madya- $pang";
			elseif($pang=='IV/e')
			$pang="Pembina Utama - $pang";
			echo("$pang"); ?></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td nowrap="nowrap">&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="2">&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="5">Berdasarkan Keputusan Walikota Bogor</td>
            </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td nowrap="nowrap">&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="2">&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="3">Nomor :<? echo(" $sk"); ?></td>
            <td colspan="2" align="center">Tanggal:<? echo(" $tgl2 $bul2 $thn2"); ?></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td nowrap="nowrap">&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="2">&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="5">Telah diangkat dalam jabatan</td>
            </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td nowrap="nowrap">&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="2">&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="4" nowrap="nowrap"><? echo("$data[1]"); ?></td>
            </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td nowrap="nowrap">&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="2">&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td nowrap="nowrap">&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="2">&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="5">Dan Telah dilantik oleh 
              <?
            
			if(substr($lantik,0,1)=='D')
			echo("<b>Walikota Bogor</b>");
			else
			echo("<b>Wakil Walikota Bogor</b>");
			?></td>
            </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td nowrap="nowrap">&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="2">&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="5">Pada Tanggal <? echo(" $tgl2 $bul2 $thn2"); ?></td>
            </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td nowrap="nowrap">&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="2">&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="5"><div align="justify">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Demikian Surat Pernyataan Pelantikan ini dibuat dengan sesungguhnya, dengan mengingat Sumpah Jabatan dan apabila dikemudian hari isi surat pernyataan ini ternyata tidak benar yang berakibat merugikan terhadap keuangan negara, maka saya bersedia menanggung kerugian tersebut.</div></td>
            </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td nowrap="nowrap">&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="2">&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="5"><div align="justify">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Asli surat pelantikan ini disampaikan kepada Kepala Kantor Perbendaharaan Negara/Kepala Kas Daerah di Bogor</div></td>
            </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td nowrap="nowrap">&nbsp;</td>
            <td>&nbsp;</td>
            <td width="20%">&nbsp;</td>
            <td width="29%">&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td nowrap="nowrap">&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="2">&nbsp;</td>
          </tr>
          <tr>
            <td colspan="6"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="70%" align="center" valign="top"><table width="85%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td align="center" valign="top">&nbsp;</td>
                    </tr>
                  <tr>
                    <td align="center" valign="top">&nbsp;</td>
                    </tr>
                  <tr>
                    <td align="center" valign="top">&nbsp;</td>
                    </tr>
                  <tr>
                    <td align="center" valign="top">&nbsp;</td>
                    </tr>
                  <tr>
                    <td align="center" valign="top">&nbsp;</td>
                    </tr>
                  <tr>
                    <td align="center" valign="top">&nbsp;</td>
                    </tr>
                  <tr>
                    <td align="center" valign="top">&nbsp;</td>
                    </tr>
                  <tr>
                    <td align="center" valign="top">&nbsp;</td>
                    </tr>
                  <tr>
                    <td align="center" valign="top">&nbsp;</td>
                    </tr>
                  <tr>
                    <td align="center" valign="top">&nbsp;</td>
                    </tr>
                  <tr>
                    <td align="center" valign="top">&nbsp;</td>
                  </tr>
                  <tr>
                    <td align="center" valign="top">&nbsp;</td>
                  </tr>
                  <tr>
                    <td align="left" valign="top">Tembusan :</td>
                  </tr>
                  <tr>
                    <td align="left" valign="top"><ol>
                      <li>Yth. Menteri Dalam Negeri di Jakarta;</li>
                      <li>Yth. Gubernur Jawa Barat di Bandung;</li>
                      <li>Yth. Kepala Badan Kepegawaian Negara di Jakarta;</li>
                      <li>Yth. Inspektur Provinsi Jawa Barat;</li>
                      <li>Yth.Inspektur Kota Bogor</li>
                    </ol></td>
                  </tr>
                  </table></td>
                <td width="30%" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td align="left" valign="top">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Bogor, <? echo(" $tgl2 $bul2 $thn2"); ?></td>
                  </tr>
                  <tr>
                    <td align="left" valign="top">&nbsp;</td>
                  </tr>
                  <tr>
                    <td align="left" valign="top"><div align="center">Yang membuat pernyataan</div></td>
                  </tr>
                  <tr>
                    <td align="left" valign="top"><div align="center">
                      <?
            
			if(substr($lantik,0,1)=='D')
			echo(" <b>WALIKOTA BOGOR</b>");
			else
			echo(" <b>WAKIL WALIKOTA BOGOR</b>");
			?>
                    </div></td>
                    </tr>
                  <tr>
                    <td height="120" align="left" valign="top"><div align="center"><br />
                      </div>                      <div align="center"></div>                      <div align="center"></div>                      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                      <div align="center"></div>                      <div align="center"></div>                      <div align="center"></div></td>
                  </tr>
                  <tr>
                    <td align="left" valign="top"><div align="center">
                      <? 
					$nama=strtoupper($lantik);
					echo("<b> $nama</b>"); ?>
                      </div></td>
                  </tr>
                  <tr>
                    <td align="left" valign="top">&nbsp;</td>
                    </tr>
                  </table></td>
                </tr>
              </table></td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height="170"><table width="846" height="1250" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td height="210" colspan="2" align="center" valign="top"><h1><img src="images/kop.png" width="846" height="200" /></h1></td>
      </tr>
      <tr>
        <td height="30" colspan="2" align="center"><strong>BERITA ACARA PENGAMBILAN SUMPAH JABATAN</strong></td>
      </tr>
      <tr>
        <td width="99">&nbsp;</td>
        <td width="747" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="3">
          <tr>
            <td width="14%">&nbsp;</td>
            <td width="15%">Nomor</td>
            <td width="2%">:</td>
            <td width="69%"><? echo($nolantik); ?></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td colspan="2" align="center" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td>&nbsp;</td>
            <td colspan="6">&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="6">&nbsp;</td>
          </tr>
          <tr>
            <td width="11%">&nbsp;</td>
            <td colspan="6"><div align="justify">Pada hari ini 
              <?  
			$dai=array('Minggu','Senin','Selasa','Rabu','Kamis','Jum\'at','Sabtu');
			$ariy=array('lieur','Satu','Dua','Tiga','Empat','Lima','Enam','Tujuh','Delapan','Sembilan','Sepuluh','Sebelas','Dua Belas','Tiga Belas','Empat Belas','Lima Belas','Enam Belas','Tujuh Belas','Delapan Belas','Sembilan Belas','Dua Puluh','Dua Puluh Dua','Dua Puluh Tiga','Dua Puluh Empat','Dua Puluh Lima','Dua Puluh Enam','Dua Puluh Enam','Dua Puluh Tujuh','Dua Puluh Delapan','Dua Puluh Sembilan','Tiga Puluh','Tiga Puluh Satu',);
			
			$taon=array('Dua Ribu Sepuluh','Dua Ribu Sebelas','Dua Ribu Dua Belas','Dua Ribu Tiga Belas','Dua Ribu Empat Belas','Dua Ribu Lima Belas','Dua Ribu Dua Belas','Dua Ribu Tujuh Belas','Dua Ribu Delapan Belas','Dua Ribu Sembilan Belas','Dua Ribu Dua Puluh');
			$bulan=array('bulan','Januari','Februari','maret','April','Mei','Juni','Juli','Agustus','September','Oktober','Nopember','Desember');
			$hari=(jddayofweek("$thn2-$bln2-$tgl2",0));
			echo("<i>$dai[$hari]</i>");
 ?> Tanggal <?
 if(substr($tgl2,0,1)=='0')
 $ari=substr($tgl2,1,1);
 else
 $ari=$tgl2;
 echo("<i>$ariy[$ari]</i>");
 ?> Bulan <?
 
  if(substr($bln2,0,1)=='0')
 $mon=substr($bln2,1,1);
 else
 $mon=$bln2;
 echo("<i>$bulan[$mon]</i>");
 ?> Tahun <? $no=substr($thn,3,1);
 echo("<i>$taon[$no]</i>");
  ?> dengan mengambil tempat di <? echo("<i>$tmpt</i>"); ?></div></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="2">&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="2">&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td width="3%">&nbsp;</td>
            <td width="34" colspan="2">&nbsp;</td>
            <td width="3%">&nbsp;</td>
            <td colspan="2">&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="3">Nama</td>
            <td>:</td>
            <td colspan="2"><? echo("<b>$lantik</b>"); ?></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="2">&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="2">&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="3">J a b a t a n</td>
            <td>:</td>
            <td colspan="2"><?
            
			if(substr($lantik,0,1)=='D')
			echo("Walikota Bogor");
			else
			echo("Wakil Walikota Bogor");
			?></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="2">&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="2">&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="6">dengan disaksikan oleh dua orang masing-masing :</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="3">&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="2">&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="3">1. Nama</td>
            <td>:</td>
            <td colspan="2"><?
			
			$qs1=mysqli_query($mysqli,"select nama,jabatan.jabatan from sk inner join pegawai on pegawai.id_pegawai=sk.id_pegawai inner join jabatan on jabatan.id_j=sk.id_j where jabatan.id_j=$s1 order by tmt desc");
			$sak=mysqli_fetch_array($qs1);
			 echo("$sak[0]"); ?></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="3">&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="2">&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="3">&nbsp;&nbsp;&nbsp;&nbsp;J a b a t a n</td>
            <td>:</td>
            <td colspan="2" nowrap="nowrap"><?  echo("$sak[1]"); ?></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="2">&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="2">&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="3">2. Nama</td>
            <td>:</td>
            <td colspan="2"><?
			
			$qs2=mysqli_query($mysqli,"select nama,jabatan.jabatan from sk inner join pegawai on pegawai.id_pegawai=sk.id_pegawai inner join jabatan on jabatan.id_j=sk.id_j where jabatan.id_j=$s2 order by tmt desc");
			$sak2=mysqli_fetch_array($qs2);
			 echo("$sak2[0]"); ?></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="2" nowrap="nowrap">&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="2">&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="3">&nbsp;&nbsp;&nbsp;&nbsp;J a b a t a n</td>
            <td>&nbsp;</td>
            <td colspan="2"><?  echo("$sak2[1]"); ?></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="6">&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="3">Telah mengambil sumpah jabatan,</td>
            <td>&nbsp;</td>
            <td colspan="2">&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="2" nowrap="nowrap">&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="2">&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="3">Nama</td>
            <td>:</td>
            <td colspan="2" align="left"><? echo($data[0]);  ?></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="2" nowrap="nowrap">&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="2">&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="3">Pangkat-Golongan/Ruang</td>
            <td>:</td>
            <td colspan="2"><? 	$pang=$data[7];
			if($pang=='I/a')
			$pang="Juru Muda - $pang";
			elseif($pang=='I/b')
			$pang="Juru Muda Tingkat I - $pang";
			elseif($pang=='I/c')
			$pang="Juru - $pang";
			elseif($pang=='I/d')
			$pang="Juru Tingkat I - $pang";
			elseif($pang=='II/a')
			$pang="Pengatur Muda - $pang";
			elseif($pang=='II/b')
			$pang="Pengatur Muda Tingkat I - $pang";
			elseif($pang=='II/c')
			$pang="Pengatur - $pang";
			elseif($pang=='II/d')
			$pang="Pengatur Tingkat I - $pang";
			elseif($pang=='III/a')
			$pang="Penata Muda - $pang";
			elseif($pang=='III/b')
			$pang="Penata Muda Tingkat I - $pang";
			elseif($pang=='III/c')
			$pang="Penata - $pang";
			elseif($pang=='III/d')
			$pang="Penata Tingkat I  - $pang";
			elseif($pang=='IV/a')
			$pang="Pembina - $pang";
			elseif($pang=='IV/b')
			$pang="Pembina  Tingkat I - $pang";
			elseif($pang=='IV/c')
			$pang="Pembina Utama Muda - $pang";
			elseif($pang=='IV/d')
			$pang="Pembina Utama Madya- $pang";
			elseif($pang=='IV/e')
			$pang="Pembina Utama - $pang";
			echo("$pang"); ?></td>
            </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="2" nowrap="nowrap">&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="2">&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="3">NIP</td>
            <td>:</td>
            <td colspan="2"><? echo(substr($data[6],0,8));
			echo(" ");
			echo(substr($data[6],8,6));
			echo(" ");
			echo(substr($data[6],16,1));
			echo(" ");
			echo(substr($data[6],-3));
			
			
			 ?></td>
            </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="2" nowrap="nowrap">&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="2">&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="3">Agama</td>
            <td>:</td>
            <td colspan="2"><? echo(strtoupper($data[8])); ?></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="6">&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="6" nowrap="nowrap">Dengan Keputusan Walikota Bogor</td>
            </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="6">&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="3">Tanggal : <? echo(" $tgl2 $bul2 $thn2"); ?></td>
            <td>&nbsp;</td>
            <td colspan="2">Nomor :<? echo(" $sk"); ?></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="2" nowrap="nowrap">&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="2">&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="3">Diangkat sebagai :</td>
            <td>&nbsp;</td>
            <td colspan="2">&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="2" nowrap="nowrap">&nbsp;</td>
            <td>&nbsp;</td>
            <td width="20%">&nbsp;</td>
            <td width="29%">&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td nowrap="nowrap">&nbsp;</td>
            <td colspan="4" nowrap="nowrap"><? echo("$data[1]"); ?></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td nowrap="nowrap">&nbsp;</td>
            <td colspan="4" nowrap="nowrap">&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="6">Yang mengangkat Sumpah Jabatan tersebut, didampingi oleh seorang Rohaniawan:</td>
            </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td nowrap="nowrap">&nbsp;</td>
            <td colspan="4" nowrap="nowrap">&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="3">Nama</td>
            <td nowrap="nowrap">:</td>
            <td nowrap="nowrap"><? echo("$ro1"); ?></td>
            <td nowrap="nowrap">&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td nowrap="nowrap">&nbsp;</td>
            <td colspan="4" nowrap="nowrap">&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="3" nowrap="nowrap">Pangkat-Golongan/Ruang</td>
            <td nowrap="nowrap">:</td>
            <td nowrap="nowrap"><? echo("$ro2"); ?></td>
            <td nowrap="nowrap">&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="3">&nbsp;</td>
            <td nowrap="nowrap">&nbsp;</td>
            <td nowrap="nowrap">&nbsp;</td>
            <td nowrap="nowrap">&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="3">NIP</td>
            <td nowrap="nowrap">:</td>
            <td nowrap="nowrap"><? echo("$ro3"); ?></td>
            <td nowrap="nowrap">&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="3">&nbsp;</td>
            <td nowrap="nowrap">&nbsp;</td>
            <td nowrap="nowrap">&nbsp;</td>
            <td nowrap="nowrap">&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="3">Agama</td>
            <td nowrap="nowrap">:</td>
            <td nowrap="nowrap"><? echo("$ro4"); ?></td>
            <td nowrap="nowrap">&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="3">&nbsp;</td>
            <td nowrap="nowrap">&nbsp;</td>
            <td nowrap="nowrap">&nbsp;</td>
            <td nowrap="nowrap">&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td colspan="3">Unit Kerja</td>
            <td nowrap="nowrap">:</td>
            <td nowrap="nowrap"><? echo("$ro5"); ?></td>
            <td nowrap="nowrap">&nbsp;</td>
          </tr>
          <tr>
            <td colspan="7">&nbsp;</td>
          </tr>
          <tr>
            <td colspan="7" align="right">Pegawai Negeri..........................</td>
          </tr>
          <tr>
            <td height="100" colspan="7" align="right">&nbsp;</td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td height="170"><table width="846" height="1250" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td  height="50" colspan="2" align="center" valign="bottom" class="style1">&nbsp;</td>
      </tr>
      <tr>
        <td width="24" height="20">&nbsp;</td>
        <td height="30" align="center" valign="middle" class="style1" style="text-align: justify"><span class="style1">Pegawai Negeri Sipil yang mengangkat Sumpah Jabatan tersebut,mengucakan sumpah sebagai berikut:</span></td>
      </tr>
      <tr>
        <td height="20">&nbsp;</td>
        <td height="30" align="left" valign="top" class="style1" style="text-align: justify">&nbsp;</td>
      </tr>
      <tr>
        <td height="20">&nbsp;</td>
        <td height="30" align="left" valign="top" class="style1" style="text-align: justify">&quot;
        
        <?
		if($ro4=='HINDU')
		echo("OM ATAH PARAMAWISESA");
		else
		echo("DEMI ALLAH");
        ?>
        &quot; SAYA BERSUMPAH</td>
      </tr>
      <tr>
        <td height="20">&nbsp;</td>
        <td height="30" align="left" valign="top" class="style1" style="text-align: justify">&nbsp;</td>
      </tr>
      <tr>
        <td height="20">&nbsp;</td>
        <td height="30" align="left" valign="top" class="style1" style="text-align: justify">BAHWA SAYA / UNTUK DIANGKAT PADA JABATAN INI / BAIK LANGSUNG MAUPUN TIDAK LANGSUNG DENGAN RUPA ATAU DALIH APAPUN / TIDAK MEMBERI ATAU MENYANGGUPI / AKAN MEMBERI SESUATU / KEPADA SIAPAPUN JUGA/.</td>
      </tr>
      <tr>
        <td height="20">&nbsp;</td>
        <td height="30" align="left" valign="top" class="style1" style="text-align: justify">&nbsp;</td>
      </tr>
      <tr>
        <td height="20">&nbsp;</td>
        <td height="30" align="left" valign="top" class="style1" style="text-align: justify">BAHWA SAYA / AKAN MEMEGANG RAHASIA SESUATU / YANG MENURUT SIFATNYA / ATAU MENURUT PERINTAH / HARUS SAYA RAHASIAKAN/.</td>
      </tr>
      <tr>
        <td height="20">&nbsp;</td>
        <td height="30" align="left" valign="top" class="style1" style="text-align: justify">&nbsp;</td>
      </tr>
      <tr>
        <td height="20">&nbsp;</td>
        <td height="30" align="left" valign="top" class="style1" style="text-align: justify">BAHWA SAYA / TIDAK AKAN MENERIMA HADIAH / ATAU SUATU PEMBERIAN BERUPA APA SAJA / /DARI SIAPAPUN JUGA ./  YANG SAYA TAHU / ATAU PATUT DAPAT MENGIRA / BAHWA IA MEMPUNYAI HAL, YANG BERSANGKUTAN / DENGAN JABATAN ATAU PEKERJAAN SAYA/.</td>
      </tr>
      <tr>
        <td height="20">&nbsp;</td>
        <td height="30" align="left" valign="top" class="style1" style="text-align: justify">&nbsp;</td>
      </tr>
      <tr>
        <td height="20">&nbsp;</td>
        <td height="30" align="left" valign="top" class="style1" style="text-align: justify">BAHWA SAYA / DALAM MENJALANKAN JABATAN / ATAU PEKERJAAN SAYA / SENANTIASA AKAN LEBIH MEMENTINGKAN /KEPENTINGAN NEGARA/ DARI PADA KEPENTINGAN SAYA SENDIRI / SESEORANG ATAU GOLONGAN/.</td>
      </tr>
      <tr>
        <td height="20">&nbsp;</td>
        <td height="30" align="left" valign="top" class="style1" style="text-align: justify">&nbsp;</td>
      </tr>
      <tr>
        <td height="20">&nbsp;</td>
        <td height="30" align="left" valign="top" class="style1" style="text-align: justify">BAHWA SAYA SENANTIASA AKAN MENJUNJUNG TINGGI / KEHORMATAN NEGARA / PEMERINTAH / DAN MARTABAT PEGAWAI NEGERI/.</td>
      </tr>
      <tr>
        <td height="20">&nbsp;</td>
        <td height="30" align="left" valign="top" class="style1" style="text-align: justify">&nbsp;</td>
      </tr>
      <tr>
        <td height="20">&nbsp;</td>
        <td height="30" align="left" valign="top" class="style1" style="text-align: justify">BAHWA SAYA AKAN BEKERJA DENGAN JUJUR / TERTIB / CERMAT DAN SEMANGAT / UNTUK KEPENTINGAN NEGARA/.</td>
      </tr>
      <tr>
        <td height="20">&nbsp;</td>
        <td height="30" align="left" valign="top" class="style1" style="text-align: justify">&nbsp;</td>
      </tr>
      <tr>
        <td height="20">&nbsp;</td>
        <td height="30" align="left" valign="top" class="style1" style="text-align: justify">Demikian Berita Acara Pengambilan Sumpah Jabatan ini, dibuat dengan sebenarnya untuk dapat dipergunakan sebagaimana mestinya</td>
      </tr>
      <tr>
        <td height="20">&nbsp;</td>
        <td width="822" height="30" align="left" valign="top" class="style1">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2"><table width="100%" border="0" cellspacing="0" cellpadding="3">
          <tr>
            <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="70%" align="left" valign="top"><table width="55%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td align="center" valign="top" class="style1">P e j a b a t <br />
                      Yang mengangkat sumpah,</td>
                  </tr>
                  <tr>
                    <td align="center" valign="top">&nbsp;</td>
                  </tr>
                  <tr>
                    <td align="center" valign="top">&nbsp;</td>
                  </tr>
                  <tr>
                    <td align="center" valign="top">&nbsp;</td>
                  </tr>
                  <tr>
                    <td align="center" valign="top">&nbsp;</td>
                  </tr>
                  <tr>
                    <td align="center" valign="top">&nbsp;</td>
                  </tr>
                  <tr>
                    <td align="center" valign="top">&nbsp;</td>
                  </tr>
                  <tr>
                    <td align="center" valign="top"><span class="style1"><strong><u><? echo($data[0]); ?></u></strong></span></td>
                  </tr>
                  <tr>
                    <td align="center" valign="top"><span class="style1">NIP. <? echo(substr($data[6],0,8));
			echo(" ");
			echo(substr($data[6],8,6));
			echo(" ");
			echo(substr($data[6],14,1));
			echo(" ");
			echo(substr($data[6],-3));
			
			
			 ?></span></td>
                  </tr>
                  <tr>
                    <td align="center" valign="top">&nbsp;</td>
                  </tr>
                  </table></td>
                <td width="30%" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td height="30" align="center" valign="top"><span class="style1">Yang mengambil sumpah</span></td>
                  </tr>
                  <tr>
                    <td align="center" valign="bottom">
                      <span class="style1">
                      <?
            
			if(substr($lantik,0,1)=='D')
			echo("<B>WALIKOTA BOGOR</B>");
			else
			echo("<B>WAKIL WALIKOTA BOGOR</B>");
			?>                      
                      <br />                    
                      </span></td>
                  </tr>
                  <tr>
                    <td align="left" valign="top">&nbsp;</td>
                  </tr>
                  <tr>
                    <td align="left" valign="top">&nbsp;</td>
                  </tr>
                  <tr>
                    <td align="left" valign="top"><span class="style1">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></td>
                  </tr>
                  <tr>
                    <td align="left" valign="top">&nbsp;</td>
                  </tr>
                  <tr>
                    <td align="left" valign="top">&nbsp;</td>
                  </tr>
                  <tr>
                    <td align="left" valign="top">&nbsp;</td>
                  </tr>
                  <tr>
                    <td align="center" valign="top"><span class="style1"><? echo("<b>$lantik</b>"); ?></span></td>
                  </tr>
                  <tr>
                    <td align="left" valign="top">&nbsp;</td>
                  </tr>
                </table></td>
              </tr>
            </table></td>
            </tr>
        </table>
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td align="center" valign="top"><table width="55%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td align="center" valign="top" class="style1">R o h a n i a w a n<br />
                    Yang mengangkat sumpah,</td>
                  </tr>
                <tr>
                  <td align="center" valign="top">&nbsp;</td>
                  </tr>
                <tr>
                  <td align="center" valign="top">&nbsp;</td>
                  </tr>
                <tr>
                  <td align="center" valign="top">&nbsp;</td>
                  </tr>
                <tr>
                  <td align="center" valign="top">&nbsp;</td>
                </tr>
                <tr>
                  <td align="center" valign="top">&nbsp;</td>
                  </tr>
                <tr>
                  <td align="center" valign="top">&nbsp;</td>
                  </tr>
                <tr>
                  <td align="center" valign="top"><span class="style1"><strong><u><? echo(strtoupper($ro1)); ?></u></strong></span></td>
                  </tr>
                <tr>
                  <td align="center" valign="top">&nbsp;</td>
                </tr>
                <tr>
                  <td align="center" valign="top">&nbsp;</td>
                  </tr>
                <tr>
                  <td align="center" valign="top" class="style2">Saksi-saksi</td>
                  </tr>
                <tr>
                  <td align="center" valign="top" class="style2">&nbsp;</td>
                </tr>
              </table></td>
              </tr>
            <tr>
              <td align="center" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="3">
                <tr>
                  <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="65%" align="left" valign="top"><table width="55%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td width="16%" align="right" valign="top" class="style1">1.&nbsp;&nbsp;</td>
                          <td width="84%" align="left" valign="top" class="style1"><?
                          $sa1=mysqli_query($mysqli,"select jabatan.jabatan,nama,nip_baru from sk inner join jabatan on jabatan.id_j=sk.id_j inner join pegawai on pegawai.id_pegawai=sk.id_pegawai where sk.id_j=$s1 ");
						  
						  $sak1=mysqli_fetch_array($sa1);
						  echo(" $sak1[0]");
						  
						  ?></td>
                        </tr>
                        <tr>
                          <td colspan="2" align="center" valign="top">&nbsp;</td>
                        </tr>
                        <tr>
                          <td colspan="2" align="center" valign="top">&nbsp;</td>
                        </tr>
                        <tr>
                          <td colspan="2" align="center" valign="top">&nbsp;</td>
                        </tr>
                        <tr>
                          <td colspan="2" align="center" valign="top">&nbsp;</td>
                        </tr>
                        <tr>
                          <td colspan="2" align="center" valign="top">&nbsp;</td>
                        </tr>
                        <tr>
                          <td colspan="2" align="center" valign="top">&nbsp;</td>
                        </tr>
                        <tr>
                          <td colspan="2" align="center" valign="top"><span class="style1"><strong><u><? echo($sak1[1]); ?></u></strong></span></td>
                        </tr>
                        <tr>
                          <td colspan="2" align="center" valign="top"><span class="style1">NIP. <? echo(substr($sak1[2],0,8));
			echo(" ");
			echo(substr($sak1[2],8,6));
			echo(" ");
			echo(substr($sak1[2],16,1));
			echo(" ");
			echo(substr($sak1[2],-3));
			
			
			 ?></span></td>
                        </tr>
                        <tr>
                          <td colspan="2" align="center" valign="top">&nbsp;</td>
                        </tr>
                      </table></td>
                      <td width="35%" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td width="16%" align="right" valign="top" class="style1">2.&nbsp;&nbsp;</td>
                          <td width="84%" align="left" valign="top" class="style1"><?
                          $sa2=mysqli_query($mysqli,"select jabatan.jabatan,nama,nip_baru from sk inner join jabatan on jabatan.id_j=sk.id_j inner join pegawai on pegawai.id_pegawai=sk.id_pegawai where sk.id_j=$s2 ");
						  
						  $sak2=mysqli_fetch_array($sa2);
						  echo(" $sak2[0]");
						  
						  ?></td>
                        </tr>
                        <tr>
                          <td colspan="2" align="center" valign="top">&nbsp;</td>
                        </tr>
                        <tr>
                          <td colspan="2" align="center" valign="top">&nbsp;</td>
                        </tr>
                        <tr>
                          <td colspan="2" align="center" valign="top">&nbsp;</td>
                        </tr>
                        <tr>
                          <td colspan="2" align="center" valign="top">&nbsp;</td>
                        </tr>
                        <tr>
                          <td colspan="2" align="center" valign="top">&nbsp;</td>
                        </tr>
                        <tr>
                          <td colspan="2" align="center" valign="top">&nbsp;</td>
                        </tr>
                        <tr>
                          <td colspan="2" align="center" valign="top"><span class="style1"><strong><u><? echo($sak2[1]); ?></u></strong></span></td>
                        </tr>
                        <tr>
                          <td colspan="2" align="center" valign="top"><span class="style1">NIP. <? echo(substr($sak2[2],0,8));
			echo(" ");
			echo(substr($sak2[2],8,6));
			echo(" ");
			echo(substr($sak2[2],16,1));
			echo(" ");
			echo(substr($sak2[2],-3));
			
			
			 ?></span></td>
                        </tr>
                        <tr>
                          <td colspan="2" align="center" valign="top">&nbsp;</td>
                        </tr>
                      </table></td>
                    </tr>
                  </table></td>
                </tr>
              </table></td>
            </tr>
          </table></td>
        </tr>
      <tr>
        <td colspan="2" align="center" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="100%" height="100" align="right">&nbsp;</td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
</table>
<?

}
?>
</body>
</html>
