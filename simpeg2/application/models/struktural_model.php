<?php
class struktural_model extends CI_Model
{
	
	var $table = 'pegawai';
	var $column_order = array(null, 'nama','jabatan','eselon','pangkat_gol'); //set column field database for datatable orderable
	var $column_search = array('pegawai.nama','jabatan.jabatan','jabatan.eselon','pangkat_gol'); //set column field database for datatable searchable 
	var $order = array('jabatan.eselon' => 'asc'); // default order 
	
    public function __construct()
    {
		
    }

    public function get_all_pejabat(){
     	$q = $this->db->query("select concat(gelar_depan,' ',nama,' ',gelar_belakang) as nama,
									jabatan.jabatan,jabatan.eselon,
									pangkat_gol,TIMESTAMPDIFF(YEAR, pegawai.tgl_lahir, curdate()) AS umur,
									pegawai.id_pegawai as idp 
								from pegawai 
								inner join jabatan on jabatan.id_j=pegawai.id_j 
								where flag_pensiun=0 and pegawai.id_j is not null order by jabatan.eselon");
		return $q->result();
    }
	
	  public function get_pendidikan($idp){
     	$q = $this->db->query("select tingkat_pendidikan,
					jurusan_pendidikan,bidang,pendidikan.id_bidang as idb,
					level_p from pendidikan left join bidang_pendidikan on bidang_pendidikan.id=pendidikan.id_bidang 	
					where id_pegawai=$idp order by level_p");
		return $q->result();
    }
	
	private function _get_datatables_query()
	{
		$this->db->select("pegawai.id_pegawai, TRIM(IF(LENGTH(pegawai.gelar_belakang) > 1,
									CONCAT(pegawai.gelar_depan,
											' ',
											pegawai.nama,
											CONCAT(', ', pegawai.gelar_belakang)),
									CONCAT(pegawai.gelar_depan, ' ', pegawai.nama))) AS nama,
									jabatan.jabatan,jabatan.eselon,
									pangkat_gol,TIMESTAMPDIFF(YEAR, pegawai.tgl_lahir, curdate()) AS umur",FALSE);
									
		$this->db->from('pegawai');
		$this->db->join('jabatan','jabatan.id_j = pegawai.id_j','inner');
		//$this->db->join('pendidikan','jabatan.id_j = pegawai.id_j','inner');
		$this->db->where('pegawai.flag_pensiun = 0');
		
	
		$i = 0;
	
		foreach ($this->column_search as $item) // loop column 
		{
			if($_POST['search']['value']) // if datatable send POST for search
			{
				
				if($i===0) // first loop
				{
					//$this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
					$this->db->like($item, $_POST['search']['value']);
				}
				else
				{
					$this->db->or_like($item, $_POST['search']['value']);
				}

				//if(count($this->column_search) - 1 == $i) //last loop
					//$this->db->group_end(); //close bracket
			}
			$i++;
		}
		
		if( !empty($_POST['columns'][1]['search']['value']) ){   //name			
			$this->db->like("nama",$_POST['columns'][1]['search']['value']);
		}
		if( !empty($_POST['columns'][2]['search']['value']) ){   //name			
			$this->db->like("jabatan.jabatan",$_POST['columns'][2]['search']['value']);
		}
		if( !empty($_POST['columns'][3]['search']['value']) ){   //name			
			$this->db->like("jabatan.eselon",$_POST['columns'][3]['search']['value']);
		}
		
		if( !empty($_POST['columns'][5]['search']['value']) ){   //name			
			$this->db->like("pangkat_gol",$_POST['columns'][5]['search']['value']);
		}
		
		if( !empty($_POST['columns'][6]['search']['value']) ){   //name			
			$this->db->like("TIMESTAMPDIFF(YEAR, pegawai.tgl_lahir, curdate())",$_POST['columns'][6]['search']['value']);
		}
		
		
		if(isset($_POST['order'])) // here order processing
		{
			$this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} 
		else if(isset($this->order))
		{
			$order = $this->order;
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}

	function get_datatables()
	{
		//print_r($_POST);exit;
		$this->_get_datatables_query();
		if($_POST['length'] != -1)		
		$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	function count_filtered()
	{
		$this->_get_datatables_query();
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all()
	{
		$this->db->from($this->table);
		$this->db->join('jabatan','jabatan.id_j = pegawai.id_j','inner');
		return $this->db->count_all_results();
	}

  

}