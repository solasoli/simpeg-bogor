<script type="text/javascript">
$(function () {
    $('#kelamin').highcharts({
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
            text: 'Persentase Pegawai <?php echo $opd; ?> Per Jenis Kelamin <?php echo("($itung[0] pegawai)"); ?>'
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.y}  </b>'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
				startAngle: 270,
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

$qg=mysqli_query($mysqli,"SELECT count( * ) , jenis_kelamin
FROM pegawai $where2
GROUP BY jenis_kelamin");

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
			$tp="Laki Laki";
			elseif($data[1]==2)			
			$tp="Perempuan";
			
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
            ]
        }]
    });
});


		</script>
	


<div id="kelamin" style="min-width: 280px; height: 400px; max-width: 600px; margin: 0 auto; width: 400px;" ></div>