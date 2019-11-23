<h2>HASIL PROSES CUTI</h2>
<br/>
<table class="table">
	<!--<tr>
		<td>Jenis Cuti</td>
		<td><div class="input-control select span6">
			<select name="cboJenisCuti">
				<option value="C_TAHUNAN">Cuti Tahunan</option>
				<option value="C_BESAR">Cuti Besar</option>
				<option value="C_SAKIT">Cuti Sakit</option>
				<option value="C_BERSALIN">Cuti Bersalin</option>
				<option value="C_ALASAN_PENTING">Cuti Karena Alasan Penting</option>
				<option value="CLTN">Cuti Diluar Tanggugan Negara</option>
			</select>
			</div>				
		</td>
	</tr>-->		
	
	<tr>
		<td>TMT Dari Tanggal</td>
		<td>
		<span class="span2">
			<span class="input-control text span2 " id="dp2" data-role="datepicker" data-format="yyyy-mm-dd">
				<input  class="datepicker" type="text" name="txtTmtAwal"/>
			</span>
		</span>		
	</tr>
	
	<tr>
		<td>TMT Sampai Tanggal</td>
		<td>
		<span class="span2">
			<span class="input-control text span2" id="dp3" data-role="datepicker" data-format="yyyy-mm-dd">
				<input class="datepicker" type="text" name="txtTmtSelesai"/>
			</span>
		</span>			
		</td>
	</tr>				
	
	<tr>
		<td>Status</td>
		<td>
			<button type="submit" name="simpan" class="btn btn-success" >Disetujui</button>
		</td>
	</tr>		
</table>

<script>

$(document).ready(function(){
	
	$('.datepicker').datepicker({
			 format: 'yyyy-mm-dd',
			 startDate: '-3d'
	});
});

	
</script>



