
<script>
    var click = <?php echo $isclicked;?>;
    function tab_click(tab){
        var link = '<?php echo $curr_addr;?>'
        if(click==true){
            click = false;
        }else{
            location.href = '<?php echo $this->public->const_http; ?>://' + link + '?click=true&tab=' + tab[0].id;
        }
    }

</script>


    <?php //echo $curr_addr;?>
    <ul class="tabs-expand-md" data-role="tabs" style="font-size: small;font-weight: bold;" data-on-tab="tab_click">
        <li id="tbStatBulanan" style="color: darkblue;" <?php echo ($tab=='tbStatBulanan'?'class="active"':'')?>><a href="#_target_1">Rekap Bulanan</a></li>
        <li id="tbStatHarian" style="color: darkblue;" <?php echo ($tab=='tbStatHarian'?'class="active"':'')?>><a href="#_target_2">Rekap Harian</a></li>
    </ul>
    <div class="border bd-default no-border-top p-2">
        <div id="_target_1">
            <?php
            if(isset($view_stat_bulanan)){
                $this->load->view($view_stat_bulanan);
            }
            ?>
        </div>
        <div id="_target_2">
            <?php
            if(isset($view_stat_harian)){
                $this->load->view($view_stat_harian);
            }
            ?>
        </div>
    </div>

