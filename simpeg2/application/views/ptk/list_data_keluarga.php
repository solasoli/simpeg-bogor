<script src="<?php echo base_url()?>assets/metro/js/metro-treeview.js"></script>
<?php if(isset($list_data)): ?>
    <?php if (sizeof($list_data) > 0): ?>
        <?php
            $i = 0;
            $e = 0;
            $label = "";
        ?>
        <?php if($list_data!=''): ?>

            <table class='table'>
                <tr style='border-bottom: solid 2px #2cc256'>
                    <th style='width:2%;'>No</th><th style='width:15%;'>Nama</th>
                    <th style='width:43%;'>Biodata</th><th style='width:30%;'>Keterangan</th>
                    <th style='width:10%;'>Status</th>
                </tr>
                <?php foreach ($list_data as $lsdata): ?>
                    <?php $i++;?>
                    <?php
                        if($label==""){
                            $label = $lsdata->status_keluarga;
                            echo "<tr><td colspan='5' style='background-color:#f7f8ef;text-align: center;color: blue; font-weight: bold;'>$lsdata->status_keluarga</td></tr>";
                        }else{
                            if($label==$lsdata->status_keluarga){
                                echo "";
                            }else{
                                echo "<tr><td colspan='5' style='background-color:#f7f8ef;text-align: center;color: blue; font-weight: bold;'>$lsdata->status_keluarga</td></tr>";
                                $label = $lsdata->status_keluarga;
                                $i = 1;
                            }
                        }
                    ?>
                    <tr>
                        <td><?php echo $i ?>.</td>
                        <td><strong><?php echo $lsdata->nama?></strong></td>
                        <td>
                            Jenis Kelamin : <?php echo $lsdata->jenis_kelamin?><br>
                            Tempat, Tgl.Lahir : <?php echo $lsdata->tempat_lahir?>, <?php echo $lsdata->tgl_lahir?><br>
                            Usia : <?php echo $lsdata->usia?> thn<br>
                            Pekerjaan : <?php echo $lsdata->pekerjaan?>
                            <ul class="treeview" data-role="treeview" id="tree<?php echo $lsdata->id_keluarga?>" style="background-color: transparent;">
                                <li class="node collapsed">
                                    <a href="#" style="background-color: transparent;font-size:small;font-weight:normal;color: #0000cc;">
                                        <span class="node-toggle" style="font-size: x-large"></span>Lihat Detail</a>
                                    <ul>
                                        <li style="font-size: small;color: black;margin-top: -5px;">
                                            <span style='text-decoration: underline;'>Kelahiran</span> <span class="icon-arrow-right"></span>
                                            No.Akte: <?php echo ($lsdata->akte_kelahiran==''?'-':$lsdata->akte_kelahiran)?>,Tgl.Akte: <?php echo ($lsdata->tgl_akte_kelahiran==''?'-':$lsdata->tgl_akte_kelahiran)?><br>
                                            <span style='text-decoration: underline;'>Pernikahan</span> <span class="icon-arrow-right"></span>
                                            Tgl.Nikah: <?php echo ($lsdata->tgl_menikah==''?'-':$lsdata->tgl_menikah)?>,No.Akte: <?php echo ($lsdata->akte_menikah==''?'-':$lsdata->akte_menikah)?>,Tgl.Akte: <?php echo ($lsdata->tgl_akte_menikah==''?'-':$lsdata->tgl_akte_menikah)?><br>
                                            <span style='text-decoration: underline;'>Perceraian</span> <span class="icon-arrow-right"></span>
                                            Tgl.Cerai: <?php echo ($lsdata->tgl_cerai==''?'-':$lsdata->tgl_cerai)?>,No.Akte: <?php echo ($lsdata->akte_cerai==''?'-':$lsdata->akte_cerai)?>,Tgl.Akte: <?php echo ($lsdata->tgl_akte_cerai==''?'-':$lsdata->tgl_akte_cerai)?><br>
                                            <span style='text-decoration: underline;'>Kematian</span> <span class="icon-arrow-right"></span>
                                            Tgl.Meninggal: <?php echo ($lsdata->tgl_meninggal==''?'-':$lsdata->tgl_meninggal)?>,No.Akte: <?php echo ($lsdata->akte_meninggal==''?'-':$lsdata->akte_meninggal)?>,Tgl.Akte: <?php echo ($lsdata->tgl_akte_meninggal==''?'-':$lsdata->tgl_akte_meninggal)?><br>
                                            <span style='text-decoration: underline;'>Sekolah</span> <span class="icon-arrow-right"></span>
                                            No.Ijazah: <?php echo ($lsdata->no_ijazah==''?'-':$lsdata->no_ijazah)?>,Institusi: <?php echo ($lsdata->nama_sekolah==''?'-':$lsdata->nama_sekolah)?>,Tgl.Lulus: <?php echo ($lsdata->tgl_lulus==''?'-':$lsdata->tgl_lulus)?>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                            <script>
                                $(function(){
                                    $("#tree<?php echo $lsdata->id_keluarga?>").treeview({});
                                });
                            </script>
                        </td>
                        <td>Tunjangan di SKUM : <?php echo $lsdata->status_tunjangan_skum?><br>
                            Verifikasi : <?php echo $lsdata->status_verifikasi_data.'<br>'.$lsdata->ref_tanggal.' '.$lsdata->ref_keterangan ?>
                        </td>
                        <td><?php echo $lsdata->status_validasi ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php endif; ?>
    <?php else: ?>
        Data tidak ditemukan.
    <?php endif; ?>
<?php else: ?>
    Data tidak ditemukan.
<?php endif; ?>