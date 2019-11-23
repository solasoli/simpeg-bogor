
<?php

$q=mysqli_query($mysqli,"select nama,nip_baru,pangkat_gol,jabatan,nama_baru,tingkat_pendidikan,jurusan,akreditasi,pegawai.id_pegawai,approve,ijin_belajar.keterangan as ket,ijin_belajar.id from ijin_belajar inner join pegawai on pegawai.id_pegawai =  ijin_belajar.id_pegawai inner join current_lokasi_kerja on current_lokasi_kerja.id_pegawai =  ijin_belajar.id_pegawai inner join unit_kerja on unit_kerja.id_unit_kerja=current_lokasi_kerja.id_unit_kerja where unit_kerja.id_skpd=$_SESSION[id_unit]  ");
?>
<table class="table table-bordered" id="listib">
    <thead>
	<tr>
        <th rowspan="2" style="padding:5px;">No</th>
        <th rowspan="2" style="padding:5px;">Nama</th>
        <th rowspan="2" style="padding:5px;">NIP</th>
        <th rowspan="2" align="center" style="padding:5px;">Golongan</th>
        <th rowspan="2" align="center" style="padding:5px;">TMT Pangkat</th>
        <th colspan="2" rowspan="2" align="center" style="padding:5px;">Jabatan</th>
        <th colspan="2" align="center" style="padding:5px;">Pendidikan Terkahir</th>
        <th colspan="2" align="center" style="padding:5px;">Pendidikan Lanjutan</th>
        <th rowspan="2" align="center" style="padding:5px;">Akreditasi</th>
        <th rowspan="2" align="center" style="padding:5px;" nowrap="nowrap">Status</th>
        <th rowspan="2" align="center" style="padding:5px;" nowrap="nowrap">Hapus</th>
        <th rowspan="2" align="center" style="padding:5px;" nowrap="nowrap">Edit</th>
    </tr>
    <tr>
        <th style="padding:5px;">Program</th>
        <th style="padding:5px;">Jurusan</th>
        <th style="padding:5px;">Program</th>
        <th style="padding:5px;">Jurusan</th>
    </tr>
	</thead>
	<tbody>
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
            <td align="center" style="padding:5px;"><?php


                $tp=array('tp',"S3","S2","S1","D3","D2","D1","SMA","SMP");
                echo($tp[$data[5]]); ?></td>
            <td style="padding:5px;"><?php echo($data[6]); ?></td>
            <td align="center" style="padding:5px;"><?php echo($data[7]); ?></td>
            <td style="padding:5px;" align="center" nowrap="nowrap"><?php
                if($data[9]==5)
                    echo("Diajukan");
                else  if($data[9]==1)
                    echo("Disetujui"); //<br> <a href=index3.php?x=uploadlib.php&idp=$data[8]>[ Upload ] </a>
                else  if($data[9]==2)
                    echo("Diproses");
                else  if($data[9]==6)
					echo("");//Sudah Upload <br> <a href=index3.php?x=uploadlib.php&idp=$data[8]>[ Lihat Berkas ] </a>
                else  if($data[9]==4)
                    echo("Selesai <br> Silakan diambil di BKPP");
                else  if($data[9]==7)
                    echo("Perbaiki"); //<br> <a href=index3.php?x=uploadlib.php&idp=$data[8]>[ Upload ] </a>
                else  if($data[9]==3)
                    echo("Ditolak:<br> $data[ket]");
                echo("<td align=center> <a href=index3.php?x=ijinbelajar.php&hapus=$data[id]> Hapus </a> </td>");
                echo("<td align=center> <a href=index3.php?x=ijinbelajar.php&edit=$data[id]> Edit </a> </td>");

                ?></td>

        </tr>
        <?php
        $i++;
    }
    ?>
	</tbody>
</table>
<script type="text/javasript">
	$(document).ready(function() {
		$('#listib').dataTable({
		   "dom": 'T<"clear">lfrtip',
			"tableTools": {
				"sSwfPath": "assets/DataTables/extensions/TableTools/swf/copy_csv_xls_pdf.swf" 
			}
		});
		
		
	  
	});

</script>