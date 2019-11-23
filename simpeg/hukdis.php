<table width="800" border="1" cellspacing="0" cellpadding="3">
  <tr>
  DAFTAR HUKUMAN
  </tr>
  <tr>
    <td>No</td>
    <td>Nama</td>
    <td>NIP</td>
    <td>Hukuman</td>
	<td>Tgl Hukuman</td>
	<td>Keterangan</td>
  </tr>
  <?
include("konek.php");
$q=mysqli_query($mysqli,"select * from hukuman");
$i=1;
while($data=mysqli_fetch_array($q))
{
$cek=mysqli_fetch_array($q);
$q2=mysqli_query($mysqli,"select nama,nip_baru from pegawai where id_pegawai=$cek[0]");	
if($q2)
{
$dek=mysqli_fetch_array($q2);	
if($dek[0]!=NULL)
{
echo(" <tr>
    <td>$i</td>
    <td nowrap>$dek[0]</td>
    <td nowrap>$dek[1]</td>
	<td nowrap>$data[2]</td>
    <td nowrap>$data[3]</td>
	<td nowrap>$data[4]</td>
  </tr>");
}
}
  $i++;
}
?>
</table>