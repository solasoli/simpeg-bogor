<?php

class Perubahan_Keluarga_M extends CI_Model
{
	private $keyword_nama;
	private $keyword_nip;
	private $id_keluarga;
	private $id_pegawai;
	private $nama;
	private $tempat_lahir;
	private $tanggal_lahir;
	private $id_status;
	private $akte_menikah;
	private $tanggal_menikah;
	private $pekerjaan;
	private $jenis_kelamin;
	private $dapat_tunjangan;
	private $status_konfirmasi;
	private $keterangan;
	private $tanggal_meninggal;
	private $akte_meninggal;
	private $tanggal_cerai;
	private $akte_cerai;
	private $bulan_ts;
	private $tahun_ts;
	
	
	
	
	//SETTER DAN GETTER
	public function set_keyword_nama($value)
	{
		$this->keyword_nama = $value;
	}
	
	public function get_keyword_nama()
	{
		return $this->keyword_nama;
	}
	
	public function set_keyword_nip($value)
	{
		$this->keyword_nip = $value;
	}
	
	public function get_keyword_nip()
	{
		return $this->keyword_nip;
	}
	
	public function set_id_pegawai($value)
	{
		$this->id_pegawai = $value;
	}
	
	public function get_id_pegawai()
	{
		return $this->id_pegawai;
	}
	
	public function set_id_keluarga($value)
	{
		$this->id_keluarga = $value;
	}
	
	public function get_id_keluarga()
	{
		return $this->id_keluarga;
	}
	
	public function set_id_status($value)
	{
		$this->id_status = $value;
	}
	
	public function get_id_status()
	{
		return $this->id_status;
	}
	
	public function set_dapat_tunjangan($value)
	{
		$this->dapat_tunjangan = $value;
	}
	
	public function get_dapat_tunjangan()
	{
		return $this->dapat_tunjangan;
	}
	
	public function set_nama($value)
	{
		$this->nama = $value;
	}
	
	public function get_nama()
	{
		return $this->nama;
	}
	
	public function set_tempat_lahir($value)
	{
		$this->tempat_lahir = $value;
	}
	
	public function get_tempat_lahir()
	{
		return $this->tempat_lahir;
	}
	
	public function set_tanggal_lahir($value)
	{
		$this->tanggal_lahir = $value;
	}
	
	public function get_tanggal_lahir()
	{
		return $this->tanggal_lahir;
	}
	
	public function set_tanggal_menikah($value)
	{
		$this->tanggal_menikah = $value;
	}
	
	public function get_tanggal_menikah()
	{
		return $this->tanggal_menikah;
	}
	
	public function set_akte_menikah($value)
	{
		$this->akte_menikah = $value;
	}
	
	public function get_akte_menikah()
	{
		return $this->akte_menikah;
	}
	
	public function set_pekerjaan($value)
	{
		$this->pekerjaan = $value;
	}
	
	public function get_pekerjaan()
	{
		return $this->pekerjaan;
	}
	
	public function set_jenis_kelamin($value)
	{
		$this->jenis_kelamin = $value;
	}
	
	public function get_jenis_kelamin()
	{
		return $this->jenis_kelamin ;
	}
	
	public function set_status_konfirmasi($value)
	{
		$this->status_konfirmasi = $value;
	}
	
	public function get_status_konfirmasi()
	{
		return $this->status_konfirmasi ;
	}
	
	public function set_keterangan($value)
	{
		$this->keterangan = $value;
	}
	
	public function get_keterangan()
	{
		return $this->keterangan;
	}
	
	public function set_tanggal_meninggal($value)
	{
		$this->tanggal_meninggal = $value;
	}
	
	public function get_tanggal_meninggal()
	{
		return $this->tanggal_meninggal;
	}
	
	public function set_akte_meninggal($value)
	{
		$this->akte_meninggal = $value;
	}
	
	public function get_akte_meninggal()
	{
		return $this->akte_meninggal;
	}
	
	public function set_tanggal_cerai($value)
	{
		$this->tanggal_cerai = $value;
	}
	
	public function get_tanggal_cerai()
	{
		return $this->tanggal_cerai;
	}
	
	public function set_akte_cerai($value)
	{
		$this->akte_cerai = $value;
	}
	
	public function get_akte_cerai()
	{
		return $this->akte_cerai;
	}
	
	public function set_bulan_ts($value)
	{
		$this->bulan_ts = $value;
	}
	
	public function get_bulan_ts()
	{
		return $this->bulan_ts;
	}
	
	public function set_tahun_ts($value)
	{
		$this->tahun_ts = $value;
	}
	
	public function get_tahun_ts()
	{
		return $this->tahun_ts;
	}
	//END SETTER DAN GETTER
	
	
	
	public function find_by_nama($k)
	{
		$qr = "SELECT * FROM pegawai 
		       WHERE nama like '$k%'
			   OR nip_baru like '$k%'";
		
		return $this->db->query($qr);
	}
	
	public function get_pegawai_by_id()
	{
		$qr = "SELECT * FROM pegawai 
		       WHERE id_pegawai = '".$this->get_id_pegawai()."'";
		
		return $this->db->query($qr);
	}
	

