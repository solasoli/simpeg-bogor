<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php $landing = "pegawai/profile"; ?>
<?php echo form_open("pegawai/instant_search?landing=$landing"); ?>
<div class="container-fluid">
<div class="input-control text">
	<input name="txtKeyword" type="text" placeholder="Cari pegawai (nama/NIP)" />
	<button class="button btn-search"></button>
</div>
<?php echo form_close(); ?>

<div class="grid fluid">
	<div class="row">
		<div class="span2">
			<div class="row">
				<div class="span10 offset1 image-container">
					<img alt="<?php echo $pegawai->nama ?>" src="http://103.14.229.15/simpeg/foto/<?php echo $pegawai->id_pegawai ?>.jpg"/>
				</div>
			</div>
			<div class="row">
				<!--div class="span10 offset1"><?php //echo anchor('#',"cetak skum",array('class'=>"button info"))?></div-->
				<div class="span12 offset1">
					<nav class="sidebar light">
						<ul>
							<li class="title">Menu</li>
							<li><a target="_blank" href="<?php echo base_url('pegawai/drh/'.$pegawai->id_pegawai) ?>">Cetak Profil PNS</a></li>
							<li><a target="_blank" href="<?php echo base_url('pdf/skum_pdf/index/'.$pegawai->id_pegawai) ?>">Cetak SKUM-PTK</a></li>
                        </ul>
					</nav>
				</div>
			</div>
		</div>
		<div class="span10">			
			<h1><?php echo $this->pegawai->get_by_id($this->uri->segment(3))->nama ?></h1>
			<div class="content--">
				<div class="tab-control"data-role="tab-control" data-effect="fade[slide]">
					<ul class="tabs">
						<li class="active"><a href="#_biodata">Biodata</a></li>
						<li><a href="#_daftar_keluarga">Daftar Keluarga</a></li>
						<li><a href="#_riwayat_pendidikan">Pendidikan</a></li>
						<li><a href="#_riwayat_pangkat">Kepangkatan</a></li>
						<li><a href="#_riwayat_jabatan">Jabatan</a></li>
                        <li><a href="#_riwayat_diklat">Pengembangan Kompetensi</a></li>
                        <li><a href="#_riwayat_skp">SKP</a></li>
                        <li><a href="#_std_kompetensi">Standar Kompetensi</a></li>
					</ul>
					<div class="frames">
						<div class="frame" class="active" id="_biodata">
							<?php $this->load->view('pegawai/biodata') ?>
						</div>
						<div class="frame" id="_daftar_keluarga">
							<?php $this->load->view('pegawai/riwayat_keluarga') ?>
						</div>
						<div class="frame" id="_riwayat_pendidikan">
							<?php $this->load->view('pegawai/riwayat_pendidikan') ?>
						</div>
						<div class="frame" id="_riwayat_pangkat">
							<?php $this->load->view('pegawai/riwayat_pangkat') ?>
						</div>
						<div class="frame" id="_riwayat_jabatan">
                            <?php $this->load->view('pegawai/riwayat_jabatan') ?>
                        </div>
                        <div class="frame" id="_riwayat_diklat">
                            <?php $this->load->view('pegawai/riwayat_diklat') ?>
                        </div>
                        <div class="frame" id="_riwayat_skp">
                            <?php $this->load->view('pegawai/riwayat_skp') ?>
                        </div>
                        <div class="frame" id="_std_kompetensi">
                            <?php $this->load->view('pegawai/std_kompetensi') ?>
                        </div>
					</div><!-- end frames-->
				</div>
			</div>			
		</div>
	</div>
</div>

