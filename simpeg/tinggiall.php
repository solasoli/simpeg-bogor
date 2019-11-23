		<script type="text/javascript">
$(function () {
    $('#ting').highcharts({
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: 1,
            plotShadow: false
        },
        title: {
			<?php
	
			$where = " inner join pegawai on pegawai.id_pegawai=pendidikan_terakhir.id_pegawai where flag_pensiun=0";
			
			$q=mysqli_query($mysqli,"select count(*) from pendidikan_terakhir $where and level_p<7");
			$itung=mysqli_fetch_array($q);
			
			?>
            text: 'Persentase Pegawai <?php echo $opd; ?>  Per  Lulusan Sekolah Tinggi <?php echo("($itung[0] pegawai)"); ?>'
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

$qg=mysqli_query($mysqli,"select count(*),institusi from pendidikan_terakhir  inner join pegawai on pegawai.id_pegawai = pendidikan_terakhir.id_pegawai inner join pendidikan on pendidikan.id_pendidikan = pendidikan_terakhir.id_pendidikan inner join institusi_pendidikan on institusi_pendidikan.id=pendidikan.id_institusi  $where2 and pendidikan_terakhir.level_p<7 group by institusi");

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

            ],
				point:{
              events:{
                  click: function (event) {
				  
					var x = this.name;
                      jQuery.noConflict();
					  
					  
				  $.ajax({
   type:"POST",
   url:"processtingall.php",
   data: "lp="+this.name+"&unit=<?php echo $unit[0]; ?>",
   success: function (data)
   {
			
				
			
		  $('#judul9').html('Data Pegawai Lulusan '+ x);
		  $('#contentnya9').html(data);
  }
   
   }); 
					  $("#daftar_pegawai9").modal("show");
					  
					 
                  }
              }
          } 
        }]
    });
});


		</script>

<script src="./assets/chart/js/highcharts.js"></script>

<div id="ting" align="center" style="width:80%"></div>
<div class="modal fade" id="daftar_pegawai9" role="dialog">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header text-primary">
				<span id="judul9"></span>
				<a class="btn btn-danger pull-right" data-dismiss="modal">Tutup</a>

			</div>
			<div class="modal-body">
				<div id="contentnya9"></div>
			</div>
			<div class="modal-footer">
			
				<a class="btn btn-danger" data-dismiss="modal">Tutup</a>
			</div>
		</div>
	</div>
</div>
