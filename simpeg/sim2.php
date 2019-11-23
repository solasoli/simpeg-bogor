<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<title>Untitled Document</title>

<style type="text/css">

<!--

body,td,th {

	font-family: Tahoma;

	font-size: 11px;

}

body {

	margin-left: 0px;

	margin-top: 0px;

	margin-right: 0px;

	margin-bottom: 0px;

}

-->

</style></head>



<body>

<table width="200" border="0" cellpadding="0" cellspacing="0">

  <tr>

    <td align="left" valign="top"><table border="0" cellpadding="3" cellspacing="3" >

      <tr >

        <td nowrap="nowrap"> jabatan :

          <?

include("konek.php");

$id=$_REQUEST['id'];



 ?></td>

        <td>&nbsp;</td>

      </tr>

      <?

$sql = "SELECT nama_baru,riwayat_mutasi_kerja.id_unit_kerja from riwayat_mutasi_kerja inner join unit_kerja on riwayat_mutasi_kerja.id_unit_kerja

				=unit_kerja.id_unit_kerja where id_pegawai=$id order by id_riwayat desc";

				

				$result = mysqli_query($mysqli,$sql);

				$r = mysqli_fetch_array($result);

				$unit = $r[1];



$qavg0=mysqli_query($mysqli,"select count(*) from (SELECT id_pegawai, id_unit_kerja, MAX(id_riwayat) FROM (SELECT id_pegawai,id_unit_kerja, id_riwayat FROM riwayat_mutasi_kerja

ORDER BY id_riwayat DESC) as x

GROUP BY id_pegawai order by id_pegawai) as y inner join pegawai on pegawai.id_pegawai=y.id_pegawai where id_unit_kerja=$r[1] and jabatan like '%sekda%'");

$avg0=mysqli_fetch_array($qavg0);

if($avg0[0]>0)

{

$qavg0a=mysqli_query($mysqli,"select pegawai.id_pegawai,nama from (SELECT id_pegawai, id_unit_kerja, MAX(id_riwayat) FROM (SELECT id_pegawai,id_unit_kerja, id_riwayat FROM riwayat_mutasi_kerja

ORDER BY id_riwayat DESC) as x

GROUP BY id_pegawai order by id_pegawai) as y inner join pegawai on pegawai.id_pegawai=y.id_pegawai where id_unit_kerja=$r[1] and jabatan like '%sekda%'");

$avg0a=mysqli_fetch_array($qavg0a);

echo("<tr><td align=left bgcolor=#f0f0f0><a href=sim2.php?y01=$avg0a[0]>Sekretaris Daerah</a></td></tr>");

if($_REQUEST['y01']!=NULL)

echo("<tr><td align=left>$avg0a[1]</td></tr>");

}



$qavg1=mysqli_query($mysqli,"select count(*) from (SELECT id_pegawai, id_unit_kerja, MAX(id_riwayat) FROM (SELECT id_pegawai,id_unit_kerja, id_riwayat FROM riwayat_mutasi_kerja

ORDER BY id_riwayat DESC) as x

GROUP BY id_pegawai order by id_pegawai) as y inner join pegawai on pegawai.id_pegawai=y.id_pegawai where id_unit_kerja=$r[1] and jabatan like '%asisten%' and jabatan not like '%apoteker%'");

$avg1=mysqli_fetch_array($qavg1);

if($avg1[0]>0)

{



$qavg1a=mysqli_query($mysqli,"select pegawai.id_pegawai,jabatan,nama from (SELECT id_pegawai, id_unit_kerja, MAX(id_riwayat) FROM (SELECT id_pegawai,id_unit_kerja, id_riwayat FROM riwayat_mutasi_kerja

ORDER BY id_riwayat DESC) as x

GROUP BY id_pegawai order by id_pegawai) as y inner join pegawai on pegawai.id_pegawai=y.id_pegawai where id_unit_kerja=$r[1] and jabatan like '%asisten%' and jabatan like '%asisten%'");

$avg1a=mysqli_fetch_array($qavg1a);



echo("<tr><td align=left bgcolor=#f0f0f0><a href=sim2.php?id=$id&&y02=$avg0a[0]>$avg1a[1]</a></td></tr>");

