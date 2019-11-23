
<?php
    if (isset($data_unit_jadwal) and sizeof($data_unit_jadwal) > 0 and $data_unit_jadwal != ''){
        foreach ($data_unit_jadwal as $lsdata){
            echo "<style>
                #canvas_map_dialog_unit_$lsdata->id_ukjdwl_enc {
                    width: 100%;
                    height: 200px;
                    background-color: grey;
                    border: 1px solid grey;
                }
            </style>";
            echo $lsdata->nama_unit.' ('.$lsdata->tipe_lokasi.')<br>';
            echo '<div id="canvas_map_dialog_unit_'.$lsdata->id_ukjdwl_enc.'"></div>';
            echo "<script>lihatPetaJadwalKhusus($lsdata->in_lat,$lsdata->in_long,$lsdata->out_lat,$lsdata->out_long,'canvas_map_dialog_unit_$lsdata->id_ukjdwl_enc');</script>";
            echo '<br>';
        }
    }else{
        echo 'Data lokasi kerja tidak ditemukan';
    }
?>

