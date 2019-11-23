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
<table id="list_pegawai" class="table table-bordered display" cellspacing="0" width="100%">
	<thead>
		<tr>
			<th>Id Pegawai</th>
			<th>Nama</th>
			<th>NIP</th>
			<th>Gol</th>
			<!--th class="hidden-print">New Gol<span style="color:red">*</span></th-->
			<th>Jabatan</th>

			<th class="hidden-print">Aksi</th>
		</tr>
	</thead>
	<tbody>
		<?php
			$r=1;
			$jabatan = '';
			while($bata=mysqli_fetch_array($qo)){
				/*
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
				*/

				$sql = "select distinct p.id_pegawai,
						TRIM(IF(LENGTH(p.gelar_belakang) > 1,
								CONCAT(p.gelar_depan,
										' ',
										p.nama,
										CONCAT(', ', p.gelar_belakang)),
								CONCAT(p.gelar_depan, ' ', p.nama))) AS nama, p.jenjab,
								concat(p.tempat_lahir,', ',date_format(p.tgl_lahir,'%d-%m-%Y')) as ttl,
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
							select * from jfu_pegawai where id_pegawai = ".$bata['id_pegawai']." and tmt =
							(select max(tmt) from jfu_pegawai where id_pegawai = ".$bata['id_pegawai']." )
							) jfu_pegawai on jfu_pegawai.id_pegawai = p.id_pegawai
						left join jfu_master on jfu_master.kode_jabatan= jfu_pegawai.kode_jabatan
						left join jafung_pegawai on jafung_pegawai.id_pegawai = p.id_pegawai
						where p.id_pegawai = ".$bata['id_pegawai'];

				$peg = mysqli_fetch_object(mysqli_query($mysqli,$sql));

		?>
		<tr>
			<td><?php echo @$bata['id_pegawai']; ?></td>
			<td><?php echo @$peg->nama; ?></td>
			<td><?php echo @$peg->nip; ?></td>
			<td><?php echo @$peg->golongan; ?></td>
			<!--td class="hidden-print"><?php //echo $last_gol ?></td-->
			<td><?php  echo $peg->jabatan ?></td>


			<td class="hidden-print">
			<!-- dropdown -->
			<div class="btn-group">
			  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				Aksi <span class="caret"></span>
			  </button>
			  <ul class="dropdown-menu dropdown-menu-right">
				<li><a href='index3.php?x=box.php&od=<?php echo @$bata['id_pegawai'] ?>' id='<?php echo @$bata['id_pegawai']?>'>Detail Profil</a></li>
				<li><a href='index3.php?x=at2.php&od=<?php echo @$bata['id_pegawai'] ?>' id='<?php echo @$bata['id_pegawai']?>'>Alih Tugas</a></li>
				<?php
					$qjo2=mysqli_query($mysqli,"select jabatan.jabatan,eselon,pegawai.id_j from jabatan inner join pegawai on pegawai.id_j =jabatan.id_j where pegawai.id_pegawai=$bata[id_pegawai]");

					$cekjo=mysqli_fetch_array($qjo2);
					if($cekjo[1]=='IVA' or $cekjo[1]=='IVB')
					{
					?>
					<li><a href='index3.php?x=staf.php&od=<?php echo @$bata['id_pegawai']; ?>&idj=<?php echo @$cekjo[2]; ?>' >Update Staf</a></li>
					<?php }	?>
				<li role="separator" class="divider"></li>
				<li><a href='index3.php?x=out.php&od=<?php echo @$bata['id_pegawai'] ?>&act=1' id='<?php echo @$bata['id_pegawai']?>'>Pensiun Dini</a></li>
				<li><a href='index3.php?x=out.php&od=<?php echo @$bata['id_pegawai'] ?>&act=2' id='<?php echo @$bata['id_pegawai']?>'>Meninggal Dunia</a></li>
			  </ul>
			</div>
			<!-- end dropdown -->




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
