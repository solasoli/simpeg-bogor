 <?php
 
 require "/class/pendidikan.php";
 
$pendidikan = new Pendidikan;
$riwayat_pendidikan = $pendidikan->get_riwayat_pendidikan($_SESSION['id_pegawai']);

?> 
 
 <table class="display table table-bordered" id="table_pendidikan">
	<thead>
		<tr>
		  <th>No</th>
		  <th>Tingkat Pendidikan</th>
		  <th>Lembaga Pendidikan</th>		 
		  <th>Tahun Lulus</th>
		  <th>Tgl Ijazah <br/>tttt-bb-hh</th>
		  <th>No Ijazah</th>
		  <th>Aksi</th>
		</tr>
	<thead>
	<tbody>
		<?php 
			$x=1;
			foreach($riwayat_pendidikan as $rp){
		?>
		<tr>
			<td><?php echo $x++ ?></td>
			<td><?php echo $rp->tingkat_pendidikan." ".$rp->jurusan_pendidikan ?></td>
			<td><?php echo $rp->lembaga_pendidikan ?></td>			
			<td><?php echo $rp->tahun_lulus ?></td>
			<td><?php echo $rp->tgl_ijazah ?></td>
			<td><?php echo $rp->no_ijazah ?></td>
			<td>
				<a class="btn btn-primary" onclick="detail()">detail</a>
			</td>
		</tr>
		<?php } ?>
	</tbody>
  </table>
<div class="modal fade" id="pendidikan_modal" role="dialog">
	<div class="modal-dialog ">
		<div class="modal-content">
			<div class="modal-header text-primary">
				<h5><span class="glyphicon glyphicon-plus"></span> Pendidikan</h5>
			</div>
			<div class="modal-body">
				<form role="form" class="form-horizontal" id="newskpform">						
					<div class="form-group">
						<label for="tingkat_pendidikan">Tingkat Pendidikan</label>
						<select class="form-control" name="tingkat_pendidikan" id="tingkat_pendidikan">
							<option>PILIH</option>
							<option>S3</option>
							<option>S2</option>
							<option>S1</option>
							<option>D3</option>
							<option>D2</option>
							<option>D1</option>
							<option>SMA</option>
							<option>SMP</option>
							<option>SD</option> 
						</select>

						
					</div>
					<div class="form-group">
						<label for="lembaga_pendidikan">Nama Sekolah/PT</label>						
						<input type='text' name='lembaga_pendidikan' id='lembaga_pendidikan' class='form-control' value=''> 
					</div>
					<div class="form-group">
						<label for="jurusan">Jurusan</label>
						<input type="text" name="jurusan" id="jurusan" class="form-control" value="">
					</div>
					<div class="form-group">
						<label for="tahun_lulus">Tahun Lulus</label>
						<input type="text" name="tahun_lulus" id="tahun_lulus" class="form-control" value="">
					</div>
					<div class="form-group">
						<label for="unit_kerja_penilai">tgl_ijazah</label>						
						<input type='text' name='unit_kerja_atasan_penilai' id='unit_kerja_atasan_penilai' class='form-control' value=''>
																	
					</div>					
				</form>
			</div>
			<div class="modal-footer">
				<a  onclick="berikutnya()" data-toggle="modal" class="btn btn-primary">Berikutnya</a>
				<a class="btn btn-danger" data-dismiss="modal">batal</a>
			</div>
		</div>
	</div>
</div>

  
  <script type="text/javascript">
	$(document).ready(function(){
		$("#table_pendidikan").dataTable({
			dom: 'Bfrtip',
			buttons:[{				
				text:"tambah pendidikan",
				action: function ( e, dt, node, config ) {
                    //alert( 'Button activated' ); 
					$("#pendidikan_modal").modal("show");
				}
			}]
		});
	});
	
	function detail(){
		$('#pendidikan_form').modal('show');
	}
  </script>
  