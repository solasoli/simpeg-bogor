		<script type="text/javascript">
$(function () {
    $('#proper2').highcharts({
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
			
		
			$q=mysqli_query($mysqli,"select count(*) from proper");
			$itung=mysqli_fetch_array($q);
			
			?>
            text: 'Persentase Jumlah Proyek Perubahan Per Tahun :<?php echo("($itung[0] Proyek Perubahan)"); ?>'
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
			$where2 = " inner join current_lokasi_kerja on pegawai.id_pegawai = current_lokasi_kerja.id_pegawai  inner join unit_kerja on unit_kerja.id_unit_kerja=current_lokasi_kerja.id_unit_kerja where flag_pensiun=0 and id_skpd =$unit[0]  ";
			}
			else
			$where2 = " where flag_pensiun=0 ";
			


$qg=mysqli_query($mysqli,"SELECT count( * ) , tahun
FROM proper 
GROUP BY tahun");

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
   url:"processproper.php",
   data: "lp="+this.name+"&unit=<?php echo $unit[0]; ?>",
   success: function (data)
   {
			
				
			
		  $('#judul99').html('Data Proyek Perubahan Tahun '+ x);
		  $('#contentnya99').html(data);
  }
   
   }); 
					  $("#daftar_pegawai99").modal("show");
					  
					 
                  }
              }
          }    
        }],
	
    });
});


		</script>
	
<script src="./assets/chart/js/highcharts.js"></script>


<div id="proper" align="center" ></div>
<div class="modal fade" id="daftar_pegawai99" role="dialog">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header text-primary">
				<span id="judul99"></span>
				<a class="btn btn-danger pull-right" data-dismiss="modal">Tutup</a>

			</div>
			<div class="modal-body">
				<div id="contentnya99"></div>
			</div>
			<div class="modal-footer">
			
				<a class="btn btn-danger" data-dismiss="modal">Tutup</a>
			</div>
		</div>
	</div>
</div>