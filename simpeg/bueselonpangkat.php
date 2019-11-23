
<!DOCTYPE html> 
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<title>Untitled Document</title>


<link href="assets/bootstrap/css/bootstrap.css" rel="stylesheet">		
<link href="assets/bootstrap/css/costums.css" rel="stylesheet">
<style type="text/css">

</style>
</head>

<body>
<?php 
include("konek.php");
include ("class/pegawai.php");

extract($_POST);

$pns = new Pegawai;

?>

<form id="form99" name="form99" method="post" action="eselonpangkat.php">
  <div class="container">
  <div class="row">
    <div class="col-md-12 well">
      <h4>Jumlah Pegawai Per Eselon dan Golongan</h4>
    </div>
	</div>
	
    
    <div class="row">
      <div class="col-xs-6">
	  <label for="e">Eselon</label>
        <select name="e" id="e" class="form-control">
			<?php
			$q=mysqli_query($mysqli,"select eselon from jabatan where tahun=2011 and eselon not like '%kota%'  and eselon not like '%NS%' group by eselon ");
			while($a=mysqli_fetch_array($q))
			{
			if(@@$e==$a[0])	
			echo("<option value=$a[0] selected>$a[0] </a>");
			else
			echo("<option value=$a[0]>$a[0] </a>");
			
			}
			?>
		</select>
	  </div>
      <div class="col-xs-6">
		<label for="g">Golongan</label>
		<select name="g" id="g" onChange="document.form99.submit()" class="form-control">
       <?php
		$q1=mysqli_query($mysqli,"select pangkat_gol from pegawai where flag_pensiun=0 group by pangkat_gol" );
		while($b=mysqli_fetch_array($q1))
		{
		if(@@$g==$b[0])	
		echo("<option value=$b[0] selected>$b[0] </a>");
		else
		echo("<option value=$b[0]>$b[0] </a>");
		
		}
		?>
      </select>
	  </div>
    </div>
	
    <div class="row">
      <div class="col-md-12">
	  <?php
	   
      if(isset($e) and isset($g))
	  {
		  
		  
		$q3=mysqli_query($mysqli,"SELECT count(*) FROM pegawai inner join jabatan on jabatan.id_j=pegawai.id_j where pegawai.id_j>0 and flag_pensiun=0 and pangkat_gol like '$g' and eselon like '$e'");  
		  $itung=mysqli_fetch_array($q3);
		  
		  echo("<h5 align=justify>Pegawai Eselon $e dengan Golongan $g berjumlah $itung[0] pegawai</h5>");
	  }
	  else
	  echo("<br><br><br><br><br><br>");
	  ?>
	  </div>
    </div>
    
	<div class="row">
      <div class="col-md-12">
      
      <?php
	  if($itung[0]>0)
	  {
	  $q4=mysqli_query($mysqli,"SELECT distinct pegawai.id_pegawai,concat(gelar_depan,' ',nama,' ',gelar_belakang) as nama, 
						pegawai.id_j,right(left(nip_baru,14),6) as tmt_cpns,floor(datediff(curdate(),tgl_lahir)/365) as umur, 
						pangkat_gol,
						DATE_ADD(sk.tmt, INTERVAL SPLIT_STR(sk.keterangan,',',2) YEAR) as tmt_cpns2
					FROM pegawai 
					inner join jabatan on jabatan.id_j=pegawai.id_j
					left join sk on sk.id_pegawai = pegawai.id_pegawai 
					where pegawai.id_j > 0 
					and flag_pensiun=0 
					and pangkat_gol like '$g' 
					and eselon like '$e'
					and sk.id_kategori_sk = '6'
					ORDER BY tmt_cpns2 DESC"); //right(left(nip_baru,14),6)
	  while($ata=mysqli_fetch_array($q4))
	  {
	  ?>
      
		<div class="row">
			<div class="col-xs-5 col-md-2">
				  <?php
		  if(file_exists("./foto/$ata[0].jpg"))
		  {
			 ?> 
			  <img src="./foto/<?php echo("$ata[0]".".jpg"); ?>" width="100" />
			<?php
			  }
		  else
		  {
			  if($ata[5]=='L')
			  echo("<img src=./images/male.jpg width=100 />");
			  else
			  echo("<img src=./images/female.jpg width=100 />");
		  
		  }
		  ?>
			</div>
			<div class="col-xs-6 col-md-10 well">
				<div class="row">
					<div class="col-xs-12" style="background-color:#DADAE6;">
						Nama: <?php echo $ata['1'] ?>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-12">
						Jabatan: <?php $qj=mysqli_query($mysqli,"select * from jabatan where id_j=$ata[2] ");
						  $jab=mysqli_fetch_array($qj);
						  echo($jab['jabatan']);
						   ?>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-12" style="background-color:#DADAE6;">
						Masa Kerja Golongan :
						<?php
						 
						  $cpns = mysqli_fetch_object(mysqli_query($mysqli,"select * from sk where id_kategori_sk = 6 and id_pegawai = $ata[0]"));
						  list($gol_cpns,$thn,$bln) = explode(',', $cpns->keterangan);
						  $mk = $pns->hitung_masakerja($cpns->tmt, $thn, $bln);
						  $mk_gol = $pns->hitung_masakerja_golongan($mk,$gol_cpns, $ata['pangkat_gol']);
						  echo $mk_gol['tahun'].' Tahun, '.$mk_gol['bulan'].' Bulan';
						  ?>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-12">
						Pendidikan Terakhir :
						<?php
						  $qp=mysqli_query($mysqli,"select * from pendidikan where id_pegawai=$ata[0] ");
						  $pen=mysqli_fetch_array($qp);
						  echo("$pen[3] $pen[2] Jurusan $pen[4]");
						  ?>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-12" style="background-color:#DADAE6;">
						Umur:<?php echo("$ata[4] Tahun"); ?>
					</div>
				</div>
			</div>
		</div>  
	  
	  <br>
     
      
      <?php
	  }
	  }

	  
	  ?>
      </div>
    </div>
  
</div>
  </form>

</body>
</html>
