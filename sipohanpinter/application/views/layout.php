<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en" style="height:100% "> <!--<![endif]-->

<!-- BEGIN HEAD-->
<head>
  <meta charset="UTF-8" />
  <title><?php echo $title ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
  <meta content="" name="description" />
  <meta content="" name="author" />
  <!--[if IE]>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <![endif]-->
  <!-- GLOBAL STYLES -->
  <!-- GLOBAL STYLES -->
<link href="//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" rel="stylesheet"/>
<!--link href="< ?php echo base_url('assets/metro/css/metro-all.css?ver=@@b-version') ?>" rel="stylesheet" -->
<link rel="stylesheet" href="https://cdn.metroui.org.ua/v4/css/metro-all.min.css">
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<!-- script src="< ?php echo base_url('vendor/components/jquery/jquery.min.js'); ?>"></script -->
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script sr="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>
<script src="https://cdn.metroui.org.ua/v4/js/metro.min.js" defer="defer"></script>
<script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>

</head>
<body class="bg-grayBlue">
  <br/>
<div class="container">
  <div class="window">
    <div class="window-caption">
        <span class="icon mif-spinner4"></span>
        <span class="title">Sipohanpinter</span>
        <div class="buttons">
            <span class="btn-min"></span>
            <span class="btn-max"></span>
            <span class="btn-close"></span>
        </div>
    </div>
    <div class="window-content p-2">
    <nav data-role="ribbonmenu">
    <ul class="tabs-holder">
      <li class="static"><a href="<?php echo base_url("Home") ?>">Home</a></li>
      <li class='<?php echo $this->uri->segment(1) == "disiplin" ? "active" : "" ?>'><a href="#section-data">Database</a></li>
       <li class='<?php echo $this->uri->segment(1) == "pemeriksaan" ? "active" : "" ?>'><a href="#section-hukdis">Pemeriksaan</a></li>
       <li class='<?php echo $this->uri->segment(1) == "bap" ? "active" : "" ?>'><a href="#section-hasil">BA Pemeriksaan</a></li>
       <li class='<?php echo $this->uri->segment(1) == "sk" ? "active" : "" ?>'><a href="#section-sk">Penjatuhan</a></li>
       <li class='<?php echo $this->uri->segment(1) == "wb" ? "active" : "" ?>'><a href="#section-wb">Pengaduan</a></li>
       <li><a href="#section-admin">Admin</a></li>
       <li class="disabled"><a href="#">Disabled</a></li>
       <li><a href="<?php echo site_url('login/do_logout') ?>">Log out</a></li>
    </ul>

    <div class="content-holder">
      <div class="section" id="section-data">
        <div class="group">
            <a class='ribbon-button' href="<?php echo base_url('disiplin') ?>" class="">
                    <span class="icon">
                        <i class="material-icons">format_align_justify</i>
                    </span>
                <span class="caption">Daftar Pegawai</span>
            </a>
            <span class="title">Database Hukuman Disiplin</span>
        </div>
      </div>

      <div class="section" id="section-hukdis">
        <div class="group">
            <a href="<?php echo base_url('pemeriksaan/dafrik') ?>" class="ribbon-button <?php echo $this->uri->segment(2) == "dafrik" ? "active" : "" ?>">
                    <span class="icon">
                        <i class="material-icons">inbox</i>
                    </span>
                <span class="caption">Daftar Pemeriksaan</span>
            </a>
            <span class="title">Pemeriksaan</span>
        </div>
        <div class="group">
            <a href="<?php echo base_url('pemeriksaan/panggilan') ?>" class="ribbon-button <?php echo $this->uri->segment(2) == "panggilan" ? "active" : "" ?>">
                    <span class="icon">
                        <i class="material-icons">create</i>
                    </span>
                <span class="caption">Panggilan</span>
            </a>
            <button class="ribbon-button">
                    <span class="icon">
                        <i class="material-icons">find_in_page</i>
                    </span>
                <span class="caption">Pemeriksaan</span>
            </button>
            <span class="title">Panggilan dan Pemeriksaan</span>
        </div>
      </div>
      <div class="section active" id="section-hasil">
        <div class="group">
                <a href="<?php echo base_url('bap/list') ?>" class="ribbon-button <?php echo $this->uri->segment(2) == "list" ? "active" : "" ?>">
                        <span class="icon">
                            <i class="material-icons">hearing</i>
                        </span>
                    <span class="caption">BAP</span>
                </a>
                <a href="<?php echo base_url('/sedang') ?>" class="ribbon-button <?php echo $this->uri->segment(2) == "sedang" ? "active" : "" ?>">
                        <span class="icon">
                            <i class="material-icons">highlight_off</i>
                        </span>
                    <span class="caption">Laporan Tidak Kooperatif</span>
                </a>
                <a href="<?php echo base_url('/sedang') ?>" class="ribbon-button <?php echo $this->uri->segment(2) == "sedang" ? "active" : "" ?>">
                        <span class="icon">
                            <i class="material-icons">done_all</i>
                        </span>
                    <span class="caption">Laporan Kooperatif</span>
                </a>
                <span class="title">Berita Acara Pemeriksaan</span>
            </div>
      </div>
      <div class="section active" id="section-sk">
        <div class="group">
            <a href="<?php echo base_url('sk/sk_list') ?>" class="ribbon-button <?php echo $this->uri->segment(2) == "sk_list" ? "active" : "" ?>">
                    <span class="icon">
                        <i class="material-icons">subject</i>
                    </span>
                <span class="caption">Daftar Penjatuhan</span>
            </a>
            <span class="title">Daftar Penjatuhan</span>
        </div>
        <div class="group">
            <a href="<?php echo base_url('sk/ringan') ?>" class="ribbon-button <?php echo $this->uri->segment(2) == "ringan" ? "active" : "" ?>">
                    <span class="icon">
                        <i class="material-icons">mood_bad</i>
                    </span>
                <span class="caption">Teguran Lisan</span>
            </a>
            <a href="<?php echo base_url('sk/sedang') ?>" class="ribbon-button <?php echo $this->uri->segment(2) == "sedang" ? "active" : "" ?>">
                    <span class="icon">
                        <i class="material-icons">sentiment_dissatisfied</i>
                    </span>
                <span class="caption">Teguran Tertulis</span>
            </a>
            <a href="<?php echo base_url('sk/sedang') ?>" class="ribbon-button <?php echo $this->uri->segment(2) == "sedang" ? "active" : "" ?>">
                    <span class="icon">
                        <i class="material-icons">sentiment_very_dissatisfied</i>
                    </span>
                <span class="caption">Pernyataan Tidak Puas</span>
            </a>
            <span class="title">SK Hukuman Disiplin Tingkat Ringan</span>
        </div>
        <div class="group">
            <a href="<?php echo base_url('sk/sedang') ?>" class="ribbon-button <?php echo $this->uri->segment(2) == "ringan" ? "active" : "" ?>">
                    <span class="icon">
                        <i class="material-icons">not_interested</i>
                    </span>
                <span class="caption">Penundaan KGB</span>
            </a>
            <a href="<?php echo base_url('sk/sedang') ?>" class="ribbon-button <?php echo $this->uri->segment(2) == "sedang" ? "active" : "" ?>">
                    <span class="icon">
                        <i class="material-icons">warning</i>
                    </span>
                <span class="caption">Penundaan KP</span>
            </a>
            <a href="<?php echo base_url('sk/sedang') ?>" class="ribbon-button <?php echo $this->uri->segment(2) == "sedang" ? "active" : "" ?>">
                    <span class="icon">
                        <i class="material-icons">get_app</i>
                    </span>
                <span class="caption">Penurunan Pangkat</span>
            </a>
            <span class="title">SK Hukuman Disiplin Tingkat Sedang</span>
        </div>
        <div class="group">
            <a href="<?php echo base_url('sk/berat') ?>" class="ribbon-button <?php echo $this->uri->segment(2) == "ringan" ? "active" : "" ?>">
                    <span class="icon">
                        <i class="material-icons">play_for_work</i>
                    </span>
                <span class="caption">Penurunan Pangkat</span>
            </a>
            <a href="<?php echo base_url('sk/berat') ?>" class="ribbon-button <?php echo $this->uri->segment(2) == "sedang" ? "active" : "" ?>">
                    <span class="icon">
                        <i class="material-icons">swap_vertical_circle</i>
                    </span>
                <span class="caption">Pemindahan dalam rangka<br/> turun jabatan</span>
            </a>
            <a href="<?php echo base_url('sk/berat') ?>" class="ribbon-button <?php echo $this->uri->segment(2) == "sedang" ? "active" : "" ?>">
                    <span class="icon">
                        <i class="material-icons">system_update_alt </i>
                    </span>
                <span class="caption">Pembebasan dari jabatan</span>
            </a>
            <a href="<?php echo base_url('sk/berat') ?>" class="ribbon-button <?php echo $this->uri->segment(2) == "sedang" ? "active" : "" ?>">
                    <span class="icon">
                        <i class="material-icons">gavel</i>
                    </span>
                <span class="caption">Pemberhentian</span>
            </a>
            <span class="title">SK Hukuman Disiplin Tingkat Berat</span>
        </div>
      </div>
      <div class="section active" id="section-admin">
        <div class="group">
                <button class="ribbon-button">
                        <span class="icon">
                            <i class="material-icons">inbox</i>
                        </span>
                    <span class="caption">Daftar Pemeriksaan</span>
                </button>
                <span class="title">Panggilan dan Pemeriksaan</span>
            </div>
        <div class="group">
              <button class="ribbon-button">
                      <span class="icon">
                          <i class="material-icons">people</i>
                      </span>
                  <span class="caption">Daftar Admin</span>
              </button>
              <button class="ribbon-button active">
                      <span class="icon">
                          <i class="material-icons">person_add</i>
                      </span>
                  <span class="caption">Tambah Admin</span>
              </button>
              <span class="title">Admin OPD</span>
          </div>
      </div>

      <div class="section active" id="section-wb">
        <div class="group">
                <a href="<?php echo base_url('wb/nu') ?>" class="ribbon-button <?php echo $this->uri->segment(2) == "nu" ? "active" : "" ?>">
                        <span class="icon">
                            <i class="material-icons">inbox</i>
                        </span>
                    <span class="caption">Pengaduan Baru</span>
                </a>
                <a href="<?php echo base_url('wb/lizt') ?>" class="ribbon-button <?php echo $this->uri->segment(2) == "lizt" ? "active" : "" ?>">
                        <span class="icon">
                            <i class="material-icons">people</i>
                        </span>
                    <span class="caption">Daftar Pengaduan</span>
                </a>
                <span class="title">Whistleblowing</span>
            </div>
      </div>
    </div>
</nav>

  </div>
</div>
<div class="content bg-white">
  <p class="p-4"><?php isset($page) ? $this->load->view($page) : "Halaman tidak ditemukan"; ?> </p>
</div>
</div>

</body>
</html>
