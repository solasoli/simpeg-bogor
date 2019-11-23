<?php



$id=$_REQUEST['id'];



include("./php-ofc-library/open-flash-chart.php");

include("konek.php");





$ke3 = mysqli_fetch_array($cari);

$ke = $ke3[0];





$bar_1 = new bar( 50, '#0066CC' );

//$bar_1->key( 'Sakit', 10 );



$bar_2 = new bar( 50, '#9933CC' );

//$bar_2->key( 'Ijin', 10 );



$bar_3 = new bar( 50, '#639F45' );

//$bar_3->key( 'Alpha', 10 );



$sql = "SELECT nama_baru,riwayat_mutasi_kerja.id_unit_kerja from riwayat_mutasi_kerja inner join unit_kerja on riwayat_mutasi_kerja.id_unit_kerja

				=unit_kerja.id_unit_kerja where id_pegawai=$id order by id_riwayat desc";

				

				$result = mysqli_query($mysqli,$sql);

				$r = mysqli_fetch_array($result);

				$unit = $r[0];



	$result2 = mysqli_query($mysqli,"select count(*) from (SELECT id_pegawai, id_unit_kerja, MAX(id_riwayat) FROM (SELECT id_pegawai,id_unit_kerja, id_riwayat FROM riwayat_mutasi_kerja

ORDER BY id_riwayat DESC) as x

GROUP BY id_pegawai order by id_pegawai) as y inner join pegawai on pegawai.id_pegawai=y.id_pegawai where id_unit_kerja=$r[1] and jabatan like 'ka%'");

				$r2 = mysqli_fetch_array($result2);

				$jumlah = $r2[0];

				$akhir=substr($jumlah,-1,1);

				$kurang=10-$akhir;

				$pas=$jumlah+$kurang;





$g = new graph();

$g->title( "Sebaran Pejabat pada \n $unit", '{font-size: 12px;}' );







for($is=0;$is<=15;$is++)

{

$is++;





$k0=mysqli_query($mysqli,"select count(*) from (SELECT id_pegawai, id_unit_kerja, MAX(id_riwayat) FROM (SELECT id_pegawai,id_unit_kerja, id_riwayat FROM riwayat_mutasi_kerja

ORDER BY id_riwayat DESC) as x

GROUP BY id_pegawai order by id_pegawai) as y inner join pegawai on pegawai.id_pegawai=y.id_pegawai where id_unit_kerja=$r[1] and jabatan like '%sekda%'");

$qk0=mysqli_fetch_array($k0);



if($qk0[0]>0)

{

$lab[$is]='Sekretaris Derah';

$is++;

}

//else

//$is--;



$k00=mysqli_query($mysqli,"select count(*) from (SELECT id_pegawai, id_unit_kerja, MAX(id_riwayat) FROM (SELECT id_pegawai,id_unit_kerja, id_riwayat FROM riwayat_mutasi_kerja

ORDER BY id_riwayat DESC) as x

GROUP BY id_pegawai order by id_pegawai) as y inner join pegawai on pegawai.id_pegawai=y.id_pegawai where id_unit_kerja=$r[1] and jabatan like '%asisten%' and jabatan not like '%apoteker%'");

$qk00=mysqli_fetch_array($k00);



if($qk00[0]>0)

{

$lab[$is]='Asisten';

$is++;

}

//else

//$is--;



$k1=mysqli_query($mysqli,"select count(*) from (SELECT id_pegawai, id_unit_kerja, MAX(id_riwayat) FROM (SELECT id_pegawai,id_unit_kerja, id_riwayat FROM riwayat_mutasi_kerja

ORDER BY id_riwayat DESC) as x

GROUP BY id_pegawai order by id_pegawai) as y inner join pegawai on pegawai.id_pegawai=y.id_pegawai where id_unit_kerja=$r[1] and jabatan like '%kepala dinas%'");

$qk1=mysqli_fetch_array($k1);



if($qk1[0]>0)

{

$lab[$is]='Kepala Dinas';

$is++;

}

//else

//$is--;



