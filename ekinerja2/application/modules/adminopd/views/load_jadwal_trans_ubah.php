
<style>
    .ui-datepicker-trigger{
        width: 32px;
    }

    #ui-datepicker-div{
        font-size: 11pt;
    }

    #script-warning {
        display: none;
        background: #eee;
        border-bottom: 1px solid #ddd;
        padding: 0 10px;
        line-height: 40px;
        text-align: center;
        font-weight: bold;
        font-size: 12px;
        color: red;
    }

    #calendar {
        max-width: 900px;
        margin: 40px auto;
        padding: 0 10px;
    }

    .eac-round{
        width: 100%!important;
    }

    .eac-square input, .eac-round input {
        background-image: url("<?php echo base_url('assets/images/if_icon-111-search_314478-32.png'); ?>");
        background-repeat: no-repeat;
        background-position: right 10px center;
    }
</style>

<?php
    //print_r($data_jadwal_trans);
    if (isset($data_jadwal_trans) and sizeof($data_jadwal_trans) > 0 and $data_jadwal_trans != ''){
        foreach ($data_jadwal_trans as $lsdata){
            $idjadwal_trans_enc = $lsdata->id_trans_jdwl_enc;
            $id_jenis_jadwal = $lsdata->id_jenis_jadwal;
            $tgl_mulai = $lsdata->tgl_mulai;
            $tgl_selesai = $lsdata->tgl_selesai;
            $jam_mulai = $lsdata->jam_mulai;
            $jam_selesai = $lsdata->jam_selesai;
            $menit_mulai = $lsdata->menit_mulai;
            $menit_selesai = $lsdata->menit_selesai;
            $peran = $lsdata->jabatan;
        }
    }
