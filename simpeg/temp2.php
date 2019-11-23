<?

include("konek.php");

$q=mysql_query("select * from sk where id_sk>=216257 ");
$i=1;
while($data=mysql_fetch_array($q))
{

$q1=mysql_query("Select * from jabatan where id_j=$data[9]");
$gyt=mysql_fetch_array($q1);

$q3=mysql_query("Select pangkat_gol from pegawai where id_pegawai=$data[1]");
$gut=mysql_fetch_array($q3);

mysql_query("insert into riwayat_mutasi_kerja (id_pegawai,id_sk,id_unit_kerja,id_j,jabatan,pangkat_gol,jenjab,eselonering) values ($data[1],$data[0],$gyt[2],'$gyt[0]','$gyt[1]','$gut[0]','Struktural','$gyt[4]')");
//echo("insert into riwayat_mutasi_kerja (id_pegawai,id_sk,id_unit_kerja,id_j,jabatan,pangkat_gol,jenjab,eselonering) values ($data[1],$data[0],$gyt[2],'$gyt[0]','$gyt[1]','$gut[0]','Struktural','$gyt[4]')<br>");

	/*
mysql_query("insert into sk (id_pegawai,id_kategori_sk,no_sk,tgl_sk,pemberi_sk,pengesah_sk,tmt) values ($data[1],1,'$data[4]','$data[3]','$data[5]','$data[6]','$data[2]') ");
echo("insert into sk (id_pegawai,id_kategori_sk,no_sk,tgl_sk,pemberi_sk,pengesah_sk,tmt) values ($data[1],1,'$data[4]','$data[3]','$data[5]','$data[6]','$data[2]') <br> ");
$qo=mysql_query("select pangkat_gol from pegawai where id_pegawai=$data[1]");
$pg=mysql_fetch_array($qo);

$q2=mysql_query("select * from sk order by id_sk desc");
$coy=mysql_fetch_array($q2);
mysql_query("insert into riwayat_mutasi_kerja (id_pegawai,id_sk,id_unit_kerja,jabatan,pangkat_gol,jenjab) values ($data[1],$coy[0],$data[8],'Staf Pelaksana','$pg[0]' ,'Struktural')");
//echo("insert into riwayat_mutasi kerja (id_pegawai,id_sk,id_unit_kerja,jabatan,pangkat_gol,jenjab) values ($data[1],$coy[0],$data[8],'Staf Pelaksana','$pg[0]' ,'Struktural') <br>");
*/
$i++;
}
echo("$i rows affected");
?>