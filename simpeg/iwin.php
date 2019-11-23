
<?php
include("konek.php");
$q=mysqli_query($mysqli,"select pegawai.id_pegawai as id,
	nama,
	concat('\`',nip_baru) as nip,
	pegawai.email,
	concat('\`',nip_baru) as username,
	md5(substring(nip_baru,1,4)) as password,id_skpd from pegawai inner join current_lokasi_kerja on current_lokasi_kerja.id_pegawai=pegawai.id_pegawai inner join unit_kerja on unit_kerja.id_unit_kerja=current_lokasi_kerja.id_unit_kerja where flag_pensiun=0");
	
	echo("<table width=100% cellpadding=5 cellspacing=0 border=0><tr>");
	echo("<td> No </td><td> Id_pegawai</td><td> Nama</td><td> NIP</td><td> Email</td><td> USername</td><td> Password</td><td> Jabatan</td><td nowrap> ID Jabatan</td></tr>");
	$i=1;
	while($data=mysqli_fetch_array($q))
	{
	echo("<tr>");
	echo("<td> $i</td> <td> $data[0]</td><td> $data[1]</td><td> $data[2]</td><td> $data[3]</td><td> $data[4]</td><td> $data[5]</td><td> $data[6]</td>");
	$qmax=mysqli_query($mysqli,"select id_j,min(eselon) from jabatan  where id_unit_kerja=$data[6] and tahun=2011 group by id_j");
	$max=mysqli_fetch_array($qmax);
	echo("<td> $max[0] </td>");
	echo("</tr>");
	$i++;
	}
	
	
	echo("</table>");
	
	
?>