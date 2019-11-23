<?php 
require_once("../../konek.php");
require_once("../../class/pegawai.php");

if($_POST){
	
	$skp = new SKP;
	switch($_POST['aksi']){
		
		case 'tambahSkp' :
			$skp->add_skp();
			break;
		case 'tambahTarget' :		
			$skp->add_target();
			break;
		case 'editTarget' :
			echo "edit target";
			break;
		case 'updateTarget':
			$skp->update_target();
			break;
		case 'getUraianTarget' :
			$skp->get_uraian_target();
			break;
		case 'saveRealisasi' :
			$skp->save_realisasi_target();
			break;
		case 'delTarget' :
			$skp->del_target();
			break;
		case 'getNilai' :
			$skp->hitung_nilai();
			break;
		case 'delSkp' :
			$skp->del_skp();
			break;
		case 'cekStatus' :
			echo $skp->get_status_skp();			
			break;
		case 'saveReviewSkp':
			$skp->save_review_skp();
			break;
		case 'updateStatusPengajuan' :
			$skp->update_status_pengajuan();
			break;
		case 'setStatus' :
			$skp->set_status();
			break;
		case 'saveTambahan' :
			$skp->save_tugas_tambahan();
			break;
		case 'delTambahan':
			$skp->del_tambahan();
			break;
		case 'savePerilaku' :
			$skp->save_perilaku();
			break;
		default:
			echo "error : undefined post";
	}
}


class Skp{
	

	
	var $id_pegawai	;
	
	
	public function set_id_pegawai($id_pegawai){
		
		$this->id_pegawai = $id_pegawai;
	}
	
	public function get_skp($id_pegawai = 'NULL'){
		
		if(!isset($id_pegawai)) $id_pegawai = $this->id_pegawai;
		
		$query = "select * from skp_header where id_pegawai = ".$id_pegawai;
		
		return mysql_query($query);
	}
	
	public function get_skp_by_id($idskp){
			
			//$query = "select * from skp_header where id_skp = '".$idskp."'";
			$query = "select *,
						(COALESCE(s.orientasi_pelayanan,0) 
						+ COALESCE(s.integritas,0)
						+ COALESCE(s.komitmen,0)
						+ COALESCE(s.disiplin,0)
						+ COALESCE(s.kerjasama,0)
						+ COALESCE(s.kepemimpinan,0)) 

						as jumlah_perilaku,

						(COALESCE(s.orientasi_pelayanan,0) 
						+ COALESCE(s.integritas,0)
						+ COALESCE(s.komitmen,0)
						+ COALESCE(s.disiplin,0)
						+ COALESCE(s.kerjasama,0)
						+ COALESCE(s.kepemimpinan	,0))
						/
						(6 -
						(COALESCE(s.orientasi_pelayanan - s.orientasi_pelayanan,1) 
						+ COALESCE(s.integritas - s.integritas,1)
						+ COALESCE(s.komitmen - s.komitmen,1)
						+ COALESCE(s.disiplin - s.disiplin,1)
						+ COALESCE(s.kerjasama - s.kerjasama,1)
						+ COALESCE(s.kepemimpinan	- s.kepemimpinan,1))
						)
					as rata2_perilaku
					FROM skp_header s
					where id_skp = ".$idskp;
			
			return mysql_fetch_object(mysql_query($query));
	}
	// untuk pengecekan status disabled button
	public function get_status_skp(){
	
		if(! isset($_POST['idskp'])) die ;
		$query = "select status_pengajuan from skp_header where id_skp = '".$_POST['idskp']."'";
		echo mysql_fetch_object(mysql_query($query))->status_pengajuan;		
	}
	
	public function get_target($idskp){
		
		$query = "select * from skp_target where id_skp = ".$idskp;	
		return mysql_query($query);		
	}
	
	public function get_uraian_target(){
		
		$query = "select * from skp_target where id_skp_target = ".$_POST['idtarget'];
		echo json_encode(mysql_fetch_array(mysql_query($query)));
		//return $query
	}
	
	public function get_tambahan_kreatifitas($idskp, $jenistambahan){
		
		$query = "select * from skp_tambahan_kreatifitas t where id_skp = '".$idskp."' and jenis = '".$jenistambahan."'";
		return mysql_query($query);
		//return $query;
	}
	
