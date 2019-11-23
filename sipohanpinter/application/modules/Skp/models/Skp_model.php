<?php

class Skp_model extends CI_Model{



  function get_list_tahun($id_pegawai){

    $query = "select DISTINCT YEAR(periode_awal) as tahun
          from skp_header where id_pegawai = ".$id_pegawai." ORDER BY tahun DESC";
    return $this->db->query($query)->result();
  }

  function get_list_skp_by_tahun($tahun){

  }

  function get_skp_by_id($id_skp){

  }


}
