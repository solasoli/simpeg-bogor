<table width="100%" border="0" cellpadding="3" cellspacing="0" class="hurup">
    <tr>
        <td width="21%" align="left" valign="top">Nama</td>
        <td width="3%" align="left" valign="top">:</td>
        <td width="28%"><label for="n"></label>
            <?php
                $namap = $ata[1];
            ?>
            <input name="n" type="text" id="n" value="<?php echo($ata[1]); ?>" size="35"/></td>
        <td width="42" colspan="3" rowspan="4" align="left" valign="bottom">
          <?php
            if (file_exists("../simpeg/foto/".$id.".jpg")) { 
                echo "<div align=left><img src='../simpeg/foto/".$id.".jpg'".time()." width='100px' /></div>";
            }else{ ?>
                <a href="https://wa.me/<?php echo '62'.(substr($ata['ponsel'],1,strlen($ata['ponsel'])-1)); ?>?text=Yth. Bpk/Ibu Pegawai Pemkot Bogor a.n <?php echo $namap;?> diberitahukan bahwa foto anda belum tercantum dalam database BKPSDA. terimakasih" target="_blank">Kirim pesan via WA <?php echo($ata['ponsel']); ?></a>
            <?php  } ?></td>
    </tr>
    <tr>
        <td align="left" valign="top">Gelar Depan</td>
        <td align="left" valign="top">:</td>
        <td><input name="gelar_depan" type="text" id="gelar_depan"
                   value="<?php echo($ata['gelar_depan']); ?>"/></td>
    </tr>
    <tr>
        <td align="left" valign="top">Gelar Belakang</td>
        <td align="left" valign="top">:</td>
        <td><input name="gelar_belakang" type="text" id="gelar_belakang"
                   value="<?php echo($ata['gelar_belakang']); ?>"/></td>
    </tr>
    <tr>
        <td align="left" valign="top">NIP Lama</td>
        <td align="left" valign="top">:</td>
        <td><input name="nl" type="text" id="nl" value="<?php echo($ata['nip_lama']); ?>"/></td>
    </tr>
    <tr>
        <td align="left" valign="top" nowrap="nowrap">Agama</td>
        <td align="left" valign="top">:</td>
        <td><select name="a" id="a">
                <?php
                $qjo = mysqli_query($con,"SELECT agama FROM `pegawai` where flag_pensiun=0 group by agama ");
                while ($otoi = mysqli_fetch_array($qjo)) {
                    if ($ata['agama'] == $otoi[0])
                        echo("<option value=$otoi[0] selected>$otoi[0]</option>");
                    else
                        echo("<option value=$otoi[0]>$otoi[0]</option>");
                }

                ?>
            </select></td>
    </tr>
    <tr>
        <td align="left" valign="top" nowrap="nowrap">Tempat Lahir</td>
        <td align="left" valign="top">:</td>
        <td><input name="tl" type="text" id="tl" value="<?php echo($ata['tempat_lahir']); ?>"/></td>
    </tr>
    <tr>
        <td align="left" valign="top" nowrap="nowrap">Tanggal Lahir</td>
        <td align="left" valign="top">:</td>
        <td><label for="tgl"></label>
            <input name="tgl" type="text" class="tcal" id="tgl" value="<?php
            $tgl = substr($ata['tgl_lahir'], 8, 2);
            $bln = substr($ata['tgl_lahir'], 5, 2);
            $thn = substr($ata['tgl_lahir'], 0, 4);
            echo("$tgl-$bln-$thn");
            ?>"/></td>
        <td width="11" rowspan="2" align="left" valign="top">Alamat</td>
        <td width="10" rowspan="2" align="left" valign="top">:</td>
        <td width="21" rowspan="2" align="left" valign="top"><textarea class="hurup" name="al" id="al"
                                                                       cols="45"
                                                                       rows="3"><?php echo($ata['alamat']); ?></textarea>                        </td>
    </tr>
    <tr>
        <td align="left" valign="top" nowrap="nowrap" class="selected">NIP Baru</td>
        <td align="left" valign="top">:</td>
        <td><input name="nb" type="text" id="nb" value="<?php echo($ata['nip_baru']); ?>" size="22"/></td>
    </tr>
    <tr>
      <td align="left" valign="top" nowrap="nowrap">NIK</td>
      <td align="left" valign="top">:</td>
      <td><label>
      <?php
$qktp=mysqli_query($con,"select no_ktp from pegawai where id_pegawai=$id");
$ktp=mysqli_fetch_array($qktp);


