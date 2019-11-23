<style>
    #map_unit_sekunder_add {
        width: 100%;
        height: 400px;
        background-color: grey;
        border: 1px solid grey;
    }

    .eac-round{
        width: 100%!important;
    }
</style>

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
            <input id="idp" name="idp" type="hidden" value="<?php echo $idp; ?>">
            Koordinat Dalam <button id="btnPoiIn" class="button primary square mini outline rounded" type="button">
                <span class="mif-pin" style="font-size: x-large;"></span></button><br>
            <input id="coordinat_y_in" name="coordinat_y_in" type="text" data-role="input" data-prepend="Latitude (Y):&nbsp;&nbsp;&nbsp; " data-clear-button="false" readonly>
            <input id="coordinat_x_in" name="coordinat_x_in" type="text" data-role="input" data-prepend="Longitude (X): " data-clear-button="false" readonly>
            <small class="text-muted">Titik Koordinat Batas Dalam Lokasi Wilayah.</small><br>
            Koordinat Luar <button id="btnPoiOut" class="button primary square mini outline rounded" type="button">
                <span class="mif-pin" style="font-size: x-large;"></span></button><br>
            <input id="coordinat_y_out" name="coordinat_y_out" type="text" data-role="input" data-prepend="Latitude (Y):&nbsp;&nbsp;&nbsp; " data-clear-button="false" readonly>
            <input id="coordinat_x_out" name="coordinat_x_out" type="text" data-role="input" data-prepend="Longitude (X): " data-clear-button="false" readonly>
            <small class="text-muted">Titik Koordinat Batas Luar Lokasi Wilayah.</small><br>
            Tipe Wilayah<br>
            <select id="ddTipeWilayah" name="ddTipeWilayah" data-role="select" class="cell-sm-12">
                <option value="0">Pilih Tipe Wilayah</option>
                <option value="Instansi">Instansi</option>
                <option value="Umum">Umum</option>
            </select><span id="err_tipe_wilayah"></span>
            <small class="text-muted">Tipe Wilayah Lokasi Sekunder.</small><br>
            Induk Lokasi Sekunder (Koordinator)<br>
            <input id="txtIndukLokasi_Sekunder" name="txtIndukLokasi_Sekunder" type="text" placeholder="Ketik nama atau alamat" style="width: 100%" onkeypress="clearIndukLokasiSekunder()">
            <input id="idIndukLokasiSekunder" name="idIndukLokasiSekunder" type="hidden">
            <span id="err_induk_lokasi"></span> <small class="text-muted">Lokasi Sekunder yang menjadi induk (Optional).</small><br>
            Unit Kerja Utama<br>
            <input id="txtUnitKerjaUtama" name="txtUnitKerjaUtama" type="text" placeholder="Ketik nama atau alamat" style="width:100%;" onkeypress="clearUnitKerjaUtama()">
            <input id="idUnitKerjaUtama" name="idUnitKerjaUtama" type="hidden">
            <span id="err_unit_utama"></span> <small class="text-muted">Unit Kerja Utama.</small><br>
        </div>
        <div class="cell-sm-6">
            Nama Lokasi<br>
            <input id="namaLokasi" name="namaLokasi" type="text" data-role="input" data-clear-button="false">
            <small class="text-muted">Nama Lokasi Sekunder.</small><br>
            Alamat<br>
            <textarea id="txtAlamat" name="txtAlamat" class="mb-1" title="" rows="3" style="resize: none; text-align: left;"></textarea>
            <small class="text-muted">Alamat lokasi sekunder.</small><br>
            Telepon<br>
            <input id="txtTelepon" name="txtTelepon" type="text" data-role="input" data-clear-button="false">
            <small class="text-muted">Telepon lokasi sekunder.</small><br>
            Email<br>
            <input id="txtEmail" name="txtEmail" type="text" data-role="input" data-clear-button="false">
            <small class="text-muted">Email lokasi sekunder.</small><br>
            <div style="background-color: lightgrey; border: 1px solid rgba(82,91,135,0.35);
    margin-bottom: 10px; text-align: center; font-size: small; font-weight: bold;">
                Surat Perintah Lokasi Kerja Lain</div>
            No. SPMT :<br>
            <input id="txtNoSPMT" name="txtNoSPMT" type="text" class="cell-sm-12">
            <small class="text-muted">Nomor Surat Tugas SPMT di lokasi kerja lain</small><br>
            TMT. bertugas pada lokasi kerja lain<br>
            <input id="tmtSpmt" value="" name="tmtSpmt" type="text" data-role="calendarpicker" class="cell-sm-12">
            <small class="text-muted">TMT. Tugas pada Lokasi Kerja Lain</small><br>
            Berkas SPMT :<br>
            <input class="cell-sm-12" type="file" id="fileSpmtBaru" name="fileSpmtBaru" style="font-size: small; padding-left: 0px;">
            <small class="text-muted">Berkas SPMT untuk bertugas</small><br>
            <div class="row" style="margin-top: 10px;">
                <div class="cell" style="margin-bottom: 10px;">
                    <button type="submit" class="button primary bg-green drop-shadow"><span class="mif-floppy-disk icon"></span> Simpan</button>
                </div>
            </div>
        </div>
    </div>
