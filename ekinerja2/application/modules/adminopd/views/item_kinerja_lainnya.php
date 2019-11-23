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
    function tab_item_lainnya_click(tab){
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

<div class="panel-content" data-role="panel"
     data-title-caption=""
     data-title-icon=""
     data-cls-title="bg-steel fg-white">

    <ul class="tabs-expand-md" data-role="tabs" style="font-size: small;font-weight: bold;" data-on-tab="tab_item_lainnya_click">
        <li id="tbInputItemLainnya" <?php echo($tab=='tbInputItemLainnya'?'class="active"':'') ?>><a href="#tab1">Formulir</a></li>
        <li id="tbListItemLainnya" <?php echo($tab=='tbListItemLainnya'?'class="active"':'') ?>><a href="#tab2">Daftar Item Lainnya</a></li>
    </ul>
    <div class="border bd-default no-border-top p-2">
        <div id="tab1">
            <?php
                if(isset($view_form)){
                    $this->load->view($view_form);
                }
            ?>
        </div>
        <div id="tab2">
            <?php
                if(isset($view_list)){
                    $this->load->view($view_list);
                }
            ?>
        </div>
    </div>
</div>