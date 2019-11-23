<?php

class Skp_model extends CI_model{
	
	public function __construct(){
		
	}
	
	public function get_rekap_tahun($tahun=NULL){
		
		$tahun = isset($tahun) ? $tahun : date('Y');
		$query = "SELECT uk.id_unit_kerja, uk.nama_baru as skpd, z.jml_pegawai, z.jml_skp FROM
					(SELECT x.id_skpd, x.jml_pegawai, y.jml_skp FROM
					(SELECT uk.id_skpd, SUM(a.jml_pegawai) as jml_pegawai FROM
					(SELECT clk.id_unit_kerja, COUNT(p.id_pegawai) jml_pegawai
					FROM pegawai p, current_lokasi_kerja clk
					WHERE p.id_pegawai = clk.id_pegawai AND p.flag_pensiun = 0
					GROUP BY clk.id_pegawai) a, unit_kerja uk
					WHERE a.id_unit_kerja = uk.id_unit_kerja
					GROUP BY uk.id_skpd) x,
					(SELECT uk.id_skpd, SUM(a.jml_skp) as jml_skp FROM
					(SELECT clk.id_unit_kerja, sh.id_pegawai, COUNT(id_skp) as jml_skp 
					FROM skp_header sh, current_lokasi_kerja clk
					WHERE YEAR(sh.periode_awal) = ".$tahun." AND clk.id_pegawai = sh.id_pegawai
					GROUP BY sh.id_pegawai) a, unit_kerja uk
					WHERE a.id_unit_kerja = uk.id_unit_kerja
					GROUP BY uk.id_skpd) y
					WHERE x.id_skpd = y.id_skpd) z, unit_kerja uk
					WHERE z.id_skpd = uk.id_unit_kerja;";
					
		return $this->db->query($query)->result();
	}
	
	public function get_opd(){
		
		$query = "select * from unit_kerja where id_unit_kerja = id_skpd and tahun = 2017";
		return $this->db->query($query)->result();
	}
	
	public function toggle(){
		$query = "select skp_block from pegawai p where flag_pensiun = 0 group by skp_block";
		$hasil = $this->db->query($query)->row()->skp_block;
		if($hasil == 0){
			$tog = 1;
		}else{
			$tog = 0;
		}
		
		$query_update = "update pegawai p set skp_block = '".$tog."'
						";
		
		
		return $this->db->query($query_update);		
						
	}
	
	public function toggle_opd($id_opd){
		$query = "select skp_block from pegawai p
					inner join current_lokasi_kerja clk on clk.id_pegawai = p.id_pegawai
					inner join unit_kerja uk on uk.id_unit_kerja = clk.id_unit_kerja
					where uk.id_skpd = '".$id_opd."' group by skp_block
					";
		$hasil = $this->db->query($query)->row()->skp_block;
		if($hasil == 0){
			$tog = 1;
		}else{
			$tog = 0;
		}
		
		$query_update = "update pegawai p, current_lokasi_kerja clk, unit_kerja uk
						set skp_block = '".$tog."'
						where clk.id_pegawai = p.id_pegawai
						and uk.id_unit_kerja = clk.id_unit_kerja
						and uk.id_skpd = '".$id_opd."'";
		
		
		return $this->db->query($query_update);		
						
	}
	
	public function toggle_pegawai($id_pegawai){
		$sql = "select skp_block from pegawai where id_pegawai = ".$id_pegawai;
		
		$hasil = $this->db->query($sql)->row()->skp_block;
		if($hasil == 0){
			$tog = 1;
		}else{
			$tog = 0;
		}
		
		$query_update = "update pegawai set skp_block = '".$tog."' where id_pegawai = ".$id_pegawai;
		return $this->db->query($query_update);
	}
	
	public function get_status_pegawai($id_pegawai){
		$sql = "select skp_block from pegawai p where id_pegawai = ".$id_pegawai;
		$query = $this->db->query($sql);
		if($query->row()->skp_block == 1){
			return "BLOCKED";
		}else{
			return "ALLOWED";
		}
	}
	
	public function get_status_all(){
		$sql = "select skp_block from pegawai p
					inner join current_lokasi_kerja clk on clk.id_pegawai = p.id_pegawai
					inner join unit_kerja uk on uk.id_unit_kerja = clk.id_unit_kerja
					where p.flag_pensiun = 0
					group by skp_block
					";
		$query =  $this->db->query($sql);
		if($query->num_rows() > 1){
			return "PARTIAL_BLOCKED";
		}else{
			if($query->row()->skp_block == 1){
				return "BLOCKED";
			}else{
				return "ALLOWED";
			}
		}
		
		
	}
	
	
	
	public function get_status_opd($id_opd){
		$sql = "select skp_block from pegawai p
					inner join current_lokasi_kerja clk on clk.id_pegawai = p.id_pegawai
					inner join unit_kerja uk on uk.id_unit_kerja = clk.id_unit_kerja
					where uk.id_skpd = '".$id_opd."' group by skp_block
					";
		$query =  $this->db->query($sql);
		if($query->num_rows() > 1){
			return "PARTIAL_BLOCKED";
		}else{
			if($query->row()->skp_block == 1){
				return "BLOCKED";
			}else{
				return "ALLOWED";
			}
		}		
		
	}
	
	public function get_detail($id_opd){
		$sql = "select p.id_pegawai, nip_baru, 
			TRIM(IF(LENGTH(p.gelar_belakang) > 1,
				CONCAT(p.gelar_depan,
						' ',
						p.nama,
						CONCAT(', ', p.gelar_belakang)),
				CONCAT(p.gelar_depan, ' ', p.nama))) AS nama, p.pangkat_gol				
				from pegawai p
				inner join current_lokasi_kerja clk on clk.id_pegawai = p.id_pegawai
				inner join unit_kerja uk on uk.id_unit_kerja = clk.id_unit_kerja
				where p.flag_pensiun = 0
				and uk.id_skpd = '".$id_opd."'
				";
				
		return $this->db->query($sql)->result();
	}
	
	
}