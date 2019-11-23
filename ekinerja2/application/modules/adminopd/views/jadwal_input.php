
<!-- jQuery UI -->
<link href="<?php echo base_url('assets/jquery/dist/jquery-ui.css'); ?>" rel="stylesheet">
<script src="<?php echo base_url('assets/jquery/dist/jquery-ui.min.js'); ?>"></script>

<!-- MultipleDatesPicker -->
<script type="text/javascript" src="<?php echo base_url('assets/fullcalendar/moment.min.js'); ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/Multiple-Dates-Picker-for-jQuery-UI-latest/jquery-ui.multidatespicker.css'); ?>" >
<script type="text/javascript" src="<?php echo base_url('assets/Multiple-Dates-Picker-for-jQuery-UI-latest/jquery-ui.multidatespicker.js'); ?>"></script>

<!-- FullCalendar -->
<link rel="stylesheet" href="<?php echo base_url('assets/fullcalendar/fullcalendar.css'); ?>" >
<script type="text/javascript" src="<?php echo base_url('assets/fullcalendar/fullcalendar.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/fullcalendar/locale-all.js'); ?>"></script>

<link href="<?php echo base_url('assets/style_checkbox.css'); ?>" rel="stylesheet">

<style>
    .ui-datepicker-trigger{
        width: 32px;
    }

    .eac-round{
        width: 100%!important;
    }

    .eac-square input, .eac-round input {
        background-image: url("<?php echo base_url('assets/images/if_icon-111-search_314478-32.png'); ?>");
        background-repeat: no-repeat;
        background-position: right 10px center;
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

    #loading {
        display: none;
        position: absolute;
        top: 10px;
        right: 10px;
    }

    #calendar {
        max-width: 900px;
        margin: 40px auto;
        padding: 0 10px;
    }

</style>
<?php
if (isset($data_jadwal) and sizeof($data_jadwal) > 0 and $data_jadwal != ''){
    foreach ($data_jadwal as $lsdata) {
        $idspmt_jadwal = $lsdata->idjadwal_spmt;
        $tmt_spmt = $lsdata->tmt_spmt2;
        $judul = $lsdata->keterangan;
        $no_spmt = $lsdata->no_spmt_jadwal;
        $tgl_input = $lsdata->tgl_input2;
        $periode_bln = $lsdata->periode_bln;
        $periode_thn = $lsdata->periode_thn;
    }
}
?>

<?php if(($tx_result == 'true' and $tx_result!='') or (isset($_GET['add']) and $_GET['add']=='true')): ?>
    <script>
        function createInfoBox(t){
            if (t === undefined) {
                t = "";
            }
            var html_content =
                "<h3>Data sukses tersimpan</h3>" +
                "<p>Selanjutnya tentukan detail jadwal kerja khusus untuk penetapan nama-nama pegawai dan waktu pelaksanaannya.</p>";
            Metro.infobox.create(html_content, t);
        }

        $(function(){
            createInfoBox('success');
        });
    </script>
    <!--<div class="container bg-emerald fg-white" style="margin-bottom: 10px;">
        <div class="cell-12 text-center" style="font-size: small;"><strong>Selamat</strong> Data sukses tersimpan. <?php //echo ($upload_kode!=0?$upload_status:''); ?></div>
    </div>-->
<?php elseif($tx_result == 'false' and $tx_result!=''): ?>
    <div class="container bg-red fg-white" style="margin-bottom: 10px;">
        <div class="cell-12 text-center" style="font-size: small;"><strong>Maaf</strong> Data tidak tersimpan. <?php echo $title_result.' '.($upload_kode!=0?$upload_status:''); ?></div>
    </div>
<?php endif; ?>