if($_REQUEST['y02']!=NULL)

echo("<tr><td align=left>$avg1a[2]</td></tr>");

}





$qavg01=mysqli_query($mysqli,"select count(*) from (SELECT id_pegawai, id_unit_kerja, MAX(id_riwayat) FROM (SELECT id_pegawai,id_unit_kerja, id_riwayat FROM riwayat_mutasi_kerja

ORDER BY id_riwayat DESC) as x

GROUP BY id_pegawai order by id_pegawai) as y inner join pegawai on pegawai.id_pegawai=y.id_pegawai where id_unit_kerja=$r[1] and jabatan like '%kepala dinas%'");

$avg01=mysqli_fetch_array($qavg01);

if($avg01[0]>0)

{

$qavg01a=mysqli_query($mysqli,"select pegawai.id_pegawai,jabatan,nama from (SELECT id_pegawai, id_unit_kerja, MAX(id_riwayat) FROM (SELECT id_pegawai,id_unit_kerja, id_riwayat FROM riwayat_mutasi_kerja

ORDER BY id_riwayat DESC) as x

GROUP BY id_pegawai order by id_pegawai) as y inner join pegawai on pegawai.id_pegawai=y.id_pegawai where id_unit_kerja=$r[1] and jabatan like '%kepala dinas%'");

$avg01a=mysqli_fetch_array($qavg01a);

echo("<tr><td align=left bgcolor=#f0f0f0><a href=sim2.php?id=$id&&y03=$avg01a[0]>$avg01a[1]</a></td></tr>");

if($_REQUEST['y03']!=NULL)

echo("<tr><td>$avg01a[2]</td></tr>");

}



$qavg=mysqli_query($mysqli,"select count(*) from (SELECT id_pegawai, id_unit_kerja, MAX(id_riwayat) FROM (SELECT id_pegawai,id_unit_kerja, id_riwayat FROM riwayat_mutasi_kerja

ORDER BY id_riwayat DESC) as x

GROUP BY id_pegawai order by id_pegawai) as y inner join pegawai on pegawai.id_pegawai=y.id_pegawai where id_unit_kerja=$r[1] and jabatan like '%kepala badan%'");

$avg=mysqli_fetch_array($qavg);

if($avg[0]>0)

{

$qavg0a=mysqli_query($mysqli,"select pegawai.id_pegawai,jabatan,nama from (SELECT id_pegawai, id_unit_kerja, MAX(id_riwayat) FROM (SELECT id_pegawai,id_unit_kerja, id_riwayat FROM riwayat_mutasi_kerja

ORDER BY id_riwayat DESC) as x

GROUP BY id_pegawai order by id_pegawai) as y inner join pegawai on pegawai.id_pegawai=y.id_pegawai where id_unit_kerja=$r[1] and jabatan like '%kepala badan%'");

$avg0a=mysqli_fetch_array($qavg0a);

echo("<tr><td align=left nowrap bgcolor=#f0f0f0><a href=sim2.php?id=$id&&y=$avg0a[0]>$avg0a[1]</a></td></tr>");

$y=$_REQUEST['y'];

if($y!=NULL and $y1==NULL)

echo("<tr><td align=left nowrap>$avg0a[2]</td></tr>");



}



$qavg2=mysqli_query($mysqli,"select count(*) from (SELECT id_pegawai, id_unit_kerja, MAX(id_riwayat) FROM (SELECT id_pegawai,id_unit_kerja, id_riwayat FROM riwayat_mutasi_kerja

ORDER BY id_riwayat DESC) as x

GROUP BY id_pegawai order by id_pegawai) as y inner join pegawai on pegawai.id_pegawai=y.id_pegawai where id_unit_kerja=$r[1] and jabatan like '%sekretaris%' and jabatan like '%badan%'");

$avg2=mysqli_fetch_array($qavg2);

if($avg2[0]>0)

