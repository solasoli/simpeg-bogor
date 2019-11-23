<div class="row">
    <legend>
        <h2>Standar Kompetensi
            <!--<span class=" place-right"><a href="#" id="addPangkat" class="button primary"><span class="icon-plus"></span> tambah</a></span>-->
        </h2>
    </legend>
    <h5><?php echo strtoupper($kat_jabatan); ?></h5>
    <?php
        if (is_array($std_kompetensi) and sizeof($std_kompetensi) > 0 and $std_kompetensi != ''){
            foreach($lvl_kompetensi as $lsdata_lvl){
                echo '<strong>Level '.$lsdata_lvl->id_kmp_level.' - '.$lsdata_lvl->nama_level.'</strong><br>';
                echo 'Kriteria : '.$lsdata_lvl->kriteria_level;
            }
        }
    ?>
    <?php if (is_array($std_kompetensi) and sizeof($std_kompetensi) > 0 and $std_kompetensi != ''){?>
    <table class="table" style="border-top: 1px solid black;margin-top: 20px;">
        <thead>
        <tr>
            <th>Kompetensi</th>
            <th>Level</th>
            <th>Deskripsi</th>
            <th>Indikator Kompetensi</th>
        </tr>
        </thead>
        <tbody>

        <?php
        $x=1;
        $nama_kmp = '';
        $nama_kmp2 = '';
        foreach($std_kompetensi as $lsdata){
            if($nama_kmp==''){
                $nama_kmp = $lsdata->nama_kmp;
                $nama_kmp2 = $lsdata->nama_kmp;
            }else{
                if($nama_kmp==$lsdata->nama_kmp){
                    $nama_kmp2 = '';
                }else{
                    $nama_kmp2 = $lsdata->nama_kmp;
                }
            }
            ?>
            <?php if($nama_kmp2!=''): ?>
            <tr>
                <td colspan="4"><?php echo '<span style="font-weight: bold; font-size: large;text-decoration: underline;">'.strtoupper($nama_kmp2).'</span>'; ?></td>
            </tr>
            <?php endif; ?>
        <tr>
            <td><?php
                if($lsdata->kode_kmp!=''){
                    echo '<strong>'.$x++.') '.$lsdata->kode_kmp.' '.$lsdata->nama_jenis_kmp.'</strong><br>Definisi: '.$lsdata->definisi_kmp;
                }
                ?></td>
            <td><?php echo $lsdata->id_kmp_level; ?></td>
            <td><?php echo $lsdata->deskripsi_kmp; ?></td>
            <td><?php echo $lsdata->indikator_kmp; ?></td>
        </tr>
        <?php } ?>
        </tbody>
    </table>
        <?php
    }else{
        echo 'Belum ada data';
    } ?>
</div>