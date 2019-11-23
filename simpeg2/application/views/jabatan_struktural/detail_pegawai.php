<?php if(isset($detail_pegawai)): ?>
    <?php foreach($detail_pegawai as $r): ?>
        <div class="row">
            <div class="col-lg-12">
                <div>SKPD Tujuan : <?php echo $skpd_tujuan; ?></div>
                <div>Jabatan Struktural : <?php echo $nm_jabatan; ?></div>
                <div>Eselon : <?php echo $jbtn_eselon; ?></div>
                <div style="text-align:center; background-color:#d3d3d3;"><span>BIODATA CALON PEMANGKU JABATAN</span></div>
            </div>
        </div>
        <br>
        <div class="row">
            <table width="95%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td rowspan="15" width="20%" valign="top"><img src="<?php echo "http://103.14.229.15/simpeg/foto/".$r->idpegawai.".jpg"; ?>" class="rounded" width="100"></td>
                    <td>Nama</td>
                    <td valign="top">:</td>
                    <td><strong><?php echo $r->nama; ?></strong></td>
                </tr>
                <tr>
                    <td width="30%">NIP </td>
                    <td valign="top">:</td>
                    <td width="45%"><span style="color:#0000cc"><?php echo $r->nip; ?></span> </td>
                </tr>
                <tr>
                    <td width="30%" valign="top">Unit Kerja </td>
                    <td valign="top">:</td>
                    <td width="45%"><?php echo $r->nama_baru; ?> </td>
                </tr>
                <tr>
                    <td width="30%" valign="top">Jabatan </td>
                    <td valign="top">:</td>
                    <td width="45%">
                        <?php
                            echo $r->jabatan;
                            if($r->eselonering <> ''){
                                echo '.<br>Eselonering: '.$r->eselonering.' ('.$r->pengalaman_eselon_current.' Thn)';
                            }
                        ?> </td>
                </tr>
                <tr>
                    <td width="30%">Pangkat </td>
                    <td valign="top">:</td>
                    <td width="45%"><?php echo $r->pangkat; ?> <span style="font-size: small">
                        <?php if($jbtn_eselon=='IIB' or $jbtn_eselon=='IVB' or $jbtn_eselon=='V') {
                            echo '(nilai bayes: '.$r->bayes_val_golongan.')';
                        }
                        ?>
                        </span>
                    </td>
                </tr>
                <tr>
                    <td>Masa Kerja</td>
                    <td valign="top">:</td>
                    <td><?php echo $r->masa_kerja; ?> Tahun <span style="font-size: small">
                        <?php if($jbtn_eselon=='IIB' or $jbtn_eselon=='IVB' or $jbtn_eselon=='V') {
                            echo '(nilai bayes: '.$r->bayes_val_masakerja.')';
                        }
                        ?>
                        </span> </td>
                </tr>
                <tr>
                    <td>Umur</td>
                    <td valign="top">:</td>
                    <td><?php echo $r->umur; ?> Tahun <span style="font-size: small">
                        <?php if($jbtn_eselon=='IIB' or $jbtn_eselon=='IVB' or $jbtn_eselon=='V') {
                            echo '(nilai bayes: '.$r->bayes_val_umur.')';
                        }
                        ?>
                        </span> </td>
                </tr>
                <tr>
                    <td>Tingkat Pendidikan</td>
                    <td valign="top">:</td>
                    <td><?php echo $r->nama_pendidikan; ?> <span style="font-size: small">
                        <?php if($jbtn_eselon=='IIB' or $jbtn_eselon=='IVB' or $jbtn_eselon=='V') {
                            echo '(nilai bayes: '.$r->bayes_val_pendidikan.')';
                        }
                        ?>
                        </span> </td>
                </tr>
                <tr>
                    <td>Jenis Jabatan</td>
                    <td valign="top">:</td>
                    <td><?php echo $r->jenis_jbtn; ?> <span style="font-size: small">
                        <?php if($jbtn_eselon=='IIB' or $jbtn_eselon=='IVB' or $jbtn_eselon=='V') {
                            echo '(nilai bayes: '.$r->bayes_val_jenjab.')';
                        }
                        ?>
                        </span> </td>
                </tr>
                <tr>
                    <td>Diklat PIM II</td>
                    <td valign="top">:</td>
                    <td><?php echo $r->jml_diklat_pim_2; ?> Kali <span style="font-size: small">
                        <?php if($jbtn_eselon=='IIB' or $jbtn_eselon=='IVB' or $jbtn_eselon=='V') {
                            echo '(nilai bayes: '.$r->bayes_val_diklat_pim2.')';
                        }
                        ?>
                        </span> </td>
                </tr>
                <tr>
                    <td>Diklat PIM III</td>
                    <td valign="top">:</td>
                    <td><?php echo $r->jml_diklat_pim_3; ?> Kali <span style="font-size: small">
                        <?php if($jbtn_eselon=='IIB' or $jbtn_eselon=='IVB' or $jbtn_eselon=='V') {
                            echo '(nilai bayes: '.$r->bayes_val_diklat_pim3.')';
                        }
                        ?>
                        </span> </td>
                </tr>
                <tr>
                    <td>Diklat PIM IV</td>
                    <td valign="top">:</td>
                    <td><?php echo $r->jml_diklat_pim_4; ?> Kali <span style="font-size: small">
                        <?php if($jbtn_eselon=='IIB' or $jbtn_eselon=='IVB' or $jbtn_eselon=='V') {
                            echo '(nilai bayes: '.$r->bayes_val_diklat_pim4.')';
                        }
                        ?>
                        </span> </td>
                </tr>
                <tr>
                    <td>Pengalaman di SKPD Tujuan</td>
                    <td valign="top">:</td>
                    <td><?php echo $r->pengalaman_uk; ?> Tahun <span style="font-size: small">
                    <?php if($jbtn_eselon=='IIB' or $jbtn_eselon=='IVB' or $jbtn_eselon=='V') {
                        echo '(nilai bayes: ' . $r->bayes_val_pengalaman . ')';
                        }
                    ?>
                    </span> </td>
                </tr>
                <?php if($jbtn_eselon=='IIB' or $jbtn_eselon=='IVB' or $jbtn_eselon=='V'): ?>
                <tr>
                    <td>Total Skor</td>
                    <td valign="top">:</td>
                    <td><span style="color:#cd0a0a"><?php echo $r->bayes_val_total; ?></span></td>
                </tr>
                <?php endif; ?>
            </table>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    Tidak ada data detail pegawai.
<?php endif;