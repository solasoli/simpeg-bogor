<style>
    .rounded_box_red {
        background-color: rgba(135,23,23,0.35);
        color: black;
        font-size: small;
        font-weight: normal;
        padding-left: 4px;
        padding-right: 4px;
        padding-top: 3px;
        padding-bottom: 3px;
        -moz-border-radius: 3px;
        -webkit-border-radius: 3px;
    }
    .rounded_box_orange {
        background-color: orange;
        color: black;
        font-size: small;
        font-weight: normal;
        padding-left: 4px;
        padding-right: 4px;
        padding-top: 3px;
        padding-bottom: 3px;
        -moz-border-radius: 3px;
        -webkit-border-radius: 3px;
    }
    .rounded_box_green {
        background-color: rgba(97,135,68,0.35);
        color: black;
        font-size: small;
        font-weight: normal;
        padding-left: 4px;
        padding-right: 4px;
        padding-top: 3px;
        padding-bottom: 3px;
        -moz-border-radius: 3px;
        -webkit-border-radius: 3px;
    }
    .rounded_box_default {
        background-color: rgba(82,91,135,0.35);
        color: black;
        font-size: small;
        font-weight: normal;
        padding-left: 4px;
        padding-right: 4px;
        padding-top: 3px;
        padding-bottom: 3px;
        -moz-border-radius: 3px;
        -webkit-border-radius: 3px;
    }
</style>

<div class="panel-content" data-role="panel"
     data-title-caption=""
     data-title-icon=""
     data-cls-title="bg-steel fg-white">
    <?php
    if (isset($data_dasar) and sizeof($data_dasar) > 0 and $data_dasar != ''){
        foreach ($data_dasar as $lsdata) {
            $nip_baru = $lsdata->nip_baru;
            $nama = $lsdata->nama;
            $periode_bln = $lsdata->periode_bln;
            $periode_thn = $lsdata->periode_thn;
            $jabatan = (isset($lsdata->jabatan_hist)?$lsdata->jabatan_hist:$lsdata->last_jabatan);
            $atsl_nip_hist = (isset($lsdata->atsl_nip_hist)?$lsdata->atsl_nip_hist:$lsdata->last_atsl_nip);
            $id_status_knj = $lsdata->id_status_knj;
            $status_knj = $lsdata->status_knj;
        }

        echo '<div style="background-color: rgba(205,205,208,0.35);padding: 5px; border: 1px solid rgba(82,91,135,0.35); font-size: 11pt;">';
        echo '<strong>'.$nama.'</strong><br>'.'NIP: '.$nip_baru;
        echo '<br>Jabatan: '.$jabatan;
        echo '<br><span style="color: blue">Periode: '.$this->umum->monthName($periode_bln).' '.$periode_thn.'<br>Status: '.$lsdata->status_knj.'</span><br>';
        echo '<strong>Atasan:</strong><br>'.(isset($lsdata->atsl_nama_hist)?$lsdata->atsl_nama_hist:$lsdata->last_atsl_nama);
        echo '<br>'.(isset($lsdata->atsl_jabatan_hist)?$lsdata->atsl_jabatan_hist:$lsdata->last_atsl_jabatan);
        echo '<br>'.(isset($lsdata->unit_kerja_hist)?$lsdata->unit_kerja_hist:$lsdata->last_unit_kerja);
        echo '</div>';
    }
    ?>
    <div class="mx-auto" data-role="panel" data-title-caption="<small><strong>Filter Data</strong></small>">
        <div class="row mb-3">
            <div class="cell-sm-3">
                <select id="ddStsProsesFilter" name="ddStsProsesFilter" data-role="select" class="cell-sm-12">
                    <option value="0">Pilih Status</option>
                    <option value="1">Disetujui</option>
                    <option value="2">Revisi</option>
                    <option value="3">Tolak</option>
                    <option value="4">Belum diproses</option>
                </select>
            </div>
            <div class="cell-sm-3">
                <input type="text" id="keywordCari" name="keywordCari" class="cell-sm-12" placeholder="Kata Kunci">
            </div>
            <div class="cell-sm-4">
                <button id="btnFilter" name="btnFilter" onclick="" type="button" class="button primary bg-grayBlue drop-shadow">
                    <span class="mif-search icon"></span> Tampilkan</button>
                <button id="btnKembali" type="button" class="button primary bg-darkSteel drop-shadow">
                    <span class="mif-arrow-left icon"></span> Kembali</button>
            </div>
        </div>
    </div>
    <div id="divListAktifitas"></div>
</div>

<script type="text/javascript">
    $("select#ddStsProsesFilter option").each(function() { this.selected = (this.text == 0); });
    $('#keywordCari').val("");
    loadDataListAktifitas(0,'','','');

    function loadDataListAktifitas(ddStsProses,keywordCari,page,ipp){
        $("#btnFilter").css("pointer-events", "none");
        $("#btnFilter").css("opacity", "0.4");
        $("#btnKembali").css("pointer-events", "none");
        $("#btnKembali").css("opacity", "0.4");
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
                data.append('id_status_knj', '<?php echo $id_status_knj; ?>');
                data.append('ddStsProses', ddStsProses);
                data.append('keywordCari', keywordCari);
                data.append('idknjm', '<?php echo $idknjm; ?>');
                data.append('idpatsl', '<?php echo $idpatsl; ?>');
                data.append('page', page);
                data.append('ipp', ipp);
                return $.ajax({
                    url: "<?php echo base_url($usr)."/vw_drop_data_peninjauan_staf_detail/";?>",
                    data: data,
                    cache: false,
                    contentType: false,
                    processData: false,
                    method: 'POST',
                }).done(function (data) {
                    $("#divListAktifitas").html(data);
                    $("#btnFilter").css("pointer-events", "auto");
                    $("#btnFilter").css("opacity", "1");
                    $("#btnKembali").css("pointer-events", "auto");
                    $("#btnKembali").css("opacity", "1");
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
        var ddStsProses = $('#ddStsProsesFilter').val();
        var keywordCari = $("#keywordCari").val();
        loadDataListAktifitas(ddStsProses,keywordCari,'','');
    });

    function pagingViewListLoad(parm,parm2) {
        var ddStsProses = $('#ddStsProsesFilter').val();
        var keywordCari = $("#keywordCari").val();
        loadDataListAktifitas(ddStsProses, keywordCari, parm, parm2);
    }

    $("#btnKembali").click(function(){
        window.history.back();
    });
</script>