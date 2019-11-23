<?php
    $unit_kerja = new Unit_kerja;
?>
<link href="js/bootstrap-datetimepicker-master/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css" />
<script src="js/moment.js"></script>
<script src="js/bootstrap-datetimepicker-master/bootstrap-datetimepicker.min.js"></script>

<h4>DAFTAR PEGAWAI PLT dan PLH <?php echo $unit_kerja->get_unit_kerja($unit['id_skpd'])->singkatan ?></h4>

<table id="list_pegawai" class="table table-bordered display" cellspacing="0" width="100%">
    <thead>
    <tr>
        <th>No</th>
        <th>Nama</th>
        <th>Jabatan</th>
        <th>Status</th>
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
