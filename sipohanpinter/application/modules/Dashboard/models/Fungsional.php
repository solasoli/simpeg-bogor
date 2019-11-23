<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Fungsional extends CI_Model {

	function cek_log() {
		if($this->session->userdata('user_id')==null):
			$this->session->set_flashdata('valid', '<div class="alert alert-info">Tidak ada akses.</div>');
			redirect('Welcome');
		endif;
	}

	function get_profile() {
		$sql_data = "SELECT cuti_peg.*, jp.id_pegawai as idp_plt_pjbt FROM
              (SELECT cuti_p.*, jp.id_pegawai as idp_plt_atsl FROM
                (SELECT me_atsl_pjbt_a.*, clk.id_unit_kerja as id_unit_kerja_pjbt, uk.id_skpd
                FROM(
                SELECT me_atsl_pjbt.*, clk.id_unit_kerja as id_unit_kerja_atsl
                FROM
                (SELECT me_atsl.*, CASE WHEN p.id_pegawai IS NULL = 1 THEN 0 ELSE p.id_pegawai END as id_pegawai_pjbt,
                p.nip_baru as nip_baru_pjbt, CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
                p.nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(' ',p.gelar_belakang) END) AS nama_pjbt, p.pangkat_gol AS gol_pjbt,
                CASE WHEN p.jenjab = 'Fungsional' THEN p.jabatan ELSE CASE WHEN p.id_j IS NULL THEN CASE WHEN (me_atsl.id_bos_pjbt = 0 OR p.id_pegawai IS NULL = 1) THEN NULL ELSE 'Fungsional Umum' END ELSE j.jabatan END END AS jabatan_pjbt
                FROM
                (SELECT me.*, CASE WHEN p.id_pegawai IS NULL = 1 THEN 0 ELSE p.id_pegawai END as id_pegawai_atsl,
                p.nip_baru as nip_baru_atsl, CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
                p.nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(' ',p.gelar_belakang) END) AS nama_atsl, p.pangkat_gol as gol_atsl,
                CASE WHEN p.jenjab = 'Fungsional' THEN p.jabatan ELSE CASE WHEN p.id_j IS NULL THEN CASE WHEN (me.id_bos_atsl = 0 OR p.id_pegawai IS NULL = 1) THEN NULL ELSE 'Fungsional Umum' END ELSE j.jabatan END END AS jabatan_atsl,
                CASE WHEN j.id_bos IS NULL = 1 THEN 0 ELSE j.id_bos END AS id_bos_pjbt
                FROM
                (
                SELECT a.*, clk.id_unit_kerja as id_unit_kerja_me, uk.nama_baru as unit_kerja_me
                FROM(
                SELECT p.id_pegawai, p.nip_baru, CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
                nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(' ',p.gelar_belakang) END) AS nama, p.pangkat_gol, p.jenjab,
                CASE WHEN p.jenjab = 'Fungsional' THEN p.jabatan ELSE CASE WHEN p.id_j IS NULL THEN 'Fungsional Umum' ELSE j.jabatan END END AS jabatan,
                CASE WHEN j.id_bos IS NULL = 1 THEN
                (
                    SELECT CASE WHEN ( (id_j_bos IS NULL) OR (COUNT(id_j_bos)=0)) THEN
                        (SELECT CASE WHEN ( (id_j_bos IS NULL) OR (COUNT(id_j_bos)=0)) THEN
                            (SELECT CASE WHEN ( (id_j_bos IS NULL) OR (COUNT(id_j_bos)=0)) THEN
                                (SELECT CASE WHEN ( (id_j_bos IS NULL) OR (COUNT(id_j_bos)=0)) THEN
                                    (SELECT CASE WHEN( (id_j_bos IS NULL) OR (COUNT(id_j_bos)=0)) THEN
                                        (SELECT CASE WHEN( (id_j_bos IS NULL) OR (COUNT(id_j_bos)=0)) THEN
                                            (SELECT CASE WHEN( (id_j_bos IS NULL) OR (COUNT(id_j_bos)=0)) THEN
                                            0
                                            ELSE  id_j_bos END AS id_j_bos
                                            FROM riwayat_mutasi_kerja rmk INNER JOIN
                                            (SELECT MAX(riwayat_mutasi_kerja.id_riwayat) AS idriwayat
                                            FROM riwayat_mutasi_kerja
                                            INNER JOIN sk
                                             ON sk.id_sk = riwayat_mutasi_kerja.id_sk
                                            WHERE sk.id_pegawai = ".$this->session->userdata('user_id')."
                                            AND sk.id_kategori_sk = 5
                                            GROUP BY riwayat_mutasi_kerja.id_pegawai
                                            ORDER BY tmt DESC LIMIT 1) a ON rmk.id_riwayat = a.idriwayat)
                                        ELSE  id_j_bos END AS id_j_bos
                                        FROM riwayat_mutasi_kerja rmk INNER JOIN
                                        (SELECT MAX(riwayat_mutasi_kerja.id_riwayat) AS idriwayat
                                        FROM riwayat_mutasi_kerja
                                        INNER JOIN sk
                                         ON sk.id_sk = riwayat_mutasi_kerja.id_sk
                                        WHERE sk.id_pegawai = ".$this->session->userdata('user_id')."
                                        AND sk.id_kategori_sk = 9
                                        GROUP BY riwayat_mutasi_kerja.id_pegawai
                                        ORDER BY tmt DESC LIMIT 1) a ON rmk.id_riwayat = a.idriwayat)
                                    ELSE  id_j_bos END AS id_j_bos
                                    FROM riwayat_mutasi_kerja rmk INNER JOIN
                                    (SELECT MAX(riwayat_mutasi_kerja.id_riwayat) AS idriwayat
                                    FROM riwayat_mutasi_kerja
                                    INNER JOIN sk
                                     ON sk.id_sk = riwayat_mutasi_kerja.id_sk
                                    WHERE sk.id_pegawai = ".$this->session->userdata('user_id')."
                                    AND sk.id_kategori_sk = 12
                                    GROUP BY riwayat_mutasi_kerja.id_pegawai
                                    ORDER BY tmt DESC LIMIT 1) a ON rmk.id_riwayat = a.idriwayat)
                                ELSE  id_j_bos END AS id_j_bos
                                FROM riwayat_mutasi_kerja rmk INNER JOIN
                                (SELECT MAX(riwayat_mutasi_kerja.id_riwayat) AS idriwayat
                                FROM riwayat_mutasi_kerja
                                INNER JOIN sk
                                 ON sk.id_sk = riwayat_mutasi_kerja.id_sk
                                WHERE sk.id_pegawai = ".$this->session->userdata('user_id')."
                                AND sk.id_kategori_sk = 10
                                GROUP BY riwayat_mutasi_kerja.id_pegawai
                                ORDER BY tmt DESC LIMIT 1) a ON rmk.id_riwayat = a.idriwayat)
                            ELSE  id_j_bos END AS id_j_bos
                            FROM riwayat_mutasi_kerja rmk INNER JOIN
                            (SELECT MAX(riwayat_mutasi_kerja.id_riwayat) AS idriwayat
                            FROM riwayat_mutasi_kerja
                            INNER JOIN sk
                             ON sk.id_sk = riwayat_mutasi_kerja.id_sk
                            WHERE sk.id_pegawai = ".$this->session->userdata('user_id')."
                            AND sk.id_kategori_sk = 7
                            GROUP BY riwayat_mutasi_kerja.id_pegawai
                            ORDER BY tmt DESC LIMIT 1) a ON rmk.id_riwayat = a.idriwayat)
                        ELSE  id_j_bos END AS id_j_bos
                        FROM riwayat_mutasi_kerja rmk INNER JOIN
                        (SELECT MAX(riwayat_mutasi_kerja.id_riwayat) AS idriwayat
                        FROM riwayat_mutasi_kerja
                        INNER JOIN sk
                         ON sk.id_sk = riwayat_mutasi_kerja.id_sk
                        WHERE sk.id_pegawai = ".$this->session->userdata('user_id')."
                        AND sk.id_kategori_sk = 6
                        GROUP BY riwayat_mutasi_kerja.id_pegawai
                        ORDER BY tmt DESC LIMIT 1) a ON rmk.id_riwayat = a.idriwayat)
                    ELSE  id_j_bos END AS id_j_bos
                    FROM riwayat_mutasi_kerja rmk INNER JOIN
                    (SELECT MAX(riwayat_mutasi_kerja.id_riwayat) AS idriwayat
                    FROM riwayat_mutasi_kerja
                    INNER JOIN sk
                     ON sk.id_sk = riwayat_mutasi_kerja.id_sk
                    WHERE sk.id_pegawai = ".$this->session->userdata('user_id')."
                    AND sk.id_kategori_sk = 1
                    GROUP BY riwayat_mutasi_kerja.id_pegawai
                    ORDER BY tmt DESC LIMIT 1) a ON rmk.id_riwayat = a.idriwayat
                )
                ELSE j.id_bos END as id_bos_atsl,
                ROUND(DATEDIFF(CURRENT_DATE, DATE_FORMAT(STR_TO_DATE(CONCAT(SUBSTRING(p.nip_baru,9,4),'/',SUBSTRING(p.nip_baru,13,2),'/','01'),
                '%Y/%m/%d'), '%Y-%m-%d'))/365,2) AS masa_kerja, p.alamat
                FROM pegawai p LEFT JOIN jabatan j ON p.id_j = j.id_j
                WHERE p.id_pegawai = ".$this->session->userdata('user_id').") AS a, current_lokasi_kerja clk, unit_kerja uk
                WHERE a.id_pegawai = clk.id_pegawai AND clk.id_unit_kerja = uk.id_unit_kerja
                ) AS me LEFT JOIN pegawai p ON (me.id_bos_atsl = p.id_j OR p.id_pegawai =
                    (SELECT CASE WHEN jplt.id_pegawai IS NULL = 1 THEN 0 ELSE jplt.id_pegawai END AS id_pegawai
                    FROM jabatan_plt jplt WHERE jplt.id_j = me.id_bos_atsl LIMIT 1))
                 LEFT JOIN jabatan j ON p.id_j = j.id_j
                ) AS me_atsl LEFT JOIN pegawai p ON me_atsl.id_bos_pjbt = p.id_j LEFT JOIN jabatan j ON p.id_j = j.id_j
                ) AS me_atsl_pjbt INNER JOIN current_lokasi_kerja clk ON me_atsl_pjbt.id_pegawai_atsl = clk.id_pegawai LEFT JOIN unit_kerja uk ON clk.id_unit_kerja = uk.id_unit_kerja
                ) AS me_atsl_pjbt_a INNER JOIN current_lokasi_kerja clk ON me_atsl_pjbt_a.id_pegawai_pjbt = clk.id_pegawai LEFT JOIN unit_kerja uk ON clk.id_unit_kerja = uk.id_unit_kerja) cuti_p
                LEFT JOIN jabatan_plt jp ON cuti_p.id_bos_atsl = jp.id_j) cuti_peg
                LEFT JOIN jabatan_plt jp ON cuti_peg.id_bos_pjbt = jp.id_j;";

		/*$get = $this->db->query('select concat(gelar_depan," ",nama," ",gelar_belakang) as nama,nama_baru,id_j,current_lokasi_kerja.id_unit_kerja as opd,id_j_bos from pegawai inner join current_lokasi_kerja on current_lokasi_kerja.id_pegawai=pegawai.id_pegawai inner join unit_kerja on unit_kerja.id_unit_kerja=current_lokasi_kerja.id_unit_kerja where pegawai.id_pegawai='.$this->session->userdata('user_id'));*/
		$get = $this->db->query($sql_data);
		foreach($get->result_array() as $us):
			return $us;
		endforeach;
	}


	/*function get_profile() {
		$get = $this->db->query('select * from knj_member a join knj_dinas b on a.member_dinas_id=b.dinas_id where a.member_nip = "'.$this->session->userdata('username').'"');

		foreach($get->result_array() as $us):
			return $us;
		endforeach;
	}
	*/

	function uploads($path, $allowed, $maxsize, $filename, $files) {
		$config['upload_path'] = $path;
		$config['allowed_types'] = $allowed;
		$config['max_size']	= $maxsize;
		$config['file_name'] = $filename;
		$this->load->library('upload', $config);
		$this->upload->initialize($config);
		$this->upload->do_upload($files);
	}

	function rows($select, $table) {
		$get = $this->db->query("select $select from $table");
		return $get->row_array();
	}

	function paging($link,$jum,$limit,$uri_segment)
	{
		$config_page['base_url']= site_url($link);
		$config_page['total_rows']= $jum->num_rows();
		$config_page['per_page']= $limit;
		$config_page['uri_segment']= $uri_segment;
		$config_page['full_tag_open'] = '<ul class="pagination right">';
		$config_page['full_tag_close'] = '</ul>';
		$config_page['first_link'] = '&laquo; First';
		$config_page['first_tag_open'] = '<li>';
		$config_page['first_tag_close'] = '</li>';

		$config_page['last_link'] = 'Last &raquo;';
		$config_page['last_tag_open'] = '<li>';
		$config_page['last_tag_close'] = '</li>';

		$config_page['next_link'] = 'Next';
		$config_page['next_tag_open'] = '<li>';
		$config_page['next_tag_close'] = '</li>';

		$config_page['prev_link'] = 'Prev';
		$config_page['prev_tag_open'] = '<li>';
		$config_page['prev_tag_close'] = '</li>';

		$config_page['cur_tag_open'] = '<li class="active"><a href="">';
		$config_page['cur_tag_close'] = '</a></li>';

		$config_page['num_tag_open'] = '<li>';
		$config_page['num_tag_close'] = '</li>';
		$this->pagination->initialize($config_page);
	}


	function query($select, $table) {
		$get = $this->db->query("select $select from $table");
		return $get->result_array();
	}


	function get_skp($kolom,$isi_kolom,$unit) {

		$get = $this->db->query("select kegiatan from stk_skp where $kolom=$isi_kolom and id_unit_kerja=$unit");
		return $get->result_array();
	}

	/*
	function get_skp($idpegawai) {
		$thn=date("Y");
		$get = $this->db->query("select uraian from anjab_uraian inner join anjab_pegawai on anjab_uraian.id_anjab=anjab_pegawai.id_anjab where id_pegawai=$idpegawai");
		return $get->result_array();
	}
	*/
	function getKategoriParent($id)
	{
		$this->db->select('kategori_nama');
			$this->db->from('knj_kategori');
			$this->db->where('kategori_id',$id);
			$getData = $this->db->get();

			if($getData->num_rows() > 0)
			{
				$rowData = $getData->result_array();
				return $rowData[0]['kategori_nama'];
			} else {
				return "-";
			}
	}

}

?>
