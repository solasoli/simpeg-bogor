<?php
class Stat_class{
	
	public function perTahun(){
		
		//$stat = array();
		$sql = "select tahun, jumlah from 
				(select count(*) as jumlah, CAST(extract(year from periode_awal) as CHAR) as tahun
				from skp_header
				group by extract(year from periode_awal)
				) as i
				group by tahun";
				
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
					<th>Orang</th>
				</tr>
			</thead>
			<tbody>		
				<?php
					$t = '2014';
					foreach($stat->perTahun() as $taun){
						
						echo "<tr>";
						echo "<th>Tahun ".$t++."</th>";
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
            text: 'Statistik penggunaan SKP Online per tahun'
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

