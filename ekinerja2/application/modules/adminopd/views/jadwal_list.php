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
</div>

<div class="row" style="margin-top: 5px;">
    <div class="cell-sm-3">
        <div style="margin-top: 10px;margin-left: 5px;">Pilih Pengelola OPD :</div>
    </div>
    <div class="cell-sm-4">
        <select id="ddInputer" name="ddInputer" class="cell-sm-12">
            <option value="0">Semua Pengelola OPD</option>
            <?php if ($list_inputer_jadwal!=NULL and sizeof($list_inputer_jadwal) > 0 and $list_inputer_jadwal != ''): ?>
                <?php foreach ($list_inputer_jadwal as $lsinp): ?>
                    <option value="<?php echo $lsinp->inputer_enc; ?>"><?php echo $lsinp->nama.' ('.$lsinp->nip_baru.') Jumlah: '.$lsinp->jumlah; ?> Jadwal</option>
                <?php endforeach; ?>
            <?php endif; ?>
        </select>
    </div>
    <div class="cell-sm-4">
        <label><input id="chkCekBerkasRil" name="chkCekBerkasRil" type="checkbox" data-role="checkbox" data-style="2">Cek keberadaan berkas</label>
    </div>
</div>

<div class="row" style="margin-top: 5px;">
    <div class="cell-sm-3">
        <button id="btnFilter" name="btnFilter" onclick="" type="button" class="button primary bg-grayBlue">
            <span class="mif-search icon"></span> Tampilkan</button>
    </div>
</div>

<div id="divListJadwal"></div>


<script>
    loadDefaultListJadwalKhusus();

    function loadDefaultListJadwalKhusus(){
        $("select#ddBln option").each(function() { this.selected = (this.text == 0); });
        $("select#ddThn option").each(function() { this.selected = (this.text == 0); });
        $("select#ddInputer option").each(function() { this.selected = (this.text == 0); });
        $('#keywordCari').val("");
        loadDataListJadwalKhususSpmt('0','0','0',false,'','','');
    }

    function loadDataListJadwalKhususSpmt(ddBln,ddThn,ddInputer,chkCekBerkasRil,keywordCari,page,ipp){
        $("#btnFilter").css("pointer-events", "none");
        $("#btnFilter").css("opacity", "0.4");
        $("#divListJadwal").css("pointer-events", "none");
        $("#divListJadwal").css("opacity", "0.4");

        var jc = $.confirm({
            title: '',
            closeIconClass: 'fa fa-close',
            closeIcon: null,
            closeIconClass: false,
            boxWidth: '200px',
            useBootstrap: false,
            content: function () {
                var data = new FormData();
                data.append('bln', ddBln);
                data.append('thn', ddThn);
                data.append('idp', ddInputer);
                data.append('keyword', keywordCari);
                data.append('chkCekBerkasRil', chkCekBerkasRil);
                data.append('page', page);
                data.append('ipp', ipp);
                return $.ajax({
                    url: "<?php echo base_url('adminopd')."/drop_data_list_jadwal_khusus_spmt/";?>",
                    data: data,
                    cache: false,
                    contentType: false,
                    processData: false,
                    method: 'POST',
                }).done(function (data) {
                    $("#divListJadwal").html(data);
                    $("#btnFilter").css("pointer-events", "auto");
                    $("#btnFilter").css("opacity", "1");
                    $("#divListJadwal").css("pointer-events", "auto");
                    $("#divListJadwal").css("opacity", "1");
                    $("#divListJadwal").find("script").each(function(i) {
                        eval($(this).text());
                    });
                }).fail(function(){
                    $("#divListJadwal").html('Error...telah terjadi kesalahan');
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
        var ddInputer = $('#ddInputer').val();
        var keywordCari = $("#keywordCari").val();
        var chkCekBerkasRil;
        if ($('#chkCekBerkasRil').is(":checked") == true){
            chkCekBerkasRil = true;
        }else{
            chkCekBerkasRil = false;
        }
        loadDataListJadwalKhususSpmt(ddBln,ddThn,ddInputer,chkCekBerkasRil,keywordCari,'','');
    });

    function pagingViewListLoad(parm,parm2){
        var ddBln = $('#ddBln').val();
        var ddThn = $('#ddThn').val();
        var ddInputer = $('#ddInputer').val();
        var keywordCari = $("#keywordCari").val();
        var chkCekBerkasRil;
        if ($('#chkCekBerkasRil').is(":checked") == true){
            chkCekBerkasRil = true;
        }else{
            chkCekBerkasRil = false;
        }
        loadDataListJadwalKhususSpmt(ddBln,ddThn,ddInputer,chkCekBerkasRil,keywordCari,parm,parm2);
    }
</script>