{



$qavg2a=mysqli_query($mysqli,"select jabatan,nama from (SELECT id_pegawai, id_unit_kerja, MAX(id_riwayat) FROM (SELECT id_pegawai,id_unit_kerja, id_riwayat FROM riwayat_mutasi_kerja

ORDER BY id_riwayat DESC) as x

GROUP BY id_pegawai order by id_pegawai) as y inner join pegawai on pegawai.id_pegawai=y.id_pegawai where id_unit_kerja=$r[1] and jabatan like '%sekretaris pada badan%'");

$avg2a=mysqli_fetch_array($qavg2a);



$pos=strpos("$avg2a[0]",'pada');

$jab=substr("$avg2a[0]",0,$pos);

echo("<tr><td align=left bgcolor=#f0f0f0><a href=sim2.php?id=$id&&y1=$avg2a[0]>$jab</a></td></tr>");

$y1=$_REQUEST['y1'];

if($y1!=NULL and $y==NULL)

echo("<tr><td align=left nowrap>$avg2a[1]</td></tr>");

}





$qavg02=mysqli_query($mysqli,"select count(*) from (SELECT id_pegawai, id_unit_kerja, MAX(id_riwayat) FROM (SELECT id_pegawai,id_unit_kerja, id_riwayat FROM riwayat_mutasi_kerja

ORDER BY id_riwayat DESC) as x

GROUP BY id_pegawai order by id_pegawai) as y inner join pegawai on pegawai.id_pegawai=y.id_pegawai where id_unit_kerja=$r[1] and jabatan like '%sekretaris%' and jabatan like '%dinas%'");

$avg02=mysqli_fetch_array($qavg02);

if($avg02[0]>0)

{

$qavg02a=mysqli_query($mysqli,"select jabatan,nama,pegawai.id_pegawai from (SELECT id_pegawai, id_unit_kerja, MAX(id_riwayat) FROM (SELECT id_pegawai,id_unit_kerja, id_riwayat FROM riwayat_mutasi_kerja

ORDER BY id_riwayat DESC) as x

GROUP BY id_pegawai order by id_pegawai) as y inner join pegawai on pegawai.id_pegawai=y.id_pegawai where id_unit_kerja=$r[1] and jabatan like '%sekretaris%' and jabatan like '%dinas%'");

$avg02a=mysqli_fetch_array($qavg02a);

echo("<tr><td align=left bgcolor=#f0f0f0><a href=sim2.php?id=$id&&y04=$avg02a[2]>$avg02a[0]</a></td></tr>");

if($_REQUEST['y04']!=NULL)

echo("<tr><td align=left nowrap>$avg02a[1]</td></tr>");

}

 

 

 $qavg002=mysqli_query($mysqli,"select count(*) from (SELECT id_pegawai, id_unit_kerja, MAX(id_riwayat) FROM (SELECT id_pegawai,id_unit_kerja, id_riwayat FROM riwayat_mutasi_kerja

ORDER BY id_riwayat DESC) as x

GROUP BY id_pegawai order by id_pegawai) as y inner join pegawai on pegawai.id_pegawai=y.id_pegawai where id_unit_kerja=$r[1] and jabatan like '%kepala kantor%'");

$avg002=mysqli_fetch_array($qavg002);

if($avg002[0]>0)

{$qavg002a=mysqli_query($mysqli,"select nama,jabatan,pegawai.id_pegawai from (SELECT id_pegawai, id_unit_kerja, MAX(id_riwayat) FROM (SELECT id_pegawai,id_unit_kerja, id_riwayat FROM riwayat_mutasi_kerja

ORDER BY id_riwayat DESC) as x

GROUP BY id_pegawai order by id_pegawai) as y inner join pegawai on pegawai.id_pegawai=y.id_pegawai where id_unit_kerja=$r[1] and jabatan like '%kepala kantor%'");

$avg002a=mysqli_fetch_array($qavg002a);

echo("<tr><td align=left bgcolor=#f0f0f0><a href=sim2.php?id=$id&&y05=$avg002a[2]>$avg002a[1]</a></td></tr>");

if($_REQUEST['y05']!=NULL)

echo("<tr><td align=left nowrap>$avg002a[0]</td></tr>");

}



 $qavg0002=mysqli_query($mysqli,"select count(*) from (SELECT id_pegawai, id_unit_kerja, MAX(id_riwayat) FROM (SELECT id_pegawai,id_unit_kerja, id_riwayat FROM riwayat_mutasi_kerja

ORDER BY id_riwayat DESC) as x

