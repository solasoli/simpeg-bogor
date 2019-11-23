<?php
extract($_POST);

if(isset($jangka))
{
$tgl=$th1."-".$b1."-".$t1;

if($jangka=='pendek')
{
$qcek=mysql_query("select count(*) from proper_tujuan where id_proper=$idp and jenis_jangka like '%pendek%' ");
$cek=mysql_fetch_array($qcek);

if($cek[0]==0)
mysql_query("insert into proper_tujuan (id_proper,jenis_jangka,tujuan_jangka,tanggal_capaian,status,alasan) values ($idp,'pendek','$tujuan','$tgl','','')");
else
mysql_query("update proper_tujuan set tujuan_jangka='$tujuan',tanggal_capaian='$tgl' where id_proper=$idp and jenis_jangka like 'pendek'");
}
else if($jangka=='menengah')
{
$qcek=mysql_query("select count(*) from proper_tujuan where id_proper=$idp and jenis_jangka like '%menengah%' ");
$cek=mysql_fetch_array($qcek);

if($cek[0]==0)
mysql_query("insert into proper_tujuan (id_proper,jenis_jangka,tujuan_jangka,tanggal_capaian,status,alasan) values ($idp,'menengah','$tujuan','$tgl','','')");
else
mysql_query("update proper_tujuan set tujuan_jangka='$tujuan',tanggal_capaian='$tgl' where id_proper=$idp and jenis_jangka like 'menengah'");
}
else
{
$qcek=mysql_query("select count(*) from proper_tujuan where id_proper=$idp and jenis_jangka like '%panjang%' ");
$cek=mysql_fetch_array($qcek);

if($cek[0]==0)
mysql_query("insert into proper_tujuan (id_proper,jenis_jangka,tujuan_jangka,tanggal_capaian,status,alasan) values ($idp,'panjang','$tujuan','$tgl','','')");
else
mysql_query("update proper_tujuan set tujuan_jangka='$tujuan',tanggal_capaian='$tgl' where id_proper=$idp and jenis_jangka like 'panjang'");


}




}

?>

<div class="hidden-print">
	<nav aria-label="breadcrumb">
	  <ol class="breadcrumb">
	    <li class="breadcrumb-item"><a href="index.php?page=list">Daftar Proyek Perubahan</a></li>
			
	  </ol>
	</nav>

<nav>
		<ol class="cd-multi-steps text-bottom count">
		<li class="visited"><strong>Data</strong></li>
		<li class=""><a href="index.php?page=unggah&idp=<?php echo $idp; ?>">Upload PDF</a></li>
        <li class=""><a href="index.php?page=monitoring&idp=<?php echo $idp; ?>">Monitoring</a></li>
		

	</ol>
</nav>
</div>
<div class="row">
	<div class="col-md-4">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h5>Tujuan Jangka Pendek</h5>
			</div>
			<div class="panel-body">
				<form class="form" role="form" name="form1" id="form1" action="index.php" method="post">
               
					<?php
					
					$qcek1=mysql_query("select count(*) from proper_tujuan where id_proper=$idp and jenis_jangka like '%pendek%' ");
