
<div class="panel-content" data-role="panel"
     data-title-caption=""
     data-title-icon=""
     data-cls-title="bg-steel fg-white">
    <?php
        //echo $this->session->userdata('id_pegawai_enc');
        //echo $this->session->userdata('id_skpd_enc');
    ?>
    <div class="row">
        <div class="cell-sm-4">
            <input type="text" id="keywordCari" name="keywordCari" class="cell-sm-12" placeholder="Kata Kunci NIP / Nama">
        </div>
        <div class="cell-sm-8">
            <button id="btnFilter" name="btnFilter" onclick="" type="button" class="button primary bg-grayBlue">
                <span class="mif-search icon"></span> Tampilkan</button>
        </div>
    </div>
    <div id="divListPegTipeLokasi"></div>
</div>

<script type="text/javascript">
    loadDefaultListTipeLokasi();

    function loadDefaultListTipeLokasi(){
        $('#keywordCari').val("");
        loadDataListTipeLokasi('','','');
    }

    function loadDataListTipeLokasi(keywordCari,page,ipp){
        $("#btnFilter").css("pointer-events", "none");
        $("#btnFilter").css("opacity", "0.4");
        $("#divListPegTipeLokasi").css("pointer-events", "none");
        $("#divListPegTipeLokasi").css("opacity", "0.4");

        var jc = $.confirm({
            title: '',
            closeIconClass: 'fa fa-close',
            closeIcon: null,
            closeIconClass: false,
            boxWidth: '200px',
            useBootstrap: false,
            content: function () {
                var data = new FormData();
                data.append('keywordCari', keywordCari);
                data.append('page', page);
                data.append('ipp', ipp);
                return $.ajax({
                    url: "<?php echo base_url($usr)."/drop_data_tipe_lokasi_kerja_pegawai/";?>",
                    data: data,
                    cache: false,
                    contentType: false,
                    processData: false,
                    method: 'POST',
                }).done(function (data) {
                    $("#divListPegTipeLokasi").html(data);
                    $("#btnFilter").css("pointer-events", "auto");
                    $("#btnFilter").css("opacity", "1");
                    $("#divListPegTipeLokasi").css("pointer-events", "auto");
                    $("#divListPegTipeLokasi").css("opacity", "1");
                    $("#divListPegTipeLokasi").find("script").each(function(i) {
                        eval($(this).text());
                    });
                }).fail(function(){
                    $("#divListAktifitas").html('Error...telah terjadi kesalahan');
                });
            },
            onContentReady: function () {
                jc.close();
            },
            buttons: {
                refreshList: {
                    text: '.',
                    action: function () {}
                }
            }
        });
    }

    $("#btnFilter").click(function(){
        var keywordCari = $("#keywordCari").val();
        loadDataListTipeLokasi(keywordCari,'','');
    });

    function pagingViewListLoad(parm,parm2){
        var keywordCari = $("#keywordCari").val();
        loadDataListTipeLokasi(keywordCari,parm,parm2);
    }

</script>
