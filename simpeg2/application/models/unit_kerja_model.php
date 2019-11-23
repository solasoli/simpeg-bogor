<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

Class Unit_kerja_model extends CI_Model{

	public function __Construct(){

		parent::__Construct();

	}

	public function get_unit_kerja($id_unit_kerja){

		$this->db->where('id_unit_kerja',$id_unit_kerja);
		return $this->db->get('unit_kerja')->row();
	}

	public function get_penandatangan($id_unit_kerja){

		if($id_unit_kerja == 5347){
			$sql = "SELECT p.id_pegawai,
				TRIM(IF(LENGTH(p.gelar_belakang) > 1,
						CONCAT(p.gelar_depan,
								' ',
								p.nama,
								CONCAT(', ', p.gelar_belakang)),
						CONCAT(p.gelar_depan, ' ', p.nama))) as nama, p.flag_pensiun,
				p.nip_baru, jabatan.jabatan, unit_kerja.nama_baru, jabatan.eselon
				FROM unit_kerja
				INNER JOIN current_lokasi_kerja on current_lokasi_kerja.id_unit_kerja = unit_kerja.id_unit_kerja
				INNER JOIN pegawai p ON p.id_pegawai = current_lokasi_kerja.id_pegawai
				INNER JOIN jabatan ON jabatan.id_j = p.id_j
				WHERE unit_kerja.id_unit_kerja = ".$id_unit_kerja." and jabatan.id_j = 3138
				order by jabatan.eselon ASC";


			$sql2 = "SELECT p.id_pegawai,
							TRIM(IF(LENGTH(p.gelar_belakang) > 1,
									CONCAT(p.gelar_depan,
											' ',
											p.nama,
											CONCAT(', ', p.gelar_belakang)),
									CONCAT(p.gelar_depan, ' ', p.nama))) as nama, p.flag_pensiun,
							p.nip_baru, CONCAT('Plt. ',jabatan.jabatan) as jabatan, jabatan.eselon
							FROM jabatan_plt plt
							INNER JOIN jabatan ON jabatan.id_j = plt.id_j
							INNER JOIN pegawai p on p.id_pegawai = plt.id_pegawai
							WHERE plt.id_j = 3138
							order by jabatan.eselon ASC";

				if($penandatangan = $this->db->query($sql)->row()){
					return $panandatangan;
				}else if($penandatangan = $this->db->query($sql2)->row()){
					return $penandatangan;
				}else{
					return NULL;
				}

		}

		//ambil id_j paling tinggi eselonnya
		$a = "SELECT * FROM jabatan WHERE id_unit_kerja = ".$id_unit_kerja." and tahun = (select max(tahun) from jabatan) order by eselon ASC limit 0,1";
		//echo $a;exit;
		$a_id_j = $this->db->query($a)->row()->id_j;
		//cek ada gak pegawai dengan id_j tersebut
		$b = "SELECT id_pegawai from pegawai where id_j = ".$a_id_j;

		if($b_row= $this->db->query($b)->row()){
			$b_id_pegawai = $b_row->id_pegawai;
			$sql = "SELECT p.id_pegawai,
					TRIM(IF(LENGTH(p.gelar_belakang) > 1,
							CONCAT(p.gelar_depan,
									' ',
									p.nama,
									CONCAT(', ', p.gelar_belakang)),
							CONCAT(p.gelar_depan, ' ', p.nama))) as nama, p.flag_pensiun,
					p.nip_baru, jabatan.jabatan, unit_kerja.nama_baru, jabatan.eselon
					FROM unit_kerja
					INNER JOIN current_lokasi_kerja on current_lokasi_kerja.id_unit_kerja = unit_kerja.id_unit_kerja
					INNER JOIN pegawai p ON p.id_pegawai = current_lokasi_kerja.id_pegawai
					INNER JOIN jabatan ON jabatan.id_j = p.id_j
					WHERE p.id_pegawai = $b_id_pegawai
					order by jabatan.eselon ASC

			";

		}else{
			//echo "disini";exit;
			$sql = "SELECT p.id_pegawai,
						TRIM(IF(LENGTH(p.gelar_belakang) > 1,
								CONCAT(p.gelar_depan,
										' ',
										p.nama,
										CONCAT(', ', p.gelar_belakang)),
								CONCAT(p.gelar_depan, ' ', p.nama))) as nama, p.flag_pensiun,
						p.nip_baru, CONCAT('Plt. ',jabatan.jabatan) as jabatan, jabatan.eselon
						FROM jabatan_plt plt
						INNER JOIN jabatan ON jabatan.id_j = plt.id_j
						INNER JOIN pegawai p on p.id_pegawai = plt.id_pegawai
						WHERE plt.id_j = $a_id_j
						order by jabatan.eselon ASC

			 ";
		}
		/*
		$sql = "SELECT p.id_pegawai,
				TRIM(IF(LENGTH(p.gelar_belakang) > 1,
						CONCAT(p.gelar_depan,
								' ',
								p.nama,
								CONCAT(', ', p.gelar_belakang)),
						CONCAT(p.gelar_depan, ' ', p.nama))) as nama, p.flag_pensiun,
				p.nip_baru, jabatan.jabatan, unit_kerja.nama_baru, jabatan.eselon
				FROM unit_kerja
				INNER JOIN current_lokasi_kerja on current_lokasi_kerja.id_unit_kerja = unit_kerja.id_unit_kerja
				INNER JOIN pegawai p ON p.id_pegawai = current_lokasi_kerja.id_pegawai
				INNER JOIN jabatan ON jabatan.id_j = p.id_j
				WHERE unit_kerja.id_unit_kerja = $id_unit_kerja
				order by jabatan.eselon ASC

		";
		*/
		//echo $sql;exit;
		if($row = $this->db->query($sql)->row()){
			//print_r($row);exit;
			return $row;
		}else{
			$sql2 = "SELECT
						p.id_pegawai,
						TRIM(IF(LENGTH(p.gelar_belakang) > 1,
						CONCAT(p.gelar_depan,
								' ',
								p.nama,
								CONCAT(', ', p.gelar_belakang)),
						CONCAT(p.gelar_depan, ' ', p.nama))) AS nama,
						p.nip_baru,
						j.jabatan,
						uk.nama_baru,
						j.eselon
					FROM
						jabatan j
							INNER JOIN
						jabatan_plt jp ON jp.id_j = j.id_j
							INNER JOIN
						pegawai p ON p.id_pegawai = jp.id_pegawai
							INNER JOIN
						unit_kerja uk ON uk.id_unit_kerja = j.id_unit_kerja
					WHERE
						j.id_unit_kerja = $id_unit_kerja
					ORDER BY j.eselon ASC

							";
				return $this->db->query($sql2)->row();

		}


	}

	public function get_sekda(){

			$sql = "select *
					FROM pegawai
					where id_j = '4376'
					";

		return $this->db->query($sql)->row();
	}

	public function get_daftar_pegawai($id_unit_kerja){


		$sql = "select p.id_pegawai, p.nama, p.nip_baru, j.eselon
			from pegawai p
			inner join current_lokasi_kerja clk on clk.id_pegawai = p.id_pegawai
			inner join unit_kerja uk on uk.id_unit_kerja = clk.id_unit_kerja
			left join jabatan j on j.id_j = p.id_j
			where p.flag_pensiun = 0
			and uk.id_skpd = $id_unit_kerja
			order by p.pangkat_gol DESC, p.nip_baru ASC,  j.eselon ASC
			";

		return $this->db->query($sql)->result();
	}

	public function get_rekap_opd(){
		$sql = "SELECT u.id_skpd, uk2.nama_baru as nama_baru, COUNT(uk2.nama_baru) AS jumlah
				FROM pegawai p
				INNER JOIN current_lokasi_kerja c ON p.id_pegawai = c.id_pegawai
				INNER JOIN unit_kerja u ON u.id_unit_kerja = c.id_unit_kerja
				inner join (select * from unit_kerja where id_unit_kerja = id_skpd) as uk2
					on uk2.id_unit_kerja = u.id_skpd
				where flag_pensiun = 0
				GROUP BY u.id_skpd ORDER BY uk2.nama_baru ASC";

		return $this->db->query($sql)->result();
	}

	public function listOPD(){
		$sql = "SELECT uk.id_unit_kerja, uk.nama_baru, uk.tahun, uk.Alamat, uk.telp,
                ST_AsText(uk.long_lat) AS long_lat, ST_AsText(uk.long_lat_outer) AS long_lat_outer,
                uk.in_long, uk.in_lat, uk.out_long, uk.out_lat
                FROM unit_kerja uk
                WHERE uk.tahun = 2017 AND uk.id_unit_kerja = uk.id_skpd ORDER BY uk.nama_baru";

		$query = $this->db->query($sql);
		$data = null;
		foreach ($query->result() as $row)
		{
			$data[] = $row;
		}
		return $data;
	}

	public function get_daftar_pegawai_opd($id_opd){
		$sql = "SELECT CONCAT(\"'\",a.nip_baru) as nip_baru, a.nama, a.jenis_kelamin, a.tgl_lahir, a.usia, a.jenjab, a.jabatan, a.eselon, a.agama,
				a.pangkat_gol, a.nama_baru FROM
				(SELECT p.nip_baru, CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
				nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(' ',p.gelar_belakang) END) AS nama,
				CASE WHEN p.jenis_kelamin = 1 THEN 'Laki-laki' ELSE 'Perempuan' END AS jenis_kelamin,
				DATE_FORMAT(p.tgl_lahir,  '%d/%m/%Y') AS tgl_lahir,
				ROUND(DATEDIFF(CURRENT_DATE, DATE_FORMAT(p.tgl_lahir, '%Y/%m/%d'))/365,2) AS usia,
				p.jenjab, CASE WHEN p.jenjab = 'Fungsional' THEN p.jabatan ELSE CASE WHEN p.id_j IS NULL THEN 'Fungsional Umum'
				ELSE j.jabatan END END AS jabatan, CASE WHEN j.eselon IS NULL THEN 'Z' ELSE j.eselon END AS eselon, p.agama, p.pangkat_gol, uk.nama_baru
				FROM pegawai p LEFT JOIN jabatan j ON p.id_j = j.id_j, current_lokasi_kerja clk, unit_kerja uk
				WHERE p.id_pegawai = clk.id_pegawai AND clk.id_unit_kerja = uk.id_unit_kerja AND p.flag_pensiun = 0
				AND uk.id_skpd = ".$id_opd.") a ORDER BY a.eselon ASC, a.pangkat_gol DESC";
		$query = $this->db->query($sql);
		return $query->result();
	}

	public function getNamaSKPD($idskpd){
		$sql = "SELECT uk.nama_baru FROM unit_kerja uk WHERE uk.id_unit_kerja = ".$idskpd;
		$query = $this->db->query($sql);
		$nm = $query->row()->nama_baru;
		return $nm;
	}
}
