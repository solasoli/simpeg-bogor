<?php 
class Pendidikan_model extends CI_Model{
	var $id_pendidikan = '';
	var $id_pegawai = '';
	var $lembaga_pendidikan = '';
	var $tingkatt_pendidikan = '';
	var $jurusan_pendidikan = '';
	var $tahun_lulus = '';
	var $level_p = '';
	var $id_berkas = '';
	
	public function __construct()
	{}
	
	public function get_all(){
		$query = $this->db->query("select * from cuti_pegawai cut 
									inner join pegawai p on p.id_pegawai = cut.id_pegawai
									inner join jenis_cuti j on j.id_jenis_cuti = cut.id_jenis_cuti
									left join current_lokasi_kerja c on c.id_pegawai = p.id_pegawai
									left join unit_kerja u on u.id_unit_kerja = c.id_unit_kerja
									left join jabatan jab on jab.id_j = p.id_j
									where flag_pensiun = 0
									order by cut.tmt_awal desc");

		$data = null;
		foreach ($query->result() as $row)
		{
			$data[] = $row;
		}
		return $data;
	}
	
	public function get_by_id_pegawai($id_pegawai){
		
		$query = $this->db->query("SELECT * 
					FROM pendidikan pend
					INNER JOIN pegawai p on pend.id_pegawai = p.id_pegawai
					WHERE p.id_pegawai = ".$id_pegawai.
					" ORDER BY pend.level_p asc");

		$data = null;
		foreach ($query->result() as $row)
		{
			$data[] = $row;
		}
		return $data;
	}
	
	public function get_by_id_jenis_cuti($id_jenis_cuti){
		$query = $this->db->query("select nama, nip_baru, pangkat_gol, j.jabatan, u.nama_baru, cut.id_jenis_cuti, cut.tmt_awal, cut.tmt_selesai, jen.deskripsi
								from pegawai p 
								inner join cuti_pegawai cut on cut.id_pegawai = p.id_pegawai
								inner join jenis_cuti jen on jen.id_jenis_cuti = cut.id_jenis_cuti
								left join jabatan j on j.id_j = p.id_j
								left join current_lokasi_kerja c on c.id_pegawai = p.id_pegawai
								left join unit_kerja u on u.id_unit_kerja = c.id_unit_kerja
								where p.flag_pensiun = 0 
								and cut.id_jenis_cuti = '".$id_jenis_cuti."'");

		$data = null;
		foreach ($query->result() as $row)
		{
			$data[] = $row;
		}
		return $data;
	}
	
	public function get_by_status_lapor($status_lapor){
		$query = $this->db->query("select nama, nip_baru, pangkat_gol, j.jabatan, u.nama_baru, cut.id_jenis_cuti, cut.tmt_awal, cut.tmt_selesai, jen.deskripsi
								from pegawai p 
								inner join cuti_pegawai cut on cut.id_pegawai = p.id_pegawai
								inner join jenis_cuti jen on jen.id_jenis_cuti = cut.id_jenis_cuti
								left join jabatan j on j.id_j = p.id_j
								left join current_lokasi_kerja c on c.id_pegawai = p.id_pegawai
								left join unit_kerja u on u.id_unit_kerja = c.id_unit_kerja
								where p.flag_pensiun = 0 
								and cut.sudah_melapor = '".$status_lapor."'");

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

		$data = null;
		foreach ($query->result() as $row)
		{
			$data[] = $row;
		}
		return $data;
	}
			
	public function recap_jenis_cuti_per_tahun(){
		$query = $this->db->query("SELECT tahun, 
									SUM( IF( id_jenis_cuti =  'CLTN', jumlah, 0 ) ) AS cltn, 
									SUM( IF( id_jenis_cuti =  'C_ALASAN_PENTING', jumlah, 0 ) ) AS alasan_penting, 
									SUM( IF( id_jenis_cuti =  'C_BERSALIN', jumlah, 0 ) ) AS bersalin,
									SUM( IF( id_jenis_cuti =  'C_BESAR', jumlah, 0 ) ) AS besar,
									SUM( IF( id_jenis_cuti =  'C_SAKIT', jumlah, 0 ) ) AS sakit,
									SUM( IF( id_jenis_cuti =  'C_TAHUNAN', jumlah, 0 ) ) AS tahunan,
									SUM(jumlah) as jumlah
								FROM (
									SELECT YEAR( tmt_awal ) AS tahun, id_jenis_cuti, COUNT( * ) AS jumlah
									FROM cuti_pegawai c
									GROUP BY tahun, id_jenis_cuti 
									ORDER BY tahun DESC
								) t
								GROUP BY tahun
								ORDER BY tahun DESC");

		$data = null;
		foreach ($query->result() as $row)
		{
			$data[] = $row;
		}
		return $data;
	}
	
	public function get_kuota_cuti_tahunan($id_pegawai, $tahun){
	
		$query = $this->db->query("SELECT * 
									FROM cuti_pegawai
									WHERE id_pegawai = $id_pegawai
									AND YEAR( tmt_awal ) = $tahun
									AND id_jenis_cuti =  'C_TAHUNAN'");

		$data = null;
		
		$kuota = 0;
		$this->load->model('workday_model');
		
		foreach ($query->result() as $row)
		{				
			$start = new DateTime($row->tmt_awal);			
			$end = new DateTime($row->tmt_selesai);			
			$diff = $start->diff($end);			
			$kuota += $diff->days;
			$kuota -= $this->workday_model->count_holiday($row->tmt_awal, $row->tmt_selesai);
		}				
		return 12-$kuota;
	}
	
	public function insert(){
		$this->id_pegawai		= $this->input->post('idPegawai');
		$this->id_jenis_cuti	= $this->input->post('cboJenisCuti');
		$this->no_keputusan 	= $this->input->post('txtNoKeputusan');
		$this->tmt_awal 		= $this->input->post('txtTmtAwal');
		$this->tmt_selesai		= $this->input->post('txtTmtSelesai');		
		$this->keterangan		= $this->input->post('txtKeterangan');
		
		$this->db->insert('cuti_pegawai', $this);
		
		return $this->db->insert_id();
	}
	
	public function delete($id_cuti){
		return $this->db->query("DELETE FROM cuti_pegawai WHERE id_cuti_pegawai =".$id_cuti);		
	}
}
