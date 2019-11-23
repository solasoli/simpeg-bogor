<style>
    .fileUpload {
        position: relative;
        overflow: hidden;
        margin: 10px;
    }

    .fileUpload input.upload {
        position: absolute;
        top: 0;
        right: 0;
        margin: 0;
        padding: 0;
        font-size: 20px;
        cursor: pointer;
        opacity: 0;
        filter: alpha(opacity=0);
    }
</style>

<?php

    function namaBulan($i){
        switch ($i) {
            case '01':
                $nm = 'Januari';
                break;
            case '02':
                $nm = 'Februari';
                break;
            case '03':
                $nm = 'Maret';
                break;
            case '04':
                $nm = 'April';
                break;
            case '05':
                $nm = 'Mei';
                break;
            case '06':
                $nm = 'Juni';
                break;
            case '07':
                $nm = 'Juli';
                break;
            case '08':
                $nm = 'Agustus';
                break;
            case '09':
                $nm = 'September';
                break;
            case '10':
                $nm = 'Oktober';
                break;
            case '11':
                $nm = 'Nopember';
                break;
            case '12':
                $nm = 'Desember';
                break;
        }
        return $nm;
    }

?>


<?php
    $sql = "SELECT a.*, uk.nama_baru as unit FROM
            (SELECT sh.id_skp, sh.periode_awal, sh.periode_akhir, ss.status, sh.idberkas_ppk, sh.id_unit_kerja_pegawai
            FROM skp_header sh, skp_status ss
            WHERE sh.id_pegawai = $od AND sh.status_pengajuan = ss.kode_status) a
            LEFT JOIN unit_kerja uk ON a.id_unit_kerja_pegawai = uk.id_unit_kerja
            ORDER BY a.periode_awal";
    $query = $mysqli->query($sql);
    if ($query->num_rows > 0) {
?>
        <form role="form" class="form-horizontal"
              action="index3.php?x=box.php&od=<?php echo $od?>" method="post"
              enctype="multipart/form-data" name="frmUploadSkp" id="frmUploadSkp">
<input type="hidden" id="is_submit_file_skp" name="is_submit_file_skp" value="true">
<input type="hidden" id="idp_skp" name="idp_skp" value="<?php echo $od?>">
<table width="100%" border="0" cellpadding="3" cellspacing="0" class="table table-bordered">
    <thead>
        <tr>

            <th style="width: 3%">No</th>
            <th style="width: 22%" nowrap="nowrap">Periode</th>
            <th style="width: 30%">Unit Kerja</th>
            <th style="width: 15%">Status</th>
            <th style="width: 30%">Berkas</th>
        </tr>
    </thead>
    <tbody>
    <?php
        $x = 1;
        while ($oto = $query->fetch_array(MYSQLI_NUM)) {
            $periode_awal = explode("-",$oto[1]);
            $periode_akhir = explode("-",$oto[2]);

            if($oto[4]<>0 and $oto[4]<>""){
                $sqlCekBerkas = "SELECT ib.file_name, b.created_by, DATE_FORMAT(b.created_date,  '%d/%m/%Y %H:%i:%s') AS created_date, p.nip_baru, p.nama, b.id_kat
                                FROM berkas b LEFT JOIN pegawai p ON b.created_by = p.id_pegawai, isi_berkas ib
                                WHERE b.id_berkas = ib.id_berkas AND b.id_berkas = ".$oto[4];
                //echo $sqlCekBerkas;
                $query2 = $mysqli->query($sqlCekBerkas);
                if (isset($query2)) {
                    if ($query2->num_rows > 0) {
                        while ($oto1 = $query2->fetch_array(MYSQLI_NUM)) {
                            $asli = basename($oto1[0]);
                            if (file_exists(str_replace("\\", "/", getcwd()) . '/Berkas/' . trim($asli))) {
                                $ext[] = explode(".", $asli);
                                $linkBerkasSkp = "<a href='./Berkas/$asli' target='_blank'>Lihat Berkas SKP</a>";
                                $tglUpload = $oto1[2];
                                $uploader = $oto1[4].' ('.$oto1[3].')';
                                unset($ext);
                            } else {
                                $linkBerkasSkp = "";
                            }
                        }
                    }
                }
            }

            echo "<tr>";
            echo "<td>$x</td>";
            echo "<td>".$periode_awal[2].' '.namaBulan($periode_awal[1]).' '.$periode_awal[0]." s.d. ".$periode_akhir[2].' '.namaBulan($periode_akhir[1]).' '.$periode_akhir[0]."</td>";
            echo "<td>".$oto[6]."</td>";
            echo "<td>".$oto[3]."</td>";
            echo "<td>";
            if ($oto[4] <> "" and $oto[4] <> "0" and $linkBerkasSkp <> "") {
                echo "$linkBerkasSkp";
                echo "<small class=\"form-text text-muted\">";
                echo "<br>Tgl.Upload : " . $tglUpload . " oleh ".$uploader."</small>";
            ?>
                <br><div id='divBtnFile<?php echo $oto[0]; ?>' class="fileUpload btn btn-default" style='margin-top: 0px;text-align: center; margin-bottom: -3px; margin-left: -1px;'>
                    <span id='judulFile<?php echo $oto[0]; ?>'>Browse</span>
                    <input id="uploadFileSkp[<?php echo $oto[0]; ?>]" name='uploadFileSkp[<?php echo $oto[0]; ?>]' type="file"
                           class="upload uploadFileSkp<?php echo $oto[0]; ?>" accept=".pdf"/>
                </div>
                <script>
                    $('.uploadFileSkp<?php echo $oto[0];?>').bind('change', function () {
                        var fileSkpSize<?php echo $oto[0];?> = 0;
                        fileSkpSize<?php echo $oto[0];?> = this.files[0].size;
                        if (parseFloat(fileSkpSize<?php echo $oto[0];?>) > 5138471) {
                            alert('Ukuran file terlalu besar');
                            $("#judulFile<?php echo $oto[0];?>").text('Browse');
                            $(".uploadFileSkp<?php echo $oto[0];?>").val("");
                        } else {
                            $("#judulFile<?php echo $oto[0];?>").text('Satu File');
                        }
                    });
                </script>
            <?php }else{ ?>

                <div id='divBtnFile<?php echo $oto[0]; ?>' class="fileUpload btn btn-default" style='margin-top: 0px;text-align: center; margin-bottom: -3px; margin-left: -1px;'>
                    <span id='judulFile<?php echo $oto[0]; ?>'>Browse</span>
                    <input id="uploadFileSkp[<?php echo $oto[0]; ?>]" name='uploadFileSkp[<?php echo $oto[0]; ?>]' type="file"
                           class="upload uploadFileSkp<?php echo $oto[0]; ?>" accept=".pdf"/>
                </div>
                <script>
                    $('.uploadFileSkp<?php echo $oto[0];?>').bind('change', function () {
                        var fileSkpSize<?php echo $oto[0];?> = 0;
                        fileSkpSize<?php echo $oto[0];?> = this.files[0].size;
                        if (parseFloat(fileSkpSize<?php echo $oto[0];?>) > 5138471) {
                            alert('Ukuran file terlalu besar');
                            $("#judulFile<?php echo $oto[0];?>").text('Browse');
                            $(".uploadFileSkp<?php echo $oto[0];?>").val("");
                        } else {
                            $("#judulFile<?php echo $oto[0];?>").text('Satu File');
                        }
                    });
                </script>

            <?php }
            echo "</td>";
            echo "</tr>";
            $x++;
        }
    ?>
    </tbody>
</table>
            <input type="submit" onclick="return confirm('Anda yakin akan meng-unggah file SKP tersebut?');"
                   name="btnUploadSkp" id="btnUploadSkp" class="btn btn-success" value="Upload File SKP" />
        </form>
<?php
    }else{
        echo "Belum Ada Data";
    }
?>
