<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<H5>DAFTAR PEJABAT ESELON <?php echo $eselon; ?>
    <?php
    if (isset($status) != ""){
        if (strpos($status, 'Jumlah') !== false) {

        }else{
            echo strtoupper($status);
        }
    }
    ?> </H5>
<div id='divDetail' style='height:410px; overflow:auto;'>
    <table class="table bordered" id="lst_data_detail">
        <thead style="border-bottom: solid #a4c400 2px;">
        <tr>
            <th style="width:5%;border-top: 1px solid rgba(111, 111, 111, 0.79);border-left: 1px solid rgba(111, 111, 111, 0.79)">No</th>
            <th style="width:13%;border-top: 1px solid rgba(111, 111, 111, 0.79)">NIP</th>
            <th style="width:30px;border-top: 1px solid rgba(111, 111, 111, 0.79)">Nama</th>
            <th style="width:7%;border-top: 1px solid rgba(111, 111, 111, 0.79)">Gol.</th>
            <th style="width:45%;border-top: 1px solid rgba(111, 111, 111, 0.79)">Jabatan</th>
            <th style="width:45%;border-top: 1px solid rgba(111, 111, 111, 0.79)">OPD</th>
            <th style="width:45%;border-top: 1px solid rgba(111, 111, 111, 0.79)">Eselon</th>
        </tr>
        </thead>
        <tbody>
        <?php if (sizeof($list_data) > 0): ?>
            <?php $i = 1; ?>
            <?php if($list_data!=''): ?>
                <?php foreach ($list_data as $lsdata): ?>
                    <tr>
                        <td style="border-bottom: solid #666666 1px;"><?php echo $i; ?></td>
                        <td style="border-bottom: solid #666666 1px;">
                            <span style="color: darkblue"><?php echo $lsdata->nip_baru ?></span>
                            <?php
                                if (strpos($status, 'Jumlah') !== false) {
                                    echo $lsdata->status_diklat;
                                }
                            ?>
                        </td>
                        <td style="border-bottom: solid #666666 1px;"><strong><?php echo $lsdata->nama ?></strong></td>
                        <td style="border-bottom: solid #666666 1px;"><?php echo $lsdata->pangkat_gol ?></td>
                        <td style="border-bottom: solid #666666 1px;"><?php echo $lsdata->jabatan ?></td>
                        <td style="border-bottom: solid #666666 1px;"><?php echo $lsdata->unit_kerja ?></td>
                        <td style="border-bottom: solid #666666 1px;"><?php echo $lsdata->eselon ?></td>
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
</div>