	public function get_pengesah_by_golongan($jb)
	{	
		$qr = "SELECT jabatan.id_j, jabatan.jabatan, pegawai.jabatan, pegawai.nama,
			   pegawai.nip_baru,pegawai.gelar_depan, pegawai.gelar_belakang FROM jabatan, pegawai 
		       WHERE jabatan.jabatan LIKE '$jb%' AND jabatan.tahun = (SELECT max(tahun) 
			   from jabatan where jabatan LIKE '$jb%') AND jabatan.id_j = pegawai.id_j ";
		
		return $this->db->query($qr);
	}
	
	public function get_suami_istri_by_id_pegawai()
	{
		$qr = "SELECT * FROM keluarga
		       WHERE id_pegawai='".$this->get_id_pegawai()."'
			   AND id_status=9 AND (dapat_tunjangan=1 OR dapat_tunjangan = 0 OR dapat_tunjangan = -1)
			   ORDER BY dapat_tunjangan DESC";
			   
		return $this->db->query($qr);
	}
	
	public function get_anak_by_id_pegawai()
	{
		$qr = "SELECT * FROM keluarga
		       WHERE id_pegawai='".$this->get_id_pegawai()."'
			   AND id_status=10 AND (dapat_tunjangan=1 OR dapat_tunjangan = 0 OR dapat_tunjangan=-1)
			   ORDER BY dapat_tunjangan DESC";
			   
		return $this->db->query($qr);
	}
	
	public function get_keluarga_by_id_keluarga()
	{
		$qr = "SELECT * FROM keluarga
		       WHERE id_keluarga = '".$this->get_id_keluarga()."'";
		
		return $this->db->query($qr);
	}
	
	public function get_si_dapat_tunjangan()
	{
		$qr = "SELECT id_keluarga FROM keluarga WHERE id_status = 9 AND dapat_tunjangan = 1
		       AND id_pegawai = '".$this->get_id_pegawai()."'";
		
		return $this->db->query($qr);
	}
	
	public function get_ak_dapat_tunjangan()
	{
		$qr = "SELECT id_keluarga FROM keluarga WHERE id_status = 10 AND dapat_tunjangan = 1
		       AND id_pegawai='".$this->get_id_pegawai()."'";
		
		return $this->db->query($qr);
	}
	
	public function update_pengurangan_jiwa()
	{
		$qr = "UPDATE keluarga SET dapat_tunjangan='".$this->get_dapat_tunjangan()."',
			   tgl_perubahan=now() WHERE id_keluarga= '".$this->get_id_keluarga()."'";
			
			return $this->db->query($qr);
	}
	
	public function get_data_pengurangan_jiwa()
	{
		$qr = "SELECT * FROM keluarga WHERE id_pegawai='".$this->set_id_pegawai()."'
			   AND dapat_tunjangan=-1";
		
		return $this->db->query($qr);
	}
	
	public function get_notifikasi_jumlah_pengajuan()
	{
		$qr = "SELECT k.tgl_perubahan FROM keluarga as k INNER JOIN pegawai as p ON k.id_pegawai=p.id_pegawai
		       WHERE k.status_konfirmasi=4 GROUP BY p.nama, k.tgl_perubahan,k.dapat_tunjangan ORDER BY k.tgl_perubahan DESC, dapat_tunjangan DESC";
		
		return $this->db->query($qr);
	}
	
	public function get_umur_anak()
	{
		$qr = "SELECT k.nama,p.nama as nama_peg, year(now()) - year(k.tgl_lahir) as usia_anak 
			   FROM keluarga as k INNER JOIN pegawai as p ON k.id_pegawai = p.id_pegawai
			   WHERE year(now()) - year(k.tgl_lahir) >= 21 AND year(now()) - year(k.tgl_lahir) <=30
			   AND id_status=10 AND dapat_tunjangan=1
				LIMIT 2000";
			
		return $this->db->query($qr);
	}
	
	public function cek_berkas_si($idsi)
	{
		$qr = "SELECT b.* FROM berkas_perubahan_keluarga as b 
		      INNER JOIN keluarga as k ON k.id_keluarga = b.id_keluarga
			  WHERE b.id_keluarga='$idsi' AND k.id_status=9";
			   
		return $this->db->query($qr);
	}
	
	public function cek_berkas_ak($idak)
	{
		$qr = "SELECT b.* FROM berkas_perubahan_keluarga as b 
		      INNER JOIN keluarga as k ON k.id_keluarga = b.id_keluarga
			  WHERE b.id_keluarga='".$idak."'";
			   
		return $this->db->query($qr);
	}
	
	public function get_berkas_by_id_keluarga($id_kel)
	{
		$qr = "SELECT * FROM berkas_perubahan_keluarga WHERE id_keluarga='$id_kel'";
		
		return $this->db->query($qr);
	}
	
	
	public function cek_umur_for_berkas($id_kel)
	{
		$qr = "SELECT year(now()) - year(tgl_lahir) as umur FROM keluarga
		       WHERE id_keluarga='$id_kel'";
		
		return $this->db->query($qr);
	}
	
	public function update_berkas_kematian($id_k,$path0)
	{
		$qr = "UPDATE berkas_perubahan_keluarga SET fc_surat_kematian='".$path0."'
		       WHERE id_keluarga = '".$id_k."'";
		
		return $this->db->query($qr);
	}
	
