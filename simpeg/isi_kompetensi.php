<?php 

mysqli_connect("simpeg.db.kotabogor.net","simpeg", "Madangkara2017");
mysqli_select_db("simpeg");

//dari pendidikan
$q=mysqli_query($mysqli,"select id_pegawai from pegawai where flag_pensiun=0");
while($data=mysqli_fetch_array($q))
{
$qb=mysqli_query($mysqli,"select id_bidang,tahun_lulus from pendidikan where id_pegawai =$data[0] and level_p <=6");	
	while($bel=mysqli_fetch_array($qb))
	{
	if($bel[0]!=0 or $bel[0]!=44 )
		mysqli_query($mysqli,"insert into kompetensi (id_pegawai,id_sumber,id_bidang,tahun) values ($data[0],1,$bel[0],$bel[1])");
	
	}
}
/*
$q=mysqli_query($mysqli,"select id_pegawai,nama_diklat,tgl_diklat,id_diklat from diklat  where jenis_diklat like '%teknis%' and noted=0");
while($data=mysqli_fetch_array($q))
{
$thn=substr($data[2],0,4);	
$a=strtolower("$data[1]");
if (preg_match('/puskesmas/',$a) or preg_match('/imunisasi/',$a))
{
mysqli_query($mysqli,"insert into kompetensi (id_pegawai,id_sumber,id_bidang,tahun) values ($data[0],2,3,$thn)");
mysqli_query($mysqli,"update diklat set noted=1 where id_diklat=$data[3] ");
}

if (preg_match('/pengadaan/',$a) or preg_match('/proyek/',$a) or preg_match('/jasa konstruksi/',$a))
{mysqli_query($mysqli,"insert into kompetensi (id_pegawai,id_sumber,id_bidang,tahun) values ($data[0],2,49,$thn)");
mysqli_query($mysqli,"update diklat set noted=1 where id_diklat=$data[3] ");
}
if (preg_match('/kas/',$a) or preg_match('/bendahara/',$a) or preg_match('/keuangan/',$a) or preg_match('/keu/',$a) or preg_match('/pengelolaan barang/',$a) or preg_match('/penyimpan barang/',$a))
{mysqli_query($mysqli,"insert into kompetensi (id_pegawai,id_sumber,id_bidang,tahun) values ($data[0],2,50,$thn)");
mysqli_query($mysqli,"update diklat set noted=1 where id_diklat=$data[3] ");
}
if (preg_match('/pariwisata/',$a) )
{
mysqli_query($mysqli,"insert into kompetensi (id_pegawai,id_sumber,id_bidang,tahun) values ($data[0],2,46,$thn)");
mysqli_query($mysqli,"update diklat set noted=1 where id_diklat=$data[3] ");
}

if (preg_match('/akuntansi/',$a) )
{
mysqli_query($mysqli,"insert into kompetensi (id_pegawai,id_sumber,id_bidang,tahun) values ($data[0],2,6,$thn)");
mysqli_query($mysqli,"update diklat set noted=1 where id_diklat=$data[3] ");
}

if (preg_match('/kepegawaian/',$a) or preg_match('/sdm/',$a) or preg_match('/bebean kerja/',$a))
{
mysqli_query($mysqli,"insert into kompetensi (id_pegawai,id_sumber,id_bidang,tahun) values ($data[0],2,19,$thn)");
mysqli_query($mysqli,"update diklat set noted=1 where id_diklat=$data[3] ");
}

if (preg_match('/lakip/',$a) )
{
mysqli_query($mysqli,"insert into kompetensi (id_pegawai,id_sumber,id_bidang,tahun) values ($data[0],2,23,$thn)");
mysqli_query($mysqli,"update diklat set noted=1 where id_diklat=$data[3] ");
}

if (preg_match('/auditor/',$a) or preg_match('/audit/',$a) or preg_match('/apip/',$a) )
{
mysqli_query($mysqli,"insert into kompetensi (id_pegawai,id_sumber,id_bidang,tahun) values ($data[0],2,51,$thn)");
mysqli_query($mysqli,"update diklat set noted=1 where id_diklat=$data[3] ");
}

if (preg_match('/komputer/',$a) or preg_match('/teknologi informasi/',$a) )
{
mysqli_query($mysqli,"insert into kompetensi (id_pegawai,id_sumber,id_bidang,tahun) values ($data[0],2,1,$thn)");
mysqli_query($mysqli,"update diklat set noted=1 where id_diklat=$data[3] ");
}

if (preg_match('/statistik/',$a) )
{
mysqli_query($mysqli,"insert into kompetensi (id_pegawai,id_sumber,id_bidang,tahun) values ($data[0],2,22,$thn)");
mysqli_query($mysqli,"update diklat set noted=1 where id_diklat=$data[3] ");
}

if (preg_match('/bela negara/',$a) or preg_match('/Pemerintahan /',$a)  )
{
mysqli_query($mysqli,"insert into kompetensi (id_pegawai,id_sumber,id_bidang,tahun) values ($data[0],2,23,$thn)");
mysqli_query($mysqli,"update diklat set noted=1 where id_diklat=$data[3] ");
}

if (preg_match('/jupen/',$a) )
{
mysqli_query($mysqli,"insert into kompetensi (id_pegawai,id_sumber,id_bidang,tahun) values ($data[0],2,40,$thn)");
mysqli_query($mysqli,"update diklat set noted=1 where id_diklat=$data[3] ");
}

if (preg_match('/hukum/',$a) )
{
mysqli_query($mysqli,"insert into kompetensi (id_pegawai,id_sumber,id_bidang,tahun) values ($data[0],2,9,$thn)");
mysqli_query($mysqli,"update diklat set noted=1 where id_diklat=$data[3] ");
}

if (preg_match('/lingkungan hidup/',$a) )
{
mysqli_query($mysqli,"insert into kompetensi (id_pegawai,id_sumber,id_bidang,tahun) values ($data[0],2,24,$thn)");
mysqli_query($mysqli,"update diklat set noted=1 where id_diklat=$data[3] ");
}

if (preg_match('/humas/',$a) )
{
mysqli_query($mysqli,"insert into kompetensi (id_pegawai,id_sumber,id_bidang,tahun) values ($data[0],2,40,$thn)");
mysqli_query($mysqli,"update diklat set noted=1 where id_diklat=$data[3] ");
}

if (preg_match('/jalan/',$a) or preg_match('/LLAJ/',$a) or preg_match('/transportasi/',$a) or preg_match('/angkutan/',$a)  or preg_match('/perhubungan/',$a) or preg_match('/kendaraan/',$a))
{
mysqli_query($mysqli,"insert into kompetensi (id_pegawai,id_sumber,id_bidang,tahun) values ($data[0],2,27,$thn)");
mysqli_query($mysqli,"update diklat set noted=1 where id_diklat=$data[3] ");
}


if (preg_match('/administrasi/',$a) )
{
mysqli_query($mysqli,"insert into kompetensi (id_pegawai,id_sumber,id_bidang,tahun) values ($data[0],2,11,$thn)");
mysqli_query($mysqli,"update diklat set noted=1 where id_diklat=$data[3] ");
}

if (preg_match('/padi/',$a) )
{
mysqli_query($mysqli,"insert into kompetensi (id_pegawai,id_sumber,id_bidang,tahun) values ($data[0],2,8,$thn)");
mysqli_query($mysqli,"update diklat set noted=1 where id_diklat=$data[3] ");
}

if (preg_match('/teacher/',$a) or preg_match('/ktsp/',$a) or preg_match('/kurikulum/',$a) or preg_match('/mgmp/',$a)  or preg_match('/modul/',$a) or preg_match('/mutu pendidikan/',$a)   or preg_match('/rsbi/',$a) or preg_match('/sekolah/',$a) or preg_match('/guru/',$a) or preg_match('/bahasa inggris/',$a) or preg_match('/mkks/',$a) or preg_match('/Kependidikan/',$a) or preg_match('/SBI/',$a) or preg_match('/dikdas/',$a) )
{
mysqli_query($mysqli,"insert into kompetensi (id_pegawai,id_sumber,id_bidang,tahun) values ($data[0],2,4,$thn)");
mysqli_query($mysqli,"update diklat set noted=1 where id_diklat=$data[3] ");
}

}
*/
echo("done");
?>
