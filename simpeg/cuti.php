<link rel="stylesheet" type="text/css" href="tcal.css" />
<script type="text/javascript" src="tcal.js"></script>
<script type="text/javascript">
function jatah2()
{
		var jenis = document.getElementById('cboJenisCuti').value;
	if(jenis=='C_TAHUNAN')	
	{
$.ajax({
   type:"POST",
   url:"jatahcuti.php",
   dataType:"json",
   data: "idp=<?php echo $_SESSION['id_pegawai']; ?>",
   success: function (data)
   {
 $("#sisa").html(data[0].sisana+' Hari Kerja');
$("#jatah").val(data[0].sisana);
   
  }
   
   }); 	
	}
	else
	{
		
		 $("#sisa").html('under construction');
	}
	
	
}
function cekhari()
{
var awal = document.getElementById('txtTmtAwal').value;
var akhir = document.getElementById('txtTmtSelesai').value;
var skr = '<?php echo(date("d-m-Y")); ?>';

Date.prototype.addDays = function(days) {
    var date = new Date(this.valueOf())
    date.setDate(date.getDate() + days);
    return date;
}
function getBusinessDatesCount(startDate, endDate) {
    var count = 0;
    var curDate = startDate;
    while (curDate <= endDate) {
        var dayOfWeek = curDate.getDay();
        var isWeekend = (dayOfWeek == 6) || (dayOfWeek == 0); 
        if(!isWeekend)
           count++;
        curDate = curDate.addDays(1);
    }
    return count;
}
var startDate = new Date(awal.substr(3,2)+"/"+awal.substr(0,2)+"/"+awal.substr(6,4));
var endDate = new Date(akhir.substr(3,2)+"/"+akhir.substr(0,2)+"/"+akhir.substr(6,4));
var selisih = getBusinessDatesCount(startDate,endDate);
var jatah = document.getElementById('jatah').value;
if ($.datepicker.parseDate('dd-mm-yy', akhir) < $.datepicker.parseDate('dd-mm-yy', awal)) {
       alert('Dari Tanggal harus Sebelum Sampai Tanggal');
}
else
{       
if ($.datepicker.parseDate('dd-mm-yy', awal) < $.datepicker.parseDate('dd-mm-yy', skr))
alert('Dari Tanggal tidak boleh sebelum hari ini');
else if(selisih>jatah)
alert('Jumlah hari maksimum '+jatah+' Hari Kerja');
else
document.form_cuti.submit();
}
}
</script>
<?PHP
	$mysqli = new mysqli("simpeg.db.kotabogor.net","simpeg","Madangkara2017","simpeg");
