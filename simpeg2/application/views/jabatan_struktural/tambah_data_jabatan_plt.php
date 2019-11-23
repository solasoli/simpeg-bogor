<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<div class="container">
    <div class="grid">
        <div class="row">
            <span style="margin-top: 50px;"><strong>TAMBAH DATA BARU JABATAN <?php echo $judul; ?></strong></span>
        </div>
        <div class="row">
            <form action="" method="post" id="frmTambahJabatanPltPlh" novalidate="novalidate" enctype="multipart/form-data">
                <input id="submitok" name="submitok" type="hidden" value="<?php echo $judul; ?>">
                <div class="span5">
                    <div class="panel">
                        <div class="panel-header">Informasi Pegawai</div>
                        <div class="panel-content">
                            <div class="input-control text">
                                <input id="nama_pegawai_plt_plh"type="text" value="" placeholder="Cari Nama / NIP"/>
                                <button type="button" class="btn-search"></button>
                            </div>
                            <div id="divInfoPegawai">
                                <input type="hidden" id="txtIdPegawai" name="txtIdPegawai" value="">
                                <input type="hidden" id="txtLastGol" name="txtLastGol" value="">
                                <input type="hidden" id="txtLastJenjab" name="txtLastJenjab" value="">
                                <input type="hidden" id="txtLastIdj" name="txtLastIdj" value="">
                                <input type="hidden" id="txtLastIdUnit" name="txtLastIdUnit" value="">
                                <input type="hidden" id="txtLastStsJab" name="txtLastStsJab" value="">
                            </div>
                        </div>
                    </div>
                    <div class="panel" style="margin-top: 20px;">
                        <div class="panel-header">Berkas SK <?php echo $judul; ?></div>
                        <div class="panel-content">
                            <input type="file" id="fileSkPlt" name="fileSkPlt" />
                        </div>
                    </div>
                </div>
                <div class="span5">
                    <div class="panel">
                        <div class="panel-header"><?php echo $judulPltPlh; ?></div>
                        <div class="panel-content">
                            <div class="input-control text">
                                <input id="nama_jabatan"type="text" value="" placeholder="Cari Jabatan sebagai PLT"/>
                                <button type="button" class="btn-search"></button>
                            </div>
                            <div class="input-control text">
                                <label>Nomor SK</label>
                                <input id="txtNoSk" name="txtNoSk" type="text" value="" required>
                            </div>
                            <div class="input-control text" id="datepicTglSk" data-week-start="1" style="margin-top: 8px;">
                                <label>Tanggal SK</label>
                                <input type="text" id="tgl_sk" name="tgl_sk" value="">
                            </div>
                            <div class="input-control text" id="datepicTmtMulai" data-week-start="1" style="margin-top: 8px;">
                                <label>TMT Mulai</label>
                                <input type="text" id="tmt_mulai" name="tmt_mulai" value="">
                            </div>
                            <div class="input-control text" id="datepicTmtSelesai" data-week-start="1" style="margin-top: 8px;">
                                <label>TMT Selesai</label>
                                <input type="text" id="tmt_selesai" name="tmt_selesai" value="">
                            </div>
                            <div class="input-control text" style="margin-top: 8px;">
                                <label>Status Aktif</label>
                                <div class="input-control select" style="width: 100%;">
                                    <select id="ddStatusAktif" name="ddStatusAktif">
                                        <option value="0">Pilih Status</option>
                                        <option value="1">PLT masih aktif</option>
                                        <option value="2">PLT sudah non aktif</option>
                                    </select> <span id="jqv_msg"></span>
                                </div>
                            </div>
                            <button id="btnregister" name="new_register" type="submit" class="button success" style="height: 34px; margin-top: 20px;">
                                <span class="icon-floppy on-left"></span><strong>Simpan</strong></button>
                            <button id="btnKembali" name="btnKembali" type="button" class="button back-button" style="height: 34px; margin-top: 20px;">
                                <span class="icon-arrow-left on-left"></span><strong>Kembali</strong></button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">

    $( "#nama_pengganti" ).autocomplete({
        minLength: 3,
        source: function( request, response ) {
            $.ajax({
                url: "<?php echo base_url()."index.php/jabatan_struktural/json_find_pegawai" ?>",
                dataType: "json",
                data: {
                    q: request.term,
                    type: 'autocomplete'
                },
                success: function( data ) {
                    response( data );
                },
                error: function(a,b,c){
                    console.log(b);
                    console.log(a.responseText);
                }
            });
        },
        focus: function( event, ui ) {
            return false;
        },
        select: function( event, ui ) {

        }
    }).autocomplete( "instance" )._renderItem = function( ul, item ) {
        return $( "<li>" )
            .append( "<img src='http://103.14.229.15/simpeg/foto/"+ item.value +".jpg' width='50' /><a><strong>" + item.label + "</strong> ("+ item.gol +")<br>" + item.uker + "</a>" )
            .appendTo( ul );
    };

    $(function(){
        $("#datepicTglSk").datepicker();
        $("#datepicTmtMulai").datepicker();
        $("#datepicTmtSelesai").datepicker();
    });

    $("#btnKembali").click(function(){
        <?php if($judul=='PLT'):; ?>
            location.href = "<?php echo base_url()."jabatan_struktural/list_jabatan_plt/" ?>";
        <?php else: ?>
            location.href = "<?php echo base_url()."jabatan_struktural/list_jabatan_plh/" ?>";
        <?php endif; ?>
    });
</script>