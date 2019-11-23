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

<div class="row">
    <div class="cell-sm-3">
        <select id="ddTgl" name="ddTgl" class="cell-sm-12">
            <option value="0">Semua Tanggal</option>
            <?php
            for ($i=0;$i<=sizeof($listTgl)-2;$i++) {
                echo "<option value=".$listTgl[$i+1].">Tanggal ".$listTgl[$i+1]."</option>";
            }
            ?>
        </select>
    </div>

    <div class="cell-sm-3">
        <select id="ddStsProses" name="ddStsProses" class="cell-sm-12">
            <option value="0">Semua Status</option>
            <option value="1">Disetujui</option>
            <option value="2">Revisi</option>
            <option value="3">Ditolak</option>
            <option value="4">Belum diproses</option>
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

<div class="row" style="margin-top: 10px;">
    <div class="cell-sm-12">
        <?php
        $list_stk_skp = Modules::run('publicpegawai/call_skp');
        ?>
        <select id="ddKatKegiatan" name="ddKatKegiatan">
            <option value="0">Semua Kegiatan Tugas Jabatan pada SKP</option>
            <?php if ($list_stk_skp!=NULL and sizeof($list_stk_skp) > 0 and $list_stk_skp != ''): ?>
                <?php foreach ($list_stk_skp as $ls): ?>
                    <option value="<?php echo $ls->id; ?>"><?php echo $ls->kegiatan; ?></option>
                <?php endforeach; ?>
                <option value="-2">Instruksi Khusus Pimpinan (IKP) khusus JPT</option>
                <option value="-1">Tugas Tambahan</option>
                <option value="-4">Tugas Tambahan Khusus</option>
                <option value="-3">Penyesuaian Target Baru</option>
            <?php endif; ?>
        </select>
    </div>
</div>

<div class="row">
    <div class="cell-sm-12">
    <div id="divListAktifitasById"></div>
    </div>
</div>