?>
<div role="tabpanel">
	<ul class="nav nav-tabs" role="tablist" id="myTab">
		<li role="presentation" class="active"><a href="#registrasi" aria-controls="registrasi" role="tab" data-toggle="tab">Registrasi</a></li>
		
	</ul> 
	
	<div class="tab-content">
		<div role="tabpanel" class="tab-pane active" id="registrasi">
			<h2>REGISTRASI CUTI</h2>
			<?php
				extract($_POST);
				$q=mysqli_query($mysqli,"select * from cuti_pegawai where id_pegawai='".$_SESSION['id_pegawai']."'");
	$data_cuti=mysqli_fetch_array($q);
	
	$qbos=mysqli_query($mysqli,"select id_j from pegawai where id_pegawai=$_SESSION[id_pegawai]");
	$bos=mysqli_fetch_array($qbos);
	if($bos[0]!=NULL)
	{
	$qatas1=mysqli_query($mysqli,"select id_bos,id_unit_kerja from jabatan where id_j=$bos[0]");
	$atas1=mysqli_fetch_array($qatas1);		
	$qatas2=mysqli_query($mysqli,"select id_bos,id_unit_kerja from jabatan where id_j=$atas1[0]");
	$atas2=mysqli_fetch_array($qatas2);
	$qatas3=mysqli_query($mysqli,"select id_bos,id_unit_kerja from jabatan where id_j=$atas2[0]");
	$atas3=mysqli_fetch_array($qatas3);
	
	
	$qa1=mysqli_query($mysqli,"select id_pegawai from pegawai where id_j=$atas1[0]");
	$qa2=mysqli_query($mysqli,"select id_pegawai from pegawai where id_j=$atas2[0]");
	
	$a1=mysqli_fetch_array($qa1);
	$a2=mysqli_fetch_array($qa2);
	
	if($atas2[1]!=$atas3[1])
	$tempat=2;
	else
	$tempat=1;
	}
	else
	{
	$qbos=mysqli_query($mysqli,"select id_j_bos from riwayat_mutasi_kerja where id_pegawai=$_SESSION[id_pegawai] order by id_riwayat desc");	
	$bos=mysqli_fetch_array($qbos);
	
	$qatas1=mysqli_query($mysqli,"select id_bos,id_unit_kerja from jabatan where id_j=$bos[0]");
	$atas1=mysqli_fetch_array($qatas1);		
	$qatas2=mysqli_query($mysqli,"select id_bos,id_unit_kerja from jabatan where id_j=$atas1[0]");
	$atas2=mysqli_fetch_array($qatas2);
	
	
	$qa1=mysqli_query($mysqli,"select id_pegawai from pegawai where id_j=$bos[0]");
	$qa2=mysqli_query($mysqli,"select id_pegawai from pegawai where id_j=$atas1[0]");
	
	$a1=mysqli_fetch_array($qa1);
	$a2=mysqli_fetch_array($qa2);
	
		
	if($atas2[1]!=$atas1[1])
	$tempat=2;
	else
	$tempat=1;
	}
	
			?>
			<br/>
			<form method="POST" action="index3.php" name="form_cuti" id="form_cuti">
				<table class="table">
				<tr>
					<td>Jenis Cuti</td>
					<td><div class="input-control select span6">
                    <input type="hidden" id="x" name="x" value="simpen_cuti.php" />
						<select name="cboJenisCuti" id="cboJenisCuti" onchange="jatah2()">
                        <option value="0">Pilih Jenis Cuti</option>
							<option value="C_TAHUNAN">Cuti Tahunan</option>
							<option value="C_BESAR">Cuti Besar</option>
							<option value="C_SAKIT">Cuti Sakit</option>
							<option value="C_BERSALIN">Cuti Bersalin</option>
							<option value="C_ALASAN_PENTING">Cuti Karena Alasan Penting</option>
							<option value="CLTN">Cuti Diluar Tanggugan Negara</option>
						</select>
						<input type="hidden" name="jatah" id="jatah" />
				      <input type="hidden" name="tempat" id="tempat" value="<?php echo($tempat) ?>" />
				      <input name="atas1" type="hidden" id="atas1" value="<?php echo $a1[0]; ?>" />
					  <input name="atas2" type="hidden" id="atas2" value="<?php echo $a2[0]; ?>" />
					</div>				
					</td>
				</tr>
				<tr>
				  <td>Jumlah Hari Cuti Yang Dapat Diambil</td>
				  <td> <div id="sisa"> </div> </td>              
				  </tr>
				<tr>
					<td>TMT</td>
					<td>Dari Tanggal
						<span class="span2">
						<span class="input-control text span2 ">
							<input name="txtTmtAwal" id="txtTmtAwal" type="text" class="tcal" id="txtTmtAwal" value="<?php 
								 				echo date("d-m-Y");
						 ?>"/>
						</span>
					</span>		
				</tr>
				<tr>
					<td></td>
					<td>Sampai Tanggal
					<span class="span2">
						<span class="input-control text span2">
							<input name="txtTmtSelesai" type="text" class="tcal"  id="txtTmtSelesai" />
						</span>
					</span>			
					</td>
				</tr>
				<tr>
					<td>Alamat selama cuti</td>
					<td>
						<div class="input-control textarea span6">
							<textarea class="span6" name="txtKeterangan"></textarea>
						</div>
					</td>
				</tr>
				<tr>
				  <td>&nbsp;</td>
				  <td>&nbsp;</td>
				  </tr>
				</table>
				
				
			</form>
			<div style="margin-left:295px; margin-right:350px;">
	<button onclick="cekhari()" type="button" name="simpan" id="simpan" class="btn btn-primary" >Simpan</button>&nbsp;
		
		
		
	
	
</div>
			<br/>
			<br/>
			
		</div>	
	</div>
</div>

