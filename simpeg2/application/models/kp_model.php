<?php 
class Ijinbelajar_model extends CI_Model{
	var $id_pegawai = '';
	var $id_jenis_hukuman = '';
	var $nama_hukuman = '';
	var $no_keputusan = '';
	var $tgl_hukuman = '';
	var $tmt = '';
	var $pejabat_pemberi_hukuman = '';
	var $jabatan_pemberi_hukuman = '';
	var $keterangan = '';
	
	public function __construct()
	{}
	
	
	
	public function daftarib($status_approve = NULL)
	{
		$query = "select 
					IF(LENGTH(pegawai.gelar_belakang) > 1,  concat(pegawai.gelar_depan,' ',pegawai.nama,concat(', ',pegawai.gelar_belakang)), concat(pegawai.gelar_depan,' ',pegawai.nama) ) as nama,
					nip_baru,pangkat_gol,jabatan,nama_baru,pegawai.id_pegawai as idp from ijin_belajar 
					inner join pegawai on pegawai.id_pegawai=ijin_belajar.id_pegawai 
					inner join current_lokasi_kerja on current_lokasi_kerja.id_pegawai = pegawai.id_pegawai 
					inner join unit_kerja on unit_kerja.id_unit_kerja = current_lokasi_kerja.id_unit_kerja ";
		
		if(! is_null($status_approve)){			
			$query .= "where approve =  ".$status_approve;
		}else{
			$query .= "where approve<=2 ";
		}		
		
		//echo "status".$status_approve;
		
		//echo $query;
					 		   
		$result = $this->db->query($query);	   
		return $result->result();
		
		
	}
		
	
	public function list_pengajuan($dari,$sampai)
	{
		$query = $this->db->query("select IF(LENGTH(pegawai.gelar_belakang) > 1,  concat(pegawai.gelar_depan,' ',pegawai.nama,concat(', ',pegawai.gelar_belakang)), concat(pegawai.gelar_depan,' ',pegawai.nama) ) as nama,
									nip_baru,pangkat_gol,jabatan,nama_baru,pegawai.id_pegawai as idp,tgl_pengajuan 
									from ijin_belajar 
									inner join pegawai on pegawai.id_pegawai=ijin_belajar.id_pegawai inner join current_lokasi_kerja on current_lokasi_kerja.id_pegawai = pegawai.id_pegawai inner join unit_kerja on unit_kerja.id_unit_kerja = current_lokasi_kerja.id_unit_kerja where approve=4 and tgl_approve between '$dari' and '$sampai' order by tgl_pengajuan");
		   return $query->result();
	}
	
	public function list_new_ajuan($dari,$sampai)
	{
		$query = $this->db->query("select IF(LENGTH(pegawai.gelar_belakang) > 1,  concat(pegawai.gelar_depan,' ',pegawai.nama,concat(', ',pegawai.gelar_belakang)), concat(pegawai.gelar_depan,' ',pegawai.nama) ) as nama,
									nip_baru,pangkat_gol,jabatan,nama_baru,pegawai.id_pegawai as idp, tgl_pengajuan from ijin_belajar 
									inner join pegawai on pegawai.id_pegawai=ijin_belajar.id_pegawai 
									inner join current_lokasi_kerja on current_lokasi_kerja.id_pegawai = pegawai.id_pegawai inner join unit_kerja on unit_kerja.id_unit_kerja = current_lokasi_kerja.id_unit_kerja where approve=0 and tgl_pengajuan between '$dari' and '$sampai' order by tgl_pengajuan");
		   return $query->result();
	}
	
	public function list_new_disetujui($dari,$sampai)
	{
		$query = $this->db->query("select IF(LENGTH(pegawai.gelar_belakang) > 1,  concat(pegawai.gelar_depan,' ',pegawai.nama,concat(', ',pegawai.gelar_belakang)), concat(pegawai.gelar_depan,' ',pegawai.nama) ) as nama,
								nip_baru,pangkat_gol,jabatan,nama_baru,pegawai.id_pegawai as idp, tgl_pengajuan,tgl_approve from ijin_belajar 
								inner join pegawai on pegawai.id_pegawai=ijin_belajar.id_pegawai 
								inner join current_lokasi_kerja on current_lokasi_kerja.id_pegawai = pegawai.id_pegawai 
								inner join unit_kerja on unit_kerja.id_unit_kerja = current_lokasi_kerja.id_unit_kerja where approve IN (1,2,3,4) and tgl_pengajuan between '$dari' and '$sampai' order by tgl_approve");
		   return $query->result();
	}
	
		public function tmtsk($idp,$pg)
	{
		$query = $this->db->query("select max(tmt) as tmt from sk where id_kategori_sk=5 and id_pegawai=$idp and keterangan like '$pg%' ");
		   return $query->row()->tmt;
	}
	
	public function pen_akhir($idp)
	{
		$query = $this->db->query("select tingkat_pendidikan as tp,jurusan_pendidikan as jp  from pendidikan where  id_pegawai=$idp order by level_p ");
		
   return $query->row();
	}	
	
	
	public function get_id_ib($idp)
	{
	
	
	}
	
		public function no_surat_skpd($nosurat,$idb)
		{
		$query = $this->db->query("update ijin_belajar set no_surat_skpd='$nosurat' where id=$idb");
		}
	
		public function get_detail($idp)
	{
		$query = $this->db->query("select gelar_depan,
				nama,gelar_belakang,golongan,pangkat,nama_jfu,
				institusi_lanjutan,jurusan,nip_baru,tingkat_pendidikan,
				unit_kerja.id_skpd as skpd,pegawai.id_j as id_j,jab.jabatan,
				unit_kerja.nama_baru as nama_skpd, pegawai.jenjab, pegawai.jabatan as jabatan2  				
				from ijin_belajar 
				inner join pegawai on pegawai.id_pegawai = ijin_belajar.id_pegawai 
				inner join golongan on golongan.golongan=pegawai.pangkat_gol 
				left join jfu_pegawai on jfu_pegawai.id_pegawai=ijin_belajar.id_pegawai 
				left join jfu_master on jfu_master.kode_jabatan=jfu_pegawai.kode_jabatan 
				left join jabatan jab on jab.id_j = pegawai.id_j
				inner join current_lokasi_kerja on current_lokasi_kerja.id_pegawai = pegawai.id_pegawai 
				inner join unit_kerja on unit_kerja.id_unit_kerja=current_lokasi_kerja.id_unit_kerja where ijin_belajar.id_pegawai=$idp");
		   return $query->row();
	}
	
	
	
	public function pen_lanjut($idp)
	{
		$query = $this->db->query("select 
									institusi_lanjutan,
									jurusan,
									tingkat_pendidikan,
									akreditasi,approve,
									tgl_approve,
									no_surat_skpd,
									tgl_pengajuan  
								from ijin_belajar where  id_pegawai=$idp order by tingkat_pendidikan ");
		   return $query->row();
	}
	
		public function ceksk($idp,$pg)
	{
		$query = $this->db->query("select file_name 
								from sk inner join berkas on berkas.id_berkas = sk.id_berkas 
								inner join isi_berkas on isi_berkas.id_berkas=berkas.id_berkas 
								where id_kategori_sk=5 and sk.id_pegawai=$idp and sk.keterangan like '$pg%' and sk.id_berkas>0  ");
		   if($query->result())
		   return $query->row()->file_name;
		   else
		   return NULL ;
	}
	
	
	
	public function cekantar($idp,$tp)
	{
		$query = $this->db->query("select file_name from berkas inner join isi_berkas on isi_berkas.id_berkas=berkas.id_berkas where id_pegawai=$idp and ket_berkas like '$tp' and id_kat=21  ");
		
		   if($query->result())
		   return $query->row()->file_name;
		   else
		   return NULL ;
	}


	public function cekspal($idp,$tp)
	{
		$query = $this->db->query("select file_name from berkas inner join isi_berkas on isi_berkas.id_berkas=berkas.id_berkas where id_pegawai=$idp and ket_berkas like '$tp' and id_kat=22  ");
		
		   if($query->result())
		   return $query->row()->file_name;
		   else
		   return NULL ;
	}
	
	
		public function cekajar($idp,$tp)
	{
		$query = $this->db->query("select file_name from berkas inner join isi_berkas on isi_berkas.id_berkas=berkas.id_berkas where id_pegawai=$idp and ket_berkas like '$tp' and id_kat=25  ");
		
		   if($query->result())
		   return $query->row()->file_name;
		   else
		   return NULL ;
	}
	
			public function cekajian($idp,$tp)
	{
		$query = $this->db->query("select file_name from berkas inner join isi_berkas on isi_berkas.id_berkas=berkas.id_berkas where id_pegawai=$idp and ket_berkas like '$tp' and id_kat=26  ");
		
		   if($query->result())
		   return $query->row()->file_name;
		   else
		   return NULL ;
	}
	
		public function cekdp3($idp,$tp)
	{
		$query = $this->db->query("select file_name from berkas inner join isi_berkas on isi_berkas.id_berkas=berkas.id_berkas where id_pegawai=$idp and ket_berkas like '$tp' and id_kat=20  ");
		
		   if($query->result())
		   return $query->row()->file_name;
		   else
		   return NULL ;
	}
	
			public function cekmpt($idp,$tp)
	{
		$query = $this->db->query("select file_name from berkas inner join isi_berkas on isi_berkas.id_berkas=berkas.id_berkas where id_pegawai=$idp and ket_berkas like '$tp' and id_kat=23  ");
		
		   if($query->result())
		   return $query->row()->file_name;
		   else
		   return NULL ;
	}
	
	public function cekjk($idp,$tp)
	{
		$query = $this->db->query("select file_name from berkas inner join isi_berkas on isi_berkas.id_berkas=berkas.id_berkas where id_pegawai=$idp and ket_berkas like '$tp' and id_kat=24  ");
		
		   if($query->result())
		   return $query->row()->file_name;
		   else
		   return NULL ;
	}

	
	public function cekib($idp,$tp)
	{
	$tp--;
		$query = $this->db->query("select file_name from ijin_belajar inner join isi_berkas on ijin_belajar.ijazah=isi_berkas.id_berkas where id_pegawai=$idp and tingkat_pendidikan=$tp");
		   if($query->result())
		   return $query->row()->file_name;
		   else
		   return NULL ;
	}

		public function get_pangkat($idp)
	{
		$query = $this->db->query("select pangkat_gol from pegawai where id_pegawai=$idp ");
		   return $query->row();
	}
	
	public function get_bos($skpd)
	{
		$query = $this->db->query("select jabatan from jabatan where id_unit_kerja=$skpd order by eselon, tahun desc ");
		   return $query->row();
	}
	
		public function kabid_mutasi()
	{
		$query = $this->db->query("select gelar_depan,nama,gelar_belakang, pegawai.nip_baru,
				IF(LENGTH(pegawai.gelar_belakang) > 1,  concat(pegawai.gelar_depan,' ',pegawai.nama,concat(', ',pegawai.gelar_belakang)), concat(pegawai.gelar_depan,' ',pegawai.nama) ) as nama_lengkap
				from jabatan inner join pegawai on pegawai.id_j=jabatan.id_j where jabatan.jabatan like 'Kepala Bidang Mutasi%' and tahun = (select max(tahun) from jabatan) ");
		   return $query->row();
	}
	
		public function get_ibe($idp)
	{
		$query = $this->db->query("select 
			tingkat_pendidikan,
			id from ijin_belajar where id_pegawai=$idp order by tingkat_pendidikan ");
		   return $query->row();
	}
	
		   
   
   public function tolak_ib($idp,$ket,$tp)
   {
	$query = $this->db->query("update ijin_belajar set approve=3,keterangan='$ket' where id_pegawai=$idp and tingkat_pendidikan=$tp");
   }
   
      
   public function acc($idp,$tp)
   {
	$query = $this->db->query("update ijin_belajar set approve=1 where id_pegawai=$idp and tingkat_pendidikan=$tp ");
   }
   
      public function ambil($idp,$tp)
   {
	   
	   $user = $this->session->userdata('user')->nama_pendek;
	   $skr=date("Y-m-d");
	$query = $this->db->query("update ijin_belajar set approve=4,approved_by='$user',tgl_approve='$skr' where id_pegawai=$idp and tingkat_pendidikan=$tp ");
   }
   
   
         
   public function apr($idp,$tp)
   {
	$query = $this->db->query("update ijin_belajar set approve=2 where id_pegawai=$idp and tingkat_pendidikan=$tp ");
   }
   
}
