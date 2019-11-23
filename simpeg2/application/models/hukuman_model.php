<?php 
class Hukuman_model extends CI_Model{
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
	
	public function get_by_id_pegawai($id_pegawai){
		$query = $this->db->query("SELECT * 
									FROM hukuman h
									inner join jenis_hukuman j on j.id_jenis_hukuman = h.id_jenis_hukuman
									WHERE h.id_pegawai = ".$id_pegawai);

		$data = null;
		foreach ($query->result() as $row)
		{
			$data[] = $row;
		}
		return $data;
	}
	
	public function get_terhukum(){
		$query = $this->db->query("SELECT p.nama, p.nip_baru, j.tingkat_hukuman, j.deskripsi, h.no_keputusan, h.tgl_hukuman, h.tmt, u.nama_baru
									FROM hukuman h
									inner join jenis_hukuman j on  h.id_jenis_hukuman = j.id_jenis_hukuman
									INNER JOIN pegawai p ON p.id_pegawai = h.id_pegawai
									LEFT JOIN current_lokasi_kerja c ON c.id_pegawai = p.id_pegawai
									LEFT JOIN unit_kerja u ON u.id_unit_kerja = c.id_unit_kerja
									ORDER BY tmt DESC");

		/*$data = null;
		foreach ($query->result() as $row)
		{
			$data[] = $row;
		}*/
		//return $data;
		return $query->result();
	}
	
	public function recap_tingkat_hukuman_per_tahun(){
		$query = $this->db->query("SELECT tahun, SUM( IF( tingkat_hukuman =  'RINGAN', jumlah, 0 ) ) AS ringan, SUM( IF( tingkat_hukuman =  'SEDANG', jumlah, 0 ) ) AS sedang, SUM( IF( tingkat_hukuman =  'BERAT', jumlah, 0 ) ) AS berat,
									sum(jumlah) as jumlah
									FROM (
										SELECT YEAR( tgl_hukuman ) AS tahun, tingkat_hukuman, COUNT( * ) AS jumlah
										FROM hukuman h
										INNER JOIN jenis_hukuman j ON j.id_jenis_hukuman = h.id_jenis_hukuman
										GROUP BY YEAR(tgl_hukuman), tingkat_hukuman
										ORDER BY YEAR( tgl_hukuman ) DESC
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

	public function get_by_id_riwayat_hukuman($id_pegawai){
		$query = $this->db->query("SELECT jh.tingkat_hukuman, jh.deskripsi, h.tmt, h.keterangan, 
                ROUND(DATEDIFF(CURRENT_DATE, h.tmt) / 365,2) AS usia_hukuman, 
                CASE WHEN jh.tingkat_hukuman = 'RINGAN' THEN (CASE WHEN YEAR(h.tmt) = YEAR(NOW()) THEN 1 ELSE 0 END) ELSE 0 END AS cek_ringan_curr 
				FROM hukuman h, jenis_hukuman jh 
				WHERE h.id_jenis_hukuman = jh.id_jenis_hukuman AND h.id_pegawai = $id_pegawai");

		$data = null;
		foreach ($query->result() as $row)
		{
			$data[] = $row;
		}
		return $data;
	}
}