$cek1=mysql_fetch_array($qcek1);
if($cek1[0]>0)
{

$qpendek=mysql_query("select * from proper_tujuan where id_proper=$idp and jenis_jangka like '%pendek%' ");
$pendek=mysql_fetch_array($qpendek);

$t2=substr($pendek[4],8,2);
$b2=substr($pendek[4],5,2);
$th2=substr($pendek[4],0,4);

}
					
					?>
					<div class="form-group">
						<label for="gol_pegawai">Tujuan</label>
						<input type="text" name="tujuan" id="tujuan" class="form-control"  <?php if($cek1[0]>0) echo (" value='".$pendek[3]."' "); ?> >
					</div>
					
					<div class="form-group">
						<label for="periode_awal">Target Waktu Jangka Pendek</label>
						<div class="form-inline">
						  Tgl: <select name="t1" id="t1" ><?php 
						  for($i=1;$i<=31;$i++)
						  {
							  if($i<10)
							  {
							
							if("0$i"==$t2)  
							echo("<option value=0$i selected=selected> $i </option>");
							else
							echo("<option value=0$i> $i </option>");
							}
							else
							{
								if($i==$t2) 
							  echo("<option value=$i selected=selected> $i </option>");
							 else
							  echo("<option value=$i> $i </option>");
							 } 
						  }
						   ?> </select>
                           <select name="b1" id="b1" ><?php 
						  for($j=1;$j<=12;$j++)
						  {
							  
							  $bulan=array('x','Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember');
							  
							  if($j<10)
							  {
							if("0$j"==$b2)  
							echo("<option value=0$j selected=selected> $bulan[$j] </option>");
							else
							echo("<option value=0$j> $bulan[$j] </option>");
							
							}
							else
							{
							 if("$j"==$b2)  
							echo("<option value=$j selected=selected> $bulan[$j] </option>");
							else
							echo("<option value=$j> $bulan[$j] </option>");
							  
							  }
						  }
						   ?> </select>
                           <select name="th1" id="th1" ><?php 
						  for($k=date("Y");$k>=2013;$k--)
						  {
							  
							  if($th2==$k)
							  echo("<option value=$k selected=selected> $k </option>");
							  else
							  echo("<option value=$k > $k </option>");
							  
						  }
						   ?> </select>
						</div>
					</div>
                    
                  
                    <input type="hidden" name="jangka" id="jangka" value="pendek" />
                      <input type="hidden" name="page" id="page" value="ubah_data" />
                        <input type="hidden" name="idp" id="idp" value="<?php echo $idp; ?>" />
<button id="btnPeriode" class="btn btn-primary" onclick="submit1();">SIMPAN</button>
				</form>
				
			</div>
		</div>
	</div>
	<!-- target -->
	<div class="row">
	<div class="col-md-4">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h5>Tujuan Jangka Menengah</h5>
			</div>
			<div class="panel-body">
				<form class="form" role="form" id="form2" name="form2" action="index.php" method="post">
						<?php
					
					$qcek2=mysql_query("select count(*) from proper_tujuan where id_proper=$idp and jenis_jangka like '%menengah%' ");
$cek2=mysql_fetch_array($qcek2);
if($cek2[0]>0)
{

$qmenengah=mysql_query("select * from proper_tujuan where id_proper=$idp and jenis_jangka like '%menengah%' ");
$menengah=mysql_fetch_array($qmenengah);

$t3=substr($menengah[4],8,2);
$b3=substr($menengah[4],5,2);
$th3=substr($menengah[4],0,4);

}
					
					?>
					<div class="form-group">
						<label for="gol_pegawai">Tujuan</label>
						<input type="text" name="tujuan" id="tujuan" class="form-control"  <?php if($cek2[0]>0) echo (" value='".$menengah[3]."' "); ?>>
					</div>
					
					<div class="form-group">
						<label for="periode_awal">Target Waktu Jangka Menengah</label>
						<div class="form-inline">
						  Tgl: <select name="t1" id="t1" ><?php 
						  for($i=1;$i<=31;$i++)
						  {
							  if($i<10)
							  {
							
							if("0$i"==$t3)  
							echo("<option value=0$i selected=selected> $i </option>");
							else
							echo("<option value=0$i> $i </option>");
							}
							else
							{
								if($i==$t3) 
							  echo("<option value=$i selected=selected> $i </option>");
							 else
							  echo("<option value=$i> $i </option>");
							 } 
						  }
						   ?> </select>
                           <select name="b1" id="b1" ><?php 
						  for($j=1;$j<=12;$j++)
						  {
							  
							  $bulan=array('x','Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember');
							  
							  if($j<10)
							  {
							if("0$j"==$b3)  
							echo("<option value=0$j selected=selected> $bulan[$j] </option>");
							else
							echo("<option value=0$j> $bulan[$j] </option>");
							
							}
							else
							{
							 if("$j"==$b3)  
							echo("<option value=$j selected=selected> $bulan[$j] </option>");
							else
							echo("<option value=$j> $bulan[$j] </option>");
							  
							  }
						  }
						   ?> </select>
                           <select name="th1" id="th1" ><?php 
						  for($k=date("Y");$k>=2013;$k--)
						  {
							  
							  if($th3==$k)
							  echo("<option value=$k selected=selected> $k </option>");
							  else
							  echo("<option value=$k > $k </option>");
							  
						  }
						   ?> </select>
						</div>
					</div>
                    
                  
                    <input type="hidden" name="jangka" id="jangka" value="menengah" />
                    <input type="hidden" name="page" id="page" value="ubah_data" />
                    <input type="hidden" name="idp" id="idp" value="<?php echo $idp; ?>" />
