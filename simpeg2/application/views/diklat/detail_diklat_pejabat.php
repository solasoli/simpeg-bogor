<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<table class="table bordered">
    <tbody>
    <tr>
        <td rowspan="7" style="width: 20%">
            <img class="border-color-grey" width="130px" src="../../../../simpeg/foto/<?php echo $idp ?>.jpg" />
        </td>
    </tr>
        <tr>
            <td>NIP</td>
            <td><?php echo $nip ?></td>
        </tr>
        <tr>
            <td>Nama</td>
            <td><strong><?php echo $nama ?></strong></td>
        </tr>
        <tr>
            <td>Golongan</td>
            <td><?php echo $gol ?></td>
        </tr>
        <tr>
            <td>Jabatan</td>
            <td><?php echo $jab ?></td>
        </tr>
        <tr>
            <td>OPD</td>
            <td><?php echo $skpd ?></td>
        </tr>
        <tr>
            <td>Eselon</td>
            <td><?php echo $eselon ?> - ( <?php echo $status ?> )</td>
        </tr>
    </tbody>
</table>

<h5>Riwayat Diklat</h5>
<table class="table bordered striped" style="border: 1px solid rgba(111, 111, 111, 0.79);">
    <thead style="border-bottom: solid #a4c400 2px;">
    <tr>
        <th style="width:5%;border-top: 1px solid rgba(111, 111, 111, 0.79);border-left: 1px solid rgba(111, 111, 111, 0.79)">No</th>
        <th style="width:10%;border-top: 1px solid rgba(111, 111, 111, 0.79);border-left: 1px solid rgba(111, 111, 111, 0.79)"">Jenis</th>
        <th style="width:10px;border-top: 1px solid rgba(111, 111, 111, 0.79);border-left: 1px solid rgba(111, 111, 111, 0.79)"">Tgl.Diklat</th>
        <th style="width:35%;border-top: 1px solid rgba(111, 111, 111, 0.79);border-left: 1px solid rgba(111, 111, 111, 0.79)"">Nama Diklat</th>
        <th style="width:5%;border-top: 1px solid rgba(111, 111, 111, 0.79);border-left: 1px solid rgba(111, 111, 111, 0.79)"">Jam</th>
        <th style="width:20%;border-top: 1px solid rgba(111, 111, 111, 0.79);border-left: 1px solid rgba(111, 111, 111, 0.79)"">Penyelenggara</th>
        <th style="width:25%;border-top: 1px solid rgba(111, 111, 111, 0.79);border-left: 1px solid rgba(111, 111, 111, 0.79)"">No.STTPL</th>
    </tr>
    </thead>
    <tbody>
    <?php if (sizeof($list_data) > 0): ?>
        <?php $i = 1; ?>
        <?php if($list_data!=''): ?>
            <?php foreach ($list_data as $lsdata): ?>
                <tr>
                    <td style="border-left: 1px solid rgba(111, 111, 111, 0.79)"><?php echo $i; ?></td>
                    <td style="border-left: 1px solid rgba(111, 111, 111, 0.79)"><?php echo $lsdata->jenis_diklat; ?></td>
                    <td style="border-left: 1px solid rgba(111, 111, 111, 0.79)"><?php echo $lsdata->tgl_diklat; ?></td>
                    <td style="border-left: 1px solid rgba(111, 111, 111, 0.79)"><?php echo $lsdata->nama_diklat; ?></td>
                    <td style="border-left: 1px solid rgba(111, 111, 111, 0.79)"><?php echo $lsdata->jml_jam_diklat; ?></td>
                    <td style="border-left: 1px solid rgba(111, 111, 111, 0.79)"><?php echo $lsdata->penyelenggara_diklat; ?></td>
                    <td style="border-left: 1px solid rgba(111, 111, 111, 0.79)"><?php echo $lsdata->no_sttpl; ?></td>
                </tr>
                <?php $i++; ?>
            <?php endforeach; ?>
        <?php else: ?>
            <tr class="error">
                <td colspan="7"><i>Tidak ada data</i></td>
            </tr>
        <?php endif; ?>
    <?php else: ?>
        <tr class="error">
            <td colspan="7"><i>Tidak ada data</i></td>
        </tr>
    <?php endif; ?>
    </tbody>
</table>