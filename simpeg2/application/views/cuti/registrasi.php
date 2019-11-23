<?php $landing = "cuti/registrasi"; ?>
<?php echo form_open("pegawai/instant_search?landing=$landing"); ?>
<div class="input-control text">
	<input name="txtKeyword" type="text" placeholder="Cari pegawai (nama/NIP)" />
	<button class="btn-search"></button>
</div>
<?php echo form_close(); ?>

<?php if(isset($notes)): ?> 
<div class="bg-color-green"><?php echo $notes; ?></div>
<?php endif; ?>

<?php if($pegawai != null): ?>
<?php echo form_open('cuti/save'); ?>
<fieldset>
	<h2>IDENTITAS PEGAWAI</h2>
	<input type="hidden" name="idPegawai" value="<?php echo $pegawai->id_pegawai; ?>" />
	<table class="table bordered hovered">		
		<tr>
			<td>Nama</td>
			<td><?php echo $pegawai->nama; ?></td>
			<td rowspan="6">
				<img class="border-color-grey" width="150px" src="http://simpeg.kotabogor.go.id/simpeg/foto/<?php echo $pegawai->id_pegawai ?>.jpg" />
			</td>
		</tr>
		<tr>
			<td>NIP Baru</td>
			<td>
				<?php echo $pegawai->nip_baru; ?>
				<?php $gol = $pegawai->pangkat_gol;?>
			</td>
		</tr>
		<tr>
			<td>NIP Lama</td>
			<td><?php echo $pegawai->nip_lama; ?></td>
		</tr>
		<tr>
			<td>Golongan</td>
			<td><?php echo $pegawai->pangkat.' - '. $gol;?></td>
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

<fieldset>
	<h2>RIWAYAT CUTI PNS</h2>
	<?php if(isset($riwayat_cuti)): ?>
	<table class="table bordered">
		<thead>
			<tr>
				<th rowspan="2">Jenis Cuti</th>
				<th rowspan="2">No Keputusan</th>
				<th colspan="2">TMT Cuti</th>
				<th rowspan="2">Lama (hari)</th>
				<th rowspan="2">Keterangan</th>
				<th rowspan="2">&nbsp;</th>
			</tr>
			<tr>
				<th>Dari</th>
				<th>Hingga</th>
			</tr>
		</thead>
		<tbody>
		<?php foreach($riwayat_cuti as $r) :?>
			<tr>
				<td><?php echo $r->deskripsi ?></td>
				<td><?php echo $r->no_keputusan ?></td>
				<td><?php echo $r->tmt_awal ?></td>
				<td><?php echo $r->tmt_selesai ?></td>				
				<td><?php echo $r->lama ?></td>				
				<td><?php echo $r->keterangan ?></td>				
				<td><?php echo anchor('cuti/delete/'.$r->id_cuti_pegawai.'?idp='.$r->id_pegawai, 'Hapus', array('group' => 'delete_link')); ?></td>
			</tr>			
		<?php endforeach; ?>
			<tr>
				<td colspan="4">Jumlah Cuti Tahunan Yg Diambil</td>
				<td><?php echo $kuota_terpakai ?></td>
			</tr>
			<tr>
				<td colspan="4">Jumlah Cuti Bersama</td>
				<!-- <td><?php echo $cuti_bersama->jumlah_cuti; ?></td> -->
				<td><?php echo $cuti_bersama; ?></td>
				
			</tr>
			<tr>
				<td colspan="4"><strong>Jumlah Cuti Tahunan Yg Tersisa</strong></td>
				<!--<td><strong><?php echo $kuota_cuti - $cuti_bersama->jumlah_cuti ?></strong></td>-->
				<td><strong><?php echo $kuota_cuti - $cuti_bersama ?></strong></td>
			</tr>
		</tbody>
	</table>
	<?php else:?>
		Tidak Ada Riwayat Cuti
	<?php endif; ?>
</fieldset>