?>
<form action="" method="post" id="frmUbahDetailJadwalKhusus"
      name="frmUbahDetailJadwal" novalidate="novalidate" enctype="multipart/form-data">
    <div class="row mb-2">
        <div class="cell-sm-4">
            <input id="idjadwal_trans_enc" name="idjadwal_trans_enc" type="hidden"
                   value="<?php echo ((isset($idjadwal_trans_enc) and $idjadwal_trans_enc!='')?$idjadwal_trans_enc:''); ?>">
            <input id="submitok" name="submitok" type="hidden" value="1">
            Jenis Jadwal : <br>
            <select id="ddJenisJadwalEd" name="ddJenisJadwalEd" data-role="select" class="cell-sm-12">
                <option value="0">Silahkan Pilih</option>
                <?php if (isset($ref_jenis_jadwal) and sizeof($ref_jenis_jadwal) > 0 and $ref_jenis_jadwal != ''):  ?>
                    <?php foreach ($ref_jenis_jadwal as $ls): ?>
                        <?php if($ls->id_jenis_jadwal==$id_jenis_jadwal): ?>
                            <option value="<?php echo $ls->id_jenis_jadwal; ?>" selected><?php echo $ls->jenis; ?></option>
                        <?php else: ?>
                            <option value="<?php echo $ls->id_jenis_jadwal; ?>"><?php echo $ls->jenis; ?></option>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php endif; ?>
            </select> <span id="jqv_msg"></span>
            <div class="row mb-2" style="margin-left: 0px;margin-right: 0px;margin-top: 10px;">
                <div class="cell-6" style="padding: 0px;">
                    Tgl. Mulai : <br>
                    <div class="input cell-sm-12 calendar-picker">
                        <input type="text" id="tglMulaiRentang" value="<?php echo((isset($tgl_mulai) and $tgl_mulai!='')?$tgl_mulai:''); ?>" style="font-size: 11pt;" readonly>
                    </div>
                </div>
                <div class="cell-6" style="padding: 0px; ">
                    Tgl. Selesai : <br>
                    <div class="input cell-sm-12 calendar-picker">
                        <input type="text" id="tglSelesaiRentang" value="<?php echo((isset($tgl_selesai) and $tgl_selesai!='')?$tgl_selesai:''); ?>" style="font-size: 11pt;" readonly>
                    </div>
                </div>
            </div>

            Waktu Mulai : <br>
            <div class="row">
                <div class="cell-6">
                    <select id="ddJamMulai" name="ddJamMulai">
                        <?php for($i=0;$i<=sizeof($listJam)-1;$i++){ ?>
                            <?php if ($listJam[$i] == ((isset($jam_mulai) and $jam_mulai != '')?$jam_mulai:date("H"))): ?>
                                <option value="<?php echo $listJam[$i]; ?>" selected><?php echo $listJam[$i]; ?></option>
                            <?php else: ?>
                                <option value="<?php echo $listJam[$i]; ?>"><?php echo $listJam[$i]; ?></option>
                            <?php endif; ?>
                        <?php } ?>
                    </select>
                    <small class="text-muted">Jam</small>
                </div>
                <div class="cell-6">
                    <select id="ddMenitMulai" name="ddMenitMulai" style="margin-right: 0px;">
                        <?php for($i=0;$i<=sizeof($listMenit)-1;$i++){ ?>
                            <?php if ($listMenit[$i] == ((isset($menit_mulai) and $menit_mulai != '')?$menit_mulai:date("i"))): ?>
                                <option value="<?php echo $listMenit[$i]; ?>" selected><?php echo $listMenit[$i]; ?></option>
                            <?php else: ?>
                                <option value="<?php echo $listMenit[$i]; ?>"><?php echo $listMenit[$i]; ?></option>
                            <?php endif; ?>
                        <?php } ?>
                    </select>
                    <small class="text-muted">Menit</small>
                </div>
            </div>

            Waktu Selesai : <br>
            <div class="row">
                <div class="cell-6">
                    <select id="ddJamSelesai" name="ddJamSelesai">
                        <?php for($i=0;$i<=sizeof($listJam)-1;$i++){ ?>
                            <?php if ($listJam[$i] == ((isset($jam_selesai) and $jam_selesai != '')?$jam_selesai:date("H"))): ?>
                                <option value="<?php echo $listJam[$i]; ?>" selected><?php echo $listJam[$i]; ?></option>
                            <?php else: ?>
                                <option value="<?php echo $listJam[$i]; ?>"><?php echo $listJam[$i]; ?></option>
                            <?php endif; ?>
                        <?php } ?>
                    </select>
                    <small class="text-muted">Jam</small>
                </div>

                <div class="cell-6">
                    <select id="ddMenitSelesai" name="ddMenitSelesai" style="margin-right: 0px;">
                        <?php for($i=0;$i<=sizeof($listMenit)-1;$i++){ ?>
                            <?php if ($listMenit[$i] == ((isset($menit_selesai) and $menit_selesai != '')?$menit_selesai:date("i"))): ?>
                                <option value="<?php echo $listMenit[$i]; ?>" selected><?php echo $listMenit[$i]; ?></option>
                            <?php else: ?>
                                <option value="<?php echo $listMenit[$i]; ?>"><?php echo $listMenit[$i]; ?></option>
                            <?php endif; ?>
                        <?php } ?>
                    </select>
                    <small class="text-muted">Menit</small>
                </div>
            </div>


            Berperan sebagai :<br>
            <input value="<?php echo((isset($peran) and $peran!='')?$peran:''); ?>" type="text" id="txtPeran" name="txtPeran" class="cell-sm-12">
            <small class="text-muted">Peran pegawai pada Jadwal Khusus.</small>
        </div>
        <div class="cell-sm-8">
            Lokasi Kerja : <br>
            <div id="tabsUnitJadwal" style="font-size: 12pt;">
                <ul>
                    <li><a href="#tabs-1"><small>Daftar Unit</small></a></li>
                    <li><a href="#tabs-2"><small>Tambah Lokasi</small></a></li>
                </ul>
                <div id="tabs-1" style="height: 295px; padding: 0px;">
                    <div id="dvDaftarUnitJdwlKhusus">
                        <div class="row mb-2">
                            <div class="cell-sm-7">
                                <?php if (isset($data_unit_jadwal) and sizeof($data_unit_jadwal) > 0 and $data_unit_jadwal != ''){ ?>
                                    <div style="height: 295px;overflow-x: auto; ">
                                        <table id="tblUkJadwalKhusus" class="table row-hover row-border compact"
                                               style="margin-bottom: 0px;border-bottom: 1px solid rgba(71,71,72,0.35);">
                                            <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Uraian</th>
                                            </tr>
                                            </thead>
                                            <?php $i = 1; ?>
                                            <?php foreach ($data_unit_jadwal as $lsdata): ?>
                                                <tr>
                                                    <td style="vertical-align: top;"><?php echo $i; ?>)</td>
                                                    <td>
                                                        <span class="mif-map2 icon"></span> <?php echo $lsdata->nama_unit; ?>
                                                        <?php echo ' ('.$lsdata->tipe_lokasi.')<br><small>'.$lsdata->alamat.'<br>'; ?>
                                                        <?php echo 'Koordinat Dalam: ('.$lsdata->in_lat.', '.$lsdata->in_long.') <br>Koordinat Luar: ('.$lsdata->out_lat.', '.$lsdata->out_long.') ' ?>
                                                        <?php if(sizeof($data_unit_jadwal) > 1): ?>
                                                            <br><a href="javascript:void(0)" onclick="hapus_unit_kerja_jadwal('<?php echo $lsdata->id_ukjdwl_enc; ?>','<?php echo $lsdata->id_trans_jdwal_enc; ?>')" style="color: darkred;"><span class="mif-bin icon"></span> Hapus</a> &nbsp;
                                                            <a href="javascript:void(0)" onclick="lihatPetaJadwalKhusus(<?php echo $lsdata->in_lat;?>,<?php echo $lsdata->in_long;?>,<?php echo $lsdata->out_lat;?>,<?php echo $lsdata->out_long;?>,'dvMapPreview');" style="color: dodgerblue;"><span class="mif-map2 icon"></span> Lihat Peta</a>
                                                        <?php endif;?>
                                                    </td>
                                                </tr>
                                                <?php
                                                    if($i==1){
                                                        echo "<script>lihatPetaJadwalKhusus(".$lsdata->in_lat.",".$lsdata->in_long.",".$lsdata->out_lat.",".$lsdata->out_long.", 'dvMapPreview');</script>";
                                                    }
                                                    $i++;
                                                ?>
                                            <?php endforeach; ?>
                                        </table>
                                    </div>
                                <?php }else{
                                    echo 'Data tidak ditemukan';
                                } ?>
                            </div>
                            <div class="cell-sm-5" style="padding-top: 10px;">
                                <span style="margin-left: -10px;">Pratinjau Peta:</span>
                                <div id="dvMapPreview" style="width: 100%;
                                    border: 1px solid rgba(71,71,72,0.35); margin-left: -10px;
                                    margin-top:0px;margin-right: 10px; margin-bottom: 10px; height: 250px;">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="tabs-2" style="height: 100%; padding: 0px;">
                    <div class="row mb-2" style="padding-top: 10px;">
                        <div class="cell-sm-6" style="padding-left: 25px;padding-top: 10px;">
                            <label style="font-weight: bold;"><input type="radio" name="rdbTipeUnitKerja" value="utama" checked> Tipe Utama</label>
                            <label style="font-weight: bold;"><input type="radio" name="rdbTipeUnitKerja" value="sekunder"> Tipe Sekunder</label><br>
                            <small class="text-muted">Tipe Lokasi Unit Kerja</small>
                        </div>
                        <div class="cell-sm-6">
                            <input id="txtLokasiSekunder" name="txtLokasiSekunder" type="text" placeholder="Ketik nama atau alamat" style="width: 100%;">
                            <small class="text-muted"> Unit Kerja terdaftar sesuai Tipe</small>
                            <input id="idLokasiSekunder" name="idLokasiSekunder" type="hidden">
                            <input id="tipe_lokasi" name="tipe_lokasi" type="hidden">
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="cell-sm-12">
                            <div id="divInfoUnitSekunder" style="padding: 10px;padding-bottom: 0px;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
    var dateToday = new Date();
    var dates = $("#tglMulaiRentang, #tglSelesaiRentang").datepicker({
        showOn: "button",
        buttonImage: "<?php echo base_url('assets/Multiple-Dates-Picker-for-jQuery-UI-latest/mdp-icon.png'); ?>",
        buttonImageOnly: true,
        buttonText: "Pilih tanggal",
        //defaultDate: "+1w",
        //changeMonth: true,
        numberOfMonths: 1,
        /*minDate: dateToday,*/
        onSelect: function(selectedDate) {
            var option = this.id == "tglMulaiRentang" ? "minDate" : "maxDate",
                instance = $(this).data("datepicker"),
                date = $.datepicker.parseDate(instance.settings.dateFormat || $.datepicker._defaults.dateFormat, selectedDate, instance.settings);
            dates.not(this).datepicker("option", option, date);
        }
    });

    $(function() {

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
                    loadInfoUnitSekunder(selectedItemValue, $('input[name=rdbTipeUnitKerja]:checked', '#frmUbahDetailJadwalKhusus').val());
                    $("#tipe_lokasi").val($('input[name=rdbTipeUnitKerja]:checked', '#frmUbahDetailJadwalKhusus').val());
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
                data.tipe_unit = $('input[name=rdbTipeUnitKerja]:checked', '#frmUbahDetailJadwalKhusus').val();
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


        jQuery.validator.addMethod(
            "selCboJnsJadwal",
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

        $("#frmUbahDetailJadwalKhusus").validate({
            errorClass: 'errors',
            ignore: "",
            rules: {
                txtPeran: {
                    required: true
                }
            },
            messages: {
                txtPeran: {
                    required: "*"
                }
            },
            errorPlacement: function(error, element) {
                switch (element.attr("name")) {
                    case 'ddJenisJadwalEd':
                        error.insertAfter($("#jqv_msg"));
                        break;
                    default:
                        error.insertAfter(element);
                }
            },
            submitHandler: function(form) {
                var jc = $.confirm({
                    title: '',
                    closeIconClass: 'fa fa-close',
                    closeIcon: null,
                    closeIconClass: false,
                    boxWidth: '200px',
                    useBootstrap: false,
                    content: function () {
                        var idjadwal_trans_enc = '<?php echo $idjadwal_trans_enc; ?>';
                        var id_jenis_jadwal = $('#ddJenisJadwalEd').val();
                        var tgl_mulai = $('#tglMulaiRentang').val();
                        var tgl_selesai = $('#tglSelesaiRentang').val();
                        var jam_mulai = $('#ddJamMulai').val();
                        var menit_mulai = $('#ddMenitMulai').val();
                        var jam_selesai = $('#ddJamSelesai').val();
                        var menit_selesai = $('#ddMenitSelesai').val();
                        var peran = $('#txtPeran').val();
                        var idLokasiSekunder = $('#idLokasiSekunder').val();
                        var tipe_lokasi = $('#tipe_lokasi').val();

                        var data = new FormData();
                        data.append('idjadwal_trans_enc', idjadwal_trans_enc);
                        data.append('id_jenis_jadwal', id_jenis_jadwal);
                        data.append('tgl_mulai', tgl_mulai);
                        data.append('tgl_selesai', tgl_selesai);
                        data.append('jam_mulai', jam_mulai);
                        data.append('menit_mulai', menit_mulai);
                        data.append('jam_selesai', jam_selesai);
                        data.append('menit_selesai', menit_selesai);
                        data.append('peran', peran);
                        data.append('idLokasiSekunder', idLokasiSekunder);
                        data.append('tipe_lokasi', tipe_lokasi);

                        return jQuery.ajax({
                            url: "<?php echo base_url('adminopd/update_detail_jadwal_khusus/')?>",
                            data: data,
                            cache: false,
                            contentType: false,
                            processData: false,
                            method: "POST"
                        }).done(function( data ){
                            if(data == 200){
                                pagingViewListLoad(<?php echo $curpage;?>,<?php echo $ipp;?>);
                                reloadUnitKerjaJadwal(idjadwal_trans_enc);
                                $.alert({
                                    title: 'Informasi',
                                    closeIconClass: 'fa fa-close',
                                    closeIcon: null,
                                    closeIconClass: false,
                                    useBootstrap: false,
                                    content: 'Sukses mengupdate Jadwal Khusus',
                                    type: 'green'
                                });
                            }else{
                                $.alert({
                                    title: 'Informasi',
                                    closeIconClass: 'fa fa-close',
                                    closeIcon: null,
                                    closeIconClass: false,
                                    useBootstrap: false,
                                    content: 'Gagal mengupdate data',
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
        });
    });

    $( "#ddJenisJadwalEd" ).addClass( "selCboJnsJadwal" );

    function submitUpdateJadwal(){
        $('#frmUbahDetailJadwalKhusus').trigger('submit');
    }

    function hapus_unit_kerja_jadwal(id_ukjdwl_enc, id_trans_jdwal_enc){
        $.confirm({
            title: 'Informasi',
            closeIconClass: 'fa fa-close',
            closeIcon: null,
            closeIconClass: false,
            useBootstrap: false,
            content: 'Anda yakin akan menghapus data lokasi kerja pada jadwal ini?',
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
                                data.append('id_ukjdwl_enc', id_ukjdwl_enc);
                                return $.ajax({
                                    url: "<?php echo base_url('adminopd')."/exec_hapus_unit_kerja_jadwal/";?>",
                                    data: data,
                                    cache: false,
                                    contentType: false,
                                    processData: false,
                                    method: "POST"
                                }).done(function( data ){
                                    if(data == 1){
                                        pagingViewListLoad(<?php echo $curpage;?>,<?php echo $ipp;?>);
                                        reloadUnitKerjaJadwal(id_trans_jdwal_enc);
                                    }else{
                                        $.alert({
                                            title: 'Informasi',
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

    $( "#tabsUnitJadwal" ).tabs();

    function reloadUnitKerjaJadwal(id_trans_jdwal_enc){
        $("#dvDaftarUnitJdwlKhusus").css("pointer-events", "none");
        $("#dvDaftarUnitJdwlKhusus").css("opacity", "0.4");
        $.ajax({
            method: "POST",
            url: "<?php echo base_url('adminopd')."/list_unit_kerja_jadwal/";?>",
            data: { id_trans_jdwal_enc: id_trans_jdwal_enc},
            dataType: "html"
        }).done(function( data ) {
            $("#dvDaftarUnitJdwlKhusus").html(data);
            $("#dvDaftarUnitJdwlKhusus").find("script").each(function(i) {
                eval($(this).text());
            });
            $("#dvDaftarUnitJdwlKhusus").css("pointer-events", "auto");
            $("#dvDaftarUnitJdwlKhusus").css("opacity", "1");
            $('#dvContentUbahJadwal').scrollTop(0);
        });
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
                    url: "<?php echo base_url('adminopd/get_info_unit_Sekunder2/');?>",
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

</script>