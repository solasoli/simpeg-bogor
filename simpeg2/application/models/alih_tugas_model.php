<?php 
class Alih_tugas_model extends CI_Model{
	var $id_pegawai = '';
	var $id_jenis_hukuman = '';
	var $nama_hukuman = '';
	var $no_keputusan = '';
	var $tgl_hukuman = '';
	var $tmt = '';
	var $pejabat_pemberi_hukuman = '';
	var $jabatan_pemberi_hukuman = '';
	var $keterangan = '';
	var $id_dasar_sk = '';
		
	public function __construct()
	{}
	
	public function get_daftar_kgb($skpd, $tahun, $bulan){
		if($skpd == -1)
			$query = $this->db->query("SELECT p.id_pegawai, p.nama AS NAMA, p.nip_baru AS NIP, p.pangkat_gol AS GOLONGAN, s.tmt AS  'TMT_KGB_TERAKHIR', u.nama_baru AS  'UNIT_KERJA'
										FROM pegawai p
										INNER JOIN (
											SELECT id_pegawai, MAX( tmt ) AS tmt, id_kategori_sk
											FROM sk
											WHERE (id_kategori_sk = 9 or id_kategori_sk = 6)
											GROUP BY id_pegawai
										) AS s ON s.id_pegawai = p.id_pegawai
										INNER JOIN current_lokasi_kerja c ON c.id_pegawai = p.id_pegawai
										INNER JOIN unit_kerja u ON u.id_unit_kerja = c.id_unit_kerja
										WHERE p.flag_pensiun = 0 and p.jabatan not like '%guru%'
										AND DATE_FORMAT( s.tmt,  '%Y%m' ) = CONCAT( $tahun -2,  '$bulan' ) 										
										ORDER BY u.id_skpd, u.nama_baru ASC ,  `p`.`nama` ASC ");
		else
			$query = $this->db->query("SELECT p.id_pegawai, p.nama AS NAMA, p.nip_baru AS NIP, p.pangkat_gol AS GOLONGAN, s.tmt AS  'TMT_KGB_TERAKHIR', u.nama_baru AS  'UNIT_KERJA'
										FROM pegawai p
										INNER JOIN (
											SELECT id_pegawai, MAX( tmt ) AS tmt, id_kategori_sk
											FROM sk
											WHERE (id_kategori_sk = 9 or id_kategori_sk = 6)
											GROUP BY id_pegawai
										) AS s ON s.id_pegawai = p.id_pegawai
										INNER JOIN current_lokasi_kerja c ON c.id_pegawai = p.id_pegawai
										INNER JOIN unit_kerja u ON u.id_unit_kerja = c.id_unit_kerja
										WHERE p.flag_pensiun = 0 and p.jabatan not like '%guru%'
										AND DATE_FORMAT( s.tmt,  '%Y%m' ) = CONCAT( $tahun -2,  '$bulan' ) 
										AND u.id_skpd = $skpd
										ORDER BY u.id_skpd, u.nama_baru ASC ,  `p`.`nama` ASC ");

		$data = null;
		foreach ($query->result() as $row)
		{
			$data[] = $row;
		}
		return $data;
	}
	
	public function get_laporan_alih_tugas($skpd, $tahun, $bulan){
		$q = "select * 
			from pegawai p 			
			inner join sk s on s.id_pegawai = p.id_pegawai
			left join unit_kerja u on u.id_unit_kerja = s.id_unit_kerja
			where s.id_kategori_sk = 1
			and year(s.tmt) = $tahun ";
			
		if($skpd != -1)
			$q = $q." and u.id_skpd = $skpd ";
		
		if($bulan > 0)
			$q = $q." and month(s.tmt) = $bulan ";
				
		$q = $q." order by s.tmt, u.id_skpd";
		
		$query = $this->db->query($q);

		$data = null;
		foreach ($query->result() as $row)
		{
			$data[] = $row;
		}
		return $data;
	}
	
	public function get_by_id_pegawai($id_pegawai){
		$query = $this->db->query(" SELECT *
									FROM
									(
										SELECT s.id_berkas, s.tmt, s.no_sk, u.nama_baru 
										FROM sk s
										INNER JOIN	sk_alih_tugas at on at.id_sk = s.id_sk									
										LEFT JOIN unit_kerja u ON u.id_unit_kerja = at.id_unit_kerja_baru
										WHERE s.id_pegawai = ".$id_pegawai.
									  " UNION
										SELECT s.id_berkas, s.tmt, s.no_sk, u.nama_baru
										FROM sk s
										INNER JOIN sk_cpns cpns ON cpns.id_sk = s.id_sk
										LEFT JOIN unit_kerja u ON u.id_unit_kerja = s.id_unit_kerja
										WHERE s.id_pegawai = ".$id_pegawai.
									" 	UNION
										SELECT s.id_berkas, s.tmt, s.no_sk, u.nama_baru
										FROM sk s
										INNER JOIN sk_jabatan_struktural struk ON struk.id_sk = s.id_sk
										LEFT JOIN unit_kerja u ON u.id_unit_kerja = s.id_unit_kerja
										WHERE s.id_pegawai = ".$id_pegawai.
									") as x
									ORDER BY tmt DESC");

		$data = null;
		foreach ($query->result() as $row)
		{
			$data[] = $row;
		}
		return $data;
	}
	
	public function get_list_dasar_sk($id_pegawai){
		$query = $this->db->query("SELECT * 
									FROM sk s			
									inner join kategori_sk k on k.id_kategori_sk = s.id_kategori_sk						
									WHERE s.id_pegawai = ".$id_pegawai.
									" AND s.id_kategori_sk IN (5,6,7,9,14)
									ORDER BY tmt desc, FIELD(s.id_kategori_sk, 5,9,14,7,6)" );

		$data = null;
		foreach ($query->result() as $row)
		{
			$data[] = $row;
		}
		return $data;
	}
	
	public function get_list_tahun_sk(){
		$query = $this->db->query("select distinct year(tmt) as tahun 
									from sk 
									where id_kategori_sk = 9
									order by year(tmt) desc" );
		
		return $query->result();
	}
	
	public function get_terhukum(){
		$query = $this->db->query("SELECT p.nama, p.nip_baru, j.tingkat_hukuman, j.deskripsi, h.no_keputusan, h.tgl_hukuman, h.tmt, u.nama_baru
									FROM hukuman h
									inner join jenis_hukuman j on  h.id_jenis_hukuman = j.id_jenis_hukuman
									INNER JOIN pegawai p ON p.id_pegawai = h.id_pegawai
									LEFT JOIN current_lokasi_kerja c ON c.id_pegawai = p.id_pegawai
									LEFT JOIN unit_kerja u ON u.id_unit_kerja = c.id_unit_kerja
									ORDER BY tmt DESC");

		$data = null;
		foreach ($query->result() as $row)
		{
			$data[] = $row;
		}
		return $data;
	}
	
	public function recap_per_tahun(){
		$query = $this->db->query("SELECT tahun, 
									SUM( IF( bulan =  '1', jumlah, 0 ) ) AS januari, 
									SUM( IF( bulan =  '2', jumlah, 0 ) ) AS februari, 
									SUM( IF( bulan =  '3', jumlah, 0 ) ) AS maret,
									SUM( IF( bulan =  '4', jumlah, 0 ) ) AS april,									
									SUM( IF( bulan =  '5', jumlah, 0 ) ) AS mei,									
									SUM( IF( bulan =  '6', jumlah, 0 ) ) AS juni,									
									SUM( IF( bulan =  '7', jumlah, 0 ) ) AS juli,									
									SUM( IF( bulan =  '8', jumlah, 0 ) ) AS agustus,									
									SUM( IF( bulan =  '9', jumlah, 0 ) ) AS september,									
									SUM( IF( bulan =  '10', jumlah, 0 ) ) AS oktober,									
									SUM( IF( bulan =  '11', jumlah, 0 ) ) AS november,									
									SUM( IF( bulan =  '12', jumlah, 0 ) ) AS desember,									
									sum(jumlah) as jumlah
									FROM (
										select year(tmt) as tahun,  month(tmt) as bulan, count(*) as jumlah
										from sk 
										where id_kategori_sk = 1 and year(tmt) > year(curdate()) - 5
										group by tahun, bulan
										ORDER BY `tahun` ASC
									)t
									GROUP BY tahun DESC");

		$data = null;
		foreach ($query->result() as $row)
		{
			$data[] = $row;
		}
		return $data;
	}
	
	public function insert(){
		$this->id_pegawai 				= $this->input->post('idPegawai');
		$this->id_jenis_hukuman 		= $this->input->post('cboJenisHukuman');
		$this->nama_hukuman				= '';//$this->input->post('cboJenjab');
		$this->no_keputusan 			= $this->input->post('txtNoKeputusan');
		$this->tgl_hukuman 				= $this->input->post('txtTanggalPenetapan');
		$this->tmt						= $this->input->post('txtTmt');
		$this->pejabat_pemberi_hukuman	= $this->input->post('txtPejabatPemberiHukuman');
		$this->jabatan_pemberi_hukuman	= $this->input->post('txtJabatan');
		$this->keterangan				= $this->input->post('txtKeterangan');
		
		$this->db->insert('hukuman', $this);
	}
	
	public function delete($id_hukuman){
		return $this->db->query("DELETE FROM hukuman WHERE id_hukuman =".$id_hukuman);		
	}
}
