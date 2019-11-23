<!-- EasyAutoComplete -->
<link rel="stylesheet" href="<?php echo base_url('assets/EasyAutocomplete-1.3.5/easy-autocomplete.css'); ?>" >
<script src="<?php echo base_url()?>assets/jquery/dist/jquery.validate.js"></script>

<script type="text/javascript" src="<?php echo base_url('assets/EasyAutocomplete-1.3.5/jquery.easy-autocomplete.js'); ?>"></script>

<!-- jQuery UI -->
<link href="<?php echo base_url('assets/jquery/dist/jquery-ui.css'); ?>" rel="stylesheet">
<script src="<?php echo base_url('assets/jquery/dist/jquery-ui.min.js'); ?>"></script>

<!-- MultipleDatesPicker -->
<script type="text/javascript" src="<?php echo base_url('assets/fullcalendar/moment.min.js'); ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/Multiple-Dates-Picker-for-jQuery-UI-latest/jquery-ui.multidatespicker.css'); ?>" >
<script type="text/javascript" src="<?php echo base_url('assets/Multiple-Dates-Picker-for-jQuery-UI-latest/jquery-ui.multidatespicker.js'); ?>"></script>

<style>
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
if (isset($data_item_lainnya) and sizeof($data_item_lainnya) > 0 and $data_item_lainnya != ''){
    foreach ($data_item_lainnya as $lsdata) {
        $id_item_lainnya_enc = $lsdata->id_item_lainnya_enc;
        $id_jenis_item = $lsdata->id_jenis_item;
        $tmt_mulai2 = $lsdata->tmt_mulai2;
        $tmt_selesai2 = $lsdata->tmt_selesai2;
        $keterangan = $lsdata->keterangan;
        $no_sk = $lsdata->no_sk;
        $waktu_input2 = $lsdata->waktu_input2;
        $nip_pegawai = $lsdata->nip_baru;
        $nama_pegawai = $lsdata->nama_pegawai;
        $unit_kerja = $lsdata->unit_kerja;
    }
}
?>

<?php //print_r($tx_result); ?>
<?php if($tx_result == 'true' and $tx_result!=''): ?>
    <div class="container bg-emerald fg-white" style="margin-bottom: 10px;">
        <div class="cell-12 text-center" style="font-size: small;"><strong>Selamat</strong> Data sukses tersimpan. <?php echo $title_result.' '.($upload_kode!=0?$upload_status:''); ?></div>
    </div>
<?php elseif($tx_result == 'false' and $tx_result!=''): ?>
    <div class="container bg-red fg-white" style="margin-bottom: 10px;">
        <div class="cell-12 text-center" style="font-size: small;"><strong>Maaf</strong> Data tidak tersimpan. <?php echo $title_result.' '.($upload_kode!=0?$upload_status:''); ?></div>
    </div>
<?php endif; ?>

