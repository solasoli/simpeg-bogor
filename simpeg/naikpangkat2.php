<?
include("konek.php");
extract($_POST);
extract($_GET);
$q=mysqli_query($mysqli,"SELECT nama,nip_baru,id_pegawai,MID(nip_baru,13,2) as bulan_naik_pangkat

				FROM pegawai

				WHERE ((LEFT(CURRENT_DATE(),4) - MID(nip_baru,9, 4)) % 4 =  0

				AND MID(nip_baru,13,2) >= MID(CURRENT_DATE(),6,2) AND jenjab = 'Struktural' and flag_pensiun=0 ) order by MID(nip_baru,13,2)
");


?>
<style type="text/css">
body,td,th {
	font-family: Verdana, Geneva, sans-serif;
	font-size: 12px;
}
</style>

<table width="100%"  cellpadding="5" border="0" cellspacing="0">
<tr>
<td>NO</td>
<td>NAMA</td>
<td>NIP</td>
<td width="700">UNIT KERJA</td>
<td nowrap="nowrap">TMT CPNS</td>

</tr>
<?
$bulan=array("bulan","Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","Nopember","Desember");
$i=1;
while($data=mysqli_fetch_array($q))
{
	$qu=mysqli_query($mysqli,"select nama_baru from riwayat_mutasi_kerja inner join unit_kerja on riwayat_mutasi_kerja.id_unit_kerja=unit_kerja.id_unit_kerja inner join sk on sk.id_sk=riwayat_mutasi_kerja.id_sk where riwayat_mutasi_kerja.id_pegawai=$data[2] order by tmt desc ");
	//echo("select nama_baru from riwayat_mutasi_kerja inner join unit_kerja on riwayat_mutasi_kerja.id_unit_kerja=unit_kerja.id_unit_kerja inner join sk on sk.id_sk=riwayat_mutasi_kerja.id_sk where sk.id_pegawai=$data[2] order by tmt desc <br>");
	
	$unit=mysqli_fetch_array($qu);
	
	$urut[$i]=$unit[0];
	$urut[$i]['nama']=$data['nama'];
	//$urut[$i][$i][$i]=$data['nip_baru'];
	
	if(substr($data[3],0,1)==0)
	$bul=substr($data[3],1,1);
	else
	$bul=$data[3];
	echo("<tr>
<td>$i</td>
<td nowrap>$data[nama]</td>
<td>$data[nip_baru]</td>
<td width=500>$unit[0]</td>
<td nowrap>$bulan[$bul]</td>

</tr>");
	$i++;
	
}
/*$batas=$i-2;
sort($urut);
for($i=0;$i<=$batas;$i++)
{echo("<tr>
<td>$i</td>
<td nowrap>$urut[$i] </td>
<td>$urut[$i][nama]</td>
<td nowrap>xx</td>

</tr>");
}
*/
?>
</table>