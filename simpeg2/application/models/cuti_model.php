<?php 
class Cuti_model extends CI_Model{
	var $id_pegawai = '';
	var $id_jenis_cuti = '';
	var $no_keputusan = '';
	var $tmt_awal = '';
	var $tmt_selesai = '';
	var $keterangan = '';
	//var $id_berkas = '';
	var $id_cuti_pegawai = '';
	
	//private $jumlah;
	//private $tahun;
	private $no;
	private $tanggal;
	private $hari;
	private $ket;
	private $ket2;
	private $tahun;

	
	public function setNo($value)
	{
		$this->no = $value;
	}	
	public function getNo()
	{
		return $this->no;
	}

	public function setTahun($value)
	{
		$this->tahun = $value;
	}	
	public function getTahun()
	{
		return $this->tahun;
	}
	
	
	public function setTanggal($value)
	{
		$this->tanggal = $value;
	}	
	public function getTanggal()
	{
		return $this->tanggal;
	}

	
	public function setHari($value)
	{
		$this->hari = $value;
	}	
	public function getHari()
	{
		return $this->hari;
	}

	public function setKet($value)
	{
		$this->ket = $value;
	}
	public function getKet()
	{
		return $this->ket;
	}
	
	public function setKet2($value)
	{
		$this->ket2 = $value;
	}
	public function getKet2()
	{
		return $this->ket2;
	}
	
	/*public function setTahun($value)
	{
		$this->tahun = $value;
	}
	public function getTahun()
	{
		return $this->tahun;
	}
	
	
	public function setJumlah($value)
	{
		$this->jumlah = $value;
	}	
	public function getJumlah()
	{
		return $this->jumlah;
	}*/	
	
	public function setIdPegawai($value)
	{
		$this->id_pegawai = $value;
	}
	
	public function getIdPegawai()
	{
		return $this->id_pegawai;
	}
	
	public function setIdBerkas($value)
	{
		$this->id_berkas = $value;
	}
	
	public function getIdBerkas()
	{
	return $this->id_berkas;
	}
	
	public function setIdJenisCuti($value)
	{
		$this->id_jenis_cuti = $value;
	}
	
	public function getIdJenisCuti()
	{
		return $this->id_jenis_cuti;
	}
	//insert cuti bersama
	public function insert_cuti_bersama()
	{
		$sql = "INSERT INTO cuti_bersama(no,tanggal,hari,ket)
			    VALUES(NULL,'".$this->getTanggal()."','".$this->getHari()."','".$this->getKet()."')";
			
			return $this->db->query($sql);
	}
	
	//delete cuti bersama
	public function delete_cuti_bersama(){		
		//echo $this->getTanggal();
		$querydelete = "DELETE FROM cuti_bersama where tanggal='".$this->getTanggal()."'";
		return $this->db->query($querydelete);
	}

	//insert libur nasional
	public function insert_libur_nasional()
	{
		$sql = "INSERT INTO libur_nasional(no,tanggal,hari,ket2)
			    VALUES(NULL,'".$this->getTanggal()."','".$this->getHari()."','".$this->getKet2()."')";
			
			return $this->db->query($sql);
	}

	//delete libur nasional
	public function delete_libur_nasional()
	{
		echo $this->getTanggal();
		$querydelete = "DELETE FROM libur_nasional where tanggal='".$this->getTanggal()."'";
		return $this->db->query($querydelete);
	} 
	
	
	public function view_cuti_bersama()
	{
		$sql = "SELECT * FROM cuti_bersama";
		
		return $this->db->query($sql);
	}
	

	public function view_tanggal_cuti_bersama()
	{
		$sql = "SELECT tanggal FROM cuti_bersama";
		
		return $this->db->query($sql);
	}

	public function view_libur_nasional()
	{
		$sql = "SELECT * FROM libur_nasional";
		
		return $this->db->query($sql);
	}
	

	public function delete_libur_bersama()
	{
		$sql = "DELETE FROM libur_bersama";
		return $this->db->query($sql);
	}
	
	
	public function hitung_cuti_bersama()
	{
		$sql = "SELECT COUNT(*) as jumlah_cuti FROM cuti_bersama";
		
		$result = $this->db->query($sql);
		
		return $result->row();
	}
	
	
	/*public function get_all(){
		$query = $this->db->query("select * from cuti_pegawai cut 
									inner join pegawai p on p.id_pegawai = cut.id_pegawai
									inner join jenis_cuti j on j.id_jenis_cuti = cut.id_jenis_cuti
									left join current_lokasi_kerja c on c.id_pegawai = p.id_pegawai
									left join unit_kerja u on u.id_unit_kerja = c.id_unit_kerja
									left join jabatan jab on jab.id_j = p.id_j
									where flag_pensiun = 0
									order by id_cuti_pegawai desc");

		$data = null;
		foreach ($query->result() as $row)
		{
			$data[] = $row;
		}
		return $data;
	}*/
	

