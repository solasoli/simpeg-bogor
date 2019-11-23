<?php if(isset($drop_other_data_rekomendasi)): ?>
    <?php foreach($drop_other_data_rekomendasi as $rp): ?>
        <li>
            <div><strong><?php echo $rp->nama; ?> (<span style="color: #0000cc"><?php echo $rp->nip_baru; ?></span>)</strong></div>
            <div><?php echo $rp->pangkat_gol. ' | Masa Kerja: '.$rp->masa_kerja.' | Usia: '.$rp->umur ;?>
                <div id="btn_detail" class="button" onclick="loadDetailPegawai(<?php echo $rp->no_reg; ?>, '<?php echo $jabatan; ?>',
                    '<?php echo $jbtn_eselon; ?>', '<?php echo $nama_baru_skpd; ?>', 'drop_type');">Detail</div>
                <div id="btn_up_emp" class="button" onclick="up_informasi_pegawai('<?php echo $rp->nip_baru; ?>', <?php echo $id_draft ?>)">
                    <span class=icon-arrow-up style="color: red;"></span></div>
            </div>
        </li>
    <?php endforeach; ?>
<?php endif; ?>

<script type="text/javascript">

</script>