	public function get_nilai_tambahan($idskp,$jenistambahan){
		$query = "select count(*) as jumlah from skp_tambahan_kreatifitas where id_skp = '".$idskp."' and jenis = '".$jenistambahan."'";
		$jumlah =mysql_fetch_object(mysql_query($query))->jumlah;
		
		if($jumlah < 1){
			return 0;
		}elseif($jumlah >=1 && $jumlah <=3){
			return 1;
		}elseif($jumlah >=4 && $jumlah <=6){
			return 2;
		}elseif($jumlah >=7 ){
			return 3;
		}
		
	}
	
	public function get_nilai_capaian($idskp){
		
		$tambahan = $this->get_nilai_tambahan($idskp,'TAMBAHAN');
		
		$query = "select round(sum(nilai_capaian),2) as nilai_skp, round(avg(nilai_capaian),2) + ".$tambahan." as rata2_nilai_skp from skp_target where id_skp = ".$idskp ;
		return mysql_fetch_object(mysql_query($query));
	}
	
		
	public function update_target(){
		$query = "update skp_target set					
					uraian_tugas= '".$_POST['inputUraian']."',
					angka_kredit= '".$_POST['inputAK']."',
					kuantitas= '".$_POST['inputKuantitas']."',
					kuantitas_satuan= '".$_POST['inputKuantitasSatuan']."',
					kualitas= '".$_POST['inputKualitas']."',
					waktu= '".$_POST['inputWaktu']."',
					waktu_satuan= '".$_POST['inputWaktuSatuan']."',
					biaya= '".$_POST['inputBiaya']."'
					where id_skp_target = '".$_POST['idtarget']."'";
				
		
		try{
			if(mysql_query($query)){
				echo "1";
			}else{
				echo "gagal menyimpan	".$query;
			}
		}catch(Exception $e){
			echo "Error mas bro".$e->getMessage();
		}
		
		//return $query;
	}
	
	public function add_skp(){
		
		$query = "insert INTO skp_header(
					id_pegawai, 
					jabatan_pegawai, 
					id_unit_kerja_pegawai, 
					id_penilai, 
					jabatan_penilai, 
					id_unit_kerja_penilai,
					id_atasan_penilai, 
					jabatan_atasan_penilai, 
					id_unit_kerja_atasan_penilai,
					periode_awal,
					periode_akhir					
				) 
				VALUES(
					'".$_POST['id_pegawai']."',
					'".$_POST['jabatan_pegawai']."',
					'".$_POST['id_unit_kerja_pegawai']."',
					'".$_POST['id_penilai']."',
					'".$_POST['jabatan_penilai']."',
					'".$_POST['id_unit_kerja_penilai']."',
					'".$_POST['id_atasan_penilai']."',
					'".$_POST['jabatan_atasan_penilai']."',
					'".$_POST['id_unit_kerja_atasan_penilai']."',
					'".$_POST['periode_awal']."',
					'".$_POST['periode_akhir']."'
				)";
				
