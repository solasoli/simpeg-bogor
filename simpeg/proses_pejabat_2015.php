<?php

include 'konek.php';



$sql_jabatan11 = "select * from jabatan where tahun = 2011 order by jabatan ASC";
$result_11	= mysqli_query($mysqli,$sql_jabatan11);

$sql_jabatan15 = "select * from jabatan 
				inner join unit_kerja on jabatan.id_unit_kerja = unit_kerja.id_unit_kerja
				where jabatan.tahun = 2015 order by jabatan ASC";
$result_15	= mysqli_query($mysqli,$sql_jabatan15);

function get_jab_old($id_j){
	$query = "select * from jabatan where id_j = $id_j and tahun = 2011";
	return mysqli_fetch_object(mysqli_query($mysqli,$query));
}


function pilihan_jabatan($eselon, $unit_kerja){
	
	$query = "select * from jabatan 
				inner join unit_kerja on jabatan.id_unit_kerja = unit_kerja.id_unit_kerja
				where eselon = '".$eselon."' 
				and unit_kerja.id_unit_kerja = $unit_kerja
				and jabatan.tahun = 2011
				order by jabatan ASC";
	$result = mysqli_query($mysqli,$query);
	
	while($a = mysqli_fetch_object($result)){
		
		$hasil[] = $a;
	}
	
	return $hasil;
}


?>
<html>
	<head>
		<title>Proses Mutasi Jabatan 2015</title>
		<link href="assets/bootstrap/css/bootstrap.css" rel="stylesheet">
		<script src="js/jquery.min.js"></script>
		<script src="assets/bootstrap/js/bootstrap.js"></script>
		<style>
			table{
				font-size:12px;
			}
		
		</style>		
	</head>
	<body>
		
		<h2>Proses Mutasi Jabatan 2015</h2>
		<div class="container-fluid">
		<form>
			<table class="table table-bordered">
				<thead>
					<tr>
						<th>no</th>
						<th>Jabatan 2015</th>
						<th>Jabatan 2011</th>						
					</tr>
				</thead>
			<?php
				$x = 1;
				while($jab15 = mysqli_fetch_object($result_15)){
			?>
				<tr>
					<td><?php echo $x ?></td>
					<td>
						<?php echo $jab15->id_j." - ".$jab15->jabatan ?>
						<input type="hidden" value="<?php echo $jab15->id_j ?>" id="<?php echo "id_j".$x ?>">
					</td>
					<td>
						<?php 
							if($jab15->id_j_old < 1){
						
							echo "<select id='jabOld".$x."'>";
								foreach(pilihan_jabatan($jab15->eselon, $jab15->id_old) as $jab){
									echo "<option value='".$jab->id_j."'>".$jab->jabatan."</option>";
								}
							echo  "</select>";
						
							echo "<a onclick='simpan(".$x.")' class='btn btn-primary pull-right' id='btn".$x."'>simpan</a>";	
							
							}else{
								echo $jab15->id_j_old." - ".get_jab_old($jab15->id_j_old)->jabatan ;
							}							
						?>
					</td>
					
				</tr>
				
			<?php
				$x++;
				}			
			?>
			</table>
		</form>
		</div>
	</body>
</html>
<script>
	
function simpan(x){
		
		//alert(x);
		id_j = $("#id_j"+x).val();
		id_j_old = $("#jabOld"+x).val();
		$.post("proses_pejabat_2015_update.php",{
			id_j_old: id_j_old,
			id_j: id_j
			
			})
		.done(function(data){
			//alert(data);			
			if(data == "1"){
				$("#jabOld"+x).prop('disabled', true);
				$("#btn"+x).prop('disabled', true);
			}
		});
		
		
		//alert("oke");
}

</script>
