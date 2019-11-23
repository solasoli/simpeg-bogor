<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<?php $this->load->view('layout/header', array( 'title' => 'Simpeg::Daftar Pejabat Struktural')); ?>


<div class="container">
	<h2>Daftar Pejabat Struktural</h2>

	<table class="table bordered hovered" id="uklist">
		<thead>
			<tr>
				<th>No</th>
				<th>Nama</th>
				<th>Jabatan</th>
				<th>Eselon</th>
				<th>Pendidikan</th>
                <th>Golongan</th>
                <th>Umur</th>
			</tr>
		</thead>
		<tfoot>
		<tr>
				<th>No</th>
				<th>Nama</th>
				<th>Jabatan</th>
				<th>Eselon</th>
				<th>Pendidikan</th>
                <th>Golongan</th>
                <th>Umur</th>
			</tr>
		</tfoot>
		<tbody>	
			
		</tbody>	
	</table>
</div>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.3.1/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.3.1/js/buttons.flash.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.27/build/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.27/build/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.3.1/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.3.1/js/buttons.print.min.js"></script>



<script>

	$(document).ready(function(){
		
		
		
	
			
     $('#uklist tfoot th').each( function () {
        var title = $(this).text();
        $(this).html( '<input type="text" placeholder="Search '+title+'" />' );
    } );
 
   
		
	
		table = $('#uklist').DataTable({ 
			
			"processing": true, //Feature control the processing indicator.
			"serverSide": true, //Feature control DataTables' server-side processing mode.
			"order": [], //Initial no order.

			// Load data for the table's content from an Ajax source
			"ajax": {
				"url": "<?php echo site_url('datatablestruktural/ajax_list')?>",
				"type": "POST"
			},

			//Set column definition initialisation properties.
			"columnDefs": [
			{ 
				"targets": [ 0 ], //first column / numbering column
				"orderable": false, 
				//set not orderable
			},
			],
			
			dom: 'Bfrtip',
			buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],

    });
	
	 // Apply the search
	$("#uklist_filter").css("display","none");
	
	 table.columns().every( function () {
        var that = this;
 
        $( 'input', this.footer() ).on( 'keyup change', function () {
            if ( that.search() !== this.value ) {
                that
                    //.search( this.value.replace(/;/g, "|"), true, false )
					.search( this.value )
                    .draw();
            }
        } );
    } );	
		
		
	});
</script>

<?php $this->load->view('layout/footer'); ?>