</form>


<script>
    var places, autocomplete, map;
    var markers = [];
    var countryRestrict = {'country': 'id'};

    $( function() {

    } );

    function initMapLocationSekunder(){

        //Add Map Lokasi Sekunder
        var myOptions = {
            zoom: 15,
            center: new google.maps.LatLng(-6.598563, 106.799336),
            mapTypeId: google.maps.MapTypeId.ROADMAP
        }
        map = new google.maps.Map(document.getElementById("map_unit_sekunder_add"), myOptions);

        // Create the autocomplete object and associate it with the UI input control.
        // Restrict the search to the default country, and to place type "cities".
        autocomplete = new google.maps.places.SearchBox( //Autocomplete
            /** @type {!HTMLInputElement} */ (
                document.getElementById('txtCariAlamat')), {
                //types: ['geocode'],
                componentRestrictions: countryRestrict
            });
        places = new google.maps.places.PlacesService(map);


        // When the user selects an address from the dropdown, populate the address
        // fields in the form.
        autocomplete.addListener('places_changed', onPlaceChanged);
        // Bias the SearchBox results towards current map's viewport.
        map.addListener('bounds_changed', function() {
            autocomplete.setBounds(map.getBounds());
        });
    }

    function onPlaceChanged() {
        // Get the place details from the autocomplete object.
        places = autocomplete.getPlaces();
        /*for (var component in componentForm) {
            document.getElementById(component).value = '';
            document.getElementById(component).disabled = false;
        }*/
        // Get each component of the address from the place details
        // and fill the corresponding field on the form.
        /*for (var i = 0; i < place.address_components.length; i++) {
            var addressType = place.address_components[i].types[0];
            if (componentForm[addressType]) {
                var val = place.address_components[i][componentForm[addressType]];
                document.getElementById(addressType).value = val;
            }
        }*/

        if (places.length == 0) {
            return;
        }
        // Clear out the old markers.
        markers.forEach(function(marker) {
            marker.setMap(null);
        });
        markers = [];
        // For each place, get the icon, name and location.
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

            // Create a marker for each place.
            markers.push(new google.maps.Marker({
                map: map,
                icon: icon,
                title: place.name,
                position: place.geometry.location
            }));

            if (place.geometry.viewport) {
                // Only geocodes have viewport.
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
    // Adds a marker to the map and push to the array.
    function addMarkerIn(location) {
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

    // Removes the markers from the map, but keeps them in the array.
    function clearMarkersIn() {
        setMapOnAllIn(null);
    }

    // Sets the map on all markers in the array.
    function setMapOnAllIn(map) {
        for (var i = 0; i < markersIn.length; i++) {
            markersIn[i].setMap(map);
        }
    }

    function addMarkerOut(location) {
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

    $(document).ready( function () {
        initMapLocationSekunder();

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

    function clearIndukLokasiSekunder(){
        $("#idIndukLokasiSekunder").val('');
    }

    function clearUnitKerjaUtama(){
        $("#idUnitKerjaUtama").val('');
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

    var fileSpmtNew = 0;
    $('#fileSpmtBaru').bind('change', function() {
        fileSpmtNew = this.files[0].size;
    });

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
                required: true,
                email: true
            },
            txtNoSPMT: {
                required: true
            },
            tmtSpmt: {
                required: true
            },
            fileSpmtBaru:{
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
            },
            txtNoSPMT: {
                required: "*"
            },
            tmtSpmt: {
                required: "*"
            },
            fileSpmtBaru: {
                required: "*"
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
            if (parseFloat(fileSpmtNew) > 2138471) {
                alert('Ukuran file terlalu besar');
            } else {
                form.submit();
            }
        }
    });

    $( "#ddTipeWilayah" ).addClass( "selectComboTipeWilayah" );

</script>

