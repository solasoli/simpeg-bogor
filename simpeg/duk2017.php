<div class="navbar">
  <div class="navbar-inner">
    <a class="brand" href="#">DAFTAR URUT KEPANGKATAN (DUK)</a>    
  </div>
</div>
<?php
include("konek.php");

$qSkpd = 	"SELECT * 
			FROM unit_kerja 
			WHERE 
				tahun = (SELECT MAX(tahun) FROM unit_kerja)
				AND id_unit_kerja = id_skpd 
			ORDER BY nama_baru ASC";
				
$rsSkpd = mysqli_query($mysqli,$qSkpd);
?>
<br/>
<div class="well">
Satuan Kerja Perangkat Daerah (SKPD) : 
<select name="id_skpd" id="id_skpd" >
	<option value="0">- SELURUH SKPD -</option>
<?php while($skpd = mysqli_fetch_array($rsSkpd)): ?>
	<option value="<?php echo $skpd[id_unit_kerja]; ?>"><?php echo $skpd[nama_baru]; ?></option>
<?php endwhile; ?>
</select>
<button class="btn" id="btnDisplay">Tampilkan</button>
<?php if($_SESSION['id_pegawai'] == 11301 ): ?>
	<a class="btn" href="generate_duk.php" target="_blank">Regenerate</a>
<?php endif; ?>
</div>

<div id="container">
</div>

<script type="text/javascript">
$(document).ready(function(){

	$("#btnDisplay").click(function(){
		$("#container").html("LOADING");
		$.post("duk_display.php", {id_unit_kerja : $("#id_skpd").val(),tahun:'2017'}, function(data){
			$("#container").html(data);
		});
	});
	
});
</script>
