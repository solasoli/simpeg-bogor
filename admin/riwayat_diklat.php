<fieldset>
    <legend>Diklat Struktural</legend>
    <table width="100%" border="0" cellpadding="3" cellspacing="0" class="hurup">
        <tr>
            <td>No</td>
            <td>Jenis Diklat</td>
            <td>Nama Diklat</td>
            <td>Tanggal Diklat</td>
            <td>Jumlah Jam</td>
            <td>Penyelenggara</td>
            <td>No STTPL</td>
            <td>Berkas</td>
            <td>Aksi</td>
        </tr>

        <?php
        $j = 1;
        $qp = mysqli_query($con,"select * from diklat where id_pegawai=$id order by tgl_diklat DESC");
        while ($pen = mysqli_fetch_array($qp)) {

            $tgl_diklat = new DateTime($pen['tgl_diklat']);
            echo("<tr>
<td>$j</td>
<td>"); ?>


            <select name="jenis_diklat<?php echo($j); ?>" id="jenis_diklat<?php echo($j); ?>">
                <?php
                $qdj=mysqli_query($con,"SELECT * FROM diklat_jenis");
                while($data=mysqli_fetch_array($qdj))
                {
                    if(trim($pen['id_jenis_diklat'])==trim($data[0]))
                        echo("<option value=$data[0] selected>$data[1]</option>");
                    else
                        echo("<option value=$data[0]>$data[1]</option>");
                }

                ?>
            </select>


            <input type="hidden" name="id_diklat<?php echo $j; ?>"
                   value="<?php echo $pen['id_diklat']; ?>"/>
            <?php
            echo("</td>
<td><input type=text name=nama_diklat$j id=lem$j value='$pen[nama_diklat]' /></td>
<td><input type=text name=tgl_diklat$j id=tgl_diklat$j value=" . $tgl_diklat->format('d-m-Y') . " class=tcal size=8 /></td>
<td><input type=text name=jml_jam_diklat$j id=lus$j value='$pen[jml_jam_diklat]' /><input type=hidden name=idpen$j id=idpen$j value='$pen[0]' /></td>
<td><input type=text name=penyelenggara_diklat$j id=penyelenggara_diklat$j value='$pen[penyelenggara_diklat]' /></td>
<td><input type=text name=no_sttpl$j id=no_sttpl$j value='$pen[no_sttpl]' /></td><td>");

            if ($pen['id_berkas'] == NULL) {
                echo("<input type=file name=filediklat$j id=filediklat$j />");
            } else
                echo("<a href=berkas.php?idb=$pen[id_berkas] target=_blank> Lihat </a>");


            echo(" </td><td><a href='hapus_diklat.php?iddiklat=$pen[id_diklat]&id=$ata[id_pegawai]' onclick='return confirm(\'yakin lw mau ngehapus?\');'>hapus</td>
</tr>");

            $j++;
        }
        $total_diklat = $j - 1;
        ?>
        <tr>
            <td>+</td>
            <td>
                <select name="jenis_diklat" id="jenis_diklat" onchange="ganti_jenis_diklat(this.value)">
                    <?php
                    $qdj2=mysqli_query($con,"SELECT * FROM `diklat_jenis` ");
                    while($data2=mysqli_fetch_array($qdj2))
                        echo("<option value=$data2[0]>$data2[1]</option>");

                    ?>
                </select>
                <input name="total_diklat" type="hidden" id="total_diklat"
                       value="<?php echo($total_diklat); ?>"/></td>
            <td><label for="lembaga"></label>

                <div id="dklt"><input type='text' name='nama_diklat' value=''></div>
                <!--select name="nama_diklat" id="nama_diklat">
                    <option value="-">- PILIH -</option>
                    <option value="Diklat Prajabatan Gol I">Diklat Prajabatan Gol I</option>
                    <option value="Diklat Prajabatan Gol II">Diklat Prajabatan Gol II</option>
                    <option value="Diklat Prajabatan Gol III">Diklat Prajabatan Gol III</option>
                    <option value="Diklat Kepemimpinan Tk.II">Diklat Kepemimpinan Tk.II</option>
                    <option value="Diklat Kepemimpinan Tk.III">Diklat Kepemimpinan Tk.III</option>
                    <option value="Diklat Kepemimpinan Tk.IV">Diklat Kepemimpinan Tk.IV</option>
              </select-->
            </td>
            <td><input type=text name="tgl_diklat" id="tgl_diklat" value="<?php echo date('d-m-Y'); ?>"
                       class=tcal size=8/></td>
            <td><input type="text" name="jml_jam_diklat" id="jml_jam_diklat" value="0"/></td>
            <td><input type="text" name="penyelenggara_diklat" id="penyelenggara_diklat"/></td>
            <td><input type="text" name="no_sttpl" id="no_sttpl"/></td>
            <td><input type="file" name="fupdiklat" id="fupdiklat"/></td>

        </tr>
    </table>
</fieldset>