$k2=mysqli_query($mysqli,"select count(*) from (SELECT id_pegawai, id_unit_kerja, MAX(id_riwayat) FROM (SELECT id_pegawai,id_unit_kerja, id_riwayat FROM riwayat_mutasi_kerja

ORDER BY id_riwayat DESC) as x

GROUP BY id_pegawai order by id_pegawai) as y inner join pegawai on pegawai.id_pegawai=y.id_pegawai where id_unit_kerja=$r[1] and jabatan like '%kepala badan%' ");

$qk2=mysqli_fetch_array($k2);



if($qk2[0]>0)

{

$lab[$is]='Kepala Badan';

$is++;

}

//else

//$is--;





$k3=mysqli_query($mysqli,"select count(*) from (SELECT id_pegawai, id_unit_kerja, MAX(id_riwayat) FROM (SELECT id_pegawai,id_unit_kerja, id_riwayat FROM riwayat_mutasi_kerja

ORDER BY id_riwayat DESC) as x

GROUP BY id_pegawai order by id_pegawai) as y inner join pegawai on pegawai.id_pegawai=y.id_pegawai where id_unit_kerja=$r[1] and jabatan like '%Sekretaris pada badan%'");

$qk3=mysqli_fetch_array($k3);



if($qk3[0]>0)

{

$lab[$is]='Sekretaris Badan';

$is++;

}

//else

//$is--;





$k4=mysqli_query($mysqli,"select count(*) from (SELECT id_pegawai, id_unit_kerja, MAX(id_riwayat) FROM (SELECT id_pegawai,id_unit_kerja, id_riwayat FROM riwayat_mutasi_kerja

ORDER BY id_riwayat DESC) as x

GROUP BY id_pegawai order by id_pegawai) as y inner join pegawai on pegawai.id_pegawai=y.id_pegawai where id_unit_kerja=$r[1] and jabatan like '%Sekretaris%' and jabatan like '%dinas%'");

$qk4=mysqli_fetch_array($k4);



if($qk4[0]>0)

{

$lab[$is]='Sekretaris Dinas';

$is++;

}

//else

//$is--;





$k400=mysqli_query($mysqli,"select count(*) from (SELECT id_pegawai, id_unit_kerja, MAX(id_riwayat) FROM (SELECT id_pegawai,id_unit_kerja, id_riwayat FROM riwayat_mutasi_kerja

ORDER BY id_riwayat DESC) as x

GROUP BY id_pegawai order by id_pegawai) as y inner join pegawai on pegawai.id_pegawai=y.id_pegawai where id_unit_kerja=$r[1] and jabatan like '%kepala kantor%'");

$qk400=mysqli_fetch_array($k400);



if($qk400[0]>0)

{

$lab[$is]='Kepala Kantor';

$is++;

}

//else

//$is--;





$k40=mysqli_query($mysqli,"select count(*) from (SELECT id_pegawai, id_unit_kerja, MAX(id_riwayat) FROM (SELECT id_pegawai,id_unit_kerja, id_riwayat FROM riwayat_mutasi_kerja

ORDER BY id_riwayat DESC) as x

GROUP BY id_pegawai order by id_pegawai) as y inner join pegawai on pegawai.id_pegawai=y.id_pegawai where id_unit_kerja=$r[1] and jabatan like 'camat%'");

$qk40=mysqli_fetch_array($k40);



if($qk40[0]>0)

{

$lab[$is]='Camat';

$is++;

}

//else

//$is--;



$k6=mysqli_query($mysqli,"select count(*) from (SELECT id_pegawai, id_unit_kerja, MAX(id_riwayat) FROM (SELECT id_pegawai,id_unit_kerja, id_riwayat FROM riwayat_mutasi_kerja

ORDER BY id_riwayat DESC) as x

GROUP BY id_pegawai order by id_pegawai) as y inner join pegawai on pegawai.id_pegawai=y.id_pegawai where id_unit_kerja=$r[1] and jabatan like '%kepala bagian%'");

$qk6=mysqli_fetch_array($k6);



if($qk6[0]>0)

{

$lab[$is]='Kepala Bagian';

$is++;

}