GROUP BY id_pegawai order by id_pegawai) as y inner join pegawai on pegawai.id_pegawai=y.id_pegawai where id_unit_kerja=$r[1] and jabatan like '%camat%'");

$avg0002=mysqli_fetch_array($qavg0002);

if($avg0002[0]>0)

{$qavg0002a=mysqli_query($mysqli,"select nama,jabatan,pegawai.id_pegawai from (SELECT id_pegawai, id_unit_kerja, MAX(id_riwayat) FROM (SELECT id_pegawai,id_unit_kerja, id_riwayat FROM riwayat_mutasi_kerja

ORDER BY id_riwayat DESC) as x

GROUP BY id_pegawai order by id_pegawai) as y inner join pegawai on pegawai.id_pegawai=y.id_pegawai where id_unit_kerja=$r[1] and jabatan like '%camat%'");

$avg0002a=mysqli_fetch_array($qavg0002a);



echo("<tr><td align=left bgcolor=#f0f0f0><a href=sim2.php?id=$id&&y06=$avg0002a[2]>$avg0002a[1]</a></td></tr>");

if($_REQUEST['y06']!=NULL)

echo("<tr><td align=left nowrap>$avg0002a[0]</td></tr>");

}



 $qavgkb=mysqli_query($mysqli,"select count(*) from (SELECT id_pegawai, id_unit_kerja, MAX(id_riwayat) FROM (SELECT id_pegawai,id_unit_kerja, id_riwayat FROM riwayat_mutasi_kerja

ORDER BY id_riwayat DESC) as x

GROUP BY id_pegawai order by id_pegawai) as y inner join pegawai on pegawai.id_pegawai=y.id_pegawai where id_unit_kerja=$r[1] and jabatan like '%kepala bagian%'");

$avgkb=mysqli_fetch_array($qavgkb);

if($avgkb[0]>0)

{ $qavg00002a=mysqli_query($mysqli,"select nama,jabatan,pegawai.id_pegawai  from (SELECT id_pegawai, id_unit_kerja, MAX(id_riwayat) FROM (SELECT id_pegawai,id_unit_kerja, id_riwayat FROM riwayat_mutasi_kerja

ORDER BY id_riwayat DESC) as x

GROUP BY id_pegawai order by id_pegawai) as y inner join pegawai on pegawai.id_pegawai=y.id_pegawai where id_unit_kerja=$r[1] and jabatan like '%kepala bagian%'");

$avg00002a=mysqli_fetch_array($qavg00002a);

echo("<tr bgcolor=#f0f0f0><td align=left nowrap><a href=sim2.php?id=$id&&y07=$avg00002a[2]>$avg00002a[1]</a></td></tr>");

if($_REQUEST['y07']!=NULL)

echo("<tr><td align=left nowrap>$avg00002a[0]</td></tr>");



}

 

 $qavg3=mysqli_query($mysqli,"select count(*) from (SELECT id_pegawai, id_unit_kerja, MAX(id_riwayat) FROM (SELECT id_pegawai,id_unit_kerja, id_riwayat FROM riwayat_mutasi_kerja

ORDER BY id_riwayat DESC) as x

GROUP BY id_pegawai order by id_pegawai) as y inner join pegawai on pegawai.id_pegawai=y.id_pegawai where id_unit_kerja=$r[1] and jabatan like '%kepala bidang%'");

$avg3=mysqli_fetch_array($qavg3);

if($avg3[0]>0)

{

$qavg3a=mysqli_query($mysqli,"select nama,jabatan,pegawai.id_pegawai from (SELECT id_pegawai, id_unit_kerja, MAX(id_riwayat) FROM (SELECT id_pegawai,id_unit_kerja, id_riwayat FROM riwayat_mutasi_kerja

ORDER BY id_riwayat DESC) as x

GROUP BY id_pegawai order by id_pegawai) as y inner join pegawai on pegawai.id_pegawai=y.id_pegawai where id_unit_kerja=$r[1] and jabatan like '%kepala bidang%'");

