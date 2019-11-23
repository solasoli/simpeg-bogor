		<script type="text/javascript">
$(function () {
    $('#jafung').highcharts({
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: 1,//null,
            plotShadow: false
        },
        title: {
			<?php
			
		
			$where = "where flag_pensiun=0 ";
			$opd = "Pemerintah Kota Bogor";
		
			
			$q=mysqli_query($mysqli,"select count(*) from pegawai $where and jenjab like 'fungsional'");
			$itung=mysqli_fetch_array($q);
			
			?>
            text: 'Persentase Pegawai <?php echo $opd; ?> Per Jabatan Fungsional <?php echo("($itung[0] pegawai)"); ?>'
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

$qg=mysqli_query($mysqli,"SELECT count(*),jabatan from pegawai $where2 and jenjab like 'fungsional'
GROUP BY jabatan");

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
			{
			if($data[1]!="Guru")
			echo(",['".$data[1]."', $data[0] ]");	
			else
			{
			$qsert=mysqli_query($mysqli,"select count(*) from sertifikasi_guru inner join pegawai on pegawai.id_pegawai=sertifikasi_guru.id_pegawai where flag_pensiun=0 and jabatan like 'Guru%'");
			$sert=mysqli_fetch_array($qsert);
			echo(",['Guru Sertifikasi', $sert[0] ]");
			
			$qnyon=mysqli_query($mysqli,"select count(*) from pegawai where jabatan like 'guru%' and flag_pensiun=0");
			$nyon=mysqli_fetch_array($qnyon);
			$non=$nyon[0]-$sert[0];
			echo(",['Guru', $non ]");
			}
			}
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

<div id="jafung" align="center" style="height: 700px;width: 65%;"></div>
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