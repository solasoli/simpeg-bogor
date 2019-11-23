<?php
    include 'konek.php';
    $idopd = $_GET['idopd'];

    $sql = "SELECT COUNT(uk.id_unit_kerja) AS jml
                FROM unit_kerja uk
                WHERE uk.id_skpd = $idopd AND uk.id_unit_kerja <> $idopd";
    $query_row = mysqli_query($mysqli,$sql);
    $rowJml = mysqli_fetch_array($query_row);
    if($rowJml['jml']<>0){
        $a = ', a.nama_baru';
        $b = 'uk.id_skpd';
    }else{
        $a = '';
        $b = 'uk.id_unit_kerja';
    }
    $sql = "SELECT a.nip_baru, a.nama, a.jenis_kelamin, a.tgl_lahir, a.usia, a.jenjab,
            CASE WHEN a.jabatan IS NULL THEN 'Fungsional Umum' ELSE a.jabatan END AS jabatan, a.agama, a.pangkat_gol $a FROM
            (SELECT p.nip_baru, CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
            nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(' ',p.gelar_belakang) END) AS nama,
            CASE WHEN p.jenis_kelamin = 1 THEN 'Laki-laki' ELSE 'Perempuan' END AS jenis_kelamin,
            DATE_FORMAT(p.tgl_lahir,  '%d/%m/%Y') AS tgl_lahir,
            ROUND(DATEDIFF(CURRENT_DATE, DATE_FORMAT(p.tgl_lahir, '%Y/%m/%d'))/365,2) AS usia,
            p.jenjab, CASE WHEN p.jenjab = 'Fungsional' THEN p.jabatan ELSE CASE WHEN p.id_j IS NULL THEN
            (SELECT jm.nama_jfu AS jabatan FROM jfu_pegawai jp, jfu_master jm
            WHERE jp.kode_jabatan = jm.kode_jabatan AND jp.id_pegawai = p.id_pegawai LIMIT 1)
            ELSE j.jabatan END END AS jabatan, CASE WHEN j.eselon IS NULL THEN 'Z' ELSE j.eselon END AS eselon, p.agama, p.pangkat_gol, uk.nama_baru
            FROM pegawai p LEFT JOIN jabatan j ON p.id_j = j.id_j, current_lokasi_kerja clk, unit_kerja uk
            WHERE p.id_pegawai = clk.id_pegawai AND clk.id_unit_kerja = uk.id_unit_kerja AND p.flag_pensiun = 0 AND p.id_j IS NULL
            AND $b = $idopd) a ORDER BY a.nama_baru ASC, a.eselon ASC, a.pangkat_gol DESC, a.jabatan ASC, a.nama ASC";
    $query_row = mysqli_query($mysqli,$sql);
    $i = 1;
?>

<table width="100%" border="0" align="center" style="border-radius:5px; font-size: small;"
       class="table table-bordered table-hover table-striped" id="tblList">
    <thead>
    <tr>
        <th width="5%">No</th>
        <th width="10%">NIP</th>
        <th width="30%">Nama</th>
        <th>Gol.</th>
        <th>JK</th>
        <th>Tgl.Lahir</th>
        <th>Jabatan</th>
        <?php if($rowJml['jml']<>0){ ?>
            <th <?php echo $rowJml['jml']<>0?'width="35%"':'' ?>>Unit</th>
        <?php } ?>
    </tr>
    </thead>
    <tbody>
    <?php while($row = mysqli_fetch_array($query_row)){ ?>
    <tr>
        <td><?php echo $i;?></td>
        <td><span style="color: darkblue"><?php echo $row['nip_baru']; ?></span></td>
        <td><span style="color: darkgreen"><?php echo $row['nama']; ?></span></td>
        <td><?php echo $row['pangkat_gol']; ?></td>
        <td><?php echo $row['jenis_kelamin']; ?></td>
        <td><?php echo $row['tgl_lahir']; ?></td>
        <td><?php echo $row['jabatan']; ?></td>
        <?php if($rowJml['jml']<>0){ ?>
            <td><?php echo $row['nama_baru']; ?></td>
        <?php } ?>
        </tr>
    <?php
        $i++;
        }
    ?>
    </tbody>
</table>
