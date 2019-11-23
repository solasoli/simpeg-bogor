<?php
    include("konek.php");
    $sql = "SELECT b.*, uk.nama_baru as skpd FROM
            (SELECT a.*, uk.nama_baru, uk.tahun, uk.id_skpd FROM
            (SELECT p.id_pegawai, p.flag_pensiun, p.nama, CONCAT(\"'\",p.nip_baru) AS nip_baru, p.nip_lama, p.tgl_lahir, p.password,
            p.ponsel, p.email, p.alamat, clk.id_aja, clk.id_unit_kerja
            FROM pegawai p LEFT JOIN current_lokasi_kerja clk ON p.id_pegawai = clk.id_pegawai
            WHERE p.flag_pensiun = 0) a LEFT JOIN unit_kerja uk
            ON a.id_unit_kerja = uk.id_unit_kerja) b LEFT JOIN unit_kerja uk
            ON b.id_skpd = uk.id_unit_kerja
            ORDER BY b.id_skpd, b.nama_baru, b.nama;";
    $rsQ = mysqli_query($mysqli,$sql);
    $no = 1;
?>
<h2>DATA PEGAWAI BELUM ADA FOTO</h2>
<table border="1" cellpadding="2" cellspacing="0" width="100%">
    <tr>
        <td>No</td>
        <td>Nama</td>
        <td>NIP</td>
        <td>Ponsel</td>
        <td>Email</td>
        <td>Alamat</td>
        <td>Unit Kerja</td>
        <td>SKPD</td>
    </tr>
    <?php while($data = mysqli_fetch_array($rsQ)): ?>
        <?php if(file_exists(str_replace("\\","/",getcwd()).'/foto/'.$data[0].'.jpg')) {
        }else{
        ?>
        <tr>
            <td><?php echo $no++; ?> </td>
            <td><?php echo $data[2]; ?></td>
            <td><?php echo $data[3]; ?></td>
            <td><?php echo $data[7]; ?></td>
            <td><?php echo $data[8]; ?></td>
            <td><?php echo $data[9]; ?></td>
            <td><?php echo $data[12]; ?></td>
            <td><?php echo $data[15]; ?></td>
        </tr>
        <?php } ?>
    <?php endwhile; ?>
</table>
