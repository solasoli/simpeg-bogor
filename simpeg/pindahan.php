<?php

include("konek.php");
$q=mysqli_query($mysqli,"select * from mutasi_jabatan where status is NULL");
$i=0;
while($data=mysqli_fetch_array($q))
{
//echo $i+1;
//echo ("<br>");
$qcek=mysqli_query($mysqli,"select id_j from pegawai where id_pegawai=$data[id_pegawai]");
$cek=mysqli_fetch_array($qcek);

if($cek[0]!=$data['id_j'])
{
$q1=mysqli_query($mysqli,"select jabatan,eselon,id_unit_kerja from jabatan where id_j=$data[id_j]");
$q2=mysqli_query($mysqli,"select pangkat_gol from pegawai where id_pegawai=$data[id_pegawai]");
//echo("select pangkat_gol from pegawai where id_pegawai=$data[1]<br>");
$ata=mysqli_fetch_array($q1);
$ta=mysqli_fetch_array($q2);

/*
if($ata[1]=='IIB')
$sk='';
elseif($ata[1]=='IIIA')
$sk='821.45 - 11 Tahun 2018';
elseif($ata[1]=='IIIB')
$sk="821.45 - 11 Tahun 2018";
elseif($ata[1]=='IVA')
$sk="821.45 - 12 Tahun 2018";
elseif($ata[1]=='IVB')
$sk="";
*/
//elseif($ata[1]=='V')
$sk='821.45 - 445 Tahun 2019';

$tanggal_sk = '2019-10-28';

//$sk = "821.45 - 75 Tahun 2017";
mysqli_query($mysqli,"insert into sk (id_pegawai,id_kategori_sk,no_sk,tgl_sk,pemberi_sk,pengesah_sk,keterangan,tmt,id_j) values ($data[id_pegawai],10,'$sk','$tanggal_sk','Walikota Bogor','Bima Arya','$ta[0]','$tanggal_sk',$data[id_j])");
//echo("insert into sk (id_pegawai,id_kategori_sk,no_sk,tgl_sk,pemberi_sk,pengesah_sk,keterangan,tmt,id_j) values ($data[id_pegawai],10,'$sk','$tanggal_sk','Walikota Bogor','Bima Arya','$ta[0]','$tanggal_sk',$data[id_j])<br>");

$q4=mysqli_query($mysqli,"select * from sk order by id_sk desc");
$a=mysqli_fetch_array($q4);

mysqli_query($mysqli,"insert into riwayat_mutasi_kerja (id_pegawai,id_sk,id_unit_kerja,id_j,jabatan,pangkat_gol,jenjab,eselonering) values ($data[id_pegawai],$a[0],$ata[2],$data[id_j],'$ata[0]','$ta[0]','Struktural','$ata[1]')");
//echo("insert into riwayat_mutasi_kerja (id_pegawai,id_sk,id_unit_kerja,id_j,jabatan,pangkat_gol,jenjab,eselonering) values ($data[id_pegawai],$a[0],$ata[2],$data[id_j],'$ata[0]','$ta[0]','Struktural','$ata[1]')<br>");
mysqli_query($mysqli,"update current_lokasi_kerja set id_unit_kerja=$ata[2] where id_pegawai=$data[id_pegawai]");
//echo("update current_lokasi_kerja set id_unit_kerja=$ata[2] where id_pegawai=$data[id_pegawai]<br>");

$null_kan = ("update pegawai set id_j = NULL, jabatan = 'KOSONG' where id_j=$data[id_j]");

if(mysqli_query($mysqli,$null_kan)){
	echo $null_kan." Berhasil"."\n";
}else{

	echo "id j tidak bisa kosong ->id_j :".$data['id_j']."\n";
	exit;
}


if($berhasil = mysqli_query($mysqli,"update pegawai set id_j=$data[id_j],jabatan='$ata[0]' where id_pegawai=".$data['id_pegawai'])){
	mysqli_query($mysqli,"update mutasi_jabatan set status = 'DONE' where id_pegawai = ".$data['id_pegawai']);
}
//echo("update pegawai set id_j=$data[id_j],jabatan='$ata[0]' where id_pegawai=$data[id_pegawai]<br>");

$i++;

}
}
echo("done $i");

//update current lokasi kerjanya
/*mysqli_query($mysqli,"UPDATE  `mutasi_jabatan` m,
					jabatan j,
					current_lokasi_kerja c
					SET c.id_unit_kerja = j.id_unit_kerja WHERE m.id_j = j.id_j AND c.id_pegawai = m.id_pegawai");

	*/
