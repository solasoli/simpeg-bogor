<?php
/*
$mysqli = new mysqli("simpeg.db.kotabogor.net","simpeg","Madangkara2017","simpeg");
$bulan=date("n")-1;
$tahun=date("Y");

$sql = "select a.*, uk.nama_baru from
(select p.id_pegawai, p.nama, p.nip_baru, oal.id_pegawai as oal_id_pegawai
from pegawai p
left join  oasys_attendance_log oal on p.id_pegawai = oal.id_pegawai and oal.date_time like '2019-05-06%'
where p.flag_pensiun = 0 and oal.id_pegawai is null) a
inner join current_lokasi_kerja clk on clk.id_pegawai = a.id_pegawai
inner join unit_kerja uk on uk.id_unit_kerja = clk.id_unit_kerja
where uk.id_skpd not in ('4785', )";

$q=mysqli_query($mysqli,$sql);

while($data=mysqli_fetch_array($q))
{

  echo $data['id_pegawai']." - ".$data['nama']." - ".$data['nama_baru']."</br>";

}


mysqli_close($mysqli);
*/

$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$start = $time;

//include("konek.php");
$mysqli = new mysqli("simpeg.db.kotabogor.net","simpeg","Madangkara2017","simpeg");

$bulan=date("n")-1;
$tahun=date("Y");
echo "mengambil data knj_master...</br>\n";
$id_pegawai = $_GET['id_pegawai'];
$q=mysqli_query($mysqli,"select id_pegawai_pelapor, id_knj_master from knj_kinerja_master
inner join current_lokasi_kerja clk on clk.id_pegawai = knj_kinerja_master.id_pegawai_pelapor
inner join unit_kerja uk on uk.id_unit_kerja = clk.id_unit_kerja and clk.id_unit_kerja = 4818
where periode_bln = 4");
//$q=mysqli_query($mysqli,"select id_pegawai_pelapor,id_knj_master from knj_kinerja_master where periode_bln = $bulan and id_pegawai_pelapor in (".$id_pegawai.")");

echo "Mulai menghitung ...</br>\n";
$x=1;
while($data=mysqli_fetch_array($q))
{
  echo $x++.".";
  $kehadiran = mysqli_query($mysqli,"CALL PRCD_KINERJA_ABSENSI_KEHADIRAN($data[0],$bulan,$tahun) ");

   if(!$kehadiran){

      $sql = "insert into knj_kalkulasi_log (id_pegawai_pelapor, id_knj_master, keterangan) VALUES(".$data['id_pegawai_pelapor'].",".$data['id_knj_master'].", 'GAGAL KALKULASI KEHADIRAN')";
      mysqli_query($mysqli, $sql);
   }else{
     echo "kalkulasi kehadiran id_pegawai = ".$data['id_pegawai_pelapor']." selesai </br>\n";
   }

   $kalkulasi = mysqli_query($mysqli,"CALL PRCD_KINERJA_KALKULASI_NILAI_TUNJANGAN($data[0], $bulan, $tahun, $data[1]); ");
   if(!$kehadiran || !$kalkulasi){
      $sql = "insert into knj_kalkulasi_log (id_pegawai_pelapor, id_knj_master) VALUES(".$data['id_pegawai_pelapor'].",".$data['id_knj_master'].", 'GAGAL KALKULASI KINERJA')";
      mysqli_query($mysqli, $sql);
   }else{
     echo "kalkulasi kinerja id_pegawai = ".$data['id_pegawai_pelapor']." selesai </br>\n";
   }
   echo ">>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>></br>\n";

}

echo "Selesai menghitung</br>\n";
$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$finish = $time;
$total_time = round(($finish - $start), 4);
echo 'Page generated in '.$total_time.' seconds.';
?>