?>
        <input name="nik" type="text" id="nik" value="<?php  echo $ktp[0]; ?>" />
      </label></td>
      <td align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
        <td align="left" valign="top" nowrap="nowrap">Jenis Kelamin</td>
        <td align="left" valign="top">:</td>
        <td><select name="jk" id="jk">
                <?php
                $qp = mysqli_query($con,"SELECT jenis_kelamin FROM `pegawai` where flag_pensiun=0 group by jenis_kelamin ");
                while ($oto = mysqli_fetch_array($qp)) {
                    if ($ata['jenis_kelamin'] == $oto[0])
                        echo("<option value=$oto[0] selected>$oto[0]</option>");
                    else
                        echo("<option value=$oto[0]>$oto[0]</option>");
                }

                ?>
            </select></td>
        <td align="left" valign="top">&nbsp;</td>
        <td align="left" valign="top">&nbsp;</td>
        <td align="left" valign="top">&nbsp;</td>
    </tr>
    <tr>
        <td align="left" valign="top" nowrap="nowrap">Kartu Pegawai</td>
        <td align="left" valign="top">:</td>
        <td><input name="karpeg" type="text" id="karpeg" value="<?php echo($ata['no_karpeg']); ?>"/></td>
        <td align="left" valign="top">Kota</td>
        <td width="10" align="left" valign="top">:</td>
        <td width="21" align="left" valign="top"><input name="kota" type="text" id="kota"
                                                        value="<?php echo($ata['kota']); ?>"/></td>
    </tr>
    <tr>
        <td align="left" valign="top" nowrap="nowrap">NPWP</td>
        <td align="left" valign="top">:</td>
        <td><input name="npwp" type="text" id="npwp" value="<?php echo($ata['NPWP']); ?>"/></td>
        <td width="11" align="left" valign="bottom">Golongan Darah</td>
        <td width="10" align="left" valign="bottom">:</td>
        <td width="21" align="left" valign="bottom">
            <select name="darah" id="darah">
                <?php
             

                $qd = mysqli_query($con,"SELECT gol_darah FROM `pegawai` where flag_pensiun=0 group by gol_darah order by gol_darah ");
                $gol_dar = array('A', 'B', 'AB', 'O');
                while ($da = mysqli_fetch_array($qd)) {
                    if ($ata['gol_darah'] == $da[0])
                        echo("<option value=$da[0] selected>$da[0]</option>");
                    else
                        echo("<option value=$da[0]>$da[0]</option>");
                }

                ?>
            </select></td>
    </tr>
    <tr>
        <td align="left" valign="top" nowrap="nowrap">Gol / Ruang</td>
        <td align="left" valign="top">:</td>
        <td><select name="gol" id="gol">
                <?php
                $qp = mysqli_query($con,"SELECT golongan as pangkat_gol FROM simpeg.golongan ");
                while ($oto = mysqli_fetch_array($qp)) {
                    if ($ata['pangkat_gol'] == $oto[0])
                        echo("<option value=$oto[0] selected>$oto[0]</option>");
                    else
                        echo("<option value=$oto[0]>$oto[0]</option>");
                }

                ?>
            </select></td>
        <td align="left" valign="top">Status Aktif</td>
        <td align="left" valign="top">:</td>
        <td align="left" valign="top"><select name="aktif" id="aktif" disabled>
                <?php
                $qot = mysqli_query($con,"SELECT status_aktif FROM `pegawai`  group by status_aktif ");
                while ($ot = mysqli_fetch_array($qot)) {
                    if ($ata['status_aktif'] == $ot[0])
                        echo("<option value='$ot[0]' selected>$ot[0]</option>");
                    else
                        echo("<option value='$ot[0]' >$ot[0]</option>");
                }

                ?>
            </select><br>
            <?php if($ata['status_aktif']=='Dipekerjakan' or $ata['status_aktif']=='Pindah Ke Instansi Lain'): ?>
                <?php
                    if($ata['status_aktif']=='Dipekerjakan'){
                        $sql = "SELECT a.*, i.instansi from
                        (SELECT d.id_instansi, DATE_FORMAT(d.tgl_dpk, '%d-%m-%Y') AS tgl_dpk FROM dpk d WHERE d.id_pegawai = $id AND d.id =
                          (SELECT MAX(id) AS id FROM dpk d2 WHERE d2.id_pegawai = $id)) a, instansi i
                        WHERE a.id_instansi = i.id";
                        $qreUnit = mysqli_query($con,$sql);
                        $reUnit = mysqli_fetch_array($qreUnit);
                    }elseif($ata['status_aktif']=='Pindah Ke Instansi Lain'){
                        $sql = "SELECT a.*, i.instansi from
                        (SELECT d.id_instansi, DATE_FORMAT(d.tgl_pindah, '%d-%m-%Y') AS tgl_dpk FROM pindah_instansi d WHERE d.id_pegawai = $id AND d.id =
                          (SELECT MAX(id) AS id FROM pindah_instansi d2 WHERE d2.id_pegawai = $id)) a, instansi i
                        WHERE a.id_instansi = i.id";
                        $qreUnit = mysqli_query($con,$sql);
                        $reUnit = mysqli_fetch_array($qreUnit);
                    }
                    $num_rows = mysqli_num_rows($qreUnit);
                    if($num_rows == 0){
                        $reUnit[1] = 'Belum ada data';
                        $reUnit[2] = 'Belum ada data';
                    }
                ?>
                <span id="jdlTmt">TMT. Terakhir: <?php echo $reUnit[1];?></span>
                <span id="jdlUnit">. Instansi Tujuan: <?php echo $reUnit[2];?></span>
            <?php else: ?>
                <span id="jdlTmt"></span>
                <span id="jdlUnit"></span>
            <?php endif; ?>
        </td>
    </tr>
    <tr>
        <td align="left" valign="top" nowrap="nowrap">Unit Kerja</td>
        <td align="left" valign="top">:</td>
        <td><?php
            $qu = mysqli_query($con,"select nama_baru from unit_kerja inner join current_lokasi_kerja on current_lokasi_kerja.id_unit_kerja=unit_kerja.id_unit_kerja where id_pegawai=$ata[0]");
            $unit = mysqli_fetch_array($qu);
            echo($unit[0]);
            ?></td>
        <td align="left" valign="top">Tgl Pensiun Reguler</td>
        <td align="left" valign="top">:</td>
        <td align="left" valign="top"><input name="pensiun" type="text" class="tcal" id="pensiun"
                                             value="<?php
                                             $tgl88 = substr($ata['tgl_pensiun_dini'], 8, 2);
                                             $bln88 = substr($ata['tgl_pensiun_dini'], 5, 2);
                                             $thn88 = substr($ata['tgl_pensiun_dini'], 0, 4);
                                             echo("$tgl88-$bln88-$thn88");
                                             ?>"/>flag pensiun : <?php echo $ata['flag_pensiun'] ?></td>
    </tr>
    <tr>
        <td align="left" valign="top" nowrap="nowrap">Jenjang Jabatan</td>
        <td align="left" valign="top">:</td>
        <td><label for="jenjab"></label>
            <select name="jenjab" id="jenjab">
                <?php
                $qjo = mysqli_query($con,"SELECT jenjab FROM `pegawai` where flag_pensiun=0 group by jenjab ");
                while ($oto = mysqli_fetch_array($qjo)) {
                    if ($ata['jenjab'] == $oto[0])
                        echo("<option value='$oto[0]' selected>$oto[0]</option>");
                    else
                        echo("<option value='$oto[0]'>$oto[0]</option>");
                }

                ?>
            </select>

            <select name="jafung" id="jafung">
                <option value="-">-</option>
                <?php $qJafung = "select distinct nama_jafung jafung\n"
                    . "from jafung\n"
                    . "order by nama_jafung ";
                $rsJafung = mysqli_query($con,$qJafung);
                ?>
                <?php while ($jafung = mysqli_fetch_array($rsJafung)): ?>
                    <option
                        <?php
                        if ($ata['jenjab'] == 'Fungsional' && $ata[jabatan] == $jafung[jafung]) echo 'selected';
                        ?>
                        value="<?php echo $jafung[jafung]; ?>"><?php echo $jafung[jafung]; ?></option>
                <?php endwhile; ?>
            </select>                        </td>

        <td align="left" valign="top">Password
            <input name="id2" type="hidden" id="id2" value="<?php echo($id); ?>"/>
            <input name="id" type="hidden" id="id" value="<?php echo($id); ?>"/></td>
        <td align="left" valign="top">:</td>
        <td align="left" valign="top"><input type="password" disabled="disabled"
                                             value="<?php echo($ata['password']); ?>"/>

            password baru:<input type="text" name="anyar" id="anyar"/>                        </td>
    </tr>
    <tr>
        <td>Jabatan</td>
        <td>:</td>
        <td>
            <?php //echo $theJabatan = $obj_pegawai->get_jabatan($pegawai) ?>
            <br/>
            <?php if ($ata['jabatan'] == 'Guru') { ?>

                <input onclick="update_kepsek(<?php echo $pegawai->id_pegawai ?>)"
                       type="checkbox" <?php echo ($obj_pegawai->is_kepsek($pegawai) == TRUE) ? "CHECKED" : "" ?>> kepala Sekolah
            <?php } ?>                        </td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
