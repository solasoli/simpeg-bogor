<style>
    .paginate {
        font-family: Arial, Helvetica, sans-serif;
        font-size: .7em;
    }

    a.paginate {
        border: 1px solid #000080;
        padding: 2px 6px 2px 6px;
        text-decoration: none;
        color: #000080;
    }

    a.paginate:hover {
        background-color: #000080;
        color: #FFF;
        text-decoration: underline;
    }

    a.current {
        border: 1px solid #000080;
        font: bold .7em Arial,Helvetica,sans-serif;
        padding: 2px 6px 2px 6px;
        cursor: default;
        background:#000080;
        color: #FFF;
        text-decoration: none;
    }

    span.inactive {
        border: 1px solid #999;
        font-family: Arial, Helvetica, sans-serif;
        font-size: .7em;
        padding: 2px 6px 2px 6px;
        color: #999;
        cursor: default;
    }
</style>

<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<br>
<div class="container">
    <strong>DAFTAR STATUS DIKLAT PEJABAT STRUKTURAL</strong>
    <div class="grid">
        <div class="row" style="margin-bottom: -10px;">
            <div class="span13" style="margin-top: -10px;">
                <table class="table">
                    <tr>
                        <th><?php if (isset($list_status)): ?>
                                <div class="input-control select" style="width: 100%;">
                                    <select id="ddFilterStatus" style="background-color: #e3c800;">
                                        <option value="0">Semua Status</option>
                                        <?php foreach ($list_status as $ls): ?>
                                            <?php if($ls->status_diklat == $status_diklat): ?>
                                                <option value="<?php echo $ls->status_diklat; ?>" selected><?php echo $ls->status_diklat; ?></option>
                                            <?php else: ?>
                                                <option value="<?php echo $ls->status_diklat; ?>"><?php echo $ls->status_diklat; ?></option>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            <?php endif; ?>
                        </th>

                        <th><?php if (isset($list_skpd)): ?>
                                <div class="input-control select" style="width: 150px;">
                                    <select id="ddFilterOPD" style="background-color: #e3c800;">
                                        <option value="0">Semua OPD</option>
                                        <?php foreach ($list_skpd as $ls): ?>
                                            <?php if($ls->id_unit_kerja == $idskpd): ?>
                                                <option value="<?php echo $ls->id_unit_kerja; ?>" selected><?php echo $ls->nama_baru; ?></option>
                                            <?php else: ?>
                                                <option value="<?php echo $ls->id_unit_kerja; ?>"><?php echo $ls->nama_baru; ?></option>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            <?php endif; ?>
                        </th>

                        <th><?php if (isset($list_eselon)): ?>
                                <div class="input-control select" style="width: 120px;">
                                    <select id="ddFilterEselon" style="background-color: #e3c800;">
                                        <option value="0">Semua Eselon</option>
                                        <?php foreach ($list_eselon as $ls): ?>
                                            <?php if($ls->eselon == $eselon): ?>
                                                <option value="<?php echo $ls->eselon; ?>" selected><?php echo $ls->eselon; ?></option>
                                            <?php else: ?>
                                                <option value="<?php echo $ls->eselon; ?>"><?php echo $ls->eselon; ?></option>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            <?php endif; ?>
                        </th>

                        <th><?php if (isset($list_gol)): ?>
                                <div class="input-control select" style="width: 150px;">
                                    <select id="ddFilterGol" style="background-color: #e3c800;">
                                        <option value="0">Semua Golongan</option>
                                        <?php foreach ($list_gol as $ls): ?>
                                            <?php if($ls->golongan == $gol): ?>
                                                <option value="<?php echo $ls->golongan; ?>" selected><?php echo $ls->pangkat.' ('.$ls->golongan.')'; ?></option>
                                            <?php else: ?>
                                                <option value="<?php echo $ls->golongan; ?>"><?php echo $ls->pangkat.' ('.$ls->golongan.')'; ?></option>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            <?php endif; ?>
                        </th>

                        <th>
                            <div class="input-control text">
                                <input id="keywordCari"type="text" value="<?php echo $keywordCari; ?>" placeholder="Kata kunci" style="background-color: #e3c800;" />
                            </div>
                        </th>

                        <th>
                            <div style="margin-top: 5px;font-weight: bold;">Umur</div>
                        </th>

                        <th>
                            <div class="input-control select" style="width: 50px;">
                                <select id="ddOperator" style="background-color: #e3c800;">
                                    <option value="<" <? echo $operator=='<'?'selected':''; ?>><</option>
                                    <option value=">" <? echo $operator=='>'?'selected':''; ?>>></option>
                                </select>
                            </div>
                        </th>

                        <th>
                            <div class="input-control text" style="width: 50px;">
                                <input id="txtUmurFilter"type="text" value="<?php echo $umur; ?>" placeholder="Umur" style="background-color: #e3c800;" number="number" />
                            </div>
                        </th>

                        <th>
                            <button id="btn_tampilkan" class="button primary" style="height: 35px;">
                                <strong>Tampilkan</strong></button>
                        </th>
                    </tr>
                </table>
                <script>
                    function checkSelectVal(a){
                        return $( "#ddSortParam"+(a-1).toString()).val();
                    }
                </script>
                <table class="table" style="margin-top: -40px;" >
                    <tr>
                        <th>
                            Sort By :
                        </th>
                        <?php
                        for($i=1;$i<=5;$i++){
                        ?>
                        <th>
                            <div class="input-control select">
                                <select id="ddSortParam<?php echo $i;?>" style="background-color: #e3c800;">
                                    <option value="0">Level <?php echo $i;?></option>
                                    <option value="skpd-asc" <?php echo ($i==1?($a=='skpd-asc'?'selected':''):($i==2?($b=='skpd-asc'?'selected':''):($i==3?($c=='skpd-asc'?'selected':''):($i==4?($d=='skpd-asc'?'selected':''):($i==5?($e=='skpd-asc'?'selected':''):''))))); ?>>OPD (Asc)</option>
                                    <option value="nama2-asc" <?php echo ($i==1?($a=='nama2-asc'?'selected':''):($i==2?($b=='nama2-asc'?'selected':''):($i==3?($c=='nama2-asc'?'selected':''):($i==4?($d=='nama2-asc'?'selected':''):($i==5?($e=='nama2-asc'?'selected':''):''))))); ?>>Nama (Asc)</option>
                                    <option value="eselon-asc" <?php echo ($i==1?($a=='eselon-asc'?'selected':''):($i==2?($b=='eselon-asc'?'selected':''):($i==3?($c=='eselon-asc'?'selected':''):($i==4?($d=='eselon-asc'?'selected':''):($i==5?($e=='eselon-asc'?'selected':''):''))))); ?>>Eselon (Asc)</option>
                                    <option value="umur-desc" <?php echo ($i==1?($a=='umur-desc'?'selected':''):($i==2?($b=='umur-desc'?'selected':''):($i==3?($c=='umur-desc'?'selected':''):($i==4?($d=='umur-desc'?'selected':''):($i==5?($e=='umur-desc'?'selected':''):''))))); ?>>Umur (Desc)</option>
                                    <option value="usia_jabatan-desc" <?php echo ($i==1?($a=='usia_jabatan-desc'?'selected':''):($i==2?($b=='usia_jabatan-desc'?'selected':''):($i==3?($c=='usia_jabatan-desc'?'selected':''):($i==4?($d=='usia_jabatan-desc'?'selected':''):($i==5?($e=='usia_jabatan-desc'?'selected':''):''))))); ?>>Usia Jabatan (Desc)</option>
                                </select>
                            </div>
                        </th>

                            <?php
                            if($i>1){
                            ?>
                                <script>
                                    $('#ddSortParam<?php echo $i;?>').on('change', function() {
                                        if(this.value == 0){ // or $(this).val()
                                            for (i = <?php echo $i+1;?>; i <= 7; i++) {
                                                $('select#ddSortParam'+i+" option").each(function() { this.selected = (this.text == 0); });
                                            }
                                        }else{
                                            if(checkSelectVal(<?php echo $i;?>)=='0'){
                                                //alert('Pilih dahulu Level <?php //echo $i-1;?>');
                                                $(this).val('0');
                                            }
                                        }
                                    });
                                </script>
                            <?php
                            }else{
                            ?>
                                <script>
                                    $('#ddSortParam<?php echo $i;?>').on('change', function() {
                                        if(this.value == 0){ // or $(this).val()
                                            for (i = <?php echo $i;?>; i <= 7; i++) {
                                                $('select#ddSortParam'+i+" option").each(function() { this.selected = (this.text == 0); });
                                            }
                                        }
                                    });
                                </script>
                            <?php
                            }
                        } ?>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <div class="grid">
        <div class="row" style="margin-top: -30px;">
            <div class="span12">
                <?php if(isset($pgDisplay)): ?>
                    <?php if($numpage > 0): ?>
                        Halaman ke <?php echo $curpage; ?> dari <?php echo $numpage; ?> | Jumlah Data : <?php echo $total_items; ?> | <?php echo $jumppage; ?> | <?php echo $item_perpage; ?>
                        | <span style="font-family: Arial, Helvetica, sans-serif;font-size: .7em;">*Kata Kunci: NIP, Nama, Jabatan</span><br><?php echo $pgDisplay; ?>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <table class="table bordered striped" id="lst_cuti">
        <thead style="border-bottom: solid #a4c400 2px;">
        <tr>
            <th>No</th>
            <th>NIP</th>
            <th>Nama</th>
            <th>Gol</th>
            <th>Umur</th>
            <th>Jabatan</th>
            <th>OPD</th>
            <th style="width: 10%;">Status</th>
            <th>Eselon</th>
            <th>TMT. Pertama</th>
            <th>Usia Jabatan</th>
            <th width="10%">Aksi</th>
        </tr>
        </thead>
        <?php if (sizeof($list_data) > 0): ?>
            <?php $i = 1; ?>
            <?php if($list_data!=''): ?>
                <?php foreach ($list_data as $lsdata): ?>
                    <tr>
                        <td><?php echo $lsdata->no_urut; ?></td>
                        <td><?php echo $lsdata->nip_baru?></td>
                        <td><?php echo $lsdata->nama?></td>
                        <td><?php echo $lsdata->pangkat_gol?></td>
                        <td><?php echo $lsdata->umur?></td>
                        <td><?php echo $lsdata->jabatan?></td>
                        <td><?php echo $lsdata->skpd?></td>
                        <td><?php echo $lsdata->status_diklat?></td>
                        <td><?php echo $lsdata->eselon?></td>
                        <td><?php echo $lsdata->tmt_awal_eselon2?></td>
                        <td><?php echo $lsdata->lama_jabatan; ?></td>
                        <td>
                            <a onclick="lihat_detail_diklat_pejabat(<?php echo $lsdata->id_pegawai.",'".$lsdata->nip_baru."','".$lsdata->nama.
                            "','".$lsdata->pangkat_gol."','".$lsdata->jabatan."','".$lsdata->skpd."','".$lsdata->status_diklat."','".$lsdata->eselon."'" ?>)"
                               class="button default">Lihat Detail</a>
                        </td>
                    </tr>
                    <?php $i++; ?>
                <?php endforeach; ?>
            <?php else: ?>
                <tr class="error">
                    <td colspan="9"><i>Tidak ada data</i></td>
                </tr>
            <?php endif; ?>
        <?php else: ?>
            <tr class="error">
                <td colspan="9"><i>Tidak ada data</i></td>
            </tr>
        <?php endif; ?>

        </table>

    <?php if(isset($pgDisplay)): ?>
        <?php if($numpage > 0): ?>
            Halaman ke <?php echo $curpage; ?> dari <?php echo $numpage; ?> | Jumlah Data : <?php echo $total_items; ?> | <?php echo $jumppage; ?> | <?php echo $item_perpage; ?><br>
            <?php echo $pgDisplay; ?>
        <?php endif; ?>
    <?php endif; ?>

