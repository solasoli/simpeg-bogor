<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div class="container">
    <h2>DAFTAR ORGANISASI PERANGKAT DAERAH</h2>
    <table class="table bordered striped" id="lst_data">
        <thead style="border-bottom: solid #a4c400 2px;">
        <tr>
            <th>No</th>
            <th>OPD</th>
            <th>Alamat</th>
            <th>Aksi</th>
        </tr>
        </thead>
        <?php if (sizeof($list_data) > 0): ?>
            <?php $i = 1; ?>
            <?php if($list_data!=''): ?>
            <?php foreach ($list_data as $lsdata): ?>
            <tr>
                <td><?php echo $i; ?></td>
                <td><?php echo $lsdata->nama_baru ?></td>
                <td><?php echo $lsdata->Alamat ?></td>
                <td width="15%">
                    <a href="<?php echo base_url('index.php/phpexcel/excel_daftar_pegawai_opd/index/').'/'.$lsdata->id_unit_kerja ?>" class="button bg-darkBlue fg-white" target="_blank">Download Excel Daftar Pegawai</a>
                </td>
            </tr>
        <?php $i++; ?>
        <?php endforeach; ?>
            <script type="text/javascript">
                var table = $('#lst_data').DataTable();
            </script>
        <?php else: ?>
            <tr class="error">
                <td colspan="9"><i>Tidak ada data</i></td>
            </tr>
        <?php endif; ?>
        <?php else: ?>
            <tr class="error">
                <td colspan="9"><i>Tidak ada data</i></td>
            </tr>
        <?php endif; ?>
    </table>
</div>