<fieldset>
	<h2>REGISTRASI CUTI</h2>
	<table class="table">
		<tr>
			<td>Jenis Cuti</td>
			<td><div class="input-control select span6">
				<select name="cboJenisCuti">
					<option value="C_TAHUNAN">Cuti Tahunan</option>
					<option value="C_BESAR">Cuti Besar</option>
					<option value="C_SAKIT">Cuti Sakit</option>
					<option value="C_BERSALIN">Cuti Bersalin</option>
					<option value="C_ALASAN_PENTING">Cuti Karena Alasan Penting</option>
					<option value="CLTN">Cuti Diluar Tanggugan Negara</option>
					
				</div>				
			</td>
		</tr>		
		<tr>
			<td>Nomor Surat</td>
			<td><div class="input-control text span6">
				<input type="text" name="txtNoKeputusan" value="menunggu" readonly/>
			</div></td>
		</tr>
		<tr>
			<td>Tanggal Surat</td>
			<td><div class="input-control text span2"  data-role="datepicker" data-format="yyyy-mm-dd">
				<input type="text" name="datePickerTglSurat" value="<?php echo date("Y-m-d"); ?>"  />
				<span class="btn-date"/></span>
			</div></td>
		</tr>
		<tr>
			<td>TMT</td>
			<td>Dari Tanggal
			<span class="span2">
				<span class="input-control text span2" id="datepickerTmtAwal" data-role="datepicker" data-format="yyyy-mm-dd">
					<input type="text" name="txtTmtAwal"/>
					<span class="btn-date"/></span>
				</span>
			</span>		
				Hingga
			<span class="span2">
				<span class="input-control text span2" id="datepickerTmtAkhir" data-role="datepicker" data-format="yyyy-mm-dd">
					<input type="text" name="txtTmtSelesai"/>
					<span class="btn-date"/></span>
				</span>
			</span>			
			</td>
		</tr>		
		<tr>
			<td>Pengesah Surat</td>
			<td>
			<div class="input-control text span6">
				<?php
					switch ($gol) {
					case 'I/a' : 
								$ttd = "Euis Rochayati, SIP, M.Si";
								$jbtn = "Kabid Informasi Administrasi dan Kesejahteraan Pegawai";
								$pgkt = "Pembina";
								$nip = "196810231988032001";
								break;
					case 'I/b' :
								$ttd = "Euis Rochayati, SIP, M.Si";
								$jbtn = "Kabid Informasi Administrasi dan Kesejahteraan Pegawai";
								$pgkt = "Pembina";
								$nip = "196810231988032001";
								break;
					case 'I/c' :
								$ttd = "Euis Rochayati, SIP, M.Si";
								$jbtn = "Kabid Informasi Administrasi dan Kesejahteraan Pegawai";
								$pgkt = "Pembina";
								$nip = "196810231988032001";
								break;
					case 'I/d' :
								$ttd = "Euis Rochayati, SIP, M.Si";
								$jbtn = "Kabid Informasi Administrasi dan Kesejahteraan Pegawai";
								$pgkt = "Pembina";
								$nip = "196810231988032001";
								break;
					case 'II/a' :
								$ttd = "Euis Rochayati, SIP, M.Si";
								$jbtn = "Kabid Informasi Administrasi dan Kesejahteraan Pegawai";
								$pgkt = "Pembina";
								$nip = "196810231988032001";
								break;
					case 'II/b' :
								$ttd = "Euis Rochayati, SIP, M.Si";
								$jbtn = "Kabid Informasi Administrasi dan Kesejahteraan Pegawai";
								$pgkt = "Pembina";
								$nip = "196810231988032001";
								break;
					case 'II/c' :
								$ttd = "Euis Rochayati, SIP, M.Si";
								$jbtn = "Kabid Informasi Administrasi dan Kesejahteraan Pegawai";
								$pgkt = "Pembina";
								$nip = "196810231988032001";
								break;
					case 'II/d' :
								$ttd = "Euis Rochayati, SIP, M.Si";
								$jbtn = "Kabid Informasi Administrasi dan Kesejahteraan Pegawai";
								$pgkt = "Pembina";
								$nip = "196810231988032001";
								break;
					case 'III/a' :
								$ttd = "Ida Priatni, S.H";
								$jbtn = "Sekertaris";
								$pgkt = "Pembina Tk.I";
								$nip = "195903171981012002";
								break;
					case 'III/b' :
								$ttd = "Ida Priatni, S.H";
								$jbtn = "Sekertaris";
								$pgkt = "Pembina Tk.I";
								$nip = "195903171981012002";
								break;
					case 'III/c' :
								$ttd = "Ida Priatni, S.H";
								$jbtn = "Sekertaris";
								$pgkt = "Pembina Tk.I";
								$nip = "195903171981012002";
								break;
					case 'III/b' :
								$ttd = "Ida Priatni, S.H";
								$jbtn = "Sekertaris";
								$pgkt = "Pembina Tk.I";
								$nip = "195903171981012002";
								break;
					case 'III/c' :
								$ttd = "Ida Priatni, S.H";
								$jbtn = "Sekertaris";
								$pgkt = "Pembina Tk.I";
								$nip = "195903171981012002";
								break;
					case 'III/d' :
								$ttd = "Ida Priatni, S.H";
								$jbtn = "Sekertaris";
								$pgkt = "Pembina Tk.I";
								$nip = "195903171981012002";
								break;
					default :
								$ttd = "Dwi Roman Pujo Prasetyo, S.H., M.M.";
								$jbtn = "Kaban BKPP Kota Bogor";
								$pgkt = "Pembina Tk.I";
								$nip = "195807161993031001";
								break;
					}
				?>
				<input type="text" class="span6" name="txtPengesah" value="<?php echo $ttd?>" />
			</div>
			</td>
		</tr>
		<tr>
			<td>Jabatan</td>
			<td>
			<div class="input-control text span6">
				<input type="text" class="span6" name="txtJabatanPengesah" value="<?php echo $jbtn; ?>" />
			</div>
			</td>
		</tr>
		<tr>
			<td>Pangkat</td>
			<td>
			<div class="input-control text span6">
				<input type="text" class="span6" name="txtPangkatPengesah" value="<?php echo $pgkt; ?>" />
			</div>
			</td>
		</tr>
		<tr>
			<td>NIP</td>
			<td>
			<div class="input-control text span6">
				<input type="text" class="span6" name="txtNipPengesah" value="<?php echo $nip; ?>" />
			</div>
			</td>
		</tr>
		<tr>
			<td>Keterangan</td>
			<td>
			<div class="input-control textarea span6">
				<textarea class="span6" name="txtKeterangan"></textarea>
			</div>
			</td>
		</tr>
	</table>
