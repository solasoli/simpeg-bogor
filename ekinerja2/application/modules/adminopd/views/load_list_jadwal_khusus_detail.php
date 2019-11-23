
<?php if(isset($drop_data_list) and sizeof($drop_data_list) > 0 and $drop_data_list != ''): ?>
    <?php if(isset($pgDisplay)): ?>
        <?php if($numpage > 0): ?>
            <?php
                if($chkCekBerkasRil=='true') {
                    $connection = ssh2_connect('103.14.229.15');
                    ssh2_auth_password($connection, 'rommonz', 'mony3Tmony3T');
                    $sftp = ssh2_sftp($connection);
                }
            ?>
            <div class="row" style="margin-top: 20px;">
                <div class="cell-sm-12">
                    Halaman ke <?php echo $curpage; ?> dari <?php echo $numpage; ?> | Jumlah : <?php echo $jmlData; ?>
                </div>
            </div>
            <?php echo $pgDisplay; ?>
        <?php endif; ?>
    <?php endif; ?>

<table id="tblJadwalDetail" class="table row-hover row-border compact">
    <thead>
        <tr>
            <th>No</th>
            <th>Uraian Jadwal</th>
        </tr>
    </thead>
    <tbody>
    <?php
    $i = 1;
    $halaman = $start_number;
    foreach($drop_data_list as $lsdata) { ?>
        <tr>
            <td style="vertical-align: top;">
                <?php echo $halaman+$i; ?>)
            </td>
            <td>
                <div class="row mb-2">
                    <div class="cell-sm-12">
                        <div style="background-color: rgba(205,205,208,0.35);padding: 5px; border: 1px solid rgba(82,91,135,0.35); font-size: 11pt;">
                            No.SPMT: <?php echo $lsdata->no_spmt_jadwal; ?>. Jenis: <span style="color: green; font-weight: bold;"><?php echo $lsdata->jenis; ?></span><br>
                            Kegiatan: <?php echo $lsdata->keterangan; ?><br>
                            Tgl.Mulai: <?php echo $lsdata->tgl_mulai; ?>, Tgl.Selesai: <?php echo $lsdata->tgl_selesai; ?> |
                            Jam Mulai: <?php echo $lsdata->jam_mulai; ?>, Jam Selesai: <?php echo $lsdata->jam_selesai; ?>
                        </div>
                    </div>
                </div>
                <div class="row mb-2" style="margin-top: -6px;">
                    <div class="cell-sm-12">
                        <div style="padding: 5px; border: 1px solid rgba(82,91,135,0.35); font-size: 11pt;">
                            Petugas : <span style="color: saddlebrown"><?php echo $lsdata->nama.' ('.$lsdata->nip_baru.')'; ?></span>. Golongan: <?php echo $lsdata->pangkat_gol; ?><br>
                            Sebagai <?php echo ($lsdata->jabatan==''?'':' '.$lsdata->jabatan.' '); ?> di Lokasi Kerja: <?php echo ($lsdata->unit_kerja==''?'Belum ada lokasi kerja':$lsdata->unit_kerja); ?><br>
                            Oleh : <?php echo $lsdata->nama_inputer.' ('.$lsdata->nip_inputer.')'; ?>
                            <div class="row mb-2">
                                <div class="cell-sm-6">
                                    <div style="font-size: 11pt;">
                                        <?php
                                        if($lsdata->berkas_spmt!=''){
                                            if($chkCekBerkasRil=='true') {
                                                if (file_exists('ssh2.sftp://' . $sftp . '/var/www/html/ekinerja2/berkas/'.$lsdata->berkas_spmt)) {
                                                    echo '<a href="javascript:void(0)" onclick="get_berkas(\''.$lsdata->berkas_spmt.'\')"><span class="mif-download icon"></span> Download Berkas SPMT</a>';
                                                }else{
                                                    echo '<span style="color: red;">Belum ada berkas yang terupload</span>';
                                                }
                                            }else{
                                                echo '<a href="javascript:void(0)" onclick="get_berkas(\''.$lsdata->berkas_spmt.'\')"><span class="mif-download icon"></span> Download Berkas SPMT</a>';
                                            }
                                        }
                                        ?>&nbsp;
                                        <a href="javascript:void(0)" onclick="lihat_peta('<?php echo $lsdata->id_tj_enc; ?>','<?php echo $lsdata->nama;?>','<?php echo $lsdata->keterangan; ?>', '<?php echo $lsdata->jenis; ?>', 'Mulai: <?php echo $lsdata->tgl_mulai.' '.$lsdata->jam_mulai; ?>, Selesai: <?php echo $lsdata->tgl_selesai.' '.$lsdata->jam_selesai; ?>');"><span class="mif-map2 icon"></span> Lihat Peta</a>
                                    </div>
                                </div>
                                <div class="cell-sm-6" style="text-align: right;">
                                    <div style="font-size: 11pt;">
                                        <?php if((strpos($this->session->userdata('opd'), 'Dinas Pekerjaan Umum')!==false) and $lsdata->jenis=='Jam Kerja Beda'): ?>
                                            <button id="btnAddJamPlg" name="btnAddJamPlg" onclick="set_absen_jam_pulang('<?php echo $lsdata->id_pegawai_enc; ?>','<?php echo $lsdata->tgl_selesai.' '.$lsdata->jam_selesai; ?>', 'PUPR');"
                                                    type="button" class="button primary bg-lightBlue drop-shadow small rounded" <?php echo($this->session->userdata('id_pegawai')==$lsdata->inputer?'':'disabled'); ?>>
                                                <span class="mif-plus icon"></span> Absen Pulang </button>
                                            <button id="btnDelJamPlg" name="btnDelJamPlg" onclick="del_absen_jam_pulang('<?php echo $lsdata->id_pegawai_enc; ?>','<?php echo $lsdata->tgl_selesai.' '.$lsdata->jam_selesai; ?>')"
                                                    type="button" class="button primary bg-lightRed drop-shadow small rounded" <?php echo($this->session->userdata('id_pegawai')==$lsdata->inputer?'':'disabled'); ?>>
                                                <span class="mif-minus icon"></span> Absen Pulang </button>
                                        <?php endif; ?>
                                        <button id="btnUbahUkSekunder" name="btnUbahUkSekunder" onclick="ubah_jadwal_detail('<?php echo $lsdata->id_tj_enc; ?>','<?php echo $lsdata->nama;?>','<?php echo $lsdata->keterangan; ?>', '<?php echo $lsdata->jenis; ?>', 'Mulai: <?php echo $lsdata->tgl_mulai.' '.$lsdata->jam_mulai; ?>, Selesai: <?php echo $lsdata->tgl_selesai.' '.$lsdata->jam_selesai; ?>',<?php echo $curpage;?>,<?php echo $ipp;?>);"
                                                type="button" class="button primary bg-green drop-shadow small rounded" <?php echo($this->session->userdata('id_pegawai')==$lsdata->inputer?'':'disabled'); ?>>
                                            <span class="mif-pencil icon"></span> Ubah </button>
                                        <button id="btnHapusUkSekunder" name="btnUbahUkSekunder" onclick="hapus_jadwal_detail('<?php echo $lsdata->id_tj_enc; ?>',<?php echo $curpage;?>,<?php echo $ipp;?>)"
                                                type="button" class="button primary bg-darkRed drop-shadow small rounded" <?php echo($this->session->userdata('id_pegawai')==$lsdata->inputer?'':'disabled'); ?>>
                                            <span class="mif-bin icon"></span> Hapus </button>

                                        <div class="dialog pos-fixed pos-center data-remove-on-close w-75" data-role="dialog" id="dialogUbahJadwalDetail" style="overflow-y: auto">
                                            <div class="dialog-title">
                                                <div>Ubah Data Detail Jadwal Khusus</div>
                                                <div id="sp_nama_ed" style="font-size: small;margin-top: 0px;color: blue;font-weight: bold;"></div>
                                                <div id="sp_kegiatan_ed" style="font-size: small;margin-top: 0px;"></div>
                                            </div>
                                            <div id="dvContentUbahJadwal" class="dialog-content" style="overflow-y: auto;">
                                                <div id="dv_form_ubah_jadwal"></div>
                                            </div>
                                            <div class="dialog-actions" style="text-align: right"></span>
                                                <button id="btnEdDetailJadwal" name="btnEdDetailJadwal<?php //echo $lsdata->id_tj_enc; ?>" type="submit"
                                                        class="button primary bg-green rounded" style="font-size: small;" onclick="submitUpdateJadwal();">
                                                    <span class="mif-floppy-disk icon"></span> Update Jadwal </button>
                                                <button class="button js-dialog-close rounded"><span class="mif-cross icon"> Tutup</button>
                                            </div>
                                        </div>

                                        <div class="dialog pos-fixed pos-center data-remove-on-close" data-role="dialog" id="dialogLihatPeta" style="overflow-y: auto">
                                            <div class="dialog-title">
                                                <div>Peta Lokasi Kerja Jadwal Khusus</div>
                                                <div id="sp_nama" style="font-size: small;margin-top: 0px;color: blue;font-weight: bold;"></div>
                                                <div id="sp_kegiatan" style="font-size: small;margin-top: 0px;"></div>
                                            </div>
                                            <div class="dialog-content" style="overflow-y: auto;">
                                                    <div id="dv_map_jadwal_khusus"></div>
                                            </div>
                                            <div class="dialog-actions" style="text-align: right"></span>
                                                <button class="button js-dialog-close rounded"><span class="mif-cross icon"> Tutup</button>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </td>
        </tr>
        <?php
        $i++;
    } ?>
    </tbody>
