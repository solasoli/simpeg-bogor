

<div>
	<h4>Daftar Tim OPD</h4>
</div>
<p>
<?php
$qu=mysqli_query($mysqli,"select id_unit_kerja from current_lokasi_kerja where id_pegawai=$ata[id_pegawai]");
$unit = mysqli_fetch_array($qu);
?>
	
<?php

$es = mysqli_query($mysqli,"select j.eselon from pegawai p 
			 inner join jabatan j on j.id_j = p.id_j
			 where p.id_pegawai = $ata[id_pegawai]");
$es = mysqli_fetch_array($es);

if($es[0] == "V")
{
	$qo=mysqli_query($mysqli,"select p.nama, p.nip_baru, p.pangkat_gol, u.nama_baru, k.* \n"
    . "from pegawai p \n"
    . "inner join buffer_kelengkapan_berkas k on k.id_pegawai = p.id_pegawai \n"
    . "inner join current_lokasi_kerja c on c.id_pegawai = p.id_pegawai\n"
    . "inner join unit_kerja u on u.id_unit_kerja = c.id_unit_kerja\n"
    . "where flag_pensiun = 0 and u.id_unit_kerja = $unit[0]\n"
	. "order by p.pangkat_gol desc, p.tgl_lahir");
}
else
{
/*$qo=mysqli_query($mysqli,"select p.nama, p.nip_baru, p.pangkat_gol, u.nama_baru, k.* \n"
    . "from pegawai p \n"
    . "left join buffer_kelengkapan_berkas k on k.id_pegawai = p.id_pegawai \n"
    . "left join current_lokasi_kerja c on c.id_pegawai = p.id_pegawai\n"
    . "inner join unit_kerja u on u.id_unit_kerja = c.id_unit_kerja\n"
    . "where flag_pensiun = 0 and u.id_skpd = $unit[0]\n"
	. "order by p.pangkat_gol desc, p.tgl_lahir");
*/
$qo=mysqli_query($mysqli,"select p.id_pegawai, p.jenjab, p.nama, p.nip_baru, p.pangkat_gol, p.id_j, p.jabatan, u.nama_baru \n"
    . "from pegawai p \n"   
    . "left join current_lokasi_kerja c on c.id_pegawai = p.id_pegawai\n"
    . "inner join unit_kerja u on u.id_unit_kerja = c.id_unit_kerja\n"
    . "where flag_pensiun = 0 and u.id_skpd = $unit[0]\n"
	. "order by p.pangkat_gol desc, p.tgl_lahir");
	
	
//$qo=mysqli_query($mysqli,'select * from ');
}


echo("<table class='table' cellpadding=5 cellspacing=0 border=0 id='list_pegawai' class='display' >
	<tr bgcolor=#cccccc><td class=bodas>No</td>
		<td class=bodas>Nama </td><td class=bodas>NIP </td>
		<td class=bodas> Golongan </td><td class=bodas>Jabatan</td>
		<td class=bodas>unit kerja</td>
		<td class=bodas>Ponsel</td>
	</tr>");
$r=1;
$jabatan = '';
$tim_opd = mysqli_query($mysqli,"select user_roles.*, pegawai.nip_baru, pegawai.nama, pegawai.pangkat_gol, pegawai.id_j, pegawai.jenjab, u.nama_baru as unit_kerja, pegawai.ponsel 
						from user_roles 
						inner join pegawai on pegawai.id_pegawai = user_roles.id_pegawai
						inner join current_lokasi_kerja c on c.id_pegawai = pegawai.id_pegawai
						inner join unit_kerja u on u.id_unit_kerja = c.id_unit_kerja
						where role_id = 2
						order by pegawai.pangkat_gol DESC, pegawai.nip_baru ASC
						
						");
while($row = mysqli_fetch_array($tim_opd))
{
	if($row['id_j']!=NULL && $row['jenjab'] == 'Struktural')
	{ 
		$qjo=mysqli_query($mysqli,"select jabatan from jabatan where id_j=$row[id_j]");
		//echo("select jabatan from jabatan where id_j=$data[id_j]");
		$ahab=mysqli_fetch_array($qjo);
	}elseif($row['id_j'] == NULL && $row['jenjab'] == 'Struktural'){
		$sql = "select jfu_pegawai.*, jfu_master.* 
				from jfu_pegawai, jfu_master
				where jfu_pegawai.id_pegawai = '".$row['id_pegawai']."'
				and jfu_master.kode_jabatan = jfu_pegawai.kode_jabatan";
					
		$qjo=mysqli_query($mysqli,$sql);
		//echo("select jabatan from jabatan where id_j=$data[id_j]");
		$ahab=mysqli_fetch_array($qjo);
	}else{
		$ahab = @$row['jabatan'];	
	
	}	
	
	echo "<tr>";
	echo "<td>$r</td>";
		
	echo "<td>$row[nama]</td>";
	echo "<td>$row[nip_baru]</td>";
	echo "<td>$row[pangkat_gol]</td>";
	echo "<td>$ahab[0]</td>";
	echo "<td>$row[unit_kerja]</td>";
	echo "<td>'$row[ponsel]</td>";
	//echo "<td>$bata[nama_baru]</td>";
	
	echo "</tr>";
	$r++;
}
echo("</table>");

?>

