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
    array( 'db' => 'tgl_pensiun_dini',     'dt' => 3 ),
    array( 'db' => 'nama_baru',     'dt' => 4 ),
    array( 'db' => 'alamat',     'dt' => 5 ),
    array( 'db' => 'jabatan',     'dt' => 6 )
    /*,
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

require( 'assets/DataTables/ssp_pensiun.class.php' );

echo json_encode(
    SSP::daftar_pensiun( $_GET, $sql_details, $table, $primaryKey, $columns, NULL, "")
);



?>
