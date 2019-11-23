<?php
require_once("konek.php");
$sql = "select t.id_tkk, t.nama, t.jabatan, date_format(t.tgl_lahir, '%d-%m-%Y') as tgl_lahir,
        date_format(t.tmt, '%d-%m-%Y') as tmt, a.id_unit_kerja, uk.nama_baru as unit from
        (select uk.id_unit_kerja
        from unit_kerja uk where uk.id_skpd = ".$_POST['idskpd'].") a
        inner join tkk t on a.id_unit_kerja = t.id_unit_kerja
        inner join unit_kerja uk on t.id_unit_kerja = uk.id_unit_kerja
        where t.status = ".$_POST['status']." order by unit, nama";
$q = mysqli_query($mysqli,$sql);
?>

<div id='list_nonpns' style='height:500px;width:99%;overflow: auto;overflow-x: auto; '>
<table class="table">
    <tr style='border-bottom: solid 2px #2cc256'>
        <th>No</th><th>Nama</th><th style="width: 13%">Tgl.Lahir</th><th>Unit</th><th>Jabatan</th><th style="width: 13%">TMT</th>
    </tr>
    <?php
        $i=1;
    while($data=mysqli_fetch_array($q)){ ?>
    <tr>
        <td><?php echo $i++;?></td>
        <td><?php echo $data[1];?></td>
        <td><?php echo $data[3];?></td>
        <td><?php echo $data[6];?></td>
        <td><?php echo $data[2];?></td>
        <td><?php echo $data[4];?></td>
    </tr>
    <?php } ?>
</table>
</div>