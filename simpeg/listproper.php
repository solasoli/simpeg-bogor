<div class="panel panel-default">
	<div class="panel-body">
<h4>DAFTAR PROYEK PERUBAHAN</h4>

<!--a href="#" class="btn btn-primary  hidden-print pull-right" onclick="window.print()">cetak</a></h2-->

<?php


$qo = mysqli_query($mysqli,"select * from proper order by tahun desc,tingkat");

?>
<table id="list_pegawai" class="table table-bordered display" cellspacing="0" width="100%">
	<thead>
		<tr>
			<th>Foto</th>
			<th>Nama</th>
			<th>Judul Proyek Perubahan</th>
			<th>Diklat Pim Tingkat</th>
			<!--th class="hidden-print">New Gol<span style="color:red">*</span></th-->
			<th>Tahun </th>

			<th class="hidden-print">Dokumen Proyek Perubahan</th>
		</tr>
	</thead>
	<tbody>
		<?php
			$r=1;

			while($data=mysqli_fetch_array($qo)){

			if (file_exists("./foto/$data[id_pegawai].jpg"))
	$gambar="<img src=./foto/$data[id_pegawai].jpg width=75 />";
else if (file_exists("./foto/$data[id_pegawai].JPG"))
	$gambar="<img src=./foto/$data[id_pegawai].JPG width=75 />";
else
{
if(@$data['jenis_kelamin']=='1')
	$gambar="<img src=./images/male.jpg width=75 />";
else
	$gambar="<img src=./images/female.jpg width=75 />";
}

$qpeserta=mysqli_query($mysqli,"select concat(gelar_depan,' ',nama,' ',gelar_belakang) as nama from pegawai where id_pegawai=$data[id_pegawai]");
$peserta=mysqli_fetch_array($qpeserta);
				?>
		<tr>
			<td><?php echo $gambar; ?></td>
			<td><?php echo $peserta[0]; ?></td>
			<td><?php echo $data[3]; ?></td>
			<td><?php echo $data[7]; ?></td>
			<td><?php echo $data[8]; ?></td>


			<td >
            <?php

				echo("<a href='http://103.14.229.15/simpeg/proper/".$data[0].".pdf' target=_blank> Download </a>");

?>
                        </td>

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
