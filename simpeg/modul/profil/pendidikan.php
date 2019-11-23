<table width="100%" border="0" cellpadding="3" cellspacing="0" class="table table-bordered">
        <tr>
  <td>No</td>
  <td>Tingkat Pendidikan</td>
  <td>Lembaga Pendidikan</td>
  <td>Jurusan</td>
  <td>Tahun Lulus</td>
  <td>Tgl Ijazah <br/>tttt-bb-hh</td>
  <td>No Ijazah</td>
  <td>Berkas Ijazah</td>

  <td>Aksi</td>

<?php
$j=1;
$qp=mysqli_query($mysqli, "select * from pendidikan where id_pegawai=$od order by level_p");
while($pen=mysqli_fetch_array($qp))
{
	echo("<tr>
  <td>$j</td>
  <td>"); ?>
  <select class="form-control" name="tp<? echo($j); ?>" id="tp<? echo($j); ?>">
	<?php
	  $qjo2=mysqli_query($mysqli, "SELECT tingkat_pendidikan FROM `pendidikan` where tingkat_pendidikan!=' '  group by tingkat_pendidikan ");
		while($otoi2=mysqli_fetch_array($qjo2))
		{
		if(trim($pen[3])==trim($otoi2[0]))
		echo("<option value=$otoi2[0] selected>$otoi2[0]</option>");
		else
		echo("<option value=$otoi2[0]>$otoi2[0]</option>");
		}

		?>
  </select>
	</td>
  </td>
  <td><input  class='form-control' type=text <?php echo "name=lem$j id=lem$j value='$pen[2]'" ?> /></td>
  <td><input class='form-control' type=text <?php echo "name=jur$j id=jur$j value='$pen[4]'" ?> /></td>
  <td><input type=text class='form-control' <?php echo "name=lus$j id=lus$j value='$pen[5]'" ?> size='5' />
  <td><input type=text class='form-control' data-format='DD-MM-YYYY' data-template='DD MMM YYYY' <?php echo "name=tgl_ijazah$j id=tgl_ijazah$j  value='$pen[11]' size='8'" ?>/>
  <td><input type=text <?php echo "name=no_ijazah$j id=no_ijazah$j value='$pen[12]'" ?> class='form-control' />
  <input type=hidden <?php echo "name=idpen$j id=idpen$j value=$pen[0]" ?> /></td>
  <td>
	<?php
	if ($pen[7] == 0){
		echo("<input type=file name=fipen$j id=fipen$j  />");
		//echo "<input type='file' name='fipen".$j."' id='fipen".$j."' class='filestyle' data-classButton='btn btn-primary' data-input='false' data-classIcon='icon-plus' data-buttonText='Pilih File'>";
	}else{
		echo("<a href='http://103.14.229.15/simpeg/berkas.php?idb=".basename($pen[7])."' target='_blank' >View</a>");
		echo("<input type=file name=fipen$j id=fipen$j  />");
	}
?>
 </td>

 <td><a class="btn btn-primary btn-sm" onclick="hapus_pendidikan(<?php echo $pen[0]?>)">hapus</a></td>


</tr>

<?php
	$j++;


	}

$totpen=$j-1;

?>

  </tr>
<tr>
  <td>+</td>
  <td><select name="tingkat" id="tingkat" class="form-control">
	<?php
	  $qjo2=mysqli_query($mysqli, "SELECT tingkat_pendidikan FROM `pendidikan` where tingkat_pendidikan!=' '   group by tingkat_pendidikan ");
		while($otoi2=mysqli_fetch_array($qjo2))
		echo("<option value=$otoi2[0]>$otoi2[0]</option>");

		?>
  </select>

	<input name="totalpen" type="hidden" id="totalpen" value="<? echo($totpen); ?>" /></td>
  <td>
	<input type="text" name="lembaga" class="form-control" id="lembaga" size="19"/></td>
  <td><input type="text" name="jurusan" id="jurusan" class="form-control"/></td>
  <td><input type="text" name="lulusan" id="lulusan" size="5" class="form-control"/></td>
  <td><input type="text" name="tgl_ijazah" id="tgl_ijazah" class="form-control"/></td>
  <td><input type="text" name="no_ijazah" id="no_ijazah" class="form-control"/></td>
  </tr>
</table>

<script type="text/javascript">
	$(document).ready(function(){
		totalpen = $("#totalpen").val();

		for(i=1;i<=totalpen;i++){
			$("#tgl_ijazah"+i).datepicker({
				format: 'yyyy-mm-dd',
				autoclose: true
			});
		}
		$("#tgl_ijazah").datepicker({
			format: 'yyyy-mm-dd',
			 autoclose: true
		});
		$(".day").addClass("form-control");
		$(".month").addClass("form-control");
		$(".year").addClass("form-control");

	});

	function hapus_pendidikan(id){
		del = confirm("yakin akan hapus "+id);
		if(del == true){
			//alert("hapus");
			$.post("modul/profil/pendidikan_hapus.php",{id_pendidikan:id})
			 .done(function(data){
				window.location.reload();
			 });

		}else{
			//alert("kela kela, can yakin yeuh tong waka di apus");
			return false;
		}
	}
</script>
