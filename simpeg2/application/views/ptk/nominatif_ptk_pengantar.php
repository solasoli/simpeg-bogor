<div class="grid" style="background-color: white;margin-bottom: -25px;margin-top: -20px;">
    <div class="row">
        <table class="table bordered" id="tbl_nomin_ptk" width="100%">
            <thead style="border-bottom: solid darkred 3px;">
            <tr>
                <th style="vertical-align: middle;"><label class="input-control checkbox small-check"
                  style="margin-top: 0px;margin-bottom:0px;;vertical-align: middle;">
                        <input type="checkbox" id="checkAllList"><span class="check"></span>
                    </label></th>
                <th style="vertical-align: middle;width: 10%;">Tgl.Usulan</th>
                <th style="vertical-align: middle;width: 45%;">Uraian</th>
                <th style="vertical-align: middle;" colspan="3">Menjadi</th>
                <th style="vertical-align: middle;">Jumlah</th>
            </tr>
            </thead>
            <tbody>
            <?php if (sizeof($listdata) > 0): ?>
            <?php if($listdata!=''): ?>
            <?php 
                $i = 1;
                $connection = ssh2_connect('103.14.229.15');
                ssh2_auth_password($connection, 'rommonz', 'mony3Tmony3T');
                $sftp = ssh2_sftp($connection);
            ?>
            <?php foreach($listdata as $rp) { ?>
                <tr>
                    <td rowspan="2"><?php echo $i;?>.<br>
                        <label class="input-control checkbox small-check"
                               style="margin-top: 0px;">
                            <input type="checkbox" value="
                            <?php echo $rp->id_ptk.'#'.$rp->nip_baru.'#'.$rp->nama.'#'; ?>
                            <?php echo (($rp->istri_nambah>0 OR $rp->suami_nambah>0)?' Penambahan':(($rp->istri_ngurang>0 OR $rp->suami_ngurang>0)?' Pengurangan':''))?>
                            <?php echo ($rp->istri_nambah>0?$rp->istri_nambah.' Org Istri':($rp->suami_nambah>0?$rp->suami_nambah.' Org Suami':
                                ($rp->istri_ngurang>0?$rp->istri_ngurang.' Org Istri':($rp->suami_ngurang>0?$rp->suami_ngurang.' Org Suami':'')))) ?>
                            <?php echo ($rp->anak_nambah>0?' Penambahan':($rp->anak_ngurang>0?' Pengurangan':''))?>
                            <?php echo ($rp->anak_nambah>0?$rp->anak_nambah.' Org Anak':($rp->anak_ngurang>0?$rp->anak_ngurang.' Org Anak':'')).'#'.
                                $rp->tgl_input_pengajuan?>
                            " id="chkPtk<?php echo $rp->id_ptk; ?>" name="chkPtk<?php echo $rp->id_ptk; ?>">
                            <span class="check"></span>
                        </label>
                    </td>
                    <td><?php echo $rp->tgl_input_pengajuan;?></td>
                    <td><?php echo (($rp->istri_nambah>0 OR $rp->suami_nambah>0)?' Penambahan':(($rp->istri_ngurang>0 OR $rp->suami_ngurang>0)?' Pengurangan':''))?><!--</td>-->
                        <!--<td>--><?php echo ($rp->istri_nambah>0?$rp->istri_nambah.' Org Istri':($rp->suami_nambah>0?$rp->suami_nambah.' Org Suami':
                            ($rp->istri_ngurang>0?$rp->istri_ngurang.' Org Istri':($rp->suami_ngurang>0?$rp->suami_ngurang.' Org Suami':'')))) ?>
                        <!--</td>-->
                        <!--<td>--><?php echo ($rp->anak_nambah>0?' Penambahan':($rp->anak_ngurang>0?' Pengurangan':''))?><!--</td>-->
                        <!--<td>--><?php echo ($rp->anak_nambah>0?$rp->anak_nambah.' Org Anak':($rp->anak_ngurang>0?$rp->anak_ngurang.' Org Anak':''))?>
                    </td>
                    <td>1 Org Pegawai</td>
                    <td><?php echo $rp->last_jml_pasangan.' Org'.($rp->jk==1?' Istri':' Suami');?></td>
                    <td><?php echo $rp->last_jml_anak;?> Org Anak </td>
                    <td><?php echo $rp->jumlah_total_tertunjang;?> Org</td>
                </tr>
                <tr style="border-bottom: 2px solid #747571;">
                    <td colspan="2">
                        <span style="color: #002a80;font-weight: bold;"><?php echo $rp->nama;?></span> <strong>|</strong>
                        <?php echo $rp->nip_baru;?> <strong>|</strong> <?php echo $rp->last_gol;?><br>
                        Jabatan : <?php echo $rp->last_jabatan.($rp->unit_kerja==$rp->opd?'':' pada '.$rp->unit_kerja);?><br>
                        OPD : <?php echo $rp->opd;?>
                    </td>
                    <td colspan="4">Tgl.Disetujui : (<?php echo $rp->tgl_approve2;?>)
                        <br><strong><?php echo $rp->status_ptk;?></strong><br>
                        <?php
                        $syaratBerkasLainnya = $this->ptk->cekBerkas($rp->id_berkas_ptk);
                        if (isset($syaratBerkasLainnya)) {
                            $x = 1;
                            if(sizeof($syaratBerkasLainnya) > 0){
                                foreach ($syaratBerkasLainnya as $row4) {
                                    $asli = basename($row4->file_name);
                                    $getcwd = substr(getcwd(),0,strlen(getcwd())-1);
                                    if (file_exists('ssh2.sftp://' . $sftp . '/var/www/html/simpeg/berkas/'.trim($asli))) {
                                        $ext[] = explode(".",$asli);
                                        $linkBerkasPtk = "<a href='http://103.14.229.15/simpeg/berkas/$asli' target='_blank' style='font-weight: bold;'>Berkas Pengajuan PTK ke BPKAD Terupload</a>";
                                        $tglUploadPtk = $row4->created_date;
                                        unset($ext);
                                        echo "$linkBerkasPtk";
                                        echo "<small class=\"form-text text-muted\">";
                                        echo "<br>Upload : ".$tglUploadPtk." oleh: ".$row4->nama."</small>";
                                    }else{
                                        echo 'Belum ada File Surat Pengajuan PTK yang diupload (Data berkas sudah ada tapi file tidak ada).';
                                    }

                                    /*if(file_exists(str_replace("\\","/",$getcwd).'/Berkas/'.trim($asli))){
                                        $ext[] = explode(".",$asli);
                                        $linkBerkasPtk = "<a href='/simpeg/Berkas/$asli' target='_blank' style='font-weight: bold;'>Berkas Pengajuan PTK ke BPKAD Terupload</a>";
                                        $tglUploadPtk = $row4->created_date;
                                        unset($ext);
                                        echo "$linkBerkasPtk";
                                        echo "<small class=\"form-text text-muted\">";
                                        echo "<br>Upload : ".$tglUploadPtk." oleh: ".$row4->nama."</small>";
                                    }else{
                                        echo 'Belum ada File Surat Pengajuan PTK yang diupload (Data berkas sudah ada tapi file tidak ada).';
                                    }*/
                                }
                            }
                        }
                        ?>
                    </td>
                </tr>
                <?php $i++;} ?>
                    <?php else: ?>
                    <tr><td colspan="13">Data tidak ditemukan</td></tr>
                <?php endif; ?>
            <?php else: ?>
                <tr><td colspan="13">Data tidak ditemukan</td></tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
    $("#checkAllList").change(function () {
        $("#divListDrop input:checkbox").prop('checked', $(this).prop("checked"));
    });

</script>
