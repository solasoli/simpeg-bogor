<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<script src="<?php echo base_url()?>assets/jquery/dist/jquery.validate.js"></script>
<style>
    .error {
        color: red;
    };
</style>
<div class="container-fluid">
    <?php if($tx_result == 'true' and $tx_result!=''): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Selamat</strong> Data sukses tersimpan.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php elseif($tx_result == 'false' and $tx_result!=''): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Maaf</strong> Data tidak tersimpan.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>
    <h4>Ubah Methode</h4>
    <p>Mengubah data methode yang sudah diimplementasikan dalam bentuk fungsi pada entitas class (kategori API) tertentu.</p>

    <?php if (isset($methode) and sizeof($methode) > 0): ?>
        <?php $i = 1; ?>
        <?php if ($methode != ''): ?>
            <?php foreach ($methode as $lsdata): ?>
                <?php
                    $id_methode = $lsdata->id_methode;
                    $masehi = $lsdata->tgl.' '.$this->umum->monthName($lsdata->bln).' '.$lsdata->thn;
                ?>
                <form action="" method="post" id="frmUbahMethode" novalidate="novalidate" enctype="multipart/form-data">
                    <input id="submitok" name="submitok" type="hidden" value="1">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#methode">Methode</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#params">Parameter</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#respons">Respons</a>
                        </li>
                    </ul>
                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div class="tab-pane container-fluid active" id="methode"><br>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-control" id="txtUpdate" readonly="readonly"
                                         style="resize: none; height: auto; width: 100%;">
                                        <?php echo 'Input pada: '.$masehi.' '.$lsdata->jam.' oleh '.$lsdata->inputer;?>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-control" id="txtUpdate" readonly="readonly"
                                         style="width: 100%;">
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <strong>ID : <?php echo $lsdata->id_methode;?></strong>
                                                <input type="hidden" class="form-control" id="txtIdMethode" name="txtIdMethode" value="<?php echo $lsdata->id_methode; ?>">
                                            </div>
                                            <div class="col-sm-9" style="text-align: right;">
                                                <?php echo 'Update: '.$lsdata->tgl_update2;?></div>
                                        </div>
                                    </div>
                                </div>
                            </div><br>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="row">
                                        <div class="col-sm-3">Judul</div>
                                        <div class="col-sm-9"><input type="text" class="form-control" id="txtJudul" name="txtJudul" value="<?php echo $lsdata->judul; ?>"></div>
                                    </div><br>
                                    <div class="row">
                                        <div class="col-sm-3">Uraian</div>
                                        <div class="col-sm-9"><textarea class="form-control" rows="3" id="txtUraian" name="txtUraian" style="resize: none"><?php echo $lsdata->uraian; ?></textarea></div>
                                    </div><br>
                                    <div class="row">
                                        <div class="col-sm-3">Entitas</div>
                                        <div class="col-sm-9">
                                            <?php if (isset($entitas_list)): ?>
                                                <select id="ddEntitas" name="ddEntitas" class="custom-select">
                                                    <?php foreach ($entitas_list as $ls): ?>
                                                        <?php if ($ls->entitas == $lsdata->entitas): ?>
                                                            <option value="<?php echo $ls->entitas; ?>" selected><?php echo $ls->entitas.' ('.$ls->keterangan.')'; ?></option>
                                                        <?php else: ?>
                                                            <option value="<?php echo $ls->entitas; ?>"><?php echo $ls->entitas.' ('.$ls->keterangan.')'; ?></option>
                                                        <?php endif; ?>
                                                    <?php endforeach; ?>
                                                </select>
                                            <?php endif; ?>
                                        </div>
                                    </div><br>
                                    <div class="row">
                                        <div class="col-sm-3">Function</div>
                                        <div class="col-sm-9"><input type="text" class="form-control" id="txtFungsi" name="txtFungsi" value="<?php echo $lsdata->function; ?>"></div>
                                    </div><br>
                                    <div class="row">
                                        <div class="col-sm-3">URL</div>
                                        <div class="col-sm-9">
                                            <code><textarea class="form-control" rows="2" id="txtUrl" name="txtUrl" style="resize: none; font-size: small;"><?php echo $lsdata->url; ?></textarea></code>
                                        </div>
                                    </div><br>
                                    <div class="row">
                                        <div class="col-sm-3">Methode</div>
                                        <div class="col-sm-9">
                                            <?php if (isset($methode_type_list)): ?>
                                                <select id="ddMethode" name="ddMethode" class="custom-select">
                                                    <?php foreach ($methode_type_list as $ls): ?>
                                                        <?php if ($ls->methode_type == $lsdata->methode): ?>
                                                            <option value="<?php echo $ls->methode_type; ?>" selected><?php echo $ls->methode_type; ?></option>
                                                        <?php else: ?>
                                                            <option value="<?php echo $ls->methode_type; ?>"><?php echo $ls->methode_type; ?></option>
                                                        <?php endif; ?>
                                                    <?php endforeach; ?>
                                                </select>
                                            <?php endif; ?>
                                        </div>
                                    </div><br>
                                </div>
                                <div class="col-sm-6">
                                    <div class="row">
                                        <div class="col-sm-4">Sample Call</div>
                                        <div class="col-sm-8"><textarea class="form-control" rows="9" id="txtSampleCall" name="txtSampleCall" style="resize: none"><?php echo $lsdata->sample_call; ?></textarea></div>
                                    </div><br>
                                    <div class="row">
                                        <div class="col-sm-4">Keterangan</div>
                                        <div class="col-sm-8"><textarea class="form-control" rows="3" id="txtKet" name="txtKet" style="resize: none"><?php echo $lsdata->keterangan; ?></textarea></div>
                                    </div><br>
                                    <div class="row">
                                        <div class="col-sm-4">Parameter Terenkripsi</div>
                                        <div class="col-sm-8">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="chkParamEnkrip" name="chkParamEnkrip" value="true" <?php echo ($lsdata->flag_param_enkrip==1?'checked':''); ?>>
                                                <label class="form-check-label" for="chkParamEnkrip"></label>
                                            </div>
                                        </div>
                                    </div><br>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane container-fluid fade" id="params"><br>
                            <table class="table table-hover table-bordered table-sm">
                                <thead>
                                <tr style="text-align: center;">
                                    <th style="width: 5%;">No</th>
                                    <th>Nama Parameter</th>
                                    <th>Tipe</th>
                                    <th>Format Nilai</th>
                                    <th>Required</th>
                                    <th>Aksi</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php if (isset($params) and sizeof($params) > 0): ?>
                                    <?php
                                    $a = 1;
                                    echo "<input type=hidden name=jmlParam id=jmlParam value=".sizeof($params)." />";
                                    ?>
                                    <?php if ($params != ''): ?>
                                        <?php foreach ($params as $lsdata2): ?>
                                            <tr>
                                                <td style="text-align: center;">
                                                    <?php echo $a; ?>.
                                                    <input type="hidden" name="idparams<?php echo $a;?>" id="idparams<?php echo $a;?>" value="<?php echo $lsdata2->idrest_params;?>" />
                                                </td>
                                                <td>
                                                    <input class="form-control" type="text" name="params_name<?php echo $a;?>" id="params_name<?php echo $a;?>" value="<?php echo $lsdata2->params_name;?>" />
                                                </td>
                                                <td>
                                                    <select name="methode_type<?php echo($a); ?>" id="methode_type<?php echo($a); ?>" class="custom-select">
                                                        <?php
                                                        foreach ($methode_type_list as $optMetType){
                                                            if($optMetType->methode_type==$lsdata2->params_type) {
                                                                echo("<option value=" . $optMetType->methode_type . " selected>" . $optMetType->methode_type . "</option>");
                                                            }else{
                                                                echo("<option value=" . $optMetType->methode_type . ">" . $optMetType->methode_type . "</option>");
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </td>
                                                <td>
                                                    <input class="form-control" type="text" name="values<?php echo $a;?>" id="values<?php echo $a;?>" value="<?php echo $lsdata2->values;?>" />
                                                </td>
                                                <td>
                                                    <div class="form-check" style="text-align: center;">
                                                        <input type="checkbox" class="form-check-input" name="chkRequired<?php echo($a); ?>" id="chkRequired<?php echo($a); ?>"
                                                               value="<?php echo $lsdata2->is_required; ?>" <?php echo ($lsdata2->is_required==1?'checked':''); ?>>
                                                    </div>
                                                </td>
                                                <td style="text-align: center;"><button onclick="hapus_params(<?php echo $lsdata2->idrest_params?>)" type="button" class="btn btn-danger btn-sm"><span data-feather="trash-2"></span> Hapus</button></td>
                                            </tr>
                                            <?php
                                            $a++;
                                        endforeach; ?>
                                    <?php else: ?>
                                        <tr><td colspan="6"></td></tr>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <tr><td colspan="6"></td></tr>
                                <?php endif; ?>
                                <tr>
                                    <td style="text-align: center;"><strong>+</strong></td>
                                    <td><input class=form-control type=text name=params_name id=params_name value="" /></td>
                                    <td>
                                        <select name="methode_type" id="methode_type" class="custom-select">
                                            <?php
                                            foreach ($methode_type_list as $optMetType){
                                                echo("<option value=" . $optMetType->methode_type . ">" . $optMetType->methode_type . "</option>");
                                            }
                                            ?>
                                        </select>
                                    </td>
                                    <td><input class=form-control type=text name=values id=values value="" /></td>
                                    <td><div class="form-check" style="text-align: center;">
                                            <input type="checkbox" class="form-check-input" name=chkRequired id=chkRequired value="1"></div>
                                    </td>
                                    <td></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane container-fluid fade" id="respons"><br>
                            <table class="table table-hover table-bordered table-sm">
                                <thead>
                                <tr style="text-align: center;">
                                    <th style="width: 5%;">No</th>
                                    <th style="width: 10%;">Status Code</th>
                                    <th>Konten</th>
                                    <th style="width: 10%;">Aksi</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php if (isset($response) and sizeof($response) > 0): ?>
                                    <?php
                                    $b = 1;
                                    echo "<input type=hidden name=jmlRespon id=jmlRespon value=".sizeof($response)." />";
                                    ?>
                                    <?php if ($response != ''): ?>
                                        <?php foreach ($response as $lsdata3): ?>
                                            <tr>
                                                <td style="text-align: center;">
                                                    <?php echo $b; ?>.
                                                    <input type="hidden" name="idrespons<?php echo $b;?>" id="idrespons<?php echo $b;?>" value="<?php echo $lsdata3->idrest_response;?>" />
                                                </td>
                                                <td>
                                                    <input class="form-control" type="text" name="status_code<?php echo $b;?>" id="status_code<?php echo $b;?>" value="<?php echo $lsdata3->status_code;?>" />
                                                </td>
                                                <td>
                                                    <code><textarea class="form-control" rows="5" id="content<?php echo($b); ?>" name="content<?php echo($b); ?>" style="resize: none; font-size: small;"><?php echo $lsdata3->content; ?></textarea></code>
                                                </td>
                                                <td style="text-align: center;">
                                                    <button onclick="hapus_respons(<?php echo $lsdata3->idrest_response?>)" type="button" class="btn btn-danger btn-sm"><span data-feather="trash-2"></span> Hapus</button>
                                                </td>
                                            </tr>
                                            <?php
                                            $b++;
                                        endforeach; ?>
                                    <?php else: ?>
                                        <tr><td colspan="4"></td></tr>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <tr><td colspan="4"></td></tr>
                                <?php endif; ?>
                                <tr>
                                    <td style="text-align: center;"><strong>+</strong></td>
                                    <td><input class=form-control type=text name=status_code id=status_code value="" /></td>
                                    <td>
                                        <code><textarea class="form-control" rows="5" id="content" name="content" style="resize: none; font-size: small;"></textarea></code>
                                    </td>
                                    <td></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="row">
                            <div class="col-sm-2"></div>
                            <div class="col-sm-10">
                                <button id="btnregister" name="new_register" type="submit" class="btn btn-success btn-sm"><span data-feather="save"></span> Simpan</button>
                                <button onclick="daftar_methode()" type="button" class="btn btn-primary btn-sm"><span data-feather="arrow-left-circle"></span> Lihat Daftar</button>
                            </div>
                        </div>
                    </div>
                </form>
                <?php
                $i++;
            endforeach; ?>
        <?php else: ?>
            Tidak Ada Data
        <?php endif; ?>
    <?php else: ?>
        Tidak Ada Data
    <?php endif; ?>
</div><br>

<script>
    function daftar_methode(){
        location.href = "<?php echo base_url()."Administrator/methode_all_list" ?>";
    }

    function hapus_params(id){
        var r = confirm("Hapus data parameter ini?");
        if (r == true) {
            var data = new FormData();
            data.append('idrest_params', id);
            jQuery.ajax({
                url: '<?php echo base_url("Administrator/hapus_parameter")?>',
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                type: 'POST',
                success: function (data) {
                    if(data == 'BERHASIL'){
                        location.href = "<?php echo base_url()."Administrator/ubah_methode/$id_methode" ?>";
                    }else{
                        alert("Gagal menghapus \n "+data);
                    }
                }
            });
        }
    }

    function hapus_respons(id){
        var r = confirm("Hapus data parameter ini?");
        if (r == true) {
            var data = new FormData();
            data.append('idrest_response', id);
            jQuery.ajax({
                url: '<?php echo base_url("Administrator/hapus_response")?>',
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                type: 'POST',
                success: function (data) {
                    if(data == 'BERHASIL'){
                        location.href = "<?php echo base_url()."Administrator/ubah_methode/$id_methode" ?>";
                    }else{
                        alert("Gagal menghapus \n "+data);
                    }
                }
            });
        }
    }

    $(function(){
        $("#frmUbahMethode").validate({
            errorClass: 'errors',
            ignore: "",
            rules: {
                txtJudul: {
                    required: true
                },
                txtUraian: {
                    required: true
                },
                txtFungsi: {
                    required: true
                },
                txtUrl:{
                    required: true
                },
                txtSampleCall:{
                    required: true
                },
                txtKet:{
                    required: true
                }
            },
            messages: {
                txtJudul: {
                    required: "Anda belum mengisi Judul"
                },
                txtUraian: {
                    required: "Anda belum mengisi Uraian"
                },
                txtFungsi: {
                    required: "Anda belum mengisi Nama Fungsi"
                },
                txtUrl: {
                    required: "Anda belum mengisi URL"
                },
                txtSampleCall: {
                    required: "Anda belum mengisi Sample Call"
                },
                txtKet: {
                    required: "Anda belum mengisi Keterangan"
                }
            },
            highlight: function (element) {
                $(element).parent().addClass('error')
            },
            submitHandler: function(form) {
                form.submit();
            }
        });
    });

</script>