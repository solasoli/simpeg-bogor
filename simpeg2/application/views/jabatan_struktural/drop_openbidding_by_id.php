<?php if (is_array($list_data) && sizeof($list_data) > 0): ?>
    <?php
    $i = 1;
    $connection = ssh2_connect('103.14.229.15');
    ssh2_auth_password($connection, 'rommonz', 'mony3Tmony3T');
    $sftp = ssh2_sftp($connection);
    ?>
    <?php if ($list_data != ''): ?>
        <?php foreach ($list_data as $lsdata): ?>
            <table class="table bordered striped" id="lst_plt">
                <thead style="border-bottom: solid #a4c400 2px;border-top: solid #000000 1px;">
                <tr>
                    <th>No</th>
                    <th>TMT</th>
                    <th>Status</th>
                    <th>Keterangan</th>
                    <th>Inputer</th>
                    <th>Aksi</th>
                </tr>
                </thead>
                <tr>
                    <td><?php echo $no_urut; ?>.</td>
                    <td><?php echo $lsdata->tmt_open_bidding; ?></td>
                    <td><?php echo($lsdata->status_aktif == 1 ? 'Aktif' : 'Tidak Aktif'); ?></td>
                    <td><?php echo $lsdata->keterangan; ?></td>
                    <td style="text-align: center;width: 13%;"><?php echo $lsdata->jml_pegawai; ?> orang</td>
                    <td><?php echo $lsdata->nama_gelar . ' (' . $lsdata->nip_baru . ') pada ' . $lsdata->tgl_input; ?></td>
                    <td style="width: 32%;">
                        <button type="button"
                                name="btnUbahOpB<?php echo $lsdata->id_open_bidding; ?>"
                                id="btnUbah<?php echo $lsdata->id_open_bidding; ?>"
                                class="btn btn-primary btn-sm"
                                style="font-weight: bold;color: darkslategrey; border: 1px solid darkgray"
                                onclick="ubah_open_bidding(<?php echo $lsdata->id_open_bidding; ?>)">
                            <span class="icon-pencil on-left"></span> Ubah
                        </button>

                        <button type="button"
                                name="btnHapusOpB<?php echo $lsdata->id_open_bidding; ?>"
                                id="btnHapus<?php echo $lsdata->id_open_bidding; ?>"
                                class="btn btn-primary btn-sm"
                                style="font-weight: bold;color: darkslategrey; border: 1px solid darkgray"
                                onclick="hapus_open_bidding(<?php echo $lsdata->id_open_bidding . ",'" . $lsdata->tmt_open_bidding . "'"; ?>)">
                            <span class="icon-remove on-left"></span> Hapus
                        </button>

                        <button type="button"
                                name="btnCetakOpnBid<?php echo $lsdata->id_open_bidding; ?>"
                                id="btnCetakOpnBid<?php echo $lsdata->id_open_bidding; ?>"
                                class="btn btn-primary btn-sm"
                                style="font-weight: bold;color: darkslategrey; border: 1px solid darkgray;"
                                onclick="cetak_open_bidding(<?php echo $lsdata->id_open_bidding; ?>)">
                            <span class="icon-file-pdf on-left"></span> Download PDF
                        </button>
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
                                        style="font-weight: bold;color: darkslategrey; border: 1px solid darkgray"
                                        onclick="add_open_bidding_pegawai(<?php echo $lsdata->id_open_bidding; ?>)">
                                    <span class="icon-user on-left"></span> Tambah Pegawai
                                </button>
                            </div>
                            <div class="span6" style="text-align: right;">Berkas :
                                <?php
                                if ($lsdata->berkas == '') {
                                    echo 'Belum ada berkas';
                                } else {
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
                        if (is_array($list_data_peg) && sizeof($list_data_peg) > 0) {
                            if ($list_data_peg != '') {
                                echo '<ol>';
                                foreach ($list_data_peg as $lsdata_peg) {
                                    echo '<li style="border-bottom: 1px solid darkgray;"><div class="row"><div class="span11" style="margin-top: -15px;"><strong>' . $lsdata_peg->nama_gelar . '</strong> (NIP. ' . $lsdata_peg->nip_baru . ')' .
                                        '<br>Jabatan: ' . $lsdata_peg->jabatan_asli_saat_opbid . ' (' . $lsdata_peg->last_jenjab . ($lsdata_peg->eselon == '' ? '' : ' Eselon ' . $lsdata_peg->eselon) . '). Pangkat: ' . $lsdata_peg->last_gol .
                                        '<br>Unit Kerja: ' . $lsdata_peg->unit_saat_opbid . ''; ?>
                                    </div>
                                    <div class="span1">
                                        <button type="button"
                                                name="btnHapus<?php echo $lsdata_peg->id_open_bidding_detail; ?>"
                                                id="btnHapus<?php echo $lsdata_peg->id_open_bidding_detail; ?>"
                                                class="btn btn-primary btn-sm"
                                                style="font-weight: bold;color: darkslategrey; border: 1px solid darkgray"
                                                onclick="hapus_open_bidding_detail(<?php echo $lsdata_peg->id_open_bidding_detail . ",'" . $lsdata_peg->nama_gelar . "'," . $lsdata->id_open_bidding . "," . $no_urut; ?>)">
                                            <span class="icon-remove on-left"></span> Hapus
                                        </button>
                                    </div>
                                    </li></div>
                                <?php }
                                echo '</ol>';
                            } else {
                                echo 'Tidak ada data';
                            }
                        } else {
                            echo 'Tidak ada data';
                        }
                        ?>
                    </td>
                </tr>
            </table>
            <?php
            $i++;
        endforeach; ?>
    <?php else: ?>
        Tidak ada data
    <?php endif; ?>
<?php else: ?>
    Tidak ada data
<?php endif; ?>