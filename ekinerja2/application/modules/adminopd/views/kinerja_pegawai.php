
<div class="panel-content" data-role="panel"
     data-title-caption=""
     data-title-icon=""
     data-cls-title="bg-steel fg-white">
    <?php //echo $this->session->userdata('id_skpd_enc'); ?>
    <div class="row">
        <div class="cell-sm-4">
            <input type="text" id="keywordCari" name="keywordCari" class="cell-sm-12" placeholder="Kata Kunci NIP / Nama">
        </div>
        <div class="cell-sm-4">
            <select id="ddStsLastPeriode" name="ddStsLastPeriode" data-role="select" class="cell-sm-12">
                <option value="Semua">Semua status laporan</option>
                <option value="Ada">Laporan bulan berjalan ada</option>
                <option value="Tidak Ada">Laporan bulan berjalan tidak ada</option>
            </select>
        </div>
        <div class="cell-sm-4">
            <button id="btnFilter" name="btnFilter" onclick="" type="button" class="button primary bg-grayBlue">
                <span class="mif-search icon"></span> Tampilkan</button>
        </div>
    </div>
    <div id="divListPegInfoKinerja"></div>
</div>

<script type="text/javascript">
    loadDefaultListKinerjaPegawai();

    function loadDefaultListKinerjaPegawai(){
        $("select#ddStsLastPeriode option").each(function() { this.selected = (this.text == 0); });
        $('#keywordCari').val("");
        loadDataListKinerjaPegawai(0,'','','');
    }

    function loadDataListKinerjaPegawai(ddStsLastPeriode,keywordCari,page,ipp){
        $("#btnFilter").css("pointer-events", "none");
        $("#btnFilter").css("opacity", "0.4");
        $("#divListPegInfoKinerja").css("pointer-events", "none");
        $("#divListPegInfoKinerja").css("opacity", "0.4");

        var jc = $.confirm({
            title: '',
            closeIconClass: 'fa fa-close',
            closeIcon: null,
            closeIconClass: false,
            boxWidth: '200px',
            useBootstrap: false,
            content: function () {
                var data = new FormData();
                data.append('ddStsLastPeriode', ddStsLastPeriode);
                data.append('keywordCari', keywordCari);
                data.append('page', page);
                data.append('ipp', ipp);
                return $.ajax({
                    url: "<?php echo base_url($usr)."/drop_data_info_kinerja_pegawai/";?>",
                    data: data,
                    cache: false,
                    contentType: false,
                    processData: false,
                    method: 'POST',
                }).done(function (data) {
                    $("#divListPegInfoKinerja").html(data);
                    $("#btnFilter").css("pointer-events", "auto");
                    $("#btnFilter").css("opacity", "1");
                    $("#divListPegInfoKinerja").css("pointer-events", "auto");
                    $("#divListPegInfoKinerja").css("opacity", "1");
                    $("#divListPegInfoKinerja").find("script").each(function(i) {
                        eval($(this).text());
                    });
                }).fail(function(){
                    $("#divListPegInfoKinerja").html('Error...telah terjadi kesalahan');
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
        var ddStsLastPeriode = $('#ddStsLastPeriode').val();
        var keywordCari = $("#keywordCari").val();
        loadDataListKinerjaPegawai(ddStsLastPeriode,keywordCari,'','');
    });

    function pagingViewListLoad(parm,parm2){
        var ddStsLastPeriode = $('#ddStsLastPeriode').val();
        var keywordCari = $("#keywordCari").val();
        loadDataListKinerjaPegawai(ddStsLastPeriode,keywordCari,parm,parm2);
    }


</script>