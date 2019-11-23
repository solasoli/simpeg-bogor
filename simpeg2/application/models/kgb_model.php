<?php 
class Kgb_model extends CI_Model{
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

	public function get_daftar_kgb($id_pegawai,$skpd, $tahun, $bulan, $jenis, $jenjab_filter){
		if($jenjab_filter==1){
			$filterJenjab1 = "AND f.jenjab = 'Struktural' OR (f.jenjab = 'Fungsional' AND f.jabatan LIKE '%Dokter%' AND f.unit = f.skpd)";
			$filterJenjab2 = "AND f.jenjab = 'Struktural' OR (f.jenjab = 'Fungsional' AND f.jabatan LIKE '%Dokter%' AND f.unit = f.skpd)";
		}else{
			$filterJenjab1 = "";
			$filterJenjab2 = "";
		}

		if($skpd == -1){
			$filter = "";
			$filter3 = "WHERE f.tmt_kgb_selanjutnya LIKE '$tahun-$bulan-01' ".$filterJenjab1." OR f.jabatan LIKE '%Penyuluh Keluarga Berencana%'";
		}else{
			$filter = " AND uk.id_skpd = $skpd";
			$filter3 = "WHERE f.tmt_kgb_selanjutnya LIKE '$tahun-$bulan-01' ".$filterJenjab1." OR f.jabatan LIKE '%Penyuluh Keluarga Berencana%'";
		}
		if($id_pegawai == ''){
			$filter2 = '';
		}else{
			$filter2 = "AND p.id_pegawai = $id_pegawai";
			$filter3 = '';
		}
		if($jenis=='KGB'){
			$whereKlause = "WHERE datax.status_kenaikan LIKE '%KGB%'";
		}elseif($jenis=='KP') {
			$filter3 = "WHERE f.tmt_pangkat_next LIKE '$tahun-$bulan-01' ".$filterJenjab2;
			$whereKlause = "";
		}else{
			$whereKlause = "";
		}

		$sql = "SELECT
				  datax.*,
				  (CASE WHEN datax.idgol_next IS NULL THEN datax.pangkat_gol ELSE g.golongan END) AS gol_next,
				  IF(datax.id_kategori_sk_terakhir = 5, 'SK.KP',
  					IF(datax.id_kategori_sk_terakhir = 7,'SK.PNS',
  						IF(datax.id_kategori_sk_terakhir = 9,'SK.KGB',IF(datax.id_kategori_sk_terakhir = -1,'Usulan KP. Apr-17','-')))) AS dasar_kgb
				FROM (SELECT
					f.*,
					DATE_FORMAT(f.tmt_kgb_selanjutnya, '%d-%m-%Y') AS kgb_selanjutnya,
					IF(f.tmt_pangkat_next = f.tmt_kgb_selanjutnya, 'Kenaikan Pangkat',
					(CASE WHEN f.tmt_pangkat_next IS NULL THEN 'KGB (Pangkat sdh tertinggi)' ELSE 'KGB' END)) AS status_kenaikan
				  FROM (SELECT
					  e.*,
					  CASE WHEN e.kelengkapan = 'Data Tidak Lengkap' THEN NULL ELSE (CASE WHEN e.id_kategori_sk_terakhir = 9 THEN DATE_ADD(e.tmt_terakhir, INTERVAL 2 year) ELSE (CASE WHEN (e.pangkat_gol = '' OR
								  e.pangkat_gol IS NULL) THEN NULL ELSE (CASE WHEN (e.pangkat_gol = 'I/b' OR
									  e.pangkat_gol = 'I/c' OR
									  e.pangkat_gol = 'I/d' OR
									  e.pangkat_gol = 'II/a' OR
									  e.pangkat_gol = 'II/b' OR
									  e.pangkat_gol = 'II/c' OR
									  e.pangkat_gol = 'II/d') THEN (IF(e.mk_tahun_terakhir % 2 = 0,
										DATE_ADD(e.tmt_terakhir, INTERVAL ((((e.mk_tahun_terakhir + 1) - e.mk_tahun_terakhir) * 12) - e.mk_bulan_terakhir) MONTH),
										DATE_ADD(e.tmt_terakhir, INTERVAL ((((e.mk_tahun_terakhir + 2) - e.mk_tahun_terakhir) * 12) - e.mk_bulan_terakhir) MONTH))) ELSE (IF(e.mk_tahun_terakhir % 2 = 0,
									  DATE_ADD(e.tmt_terakhir, INTERVAL ((((e.mk_tahun_terakhir + 2) - e.mk_tahun_terakhir) * 12) - e.mk_bulan_terakhir) MONTH),
									  DATE_ADD(e.tmt_terakhir, INTERVAL ((((e.mk_tahun_terakhir + 1) - e.mk_tahun_terakhir) * 12) - e.mk_bulan_terakhir) MONTH))) END) END) END) END AS tmt_kgb_selanjutnya
					FROM (SELECT
						d.*,
						CASE WHEN (d.tmt_kp = '' OR
							d.tmt_kp IS NULL) AND
							(d.tmt_kgb = '' OR
							d.tmt_kgb IS NULL) THEN (CASE WHEN (d.tmt_pns IS NULL OR
								  d.tmt_pns = '') THEN 'Data Tidak Lengkap' ELSE (CASE WHEN d.gol_pns <> d.pangkat_gol THEN 'Data Tidak Lengkap' ELSE 'Data KGB dan Pangkat Terakhir Belum Ada, Data SK PNS Ada' END) END) ELSE 'Data KGB dan Pangkat Terakhir Ada' END AS kelengkapan,
						CASE WHEN d.tmt_usulan IS NOT NULL THEN d.tmt_usulan ELSE (CASE WHEN (d.tmt_kp = '' OR d.tmt_kp IS NULL) AND (d.tmt_kgb = '' OR d.tmt_kgb IS NULL) THEN
  (CASE WHEN d.gol_pns <> d.pangkat_gol THEN '' ELSE d.tmt_pns END) ELSE
  (CASE WHEN (CASE WHEN d.tmt_kgb IS NULL THEN '0000-00-00' ELSE d.tmt_kgb END) >
  (CASE WHEN d.tmt_kp IS NULL THEN '0000-00-00' ELSE d.tmt_kp END) THEN d.tmt_kgb ELSE d.tmt_kp END) END) END as tmt_terakhir,
CASE WHEN d.tmt_usulan IS NOT NULL THEN d.mkg_thn_usulan ELSE (CASE WHEN (d.tmt_kp = '' OR d.tmt_kp IS NULL) AND (d.tmt_kgb = '' OR d.tmt_kgb IS NULL) THEN
  (CASE WHEN d.gol_pns <> d.pangkat_gol THEN '' ELSE d.mk_thn_pns END) ELSE
  (CASE WHEN (CASE WHEN d.tmt_kgb IS NULL THEN '0000-00-00' ELSE d.tmt_kgb END) >
  (CASE WHEN d.tmt_kp IS NULL THEN '0000-00-00' ELSE d.tmt_kp END) THEN d.mk_thn_kgb ELSE d.mk_thn_kp END) END) END as mk_tahun_terakhir,
CASE WHEN d.tmt_usulan IS NOT NULL THEN d.mkg_bln_usulan ELSE (CASE WHEN (d.tmt_kp = '' OR d.tmt_kp IS NULL) AND (d.tmt_kgb = '' OR d.tmt_kgb IS NULL) THEN
  (CASE WHEN d.gol_pns <> d.pangkat_gol THEN '' ELSE d.mk_bln_pns END) ELSE
  (CASE WHEN (CASE WHEN d.tmt_kgb IS NULL THEN '0000-00-00' ELSE d.tmt_kgb END) >
  (CASE WHEN d.tmt_kp IS NULL THEN '0000-00-00' ELSE d.tmt_kp END) THEN d.mk_bln_kgb ELSE d.mk_bln_kp END) END) END as mk_bulan_terakhir,
CASE WHEN d.tmt_usulan IS NOT NULL THEN (CASE WHEN d.tmt_usulan = d.tmt_kp THEN 5 ELSE -1 END) ELSE (CASE WHEN (d.tmt_kp = '' OR d.tmt_kp IS NULL) AND (d.tmt_kgb = '' OR d.tmt_kgb IS NULL) THEN
  (CASE WHEN d.gol_pns <> d.pangkat_gol THEN '' ELSE 7 END) ELSE
  (CASE WHEN (CASE WHEN d.tmt_kgb IS NULL THEN '0000-00-00' ELSE d.tmt_kgb END) >
  (CASE WHEN d.tmt_kp IS NULL THEN '0000-00-00' ELSE d.tmt_kp END) THEN 9 ELSE 5 END) END) END as id_kategori_sk_terakhir,
						CASE WHEN (d.tmt_kp = '' OR
							d.tmt_kp IS NULL) THEN (CASE WHEN d.gol_pns <> d.pangkat_gol THEN '' ELSE DATE_ADD(d.tmt_pns, INTERVAL 4 year) END) ELSE (CASE WHEN d.jenjab = 'Struktural' THEN (CASE WHEN eselon = 'Z' THEN (CASE WHEN pangkat_gol < max_gol_pend THEN DATE_ADD(d.tmt_kp, INTERVAL 4 year) ELSE NULL END) ELSE (CASE WHEN pangkat_gol < max_gol_pend THEN DATE_ADD(d.tmt_kp, INTERVAL 4 year) ELSE (CASE WHEN pangkat_gol < max_gol_eselon THEN DATE_ADD(d.tmt_kp, INTERVAL 4 year) ELSE NULL END) END) END) ELSE DATE_ADD(d.tmt_kp, INTERVAL 2 year) END) END AS tmt_pangkat_next,
						CASE WHEN d.jenjab = 'Struktural' THEN (CASE WHEN eselon = 'Z' THEN (CASE WHEN pangkat_gol < max_gol_pend THEN (d.id_golongan + 1) ELSE NULL END) ELSE (CASE WHEN pangkat_gol < max_gol_pend THEN (d.id_golongan + 1) ELSE (CASE WHEN pangkat_gol < max_gol_eselon THEN (d.id_golongan + 1) ELSE NULL END) END) END) ELSE (d.id_golongan + 1) END AS idgol_next
					  FROM (SELECT
						  d2.*,
						  p.level_p,
						  pp.max AS max_gol_pend,
						  ge.gol_maksimal AS max_gol_eselon
						FROM (SELECT
								  d1.*,
								  CASE WHEN ukb.gol IS NULL THEN '' ELSE ukb.gol END AS gol_usulan,
								  ukb.tmt AS tmt_usulan,
								  ukb.mkg_thn AS mkg_thn_usulan,
								  ukb.mkg_bln AS mkg_bln_usulan
								FROM (SELECT
									c.id_pegawai,
									c.nip,
									c.nama,
									c.jenjab,
									c.pangkat_gol,
									c.id_golongan,
									c.jabatan,
									c.eselon,
									c.unit,
									c.skpd,
									MAX(CASE WHEN c.id_kategori_sk = 7 THEN c.tmt END) AS tmt_pns,
									MAX(CASE WHEN c.id_kategori_sk = 7 THEN c.gol END) AS gol_pns,
									MAX(CASE WHEN c.id_kategori_sk = 7 THEN c.mk_tahun END) AS mk_thn_pns,
									MAX(CASE WHEN c.id_kategori_sk = 7 THEN c.mk_bulan END) AS mk_bln_pns,
									MAX(CASE WHEN c.id_kategori_sk = 5 THEN c.tmt END) AS tmt_kp,
									MAX(CASE WHEN c.id_kategori_sk = 5 THEN c.gol END) AS gol_kp,
									MAX(CASE WHEN c.id_kategori_sk = 5 THEN c.mk_tahun END) AS mk_thn_kp,
									MAX(CASE WHEN c.id_kategori_sk = 5 THEN c.mk_bulan END) AS mk_bln_kp,
									MAX(CASE WHEN c.id_kategori_sk = 9 THEN c.tmt END) AS tmt_kgb,
									MAX(CASE WHEN c.id_kategori_sk = 9 THEN c.gol END) AS gol_kgb,
									MAX(CASE WHEN c.id_kategori_sk = 9 THEN c.mk_tahun END) AS mk_thn_kgb,
									MAX(CASE WHEN c.id_kategori_sk = 9 THEN c.mk_bulan END) AS mk_bln_kgb
								  FROM (SELECT
									  b.*,
									  s.gol,
									  s.mk_tahun,
									  s.mk_bulan
									FROM (SELECT
										a.*,
										MAX(s.id_sk) AS id_sk
									  FROM (SELECT
										  peg.id_pegawai,
										  peg.nip,
										  peg.nama,
										  peg.jenjab,
										  peg.pangkat_gol,
										  peg.id_golongan,
										  peg.jabatan,
										  peg.eselon,
										  peg.unit,
										  peg.skpd,
										  sk.id_kategori_sk,
										  MAX(sk.tmt) AS tmt
										FROM (SELECT
											b.id_pegawai,
											CONCAT(\"'\", b.nip_baru) AS nip,
											b.nama,
											b.tempat_lahir,
											b.tgl_lahir,
											b.usia,
											b.jenjab,
											b.pangkat_gol,
											b.jabatan,
											b.eselon,
											b.unit,
											b.id_skpd,
											uk.nama_baru AS skpd,
											b.id_golongan/*, a.Alamat, a.alamat_rumah*/
										  FROM (SELECT
												   a.*,
												   g.id_golongan
												 FROM (SELECT
													 p.id_pegawai,
													 p.nip_baru,
													 CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
													 nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(' ', p.gelar_belakang) END) AS nama,
													 p.tempat_lahir,
													 p.tgl_lahir,
													 ROUND(DATEDIFF(current_date, DATE_FORMAT(p.tgl_lahir, '%Y/%m/%d')) / 365, 2) AS usia,
													 p.jenjab,
													 p.pangkat_gol,
													 CASE WHEN p.jenjab = 'Fungsional' THEN p.jabatan ELSE CASE WHEN p.id_j IS NULL THEN (SELECT
																   jm.nama_jfu AS jabatan
																 FROM jfu_pegawai jp,
																	  jfu_master jm
																 WHERE jp.kode_jabatan = jm.kode_jabatan
																 AND jp.id_pegawai = p.id_pegawai LIMIT 1) ELSE j.jabatan END END AS jabatan,
													 CASE WHEN j.eselon IS NULL THEN 'Z' ELSE j.eselon END AS eselon,
													 uk.nama_baru AS unit,
													 uk.id_skpd
												   FROM pegawai p
														  LEFT JOIN jabatan j
															ON p.id_j = j.id_j,
														current_lokasi_kerja clk,
														unit_kerja uk
												   WHERE p.id_pegawai = clk.id_pegawai
												   AND clk.id_unit_kerja = uk.id_unit_kerja
												   AND p.flag_pensiun = 0 $filter2 $filter
												   ORDER BY eselon ASC, p.pangkat_gol DESC, p.nama) a
												   LEFT JOIN golongan g
													 ON a.pangkat_gol = g.golongan) b,
											   unit_kerja uk
										  WHERE b.id_skpd = uk.id_unit_kerja $filter) peg
										  LEFT JOIN sk
											ON peg.id_pegawai = sk.id_pegawai
											AND (sk.id_kategori_sk IN (5, 7, 9))
										GROUP BY peg.id_pegawai,
												 peg.nip,
												 peg.nama,
												 peg.pangkat_gol,
												 peg.jabatan,
												 peg.eselon,
												 peg.unit,
												 peg.skpd,
												 sk.id_kategori_sk
										ORDER BY sk.id_kategori_sk, sk.tmt DESC) a
										LEFT JOIN sk s
										  ON a.id_pegawai = s.id_pegawai
										  AND a.id_kategori_sk = s.id_kategori_sk
										  AND a.tmt = s.tmt
									  GROUP BY a.id_pegawai,
											   a.nip,
											   a.nama,
											   a.pangkat_gol,
											   a.id_golongan,
											   a.jabatan,
											   a.eselon,
											   a.unit,
											   a.skpd,
											   a.id_kategori_sk,
											   a.tmt
									  ORDER BY a.id_pegawai, a.tmt DESC) b
									  LEFT JOIN sk s
										ON b.id_sk = s.id_sk) c
								  GROUP BY c.id_pegawai) d1
								  LEFT JOIN usulan_kp_bkn ukb
									ON d1.id_pegawai = ukb.id_pegawai) d2
						  LEFT JOIN pendidikan p
							ON d2.id_pegawai = p.id_pegawai
							AND p.id_pendidikan = (SELECT
								p.id_pendidikan
							  FROM pendidikan p
							  WHERE p.id_pegawai = d2.id_pegawai
							  ORDER BY p.level_p ASC LIMIT 1)
						  LEFT JOIN pendidikan_puncak pp
							ON p.level_p = pp.level_p
						  LEFT JOIN golongan_eselon ge
							ON d2.eselon = ge.eselon) d) e) f
				  $filter3
				  ORDER BY f.eselon ASC, f.pangkat_gol DESC, f.nama) datax
				  LEFT JOIN golongan g
					ON datax.idgol_next = g.id_golongan $whereKlause";

		$query = $this->db->query($sql);
		
		$data = null;
		foreach ($query->result() as $row)
		{
			$data[] = $row;
		}
		return $data;
	}

