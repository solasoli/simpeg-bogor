<h2 style="margin-left: 20px;">ADMINISTRASI PENILAIAN PRESTASI KERJA ONLINE</h2>
<?php $this->load->view('skp/header'); ?>
<br>

<div class="container">
<div class="grid">
	<div class="row">
		<div class="panel span5">
			<div class="panel-header">
				Status SKP
			</div>
			<div class="panel-content">
				<div id="status-text">
					<h2 class="text-alert"><?php echo $status_all ?><br></h2>
				</div>				
				<label>
				<button onclick="buka()"
				   class="place-left button bg-darkRed bg-hover-red fg-white fg-hover-white bd-orange" style="margin-top: 10px;margin-bottom:10px">
					<h3 style="margin: 10px 40px">TOGGLE <span class="icon-switch on-right"></span></h3>
				</button>
				</label>
				<div><span></span></div>				
			</div>
		</div>
		
		
	</div>
</div>
<div class="grid">
	<div class="row">		
		<div class="span12">
			<h3></h3>
			<table class="table bordered hovered striped" id="daftar_pegawai">
				<thead>
					<tr>
						<th>No</th>	
						<th>OPD</th>				
						<th>Status</th>				
						<th>Action</th>											
					</tr>
				</thead>
				<tbody>	
					<?php $x=1; foreach($list_skpd as $skpd){ ?>
					<tr>
						<td align="center"><?php echo $x++ ?></td>							
						<td ><?php echo $skpd->nama_baru ?></td>	
						<td ><?php echo $skpd->status ?></td>							
												
						<td >
							<div class="button-set">
								<?php if($skpd->status == 'ALLOWED'){ ?>
									<button class="danger" onclick="toggle_opd(<?php echo $skpd->id_skpd ?>)">Tutup
								<?php }else if($skpd->status == 'BLOCKED') { ?>
									<button class="success" onclick="toggle_opd(<?php echo $skpd->id_skpd ?>)">Buka
								<?php } ?>
								
									</button>
								<button onclick="detail(<?php echo $skpd->id_skpd ?>)" class="default">Detail</button>								
							</div>
						</td>
					</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
	</div>
</div>

</div>
<script type="text/javascript">
	
	function buka(){
		$.post('<?php echo base_url('skp/toggle') ?>')
		 .done(function(obj){
			 alert(obj);
			 window.location.reload();
		 });
	}
	
	function detail(id_skpd){
		//alert("buka "+id_skpd);
		window.location.replace("<?php echo base_url('skp/blocked_detail/') ?>/"+id_skpd);
	}
	
	function toggle_opd(id_skpd){
		$.post('<?php echo base_url('skp/toggle_opd') ?>',{id_skpd: id_skpd })
			 .done(function(obj){
				 alert(obj);
				 window.location.reload();
			 });

	}
	
</script>