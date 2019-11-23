<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<?php $this->load->view('layout/header', array( 'title' => 'Simpeg::Daftar Pejabat Struktural')); ?>


<div class="container">
	<h2>Daftar Pejabat Struktural</h2>

	<table class="table bordered hovered" id="uklist">
		<thead>
			<tr>
				<th >No</th>
				<th>Nama</th>
				<th>Jabatan</th>
				<th>Eselon</th>
				<th>Pendidikan</th>
                <th>Golongan</th>
                <th>Umur</th>
			</tr>
		</thead>
     
		<tbody>
			<?php $x= 1; foreach($pejabat as $p){ ?>
			<tr>
				<td><?php echo $x++; ?></td>
				<td><?php echo $p->nama; ?></td>
				<td><?php echo $p->jabatan; ?></td>
                <td><?php echo $p->eselon; ?></td>
				<td>
                <?php $pend = $this->struktural_model->get_pendidikan($p->idp);
				$po=1;
				$pt=false;
				foreach($pend as $pe)
				{
				
				if($pe->level_p<=6)
				{
				if($pe->level_p<=6 and $pe->idb>0)
				echo("$pe->tingkat_pendidikan $pe->jurusan_pendidikan [$pe->bidang]<br>");
				
				$pt=true;
				}
				
				else
				{
				if($pt==false){
				if($pe->idb>0)
				echo("$pe->tingkat_pendidikan $pe->jurusan_pendidikan [$pe->bidang]<br>");
				else
				echo("$pe->tingkat_pendidikan $pe->jurusan_pendidikan <br>");
				 }
				 }
				 $po++;
				 }?>
                </td>
                                <td><?php echo $p->pangkat_gol; ?></td>
				                <td><?php echo $p->umur; ?></td>
			</tr>
			<?php } ?>
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
		
		
		
	
		
		  $('#uklist thead th').each( function () {
        var title = $(this).text();
		if(title!='No')
		{
		if(title=='Eselon')
        $(this).html( 'Eselon<input type="text" style="width:50px;" placeholder="Eselon" />' );
		else if(title=='Golongan')
        $(this).html( 'Golongan<input type="text" style="width:70px;" placeholder="Golongan" />' );
		else if(title=='Umur')
        $(this).html( 'Umur<input type="text" style="width:50px;" placeholder="Umur" />' );
		else if(title=='Pendidikan')
        $(this).html( 'Pendidikan<input type="text" style="width:400px;" placeholder="Pendidikan" />' );
		else if(title=='Jabatan')
        $(this).html( 'Jabatan<input type="text" style="width:200px;" placeholder="Jabatan" />' );
		else if(title=='Nama')
        $(this).html( 'Nama<input type="text" style="width:250px;" placeholder="Nama" />' );
		else
		        $(this).html( '<input type="text" placeholder="Search '+title+'" />' );
		}
		else
		$(this).html('No');
    } );
 
    // DataTable
    var table = $('#uklist').DataTable({
		
		  dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
	});
 
    // Apply the search
    table.columns().every( function () {
        var that = this;
 
        $( 'input', this.header() ).on( 'keyup change', function () {
            if ( that.search() !== this.value ) {
                that
                    .search( this.value.replace(/;/g, "|"), true, false )
                    .draw();
            }
        } );
    } );
		
		
		
		
		
		
	});
</script>

<?php $this->load->view('layout/footer'); ?>
