<?php
include("konek.php");
$q=mysqli_query($mysqli,"select hukuman.id_pegawai,id_unit_kerja,tingkat_hukuman from hukuman inner join pegawai on pegawai.id_pegawai=hukuman.id_pegawai inner join current_lokasi_kerja on pegawai.id_pegawai=current_lokasi_kerja.id_pegawai inner join jenis_hukuman on jenis_hukuman.id_jenis_hukuman=hukuman.id_jenis_hukuman where id_j is not null and flag_pensiun=0 group by hukuman.
id_pegawai");
while($data=mysqli_fetch_array($q))
{



$qcek=mysqli_query($mysqli,"select count(*) from ipasn_hukuman where id_unit_kerja=$data[1]");
$cek=mysqli_fetch_array($qcek);

if($cek[0]==0)
{


$ringan=0;
$sedang=0;
$berat=0;

if($data[2]=='RINGAN')
$ringan=1;
else if($data[2]=='SEDANG')
$sedang=1;
else if($data[2]=='BERAT')
$berat=1;


mysqli_query($mysqli,"insert into ipasn_hukuman (id_unit_kerja,ringan,sedang,berat) values ($data[1],$ringan,$sedang,$berat)");

}
else
{

if($data[2]=='RINGAN')
{
mysqli_query($mysqli,"update ipasn_hukuman set ringan=ringan+1 where id_unit_kerja=$data[1]");
echo("update ipasn_hukuman set ringan=ringan+1 where id_unit_kerja=$data[1]");
}
else if($data[2]=='SEDANG')
mysqli_query($mysqli,"update ipasn_hukuman set sedang=sedang+1 where id_unit_kerja=$data[1]");
else if($data[2]=='BERAT')
mysqli_query($mysqli,"update ipasn_hukuman set berat=berat+1 where id_unit_kerja=$data[1]");

}
}
echo "done";

?>