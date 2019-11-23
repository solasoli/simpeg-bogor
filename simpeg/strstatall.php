		<script type="text/javascript">
$(function () {
    $('#struk').highcharts({
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: 1,//null,
            plotShadow: false
        },
        title: {
			<?php
			
				
			$where = "where flag_pensiun=0 ";
			$opd = "Pemerintah Kota Bogor";
		
			
			$q=mysqli_query($mysqli,"select count(*) from pegawai $where and jenjab like 'struktural'");
			$itung=mysqli_fetch_array($q);
			
			?>
            text: 'Persentase Pegawai <?php echo $opd; ?> Per Jabatan Struktural <?php echo("($itung[0] pegawai)"); ?>'
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


			$where2 = " where flag_pensiun=0 and jenjab like 'struktural' and pegawai.id_j>0";
			$where3= " where flag_pensiun=0 and jenjab like '%Struktural%' and ( pegawai.id_j=0 or pegawai.id_j is null) ";
	

$qg=mysqli_query($mysqli,"SELECT count(*),jabatan.eselon from pegawai inner join jabatan on jabatan.id_j = pegawai.id_j $where2 
GROUP BY eselon");

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
			echo("['Eselon ".$data[1]."', $data[0] ]");	
			else
			echo(",['Eselon ".$data[1]."', $data[0] ]");	
			$i++;	
			}
			$qco=mysqli_query($mysqli,"SELECT count(*) from pegawai  $where3 ");
			$co=mysqli_fetch_array($qco);
			echo(",['Staf', $co[0] ]");	
			?>

            ],
				point:{
              events:{
                  click: function (event) {
				  
					var x = this.name;
                      jQuery.noConflict();
					  
					  
				  $.ajax({
   type:"POST",
   url:"processstrukall.php",
   data: "lp="+this.name+"&unit=<?php echo $unit[0]; ?>",
   success: function (data)
   {
			
				
			
		  $('#judul5').html('Data Pegawai Dengan Jabatan Struktural '+ x);
		  $('#contentnya5').html(data);
  }
   
   }); 
					  $("#daftar_pegawai5").modal("show");
					  
					 
                  }
              }
          } 
        }]
    });
});


		</script>

<script src="./assets/chart/js/highcharts.js"></script>

<div id="struk" align="center"></div>
<div class="modal fade" id="daftar_pegawai5" role="dialog">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header text-primary">
				<span id="judul5"></span>
				<a class="btn btn-danger pull-right" data-dismiss="modal">Tutup</a>

			</div>
			<div class="modal-body">
				<div id="contentnya5"></div>
			</div>
			<div class="modal-footer">
			
				<a class="btn btn-danger" data-dismiss="modal">Tutup</a>
			</div>
		</div>
	</div>
</div>