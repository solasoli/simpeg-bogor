<?
include("konek.php");
extract($_POST);
extract($_GET);
$q=mysqli_query($mysqli,"select nama,nip_baru,id_pegawai,right(left(nip_baru,14),2)  from pegawai where right(left(nip_baru,13),1)='0' and right(left(nip_baru,14),1)<5 and flag_pensiun=0 and jenjab like 'struktural' and length(nip_baru)=18 and (left(curdate(),4)-right(left(nip_baru,12),4))%4=0 and left(curdate(),4)-right(left(nip_baru,12),4)>=4 order by  right(left(nip_baru,14),2)
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
	
	
	$unit=mysqli_fetch_array($qu);
	
	$skr=date("Y");
	if(substr($data[3],0,1)==0)
	$bul=substr($data[3],1,1);
	else
	$bul=$data[3];
	$qd=mysqli_query($mysqli,"select count(*) from sk where id_kategori_sk=5 and id_pegawai=$data[2] and  tmt like '$skr%'");
	$dor=mysqli_fetch_array($qd);
	if($dor[0]==0)
	{echo("<tr>
<td>$i</td>
<td nowrap>$data[nama]</td>
<td>$data[nip_baru]</td>
<td width=500>$unit[0]</td>
<td nowrap>$bulan[$bul]</td>

</tr>");
	$i++;
	}
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