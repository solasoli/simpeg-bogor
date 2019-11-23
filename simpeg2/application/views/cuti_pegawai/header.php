
<h2 style="margin-left: 20px;">ADMINISTRASI CUTI PEGAWAI</h2>
<div class="row" style="border-top: solid 1px rgba(46, 46, 46, 0.8);border-bottom: solid 1px rgba(46, 46, 46, 0.8);">
    <nav class="horizontal-menu compact">
        <ul>
            <li style="border: solid 1px rgba(46, 46, 46, 0.8);<?php if($idproses == 0): ?>background-color: #5bb75b;color: #eeeeee;<?php endif; ?>"><?php echo anchor("cuti_pegawai/list_pengajuan_cuti", "Dalam Proses Pegawai YBS"); ?></li>
            <li style="border: solid 1px rgba(46, 46, 46, 0.8);<?php if($idproses == 1): ?>background-color: #5bb75b;color: #eeeeee;<?php endif; ?>"><?php echo anchor("cuti_pegawai/list_pengajuan_cuti/1", "Dalam Proses Admin OPD"); ?></li>
            <li style="border: solid 1px rgba(46, 46, 46, 0.8);<?php if($idproses == 2): ?>background-color: #5bb75b;color: #eeeeee;<?php endif; ?>"><?php echo anchor("cuti_pegawai/list_pengajuan_cuti/2", "Dalam Proses BKPSDA"); ?></li>
            <li style="border: solid 1px rgba(46, 46, 46, 0.8); padding-right: 15px; <?php if($idproses == 3 or $idproses == 4 or $idproses == 5): ?>background-color: #5bb75b;color: #eeeeee;<?php endif; ?>">
                <a class="dropdown-toggle" href="#">Pemrosesan Selesai</a>
                <ul class="dropdown-menu" data-role="dropdown">
                    <li><?php echo anchor("cuti_pegawai/list_pengajuan_cuti/3", "Permohonan Disetujui"); ?></li>
                    <li><?php echo anchor("cuti_pegawai/list_pengajuan_cuti/4", "Permohonan Ditolak"); ?></li>
                    <li><?php echo anchor("cuti_pegawai/list_pengajuan_cuti/5", "Permohonan Dibatalkan"); ?></li>
                </ul>
            </li>
            <li style="border: solid 1px rgba(46, 46, 46, 0.8); padding-right: 15px; <?php if($idproses == 6 or $idproses == 7): ?>background-color: #5bb75b;color: #eeeeee;<?php endif; ?>">
                <a class="dropdown-toggle" href="#">Profiling</a>
                <ul class="dropdown-menu" data-role="dropdown">
                    <li><?php echo anchor("cuti_pegawai/rekap", "Rekapitulasi Data"); ?></li>
                    <li><?php echo anchor("cuti_pegawai/cek_historis", "Cek Historis Cuti"); ?></li>
                </ul>
            </li>
            <li style="border: solid 1px rgba(46, 46, 46, 0.8);<?php if($idproses == 8): ?>background-color: #5bb75b;color: #eeeeee;<?php endif; ?>"><?php echo anchor("cuti_pegawai/pengaturan", "Pengaturan"); ?></li>
            <li style="border: solid 1px rgba(46, 46, 46, 0.8);<?php if($idproses == 9): ?>background-color: #5bb75b;color: #eeeeee;<?php endif; ?>"><?php echo anchor("cuti_pegawai/entry_konvensional", "Input Usulan Offline"); ?></li>
        </ul>
    </nav>
</div>
<!--     <div class="navbar bg-crimson">
        <div class="navbar-content">
            <span class="pull-menu"></span>
            <ul class="element-menu">
                <li><?php //echo anchor("cuti_pegawai/list_pengajuan_cuti", "Dalam Proses Pegawai YBS |"); ?></li>
                <li><?php //echo anchor("cuti_pegawai/list_pengajuan_cuti/1", "Dalam Proses Admin SKPD |"); ?></li>
                <li><?php //echo anchor("cuti_pegawai/list_pengajuan_cuti/2", "Order Pemrosesan BKPP |"); ?></li>
                <li><?php //echo anchor("cuti_pegawai/list_pengajuan_cuti/3", "Permohonan Disetujui |"); ?></li>
                <li><?php //echo anchor("cuti_pegawai/list_pengajuan_cuti/4", "Ditolak |"); ?></li>
                <li><?php //echo anchor("cuti_pegawai/list_pengajuan_cuti/5", "Dibatalkan |"); ?></li>
                <li><?php //echo anchor("cuti_pegawai/rekap", "Rekapitulasi |"); ?></li>
                <li><?php //echo anchor("cuti_pegawai/pengaturan", "Pengaturan |"); ?></li>
                <li><?php //echo anchor("cuti_pegawai", "Cek Historis Cuti |"); ?></li>
            </ul>
        </div>
    </div> -->

<!--  End of file header.php -->
<!--  Location: ./application/views/cuti/header.php  -->
