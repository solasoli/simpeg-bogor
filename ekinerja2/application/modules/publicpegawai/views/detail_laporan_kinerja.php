
<script>
    var click = <?php echo $isclicked;?>;
    function tab_click(tab){
        var link = '<?php echo $curr_addr;?>'
        if(click==true){
            click = false;
        }else{
            location.href = '<?php echo $this->ekinerja->const_http; ?>://' + link + '&click=true&tab=' + tab[0].id;
        }
    }

</script>

<div class="panel-content" data-role="panel"
     data-title-caption=""
     data-title-icon=""
     data-cls-title="bg-steel fg-white">

        <?php //echo $curr_addr;?>
        <ul class="tabs-expand-md" data-role="tabs" style="font-size: small;font-weight: bold;" data-on-tab="tab_click">
            <li id="tbRekap" style="color: darkblue;" <?php echo ($tab=='tbRekap'?'class="active"':'')?>><a href="#_target_1">Rekapitulasi</a></li>
            <li id="tbAktivitas" style="color: darkblue;" <?php echo ($tab=='tbAktivitas'?'class="active"':'')?>><a href="#_target_2">Aktivitas Kegiatan</a></li>
            <li id="tbAbsHadir" style="color: darkblue;" <?php echo ($tab=='tbAbsHadir'?'class="active"':'')?>><a href="#_target_3">Absensi Kehadiran dan Apel</a></li>
            <li id="tbItemLain" style="color: darkblue;" <?php echo ($tab=='tbItemLain'?'class="active"':'')?>><a href="#_target_4">Item Kinerja Lainnya</a></li>
        </ul>
        <div class="border bd-default no-border-top p-2">
            <div id="_target_1">
                <?php
                    if(isset($view_detail_nilai)){
                        $this->load->view($view_detail_nilai);
                    }else{
                        if(isset($view_list_detail)){
                            $this->load->view($view_list_detail);
                        }
                    }
                ?>
            </div>
            <div id="_target_2">
                <?php
                    if(isset($view_list_aktifitas)){
                        $this->load->view($view_list_aktifitas);
                    }
                ?>
            </div>
            <div id="_target_3">
                <?php
                if(isset($view_list_absensi)){
                    $this->load->view($view_list_absensi);
                }
                ?>
            </div>
            <div id="_target_4">

            </div>
        </div>
</div>
