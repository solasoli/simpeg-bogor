<?php
include("konek.php");
extract($_POST);
extract($_GET);

$q=mysqli_query($mysqli,"select id_tkk,nama,nama_baru,unit_kerja.id_unit_kerja from tkk 
                      inner join unit_kerja on unit_kerja.id_unit_kerja=tkk.id_unit_kerja 
                      where status=2 order by nama");
?>
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="assets/bootstrap/css/bootstrap.css" >
<link rel="stylesheet" href="assets/bootstrap/css/tabdrop.css" >
<script src="https://code.jquery.com/jquery-1.12.4.js" type="text/javascript"></script>
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="assets/bootstrap/js/bootstrap.js"></script>
<script src="assets/bootstrap/js/bootstrap-tabdrop.js"></script>

<link href="js/bootstrap-datetimepicker-master/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css" />
<script src="js/moment.js"></script>
<script src="js/bootstrap-datetimepicker-master/bootstrap-datetimepicker.min.js"></script>

<div style="padding: 20px;padding-bottom: 0px;">
    <strong>Upload Berkas SK Pengangkatan Kembali Tenaga Honorer TKK : </strong> <br>
    <form class="form-inline" action="uploadk1.php" method="post" enctype="multipart/form-data"
          name="form1" style="border-bottom: 1px solid #060a21; padding-bottom: 10px;">
        <div class="form-group">
            <label for="idtkk">Nama TKK :</label>
            <select name="idtkk" id="idtkk" class="form-control" style="font-size: medium;">
                <?php
                while($data=mysqli_fetch_array($q))
                {
                    echo("<option value=$data[0]-$data[3]>$data[1] ($data[2]) </option>");
                }
                ?>
            </select>
        </div>
        <div class="form-group">

            <input type="file" name="sk" id="sk" style="font-size: medium;">
        </div>
        <input type="submit" class="btn btn-primary" name="button" id="button" value="Submit" style="font-size: medium;">
        <input type="button" name="btnTambahData" id="btnTambahData" class="btn btn-success" value="Tambah Data Baru" style="font-size: medium;"/>
        <script type="text/javascript">
            $("#btnTambahData").click(function () {
                window.open('/simpeg/k1.php?add=true','_self');
            });
        </script>
    </form>

<?php

if ($issubmit == 'true') {
    if (isset($btnHapusSk)) {
        $sql = "delete from sk_tkk where id_sk = $idsk_nya";
        if (mysqli_query($mysqli,$sql)) {
            echo "<span style='font-size: medium; font-weight: bold; color: darkred;'>Data SK sukses terhapus</span><br>";
        }
    }

    if (isset($btnHapusTkk)) {
        $sql = "delete from tkk where id_tkk = $idp_nya";
        if (mysqli_query($mysqli,$sql)) {
            echo "<span style='font-size: medium; font-weight: bold; color: darkred;'>Data TKK sukses terhapus</span><br>";
        }
    }

    if(isset($btnSimpanAdd)){
        if($nama == '' and $jabatan == ''){
            echo "<span style='font-size: medium; font-weight: bold; color: darkred;'>Nama dan Jabatan tidak boleh kosong</span>";
        }else{
            $nama = "'".$nama."'";
            $tmt_masuk = explode("-", $tmt_masuk);
            $tmt_masuk = "'".$tmt_masuk[2] . '-' . $tmt_masuk[1] . '-' . $tmt_masuk[0]."'";
            $tmpt_lahir = "'".$tmpt_lahir."'";
            $tgl_lahir = explode("-", $tgl_lahir);
            $tgl_lahir = "'".$tgl_lahir[2] . '-' . $tgl_lahir[1] . '-' . $tgl_lahir[0]."'";
            $jabatan = "'".$jabatan."'";
            $no_ktp = "'".$no_ktp."'";
            $no_kk = "'".$no_kk."'";
            $institusi = "'".$institusi."'";
            $jurusan = "'".$jurusan."'";
            $tgl_pensiun = explode("-", $tgl_pensiun);
            $tgl_pensiun = "'".$tgl_pensiun[2] . '-' . $tgl_pensiun[1] . '-' . $tgl_pensiun[0]."'";
            $thn_lulus = ($thn_lulus==''?0:$thn_lulus);

            $sql = "insert into tkk(nama, id_unit_kerja, status, tmt, tempat_lahir, tgl_lahir, jabatan, no_ktp, no_kk,
              levelp_last, jurusan, institusi, thn_lulus, tgl_modifikasi, flag_pensiun, tgl_pensiun)
              values ($nama, $selOpd, $selStatus, $tmt_masuk, $tmpt_lahir, $tgl_lahir, $jabatan, $no_ktp, 
              $no_kk, $selPend, $jurusan, $institusi, $thn_lulus, NOW(), $selStatusPensiun, $tgl_pensiun)";

            if (mysqli_query($mysqli,$sql)) {
                echo "<span style='font-size: medium; font-weight: bold; color: darkred;'>Data TKK sukses tersimpan</span><br>";
            }
        }
    }

    if(isset($btnEditTkk)){
        $sql = "select * from tkk where id_tkk = ".$idp_nya;
        $edit = true;
        $qed = mysqli_query($mysqli,$sql);
        while($edata=mysqli_fetch_array($qed)){
            $idtkk = $edata[0];
            $nama = $edata[1];
            $tmpt_lahir = $edata[5];
            $tgl_lahir = explode('-',$edata[6]);
            $tgl_lahir = $tgl_lahir[2] . '-' . $tgl_lahir[1] . '-' . $tgl_lahir[0];
            $no_ktp = $edata[8];
            $no_kk = $edata[9];
            $levelp = $edata[10];
            $jurusan = $edata[11];
            $institusi = $edata[12];
            $thn_lulus = $edata[13];
            $stsp = $edata[3];
            $jabatan = $edata[7];
            $idu = $edata[2];
            $tmt_masuk = explode('-',$edata[4]);
            $tmt_masuk = $tmt_masuk[2] . '-' . $tmt_masuk[1] . '-' . $tmt_masuk[0];
            $flagp = $edata[16];
            $tgl_pensiun = explode('-',$edata[17]);
            $tgl_pensiun = $tgl_pensiun[2] . '-' . $tgl_pensiun[1] . '-' . $tgl_pensiun[0];
        }
    }

    if(isset($btnSimpanEdit)){
        $nama = "'".$nama."'";
        $tmt_masuk = explode("-", $tmt_masuk);
        $tmt_masuk = "'".$tmt_masuk[2] . '-' . $tmt_masuk[1] . '-' . $tmt_masuk[0]."'";
        $tmpt_lahir = "'".$tmpt_lahir."'";
        $tgl_lahir = explode("-", $tgl_lahir);
        $tgl_lahir = "'".$tgl_lahir[2] . '-' . $tgl_lahir[1] . '-' . $tgl_lahir[0]."'";
        $jabatan = "'".$jabatan."'";
        $no_ktp = "'".$no_ktp."'";
        $no_kk = "'".$no_kk."'";
        $institusi = "'".$institusi."'";
        $jurusan = "'".$jurusan."'";
        $tgl_pensiun = explode("-", $tgl_pensiun);
        $tgl_pensiun = "'".$tgl_pensiun[2] . '-' . $tgl_pensiun[1] . '-' . $tgl_pensiun[0]."'";

        $sql = "update tkk set set nama = $nama, id_unit_kerja = $selOpd, status = $selStatus, tmt = $tmt_masuk,
        tempat_lahir = $tmpt_lahir, tgl_lahir = $tgl_lahir, jabatan = $jabatan, no_ktp = $no_ktp, no_kk = $no_kk,
        levelp_last = $selPend, jurusan = $jurusan, institusi = $institusi, thn_lulus = $thn_lulus, tgl_modifikasi = NOW(),
        flag_pensiun = $selStatusPensiun, tgl_pensiun = $tgl_pensiun   
        where id_tkk = $idtkk";

        if (mysqli_query($mysqli,$sql)) {
            echo "<span style='font-size: medium; font-weight: bold; color: darkred;'>Data Ubah TKK sukses tersimpan</span><br>";
        }
    }

}

