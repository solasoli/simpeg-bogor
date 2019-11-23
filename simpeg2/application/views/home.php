<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>


<?php $landing = "pegawai/profile"; ?>
<?php echo form_open("pegawai/instant_search?landing=$landing"); ?>
<br>
<div class="container">
<div class="grid">
<div class="row">
<div class="span12">
<div class="input-control text">
	<input name="txtKeyword" type="text" placeholder="Cari pegawai (nama/NIP)" />
	<button class="button btn-search"></button>
</div>
<?php echo form_close(); ?>
</div>
</div>
</div>
<h1>
	Sistem Informasi Manajemen &<br> Pelayanan Kepegawaian<br>
	<small>Badan Kepegawaian, dan Pengembangan Sumberdaya Aparatur Kota Bogor</small>
</h1>

<div class="grid">
	<div class="row">
		<div class="span12">
	<div class="tile bg-darkPink">
		<a href="<?php echo base_url('unit_kerja/daftar') ?>">
		<div class="tile-content icon">
			<i class="icon-layers-alt"></i>
			</div>
			<div class="tile-status">
			<span class="name">Daftar OPD</span>
		</div>
		</a>
	</div>

	<div class="tile bg-darkRed">
		<a href="<?php echo base_url('pensiun') ?>">
		<div class="tile-content icon">
			<i class=" icon-accessibility"></i>
			</div>
			<div class="tile-status">
			<span class="name">Pensiun</span>
		</div>
		</a>
	</div>

	<div class="tile bg-darkOrange">
		<a href="<?php echo base_url('ib') ?>">
		<div class="tile-content icon">
			<i class="icon-bookmark-4"></i>
			</div>
			<div class="tile-status">
			<span class="name">Ijin Belajar</span>
		</div>
		</a>
	</div>

	<div class="tile bg-cyan">
		<a href="<?php echo base_url('kgb') ?>">
		<div class="tile-content icon">
			<i class="icon-dollar-2"></i>
			</div>
			<div class="tile-status">
			<span class="name">KGB</span>
		</div>
		</a>
	</div>

	<div class="tile bg-crimson">
		<a href="<?php echo base_url('hukuman_disiplin') ?>">
		<div class="tile-content icon">
			<i class=" icon-bell"></i>
			</div>
			<div class="tile-status">
			<span class="name">Hukuman Disiplin</span>
		</div>
		</a>
	</div>

	<div class="tile bg-yellow">
		<a href="<?php echo base_url('inpassing/jfu') ?>">
		<div class="tile-content icon">
			<i class=" icon-bell"></i>
			</div>
			<div class="tile-status">
			<span class="name">Inpassing JFU</span>
		</div>
		</a>
	</div>

	<div class="tile bg-darkIndigo">
		<a href="<?php echo base_url('alih_tugas') ?>">
		<div class="tile-content icon">
			<i class=" icon-tab"></i>
			</div>
			<div class="tile-status">
			<span class="name">Alih Tugas</span>
		</div>
		</a>
	</div>

	<div class="tile bg-olive">
		<a href="<?php echo base_url('jabatan_struktural') ?>">
		<div class="tile-content icon">
			<i class=" icon-user-3"></i>
			</div>
			<div class="tile-status">
			<span class="name">Jabatan Struktural</span>
		</div>
		</a>
	</div>

	<div class="tile bg-lightGreen">
		<a target="_blank" href="http://192.168.1.2:9945/alih_tugas">
		<div class="tile-content icon">
			<i class=" icon-user-3"></i>
			</div>
			<div class="tile-status">
			<span class="name">Alih Tugas JFU</span>
		</div>
		</a>
	</div>

	<div class="tile bg-taupe">
		<a href="<?php echo base_url('unit_kerja/daftar_kp') ?>">
		<div class="tile-content icon">
			<i class=" icon-clubs"></i>
			</div>
			<div class="tile-status">
			<span class="name">Kenaikan Pangkat</span>
		</div>
		</a>
	</div>

	<div class="tile bg-green">
		<a href="<?php echo base_url('cuti_pegawai') ?>">
		<div class="tile-content icon">
			<i class="  icon-cloudy"></i>
			</div>
			<div class="tile-status">
			<span class="name">Cuti</span>
		</div>
		</a>
	</div>

	<div class="tile bg-yellow">
		<a href="<?php echo base_url('card') ?>">
		<div class="tile-content icon">
			<i class="  icon-cloudy"></i>
			</div>
			<div class="tile-status">
			<span class="name">ID Card</span>
		</div>
		</a>
	</div>

	<div class="tile bg-darkGreen">
		<a href="<?php echo base_url('diklat').'/index' ?>">
			<div class="tile-content icon">
				<i class="icon-user-2"></i>
			</div>
			<div class="tile-status">
				<span class="name">Pengembangan Komptensi</span>
			</div>
		</a>
	</div>

	<div class="tile bg-darkPink">
		<a href="<?php echo base_url('report_absensi') ?>">
			<div class="tile-content icon">
				<i class="icon-file"></i>
			</div>
			<div class="tile-status">
				<span class="name">Report Absensi</span>
			</div>
		</a>
	</div>

	<div class="tile bg-darkBlue">
		<a href="<?php echo base_url('skp') ?>">
			<div class="tile-content icon">
				<i class="icon-file"></i>
			</div>
			<div class="tile-status">
				<span class="name">Pengaturan SKP</span>
			</div>
		</a>
	</div>

	<div class="tile bg-darkRed">
		<a href="<?php echo base_url('ptk') ?>">
			<div class="tile-content icon">
				<i class="icon-coins"></i>
			</div>
			<div class="tile-status">
				<span class="name">Pengajuan PTK</span>
			</div>
		</a>
	</div>
	<div class="tile bg-gray">
		<a href="<?php echo base_url('signer') ?>">
			<div class="tile-content icon">
				<i class="icon-key"></i>
			</div>
			<div class="tile-status">
				<span class="name">DigiSign</span>
			</div>
		</a>
	</div>
	<div class="tile bg-darkGreen">
		<a href="<?php echo base_url('jabatan_struktural/draft_pelantikan') ?>">
			<div class="tile-content icon">
				<i class=" icon-tree-view"></i>
			</div>
			<div class="tile-status">
				<span class="name">Anjas Go Clear</span>
			</div>
		</a>
	</div>
</div>
</div>
</div>
<hr />
<div>
	<label>Powered by</label>
	<img src="<?php echo base_url('images/logo-bsre-1.png'); ?>" width="150" alt="" />
</div>
</div>
