		<script type="text/javascript">
$(function () {
    $('#umur').highcharts({
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: 1,//null,
            plotShadow: false
        },
        title: {
			<?php
	
				$where = "where flag_pensiun=0 ";
			$opd = "Pemerintah Kota  Bogor";
		
			
			$q=mysqli_query($mysqli,"select count(*) from pegawai $where ");
			$itung=mysqli_fetch_array($q);
			
			?>
            text: 'Persentase Pegawai <?php echo $opd; ?>  Per Umur <?php echo("($itung[0] pegawai)"); ?>'
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
<?php


			$where2 = " where flag_pensiun=0 ";

$qg=mysqli_query($mysqli,"SELECT count(*),floor(datediff(curdate(),tgl_lahir)/365) FROM pegawai $where2 group by floor(datediff(curdate(),tgl_lahir)/365)");

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
			echo("['".$data[1]." Tahun', $data[0] ]");	
			else
			echo(",['".$data[1]." Tahun ', $data[0] ]");	
			$i++;	
			}

			?>

            ],
				point:{
              events:{
                  click: function (event) {
				  
					var x = this.name;
                      jQuery.noConflict();
					  
					  
				  $.ajax({
   type:"POST",
   url:"processumurall.php",
   data: "lp="+this.name+"&unit=<?php echo $unit[0]; ?>",
   success: function (data)
   {
			
				
			
		  $('#judul6').html('Data Pegawai Dengan Umur '+ x);
		  $('#contentnya6').html(data);
  }
   
   }); 
					  $("#daftar_pegawai6").modal("show");
					  
					 
                  }
              }
          } 
        }]
    });
});


		</script>

<script src="./assets/chart/js/highcharts.js"></script>

<div id="umur" align="center"></div>
<div class="modal fade" id="daftar_pegawai6" role="dialog">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header text-primary">
				<span id="judul6"></span>
				<a class="btn btn-danger pull-right" data-dismiss="modal">Tutup</a>

			</div>
			<div class="modal-body">
				<div id="contentnya6"></div>
			</div>
			<div class="modal-footer">
			
				<a class="btn btn-danger" data-dismiss="modal">Tutup</a>
			</div>
		</div>
	</div>
</div>