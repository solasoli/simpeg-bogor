<?php
session_start();
require_once("../konek.php");
require_once "../class/unit_kerja.php";
require_once("../library/format.php");
require_once "../class/duk.php";

if(! isset($_SESSION['user'])) header('location: '.BASE_URL.'index.php');

$format = new Format;
$uk = new Unit_kerja;
$duk = new Duk;

$unor = "...";
if(isset($_REQUEST['opd']) ){

	if(isset($_REQUEST['uk'])){
		$unor = strtoupper($uk->get_unit_kerja($_REQUEST['uk'])->nama_baru);
	}else{
		$unor = strtoupper($uk->get_unit_kerja($_REQUEST['opd'])->nama_baru);
	}

}else{
	$unor = "PEMERINTAH KOTA BOGOR";
}

header("Content-type:application/vnd.ms-excel");
header("Content-Disposition:attachment;filename=nominatif.xls");

?>
<h3>DAFTAR NOMINATIF<br>
PEGAWAI NEGERI SIPIL <?php echo  $unor ?><br>
TAHUN 2017</h3>
<table border="1" class="table table-bordered">
	<thead>
		<tr>
			<th rowspan="2">NO.</th>
			<th rowspan="2">NAMA</th>
			<th rowspan="2">NIP</th>
			<th colspan="2">PANGKAT</th>
			<th colspan="2">JABATAN</th>
			<th colspan="2">MASA KERJA</th>
			<th colspan="3">LATIHAN JABATAN</th>
			<th colspan="3">PENDIDIKAN</th>
			<th rowspan="2">USIA</th>
			<th rowspan="2">CATATAN<br>MUTASI</th>
			<th rowspan="2">KET</th>
		</tr>
		<tr>
			<th>GOL/<br>RUANG</th>
			<th>TMT</th>

			<th>NAMA</th>
			<th>TMT</th>

			<th>THN</th>
			<th>BLN</th>

			<th>NAMA</th>
			<th>TAHUN</th>
			<th>JUMLAH<br>JAM</th>

			<th>NAMA</th>
			<th>LULUS<br>TAHUN</th>
			<th>TINGKAT</th>
		</tr>
		<tr>
			<?php

				for($i = 1; $i<=18; $i++){

					echo "<th>".$i."</th>";
				}
			?>

		</tr>
	</thead>
	<tbody>
		<?php

			if(isset($_REQUEST['opd']) ){

				if(isset($_REQUEST['uk'])){
					$result = $duk->get_nominatif($_REQUEST['opd'],$_REQUEST['uk']);
				}else{
					$result = $duk->get_nominatif($_REQUEST['opd']);
				}

			}else{
				$result = $duk->get_nominatif();
			}

			$x=1;
			while($data = mysql_fetch_object($result)){
		?>
		<tr>
			<td><?php echo $x++ ?></td>
			<td>
				<?php echo $data->nama ?><br>
				<?php echo $data->tempat_lahir.", ".$format->date_dmY($data->tgl_lahir) ?>

			</td>
			<td><?php echo $data->nip ?></td>
			<td><?php echo $data->gol_akhir ?></td>
			<td><?php echo $format->date_dmY($data->gol_akhir_tmt) ?></td>
			<td><?php echo $data->jabatan ?></td>
			<td><?php echo $format->date_dmY($data->jabatan_tmt) ?></td>
			<td><?php echo $data->mkt ?></td>
			<td><?php echo $data->mkb ?></td>
			<td><?php echo $data->nama_diklat ?></td>
			<td><?php echo $data->tgl_diklat == '0000-00-00' || $data->tgl_diklat == NULL ? '-' : $format->date_dmY($data->tgl_diklat) ?></td>
			<td><?php echo $data->jml_jam_diklat ?></td>
			<td><?php echo $data->lembaga_pendidikan ?></td>
			<td><?php echo $data->tahun_lulus ?></td>
			<td><?php echo $data->tingkat_pendidikan ?></td>
			<td><?php echo $data->usia ?></td>
			<td></td>
			<td></td>
		</tr>
			<?php } ?>
	</tbody>
</table>
