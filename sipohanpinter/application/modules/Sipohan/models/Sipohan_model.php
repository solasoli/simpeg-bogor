<?php

class Sipohan_model extends CI_Model{

  public function getPengesah($id_pegawai){
      $sql = "SELECT e.*, p6.pangkat_gol as pangkat_gol_plt,
          (CASE WHEN e.last_gol = p6.pangkat_gol THEN /* jika gol pegawai sama dengan gol plt maka naikkan lagi pengesahnya */
            (CASE WHEN e.eselon_pengesah = 'IIIB' THEN (SELECT id_pegawai FROM pegawai WHERE id_j = 3120) ELSE
              (CASE WHEN e.eselon_pengesah = 'IIIA' THEN (SELECT id_pegawai FROM pegawai WHERE id_j = 3082) ELSE
                (CASE WHEN e.eselon_pengesah = 'IIB' THEN (SELECT id_pegawai FROM pegawai WHERE id_j = 4376) ELSE
                  (CASE WHEN e.eselon_pengesah = 'IIA' THEN (SELECT id_pegawai FROM pegawai WHERE id_j = 4375) END) END) END) END) ELSE NULL END) AS id_pegawai_pengesah_up
          FROM
            (SELECT d.*, jp.id_pegawai as id_pegawai_plt FROM
              (SELECT c.*, CASE WHEN p5.id_j IS NULL THEN c.id_j_pengesah ELSE p5.id_j END AS id_j, CASE WHEN p5.id_j IS NULL THEN (SELECT eselon FROM jabatan WHERE id_j = c.id_j_pengesah) ELSE j2.eselon END as eselon_pengesah FROM
                (SELECT b.*, j.eselon,
                   CASE WHEN (b.last_gol='I/a' OR b.last_gol='I/b' OR b.last_gol='I/c' OR b.last_gol='I/d'
                              OR b.last_gol='II/a' OR b.last_gol='II/b' OR b.last_gol='II/c' OR b.last_gol='II/d') AND (b.last_idj_pemohon IS NULL)
                     THEN (SELECT p1.id_pegawai FROM pegawai p1 WHERE p1.id_j = 3190)
                   ELSE (CASE WHEN (b.last_gol='III/a' OR b.last_gol='III/b' OR b.last_gol='III/c' OR b.last_gol='III/d'
                                     /*OR b.last_gol='IV/a' OR b.last_gol='IV/b' OR b.last_gol='IV/c' OR b.last_gol='IV/d'*/) AND (b.last_idj_pemohon IS NULL OR j.eselon='IVA' OR j.eselon='IVB')
                     THEN (SELECT p2.id_pegawai FROM pegawai p2 WHERE p2.id_j = 3120)
                         ELSE (CASE WHEN (/*b.last_gol='III/a' OR b.last_gol='III/b' OR b.last_gol='III/c' OR b.last_gol='III/d'
                            OR */(b.last_gol='IV/a' OR b.last_gol='IV/b' OR b.last_gol='IV/c' OR b.last_gol='IV/d') AND (b.last_idj_pemohon IS NULL OR j.eselon='IVA' OR j.eselon='IVB')) OR
                                         j.eselon='IIIA' OR j.eselon='IIIB'
                           THEN (SELECT p3.id_pegawai FROM pegawai p3 WHERE p3.id_j = 3082)
                               ELSE (CASE WHEN (b.last_gol='IV/a' OR b.last_gol='IV/b' OR b.last_gol='IV/c' OR b.last_gol='IV/d') AND (j.eselon='IIA' OR j.eselon='IIB')
                                 THEN (SELECT p4.id_pegawai FROM pegawai p4 WHERE p4.id_j = 4376) ELSE NULL END) END) END)
                   END as id_pegawai_pengesah,
                   CASE WHEN (b.last_gol='I/a' OR b.last_gol='I/b' OR b.last_gol='I/c' OR b.last_gol='I/d'
                              OR b.last_gol='II/a' OR b.last_gol='II/b' OR b.last_gol='II/c' OR b.last_gol='II/d') AND (b.last_idj_pemohon IS NULL)
                     THEN 3190
                   ELSE (CASE WHEN (b.last_gol='III/a' OR b.last_gol='III/b' OR b.last_gol='III/c' OR b.last_gol='III/d'
                                     /*OR b.last_gol='IV/a' OR b.last_gol='IV/b' OR b.last_gol='IV/c' OR b.last_gol='IV/d'*/) AND (b.last_idj_pemohon IS NULL OR j.eselon='IVA' OR j.eselon='IVB')
                     THEN 3120
                         ELSE (CASE WHEN (/*b.last_gol='III/a' OR b.last_gol='III/b' OR b.last_gol='III/c' OR b.last_gol='III/d'
                            OR */(b.last_gol='IV/a' OR b.last_gol='IV/b' OR b.last_gol='IV/c' OR b.last_gol='IV/d') AND (b.last_idj_pemohon IS NULL OR j.eselon='IVA' OR j.eselon='IVB')) OR
                                         j.eselon='IIIA' OR j.eselon='IIIB'
                           THEN 3082
                               ELSE (CASE WHEN (b.last_gol='IV/a' OR b.last_gol='IV/b' OR b.last_gol='IV/c' OR b.last_gol='IV/d') AND (j.eselon='IIA' OR j.eselon='IIB')
                                 THEN 4376 ELSE NULL END) END) END)
                   END as id_j_pengesah
                 FROM (SELECT a.*, p.id_j AS last_idj_pemohon FROM
                   (SELECT  peg.id_pegawai, peg.pangkat_gol as last_gol
                    FROM pegawai peg
                    WHERE peg.id_pegawai = $id_pegawai) a LEFT JOIN pegawai p
                     ON a.id_pegawai = p.id_pegawai) b LEFT JOIN jabatan j
                     ON b.last_idj_pemohon = j.id_j) c LEFT JOIN pegawai p5 ON c.id_pegawai_pengesah = p5.id_pegawai
                LEFT JOIN jabatan j2 ON p5.id_j = j2.id_j) d
              LEFT JOIN jabatan_plt jp ON d.id_j = jp.id_j) e LEFT JOIN pegawai p6 ON e.id_pegawai_plt = p6.id_pegawai";

      $query = $this->db->query($sql);
      foreach ($query->result() as $row){
          if($row->id_pegawai_plt==''){
              $idp_pengesah = $row->id_pegawai_pengesah;
          }else{
              if($row->id_pegawai_pengesah_up==''){
                  $idp_pengesah = $row->id_pegawai_plt;
              }else{
                  $idp_pengesah = $row->id_pegawai_pengesah_up;
              }
          }
      }
      $sql = " SELECT a.*, jp.id_pegawai as id_pegawai_plt FROM
          (SELECT p.id_pegawai,
            p.nip_baru,
            CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
    nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(', ',p.gelar_belakang) END) AS nama,
    j.jabatan, j.eselon, g.golongan, g.pangkat
          FROM pegawai p LEFT JOIN jabatan j ON p.id_j = j.id_j
          LEFT JOIN golongan g ON p.pangkat_gol = g.golongan
          WHERE p.id_pegawai = $idp_pengesah) a LEFT JOIN jabatan_plt jp ON a.id_pegawai = jp.id_pegawai";
      $query = $this->db->query($sql);
      return $query->row();
  }

  function get_kepala_peg($id_pegawai){

    $sql = "
            select TRIM(IF(LENGTH(p.gelar_belakang) > 1,
          CONCAT(p.gelar_depan,
                  ' ',
                  p.nama,
                  CONCAT(', ', p.gelar_belakang)),
          CONCAT(p.gelar_depan, ' ', p.nama))) AS nama, p.nip_baru as nip
          from pegawai p
          inner join
          (select j.jabatan, j.id_j, min(j.eselon), a.*
          from jabatan j
          inner join
          (select pegawai.id_pegawai, uk.id_skpd, uk.id_unit_kerja
          from pegawai
          inner join current_lokasi_kerja clk on clk.id_pegawai = pegawai.id_pegawai
          inner join unit_kerja uk on uk.id_unit_kerja = clk.id_unit_kerja
          where pegawai.id_pegawai = ".$id_pegawai.") a
          on a.id_unit_kerja = j.id_unit_kerja ) b on b.id_j = p.id_j";

      return $this->db->query($sql)->row();


  }

  function get_pegawai($id_pegawai){

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
            ) as jabatan
            from pegawai p
            inner join golongan gol on gol.golongan = p.pangkat_gol
            left join jabatan j on j.id_j = p.id_j
            where p.id_pegawai = ".$id_pegawai;

    return $this->db->query($sql)->row();
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
            uk.nama_baru
            from pegawai p
            inner join golongan gol on gol.golongan = p.pangkat_gol
            inner join current_lokasi_kerja clk on clk.id_pegawai = p.id_pegawai
            inner join unit_kerja uk on uk.id_unit_kerja = clk.id_unit_kerja
            left join jabatan j on j.id_j = p.id_j
            where p.nip_baru = ".$nip;

    return $this->db->query($sql)->row();
  }

  function get_sk_hukdis($id_pegawai){

		$query = "select * from sk where id_pegawai = ".$id_pegawai." and id_kategori_sk in (20,21,22,33,36,38,39,40,41,42,43,44,45,46,47,48)";
		return $this->db->query($query)->result();
	}


  function get_jenis($id_jenis){

  return $this->db->get_where('jenis_hukuman',array('id_jenis_hukuman'=>$id_jenis))->row();
  }
}