$k5=mysqli_query($mysqli,"select count(*) from (SELECT id_pegawai, id_unit_kerja, MAX(id_riwayat) FROM (SELECT id_pegawai,id_unit_kerja, id_riwayat FROM riwayat_mutasi_kerja

ORDER BY id_riwayat DESC) as x

GROUP BY id_pegawai order by id_pegawai) as y inner join pegawai on pegawai.id_pegawai=y.id_pegawai where id_unit_kerja=$r[1] and jabatan like '%kepala bidang%'");

$qk5=mysqli_fetch_array($k5);



if($qk5[0]>0)

{

$lab[$is]='Kepala Bidang';

$is++;

}

//else

//$is--;









$k7=mysqli_query($mysqli,"select count(*) from (SELECT id_pegawai, id_unit_kerja, MAX(id_riwayat) FROM (SELECT id_pegawai,id_unit_kerja, id_riwayat FROM riwayat_mutasi_kerja

ORDER BY id_riwayat DESC) as x

GROUP BY id_pegawai order by id_pegawai) as y inner join pegawai on pegawai.id_pegawai=y.id_pegawai where id_unit_kerja=$r[1] and jabatan like '%kasubid%'");

$qk7=mysqli_fetch_array($k7);



if($qk7[0]>0)

{

$lab[$is]="Kepala Sub Bidang ";

$is++;

}

//else

//$is--;



$k8=mysqli_query($mysqli,"select count(*) from (SELECT id_pegawai, id_unit_kerja, MAX(id_riwayat) FROM (SELECT id_pegawai,id_unit_kerja, id_riwayat FROM riwayat_mutasi_kerja

ORDER BY id_riwayat DESC) as x

GROUP BY id_pegawai order by id_pegawai) as y inner join pegawai on pegawai.id_pegawai=y.id_pegawai where id_unit_kerja=$r[1] and jabatan like '%kasubag%'");

$qk8=mysqli_fetch_array($k8);

if($qk8[0]>0)

{

$lab[$is]='Kepala Sub Bagian';

$is++;

}





$k08=mysqli_query($mysqli,"select count(*) from (SELECT id_pegawai, id_unit_kerja, MAX(id_riwayat) FROM (SELECT id_pegawai,id_unit_kerja, id_riwayat FROM riwayat_mutasi_kerja

ORDER BY id_riwayat DESC) as x

GROUP BY id_pegawai order by id_pegawai) as y inner join pegawai on pegawai.id_pegawai=y.id_pegawai where id_unit_kerja=$r[1] and jabatan like '%kepala UPTD%'");

$qk08=mysqli_fetch_array($k08);

if($qk08[0]>0)

{

$lab[$is]='Kepala UPTD';

$is++;

}

//else

//$is--;



$k9=mysqli_query($mysqli,"select count(*) from (SELECT id_pegawai, id_unit_kerja, MAX(id_riwayat) FROM (SELECT id_pegawai,id_unit_kerja, id_riwayat FROM riwayat_mutasi_kerja

ORDER BY id_riwayat DESC) as x

GROUP BY id_pegawai order by id_pegawai) as y inner join pegawai on pegawai.id_pegawai=y.id_pegawai where id_unit_kerja=$r[1] and jabatan like '%lurah%'");

$qk9=mysqli_fetch_array($k9);

if($qk9[0]>0)

{

$lab[$is]='Lurah';

$is++;

}

//else

//$is--;





$k10=mysqli_query($mysqli,"select count(*) from (SELECT id_pegawai, id_unit_kerja, MAX(id_riwayat) FROM (SELECT id_pegawai,id_unit_kerja, id_riwayat FROM riwayat_mutasi_kerja

ORDER BY id_riwayat DESC) as x

GROUP BY id_pegawai order by id_pegawai) as y inner join pegawai on pegawai.id_pegawai=y.id_pegawai where id_unit_kerja=$r[1] and jabatan like '%sekretaris camat%'");

$qk10=mysqli_fetch_array($k10);

if($qk10[0]>0)

{

$lab[$is]='Sekretaris Camat';

$is++;

}

//else

//$is--;



