<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<?php $this->load->view('layout/header'); ?>
<br>
<div class="container">
	<h2>Daftar Batas Usia Pensiun Pegawai</h2>
</div>


<div class="container">
	<div class="baloon">
		<form class="form">
			<label>Pilih Unit Kerja</label>
			<input type="select">
		</form>
	</div>
</div>

<div class="container">
	<table class="table">
		<thead>
			<tr>
				<th>No</th>
				<th>Nama</th>
				<th>NIP</th>
				<th>BUP</th>
				<th>Aksi</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>1</td>
				<td>nama</td>
				<td>asdasd</td>
				<td>123123</td>
				<td>asdasd</td>
			</tr>
		</tbody>
	</table>
</div>

<?php $this->load->view('layout/footer'); ?>
