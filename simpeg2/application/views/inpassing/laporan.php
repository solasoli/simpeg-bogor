<h2>Cetak Inpassing <small>Tahun </small><?php echo date('Y') ?></h2>

<?php if(!abs($this->input->get('skpd')) > 0): ?>
	
	<?php  echo form_open('pdf/inpassing_gaji', array('method' => 'get', 'target' => '_blank')); ?>
	<div class="grid offset1">
		<div class="row">			
			<div class="span2">
				<div class="input-control text">
					<label>Nomor</label>					
				</div>
			</div>
			<div class="span8">
				<div class="input-control text span4">
					<input type="text" name="no">
				</div>
			</div>
		</div>
		<div class="divider"></div>
		<div class="row">
			<div class="span2"><div class="input-control text">
					<label>TMT</label>					
				</div>
			</div>
			<div class="span8">
				<div class="input-control text span4" id="datepicker" data-role="datepicker" data-format="dd-mm-yyyy">
					<input type="text" name="tmt"/>
					<span class="btn-date"/></span>
				</div>
			</div>			
		</div>
		<div class="row">
			<div class="span2"><div class="input-control text">
					<label>SKPD</label>					
				</div>
			</div>
			<div class="span8">
				<div class="input-control select span4">
					<select name="skpd">
						<option value="-1">-PILIH-</option>
						<?php foreach($skpd as $s): ?>
						<option <?php if($this->input->get('skpd') == $s->id_skpd) echo  'selected' ?> value="<?php echo $s->id_skpd ?>"><?php echo $s->nama_baru ?></option>					
						<?php endforeach; ?>
					</select>
				</div>
			</div>			
		</div> <!-- end row -->
		<div class="row">
			<div class="span2"><div class="input-control text">
					<label>Tahun PP</label>					
				</div>
			</div>
			<div class="span8">
				<div class="input-control text span2">
					<select name="tahun">
					<?php for($i = date("Y"); $i > date("Y")-5; $i--): ?>
					<option <?php 
								if( $this->input->get('tahun') == $i) 
									echo 'selected';
								else if(date("Y") == $i && $this->input->get('tahun') == '') 
									echo 'selected' ?> value = "<?php echo $i 
					?>"><?php echo $i ?></option>
					<?php endfor; ?>
				</select>
				</div>
			</div>			
		</div> <!-- end row -->
		<div class="row">
			<input type="submit" value="Tampilkan" />
		</div>
	</div>
		
	<?php echo form_close(); ?>
	
	
<?php endif; ?>