	public function update_berkas_suami_istri($id_kel, $path0)
	{
		$data = array('fc_surat_nikah'=>$path0);
		
		$this->db->where('id_keluarga', $id_kel);
		
		$this->db->update('berkas_perubahan_keluarga', $data); 
	
	}
	
	public function update_berkas_dasar($id_kel,$path0,$path1,$path2,$path3)
	{
		$berkas = array('id_keluarga'=>$id_kel,
						'srt_pengantar_unit_kerja'=>$path0,
						'fc_sk_pangkat_terakhir'=>$path1,
						'fc_skumptk'=>$path2,
						'fc_daftar_gaji'=>$path3,
						);
						
		$this->db->where('id_keluarga', $id_kel);
		
		$this->db->update('berkas_perubahan_keluarga', $berkas); 
		
	}
	
	public function update_berkas_anak($id_kel,$path1)
	{
		$data = array('fc_keterangan_kuliah'=>$path1);
		
		$this->db->where('id_keluarga', $id_kel);
		
		$this->db->update('berkas_perubahan_keluarga', $data); 
	}
	
	public function update_berkas_cerai($id_k,$path0)
	{
		$qr = "UPDATE berkas_perubahan_keluarga SET fc_surat_cerai='".$path0."',status_berkas=1
		       WHERE id_keluarga = '".$id_k."'";
		
		return $this->db->query($qr);
	}
	
	public function update_berkas_kerja($id_k,$path0)
	{
		$qr = "UPDATE berkas_perubahan_keluarga SET fc_keterangan_kerja='".$path0."',status_berkas=1
		       WHERE id_keluarga = '".$id_k."'";
		
		return $this->db->query($qr);
	}
	
	public function update_keterangan_cerai()
	{
		$qr = "UPDATE keluarga SET keterangan='".$this->get_keterangan()."',
			   tgl_cerai='".$this->get_tanggal_cerai()."',
			   akte_cerai='".$this->get_akte_cerai()."' 
			   WHERE id_keluarga= '".$this->get_id_keluarga()."'";
			   
		return $this->db->query($qr);
	}
	
	public function update_keterangan_meninggal()
	{
		$qr = "UPDATE keluarga SET keterangan = '".$this->get_keterangan()."',
		       tgl_meninggal = '".$this->get_tanggal_meninggal()."',
			   akte_menikah = '".$this->get_akte_meninggal()."'
			   WHERE id_keluarga = '".$this->get_id_keluarga()."'";
		
		return $this->db->query($qr); 
	}
	
	public function update_keterangan()
	{
		
		$qr = "UPDATE keluarga SET keterangan='".$this->get_keterangan()."'
			   WHERE id_keluarga= '".$this->get_id_keluarga()."'";
			   
		return $this->db->query($qr);
	}
	
	public function insert_data_suami_istri()
	{
		$qr = "INSERT INTO keluarga (id_keluarga, id_pegawai, id_status, nama, tempat_lahir,
		       tgl_lahir,tgl_menikah, akte_menikah,tgl_meninggal,akte_meninggal,	
			   tgl_cerai,akte_cerai,no_karsus,pekerjaan,jk,dapat_tunjangan,keterangan,
			   timestamp,status_konfirmasi,tgl_perubahan)
			   VALUES(NULL,'".$this->get_id_pegawai()."','".$this->get_id_status()."',
			          '".$this->get_nama()."','".$this->get_tempat_lahir()."',
					  '".$this->get_tanggal_lahir()."','".$this->get_tanggal_menikah()."',
					  '".$this->get_akte_menikah()."',NULL,NULL,NULL,NULL,NULL,
					  '".$this->get_pekerjaan()."','".$this->get_jenis_kelamin()."',
					  '".$this->get_dapat_tunjangan()."','".$this->get_keterangan()."',now(),3,now())";
		
