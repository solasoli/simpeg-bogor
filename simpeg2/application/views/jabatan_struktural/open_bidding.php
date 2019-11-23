<br>
<div class="container">
    <strong>DAFTAR PEGAWAI YANG IKUT OPEN BIDDING</strong>
    <br><br>
    <div class="grid">
        <?php if (is_array($list_data) && sizeof($list_data) > 0): ?>
                <?php
                    $i = 1;
                    $connection = ssh2_connect('103.14.229.15');
                    ssh2_auth_password($connection, 'rommonz', 'mony3Tmony3T');
                    $sftp = ssh2_sftp($connection);
                ?>
                <?php if ($list_data != ''): ?>
                    <?php foreach ($list_data as $lsdata): ?>
                    <div id="dvOpnBidLst<?php echo $lsdata->id_open_bidding; ?>">
                        <table class="table bordered striped" id="lst_plt">
                            <thead style="border-bottom: solid #a4c400 2px;border-top: solid #000000 1px;">
                            <tr>
                                <th>No</th>
                                <th>TMT</th>
                                <th>Status</th>
                                <th>Keterangan</th>
                                <th>Jumlah Pegawai</th>
                                <th>Inputer</th>
                                <th>Aksi</th>
                            </tr>
                            </thead>
                            <tr>
                                <td><?php echo $i; ?>.</td>
                                <td><?php echo $lsdata->tmt_open_bidding; ?></td>
                                <td><?php echo ($lsdata->status_aktif==1?'Aktif':'Tidak Aktif'); ?></td>
                                <td><?php echo $lsdata->keterangan; ?></td>
                                <td style="text-align: center;width: 13%;"><?php echo $lsdata->jml_pegawai; ?> orang</td>
                                <td><?php echo $lsdata->nama_gelar.' ('.$lsdata->nip_baru.') pada '.$lsdata->tgl_input; ?></td>
                                <td style="width: 32%;">
                                    <button type="button"
                                            name="btnUbahOpB<?php echo $lsdata->id_open_bidding; ?>"
                                            id="btnUbah<?php echo $lsdata->id_open_bidding; ?>"
                                            class="btn btn-primary btn-sm"
                                            style="font-weight: bold;color: darkslategrey; border: 1px solid darkgray" onclick="ubah_open_bidding(<?php echo $lsdata->id_open_bidding; ?>)">
                                        <span class="icon-pencil on-left"></span> Ubah</button>

                                    <button type="button"
                                            name="btnHapusOpB<?php echo $lsdata->id_open_bidding; ?>"
                                            id="btnHapus<?php echo $lsdata->id_open_bidding; ?>"
                                            class="btn btn-primary btn-sm"
                                            style="font-weight: bold;color: darkslategrey; border: 1px solid darkgray" onclick="hapus_open_bidding(<?php echo $lsdata->id_open_bidding.",'".$lsdata->tmt_open_bidding."'"; ?>)">
                                        <span class="icon-remove on-left"></span> Hapus</button>

                                    <button type="button"
                                            name="btnCetakOpnBid<?php echo $lsdata->id_open_bidding; ?>"
                                            id="btnCetakOpnBid<?php echo $lsdata->id_open_bidding; ?>"
                                            class="btn btn-primary btn-sm"
                                            style="font-weight: bold;color: darkslategrey; border: 1px solid darkgray;" onclick="cetak_open_bidding(<?php echo $lsdata->id_open_bidding; ?>)">
                                        <span class="icon-file-pdf on-left"></span> Download PDF</button>
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td colspan="6">
                                    <div class="row" style="margin-top: 0px;">
                                        <div class="span6">Terdiri dari :
                                            <button type="button"
                                                    name="btnAddOpbEmp<?php echo $lsdata->id_open_bidding; ?>"
                                                    id="btnAddOpbEmp<?php echo $lsdata->id_open_bidding; ?>"
                                                    class="btn btn-primary btn-sm"
                                                    style="font-weight: bold;color: darkslategrey; border: 1px solid darkgray" onclick="add_open_bidding_pegawai(<?php echo $lsdata->id_open_bidding; ?>)">
                                                <span class="icon-user on-left"></span> Tambah Pegawai</button>
                                        </div>
                                        <div class="span6" style="text-align: right;">Berkas :
                                            <?php
                                            if($lsdata->berkas==''){
                                                echo 'Belum ada berkas';
                                            }else {
                                                error_reporting(0);
                                                if (file_exists('ssh2.sftp://' . $sftp . '/var/www/html/simpeg2/Berkas/' . trim($lsdata->berkas))) {
                                                    $linkBerkas = "<a href='http://arsipsimpeg.kotabogor.go.id/simpeg2/Berkas/$lsdata->berkas' target='_blank' style='font-weight: bold;'>Berkas Peserta Open Bidding</a>";
                                                    echo "$linkBerkas";
                                                } else {
                                                    echo 'Belum ada berkas';
                                                }
                                                error_reporting(1);
                                            }
                                            ?>
                                        </div>
                                    </div>
                                    <?php
                                        $list_data_peg = $this->jabatan_model->get_detail_open_bidding($lsdata->id_open_bidding);
                                        if (is_array($list_data_peg) && sizeof($list_data_peg) > 0){
                                            if ($list_data_peg != ''){
                                                echo '<ol>';
                                                foreach ($list_data_peg as $lsdata_peg) {
                                                    echo '<li style="border-bottom: 1px solid darkgray;"><div class="row"><div class="span11" style="margin-top: -15px;"><strong>'.$lsdata_peg->nama_gelar.'</strong> (NIP. '.$lsdata_peg->nip_baru.')'.
                                                        '<br>Jabatan: '.$lsdata_peg->jabatan_asli_saat_opbid.' ('.$lsdata_peg->last_jenjab.($lsdata_peg->eselon==''?'':' Eselon '.$lsdata_peg->eselon).'). Pangkat: '.$lsdata_peg->last_gol.
                                                        '<br>Unit Kerja: '.$lsdata_peg->unit_saat_opbid.''; ?>
                                                    </div><div class="span1">
                                                    <button type="button"
                                                            name="btnHapus<?php echo $lsdata_peg->id_open_bidding_detail; ?>"
                                                            id="btnHapus<?php echo $lsdata_peg->id_open_bidding_detail; ?>"
                                                            class="btn btn-primary btn-sm"
                                                            style="font-weight: bold;color: darkslategrey; border: 1px solid darkgray" onclick="hapus_open_bidding_detail(<?php echo $lsdata_peg->id_open_bidding_detail.",'".$lsdata_peg->nama_gelar  ."',".$lsdata->id_open_bidding.",".$i; ?>)">
                                                        <span class="icon-remove on-left"></span> Hapus</button></div>
                                                    </li></div>
                                                <?php }
                                                echo '</ol>';
                                            }else{
                                                echo 'Tidak ada data';
                                            }
                                        }else{
                                            echo 'Tidak ada data';
                                        }
                                    ?>
                                </td>
                            </tr>
                        </table>
                    </div>
                        <?php
                        $i++;
                    endforeach; ?>
                <?php else: ?>
                    Tidak ada data
                <?php endif; ?>
        <?php else: ?>
            Tidak ada data
        <?php endif; ?>
    </div>
