<div class="grid" style="background-color: white;margin-bottom: -25px;">
    <div class="row">
        <div style="border:1px solid #c0c2bb; overflow: scroll;height: 428px; width: 100%;padding: 5px;">
            <table class="table bordered" id="tbl_nominatif_rekap_ptk" width="100%">
                <thead style="border-bottom: solid darkred 2px;">
                <tr>
                    <th style="vertical-align: middle;">No</th>
                    <th style="vertical-align: middle;width: 15%;">Tgl.Usulan</th>
                    <th style="vertical-align: middle;">Pengajuan</th>
                    <th style="vertical-align: middle;">Uraian Pengubahan</th>
                    <th style="vertical-align: middle;" colspan="3">Menjadi</th>
                    <th style="vertical-align: middle;">Jumlah</th>
                </tr>
                </thead>
                <tbody>
                <?php $i = 1; ?>
                <?php foreach($listdata as $rp) { ?>
                    <tr>
                        <td rowspan="2"><?php echo $i;?>.</td>
                        <td><?php echo $rp->tgl_input_pengajuan;?></td>
                        <td><?php echo $rp->jenis_pengajuan;?></td>
                        <td><?php echo (($rp->istri_nambah>0 OR $rp->suami_nambah>0)?' Penambahan':(($rp->istri_ngurang>0 OR $rp->suami_ngurang>0)?' Pengurangan':''))?><!--</td>-->
                            <!--<td>--><?php echo ($rp->istri_nambah>0?$rp->istri_nambah.' Orang Istri':($rp->suami_nambah>0?$rp->suami_nambah.' Orang Suami':
                                ($rp->istri_ngurang>0?$rp->istri_ngurang.' Orang Istri':($rp->suami_ngurang>0?$rp->suami_ngurang.' Orang Suami':'')))) ?>
                            <!--</td>-->
                            <!--<td>--><?php echo ($rp->anak_nambah>0?' Penambahan':($rp->anak_ngurang>0?' Pengurangan':''))?><!--</td>-->
                            <!--<td>--><?php echo ($rp->anak_nambah>0?$rp->anak_nambah.' Orang Anak':($rp->anak_ngurang>0?$rp->anak_ngurang.' Orang Anak':''))?></td>

                        <td>1 Orang Pegawai</td>
                        <td><?php echo $rp->last_jml_pasangan.' Orang'.($rp->jk==1?' Istri':' Suami');?></td>
                        <td><?php echo $rp->last_jml_anak;?> Orang Anak</td>
                        <td><?php echo $rp->jumlah_total_tertunjang;?> Orang</td>
                    </tr>
                    <tr>
                        <td style="display: none;"></td>
                        <td colspan="3">
                            <span style="color: #002a80;font-weight: bold;"><?php echo $rp->nama;?></span> <strong>|</strong>
                            <?php echo $rp->nip_baru;?> <?php echo $rp->pangkat.' - '.$rp->last_gol;?><br>
                            Jabatan : <?php echo $rp->last_jabatan.($rp->unit_kerja==$rp->opd?'':' pada '.$rp->unit_kerja);?><br>
                            OPD : <?php echo $rp->opd;?>
                        </td>
                        <td style="display: none;"></td>
                        <td style="display: none;"></td>
                        <td colspan="4">
                            Status Usulan (<?php echo $rp->tgl_update_pengajuan;?>) :
                            <br><strong><?php echo $rp->status_ptk;?></strong>
                        </td>
                        <td style="display: none;"></td>
                        <td style="display: none;"></td>
                        <td style="display: none;"></td>
                    </tr>
                    <?php $i++;} ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    $('#tbl_nominatif_rekap_ptk').dataTable({
        "paging": true,
        "ordering": false,
        "info": true
    });
</script>
