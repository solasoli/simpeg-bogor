<?php

include("../koneksi.php");

$s = $_REQUEST['s'];

$id = $_REQUEST['id'];

$e = $_REQUEST['e'];

$thn=$_REQUEST['thn'];





$qc=mysqli_query($mysqli,"select bidangstudi from bidang_studi where id_bidang=$e");

$dw=mysqli_fetch_array($qc);

$k=$dw[0];





$q0 =mysqli_query($mysqli,"select siswa.id_siswa,bidangstudi,left(nilai1,5),left(nilai2,5),left(nilai3,5),left(nilai4,5),nama_siswa from ulangan_harian inner join siswa on ulangan_harian.id_siswa = siswa.id_siswa inner join bidang_studi on ulangan_harian.id_bidang = bidang_studi.id_bidang inner join kelas on ulangan_harian.id_kelas = kelas.id_kelas where siswa.id_siswa=$id and bidang_studi.id_bidang =$e and kelas.tahun_ajaran = '$thn' group by bidangstudi");

$ba=mysqli_fetch_array($q0);



$qk = mysqli_query($mysqli,"select kelas_murid.id_kelas,tingkat from kelas_murid inner join kelas on kelas_murid.id_kelas=kelas.id_kelas where id_siswa = $id and kelas.tahun_ajaran='$thn'");

$ke = mysqli_fetch_array($qk);

$qr = mysqli_query($mysqli,"select bidangstudi,left(nilai1,5),left(nilai2,5),left(nilai3,5),left(nilai4,5),kelas from ulangan_harian inner join bidang_studi on ulangan_harian.id_bidang = bidang_studi.id_bidang inner join kelas on ulangan_harian.id_kelas=kelas.id_kelas where bidang_studi.id_bidang =$e and ulangan_harian.id_kelas =$ke[0] and kelas.tahun_ajaran='$thn' group by bidangstudi");

$bb = mysqli_fetch_array($qr);

$qs = mysqli_query($mysqli,"SELECT bidangstudi, left( (avg( nilai1 ) ) , 5), left( (avg( nilai2 ) ) , 5), left( (avg( nilai3 ) ) , 5), left( (avg( nilai4 ) ) , 5) FROM ulangan_harian INNER JOIN bidang_studi ON ulangan_harian.id_bidang = bidang_studi.id_bidang INNER JOIN kelas ON ulangan_harian.id_kelas = kelas.id_kelas WHERE bidang_studi.id_bidang =$e AND kelas.tingkat = '$ke[1]' AND kelas.tahun_ajaran = '$thn' GROUP BY bidangstudi");

$bc = mysqli_fetch_array($qs);





// generate some random data

srand((double)microtime()*1000000);



//

// NOTE: how we are filling 3 arrays full of data,

//       one for each line on the graph

//



$data_1 = array($ba[2], $ba[3], $ba[4], $ba[5]);

$data_2 = array($bb[1], $bb[2], $bb[3], $bb[4]);

$data_3 = array($bc[1], $bc[2], $bc[3], $bc[4]);

/*

$data_1 = array();

$data_2 = array();

$data_3 = array();

for( $i=0; $i<4; $i++ )

{

  $data_1[] = rand(8,20);

  $data_2[] = rand(8,13);

  $data_3[] = rand(1,7);

}

*/

include("../php-ofc-library/open-flash-chart.php" );

$g = new graph();

$g->title( "grafik nilai ulangan harian $k", '{font-size: 10px; color: #736AFF}' );



// we add 3 sets of data:

$g->set_data( $data_1 );

$g->set_data( $data_2 );

$g->set_data( $data_3 );



// we add the 3 line types and key labels

$g->line_hollow( 2,4, '0x9933CC', 'nilai siswa', 10 );

$g->line_dot( 3, 5, '0xCC3399', 'rata-rata kelas', 10);    // <-- 3px thick + dots

$g->line_hollow( 2, 4, '0x80a033', 'rata-rata tingkat', 10 );



$g->set_x_labels( array( "Ulangan Harian I", "Ulangan Harian II", "Ulangan Harian III", "Ulangan Harian IV") );

$g->set_x_label_style( 10, '0x000000', 0, 1 );



$g->set_y_max( 10 );

$g->y_label_steps( 4 );

//$g->set_y_legend( 'Open Flash Chart', 4, '#736AFF' );

echo $g->render();

?>