</div>

<script>

    function lihat_detail_diklat_pejabat(idp, nip, nama, gol, jab, skpd, status, eselon){
        $.ajax({
            method: "POST",
            url: "<?php echo base_url()?>index.php/diklat/detail_diklat_pejabat",
            data: { idp: idp, nip: nip, nama : nama, gol: gol, jab: jab, skpd: skpd, status:status, eselon:eselon },
            dataType: "html"
        }).done(function( data ) {
            $("#detail_list_diklat").html(data);
            $("#detail_list_diklat").find("script").each(function(i) {
                //eval($(this).text());
            });
        });

        $.Dialog({
            shadow: true,
            overlay: false,
            icon: '<span class="icon-rocket"></span>',
            title: 'Detail Informasi Diklat',
            width: 850,
            height: 550,
            padding: 10,
            content: "<div id='detail_list_diklat' style='height:450px; overflow:auto;'></div>"
        });
    }

    $("#btn_tampilkan").click(function(){
        var status_diklat = $('#ddFilterStatus').val();
        var idskpd = $('#ddFilterOPD').val();
        var eselon = $('#ddFilterEselon').val();
        var gol = $('#ddFilterGol').val();
        var keywordCari = $("#keywordCari").val();
        var operator = $('#ddOperator').val();
        var umur = $('#txtUmurFilter').val();
        var a = $('#ddSortParam1').val();
        var b = $('#ddSortParam2').val();
        var c = $('#ddSortParam3').val();
        var d = $('#ddSortParam4').val();
        var e = $('#ddSortParam5').val();

        loadDataListDiklatPejabat(status_diklat,idskpd,eselon,gol,keywordCari,operator,umur,'<?php echo isset($_GET['page'])?1:1; ?>',a,b,c,d,e);//$_GET['page']
    });

    function loadDataListDiklatPejabat(status_diklat,idskpd,eselon,gol,keywordCari,operator,umur,page,a,b,c,d,e){
        var ipp = $("#selIpp").val();
        location.href="<?php echo base_url()."diklat/status_diklat_pejabat/" ?>"+"?page="+page+"&ipp="+ipp+"&status_diklat="+status_diklat+"&idskpd="+idskpd+"&eselon="+eselon+"&gol="+gol+"&keywordCari="+keywordCari+"&operator="+operator+"&umur="+umur+"&a="+a+"&b="+b+"&c="+c+"&d="+d+"&e="+e;
    }

</script>