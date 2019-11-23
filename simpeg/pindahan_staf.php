<?

include("konek.php");
$q=mysqli_query($mysqli,"select * from mutasi_pegawai");
$i=0;
while($data=mysqli_fetch_array($q))
{


$q2=mysqli_query($mysqli,"select pangkat_gol from pegawai where id_pegawai=$data[4]");
//echo("select pangkat_gol from pegawai where id_pegawai=$data[1]<br>");

$ta=mysqli_fetch_array($q2);


$sk='820.45-158 Tahun 2016';
//elseif($ata[1]=='V')
//$sk='821.2.45-41 Tahun 2012';

$tanggal_sk = '2016-12-28';

$qcek=mysqli_query($mysqli,"select count(*) from sk where id_pegawai=$data[4] and tmt ='2017-01-03'");
$cek=mysqli_fetch_array($qcek);
//$sk = "820.45 - 52  Tahun 2016";
if($cek[0]==0)
{
mysqli_query($mysqli,"insert into sk (id_pegawai,id_kategori_sk,no_sk,tgl_sk,pemberi_sk,pengesah_sk,keterangan,tmt) values ($data[4],1,'$sk','$tanggal_sk','Walikota Bogor','Bima Arya','$ta[0]','2017-01-03')");

$q4=mysqli_query($mysqli,"select * from sk order by id_sk desc");
$a=mysqli_fetch_array($q4);

mysqli_query($mysqli,"insert into riwayat_mutasi_kerja (id_pegawai,id_sk,id_unit_kerja,id_j,pangkat_gol) values ($data[4],$a[0],$data[5],0,'$ta[0]')");
mysqli_query($mysqli,"update current_lokasi_kerja set id_unit_kerja=$data[5] where id_pegawai=$data[4]");



}

$i++;
}
echo("done $i");

//update current lokasi kerjanya
/*mysqli_query($mysqli,"UPDATE  `mutasi_jabatan` m,
					jabatan j,
					current_lokasi_kerja c
					SET c.id_unit_kerja = j.id_unit_kerja WHERE m.id_j = j.id_j AND c.id_pegawai = m.id_pegawai");
					
	*/				
?>
