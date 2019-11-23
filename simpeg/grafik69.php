<?php



// generate some random data

srand((double)microtime()*1000000);



$data = array();

include("konek.php");

$qjum=mysqli_query($mysqli,"select count(*) from pegawai where flag_pensiun=0");

$jum=mysqli_fetch_array($qjum);



//sd

$qsd=mysqli_query($mysqli,"select count(*) from (select pegawai.id_pegawai,min(level_p) as p from pegawai inner join pendidikan on pegawai.id_pegawai = pendidikan.id_pegawai  where flag_pensiun=0 group by pegawai.id_pegawai) as tet where p=9 ");

$sd=mysqli_fetch_array($qsd);



$data[0]=round(($sd[0]/$jum[0])*100,2);





//smp

$qsmp=mysqli_query($mysqli,"select count(*) from (select pegawai.id_pegawai,min(level_p) as p from pegawai inner join pendidikan on pegawai.id_pegawai = pendidikan.id_pegawai  where flag_pensiun=0 group by pegawai.id_pegawai) as tet where p=8 ");

$smp=mysqli_fetch_array($qsmp);

$data[1]=round(($smp[0]/$jum[0])*100,2);



//sma

$qsma=mysqli_query($mysqli,"select count(*) from (select pegawai.id_pegawai,min(level_p) as p from pegawai inner join pendidikan on pegawai.id_pegawai = pendidikan.id_pegawai  where flag_pensiun=0 group by pegawai.id_pegawai) as tet where p=7 ");

$sma=mysqli_fetch_array($qsma);

$data[2]=round(($sma[0]/$jum[0])*100,2);



//d1

$qd1=mysqli_query($mysqli,"select count(*) from (select pegawai.id_pegawai,min(level_p) as p from pegawai inner join pendidikan on pegawai.id_pegawai = pendidikan.id_pegawai  where flag_pensiun=0 group by pegawai.id_pegawai) as tet where p=6 ");

$d1=mysqli_fetch_array($qd1);

$data[3]=round(($d1[0]/$jum[0])*100,2);



//d2

$qd2=mysqli_query($mysqli,"select count(*) from (select pegawai.id_pegawai,min(level_p) as p from pegawai inner join pendidikan on pegawai.id_pegawai = pendidikan.id_pegawai  where flag_pensiun=0 group by pegawai.id_pegawai) as tet where p=5 ");

$d2=mysqli_fetch_array($qd2);

$data[4]=round(($d2[0]/$jum[0])*100,2);



//d3

$qd3=mysqli_query($mysqli,"select count(*) from (select pegawai.id_pegawai,min(level_p) as p from pegawai inner join pendidikan on pegawai.id_pegawai = pendidikan.id_pegawai  where flag_pensiun=0 group by pegawai.id_pegawai) as tet where p=4 ");

$d3=mysqli_fetch_array($qd3);

$data[5]=round(($d3[0]/$jum[0])*100,2);



//s1

$qs1=mysqli_query($mysqli,"select count(*) from (select pegawai.id_pegawai,min(level_p) as p from pegawai inner join pendidikan on pegawai.id_pegawai = pendidikan.id_pegawai  where flag_pensiun=0 group by pegawai.id_pegawai) as tet where p=3 ");

$s1=mysqli_fetch_array($qs1);

$data[6]=round(($s1[0]/$jum[0])*100,2);



//s2

$qs2=mysqli_query($mysqli,"select count(*) from (select pegawai.id_pegawai,min(level_p) as p from pegawai inner join pendidikan on pegawai.id_pegawai = pendidikan.id_pegawai  where flag_pensiun=0 group by pegawai.id_pegawai) as tet where p=2 ");

$s2=mysqli_fetch_array($qs2);

$data[7]=round(($s2[0]/$jum[0])*100,2);



//s3

$qs3=mysqli_query($mysqli,"select count(*) from (select pegawai.id_pegawai,min(level_p) as p from pegawai inner join pendidikan on pegawai.id_pegawai = pendidikan.id_pegawai  where flag_pensiun=0 group by pegawai.id_pegawai) as tet where p=1 ");

$s3=mysqli_fetch_array($qs3);

$data[8]=round(($s3[0]/$jum[0])*100,2);



/*for( $i=0; $i<9; $i++ )

{

  $data->add_data_tip( rand(14,19), '(Extra: '.$i.')' );

  }

*/

include("./php-ofc-library/open-flash-chart.php" );

$g = new graph();



//

// PIE chart, 60% alpha

//

$g->pie(60,'#505050','{font-size: 12px; color: #404040;');

//

// pass in two arrays, one of data, the other data labels

//





$g->pie_values( $data, array("SD = $sd[0]","SMP = $smp[0]","SMA = $sma[0] ","D1 = $d1[0]","D2 = $d2[0]","D3  = $d3[0]","S1 = $s1[0]","S2 = $s2[0]","S3 = $s3[0]") );

//

// Colours for each slice, in this case some of the colours

// will be re-used (3 colurs for 5 slices means the last two

// slices will have colours colour[0] and colour[1]):

//

$g->pie_slice_colours( array('#d01f3c','#356aa0','#C79810') );



$g->set_tool_tip( '#val#% ' );

$g->set_num_decimals( 2 );

$g->set_is_fixed_num_decimals_forced( true );

$g->set_is_decimal_separator_comma( true );

$g->set_is_thousand_separator_disabled( true );  





$g->title( "Pemerintah Kota bogor ($jum[0] pegawai)", '{font-size:12px; color: #d01f3c}' );

echo $g->render();

?>