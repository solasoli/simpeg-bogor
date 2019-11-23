<style>
    #map_canvas_unit_sekunder {
        width: 100%;
        height: 400px;
        background-color: grey;
        border: 1px solid grey;
    }
</style>
<?php if (isset($unit_sekunder) and sizeof($unit_sekunder) > 0 and $unit_sekunder != ''){ ?>
    <?php foreach ($unit_sekunder as $lsdata): ?>
        <?php
        if($tipeUnit=='sekunder'){
            echo '<small><strong>Informasi Lokasi Sekunder Terpilih</strong><br>';
            echo '<span style="color: saddlebrown; font-weight: bold">'.$lsdata->nama.'</span><br>';
            echo 'Alamat: '.$lsdata->alamat.'<br>';
            echo 'Unit Utama: '.$lsdata->unit_utama.($lsdata->induk==''?'':' Induk Sekunder: '.$lsdata->induk).'<br>';
            echo 'Tipe Wilayah: '.$lsdata->tipe_wilayah.'<br>';
            echo 'Oleh: '.$lsdata->updater.' ('.$lsdata->nip_baru.')'.'<br>'.$lsdata->tgl_input2;
            echo '</small>';
        }else{
            echo '<small><strong>Informasi Lokasi Utama Terpilih</strong><br>';
            echo '<span style="color: saddlebrown; font-weight: bold">'.$lsdata->nama.'</span><br>';
            echo 'Alamat: '.$lsdata->alamat.'<br>';
            if($lsdata->id_unit_kerja!=$lsdata->id_skpd){
                echo '<br>OPD :<br>';
                echo $lsdata->opd;
            }
        }

            $point_lat_sekunder = $lsdata->in_lat;
            $point_long_sekunder = $lsdata->in_long;
            $point_lat_sekunder_out = $lsdata->out_lat;
            $point_long_sekunder_out = $lsdata->out_long;
        ?>
    <?php endforeach; ?>
    <div id="map_canvas_unit_sekunder"></div>
    <script>
        var center_unit_sekunder = {lat: <?php echo $point_lat_sekunder;?>, lng: <?php echo $point_long_sekunder;?>};
        var map_unit_sekunder = new google.maps.Map(
            document.getElementById('map_canvas_unit_sekunder'), {zoom: 17, center: center_unit_sekunder,});
        var image_in = 'http://maps.google.com/mapfiles/ms/icons/green-dot.png';
        var marker_unit_sekunder_in = new google.maps.Marker({
            position: center_unit_sekunder,
            map: map_unit_sekunder,
            icon: image_in
        });
        var image_out = 'http://maps.google.com/mapfiles/ms/icons/red-dot.png';
        var center_unit_sekunder_out = {lat: <?php echo $point_lat_sekunder_out;?>, lng: <?php echo $point_long_sekunder_out;?>};
        var marker_unit_sekunder_out = new google.maps.Marker({
            position: center_unit_sekunder_out,
            map: map_unit_sekunder,
            icon: image_out
        });
    </script>
<?php }else{
    echo 'Data tidak ditemukan';
} ?>