<script type="text/javascript">
    loadDefaultListAktifitasById();

    function loadDefaultListAktifitasById(){
        $("select#ddTgl option").each(function() { this.selected = (this.text == 0); });
        $("select#ddStsProses option").each(function() { this.selected = (this.text == 0); });
        $("select#ddKatKegiatan option").each(function() { this.selected = (this.text == 0); });
        $('#keywordCari').val("");
        loadDataListAktifitasById('0','0','0','','','');
    }

    function loadDataListAktifitasById(ddTgl,ddStsProses,ddKatKegiatan,keywordCari,page,ipp){
        $("#btnFilter").css("pointer-events", "none");
        $("#btnFilter").css("opacity", "0.4");
        $("#divListAktifitasById").css("pointer-events", "none");
        $("#divListAktifitasById").css("opacity", "0.4");
        var jc = $.confirm({
            title: '',
            closeIconClass: 'fa fa-close',
            closeIcon: null,
            closeIconClass: false,
            boxWidth: '200px',
            useBootstrap: false,
            content: function () {
                var data = new FormData();
                data.append('idknjm', '<?php echo (isset($_GET['idknjm'])?$_GET['idknjm']:'');?>');
                data.append('ddTgl', ddTgl);
                data.append('ddStsProses', ddStsProses);
                data.append('ddKatKegiatan', ddKatKegiatan);
                data.append('keywordCari', keywordCari);
                data.append('page', page);
                data.append('ipp', ipp);
                return $.ajax({
                    url: "<?php echo base_url($usrsrc)."/drop_data_aktifitas_by_id/";?>",
                    data: data,
                    cache: false,
                    contentType: false,
                    processData: false,
                    method: 'POST',
                }).done(function (data) {
                    $("#divListAktifitasById").html(data);
                    $("#btnFilter").css("pointer-events", "auto");
                    $("#btnFilter").css("opacity", "1");
                    $("#divListAktifitasById").css("pointer-events", "auto");
                    $("#divListAktifitasById").css("opacity", "1");
                    $("#divListAktifitasById").find("script").each(function(i) {
                        eval($(this).text());
                    });
                }).fail(function(){
                    $("#divListAktifitasById").html('Error...telah terjadi kesalahan');
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
        var ddTgl = $('#ddTgl').val();
        var ddStsProses = $('#ddStsProses').val();
        var ddKatKegiatan = $('#ddKatKegiatan').val();
        var keywordCari = $("#keywordCari").val();
        loadDataListAktifitasById(ddTgl,ddStsProses,ddKatKegiatan,keywordCari,'','');
    });

    function pagingViewListLoad(parm,parm2){
        var ddTgl = $('#ddTgl').val();
        var ddStsProses = $('#ddStsProses').val();
        var ddKatKegiatan = $('#ddKatKegiatan').val();
        var keywordCari = $("#keywordCari").val();
        loadDataListAktifitasById(ddTgl,ddStsProses,ddKatKegiatan,keywordCari,parm,parm2);
    }

    function get_berkas(berkas){
        window.open('https://arsipsimpeg.kotabogor.go.id/ekinerja2/berkas/'+berkas, '_blank');
    }

    function ubah_aktifitas_kegiatan(id_knj_master, id_kegiatan){
        location.href = "<?php echo base_url().$usr."/ubah_aktifitas_kegiatan/" ?>" + id_knj_master + "/" + id_kegiatan;
    }

    function hapus_aktifitas_kegiatan(id){
        $.confirm({
            title: 'Informasi',
            closeIconClass: 'fa fa-close',
            closeIcon: null,
            closeIconClass: false,
            useBootstrap: false,
            content: 'Anda yakin akan menghapus data aktifitas ini?',
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
                                data.append('id_knj_kegiatan', id);
                                return $.ajax({
                                    url: "<?php echo base_url($usr)."/exec_hapus_kegiatan/";?>",
                                    data: data,
                                    cache: false,
                                    contentType: false,
                                    processData: false,
                                    method: "POST"
                                }).done(function( data ) {
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

    function hapus_berkas_kegiatan(id){
        $.confirm({
            title: 'Informasi',
            closeIconClass: 'fa fa-close',
            closeIcon: null,
            closeIconClass: false,
            useBootstrap: false,
            content: 'Anda yakin akan menghapus berkas aktifitas ini?',
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
                                data.append('id_knj_kegiatan', id);
                                return $.ajax({
                                    url: "<?php echo base_url($usr)."/exec_hapus_berkas_kegiatan/";?>",
                                    data: data,
                                    cache: false,
                                    contentType: false,
                                    processData: false,
                                    method: "POST"
                                }).done(function( data ) {
                                    if(data == 1){
                                        location.href = "<?php echo $url_reload ?>";
                                    }else{
                                        $.alert({
                                            closeIconClass: 'fa fa-close',
                                            closeIcon: null,
                                            closeIconClass: false,
                                            useBootstrap: false,
                                            content: 'Gagal menghapus berkas',
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

    function send_msg_whats_app(id){
        var jc = $.confirm({
            title: '',
            closeIconClass: 'fa fa-close',
            closeIcon: null,
            closeIconClass: false,
            boxWidth: '200px',
            useBootstrap: false,
            content: function () {
                var data = new FormData();
                data.append('id_knj_kegiatan', id);
                return $.ajax({
                    url: "<?php echo base_url($usr)."/exec_send_msg_whatsapp/";?>",
                    data: data,
                    cache: false,
                    contentType: false,
                    processData: false,
                    method: "POST"
                }).done(function( data ) {
                    if(data == 0){
                        $.alert({
                            closeIconClass: 'fa fa-close',
                            closeIcon: null,
                            closeIconClass: false,
                            useBootstrap: false,
                            content: 'Gagal menghapus berkas',
                            type: 'red'
                        });
                    }else{
                        var data;
                        $(JSON.parse(data)).each(function() {
                            result = this.code;
                            data = this.data;
                        });
                        if(result == 200){
                            var msg = '*eKinerja SIMPEG Kota Bogor* \n a.n ' + data[0].nama + '(' + data[0].nip_baru + ') telah mengisi data aktifitas sbb : \n' + 'SKP: ' + data[0].skp + '\nAktifitas: ' + data[0].kegiatan_rincian + '. Keterangan: ' + data[0].kegiatan_keterangan + '\nPada : ' + data[0].kegiatan_tanggal + ' Durasi: ' + data[0].durasi_menit + ' menit (' + data[0].kuantitas + ' ' + data[0].satuan + ')' +
                                '\nNomor Kontak: +' + data[0].ponsel_pegawai + '\nKunjungi : https://simpeg.kotabogor.go.id/ekinerja2?idknjm=' + data[0].id_knj_kegiatan_enc + '\nTerimakasih';
                            window.open('https://wa.me/'+data[0].ponsel_atasan+'?text='+encodeURIComponent(msg), '_blank');
                        }else{
                            $.alert({
                                closeIconClass: 'fa fa-close',
                                closeIcon: null,
                                closeIconClass: false,
                                useBootstrap: false,
                                content: 'Gagal mengambil informasi pesan WhatsApps',
                                type: 'red'
                            });
                        }
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

</script>