	public function get_daftar_kgb_old2($skpd, $tahun, $bulan){
		if($skpd == -1)
			$query = $this->db->query("SELECT p.id_pegawai, p.NAMA, p.nip_baru as NIP, p.pangkat_gol as GOLONGAN, x.tmt as TMT_KGB_TERAKHIR, v.golongan as gol_cpns, u.nama_baru as UNIT_KERJA, x.no_sk, x.tgl_sk as tgl_sk
				FROM `view_kgb_pertama` v
				inner join pegawai p on p.id_pegawai = v.id_pegawai
				inner join current_lokasi_kerja c on c.id_pegawai = p.id_pegawai
				inner join unit_kerja u on u.id_unit_kerja = c.id_unit_kerja
				left join (
					select s.id_pegawai, max(s.tmt) as tmt, s.no_sk, s.id_kategori_sk, max(s.tgl_sk) as tgl_sk
					from sk s
					inner join (
					select id_pegawai, max(tmt) as tmt, id_kategori_sk, no_sk, id_sk
					from sk
					where $tahun-year(tmt)<=4 AND id_kategori_sk in (7,5,9)
					group by id_pegawai, id_kategori_sk
					ORDER BY `sk`.`id_pegawai` ASC
						)as x on x.id_pegawai = s.id_pegawai
					group by s.id_pegawai
				) as x on x.id_pegawai = p.id_pegawai
				where p.flag_pensiun = 0 AND ($tahun-LEFT(kgb_pertama,4))%2 = 0 AND MONTH(kgb_pertama) = $bulan
				ORDER BY nama_baru ASC, pangkat_gol DESC");
		else
			$query = $this->db->query("SELECT p.NAMA, 
										p.nip_baru as NIP, 
										p.pangkat_gol as GOLONGAN, 
										x.tmt as TMT_KGB_TERAKHIR, 
										v.golongan as gol_cpns, 
										u.nama_baru as UNIT_KERJA, 
										x.no_sk, x.tgl_sk as tgl_sk
				FROM `view_kgb_pertama` v
				inner join pegawai p on p.id_pegawai = v.id_pegawai
				inner join current_lokasi_kerja c on c.id_pegawai = p.id_pegawai
				inner join unit_kerja u on u.id_unit_kerja = c.id_unit_kerja
				left join (
					select s.id_pegawai, max(s.tmt) as tmt, s.no_sk, s.id_kategori_sk, max(s.tgl_sk) as tgl_sk
					from sk s
					inner join (
					select id_pegawai, max(tmt) as tmt, id_kategori_sk, no_sk, id_sk
					from sk
					where $tahun-year(tmt)<=4 AND id_kategori_sk in (7,5,9)
					group by id_pegawai, id_kategori_sk
					ORDER BY `sk`.`id_pegawai` ASC
						)as x on x.id_pegawai = s.id_pegawai
					group by s.id_pegawai
				) as x on x.id_pegawai = p.id_pegawai
				where p.flag_pensiun = 0 AND ($tahun-LEFT(kgb_pertama,4))%2 = 0 AND MONTH(kgb_pertama) = $bulan
				AND u.id_skpd = $skpd
				ORDER BY nama_baru ASC, pangkat_gol DESC");

		$data = null;
		foreach ($query->result() as $row)
		{
			$data[] = $row;
		}
		return $data;
	}
	
	public function get_daftar_kgb_old($skpd, $tahun, $bulan){
		if($skpd == -1)
			$query = $this->db->query("select *
				from(
					SELECT p.id_pegawai, p.nama AS NAMA, p.nip_baru AS NIP, p.pangkat_gol AS GOLONGAN, s.tmt AS  'TMT_KGB_TERAKHIR', u.nama_baru AS  'UNIT_KERJA'
					FROM pegawai p
					INNER JOIN (
						SELECT id_pegawai, MAX( tmt ) AS tmt, id_kategori_sk
						FROM sk
						WHERE (id_kategori_sk = 9 or id_kategori_sk = 6 or id_kategori_sk = 5)
						GROUP BY id_pegawai
					) AS s ON s.id_pegawai = p.id_pegawai
					INNER JOIN current_lokasi_kerja c ON c.id_pegawai = p.id_pegawai
					INNER JOIN unit_kerja u ON u.id_unit_kerja = c.id_unit_kerja
					WHERE p.flag_pensiun = 0 and p.jabatan not like '%guru%'
					AND DATE_FORMAT( s.tmt,  '%Y%m' ) = CONCAT( $tahun -2,  '$bulan' ) 										
					UNION
					SELECT p.id_pegawai, p.nama AS NAMA, p.nip_baru AS NIP, p.pangkat_gol AS GOLONGAN, s.tmt AS  'TMT_KGB_TERAKHIR', u.nama_baru AS  'UNIT_KERJA'
					FROM pegawai p
					INNER JOIN sk s
					ON s.id_pegawai = p.id_pegawai
					INNER JOIN current_lokasi_kerja c ON c.id_pegawai = p.id_pegawai
					INNER JOIN unit_kerja u ON u.id_unit_kerja = c.id_unit_kerja
					WHERE p.flag_pensiun = 0 and p.jabatan not like '%guru%' and s.id_kategori_sk = 9
					AND DATE_FORMAT( s.tmt,  '%Y%m' ) = CONCAT( $tahun,  '$bulan' )
				) as global 
				ORDER BY unit_kerja, nama, golongan desc");
		else
			$query = $this->db->query("select *
				from(
					SELECT p.id_pegawai, p.nama AS NAMA, p.nip_baru AS NIP, p.pangkat_gol AS GOLONGAN, s.tmt AS  'TMT_KGB_TERAKHIR', u.nama_baru AS  'UNIT_KERJA', u.id_skpd
					FROM pegawai p
					INNER JOIN (
						SELECT id_pegawai, MAX( tmt ) AS tmt, id_kategori_sk
						FROM sk
						WHERE (id_kategori_sk = 9 or id_kategori_sk = 6 or id_kategori_sk = 5)
						GROUP BY id_pegawai
					) AS s ON s.id_pegawai = p.id_pegawai
					INNER JOIN current_lokasi_kerja c ON c.id_pegawai = p.id_pegawai
					INNER JOIN unit_kerja u ON u.id_unit_kerja = c.id_unit_kerja
					WHERE p.flag_pensiun = 0 and p.jabatan not like '%guru%'
					AND DATE_FORMAT( s.tmt,  '%Y%m' ) = CONCAT( $tahun -2,  '$bulan' ) 										
					UNION
					SELECT p.id_pegawai, p.nama AS NAMA, p.nip_baru AS NIP, p.pangkat_gol AS GOLONGAN, s.tmt AS  'TMT_KGB_TERAKHIR', u.nama_baru AS  'UNIT_KERJA', u.id_skpd
					FROM pegawai p
					INNER JOIN sk s
					ON s.id_pegawai = p.id_pegawai
					INNER JOIN current_lokasi_kerja c ON c.id_pegawai = p.id_pegawai
					INNER JOIN unit_kerja u ON u.id_unit_kerja = c.id_unit_kerja
					WHERE p.flag_pensiun = 0 and p.jabatan not like '%guru%' and s.id_kategori_sk = 9
					AND DATE_FORMAT( s.tmt,  '%Y%m' ) = CONCAT( $tahun,  '$bulan' )
				) as global 
				WHERE id_skpd = $skpd
				ORDER BY unit_kerja, nama, golongan desc");

		$data = null;
		foreach ($query->result() as $row)
		{
			$data[] = $row;
		}
		return $data;
	}
	
	public function get_laporan_kgb($skpd, $tahun, $bulan){
		$q = "select * 
			from pegawai p 			
			inner join sk s on s.id_pegawai = p.id_pegawai
			left join unit_kerja u on u.id_unit_kerja = s.id_unit_kerja
			where s.id_kategori_sk = 9
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
		$query = $this->db->query("SELECT * 
									FROM sk s									
									WHERE s.id_pegawai = ".$id_pegawai.
									" AND id_kategori_sk = 9" );

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
	
	public function recap_kgb_per_tahun(){
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
										where id_kategori_sk = 9 and year(tmt) > year(curdate())-5
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
