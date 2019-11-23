<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<script src="<?php echo base_url()?>assets/jquery/dist/jquery.validate.js"></script>
<link href="<?php echo base_url('assets/style_checkbox.css'); ?>" rel="stylesheet">
<style>
    .error {
        font-size: small;
        color: red;
    }
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

<script>
    jQuery.validator.addMethod(
        "selectComboStatus",
        function (value, element)
        {
            if (element.value === "0") {
                return false;
            }else {
                return true;
            }
        },
        "Tentukan Status"
    );

    $(function(){
        $("#frmPersetujuanAktifitasPlh").validate({
            ignore: "",
            errorPlacement: function(error, element) {
                switch (element.attr("name")) {
                    case 'ddStsProsesPlh':
                        error.insertAfter($("#jqv_msg_sts_plh"));
                        break;
                    default:
                        error.insertAfter(element);
                }
            },
            submitHandler: function(form) {
                var checkboxes = $("#dvAllListAktifitasPlh input:checkbox");
                var jmlCheck = 0;
                for (var i = 0; i < checkboxes.length; i++) {
                    if(checkboxes[i].checked == true){
                        jmlCheck++;
                    }
                }
                if(jmlCheck <= 0){
                    alert('Pilih dahulu aktifitas yang akan diproses');
                }else{
                    form.submit();
                }
            }
        });
    });
</script>


<?php if($tx_result == 'true' and $tx_result!=''): ?>
    <div class="container bg-emerald fg-white" style="margin-bottom: 10px;">
        <div class="cell-12 text-center"><strong>Selamat</strong> Data sukses tersimpan. <?php echo $title_result; ?></div>
    </div>
<?php elseif($tx_result == 'false' and $tx_result!=''): ?>
    <div class="container bg-red fg-white" style="margin-bottom: 10px;">
        <div class="cell-12 text-center" style="font-size: small;"><strong>Maaf</strong> Data tidak tersimpan. <?php echo $title_result; ?></div>
    </div>
<?php endif; ?>

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

    <form action="" method="post" id="frmPersetujuanAktifitasPlh" name="frmPersetujuanAktifitasPlh" novalidate="novalidate" enctype="multipart/form-data">
        <div class="row">
            <div class="cell-md-12">
                <?php if($id_status_knj==1 or $id_status_knj==2 or $id_status_knj==5): ?>
                    <div class="mx-auto" data-role="panel" data-title-caption="<small><strong>Pemrosesan Sekaligus</strong></small>">
                        <div class="row mb-3">
                            <div class="cell-sm-5">
                                <input id="submitok" name="submitok" type="hidden" value="1">
                                <label><input id="chkCheckAllPlh" name="chkCheckAllPlh" type="checkbox" data-role="checkbox" data-style="2">Pilih semua pada halaman ini</label>
                            </div>
                            <div class="cell-sm-5">
                                <select id="ddStsProsesPlh" name="ddStsProsesPlh" data-role="select" class="cell-sm-12">
                                    <option value="0">Penentuan status aktifitas</option>
                                    <option value="1">Setujui yang dipilih</option>
                                    <option value="2">Revisi yang dipilih</option>
                                    <option value="3">Tolak yang dipilih</option>
                                    <option value="4">Batalkan Proses yang dipilih</option>
                                </select><span id="jqv_msg_sts_plh"></span>
                            </div>
                            <div class="cell-sm-2">
                                <button type="submit" class="button primary bg-green drop-shadow"><span class="mif-floppy-disk icon"></span> Proses</button>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <div class="mx-auto" data-role="panel" data-title-caption="<small><strong>Filter Data</strong></small>">
            <div class="row mb-3">
                <div class="cell-sm-3">
                    <select id="ddStsProsesFilterPlh" name="ddStsProsesFilterPlh" data-role="select" class="cell-sm-12">
                        <option value="0">Pilih Status</option>
                        <option value="1">Disetujui</option>
                        <option value="2">Revisi</option>
                        <option value="3">Tolak</option>
                        <option value="4">Belum diproses</option>
                    </select>
                </div>
                <div class="cell-sm-3">
                    <input type="text" id="keywordCariPlh" name="keywordCariPlh" class="cell-sm-12" placeholder="Kata Kunci">
                </div>
                <div class="cell-sm-4">
                    <button id="btnFilterPlh" name="btnFilterPlh" onclick="" type="button" class="button primary bg-grayBlue drop-shadow">
                        <span class="mif-search icon"></span> Tampilkan</button>
                    <button id="btnKembaliPlh" type="button" class="button primary bg-darkSteel drop-shadow">
                        <span class="mif-arrow-left icon"></span> Kembali</button>
                </div>
            </div>
        </div>

        <div id="divListAktifitasPlh"></div>
    </form>
</div>

<script type="text/javascript">
    $("select#ddStsProsesFilterPlh option").each(function() { this.selected = (this.text == 0); });
    $('#keywordCariPlh').val("");
    loadDataListAktifitasPlh(0,'','','');

    function loadDataListAktifitasPlh(ddStsProses,keywordCari,page,ipp){
        $("#btnFilterPlh").css("pointer-events", "none");
        $("#btnFilterPlh").css("opacity", "0.4");
        $("#btnKembaliPlh").css("pointer-events", "none");
        $("#btnKembaliPlh").css("opacity", "0.4");
        $("#divListAktifitasPlh").css("pointer-events", "none");
        $("#divListAktifitasPlh").css("opacity", "0.4");

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
                data.append('idpatsl_plh', '<?php echo $idpatsl_plh; ?>');
                data.append('page', page);
                data.append('ipp', ipp);
                return $.ajax({
                    url: "<?php echo base_url($usr)."/drop_data_peninjauan_staf_detail_plh/";?>",
                    data: data,
                    cache: false,
                    contentType: false,
                    processData: false,
                    method: 'POST',
                }).done(function (data) {
                    $("#divListAktifitasPlh").html(data);
                    $("#btnFilterPlh").css("pointer-events", "auto");
                    $("#btnFilterPlh").css("opacity", "1");
                    $("#btnKembaliPlh").css("pointer-events", "auto");
                    $("#btnKembaliPlh").css("opacity", "1");
                    $("#divListAktifitasPlh").css("pointer-events", "auto");
                    $("#divListAktifitasPlh").css("opacity", "1");
                    $("#divListAktifitasPlh").find("script").each(function(i) {
                        eval($(this).text());
                    });
                }).fail(function(){
                    $("#divListAktifitasPlh").html('Error...telah terjadi kesalahan');
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

    $("#btnFilterPlh").click(function(){
        var ddStsProsesPlh = $('#ddStsProsesFilterPlh').val();
        var keywordCariPlh = $("#keywordCariPlh").val();
        loadDataListAktifitasPlh(ddStsProsesPlh,keywordCariPlh,'','');
    });

    function pagingViewListLoad(parm,parm2){
        var ddStsProsesPlh = $('#ddStsProsesFilterPlh').val();
        var keywordCariPlh = $("#keywordCariPlh").val();
        loadDataListAktifitasPlh(ddStsProsesPlh,keywordCariPlh,parm,parm2);
        $( "#chkCheckAllPlh" ).prop( "checked", false );
    }

    $( "#ddStsProsesPlh" ).addClass( "selectComboStatus" );

    $("#btnKembaliPlh").click(function(){
        window.history.back();
    });
</script>