<script src="js/jquery.min.js"></script>
<div class="row">
	<div class="col-md-12">
		<div id="gol_stat" style="width:100%; height:400px;"></div>
	</div>
	<div class="col-md-2 hide">
		<table class="table table-bordered table-striped table-hover" id="datatable">
			<thead>		
				<tr>
					<th></th>
					<th>Jumlah</th>
				</tr>
			</thead>
			<tbody>		
				<?php
					
					foreach($stat->getByGolongan() as $by_gol){
						echo "<tr>";
						echo "<th>".$by_gol->pangkat_gol."</th>";
						echo "<td>".$by_gol->jumlah."</td>";
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
            type: 'pie',
            options3d: {
                enabled: true,
                alpha: 45,                
                beta: 0
            }
        },
        plotOptions: {
			pie: {
                allowPointSelect: true,
                depth: 35,
                
            }
		},
        title: {
            text: 'Sebaran Pegawai Pemerintah Kota Bogor Berdasarkan Golongan'
        },
        yAxis: {
            allowDecimals: false,
            title: {
                text: 'Units'
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

