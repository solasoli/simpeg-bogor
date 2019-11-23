<?php
session_start();

include("konek.php");

$u = mysqli_real_escape_string($mysqli, $_POST['u']);
$p = mysqli_real_escape_string($mysqli, $_POST['p']);

$q = mysqli_query($mysqli, "select * from pegawai where (nip_lama='$u' or nip_baru='$u') and password ='$p' and flag_pensiun <> 1");
//echo("select * from pegawai where (nip_lama='$u' or nip_baru='$u') and password ='$p' ");

$cek = mysqli_fetch_array($q);

if(mysqli_num_rows($q))
{
	$_SESSION['user'] = $u;
	$_SESSION['passx'] = md5($p);
	$_SESSION['nip_baru'] = $cek[nip_baru];
	$_SESSION['id_pegawai'] = $cek['id_pegawai'];
	$qunit=mysqli_query($mysqli, "select unit_kerja.id_unit_kerja,
				unit_kerja.nama_baru,
				unit_kerja.id_skpd,
				uk2.nama_baru as nama_skpd
				from unit_kerja
				inner join unit_kerja uk2 on uk2.id_unit_kerja = unit_kerja.id_skpd
				inner join current_lokasi_kerja on current_lokasi_kerja.id_unit_kerja = unit_kerja.id_unit_kerja
				inner join pegawai on pegawai.id_pegawai=current_lokasi_kerja.id_pegawai
				where pegawai.id_pegawai=$cek[id_pegawai]");
	$unit=mysqli_fetch_array($qunit);
	$_SESSION['id_unit'] = $unit[0];
	$_SESSION['opd'] = $unit[1];
	$_SESSION['id_skpd'] = $unit[2];
	$_SESSION['nama_skpd'] = $unit['nama_skpd'];

	$lengkap_sql = "select distinct p.id_pegawai,
				TRIM(IF(LENGTH(p.gelar_belakang) > 1,
						CONCAT(p.gelar_depan,
								' ',
								p.nama,
								CONCAT(', ', p.gelar_belakang)),
						CONCAT(p.gelar_depan, ' ', p.nama))) AS nama, p.jenjab,
						concat(p.tempat_lahir,', ',date_format(p.tgl_lahir,'%d-%m-%Y')) as TTL,
						p.nip_baru as nip,
						g.pangkat,
						vpt.golongan,
						vpt.tmt as tmt_golongan,
						uk.id_unit_kerja,
						uk.nama_baru as opd,
						IF(p.id_j is not NULL, j.jabatan,
							IF(p.jenjab like 'Struktural', jfu_master.nama_jfu,  jafung_pegawai.jabatan)
						) as jabatan,p.jenjab,p.id_j, p.is_kepsek
				from pegawai p
				inner join view_pangkat_terakhir vpt on p.id_pegawai = vpt.id_pegawai
				inner join golongan g on vpt.golongan = g.golongan
				inner join current_lokasi_kerja clk on clk.id_pegawai = p.id_pegawai
				inner join unit_kerja uk on uk.id_unit_kerja = clk.id_unit_kerja
				left join jabatan j on j.id_j = p.id_j
				left join  (
					select * from jfu_pegawai where id_pegawai = ".$_SESSION['id_pegawai']." and tmt =
					(select max(tmt) from jfu_pegawai where id_pegawai = ".$_SESSION['id_pegawai'].")
					) jfu_pegawai on jfu_pegawai.id_pegawai = p.id_pegawai
				left join jfu_master on jfu_master.kode_jabatan= jfu_pegawai.kode_jabatan
				left join jafung_pegawai on jafung_pegawai.id_pegawai = p.id_pegawai


				where p.id_pegawai = ".$_SESSION['id_pegawai'];

	$lengkap = mysqli_fetch_object(mysqli_query($mysqli, $lengkap_sql));

	$_SESSION['profil'] = $lengkap;

	$role_sql = "select * from user_roles where id_pegawai = ".$cek['id_pegawai'];
	$role_result = mysqli_query($mysqli, $role_sql);
	$i = 0;
	while($role_row = mysqli_fetch_array($role_result)){
		$_SESSION['role'][$i] = $role_row[1];
		$i++;
	}

	mysqli_query($mysqli, "update pegawai set my_status='online' where id_pegawai= $cek[id_pegawai]");
	header('location:index3.php');
}
else
{
	//echo("<div align=center class='error'>username atau password salah </div><br>");
	//include("index.php");
	header("Location: http://simpeg.kotabogor.net/simpeg/index.php?login-error=true");
	exit();
}
?>