		return $this->db->query($qr);
		
	}
	
	public function insert_berkas()
	{
		$data = array('id_perubahan' => NULL);

		$this->db->insert('berkas_perubahan_keluarga', $data); 
	}
	
	public function insert_data_anak()
	{
		$qr = "INSERT INTO keluarga(id_keluarga,id_pegawai,id_status,nama,tempat_lahir,
		       tgl_lahir,tgl_menikah, akte_menikah,tgl_meninggal,akte_meninggal,
			   tgl_cerai,akte_cerai,no_karsus,pekerjaan,jk,dapat_tunjangan,keterangan,
			   timestamp,status_konfirmasi,tgl_perubahan)
			   VALUES(NULL,'".$this->get_id_pegawai()."','".$this->get_id_status()."',
			          '".$this->get_nama()."','".$this->get_tempat_lahir()."',
					  '".$this->get_tanggal_lahir()."',NULL,
					   NULL,NULL,NULL,NULL,NULL,NULL,NULL,
					  '".$this->get_jenis_kelamin()."',
					  '".$this->get_dapat_tunjangan()."','".$this->get_keterangan()."',now(),3,now())";
		
		return $this->db->query($qr);
		
	}
	
	public function get_max_id_keluarga()
	{
		$qr = "SELECT MAX(id_keluarga) as max_ik FROM keluarga";
		
		return $this->db->query($qr);
	}
	
	public function insert_berkas_si($id_k,$path0,$path1,$path2,$path3,$path4)
	{
		$berkas = array('id_perubahan'=>NULL,
		                'id_keluarga'=>$id_k,
						'srt_pengantar_unit_kerja'=>$path0,
						'fc_sk_pangkat_terakhir'=>$path1,
						'fc_skumptk'=>$path2,
						'fc_daftar_gaji'=>$path3,
						'fc_surat_nikah'=>$path4,
		);
		
		$this->db->insert('berkas_perubahan_keluarga', $berkas); 
	}
	
	public function insert_berkas_penambahan($id_k,$path1, $path2, $path3)
	{
		
		$qr = "INSERT INTO berkas_perubahan_keluarga(id_perubahan, id_keluarga, fc_surat_nikah, fc_kelahiran_anak,
			   fc_keterangan_kuliah, fc_keterangan_kerja, fc_surat_kematian, fc_surat_cerai,status_berkas)
			   VALUES(NULL, '$id_k',";
			   is_null($path1) ? $qr .= "NULL,": $qr .= "'$path1', ";
			   is_null($path2) ? $qr .= "NULL,": $qr .= "'$path2', ";
			   is_null($path3) ? $qr .= "NULL,": $qr .= "'$path3', ";
			   
			   $qr .= "NULL,NULL,NULL,'0')";
		
		return $this->db->query($qr);
		
		// is_null($path1) ? $path1 = NULL : $path1;
		// is_null($path2) ? $path2 = NULL : $path2;
		// is_null($path3) ? $path3 = NULL : $path3;
		
		// $berkas = array('id_perubahan'=>NULL,
		                // 'id_keluarga'=>$id_k,
						// 'fc_surat_nikah'=>$path1,
						// 'fc_kelahiran_anak'=>$path2,
						// 'fc_keterangan_kuliah'=>$path3
						// );
		
		// $this->db->insert('berkas_perubahan_keluarga', $berkas); 	
	}
	
	
	/* public function insert_perubahan_keluarga()
	{
		$qr = "INSERT INTO perubahan_keluarga
		      (id_perubahan,id_keluarga,id_pegawai,status_konfirmasi,dapat_tunjangan,waktu)
			  VALUE(NULL,'".$this->get_id_pegawai()."','".$this->get_status_konfirmasi()."',
			  '".$this->get_dapat_tunjangan."',now())";
		
		return $this->db->query($qr);
		
	} */
	
	public function delete_data_keluarga()
	{
		$qr = "DELETE FROM keluarga 
		       WHERE id_keluarga = '".$this->get_id_keluarga()."'";
		
		return $this->db->query($qr);
	}
	
	public function update_data_keluarga_tunjangan()
	{
		
		$qr = "UPDATE keluarga SET nama = '".$this->get_nama()."',
 		      tempat_lahir = '".$this->get_tempat_lahir()."',
			  tgl_lahir = '".$this->get_tanggal_lahir()."',
			  pekerjaan = '".$this->get_pekerjaan()."',
			  jk = '".$this->get_jenis_kelamin()."',
			  dapat_tunjangan = '".$this->get_dapat_tunjangan()."'
			  WHERE id_keluarga = '".$this->get_id_keluarga()."'";
		
		return $this->db->query($qr);
	}
	
	public function update_data_keluarga()
	{
		$qr = "UPDATE keluarga SET nama = '".$this->get_nama()."',
 		      tempat_lahir = '".$this->get_tempat_lahir()."',
			  tgl_lahir = '".$this->get_tanggal_lahir()."',
			  pekerjaan = '".$this->get_pekerjaan()."',
			  jk = '".$this->get_jenis_kelamin()."'
			  WHERE id_keluarga = '".$this->get_id_keluarga()."'";
		
		return $this->db->query($qr);
	}
	
	public function delete_berkas($id_kel)
	{
		$qr	= "DELETE FROM berkas_perubahan_keluarga
		       WHERE id_keluarga='".$id_kel."'";
		
		return $this->db->query($qr);
	}
	
	public function get_riwayat_surat()
	{
		$qr = "SELECT * FROM keluarga WHERE 
		       tgl_perubahan= AND (id_status=9 OR id_status=10) AND
			   dapat_tunjangan= ";
	}

