		<script type="text/javascript">
$(function () {
    $('#opd').highcharts({
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: 1,//null,
            plotShadow: false,
			width: 1000,
			height: 900
		
        },
        title: {
			<?php
			
		
			$where = "where flag_pensiun=0 ";
			$opd = "Pemerintah Kota Bogor";
		
			
			$q=mysqli_query($mysqli,"select count(*) from pegawai $where ");
			$itung=mysqli_fetch_array($q);
			
			?>
            text: 'Persentase Pegawai <?php echo $opd; ?> Per Organisasi Perangakat Daerah <?php echo("($itung[0] pegawai)"); ?>'
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.y}  </b>'
        },
        plotOptions: {
            pie: {
				size:'55%',
                allowPointSelect: true,
                cursor: 'pointer',
				startAngle: 90,
                dataLabels: {
                    enabled: true,
					 padding: 0,
					 
                    format: '<b>{point.name}</b>: {point.percentage:.2f} % ({point.y})',
                    style: {
                        color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black',fontSize: '10px'
                    }
                }
            }
        },
<?php

			

$qg=mysqli_query($mysqli,"SELECT count(*),id_skpd
FROM `current_lokasi_kerja` inner join pegawai on pegawai.id_pegawai = current_lokasi_kerja.id_pegawai
inner join unit_kerja on unit_kerja.id_unit_kerja=current_lokasi_kerja.id_unit_kerja
where flag_pensiun=0 and tahun=2017 group by id_skpd
ORDER BY count(*) ASC");

?>		
		
        series: [{
            type: 'pie',
            name: 'Jumlah Pegawai',
            data: [
			
			<?php
			$i=1;
			while($data=mysqli_fetch_array($qg))
			{
			
			$qunit=mysqli_query($mysqli,"select nama_baru from unit_kerja where id_unit_kerja=$data[1]");
			$unit=mysqli_fetch_array($qunit);
			if($i==1)
			echo("['".$unit[0]."', $data[0] ]");	
			else
			echo(",['".$unit[0]."', $data[0] ]");	
			
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
   url:"processfungall.php",
   data: "lp="+this.name+"&unit=<?php echo $unit[0]; ?>",
   success: function (data)
   {
			
				
			
		  $('#judul4').html('Data Pegawai Dengan Jabatan Fungsional '+ x);
		  $('#contentnya4').html(data);
  }
   
   }); 
					  $("#daftar_pegawai4").modal("show");
					  
					 
                  }
              }
          } 
        }]
    });
});


		</script>
	
<script src="./assets/chart/js/highcharts.js"></script>

<div id="opd" align="center"></div>
<div class="modal fade" id="daftar_pegawai4" role="dialog">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header text-primary">
				<span id="judul4"></span>
				<a class="btn btn-danger pull-right" data-dismiss="modal">Tutup</a>

			</div>
			<div class="modal-body">
				<div id="contentnya4"></div>
			</div>
			<div class="modal-footer">
			
				<a class="btn btn-danger" data-dismiss="modal">Tutup</a>
			</div>
		</div>
	</div>
</div>