$sql = "select a.*, count(st.id_sk) as jml_sk from
(select id_tkk,nama,nama_baru, tkk.tgl_lahir, tkk.jabatan, tkk.tempat_lahir, tkk.tmt  
from tkk inner join unit_kerja on unit_kerja.id_unit_kerja=tkk.id_unit_kerja 
 where status=2) a left join sk_tkk st on a.id_tkk = st.id_tkk and st.id_kategori_sk = 37 
 group by a.id_tkk
 order by a.nama";

$q = mysqli_query($mysqli,$sql);
?>

<div id="container" style="padding: 20px;">
    <div role="tabpanel">
        <ul class="nav nav-tabs" role="tablist" id="myTab">
            <li role="presentation" <?php echo(($edit==true or $add==true)?'':'class="active"'); ?>>
                <a href="#list_tkk" aria-controls="list_tkk" role="tab" data-toggle="tab" style="font-size: medium; color: darkgreen; font-weight: bold;">Daftar TKK</a></li>
            <li role="presentation" <?php echo(($edit==true or $add==true)?'class="active"':''); ?>>
                <a href="#add_new" aria-controls="add_new" role="tab" data-toggle="tab" style="font-size: medium; color: darkgreen; font-weight: bold;"><?php echo($edit==true?'Ubah':'Tambah'); ?> Data Tenaga Honorer</a></li>
        </ul>
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane <?php echo(($edit==true or $add==true)?'':'active'); ?>" id="list_tkk">
                <br>
                <strong>DAFTAR PEGAWAI NON PNS TKK</strong>
                <table id="tbl_data" class="display">
                    <thead>
                    <tr>
                        <th>No</th><th>Nama</th><th style="width: 15%">Tempat/Tgl.Lahir</th><th>Unit</th>
                        <th>Jabatan</th><th style="width: 10%">TMT</th><th style="width: 25%">Berkas</th>
                    </tr></thead>
                    <tbody>
                    <?php
                    $i=1;
                    while($data=mysqli_fetch_array($q)){ ?>
                        <tr>
                            <td><?php echo $i++;?></td>
                            <td>
                                <table>
                                    <tr>
                                        <td><?php echo $data[1];?></td>
                                        <td style="width: 40%">
                                            <form role="form" class="form-horizontal"
                                                  action="k1.php" method="post"
                                                  enctype="multipart/form-data" name="frmTkk" id="frmTkk"
                                                  style="margin-top: -10px;margin-bottom: -15px;">
                                                <input id="issubmit" name="issubmit" type="hidden" value="true"/>
                                                <input type="hidden" id="idp_nya" name="idp_nya" value="<?php echo $data[0];?>">
                                                <input style="font-size: medium; background-color: lightgoldenrodyellow;" type="submit"
                                                       onclick="return confirm('Anda yakin akan menghapus data tkk ini?');"
                                                       name="btnHapusTkk[<?php echo $data[0]; ?>]"
                                                       id="btnHapusTkk[<?php echo $data[0]; ?>]"
                                                       value=" x " />
                                                <input style="font-size: medium; background-color: lightgoldenrodyellow;" type="submit"
                                                       onclick="return confirm('Anda yakin akan mengubah data tkk ini?');"
                                                       name="btnEditTkk[<?php echo $data[0]; ?>]"
                                                       id="btnEditTkk[<?php echo $data[0]; ?>]"
                                                       value="!" />
                                            </form>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                            <td><?php echo $data[5].', '.$data[3];?></td>
                            <td><?php echo $data[2];?></td>
                            <td><?php echo $data[4];?></td>
                            <td><?php echo $data[6];?></td>
                            <td>
                                <?php
                                if($data[7] > 0) {
                                    echo '<table style="margin-bottom: -10px;margin-top: -5px;"><tr><td>';
                                    echo 'Jumlah SK : '.$data[7].'</td>';
                                    $sql = "select a.*, ib.file_name from 
                                    (select st.id_sk, st.no_sk, st.tmt_mulai, st.tmt_akhir, st.id_berkas
                                    from sk_tkk st where st.id_tkk = ".$data[0]." and st.id_kategori_sk = 37) a
                                    left join berkas_tkk be on a.id_berkas = be.id_berkas left join isi_berkas_tkk ib on be.id_berkas = ib.id_berkas";
                                    $qsk = mysqli_query($mysqli,$sql);
                                    $x=1;
                                    echo '<td>';
                                    while($datask=mysqli_fetch_array($qsk)){
                                        $asli = basename($datask[5]);
                                        if (file_exists(str_replace("\\", "/", getcwd()) . '/Berkas/' . trim($asli))) {
                                            $ext[] = explode(".", $asli);
                                            $linkBerkasUsulan = "<a href='./Berkas/$asli' target='_blank' class=\"btn-sm btn-success\"><strong>Lihat Berkas</strong></a>";
                                            echo '<table><tr><td>'.$linkBerkasUsulan.'</td><td style="margin-left: -5px;">';
                                            ?>
                                            <form role="form" class="form-horizontal"
                                                  action="k1.php" method="post"
                                                  enctype="multipart/form-data" name="frmTkk" id="frmTkk"
                                                  style="margin-top: -10px;margin-bottom: -15px;">
                                                <input id="issubmit" name="issubmit" type="hidden" value="true"/>
                                                <input type="hidden" id="idsk_nya" name="idsk_nya" value="<?php echo $datask[0];?>">
                                                <input style="font-size: medium; background-color: lightgoldenrodyellow;" type="submit"
                                                       onclick="return confirm('Anda yakin akan menghapus data sk ini?');"
                                                       name="btnHapusSk[<?php echo $datask[0]; ?>]"
                                                       id="btnHapusSk[<?php echo $datask[0]; ?>]"
                                                       value=" x " />
                                            </form>
                                            <?php
                                            echo '</td></tr></table>';
                                            unset($ext);
                                        }
                                    }
                                    echo '</td></tr></table>';
                                }else{
                                    echo 'Belum ada berkas SK';
                                }
                                ?>

                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
            <div role="tabpanel" class="tab-pane <?php echo(($edit==true or $add==true)?'active':''); ?>" id="add_new">
                <br>
                <form class="form-horizontal" action="k1.php" method="post"
                      enctype="multipart/form-data" name="frmTkkAdd" id="frmTkkAdd">
                <div class="row">
                    <div class="col-sm-6">
                            <input id="issubmit" name="issubmit" type="hidden" value="true"/>
                            <?php if($edit==true):?>
                                <input id="idtkk" name="idtkk" type="hidden" value="<?php echo $idtkk;?>"/>
                            <?php endif;?>
                            <div class="form-group">
                                <label class="control-label col-sm-3" for="nama">Nama</label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control" id="nama" name="nama" value="<?php echo ($edit==true?$nama:''); ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-3" for="tmpt_lahir">Tempat Lahir</label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control" id="tmpt_lahir" name="tmpt_lahir" value="<?php echo ($edit==true?$tmpt_lahir:''); ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-3" for="tgl_lahir">Tanggal Lahir</label>
                                <div class="col-sm-4">
                                    <div class='input-group date' id='datetimepicker'>
                                        <input type="text" class="form-control" id="tgl_lahir" name="tgl_lahir" value="<?php echo ($edit==true?$tgl_lahir:date("d-m-Y")); ?>" readonly="readonly" >
                                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                    </div>
                                </div>
                                <div class="col-sm-1" style="text-align: left;padding-left: 0px;">
                                    <a style="height: 35px;width: 35px;" href="#" class="btn btn-lg btn-default" onclick="document.getElementById('tgl_lahir').value = '';">
                                        <span style="margin-top: -3px;margin-left: -8px;" class="glyphicon glyphicon-remove-circle"></span></a>
                                </div>
                            </div>
                            <script>
                                $(function () {
                                    $('#datetimepicker').datetimepicker({
                                        format: 'DD-MM-YYYY',
                                        ignoreReadonly: true
                                    });
                                });
                            </script>
                            <div class="form-group">
                                <label class="control-label col-sm-3" for="no_ktp">No. KTP</label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control" id="no_ktp" name="no_ktp" value="<?php echo ($edit==true?$no_ktp:''); ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-3" for="no_kk">No. KK</label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control" id="no_kk" name="no_kk" value="<?php echo ($edit==true?$no_kk:''); ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-3" for="selPend">Tingkat Pendidikan</label>
                                <div class="col-sm-5">
                                    <select class="form-control" id="selPend" name="selPend">
                                        <?php
                                        $q=mysqli_query($mysqli,"SELECT *  FROM kategori_pendidikan order by level_p");
                                        while($d=mysqli_fetch_array($q))
                                            echo("<option value=".$d[0].' '.($d[0]==$levelp?'selected':'').">".$d[1]."</option>");
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-3" for="jurusan">Jurusan</label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control" id="jurusan" name="jurusan" value="<?php echo ($edit==true?$jurusan:''); ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-3" for="institusi">Institusi</label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control" id="institusi" name="institusi" value="<?php echo ($edit==true?$institusi:''); ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-3" for="thn_lulus">Tahun Lulus</label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control" id="thn_lulus" name="thn_lulus" value="<?php echo ($edit==true?$thn_lulus:''); ?>">
                                </div>
                            </div>
                    </div>
                    <div class="col-sm-6" style="margin-left: -15%">
                        <div class="form-group">
                            <label class="control-label col-sm-3" for="selStatus">Status Pegawai</label>
                            <div class="col-sm-5">
                                <select class="form-control" id="selStatus" name="selStatus">
                                    <?php
                                    /*$q=mysqli_query($mysqli,"SELECT *  FROM status_tkk");
                                    while($d=mysqli_fetch_array($q))
                                        echo("<option value=$d[0]>$d[1]</option>");*/
                                    ?>
                                    <option value=2>TKK</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-3" for="jabatan">Jabatan</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" id="jabatan" name="jabatan" value="<?php echo ($edit==true?$jabatan:''); ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-3" for="selOpd">OPD</label>
                            <div class="col-sm-5">
                                <select class="form-control" id="selOpd" name="selOpd">
                                    <?php
                                    $q=mysqli_query($mysqli,"SELECT *  FROM unit_kerja 
                                    WHERE id_unit_kerja=id_skpd and tahun = (SELECT max(tahun) from unit_kerja)
                                    ORDER BY nama_baru");
                                    while($d=mysqli_fetch_array($q))

                                        echo("<option value=".$d[0].' '.($d[0]==$idu?'selected':'').">".$d[2]."</option>");
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-3" for="tmt_masuk">TMT. Masuk</label>
                            <div class="col-sm-4">
                                <div class='input-group date' id='datetimepicker3'>
                                    <input type="text" class="form-control" id="tmt_masuk" name="tmt_masuk" value="<?php echo ($edit==true?$tmt_masuk:date("d-m-Y")); ?>" readonly="readonly">
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                </div>
                            </div>
                            <div class="col-sm-1" style="text-align: left;padding-left: 0px;">
                                <a style="height: 35px;width: 35px;" href="#" class="btn btn-lg btn-default" onclick="document.getElementById('tmt_masuk').value = '';">
                                    <span style="margin-top: -3px;margin-left: -8px;" class="glyphicon glyphicon-remove-circle"></span></a>
                            </div>
                        </div>
                        <script>
                            $(function () {
                                $('#datetimepicker3').datetimepicker({
                                    format: 'DD-MM-YYYY',
                                    ignoreReadonly: true
                                });
                            });
                        </script>
                        <div class="form-group">
                            <label class="control-label col-sm-3" for="selStatusPensiun">Status Pensiun</label>
                            <div class="col-sm-5">
                                <select class="form-control" id="selStatusPensiun" name="selStatusPensiun">
                                    <option value=0 <?php echo($flagp==0?'selected':''); ?>>Belum Pensiun</option>
                                    <option value=1 <?php echo($flagp==1?'selected':''); ?>>Sudah Pensiun</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-3" for="tgl_pensiun">Tanggal Pensiun</label>
                            <div class="col-sm-4">
                                <div class='input-group date' id='datetimepicker2'>
                                    <input type="text" class="form-control" id="tgl_pensiun" name="tgl_pensiun" value="<?php echo ($edit==true?$tgl_pensiun:date("d-m-Y")); ?>" readonly="readonly">
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                </div>
                            </div>
                            <div class="col-sm-1" style="text-align: left;padding-left: 0px;">
                                <a style="height: 35px;width: 35px;" href="#" class="btn btn-lg btn-default" onclick="document.getElementById('tgl_pensiun').value = '';">
                                    <span style="margin-top: -3px;margin-left: -8px;" class="glyphicon glyphicon-remove-circle"></span></a>
                            </div>
                        </div>
                        <script>
                            $(function () {
                                $('#datetimepicker2').datetimepicker({
                                    format: 'DD-MM-YYYY',
                                    ignoreReadonly: true
                                });
                            });
                        </script>
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-3">
                                <?php if($edit==true):?>
                                    <button type="submit" class="btn btn-primary"
                                            id="btnSimpanEdit" name="btnSimpanEdit">Simpan</button>
                                <?php else: ?>
                                    <button type="submit" class="btn btn-primary"
                                        id="btnSimpanAdd" name="btnSimpanAdd">Simpan</button>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
<script>
    $(document).ready(function() {
        $('#tbl_data').DataTable({
            "iDisplayLength": 10
        });
    });

</script>