<?php

// generate some random data
srand((double)microtime()*1000000);
$idu=$_REQUEST['idu'];

$data = array();
include("konek.php");


$thn=date("Y");				
	

if($idu==NULL)
{$var=">0";

}
else
{
$var="=$idu";
	
}

$qjum=mysqli_query($mysqli," SELECT count(*),id_skpd FROM current_lokasi_kerja inner join pegawai on pegawai.id_pegawai=current_lokasi_kerja.id_pegawai inner join unit_kerja on unit_kerja.id_unit_kerja=current_lokasi_kerja=id_unit_kerja where flag_pensiun=0 and id_skpd $var group by id_skpd ");
$jum=mysqli_fetch_array($qjum);



//IV/d
$qsd=mysqli_query($mysqli,"
 SELECT count(*),id_skpd FROM current_lokasi_kerja inner join pegawai on pegawai.id_pegawai=current_lokasi_kerja.id_pegawai inner join unit_kerja on unit_kerja.id_unit_kerja=current_lokasi_kerja=id_unit_kerja where flag_pensiun=0 and pangkat_gol='IV/d' and id_skpd $var group by id_skpd ");
$smp=mysqli_fetch_array($qsmp);
$data[1]=round(($smp[0]/$jum[0])*100,2);
if($data[1]==0)
$data[1]=0.001;

//sma
$qsma=mysqli_query($mysqli," select sum(jum) from (SELECT  COUNT(*) as jum, c.id_unit_kerja,pd.min_level_p
FROM current_lokasi_kerja c
INNER JOIN 
(
    SELECT pd.id_pegawai, MIN(pd.level_p) AS 'min_level_p'
    FROM pendidikan pd
    GROUP BY pd.id_pegawai
) AS pd ON pd.id_pegawai = c.id_pegawai 
INNER JOIN unit_kerja u ON u.id_unit_kerja = c.id_unit_kerja
WHERE pd.min_level_p = 7
    AND u.id_skpd $var
GROUP BY c.id_unit_kerja) as sma");
$sma=mysqli_fetch_array($qsma);
$data[2]=round(($sma[0]/$jum[0])*100,2);
if($data[2]==0)
$data[2]=0.001;



//d1
$qd1=mysqli_query($mysqli," select sum(jum) from (SELECT  COUNT(*) as jum,c.id_unit_kerja, pd.min_level_p
FROM current_lokasi_kerja c
INNER JOIN 
(
    SELECT pd.id_pegawai, MIN(pd.level_p) AS 'min_level_p'
    FROM pendidikan pd
    GROUP BY pd.id_pegawai
) AS pd ON pd.id_pegawai = c.id_pegawai 
INNER JOIN unit_kerja u ON u.id_unit_kerja = c.id_unit_kerja
WHERE pd.min_level_p = 6
    AND u.id_skpd $var
GROUP BY c.id_unit_kerja) as d1 ");
$d1=mysqli_fetch_array($qd1);
$data[3]=round(($d1[0]/$jum[0])*100,2);
if($data[3]==0)
$data[3]=0.001;


//d2
$qd2=mysqli_query($mysqli," select sum(jum) from (SELECT  COUNT(*) as jum,c.id_unit_kerja, pd.min_level_p
FROM current_lokasi_kerja c
INNER JOIN 
(
    SELECT pd.id_pegawai, MIN(pd.level_p) AS 'min_level_p'
    FROM pendidikan pd
    GROUP BY pd.id_pegawai
) AS pd ON pd.id_pegawai = c.id_pegawai 
INNER JOIN unit_kerja u ON u.id_unit_kerja = c.id_unit_kerja
WHERE pd.min_level_p = 5
    AND u.id_skpd $var
GROUP BY c.id_unit_kerja) as d2");
$d2=mysqli_fetch_array($qd2);
$data[4]=round(($d2[0]/$jum[0])*100,2);
if($data[4]==0)
$data[4]=0.001;


//d3
$qd3=mysqli_query($mysqli," select sum(jum) from ( SELECT  COUNT(*) as jum,c.id_unit_kerja, pd.min_level_p
FROM current_lokasi_kerja c
INNER JOIN 
(
    SELECT pd.id_pegawai, MIN(pd.level_p) AS 'min_level_p'
    FROM pendidikan pd
    GROUP BY pd.id_pegawai
) AS pd ON pd.id_pegawai = c.id_pegawai 
INNER JOIN unit_kerja u ON u.id_unit_kerja = c.id_unit_kerja
WHERE pd.min_level_p = 4
    AND u.id_skpd $var
GROUP BY c.id_unit_kerja) as d3 ");
$d3=mysqli_fetch_array($qd3);
$data[5]=round(($d3[0]/$jum[0])*100,2);
if($data[5]==0)
$data[5]=0.001;


//s1
$qs1=mysqli_query($mysqli," select sum(jum) from ( SELECT COUNT(*) as jum,c.id_unit_kerja,  pd.min_level_p
FROM current_lokasi_kerja c
INNER JOIN 
(
    SELECT pd.id_pegawai, MIN(pd.level_p) AS 'min_level_p'
    FROM pendidikan pd
    GROUP BY pd.id_pegawai
) AS pd ON pd.id_pegawai = c.id_pegawai 
INNER JOIN unit_kerja u ON u.id_unit_kerja = c.id_unit_kerja
WHERE pd.min_level_p = 3
    AND u.id_skpd $var
GROUP BY c.id_unit_kerja) as s1 ");
$s1=mysqli_fetch_array($qs1);
$data[6]=round(($s1[0]/$jum[0])*100,2);
if($data[6]==0)
$data[6]=0.001;


//s2
$qs2=mysqli_query($mysqli," select sum(jum) from ( SELECT COUNT(*) as jum,c.id_unit_kerja,  pd.min_level_p
FROM current_lokasi_kerja c
INNER JOIN 
(
    SELECT pd.id_pegawai, MIN(pd.level_p) AS 'min_level_p'
    FROM pendidikan pd
    GROUP BY pd.id_pegawai
) AS pd ON pd.id_pegawai = c.id_pegawai 
INNER JOIN unit_kerja u ON u.id_unit_kerja = c.id_unit_kerja
WHERE pd.min_level_p = 2
    AND u.id_skpd $var
GROUP BY c.id_unit_kerja) as s2 ");
$s2=mysqli_fetch_array($qs2);
$data[7]=round(($s2[0]/$jum[0])*100,2);
if($data[7]==0)
$data[7]=0.001;


//s3
$qs3=mysqli_query($mysqli," select sum(jum) from ( SELECT COUNT(*) as jum,c.id_unit_kerja,  pd.min_level_p
FROM current_lokasi_kerja c
INNER JOIN 
(
    SELECT pd.id_pegawai, MIN(pd.level_p) AS 'min_level_p'
    FROM pendidikan pd
    GROUP BY pd.id_pegawai
) AS pd ON pd.id_pegawai = c.id_pegawai 
INNER JOIN unit_kerja u ON u.id_unit_kerja = c.id_unit_kerja
WHERE pd.min_level_p = 1
    AND u.id_skpd $var
GROUP BY c.id_unit_kerja) as s3 ");
$s3=mysqli_fetch_array($qs3);
$data[8]=round(($s3[0]/$jum[0])*100,2);
if($data[8]==0)
$data[8]=0.001;


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


$g->title( "$show \n ($jum[0] pegawai)", '{font-size:12px; color: #d01f3c}' );
echo $g->render();
?>