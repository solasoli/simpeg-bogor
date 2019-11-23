<div class="panel-content" data-role="panel"
     data-title-caption="Laporan Kinerja Pegawai"
     data-title-icon=""
     data-cls-title=" fg-black">
    <div class="row" style="margin-top: 10px;">
        <div class="cell-sm-3">
            <select id="ddBln" name="ddBln" data-role="select" class="cell-sm-12">
                <option value="0">Semua Bulan</option>
                <option value="1">Januari</option>
                <option value="2">Februari</option>
                <option value="3">Maret</option>
                <option value="4">April</option>
                <option value="5">Mei</option>
                <option value="6">Juni</option>
                <option value="7">Juli</option>
                <option value="8">Agustus</option>
                <option value="9">September</option>
                <option value="10">Oktober</option>
                <option value="11">Nopember</option>
                <option value="12">Desember</option>
            </select>
        </div>
        <div class="cell-sm-3">
            <select id="ddTahun" name="ddTahun" data-role="select" class="cell-sm-12">
                <option value="0">Semua Tahun</option>
                <option value="2018">2018</option>
                <option value="2019">2019</option>
                <option value="2020">2020</option>
                <option value="2021">2021</option>
                <option value="2022">2022</option>
                <option value="2023">2023</option>
            </select>
        </div>
        <div class="cell-sm-3">
            <button id="btnFilter" name="btnFilter" onclick="" type="button" class="button primary bg-grayBlue">
                <span class="mif-search icon"></span> Tampilkan</button>
        </div>
    </div>
    <div class="row">
        <div class="cell-sm-12">
            <div id="dvListData"></div>
        </div>
    </div>
</div>

<script>
    loadDefaultDaftarKinerja();

    function loadDefaultDaftarKinerja(){
        $("select#ddBln option").each(function() { this.selected = (this.text == 0); });
        $("select#ddTahun option").each(function() { this.selected = (this.text == 0); });
        loadDataDaftarKinerja(0,0,'','');
    }

    function loadDataDaftarKinerja(ddBln,ddTahun,page,ipp){
        $("#btnFilter").css("pointer-events", "none");
        $("#btnFilter").css("opacity", "0.4");
        $("#dvListData").css("pointer-events", "none");
        $("#dvListData").css("opacity", "0.4");

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
                data.append('ddTahun', ddTahun);
                data.append('page', page);
                data.append('ipp', ipp);
                return $.ajax({
                    url: "<?php echo base_url('publicpegawai')."/drop_data_laporan_kinerja_pegawai/";?>",
                    data: data,
                    cache: false,
                    contentType: false,
                    processData: false,
                    method: 'POST',
                }).done(function (data) {
                    $("#dvListData").html(data);
                    $("#btnFilter").css("pointer-events", "auto");
                    $("#btnFilter").css("opacity", "1");
                    $("#dvListData").css("pointer-events", "auto");
                    $("#dvListData").css("opacity", "1");
                    $("#dvListData").find("script").each(function(i) {
                        eval($(this).text());
                    });
                }).fail(function(){
                    $("#dvListData").html('Error...telah terjadi kesalahan');
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
        var ddTahun = $('#ddTahun').val();
        loadDataDaftarKinerja(ddBln,ddTahun,'','');
    });

    function pagingViewListLoad(parm,parm2){
        var ddBln = $('#ddBln').val();
        var ddTahun = $('#ddTahun').val();
        loadDataDaftarKinerja(ddBln,ddTahun,parm,parm2);
    }
</script>