<button id="btnPeriode" class="btn btn-primary" onclick="submit2();">SIMPAN</button>
				</form>
			</div>
		</div>
	</div>
	<div class="row">
	<div class="col-md-4">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h5>Tujuan Jangka Panjang</h5>
			</div>
			<div class="panel-body">
				<form class="form" role="form" id="form3" name="form3" action="index.php" method="post">
                
                	<?php
					
					$qcek3=mysql_query("select count(*) from proper_tujuan where id_proper=$idp and jenis_jangka like '%panjang%' ");
$cek3=mysql_fetch_array($qcek3);
if($cek3[0]>0)
{

$qpanjang=mysql_query("select * from proper_tujuan where id_proper=$idp and jenis_jangka like '%panjang%' ");
$panjang=mysql_fetch_array($qpanjang);

$t4=substr($panjang[4],8,2);
$b4=substr($panjang[4],5,2);
$th4=substr($panjang[4],0,4);

}
?>
					
					<div class="form-group">
						<label for="gol_pegawai">Tujuan</label>
						<input type="text" name="tujuan" id="tujuan" class="form-control" <?php if($cek3[0]>0) echo (" value='".$panjang[3]."' "); ?>>
					</div>
					
					<div class="form-group">
						<label for="periode_awal">Target Waktu Jangka Panjang <?php  ?></label>
						<div class="form-inline">
						  Tgl: <select name="t1" id="t1" ><?php 
						  for($i=1;$i<=31;$i++)
						  {
							  if($i<10)
							  {
							
							if("0$i"==$t4)  
							echo("<option value=0$i selected=selected> $i </option>");
							else
							echo("<option value=0$i> $i </option>");
							}
							else
							{
								if($i==$t4) 
							  echo("<option value=$i selected=selected> $i </option>");
							 else
							  echo("<option value=$i> $i </option>");
							 } 
						  }
						   ?> </select>
                           <select name="b1" id="b1" ><?php 
						  for($j=1;$j<=12;$j++)
						  {
							  
							  $bulan=array('x','Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember');
							  
							  if($j<10)
							  {
							if("0$j"==$b4)  
							echo("<option value=0$j selected=selected> $bulan[$j] </option>");
							else
							echo("<option value=0$j> $bulan[$j] </option>");
							
							}
							else
							{
							 if("$j"==$b4)  
							echo("<option value=$j selected=selected> $bulan[$j] </option>");
							else
							echo("<option value=$j> $bulan[$j] </option>");
							  
							  }
						  }
						   ?> </select>
                           <select name="th1" id="th1" ><?php 
						  for($k=date("Y");$k>=2013;$k--)
						  {
							  
							  if($th4==$k)
							  echo("<option value=$k selected=selected> $k </option>");
							  else
							  echo("<option value=$k > $k </option>");
							  
						  }
						   ?> </select>
						</div>
					</div>
                    
                 
                    <input type="hidden" name="jangka" id="jangka" value="panjang" />
                    <input type="hidden" name="page" id="page" value="ubah_data" />
                    <input type="hidden" name="idp" id="idp" value="<?php echo $idp; ?>" />
