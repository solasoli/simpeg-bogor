
<div class="row" style="border-top: solid 1px rgba(46, 46, 46, 0.8);border-bottom: solid 1px rgba(46, 46, 46, 0.8);">
    <nav class="horizontal-menu compact">
        <ul>
            <li style="border: solid 1px rgba(46, 46, 46, 0.8);<?php if($idproses == 0): ?>background-color: #5bb75b;color: #eeeeee;<?php endif; ?>"><?php echo anchor("ipasn", "Input Kesesuaian"); ?></li>
            <li style="border: solid 1px rgba(46, 46, 46, 0.8);<?php if($idproses == 1): ?>background-color: #5bb75b;color: #eeeeee;<?php endif; ?>"><?php echo anchor("ipasn/list_report_ipp", "Output Laporan IPP"); ?></li>
        </ul>
    </nav>
</div>