$kb=1;

while($avg3a=mysqli_fetch_array($qavg3a))

{

$pos=strpos("$avg3a[1]",'pada');

$jab=substr("$avg3a[1]",0,$pos);



echo("<tr><td align=left nowrap bgcolor=#f0f0f0><a href=sim2.php?id=$id&&kb$kb=$avg3a[2]>$jab</a></td></tr>");



if($_REQUEST["kb"."$kb"]!=NULL)

echo("<tr><td align=left nowrap >$avg3a[0]</td></tr>");

$kb++;



}

}

 





 $qavg4=mysqli_query($mysqli,"select count(*) from (SELECT id_pegawai, id_unit_kerja, MAX(id_riwayat) FROM (SELECT id_pegawai,id_unit_kerja, id_riwayat FROM riwayat_mutasi_kerja

ORDER BY id_riwayat DESC) as x

GROUP BY id_pegawai order by id_pegawai) as y inner join pegawai on pegawai.id_pegawai=y.id_pegawai where id_unit_kerja=$r[1] and jabatan like '%kasubid%'");

$avg4=mysqli_fetch_array($qavg4);

if($avg4[0]>0)

{

 $qavg4a=mysqli_query($mysqli,"select nama,jabatan,pegawai.id_pegawai from (SELECT id_pegawai, id_unit_kerja, MAX(id_riwayat) FROM (SELECT id_pegawai,id_unit_kerja, id_riwayat FROM riwayat_mutasi_kerja

ORDER BY id_riwayat DESC) as x

GROUP BY id_pegawai order by id_pegawai) as y inner join pegawai on pegawai.id_pegawai=y.id_pegawai where id_unit_kerja=$r[1] and jabatan like '%kasubid%'");

$ks=1;

while($avg4a=mysqli_fetch_array($qavg4a))

{

$pos=strpos("$avg4a[1]",'pada');

$jab=substr("$avg4a[1]",0,$pos);

echo("<tr><td align=left nowrap bgcolor=#f0f0f0><a href=sim2.php?id=$id&&ks$ks=$avg4a[2]>$jab</a></td></tr>");



if($_REQUEST["ks"."$ks"]!=NULL)

echo("<tr><td align=left nowrap>$avg4a[0]</td></tr>");

$ks++;

}



}

 

 

 $qavg5=mysqli_query($mysqli,"select count(*) from (SELECT id_pegawai, id_unit_kerja, MAX(id_riwayat) FROM (SELECT id_pegawai,id_unit_kerja, id_riwayat FROM riwayat_mutasi_kerja

ORDER BY id_riwayat DESC) as x

GROUP BY id_pegawai order by id_pegawai) as y inner join pegawai on pegawai.id_pegawai=y.id_pegawai where id_unit_kerja=$r[1] and jabatan like '%kasubag%'");

$avg5=mysqli_fetch_array($qavg5);

if($avg5[0]>0)

{$qavg5a=mysqli_query($mysqli,"select nama,jabatan,pegawai.id_pegawai from (SELECT id_pegawai, id_unit_kerja, MAX(id_riwayat) FROM (SELECT id_pegawai,id_unit_kerja, id_riwayat FROM riwayat_mutasi_kerja

ORDER BY id_riwayat DESC) as x

GROUP BY id_pegawai order by id_pegawai) as y inner join pegawai on pegawai.id_pegawai=y.id_pegawai where id_unit_kerja=$r[1] and jabatan like '%kasubag%'");

$ksb=1;

while($avg5a=mysqli_fetch_array($qavg5a))

{

$pos=strpos("$avg5a[1]",'pada');

$jab=substr("$avg5a[1]",0,$pos);

echo("<tr><td align=left nowrap bgcolor=#f0f0f0><a href=sim2.php?id=$id&&ksb$ksb=$avg5a[2]>$jab</a></td></tr>");



if($_REQUEST["ksb"."$ksb"]!=NULL)

echo("<tr><td align=left nowrap>$avg5a[0]</td></tr>");





$ksb++;

}



}

//uptd

