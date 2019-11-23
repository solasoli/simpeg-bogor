<h2 style="margin-left: 20px;">DigiSign<small>Tandatangan Elektronik</small></h2>

<div class="row" style="border-top: solid 1px rgba(46, 46, 46, 0.8);border-bottom: solid 1px rgba(46, 46, 46, 0.8);">
    <nav class="horizontal-menu compact">
        <ul>
            <li style="border: solid 1px rgba(46, 46, 46, 0.8);<?php if($this->uri->segment(2) == 'index' || $this->uri->segment(2) == null ): ?>background-color: #5bb75b;color: #eeeeee;<?php endif; ?>"><?php echo anchor("signer", "Inbox"); ?></li>
            <li style="border: solid 1px rgba(46, 46, 46, 0.8);<?php if($this->uri->segment(2) == 'doc_baru'): ?>background-color: #5bb75b;color: #eeeeee;<?php endif; ?>"><?php echo anchor("signer/doc_baru", "Upload Dokumen Baru"); ?></li>
            <li style="border: solid 1px rgba(46, 46, 46, 0.8);<?php if($this->uri->segment(2) == 'signed'): ?>background-color: #5bb75b;color: #eeeeee;<?php endif; ?>"><?php echo anchor("signer/signed", "Dokumen Telah ditandatangan"); ?></li>
            <li style="border: solid 1px rgba(46, 46, 46, 0.8);<?php if($this->uri->segment(2) == 'setting'): ?>background-color: #5bb75b;color: #eeeeee;<?php endif; ?>"><?php echo anchor("signer/setting", "Pengaturan"); ?></li>

        </ul>
    </nav>
</div>
