<?php
    include 'konek.php';
    $idkeb = $_GET['id'];
    $sql = "SELECT p.id_pegawai, p.nip_baru, CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
    nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(' ',p.gelar_belakang) END) AS nama,
    p.pangkat_gol, CASE WHEN p.jenjab = 'Fungsional' THEN p.jabatan ELSE CASE WHEN p.id_j IS NULL THEN
    (SELECT jm.nama_jfu AS jabatan
     FROM jfu_pegawai jp, jfu_master jm
     WHERE jp.kode_jabatan = jm.kode_jabatan AND jp.id_pegawai = p.id_pegawai LIMIT 1)
    ELSE j.jabatan END END AS jabatan, uk.nama_baru as unit
    FROM pegawai p LEFT JOIN jabatan j ON p.id_j = j.id_j, kebutuhan_diklat_detail kdd,
    current_lokasi_kerja clk, unit_kerja uk
    WHERE kdd.id_keb_diklat = $idkeb AND p.id_pegawai = kdd.id_pegawai AND
    p.id_pegawai = clk.id_pegawai AND clk.id_unit_kerja = uk.id_unit_kerja";
    $query_row = mysqli_query($mysqli, $sql);
    $i = 1;
?>

<table width="100%" border="0" align="center" style="border-radius:5px;"
       class="table table-bordered table-hover table-striped" id="tblList">
    <thead>
    <tr>
        <th width="5%">No</th>
        <th width="20%">NIP</th>
        <th width="20%">Nama</th>
        <th width="5%">Gol</th>
        <th width="25%">Jabatan</th>
        <th width="25%">Unit</th>
    </tr>
    </thead>
    <tbody>
    <?php while($row = mysqli_fetch_array($query_row)){ ?>
        <tr>
            <td><?php echo $i;?></td>
            <td><?php echo $row['nip_baru']; ?></td>
            <td><?php echo $row['nama']; ?></td>
            <td><?php echo $row['pangkat_gol']; ?></td>
            <td><?php echo $row['jabatan']; ?></td>
            <td><?php echo $row['unit']; ?></td>
        </tr>
        <?php
        $i++;
    } ?>
    </tbody>
</table>

