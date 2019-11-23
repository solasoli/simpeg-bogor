<?php $unit_kerja = new Unit_kerja; ?>


<h2>DAFTAR NAMA JFU <br></h2>
<?php

$qo=mysqli_query($mysqli,"select * from jfu_master");

?>
<table id="list_pegawai" class="table table-bordered">
	<thead>
		<tr>
			<th>No</th>
			<th>kode</th>
			<th>Nama</th>			
		</tr>
	</thead>
	<tbody>
		<?php
			$r=1;			
			while($bata=mysqli_fetch_array($qo)){			
		
		?>
		<tr>
			<td><?php echo $r ?></td>
			<td><?php echo $bata['kode_jabatan'] ?> </td>
			<td><?php echo $bata['nama_jfu'] ?></td>			
		</tr>
		<?php $r++; } ?>
	</tbody>
</table>

<script>
$(document).ready(function() {
	$('#list_pegawai').dataTable({
       "dom": 'T<"clear">lfrtip',
        "tableTools": {
            "sSwfPath": "assets/DataTables/extensions/TableTools/swf/copy_csv_xls_pdf.swf" 
        }
    });
    
    
  
});
</script>
