<h2 style="margin-left: 20px;">REPORT ABSENSI PEGAWAI</h2>
<div class="row" style="border-top: solid 1px rgba(46, 46, 46, 0.8);border-bottom: solid 1px rgba(46, 46, 46, 0.8);">
    <nav class="horizontal-menu compact">
        <ul>
            <li style="border: solid 1px rgba(46, 46, 46, 0.8);<?php if($idproses == 0): ?>background-color: #5bb75b;color: #eeeeee;<?php endif; ?>"><?php echo anchor("report_absensi/list_report_absensi", "Daftar Absensi"); ?></li>
            <li style="border: solid 1px rgba(46, 46, 46, 0.8);<?php if($idproses == 1): ?>background-color: #5bb75b;color: #eeeeee;<?php endif; ?>"><?php echo anchor("report_absensi/rekap_jumlah_opd", "Rekapitulasi Jumlah Per OPD"); ?>
            <li style="border: solid 1px rgba(46, 46, 46, 0.8);<?php if($idproses == 2): ?>background-color: #5bb75b;color: #eeeeee;<?php endif; ?>"><?php echo anchor("report_absensi/rekap_list_opd", "Rekapitulasi List Pegawai Per OPD"); ?>

            <!--<li style="border: solid 1px rgba(46, 46, 46, 0.8);<?php //if($idproses == 1): ?>background-color: #5bb75b;color: #eeeeee;<?php //endif; ?>"><?php //echo anchor("report_absensi/profil_absensi", "Profil Absensi"); ?></li>
            <li style="border: solid 1px rgba(46, 46, 46, 0.8);<?php //if($idproses == 2): ?>background-color: #5bb75b;color: #eeeeee;<?php //endif; ?>"><?php //echo anchor("report_absensi/rekapitulasi_bulanan", "Rekapitulasi Bulanan"); ?></li>
            <li style="border: solid 1px rgba(46, 46, 46, 0.8);<?php //if($idproses == 3): ?>background-color: #5bb75b;color: #eeeeee;<?php //endif; ?>"><?php //echo anchor("report_absensi/rekapitulasi_pegawai", "Rekapitulasi Pegawai"); ?></li>-->
        </ul>
    </nav>
</div>