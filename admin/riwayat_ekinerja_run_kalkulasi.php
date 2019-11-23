<?php
$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$start = $time;

//include("konek.php");
$mysqli = new mysqli("simpeg.db.kotabogor.net","simpeg","Madangkara2017","simpeg");

$bulan=$_POST['bulan'];
$tahun=$_POST['tahun'];
$id_pegawai = $_POST['id_pegawai'];

$q=mysqli_query($mysqli,"select id_pegawai_pelapor,id_knj_master from knj_kinerja_master where periode_bln = $bulan and id_pegawai_pelapor in (".$id_pegawai.")");

while($data=mysqli_fetch_array($q))
{

  $kehadiran = mysqli_query($mysqli,"CALL PRCD_KINERJA_ABSENSI_KEHADIRAN_MDX($data[0],$bulan,$tahun,0) ");


   $kalkulasi = mysqli_query($mysqli,"CALL PRCD_KINERJA_KALKULASI_NILAI_TUNJANGAN($data[0], $bulan, $tahun, $data[1]); ");
   if(!$kehadiran || !$kalkulasi){
      echo "CALCULATION_FAILED";
   }else{
     echo "CALCULATION_SUCCESS";
   }

}

?>
