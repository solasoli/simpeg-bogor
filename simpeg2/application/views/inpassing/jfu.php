<div class="container fluid">
<legend><h2>Penyesuaian Jabatan Fungsional Umum <small><?php echo date('Y') ?></small></h2></legend>
<?php echo $this->uri->segment(3) ? $this->skpd_model->get_by_id($this->uri->segment(3))->nama_baru : "kosong" ;?>
<?php if(!abs($this->input->get('skpd')) > 0): ?>
	
	<?php // echo form_open('pdf/inpassing_jfu', array('method' => 'get', 'target' => '_blank','id'=>'formJfu')); ?>
	<div class="grid">		
		<div class="row">
			<div class="span2"><div class="input-control text">
					<label>OPD</label>					
				</div>
			</div>
			<div class="span4">
				<div class="input-control select"  style="width:350px;" tabindex="2">
					<select name="skpd" class="chosen-select" id="skpd" data-placeholder="Cari OPD">
						<?php if($this->uri->segment(3)){ 
							echo "<option value=''>".$this->skpd_model->get_by_id($this->uri->segment(3))->nama_baru."</option>";
						}else{
							echo "<option> Pilih OPD</option>";
						}						
						?>						
						<?php foreach($skpd as $s): ?>
						<option <?php if($this->input->get('skpd') == $s->id_skpd) echo  'selected' ?> value="<?php echo $s->id_skpd ?>"><?php echo $s->nama_baru ?></option>					
						<?php endforeach; ?>
					</select>
				</div>
			</div>			
		</div> <!-- end row -->
		
		<div class="row">
			<button class="button default" id="btnCetak" >Cetak SK" </button>
		</div>
	</div>		
	<?php // echo form_close(); ?>

	<div class="container fluid" id="generated_daftar_jfu">
	<table class="table bordered hovered" id="daftar_jfu">
		<thead>
			<tr>
				<th>No</th>
				<th>Nama</th>
				<th>NIP</th>
				<th>Gol/Ruang</th>
				<th>Jabatan Lama</th>
				<th>Jabatan Baru</th>
				<th>Unit Kerja</th>
			<tr>
		</thead>
		<tbody>		
			<?php if($this->uri->segment(3) && sizeof($pegawai > 0)){ 
				$x =1;
				foreach($pegawai as $peg){
			?>
			<tr>
				<td><?php echo $x++ ;?></td>
				<td><?php echo anchor(base_url('pegawai/edit/2/'.$peg->id_pegawai),$this->pegawai->get_by_id($peg->id_pegawai)->nama)?></td>
				<td><?php echo $this->pegawai->get_by_id($peg->id_pegawai)->nip_baru?></td>
				<td><?php echo $this->pegawai->get_by_id($peg->id_pegawai)->pangkat_gol?></td>
				<td><?php echo $this->pegawai->get_by_id($peg->id_pegawai)->jabatan?></td>
				<td><?php echo $this->jabatan->get_jabatan_pegawai($peg->id_pegawai)?></td>
				<td><?php echo $peg->nama_baru?></td>
			<tr>
			<?php }}else { ?>
			<tr>
				<td colspan=5>tidak ada data</td>
			<tr>
			<?php } ?>
		</tbody>
		</table>
	
	</div>
	
<?php endif; ?>
</div>

<div id="ubahJfu">
<!--input type='text' name='jfu' id='jfu' placeholder='ketik jfu' >
</div-->

<script src="<?php echo base_url()?>js/jquery/chosen.jquery.js"></script>
<script>
	$('.chosen-select').chosen();
	
	$('#skpd').on('change',function(){
				skpd = $('#skpd').val();
		//alert(skpd);
		window.location.replace("<?php echo base_url('inpassing/jfu/')?>/"+skpd);		
	});
	//$('#daftar_jfu').dataTable();
	
	/*$("#edit_jfu").on('click',function(){
	
		//alert('jfu');
				
		
	}); */
	
	$("#btnCetak").on('click', function(){
        $.Dialog({
            overlay: true,
            shadow: true,
            flat: true,
            //draggable: true,
                    //icon: '<img src="images/excel2013icon.png">',
                                //title: 'Flat window',
            content: '',
            padding: 10,
            onShow: function(_dialog){
                var content = '<form class="user-input span6" action="<?php echo base_url('pdf/inpassing_jfu')?>" method="get" target="_blank">' +
                '<label>No. SK :</label>' +
                '<div class="input-control text"><input type="text" name="no" value="823/190-BKPP"></div>' + //823/35-BKPP
				'<label>Tgl SK :</label>' +
				'<div class="input-control text" id="datepicker" data-role="datepicker" data-format="dd-mm-yyyy">'+				
				'<input type="text" name="tgl" value="31-12-2013" id="tgl">'+
				'<span class="btn-date"/></span></div>'+
				'<label>TMT :</label>' +
				'<div class="input-control text" id="datepicker" data-role="datepicker" data-format="dd-mm-yyyy">'+				
				'<input type="text" name="tmt" value="01-01-2014" id="tmt">'+
				'<span class="btn-date"/></span></div>'+
				'<input type="hidden" name="skpd" value="<?php echo $this->uri->segment(3)?>">' +
                '<div class="form-actions">' +
                '<button class="button primary">Simpan dan Cetak</button>&nbsp;'+
                '<button class="button" type="button" onclick="$.Dialog.close()">Batal</button> '+
                '</div>'+
                '</form>';

                $.Dialog.title("Cetak Petikan");
                $.Dialog.content(content);
            }
        });
    });
	$.Dialog.close();
		
</script>