//UNTUK ISI SURAT PERUBAHAN KELUARGA
	public function mengambil_tanggal_sekarang()
	{
		$qr = 'SELECT year(now()) as tahun, month(now()) as bulan';
			
		return $this->db->query($qr);
	}
	
	public function get_unit_kerja()
	{
		$qr = "SELECT u.nama_baru
		      FROM unit_kerja as u INNER JOIN current_lokasi_kerja as c
			  ON u.id_unit_kerja = c.id_unit_kerja
			  WHERE c.id_pegawai ='".$this->get_id_pegawai()."'";
		
		return $this->db->query($qr);
	}
	
	public function tanggal_max()
	{
		$qr = "SELECT tgl_perubahan,dapat_tunjangan FROM keluarga WHERE id_pegawai='".$this->get_id_pegawai()."'
		       AND tgl_perubahan = (SELECT max(tgl_perubahan) FROM keluarga)";
		
		return $this->db->query($qr);
	}
	
	public function get_keluarga_by_id_pegawai_si($tgl,$js)
	{
		$qr	= "SELECT * FROM keluarga WHERE id_pegawai='".$this->get_id_pegawai()."'
		      AND id_status=9 AND dapat_tunjangan='$js' AND tgl_perubahan='$tgl'";
		
		return $this->db->query($qr);
	}
	
	public function get_keluarga_si_ak($tgl,$js)
	{
		$qr	= "SELECT * FROM keluarga WHERE id_pegawai='".$this->get_id_pegawai()."'
		      AND (id_status=9 OR id_status = 10) AND dapat_tunjangan='$js' AND tgl_perubahan='$tgl'";
		
		return $this->db->query($qr);
	}
	
	public function get_all_keluarga()
	{
		$qr = "SELECT * FROM keluarga WHERE id_keluarga = '".$this->get_id_keluarga()."'";
		
		return $this->db->query($qr);
	}
	
	public function get_bulan($tgl)
	{
		$qr = "SELECT month('$tgl') as bulan, year('$tgl') as tahun, substr('$tgl',9,2) as tanggal";
		
		return $this->db->query($qr);
	}
	
	public function get_keluarga_by_id_pegawai_ak($tgl,$js)
	{
		$qr	= "SELECT * FROM keluarga WHERE id_pegawai='".$this->get_id_pegawai()."'
		      AND id_status=10 AND dapat_tunjangan='$js' AND tgl_perubahan='$tgl'";
		
		return $this->db->query($qr);
	}
	
	public function get_keluarga_lainnya()
	{
		$qr = "SELECT * FROM keluarga where id_status NOT IN(9,10) 
			  AND id_pegawai ='".$this->get_id_pegawai()."'";
			  
		return $this->db->query($qr);
	}
	
	
	// public function surat_terbaru($tgl)
	// {
		// $qr = "SELECT * FROM keluarga WHERE id_pegawai='".$this->get_id_pegawai()."'
		       // AND tgl_perubahan = '$tgl' AND 
			  // (dapat_tunjangan=1 OR dapat_tunjangan=-1)";
			   
		// return $this->db->query($qr);
	// }
	
	public function get_tanggal_riwayat_surat_by_jenis_surat($js,$ip)
	{
		
		
		$qr = "SELECT distinct(tgl_perubahan) FROM keluarga
		       WHERE id_pegawai='$ip'
			   AND (id_status=9 OR id_status=10) AND dapat_tunjangan= '$js'
			   ORDER BY tgl_perubahan DESC;";

		return $this->db->query($qr);
	}
	
	public function get_berkas_dasar_pegawai($id_peg)
	{
		$qr = "SELECT * FROM berkas_dasar_pegawai WHERE id_pegawai = '$id_peg'";
		
		return $this->db->query($qr);
	}
	
	public function insert_berkas_dasar_pegawai($id_p,$p0,$p1,$p2,$p3)
	{	
		$qr = "INSERT INTO berkas_dasar_pegawai (id_berkas, id_pegawai, surat_pengantar_dari_unit_kerja, sk_terakhir,
												skumptk, gaji_bulan_terakhir, tgl_update)
			  VALUES(NULL, '$id_p', '$p0', '$p1', '$p2', '$p3', now())";
		
		return $this->db->query($qr);
	}
	
	public function update_berkas_dasar_pegawai($id_p,$p0,$p1,$p2,$p3)
	{
		$qr = "UPDATE berkas_dasar_pegawai SET surat_pengantar_dari_unit_kerja='$p0',
		      sk_terakhir='$p1', skumptk='$p2',gaji_bulan_terakhir='$p3',tgl_update=now()
			  WHERE id_pegawai = '$id_p'";
		
		return $this->db->query($qr);
	}
	
//END ISI SURAT PERUBAHAN KELUARGA


//DAFTAR PENGAJUAN KELUARGA
	public function daftar_pengajuan()
	{
		$qr = "SELECT k.tgl_perubahan,k.dapat_tunjangan, k. id_pegawai, p.nip_baru,p.nama , k.tgl_perubahan, p.id_pegawai, k.dapat_tunjangan,k.id_status,
		       k.status_konfirmasi FROM keluarga as k INNER JOIN pegawai as p ON k.id_pegawai=p.id_pegawai
		       WHERE k.status_konfirmasi=4 OR k.status_konfirmasi=1 OR k.status_konfirmasi=-3
			   GROUP BY k.tgl_perubahan,k.dapat_tunjangan, p.nama ORDER BY k.tgl_perubahan DESC ";
		
		return $this->db->query($qr);
	}
	
	
	public function setuju($tgl, $dt, $flag, $id_peg)
	{
		$qr = "UPDATE keluarga SET status_konfirmasi=1, dapat_tunjangan='$flag'
		      WHERE tgl_perubahan = '$tgl' AND dapat_tunjangan='$dt' AND id_pegawai = '$id_peg'";
		
		return $this->db->query($qr);
	}
	
	public function tidak_setuju($tgl, $flag, $dt, $st_kon, $ket_tolak, $id_peg)
	{
		$qr = "UPDATE keluarga SET status_konfirmasi= '$st_kon', keterangan_penolakan= '$ket_tolak',
		       dapat_tunjangan = '$flag', tgl_perubahan = now() WHERE tgl_perubahan = '$tgl' AND dapat_tunjangan= '$dt' AND id_pegawai='$id_peg'";
			   
		return $this->db->query($qr);
	}
	
	public function tolak($tgl)
	{
		$qr = "UPDATE keluarga SET status_konfirmasi=-1, tgl_perubahan=now() 
		      WHERE tgl_perubahan = '$tgl'";
		
		return $this->db->query($qr);
	}
	
