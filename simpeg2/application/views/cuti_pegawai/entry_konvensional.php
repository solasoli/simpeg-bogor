<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<script src="<?php echo base_url()?>js/jquery/jquery.validate.js"></script>

<div class="container">
    <div class="grid">
        <div class="row">
            <span style="font-weight: bold; margin-top: 50px;">TAMBAH DATA BARU PENGAJUAN CUTI OFFLINE</span>
        </div>
        <div class="row">
            <form action="" method="post" id="frmTambahCutiKonv" novalidate="novalidate" enctype="multipart/form-data">
                <input id="submitok" name="submitok" type="hidden" value="1">
                <div class="span5">
                    <div class="panel">
                        <div class="panel-header">Informasi Pegawai</div>
                        <div class="panel-content">
                            <div class="input-control text" style="margin-bottom: 40px;">
                                <label>NIP (Silahkan ketik untuk mencari)</label>
                                <table style="width: 100%">
                                    <th><input id="nipCari" name="nipCari" type="text" value=""></th>
                                    <th><button id="btnCariNip" name="btnCariNip" type="button" class="button info" style="height: 33px; width: 100%" onclick="getInfoPegawai();">
                                            <span class="icon-search on-left"></span><strong>Cari</strong></button></th>
                                </table>
                            </div>
                            <div id="divInfoPegawai">
                                <input type="hidden" id="txtIdPegawai" name="txtIdPegawai" value="">
                            </div>
                        </div>
                    </div>
                    <div class="panel" style="margin-top: 20px;">
                        <div class="panel-header">Surat Pengajuan Cuti</div>
                        <div class="panel-content">
                            <input type="file" id="fileSuratCuti" name="fileSuratCuti" />
                        </div>
                    </div>
                    <div class="panel" style="margin-top: 20px;">
                        <div class="panel-header">Penerbitan SK Cuti</div>
                        <div class="panel-content">
                            <input type="file" id="fileSKCuti" name="fileSKCuti" />
                        </div>
                    </div>
                </div>

                <div class="span4">
                    <div class="panel">
                        <div class="panel-header">Data Pegawai yang Cuti</div>
                        <div class="panel-content">
                            <div class="input-control text" style="margin-top: 0px;">
                                <label>Masukkan NIP</label>
                                <input type="text" id="txtnip" name="txtnip" value="">
                            </div>
                            <div class="input-control text" style="margin-top: 10px;">
                                <label>Jenjang</label>
                                    <div class="input-control select" style="width: 100%;">
                                        <select id="ddFilterJenjang" name="ddFilterJenjang">
                                            <option value="0">Pilih Jenjang</option>
                                            <option value="Struktural">Struktural</option>
                                            <option value="Fungsional">Fungsional</option>
                                        </select> <span id="jqv_msg"></span>
                                    </div>
                            </div>
                            <div class="input-control text" style="margin-top: 10px;">
                                <label>Jabatan</label>
                                <input id="txtJabatan" name="txtJabatan" type="text" value="" required>
                            </div>
                            <div class="input-control text" style="margin-top: 10px;">
                                <label>Golongan</label>
                                <?php if (isset($golongan)): ?>
                                    <div class="input-control select" style="width: 100%;">
                                        <select id="ddGolongan" name="ddGolongan">
                                            <option value="0">Pilih Golongan</option>
                                            <?php foreach ($golongan as $ls): ?>
                                                <option value="<?php echo $ls->golongan; ?>"><?php echo $ls->golongan; ?> (<?php echo $ls->pangkat; ?>)</option>
                                            <?php endforeach; ?>
                                        </select> <span id="jqv_msg2"></span>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="input-control text" style="margin-top: 10px;">
                                <label>Unit Kerja</label>
                                <div class="input-control select">
                                    <select name="idunit" id="idunit" class="chosen-select">
                                        <option value="0">Pilih Unit Kerja</option>
                                        <?php foreach($listUnit as $c): ?>
                                            <option value="<?php echo $c->id_unit_kerja ?>"><?php echo $c->unit ?></option>
                                        <?php endforeach; ?>
                                        </select>
                                </div>
                            </div>
                            <div class="input-control text" style="margin-top: 10px;">
                                <label>Masa Kerja</label>
                                <input type="text" id="txtmasakerja" name="txtmasakerja" value="">
                            </div>
                            <div class="input-control text" style="margin-top: 10px;">
                                <label>Atasan Langsung</label>
                                <input type="text" id="txtatasan_lgsg" name="txtatasan_lgsg" value="">
                            </div>
                            <div class="input-control text" style="margin-top: 10px;">
                                <label>Pejabat Berwenang</label>
                                <input type="text" id="txtpejabat" name="txtpejabat" value="">
                            </div>

                            <button id="btnregister" name="new_register" type="submit" class="button success" style="height: 34px; margin-top: 20px;">
                                <span class="icon-floppy on-left"></span><strong>Simpan</strong></button>
                            <!-- </div> -->
                        </div>
                    </div>
                </div>

                <div class="span5">
                    <div class="panel">
                        <div class="panel-header">Data Pengajuan Cuti</div>
                        <div class="panel-content"></div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="<?php echo base_url()?>js/jquery/chosen.jquery.js"></script>
<script>
    $('.chosen-select').chosen();
</script>