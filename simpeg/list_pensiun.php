<?php $unit_kerja = new Unit_kerja; ?>

<div class="panel panel-default">
	<div class="panel-body">
<h4>DAFTAR BATAS USIA PENSIUN PNS</h4>

<!--a href="#" class="btn btn-primary  hidden-print pull-right" onclick="window.print()">cetak</a></h2-->

<?php
extract($_GET);

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
    . "inner join unit_kerja u on u.id_unit_kerja = c.id_unit_kerja_t\n"
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

$qo = mysqli_query($mysqli,"select DISTINCT p.nama, p.id_pegawai from pegawai p
			inner join current_lokasi_kerja c on c.id_pegawai = p.id_pegawai
			inner join unit_kerja uk on uk.id_unit_kerja = c.id_unit_kerja
			 where p.flag_pensiun = 0 and uk.id_skpd = $unit[id_skpd] order by p.pangkat_gol DESC");

/* echo "select DISTINCT p.nama, p.id_pegawai from pegawai p
			inner join current_lokasi_kerja c on c.id_pegawai = p.id_pegawai
			inner join unit_kerja uk on uk.id_unit_kerja = c.id_unit_kerja
			 where p.flag_pensiun = 0 and uk.id_skpd = $unit[id_skpd] order by p.pangkat_gol DESC";
*/
?>
<?php

if(@$pesan!=NULL)
echo("<div align=center> $pesan </div>");
?>
<table id="list_pegawai" class="table table-bordered display" cellspacing="0" width="100%">
	<thead>
		<tr>
			<th>Nama</th>
			<th>NIP</th>
			<th>Gol</th>
			<!--th class="hidden-print">New Gol<span style="color:red">*</span></th-->
			<th>BUP</th>
			<th>Unit Kerja</th>
			<th>Alamat</th>
			<th>Jabatan</th>


		</tr>
	</thead>
	<tbody>
		<?php


		?>
		<tr>
		    <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
				<td></td>
				<td></td>
		</tr>

	</tbody>
</table>
</div>
</div>

<script type="text/javascript" language="javascript" class="init">

$(document).ready(function() {
  $('#list_pegawai').dataTable( {
    "processing": true,
    "serverSide": true,
    "ajax": "list2_data_pensiun.php",
		//"searching": false

  });

	$('#list_pegawai tbody').on( 'click', 'button', function () {
        var data = table.row( $(this).parents('tr') ).data();
        alert( data[0] +"'s id_pegawai adalah "+ data[ 4 ] );
    } );

} );


</script>
