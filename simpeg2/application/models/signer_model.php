<?php

class Signer_model extends CI_Model{

  public function get_by_id($id){
    $sql = "select * from tte_inbox where id = ".$id;
    return $this->db->query($sql)->row();
  }

  public function get_kategori_berkas(){
    return $this->db->query('select * from kat_berkas where tte = 1')->result();
  }

 public function get_penandatangan_berkas(){
   return $this->db->query('select tte_penandatangan.* from tte_penandatangan order by eselon DESC')->result();
 }

 public function get_idp_penandatangan($idj){

   $sql = "select * from pegawai where id_j = ".$idj;
   return $this->db->query($sql)->row();
 }


 public function get_inbox($idj){


   $sql = "select * from tte_inbox where (idj_penandatangan=".$idj." or idj_pemaraf1=".$idj." or idj_pemaraf2=".$idj." or idj_pemaraf3=".$idj." or idj_pemaraf4=".$idj.") and (idp_penandatangan is null )";

   return $this->db->query($sql)->result();
 }


 public function get_inbox_pengolah($idp_pengolah){

   $sql = "select * from tte_inbox where idp_pengolah=$idp_pengolah";

   return $this->db->query($sql)->result();
 }

 public function get_signed($idj){
   $sql = "select * from tte_inbox where idp_penandatangan is not null order by id DESC";

   return $this->db->query($sql)->result();
 }

 public function get_should_paraf($id){

 }

 public function get_kat_berkas($id_kat_berkas){
   $sql = "select * from kat_berkas where id_kat_berkas = ".$id_kat_berkas;
   return $this->db->query($sql)->row();
 }

 public function get_setting($id_pegawai){
   $sql = "select * from tte_setting where id_pegawai = ".$id_pegawai;
   return $this->db->query($sql)->row();
 }

 public function delete_inbox($id_tte){


   $sql = "delete from tte_inbox where id = ".$id_tte;

   return $this->db->query($sql);
 }


}
