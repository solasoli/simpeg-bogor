<table width="95%" border="0" cellspacing="0" cellpadding="3">
  <tr>
    <td>No</td>
    <td>Nama</td>
    <td>NIP</td>
    <td>Jabatan</td>
  </tr>
  <?
include("konek.php");
$q=mysqli_query($mysqli,"select * from jabatan where Tahun=2011 and jabatan not like '%walikota%' order by eselon");
$i=1;
while($data=mysqli_fetch_array($q))
{
$q1=mysqli_query($mysqli,"select id_pegawai from sk where id_j=$data[0] and id_kategori_sk=10 order by tmt desc");	
$cek=mysqli_fetch_array($q1);
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
    <td nowrap>$data[1]</td>
  </tr>");
}
}
  $i++;
}
?>
</table>
