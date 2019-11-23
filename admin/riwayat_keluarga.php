<table width="100%" border="0" cellpadding="3" cellspacing="0" class="hurup">
    <tr>
        <td>Status Nikah</td>
        <td>:</td>
        <td><select name="kawin" id="kawin">
                <?php
                $qjo = mysqli_query($con,"SELECT status_kawin FROM `pegawai` where flag_pensiun=0 group by status_kawin ");
                while ($otoi = mysqli_fetch_array($qjo)) {
                    if ($otoi[0]==$ata['status_kawin'])
                        echo("<option value=$otoi[0] selected>$otoi[0]</option>");
                    else
                        echo("<option value=$otoi[0]>$otoi[0]</option>");
                }

                ?>
            </select></td>
        <td colspan="3" rowspan="4" align="center" valign="top"><?php

            $qa = mysqli_query($con,"select count(*) from pegawai where id_pegawai=$id");
            $anak = mysqli_fetch_array($qa);
            if ($anak[0] > 0)
            {
            ?>
            <table width="400" border="0" align="center" cellpadding="3" cellspacing="0" class="hurup">
                <tr>
                    <td colspan="4" align="left">Data Anak</td>
                </tr>
                <tr>
                    <td>No</td>
                    <td>Nama</td>
                    <td>Tempat Lahir</td>
                    <td>Tanggal Lahir</td>
                    <td>Aksi</td>
                </tr>

                <?php
                $qpr = mysqli_query($con,"select * from keluarga where id_pegawai=$id and id_status=10 order by tgl_lahir ");


                $i = 1;
                while ($acoy = mysqli_fetch_array($qpr)) {
                    $t5 = substr($acoy[5], 8, 2);
                    $b5 = substr($acoy[5], 5, 2);
                    $th5 = substr($acoy[5], 0, 4);
                    echo("<tr>
<td> $i</td>
<td>$acoy[3] </td>
<td>$acoy[4] </td>
<td>$t5-$b5-$th5  </td>
<td><a href='hapus_anak.php?id_keluarga=$acoy[0]&id=$acoy[1]' onclick='return confirm('yakin lw mau ngehapus?');'>hapus</a></td>
</tr>");
                    $i++;
                }
                $totanak = $i - 1;
                ?>

                <tr>
                    <td><input name="ja" type="hidden" id="ja" value="<?php echo($totanak); ?>"/>
                        +
                    </td>
                    <td><label for="anak"></label>
                        <input type="text" name="anak" id="anak" size="25"/></td>
                    <td><label for="ttl"></label>
                        <input type="text" name="ttl" id="ttl" size="15"/></td>
                    <td><input name="tlanak" type="text" class="tcal" id="tlanak" size="20"/></td>

                </tr>
            </table>
            <?php
			}
			?>
        </td>
    </tr>
    <tr>
        <td>Nama Istri / Suami</td>
        <td>:</td>
        <td><label for="win"></label>

            <?php
            $qsi = mysqli_query($con,"select * from keluarga where id_pegawai=$id and id_status=9 order by tgl_lahir ");
            $si = mysqli_fetch_array($qsi);


            ?>
            <input name="idwin" type="hidden" id="idwin" value="<?php echo("$si[id_keluarga]"); ?>">
            <input name="win" type="text" id="win" value="<?php echo("$si[nama]"); ?>" size="30"/></td>
    </tr>
    <tr>
        <td nowrap="nowrap">Tempat Lahir Istri/Suami</td>
        <td>:</td>
        <td><input name="twin" type="text" id="twin" value="<?php echo("$si[tempat_lahir]"); ?>"
                   size="30"/></td>
    </tr>
    <tr>
        <td nowrap="nowrap">Tanggal Lahir Istri/Suami</td>
        <td>:</td>
        <td><input name="tglwin" type="text" class="tcal" id="tglwin" value="<?php
            $tgl = substr($si['tgl_lahir'], 8, 2);
            $bln = substr($si['tgl_lahir'], 5, 2);
            $thn = substr($si['tgl_lahir'], 0, 4);
            echo("$tgl-$bln-$thn");
            ?>"/></td>
    </tr>
    <tr>
        <td nowrap="nowrap">Tanggal Menikah</td>
        <td>:</td>
        <td><input name="tgl_menikah" type="text" class="tcal" id="tgl_menikah" value="<?php
            if ($ata['tgl_menikah']) {
                $tgl = substr($si['tgl_menikah'], 8, 2);
                $bln = substr($si['tgl_menikah'], 5, 2);
                $thn = substr($si['tgl_menikah'], 0, 4);
                echo("$tgl-$bln-$thn");
            } else
                echo "01-01-1900";
            ?>"/></td>
    </tr>
    <tr>
        <td>Status Tunjangan</td>
        <td>:</td>
        <td>
            <?php $tun_istri = $si['dapat_tunjangan'] == 1 ? "Dapat" : "Tidak Dapat" ?>
            <select name="tun_istri">
                <option value="<?php echo $si['dapat_tunjangan'] ?>"><?php echo $tun_istri ?></option>
                <option value="1">Dapat</option>
                <option value="0">Tidak Dapat</option>
            </select>
        </td>
    </tr>
    <tr>
        <td>Pekerjaan Istri / Suami</td>
        <td>:</td>
        <td><input type="text" name="pekerjaan_istri"
                   value="<?php echo isset($si['pekerjaan']) ? $si['pekerjaan'] : "" ?>"/>
        </td>
    </tr>
    <tr>
        <td>No. Karis/Karsu</td>
        <td>:</td>
        <td><input type="text" name="nokarisu"
                   value="<?php echo isset($si['no_karsus']) ? $si['no_karsus'] : "" ?>"/>
        </td>
    </tr>
</table>