$k11=mysqli_query($mysqli,"select count(*) from (SELECT id_pegawai, id_unit_kerja, MAX(id_riwayat) FROM (SELECT id_pegawai,id_unit_kerja, id_riwayat FROM riwayat_mutasi_kerja

ORDER BY id_riwayat DESC) as x

GROUP BY id_pegawai order by id_pegawai) as y inner join pegawai on pegawai.id_pegawai=y.id_pegawai where id_unit_kerja=$r[1] and jabatan like '%kasi%'");

$qk11=mysqli_fetch_array($k11);

if($qk11[0]>0)

{

$lab[$is]='Kepala Seksi';

$is++;

}

//else

//$is--;





$k12=mysqli_query($mysqli,"select count(*) from (SELECT id_pegawai, id_unit_kerja, MAX(id_riwayat) FROM (SELECT id_pegawai,id_unit_kerja, id_riwayat FROM riwayat_mutasi_kerja

ORDER BY id_riwayat DESC) as x

GROUP BY id_pegawai order by id_pegawai) as y inner join pegawai on pegawai.id_pegawai=y.id_pegawai where id_unit_kerja=$r[1] and jabatan like '%Sekretaris%' and jabatan like '%lurah%'");

$qk12=mysqli_fetch_array($k12);

if($qk12[0]>0)

{

$lab[$is]='Sekretaris Lurah';

$is++;

}

//else

//$is--;





$k13=mysqli_query($mysqli,"select count(*) from (SELECT id_pegawai, id_unit_kerja, MAX(id_riwayat) FROM (SELECT id_pegawai,id_unit_kerja, id_riwayat FROM riwayat_mutasi_kerja

ORDER BY id_riwayat DESC) as x

GROUP BY id_pegawai order by id_pegawai) as y inner join pegawai on pegawai.id_pegawai=y.id_pegawai where id_unit_kerja=$r[1] and jabatan like '%Kepala Urusan Tata Usaha%'");

$qk13=mysqli_fetch_array($k13);

if($qk13[0]>0)

{

$lab[$is]='Kepala Urusan Tata Usaha';

$is++;

}

//else

//$is--;





$is=15;

}













for($isi=0;$isi<=14;$isi++)

{







$qavg0=mysqli_query($mysqli,"select count(*) from (SELECT id_pegawai, id_unit_kerja, MAX(id_riwayat) FROM (SELECT id_pegawai,id_unit_kerja, id_riwayat FROM riwayat_mutasi_kerja

ORDER BY id_riwayat DESC) as x

GROUP BY id_pegawai order by id_pegawai) as y inner join pegawai on pegawai.id_pegawai=y.id_pegawai where id_unit_kerja=$r[1] and jabatan like '%sekda%'");

$avg0=mysqli_fetch_array($qavg0);

if($avg0[0]>0)

{

$data0[$isi]=$avg0[0];

 $bar_1->data[] = $avg0[0];

$isi++;

}





$qavg1=mysqli_query($mysqli,"select count(*) from (SELECT id_pegawai, id_unit_kerja, MAX(id_riwayat) FROM (SELECT id_pegawai,id_unit_kerja, id_riwayat FROM riwayat_mutasi_kerja

ORDER BY id_riwayat DESC) as x

GROUP BY id_pegawai order by id_pegawai) as y inner join pegawai on pegawai.id_pegawai=y.id_pegawai where id_unit_kerja=$r[1] and jabatan like '%asisten%' and jabatan not like '%apoteker%'");

$avg1=mysqli_fetch_array($qavg1);

if($avg1[0]>0)

{

$data1[$isi]=$avg1[0];

 $bar_1->data[] = $avg1[0];

$isi++;

}







$qavg01=mysqli_query($mysqli,"select count(*) from (SELECT id_pegawai, id_unit_kerja, MAX(id_riwayat) FROM (SELECT id_pegawai,id_unit_kerja, id_riwayat FROM riwayat_mutasi_kerja

ORDER BY id_riwayat DESC) as x

GROUP BY id_pegawai order by id_pegawai) as y inner join pegawai on pegawai.id_pegawai=y.id_pegawai where id_unit_kerja=$r[1] and jabatan like '%kepala dinas%'");

