<?php
include("konek.php");
$qunit=mysqli_query($mysqli,"select id_skpd from unit_kerja where tahun=2017");
while($unit=mysqli_fetch_array($qunit))
{
$q=mysqli_query($mysqli,"select eselon from jabatan inner join unit_kerja on jabatan.id_unit_kerja=unit_kerja.id_unit_kerja where id_skpd=$unit[0] group by eselon order by eselon");

while($data=mysqli_fetch_array($q))
{
if($data[0]=='IIA' or $data[0]=='IIB')
{
$qmax=mysqli_query($mysqli,"select max(tpp) from jabatan   inner join unit_kerja on jabatan.id_unit_kerja=unit_kerja.id_unit_kerja where (eselon like 'IIA' or eselon like 'IIB') and jabatan.tahun=2017 and id_skpd=$unit[0]");
$max=mysqli_fetch_array($qmax);

$qmin=mysqli_query($mysqli,"select min(tpp) from jabatan  inner join unit_kerja on jabatan.id_unit_kerja=unit_kerja.id_unit_kerja  where (eselon like 'IIA' or eselon like 'IIB') and jabatan.tahun=2017 and id_skpd=$unit[0]");
$min=mysqli_fetch_array($qmin);

$selisih=$max[0]-$min[0];
$persen=$selisih/$min[0];
$qcek=mysqli_query($mysqli,"select count(*) from ipasn_kompensasi where id_unit_kerja=$unit[0] and eselon='II'");
$cek=mysqli_fetch_array($qcek);
if($cek[0]==0)
mysqli_query($mysqli,"insert into ipasn_kompensasi (id_unit_kerja,eselon,tertinggi,terendah,selisih,persentase) values ($unit[0],'II',$max[0],$min[0],$selisih,$persen)");


}
else if($data[0]=='IIIA' or $data[0]=='IIIB')
{
$qmax=mysqli_query($mysqli,"select max(tpp) from jabatan   inner join unit_kerja on jabatan.id_unit_kerja=unit_kerja.id_unit_kerja where (eselon like 'IIIA' or eselon like 'IIIB') and jabatan.tahun=2017 and id_skpd=$unit[0]");
$max=mysqli_fetch_array($qmax);

$qmin=mysqli_query($mysqli,"select min(tpp) from jabatan  inner join unit_kerja on jabatan.id_unit_kerja=unit_kerja.id_unit_kerja  where (eselon like 'IIIA' or eselon like 'IIIB') and jabatan.tahun=2017 and id_skpd=$unit[0]");
$min=mysqli_fetch_array($qmin);

$selisih=$max[0]-$min[0];
$persen=$selisih/$min[0];
$qcek=mysqli_query($mysqli,"select count(*) from ipasn_kompensasi where id_unit_kerja=$unit[0] and eselon='III'");
$cek=mysqli_fetch_array($qcek);
if($cek[0]==0)
mysqli_query($mysqli,"insert into ipasn_kompensasi (id_unit_kerja,eselon,tertinggi,terendah,selisih,persentase) values ($unit[0],'III',$max[0],$min[0],$selisih,$persen)");


}
else if($data[0]=='IVA' or $data[0]=='IVB')
{
$qmax=mysqli_query($mysqli,"select max(tpp) from jabatan   inner join unit_kerja on jabatan.id_unit_kerja=unit_kerja.id_unit_kerja where (eselon like 'IVA' or eselon like 'IVB') and jabatan.tahun=2017 and id_skpd=$unit[0]");
$max=mysqli_fetch_array($qmax);

$qmin=mysqli_query($mysqli,"select min(tpp) from jabatan  inner join unit_kerja on jabatan.id_unit_kerja=unit_kerja.id_unit_kerja  where (eselon like 'IVA' or eselon like 'IVB') and jabatan.tahun=2017 and id_skpd=$unit[0]");
$min=mysqli_fetch_array($qmin);

$selisih=$max[0]-$min[0];
$persen=$selisih/$min[0];
$qcek=mysqli_query($mysqli,"select count(*) from ipasn_kompensasi where id_unit_kerja=$unit[0] and eselon='IV'");
$cek=mysqli_fetch_array($qcek);
if($cek[0]==0)
mysqli_query($mysqli,"insert into ipasn_kompensasi (id_unit_kerja,eselon,tertinggi,terendah,selisih,persentase) values ($unit[0],'IV',$max[0],$min[0],$selisih,$persen)");


}


}




}
echo "done";
?>