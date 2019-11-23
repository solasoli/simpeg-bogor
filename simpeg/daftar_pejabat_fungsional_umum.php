<H1>DAFTAR PEJABAT FUNGSIONAL UMUM</H1>

<?php
$qDaftar = "SELECT  p.id_pegawai, p.nama, p.nip_baru, jm.nama_jfu, p.pangkat_gol, u.nama_baru
		FROM pegawai p
		inner join current_lokasi_kerja c on p.id_pegawai=c.id_pegawai
		inner join unit_kerja u on c.id_unit_kerja = u.id_unit_kerja
		left join jfu_pegawai jf on p.id_pegawai=jf.id_pegawai
		left join jfu_master jm on jf.kode_jabatan =jm.kode_jabatan
		where flag_pensiun =0 and jenjab like '%struktural%' and id_j is null
		ORDER by pangkat_gol desc, p.jabatan";


$rDaftar = mysqli_query($mysqli,$qDaftar);

$no=1;
?>
<table BORDER="1" >
<thead>
	<th><center>NO</center></th>
	<th><center>NAMA</center></th>
	<th><center>NIP</center></th>
	<th><center>Jabatan</center></th>
	<th><center>Golongan</center></th>
	<th><center>TMT Golongan, Masa Kerja Golongan</center></th>
	<th><center>Unit Kerja</center></th>
</thead>
<tbody>
<? while($r = mysqli_fetch_array($rDaftar)):
$last_gol_query = "select *
									from sk
									where id_pegawai = '".$r['id_pegawai']."'
									and id_kategori_sk in ('5','6')
									and tmt = (select max(tmt) from sk where id_kategori_sk in ('5','6') and id_pegawai = '".$r['id_pegawai']."' )";
				//var_dump($last_gol_query);
				//echo "</br>";
				$last_gol = mysqli_fetch_array(mysqli_query($mysqli,$last_gol_query))['keterangan'];
				$tmt_last = mysqli_fetch_array(mysqli_query($mysqli,$last_gol_query))['tmt'];
				?>
	<tr>
		<td><?php echo $no++?></td>
		<td><?php echo $r['nama']; ?></td>
		<td><?php echo $r['nip_baru']; ?></td>
		<td><?php echo $r['nama_jfu']; ?></td>
		<td><center><?php echo $r['pangkat_gol']; ?></center></td>
		<td><?php echo $last_gol.' - '.$tmt_last; ?></td>
		<td><?php echo $r['nama_baru']; ?></td>
	</tr>
<? endwhile; ?>
</tbody>
</table>
