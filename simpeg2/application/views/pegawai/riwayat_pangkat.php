<div class="row">
<legend>
	<h2>Riwayat Kepangkatan
		<!--<span class=" place-right"><a href="#" id="addPangkat" class="button primary"><span class="icon-plus"></span> tambah</a></span>-->
	</h2>
</legend>

<table class="table">
	<thead>
		<tr>
			<th>No</th>
			<th>Pangkat, Gol. Ruang</th>
			<th>Masa Kerja</th>
			<th>No.SK</th>
			<th>Tanggal SK</th>
			<th>TMT</th>
			<th>Keterangan</th>
			<!--<th>Berkas</th>-->
		</tr>
	</thead>
	<tbody>
		<?php $x=1; foreach($sk_pangkats as $pangkat){ ?>
			
		<?php	/*if($pangkat->keterangan != "" || $pangkat->keterangan != "-") {
					list($gol,$mk_tahun,$mk_bulan) = explode(",",$pangkat->keterangan);
				}else{
					$gol = $mk_tahun = $mk_bulan = "-";	
				}*/
		?>
						
		<tr>
			<td><?php echo $x++."."; ?></td>
			<td><?php echo $pangkat->gol.' ('.$pangkat->pangkat.')'; ?></td>
			<td><?php echo $pangkat->mk_tahun.' Thn '.$pangkat->mk_bulan.' Bln'; ?></td>
			<td><?php echo $pangkat->no_sk; ?></td>
			<td><?php echo $pangkat->tgl_sk ?></td>
			<td><?php echo $pangkat->tmt ?></td>
			<td><?php echo $pangkat->nama_sk ?></td>
			<!--<td><?php //if($pangkat->id_kategori_sk == 6) {echo "CPNS"; }elseif($pangkat->id_kategori_sk == 7) {echo "PNS";} else {echo "Kenaikan Pangkat";}  ?></td>-->
			<!--<td>
				<?php //if($pangkat->id_berkas <> 0) { ?>
				<a href="http://simpeg.kotabogor.go.id/admin/berkas.php?idb=<?php //echo $pangkat->id_berkas ?>" target="_blank"><span class="icon-download-2"></span></a>
                <?php //} ?>
            </td>-->
		</tr>
		<?php } ?>
	</tbody>
</table>
</div>

<div id="addPangkatDialog" class="hide">
	<form class="user-input">
		<label>Pangkat</label>
		<div class="input-control text">
			<input type="text" name="jenis">
			<button class="btn-clear"></button>
		</div>
		<label>No SK</label>
		<div class="input-control text">
			<input type="text" name="no_sk">
			<button class="btn-clear"></button>
		</div>
		<label>Tgl SK</label>
		<div class="input-control text" id="datepickerTglSk">
			<input type="text" name="tgl_sk">
			<a class="btn-date"></a>
		</div>
		<label>TMT SK</label>
		<div class="input-control text">
			<input type="text" name="tmt_sk">
			<button class="btn-clear"></button>
		</div>
	</form>
</div>
<script>
	
	 $(function(){
	 $("#addPangkat").on('click', function(){
			$.Dialog({
				overlay: true,
				shadow: true,
				flat: true,
				draggable: true,                              
				content: '',
				width: "50%",
				padding: 10,
				onShow: function(_dialog){
					var content = $("#addPangkatDialog").html();
					$.Dialog.title("Tambah Riwayat Kepangkatan");
					$.Dialog.content(content);
				}
			});
		});
	})
	 
	$("#datepickerTglSk").datepicker({
		 format: "yyyy-mm-dd"
	 });
</script>