	public function get_all(){
		$query = $this->db->query("select p.id_pegawai,nama,nip_baru,deskripsi,tmt_awal,tmt_selesai,
                                    j.id_jenis_cuti,id_cuti_pegawai,status, cut.berkas
									from cuti_pegawai cut 
									inner join pegawai p on p.id_pegawai = cut.id_pegawai
									inner join jenis_cuti j on j.id_jenis_cuti = cut.id_jenis_cuti
									left join current_lokasi_kerja c on c.id_pegawai = p.id_pegawai
									left join unit_kerja u on u.id_unit_kerja = c.id_unit_kerja
									left join jabatan jab on jab.id_j = p.id_j
									where flag_pensiun = 0
									order by id_cuti_pegawai desc");

		$data = null;
		foreach ($query->result() as $row)
		{
			$data[] = $row;
		}
		return $data;
	}

	public function get_by_id_cuti_pegawai($id_cuti_pegawai){
		$query = $this->db->query("SELECT *, jab.jabatan as jab_jabatan, p.jabatan as peg_jabatan, p.id_pegawai as id_pegawainya 
					FROM cuti_pegawai c
					INNER JOIN jenis_cuti j on j.id_jenis_cuti = c.id_jenis_cuti					
					INNER JOIN pegawai p on p.id_pegawai = c.id_pegawai
					INNER JOIN golongan g on g.golongan = p.pangkat_gol
					LEFT JOIN current_lokasi_kerja cur on cur.id_pegawai = c.id_pegawai
					LEFT JOIN unit_kerja u on u.id_unit_kerja = cur.id_unit_kerja
					LEFT JOIN jabatan jab on jab.id_j = p.id_j
					
					WHERE c.id_cuti_pegawai = ".$id_cuti_pegawai);
		
		foreach ($query->result() as $row)
		{
			return $row;
		}
		return null;
	}
	
	public function get_by_id_pegawai($id_pegawai){
		$query = $this->db->query("SELECT * 
					FROM cuti_pegawai c
					INNER JOIN jenis_cuti j on j.id_jenis_cuti = c.id_jenis_cuti
					WHERE c.id_pegawai = ".$id_pegawai." AND c.status=1 ORDER BY c.tmt_awal desc");

		$data = null;
		foreach ($query->result() as $row)
		{
			$data[] = $row;
		}
		return $data;
	}
	public function update_kuota($k_c,$id_pegawai){
		$query = "UPDATE pegawai SET kuota_cuti='$k_c' where id_pegawai=$id_pegawai";
		$this->db->query($query);			
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
	
	public function get_jumlah_hari_kerja($tmt_mulai, $tmt_selesai){
		$query = $this->db->query("SELECT sum( is_workday ) AS jumlah
			FROM oasys_workday
			WHERE workday_date
			BETWEEN '$tmt_mulai'
			AND '$tmt_selesai'");

		$r = $query->result();
		
		return $r[0]->jumlah;
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
	
	public function insert_berkas()
	{
		$sql = "INSERT INTO berkas (id_berkas,id_pegawai,id_kat,nm_berkas,ket_berkas,tgl_upload,byk_hal,tgl_berkas,status, created_by, created_date) 
				VALUES (NULL, '".$this->getIdPegawai()."', 657464, 'coba', 'coba', '2015-02-11', 1, '2015-02-04', 'coba', 'coba', '2015-02-11 00:00:00')";
				
		return $this->db->query($sql);
	}
	
	public function get_id_berkas()
	{
		$sql = "SELECT max(id_berkas) as new_id FROM berkas";
		
		return $this->db->query($sql);
		
	}
	
	public function get_id_jenis_cuti()
	{
		$sql = "SELECT max(id_sk) as new_id_sk FROM sk";
		
		return $this->db->query($sql);
	}
	
	public function insert(){
		$this->id_pegawai		= $this->input->post('idPegawai');
		$this->id_jenis_cuti	= $this->input->post('cboJenisCuti');
		$this->no_keputusan 	= $this->input->post('txtNoKeputusan');
		$this->tmt_awal 		= $this->input->post('txtTmtAwal');
		$this->tmt_selesai		= $this->input->post('txtTmtSelesai');		
		$this->keterangan		= $this->input->post('txtKeterangan');
		
		//echo $this->id_pegawai;

		$sql = "INSERT INTO cuti_pegawai(id_pegawai,id_jenis_cuti,no_keputusan,tmt_awal,tmt_selesai,keterangan) VALUES(".$this->id_pegawai.",'".$this->id_jenis_cuti."','".$this->no_keputusan."','".$this->tmt_awal."','".$this->tmt_selesai."','".$this->keterangan."')";

		return $this->db->query($sql);

		//return $this->db->insert('cuti_pegawai', $this);
		
		//return $this->db->insert_id();
	}
	
	public function delete($id_cuti){
		return $this->db->query("DELETE FROM cuti_pegawai WHERE id_cuti_pegawai =".$id_cuti);		
	}
	
	function jumlah_hari_cuti( $tgl_awal, $tgl_akhir  ){
		$date1  = date_create($tgl_awal);
		$date2  = date_create($tgl_akhir);
		$diff     = date_diff($date1,$date2);

		$interval =  $diff->format("%a");
		$jumlah  = 0;
		
		for($i=1; $i<=$interval + 1; $i++){
			if( strcasecmp( date_format($date1, "l"), "Sunday") == 0){
				date_add($date1, date_interval_create_from_date_string("1 days"));
				continue;
			}else if( strcasecmp( date_format($date1, "l") , "Saturday") == 0 ){
				date_add($date1, date_interval_create_from_date_string("1 days"));
				continue;
			}else{
				$jumlah++ ;
				date_add($date1, date_interval_create_from_date_string("1 days"));
			}			
		}
		return $jumlah;
	}
	function update_status($id)
	{
		$sql = "UPDATE cuti_pegawai set status=1 WHERE id_cuti_pegawai=".$id;
		
		return $this->db->query($sql);
	}
	function update_status_tidak($id)
	{
		$sql = "UPDATE cuti_pegawai set status=3 WHERE id_cuti_pegawai=".$id;
		
		return $this->db->query($sql);
	}
	function get_kuota($id)
	{
		$query = $this->db->query("SELECT kuota_cuti FROM pegawai where id_pegawai='".$id."'");

		$r = $query->result();

		return $r[0]->kuota_cuti;
	}
}
