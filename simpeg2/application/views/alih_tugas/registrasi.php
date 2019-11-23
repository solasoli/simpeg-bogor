<?php $landing = "alih_tugas/registrasi"; ?>
<?php echo form_open("pegawai/instant_search?landing=$landing"); ?>
<div class="container-fluid">
<div class="input-control text">
	<input name="txtKeyword" type="text" placeholder="Cari pegawai (nama/NIP)" />
	<button class="button btn-search"></button>
</div>
<?php echo form_close(); ?>

<?php if(isset($notes)): ?> 
<div class="bg-color-green"><?php echo $notes; ?></div>
<?php endif; ?>

<?php if($pegawai != null): ?>
<?php echo form_open('alih_tugas/ave'); ?>
<fieldset>
	<h3><strong>IDENTITAS PEGAWAI</strong></h3>
	<input type="hidden" name="idPegawai" value="<?php echo $pegawai->id_pegawai; ?>" />
	<?php if($this->input->get('add_dasar') == 1) : ?>
		<input type="hidden" name="add_dasar" value="1" />
	<?php endif; ?>
	<table class="table ">		
		<tr>
			<td>Nama</td>
			<td><?php echo $pegawai->nama; ?></td>
			<td rowspan="6">
				<img class="border-color-grey" width="150px" src="http://simpeg.kotabogor.go.id/simpeg/foto/<?php echo $pegawai->id_pegawai ?>.jpg" />
			</td>
		</tr>
		<tr>
			<td>NIP Baru</td>
			<td><?php echo $pegawai->nip_baru; ?></td>
		</tr>
		<tr>
			<td>NIP Lama</td>
			<td><?php echo $pegawai->nip_lama; ?></td>
		</tr>
		<tr>
			<td>Golongan</td>
			<td><?php echo $pegawai->pangkat.' - '.$pegawai->pangkat_gol; ?></td>
		</tr>
		<tr>
			<td>Jabatan</td>
			<td><?php echo $pegawai->jabatan; ?></td>
		</tr>
		<tr>
			<td>Unit Kerja</td>
			<td><?php echo $pegawai->nama_baru; ?></td>
		</tr>
	</table>	
</fieldset>

<?php if($pegawai->id_j > 0): ?>
<fieldset>
	<h3><strong>Informasi</strong></h3>
	Menu alih tugas ini hanya digunakan untuk pegawai non pejabat struktural.
</fieldset>
<?php else: ?>

<fieldset>
	<h3><strong>RIWAYAT ALIH TUGAS</strong></h3>
	<?php if(isset($riwayat_alih_tugas)): ?>
	
	<table class="table striped">
		<thead>
			<tr>
				<th rowspan="1">Tahun</th>
				<th rowspan="1">No SK</th>
				<th colspan="1">Unit Kerja</th>	
				<th colspan="1">Berkas</th>				
			</tr>			
		</thead>
		<tbody>
		<?php foreach($riwayat_alih_tugas as $r) :?>
			<tr>
				<td><?php echo $r->tmt ?></td>
				<td><?php echo $r->no_sk ?></td>
				<td><?php echo $r->nama_baru ?></td>	
				<td><?php if($r->id_berkas > 0) echo anchor("http://simpeg.kotabogor.go.id/admin/berkas.php?idb=".$r->id_berkas ,'Lihat', array("target" => "_blank")); ?></td>				
			</tr>			
		<?php endforeach; ?>
		</tbody>
	</table>
	<?php else:?>
		Tidak Ada Riwayat Alih Tugas
	<?php endif; ?>
</fieldset>

<fieldset>
Alih tugas baru?
<select name="alih_tugas_baru" >
	<option value="Ya">Ya</option>
	<option value="Tidak">Tidak</option>
</select>
</fieldset>