		try{
			//lock tables skp_header
			
			if(mysql_query($query)){
				mysql_query("lock tables skp_header WRITE");
				$id_skp = mysql_fetch_object(mysql_query("select MAX(id_skp) as id_skp from skp_header"))->id_skp;
				mysql_query("unlock tables");
				echo $id_skp;
			}else{
				echo "gagal menyimpan	".mysql_error();
			}
		}catch(Exception $e){
			echo "Error mas bro".$e->getMessage();
		}
	}
	
	public function add_target(){
		
		$query = "insert INTO skp_target(
					id_skp,
					uraian_tugas,
					angka_kredit,
					kuantitas,
					kuantitas_satuan,
					kualitas,
					waktu,
					waktu_satuan,
					biaya,
					status_pengajuan
				)VALUES(
						'".$_POST['idskp']."',
						'".$_POST['inputUraian']."',
						'".$_POST['inputAK']."',
						'".$_POST['inputKuantitas']."',
						'".$_POST['inputKuantitasSatuan']."',
						'".$_POST['inputKualitas']."',
						'".$_POST['inputWaktu']."',
						'".$_POST['inputWaktuSatuan']."',
						'".$_POST['inputBiaya']."',
						'0'						
					)";
		
		try{
			if(mysql_query($query)){
				//echo "1";
				echo mysql_insert_id();
			}else{
				echo "gagal menyimpan	".mysql_error();
			}
		}catch(Exception $e){
			echo "Error mas bro".$e->getMessage();
		}
		
		//return $query;
	}
	
	public function save_realisasi_target(){
			
		$nilai = $this->hitung_nilai();
		
		$query = "update skp_target set 
					real_angka_kredit	= '".$_POST['realAngkaKredit']."',
					real_kuantitas		= '".$_POST['realKuantitas']."',
					real_kualitas		= '".$_POST['realKualitas']."',
					real_waktu			= '".$_POST['realWaktu']."',
					real_biaya			= '".$_POST['realBiaya']."',
					hitung_nilai		= '".$nilai['hitung_nilai']."',
					nilai_capaian		= '".$nilai['nilai_capaian']."'
				 where id_skp_target = ".$_POST['idtarget'];
		//echo $query;
		if(mysql_query($query)){
			echo "Berhasil";
		}else{
			echo "gagal menyimpan update "+mysql_error();
		}
					
	}
	
	public function save_review_skp(){
		
		$query = "update skp_header set review = '".$_POST['review']."' where id_skp = '".$_POST['idskp']."'";
		
		if(mysql_query($query)){
			echo "Berhasil";
			//echo $query ;
		}else{
			echo "gagal menyimpan update "+mysql_error();
		}
	}
	
	
	public function save_review_target(){
		
		$query = "update skp_target set review = '".$_POST['review']."' where id_skp_target = ".$_POST['idtarget'];
	}
	
	public function del_target(){
		
		$query = "delete from skp_target where id_skp_target = ".$_POST['idtarget'];
		if(mysql_query($query)){
			echo "1";
		}else{
			echo "gagal hapus "+mysql_error();
		}
	}
	
	public function del_skp(){
		
		$query = "delete from skp_header where id_skp = ".$_POST['idskp'];
		if(mysql_query($query)){
			echo "1";
		}else{
			echo "gagal hapus "+mysql_error();
		}
	}
	
	public function save_tugas_tambahan(){
		$query = "insert into skp_tambahan_kreatifitas(					
					id_skp,
					tugas_tambahan,
					jenis
				) VALUES(					
					'".$_POST['idskp']."',
					'".$_POST['tugastambahan']."',
					'".$_POST['jenis']."'
				)";
		try{
			if(mysql_query($query)){
				//echo "1";
				echo mysql_insert_id();
			}else{
				echo "gagal menyimpan	".mysql_error();
			}
		}catch(Exception $e){
			echo "Error mas bro".$e->getMessage();
		}
	}
	
	public function del_tambahan(){
		
		$query = "delete from skp_tambahan_kreatifitas where id_tambahan_kreatifitas = ".$_POST['idtambahan'];
		if(mysql_query($query)){
			echo "1";
		}else{
			echo "gagal hapus "+mysql_error();
		}
	}
	
	public function save_perilaku(){
		
		
		$query = "update skp_header set
					orientasi_pelayanan='".$_POST['orientasipelayanan']."',
					integritas		='".$_POST['integritas']."',
					komitmen		='".$_POST['komitmen']."',
					disiplin		='".$_POST['disiplin']."',
					kerjasama		='".$_POST['kerjasama']."',";
		
			
		if($_POST['kepemimpinan'] == '0' || $_POST['kepemimpinan'] == NULL){
			//$kepemimpinan = NULL;
			$query .= "kepemimpinan = NULL ";
		}else{
			$query .= "kepemimpinan = '".$_POST['kepemimpinan']."'";
		}			
										
		$query 		.=	"where id_skp	= '".$_POST['idskp']."'";
					
		
		if(mysql_query($query)){				
			echo "1";
		}else{
			echo "gagal menyimpan	".$query."<br>".mysql_error();
		}
		
		// echo $query;
	}
	
	public function sebutan_capaian($nilai){
		
		if($nilai < 51){
			return "Buruk";			
		}elseif($nilai >= 51 && $nilai < 61){
			return "Kurang";
		}elseif($nilai >= 61 && $nilai < 76){
			return "Cukup";
		}elseif($nilai >= 76 && $nilai < 91){
			return "Baik";
		}elseif($nilai >= 91 ){
			return "Sangat Baik";
		}else{
			return "Nilai tidak terdefinisi";
		}
	}
	
	
	public function update_status_pengajuan(){
	
		$query = "update skp_header set status_pengajuan = '".$_POST['statusPengajuan']."' where id_skp = '".$_POST['idskp']."'";
		
		if(mysql_query($query)){
			echo "1";
		}else{
			echo "gagal hapus "+mysql_error();
		}
	}
	
	public function get_dinilai($pegawai){
		
		if($pegawai->id_j == NULL) {			
			return FALSE;die;
		}
		
		$query = "select * from jabatan 
					inner join pegawai on pegawai.id_j = jabatan.id_j
					where jabatan.id_bos = '".$pegawai->id_j."'";
		$result = mysql_query($query);
		if(mysql_num_rows($result) > 0){
			return $result;
		}else{
			$query = "SELECT rmk.id_j_bos, p.*, rmk.id_pegawai
						FROM riwayat_mutasi_kerja rmk
						INNER JOIN pegawai p on p.id_pegawai = rmk.id_pegawai
						INNER JOIN 
						(
							SELECT s.id_sk, tmt
							FROM sk s
							INNER JOIN
							(
								SELECT rmk.id_pegawai, MAX(s.tmt) as max_tmt, s.id_sk
								FROM riwayat_mutasi_kerja rmk
								INNER JOIN sk s ON s.id_sk = rmk.id_sk
								GROUP BY rmk.id_pegawai
							) AS t ON t.id_pegawai = s.id_pegawai AND s.tmt = t.max_tmt
						) AS t ON t.id_sk = rmk.id_sk
					   WHERE rmk.id_j_bos = '".$pegawai->id_j."' AND p.flag_pensiun = 0";			
			return mysql_query($query);
		}
		
				
		
	}
	
	public function get_penilai($pegawai){
		$obj_pegawai = new Pegawai;
		
		/**
		 * kalo id_j pegawainya walikota, atasannya walikota
		 * id_j walikota adalah 1960
		 * 
		 */
		if($pegawai->id_j == '1960'){
			//return $pegawai;
			$walikota = $pegawai;
			$walikota->nama_baru	= "Pemerintah Kota Bogor";
			return $walikota;		
			
			die;
		}
		
		
		if($pegawai->id_j !=NULL && $pegawai->jenjab == 'Struktural'){ 
						
			$sql = "select * from pegawai where id_j =
							(select id_bos from jabatan where id_j = ".$pegawai->id_j.")";
			$result = mysql_fetch_object(mysql_query($sql));
						
			
			/**
			 * kalo id_j sekda (1978) atasannya walikota
			 * */
			if($pegawai->id_j == '1978'){
				return $obj_pegawai->get_obj($result->id_pegawai);
				die;
			}
			
			/**
			 * kalo dia punya atasan walikota
			 * penilainya adalah sekda
			 * 
			 * */
			if($result->id_j == '1960'){
				$sekda = "select id_pegawai from pegawai where id_j = '1978'";
				$sekda = mysql_fetch_object(mysql_query($sekda));
				return $obj_pegawai->get_obj($sekda->id_pegawai);
				die;
			}
			 			 
			return $obj_pegawai->get_obj($result->id_pegawai);
						
		
		}elseif($pegawai->id_j == NULL && $pegawai->jenjab == 'Struktural'){
			//jfu
			$query = "select * from riwayat_mutasi_kerja where id_pegawai = '".$pegawai->id_pegawai."'";
			$query .= "and id_riwayat = (select MAX(id_riwayat) from riwayat_mutasi_kerja where id_pegawai = '".$pegawai->id_pegawai."') ";
			$r		= mysql_fetch_object(mysql_query($query))->id_j_bos;
			
			$bos = "select id_pegawai from pegawai where id_j = '".$r."'";
			$bos = mysql_fetch_object(mysql_query($bos));
			return $obj_pegawai->get_obj($bos->id_pegawai);
			
		}else{ // jabatan fungsional
		
			return $obj_pegawai->get_obj($pegawai->id_pegawai);
				
		}
	}
	
	
	
	/**
	 * menghitung nilai capaian skp
	 * @param int idtarget
	 * @retur array nilai hitung, dan nilai capaian
	 * */
	public function hitung_nilai(){
		$id_target 	= $_POST['idtarget'];
				
		$query = "select * from skp_target where id_skp_target = '".$_POST['idtarget']."'";
		$target = mysql_fetch_object(mysql_query($query));
		
		$aspek_kuantitas	= ($_POST['realKuantitas']/ $target->kuantitas)*100;
		$aspek_kualitas		= ($_POST['realKualitas'] / $target->kualitas)*100;
		
		/**
		 * hitung aspek biaya
		 * pertama hitung dulu efisiensi waktu
		 * */
		$efisiensi_waktu = 100 - ($_POST['realWaktu'] / $target->waktu * 100);
		
		/**
		 * kalo kegiatan tidak dilakukan berarti realisasinya o
		 * */
		 
		if($target->waktu > 0 && $_POST['realWaktu'] <= 0){
			$aspek_waktu = ((1.76 * $target->waktu - $target->real_waktu) / $target_waktu) * 0 * 100;
		
		/**
		 * kalo dilakukan kegiatannya
		 * */
		}else{
			/**
			 * kalo persentase efisiensi waktu kurang dari 24%
			 * */
			if($efisiensi_waktu <= 24 ){
				$aspek_waktu = ((1.76 * $target->waktu - $_POST['realWaktu']) / $target->waktu) * 100;
			/**
			 * kalo efisiensi waktu lebih dari 24%
			 * nilainya ke cukup sampe buruk
			 * */
			}elseif($efisiensi_waktu > 24 ){
				$aspek_waktu = 76 - ((((1.76 * $target->waktu - $_POST['realWaktu']) / $target->waktu) * 100) - 100);
				
			}
		}
		
			/**
		 * dalam hal kegiatan tidak dilakukan maka realisasi biaya nol 
		 * pertama yang dilakukan adalah hitung efisiensi biaya dulu
		 * */
						
		
		
		if($target->biaya > 0 && $_POST['realBiaya'] <= 0){
			
			$aspek_biaya = ((1.76 * $target->biaya - $_POST['realBiaya'] ) / $target->biaya) * 0 * 100;
		}else{
					
			 $efisiensi_biaya = 100 - ($_POST['realBiaya'] / $target->biaya * 100); 
			if($efisiensi_biaya <= 24){
				$aspek_biaya = ((1.76 * $target->biaya - $_POST['realBiaya']) / $target->biaya) * 100;
				
			}elseif($efisiensi_biaya > 24){
				$aspek_biaya = 76 - ((((1.76 * $target->biaya - $_POST['realBiaya']) / $target->biaya) * 100) - 100);
			}			
		}
		
		//jumlahkan semua aspek
		$penghitungan_aspek = $aspek_kuantitas + $aspek_kualitas + $aspek_waktu;
		
		if($target->biaya > 0) {
				$penghitungan_aspek += $aspek_biaya;
		}
		
		
		//$penghitungan_aspek = $efisiensi_biaya;
		//$penghitungan_aspek = $aspek_biaya;
		if($target->biaya > 0 ){
			$nilai_capaian = $penghitungan_aspek / 4;
		}else{
			$nilai_capaian = $penghitungan_aspek / 3;
		}
		
		/*
		$query = "update skp_target set hitung_nilai = '"+$penghitungan_aspek+"',
								nilai_capaian = '"+$nilai_capaian+"'
								where id_skp_target = '".$idtarget."'";
		*/
		
		$penghitungan_aspek = number_format($penghitungan_aspek,2);
		$nilai_capaian = number_format($nilai_capaian,2);
		return $nilai = array('hitung_nilai'=>$penghitungan_aspek, 'nilai_capaian'=>$nilai_capaian) ;
		
		
	}
	
	public function get_status($kode_status){
		
			return mysql_fetch_object(mysql_query("select * from skp_status where kode_status = '".$kode_status."'"));
	}
	
	public function set_status(){
		
			$query = ("update skp_header set status_pengajuan = '".$_POST['kodeStatus']."' where id_skp = '".$_POST['idskp']."'");
			//echo $query;
			if(mysql_query($query)){
				echo "berhasil";
			}else{
				echo "gagal update "+mysql_error();
			}
			
			//echo ($_POST['kodeStatus']." - ".$_POST['idskp']);
			
	}
	
}
