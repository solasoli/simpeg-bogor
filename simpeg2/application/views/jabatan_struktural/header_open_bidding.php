<h2 style="margin-left: 20px;">MANAJEMEN DATA OPEN BIDDING</h2>

<div class="row" style="border-top: solid 1px rgba(46, 46, 46, 0.8);border-bottom: solid 1px rgba(46, 46, 46, 0.8);">
    <nav class="horizontal-menu compact">
        <ul>
            <li style="border: solid 1px rgba(46, 46, 46, 0.8);<?php if($idproses == 1): ?>background-color: #5bb75b;color: #eeeeee;<?php endif; ?>"><?php echo anchor("jabatan_struktural/list_open_bidding", "Daftar Open Bidding"); ?></li>
            <li style="border: solid 1px rgba(46, 46, 46, 0.8);<?php if($idproses == 2): ?>background-color: #5bb75b;color: #eeeeee;<?php endif; ?>"><?php echo anchor("jabatan_struktural/add_open_bidding", "Tambah Data"); ?></li>
        </ul>
    </nav>
</div>