<form action="" method="post" id="frmAddItemLainnya" novalidate="novalidate" enctype="multipart/form-data" class="custom-validation need-validation">
    <div class="row mb-2">
        <div class="cell-sm-5">
            <input id="id_item_lainnya_enc" name="id_item_lainnya_enc" type="hidden" value="<?php echo ((isset($id_item_lainnya_enc) and $id_item_lainnya_enc!='')?$id_item_lainnya_enc:''); ?>">
            <input id="submitok" name="submitok" type="hidden" value="1">
            <input id="input_type" name="input_type" type="hidden" value="<?php echo $input_type; ?>">
            <?php if($input_type=='ubah'):  ?>
                <strong>Ubah Data Item Kinerja Lainnya</strong><br>
            <?php endif; ?>
            Jenis Item Kinerja Lainnya :<br>
            <select id="ddItemLainnya" name="ddItemLainnya" class="cell-sm-12">
                <option value="0">Pilih Jenis Item Lainnya</option>
                <?php if (isset($ref_jenis_item_lain) and sizeof($ref_jenis_item_lain) > 0 and $ref_jenis_item_lain != ''):  ?>
                    <?php foreach ($ref_jenis_item_lain as $ls): ?>
                        <?php if ($ls->id_jenis_item == $id_jenis_item): ?>
                            <option value="<?php echo $ls->id_jenis_item; ?>" selected><?php echo $ls->jenis_item_lainnya; ?></option>
                        <?php else: ?>
                            <option value="<?php echo $ls->id_jenis_item; ?>"><?php echo $ls->jenis_item_lainnya; ?></option>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php endif; ?>
            </select> <span id="jqv_msg"></span>
            <small class="text-muted">Jenis Item Lainnya</small><br>
            Tgl. Mulai Berlaku :<br>
            <div class="input cell-sm-12 calendar-picker">
                <input type="text" id="tglMulaiBerlaku" name="tglMulaiBerlaku" value="<?php echo((isset($tmt_mulai2) and $tmt_mulai2!='')?$tmt_mulai2:''); ?>" style="font-size: 11pt;" readonly>
            </div>
            <small class="text-muted">TMT. Mulai</small><br>
            Tgl. Selesai Berlaku :<br>
            <div class="input cell-sm-12 calendar-picker">
                <input type="text" id="tglSelesaiBerlaku" name="tglSelesaiBerlaku" value="<?php echo((isset($tmt_selesai2) and $tmt_selesai2!='')?$tmt_selesai2:''); ?>" style="font-size: 11pt;" readonly>
            </div>
            <small class="text-muted">TMT. Selesai</small><br>
            Keterangan :<br>
            <textarea id="txtKeterangan" name="txtKeterangan" class="cell-sm-12" title="" rows="6" style="resize: none;
                text-align: left;"><?php echo((isset($keterangan) and $keterangan!='')?$keterangan:''); ?></textarea>
            <small class="text-muted">Deskripsi item kinerja lainnya </small><br>
            No. SK :<br>
            <input type="text" id="txtNoSk" name="txtNoSk" class="cell-sm-12" value="<?php echo((isset($no_sk) and $no_sk!='')?$no_sk:''); ?>">
            <small class="text-muted">Nomor SK item kinerja lainnya.</small><br>
            Berkas SK :<br>
            <input class="cell-sm-12" type="file" id="fileSk" name="fileSk" style="font-size: small; padding-left: 0px;">
            <small class="text-muted">Berkas SK item kinerja lainnya.</small><br>
            <?php if($input_type=='ubah'): ?>
                <label><input id="chkUbahBerkasSk" name="chkUbahBerkasSk" type="checkbox" data-role="checkbox" data-style="2">Ubah Berkas SK</label><br>
            <?php endif;?>
            Waktu Input Data :<br>
            <input value="<?php echo((isset($tgl_input) and $tgl_input!='')?$tgl_input:date('d-m-Y'));  ?>" type="text" id="tglInput" name="tglInput" class="cell-sm-12" readonly>
            <small class="text-muted">Tanggal input item kinerja lainnya</small>
        </div>
        <div class="cell-sm-7">
            <?php if($input_type=='ubah'): ?>
                <?php
                echo 'Pegawai saat ini:<br>';
                echo $nama_pegawai;
                echo '<br><br>';
                ?>
            <?php endif;?>
            Pilih Pegawai : <br>
            <div class="row">
                <div class="cell-8">
                    <input type="text" id="keywordCari" name="keywordCari" placeholder="Ketikan Kata Kunci" class="cell-sm-12">
                </div>
                <div class="cell-2">
                    <button id="btnCari" type="button" class="button primary bg-darkGray drop-shadow"><span class="mif-search icon"></span> Cari</button>
                </div>
            </div>
            <div class="row">
                <div class="cell-12">
                    <div id="dvPegawaiList" style="border:1px solid #c0c2bb; overflow-y: auto; overflow-x: hidden; height: 600px; margin-top: 10px; padding: 10px;"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="row" style="margin-top: 5px;">
        <div class="cell" style="margin-bottom: 5px;">
            <button type="submit" class="button primary bg-green drop-shadow"><span class="mif-floppy-disk icon"></span> Simpan</button>
        </div>
    </div>
</form>

