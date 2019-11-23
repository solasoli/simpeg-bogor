<script type="text/javascript">
$(function () {
    $('#golbon3').highcharts({
	
	chart: {
    type: 'column'
  },
  title: {
    text: 'Pensiun Guru'
  },
  subtitle: {
    text: ''
  },
  xAxis: {
    categories: [
     <?php  $taon=date("Y");
	$taon2=date("Y")+6;
	for($i=$taon;$i<=$taon2;$i++) echo("$i,"); ?>
    ],
    crosshair: true
  },
  yAxis: {
    min: 0,
    title: {
      text: 'Jumlah Guru Yang Akan Pensiun'
    }
  },
  tooltip: {
    headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
    pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
      '<td style="padding:0"><b>{point.y:1f} Pejabat</b></td></tr>',
    footerFormat: '</table>',
    shared: true,
    useHTML: true
  },
  plotOptions: {
    column: {
      pointPadding: 0.2,
      borderWidth: 0
    },
	  series: {
                borderWidth: 0,
                dataLabels: {
                    enabled: true,
                    format: '{point.y:1f}'
                }
            }
  },
  series: [{
    name: 'Guru Pensiun',
    data: [
	<?php
	$j=1;
	$setring="";
	for($i=2019;$i<=2022;$i++)
	{
	$qc=mysqli_query($mysqli,"select count(*) from pegawai where jenjab like 'fungsional' and 

tgl_pensiun_dini like '$i-%' and  jabatan like '%guru%' and flag_provinsi=0");
	$itung=mysqli_fetch_array($qc);
	if($j==1)
	$set="$itung[0]";
	else
	$set=",$itung[0]";
	$setring=$setring."$set";
	$j++;
	}
	echo $setring;
	?>
	
	]

  }
  
  ]
	});
});
</script>

<div id="golbon3" align="center" ></div>
