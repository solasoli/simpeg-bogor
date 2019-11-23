<?php


class Pegawai{


	public $id_pegawai;
	public $nip;
	public $nama;
	public $id_j;
	public $jabatan;
	
	
	public function set_nip($nip){
	
		$this->nip = $nip;
	}
	
	public function get_nip(){
	
		return $this->nip;
	}
	
	/*
	 * concat(concat(concat(gelar_depan,' '),nama),concat(', ',gelar_belakang)) as nama,	
	*/
	public function get_obj($id_pegawai){
	
		$this->id_pegawai = $id_pegawai;
		$sql = "select 			
				*				
				from pegawai where id_pegawai = $id_pegawai"; 
				
		return mysql_fetch_object(mysql_query($sql));
	}
	
	public function get_by_id_j($id_j){
	
		$query = mysql_query("select * from pegawai where id_j = $id_j and flag_pensiun = 0 ");
		return mysql_fetch_object($query);
	}
	
	public function get_unit_kerja($id_pegawai){
	
		$sql = "select current_lokasi_kerja.id_unit_kerja, unit_kerja.nama_baru as nama_unit_kerja, unit_kerja.nama_baru
				from current_lokasi_kerja 
				inner join unit_kerja on unit_kerja.id_unit_kerja = current_lokasi_kerja.id_unit_kerja
				where id_pegawai=".$id_pegawai;
		
		return mysql_fetch_object(mysql_query($sql));
		
	}
	
	public function get_cpns($id_pegawai){
						 
		$cpns = mysql_fetch_object(mysql_query("select * from sk where id_kategori_sk = 6 and id_pegawai = ".$id_pegawai));
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
					
			$qjo=mysql_query("select jabatan from jabatan where id_j=".$pegawai->id_j);
			
			$jabatan=mysql_fetch_object($qjo)->jabatan;
		
		}elseif($pegawai->id_j == NULL && $pegawai->jenjab == 'Struktural'){
		
			$sql = "select jfu_pegawai.*, jfu_master.* 
					from jfu_pegawai, jfu_master
					where jfu_pegawai.id_pegawai = '".$pegawai->id_pegawai."'
					and jfu_master.kode_jabatan = jfu_pegawai.kode_jabatan";
								
			$qjo=mysql_query($sql);
				
			$jabatan=mysql_fetch_object($qjo)->nama_jfu;
		}else{ // jabatan fungsional
		
			$jabatan = $pegawai->jabatan;	
				
		}
		
		return $jabatan;
			
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
					$result_eselon = mysql_fetch_object(mysql_query($query_eselon))->eselon;
					
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
								
				$result_jafung = mysql_fetch_object(mysql_query($query_jafung))->bup;
				$bup = $result_jafung;
			}else{
				echo "<span class='alert alert-danger'>Jabatan tidak terdefinisi</span>";
				
			}
			
			$query_pensiun = "select DATE_FORMAT( CONCAT( LEFT( ADDDATE( ADDDATE( pegawai.tgl_lahir, INTERVAL $bup YEAR ) , INTERVAL 1 
				MONTH ) , 7 ) ,  '-01' ) ,  '%Y-%m-%d' ) AS tgl_pensiun 
				from pegawai 
				where id_pegawai = '".$pegawai->id_pegawai."'";
			$result_pensiun = mysql_fetch_object(mysql_query($query_pensiun))->tgl_pensiun;
			return $result_pensiun;
			
			
		}catch(Exception $e){
			return "error cuy :".$e;	
		}
	}
	
	public function reset_password($id_pegawai){
						
		try{
			$sql = "update pegawai set password = left(nip_baru,4) where id_pegawai = ".$id_pegawai;
			mysql_query($sql);
			echo "<span class='alert alert-success'>reset password berhasil, password kembali ke tahun lahir</span>";
		}catch(Exception $e){
			echo "<span class='alert alert-danger'>Reset password gagal ".$e."</span>";
		}
	}
	
	
}
