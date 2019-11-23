<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pendidikan_model extends CI_Model{
	
		
	public function __Construct(){
	
		parent::__Construct();
		
	}
	
	function get_stat(){
		$query = "select pt.tingkat_pendidikan, count(*) as jumlah
					from pendidikan_terakhir pt
					inner join pegawai p on p.id_pegawai = pt.id_pegawai
					where p.flag_pensiun = 0
					group by tingkat_pendidikan
					order by level_p
					";
		return $this->db->query($query);
	}

    public function getPendidikanPerOPD($opd){
        $sql = "SELECT IF(kp.level_p IS NULL, '0', kp.level_p) AS level_p,
				IF(kp.nama_pendidikan IS NULL, 'Tingkat Pendidikan belum diketahui',
				kp.nama_pendidikan) AS tingkat_pendidikan, c.id_unit_kerja, c.nama_baru, c.jumlah
				FROM
				(SELECT p.level_p, b.id_unit_kerja, b.nama_baru,
				COUNT(p.id_pendidikan) AS jumlah FROM pendidikan p INNER JOIN
				(SELECT p.id_pegawai, a.id_unit_kerja, a.nama_baru,
				MAX(p.id_pendidikan) AS id_pendidikan FROM pendidikan p,
				(SELECT p.id_pegawai, uk.id_unit_kerja, uk.nama_baru, MIN(pend.level_p) AS level_p
				FROM pegawai p INNER JOIN pendidikan pend ON p.id_pegawai = pend.id_pegawai,
				current_lokasi_kerja clk, unit_kerja uk
				WHERE p.flag_pensiun = 0 AND pend.level_p < 7 AND
				p.id_pegawai = clk.id_pegawai AND
				clk.id_unit_kerja = uk.id_unit_kerja AND uk.id_skpd = $opd
				GROUP BY p.id_pegawai, uk.id_unit_kerja, uk.nama_baru) a
				WHERE p.id_pegawai = a.id_pegawai AND p.level_p = a.level_p
				GROUP BY p.id_pegawai, a.id_unit_kerja, a.nama_baru) b
				ON p.id_pendidikan = b.id_pendidikan
				GROUP BY p.level_p, b.id_unit_kerja, b.nama_baru) c LEFT JOIN kategori_pendidikan kp
				ON c.level_p = kp.level_p ORDER BY kp.level_p, c.nama_baru";
        return $this->db->query($sql);
    }

    public function getRekapPerBidangPendidikan(){
        $sql = "SELECT IF(bp.id IS NULL, '0', bp.id) AS id, IF(bp.bidang IS NULL, 'Bidang belum diketahui', bp.bidang) AS bidang, c.jumlah FROM
				(SELECT p.id_bidang, COUNT(p.id_pendidikan) AS jumlah FROM pendidikan p INNER JOIN
				(SELECT p.id_pegawai, MAX(p.id_pendidikan) AS id_pendidikan FROM pendidikan p,
				(SELECT p.id_pegawai, MIN(pend.level_p) AS level_p
				FROM pegawai p INNER JOIN pendidikan pend ON p.id_pegawai = pend.id_pegawai
				WHERE p.flag_pensiun = 0 AND pend.level_p < 7
				GROUP BY p.id_pegawai) a WHERE p.id_pegawai = a.id_pegawai AND p.level_p = a.level_p
				GROUP BY p.id_pegawai) b ON p.id_pendidikan = b.id_pendidikan
				GROUP BY p.id_bidang) c LEFT JOIN bidang_pendidikan bp
				ON c.id_bidang = bp.id ORDER BY bp.bidang";
        return $this->db->query($sql);
    }

    public function getRekapPerBidangPendidikanPerOPD($opd){
        $sql = "SELECT IF(bp.id IS NULL, '0', bp.id) AS id,
				IF(bp.bidang IS NULL, 'Bidang belum diketahui', bp.bidang) AS bidang,
				c.id_unit_kerja, c.nama_baru, c.jumlah FROM
				(SELECT p.id_bidang, b.id_unit_kerja, b.nama_baru,
				COUNT(p.id_pendidikan) AS jumlah FROM pendidikan p INNER JOIN
				(SELECT p.id_pegawai, a.id_unit_kerja, a.nama_baru,
				MAX(p.id_pendidikan) AS id_pendidikan FROM pendidikan p,
				(SELECT p.id_pegawai, uk.id_unit_kerja, uk.nama_baru, MIN(pend.level_p) AS level_p
				FROM pegawai p INNER JOIN pendidikan pend ON p.id_pegawai = pend.id_pegawai,
				current_lokasi_kerja clk, unit_kerja uk
				WHERE p.flag_pensiun = 0 AND pend.level_p < 7 AND
				p.id_pegawai = clk.id_pegawai AND
				clk.id_unit_kerja = uk.id_unit_kerja AND uk.id_skpd = $opd
				GROUP BY p.id_pegawai, uk.id_unit_kerja, uk.nama_baru) a
				WHERE p.id_pegawai = a.id_pegawai AND p.level_p = a.level_p
				GROUP BY p.id_pegawai, a.id_unit_kerja, a.nama_baru) b
				ON p.id_pendidikan = b.id_pendidikan
				GROUP BY p.id_bidang, b.id_unit_kerja, b.nama_baru) c LEFT JOIN bidang_pendidikan bp
				ON c.id_bidang = bp.id ORDER BY bp.bidang";
        return $this->db->query($sql);
    }
	
}
