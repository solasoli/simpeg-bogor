<!-- EasyAutoComplete -->
<link rel="stylesheet" href="<?php echo base_url('assets/EasyAutocomplete-1.3.5/easy-autocomplete.css'); ?>" >
<script src="<?php echo base_url()?>assets/jquery/dist/jquery.validate.js"></script>

<script type="text/javascript" src="<?php echo base_url('assets/EasyAutocomplete-1.3.5/jquery.easy-autocomplete.js'); ?>"></script>
<style>
    #map_unit_utama {
        width: 100%;
        height: 400px;
        background-color: grey;
        border: 1px solid grey;
    }

    #canvas_map_dialog {
        width: 100%;
        height: 400px;
        background-color: grey;
        border: 1px solid grey;
    }

    .myCheck::before{
        border-color: #0b98da!important;
    }

    .eac-round{
        width: 100%!important;
    }

    .eac-square input, .eac-round input {
        background-image: url("<?php echo base_url('assets/images/if_icon-111-search_314478-32.png'); ?>");
        background-repeat: no-repeat;
        background-position: right 10px center;
    }

    .errors {
        color: red;
    };
</style>
<div class="panel-content" data-role="panel"
     data-title-caption=""
     data-title-icon=""
     data-cls-title="bg-steel fg-white">
    <?php if($tx_result == 'true' and $tx_result!=''): ?>
        <div class="container bg-emerald fg-white" style="margin-bottom: 10px;">
            <div class="cell-12 text-center" style="font-size: small;"><strong>Selamat</strong> Data sukses tersimpan. <?php echo ($upload_kode!=0?$upload_status:''); ?></div>
        </div>
    <?php elseif($tx_result == 'false' and $tx_result!=''): ?>
        <div class="container bg-red fg-white" style="margin-bottom: 10px;">
            <div class="cell-12 text-center" style="font-size: small;"><strong>Maaf</strong> Data tidak tersimpan. <?php echo $title_result.' '.($upload_kode!=0?$upload_status:''); ?></div>
        </div>
    <?php endif; ?>
    <ul class="tabs-expand-md" data-role="tabs" style="font-size: small;font-weight: bold;">
        <li id="tbCurLokasiKerja" class="active"><a href="#tab1">Lokasi Kerja</a></li>
        <li id="tbNewLokasiLainnya"><a href="#tab2">Tambah Lokasi Kerja Lainnya</a></li>
    </ul>
    <div class="border bd-default no-border-top p-2">
        <div id="tab1">
            <div class="row mb-2">
                <div class="cell-sm-6">
                    <?php if (isset($unit_utama) and sizeof($unit_utama) > 0 and $unit_utama != ''){
                        foreach ($unit_utama as $lsdata) {
                            $point_lat_utama = $lsdata->in_lat_unit;
                            $point_long_utama = $lsdata->in_long_unit;
                            $point_lat_utama_out = $lsdata->out_lat_unit;
                            $point_long_utama_out = $lsdata->out_long_unit;
                            echo '<span style="color: green; font-weight: bold">'.$lsdata->nama.'</span><br>'.$lsdata->nip_baru.'<br>'; ?>
                            <input id="clkMulti" name="clkMulti" type="checkbox"
                                   data-role="checkbox"
                                   data-style="2"
                                   data-caption="Multi Lokasi Kerja"
                                   data-cls-caption="fg-cyan text-bold"
                                   data-cls-check="bd-cyan myCheck" onclick="prosesMultiLokasi(this.checked, '<?php echo $lsdata->id_clk;?>');" <?php echo ($lsdata->flag_lokasi_multiple==0?'':'checked'); ?>><br>
                            <?php echo '<span style="color: blue;">Unit Kerja Utama :</span><br>'.$lsdata->unit_kerja.'<br><small>'.$lsdata->alamat_unit.'</small><br>';
                            if($lsdata->id_unit_kerja!=$lsdata->id_skpd){
                                echo '<br>OPD :<br>';
                                echo $lsdata->opd.'<br><small>'.$lsdata->alamat_opd.'</small><br>';
                            }
                            echo 'Koordinat :<br><small>';
                            echo '<img src=\''.base_url('assets/images/green-dot.png').'\' style="width:16px;height: 16px;"/> Titik Area Dalam (Latitude, Longitude) : <br>&nbsp;&nbsp;&nbsp;('.$lsdata->in_lat_unit.','.$lsdata->in_long_unit.')<br>';
                            echo '<img src=\''.base_url('assets/images/red-dot.png').'\' style="width:16px;height: 16px;"/> Titik Area Luar (Latitude, Longitude) : <br>&nbsp;&nbsp;&nbsp;('.$lsdata->out_lat_unit.','.$lsdata->out_long_unit.')</small>';
                        }
                        ?><br>Peta Lokasi :<br>
                        <div id="map_unit_utama"></div>
                    <?php }else{ ?>
                        Data tidak ditemukan
                    <?php } ?>
                </div>
                <div class="cell-sm-6">
                    <span style="color: blue">Unit Kerja Lainnya :</span> <br>
                    <?php if (isset($unit_sekunder) and sizeof($unit_sekunder) > 0 and $unit_sekunder != ''){
                        $i = 1;?>
                        <div class="my-rows-wrapper" style="display: none"></div>
                        <div class="my-search-wrapper"></div>
                        <table id="tblListUnitKerjaLainnya" class="table row-hover row-border compact"
                               style="margin-bottom: 0px;border-bottom: 1px solid rgba(71,71,72,0.35);"
                               data-role="table"
                               data-rows-steps="10, 15, 20, 30"
                               data-rows="3"
                               data-info-wrapper=".my-info-wrapper"
                               data-pagination-wrapper=".my-pagination-wrapper"
                               data-search-wrapper=".my-search-wrapper"
                               data-rows-wrapper=".my-rows-wrapper">
                            <thead>
                            <tr>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($unit_sekunder as $lsdata2): ?>
                                <tr>
                                    <td>
                                        <?php
                                        $point_in_lat_sekunder = $lsdata2->in_lat_unit_sekunder;
                                        $point_in_long_sekunder = $lsdata2->in_long_unit_sekunder;
                                        $point_out_lat_sekunder = $lsdata2->out_lat_unit_sekunder;
                                        $point_out_long_sekunder = $lsdata2->out_long_unit_sekunder;

                                        echo '<strong>'.(sizeof($unit_sekunder)>1?$i.') ':'').$lsdata2->unit_sekunder.'</strong> ('.($lsdata2->tipe_unit_kerja_lain==1?'Unit Utama':'Unit Sekunder').')'.'<br><small>'.$lsdata2->alamat.'</small><br>';
                                        echo 'Koordinat :<br><small>';
                                        echo '<img src=\''.base_url('assets/images/green-dot.png').'\' style="width:16px;height: 16px;"/> Titik Area Dalam (Latitude, Longitude) : <br>&nbsp;&nbsp;&nbsp;('.$lsdata2->in_lat_unit_sekunder.','.$lsdata2->in_long_unit_sekunder.')<br>';
                                        echo '<img src=\''.base_url('assets/images/red-dot.png').'\' style="width:16px;height: 16px;"/> Titik Area Luar (Latitude, Longitude) : <br>&nbsp;&nbsp;&nbsp;('.$lsdata2->out_lat_unit_sekunder.','.$lsdata2->out_long_unit_sekunder.')</small>';
                                        echo '<br>No.SPMT : '.$lsdata2->no_spmt_unit_sekunder.' ('.$lsdata2->tmt_spmt.')';
                                        echo '<br>Oleh : '.$lsdata2->nama.' ('.$lsdata2->tgl_input.')';
                                        echo '<br><a href="javascript:void(0);" onclick="hapus_unit_kerja_lainnya(\''.$lsdata2->id_clkl.'\');"><span class="mif-bin icon"></span> Hapus</a>';
                                        if($lsdata2->berkas_spmt!=''){
                                            echo '&nbsp;&nbsp;<a href="javascript:void(0)" onclick="get_berkas(\''.$lsdata2->berkas_spmt.'\')"><span class="mif-download icon"></span> Download</a>'; ?>
                                        <?php }
                                        echo '&nbsp;<a href="javascript:void(0)" onclick="lihatPeta('."$point_in_lat_sekunder, $point_in_long_sekunder, $point_out_lat_sekunder, $point_out_long_sekunder".')"><span class="mif-map2 icon"></span> Lihat Peta</a> ';
                                        echo '<br>';
                                        $i++;
                                        ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                        <p class="text-center my-info-wrapper" style="font-size: small"></p>
                        <div class="d-flex flex-justify-center my-pagination-wrapper pagination size-small" style="margin-bottom: -20px;"></div>
                        <div class="dialog" data-role="dialog" id="dialogMap" style="overflow-y: auto">
                            <div class="dialog-title">Peta Lokasi Unit Kerja Sekunder</div>
                            <div class="dialog-content">
                                <div id="canvas_map_dialog"></div>
                            </div>
                            <div class="dialog-actions" style="text-align: right">
                                <button class="button js-dialog-close">Tutup</button>
                            </div>
                        </div>

                    <?php }else{ ?>
                        Data tidak ditemukan
                    <?php } ?><br>
                </div>
            </div>
        </div>
        <div id="tab2">
            <div class="row mb-2">
                <div class="cell-sm-12">
                    <div data-role="accordion" data-one-frame="true" data-show-active="true">
                        <div class="frame active">
                            <div class="heading"><span style="color: blue">Dari Unit Kerja Terdaftar</span></div>
                            <div class="content">
                                <form action="" method="post" id="frmAddUnitSekunderEksisting" novalidate="novalidate" enctype="multipart/form-data" class="custom-validation need-validation">
                                    <div class="row mb-2">
                                        <div class="cell-sm-6">
                                            <input id="submitUnitSekunderEksisting" name="submitUnitSekunderEksisting" type="hidden" value="1">
                                            <input id="rdbTipeUnitKerja" name="rdbTipeUnitKerja" type="radio" value="utama" checked
                                                   data-role="radio"
                                                   data-style="2"
                                                   data-caption="Utama"
                                                   data-cls-caption="fg-cyan text-bold"
                                                   data-cls-check="bd-cyan myCheck">
                                            <input id="rdbTipeUnitKerja" name="rdbTipeUnitKerja" value="sekunder" type="radio"
                                                   data-role="radio"
                                                   data-style="2"
                                                   data-caption="Sekunder"
                                                   data-cls-caption="fg-cyan text-bold"
                                                   data-cls-check="bd-cyan myCheck">
                                            <input id="txtLokasiSekunder" name="txtLokasiSekunder" type="text" placeholder="Ketik nama atau alamat" style="width: 100%;">
                                            <input id="idLokasiSekunder" name="idLokasiSekunder" type="hidden">
                                            <input id="idp" name="idp" type="hidden" value="<?php echo $idp; ?>">
                                            <input id="tipe_lokasi" name="tipe_lokasi" type="hidden">
                                            <span id="err_msg_lokasi"></span> <small class="text-muted">Unit Kerja yang terdaftar sesuai Tipe</small>
                                            <div id="divInfoUnitSekunder"></div>
                                        </div>
                                        <div class="cell-sm-6">
                                            <div style="background-color: lightgrey; border: 1px solid rgba(82,91,135,0.35);
    margin-bottom: 10px; text-align: center; font-size: small; font-weight: bold;">
                                                Surat Perintah Lokasi Kerja Lain</div>
                                            No. SPMT :<br>
                                            <input type="text" id="txtNoSPMT" name="txtNoSPMT" class="cell-sm-12">
                                            <small class="text-muted">Nomor Surat Tugas SPMT di lokasi kerja lain</small><br>
                                            TMT. bertugas pada lokasi kerja lain<br>
                                            <input id="tmtSpmt" value="" name="tmtSpmt" type="text" data-role="calendarpicker" class="cell-sm-12">
                                            <small class="text-muted">TMT. Tugas pada Lokasi Kerja Lain</small><br>
                                            Berkas SPMT :<br>
                                            <input class="cell-sm-12" type="file" id="fileSpmtExisting" name="fileSpmtExisting" style="font-size: small; padding-left: 0px;">
                                            <small class="text-muted">Berkas SPMT untuk bertugas</small><br>
                                            <div class="row" style="margin-top: 10px;">
                                                <div class="cell" style="margin-bottom: 10px;">
                                                    <button type="submit" class="button primary bg-green drop-shadow"><span class="mif-floppy-disk icon"></span> Simpan</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="frame">
                            <div class="heading"><span style="color: blue">Unit Kerja Sekunder Baru</span></div>
                            <div class="content">
                                <div class="p-2"><?php
                                    if(isset($view_form)){
                                        $this->load->view($view_form);
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



</div>

<script>

    $( function() {
        var options = {
            url: function(phrase) {
                return "<?php echo base_url('adminopd/cari_lokasi_sekunder'); ?>";
            },

            getValue: function(element) {
                return element.nama;
            },

            list: {
                onClickEvent: function() {
                    var selectedItemValue = $("#txtLokasiSekunder").getSelectedItemData().id_uk_sekunder_enc;
                    $("#idLokasiSekunder").val(selectedItemValue);
                    loadInfoUnitSekunder(selectedItemValue, $('input[name=rdbTipeUnitKerja]:checked', '#frmAddUnitSekunderEksisting').val());
                    $("#tipe_lokasi").val($('input[name=rdbTipeUnitKerja]:checked', '#frmAddUnitSekunderEksisting').val());
                }
            },

            ajaxSettings: {
                dataType: "json",
                method: "POST",
                data: {
                    dataType: "json"
                }
            },

            preparePostData: function(data) {
                data.phrase = $("#txtLokasiSekunder").val();
                data.tipe_unit = $('input[name=rdbTipeUnitKerja]:checked', '#frmAddUnitSekunderEksisting').val();
                data.opd = '';<?php //echo $this->session->userdata('id_skpd_enc'); ?>
                return data;
            },

            requestDelay: 400,
            theme: "round"
        };

        $("#txtLokasiSekunder").easyAutocomplete(options);

        $('input[type=radio][name=rdbTipeUnitKerja]').change(function() {
            $("#txtLokasiSekunder").val('');
            $("#eac-container-txtLokasiSekunder ul").each(function() {
                $(this).css('display', 'none');
            });
        });

    } );

    function get_berkas(berkas){
        window.open('https://arsipsimpeg.kotabogor.go.id/ekinerja2/berkas/'+berkas, '_blank');
    }

    function loadInfoUnitSekunder(selectedItemValue, tipeUnit){
        $("#txtLokasiSekunder").css("pointer-events", "none");
        $("#txtLokasiSekunder").css("opacity", "0.4");
        $("#divInfoUnitSekunder").css("pointer-events", "none");
        $("#divInfoUnitSekunder").css("opacity", "0.4");
        var jc = $.confirm({
            title: '',
            closeIconClass: 'fa fa-close',
            closeIcon: null,
            closeIconClass: false,
            boxWidth: '200px',
            useBootstrap: false,
            content: function () {
                var data = new FormData();
                data.append('idUnitSekunder', selectedItemValue);
                data.append('tipeUnit', tipeUnit);
                return $.ajax({
                    url: "<?php echo base_url('adminopd/get_info_unit_Sekunder/');?>",
                    data: data,
                    cache: false,
                    contentType: false,
                    processData: false,
                    method: 'POST',
                }).done(function (data) {
                    $("#divInfoUnitSekunder").html(data);
                    $("#txtLokasiSekunder").css("pointer-events", "auto");
                    $("#txtLokasiSekunder").css("opacity", "1");
                    $("#divInfoUnitSekunder").css("pointer-events", "auto");
                    $("#divInfoUnitSekunder").css("opacity", "1");
                    $("#divInfoUnitSekunder").find("script").each(function(i) {
                        eval($(this).text());
                    });
                }).fail(function(){
                    $("#divInfoUnitSekunder").html('Error...telah terjadi kesalahan');
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

    function initMap() {
        // The location of center_unit_utama
        var center_unit_utama = {lat: <?php echo $point_lat_utama;?>, lng: <?php echo $point_long_utama;?>};
        // The map, centered at center_unit_utama
        var map_unit_utama = new google.maps.Map(
            document.getElementById('map_unit_utama'), {zoom: 17, center: center_unit_utama, mapTypeId: 'hybrid'});
        // The marker, positioned at center_unit_utama
        var image_in = 'http://maps.google.com/mapfiles/ms/icons/green-dot.png';
        var marker_unit_utama_in = new google.maps.Marker({
            position: center_unit_utama,
            map: map_unit_utama,
            icon: image_in
        });
        var image_out = 'http://maps.google.com/mapfiles/ms/icons/red-dot.png';
        var center_unit_utama_out = {lat: <?php echo $point_lat_utama_out;?>, lng: <?php echo $point_long_utama_out;?>};
        var marker_unit_utama_out = new google.maps.Marker({
            position: center_unit_utama_out,
            map: map_unit_utama,
            icon: image_out
        });
    }

    function prosesMultiLokasi(isMulti, idClk){
        $.alert({
            closeIconClass: 'fa fa-close',
            closeIcon: null,
            closeIconClass: false,
            useBootstrap: false,
            content: function () {
                var self = this;
                var data = new FormData();
                data.append('isMulti', isMulti);
                data.append('idClk', idClk);
                data.append('idp_updater', '<?php echo $this->session->userdata('id_pegawai_enc'); ?>');
                return $.ajax({
                    url: "<?php echo base_url($usr)."/ubah_tipe_lokasi_pegawai/";?>",
                    data: data,
                    cache: false,
                    contentType: false,
                    processData: false,
                    method: 'POST',
                }).done(function (result) {
                    self.setTitle('Informasi');
                    if(result==1){
                        self.setType('green');
                        self.setContent('Berhasil mengubah tipe lokasi kerja');
                    }else{
                        self.setType('red');
                        self.setContent('Maaf tidak Berhasil mengubah tipe lokasi kerja');
                    }
                }).fail(function(){
                    self.setContent('Error...telah terjadi kesalahan');
                });
            },
            onContentReady: function () {},
            buttons: {
                refreshList: {
                    text: 'OK',
                    btnClass: 'btn-blue',
                    action: function () {
                        //location.href = '<?php //echo base_url($usr);?>/input_tipe_lokasi_kerja?idp=<?php //echo $idp; ?>';
                    }
                },
            }
        });
    }

    function hapus_unit_kerja_lainnya(id_clkl){
        $.confirm({
            title: 'Informasi',
            closeIconClass: 'fa fa-close',
            closeIcon: null,
            closeIconClass: false,
            useBootstrap: false,
            content: 'Anda yakin akan menghapus data lokasi unit kerja lainnya ini?',
            buttons: {
                cancel: {
                    text: 'Tidak',
                    action: function () {
                        return true;
                    }
                },
                somethingElse: {
                    text: 'Ya',
                    btnClass: 'btn-blue',
                    keys: ['enter', 'shift'],
                    action: function(){
                        var jc = $.confirm({
                            title: '',
                            closeIconClass: 'fa fa-close',
                            closeIcon: null,
                            closeIconClass: false,
                            boxWidth: '200px',
                            useBootstrap: false,
                            content: function () {
                                var data = new FormData();
                                data.append('id_unit_sekunder_pegawai_enc', id_clkl);
                                return $.ajax({
                                    url: "<?php echo base_url($usr)."/exec_hapus_unit_sekunder_pegawai/";?>",
                                    data: data,
                                    cache: false,
                                    contentType: false,
                                    processData: false,
                                    method: "POST"
                                }).done(function( data ){
                                    if(data == 1){
                                        location.href = "<?php echo $url_reload ?>";
                                    }else{
                                        $.alert({
                                            closeIconClass: 'fa fa-close',
                                            closeIcon: null,
                                            closeIconClass: false,
                                            useBootstrap: false,
                                            content: 'Gagal menghapus data',
                                            type: 'red'
                                        });
                                    }
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
                }
            }
        });
    }

    var fileSpmtExisting = 0;
    $('#fileSpmtExisting').bind('change', function() {
        fileSpmtExisting = this.files[0].size;
    });

    $("#frmAddUnitSekunderEksisting").validate({
        errorClass: 'errors',
        ignore: "",
        rules: {
            txtNoSPMT: {
                required: true
            },
            tmtSpmt: {
                required: true
            },
            idLokasiSekunder: {
                required: true
            },
            fileSpmtExisting:{
                required: true
            }
        },
        messages: {
            txtNoSPMT: {
                required: "*"
            },
            tmtSpmt: {
                required: "*"
            },
            idLokasiSekunder: {
                required: "*"
            },
            fileSpmtExisting:{
                required: "*"
            }
        },
        errorPlacement: function(error, element) {
            switch (element.attr("name")) {
                case 'idLokasiSekunder':
                    error.insertAfter($("#err_msg_lokasi"));
                    break;
                default:
                    error.insertAfter(element);
            }
        },
        submitHandler: function(form) {
            if (parseFloat(fileSpmtExisting) > 2138471) {
                alert('Ukuran file terlalu besar');
            } else {
                form.submit();
            }
        }
    });

    function lihatPeta(in_lat, in_lng, out_lat, out_lng){
        var point_in = {lat: in_lat, lng: in_lng};
        var map_dialog = new google.maps.Map(
            document.getElementById('canvas_map_dialog'), {zoom: 19, center: point_in, mapTypeId: 'hybrid'});
        var img_in = 'http://maps.google.com/mapfiles/ms/icons/green-dot.png';
        var marker_in = new google.maps.Marker({
            position: point_in,
            map: map_dialog,
            icon: img_in
        });
        var img_out = 'http://maps.google.com/mapfiles/ms/icons/red-dot.png';
        var point_out = {lat: out_lat, lng: out_lng};
        var marker_out = new google.maps.Marker({
            position: point_out,
            map: map_dialog,
            icon: img_out
        });
        Metro.dialog.open('#dialogMap');
    }
</script>

<!--Load the API from the specified URL
* The async attribute allows the browser to render the page while the API loads
* The key parameter will contain your own API key (which is not needed for this tutorial)
* The callback parameter executes the initMap() function
-->
<script
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBUn6I2tqpiL5IKsdP8YNErsUnBeNPn9O0&callback=initMap&libraries=places">
</script>