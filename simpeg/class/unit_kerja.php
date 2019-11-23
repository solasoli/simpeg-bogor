<?php
//require_once("../../konek.php");

class Unit_kerja{


	public $id_unit_kerja;
	public $eselon_kepala;
	public $id_j_bos;



	public function get_unit_kerja($id_unit_kerja=null){
	$mysqli = new mysqli("simpeg.db.kotabogor.net","simpeg","Madangkara2017","simpeg");

		$sql = "select * from unit_kerja where id_unit_kerja = $id_unit_kerja";
		return mysqli_fetch_object(mysqli_query($mysqli,$sql));
	}

	public function get_skpd_by_id_unit_kerja($id_unit_kerja){
	$mysqli = new mysqli("simpeg.db.kotabogor.net","simpeg","Madangkara2017","simpeg");
		$sql = "select uk1.*, uk2.nama_baru as skpd
				from unit_kerja uk1
				inner join unit_kerja uk2 on uk1.id_skpd = uk2.id_unit_kerja
				where uk1.id_unit_kerja = $id_unit_kerja
				";

		return mysqli_fetch_object(mysqli_query($mysqli,$sql));
	}


	public function get_skpd_list(){
		$mysqli = new mysqli("simpeg.db.kotabogor.net","simpeg","Madangkara2017","simpeg");
		$sql = "select * from unit_kerja
				where tahun = (select max(tahun) from unit_kerja)
				and id_unit_kerja = id_skpd
				order by nama_baru ASC
				";
		$result = mysqli_query($mysqli,$sql);
		while($r = mysqli_fetch_object($result)){
			$skpd[] = $r;
		}
		return $skpd;
	}
	public function get_skpd_list_tahun($tahun){
		$mysqli = new mysqli("simpeg.db.kotabogor.net","simpeg","Madangkara2017","simpeg");
		$sql = "select * from unit_kerja
				where tahun = ".$tahun."
				and id_unit_kerja = id_skpd
				order by nama_baru ASC
				";
		$result = mysqli_query($mysqli,$sql);
		while($r = mysqli_fetch_object($result)){
			$skpd[] = $r;
		}
		return $skpd;
	}

	public function get_unit_kerja_by_skpd($id_skpd){
		$mysqli = new mysqli("simpeg.db.kotabogor.net","simpeg","Madangkara2017","simpeg");

		$sql = "select * from unit_kerja
				where id_skpd = '".$id_skpd."' order by nama_baru ASC";

		$result = mysqli_query($mysqli,$sql);
		while($obj = mysqli_fetch_object($result)){
			$uk[] = $obj;
		}
		return $uk;
	}



	public function unit_kerja_list($tahun=NULL){
		$mysqli = new mysqli("simpeg.db.kotabogor.net","simpeg","Madangkara2017","simpeg");
		$sql = "select *
				from unit_kerja
				where tahun = 2015";
		$result =  mysqli_query($mysqli,$sql);


		while($list = mysqli_fetch_object($result)){
			$hasil[] = $list;
		}

		return $hasil;

	}

	public function daftar_pegawai($id_unit_kerja){
		$mysqli = new mysqli("simpeg.db.kotabogor.net","simpeg","Madangkara2017","simpeg");

			$sql ="select pegawai.id_pegawai from pegawai
					inner join current_lokasi_kerja clk on clk.id_pegawai = pegawai.id_pegawai
					where flag_pensiun = 0 and id_unit_kerja = ".$id_unit_kerja." order by pegawai.pangkat_gol DESC";

			return mysqli_query($mysqli,$sql);
	}

	public function set_id_unit_kerja($id_unit_kerja){
	$mysqli = new mysqli("simpeg.db.kotabogor.net","simpeg","Madangkara2017","simpeg");
		$this->id_unit_kerja = $id_unit_kerja;
	}

