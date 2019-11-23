<table width="100%" border="0" cellpadding="3" cellspacing="0" class="hurup">
    <tr>
        <td>No</td>
        <td>Tingkat Pendidikan</td>
        <td>Lembaga Pendidikan</td>
        <td>Jurusan</td>
        <td>Bidang Pendidikan</td>
        <td>Tahun Lulus</td>
        <td>Berkas</td>
        <td>Aksi</td>

    </tr>

    <?php
    $j = 1;
    $qp = mysqli_query($con,"select * from pendidikan where id_pegawai=$id order by level_p");
    while ($pen = mysqli_fetch_array($qp)) {
        echo("<tr>
<td>$j</td>
<td>"); ?>
        <select name="tp<?php echo($j); ?>" id="tp<?php echo($j); ?>">
            <?php
            $qjo2 = mysqli_query($con,"SELECT tingkat_pendidikan FROM `pendidikan` where tingkat_pendidikan!=' '    group by tingkat_pendidikan");
            while ($otoi2 = mysqli_fetch_array($qjo2)) {
                if (trim($pen[3]) == trim($otoi2[0]))
                    echo("<option value=$otoi2[0] selected>$otoi2[0]</option>");
                else
                    echo("<option value=$otoi2[0]>$otoi2[0]</option>");
            }

            ?>
        </select>

        <?php

        echo "</td>

<td><input type=text name=lem$j id=lem$j value='$pen[2]' /></td>
<td><input type=text name=jur$j id=jur$j value='$pen[4]' /></td>
<td>";
        echo("<select name=bp$j id=bp$j >");
        echo("<option value=0 >Pilih Bidang</option>");
        $qb = mysqli_query($con,"select * from bidang_pendidikan order by bidang ASC");
        while ($bida = mysqli_fetch_array($qb)) {
            if ($bida[0] == $pen['id_bidang'])
                echo("<option value=$bida[0] selected> $bida[1]</option>");
            else
                echo("<option value=$bida[0] > $bida[1]</option>");


        }


        echo("</select>");
        echo "</td>
<td><input type=text name=lus$j id=lus$j value='$pen[5]' /><input type=hidden name=pendi$j id=pendi$j value='$pen[0]' /></td>

";

        ?>
        <td>
            <?php
            if ($pen['id_berkas'] > 0) {

                echo("<a href=berkas.php?idb=$pen[id_berkas] target=_blank>Preview</a>");

            }
            ?>
        </td>
        <td><a href="<?php echo "hapus_pendidikan.php?id_pendidikan=$pen[0]&id=$ata[id_pegawai]" ?>"
               onclick="return confirm('yakin lw mau ngehapus?');">hapus</a></td>
        <?php echo "</tr>";

        $j++;
    }
    $totpen = $j - 1;
    ?>
    <tr>
        <td>+</td>
        <td><select name="tingkat" id="tingkat">
                <?php
                $qjo2 = mysqli_query($con,"SELECT tingkat_pendidikan FROM `pendidikan` where tingkat_pendidikan!=' '   group by tingkat_pendidikan ");
                while ($otoi2 = mysqli_fetch_array($qjo2))
                    echo("<option value=$otoi2[0]>$otoi2[0]</option>");

                ?>
            </select>
            <input name="totalpen" type="hidden" id="totalpen" value="<?php echo($totpen); ?>"/></td>
        <td><label for="lembaga"></label>
            <input type="text" name="lembaga" id="lembaga"/>
            <script type="text/javascript">
                $(document).ready(function () {
                    $("#jurusan").autocomplete({
                        source: function (request, response) {
                            $.ajax({
                                url: "prosesj.php",
                                dataType: "json",
                                data: {
                                    q: request.term,
                                    ins: document.getElementById('lembaga').value,
                                    kategori: $("#lembaga").val()
                                },
                                success: function (data, ui) {
                                    response(data);

                                }
                            });
                        },

                        minLength: 1,
                        select: function (event, ui) {
                            var origEvent = event;
                            while (origEvent.originalEvent !== undefined)
                                origEvent = origEvent.originalEvent;
                            if (origEvent.type == 'keydown') {
                                $("#jurusan").click();


                            }
                        }

                    });


                    $("#lembaga").autocomplete({
                        source: function (request, response) {
                            $.ajax({
                                url: "prosesi.php",
                                dataType: "json",
                                data: {
                                    q: request.term
                                },
                                success: function (data) {
                                    response(data);
                                }
                            });
                        },

                        minLength: 1,
                        select: function (event, ui) {
                            var origEvent = event;
                            while (origEvent.originalEvent !== undefined)
                                origEvent = origEvent.originalEvent;
                            if (origEvent.type == 'keydown') {
                                $("#lembaga").click();


                            }
                        }

                    });

                });
            </script>

        </td>
        <td><input type="text" name="jurusan" id="jurusan"/></td>
        <td><select name="bidang" id="bidang" ">
            <?php
            echo("<option value=0>Pilih Bidang</option>");
            $qbid = mysqli_query($con,"select * from bidang_pendidikan order by bidang");
            while ($bid = mysqli_fetch_array($qbid))
                echo("<option value=$bid[0]>$bid[1]</option>");

            ?>
            </select></td>
        <td><input type="text" name="lulusan" id="lulusan"/></td>
    </tr>
</table>
