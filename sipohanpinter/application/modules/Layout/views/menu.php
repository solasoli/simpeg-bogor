<nav class="navview-pane">
    <button class="pull-button">
        <span class="mif-menu"></span>
    </button>

    <ul class="navview-menu h-200">


        <hr class="bg-red">
        <?php if($this->session->userdata('user_id') === "11431" || $this->session->userdata('user_id') === '11301'): ?>
          <li class="item-header">Wistle Blower</li>
        <li>
            <a href="<?php echo site_url('Pengaduan/lizt') ?>">
                <span class="icon"><span class="mif-user-secret"></span></span>
                <span class="caption">Daftar Pengaduan</span>
            </a>
        </li>
      <?php endif; ?>
        <li>
            <a href="<?php echo site_url('Pengaduan') ?>">
                <span class="icon"><span class="mif-user-secret"></span></span>
                <span class="caption">Pengaduan Baru</span>
            </a>
        </li>
        <li class="item-separator"></li>
          <li class="item-header">Sipohan Pinter</li>
        <li>
            <a href="<?php echo site_url('Sipohan/lizt') ?>">
                <span class="icon"><span class="mif-justice"></span></span>
                <span class="caption">Daftar Penjatuhan</span>
            </a>
        </li>
        <li>
            <a href="<?php echo site_url('Sipohan/panggilan') ?>">
                <span class="icon"><span class="mif-zoom-in"></span></span>
                <span class="caption">Daftar Pemeriksaan</span>
            </a>
        </li>
        <li>
            <a href="<?php echo site_url('Sipohan/panggilan_add') ?>">
                <span class="icon"><span class="mif-drafts"></span></span>
                <span class="caption">Buat Pemeriksaan</span>
            </a>
        </li>
        <li class="item-header active">Sasaran Kerja Pegawai</li>
        <li>
            <a href="<?php echo site_url('skp') ?>">
                <span class="icon"><span class="mif-key"></span></span>
                <span class="caption">Daftar Sasaran Kerja</span>
            </a>
        </li>
        <li class="item-header active">Pengaturan</li>

        <li>
            <a href="<?php echo site_url('Sipohanadmin/pasal_pelanggaran') ?>">
                <span class="icon"><span class="mif-key"></span></span>
                <span class="caption">Pasal Pelanggaran</span>
            </a>
        </li>

        <li class="item-separator"></li>

        <li>
            <a href="<?php echo site_url('Welcome/out') ?>">
                <span class="icon"><span class="mif-exit"></span></span>
                <span class="caption">LOG OUT</span>
            </a>
        </li>
        <li class="item-separator"></li>
    </ul>

</nav>