$avg01=mysqli_fetch_array($qavg01);

if($avg01[0]>0)

{

$data0[$isi]=$avg01[0];

 $bar_1->data[] = $avg01[0];

$isi++;

}





$qavg=mysqli_query($mysqli,"select count(*) from (SELECT id_pegawai, id_unit_kerja, MAX(id_riwayat) FROM (SELECT id_pegawai,id_unit_kerja, id_riwayat FROM riwayat_mutasi_kerja

ORDER BY id_riwayat DESC) as x

GROUP BY id_pegawai order by id_pegawai) as y inner join pegawai on pegawai.id_pegawai=y.id_pegawai where id_unit_kerja=$r[1] and jabatan like '%kepala badan%'");

$avg=mysqli_fetch_array($qavg);

if($avg[0]>0)

{

$data0[$isi]=$avg[0];

 $bar_1->data[] = $avg[0];

$isi++;

}



$qavg2=mysqli_query($mysqli,"select count(*) from (SELECT id_pegawai, id_unit_kerja, MAX(id_riwayat) FROM (SELECT id_pegawai,id_unit_kerja, id_riwayat FROM riwayat_mutasi_kerja

ORDER BY id_riwayat DESC) as x

GROUP BY id_pegawai order by id_pegawai) as y inner join pegawai on pegawai.id_pegawai=y.id_pegawai where id_unit_kerja=$r[1] and jabatan like '%sekretaris pada badan%'");

$avg2=mysqli_fetch_array($qavg2);

if($avg2[0]>0)

{$data0[$isi]=$avg2[0];

  $bar_1->data[] = $avg2[0];

$isi++;

}





$qavg02=mysqli_query($mysqli,"select count(*) from (SELECT id_pegawai, id_unit_kerja, MAX(id_riwayat) FROM (SELECT id_pegawai,id_unit_kerja, id_riwayat FROM riwayat_mutasi_kerja

ORDER BY id_riwayat DESC) as x

GROUP BY id_pegawai order by id_pegawai) as y inner join pegawai on pegawai.id_pegawai=y.id_pegawai where id_unit_kerja=$r[1] and jabatan like '%sekretaris%' and jabatan like '%dinas%'");

$avg02=mysqli_fetch_array($qavg02);

if($avg02[0]>0)

{$data0[$isi]=$avg02[0];

  $bar_1->data[] = $avg02[0];

$isi++;

}

 

 

 $qavg002=mysqli_query($mysqli,"select count(*) from (SELECT id_pegawai, id_unit_kerja, MAX(id_riwayat) FROM (SELECT id_pegawai,id_unit_kerja, id_riwayat FROM riwayat_mutasi_kerja

ORDER BY id_riwayat DESC) as x

GROUP BY id_pegawai order by id_pegawai) as y inner join pegawai on pegawai.id_pegawai=y.id_pegawai where id_unit_kerja=$r[1] and jabatan like '%kepala kantor%'");

$avg002=mysqli_fetch_array($qavg002);

if($avg002[0]>0)

{$data0[$isi]=$avg002[0];

  $bar_1->data[] = $avg002[0];

$isi++;

}



 $qavg0002=mysqli_query($mysqli,"select count(*) from (SELECT id_pegawai, id_unit_kerja, MAX(id_riwayat) FROM (SELECT id_pegawai,id_unit_kerja, id_riwayat FROM riwayat_mutasi_kerja

ORDER BY id_riwayat DESC) as x

GROUP BY id_pegawai order by id_pegawai) as y inner join pegawai on pegawai.id_pegawai=y.id_pegawai where id_unit_kerja=$r[1] and jabatan like '%camat%'");

$avg0002=mysqli_fetch_array($qavg0002);

if($avg0002[0]>0)

{$data0[$isi]=$avg0002[0];

  $bar_1->data[] = $avg002[0];

$isi++;

}



 $qavgkb=mysqli_query($mysqli,"select count(*) from (SELECT id_pegawai, id_unit_kerja, MAX(id_riwayat) FROM (SELECT id_pegawai,id_unit_kerja, id_riwayat FROM riwayat_mutasi_kerja

ORDER BY id_riwayat DESC) as x