<div id="dasar_alih_tugas">
<fieldset>
	<h3><strong>DASAR ALIH TUGAS SEBELUMNYA</strong></h3>
	<table class="table">		
		<tr>
			<td>Nomor SK</td>
			<td>
			<div class="input-control text span2">
				<input type="text" placeholder="Nomor SK" name="txtNoSk" />
			</div>
			</td>
		</tr>
		<tr>
			<td>Tanggal SK</td>
			<td>
				<span class="span2">
				<span class="input-control text span2" id="datepickerTmtAwal" data-role="datepicker" data-format="yyyy-mm-dd">
					<input type="text" name="txtTanggalSk"/>
					<span class="btn-date"/></span>
				</span>
			</span>	
			</td>
		</tr>
		<tr>
			<td>TMT</td>
			<td><span class="span2">
				<span class="input-control text span2" id="datepickerTmtAwal" data-role="datepicker" data-format="yyyy-mm-dd">
					<input type="text" name="txtTmt"/>
					<span class="btn-date"/></span>
				</span>
			</td>
		</tr>
		<tr>
			<td>Pemberi SK</td>
			<td>
				<div class="input-control text span4">
				<input type="text" name="pemberi_sk" placeholder="Jabatan Pemberi SK" />	
				</div>
			</td>
		</tr>		
		<tr>
			<td>Pengesah SK</td>
			<td><div class="input-control text span4">
				<input type="text" name="pengesah_sk" placeholder="Nama pejabat yg menandatangani SK" />		
				</div>
			</td>
		</tr>					
		<tr>
			<td>Golongan</td>
			<td>
				<?php 
					if(isset($dasar_sk->keterangan)) 
						$ket = explode(',',$dasar_sk->keterangan);
					else 
						$ket = array('-','0','0');
				?>				
				<div class="input-control select span2">	
				<select name="cboGolongan">
					<option value="-">-</option>
					<option <?php if($pegawai->pangkat_gol == "I/a") echo "selected" ?> value="I/a">I/a</option>
					<option <?php if($pegawai->pangkat_gol == "I/b") echo "selected" ?> value="I/b">I/b</option>
					<option <?php if($pegawai->pangkat_gol == "I/c") echo "selected" ?> value="I/c">I/c</option>
					<option <?php if($pegawai->pangkat_gol == "I/d") echo "selected" ?> value="I/d">I/d</option>
					<option <?php if($pegawai->pangkat_gol == "II/a") echo "selected" ?> value="II/a">II/a</option>
					<option <?php if($pegawai->pangkat_gol == "II/b") echo "selected" ?> value="II/b">II/b</option>
					<option <?php if($pegawai->pangkat_gol == "II/c") echo "selected" ?> value="II/c">II/c</option>
					<option <?php if($pegawai->pangkat_gol == "II/d") echo "selected" ?> value="II/d">II/d</option>
					<option <?php if($pegawai->pangkat_gol == "III/a") echo "selected" ?> value="III/a">III/a</option>
					<option <?php if($pegawai->pangkat_gol == "III/b") echo "selected" ?> value="III/b">III/b</option>
					<option <?php if($pegawai->pangkat_gol == "III/c") echo "selected" ?> value="III/c">III/c</option>
					<option <?php if($pegawai->pangkat_gol == "III/d") echo "selected" ?> value="III/d">III/d</option>
					<option <?php if($pegawai->pangkat_gol == "IV/a") echo "selected" ?> value="IV/a">IV/a</option>
					<option <?php if($pegawai->pangkat_gol == "IV/b") echo "selected" ?> value="IV/b">IV/b</option>
					<option <?php if($pegawai->pangkat_gol == "IV/c") echo "selected" ?> value="IV/c">IV/c</option>
					<option <?php if($pegawai->pangkat_gol == "IV/d") echo "selected" ?> value="IV/d">IV/d</option>
					<option <?php if($pegawai->pangkat_gol == "IV/e") echo "selected" ?> value="IV/e">IV/e</option>					
				</select>
				</div>
			</td>
		</tr>		
		<tr>
			<td>Unit Kerja</td>
			<td>
				<div class="input-control select span6">
				<select name="id_unit_kerja_lama">
					<?php foreach($unit_kerja as $u): ?>
						<option
							<?php if($pegawai->id_unit_kerja == $u->id_unit_kerja) echo 'selected' ?>
							value = "<?php echo $u->id_unit_kerja; ?>">
							<?php echo $u->nama_baru ?>
						</option>
					<?php endforeach; ?>
				</select>
				</div>
			</td>
		</tr>								
	</table>