<form action="" method="post" id="frmAddJadwalKhusus" novalidate="novalidate" enctype="multipart/form-data" class="custom-validation need-validation">
    <div style="background-color: lightgrey; border: 1px solid rgba(82,91,135,0.35);
    margin-bottom: 10px; text-align: center; font-size: small; font-weight: bold;">
        Surat Perintah Jadwal Khusus</div>
    <div class="row mb-2">
        <div class="cell-sm-6">
            <input id="idspmt_jadwal" name="idspmt_jadwal" type="hidden" value="<?php echo ((isset($idspmt_jadwal) and $idspmt_jadwal!='')?$idspmt_jadwal:''); ?>">
            <input id="idspmt_jadwal" name="idspmt_jadwal_enc" type="hidden" value="<?php echo ((isset($idspmt_jadwal_enc) and $idspmt_jadwal_enc!='')?$idspmt_jadwal_enc:''); ?>">
            <input id="submitok" name="submitok" type="hidden" value="1">
            <input id="input_type" name="input_type" type="hidden" value="<?php echo $input_type; ?>">
            <div class="row mb-2">
                <div class="cell-sm-11">
                    <!--TMT. Input SPMT :<br>
                    <div id="dvCalendar" class=""><input id="tmtJadwal" value="<?php //echo ((isset($tmt_spmt) and $tmt_spmt!='')?$tmt_spmt:date("Y/m/d")); ?>" name="tmtJadwal" type="text" data-role="calendarpicker" class="cell-sm-12" required ></div>
                    <small class="text-muted">TMT. Tugas pada Jadwal Khusus.</small><br>-->
                    Periode Bulan :<br>
                    <select id="ddBln" name="ddBln" data-role="select" class="cell-sm-12">
                        <option value="0">Pilih Bulan</option>
                        <?php
                        $i = 0;
                        for ($x = 0; $x <= 11; $x++) {
                            echo "<option value=".$listBln[$i][0].((isset($periode_bln) and $periode_bln==$listBln[$i][0])?' selected':'').">".$listBln[$i][1]."</option>";
                            $i++;
                        }
                        ?>
                    </select> <span id="msg_bln"></span>
                    <small class="text-muted">Bulan Laporan</small><br>
                    Periode Tahun : <br>
                    <select id="ddThn" name="ddThn" data-role="select" class="cell-sm-12">
                        <option value="0">Pilih Tahun</option>
                        <?php
                        $i = 0;
                        for ($x = 0; $x < sizeof($listThn); $x++) {
                            echo "<option value=".$listThn[$i].((isset($periode_thn) and $periode_thn==$listThn[$i])?' selected':'').">".$listThn[$i]."</option>";
                            $i++;
                        }
                        ?>
                    </select> <span id="msg_thn"></span>
                    <small class="text-muted">Tahun Laporan</small><br>
                    No. SPMT :<br>
                    <input type="text" id="txtNoSPMT" name="txtNoSPMT" class="cell-sm-12" value="<?php echo((isset($no_spmt) and $no_spmt!='')?$no_spmt:''); ?>">
                    <small class="text-muted">Nomor Surat Tugas SPMT.</small><br>
                    Keterangan :<br>
                    <textarea id="txtKeterangan" name="txtKeterangan" class="cell-sm-12" title="" rows="6" style="resize: none;
                    text-align: left;"><?php echo((isset($judul) and $judul!='')?$judul:''); ?></textarea>
                    <small class="text-muted">Judul Jadwal Khusus.</small>

                </div>
            </div>
        </div>
        <div class="cell-sm-6">
            Berkas SPMT :<br>
            <input class="cell-sm-12" type="file" id="fileSpmt" name="fileSpmt" style="font-size: small; padding-left: 0px;">
            <small class="text-muted">Berkas SPMT untuk bertugas.</small><br>
            <?php if($input_type=='ubah'): ?>
                <label><input id="chkUbahBerkasSPMT" name="chkUbahBerkasSPMT" type="checkbox" data-role="checkbox" data-style="2">Ubah Berkas SPMT</label><br>
            <?php endif;?>
            Tanggal Input Jadwal :<br>
            <input value="<?php echo((isset($tgl_input) and $tgl_input!='')?$tgl_input:date('d-m-Y'));  ?>" type="text" id="tglInput" name="tglInput" class="cell-sm-12" readonly>
            <small class="text-muted">Waktu dibuatnya jadwal khusus.</small><br>
            <div class="row" style="margin-top: 10px;">
                <div class="cell" style="margin-bottom: 10px;">
                    <button type="submit" class="button primary bg-green drop-shadow"><span class="mif-floppy-disk icon"></span> Simpan</button>
                    <?php if($input_type=='ubah'): ?>
                        &nbsp; <button type="button" class="button drop-shadow" onclick="batal_ubah();"><span class="mif-arrow-left icon"></span> Batal</button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</form>
