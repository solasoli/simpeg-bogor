<?php 
include_once("lib/UnitKerjaRepository.php");
?>
<div style="border-left: solid #c9c9c9 1px;
			border-right: solid #c9c9c9 1px;
			border-bottom: solid #c9c9c9 1px;">
			
<div style="color: white; 
			background-color: #cf2c2c; 
			text-align: center;
			width: 100%;"><h3>FORMULIR ISIAN STAF</h3></div>
<br/>
<div style="background-color: #ededed;
			color: #828285;
			font-size: 10pt;
			padding: 5px 5px 5px 5px;
			text-align: center;
			border-bottom: solid 1px #c9c9c9;
			border-top: solid 1px #c9c9c9;
			font-weight: bold;">Unit Kerja dan Atasan</div>

<table style="background-color: ">
	<tr>
		<td>
			Unit Kerja
		</td>
		<td>:</td>
		<td>
			<select name="id_skpd">
				<option value="-">- Pilih SKPD tempat anda bekerja -</option>
			<?php
				$skpds = getAllCurrentSKPD();
				while ($skpd = mysqli_fetch_array($skpds)) {
					?>
					<option value="<?php echo $skpd[id_unit_kerja] ?>">
						<?php echo $skpd[nama_baru]; ?>
					</option>
					<?php
				}
			?>
			
	
			</select>
		</td>
	</tr>
	<tr>
		<td>
			Nama Atasan Langsung
		</td>
		<td>:</td>
		<td>
			<input type="text" name="nama_atasan" id="nama_atasan"/><i> Diisi dengan nama atasan langsung anda.</i>
		</td>
	</tr>
	<tr>
		<td>
			Jabatan Atasan Langsung
		</td>
		<td>:</td>
		<td>
			<input type="text" name="jabatan_atasan"/> <i>Diisi dengan jabatan atasan langsung anda, misal: Kepala Sub Bagian Umum dan Kepegawaian.</i>
		</td>
	</tr>
</table>

<br/><br/><br/>

<div style="background-color: #ededed;
			color: #828285;
			font-size: 10pt;
			padding: 5px 5px 5px 5px;
			text-align: center;
			border-bottom: solid 1px #c9c9c9;
			border-top: solid 1px #c9c9c9;
			font-weight: bold;">Informasi Dasar</div>
			
<table>
	<tr>
		<td>Nama Lengkap</td>
		<td>:</td>
		<td><input type="text" name="nama" /></td>
	</tr>
	<tr>
		<td>Status</td>
		<td>:</td>
		<td>
			<input type="radio" name="status" /> PNS 
			<input type="radio" name="status" /> TKK
		</td>
	</tr>
</table>
</div>




<script type="text/javascript">

	$("#nama_atasan").autocomplete('lib/Pegawai/GetNamaLike.php');
        
        /*.result(function(evt, data, formated){
        	$("#id_pegawai_atasan").val(data[1]);
        });*/
	
</script>

