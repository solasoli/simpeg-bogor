<?php

require_once "/konek.php";
require_once "/library/format.php";

$format = new Format();
if(isset($_REQUEST['aksi'])){

  //echo $_REQUEST['aksi'];
  //echo $_REQUEST['golongan'];

  switch ($_REQUEST['aksi']) {
    case "DEL":
      $query = "delete from ijin_belajar_data where id_ijin_belajar_data = ".$_POST['id'];
      echo mysqli_query($mysqli,$query) ? 1 : $query;

      break;
    case "INS":
      $query = "insert into ijin_belajar_data (
                id_pegawai,
                pangkat_gol,
                jenjang_pendidikan,
                nama_sekolah,
                program_studi,
                nomor_akreditasi,
                tgl_akreditasi,
                nomor_ijin_belajar,
                tgl_ijin_belajar,
                perkiraan_tahun_lulus,
                keterangan)
                VALUES(
                  '".$_POST['idPegawai']."',
                  '".$_POST['golongan']."',
                  '".$_POST['jenjang']."',
                  '".$_POST['namaSekolah']."',
                  '".$_POST['programStudi']."',
                  '".$_POST['noAkreditasi']."',
                  '".$format->date_Ymd($_POST['tglAkreditasi'])."',
                  '".$_POST['nomorIzinBelajar']."',
                  '".$format->date_Ymd($_POST['tglIzinBelajar'])."',
                  '".$_POST['tahunLulus']."',
                  '".$_POST['keterangan']."'
                  )";

        echo mysqli_query($mysqli,$query) ? 1 : 0;
      break;
    case "GETBYID":
      $query = "select  IF(LENGTH(p.gelar_belakang) > 1,
                      CONCAT(IF(LENGTH(p.gelar_depan) > 1,
                                  CONCAT(p.gelar_depan, ' '),
                                  ''),
                              p.nama,
                              CONCAT(', ', p.gelar_belakang)),
                      CONCAT(IF(LENGTH(p.gelar_depan) > 1,
                                  CONCAT(p.gelar_depan, ' '),
                                  ''),
                              p.nama)) AS nama,  p.nip_baru, a.*

              from
              (select
                id_ijin_belajar_data,
                id_pegawai,
                pangkat_gol,
                jenjang_pendidikan,
                nama_sekolah,
                program_studi,
                nomor_akreditasi,
                DATE_FORMAT(tgl_akreditasi,'%d-%m-%Y') as tgl_akreditasi,
                nomor_ijin_belajar,
                DATE_FORMAT(tgl_ijin_belajar,'%d-%m-%Y') as tgl_ijin_belajar,
                perkiraan_tahun_lulus,
                keterangan
              from ijin_belajar_data) as a
              inner join pegawai p on a.id_pegawai = p.id_pegawai
              where a.id_ijin_belajar_data = '".$_REQUEST['id']."'";

          if($result = mysqli_query($mysqli,$query)){
            echo json_encode(mysqli_fetch_array($result));
          }else{
            echo mysqli_error();
          }
      break;
    case "UPD":
      $query = "update ijin_belajar_data set
                pangkat_gol = '".$_POST['golongan']."',
                jenjang_pendidikan = '".$_POST['jenjang']."',
                nama_sekolah = '".$_POST['namaSekolah']."',
                program_studi = '".$_POST['programStudi']."',
                nomor_akreditasi = '".$_POST['noAkreditasi']."',
                tgl_akreditasi = '".$format->date_Ymd($_POST['tglAkreditasi'])."',
                nomor_ijin_belajar =   '".$_POST['nomorIzinBelajar']."',
                tgl_ijin_belajar = '".$format->date_Ymd($_POST['tglIzinBelajar'])."',
                perkiraan_tahun_lulus  = '".$_POST['tahunLulus']."',
                keterangan = '".$_POST['keterangan']."'
                where id_ijin_belajar_data = '".$_POST['id']."'";

                echo mysqli_query($mysqli,$query) ? 1 : $query;
      break;
    default:
      # code...
      echo "default";
      break;
  }


}
