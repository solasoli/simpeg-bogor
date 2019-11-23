
		<script type="text/javascript">
$(function () {
    $('#pim').highcharts({
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: 1,//null,
            plotShadow: false
        },
        title: {
			<?php
		
			$q=mysqli_query($mysqli,"select count(*) from pegawai where id_j>0 and  flag_pensiun=0 ");
			$itung=mysqli_fetch_array($q);
			
			?>
            text: 'Persentase Pejabat Struktural Per Diklat Kepemimpinan <?php echo("($itung[0] pegawai)"); ?>'
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.y}  </b>'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b>: {point.percentage:.2f} % ({point.y})',
                    style: {
                        color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                    }
                }
            }
        },
		
        series: [{
            type: 'pie',
            name: 'Jumlah Pegawai',
            data: [
			
			<?php

			$qp2=mysqli_query($mysqli,"select count(*) from diklat  WHERE `nama_diklat` LIKE '%Tk.II'");
				$p2=mysqli_fetch_array($qp2);
				echo("['Pim II', $p2[0] ]");	
				
				$qp3=mysqli_query($mysqli,"select count(*) from diklat  WHERE `nama_diklat` LIKE '%Tk.III'");
				$p3=mysqli_fetch_array($qp3);	
				$pim3= $p3[0]-$p2[0];
				echo(",['Pim III', $pim3 ]");
				
				$qp4=mysqli_query($mysqli,"select count(*) from diklat  WHERE `nama_diklat` LIKE '%Tk.IV'");
				$p4=mysqli_fetch_array($qp4);
				$pim4= $p4[0]-$p3[0];
				echo(",['Pim IV', $pim4 ]");	

			$belum=$itung[0]-$p4[0];
				echo(",['Belum Mengikuti', $belum ]");
				
			?>

            ],
				point:{
              events:{
                  click: function (event) {
				  
					var x = this.name;
                      jQuery.noConflict();
					  
					  
				  $.ajax({
   type:"POST",
   url:"processpim.php",
   data: "lp="+this.name+"&unit=<?php echo $unit[0]; ?>",
   success: function (data)
   {
			
				
			
		  $('#judul7').html('Data Pegawai Yang Pernah Mengikuti Diklat '+ x);
		  $('#contentnya7').html(data);
  }
   
   }); 
					  $("#daftar_pegawai7").modal("show");
					  
					 
                  }
              }
          } 
        }]
    });
});


		</script>

<script src="./assets/chart/js/highcharts.js"></script>

<div id="pim" align="center"></div>
<div class="modal fade" id="daftar_pegawai7" role="dialog">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header text-primary">
				<span id="judul7"></span>
				<a class="btn btn-danger pull-right" data-dismiss="modal">Tutup</a>

			</div>
			<div class="modal-body">
				<div id="contentnya7"></div>
			</div>
			<div class="modal-footer">
			
				<a class="btn btn-danger" data-dismiss="modal">Tutup</a>
			</div>
		</div>
	</div>
</div>