<tr>
        <td>Jabatan Atasan</td>
        <td>:</td>
        <td>
            <?php
echo $obj_pegawai->get_atasan($pegawai)->jabatan;
echo "<br>";
echo "(<strong>".$obj_pegawai->get_atasan($pegawai)->nama."</strong>)";
?>
</td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td align="left" valign="top" nowrap="nowrap">Telepon</td>
        <td align="left" valign="top">:</td>
        <td><input name="telp" type="text" id="telp" value="<?php echo($ata['telepon']); ?>"/></td>
        <td align="left" valign="top">Jabatan</td>
        <td align="left" valign="top">:</td>
        <td align="left" valign="top"><?php
            if ($ata['id_j'] > 0) {
                $qj = mysqli_query($con,"select * from jabatan where id_j=$ata[id_j]");
                $jab = mysqli_fetch_array($qj);
                $ab = $jab[1];
                $es = $jab[4];
            } else {
                $ab = $ata['jenjab'];
                $es = "-";
            }
            echo("$ab");
            ?></td>
    </tr>
    <?php $ponsel = $ata['ponsel']; ?>
    <tr>
        <td align="left" valign="top" nowrap="nowrap">Ponsel</td>
        <td align="left" valign="top">:</td>
        <td><input name="hp" type="text" id="hp" value="<?php echo($ata['ponsel']); ?>"/>
            OS <select name="os" id="os">
                <option value="-" <?php if ($ata['os'] == '-') echo "selected"; ?>>Pilih Sistem
                    Operasi                                </option>
                <option value="Android" <?php if ($ata['os'] == 'Android') echo "selected"; ?>>Android                                </option>
                <option value="Ios" <?php if ($ata['os'] == 'Ios') echo "selected"; ?>>Iphone Apple                                </option>
                <option value="BB" <?php if ($ata['os'] == 'BB') echo "selected"; ?>>Blackberry</option>
                <option value="Lainnya" <?php if ($ata['os'] == 'Lainnya') echo "selected"; ?>>Lainnya                                </option>

            </select>                        </td>
        <td align="left" valign="top">Eselonering</td>
        <td align="left" valign="top">:</td>
        <td align="left" valign="top"><?php echo("$es"); ?></td>
    </tr>
