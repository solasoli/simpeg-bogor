<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<style type="text/css">
<!--
body,td,th {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 11px;
}
-->
</style></head>

<body>
<?
extract($_GET);

include("konek.php");
$q=mysqli_query($mysqli,"select count(*) from pegawai where flag_pensiun=0 ");
$itung=mysqli_fetch_array($q);

$q1=mysqli_query($mysqli,"select count(*) from sk inner join pegawai on pegawai.id_pegawai=sk.id_pegawai where flag_pensiun=0 and id_kategori_sk=6 and id_berkas>0 ");

$q2=mysqli_query($mysqli,"select count(*) from sk inner join pegawai on pegawai.id_pegawai=sk.id_pegawai where flag_pensiun=0 and id_kategori_sk=7 and id_berkas>0 ");

$q3=mysqli_query($mysqli,"select count(*) from (select count(*),sk.id_pegawai from sk inner join pegawai on pegawai.id_pegawai=sk.id_pegawai where flag_pensiun=0 and id_kategori_sk=5 and id_berkas>0 and sk.keterangan like concat(pegawai.pangkat_gol,'%')  group by sk.id_pegawai) as x ");
$kepang=mysqli_fetch_array($q3);

$q4=mysqli_query($mysqli,"select count(*) from berkas inner join pegawai on pegawai.id_pegawai=berkas.id_pegawai where flag_pensiun=0 and id_kat=10 ");
$karpeg=mysqli_fetch_array($q4);

$q5=mysqli_query($mysqli,"select count(*) from dp3 inner join pegawai on pegawai.id_pegawai=dp3.id_pegawai where flag_pensiun=0 and tahun=2011 ");
$d2011=mysqli_fetch_array($q5);

$q6=mysqli_query($mysqli,"select count(*) from dp3 inner join pegawai on pegawai.id_pegawai=dp3.id_pegawai where flag_pensiun=0 and tahun=2012 ");
$d2012=mysqli_fetch_array($q6);

$q7=mysqli_query($mysqli,"select count(*),sk.id_pegawai from sk inner join pegawai on pegawai.id_pegawai=sk.id_pegawai where flag_pensiun=0 and tmt like '2010%' and id_kategori_sk=9 and id_berkas>0 group by sk.id_pegawai");
$kgb2010=mysqli_num_rows($q7);

$q8=mysqli_query($mysqli,"select count(*),sk.id_pegawai from sk inner join pegawai on pegawai.id_pegawai=sk.id_pegawai where flag_pensiun=0 and tmt like '2011%' and id_kategori_sk=9 and id_berkas>0 group by sk.id_pegawai");
$kgb2011=mysqli_num_rows($q8);



$pns=mysqli_fetch_array($q2);
$cpns=mysqli_fetch_array($q1);
$perkepang=round($kepang[0]/$itung[0],2)*100;
$perkarpeg=round($karpeg[0]/$itung[0],2)*100;
$percpns=round($cpns[0]/$itung[0],2)*100;
$perpns=round($pns[0]/$itung[0],2)*100;
$per2011=round($d2011[0]/$itung[0],2)*100;
$per2012=round($d2012[0]/$itung[0],2)*100;
$perkgb1=round($kgb2010/$itung[0],2)*100;
$perkgb2=round($kgb2011/$itung[0],2)*100;



