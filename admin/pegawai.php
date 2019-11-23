<?php
class Pegawai{


	public $id_pegawai;
	public $nip;
	public $nama;
	public $id_j;
	public $jabatan;
	public $id_pegawai_atasan = NULL;
	public $id_pegawai_bawahan = NULL;
	public $pangkat_gol;
	public $nama_baru;

	public $password;

	public function set_nip($nip){

		$this->nip = $nip;
	}

	public function get_nip(){

		return $this->nip;
	}


	public function get_obj($id_pegawai){
include("koncil.php");
		$this->id_pegawai = $id_pegawai;
		$sql = "select 	pegawai.*, concat(pegawai.gelar_depan,' ',pegawai.nama,' ',pegawai.gelar_belakang) as nama_lengkap, golongan.pangkat, uk.*
				from pegawai
				inner join current_lokasi_kerja clk on clk.id_pegawai = pegawai.id_pegawai
				inner join unit_kerja uk on uk.id_unit_kerja = clk.id_unit_kerja
                left join golongan on golongan.golongan = pegawai.pangkat_gol
				where pegawai.id_pegawai = ".$id_pegawai;

		if($r = mysqli_fetch_object(mysqli_query($con,$sql))){
			return $r;
			exit;
		}else{
			
		}

		
	}

	public function get_by_id_j($id_j){

		$query = mysqli_query("select * from pegawai where id_j = $id_j and flag_pensiun = 0 ");
		return mysqli_fetch_object($query);
	}

	public function get_by_nip($nip){
include("koncil.php");
		$query = mysqli_query($con,"select * from pegawai where nip_baru = $nip and flag_pensiun = 0 ");
		return mysqli_fetch_object($query);
	}

	public function get_by_kepsek_di($id_unit_kerja){
		$query = mysqli_query("select * from pegawai where kepsek_di = $id_unit_kerja and flag_pensiun = 0 ");
		return mysqli_fetch_object($query);
	}

	public function pangkat($gol){

		return mysqli_fetch_object(mysqli_query('select pangkat from golongan where golongan = "'.$gol.'"'))->pangkat;
	}

	public function get_unit_kerja($id_pegawai){

		$sql = "select current_lokasi_kerja.id_unit_kerja, unit_kerja.nama_baru as nama_unit_kerja, unit_kerja.nama_baru
				from current_lokasi_kerja
				inner join unit_kerja on unit_kerja.id_unit_kerja = current_lokasi_kerja.id_unit_kerja
				where id_pegawai=".$id_pegawai;

		return mysqli_fetch_object(mysqli_query($sql));

	}

	public function get_cpns($id_pegawai){

		$cpns = mysqli_fetch_object(mysqli_query("select * from sk where id_kategori_sk = 6 and id_pegawai = ".$id_pegawai));
		return $cpns;

	}

	public function hitung_masakerja($tmt_cpns, $mk_awal_thn, $mk_awal_bln){

       if (class_exists('Format')) {
			$format = new Format;
		}else{
			include "./library/format.php";
			$format = new Format;
		}


		list($tmt_thn,$tmt_bln,$tmt_tgl) = explode("-",$tmt_cpns);

		$timestamp = mktime(0,0,0,$tmt_bln - $mk_awal_bln,$tmt_tgl,$tmt_thn - $mk_awal_thn);
		$tgl = $format->datediff(date('Y-m-d'),date('Y-m-d',$timestamp));
        $this->masakerja['tahun'] = $tgl['years'];
        $this->masakerja['bulan'] = $tgl['months'];
        return $this->masakerja;

    }

    public function hitung_masakerja_golongan($masakerja, $gol_cpns, $gol_sekarang){

		list($gol_awal,$ruang_awal) = explode('/',$gol_cpns);
		list($gol,$ruang) = explode('/',$gol_sekarang);

		if($gol_awal == 'II' && $gol == 'III'){
			$tahun = $masakerja['tahun'] - 5;
		}elseif($gol_awal == 'I' && $gol == 'III'){
			$tahun = $masakerja['tahun'] - 11;
		}elseif($gol_awal == 'I' && $gol == 'II'){
			$tahun = $masakerja['tahun'] - 6;
		}else{
			$tahun = $masakerja['tahun'];
		}


		$this->masakerja_golongan['tahun'] = $tahun;
        $this->masakerja_golongan['bulan'] = $masakerja['bulan'];
        return $this->masakerja_golongan;
    }

    /**
     * param obj $pegawai
     *
     *
     */
    public function get_jabatan($pegawai){


		if($pegawai->id_j !=NULL && $pegawai->jenjab == 'Struktural'){

			$qjo=mysqli_query("select jabatan from jabatan where id_j=".$pegawai->id_j);

			$jabatan=mysqli_fetch_object($qjo)->jabatan;

		}elseif($pegawai->id_j == NULL && $pegawai->jenjab == 'Struktural'){

			$sql = "select jfu_pegawai.*, jfu_master.*
					from jfu_pegawai, jfu_master
					where jfu_pegawai.id_pegawai = '".$pegawai->id_pegawai."'
					and jfu_master.kode_jabatan = jfu_pegawai.kode_jabatan";

			$qjo=mysqli_query($sql);

			$jabatan=mysqli_fetch_object($qjo)->nama_jfu;
		}else{ // jabatan fungsional

			$jabatan = $pegawai->jabatan;

			if($jabatan == 'Guru' && $pegawai->kepsek_di != NULL){

				$sekolah = mysqli_query("select * from unit_kerja where id_unit_kerja = ".$pegawai->kepsek_di);

				$jabatan = 'Kepala Sekolah '.mysqli_fetch_object($sekolah)->nama_baru;
			}


		}

		return $jabatan;

	}

