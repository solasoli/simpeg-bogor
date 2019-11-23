<?php
include("koncil.php");
extract($_POST);
if($n!=NULL and ($nl!=NULL or $nb!=NULL))
{
$t1=substr($tgl,0,2);
$b1=substr($tgl,3,2);
$th1=substr($tgl,6,4);

$qInsert = "insert into pegawai ( 
			nama,
			gelar_depan,
			gelar_belakang,
			nip_baru,
			nip_lama,
			agama,
			tempat_lahir,
			tgl_lahir,
			jenis_kelamin,
			no_karpeg,
			alamat,
			kota,
			gol_darah,
			telepon,
			ponsel,status_pegawai,pangkat_gol,nama_pendek,jenjab,jabatan,email, password, status_aktif, flag_provinsi)
			values 
			('$n',
			'$gelar_depan',
			'$gelar_belakang',
			'$nb','$nl','$a',
			'$tl',
			'$th1-$b1-$t1','$jk','$karpeg','$al','$kota','$darah','$telp','$hp','PNS','$gol','$n','$jenjab','Fungsional Umum','$email', '$th1', 'Aktif', 0)";



			$qlem=mysqli_query($con,"select id from institusi_pendidikan where institusi like 
			'$lembaga%'");
			$lem=mysqli_fetch_array($qlem);
			if(!is_numeric($lem[0]))
			$lem[0]=0;
			
	if($tingkat=="S3")
	$lp=1;
	elseif($tingkat=="S2")
	$lp=2;
	elseif($tingkat=="S1")
	$lp=3;
	elseif($tingkat=="D4")
	$lp=3;
	elseif($tingkat=="D3")
	$lp=4;
	elseif($tingkat=="D2")
	$lp=5;
	elseif($tingkat=="D1")
	$lp=6;
	elseif($tingkat=="SMU/SMK/MA/SEDERAJAT")
	$lp=7;
	elseif($tingkat=="SMP/MTs/SEDERAJAT" or $tingkat=="SMP/SEDERAJAT")
	$lp=8;
	elseif($tingkat=="SD/SEDERAJAT")
	$lp=9;

			
			
//echo $qInsert;
if(mysqli_query($con,$qInsert)){
	$id=mysqli_insert_id($con);
	
	if(!is_numeric($lulusan))
	$lulusan=0;
	mysqli_query($con,"insert into pendidikan (id_pegawai,lembaga_pendidikan,tingkat_pendidikan,jurusan_pendidikan,tahun_lulus,level_p,id_bidang,id_institusi) values ($id,'$lembaga','$tingkat','$jurusan',$lulusan,$lp,$bidang,$lem[0])");
	
	
	
	
	echo("<div align=center> data pegawai $n sudah ditambahkan</div>");
}else{
	echo "Gagal menambah pegawai" ;
}
//

//echo "insert into pegawai (nama,nip_baru,nip_lama,agama,tempat_lahir,tgl_lahir,jenis_kelamin,no_karpeg,alamat,kota,gol_darah,telepon,ponsel,status_pegawai,pangkat_gol,nama_pendek,jenjab,jabatan,email, password, status_aktif) values ('$n','$nb','$nl','$a','$tl','$th1-$b1-$t1','$jk','$karpeg','$al','$kota','$darah','$telp','$hp','PNS','$gol','$n','$jenjab','Staf Pelaksana','$email', '$th1', 'Aktif')";

include("tambah.php");
}
else
{
echo("<div align=center>minimum harus ada nama, nip lama atau nip baru dan tanggal lahir  </div>");
include("tambah.php");

}
?>
