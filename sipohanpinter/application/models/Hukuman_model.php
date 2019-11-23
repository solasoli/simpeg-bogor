<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Hukuman_model extends CI_Model {

    function get_login($nip, $password){

      $sql = "select p.id_pegawai,
					TRIM(IF(LENGTH(p.gelar_belakang) > 1,
						CONCAT(p.gelar_depan,
								' ',
								p.nama,
								CONCAT(', ', p.gelar_belakang)),
						CONCAT(p.gelar_depan, ' ', p.nama))) AS nama, p.nip_baru,
					p.my_status,
					p.pangkat_gol,
					p.id_j,
					u.id_unit_kerja,
					u.nama_baru,
					g.pangkat,
                    u.id_unit_kerja,
					u.id_skpd,
                    ha.id_role

			   from pegawai p
               inner join hukuman_admin ha on ha.id_pegawai = p.id_pegawai
			   inner join current_lokasi_kerja c on c.id_pegawai = p.id_pegawai
			   inner join unit_kerja u on u.id_unit_kerja = c.id_unit_kerja
			   inner join golongan g on g.golongan = p.pangkat_gol
			   where
				(p.nip_baru = '".$nip."' )
				and password = '".$password."'";

        return $this->db->query($sql)->row();
    }

    function get_enum_values($table, $field )
    {
        $type = $this->db->query( "SHOW COLUMNS FROM {$table} WHERE Field = '{$field}'" )->row( 0 )->Type;
        preg_match("/^enum\(\'(.*)\'\)$/", $type, $matches);
        $enum = explode("','", $matches[1]);
        return $enum;
    }

    /* get nama namanya aja */
    function get_pelanggar(){
      $sql = "select  p.id_pegawai,
    					TRIM(IF(LENGTH(p.gelar_belakang) > 1,
    						CONCAT(p.gelar_depan,
    								' ',
    								p.nama,
    								CONCAT(', ', p.gelar_belakang)),
    						CONCAT(p.gelar_depan, ' ', p.nama))) AS nama, p.nip_baru,
                p.pangkat_gol,
                uk.nama_baru
              from hukuman hd
              inner join pegawai p on p.id_pegawai = hd.id_pegawai
              inner join current_lokasi_kerja clk on clk.id_pegawai = p.id_pegawai
              inner join unit_kerja uk on uk.id_unit_kerja = clk.id_unit_kerja
              group by p.id_pegawai
              order by hd.tmt DESC";

      return $this->db->query($sql)->result();
    }

    function get_pelanggar_by_id_pegawai($id_pegawai){
      $sql = "select  p.id_pegawai,
              TRIM(IF(LENGTH(p.gelar_belakang) > 1,
                CONCAT(p.gelar_depan,
                    ' ',
                    p.nama,
                    CONCAT(', ', p.gelar_belakang)),
                CONCAT(p.gelar_depan, ' ', p.nama))) AS nama, p.nip_baru,
                p.pangkat_gol,
                uk.nama_baru
              from hukuman hd
              inner join pegawai p on p.id_pegawai = hd.id_pegawai
              inner join current_lokasi_kerja clk on clk.id_pegawai = p.id_pegawai
              inner join unit_kerja uk on uk.id_unit_kerja = clk.id_unit_kerja
              where p.id_pegawai = ".$id_pegawai." order by hd.tmt DESC";

      return $this->db->query($sql)->result();
    }

    function get_pegawai_by_nip($nip){

      $sql = "select p.id_pegawai,
            TRIM(IF(LENGTH(p.gelar_belakang) > 1,
              CONCAT(p.gelar_depan,
                      ' ',
                      p.nama,
                      CONCAT(', ', p.gelar_belakang)),
              CONCAT(p.gelar_depan, ' ', p.nama))) AS nama, p.nip_baru as nip,
              p.pangkat_gol,
              p.pangkat_gol as golongan,
              gol.pangkat as pangkat,
              if(p.id_j is null,
                p.jabatan,
                j.jabatan
              ) as jabatan,
              uk.nama_baru,
              uk.id_unit_kerja
              from pegawai p
              inner join golongan gol on gol.golongan = p.pangkat_gol
              inner join current_lokasi_kerja clk on clk.id_pegawai = p.id_pegawai
              inner join unit_kerja uk on uk.id_unit_kerja = clk.id_unit_kerja
              left join jabatan j on j.id_j = p.id_j
              where p.nip_baru = ".$nip;

      return $this->db->query($sql)->row();
    }

    /* proses pemeriksaan */
    function get_pemeriksaan(){

    }


}
