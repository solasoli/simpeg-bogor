<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<script src="<?php echo base_url()?>assets/jquery/dist/jquery.validate.js"></script>
<style>
    .errors {
        color: red;
    };
</style>

<script>
    var click = <?php echo $isclicked;?>;
    function tab_kinerja_click(tab){
        var link = '<?php echo $curr_addr;?>';
        if(click==true){
            click = false;
        }else{
            var url = '<?php echo $this->ekinerja->const_http; ?>://' + link + '?click=true&tab=' + tab[0].id;
            console.log(tab[0].id);
            console.log(url);
            location.href = '<?php echo $this->ekinerja->const_http; ?>://' + link + '?click=true&tab=' + tab[0].id;
        }
    }
</script>

<ul class="tabs-expand-md" data-role="tabs" style="font-size: small;font-weight: bold;" data-on-tab="tab_kinerja_click">
    <li id="tbFormAktifitas" style="color: darkblue;" <?php echo ($tab=='tbFormAktifitas'?'class="active"':'')?>><a href="#_target_1">Input Aktifitas Kegiatan</a></li>
    <li id="tbDaftarAktifitas" style="color: darkblue;" <?php echo ($tab=='tbDaftarAktifitas'?'class="active"':'')?>><a href="#_target_2">Daftar Aktifitas Bulan Ini</a></li>
    <li id="tbDaftarLaporan" style="color: darkblue;" <?php echo ($tab=='tbDaftarLaporan'?'class="active"':'')?>><a href="#_target_3">Daftar Laporan Per Periode</a></li>
</ul>
<div class="border bd-default no-border-top p-2">
    <div id="_target_1">
        <?php
            if(isset($view_form)){
                $this->load->view($view_form);
            }
        ?>
    </div>
    <div id="_target_2">
        <?php
            if(isset($view_list)){
                $this->load->view($view_list);
            }
        ?>
    </div>
    <div id="_target_3">
        <?php
            if(isset($view_list_kinerja)){
                $this->load->view($view_list_kinerja);
            }
        ?>
    </div>
</div>