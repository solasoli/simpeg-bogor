<?php
	include "../../konek.php";
	$id = $_POST['idunsur'];
	if($id=='utama'){
		$id=1;
	}else{
		$id=2;
	}
	$sql = "select * from dupak where utama_penunjang = $id";
	$q = mysqli_query($mysqli, $sql);
	echo "<select class=\"form-control\" id=\"inputUraian\" name=\"inputUraian\" onchange='viewImgPkg(this.value)'>";
		echo "<option></option>";
	while($data = mysqli_fetch_array($q)){
		echo "<option value='$data[1]'>$data[1]</option>";
	}
	echo "</select>";
?>

<script>
	function viewImgPkg(val){
		var str = val;
		var n = str.indexOf("Merencanakan dan melaksanakan pembelajaran");
		if(n==-1){
		 	$("#divImgPkg").empty();
		 	$("#divImgPkg").css({width:'90%',height:'auto'});

		 }else{
		 	$("#divImgPkg").html("<img id='imgPkg' src=\"pkg.png\" alt=\"PKG Guru\" height=\"250px\" width=\"330px\">");
		 	$("#divImgPkg").css({width:'200%',height:'auto','max-height':'100%'});
		 }
	}
</script>
