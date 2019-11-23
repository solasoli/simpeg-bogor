<script>
    var arrPilih2 = [];
</script>

<div class="grid" style="background-color: white;margin-bottom: -25px;">
    <div class="row">
        <div class="tab-control" data-role="tab-control" id="tabUbahPengantar">
            <ul class="tabs">
                <li class="active"><a href="#_page_1_ptr">Form & Nominatif</a></li>
                <li><a href="#_page_2_ptr">Upload File Pengantar</a></li>
            </ul>
            <div class="frames">
                <div class="frame" id="_page_1_ptr">
                    <div class="grid" style="margin-top: -20px;margin-bottom: -10px;">
                        <div class="row">
                            <?php if (sizeof($listdata) > 0): ?>
                                <?php if ($listdata != ''): ?>
                                    <?php foreach ($listdata as $lsdata): ?>
                                        <form action="" id="frmUbahPtr" novalidate="novalidate"
                                              enctype="multipart/form-data">
                                            <div class="span3">
                                                <div class="row" style="margin-top: -20px;padding-bottom: 15px;">
                                                    <div class="span3">
                                                        <input id="submitok_ptr" name="submitok_ptr" type="hidden"
                                                               value="1">
                                                        <input type="hidden" id="id_ptr" name="id_ptr"
                                                               value="<?php echo $id_pengantar; ?>">

                                                        <div class="input-control text">
                                                            <label style="font-size: small;margin-top: 5px;"><strong>Jenis
                                                                    :</strong> <?php echo $lsdata->jenis_pengantar ?>
                                                                <br>
                                                                Periode
                                                                : <?php echo $lsdata->bln . ' - ' . $lsdata->thn; ?><br>
                                                                Waktu : <?php echo $lsdata->tgl_pembuatan; ?>
                                                            </label>
                                                        </div>
                                                        <div class="input-control text" style="margin-top: 5px;">
                                                            <label>Nomor</label>
                                                            <input id="nomorPtr" name="nomorPtr" type="text"
                                                                   value="<?php echo $lsdata->nomor ?>" required>
                                                        </div>
                                                        <div class="input-control text" style="margin-top: 10px;">
                                                            <label>Pengesah</label>
                                                            <table style="width: 100%; background-color: white;">
                                                                <tr>
                                                                    <td><input id="nipPengesah" name="nipPengesah"
                                                                               type="text" value=""
                                                                               placeholder="Masukkan NIP"></td>
                                                                    <td>
                                                                        <button id="btnCariNip" name="btnCariNip"
                                                                                type="button" class="button info"
                                                                                style="height: 33px; width: 100%"
                                                                                onclick="getInfoPegawai();">
                                                                            <strong>Cari</strong></button>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </div>
                                                        <div id="divInfoPegawai" style="font-size: small;">
                                                            <?php if ($lsdata->nip_pengesah != ''): ?><br>
                                                                <?php echo $lsdata->nama_pengesah; ?><br>
                                                                <?php echo $lsdata->nip_pengesah; ?><br>
                                                                <?php echo $lsdata->jabatan; ?><br>
                                                                Status : <?php echo $lsdata->flag_pensiun == 0 ? 'Aktif Bekerja' : 'Pensiun/Pindah'; ?>
                                                            <?php else: ?>
                                                                <i>Belum ada data pengesah</i>
                                                            <?php endif; ?>
                                                            <input type="hidden" id="txtIdPegawaiPengesah"
                                                                   name="txtIdPegawaiPengesah"
                                                                   value="<?php echo(isset($lsdata->id_pegawai_pengesah) ? $lsdata->id_pegawai_pengesah : ''); ?>">
                                                        </div>
                                                        <button id="btnregister" name="new_register" type="submit"
                                                                class="button success"
                                                                style="height: 34px; margin-top: 5px;">
                                                            <span
                                                                class="icon-floppy on-left"></span><strong>Simpan</strong>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="span6" style="margin-top: -20px;">
                                                <div style="color: blue;background-color: #EEEEEE;border: 1px solid #747571;
                                                width: 108%;font-size: small;padding: 3px;margin-bottom: 0px;text-align: center;margin-top: 10px;">
                                                    Daftar Pengajuan PTK (Sesuai Penerbitan Surat ke BPKAD)
                                                </div>
                                                <div class="row" style="margin-top: 6px;width: 108%;">
                                                    <span class="span1" style="margin-left: 0px;">
                                                        <div class="input-control select" style="width: 180%;">
                                                            <select id="ddFilterBln" name="ddFilterBln">
                                                                <option value="0">Bln</option>
                                                                <?php
                                                                $i = 0;
                                                                for ($x = 0; $x <= 11; $x++) {
                                                                    if ($listBln[$i][0] == date("m")) {
                                                                        echo "<option value=" . $listBln[$i][0] . " selected>" . $listBln[$i][1] . "</option>";
                                                                    } else {
                                                                        echo "<option value=" . $listBln[$i][0] . ">" . $listBln[$i][1] . "</option>";
                                                                    }
                                                                    $i++;
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </span>
                                                    <span class="span1" style="margin-left: 50px;">
                                                        <div class="input-control select" style="width: 110%;">
                                                            <select id="ddFilterThn" name="ddFilterThn">
                                                                <option value="0">Thn</option>
                                                                <?php
                                                                $i = 0;
                                                                for ($x = 0; $x < sizeof($listThn); $x++) {
                                                                    if ($listThn[$i] == date("Y")) {
                                                                        echo "<option value=" . $listThn[$i] . " selected>" . $listThn[$i] . "</option>";
                                                                    } else {
                                                                        echo "<option value=" . $listThn[$i] . ">" . $listThn[$i] . "</option>";
                                                                    }
                                                                    $i++;
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </span>
                                                    <span class="span1" style="margin-left: 10px;">
                                                        <div class="input-control text" style="width:150%;">
                                                            <input id="keywordCari" type="text" value=""
                                                                   placeholder="Kata kunci"/>
                                                        </div>
                                                    </span>
                                                    <span class="span1" style="margin-left: 35px;">
                                                        <button id="btn_tampilkan_ptr" class="button primary"
                                                                style="height: 33px; width: 120%;"
                                                                type="button" onclick="filterCariNominatifPeriode();">
                                                            <!--<span
                                                                class="icon-search on-left"></span>--><strong>Cari</strong>
                                                        </button>
                                                    </span>
                                                    <span class="span1" style="margin-left: 18px;">
                                                        <button id="btnPilih_ptr" class="button warning"
                                                                style="height: 33px; width: 130%;" type="button">
                                                            <strong>Pilih</strong> <!--<span class="icon-arrow-right on-right"></span>-->
                                                        </button>
                                                    </span>
                                                    <span class="span1" style="width: 50%">
                                                        <img id="imgLoadingPtk" src="<?php echo base_url()?>/images/preload-crop.gif" height="28" width="27">
                                                    </span>
                                                </div>
                                                <div id="divListDrop" style="border:1px solid #c0c2bb; overflow: scroll;
                                                height: 295px; width: 108%;padding: 5px;">
                                                </div>
                                            </div>
                                            <div class="span6" style="margin-top: -20px;margin-left: 40px;">
                                                <?php
                                                $pengantarNominatif = $this->ptk->nominatifRekapPTK_ByPengantar($id_pengantar);
                                                $jmlList = sizeof($pengantarNominatif);
                                                $i = 1;
                                                ?>
                                                <div style="color: blue;background-color: #EEEEEE;border: 1px solid #747571;
                                                width: 102%;font-size: small;padding: 3px;margin-bottom: 0px;text-align: center;margin-top: 10px;">
                                                    Daftar Nominatif Eksisting Berds. Pengantar
                                                </div>
                                                <div class="row" style="margin-top: 6px;">
                                                    <span class="span4" style="margin-left: 0px;">
                                                        Pengajuan PTK yang dipilih berjumlah : <br><span id="jmlPTKPlih"
                                                                                                         style="font-weight: bold">
                                                            <?php echo $jmlList; ?></span> Usulan
                                                    </span>
                                                    <span class="span2" style="margin-left: -15px;">
                                                        <button id="btnHapus" class="button danger"
                                                                style="height: 35px;width: 130%;" type="button">
                                                            <span class="icon-remove on-left"></span><strong>Hapus yg
                                                                diceklis</strong></button>
                                                    </span>
                                                </div>
                                                <div id="divChkStore" style="border:1px solid #c0c2bb; overflow: scroll;
                                                height: 295px; width: 102%;padding: 5px;">
                                                    <table class="table bordered" id="tbl_nominatif_pengantar"
                                                           width="100%">
                                                        <thead style="border-bottom: solid darkred 3px;">
                                                        <tr>
                                                            <th style="vertical-align: middle;">
                                                                <label class="input-control checkbox small-check"
                                                                       style="margin-top: 0px;margin-bottom:0px;;vertical-align: middle;">
                                                                    <input type="checkbox" id="checkAllPilihPtk"
                                                                           checked><span class="check"></span>
                                                                </label>
                                                            </th>
                                                            <th style="vertical-align: middle;">Tgl.Usulan</th>
                                                            <th style="vertical-align: middle;">Nama</th>
                                                            <th style="vertical-align: middle;">Uraian</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <?php
                                                        $dataArrPilih = array();
                                                        foreach ($pengantarNominatif as $rp) { ?>
                                                            <tr id="rowTblPilih<?php echo $rp->id_ptk; ?>">
                                                                <td><?php echo $i; ?>.<br>
                                                                    <label class="input-control checkbox small-check"
                                                                           style="margin-top: 0px;">
                                                                        <input type="checkbox"
                                                                               value="<?php echo $rp->id_ptk; ?>"
                                                                               id="chkPtkPtr<?php echo $rp->id_ptk; ?>"
                                                                               name="chkPtkPtr<?php echo $rp->id_ptk; ?>"
                                                                               checked>
                                                                        <span class="check"></span>
                                                                </td>
                                                                <td><?php echo $rp->tgl_input_pengajuan; ?></td>
                                                                <td><span
                                                                        style="color: #002a80;font-weight: bold;"><?php echo $rp->nama; ?></span>
                                                                    <br><?php echo $rp->nip_baru; ?></td>
                                                                <td>
                                                                    <?php echo(($rp->istri_nambah > 0 OR $rp->suami_nambah > 0) ? ' Penambahan' : (($rp->istri_ngurang > 0 OR $rp->suami_ngurang > 0) ? ' Pengurangan' : '')) ?><!--</td>-->
                                                                    <!--<td>--><?php echo($rp->istri_nambah > 0 ? $rp->istri_nambah . ' Orang Istri' : ($rp->suami_nambah > 0 ? $rp->suami_nambah . ' Orang Suami' :
                                                                        ($rp->istri_ngurang > 0 ? $rp->istri_ngurang . ' Orang Istri' : ($rp->suami_ngurang > 0 ? $rp->suami_ngurang . ' Orang Suami' : '')))) ?>
                                                                    <!--</td>-->
                                                                    <!--<td>-->
                                                                    <?php echo($rp->anak_nambah > 0 ? ' Penambahan' : ($rp->anak_ngurang > 0 ? ' Pengurangan' : '')) ?><!--</td>-->
                                                                    <!--<td>--><?php echo($rp->anak_nambah > 0 ? $rp->anak_nambah . ' Orang Anak' : ($rp->anak_ngurang > 0 ? $rp->anak_ngurang . ' Orang Anak' : '')) ?></td>
                                                            </tr>
                                                            <?php
                                                            $dataArrPilih[] = $rp->id_ptk;
                                                            $i++;
                                                        } ?>
                                                        <script>
                                                            var arrPilih2 = <?php echo json_encode( $dataArrPilih ) ?>;
                                                        </script>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </form>
                                        <script>
                                            $(function () {
                                                $("#frmUbahPtr").validate({
                                                    ignore: "",
                                                    submitHandler: function (form) {
                                                        var checkboxes = $("#divChkStore input:checkbox");
                                                        var jmlCheck = 0;
                                                        var strIdPtk = "";
                                                        for (var i = 1; i < checkboxes.length; i++) {
                                                            if (checkboxes[i].checked == true) {
                                                                strIdPtk += checkboxes[i].value + "#";
                                                                jmlCheck++;
                                                            }
                                                        }
                                                        strIdPtk = strIdPtk.substring(0, ((strIdPtk.length) - 1));
                                                        if (jmlCheck <= 0) {
                                                            alert('Pengajuan PTK yang akan dibuat nominatifnya harus dipilih dari Daftar Pengajuan PTK dan diceklis');
                                                        } else {
                                                            var dataPtr = new FormData();
                                                            var id_ptr2 = $('#id_ptr').val();
                                                            var nomorPtr = $('#nomorPtr').val();
                                                            var txtIdPegawaiPengesah = $('#txtIdPegawaiPengesah').val();
                                                            dataPtr.append('id_ptr', id_ptr2);
                                                            dataPtr.append('nomorPtr', nomorPtr);
                                                            dataPtr.append('txtIdPegawaiPengesah', txtIdPegawaiPengesah);
                                                            dataPtr.append('strIdPtk', strIdPtk);
                                                            jQuery.ajax({
                                                                url: "<?php echo base_url()?>index.php/ptk/update_pengantar",
                                                                data: dataPtr,
                                                                cache: false,
                                                                contentType: false,
                                                                processData: false,
                                                                type: 'POST',
                                                                success: function (data) {
                                                                    if (data == '1') {
                                                                        alert('Data sukses tersimpan');
                                                                        //window.location.reload();
                                                                    } else {
                                                                        alert(data);
                                                                    }
                                                                    pagingViewListLoad(<?php echo $curpage;?>, <?php echo $ipp?>);
                                                                }
                                                            });
                                                        }
                                                    }
                                                });
                                            });
                                        </script>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="frame" id="_page_2_ptr">
                    <?php if ($id_berkas == '') {
                        echo 'Belum ada File Surat Pengantar yang diupload : ';
                    } else {
                        $syaratBerkasLainnya = $this->ptk->cekBerkas($id_berkas);
                        if (isset($syaratBerkasLainnya)) {
                            $x = 1;
                            if (sizeof($syaratBerkasLainnya) > 0) {
                                foreach ($syaratBerkasLainnya as $row4) {
                                    $asli = basename($row4->file_name);
                                    $getcwd = substr(getcwd(), 0, strlen(getcwd()) - 1);
                                    if (file_exists(str_replace("\\", "/", $getcwd) . '/Berkas/' . trim($asli))) {
                                        $ext[] = explode(".", $asli);
                                        $linkBerkasPtk = "<a href='/simpeg/Berkas/$asli' target='_blank' style='font-weight: bold;'>Berkas Pengantar PTK ke BPKAD Terupload</a>";
                                        $tglUploadPtk = $row4->created_date;
                                        unset($ext);
                                        echo "$linkBerkasPtk";
                                        echo "<small class=\"form-text text-muted\">";
                                        echo "<br>Upload : " . $tglUploadPtk . " oleh: " . $row4->nama . "</small><br>";
                                        echo "-------------------------------------------------";
                                    } else {
                                        echo 'Belum ada File Surat Pengantar yang diupload (Data berkas sudah ada tapi file tidak ada).';
                                    }
                                }
                            }
                        }
                    } ?>

                    <div class="panel-content">
                        <a href='/simpeg2/ptk/cetak_pengantar_ptk/<?php echo $id_pengantar; ?>' target='_blank'
                           class="button"
                           style="background-color: #747571; font-weight: bold; color: white;">Download Format Pengantar
                            ke BPKAD</a>
                        <br><br>Upload File Baru (Tipe PDF maks. 2 MB):
                        <form action="" id="frmUploadPtr" novalidate="novalidate" enctype="multipart/form-data">
                            <input type="hidden" id="id_ptr" name="id_ptr" value="<?php echo $id_pengantar; ?>">
                            <input style="border: 1px solid #c0c2bb;" type="file" id="fileSkPtr" name="fileSkPtr"
                                   accept=".pdf"/>
                            <button id="btnbtnupload" name="new_upload" type="submit" class="button info"
                                    style="height: 28px; margin-top: 0px;">
                                <span class="icon-upload on-left"></span><strong>Upload</strong></button>
                        </form>
                        <script>
                            $(function () {
                                var filePtrSize = 0;
                                $('#fileSkPtr').bind('change', function () {
                                    filePtrSize = this.files[0].size;
                                });

                                $("#frmUploadPtr").validate({
                                    ignore: "",
                                    submitHandler: function (form) {
                                        var data = new FormData();
                                        var id_ptr = $('#id_ptr').val();
                                        if (parseFloat(filePtrSize) > 2138471) {
                                            alert('Ukuran file terlalu besar');
                                        } else {
                                            if (parseFloat(filePtrSize) > 0) {
                                                jQuery.each(jQuery('#fileSkPtr')[0].files, function (i, file) {
                                                    data.append('fileSkPtr', file);
                                                });
                                            }
                                            data.append('id_ptr', id_ptr);
                                            jQuery.ajax({
                                                url: "<?php echo base_url()?>index.php/ptk/upload_surat_ptr_ptk",
                                                data: data,
                                                cache: false,
                                                contentType: false,
                                                processData: false,
                                                type: 'POST',
                                                success: function (data) {
                                                    if (data == '1') {
                                                        alert('File sudah terupload dan Surat Pengantar ke BPKAD diterbitkan');
                                                    } else {
                                                        alert(data);
                                                    }
                                                    pagingViewListLoad(<?php echo $curpage;?>, <?php echo $ipp?>);
                                                }
                                            });
                                        }
                                    }
                                });
                            });
                        </script>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    var img = document.getElementById("imgLoadingPtk");
    img.style.visibility = 'hidden';

    $(function () {
        filterCariNominatifPeriode();
    });

    $('#tabUbahPengantar').tabcontrol({
        effect: 'fade' // or 'slide'
    });

    /*$('#tbl_nominatif_pengantar').dataTable({
     "paging": false,
     "ordering": false,
     "info": false
     });*/

    function filterCariNominatifPeriode() {
        var bln = $('#ddFilterBln').val();
        var thn = $('#ddFilterThn').val();
        var keyword = $('#keywordCari').val();
        img.style.visibility = 'visible';
        $("#divListDrop").css("pointer-events", "none");
        $("#divListDrop").css("opacity", "0.4");
        $.ajax({
            method: "POST",
            url: "<?php echo base_url()?>index.php/ptk/nominatif_ptk_pengantar",
            data: {bln: bln, thn: thn, keyword: keyword},
            dataType: "html"
        }).done(function (data) {
            $("#divListDrop").html(data);
            $("#divListDrop").find("script").each(function (i) {
                eval($(this).text());
            });
            $("#divListDrop").css("pointer-events", "auto");
            $("#divListDrop").css("opacity", "1");
            img.style.visibility = 'hidden';
        });
    }

    function getInfoPegawai() {
        var nipCari = $("#nipPengesah").val();
        $.ajax({
            method: "POST",
            url: "<?php echo base_url()?>index.php/ptk/info_pegawai",
            data: {nipCari: nipCari, id_ptk: ''},
            dataType: "html"
        }).done(function (data) {
            $("#divInfoPegawai").html(data);
            $("#divInfoPegawai").find("script").each(function (i) {
                //eval($(this).text());
            });
        });
    }

    function loadDataPengantar(bln, thn, page, ipp) {
        $("#btn_tampilkan").css("pointer-events", "none");
        $("#btn_tampilkan").css("opacity", "0.4");
        $.post('<?php echo base_url()."index.php/ptk/drop_data_pengantar_bpkad"; ?>',
            {
                bln: bln,
                thn: thn,
                page: page,
                ipp: ipp
            }, function (data) {
                $("#divPengantar").html(data);
                $("#btn_tampilkan").css("pointer-events", "auto");
                $("#btn_tampilkan").css("opacity", "1");
            });
    }

    function pagingViewListLoad(parm, parm2) {
        var bln = $('#ddBulan').val();
        var thn = $('#ddTahun').val();
        loadDataPengantar(bln, thn, parm, parm2);
    }

    $("#checkAllPilihPtk").change(function () {
        $("#divChkStore input:checkbox").prop('checked', $(this).prop("checked"));
    });

    $("#btnPilih_ptr").click(function () {
        var checkboxes = $("#divListDrop input:checkbox");
        var idPtk = 0;
        for (var i = 1; i < checkboxes.length; i++) {
            if (checkboxes[i].checked == true) {
                var str = checkboxes[i].value;
                var res = str.split("#");
                idPtk = res[0].trim();
                var a = arrPilih2.indexOf(idPtk);
                if (a == -1) {
                    document.getElementById("jmlPTKPlih").innerHTML = parseInt(document.getElementById('jmlPTKPlih').innerHTML) + 1;
                    arrPilih2.push(idPtk);
                    $('#tbl_nominatif_pengantar tr:last').after('<tr id="rowTblPilih' + idPtk + '"><td><label class="input-control checkbox small-check" style="margin-top: -2px;margin-bottom: -50px;vertical-align: top;"><input type="checkbox" value="' + idPtk + '" id="chkIdPTKPilih[]" name="chkIdPTKPilih[]" checked><span class="check"></span></label></td><td>' + res[4] + '</td><td><span style="color: #002a80;font-weight: bold;">' + res[2] + '</span><br>' + res[1] + '</td><td>' + res[3] + '</td></tr>');
                }
            }
        }

    });

    $("#btnHapus").click(function () {
        var checkboxes = $("#divChkStore input:checkbox");
        var idPtk = 0;
        for (var i = 1; i < checkboxes.length; i++) {
            if (checkboxes[i].checked == true) {
                var str = checkboxes[i].value;
                var res = str.split("#");
                idPtk = res[0].trim();
                var a = arrPilih2.indexOf(idPtk);
                arrPilih2.splice(a, 1);
                document.getElementById("jmlPTKPlih").innerHTML = parseInt(document.getElementById('jmlPTKPlih').innerHTML) - 1;
                $('#rowTblPilih' + idPtk).remove();
                $("#checkAllPilihPtk").prop("checked", false);
            }
        }
    });

</script>