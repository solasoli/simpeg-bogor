<?php
extract($_GET);
?>
 <ul class="nav nav-tabs hidden-print" id="tab_container">
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

  <li >
    <a href="#tab_skpd" data-toggle="tab">OPD</a>
  </li>



  <li >
    <a href="#tab_os" data-toggle="tab">Pengguna Ponsel</a>
  </li>



  <li>
  <a href="#tab_rekap" data-toggle="tab">Rekapitulasi</a>
  </li>

  <li>
  <a href="#espang" data-toggle="tab">Pensiun Pejabat Struktural</a>
  </li>

   <li>
  <a href="#spain" data-toggle="tab">Pensiun Guru</a>
  </li>

<li>
  <a href="#pain" data-toggle="tab">Pensiun</a>
  </li>

  <li>
    <a href="#espang2" data-toggle="tab">Proyek Perubahan</a>
    </li>

     <li>
    <a href="#pro" data-toggle="tab">Progress Proyek Perubahan</a>
    </li>
    
      <li>
    <a href="#pk1" data-toggle="tab">Pengembangan Kompetensi</a>
    </li>
    
     <li>
    <a href="#pk2" data-toggle="tab">Kompetensi Manajerial</a>
    </li>
    
    
     <li>
    <a href="#pk3" data-toggle="tab">Kompetensi Teknis</a>
    </li>
    
    



</ul>

<div id="myTabContent" class="tab-content">
	<div class="tab-pane fade in active" id="tab_statistik">
		<?php
			include("statall.php");
		?>
	</div> <!-- id="tab_statistik" -->


<div class="tab-pane fade in" id="tab_gol">
		<?php include 'pstatall.php'; ?>
	</div> <!-- id="dinilai" -->



<div class="tab-pane fade in" id="tab_jab">
		<?php include 'jfstatall.php'; ?>
	</div> <!-- id="dinilai" -->

    <div class="tab-pane fade in" id="tab_fung">
		<?php include 'fstatall.php'; ?>
	</div> <!-- id="dinilai" -->

 <div class="tab-pane fade in" id="tab_struk">
		<?php include 'strstatall.php'; ?>
	</div> <!-- id="dinilai" -->

	<div class="tab-pane fade in" id="tab_umur">
		<?php include 'umurstatall.php'; ?>
	</div> <!-- id="dinilai" -->


	<div class="tab-pane fade in" id="tab_pim">
		<?php include 'pimstat.php'; ?>
	</div> <!-- id="dinilai" -->

    <div class="tab-pane fade in" id="tab_bid">
		<?php include 'bidstatall.php'; ?>
	</div> <!-- id="dinilai" -->


	<div class="tab-pane fade in" id="tinggi">
		<?php include 'tinggiall.php'; ?>
	</div> <!-- id="dinilai" -->


<div class="tab-pane fade in" id="tab_kelamin">
		<?php include 'jkstatall.php'; ?>
	</div> <!-- id="dinilai" -->


<div class="tab-pane fade in" id="tab_skpd">
		<?php include 'skpdall.php'; ?>
	</div> <!-- id="dinilai" -->


	<div class="tab-pane fade in" id="tab_os">
		<?php include 'ostatall.php'; ?>
	</div> <!-- id="dinilai" -->






	<div class="tab-pane fade in" id="tab_rekap">
		<?php include 'statistik_rekap.php'; ?>
	</div> <!-- id="dinilai" -->


		<div class="tab-pane fade in" id="espang">
		<?php include 'penpej.php'; ?>
	</div>

    <div class="tab-pane fade in" id="spain">
		<?php include 'gurup.php'; ?>
	</div>


    <div class="tab-pane fade in" id="pain">
		<?php include 'urup.php'; ?>
	</div>

 <div class="tab-pane fade in" id="spain2">
		<?php include 'pension.php';//include 'pangsiun.php'; ?>
	</div>

  <div class="tab-pane fade in" id="espang2">
  <?php include 'propergraph.php'; ?>
  </div>


   <div class="tab-pane fade in" id="pro">
   <?php include 'propergraph3.php'; ?>
</div>

 <div class="tab-pane fade in" id="pk1">
   <?php include 'pk1.php'; ?>
</div>

 <div class="tab-pane fade in" id="pk2">
   <?php include 'pk2.php'; ?>
</div>

<div class="tab-pane fade in" id="pk3">
   <?php include 'pk3.php'; ?>
</div>

<!-- id="tab_rekap" -->
