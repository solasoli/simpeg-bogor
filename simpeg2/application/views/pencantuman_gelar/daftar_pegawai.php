<h2>Nominatif KGB Pegawai Negeri Sipil</h2>

<fieldset>
	<h4>Kriteria</h4>
	<?php echo form_open('kgb/nominatif', array('method' => 'get')); ?>
	<table class="table">
		<tr>
			<td>SKPD</td>
			<td>
				<div class="input-control select span6">
				<select name="skpd">
					<option value="-1">-SELURUH-</option>
					<?php foreach($skpd as $s): ?>
					<option <?php if($this->input->get('skpd') == $s->id_skpd) echo  'selected' ?> value="<?php echo $s->id_skpd ?>"><?php echo $s->nama_baru ?></option>					
					<?php endforeach; ?>
				</select>
				</div>
			</td>
		</tr>		
		<tr>
			<td>TAHUN</td>
			<td>
				<div class="input-control select span2">
				<select name="tahun">
					<?php for($i = date("Y")-5; $i < date("Y") + 5; $i++): ?>
					<option <?php 
								if( $this->input->get('tahun') == $i) 
									echo 'selected';
								else if(date("Y") == $i && $this->input->get('tahun') == '') 
									echo 'selected' ?> value = "<?php echo $i 
					?>"><?php echo $i ?></option>
					<?php endfor; ?>
				</select>
				</div>
			</td>
		</tr>
		<tr>
			<td>BULAN</td>
			<td>
				<div class="input-control select span2">
				<select name="bulan">
					<option <?php if($this->input->get('bulan') == '01') echo  'selected' ?> value="01">Januari</option>
					<option <?php if($this->input->get('bulan') == '02') echo  'selected' ?> value="02">Februari</option>
					<option <?php if($this->input->get('bulan') == '03') echo  'selected' ?> value="03">Maret</option>
					<option <?php if($this->input->get('bulan') == '04') echo  'selected' ?> value="04">April</option>
					<option <?php if($this->input->get('bulan') == '05') echo  'selected' ?> value="05">Mei</option>
					<option <?php if($this->input->get('bulan') == '06') echo  'selected' ?> value="06">Juni</option>
					<option <?php if($this->input->get('bulan') == '07') echo  'selected' ?> value="07">Juli</option>
					<option <?php if($this->input->get('bulan') == '08') echo  'selected' ?> value="08">Agustus</option>
					<option <?php if($this->input->get('bulan') == '09') echo  'selected' ?> value="09">September</option>
					<option <?php if($this->input->get('bulan') == '10') echo  'selected' ?> value="10">Oktober</option>
					<option <?php if($this->input->get('bulan') == '11') echo  'selected' ?> value="11">November</option>
					<option <?php if($this->input->get('bulan') == '12') echo  'selected' ?> value="12">Desember</option>
				</select>
				</div>
			</td>
		</tr>			
		<tr>
			<td>&nbsp;</td>
			<td><input type="submit" class="button default" value="Tampilkan" /></td>
		</tr>
	</table>
	<?php echo form_close(); ?>
</fieldset>


<table class="table bordered striped" <?php echo $this->input->get('skpd') ? "id='daftar_pegawai_kgb'" : "" ?>>
<thead>
	<tr>
		<th>No</th>
		<th>Nama</th>
		<th>NIP</th>
		<th>Golongan</th>
		<th>TMT Sebelumnya</th>	
		<th>Unit Kerja</th>	
	</tr>	
</thead>
<tbody>
<?php if(sizeof($kgb) > 0): ?>
	<?php $i=1; ?>
	<?php foreach($kgb as $k): ?>
	<tr>
		<td><?php echo $i++ ?></td>
		<td><?php echo anchor('kgb/registrasi/'.$k->id_pegawai, $k->NAMA) ?></td>
		<td><?php echo $k->NIP ?></td>
		<td><?php echo $k->GOLONGAN ?></td>
		<td><?php echo $k->TMT_KGB_TERAKHIR ?></td>		
		<td><?php echo $k->UNIT_KERJA ?></td>		
	</tr>
	<?php endforeach; ?>
<?php else: ?>
	<tr class="error">
		<td colspan="6" align="center"><i>Tidak ada data</i></td>
	</tr>
<?php endif; ?>
</tbody>
</table>
<script>
	$(function(){
		$('#daftar_pegawai_kgb').dataTable();
	
	});
</script>