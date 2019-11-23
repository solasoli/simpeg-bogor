<!-- EasyAutoComplete -->
<link rel="stylesheet" href="<?php echo base_url('assets/EasyAutocomplete-1.3.5/easy-autocomplete.css'); ?>" >
<script src="<?php echo base_url()?>assets/jquery/dist/jquery.validate.js"></script>
<script type="text/javascript" src="<?php echo base_url('assets/EasyAutocomplete-1.3.5/jquery.easy-autocomplete.js'); ?>"></script>
<style>
    .errors {
        color: red;
    };

</style>

<script>
    var click = <?php echo $isclicked;?>;
    function tab_jadwal_click(tab){
        var link = '<?php echo $curr_addr;?>';
        if(click==true){
            click = false;
        }else{
            var url = 'http://' + link + '?click=true&tab=' + tab[0].id;
            console.log(tab[0].id);
            console.log(url);
            location.href = 'http://' + link + '?click=true&tab=' + tab[0].id;
        }
    }
</script>

<div class="panel-content" data-role="panel"
     data-title-caption=""
     data-title-icon=""
     data-cls-title="bg-steel fg-white">

    <ul class="tabs-expand-md" data-role="tabs" style="font-size: small;font-weight: bold;" data-on-tab="tab_jadwal_click">
        <li id="tbInputAbsensiKhusus" <?php echo($tab=='tbInputAbsensiKhusus'?'class="active"':'') ?>><a href="#tab1">Formulir</a></li>
        <li id="tbListAbsensiKhusus" <?php echo($tab=='tbListAbsensiKhusus'?'class="active"':'') ?>><a href="#tab2">Daftar Absensi Khusus</a></li>
    </ul>

    <div class="border bd-default no-border-top p-2">
        <div id="tab1"></div>
        <div id="tab2"></div>
    </div>
</div>