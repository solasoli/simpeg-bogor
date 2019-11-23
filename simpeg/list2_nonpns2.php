<?php
    $unit_kerja = new Unit_kerja;
    if (@$issubmit == 'true') {
        if (isset($btnHapusTkk)) {
            $sql = "delete from tkk where id_tkk = $idnon_pns";
            if (mysqli_query($mysqli,$sql)) {
                echo "<span style='font-size: medium; font-weight: bold; color: darkgreen;'>Data Non PNS sukses terhapus</span><br>";
            }
        }
        if(isset($btnSimpanAdd)){
            if($nama == '' and $jabatan == ''){
                echo "<span style='font-size: medium; font-weight: bold; color: red;'>Nama dan Jabatan tidak boleh kosong</span>";
            }else{
                $nama = "'".$nama."'";
                if($tmt_masuk=='' or $tmt_masuk=='--'){
                    $tmt_masuk = 'NULL';
                }else{
                    $tmt_masuk = explode("-", $tmt_masuk);
                    $tmt_masuk = "'".$tmt_masuk[2] . '-' . $tmt_masuk[1] . '-' . $tmt_masuk[0]."'";
                }
                $tmpt_lahir = "'".$tmpt_lahir."'";
                if($tgl_lahir=='' or $tgl_lahir=='--'){
                    $tgl_lahir = 'NULL';
                }else{
                    $tgl_lahir = explode("-", $tgl_lahir);
                    $tgl_lahir = "'".$tgl_lahir[2] . '-' . $tgl_lahir[1] . '-' . $tgl_lahir[0]."'";
                }
                $jabatan = "'".$jabatan."'";
                $no_ktp = "'".$no_ktp."'";
                $no_kk = "'".$no_kk."'";
                $institusi = "'".$institusi."'";
                $jurusan = "'".$jurusan."'";
                if($tgl_pensiun=='' or $tgl_pensiun=='--'){
                    $tgl_pensiun = 'NULL';
                }else{
                    $tgl_pensiun = explode("-", $tgl_pensiun);
                    $tgl_pensiun = "'".$tgl_pensiun[2] . '-' . $tgl_pensiun[1] . '-' . $tgl_pensiun[0]."'";
                }
                $thn_lulus = ($thn_lulus==''?0:$thn_lulus);
                $selOpd = $unit['id_skpd'];

                $sql = "insert into tkk(nama, id_unit_kerja, status, tmt, tempat_lahir, tgl_lahir, jabatan, no_ktp, no_kk,
                  levelp_last, jurusan, institusi, thn_lulus, tgl_modifikasi, flag_pensiun, tgl_pensiun)
                  values ($nama, $selOpd, $selStatus, $tmt_masuk, $tmpt_lahir, $tgl_lahir, $jabatan, $no_ktp,
                  $no_kk, $selPend, $jurusan, $institusi, $thn_lulus, NOW(), $selStatusPensiun, $tgl_pensiun)";

                if (mysqli_query($mysqli,$sql)) {
                    echo "<span style='font-size: medium; font-weight: bold; color: darkgreen;'>Data Non PNS sukses tersimpan</span><br>";
                }
            }
        }
        if(isset($btnEditTkk)){
            $sql = "select * from tkk where id_tkk = ".$idnon_pns;
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
                $tgl_pensiun = @$tgl_pensiun[2] . '-' . @$tgl_pensiun[1] . '-' . $tgl_pensiun[0];
            }
        }

        if(isset($btnSimpanEdit)){
            $nama = "'".$nama."'";
            if($tmt_masuk=='' or $tmt_masuk=='--'){
                $tmt_masuk = 'NULL';
            }else{
                $tmt_masuk = explode("-", $tmt_masuk);
                $tmt_masuk = "'".$tmt_masuk[2] . '-' . $tmt_masuk[1] . '-' . $tmt_masuk[0]."'";
            }
            $tmpt_lahir = "'".$tmpt_lahir."'";
            if($tgl_lahir=='' or $tgl_lahir=='--'){
                $tgl_lahir = 'NULL';
            }else{
                $tgl_lahir = explode("-", $tgl_lahir);
                $tgl_lahir = "'".$tgl_lahir[2] . '-' . $tgl_lahir[1] . '-' . $tgl_lahir[0]."'";
            }
            $jabatan = "'".$jabatan."'";
            $no_ktp = "'".$no_ktp."'";
            $no_kk = "'".$no_kk."'";
            $institusi = "'".$institusi."'";
            $jurusan = "'".$jurusan."'";
            if($tgl_pensiun=='' or $tgl_pensiun=='--'){
                $tgl_pensiun = 'NULL';
            }else{
                $tgl_pensiun = explode("-", $tgl_pensiun);
                $tgl_pensiun = "'".$tgl_pensiun[2] . '-' . $tgl_pensiun[1] . '-' . $tgl_pensiun[0]."'";
            }
            $thn_lulus = ($thn_lulus==''?0:$thn_lulus);
            $selOpd = $unit['id_skpd'];

            $sql = "update tkk set nama = $nama, id_unit_kerja = $selOpd, status = $selStatus, tmt = $tmt_masuk,
            tempat_lahir = $tmpt_lahir, tgl_lahir = $tgl_lahir, jabatan = $jabatan, no_ktp = $no_ktp, no_kk = $no_kk,
            levelp_last = $selPend, jurusan = $jurusan, institusi = $institusi, thn_lulus = $thn_lulus, tgl_modifikasi = NOW(),
            flag_pensiun = $selStatusPensiun, tgl_pensiun = $tgl_pensiun
            where id_tkk = $idtkk";

            if (mysqli_query($mysqli,$sql)) {
                echo "<span style='font-size: medium; font-weight: bold; color: darkgreen;'>Data Non PNS sukses tersimpan</span><br>";
            }
        }
    }
