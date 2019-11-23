<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<br>
<?php //echo "<pre>"; print_r($diklats); echo "</pre>"; ?>
<div class="container">
	<strong>DAFTAR PENGAJUAN DIKLAT</strong>
	<div class="grid">
		<div class="row" style="margin-bottom: -20px;">
			<div class="span13" style="margin-top: -10px;">
				<table class="table">
					<tr>
						<th>
							<div class="input-control select" style="width: 100%;">
								<select id="ddFilterStatus" style="background-color: #e3c800;">
									<option value="0">Semua Status</option>
									<option value="1" <?php echo $id_status=='1'?'selected':''?>>Pengajuan Baru</option>
									<option value="2" <?php echo $id_status=='2'?'selected':''?>>Disetujui</option>
									<option value="3" <?php echo $id_status=='3'?'selected':''?>>Ditolak</option>
								</select>
							</div>
						</th>

						<th>

							<?php if (isset($list_jenis)): ?>
								<div class="input-control select" style="width: 100%;">
									<select id="ddFilterJenis" style="background-color: #e3c800;">
										<option value="0">Semua Jenis</option>
										<?php foreach ($list_jenis as $ls): ?>
											<?php if($ls->id_jenis_diklat == $id_jenis): ?>
												<option value="<?php echo $ls->id_jenis_diklat; ?>" selected><?php echo $ls->jenis_diklat; ?></option>
											<?php else: ?>
												<option value="<?php echo $ls->id_jenis_diklat; ?>"><?php echo $ls->jenis_diklat; ?></option>
											<?php endif; ?>
										<?php endforeach; ?>
									</select>
								</div>
							<?php endif; ?>
						</th>

						<th><?php if (isset($list_bidang)): ?>
								<div class="input-control select" style="width: 150px;">
									<select id="ddFilterBidang" style="background-color: #e3c800;">
										<option value="0">Semua Bidang</option>
										<?php foreach ($list_bidang as $ls): ?>
											<?php if($ls->id == $id_bidang): ?>
												<option value="<?php echo $ls->id; ?>" selected><?php echo $ls->bidang; ?></option>
											<?php else: ?>
												<option value="<?php echo $ls->id; ?>"><?php echo $ls->bidang; ?></option>
											<?php endif; ?>
										<?php endforeach; ?>
									</select>
								</div>
							<?php endif; ?>
						</th>

						<th>
							<button id="btn_tampilkan" class="button primary" style="height: 35px;">
								<strong>Tampilkan</strong></button>
						</th>
					</tr>
				</table>
			</div>
		</div>
	</div>

	<table class="table bordered striped" id="kebutuhan_diklat">
		<thead style="border-bottom: solid #a4c400 2px;">
		<th width="8%">No</th>
		<th width="30%">Nama Diklat</th>
		<th width="10%">Usulan</th>
		<th>OPD</th>
		<th>Tanggal</th>
		<th width="10%">Status</th>
		<th style="width: 18%">Aksi</th>
		</thead>
		<tbody>
		<?php $x=1;foreach($diklats as $diklat){ ?>
			<tr>
				<td><?php echo $x++ ?></td>
				<td><?php echo $diklat->nama_diklat ?></td>
				<td><?php echo $diklat->jumlah_peserta ?> org</td>
				<td><?php echo $this->unit_kerja->get_unit_kerja($diklat->id_unit_kerja)->nama_baru ?></td>
				<td><?php echo $this->format->date_dmY($diklat->tgl_permintaan) ?></td>
				<td>
					<?php
					switch($diklat->idstatus_approve){
						case 1 : echo "Baru";break;
						case 2 : echo "Disetujui";break;
						case 3 : echo "Ditolak";break;
						default : echo "undefined";
					}

					?>
				</td>
				<td>
					<div class="button-set">
						<a href="<?php echo base_url('diklat/detail/'.$diklat->id)?>" class="button default">Lihat Detail</a>
						<a onclick="hapus(<?php echo $diklat->id.",'".$diklat->nama_diklat."'"?>)"  class="button danger">Hapus</a>
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

	function hapus(id, namaDiklat){
		var r = confirm("Hapus pengajuan kebutuhan diklat \n "+namaDiklat+" ?");
		if (r == true) {
			$.post('<?php echo base_url("diklat/hapus")?>',{id:id},function(data){
				if(data == 'BERHASIL'){
					window.location.reload();
				}else{
					alert("gagal menghapus \n "+data);
				}
			});

		}
	}

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

	$("#btn_tampilkan").click(function(){
		var status_diklat = $('#ddFilterStatus').val();
		var jenis = $('#ddFilterJenis').val();
		var bidang = $('#ddFilterBidang').val();
		loadDataListPengajuan(status_diklat,jenis,bidang,'<?php echo isset($_GET['page'])?$_GET['page']:1; ?>');
	});

	function loadDataListPengajuan(status_diklat,jenis,bidang,page){
		var ipp = $("#selIpp").val();
		location.href="<?php echo base_url()."diklat/list_kebutuhan_diklat/" ?>"+"?page="+page+"&ipp="+ipp+"&status="+status_diklat+"&jenis="+jenis+"&bidang="+bidang;
	}

</script>