<button id="btnPeriode" class="btn btn-primary" onclick="submit3();">SIMPAN</button>
				</form>
			</div>
		</div>
	</div>
	<!-- realisasi -->
	
	


<script>

function submit1()
{
document.getElementById("form1").submit();
}

function submit2()
{
document.getElementById("form2").submit();
}

function submit3()
{
document.getElementById("form3").submit();
}



	$(document).ready(function(){

		$(".tanggal").combodate({
			minYear: 2010,
			maxYear: <?php echo date('Y'); ?>
		});
		$(".day").addClass("form-control");
		$(".month").addClass("form-control");
		$(".year").addClass("form-control");

		$( "input[name='unit_kerja_pegawai']" ).autocomplete({
			source: "find_opd.php",
			minLength: 3,
			select: function( event, ui ) {
                    console.log ( ui.item ?
                    "Selected: " + ui.item.value + " aka " + ui.item.id :
                    "Nothing selected, input was " + this.value );
					$("#id_unit_kerja_pegawai").val(ui.item.id);
                    //window.location.replace("index.php?page=monitoring&uk="+ui.item.id);

			}
		});

		$( "input[name='unit_kerja_penilai']" ).autocomplete({
			source: "find_opd.php",
			minLength: 3,
			select: function( event, ui ) {
                    console.log ( ui.item ?
                    "Selected: " + ui.item.value + " aka " + ui.item.id :
                    "Nothing selected, input was " + this.value );
					$("#id_unit_kerja_penilai").val(ui.item.id);
                    //window.location.replace("index.php?page=monitoring&uk="+ui.item.id);

			}
		});

		$( "input[name='unit_kerja_atasan_penilai']" ).autocomplete({
			source: "find_opd.php",
			minLength: 3,
			select: function( event, ui ) {
                    console.log ( ui.item ?
                    "Selected: " + ui.item.value + " aka " + ui.item.id :
                    "Nothing selected, input was " + this.value );
					$("#id_unit_kerja_atasan_penilai").val(ui.item.id);

			}
		});

		$("#btnPeriode").on('click',function(){


			awal = $("#periode_awal").val();
			akhir = $("#periode_akhir").val();

			$.post("skp.php", {aksi: "UPDATE_PERIODE_PENILAIAN",
					id_skp:<?php echo $_GET['idskp'] ?>,
					periode_awal: $("#periode_awal").val(),
					periode_akhir: $("#periode_akhir").val(),
					gol_pegawai: $("#gol_pegawai").val(),
					jabatan_pegawai: $("#jabatan_pegawai").val(),
					id_unit_kerja_pegawai: $("#id_unit_kerja_pegawai").val()})
			  .done(function(obj){
				  alert(obj);
			  })
		});

		$("#cari_penilai").on('click',function(){
			$.post('find_atasan.php',{nip:$("#nip_penilai").val()})
			 .done(function(obj){
				data = JSON.parse(obj);
				if(data.id == 0){
					alert("Pegawai Tidak Ditemukan");
					//alert(data);
				}else{
					//alert(data.id);
					$("#id_penilai").val(data.id);
					$("#nama_penilai").val(data.nama);
					$("#gol_penilai").val(data.golongan);
					$("#jabatan_penilai").val(data.jabatan);
				}

			});
		});

		$("#btnPenilai").on("click",function(){

			$.post('skp.php',{aksi:"UPDATE_HEADER",x:"PENILAI",
					id_penilai:$("#id_penilai").val(),
					gol_penilai:$("#gol_penilai").val(),
					jabatan_penilai:$("#jabatan_penilai").val(),
					id_skp : <?php echo $_GET['idskp'] ?>,
					id_unit_kerja_penilai: $("#id_unit_kerja_penilai").val()
					})
			 .done(function(obj){
				 alert(obj);
			 });
		});

		$("#cari_atasan_penilai").on('click',function(){

			$.post('find_atasan.php',{nip:$("#nip_atasan_penilai").val()})
			 .done(function(obj){
				data = JSON.parse(obj);
				if(data.id == 0){
					alert("Pegawai Tidak Ditemukan");
				}else{
					//alert(data.id);
					$("#id_atasan_penilai").val(data.id);
					$("#nama_atasan_penilai").val(data.nama);
					$("#gol_atasan_penilai").val(data.golongan);
					$("#jabatan_atasan_penilai").val(data.jabatan);
				}
			});
		});

		$("#btnAtasanPenilai").on("click",function(){

			$.post('skp.php',{aksi:"UPDATE_HEADER",x:"ATASAN_PENILAI",
					id_atasan_penilai:$("#id_atasan_penilai").val(),
					gol_atasan_penilai:$("#gol_atasan_penilai").val(),
					jabatan_atasan_penilai:$("#jabatan_atasan_penilai").val(),
					id_skp : <?php echo $_GET['idskp'] ?>,
					id_unit_kerja_atasan_penilai: $("#id_unit_kerja_atasan_penilai").val()
					})
			 .done(function(obj){
				 alert(obj);
			 });
		});

		$("#cari_penilai_realisasi").on('click',function(){
			$.post('find_atasan.php',{nip:$("#nip_penilai_realisasi").val()})
			 .done(function(obj){
				data = JSON.parse(obj);
				if(data.id == 0){
					alert("Pegawai Tidak Ditemukan");
				}else{
					//alert(data.id);
					$("#id_penilai_realisasi").val(data.id);
					$("#nama_penilai_realisasi").val(data.nama);
					$("#gol_penilai_realisasi").val(data.golongan);
					$("#jabatan_penilai_realisasi").val(data.jabatan);
				}

			});
		});

		$("#btnPenilaiRealisasi").on("click",function(){

			$.post('skp.php',{aksi:"UPDATE_HEADER",x:"PENILAI_REALISASI",
					id_penilai_realisasi:$("#id_penilai_realisasi").val(),
					gol_penilai_realisasi:$("#gol_penilai_realisasi").val(),
					jabatan_penilai_realisasi:$("#jabatan_penilai_realisasi").val(),
					id_skp : <?php echo $_GET['idskp'] ?>
					})
			 .done(function(obj){
				 alert(obj);
			 });
		});

		$("#cari_atasan_penilai_realisasi").on('click',function(){

			$.post('find_atasan.php',{nip:$("#nip_atasan_penilai_realisasi").val()})
			 .done(function(obj){
				data = JSON.parse(obj);
				if(data.id == 0){
					alert("Pegawai Tidak Ditemukan");
				}else{
					//alert(data.id);
					$("#id_atasan_penilai_realisasi").val(data.id);
					$("#nama_atasan_penilai_realisasi").val(data.nama);
					$("#gol_atasan_penilai_realisasi").val(data.golongan);
					$("#jabatan_atasan_penilai_realisasi").val(data.jabatan);
				}
			});
		});

		$("#btnAtasanPenilaiRealisasi").on("click",function(){
			$.post('skp.php',{aksi:"UPDATE_HEADER",x:"ATASAN_PENILAI_REALISASI",
					id_atasan_penilai_realisasi:$("#id_atasan_penilai_realisasi").val(),
					gol_atasan_penilai_realisasi:$("#gol_atasan_penilai_realisasi").val(),
					jabatan_atasan_penilai_realisasi:$("#jabatan_atasan_penilai_realisasi").val(),
					id_skp : <?php echo $_GET['idskp'] ?>
					})
			 .done(function(obj){
				 alert(obj);
			 });
		});


	});

</script>
<script src="skp.js"></script>
