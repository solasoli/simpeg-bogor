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
	font-size: 12pt;
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


$qp=mysqli_query($mysqli,"Select nama,jabatan.jabatan,pegawai.id_pegawai,eselon,tunjangan from mutasi_jabatan inner join jabatan on jabatan.id_j=mutasi_jabatan.id_j inner join pegawai on pegawai.id_pegawai=mutasi_jabatan.id_pegawai where eselon='$s' $were");

//echo("Select nama,jabatan.jabatan,pegawai.id_pegawai,eselon,tunjangan from mutasi_jabatan inner join jabatan on jabatan.id_j=mutasi_jabatan.id_j inner join pegawai on pegawai.id_pegawai=mutasi_jabatan.id_pegawai where eselon='$s' $were");

while($data=mysqli_fetch_array($qp))
{
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><table  width="846" height="395" border="0" cellspacing="0" cellpadding="5">
      <tr>
        <td width="806" height="205" align="center" valign="top"><strong>PEMERINTAH KOTA BOGOR<BR />
        BADAN PERTIMBANGAN JABATAN DAN KEPANGKATAN</strong><BR /><BR />
        Nomor : </td>
      </tr>
      <tr>
        <td height="20" align="center" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td colspan="2" align="center" valign="top">&nbsp;</td>
            <td>&nbsp;</td>
            </tr>
          <tr>
            <td colspan="2" align="center" valign="top">&nbsp;</td>
            <td width="30%">&nbsp;</td>
            </tr>
          <tr>
            <td width="10%" align="left" valign="top">&nbsp;</td>
            <td width="60%" align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">&nbsp;</td>
            </tr>
          </table></td>
      </tr>
      <tr>
        <td height="170" align="center" valign="top">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
</table>
<?

}
?>

</body>
</html>
