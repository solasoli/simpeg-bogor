<?php
class Stat_class{

	public function perTahun(){

		//$stat = array();
		$sql = "select tahun, count(*) as jumlah

				from proper
				group by tahun
				";

		$results = mysql_query($sql);

		while($result =  mysql_fetch_object($results)){
			$stat[] = $result;
		}

		return $stat;
	}


}






$stat = new Stat_class();

?>
<script src="<?php echo BASE_URL.'js/jquery.min.js' ?>"></script>
<script src="<?php echo BASE_URL.'assets/chart/js/highcharts.js' ?>"></script>
<script src="<?php echo BASE_URL.'assets/chart/js/highcharts-3d.js' ?>"></script>
<script src="<?php echo BASE_URL.'assets/chart/js/modules/data.js' ?>"></script>
<script src="<?php echo BASE_URL.'assets/chart/js/modules/exporting.js' ?>"></script>
<div class="row">
	<div class="col-md-12">
		<div id="gol_stat" style="width:100%; height:400px;"></div>
	</div>
	<div class="col-md-2 hide">
		<table class="table table-bordered table-striped table-hover" id="datatable">
			<thead>
				<tr>
					<th></th>
					<th>Pendek</th>
					<th>Menengah</th>
					<th>Menengah</th>
				</tr>
			</thead>
			<tbody>
				<?php

					foreach($stat->perTahun() as $taun){

						echo "<tr>";
						echo "<th>Tahun ".$taun->tahun."</th>";
						echo "<td>".$taun->jumlah."</td>";
						echo "<td>".$taun->jumlah."</td>";
						echo "</tr>";
					}
				?>
			</tbody>
		</table>
	</div>
</div>


<div class="row">
	<div class="col-md-12">
		<div id="gol_stat" style="width:100%; height:400px;"></div>
	</div>
	<div class="col-md-2 hide">
		<table class="table table-bordered table-striped table-hover" id="datatable">
			<thead>
				<tr>
					<th></th>
					<th>Proper</th>
				</tr>
			</thead>
			<tbody>
				<?php

					foreach($stat->perTahun() as $taun){

						echo "<tr>";
						echo "<th>Tahun ".$taun->tahun."</th>";
						echo "<td>".$taun->jumlah."</td>";
						echo "</tr>";
					}
				?>
			</tbody>
		</table>
	</div>
</div>

<script type="text/javascript">

$(document).ready(function() {
   $('#gol_stat').highcharts({
        data: {
            table: 'datatable'
        },
        chart: {
            type: 'column',
        },
        plotOptions: {
			pie: {
                allowPointSelect: true,
                depth: 35,

            }
		},
        title: {
            text: 'Statistik Hasil Proyek Perubahan yang berjalan'
        },
		xAxis:{
			title: {
				text: 'Tahun'
			}
		},
        yAxis: {
            title: {
                text: 'Jumlah'
            }
        },
        tooltip: {
            formatter: function () {
                return '<b>' + this.series.name + '</b><br/>' +
                    this.point.name+ ' : ' + this.point.y;
            }
        }
    });
});
</script>
