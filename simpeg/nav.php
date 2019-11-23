  <style>
    /* styles for desktop */
    .tinynav { display: none }
    #tab_container .selected a { color: red }
    /* styles for mobile */
    @media screen and (max-width: 600px) {
      .tinynav { display: block }
      #tab_container { display: none }
    }
  </style>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
  <script src="./assets/js/tinynav.min.js"></script>
  <script>
    $(function () {

      // TinyNav.js 1
      $('#tab_container').tinyNav({
        active: 'selected',
      
      });
      
     

    });
  </script>
<ul class="nav nav-tabs" id="tab_container">
  <li class="active">
    <a href="#tab_statistik" data-toggle="tab">Tingkat Pendidikan</a>
  </li>
  
  <li >
    <a href="#tab_kelamin" data-toggle="tab">Jenis Kelamin</a>
  </li>
 
 
  <li>
  <a href="#tab_rekap" data-toggle="tab">Rekapitulasi</a>
  </li>
  <li>
  <a href="#espang" data-toggle="tab">Rekap Eselon</a>
  </li>  

</ul>

<div id="myTabContent" class="tab-content">
	<div class="tab-pane fade in active" id="tab_statistik">
		<?php 
			include("stat.php");
		?>
	</div> <!-- id="tab_statistik" -->

<div class="tab-pane fade in" id="tab_kelamin">
		<?php include 'jkstat.php'; ?>
	</div> <!-- id="dinilai" -->
	
	
	<div class="tab-pane fade in" id="tab_rekap">
		<?php include 'statistik_rekap.php'; ?>
	</div> <!-- id="dinilai" -->
	
	
		<div class="tab-pane fade in" id="espang">
		<?php include 'eselonpangkat.php'; ?>
	</div> 
	

</div> <!-- id="tab_rekap" -->