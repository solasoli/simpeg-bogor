<style type="text/css">
<!--
.style2 {color: #FFFFFF}
-->
</style>

<table id="pejabat_list">
	<thead>
		<tr>
			<th>Nama</th>
			<th>NIP</th>
			<th>Gol</th>
			<th>Unit Kerja</th>
			<th>Jabatan</th>
			<th>Eselon</th>
			<th>Tanggal Lahir</th>
			<th>Batas Usia Pensiun</th>
		</tr>
	</thead>	
</table>


<script src="assets/DataTables/media/js/jquery.dataTables.js" type="text/javascript"></script>
<script>
$("#pejabat_list").dataTable({
        "ajax": '../simpeg2/index.php/pensiun/list_pejabat_dataTable'
    } );
</script>