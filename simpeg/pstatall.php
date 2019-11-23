		<script type="text/javascript">
$(function () {
    $('#gol').highcharts({
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: 1,//null,
            plotShadow: false
        },
        title: {
			<?php
			
			$where = "where flag_pensiun=0 ";
			$opd = "Pemerintah Kota Bogor";
			
			$q=mysqli_query($mysqli,"select count(*) from pegawai $where");
			$itung=mysqli_fetch_array($q);
			
			?>
            text: 'Persentase Pegawai <?php echo $opd; ?> Per Golongan <?php echo("($itung[0] pegawai)"); ?>'
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
                    format: '<b>{point.name}</b>: {point.percentage:.1f} % ({point.y})',
                    style: {
                        color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                    }
                }
            }
        },
<?php


			$where2 = " where flag_pensiun=0 ";


$qg=mysqli_query($mysqli,"SELECT count( * ) , pangkat_gol
FROM pegawai $where2
GROUP BY pangkat_gol");

?>		
		
        series: [{
            type: 'pie',
            name: 'Jumlah Pegawai',
            data: [
			
			<?php
			$i=1;
			while($data=mysqli_fetch_array($qg))
			{
			
			
			if($i==1)
			echo("['".$data[1]."', $data[0] ]");	
			else
			echo(",['".$data[1]."', $data[0] ]");	
			$i++;	
			}
			
			?>
/*                ['Firefox',   45.0],
                ['IE',       26.8],
                {
                    name: 'Chrome',
                    y: 12.8,
                    sliced: true,
                    selected: true
                },
                ['Safari',    8.5],
                ['Opera',     6.2],
                ['Others',   0.7]
				*/
            ],
				point:{
              events:{
                  click: function (event) {
				  
					var x = this.name;
                      jQuery.noConflict();
					  
					  
				  $.ajax({
   type:"POST",
   url:"processgolall.php",
   data: "lp="+this.name+"&unit=<?php echo $unit[0]; ?>",
   success: function (data)
   {
			
				
			
		  $('#judul2').html('Data Pegawai Dengan Golongan '+ x);
		  $('#contentnya2').html(data);
  }
   
   }); 
					  $("#daftar_pegawai2").modal("show");
					  
					 
                  }
              }
          }    
        }],
	
    });
});


		</script>
	
<script src="./assets/chart/js/highcharts.js"></script>


<div id="gol" align="center" ></div>
<div class="modal fade" id="daftar_pegawai2" role="dialog">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header text-primary">
				<span id="judul2"></span>
				<a class="btn btn-danger pull-right" data-dismiss="modal">Tutup</a>

			</div>
			<div class="modal-body">
				<div id="contentnya2"></div>
			</div>
			<div class="modal-footer">
			
				<a class="btn btn-danger" data-dismiss="modal">Tutup</a>
			</div>
		</div>
	</div>
</div>