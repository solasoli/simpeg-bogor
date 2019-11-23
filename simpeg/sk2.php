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
	font-family: Times New Roman, Times, serif;
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


$qp=mysqli_query($mysqli,"Select nama,jabatan.jabatan,pegawai.id_pegawai,eselon,tunjangan,jabatan.id_j from mutasi_jabatan inner join jabatan on jabatan.id_j=mutasi_jabatan.id_j inner join pegawai on pegawai.id_pegawai=mutasi_jabatan.id_pegawai where eselon='$s' $were");

//echo("Select nama,jabatan.jabatan,pegawai.id_pegawai,eselon,tunjangan,jabatan.id_j from mutasi_jabatan inner join jabatan on jabatan.id_j=mutasi_jabatan.id_j inner join pegawai on pegawai.id_pegawai=mutasi_jabatan.id_pegawai where eselon='$s'");

while($data=mysqli_fetch_array($qp))
{
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td></td>
  </tr>
  <tr>
    <td><table width="846" height="936" border="0" cellspacing="0" cellpadding="0">
     
      <tr>
        <td height="205" colspan="2">&nbsp;</td>
        </tr>
      <tr>
        <td height="20">&nbsp;</td>
        <td width="672" height="30" align="left" valign="top">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Daftar lampiran Keputusan Walikota Bogor</td>
      </tr>
      <tr>
        <td width="150" height="80">&nbsp;</td>
        <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="3">
          <tr>
            <td width="18%">&nbsp;</td>
            <td width="15%">Nomor</td>
            <td width="1%">:</td>
            <td width="66%"><? echo($sk); ?></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Tanggal</td>
            <td>:</td>
            <td><? echo("$tgl2 $bul2 $thn2 ");  ?></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="left" valign="top">Tentang</td>
            <td align="left" valign="top">:</td>
            <td>Pengangkatan dan Alih Tugas Dalam Jabatan Struktural di Lingkungan Pemerintah Kota Bogor</td>
          </tr>
          </table></td>
      </tr>
      <tr>
        <td colspan="2" align="center" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td>&nbsp;</td>
            <td colspan="4"><hr /></td>
            </tr>
          <tr>
            <td width="12%">&nbsp;</td>
            <td width="4%">&nbsp;</td>
            <td width="23%">&nbsp;</td>
            <td width="1%">&nbsp;</td>
            <td width="60%">&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>1.</td>
            <td>Nomor</td>
            <td>:</td>
            <td><? echo($sk); ?></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>2.</td>
            <td>Nama</td>
            <td>:</td>
            <td><? echo($data[0]); 
		  
		  $q1=mysqli_query($mysqli,"select * from pegawai where id_pegawai=$data[2]");
		 
		  $peg=mysqli_fetch_array($q1);
		  ?></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>NIP</td>
            <td>:</td>
            <td><? 
		  if($peg['nip_baru']=='-')
		  echo("$peg[nip_lama]");
		  else
		  echo("$peg[nip_baru]"); ?></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>Tanggal Lahir</td>
            <td>:</td>
            <td><? 
		  
		  $tg1=substr($peg['tgl_lahir'],8,2);
		  $bl1=substr($peg['tgl_lahir'],5,2);
		  $th1=substr($peg['tgl_lahir'],0,4);
		  
		  echo("$tg1-$bl1-$th1");
		   ?></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>3.</td>
            <td nowrap="nowrap">Pangkat-Golongan/Ruang</td>
            <td>:</td>
            <td><? 
			$pang=$peg['pangkat_gol'];
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
						
			
			echo($pang); 
		  ?></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td nowrap="nowrap">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td nowrap="nowrap">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>4.</td>
            <td nowrap="nowrap">Jabatan Lama</td>
            <td>:</td>
            <td><? $qjab=mysqli_query($mysqli,"select jabatan.jabatan,jabatan.id_j from riwayat_mutasi_kerja inner join jabatan on jabatan.id_j=riwayat_mutasi_kerja.id_j where id_pegawai=$peg[0]");
		  $jab=mysqli_fetch_array($qjab);
		  echo($jab[0]);
		  ?></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td nowrap="nowrap">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td nowrap="nowrap">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>5.</td>
            <td nowrap="nowrap">Jabatan Baru</td>
            <td>:</td>
            <td><? echo($data[1]); 
		  ?></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td nowrap="nowrap">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td nowrap="nowrap">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td nowrap="nowrap">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>6.</td>
            <td nowrap="nowrap">Eselon</td>
            <td>:</td>
            <td><? 
			$baru=str_replace('A',' A',"$data[3]");
			$baru=str_replace('B',' B',"$data[3]");
			echo($baru); 
		  
		  ?></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td nowrap="nowrap">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>7.</td>
            <td nowrap="nowrap">Tunjangan Jabatan</td>
            <td>:</td>
            <td><?
		  $tun=number_format($data[4],0,',','.');
		   echo("Rp $tun,-"); 
		  ?></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td nowrap="nowrap">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td colspan="5" align="center">B A P E R J A K A T</td>
            </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td nowrap="nowrap">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td nowrap="nowrap">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>8.</td>
            <td nowrap="nowrap">Nomor</td>
            <td>:</td>
            <td><? echo($baper); 
		  
		  ?></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td nowrap="nowrap">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>9.</td>
            <td nowrap="nowrap">Tanggal</td>
            <td>:</td>
            <td><? echo("$tgl2 $bul2 $thn2 ");  ?></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td nowrap="nowrap">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>10.</td>
            <td nowrap="nowrap">Keterangan</td>
            <td>:</td>
            <td><?
            
			 $qp1=mysqli_query($mysqli,"select nama,riwayat_mutasi_kerja.jabatan,riwayat_mutasi_kerja.eselonering from pegawai inner join sk on pegawai.id_pegawai=sk.id_pegawai inner join riwayat_mutasi_kerja on riwayat_mutasi_kerja.id_sk=sk.id_sk where sk.id_pegawai=$data[2] order by tgl_sk desc");
	  
	 
	  $pegi=mysqli_fetch_array($qp1);
			 $qj1=mysqli_query($mysqli,"select jabatan,eselon from jabatan where id_j=$data[5]");
	  $joi=mysqli_fetch_array($qj1);
	  
	   if("$pegi[2]"=="$joi[1]")
	   {
	   if("$pegi[1]"=="$joi[0]")
	   $ket="Tetap";
	   else
	   $ket="Rotasi";
	   
	   }
	   else
	   $ket="Promosi";
	 echo("$ket");
			?></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td nowrap="nowrap">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td nowrap="nowrap">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td nowrap="nowrap">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td colspan="5"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="70%" align="center" valign="top"><table width="55%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td align="center" valign="top">Sesuai dengan aslinya,<br />
                        <?
                  if($data[3]=='IIA' or $data[3]=='IIB')
				  echo("Sekretaris Daerah Kota Bogor");
				  else
				  echo("Kepala Badan Kepegawaian Pendidikan<br>dan Pelatihan Kota Bogor");
				  ?>    </td>
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
                    <td align="center" valign="top"><strong><u><?
				if($data[3]=='IIA' or $data[3]=='IIB')
				echo("H. BAMBANG GUNAWAN S,SH,M.Si");
				else
				{
				echo("Dra.Hj.FETTY QONDARSYAH,M.Si");
					
				}
				?></u></strong></td>
                    </tr>
                  <tr>
                    <td align="center" valign="top"> <? if($data[3]=='IIA' or $data[3]=='IIB')
                echo("Pembina Utama Madya");
				else
				echo("Pembina Utama Muda");
				?><br />
                      <? if($data[3]=='IIA' or $data[3]=='IIB')
                  echo("NIP 19550613 198203 1 009");
				  else
				  echo("NIP 19581024 198603 2 005");
				  ?></td>
                    </tr>
                  <tr>
                    <td align="center" valign="top">&nbsp;</td>
                    </tr>
                  <tr>
                    <td align="center" valign="top">&nbsp;</td>
                  </tr>
                  </table></td>
                <td width="30%" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td align="left" valign="top">&nbsp;</td>
                    </tr>
                  <tr>
                    <td align="left" valign="top">WALIKOTA BOGOR,<br /></td>
                    </tr>
                  <tr>
                    <td align="left" valign="top">&nbsp;</td>
                  </tr>
                  <tr>
                    <td align="left" valign="top">&nbsp;</td>
                    </tr>
                  <tr>
                    <td align="left" valign="top">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ttd</td>
                    </tr>
                  <tr>
                    <td align="left" valign="top">&nbsp;</td>
                  </tr>
                  <tr>
                    <td align="left" valign="top">&nbsp;</td>
                    </tr>
                  <tr>
                    <td align="left" valign="top"><strong>DIANI BUDIARTO</strong></td>
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
    <td height="170">&nbsp;</td>
  </tr>
</table>
<?

}
?>

</body>
</html>
