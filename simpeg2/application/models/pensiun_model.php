<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pensiun_model extends CI_Model{

	public function __construct(){
	
		parent::__construct();
		
	}
	
	function list_pejabat(){
		$q = "select nama, nip_baru as nip, pangkat_gol as golongan, u.nama_baru as unit_kerja, j.jabatan, j.eselon as eselon, tgl_lahir, bup
			from pegawai p
			inner join current_lokasi_kerja c on c.id_pegawai = p.id_pegawai
			inner join unit_kerja u on u.id_unit_kerja = c.id_unit_kerja
			inner join jabatan j on j.id_j = p.id_j
			inner join (
				SELECT p.id_pegawai, DATE_ADD( tgl_lahir, INTERVAL 58 YEAR )  AS bup
			FROM pegawai p
			INNER JOIN jabatan j ON j.id_j = p.id_j
			WHERE flag_pensiun =0 
			group by p.id_pegawai
			ORDER BY  `j`.`eselon` DESC 
				) as b on b.id_pegawai = p.id_pegawai
			where flag_pensiun = 0
			ORDER by bup asc";
			
		$r = $this->db->query($q);
		return $r->result();
	}
	
}
