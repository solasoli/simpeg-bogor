<?php
    include "konek.php";
    $idskpd = $_GET['idskpd'];
    $txtKeyword = $_GET['txtkeyword'];
    $andKlausa = "";
    $andKlausa2 = "";
    if($idskpd!='0'){
        $andKlausa .= " AND uk.id_skpd = ".$idskpd;
    }
    if (!(trim($txtKeyword)== "") && !(trim($txtKeyword)== "0")){
        $andKlausa2 .= " WHERE (nip_baru LIKE '%".$txtKeyword."%'
                       OR nama LIKE '%".$txtKeyword."%'
                       OR jabatan LIKE '%".$txtKeyword."%')";
    }

    $sql = "SELECT id_pegawai, nip_baru, nama, jabatan FROM (SELECT p.id_pegawai, p.nip_baru, CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
            nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(' ',p.gelar_belakang) END) AS nama, p.pangkat_gol,
            CASE WHEN p.jenjab = 'Fungsional' THEN p.jabatan ELSE CASE WHEN p.id_j IS NULL THEN
            (SELECT jm.nama_jfu AS jabatan
            FROM jfu_pegawai jp, jfu_master jm
            WHERE jp.kode_jabatan = jm.kode_jabatan AND jp.id_pegawai = p.id_pegawai LIMIT 1)
            ELSE j.jabatan END END AS jabatan, CASE WHEN j.eselon IS NULL THEN 'Z' ELSE j.eselon END AS eselon
            FROM pegawai p LEFT JOIN jabatan j ON p.id_j = j.id_j, current_lokasi_kerja clk, unit_kerja uk
            WHERE p.id_pegawai = clk.id_pegawai AND clk.id_unit_kerja = uk.id_unit_kerja ".$andKlausa." AND p.flag_pensiun = 0
            ORDER BY eselon ASC, p.pangkat_gol DESC, p.nama) a".$andKlausa2;
    $query_row = mysqli_query($mysqli,$sql);
    $i = 1;
?>

<table width="100%" border="0" align="center" style="border-radius:5px;"
       class="table table-bordered table-hover table-striped" id="tblList">
    <thead>
    <tr>
        <th width="5%"><input type="checkbox" id="checkAllList"></th>
        <th width="30%">NIP</th>
        <th width="65%">Nama</th>
    </tr>
    </thead>
    <tbody>
    <?php while($row = mysqli_fetch_array($query_row)){ ?>
        <tr>
            <td>
                <input type="checkbox" value="<?php echo $row['id_pegawai'].':'.$row['nip_baru'].':'.$row['nama']; ?>" id="chkUnit<?php echo $row['id_pegawai']; ?>" name="chkUnit<?php echo $row['id_pegawai']; ?>">
                <div class="modal fade" id="modal<?php echo $row['id_pegawai']; ?>" role="dialog">
                    <div class="modal-dialog modal-lg" style="max-height: 350px;">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title" style="border: 0px;">Informasi Pegawai</h4>
                            </div>
                            <div class="modal-body" style="height: 350px; width: 100%; overflow-y: scroll;">
                                <div id="winInfo<?php echo $row['id_pegawai']; ?>" style="margin-top: -10px;"></div>
                            </div>
                            <div class="modal-footer">
                                <button id="btnClose<?php echo $row['id_pegawai']; ?>" type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            </td>
            <td><span style="font-size: small;"><a href="javascript:void(0);" onclick="viewDetailPegawai(<?php echo $row['id_pegawai']; ?>);" style="text-decoration: none"><?php echo $row['nip_baru']; ?></a></span></td>
            <td><span style="font-size: small;"><?php echo $row['nama']; ?></span></td>
        </tr>
        <?php
        $i++;
    } ?>
    </tbody>
</table>