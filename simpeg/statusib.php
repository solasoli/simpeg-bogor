
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Untitled Document</title>
    </head>
    <body>
<div align="center">Daftar Pengajuan Ijin Belajar </div>
<?php
include("konek.php");
$sql = "select 
		nama,
		nip_baru,
		pangkat_gol,
		jabatan,
		nama_baru,
		tingkat_pendidikan,
		jurusan,akreditasi,
		pegawai.id_pegawai,
		approve,
		ijin_belajar.keterangan as ket, 
		rsib.status_ib
from ijin_belajar inner join pegawai on pegawai.id_pegawai =  ijin_belajar.id_pegawai
inner join current_lokasi_kerja on current_lokasi_kerja.id_pegawai =  ijin_belajar.id_pegawai
inner join unit_kerja on unit_kerja.id_unit_kerja=current_lokasi_kerja.id_unit_kerja
inner join ref_status_ijin_belajar rsib ON ijin_belajar.approve = rsib.idstatus_ib
where pegawai.id_pegawai=$_SESSION[id_pegawai]  ";
$q=mysqli_query($mysqli,$sql);

?>
<table width="95%" border="1" align="center" cellpadding="5" cellspacing="0">
    <tr>
        <td rowspan="2" style="padding:5px;">No</td>
        <td rowspan="2" style="padding:5px;">Nama</td>
        <td rowspan="2" style="padding:5px;">NIP</td>
        <td rowspan="2" align="center" style="padding:5px;">Golongan</td>
        <td rowspan="2" align="center" style="padding:5px;">TMT Pangkat</td>
        <td colspan="2" rowspan="2" align="center" style="padding:5px;">Jabatan</td>
        <td colspan="2" align="center" style="padding:5px;">Pendidikan Terkahir</td>
        <td colspan="2" align="center" style="padding:5px;">Pendidikan Lanjutan</td>
        <td rowspan="2" align="center" style="padding:5px;">Akreditasi</td>
        <td rowspan="2" align="center" style="padding:5px;" nowrap="nowrap">Status</td>
    </tr>
    <tr>
        <td style="padding:5px;">Program</td>
        <td style="padding:5px;">Jurusan</td>
        <td style="padding:5px;">Program</td>
        <td style="padding:5px;">Jurusan</td>
    </tr>
    <?php
    $i=1;
    while($data=mysqli_fetch_array($q))
    {
        ?>
        <tr>
            <td style="padding:5px;"><?php echo($i); ?></td>
            <td style="padding:5px;"><?php echo($data[0]); ?></td>
            <td style="padding:5px;"><?php echo($data[1]); ?></td>
            <td align="center" style="padding:5px;"><?php echo($data[2]); ?></td>
            <td align="center" style="padding:5px;"><?php
                $qsk=mysqli_query($mysqli,"select tmt from sk where id_pegawai=$data[8] and id_kategori_sk=5 order by tmt desc ");
                $tmt=mysqli_fetch_array($qsk);
                echo($tmt[0]); ?></td>
            <td colspan="2" style="padding:5px;"> <?php

                $qjab=mysqli_query($mysqli,"select nama_jfu  from jfu_master inner join jfu_pegawai on jfu_pegawai.kode_jabatan=jfu_master.kode_jabatan where jfu_pegawai.id_pegawai=$data[8]");


                $jab=mysqli_fetch_array($qjab);
                echo("$jab[0]");



                ?></td>
            <td align="center" style="padding:5px;"><?php
                $qpen=mysqli_query($mysqli,"select tingkat_pendidikan,jurusan_pendidikan from pendidikan where id_pegawai=$data[8] order by level_p ");
                $pen=mysqli_fetch_array($qpen);
                echo($pen[0]);
                ?></td>
            <td style="padding:5px;"><?php echo($pen[1]); ?></td>
            <td align="center" style="padding:5px;">
                <?php
                $tp=array('tp',"S3","S2","S1","D3","D2","D1","SMA","SMP");
                echo($tp[$data[5]]); ?></td>
                <td style="padding:5px;"><?php echo($data[6]); ?></td>
                <td align="center" style="padding:5px;"><?php echo($data[7]); ?></td>
                <td style="padding:5px;" align="center" nowrap="nowrap">
                    <?php
                        echo $data[11].'<br>';
                        if($data[9]==1 or $data[9]==7){
                            echo "<a href=index3.php?x=uploadlib.php&idp=$data[8]>[ Upload Ulang] </a>";
                        }elseif($data[9]==6 or $data[9]==2 or $data[9]==4){
                            echo "<a href=index3.php?x=uploadlib.php&idp=$data[8]>[ Lihat Berkas ] </a>";
                        }
                    ?>
                </td>
        </tr>
        <?php
        $i++;
    }
    ?>
</table>

</body>
</html>