<?php
include("../../konek.php");
include('../../library/format.php');

$format = new Format();
//echo $_POST['jenjang_jafung'];


$jenjang = $_POST['jenjang'];
$id_pegawai = $_POST['id_pegawai'];
$id_jfu = $_POST['id_jfu'];
$nama_pelaksana = $_POST['nama_pelaksana'];
$kode_jabatan = $_POST['kode_jabatan'];
$nosk = $_POST['no_sk'];
$tgl_sk = $_POST['tgl_sk'];
$tmt_jfu = $_POST['tmt_jfu'];

//echo base_url();

if($jenjang == 1){
// 1 = pelaksana
//echo "test";
//print_r($_POST);

$query_insert_sk = ("insert into sk (id_pegawai,id_kategori_sk,no_sk,tgl_sk,pemberi_sk,pengesah_sk,keterangan,tmt, gol, mk_tahun, mk_bulan)

values ($id_pegawai,52,'".$nosk."', '".$format->date_Ymd($tgl_sk)."','-','-','-','".$format->date_Ymd($tmt_jfu)."','-',0,0)");

mysqli_query($mysqli, $query_insert_sk);
$idsk = mysqli_insert_id($mysqli);



$q = ("insert into jfu_pegawai(id_pegawai, id_jfu, kode_jabatan,id_sk, jabatan, tmt, keterangan)
          values ($id_pegawai, $id_jfu,'".$kode_jabatan."','".$idsk."', '".$nama_pelaksana."','".$format->date_Ymd($tmt_jfu)."','')");

if(mysqli_query($mysqli, $q)){
  echo "1";

}else{
  echo $q;
}
}else if($jenjang == 2){
  //2 = JFT
  //print_r($_POST);exit;
  $query_insert_sk = ("insert into sk (id_pegawai,id_kategori_sk,no_sk,tgl_sk,pemberi_sk,pengesah_sk,keterangan,tmt, gol, mk_tahun, mk_bulan)
  values ($id_pegawai,23,'".$nosk."', '".$format->date_Ymd($tgl_sk)."','-','-','-','".$format->date_Ymd($tmt_jfu)."','-',0,0)");

  mysqli_query($mysqli, $query_insert_sk);
  $idsk = mysqli_insert_id($mysqli);

  //$q = ("insert into jafung_pegawai(id_pegawai, id_jafung, id_sk, id_unit_kerja, angka_kredit_utama, angka_kredit_penunjang, pangkat_gol, jabatan, id_j_bos, tmt)
  //          values ($id_pegawai, ".trim($_POST['jenjang_jafung'])."  , '".$idsk."','0', '0','0','','','0','".$format->date_Ymd($tmt_jfu)."')");

$q = "insert into jafung_pegawai(id_pegawai, id_jafung, id_sk, id_unit_kerja, angka_kredit_utama, angka_kredit_penunjang, pangkat_gol, jabatan, id_j_bos, tmt)
        select $id_pegawai, ".trim($_POST['jenjang_jafung']).", '".$idsk."','0', '0','0','',concat(jafung.nama_jafung,' ',jafung.jenjang_jabatan),'0','".$format->date_Ymd($tmt_jfu)."'
        from jafung where jafung.id_jafung = ".trim($_POST['jenjang_jafung']);

  if(mysqli_query($mysqli, $q)){
    echo "1";

  }else{
    echo $q." ".$_POST['jenjang_jafung'];
  }


}
