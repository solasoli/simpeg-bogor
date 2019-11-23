<?php

require_once("konek.php");

$nama_jafung = $_POST['nama_jafung'];

$qJafung = "select * from jafung where nama_jafung = '".$nama_jafung."'";

$result = mysqli_query($mysqli,$qJafung);
if($result){

	while($hasil = mysqli_fetch_object($result)){

    $test[] = array('id_jafung' => $hasil->id_jafung,
                    'nama_jafung'=>$hasil->nama_jafung,
                    'jenjang_jabatan'=>$hasil->jenjang_jabatan,
										'pangkat_gol'=>$hasil->pangkat_gol
                    );
  }

  echo json_encode($test);

}else{
	echo "false ".$qJafung;//json_encode(array('id'=>0));
}
