<?php $unit_kerja = new Unit_kerja; ?>

<div class="panel panel-default">
	<div class="panel-body">
<h4>DAFTAR PEGAWAI <?php echo $unit_kerja->get_unit_kerja($unit['id_skpd'])->singkatan ?></h4>

<!--a href="#" class="btn btn-primary  hidden-print pull-right" onclick="window.print()">cetak</a></h2-->

<?php
extract($_GET);

if(@$de>0)
{
$taon=date("Y");
mysqli_query($mysqli,"delete from kp_draft where id_pegawai=$de and periode like '$taon-%'");
$pesan="Kenaikan Pangkat berhasil dihapus";
}

if(@$od>0)
{
$bul=date("m");
$taon=date("Y");
if($bul<10)
$lan=substr($bul,1,1);
else
$lan=$bul;
if($lan>4 and $lan<=10)
$periode="$taon-10-01";
else
{
if($lan>10)
$taon++;
$periode="$taon-04-01";
}
$qcek=mysqli_query($mysqli,"select count(*) from kp_draft where id_pegawai=$od and periode like '$periode'");
$cek=mysqli_fetch_array($qcek);
if($cek[0]==0)
{
mysqli_query($mysqli,"insert into kp_draft (id_pegawai,periode,id_status) values ($od,'$periode',0)");
$pesan="Kenaikan Pangkat berhasil diajukan";
}
}

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
			<th>Jabatan</th>
			<th>Aksi</th>


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
		</tr>

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
<script type="text/javascript" language="javascript" class="init">

$(document).ready(function() {
  $('#list_pegawai').dataTable( {
    "processing": true,
    "serverSide": true,
    "ajax": "list2_data.php?id_skpd=<?php echo $_SESSION['id_skpd'] ?>",
		//"searching": false

  });

	$('#list_pegawai tbody').on( 'click', 'button', function () {
        var data = table.row( $(this).parents('tr') ).data();
        alert( data[0] +"'s id_pegawai adalah "+ data[ 4 ] );
    } );

} );

function aktifkan(id_pegawai){
	$.ajax({
			type: "POST",
			dataType: "html",
			url: "modul/profil/update_status_aktif.php",
			data: {id_pegawai: id_pegawai}
	}).done(function(data){
			if(data = 'UPDATE_SUCCESS'){
				alert("Berhasil")
			}
	});
}

function hapus_pengajuan_kp(id){
    $.ajax({
        type: "POST",
        dataType: "html",
        url: "list2_hapus_draft_kp.php",
        data: {id_pegawai: id}
    }).done(function(data){

    });
}

</script>
