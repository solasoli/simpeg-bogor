<?php include "kp_navbar.php"; ?>
<div class="page-header" style="text-align: center">
	<h1>Daftar Usulan Kenaikan Pangkat <br/>
	<small>Daftar pegawai yang sudah mengajukan usulan untuk kenaikan pangkat tahun <?php echo date("Y"); ?></small></h1>
	<br/>
</div>


<?php
// PENANGANAN UPDATE STATUS
for($c = 0; $c < $_POST[jumlah_pengajuan]; $c++)
{
	$indexer = $c+1;
	$qUpdate = "UPDATE pengajuan SET id_status = '".$_POST["pengajuan$indexer"]."' WHERE id_pengajuan = '".$_POST["id_pengajuan$indexer"]."'";
	mysqli_query($mysqli,$qUpdate);
}
?>

<?php if($_POST[jumlah_pengajuan]): ?>
<div class="alert alert-success">
	<button type="button" class="close" data-dismiss="alert">×</button>
	<b>Updated!</b> Status telah berhasil di-update.
</div>
<?php endif; ?>

<form action="index2.php?x=daftar_pengajuan_kp.php" method="post">
<?php if($_SESSION[id_pegawai] == "1751"): ?>
<div class="well">
	<a class="btn btn-primary" href="index2.php?x=add_pengajuan_kp.php"><i class="icon-plus-sign icon-white"></i> Tambah usulan baru </a>
	<input type="submit" class="btn btn-primary" value="Update Status"/>
</div>
<?php endif; ?>

<div>
	<?php 
		// Prepare the status
		$qstatus = "SELECT * FROM status_proses WHERE id_proses = 1";
		$rsStatus = mysqli_query($mysqli,$qstatus);
		$arrStatus = array();
		while ($status = mysqli_fetch_array($rsStatus)) {
			$arrStatus[] = array(
				'id_status' => $status[id_status],
				'nama_status' => $status[nama_status],
			);
		}		
	?>
		
	<table class="table table-bordered tabel-condensed table-striped">
		<thead>
			<tr>
				<th>No</th>
				<th>Nama</th>
				<th>NIP</th>
				<th>Golongan</th>
				<th>TMT</th>
				<th>Unit Kerja</th>
				<th>Status Proses</th>
				<th>Keterangan</th>
				<th>&nbsp;</th>				
			</tr>
		</thead>
		<tbody>
			
			<?php
				// LIST SEMUA PENGAJUAN KENAIKAN GAJI BERKALA
				$qListPengajuan = "SELECT peng.id_pengajuan, p.id_pegawai, nama, nip_baru, pangkat_gol, tmt_proses, nama_baru, sp.nama_status, peng.keterangan, peng.id_status
							       FROM pengajuan peng
								   INNER JOIN pegawai p ON p.id_pegawai = peng.id_pegawai
								   INNER JOIN current_lokasi_kerja c ON c.id_pegawai = p.id_pegawai
								   INNER JOIN unit_kerja u ON u.id_unit_kerja = c.id_unit_kerja
								   INNER JOIN status_proses sp ON sp.id_status = peng.id_status
								   WHERE peng.id_proses = 1
								   ORDER BY tmt_proses, nama_baru, nama, pangkat_gol ASC";									   
				$qrsListPengajuan = mysqli_query($mysqli,$qListPengajuan);
				$i = 1;
				$any = 0;
				if(mysqli_num_rows($qrsListPengajuan))
				{
					
					while($pengajuan = mysqli_fetch_array($qrsListPengajuan))
					{
						
						if($pengajuan[id_status] > 2 || $_SESSION[id_pegawai] == "1751")						
						{
							$any++;
							echo "<tr>";
						?>					
							<td>
								<?php echo $i; ?>
								<input type="hidden" name="<?php echo "id_pengajuan$any"; ?>" value="<?php echo $pengajuan[id_pengajuan]; ?>"
							</td>
							<td>
								<a href="<?php if($_SESSION[id_pegawai] == "1751") echo "../admin/dock2.php?id=$pengajuan[id_pegawai]" ;?>" target="_blank" >
								<?php echo $pengajuan[nama]; ?>
								</a></td>
							<td><?php echo $pengajuan[nip_baru]; ?></td>
							<td><?php echo $pengajuan[pangkat_gol]; ?></td>
							<td><?php echo $pengajuan[tmt_proses]; ?></td>
							<td><?php echo $pengajuan[nama_baru]; ?></td>	
							<td>
								<?php if($_SESSION[id_pegawai] == "1751"): ?>
									<select name="<?php echo "pengajuan$any";?>">
										<?php  foreach($arrStatus as $s): ?>
										<option value="<?php print_r($s[id_status]); ?>" 
											<?php if($s[id_status] == $pengajuan[id_status]) echo "selected" ?>>
											<?php print_r($s[nama_status]); ?>
										</option>
										<?php endforeach; ?>
									</select>
								<?php else: ?>
									<?php echo $pengajuan[nama_status]; ?>
								<?php endif; ?>
							</td>	
							<td><?php echo $pengajuan[keterangan]; ?>&nbsp;</td>	
							<td>
								<?php if($_SESSION[id_pegawai] == "1751"): ?>
								<a href="#" class="btn btn-success">Setujui</a>
								<a id="btn_reject_pengajuan" href="remove_daftar_pengajuan.php?id_pengajuan=<?php echo $pengajuan[id_pengajuan]; ?>" class="btn btn-danger">Tolak</a>
								
								<?php endif; ?>
								&nbsp;
							</td>			
						</tr>		
						<?php	
						$i++;
						}
					}	
				}
				else{
				?>
				<tr>
				<td colspan="9"><i>Daftar pengajuan kosong.</i>&nbsp;</td>							
				</tr>				
				<?php	
				}						
			?>	
			<?php if(!$any): ?>
			<tr>
				<td colspan="9"><i>Daftar pengajuan kosong.</i>&nbsp;</td>							
				</tr>	
			<?php endif;?>				
		</tbody>
	</table>
	<input type="hidden" name="jumlah_pengajuan" value="<?php echo $any?>" />
	</form>
</div>

<script type="text/javascript">
	$(document).ready(function(data){
		$("#btn_reject_pengajuan").click(function(data){
			return confirm("Anda yakin akan menolak pengajuan ini?");
		});
	});
	
</script>