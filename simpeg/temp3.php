<?

include("konek.php");
$q=mysqli_query($mysqli,"select * from uptd");
$i=1;
while($data=mysqli_fetch_array($q))
{



$qcek=mysqli_query($mysqli,"select eselon,id_unit_kerja,jabatan,eselon from jabatan where id_j=$data[1] and Tahun=2011");


$plis=mysqli_fetch_array($qcek);
if($plis[0]=='IIB')
$sk='IIB Tahun 2011';
elseif($plis[0]=='IIIA')
$sk='IIIA Tahun 2011';
elseif($plis[0]=='IIIB')
$sk='IIIB 2011';
elseif($plis[0]=='IVA')
$sk='IVA 2011';
else
$sk='IVB 2011';


$qp=mysqli_query($mysqli,"select pangkat_gol from pegawai where id_pegawai=$data[2]");
$pg=mysqli_fetch_array($qp);

//echo("select pangkat_gol from pegawai where id_pegawai=$data[2]<br>");



mysqli_query($mysqli,"insert into sk (id_pegawai,id_kategori_sk,no_sk,tgl_sk,pemberi_sk,pengesah_sk,tmt,id_j) values ($data[2],10,'$sk','2011-04-08','Walikota Bogor','Walikota Bogor','2011-04-08',$data[1])");
//echo("insert into sk (id_pegawai,id_kategori_sk,no_sk,tgl_sk,pemberi_sk,pengesah_sk,tmt,id_j) values ($data[2],10,'$sk','2011-04-08','Walikota Bogor','Walikota Bogor','2011-04-08',$data[4])<br>");



$qambil=mysqli_query($mysqli,"select * from sk order by id_sk desc");
$ambil=mysqli_fetch_array($qambil);

mysqli_query($mysqli,"insert into riwayat_mutasi_kerja (id_pegawai,id_sk,id_unit_kerja,id_j,jabatan,pangkat_gol,jenjab,eselonering) values ($data[2],$ambil[0],$plis[1],$data[2],'$plis[3]','$pg[0]','Struktural','$plis[3]')");

$i++;
}
echo("$i rows affected");
?>