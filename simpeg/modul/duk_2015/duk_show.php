<?php
session_start(); 
require_once("../../konek.php");
require_once "../../class/duk.php";
require_once("../../library/format.php");

if(! isset($_SESSION['user'])) header('location: '.BASE_URL.'index.php');

$format = new Format;
$duk = new Duk;


if(isset($_GET['q']) == 'download'){
	header("Content-type:application/vnd.ms-excel");
	header("Content-Disposition:attachment;filename=DUK.xls");
}
if(isset($_REQUEST['id_skpd'])){
	if(isset($_REQUEST['id_unit_kerja'])){
?>
	<a href="duk_show.php?q=download&id_skpd=<?php echo $_REQUEST['id_skpd'] ?>&id_unit_kerja=<?php echo $_REQUEST['id_unit_kerja'] ?>">download xls</a>
<?php
	}else{
?>
	<a href="duk_show.php?q=download&id_skpd=<?php echo $_REQUEST['id_skpd']?>">download xls</a>
<?php	
	}
}else{
?>
	<a href="duk_show.php?q=download">download xls</a>
<?php	
}
?>


<div class="table-responsive">
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
			
			if(isset($_REQUEST['id_skpd']) ){
				
				if(isset($_REQUEST['id_unit_kerja'])){					
					$result = $duk->get_duk($_REQUEST['id_skpd'],$_REQUEST['id_unit_kerja']);
				}else{
					$result = $duk->get_duk($_REQUEST['id_skpd']);
				}				
			
			}else{
				$result = $duk->get_duk();
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
		<?php
		
			} 
		?>
	</tbody>
</table>
</div>


