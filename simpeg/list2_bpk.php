<?php $unit_kerja = new Unit_kerja; ?>

<div class="panel panel-default">
	<div class="panel-body">
<h4>DAFTAR PEGAWAI <?php echo $unit_kerja->get_unit_kerja($unit['id_skpd'])->singkatan ?></h4>

<!--a href="#" class="btn btn-primary  hidden-print pull-right" onclick="window.print()">cetak</a></h2-->

<?php

$es = mysqli_query($mysqli,"select j.eselon from pegawai p
			 inner join jabatan j on j.id_j = p.id_j
			 where p.id_pegawai = $ata[id_pegawai]");
$es = mysqli_fetch_array($es);

if($es[0] == "V")
{
	$qo=mysqli_query($mysqli,"select DISTINCT p.nama, p.nip_baru, p.pangkat_gol, u.nama_baru, k.* \n"
    . "from pegawai p \n"
    . "inner join buffer_kelengkapan_berkas k on k.id_pegawai = p.id_pegawai \n"
    . "inner join current_lokasi_kerja c on c.id_pegawai = p.id_pegawai\n"
    . "inner join unit_kerja u on u.id_unit_kerja = c.id_unit_kerja\n"
    . "where flag_pensiun = 0 and u.id_unit_kerja = $unit[0]\n"
	. "order by p.pangkat_gol desc, p.tgl_lahir");
}
else
{
$qo=mysqli_query($mysqli,"select DISTINCT p.id_pegawai, vpt.golongan, p.jenjab, p.gelar_depan, p.nama, p.gelar_belakang, p.nip_baru, p.pangkat_gol, p.id_j, p.jabatan, u.nama_baru, p.alamat "
    . "from pegawai p inner join view_pangkat_terakhir vpt on vpt.id_pegawai = p.id_pegawai\n"
    . "left join current_lokasi_kerja c on c.id_pegawai = p.id_pegawai\n"
    . "inner join unit_kerja u on u.id_unit_kerja = c.id_unit_kerja\n"
    . "where flag_pensiun = 0 and u.id_skpd = $unit[id_skpd] \n"
	. "order by p.pangkat_gol desc, p.tgl_lahir");
}



?>
<table id="list_pegawai" class="table table-bordered display" cellspacing="0" width="100%">
	<thead>
		<tr>
			<th>Id Pegawai</th>
			<th>Nama</th>
			<th>NIP</th>
			<th>Gol</th>
			<!--th class="hidden-print">New Gol<span style="color:red">*</span></th-->
			<th>Jabatan</th>


		</tr>
	</thead>
	<tbody>
		<?php
			$r=1;
			$jabatan = '';
			while($bata=mysqli_fetch_array($qo)){

				if($bata[id_j]!=NULL && $bata[jenjab] == 'Struktural'){

					$qjo=mysqli_query($mysqli,"select jabatan,eselon from jabatan where id_j=$bata[id_j]");

					$ahab=mysqli_fetch_array($qjo)[0];

				}elseif($bata[id_j] == NULL && $bata[jenjab] == 'Struktural'){

					$sql = "select jfu_pegawai.*, jfu_master.*
							from jfu_pegawai, jfu_master
							where jfu_pegawai.id_pegawai = '".$bata['id_pegawai']."'
							and jfu_master.kode_jabatan = jfu_pegawai.kode_jabatan";

					$qjo=mysqli_query($mysqli,$sql);

					$ahab=mysqli_fetch_array($qjo)['nama_jfu'];
				}else{

					$ahab = $bata[jabatan];

				}

				$nama_full = $bata[gelar_depan] ? $bata[gelar_depan].' '.$bata[nama] : $bata[nama];
				$nama_full .= $bata[gelar_belakang] ? ', '.$bata[gelar_belakang] : '' ;


					$last_gol_query = "select *
										from sk
										where id_pegawai = '".$bata['id_pegawai']."'
										and id_kategori_sk in ('5','6')
										and tmt = (select max(tmt) from sk where id_kategori_sk in ('5','6') and id_pegawai = '".$bata['id_pegawai']."' )";

				$last_gol = mysqli_fetch_array(mysqli_query($mysqli,$last_gol_query))['keterangan'];

		?>
		<tr>
			<td><?php echo $bata["id_pegawai"] ?></td>
			<td><?php echo $nama_full ?></td>
			<td><?php echo $bata["nip_baru"] ?></td>
			<td><?php echo $bata["golongan"] ?></td>
			<!--td class="hidden-print"><?php //echo $last_gol ?></td-->
			<td><?php echo $ahab ?></td>
		</tr>
		<?php $r++; } ?>


	</tbody>
</table>
</div>
</div>
<p>
	<span style="color:red">*</span> Golongan berdasarkan data riwayat pangkat/sk yang sudah di input
</p>
<p>
	<span style="color:red">*</span> Sinkronisasi Nilai SKP dilakukan secara berkala
</p>
<script>
$(document).ready(function() {
	$('#list_pegawai').dataTable({
       "dom": 'T<"clear">lfrtip',
        "tableTools": {
            "sSwfPath": "assets/DataTables/extensions/TableTools/swf/copy_csv_xls_pdf.swf"
        }
    });



});
</script>
