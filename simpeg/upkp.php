<?
include("konek.php");
extract($_POST);

if(isset($_FILES['fcpns']))
$fcpns=$_FILES['fcpns'];
else
$fcpns=NULL;

if(isset($_FILES['pi']))
$pi=$_FILES['pi'];
else
$pi=NULL;

if(isset($_FILES['ud']))
$ud=$_FILES['ud'];
else
$ud=NULL;

if(isset($_FILES['fpns']))
$fpns=$_FILES['fpns'];
else
$fpns=NULL;

if(isset($_FILES['fjab']))
$fjab=$_FILES['fjab'];
else
$fjab=NULL;

if(isset($_FILES['ut']))
$ut=$_FILES['ut'];
else
$ut=NULL;

if(isset($_FILES['fat']))
$fat=$_FILES['fat'];
else
$fat=NULL;

if(isset($_FILES['fkp']))
$fkp=$_FILES['fkp'];
else
$fkp=NULL;

if(isset($_FILES['fsttp']))
$fsttp=$_FILES['fsttp'];
else
$fsttp=NULL;

if(isset($_FILES['fdp3b']))
$fdp3b=$_FILES['fdp3b'];
else
$dp3b=NULL;

if(isset($_FILES['fdp3a']))
$fdp3a=$_FILES['fdp3a'];
else
$dp3a=NULL;

if(isset($_FILES['fij']))
$fij=$_FILES['fij'];
else
$fij=NULL;

if(isset($_FILES['fkarpeg']))
$fkarpeg=$_FILES['fkarpeg'];
else
$fkarpeg=NULL;