</div>

<fieldset>
	<h3><strong>REGISTRASI ALIH TUGAS</strong></h3>
	<table class="table">		
		<tr>
			<td>Nomor SK</td>
			<td>
			<div class="input-control text span2">
				<input type="text" placeholder="Nomor SK" name="txtNoSk" />
			</div>
			</td>
		</tr>
		<tr>
			<td>Tanggal SK</td>
			<td>
				<span class="span2">
				<span class="input-control text span2" id="datepickerTmtAwal" data-role="datepicker" data-format="yyyy-mm-dd">
					<input type="text" name="txtTanggalSk"/>
					<span class="btn-date"/></span>
				</span>
			</span>	
			</td>
		</tr>
		<tr>
			<td>TMT</td>
			<td><span class="span2">
				<span class="input-control text span2" id="datepickerTmtAwal" data-role="datepicker" data-format="yyyy-mm-dd">
					<input type="text" name="txtTmt"/>
					<span class="btn-date"/></span>
				</span>
			</td>
		</tr>
		<tr>
			<td>Pemberi SK</td>
			<td>
				<div class="input-control text span4">
				<input type="text" name="pemberi_sk" placeholder="Jabatan Pemberi SK" />	
				</div>
			</td>
		</tr>		
		<tr>
			<td>Pengesah SK</td>
			<td><div class="input-control text span4">
				<input type="text" name="pengesah_sk" placeholder="Nama pejabat yg menandatangani SK" />		
				</div>
			</td>
		</tr>					
		<tr>
			<td>Golongan</td>
			<td>
				<?php 
					if(isset($dasar_sk->keterangan)) 
						$ket = explode(',',$dasar_sk->keterangan);
					else 
						$ket = array('-','0','0');
				?>				
				<div class="input-control select span2">	
				<select name="cboGolongan">
					<option value="-">-</option>
					<option <?php if($pegawai->pangkat_gol == "I/a") echo "selected" ?> value="I/a">I/a</option>
					<option <?php if($pegawai->pangkat_gol == "I/b") echo "selected" ?> value="I/b">I/b</option>
					<option <?php if($pegawai->pangkat_gol == "I/c") echo "selected" ?> value="I/c">I/c</option>
					<option <?php if($pegawai->pangkat_gol == "I/d") echo "selected" ?> value="I/d">I/d</option>
					<option <?php if($pegawai->pangkat_gol == "II/a") echo "selected" ?> value="II/a">II/a</option>
					<option <?php if($pegawai->pangkat_gol == "II/b") echo "selected" ?> value="II/b">II/b</option>
					<option <?php if($pegawai->pangkat_gol == "II/c") echo "selected" ?> value="II/c">II/c</option>
					<option <?php if($pegawai->pangkat_gol == "II/d") echo "selected" ?> value="II/d">II/d</option>
					<option <?php if($pegawai->pangkat_gol == "III/a") echo "selected" ?> value="III/a">III/a</option>
					<option <?php if($pegawai->pangkat_gol == "III/b") echo "selected" ?> value="III/b">III/b</option>
					<option <?php if($pegawai->pangkat_gol == "III/c") echo "selected" ?> value="III/c">III/c</option>
					<option <?php if($pegawai->pangkat_gol == "III/d") echo "selected" ?> value="III/d">III/d</option>
					<option <?php if($pegawai->pangkat_gol == "IV/a") echo "selected" ?> value="IV/a">IV/a</option>
					<option <?php if($pegawai->pangkat_gol == "IV/b") echo "selected" ?> value="IV/b">IV/b</option>
					<option <?php if($pegawai->pangkat_gol == "IV/c") echo "selected" ?> value="IV/c">IV/c</option>
					<option <?php if($pegawai->pangkat_gol == "IV/d") echo "selected" ?> value="IV/d">IV/d</option>
					<option <?php if($pegawai->pangkat_gol == "IV/e") echo "selected" ?> value="IV/e">IV/e</option>					
				</select>
				</div>
			</td>
		</tr>		
		<tr>
			<td>Unit Kerja Lama</td>
			<td>
				<div class="input-control select span6">
				<select name="id_unit_kerja_lama">
					<?php foreach($unit_kerja as $u): ?>
						<option
							<?php if($pegawai->id_unit_kerja == $u->id_unit_kerja) echo 'selected' ?>
							value = "<?php echo $u->id_unit_kerja; ?>">
							<?php echo $u->nama_baru ?>
						</option>
					<?php endforeach; ?>
				</select>
				</div>
			</td>
		</tr><tr>
			<td>Unit Kerja Baru</td>
			<td>
				<div class="input-control select span6">
				<select name="id_unit_kerja_baru">
					<?php foreach($unit_kerja as $u): ?>
						<option
							<?php if($pegawai->id_unit_kerja == $u->id_unit_kerja) echo 'selected' ?>
							value = "<?php echo $u->id_unit_kerja; ?>">
							<?php echo $u->nama_baru ?>
						</option>
					<?php endforeach; ?>
				</select>
				</div>
			</td>
		</tr>								
	</table>

