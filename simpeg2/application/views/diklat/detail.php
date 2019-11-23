<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<div class="container">
	<h2>MANAJEMEN KEBUTUHAN DIKLAT </h2>
	<div class="row" style="border-top: solid 1px rgba(46, 46, 46, 0.8);border-bottom: solid 1px rgba(46, 46, 46, 0.8);">
		<nav class="horizontal-menu compact">
			<ul>
				<li style="border: solid 1px rgba(46, 46, 46, 0.8);  "><a href="#" onclick="goBack()">KEMBALI KE DAFTAR</a></li>
				
			</ul>
		</nav>
	</div>
	
	<div class="grid">
		<div class="row">
			<div class="span6">
				<div class="panel" data-role="panel">
					<div class="panel-header bg-lightBlue fg-white">
						PENGAJUAN
					</div>
					<div class="panel-content">
						<table id="diklat" class="table">
								<tr>
									<td>Jenis Diklat</td>
									<td>: <?php echo $diklat->jenis_diklat ?></td>

								</tr>
								<tr>
									<td>Nama Diklat</td>
									<td>: <?php echo $diklat->nama_diklat ?></td>
									
								</tr>
								<tr>
									<td>OPD</td>
									<td>: <?php echo $diklat->nama_baru ?></td>
									</tr>
								<tr>
									<td>Tanggal</td>
									<td>: <?php echo $this->format->date_dmY($diklat->tgl_permintaan) ?></td>
									</tr>
								<tr>
									<td>Bidang Diklat</td>
									<td>: <?php echo $diklat->bidang ?></td>
									</tr>
								<tr>
									<td>Jumlah Usulan</td>
									<td>: <?php echo $diklat->jumlah_peserta ?> Orang</td>
								</tr>
								<tr>
									<td>Pemohon</td>
									<td>: <?php echo $diklat->idpegawai_pemohon !== NULL ? $this->pegawai->get_by_id($diklat->idpegawai_pemohon)->nama_lengkap : "tidak terdefinisi"; ?></td>
								</tr>			
						</table>
					</div>
				</div>
			</div>
			<div class="span6">
				<div class="panel" data-role="panel">
					<div class="panel-header bg-lightBlue fg-white">
						PERSETUJUAN
					</div>
					<div class="panel-content">
						<table id="diklat" class="table">				
							<tr>								
								<td width="50%">Status Persetujuan</td>
								<td>: 
									<span id="statuspengajuan<?php echo $diklat->id?>">				
									<?php 					
										switch($diklat->idstatus_approve){
											case 1 : echo "Baru";break;
											case 2 : echo "Disetujui";break;
											case 3 : echo "Ditolak";break;
										}
									?>					
									</span>
								</td>
							</tr>
							<?php if($diklat->idstatus_approve != 1) { ?>
							<tr>
								<td><?php echo $diklat->idstatus_approve == 2 ? "Disetujui" : "Ditolak"?> Oleh :</td>
								<td>: <?php echo $diklat->idpegawai_approve !== NULL ? $this->pegawai->get_by_id($diklat->idpegawai_approve)->nama_lengkap : "-" ?></td>				
							</tr>
							<?php } ?>
							<tr>
								<td>Pada Tanggal</td>
								<td>: <?php echo $diklat->tgl_approve ? $this->format->date_dmY($diklat->tgl_approve) : "" ?></td>				
							</tr>
							<?php if($diklat->idstatus_approve == 2) { ?>
							<tr>
								<td>Tanggal Pelaksanaan</td>
								<td>: <span id="pelaksanaan"><?php echo $diklat->tgl_pelaksanaan ? $this->format->date_dmY($diklat->tgl_pelaksanaan) : "" ?></span></td>
							</tr>
							<?php } ?>
							<tr>
								<td colspan="2">
									<div class="button-set">															
										<a href="<?php echo base_url('diklat/download_pengajuan/'.$diklat->id) ?>" class="button primary">Download Daftar</a>
										<a title="Setujui" class="button success" onclick="ubahstatus(<?php echo $diklat->id ?>, 2)">Setujui</a>
										<a title="Tolak" class="button danger" onclick="ubahstatus(<?php echo $diklat->id ?>,3)">Tolak</a>
										<?php if($diklat->idstatus_approve == 2) { ?>
										<a title="entri tgl pelaksanaan " class="button warning" onclick="pelaksanaan(<?php echo $diklat->id.",'".$diklat->tgl_pelaksanaan."'" ?>)">Tanggal Pelaksanaan</a>
										<?php } ?>
									</div>
								</td>								
							</tr>
							<?php if($diklat->idstatus_approve == 2) { ?>
								<tr>
									<td colspan="2"><strong>Rekapitulasi Keikutsertaan Peserta</strong></td>
								</tr>
								<tr>
									<td>Jumlah Total Terbaru</td>
									<td>: <?php echo $rekap_peserta->jml_total ?> orang</td>
								</tr>
								<tr>
									<td>Jumlah yang ikut</td>
									<td>: <?php echo $rekap_peserta->jml_ikut ?> orang</td>
								</tr>
								<tr>
									<td>Jumlah yang tidak ikut</td>
									<td>: <?php echo $rekap_peserta->jml_tak_ikut ?> orang</td>
								</tr>
								<tr>
									<td>Penambahan Baru</td>
									<td>: <?php echo $rekap_peserta->jml_baru ?> orang</td>
								</tr>
							<?php } ?>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
	<h3>DAFTAR CALON PESERTA DIKLAT<h3>
	<div class="grid">
		<div class="tab-control" data-role="tab-control" data-effect="fade">
			<ul class="tabs">
				<li class="active"><a href="#_page_1">Usulan dari OPD</a></li>
				<?php if($diklat->idstatus_approve == 2): ?>
				<li><a href="#_page_2">Penambahan Usulan</a></li>
				<?php endif; ?>
			</ul>
			<div class="frames">
				<div class="frame" id="_page_1">
					<div id="div1">
						<?php if($diklat->idstatus_approve == 2): ?>
						<a onclick="update_keikutpesertaan(<?php echo $diklat->id?>)" class="button default" style="margin-bottom: 15px;">
							Update Keikutsertaan Peserta</a><?php endif; ?>
						<table class="table bordered striped" id="detail">
							<thead>
							<tr>
								<?php if($diklat->idstatus_approve == 2): ?><th><input type="checkbox" id="checkAllList"><br>
									Diikutkan
								</th><?php endif; ?>
								<th>No</th><th>Nama</th><th>NIP</th><th>Pangkat</th><th>Usia</th><th>Jabatan</th><th>Unit Kerja</th>
							</tr>
							</thead>
							<tbody>
							<?php if(sizeof($details) > 0){ ?>
								<?php $x=1;foreach($details as $detail) {?>
									<tr>
										<?php if($diklat->idstatus_approve == 2): ?>
											<td style="text-align: center;">
												<input type="checkbox" value="<?php echo $detail->id_pegawai.':'.$detail->nip.':'.$detail->nama; ?>"
													   id="chkUnit<?php echo $detail->id_pegawai; ?>"
													   name="chkUnit<?php echo $detail->id_pegawai; ?>"
														<?php echo $detail->status==true?'checked':'';?>>
											</td>
										<?php endif; ?>
										<td><?php echo $x++ ?></td>
										<td><?php echo $detail->nama?></td>
										<td><?php echo $detail->nip ?></td>
										<td><?php echo $detail->pangkat_gol ?></td>
										<td><?php echo $detail->usia ?></td>
										<td><?php echo $detail->jabatan ?></td>
										<td><?php echo $detail->unit ?></td>
									</tr>
								<?php } }else{?>
								<td colspan="5" align="center" class="danger">TIDAK ADA DATA</td>
							<?php } ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<?php if($diklat->idstatus_approve == 2): ?>
			<div class="frames">
				<div class="frame" id="_page_2">
				</div>
			</div>
			<?php endif; ?>
		</div>
	</div>
