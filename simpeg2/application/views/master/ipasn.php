<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<?php $this->load->view('layout/header', array( 'title' => 'Simpeg::Daftar Unit Kerja')); ?>
<?php $this->load->view('master/header_ipasn', array( 'title' => '', 'idproses' => 0)); ?>

<div class="container">
	<h2>INDEKS PROFESIONALITAS ASN</h2>

	<table class="table bordered hovered" id="uklist">
		<thead>
			<tr>
				<th>No</th>
				<th>Id Unit Kerja</th>
				<th>Unit Kerja</th>
				<th>OPD</th>
				<th>Aksi</th>
			</tr>
		</thead>
		<tbody>
			<?php $x= 1; foreach($daftarUnitKerja as $k){ ?>
			<tr>
				<td><?php echo $x++ ?></td>
				<td><?php echo $k->id_unit_kerja ?></td>
				<td><?php echo $k->nama_baru ?></td>
				<td></td>
				<td>
					<a href="<?php echo base_url('ipasn/daftar_pejabat/'.$k->id_unit_kerja) ?>" data-hint="Daftar Pegawai|Lihat Daftar Pegawai <?php echo $k->nama_baru ?>" class="button success">
						<span class="icon-user-3"></span>
					</a>
				</td>
			</tr>
			<?php } ?>
		</tbody>	
	</table>
</div>

<script>

	$(document).ready(function(){
		
		$('#uklist').dataTable();
	});
</script>

<?php $this->load->view('layout/footer'); ?>