	public function get_kepala($id_unit_kerja){
	$mysqli = new mysqli("simpeg.db.kotabogor.net","simpeg","Madangkara2017","simpeg");
		$sql = "SELECT pegawai.id_pegawai, concat(concat(concat(concat(pegawai.gelar_depan,' '),pegawai.nama),' '),gelar_belakang) as nama, pegawai.nip_baru, jabatan.jabatan, unit_kerja.nama_baru, jabatan.eselon, jabatan.id_j,
				pegawai.nip_baru AS nip, CONCAT(g.pangkat, '-', pegawai.pangkat_gol) AS pangkat_gol, pegawai.id_pegawai
				FROM unit_kerja
				LEFT JOIN jabatan ON jabatan.id_unit_kerja = unit_kerja.id_unit_kerja
				LEFT JOIN pegawai ON pegawai.id_j = jabatan.id_j, golongan g
				WHERE unit_kerja.id_unit_kerja =$id_unit_kerja
				AND jabatan.eselon =
					(SELECT MIN(eselon)
					FROM unit_kerja
					INNER JOIN jabatan ON jabatan.id_unit_kerja = unit_kerja.id_unit_kerja
					WHERE unit_kerja.id_unit_kerja =$id_unit_kerja) AND pegawai.pangkat_gol = g.golongan";

		$obj_kepala = mysqli_fetch_object(mysqli_query($mysqli,$sql));
		$this->eselon_kepala = $obj_kepala->eselon;
		$this->id_j_bos = $obj_kepala->id_j;
		return $obj_kepala;
	}

	public function get_sekretaris(){
	$mysqli = new mysqli("simpeg.db.kotabogor.net","simpeg","Madangkara2017","simpeg");
		$sql = "SELECT
				pegawai.id_pegawai,
				concat(concat(concat(concat(pegawai.gelar_depan,' '),pegawai.nama),' '),gelar_belakang) as nama,
				pegawai.nip_baru, jabatan.jabatan, jabatan.eselon, jabatan.id_j,
				pegawai.nip_baru AS nip, CONCAT(g.pangkat, '-', pegawai.pangkat_gol) AS pangkat_gol, pegawai.id_pegawai
				from jabatan
				LEFT join pegawai on pegawai.id_j = jabatan.id_j, golongan g
				where jabatan.id_bos = $this->id_j_bos
				and eselon =
					(select min(eselon)
					from jabatan
					where jabatan.id_bos = $this->id_j_bos) AND pegawai.pangkat_gol = g.golongan
				";
		$obj = mysqli_fetch_object(mysqli_query($mysqli,$sql));

		return $obj;

	}

	public function get_kabid(){
	$mysqli = new mysqli("simpeg.db.kotabogor.net","simpeg","Madangkara2017","simpeg");

		$sql = "SELECT j.id_j, j.jabatan, j.eselon, CONCAT(p.gelar_depan,' ', p.nama, ' ',p.gelar_belakang) AS nama,
				p.nip_baru AS nip, CONCAT(g.pangkat, '-', p.pangkat_gol) AS pangkat_gol, p.id_pegawai
				FROM jabatan j, pegawai p, golongan g
				WHERE j.id_j = p.id_j AND p.pangkat_gol = g.golongan AND j.id_bos = $this->id_j_bos
				AND j.eselon = 'IIIB'";

		$obj = mysqli_query($mysqli,$sql);
		$num_rows = mysqli_num_rows($obj);
		if($num_rows == 0){
			return $num_rows;
		}else{
			return $obj;
		}
	}

	public function get_bawahan_sekretaris($id_bos){
	$mysqli = new mysqli("simpeg.db.kotabogor.net","simpeg","Madangkara2017","simpeg");
			$sql = "SELECT j.jabatan, j.eselon, CONCAT(p.gelar_depan,' ', p.nama, ' ',p.gelar_belakang) AS nama,
					p.nip_baru AS nip, CONCAT(g.pangkat, '-', p.pangkat_gol) AS pangkat_gol, p.id_pegawai
					FROM jabatan j, pegawai p, golongan g
					WHERE j.id_j = p.id_j AND p.pangkat_gol = g.golongan AND j.id_bos = $id_bos";

			$result =  mysqli_query($mysqli,$sql);
			//var_dump($sql);
			return $result;


	}

