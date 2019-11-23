<html>
<head>
	<title>Surat Cuti</title>
	<style>
		@media print{
			#screen_only{
				display: none;
			}
		}
	</style>
</head>
<body>
<div id="screen_only">
	<a href="#" onClick="window.print()">Print</a> |
	<?php echo anchor('cuti/registrasi/'.$cuti->id_pegawainya, 'Kembali'); ?>
</div>
<?php
	if(!isset($cuti)) redirect('cuti');
	else
	//print_r($cuti);
?>
<div style="max-width:800px">
<table>
	<tr>
		<td>
			<img height="100" src="<?php echo base_url()."images/logo_kota.jpg" ?>" />
		</td>
		<td align="center">
			<strong>
				BADAN KEPEGAWAIAN, PENDIDIKAN DAN PELATIHAN<br />
				PEMERINTAHAN KOTA BOGOR<br />
				Jl. Ir. H. Juanda No. 10 Telp. (0251) 8358942 Fax. (0251) 8356170<br/>
				BOGOR - 16121<br/>
			</strong>
		</td>
	</tr>
</table>
<hr />

<div align="right">
Bogor, <?php echo $tgl_surat ?><br />
</div>

<div align="center">
	<u><b>SURAT IZIN <?php echo strtoupper($cuti->deskripsi); ?></b><br/></u>
	Nomor : <?php if($cuti->no_keputusan == "menunggu") ; else echo $cuti->no_keputusan; ?><br/>
</div>

<p>
Diberikan <?php echo $cuti->deskripsi ?> untuk tahun <?php echo substr($cuti->tmt_awal, strlen($cuti->tmt_awal)-4,4) ?> kepada Pegawai Negeri Sipil :
</p>

<p>
	<table>
		<tr>
			<td>Nama</td>
			<td>:</td>
			<td><?php echo ($cuti->nama); ?></td>
		</tr>
		<tr>
			<td>NIP</td>
			<td>:</td>
			<td><?php echo ($cuti->nip_baru); ?></td>
		</tr>
		<tr>
			<td>Pangkat, Golongan Ruang</td>
			<td>:</td>
			<td><?php echo ($cuti->pangkat)." - ".($cuti->pangkat_gol); ?></td>
		</tr>
		<tr>
			<td>Jabatan</td>
			<td>:</td>
			<td><?php if($cuti->jab_jabatan) echo ($cuti->jab_jabatan);
					  else echo $cuti->peg_jabatan; ?></td>
		</tr>
		<tr>
			<td>Unit Kerja</td>
			<td>:</td>
			<td><?php echo ($cuti->nama_baru); ?></td>
		</tr>
	</table>
</p>

<p>
Selama <?php echo $lama_cuti ?> hari kerja terhitung mulai tanggal <?php echo $cuti->tmt_awal ?> s/d <?php echo $cuti->tmt_selesai ?> dengan ketentuan sebagai
berikut :
</p>

<ol>
	<li>Sebelum menjalankan <?php echo $cuti->deskripsi ?>, wajib menyerahkan pekerjaan kepada atasan langsungnya;</li>
	<li>Setelah selesai menjalankan <?php echo $cuti->deskripsi ?>, wajib melaporkan diri kepada atasan langsungnya dan
bekerja kembali sebagaimana biasa.</li>
</ol>

<p>
Demikian surat izin <?php echo $cuti->deskripsi ?> ini dibuat untuk dapat digunakan sebagaimana mestinya.
</p>

<table>
<tr>
	<td width="400px">&nbsp;</td>
	<td width="400px">
		<div align="center">
			An. Kepala<br/>
			<?php $this->input->post('txtJabatanPengesah') ?>,<br/><br/><br/><br/>


			<?php echo $this->input->post('txtPengesah') ?><br/>
			<?php echo $this->input->post('txtPangkatPengesah') ?><br/>
			NIP. <?php echo $this->input->post('txtNipPengesah') ?><br/>
		</div>
	</td>
</tr>
</table>


Tembusan disampaikan kepada :
<ol>
	<li>Yth. Inspektur Kota Bogor</li>
	<li>Yth. Kepala Bagian Hukum Setda Kota Bogor;</li>
	<li>Pegawai Negeri Sipil yang bersangkutan.</li>
</ol>
</div>
</body>
</html>
