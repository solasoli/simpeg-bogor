<!-- EasyAutoComplete -->
<link rel="stylesheet" href="<?php echo base_url('assets/EasyAutocomplete-1.3.5/easy-autocomplete.css'); ?>" >
<script src="<?php echo base_url()?>assets/jquery/dist/jquery.validate.js"></script>

<script type="text/javascript" src="<?php echo base_url('assets/EasyAutocomplete-1.3.5/jquery.easy-autocomplete.js'); ?>"></script>

<style>
    #canvas_map_dialog {
        width: 100%;
        height: 400px;
        background-color: grey;
        border: 1px solid grey;
    }

    #map_unit_sekunder_add {
        width: 100%;
        height: 400px;
        background-color: grey;
        border: 1px solid grey;
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

<?php
    if (isset($data_uk_sekunder) and sizeof($data_uk_sekunder) > 0 and $data_uk_sekunder != ''){
        foreach ($data_uk_sekunder as $lsdata) {
            $nama_lokasi = $lsdata->nama;
            $alamat = $lsdata->alamat;
            $telp = $lsdata->telp;
            $email = $lsdata->email;
            $in_lat = $lsdata->in_lat;
            $in_long = $lsdata->in_long;
            $out_lat = $lsdata->out_lat;
            $out_long = $lsdata->out_long;
            $tipe_wilayah = $lsdata->tipe_wilayah;
            $id_uk_induk = $lsdata->id_uk_induk;
            $id_uk_primer = $lsdata->id_uk_primer;
            $induk = $lsdata->induk;
            $unit_utama = $lsdata->unit_utama;
        }
    }
?>

