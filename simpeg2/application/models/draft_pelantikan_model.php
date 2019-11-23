<?php 
class Draft_pelantikan_model extends CI_Model{	
	var $nama = '';
	var $created_by = '';
	
	//$iduser =$this->session->userdata('user')->id_pegawai;
	//$skr=date("Y-m-d");
	
	public function __construct(){
	}

	public function get_pejabat_sekarang($id_draft, $id_j){
		$query = $this->db->query("SELECT 
				p.id_pegawai as idpegawai,
				CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
                p.nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(', ',p.gelar_belakang) END) AS nama_gelar, 
				p.nip_baru, 
				p.pangkat_gol, 
				p.jenjab,
				j.jabatan, 
				j.eselon, 
				s_jab.tmt_jabatan, 
				pend . *, 
				DATE_FORMAT( s.tmt,  '%d-%m-%Y' ) AS tmt, p.alamat, p.kota 
			FROM draft_pelantikan_detail det
			INNER JOIN pegawai p ON p.id_pegawai = det.id_pegawai
			LEFT JOIN (
            SELECT pt.id_pegawai, pt.id_pendidikan, pt.tingkat_pendidikan, pt.jurusan_pendidikan,
              pt.lembaga_pendidikan, pt.tahun_lulus
            FROM pendidikan_terakhir pt) AS pend ON pend.id_pegawai = p.id_pegawai
			LEFT JOIN jabatan j ON j.id_j = p.id_j
			LEFT JOIN (
				SELECT s.id_pegawai, date_format(s.tmt, '%d-%m-%Y') as tmt_jabatan
				FROM pegawai p
				INNER JOIN sk s ON s.id_pegawai = p.id_pegawai
				WHERE id_kategori_sk = 10
				AND s.id_j = p.id_j
				GROUP BY s.id_pegawai
				ORDER BY s.tmt DESC				
			) as s_jab on s_jab.id_pegawai = p.id_pegawai
			LEFT JOIN (
				SELECT s.id_pegawai, s.tmt
				FROM pegawai p
				INNER JOIN sk s ON s.id_pegawai = p.id_pegawai
				WHERE id_kategori_sk =5
				AND s.gol = p.pangkat_gol
				GROUP BY s.id_pegawai
			) AS s ON s.id_pegawai = p.id_pegawai
			WHERE id_draft = $id_draft
			AND det.id_j =$id_j" );

		$data = null;
		foreach ($query->result() as $row){
			return $row;
		}
		return null;
	}
	
