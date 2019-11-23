<?php if(isset($drop_data_list) and sizeof($drop_data_list) > 0 and $drop_data_list != ''): ?>
    <?php if(isset($pgDisplay)): ?>
        <?php if($numpage > 0): ?>
            <?php
                if($chkCekBerkasRil=='true'){
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

<table id="tblJadwalKhusus" class="table row-hover row-border compact">
    <thead>
        <tr>
            <th>No</th>
            <th>Periode</th>
            <th>No.SPMT</th>
            <th>Tgl.Input</th>
            <th>Jumlah Acara</th>
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
                <td><?php echo $lsdata->periode_bln.'-'.$lsdata->periode_thn; ?></td>
                <td><?php echo $lsdata->no_spmt_jadwal; ?></td>
                <td><?php echo $lsdata->tgl_input2; ?></td>
                <td><a href="javascript:void(0)">
                        <span class="mif-list icon"></span> <?php echo $lsdata->jml_jadwal; ?> Acara</a>
                </td>
            </tr>
            <tr>
                <td style="width: 5%">&nbsp;</td>
                <td colspan="2" style="width: 50%">
                    Uraian : <?php echo $lsdata->keterangan; ?> <br>Oleh: <?php echo $lsdata->nama.' ('.$lsdata->nip_baru; ?>)
                    <?php
                        if($lsdata->berkas_spmt!=''){
                            if($chkCekBerkasRil=='true') {
                                if (file_exists('ssh2.sftp://' . $sftp . '/var/www/html/ekinerja2/berkas/' . $lsdata->berkas_spmt)) {
                                    echo ' <br>&nbsp;<a href="javascript:void(0)" onclick="get_berkas(\'' . $lsdata->berkas_spmt . '\')"><span class="mif-download icon"></span> Download Berkas SPMT</a>';
                                } else {
                                    echo '<br><span style="color: red;">Belum ada berkas yang terupload</span>';
                                }
                            }else{
                                echo ' <br>&nbsp;<a href="javascript:void(0)" onclick="get_berkas(\'' . $lsdata->berkas_spmt . '\')"><span class="mif-download icon"></span> Download Berkas SPMT</a>';
                            }
                        }else{
                            echo '<br><span style="color: red;">Belum ada berkas yang terupload</span>';
                        }
                    ?>
                </td>
                <td colspan="2" style="width: 30%">
                    <button id="btnUbahJdwlKhusus" name="btnUbahJdwlKhusus" onclick="ubah_jadwal_spmt('<?php echo $lsdata->idjadwal_spmt_enc; ?>')"
                            type="button" class="button primary bg-green drop-shadow small rounded" <?php echo($this->session->userdata('id_pegawai')==$lsdata->inputer?'':'disabled'); ?>>
                        <span class="mif-pencil icon"></span> Ubah </button>
                    <button id="btnHapusJdwlKhusus" name="btnHapusJdwlKhusus" onclick="hapus_jadwal_spmt('<?php echo $lsdata->idjadwal_spmt_enc; ?>',<?php echo $curpage;?>,<?php echo $ipp;?>)"
                            type="button" class="button primary bg-darkRed drop-shadow small rounded" <?php echo($this->session->userdata('id_pegawai')==$lsdata->inputer?'':'disabled'); ?>>
                        <span class="mif-bin icon"></span> Hapus </button>
                    <button id="btnCetakJadwal" name="btnCetakJadwal" onclick="cetak_jadwal_khusus('<?php echo $lsdata->idjadwal_spmt_enc; ?>')"
                            type="button" class="button info drop-shadow small rounded">
                        <span class="mif-printer icon"></span> Cetak </button>
                </td>
            </tr>
            <?php
            $i++;
        } ?>
    </tbody>
</table>

    <script>
        function ubah_jadwal_spmt(idjdwl_spmt){
            location.href = "<?php echo base_url()."adminopd/ubah_jadwal_kerja/" ?>" + idjdwl_spmt;
        }

        function hapus_jadwal_spmt(idjadwal_khusus_enc, curpage, ipp){
            $.confirm({
                title: 'Informasi',
                closeIconClass: 'fa fa-close',
                closeIcon: null,
                closeIconClass: false,
                useBootstrap: false,
                content: 'Anda yakin akan menghapus data jadwal khusus ini?',
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
                                    data.append('idjadwal_khusus_enc', idjadwal_khusus_enc);
                                    return $.ajax({
                                        url: "<?php echo base_url('adminopd')."/exec_hapus_jadwal_khusus/";?>",
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

        function cetak_jadwal_khusus(idjdwl_spmt){
            window.open('/ekinerja2/adminopd/cetak_jadwal_khusus/' + idjdwl_spmt, '_blank');
        };

    </script>

<?php else: ?>
    <br>Data tidak ditemukan.
<?php endif; ?>