<div class="panel-content" data-role="panel"
     data-title-caption=""
     data-title-icon=""
     data-cls-title="bg-steel fg-white">

    <?php if($tx_result == 'true' and $tx_result!=''): ?>
        <div class="container bg-emerald fg-white" style="margin-bottom: 10px;">
            <div class="cell-12 text-center" style="font-size: small;"><strong>Selamat</strong> Data sukses tersimpan.</div>
        </div>
    <?php elseif($tx_result == 'false' and $tx_result!=''): ?>
        <div class="container bg-red fg-white" style="margin-bottom: 10px;">
            <div class="cell-12 text-center" style="font-size: small;"><strong>Maaf</strong> Data tidak tersimpan. <?php echo $title_result; ?></div>
        </div>
    <?php endif; ?>
    <ul class="tabs-expand-md" data-role="tabs" style="font-size: small;font-weight: bold;">
        <li id="tbList" <?php echo($input_type==''?'class="active"':'') ?>><a href="#tab1">Daftar Unit Sekunder</a></li>
        <li id="tbAdd" <?php echo($input_type==''?'':'class="active"') ?>><a href="#tab2"><?php echo($input_type==''?'Tambah Unit Sekunder Baru':'Ubah Unit Sekunder') ?></a></li>
    </ul>
    <div class="border bd-default no-border-top p-2">
        <div id="tab1">
            <div class="row">
                <div class="cell-sm-6">
                    <select id="ddOpd" name="ddOpd" class="cell-sm-12">
                        <option value="0">Semua OPD</option>
                        <?php if ($list_opd!=NULL and sizeof($list_opd) > 0 and $list_opd != ''): ?>
                            <?php foreach ($list_opd as $lsopd): ?>
                                <option value="<?php echo $lsopd->id_skpd; ?>"><?php echo $lsopd->nama_skpd; ?></option>
                            <?php endforeach; ?>
                        <?php endif; ?>
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

            <div id="divListUkSekunder"></div>
            <div class="dialog" data-role="dialog" id="dialogMap" style="overflow-y: auto">
                <div class="dialog-title">Peta Lokasi Unit Kerja Sekunder</div>
                <div class="dialog-content">
                    <div id="canvas_map_dialog"></div>
                </div>
                <div class="dialog-actions" style="text-align: right"></span>
                    <button class="button js-dialog-close rounded"><span class="mif-cross icon"> Tutup</button>
                </div>
            </div>
        </div>
        <div id="tab2">
            <div class="row mb-2">
                <div class="cell-sm-12">
                    <div class="input">
                        <input id="txtCariAlamat" type="text" data-role="input" data-prepend="Cari Alamat: " data-clear-button="false" placeholder="Nama / Koordinat">
                        <!--<button class="button" style="">
                            <span class="mif-search"></span>
                        </button>-->
                    </div>
                    <div id="map_unit_sekunder_add"></div>
                </div>
            </div>
            <form action="" method="post" id="frmAddUnitSekunderNew" novalidate="novalidate" enctype="multipart/form-data" class="custom-validation need-validation">
                <div class="row mb-2">
                    <div class="cell-sm-6">
                        <input id="submitUnitSekunderNew" name="submitUnitSekunderNew" type="hidden" value="1">
                        <input id="id_uk_sekunder" name="id_uk_sekunder" type="hidden" value="<?php echo ((isset($id_uk_sekunder) and $id_uk_sekunder!='')?$id_uk_sekunder:''); ?>">
                        <input id="input_type" name="input_type" type="hidden" value="<?php echo $input_type; ?>">
                        Koordinat Dalam <button id="btnPoiIn" class="button primary square mini outline rounded" type="button">
                            <span class="mif-pin" style="font-size: x-large;"></span></button><br>
                        <input id="coordinat_y_in" name="coordinat_y_in" type="text" data-role="input" data-prepend="Latitude (Y):&nbsp;&nbsp;&nbsp; " data-clear-button="false" value="<?php echo((isset($in_lat) and $in_lat!='')?$in_lat:''); ?>"> <!--readonly-->
                        <input id="coordinat_x_in" name="coordinat_x_in" type="text" data-role="input" data-prepend="Longitude (X): " data-clear-button="false" value="<?php echo((isset($in_long) and $in_long!='')?$in_long:''); ?>"> <!--readonly-->
                        <small class="text-muted">Titik Koordinat Batas Dalam Lokasi Wilayah.<br>Contoh: Y= -6.60067915, X= 106.79101632</small><br>
                        Koordinat Luar <button id="btnPoiOut" class="button primary square mini outline rounded" type="button">
                            <span class="mif-pin" style="font-size: x-large;"></span></button><br>
                        <input id="coordinat_y_out" name="coordinat_y_out" type="text" data-role="input" data-prepend="Latitude (Y):&nbsp;&nbsp;&nbsp; " data-clear-button="false" value="<?php echo((isset($out_lat) and $out_lat!='')?$out_lat:''); ?>"> <!--readonly-->
                        <input id="coordinat_x_out" name="coordinat_x_out" type="text" data-role="input" data-prepend="Longitude (X): " data-clear-button="false" value="<?php echo((isset($out_long) and $out_long!='')?$out_long:''); ?>"> <!--readonly-->
                        <small class="text-muted">Titik Koordinat Batas Luar Lokasi Wilayah.<br>Contoh: Y= -6.59679972, X= 106.78728268</small><br>
                        Tipe Wilayah<br>
                        <select id="ddTipeWilayah" name="ddTipeWilayah" data-role="select" class="cell-sm-12">
                            <option value="0">Pilih Tipe Wilayah</option>
                            <option value="Instansi" <?php echo((isset($tipe_wilayah) and $tipe_wilayah=='Instansi')?'selected':''); ?>>Instansi</option>
                            <option value="Umum" <?php echo((isset($tipe_wilayah) and $tipe_wilayah=='Umum')?'selected':''); ?>>Umum</option>
                        </select><span id="err_tipe_wilayah"></span>
                        <small class="text-muted">Tipe Wilayah Lokasi Sekunder.</small><br>
                        Induk Lokasi Sekunder (Koordinator)<br>
                        <input id="txtIndukLokasi_Sekunder" name="txtIndukLokasi_Sekunder" type="text" placeholder="Ketik nama atau alamat" style="width: 100%" onkeypress="clearIndukLokasiSekunder()" value="<?php echo((isset($induk) and $induk!='')?$induk:''); ?>">
                        <input id="idIndukLokasiSekunder" name="idIndukLokasiSekunder" type="hidden" value="<?php echo((isset($id_uk_induk) and $id_uk_induk!='0')?$id_uk_induk:''); ?>">
                        <span id="err_induk_lokasi"></span> <small class="text-muted">Lokasi Sekunder yang menjadi induk (Optional).</small><br>
                        Unit Kerja Utama<br>
                        <input id="txtUnitKerjaUtama" name="txtUnitKerjaUtama" type="text" placeholder="Ketik nama atau alamat" style="width:100%;" onkeypress="clearUnitKerjaUtama()" value="<?php echo((isset($unit_utama) and $unit_utama!='')?$unit_utama:''); ?>">
                        <input id="idUnitKerjaUtama" name="idUnitKerjaUtama" type="hidden" value="<?php echo((isset($id_uk_primer) and $id_uk_primer!='0')?$id_uk_primer:''); ?>">
                        <span id="err_unit_utama"></span> <small class="text-muted">Unit Kerja Utama.</small><br>
                    </div>
                    <div class="cell-sm-6">
                        Nama Lokasi<br>
                        <input id="namaLokasi" name="namaLokasi" type="text" data-role="input" data-clear-button="false" value="<?php echo((isset($nama_lokasi) and $nama_lokasi!='')?$nama_lokasi:''); ?>">
                        <small class="text-muted">Nama Lokasi Sekunder.</small><br>
                        Alamat<br>
                        <textarea id="txtAlamat" name="txtAlamat" class="mb-1" title="" rows="3" style="resize: none; text-align: left;"><?php echo((isset($alamat) and $alamat!='')?$alamat:''); ?></textarea>
                        <small class="text-muted">Alamat lokasi sekunder.</small><br>
                        Telepon<br>
                        <input id="txtTelepon" name="txtTelepon" type="text" data-role="input" data-clear-button="false" value="<?php echo((isset($telp) and $telp!='')?$telp:''); ?>">
                        <small class="text-muted">Telepon lokasi sekunder.</small><br>
                        Email<br>
                        <input id="txtEmail" name="txtEmail" type="text" data-role="input" data-clear-button="false" value="<?php echo((isset($email) and $email!='')?$email:''); ?>">
                        <small class="text-muted">Email lokasi sekunder.</small>
                        <div class="row" style="margin-top: 10px;">
                            <div class="cell" style="margin-bottom: 10px;">
                                <button type="submit" class="button primary bg-green drop-shadow"><span class="mif-floppy-disk icon"></span> Simpan</button> &nbsp;
                                <button type="button" class="button drop-shadow" onclick="batal_ubah();"><span class="mif-arrow-left icon"></span> Batal</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">
    loadDefaultUnitSekunderByOPD();

    function loadDefaultUnitSekunderByOPD(){
        $("select#ddOpd option").each(function() { this.selected = (this.text == 0); });
        $('#keywordCari').val("");
        loadDataListUnitSekunderByOPD('0','','','');
    }

    function loadDataListUnitSekunderByOPD(opd,keywordCari,page,ipp){
        $("#btnFilter").css("pointer-events", "none");
        $("#btnFilter").css("opacity", "0.4");
        $("#divListUkSekunder").css("pointer-events", "none");
        $("#divListUkSekunder").css("opacity", "0.4");
        var jc = $.confirm({
            title: '',
            closeIconClass: 'fa fa-close',
            closeIcon: null,
            closeIconClass: false,
            boxWidth: '200px',
            useBootstrap: false,
            content: function () {
                var data = new FormData();
                data.append('opd', opd);
                data.append('keywordCari', keywordCari);
                data.append('page', page);
                data.append('ipp', ipp);
                return $.ajax({
                    url: "<?php echo base_url('adminopd')."/drop_data_unit_kerja_sekunder/";?>",
                    data: data,
                    cache: false,
                    contentType: false,
                    processData: false,
                    method: 'POST',
                }).done(function (data) {
                    $("#divListUkSekunder").html(data);
                    $("#btnFilter").css("pointer-events", "auto");
                    $("#btnFilter").css("opacity", "1");
                    $("#divListUkSekunder").css("pointer-events", "auto");
                    $("#divListUkSekunder").css("opacity", "1");
                    $("#divListUkSekunder").find("script").each(function(i) {
                        eval($(this).text());
                    });
                }).fail(function(){
                    $("#divListUkSekunder").html('Error...telah terjadi kesalahan');
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
        var ddOpd = $('#ddOpd').val();
        var keywordCari = $("#keywordCari").val();
        loadDataListUnitSekunderByOPD(ddOpd,keywordCari,'','');
    });

    function pagingViewListLoad(parm,parm2){
        var ddOpd = $('#ddOpd').val();
        var keywordCari = $("#keywordCari").val();
        loadDataListUnitSekunderByOPD(ddOpd,keywordCari,parm,parm2);
    }

    var places, autocomplete, map;
    var markers = [];
    var markers_data = [];
    var countryRestrict = {'country': 'id'};
    var marker_unit_utama_in;
    var marker_unit_utama_out;

    $(document).ready( function () {
        var options2 = {
            url: function(phrase) {
                return "<?php echo base_url('adminopd/cari_lokasi_sekunder'); ?>";
            },

            getValue: function(element) {
                return element.nama;
            },

            list: {
                onClickEvent: function() {
                    var selectedItemValue = $("#txtIndukLokasi_Sekunder").getSelectedItemData().id_uk_sekunder_enc;
                    $("#idIndukLokasiSekunder").val(selectedItemValue);
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
                data.phrase = $("#txtIndukLokasi_Sekunder").val();
                data.tipe_unit = 'sekunder';
                data.opd = '<?php echo $this->session->userdata('id_skpd_enc'); ?>';
                return data;
            },

            requestDelay: 400,
            theme: "round"
        };

        $("#txtIndukLokasi_Sekunder").easyAutocomplete(options2);

        var options3 = {
            url: function(phrase) {
                return "<?php echo base_url('adminopd/cari_lokasi_sekunder'); ?>";
            },

            getValue: function(element) {
                return element.nama;
            },

            list: {
                onClickEvent: function() {
                    var selectedItemValue = $("#txtUnitKerjaUtama").getSelectedItemData().id_uk_sekunder_enc;
                    $("#idUnitKerjaUtama").val(selectedItemValue);
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
                data.phrase = $("#txtUnitKerjaUtama").val();
                data.tipe_unit = 'utama';
                data.opd = '<?php echo $this->session->userdata('id_skpd_enc'); ?>';
                return data;
            },

            requestDelay: 400,
            theme: "round"
        };

        $("#txtUnitKerjaUtama").easyAutocomplete(options3);
    });

    function initMapLocationSekunder(){

        var myOptions = {
            zoom: <?php echo($input_type==''?'15':'19') ?>,
            center: new google.maps.LatLng(<?php echo((isset($in_lat) and $in_lat!='')?$in_lat:'-6.598563'); ?>, <?php echo((isset($in_long) and $in_long!='')?$in_long:'106.799336'); ?>),
            mapTypeId: <?php echo($input_type==''?'google.maps.MapTypeId.ROADMAP':'google.maps.MapTypeId.HYBRID'); ?>
        }
        map = new google.maps.Map(document.getElementById("map_unit_sekunder_add"), myOptions);
        autocomplete = new google.maps.places.SearchBox( //Autocomplete
            /** @type {!HTMLInputElement} */ (
                document.getElementById('txtCariAlamat')), {
                //types: ['geocode'],
                componentRestrictions: countryRestrict
            });
        places = new google.maps.places.PlacesService(map);
        autocomplete.addListener('places_changed', onPlaceChanged);
        map.addListener('bounds_changed', function() {
            autocomplete.setBounds(map.getBounds());
        });

        <?php if($input_type=='ubah'): ?>
            var center_unit_utama = {lat: <?php echo $in_lat;?>, lng: <?php echo $in_long;?>};
            var image_in = 'http://maps.google.com/mapfiles/ms/icons/green-dot.png';
            marker_unit_utama_in = new google.maps.Marker({
                position: center_unit_utama,
                map: map,
                icon: image_in
            });
            markers_data.push(marker_unit_utama_in);

            var center_unit_utama_out = {lat: <?php echo $out_lat;?>, lng: <?php echo $out_long;?>};
            var image_out = 'http://maps.google.com/mapfiles/ms/icons/red-dot.png';
            marker_unit_utama_out = new google.maps.Marker({
                position: center_unit_utama_out,
                map: map,
                icon: image_out
            });
            markers_data.push(marker_unit_utama_out);

        <?php endif; ?>
    }

    function onPlaceChanged() {
        places = autocomplete.getPlaces();
        if (places.length == 0) {
            return;
        }
        markers.forEach(function(marker) {
            marker.setMap(null);
        });
        markers = [];
        var bounds = new google.maps.LatLngBounds();
        places.forEach(function(place) {
            if (!place.geometry) {
                console.log("Tempat yang dicari tidak memiliki nilai geometry");
                return;
            }

            var icon = {
                url: place.icon,
                size: new google.maps.Size(71, 71),
                origin: new google.maps.Point(0, 0),
                anchor: new google.maps.Point(17, 34),
                scaledSize: new google.maps.Size(25, 25)
            };

            markers.push(new google.maps.Marker({
                map: map,
                icon: icon,
                title: place.name,
                position: place.geometry.location
            }));

            if (place.geometry.viewport) {
                bounds.union(place.geometry.viewport);
            } else {
                bounds.extend(place.geometry.location);
            }
            console.log(place.name + ' ' + place.geometry.location);
            //map.panTo(place.geometry.location);
        });
        map.fitBounds(bounds);
        map.setZoom(17);
    }

    var markersIn = [];
    var markersOut = [];

    $("#btnPoiIn").click(function(){
        google.maps.event.clearListeners(map, 'click');
        // This event listener will call addMarker() when the map is clicked.
        map.addListener('click', function(event) {
            addMarkerIn(event.latLng);
            document.getElementById("coordinat_y_in").value = event.latLng.lat().toFixed(8);
            document.getElementById("coordinat_x_in").value = event.latLng.lng().toFixed(8);
        });
    });

    $("#btnPoiOut").click(function(){
        google.maps.event.clearListeners(map, 'click');
        map.addListener('click', function(event) {
            addMarkerOut(event.latLng);
            document.getElementById("coordinat_y_out").value = event.latLng.lat().toFixed(8);
            document.getElementById("coordinat_x_out").value = event.latLng.lng().toFixed(8);
        });
    });

    function addMarkerIn(location) {
        <?php if($input_type=='ubah'): ?>
            markers_data[0].setMap(null);
        <?php endif; ?>
        clearMarkersIn();
        markersIn = [];
        var image_in = 'http://maps.google.com/mapfiles/ms/icons/green-dot.png';
        var marker = new google.maps.Marker({
            position: location,
            map: map,
            icon: image_in
        });
        markersIn.push(marker);
    }

    function clearMarkersIn() {
        setMapOnAllIn(null);
    }

    function setMapOnAllIn(map) {
        for (var i = 0; i < markersIn.length; i++) {
            markersIn[i].setMap(map);
        }
    }

    function addMarkerOut(location) {
        <?php if($input_type=='ubah'): ?>
            markers_data[1].setMap(null);
        <?php endif; ?>
        clearMarkersOut();
        markersOut = [];
        var image_out = 'http://maps.google.com/mapfiles/ms/icons/red-dot.png';
        var marker = new google.maps.Marker({
            position: location,
            map: map,
            icon: image_out
        });
        markersOut.push(marker);
    }

    function clearMarkersOut() {
        setMapOnAllOut(null);
    }

    function setMapOnAllOut(map) {
        for (var i = 0; i < markersOut.length; i++) {
            markersOut[i].setMap(map);
        }
    }

    function clearIndukLokasiSekunder(){
        $("#idIndukLokasiSekunder").val('');
    }

    function clearUnitKerjaUtama(){
        $("#idUnitKerjaUtama").val('');
    }

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

    jQuery.validator.addMethod(
        "selectComboTipeWilayah",
        function (value, element)
        {
            if (element.value === "0") {
                return false;
            }else {
                return true;
            }
        },
        "*"
    );

    $("#frmAddUnitSekunderNew").validate({
        errorClass: 'errors',
        ignore: "",
        rules: {
            coordinat_y_in: {
                required: true
            },
            coordinat_x_in: {
                required: true
            },
            coordinat_y_out: {
                required: true
            },
            coordinat_x_out:{
                required: true
            },
            idUnitKerjaUtama: {
                required: true
            },
            namaLokasi: {
                required: true
            },
            txtAlamat: {
                required: true
            },
            txtTelepon: {
                required: true
            },
            txtEmail: {
                required: true
            }
        },
        messages: {
            coordinat_y_in: {
                required: "*"
            },
            coordinat_x_in: {
                required: "*"
            },
            coordinat_y_out: {
                required: "*"
            },
            coordinat_x_out:{
                required: "*"
            },
            idUnitKerjaUtama: {
                required: "*"
            },
            namaLokasi: {
                required: "*"
            },
            txtAlamat: {
                required: "*"
            },
            txtTelepon: {
                required: "*"
            },
            txtEmail: {
                required: "*",
                email: "*"
            }
        },
        errorPlacement: function(error, element) {
            switch (element.attr("name")) {
                case 'ddTipeWilayah':
                    error.insertAfter($("#err_tipe_wilayah"));
                    break;
                case 'idUnitKerjaUtama':
                    error.insertAfter($("#err_unit_utama"));
                    break;
                default:
                    error.insertAfter(element);
            }
        },
        submitHandler: function(form) {
            form.submit();
        }
    });

    function hapus_unit_kerja_lokasi(id_uk_sekunder_lokasi){
        $.confirm({
            title: 'Informasi',
            closeIconClass: 'fa fa-close',
            closeIcon: null,
            closeIconClass: false,
            useBootstrap: false,
            content: 'Anda yakin akan menghapus data unit kerja sekunder ini?',
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
                                data.append('id_unit_sekunder_enc', id_uk_sekunder_lokasi);
                                return $.ajax({
                                    url: "<?php echo base_url($usr)."/exec_hapus_unit_sekunder_lokasi/";?>",
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

    function ubah_unit_sekunder(id_uk_sekunder_lokasi){
        location.href = "<?php echo base_url().$usr."/unit_kerja_sekunder/" ?>" + id_uk_sekunder_lokasi;
    }

    function batal_ubah(){
        location.href = "<?php echo base_url().$usr."/unit_kerja_sekunder/" ?>";
    }

</script>

<script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBUn6I2tqpiL5IKsdP8YNErsUnBeNPn9O0&callback=initMapLocationSekunder&libraries=places">
</script>