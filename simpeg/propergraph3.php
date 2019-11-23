		<script type="text/javascript">
$(function () {
    $('#golbon').highcharts({
	
	chart: {
    type: 'column'
  },
  title: {
    text: 'Progress Proyek Perubahan hingga <?php echo date("Y"); ?>'
  },
  subtitle: {
    text: ''
  },
  xAxis: {
    categories: [
     <?php  for($i=2015;$i<=date("Y");$i++) echo("$i,"); ?>
    ],
    crosshair: true
  },
  yAxis: {
    min: 0,
    title: {
      text: 'Jumlah Proyek Perubahan'
    }
  },
  tooltip: {
    headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
    pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
      '<td style="padding:0"><b>{point.y:.1f} mm</b></td></tr>',
    footerFormat: '</table>',
    shared: true,
    useHTML: true
  },
  plotOptions: {
    column: {
      pointPadding: 0.2,
      borderWidth: 0
    }
  },
  series: [{
    name: 'Berjalan',
    data: [
	<?php
	$j=1;
	$setring="";
	for($i=2015;$i<=date("Y");$i++)
	{
	$qc=mysqli_query($mysqli,"select count(*) from proper_status inner join proper on proper.id_proper=proper_status.id_proper where jangka like 'panjang' and approvement_pengelola=1 and status like 'berjalan' and tahun=$i");
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

  }, {
    name: 'Tidak Berjalan',
    data: [
	
	<?php
	$j=1;
	$setring="";
	for($i=2015;$i<=date("Y");$i++)
	{
	$qc=mysqli_query($mysqli,"select count(*) from proper_status inner join proper on proper.id_proper=proper_status.id_proper where jangka like 'panjang' and approvement_pengelola=1 and status like 'tidak berjalan' and tahun=$i");
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

  }]
	});
});


		</script>
	
<script src="./assets/chart/js/highcharts.js"></script>


<div id="golbon" align="center" ></div>
