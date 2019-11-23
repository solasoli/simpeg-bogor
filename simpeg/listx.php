<?php $unit_kerja = new Unit_kerja; ?>


<h2>DAFTAR PEGAWAI NON AKTIF <br><?php echo $unit['id_skpd']." ".$unit_kerja->get_unit_kerja($unit['id_skpd'])->nama_baru ?><a href="#" class="btn btn-primary  hidden-print pull-right" onclick="window.print()">cetak</a></h2>

<?php

$es = mysqli_query($mysqli,"select j.eselon from pegawai p
			 inner join jabatan j on j.id_j = p.id_j
			 where p.id_pegawai = $ata[id_pegawai]");
$es = mysqli_fetch_array($es);

$qold=mysqli_query($mysqli,"select id_old from unit_kerja where id_unit_kerja=$unit[0]");
$old=mysqli_fetch_array($qold);

if($qold)
{
$qold2=mysqli_query($mysqli,"select id_old from unit_kerja where id_unit_kerja=$old[0]");
$old2=mysqli_fetch_array($qold2);
}

if($qold2)
{
$qold3=mysqli_query($mysqli,"select id_old from unit_kerja where id_unit_kerja=$old2[0]");
$old3=mysqli_fetch_array($qold3);
}


if($old[0]==0) //kalo id_unit_kerja old nya = 0
$where="c.id_unit_kerja = $unit[0]";
else if ($old2[0]==0)
$where="u.id_skpd = $unit[0] or u.id_skpd = $old[0]";
else if ($old2[0]==0)
$where="u.id_skpd = $unit[0] or u.id_skpd = $old[0] or u.id_skpd = $old2[0]";
else
$where="u.id_skpd = $unit[0] or u.id_skpd = $old[0] or u.id_skpd = $old2[0] or u.id_skpd = $old3[0]";

if($es[0] == "V")
{
	$qo=mysqli_query($mysqli,"select DISTINCT p.nama, p.nip_baru, p.pangkat_gol, u.nama_baru, k.* \n"
    . "from pegawai p \n"
    . "left join buffer_kelengkapan_berkas k on k.id_pegawai = p.id_pegawai \n"
    . "left join current_lokasi_kerja c on c.id_pegawai = p.id_pegawai\n"
    . "inner join unit_kerja u on u.id_unit_kerja = c.id_unit_kerja\n"
    . "where flag_pensiun = 1 and ( $where ) \n"
	. "order by p.pangkat_gol desc, p.tgl_lahir");
}
else
{
$qo=mysqli_query($mysqli,"select DISTINCT p.id_pegawai,
		p.pangkat_gol, p.jenjab, p.gelar_depan, p.nama, p.gelar_belakang, p.nip_baru, p.pangkat_gol,
		p.id_j, p.jabatan, p.alamat, p.status_aktif, p.tgl_pensiun_dini "
    . "from pegawai p \n"
    . "left join current_lokasi_kerja c on c.id_pegawai = p.id_pegawai\n"
	. "inner join unit_kerja u on u.id_unit_kerja = c.id_unit_kerja\n"
    . "where flag_pensiun = 1 and ( $where ) \n"
	. "order by p.pangkat_gol desc, p.tgl_lahir");


}



?>
<?php //print_r($_SESSION['profil']) ?>
<table id="list_pegawai" class="table table-bordered display" cellspacing="0" width="100%">
	<thead>
		<tr>
			<th>No</th>
			<th>kode</th>
			<th>Nama</th>
			<th>NIP</th>
			<th>Gol</th>
			<!--th class="hidden-print">New Gol<span style="color:red">*</span></th-->
			<th>Status Aktif</th>
            <th>Tgl.Pensiun</th>
            <th> Detil </th>

		</tr>
	</thead>
	<tbody>
		<?php
			$r=1;
			$jabatan = '';
			while($bata=mysqli_fetch_array($qo)){

				if(@$bata['id_j']!=NULL && @$bata[jenjab] == 'Struktural'){

					$qjo=mysqli_query($mysqli,"select jabatan,eselon from jabatan where id_j=$bata[id_j]");

					$ahab=mysqli_fetch_array($qjo);

				}elseif(@$bata[id_j] == NULL && @$bata[jenjab] == 'Struktural'){

					$sql = "select jfu_pegawai.*, jfu_master.*
							from jfu_pegawai, jfu_master
							where jfu_pegawai.id_pegawai = '".$bata['id_pegawai']."'
							and jfu_master.kode_jabatan = jfu_pegawai.kode_jabatan";

					$qjo=mysqli_query($mysqli,$sql);

					$ahab=mysqli_fetch_array($qjo);
				}else{

					$ahab = @$bata['jabatan'];

				}

				$nama_full = @$bata['gelar_depan'] ? @$bata['gelar_depan'].' '.@$bata['nama'] : @$bata['nama'];
				$nama_full .= @$bata['gelar_belakang'] ? ', '.@$bata['gelar_belakang'] : '' ;


					$last_gol_query = "select *
										from sk
										where id_pegawai = '".$bata['id_pegawai']."'
										and id_kategori_sk in ('5','6')
										and tmt = (select max(tmt) from sk where id_kategori_sk in ('5','6')
										and id_pegawai = '".$bata['id_pegawai']."' )";

				$last_gol = mysqli_fetch_array(mysqli_query($mysqli,$last_gol_query))['keterangan'];

		?>
		<tr>
			<td><?php echo $r ?></td>
			<td><?php echo $bata['id_pegawai'] ?> </td>
			<td><?php echo $nama_full ?></td>
			<td><?php echo $bata["nip_baru"] ?></td>
			<td><?php echo $bata["pangkat_gol"] ?></td>
			<!--td class="hidden-print"><?php //echo $last_gol ?></td-->
			<td><?php echo $bata["status_aktif"]; ?></td>
            <td><?php echo $bata["tgl_pensiun_dini"]; ?></td>
            <td class="hidden-print">
							<!-- a href='index3.php?x=box.php&od=<?php //echo @$bata['id_pegawai'] ?>' id='<?php echo @$bata['id_pegawai']?>' class='btn btn-primary'>Detail</a -->
							<div class="btn-group">
								<button class="btn btn-default" type="button">Aksi</button>
								<button class="btn btn-default dropdown-toggle" data-toggle="dropdown" type="button">
								<span class="caret"></span>
								<span class="sr-only">Toggle Dropdown</span>
								</button>
								<ul class="dropdown-menu" role="menu">
										<li>
												<a href="index3.php?x=box.php&od=<?php echo @$bata['id_pegawai'] ?>"><i class="fa fa-check-circle fa-lg" title="Assess" alt="assess"></i> Detail Profil</a>
										</li>
										<?php if($bata["status_aktif"] !== 'Pensiun Reguler'){ ?>
										<li>
												<a onclick="aktifkan(<?php echo @$bata['id_pegawai'] ?>)"><i class="fa fa-check-circle fa-lg" title="Assess" alt="assess"></i> Aktifkan</a>
										</li>
									<?php } ?>

							</div>
						</td>

		</tr>
		<?php $r++; } ?>


	</tbody>
</table>
<p>
	<span style="color:red">*</span> Golongan berdasarkan data riwayat pangkat/sk yang sudah di input
</p>
<script>
		function aktifkan(id_pegawai){
			//alert(id_pegawai);
			$.post("listx2.php",{id_pegawai:id_pegawai})
			 .done(function(data){
					if(data == 0){
						alert('gagal menyimpan perubahan');
					}else{
						window.location.reload();
					}
			});
		}
</script>
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
