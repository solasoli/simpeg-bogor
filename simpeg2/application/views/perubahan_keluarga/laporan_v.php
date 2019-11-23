<h2 align="center">Laporan Perubahan Keluarga</h2>
<br/> <br/>
<div style="margin-left:10%;">
<form method="get">
<div>
<table cellpadding="5px">
	<tr>
			<tr>
				<td width="100px">Pilih Bulan </td>
				<td>:</td>
				<td width="200px">
					<div class="input-control select">
					<select name="bulan" id="bulan">
						<option value=0>-Pilih Bulan-</option>
						<option value=1>Januari</option>
						<option value=2>Februari</option>
						<option value=3>Maret</option>
						<option value=4>April</option>
						<option value=5>Mei</option>
						<option value=6>Juni</option>
						<option value=7>Juli</option>
						<option value=8>Agustus</option>
						<option value=9>September</option>
						<option value=10>Oktober</option>
						<option value=11>November</option>
						<option value=12>Desember</option>
					</select>
					</div>
				</td>
				<td width="100px"></td>
				<td width="100px">Pilih Tahun : </td>
				<td width="200px">
					<div class="input-control select">
						<select name="tahun" id="tahun">
							<option value="0">-Pilih Tahun-</option>
							<?php foreach($tahun_ts->result() as $r)
								{
							?>
							<option value="<?php echo $r->tahun?>"><?php echo $r->tahun?></option>
							<?php }?>
						</select>
					</div>
				</td>
				<td width="50px"></td>
				<td><button class="button primary" id="lihat" >Lihat</button></td>
			</tr>
		<td></td>
		<td></td>
	</tr>
</table>
</form>
</div>
<div id="hasil_laporan" style="margin-top:20px;margin-left:10%;margin-right:10%;">

</div>
</div>
<br/>
<script>
$(document).ready(function(){
		$('#lihat').click(function(){
			$.ajax({
				url: "<?php echo base_url().'perubahan_keluarga/get_laporan_by_bulan_tahun'?>",
				type: "get",
				data: "bulan="+('#bulan').val()+"tahun="+('#tahun').val(),
				success: function(data){
					$('#hasil_laporan').html(data)
				}
			});
		});
});
</script>