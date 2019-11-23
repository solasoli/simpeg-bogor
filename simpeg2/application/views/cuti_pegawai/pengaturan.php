

<div class="container">
	<h1>Pengaturan <small> Hari Libur Nasional dan Cuti Bersama</small></h1>

	<ol type="A">
		<li>Hari Libur Nasional
		<table class="table">
			<thead>
				<tr>
					<th>No</th>
					<th>Tanggal</th>
					<th>Hari</th>
					<th>Keterangan</th>
					<th>Aksi</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($libur_nasionals as $ln){ ?>
				<tr>
					<td><?php echo $ln->no?></td>
					<td><?php echo $ln->tanggal?></td>
					<td><?php echo $ln->hari?></td>
					<td><?php echo $ln->ket?></td>
					<td>
						<button class="danger" onclick="hapusLN(<?php echo $ln->no ?>)">Hapus</button>
					</td>					
				</tr>
				<?php } ?>				
			</tbody>
		</table>
		<button class="button primary" id="btnTambahLN">
			<span class=" icon-box-add on-left"></span>
			<strong>Tambah</strong>
		</button>
		
		<div id="tambahLN" >
			<div class=" span6">
				
				<fieldset">
					<legend>Tambah Hari Libur Nasional</legend>
					<!--form action="#" name="formLN" id="formLN"-->
						<label for="tglLN">Tanggal Libur Nasional :</label>
						<div class="input-control text" id="LNdatepicker">							
							<input type="text" name="tglLN" id="tglLN" >
							<button class="btn-date" onclick="javascript:void(0)"></button>
						</div>
						<label for="ketLN">Keterangan Libur Nasional :</label>
						<div class="input-control text" id="datepicker">							
							<input type="text" name="ketLN" id="ketLN">							
						</div>
					<!--/form-->
				</div>
				<div>
					<button id="btnSimpanLN">simpan</button>
					<button id="btnBatalTambahLN">batal</button>
				</div>
			</fieldset>					
		</div>		
		</li>
		
		<li>Cuti Bersama
		<table class="table">
			<thead>
				<tr>
					<th>No</th>
					<th>Tanggal</th>
					<th>Hari</th>
					<th>Keterangan</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($cuti_bersamas as $cb){ ?>
				<tr>
					<td><?php echo $cb->no?></td>
					<td><?php echo $cb->tanggal?></td>
					<td><?php echo $cb->hari?></td>
					<td><?php echo $cb->ket?></td>
				</tr>
				<?php } ?>
			</tbody>
		</table>
		<button class="button primary" id="btnTambahCB">
			<span class=" icon-box-add on-left"></span>
			<strong>Tambah</strong>
		</button>
		<div id="tambahCB" >
			<div class=" span6">
				
				<fieldset">
					<legend>Tambah Cuti Bersama</legend>
					<!--form action="#" name="formLN" id="formLN"-->
						<label for="tglCB">Tanggal Libur Nasional :</label>
						<div class="input-control text" id="LNdatepicker">							
							<input type="text" name="tglLN" id="tglLN" >
							<button class="btn-date" onclick="javascript:void(0)"></button>
						</div>
						<label for="ketLN">Keterangan Libur Nasional :</label>
						<div class="input-control text" id="datepicker">							
							<input type="text" name="ketLN" id="ketLN">							
						</div>
					<!--/form-->
				</div>
				<div>
					<button>simpan</button>
					<button id="btnBatalTambahCB">batal</button>
				</div>
			</fieldset>					
		</div>		
		
		</li>
	</ul>
</div>
<script type="text/javascript">
	
	$(document).ready(function(){		
		$("#tambahLN").hide();
		$("#tambahCB").hide();
	});
		
	$("#LNdatepicker").datepicker({ format: "dd-mm-yyyy" });	 
	$("#btnTambahLN").click(function(){
		$("#btnTambahLN").hide("slow");
		$("#tambahLN").toggle("slow");
	});
	$("#btnBatalTambahLN").click(function(){		 
		$("#tambahLN").toggle("slow");
		$("#btnTambahLN").show("slow");
	});
	
	
	$("#CBdatepicker").datepicker({	format: "dd-mm-yyyy" });
	$("#btnTambahCB").click(function(){
		$("#btnTambahCB").hide("slow");
		$("#tambahCB").toggle("slow");
	});
	$("#btnBatalTambahCB").click(function(){		 
		$("#tambahCB").toggle("slow");
		$("#btnTambahCB").show("slow");
	});
	
	
	$("#btnSimpanLN").click(function(){
			//alert($("#tglLN").val());
		$.ajax({
			type: "POST",
			dataType: "json",
			url: "<?php echo base_url('cuti_pegawai/saveLiburNasional')?>",
			data: "tglLN="+$("#tglLN").val()+"&ketLN=" + $("#ketLN").val(),
			success: function(data) {						
				if(data == true){
					location.reload()
				}else{
					alert("gagal menyimpan");
				}
			}
		});
	});
	
	
	function hapusLN(no){
		
		del = confirm("yakin akan menghapus? ");
		if(del == true){				
			//alert(no);
			//$("a#"+idtarget+"").closest('tr').remove();
			$.post("<?php echo base_url('cuti_pegawai/delLiburNasional')?>",
					{no: no})
			.done(function(data){
				//alert(data);
				window.location.reload();
			});						 
			
		}
	}
</script>
