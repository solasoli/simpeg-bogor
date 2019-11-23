<?
include("konek.php");
$q=mysqli_query($mysqli,"select * from alih ");
while($data=mysqli_fetch_array($q))
{
$qn=mysqli_query($mysqli,"select count(*) from  alih where id_pegawai=$data[1]");
$n=mysqli_fetch_array($qn);
$qa=mysqli_query($mysqli,"Select count(*) from sk where id_pegawai=$data[1] and id_kategori_sk=1 and tmt='2011-01-01'");
$a=mysqli_fetch_array($qa);

if($n[0]==1 and $a[0]==0)
{
	//cekk yg udah adadi tabel sk
	/*$qp=mysqli_query($mysqli,"select nama from pegawai where id_pegawai=$data[1]");
$p=mysqli_fetch_array($qp);
	echo("$p[0] sudah ada di sk<br>");*/
	
$qp=mysqli_query($mysqli,"select pangkat_gol from pegawai where id_pegawai=$data[1]");
$p=mysqli_fetch_array($qp);
	
	
mysqli_query($mysqli,"insert into sk (id_pegawai,id_kategori_sk,no_sk,tgl_sk,pemberi_sk,pengesah_sk,keterangan,tmt) values ($data[1],1,'$data[4]','2010-12-27','Walikota Bogor','Dra. Hj. Fetty Qondarsyah,M.Si','$p[0]','2011-01-01')");
	
	$qw=mysqli_query($mysqli,"select id_sk from sk where id_kategori_sk=1 order by id_sk desc");
	$w=mysqli_fetch_array($qw);
	
	mysqli_query($mysqli,"insert into riwayat_mutasi_kerja (id_pegawai,sk,id_unit_kerja,jabatan,pangkat_gol,jenjab) values ($data[1],$w[0],$data[8],'Staf Pelaksana','$p[0]','Struktural') ");
	
mysqli_query($mysqli,"update alih set flag=1 where id_pegawai=$data[1]");

}

	
}
echo("done!");
?>