	public function get_draft_by_id($id_draft){
		$query = $this->db->query("SELECT * 
					from draft_pelantikan					
					where id_draft = $id_draft");

		$data = null;
		foreach ($query->result() as $row)
			return $row;
	}
	
	public function get_all(){
        $this->db->query("SET @row_number := 0");

		$query = $this->db->query("SELECT FCN_ROW_NUMBER() as no_urut, dp.id_draft, dp.nama, DATE_FORMAT(dp.created_time, '%d-%m-%Y %H:%m:%s') as created_time, p.id_pegawai, p.nip_baru,
        CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
        p.nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(' ',p.gelar_belakang) END) AS nama_pembuat,
        CASE WHEN dp.tgl_pelantikan IS NULL = 1 THEN NULL ELSE DATE_FORMAT(dp.tgl_pelantikan, '%d-%m-%Y') END AS tgl_pelantikan
        FROM draft_pelantikan dp LEFT JOIN pegawai p ON dp.created_by = p.id_pegawai
        ORDER BY dp.created_time DESC");

		$data = null;
		foreach ($query->result() as $row)
		{
			$data[] = $row;
		}
		return $data;
	}

	public function ganti($data){
		//print_r($data);
        $this->db->trans_begin();
        //$this->db->query("delete from draft_pelantikan_lepas_jabatan where id_pegawai = ".$data['id_pegawai_baru']." and id_draft = ".$data['id_draft']);
        if($data['id_pegawai_sebelumnya']) {
            // cek apakah sedang dicalonkan
            $sql = "SELECT *
                    FROM draft_pelantikan_detail dpd
                    WHERE dpd.id_pegawai = " . $data['id_pegawai_sebelumnya'] . " AND dpd.id_pegawai <> dpd.id_pegawai_awal AND dpd.id_draft = ".$data['id_draft'];
            $query = $this->db->query($sql);
            $rowcount = $query->num_rows();
            //if($rowcount > 0) {
            //}else{
			    //lepas jabatan
                $this->db->query("insert ignore into draft_pelantikan_lepas_jabatan(id_draft, id_pegawai, created_by)
                values ($data[id_draft], $data[id_pegawai_sebelumnya], $data[created_by])");

                $sql = "insert into draft_pelantikan_log (id_user,id_draft,id_pegawai,idj_awal,idj_akhir,id_transaksi) values
                (".$this->session->userdata('user')->id_pegawai.",$data[id_draft],$data[id_pegawai_sebelumnya],$data[id_j_dituju],0,1)";

                $this->db->query($sql);
            //}
        }
		//isi jabatan baru
        $this->db->query("update draft_pelantikan_detail set id_pegawai =  " . $data['id_pegawai_baru'] . " where id_draft = " . $data['id_draft'] . " and id_j = " . $data['id_j_dituju']);
		
		$this->db->query("insert into draft_pelantikan_log (id_user,id_draft,id_pegawai,idj_awal,idj_akhir,id_transaksi) values
        (".$this->session->userdata('user')->id_pegawai.",$data[id_draft],$data[id_pegawai_baru],".($data['id_j_ditinggal']=='-'?'0':$data['id_j_ditinggal']).",$data[id_j_dituju],2)");

        $sql = "select id_pegawai from draft_pelantikan_lepas_jabatan where id_pegawai = " . $data['id_pegawai_baru'] . " and id_draft = " . $data['id_draft'];

        $query = $this->db->query($sql);
        $rowcount = $query->num_rows();

        if($rowcount >= 1){
            $sql = "delete from draft_pelantikan_lepas_jabatan where id_pegawai = " . $data['id_pegawai_baru'] . " and id_draft = " . $data['id_draft'];
            $this->db->query($sql);
        }

        if($data['id_j_dituju'] <> $data['id_j_ditinggal']){
            if ($data['id_j_ditinggal'] <> '' and $data['id_j_ditinggal'] <> '-') {
                $sql = "SELECT dpd.*
                    FROM draft_pelantikan_detail dpd
                    WHERE dpd.id_pegawai = ".$data['id_pegawai_baru']." AND dpd.id_draft = ".$data['id_draft']." AND id_j = ".$data['id_j_ditinggal'];
                $query = $this->db->query($sql);
                $rowcount = $query->num_rows();
                if($rowcount > 0){
                    $this->db->query("update draft_pelantikan_detail set id_pegawai = null where id_draft = $data[id_draft] and id_j = $data[id_j_ditinggal];");
                }
            }
        }
        if ($this->db->trans_status() === FALSE)
        {
            $this->db->trans_rollback();
            $query = false;
        }else{
            $this->db->trans_commit();
            $query = true;
        }
        return $query;
	}
	
	public function get_pass($id_draft)
	{
		$query = $this->db->query("select password from draft_pelantikan where id_draft=$id_draft");
		foreach ($query->result() as $row)
		{
			$data[] = $row;
		}
		return $data[0];
	}
	 
	public function get_kosong($id_draft){
		$query = $this->db->query("SELECT a.*, p.id_j AS id_j_baru_isi FROM
            (select d.*, det.id_j, det.id_pegawai, det.id_pegawai_awal, det.update_time, j.jabatan, j.eselon, p.nama as nama_pegawai, jplt.tmt
			from draft_pelantikan d
			inner join draft_pelantikan_detail det on det.id_draft = d.id_draft
			inner join jabatan j on j.id_j = det.id_j
			left join pegawai p on p.id_pegawai = det.id_pegawai
			left join jabatan_plt jplt on j.id_j = jplt.id_j AND jplt.status_aktif = 1 
			where det.id_draft = $id_draft and p.nama is null AND tmt IS NULL = 1 
			ORDER BY `j`.`eselon` ASC) a LEFT JOIN pegawai p ON a.id_j = p.id_j
			LEFT JOIN draft_pelantikan_detail det ON p.id_pegawai = det.id_pegawai_awal AND det.id_pegawai IS NULL = 1 AND det.id_draft = $id_draft 
            WHERE p.id_j IS NULL = 1 OR (a.id_pegawai_awal = det.id_pegawai_awal)");

		$data = null;
		foreach ($query->result() as $row)
		{
			$data[] = $row;
		}
		return $data;
	}

	public function get_kosong_plt($id_draft){
        $query = $this->db->query("select d.*, det.*, j.jabatan, j.eselon, p.nama as nama_pegawai, jplt.tmt
            from draft_pelantikan d
            inner join draft_pelantikan_detail det on det.id_draft = d.id_draft
            inner join jabatan j on j.id_j = det.id_j
            left join pegawai p on p.id_pegawai = det.id_pegawai
            left join jabatan_plt jplt on j.id_j = jplt.id_j AND jplt.status_aktif = 1
            where det.id_draft = $id_draft and p.nama is null AND tmt IS NULL = 0
            order by j.jabatan asc");

        $data = null;
        foreach ($query->result() as $row)
        {
            $data[] = $row;
        }
        return $data;
    }
	
	public function get_lima($id_draft){
		/*$query = $this->db->query("select y.*, drf.id_draft from
                (select * from (select p.id_pegawai, p.nama, j.id_j, j.jabatan, a.jabatan as jabatan_lama, a.lama, datediff(now(), a.lama)/365 as masa 
                from pegawai p inner join jabatan j on p.id_j = j.id_j
                inner join 
                (SELECT a.id_pegawai, a.jabatan, MIN(a.lama) as lama FROM (select jabatan.jabatan, nama,sk.id_pegawai, sk.id_j as id_j,(tmt) as lama, nip_baru 
                from pegawai inner join sk on pegawai.id_pegawai = sk.id_pegawai
                inner join jabatan on sk.id_j = jabatan.id_j
                where flag_pensiun=0 and pegawai.id_j is not null and id_kategori_sk=10 and sk.id_j>0 
                ) a GROUP BY a.id_pegawai, a.jabatan) a
                on j.jabatan = a.jabatan AND p.id_pegawai = a.id_pegawai) as x where masa >=5 and jabatan_lama not like '%kepala puskesmas%' order by masa desc) y
                left join
                (select d.id_draft, dp.id_pegawai from draft_pelantikan d 
                inner join draft_pelantikan_detail dp ON d.id_draft = dp.id_draft
                where d.id_draft = $id_draft) drf ON y.id_pegawai = drf.id_pegawai;");*/

		$sql = "SELECT c.*, j.jabatan, p.nip_baru, p.nama, dp.id_draft FROM 
                (SELECT b.id_pegawai, 
                GROUP_CONCAT(b.id_j ORDER BY b.tmt_current DESC) AS idj_gab, 
                GROUP_CONCAT(b.tmt_awal_jabatan ORDER BY b.tmt_current DESC) AS tmt_awal_jabatan_gab,
                GROUP_CONCAT(b.tmt_current ORDER BY b.tmt_current DESC) AS tmt_current_gab,
                GROUP_CONCAT(b.pengalaman_eselon ORDER BY b.tmt_current DESC) AS pengalaman_eselon_gab,
                (SELECT SUBSTRING_INDEX(SUBSTRING_INDEX(GROUP_CONCAT(b.id_j ORDER BY b.tmt_current DESC), ',', 1), ', ', -1)) AS id_j_new,
                (SELECT SUBSTRING_INDEX(SUBSTRING_INDEX(GROUP_CONCAT(b.tmt_awal_jabatan ORDER BY b.tmt_current DESC), ',', 1), ', ', -1)) AS tmt_awal_jabatan_new,
                (SELECT SUBSTRING_INDEX(SUBSTRING_INDEX(GROUP_CONCAT(b.tmt_current ORDER BY b.tmt_current DESC), ',', 1), ', ', -1)) AS tmt_current_new,
                CAST(SUBSTRING_INDEX(GROUP_CONCAT(b.pengalaman_eselon ORDER BY b.tmt_current DESC), ',', 1) AS DECIMAL(11,2)) AS pengalaman_eselon_new
                FROM 
                (SELECT a.id_pegawai, MAX(a.id_j) AS id_j, MIN(a.tmt) AS tmt_awal_jabatan, MAX(a.tmt) AS tmt_current, a.eselon_jabatan, 
                GROUP_CONCAT(a.pengalaman_eselon ORDER BY a.pengalaman_eselon DESC SEPARATOR ',') AS pengalaman_eselon, COUNT(a.id_j) AS jml_jabatan, GROUP_CONCAT(DISTINCT a.jabatan_murni) AS jabatan_murni 
                FROM
                (SELECT sk.tmt, j.eselon AS eselon_jabatan, ROUND(DATEDIFF((SELECT STR_TO_DATE(NOW(), '%Y-%m-%d')), sk.tmt) / 365,2) AS pengalaman_eselon, j.id_j, j.jabatan,
                (CASE WHEN (SUBSTRING(j.jabatan,1,LOCATE('pada', j.jabatan)-2) IS NULL = 1 OR SUBSTRING(j.jabatan,1,LOCATE('pada', j.jabatan)-2) = '') THEN j.jabatan ELSE SUBSTRING(j.jabatan,1,LOCATE('pada', j.jabatan)-2) END) AS jabatan_murni, p.id_pegawai
                FROM pegawai p, sk LEFT JOIN jabatan j ON sk.id_j = j.id_j
                WHERE sk.id_kategori_sk = 10 AND j.jabatan NOT LIKE '%Kepala UPTD Puskesmas%'
                AND j.id_j IS NOT NULL AND p.id_pegawai = sk.id_pegawai AND p.flag_pensiun = 0
                ORDER BY sk.tmt ASC, sk.id_sk ASC) a
                GROUP BY a.id_pegawai, a.jabatan_murni ORDER BY a.id_pegawai ASC, a.tmt DESC) AS b
                GROUP BY b.id_pegawai
                ) c 
                INNER JOIN jabatan j ON c.id_j_new = j.id_j
                INNER JOIN pegawai p ON c.id_pegawai = p.id_pegawai 
                LEFT JOIN (
                SELECT d.id_draft, dp.id_pegawai FROM draft_pelantikan d 
                INNER JOIN draft_pelantikan_detail dp ON d.id_draft = dp.id_draft
                WHERE d.id_draft = $id_draft
                ) dp ON c.id_pegawai = dp.id_pegawai
                WHERE c.pengalaman_eselon_new >= 5 AND dp.id_draft IS NULL <> 1
                ORDER BY c.pengalaman_eselon_new DESC";

		$query = $query = $this->db->query($sql);

		$data = null;
		foreach ($query->result() as $row)
		{
			$data[] = $row;
		}
		return $data;
	}
	
	public function get_lepas_jabatan($id_draft){
		$query = $this->db->query("select d.*, p.nama as nama_pegawai, p.nip_baru, p.status_aktif, p.flag_pensiun, 
            DATE_FORMAT( p.tgl_pensiun_dini ,  '%d-%m-%Y' ) as tgl_pensiun_dini 
			from draft_pelantikan_lepas_jabatan d 
			inner join pegawai p on p.id_pegawai = d.id_pegawai 
			where d.id_draft = $id_draft 
			ORDER BY p.nama ASC");

		$data = null;
		foreach ($query->result() as $row)
		{
			$data[] = $row;
		}
		return $data;
	}
	
	public function get_by_id($id_draft){
		$query = $this->db->query("select d.id_draft, det.id_j, j.jabatan, j.eselon, 
            (CASE WHEN (p.flag_pensiun = 0 OR p.flag_pensiun = 2) THEN p.nama ELSE (CASE WHEN p.flag_pensiun = 1 THEN 'Kosong' ELSE NULL END) END) as nama_pegawai 
			from draft_pelantikan d
			inner join draft_pelantikan_detail det on det.id_draft = d.id_draft
			inner join jabatan j on j.id_j = det.id_j
			left join pegawai p on p.id_pegawai = det.id_pegawai
			where det.id_draft = $id_draft
			ORDER BY `j`.`eselon` ASC");

		$data = null;
		foreach ($query->result() as $row)
		{
			$data[] = $row;
		}
		return $data;
	}
	
	public function nominatif_by_id($id_draft, $eselon = NULL){
        $this->db->query("SET @row_number := 0");

        $sql = "SELECT
          FCN_ROW_NUMBER() as no_urut,
          draft_struktural.id_draft, draft_struktural.id_pegawai, draft_struktural.nip,
          draft_struktural.gelar_depan, draft_struktural.nama, draft_struktural.gelar_belakang,
          draft_struktural.tgl_lahir, draft_struktural.pangkat_gol, draft_struktural.pangkat,
          draft_struktural.jabatan_baru, draft_struktural.unit_baru, draft_struktural.eselon_baru,
          CASE WHEN draft_struktural.jabatan_lama IS NULL THEN
            CONCAT('Fungsional Umum pada ', draft_struktural.unit_lama)
          ELSE
            (CASE WHEN draft_struktural.eselon_lama IS NULL THEN CONCAT(draft_struktural.jabatan_lama,' pada ',draft_struktural.unit_lama)
            ELSE draft_struktural.jabatan_lama END)
          END AS jabatan_lama,
          draft_struktural.unit_lama, draft_struktural.eselon_lama,
          draft_struktural.keterangan, draft_struktural.id_pegawai_awal,
          CASE WHEN p.nip_baru IS NULL THEN '-' ELSE p.nip_baru END AS nip_pejabat_awal,
          CASE WHEN p.gelar_depan IS NULL THEN '-' ELSE p.gelar_depan END AS gelar_depan_pejabat_awal,
          CASE WHEN p.nama IS NULL THEN '-' ELSE p.nama END AS nama_pejabat_awal,
          CASE WHEN p.gelar_belakang IS NULL THEN '-' ELSE p.gelar_belakang END AS gelar_belakang_pejabat_awal,
          DATE_FORMAT(p.tgl_lahir,  '%d/%m/%Y') AS tgl_lahir_pejabat_awal
        FROM (SELECT
                 jab_baru.id_draft_dj_baru AS id_draft,
                 p.id_pegawai,
                 p.nip_baru AS nip,
                 p.gelar_depan,
                 p.nama,
                 p.gelar_belakang,
                 DATE_FORMAT(p.tgl_lahir,  '%d/%m/%Y') AS tgl_lahir,
                 p.pangkat_gol,
                 g.pangkat,
                 jab_baru.jabatan_baru,
                 jab_baru.unit_baru,
                 jab_baru.eselon_baru,
                 CASE WHEN p.jenjab = 'Fungsional' THEN p.jabatan ELSE CASE WHEN p.id_j IS NULL THEN
                (SELECT jm.nama_jfu AS jabatan
                 FROM jfu_pegawai jp, jfu_master jm
                 WHERE jp.kode_jabatan = jm.kode_jabatan AND jp.id_pegawai = p.id_pegawai LIMIT 1)
                ELSE j.jabatan END END AS jabatan_lama,
                 ukl.nama_baru AS unit_lama,
                 j.eselon AS eselon_lama,
                 IF(jab_baru.eselon_baru < j.eselon, 'Promosi',
                 IF(j.eselon IS NULL AND jab_baru.eselon_baru IS NOT NULL, 'Promosi', 'Rotasi')) AS keterangan,
                 jab_baru.id_pegawai_awal
       FROM (SELECT
                dpdl.id_draft AS id_draft_current,
                dj_baru.id_draft_dj_baru,
                dj_baru.idp_baru AS idpegawai,
                dj_baru.idj_baru,
                dpdl.id_j AS idj_lama,
                j.jabatan AS jabatan_baru,
                uk.nama_baru AS unit_baru,
                j.eselon AS eselon_baru,
                dj_baru.id_pegawai_awal
              FROM (SELECT
                       dpd.id_j AS idj_baru,
                       dpd.id_pegawai AS idp_baru,
                       dpd.id_pegawai_awal,
                       dpd.id_draft AS id_draft_dj_baru
                     FROM draft_pelantikan_detail dpd
                              WHERE (dpd.id_pegawai <> dpd.id_pegawai_awal OR (dpd.id_pegawai IS NOT NULL AND dpd.id_pegawai_awal IS NULL))
                            AND dpd.id_draft = ".$id_draft.") AS dj_baru
                            LEFT JOIN draft_pelantikan_detail dpdl ON dj_baru.idp_baru = dpdl.id_pegawai_awal AND dpdl.id_draft = ".$id_draft.",
                            jabatan j,
                            unit_kerja uk
                       WHERE
                       dj_baru.idj_baru = j.id_j
                       AND j.id_unit_kerja = uk.id_unit_kerja ) AS jab_baru
                       LEFT JOIN jabatan j ON j.id_j = jab_baru.idj_lama
                       INNER JOIN current_lokasi_kerja clk ON jab_baru.idpegawai = clk.id_pegawai
                       INNER JOIN unit_kerja ukl ON clk.id_unit_kerja = ukl.id_unit_kerja,
                     pegawai p,
                     golongan g
                WHERE p.id_pegawai = jab_baru.idpegawai
                AND p.pangkat_gol = g.golongan AND jab_baru.eselon_baru = '".$eselon."'
                ORDER BY jab_baru.unit_baru ASC) AS draft_struktural LEFT JOIN
                pegawai p ON draft_struktural.id_pegawai_awal = p.id_pegawai";

		$query = $this->db->query($sql);
		$data = null;
		foreach ($query->result() as $row)
		{
			$data[] = $row;
		}
		return $data;
	}
	
	public function get_eselon_pelantikan($id_draft){
		$sql = "SELECT DISTINCT j.eselon
            FROM draft_pelantikan_detail dpd, jabatan j
            WHERE (dpd.id_pegawai <> dpd.id_pegawai_awal OR (dpd.id_pegawai IS NOT NULL AND dpd.id_pegawai_awal IS NULL)) AND j.id_j = dpd.id_j AND dpd.id_draft = $id_draft
            ORDER BY j.eselon ASC";
		return $this->db->query($sql)->result();
	}

	public function save($tglpelantikan, $nama, $pass, $created_by){
        $tglpelantikan = explode(".", $tglpelantikan);
        $tglpelantikan = $tglpelantikan[2].'-'.$tglpelantikan[1].'-'.$tglpelantikan[0];
        $this->tgl_pelantikan = $tglpelantikan;
		$this->nama = $nama;
        $this->password = $pass;
		$this->created_by = $created_by;
		$this->db->insert('draft_pelantikan', $this);
        $id = $this->db->insert_id();
		return $id;
	}
	
	public function delete($id_draft){
		$this->db->where('id_draft', $id_draft);
		$this->db->delete('draft_pelantikan'); 
	}

	public function get_by_nama($nama, $id_draft, $type){
        $data = null;
        if($type == 'autocomplete') {
            $whereKlause = " where (p.nama like '%$nama%' or p.nip_baru like '%$nama%')";
        }else{
            $whereKlause = " where (p.nip_baru = '$nama')";
        }

        $sql = "select p.nama, p.id_pegawai from draft_pelantikan_detail dpd, pegawai p ".
                $whereKlause." and p.id_pegawai = dpd.id_pegawai and dpd.id_draft = ".$id_draft;

        $query = $this->db->query($sql);
        $rowcount = $query->num_rows();
        if($rowcount == 0){
            $strJoin = "det.id_pegawai_awal = p.id_pegawai ";
        }else{
            $strJoin = "det.id_pegawai = p.id_pegawai ";
        }
        $sql = "SELECT p.nama, p.id_pegawai, p.nip_baru, p.pangkat_gol, u.nama_baru, s.tmt,
                CASE WHEN j.jabatan IS NULL THEN '-' ELSE j.jabatan END AS jabatan,
                CASE WHEN j.id_j IS NULL THEN '-' ELSE j.id_j END AS id_j,
                CASE WHEN j.eselon IS NULL THEN '-' ELSE j.eselon END AS eselon,
                CASE WHEN s_jab.tmt_jabatan IS NULL THEN '-' ELSE s_jab.tmt_jabatan END AS tmt_jabatan,
                pend.tingkat_pendidikan, pend.jurusan_pendidikan, pend.lembaga_pendidikan, pend.tahun_lulus,
                CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
                p.nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(', ',p.gelar_belakang) END) AS nama_gelar,
                p.alamat, p.kota  
                from pegawai p
                inner join current_lokasi_kerja c on c.id_pegawai = p.id_pegawai
                inner join unit_kerja u on u.id_unit_kerja = c.id_unit_kerja
                left join (
                SELECT pt.id_pegawai, pt.id_pendidikan, pt.tingkat_pendidikan, pt.jurusan_pendidikan,
                pt.lembaga_pendidikan, pt.tahun_lulus
                FROM pendidikan_terakhir pt) AS pend ON pend.id_pegawai = p.id_pegawai
                left join (
                    select * from draft_pelantikan_detail where id_draft = $id_draft
                ) as det on ".$strJoin."
                left join jabatan j on j.id_j = det.id_j
                left join (
                    SELECT s.id_pegawai, date_format(s.tmt, '%d-%m-%Y') as tmt_jabatan
                    FROM pegawai p
                    INNER JOIN sk s ON s.id_pegawai = p.id_pegawai
                    WHERE id_kategori_sk = 10
                    AND s.id_j = p.id_j
                    GROUP BY s.id_pegawai
                    ORDER BY s.tmt DESC
                ) as s_jab on s_jab.id_pegawai = p.id_pegawai
                left join(
                    SELECT s.id_pegawai, date_format(s.tmt, '%d-%m-%Y') as tmt
                    FROM pegawai p
                    INNER JOIN sk s ON s.id_pegawai = p.id_pegawai
                    WHERE id_kategori_sk =5
                    AND s.gol = p.pangkat_gol
                    GROUP BY s.id_pegawai
                ) as s on s.id_pegawai = p.id_pegawai".$whereKlause." and flag_pensiun = 0
                order by nama ASC;";



		$query = $this->db->query($sql);

		foreach ($query->result() as $row)
		{
			$data[] = $row;
		}
		return $data;
	}
	
	public function get_pegawai($id_pegawai, $id_draft){
        $sql = "select * from draft_pelantikan_detail where id_pegawai = ".$id_pegawai." and id_draft = ".$id_draft;
        $query = $this->db->query($sql);
        $rowcount = $query->num_rows();
        if($rowcount == 0){
            $strJoin = "det.id_pegawai_awal = p.id_pegawai ";
        }else{
            $strJoin = "det.id_pegawai = p.id_pegawai ";
        }

        $sql = "select *, ROUND(DATEDIFF(CURRENT_DATE, DATE_FORMAT(STR_TO_DATE(CONCAT(SUBSTRING(p.nip_baru,9,4),'/',SUBSTRING(p.nip_baru,13,2),'/','01'),
                '%Y/%m/%d'), '%Y-%m-%d'))/365,2) AS masa_kerja, p.id_pegawai as id_pegawai_ori  
		from pegawai p 
		inner join current_lokasi_kerja c on c.id_pegawai = p.id_pegawai
		inner join unit_kerja u on u.id_unit_kerja = c.id_unit_kerja
		left join pendidikan_terakhir pt on pt.id_pegawai = p.id_pegawai
		left join (
			select * from draft_pelantikan_detail where id_draft = $id_draft
		) as det on ".$strJoin."
		left join jabatan j on j.id_j = det.id_j
		left join (
			SELECT s.id_pegawai, date_format(s.tmt, '%d-%m-%Y') as tmt_jabatan
			FROM pegawai p
			INNER JOIN sk s ON s.id_pegawai = p.id_pegawai
			WHERE id_kategori_sk = 10
			AND s.id_j = p.id_j
			GROUP BY s.id_pegawai
			ORDER BY s.tmt DESC
		) as s_jab on s_jab.id_pegawai = p.id_pegawai
		left join(
			SELECT s.id_pegawai, date_format(s.tmt, '%d-%m-%Y') as tmt
			FROM pegawai p
			INNER JOIN sk s ON s.id_pegawai = p.id_pegawai
			WHERE id_kategori_sk =5
			AND s.gol = p.pangkat_gol
			GROUP BY s.id_pegawai
		) as s on s.id_pegawai = p.id_pegawai
		left join bidang_pendidikan bp ON pt.id_bidang = bp.id
		where p.id_pegawai like '$id_pegawai' and flag_pensiun = 0
		order by nama asc";
		$query = $this->db->query($sql);

        //echo $sql;

		foreach ($query->result() as $row)
		{
			return $row;
		}
		return null;
	}

    public function getRekomendasiPejabat($id_j){
        $andKlausa = '';
        $query = $this->db->query("SELECT uk.id_skpd, j.eselon FROM jabatan j, unit_kerja uk
            WHERE id_j = $id_j AND j.id_unit_kerja = uk.id_unit_kerja");
        $data = null;
        foreach ($query->result() as $row)
        {
            $data[] = $row;
        }
        $this->idskpd_dest = $data[0]->id_skpd;

        if($data[0]->eselon!='IIIA' and $data[0]->eselon!='IIIB'){
            $andKlausa = '';
        }else{
            $andKlausa = "AND d.tgl_diklat <> '' ";
        }

        if($data[0]->eselon=='IIB' or $data[0]->eselon=='IVB' or $data[0]->eselon=='V'){
            $sql = "SELECT e.*, 
                    GROUP_CONCAT(CONCAT('Thn.', e.tahun_skp,\" (\",e.periode_awal,\") -> \", \"Orientasi Pelayanan=\", sh.orientasi_pelayanan, \", Integritas=\", sh.integritas, \", Komitmen=\", sh.komitmen, 
                    \", Disiplin=\", sh.disiplin, \", Kerjasama=\", sh.kerjasama, \", Kepemimpinan=\", (CASE WHEN sh.kepemimpinan IS NULL = 1 THEN 0 ELSE sh.kepemimpinan END), \", Rata-rata Perilaku = \",
                    ROUND(
                    ((sh.orientasi_pelayanan + sh.integritas + sh.komitmen + sh.disiplin + sh.kerjasama + (CASE WHEN sh.kepemimpinan IS NULL = 1 THEN 0 ELSE sh.kepemimpinan END)) /
                    (CASE WHEN sh.kepemimpinan IS NULL = 1 THEN (CASE WHEN e.eselonering = '' THEN 5 ELSE 6 END) ELSE 6 END))
                    ,2), \", Capaian SKP (60%) = \", (0.6*e.rata_rata_pencapaian_skp), \", Capaian Perilaku (40%) = \",
                    (0.4*(ROUND(
                    ((sh.orientasi_pelayanan + sh.integritas + sh.komitmen + sh.disiplin + sh.kerjasama + (CASE WHEN sh.kepemimpinan IS NULL = 1 THEN 0 ELSE sh.kepemimpinan END)) /
                    (CASE WHEN sh.kepemimpinan IS NULL = 1 THEN (CASE WHEN e.eselonering = '' THEN 5 ELSE 6 END) ELSE 6 END))
                    ,2))), \", Nilai Akhir SKP = \", ((0.6*e.rata_rata_pencapaian_skp) + 
                    (0.4*(ROUND(
                    ((sh.orientasi_pelayanan + sh.integritas + sh.komitmen + sh.disiplin + sh.kerjasama + (CASE WHEN sh.kepemimpinan IS NULL = 1 THEN 0 ELSE sh.kepemimpinan END)) /
                    (CASE WHEN sh.kepemimpinan IS NULL = 1 THEN (CASE WHEN e.eselonering = '' THEN 5 ELSE 6 END) ELSE 6 END))
                    ,2))))) SEPARATOR \" <br> \") AS skp  
                    FROM (SELECT d.*, MAX(sh.id_skp) AS id_skp FROM 
                    (SELECT c.no_reg, c.idskpd_tujuan, c.idpegawai, c.nip, c.nama, c.skpd, c.pangkat, c.masa_kerja, c.umur, c.jenis_jbtn, c.jabatan, c.eselonering,
                    c.tk_pendidikan, c.jml_diklat_pim_2, c.jml_diklat_pim_3, c.jml_diklat_pim_4, c.pengalaman_uk, c.pengalaman_eselon_current,
                    c.bayes_val_diklat_pim2, c.bayes_val_diklat_pim3, c.bayes_val_diklat_pim4, c.bayes_val_diklat_pim_null,
                    c.bayes_val_golongan, c.bayes_val_jenjab, c.bayes_val_masakerja, c.bayes_val_pendidikan, c.bayes_val_pengalaman,
                    c.bayes_val_umur, c.bayes_val_total,
                    c.tgl_diklat_barjas, c.tahun_skp, MAX(c.periode_awal) AS periode_awal, ROUND(AVG(c.rata_rata_pencapaian_skp),2) AS rata_rata_pencapaian_skp 
                    FROM (SELECT b.*, YEAR(sh.periode_awal) AS tahun_skp, sh.periode_awal, sh.periode_akhir, st.id_skp, 
                    ROUND(AVG(CASE WHEN st.nilai_capaian IS NULL = 1 THEN 0 ELSE st.nilai_capaian END),2) AS rata_rata_pencapaian_skp 
                    FROM 
                    (SELECT dptb.*, GROUP_CONCAT(DATE_FORMAT(d.tgl_diklat, '%d-%m-%Y') SEPARATOR \", \") AS tgl_diklat_barjas 
                    FROM draft_pelantikan_top_bayes dptb 
                    LEFT JOIN diklat d ON dptb.idpegawai = d.id_pegawai AND d.id_jenis_diklat = 3 AND d.nama_diklat LIKE '%Sertifikasi Pengadaan Barang dan Jasa%' 
                    WHERE dptb.idskpd_tujuan = ".$data[0]->id_skpd." AND dptb.jbtn_eselon = '".$data[0]->eselon."' ".$andKlausa.
                    "GROUP BY dptb.idskpd_tujuan, dptb.jbtn_eselon, dptb.idpegawai
                    ORDER BY bayes_val_total DESC, eselonering ASC, pengalaman_eselon_current DESC, masa_kerja DESC, jenis_jbtn DESC, pengalaman_uk DESC, pangkat, 
                    tk_pendidikan, jml_diklat_pim_4 DESC, umur DESC, nama ASC) b
                    LEFT JOIN skp_header sh ON b.idpegawai = sh.id_pegawai AND ((YEAR(sh.periode_awal) = 2018 AND YEAR(sh.periode_akhir) = 2018)
                    OR (YEAR(sh.periode_awal) = 2017 AND YEAR(sh.periode_akhir) = 2017)) 
                    LEFT JOIN skp_target st ON sh.id_skp = st.id_skp 
                    GROUP BY b.idpegawai, st.id_skp) c 
                    GROUP BY c.idpegawai, c.tahun_skp) d INNER JOIN skp_header sh ON d.periode_awal = sh.periode_awal AND d.idpegawai = sh.id_pegawai 
                    WHERE sh.orientasi_pelayanan > 0  and sh.integritas > 0 
                    GROUP BY d.idpegawai, d.tahun_skp) e INNER JOIN skp_header sh ON e.id_skp = sh.id_skp GROUP BY id_pegawai 
                    ORDER BY bayes_val_total DESC, eselonering ASC, pengalaman_eselon_current DESC, masa_kerja DESC, jenis_jbtn DESC, pengalaman_uk DESC, pangkat, tk_pendidikan, jml_diklat_pim_4 DESC, umur DESC, nama ASC";
            $query = $this->db->query($sql);
        }else{
            $sql = "SELECT e.*, 
                    GROUP_CONCAT(CONCAT('Thn.', e.tahun_skp,\" (\",e.periode_awal,\") -> \", \"Orientasi Pelayanan=\", sh.orientasi_pelayanan, \", Integritas=\", sh.integritas, \", Komitmen=\", sh.komitmen, 
                    \", Disiplin=\", sh.disiplin, \", Kerjasama=\", sh.kerjasama, \", Kepemimpinan=\", (CASE WHEN sh.kepemimpinan IS NULL = 1 THEN 0 ELSE sh.kepemimpinan END), \", Rata-rata Perilaku = \",
                    ROUND(
                    ((sh.orientasi_pelayanan + sh.integritas + sh.komitmen + sh.disiplin + sh.kerjasama + (CASE WHEN sh.kepemimpinan IS NULL = 1 THEN 0 ELSE sh.kepemimpinan END)) /
                    (CASE WHEN sh.kepemimpinan IS NULL = 1 THEN (CASE WHEN e.eselonering = '' THEN 5 ELSE 6 END) ELSE 6 END))
                    ,2), \", Capaian SKP (60%) = \", (0.6*e.rata_rata_pencapaian_skp), \", Capaian Perilaku (40%) = \",
                    (0.4*(ROUND(
                    ((sh.orientasi_pelayanan + sh.integritas + sh.komitmen + sh.disiplin + sh.kerjasama + (CASE WHEN sh.kepemimpinan IS NULL = 1 THEN 0 ELSE sh.kepemimpinan END)) /
                    (CASE WHEN sh.kepemimpinan IS NULL = 1 THEN (CASE WHEN e.eselonering = '' THEN 5 ELSE 6 END) ELSE 6 END))
                    ,2))), \", Nilai Akhir SKP = \", ((0.6*e.rata_rata_pencapaian_skp) + 
                    (0.4*(ROUND(
                    ((sh.orientasi_pelayanan + sh.integritas + sh.komitmen + sh.disiplin + sh.kerjasama + (CASE WHEN sh.kepemimpinan IS NULL = 1 THEN 0 ELSE sh.kepemimpinan END)) /
                    (CASE WHEN sh.kepemimpinan IS NULL = 1 THEN (CASE WHEN e.eselonering = '' THEN 5 ELSE 6 END) ELSE 6 END))
                    ,2))))) SEPARATOR \" <br> \") AS skp 
                    FROM (SELECT d.*, MAX(sh.id_skp) AS id_skp FROM 
                    (SELECT c.no_reg, c.idskpd_tujuan, c.idpegawai, c.nip, c.nama, c.skpd, c.pangkat, c.masa_kerja, c.umur, c.jenis_jbtn, c.jabatan, c.eselonering,
                    c.tk_pendidikan, c.jml_diklat_pim_2, c.jml_diklat_pim_3, c.jml_diklat_pim_4, c.pengalaman_uk, c.pengalaman_eselon_current,
                    c.tgl_diklat_barjas, c.tahun_skp, MAX(c.periode_awal) AS periode_awal, ROUND(AVG(c.rata_rata_pencapaian_skp),2) AS rata_rata_pencapaian_skp 
                    FROM (SELECT b.*, YEAR(sh.periode_awal) AS tahun_skp, sh.periode_awal, sh.periode_akhir, st.id_skp, 
                    ROUND(AVG(CASE WHEN st.nilai_capaian IS NULL = 1 THEN 0 ELSE st.nilai_capaian END),2) AS rata_rata_pencapaian_skp 
                    FROM 
                    (SELECT dptc.*, GROUP_CONCAT(DATE_FORMAT(d.tgl_diklat, '%d-%m-%Y') SEPARATOR \", \") AS tgl_diklat_barjas 
                    FROM draft_pelantikan_top_cruise dptc 
                    LEFT JOIN diklat d ON dptc.idpegawai = d.id_pegawai AND d.id_jenis_diklat = 3 AND d.nama_diklat LIKE '%Sertifikasi Pengadaan Barang dan Jasa%' 
                    WHERE dptc.idskpd_tujuan = ".$data[0]->id_skpd." AND dptc.jbtn_eselon = '".$data[0]->eselon."' ".$andKlausa.
                    "GROUP BY dptc.idskpd_tujuan, dptc.jbtn_eselon, dptc.idpegawai 
                    ORDER BY pangkat DESC, tk_pendidikan ASC, jml_diklat_pim_4 DESC, jenis_jbtn DESC, pengalaman_uk DESC, masa_kerja DESC, umur DESC, nama ASC) b
                    LEFT JOIN skp_header sh ON b.idpegawai = sh.id_pegawai AND ((YEAR(sh.periode_awal) = 2018 AND YEAR(sh.periode_akhir) = 2018)
                    OR (YEAR(sh.periode_awal) = 2017 AND YEAR(sh.periode_akhir) = 2017)) 
                    LEFT JOIN skp_target st ON sh.id_skp = st.id_skp
                    GROUP BY b.idpegawai, st.id_skp) c 
                    GROUP BY c.idpegawai, c.tahun_skp) d INNER JOIN skp_header sh ON d.periode_awal = sh.periode_awal AND d.idpegawai = sh.id_pegawai 
                    WHERE sh.orientasi_pelayanan > 0  and sh.integritas > 0
                    GROUP BY d.idpegawai, d.tahun_skp) e INNER JOIN skp_header sh ON e.id_skp = sh.id_skp GROUP BY id_pegawai 
                    ORDER BY pangkat DESC, tk_pendidikan ASC, jml_diklat_pim_4 DESC, jenis_jbtn DESC, pengalaman_uk DESC, masa_kerja DESC, umur DESC, nama ASC";
            $query = $this->db->query($sql);
        }

        $data = null;

        foreach ($query->result() as $row)
        {
            $data[] = $row;
        }
        return $data;
    }

    public function getIdSkpdTujuan(){
        return $this->idskpd_dest;
    }

    public function getDetailPegawai($no_reg, $jbtn_eselon, $type){
        if($jbtn_eselon=='IIB' or $jbtn_eselon=='IVB' or $jbtn_eselon=='V') {
            if($type == 'top_type') {
                $query = $this->db->query("SELECT dptb.idpegawai, dptb.nama, dptb.nip, uk.nama_baru, dptb.pangkat, dptb.masa_kerja,
                dptb.umur, dptb.jenis_jbtn, dptb.tk_pendidikan, dptb.jml_diklat_pim_2, dptb.jml_diklat_pim_3,
                dptb.jml_diklat_pim_4, dptb.pengalaman_uk, dptb.bayes_val_diklat_pim2, dptb.bayes_val_diklat_pim3,
                dptb.bayes_val_diklat_pim4, dptb.bayes_val_diklat_pim_null, dptb.bayes_val_golongan, dptb.bayes_val_jenjab,
                dptb.bayes_val_masakerja, dptb.bayes_val_pendidikan, dptb.bayes_val_pengalaman, dptb.bayes_val_umur,
                dptb.bayes_val_total, kp.nama_pendidikan, dptb.jabatan, dptb.eselonering, dptb.pengalaman_eselon_current
			    FROM  draft_pelantikan_top_bayes dptb, unit_kerja uk, kategori_pendidikan kp
			    WHERE no_reg = $no_reg AND dptb.skpd = uk.id_unit_kerja AND dptb.tk_pendidikan = kp.level_p");
            }else{
                $query = $this->db->query("SELECT dptb.idpegawai, dptb.nama, dptb.nip, uk.nama_baru, dptb.pangkat, dptb.masa_kerja,
                dptb.umur, dptb.jenis_jbtn, dptb.tk_pendidikan, dptb.jml_diklat_pim_2, dptb.jml_diklat_pim_3,
                dptb.jml_diklat_pim_4, dptb.pengalaman_uk, dptb.bayes_val_diklat_pim2, dptb.bayes_val_diklat_pim3,
                dptb.bayes_val_diklat_pim4, dptb.bayes_val_diklat_pim_null, dptb.bayes_val_golongan, dptb.bayes_val_jenjab,
                dptb.bayes_val_masakerja, dptb.bayes_val_pendidikan, dptb.bayes_val_pengalaman, dptb.bayes_val_umur,
                dptb.bayes_val_total, kp.nama_pendidikan,
                CASE WHEN j.jabatan IS NULL = 1 THEN '' ELSE j.jabatan END AS jabatan,
                dptb.eselonering, dptb.pengalaman_eselon_current
                FROM  draft_pelantikan_base_bayes dptb, unit_kerja uk, kategori_pendidikan kp,
                pegawai p LEFT JOIN jabatan j ON p.id_j = j.id_j
                WHERE no_reg = $no_reg AND dptb.idpegawai = p.id_pegawai AND dptb.skpd = uk.id_unit_kerja
                AND dptb.tk_pendidikan = kp.level_p;");
            }
        }else{
            if($type == 'top_type') {
                $query = $this->db->query("SELECT dptc.*, uk.nama_baru, kp.nama_pendidikan
                FROM  draft_pelantikan_top_cruise dptc, unit_kerja uk, kategori_pendidikan kp
			    WHERE no_reg = $no_reg AND dptc.skpd = uk.id_unit_kerja AND dptc.tk_pendidikan = kp.level_p");
            }else{
                $query = $this->db->query("SELECT dptc.*, uk.nama_baru, kp.nama_pendidikan,
                CASE WHEN j.jabatan IS NULL = 1 THEN '' ELSE j.jabatan END AS jabatan,
                dptc.eselonering, dptc.pengalaman_eselon_current
                FROM  draft_pelantikan_base_cruise dptc, unit_kerja uk, kategori_pendidikan kp,
                pegawai p LEFT JOIN jabatan j ON p.id_j = j.id_j
			    WHERE no_reg = $no_reg AND dptc.idpegawai = p.id_pegawai AND dptc.skpd = uk.id_unit_kerja
			    AND dptc.tk_pendidikan = kp.level_p");
            }
        }
        $data = null;
        foreach ($query->result() as $row)
        {
            $data[] = $row;
        }
        return $data;
    }

    public function dropDataOtherRekomendasi($limit_mulai, $limit_banyaknya, $idskpd, $jbtn_eselon, $tipe_rekomendasi,$keywordSuggest){
        if($tipe_rekomendasi == 'bayesnet') {
            $sql = "CALL PRCD_DROP_DATA_OTHER_REKOMEND_BAYES($limit_mulai,$limit_banyaknya,$idskpd,'$jbtn_eselon','$keywordSuggest')";
        }else{
            $sql = "CALL PRCD_DROP_DATA_OTHER_REKOMEND_CRUISE($limit_mulai,$limit_banyaknya,$idskpd,'$jbtn_eselon','$keywordSuggest')";
        }
        $query = $this->db->query($sql);
        $data = null;
        foreach ($query->result() as $row)
        {
            $data[] = $row;
        }
        return $data;
    }

    public function getCountAlldropDataSortManualRekomendasi($idskpd, $jbtn_eselon, $a,$b,$c,$d,$e,$f,$g, $filter, $pend, $txtKeyword, $barjas, $mkjabatan){
        $orderby_query_string = "";
        $andKlausa = " AND jenjab = 'Struktural' ";
        if($a!='0'){
            if($a=='tk_pendidikan'){
                $orderby_query_string.= " ORDER BY level_p ASC";
            }else{
                $orderby_query_string.= " ORDER BY ".$a." DESC";
            }
        }
        if($b!='0'){
            $orderby_query_string.= ", ".$b." DESC";
        }
        if($c!='0'){
            $orderby_query_string.= ", ".$c." DESC";
        }
        if($d!='0'){
            $orderby_query_string.= ", ".$d." DESC";
        }
        if($e!='0'){
            $orderby_query_string.= ", ".$e." DESC";
        }
        if($f!='0'){
            $orderby_query_string.= ", ".$f." DESC";
        }
        if($g!='0'){
            $orderby_query_string.= ", ".$g." DESC";
        }
        if($filter == 'Promosi'){
            switch (strtolower($jbtn_eselon)) {
                case 'iib' :
                    $andKlausa .= "AND eselon = 'IIIA' AND pengalaman_eselon_current >= 2";
                    break;
                case 'iiia' :
                    $andKlausa .= "AND eselon = 'IIIB' AND pengalaman_eselon_current >= 2";
                    break;
                case 'iiib' :
                    $andKlausa .= "AND eselon = 'IVA' AND pengalaman_eselon_current >= 2";
                    break;
                case 'iva' :
                    $andKlausa .= "AND ((eselon = 'IVB' AND pengalaman_eselon_current >= 2) OR
              (eselon = 'V' AND pengalaman_eselon_current >= 2) OR eselon = '' OR eselon IS NULL = 1)";
                    break;
                case 'ivb' :
                    $andKlausa .= "AND ((eselon = 'V' AND pengalaman_eselon_current >= 2) OR eselon = '' OR eselon IS NULL = 1)";
                    break;
            }
        }elseif($filter == 'Rotasi'){
            $andKlausa .= " AND eselon = '".$jbtn_eselon."' ";
        }
        if($pend!='0'){
            $andKlausa .= " AND id_bidang = ".$pend;
        }
        if (!(trim($txtKeyword)== "") && !(trim($txtKeyword)== "0")){
            $andKlausa = " AND (nip_baru LIKE '%".$txtKeyword."%'
								OR nama LIKE '%".$txtKeyword."%'
								OR unit LIKE '%".$txtKeyword."%'
								OR jabatan LIKE '%".$txtKeyword."%')".$andKlausa;
        }
        if($barjas!='0'){
            if($barjas==1){
                $andKlausa .= " AND d.tgl_diklat <> '' ";
            }else{
                $andKlausa .= " AND d.tgl_diklat IS NULL ";
            }
        }
        if($mkjabatan!='0' and $mkjabatan!=''){
            $andKlausa .= " AND dps.pengalaman_eselon_current >= $mkjabatan";
        }

        $sql = "SELECT COUNT(*) as jumlah_all FROM
            (SELECT e.* FROM (SELECT d.*, MAX(sh.id_skp) AS id_skp FROM (SELECT c.* FROM (SELECT b.*, YEAR(sh.periode_awal) AS tahun_skp, sh.periode_awal FROM (SELECT a.* FROM (SELECT dps.no_reg, dps.id_pegawai  
            FROM draft_pelantikan_sort_manual dps 
            LEFT JOIN diklat d ON dps.id_pegawai = d.id_pegawai AND d.id_jenis_diklat = 3 AND d.nama_diklat LIKE '%Sertifikasi Pengadaan Barang dan Jasa%', 
            kategori_pendidikan kp 
            WHERE dps.tk_pendidikan = kp.nama_pendidikan AND idskpd_tujuan = ".$idskpd.$andKlausa." GROUP BY dps.id_pegawai) a LEFT JOIN hukuman h ON a.id_pegawai = h.id_pegawai 
            GROUP BY a.id_pegawai)b LEFT JOIN skp_header sh ON b.id_pegawai = sh.id_pegawai AND ((YEAR(sh.periode_awal) = 2018 AND YEAR(sh.periode_akhir) = 2018) OR (YEAR(sh.periode_awal) = 2017 AND YEAR(sh.periode_akhir) = 2017)) 
            LEFT JOIN skp_target st ON sh.id_skp = st.id_skp 
            GROUP BY b.id_pegawai, st.id_skp) c GROUP BY c.id_pegawai, c.tahun_skp) d 
            LEFT JOIN skp_header sh ON d.periode_awal = sh.periode_awal AND d.id_pegawai = sh.id_pegawai AND sh.orientasi_pelayanan > 0 and sh.integritas > 0  
            GROUP BY d.id_pegawai, d.tahun_skp) e 
            LEFT JOIN skp_header sh ON e.id_skp = sh.id_skp 
            LEFT JOIN pegawai p ON e.id_pegawai = p.id_pegawai 
            GROUP BY e.id_pegawai) f";

        $query = $this->db->query($sql);
        foreach ($query->result() as $row){
            $count = $row->jumlah_all;
        }
        return $count;
    }

    public function getDropDataSortManualRekomendasi($row_number_start,$idskpd,$jbtn_eselon,$a,$b,$c,$d,$e,$f,$g,$filter,$pend,$txtKeyword,$barjas,$mkjabatan,$limit,$posisi){
        $orderby_query_string = "";
        $andKlausa = " AND jenjab = 'Struktural' ";
        if($a!='0'){
            if($a=='tk_pendidikan'){
                $orderby_query_string.= " ORDER BY level_p ASC";
            }else{
                $orderby_query_string.= " ORDER BY ".$a." DESC";
            }
        }
        if($b!='0'){
            $orderby_query_string.= ", ".$b." DESC";
        }
        if($c!='0'){
            $orderby_query_string.= ", ".$c." DESC";
        }
        if($d!='0'){
            $orderby_query_string.= ", ".$d." DESC";
        }
        if($e!='0'){
            $orderby_query_string.= ", ".$e." DESC";
        }
        if($f!='0'){
            $orderby_query_string.= ", ".$f." DESC";
        }
        if($g!='0'){
            $orderby_query_string.= ", ".$g." DESC";
        }
        if($filter == 'Promosi'){
            switch (strtolower($jbtn_eselon)) {
                case 'iib' :
                    $andKlausa .= "AND eselon = 'IIIA' AND pengalaman_eselon_current >= 2";
                    break;
                case 'iiia' :
                    $andKlausa .= "AND eselon = 'IIIB' AND pengalaman_eselon_current >= 2";
                    break;
                case 'iiib' :
                    $andKlausa .= "AND eselon = 'IVA' AND pengalaman_eselon_current >= 2";
                    break;
                case 'iva' :
                    $andKlausa .= "AND ((eselon = 'IVB' AND pengalaman_eselon_current >= 2) OR
              (eselon = 'V' AND pengalaman_eselon_current >= 2) OR eselon = '' OR eselon IS NULL = 1)";
                    break;
                case 'ivb' :
                    $andKlausa .= "AND ((eselon = 'V' AND pengalaman_eselon_current >= 2) OR eselon = '' OR eselon IS NULL = 1)";
                    break;
            }
        }elseif($filter == 'Rotasi'){
            $andKlausa .= " AND eselon = '".$jbtn_eselon."' ";
        }
        if($pend!='0'){
            $andKlausa .= " AND id_bidang = ".$pend;
        }
        if (!(trim($txtKeyword)== "") && !(trim($txtKeyword)== "0")){
            $andKlausa = " AND (nip_baru LIKE '%".$txtKeyword."%'
								OR nama LIKE '%".$txtKeyword."%'
								OR unit LIKE '%".$txtKeyword."%'
								OR jabatan LIKE '%".$txtKeyword."%')".$andKlausa;
        }
        if($barjas!='0'){
            if($barjas==1){
                $andKlausa .= " AND d.tgl_diklat <> '' ";
            }else{
                $andKlausa .= " AND d.tgl_diklat IS NULL ";
            }
        }
        if($mkjabatan!='0' and $mkjabatan!=''){
            $andKlausa .= " AND dps.pengalaman_eselon_current >= $mkjabatan";
        }

        $this->db->query("SET @row_number := $row_number_start");
        $sql = "SELECT FCN_ROW_NUMBER() as no_urut, e.*, 
                GROUP_CONCAT(CONCAT('Thn.', e.tahun_skp,\" (\",e.periode_awal,\") :: \", \"Orientasi Pelayanan=\", sh.orientasi_pelayanan, \", Integritas=\", sh.integritas, \", Komitmen=\", sh.komitmen, 
                \", Disiplin=\", sh.disiplin, \", Kerjasama=\", sh.kerjasama, \", Kepemimpinan=\", (CASE WHEN sh.kepemimpinan IS NULL = 1 THEN 0 ELSE sh.kepemimpinan END), \", Rata-rata Perilaku = \",
                ROUND(
                ((sh.orientasi_pelayanan + sh.integritas + sh.komitmen + sh.disiplin + sh.kerjasama + (CASE WHEN sh.kepemimpinan IS NULL = 1 THEN 0 ELSE sh.kepemimpinan END)) /
                (CASE WHEN sh.kepemimpinan IS NULL = 1 THEN (CASE WHEN e.eselon = 'Z' THEN 5 ELSE 6 END) ELSE 6 END))
                ,2), \", Capaian SKP (60%) = \", (0.6*e.rata_rata_pencapaian_skp), \", Capaian Perilaku (40%) = \",
                (0.4*(ROUND(
                ((sh.orientasi_pelayanan + sh.integritas + sh.komitmen + sh.disiplin + sh.kerjasama + (CASE WHEN sh.kepemimpinan IS NULL = 1 THEN 0 ELSE sh.kepemimpinan END)) /
                (CASE WHEN sh.kepemimpinan IS NULL = 1 THEN (CASE WHEN e.eselon = 'Z' THEN 5 ELSE 6 END) ELSE 6 END))
                ,2))), \", <br>Nilai Akhir SKP = \", ((0.6*e.rata_rata_pencapaian_skp) + 
                (0.4*(ROUND(
                ((sh.orientasi_pelayanan + sh.integritas + sh.komitmen + sh.disiplin + sh.kerjasama + (CASE WHEN sh.kepemimpinan IS NULL = 1 THEN 0 ELSE sh.kepemimpinan END)) /
                (CASE WHEN sh.kepemimpinan IS NULL = 1 THEN (CASE WHEN e.eselon = 'Z' THEN 5 ELSE 6 END) ELSE 6 END))
                ,2)))
                )  
                ) SEPARATOR \" <br> \") AS skp, p.alamat, p.kota  
                FROM (SELECT d.*, MAX(sh.id_skp) AS id_skp FROM 
                (SELECT c.no_reg, c.idskpd_tujuan, c.id_pegawai, c.nip_baru, c.nama, c.unit, c.id_skpd, c.pangkat_gol, c.masa_kerja, c.umur, c.jenjab, c.jabatan, c.eselon,
                c.tk_pendidikan, c.id_bidang, c.jurusan_pendidikan, c.jml_diklat_pim_2, c.jml_diklat_pim_3, c.jml_diklat_pim_4, c.pengalaman_uk, c.pengalaman_eselon_current,
                c.tmt_bup, c.level_p, c.tgl_diklat_barjas, c.hukuman, c.tahun_skp, MAX(c.periode_awal) AS periode_awal, ROUND(AVG(c.rata_rata_pencapaian_skp),2) AS rata_rata_pencapaian_skp 
                FROM (SELECT b.*, YEAR(sh.periode_awal) AS tahun_skp, sh.periode_awal, sh.periode_akhir, st.id_skp, 
                ROUND(AVG(CASE WHEN st.nilai_capaian IS NULL = 1 THEN 0 ELSE st.nilai_capaian END),2) AS rata_rata_pencapaian_skp 
                FROM 
                (SELECT a.*, GROUP_CONCAT(h.keterangan,' (',YEAR(h.tmt),') ',' | ') AS hukuman  FROM
                (SELECT dps.*,
                DATE_FORMAT(DATE_SUB(
                LAST_DAY(
                    DATE_ADD(DATE_ADD(CONCAT(SUBSTRING(nip_baru,1,4),'-',SUBSTRING(nip_baru,5,2),'-',SUBSTRING(nip_baru,7,2)), INTERVAL (SELECT CASE WHEN (eselon = 'IIA' OR eselon = 'IIB') THEN 60 ELSE 58 END) YEAR), INTERVAL 1 MONTH)
                ),
                INTERVAL DAY(
                    LAST_DAY(
                        DATE_ADD(DATE_ADD(CONCAT(SUBSTRING(nip_baru,1,4),'-',SUBSTRING(nip_baru,5,2),'-',SUBSTRING(nip_baru,7,2)), INTERVAL (SELECT CASE WHEN (eselon = 'IIA' OR eselon = 'IIB') THEN 60 ELSE 58 END) YEAR), INTERVAL 1 MONTH)
                    )
                )-1 DAY
            ),  '%d/%m/%Y')AS tmt_bup, level_p, GROUP_CONCAT(DATE_FORMAT(d.tgl_diklat, '%d-%m-%Y') SEPARATOR \", \") AS tgl_diklat_barjas 
            FROM draft_pelantikan_sort_manual dps 
            LEFT JOIN diklat d ON dps.id_pegawai = d.id_pegawai AND d.id_jenis_diklat = 3 AND d.nama_diklat LIKE '%Sertifikasi Pengadaan Barang dan Jasa%', 
            kategori_pendidikan kp
            WHERE dps.tk_pendidikan = kp.nama_pendidikan AND idskpd_tujuan = ".$idskpd.$andKlausa." GROUP BY dps.id_pegawai ".$orderby_query_string.$limit.
            ")a LEFT JOIN hukuman h ON a.id_pegawai = h.id_pegawai GROUP BY a.id_pegawai)b
            LEFT JOIN skp_header sh ON b.id_pegawai = sh.id_pegawai AND ((YEAR(sh.periode_awal) = 2018 AND YEAR(sh.periode_akhir) = 2018)
            OR (YEAR(sh.periode_awal) = 2017 AND YEAR(sh.periode_akhir) = 2017)) 
            LEFT JOIN skp_target st ON sh.id_skp = st.id_skp
            GROUP BY b.id_pegawai, st.id_skp) c 
            GROUP BY c.id_pegawai, c.tahun_skp) d 
            LEFT JOIN skp_header sh ON d.periode_awal = sh.periode_awal AND d.id_pegawai = sh.id_pegawai AND sh.orientasi_pelayanan > 0  and sh.integritas > 0 
            GROUP BY d.id_pegawai, d.tahun_skp) e 
            LEFT JOIN skp_header sh ON e.id_skp = sh.id_skp 
            LEFT JOIN pegawai p ON e.id_pegawai = p.id_pegawai 
            GROUP BY id_pegawai ".$orderby_query_string.', no_urut';

        $query = $this->db->query($sql);
        $data = null;
        foreach ( $query->result() as $row)
        {
            $data[] = $row;
        }
        return $data;
    }

    public function get_draft_pelantikan_by_id($id_draft){
	    $sql = "SELECT * FROM draft_pelantikan WHERE id_draft = $id_draft";
        $query = $this->db->query($sql);
        $data = null;
        foreach ($query->result() as $row){
            return $row;
        }
        return null;
    }

    public function pengalaman_eselon_pegawai($id_pegawai, $eselon, $tgl_pelantikan=null){
        $sql = "CALL PRCD_PENGALAMAN_ESELON(?, ?, ?, @pengalaman_eselon, @jml_jabatan)";
        $tgl_pelantikan = substr($tgl_pelantikan,1,10);
        $this->db->query($sql, array('_idpegawai'=>$id_pegawai, '_lbleselon_cur'=>$eselon, '_tgl_pelantikan'=>$tgl_pelantikan));
        $query = $this->db->query('SELECT @pengalaman_eselon AS pengalaman_eselon, @jml_jabatan AS jml_jabatan');
        $data = null;
        foreach ($query->result() as $row){
            return $row;
        }
        return null;
    }

    public function getEselonDibawahnya($eselon){
        $sql = "SELECT eselon FROM golongan_eselon ge WHERE eselon > '".$eselon."' LIMIT 1";
        $query = $this->db->query($sql);
        $data = null;
        foreach ($query->result() as $row){
            return $row;
        }
        return null;
    }

    public function batal_pelantikan($data){
        $icon_warning = "<img src='".base_url().'images/Warning.png'."' width='64'>";
        $icon_ok = "<img src='".base_url().'images/Checked.png'."' width='64'>";
        $cttn = "";

        $sql = "SELECT a.*, dpd.id_j AS idj_usulan_dr_pegawai_awal FROM
(               SELECT dpd.id_j AS idj_baru, dpd.id_pegawai AS idp_baru, dpd.id_pegawai_awal, j.jabatan
                FROM draft_pelantikan_detail dpd, jabatan j
                WHERE dpd.id_j = j.id_j AND (dpd.id_pegawai = ".$data['id_pegawai_baru']."
                OR dpd.id_pegawai_awal = ".$data['id_pegawai_baru'].") AND dpd.id_draft = ".$data['id_draft']."
                ORDER BY idp_baru) a LEFT JOIN draft_pelantikan_detail dpd ON
                a.id_pegawai_awal = dpd.id_pegawai AND dpd.id_draft = ".$data['id_draft'];

        $query = $this->db->query($sql);
        $rowcount = $query->num_rows();
        if($rowcount == 1) {
            foreach ($query->result() as $row){
                $sql = "SELECT dpd.id_j, j.jabatan, j.eselon, COUNT(dpd.id_pegawai) as jml
                    FROM draft_pelantikan_detail dpd, jabatan j
                    WHERE dpd.id_pegawai = " . (isset($row->id_pegawai_awal)?$row->id_pegawai_awal:0) . " AND dpd.id_j = j.id_j AND dpd.id_draft = ".$data['id_draft']."
                    GROUP BY dpd.id_j, j.jabatan, j.eselon";

                $query_count = $this->db->query($sql);
                $rowcount = $query_count->num_rows();
                if($rowcount > 0) { // Jika pejabat awal sedang dicalonkan
                    foreach ($query_count->result() as $row_c){
                        if($row->id_pegawai_awal==$row->idp_baru){
                        }else{
                            $cttn .= "Pejabat awal sedang dicalonkan menjadi ".$row_c->jabatan.' (Eselon: '.$row_c->eselon.')';
                            $notes = array($cttn, $icon_warning, 0);
                            $this->db->trans_begin();
                            $sql = "update draft_pelantikan_detail set id_pegawai =  id_pegawai_awal
                                        where id_j = " . $row->idj_baru  . " AND id_draft = ".$data['id_draft'];
                            $this->db->query($sql);
                            if ($this->db->trans_status() === FALSE) {
                                $this->db->trans_rollback();
                                $query = false;
                                $notes = array("Query gagal", $icon_warning, 0);
                            }else{
                                $sqlLog = "insert into draft_pelantikan_log (id_user,id_draft,id_pegawai,idj_awal,idj_akhir,id_transaksi) values (".
                                    $this->session->userdata('user')->id_pegawai.",".$data['id_draft'].",".$data['id_pegawai_baru'].",".$row->idj_baru.",0,3)";
                                $this->db->query($sqlLog);
                                if ($this->db->trans_status() === FALSE) {
                                    $this->db->trans_rollback();
                                    $query = false;
                                    $cttn .= "Query gagal";
                                    $notes = array($cttn, $icon_warning, 0);
                                } else {
                                    $this->db->trans_commit();
                                    $query = true;
                                    $cttn .= $row->jabatan." Sukses dibatalkan.";
                                    $notes = array($cttn, $icon_ok, 1);
                                }
                            }
                        }
                    }
                }else{ // Jika pejabat awal tidak sedang dicalonkan
                    $this->db->trans_begin();
                    if(isset($row->id_pegawai_awal)==true){
                        $sql = "update draft_pelantikan_detail set id_pegawai = id_pegawai_awal where id_pegawai = ".$data['id_pegawai_baru']." AND id_draft = ".$data['id_draft'];
                    }else{
                        $sql = "update draft_pelantikan_detail set id_pegawai = null where id_pegawai = ".$data['id_pegawai_baru']." AND id_draft = ".$data['id_draft'];
                    }
                    $this->db->query($sql);
                    if ($this->db->trans_status() === FALSE){
                        $this->db->trans_rollback();
                        $query = false;
                        $cttn .= "Query gagal";
                        $notes = array($cttn, $icon_warning, 0);
                    }else{
                        if(isset($row->id_pegawai_awal)==true) { //Jika sebelumnya jabatan tsb tidak kosong
                            if(isset($row->id_pegawai_awal)==true) {
                                $a = $row->id_pegawai_awal;
                            }else{
                                $a = 0;
                            }
                            $sql = "delete from draft_pelantikan_lepas_jabatan where id_pegawai = ".$a." and id_draft = ".$data['id_draft'];
                            $this->db->query($sql);

                            if ($this->db->trans_status() === FALSE) {
                                $this->db->trans_rollback();
                                $query = false;
                                $cttn .= "Query gagal";
                                $notes = array($cttn, $icon_warning, 0);
                            } else {
                                $sqlLog = "insert into draft_pelantikan_log (id_user,id_draft,id_pegawai,idj_awal,idj_akhir,id_transaksi) values (".
                                    $this->session->userdata('user')->id_pegawai.",".$data['id_draft'].",".$data['id_pegawai_baru'].",".$row->idj_baru.",0,3)";
                                $this->db->query($sqlLog);
                                if ($this->db->trans_status() === FALSE) {
                                    $this->db->trans_rollback();
                                    $query = false;
                                    $cttn .= "Query gagal";
                                    $notes = array($cttn, $icon_warning, 0);
                                } else {
                                    $this->db->trans_commit();
                                    $query = true;
                                    $cttn .= $row->jabatan." Sukses dibatalkan.";
                                    $notes = array($cttn, $icon_ok, 1);
                                }
                            }
                        }else{ //Jika sebelumnya jabatan tsb kosong
                            $sqlLog = "insert into draft_pelantikan_log (id_user,id_draft,id_pegawai,idj_awal,idj_akhir,id_transaksi) values (".
                                       $this->session->userdata('user')->id_pegawai.",".$data['id_draft'].",".$data['id_pegawai_baru'].",".$row->idj_baru.",0,3)";
                            $this->db->query($sqlLog);
                            if ($this->db->trans_status() === FALSE) {
                                $this->db->trans_rollback();
                                $query = false;
                                $cttn .= "Query gagal";
                                $notes = array($cttn, $icon_warning, 0);
                            } else {
                                $this->db->trans_commit();
                                $query = true;
                                $cttn .= $row->jabatan." Sukses dibatalkan.";
                                $notes = array($cttn, $icon_ok, 1);
                            }
                        }
                    }
                }
            }
        }else{
            foreach ($query->result() as $row){
                if($row->idp_baru == $data['id_pegawai_baru']){
                    $sql = "SELECT dpd.id_j, j.jabatan, j.eselon, COUNT(dpd.id_pegawai) as jml
                    FROM draft_pelantikan_detail dpd, jabatan j
                    WHERE dpd.id_pegawai = ". (isset($row->id_pegawai_awal)?$row->id_pegawai_awal:0) ." AND dpd.id_j = j.id_j AND dpd.id_draft = ".$data['id_draft']."
                    GROUP BY dpd.id_j, j.jabatan, j.eselon";

                    $query_count = $this->db->query($sql);
                    $rowcount = $query_count->num_rows();
                    if($rowcount > 0) { // // update pejabat yg baru dicalonkan kembali ke tempat semula
                        foreach ($query_count->result() as $row_c){
                            if($row->id_pegawai_awal==$row->idp_baru){
                            }else{
                                $cttn .= "Pejabat awal sedang dicalonkan juga menjadi ".$row_c->jabatan.' (Eselon: '.$row_c->eselon.').';
                                $notes = array($cttn, $icon_warning, 0);
                                $this->db->trans_begin();
                                $sql = "update draft_pelantikan_detail set id_pegawai =  NULL
                                        where id_j = " . $row->idj_baru  . " AND id_draft = ".$data['id_draft'];
                                $this->db->query($sql);
                                if ($this->db->trans_status() === FALSE) {
                                    $this->db->trans_rollback();
                                    $query = false;
                                    $notes = array("Query gagal", $icon_warning, 0);
                                }else{
                                    $sqlLog = "insert into draft_pelantikan_log (id_user,id_draft,id_pegawai,idj_awal,idj_akhir,id_transaksi) values (".
                                        $this->session->userdata('user')->id_pegawai.",".$data['id_draft'].",".$data['id_pegawai_baru'].",".$row->idj_usulan_dr_pegawai_awal.",$row->idj_baru,3)";
                                    $this->db->query($sqlLog);
                                    if ($this->db->trans_status() === FALSE) {
                                        $this->db->trans_rollback();
                                        $query = false;
                                        $cttn .= "Query gagal";
                                        $notes = array($cttn, $icon_warning, 0);
                                    } else {
                                        $this->db->trans_commit();
                                        $query = true;
                                        $cttn .= $row->jabatan." Sukses dibatalkan.";
                                        $notes = array($cttn, $icon_ok, 1);
                                    }
                               }
                            }
                        }
                    }else{ // update pejabat awal kembali ke tempat semula
                        $this->db->trans_begin();
                        $sql = "update draft_pelantikan_detail set id_pegawai =  id_pegawai_awal where id_pegawai = " . $data['id_pegawai_baru']  . " AND id_draft = ".$data['id_draft'];
                        $this->db->query($sql);
                        if ($this->db->trans_status() === FALSE)
                        {
                            $this->db->trans_rollback();
                            $query = false;
                            $notes = array("Query gagal", $icon_warning, 0);
                        }else{
                            if(isset($row->id_pegawai_awal)==true) {
                                $sql = "delete from draft_pelantikan_lepas_jabatan where id_pegawai = ".$data['id_pegawai_awal']." and id_draft = " . $data['id_draft'];
                                $this->db->query($sql);
                                if ($this->db->trans_status() === FALSE) {
                                    $this->db->trans_rollback();
                                    $query = false;
                                    $notes = array("Query gagal", $icon_warning, 0);
                                } else {
                                    // Log pejabat awal
                                    $sqlLog = "insert into draft_pelantikan_log (id_user,id_draft,id_pegawai,idj_awal,idj_akhir,id_transaksi) values (".
                                        $this->session->userdata('user')->id_pegawai.",".$data['id_draft'].",".$data['id_pegawai_awal'].",0,$row->idj_baru,3)";
                                    $this->db->query($sqlLog);

                                    if ($this->db->trans_status() === FALSE) {
                                        $this->db->trans_rollback();
                                        $query = false;
                                        $cttn .= "Query gagal";
                                        $notes = array($cttn, $icon_warning, 0);
                                    } else {
                                        $this->db->trans_commit();
                                        $query = true;
                                        $cttn .= $row->jabatan." Sukses dibatalkan.";
                                        $notes = array($cttn, $icon_ok, 1);
                                    }
                                }
                            }else{ // dari jabatan kosong asalnya, tidak insert log sdh diinsert dari loop sblmnya
                                $sql = "update draft_pelantikan_detail set id_pegawai =  null where id_pegawai = " .
                                    $data['id_pegawai_baru']  . " AND id_draft = ".$data['id_draft'] . " and id_pegawai_awal is null";
                                $this->db->query($sql);
                                if ($this->db->trans_status() === FALSE) {
                                    $this->db->trans_rollback();
                                    $query = false;
                                    $notes = array("Query gagal", $icon_warning, 0);
                                } else {
                                    $this->db->trans_commit();
                                    $query = true;
                                    $cttn .= $row->jabatan." Sukses dibatalkan.";
                                    $notes = array($cttn, $icon_ok, 1);
                                }
                            }
                        }
                    }
                }elseif($row->idp_baru == ''){
                    $this->db->trans_begin();
                    $sql = "update draft_pelantikan_detail set id_pegawai =  id_pegawai_awal where (id_pegawai_awal = " . $data['id_pegawai_baru']."
                    OR (id_pegawai_awal IS NULL AND id_pegawai = " .$data['id_pegawai_baru']. ")) and id_draft = ".$data['id_draft'];
                    $this->db->query($sql);

                    if ($this->db->trans_status() === FALSE)
                    {
                        $this->db->trans_rollback();
                        $query = false;
                        $notes = array("Query gagal", $icon_warning, 0);
                    }else{
                        if(isset($row->id_pegawai_awal)==true) {
                            $sql = "delete from draft_pelantikan_lepas_jabatan where id_pegawai = " . $data['id_pegawai_awal'] . " and id_draft = " . $data['id_draft'];

                            $this->db->query($sql);
                            if ($this->db->trans_status() === FALSE) {
                                $this->db->trans_rollback();
                                $query = false;
                                $notes = array("Query gagal", $icon_warning, 0);
                            } else {
                                $sqlLog = "insert into draft_pelantikan_log (id_user,id_draft,id_pegawai,idj_awal,idj_akhir,id_transaksi) values (".
                                    $this->session->userdata('user')->id_pegawai.",".$data['id_draft'].",".$data['id_pegawai_baru'].",$row->idj_usulan_dr_pegawai_awal,$row->idj_baru,3)";
                                $this->db->query($sqlLog);
                                if ($this->db->trans_status() === FALSE) {
                                    $this->db->trans_rollback();
                                    $query = false;
                                    $cttn .= "Query gagal";
                                    $notes = array($cttn, $icon_warning, 0);
                                } else {
                                    $this->db->trans_commit();
                                    $query = true;
                                    $cttn .= $row->jabatan." Sukses dibatalkan.";
                                    $notes = array($cttn, $icon_ok, 1);
                                }
                            }
                        }else{
                            $this->db->trans_commit();
                            $cttn .= $row->jabatan." Sukses dibatalkan.";
                            $notes = array($cttn, $icon_ok, 1);
                        }
                    }
                }elseif($row->idp_baru != $data['id_pegawai_baru']){
                    //Jabatan lama sedang diisi
                    $cttn .= " Jabatan ".$row->jabatan.' sedang diisi oleh pegawai lain.';
                    $notes = array($cttn, $icon_warning, 0);
                    $this->db->trans_begin();
                    //eko adin
                    $sqlInsertLepasJab = "insert into draft_pelantikan_lepas_jabatan (id_draft, id_pegawai, created_by) 
                                 values (".$data['id_draft'].",".$row->id_pegawai_awal.",".$this->session->userdata('user')->id_pegawai.")";
                    $this->db->query($sqlInsertLepasJab);
                    if ($this->db->trans_status() === FALSE) {
                        $this->db->trans_rollback();
                        $query = false;
                        $cttn .= "Query gagal";
                        $notes = array($cttn, $icon_warning, 0);
                    }else{
                        $sql = "insert into draft_pelantikan_temporary(id_draft, id_j, id_pegawai)
                            values (".$data['id_draft'].",".$row->idj_baru.",".$row->id_pegawai_awal.")";
                        $this->db->query($sql);
                        if ($this->db->trans_status() === FALSE) {
                            $this->db->trans_rollback();
                            $query = false;
                            $notes = array("Query gagal", $icon_warning, 0);
                        }else{
                            $sql = "insert into draft_pelantikan_temporary(id_draft, id_j, id_pegawai)
                            values (".$data['id_draft'].",".$row->idj_baru.",".$row->idp_baru.")";
                            $this->db->query($sql);
                            if ($this->db->trans_status() === FALSE) {
                                $this->db->trans_rollback();
                                $query = false;
                                $notes = array("Query gagal", $icon_warning, 0);
                            }else{
                                $sqlLog = "insert into draft_pelantikan_log (id_user,id_draft,id_pegawai,idj_awal,idj_akhir,id_transaksi) values (".
                                    $this->session->userdata('user')->id_pegawai.",".$data['id_draft'].",".$row->id_pegawai_awal.",$row->idj_usulan_dr_pegawai_awal,$row->idj_baru,3)";
                                $this->db->query($sqlLog);
                                if ($this->db->trans_status() === FALSE) {
                                    $this->db->trans_rollback();
                                    $query = false;
                                    $cttn .= "Query gagal";
                                    $notes = array($cttn, $icon_warning, 0);
                                } else {
                                    $this->db->trans_commit();
                                    $query = true;
                                    $cttn .= " Sukses ditambahkan ke Riwayat Pengubahan Jabatan.";
                                    $notes = array($cttn, $icon_ok, 1);
                                }
                            }
                        }
                    }
                }
            }
        }
        return $notes;
    }

    public function getdraft_pelantikan_pengesahan_by_iddraft($id_draft){
        $this->db->select("id_draft, id_baperjakat, no_sk, date_format(dpp.tgl_pengesahan, '%d.%m.%Y') AS tgl_pengesahan,
        dpp.wkt_pengesahan, dpp.ruang_pengesahan", FALSE);
        $this->db->where('id_draft', $id_draft);
        return $this->db->get('draft_pelantikan_pengesahan dpp')->row();
    }

    public function updatePengesahanPelantikan($data, $existingIddraft){
        $this->db->trans_begin();
        $tglpengesahan = explode(".", $data['tglpengesahan']);
        $tglpengesahan = $tglpengesahan[2].'-'.$tglpengesahan[1].'-'.$tglpengesahan[0];
        if($existingIddraft > 0){
            $sql = "update draft_pelantikan_pengesahan set id_baperjakat =  " . $data['idbaperjakat'] .
                ", no_sk =  '" . $data['nosk'] . "', tgl_pengesahan =  '" . $tglpengesahan .
                "', wkt_pengesahan =  '" . $data['wktpengesahan'] . "', ruang_pengesahan =  '" . $data['ruang_pengesahan'] .
                "' where id_draft = " . $data['id_draft'];
        }else{
            $sql = "insert into draft_pelantikan_pengesahan(id_draft, id_baperjakat, no_sk, tgl_pengesahan, wkt_pengesahan, ruang_pengesahan) ".
                         "values (".$data['id_draft'].','.$data['idbaperjakat'].",'".$data['nosk'].
                         "','".$tglpengesahan."','".$data['wktpengesahan']."','".$data['ruang_pengesahan']."')";
        }

        $this->db->query($sql);
        if ($this->db->trans_status() === FALSE)
        {
            $this->db->trans_rollback();
            $query = false;
        }else{
            $this->db->trans_commit();
            $query = true;
        }
        return $query;
    }

    public function getBidangPendidikan(){
        $sql = "SELECT * FROM bidang_pendidikan bp ORDER BY bp.bidang ASC;";
        $query = $this->db->query($sql);
        $data = null;
        foreach ($query->result() as $row)
        {
            $data[] = $row;
        }
        return $data;
    }

    public function get_by_id_kompetensi($id_pegawai){
        $query = $this->db->query("SELECT sk.sumber, bp.bidang, k.tahun, k.durasi
        FROM kompetensi k, sumber_kompetensi sk, bidang_pendidikan bp
        WHERE k.id_pegawai=$id_pegawai AND k.id_sumber = sk.id AND k.id_bidang = bp.id");

        $data = null;
        foreach ($query->result() as $row)
        {
            $data[] = $row;
        }
        return $data;
    }

    public function get_jabatan_potensi_kosong(){
        $sql = "SELECT t.*,DATE_FORMAT(t.tmt_bup, '%d-%m-%Y') AS tgl_bup, bp.bidang AS bidang_pendidikan FROM ( SELECT
                g.id_pegawai, g.nip, g.nama, g.tempat_lahir, g.tgl_lahir, g.usia, g.jenjab, g.pangkat_gol, g.id_j, g.jabatan, g.eselon,
                g.unit, g.id_skpd, g.skpd, g.tingkat_pendidikan, g.jurusan_pendidikan, g.id_bidang, g.gol, g.mk_tahun, g.mk_bulan,
                CASE WHEN g.jenjab = 'Struktural'
                  THEN (CASE WHEN (g.eselon = 'IIA' OR g.eselon = 'IIB') THEN 60 ELSE 58 END)
                  ELSE (CASE WHEN jaf.bup IS NULL THEN 58 ELSE jaf.bup END)
                  END AS usia_pensiun,
                CASE WHEN g.jenjab = 'Struktural'
                  THEN
                    DATE_SUB(
                        LAST_DAY(
                            DATE_ADD(DATE_ADD(g.tgl_lahir, INTERVAL (SELECT CASE WHEN (g.eselon = 'IIA' OR g.eselon = 'IIB') THEN 60 ELSE 58 END) YEAR), INTERVAL 1 MONTH)
                        ),
                        INTERVAL DAY(
                            LAST_DAY(
                                DATE_ADD(DATE_ADD(g.tgl_lahir, INTERVAL (SELECT CASE WHEN (g.eselon = 'IIA' OR g.eselon = 'IIB') THEN 60 ELSE 58 END) YEAR), INTERVAL 1 MONTH)
                            )
                        )-1 DAY
                    )
                  ELSE
                    DATE_SUB(
                        LAST_DAY(
                            DATE_ADD(DATE_ADD(g.tgl_lahir, INTERVAL (SELECT CASE WHEN jaf.bup IS NULL THEN 58 ELSE jaf.bup END) YEAR), INTERVAL 1 MONTH)
                        ),
                        INTERVAL DAY(
                            LAST_DAY(
                                DATE_ADD(DATE_ADD(g.tgl_lahir, INTERVAL (SELECT CASE WHEN jaf.bup IS NULL THEN 58 ELSE jaf.bup END) YEAR), INTERVAL 1 MONTH)
                            )
                        )-1 DAY
                    )
                  END AS tmt_bup, skn.tmt_jabatan as tmt_jabatan_min, ROUND(DATEDIFF(CURRENT_DATE, skn.tmt_jabatan)/365,2) AS usia_jabatan
                FROM
                (SELECT ef.*, p.tingkat_pendidikan, p.jurusan_pendidikan, p.id_bidang,
                CASE WHEN ((ef.gol_pangkat IS NULL AND ef.gol_kgb IS NULL) OR (ef.gol_pangkat IS NULL AND ef.gol_kgb = '')
                  OR (ef.gol_pangkat = '' AND ef.gol_kgb IS NULL) OR (ef.gol_pangkat = '' AND ef.gol_kgb = ''))
                  THEN ef.pangkat_gol ELSE
                  (CASE WHEN ef.gol_pangkat IS NULL THEN ef.gol_kgb ELSE
                    (CASE WHEN ef.gol_kgb IS NULL THEN ef.gol_pangkat ELSE
                      (CASE WHEN ef.gol_pangkat > ef.gol_kgb THEN ef.gol_pangkat ELSE ef.gol_kgb END) END) END) END AS gol,
                CASE WHEN ef.mk_tahun_pangkat > ef.mk_tahun_kgb THEN ef.mk_tahun_pangkat ELSE ef.mk_tahun_kgb END AS mk_tahun,
                CASE WHEN ef.mk_tahun_pangkat > ef.mk_tahun_kgb THEN ef.mk_bulan_pangkat ELSE ef.mk_bulan_kgb END AS mk_bulan
                FROM
                (SELECT cd.*, s.gol AS gol_kgb, CASE WHEN s.mk_tahun IS NULL THEN 0 ELSE CONVERT(s.mk_tahun,UNSIGNED INTEGER) END as mk_tahun_kgb,
                CASE WHEN s.mk_bulan IS NULL THEN 0 ELSE CONVERT(s.mk_bulan,UNSIGNED INTEGER) END AS mk_bulan_kgb
                FROM
                (SELECT ab.*, s.gol AS gol_pangkat, CASE WHEN s.mk_tahun IS NULL THEN 0 ELSE CONVERT(s.mk_tahun,UNSIGNED INTEGER) END as mk_tahun_pangkat,
                CASE WHEN s.mk_bulan IS NULL THEN 0 ELSE CONVERT(s.mk_bulan,UNSIGNED INTEGER) END as mk_bulan_pangkat
                FROM
                (SELECT a.id_pegawai, CONCAT(\"'\",a.nip_baru) AS nip, a.nama, a.tempat_lahir, a.tgl_lahir, a.usia, a.jenjab, a.pangkat_gol, a.jabatan,
                CASE WHEN a.eselon = 'Z' THEN '' ELSE a.eselon END AS eselon, a.unit, a.id_skpd, uk.nama_baru as skpd, id_j
                FROM
                (SELECT p.id_pegawai, p.nip_baru, CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
                nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(' ',p.gelar_belakang) END) AS nama, p.tempat_lahir, p.tgl_lahir,
                  ROUND(DATEDIFF(CURRENT_DATE, DATE_FORMAT(p.tgl_lahir, '%Y/%m/%d'))/365,2) AS usia ,
                  p.jenjab, p.pangkat_gol,
                CASE WHEN p.jenjab = 'Fungsional' THEN p.jabatan ELSE CASE WHEN p.id_j IS NULL THEN
                (SELECT jm.nama_jfu AS jabatan
                 FROM jfu_pegawai jp, jfu_master jm
                 WHERE jp.kode_jabatan = jm.kode_jabatan AND jp.id_pegawai = p.id_pegawai LIMIT 1)
                ELSE j.jabatan END END AS jabatan, CASE WHEN j.eselon IS NULL THEN 'Z' ELSE j.eselon END AS eselon, uk.nama_baru as unit,
                uk.id_skpd, p.id_j
                FROM pegawai p LEFT JOIN jabatan j ON p.id_j = j.id_j, current_lokasi_kerja clk, unit_kerja uk
                WHERE p.id_pegawai = clk.id_pegawai AND clk.id_unit_kerja = uk.id_unit_kerja
                AND p.flag_pensiun = 0 AND p.id_j IS NOT NULL
                ORDER BY eselon ASC, p.pangkat_gol DESC, p.nama) a, unit_kerja uk
                WHERE a.id_skpd = uk.id_unit_kerja) ab LEFT JOIN sk s
                ON ab.id_pegawai = s.id_pegawai AND s.id_sk = (SELECT sk.id_sk AS id_sk
                FROM sk WHERE sk.id_pegawai = ab.id_pegawai AND sk.id_kategori_sk = 5 ORDER BY sk.id_kategori_sk, sk.tmt DESC LIMIT 1)) cd LEFT JOIN sk s
                ON cd.id_pegawai = s.id_pegawai AND s.id_sk = (SELECT sk.id_sk AS id_sk
                FROM sk WHERE sk.id_pegawai = cd.id_pegawai AND sk.id_kategori_sk = 9 ORDER BY sk.id_kategori_sk, sk.tmt DESC LIMIT 1)) ef LEFT JOIN pendidikan p
                ON ef.id_pegawai = p.id_pegawai AND p.id_pendidikan = (SELECT p.id_pendidikan FROM pendidikan p WHERE p.id_pegawai = ef.id_pegawai
                ORDER BY p.level_p ASC LIMIT 1)) g
                LEFT JOIN (SELECT nama_jafung, pangkat_gol, MAX(bup) AS bup FROM jafung
                      GROUP BY nama_jafung, pangkat_gol) jaf ON jaf.nama_jafung = g.jabatan AND jaf.pangkat_gol = g.gol
                LEFT JOIN (SELECT s.id_pegawai, MIN(s.tmt) AS tmt_jabatan
                  FROM sk s WHERE s.id_kategori_sk = 10 GROUP BY s.id_pegawai) skn ON
                skn.id_pegawai = g.id_pegawai) t LEFT JOIN bidang_pendidikan bp ON t.id_bidang = bp.id 
                WHERE (t.tmt_bup BETWEEN DATE_ADD(STR_TO_DATE(CONCAT(SUBSTRING(DATE_FORMAT(NOW(), '%Y-%m-%d'),1,8),'01'), '%Y-%m-%d'), INTERVAL 1 MONTH) AND
                DATE_ADD(STR_TO_DATE(CONCAT(SUBSTRING(DATE_FORMAT(NOW(), '%Y-%m-%d'),1,8),'01'), '%Y-%m-%d'), INTERVAL 6 MONTH)) 
                ORDER BY t.tmt_bup ASC, t.id_skpd, t.unit, t.eselon ASC, t.pangkat_gol DESC, t.nama ASC";
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function get_jabatan_kosong_baru($id_draft){
        $sql = "SELECT c.*, j.jabatan, j.eselon FROM (SELECT b.* FROM
            (SELECT a.*, p.id_pegawai AS id_pegawai_skrg FROM
            (SELECT dp.id_draft, dp.id_j, dp.id_pegawai_awal, dp.id_pegawai FROM draft_pelantikan_detail dp
            WHERE dp.id_draft = ".$id_draft.") a LEFT JOIN pegawai p
            ON a.id_j = p.id_j AND (p.flag_pensiun = 0 OR p.flag_pensiun = 2)) b
            WHERE b.id_pegawai_skrg IS NULL AND b.id_pegawai IS NOT NULL) c
            LEFT JOIN jabatan j ON c.id_j = j.id_j
            WHERE /*j.jabatan NOT LIKE '%RSUD%' AND*/ c.id_pegawai_awal = c.id_pegawai;";

        $query = $this->db->query($sql);
        return $query->result();
    }

    public function get_pegawai_rangkap_jabatan($id_draft){
        $sql = "SELECT c.*,j.jabatan, j.eselon, p.nama, p.nip_baru FROM
                (SELECT b.*, dp.id_j, dp.id_draft FROM
                (SELECT a.id_pegawai FROM
                (SELECT dpd.id_pegawai, COUNT(dpd.id_draft) AS jumlah
                FROM draft_pelantikan_detail dpd
                WHERE dpd.id_draft = $id_draft AND dpd.id_pegawai IS NOT NULL
                GROUP BY dpd.id_pegawai) a WHERE a.jumlah > 1
                ORDER BY a.jumlah DESC) b INNER JOIN draft_pelantikan_detail dp
                WHERE dp.id_draft = $id_draft AND dp.id_pegawai = b.id_pegawai) c
                INNER JOIN jabatan j on j.id_j = c.id_j
                LEFT JOIN pegawai p on p.id_pegawai = c.id_pegawai
                ORDER BY p.nama, j.id_j;";

        $query = $this->db->query($sql);
        return $query->result();
    }

    public function getdraft_pelantikan_temporary($id_draft){
        $sql = "SELECT f.*, p.nama, p.nip_baru FROM
                (SELECT e.*, j.jabatan as jabatan_tujuan
                  FROM (SELECT d.*, j.jabatan FROM
                (SELECT c.id_temp, c.id_draft, c.id_j, c.id_pegawai, c.update_time,
                (CASE WHEN c.status_data = 'Temporary' THEN (
                  CASE WHEN dpd.id_pegawai IS NULL THEN 'Blm dicalonkan' ELSE 'Sdh dicalonkan' END)
                  ELSE c.status_data END) AS status_data, dpd.id_j AS id_j_tujuan
                  FROM
                (SELECT b.id_temp, b.id_draft, b.id_j, b.id_pegawai, b.update_time,
                  (CASE WHEN b.status_data IS NULL THEN (
                  CASE WHEN b.id_pegawai = dpd.id_pegawai THEN 'Definitive' ELSE 'Temporary' END)
                  ELSE b.status_data END) AS status_data
                  FROM
                (SELECT a.*, (CASE WHEN a.id_pegawai = dpd.id_pegawai_awal THEN (
                  CASE WHEN dpd.id_pegawai_awal = dpd.id_pegawai THEN 'Pejabat Awal dan Definitive' ELSE
                  'Pejabat Awal dan blm dicalonkan' END) END) AS status_data FROM
                (SELECT * FROM draft_pelantikan_temporary temp
                WHERE temp.id_draft = ".$id_draft.") a LEFT JOIN draft_pelantikan_detail dpd
                ON dpd.id_draft = a.id_draft AND a.id_pegawai = dpd.id_pegawai_awal AND a.id_j = dpd.id_j) b
                LEFT JOIN draft_pelantikan_detail dpd
                ON dpd.id_draft = b.id_draft AND b.id_pegawai = dpd.id_pegawai AND b.id_j = dpd.id_j) c
                LEFT JOIN draft_pelantikan_detail dpd ON c.id_pegawai = dpd.id_pegawai AND c.id_draft = dpd.id_draft
                ORDER BY c.id_draft, c.id_j, c.id_temp ASC) d LEFT JOIN jabatan j
                ON d.id_j = j.id_j) e LEFT JOIN jabatan j ON e.id_j_tujuan = j.id_j) f
                LEFT JOIN pegawai p ON f.id_pegawai = p.id_pegawai";

        $query = $this->db->query($sql);
        return $query->result();
    }

    public function get_pegawai_exist_in_draft($id_draft, $id_pegawai_bawahan){
        $sql = "select count(*) as jumlah from draft_pelantikan_detail
			    where id_draft = $id_draft and id_pegawai = $id_pegawai_bawahan";
        $query = $this->db->query($sql);
        foreach ($query->result() as $row){
            $count = $row->jumlah;
        }
        return $count;
    }

    public function get_log_aktifitas($id_draft){
        $sql = "SELECT c.*, p.nama AS oleh FROM
                (SELECT b.*, j.jabatan as jabatan_akhir, j.eselon as eselon_akhir FROM
                (SELECT a.*, p.nip_baru, p.nama, p.pangkat_gol,
                dpt.transaksi, j.jabatan as jabatan_awal, j.eselon as eselon_awal FROM
                (SELECT *, DATE_FORMAT(dpl.waktu, '%d-%m-%Y %H:%i:%s') AS waktu2 FROM draft_pelantikan_log dpl
                WHERE dpl.id_draft = $id_draft) a LEFT JOIN pegawai p ON a.id_pegawai = p.id_pegawai
                LEFT JOIN jabatan j ON a.idj_awal = j.id_j
                INNER JOIN draft_pelantikan_transaksi dpt ON a.id_transaksi = dpt.id) b
                LEFT JOIN jabatan j ON b.idj_akhir = j.id_j) c
                LEFT JOIN pegawai p ON c.id_user = p.id_pegawai
                ORDER BY c.waktu DESC ";

        $query = $this->db->query($sql);
        return $query->result();
    }

    public function compare_draft_with_existing($id_draft){
        $sql = "SELECT a.*, b.nama as pejabat_lama, b.eselon_baru, b.jabatan_baru, p.nip_baru as nip_eksisting,
                CASE WHEN (a.nip_baru IS NULL AND b.nama IS NOT NULL AND p.nip_baru IS NOT NULL) THEN 'Kosong sedang direposisi' ELSE
                  (CASE WHEN (a.nip_baru IS NOT NULL AND p.nip_baru IS NULL) THEN 'Kosong pensiun' ELSE 'Tidak ada catatan' END)
                END AS status_data
                FROM
                (SELECT dpd.id_pegawai, dpd.id_j, j.jabatan, j.eselon, p.nip_baru,
                CONCAT(CASE WHEN (p.gelar_depan = '' OR p.gelar_depan IS NULL) THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
                nama, CASE WHEN (p.gelar_belakang = '' OR p.gelar_belakang IS NULL) THEN '' ELSE CONCAT(' ',p.gelar_belakang) END) AS nama
                FROM draft_pelantikan_detail dpd
                LEFT JOIN jabatan j ON dpd.id_j = j.id_j
                LEFT JOIN pegawai p ON  dpd.id_j = p.id_j AND (p.flag_pensiun = 0 OR p.flag_pensiun = 2)
                WHERE dpd.id_draft = $id_draft
                ORDER BY j.eselon ASC, j.jabatan ASC) a
                LEFT JOIN
                (SELECT
                  draft_struktural.id_draft, draft_struktural.id_pegawai, draft_struktural.nip,
                  draft_struktural.gelar_depan, draft_struktural.nama, draft_struktural.gelar_belakang,
                  draft_struktural.tgl_lahir, draft_struktural.pangkat_gol, draft_struktural.pangkat,
                  draft_struktural.jabatan_baru, draft_struktural.unit_baru, draft_struktural.eselon_baru,
                  CASE WHEN draft_struktural.jabatan_lama IS NULL THEN
                    CONCAT('Fungsional Umum pada ', draft_struktural.unit_lama)
                  ELSE
                    (CASE WHEN draft_struktural.eselon_lama IS NULL THEN CONCAT(draft_struktural.jabatan_lama,' pada ',draft_struktural.unit_lama)
                     ELSE draft_struktural.jabatan_lama END)
                  END AS jabatan_lama,
                  draft_struktural.unit_lama, draft_struktural.id_j_lama, draft_struktural.eselon_lama,
                  draft_struktural.keterangan, draft_struktural.id_pegawai_awal,
                  CASE WHEN p.nip_baru IS NULL THEN '-' ELSE p.nip_baru END AS nip_pejabat_awal,
                  CASE WHEN p.gelar_depan IS NULL THEN '-' ELSE p.gelar_depan END AS gelar_depan_pejabat_awal,
                  CASE WHEN p.nama IS NULL THEN '-' ELSE p.nama END AS nama_pejabat_awal,
                  CASE WHEN p.gelar_belakang IS NULL THEN '-' ELSE p.gelar_belakang END AS gelar_belakang_pejabat_awal,
                  DATE_FORMAT(p.tgl_lahir,  '%d/%m/%Y') AS tgl_lahir_pejabat_awal
                FROM (SELECT
                        jab_baru.id_draft_dj_baru AS id_draft,
                        p.id_pegawai,
                        p.nip_baru AS nip,
                        p.gelar_depan,
                        p.nama,
                        p.gelar_belakang,
                        DATE_FORMAT(p.tgl_lahir,  '%d/%m/%Y') AS tgl_lahir,
                        p.pangkat_gol,
                        g.pangkat,
                        jab_baru.jabatan_baru,
                        jab_baru.unit_baru,
                        jab_baru.eselon_baru,
                        CASE WHEN p.jenjab = 'Fungsional' THEN p.jabatan ELSE CASE WHEN p.id_j IS NULL THEN
                          (SELECT jm.nama_jfu AS jabatan
                           FROM jfu_pegawai jp, jfu_master jm
                           WHERE jp.kode_jabatan = jm.kode_jabatan AND jp.id_pegawai = p.id_pegawai LIMIT 1)
                                                                              ELSE j.jabatan END END AS jabatan_lama,
                        ukl.nama_baru AS unit_lama,
                        j.id_j AS id_j_lama,
                        j.eselon AS eselon_lama,
                        IF(jab_baru.eselon_baru < j.eselon, 'Promosi',
                           IF(j.eselon IS NULL AND jab_baru.eselon_baru IS NOT NULL, 'Promosi', 'Rotasi')) AS keterangan,
                        jab_baru.id_pegawai_awal
                      FROM (SELECT
                              dpdl.id_draft AS id_draft_current,
                              dj_baru.id_draft_dj_baru,
                              dj_baru.idp_baru AS idpegawai,
                              dj_baru.idj_baru,
                              dpdl.id_j AS idj_lama,
                              j.jabatan AS jabatan_baru,
                              uk.nama_baru AS unit_baru,
                              j.eselon AS eselon_baru,
                              dj_baru.id_pegawai_awal
                            FROM (SELECT
                                    dpd.id_j AS idj_baru,
                                    dpd.id_pegawai AS idp_baru,
                                    dpd.id_pegawai_awal,
                                    dpd.id_draft AS id_draft_dj_baru
                                  FROM draft_pelantikan_detail dpd
                                  WHERE (dpd.id_pegawai <> dpd.id_pegawai_awal OR (dpd.id_pegawai IS NOT NULL AND dpd.id_pegawai_awal IS NULL))
                                        AND dpd.id_draft = $id_draft) AS dj_baru
                              LEFT JOIN draft_pelantikan_detail dpdl ON dj_baru.idp_baru = dpdl.id_pegawai_awal AND dpdl.id_draft = $id_draft,
                              jabatan j,
                              unit_kerja uk
                            WHERE
                              dj_baru.idj_baru = j.id_j
                              AND j.id_unit_kerja = uk.id_unit_kerja ) AS jab_baru
                        LEFT JOIN jabatan j ON j.id_j = jab_baru.idj_lama
                        INNER JOIN current_lokasi_kerja clk ON jab_baru.idpegawai = clk.id_pegawai
                        INNER JOIN unit_kerja ukl ON clk.id_unit_kerja = ukl.id_unit_kerja,
                        pegawai p,
                        golongan g
                      WHERE p.id_pegawai = jab_baru.idpegawai
                            AND p.pangkat_gol = g.golongan
                      ORDER BY jab_baru.unit_baru ASC) AS draft_struktural LEFT JOIN
                  pegawai p ON draft_struktural.id_pegawai_awal = p.id_pegawai) b ON a.id_j = b.id_j_lama
                LEFT JOIN pegawai p ON a.id_j = p.id_j
                WHERE ( a.nip_baru IS NULL) AND a.id_pegawai IS NOT NULL /*AND a.jabatan NOT LIKE '%RSUD%'*/";
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function update_jabatan_kosong_baru($data, $id_draft){
        $whereKlause = '';
        for ($x = 0; $x < sizeof($data['id_jab']); $x++) {
            $whereKlause .= $data['id_jab'][$x].',';
        }
        $whereKlause = substr($whereKlause,0,strlen($whereKlause)-1);
        $this->db->trans_begin();
        $sql = "UPDATE draft_pelantikan_detail SET id_pegawai = NULL, id_pegawai_awal = NULL 
                WHERE id_j IN (".$whereKlause.") AND id_draft = $id_draft";

        $this->db->query($sql);
        if ($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            $query = 'false';
        }else{
            $this->db->trans_commit();
            $query = 'true';
        }
        return $query;
    }

    public function get_diklat_barjas($id_pegawai){
	    $sql = "SELECT COUNT(*) AS jumlah FROM diklat 
                WHERE id_jenis_diklat = 3 AND nama_diklat LIKE '%Sertifikasi Pengadaan Barang dan Jasa%' AND id_pegawai = $id_pegawai";

	    $query = $this->db->query($sql);
        $rowcount = $query->num_rows();
        if($rowcount > 0) {
            foreach ($query->result() as $data) {
                $jmlData = $data->jumlah;
            }
        }else{
            $jmlData = 0;
        }
        return $jmlData;
	}

	public function get_usia_golongan_terakhir($id_pegawai, $tgl_pelantikan){
	    $sql = "SELECT no_sk, DATE_FORMAT(tmt, '%d-%m-%Y') AS tgl_tmt, CURRENT_DATE as tgl_sekarang, 
                ROUND(DATEDIFF('$tgl_pelantikan', tmt) / 365,2) AS usia_golongan, gol
                FROM sk WHERE id_pegawai = $id_pegawai AND (id_kategori_sk = 5 OR id_kategori_sk = 6 OR id_kategori_sk = 7) 
                ORDER BY tmt DESC LIMIT 1";

        $query = $this->db->query($sql);
        foreach($query->result() as $row ){
            $data[] = $row;
        }
        return $data;
    }

    public function get_masa_kerja($id_pegawai, $tgl_pelantikan){
	    $sql = "SELECT no_sk, DATE_FORMAT(tmt, '%d-%m-%Y') AS tgl_tmt, CURRENT_DATE as tgl_sekarang, 
                ROUND(DATEDIFF('$tgl_pelantikan', tmt) / 365,2) AS usia_golongan, gol
                FROM sk WHERE id_pegawai = $id_pegawai AND id_kategori_sk = 6 
                ORDER BY tmt DESC LIMIT 1";
        $query = $this->db->query($sql);
        foreach($query->result() as $row ){
            $data[] = $row;
        }
        return $data;
    }

    public function is_mpp_tubel_cltn($id_pegawai){
	    $sql = "SELECT p.status_aktif, COUNT(p.id_pegawai) AS jml_pegawai 
                FROM pegawai p WHERE (LOCATE('MPP', p.status_aktif) > 0 OR LOCATE('Tugas Belajar', p.status_aktif) > 0 OR  LOCATE('CLTN', p.status_aktif) > 0) 
                AND p.flag_pensiun = 0 AND p.id_pegawai = $id_pegawai
                GROUP BY p.status_aktif";

        $query = $this->db->query($sql);
        $rowcount = $query->num_rows();
        if($rowcount > 0){
            foreach ($query->result() as $data){
                $statusAktif = $data->status_aktif;
                $jmlData = $data->jml_pegawai;
            }
        }else{
            $statusAktif = '';
            $jmlData = 0;
        }

        return array(
            'statusAktif' => $statusAktif,
            'jmlData' => $jmlData
        );
    }

    public function get_pejabat_sekarang_plt($id_draft, $id_j){
        $sql = "SELECT 
                    NULL as idpegawai, 
                    p.id_pegawai AS idpegawai_plt, 
                    CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
                    p.nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(', ',p.gelar_belakang) END) AS nama_gelar,
                    p.nip_baru, 
                    p.pangkat_gol, 
                    p.jenjab,
                    CONCAT((CASE WHEN p.jenjab = 'Fungsional' THEN (CASE WHEN jafung.nama_jafung IS NULL THEN j.jabatan ELSE jafung.nama_jafung END) ELSE
                    (CASE WHEN p.id_j IS NULL THEN (jp.nama_jfu) ELSE j.jabatan END) END), ' <br>sebagai Plt. Jabatan yang dituju') AS jabatan, 
                    j.eselon, 
                    s_jab.tmt_jabatan, 
                    pend . *, 
                    DATE_FORMAT( s.tmt,  '%d-%m-%Y' ) AS tmt, p.alamat, p.kota 
                FROM (SELECT (CASE WHEN a.id_pegawai_draft IS NULL = 1 THEN a.id_pegawai_jplt ELSE a.id_pegawai_draft END) AS id_pegawai FROM 
                (SELECT det.id_j, det.id_pegawai as id_pegawai_draft, jplt.id_pegawai as  id_pegawai_jplt
                FROM draft_pelantikan_detail det 
                LEFT JOIN pegawai p ON p.id_pegawai = det.id_pegawai
                LEFT JOIN jabatan_plt jplt ON jplt.id_j = det.id_j AND jplt.status_aktif = 1
                WHERE det.id_draft = $id_draft AND det.id_j = $id_j) a) det 
                INNER JOIN pegawai p ON p.id_pegawai = det.id_pegawai
                LEFT JOIN (
                SELECT pt.id_pegawai, pt.id_pendidikan, pt.tingkat_pendidikan, pt.jurusan_pendidikan,
                  pt.lembaga_pendidikan, pt.tahun_lulus
                FROM pendidikan_terakhir pt) AS pend ON pend.id_pegawai = p.id_pegawai
                LEFT JOIN jabatan j ON j.id_j = p.id_j
                LEFT JOIN (
                SELECT b.id_pegawai, jm.id_jfu as kode_jabatan_jfu, jm.kelas_jabatan as kelas_jabatan_jfu,
                jm.nilai_jabatan as nilai_jabatan_jfu, jm.nama_jfu
                FROM (SELECT a.*, jp.id_jfu FROM
                (SELECT jp.id_pegawai, MAX(jp.id) as id_jfu_pegawai FROM jfu_pegawai jp,
                (SELECT id_pegawai, MAX(tmt) as max_tmt FROM jfu_pegawai WHERE tmt IS NOT NULL GROUP BY id_pegawai) x
                WHERE jp.id_pegawai = x.id_pegawai AND jp.tmt = x.max_tmt
                GROUP BY jp.id_pegawai) a
                INNER JOIN jfu_pegawai jp ON a.id_jfu_pegawai = jp.id) b
                INNER JOIN jfu_master jm ON b.id_jfu = jm.id_jfu) jp ON jp.id_pegawai = p.id_pegawai
                LEFT JOIN (
                SELECT b.id_pegawai, jm.id_jafung as kode_jabatan_jafung, jm.kelas_jabatan as kelas_jabatan_jafung,
                jm.nilai_jabatan as nilai_jabatan_jafung, jm.nama_jafung
                FROM (SELECT a.*, jp.id_jafung FROM
                (SELECT jp.id_pegawai, MAX(jp.id) as id_jafung_pegawai FROM jafung_pegawai jp,
                (SELECT id_pegawai, MAX(tmt) as max_tmt FROM jafung_pegawai WHERE tmt IS NOT NULL GROUP BY id_pegawai) x
                WHERE jp.id_pegawai = x.id_pegawai AND jp.tmt = x.max_tmt
                GROUP BY jp.id_pegawai) a
                INNER JOIN jafung_pegawai jp ON a.id_jafung_pegawai = jp.id) b
                INNER JOIN jafung jm ON b.id_jafung = jm.id_jafung) jafung ON jafung.id_pegawai = p.id_pegawai
                LEFT JOIN (
                    SELECT s.id_pegawai, date_format(s.tmt, '%d-%m-%Y') as tmt_jabatan
                    FROM pegawai p
                    INNER JOIN sk s ON s.id_pegawai = p.id_pegawai
                    WHERE id_kategori_sk = 10
                    AND s.id_j = p.id_j
                    GROUP BY s.id_pegawai
                    ORDER BY s.tmt DESC				
                ) as s_jab on s_jab.id_pegawai = p.id_pegawai
                LEFT JOIN (
                    SELECT s.id_pegawai, s.tmt
                    FROM pegawai p
                    INNER JOIN sk s ON s.id_pegawai = p.id_pegawai
                    WHERE id_kategori_sk =5
                    AND s.gol = p.pangkat_gol
                    GROUP BY s.id_pegawai
                ) AS s ON s.id_pegawai = p.id_pegawai";

        $query = $this->db->query($sql);
        $data = null;
        foreach ($query->result() as $row){
            return $row;
        }
        return null;
    }

    public function get_exists_reposition_in_draft($id_draft, $id_pegawai){
        $sql = "SELECT COUNT(*) AS jumlah FROM draft_pelantikan_detail WHERE id_draft = $id_draft AND id_pegawai = $id_pegawai AND id_pegawai <> id_pegawai_awal";

        $query = $this->db->query($sql);
        $rowcount = $query->num_rows();
        if($rowcount > 0) {
            foreach ($query->result() as $data) {
                $jmlData = $data->jumlah;
            }
        }else{
            $jmlData = 0;
        }
        return $jmlData;
    }

    public function get_existin_openbidding($id_pegawai){
        $sql = "SELECT  COUNT(dpobd.id_open_bidding_detail) AS jumlah 
                FROM draft_pelantikan_open_bidding_detail dpobd 
                INNER JOIN draft_pelantikan_open_bidding dpob ON dpobd.id_open_bidding = dpob.id_open_bidding 
                WHERE /*dpob.id_open_bidding = 
                (SELECT id_open_bidding FROM draft_pelantikan_open_bidding 
                WHERE tmt_open_bidding = (SELECT MAX(tmt_open_bidding) AS maks_periode FROM draft_pelantikan_open_bidding))
                AND*/ dpob.status_aktif = 1 AND dpobd.id_pegawai = $id_pegawai";
        $query = $this->db->query($sql);
        $rowcount = $query->num_rows();
        if($rowcount > 0) {
            foreach ($query->result() as $data) {
                $jmlData = $data->jumlah;
            }
        }else{
            $jmlData = 0;
        }
        return $jmlData;
    }

}
?>
