<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<script src="<?php echo base_url()?>js/jquery/jquery.validate.js"></script>
<script>
    $(function(){
        $("#frmPelantikanBaru").validate({
            rules: {
                tglpelantikan: {
                    required: true
                },
                nama_draft:{
                    required: true
                },
                pass:{
                    required: true
                }
            },
            messages: {
                tglpelantikan: {
                    required: "Tgl. Pelantikan harus diisi"
                },
                nama_draft: {
                    required: "Nama draft harus diisi"
                },
                pass: {
                    required: "Password harus diisi"
                }
            },
            errorPlacement: function(error, element) {
                switch (element.attr("name")) {
                    default:
                        error.insertAfter(element);
                }
            },
            submitHandler: function(form) {
                form.submit();
            }

        });
    });
</script>
<div class="container">
    <h2>Draft Pelantikan Baru</h2>
    <?php //echo form_open(); ?>
    <form id="frmPelantikanBaru" novalidate="novalidate" action="<?php echo base_url()?>jabatan_struktural/draft_pelantikan_baru" method="post" accept-charset="utf-8">
        <div class="grid">
            <div class="row">
                <div class="span5">
                    <div class="input-control text" id="datepicTglpelantikan" data-week-start="1">
                        <label>Tanggal Pelantikan</label>
                        <input type="text" id="tglpelantikan" name="tglpelantikan" value="">
                    </div>
                    <div class="input-control text" style="margin-top: 10px;">
                        <label>Nama Draft</label>
                        <input id="nama_draft" name="nama_draft" type="text" />
                    </div>
                    <div class="input-control text" style="margin-top: 10px;">
                        <label>Password</label>
                        <input type="password" name="pass" id="pass"/>
                    </div>
                    <input id="btnSimpan" name="btnSimpan" type="submit" value="Simpan"
                           class="submit bg-green fg-white" style="margin-top: 20px;">

                    <a href="<?php echo base_url('jabatan_struktural/draft_pelantikan'); ?>"
                       class="button bg-grayDark fg-white" target="_blank" style="margin-top: 20px;">Batalkan</a>
                    <?php //echo anchor('jabatan_struktural/draft_pelantikan', 'Batalkan'); ?>
                </div>
            </div>
        </div>
    </form>
    <?php //echo form_close(); ?>
</div>
<script type="text/javascript">
    $("input[name=nama_draft]").focus();

    $(function(){
        $("#datepicTglpelantikan").datepicker();
    });
</script>