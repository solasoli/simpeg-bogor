		<script type="text/javascript">
$(function () {
    $('#bid').highcharts({
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: 1,//null,
            plotShadow: false
        },
        title: {
			<?php
		
			$where = " inner join pegawai  on pegawai.id_pegawai=pendidikan_terakhir.id_pegawai where flag_pensiun=0 ";
			
			$q=mysqli_query($mysqli,"select count(*) from pendidikan_terakhir $where and level_p<7");
			$itung=mysqli_fetch_array($q);
			
			?>
            text: 'Persentase Pegawai <?php echo $opd; ?> Per  Bidang Pendidikan <?php echo("($itung[0] pegawai)"); ?>'
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

$qg=mysqli_query($mysqli,"select count(*),bidang from pendidikan_terakhir  inner join pegawai on pegawai.id_pegawai = pendidikan_terakhir.id_pegawai inner join pendidikan on pendidikan.id_pendidikan = pendidikan_terakhir.id_pendidikan inner join bidang_pendidikan on bidang_pendidikan.id=pendidikan.id_bidang  $where2 and pendidikan_terakhir.level_p<7 group by bidang");

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
   url:"processbid.php",
   data: "lp="+this.name+"&unit=<?php echo $unit[0]; ?>",
   success: function (data)
   {
			
				
			
		  $('#judul8').html('Data Pegawai Dengan Bidang Pendidikan '+ x);
		  $('#contentnya8').html(data);
  }
   
   }); 
					  $("#daftar_pegawai8").modal("show");
					  
					 
                  }
              }
          } 
        }]
    });
});


		</script>

<script src="./assets/chart/js/highcharts.js"></script>

<div id="bid" align="center"></div>
<div class="modal fade" id="daftar_pegawai8" role="dialog">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header text-primary">
				<span id="judul8"></span>
				<a class="btn btn-danger pull-right" data-dismiss="modal">Tutup</a>

			</div>
			<div class="modal-body">
				<div id="contentnya8"></div>
			</div>
			<div class="modal-footer">
			
				<a class="btn btn-danger" data-dismiss="modal">Tutup</a>
			</div>
		</div>
	</div>
</div>