	public function get_bawahan_kabid($id_unit_kerja, $id_bos){
		$mysqli = new mysqli("simpeg.db.kotabogor.net","simpeg","Madangkara2017","simpeg");
			$sql = "SELECT j.jabatan, j.eselon, CONCAT(p.gelar_depan,' ', p.nama, ' ',p.gelar_belakang) AS nama,
					p.nip_baru AS nip, CONCAT(g.pangkat, '-', p.pangkat_gol) AS pangkat_gol, p.id_pegawai
					FROM jabatan j, pegawai p, golongan g
					WHERE j.id_j = p.id_j AND p.pangkat_gol = g.golongan AND j.id_bos = $id_bos AND j.id_unit_kerja = $id_unit_kerja";

			$result =  mysqli_query($mysqli,$sql);
			//var_dump($sql);
			$num_rows = mysqli_num_rows($result);
			if($num_rows == 0){
				return $num_rows;
			}else{
				return $result;
			}

	}

	public function get_kasi_wilayah($id_bos){
$mysqli = new mysqli("simpeg.db.kotabogor.net","simpeg","Madangkara2017","simpeg");
		$sql = "SELECT j.jabatan, j.eselon, CONCAT(p.gelar_depan,' ', p.nama, ' ',p.gelar_belakang) AS nama,
				p.nip_baru AS nip, CONCAT(g.pangkat, '-', p.pangkat_gol) AS pangkat_gol, p.id_pegawai
				FROM jabatan j, pegawai p, golongan g
				WHERE j.id_j = p.id_j AND p.pangkat_gol = g.golongan AND j.id_bos = $id_bos
				AND eselon =
					(SELECT max( eselon )
					FROM jabatan
					WHERE id_bos = $id_bos
					)";

		$obj = mysqli_query($mysqli,$sql);
		return $obj;
	}

	public function get_list_pensiun($id_unit_kerja=NULL){
	$mysqli = new mysqli("simpeg.db.kotabogor.net","simpeg","Madangkara2017","simpeg");


	}

	public function get_list_kepala_sekolah($tingkat = NULL){
		$mysqli = new mysqli("simpeg.db.kotabogor.net","simpeg","Madangkara2017","simpeg");

		$kepsek = array();

		$sql = "select
						pegawai.nama,
						concat(pegawai.gelar_depan,' ',pegawai.nama,' ',pegawai.gelar_belakang) as nama_lengkap,
						pegawai.nip_baru, unit_kerja.nama_baru
					from
						unit_kerja
					inner join current_lokasi_kerja clk on clk.id_unit_kerja = unit_kerja.id_unit_kerja
					inner join pegawai on pegawai.id_pegawai = clk.id_pegawai
					where
					nama_baru like '".$tingkat."%'
					and pegawai.is_kepsek = 1
					and pegawai.flag_pensiun = 0
					and tahun = (select max(tahun) from unit_kerja)
					order by unit_kerja.id_unit_kerja";



		$result = mysqli_query($mysqli,$sql);
		while($r = mysqli_fetch_object($result)){
			$kepsek[] = $r;
		}
		return $kepsek;
	}

	public function get_list_jabatan($id_unit_kerja=NULL){
		$mysqli = new mysqli("simpeg.db.kotabogor.net","simpeg","Madangkara2017","simpeg");
		$sql = "SELECT *
				FROM jabatan
				WHERE tahun = (
				SELECT max( tahun )
				FROM jabatan
				WHERE id_unit_kerja =".$id_unit_kerja." )
				AND id_unit_kerja =".$id_unit_kerja;

		//return  $sql;
		$result = mysqli_query($mysqli,$sql);
		while($r = mysqli_fetch_object($result)){
			$jabatan[] = $r;
		}
		return $jabatan;
	}

}
