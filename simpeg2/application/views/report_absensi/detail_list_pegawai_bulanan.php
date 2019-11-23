<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<H5>DAFTAR PEGAWAI <?php echo $judul.' '.$tgl; ?></H5>
<h5><span style="color: darkred;font-weight: bold;"><?php echo $nama_unit[0]->opd?> Kota Bogor</span></h5>

<table class="table bordered" id="lst_data_detail">
<thead style="border-bottom: solid #a4c400 2px;">
<tr>
    <th style="width:5%;border-top: 1px solid rgba(111, 111, 111, 0.79);border-left: 1px solid rgba(111, 111, 111, 0.79)">No</th>
    <th style="width:13%;border-top: 1px solid rgba(111, 111, 111, 0.79)">NIP</th>
    <th style="width:37%;border-top: 1px solid rgba(111, 111, 111, 0.79)">Nama</th>
    <th style="width:7%;border-top: 1px solid rgba(111, 111, 111, 0.79)">Gol.</th>
    <th style="width:45%;border-top: 1px solid rgba(111, 111, 111, 0.79)">Jabatan</th>
    <?php if($status=='All'): ?>
        <th style="width:5%;border-top: 1px solid rgba(111, 111, 111, 0.79)">Status</th>
    <?php endif; ?>
    <?php if($tgl==''): ?>
        <th style="width:5%;border-top: 1px solid rgba(111, 111, 111, 0.79)">TGL</th>
    <?php endif; ?>
</tr>
</thead>
<tbody>
    <?php if (sizeof($list_data) > 0): ?>
    <?php $i = 1; ?>
        <?php if($list_data!=''): ?>
            <?php foreach ($list_data as $lsdata): ?>
                <tr>
                    <td style="border-bottom: solid #666666 1px;"><?php echo $i; ?></td>
                    <td style="border-bottom: solid #666666 1px;"><span style="color: darkblue"><?php echo $lsdata->nip_baru ?></span></td>
                    <td style="border-bottom: solid #666666 1px;"><strong><?php echo $lsdata->nama ?></strong></td>
                    <td style="border-bottom: solid #666666 1px;"><?php echo $lsdata->pangkat_gol ?></td>
                    <td style="border-bottom: solid #666666 1px;"><?php echo $lsdata->jabatan ?></td>
                    <?php if($status=='All'): ?>
                        <td style="border-bottom: solid #666666 1px;"><?php echo $lsdata->status ?></td>
                    <?php endif; ?>
                    <?php if($tgl==''): ?>
                        <td style="border-bottom: solid #666666 1px;"><?php echo $lsdata->tgl ?></td>
                    <?php endif; ?>
                </tr>
                <?php $i++; ?>
            <?php endforeach; ?>
        <?php else: ?>
            <tr class="error">
                <td colspan="5"><i>Tidak ada data</i></td>
            </tr>
        <?php endif; ?>
    <?php else: ?>
        <tr class="error">
            <td colspan="5"><i>Tidak ada data</i></td>
        </tr>
    <?php endif; ?>
</tbody>
</table>

<script>
    $('#lst_data_detail').dataTable();
</script>