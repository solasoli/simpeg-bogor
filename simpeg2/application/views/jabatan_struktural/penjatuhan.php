<?php $landing = "hukuman_disiplin/penjatuhan"; ?>
<?php echo form_open("pegawai/instant_search?landing=$landing"); ?>
<div class="input-control text">
	<input name="txtKeyword" type="text" placeholder="Cari pegawai (nama/NIP)" />
	<button class="btn-search"></button>
</div>
<?php echo form_close(); ?>
<div class="container">
<?php if(isset($notes)): ?> 
<div class="bg-color-green"><?php echo $notes; ?></div>
<?php endif; ?>

<?php if($pegawai != null): ?>
<?php echo form_open('hukuman_disiplin/save'); ?>
<fieldset>
	<legend><h2>IDENTITAS PEGAWAI</h2></legend>
	<input type="hidden" name="idPegawai" value="<?php echo $pegawai->id_pegawai; ?>" />
	<table class="table striped">			
		<tr>
			<td>Nama</td>
			<td><?php echo $pegawai->nama; ?></td>
			<td rowspan="6">
				<img class="border-color-grey" width="150px" src="http://simpeg.org/simpeg/foto/<?php echo $pegawai->id_pegawai ?>.jpg" />
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
</br>
<fieldset>
	<legend><h2>RIWAYAT HUKUMAN</h2></legend>
	<?php if(isset($riwayat_hukuman)): ?>
	<table class="striped">
		<thead>
			<tr>
				<th>Tingkat Hukuman</th>
				<th>Jenis</th>
				<th>No Keputusan</th>
				<th>Tanggal Hukuman</th>
				<th>TMT</th>
				<th>Pejabat</th>
				<th>&nbsp;</th>
			</tr>
		</thead>
		<tbody>
		<?php foreach($riwayat_hukuman as $hukuman) :?>
			<tr>
				<td><?php echo $hukuman->tingkat_hukuman ?></td>
				<td><?php echo $hukuman->deskripsi ?></td>
				<td><?php echo $hukuman->no_keputusan ?></td>
				<td><?php echo $hukuman->tgl_hukuman ?></td>
				<td><?php echo $hukuman->tmt ?></td>
				<td><?php echo $hukuman->pejabat_pemberi_hukuman ?></td>
				<td><?php echo anchor('hukuman_disiplin/delete/'.$hukuman->id_hukuman.'?idp='.$hukuman->id_pegawai, 'Hapus', array('group' => 'delete_link')); ?></td>
			</tr>			
		<?php endforeach; ?>
		</tbody>
	</table>
	<?php else:?>
		Tidak Ada Riwayat Hukuman
	<?php endif; ?>
</fieldset>
</br>
<fieldset>
	<legend><h2>PENAMBAHAN HUKUMAN BARU</h2></legend>
	<table class="striped">
		<tr>
			<td>Tingkat Hukuman</td>
			<td>
				<div class="input-control select">
				<select name="cboTingkatHukuman">
					<option value="RINGAN">Ringan</option>
					<option value="SEDANG">Sedang</option>
					<option value="BERAT">Berat</option>
				</select>
				</div>
			</td>
		</tr>
		<tr>
			<td>Jenis Hukuman</td>
			<td>
				<div class="input-control select">
				<select name="cboJenisHukuman">
					<?php foreach($jenis_hukuman as $j): ?>
						<option value="<?php echo $j->id_jenis_hukuman ?>"><?php echo $j->deskripsi ?></option>
					<?php endforeach; ?>					
				</select>
				</div>
			</td>
		</tr>
		<tr>
			<td>No. Keputusan Hukuman</td>
			<td>
				<div class="input-control text">
					<input type="text" name="txtNoKeputusan" />
				</div>
			</td>
		</tr>
		<tr>
			<td>Tanggal Penetapan Hukuman</td>
			<td>
				<div class="input-control text">
				<input type="text" name="txtTanggalPenetapan" /> (yyyy-mm-dd)
				</div>
			</td>
		</tr>
		<tr>
			<td>TMT Hukuman</td>
			<td>
				<div class="input-control text">
				<input type="text" name="txtTmt" /> (yyyy-mm-dd)
				</div>
				</td>
		</tr>
		<tr>
			<td>Nama Pejabat Pemberi Hukuman</td>
			<td>
				<div class="input-control text">
				<input type="text" name="txtPejabatPemberiHukuman" />
				</div>
				</td>
		</tr>
		<tr>
			<td>Jabatan</td>
			<td>
				<div class="input-control text">
				<input type="text" name="txtJabatan" />
				</div>
			</td>
		</tr>
		<tr>
			<td>Keterangan</td>
			<td>
				<div class="input-control textarea">
				<textarea class="span6" name="txtKeterangan"></textarea>
				</div>
			</td>
		</tr>
	</table>
</fieldset>
<fieldset>
<input type="submit" class="button default" value="Simpan" />
</fieldset	>
<?php echo form_close(); ?>
<?php endif; ?>
</div>
<script>
$(document).ready(function(){
	$("input[name='txtKeyword']").focus();
	
	$("input[type='submit']").click(function(){
		return confirm("Yakin akan menambahkan data hukuman?");
	});
	
	$("select[name='cboTingkatHukuman']").change(function(){
	    $.post('<?php echo base_url() ?>index.php/hukuman_disiplin/json_get_by_tingkat', { tingkat:$("select[name='cboTingkatHukuman']").val() }, function(data){
            var opt ='';
            $($.parseJSON(data)).map(function () {
                opt += "<option value='" + this.id_jenis_hukuman + "'>" + this.deskripsi + "</option>";
            }).appendTo("select[name='cboJenisHukuman']");
			
            $("select[name='cboJenisHukuman']").html(opt);
	   })
	});
	
	$("a[group='delete_link']").click(function(){
		if(confirm('Hapus data hukuman ini?')){
			return true;
		}
		return false;
	});
});
</script>