<tr>
<td align="left" valign="top" nowrap="nowrap">IMEI</td>
        <td align="left" valign="top">:</td>
<td> <div id="divreset">
<?php

if($ata['imei']){ echo $ata['imei'] ; ?>

  <a href="#" onclick="resetImei(<?php echo $id ?>)" id="btnResetImei">[ Reset Imei ]</a>
<?php
}
?>
</div>						</td>
<td></td>
<td></td>
<td></td>
</tr>
    <tr>
        <td align="left" valign="top" nowrap="nowrap">Email</td>
        <td align="left" valign="top">:</td>
        <td><input name="email" type="text" id="email" value="<?php echo($ata['email']); ?>"/></td>
        <td align="left" valign="top">id pegawai</td>
        <td align="left" valign="top">:</td>
        <td align="left" valign="top"><input name="hp3" type="text" id="hp3"
                                             value="<?php echo($ata['id_pegawai']); ?>"
                                             readonly="readonly"/></td>
    </tr>
    <tr>
        <td align="left" valign="top" nowrap="nowrap">Keterangan</td>
        <td align="left" valign="top">:</td>
        <td><textarea name="keterangan" type="text"
                      id="keterangan"><?php echo($ata['keterangan']); ?></textarea></td>
        <td align="left" valign="top">Jumlah Transit</td>
        <td align="left" valign="top">:</td>
        <td align="left" valign="top">
            <input name="jumlah_transit" type="text" id="jumlah_transit"
                   value="<?php echo $ata['jumlah_transit'] ? $ata['jumlah_transit'] : 0 ?>"> Kali                        </td>
    </tr>

    <tr>
        <td align="left" valign="top" nowrap="nowrap">Map Arsip</td>
        <td align="left" valign="top">:</td>
        <td><input type="radio" name="berkas" id="radio"
                   value="1" <?php if ($ata['status_map'] == 1) echo(" checked=checked"); ?>/>

            Ada
            <input type="radio" name="berkas" id="radio"
                   value="0" <?php if ($ata['status_map'] == 0) echo(" checked=checked"); ?> />
            Tidak Ada                        </td>
        <td align="left" valign="top"></td>
        <td align="left" valign="top"></td>
        <td align="left" valign="top">                        </td>
    </tr>
</table>
