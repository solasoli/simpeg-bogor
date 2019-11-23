<h4>
	PENILAIAN PRESTASI KERJA PNS
</h4>
<div class="row">
	<ul class="nav nav-tabs hidden-print" >   
		<li><a href="0_data.php?idskp=<?php echo $_GET['idskp'] ?>" data-target="#data" data-toggle="tabajax" id="tabData">Data SKP</a></li>
		<li><a href="1_sasaran.php?idskp=<?php echo $_GET['idskp'] ?>" data-target="#sasaran" data-toggle="tabajax" id="tabSasaran">Sasaran Kerja</a></li>
		<li><a href="1_realisasi.php?idskp=<?php echo $_GET['idskp']?>" data-target="#realisasi" data-toggle="tabajax" id="tabRealisasi">Realisasi</a></li>
		<li><a href="1_perilaku.php?idskp=<?php echo $_GET['idskp']?>"  data-target="#perilaku" data-toggle="tabajax" id="tabPerilaku">Penilaian Perilaku</a></li>
		<li><a href="1_laporan.php"  data-toggle="tabajax">Laporan akhir</a></li>
		<li><a href="0_cover.php"  data-toggle="tabajax">Cover</a></li>
			
	</ul>
	<div class="tab-content">
		<div class="tab-pane" id="data">
			Loading..
		</div>
		<div class="tab-pane" id="sasaran">
			Loading..
		</div>
		<div class="tab-pane" id="realisasi">
			Loading..
		</div>
		<div class="tab-pane" id="perilaku">
			Loading..
		</div>
	</div>    
	
</div><!-- end of row-->

<script>
	
	$(document).ready(function(){
		
			
		$('[data-toggle="tabajax"]').click(function(e) {
			var $this = $(this),
				loadurl = $this.attr('href'),
				targ = $this.attr('data-target');

			$.get(loadurl, function(data) {
				$(targ).html(data);
			});

			$this.tab('show');
			return false;
		});
		
		<?php if(isset($_GET['tab'])){	?>	
			
			tab = <?php echo $_GET['tab'] ?>;
						
			if(tab == 0){
				
				var	loadurl = $('#tabData').attr('href'),
					targ = '#data';

				$.get(loadurl, function(data) {					
					$(targ).html(data);					
				});
				
				$('#tabData').tab('show');
				
			}else if(tab == 1){
				
				var	loadurl = $('#tabSasaran').attr('href'),
					targ = '#sasaran';

				$.get(loadurl, function(data) {					
					$(targ).html(data);					
				});
				
				$('#tabSasaran').tab('show');
				//alert(tab);
			}else if(tab == 2){
				
				var	loadurl = $('#tabRealisasi').attr('href'),
					targ = '#realisasi';

				$.get(loadurl, function(data) {					
					$(targ).html(data);					
				});
				
				$('#tabRealisasi').tab('show');
				
			}else if(tab == 3){
				var	loadurl = $('#tabPerilaku').attr('href'),
					targ = '#perilaku';

				$.get(loadurl, function(data) {					
					$(targ).html(data);					
				});
				
				$('#tabPerilaku').tab('show');
			}			
		<?php } ?>
		
		
	});

</script>
