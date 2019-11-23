<?php
session_start();
include 'class/cls_ptk.php';
$oPtk = new Ptk();
$idp = $_GET['idpegawai'];
$nip = $_GET['nip'];
$nama_gaji = $_GET['nama_gaji'];

if($oPtk->connectSimGaji()){
    $konekGaji = true;
}else{
    $konekGaji = false;
}

?>

<div class="container" style="width: 100%;">
    <div class="row">
        <div class='col-md-6'>
            <span style="color:saddlebrown; font-weight: bold;">SIMGAJI</span><br>
            <?php if($konekGaji): ?>
            <div class="panel-group" style="overflow-y:scroll;height: 430px;width: 107%;">
                <div class="panel panel-primary">
                    <div class="panel-heading">Biodata</div>
                    <div class="panel-body">
                        <?php
                        $oBioSimpegGaji = $oPtk->view_biodata_simgaji($nip);
                        ?>
                        <?php if($oBioSimpegGaji->num_rows > 0): ?>
                            <?php while ($oto = $oBioSimpegGaji->fetch_array(MYSQLI_NUM)) {?>
                                <table class="display compact" width="100%" cellspacing="0">
                                    <tr><td>
                                            <strong><?php echo $oto[2];?></strong><br>
                                            NIP: <?php echo $oto[0];?><br>
                                            Tempat/Tgl.Lahir: <?php echo $oto[5].", ".$oto[6];?><br>
                                            Usia: <?php echo $oto[7];?><br>
                                            Golongan: <?php echo $oto[29];?><br>
                                            Eselon : <?php echo $oto[17];?><br>
                                            Jabatan : <?php echo ($oto[32]==''?'-':$oto[32]);?><br>
                                            Unit Kerja : <?php echo $oto[30];?><br>
                                            OPD: <?php echo $oto[31];?><br>
                                            Pendidikan: <?php echo ($oto[9]==''?'-':$oto[9]);?><br>
                                            BUP: <?php echo $oto[19];?> Thn (TMT: <?php echo $oto[12];?>)<br>
                                            Status: <?php echo $oto[28];?>
                                        </td>
                                    </tr>
                                </table>
                            <?php } ?>

                            <ul class="nav nav-tabs" role="tablist" id="myTab_BPKAD" style="margin-top: 10px;">
                                <li role="presentation" class="active">
                                    <a href="#rekapKel" aria-controls="rekapKel" role="tab" data-toggle="tab">Rekap Keluarga</a></li>
                                <li role="presentation">
                                    <a href="#histJiwa" aria-controls="histJiwa" role="tab" data-toggle="tab">Historis Jiwa</a></li>
                            </ul>
                            <div class="tab-content" style="margin-top: 10px;">
                                <div role="tabpanel" class="tab-pane active" id="rekapKel">
                                    <?php $oBioSimpegGaji = $oPtk->view_rekap_keluarga_simgaji($nip);
                                    if ($oBioSimpegGaji->num_rows > 0) {
                                        while ($oto = $oBioSimpegGaji->fetch_array(MYSQLI_NUM)) { ?>
                                            <table class="display compact" width="100%" cellspacing="0">
                                                <tr style="color: darkblue">
                                                    <td style="width: 30%"><span style="text-decoration: underline">Uraian</span></td>
                                                    <td style="width: 20%"><span style="text-decoration: underline">Jumlah</span></td>
                                                    <td style="width: 20%"><span style="text-decoration: underline">Tertunjang</span></td>
                                                </tr>
                                                <tr style="background-color: #eff0e7">
                                                    <td>Pasangan</td>
                                                    <td>&nbsp;&nbsp;&nbsp;<?php echo $oto[6]; ?></td>
                                                    <td>&nbsp;&nbsp;&nbsp;<?php echo $oto[13]; ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Anak</td>
                                                    <td>&nbsp;&nbsp;&nbsp;<?php echo $oto[10]; ?></td>
                                                    <td>&nbsp;&nbsp;&nbsp;<?php echo $oto[14]; ?></td>
                                                </tr>
                                                <tr style="background-color: #eff0e7">
                                                    <td>Lainnya</td>
                                                    <td>&nbsp;&nbsp;&nbsp;<?php echo $oto[11]; ?></td>
                                                    <td>&nbsp;&nbsp;&nbsp;0</td>
                                                </tr>
                                                <tr>
                                                    <td><i>Total</i></td>
                                                    <td><i>&nbsp;&nbsp;&nbsp;<?php echo $oto[12]; ?></i></td>
                                                    <td><i>&nbsp;&nbsp;&nbsp;<?php echo ((Int)$oto[13] + (Int)$oto[14]);?></i></td>
                                                </tr>
                                            </table>
                                            <?php
                                        }
                                    }else{
                                        echo 'Tidak ada data';
                                    }
                                    ?>
                                </div>
                                <div role="tabpanel" class="tab-pane" id="histJiwa">
                                    <?php $oBioSimpegGaji = $oPtk->view_historis_jiwa($nip);
                                    if ($oBioSimpegGaji->num_rows > 0) {
                                        $i = 1;
                                        ?>
                                        <div style="overflow-x:scroll;width: 100%;height: 200px;">
                                            <table class="table" width="100%" cellspacing="0">
                                                <thead>
                                                <tr style="border-bottom: 2px solid #9b1b20;">
                                                    <td>TMT.Gaji</td>
                                                    <td>J.Istri</td>
                                                    <td>J.Anak</td>
                                                    <td>Keterangan</td>
                                                    <td>Tgl.Update</td>
                                                    <td>Status</td>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php
                                                while ($oto = $oBioSimpegGaji->fetch_array(MYSQLI_NUM)) { ?>
                                                    <tr style="border-top: 1px solid #dbdcd3;">
                                                        <td><?php echo $oto[0]; ?></td>
                                                        <td><?php echo $oto[1]; ?></td>
                                                        <td><?php echo $oto[2]; ?></td>
                                                        <td><?php echo $oto[3]; ?></td>
                                                        <td><?php echo $oto[4]; ?></td>
                                                        <td><?php echo $oto[5]; ?></td>
                                                    </tr>
                                                    <?php
                                                } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                        <?php
                                    }else{
                                        echo 'Tidak ada data';
                                    }
                                    ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="panel panel-primary">
                    <div class="panel-heading">Daftar Keluarga</div>
                    <div class="panel-body">
                        <?php
                        $oKeluargaSimgaji = $oPtk->view_keluarga_simgaji($nip);
                        if ($oKeluargaSimgaji->num_rows > 0) {
                            $i = 1;
                            while ($oto = $oKeluargaSimgaji->fetch_array(MYSQLI_NUM)) { ?>
                                <table class="display compact" width="100%" cellspacing="0"
                                       style="margin-top: 5px;<?php echo (($i%2)==0?"'background-color:#FFFFFF;":"background-color: #F9F9F9;"); ?>" >
                                    <tr>
                                        <td rowspan="15" style="width:5%;vertical-align: top;">
                                            <?php echo $i++; ?>.</td>
                                        <td style="width:20%;vertical-align: top;">Nama</td><td style="width:5%;">:</td>
                                        <td style="width:70%;vertical-align: top;"><strong><?php echo $oto[2]; ?></strong></td>
                                    </tr>
                                    <tr>
                                        <td>J.Kelamin</td><td>:</td>
                                        <td><?php echo $oto[3]; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Hubungan</td><td>:</td>
                                        <td><?php echo $oto[4]; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Tgl.Lahir</td><td>:</td>
                                        <td><?php echo $oto[5]; ?>. Usia: <?php echo $oto[17]; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Tgl.Nikah</td><td>:</td>
                                        <td><?php echo ($oto[6]==''?'-':$oto[6]); ?></td>
                                    </tr>
                                    <tr>
                                        <td>Tgl.Cerai</td><td>:</td>
                                        <td><?php echo ($oto[7]==''?'-':$oto[7]); ?></td>
                                    </tr>
                                    <tr>
                                        <td>Tgl.Wafat</td><td>:</td>
                                        <td><?php echo ($oto[8]==''?'-':$oto[8]); ?></td>
                                    </tr>
                                    <tr>
                                        <td>Status</td><td>:</td>
                                        <td><span style="font-weight: bold;color: darkgreen;"><?php echo $oto[12]; ?></span></td>
                                    </tr>
                                    <tr>
                                        <td>Pekerjaan</td><td>:</td>
                                        <td><?php echo ($oto[15]==''?'-':$oto[15]); ?></td>
                                    </tr>
                                    <tr>
                                        <td>Tgl.SKS</td><td>:</td>
                                        <td><?php echo ($oto[9]==''?'-':$oto[9]); ?></td>
                                    </tr>
                                    <tr>
                                        <td>TAT SKS</td><td>:</td>
                                        <td><?php echo ($oto[10]==''?'-':$oto[10]); ?></td>
                                    </tr>
                                    <tr>
                                        <td>No.SKS</td><td>:</td>
                                        <td><?php echo (trim($oto[11])==''?'-':$oto[11]); ?></td>
                                    </tr>
                                    <tr>
                                        <td>NIP</td><td>:</td>
                                        <td><?php echo (trim($oto[13])==''?'-':$oto[13]); ?></td>
                                    </tr>
                                    <tr>
                                        <td>Inputer</td><td>:</td>
                                        <td><?php echo $oto[16]; ?></td>
                                    </tr>
                                </table>
                                <?php
                            }
                        }else{
                            echo 'Tidak ada data';
                        }
                        ?>
                    </div>
                </div>
            </div>
            <?php else: ?>
                Maaf, Tidak dapat terkoneksi ke Database SIM GAJI
            <?php endif; ?>
        </div>
        <div class='col-md-6'>
            <span style="color:#0000CC; font-weight: bold;">SIMPEG</span><br>
            <div class="panel-group" style="overflow-y:scroll;height: 430px;width: 107%;">
                <div class="panel panel-success">
                    <div class="panel-heading">Biodata</div>
                    <div class="panel-body">
                        <?php
                        $oBioSimpeg = $oPtk->view_biodata_simpeg($idp);
                        if ($oBioSimpeg->num_rows > 0) {
                            ?>
                            <table class="display compact" width="100%" cellspacing="0">
                                <?php while ($oto = $oBioSimpeg->fetch_array(MYSQLI_NUM)) {?>
                                    <tr><td rowspan="5" style="width: 20%;"><img style='float:left;width:70px;height:90px; margin-right:10px;' src="http://103.14.229.15/simpeg/foto/<?php echo $oto[0]; ?>.jpg" /></td>
                                        <td style="width: 80%;"><strong><?php echo $oto[2]; ?></strong></td></tr>
                                    <tr><td>NIP: <?php echo $oto[1]; ?></td></tr>
                                    <tr><td>Tempat/Tgl.Lahir: <?php echo $oto[8].', '.$oto[20]; ?></td></tr>
                                    <tr><td>Usia: <?php echo $oto[21]; ?></td></tr>
                                    <tr><td>Golongan: <?php echo $oto[4]; ?></td></tr>
                                    <tr><td colspan="2">Jenjab: <?php echo $oto[3]; ?>. Eselon: <?php echo ($oto[5]==''?'-':$oto[5]); ?></td></tr>
                                    <tr><td colspan="2">Jabatan: <?php echo ($oto[6]==''?'-':$oto[6]); ?></td></tr>
                                    <tr><td colspan="2">Unit Kerja: <?php echo ($oto[7]==''?'-':$oto[7]); ?></td></tr>
                                    <tr><td colspan="2">Pendidikan: <?php echo $oto[19]; ?></td></tr>
                                    <tr><td colspan="2">BUP: <?php echo $oto[22]." Thn (TMT: ".$oto[23].")"; ?></td></tr>
                                    <tr><td colspan="2">Status: <?php echo $oto[17]; ?></td></tr>
                                    <?php if($oto[18]==1): ?>
                                        <tr><td colspan="2">Tgl.Berhenti: <?php echo $oto[16]; ?></td></tr>
                                    <?php endif; ?>
                                <?php } ?>
                            </table>
                            <strong>Rekap Keluarga:</strong> <br>
                            <?php $oBioSimpeg = $oPtk->rekap_keluarga($idp);
                            if ($oBioSimpeg->num_rows > 0) {
                                while ($oto = $oBioSimpeg->fetch_array(MYSQLI_NUM)) { ?>
                                    <table class="display compact" width="100%" cellspacing="0">
                                        <tr style="color: darkblue">
                                            <td style="width: 30%"><span style="text-decoration: underline">Uraian</span></td>
                                            <td style="width: 20%"><span style="text-decoration: underline">Jumlah</span></td>
                                            <td style="width: 20%"><span style="text-decoration: underline">Tertunjang</span></td>
                                        </tr>
                                        <tr style="background-color: #eff0e7">
                                            <td>Pasangan</td>
                                            <td>&nbsp;&nbsp;&nbsp;<?php echo $oto[6]; ?></td>
                                            <td>&nbsp;&nbsp;&nbsp;<?php echo $oto[12]; ?></td>
                                        </tr>
                                        <tr>
                                            <td>Anak</td>
                                            <td>&nbsp;&nbsp;&nbsp;<?php echo $oto[7]; ?></td>
                                            <td>&nbsp;&nbsp;&nbsp;<?php echo $oto[13]; ?></td>
                                        </tr>
                                        <tr style="background-color: #eff0e7">
                                            <td>Lainnya</td>
                                            <td>&nbsp;&nbsp;&nbsp;<?php echo $oto[8]; ?></td>
                                            <td>&nbsp;&nbsp;&nbsp;0</td>
                                        </tr>
                                        <tr>
                                            <td><i>Total</i></td>
                                            <td><i>&nbsp;&nbsp;&nbsp;<?php echo $oto[9]; ?></i></td>
                                            <td><i>&nbsp;&nbsp;&nbsp;<?php echo ((Int)$oto[12] + (Int)$oto[13]);?></i></td>
                                        </tr>
                                    </table>
                                    <?php
                                }
                            }
                        }else{
                            echo 'Tidak ada data';
                        }
                        ?>
                    </div>
                </div>
                <div class="panel panel-success">
                    <div class="panel-heading">Daftar Keluarga</div>
                    <div class="panel-body">
                        <?php
                        $oKeluargaSimpeg = $oPtk->view_keluarga_simpeg($idp);
                        if ($oKeluargaSimpeg->num_rows > 0) {
                            $i = 1;
                            while ($oto = $oKeluargaSimpeg->fetch_array(MYSQLI_NUM)) {?>
                                <table class="display compact" width="100%" cellspacing="0"
                                       style="margin-top: 5px;<?php echo (($i%2)==0?"'background-color:#FFFFFF;":"background-color: #F9F9F9;"); ?>" >
                                    <tr>
                                        <td rowspan="<?php echo($oto[2]==10?'13':'10'); ?>" style="width:5%;vertical-align: top;">
                                            <?php echo $i++; ?>.</td>
                                        <td style="width:20%;">Nama</td><td style="width:5%;">:</td>
                                        <td style="width:70%;"><strong><?php echo $oto[4]; ?></strong></td>
                                    </tr>
                                    <tr>
                                        <td>J.Kelamin</td><td>:</td>
                                        <td><?php echo $oto[8]; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Hubungan</td><td>:</td>
                                        <td><?php echo $oto[3]; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Tgl.Lahir</td><td>:</td>
                                        <td><?php echo $oto[30]; ?>. Usia: <?php echo $oto[31]; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Tgl.Nikah</td><td>:</td>
                                        <td><?php echo ($oto[17]==''?'-':$oto[17]); ?></td>
                                    </tr>
                                    <tr>
                                        <td>Tgl.Cerai</td><td>:</td>
                                        <td><?php echo ($oto[23]==''?'-':$oto[23]); ?></td>
                                    </tr>
                                    <tr>
                                        <td>Tgl.Wafat</td><td>:</td>
                                        <td><?php echo ($oto[20]==''?'-':$oto[20]); ?></td>
                                    </tr>
                                    <tr>
                                        <td>Tunjangan</td><td>:</td>
                                        <td><span style="font-weight: bold;color: darkgreen;"><?php echo $oto[9]; ?></span></td>
                                    </tr>
                                    <tr>
                                        <td>Pekerjaan</td><td>:</td>
                                        <td><?php echo $oto[7]; ?></td>
                                    </tr>
                                    <?php if($oto[2]==10): ?>
                                        <tr>
                                            <td>Ijazah</td><td>:</td>
                                            <td><?php echo ($oto[26]==''?'-':$oto[26]); ?></td>
                                        </tr>
                                        <tr>
                                            <td>Sekolah</td><td>:</td>
                                            <td><?php echo ($oto[27]==''?'-':$oto[27]); ?></td>
                                        </tr>
                                        <tr>
                                            <td>Tgl.Lulus</td><td>:</td>
                                            <td><?php echo ($oto[28]==''?'-':$oto[28]); ?></td>
                                        </tr>
                                    <?php endif; ?>
                                    <tr>
                                        <td>Verifikasi</td><td>:</td>
                                        <td><?php echo $oto[11]; ?></td>
                                    </tr>
                                </table>
                                <?php
                            }
                        }else{
                            echo 'Tidak ada data';
                        }?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