$thn=date("Y");
if($fcpns['size']>0 or $fpns['size']>0  or $fkarpeg['size']>0 or $fsttp['size']>0  or $ut['size']>0  or $fjab['size']>0  or $fkp['size']>0  or $fat['size']>0  or ($fdp3b['size']>0  and $fdp3a['size']>0)  or $fij['size']>0 or $pi['size']>0 or $ud['size']>0   )
{
$q=mysqli_query($mysqli,"select count(*) from syarat_mutasi where id_pegawai=$idp and id_proses=1 and tglpengajuan like '$thn%' ");	

	
$cek=mysqli_fetch_array($q);

$tgl=date("Y-m-d");
if($cek[0]==0)
mysqli_query($mysqli,"insert into syarat_mutasi (id_pegawai,id_proses,tglpengajuan) values ($idp,1,'$tgl')");


//cpns	-----> udah bener
if($fcpns['size']>0)
{
	$q1=mysqli_query($mysqli,"select count(*) from sk where id_pegawai=$idp and id_kategori_sk=6");	
	$c1=mysqli_fetch_array($q1);
	if($c1[0]>0)
	{
		$t1=substr($tcpns,0,2);
	$b1=substr($tcpns,3,2);
	$th1=substr($tcpns,6,4);

$t2=substr($tmtcpns,0,2);
	$b2=substr($tmtcpns,3,2);
	$th2=substr($tmtcpns,6,4);
	$qa=mysqli_query($mysqli,"select id_sk,no_sk,nip_baru,nip_lama from sk inner join pegawai on pegawai.id_pegawai=sk.id_pegawai where sk.id_pegawai=$idp and id_kategori_sk=6");
	$a=mysqli_fetch_array($qa);	
	}
	else
	{$t1=substr($tcpns,0,2);
	$b1=substr($tcpns,3,2);
	$th1=substr($tcpns,6,4);

$t2=substr($tmtcpns,0,2);
	$b2=substr($tmtcpns,3,2);
	$th2=substr($tmtcpns,6,4);
	
		mysqli_query($mysqli,"insert into sk (id_pegawai,id_kategori_sk,no_sk,tgl_sk,tmt) values ($idp,6,$cpns,'$th1-$b1-$t1','$th2-$b2-$t2')");
$qa=mysqli_query($mysqli,"select id_sk,no_sk,nip_baru,nip_lama from sk inner join pegawai on pegawai.id_pegawai=sk.id_pegawai where sk.id_pegawai=$idp and id_kategori_sk=6");
	$a=mysqli_fetch_array($qa);	
	}
	
	if(substr($a[2],0,2)=='19')
	$nip=$a[2];
	else
	$nip=$a[3];
move_uploaded_file($fcpns['tmp_name'],"sk/$fcpns[name]");
rename("sk/$fcpns[name]", "sk/$nip"."-"."$a[0]".".jpg");
mysqli_query($mysqli,"insert into berkas (id_pegawai,id_kat,nm_berkas,tgl_upload,tgl_berkas,byk_hal) values ($idp,2,'SK CPNS','$tgl','$th1-$b1-$t1',1)");
$qf=mysqli_query($mysqli,"select id_berkas from berkas order by id_berkas desc");
$foe=mysqli_fetch_array($qf);
mysqli_query($mysqli,"insert into isi_berkas (id_berkas,hal_ke,URL) values ($foe[0],1,'sk/$nip"."-"."$a[0]".".jpg')");
//echo("insert into isi_berkas (id_berkas,id_pegawai,hal_ke,URL) values ($foe[0],$idp,1,'sk/$nip"."-"."$a[0]".".jpg')");
mysqli_query($mysqli,"update syarat_mutasi set id_berkas_skcpns=$a[0] where id_pegawai=$idp and id_proses=1 and tglpengajuan='$tgl'");
mysqli_query($mysqli,"update sk set id_berkas=$foe[0] where id_sk=$a[0]");
}


//sk pns  ---> udah bener

if($fpns['size']>0)
{
	$q1=mysqli_query($mysqli,"select count(*) from sk where id_pegawai=$idp and id_kategori_sk=7");	
	$c1=mysqli_fetch_array($q1);
	if($c1[0]>0)
	{
		$t10=substr($tpns,0,2);
	$b10=substr($tpns,3,2);
	$th10=substr($tpns,6,4);

$t11=substr($tmtpns,0,2);
	$b11=substr($tmtpns,3,2);
	$th11=substr($tmtpns,6,4);
	
	$qa=mysqli_query($mysqli,"select id_sk,no_sk,nip_baru,nip_lama from sk inner join pegawai on pegawai.id_pegawai=sk.id_pegawai where sk.id_pegawai=$idp and id_kategori_sk=7");
	$a=mysqli_fetch_array($qa);	
	}
	else
	{
	$t10=substr($tpns,0,2);
	$b10=substr($tpns,3,2);
	$th10=substr($tpns,6,4);

$t11=substr($tmtpns,0,2);
	$b11=substr($tmtpns,3,2);
	$th11=substr($tmtpns,6,4);
	
		mysqli_query($mysqli,"insert into sk (id_pegawai,id_kategori_sk,no_sk,tgl_sk,tmt) values ($idp,7,$cpns,'$th10-$b10-$t10','$th11-$b11-$t11')");
$qa=mysqli_query($mysqli,"select id_sk,no_sk,nip_baru,nip_lama from sk inner join pegawai on pegawai.id_pegawai=sk.id_pegawai where sk.id_pegawai=$idp and id_kategori_sk=7");
	$a=mysqli_fetch_array($qa);	
	}
	
	if(substr($a[2],0,2)=='19')
	$nip=$a[2];
	else
	$nip=$a[3];
move_uploaded_file($fpns['tmp_name'],"sk/$fpns[name]");
rename("sk/$fpns[name]", "sk/$nip"."-"."$a[0]".".jpg");
mysqli_query($mysqli,"insert into berkas (id_pegawai,id_kat,nm_berkas,tgl_upload,tgl_berkas,byk_hal) values ($idp,2,'SK PNS','$tgl','$th10-$b10-$t10',1)");
$qf=mysqli_query($mysqli,"select id_berkas from berkas order by id_berkas desc");
$foe=mysqli_fetch_array($qf);
mysqli_query($mysqli,"insert into isi_berkas (id_berkas,hal_ke,URL) values ($foe[0],1,'sk/$nip"."-"."$a[0]".".jpg')");
//echo("insert into isi_berkas (id_berkas,id_pegawai,hal_ke,URL) values ($foe[0],$idp,1,'sk/$nip"."-"."$a[0]".".jpg')");
mysqli_query($mysqli,"update syarat_mutasi set id_berkas_skpns=$a[0] where id_pegawai=$idp and id_proses=1 and tglpengajuan='$tgl'");
mysqli_query($mysqli,"update sk set id_berkas=$foe[0] where id_sk=$a[0]");
}


// mutasi jabatan ------>
if($fjab['size']>0)
{
$t8=substr($tjab,0,2);
	$b8=substr($tjab,3,2);
	$th8=substr($jab,6,4);

$t9=substr($tmtjab,0,2);
	$b9=substr($tmtjab,3,2);
	$th9=substr($tmtjab,6,4);
	
$q1=mysqli_query($mysqli,"select count(*) from sk where id_pegawai=$idp and id_kategori_sk=10 and tmt like '$th9%' ");	
	$c1=mysqli_fetch_array($q1);
	if($c1[0]>0)
	{
	$qe=mysqli_query($mysqli,"select id_sk,no_sk,nip_baru,nip_lama from sk inner join pegawai on pegawai.id_pegawai=sk.id_pegawai where sk.id_pegawai=$idp and id_kategori_sk=10 and tmt like '$th9%'");
	$e=mysqli_fetch_array($qe);	
	}
	else
	{$t8=substr($tjab,0,2);
	$b8=substr($tjab,3,2);
	$th8=substr($jab,6,4);

$t9=substr($tmtjab,0,2);
	$b9=substr($tmtjab,3,2);
	$th9=substr($tmtjab,6,4);
	
		mysqli_query($mysqli,"insert into sk (id_pegawai,id_kategori_sk,no_sk,tgl_sk,tmt) values ($idp,10,$kp,'$th8-$b8-$t8','$th9-$b9-$t9')");
$qe=mysqli_query($mysqli,"select id_sk,no_sk,nip_baru,nip_lama from sk inner join pegawai on pegawai.id_pegawai=sk.id_pegawai where sk.id_pegawai=$idp and id_kategori_sk=10 and tmt like '$th9%'");
	$e=mysqli_fetch_array($qe);	
	}
	
	if(substr($e[2],0,2)=='19')
	$nip=$e[2];
	else
	$nip=$e[3];
move_uploaded_file($fjab['tmp_name'],"sk/$fjab[name]");
rename("sk/$fjab[name]", "sk/$nip"."-"."$e[0]".".jpg");
mysqli_query($mysqli,"insert into berkas (id_pegawai,id_kat,nm_berkas,tgl_upload,tgl_berkas,byk_hal) values ($idp,2,'SK MUTASI JABATAN','$tgl','$th8-$b8-$t8',1)");
$qf=mysqli_query($mysqli,"select id_berkas from berkas order by id_berkas desc");
$foe=mysqli_fetch_array($qf);
mysqli_query($mysqli,"insert into isi_berkas (id_berkas,hal_ke,URL) values ($foe[0],1,'sk/$nip"."-"."$e[0]".".jpg')");
mysqli_query($mysqli,"update syarat_mutasi set id_berkas_mutasijabatan=$e[0] where id_pegawai=$idp and id_proses=1 and tglpengajuan='$tgl'");
mysqli_query($mysqli,"update sk set id_berkas=$foe[0] where id_sk=$e[0]"); 
}


//uraian tugas ----> udah bener
if($ut['size']>0)
{
if(substr($ata['nip_baru'],0,2)=='19')
	$nip=$ata['nip_baru'];
	else
	$nip=$ata['nip_lama'];
move_uploaded_file($ut['tmp_name'],"Berkas/$ut[name]");
mysqli_query($mysqli,"insert into berkas (id_pegawai,id_kat,nm_berkas,tgl_upload,tgl_berkas,byk_hal) values ($idp,7,'Uraian Tugas','$tgl','$thn-01-01',1)");
$qf=mysqli_query($mysqli,"select id_berkas from berkas order by id_berkas desc");
$foe=mysqli_fetch_array($qf);
mysqli_query($mysqli,"insert into isi_berkas (id_berkas,hal_ke) values ($foe[0],1)");
$qf2=mysqli_query($mysqli,"select id_isi_berkas from isi_berkas order by id_isi_berkas desc");
$fo=mysqli_fetch_array($qf2);

mysqli_query($mysqli,"update isi_berkas set URL='Berkas/$nip"."-"."$foe[0]"."-"."$fo[0]".".jpg' where id_isi_berkas=$fo[0]");
mysqli_query($mysqli,"update syarat_mutasi set id_berkas_uraiantugas=$foe[0] where id_pegawai=$idp and id_proses=1 and tglpengajuan='$tgl'");
rename("Berkas/$ut[name]", "Berkas/$nip"."-"."$foe[0]"."-$fo[0]".".jpg");
}

//ujian dinas
if($ud['size']>0)
{
if(substr($ata['nip_baru'],0,2)=='19')
	$nip=$ata['nip_baru'];
	else
	$nip=$ata['nip_lama'];
move_uploaded_file($ud['tmp_name'],"Berkas/$ud[name]");
mysqli_query($mysqli,"insert into berkas (id_pegawai,id_kat,nm_berkas,tgl_upload,tgl_berkas,byk_hal) values ($idp,21,'Ujian Dinas','$tgl','$thn-01-01',1)");
$qf=mysqli_query($mysqli,"select id_berkas from berkas order by id_berkas desc");
$foe=mysqli_fetch_array($qf);
mysqli_query($mysqli,"insert into isi_berkas (id_berkas,hal_ke) values ($foe[0],1)");
$qf2=mysqli_query($mysqli,"select id_isi_berkas from isi_berkas order by id_isi_berkas desc");
$fo=mysqli_fetch_array($qf2);

mysqli_query($mysqli,"update isi_berkas set URL='Berkas/$nip"."-"."$foe[0]"."-"."$fo[0]".".jpg' where id_isi_berkas=$fo[0]");
mysqli_query($mysqli,"update syarat_mutasi set id_berkas_udin=$foe[0] where id_pegawai=$idp and id_proses=1 and tglpengajuan='$tgl'");
rename("Berkas/$ud[name]", "Berkas/$nip"."-"."$foe[0]"."-$fo[0]".".jpg");
}

//penyesuaian ijazah  
if($pi['size']>0)
{
if(substr($ata['nip_baru'],0,2)=='19')
	$nip=$ata['nip_baru'];
	else
	$nip=$ata['nip_lama'];
move_uploaded_file($pi['tmp_name'],"Berkas/$pi[name]");
mysqli_query($mysqli,"insert into berkas (id_pegawai,id_kat,nm_berkas,tgl_upload,tgl_berkas,byk_hal) values ($idp,19,'Penyesuaian Ijazah','$tgl','$thn-01-01',1)");
$qf=mysqli_query($mysqli,"select id_berkas from berkas order by id_berkas desc");
$foe=mysqli_fetch_array($qf);
mysqli_query($mysqli,"insert into isi_berkas (id_berkas,hal_ke) values ($foe[0],1)");
$qf2=mysqli_query($mysqli,"select id_isi_berkas from isi_berkas order by id_isi_berkas desc");
$fo=mysqli_fetch_array($qf2);

mysqli_query($mysqli,"update isi_berkas set URL='Berkas/$nip"."-"."$foe[0]"."-"."$fo[0]".".jpg' where id_isi_berkas=$fo[0]");
mysqli_query($mysqli,"update syarat_mutasi set id_berkas_pi=$foe[0] where id_pegawai=$idp and id_proses=1 and tglpengajuan='$tgl'");
rename("Berkas/$pi[name]", "Berkas/$nip"."-"."$foe[0]"."-$fo[0]".".jpg");
}


// alih tugas
if($fat['size']>0)
{
$t6=substr($tat,0,2);
	$b6=substr($tat,3,2);
	$th6=substr($tat,6,4);

$t7=substr($tmtat,0,2);
	$b7=substr($tmtat,3,2);
	$th7=substr($tmtat,6,4);
	
$q1=mysqli_query($mysqli,"select count(*) from sk where id_pegawai=$idp and id_kategori_sk=1 and tmt like '$th7%' ");	
	$c1=mysqli_fetch_array($q1);
	if($c1[0]>0)
	{
	$qd=mysqli_query($mysqli,"select id_sk,no_sk,nip_baru,nip_lama from sk inner join pegawai on pegawai.id_pegawai=sk.id_pegawai where id_pegawai=$idp and id_kategori_sk=1 and tmt like '$th7%'");
	$d=mysqli_fetch_array($qd);	
	}
	else
	{
	$t6=substr($tat,0,2);
	$b6=substr($tat,3,2);
	$th6=substr($tat,6,4);

$t7=substr($tmtat,0,2);
	$b7=substr($tmtat,3,2);
	$th7=substr($tmtat,6,4);
	
		mysqli_query($mysqli,"insert into sk (id_pegawai,id_kategori_sk,no_sk,tgl_sk,tmt) values ($idp,1,$at,'$th6-$b6-$t6','$th7-$b7-$t7')");
$qd=mysqli_query($mysqli,"select id_sk,no_sk,nip_baru,nip_lama from sk inner join pegawai on pegawai.id_pegawai=sk.id_pegawai where sk.id_pegawai=$idp and id_kategori_sk=1 and tmt like '$th7%'");
	$d=mysqli_fetch_array($qd);	
	}
	
	if(substr($d[2],0,2)=='19')
	$nip=$d[2];
	else
	$nip=$d[3];
move_uploaded_file($fat['tmp_name'],"sk/$fat[name]");
rename("sk/$fat[name]", "sk/$nip"."-"."$d[0]".".jpg");
mysqli_query($mysqli,"insert into berkas (id_pegawai,id_kat,nm_berkas,tgl_upload,tgl_berkas,byk_hal) values ($idp,2,'SK ALIH TUGAS','$tgl','$th6-$b6-$t6',1)");
$qf=mysqli_query($mysqli,"select id_berkas from berkas order by id_berkas desc");
$foe=mysqli_fetch_array($qf);
mysqli_query($mysqli,"insert into isi_berkas (id_berkas,hal_ke,URL) values ($foe[0],1,'sk/$nip"."-"."$d[0]".".jpg')");
mysqli_query($mysqli,"update syarat_mutasi set id_berkas_alihtugas=$d[0] where id_pegawai=$idp and id_proses=1 and tglpengajuan='$tgl'");
mysqli_query($mysqli,"update sk set id_berkas=$foe[0] where id_sk=$d[0]");
}


//kenaikan pangkat
if($fkp['size']>0)
{
$t4=substr($tkp,0,2);
	$b4=substr($tkp,3,2);
	$th4=substr($tkp,6,4);

$t5=substr($tmtkp,0,2);
	$b5=substr($tmtkp,3,2);
	$th5=substr($tmtkp,6,4);
	
$q1=mysqli_query($mysqli,"select count(*) from sk where id_pegawai=$idp and id_kategori_sk=5 and tmt like '$th5%' ");	
	$c1=mysqli_fetch_array($q1);
	if($c1[0]>0)
	{
	$qc=mysqli_query($mysqli,"select id_sk,no_sk,nip_baru,nip_lama from sk inner join pegawai on pegawai.id_pegawai=sk.id_pegawai where sk.id_pegawai=$idp and id_kategori_sk=5 and tmt like '$th5%'");

	$c=mysqli_fetch_array($qc);	
	}
	else
	{$t4=substr($tkp,0,2);
	$b4=substr($tkp,3,2);
	$th4=substr($tkp,6,4);

$t5=substr($tmtkp,0,2);
	$b5=substr($tmtkp,3,2);
	$th5=substr($tmtkp,6,4);
	
		mysqli_query($mysqli,"insert into sk (id_pegawai,id_kategori_sk,no_sk,tgl_sk,tmt) values ($idp,5,'$kp','$th4-$b4-$t4','$th5-$b5-$t5')");
		//echo("insert into sk (id_pegawai,id_kategori_sk,no_sk,tgl_sk,tmt) values ($idp,5,$kp,'$th4-$b4-$t4','$th5-$b5-$t5')");
$qc=mysqli_query($mysqli,"select id_sk,no_sk,nip_baru,nip_lama from sk inner join pegawai on pegawai.id_pegawai=sk.id_pegawai where sk.id_pegawai=$idp and id_kategori_sk=5 and tmt like '$th5%'");
	$c=mysqli_fetch_array($qc);	
	}
	
	if(substr($c[2],0,2)=='19')
	$nip=$c[2];
	else
	$nip=$c[3];
move_uploaded_file($fkp['tmp_name'],"sk/$fkp[name]");
rename("sk/$fkp[name]", "sk/$nip"."-"."$c[0]".".jpg");
mysqli_query($mysqli,"insert into berkas (id_pegawai,id_kat,nm_berkas,tgl_upload,tgl_berkas,byk_hal) values ($idp,2,'SK KENAIKAN PANGKAT','$tgl','$th4-$b4-$t4',1)");
$qf=mysqli_query($mysqli,"select id_berkas from berkas order by id_berkas desc");
$foe=mysqli_fetch_array($qf);
mysqli_query($mysqli,"insert into isi_berkas (id_berkas,hal_ke,URL) values ($foe[0],1,'sk/$nip"."-"."$c[0]".".jpg')");
mysqli_query($mysqli,"update syarat_mutasi set id_berkas_sknaikpangkat=$c[0] where id_pegawai=$idp and id_proses=1 and tglpengajuan='$tgl'");
mysqli_query($mysqli,"update sk set id_berkas=$foe[0] where id_sk=$c[0]");


}

//sttpl  -------> udah bener
if($fsttp['size']>0)
{
	
$q1=mysqli_query($mysqli,"select count(*) from sertifikat where id_pegawai=$idp and nama_sertifikat like '%sttpl%'");	
	$c1=mysqli_fetch_array($q1);
	if($c1[0]>0)
	{
		$t3=substr($tsttp,0,2);
	$b3=substr($tsttp,3,2);
	$th3=substr($tsttp,6,4);
	$qb=mysqli_query($mysqli,"select id_sertifikat,nip_baru,nip_lama from sertifikat inner join pegawai on pegawai.id_pegawai=sertifikat.id_pegawai where sertifikat.id_pegawai=$idp");
	$b=mysqli_fetch_array($qb);	
	}
	else
	{$t3=substr($tsttp,0,2);
	$b3=substr($tsttp,3,2);
	$th3=substr($tsttp,6,4);

	
		mysqli_query($mysqli,"insert into sertifikat (id_pegawai,nama_sertifikat,lembaga_pembuat_sertifikat,tgl_sertifikat) values ($idp,'STTPL','Badan Diklat Daerah Prov','$th3-$b3-$t3')");
$qb=mysqli_query($mysqli,"select id_sertifikat,nip_baru,nip_lama from sertifikat inner join pegawai on pegawai.id_pegawai=sertifikat.id_pegawai where sertifikat.id_pegawai=$idp ");

	$b=mysqli_fetch_array($qb);	
	}	
if(substr($b[1],0,2)=='19')
	$nip=$b[1];
	else
	$nip=$b[2];
move_uploaded_file($fsttp['tmp_name'],"Berkas/$fsttp[name]");
mysqli_query($mysqli,"insert into berkas (id_pegawai,id_kat,nm_berkas,tgl_upload,tgl_berkas,byk_hal) values ($idp,17,'STTPL','$tgl','$th3-$b3-$t3',1)");
$qf=mysqli_query($mysqli,"select id_berkas from berkas order by id_berkas desc");
$foe=mysqli_fetch_array($qf);
mysqli_query($mysqli,"insert into isi_berkas (id_berkas,hal_ke) values ($foe[0],1)");
$qf2=mysqli_query($mysqli,"select id_isi_berkas from isi_berkas order by id_isi_berkas desc");
$fo=mysqli_fetch_array($qf2);

mysqli_query($mysqli,"update isi_berkas set URL='Berkas/$nip"."-"."$b[0]"."-"."$fo[0]".".jpg' where id_berkas=$foe[0]");
mysqli_query($mysqli,"update syarat_mutasi set id_berkas_sttpl=$b[0] where id_pegawai=$idp and id_proses=1 and tglpengajuan='$tgl'");
rename("Berkas/$fsttp[name]", "Berkas/$nip"."-"."$b[0]"."-$fo[0]".".jpg");



}


//karpeg ---> udah bener
if($fkarpeg['size']>0)
{
	mysqli_query($mysqli,"update pegawai set no_karpeg='$karpeg' where id_pegawai=$ata[0]");
if(substr($ata['nip_baru'],0,2)=='19')
	$nip=$ata['nip_baru'];
	else
	$nip=$ata['nip_lama'];
move_uploaded_file($fkarpeg['tmp_name'],"Berkas/$fkarpeg[name]");
mysqli_query($mysqli,"insert into berkas (id_pegawai,id_kat,nm_berkas,tgl_upload,tgl_berkas,byk_hal) values ($idp,10,'Kartu Pegawai','$tgl','$thn-01-01',1)");
$qf=mysqli_query($mysqli,"select id_berkas from berkas order by id_berkas desc");
$foe=mysqli_fetch_array($qf);
mysqli_query($mysqli,"insert into isi_berkas (id_berkas,hal_ke) values ($foe[0],1)");
$qf2=mysqli_query($mysqli,"select id_isi_berkas from isi_berkas order by id_isi_berkas desc");
$fo=mysqli_fetch_array($qf2);

mysqli_query($mysqli,"update isi_berkas set URL='Berkas/$nip"."-"."$foe[0]"."-"."$fo[0]".".jpg' where id_berkas=$foe[0]");
mysqli_query($mysqli,"update syarat_mutasi set id_berkas_karpeg=$foe[0] where id_pegawai=$idp and id_proses=1 and tglpengajuan='$tgl'");
rename("Berkas/$fkarpeg[name]", "Berkas/$nip"."-"."$foe[0]"."-$fo[0]".".jpg");
}


// ijazah --> udah bener
if($fij['size']>0)
{
if(substr($ata['nip_baru'],0,2)=='19')
	$nip=$ata['nip_baru'];
	else
	$nip=$ata['nip_lama'];
move_uploaded_file($fij['tmp_name'],"Berkas/$fij[name]");
mysqli_query($mysqli,"insert into berkas (id_pegawai,id_kat,nm_berkas,tgl_upload,tgl_berkas,byk_hal) values ($idp,20,'Ijazah','$tgl','$thn-01-01',1)");
$qf=mysqli_query($mysqli,"select id_berkas from berkas order by id_berkas desc");
$foe=mysqli_fetch_array($qf);
mysqli_query($mysqli,"insert into isi_berkas (id_berkas,hal_ke) values ($foe[0],1)");
$qf2=mysqli_query($mysqli,"select id_isi_berkas from isi_berkas order by id_isi_berkas desc");
$fo=mysqli_fetch_array($qf2);

mysqli_query($mysqli,"update isi_berkas set URL='Berkas/$nip"."-"."$foe[0]"."-"."$fo[0]".".jpg' where id_berkas=$foe[0]");
mysqli_query($mysqli,"update syarat_mutasi set id_berkas_ijazah=$foe[0] where id_pegawai=$idp and id_proses=1 and tglpengajuan='$tgl'");
rename("Berkas/$fij[name]", "Berkas/$nip"."-"."$foe[0]"."-$fo[0]".".jpg");
}



//dp3 1 --> udah bener

if($fdp3a['size']>0)
{
if(substr($ata['nip_baru'],0,2)=='19')
	$nip=$ata['nip_baru'];
	else
	$nip=$ata['nip_lama'];
move_uploaded_file($fdp3a['tmp_name'],"Berkas/$fdp3a[name]");
mysqli_query($mysqli,"insert into berkas (id_pegawai,id_kat,nm_berkas,tgl_upload,tgl_berkas,byk_hal) values ($idp,20,'DP3','$tgl','$thn-01-01',1)");
$qf=mysqli_query($mysqli,"select id_berkas from berkas order by id_berkas desc");
$foe=mysqli_fetch_array($qf);
mysqli_query($mysqli,"insert into isi_berkas (id_berkas,hal_ke) values ($foe[0],1)");
$qf2=mysqli_query($mysqli,"select id_isi_berkas from isi_berkas order by id_isi_berkas desc");
$fo=mysqli_fetch_array($qf2);

mysqli_query($mysqli,"update isi_berkas set URL='Berkas/$nip"."-"."$foe[0]"."-"."$fo[0]".".jpg' where id_berkas=$foe[0]");
mysqli_query($mysqli,"update syarat_mutasi set id_berkas_dp31=$foe[0] where id_pegawai=$idp and id_proses=1 and tglpengajuan='$tgl'");
rename("Berkas/$fdp3a[name]", "Berkas/$nip"."-"."$foe[0]"."-$fo[0]".".jpg");
}

// dp3b ---> udah bener
if($fdp3b['size']>0)
{
if(substr($ata['nip_baru'],0,2)=='19')
	$nip=$ata['nip_baru'];
	else
	$nip=$ata['nip_lama'];
move_uploaded_file($fdp3b['tmp_name'],"Berkas/$fdp3b[name]");
mysqli_query($mysqli,"insert into berkas (id_pegawai,id_kat,nm_berkas,tgl_upload,tgl_berkas,byk_hal) values ($idp,20,'DP3','$tgl','$thn-01-01',1)");
$qf=mysqli_query($mysqli,"select id_berkas from berkas order by id_berkas desc");
$foe=mysqli_fetch_array($qf);
mysqli_query($mysqli,"insert into isi_berkas (id_berkas,hal_ke) values ($foe[0],1)");
$qf2=mysqli_query($mysqli,"select id_isi_berkas from isi_berkas order by id_isi_berkas desc");
$fo=mysqli_fetch_array($qf2);

mysqli_query($mysqli,"update isi_berkas set URL='Berkas/$nip"."-"."$foe[0]"."-"."$fo[0]".".jpg' where id_berkas=$foe[0]");
mysqli_query($mysqli,"update syarat_mutasi set id_berkas_dp32=$foe[0] where id_pegawai=$idp and id_proses=1 and tglpengajuan='$tgl'");
rename("Berkas/$fdp3b[name]", "Berkas/$nip"."-"."$foe[0]"."-$fo[0]".".jpg");
}

echo("<div align=center>Data Anda Sudah Diupload dan Akan Kami Proses </div>");
}
else
{
echo("<div align=center>dokumen yang diajukan belum lengkap silakan dilengkapi kembali</div>	");
include("formpangkat.php");	
}
?>
