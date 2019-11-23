<?php
    session_start();
    include 'class/cls_ptk.php';
    $oPtk = new Ptk();
    $idp = $_GET['idpegawai'];
    $nip = $_GET['nip'];
    if($oPtk->connectSimGaji()){
        $konekGaji = true;
    }else{
        $konekGaji = false;
    }

?>

<div class="container" style="width: 100%;">
    <div class="row">
        <div class="panel-group">
            <div class="panel panel-primary">
                <div class="panel-heading">Daftar Keluarga di SIMGAJI</div>
                <div class="panel-body">
                    <?php if($konekGaji): ?>
                    <div style="overflow-y:scroll;height: 180px;">
                        <?php
                        $oKeluargaSimgaji = $oPtk->view_keluarga_simgaji($nip);
                        if ($oKeluargaSimgaji->num_rows > 0) {
                            $i = 1;
                            ?>
                            <table id="table_sk" class="display compact" width="100%" cellspacing="0">
                                <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Nama</th>
                                    <th>J.Kelamin</th>
                                    <th>Hubungan</th>
                                    <th>Tgl.Lahir</th>
                                    <th>Tgl.Nikah</th>
                                    <th>Tgl.Cerai</th>
                                    <th>Tgl.Wafat</th>
                                    <th>Status</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                while ($oto = $oKeluargaSimgaji->fetch_array(MYSQLI_NUM)) {
                                    ?>
                                    <tr style="border-top: 1px solid #c0c2bb;">
                                        <td><?php echo $i++; ?></td>
                                        <td><strong><?php echo $oto[2]; ?></strong></td>
                                        <td><?php echo $oto[3]; ?></td>
                                        <td><?php echo $oto[4]; ?></td>
                                        <td><?php echo $oto[5]; ?></td>
                                        <td><?php echo $oto[6]; ?></td>
                                        <td><?php echo $oto[7]; ?></td>
                                        <td><?php echo $oto[8]; ?></td>
                                        <td><?php echo $oto[12]; ?></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td colspan="8">
                                            <div class="row" style='border: solid 1px #eff0e7; background: #f7f8ef;padding: 1px;width: 100%;'>
                                                <div class="col-md-12" style='font-style: normal;'>
                                                    Usia: <?php echo $oto[17]; ?>,
                                                    Tgl.SKS: <?php echo $oto[9]; ?>, TAT SKS: <?php echo $oto[10]; ?>,
                                                    NO.SKS: <?php echo $oto[11]; ?>, NIP Pasangan: <?php echo $oto[13]; ?>,
                                                    Pekerjaan: <?php echo $oto[15]; ?>, Inputer: <?php echo $oto[16]; ?>
                                                    <a href="javascript:void(0);" onclick="ubahDataKeluargaSIMGAJI('<?php echo $oto[0]; ?>','<?php echo $oto[1]; ?>');">
                                                        <img src="images/pencil.png" alt="Ubah Data Keluarga di SIMGAJI" title='Ubah Data Keluarga di SIMGAJI'
                                                             style="width:16px;height:16px;border:0;"></a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php
                                }
                                ?>
                                </tbody>
                            </table>
                            <?php
                        }else{
                            echo 'Tidak ada data';
                        }
                        ?>
                    </div>
                    <?php else: ?>
                        Maaf, Tidak dapat terkoneksi ke Database SIM GAJI
                    <?php endif; ?>
                </div>
            </div>

            <div class="panel panel-success">
                <div class="panel-heading">Daftar Keluarga di SIMPEG</div>
                <div class="panel-body">
                    <div style="overflow-y:scroll;height: 190px;">
                    <?php
                        $oKeluargaSimpeg = $oPtk->view_keluarga_simpeg($idp);
                        if ($oKeluargaSimpeg->num_rows > 0) {
                        $i = 1;
                    ?>
                            <table id="table_sk" class="display compact" width="100%" cellspacing="0">
                                <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Nama</th>
                                    <th>J.Kelamin</th>
                                    <th>Hubungan</th>
                                    <th>Tgl.Lahir</th>
                                    <th>Tgl.Nikah</th>
                                    <th>Tgl.Cerai</th>
                                    <th>Tgl.Wafat</th>
                                    <th>Tunjangan</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                while ($oto = $oKeluargaSimpeg->fetch_array(MYSQLI_NUM)) {
                                    ?>
                                    <tr style="border-top: 1px solid #c0c2bb;">
                                        <td><?php echo $i++; ?></td>
                                        <td><strong><?php echo strtoupper($oto[4]); ?></strong></td>
                                        <td><?php echo $oto[8]; ?></td>
                                        <td><?php echo $oto[3]; ?></td>
                                        <td><?php echo $oto[30]; ?></td>
                                        <td><?php echo $oto[17]; ?></td>
                                        <td><?php echo $oto[23]; ?></td>
                                        <td><?php echo $oto[20]; ?></td>
                                        <td><?php echo $oto[9]; ?></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td colspan="8">
                                            <div class="row" style='border: solid 1px #eff0e7; background: #f7f8ef;padding: 1px;width: 100%;'>
                                                <div class="col-md-12" style='font-style: normal;'>
                                                    Usia: <?php echo $oto[31]; ?>,
                                                    Pekerjaan: <?php echo $oto[7]; ?>,
                                                    <?php if($oto[2]==10): ?>
                                                        Ijazah: <?php echo $oto[26]; ?>, Sekolah: <?php echo $oto[27]; ?>,
                                                        Tgl.Lulus: <?php echo $oto[28]; ?>,
                                                    <?php endif; ?><br>
                                                    <span style="color: darkblue;">
                                                        Hasil Verifikasi Data : <?php echo $oto[11]; ?>
                                                    </span>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php
                                }

                                ?>
                                </tbody>
                            </table>
                        <?php
                    }else{
                        echo 'Tidak ada data';
                    }
                    ?>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script type="application/javascript">
    function ubahDataKeluargaSIMGAJI(nip, kdhubkel){
        alert(nip + ' - ' + kdhubkel);
    }
</script>