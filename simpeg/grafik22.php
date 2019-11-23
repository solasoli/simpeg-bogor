<?php



$id=$_REQUEST['id'];



include("./php-ofc-library/open-flash-chart.php");

include("konek.php");



//$bar_1 = new bar( 50, '#0066CC' );

$bar_1 = new bar( 50, '#0066CC' );

//$bar_1->key( 'Sakit', 10 );



$bar_2 = new bar( 50, '#9933CC' );

//$bar_2->key( 'Ijin', 10 );



$bar_3 = new bar( 50, '#639F45' );

//$bar_3->key( 'Alpha', 10 );











				

				$result = mysqli_query($mysqli,"SELECT nama_baru,riwayat_mutasi_kerja.id_unit_kerja from riwayat_mutasi_kerja inner join unit_kerja on riwayat_mutasi_kerja.id_unit_kerja

				=unit_kerja.id_unit_kerja where id_pegawai=$id order by id_riwayat desc");

				$r = mysqli_fetch_array($result);

				$unit = $r[0];

				

				

				$result2 = mysqli_query($mysqli,"select count(*) as tes,pangkat_gol from (SELECT id_pegawai, id_unit_kerja, MAX(id_riwayat) FROM (SELECT id_pegawai,id_unit_kerja, id_riwayat FROM riwayat_mutasi_kerja

ORDER BY id_riwayat DESC) as x

GROUP BY id_pegawai order by id_pegawai) as y inner join pegawai on pegawai.id_pegawai=y.id_pegawai where id_unit_kerja=$r[1] group by pangkat_gol order by tes desc");

				$r2 = mysqli_fetch_array($result2);

				$jumlah = $r2[0];

				$akhir=substr($jumlah,-1,1);

				$kurang=10-$akhir;

				$pas=$jumlah+$kurang;

				

				



$g = new graph();

$g->title( "Sebaran Golongan Pegawai pada \n $unit", '{font-size: 12px;}' );







$qd=mysqli_query($mysqli,"select distinct(pangkat_gol) from pegawai where pangkat_gol <> '-' order by pangkat_gol ");

$is=0;

while($ye=mysqli_fetch_array($qd))

{

$lab[$is]=$ye[0];

$is++;

}







$qd2=mysqli_query($mysqli,"select distinct(pangkat_gol) from pegawai where pangkat_gol <> '-' order by pangkat_gol ");

$j=1;

while($yo=mysqli_fetch_array($qd2))

{

//$r=$j+1;









$qavg=mysqli_query($mysqli,"select count(*) from (SELECT id_pegawai, id_unit_kerja, MAX(id_riwayat) FROM (SELECT id_pegawai,id_unit_kerja, id_riwayat FROM riwayat_mutasi_kerja

ORDER BY id_riwayat DESC) as x

GROUP BY id_pegawai order by id_pegawai) as y inner join pegawai on pegawai.id_pegawai=y.id_pegawai where id_unit_kerja=$r[1] and pangkat_gol='$yo[0]' order by pangkat_gol");

$avg=mysqli_fetch_array($qavg);

$data0[$j]=$avg[0];

$j++;



  $bar_1->data[] = $avg[0];





}





// add the 3 bar charts to it:

$g->data_sets[] = $bar_1;





//





$g->set_x_labels( $lab );

// set the X axis to show every 2nd label:

$g->set_x_label_style( 10, '#9933CC', 1);

// and tick every second value:

$g->set_x_axis_steps( 1 );

//



$g->set_y_max( $pas);

$g->y_label_steps( 10 );

//$g->set_y_legend( "$s", 12, '0x736AFF' );

echo $g->render();

?>