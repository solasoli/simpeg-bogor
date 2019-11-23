<?

include("konek.php");
$q=mysqli_query($mysqli,"select nama,pegawai.id_pegawai as id_pegawai,nip_lama,nip_baru,tgl_lahir,jenis_kelamin,pegawai.pangkat_gol from pegawai inner join riwayat_mutasi_kerja on pegawai.id_pegawai=riwayat_mutasi_kerja.id_pegawai inner join unit_kerja on riwayat_mutasi_kerja.id_unit_kerja=unit_kerja.id_unit_kerja where status_aktif not like '%pensiun%' and flag_pensiun=0 and pegawai.id_j=0 and  (nama_baru like 'kelurahan%') group by id_pegawai,nip_lama,nip_baru  order by nama");
while($data=mysqli_fetch_array($q))
{
	
	$qp=mysqli_query($mysqli,"select min(level_p) from pendidikan where id_pegawai=$data[1]");
	$p=mysqli_fetch_array($qp);
	if($data[1]==1408)
	echo("select max(level_p) from pendidikan where id_pegawai=$data[1]");
	$qtampil=mysqli_query($mysqli,"Select tingkat_pendidikan from pendidikan where id_pegawai=$data[1] and level_p=$p[0]");
	
	$tampil=mysqli_fetch_array($qtampil);
	echo("$data[0] $tampil[0]<br>");
}

?>