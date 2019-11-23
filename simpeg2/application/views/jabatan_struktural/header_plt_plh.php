<h2 style="margin-left: 20px;">MANAJEMEN DATA JABATAN PLT DAN PLH</h2>

<div class="row" style="border-top: solid 1px rgba(46, 46, 46, 0.8);border-bottom: solid 1px rgba(46, 46, 46, 0.8);">
    <nav class="horizontal-menu compact">
        <ul>
            <li style="border: solid 1px rgba(46, 46, 46, 0.8);<?php if($idproses == 1): ?>background-color: #5bb75b;color: #eeeeee;<?php endif; ?>"><?php echo anchor("jabatan_struktural/list_jabatan_plt", "Daftar Jabatan PLT"); ?></li>
            <li style="border: solid 1px rgba(46, 46, 46, 0.8);<?php if($idproses == 2): ?>background-color: #5bb75b;color: #eeeeee;<?php endif; ?>"><?php echo anchor("jabatan_struktural/list_jabatan_plh", "Daftar Jabatan PLH"); ?></li>
        </ul>
    </nav>
</div>