<?php if($input_type=='ubah'): ?>
    <div style="background-color: lightgrey; border: 1px solid rgba(82,91,135,0.35);
    margin-bottom: 10px; text-align: center; font-size: small; font-weight: bold;">
        Pembaruan Detail Jadwal Khusus</div>
    <div id="tabs" style="font-size: 11pt;">
        <ul>
            <li><a href="#tabs-2">Input Jadwal Pegawai</a></li>
            <li><a href="#tabs-1">Lihat Kalender Jadwal</a></li>
        </ul>
        <div id="tabs-1">
            <div id='script-warning'></div>
            <div id='loading'>loading...</div>
            <div id='calRekap'></div>
            <button type="button" class="button drop-shadow" onclick="refresh_calendar();" style="margin-top: 10px; font-size: small;"><span class="mif-spinner4 icon"></span> Refresh Kalender</button>
        </div>
        <div id="tabs-2">
            <div id="jadwal_identity_add">
                <form action="" method="post" id="frmAddDetailJadwalKhusus" novalidate="novalidate" enctype="multipart/form-data" class="custom-validation need-validation">
                    <div class="row mb-2">
                        <div class="cell-sm-6">
                            Daftar Pegawai :<br>
                            <div class="row">
                                <div class="cell-8">
                                    <input type="text" id="keywordCari" name="keywordCari" placeholder="Ketikan Kata Kunci" class="cell-sm-12">
                                </div>
                                <div class="cell-2">
                                    <button id="btnCari" type="button" class="button primary bg-darkGray drop-shadow"><span class="mif-search icon"></span> Cari</button>
                                </div>
                            </div>

                            <div id="dvPegawaiList" style="border:1px solid #c0c2bb; height: 580px; margin-top: 10px;" class="cell-sm-12"></div>
                            <button id="btnPilih" type="button" class="button primary bg-darkBlue drop-shadow" style="font-size: small"><span class="mif-plus icon"></span> Pilih</button><br>

                            <script>
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
                                            data.append('id_skpd', '<?php echo $this->session->userdata('id_skpd_enc'); ?>');
                                            data.append('page', page);
                                            data.append('ipp', ipp);
                                            return $.ajax({
                                                url: "<?php echo base_url('adminopd')."/drop_data_list_pegawai/";?>",
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

                                function batal_ubah(){
                                    location.href = "<?php echo base_url()."adminopd/jadwal_kerja?click=true&tab=tbListJadwal" ?>";
                                }

                                function refresh_calendar(){
                                    $('#calRekap').fullCalendar('refetchEvents');
                                }
                            </script>

                            Pegawai yang dipilih :<br>
                            <div id="dvPegawaiPilih" style="border:1px solid #c0c2bb; overflow-y:auto;height: 500px;" class="cell-sm-12">
                                <table class="table bordered compact" id="tbl_pegawai" width="100%">
                                    <thead style="border-bottom: solid darkred 3px;">
                                    <tr>
                                        <td style="width: 5%;">
                                            <label class="input-control checkbox small-check" style="vertical-align: middle;">
                                                <input type="checkbox" id="checkAllPilih">
                                                <span class="check"></span><span class="caption"></span>
                                            </label>
                                        </td>
                                        <th style="text-align: center">Personil</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            Pegawai yang dipilih berjumlah :
                            <span id="jmlPegawaiPilih" style="font-weight: bold">0</span> Orang
                            <button id="btnHapus" type="button" class="button primary bg-darkRed drop-shadow" style="font-size: small"><span class="mif-bin icon"></span> Hapus</button><br>
                            Berperan sebagai : <br>
                            <input id="txtSebagai" name="txtSebagai" type="text" placeholder="" data-role="input" data-clear-button="false">
                            <small class="text-muted">Peran pegawai pada saat bekerja di jadwal khusus.</small><br>

                        </div>
                        <div class="cell-sm-6">
                            Jenis Jadwal : <br>
                            <select id="ddJenisJadwal" name="ddJenisJadwal" data-role="select" class="cell-sm-12">
                                <option value="0">Pilih Jenis Jadwal</option>
                                <?php if (isset($ref_jenis_jadwal) and sizeof($ref_jenis_jadwal) > 0 and $ref_jenis_jadwal != ''):  ?>
                                    <?php foreach ($ref_jenis_jadwal as $ls): ?>
                                        <option value="<?php echo $ls->id_jenis_jadwal; ?>"><?php echo $ls->jenis; ?></option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select> <span id="jqv_msg"></span>
                            <small class="text-muted">Jenis Jadwal Khusus.</small><br>
                            Tanggal Pelaksanaan : <br>
                            <input id="rdbTipeTanggal" name="rdbTipeTanggal" type="radio" value="rentang_hari" checked
                                   data-role="radio"
                                   data-style="2"
                                   data-caption="Berds. Waktu Rentang Hari (mm/dd/yyyy)"
                                   data-cls-caption="fg-cyan"
                                   data-cls-check="bd-cyan myCheck" style="font-size: 11pt;"><br>
                            <div class="row" style="margin-left: 0px;margin-right: 0px;">
                                <div class="cell-6">
                                    <div class="input cell-sm-12 calendar-picker">
                                        <input type="text" id="tglMulaiRentang" style="font-size: 11pt;" readonly>
                                    </div>
                                    <small class="text-muted">Tanggal Mulai.</small>
                                </div>
                                <div class="cell-6">
                                    <div class="input cell-sm-12 calendar-picker">
                                        <input type="text" id="tglSelesaiRentang" style="font-size: 11pt;" readonly>
                                    </div>
                                    <small class="text-muted">Tanggal Selesai.</small>
                                </div>
                            </div>
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
                            </script>

                            <input id="rdbTipeTanggal" name="rdbTipeTanggal" value="per_hari" type="radio"
                                   data-role="radio"
                                   data-style="2"
                                   data-caption="Berds. Waktu Harian"
                                   data-cls-caption="fg-cyan"
                                   data-cls-check="bd-cyan myCheck" style="font-size: 11pt;">
                            <br>
                            <div id="mdp-waktu-harian">
                                <script>
                                    $('#mdp-waktu-harian').multiDatesPicker({
                                        //stepMonths: 0,
                                        //minDate: dateToday,
                                        onSelect: function(dateText, inst) {
                                            var dateAsString = dateText; //the first parameter of this function
                                            //var dateAsObject = $(this).datepicker( 'getDate' ); //the getDate method
                                            //console.log(dateAsString);
                                            var a = arrTglPelaksanaanWktHarian.indexOf(dateAsString);
                                            if(a==-1){
                                                arrTglPelaksanaanWktHarian.push(dateAsString);
                                            }else{
                                                arrTglPelaksanaanWktHarian.splice(a, 1);
                                            }
                                            //console.log(arrTglPelaksanaanWktHarian);
                                        },
                                    });
                                </script>
                                <small class="text-muted">Tanggal Berlaku Aktifitas.</small><br>
                                Waktu Mulai : <br>
                                <div class="row" style="border: 1px solid rgba(71,71,72,0.35); margin-left: 0px;margin-right: 0px;">
                                    <div class="cell-2" style="margin-top: 5px;">Jam</div>
                                    <div class="cell-4">
                                        <select id="ddJamMulai" name="ddJamMulai">
                                            <?php for($i=0;$i<=sizeof($listJam)-1;$i++){ ?>
                                                <?php if ($listJam[$i] == ((isset($jam) and $jam != '')?$jam:date("H"))): ?>
                                                    <option value="<?php echo $listJam[$i]; ?>" selected><?php echo $listJam[$i]; ?></option>
                                                <?php else: ?>
                                                    <option value="<?php echo $listJam[$i]; ?>"><?php echo $listJam[$i]; ?></option>
                                                <?php endif; ?>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="cell-2" style="margin-top: 5px;">Menit</div>
                                    <div class="cell-4">
                                        <select id="ddMenitMulai" name="ddMenitMulai" style="margin-right: 0px;">
                                            <?php for($i=0;$i<=sizeof($listMenit)-1;$i++){ ?>
                                                <?php if ($listMenit[$i] == ((isset($menit) and $menit != '')?$menit:date("i"))): ?>
                                                    <option value="<?php echo $listMenit[$i]; ?>" selected><?php echo $listMenit[$i]; ?></option>
                                                <?php else: ?>
                                                    <option value="<?php echo $listMenit[$i]; ?>"><?php echo $listMenit[$i]; ?></option>
                                                <?php endif; ?>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <small class="text-muted">Jam mulai aktifitas.</small><br>
                                Waktu Selesai : <br>
                                <div class="row" style="border: 1px solid rgba(71,71,72,0.35); margin-left: 0px;margin-right: 0px;">
                                    <div class="cell-2" style="margin-top: 5px;">Jam</div>
                                    <div class="cell-4">
                                        <select id="ddJamSelesai" name="ddJamSelesai">
                                            <?php for($i=0;$i<=sizeof($listJam)-1;$i++){ ?>
                                                <?php if ($listJam[$i] == ((isset($jam) and $jam != '')?$jam:date("H"))): ?>
                                                    <option value="<?php echo $listJam[$i]; ?>" selected><?php echo $listJam[$i]; ?></option>
                                                <?php else: ?>
                                                    <option value="<?php echo $listJam[$i]; ?>"><?php echo $listJam[$i]; ?></option>
                                                <?php endif; ?>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="cell-2" style="margin-top: 5px;">Menit</div>
                                    <div class="cell-4">
                                        <select id="ddMenitSelesai" name="ddMenitSelesai" style="margin-right: 0px;">
                                            <?php for($i=0;$i<=sizeof($listMenit)-1;$i++){ ?>
                                                <?php if ($listMenit[$i] == ((isset($menit) and $menit != '')?$menit:date("i"))): ?>
                                                    <option value="<?php echo $listMenit[$i]; ?>" selected><?php echo $listMenit[$i]; ?></option>
                                                <?php else: ?>
                                                    <option value="<?php echo $listMenit[$i]; ?>"><?php echo $listMenit[$i]; ?></option>
                                                <?php endif; ?>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <small class="text-muted">Jam selesai aktifitas.</small><br>
                                Lokasi Kerja : <br>
                                <div class="row mb-2">
                                    <div class="cell-sm-12">
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
                                        <input id="tipe_lokasi" name="tipe_lokasi" type="hidden">
                                        <span id="err_msg_lokasi"></span> <small class="text-muted">Unit Kerja yang terdaftar sesuai Tipe</small>
                                        <div id="divInfoUnitSekunder"></div>
                                    </div>
                                </div>
                                <button id="btnAddDetailJadwal" name="btnAddDetailJadwal" type="submit" class="button primary bg-green drop-shadow" style="margin-top: 10px; font-size: small;">
                                    <span class="mif-calendar icon"></span> Update Jadwal </button>
                                <?php if($input_type=='ubah'): ?>
                                    &nbsp; <button type="button" class="button drop-shadow" onclick="batal_ubah();" style="margin-top: 10px; font-size: small;"><span class="mif-arrow-left icon"></span> Batal</button>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        var arrTglPelaksanaanWktHarian = [];

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

        $("#frmAddDetailJadwalKhusus").validate({
            errorClass: 'errors',
            ignore: "",
            rules: {
                txtSebagai: {
                    required: true
                },
                idLokasiSekunder: {
                    required: true
                }
            },
            messages: {
                idLokasiSekunder: {
                    required: "*"
                },
                txtSebagai: {
                    required: "*"
                }
            },
            errorPlacement: function(error, element) {
                switch (element.attr("name")) {
                    case 'ddJenisJadwal':
                        error.insertAfter($("#jqv_msg"));
                        break;
                    case 'idLokasiSekunder':
                        error.insertAfter($("#err_msg_lokasi"));
                        break;
                    default:
                        error.insertAfter(element);
                }
            },
            submitHandler: function(form) {
                var checkboxes = $("#dvPegawaiPilih input:checkbox");
                var jmlCheck = 0;
                var arrPegawai = [];

                for (var i = 1; i < checkboxes.length; i++) {
                    if(checkboxes[i].checked == true){
                        var b = arrPegawai.indexOf(checkboxes[i].value);
                        if(b==-1){
                            arrPegawai.push(checkboxes[i].value);
                        }
                        jmlCheck++;
                    }
                }
                if(jmlCheck <= 0){
                    alert('Pegawai harus dipilih dari daftar yang ada dan diceklis');
                }else{
                    var tglPelaksanaanTipe = $('input[name=rdbTipeTanggal]:checked', '#frmAddDetailJadwalKhusus').val();
                    var cekValid = true;
                    if(tglPelaksanaanTipe=='rentang_hari'){
                        if($("#tglMulaiRentang").val()=='' && $("#tglSelesaiRentang").val()==''){
                            cekValid = false;
                            alert('Pastikan tgl pelaksanaan berds. waktu rentang hari sudah ditentukan');
                        }
                    }else{
                        if(arrTglPelaksanaanWktHarian.length==0){
                            cekValid = false;
                            alert('Pastikan tgl pelaksanaan berds. waktu harian sudah ditentukan');
                        }
                    }
                    if(cekValid == true){
                        var jc = $.confirm({
                            title: '',
                            closeIconClass: 'fa fa-close',
                            closeIcon: null,
                            closeIconClass: false,
                            boxWidth: '200px',
                            useBootstrap: false,
                            content: function () {
                                var periode_bln = '<?php echo $periode_bln; ?>';
                                var periode_thn = '<?php echo $periode_thn; ?>';
                                var txtSebagai = $('#txtSebagai').val();
                                var ddJenisJadwal = $('#ddJenisJadwal').val();
                                var idLokasiSekunder = $('#idLokasiSekunder').val();
                                var tipe_lokasi = $('#tipe_lokasi').val();
                                var ddJamMulai = $('#ddJamMulai').val();
                                var ddMenitMulai = $('#ddMenitMulai').val();
                                var ddJamSelesai = $('#ddJamSelesai').val();
                                var ddMenitSelesai = $('#ddMenitSelesai').val();
                                var pegawaiPilih = arrPegawai;
                                var tglMulaiRentang = $("#tglMulaiRentang").val();
                                var tglSelesaiRentang = $("#tglSelesaiRentang").val();
                                var tglpelaksanaanPilih = arrTglPelaksanaanWktHarian;
                                var idspmt_jadwal = '<?php echo $idspmt_jadwal_enc; ?>';

                                var data = new FormData();
                                data.append('periode_bln', periode_bln);
                                data.append('periode_thn', periode_thn);
                                data.append('txtSebagai', txtSebagai);
                                data.append('ddJenisJadwal', ddJenisJadwal);
                                data.append('idLokasiSekunder', idLokasiSekunder);
                                data.append('tipe_lokasi', tipe_lokasi);
                                data.append('ddJamMulai', ddJamMulai);
                                data.append('ddMenitMulai', ddMenitMulai);
                                data.append('ddJamSelesai', ddJamSelesai);
                                data.append('ddMenitSelesai', ddMenitSelesai);
                                data.append('pegawaiPilih', pegawaiPilih);
                                data.append('tglPelaksanaanTipe', tglPelaksanaanTipe);
                                data.append('tglMulaiRentang', tglMulaiRentang);
                                data.append('tglSelesaiRentang', tglSelesaiRentang);
                                data.append('tglpelaksanaanPilih', tglpelaksanaanPilih);
                                data.append('idspmt_jadwal', idspmt_jadwal);

                                return jQuery.ajax({
                                    url: "<?php echo base_url('adminopd/insert_detail_jadwal_khusus/')?>",
                                    data: data,
                                    cache: false,
                                    contentType: false,
                                    processData: false,
                                    method: "POST"
                                }).done(function( data ){
                                    if(data == 200){
                                        $('#calRekap').fullCalendar('refetchEvents');
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
                }
            }
        });

        $( "#ddJenisJadwal" ).addClass( "selCboJnsJadwal" );

    </script>
<?php endif; ?>

<script>

    $(function(){
        <?php if($input_type=='ubah'): ?>
        $("#dvCalendar").addClass("disabled");
        var initialLocaleCode = 'id';
        $('#calRekap').fullCalendar({
            locale: initialLocaleCode,
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'listDay,listWeek,month'
            },
            views: {
                listDay: { buttonText: 'List Harian' },
                listWeek: { buttonText: 'List Mingguan' }
            },
            nextDayThreshold: "00:00:00",
            defaultDate: '<?php echo date('Y-m-d'); ?>',
            navLinks: true,
            editable: true,
            eventLimit: true, // allow "more" link,
            events: {
                url: "<?php echo base_url('adminopd') . "/drop_data_list_jadwal_trans_kalender/";?>",
                type: 'GET',
                data: function() {
                    return {
                        bln: $('#calRekap').fullCalendar('getDate').month()+1,
                        thn: $('#calRekap').fullCalendar('getDate').year()
                    };
                },
                error: function() {
                    $('#script-warning').show();
                }
            },
            loading: function(bool) {
                $('#loading').toggle(bool);
            }
        });

        $(".fc-prev-button").click(function(){
            var b = $('#calRekap').fullCalendar('getDate');
            var month_int = b.month()+1; //b.format('L')
            var year_int = b.year();
        });

        $(".fc-next-button").click(function(){
            var b = $('#calRekap').fullCalendar('getDate');
            var month_int = b.month()+1; //b.format('L')
            var year_int = b.year();
        });

        $( "#tabs" ).tabs();
        loadDefaultListPegawai();

        var arrPilih = [];
        $("#btnPilih").click(function () {
            var checkboxes = $("#dvPegawaiList input:checkbox");
            var idpegawai = "";
            for (var i = 1; i < checkboxes.length; i++) {
                if(checkboxes[i].checked == true){
                    var str = checkboxes[i].value;
                    var res = str.split("#");
                    idpegawai = res[0].trim();
                    var a = arrPilih.indexOf(idpegawai);
                    if(a==-1){
                        document.getElementById("jmlPegawaiPilih").innerHTML = parseInt(document.getElementById('jmlPegawaiPilih').innerHTML)+1;
                        arrPilih.push(idpegawai);
                        $('#tbl_pegawai tr:last').after('<tr id="rowTblPilih'+idpegawai+'"><td><label class="input-control checkbox small-check" style="margin-top: -2px;margin-bottom: -50px;vertical-align: top;"><input type="checkbox" value="'+idpegawai+'" id="chkIdPegawaiPilih[]" name="chkIdPegawaiPilih[]" checked><span class="check"></span><span class="caption"></span></label></td><td><span style="color: #002a80;font-weight: bold;">'+res[2]+'</span><br>'+res[1]+'</td></tr>');
                    }
                }
            }
            $(document).scrollTop($(document).height());
        });

        $("#checkAllPilih").change(function () {
            $("#dvPegawaiPilih input:checkbox").prop('checked', $(this).prop("checked"));
        });

        $("#btnHapus").click(function () {
            var checkboxes = $("#dvPegawaiPilih input:checkbox");
            var idpegawai = "";
            for (var i = 1; i < checkboxes.length; i++) {
                if(checkboxes[i].checked == true){
                    var str = checkboxes[i].value;
                    var res = str.split("#");
                    idpegawai = res[0].trim();
                    var a = arrPilih.indexOf(idpegawai);
                    arrPilih.splice(a, 1);
                    document.getElementById("jmlPegawaiPilih").innerHTML = parseInt(document.getElementById('jmlPegawaiPilih').innerHTML)-1;
                    $('#rowTblPilih'+idpegawai).remove();
                    $( "#checkAllPilih" ).prop( "checked", false );
                }
            }
        });
        <?php endif; ?>

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
                    loadInfoUnitSekunder(selectedItemValue, $('input[name=rdbTipeUnitKerja]:checked', '#frmAddDetailJadwalKhusus').val());
                    $("#tipe_lokasi").val($('input[name=rdbTipeUnitKerja]:checked', '#frmAddDetailJadwalKhusus').val());
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
                data.tipe_unit = $('input[name=rdbTipeUnitKerja]:checked', '#frmAddDetailJadwalKhusus').val();
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

    });

    var fileSpmt = 0;
    $('#fileSpmt').bind('change', function() {
        fileSpmt = this.files[0].size;
    });

    jQuery.validator.addMethod(
        "selCombo",
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

    $("#frmAddJadwalKhusus").validate({
        errorClass: 'errors',
        ignore: "",
        rules: {
            txtKeterangan: {
                required: true
            },
            txtNoSPMT: {
                required: true
            },
            tmtJadwal: {
                required: true
            },
            <?php if($input_type==''): ?>
            fileSpmt:{
                required: true
            }
            <?php endif;?>
        },
        messages: {
            txtKeterangan: {
                required: "*"
            },
            txtNoSPMT: {
                required: "*"
            },
            tmtJadwal: {
                required: "*"
            },
            <?php if($input_type==''): ?>
            fileSpmt:{
                required: "*"
            }
            <?php endif;?>
        },
        errorPlacement: function(error, element) {
            switch (element.attr("name")) {
                case 'ddBln':
                    error.insertAfter($("#msg_bln"));
                    break;
                case 'ddThn':
                    error.insertAfter($("#msg_thn"));
                    break;
                default:
                    error.insertAfter(element);
            }
        },
        submitHandler: function(form) {
            <?php if($input_type=='ubah'): ?>
            if ($('#chkUbahBerkasSPMT').is(":checked") == true){
                if(parseFloat(fileSpmt)==0){
                    alert('Harap lampirkan file SPMT Jadwal Khusus');
                }else{
                    form.submit();
                }
            }else{
                form.submit();
            }
            <?php else: ?>
            if (parseFloat(fileSpmt) > 2138471) {
                alert('Ukuran file terlalu besar');
            } else {
                form.submit();
            }
            <?php endif;?>
        }
    });

    $( "#ddBln" ).addClass( "selCombo" );
    $( "#ddThn" ).addClass( "selCombo" );

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
                }).done(function (data){
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

<script
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBUn6I2tqpiL5IKsdP8YNErsUnBeNPn9O0&callback=initMap&libraries=places">
</script>