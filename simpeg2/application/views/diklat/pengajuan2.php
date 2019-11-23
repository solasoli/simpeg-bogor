<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<?php //echo "<pre>"; print_r($diklats); echo "</pre>"; ?>
<div class="container">
	
	<table class="table" id="kebutuhan_diklat">		
		<thead>
			<th>No</th>
			<th>Pengajuan</th>
			<th>Persetujuan</th>
		</thead>
		<tbody>
		<?php $x=1;foreach($diklats as $diklat){ ?>			
			<tr>
				<td><?php echo $x++ ?></td>
				<td >
					<h5>Pengajuan  </h5>					
					<strong>Nama Diklat : <?php echo $diklat->nama_diklat ?></strong><br>
					OPD : <?php echo $this->unit_kerja->get_unit_kerja($diklat->id_unit_kerja)->nama_baru ?><br>
					Tanggal : <?php echo $this->format->date_dmY($diklat->tgl_permintaan) ?><br>
					Bidang Diklat :
							<?php echo $diklat->id_bidang ?><br>
					Jumlah Peserta :					
						<?php echo $diklat->jumlah_peserta ?><br>
					Nama Pemohon :
						<?php echo $diklat->idpegawai_pemohon !== NULL ? $this->pegawai->get_by_id($diklat->idpegawai_pemohon)->nama_lengkap : "tidak terdefinisi"; ?><br>					
										
					
						
				</td>
				<td width="30%">
					<h5>Persetujuan  </h5>
					<b>Status Pengajuan :</b>
					<div id="statuspengajuan<?php echo $diklat->id?>">				
					<?php 					
						switch($diklat->idstatus_approve){
							case 1 : echo "Baru";break;
							case 2 : echo "Disetujui";break;
							case 3 : echo "Ditolak";break;
						}
					?>					
					</div>
					<b>Disetujui Oleh :</b>
					<div id="disetujuioleh">
						<?php echo $diklat->idpegawai_approve !== NULL ? $this->pegawai->get_by_id($diklat->idpegawai_approve)->nama_lengkap : "Tidak Terdefinisi" ?>
					
					</div>
					<b>Pada Tanggal :</b>
					<div id="tglApprovement<?php echo $diklat->id ?>">
						<?php echo $diklat->tgl_approve ? $this->format->date_dmY($diklat->tgl_approve) : "" ?>						
					</div>					
					<b>Tanggal Pelaksanaan:</b>
					<div id="pelaksanaan<?php echo $diklat->id ?>">
						<?php echo $diklat->tgl_pelaksanaan ? $this->format->date_dmY($diklat->tgl_pelaksanaan) : "" ?>						
					</div>
					<div class="button-set">
						<div class="button-dropdown">
							<button class="dropdown-toggle warning">Aksi</button>
							<ul class="dropdown-menu place-right" data-role="dropdown">
								<li>								
									<a title="Setujui" onclick="ubahstatus(<?php echo $diklat->id ?>, 2)">Setujui</a>								 
								</li>
								<li>								
									<a title="Tolak" onclick="ubahstatus(<?php echo $diklat->id ?>,3)">Tolak</a>								 
								</li>
								<li>								
									<a title="Tolak" onclick="pelaksanaan(<?php echo $diklat->id.",'".$diklat->tgl_pelaksanaan."'" ?>)">Tanggal Pelaksanaan</a>								 
								</li>							
							</ul>
						</div>					
						<a href="<?php echo base_url('diklat/download_pengajuan/'.$diklat->id) ?>" class="button primary">download</a>
						<!--button id="showDetail" onclick="showDetail(<?php echo $diklat->id?>)">Lihat Detail</button-->
						<a href="<?php echo base_url('diklat/detail/'.$diklat->id)?>" class="button default">Lihat Detail</a>
					</div>
				</td>
			</tr>		
				
		<?php } ?>
		</tbody>
	</table>
</div>

<script type="text/javascript">

	$(document).ready(function(){
		$('#kebutuhan_diklat').dataTable();		
		
	});
	function showDetail(id){
		$("#detail"+id).html("loading...");
		$.post('<?php echo base_url()."diklat/get_list_detail"; ?>', { id:id }, function(data){
						
			var html = '<table class="table"><thead><tr><th>No</th><th>Nama</th><th>NIP</th><th>Jabatan</th><th>Unit Kerja</th></tr></thead>' ;
			html += '<tbody>';
			$(JSON.parse(data)).each(function() {  
				 html += '<tr>';
				 html += '<td></td>';
				 html += '<td>'+ this.nama_lengkap+'</td>';
				 html += '<td>'+this.nip_baru+'</td>';
				 html += '<td>'+this.jabatan +'</td>';
				 html += '<td>'+this.nama_baru+'</td>';
				 html += '</tr>';
				 
			});
			html += '</tbody></table><br><br>';
			//alert(html);
			$("#detail"+id).html(html);
		});
	}
	
	function showDetail_(id){
			$.Dialog({
				overlay: true,
				shadow: true,
				flat: true,
				width: '80%',
				height: '100%',
				padding: 1,
				//icon: '<img src="images/excel2013icon.png">',
				title: 'Daftar Nominatif Peserta Diklat',
				
				
			
				onShow: function(_dialog){
					var content = _dialog.children('.content');
					
					$.post('<?php echo base_url()."diklat/get_list_detail"; ?>', { id:id }, function(data){
						
						var html = '<table class="table"><thead><tr><th>No</th><th>Nama</th><th>NIP</th><th>Jabatan</th><th>Unit Kerja</th></tr></thead>' ;
						html += '<tbody>';
						$(JSON.parse(data)).each(function() {  
							 html += '<tr>';
							 html += '<td></td>';
							 html += '<td>'+ this.nama_lengkap+'</td>';
							 html += '<td>'+this.nip_baru+'</td>';
							 html += '<td>'+this.jabatan +'</td>';
							 html += '<td>'+this.nama_baru+'</td>';
							 html += '</tr>';
							 
						});
						html += '</tbody></table><br><br>';
						//alert(html);
						content.html(html);
					});
															
				}
			});
		}
	
	function ubahstatus(id, status){
	
		$.post('<?php echo base_url()."diklat/ubah_status"; ?>', { id:id, status: status }, function(data){
			if(data == 'BERHASIL'){
				if(status == 2) stat = "Disetujui"; else{ stat = "Ditolak"}				
				$("#statuspengajuan"+id).html(stat);
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
		$("#pelaksanaan"+id).html("<div class='input-control text'><input type='text' name='tglpelaksanaan' id='tglpelaksanaan"+id+
							"' data-format='DD-MM-YYYY' data-template='DD MMM YYYY' class='datepicker' value='"+tgl+"'>"+
							"</div><button class='small' id='saveTgl"+id+"'><i class='icon-floppy'></i></button></div><button class='small' id='cancel"+id+"'><i class='icon-cancel-2'></i></button>");
			
		$(function(){
			$('#tglpelaksanaan'+id).combodate({
				    minYear: 2016,
					maxYear: 2018,
			});    
		});
		
		$("#saveTgl"+id).click(function(){
			tgl = $("#tglpelaksanaan"+id).val();
			
			$.post('<?php echo base_url()."diklat/simpan_tgl_pelaksanaan"; ?>', { id:id, tgl_pelaksanaan: tgl }, function(data){
				if(data == 'BERHASIL'){								
					$("#pelaksanaan"+id).html(tgl);
				}else{
					alert("gagal merubah menyimpan tanggal pelaksanaan");
				}
			});
		});
	  
	}
	
	
	
</script>