?>

<link href="js/bootstrap-datetimepicker-master/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css" />
<script src="js/moment.js"></script>
<script src="js/bootstrap-datetimepicker-master/bootstrap-datetimepicker.min.js"></script>

<h4>DAFTAR PEGAWAI NON-PNS <?php echo $unit_kerja->get_unit_kerja($unit['id_skpd'])->singkatan ?></h4>

<div role="tabpanel">
    <ul class="nav nav-tabs" role="tablist" id="myTab">
        <li role="presentation" <?php echo((@$edit==true or @$add==true)?'':'class="active"'); ?>>
            <a href="#list_data" aria-controls="list_data" role="tab" data-toggle="tab">List Data</a>
        </li>
        <li role="presentation" <?php echo((@$edit==true or @$add==true)?'class="active"':''); ?>>
            <a href="#tambah_data" aria-controls="tambah_data" role="tab" data-toggle="tab"><?php echo(isset($edit)==true?'Ubah Data':'Tambah Data Baru'); ?></a>
        </li>
    </ul>
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane <?php echo(($edit==true or $add==true)?'':'active'); ?>" id="list_data">
            <br>
            <table id="list_pegawai" class="table table-bordered display" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Tanggal Lahir</th>
                    <th>Jenis Pegawai</th>
                    <!--th class="hidden-print">New Gol<span style="color:red">*</span></th-->
                    <th>TMT</th>
                    <th>Jabatan</th>
                    <th class="hidden-print" style="width: 150px;">Aksi</th>
                    <th class="hidden-print" style="width: 20%;">Berkas</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $no = 1;
                $sql = "select a.*, count(st.id_sk) as jml_sk from
                    (select tkk.id_tkk, tkk.nama, tkk.tempat_lahir, tkk.tgl_lahir, tkk.tmt, tkk.jabatan, status_tkk.status as status
                    from tkk left join status_tkk on status_tkk.id = tkk.status
                    where id_unit_kerja=$unit[id_skpd]) a left join sk_tkk st on a.id_tkk = st.id_tkk and st.id_kategori_sk = 37
                    group by a.id_tkk order by a.nama";

                $q = mysqli_query($mysqli,$sql);
                while($tkk=mysqli_fetch_array($q)) { ?>
                    <tr>
                        <td><?php echo $no++ ?></td>
                        <td><?php echo $tkk['nama'] ?></td>
                        <td><?php echo $tkk['tgl_lahir'] ?> </td>
                        <td><?php echo $tkk['status'] ?></td>
                        <td><?php echo $tkk['tmt'] ?></td>
                        <td><?php echo $tkk['jabatan'] ?></td>
                        <td>
                            <form role="form" class="form-horizontal"
                                  action="index3.php?x=list2_nonpns2.php" method="post"
                                  enctype="multipart/form-data" name="frmNonPns" id="frmNonPns">
                                <input id="issubmit" name="issubmit" type="hidden" value="true"/>
                                <input type="hidden" id="idnon_pns" name="idnon_pns" value="<?php echo $tkk['id_tkk'];?>">
                                <input type="submit" class="btn btn-danger btn-sm"
                                       onclick="return confirm('Anda yakin akan menghapus data non pns ini?');"
                                       name="btnHapusTkk[<?php echo $data['id_tkk']; ?>]"
                                       id="btnHapusTkk[<?php echo $data['id_tkk']; ?>]"
                                       value="Hapus" />
                                <input class="btn btn-primary btn-sm" type="submit"
                                       onclick="return confirm('Anda yakin akan mengubah data non pns ini?');"
                                       name="btnEditTkk[<?php echo $data['id_tkk']; ?>]"
                                       id="btnEditTkk[<?php echo $data['id_tkk']; ?>]"
                                       value="Edit Data" />
                            </form>
                        </td>
                        <td>
                            <?php
                            if($tkk['jml_sk'] > 0) {
                                $sql = "select a.*, ib.file_name from
                            (select st.id_sk, st.no_sk, st.tmt_mulai, st.tmt_akhir, st.id_berkas
                            from sk_tkk st where st.id_tkk = ".$tkk['id_tkk']." and st.id_kategori_sk = 37) a
                            left join berkas_tkk be on a.id_berkas = be.id_berkas left join isi_berkas_tkk ib on be.id_berkas = ib.id_berkas";
                                //echo $sql;
                                $qsk = mysqli_query($mysqli,$sql);
                                $x=1;
                                while($datask=mysqli_fetch_array($qsk)) {
                                    $asli = basename($datask[5]);
                                    if (file_exists(str_replace("\\", "/", getcwd()) . '/Berkas/' . trim($asli))) {
                                        $ext[] = explode(".", $asli);
                                        $linkBerkasUsulan = "<a href='./Berkas/$asli' target='_blank' class=\"btn-sm btn-success\"><strong>Lihat Berkas</strong></a>";
                                        echo '<table><tr><td>' . $linkBerkasUsulan . '</td><td style="margin-left: -5px;">';
                                        echo '</td></tr></table>';
                                        unset($ext);
                                    }else{
                                        echo 'Belum ada berkas';
                                    }
                                }
                            }else{
                                echo 'Belum ada berkas';
                            }
                            ?>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
        <script>
            $(function () {
                $('#list_pegawai').dataTable({
                    "dom": 'T<"clear">lfrtip',
                    "tableTools": {
                        "sSwfPath": "assets/DataTables/extensions/TableTools/swf/copy_csv_xls_pdf.swf"
                    }
                });
            });
        </script>
        <div role="tabpanel" class="tab-pane <?php echo(($edit==true or $add==true)?'active':''); ?>" id="tambah_data">
            <br>
            <form class="form-horizontal" action="index3.php?x=list2_nonpns2.php" method="post"
                  enctype="multipart/form-data" name="frmNonPnsAdd" id="frmNonPnsAdd">
                <div class="row">
                    <div class="col-sm-6">
                        <input id="issubmit" name="issubmit" type="hidden" value="true"/>
                        <?php if($edit==true):?>
                            <input id="idtkk" name="idtkk" type="hidden" value="<?php echo $idtkk;?>"/>
                        <?php endif;?>
                        <div class="form-group">
                            <label class="control-label col-sm-4" for="nama">Nama</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" id="nama" name="nama" value="<?php echo ($edit==true?$nama:''); ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-4" for="tmpt_lahir">Tempat Lahir</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" id="tmpt_lahir" name="tmpt_lahir" value="<?php echo ($edit==true?$tmpt_lahir:''); ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-4" for="tgl_lahir">Tanggal Lahir</label>
                            <div class="col-sm-4">
                                <div class='input-group date' id='datetimepicker'>
                                    <input type="text" class="form-control" id="tgl_lahir" name="tgl_lahir" value="<?php echo ($edit==true?$tgl_lahir:date("d-m-Y")); ?>" >
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                </div>
                            </div>
                            <div class="col-sm-1" style="text-align: left;padding-left: 0px;">
                                <a style="margin-top:-2px;width: 35px;height: 40px;margin-left: -10px;" href="#" class="btn btn-lg btn-default" onclick="document.getElementById('tgl_lahir').value = '';">
                                    <span style="margin-left: -8px;" class="glyphicon glyphicon-remove-circle"></span></a>
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
                            <label class="control-label col-sm-4" for="no_ktp">No. KTP</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" id="no_ktp" name="no_ktp" value="<?php echo ($edit==true?$no_ktp:''); ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-4" for="no_kk">No. KK</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" id="no_kk" name="no_kk" value="<?php echo ($edit==true?$no_kk:''); ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-4" for="selPend">Tingkat Pendidikan</label>
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
                            <label class="control-label col-sm-4" for="jurusan">Jurusan</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" id="jurusan" name="jurusan" value="<?php echo ($edit==true?$jurusan:''); ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-4" for="institusi">Institusi</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" id="institusi" name="institusi" value="<?php echo ($edit==true?$institusi:''); ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-4" for="thn_lulus">Tahun Lulus</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" id="thn_lulus" name="thn_lulus" value="<?php echo ($edit==true?$thn_lulus:''); ?>">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6" style="margin-left: -15%">
                        <div class="form-group">
                            <label class="control-label col-sm-4" for="selStatus">Status Pegawai</label>
                            <div class="col-sm-5">
                                <select class="form-control" id="selStatus" name="selStatus">
                                    <?php
                                    $q=mysqli_query($mysqli,"SELECT *  FROM status_tkk");
                                    while($d=mysqli_fetch_array($q))
                                        echo("<option value=$d[0]>$d[1]</option>");
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-4" for="jabatan">Jabatan</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" id="jabatan" name="jabatan" value="<?php echo ($edit==true?$jabatan:''); ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-4" for="tmt_masuk">TMT. Masuk</label>
                            <div class="col-sm-4">
                                <div class='input-group date' id='datetimepicker3'>
                                    <input type="text" class="form-control" id="tmt_masuk" name="tmt_masuk" value="<?php echo ($edit==true?$tmt_masuk:date("d-m-Y")); ?>">
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                </div>
                            </div>
                            <div class="col-sm-1" style="text-align: left;padding-left: 0px;">
                                <a style="margin-top:-2px;width: 35px;height: 40px;margin-left: -10px;" href="#" class="btn btn-lg btn-default" onclick="document.getElementById('tmt_masuk').value = '';">
                                    <span style="margin-left: -8px;" class="glyphicon glyphicon-remove-circle"></span></a>
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
                            <label class="control-label col-sm-4" for="selStatusPensiun">Status Pensiun</label>
                            <div class="col-sm-5">
                                <select class="form-control" id="selStatusPensiun" name="selStatusPensiun">
                                    <option value=0 <?php echo($flagp==0?'selected':''); ?>>Belum Pensiun</option>
                                    <option value=1 <?php echo($flagp==1?'selected':''); ?>>Sudah Pensiun</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-4" for="tgl_pensiun">Tanggal Pensiun</label>
                            <div class="col-sm-4">
                                <div class='input-group date' id='datetimepicker2'>
                                    <input type="text" class="form-control" id="tgl_pensiun" name="tgl_pensiun" value="<?php echo ($edit==true?$tgl_pensiun:date("d-m-Y")); ?>">
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                </div>
                            </div>
                            <div class="col-sm-1" style="text-align: left;padding-left: 0px;">
                                <a style="margin-top:-2px;width: 35px;height: 40px;margin-left: -10px;" href="#" class="btn btn-lg btn-default" onclick="document.getElementById('tgl_pensiun').value = '';">
                                    <span style="margin-left: -8px;" class="glyphicon glyphicon-remove-circle"></span></a>
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
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6" style="text-align: left">
                        <div class="form-group">
                            <label class="control-label col-sm-4"></label>
                            <div class="col-sm-5">
                                <?php if($edit==true):?>
                                <button type="button" name="btnTambahData" id="btnTambahData" class="btn btn-success">
                                    <span class="glyphicon glyphicon-plus"></span> Tambah Data Baru</button>
                                    <script type="text/javascript">
                                        $("#btnTambahData").click(function () {
                                            window.open('/simpeg/index3.php?x=list2_nonpns2.php&add=true','_self');
                                        });
                                    </script>
                                    <button type="submit" class="btn btn-primary"
                                            id="btnSimpanEdit" name="btnSimpanEdit">
                                        <span class="glyphicon glyphicon-floppy-save"></span> Simpan</button>
                                <?php else: ?>
                                    <button type="submit" class="btn btn-primary"
                                            id="btnSimpanAdd" name="btnSimpanAdd">
                                        <span class="glyphicon glyphicon-floppy-save"></span> Simpan</button>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
