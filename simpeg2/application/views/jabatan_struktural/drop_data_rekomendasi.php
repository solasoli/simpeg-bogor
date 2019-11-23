<?php if(isset($drop_other_data_rekomendasi)): ?>
    <?php foreach($drop_other_data_rekomendasi as $rp): ?>
        <li>
            <table style="border-bottom: 1px solid rgba(192, 192, 192, 0.8);margin-bottom: 5px;">
                <tr>
                    <td width="7%" rowspan="2" style="vertical-align: top;"><img src='http://103.14.229.15/simpeg/foto/<?php echo $rp->idpegawai?>.jpg' width='50px' />
                        <div id="btn_up_emp" class="button" onclick="up_informasi_pegawai('<?php echo $rp->nip; ?>', <?php echo $id_draft ?>)"
                             style="width: 50px;"><span class=icon-arrow-up style="color: red;"></span></div>
                        <div id="btn_detail" class="button" onclick="loadDetailPegawai(<?php echo $rp->no_reg; ?>, '<?php echo $jabatan; ?>',
                                '<?php echo $jbtn_eselon; ?>', '<?php echo $nama_baru_skpd; ?>', 'drop_type');"
                             style="width: 50px;border-top: 1px solid rgba(71,71,72,0.78)"><strong>...</strong></div>
                    </td>
                    <td width="20%" style="vertical-align: top;"><span style="color: #0000cc"><?php echo $rp->nip; ?></span></td>
                    <td width="20%" style="vertical-align: top;"><strong><?php echo $rp->nama; ?></strong></td>
                    <td width="53%" style="vertical-align: top;"><?php echo $rp->pangkat; ?></td>
                </tr>
                <tr>
                    <td colspan="3">
                        Jabatan: <?php echo $rp->jabatan; ?><br>
                        Eselon: <?php echo $rp->eselonering ?> (Lamanya <?php echo $rp->pengalaman_eselon ?> Thn) | Umur: <?php echo $rp->umur ?> Thn |
                        Masa Kerja Keseluruhan: <?php echo $rp->masa_kerja ?> Thn <br>
                        Pengalaman pada unit kerja tujuan : <?php echo $rp->pengalaman_uk ?> Thn |
                        PIM II : <?php echo $rp->jml_diklat_pim_2 ?> | PIM III : <?php echo $rp->jml_diklat_pim_3 ?> | PIM IV : <?php echo $rp->jml_diklat_pim_4 ?>
                        <?php if($rp->jbtn_eselon=='IIB' or $rp->jbtn_eselon=='IVB' or $rp->jbtn_eselon=='V'): ?>
                            <?php echo ' | Total Skor : ';?><span style="color:#cd0a0a"><?php echo $rp->bayes_val_total; ?></span>
                        <?php endif; ?>
                        <br>Sertifikasi Barang dan Jasa : <?php echo ($rp->tgl_diklat_barjas==''?'-':$rp->tgl_diklat_barjas) ?><br>
                        <span style="font-weight: bold;">SKP 2 Tahun Terakhir</span> : <?php echo ($rp->skp==''?'-':'<br>'.$rp->skp) ?>
                    </td>
                </tr>
            </table>
        </li>
    <?php endforeach; ?>
<?php endif; ?>

<script type="text/javascript">

</script>
