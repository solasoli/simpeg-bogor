
<div class="panel-content" data-role="panel"
     data-title-caption=""
     data-title-icon=""
     data-cls-title="bg-steel fg-white">
    <div class="row">
        <div class="cell-sm-3">
            <select id="ddBln" name="ddBln" data-role="select" class="cell-sm-12">
                <option value="0">Semua Bulan</option>
                <?php
                $i = 0;
                for ($x = 0; $x <= 11; $x++) {
                    echo "<option value=".$listBln[$i][0].">".$listBln[$i][1]."</option>";
                    $i++;
                }
                ?>
            </select>
        </div>
        <div class="cell-sm-3">
            <select id="ddThn" name="ddThn" data-role="select" class="cell-sm-12">
                <option value="0">Semua Tahun</option>
                <?php
                $i = 0;
                for ($x = 0; $x < sizeof($listThn); $x++) {
                    echo "<option value=".$listThn[$i].">".$listThn[$i]."</option>";
                    $i++;
                }
                ?>
            </select>
        </div>
        <div class="cell-sm-3">
            <input type="text" id="keywordCari" name="keywordCari" class="cell-sm-12" placeholder="Kata Kunci">
        </div>
        <div class="cell-sm-3">
            <button id="btnFilter" name="btnFilter" onclick="" type="button" class="button primary bg-grayBlue">
                <span class="mif-search icon"></span> Tampilkan</button>
        </div>
    </div>
    <?php //echo $this->session->userdata('id_pegawai_enc'); ?>
    <div id="divListAktifitas"></div>
</div>

<script type="text/javascript">
    loadDefaultListAktifitas();

    function loadDefaultListAktifitas(){
        $("select#ddBln option").each(function() { this.selected = (this.text == 0); });
        $("select#ddThn option").each(function() { this.selected = (this.text == 0); });
        $('#keywordCari').val("");
        loadDataListAktifitas('0','0','','','');
    }

    function loadDataListAktifitas(ddBln,ddThn,keywordCari,page,ipp){
        $("#btnFilter").css("pointer-events", "none");
        $("#btnFilter").css("opacity", "0.4");
        $("#divListAktifitas").css("pointer-events", "none");
        $("#divListAktifitas").css("opacity", "0.4");
        var jc = $.confirm({
            title: '',
            closeIconClass: 'fa fa-close',
            closeIcon: null,
            closeIconClass: false,
            boxWidth: '200px',
            useBootstrap: false,
            content: function () {
                var data = new FormData();
                data.append('ddBln', ddBln);
                data.append('ddThn', ddThn);
                data.append('keywordCari', keywordCari);
                data.append('page', page);
                data.append('ipp', ipp);
                return $.ajax({
                    url: "<?php echo base_url($usr)."/drop_data_riwayat_aktifitas/";?>",
                    data: data,
                    cache: false,
                    contentType: false,
                    processData: false,
                    method: 'POST',
                }).done(function (data) {
                    $("#divListAktifitas").html(data);
                    $("#btnFilter").css("pointer-events", "auto");
                    $("#btnFilter").css("opacity", "1");
                    $("#divListAktifitas").css("pointer-events", "auto");
                    $("#divListAktifitas").css("opacity", "1");
                    $("#divListAktifitas").find("script").each(function(i) {
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
        var ddBln = $('#ddBln').val();
        var ddThn = $('#ddThn').val();
        var keywordCari = $("#keywordCari").val();
        loadDataListAktifitas(ddBln,ddThn,keywordCari,'','');
    });

    function pagingViewListLoad(parm,parm2){
        var ddBln = $('#ddBln').val();
        var ddThn = $('#ddThn').val();
        var keywordCari = $("#keywordCari").val();
        loadDataListAktifitas(ddBln,ddThn,keywordCari,parm,parm2);
    }

</script>