	public function is_kepsek($pegawai){

		if($pegawai->is_kepsek == 1){
			return TRUE;
		}else{
			return FALSE;
		}
	}

	public function get_pensiun($pegawai){

		try{
			$bup = 58;
			if(strtolower($pegawai->jenjab) == 'struktural'){
				//return "58";
				if($pegawai->id_j == NULL){
					//fungsional umum bup 58 tahun
					$bup = 58;

				}else{
					//cek eselon ybs
					$query_eselon = "select eselon from jabatan where id_j = ".$pegawai->id_j;
					$result_eselon = mysqli_fetch_object(mysqli_query($query_eselon))->eselon;

					if($result_eselon == 'IIA' || $result_eselon == 'IIB'){
						$bup = 60; //eselon II bup 60 tahun, assik ye..
					}else{
						$bup = 58; //eselon lain bup 58 tahun
					}
				}
			}elseif(strtolower($pegawai->jenjab) == 'fungsional'){
				//cek ke tabel fungsional dong bup nya
				$query_jafung = "select *
								from jafung
								where nama_jafung like '".strtolower($pegawai->jabatan)."'
								AND pangkat_gol = '".$pegawai->pangkat_gol."'";

				$result_jafung = mysqli_fetch_object(mysqli_query($query_jafung))->bup;
				$bup = $result_jafung;
			}else{
				echo "<span class='alert alert-danger'>Jabatan tidak terdefinisi</span>";

			}

			$query_pensiun = "select DATE_FORMAT( CONCAT( LEFT( ADDDATE( ADDDATE( pegawai.tgl_lahir, INTERVAL $bup YEAR ) , INTERVAL 1
				MONTH ) , 7 ) ,  '-01' ) ,  '%Y-%m-%d' ) AS tgl_pensiun
				from pegawai
				where id_pegawai = '".$pegawai->id_pegawai."'";
			$result_pensiun = mysqli_fetch_object(mysqli_query($query_pensiun))->tgl_pensiun;
			return $result_pensiun;


		}catch(Exception $e){
			return "error cuy :".$e;
		}
	}

	public function reset_password($id_pegawai){

		try{
			$sql = "update pegawai set password = left(nip_baru,4) where id_pegawai = ".$id_pegawai;
			mysqli_query($sql);
			echo "<span class='alert alert-success'>reset password berhasil, password kembali ke tahun lahir</span>";
		}catch(Exception $e){
			echo "<span class='alert alert-danger'>Reset password gagal ".$e."</span>";
		}
	}

	public function get_atasan($pegawai){


		if($pegawai->id_j !=NULL && $pegawai->jenjab == 'Struktural'){

			$sql = "select * from pegawai where id_j =
							(select id_bos from jabatan where id_j = ".$pegawai->id_j.")";
			$result = mysqli_fetch_object(mysqli_query($sql));


			return $this->get_obj($result->id_pegawai);

		}elseif($pegawai->id_j == NULL && $pegawai->jenjab == 'Struktural'){

			//return $this->get_obj($pegawai->id_pegawai);
			$query = "select * from riwayat_mutasi_kerja where id_pegawai = '".$pegawai->id_pegawai."'";
			$query .= "and id_riwayat = (select MAX(id_riwayat) from riwayat_mutasi_kerja where id_pegawai = '".$pegawai->id_pegawai."') ";
			//echo $query;
			$r		= mysqli_fetch_object(mysqli_query($query))->id_j_bos;
			//return $r;
			$bos = "select * from pegawai where id_j = '".$r."'";
			$bos = mysqli_fetch_object(mysqli_query($bos));
			//echo
			//return $obj_pegawai->get_obj($bos->id_pegawai);
			return $bos;
		}else{ // jabatan fungsional

			return $this->get_obj($pegawai->id_pegawai);

		}

	}

	public function get_bawahan($pegawai){

		if($pegawai->id_j !=NULL && $pegawai->jenjab == 'Struktural'){

			$sql = "select * from pegawai where id_j =
							(select id_bos from jabatan where id_j = ".$pegawai->id_j.")";
			$result = mysqli_fetch_object(mysqli_query($sql));


			return $this->get_obj($result->id_pegawai);

		}else{

			return FALSE;

		}
	}


	public function login_admin(){
include("koncil.php");
			$sql = "select * from pegawai
					inner join current_lokasi_kerja clk on clk.id_pegawai = pegawai.id_pegawai
					where nip_baru = '".$this->nip."'
					and password='".$this->password."' and (clk.id_unit_kerja = 4789 or pegawai.id_pegawai = 3978) and flag_pensiun = 0";
					
					$q = mysqli_query($con,$sql);
					$cek=mysqli_fetch_array($q);
			if($cek[0]>0){
				return TRUE;
			}else{
				return FALSE;
			}
	}

}
?>