</div>

<script type="application/javascript">
    function ubah_open_bidding(id_open_bidding){
        $.ajax({
            method: "POST",
            url: "<?php echo base_url()?>index.php/jabatan_struktural/ubah_data_open_bidding",
            data: { id_open_bidding: id_open_bidding },
            dataType: "html"
        }).done(function( data ) {
            $("#ubah_open_bidding").html(data);
            $("#ubah_open_bidding").find("script").each(function(i) {
                eval($(this).text());
            });
        });

        $.Dialog({
            shadow: true,
            overlay: false,
            icon: '<span class="icon-rocket"></span>',
            title: 'Ubah Data Open Bidding',
            width: 550,
            height: 310,
            padding: 10,
            content: "<div id='ubah_open_bidding' style='height:250px;overflow: auto;overflow-x: hidden; '></div>"
        });
    }

    function hapus_open_bidding(id_open_bidding){

    }

    function hapus_open_bidding_detail(id_open_bidding_detail, nama, id_open_bidding, no_urut){
        var r = confirm("Anda yakin akan menghapus data pegawai ini a.n. "+nama+"?");
        if (r == true) {
            $.ajax({
                method: "POST",
                url: "<?php echo base_url()?>index.php/jabatan_struktural/hapus_data_detail_open_bidding",
                data: {
                    id_open_bidding_detail: id_open_bidding_detail,
                    id_open_bidding: id_open_bidding,
                    no_urut: no_urut
                },
                dataType: "html"
            }).done(function( data ) {
                if (data == '1') {
                    alert('Data sukses terhapus');
                    load_open_bidding_by_id(id_open_bidding, no_urut);
                } else {
                    alert(data);
                }
            });
        }
    }

    function load_open_bidding_by_id(id_open_bidding, no_urut){
        $("#dvOpnBidLst"+id_open_bidding).css("pointer-events", "none");
        $("#dvOpnBidLst"+id_open_bidding).css("opacity", "0.4");
        $.ajax({
            method: "POST",
            url: "<?php echo base_url()?>index.php/jabatan_struktural/load_openbidding_by_id_on_list",
            data: { id_open_bidding: id_open_bidding, no_urut: no_urut},
            dataType: "html"
        }).done(function (data) {
            $("#dvOpnBidLst"+id_open_bidding).html(data);
            $("#dvOpnBidLst"+id_open_bidding).css("pointer-events", "auto");
            $("#dvOpnBidLst"+id_open_bidding).css("opacity", "1");
            $("#dvOpnBidLst"+id_open_bidding).find("script").each(function(i) {
                eval($(this).text());
            });
        }).fail(function(){
            $("#dvOpnBidLst"+id_open_bidding).html('Error...telah terjadi kesalahan');
        });
    }

    function add_open_bidding_pegawai(id_open_bidding){
        $.ajax({
            method: "POST",
            url: "<?php echo base_url()?>index.php/jabatan_struktural/add_open_bidding_detail",
            data: { id_open_bidding: id_open_bidding },
            dataType: "html"
        }).done(function( data ) {
            $("#add_open_bidding_detail").html(data);
            $("#add_open_bidding_detail").find("script").each(function(i) {
                eval($(this).text());
            });
        });

        $.Dialog({
            shadow: true,
            overlay: false,
            icon: '<span class="icon-rocket"></span>',
            title: 'Tambah Data Pegawai untuk Open Bidding',
            width: 930,
            height: 500,
            padding: 10,
            content: "<div id='add_open_bidding_detail' style='height:500px;overflow: auto;overflow-x: hidden; '></div>"
        });
    }

    function hapus_open_bidding(id_open_bidding, tmt_open_bidding){
        var r = confirm("Anda yakin akan menghapus data Open Bidding ini TMT. "+tmt_open_bidding+"?");
        if (r == true) {
            $.ajax({
                method: "POST",
                url: "<?php echo base_url()?>index.php/jabatan_struktural/hapus_data_open_bidding",
                data: {
                    id_open_bidding: id_open_bidding
                },
                dataType: "html"
            }).done(function( data ) {
                if (data == '1') {
                    alert('Data sukses terhapus');
                    window.location.reload();
                } else {
                    alert(data);
                }
            });
        }
    }

    function cetak_open_bidding(){

    }

</script>