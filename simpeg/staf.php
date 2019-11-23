<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<?php
include("konek.php");
extract($_GET);
extract($_POST);
if(isset($idr))
{

for($i=1;$i<=$tot;$i++)
{
$pindah=$_POST["p".$i];

if($pindah!=NULL)
{
 $taon=date("Y");
	  $qcek=mysqli_query($mysqli,"select id_riwayat from riwayat_mutasi_kerja inner join sk on sk.id_sk=riwayat_mutasi_kerja.id_sk where riwayat_mutasi_kerja.id_pegawai=$pindah and tmt like '$taon%' and id_kategori_sk=1 order by tmt desc");
	  $cok=mysqli_fetch_array($qcek);
	  mysqli_query($mysqli,"update riwayat_mutasi_kerja set id_j_bos=$idr where id_riwayat=$cok[0]");


}


}








echo("<div align=center>Data Staf sudah diupdate </div>");
include("list2.php");
}
else
{
$qp=mysqli_query($mysqli,"select concat(gelar_depan,' ',nama,' ',gelar_belakang) as nama, nip_baru,id_j,id_unit_kerja from pegawai inner join current_lokasi_kerja on pegawai.id_pegawai=current_lokasi_kerja.id_pegawai where pegawai.id_pegawai=$od");


$peg=mysqli_fetch_array($qp);
$qjab=mysqli_query($mysqli,"select jabatan from jabatan where id_j=$peg[2]");
$job=mysqli_fetch_array($qjab);
?>

<form action="index3.php" method="post" enctype="multipart/form-data" name="form1" id="form1">
  <table width="80%" border="0" align="center" cellpadding="10" cellspacing="0" class="table">
    <tr>
      <td>Nama
      <input name="idr" type="hidden" id="idr" value="<?php echo $peg[2]; ?>" />
      <input name="x" type="hidden" id="x" value="staf.php" /></td>
      <td>:</td>
      <td><?php echo $peg[0]; ?></td>
    </tr>
    <tr>
      <td>Nip</td>
      <td>:</td>
      <td><?php echo $peg[1]; ?></td>
    </tr>
    <tr>
      <td>Jabatan</td>
      <td>:</td>
      <td><?php echo $job[0]; ?></td>
    </tr>
    <tr>
      <td valign="top">Pegawai yang dinilai</td>
      <td valign="top">:</td>
      <td><?php
      //print_r($peg);exit;
	  $qbah = mysqli_query ("select concat(gelar_depan,' ',nama,' ',gelar_belakang) as nama,
                nip_baru from riwayat_mutasi_kerja
                inner join pegawai on pegawai.id_pegawai=riwayat_mutasi_kerja.id_pegawai
                inner join current_lokasi_kerja clk on clk.id_pegawai = pegawai.id_pegawai
                where riwayat_mutasi_kerja.id_j_bos=$peg[2]
                and clk.id_unit_kerja=".$peg['id_unit_kerja']."
                group by pegawai.id_pegawai"
               ); 
	   ?>
       <ul><?php
      while($anak=mysqli_fetch_array($qbah))
	  {

	  echo("<li>".$anak[0]." ".$anak['nip_baru']."</li>");

	  }

	  ?>
      </ul>
       </td>
    </tr>
    <tr>
      <td>Tambah Pegawai Yang dinilai</td>
      <td>:</td>
      <td><label>
      <?php
	  $qlis=mysqli_query($mysqli,"select concat(gelar_depan,' ',nama,' ',gelar_belakang) as nama, pegawai.id_pegawai, pegawai.nip_baru  from pegawai inner join current_lokasi_kerja on pegawai.id_pegawai=current_lokasi_kerja.id_pegawai where id_unit_kerja=$peg[3] and id_j is null order by nama");

	  $f=1;
	  while($lp=mysqli_fetch_array($qlis))
	  {
	  $taon=date("Y");
	  $qcek=mysqli_query($mysqli,"select id_j_bos from riwayat_mutasi_kerja inner join sk on sk.id_sk=riwayat_mutasi_kerja.id_sk where riwayat_mutasi_kerja.id_pegawai=$lp[1] and tmt like '$taon%'");
	  //echo("select id_j_bos from riwayat_mutasi_kerja inner join sk on sk.id_sk=riwayat_mutasi_kerja.id_sk where id_pegawai=$lp[1] and tmt like '$taon%'");

	  $cek=mysqli_fetch_array($qcek);

	  if($cek[0]!=$peg[2])
	  {
	  ?>
        <input name="p<?php echo $f; ?>" type="checkbox" id="p<?php echo $f; ?>" value="<?php echo $lp[1] ?>" /> <?php echo ("$lp[0] - $lp[2]<br>"); ?>

      <?php
	  }
	  $f++;
      }
	  ?>

      </label>
      <?php


	  ?>
      <input type="hidden" name="tot" id="tot" value="<?php echo $f; ?>" />
        </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><label>
        <input type="submit" name="button" id="button" value="Simpan" />
      </label></td>
    </tr>
  </table>
</form>
<p>
  <?php
}

?>
</p>

<p>&nbsp;</p>
</body>
</html>
