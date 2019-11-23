<?php if(isset($drop_data_list) and sizeof($drop_data_list) > 0 and $drop_data_list != ''): ?>
    <?php if(isset($pgDisplay)): ?>
        <?php if($numpage > 0): ?>
            <div class="row" style="margin-top: 20px;">
                <div class="cell-sm-12">
                    Halaman ke <?php echo $curpage; ?> dari <?php echo $numpage; ?> | Jumlah : <?php echo $jmlData; ?>
                </div>
            </div>
            <?php echo $pgDisplay; ?>
        <?php endif; ?>
    <?php endif; ?>
    <table id="tblItemLain" class="table row-hover row-border compact" style="width: 100%;">
        <thead style="border-bottom: 3px solid yellowgreen;">
        <tr>
            <th>No</th>
            <th style="width: 45%">Kategori Kinerja Lainnya</th>
            <th style="width: 50%">Keterangan</th>
        </tr>
        </thead>
        <tbody>
            <?php
            if(sizeof($drop_data_list) > 0):
                $i = 1;
                $halaman = $start_number;
                foreach($drop_data_list as $lsdata) {
                    ?>
                    <tr>
                        <td style="vertical-align: top;"><?php echo $halaman+$i; ?>)</td>
                        <td style="vertical-align: top;">
                            <span style="color: blue;"><?php echo $lsdata->jenis_item_lainnya; ?></span><br>
                            <?php echo $lsdata->keterangan; ?><br>
                            <h5><?php echo $lsdata->nama_pegawai; ?></h5>
                            NIP. <?php echo $lsdata->nip_pegawai; ?><br>
                            No.SK. <?php echo $lsdata->no_sk; ?><br>
                            TMT. <?php echo $lsdata->tmt_mulai; ?> s/d <?php echo $lsdata->tmt_selesai; ?><br>
                            Status: <?php echo $lsdata->status_usulan_item_lainnya; ?>
                        </td>
                        <td style="vertical-align: top;">
                            <span style="color: saddlebrown;"><?php echo $lsdata->kategori_item.' Tunjangan ('.$lsdata->persen_tunjangan.'% '.$lsdata->ket_item.')'; ?></span><br>
                            Diinput pada <?php echo $lsdata->waktu_input; ?> oleh <?php echo $lsdata->inputer; ?> (<?php echo $lsdata->nip_inputer; ?>) <br>
                            Pemrosesan akhir pada <?php echo $lsdata->tgl_approved; ?> oleh <?php echo $lsdata->approver; ?> (<?php echo $lsdata->nip_approver; ?>)<br>
                            Catatan: <?php echo $lsdata->catatan_approved; ?><br>
                            <div class="row mb-2">
                                <div class="cell-sm-6">
                                    <div style="font-size: 11pt;">
                                        <?php
                                        if($lsdata->berkas_sk!=''){
                                            echo '<a href="javascript:void(0)" onclick="get_berkas(\''.$lsdata->berkas_sk.'\')"><span class="mif-download icon"></span> Download Berkas SK</a>';
                                        }
                                        ?>&nbsp;
                                    </div>
                                </div>
                                <div class="cell-sm-6">
                                    <div style="font-size: 11pt;">
                                        <button id="btnUbahItemLain" name="btnUbahItemLain" onclick="ubah_item_lainnya('<?php echo $lsdata->id_item_lainnya_enc; ?>')"
                                                type="button" class="button primary bg-green drop-shadow small rounded">
                                            <span class="mif-pencil icon"></span> Ubah </button>
                                        <button id="btnHapusItemLain" name="btnHapusItemLain" onclick="hapus_item_lainnya('<?php echo $lsdata->id_item_lainnya_enc; ?>',<?php echo $curpage;?>,<?php echo $ipp;?>)"
                                                type="button" class="button primary bg-darkRed drop-shadow small rounded">
                                            <span class="mif-bin icon"></span> Hapus </button>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <?php
                    $i++;
                }
            else:
                echo '<tr><td colspan="3">Data tidak ditemukan</td></tr>';
            endif;
            ?>
        </tbody>
    </table>
    <script>
        function get_berkas(berkas){
            window.open('https://arsipsimpeg.kotabogor.go.id/ekinerja2/berkas/'+berkas, '_blank');
        }

        function ubah_item_lainnya(id_item_lainnya_enc){
            location.href = "<?php echo base_url()."adminopd/ubah_item_lainnya/" ?>" + id_item_lainnya_enc;
        }

        function hapus_item_lainnya(id_item_lainnya_enc){
            $.confirm({
                title: 'Informasi',
                closeIconClass: 'fa fa-close',
                closeIcon: null,
                closeIconClass: false,
                useBootstrap: false,
                content: 'Anda yakin akan menghapus data item kinerja lainnya?',
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
                                    data.append('id_item_lainnya_enc', id_item_lainnya_enc);
                                    return $.ajax({
                                        url: "<?php echo base_url($usr)."/exec_hapus_item_lainnya/";?>",
                                        data: data,
                                        cache: false,
                                        contentType: false,
                                        processData: false,
                                        method: "POST"
                                    }).done(function( data ){
                                        if(data == 1){
                                            pagingViewListLoad(<?php echo $curpage;?>,<?php echo $ipp;?>);
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

    </script>
<?php else: ?>
    Data tidak ditemukan.
<?php endif; ?>

