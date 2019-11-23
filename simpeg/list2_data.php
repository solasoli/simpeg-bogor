<?php

/*
 * DataTables example server-side processing script.
 *
 * Please note that this script is intentionally extremely simply to show how
 * server-side processing can be implemented, and probably shouldn't be used as
 * the basis for a large complex system. It is suitable for simple use cases as
 * for learning.
 *
 * See http://datatables.net/usage/server-side for full details on the server-
 * side processing requirements of DataTables.
 *
 * @license MIT - http://datatables.net/license_mit
 */

/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * Easy set variables
 */

// DB table to use
$table = 'pegawai';

// Table's primary key
$primaryKey = 'pegawai.id_pegawai';

// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$columns = array(
    array( 'db' => 'nama', 'dt' => 0,
              'formatter' => function ($d, $row){
                if($row['status_aktif'] == 'Aktif' || $row['status_aktif'] == 'Aktif Bekerja'){
                    return '<span>'.$d.'</span>';
                  }else{
                    return $d.'</br>'.'<span class="text text-danger">('.$row['status_aktif'].')</span>';
                  }

                }),
    array( 'db' => 'nip_baru',  'dt' => 1 ),
    array( 'db' => 'pangkat_gol',   'dt' => 2 ),
    array( 'db' => 'jabatan',     'dt' => 3 ),
    array( 'db' => 'id_pegawai',     'dt' => 4,
            'searching' => false,
            'formatter' => function( $d, $row ) {
              $buttons='<div class="btn-group">
                         <button class="btn btn-default" type="button">Aksi</button>
                         <button class="btn btn-default dropdown-toggle" data-toggle="dropdown" type="button">
                         <span class="caret"></span>
                         <span class="sr-only">Toggle Dropdown</span>
                         </button>
                         <ul class="dropdown-menu" role="menu">
                             <li>
                                 <a href="index3.php?x=box.php&od='.$d.'"><i class="fa fa-check-circle fa-lg" title="Assess" alt="assess"></i> Detail Profil</a>
                             </li>
                             <li>
                                     <a href="#" onClick="aktifkan('.$d.')" title="Assess" alt="assess"></i> Aktifkan</a>
                                 </li>
                              <!--<li>
                               <a href="index3.php?x=at2.php&od='.$d.'"><i class="fa fa-check-circle fa-lg" title="Assess" alt="assess"></i> Alih Tugas</a>
                            </li>-->'.($row[4]==''?'':

                            '<li><a href="index3.php?x=list2.php&de='.$d.'"><i class="fa fa-check-circle fa-lg" title="Assess" alt="assess"></i> Hapus Pengajuan KP</a></li>
							             ');

                            if(2==1):
                             $buttons.='<li>
                                 <a href="delete-experience.php?id='.$row[0].'&c='.$row[4].'" onclick="return confirmDelete;">
                 <i class="fa fa-trash" alt="Delete" title="Delete Experience" ></i> Delete</a>
                             </li>';
                             endif;
                         $buttons.='</ul>
                     </div>';
               return $buttons;
            },

          )/*,
    array( 'db' => 'status_kp',     'dt' => 5,*/
);

// SQL server connection information
$sql_details = array(
    //'user' => 'kominfo-simpeg',
    //'pass' => 'Madangkara2017',
    //'db'   => 'simpeg',
    //'host' => '127.0.0.1:3307'
    'user' => 'simpeg',
    'pass' => 'Madangkara2017',
    'db'   => 'simpeg',
    'host' => 'simpeg.db.kotabogor.net'
);


/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * If you just want to use the basic configuration for DataTables with PHP
 * server-side, there is no need to edit below this line.
 */

require( 'assets/DataTables/ssp.class.php' );

echo json_encode(
    SSP::daftar_pegawai( $_GET, $sql_details, $table, $primaryKey, $columns, NULL, "", $_GET['id_skpd'])
);



?>