$pcpns=($cpns[0]/50);
$ppns=($pns[0]/50);
$pkarpeg=($karpeg[0]/50);
$pkepang=($kepang[0]/50);
$p2011=($d2011[0]/50);
$p2012=($d2012[0]/50);
$pkgb1=($kgb2010/50);
$pkgb2=($kgb2011/50);
echo("<table ALIGN=CENTER border=0 cellspacing=0 cellpadding=5><tr><td align=center valign=bottom> $percpns"."% <br> ($cpns[0])<br><img src=./images/bar.png width=50 height=$pcpns />    </td>
<td align=center valign=bottom> $perpns"."% <br> ($pns[0])<br><img src=./images/bar.png width=50 height=$ppns />    </td>
<td align=center valign=bottom> $perkepang"."% <br> ($kepang[0])<br><img src=./images/bar.png width=50 height=$pkepang />    </td>
<td align=center valign=bottom> $perkarpeg"."% <br> ($karpeg[0])<br><img src=./images/bar.png width=50 height=$pkarpeg />    </td>
<td align=center valign=bottom> $per2012"."% <br> ($d2012[0])<br><img src=./images/bar.png width=50 height=$p2012 />    </td>
<td align=center valign=bottom> $per2011"."% <br> ($d2011[0])<br><img src=./images/bar.png width=50 height=$p2011 />    </td>
<td align=center valign=bottom> $perkgb1"."% <br> ($kgb2010)<br><img src=./images/bar.png width=50 height=$pkgb1 />    </td>
<td align=center valign=bottom> $perkgb2"."% <br> ($kgb2011)<br><img src=./images/bar.png width=50 height=$pkgb2 />    </td>
</tr>
<tr><td align=center> <a href=cpns.php?id=6>SK CPNS</a> </td><td align=center> <a href=cpns.php?id=7>SK PNS </a></td><td align=center><a href=cpns.php?id=5> SK KP </a> </td><td align=center> <a href=cpns.php?id=10>Karpeg</a> </td>

<td align=center> <a href=cpns.php?id=2012>DP3 2012</a> </td>
<td align=center><a href=cpns.php?id=2011> DP3 2011 </a> </td>
<td align=center><a href=cpns.php?id=k2010> KGB 2010 </a> </td>
<td align=center><a href=cpns.php?id=k2011> KGB 2011 </a> </td>
</tr></table>");

if($id==6)
{

$qa=mysqli_query($mysqli,"select count(*),id_skpd from sk inner join pegawai on pegawai.id_pegawai=sk.id_pegawai inner join current_lokasi_kerja on current_lokasi_kerja.id_pegawai=pegawai.id_pegawai inner join unit_kerja on unit_kerja.id_unit_kerja=current_lokasi_kerja.id_unit_kerja where flag_pensiun=0 and id_kategori_sk=6 and id_berkas>0 and unit_kerja.tahun=2011 group by id_skpd order by id_skpd");

echo("<table align=center cellpadding=5 cellspacing=0 border=0><tr> <td > Unit kerja </td><td align=center> Jumah Pegawai </td><td align=center> Jumah SK </td><td align=center> Persentase </td></tr>");
while($ata=mysqli_fetch_array($qa))
{

$qc=mysqli_query($mysqli,"Select nama_baru from unit_kerja where id_unit_kerja=$ata[1]");
$c=mysqli_fetch_array($qc);

$qd=mysqli_query($mysqli,"Select count(*) from current_lokasi_kerja inner join unit_kerja on unit_kerja.id_unit_kerja=current_lokasi_kerja.id_unit_kerja inner join pegawai on pegawai.id_pegawai=current_lokasi_kerja.id_pegawai where id_skpd=$ata[1] and flag_pensiun=0 ");
$d=mysqli_fetch_array($qd);

$per=round(($ata[0]/$d[0])*100,0);
echo(" <tr> <td>$c[0] </td><td align=center> $d[0] </td><td align=center> $ata[0] </td><td align=center> $per"."% </td></tr> ");
}


echo("</table>");
}
elseif($id==7)
{

$qa=mysqli_query($mysqli,"select count(*),id_skpd from sk inner join pegawai on pegawai.id_pegawai=sk.id_pegawai inner join current_lokasi_kerja on current_lokasi_kerja.id_pegawai=pegawai.id_pegawai inner join unit_kerja on unit_kerja.id_unit_kerja=current_lokasi_kerja.id_unit_kerja where flag_pensiun=0 and id_kategori_sk=7 and id_berkas>0 and unit_kerja.tahun=2011 group by id_skpd order by id_skpd");
echo("<table align=center cellpadding=5 cellspacing=0 border=0><tr> <td > Unit kerja </td><td align=center> Jumah Pegawai </td><td align=center> Jumah SK </td><td align=center> Persentase </td></tr>");
while($ata=mysqli_fetch_array($qa))
{

$qc=mysqli_query($mysqli,"Select nama_baru from unit_kerja where id_unit_kerja=$ata[1]");
$c=mysqli_fetch_array($qc);

$qd=mysqli_query($mysqli,"Select count(*) from current_lokasi_kerja inner join unit_kerja on unit_kerja.id_unit_kerja=current_lokasi_kerja.id_unit_kerja inner join pegawai on pegawai.id_pegawai=current_lokasi_kerja.id_pegawai where id_skpd=$ata[1] and flag_pensiun=0");
$d=mysqli_fetch_array($qd);

$per=round(($ata[0]/$d[0])*100,0);
echo(" <tr> <td>$c[0] </td><td align=center> $d[0] </td><td align=center> $ata[0] </td><td align=center> $per"."% </td></tr> ");
}


echo("</table>");


}

elseif($id==5)
{

$qa=mysqli_query($mysqli,"
select count(*),id_skpd from (
select sk.id_pegawai,count(*) as y from sk inner join pegawai on pegawai.id_pegawai = sk.id_pegawai where id_kategori_sk=5 and  sk.keterangan like concat(pangkat_gol,'%') group by sk.id_pegawai) as x inner join current_lokasi_kerja on current_lokasi_kerja.id_pegawai=x.id_pegawai inner join unit_kerja on unit_kerja.id_unit_kerja=current_lokasi_kerja.id_unit_kerja where id_skpd>3000 group by id_skpd

");
echo("<table align=center cellpadding=5 cellspacing=0 border=0><tr> <td > Unit kerja </td><td align=center> Jumah Pegawai </td><td align=center> Jumah SK </td><td align=center> Persentase </td></tr>");
while($ata=mysqli_fetch_array($qa))
{

$qc=mysqli_query($mysqli,"Select nama_baru from unit_kerja where id_unit_kerja=$ata[1]");
$c=mysqli_fetch_array($qc);

$qd=mysqli_query($mysqli,"Select count(*) from current_lokasi_kerja inner join unit_kerja on unit_kerja.id_unit_kerja=current_lokasi_kerja.id_unit_kerja inner join pegawai on pegawai.id_pegawai=current_lokasi_kerja.id_pegawai where id_skpd=$ata[1] and flag_pensiun=0");
$d=mysqli_fetch_array($qd);

$per=round(($ata[0]/$d[0])*100,0);
echo(" <tr> <td>$c[0] </td><td align=center> $d[0] </td><td align=center> $ata[0] </td><td align=center> $per"."% </td></tr> ");
}


echo("</table>");


}



elseif($id==10)
{

$qa=mysqli_query($mysqli,"select count(*),id_skpd from berkas inner join pegawai on pegawai.id_pegawai=berkas.id_pegawai inner join current_lokasi_kerja on current_lokasi_kerja.id_pegawai=berkas.id_pegawai inner join unit_kerja on unit_kerja.id_unit_kerja=current_lokasi_kerja.id_unit_kerja where flag_pensiun=0 and id_kat=10  and unit_kerja.tahun=2011 group by id_skpd order by id_skpd");
echo("<table align=center cellpadding=5 cellspacing=0 border=0><tr> <td > Unit kerja </td><td align=center> Jumah Pegawai </td><td align=center> Jumah SK </td><td align=center> Persentase </td></tr>");
while($ata=mysqli_fetch_array($qa))
{

$qc=mysqli_query($mysqli,"Select nama_baru from unit_kerja where id_unit_kerja=$ata[1]");
$c=mysqli_fetch_array($qc);

$qd=mysqli_query($mysqli,"Select count(*) from current_lokasi_kerja inner join unit_kerja on unit_kerja.id_unit_kerja=current_lokasi_kerja.id_unit_kerja inner join pegawai on pegawai.id_pegawai=current_lokasi_kerja.id_pegawai where id_skpd=$ata[1] and flag_pensiun=0");
$d=mysqli_fetch_array($qd);

$per=round(($ata[0]/$d[0])*100,0);
echo(" <tr> <td>$c[0] </td><td align=center> $d[0] </td><td align=center> $ata[0] </td><td align=center> $per"."% </td></tr> ");
}
echo("</table>");
}




elseif($id==2010)
{

$qa=mysqli_query($mysqli,"select count(*),id_skpd from dp3 inner join pegawai on pegawai.id_pegawai=dp3.id_pegawai inner join current_lokasi_kerja on current_lokasi_kerja.id_pegawai=dp3.id_pegawai inner join unit_kerja on unit_kerja.id_unit_kerja=current_lokasi_kerja.id_unit_kerja where flag_pensiun=0 and dp3.tahun=2010  and unit_kerja.tahun=2011 group by id_skpd order by id_skpd");
echo("<table align=center cellpadding=5 cellspacing=0 border=0><tr> <td > Unit kerja </td><td align=center> Jumah Pegawai </td><td align=center> Jumah SK </td><td align=center> Persentase </td></tr>");
while($ata=mysqli_fetch_array($qa))
{

$qc=mysqli_query($mysqli,"Select nama_baru from unit_kerja where id_unit_kerja=$ata[1]");
$c=mysqli_fetch_array($qc);

$qd=mysqli_query($mysqli,"Select count(*) from current_lokasi_kerja inner join unit_kerja on unit_kerja.id_unit_kerja=current_lokasi_kerja.id_unit_kerja inner join pegawai on pegawai.id_pegawai=current_lokasi_kerja.id_pegawai where id_skpd=$ata[1] and flag_pensiun=0");
$d=mysqli_fetch_array($qd);

$per=round(($ata[0]/$d[0])*100,0);
echo(" <tr> <td>$c[0] </td><td align=center> $d[0] </td><td align=center> $ata[0] </td><td align=center> $per"."% </td></tr> ");
}
echo("</table>");
}


elseif($id==2011)
{

$qa=mysqli_query($mysqli,"select count(*),id_skpd from dp3 inner join pegawai on pegawai.id_pegawai=dp3.id_pegawai inner join current_lokasi_kerja on current_lokasi_kerja.id_pegawai=dp3.id_pegawai inner join unit_kerja on unit_kerja.id_unit_kerja=current_lokasi_kerja.id_unit_kerja where flag_pensiun=0 and dp3.tahun=2011  and unit_kerja.tahun=2011 group by id_skpd order by id_skpd");
echo("<table align=center cellpadding=5 cellspacing=0 border=0><tr> <td > Unit kerja </td><td align=center> Jumah Pegawai </td><td align=center> Jumah SK </td><td align=center> Persentase </td></tr>");
while($ata=mysqli_fetch_array($qa))
{

$qc=mysqli_query($mysqli,"Select nama_baru from unit_kerja where id_unit_kerja=$ata[1]");
$c=mysqli_fetch_array($qc);

$qd=mysqli_query($mysqli,"Select count(*) from current_lokasi_kerja inner join unit_kerja on unit_kerja.id_unit_kerja=current_lokasi_kerja.id_unit_kerja inner join pegawai on pegawai.id_pegawai=current_lokasi_kerja.id_pegawai where id_skpd=$ata[1] and flag_pensiun=0");
$d=mysqli_fetch_array($qd);

$per=round(($ata[0]/$d[0])*100,0);
echo(" <tr> <td>$c[0] </td><td align=center> $d[0] </td><td align=center> $ata[0] </td><td align=center> $per"."% </td></tr> ");
}
echo("</table>");
}
?>

</body>
</html>