GROUP BY id_pegawai order by id_pegawai) as y inner join pegawai on pegawai.id_pegawai=y.id_pegawai where id_unit_kerja=$r[1] and jabatan like '%kepala bagian%'");

$avgkb=mysqli_fetch_array($qavgkb);

if($avgkb[0]>0)

{$data0[$isi]=$avgkb[0];

  $bar_1->data[] = $avgkb[0];

$isi++;

}

 

 $qavg3=mysqli_query($mysqli,"select count(*) from (SELECT id_pegawai, id_unit_kerja, MAX(id_riwayat) FROM (SELECT id_pegawai,id_unit_kerja, id_riwayat FROM riwayat_mutasi_kerja

ORDER BY id_riwayat DESC) as x

GROUP BY id_pegawai order by id_pegawai) as y inner join pegawai on pegawai.id_pegawai=y.id_pegawai where id_unit_kerja=$r[1] and jabatan like '%kepala bidang%'");

$avg3=mysqli_fetch_array($qavg3);

if($avg3[0]>0)

{$data0[$isi]=$avg3[0];

  $bar_1->data[] = $avg3[0];

$isi++;

}

 





 $qavg4=mysqli_query($mysqli,"select count(*) from (SELECT id_pegawai, id_unit_kerja, MAX(id_riwayat) FROM (SELECT id_pegawai,id_unit_kerja, id_riwayat FROM riwayat_mutasi_kerja

ORDER BY id_riwayat DESC) as x

GROUP BY id_pegawai order by id_pegawai) as y inner join pegawai on pegawai.id_pegawai=y.id_pegawai where id_unit_kerja=$r[1] and jabatan like '%kasubid%'");

$avg4=mysqli_fetch_array($qavg4);

if($avg4[0]>0)

{$data0[$isi]=$avg4[0];

  $bar_1->data[] = $avg4[0];

$isi++;

}

 

 

  







  $qavg004=mysqli_query($mysqli,"select count(*) from (SELECT id_pegawai, id_unit_kerja, MAX(id_riwayat) FROM (SELECT id_pegawai,id_unit_kerja, id_riwayat FROM riwayat_mutasi_kerja

ORDER BY id_riwayat DESC) as x

GROUP BY id_pegawai order by id_pegawai) as y inner join pegawai on pegawai.id_pegawai=y.id_pegawai where id_unit_kerja=$r[1] and  jabatan  like 'lurah%'");

$avg004=mysqli_fetch_array($qavg004);

if($avg004[0]>0)

{$data0[$isi]=$avg004[0];

  $bar_1->data[] = $avg004[0];

$isi++;

}

 

 

   $qavg0004=mysqli_query($mysqli,"select count(*) from (SELECT id_pegawai, id_unit_kerja, MAX(id_riwayat) FROM (SELECT id_pegawai,id_unit_kerja, id_riwayat FROM riwayat_mutasi_kerja

ORDER BY id_riwayat DESC) as x

GROUP BY id_pegawai order by id_pegawai) as y inner join pegawai on pegawai.id_pegawai=y.id_pegawai where id_unit_kerja=$r[1] and jabatan like '%sekretaris camat%' ");

$avg0004=mysqli_fetch_array($qavg0004);

if($avg004[0]>0)

{$data0[$isi]=$avg0004[0];

  $bar_1->data[] = $avg0004[0];

$isi++;

}

 

 

  $qavg5=mysqli_query($mysqli,"select count(*) from (SELECT id_pegawai, id_unit_kerja, MAX(id_riwayat) FROM (SELECT id_pegawai,id_unit_kerja, id_riwayat FROM riwayat_mutasi_kerja

ORDER BY id_riwayat DESC) as x

GROUP BY id_pegawai order by id_pegawai) as y inner join pegawai on pegawai.id_pegawai=y.id_pegawai where id_unit_kerja=$r[1] and jabatan like '%kasubag%'");

$avg5=mysqli_fetch_array($qavg5);