//END DAFTAR PENGAJUAN KELUARGA

//LAPORAN
	public function get_tahun_tgl_perubahan()
	{
		$qr = "SELECT distinct(year(tgl_perubahan)) as tahun FROM keluarga";
		
		return $this->db->query($qr);
	}
	
	public function get_laporan_by_bulan_tahun()
	{
		
		$qr = "SELECT distinct(k.id_pegawai), p.nama, p.pangkat_gol, 
		              u.nama_baru, p.nip_baru,k.jk
		       FROM pegawai as p, keluarga as k, 
			        current_lokasi_kerja as c, unit_kerja as u 
			   WHERE p.id_pegawai = k.id_pegawai 
			         AND c.id_pegawai = k.id_pegawai 
					 AND c.id_unit_kerja = u.id_unit_kerja 
					 AND year(k.tgl_perubahan) = '".$this->get_tahun_ts()."' 
					 AND month(k.tgl_perubahan) = '".$this->get_bulan_ts()."'
					 GROUP BY k.id_pegawai LIMIT 10";
		
		return $this->db->query($qr);
	}
	
	public function count_penambahan_anak()
	{
		$qr = "SELECT COUNT(dapat_tunjangan) as jumlah_penambahan_anak 
		       FROM keluarga WHERE id_pegawai = '".$this->get_id_pegawai()."' 
			   AND dapat_tunjangan=1 
			   AND id_status=10 AND year(tgl_perubahan) = '".$this->get_tahun_ts()."' 
			   AND month(tgl_perubahan) = '".$this->get_bulan_ts()."'";
		
		return $this->db->query($qr);
	}
	
	public function count_penambahan_suami_istri()
	{
		$qr = "SELECT COUNT(dapat_tunjangan) as jumlah_penambahan_suami_istri,jk
		       FROM keluarga WHERE id_pegawai = '".$this->get_id_pegawai()."' 
			   AND dapat_tunjangan=1 
			   AND id_status=9 AND year(tgl_perubahan) = '".$this->get_tahun_ts()."' 
			   AND month(tgl_perubahan) = '".$this->get_bulan_ts()."'";
		
		return $this->db->query($qr);
	}
	
	public function count_pengurangan_anak()
	{
		$qr = "SELECT COUNT(dapat_tunjangan) as jumlah_pengurangan_anak 
		       FROM keluarga WHERE id_pegawai = '".$this->get_id_pegawai()."' 
			   AND dapat_tunjangan=-1
			   AND id_status=10 AND year(tgl_perubahan) = '".$this->get_tahun_ts()."' 
			   AND month(tgl_perubahan) = '".$this->get_bulan_ts()."'";
		
		return $this->db->query($qr);
	}
	
	public function count_pengurangan_suami_istri()
	{
		$qr = "SELECT COUNT(dapat_tunjangan) as jumlah_pengurangan_suami_istri
		       FROM keluarga WHERE id_pegawai = '".$this->get_id_pegawai()."' 
			   AND dapat_tunjangan=-1
			   AND id_status=9 AND year(tgl_perubahan) = '".$this->get_tahun_ts()."' 
			   AND month(tgl_perubahan) = '".$this->get_bulan_ts()."'";
		
		return $this->db->query($qr);
	}
//END LAPORAN


