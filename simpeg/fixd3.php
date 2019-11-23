<?php
include("konek.php");
$q=mysqli_query($mysqli,"select nama,gelar_depan,gelar_belakang,pegawai.id_pegawai from pegawai inner join pendidikan_terakhir on pendidikan_terakhir.id_pegawai=pegawai.id_pegawai where flag_pensiun=0 and  (gelar_belakang like '%a%') and level_p>4");
extract($_POST);
if(isset($id))
{
	
if($pen==1)
$ting="S3";
elseif($pen==2)
$ting="S2";
elseif($pen==3)
$ting="S1";
elseif($pen==4)
$ting="D3";

	
	
mysqli_query($mysqli,"insert into pendidikan (id_pegawai,level_p,jurusan_pendidikan,tingkat_pendidikan) values($id,$pen,'$jur','$ting')");



}
?>
<style type="text/css">
body,td,th {
	font-family: Verdana, Geneva, sans-serif;
	font-size: 11px;
}
</style>

<table width="500" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr>
    <td nowrap="nowrap">No</td>
    <td nowrap="nowrap">Nama</td>
    <td nowrap="nowrap">Gelar Depan</td>
    <td nowrap="nowrap">Gelar Belakang</td>
    <td nowrap="nowrap">Pendidikan Seharusnya</td>
    <td nowrap="nowrap">Jurusan</td>
    <td nowrap="nowrap">Simpan</td>
  </tr>
  <?php
  $i=1;
  while($data=mysqli_fetch_array($q))
  {
	  $qd=mysqli_query($mysqli,"select count(*) from pendidikan where id_pegawai=$data[3] and level_p<5");
     $dek=mysqli_fetch_array($qd);
	 if($dek[0]==0)
	 {
	echo("<form name=form$i id=form$i method=post action=fixd3.php>");
	echo("<tr>
    <td>$i</td>
    <td nowrap>$data[0]</td>
    <td nowrap>$data[1]</td>
    <td nowrap>$data[2]</td>
    <td nowrap>");

	echo("<input type=hidden name=id id=id value=$data[3] /> ");
	echo("<select name=pen id=pen>");
	
		$q1=mysqli_query($mysqli,"select tingkat_pendidikan,level_p from pendidikan where level_p<5 and level_p>0 group by level_p order by level_p desc ");
			while($ata=mysqli_fetch_array($q1))
	{
	
	echo("<option value=$ata[1] > $ata[0]</option>");
	
	
	}
	echo("</select>");
	echo("</td>
    <td><input type=text name=jur id=jur value='-' /></td>
    <td><input type=submit value=simpan /></td>
  </tr>");
	echo("</form>");
	 }
	$i++;  
  }
  ?>
</table>
