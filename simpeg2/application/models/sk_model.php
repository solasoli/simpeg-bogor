<?php 
class Sk_model extends CI_Model{
	var $id_sk = '';
	var $id_pegawai = '';
	var $id_kategori_sk = '';
	var $no_sk = '';
	var $tgl_sk = '';
	var $pemberi_sk = '';
	var $pengesah_sk = '';
	var $keterangan = '';
	var $tmt = '';
	var $id_j = '';
	var $id_berkas = '';
	var $id_gapok = '';
	var $id_dasar_sk = '';
	var $id_unit_kerja = '';
	
		
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
	
	public function get_by_id_sk($id_sk){
	
		$query = $this->db->query("select s.*, g.*, k.nama_sk
									from sk s 
									inner join kategori_sk k on k.id_kategori_sk = s.id_kategori_sk
									left join gaji_pokok g on s.id_gapok = g.id_gaji_pokok
									where id_sk = '$id_sk'");


		foreach ($query->result() as $row)
		{
			return $row;
		}
		return null;
	}

	public function get_sk_pegawai_by_kategori($id_pegawai, $id_kategori){
		$data = null;
		$query = $this->db->query("select s.*, k.nama_sk
									from sk s 
									inner join kategori_sk k on k.id_kategori_sk = s.id_kategori_sk							
									where s.id_kategori_sk = '$id_kategori' and s.id_pegawai = '$id_pegawai'");

		
		foreach ($query->result() as $row)
		{
			$data[] =  $row;
		}
		return $data;
	}
	
	public function get_masa_kerja(){
		if($this->keterangan)
		{
			$d = explode(',',$this->keterangan);
			return array($d[1],$d[2]);
		}
		return array('-','-');
	}
	
	public function get_pengesah_sk_old($golongan){		
		$idj = '';
		$data = null;
		
		$this->load->model('pegawai_model');
		
		if($golongan == 'IV/c'){
			if($pegawai = $this->pegawai_model->get_by_jabatan(2003)){							
			}
			else{
				$pegawai = $this->pegawai_model->get_by_id(4357);
				$pegawai->jabatan = "WALIKOTA,";
				$pegawai->gelar_depan = "";
				$pegawai->gelar_belakang = "";
				$pegawai->pangkat = "";
				$pegawai->pangkat_gol = "";
				$pegawai->nip_baru = "";
				$pegawai->nama = "BIMA ARYA";
			}
			$data[0] = $pegawai;
			$data[1] = '';
			return $data;
		}
		else if($golongan == 'IV/b'){
			if($pegawai = $this->pegawai_model->get_by_jabatan(2004)){
				$data[0] = $pegawai;
				$data[1] = 'A.n Walikota Bogor';
				return $data;
			}
			if($pegawai = $this->pegawai_model->get_by_jabatan(2003))
				$data[0] = $pegawai;
				$data[1] = '';
				return $data;
		}
		else if($golongan == 'IV/a'){
			if($pegawai = $this->pegawai_model->get_by_jabatan(2029)){
				$data[0] = $pegawai;
				$data[1] = '';
				return $data;
			}	
			if($pegawai = $this->pegawai_model->get_by_jabatan(2004)){
				$data[0] = $pegawai;
				$data[1] = 'A.n Walikota Bogor';
				return $data;
			}
			if($pegawai = $this->pegawai_model->get_by_jabatan(2003)){
				$data[0] = $pegawai;
				$data[1] = '';
				return $data;
			}
		}		
		else if($golongan == 'III/d' || $golongan == 'III/c'){
			if($pegawai = $this->pegawai_model->get_by_jabatan(2067)){
				$data[0] = $pegawai;
				$data[1] = 'A.n Kepala';
				return $data;
			}	
			if($pegawai = $this->pegawai_model->get_by_jabatan(2029)){
				$data[0] = $pegawai;
				$data[1] = 'A.n Kepala';
				return $data;
			}	
			if($pegawai = $this->pegawai_model->get_by_jabatan(2004)){
				$data[0] = $pegawai;
				$data[1] = 'A.n Kepala';
				return $data;
			}	
			if($pegawai = $this->pegawai_model->get_by_jabatan(2003)){
				$data[0] = $pegawai;
				$data[1] = 'A.n Kepala';
				return $data;
			}	
		}
		else{			
			if($pegawai = $this->pegawai_model->get_by_jabatan(3191)){ //kabid
				$data[0] = $pegawai;
				$data[1] = 'A.n Kepala';
				return $data;
			}	
			if($pegawai = $this->pegawai_model->get_by_jabatan(3120)){ //sekretaris
				$data[0] = $pegawai;
				$data[1] = 'A.n Kepala';
				return $data;
			}	
			if($pegawai = $this->pegawai_model->get_by_jabatan(3082)) { // kaban
				$data[0] = $pegawai;
				$data[1] = 'A.n Kepala';
				return $data;
			}	
			if($pegawai = $this->pegawai_model->get_by_jabatan(2004)) { // sekda
				$data[0] = $pegawai;
				$data[1] = 'A.n Kepala';
				return $data;
			}	
			if($pegawai = $this->pegawai_model->get_by_jabatan(2003)) { //walikota
				$data[0] = $pegawai;
				$data[1] = 'A.n Kepala';
				return $data;
			}			
		}						
	}
	
	public function get_pengesah_sk($p)
	{
		$idj = '';
		$data = null;

		$this->load->model('pegawai_model');

		if ($p->pangkat_gol == 'IV/d' || $p->pangkat_gol == 'IV/e') {
			if($pegawai = $this->pegawai_model->get_by_jabatan(4376)){
				$pegawai = new StdClass;
				$pegawai->jabatan = "WALIKOTA BOGOR,";
				$pegawai->gelar_depan = "";
				$pegawai->gelar_belakang = "";
				$pegawai->pangkat = "";
				$pegawai->pangkat_gol = "";
				$pegawai->nip_baru = "";
				$pegawai->nama = "BIMA ARYA";
				$data[0] = $pegawai;
				$data[1] = '';
				$data[2] = $pegawai->id_j;
				$data[3] = $pegawai->p.id_pegawai;
				return $data;
			}
		}elseif($p->pangkat_gol == 'IV/c'){
			if($pegawai = $this->pegawai_model->get_by_jabatan(4376)){
				$pegawai2 = $this->pegawai_model->get_by_jabatan2(4376);
				$data[0] = $pegawai;
				$data[1] = 'A.n Walikota Bogor';
				$data[2] = $pegawai->id_j;
				$data[3] = $pegawai2->id_pegawai;
				$data[4] = $pegawai2->ponsel;
				
				return $data;
			}else{
				if($p->id_j == 4376 || $p->pangkat_gol == 'IV/d'){
					//$pegawai = $this->pegawai_model->get_by_id(4357);
					$pegawai = new StdClass;
					$pegawai->jabatan = "WALIKOTA,";
					$pegawai->gelar_depan = "";
					$pegawai->gelar_belakang = "";
					$pegawai->pangkat = "";
					$pegawai->pangkat_gol = "";
					$pegawai->nip_baru = "";
					$pegawai->nama = "BIMA ARYA";
				}
				else{

					if($pegawai = $this->pegawai_model->get_by_jabatan(4376)){
						$pegawai2 = $this->pegawai_model->get_by_jabatan2(4376);
						$data[0] = $pegawai;
						$data[1] = 'A.n Walikota Bogor';
						$data[2] = $pegawai->id_j;
				$data[3] = $pegawai2->id_pegawai;
				$data[4] = $pegawai2->ponsel;
						return $data;
					}
					if($pegawai = $this->pegawai_model->get_by_jabatan(4375))
						$data[0] = $pegawai;
						$data[1] = '';
						$data[2] = $pegawai->id_j;
				$data[3] = 4375;
				$data[4] = $pegawai2->ponsel;
						return $data;
				}
			}
			$data[0] = $pegawai;
			$data[1] = '';
			$data[2] = $pegawai->id_j;
				$data[3] = $pegawai->id_pegawai;
				$data[4] = $pegawai2->ponsel;
			return $data;
		}
		else if($p->pangkat_gol == 'IV/b'){
			if($pegawai = $this->pegawai_model->get_by_jabatan(4376)){
				$pegawai2 = $this->pegawai_model->get_by_jabatan2(4376);
				$data[0] = $pegawai;
				$data[1] = 'A.n Walikota Bogor';
				$data[2] = $pegawai->id_j;
				$data[3] = $pegawai2->id_pegawai;
				$data[4] = $pegawai2->ponsel;
				return $data;
			}
			if($pegawai = $this->pegawai_model->get_by_jabatan(4375))
				$data[0] = $pegawai;
				$data[1] = '';
				$data[2] = $pegawai->id_j;
				$data[3] = 4375;
				$data[4] = $pegawai2->ponsel;
				
				return $data;
		}
		else if($p->pangkat_gol == 'IV/a'){
			if($pegawai = $this->pegawai_model->get_by_jabatan(3082)){
				$pegawai2 = $this->pegawai_model->get_by_jabatan2(3082);
				$data[0] = $pegawai;
				$data[1] = 'A.n Walikota Bogor';
				$data[2] = $pegawai->id_j;
				$data[3] = $pegawai2->id_pegawai;
				$data[4] = $pegawai2->ponsel;
				return $data;
			}
			if($pegawai = $this->pegawai_model->get_by_jabatan(4376)){ //sekda
			$pegawai2 = $this->pegawai_model->get_by_jabatan2(4376);
				$data[0] = $pegawai;
				$data[1] = 'A.n Walikota Bogor';
				$data[2] = $pegawai->id_j;
				$data[3] = $pegawai2->id_pegawai;
				$data[4] = $pegawai2->ponsel;
				return $data;
			}
			if($pegawai = $this->pegawai_model->get_by_jabatan(4375)){
				$pegawai2 = $this->pegawai_model->get_by_jabatan2(4375);
				$data[0] = $pegawai;
				$data[1] = '';
				$data[2] = $pegawai->id_j;
				$data[3] = $pegawai2->id_pegawai;
				$data[4] = $pegawai2->ponsel;
				return $data;
			}
		}
		else if($p->pangkat_gol == 'III/d' || $p->pangkat_gol == 'III/c'){
			if($pegawai = $this->pegawai_model->get_by_jabatan(3191)){ // sekretaris
			
				$pegawai2 = $this->pegawai_model->get_by_jabatan2(3191);
				$data[0] = $pegawai;
				$data[1] = 'A.n Kepala';
				$data[2] = $pegawai->id_j;
				$data[3] = $pegawai2->id_pegawai;
				$data[4] = $pegawai2->ponsel;
				return $data;
			}
			if($pegawai = $this->pegawai_model->get_by_jabatan(3082)){ //kaban
				$pegawai2 = $this->pegawai_model->get_by_jabatan2(3082);
				$data[0] = $pegawai;
				$data[1] = '';
				$data[2] = $pegawai->id_j;
				$data[3] = $pegawai2->id_pegawai;
				$data[4] = $pegawai2->ponsel;
				return $data;
			}
			if($pegawai = $this->pegawai_model->get_by_jabatan(4376)){ //sekda
				$pegawai2 = $this->pegawai_model->get_by_jabatan2(4376);
				$data[0] = $pegawai;
				$data[1] = '';
				$data[2] = $pegawai->id_j;
				$data[3] = $pegawai2->id_pegawai;
				$data[4] = $pegawai2->ponsel;
				return $data;
			}
			if($pegawai = $this->pegawai_model->get_by_jabatan(4375)){ //walikota
				$pegawai2 = $this->pegawai_model->get_by_jabatan(4375);
				$data[0] = $pegawai;
				$data[1] = '';
				$data[2] = $pegawai->id_j;
				$data[3] = $pegawai2->id_pegawai;
				$data[4] = $pegawai2->ponsel;
				return $data;
			}
		}
		else{
			if($pegawai = $this->pegawai_model->get_by_jabatan(3191)){
				$pegawai2 = $this->pegawai_model->get_by_jabatan2(3191);
				 //kabid 1095 diganti yak
				$data[0] = $pegawai;
				$data[1] = 'A.n Kepala';
				$data[2] = $pegawai->id_j;
				$data[3] = $pegawai2->id_pegawai;
				$data[4] = $pegawai2->ponsel;
				return $data;
			}
			if($pegawai = $this->pegawai_model->get_by_jabatan(3120)){ //sekretaris
			$pegawai2 = $this->pegawai_model->get_by_jabatan2(3120);
				$data[0] = $pegawai;
				$data[1] = 'A.n Kepala';
				$data[2] = $pegawai->id_j;
				$data[3] = $pegawai2->id_pegawai;
				$data[4] = $pegawai2->ponsel;
				return $data;
			}
			if($pegawai = $this->pegawai_model->get_by_jabatan(3082)) { // kaban
				$pegawai2 = $this->pegawai_model->get_by_jabatan2(3082);
				$data[0] = $pegawai;
				$data[1] = '';
				$data[2] = $pegawai->id_j;
				$data[3] = $pegawai2->id_pegawai;
				$data[4] = $pegawai2->ponsel;
				return $data;
			}
			if($pegawai = $this->pegawai_model->get_by_jabatan(4376)) { // sekda
				$pegawai2 = $this->pegawai_model->get_by_jabatan2(4376);
				$data[0] = $pegawai;
				$data[1] = '';
				$data[2] = $pegawai->id_j;
				$data[3] = $pegawai2->id_pegawai;
				$data[4] = $pegawai2->ponsel;
				return $data;
			}
			if($pegawai = $this->pegawai_model->get_by_jabatan(4375)) { //walikota
				$pegawai2 = $this->pegawai_model->get_by_jabatan2(4375);
				$data[0] = $pegawai;
				$data[1] = '';
				$data[2] = $pegawai->id_j;
				$data[3] = 4375;
				$data[3] = $pegawai2->id_pegawai;
				$data[4] = $pegawai2->ponsel;
				return $data;
			}
		}
	}
	
	public function recap_tingkat_hukuman_per_tahun(){
		$query = $this->db->query("SELECT tahun, SUM( IF( tingkat_hukuman =  'RINGAN', jumlah, 0 ) ) AS ringan, SUM( IF( tingkat_hukuman =  'SEDANG', jumlah, 0 ) ) AS sedang, SUM( IF( tingkat_hukuman =  'BERAT', jumlah, 0 ) ) AS berat,
									jumlah
									FROM (

									SELECT YEAR( tgl_hukuman ) AS tahun, tingkat_hukuman, COUNT( * ) AS jumlah
									FROM hukuman h
									INNER JOIN jenis_hukuman j ON j.id_jenis_hukuman = h.id_jenis_hukuman
									GROUP BY YEAR( tgl_hukuman ) 
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
		$this->db->insert('sk', $this);
		return $this->db->insert_id();
	}
	
	 public function tte($data){
       
        $sql = "insert into tte_inbox (idp_pengolah,id_kat_berkas,id_kategori_sk,uraian,filename,idj_pemaraf4,idp_pemaraf4,idj_penandatangan,status,history,id_pegawai,ponsel) 
		values 
		
		(1750,2,9,'$data[uraian]','$data[filename]',3444,4086,$data[idj],1,'diupload pada tanggal : ".date("Y-m-d H:i:s")." ',$data[id_pegawai],$data[ponsel]) ";

        $this->db->query($sql);
	 }
	
	public function update(){
		$this->db->where('id_sk', $this->id_sk);
		$this->db->update('sk', $this);
	}
	
	public function delete($id_sk){
		return $this->db->query("DELETE FROM sk WHERE id_sk =".$id_sk);		
	}

    public function drh_golongan($id_pegawai){
        $sql = "SELECT k.nama_sk, s.gol, g.pangkat, s.no_sk, s.tmt, s.tgl_sk, s.mk_tahun, s.mk_bulan, s.pemberi_sk
                FROM sk s LEFT JOIN kategori_sk k ON s.id_kategori_sk = k.id_kategori_sk
                LEFT JOIN golongan g ON s.gol = g.golongan
                WHERE (k.id_kategori_sk = 6 OR k.id_kategori_sk = 7 OR k.id_kategori_sk = 5) 
                AND s.id_pegawai = $id_pegawai";
        return $this->db->query($sql)->result();
    }

}
