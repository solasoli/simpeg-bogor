<div class="row">
    <legend>
        <h2>Riwayat SKP
            <!--<span class=" place-right"><a href="#" id="addPangkat" class="button primary"><span class="icon-plus"></span> tambah</a></span>-->
        </h2>
    </legend>

    <table class="table">
        <thead>
        <tr>
            <th>No</th>
            <th>Tahun</th>
            <th>Periode</th>
            <th>Jabatan</th>
            <th>Unit Kerja</th>
            <th>Status</th>
        </tr>
        </thead>
        <tbody>
        <?php $x=1; $thn=0; $capaian=array(); foreach($skp as $lsdata){ ?>
            <tr>
                <td><?php echo $x++."."; ?></td>
                <td><?php echo $lsdata->tahun; ?></td>
                <td><?php echo $lsdata->periode_awal.' s/d '.$lsdata->periode_akhir; ?></td>
                <td><strong><?php echo $lsdata->jabatan_pegawai; ?></strong></td>
                <td><?php echo $lsdata->unit_kerja ?></td>
                <td><?php echo $lsdata->status ?></td>
            </tr>
            <tr>
                <td style="background-color: rgba(205,205,208,0.35)"></td>
                <td colspan="5" style="text-align: right;background-color: rgba(205,205,208,0.35)">Rata-rata Capaian: <?php echo $lsdata->jml_rata2_pencapaian ?> |
                    Rata-rata Perilaku: <?php echo $lsdata->avg_perilaku; ?>
                    (Orientasi Pelayanan: <?php echo $lsdata->orientasi_pelayanan ?>, Integritas: <?php echo $lsdata->integritas ?>,
                    Komitmen: <?php echo $lsdata->komitmen ?>, Disiplin: <?php echo $lsdata->disiplin ?>,
                    Kerjasama: <?php echo $lsdata->kerjasama ?><?php echo($lsdata->kepemimpinan==''?'':', Kepemimpinan: '.$lsdata->kepemimpinan); ?>)
                    <?php
                        if($thn==$lsdata->tahun){
                            $capaian[] = $lsdata->jml_rata2_pencapaian;
                            $nilaiSkp = round(array_sum($capaian)/count($capaian),2);
                            echo '<br>'."SKP Gabungan Thn. $thn Rata-rata Capaian:".$nilaiSkp;
                            echo '<br>60% Capaian:'.round(0.6*$nilaiSkp,2).', 40% Perilaku:'.round(0.4*$lsdata->avg_perilaku,2);
                            echo ' | NPK: '.round((0.6*$nilaiSkp)+(0.4*$lsdata->avg_perilaku), 2);
                            echo ' ('.$this->pegawai->sebutan_capaian((0.6*$lsdata->jml_rata2_pencapaian)+(0.4*$lsdata->avg_perilaku)).')';
                        }else{
                            $thn=$lsdata->tahun;
                            $capaian = array();
                            $capaian[] = $lsdata->jml_rata2_pencapaian;
                            echo '<br>60% Capaian:'.round(0.6*$lsdata->jml_rata2_pencapaian,2).', 40% Perilaku:'.round(0.4*$lsdata->avg_perilaku,2);
                            echo ' | NPK: '.round((0.6*$lsdata->jml_rata2_pencapaian)+(0.4*$lsdata->avg_perilaku), 2);
                            echo ' ('.$this->pegawai->sebutan_capaian((0.6*$lsdata->jml_rata2_pencapaian)+(0.4*$lsdata->avg_perilaku)).')';
                        }
                    ?>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>

</div>