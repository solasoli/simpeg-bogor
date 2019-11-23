<p/>
<div class="container">
<div class="tab-control" data-role="tab-control">
    <ul class="tabs">
        <li class="active"><a href="#_page_1">Sertifikat</a></li>
        <li><a href="#_page_2">Spesimen</a></li>
        <li><a href="#_page_3"><i class="icon-rocket"></i></a></li>
        <li class="place-right"><a href="#_page_4"><i class="icon-cog"></i></a></li>
    </ul>

    <div class="frames">
        <div class="frame" id="_page_1"><?php $this->load->view('signer/setting_sertifikat') ?></div>
        <div class="frame" id="_page_2"><?php $this->load->view('signer/setting_spesimen') ?></div>
        <div class="frame" id="_page_3">...</div>
    </div>
</div>
</div>
