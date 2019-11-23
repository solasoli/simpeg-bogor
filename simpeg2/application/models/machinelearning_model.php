<?php 
class Machinelearning_model extends CI_Model{
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
	
	
	
	public function eseloniva()
	{
		$query = $this->db->query("select id_pegawai from pegawai inner join jabatan on jabatan.id_j=pegawai.id_j where id_j>0 and flag_pensiun=0 and eselon='IVA' ");
		   return $query->result();
	}
	
		public function eseloniiib()
	{
		$query = $this->db->query("select id_pegawai from pegawai inner join jabatan on jabatan.id_j=pegawai.id_j where id_j>0 and flag_pensiun=0 and eselon='IIIB' ");
		   return $query->result();
	}
	
		public function eseloniiia()
	{
		$query = $this->db->query("select id_pegawai from pegawai inner join jabatan on jabatan.id_j=pegawai.id_j where id_j>0 and flag_pensiun=0 and eselon='IIIA' ");
		   return $query->result();
	}

	public function eseloniib()
	{
		$query = $this->db->query("select id_pegawai from pegawai inner join jabatan on jabatan.id_j=pegawai.id_j where id_j>0 and flag_pensiun=0 and eselon='IIB' ");
		   return $query->result();
	}
	
	public function get_jenjabumurpangkat($id_pegawai){
		$query = $this->db->query("SELECT jenjab,  DATEDIFF(curdate(),tgl_lahir)/356, pangkat_gol
								FROM pegawai
								WHERE id_pegawai =  '$id_pegawai' and flag_pensiun=0");
	
        return $query->result();
	}
	
	function get_tmt_cpns($id_pegawai){
	
		$this->db->where('id_kategori_sk',6);
		$this->db->where('id_pegawai',$id_pegawai);
		$this->db->where('flag_pensiun',0);
		return $this->db->get('sk')->row()->tmt;
	}
	
	function hitung_masakerja($tmt_cpns, $mk_awal_thn, $mk_awal_bln){
        $this->load->library('format');
       
		list($tmt_thn,$tmt_bln,$tmt_tgl) = explode("-",$tmt_cpns);
       
		$timestamp = mktime(0,0,0,$tmt_bln - $mk_awal_bln,$tmt_tgl,$tmt_thn - $mk_awal_thn);
		$tgl = $this->format->datediff(date('Y-m-d'),date('Y-m-d',$timestamp));
        $this->masakerja['tahun'] = $tgl['years'];
        $this->masakerja['bulan'] = $tgl['months'];
        return $this->masakerja;
        
    }
		       
	 function get_diklat($id_pegawai)
    {

        $this->db->where('id_pegawai', $id_pegawai);
        $query = $this->db->get('diklat');
         return $query->row();

    }	
	
	
	 function get_pendidikan($id_pegawai)
    {
		$this->db->select(min('level_p'));
        $this->db->where('id_pegawai', $id_pegawai);
        $query = $this->db->get('pendidikan');
         return $query->row();

    }		   
	
	
	function get_pengalaman($id_pegawai,$eselon)
    {
		$query = $this->db->query("SELECT min(tmt) FROM sk	inner join jabatan on jabatan.id_j=sk.id_j WHERE id_kategori=10 and flag_pensiun=0 and id_pegawai=$id and eselon='$eselon'");
        return $query->row();
    }		   
   
   
}
