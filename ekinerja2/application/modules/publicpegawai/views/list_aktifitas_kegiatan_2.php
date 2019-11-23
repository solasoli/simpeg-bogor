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

<?php if (isset($aktifitas) and sizeof($aktifitas) > 0 and $aktifitas != ''){ ?>
    <div class="row mb-2">
        <div class="cell-md-8 my-search-wrapper"></div>
        <div class="cell-md-4 my-rows-wrapper"></div>
    </div>
    <!--data-pagination-wrapper=".my-pagination-wrapper"-->
    <table id="tblAktifitas" class="table row-hover row-border compact"
           style="margin-bottom: 0px;border-bottom: 1px solid rgba(71,71,72,0.35);"
           data-role="table"
           data-rows-steps="10, 15, 20, 30"
           data-rows="10"
           data-info-wrapper=".my-info-wrapper"
           data-search-wrapper=".my-search-wrapper"
           data-rows-wrapper=".my-rows-wrapper">
        <thead>
        <tr>
            <th>No</th>
            <th>Uraian Aktifitas</th>
        </tr>
        </thead>
        <tbody>
        <?php
            $i = 1;
            //echo $_SERVER['HTTP_USER_AGENT'];
        ?>
        <?php foreach ($aktifitas as $lsdata): ?>
            <tr>
                <td style="vertical-align: top;"><?php echo $i; ?>.</td>
                <td style="vertical-align: top">
                    <span style="color: saddlebrown; font-weight: bold;">
                        <?php echo $lsdata->kegiatan_rincian; ?>
                    </span>
                    <br>
                    <?php echo 'Keterangan: ' . $lsdata->kegiatan_keterangan; ?><br>
                    <?php echo '<span style="color: rosybrown">SKP: ' . $lsdata->kegiatan.'.</span> <br>Atasan: '.$lsdata->atsl_nama; ?>
                    <br>
                    <?php echo 'Waktu: '.$lsdata->kegiatan_tanggal2; ?>
                    Durasi: <?php echo $lsdata->durasi_menit; ?> menit <br>Output:
                    <?php echo $lsdata->kuantitas.' '.$lsdata->satuan; ?><br>
                    <?php if ($lsdata->approved == '') { ?>
                        <span class="rounded_box_default">Belum diproses</span>
                    <?php } elseif ($lsdata->approved == 1) { ?>
                        <span class="rounded_box_green">Disetujui</span>
                    <?php } elseif ($lsdata->approved == 2) { ?>
                        <span class="rounded_box_orange">Revisi</span>
                    <?php } else { ?>
                        <span class="rounded_box_red">Ditolak</span>
                    <?php } ?>

                    <?php
                    if($lsdata->approved == ''){
                    }elseif ($lsdata->approved == 1 or $lsdata->approved == 2 or $lsdata->approved == 3){
                        echo '<br>Catatan Atasan: '.($lsdata->catatan_approved==''?'-':$lsdata->catatan_approved).' ('.$lsdata->tgl_approved2.')';
                    }
                    ?><br>
                    <?php echo(($lsdata->approved == '' OR $lsdata->approved == 2)?'<a href="javascript:void(0)" onclick="ubah_aktifitas_kegiatan(\''.$lsdata->id_knj_master_enc.'\',\''.$lsdata->id_knj_kegiatan_enc.'\')"><span class="mif-pencil icon"></span> Ubah</a> &nbsp;':''); ?>
                    <a href="javascript:void(0)" onclick="hapus_aktifitas_kegiatan('<?php echo $lsdata->id_knj_kegiatan_enc; ?>')"><span class="mif-bin icon"></span> Hapus</a> &nbsp;
                    <?php
                    if($lsdata->url_berkas_eviden!=''){
                        echo '<a href="javascript:void(0)" onclick="get_berkas(\''.$lsdata->url_berkas_eviden.'\')"><span class="mif-download icon"></span> Download</a> &nbsp;'; ?>
                        <a href="javascript:void(0)" onclick="hapus_berkas_kegiatan('<?php echo $lsdata->id_knj_kegiatan_enc; ?>')"><span class="mif-cross icon"></span> Hapus Berkas</a>&nbsp;
                    <?php }
                    if($lsdata->approved == ''){
                        echo '<a href="javascript:void(0)" onclick="send_msg_whats_app(\''.$lsdata->id_knj_kegiatan_enc.'\')"><span class="mif-bubble icon"></span> WhatsApp</a>';
                    }
                    ?>
                </td>
            </tr>
            <?php $i++; ?>
        <?php endforeach; ?>
        </tbody>
    </table>
    <p class="text-center my-info-wrapper" style="font-size: small"></p>
    <div class="d-flex flex-justify-center my-pagination-wrapper pagination size-small"></div>
<?php }else{
    echo 'Data tidak ditemukan';
} ?>

<script>
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