$qavg99=mysqli_query($mysqli,"select count(*) from (SELECT id_pegawai, id_unit_kerja, MAX(id_riwayat) FROM (SELECT id_pegawai,id_unit_kerja, id_riwayat FROM riwayat_mutasi_kerja

ORDER BY id_riwayat DESC) as x

GROUP BY id_pegawai order by id_pegawai) as y inner join pegawai on pegawai.id_pegawai=y.id_pegawai where id_unit_kerja=$r[1] and jabatan like '%kepala UPTD%'");

$avg99=mysqli_fetch_array($qavg99);

if($avg99[0]>0)

{$qavg99a=mysqli_query($mysqli,"select nama,jabatan,pegawai.id_pegawai from (SELECT id_pegawai, id_unit_kerja, MAX(id_riwayat) FROM (SELECT id_pegawai,id_unit_kerja, id_riwayat FROM riwayat_mutasi_kerja

ORDER BY id_riwayat DESC) as x

GROUP BY id_pegawai order by id_pegawai) as y inner join pegawai on pegawai.id_pegawai=y.id_pegawai where id_unit_kerja=$r[1] and jabatan like '%kepala UPTD%'");

$uptd=1;

while($avg99a=mysqli_fetch_array($qavg99a))

{

$pos=strpos("$avg99a[1]",'pada');

$jab=substr("$avg99a[1]",0,$pos);

echo("<tr><td align=left nowrap bgcolor=#f0f0f0><a href=sim2.php?id=$id&&uptd$uptd=$avg99a[2]>$jab</a></td></tr>");



if($_REQUEST["uptd"."$uptd"]!=NULL)

echo("<tr><td align=left nowrap>$avg99a[0]</td></tr>");





$uptd++;

}



}





 

  $qavg04=mysqli_query($mysqli,"select count(*) from (SELECT id_pegawai, id_unit_kerja, MAX(id_riwayat) FROM (SELECT id_pegawai,id_unit_kerja, id_riwayat FROM riwayat_mutasi_kerja

ORDER BY id_riwayat DESC) as x

GROUP BY id_pegawai order by id_pegawai) as y inner join pegawai on pegawai.id_pegawai=y.id_pegawai where id_unit_kerja=$r[1] and jabatan like '%kasi%' and jabatan not like '%kelurahan%'");

$avg04=mysqli_fetch_array($qavg04);

if($avg04[0]>0)

{

$qavg04a=mysqli_query($mysqli,"select nama,jabatan,pegawai.id_pegawai from (SELECT id_pegawai, id_unit_kerja, MAX(id_riwayat) FROM (SELECT id_pegawai,id_unit_kerja, id_riwayat FROM riwayat_mutasi_kerja

ORDER BY id_riwayat DESC) as x

GROUP BY id_pegawai order by id_pegawai) as y inner join pegawai on pegawai.id_pegawai=y.id_pegawai where id_unit_kerja=$r[1] and jabatan like '%kasi%' and jabatan not like '%kelurahan%'");

$kasi=1;

while($avg04a=mysqli_fetch_array($qavg04a))

{

$pos=strpos("$avg04a[1]",'pada');

$jab=substr("$avg04a[1]",0,$pos);

echo("<tr><td align=left nowrap bgcolor=#f0f0f0><a href=sim2.php?id=$id&&kasi$kasi=$avg04a[2]>$jab</a></td></tr>");



if($_REQUEST["kasi"."$kasi"]!=NULL)

echo("<tr><td align=left nowrap>$avg04a[0]</td></tr>");

$kasi++;





}

}







  $qavg004=mysqli_query($mysqli,"select count(*) from (SELECT id_pegawai, id_unit_kerja, MAX(id_riwayat) FROM (SELECT id_pegawai,id_unit_kerja, id_riwayat FROM riwayat_mutasi_kerja

ORDER BY id_riwayat DESC) as x

GROUP BY id_pegawai order by id_pegawai) as y inner join pegawai on pegawai.id_pegawai=y.id_pegawai where id_unit_kerja=$r[1] and  jabatan  like '%lurah%'");

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





?>

      <tr>

        <td colspan="18"></td>

      </tr>

    </table></td>

  </tr>

</table>

</td>

<td align="left" valign="top">



</body>

</html>

