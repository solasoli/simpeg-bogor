<?php extract($_GET);

?>
 <ul class="nav nav-tabs" id="tab_container">
  <li class="active">
    <a href="#tab_statistik" data-toggle="tab"> Pendidikan</a>
  </li>
  
  <li >
    <a href="#tab_gol" data-toggle="tab">Golongan</a>
  </li>
   <li >
    <a href="#tab_jab" data-toggle="tab">Jabatan</a>
  </li>
  
  <li > 
    <a href="#tab_fung" data-toggle="tab">Fungsional</a>
  </li>
  
    <li >
    <a href="#tab_struk" data-toggle="tab">Struktural</a>
  </li>
  
   <li >
    <a href="#tab_umur" data-toggle="tab">Umur</a>
  </li>
  
  
     <li >
    <a href="#tab_pim" data-toggle="tab">Diklat Pim</a>
  </li>
  
  
   <li >
    <a href="#tab_bid" data-toggle="tab">Bidang Pendidikan</a>
  </li>
  
  
   <li >
    <a href="#tinggi" data-toggle="tab">Lulusan Sekolah Tinggi </a>
  </li>
  
  
  <li >
    <a href="#tab_kelamin" data-toggle="tab">Jenis Kelamin</a>
  </li>
 
   
  <li>
  <a href="#os" data-toggle="tab">Pengguna Ponsel</a>
  </li> 
 
 
  <li>
  <a href="#tab_rekap" data-toggle="tab">Rekapitulasi</a>
  </li>
  <li>
  <a href="#espang" data-toggle="tab">Rekap Eselon</a>
  </li>
    <li>
  <a href="#espang2" data-toggle="tab">Proyek Perubahan</a>
  </li>  
 

</ul>

<div id="myTabContent" class="tab-content">
	<div class="tab-pane fade in active" id="tab_statistik">
		<?php 
			include("stat.php");
		?>
	</div> <!-- id="tab_statistik" -->


<div class="tab-pane fade in" id="tab_gol">
		<?php include 'pstat.php'; ?>
	</div> <!-- id="dinilai" -->



<div class="tab-pane fade in" id="tab_jab">
		<?php include 'jfstat.php'; ?>
	</div> <!-- id="dinilai" -->
    
    <div class="tab-pane fade in" id="tab_fung">
		<?php include 'fstat.php'; ?>
	</div> <!-- id="dinilai" -->

 <div class="tab-pane fade in" id="tab_struk">
		<?php include 'strstat.php'; ?>
	</div> <!-- id="dinilai" -->

	<div class="tab-pane fade in" id="tab_umur">
		<?php include 'umurstat.php'; ?>
	</div> <!-- id="dinilai" -->


	<div class="tab-pane fade in" id="tab_pim">
		<?php include 'pimstat.php'; ?>
	</div> <!-- id="dinilai" -->
    
    <div class="tab-pane fade in" id="tab_bid">
		<?php include 'bidstat.php'; ?>
	</div> <!-- id="dinilai" -->
	
	
	<div class="tab-pane fade in" id="tinggi">
		<?php include 'tinggi.php'; ?>
	</div> <!-- id="dinilai" -->


<div class="tab-pane fade in" id="tab_kelamin">
		<?php include 'jkstat.php'; ?>
	</div> <!-- id="dinilai" -->
	
	
	<div class="tab-pane fade in" id="os">
		<?php include 'os.php'; ?>
	</div> <!-- id="dinilai" -->
	
	 
	<div class="tab-pane fade in" id="tab_rekap">
		<?php include 'statistik_rekap.php'; ?>
	</div> <!-- id="dinilai" -->
	
	
		<div class="tab-pane fade in" id="espang">
		<?php include 'eselonpangkat.php'; ?>
	</div> 
    
    <div class="tab-pane fade in" id="espang2">
		<?php include 'propergraph.php'; ?>
	</div> 
	
	

</div> <!-- id="tab_rekap" -->