</fieldset>
<fieldset>
	<div style="margin-left=3opc">

&nbsp;&nbsp;
&nbsp;&nbsp;
&nbsp;&nbsp;
&nbsp;&nbsp;
&nbsp;&nbsp;
&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;
&nbsp;&nbsp;
&nbsp;&nbsp;
&nbsp;&nbsp;
&nbsp;&nbsp;
&nbsp;&nbsp;
&nbsp;&nbsp;
&nbsp;&nbsp;<input type="submit" name="simpan" value="Simpan" class="button default" /> 

</div>
<!--<input type="submit" name="simpan" value="Simpan & Cetak Surat" class="button primary" />-->
</fieldset	>
<?php echo form_close(); ?>
<?php endif; ?>
<script>
$(document).ready(function(){
	var d = new Date();
	var tgl_skg = d.getFullYear();
	
	
	
	$("input[name='txtKeyword']").focus();
	
	$("input[type='submit']").click(function(){
		return confirm("Yakin akan menambahkan data cuti?");
	});
	
	$("a[group='delete_link']").click(function(){
		if(confirm('Hapus data cuti ini?')){
			return true;
		}
		return false;
	});
	
	$("input[name='txtTmtAwal']").datepicker({
	  onSelect: function() {
		alert('');
	  }
	});
	
	$("select[name='cboJenisCuti']").change(function(){
		$("#label_keterangan_cuti").html('');
		switch($("select[name='cboJenisCuti']").val()){
			case "C_TAHUNAN":	
				$("#label_keterangan_cuti").html('Loading kuota cuti tahunan . . .');
				$.post('<?php echo site_url() ?>cuti/json_get_kuota_cuti_tahunan', {id_pegawai: <?php echo $pegawai->id_pegawai; ?>, year: (new Date).getFullYear() }, function(data){
					$("#label_keterangan_cuti").html("Sisa Kuota Cuti Tahunan : <strong>"+ data +"</strong> hari kerja. ");
				});
				break;
			case "C_ALASAN_PENTING":
				$("#label_keterangan_cuti").html('Cuti Alasan Penting diberikan paling lama selama <strong>2 bulan</strong>');
				break;			
		}
	});
	
});
</script>
