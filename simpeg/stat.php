		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
		
		<style type="text/css">
${demo.css}
		</style>
		<script type="text/javascript">
$(function () {
    $('#cht').highcharts({
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: 1,//null,
            plotShadow: false
        },
        title: {
			<?php
			
			if($_SESSION['id_pegawai']!=12239)
			{
			$qunit=mysqli_query($mysqli,"select id_skpd from unit_kerja where id_unit_kerja=$_SESSION[id_unit]");
			$unit=mysqli_fetch_array($qunit);
			$where = " inner join current_lokasi_kerja on pegawai.id_pegawai = current_lokasi_kerja.id_pegawai inner join unit_kerja on unit_kerja.id_unit_kerja=current_lokasi_kerja.id_unit_kerja  where flag_pensiun=0 and id_skpd = $unit[0] ";
			$opd = $_SESSION['opd'];
			}
			else
			{
			$where = "where flag_pensiun=0 ";
			$opd = "Pemerintah Kota Bogor";
			}
			
			
			
			$q=mysqli_query($mysqli,"select count(*) from pegawai $where");
			$itung=mysqli_fetch_array($q);
			
			?>
            text: 'Persentase Pegawai <?php echo $opd; ?> Per Tingkat Pendidikan <?php echo("($itung[0] pegawai)");    ?>'
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

			if($_SESSION['id_pegawai']!=12239)
			{
			$where2 = " inner join pegawai on pegawai.id_pegawai=pendidikan_terakhir.id_pegawai inner join current_lokasi_kerja on pegawai.id_pegawai = current_lokasi_kerja.id_pegawai  inner join unit_kerja on unit_kerja.id_unit_kerja=current_lokasi_kerja.id_unit_kerja where flag_pensiun=0 and id_skpd =$unit[0]  ";
			}
			else
			$where2 = " inner join pegawai on pegawai.id_pegawai=pendidikan_terakhir.id_pegawai where flag_pensiun=0 ";
			
			
$qg=mysqli_query($mysqli,"SELECT count( * ) , level_p
FROM pendidikan_terakhir $where2
GROUP BY level_p");

?>		
		
        series: [{
            type: 'pie',
            name: 'Jumlah Pegawai',
            data: [
			
			<?php
			$i=1;
			while($data=mysqli_fetch_array($qg))
			{
			if($data[1]==1)
			$tp="S3";
			elseif($data[1]==2)			
			$tp="S2";
			elseif($data[1]==3)			
			$tp="S1";
			elseif($data[1]==4)			
			$tp="D3";
			elseif($data[1]==5)			
			$tp="D2";
			elseif($data[1]==6)			
			$tp="D1";
			elseif($data[1]==7)			
			$tp="SMA";
			elseif($data[1]==8)			
			$tp="SMP";
			elseif($data[1]==9)			
			$tp="SD";
			
			if($i==1)
			echo("['".$tp."', $data[0] ]");	
			else
			echo(",['".$tp."', $data[0] ]");	
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
   url:"process.php",
   data: "lp="+this.name+"&unit=<?php echo $unit[0]; ?>",
   success: function (data)
   {
			
			//var tp;
			if(x==1)
				tp="S3";
			else if(x==2)
				tp="S2";
			else if(x==3)
				tp="S1";
			else if(x==4)
				tp="D3";
			else if(x==5)
				tp="D2";
			else if(x==6)
				tp="D1";
			else if(x==7)
				tp="SMA / SMK";
			else if(x==8)
				tp="SMP";
			else if(x==9)
				tp="SD";
			
			
		  $('#judul').html('Data Pegawai Dengan Tingkat Pendidikan '+ x);
		  $('#contentnya').html(data);
  }
   
   }); 
					  $("#daftar_pegawai").modal("show");
					  
				
			
                  }
              }
          }    
        }]
    });
});


		</script>
	
<script src="./assets/chart/js/highcharts.js"></script>
<script src="./assets/chart/js/modules/exporting.js"></script>

<div id="cht" style="min-width: 280px; height: 400px; max-width: 600px; margin: 0 auto"></div>
<div class="modal fade" id="daftar_pegawai" role="dialog">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header text-primary">
				<span id="judul"></span>
				<a class="btn btn-danger pull-right" data-dismiss="modal">Tutup</a>

			</div>
			<div class="modal-body">
				<div id="contentnya"></div>
			</div>
			<div class="modal-footer">
			
				<a class="btn btn-danger" data-dismiss="modal">Tutup</a>
			</div>
		</div>
	</div>
</div>
