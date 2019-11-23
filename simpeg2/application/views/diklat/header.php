<h2 style="margin-left: 20px;">MANAJEMEN DATA PENDIDIKAN DAN PENGEMBANGAN SUMBER DAYA APARATUR</h2>

<div class="row" style="border-top: solid 1px rgba(46, 46, 46, 0.8);border-bottom: solid 1px rgba(46, 46, 46, 0.8);">
    <nav class="horizontal-menu compact">
        <ul>
            <li style="border: solid 1px rgba(46, 46, 46, 0.8);<?php if($idproses == 0): ?>background-color: #5bb75b;color: #eeeeee;<?php endif; ?>"><?php echo anchor("diklat/index", "Rekapitulasi Data"); ?></li>
            <li style="border: solid 1px rgba(46, 46, 46, 0.8);<?php if($idproses == 1): ?>background-color: #5bb75b;color: #eeeeee;<?php endif; ?>"><?php echo anchor("diklat/list_data_diklat", "Daftar Kegiatan Diklat"); ?></li>
            <li style="border: solid 1px rgba(46, 46, 46, 0.8);<?php if($idproses == 2): ?>background-color: #5bb75b;color: #eeeeee;<?php endif; ?>"><?php echo anchor("diklat/status_diklat_pejabat", "Status Diklat Pejabat Struktural"); ?></li>
            <li style="border: solid 1px rgba(46, 46, 46, 0.8);<?php if($idproses == 3): ?>background-color: #5bb75b;color: #eeeeee;<?php endif; ?>"><?php echo anchor("diklat/list_kebutuhan_diklat", "Usulan dari OPD"); ?></li>
            <li style="border: solid 1px rgba(46, 46, 46, 0.8);<?php if($idproses == 5): ?>background-color: #5bb75b;color: #eeeeee;<?php endif; ?>"><?php echo anchor("diklat/penyusunan_kompetensi", "Pengembangan Kompetensi"); ?></li>
            <li style="border: solid 1px rgba(46, 46, 46, 0.8);<?php if($idproses == 4): ?>background-color: #5bb75b;color: #eeeeee;<?php endif; ?>"><?php echo anchor("diklat/list_penyusunan_diklat", "Penyusunan Sprint oleh BKPSDA"); ?></li>
            <li style="border: solid 1px rgba(46, 46, 46, 0.8);<?php if($idproses == 6): ?>background-color: #5bb75b;color: #eeeeee;<?php endif; ?>"><?php echo anchor("diklat/list_proper", "Daftar Proper"); ?></li>
        </ul>
    </nav>
</div>