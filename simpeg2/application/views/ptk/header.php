<h2 style="margin-left: 20px;">ADMINISTRASI PENGUBAHAN TUNJANGAN KELUARGA (PTK)</h2>

<div class="row" style="border-top: solid 1px rgba(46, 46, 46, 0.8);border-bottom: solid 1px rgba(46, 46, 46, 0.8);">
    <nav class="horizontal-menu compact">
        <ul>
            <li style="border: solid 1px rgba(46, 46, 46, 0.8);<?php if($idproses == 0): ?>background-color: #5bb75b;color: #eeeeee;<?php endif; ?>"><?php echo anchor("ptk", "Rekapitulasi Data"); ?></li>
            <li style="border: solid 1px rgba(46, 46, 46, 0.8);<?php if($idproses == 1): ?>background-color: #5bb75b;color: #eeeeee;<?php endif; ?>"><?php echo anchor("ptk/list_pengajuan_ptk/1", "Dalam Proses Pegawai YBS"); ?></li>
            <li style="border: solid 1px rgba(46, 46, 46, 0.8);<?php if($idproses == 2): ?>background-color: #5bb75b;color: #eeeeee;<?php endif; ?>"><?php echo anchor("ptk/list_pengajuan_ptk/2", "Dalam Proses BKPSDA"); ?></li>
            <li style="border: solid 1px rgba(46, 46, 46, 0.8);<?php if($idproses == 3): ?>background-color: #5bb75b;color: #eeeeee;<?php endif; ?>"><?php echo anchor("ptk/list_pengajuan_ptk/3", "Permohonan Disetujui"); ?></li>
            <li style="border: solid 1px rgba(46, 46, 46, 0.8);<?php if($idproses == 6): ?>background-color: #5bb75b;color: #eeeeee;<?php endif; ?>"><?php echo anchor("ptk/list_pengajuan_ptk/6", "Surat ke BPKAD Terbit"); ?></li>
            <li style="border: solid 1px rgba(46, 46, 46, 0.8);<?php if($idproses == 4): ?>background-color: #5bb75b;color: #eeeeee;<?php endif; ?>"><?php echo anchor("ptk/list_pengajuan_ptk/4", "Ditolak & Hanya Informasi"); ?></li>
            <li style="border: solid 1px rgba(46, 46, 46, 0.8);<?php if($idproses == 5): ?>background-color: #5bb75b;color: #eeeeee;<?php endif; ?>"><?php echo anchor("ptk/list_pengajuan_ptk/5", "Dibatalkan"); ?></li>
        </ul>
    </nav>
</div>