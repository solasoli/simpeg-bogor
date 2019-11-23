<?php
	if($hub == 9)
	{
		if($jumlah_si > 0 && $tunjangan == 1)
		{
			echo "<input type='hidden' value=2 id='status'/>";
		}
		else
		{
?>
		<table cellpadding="10px">
			<tr>
				<td width="200px">Nama Suamai/Istri</td>
				<td width="20px">:</td>
				<td>
					<div class="input-control text">
						<input type="text" id="nama_si" name="nama_si" required/>
					</div>
				</td>
			</tr>
			<tr>
				<td height="50px">Tempat Lahir</td>
				<td>:</td>
				<td>
					<div class="input-control text">
						<input type="text" name="tempat_lahir_si" required/>
					</div>
				</td>
			</tr>
			<tr>
				<td>Tanggal Lahir</td>
				<td>:</td>
				<td>
					<div height="10px" class="input-control text" id="dp_tanggal_lahir">
						<input type="text" name="tanggal_lahir_si" required>
						<a class="btn-date"></a>
					</div>
				</td>
			</tr>
			<tr>
				<td>Tanggal Menikah</td>
				<td>:</td>
				<td>
					<div class="input-control text" id="dp_tanggal_menikah">
						<input type="text" name="tanggal_menikah_si" required>
						<a class="btn-date"></a>
					</div>
				</td>
			</tr>
			<tr>
				<td>Akte Menikah</td>
				<td>:</td>
				<td>
					<div class="input-control text">
						<input type="text" name="akte_menikah_si" required/>
					</div>
				</td>
			</tr>
			<tr>
				<td>Pekerjaan</td>
				<td>:</td>
				<td>
					<div class="input-control text">
						<input type="text" name="pekerjaan_si" required/>
					</div>
				</td>
			</tr>
			<tr>
				<td>Jenis Kelamin</td>
				<td>:</td>
				<td>
					<div class="input-control select">
						<select name="pilih_jk_si">
							<option value=0>-Pilih Jenis Kelamin-</option>
							<option value=1 <?php echo $jk == 2 ? "selected":""?>>Laki-laki</option>
							<option value=2 <?php echo $jk == 1 ? "selected":""?>>Perempuan</option>
						</select>
					</div>						
				</td>
			</tr>
			<tr>
				<td>Keterangan</td>
				<td>:</td>
				<td>
					<div class="input-control text">
						<input type="text" name="keterangan_si">
					</div>		
				</td>
			</tr>
		</table>
<?php
		}
	}
	else if($hub == 10)
	{
		if($jumlah_ak > 1 && $tunjangan==1)
		{
			echo "<input type='hidden' value=3 id='status'/>";
		}
		else
		{
?>
		<table cellpadding="10px">
								<tr>
									<td width="200px">Nama Anak</td>
									<td width="20px">:</td>
									<td>
										<div class="input-control text">
											<input type="text" name="nama_ak" required/>
										</div>
									</td>
								</tr>
								<tr>
									<td>Tempat Lahir</td>
									<td>:</td>
									<td>
										<div class="input-control text">
											<input type="text" name="tempat_lahir_ak" required/>
										</div>
									</td>
								</tr>
								<tr>
									<td>Tanggal Lahir</td>
									<td>:</td>
									<td>
										<div height="10px" class="input-control text" id="dp_tanggal_lahir">
											<input type="text" name="tanggal_lahir_ak" required />
											<a class="btn-date"></a>
										</div>
									</td>
								</tr>
								<tr>
									<td>Jenis Kelamin</td>
									<td>:</td>
									<td>
										<div class="input-control select">
											<select name="pilih_jk_ak">
												<option value=0>-Pilih Jenis Kelamin-</option>
												<option value=1>Laki-Laki</option>
												<option value=2>Perempuan</option>
											</select>
										<div>
									</td>
								</tr>
								<tr>
								<td>Keterangan</td>
								<td>:</td>
								<td>
									<div class="input-control text">
										<input type="text" name="keterangan_ak"></textarea>
									</div>
										
								</td>
							</tr>
		</table>		
<?php
}
	}
?>