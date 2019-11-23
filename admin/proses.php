<?php 
include("koncil.php");
extract($_GET);
$k=mysql_query("select TRIM(IF(LENGTH(p.gelar_belakang) > 1,
        CONCAT(p.gelar_depan,
                ' ',
                p.nama,
                CONCAT(', ', p.gelar_belakang)),
        CONCAT(p.gelar_depan, ' ', p.nama))) AS nama,nip_baru,pangkat_gol,jabatan,nama_baru,pegawai.id_pegawai from pegawai inner join current_lokasi_kerja on current_lokasi_kerja.id_pegawai=pegawai.id_pegawai inner join unit_kerja on unit_kerja.id_unit_kerja=current_lokasi_kerja.id_unit_kerja where flag_pensiun=0 and nama like '%$q%' and  unit_kerja.id_skpd=$skpd");
while($ata=mysql_fetch_array($k))
{
	
$qsk=mysql_query("select max(tmt) from sk where id_pegawai=$ata[5] and id_kategori_sk=5  ");
$sk=mysql_fetch_array($qsk);
$t1=substr($sk[0],8,2);
$b1=substr($sk[0],5,2);
$th1=substr($sk[0],0,4);

$qp=mysql_query("select * from pendidikan where id_pegawai=$ata[5] order by level_p");
$pen=mysql_fetch_array($qp);
	
$data[] = array(
'label' => $ata[0], 
'value' =>$ata[0],
'nama' => $ata[0],
'nip' => $ata[1],
'pg' => $ata[2],
'jab' => $ata[3],
'opd' => $ata[4],
'tmt' => "$t1-$b1-$th1",
'pen' => $pen[3],
'jur' => $pen[4],
'idp' => $ata[5],
'ip' => $pen[2]

);

}
echo json_encode($data);
?>