</fieldset>

<fieldset>

<input type="submit" name="simpan" class="button default" value="Simpan" />
<input type="submit" class="button primary" name="simpan" value="Simpan & Cetak SK" />
</fieldset	>
<?php echo form_close(); ?>
<?php endif; ?>
<?php endif; ?>
</div>
<script>

$(document).ready(function(){
	<?php if($this->input->get('add_dasar') == 1 || $this->input->get('ids')): ?>
		$("input[name='txtNoDasarSk']").focus();
	<?php else: ?>
		$("input[name='txtKeyword']").focus();
	<?php endif; ?>
	
	function prediksi_masa_kerja(){
		var tahun = $("input[name='makerDasarTahun']").val() * 365;
		var bulan = $("input[name='makerDasarBulan']").val() * 30;

		var makertotal = tahun + bulan;
		
		var tgl_dasar 	= moment($("input[name='txtTmtDasarSk']").val());
		var tgl_sk 		= moment($("input[name='txtTmtm']").val());				
		
		var selisih = tgl_sk.diff(tgl_dasar, 'days');								

		makertotal += selisih;
		
		var tahun = Math.floor(makertotal / 365);
		var bulan = Math.floor((makertotal % 365) / 30);
		
		if(bulan == 12){
			tahun = tahun + 1;
			bulan = 0;
		}
		
		console.log(tahun);
		console.log(bulan);
		$("input[name='makerTahun']").val(tahun);		
		$("input[name='makerBulan']").val(bulan);		
	}
	
	function load_gaji(display, value, golongan, masa_kerja, tahun){
		display.html('loading . . .');
		
		var formData = { golongan: golongan, 
						 masa_kerja: masa_kerja,
						 tahun: tahun
					   };
 
		$.ajax({
			url: "<?php echo base_url() ?>kgb/json_get_gapok",
			type: "post",
			dataType: "json",
			data: formData,
			success: function(data, textStatus, jqXHR){
				display.html(data.gaji);								
				value.val(data.id_gaji_pokok);
			},
			error: function(jq, status, err){
				display.html(status);								
			}
		});
	}
	
	$("input[type='submit']").click(function(){
		return confirm("Yakin akan menambahkan data KGB?");
	});
	
	$("a[group='delete_link']").click(function(){
		if(confirm('Hapus data KGB ini?')){
			return true;
		}
		return false;
	});
	
	
	$("select[name='cboGolonganDasarSk']").change(function(){
		display = $("#labelGajiDasarSk");
		golongan =  $("select[name='cboGolonganDasarSk']").val();
		masa_kerja = $("input[name='makerDasarTahun']").val();
		tahun = $("select[name='peraturanGajiDasarSk']").val();
		value = $("input[name='id_gapok_dasar']");
		
		load_gaji(display, value, golongan, masa_kerja, tahun);
		
		return false;
	});
	
	$("select[name='alih_tugas_baru']").change(function(){	
		
		//if($("#dasar_alih_tugas").is(":visible"))
			$("#dasar_alih_tugas").slideToggle();		
		//else
			//$("#dasar_alih_tugas").fadeIn('slow');				
		//return false;
	});
	
	
	$("select[name='peraturanGajiDasarSk']").change(function(){
		display = $("#labelGajiDasarSk");
		golongan =  $("select[name='cboGolonganDasarSk']").val();
		masa_kerja = $("input[name='makerDasarTahun']").val();
		tahun = $("select[name='peraturanGajiDasarSk']").val();
		value = $("input[name='id_gapok_dasar']");
		
		load_gaji(display, value, golongan, masa_kerja, tahun);
		
		return false;
	});
	
	$("input[name='makerDasarTahun']").change(function(){
		display = $("#labelGajiDasarSk");
		golongan =  $("select[name='cboGolonganDasarSk']").val();
		masa_kerja = $("input[name='makerDasarTahun']").val();
		tahun = $("select[name='peraturanGajiDasarSk']").val();
		value = $("input[name='id_gapok_dasar']");
		
		load_gaji(display, value, golongan, masa_kerja, tahun);
		
		return false;
	});
	
	
	$("select[name='cboGolongan']").change(function(){
		display = $("#labelGaji");
		golongan =  $("select[name='cboGolongan']").val();
		masa_kerja = $("input[name='makerTahun']").val();
		tahun = $("select[name='peraturanGaji']").val();
		var value = $("input[name='id_gapok']");
		
		load_gaji(display, value, golongan, masa_kerja, tahun);
		
		return false;
	});
	
	$("select[name='peraturanGaji']").change(function(){
		display = $("#labelGaji");
		golongan =  $("select[name='cboGolongan']").val();
		masa_kerja = $("input[name='makerTahun']").val();
		tahun = $("select[name='peraturanGaji']").val();
		var value = $("input[name='id_gapok']");
		
		load_gaji(display, value, golongan, masa_kerja, tahun);
		
		return false;
	});
	
	$("input[name='makerDasarTahun']").change(function(){
		display = $("#labelGaji");
		golongan =  $("select[name='cboGolongan']").val();
		masa_kerja = $("input[name='makerTahun']").val();
		tahun = $("select[name='peraturanGaji']").val();
		var value = $("input[name='id_gapok']");
		
		load_gaji(display, value, golongan, masa_kerja, tahun);
		
		return false;
	});
	
	
	$("#btnGajiDasarSk").click(function(){
		display = $("#labelGajiDasarSk");
		golongan =  $("select[name='cboGolonganDasarSk']").val();
		masa_kerja = $("input[name='makerDasarTahun']").val();
		tahun = $("select[name='peraturanGajiDasarSk']").val();
		var value = $("input[name='id_gapok_dasar']");
		
		load_gaji(display, value, golongan, masa_kerja, tahun);
				
		return false;
	});
	
	$("#btnGaji").click(function(){		
		load_gaji(
			$("#labelGaji"),
			$("input[name='id_gapok']"),
			$("select[name='cboGolongan']").val(),
			$("input[name='makerTahun']").val(),
			$("select[name='peraturanGaji']").val()
		);
		return false;
	});
	
	
	$("#btnPrediksiMasaKerja").click(function(){
		prediksi_masa_kerja();
		return false;
	});
	
	
});
</script>
