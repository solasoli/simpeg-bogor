<div class="panel-content" data-role="panel"
     data-title-caption="Daftar Penilaian Prestasi"
     data-title-icon=""
     data-cls-title=" fg-black">
    <?php if (isset($riwayat_skp) and sizeof($riwayat_skp) > 0 and $riwayat_skp != ''){ ?>
        <?php $i = 1; ?>

        <div style="overflow-x: auto;margin-top: 10px;">
            <table class="table table-border row-hover cell-border compact">
                <thead>
                <tr>
                    <th>No</th>
                    <th>Uraian</th>
                    <th>Status</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach($riwayat_skp as $lsdata){ ?>
                    <tr>
                        <td><?php echo $i; ?></td>
                        <td>
                            Periode: <a href="<?php echo base_url()."$usr/detail_stk_skp/?id_skp=".$lsdata->id_skp; ?>"><?php echo $lsdata->tahun; ?> (<?php echo $lsdata->periode_awal; ?> s.d <?php echo $lsdata->periode_akhir; ?>)</a><br>
                            Jabatan: <span style="color: saddlebrown"><?php echo $lsdata->jabatan_pegawai; ?></span><br>
                            Unit Kerja: <?php echo $lsdata->unit_kerja; ?>
                        </td>
                        <td><?php echo $lsdata->status; ?></td>
                    </tr>
                    <?php
                    $i++;
                } ?>
                </tbody>
            </table>
        </div>
    <?php }else{
        echo 'Data tidak ditemukan';
    } ?>
</div>