if($avg5[0]>0)

{$data0[$isi]=$avg5[0];

  $bar_1->data[] = $avg5[0];

$isi++;

}



  $qavg05=mysqli_query($mysqli,"select count(*) from (SELECT id_pegawai, id_unit_kerja, MAX(id_riwayat) FROM (SELECT id_pegawai,id_unit_kerja, id_riwayat FROM riwayat_mutasi_kerja

ORDER BY id_riwayat DESC) as x

GROUP BY id_pegawai order by id_pegawai) as y inner join pegawai on pegawai.id_pegawai=y.id_pegawai where id_unit_kerja=$r[1] and jabatan like '%kepala UPTD%'");

$avg05=mysqli_fetch_array($qavg05);

if($avg05[0]>0)

{$data0[$isi]=$avg05[0];

  $bar_1->data[] = $avg05[0];

$isi++;

}



$qavg04=mysqli_query($mysqli,"select count(*) from (SELECT id_pegawai, id_unit_kerja, MAX(id_riwayat) FROM (SELECT id_pegawai,id_unit_kerja, id_riwayat FROM riwayat_mutasi_kerja

ORDER BY id_riwayat DESC) as x

GROUP BY id_pegawai order by id_pegawai) as y inner join pegawai on pegawai.id_pegawai=y.id_pegawai where id_unit_kerja=$r[1] and jabatan like '%kasi%' and jabatan not like '%kelurahan%'");

$avg04=mysqli_fetch_array($qavg04);

if($avg04[0]>0)

{$data0[$isi]=$avg04[0];

  $bar_1->data[] = $avg04[0];

$isi++;

}

 

  $qavg6=mysqli_query($mysqli,"select count(*) from (SELECT id_pegawai, id_unit_kerja, MAX(id_riwayat) FROM (SELECT id_pegawai,id_unit_kerja, id_riwayat FROM riwayat_mutasi_kerja

ORDER BY id_riwayat DESC) as x

GROUP BY id_pegawai order by id_pegawai) as y inner join pegawai on pegawai.id_pegawai=y.id_pegawai where id_unit_kerja=$r[1] and jabatan like '%sekretaris%' and jabatan like '%lurah%'");

$avg6=mysqli_fetch_array($qavg6);

if($avg6[0]>0)

{$data0[$isi]=$avg6[0];

  $bar_1->data[] = $avg6[0];

$isi++;

}



 $qavg7=mysqli_query($mysqli,"select count(*) from (SELECT id_pegawai, id_unit_kerja, MAX(id_riwayat) FROM (SELECT id_pegawai,id_unit_kerja, id_riwayat FROM riwayat_mutasi_kerja

ORDER BY id_riwayat DESC) as x

GROUP BY id_pegawai order by id_pegawai) as y inner join pegawai on pegawai.id_pegawai=y.id_pegawai where id_unit_kerja=$r[1] and jabatan like '%kasubag%' and jabatan like '%kecamatan%'");

$avg7=mysqli_fetch_array($qavg7);

if($avg7[0]>0)

{$data0[$isi]=$avg7[0];

  $bar_1->data[] = $avg7[0];

$isi++;

}









 $qavg8=mysqli_query($mysqli,"select count(*) from (SELECT id_pegawai, id_unit_kerja, MAX(id_riwayat) FROM (SELECT id_pegawai,id_unit_kerja, id_riwayat FROM riwayat_mutasi_kerja

ORDER BY id_riwayat DESC) as x

GROUP BY id_pegawai order by id_pegawai) as y inner join pegawai on pegawai.id_pegawai=y.id_pegawai where id_unit_kerja=$r[1] and jabatan like '%kepala%' and jabatan like '%tata usaha%'");

$avg8=mysqli_fetch_array($qavg8);

if($avg8[0]>0)

{$data0[$isi]=$avg8[0];

  $bar_1->data[] = $avg8[0];

$isi++;

}







$isi=14;

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



$g->set_y_max( $pas );

$g->y_label_steps( 10 );

//$g->set_y_legend( "$s", 12, '0x736AFF' );

echo $g->render();

?>