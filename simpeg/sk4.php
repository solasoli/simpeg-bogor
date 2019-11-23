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
	font-size: 10pt;
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
body p {
	text-align: justify;
}
#kuya {
	text-align: justify;
}
.konsumsi {
	text-align: justify;
}
.kmapret {
	text-align: justify;
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


$qp=mysqli_query($mysqli,"Select nama,jabatan.jabatan,pegawai.id_pegawai,eselon,tunjangan,nip_baru,pangkat_gol from mutasi_jabatan inner join jabatan on jabatan.id_j=mutasi_jabatan.id_j inner join pegawai on pegawai.id_pegawai=mutasi_jabatan.id_pegawai where eselon='$s' $were");

$dai=array('Minggu','Senin','Selasa','Rabu','Kamis','Jum\'at','Sabtu');
			$ariy=array('lieur','Satu','Dua','Tiga','Empat','Lima','Enam','Tujuh','Delapan','Sembilan','Sepuluh','Sebelas','Dua Belas','Tiga Belas','Empat Belas','Lima Belas','Enam Belas','Tujuh Belas','Delapan Belas','Sembilan Belas','Dua Puluh','Dua Puluh Dua','Dua Puluh Tiga','Dua Puluh Empat','Dua Puluh Lima','Dua Puluh Enam','Dua Puluh Enam','Dua Puluh Tujuh','Dua Puluh Delapan','Dua Puluh Sembilan','Tiga Puluh','Tiga Puluh Satu',);
			
			$taon=array('Dua Ribu Sepuluh','Dua Ribu Sebelas','Dua Ribu Dua Belas','Dua Ribu Tiga Belas','Dua Ribu Empat Belas','Dua Ribu Lima Belas','Dua Ribu Dua Belas','Dua Ribu Tujuh Belas','Dua Ribu Delapan Belas','Dua Ribu Sembilan Belas','Dua Ribu Dua Puluh');
			$bulan=array('bulan','Januari','Februari','maret','April','Mei','Juni','Juli','Agustus','September','Oktober','Nopember','Desember');
			 if(substr($bln,0,1)=='0')
 $mon=substr($bln,1,1);
 else
 $mon=$bln;

//echo("Select nama,jabatan.jabatan,pegawai.id_pegawai,eselon,tunjangan from mutasi_jabatan inner join jabatan on jabatan.id_j=mutasi_jabatan.id_j inner join pegawai on pegawai.id_pegawai=mutasi_jabatan.id_pegawai where eselon='$s' $were");


?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><table  width="100%" border="0" cellspacing="0" cellpadding="3">
      <tr>
        <td width="806" align="center" valign="top"><strong>PEMERINTAH KOTA BOGOR<BR />BADAN PERTIMBANGAN JABATN DAN KEPANGKATAN</strong><BR /><BR />Nomor : <? echo($baper); ?><br />Tanggal : <? echo("&nbsp;&nbsp;&nbsp;&nbsp; $bulan[$mon] $thn"); ?></td>
      </tr>
      <tr>
        <td align="center" valign="top" bgcolor="#FFFFFF"><div align="left">Pada hari ini
          <?  
			
			$hari=(jddayofweek("2011-05-31",0));
			echo("$hari");
 ?> 
          tanggal <?
		
 echo("$tgl $bulan[$mon] $thn");
		
		?>
          Kami Badan Pertimbangan Jabatandan Kepangkatan (Baperjakat) Pemerintah Kota Bogor <br />yang dibentuk dengan Keputusan walikota Bogor Tanggal 24 Maret 2011 Nomor 820.45-36 Tahun 2011 yang terdiri dari :
          <table width="400" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
              <td width="17">1.</td>
              <td width="106">Ketua</td>
              <td width="10">:</td>
              <td width="267">Sekretaris Daerah Kota Bogor</td>
              </tr>
            <tr>
              <td>2.</td>
              <td>Sekretaris</td>
              <td>:</td>
              <td nowrap="nowrap">Kabid Mutasi dan Pengembangan Karir</td>
              </tr>
            <tr>
              <td>3.</td>
              <td>Anggota</td>
              <td>:</td>
              <td nowrap="nowrap">Kepala Badan Kepegawaian Pendidikan dan Pelatihan Kota Bogor</td>
              </tr>
            <tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>Inspektur Kota Bogor</td>
              </tr>
            <tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>Asisten Tata Praja Setda Kota Bogor</td>
              </tr>
            <tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td nowrap="nowrap">Asisten Administrasi Kemasyarakatan &amp; Pembangunan Setda Kota Bogor</td>
              </tr>
            <tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>Asisten Administrasi Umum Setda Kota Bogor</td>
              </tr>
            </table>
          Telah melaksanakan rapat untuk memberikan Pertimbangan Kelayakan Pengangkatan dan alih tugas Pegawai Negeri Sipil dalamJabatan Struktural di lingkungan Pemerintah Kota Bogor, antara lain : </div></td>
      </tr>
      <tr>
        <td align="LEFT" valign="top">Eselon <? echo($s); ?><table width="100%" bordercolor="#000000" border="1" cellspacing="0" cellpadding="1">
          <tr>
            <td align="center" valign="middle"><strong>NO</strong></td>
            <td align="center" valign="top"><strong>NAMA<BR />NIP<BR />TANGGAL LAHIR</strong></td>
            <td align="center"><strong>PANGKAT<BR />GOL. RUANG</strong></td>
            <td align="center" valign="middle" nowrap="nowrap"><strong>JABATAN LAMA</strong></td>
            <td align="center" valign="middle" nowrap="nowrap"><strong>JABATAN BARU</strong></td>
            <td align="center" valign="middle"><strong>ESELON</strong></td>
            <td align="center" valign="middle"><strong>KETERANGAN</strong></td>
            </tr>
          <tr>
            <td align="center" valign="middle">1</td>
            <td align="center" valign="middle">2</td>
            <td align="center" valign="middle">3</td>
            <td align="center" valign="middle">4</td>
            <td align="center" valign="middle">5</td>
            <td align="center" valign="middle">6</td>
            <td align="center" valign="middle">7</td>
            </tr>
          <?
		  $i=1;
		  while($data=mysqli_fetch_array($qp))
{
	
			$qp2=mysqli_query($mysqli,"select nama,riwayat_mutasi_kerja.jabatan,riwayat_mutasi_kerja.eselonering,sk.id_j from pegawai inner join sk on pegawai.id_pegawai=sk.id_pegawai inner join riwayat_mutasi_kerja on riwayat_mutasi_kerja.id_sk=sk.id_sk where sk.id_pegawai=$data[2] order by tgl_sk desc");
			$coi=mysqli_fetch_array($qp2);
	
	echo(" <tr>
            <td align=center  valign=middle >$i</td>
            <td ><table width=100%><tr><td nowrap>$data[0]</td></tr><tr><td>");
			echo(substr($data[5],0,8));
			echo(" ");
			echo(substr($data[5],8,6));
			echo(" ");
			echo(substr($data[5],14,1));
			echo(" ");
			echo(substr($data[5],-3));
			
			echo("</td></tr></table></td>
            <td align=center  valign=middle>");
			
			$pang=$data[6];
			if($pang=='I/a')
			$pang="Juru Muda <br> $pang";
			elseif($pang=='I/b')
			$pang="Juru Muda Tingkat I <br> $pang";
			elseif($pang=='I/c')
			$pang="Juru - $pang";
			elseif($pang=='I/d')
			$pang="Juru Tingkat I <br> $pang";
			elseif($pang=='II/a')
			$pang="Pengatur Muda <br> $pang";
			elseif($pang=='II/b')
			$pang="Pengatur Muda Tingkat I <br> $pang";
			elseif($pang=='II/c')
			$pang="Pengatur <br> $pang";
			elseif($pang=='II/d')
			$pang="Pengatur Tingkat I <br> $pang";
			elseif($pang=='III/a')
			$pang="Penata Muda <br> $pang";
			elseif($pang=='III/b')
			$pang="Penata Muda Tingkat I <br> $pang";
			elseif($pang=='III/c')
			$pang="Penata <br> $pang";
			elseif($pang=='III/d')
			$pang="Penata Tingkat I  <br> $pang";
			elseif($pang=='IV/a')
			$pang="Pembina <br> $pang";
			elseif($pang=='IV/b')
			$pang="Pembina  Tingkat I <br> $pang";
			elseif($pang=='IV/c')
			$pang="Pembina Utama Muda <br> $pang";
			elseif($pang=='IV/d')
			$pang="Pembina Utama Madya <br> $pang";
			elseif($pang=='IV/e')
			$pang="Pembina Utama <br> $pang";
			echo("$pang");
			
			 $qj=mysqli_query($mysqli,"select jabatan,eselon from jabatan where id_j=$coi[3]");
			 if($qj)
	  $jo=mysqli_fetch_array($qj);
			
			 if("$data[3]"=="$jo[1]")
	   {
	   if("$data[1]"=="$jo[0]")
	   $ket="Tetap";
	   else
	   $ket="Rotasi";
	   
	   }
	   else
	   $ket="Promosi";
	  
			
			echo("</td>
            <td width=300>");
			if($coi[1]==NULL)
			echo("Staf Pelaksana");
			else
			echo("$coi[1]");
			echo("</td>
            <td valign=top align=left width=300>$data[1]</td>
            <td valign=top align=center >$data[3]</td>
            <td valign=top align=left>$ket</td>
          </tr>");
		  $i++;
}

?>
          </table></td>
      </tr>
      <tr>
        <td align="LEFT" valign="top">Demikian Hasil Rapat Badan Pertimbangan Jabatan dan Kepangkatan Pemerintah Kota Bogor telah ditutup dan ditandatangani oleh Ketua,Sekretaris dan Anggota pada hari ini tanggal tersebut di atas pukul 10.00 WIB. di ruang kerja Sekretaris Daerah Kota Bogor</td>
      </tr>
      <tr>
        <td align="LEFT" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="2">
          <tr>
            <td width="25%" align="center" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td align="center">Ketua,</td>
              </tr>
              <tr>
                <td align="center" nowrap="nowrap">Sekretaris Daerah Kota Bogor</td>
              </tr>
              <tr>
                <td height="30">&nbsp;</td>
              </tr>
              <tr>
                <td align="center"><?
				$taon=date("Y");
				$qj1=mysqli_query($mysqli,"select id_j from jabatan where Tahun=$taon and jabatan like 'Sekretaris Daerah Kota Bogor%'");
				$ja1=mysqli_fetch_array($qj1);
                $qsek=mysqli_query($mysqli,"select nama,nip_baru from pegawai where id_j=$ja1[0]");
				$sek=mysqli_fetch_array($qsek);
				echo("<strong><u>$sek[0]</u></strong><br>");
				
				echo(substr($sek[1],0,8));
			echo(" ");
			echo(substr($sek[1],8,6));
			echo(" ");
			echo(substr($sek[1],14,1));
			echo(" ");
			echo(substr($sek[1],-3));
				?></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
              </tr>
            </table></td>
            <td width="6%">&nbsp;</td>
            <td width="40%" align="center" valign="bottom"><strong>Anggota</strong></td>
            <td width="1%">&nbsp;</td>
            <td width="28%" align="center" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td align="center">Sekretaris,</td>
              </tr>
              <tr>
                <td align="center" nowrap="nowrap">Kepala Bidang Mutasi dan Bangrier</td>
              </tr>
              <tr>
                <td height="30">&nbsp;</td>
              </tr>
              <tr>
                <td align="center"><?
				$taon=date("Y");
				$qj1=mysqli_query($mysqli,"select id_j from jabatan where Tahun=$taon and jabatan like 'Kepala Bidang Mutasi%'");
				$ja1=mysqli_fetch_array($qj1);
                $qsek=mysqli_query($mysqli,"select nama,nip_baru from pegawai where id_j=$ja1[0]");
				$sek=mysqli_fetch_array($qsek);
				echo("<strong><u>$sek[0]</u></strong><br>");
				
				echo(substr($sek[1],0,8));
			echo(" ");
			echo(substr($sek[1],8,6));
			echo(" ");
			echo(substr($sek[1],14,1));
			echo(" ");
			echo(substr($sek[1],-3));
				?></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td align="center" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td align="center" valign="top" nowrap="nowrap">1. Kepala Badan Kepegawaian<br /></td>
                </tr>
              <tr>
                <td align="center" valign="top">Pendidikan dan Pelatihan</td>
                </tr>
              <tr>
                <td height="30">&nbsp;</td>
                </tr>
              <tr>
                <td align="center"><?
				$taon=date("Y");
				$qj1=mysqli_query($mysqli,"select id_j from jabatan where Tahun=$taon and jabatan like 'Kepala Badan Kepegawaian%'");
				$ja1=mysqli_fetch_array($qj1);
                $qsek=mysqli_query($mysqli,"select nama,nip_baru from pegawai where id_j=$ja1[0]");
				$sek=mysqli_fetch_array($qsek);
				echo("<strong><u>$sek[0]</u></strong><br>");
				
				echo(substr($sek[1],0,8));
			echo(" ");
			echo(substr($sek[1],8,6));
			echo(" ");
			echo(substr($sek[1],14,1));
			echo(" ");
			echo(substr($sek[1],-3));
				?></td>
              </tr>
              </table></td>
            <td>&nbsp;</td>
            <td align="center" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td align="center" valign="top" nowrap="nowrap">3. Asisten Tata Praja<br /></td>
                </tr>
              <tr>
                <td height="30">&nbsp;</td>
                </tr>
              <tr>
                <td align="center"><?
				$taon=date("Y");
				$qj1=mysqli_query($mysqli,"select id_j from jabatan where Tahun=$taon and jabatan like 'Asisten Tata Praja%'");
				$ja1=mysqli_fetch_array($qj1);
                $qsek=mysqli_query($mysqli,"select nama,nip_baru from pegawai where id_j=$ja1[0]");
				$sek=mysqli_fetch_array($qsek);
				echo("<strong><u>$sek[0]</u></strong><br>");
				
				echo(substr($sek[1],0,8));
			echo(" ");
			echo(substr($sek[1],8,6));
			echo(" ");
			echo(substr($sek[1],14,1));
			echo(" ");
			echo(substr($sek[1],-3));
				?></td>
              </tr>
              </table></td>
            <td>&nbsp;</td>
            <td align="center" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td align="center" valign="top" nowrap="nowrap">5.Asisten Administrasi Umum<br /></td>
                </tr>
              <tr>
                <td height="30">&nbsp;</td>
                </tr>
              <tr>
                <td align="center"><?
				$taon=date("Y");
				$qj1=mysqli_query($mysqli,"select id_j from jabatan where Tahun=$taon and jabatan like 'Asisten Administrasi Umum%'");
				$ja1=mysqli_fetch_array($qj1);
                $qsek=mysqli_query($mysqli,"select nama,nip_baru from pegawai where id_j=$ja1[0]");
				$sek=mysqli_fetch_array($qsek);
				echo("<strong><u>$sek[0]</u></strong><br>");
				
				echo(substr($sek[1],0,8));
			echo(" ");
			echo(substr($sek[1],8,6));
			echo(" ");
			echo(substr($sek[1],14,1));
			echo(" ");
			echo(substr($sek[1],-3));
				?></td>
              </tr>
              </table></td>
          </tr>
          <tr>
            <td align="center" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td align="center" valign="top" nowrap="nowrap">2. Inspektur Kota Bogor<br /></td>
                </tr>
              <tr>
                <td height="30">&nbsp;</td>
                </tr>
              <tr>
                <td align="center"><?
				$taon=date("Y");
				$qj1=mysqli_query($mysqli,"select id_j from jabatan where Tahun=$taon and jabatan like 'Inspektur Kota Bogor%'");
				$ja1=mysqli_fetch_array($qj1);
                $qsek=mysqli_query($mysqli,"select nama,nip_baru from pegawai where id_j=$ja1[0]");
				$sek=mysqli_fetch_array($qsek);
				echo("<strong><u>$sek[0]</u></strong><br>");
				
				echo(substr($sek[1],0,8));
			echo(" ");
			echo(substr($sek[1],8,6));
			echo(" ");
			echo(substr($sek[1],14,1));
			echo(" ");
			echo(substr($sek[1],-3));
				?></td>
                </tr>
              <tr>
                <td>&nbsp;</td>
                </tr>
              </table></td>
            <td>&nbsp;</td>
            <td align="center" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td align="center" valign="top" nowrap="nowrap">4. Asisten Administrasi Kemasyarakatan<br />
                  dan Pembangunan</td>
              </tr>
              <tr>
                <td height="30">&nbsp;</td>
              </tr>
              <tr>
                <td align="center"><?
				$taon=date("Y");
				$qj1=mysqli_query($mysqli,"select id_j from jabatan where Tahun=$taon and jabatan like 'Asisten Administrasi Kemasyarakatan%'");
				$ja1=mysqli_fetch_array($qj1);
                $qsek=mysqli_query($mysqli,"select nama,nip_baru from pegawai where id_j=$ja1[0]");
				$sek=mysqli_fetch_array($qsek);
				echo("<strong><u>$sek[0]</u></strong><br>");
				
				echo(substr($sek[1],0,8));
			echo(" ");
			echo(substr($sek[1],8,6));
			echo(" ");
			echo(substr($sek[1],14,1));
			echo(" ");
			echo(substr($sek[1],-3));
				?></td>
              </tr>
              </table></td>
            <td>&nbsp;</td>
            <td align="left" valign="top">&nbsp;</td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
</table>


</body>
</html>