<script>
    $(function(){
        loadDefaultListPegawai();
    });

    function loadDefaultListPegawai(){
        $('#keywordCari').val("");
        loadDataListPegawai('','','');
    }

    function loadDataListPegawai(keywordCari,page,ipp){
        $("#btnCari").css("pointer-events", "none");
        $("#btnCari").css("opacity", "0.4");
        $("#dvPegawaiList").css("pointer-events", "none");
        $("#dvPegawaiList").css("opacity", "0.4");

        var jc = $.confirm({
            title: '',
            closeIconClass: 'fa fa-close',
            closeIcon: null,
            closeIconClass: false,
            boxWidth: '200px',
            useBootstrap: false,
            content: function () {
                var data = new FormData();
                data.append('keywordCari', keywordCari);
                <?php if($this->session->userdata('user_level')=='admin_opd'): ?>
                data.append('id_skpd', '<?php echo $this->session->userdata('id_skpd_enc'); ?>');
                <?php else: ?>
                data.append('id_skpd', '');
                <?php endif; ?>
                data.append('page', page);
                data.append('ipp', ipp);
                return $.ajax({
                    url: "<?php echo base_url('adminopd')."/drop_data_list_pegawai/item_lainnya";?>",
                    data: data,
                    cache: false,
                    contentType: false,
                    processData: false,
                    method: 'POST',
                }).done(function (data) {
                    $("#dvPegawaiList").html(data);
                    $("#btnCari").css("pointer-events", "auto");
                    $("#btnCari").css("opacity", "1");
                    $("#dvPegawaiList").css("pointer-events", "auto");
                    $("#dvPegawaiList").css("opacity", "1");
                    $("#dvPegawaiList").find("script").each(function(i) {
                        eval($(this).text());
                    });
                }).fail(function(){
                    $("#dvPegawaiList").html('Error...telah terjadi kesalahan');
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

    $("#btnCari").click(function(){
        var keywordCari = $("#keywordCari").val();
        loadDataListPegawai(keywordCari,'','');
    });

    function pagingViewListLoad(parm,parm2){
        var keywordCari = $("#keywordCari").val();
        loadDataListPegawai(keywordCari,parm,parm2);
    }

    var dateToday = new Date();
    var dates = $("#tglMulaiBerlaku, #tglSelesaiBerlaku").datepicker({
        showOn: "button",
        buttonImage: "<?php echo base_url('assets/Multiple-Dates-Picker-for-jQuery-UI-latest/mdp-icon.png'); ?>",
        buttonImageOnly: true,
        buttonText: "Pilih tanggal",
        //defaultDate: "+1w",
        //changeMonth: true,
        numberOfMonths: 1,
        //minDate: dateToday,
        onSelect: function(selectedDate) {
            var option = this.id == "tglMulaiBerlaku" ? "minDate" : "maxDate",
                instance = $(this).data("datepicker"),
                date = $.datepicker.parseDate(instance.settings.dateFormat || $.datepicker._defaults.dateFormat, selectedDate, instance.settings);
            dates.not(this).datepicker("option", option, date);
        }
    });

    jQuery.validator.addMethod(
        "selCboJnsItemLainnya",
        function (value, element){
            if (element.value === "0") {
                return false;
            }else {
                return true;
            }
        },
        "*"
    );

    var fileSk = 0;
    $('#fileSk').bind('change', function() {
        fileSk = this.files[0].size;
    });

    $("#frmAddItemLainnya").validate({
        errorClass: 'errors',
        ignore: "",
        rules: {
            tglMulaiBerlaku: {
                required: true
            },
            tglSelesaiBerlaku: {
                required: true
            },
            txtNoSk: {
                required: true
            },
            txtKeterangan: {
                required: true
            },
            <?php if($input_type==''): ?>
            fileSk:{
                required: true
            }
            <?php endif;?>
        },
        messages: {
            tglMulaiBerlaku: {
                required: "*"
            },
            tglSelesaiBerlaku: {
                required: "*"
            },
            txtNoSk: {
                required: "*"
            },
            txtKeterangan: {
                required: "*"
            },
            <?php if($input_type==''): ?>
            fileSk:{
                required: "*"
            }
            <?php endif;?>
        },
        errorPlacement: function(error, element) {
            switch (element.attr("name")) {
                case 'ddItemLainnya':
                    error.insertAfter($("#jqv_msg"));
                    break;
                default:
                    error.insertAfter(element);
            }
        },
        submitHandler: function(form) {
            <?php if($input_type=='ubah'): ?>
            if ($('#chkUbahBerkasSk').is(":checked") == true){
                if(parseFloat(fileSk)==0){
                    alert('Harap lampirkan file SK');
                }else{
                    form.submit();
                }
            }else{
                form.submit();
            }
            <?php else: ?>
            if(parseFloat(fileSk)==0){
                alert('Harap lampirkan file SK');
            }else{
                form.submit();
            }
            <?php endif;?>
        }
    });

    $( "#ddItemLainnya" ).addClass( "selCboJnsItemLainnya" );

</script>