</table>

    <script>
        function lihat_peta(idjadwal_trans_enc, nama, kegiatan, jenis, waktu){
            $('#sp_nama').html(nama);
            $('#sp_kegiatan').html('Kegiatan: ' + kegiatan + ' (' + jenis + ')' + '<br>' + waktu);
            $("#dv_map_jadwal_khusus").html('');
            var jc = $.confirm({
                title: '',
                closeIconClass: 'fa fa-close',
                closeIcon: null,
                closeIconClass: false,
                boxWidth: '200px',
                useBootstrap: false,
                content: function () {
                    var data = new FormData();
                    data.append('idjadwal_trans_enc', idjadwal_trans_enc);
                    return $.ajax({
                        url: "<?php echo base_url('adminopd')."/drop_lokasi_unit_by_idjadwal_trans/";?>",
                        data: data,
                        cache: false,
                        contentType: false,
                        processData: false,
                        method: 'POST',
                    }).done(function (data) {
                        $("#dv_map_jadwal_khusus").html(data);
                        $("#dv_map_jadwal_khusus").find("script").each(function(i) {
                            eval($(this).text());
                        });
                    }).fail(function(){
                        $("#dv_map_jadwal_khusus").html('Error...telah terjadi kesalahan');
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
            Metro.dialog.open('#dialogLihatPeta');
        }

        function lihatPetaJadwalKhusus(in_lat, in_lng, out_lat, out_lng, id){
            var point_in = {lat: in_lat, lng: in_lng};
            var map_dialog = new google.maps.Map(
                document.getElementById(id), {zoom: 19, center: point_in, mapTypeId: 'hybrid'});
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
        }

        function ubah_jadwal_detail(idjadwal_trans_enc, nama, kegiatan, jenis, waktu, curpage, ipp){
            $('#sp_nama_ed').html(nama);
            $('#sp_kegiatan_ed').html('Kegiatan: ' + kegiatan + ' (' + jenis + ')' + '<br>' + waktu);
            $("#dv_form_ubah_jadwal").html('');

            var dateToday = new Date();
            var dates = $("#tglMulaiRentang, #tglSelesaiRentang").datepicker({
                showOn: "button",
                buttonImage: "<?php echo base_url('assets/Multiple-Dates-Picker-for-jQuery-UI-latest/mdp-icon.png'); ?>",
                buttonImageOnly: true,
                buttonText: "Pilih tanggal",
                //defaultDate: "+1w",
                //changeMonth: true,
                numberOfMonths: 1,
                minDate: dateToday,
                onSelect: function(selectedDate) {
                    var option = this.id == "tglMulaiRentang" ? "minDate" : "maxDate",
                        instance = $(this).data("datepicker"),
                        date = $.datepicker.parseDate(instance.settings.dateFormat || $.datepicker._defaults.dateFormat, selectedDate, instance.settings);
                    dates.not(this).datepicker("option", option, date);
                }
            });

            var jc = $.confirm({
                title: '',
                closeIconClass: 'fa fa-close',
                closeIcon: null,
                closeIconClass: false,
                boxWidth: '200px',
                useBootstrap: false,
                content: function () {
                    var data = new FormData();
                    data.append('idjadwal_trans_enc', idjadwal_trans_enc);
                    data.append('curpage', curpage);
                    data.append('ipp', ipp);
                    return $.ajax({
                        url: "<?php echo base_url('adminopd')."/drop_ubah_jadwal_detail_by_id/";?>",
                        data: data,
                        cache: false,
                        contentType: false,
                        processData: false,
                        method: 'POST',
                    }).done(function (data) {
                        $("#dv_form_ubah_jadwal").html(data);
                        $("#dv_form_ubah_jadwal").find("script").each(function(i) {
                            eval($(this).text());
                        });
                    }).fail(function(){
                        $("#dv_form_ubah_jadwal").html('Error...telah terjadi kesalahan');
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

            Metro.dialog.open('#dialogUbahJadwalDetail');
        }

        function hapus_jadwal_detail(idjadwal_trans_enc, curpage, ipp){
            $.confirm({
                title: 'Informasi',
                closeIconClass: 'fa fa-close',
                closeIcon: null,
                closeIconClass: false,
                useBootstrap: false,
                content: 'Anda yakin akan menghapus data detail jadwal ini?',
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
                                    data.append('idjadwal_trans_enc', idjadwal_trans_enc);
                                    return $.ajax({
                                        url: "<?php echo base_url('adminopd')."/exec_hapus_jadwal_trans/";?>",
                                        data: data,
                                        cache: false,
                                        contentType: false,
                                        processData: false,
                                        method: "POST"
                                    }).done(function( data ){
                                        if(data == 1){
                                            pagingViewListLoad(curpage, ipp);
                                        }else{
                                            $.alert({
                                                closeIconClass: 'fa fa-close',
                                                closeIcon: null,
                                                closeIconClass: false,
                                                useBootstrap: false,
                                                content: 'Gagal menghapus data',
                                                type: 'red'
                                            });
                                            pagingViewListLoad(curpage, ipp);
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

        function get_berkas(berkas){
            window.open('https://arsipsimpeg.kotabogor.go.id/ekinerja2/berkas/'+berkas, '_blank');
        }

        function set_absen_jam_pulang(idp_enc, wkt_plg, ket){
            var jc = $.confirm({
                title: '',
                closeIconClass: 'fa fa-close',
                closeIcon: null,
                closeIconClass: false,
                boxWidth: '200px',
                useBootstrap: false,
                content: function () {
                    var data = new FormData();
                    data.append('id_pegawai', idp_enc);
                    data.append('wkt', wkt_plg);
                    data.append('ket', ket);
                    return $.ajax({
                        url: "<?php echo base_url($usr)."/input_jadwal_pulang_sesuai_jadwal/";?>",
                        data: data,
                        cache: false,
                        contentType: false,
                        processData: false,
                        method: 'POST',
                    }).done(function (data) {
                        if(data==0) {
                            $.confirm({
                                title: 'Informasi',
                                type: 'red',
                                closeIconClass: 'fa fa-close',
                                closeIcon: null,
                                closeIconClass: false,
                                useBootstrap: false,
                                content: 'Maaf input waktu absen pulang sesuai jadwal gagal',
                                buttons: {
                                    tryAgain: {
                                        text: 'Coba Lagi',
                                        btnClass: 'btn-blue',
                                        action: function () {
                                            set_absen_jam_pulang(idp_enc, wkt_plg);
                                        }
                                    },
                                    tutup: function () {
                                    }
                                }
                            });
                        }else if(data==202){
                            $.alert({
                                title: 'Informasi',
                                type: 'blue',
                                closeIconClass: 'fa fa-close',
                                closeIcon: null,
                                closeIconClass: false,
                                useBootstrap: false,
                                content: 'Data waktu absen pulang sesuai jadwal sudah ada'
                            });
                        }else{
                            $.alert({
                                title: 'Informasi',
                                type: 'green',
                                closeIconClass: 'fa fa-close',
                                closeIcon: null,
                                closeIconClass: false,
                                useBootstrap: false,
                                content: 'Input waktu absen pulang sesuai jadwal sukses'
                            });
                        }
                    }).fail(function(){
                        $("#_target_1").html('Error...telah terjadi kesalahan');
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

        function del_absen_jam_pulang(idp_enc, wkt_plg){
            $.confirm({
                title: 'Informasi',
                closeIconClass: 'fa fa-close',
                closeIcon: null,
                closeIconClass: false,
                useBootstrap: false,
                content: 'Anda yakin akan menghapus data absen pulang jadwal ini?',
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
                                    data.append('id_pegawai', idp_enc);
                                    data.append('wkt', wkt_plg);
                                    return $.ajax({
                                        url: "<?php echo base_url('adminopd')."/hapus_jadwal_pulang_sesuai_jadwal/";?>",
                                        data: data,
                                        cache: false,
                                        contentType: false,
                                        processData: false,
                                        method: "POST"
                                    }).done(function( data ){
                                        if(data == 1){
                                            $.alert({
                                                title: 'Informasi',
                                                type: 'green',
                                                closeIconClass: 'fa fa-close',
                                                closeIcon: null,
                                                closeIconClass: false,
                                                useBootstrap: false,
                                                content: 'Sukses menghapus data'
                                            });
                                        }else{
                                            $.alert({
                                                closeIconClass: 'fa fa-close',
                                                closeIcon: null,
                                                closeIconClass: false,
                                                useBootstrap: false,
                                                content: 'Tidak menghapus data',
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

    </script>
<?php else: ?>
    <br>Data tidak ditemukan.
<?php endif; ?>