//REKAPITULASI
public function rekap_penambahan_januari()
	{
		$qr = "SELECT COUNT(dapat_tunjangan) as jumlah 
		       FROM keluarga WHERE dapat_tunjangan=1 AND
			   (id_status=9 OR id_status=10) 
			   AND year(tgl_perubahan)=year(now()) 
			   AND month(tgl_perubahan)=1";
		
		return $this->db->query($qr);
	}
	
	public function rekap_penambahan_februari()
	{
		$qr = "SELECT COUNT(dapat_tunjangan) as jumlah 
		       FROM keluarga WHERE dapat_tunjangan=1 AND
			   (id_status=9 OR id_status=10) 
			   AND year(tgl_perubahan)=year(now()) 
			   AND month(tgl_perubahan)=2";
		
		return $this->db->query($qr);
	}
	
	public function rekap_penambahan_maret()
	{
		$qr = "SELECT COUNT(dapat_tunjangan) as jumlah 
		       FROM keluarga WHERE dapat_tunjangan=1 AND
			   (id_status=9 OR id_status=10) 
			   AND year(tgl_perubahan)=year(now()) 
			   AND month(tgl_perubahan)=3";
		
		return $this->db->query($qr);
	}
	
	public function rekap_penambahan_april()
	{
		$qr = "SELECT COUNT(dapat_tunjangan) as jumlah 
		       FROM keluarga WHERE dapat_tunjangan=1 AND
			   (id_status=9 OR id_status=10) 
			   AND year(tgl_perubahan)=year(now()) 
			   AND month(tgl_perubahan)=4";
		
		return $this->db->query($qr);
	}
	
	public function rekap_penambahan_mei()
	{
		$qr = "SELECT COUNT(dapat_tunjangan) as jumlah 
		       FROM keluarga WHERE dapat_tunjangan=1 AND
			   (id_status=9 OR id_status=10) 
			   AND year(tgl_perubahan)=year(now()) 
			   AND month(tgl_perubahan)=5";
		
		return $this->db->query($qr);
	}
	
	public function rekap_penambahan_juni()
	{
		$qr = "SELECT COUNT(dapat_tunjangan) as jumlah 
		       FROM keluarga WHERE dapat_tunjangan=1 AND
			   (id_status=9 OR id_status=10) 
			   AND year(tgl_perubahan)=year(now()) 
			   AND month(tgl_perubahan)=6";
		
		return $this->db->query($qr);
	}
	
	public function rekap_penambahan_juli()
	{
		$qr = "SELECT COUNT(dapat_tunjangan) as jumlah 
		       FROM keluarga WHERE dapat_tunjangan=1 AND
			   (id_status=9 OR id_status=10) 
			   AND year(tgl_perubahan)=year(now()) 
			   AND month(tgl_perubahan)=7";
		
		return $this->db->query($qr);
	}
	
	public function rekap_penambahan_agustus()
	{
		$qr = "SELECT COUNT(dapat_tunjangan) as jumlah 
		       FROM keluarga WHERE dapat_tunjangan=1 AND
			   (id_status=9 OR id_status=10) 
			   AND year(tgl_perubahan)=year(now()) 
			   AND month(tgl_perubahan)=8";
		
		return $this->db->query($qr);
	}
	
	public function rekap_penambahan_september()
	{
		$qr = "SELECT COUNT(dapat_tunjangan) as jumlah 
		       FROM keluarga WHERE dapat_tunjangan=1 AND
			   (id_status=9 OR id_status=10) 
			   AND year(tgl_perubahan)=year(now()) 
			   AND month(tgl_perubahan)=9";
		
		return $this->db->query($qr);
	}
	
	public function rekap_penambahan_oktober()
	{
		$qr = "SELECT COUNT(dapat_tunjangan) as jumlah 
		       FROM keluarga WHERE dapat_tunjangan=1 AND
			   (id_status=9 OR id_status=10) 
			   AND year(tgl_perubahan)=year(now()) 
			   AND month(tgl_perubahan)=10";
		
		return $this->db->query($qr);
	}
	
	public function rekap_penambahan_november()
	{
		$qr = "SELECT COUNT(dapat_tunjangan) as jumlah 
		       FROM keluarga WHERE dapat_tunjangan=1 AND
			   (id_status=9 OR id_status=10) 
			   AND year(tgl_perubahan)=year(now()) 
			   AND month(tgl_perubahan)=11";
		
		return $this->db->query($qr);
	}
	
	public function rekap_penambahan_desember()
	{
		$qr = "SELECT COUNT(dapat_tunjangan) as jumlah 
		       FROM keluarga WHERE dapat_tunjangan=1 AND
			   (id_status=9 OR id_status=10) 
			   AND year(tgl_perubahan)=year(now()) 
			   AND month(tgl_perubahan)=12";
		
		return $this->db->query($qr);
	}
	
	public function rekap_pengurangan_januari()
	{
		$qr = "SELECT COUNT(dapat_tunjangan) as jumlah 
		       FROM keluarga WHERE dapat_tunjangan=-1 AND
			   (id_status=9 OR id_status=10) 
			   AND year(tgl_perubahan)=year(now()) 
			   AND month(tgl_perubahan)=1";
		
		return $this->db->query($qr);
	}
	
	public function rekap_pengurangan_februari()
	{
		$qr = "SELECT COUNT(dapat_tunjangan) as jumlah 
		       FROM keluarga WHERE dapat_tunjangan=-1 AND
			   (id_status=9 OR id_status=10) 
			   AND year(tgl_perubahan)=year(now()) 
			   AND month(tgl_perubahan)=2";
		
		return $this->db->query($qr);
	}
	
	public function rekap_pengurangan_maret()
	{
		$qr = "SELECT COUNT(dapat_tunjangan) as jumlah 
		       FROM keluarga WHERE dapat_tunjangan=-1 AND
			   (id_status=9 OR id_status=10) 
			   AND year(tgl_perubahan)=year(now()) 
			   AND month(tgl_perubahan)=3";
		
		return $this->db->query($qr);
	}
	
	public function rekap_pengurangan_april()
	{
		$qr = "SELECT COUNT(dapat_tunjangan) as jumlah 
		       FROM keluarga WHERE dapat_tunjangan=-1 AND
			   (id_status=9 OR id_status=10) 
			   AND year(tgl_perubahan)=year(now()) 
			   AND month(tgl_perubahan)=4";
		
		return $this->db->query($qr);
	}
	
	public function rekap_pengurangan_mei()
	{
		$qr = "SELECT COUNT(dapat_tunjangan) as jumlah 
		       FROM keluarga WHERE dapat_tunjangan=-1 AND
			   (id_status=9 OR id_status=10) 
			   AND year(tgl_perubahan)=year(now()) 
			   AND month(tgl_perubahan)=5";
		
		return $this->db->query($qr);
	}
	
	public function rekap_pengurangan_juni()
	{
		$qr = "SELECT COUNT(dapat_tunjangan) as jumlah 
		       FROM keluarga WHERE dapat_tunjangan=-1 AND
			   (id_status=9 OR id_status=10) 
			   AND year(tgl_perubahan)=year(now()) 
			   AND month(tgl_perubahan)=6";
		
		return $this->db->query($qr);
	}
	
	public function rekap_pengurangan_juli()
	{
		$qr = "SELECT COUNT(dapat_tunjangan) as jumlah 
		       FROM keluarga WHERE dapat_tunjangan=-1 AND
			   (id_status=9 OR id_status=10) 
			   AND year(tgl_perubahan)=year(now()) 
			   AND month(tgl_perubahan)=7";
		
		return $this->db->query($qr);
	}
	
	public function rekap_pengurangan_agustus()
	{
		$qr = "SELECT COUNT(dapat_tunjangan) as jumlah 
		       FROM keluarga WHERE dapat_tunjangan=-1 AND
			   (id_status=9 OR id_status=10) 
			   AND year(tgl_perubahan)=year(now()) 
			   AND month(tgl_perubahan)=8";
		
		return $this->db->query($qr);
	}
	
	public function rekap_pengurangan_september()
	{
		$qr = "SELECT COUNT(dapat_tunjangan) as jumlah 
		       FROM keluarga WHERE dapat_tunjangan=-1 AND
			   (id_status=9 OR id_status=10) 
			   AND year(tgl_perubahan)=year(now()) 
			   AND month(tgl_perubahan)=9";
		
		return $this->db->query($qr);
	}
	
	public function rekap_pengurangan_oktober()
	{
		$qr = "SELECT COUNT(dapat_tunjangan) as jumlah 
		       FROM keluarga WHERE dapat_tunjangan=-1 AND
			   (id_status=9 OR id_status=10) 
			   AND year(tgl_perubahan)=year(now()) 
			   AND month(tgl_perubahan)=10";
		
		return $this->db->query($qr);
	}
	
	public function rekap_pengurangan_november()
	{
		$qr = "SELECT COUNT(dapat_tunjangan) as jumlah 
		       FROM keluarga WHERE dapat_tunjangan=-1 AND
			   (id_status=9 OR id_status=10) 
			   AND year(tgl_perubahan)=year(now()) 
			   AND month(tgl_perubahan)=11";
		
		return $this->db->query($qr);
	}
	
	public function rekap_pengurangan_desember()
	{
		$qr = "SELECT COUNT(dapat_tunjangan) as jumlah 
		       FROM keluarga WHERE dapat_tunjangan=-1 AND
			   (id_status=9 OR id_status=10) 
			   AND year(tgl_perubahan)=year(now()) 
			   AND month(tgl_perubahan)=12";
		
		return $this->db->query($qr);
	}
	
	public function jumlah_rekap_penambahan()
	{
		$qr = "SELECT COUNT(dapat_tunjangan) as total 
		       FROM keluarga WHERE dapat_tunjangan=1
			   AND(id_status=9 OR id_status=10)";
		
		return $this->db->query($qr);
	}
	
	public function jumlah_rekap_pengurangan()
	{
		$qr = "SELECT COUNT(dapat_tunjangan) as total 
		       FROM keluarga WHERE dapat_tunjangan=-1
			   AND(id_status=9 OR id_status=10)";
		
		return $this->db->query($qr);
	}
	
	public function get_keluarga_by_tgl_perubahan($tgl, $id_peg)
	{
		$qr = "SELECT * FROM keluarga WHERE tgl_perubahan= '$tgl' AND 
		      id_pegawai = '$id_peg'";
		
		return $this->db->query($qr);
	}
	
	public function get_keluarga_by_status_tgl($tgl, $id_peg, $status)
	{
		$qr = "SELECT k.nama, k.id_status, k.tgl_perubahan, k.dapat_tunjangan, k.keterangan, b.fc_surat_nikah,
		       b.fc_kelahiran_anak, b.fc_keterangan_kuliah, b.fc_surat_kematian, b.fc_keterangan_kerja,
			   b.fc_surat_cerai
			   FROM keluarga as k INNER JOIN berkas_perubahan_keluarga as b 
		       ON k.id_keluarga = b.id_keluarga WHERE k.tgl_perubahan= '$tgl' AND 
		      k.id_pegawai = '$id_peg' AND k.dapat_tunjangan= '$status'";
		
		return $this->db->query($qr);
	}
	
//END MODEL MENU REKAPITULASI

	/*public function update_dapat_tunjangan()
	{
		$qr = "UPDATE perubahan_keluarga SET dapat_tunjangan=-1
				      WHERE dapat_tunjangan=-1";
		
		$this->db->query($qr);
					  
	}*/
}
?>