</div>
<script type="text/javascript">

	$(document).ready(function(){
		//$("#detail").datatable();
		$("#checkAllList").change(function () {
			$("#div1 input:checkbox").prop('checked', $(this).prop("checked"));
		});
	});
	
	function goBack() {
		window.history.back();
	}
	
	function ubahstatus(id, status){
	
		$.post('<?php echo base_url()."diklat/ubah_status"; ?>', { id:id, status: status }, function(data){
			if(data == 'BERHASIL'){
				//if(status == 2) stat = "Disetujui"; else{ stat = "Ditolak"}				
				//$("#statuspengajuan"+id).html(stat);
				location.reload();
			}else{
				alert("gagal merubah status pengajuan");
			}
		});		
	}
	
	function pelaksanaan(id, tgl){
		
		
		if(tgl){
			tahun = tgl.substr(0,4);
			bulan = tgl.substr(5,2);
			hari = tgl.substr(8,2);
		
			tgl = hari+"-"+bulan+"-"+tahun;
		}
		
		//alert(tgl);
		$("#pelaksanaan").html("<span class='input-control text'><input type='text' name='tglpelaksanaan' id='tglpelaksanaan"+
							"' data-format='DD-MM-YYYY' data-template='DD MMM YYYY' class='datepicker' value='"+tgl+"'>"+
							"</span><button class='small' id='saveTgl'><i class='icon-floppy'></i></button></div><button class='small' id='cancel'><i class='icon-cancel-2'></i></button>");
			
		$(function(){
			$('#tglpelaksanaan').combodate({
				    minYear: 2016,
					maxYear: 2018,
			});    
		});
		
		$("#saveTgl").click(function(){
			tgl = $("#tglpelaksanaan").val();
			
			$.post('<?php echo base_url()."diklat/simpan_tgl_pelaksanaan"; ?>', { id:id, tgl_pelaksanaan: tgl }, function(data){
				if(data == 'BERHASIL'){								
					//$("#pelaksanaan"+id).html(tgl);
					location.reload();
				}else{
					alert("gagal merubah menyimpan tanggal pelaksanaan");
				}
			});
		});
	  
	}

	function update_keikutpesertaan(id){
		var r = confirm("Ingin mengubah keikutsertaan peserta?");
		if (r == true) {
			$.post('<?php echo base_url("diklat/ubah_keikutpesertaan_diklat")?>',{id_diklat:id},function(data){
				if(data == 'BERHASIL'){
					window.location.reload();
				}else{
					alert("gagal mengubah \n "+data);
				}
			});

		}
	}

</script>