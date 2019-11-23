<h1>PENJAGAAN KENAIKAN GAJI BERKALA</h1>
<hr/>
<fieldset>
<label>SKPD</label>
<select id="cboSkpd">
	<option value="-1">SEMUA SKPD</option>	
</select>
<label>Tahun</label>
<select id="cboTahun">
	<?php for($t = date("Y")-5; $t <= date("Y")+5; $t++): ?>
	<option <?php if($t == date("Y")) echo "selected"; ?> value="<?php echo $t ?>"><?php echo $t ?></option>
	<?php endfor; ?>
</select>
<label>Bulan</label>
<select id="cboBulan">
	<option value="01">Januari</option>
	<option value="02">Februari</option>
	<option value="03">Maret</option>
	<option value="04">April</option>
	<option value="05">Mei</option>
	<option value="06">Juni</option>
	<option value="07">Juli</option>
	<option value="08">Agustus</option>
	<option value="09">September</option>
	<option value="10">Oktober</option>
	<option value="11">November</option>
	<option value="12">Desember</option>
</select>
<button id="btnView">Tampilkan</button>
</fieldset>
<div id="kgb">
<table class="table bordered striped" >
<thead>
	<tr>
		<th>No</th>
		<th>Nama</th>
		<th>NIP</th>
		<th>Golongan</th>
		<th>TMT Sebelumnya</th>	
		<th>Unit Kerja</th>	
		<th>Status</th>	
	</tr>	
</thead>
<tbody id="kgb_list">
</tbody>
</div>
<script>
$(document).ready(function(){
	$.post('../simpeg2/index.php/unit_kerja/json_get_current_all', {}, function(data){
		var skpd = jQuery.parseJSON(data);
		for(var i = 0; i < skpd.length;i++){
			$("#cboSkpd").append("<option value='"+skpd[i].id_unit_kerja+"'>"+skpd[i].nama_baru+"</option>");
		}
	});
	
	$("#btnView").click(function(){
		$.post('../simpeg2/index.php/kgb/json_nominatif', {
				skpd: $("#cboSkpd").val(),
				tahun: $("#cboTahun").val(),
				bulan: $("#cboBulan").val()				
			}, 
			function(data){
				var peg = jQuery.parseJSON(data);
				$("#kgb_list").html('');
				var no = 1;
				for(var i = 0; i <= peg.length;i++){
					var status = "";
					var color = "";
					if((peg[i].TMT_KGB_TERAKHIR).substring(0,7) == $("#cboTahun").val() + "-" + $("#cboBulan").val() ){
						status = "<span class='label label-success'>Selesai</span>";
						color = "style='color:#009900'";
					}
					else if(peg[i].no_sk == ''){
						status = "<span class='label label-danger'>Berkas Tdk.Lengkap</span>";
					}
					else{
						status = "<span class='label label-warning'>Proses</span>";
					}
					$("#kgb_list").append("<tr>" +
						"<td>"+ no +"</td>" +
						"<td>"+ peg[i].NAMA +"</td>" +
						"<td>"+ peg[i].NIP +"</td>" +
						"<td>"+ peg[i].GOLONGAN +"</td>" +
						"<td>"+ peg[i].TMT_KGB_TERAKHIR +"</td>" +
						"<td>"+ peg[i].UNIT_KERJA +"</td>" +
						"<td>"+ status  + "</td>" +
					"</tr>");
					no++;
				}
				
				console.log(peg);			
		});
	});
});
</script>
