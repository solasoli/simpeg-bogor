<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ekinerja_model extends CI_Model{

    public function __Construct(){
        parent::__Construct();

    }

    public function getDataDasar($id_pegawai){
        $sql = "SELECT data3.*, opd.nama_baru as opd, j.eselon as eselon_kepala, j.jabatan as jabatan_kepala, j.id_j as id_j_kepala, (data3.nilai_jabatan*4000) as tunjangan,
                p1.nip_baru as nip_baru_atsl_plh, CONCAT(CASE WHEN p1.gelar_depan = '' THEN '' ELSE CONCAT(p1.gelar_depan, ' ') END,
                p1.nama, CASE WHEN p1.gelar_belakang = '' THEN '' ELSE CONCAT(', ',p1.gelar_belakang) END) as nama_atsl_plh,
                CASE WHEN data3.jabatan_atsl LIKE 'Walikota Bogor%' THEN '-' ELSE p1.pangkat_gol END as gol_atsl_plh, 
                CASE WHEN p1.jenjab = 'Fungsional' THEN (SELECT jaf.id_jafung AS kode_jabatan FROM jafung_pegawai jap, jafung jaf
                WHERE jap.id_jafung = jaf.id_jafung AND jap.id_pegawai = p1.id_pegawai ORDER BY jap.tmt DESC LIMIT 1) ELSE CASE WHEN p1.id_j IS NULL THEN (SELECT jm.id_jfu AS kode_jabatan FROM jfu_pegawai jp, jfu_master jm
                WHERE jp.id_jfu = jm.id_jfu AND jp.id_pegawai = p1.id_pegawai ORDER BY jp.tmt DESC LIMIT 1) ELSE j.id_j END END AS id_bos_atsl_plh,
                CASE WHEN p1.jenjab = 'Fungsional' THEN (CASE WHEN (SELECT jaf.nama_jafung AS jabatan FROM jafung_pegawai jap, jafung jaf
                WHERE jap.id_jafung = jaf.id_jafung AND jap.id_pegawai = p1.id_pegawai ORDER BY jap.tmt DESC LIMIT 1) IS NULL THEN p1.jabatan ELSE (SELECT jaf.nama_jafung AS jabatan FROM jafung_pegawai jap, jafung jaf
                WHERE jap.id_jafung = jaf.id_jafung AND jap.id_pegawai = p1.id_pegawai ORDER BY jap.tmt DESC LIMIT 1) END) ELSE CASE WHEN p1.id_j IS NULL THEN (SELECT jm.nama_jfu AS jabatan FROM jfu_pegawai jp, jfu_master jm
                WHERE jp.id_jfu = jm.id_jfu AND jp.id_pegawai = p1.id_pegawai ORDER BY jp.tmt DESC LIMIT 1) ELSE j.jabatan END END AS jabatan_atsl_plh, 
                p2.nip_baru as nip_baru_pjbt_plh,
                CONCAT(CASE WHEN p2.gelar_depan = '' THEN '' ELSE CONCAT(p2.gelar_depan, ' ') END,
                p2.nama, CASE WHEN p2.gelar_belakang = '' THEN '' ELSE CONCAT(', ',p2.gelar_belakang) END) as nama_pjbt_plh,
                CASE WHEN data3.jabatan_pjbt LIKE 'Walikota Bogor%' THEN '-' ELSE p2.pangkat_gol END as gol_pjbt_plh, 
                CASE WHEN p2.jenjab = 'Fungsional' THEN (SELECT jaf.id_jafung AS kode_jabatan FROM jafung_pegawai jap, jafung jaf
                WHERE jap.id_jafung = jaf.id_jafung AND jap.id_pegawai = p2.id_pegawai ORDER BY jap.tmt DESC LIMIT 1) ELSE CASE WHEN p2.id_j IS NULL THEN (SELECT jm.id_jfu AS kode_jabatan FROM jfu_pegawai jp, jfu_master jm
                WHERE jp.id_jfu = jm.id_jfu AND jp.id_pegawai = p2.id_pegawai ORDER BY jp.tmt DESC LIMIT 1) ELSE j.id_j END END AS id_bos_pjbt_plh,
                CASE WHEN p2.jenjab = 'Fungsional' THEN (CASE WHEN (SELECT jaf.nama_jafung AS jabatan FROM jafung_pegawai jap, jafung jaf
                WHERE jap.id_jafung = jaf.id_jafung AND jap.id_pegawai = p2.id_pegawai ORDER BY jap.tmt DESC LIMIT 1) IS NULL THEN p2.jabatan ELSE (SELECT jaf.nama_jafung AS jabatan FROM jafung_pegawai jap, jafung jaf
                WHERE jap.id_jafung = jaf.id_jafung AND jap.id_pegawai = p2.id_pegawai ORDER BY jap.tmt DESC LIMIT 1) END) ELSE CASE WHEN p2.id_j IS NULL THEN (SELECT jm.nama_jfu AS jabatan FROM jfu_pegawai jp, jfu_master jm
                WHERE jp.id_jfu = jm.id_jfu AND jp.id_pegawai = p2.id_pegawai ORDER BY jp.tmt DESC LIMIT 1) ELSE j.jabatan END END AS jabatan_pjbt_plh
                FROM
                (SELECT data2.*, jh.id_pegawai as idp_plh_pjbt FROM
                (SELECT data1.*, jh.id_pegawai as idp_plh_atsl FROM 
                (SELECT data_dasar.*, jp.id_pegawai as idp_plt_pjbt FROM
                (SELECT data_d.*, jp.id_pegawai as idp_plt_atsl FROM
                (SELECT me_atsl_pjbt_a.*, clk.id_unit_kerja as id_unit_kerja_pjbt, uk.id_skpd
                FROM( 
                SELECT me_atsl_pjbt.*, clk.id_unit_kerja as id_unit_kerja_atsl
                FROM 
                (SELECT me_atsl.*, CASE WHEN p.id_pegawai IS NULL = 1 THEN 0 ELSE p.id_pegawai END as id_pegawai_pjbt,
                CASE WHEN j.jabatan LIKE 'Walikota Bogor%' THEN '-' ELSE p.nip_baru END as nip_baru_pjbt, CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
                p.nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(', ',p.gelar_belakang) END) AS nama_pjbt, CASE WHEN j.jabatan LIKE 'Walikota Bogor%' THEN '-' ELSE p.pangkat_gol END AS gol_pjbt,
                CASE WHEN p.jenjab = 'Fungsional' THEN p.jabatan ELSE CASE WHEN p.id_j IS NULL THEN CASE WHEN (me_atsl.id_bos_pjbt = 0 OR p.id_pegawai IS NULL = 1) THEN NULL ELSE 'Fungsional Umum' END ELSE j.jabatan END END AS jabatan_pjbt,
                (CASE WHEN (STR_TO_DATE(CONCAT(YEAR(NOW()),'-',MONTH(NOW()),'-01'),'%Y-%m-%d') >= cm.tmt_awal) AND (LAST_DAY(CONCAT(YEAR(NOW()),'-',MONTH(NOW()),'-01')) <= cm.tmt_akhir) THEN 1 ELSE 0 END) as status_cuti 
                FROM
                (SELECT me_atsl.* FROM 
                (SELECT me.*, CASE WHEN p.id_pegawai IS NULL = 1 THEN 0 ELSE p.id_pegawai END as id_pegawai_atsl,
                p.nip_baru as nip_baru_atsl, CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
                p.nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(', ',p.gelar_belakang) END) AS nama_atsl, p.pangkat_gol as gol_atsl,
                CASE WHEN p.jenjab = 'Fungsional' THEN p.jabatan ELSE CASE WHEN p.id_j IS NULL THEN CASE WHEN (me.id_bos_atsl = 0 OR p.id_pegawai IS NULL = 1) THEN NULL ELSE 'Fungsional Umum' END ELSE j.jabatan END END AS jabatan_atsl,
                (CASE WHEN j.id_bos IS NULL = 1 THEN (SELECT id_bos FROM jabatan WHERE id_j = me.id_bos_atsl AND tahun = (SELECT MAX(tahun) FROM jabatan)) ELSE (CASE WHEN (me.unit_kerja_me = 'RSUD Kota Bogor' AND
                me.id_bos = (SELECT j.id_j FROM jabatan j WHERE j.tahun = (SELECT MAX(tahun) FROM jabatan)
                AND j.jabatan LIKE 'Walikota Bogor%')) THEN 
                (SELECT j.id_j FROM jabatan j WHERE j.tahun = (SELECT MAX(tahun) FROM jabatan)
                AND j.jabatan LIKE '%Sekretaris Daerah%') ELSE
                CASE WHEN me.id_bos IS NULL = 1 THEN j.id_bos ELSE ( CASE WHEN me.idj_plt_ybs IS NULL = 1 THEN me.id_bos
                ELSE (CASE WHEN me.jabatan_plt_ybs LIKE 'Walikota Bogor%' THEN (SELECT id_bos FROM jabatan WHERE id_j = me.id_bos AND tahun = (SELECT MAX(tahun) FROM jabatan))
                ELSE (CASE WHEN (SELECT id_j FROM jabatan WHERE id_j = me.idj_plt_ybs AND tahun = (SELECT MAX(tahun) FROM jabatan)) = me.id_bos
                THEN me.id_bos ELSE (SELECT id_bos FROM jabatan WHERE id_j = (SELECT id_bos FROM jabatan 
                WHERE id_j = (CASE WHEN me.jabatan LIKE '%Plt%' THEN (CASE WHEN (me.jenjab = 'Fungsional' AND me.unit_kerja_me LIKE '%Dinas Tenaga Kerja%') THEN
                me.id_bos_atsl_plt ELSE (CASE WHEN me.eselon >= me.eselon_plt_ybs THEN me.idj_plt_ybs ELSE (CASE WHEN me.eselon IS NULL = 1 THEN me.idj_plt_ybs ELSE me.id_bos_atsl_plt END) END) END) ELSE me.idj_plt_ybs END)
                AND tahun = (SELECT MAX(tahun) FROM jabatan)) AND tahun = (SELECT MAX(tahun) FROM jabatan)) END) END) END) END END) END) AS id_bos_pjbt  
                FROM (
                SELECT a.*, clk.id_unit_kerja as id_unit_kerja_me, uk.nama_baru as unit_kerja_me, uk.id_skpd as id_skpd_me, j.id_bos as id_bos
                FROM (SELECT a.*, CASE WHEN a.id_bos_atsl_plt IS NULL = 1 THEN a.id_bos_atsl_ori ELSE CASE WHEN skp.id_j = a.id_bos_atsl_plt THEN a.id_bos_atsl_plt ELSE a.id_bos_atsl_ori END END AS id_bos_atsl, skp.id_penilai
                FROM (
                SELECT p.id_pegawai, p.nip_baru, CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END, 
                nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(', ',p.gelar_belakang) END) AS nama, p.pangkat_gol, p.jenjab, p.status_pegawai, 
                CASE WHEN p.jenjab = 'Fungsional' THEN (SELECT jaf.id_jafung AS kode_jabatan FROM jafung_pegawai jap, jafung jaf 
                WHERE jap.id_jafung = jaf.id_jafung AND jap.id_pegawai = p.id_pegawai ORDER BY jap.tmt DESC LIMIT 1) ELSE CASE WHEN p.id_j IS NULL THEN (SELECT jm.id_jfu AS kode_jabatan FROM jfu_pegawai jp, jfu_master jm
                WHERE jp.id_jfu = jm.id_jfu AND jp.id_pegawai = p.id_pegawai ORDER BY jp.tmt DESC LIMIT 1) ELSE j.id_j END END AS kode_jabatan,
                CASE WHEN p.jenjab = 'Fungsional' THEN (SELECT jaf.kelas_jabatan AS kode_jabatan FROM jafung_pegawai jap, jafung jaf
                WHERE jap.id_jafung = jaf.id_jafung AND jap.id_pegawai = p.id_pegawai ORDER BY jap.tmt DESC LIMIT 1) ELSE CASE WHEN p.id_j IS NULL THEN (SELECT jm.kelas_jabatan AS kode_jabatan FROM jfu_pegawai jp, jfu_master jm
                WHERE jp.id_jfu = jm.id_jfu AND jp.id_pegawai = p.id_pegawai ORDER BY jp.tmt DESC LIMIT 1) ELSE j.kelas_jabatan END END AS kelas_jabatan,
                CASE WHEN p.jenjab = 'Fungsional' THEN (SELECT jaf.nilai_jabatan AS kode_jabatan FROM jafung_pegawai jap, jafung jaf
                WHERE jap.id_jafung = jaf.id_jafung AND jap.id_pegawai = p.id_pegawai ORDER BY jap.tmt DESC LIMIT 1) ELSE CASE WHEN p.id_j IS NULL THEN (SELECT jm.nilai_jabatan AS kode_jabatan FROM jfu_pegawai jp, jfu_master jm
                WHERE jp.id_jfu = jm.id_jfu AND jp.id_pegawai = p.id_pegawai ORDER BY jp.tmt DESC LIMIT 1) ELSE j.nilai_jabatan END END AS nilai_jabatan,
                CASE WHEN p.jenjab = 'Fungsional' THEN (CASE WHEN (SELECT jaf.nama_jafung AS jabatan FROM jafung_pegawai jap, jafung jaf
                WHERE jap.id_jafung = jaf.id_jafung AND jap.id_pegawai = p.id_pegawai ORDER BY jap.tmt DESC LIMIT 1) IS NULL THEN p.jabatan ELSE (SELECT jaf.nama_jafung AS jabatan FROM jafung_pegawai jap, jafung jaf
                WHERE jap.id_jafung = jaf.id_jafung AND jap.id_pegawai = p.id_pegawai ORDER BY jap.tmt DESC LIMIT 1) END) ELSE CASE WHEN p.id_j IS NULL THEN (SELECT jm.nama_jfu AS jabatan FROM jfu_pegawai jp, jfu_master jm
                WHERE jp.id_jfu = jm.id_jfu AND jp.id_pegawai = p.id_pegawai ORDER BY jp.tmt DESC LIMIT 1) ELSE j.jabatan END END AS jab_ori,
                CONCAT(
                CASE WHEN p.jenjab = 'Fungsional' THEN (CASE WHEN (SELECT jaf.nama_jafung AS jabatan FROM jafung_pegawai jap, jafung jaf
                WHERE jap.id_jafung = jaf.id_jafung AND jap.id_pegawai = p.id_pegawai ORDER BY jap.tmt DESC LIMIT 1) IS NULL THEN p.jabatan ELSE (SELECT jaf.nama_jafung AS jabatan FROM jafung_pegawai jap, jafung jaf
                WHERE jap.id_jafung = jaf.id_jafung AND jap.id_pegawai = p.id_pegawai ORDER BY jap.tmt DESC LIMIT 1) END) ELSE CASE WHEN p.id_j IS NULL THEN (SELECT jm.nama_jfu AS jabatan FROM jfu_pegawai jp, jfu_master jm
                WHERE jp.id_jfu = jm.id_jfu AND jp.id_pegawai = p.id_pegawai ORDER BY jp.tmt DESC LIMIT 1) ELSE j.jabatan END END,
                (CASE WHEN jplt.idj_plt_ybs IS NULL = 1 THEN '' ELSE CONCAT(CASE WHEN j2.jabatan = 'Walikota Bogor' THEN ' sebagai Plh. ' ELSE ' sebagai Plt. ' END, j2.jabatan) END)) AS jabatan, j.eselon,
                CASE WHEN j.id_bos IS NULL = 1 THEN
                (
                SELECT CASE WHEN ( (id_j_bos IS NULL) OR (COUNT(id_j_bos)=0)) THEN
                (SELECT CASE WHEN ( (id_j_bos IS NULL) OR (COUNT(id_j_bos)=0)) THEN
                (SELECT CASE WHEN ( (id_j_bos IS NULL) OR (COUNT(id_j_bos)=0)) THEN
                (SELECT CASE WHEN ( (id_j_bos IS NULL) OR (COUNT(id_j_bos)=0)) THEN
                    (SELECT CASE WHEN( (id_j_bos IS NULL) OR (COUNT(id_j_bos)=0)) THEN
                        (SELECT CASE WHEN( (id_j_bos IS NULL) OR (COUNT(id_j_bos)=0)) THEN
                            (SELECT CASE WHEN( (id_j_bos IS NULL) OR (COUNT(id_j_bos)=0)) THEN
                                (SELECT CASE WHEN( (id_j_bos IS NULL) OR (COUNT(id_j_bos)=0)) THEN
                                    (SELECT CASE WHEN( (id_j_bos IS NULL) OR (COUNT(id_j_bos)=0)) THEN
                                        (SELECT CASE WHEN( (id_j_bos IS NULL) OR (COUNT(id_j_bos)=0)) THEN
                                            (SELECT CASE WHEN( ((id_j_bos IS NULL) OR (COUNT(id_j_bos)=0)) AND id_j_bos > 0) THEN
                                                0
                                          ELSE  id_j_bos END AS id_j_bos
                                          FROM riwayat_mutasi_kerja rmk INNER JOIN
                                          (SELECT riwayat_mutasi_kerja.id_riwayat AS idriwayat
                                          FROM riwayat_mutasi_kerja
                                          INNER JOIN sk
                                           ON sk.id_sk = riwayat_mutasi_kerja.id_sk
                                          WHERE sk.id_pegawai = $id_pegawai and riwayat_mutasi_kerja.id_pegawai = $id_pegawai
                                          AND sk.id_kategori_sk = 18
                                          ORDER BY tmt DESC LIMIT 1) a ON rmk.id_riwayat = a.idriwayat)
                            ELSE  id_j_bos END AS id_j_bos
                            FROM riwayat_mutasi_kerja rmk INNER JOIN
                            (SELECT riwayat_mutasi_kerja.id_riwayat AS idriwayat
                            FROM riwayat_mutasi_kerja
                            INNER JOIN sk
                             ON sk.id_sk = riwayat_mutasi_kerja.id_sk
                            WHERE sk.id_pegawai = $id_pegawai and riwayat_mutasi_kerja.id_pegawai = $id_pegawai
                            AND (sk.id_kategori_sk = 52 OR sk.id_kategori_sk = 23)
                            ORDER BY tmt DESC LIMIT 1) a ON rmk.id_riwayat = a.idriwayat)
                        ELSE  id_j_bos END AS id_j_bos
                        FROM riwayat_mutasi_kerja rmk INNER JOIN
                        (SELECT riwayat_mutasi_kerja.id_riwayat AS idriwayat
                        FROM riwayat_mutasi_kerja
                        INNER JOIN sk
                         ON sk.id_sk = riwayat_mutasi_kerja.id_sk
                        WHERE sk.id_pegawai = $id_pegawai and riwayat_mutasi_kerja.id_pegawai = $id_pegawai
                        AND sk.id_kategori_sk = 55
                        ORDER BY tmt DESC LIMIT 1) a ON rmk.id_riwayat = a.idriwayat)
                    ELSE  id_j_bos END AS id_j_bos
                    FROM riwayat_mutasi_kerja rmk INNER JOIN
                    (SELECT riwayat_mutasi_kerja.id_riwayat AS idriwayat
                    FROM riwayat_mutasi_kerja
                    INNER JOIN sk
                     ON sk.id_sk = riwayat_mutasi_kerja.id_sk
                    WHERE sk.id_pegawai = $id_pegawai and riwayat_mutasi_kerja.id_pegawai = $id_pegawai
                    AND sk.id_kategori_sk = 21
                    ORDER BY tmt DESC LIMIT 1) a ON rmk.id_riwayat = a.idriwayat)
                ELSE  id_j_bos END AS id_j_bos
                FROM riwayat_mutasi_kerja rmk INNER JOIN
                (SELECT riwayat_mutasi_kerja.id_riwayat AS idriwayat
                FROM riwayat_mutasi_kerja
                INNER JOIN sk
                 ON sk.id_sk = riwayat_mutasi_kerja.id_sk
                WHERE sk.id_pegawai = $id_pegawai and riwayat_mutasi_kerja.id_pegawai = $id_pegawai
                AND sk.id_kategori_sk = 12
                ORDER BY tmt DESC LIMIT 1) a ON rmk.id_riwayat = a.idriwayat)
                ELSE  id_j_bos END AS id_j_bos
                FROM riwayat_mutasi_kerja rmk INNER JOIN
                (SELECT riwayat_mutasi_kerja.id_riwayat AS idriwayat
                FROM riwayat_mutasi_kerja
                INNER JOIN sk
                ON sk.id_sk = riwayat_mutasi_kerja.id_sk
                WHERE sk.id_pegawai = $id_pegawai and riwayat_mutasi_kerja.id_pegawai = $id_pegawai
                AND sk.id_kategori_sk = 10
                ORDER BY tmt DESC LIMIT 1) a ON rmk.id_riwayat = a.idriwayat)
                ELSE  id_j_bos END AS id_j_bos
                FROM riwayat_mutasi_kerja rmk INNER JOIN
                (SELECT riwayat_mutasi_kerja.id_riwayat AS idriwayat
                FROM riwayat_mutasi_kerja
                INNER JOIN sk
                ON sk.id_sk = riwayat_mutasi_kerja.id_sk
                WHERE sk.id_pegawai = $id_pegawai and riwayat_mutasi_kerja.id_pegawai = $id_pegawai
                AND sk.id_kategori_sk = 9
                ORDER BY tmt DESC LIMIT 1) a ON rmk.id_riwayat = a.idriwayat)
                ELSE  id_j_bos END AS id_j_bos
                FROM riwayat_mutasi_kerja rmk INNER JOIN
                (SELECT riwayat_mutasi_kerja.id_riwayat AS idriwayat
                FROM riwayat_mutasi_kerja
                INNER JOIN sk
                ON sk.id_sk = riwayat_mutasi_kerja.id_sk
                WHERE sk.id_pegawai = $id_pegawai and riwayat_mutasi_kerja.id_pegawai = $id_pegawai
                AND sk.id_kategori_sk = 7
                ORDER BY tmt DESC LIMIT 1) a ON rmk.id_riwayat = a.idriwayat)
                ELSE  id_j_bos END AS id_j_bos
                FROM riwayat_mutasi_kerja rmk INNER JOIN
                (SELECT riwayat_mutasi_kerja.id_riwayat AS idriwayat
                FROM riwayat_mutasi_kerja
                INNER JOIN sk
                ON sk.id_sk = riwayat_mutasi_kerja.id_sk
                WHERE sk.id_pegawai = $id_pegawai and riwayat_mutasi_kerja.id_pegawai = $id_pegawai
                AND sk.id_kategori_sk = 6
                ORDER BY tmt DESC LIMIT 1) a ON rmk.id_riwayat = a.idriwayat)
                ELSE  id_j_bos END AS id_j_bos
                FROM riwayat_mutasi_kerja rmk INNER JOIN
                (SELECT riwayat_mutasi_kerja.id_riwayat AS idriwayat
                FROM riwayat_mutasi_kerja
                INNER JOIN sk
                ON sk.id_sk = riwayat_mutasi_kerja.id_sk
                WHERE sk.id_pegawai = $id_pegawai and riwayat_mutasi_kerja.id_pegawai = $id_pegawai
                AND sk.id_kategori_sk = 5
                ORDER BY tmt DESC LIMIT 1) a ON rmk.id_riwayat = a.idriwayat)
                ELSE  id_j_bos END AS id_j_bos
                FROM riwayat_mutasi_kerja rmk INNER JOIN
                (SELECT riwayat_mutasi_kerja.id_riwayat AS idriwayat
                FROM riwayat_mutasi_kerja
                INNER JOIN sk
                ON sk.id_sk = riwayat_mutasi_kerja.id_sk
                WHERE sk.id_pegawai = $id_pegawai and riwayat_mutasi_kerja.id_pegawai = $id_pegawai
                AND (sk.id_kategori_sk = 1)
                ORDER BY tmt DESC LIMIT 1) a ON rmk.id_riwayat = a.idriwayat
                )
                ELSE j.id_bos END as id_bos_atsl_ori,
                (SELECT id_bos FROM jabatan WHERE id_j = jplt.idj_plt_ybs) as id_bos_atsl_plt,
                ROUND(DATEDIFF(CURRENT_DATE, DATE_FORMAT(STR_TO_DATE(CONCAT(SUBSTRING(p.nip_baru,9,4),'/',SUBSTRING(p.nip_baru,13,2),'/','01'),
                '%Y/%m/%d'), '%Y-%m-%d'))/365,2) AS masa_kerja, p.alamat, p.is_kepsek, p.is_kapus, jplt.idj_plt_ybs, j2.jabatan as jabatan_plt_ybs, j2.eselon as eselon_plt_ybs
                FROM pegawai p
                LEFT JOIN jabatan j ON p.id_j = j.id_j
                LEFT JOIN (SELECT id_j as idj_plt_ybs, id_pegawai FROM jabatan_plt WHERE id_pegawai = $id_pegawai ORDER BY tmt DESC LIMIT 1) jplt ON p.id_pegawai = jplt.id_pegawai
                LEFT JOIN jabatan j2 ON jplt.idj_plt_ybs = j2.id_j
                WHERE p.id_pegawai = $id_pegawai) a LEFT JOIN
                (SELECT skp.*, p.id_j FROM
                (SELECT sh.id_pegawai, sh.id_skp, sh.periode_awal as tmt, DATE_FORMAT(sh.periode_awal, '%d-%m-%Y') AS periode_awal, sh.id_penilai,
                p.nip_baru, CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
                nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(' ',p.gelar_belakang) END) AS nama, sh.jabatan_penilai,
                sh.gol_penilai, uk.nama_baru as unit_kerja , ss.status, uk.id_unit_kerja, sh.id_atasan_penilai
                FROM skp_header sh, skp_status ss, pegawai p, unit_kerja uk
                WHERE sh.id_skp =
                (SELECT MAX(sh.id_skp) as id_skp
                FROM skp_header sh WHERE sh.periode_awal =
                (SELECT MAX(sh.periode_awal) as tgl_periode FROM skp_header sh
                WHERE sh.id_pegawai = $id_pegawai AND YEAR(sh.periode_awal) = YEAR(NOW())
                AND sh.status_pengajuan IN (1,2,3,4,5,6,7)) AND sh.id_pegawai = $id_pegawai AND YEAR(sh.periode_awal) = YEAR(NOW())
                AND sh.status_pengajuan IN (1,2,3,4,5,6,7)) AND ss.kode_status = sh.status_pengajuan AND
                sh.id_penilai = p.id_pegawai AND sh.id_unit_kerja_pegawai = uk.id_unit_kerja) skp
                LEFT JOIN pegawai p ON skp.id_penilai = p.id_pegawai) skp ON a.id_pegawai = skp.id_pegawai) AS a
                LEFT JOIN jabatan j ON a.id_bos_atsl = j.id_j, current_lokasi_kerja clk, unit_kerja uk
                WHERE a.id_pegawai = clk.id_pegawai AND clk.id_unit_kerja = uk.id_unit_kerja
                ) AS me LEFT JOIN pegawai p ON (me.id_bos_atsl = p.id_j OR p.id_pegawai =
                (SELECT CASE WHEN jplt.id_pegawai IS NULL = 1 THEN 0 ELSE jplt.id_pegawai END AS id_pegawai
                FROM jabatan_plt jplt WHERE jplt.id_j = me.id_bos_atsl LIMIT 1) OR me.id_bos_atsl_plt = p.id_j OR me.id_penilai = p.id_pegawai)
                LEFT JOIN jabatan j ON p.id_j = j.id_j 
                ) AS me_atsl WHERE me_atsl.id_pegawai <> me_atsl.id_pegawai_atsl  
                AND (CASE WHEN me_atsl.jabatan LIKE '%Plt%' THEN
                      (CASE WHEN (me_atsl.jenjab = 'Fungsional' AND me_atsl.unit_kerja_me LIKE '%Dinas Tenaga Kerja%') THEN
                           me_atsl.jabatan_atsl /*NOT*/ LIKE '%Kepala Dinas%' ELSE me_atsl.jabatan_atsl LIKE '%%' END) ELSE
                      (CASE WHEN (me_atsl.jenjab = 'Fungsional' AND me_atsl.unit_kerja_me LIKE '%Dinas Tenaga Kerja%') THEN
                           me_atsl.jabatan_atsl LIKE '%Kepala Dinas%' ELSE me_atsl.jabatan_atsl LIKE '%%' END)
                  END)
                ) AS me_atsl 
                LEFT JOIN cuti_master cm ON cm.id_pegawai = me_atsl.id_pegawai_atsl AND cm.id_status_cuti IN (6,10) AND cm.periode_thn = YEAR(NOW())
                AND (CASE WHEN (STR_TO_DATE(CONCAT(YEAR(NOW()),'-',MONTH(NOW()),'-01'),'%Y-%m-%d') >= cm.tmt_awal) AND (LAST_DAY(CONCAT(YEAR(NOW()),'-',MONTH(NOW()),'-01')) <= cm.tmt_akhir) THEN 1 ELSE 0 END) = 1 
                LEFT JOIN pegawai p ON me_atsl.id_bos_pjbt = p.id_j LEFT JOIN jabatan j ON p.id_j = j.id_j
                ) AS me_atsl_pjbt INNER JOIN current_lokasi_kerja clk ON me_atsl_pjbt.id_pegawai_atsl = clk.id_pegawai LEFT JOIN unit_kerja uk ON clk.id_unit_kerja = uk.id_unit_kerja
                ) AS me_atsl_pjbt_a INNER JOIN current_lokasi_kerja clk ON me_atsl_pjbt_a.id_pegawai_pjbt = clk.id_pegawai LEFT JOIN unit_kerja uk ON clk.id_unit_kerja = uk.id_unit_kerja) data_d
                LEFT JOIN jabatan_plt jp ON data_d.id_bos_atsl = jp.id_j) data_dasar
                LEFT JOIN jabatan_plt jp ON data_dasar.id_bos_pjbt = jp.id_j) data1
                LEFT JOIN jabatan_plh jh ON data1.id_bos_atsl = jh.id_j AND jh.status_aktif = 1) data2
                LEFT JOIN jabatan_plh jh ON data2.id_bos_pjbt = jh.id_j AND jh.status_aktif = 1) data3
                LEFT JOIN pegawai p1 ON data3.idp_plh_atsl = p1.id_pegawai AND p1.flag_pensiun = 0
                LEFT JOIN jabatan j1 ON p1.id_j = j1.id_j
                LEFT JOIN pegawai p2 ON data3.idp_plh_pjbt = p2.id_pegawai AND p2.flag_pensiun = 0
                LEFT JOIN jabatan j2 ON p2.id_j = j2.id_j
                LEFT JOIN unit_kerja opd ON data3.id_skpd_me = opd.id_unit_kerja
                LEFT JOIN jabatan j ON data3.id_skpd_me = j.id_unit_kerja AND j.eselon = 'IIB'
                ORDER BY data3.gol_atsl ASC";
        return $this->db->query($sql);
    }

    public function getKepalaPuskesmas($id_unit_kerja_me){
        $sql = "SELECT p.nip_baru, CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
                nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(' ',p.gelar_belakang) END) AS nama, p.pangkat_gol, p.id_pegawai, p.id_j 
                FROM pegawai p, current_lokasi_kerja clk
                WHERE p.id_pegawai = clk.id_pegawai AND clk.id_unit_kerja = ".$id_unit_kerja_me." AND p.is_kapus = true AND p.flag_pensiun = 0";
        return $this->db->query($sql);
    }

    public function getKepalaSekolah($id_unit_kerja_me){
        $sql = "SELECT p.nip_baru, CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
                nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(' ',p.gelar_belakang) END) AS nama, p.pangkat_gol, p.id_j, p.id_pegawai, p.id_j  
                FROM pegawai p, current_lokasi_kerja clk
                WHERE p.id_pegawai = clk.id_pegawai AND clk.id_unit_kerja = ".$id_unit_kerja_me." AND p.is_kepsek = true AND p.flag_pensiun = 0";
        return $this->db->query($sql);
    }

    public function getPejabatBidangDisdik($unit_kerja_me){
        $sql = "SELECT c.nip_baru, c.nama, c.pangkat_gol, j.jabatan, j.id_j, c.id_pegawai FROM 
                (SELECT p.nip_baru, CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
                nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(' ',p.gelar_belakang) END) AS nama, p.pangkat_gol, p.id_j, p.id_pegawai 
                FROM pegawai p INNER JOIN
                (SELECT CASE WHEN (LOWER(a.sekolah) LIKE 'tk%' OR  LOWER(a.sekolah) LIKE 'sdn%') THEN
                  (SELECT j.id_j FROM jabatan j WHERE j.jabatan LIKE '%Kepala Bidang Sekolah Dasar%'
                  AND j.Tahun = (SELECT MAX(Tahun) FROM jabatan))
                ELSE (CASE WHEN (LOWER(a.sekolah) LIKE 'sman%' OR LOWER(a.sekolah) LIKE 'smkn%' OR LOWER(a.sekolah) LIKE 'smpn%') THEN
                  (SELECT j.id_j FROM jabatan j WHERE j.jabatan LIKE '%Kepala Bidang Sekolah Menengah%'
                  AND j.Tahun = (SELECT MAX(Tahun) FROM jabatan))
                ELSE 0 END) END as id_j FROM
                (SELECT '".$unit_kerja_me."' AS sekolah) a) b ON p.id_j = b.id_j) c, jabatan j
                WHERE c.id_j = j.id_j";
        return $this->db->query($sql);
    }

    public function getKasubagUmumKepegDinas($id_skpd){
        $sql = "SELECT p.nip_baru, CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
                nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(' ',p.gelar_belakang) END) AS nama, g.golongan, j.jabatan, p.id_j, p.id_pegawai 
                FROM pegawai p, golongan g, jabatan j
                WHERE  p.pangkat_gol = g.golongan AND p.id_j = (SELECT id_j FROM jabatan WHERE tahun =
                (SELECT max(tahun) FROM jabatan) and jabatan LIKE '%Kasubag Umum dan Kepegawaian%' and id_unit_kerja = $id_skpd) AND p.id_j = j.id_j";
        return $this->db->query($sql);
    }

    public function getSekretarisDinas($id_skpd){
        $sql = "SELECT p.nip_baru, CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
                nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(' ',p.gelar_belakang) END) AS nama, g.golongan, j.jabatan, p.id_j, p.id_pegawai 
                FROM pegawai p, golongan g, jabatan j
                WHERE  p.pangkat_gol = g.golongan AND p.id_j = (SELECT id_j FROM jabatan WHERE tahun =
                (SELECT max(tahun) FROM jabatan) and jabatan LIKE '%Sekretaris%' and id_unit_kerja = $id_skpd) AND p.id_j = j.id_j";
        return $this->db->query($sql);
    }

    public function getNamaPejabatEselon($id_j){
        $sql = "SELECT p.nip_baru, CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
            nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(' ',p.gelar_belakang) END) AS nama, g.golongan, p.id_pegawai 
            FROM pegawai p, golongan g
            WHERE  p.pangkat_gol = g.golongan AND p.id_j = $id_j";
        return $this->db->query($sql);
    }

    public function getNamaSekda(){
        $sql = "SELECT p.nip_baru, CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
                nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(' ',p.gelar_belakang) END) AS nama, g.golongan, j.jabatan, j.id_j, p.id_pegawai 
                FROM pegawai p, golongan g, jabatan j
                WHERE  p.pangkat_gol = g.golongan AND p.id_j = (SELECT id_j FROM jabatan WHERE tahun =
                (SELECT max(tahun) FROM jabatan) and jabatan LIKE '%Sekretaris Daerah%') AND p.id_j = j.id_j";
        return $this->db->query($sql);
    }

    public function getPltAtasanLangsung($idp){
        $sql = "SELECT p.nip_baru, CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
                nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(' ',p.gelar_belakang) END) AS nama, g.golongan, j.jabatan, j.id_j, p.id_pegawai
                FROM pegawai p, golongan g, jabatan_plt jp, jabatan j
                WHERE p.id_pegawai = ".$idp." AND p.pangkat_gol = g.golongan AND p.id_pegawai = jp.id_pegawai AND jp.id_j = j.id_j";
        return $this->db->query($sql);
    }

    public function getPltPejabatBerwenang($idp){
        $sql = "SELECT p.nip_baru, CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
            nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(' ',p.gelar_belakang) END) AS nama,
            g.golongan, j.jabatan, j.id_j, p.id_pegawai, uk.id_skpd
            FROM pegawai p LEFT JOIN golongan g ON p.pangkat_gol = g.golongan
            LEFT JOIN jabatan_plt jp ON p.id_pegawai = jp.id_pegawai
            LEFT JOIN jabatan j ON jp.id_j = j.id_j
            LEFT JOIN current_lokasi_kerja clk ON p.id_pegawai = clk.id_pegawai
            LEFT JOIN unit_kerja uk ON clk.id_unit_kerja = uk.id_unit_kerja
            WHERE p.id_pegawai = ".$idp;
        return $this->db->query($sql);
    }

    public function getPegawaiEselon3A($id_skpd){
        $sql = "SELECT p.nip_baru, CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
                nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(' ',p.gelar_belakang) END) AS nama,
                p.pangkat_gol, j.jabatan, j.id_j, p.id_pegawai
                FROM pegawai p, jabatan j
                WHERE p.id_j = j.id_j AND p.id_j =
                (SELECT id_j FROM jabatan WHERE id_unit_kerja = $id_skpd AND eselon = 'IIIA')";
        return $this->db->query($sql);
    }

    public function insertKinerjaMaster($data){
        $periode_thn = $data['ddThn'];
        $periode_bln = $data['ddBln'];
        $id_pegawai = $data['id_pegawai'];
        $this->db->trans_begin();
        $last_jenjab = "'".$data['last_jenjab']."'";
        $last_kode_jabatan = $data['last_kode_jabatan'];
        $last_jabatan = "'".$data['last_jabatan']."'";
        $last_eselon = "'".$data['last_eselon']."'";
        $last_gol = "'".$data['last_gol']."'";
        $last_id_unit_kerja = $data['last_id_unit_kerja'];
        $last_unit_kerja = "'".$data['last_unit_kerja']."'";
        $last_atsl_idp = $data['last_atsl_idp'];
        $last_atsl_nip = "'".$data['last_atsl_nip']."'";
        $last_atsl_nama = "'".$data['last_atsl_nama']."'";
        $last_atsl_gol = "'".$data['last_atsl_gol']."'";
        $last_atsl_jabatan = "'".$data['last_atsl_jabatan']."'";
        $last_atsl_id_j = $data['last_atsl_id_j'];
        $last_pjbt_idp = $data['last_pjbt_idp'];
        $last_pjbt_nip = "'".$data['last_pjbt_nip']."'";
        $last_pjbt_nama = "'".$data['last_pjbt_nama']."'";
        $last_pjbt_gol = "'".$data['last_pjbt_gol']."'";
        $last_pjbt_jabatan = "'".$data['last_pjbt_jabatan']."'";
        $last_pjbt_id_j = $data['last_pjbt_id_j'];
        $id_skp = $data['id_skp'];
        $tmt_skp = $data['tmt_skp'];
        $persen_total_tpp = 100;
        $rupiah_tpp = 0;
        $last_status_pegawai = "'".$data['last_status_pegawai']."'";

        $last_atsl_idp_plh = ($data['last_atsl_idp_plh']==''?'NULL':$data['last_atsl_idp_plh']);
        $last_atsl_nip_plh = "'".$data['last_atsl_nip_plh']."'";
        $last_atsl_nama_plh = "'".$data['last_atsl_nama_plh']."'";
        $last_atsl_gol_plh = "'".$data['last_atsl_gol_plh']."'";
        $last_atsl_jabatan_plh = "'".$data['last_atsl_jabatan_plh']."'";
        $last_atsl_id_j_plh = ($data['last_atsl_id_j_plh']==''?'NULL':$data['last_atsl_id_j_plh']);
        $last_pjbt_idp_plh = ($data['last_pjbt_idp_plh']==''?'NULL':$data['last_pjbt_idp_plh']);
        $last_pjbt_nip_plh = "'".$data['last_pjbt_nip_plh']."'";
        $last_pjbt_nama_plh = "'".$data['last_pjbt_nama_plh']."'";
        $last_pjbt_gol_plh = "'".$data['last_pjbt_gol_plh']."'";
        $last_pjbt_jabatan_plh = "'".$data['last_pjbt_jabatan_plh']."'";
        $last_pjbt_id_j_plh = ($data['last_pjbt_id_j_plh']==''?'NULL':$data['last_pjbt_id_j_plh']);

        $data_kegiatan = array(
            'ddKatKegiatan' => $data['ddKatKegiatan'],
            'tglKegiatan' => $data['tglKegiatan'],
            'jamKegiatan' => $data['jamKegiatan'],
            'txtRincian' => $data['txtRincian'],
            'txtKet' => $data['txtKet'],
            'txtKuantitas' => $data['txtKuantitas'],
            'ddSatuan' => $data['ddSatuan'],
            'txtDurasi' => $data['txtDurasi'],
            'atsl_idp' => $data['last_atsl_idp'],
            'atsl_nip' => $data['last_atsl_nip'],
            'atsl_nama' => $data['last_atsl_nama'],
            'atsl_gol' => $data['last_atsl_gol'],
            'atsl_jabatan' => $data['last_atsl_jabatan'],
            'atsl_id_j' => $data['last_atsl_id_j'],
            'pjbt_idp' => $data['last_pjbt_idp'],
            'pjbt_nip' => $data['last_pjbt_nip'],
            'pjbt_nama' => $data['last_pjbt_nama'],
            'pjbt_gol' => $data['last_pjbt_gol'],
            'pjbt_jabatan' => $data['last_pjbt_jabatan'],
            'pjbt_id_j' => $data['last_pjbt_id_j'],

        );

        $jmlHukumanAktual = $this->ref_get_data_hukuman_aktual_by_idpegawai($id_pegawai);
        if (isset($jmlHukumanAktual)){
            if($jmlHukumanAktual==0){
                $persen_minus_tpp_hukdis = 0;
            }else{
                $persen_minus_tpp_hukdis = $this->ref_get_persen_knj_jenis_item_lainnya(13);
            }
        }else{
            $persen_minus_tpp_hukdis = 0;
        }

        $jmlTgsBelajarAktual = $this->ref_get_data_status_aktif_belajar($id_pegawai);
        if (isset($jmlTgsBelajarAktual)){
            if($jmlTgsBelajarAktual==0){
                $persen_minus_tpp_tubel = 0;
            }else{
                $persen_minus_tpp_tubel = $this->ref_get_persen_knj_jenis_item_lainnya(14);
            }
        }else{
            $persen_minus_tpp_tubel = 0;
        }
        $persen_tpp_akhir = ($persen_total_tpp-$persen_minus_tpp_hukdis-$persen_minus_tpp_tubel);
        $rupiah_tpp_akhir = 0;

        $attrJabatan = $this->ref_get_kelas_jabatan($last_jenjab,$last_kode_jabatan,$last_eselon);
        if (isset($attrJabatan)){
            $rowcount = $attrJabatan->num_rows();
            if($rowcount>0){
                foreach ($attrJabatan->result() as $data) {
                    $kelas_jabatan = $data->kelas_jabatan;
                    $nilai_jabatan = $data->nilai_jabatan;
                }
            }else{
                $kelas_jabatan = 0;
                $nilai_jabatan = 0;
            }
        }else{
            $kelas_jabatan = 0;
            $nilai_jabatan = 0;
        }
        //echo "$kelas_jabatan, $nilai_jabatan";
        $nilai_rp_tkd = $this->ref_get_nilai_rupiah_tkd();
        if (isset($nilai_rp_tkd)){
            $rowcount = $nilai_rp_tkd->num_rows();
            if($rowcount>0){
                foreach ($nilai_rp_tkd->result() as $data) {
                    $nilai_rupiah_tkd = $data->nilai;
                }
            }else{
                $nilai_rupiah_tkd = 0;
            }
        }else{
            $nilai_rupiah_tkd = 0;
        }

        if($last_status_pegawai == "'PNS'") {
            $rupiah_awal_tkd = ($nilai_jabatan * $nilai_rupiah_tkd);
        }else{
            $rupiah_awal_tkd = ($nilai_jabatan * $nilai_rupiah_tkd)*0.8;
        }

        if(strpos($last_unit_kerja, 'Badan Pendapatan Daerah') !== false
            or strpos($last_unit_kerja, 'Puskesmas') !== false
            or strpos($last_jabatan, 'Guru') !== false) {
            $nilai_jabatan = 0;
            $rupiah_awal_tkd = 0;
        }

        $efektif_hari_kerja = $this->ref_get_jml_menit_efektif_kerja($id_pegawai, $periode_bln, $periode_thn);
        if (isset($efektif_hari_kerja)){
            $rowcount = $efektif_hari_kerja->num_rows();
            if($rowcount>0){
                foreach ($efektif_hari_kerja->result() as $data) {
                    $jml_menit_efektif_kerja = $data->jml_menit_efektif_kerja;
                    $jml_hari_kerja_efektif = $data->jml_hari_kerja_efektif;
                }
            }else{
                $jml_menit_efektif_kerja = 0;
                $jml_hari_kerja_efektif = 0;
            }
        }else{
            $jml_menit_efektif_kerja = 0;
            $jml_hari_kerja_efektif = 0;
        }

        $jml_waktu_kinerja_accu = 0;
        $persen_kinerja_accu = 0;
        $rupiah_kinerja = 0;
        $jml_waktu_kinerja_accu_bawahan = 0;
        $persen_kinerja_accu_bawahan = 0;
        $persen_kinerja_aktual = 0;
        $rupiah_kinerja_aktual = 0;

        $jml_kehadiran_accu = 0;
        $persen_kehadiran_accu = 0;
        $jml_tidak_hadir_accu = 0;
        $persen_minus_tidak_hadir_accu = 0;
        $persen_minus_terlambat_plg_cpt_accu = 0;

        $efektif_hari_apel = $this->ref_get_tgl_apel_current($id_pegawai, $periode_bln, $periode_thn);
        if (isset($efektif_hari_apel)){
            $rowcount = $efektif_hari_apel->num_rows();
            if($rowcount>0){
                if($rowcount==1){
                    foreach ($efektif_hari_apel->result() as $data) {
                        if($data->tgl_apel == ''){
                            $jml_hari_efektif_apel = 0;
                        }else{
                            $jml_hari_efektif_apel = 1;
                        }
                    }
                }else{
                    $jml_hari_efektif_apel = $rowcount;
                }
            }else{
                $jml_hari_efektif_apel = 0;
            }
        }else{
            $jml_hari_efektif_apel = 0;
        }

        $jml_tidak_apel_accu = 0;
        $persen_minus_tidak_apel_accu = 0;

        $item_lainnya = $this->ref_get_persen_item_lainnya($id_pegawai, $periode_bln, $periode_thn);

        if (isset($item_lainnya)){
            $jumlah_penambahan_item_lain = 0;
            $persen_penambahan_item_lain = 0;
            $jumlah_pengurangan_item_lain = 0;
            $persen_pengurangan_item_lain = 0;
            $rowcount = $item_lainnya->num_rows();
            if($rowcount>0){
                foreach ($item_lainnya->result() as $data) {
                    if($data->kategori_item == 'Penambahan'){
                        $jumlah_penambahan_item_lain = $data->jumlah_item;
                        $persen_penambahan_item_lain = $data->jumlah_persen;

                    }
                    if($data->kategori_item == 'Pengurangan'){
                        $jumlah_pengurangan_item_lain = $data->jumlah_item;
                        $persen_pengurangan_item_lain = $data->jumlah_persen;
                    }
                }
            }else{
                $jumlah_penambahan_item_lain = 0;
                $persen_penambahan_item_lain = 0;
                $jumlah_pengurangan_item_lain = 0;
                $persen_pengurangan_item_lain = 0;
            }
        }else{
            $jumlah_penambahan_item_lain = 0;
            $persen_penambahan_item_lain = 0;
            $jumlah_pengurangan_item_lain = 0;
            $persen_pengurangan_item_lain = 0;
        }

        $persen_kinerja_final = 0;
        $rupiah_kinerja_final = 0;

        $sql = "INSERT INTO knj_kinerja_master(periode_thn,periode_bln,id_pegawai_pelapor,last_jenjab,last_kode_jabatan,last_jabatan,last_eselon,last_gol,
                last_id_unit_kerja,last_unit_kerja,last_atsl_idp,last_atsl_nip,last_atsl_nama,last_atsl_gol,last_atsl_jabatan,
                last_atsl_id_j,last_pjbt_idp,last_pjbt_nip,last_pjbt_nama,last_pjbt_gol,last_pjbt_jabatan,last_pjbt_id_j,persen_total_tpp,
                rupiah_tpp,persen_minus_tpp_hukdis,persen_minus_tpp_tubel,persen_tpp_akhir,rupiah_tpp_akhir, jml_menit_efektif_kerja,jml_waktu_kinerja_accu,
                persen_kinerja_accu,rupiah_kinerja,jml_waktu_kinerja_accu_bawahan,persen_kinerja_accu_bawahan,persen_kinerja_aktual,rupiah_kinerja_aktual,
                jml_hari_efektif_kerja,jml_kehadiran_accu,persen_kehadiran_accu,jml_tidak_hadir_accu,persen_minus_tidak_hadir_accu,persen_minus_terlambat_plg_cpt_accu,
                jml_hari_efektif_apel,jml_tidak_apel_accu,persen_minus_tidak_apel_accu,jumlah_penambahan_item_lain,persen_penambahan_item_lain,
                jumlah_pengurangan_item_lain,persen_pengurangan_item_lain,persen_kinerja_final,rupiah_kinerja_final,id_status_knj,status_pegawai,
                last_atsl_idp_plh, last_atsl_nip_plh, last_atsl_nama_plh, last_atsl_gol_plh, last_atsl_jabatan_plh, last_atsl_id_j_plh, 
                last_pjbt_idp_plh, last_pjbt_nip_plh, last_pjbt_nama_plh, last_pjbt_gol_plh, last_pjbt_jabatan_plh, last_pjbt_id_j_plh)
                VALUES ($periode_thn,$periode_bln,$id_pegawai,$last_jenjab,$last_kode_jabatan,$last_jabatan,$last_eselon,$last_gol,$last_id_unit_kerja,
                $last_unit_kerja,$last_atsl_idp,$last_atsl_nip,$last_atsl_nama,$last_atsl_gol,$last_atsl_jabatan,$last_atsl_id_j,$last_pjbt_idp,
                $last_pjbt_nip,$last_pjbt_nama,$last_pjbt_gol,$last_pjbt_jabatan,$last_pjbt_id_j,$persen_total_tpp,$rupiah_tpp,$persen_minus_tpp_hukdis,
                $persen_minus_tpp_tubel,$persen_tpp_akhir,$rupiah_tpp_akhir, 
                $jml_menit_efektif_kerja,$jml_waktu_kinerja_accu,$persen_kinerja_accu,$rupiah_kinerja,$jml_waktu_kinerja_accu_bawahan,
                $persen_kinerja_accu_bawahan,$persen_kinerja_aktual,$rupiah_kinerja_aktual,$jml_hari_kerja_efektif,$jml_kehadiran_accu,$persen_kehadiran_accu,
                $jml_tidak_hadir_accu,$persen_minus_tidak_hadir_accu,$persen_minus_terlambat_plg_cpt_accu,$jml_hari_efektif_apel,$jml_tidak_apel_accu,
                $persen_minus_tidak_apel_accu,$jumlah_penambahan_item_lain,$persen_penambahan_item_lain,$jumlah_pengurangan_item_lain,$persen_pengurangan_item_lain,
                $persen_kinerja_final,$rupiah_kinerja_final,2,$last_status_pegawai,
                $last_atsl_idp_plh, $last_atsl_nip_plh, $last_atsl_nama_plh, $last_atsl_gol_plh, $last_atsl_jabatan_plh, $last_atsl_id_j_plh, 
                $last_pjbt_idp_plh, $last_pjbt_nip_plh, $last_pjbt_nama_plh, $last_pjbt_gol_plh, $last_pjbt_jabatan_plh, $last_pjbt_id_j_plh)";

        $this->db->query($sql);
        if ($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            return array(
                'query' => 0,
                'id_knj_kegiatan' => ''
            );
        }else{
            $id_knj = $this->db->insert_id();
            $data_atasan = array(
                'last_id_unit_kerja' => $last_id_unit_kerja,
                'last_unit_kerja' => $last_unit_kerja,
                'jenjab' => $last_jenjab,
                'kode_jabatan' => $last_kode_jabatan,
                'jabatan' => $last_jabatan,
                'eselon' => $last_eselon,
                'kelas_jabatan' => $kelas_jabatan,
                'nilai_jabatan' => $nilai_jabatan,
                'nilai_rupiah_tkd' => $nilai_rupiah_tkd,
                'rupiah_awal_tkd' => $rupiah_awal_tkd,
                'last_atsl_idp' => $last_atsl_idp,
                'last_atsl_nip' => $last_atsl_nip,
                'last_atsl_nama' => $last_atsl_nama,
                'last_atsl_gol' => $last_atsl_gol,
                'last_atsl_jabatan' => $last_atsl_jabatan,
                'last_atsl_id_j' => $last_atsl_id_j,
                'last_pjbt_idp' => $last_pjbt_idp,
                'last_pjbt_nip' => $last_pjbt_nip,
                'last_pjbt_nama' => $last_pjbt_nama,
                'last_pjbt_gol' => $last_pjbt_gol,
                'last_pjbt_jabatan' => $last_pjbt_jabatan,
                'last_pjbt_id_j' => $last_pjbt_id_j,
                'id_skp' => $id_skp,
                'tmt_skp' => $tmt_skp,
                'jml_menit_efektif_kerja' => $jml_menit_efektif_kerja,
                'jml_hari_kerja_efektif' => $jml_hari_kerja_efektif,

                'last_atsl_idp_plh' => $last_atsl_idp_plh,
                'last_atsl_nip_plh' => $last_atsl_nip_plh,
                'last_atsl_nama_plh' => $last_atsl_nama_plh,
                'last_atsl_gol_plh' => $last_atsl_gol_plh,
                'last_atsl_jabatan_plh' => $last_atsl_jabatan_plh,
                'last_atsl_id_j_plh' => $last_atsl_id_j_plh,
                'last_pjbt_idp_plh' => $last_pjbt_idp_plh,
                'last_pjbt_nip_plh' => $last_pjbt_nip_plh,
                'last_pjbt_nama_plh' => $last_pjbt_nama_plh,
                'last_pjbt_gol_plh' => $last_pjbt_gol_plh,
                'last_pjbt_jabatan_plh' => $last_pjbt_jabatan_plh,
                'last_pjbt_id_j_plh' => $last_pjbt_id_j_plh
            );

            $query = $this->insert_kinerja_historis_alih_tugas($data_atasan, $id_knj, $data_kegiatan['tglKegiatan']);
            if ($query['query'] > 0) {
                $query = $this->insertKinerjaKegiatan($data_kegiatan, $query['idknj_hist_alih_tugas']);
                if ($query['query'] > 0) {
                    $this->db->trans_commit();
                    return array(
                        'query' => 1,
                        'id_knj_kegiatan' => $query['id_knj_kegiatan']
                    );
                }else{
                    $this->db->trans_rollback();
                    return array(
                        'query' => 0,
                        'id_knj_kegiatan' => ''
                    );
                }
            }else{
                $this->db->trans_rollback();
                return array(
                    'query' => 0,
                    'id_knj_kegiatan' => ''
                );
            }
        }
    }

    public function insertKinerjaKegiatan($data, $idknj_hist_alih_tugas){
        $ddKatKegiatan = $data['ddKatKegiatan'];
        $tglKegiatan = "'".$data['tglKegiatan'].' '.$data['jamKegiatan']."'";
        $txtRincian = "'".$data['txtRincian']."'";
        $txtKet = "'".$data['txtKet']."'";
        $txtKuantitas = $data['txtKuantitas'];
        $ddSatuan = "'".$data['ddSatuan']."'";
        $txtDurasi = "'".$data['txtDurasi']."'";

        $this->db->trans_begin();
        $sql = "INSERT INTO knj_kinerja_kegiatan(kegiatan_kategori_id, kegiatan_tanggal, kegiatan_rincian, 
                kegiatan_keterangan, idknj_hist_alih_tugas, durasi_menit, kuantitas, satuan, tgl_input, tgl_update) 
                VALUES ($ddKatKegiatan, $tglKegiatan, $txtRincian, $txtKet, $idknj_hist_alih_tugas, $txtDurasi, $txtKuantitas, $ddSatuan, NOW(), NOW())";

        $this->db->query($sql);
        if ($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            return array(
                'query' => 0,
                'id_knj_kegiatan' => ''
            );
        }else{
            $id_knj_kegiatan = $this->db->insert_id();
            $this->db->trans_commit();
            return array(
                'query' => 1,
                'id_knj_kegiatan' => $id_knj_kegiatan
            );
        }
    }

    public function updateKinerjaKegiatan($data, $idknj_hist_alih_tugas){
        $ddKatKegiatan = $data['ddKatKegiatan'];
        $tglKegiatan = "'".$data['tglKegiatan'].' '.$data['jamKegiatan']."'";
        $txtRincian = "'".$data['txtRincian']."'";
        $txtKet = "'".$data['txtKet']."'";
        $txtKuantitas = $data['txtKuantitas'];
        $ddSatuan = "'".$data['ddSatuan']."'";
        $txtDurasi = "'".$data['txtDurasi']."'";

        if(isset($data['chkUbahWktKegiatan'])){
            if($data['chkUbahWktKegiatan'] == 1){
                $sql = "UPDATE knj_kinerja_kegiatan SET kegiatan_kategori_id = $ddKatKegiatan, kegiatan_tanggal = $tglKegiatan, kegiatan_rincian = $txtRincian,
                kegiatan_keterangan = $txtKet, idknj_hist_alih_tugas = $idknj_hist_alih_tugas, durasi_menit = $txtDurasi, 
                kuantitas = $txtKuantitas, satuan = $ddSatuan, tgl_update = NOW()
                WHERE id_knj_kegiatan = ".$data['id_knj_kegiatan'];
            }else{
                $sql = "UPDATE knj_kinerja_kegiatan SET kegiatan_kategori_id = $ddKatKegiatan, kegiatan_rincian = $txtRincian,
                kegiatan_keterangan = $txtKet, idknj_hist_alih_tugas = $idknj_hist_alih_tugas, durasi_menit = $txtDurasi, 
                kuantitas = $txtKuantitas, satuan = $ddSatuan, tgl_update = NOW()
                WHERE id_knj_kegiatan = ".$data['id_knj_kegiatan'];
            }
        }else{
            $sql = "UPDATE knj_kinerja_kegiatan SET kegiatan_kategori_id = $ddKatKegiatan, kegiatan_tanggal = $tglKegiatan, kegiatan_rincian = $txtRincian,
                kegiatan_keterangan = $txtKet, idknj_hist_alih_tugas = $idknj_hist_alih_tugas, durasi_menit = $txtDurasi, 
                kuantitas = $txtKuantitas, satuan = $ddSatuan, tgl_update = NOW()
                WHERE id_knj_kegiatan = ".$data['id_knj_kegiatan'];
        }
        $this->db->trans_begin();
        $this->db->query($sql);
        if ($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            return array(
                'query' => 0,
                'id_knj_kegiatan' => '',
                'sql' => $sql
            );
        }else{
            $this->db->trans_commit();
            return array(
                'query' => 1,
                'id_knj_kegiatan' => $data['id_knj_kegiatan'],
                'sql' => $sql
            );
        }
    }

    function update_last_atsl_kinerja_master($data, $id_knj_m){
        //print_r($data);
        $this->db->trans_begin();
        $sql = "UPDATE knj_kinerja_master 
                SET last_atsl_idp = ".$data['last_atsl_idp'].','."last_atsl_nip = ".$data['last_atsl_nip'].','.
            "last_atsl_nama = ".$data['last_atsl_nama'].','."last_atsl_gol = ".$data['last_atsl_gol'].','.
            "last_atsl_jabatan = ".$data['last_atsl_jabatan'].','."last_atsl_id_j = ".$data['last_atsl_id_j'].','.
            "last_pjbt_idp = ".$data['last_pjbt_idp'].','."last_pjbt_nip = ".$data['last_pjbt_nip'].','.
            "last_pjbt_nama = ".$data['last_pjbt_nama'].','."last_pjbt_gol = ".$data['last_pjbt_gol'].','.
            "last_pjbt_jabatan = ".$data['last_pjbt_jabatan'].','."last_pjbt_id_j = ".$data['last_pjbt_id_j'].','.
            "last_jenjab = ".$data['jenjab'].','."last_kode_jabatan = ".$data['kode_jabatan'].','.
            "last_jabatan = ".$data['jabatan'].','."last_eselon = ".$data['eselon'].','.
            "last_id_unit_kerja = ".$data['last_id_unit_kerja'].','."last_unit_kerja = ".$data['last_unit_kerja'].','.

            "last_atsl_idp_plh = "."'".$data['last_atsl_idp_plh']."'".','."last_atsl_nip_plh = ".$data['last_atsl_nip_plh'].','.
            "last_atsl_nama_plh = ".$data['last_atsl_nama_plh'].','."last_atsl_gol_plh = ".$data['last_atsl_gol_plh'].','.
            "last_atsl_jabatan_plh = ".$data['last_atsl_jabatan_plh'].','."last_atsl_id_j_plh = "."'".$data['last_atsl_id_j_plh']."'".','.
            "last_pjbt_idp_plh = "."'".$data['last_pjbt_idp_plh']."'".','."last_pjbt_nip_plh = ".$data['last_pjbt_nip_plh'].','.
            "last_pjbt_nama_plh = ".$data['last_pjbt_nama_plh'].','."last_pjbt_gol_plh = ".$data['last_pjbt_gol_plh'].','.
            "last_pjbt_jabatan_plh = ".$data['last_pjbt_jabatan_plh'].','."last_pjbt_id_j_plh = "."'".$data['last_pjbt_id_j_plh']."'".','.

            "tgl_update_kinerja = NOW()".
            " WHERE id_knj_master = ".$id_knj_m;

        $this->db->query($sql);
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return 0;
        }else{
            $this->db->trans_commit();
            return 1;
        }
        //return $sql;
    }

    function insert_kinerja_historis_alih_tugas($data, $id_knj_m, $tglKegiatan){
        $id_skp = $data['id_skp'];
        $tmt_skp = "'".$data['tmt_skp']."'";
        $flagUpdate = $this->get_tgl_kinerja_last_atasan($id_knj_m, $tglKegiatan);

        $sql = "INSERT INTO knj_kinerja_historis_alih_tugas(id_unit_kerja, unit_kerja,
                jenjab, kode_jabatan, jabatan, eselon, kelas_jabatan, nilai_jabatan, nilai_rupiah_tkd, rupiah_awal_tkd,
                atsl_idp, atsl_nip, atsl_nama, atsl_gol, atsl_jabatan, atsl_id_j, 
                pjbt_nip, pjbt_idp, pjbt_nama, pjbt_gol, pjbt_jabatan, pjbt_id_j, id_knj_master, tmt, id_skp, jml_menit_efektif_kerja, jml_hari_efektif_kerja,
                atsl_idp_plh, atsl_nip_plh, atsl_nama_plh, atsl_gol_plh, atsl_jabatan_plh, atsl_id_j_plh,
                pjbt_idp_plh, pjbt_nip_plh, pjbt_nama_plh, pjbt_gol_plh, pjbt_jabatan_plh, pjbt_id_j_plh) 
                VALUES (".$data['last_id_unit_kerja'].','.$data['last_unit_kerja'].','.
            $data['jenjab'].','.$data['kode_jabatan'].','.
            $data['jabatan'].','.$data['eselon'].','.
            $data['kelas_jabatan'].','.$data['nilai_jabatan'].','.
            $data['nilai_rupiah_tkd'].','.$data['rupiah_awal_tkd'].','.
            $data['last_atsl_idp'].','.$data['last_atsl_nip'].','.
            $data['last_atsl_nama'].','.$data['last_atsl_gol'].','.
            $data['last_atsl_jabatan'].','.$data['last_atsl_id_j'].','.
            $data['last_pjbt_nip'].','.$data['last_pjbt_idp'].','.
            $data['last_pjbt_nama'].','.$data['last_pjbt_gol'].','.
            $data['last_pjbt_jabatan'].','.$data['last_pjbt_id_j'].','.
            $id_knj_m.','.$tmt_skp.','.$id_skp.",".$data['jml_menit_efektif_kerja'].",".$data['jml_hari_kerja_efektif'].",'".
            $data['last_atsl_idp_plh']."'".','.$data['last_atsl_nip_plh'].','.
            $data['last_atsl_nama_plh'].','.$data['last_atsl_gol_plh'].','.
            $data['last_atsl_jabatan_plh'].','."'".$data['last_atsl_id_j_plh']."'".','.
            $data['last_pjbt_nip_plh'].','."'".$data['last_pjbt_idp_plh']."'".','.
            $data['last_pjbt_nama_plh'].','.$data['last_pjbt_gol_plh'].','.
            $data['last_pjbt_jabatan_plh'].','."'".$data['last_pjbt_id_j_plh']."')";

        $this->db->query($sql);
        if ($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            return array(
                'query' => 0,
                'idknj_hist_alih_tugas' => ''
            );
        }else{
            $idknj_hist_alih_tugas = $this->db->insert_id();
            $this->db->trans_commit();
            if($flagUpdate==1){
                $this->update_last_atsl_kinerja_master($data,$id_knj_m);
            }
            return array(
                'query' => 1,
                'idknj_hist_alih_tugas' => $idknj_hist_alih_tugas
            );
        }
    }

    function cek_knj_kinerja_historis_alih_tugas($id_knj, $last_atsl_idp, $last_pjbt_idp, $last_atsl_idp_plh){
        $sql = "SELECT * 
                FROM knj_kinerja_historis_alih_tugas kat
                WHERE kat.id_knj_master = $id_knj AND kat.atsl_idp = $last_atsl_idp
                AND kat.pjbt_idp = $last_pjbt_idp";
        $isexist = $this->db->query($sql);
        $rowcount = $isexist->num_rows();
        if($rowcount>0){
            if($last_atsl_idp_plh==''){
                $last_atsl_idp_plh = 0;
            }
            foreach ($isexist->result() as $data) {
                $idknj_hist_alih_tugas = $data->idknj_hist_alih_tugas;
                $atsl_idp_plh_cur = $data->atsl_idp_plh;
                if($atsl_idp_plh_cur==$last_atsl_idp_plh){
                    $idknj_hist_alih_tugas = $idknj_hist_alih_tugas;
                    break;
                }else{
                    $idknj_hist_alih_tugas = 0;
                }
            }
        }else{
            $idknj_hist_alih_tugas = 0;
        }
        return $idknj_hist_alih_tugas;
    }

    function get_tgl_kinerja_last_atasan($id_knj, $tgl_kegiatan){
        $sql = "SELECT kat.tgl_input as last_tgl_input_atasan,
                STR_TO_DATE(".$tgl_kegiatan.",'%Y-%m-%d %H:%i:%s') as tgl_kegiatan,
                IF(kat.tgl_input <= STR_TO_DATE(".$tgl_kegiatan.",'%Y-%m-%d %H:%i:%s'),1,0) as flag_update
                FROM knj_kinerja_historis_alih_tugas kat
                WHERE kat.id_knj_master = $id_knj
                ORDER BY kat.tgl_input DESC LIMIT 1";
        $isexist = $this->db->query($sql);
        $rowcount = $isexist->num_rows();
        if($rowcount>0){
            foreach ($isexist->result() as $data) {
                $flag_update = $data->flag_update;
            }
        }else{
            $flag_update = "";
        }
        return $flag_update;
    }

    function getJmlHistAlihTugas($idpegawai){
        $sql = "SELECT COUNT(*) as jumlah FROM
                (SELECT kkh.idknj_hist_alih_tugas
                FROM knj_kinerja_historis_alih_tugas kkh
                LEFT JOIN knj_kinerja_kegiatan kkk ON kkh.idknj_hist_alih_tugas = kkk.idknj_hist_alih_tugas
                WHERE kkh.id_knj_master IN (SELECT kkm.id_knj_master FROM knj_kinerja_master kkm
                WHERE ((kkm.periode_bln = MONTH(NOW()) AND kkm.periode_thn = YEAR(NOW())) /*OR
                (kkm.periode_bln = (CASE WHEN MONTH(NOW()) = 1 THEN 12 ELSE MONTH(NOW()) END) AND kkm.periode_thn =
                (CASE WHEN MONTH(NOW()) = 1 THEN YEAR(NOW())-1 ELSE YEAR(NOW()) END))*/)
                AND kkm.id_pegawai_pelapor = AES_DECRYPT(UNHEX('$idpegawai'),SHA2('keyloginekinerja',512)))
                GROUP BY kkh.idknj_hist_alih_tugas
                ORDER BY kkh.tgl_input DESC) a";
        //echo $sql;
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

    function update_url_berkas_kegiatan($nf, $idknjkeg){
        $this->db->trans_begin();
        $sql = "UPDATE knj_kinerja_kegiatan 
                SET url_berkas_eviden = '$nf' 
                WHERE id_knj_kegiatan = $idknjkeg";

        $this->db->query($sql);
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return array(
                'query' => 0,
            );
        }else{
            $this->db->trans_commit();
            return array(
                'query' => 1,
            );
        }
    }

    function listof_knj_hist_alih_tugas_by_idpegawai($idpegawai){
        $sql = "SELECT kkh.idknj_hist_alih_tugas, kkh.tgl_input AS tgl_update, kkh.unit_kerja, kkh.atsl_nama, kkh.atsl_nip, kkh.atsl_jabatan,
                kkh.pjbt_nama, kkh.pjbt_nip, kkh.pjbt_jabatan, kkh.tmt, kkh.id_skp, DATE_FORMAT(kkh.tmt, '%d-%m-%Y') as tmt2, COUNT(kkk.id_knj_kegiatan) AS jml_aktifitas,
                kkh.atsl_nama_plh, kkh.atsl_jabatan_plh, DATE_FORMAT(kkh.tgl_input, '%d-%m-%Y') as tgl_update2 
                FROM knj_kinerja_historis_alih_tugas kkh 
                LEFT JOIN knj_kinerja_kegiatan kkk ON kkh.idknj_hist_alih_tugas = kkk.idknj_hist_alih_tugas
                WHERE kkh.id_knj_master IN (SELECT kkm.id_knj_master FROM knj_kinerja_master kkm
                WHERE ((kkm.periode_bln = MONTH(NOW()) AND kkm.periode_thn = YEAR(NOW())) OR
                (kkm.periode_bln = (CASE WHEN MONTH(NOW()) = 1 THEN 12 ELSE MONTH(NOW()) END) AND kkm.periode_thn =
                (CASE WHEN MONTH(NOW()) = 1 THEN YEAR(NOW())-1 ELSE YEAR(NOW()) END)))
                AND kkm.id_pegawai_pelapor = AES_DECRYPT(UNHEX('$idpegawai'),SHA2('keyloginekinerja',512)))
                GROUP BY kkh.idknj_hist_alih_tugas
                ORDER BY kkh.tgl_input DESC";
        return $this->db->query($sql);
    }

    function listof_knj_hist_alih_tugas_by_id_knj($id_knj, $keyApps){
        $sql = "SELECT HEX(AES_ENCRYPT(kkh.idknj_hist_alih_tugas,SHA2($keyApps,512))) as idknj_hist_alih_tugas, DATE_FORMAT(kkh.tgl_input, '%d-%m-%Y %H:%i:%s') AS tgl_input, 
                DATE_FORMAT(kkh.tgl_input, '%d-%m-%Y') AS tmt, kkh.tgl_input AS tgl_update, HEX(AES_ENCRYPT(kkh.id_knj_master,SHA2($keyApps,512))) as id_knj_master, 
                kkh.jenjab, kkh.kode_jabatan, kkh.jabatan, kkh.eselon, kkh.kelas_jabatan, kkh.nilai_jabatan, kkh.nilai_rupiah_tkd, kkh.rupiah_awal_tkd, 
                kkh.id_knj_master as id_knj_master_ori, kkh.id_unit_kerja, kkh.unit_kerja, 
                kkh.atsl_idp, kkh.atsl_nip, kkh.atsl_nama, kkh.atsl_gol, kkh.atsl_jabatan, kkh.atsl_id_j,
                kkh.pjbt_idp, kkh.pjbt_nip, kkh.pjbt_nama, kkh.pjbt_gol, kkh.pjbt_jabatan, kkh.pjbt_id_j,
                kkh.atsl_nama_plh, kkh.atsl_jabatan_plh, kkh.atsl_idp_plh, kkh.atsl_nip_plh, kkh.atsl_gol_plh, kkh.atsl_id_j_plh,  
                kkh.pjbt_idp_plh, kkh.pjbt_nip_plh, kkh.pjbt_nama_plh, kkh.pjbt_gol_plh, kkh.pjbt_jabatan_plh, kkh.pjbt_id_j_plh,  
                COUNT(kkk.id_knj_kegiatan) AS jml_aktifitas, HEX(AES_ENCRYPT(kkh.atsl_idp, SHA2('keyloginekinerja',512))) AS idp_atsl_enc 
                FROM knj_kinerja_historis_alih_tugas kkh
                LEFT JOIN knj_kinerja_kegiatan kkk ON kkh.idknj_hist_alih_tugas = kkk.idknj_hist_alih_tugas
                WHERE kkh.id_knj_master = AES_DECRYPT(UNHEX('$id_knj'),SHA2($keyApps,512))
                GROUP BY kkh.idknj_hist_alih_tugas
                ORDER BY kkh.tgl_input DESC";
        return $this->db->query($sql);
    }

    function ref_get_data_hukuman_aktual_by_idpegawai($id_pegawai){
        $sql = "SELECT COUNT(*) as jumlah FROM
                (SELECT id_hukuman, id_pegawai, tmt, tmt_selesai, DATE_FORMAT(NOW(), '%Y-%m-%d') as tgl_skrg,
                IF(tmt_selesai > DATE_FORMAT(NOW(), '%Y-%m-%d'),'Aktual','Kadaluarsa') as validasi_masa
                FROM hukuman WHERE id_pegawai = $id_pegawai) a
                WHERE a.validasi_masa = 'Aktual'";
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

    function ref_get_data_status_aktif_belajar($id_pegawai){
        $sql = "SELECT COUNT(*) as jumlah
                FROM pegawai p
                WHERE p.flag_pensiun = 0 AND p.status_aktif LIKE '%Belajar%' AND p.id_pegawai = $id_pegawai";
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

    function ref_get_persen_knj_jenis_item_lainnya($id_jenis_item){
        $sql = "SELECT persen_tunjangan FROM knj_jenis_item_lainnya
                WHERE id_jenis_item = $id_jenis_item";
        $query = $this->db->query($sql);
        $rowcount = $query->num_rows();
        if($rowcount > 0) {
            foreach ($query->result() as $data) {
                $persen = $data->persen_tunjangan;
            }
        }else{
            $persen = 0;
        }
        return $persen;
    }

    function ref_get_kelas_jabatan($jenjab, $kode_jabatan, $eselon){
        //echo "$jenjab, $kode_jabatan, $eselon";
        if($jenjab=="'Fungsional'"){
            $sql = "SELECT kelas_jabatan, nilai_jabatan
                    FROM jafung WHERE id_jafung = $kode_jabatan";
        }else{
            if($eselon=="'IVA'" or $eselon=="'IVB'" or $eselon=="'IIIA'" or $eselon=="'IIIB'" or $eselon=="'IIA'" or $eselon=="'IIB'"){
                $sql = "SELECT kelas_jabatan, nilai_jabatan
                        FROM jabatan WHERE id_j = $kode_jabatan";
            }else{
                $sql = "SELECT kelas_jabatan, nilai_jabatan
                        FROM jfu_master WHERE id_jfu = $kode_jabatan";
            }
        }
        return $this->db->query($sql);
    }

    function ref_get_nilai_rupiah_tkd(){
        $sql = "SELECT * FROM knj_jenis_tunjangan WHERE id_jenis_tunjangan = 2";
        //return $sql;
        return $this->db->query($sql);
    }

    function ref_get_jml_menit_efektif_kerja($id_pegawai, $bln, $thn){
        $sql = "SELECT x.*, (x.jml_hari_kerja_efektif*jml_menit_perhari) AS jml_menit_efektif_kerja FROM
                (SELECT pegawai.id_pegawai, pegawai.nama, pegawai.id_unit_kerja, pegawai.id_skpd,
                pegawai.opd, pegawai.unit, periode_hari.*, (jumlah_hari -
                (CASE WHEN (pegawai.opd LIKE '%Kesehatan%' OR pegawai.opd LIKE '%Pendidikan%') THEN
                libur_6hari_kerja ELSE libur_5hari_kerja END) - jml_cuti_bersama - jml_libur_nas) AS jml_hari_kerja_efektif
                FROM
                (SELECT peg_unit.*, uk.nama_baru AS unit, $bln AS bln, $thn AS thn FROM
                (SELECT peg.*, uk.nama_baru AS opd FROM
                (SELECT p.id_pegawai, p.nip_baru, CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
                nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(' ',p.gelar_belakang) END) AS nama, clk.id_unit_kerja, uk.id_skpd
                FROM pegawai p LEFT JOIN current_lokasi_kerja clk ON p.id_pegawai = clk.id_pegawai
                LEFT JOIN unit_kerja uk ON clk.id_unit_kerja = uk.id_unit_kerja
                WHERE p.flag_pensiun = 0 AND p.id_pegawai = $id_pegawai) peg LEFT JOIN
                unit_kerja uk ON peg.id_skpd = uk.id_unit_kerja) peg_unit LEFT JOIN
                unit_kerja uk ON peg_unit.id_unit_kerja = uk.id_unit_kerja) pegawai INNER JOIN
                (SELECT c.*, d.jml_cuti_bersama, e.jml_libur_nas, 300 AS jml_menit_perhari FROM
                (SELECT b.*, FLOOR(((b.jumlah_hari / 7) * 2)) AS libur_5hari_kerja,
                FLOOR(((b.jumlah_hari / 7) * 1)) AS libur_6hari_kerja FROM
                (SELECT a.*, DATEDIFF(a.akhir_bulan, a.awal_bulan)+1 AS jumlah_hari FROM
                (SELECT $bln AS bln, $thn AS thn,
                DATE_ADD(DATE_ADD(LAST_DAY(CONCAT($thn,'-',$bln,'-01')), INTERVAL 1 DAY), INTERVAL - 1 MONTH) AS awal_bulan,
                LAST_DAY(CONCAT($thn,'-',$bln,'-01')) AS akhir_bulan) a) b) c
                LEFT JOIN
                (SELECT $bln AS bln, $thn AS thn, COUNT(*) AS jml_cuti_bersama
                FROM cuti_bersama
                WHERE MONTH(tanggal) = $bln AND YEAR(tanggal) = $thn) d ON c.bln = d.bln AND c.thn = d.thn
                LEFT JOIN
                (SELECT $bln AS bln, $thn AS thn, COUNT(*) AS jml_libur_nas
                FROM libur_nasional
                WHERE MONTH(tanggal) = $bln AND YEAR(tanggal) = $thn) e ON c.bln = e.bln AND c.thn = e.thn) periode_hari
                ON pegawai.bln = periode_hari.bln AND pegawai.thn = periode_hari.thn) x";
        return $this->db->query($sql);
    }

    function ref_get_tgl_apel_current($id_pegawai, $bln, $thn){
        $sql = "SELECT c.* FROM (SELECT b.* FROM
                (SELECT  *
                FROM (
                SELECT  DATE_ADD('2015-01-01',
                INTERVAL n4.num*1000+n3.num*100+n2.num*10+n1.num DAY ) AS tgl_apel
                FROM  (
                SELECT 0 AS num
                UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3
                UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6
                UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9
                ) AS n1,
                (
                SELECT 0 AS num
                UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3
                UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6
                UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9
                ) AS n2,
                (
                SELECT 0 AS num
                UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3
                UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6
                UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9
                ) AS n3,
                (
                SELECT 0 AS num
                UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3
                UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6
                UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9
                ) AS n4
                ) AS a
                WHERE tgl_apel >= DATE_ADD(DATE_ADD(LAST_DAY(CONCAT($thn,'-',$bln,'-01')), INTERVAL 1 DAY), INTERVAL - 1 MONTH)
                AND tgl_apel < LAST_DAY(CONCAT($thn,'-',$bln,'-01'))
                AND WEEKDAY(tgl_apel) = 0
                ORDER BY tgl_apel) b
                UNION
                SELECT CASE WHEN $bln=8 THEN NULL ELSE
                CASE WHEN DAYNAME(STR_TO_DATE(CONCAT($thn,'-',$bln,'-17'),'%Y-%m-%d'))='Sunday' THEN
                NULL ELSE (CASE WHEN STR_TO_DATE(CONCAT($thn,'-',$bln,'-17'),'%Y-%m-%d')='Saturday' THEN
                (CASE WHEN (pegawai.opd LIKE '%Kesehatan%' OR pegawai.opd LIKE '%Pendidikan%') THEN
                STR_TO_DATE(CONCAT($thn,'-',$bln,'-17'),'%Y-%m-%d') ELSE NULL END) ELSE STR_TO_DATE(CONCAT($thn,'-',$bln,'-17'),'%Y-%m-%d') END) END END as tgl_apel
                FROM (SELECT peg_unit.*, uk.nama_baru AS unit FROM
                (SELECT peg.*, uk.nama_baru AS opd FROM
                (SELECT p.id_pegawai, p.nip_baru, CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
                nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(' ',p.gelar_belakang) END) AS nama, clk.id_unit_kerja, uk.id_skpd
                FROM pegawai p LEFT JOIN current_lokasi_kerja clk ON p.id_pegawai = clk.id_pegawai
                LEFT JOIN unit_kerja uk ON clk.id_unit_kerja = uk.id_unit_kerja
                WHERE p.flag_pensiun = 0 AND p.id_pegawai = $id_pegawai) peg LEFT JOIN
                unit_kerja uk ON peg.id_skpd = uk.id_unit_kerja) peg_unit LEFT JOIN
                unit_kerja uk ON peg_unit.id_unit_kerja = uk.id_unit_kerja) pegawai) c
                WHERE c.tgl_apel IS NOT NULL";
        return $this->db->query($sql);
    }

    function ref_get_persen_item_lainnya($id_pegawai, $bln, $thn){
        $sql = "SELECT j_knj.kategori_item, COUNT(knj.id_item_lainnya) as jumlah_item,
                SUM(j_knj.persen_tunjangan) as jumlah_persen
                FROM knj_item_lainnya knj INNER JOIN knj_jenis_item_lainnya j_knj
                ON knj.id_jenis_item = j_knj.id_jenis_item
                WHERE knj.id_pegawai = $id_pegawai /*AND knj.periode_bln = $bln AND knj.periode_thn = $thn*/
                GROUP BY j_knj.kategori_item";
        return $this->db->query($sql);
    }

    public function is_exist_reportkinerja_by_periode($id_pegawai, $bln, $thn){
        $sql = "SELECT knj.id_knj_master, COUNT(*) as jumlah, MAX(knj_ha.idknj_hist_alih_tugas) as idknj_hist_alih_tugas
                FROM knj_kinerja_master knj LEFT JOIN knj_kinerja_historis_alih_tugas knj_ha ON knj.id_knj_master = knj_ha.id_knj_master 
                WHERE knj.id_pegawai_pelapor = $id_pegawai
                AND knj.periode_bln = $bln AND knj.periode_thn = $thn AND knj.id_status_knj != 1
                GROUP BY knj.id_knj_master";
        $isexist_kinerja = $this->db->query($sql);
        $rowcount = $isexist_kinerja->num_rows();
        if($rowcount>0){
            foreach ($isexist_kinerja->result() as $data) {
                $id_knj = $data->id_knj_master;
                $jmlExist = $data->jumlah;
                $idknj_hist_alih_tugas = $data->idknj_hist_alih_tugas;
            }
        }else{
            $id_knj = '';
            $jmlExist = 0;
            $idknj_hist_alih_tugas = 0;
        }
        return array(
            'id_knj' => $id_knj,
            'jmlExist' => $jmlExist,
            'idknj_hist_alih_tugas' => $idknj_hist_alih_tugas
        );
    }

    public function listof_kinerja_master($id_pegawai, $keyApps){
        $sql = "SELECT HEX(AES_ENCRYPT(knj.id_knj_master,SHA2($keyApps,512))) as id_knj_master, knj.periode_bln, knj.periode_thn,
                DATE_FORMAT(knj.tgl_input_kinerja, '%d-%m-%Y %H:%i:%s') as tgl_input_kinerja,
                knj.last_unit_kerja, last_atsl_nama, last_atsl_jabatan, knj.last_pjbt_nama, knj.last_pjbt_jabatan, kns.status_knj,
                knj.status_pegawai 
                FROM knj_kinerja_master knj INNER JOIN knj_status_kinerja kns ON knj.id_status_knj = kns.id_status_knj
                WHERE knj.id_pegawai_pelapor = AES_DECRYPT(UNHEX('$id_pegawai'),SHA2('keyloginekinerja',512))
                ORDER BY knj.periode_thn DESC, knj.periode_bln DESC, knj.tgl_input_kinerja DESC";
        return $this->db->query($sql);
    }

    public function deleteKinerjaMaster($id_knj, $keyApps){
        $this->db->trans_begin();
        $sql = "DELETE FROM knj_kinerja_master 
                WHERE id_knj_master = AES_DECRYPT(UNHEX('$id_knj'),SHA2($keyApps,512))";
        $this->db->query($sql);
        if ($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            return 0;
        }else{
            $this->db->trans_commit();
            $sql = "SELECT COUNT(*) as jumlah 
                    FROM knj_kinerja_historis_alih_tugas
                    WHERE id_knj_master = AES_DECRYPT(UNHEX('$id_knj'),SHA2($keyApps,512))";
            $query = $this->db->query($sql);
            $rowcount = $query->num_rows();
            if($rowcount > 0) {
                foreach ($query->result() as $data) {
                    $jmlData = $data->jumlah;
                }
            }else{
                $jmlData = 0;
            }
            if($jmlData > 0){
                $sql = "SELECT HEX(AES_ENCRYPT(idknj_hist_alih_tugas,SHA2($keyApps,512))) as idknj_hist_alih_tugas 
                        FROM knj_kinerja_historis_alih_tugas
                        WHERE id_knj_master = AES_DECRYPT(UNHEX('$id_knj'),SHA2($keyApps,512))";
                $query = $this->db->query($sql);
                $rowcount = $query->num_rows();
                if($rowcount > 0) {
                    foreach ($query->result() as $data) {
                        $idknj_hist_alih_tugas = $data->idknj_hist_alih_tugas;
                        $this->hapusHistAlihTugas(0, $idknj_hist_alih_tugas, $keyApps);
                    }
                }
            }
            return 1;
        }
    }

    public function get_key_apps($api_key){
        $sql = "SELECT CONCAT(ra.rsa_modulo, ra.rsa_private_key, ra.rsa_public_key) as key_apps
                FROM rest_apps ra
                WHERE ra.api_key = '$api_key'";
        $key_apps = $this->db->query($sql);
        $rowcount = $key_apps->num_rows();
        if($rowcount>0){
            foreach ($key_apps->result() as $data) {
                $keyApps = $data->key_apps;
            }
        }else{
            $keyApps = '';
        }
        return $keyApps;
    }

    public function detailLaporanKinerjaById($id_knj, $keyApps){
        $sql = "SELECT a.*, (a.nilai_jabatan*4000) as tunjangan, p.nip_baru as nip_approver, CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
        p.nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(' ',p.gelar_belakang) END) AS nama_approver, a.last_gol AS pangkat_gol, a.last_jenjab AS jenjab, a.last_kode_jabatan AS kode_jabatan,
        a.last_jabatan AS jabatan, a.last_eselon AS eselon, a.last_atsl_id_j AS id_bos_atsl, a.last_id_unit_kerja AS id_unit_kerja_me, a.last_unit_kerja AS unit_kerja_me, a.last_atsl_idp AS id_pegawai_atsl, 
        a.last_atsl_nip AS nip_baru_atsl, a.last_atsl_nama AS nama_atsl, a.last_atsl_gol AS gol_atsl, a.last_atsl_jabatan AS jabatan_atsl, a.last_pjbt_id_j AS id_bos_pjbt, a.last_pjbt_idp AS id_pegawai_pjbt,
        a.last_pjbt_nip AS nip_baru_pjbt, a.last_pjbt_nama AS nama_pjbt, a.last_pjbt_gol AS gol_pjbt, a.last_pjbt_jabatan AS jabatan_pjbt,  
        a.last_atsl_id_j_plh AS id_bos_atsl_plh, a.last_atsl_idp_plh AS idp_plh_atsl, 
        a.last_atsl_nip_plh AS nip_baru_atsl_plh, a.last_atsl_nama_plh AS nama_atsl_plh, 
        a.last_atsl_gol_plh AS gol_atsl_plh, a.last_atsl_jabatan_plh AS jabatan_atsl_plh, 
        a.last_pjbt_id_j_plh AS id_bos_pjbt_plh, a.last_pjbt_idp_plh AS idp_plh_pjbt, 
        a.last_pjbt_nip_plh AS nip_baru_pjbt_plh, a.last_pjbt_nama_plh AS nama_pjbt_plh, 
        a.last_pjbt_gol_plh AS gol_pjbt_plh, a.last_pjbt_jabatan_plh AS jabatan_pjbt_plh   
        FROM 
        (SELECT kkm.*, kkm.id_pegawai_pelapor AS id_pegawai, HEX(AES_ENCRYPT(kkm.id_knj_master,SHA2($keyApps,512))) as id_knj_master_enc, HEX(AES_ENCRYPT(kkm.id_pegawai_pelapor,SHA2('keyloginekinerja',512))) as id_pegawai_enc,
        p.nip_baru, CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
        nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(' ',p.gelar_belakang) END) AS nama, ksk.status_knj,
        kkh.kelas_jabatan, kkh.nilai_jabatan 
        FROM knj_kinerja_master kkm INNER JOIN pegawai p
        ON kkm.id_pegawai_pelapor = p.id_pegawai
        INNER JOIN knj_status_kinerja ksk ON kkm.id_status_knj = ksk.id_status_knj 
        LEFT JOIN knj_kinerja_historis_alih_tugas kkh ON kkm.id_knj_master = kkh.id_knj_master AND kkm.last_kode_jabatan = kkh.kode_jabatan 
        LEFT JOIN jabatan j ON j.id_j = p.id_j
        WHERE kkm.id_knj_master = AES_DECRYPT(UNHEX('$id_knj'),SHA2($keyApps,512)) LIMIT 1) a
        LEFT JOIN pegawai p ON a.id_pegawai_approved = p.id_pegawai";
        return $this->db->query($sql);
    }

    public function listStkSkp($jenjab,$eselon,$kode_jabatan){
        if($jenjab=='Struktural'){
            if($eselon!=''){
                $sql = "SELECT * FROM stk_skp sp WHERE sp.id_j = $kode_jabatan";
            }else{
                $sql = "SELECT * FROM stk_skp sp WHERE sp.id_jfu = $kode_jabatan";
            }
        }elseif($jenjab=='Fungsional'){
            $sql = "SELECT * FROM stk_skp sp WHERE sp.id_jft = $kode_jabatan";
        }
        return $this->db->query($sql);
    }

    public function listSkpByPeriodeAndIdPeg($idpegawai){
        $sql = "SELECT st.id_skp_target as id, st.uraian_tugas as kegiatan 
                FROM skp_target st WHERE st.id_skp =
                (SELECT MAX(sh.id_skp) as id_skp
                FROM skp_header sh WHERE sh.periode_awal =
                (SELECT MAX(sh.periode_awal) as tgl_periode FROM skp_header sh
                WHERE sh.id_pegawai = AES_DECRYPT(UNHEX('$idpegawai'),SHA2('keyloginekinerja',512)) AND YEAR(sh.periode_awal) = YEAR(NOW())
                AND sh.status_pengajuan IN (1,2,3,4,5,6,7)) AND sh.id_pegawai = AES_DECRYPT(UNHEX('$idpegawai'),SHA2('keyloginekinerja',512)) AND YEAR(sh.periode_awal) = YEAR(NOW())
                AND sh.status_pengajuan IN (1,2,3,4,5,6,7))";
        return $this->db->query($sql);
    }

    public function infoLastSKP($idpegawai){
        $sql = "SELECT sh.id_skp, sh.periode_awal as tmt, DATE_FORMAT(sh.periode_awal, '%d-%m-%Y') AS periode_awal, sh.id_penilai, 
                p.nip_baru, CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
                nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(' ',p.gelar_belakang) END) AS nama, sh.jabatan_penilai,
                sh.gol_penilai, uk.nama_baru as unit_kerja , ss.status, uk.id_unit_kerja, sh.id_atasan_penilai 
                FROM skp_header sh, skp_status ss, pegawai p, unit_kerja uk
                WHERE sh.id_skp = 
                (SELECT MAX(sh.id_skp) as id_skp
                FROM skp_header sh WHERE sh.periode_awal =
                (SELECT MAX(sh.periode_awal) as tgl_periode FROM skp_header sh
                WHERE sh.id_pegawai = AES_DECRYPT(UNHEX('$idpegawai'),SHA2('keyloginekinerja',512)) AND YEAR(sh.periode_awal) = YEAR(NOW())
                AND sh.status_pengajuan IN (1,2,3,4,5,6,7)) AND sh.id_pegawai = AES_DECRYPT(UNHEX('$idpegawai'),SHA2('keyloginekinerja',512)) AND YEAR(sh.periode_awal) = YEAR(NOW())
                AND sh.status_pengajuan IN (1,2,3,4,5,6,7)) AND ss.kode_status = sh.status_pengajuan AND
                sh.id_penilai = p.id_pegawai AND sh.id_unit_kerja_pegawai = uk.id_unit_kerja";
        return $this->db->query($sql);
    }

    public function listSkpById($id_skp){
        $sql = "SELECT st.id_skp_target as id, st.uraian_tugas as kegiatan 
                FROM skp_target st WHERE st.id_skp = $id_skp";
        return $this->db->query($sql);
    }

    public function infoLastSKPById($id_skp){
        $sql = "SELECT sh.id_skp, sh.periode_awal as tmt, DATE_FORMAT(sh.periode_awal, '%d-%m-%Y') AS periode_awal, sh.id_penilai,
                p.nip_baru, CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
                nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(' ',p.gelar_belakang) END) AS nama, sh.jabatan_penilai, sh.gol_penilai, uk.nama_baru as unit_kerja , ss.status, uk.id_unit_kerja 
                FROM skp_header sh, skp_status ss, pegawai p, unit_kerja uk
                WHERE sh.id_skp = $id_skp AND ss.kode_status = sh.status_pengajuan AND
                sh.id_penilai = p.id_pegawai AND sh.id_unit_kerja_pegawai = uk.id_unit_kerja";
        return $this->db->query($sql);
    }

    public function getDataReportNoAbsensi_ByIdpTgl($idp, $tgl){
        $sql = "SELECT a.id_pegawai, GROUP_CONCAT(DISTINCT a.nama_status) as nama_status, SUM(a.jumlah) as jumlah FROM
                (SELECT ra.id_pegawai, rs.nama_status, COUNT(ra.id) as jumlah
                FROM report_absensi ra INNER JOIN ref_status_absensi rs ON ra.status = rs.idstatus
                WHERE ra.id_pegawai = $idp AND ra.tgl = '$tgl' AND ra.status <> 'TA' /*AND ra.status <> 'DL'*/
                GROUP BY rs.nama_status 
                UNION ALL 
                SELECT cm.id_pegawai, 'Cuti' as nama_status, COUNT(cm.id_cuti_master) as jumlah FROM cuti_master cm
                WHERE cm.id_pegawai = $idp AND cm.tmt_awal <= STR_TO_DATE('$tgl','%Y-%m-%d') AND
                cm.tmt_akhir >= STR_TO_DATE('$tgl','%Y-%m-%d') AND (cm.id_status_cuti = 6 OR cm.id_status_cuti = 10)
                GROUP BY cm.id_pegawai) a GROUP BY a.id_pegawai, a.nama_status";
        return $this->db->query($sql);
    }

    public function getDataReportLogAbsensi_ByIdpTgl($idp, $tgl, $time){
        $sql = "SELECT DATE_FORMAT(atl.date_time, '%d-%m-%Y %H:%i:%s') AS date_time, 
                (CASE WHEN (STR_TO_DATE('$time', '%H:%i:%s') >= TIME(atl.date_time)) THEN 1 ELSE 0 END) AS waktu_aktivitas_valid  
                FROM oasys_attendance_log atl
                WHERE atl.id_pegawai = $idp and DATE(atl.date_time) = '$tgl'
                ORDER BY atl.date_time ASC LIMIT 1";
        return array(
            'query' => $this->db->query($sql),
            'sql' => $sql
        );
    }

    public function getDataApel_ByIdpTgl($idp, $tgl){
        $sql = "SELECT COUNT(ra.id) as jumlah
                FROM report_absensi ra INNER JOIN ref_status_absensi rs ON ra.status = rs.idstatus
                WHERE ra.id_pegawai = $idp AND ra.tgl = '$tgl' AND ra.status = 'TA'";
        $rs = $this->db->query($sql);
        $rowcount = $rs->num_rows();
        if($rowcount>0){
            foreach ($rs->result() as $data) {
                $jumlah = $data->jumlah;
            }
        }else{
            $jumlah = 0;
        }
        return $jumlah;
    }

    public function getLastKegiatanByDateTime($id_pegawai, $tglKegiatan, $jamKegiatan, $durasi, $type, $tglKegiatanOri, $id_knj){
        if($type == 'add'){
            $limit = '1,1';
        }else{
            if($tglKegiatan==$tglKegiatanOri) {
                $limit = '1,1';
            }else{
                $limit = '1,1';
            }
        }

        $sql = "SELECT b.*,
                CASE WHEN  b.kegiatan_baru > b.kegiatan_durasi_setelah THEN 1 ELSE
                    (CASE WHEN b.kegiatan_baru < b.kegiatan_sebelum THEN 0 ELSE
                            (CASE WHEN b.kegiatan_baru > b.kegiatan_durasi_sebelum THEN
                                    (CASE WHEN b.kegiatan_durasi_baru < b.kegiatan_sesudah THEN (CASE WHEN (b.kegiatan_durasi_sebelum < b.kegiatan_baru AND b.kegiatan_durasi_baru < b.kegiatan_sesudah) THEN 1 ELSE 0 END) ELSE
                                            (CASE WHEN b.kegiatan_sesudah IS NULL THEN 1 ELSE
                                                (CASE WHEN b.kegiatan_baru = b.kegiatan_sesudah THEN 1 ELSE 0 END) END) END) ELSE
                                                        (CASE WHEN b.kegiatan_durasi_baru < b.kegiatan_sesudah THEN (CASE WHEN (b.kegiatan_sebelum <= b.kegiatan_baru AND b.kegiatan_baru < b.kegiatan_durasi_sebelum) THEN 0 ELSE 1 END) ELSE
                                                            (CASE WHEN b.kegiatan_durasi_baru = b.kegiatan_sesudah THEN 0 ELSE
                                                                (CASE WHEN b.kegiatan_sebelum IS NULL THEN (CASE WHEN b.kegiatan_baru_exist IS NOT NULL THEN (CASE WHEN b.kegiatan_baru = b.kegiatan_sesudah THEN 1 ELSE 0 END) ELSE (CASE WHEN b.kegiatan_durasi_baru > b.kegiatan_sesudah THEN 0 ELSE 1 END) END) ELSE
                                                                    (CASE WHEN b.kegiatan_durasi_baru > b.kegiatan_sesudah THEN 0 ELSE
                                                                      (CASE WHEN b.kegiatan_sesudah IS NULL THEN (CASE WHEN b.kegiatan_baru_exist IS NOT NULL THEN 0 ELSE 1 END) ELSE 1 END) END) END) END) END) END) END) END AS flag_status FROM 
                (SELECT a.*, kkk.kegiatan_tanggal as kegiatan_sesudah, kkk.durasi_menit as durasi_menit_setelah,  
                DATE_ADD(kkk.kegiatan_tanggal, INTERVAL kkk.durasi_menit MINUTE) as kegiatan_durasi_setelah
                FROM 
                (SELECT x.kegiatan_baru_exist, x.kegiatan_baru, x.durasi_menit_baru, x.kegiatan_durasi_baru, y.idknj_hist_alih_tugas, y.kegiatan_sebelum, y.durasi_menit_sebelum, y.kegiatan_durasi_sebelum FROM 
                (SELECT xx.*, DATE_ADD(yy.kegiatan_baru, INTERVAL yy.durasi_menit_sebelum MINUTE) as kegiatan_baru_exist FROM (SELECT STR_TO_DATE('$tglKegiatan $jamKegiatan','%Y-%m-%d %H:%i:%s') as kegiatan_baru, $durasi as durasi_menit_baru, DATE_ADD(STR_TO_DATE('$tglKegiatan $jamKegiatan','%Y-%m-%d %H:%i:%s'), INTERVAL $durasi MINUTE) as kegiatan_durasi_baru) xx
                LEFT JOIN (SELECT kkh.idknj_hist_alih_tugas, STR_TO_DATE('$tglKegiatan $jamKegiatan','%Y-%m-%d %H:%i:%s') as kegiatan_baru, $durasi as durasi_menit_baru,
                kkk.kegiatan_tanggal as kegiatan_sebelum, kkk.durasi_menit as durasi_menit_sebelum,
                DATE_ADD(kkk.kegiatan_tanggal, INTERVAL kkk.durasi_menit MINUTE) as kegiatan_durasi_sebelum
                FROM knj_kinerja_master kkm 
                INNER JOIN knj_kinerja_historis_alih_tugas kkh ON kkm.id_knj_master = kkh.id_knj_master
                INNER JOIN knj_kinerja_kegiatan kkk ON kkh.idknj_hist_alih_tugas = kkk.idknj_hist_alih_tugas
                WHERE kkm.id_pegawai_pelapor = $id_pegawai AND DATE_FORMAT(kkk.kegiatan_tanggal , '%Y-%m-%d') =
                STR_TO_DATE('$tglKegiatan','%Y-%m-%d') AND kkk.kegiatan_tanggal <= STR_TO_DATE('$tglKegiatan $jamKegiatan','%Y-%m-%d %H:%i:%s')
                ORDER BY kkk.kegiatan_tanggal DESC LIMIT 0,1) yy ON xx.kegiatan_baru = yy.kegiatan_baru) x 
                LEFT JOIN (SELECT kkh.idknj_hist_alih_tugas, STR_TO_DATE('$tglKegiatan $jamKegiatan','%Y-%m-%d %H:%i:%s') as kegiatan_baru, $durasi as durasi_menit_baru, 
                DATE_ADD(STR_TO_DATE('$tglKegiatan $jamKegiatan','%Y-%m-%d %H:%i:%s'), INTERVAL $durasi MINUTE) as kegiatan_durasi_baru,
                kkk.kegiatan_tanggal as kegiatan_sebelum, kkk.durasi_menit as durasi_menit_sebelum,
                DATE_ADD(kkk.kegiatan_tanggal, INTERVAL kkk.durasi_menit MINUTE) as kegiatan_durasi_sebelum
                FROM knj_kinerja_master kkm 
                INNER JOIN knj_kinerja_historis_alih_tugas kkh ON kkm.id_knj_master = kkh.id_knj_master
                INNER JOIN knj_kinerja_kegiatan kkk ON kkh.idknj_hist_alih_tugas = kkk.idknj_hist_alih_tugas
                WHERE kkm.id_pegawai_pelapor = $id_pegawai AND DATE_FORMAT(kkk.kegiatan_tanggal , '%Y-%m-%d') =
                STR_TO_DATE('$tglKegiatan','%Y-%m-%d') AND kkk.kegiatan_tanggal <= STR_TO_DATE('$tglKegiatan $jamKegiatan','%Y-%m-%d %H:%i:%s')
                ORDER BY kkk.kegiatan_tanggal DESC LIMIT 0,1) y ON x.kegiatan_baru = y.kegiatan_baru) a
                LEFT JOIN knj_kinerja_historis_alih_tugas kkh ON a.idknj_hist_alih_tugas = kkh.idknj_hist_alih_tugas OR kkh.idknj_hist_alih_tugas IN (SELECT kat.idknj_hist_alih_tugas FROM knj_kinerja_historis_alih_tugas kat WHERE kat.id_knj_master = $id_knj)
                LEFT JOIN knj_kinerja_kegiatan kkk ON kkh.idknj_hist_alih_tugas = kkk.idknj_hist_alih_tugas AND 
                DATE_FORMAT(kkk.kegiatan_tanggal , '%Y-%m-%d') = STR_TO_DATE('$tglKegiatan','%Y-%m-%d') AND 
                ((DATE_ADD(kkk.kegiatan_tanggal, INTERVAL kkk.durasi_menit MINUTE) > DATE_ADD(STR_TO_DATE('$tglKegiatan $jamKegiatan','%Y-%m-%d %H:%i:%s'), INTERVAL $durasi MINUTE))
                OR (DATE_FORMAT(kkk.kegiatan_tanggal , '%Y-%m-%d %H:%i:%s') > a.kegiatan_baru)) 
                ORDER BY kkk.kegiatan_tanggal ASC LIMIT $limit) b";


        return $this->db->query($sql);
    }

    public function getAktivitasKegiatan($id_knj, $keyApps){
        $sql = "SELECT HEX(AES_ENCRYPT(kk.id_knj_kegiatan,SHA2($keyApps,512))) as id_knj_kegiatan_enc,
                  HEX(AES_ENCRYPT(a.id_knj_master,SHA2($keyApps,512))) as id_knj_master_enc,
                  kk.*, trim(replace(REPLACE(kk.kegiatan_rincian,CHAR(13),''),CHAR(10),' ')) as kegiatan_rincian2,
                  (CASE WHEN (ss.uraian_tugas = '' OR ss.uraian_tugas IS NULL) THEN 
                  (CASE WHEN kk.kegiatan_kategori_id = -1 THEN 'Tugas Tambahan' ELSE
                  (CASE WHEN kk.kegiatan_kategori_id = -4 THEN 'Tugas Tambahan Khusus' ELSE
                  (CASE WHEN kk.kegiatan_kategori_id = -2 THEN 'Instruksi Khusus Pimpinan (IKP) khusus JPT' ELSE
                  (CASE WHEN kk.kegiatan_kategori_id = -3 THEN 'Penyesuaian Target Baru' ELSE '' END) END) END) END) ELSE ss.uraian_tugas END) as kegiatan, DATE_FORMAT(kk.kegiatan_tanggal, '%d-%m-%Y %H:%i:%s') AS kegiatan_tanggal2,
                  DATE_FORMAT(kk.tgl_input, '%d-%m-%Y %H:%i:%s') AS tgl_input2,
                  DATE_FORMAT(kk.tgl_update, '%d-%m-%Y %H:%i:%s') AS tgl_update2,
                  DATE_FORMAT(kk.tgl_approved, '%d-%m-%Y %H:%i:%s') AS tgl_approved2, a.atsl_nama, a.atsl_nip FROM
                (SELECT * FROM knj_kinerja_historis_alih_tugas kkat
                WHERE kkat.id_knj_master = AES_DECRYPT(UNHEX('$id_knj'), SHA2($keyApps,512))) a
                INNER JOIN knj_kinerja_kegiatan kk ON kk.idknj_hist_alih_tugas = a.idknj_hist_alih_tugas
                LEFT JOIN skp_target ss ON kk.kegiatan_kategori_id = ss.id_skp_target
                ORDER BY kk.kegiatan_tanggal DESC";
        return $this->db->query($sql);
    }

    public function getIdKnjMaster($idpegawai, $keyApps){
        $sql = "SELECT HEX(AES_ENCRYPT(kkm.id_knj_master,SHA2($keyApps,512))) as id_knj_master
                FROM knj_kinerja_master kkm
                WHERE kkm.periode_bln = MONTH(NOW()) AND kkm.periode_thn = YEAR(NOW())
                AND kkm.id_pegawai_pelapor = AES_DECRYPT(UNHEX('$idpegawai'),SHA2('keyloginekinerja',512))";
        $rs = $this->db->query($sql);
        if (isset($rs)) {
            $rowcount = $rs->num_rows();
            if ($rowcount > 0) {
                foreach ($rs->result() as $data) {
                    $id_knj_master = $data->id_knj_master;
                }
            }else{
                $id_knj_master = 0;
            }
        }else{
            $id_knj_master = 0;
        }
        return $id_knj_master;
    }

    public function ubahAktifitasKegiatanById($id_knj_keg, $keyApps){
        $sql = "SELECT a.*, knha.tmt, knha.id_skp FROM 
                (SELECT kk.*, DATE_FORMAT(kk.kegiatan_tanggal, '%Y/%m/%d') as tgl_kegiatan,
                DATE_FORMAT(kk.kegiatan_tanggal, '%H:%i:%s') as jam_kegiatan,
                DATE_FORMAT(kk.tgl_input, '%d-%m-%Y') as tgl_create 
                FROM knj_kinerja_kegiatan kk 
                WHERE kk.id_knj_kegiatan = AES_DECRYPT(UNHEX('$id_knj_keg'),SHA2($keyApps,512))) a
                INNER JOIN knj_kinerja_historis_alih_tugas knha ON a.idknj_hist_alih_tugas = knha.idknj_hist_alih_tugas";
        return $this->db->query($sql);
    }

    public function hapusAktifitasKegiatanById($id_knj_keg, $keyApps){
        $this->db->trans_begin();
        $url_berkas_eviden = $this->getUrlBerkasEvidenByIdKeg($id_knj_keg, $keyApps);
        $sql = "DELETE FROM knj_kinerja_kegiatan 
                WHERE id_knj_kegiatan = AES_DECRYPT(UNHEX('$id_knj_keg'),SHA2($keyApps,512))";
        $this->db->query($sql);
        if ($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            return 0;
        }else{
            if($url_berkas_eviden!=''){
                //if(file_exists($_SERVER['DOCUMENT_ROOT']."/ekinerja2/berkas/".$url_berkas_eviden)){
                //    unlink($_SERVER['DOCUMENT_ROOT']."/ekinerja2/berkas/".$url_berkas_eviden);
                //}
                $connection = ssh2_connect('103.14.229.15');
                ssh2_auth_password($connection, 'rommonz', 'mony3Tmony3T');
                $sftp = ssh2_sftp($connection);
                error_reporting(0);
                if (file_exists('ssh2.sftp://' . $sftp . '/var/www/html/ekinerja2/berkas/'.$url_berkas_eviden)) {
                    ssh2_sftp_unlink($sftp, '/var/www/html/ekinerja2/berkas/'.$url_berkas_eviden);
                }
                error_reporting(1);
            }
            $this->db->trans_commit();
            return 1;
        }
    }

    public function hapusBerkasKegiatanById($id_knj_keg, $keyApps){
        $this->db->trans_begin();
        $url_berkas_eviden = $this->getUrlBerkasEvidenByIdKeg($id_knj_keg, $keyApps);
        $sql = "UPDATE knj_kinerja_kegiatan SET url_berkas_eviden = NULL
                WHERE id_knj_kegiatan = AES_DECRYPT(UNHEX('$id_knj_keg'),SHA2($keyApps,512))";
        $this->db->query($sql);
        if ($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            return 0;
        }else{
            if($url_berkas_eviden!=''){
                /*if(file_exists($_SERVER['DOCUMENT_ROOT']."/ekinerja2/berkas/".$url_berkas_eviden)){
                    unlink($_SERVER['DOCUMENT_ROOT']."/ekinerja2/berkas/".$url_berkas_eviden);
                }*/
                $connection = ssh2_connect('103.14.229.15');
                ssh2_auth_password($connection, 'rommonz', 'mony3Tmony3T');
                $sftp = ssh2_sftp($connection);
                error_reporting(0);
                if (file_exists('ssh2.sftp://' . $sftp . '/var/www/html/ekinerja2/berkas/'.$url_berkas_eviden)) {
                    ssh2_sftp_unlink($sftp, '/var/www/html/ekinerja2/berkas/'.$url_berkas_eviden);
                }
                error_reporting(1);
            }
            $this->db->trans_commit();
            return 1;
        }
    }

    public function hapusHistAlihTugas($id_knj, $idknj_hist_alih_tugas, $keyApps){
        $this->db->trans_begin();
        $sql = "DELETE FROM knj_kinerja_historis_alih_tugas
                WHERE idknj_hist_alih_tugas = AES_DECRYPT(UNHEX('$idknj_hist_alih_tugas'),SHA2($keyApps,512))";
        $this->db->query($sql);
        if ($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            return 0;
        }else{
            $this->db->trans_commit();
            $sql = "SELECT COUNT(*) as jumlah 
                    FROM knj_kinerja_kegiatan
                    WHERE idknj_hist_alih_tugas = AES_DECRYPT(UNHEX('$idknj_hist_alih_tugas'),SHA2($keyApps,512))";
            $query = $this->db->query($sql);
            $rowcount = $query->num_rows();
            if($rowcount > 0) {
                foreach ($query->result() as $data) {
                    $jmlData = $data->jumlah;
                }
            }else{
                $jmlData = 0;
            }
            if($jmlData > 0){
                $sql = "SELECT HEX(AES_ENCRYPT(id_knj_kegiatan,SHA2($keyApps,512))) as id_knj_kegiatan 
                        FROM knj_kinerja_kegiatan
                        WHERE idknj_hist_alih_tugas = AES_DECRYPT(UNHEX('$idknj_hist_alih_tugas'),SHA2($keyApps,512))";
                $query = $this->db->query($sql);
                $rowcount = $query->num_rows();
                if($rowcount > 0) {
                    foreach ($query->result() as $data) {
                        $idkegiatan = $data->id_knj_kegiatan;
                        $this->hapusAktifitasKEgiatanById($idkegiatan, $keyApps);
                    }
                }
            }
            if($id_knj==0 and $id_knj=='') {
            }else{
                $query = $this->listof_knj_hist_alih_tugas_by_id_knj($id_knj, $keyApps);
                $data_list = $query->result();
                $i = 1;
                if (isset($data_list) and sizeof($data_list) > 0 and $data_list != '') {
                    foreach ($data_list as $data2) {
                        if ($i == 1) {
                            $data_atasan = array(
                                'last_id_unit_kerja' => $data2->id_unit_kerja,
                                'last_unit_kerja' => "'".$data2->unit_kerja."'",
                                'jenjab' => "'".$data2->jenjab."'",
                                'kode_jabatan' => $data2->kode_jabatan,
                                'jabatan' => "'".$data2->jabatan."'",
                                'eselon' => "'".$data2->eselon."'",
                                'last_atsl_idp' => $data2->atsl_idp,
                                'last_atsl_nip' => "'".$data2->atsl_nip."'",
                                'last_atsl_nama' => "'".$data2->atsl_nama."'",
                                'last_atsl_gol' => "'".$data2->atsl_gol."'",
                                'last_atsl_jabatan' => "'".$data2->atsl_jabatan."'",
                                'last_atsl_id_j' => $data2->atsl_id_j,
                                'last_pjbt_idp' => $data2->pjbt_idp,
                                'last_pjbt_nip' => "'".$data2->pjbt_nip."'",
                                'last_pjbt_nama' => "'".$data2->pjbt_nama."'",
                                'last_pjbt_gol' => "'".$data2->pjbt_gol."'",
                                'last_pjbt_jabatan' => "'".$data2->pjbt_jabatan."'",
                                'last_pjbt_id_j' => $data2->pjbt_id_j,
                                'last_atsl_idp_plh' => $data2->atsl_idp_plh,
                                'last_atsl_nip_plh' => "'".$data2->atsl_nip_plh."'",
                                'last_atsl_nama_plh' => "'".$data2->atsl_nama_plh."'",
                                'last_atsl_gol_plh' => "'".$data2->atsl_gol_plh."'",
                                'last_atsl_jabatan_plh' => "'".$data2->atsl_jabatan_plh."'",
                                'last_atsl_id_j_plh' => $data2->atsl_id_j_plh,
                                'last_pjbt_idp_plh' => $data2->pjbt_idp_plh,
                                'last_pjbt_nip_plh' => "'".$data2->pjbt_nip_plh."'",
                                'last_pjbt_nama_plh' => "'".$data2->pjbt_nama_plh."'",
                                'last_pjbt_gol_plh' => "'".$data2->pjbt_gol_plh."'",
                                'last_pjbt_jabatan_plh' => "'".$data2->pjbt_jabatan_plh."'",
                                'last_pjbt_id_j_plh' => $data2->pjbt_id_j_plh,
                            );

                            $id_knj = $data2->id_knj_master_ori;
                            $this->update_last_atsl_kinerja_master($data_atasan, $id_knj);
                        }
                        $i++;
                    }
                }
            }
            return 1;
        }
    }

    public function getUrlBerkasEvidenByIdKeg($id_knj_keg, $keyApps){
        $sql = "SELECT url_berkas_eviden 
                FROM knj_kinerja_kegiatan 
                WHERE id_knj_kegiatan = AES_DECRYPT(UNHEX('$id_knj_keg'),SHA2($keyApps,512))";
        $rs = $this->db->query($sql);
        $rowcount = $rs->num_rows();
        if($rowcount>0){
            foreach ($rs->result() as $data) {
                $url_berkas_eviden = $data->url_berkas_eviden;
            }
        }else{
            $url_berkas_eviden = '';
        }
        return $url_berkas_eviden;
    }

    public function getSatuanHasilOutput(){
        $sql = "SELECT * FROM knj_satuan_output ORDER BY satuan_output";
        return $this->db->query($sql);
    }

    public function listof_knj_hist_absensi_kehadiran_apel($id_knj_master, $idpegawai, $filter_tgl, $keyApps){
        $sql = "SELECT id_pegawai FROM pegawai 
                WHERE id_pegawai = AES_DECRYPT(UNHEX('$idpegawai'), SHA2('keyloginekinerja',512));";
        $rs = $this->db->query($sql);
        if (isset($rs)) {
            $rowcount = $rs->num_rows();
            if ($rowcount > 0) {
                foreach ($rs->result() as $data) {
                    $idp = $data->id_pegawai;
                }
            }else{
                $idp = 0;
            }
        }else{
            $idp = 0;
        }
        if($idp>0){
            if($id_knj_master==""){
                $bln = date("m");
                $thn = date("Y");
                $rowcount = 1;
            }else{
                $sql = "SELECT knj.periode_bln, knj.periode_thn 
                    FROM knj_kinerja_master knj WHERE knj.id_knj_master = 
                    AES_DECRYPT(UNHEX('$id_knj_master'), SHA2('$keyApps',512));";
                $rs = $this->db->query($sql);
                if (isset($rs)) {
                    $rowcount = $rs->num_rows();
                    if ($rowcount > 0) {
                        foreach ($rs->result() as $data) {
                            $bln = $data->periode_bln;
                            $thn = $data->periode_thn;
                        }
                    }else{
                        $rowcount = 0;
                    }
                }else{
                    $rowcount = 0;
                }
            }

            if($rowcount>0) {
                $whereFilterTgl1 = '';
                $whereFilterTgl2 = '';
                if($filter_tgl==true){
                    $sql = "CALL PRCD_KINERJA_ABSENSI_KEHADIRAN_MDX($idp,$bln,$thn,1)";
                    $this->db->query($sql);
                    $whereFilterTgl1 = "WHERE tgl = ".date('d');
                    $whereFilterTgl2 = "WHERE DAY(kkk.kegiatan_tanggal) = ".date('d');
                }else{
                    $sql = "CALL PRCD_KINERJA_ABSENSI_KEHADIRAN_MDX($idp,$bln,$thn,0)";
                    $rs = $this->db->query($sql);
                    /*$rowcount = $rs->num_rows();
                    if($rowcount>0){
                        foreach ($rs->result() as $data) {
                            $str_sql = $data->str_sql;
                        }
                    }*/
                }
                $sql = "SELECT * FROM
                        (SELECT * FROM TEMP_KNJ_ABSENSI $whereFilterTgl1) xx LEFT JOIN
                        (SELECT d.idknj_hist_alih_tugas, d.tgl as tgl2, d.jumlah_durasi_aktual AS jumlah_durasi, d.tugas_utama, d.tugas_tambahan_khusus, d.penyesuaian_target, d.tugas_tambahan, d.ikp FROM
                        (SELECT c.*, (IF(c.tugas_tambahan >= c.maks_tambahan, c.maks_tambahan, c.tugas_tambahan) +
                        IF(c.ikp >= c.maks_ikp, c.maks_ikp, c.ikp) + c.tugas_utama + c.tugas_tambahan_khusus + c.penyesuaian_target) AS jumlah_durasi_aktual FROM
                        (SELECT b.idknj_hist_alih_tugas, b.tgl, b.last_unit_kerja,
                        SUM(IF(b.kategori = 'Tugas Utama', b.jumlah_durasi, 0)) AS tugas_utama,
                        SUM(IF(b.kategori = 'Tugas Tambahan', b.jumlah_durasi, 0)) AS tugas_tambahan,
                        SUM(IF(b.kategori = 'Tugas Tambahan Khusus', b.jumlah_durasi, 0)) AS tugas_tambahan_khusus,
                        SUM(IF(b.kategori = 'Penyesuaian Target Baru', b.jumlah_durasi, 0)) AS penyesuaian_target,
                        SUM(IF(b.kategori = 'IKP', b.jumlah_durasi, 0)) AS ikp,
                        ((CASE WHEN 9 = 9 THEN 240 ELSE 300 END)*0.2) as maks_tambahan, ((CASE WHEN 9 = 9 THEN 240 ELSE 300 END)*0.8) as maks_utama_80,
                        ((CASE WHEN 9 = 9 THEN 240 ELSE 300 END)*0.7) as maks_utama_70, ((CASE WHEN 9 = 9 THEN 240 ELSE 300 END)*0.1) as maks_ikp
                        FROM
                        (SELECT a.idknj_hist_alih_tugas, a.last_unit_kerja, a.tgl, a.kategori, SUM(a.durasi_menit) AS jumlah_durasi
                        FROM
                        (SELECT b.idknj_hist_alih_tugas, b.last_unit_kerja, DAY(kkk.kegiatan_tanggal) as tgl, kkk.kegiatan_kategori_id,
                        CASE WHEN kkk.kegiatan_kategori_id = -1 THEN 'Tugas Tambahan' ELSE
                        (CASE WHEN kkk.kegiatan_kategori_id = -2 THEN 'IKP' ELSE
                        (CASE WHEN kkk.kegiatan_kategori_id = -3 THEN 'Penyesuaian Target Baru' ELSE
                        (CASE WHEN kkk.kegiatan_kategori_id = -4 THEN 'Tugas Tambahan Khusus' ELSE 'Tugas Utama' END) END) END) END AS kategori, kkk.durasi_menit
                        FROM knj_kinerja_kegiatan kkk INNER JOIN
                        (SELECT kkat.idknj_hist_alih_tugas, a.last_unit_kerja FROM knj_kinerja_historis_alih_tugas kkat INNER JOIN
                        (SELECT kkm.id_knj_master, kkm.last_unit_kerja FROM knj_kinerja_master kkm
                        WHERE kkm.periode_bln = $bln AND kkm.periode_thn = $thn AND kkm.id_pegawai_pelapor = $idp) a ON
                        kkat.id_knj_master = a.id_knj_master) b ON kkk.idknj_hist_alih_tugas = b.idknj_hist_alih_tugas 
                        $whereFilterTgl2) a
                        GROUP BY a.idknj_hist_alih_tugas, a.tgl, a.kategori) b
                        GROUP BY b.idknj_hist_alih_tugas, b.tgl) c) d) yy ON xx.tgl = yy.tgl2";
                return $this->db->query($sql);
            }else{
                return null;
            }
        }else{
            return null;
        }
    }

    public function getItemKinerjaLainnya($idp, $bln, $thn){
        $sql = "";
    }

    public function getInformasiPegawai($nip){
        $sql = "SELECT p.id_pegawai, CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
                p.nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(' ',p.gelar_belakang) END) AS nama,
                p.nip_baru, p.pangkat_gol, p.id_j, j.jabatan, clk.id_unit_kerja, uk.nama_baru as unit
                FROM pegawai p
                LEFT JOIN current_lokasi_kerja clk ON p.id_pegawai = clk.id_pegawai
                LEFT JOIN unit_kerja uk ON clk.id_unit_kerja = uk.id_unit_kerja
                LEFT JOIN jabatan j ON p.id_j = j.id_j
                WHERE p.nip_baru = '$nip'";
        return $this->db->query($sql);
    }

    public function execute_sp_kalkulasi_kinerja($idpegawai, $bln, $thn, $id_knj_master, $keyApps){
        $this->db->trans_begin();
        $sql = "SELECT id_pegawai FROM pegawai 
                WHERE id_pegawai = AES_DECRYPT(UNHEX('$idpegawai'), SHA2('keyloginekinerja',512));";
        $rs = $this->db->query($sql);
        if (isset($rs)) {
            $rowcount = $rs->num_rows();
            if ($rowcount > 0) {
                foreach ($rs->result() as $data) {
                    $idp = $data->id_pegawai;
                }
            }else{
                $idp = 0;
            }
        }else{
            $idp = 0;
        }

        if($idp>0){
            $sql = "SELECT knj.id_knj_master 
                    FROM knj_kinerja_master knj WHERE knj.id_knj_master = 
                    AES_DECRYPT(UNHEX('$id_knj_master'), SHA2('$keyApps',512));";
            $rs = $this->db->query($sql);
            if (isset($rs)) {
                $rowcount = $rs->num_rows();
                if ($rowcount > 0) {
                    foreach ($rs->result() as $data) {
                        $id_knj_master = $data->id_knj_master;
                    }
                }else{
                    $rowcount = 0;
                }
                if($rowcount>0) {
                    $sql = "CALL PRCD_KINERJA_ABSENSI_KEHADIRAN_MDX($idp, $bln, $thn, 0);";
                    $this->db->query($sql);
                    if ($this->db->trans_status() === FALSE){
                        $this->db->trans_rollback();
                        return 0;
                    }else {
                        $sql = "CALL PRCD_KINERJA_KALKULASI_NILAI_TUNJANGAN($idp, $bln, $thn, $id_knj_master);";
                        $this->db->query($sql);
                        if ($this->db->trans_status() === FALSE){
                            $this->db->trans_rollback();
                            return 0;
                        }else{
                            $this->db->trans_commit();
                            return 1;
                        }
                    }
                }else{
                    return 0;
                }
            }else{
                return 0;
            }
        }else{
            return 0;
        }
    }

    public function execute_sp_kinerja_selesai($id_knj_master, $idpegawai_approved, $status_laporan, $keyApps){
        $this->db->trans_begin();
        $sql = "SELECT id_pegawai FROM pegawai 
                WHERE id_pegawai = AES_DECRYPT(UNHEX('$idpegawai_approved'), SHA2('keyloginekinerja',512));";
        $rs = $this->db->query($sql);
        if (isset($rs)) {
            $rowcount = $rs->num_rows();
            if ($rowcount > 0) {
                foreach ($rs->result() as $data) {
                    $idp = $data->id_pegawai;
                }
            }else{
                $idp = 0;
            }
        }else{
            $idp = 0;
        }

        if($idp>0){
            $sql = "SELECT knj.id_knj_master 
                    FROM knj_kinerja_master knj WHERE knj.id_knj_master = 
                    AES_DECRYPT(UNHEX('$id_knj_master'), SHA2('$keyApps',512));";
            $rs = $this->db->query($sql);
            if (isset($rs)) {
                $rowcount = $rs->num_rows();
                if ($rowcount > 0) {
                    foreach ($rs->result() as $data) {
                        $id_knj_master = $data->id_knj_master;
                    }
                }else{
                    $rowcount = 0;
                }
                if($rowcount>0) {
                    if($status_laporan=='ajukan') {
                        $sql = "UPDATE knj_kinerja_master SET id_status_knj = 3, tgl_approved = NOW(), catatan_approved = '-', 
                            id_pegawai_approved = $idp 
                            WHERE id_knj_master = " . $id_knj_master;
                    }else{
                        $sql = "UPDATE knj_kinerja_master SET id_status_knj = 2, tgl_approved = NULL, catatan_approved = NULL, 
                            id_pegawai_approved = NULL 
                            WHERE id_knj_master = " . $id_knj_master;
                    }
                    $this->db->query($sql);
                    if ($this->db->trans_status() === FALSE){
                        $this->db->trans_rollback();
                        return 0;
                    }else{
                        $this->db->trans_commit();
                        return 1;
                    }
                }else{
                    return 0;
                }
            }else{
                return 0;
            }
        }else{
            return 0;
        }
    }

    public function list_staf_aktual_kinerja($id_pegawai_enc, $id_skpd_enc, $keyApps){
        $sql = "SELECT HEX(AES_ENCRYPT(uk.id_unit_kerja,SHA2($keyApps,512))) as id_skpd_enc, uk.nama_baru as unit
                FROM unit_kerja uk WHERE uk.id_unit_kerja = uk.id_skpd AND uk.tahun = (SELECT MAX(tahun) FROM unit_kerja)
                AND (uk.nama_baru LIKE '%Dinas Kesehatan%' OR uk.nama_baru LIKE '%Dinas Pendidikan%')";
        $query = $this->db->query($sql);
        foreach ($query->result() as $data) {
            $id_skpd_enc_get = $data->id_skpd_enc;
            if($id_skpd_enc_get==$id_skpd_enc){
                $dinkes_disdik = $data->unit;
                break;
            }else{
                $dinkes_disdik = '';
            }
        }

        if($dinkes_disdik=='Dinas Kesehatan Kota Bogor'){
            $andKlause = "AND (uk.id_unit_kerja = uk.id_skpd OR uk.id_unit_kerja =
            (SELECT id_unit_kerja FROM unit_kerja uk_labkesda WHERE uk_labkesda.tahun = (SELECT MAX(tahun) FROM unit_kerja)
            AND uk_labkesda.nama_baru LIKE '%UPTD Laboratorium Kesehatan Daerah%'))";
        }elseif($dinkes_disdik=='Dinas Pendidikan Kota Bogor'){
            $andKlause = "AND (CASE WHEN p.jenjab = 'Fungsional' THEN (CASE WHEN jafung.nama_jafung IS NULL THEN p.jabatan ELSE jafung.nama_jafung END) ELSE
            CASE WHEN p.id_j IS NULL THEN (jfu.nama_jfu) ELSE j.jabatan END END) != 'Guru'";
        }else{
            $andKlause = "";
        }

        $sql = "SELECT ax.*, HEX(AES_ENCRYPT(kkm.id_knj_master,SHA2('$keyApps',512))) AS id_knj_master_enc, 
                (CASE WHEN kkm.id_knj_master IS NULL THEN 'Belum' ELSE 'Sudah Ada' END) as ekinerja_current,
                ksk.status_knj, (CASE WHEN kkm.flag_kalkulasi = 1 THEN CONCAT('Sudah pada ', DATE_FORMAT(kkm.tgl_update_kalkulasi, '%d-%m-%Y %H:%i:%s')) ELSE '' END) as kalkulasi,
                HEX(AES_ENCRYPT(ax.id_pegawai,SHA2('keyloginekinerja',512))) AS id_pegawai_enc
                FROM (SELECT z.* FROM
                (SELECT b.*, (CASE WHEN p.id_pegawai IS NULL THEN (SELECT CASE WHEN jplt.id_pegawai IS NULL = 1 THEN 0 ELSE jplt.id_pegawai END AS id_pegawai
                FROM jabatan_plt jplt WHERE jplt.id_j = b.id_bos_atsl LIMIT 1) ELSE p.id_pegawai END) AS id_pegawai_atasan, 
                (CASE WHEN uk_dinkes.id_unit_kerja IS NULL = 1 THEN 1 ELSE 
                (CASE WHEN (b.id_unit_kerja = uk_dinkes.id_unit_kerja OR b.id_unit_kerja = uk_labkesda.id_unit_kerja) THEN 1 ELSE 0 END) END) as cek 
                FROM (SELECT a.id_pegawai, a.id_unit_kerja, uk.id_unit_kerja AS id_skpd, a.id_bos_atsl,
                a.nip_baru, a.nama, a.jenjab, a.pangkat_gol, a.jabatan, (CASE WHEN a.eselon = 'Z' THEN '' ELSE a.eselon END) AS eselon
                FROM
                (SELECT p.id_pegawai,
                p.nip_baru, CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
                nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(' ',p.gelar_belakang) END) AS nama, p.tempat_lahir, p.tgl_lahir,
                ROUND(DATEDIFF(CURRENT_DATE, DATE_FORMAT(p.tgl_lahir, '%Y/%m/%d'))/365,2) AS usia,
                p.jenjab, p.pangkat_gol,
                CASE WHEN p.jenjab = 'Fungsional' THEN (jafung.kode_jabatan_jafung) ELSE
                CASE WHEN p.id_j IS NULL THEN (jfu.kode_jabatan_jfu) ELSE j.id_j END END AS kode_jabatan,
                CASE WHEN p.jenjab = 'Fungsional' THEN (jafung.kelas_jabatan_jafung) ELSE
                CASE WHEN p.id_j IS NULL THEN (jfu.kelas_jabatan_jfu) ELSE j.kelas_jabatan END END AS kelas_jabatan,
                CASE WHEN p.jenjab = 'Fungsional' THEN (jafung.nilai_jabatan_jafung) ELSE
                CASE WHEN p.id_j IS NULL THEN (jfu.nilai_jabatan_jfu) ELSE j.nilai_jabatan END END AS nilai_jabatan,
                CASE WHEN p.jenjab = 'Fungsional' THEN (CASE WHEN jafung.nama_jafung IS NULL THEN p.jabatan ELSE jafung.nama_jafung END) ELSE
                CASE WHEN p.id_j IS NULL THEN (jfu.nama_jfu) ELSE j.jabatan END END AS jabatan,
                CASE WHEN j.eselon IS NULL THEN 'Z' ELSE j.eselon END AS eselon,
                uk.id_unit_kerja, uk.id_skpd,
                CASE WHEN j.id_bos IS NULL = 1 THEN (
                (SELECT CASE WHEN ( (id_j_bos IS NULL) OR (COUNT(id_j_bos)=0)) THEN
                (SELECT CASE WHEN ( (id_j_bos IS NULL) OR (COUNT(id_j_bos)=0)) THEN
                (SELECT CASE WHEN ( (id_j_bos IS NULL) OR (COUNT(id_j_bos)=0)) THEN
                (SELECT CASE WHEN ( (id_j_bos IS NULL) OR (COUNT(id_j_bos)=0)) THEN
                (SELECT CASE WHEN ( (id_j_bos IS NULL) OR (COUNT(id_j_bos)=0)) THEN
                (SELECT CASE WHEN ( (id_j_bos IS NULL) OR (COUNT(id_j_bos)=0)) THEN
                (SELECT CASE WHEN ( (id_j_bos IS NULL) OR (COUNT(id_j_bos)=0)) THEN
                (SELECT CASE WHEN ( (id_j_bos IS NULL) OR (COUNT(id_j_bos)=0)) THEN
                (SELECT CASE WHEN ( (id_j_bos IS NULL) OR (COUNT(id_j_bos)=0)) THEN
                (SELECT CASE WHEN ( (id_j_bos IS NULL) OR (COUNT(id_j_bos)=0)) THEN
                (SELECT CASE WHEN ( (id_j_bos IS NULL) OR (COUNT(id_j_bos)=0)) THEN
                0
                ELSE  id_j_bos END AS id_j_bos FROM riwayat_mutasi_kerja rmk WHERE rmk.id_riwayat =
                (SELECT MAX(riwayat_mutasi_kerja.id_riwayat) AS idriwayat
                FROM riwayat_mutasi_kerja INNER JOIN sk ON sk.id_sk = riwayat_mutasi_kerja.id_sk
                WHERE sk.id_pegawai = p.id_pegawai AND sk.id_kategori_sk = 18 AND riwayat_mutasi_kerja.id_pegawai = p.id_pegawai
                GROUP BY riwayat_mutasi_kerja.id_pegawai
                ORDER BY tmt DESC LIMIT 1))
                ELSE  id_j_bos END AS id_j_bos FROM riwayat_mutasi_kerja rmk WHERE rmk.id_riwayat =
                (SELECT MAX(riwayat_mutasi_kerja.id_riwayat) AS idriwayat
                FROM riwayat_mutasi_kerja INNER JOIN sk ON sk.id_sk = riwayat_mutasi_kerja.id_sk
                WHERE sk.id_pegawai = p.id_pegawai AND (sk.id_kategori_sk = 52 OR sk.id_kategori_sk = 23) AND riwayat_mutasi_kerja.id_pegawai = p.id_pegawai
                GROUP BY riwayat_mutasi_kerja.id_pegawai
                ORDER BY tmt DESC LIMIT 1))
                ELSE  id_j_bos END AS id_j_bos FROM riwayat_mutasi_kerja rmk WHERE rmk.id_riwayat =
                (SELECT MAX(riwayat_mutasi_kerja.id_riwayat) AS idriwayat
                FROM riwayat_mutasi_kerja INNER JOIN sk ON sk.id_sk = riwayat_mutasi_kerja.id_sk
                WHERE sk.id_pegawai = p.id_pegawai AND sk.id_kategori_sk = 55 AND riwayat_mutasi_kerja.id_pegawai = p.id_pegawai
                GROUP BY riwayat_mutasi_kerja.id_pegawai
                ORDER BY tmt DESC LIMIT 1))
                ELSE  id_j_bos END AS id_j_bos FROM riwayat_mutasi_kerja rmk WHERE rmk.id_riwayat =
                (SELECT MAX(riwayat_mutasi_kerja.id_riwayat) AS idriwayat
                FROM riwayat_mutasi_kerja INNER JOIN sk ON sk.id_sk = riwayat_mutasi_kerja.id_sk
                WHERE sk.id_pegawai = p.id_pegawai AND sk.id_kategori_sk = 21 AND riwayat_mutasi_kerja.id_pegawai = p.id_pegawai
                GROUP BY riwayat_mutasi_kerja.id_pegawai
                ORDER BY tmt DESC LIMIT 1))
                ELSE  id_j_bos END AS id_j_bos FROM riwayat_mutasi_kerja rmk WHERE rmk.id_riwayat =
                (SELECT MAX(riwayat_mutasi_kerja.id_riwayat) AS idriwayat
                FROM riwayat_mutasi_kerja INNER JOIN sk ON sk.id_sk = riwayat_mutasi_kerja.id_sk
                WHERE sk.id_pegawai = p.id_pegawai AND sk.id_kategori_sk = 12 AND riwayat_mutasi_kerja.id_pegawai = p.id_pegawai
                GROUP BY riwayat_mutasi_kerja.id_pegawai
                ORDER BY tmt DESC LIMIT 1))
                ELSE  id_j_bos END AS id_j_bos FROM riwayat_mutasi_kerja rmk WHERE rmk.id_riwayat =
                (SELECT MAX(riwayat_mutasi_kerja.id_riwayat) AS idriwayat
                FROM riwayat_mutasi_kerja INNER JOIN sk ON sk.id_sk = riwayat_mutasi_kerja.id_sk
                WHERE sk.id_pegawai = p.id_pegawai AND sk.id_kategori_sk = 10 AND riwayat_mutasi_kerja.id_pegawai = p.id_pegawai
                GROUP BY riwayat_mutasi_kerja.id_pegawai
                ORDER BY tmt DESC LIMIT 1))
                ELSE  id_j_bos END AS id_j_bos FROM riwayat_mutasi_kerja rmk WHERE rmk.id_riwayat =
                (SELECT MAX(riwayat_mutasi_kerja.id_riwayat) AS idriwayat
                FROM riwayat_mutasi_kerja INNER JOIN sk ON sk.id_sk = riwayat_mutasi_kerja.id_sk
                WHERE sk.id_pegawai = p.id_pegawai AND sk.id_kategori_sk = 9 AND riwayat_mutasi_kerja.id_pegawai = p.id_pegawai
                GROUP BY riwayat_mutasi_kerja.id_pegawai
                ORDER BY tmt DESC LIMIT 1))
                ELSE  id_j_bos END AS id_j_bos FROM riwayat_mutasi_kerja rmk WHERE rmk.id_riwayat =
                (SELECT MAX(riwayat_mutasi_kerja.id_riwayat) AS idriwayat
                FROM riwayat_mutasi_kerja INNER JOIN sk ON sk.id_sk = riwayat_mutasi_kerja.id_sk
                WHERE sk.id_pegawai = p.id_pegawai AND sk.id_kategori_sk = 7 AND riwayat_mutasi_kerja.id_pegawai = p.id_pegawai
                GROUP BY riwayat_mutasi_kerja.id_pegawai
                ORDER BY tmt DESC LIMIT 1))
                ELSE  id_j_bos END AS id_j_bos FROM riwayat_mutasi_kerja rmk WHERE rmk.id_riwayat =
                (SELECT MAX(riwayat_mutasi_kerja.id_riwayat) AS idriwayat
                FROM riwayat_mutasi_kerja INNER JOIN sk ON sk.id_sk = riwayat_mutasi_kerja.id_sk
                WHERE sk.id_pegawai = p.id_pegawai AND sk.id_kategori_sk = 6 AND riwayat_mutasi_kerja.id_pegawai = p.id_pegawai
                GROUP BY riwayat_mutasi_kerja.id_pegawai
                ORDER BY tmt DESC LIMIT 1))
                ELSE  id_j_bos END AS id_j_bos FROM riwayat_mutasi_kerja rmk WHERE rmk.id_riwayat =
                (SELECT MAX(riwayat_mutasi_kerja.id_riwayat) AS idriwayat
                FROM riwayat_mutasi_kerja INNER JOIN sk ON sk.id_sk = riwayat_mutasi_kerja.id_sk
                WHERE sk.id_pegawai = p.id_pegawai AND sk.id_kategori_sk = 5 AND riwayat_mutasi_kerja.id_pegawai = p.id_pegawai
                GROUP BY riwayat_mutasi_kerja.id_pegawai
                ORDER BY tmt DESC LIMIT 1))
                ELSE  id_j_bos END AS id_j_bos FROM riwayat_mutasi_kerja rmk WHERE rmk.id_riwayat =
                (SELECT MAX(riwayat_mutasi_kerja.id_riwayat) AS idriwayat
                FROM riwayat_mutasi_kerja INNER JOIN sk ON sk.id_sk = riwayat_mutasi_kerja.id_sk
                WHERE sk.id_pegawai = p.id_pegawai AND sk.id_kategori_sk = 1 AND riwayat_mutasi_kerja.id_pegawai = p.id_pegawai
                GROUP BY riwayat_mutasi_kerja.id_pegawai
                ORDER BY tmt DESC LIMIT 1))
                ) ELSE j.id_bos END AS id_bos_atsl
                FROM pegawai p LEFT JOIN jabatan j ON p.id_j = j.id_j
                LEFT JOIN (
                SELECT b.id_pegawai, jm.id_jfu as kode_jabatan_jfu, jm.kelas_jabatan as kelas_jabatan_jfu,
                jm.nilai_jabatan as nilai_jabatan_jfu, jm.nama_jfu
                FROM (SELECT a.*, jp.id_jfu FROM
                (SELECT jp.id_pegawai, MAX(jp.id) as id_jfu_pegawai FROM jfu_pegawai jp,
                (SELECT id_pegawai, MAX(tmt) as max_tmt FROM jfu_pegawai WHERE tmt IS NOT NULL GROUP BY id_pegawai) x
                WHERE jp.id_pegawai = x.id_pegawai AND jp.tmt = x.max_tmt
                GROUP BY jp.id_pegawai) a
                INNER JOIN jfu_pegawai jp ON a.id_jfu_pegawai = jp.id) b
                INNER JOIN jfu_master jm ON b.id_jfu = jm.id_jfu) jfu ON jfu.id_pegawai = p.id_pegawai 
                LEFT JOIN (
                SELECT b.id_pegawai, jm.id_jafung as kode_jabatan_jafung, jm.kelas_jabatan as kelas_jabatan_jafung,
                jm.nilai_jabatan as nilai_jabatan_jafung, jm.nama_jafung
                FROM (SELECT a.*, jp.id_jafung FROM
                (SELECT jp.id_pegawai, MAX(jp.id) as id_jafung_pegawai FROM jafung_pegawai jp,
                (SELECT id_pegawai, MAX(tmt) as max_tmt FROM jafung_pegawai WHERE tmt IS NOT NULL GROUP BY id_pegawai) x
                WHERE jp.id_pegawai = x.id_pegawai AND jp.tmt = x.max_tmt
                GROUP BY jp.id_pegawai) a
                INNER JOIN jafung_pegawai jp ON a.id_jafung_pegawai = jp.id) b
                INNER JOIN jafung jm ON b.id_jafung = jm.id_jafung) jafung ON jafung.id_pegawai = p.id_pegawai, current_lokasi_kerja clk, unit_kerja uk
                WHERE p.id_pegawai = clk.id_pegawai AND clk.id_unit_kerja = uk.id_unit_kerja AND uk.id_skpd = AES_DECRYPT(UNHEX('$id_skpd_enc'),SHA2('keyloginekinerja',512))
                AND p.flag_pensiun = 0 $andKlause 
                ORDER BY eselon ASC, p.pangkat_gol DESC, p.nama) a, unit_kerja uk
                WHERE a.id_skpd = uk.id_unit_kerja) b LEFT JOIN pegawai p ON b.id_bos_atsl = p.id_j
                LEFT JOIN unit_kerja uk_dinkes ON b.id_skpd = uk_dinkes.id_unit_kerja AND uk_dinkes.tahun = (SELECT MAX(tahun) FROM unit_kerja) AND uk_dinkes.nama_baru LIKE '%Dinas Kesehatan%'
                LEFT JOIN unit_kerja uk_labkesda ON b.id_unit_kerja = uk_labkesda.id_unit_kerja AND uk_labkesda.tahun = (SELECT MAX(tahun) FROM unit_kerja) AND uk_labkesda.nama_baru LIKE '%UPTD Laboratorium Kesehatan Daerah%') z
                WHERE z.id_pegawai_atasan = AES_DECRYPT(UNHEX('$id_pegawai_enc'),SHA2('keyloginekinerja',512)) AND z.cek = 1 AND z.id_pegawai_atasan <> z.id_pegawai ORDER BY z.nama ASC) ax LEFT JOIN
                knj_kinerja_master kkm ON ax.id_pegawai = kkm.id_pegawai_pelapor AND
                kkm.periode_bln = MONTH(NOW()) AND kkm.periode_thn = YEAR(NOW())
                LEFT JOIN knj_status_kinerja ksk ON kkm.id_status_knj = ksk.id_status_knj 
                ORDER BY ax.nama";
        return $this->db->query($sql);
    }

    public function jumlah_peninjauan_kegiatan_staf($idstatus, $txtKeyword, $id_knj_master, $id_pegawai_atsl_enc, $keyApps){
        $andKlausa = '';
        if($idstatus!='0'){
            if($idstatus==4){
                $andKlausa .= " AND kkk.approved IS NULL ";
            }else {
                $andKlausa .= " AND kkk.approved = " . $idstatus;
            }
        }

        if (!(trim($txtKeyword)== "") && !(trim($txtKeyword)== "0")){
            $andKlausa .= " AND (kkk.kegiatan_keterangan LIKE '%".$txtKeyword."%'
								OR kkk.kegiatan_rincian LIKE '%".$txtKeyword."%'
								OR kkk.satuan LIKE '%".$txtKeyword."%'
								OR st.uraian_tugas LIKE '%".$txtKeyword."%')";
        }

        $sql = "SELECT COUNT(*) AS jumlah  
                FROM knj_kinerja_master kkm
                INNER JOIN knj_kinerja_historis_alih_tugas kkh ON kkm.id_knj_master = kkh.id_knj_master
                INNER JOIN knj_kinerja_kegiatan kkk ON kkh.idknj_hist_alih_tugas = kkk.idknj_hist_alih_tugas
                LEFT JOIN skp_target st ON kkk.kegiatan_kategori_id = st.id_skp_target
                WHERE /*kkm.periode_thn = YEAR(NOW()) AND kkm.periode_bln = MONTH(NOW()) AND*/ kkh.atsl_idp = AES_DECRYPT(UNHEX('$id_pegawai_atsl_enc'), SHA2('keyloginekinerja',512))
                AND kkm.id_knj_master = AES_DECRYPT(UNHEX('$id_knj_master'), SHA2('$keyApps',512))  
                $andKlausa";
        return $this->db->query($sql);
    }

    public function list_peninjauan_kegiatan_staf($row_number_start, $idstatus, $txtKeyword, $id_knj_master, $id_pegawai_atsl_enc, $limit, $keyApps){
        $andKlausa = '';
        if($idstatus!='0'){
            if($idstatus==4){
                $andKlausa .= " AND kkk.approved IS NULL ";
            }else {
                $andKlausa .= " AND kkk.approved = " . $idstatus;
            }
        }

        if (!(trim($txtKeyword)== "") && !(trim($txtKeyword)== "0")){
            $andKlausa .= " AND (kkk.kegiatan_keterangan LIKE '%".$txtKeyword."%'
								OR kkk.kegiatan_rincian LIKE '%".$txtKeyword."%'
								OR kkk.satuan LIKE '%".$txtKeyword."%'
								OR st.uraian_tugas LIKE '%".$txtKeyword."%')";
        }

        $this->db->query("SET @row_number := $row_number_start");
        $sql = "SELECT FCN_ROW_NUMBER() as no_urut, a.*, p.nip_baru, CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
                nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(' ',p.gelar_belakang) END) AS nama  
                FROM (SELECT kkk.*, (CASE WHEN (st.uraian_tugas = '' OR st.uraian_tugas IS NULL) THEN 
                (CASE WHEN kkk.kegiatan_kategori_id = -1 THEN 'Tugas Tambahan' ELSE
                (CASE WHEN kkk.kegiatan_kategori_id = -4 THEN 'Tugas Tambahan Khusus' ELSE
                (CASE WHEN kkk.kegiatan_kategori_id = -2 THEN 'Instruksi Khusus Pimpinan (IKP) khusus JPT' ELSE
                (CASE WHEN kkk.kegiatan_kategori_id = -3 THEN 'Penyesuaian Target Baru' ELSE '' END) END) END) END) ELSE st.uraian_tugas END) as uraian_tugas, 
                DATE_FORMAT(kkk.kegiatan_tanggal, '%d-%m-%Y %H:%i:%s') AS tgl_kegiatan,
                DATE_FORMAT(kkk.tgl_input, '%d-%m-%Y %H:%i:%s') AS tgl_entri,
                (CASE WHEN approved IS NULL THEN NULL ELSE DATE_FORMAT(kkk.tgl_approved, '%d-%m-%Y %H:%i:%s') END) AS tgl_approved2, 
                HEX(AES_ENCRYPT(kkk.id_knj_kegiatan,SHA2($keyApps,512))) AS id_knj_kegiatan_enc, kkh.atsl_nip, 
                kkh.atsl_nama_plh, kkh.atsl_nip_plh, kkh.atsl_jabatan_plh 
                FROM knj_kinerja_master kkm
                INNER JOIN knj_kinerja_historis_alih_tugas kkh ON kkm.id_knj_master = kkh.id_knj_master
                INNER JOIN knj_kinerja_kegiatan kkk ON kkh.idknj_hist_alih_tugas = kkk.idknj_hist_alih_tugas
                LEFT JOIN skp_target st ON kkk.kegiatan_kategori_id = st.id_skp_target
                WHERE /*kkm.periode_thn = YEAR(NOW()) AND kkm.periode_bln = MONTH(NOW()) AND*/ kkh.atsl_idp = AES_DECRYPT(UNHEX('$id_pegawai_atsl_enc'), SHA2('keyloginekinerja',512))
                AND kkm.id_knj_master = AES_DECRYPT(UNHEX('$id_knj_master'), SHA2('$keyApps',512))  
                $andKlausa ORDER BY kkk.kegiatan_tanggal DESC) a
                LEFT JOIN pegawai p ON a.id_pegawai_approved = p.id_pegawai $limit";
        return $this->db->query($sql);
    }

    public function jumlah_aktifitas_by_periode($bln, $thn, $txtKeyword, $id_pegawai){
        $andKlausa = '';
        if($bln!='0'){
            $andKlausa .= " AND kkm.periode_bln = ".$bln;
        }
        if($thn!='0'){
            $andKlausa .= " AND kkm.periode_thn = ".$thn;
        }
        if (!(trim($txtKeyword)== "") && !(trim($txtKeyword)== "0")){
            $andKlausa .= " AND (kkk.kegiatan_keterangan LIKE '%".$txtKeyword."%'
								OR kkk.kegiatan_rincian LIKE '%".$txtKeyword."%'
								OR kkk.satuan LIKE '%".$txtKeyword."%'
								OR st.uraian_tugas LIKE '%".$txtKeyword."%')".$andKlausa;
        }
        $sql = "SELECT COUNT(*) AS jumlah
                FROM knj_kinerja_master kkm
                INNER JOIN knj_kinerja_historis_alih_tugas kkh ON kkm.id_knj_master = kkh.id_knj_master
                INNER JOIN knj_kinerja_kegiatan kkk ON kkh.idknj_hist_alih_tugas = kkk.idknj_hist_alih_tugas
                LEFT JOIN skp_target st ON kkk.kegiatan_kategori_id = st.id_skp_target
                WHERE kkm.id_knj_master IS NOT NULL AND kkm.id_pegawai_pelapor = AES_DECRYPT(UNHEX('$id_pegawai'), SHA2('keyloginekinerja',512))
                $andKlausa";
        return $this->db->query($sql);
    }

    public function list_aktifitas_by_periode($row_number_start, $bln, $thn, $txtKeyword, $id_pegawai, $limit){
        $andKlausa = '';
        if($bln!='0'){
            $andKlausa .= " AND kkm.periode_bln = ".$bln;
        }
        if($thn!='0'){
            $andKlausa .= " AND kkm.periode_thn = ".$thn;
        }
        if (!(trim($txtKeyword)== "") && !(trim($txtKeyword)== "0")){
            $andKlausa .= " AND (kkk.kegiatan_keterangan LIKE '%".$txtKeyword."%'
								OR kkk.kegiatan_rincian LIKE '%".$txtKeyword."%'
								OR kkk.satuan LIKE '%".$txtKeyword."%'
								OR st.uraian_tugas LIKE '%".$txtKeyword."%')".$andKlausa;
        }
        $this->db->query("SET @row_number := $row_number_start");
        $sql = "SELECT kkm.periode_bln, kkm.periode_thn, kkk.*, (CASE WHEN (st.uraian_tugas = '' OR st.uraian_tugas IS NULL) THEN 
                (CASE WHEN kkk.kegiatan_kategori_id = -1 THEN 'Tugas Tambahan' ELSE
                (CASE WHEN kkk.kegiatan_kategori_id = -4 THEN 'Tugas Tambahan Khusus' ELSE
                (CASE WHEN kkk.kegiatan_kategori_id = -2 THEN 'Instruksi Khusus Pimpinan (IKP) khusus JPT' ELSE
                (CASE WHEN kkk.kegiatan_kategori_id = -3 THEN 'Penyesuaian Target Baru' ELSE '' END) END) END) END) ELSE st.uraian_tugas END) as uraian_tugas,
                DATE_FORMAT(kkk.kegiatan_tanggal, '%d-%m-%Y %H:%i:%s') AS tgl_kegiatan,
                DATE_FORMAT(kkk.tgl_input, '%d-%m-%Y %H:%i:%s') AS tgl_entri,
                (CASE WHEN approved IS NULL THEN 'Belum diproses' ELSE (CASE WHEN approved = 1 THEN 'Disetujui' ELSE 'Ditolak' END) END) AS sts_approved,
                (CASE WHEN approved IS NULL THEN NULL ELSE DATE_FORMAT(kkk.tgl_approved, '%d-%m-%Y %H:%i:%s') END) AS tgl_approved2,
                (CASE WHEN approved IS NULL THEN NULL ELSE (kkk.catatan_approved) END) AS cttn_approved 
                FROM knj_kinerja_master kkm
                INNER JOIN knj_kinerja_historis_alih_tugas kkh ON kkm.id_knj_master = kkh.id_knj_master
                INNER JOIN knj_kinerja_kegiatan kkk ON kkh.idknj_hist_alih_tugas = kkk.idknj_hist_alih_tugas
                LEFT JOIN skp_target st ON kkk.kegiatan_kategori_id = st.id_skp_target
                WHERE kkm.id_knj_master IS NOT NULL AND kkm.id_pegawai_pelapor = AES_DECRYPT(UNHEX('$id_pegawai'), SHA2('keyloginekinerja',512))
                $andKlausa
                ORDER BY kkk.kegiatan_tanggal DESC $limit";
        return $this->db->query($sql);
    }

    public function updateAktifitasKegiatanById($data, $keyApps){
        $id_knj_kegiatan = $data['id_knj_kegiatan'];
        $idstatus = ($data['idstatus']==0?'NULL':$data['idstatus']);
        $tgl_update = ($data['idstatus']==0?'NULL':'NOW()');
        $idpegawai = ($data['idstatus']==0?'NULL':$data['id_pegawai']);
        $ket_approval = ($data['idstatus']==0?'NULL':"'".$data['ket_approval']."'");

        $this->db->trans_begin();
        $sql = "UPDATE knj_kinerja_kegiatan SET approved = $idstatus, tgl_approved = $tgl_update, 
                catatan_approved = $ket_approval, id_pegawai_approved = AES_DECRYPT(UNHEX('$idpegawai'),SHA2('keyloginekinerja',512)) 
                WHERE id_knj_kegiatan = AES_DECRYPT(UNHEX('$id_knj_kegiatan'),SHA2($keyApps,512))";

        $this->db->query($sql);
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return 0;
        }else{
            if($idstatus==0){
                $this->db->trans_commit();
                return 1;
            }else{
                $sql2 = "INSERT INTO knj_kinerja_historis_approve(tgl_approved, approved,
                    id_pegawai_approved, catatan_approved, id_knj_kegiatan) 
                    VALUES (NOW(), $idstatus, AES_DECRYPT(UNHEX('$idpegawai'),SHA2('keyloginekinerja',512)), $ket_approval, 
                    AES_DECRYPT(UNHEX('$id_knj_kegiatan'),SHA2($keyApps,512)))";
                $this->db->query($sql2);
                if ($this->db->trans_status() === FALSE) {
                    $this->db->trans_rollback();
                    return 0;
                }else{
                    $this->db->trans_commit();
                    return 1;
                }
            }
        }
    }

    public function kegiatan_staf_by_id($id_knj_kegiatan, $keyApps){
        $sql = "SELECT a.*, p.nip_baru, CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
                nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(' ',p.gelar_belakang) END) AS nama FROM 
                (SELECT kkk.*, st.uraian_tugas, DATE_FORMAT(kkk.kegiatan_tanggal, '%d-%m-%Y
                %H:%i:%s') AS tgl_kegiatan, DATE_FORMAT(kkk.tgl_input, '%d-%m-%Y %H:%i:%s')
                AS tgl_entri, (CASE WHEN approved IS NULL THEN 'Belum diproses' ELSE (CASE
                WHEN approved = 1 THEN 'Disetujui' ELSE 'Ditolak' END) END) AS sts_approved,
                (CASE WHEN approved IS NULL THEN NULL ELSE DATE_FORMAT(kkk.tgl_approved,
                '%d-%m-%Y %H:%i:%s') END) AS tgl_approved2, (CASE WHEN approved IS NULL
                THEN NULL ELSE (kkk.catatan_approved) END) AS cttn_approved,
                HEX(AES_ENCRYPT(kkk.id_knj_kegiatan,SHA2($keyApps,512))) AS id_knj_kegiatan_enc 
                FROM knj_kinerja_master
                kkm INNER JOIN knj_kinerja_historis_alih_tugas kkh ON kkm.id_knj_master
                = kkh.id_knj_master INNER JOIN knj_kinerja_kegiatan kkk ON kkh.idknj_hist_alih_tugas
                = kkk.idknj_hist_alih_tugas LEFT JOIN skp_target st ON kkk.kegiatan_kategori_id
                = st.id_skp_target WHERE kkk.id_knj_kegiatan = AES_DECRYPT(UNHEX('$id_knj_kegiatan'),SHA2($keyApps,512))) a 
                LEFT JOIN pegawai p ON a.id_pegawai_approved = p.id_pegawai";
        return $this->db->query($sql);
    }

    public function prosesPeninjauanAktifitasByChecklist($data, $keyApps){
        $this->db->trans_begin();
        $idstatus = ($data['idstatus']==4?'NULL':$data['idstatus']);
        $tgl_update = ($data['idstatus']==4?'NULL':'NOW()');
        $idpegawai = ($data['idstatus']==4?'NULL':$data['id_pegawai_enc']);
        foreach( $data['chkAktifitas'] as $key => $n ) {
            $sql = "UPDATE knj_kinerja_kegiatan SET approved = $idstatus, tgl_approved = $tgl_update, 
                    catatan_approved = NULL, id_pegawai_approved = AES_DECRYPT(UNHEX('$idpegawai'),SHA2('keyloginekinerja',512)) 
                    WHERE id_knj_kegiatan = AES_DECRYPT(UNHEX('".$data['chkAktifitas'][$key]."'),SHA2($keyApps,512))";
            $this->db->query($sql);
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
            }else{
                if($idstatus==0){
                    $this->db->trans_commit();
                }else{
                    $sql2 = "INSERT INTO knj_kinerja_historis_approve(tgl_approved, approved,
                    id_pegawai_approved, catatan_approved, id_knj_kegiatan) 
                    VALUES (NOW(), $idstatus, AES_DECRYPT(UNHEX('$idpegawai'),SHA2('keyloginekinerja',512)), '', 
                    AES_DECRYPT(UNHEX('".$data['chkAktifitas'][$key]."'),SHA2($keyApps,512)))";
                    $this->db->query($sql2);
                    if ($this->db->trans_status() === FALSE) {
                        $this->db->trans_rollback();
                    }else{
                        $this->db->trans_commit();
                    }
                }
            }

        }
        if ($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            return 0;
        }else{
            $this->db->trans_commit();
            return 1;
        }
    }

    public function deteksiJabatanTinggiPratamaAdminKepala($id_j){
        $sql = "SELECT COUNT(a.id_j_p) as jumlah FROM
                (SELECT $id_j as id_j_p) a INNER JOIN
                (SELECT j.id_j, j.jabatan, j.eselon, j.tahun FROM jabatan j 
                WHERE ((j.tahun = (SELECT MAX(tahun) FROM jabatan) AND (j.jabatan LIKE 'Camat%' OR j.jabatan LIKE '%Kepala Kantor%')) OR 
                ((j.tahun = (SELECT MAX(tahun) FROM jabatan) AND (j.eselon = 'IIA' OR j.eselon = 'IIB')))) AND j.jabatan NOT LIKE '%Direktur%'
                ORDER BY j.eselon, j.jabatan) b ON a.id_j_p = b.id_j";
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

    public function getLastTimeKegiatanByPeriode($id_pegawai, $bln, $thn){
        $sql = "SELECT a.*, DATE_FORMAT(a.kegiatan_durasi, '%d-%m-%Y %H:%i:%s') AS kegiatan_durasi FROM 
                (SELECT kkk.kegiatan_tanggal as kegiatan_terakhir, kkk.durasi_menit,
                DATE_ADD(kkk.kegiatan_tanggal, INTERVAL kkk.durasi_menit MINUTE) as kegiatan_durasi
                FROM knj_kinerja_master kkm
                INNER JOIN knj_kinerja_historis_alih_tugas kkh ON kkm.id_knj_master = kkh.id_knj_master
                INNER JOIN knj_kinerja_kegiatan kkk ON kkh.idknj_hist_alih_tugas = kkk.idknj_hist_alih_tugas
                WHERE kkm.id_pegawai_pelapor = AES_DECRYPT(UNHEX('$id_pegawai'),SHA2('keyloginekinerja',512)) AND MONTH(kkk.kegiatan_tanggal) = $bln AND YEAR(kkk.kegiatan_tanggal) = $thn
                ORDER BY kkk.kegiatan_tanggal DESC LIMIT 0,1) a";
        return $this->db->query($sql);
    }

    public function getNomorPonsel($id_pegawai_enc){
        $sql = "SELECT p.nip_baru, CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
                nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(' ',p.gelar_belakang) END) AS nama, 
                CONCAT('62', SUBSTRING(p.ponsel, 2, LENGTH(p.ponsel)-1)) as ponsel FROM pegawai p
                WHERE p.id_pegawai = AES_DECRYPT(UNHEX('$id_pegawai_enc'),SHA2('keyloginekinerja',512))";
        $query = $this->db->query($sql);
        $rowcount = $query->num_rows();
        if($rowcount > 0) {
            $data = $query->result();
        }else{
            $data = 0;
        }
        return $data;
    }

    public function get_kegiatan_tosend_info_whatsapp($id_knj_kegiatan, $keyApps){
        $sql = "SELECT (CASE WHEN st.uraian_tugas IS NULL THEN 
                (CASE WHEN kkk.kegiatan_kategori_id = -1 THEN 'Tugas Tambahan' ELSE
                (CASE WHEN kkk.kegiatan_kategori_id = -4 THEN 'Tugas Tambahan Khusus' ELSE
                (CASE WHEN kkk.kegiatan_kategori_id = -2 THEN 'Instruksi Khusus Pimpinan (IKP) khusus JPT' ELSE
                (CASE WHEN kkk.kegiatan_kategori_id = -3 THEN 'Penyesuaian Target Baru' ELSE '' END) END) END) END) ELSE st.uraian_tugas END) AS skp, DATE_FORMAT(kkk.kegiatan_tanggal, '%d-%m-%Y %H:%i:%s') AS kegiatan_tanggal, kkk.kegiatan_rincian, kkk.kegiatan_keterangan, 
                kkk.durasi_menit, kkk.kuantitas, kkk.satuan, CONCAT('62', SUBSTRING(p.ponsel, 2, LENGTH(p.ponsel)-1)) as ponsel_atasan, CONCAT('62', SUBSTRING(p2.ponsel, 2, LENGTH(p2.ponsel)-1)) as ponsel_pegawai, p2.nip_baru, 
                CONCAT(CASE WHEN p2.gelar_depan = '' THEN '' ELSE CONCAT(p2.gelar_depan, ' ') END,
                p2.nama, CASE WHEN p2.gelar_belakang = '' THEN '' ELSE CONCAT(' ',p2.gelar_belakang) END) AS nama,
                HEX(AES_ENCRYPT(kkm.id_knj_master,SHA2($keyApps,512))) AS id_knj_kegiatan_enc 
                FROM knj_kinerja_kegiatan kkk 
                LEFT JOIN skp_target st ON kkk.kegiatan_kategori_id = st.id_skp_target
                LEFT JOIN knj_kinerja_historis_alih_tugas kkh ON kkk.idknj_hist_alih_tugas = kkh.idknj_hist_alih_tugas
                LEFT JOIN knj_kinerja_master kkm ON kkh.id_knj_master = kkm.id_knj_master
                LEFT JOIN pegawai p ON kkh.atsl_idp = p.id_pegawai 
                LEFT JOIN pegawai p2 ON kkm.id_pegawai_pelapor = p2.id_pegawai
                WHERE kkk.id_knj_kegiatan = AES_DECRYPT(UNHEX('$id_knj_kegiatan'),SHA2($keyApps,512))";
        return $this->db->query($sql);
    }

    public function jumlah_pegawai_info_tipe_unit($id_skpd, $keyword){
        $andKlausa = '';
        if($keyword != ''){
            $andKlausa = " AND (p.nip_baru LIKE '%$keyword%' OR p.nama LIKE '%$keyword%')";
        }

        $sql = "SELECT COUNT(b.id_pegawai) AS jumlah FROM 
                (SELECT a.*, p.nip_baru as nip_updater, CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
                p.nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(' ',p.gelar_belakang) END) AS nama_updater,
                COUNT(clkl.id_aja_lain) as jumlah_unit_sekunder
                FROM
                (SELECT p.id_pegawai, p.nip_baru, CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
                nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(' ',p.gelar_belakang) END) AS nama,
                p.jenjab, p.pangkat_gol, CASE WHEN j.eselon IS NULL THEN 'Staf' ELSE j.eselon END AS eselon,
                CASE WHEN p.jenjab = 'Fungsional' THEN (jafung.kode_jabatan_jafung) ELSE
                CASE WHEN p.id_j IS NULL THEN (jfu.kode_jabatan_jfu) ELSE j.id_j END END AS kode_jabatan,
                CASE WHEN p.jenjab = 'Fungsional' THEN (jafung.kelas_jabatan_jafung) ELSE
                CASE WHEN p.id_j IS NULL THEN (jfu.kelas_jabatan_jfu) ELSE j.kelas_jabatan END END AS kelas_jabatan,
                CASE WHEN p.jenjab = 'Fungsional' THEN (jafung.nilai_jabatan_jafung) ELSE
                CASE WHEN p.id_j IS NULL THEN (jfu.nilai_jabatan_jfu) ELSE j.nilai_jabatan END END AS nilai_jabatan,
                CASE WHEN p.jenjab = 'Fungsional' THEN (CASE WHEN jafung.nama_jafung IS NULL THEN p.jabatan ELSE jafung.nama_jafung END) ELSE
                CASE WHEN p.id_j IS NULL THEN (jfu.nama_jfu) ELSE j.jabatan END END AS jabatan,
                uk.nama_baru as unit_primer, p.status_aktif, clk.flag_lokasi_multiple,
                DATE_FORMAT(clk.last_tgl_update_flag_lokasi, '%d-%m-%Y %H:%i:%s') AS last_tgl_update_flag_lokasi,
                clk.last_updater_flag_lokasi
                FROM pegawai p LEFT JOIN jabatan j ON p.id_j = j.id_j
                LEFT JOIN (
                SELECT b.id_pegawai, jm.id_jfu as kode_jabatan_jfu, jm.kelas_jabatan as kelas_jabatan_jfu,
                jm.nilai_jabatan as nilai_jabatan_jfu, jm.nama_jfu
                FROM (SELECT a.*, jp.id_jfu FROM
                (SELECT jp.id_pegawai, MAX(jp.id) as id_jfu_pegawai FROM jfu_pegawai jp,
                (SELECT id_pegawai, MAX(tmt) as max_tmt FROM jfu_pegawai WHERE tmt IS NOT NULL GROUP BY id_pegawai) x
                WHERE jp.id_pegawai = x.id_pegawai AND jp.tmt = x.max_tmt
                GROUP BY jp.id_pegawai) a
                INNER JOIN jfu_pegawai jp ON a.id_jfu_pegawai = jp.id) b
                INNER JOIN jfu_master jm ON b.id_jfu = jm.id_jfu) jfu ON jfu.id_pegawai = p.id_pegawai
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
                LEFT JOIN current_lokasi_kerja clk ON p.id_pegawai = clk.id_pegawai
                LEFT JOIN unit_kerja uk ON clk.id_unit_kerja = uk.id_unit_kerja
                WHERE p.flag_pensiun = 0 AND uk.id_skpd = AES_DECRYPT(UNHEX('$id_skpd'),SHA2('keyloginekinerja',512)) $andKlausa) a
                LEFT JOIN pegawai p ON a.last_updater_flag_lokasi = p.id_pegawai
                LEFT JOIN current_lokasi_kerja_lain clkl ON a.id_pegawai = clkl.id_pegawai
                GROUP BY a.id_pegawai ORDER BY eselon ASC, pangkat_gol DESC, nama) b";
        return $this->db->query($sql);
    }

    public function list_pegawai_info_tipe_unit($row_number_start, $id_skpd, $keyword, $limit){
        $andKlausa = '';
        if($keyword != ''){
            $andKlausa = " AND (p.nip_baru LIKE '%$keyword%' OR p.nama LIKE '%$keyword%')";
        }

        $this->db->query("SET @row_number := $row_number_start");
        $sql = "SELECT a.*, p.nip_baru as nip_updater, CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
                p.nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(' ',p.gelar_belakang) END) AS nama_updater,
                COUNT(clkl.id_aja_lain) as jumlah_unit_sekunder, HEX(AES_ENCRYPT(a.id_pegawai,SHA2('keyloginekinerja',512))) AS id_pegawai_enc 
                FROM 
                (SELECT p.id_pegawai, p.nip_baru, CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
                nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(' ',p.gelar_belakang) END) AS nama,
                p.jenjab, p.pangkat_gol, CASE WHEN j.eselon IS NULL THEN 'Staf' ELSE j.eselon END AS eselon, 
                CASE WHEN p.jenjab = 'Fungsional' THEN (jafung.kode_jabatan_jafung) ELSE 
                CASE WHEN p.id_j IS NULL THEN (jfu.kode_jabatan_jfu) ELSE j.id_j END END AS kode_jabatan,
                CASE WHEN p.jenjab = 'Fungsional' THEN (jafung.kelas_jabatan_jafung) ELSE 
                CASE WHEN p.id_j IS NULL THEN (jfu.kelas_jabatan_jfu) ELSE j.kelas_jabatan END END AS kelas_jabatan,
                CASE WHEN p.jenjab = 'Fungsional' THEN (jafung.nilai_jabatan_jafung) ELSE 
                CASE WHEN p.id_j IS NULL THEN (jfu.nilai_jabatan_jfu) ELSE j.nilai_jabatan END END AS nilai_jabatan,
                CASE WHEN p.jenjab = 'Fungsional' THEN (CASE WHEN jafung.nama_jafung IS NULL THEN p.jabatan ELSE jafung.nama_jafung END) ELSE
                CASE WHEN p.id_j IS NULL THEN (jfu.nama_jfu) ELSE j.jabatan END END AS jabatan,
                uk.nama_baru as unit_primer, p.status_aktif, clk.flag_lokasi_multiple,
                DATE_FORMAT(clk.last_tgl_update_flag_lokasi, '%d-%m-%Y %H:%i:%s') AS last_tgl_update_flag_lokasi,
                clk.last_updater_flag_lokasi
                FROM pegawai p LEFT JOIN jabatan j ON p.id_j = j.id_j
                LEFT JOIN (
                SELECT b.id_pegawai, jm.id_jfu as kode_jabatan_jfu, jm.kelas_jabatan as kelas_jabatan_jfu,
                jm.nilai_jabatan as nilai_jabatan_jfu, jm.nama_jfu
                FROM (SELECT a.*, jp.id_jfu FROM
                (SELECT jp.id_pegawai, MAX(jp.id) as id_jfu_pegawai FROM jfu_pegawai jp,
                (SELECT id_pegawai, MAX(tmt) as max_tmt FROM jfu_pegawai WHERE tmt IS NOT NULL GROUP BY id_pegawai) x
                WHERE jp.id_pegawai = x.id_pegawai AND jp.tmt = x.max_tmt
                GROUP BY jp.id_pegawai) a
                INNER JOIN jfu_pegawai jp ON a.id_jfu_pegawai = jp.id) b
                INNER JOIN jfu_master jm ON b.id_jfu = jm.id_jfu) jfu ON jfu.id_pegawai = p.id_pegawai
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
                LEFT JOIN current_lokasi_kerja clk ON p.id_pegawai = clk.id_pegawai
                LEFT JOIN unit_kerja uk ON clk.id_unit_kerja = uk.id_unit_kerja
                WHERE p.flag_pensiun = 0 AND uk.id_skpd = AES_DECRYPT(UNHEX('$id_skpd'),SHA2('keyloginekinerja',512)) $andKlausa) a
                LEFT JOIN pegawai p ON a.last_updater_flag_lokasi = p.id_pegawai
                LEFT JOIN current_lokasi_kerja_lain clkl ON a.id_pegawai = clkl.id_pegawai
                GROUP BY a.id_pegawai ORDER BY eselon ASC, pangkat_gol DESC, nama $limit";
        return $this->db->query($sql);
    }

    public function listof_knj_hist_alih_tugas_detail_calc_by_id_knj($id_knj, $keyApps){
        $sql = "SELECT kkh.*,
                HEX(AES_ENCRYPT(kkh.idknj_hist_alih_tugas,SHA2($keyApps,512))) as idknj_hist_alih_tugas_enc, 
                DATE_FORMAT(kkh.tgl_input, '%d-%m-%Y') AS tmt, kkm.periode_bln, kkm.periode_thn  
                FROM knj_kinerja_historis_alih_tugas kkh INNER JOIN knj_kinerja_master kkm
                ON kkh.id_knj_master = kkm.id_knj_master
                WHERE kkh.id_knj_master = AES_DECRYPT(UNHEX('$id_knj'),SHA2($keyApps,512))
                ORDER BY kkh.tgl_input ASC";
        return $this->db->query($sql);
    }

    public function detail_nilai_tunjangan_by_hist_alihtugas($idknj_hist_alih_tugas, $keyApps){
        $sql = "SELECT *, DAY(date_periode_knj) AS tanggal FROM knj_kinerja_tunjangan 
                WHERE idknj_hist_alih_tugas = AES_DECRYPT(UNHEX('$idknj_hist_alih_tugas'),SHA2($keyApps,512))
                AND DATE(date_periode_knj) <= DATE(NOW())";
        return $this->db->query($sql);
    }

    public function get_unit_kerja_utama($id_pegawai_enc, $keyApps){
        $sql = "SELECT a.*, uk.nama_baru AS opd, uk.in_lat as in_lat_opd, (CASE WHEN uk.alamat IS NULL = 1 THEN 'Belum ada data alamat' ELSE uk.alamat END) as alamat_opd,
                uk.in_long as in_long_opd, uk.out_lat as out_lat_opd, uk.out_long as out_long_opd FROM
                (SELECT p.id_pegawai, p.nip_baru, CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
                p.nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(' ',p.gelar_belakang) END) AS nama,
                HEX(AES_ENCRYPT(clk.id_aja,SHA2('$keyApps',512))) as id_clk, clk.flag_lokasi_multiple, 
                uk.id_unit_kerja, uk.nama_baru as unit_kerja, (CASE WHEN uk.alamat IS NULL = 1 THEN 'Belum ada data alamat' ELSE uk.alamat END) as alamat_unit, uk.in_lat as in_lat_unit,
                uk.in_long as in_long_unit, uk.out_lat as out_lat_unit, uk.out_long as out_long_unit, uk.id_skpd 
                FROM pegawai p LEFT JOIN current_lokasi_kerja clk ON p.id_pegawai = clk.id_pegawai 
                LEFT JOIN unit_kerja uk ON clk.id_unit_kerja = uk.id_unit_kerja 
                WHERE p.id_pegawai =
                AES_DECRYPT(UNHEX('$id_pegawai_enc'),SHA2('keyloginekinerja',512))) a
                LEFT JOIN unit_kerja uk ON a.id_skpd = uk.id_unit_kerja";
        return $this->db->query($sql);
    }

    public function get_unit_kerja_sekunder($id_pegawai_enc, $keyApps){
        $sql = "SELECT a.* FROM
                (SELECT HEX(AES_ENCRYPT(clkl.id_aja_lain,SHA2('$keyApps',512))) as id_clkl,
                clkl.tipe_unit_kerja_lain, clkl.id_unit_kerja_lain,
                clkl.no_spmt_unit_sekunder, clkl.tmt_spmt, clkl.berkas_spmt, clkl.tgl_input, clkl.inputer, p.nama, p.nip_baru,
                uks.nama as unit_sekunder, (CASE WHEN uks.alamat IS NULL = 1 THEN 'Belum ada data alamat' ELSE uks.alamat END) as alamat, uks.in_lat as in_lat_unit_sekunder,
                uks.in_long as in_long_unit_sekunder, uks.out_lat as out_lat_unit_sekunder, uks.out_long as out_long_unit_sekunder,
                uk.id_unit_kerja, uk.nama_baru as unit_kerja_utama, uks2.nama as induk_unit_sekunder
                FROM current_lokasi_kerja_lain clkl
                LEFT JOIN unit_kerja_sekunder uks ON clkl.id_unit_kerja_lain = uks.id_uk_sekunder
                LEFT JOIN unit_kerja uk ON uks.id_uk_primer = uk.id_unit_kerja
                LEFT JOIN unit_kerja_sekunder uks2 ON uks.id_uk_induk = uks2.id_uk_sekunder
                LEFT JOIN pegawai p ON clkl.inputer = p.id_pegawai
                WHERE clkl.id_pegawai = AES_DECRYPT(UNHEX('$id_pegawai_enc'),SHA2('keyloginekinerja',512))
                AND clkl.tipe_unit_kerja_lain = 2
                UNION ALL
                SELECT HEX(AES_ENCRYPT(clkl.id_aja_lain,SHA2('$keyApps',512))) as id_clkl,
                clkl.tipe_unit_kerja_lain, clkl.id_unit_kerja_lain,
                clkl.no_spmt_unit_sekunder, clkl.tmt_spmt, clkl.berkas_spmt, clkl.tgl_input, clkl.inputer, p.nama, p.nip_baru,
                uk.nama_baru as unit_sekunder, (CASE WHEN uk.Alamat IS NULL = 1 THEN 'Belum ada data alamat' ELSE uk.Alamat END) as alamat, uk.in_lat as in_lat_unit_sekunder,
                uk.in_long as in_long_unit_sekunder, uk.out_lat as out_lat_unit_sekunder, uk.out_long as out_long_unit_sekunder,
                uk.id_skpd, uk2.nama_baru as unit_kerja_utama, NULL
                FROM current_lokasi_kerja_lain clkl
                LEFT JOIN unit_kerja uk ON clkl.id_unit_kerja_lain = uk.id_unit_kerja
                LEFT JOIN unit_kerja uk2 ON uk.id_skpd = uk2.id_unit_kerja
                LEFT JOIN pegawai p ON clkl.inputer = p.id_pegawai
                WHERE clkl.id_pegawai = AES_DECRYPT(UNHEX('$id_pegawai_enc'),SHA2('keyloginekinerja',512))
                AND clkl.tipe_unit_kerja_lain = 1) a ORDER BY a.tgl_input";
        return $this->db->query($sql);
    }


    public function updateTipeLokasiPegawai($data, $keyApps){
        $this->db->trans_begin();
        $flagTipe = ($data['isMulti']=='true'?1:0);
        $idClk = $data['idClk'];
        $idpegawai_update = $data['idp_updater'];
        $sql = "UPDATE current_lokasi_kerja SET flag_lokasi_multiple = $flagTipe, last_tgl_update_flag_lokasi = NOW(), 
                last_updater_flag_lokasi = AES_DECRYPT(UNHEX('$idpegawai_update'),SHA2('keyloginekinerja',512)) 
                WHERE id_aja = AES_DECRYPT(UNHEX('$idClk'),SHA2($keyApps,512))";
        $this->db->query($sql);
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return 0;
        }else{
            $this->db->trans_commit();
            return 1;
        }
    }

    public function get_lokasi_unit_sekunder_by_term($q, $tipe_unit, $opd, $keyApps){
        if($tipe_unit == 'sekunder') {
            $sql = "SELECT HEX(AES_ENCRYPT(uks.id_uk_sekunder,SHA2($keyApps,512))) AS id_uk_sekunder_enc, uks.nama 
                FROM unit_kerja_sekunder uks 
                WHERE uks.nama LIKE '%$q%' OR uks.alamat LIKE '%$q%'
                ORDER BY uks.nama";
        }else{
            $andKlausa = '';
            if($opd!=''){
                $andKlausa = " AND uk.id_skpd = AES_DECRYPT(UNHEX('$opd'), SHA2('keyloginekinerja',512)) ";
            }
            $sql = "SELECT HEX(AES_ENCRYPT(uk.id_unit_kerja,SHA2($keyApps,512))) AS id_uk_sekunder_enc, uk.nama_baru as nama
                FROM unit_kerja uk
                WHERE (uk.nama_baru LIKE '%$q%' OR uk.alamat LIKE '%$q%') AND uk.tahun = (SELECT MAX(tahun) FROM unit_kerja) 
                $andKlausa
                ORDER BY uk.nama_baru";
        }
        return $this->db->query($sql);
    }

    public function get_info_lokasi_sekunder_by_id($idUnitSekunder, $tipeUnit, $keyApps){
        if($tipeUnit == 'sekunder') {
            $sql = "SELECT a.*, uks.nama as induk, uk.nama_baru as unit_utama, p.nama as updater, p.nip_baru, 
                DATE_FORMAT(a.tgl_input, '%d-%m-%Y %H:%i:%s') as tgl_input2 FROM
                (SELECT * FROM unit_kerja_sekunder uks
                WHERE uks.id_uk_sekunder = AES_DECRYPT(UNHEX('$idUnitSekunder'), SHA2($keyApps,512))) a
                LEFT JOIN unit_kerja_sekunder uks ON a.id_uk_induk = uks.id_uk_sekunder
                LEFT JOIN unit_kerja uk ON a.id_uk_primer = uk.id_unit_kerja
                LEFT JOIN pegawai p ON a.inputer = p.id_pegawai";
        }else{
            $sql = "SELECT a.*, uk.nama_baru as opd FROM
                (SELECT uk.id_unit_kerja, uk.nama_baru as nama, uk.Alamat as alamat, uk.telp,
                uk.in_lat, uk.in_long, uk.out_lat, uk.out_long, uk.id_skpd
                FROM unit_kerja uk 
                WHERE uk.id_unit_kerja = AES_DECRYPT(UNHEX('$idUnitSekunder'), SHA2($keyApps,512))) a
                LEFT JOIN unit_kerja uk ON a.id_skpd = uk.id_unit_kerja";
        }
        return $this->db->query($sql);
    }

    public function insert_unit_sekunder_pegawai($data, $keyApps){
        $idLokasiSekunder = $data['idLokasiSekunder'];
        $idP = $data['idp'];
        $tipe_lokasi = ($data['tipe_lokasi']=='utama'?1:2);
        $txtNoSPMT = "'".$data['txtNoSPMT']."'";
        $tmtSpmt = "'".$data['tmtSpmt']."'";
        $inputer = $data['inputer'];

        $this->db->trans_begin();
        $sql = "INSERT INTO current_lokasi_kerja_lain(id_pegawai, id_unit_kerja_lain, tipe_unit_kerja_lain, 
                no_spmt_unit_sekunder, tmt_spmt, tgl_input, inputer)
                VALUES (AES_DECRYPT(UNHEX('$idP'),SHA2('keyloginekinerja',512)),
                AES_DECRYPT(UNHEX('$idLokasiSekunder'), SHA2($keyApps,512)), $tipe_lokasi, $txtNoSPMT,
                $tmtSpmt, NOW(), AES_DECRYPT(UNHEX('$inputer'),SHA2('keyloginekinerja',512)))";
        $this->db->query($sql);
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return array(
                'query' => 0,
                'id_clkl' => ''
            );
        }else{
            $id_clkl = $this->db->insert_id();
            $this->db->trans_commit();
            return array(
                'query' => 1,
                'id_clkl' => $id_clkl
            );
        }
    }

    public function cek_eksisting_unit_sekunder_by_idpegawai($iduk_sekunder, $idp, $keyApps){
        $sql = "SELECT COUNT(*) AS jumlah FROM current_lokasi_kerja_lain clkl
                WHERE clkl.id_pegawai = AES_DECRYPT(UNHEX('$idp'),SHA2('keyloginekinerja',512))
                AND clkl.id_unit_kerja_lain = AES_DECRYPT(UNHEX('$iduk_sekunder'), SHA2($keyApps,512))";
        $query = $this->db->query($sql);
        $rowcount = $query->num_rows();
        if($rowcount > 0) {
            foreach ($query->result() as $data) {
                $jmlData = $data->jumlah;
            }
            if($jmlData>0){
                $eksistingAda = 1;
            }else{
                $eksistingAda = 0;
            }
        }else{
            $eksistingAda = 0;
        }
        return $eksistingAda;
    }

    public function hapus_unit_sekunder_pegawai($id_unit_sekunder_pegawai, $keyApps){
        $this->db->trans_begin();
        $url_berkas_spmt = $this->getUrlBerkasSpmtByIdClkl($id_unit_sekunder_pegawai, $keyApps);
        $sql = "DELETE FROM current_lokasi_kerja_lain 
                WHERE id_aja_lain = AES_DECRYPT(UNHEX('$id_unit_sekunder_pegawai'),SHA2($keyApps,512))";
        $this->db->query($sql);
        if ($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            return array(
                'query' => 0,
                'sql' => $sql
            );
        }else{
            if($url_berkas_spmt!=''){
                //if(file_exists($_SERVER['DOCUMENT_ROOT']."/ekinerja2/berkas/".$url_berkas_spmt)){
                    //unlink($_SERVER['DOCUMENT_ROOT']."/ekinerja2/berkas/".$url_berkas_spmt);
                //}
                $connection = ssh2_connect('103.14.229.15');
                ssh2_auth_password($connection, 'rommonz', 'mony3Tmony3T');
                $sftp = ssh2_sftp($connection);
                error_reporting(0);
                if (file_exists('ssh2.sftp://' . $sftp . '/var/www/html/ekinerja2/berkas/'.$url_berkas_spmt)) {
                    ssh2_sftp_unlink($sftp, '/var/www/html/ekinerja2/berkas/'.$url_berkas_spmt);
                }
                error_reporting(1);
            }
            $this->db->trans_commit();
            return array(
                'query' => 1,
                'sql' => $sql
            );
        }
    }

    function update_url_berkas_spmt_clkl($nf, $idclkl){
        $this->db->trans_begin();
        $sql = "UPDATE current_lokasi_kerja_lain 
                SET berkas_spmt = '$nf' 
                WHERE id_aja_lain = $idclkl";
        $this->db->query($sql);
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return array(
                'query' => 0,
            );
        }else{
            $this->db->trans_commit();
            return array(
                'query' => 1,
            );
        }
    }

    public function getUrlBerkasSpmtByIdClkl($idclkl, $keyApps){
        $sql = "SELECT berkas_spmt 
                FROM current_lokasi_kerja_lain 
                WHERE id_aja_lain = AES_DECRYPT(UNHEX('$idclkl'),SHA2($keyApps,512))";
        $rs = $this->db->query($sql);
        $rowcount = $rs->num_rows();
        if($rowcount>0){
            foreach ($rs->result() as $data) {
                $url_berkas_spmt = $data->berkas_spmt;
            }
        }else{
            $url_berkas_spmt = '';
        }
        return $url_berkas_spmt;
    }

    public function insert_unit_sekunder_baru_pegawai($data, $keyApps){
        $namaLokasi = "'".$data['namaLokasi']."'";
        $txtAlamat = "'".$data['txtAlamat']."'";
        $txtTelepon = "'".$data['txtTelepon']."'";
        $txtEmail = "'".$data['txtEmail']."'";
        $idIndukLokasiSekunder = $data['idIndukLokasiSekunder'];
        $idIndukLokasiSekunder = ($idIndukLokasiSekunder==''?'0':"AES_DECRYPT(UNHEX('$idIndukLokasiSekunder'), SHA2($keyApps,512))");
        $idUnitKerjaUtama = $data['idUnitKerjaUtama'];
        $coordinat_y_in = $data['coordinat_y_in'];
        $coordinat_x_in = $data['coordinat_x_in'];
        $coordinat_y_out = $data['coordinat_y_out'];
        $coordinat_x_out = $data['coordinat_x_out'];
        $ddTipeWilayah = "'".$data['ddTipeWilayah']."'";
        $inputer = $data['inputer'];
        $idP = $data['idp'];
        $txtNoSPMT = "'".$data['txtNoSPMT']."'";
        $tmtSpmt = "'".$data['tmtSpmt']."'";

        $this->db->trans_begin();
        $sql = "INSERT INTO unit_kerja_sekunder(nama, alamat, telp, email, id_uk_induk, 
                id_uk_primer, in_long, in_lat, out_long, out_lat, tipe_wilayah, tgl_input, inputer)
                VALUES($namaLokasi, $txtAlamat, $txtTelepon, $txtEmail, $idIndukLokasiSekunder,
                AES_DECRYPT(UNHEX('$idUnitKerjaUtama'), SHA2($keyApps,512)), $coordinat_x_in, $coordinat_y_in, $coordinat_x_out, $coordinat_y_out,
                $ddTipeWilayah, NOW(), AES_DECRYPT(UNHEX('$inputer'),SHA2('keyloginekinerja',512)))";
        $this->db->query($sql);
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return array(
                'query' => 0,
                'id_clkl' => '',
                'sql' => $sql
            );
        }else{
            $id_uk_sekunder = $this->db->insert_id();
            $sql = "INSERT INTO current_lokasi_kerja_lain(id_pegawai, id_unit_kerja_lain, tipe_unit_kerja_lain, 
                    no_spmt_unit_sekunder, tmt_spmt, tgl_input, inputer) 
                    VALUES (AES_DECRYPT(UNHEX('$idP'),SHA2('keyloginekinerja',512)),
                    $id_uk_sekunder, 2, $txtNoSPMT, $tmtSpmt, NOW(),
                    AES_DECRYPT(UNHEX('$inputer'),SHA2('keyloginekinerja',512)))";
            $this->db->query($sql);
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                return array(
                    'query' => 0,
                    'id_clkl' => '',
                    'sql' => $sql.$sql
                );
            }else{
                $id_clkl = $this->db->insert_id();
                $this->db->trans_commit();
                return array(
                    'query' => 1,
                    'id_clkl' => $id_clkl
                );
            }
        }
    }

    public function listof_unit_kerja_sekunder_by_opd($opd, $keyApps){
        $sql = "SELECT uk.id_uk_sekunder, HEX(AES_ENCRYPT(uk.id_uk_sekunder,SHA2($keyApps,512))) AS id_uk_sekunder_enc,
                uk.nama, uk.alamat, uk.telp, uk.email, uk.in_long, uk.in_lat, uk.out_long, uk.out_lat, uk.tipe_wilayah,
                uk2.nama as induk, uk3.nama_baru as utama, p.id_pegawai as idp_inputer, p.nama as inputer, DATE_FORMAT(uk.tgl_input, '%d-%m-%Y %H:%i:%s') AS tgl_input
                FROM unit_kerja_sekunder uk
                LEFT JOIN unit_kerja_sekunder uk2 ON uk.id_uk_induk = uk2.id_uk_sekunder
                LEFT JOIN unit_kerja uk3 ON uk.id_uk_primer = uk3.id_unit_kerja
                LEFT JOIN pegawai p ON uk.inputer = p.id_pegawai
                /*WHERE uk.id_uk_primer = AES_DECRYPT(UNHEX('$opd'), SHA2('keyloginekinerja', 512))*/";
        return $this->db->query($sql);
    }

    public function insert_unit_sekunder_baru_lokasi($data, $keyApps){
        $namaLokasi = "'".$data['namaLokasi']."'";
        $txtAlamat = "'".$data['txtAlamat']."'";
        $txtTelepon = "'".$data['txtTelepon']."'";
        $txtEmail = "'".$data['txtEmail']."'";
        $idIndukLokasiSekunder = $data['idIndukLokasiSekunder'];
        $idIndukLokasiSekunder = ($idIndukLokasiSekunder==''?'0':"AES_DECRYPT(UNHEX('$idIndukLokasiSekunder'), SHA2($keyApps,512))");
        $idUnitKerjaUtama = $data['idUnitKerjaUtama'];
        $coordinat_y_in = $data['coordinat_y_in'];
        $coordinat_x_in = $data['coordinat_x_in'];
        $coordinat_y_out = $data['coordinat_y_out'];
        $coordinat_x_out = $data['coordinat_x_out'];
        $ddTipeWilayah = "'".$data['ddTipeWilayah']."'";
        $inputer = $data['inputer'];

        $this->db->trans_begin();
        $sql = "INSERT INTO unit_kerja_sekunder(nama, alamat, telp, email, id_uk_induk, 
                id_uk_primer, in_long, in_lat, out_long, out_lat, tipe_wilayah, tgl_input, inputer)
                VALUES($namaLokasi, $txtAlamat, $txtTelepon, $txtEmail, $idIndukLokasiSekunder,
                AES_DECRYPT(UNHEX('$idUnitKerjaUtama'), SHA2($keyApps,512)), $coordinat_x_in, $coordinat_y_in, $coordinat_x_out, $coordinat_y_out,
                $ddTipeWilayah, NOW(), AES_DECRYPT(UNHEX('$inputer'),SHA2('keyloginekinerja',512)))";
        $this->db->query($sql);
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return 0;
        }else{
            $this->db->trans_commit();
            return 1;
        }
        return $this->db->query($sql);
    }

    public function hapus_unit_sekunder_lokasi($id_unit_sekunder, $keyApps){
        $this->db->trans_begin();
        $sql = "DELETE FROM unit_kerja_sekunder 
                WHERE id_uk_sekunder = AES_DECRYPT(UNHEX('$id_unit_sekunder'),SHA2($keyApps,512))";
        $this->db->query($sql);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return 0;
        }else{
            $this->db->trans_commit();
            return 1;
        }
    }

    public function ubahUnitSekunder($id_uk_sekunder, $keyApps){
        $sql = "SELECT uks.nama, uks.alamat, uks.telp, uks.email, uks.in_lat, uks.in_long, uks.out_lat, uks.out_long,
                uks.tipe_wilayah, HEX(AES_ENCRYPT(uks.id_uk_induk,SHA2($keyApps,512))) as id_uk_induk,
                HEX(AES_ENCRYPT(uks.id_uk_primer,SHA2($keyApps,512))) as id_uk_primer, 
                uks2.nama as induk, uk.nama_baru as unit_utama 
                FROM unit_kerja_sekunder uks 
                LEFT JOIN unit_kerja_sekunder uks2 ON uks.id_uk_induk = uks2.id_uk_sekunder
                LEFT JOIN unit_kerja uk ON uks.id_uk_primer = uk.id_unit_kerja
                WHERE uks.id_uk_sekunder = AES_DECRYPT(UNHEX('$id_uk_sekunder'), SHA2($keyApps,512))";
        return $this->db->query($sql);
    }

    public function updateUnitSekunder($data, $keyApps){
        $id_uk_sekunder = $data['id_uk_sekunder'];
        $namaLokasi = "'".$data['namaLokasi']."'";
        $txtAlamat = "'".$data['txtAlamat']."'";
        $txtTelepon = "'".$data['txtTelepon']."'";
        $txtEmail = "'".$data['txtEmail']."'";
        $idIndukLokasiSekunder = $data['idIndukLokasiSekunder'];
        $idIndukLokasiSekunder = ($idIndukLokasiSekunder==''?'0':"AES_DECRYPT(UNHEX('$idIndukLokasiSekunder'), SHA2($keyApps,512))");
        $idUnitKerjaUtama = $data['idUnitKerjaUtama'];
        $coordinat_y_in = $data['coordinat_y_in'];
        $coordinat_x_in = $data['coordinat_x_in'];
        $coordinat_y_out = $data['coordinat_y_out'];
        $coordinat_x_out = $data['coordinat_x_out'];
        $ddTipeWilayah = "'".$data['ddTipeWilayah']."'";

        $this->db->trans_begin();
        $sql = "UPDATE unit_kerja_sekunder SET nama = $namaLokasi, alamat = $txtAlamat, 
                telp = $txtTelepon, email = $txtEmail, id_uk_induk = $idIndukLokasiSekunder, 
                id_uk_primer = AES_DECRYPT(UNHEX('$idUnitKerjaUtama'), SHA2($keyApps,512)), in_lat = $coordinat_y_in, in_long = $coordinat_x_in,
                out_lat = $coordinat_y_out, out_long = $coordinat_x_out, tipe_wilayah = $ddTipeWilayah
                WHERE id_uk_sekunder = AES_DECRYPT(UNHEX('$id_uk_sekunder'),SHA2($keyApps,512))";

        $this->db->query($sql);
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return 0;
        }else{
            $this->db->trans_commit();
            return 1;
        }
        return $this->db->query($sql);
    }

    public function jml_jadwal_khusus_by_opd($opd, $bln, $thn, $id_jenis_jadwal, $idp, $tglMulaiAcara, $tglSelesaiAcara, $txtKeyword, $keyApps){
        $andKlausa_0 = '';
        $andKlausa_tgl = '';
        $andKlausa = '';
        $whereKlausa = '';

        if($idp!='0'){
            $andKlausa_0 .= " AND js.inputer = AES_DECRYPT(UNHEX('$idp'), SHA2('keyloginekinerja',512)) ";
        }

        if($bln!='0'){
            $andKlausa .= " AND js.periode_bln = ".$bln;
        }

        if($thn!='0'){
            $andKlausa .= " AND js.periode_thn = ".$thn;
        }

        if($tglMulaiAcara!='' and $tglSelesaiAcara!=''){
            $andKlausa_tgl .= "AND ((jt.tgl_mulai = '$tglMulaiAcara' AND jt.tgl_selesai = '$tglSelesaiAcara') OR (jt.tgl_mulai >= '$tglMulaiAcara' AND jt.tgl_selesai <= '$tglSelesaiAcara'))";
        }

        if($id_jenis_jadwal!='0'){
            $andKlausa .= " AND jt.id_jenis_jadwal = ".$id_jenis_jadwal;
        }
        if (!(trim($txtKeyword)== "") && !(trim($txtKeyword)== "0")){
            $whereKlausa = "AND (jt.jabatan LIKE '%$txtKeyword%' OR uk.nama_baru LIKE '%$txtKeyword%' OR jt.no_spmt_jadwal LIKE '%$txtKeyword%' 
                            OR jt.keterangan LIKE '%$txtKeyword%' OR p.nip_baru LIKE '%$txtKeyword%' OR p.nama LIKE '%$txtKeyword%')";
        }
        $sql = "SELECT COUNT(a.idjadwal_spmt) AS jumlah FROM
                (SELECT
                jt.idjadwal_spmt, HEX(AES_ENCRYPT(jt.id_trans_jadwal,SHA2($keyApps,512))) as id_tj_enc
                FROM
                (SELECT js.*, jt.id_trans_jadwal, jt.id_pegawai, jt.tgl_mulai, jt.tgl_selesai,
                jt.jam_mulai, jt.jam_selesai, jt.jabatan, jt.id_jenis_jadwal
                FROM
                (SELECT js.* FROM jadwal_spmt js
                WHERE js.id_skpd = AES_DECRYPT(UNHEX('$opd'), SHA2('keyloginekinerja',512)) $andKlausa_0) js
                INNER JOIN jadwal_transaksi jt ON js.idjadwal_spmt = jt.idjadwal_spmt
                WHERE jt.id_trans_jadwal IS NOT NULL $andKlausa $andKlausa_tgl
                ORDER BY js.periode_bln ASC, js.periode_thn ASC, jt.tgl_mulai ASC, jt.jam_mulai ASC) jt
                INNER JOIN jadwal_master jm ON jt.id_jenis_jadwal = jm.id_jenis_jadwal
                LEFT JOIN jadwal_unit_kerja juk ON jt.id_trans_jadwal = juk.id_trans_jadwal
                INNER JOIN pegawai p ON jt.id_pegawai = p.id_pegawai
                LEFT JOIN unit_kerja uk ON juk.id_unit_kerja = uk.id_unit_kerja
                INNER JOIN pegawai p2 ON jt.inputer = p2.id_pegawai
                $whereKlausa
                GROUP BY jt.id_pegawai, id_tj_enc) a";
        return $this->db->query($sql);
    }

    public function listof_jadwal_khusus_by_opd($row_number_start, $opd, $bln, $thn, $id_jenis_jadwal, $idp, $tglMulaiAcara, $tglSelesaiAcara, $txtKeyword, $limit, $keyApps){
        $andKlausa_0 = '';
        $andKlausa_tgl = '';
        $andKlausa = '';
        $whereKlausa = '';

        if($idp!='0'){
            $andKlausa_0 .= " AND js.inputer = AES_DECRYPT(UNHEX('$idp'), SHA2('keyloginekinerja',512)) ";
        }

        if($bln!='0'){
            $andKlausa .= " AND js.periode_bln = ".$bln;
        }

        if($thn!='0'){
            $andKlausa .= " AND js.periode_thn = ".$thn;
        }

        if($tglMulaiAcara!='' and $tglSelesaiAcara!=''){
            $andKlausa_tgl .= "AND ((jt.tgl_mulai = '$tglMulaiAcara' AND jt.tgl_selesai = '$tglSelesaiAcara') OR (jt.tgl_mulai >= '$tglMulaiAcara' AND jt.tgl_selesai <= '$tglSelesaiAcara'))";
        }

        if($id_jenis_jadwal!='0'){
            $andKlausa .= " AND jt.id_jenis_jadwal = ".$id_jenis_jadwal;
        }

        if (!(trim($txtKeyword)== "") && !(trim($txtKeyword)== "0")){
            $whereKlausa = "AND (jt.jabatan LIKE '%$txtKeyword%' OR uk.nama_baru LIKE '%$txtKeyword%' OR jt.no_spmt_jadwal LIKE '%$txtKeyword%' 
                            OR jt.keterangan LIKE '%$txtKeyword%' OR p.nip_baru LIKE '%$txtKeyword%' OR p.nama LIKE '%$txtKeyword%')";
        }
        $this->db->query("SET @row_number := $row_number_start");
        $sql = "SELECT 
                HEX(AES_ENCRYPT(jt.id_trans_jadwal,SHA2($keyApps,512))) as id_tj_enc,
                HEX(AES_ENCRYPT(jt.id_pegawai,SHA2('keyloginekinerja',512))) as id_pegawai_enc,
                jt.periode_bln, jt.periode_thn, DATE_FORMAT(jt.tgl_mulai, '%d-%m-%Y') as tgl_mulai,
                DATE_FORMAT(jt.tgl_selesai, '%d-%m-%Y') as tgl_selesai, jt.jam_mulai, jt.jam_selesai,
                jm.jenis, jt.jabatan, jt.keterangan,
                GROUP_CONCAT((CASE WHEN juk.flag_lokasi_sekunder = 0 THEN
                (SELECT nama_baru FROM unit_kerja WHERE id_unit_kerja = juk.id_unit_kerja)
                ELSE (SELECT nama FROM unit_kerja_sekunder WHERE id_uk_sekunder = juk.id_unit_kerja)
                END), ' (', (CASE WHEN juk.flag_lokasi_sekunder = 0 THEN 'Unit Utama' ELSE 'Unit Sekunder' END), ')' SEPARATOR ', ') unit_kerja,
                GROUP_CONCAT((CASE WHEN juk.flag_lokasi_sekunder = 0 THEN 'utama' ELSE 'sekunder' END),'-',HEX(AES_ENCRYPT(juk.id_unit_kerja,SHA2($keyApps,512)))) as id_unit_kerja,
                p.nip_baru, CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
                p.nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(' ',p.gelar_belakang) END) AS nama, p.pangkat_gol,
                jt.no_spmt_jadwal, jt.tmt_spmt, jt.berkas_spmt, jt.keterangan, jt.tgl_input as tgl_input_spmt,
                p2.nip_baru as nip_inputer, CONCAT(CASE WHEN p2.gelar_depan = '' THEN '' ELSE CONCAT(p2.gelar_depan, ' ') END,
                p2.nama, CASE WHEN p2.gelar_belakang = '' THEN '' ELSE CONCAT(' ',p2.gelar_belakang) END)  AS nama_inputer, p2.id_pegawai as inputer
                FROM
                (SELECT js.*, jt.id_trans_jadwal, jt.id_pegawai, jt.tgl_mulai, jt.tgl_selesai,
                jt.jam_mulai, jt.jam_selesai, jt.jabatan, jt.id_jenis_jadwal
                FROM
                (SELECT js.* FROM jadwal_spmt js
                WHERE js.id_skpd = AES_DECRYPT(UNHEX('$opd'), SHA2('keyloginekinerja',512)) $andKlausa_0) js
                INNER JOIN jadwal_transaksi jt ON js.idjadwal_spmt = jt.idjadwal_spmt
                WHERE jt.id_trans_jadwal IS NOT NULL $andKlausa $andKlausa_tgl 
                ORDER BY js.periode_bln ASC, js.periode_thn ASC, jt.tgl_mulai ASC, jt.jam_mulai ASC ) jt
                INNER JOIN jadwal_master jm ON jt.id_jenis_jadwal = jm.id_jenis_jadwal
                LEFT JOIN jadwal_unit_kerja juk ON jt.id_trans_jadwal = juk.id_trans_jadwal
                INNER JOIN pegawai p ON jt.id_pegawai = p.id_pegawai
                LEFT JOIN unit_kerja uk ON juk.id_unit_kerja = uk.id_unit_kerja
                INNER JOIN pegawai p2 ON jt.inputer = p2.id_pegawai
                $whereKlausa 
                GROUP BY jt.id_pegawai, id_tj_enc
                ORDER BY jt.periode_bln ASC, jt.periode_thn ASC, jt.tgl_mulai ASC, jt.jam_mulai ASC $limit";

        return $this->db->query($sql);
    }

    public function ref_jadwal_jenis(){
        $sql = "SELECT * FROM jadwal_master";
        return $this->db->query($sql);
    }

    public function insert_jadwal_khusus($data, $keyApps){
        $periode_bln = $data['periode_bln'];
        $periode_thn = $data['periode_thn'];
        $txtKeterangan = "'".$data['txtKeterangan']."'";
        $txtNoSPMT = "'".$data['txtNoSPMT']."'";
        $tmtJadwal = "'".$data['tmtJadwal']."'";
        $inputer = $data['inputer'];
        $id_skpd_enc = $data['id_skpd_enc'];

        $this->db->trans_begin();
        $sql = "INSERT INTO jadwal_spmt(periode_bln, periode_thn, no_spmt_jadwal, tmt_spmt, 
                keterangan, inputer, id_skpd) VALUES ($periode_bln, $periode_thn, $txtNoSPMT,
                $tmtJadwal, $txtKeterangan, AES_DECRYPT(UNHEX('$inputer'),SHA2('keyloginekinerja',512)),
                AES_DECRYPT(UNHEX('$id_skpd_enc'),SHA2('keyloginekinerja',512))) ";
        $this->db->query($sql);
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return array(
                'query' => 0,
                'idjadwal_spmt' => ''
            );
        }else{
            $idjadwal_spmt = $this->db->insert_id();
            $this->db->trans_commit();
            $sql = "SELECT HEX(AES_ENCRYPT($idjadwal_spmt,SHA2($keyApps,512))) as idjdwl";
            $query = $this->db->query($sql);
            $rowcount = $query->num_rows();
            if($rowcount > 0) {
                foreach ($query->result() as $data) {
                    $idjdwl = $data->idjdwl;
                }
            }else{
                $idjdwl = 0;
            }
            return array(
                'query' => 1,
                'idjadwal_spmt_enc' => $idjdwl,
                'idjadwal_spmt' => $idjadwal_spmt
            );
        }
    }

    public function ubahJadwalKhusus($idspmt_jadwal, $keyApps){
        $sql = "SELECT jst.*, DATE_FORMAT(jst.tmt_spmt, '%Y/%m/%d') as tmt_spmt2,
                DATE_FORMAT(jst.tgl_input, '%d-%m-%Y') as tgl_input2
                FROM jadwal_spmt jst
                WHERE jst.idjadwal_spmt = AES_DECRYPT(UNHEX('$idspmt_jadwal'), SHA2($keyApps,512));";
        return $this->db->query($sql);
    }

    public function jml_pegawai_by_id_opd($id_skpd, $txtKeyword){
        $andKlausa = '';
        if (!(trim($txtKeyword)== "") && !(trim($txtKeyword)== "0")){
            $andKlausa .= " AND (p.nama LIKE '%".$txtKeyword."%' 
							OR p.nip_baru LIKE '%".$txtKeyword."%')".$andKlausa;
        }
        $sql = "SELECT COUNT(*) AS jumlah
                FROM pegawai p LEFT JOIN jabatan j ON p.id_j = j.id_j
                LEFT JOIN current_lokasi_kerja clk ON p.id_pegawai = clk.id_pegawai
                LEFT JOIN unit_kerja uk ON clk.id_unit_kerja = uk.id_unit_kerja
                WHERE p.flag_pensiun = 0 AND uk.id_skpd = AES_DECRYPT(UNHEX('$id_skpd'),SHA2('keyloginekinerja',512)) 
                $andKlausa";
        return $this->db->query($sql);
    }

    public function list_pegawai_by_id_opd($row_number_start, $id_skpd, $txtKeyword, $limit, $keyApps){
        $andKlausa = '';
        if (!(trim($txtKeyword)== "") && !(trim($txtKeyword)== "0")){
            $andKlausa .= " AND (p.nama LIKE '%".$txtKeyword."%' 
							OR p.nip_baru LIKE '%".$txtKeyword."%')".$andKlausa;
        }
        $this->db->query("SET @row_number := $row_number_start");
        $sql = "SELECT a.* FROM
                (SELECT HEX(AES_ENCRYPT(p.id_pegawai,SHA2($keyApps,512))) AS id_pegawai, p.nip_baru, CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
                nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(' ',p.gelar_belakang) END) AS nama,
                p.jenjab, p.pangkat_gol, CASE WHEN j.eselon IS NULL THEN 'Staf' ELSE j.eselon END AS eselon,
                CASE WHEN p.jenjab = 'Fungsional' THEN (SELECT jaf.id_jafung AS kode_jabatan FROM jafung_pegawai jap, jafung jaf
                WHERE jap.id_jafung = jaf.id_jafung AND jap.id_pegawai = p.id_pegawai ORDER BY jap.tmt DESC LIMIT 1) ELSE CASE WHEN p.id_j IS NULL THEN (SELECT jm.id_jfu AS kode_jabatan FROM jfu_pegawai jp, jfu_master jm
                WHERE jp.kode_jabatan = jm.kode_jabatan AND jp.id_pegawai = p.id_pegawai ORDER BY jp.tmt DESC LIMIT 1) ELSE j.id_j END END AS kode_jabatan,
                CASE WHEN p.jenjab = 'Fungsional' THEN (SELECT jaf.kelas_jabatan AS kode_jabatan FROM jafung_pegawai jap, jafung jaf
                WHERE jap.id_jafung = jaf.id_jafung AND jap.id_pegawai = p.id_pegawai ORDER BY jap.tmt DESC LIMIT 1) ELSE CASE WHEN p.id_j IS NULL THEN (SELECT jm.kelas_jabatan AS kode_jabatan FROM jfu_pegawai jp, jfu_master jm
                WHERE jp.kode_jabatan = jm.kode_jabatan AND jp.id_pegawai = p.id_pegawai ORDER BY jp.tmt DESC LIMIT 1) ELSE j.kelas_jabatan END END AS kelas_jabatan,
                CASE WHEN p.jenjab = 'Fungsional' THEN (SELECT jaf.nilai_jabatan AS kode_jabatan FROM jafung_pegawai jap, jafung jaf
                WHERE jap.id_jafung = jaf.id_jafung AND jap.id_pegawai = p.id_pegawai ORDER BY jap.tmt DESC LIMIT 1) ELSE CASE WHEN p.id_j IS NULL THEN (SELECT jm.nilai_jabatan AS kode_jabatan FROM jfu_pegawai jp, jfu_master jm
                WHERE jp.kode_jabatan = jm.kode_jabatan AND jp.id_pegawai = p.id_pegawai ORDER BY jp.tmt DESC LIMIT 1) ELSE j.nilai_jabatan END END AS nilai_jabatan,
                CASE WHEN p.jenjab = 'Fungsional' THEN (CASE WHEN (SELECT jaf.nama_jafung AS jabatan FROM jafung_pegawai jap, jafung jaf
                WHERE jap.id_jafung = jaf.id_jafung AND jap.id_pegawai = p.id_pegawai ORDER BY jap.tmt DESC LIMIT 1) IS NULL THEN p.jabatan ELSE
                (SELECT jaf.nama_jafung AS jabatan FROM jafung_pegawai jap, jafung jaf
                WHERE jap.id_jafung = jaf.id_jafung AND jap.id_pegawai = p.id_pegawai ORDER BY jap.tmt DESC LIMIT 1) END) ELSE CASE WHEN p.id_j IS NULL THEN (SELECT jm.nama_jfu AS jabatan FROM jfu_pegawai jp, jfu_master jm
                WHERE jp.kode_jabatan = jm.kode_jabatan AND jp.id_pegawai = p.id_pegawai ORDER BY jp.tmt DESC LIMIT 1) ELSE j.jabatan END END AS jabatan,
                uk.id_unit_kerja, uk.nama_baru as unit
                FROM pegawai p LEFT JOIN jabatan j ON p.id_j = j.id_j
                LEFT JOIN current_lokasi_kerja clk ON p.id_pegawai = clk.id_pegawai
                LEFT JOIN unit_kerja uk ON clk.id_unit_kerja = uk.id_unit_kerja
                WHERE p.flag_pensiun = 0 AND uk.id_skpd = AES_DECRYPT(UNHEX('$id_skpd'),SHA2('keyloginekinerja',512)) 
                $andKlausa) a 
                ORDER BY a.eselon ASC, a.pangkat_gol DESC $limit";
        return $this->db->query($sql);
    }

    public function update_url_berkas_spmt_jdwl_khusus($nf, $idjadwal_spmt, $keyApps){
        $this->db->trans_begin();
        $sql = "UPDATE jadwal_spmt 
                SET berkas_spmt = '$nf' 
                WHERE idjadwal_spmt = $idjadwal_spmt";
        $this->db->query($sql);
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return array(
                'query' => 0,
                'sql' => $sql
            );
        }else{
            $this->db->trans_commit();
            return array(
                'query' => 1,
            );
        }
    }

    public function update_jadwal_khusus($data, $keyApps){
        $txtKeterangan = "'".$data['txtKeterangan']."'";
        $txtNoSPMT = "'".$data['txtNoSPMT']."'";
        $idspmt_jadwal_enc = $data['idspmt_jadwal_enc'];
        $ddBln = $data['ddBln'];
        $ddThn = $data['ddThn'];
        $this->db->trans_begin();
        $sql = "UPDATE jadwal_spmt SET no_spmt_jadwal = $txtNoSPMT, keterangan = $txtKeterangan, periode_bln = $ddBln, periode_thn = $ddThn 
                WHERE idjadwal_spmt = AES_DECRYPT(UNHEX('$idspmt_jadwal_enc'),
                SHA2($keyApps,512))";
        $this->db->query($sql);
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return array(
                'query' => 0
            );
        }else{
            $this->db->trans_commit();
            return array(
                'query' => 1
            );
        }

    }

    public function detailLaporanKinerjaByIdHistAlihTugas($id_knj, $id_knj_alih_tugas, $keyApps){
        $sql = "SELECT a.*, p.nip_baru as nip_approver, CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
        p.nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(' ',p.gelar_belakang) END) AS nama_approver
        FROM 
        (SELECT kkm.*, HEX(AES_ENCRYPT(kkm.id_knj_master,SHA2($keyApps,512))) as id_knj_master_enc,
        p.nip_baru, CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
        nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(' ',p.gelar_belakang) END) AS nama, ksk.status_knj, 
        kkh.jabatan as jabatan_hist, kkh.atsl_nama as atsl_nama_hist, kkh.atsl_nip as atsl_nip_hist, 
        kkh.atsl_jabatan as atsl_jabatan_hist, kkh.unit_kerja as unit_kerja_hist
        FROM knj_kinerja_master kkm 
        INNER JOIN knj_kinerja_historis_alih_tugas kkh ON kkm.id_knj_master = kkh.id_knj_master
        INNER JOIN pegawai p ON kkm.id_pegawai_pelapor = p.id_pegawai
        INNER JOIN knj_status_kinerja ksk ON kkm.id_status_knj = ksk.id_status_knj
        WHERE kkm.id_knj_master = AES_DECRYPT(UNHEX('$id_knj'), SHA2($keyApps,512))
        AND kkh.idknj_hist_alih_tugas = AES_DECRYPT(UNHEX('$id_knj_alih_tugas'), SHA2($keyApps,512))) a
        LEFT JOIN pegawai p ON a.id_pegawai_approved = p.id_pegawai;";
        return $this->db->query($sql);
    }

    public function getInformasiPegawaiByIdp($idp){
        $sql = "SELECT p.id_pegawai, CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
                p.nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(' ',p.gelar_belakang) END) AS nama,
                p.nip_baru, p.pangkat_gol, p.id_j, CASE WHEN p.jenjab = 'Fungsional' THEN (CASE WHEN jafung.nama_jafung IS NULL THEN p.jabatan ELSE jafung.nama_jafung END) ELSE
                CASE WHEN p.id_j IS NULL THEN (jfu.nama_jfu) ELSE j.jabatan END END AS jabatan, 
                clk.id_unit_kerja, uk.nama_baru as unit, g.pangkat
                FROM pegawai p
                LEFT JOIN current_lokasi_kerja clk ON p.id_pegawai = clk.id_pegawai
                LEFT JOIN unit_kerja uk ON clk.id_unit_kerja = uk.id_unit_kerja
                LEFT JOIN jabatan j ON p.id_j = j.id_j
                LEFT JOIN (
                SELECT b.id_pegawai, jm.id_jfu as kode_jabatan_jfu, jm.kelas_jabatan as kelas_jabatan_jfu,
                jm.nilai_jabatan as nilai_jabatan_jfu, jm.nama_jfu
                FROM (SELECT a.*, jp.id_jfu FROM
                (SELECT jp.id_pegawai, MAX(jp.id) as id_jfu_pegawai FROM jfu_pegawai jp,
                (SELECT id_pegawai, MAX(tmt) as max_tmt FROM jfu_pegawai WHERE tmt IS NOT NULL GROUP BY id_pegawai) x
                WHERE jp.id_pegawai = x.id_pegawai AND jp.tmt = x.max_tmt
                GROUP BY jp.id_pegawai) a
                INNER JOIN jfu_pegawai jp ON a.id_jfu_pegawai = jp.id) b
                INNER JOIN jfu_master jm ON b.id_jfu = jm.id_jfu) jfu ON jfu.id_pegawai = p.id_pegawai
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
                LEFT JOIN golongan g ON p.pangkat_gol = g.golongan 
                WHERE p.id_pegawai = AES_DECRYPT(UNHEX('$idp'), SHA2('keyloginekinerja',512))";
        return $this->db->query($sql);
    }

    public function jumlah_jadwal_spmt_by_inputer($bln, $thn, $txtKeyword, $idp, $idskpd){
        $andKlausa = '';
        if($bln!='0'){
            $andKlausa .= " AND MONTH(js.tgl_input) = " . $bln;
        }

        if($thn!='0'){
            $andKlausa .= " AND YEAR(js.tgl_input) = " . $thn;
        }

        if (!(trim($txtKeyword)== "") && !(trim($txtKeyword)== "0")){
            $andKlausa .= " AND (js.no_spmt_jadwal LIKE '%".$txtKeyword."%'
								OR js.keterangan LIKE '%".$txtKeyword."%')";
        }

        if($idp!='0'){
            $andKlausa .= " AND js.inputer = AES_DECRYPT(UNHEX('$idp'), SHA2('keyloginekinerja',512)) ";
        }

        $sql = "SELECT COUNT(*) as jumlah 
                FROM jadwal_spmt js 
                WHERE js.id_skpd = AES_DECRYPT(UNHEX('$idskpd'), SHA2('keyloginekinerja',512)) 
                $andKlausa";
        return $this->db->query($sql);
    }

    public function list_jadwal_spmt_by_inputer($row_number_start, $bln, $thn, $txtKeyword, $idp, $idskpd, $limit, $keyApps){
        $andKlausa = '';
        if($bln!='0'){
            $andKlausa .= " AND js.periode_bln = " . $bln;
        }

        if($thn!='0'){
            $andKlausa .= " AND js.periode_thn = " . $thn;
        }

        if (!(trim($txtKeyword)== "") && !(trim($txtKeyword)== "0")){
            $andKlausa .= " AND (js.no_spmt_jadwal LIKE '%".$txtKeyword."%'
								OR js.keterangan LIKE '%".$txtKeyword."%')";
        }

        if($idp!='0'){
            $andKlausa .= " AND js.inputer = AES_DECRYPT(UNHEX('$idp'), SHA2('keyloginekinerja',512)) ";
        }

        $this->db->query("SET @row_number := $row_number_start");
        $sql = "SELECT FCN_ROW_NUMBER() as no_urut, a.*, COUNT(jt.id_trans_jadwal) as jml_jadwal FROM 
                (SELECT a.*, p.nip_baru, CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
                p.nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(' ',p.gelar_belakang) END) AS nama 
                FROM 
                (SELECT js.idjadwal_spmt, HEX(AES_ENCRYPT(js.idjadwal_spmt, SHA2($keyApps,512))) as idjadwal_spmt_enc,
                js.periode_bln, js.periode_thn,
                js.no_spmt_jadwal, js.keterangan, js.tgl_input,
                DATE_FORMAT(js.tgl_input, '%d-%m-%Y %H:%i:%s') as tgl_input2,
                js.inputer, js.berkas_spmt 
                FROM jadwal_spmt js 
                WHERE js.id_skpd = AES_DECRYPT(UNHEX('$idskpd'), SHA2('keyloginekinerja',512)) 
                $andKlausa) a INNER JOIN 
                pegawai p ON a.inputer = p.id_pegawai) a LEFT JOIN jadwal_transaksi jt
                ON a.idjadwal_spmt = jt.idjadwal_spmt 
                GROUP BY a.idjadwal_spmt 
                ORDER BY a.tgl_input DESC $limit";

        return $this->db->query($sql);
    }

    public function hapus_jadwal_spmt_by_inputer($idjadwal_khusus_enc, $keyApps){
        $this->db->trans_begin();
        $url_berkas_spmt = $this->getUrlBerkasJadwalKhusus($idjadwal_khusus_enc, $keyApps);
        $sql = "DELETE FROM jadwal_spmt 
                WHERE idjadwal_spmt = AES_DECRYPT(UNHEX('$idjadwal_khusus_enc'),SHA2($keyApps,512))";
        $this->db->query($sql);
        if ($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            return 0;
        }else{
            if($url_berkas_spmt!=''){
                //if(file_exists($_SERVER['DOCUMENT_ROOT']."/ekinerja2/berkas/".$url_berkas_spmt)){
                    //unlink($_SERVER['DOCUMENT_ROOT']."/ekinerja2/berkas/".$url_berkas_spmt);
                //}
                $connection = ssh2_connect('103.14.229.15');
                ssh2_auth_password($connection, 'rommonz', 'mony3Tmony3T');
                $sftp = ssh2_sftp($connection);
                error_reporting(0);
                if (file_exists('ssh2.sftp://' . $sftp . '/var/www/html/ekinerja2/berkas/'.$url_berkas_spmt)) {
                    ssh2_sftp_unlink($sftp, '/var/www/html/ekinerja2/berkas/'.$url_berkas_spmt);
                }
                error_reporting(1);
            }
            $this->db->trans_commit();
            return 1;
        }
    }

    public function getUrlBerkasJadwalKhusus($idjadwal_khusus_enc, $keyApps){
        $sql = "SELECT berkas_spmt 
                FROM jadwal_spmt 
                WHERE idjadwal_spmt = AES_DECRYPT(UNHEX('$idjadwal_khusus_enc'),SHA2($keyApps,512))";
        $rs = $this->db->query($sql);
        $rowcount = $rs->num_rows();
        if($rowcount>0){
            foreach ($rs->result() as $data) {
                $url_berkas_spmt = $data->berkas_spmt;
            }
        }else{
            $url_berkas_spmt = '';
        }
        return $url_berkas_spmt;
    }

    public function insert_jadwal_khusus_trans($data, $keyApps){
        $this->db->trans_begin();
        $idjadwal_spmt = '';
        $sqlText = '';
        for ($row = 0; $row < sizeof($data); $row++) {
            for ($col = 0; $col < sizeof($data[$row]); $col++) {
                $periode_bln = $data[$row]['periode_bln'];
                $periode_thn = $data[$row]['periode_thn'];
                $txtSebagai = "'".$data[$row]['txtSebagai']."'";
                $ddJenisJadwal = $data[$row]['ddJenisJadwal'];
                $idLokasiSekunder = $data[$row]['idLokasiSekunder'];
                $tipe_lokasi = "'".$data[$row]['tipe_lokasi']."'";
                $ddJamMulai = $data[$row]['ddJamMulai'];
                $ddMenitMulai = $data[$row]['ddMenitMulai'];
                $ddJamSelesai = $data[$row]['ddJamSelesai'];
                $ddMenitSelesai = $data[$row]['ddMenitSelesai'];
                $idPegawai = $data[$row]['idPegawai'];
                $tglMulaiRentang = "'".$data[$row]['tglMulaiRentang']."'";
                $tglSelesaiRentang = "'".$data[$row]['tglSelesaiRentang']."'";
                $idspmt_jadwal = $data[$row]['idspmt_jadwal'];
            }
            $sql = "INSERT INTO jadwal_transaksi (periode_bln, periode_thn, id_pegawai, 
                    tgl_mulai, tgl_selesai, jam_mulai, jam_selesai, id_jenis_jadwal, 
                    jabatan, keterangan, idjadwal_spmt) VALUES ($periode_bln, $periode_thn, AES_DECRYPT(UNHEX('$idPegawai'), SHA2($keyApps,512)), 
                    $tglMulaiRentang, $tglSelesaiRentang, 
                    '$ddJamMulai:$ddMenitMulai:00', '$ddJamSelesai:$ddMenitSelesai:00', 
                    $ddJenisJadwal, $txtSebagai, '', AES_DECRYPT(UNHEX('$idspmt_jadwal'), SHA2($keyApps,512))) ";
            //$sqlText .= $sql;
            $this->db->query($sql);

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $query = 0;
            }else{
                $idjadwal_trans = $this->db->insert_id();
                if($tipe_lokasi=="'utama'"){
                    $tipe_lokasi_sekunder = 0;
                }else{
                    $tipe_lokasi_sekunder = 1;
                }
                $sql = "INSERT INTO jadwal_unit_kerja(id_unit_kerja, flag_lokasi_sekunder, id_trans_jadwal)
                VALUES (AES_DECRYPT(UNHEX('$idLokasiSekunder'), SHA2($keyApps,512)), $tipe_lokasi_sekunder, $idjadwal_trans)";
                $this->db->query($sql);
                //$sqlText .= $sql;
                if ($this->db->trans_status() === FALSE) {
                    $this->db->trans_rollback();
                    $query = 0;
                }else{
                    $this->db->trans_commit();
                    $query = 1;
                }
            }
        }

        if($query > 0){
            return array(
                'query' => 1,
                'id' => $idjadwal_spmt
            );
        }else{
            return array(
                'query' => 0,
                'sql' => $sqlText
            );
        }

    }

    public function listof_jadwalTrans_Kalender_by_opd($bln, $thn, $opd){
        $sql = "SELECT js.no_spmt_jadwal as id,
                CONCAT('Jadwal ', js.keterangan, ' a.n. ',
                CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
                p.nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(' ',p.gelar_belakang) END), ' ', p.nip_baru, '. Tugas ',
                jm.jenis, ' sebagai ', jt.jabatan, ' pada unit kerja ', CASE WHEN ju.flag_lokasi_sekunder = 0 THEN 'Utama' ELSE 'Sekunder' END, ' di ',
                (CASE WHEN ju.flag_lokasi_sekunder = 0 THEN
                (SELECT nama_baru FROM unit_kerja WHERE id_unit_kerja = ju.id_unit_kerja) ELSE
                (SELECT nama FROM unit_kerja_sekunder WHERE id_uk_sekunder = ju.id_unit_kerja) END)) as title,
                CONCAT(DATE_FORMAT(jt.tgl_mulai, '%Y-%m-%d'), 'T',jt.jam_mulai) as start,
                CONCAT(DATE_FORMAT(jt.tgl_selesai, '%Y-%m-%d'), 'T',jt.jam_selesai) as end
                FROM jadwal_spmt js
                INNER JOIN jadwal_transaksi jt ON js.idjadwal_spmt = jt.idjadwal_spmt
                INNER JOIN jadwal_unit_kerja ju ON jt.id_trans_jadwal = ju.id_trans_jadwal
                INNER JOIN pegawai p ON jt.id_pegawai = p.id_pegawai
                INNER JOIN jadwal_master jm ON jt.id_jenis_jadwal = jm.id_jenis_jadwal
                WHERE ((MONTH(jt.tgl_mulai) = $bln AND YEAR(jt.tgl_mulai) = $thn) 
                OR (MONTH(jt.tgl_selesai) = $bln AND YEAR(jt.tgl_mulai) = $thn)) AND 
                js.id_skpd = AES_DECRYPT(UNHEX('$opd'),SHA2('keyloginekinerja',512)) 
                ORDER BY jt.tgl_mulai ASC";
        return $this->db->query($sql);
    }

    public function hapus_jadwal_trans($idjadwal_trans_enc, $keyApps){
        $this->db->trans_begin();
        $sql = "DELETE FROM jadwal_transaksi 
                WHERE id_trans_jadwal = AES_DECRYPT(UNHEX('$idjadwal_trans_enc'),SHA2($keyApps,512))";
        $this->db->query($sql);
        if ($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            return array(
                'query' => 0,
                'sql' => $sql
            );
        }else{
            $this->db->trans_commit();
            return array(
                'query' => 1,
                'sql' => $sql
            );
        }
    }

    public function listof_unit_jadwal_transaksi($id_trans_jadwal, $keyApps){
        $sql = "SELECT 
                HEX(AES_ENCRYPT(ju.id_uk_jadwal, SHA2($keyApps,512))) as id_ukjdwl_enc,
                HEX(AES_ENCRYPT(ju.id_unit_kerja, SHA2($keyApps,512))) as id_uk_enc,
                HEX(AES_ENCRYPT(ju.id_trans_jadwal, SHA2($keyApps,512))) as id_trans_jdwal_enc,
                (CASE WHEN ju.flag_lokasi_sekunder = 0 THEN 'Unit Utama' ELSE 'Unit Sekunder' END) as tipe_lokasi,
                (CASE WHEN ju.flag_lokasi_Sekunder = 0 THEN (SELECT nama_baru FROM unit_kerja WHERE id_unit_kerja = ju.id_unit_kerja)
                ELSE (SELECT nama FROM unit_kerja_sekunder WHERE id_uk_sekunder = ju.id_unit_kerja) END) as nama_unit,
                (CASE WHEN ju.flag_lokasi_Sekunder = 0 THEN (SELECT in_lat FROM unit_kerja WHERE id_unit_kerja = ju.id_unit_kerja)
                ELSE (SELECT in_lat FROM unit_kerja_sekunder WHERE id_uk_sekunder = ju.id_unit_kerja) END) as in_lat,
                (CASE WHEN ju.flag_lokasi_Sekunder = 0 THEN (SELECT in_long FROM unit_kerja WHERE id_unit_kerja = ju.id_unit_kerja)
                ELSE (SELECT in_long FROM unit_kerja_sekunder WHERE id_uk_sekunder = ju.id_unit_kerja) END) as in_long,
                (CASE WHEN ju.flag_lokasi_Sekunder = 0 THEN (SELECT out_lat FROM unit_kerja WHERE id_unit_kerja = ju.id_unit_kerja)
                ELSE (SELECT out_lat FROM unit_kerja_sekunder WHERE id_uk_sekunder = ju.id_unit_kerja) END) as out_lat,
                (CASE WHEN ju.flag_lokasi_Sekunder = 0 THEN (SELECT out_long FROM unit_kerja WHERE id_unit_kerja = ju.id_unit_kerja)
                ELSE (SELECT out_long FROM unit_kerja_sekunder WHERE id_uk_sekunder = ju.id_unit_kerja) END) as out_long, 
                (CASE WHEN ju.flag_lokasi_Sekunder = 0 THEN (SELECT alamat FROM unit_kerja WHERE id_unit_kerja = ju.id_unit_kerja)
                ELSE (SELECT alamat FROM unit_kerja_sekunder WHERE id_uk_sekunder = ju.id_unit_kerja) END) as alamat 
                FROM jadwal_unit_kerja ju 
                WHERE id_trans_jadwal = AES_DECRYPT(UNHEX('$id_trans_jadwal'), SHA2($keyApps,512))";
        return $this->db->query($sql);
    }

    public function ubah_jadwal_transkasi($id_trans_jadwal, $keyApps){
        $sql = "SELECT 
                HEX(AES_ENCRYPT(jt.id_trans_jadwal, SHA2($keyApps,512))) as id_trans_jdwl_enc,
                DATE_FORMAT(jt.tgl_mulai, '%m/%d/%Y') AS tgl_mulai, DATE_FORMAT(jt.tgl_selesai, '%m/%d/%Y') AS tgl_selesai, 
                DATE_FORMAT(jt.jam_mulai, '%H') AS jam_mulai, DATE_FORMAT(jt.jam_selesai, '%H') AS jam_selesai, 
                DATE_FORMAT(jt.jam_mulai, '%i') AS menit_mulai, DATE_FORMAT(jt.jam_selesai, '%i') AS menit_selesai, 
                jt.id_jenis_jadwal, jt.jabatan 
                FROM jadwal_transaksi jt 
                WHERE jt.id_trans_jadwal = AES_DECRYPT(UNHEX('$id_trans_jadwal'), SHA2($keyApps,512))";
        return $this->db->query($sql);
    }

    public function update_jadwal_khusus_detail_trans($data, $keyApps){
        $id_jenis_jadwal = $data['id_jenis_jadwal'];
        $tgl_mulai = "'".$data['tgl_mulai']."'";
        $tgl_selesai = "'".$data['tgl_selesai']."'";
        $jam_mulai = $data['jam_mulai'];
        $menit_mulai = $data['menit_mulai'];
        $wktMulai = "'".$jam_mulai.':'.$menit_mulai."'";
        $jam_selesai = $data['jam_selesai'];
        $menit_selesai = $data['menit_selesai'];
        $wktSelesai = "'".$jam_selesai.':'.$menit_selesai."'";
        $peran = "'".$data['peran']."'";
        $idLokasiSekunder = $data['idLokasiSekunder'];
        $tipe_lokasi = $data['tipe_lokasi'];
        $idjadwal_trans_enc = $data['idjadwal_trans_enc'];

        $this->db->trans_begin();
        $sql = "UPDATE jadwal_transaksi SET id_jenis_jadwal = $id_jenis_jadwal, 
                tgl_mulai = $tgl_mulai, tgl_selesai = $tgl_selesai, 
                jam_mulai = $wktMulai, jam_selesai = $wktSelesai, 
                jabatan = $peran 
                WHERE id_trans_jadwal = AES_DECRYPT(UNHEX('$idjadwal_trans_enc'), SHA2($keyApps,512))";

        $this->db->query($sql);
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return array(
                'query' => 0
            );
        }else{
            if($idLokasiSekunder==''){
                 $this->db->trans_commit();
                 return array(
                     'query' => 1
                 );
            }else{
                $sql = "SELECT COUNT(id_uk_jadwal) AS jumlah
                    FROM jadwal_unit_kerja
                    WHERE id_trans_jadwal = AES_DECRYPT(UNHEX('$idjadwal_trans_enc'),SHA2($keyApps,512)) AND 
                    id_unit_kerja = AES_DECRYPT(UNHEX('$idLokasiSekunder'),SHA2($keyApps,512)) AND 
                    flag_lokasi_sekunder = ".($tipe_lokasi=='sekunder'?1:0);

                $rs = $this->db->query($sql);
                $rowcount = $rs->num_rows();
                if($rowcount>0){
                    foreach ($rs->result() as $data) {
                        $jumlah = $data->jumlah;
                    }
                }else{
                    $jumlah = 0;
                }

                if($jumlah==0){
                    $sql = "INSERT INTO jadwal_unit_kerja(id_unit_kerja, flag_lokasi_sekunder, id_trans_jadwal)
                VALUES (AES_DECRYPT(UNHEX('$idLokasiSekunder'), SHA2($keyApps,512)), ".($tipe_lokasi=='sekunder'?1:0).", AES_DECRYPT(UNHEX('$idjadwal_trans_enc'), SHA2($keyApps,512)))";
                    $this->db->query($sql);
                }

                if ($this->db->trans_status() === FALSE) {
                    $this->db->trans_rollback();
                    return array(
                        'query' => 0
                    );
                }else{
                    $this->db->trans_commit();
                    return array(
                        'query' => 1
                    );
                }
            }
        }
    }

    public function jml_item_lainnya($ulevel, $id_pegawai, $id_skpd, $id_status_item, $txtKeyword){
        $andKlausa = '';
        if($ulevel == 'publik'){
            $andKlausa .= " AND kil.id_pegawai = AES_DECRYPT(UNHEX('$id_pegawai'),SHA2('keyloginekinerja',512))";
            if (!(trim($txtKeyword)== "") && !(trim($txtKeyword)== "0")){
                $andKlausa .= " AND (kil.keterangan LIKE '%$txtKeyword%' OR kji.jenis_item_lainnya LIKE '%$txtKeyword%' OR p1.nip_baru LIKE '%$txtKeyword%' OR p1.nama LIKE '%$txtKeyword%')";
            }
        }else{
            if($id_skpd!='0'){
                $andKlausa .= " AND uk.id_skpd = AES_DECRYPT(UNHEX('$id_skpd'), SHA2('keyloginekinerja',512))";
            }

            if($id_status_item!='0'){
                $andKlausa .= " AND kil.id_status_item_lainnya = $id_status_item";
            }
        }

        $sql = "SELECT COUNT(*) as jumlah 
                FROM knj_item_lainnya kil 
                INNER JOIN knj_jenis_item_lainnya kji ON kil.id_jenis_item = kji.id_jenis_item
                LEFT JOIN knj_status_usulan_item_lainnya ksu ON kil.id_status_item_lainnya = ksu.id_status_usulan_item_lainnya
                LEFT JOIN unit_kerja uk ON kil.id_unit_kerja = uk.id_unit_kerja
                INNER JOIN pegawai p1 ON kil.id_pegawai = p1.id_pegawai
                WHERE kil.id_item_lainnya IS NOT NULL $andKlausa";

        return $this->db->query($sql);
    }

    public function listof_item_lainnya($row_number_start, $ulevel, $id_pegawai, $id_skpd, $id_status_item, $txtKeyword, $limit, $keyApps){
        $andKlausa = '';
        if($ulevel == 'publik'){
            $andKlausa .= " AND kil.id_pegawai = AES_DECRYPT(UNHEX('$id_pegawai'),SHA2('keyloginekinerja',512))";
            if (!(trim($txtKeyword)== "") && !(trim($txtKeyword)== "0")){
                $andKlausa .= " AND (kil.keterangan LIKE '%$txtKeyword%' OR kji.jenis_item_lainnya LIKE '%$txtKeyword%' OR p1.nip_baru LIKE '%$txtKeyword%' OR p1.nama LIKE '%$txtKeyword%')";
            }
        }else{
            if($id_skpd!='0'){
                $andKlausa .= " AND uk.id_skpd = AES_DECRYPT(UNHEX('$id_skpd'), SHA2('keyloginekinerja',512))";
            }

            if($id_status_item!='0'){
                $andKlausa .= " AND kil.id_status_item_lainnya = $id_status_item";
            }

            if (!(trim($txtKeyword)== "") && !(trim($txtKeyword)== "0")){
                $andKlausa .= " AND (kil.keterangan LIKE '%$txtKeyword%' OR kji.jenis_item_lainnya LIKE '%$txtKeyword%' OR p1.nip_baru LIKE '%$txtKeyword%' OR p1.nama LIKE '%$txtKeyword%')";
            }
        }

        $this->db->query("SET @row_number := $row_number_start");
        $sql = "SELECT a.*, 
                p2.nip_baru as nip_inputer, CONCAT(CASE WHEN p2.gelar_depan = '' THEN '' ELSE CONCAT(p2.gelar_depan, ' ') END,
                p2.nama, CASE WHEN p2.gelar_belakang = '' THEN '' ELSE CONCAT(' ',p2.gelar_belakang) END) AS inputer,
                p3.nip_baru as nip_approver, CONCAT(CASE WHEN p3.gelar_depan = '' THEN '' ELSE CONCAT(p3.gelar_depan, ' ') END,
                p3.nama, CASE WHEN p3.gelar_belakang = '' THEN '' ELSE CONCAT(' ',p3.gelar_belakang) END) AS approver
                FROM (SELECT 
                HEX(AES_ENCRYPT(kil.id_item_lainnya, SHA2($keyApps,512))) as id_item_lainnya_enc,
                kil.waktu_input as waktu_input_ori, 
                DATE_FORMAT(kil.waktu_input, '%d-%m-%Y %H:%i:%s') AS waktu_input,
                DATE_FORMAT(kil.tmt_mulai, '%d-%m-%Y') AS tmt_mulai,
                DATE_FORMAT(kil.tmt_selesai, '%d-%m-%Y') AS tmt_selesai,
                kil.id_pegawai, p1.nip_baru as nip_pegawai, CONCAT(CASE WHEN p1.gelar_depan = '' THEN '' ELSE CONCAT(p1.gelar_depan, ' ') END,
                p1.nama, CASE WHEN p1.gelar_belakang = '' THEN '' ELSE CONCAT(' ',p1.gelar_belakang) END) AS nama_pegawai,
                kil.keterangan, uk.nama_baru as unit_kerja, uk.id_skpd,
                kji.jenis_item_lainnya, kji.kategori_item, kji.persen_tunjangan,
                kji.keterangan as ket_item, ksu.status_usulan_item_lainnya, kil.id_pegawai_input,
                DATE_FORMAT(kil.tgl_approved, '%d-%m-%Y %H:%i:%s') AS tgl_approved,
                kil.catatan_approved, kil.id_pegawai_approved, kil.no_sk, kil.berkas_sk 
                FROM knj_item_lainnya kil 
                INNER JOIN knj_jenis_item_lainnya kji ON kil.id_jenis_item = kji.id_jenis_item
                LEFT JOIN knj_status_usulan_item_lainnya ksu ON kil.id_status_item_lainnya = ksu.id_status_usulan_item_lainnya
                LEFT JOIN unit_kerja uk ON kil.id_unit_kerja = uk.id_unit_kerja
                INNER JOIN pegawai p1 ON kil.id_pegawai = p1.id_pegawai 
                WHERE kil.id_item_lainnya IS NOT NULL $andKlausa) a 
                LEFT JOIN pegawai p2 ON a.id_pegawai_input = p2.id_pegawai 
                LEFT JOIN pegawai p3 ON a.id_pegawai_approved = p3.id_pegawai 
                ORDER BY a.waktu_input_ori DESC $limit";

        return $this->db->query($sql);
    }

    public function ref_jenis_item_lainnya(){
        $sql = "SELECT kji.id_jenis_item, kji.jenis_item_lainnya
                FROM knj_jenis_item_lainnya kji
                WHERE kji.id_jenis_tunjangan = 2";
        return $this->db->query($sql);
    }

    public function hapus_unit_kerja_jadwal($id_ukjdwl_enc, $keyApps){
        $this->db->trans_begin();
        $sql = "DELETE FROM jadwal_unit_kerja 
                WHERE id_uk_jadwal = AES_DECRYPT(UNHEX('$id_ukjdwl_enc'),SHA2($keyApps,512))";
        $this->db->query($sql);
        if ($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            return array(
                'query' => 0,
                'sql' => $sql
            );
        }else{
            $this->db->trans_commit();
            return array(
                'query' => 1,
                'sql' => $sql
            );
        }
    }

    public function ref_status_item_lainnya(){
        $sql = "SELECT * FROM `knj_status_usulan_item_lainnya`";
        return $this->db->query($sql);
    }

    public function insert_item_lainnya($data, $keyApps){
        $ddItemLainnya = $data['ddItemLainnya'];
        $tglMulaiBerlaku = "'".$data['tglMulaiBerlaku']."'";
        $tglSelesaiBerlaku = "'".$data['tglSelesaiBerlaku']."'";
        $txtNoSk = "'".$data['txtNoSk']."'";
        $txtKeterangan = "'".$data['txtKeterangan']."'";
        $id_pegawai = $data['id_pegawai'];
        $id_unit_kerja = $data['id_unit_kerja'];
        $inputer = $data['inputer'];

        $this->db->trans_begin();
        $sql = "INSERT INTO knj_item_lainnya(waktu_input, id_jenis_item, tmt_mulai, tmt_selesai, id_pegawai, keterangan,
                id_unit_kerja, no_sk, id_pegawai_input, id_status_item_lainnya, tgl_approved, catatan_approved, id_pegawai_approved) 
                VaLUES (NOW(), $ddItemLainnya, $tglMulaiBerlaku, $tglSelesaiBerlaku, AES_DECRYPT(UNHEX('$id_pegawai'), SHA2($keyApps,512)), $txtKeterangan, 
                $id_unit_kerja, $txtNoSk, AES_DECRYPT(UNHEX('$inputer'),SHA2('keyloginekinerja',512)), 4, NOW(), '-', AES_DECRYPT(UNHEX('$inputer'),SHA2('keyloginekinerja',512)))";
        $this->db->query($sql);
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return array(
                'query' => 0,
                'id_item_lainnya' => ''
            );
        }else{
            $id_item_lainnya = $this->db->insert_id();
            $this->db->trans_commit();
            return array(
                'query' => 1,
                'id_item_lainnya' => $id_item_lainnya
            );
        }
    }

    public function update_url_berkas_sk_item_lainnya($nf, $iditem_lainnya, $keyApps){
        $this->db->trans_begin();
        $sql = "UPDATE knj_item_lainnya 
                SET berkas_sk = '$nf' 
                WHERE id_item_lainnya = $iditem_lainnya";
        $this->db->query($sql);
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return array(
                'query' => 0,
                'sql' => $sql
            );
        }else{
            $this->db->trans_commit();
            return array(
                'query' => 1,
            );
        }
    }

    public function ubahItemLainnya($iditem_lainnya_enc, $keyApps){
        $sql = "SELECT kil.*, DATE_FORMAT(kil.waktu_input, '%d-%m-%Y') AS waktu_input2,
                DATE_FORMAT(kil.tmt_mulai, '%m/%d/%Y') AS tmt_mulai2, DATE_FORMAT(kil.tmt_selesai, '%m/%d/%Y') AS tmt_selesai2,
                p.nip_baru, CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
                p.nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(' ',p.gelar_belakang) END) AS nama_pegawai,
                uk.nama_baru AS unit_kerja, HEX(AES_ENCRYPT(kil.id_item_lainnya, SHA2($keyApps,512))) as id_item_lainnya_enc 
                FROM knj_item_lainnya kil LEFT JOIN pegawai p ON kil.id_pegawai = p.id_pegawai
                LEFT JOIN unit_kerja uk ON kil.id_unit_kerja = uk.id_unit_kerja
                WHERE kil.id_item_lainnya = AES_DECRYPT(UNHEX('$iditem_lainnya_enc'), SHA2($keyApps,512))";
        return $this->db->query($sql);
    }
    
    public function update_item_lainnya($data, $keyApps){
        $ddItemLainnya = $data['ddItemLainnya'];
        $tglMulaiBerlaku = "'".$data['tglMulaiBerlaku']."'";
        $tglSelesaiBerlaku = "'".$data['tglSelesaiBerlaku']."'";
        $txtNoSk = "'".$data['txtNoSk']."'";
        $txtKeterangan = "'".$data['txtKeterangan']."'";
        $id_pegawai = $data['id_pegawai'];
        $id_unit_kerja = $data['id_unit_kerja'];
        $id_item_lainnya_enc = $data['id_item_lainnya_enc'];
        
        $this->db->trans_begin();

        $sql = "UPDATE knj_item_lainnya SET id_jenis_item = $ddItemLainnya, tmt_mulai = $tglMulaiBerlaku,
                tmt_selesai = $tglSelesaiBerlaku, id_pegawai = AES_DECRYPT(UNHEX('$id_pegawai'), SHA2($keyApps,512)), 
                keterangan = $txtKeterangan, id_unit_kerja = $id_unit_kerja, no_sk = $txtNoSk 
                WHERE id_item_lainnya = AES_DECRYPT(UNHEX('$id_item_lainnya_enc'), SHA2($keyApps,512))";
        //echo $sql;
        $this->db->query($sql);
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return array(
                'query' => 0
            );
        }else{
            $this->db->trans_commit();
            return array(
                'query' => 1
            );
        }
    }

    public function hapus_kinerja_item_lainnya($id_item_lainnya_enc, $keyApps){
        $this->db->trans_begin();
        $sql = "DELETE FROM knj_item_lainnya 
                WHERE id_item_lainnya = AES_DECRYPT(UNHEX('$id_item_lainnya_enc'),SHA2($keyApps,512))";
        $this->db->query($sql);
        if ($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            return array(
                'query' => 0,
                'sql' => $sql
            );
        }else{
            $this->db->trans_commit();
            return array(
                'query' => 1,
                'sql' => $sql
            );
        }
    }

    public function riwayat_skp_by_idpegawai($id_pegawai_enc, $keyApps){
        $sql = "SELECT HEX(AES_ENCRYPT(skh.id_skp, SHA2($keyApps,512))) as id_skp, YEAR(skh.periode_awal) as tahun, DATE_FORMAT(skh.periode_awal, '%d-%m-%Y') AS periode_awal,
                DATE_FORMAT(skh.periode_akhir, '%d-%m-%Y') AS periode_akhir, skh.jabatan_pegawai, 
                uk.nama_baru as unit_kerja, sst.status
                FROM skp_header skh INNER JOIN skp_status sst ON skh.status_pengajuan = sst.kode_status
                LEFT JOIN unit_kerja uk ON skh.id_unit_kerja_pegawai = uk.id_unit_kerja
                WHERE skh.id_pegawai = AES_DECRYPT(UNHEX('$id_pegawai_enc'),SHA2('keyloginekinerja',512))
                ORDER BY skh.periode_awal DESC";
        return $this->db->query($sql);
    }

    public function skp_header_byid($id_skp_enc, $keyApps){
        $sql = "SELECT skh.id_skp, skh.jabatan_pegawai, uk.nama_baru as unit_kerja, p1.nip_baru as nip_penilai,
                CONCAT(CASE WHEN p1.gelar_depan = '' THEN '' ELSE CONCAT(p1.gelar_depan, ' ') END,
                p1.nama, CASE WHEN p1.gelar_belakang = '' THEN '' ELSE CONCAT(' ',p1.gelar_belakang) END) as nama_penilai, skh.gol_penilai, skh.jabatan_penilai,
                p2.nip_baru as nip_atasan_penilai, CONCAT(CASE WHEN p2.gelar_depan = '' THEN '' ELSE CONCAT(p2.gelar_depan, ' ') END,
                p2.nama, CASE WHEN p2.gelar_belakang = '' THEN '' ELSE CONCAT(' ',p2.gelar_belakang) END) as nama_atasan_penilai,
                skh.gol_atasan_penilai, skh.jabatan_atasan_penilai,
                skh.periode_awal, skh.periode_akhir, skh.orientasi_pelayanan, skh.integritas, skh.komitmen, skh.disiplin,
                skh.kerjasama, skh.kepemimpinan, sst.status
                FROM skp_header skh
                LEFT JOIN unit_kerja uk ON skh.id_unit_kerja_pegawai = uk.id_unit_kerja
                LEFT JOIN pegawai p1 ON skh.id_penilai = p1.id_pegawai
                LEFT JOIN pegawai p2 ON skh.id_atasan_penilai = p2.id_pegawai
                INNER JOIN skp_status sst ON skh.status_pengajuan = sst.kode_status
                WHERE skh.id_skp = AES_DECRYPT(UNHEX('$id_skp_enc'),SHA2($keyApps,512))";
        return $this->db->query($sql);
    }

    public function skp_target_byid($id_skp_enc, $keyApps){
        $sql = "SELECT * FROM skp_target st 
                WHERE st.id_skp = AES_DECRYPT(UNHEX('$id_skp_enc'),SHA2($keyApps,512))";
        return $this->db->query($sql);
    }

    public function skp_tambahan_byid($id_skp_enc, $keyApps){
        $sql = "SELECT * FROM skp_tambahan_kreatifitas stk 
                WHERE stk.id_skp = AES_DECRYPT(UNHEX('$id_skp_enc'),SHA2($keyApps,512))";
        return $this->db->query($sql);
    }

    public function get_hist_staf_ekinerja($id_pegawai_enc){
        $sql = "SELECT a.*, HEX(AES_ENCRYPT(a.id_pegawai_pelapor,SHA2('keyloginekinerja',512))) AS id_pegawai_enc,
                p.nip_baru, CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
                nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(' ',p.gelar_belakang) END) AS nama,p.jenjab, p.pangkat_gol,
                CASE WHEN p.jenjab = 'Fungsional' THEN (SELECT jaf.id_jafung AS kode_jabatan FROM jafung_pegawai jap, jafung jaf
                WHERE jap.id_jafung = jaf.id_jafung AND jap.id_pegawai = p.id_pegawai ORDER BY jap.tmt DESC LIMIT 1) ELSE CASE WHEN p.id_j IS NULL THEN (SELECT jm.id_jfu AS kode_jabatan FROM jfu_pegawai jp, jfu_master jm
                WHERE jp.kode_jabatan = jm.kode_jabatan AND jp.id_pegawai = p.id_pegawai ORDER BY jp.tmt DESC LIMIT 1) ELSE j.id_j END END AS kode_jabatan,
                CASE WHEN p.jenjab = 'Fungsional' THEN (SELECT jaf.kelas_jabatan AS kode_jabatan FROM jafung_pegawai jap, jafung jaf
                WHERE jap.id_jafung = jaf.id_jafung AND jap.id_pegawai = p.id_pegawai ORDER BY jap.tmt DESC LIMIT 1) ELSE CASE WHEN p.id_j IS NULL THEN (SELECT jm.kelas_jabatan AS kode_jabatan FROM jfu_pegawai jp, jfu_master jm
                WHERE jp.kode_jabatan = jm.kode_jabatan AND jp.id_pegawai = p.id_pegawai ORDER BY jp.tmt DESC LIMIT 1) ELSE j.kelas_jabatan END END AS kelas_jabatan,
                CASE WHEN p.jenjab = 'Fungsional' THEN (SELECT jaf.nilai_jabatan AS kode_jabatan FROM jafung_pegawai jap, jafung jaf
                WHERE jap.id_jafung = jaf.id_jafung AND jap.id_pegawai = p.id_pegawai ORDER BY jap.tmt DESC LIMIT 1) ELSE CASE WHEN p.id_j IS NULL THEN (SELECT jm.nilai_jabatan AS kode_jabatan FROM jfu_pegawai jp, jfu_master jm
                WHERE jp.kode_jabatan = jm.kode_jabatan AND jp.id_pegawai = p.id_pegawai ORDER BY jp.tmt DESC LIMIT 1) ELSE j.nilai_jabatan END END AS nilai_jabatan,
                CASE WHEN p.jenjab = 'Fungsional' THEN (CASE WHEN (SELECT jaf.nama_jafung AS jabatan FROM jafung_pegawai jap, jafung jaf
                WHERE jap.id_jafung = jaf.id_jafung AND jap.id_pegawai = p.id_pegawai ORDER BY jap.tmt DESC LIMIT 1) IS NULL THEN p.jabatan ELSE (SELECT jaf.nama_jafung AS jabatan FROM jafung_pegawai jap, jafung jaf
                WHERE jap.id_jafung = jaf.id_jafung AND jap.id_pegawai = p.id_pegawai ORDER BY jap.tmt DESC LIMIT 1) END) ELSE CASE WHEN p.id_j IS NULL THEN (SELECT jm.nama_jfu AS jabatan FROM jfu_pegawai jp, jfu_master jm
                WHERE jp.kode_jabatan = jm.kode_jabatan AND jp.id_pegawai = p.id_pegawai ORDER BY jp.tmt DESC LIMIT 1) ELSE j.jabatan END END AS jabatan,
                CASE WHEN j.eselon IS NULL THEN 'Z' ELSE j.eselon END AS eselon, uk.nama_baru as unit_kerja,
                knjm.periode_thn, knjm.periode_bln, knjm.flag_kalkulasi, knjm.tgl_update_kalkulasi, ksk.status_knj
                FROM
                (SELECT knj.id_pegawai_pelapor, MAX(CONCAT(periode_thn, periode_bln)) as periode
                FROM knj_kinerja_master knj
                WHERE knj.last_atsl_idp = AES_DECRYPT(UNHEX('$id_pegawai_enc'),SHA2('keyloginekinerja',512))
                GROUP BY knj.id_pegawai_pelapor) a INNER JOIN knj_kinerja_master knjm ON a.id_pegawai_pelapor = knjm.id_pegawai_pelapor
                AND a.periode = CONCAT(knjm.periode_thn, knjm.periode_bln) 
                INNER JOIN knj_status_kinerja ksk ON knjm.id_status_knj = ksk.id_status_knj 
                INNER JOIN pegawai p ON p.id_pegawai = a.id_pegawai_pelapor
                LEFT JOIN jabatan j ON p.id_j = j.id_j, current_lokasi_kerja clk, unit_kerja uk
                WHERE p.id_pegawai = clk.id_pegawai AND clk.id_unit_kerja = uk.id_unit_kerja ORDER BY p.nama";
        return $this->db->query($sql);
    }

    public function jumlah_pegawai_info_kinerja($id_skpd, $last_periode, $keyword){
        $andKlausa = '';
        if($keyword != ''){
            $andKlausa .= " AND (p.nip_baru LIKE '%$keyword%' OR p.nama LIKE '%$keyword%')";
        }

        if($last_periode == 'Ada'){
            $andKlausa .= " AND kinerja.last_periode IS NOT NULL AND kinerja.last_periode = CONCAT(YEAR(NOW()), MONTH(NOW()))";
        }elseif($last_periode == 'Tidak Ada'){
            $andKlausa .= " AND (kinerja.last_periode IS NULL OR kinerja.last_periode <> CONCAT(YEAR(NOW()), MONTH(NOW())))";
        }

        $sql = "SELECT COUNT(p.id_pegawai) as jumlah 
                FROM pegawai p LEFT JOIN jabatan j ON p.id_j = j.id_j
                LEFT JOIN (
                SELECT b.id_pegawai, jm.id_jfu as kode_jabatan_jfu, jm.kelas_jabatan as kelas_jabatan_jfu,
                jm.nilai_jabatan as nilai_jabatan_jfu, jm.nama_jfu
                FROM (SELECT a.*, jp.id_jfu FROM
                (SELECT jp.id_pegawai, MAX(jp.id) as id_jfu_pegawai FROM jfu_pegawai jp,
                (SELECT id_pegawai, MAX(tmt) as max_tmt FROM jfu_pegawai WHERE tmt IS NOT NULL GROUP BY id_pegawai) x
                WHERE jp.id_pegawai = x.id_pegawai AND jp.tmt = x.max_tmt
                GROUP BY jp.id_pegawai) a
                INNER JOIN jfu_pegawai jp ON a.id_jfu_pegawai = jp.id) b
                INNER JOIN jfu_master jm ON b.id_jfu = jm.id_jfu) jfu ON jfu.id_pegawai = p.id_pegawai
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
                SELECT knj.id_pegawai_pelapor, MAX(CONCAT(knj.periode_thn, periode_bln)) AS last_periode,
                COUNT(knj.id_knj_master) AS jumlah_laporan
                FROM knj_kinerja_master knj GROUP BY knj.id_pegawai_pelapor
                ) kinerja ON kinerja.id_pegawai_pelapor = p.id_pegawai
                LEFT JOIN current_lokasi_kerja clk ON p.id_pegawai = clk.id_pegawai
                LEFT JOIN unit_kerja uk ON clk.id_unit_kerja = uk.id_unit_kerja
                WHERE p.flag_pensiun = 0 AND uk.id_skpd = AES_DECRYPT(UNHEX('$id_skpd'),SHA2('keyloginekinerja',512)) $andKlausa";

        return $this->db->query($sql);
    }

    public function list_pegawai_info_kinerja($row_number_start, $id_skpd, $last_periode, $keyword, $limit){
        $andKlausa = '';
        if($keyword != ''){
            $andKlausa .= " AND (p.nip_baru LIKE '%$keyword%' OR p.nama LIKE '%$keyword%')";
        }

        if($last_periode == 'Ada'){
            $andKlausa .= " AND kinerja.last_periode IS NOT NULL AND kinerja.last_periode = CONCAT(YEAR(NOW()), MONTH(NOW()))";
        }elseif($last_periode == 'Tidak Ada'){
            $andKlausa .= " AND (kinerja.last_periode IS NULL OR kinerja.last_periode <> CONCAT(YEAR(NOW()), MONTH(NOW())))";
        }

        $this->db->query("SET @row_number := $row_number_start");
        $sql = "SELECT a.*, kkm.flag_kalkulasi, kkm.tgl_update_kalkulasi, ksk.status_knj, kkm.persen_kinerja_final, kkm.last_persen_disiplin
                FROM 
                (SELECT HEX(AES_ENCRYPT(p.id_pegawai, SHA2('keyloginekinerja',512))) AS id_pegawai_enc, p.id_pegawai,
                p.nip_baru, CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
                nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(' ',p.gelar_belakang) END) AS nama,
                p.jenjab, p.pangkat_gol, CASE WHEN j.eselon IS NULL THEN 'Staf' ELSE j.eselon END AS eselon,
                CASE WHEN p.jenjab = 'Fungsional' THEN (jafung.kode_jabatan_jafung) ELSE
                CASE WHEN p.id_j IS NULL THEN (jfu.kode_jabatan_jfu) ELSE j.id_j END END AS kode_jabatan,
                CASE WHEN p.jenjab = 'Fungsional' THEN (jafung.kelas_jabatan_jafung) ELSE
                CASE WHEN p.id_j IS NULL THEN (jfu.kelas_jabatan_jfu) ELSE j.kelas_jabatan END END AS kelas_jabatan,
                CASE WHEN p.jenjab = 'Fungsional' THEN (jafung.nilai_jabatan_jafung) ELSE
                CASE WHEN p.id_j IS NULL THEN (jfu.nilai_jabatan_jfu) ELSE j.nilai_jabatan END END AS nilai_jabatan,
                CASE WHEN p.jenjab = 'Fungsional' THEN (CASE WHEN jafung.nama_jafung IS NULL THEN p.jabatan ELSE jafung.nama_jafung END) ELSE
                CASE WHEN p.id_j IS NULL THEN (jfu.nama_jfu) ELSE j.jabatan END END AS jabatan,
                p.status_aktif, kinerja.last_periode, kinerja.jumlah_laporan
                FROM pegawai p LEFT JOIN jabatan j ON p.id_j = j.id_j
                LEFT JOIN (
                SELECT b.id_pegawai, jm.id_jfu as kode_jabatan_jfu, jm.kelas_jabatan as kelas_jabatan_jfu,
                jm.nilai_jabatan as nilai_jabatan_jfu, jm.nama_jfu
                FROM (SELECT a.*, jp.id_jfu FROM
                (SELECT jp.id_pegawai, MAX(jp.id) as id_jfu_pegawai FROM jfu_pegawai jp,
                (SELECT id_pegawai, MAX(tmt) as max_tmt FROM jfu_pegawai WHERE tmt IS NOT NULL GROUP BY id_pegawai) x
                WHERE jp.id_pegawai = x.id_pegawai AND jp.tmt = x.max_tmt
                GROUP BY jp.id_pegawai) a
                INNER JOIN jfu_pegawai jp ON a.id_jfu_pegawai = jp.id) b
                INNER JOIN jfu_master jm ON b.id_jfu = jm.id_jfu) jfu ON jfu.id_pegawai = p.id_pegawai
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
                SELECT knj.id_pegawai_pelapor, MAX(CONCAT(knj.periode_thn, periode_bln)) AS last_periode,
                COUNT(knj.id_knj_master) AS jumlah_laporan
                FROM knj_kinerja_master knj GROUP BY knj.id_pegawai_pelapor
                ) kinerja ON kinerja.id_pegawai_pelapor = p.id_pegawai
                LEFT JOIN current_lokasi_kerja clk ON p.id_pegawai = clk.id_pegawai
                LEFT JOIN unit_kerja uk ON clk.id_unit_kerja = uk.id_unit_kerja
                WHERE p.flag_pensiun = 0 AND uk.id_skpd = AES_DECRYPT(UNHEX('$id_skpd'),SHA2('keyloginekinerja',512)) $andKlausa 
                ORDER BY eselon, pangkat_gol DESC, nama $limit) a
                LEFT JOIN knj_kinerja_master kkm ON a.last_periode = CONCAT(kkm.periode_thn, kkm.periode_bln)
                AND a.id_pegawai = kkm.id_pegawai_pelapor
                LEFT JOIN knj_status_kinerja ksk ON kkm.id_status_knj = ksk.id_status_knj
                ORDER BY a.eselon, a.pangkat_gol DESC, a.nama";
        
        return $this->db->query($sql);
    }

    public function list_item_kinerja_lainnya_by_idpegawai($id_pegawai_enc, $bln, $thn){
        $sql = "SELECT kil.id_pegawai, DATE_FORMAT(kil.tmt_mulai, '%d-%m-%Y') as tmt_mulai, DATE_FORMAT(kil.tmt_selesai, '%d-%m-%Y') as tmt_selesai, kil.id_jenis_item,
                kji.jenis_item_lainnya, kil.no_sk, kil.keterangan as ket_unsur_lain, kji.kategori_item, kji.persen_tunjangan, kji.keterangan
                FROM knj_item_lainnya kil 
                INNER JOIN knj_jenis_item_lainnya kji ON kil.id_jenis_item = kji.id_jenis_item
                INNER JOIN knj_status_usulan_item_lainnya ksu ON kil.id_status_item_lainnya = ksu.id_status_usulan_item_lainnya
                WHERE kil.id_pegawai = AES_DECRYPT(UNHEX('$id_pegawai_enc'),SHA2('keyloginekinerja',512))
                AND ((MONTH(kil.tmt_selesai) = $bln AND YEAR(kil.tmt_selesai) = $thn) OR
                (MONTH(kil.tmt_mulai) = $bln AND YEAR(kil.tmt_mulai) = $thn)) 
                ORDER BY kil.tmt_mulai ASC";

        return $this->db->query($sql);
    }

    public function jumlah_laporan_kinerja_by_opd($id_skpd_enc, $id_sts_laporan, $jenjab, $eselon, $bln, $thn, $keyword){
        $andKlausa = '';

        if($id_sts_laporan!='0'){
            $andKlausa .= " AND knj.id_status_knj = $id_sts_laporan";
        }

        if($jenjab!='0'){
            $andKlausa .= " AND knj.last_jenjab = $jenjab";
        }

        if($eselon!='0'){
            $andKlausa .= " AND knj.last_eselon = $eselon";
        }

        if($bln!='0'){
            $andKlausa .= " AND knj.periode_bln = $bln";
        }

        if($thn!='0'){
            $andKlausa .= " AND knj.periode_thn = $thn";
        }

        if (!(trim($keyword)== "") && !(trim($keyword)== "0")){
            $andKlausa .= " AND (knj.last_jabatan LIKE '%$keyword%' OR p.nip_baru LIKE '%$keyword%' OR p.nama LIKE '%$keyword%')";
        }

        $sql = "SELECT COUNT(*) AS jumlah
                FROM knj_kinerja_master knj
                LEFT JOIN unit_kerja uk ON knj.last_id_unit_kerja = uk.id_unit_kerja
                LEFT JOIN pegawai p ON knj.id_pegawai_pelapor = p.id_pegawai
                WHERE uk.id_skpd = AES_DECRYPT(UNHEX('$id_skpd_enc'),SHA2('keyloginekinerja',512)) $andKlausa";
        return $this->db->query($sql);
    }
    
    public function list_laporan_kinerja_by_opd($row_number_start, $id_skpd_enc, $id_sts_laporan, $jenjab, $eselon, $bln, $thn, $keyword, $limit, $keyApps){
        $andKlausa = '';
        if($id_sts_laporan!='0'){
            $andKlausa .= " AND knj.id_status_knj = $id_sts_laporan";
        }

        if($jenjab!='0'){
            $andKlausa .= " AND knj.last_jenjab = $jenjab";
        }

        if($eselon!='0'){
            $andKlausa .= " AND knj.last_eselon = $eselon";
        }

        if($bln!='0'){
            $andKlausa .= " AND knj.periode_bln = $bln";
        }

        if($thn!='0'){
            $andKlausa .= " AND knj.periode_thn = $thn";
        }

        if (!(trim($keyword)== "") && !(trim($keyword)== "0")){
            $andKlausa .= " AND (knj.last_jabatan LIKE '%$keyword%' OR p.nip_baru LIKE '%$keyword%' OR p.nama LIKE '%$keyword%')";
        }
        
        $this->db->query("SET @row_number := $row_number_start");
        $sql = "SELECT knj.id_knj_master, HEX(AES_ENCRYPT(knj.id_knj_master,SHA2($keyApps,512))) as id_knj_master_enc, knj.periode_bln, knj.periode_thn, p.nip_baru, CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
                nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(' ',p.gelar_belakang) END) AS nama, p.pangkat_gol,
                knj.tgl_input_kinerja, knj.last_jenjab, knj.last_kode_jabatan, knj.last_jabatan, CASE WHEN knj.last_eselon = '' THEN 'Staf' ELSE knj.last_eselon END AS last_eselon,
                knj.last_gol, knj.last_atsl_nip, knj.last_atsl_nama, knj.last_atsl_jabatan, knj.last_pjbt_nip, knj.last_pjbt_nama, knj.last_pjbt_jabatan, kns.status_knj, knj.flag_kalkulasi, knj.tgl_update_kalkulasi, 
                knj.jml_menit_efektif_kerja, knj.jml_waktu_kinerja_accu, knj.persen_kinerja_accu, knj.rupiah_kinerja, knj.jml_bawahan_aktual, knj.jml_bawahan_kinerja,
                knj.jml_waktu_kinerja_accu_bawahan, knj.persen_kinerja_accu_bawahan, knj.persen_kinerja_bawahan_aktual, knj.persen_kinerja_aktual,
                knj.rupiah_kinerja_aktual, knj.jml_hari_efektif_kerja, knj.jml_kehadiran_accu, knj.persen_kehadiran_accu, knj.jml_tidak_hadir_accu,
                knj.persen_minus_tidak_hadir_accu, knj.persen_minus_terlambat_plg_cpt_accu, knj.jml_hari_efektif_apel, knj.jml_tidak_apel_accu,
                knj.persen_minus_tidak_apel_accu, knj.jumlah_penambahan_item_lain, knj.persen_penambahan_item_lain, knj.jumlah_pengurangan_item_lain,
                knj.persen_pengurangan_item_lain, knj.persen_disiplin_final, knj.rupiah_disiplin, knj.rupiah_awal_kinerja, knj.rupiah_awal_disiplin,
                knj.persen_kinerja_final, knj.rupiah_kinerja_final, knj.jumlah_pengurangan_item_lain_maks, knj.persen_pengurangan_item_lain_maks,
                knj.last_persen_disiplin, knj.last_rupiah_disiplin, knj.last_rupiah_kinerja_final 
                FROM knj_kinerja_master knj 
                LEFT JOIN unit_kerja uk ON knj.last_id_unit_kerja = uk.id_unit_kerja
                LEFT JOIN pegawai p ON knj.id_pegawai_pelapor = p.id_pegawai 
                LEFT JOIN knj_status_kinerja kns ON knj.id_status_knj = kns.id_status_knj 
                WHERE uk.id_skpd = AES_DECRYPT(UNHEX('$id_skpd_enc'),SHA2('keyloginekinerja',512)) $andKlausa 
                ORDER BY knj.periode_thn DESC, knj.periode_bln DESC, last_eselon ASC, p.nama ASC $limit";
        return $this->db->query($sql);
    }

    public function getInputerJadwalByOPD($id_skpd_enc){
        $sql = "SELECT a.*, uk.nama_baru as unit, p.nama, p.nip_baru FROM 
                (SELECT jsp.id_skpd, jsp.inputer, HEX(AES_ENCRYPT(jsp.inputer,SHA2('keyloginekinerja',512))) as inputer_enc, COUNT(jsp.idjadwal_spmt) as jumlah 
                FROM jadwal_spmt jsp WHERE jsp.id_skpd = AES_DECRYPT(UNHEX('$id_skpd_enc'),SHA2('keyloginekinerja',512)) 
                GROUP BY jsp.id_skpd, jsp.inputer) a LEFT JOIN unit_kerja uk ON a.id_skpd = uk.id_unit_kerja 
                LEFT JOIN pegawai p ON a.inputer = p.id_pegawai 
                ORDER BY uk.nama_baru, p.nama";
        return $this->db->query($sql);
    }

    public function cetak_laporan_kinerja_by_opd($id_skpd_enc, $bln, $thn, $keyApps){
        $andKlausa = '';
        if($bln!='0'){
            $andKlausa .= " AND knj.periode_bln = $bln";
        }else{
            $andKlausa .= " AND knj.periode_bln = ".(int)date('m');
        }

        if($thn!='0'){
            $andKlausa .= " AND knj.periode_thn = $thn";
        }else{
            $andKlausa .= " AND knj.periode_thn = ".date('Y');
        }

        $sql = "SELECT knj.id_knj_master, HEX(AES_ENCRYPT(knj.id_knj_master,SHA2($keyApps,512))) as id_knj_master_enc, knj.periode_bln, knj.periode_thn, p.nip_baru, CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
                nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(' ',p.gelar_belakang) END) AS nama, p.pangkat_gol,
                knj.tgl_input_kinerja, knj.last_jenjab, knj.last_kode_jabatan, knj.last_jabatan, CASE WHEN knj.last_eselon = '' THEN 'Staf' ELSE knj.last_eselon END AS last_eselon,
                knj.last_gol, knj.last_atsl_nip, knj.last_atsl_nama, knj.last_atsl_jabatan, knj.last_pjbt_nip, knj.last_pjbt_nama, knj.last_pjbt_jabatan, kns.status_knj, knj.flag_kalkulasi, knj.tgl_update_kalkulasi, 
                knj.jml_menit_efektif_kerja, knj.jml_waktu_kinerja_accu, knj.persen_kinerja_accu, knj.rupiah_kinerja, knj.jml_bawahan_aktual, knj.jml_bawahan_kinerja,
                knj.jml_waktu_kinerja_accu_bawahan, knj.persen_kinerja_accu_bawahan, knj.persen_kinerja_bawahan_aktual, knj.persen_kinerja_aktual,
                knj.rupiah_kinerja_aktual, knj.jml_hari_efektif_kerja, knj.jml_kehadiran_accu, knj.persen_kehadiran_accu, knj.jml_tidak_hadir_accu,
                knj.persen_minus_tidak_hadir_accu, knj.persen_minus_terlambat_plg_cpt_accu, knj.jml_hari_efektif_apel, knj.jml_tidak_apel_accu,
                knj.persen_minus_tidak_apel_accu, knj.jumlah_penambahan_item_lain, knj.persen_penambahan_item_lain, knj.jumlah_pengurangan_item_lain,
                knj.persen_pengurangan_item_lain, knj.persen_disiplin_final, knj.rupiah_disiplin, knj.rupiah_awal_kinerja, knj.rupiah_awal_disiplin,
                knj.persen_kinerja_final, knj.rupiah_kinerja_final, knj.jumlah_pengurangan_item_lain_maks, knj.persen_pengurangan_item_lain_maks,
                knj.last_persen_disiplin, knj.last_rupiah_disiplin, knj.last_rupiah_kinerja_final, GROUP_CONCAT(DISTINCT CONCAT('Kelas: ',kha.kelas_jabatan, ' Nilai: ', kha.nilai_jabatan)) as kelas_jabatan 
                FROM knj_kinerja_master knj 
                LEFT JOIN unit_kerja uk ON knj.last_id_unit_kerja = uk.id_unit_kerja
                LEFT JOIN pegawai p ON knj.id_pegawai_pelapor = p.id_pegawai 
                LEFT JOIN knj_status_kinerja kns ON knj.id_status_knj = kns.id_status_knj 
                LEFT JOIN knj_kinerja_historis_alih_tugas kha ON kha.id_knj_master = knj.id_knj_master
                WHERE uk.id_skpd = AES_DECRYPT(UNHEX('$id_skpd_enc'),SHA2('keyloginekinerja',512)) $andKlausa 
                GROUP BY knj.id_knj_master 
                ORDER BY knj.periode_thn DESC, knj.periode_bln DESC, last_eselon ASC, p.nama ASC";
        return $this->db->query($sql);
    }

    public function cek_eksisting_logabsen_byidpegawai_wkt($idpegawai, $wkt){
        $wkt = explode(' ', $wkt);
        $tgl = explode('-', $wkt[0]);
        $tgl = $tgl[2].'-'.$tgl[1].'-'.$tgl[0];
        $jam = $wkt[1];

        $sql = "SELECT COUNT(id) AS jumlah FROM oasys_attendance_log oal
                WHERE oal.id_pegawai = AES_DECRYPT(UNHEX('$idpegawai'),SHA2('keyloginekinerja',512)) AND oal.date_time = '$tgl $jam'";
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

    public function insert_logabsen_byidpegawai_wkt($idpegawai, $wkt, $ket){
        $this->db->trans_begin();
        $wkt = explode(' ', $wkt);
        $tgl = explode('-', $wkt[0]);
        $tgl = $tgl[2].'-'.$tgl[1].'-'.$tgl[0];
        $jam = $wkt[1];

        $sql = "INSERT INTO oasys_attendance_log(id_pegawai, date_time, status, longitude, latitude) 
                VALUES (AES_DECRYPT(UNHEX('$idpegawai'),SHA2('keyloginekinerja',512)), '$tgl $jam', 'Pulang Jam Kerja Beda $ket', 0, 0)";
        $this->db->query($sql);
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return array(
                'query' => 0
            );
        }else{
            $this->db->trans_commit();
            return array(
                'query' => 1
            );
        }
    }

    public function hapus_logabsen_byidpegawai_wkt($idpegawai, $wkt){
        $this->db->trans_begin();
        $wkt = explode(' ', $wkt);
        $tgl = explode('-', $wkt[0]);
        $tgl = $tgl[2].'-'.$tgl[1].'-'.$tgl[0];
        $jam = $wkt[1];
        $sql = "DELETE FROM oasys_attendance_log
                WHERE id_pegawai = AES_DECRYPT(UNHEX('$idpegawai'),SHA2('keyloginekinerja',512)) AND date_time = '$tgl $jam'";
        $this->db->query($sql);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return 0;
        }else{
            $this->db->trans_commit();
            return 1;
        }
    }

    public function pencapaianKinerjaCurrent($id_pegawai, $keyApps){
        $sql = "SELECT HEX(AES_ENCRYPT(knjm.id_knj_master,SHA2($keyApps,512))) as id_knj_master, knjm.tgl_update_kalkulasi, knjm.last_eselon, 
                kkh.nilai_rupiah_tkd, kkh.nilai_jabatan, (kkh.nilai_rupiah_tkd*kkh.nilai_jabatan) as nilai, kkh.rupiah_awal_tkd, knjm.rupiah_awal_kinerja, knjm.rupiah_awal_disiplin,
                knjm.jml_bawahan_aktual, knjm.jml_bawahan_kinerja, knjm.persen_kinerja_accu_bawahan, knjm.persen_kinerja_bawahan_aktual,
                knjm.persen_kinerja_aktual, knjm.rupiah_kinerja_aktual, knjm.last_persen_disiplin, knjm.last_rupiah_disiplin, knjm.last_rupiah_kinerja_final 
                FROM knj_kinerja_master knjm INNER JOIN knj_kinerja_historis_alih_tugas kkh ON knjm.id_knj_master = kkh.id_knj_master 
                WHERE knjm.id_pegawai_pelapor = AES_DECRYPT(UNHEX('$id_pegawai'),SHA2('keyloginekinerja',512)) AND periode_bln = MONTH(NOW()) AND periode_thn = YEAR(NOW())
                ORDER BY knjm.id_pegawai_pelapor ASC";
        return $this->db->query($sql);
    }

    public function statusAktifitasCurrent($id_pegawai){
        $sql = "CALL PRCD_KINERJA_STATUS_AKTIVITAS('".$id_pegawai."');";
        return $this->db->query($sql);
    }

    public function statusAktifitasStaf($id_pegawai_enc, $id_skpd_enc, $keyApps){
        $sql = "SELECT HEX(AES_ENCRYPT(uk.id_unit_kerja,SHA2($keyApps,512))) as id_skpd_enc, uk.nama_baru as unit
                FROM unit_kerja uk WHERE uk.id_unit_kerja = uk.id_skpd AND uk.tahun = (SELECT MAX(tahun) FROM unit_kerja)
                AND (uk.nama_baru LIKE '%Dinas Kesehatan%' OR uk.nama_baru LIKE '%Dinas Pendidikan%')";
        $query = $this->db->query($sql);
        foreach ($query->result() as $data) {
            $id_skpd_enc_get = $data->id_skpd_enc;
            if($id_skpd_enc_get==$id_skpd_enc){
                $dinkes_disdik = $data->unit;
                break;
            }else{
                $dinkes_disdik = '';
            }
        }

        if($dinkes_disdik=='Dinas Kesehatan Kota Bogor'){
            $andKlause = "AND (uk.id_unit_kerja = uk.id_skpd OR uk.id_unit_kerja =
            (SELECT id_unit_kerja FROM unit_kerja uk_labkesda WHERE uk_labkesda.tahun = (SELECT MAX(tahun) FROM unit_kerja)
            AND uk_labkesda.nama_baru LIKE '%UPTD Laboratorium Kesehatan Daerah%'))";
        }elseif($dinkes_disdik=='Dinas Pendidikan Kota Bogor'){
            $andKlause = "AND (CASE WHEN p.jenjab = 'Fungsional' THEN (CASE WHEN jafung.nama_jafung IS NULL THEN p.jabatan ELSE jafung.nama_jafung END) ELSE
            CASE WHEN p.id_j IS NULL THEN (jfu.nama_jfu) ELSE j.jabatan END END) != 'Guru'";
        }else{
            $andKlause = "";
        }

        $sql = "SELECT bz.id_pegawai, bz.nama, bz.jabatan,
                SUM(IF(bz.approved='' OR bz.approved IS NULL, bz.jumlah, 0)) AS blm_diproses,
                SUM(IF(bz.approved=1, bz.jumlah, 0)) AS disetujui,
                SUM(IF(bz.approved=2, bz.jumlah, 0)) AS revisi,
                SUM(IF(bz.approved=3, bz.jumlah, 0)) AS ditolak
                FROM
                (SELECT az.*, kkk.approved, COUNT(kkk.id_knj_kegiatan) AS jumlah FROM
                (SELECT ay.id_pegawai, ay.nama, ay.jabatan, kkh.idknj_hist_alih_tugas FROM
                (SELECT ax.*, HEX(AES_ENCRYPT(kkm.id_knj_master,SHA2('$keyApps',512))) AS id_knj_master_enc, 
                (CASE WHEN kkm.id_knj_master IS NULL THEN 'Belum' ELSE 'Sudah Ada' END) as ekinerja_current,
                ksk.status_knj, (CASE WHEN kkm.flag_kalkulasi = 1 THEN CONCAT('Sudah pada ', DATE_FORMAT(kkm.tgl_update_kalkulasi, '%d-%m-%Y %H:%i:%s')) ELSE '' END) as kalkulasi,
                HEX(AES_ENCRYPT(ax.id_pegawai,SHA2('keyloginekinerja',512))) AS id_pegawai_enc
                FROM (SELECT z.* FROM
                (SELECT b.*, (CASE WHEN p.id_pegawai IS NULL THEN (SELECT CASE WHEN jplt.id_pegawai IS NULL = 1 THEN 0 ELSE jplt.id_pegawai END AS id_pegawai
                FROM jabatan_plt jplt WHERE jplt.id_j = b.id_bos_atsl LIMIT 1) ELSE p.id_pegawai END) AS id_pegawai_atasan, 
                (CASE WHEN uk_dinkes.id_unit_kerja IS NULL = 1 THEN 1 ELSE 
                (CASE WHEN (b.id_unit_kerja = uk_dinkes.id_unit_kerja OR b.id_unit_kerja = uk_labkesda.id_unit_kerja) THEN 1 ELSE 0 END) END) as cek 
                FROM (SELECT a.id_pegawai, a.id_unit_kerja, uk.id_unit_kerja AS id_skpd, a.id_bos_atsl,
                a.nip_baru, a.nama, a.jenjab, a.pangkat_gol, a.jabatan, (CASE WHEN a.eselon = 'Z' THEN '' ELSE a.eselon END) AS eselon
                FROM
                (SELECT p.id_pegawai,
                p.nip_baru, CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
                nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(' ',p.gelar_belakang) END) AS nama, p.tempat_lahir, p.tgl_lahir,
                ROUND(DATEDIFF(CURRENT_DATE, DATE_FORMAT(p.tgl_lahir, '%Y/%m/%d'))/365,2) AS usia,
                p.jenjab, p.pangkat_gol,
                CASE WHEN p.jenjab = 'Fungsional' THEN (jafung.kode_jabatan_jafung) ELSE
                CASE WHEN p.id_j IS NULL THEN (jfu.kode_jabatan_jfu) ELSE j.id_j END END AS kode_jabatan,
                CASE WHEN p.jenjab = 'Fungsional' THEN (jafung.kelas_jabatan_jafung) ELSE
                CASE WHEN p.id_j IS NULL THEN (jfu.kelas_jabatan_jfu) ELSE j.kelas_jabatan END END AS kelas_jabatan,
                CASE WHEN p.jenjab = 'Fungsional' THEN (jafung.nilai_jabatan_jafung) ELSE
                CASE WHEN p.id_j IS NULL THEN (jfu.nilai_jabatan_jfu) ELSE j.nilai_jabatan END END AS nilai_jabatan,
                CASE WHEN p.jenjab = 'Fungsional' THEN (CASE WHEN jafung.nama_jafung IS NULL THEN p.jabatan ELSE jafung.nama_jafung END) ELSE
                CASE WHEN p.id_j IS NULL THEN (jfu.nama_jfu) ELSE j.jabatan END END AS jabatan,
                CASE WHEN j.eselon IS NULL THEN 'Z' ELSE j.eselon END AS eselon,
                uk.id_unit_kerja, uk.id_skpd,
                CASE WHEN j.id_bos IS NULL = 1 THEN (
                (SELECT CASE WHEN ( (id_j_bos IS NULL) OR (COUNT(id_j_bos)=0)) THEN
                (SELECT CASE WHEN ( (id_j_bos IS NULL) OR (COUNT(id_j_bos)=0)) THEN
                (SELECT CASE WHEN ( (id_j_bos IS NULL) OR (COUNT(id_j_bos)=0)) THEN
                (SELECT CASE WHEN ( (id_j_bos IS NULL) OR (COUNT(id_j_bos)=0)) THEN
                (SELECT CASE WHEN ( (id_j_bos IS NULL) OR (COUNT(id_j_bos)=0)) THEN
                (SELECT CASE WHEN ( (id_j_bos IS NULL) OR (COUNT(id_j_bos)=0)) THEN
                (SELECT CASE WHEN ( (id_j_bos IS NULL) OR (COUNT(id_j_bos)=0)) THEN
                (SELECT CASE WHEN ( (id_j_bos IS NULL) OR (COUNT(id_j_bos)=0)) THEN
                (SELECT CASE WHEN ( (id_j_bos IS NULL) OR (COUNT(id_j_bos)=0)) THEN
                (SELECT CASE WHEN ( (id_j_bos IS NULL) OR (COUNT(id_j_bos)=0)) THEN
                (SELECT CASE WHEN ( (id_j_bos IS NULL) OR (COUNT(id_j_bos)=0)) THEN
                0
                ELSE  id_j_bos END AS id_j_bos FROM riwayat_mutasi_kerja rmk WHERE rmk.id_riwayat =
                (SELECT MAX(riwayat_mutasi_kerja.id_riwayat) AS idriwayat
                FROM riwayat_mutasi_kerja INNER JOIN sk ON sk.id_sk = riwayat_mutasi_kerja.id_sk
                WHERE sk.id_pegawai = p.id_pegawai AND sk.id_kategori_sk = 18 AND riwayat_mutasi_kerja.id_pegawai = p.id_pegawai
                GROUP BY riwayat_mutasi_kerja.id_pegawai
                ORDER BY tmt DESC LIMIT 1))
                ELSE  id_j_bos END AS id_j_bos FROM riwayat_mutasi_kerja rmk WHERE rmk.id_riwayat =
                (SELECT MAX(riwayat_mutasi_kerja.id_riwayat) AS idriwayat
                FROM riwayat_mutasi_kerja INNER JOIN sk ON sk.id_sk = riwayat_mutasi_kerja.id_sk
                WHERE sk.id_pegawai = p.id_pegawai AND (sk.id_kategori_sk = 52 OR sk.id_kategori_sk = 23) AND riwayat_mutasi_kerja.id_pegawai = p.id_pegawai
                GROUP BY riwayat_mutasi_kerja.id_pegawai
                ORDER BY tmt DESC LIMIT 1))
                ELSE  id_j_bos END AS id_j_bos FROM riwayat_mutasi_kerja rmk WHERE rmk.id_riwayat =
                (SELECT MAX(riwayat_mutasi_kerja.id_riwayat) AS idriwayat
                FROM riwayat_mutasi_kerja INNER JOIN sk ON sk.id_sk = riwayat_mutasi_kerja.id_sk
                WHERE sk.id_pegawai = p.id_pegawai AND sk.id_kategori_sk = 55 AND riwayat_mutasi_kerja.id_pegawai = p.id_pegawai
                GROUP BY riwayat_mutasi_kerja.id_pegawai
                ORDER BY tmt DESC LIMIT 1))
                ELSE  id_j_bos END AS id_j_bos FROM riwayat_mutasi_kerja rmk WHERE rmk.id_riwayat =
                (SELECT MAX(riwayat_mutasi_kerja.id_riwayat) AS idriwayat
                FROM riwayat_mutasi_kerja INNER JOIN sk ON sk.id_sk = riwayat_mutasi_kerja.id_sk
                WHERE sk.id_pegawai = p.id_pegawai AND sk.id_kategori_sk = 21 AND riwayat_mutasi_kerja.id_pegawai = p.id_pegawai
                GROUP BY riwayat_mutasi_kerja.id_pegawai
                ORDER BY tmt DESC LIMIT 1))
                ELSE  id_j_bos END AS id_j_bos FROM riwayat_mutasi_kerja rmk WHERE rmk.id_riwayat =
                (SELECT MAX(riwayat_mutasi_kerja.id_riwayat) AS idriwayat
                FROM riwayat_mutasi_kerja INNER JOIN sk ON sk.id_sk = riwayat_mutasi_kerja.id_sk
                WHERE sk.id_pegawai = p.id_pegawai AND sk.id_kategori_sk = 12 AND riwayat_mutasi_kerja.id_pegawai = p.id_pegawai
                GROUP BY riwayat_mutasi_kerja.id_pegawai
                ORDER BY tmt DESC LIMIT 1))
                ELSE  id_j_bos END AS id_j_bos FROM riwayat_mutasi_kerja rmk WHERE rmk.id_riwayat =
                (SELECT MAX(riwayat_mutasi_kerja.id_riwayat) AS idriwayat
                FROM riwayat_mutasi_kerja INNER JOIN sk ON sk.id_sk = riwayat_mutasi_kerja.id_sk
                WHERE sk.id_pegawai = p.id_pegawai AND sk.id_kategori_sk = 10 AND riwayat_mutasi_kerja.id_pegawai = p.id_pegawai
                GROUP BY riwayat_mutasi_kerja.id_pegawai
                ORDER BY tmt DESC LIMIT 1))
                ELSE  id_j_bos END AS id_j_bos FROM riwayat_mutasi_kerja rmk WHERE rmk.id_riwayat =
                (SELECT MAX(riwayat_mutasi_kerja.id_riwayat) AS idriwayat
                FROM riwayat_mutasi_kerja INNER JOIN sk ON sk.id_sk = riwayat_mutasi_kerja.id_sk
                WHERE sk.id_pegawai = p.id_pegawai AND sk.id_kategori_sk = 9 AND riwayat_mutasi_kerja.id_pegawai = p.id_pegawai
                GROUP BY riwayat_mutasi_kerja.id_pegawai
                ORDER BY tmt DESC LIMIT 1))
                ELSE  id_j_bos END AS id_j_bos FROM riwayat_mutasi_kerja rmk WHERE rmk.id_riwayat =
                (SELECT MAX(riwayat_mutasi_kerja.id_riwayat) AS idriwayat
                FROM riwayat_mutasi_kerja INNER JOIN sk ON sk.id_sk = riwayat_mutasi_kerja.id_sk
                WHERE sk.id_pegawai = p.id_pegawai AND sk.id_kategori_sk = 7 AND riwayat_mutasi_kerja.id_pegawai = p.id_pegawai
                GROUP BY riwayat_mutasi_kerja.id_pegawai
                ORDER BY tmt DESC LIMIT 1))
                ELSE  id_j_bos END AS id_j_bos FROM riwayat_mutasi_kerja rmk WHERE rmk.id_riwayat =
                (SELECT MAX(riwayat_mutasi_kerja.id_riwayat) AS idriwayat
                FROM riwayat_mutasi_kerja INNER JOIN sk ON sk.id_sk = riwayat_mutasi_kerja.id_sk
                WHERE sk.id_pegawai = p.id_pegawai AND sk.id_kategori_sk = 6 AND riwayat_mutasi_kerja.id_pegawai = p.id_pegawai
                GROUP BY riwayat_mutasi_kerja.id_pegawai
                ORDER BY tmt DESC LIMIT 1))
                ELSE  id_j_bos END AS id_j_bos FROM riwayat_mutasi_kerja rmk WHERE rmk.id_riwayat =
                (SELECT MAX(riwayat_mutasi_kerja.id_riwayat) AS idriwayat
                FROM riwayat_mutasi_kerja INNER JOIN sk ON sk.id_sk = riwayat_mutasi_kerja.id_sk
                WHERE sk.id_pegawai = p.id_pegawai AND sk.id_kategori_sk = 5 AND riwayat_mutasi_kerja.id_pegawai = p.id_pegawai
                GROUP BY riwayat_mutasi_kerja.id_pegawai
                ORDER BY tmt DESC LIMIT 1))
                ELSE  id_j_bos END AS id_j_bos FROM riwayat_mutasi_kerja rmk WHERE rmk.id_riwayat =
                (SELECT MAX(riwayat_mutasi_kerja.id_riwayat) AS idriwayat
                FROM riwayat_mutasi_kerja INNER JOIN sk ON sk.id_sk = riwayat_mutasi_kerja.id_sk
                WHERE sk.id_pegawai = p.id_pegawai AND sk.id_kategori_sk = 1 AND riwayat_mutasi_kerja.id_pegawai = p.id_pegawai
                GROUP BY riwayat_mutasi_kerja.id_pegawai
                ORDER BY tmt DESC LIMIT 1))
                ) ELSE j.id_bos END AS id_bos_atsl
                FROM pegawai p LEFT JOIN jabatan j ON p.id_j = j.id_j
                LEFT JOIN (
                SELECT b.id_pegawai, jm.id_jfu as kode_jabatan_jfu, jm.kelas_jabatan as kelas_jabatan_jfu,
                jm.nilai_jabatan as nilai_jabatan_jfu, jm.nama_jfu
                FROM (SELECT a.*, jp.id_jfu FROM
                (SELECT jp.id_pegawai, MAX(jp.id) as id_jfu_pegawai FROM jfu_pegawai jp,
                (SELECT id_pegawai, MAX(tmt) as max_tmt FROM jfu_pegawai WHERE tmt IS NOT NULL GROUP BY id_pegawai) x
                WHERE jp.id_pegawai = x.id_pegawai AND jp.tmt = x.max_tmt
                GROUP BY jp.id_pegawai) a
                INNER JOIN jfu_pegawai jp ON a.id_jfu_pegawai = jp.id) b
                INNER JOIN jfu_master jm ON b.id_jfu = jm.id_jfu) jfu ON jfu.id_pegawai = p.id_pegawai 
                LEFT JOIN (
                SELECT b.id_pegawai, jm.id_jafung as kode_jabatan_jafung, jm.kelas_jabatan as kelas_jabatan_jafung,
                jm.nilai_jabatan as nilai_jabatan_jafung, jm.nama_jafung
                FROM (SELECT a.*, jp.id_jafung FROM
                (SELECT jp.id_pegawai, MAX(jp.id) as id_jafung_pegawai FROM jafung_pegawai jp,
                (SELECT id_pegawai, MAX(tmt) as max_tmt FROM jafung_pegawai WHERE tmt IS NOT NULL GROUP BY id_pegawai) x
                WHERE jp.id_pegawai = x.id_pegawai AND jp.tmt = x.max_tmt
                GROUP BY jp.id_pegawai) a
                INNER JOIN jafung_pegawai jp ON a.id_jafung_pegawai = jp.id) b
                INNER JOIN jafung jm ON b.id_jafung = jm.id_jafung) jafung ON jafung.id_pegawai = p.id_pegawai, current_lokasi_kerja clk, unit_kerja uk
                WHERE p.id_pegawai = clk.id_pegawai AND clk.id_unit_kerja = uk.id_unit_kerja AND uk.id_skpd = AES_DECRYPT(UNHEX('$id_skpd_enc'),SHA2('keyloginekinerja',512))
                AND p.flag_pensiun = 0 $andKlause 
                ORDER BY eselon ASC, p.pangkat_gol DESC, p.nama) a, unit_kerja uk
                WHERE a.id_skpd = uk.id_unit_kerja) b LEFT JOIN pegawai p ON b.id_bos_atsl = p.id_j
                LEFT JOIN unit_kerja uk_dinkes ON b.id_skpd = uk_dinkes.id_unit_kerja AND uk_dinkes.tahun = (SELECT MAX(tahun) FROM unit_kerja) AND uk_dinkes.nama_baru LIKE '%Dinas Kesehatan%'
                LEFT JOIN unit_kerja uk_labkesda ON b.id_unit_kerja = uk_labkesda.id_unit_kerja AND uk_labkesda.tahun = (SELECT MAX(tahun) FROM unit_kerja) AND uk_labkesda.nama_baru LIKE '%UPTD Laboratorium Kesehatan Daerah%') z
                WHERE z.id_pegawai_atasan = AES_DECRYPT(UNHEX('$id_pegawai_enc'),SHA2('keyloginekinerja',512)) AND z.cek = 1 AND z.id_pegawai_atasan <> z.id_pegawai ORDER BY z.nama ASC) ax LEFT JOIN
                knj_kinerja_master kkm ON ax.id_pegawai = kkm.id_pegawai_pelapor AND
                kkm.periode_bln = MONTH(NOW()) AND kkm.periode_thn = YEAR(NOW())
                LEFT JOIN knj_status_kinerja ksk ON kkm.id_status_knj = ksk.id_status_knj 
                ORDER BY ax.nama) ay LEFT JOIN knj_kinerja_master knjm ON ay.id_pegawai = knjm.id_pegawai_pelapor
                LEFT JOIN knj_kinerja_historis_alih_tugas kkh ON knjm.id_knj_master = kkh.id_knj_master
                WHERE periode_bln = MONTH(NOW()) AND periode_thn = YEAR(NOW())) az
                INNER JOIN knj_kinerja_kegiatan kkk ON az.idknj_hist_alih_tugas = kkk.idknj_hist_alih_tugas
                GROUP BY az.id_pegawai, kkk.approved) bz GROUP BY bz.id_pegawai ORDER BY bz.nama";
        return $this->db->query($sql);
    }

    public function jumlah_laporan_kinerja_by_pegawai($id_skpd_enc, $bln, $thn, $idp_enc){
        $andKlausa = '';
        if($bln!='0'){
            $andKlausa .= " AND knj.periode_bln = $bln";
        }

        if($thn!='0'){
            $andKlausa .= " AND knj.periode_thn = $thn";
        }

        $sql = "SELECT COUNT(*) AS jumlah
                FROM knj_kinerja_master knj
                LEFT JOIN unit_kerja uk ON knj.last_id_unit_kerja = uk.id_unit_kerja
                LEFT JOIN pegawai p ON knj.id_pegawai_pelapor = p.id_pegawai
                WHERE uk.id_skpd = AES_DECRYPT(UNHEX('$id_skpd_enc'),SHA2('keyloginekinerja',512)) AND 
                knj.id_pegawai_pelapor = AES_DECRYPT(UNHEX('$idp_enc'),SHA2('keyloginekinerja',512)) $andKlausa";
        return $this->db->query($sql);

    }

    public function list_laporan_kinerja_by_pegawai($row_number_start, $id_skpd_enc, $bln, $thn, $idp_enc, $limit, $keyApps){
        $andKlausa = '';
        if($bln!='0'){
            $andKlausa .= " AND knj.periode_bln = $bln";
        }

        if($thn!='0'){
            $andKlausa .= " AND knj.periode_thn = $thn";
        }

        $this->db->query("SET @row_number := $row_number_start");
        $sql = "SELECT knj.id_knj_master, HEX(AES_ENCRYPT(knj.id_knj_master,SHA2($keyApps,512))) as id_knj_master_enc, knj.periode_bln, knj.periode_thn, p.nip_baru, CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
                nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(' ',p.gelar_belakang) END) AS nama, p.pangkat_gol,
                knj.tgl_input_kinerja, knj.last_jenjab, knj.last_kode_jabatan, knj.last_jabatan, CASE WHEN knj.last_eselon = '' THEN 'Staf' ELSE knj.last_eselon END AS last_eselon,
                knj.last_gol, knj.last_atsl_nip, knj.last_atsl_nama, knj.last_atsl_jabatan, knj.last_pjbt_nip, knj.last_pjbt_nama, knj.last_pjbt_jabatan, kns.status_knj, knj.flag_kalkulasi, knj.tgl_update_kalkulasi, 
                knj.jml_menit_efektif_kerja, knj.jml_waktu_kinerja_accu, knj.persen_kinerja_accu, knj.rupiah_kinerja, knj.jml_bawahan_aktual, knj.jml_bawahan_kinerja,
                knj.jml_waktu_kinerja_accu_bawahan, knj.persen_kinerja_accu_bawahan, knj.persen_kinerja_bawahan_aktual, knj.persen_kinerja_aktual,
                knj.rupiah_kinerja_aktual, knj.jml_hari_efektif_kerja, knj.jml_kehadiran_accu, knj.persen_kehadiran_accu, knj.jml_tidak_hadir_accu,
                knj.persen_minus_tidak_hadir_accu, knj.persen_minus_terlambat_plg_cpt_accu, knj.jml_hari_efektif_apel, knj.jml_tidak_apel_accu,
                knj.persen_minus_tidak_apel_accu, knj.jumlah_penambahan_item_lain, knj.persen_penambahan_item_lain, knj.jumlah_pengurangan_item_lain,
                knj.persen_pengurangan_item_lain, knj.persen_disiplin_final, knj.rupiah_disiplin, knj.rupiah_awal_kinerja, knj.rupiah_awal_disiplin,
                knj.persen_kinerja_final, knj.rupiah_kinerja_final, knj.jumlah_pengurangan_item_lain_maks, knj.persen_pengurangan_item_lain_maks,
                knj.last_persen_disiplin, knj.last_rupiah_disiplin, knj.last_rupiah_kinerja_final 
                FROM knj_kinerja_master knj 
                LEFT JOIN unit_kerja uk ON knj.last_id_unit_kerja = uk.id_unit_kerja
                LEFT JOIN pegawai p ON knj.id_pegawai_pelapor = p.id_pegawai 
                LEFT JOIN knj_status_kinerja kns ON knj.id_status_knj = kns.id_status_knj 
                WHERE uk.id_skpd = AES_DECRYPT(UNHEX('$id_skpd_enc'),SHA2('keyloginekinerja',512)) AND 
                knj.id_pegawai_pelapor = AES_DECRYPT(UNHEX('$idp_enc'),SHA2('keyloginekinerja',512)) $andKlausa 
                ORDER BY knj.periode_thn DESC, knj.periode_bln DESC, last_eselon ASC, p.nama ASC $limit";
        return $this->db->query($sql);

    }

    public function statistik_kinerja_bulanan($id_pegawai, $thn){
        $sql = "SELECT lb.bln, CASE WHEN a.utama IS NULL = 1 THEN 0 ELSE a.utama END AS utama,
                CASE WHEN a.khusus IS NULL = 1 THEN 0 ELSE a.khusus END AS khusus,
                CASE WHEN a.tambahan IS NULL = 1 THEN 0 ELSE a.tambahan END AS tambahan,
                CASE WHEN a.penyesuaian IS NULL = 1 THEN 0 ELSE a.penyesuaian END AS penyesuaian,
                CASE WHEN a.ikp IS NULL = 1 THEN 0 ELSE a.ikp END AS ikp
                FROM list_bulan lb LEFT JOIN
                (SELECT MONTH(ktnj.date_periode_knj) as bln,
                SUM(ktnj.jumlah_waktu_tugas_utama) as utama, SUM(ktnj.jumlah_waktu_tugas_tambahan_khusus) as khusus,
                SUM(ktnj.jumlah_waktu_tugas_tambahan) as tambahan, SUM(ktnj.jumlah_waktu_penyesuaian_target) as penyesuaian,
                SUM(ktnj.jumlah_waktu_ikp) as ikp
                FROM knj_kinerja_tunjangan ktnj WHERE ktnj.idknj_hist_alih_tugas IN
                (SELECT kkat.idknj_hist_alih_tugas FROM knj_kinerja_historis_alih_tugas kkat INNER JOIN
                (SELECT kkm.id_knj_master FROM knj_kinerja_master kkm
                WHERE kkm.periode_thn = $thn AND kkm.id_pegawai_pelapor = AES_DECRYPT(UNHEX('$id_pegawai'),SHA2('keyloginekinerja',512))) a ON
                kkat.id_knj_master = a.id_knj_master)
                GROUP BY bln) a ON lb.bln = a.bln";
        return $this->db->query($sql);
    }

    public function statistik_absensi_bulanan($id_pegawai, $thn){
        $sql = "SELECT lb.bln,
                CASE WHEN a.terlambat IS NULL = 1 THEN 0 ELSE a.terlambat END AS terlambat,
                CASE WHEN a.terlambat IS NULL = 1 THEN NULL ELSE CONCAT(FLOOR(a.terlambat/60),'h ',MOD(a.terlambat,60),'m') END AS terlambat_jm,
                CASE WHEN a.pulang_cepat IS NULL = 1 THEN 0 ELSE a.pulang_cepat END AS pulang_cepat,
                CASE WHEN (a.pulang_cepat IS NULL = 1 OR a.pulang_cepat = 0) THEN NULL ELSE CONCAT(FLOOR(a.pulang_cepat/60),'h ',MOD(a.pulang_cepat,60),'m') END AS pulang_cepat_jm
                FROM list_bulan lb LEFT JOIN
                (SELECT MONTH(ktnj.date_periode_knj) as bln,
                SUM(ktnj.menit_terlambat_masuk) as terlambat,
                SUM(ktnj.menit_pulang_lebih_cepat) as pulang_cepat
                FROM knj_kinerja_tunjangan ktnj WHERE ktnj.idknj_hist_alih_tugas IN
                (SELECT kkat.idknj_hist_alih_tugas FROM knj_kinerja_historis_alih_tugas kkat INNER JOIN
                (SELECT kkm.id_knj_master FROM knj_kinerja_master kkm
                WHERE kkm.periode_thn = $thn AND kkm.id_pegawai_pelapor = AES_DECRYPT(UNHEX('$id_pegawai'),SHA2('keyloginekinerja',512))) a ON
                kkat.id_knj_master = a.id_knj_master)
                GROUP BY bln) a ON lb.bln = a.bln";
        return $this->db->query($sql);
    }

    public function statistik_persen_kinerja_absensi_bulanan($id_pegawai, $thn){
        $sql = "SELECT lb.bln, 
                CASE WHEN c.persen_kinerja IS NULL = 1 THEN 0 ELSE c.persen_kinerja END AS persen_kinerja,
                CASE WHEN c.persen_kinerja_lost IS NULL = 1 THEN 0 ELSE c.persen_kinerja_lost END AS persen_kinerja_lost,
                CASE WHEN c.rupiah_kinerja IS NULL = 1 THEN 0 ELSE c.rupiah_kinerja END AS rupiah_kinerja,
                CASE WHEN c.rupiah_kinerja_lost IS NULL = 1 THEN 0 ELSE c.rupiah_kinerja_lost END AS rupiah_kinerja_lost,
                CASE WHEN c.persen_minus_terlambat_plg_cpt IS NULL = 1 THEN 0 ELSE c.persen_minus_terlambat_plg_cpt END AS persen_minus_terlambat_plg_cpt,
                CASE WHEN c.rupiah_terlambat_plg_cpt IS NULL = 1 THEN 0 ELSE c.rupiah_terlambat_plg_cpt END AS rupiah_terlambat_plg_cpt,
                CASE WHEN c.persen_minus_tidak_hadir IS NULL = 1 THEN 0 ELSE c.persen_minus_tidak_hadir END AS persen_minus_tidak_hadir,
                CASE WHEN c.rupiah_tdk_hadir IS NULL = 1 THEN 0 ELSE c.rupiah_tdk_hadir END AS rupiah_tdk_hadir,
                CASE WHEN c.persen_minus_tidak_apel IS NULL = 1 THEN 0 ELSE c.persen_minus_tidak_apel END AS persen_minus_tidak_apel,
                CASE WHEN c.rupiah_tidak_apel IS NULL = 1 THEN 0 ELSE c.rupiah_tidak_apel END AS rupiah_tidak_apel
                FROM list_bulan lb LEFT JOIN 
                (SELECT b.bln, ROUND(SUM(persen_kinerja)/SUM(b.flag_hari_kerja),2) AS persen_kinerja,
                (100-ROUND(SUM(persen_kinerja)/SUM(b.flag_hari_kerja),2)) as persen_kinerja_lost,
                CAST((ROUND(AVG(b.rupiah_awal_kinerja),2)*(ROUND(SUM(persen_kinerja)/SUM(b.flag_hari_kerja),2)/100)) AS SIGNED) as rupiah_kinerja,
                CAST(ROUND(AVG(b.rupiah_awal_kinerja),2)-(ROUND(AVG(b.rupiah_awal_kinerja),2)*(ROUND(SUM(persen_kinerja)/SUM(b.flag_hari_kerja),2)/100)) AS SIGNED) as rupiah_kinerja_lost,
                SUM(persen_minus_terlambat_plg_cpt) as persen_minus_terlambat_plg_cpt, SUM(rupiah_terlambat_plg_cpt) as rupiah_terlambat_plg_cpt,
                SUM(persen_minus_tidak_hadir) as persen_minus_tidak_hadir, SUM(rupiah_tdk_hadir) as rupiah_tdk_hadir,
                SUM(persen_minus_tidak_apel) as persen_minus_tidak_apel, SUM(rupiah_tidak_apel) as rupiah_tidak_apel
                FROM (SELECT MONTH(ktnj.date_periode_knj) as bln, CASE WHEN ktnj.persen_kinerja > 100 THEN 100 ELSE ktnj.persen_kinerja END persen_kinerja,
                (CASE WHEN (ktnj.status_hari = 'Libur' OR ktnj.status_hari = 'Libur Nasional' OR ktnj.status_hari = 'Cuti Bersama') THEN 0 ELSE 1 END) AS flag_hari_kerja,
                kkh.rupiah_awal_kinerja,
                ktnj.persen_minus_terlambat_plg_cpt,
                CAST((ktnj.persen_minus_terlambat_plg_cpt/100)*kkh.rupiah_awal_disiplin AS SIGNED) as rupiah_terlambat_plg_cpt,
                ktnj.persen_minus_tidak_hadir,
                CAST((((ktnj.persen_minus_tidak_hadir/100)*kkh.rupiah_awal_disiplin)+((ktnj.persen_minus_tidak_hadir/100)*kkh.rupiah_awal_kinerja)) AS SIGNED) as rupiah_tdk_hadir,
                ktnj.persen_minus_tidak_apel,
                CAST((ktnj.persen_minus_tidak_apel/100)*kkh.rupiah_awal_disiplin AS SIGNED) as rupiah_tidak_apel
                FROM knj_kinerja_tunjangan ktnj INNER JOIN knj_kinerja_historis_alih_tugas kkh ON ktnj.idknj_hist_alih_tugas = kkh.idknj_hist_alih_tugas
                WHERE ktnj.idknj_hist_alih_tugas IN
                (SELECT kkat.idknj_hist_alih_tugas FROM knj_kinerja_historis_alih_tugas kkat INNER JOIN
                (SELECT kkm.id_knj_master FROM knj_kinerja_master kkm
                WHERE kkm.periode_thn = $thn AND kkm.id_pegawai_pelapor = AES_DECRYPT(UNHEX('$id_pegawai'),SHA2('keyloginekinerja',512))) a ON
                kkat.id_knj_master = a.id_knj_master)) b
                GROUP BY b.bln) c ON lb.bln = c.bln";
        return $this->db->query($sql);
    }

    public function statistik_kinerja_harian($id_pegawai, $bln, $thn){
        $sql = "SELECT DAY(ktnj.date_periode_knj) as tgl, ktnj.status_hari,
                SUM(ktnj.jumlah_waktu_tugas_utama) as utama, SUM(ktnj.jumlah_waktu_tugas_tambahan_khusus) as khusus,
                SUM(ktnj.jumlah_waktu_tugas_tambahan) as tambahan, SUM(ktnj.jumlah_waktu_penyesuaian_target) as penyesuaian,
                SUM(ktnj.jumlah_waktu_ikp) as ikp
                FROM knj_kinerja_tunjangan ktnj WHERE ktnj.idknj_hist_alih_tugas IN
                (SELECT kkat.idknj_hist_alih_tugas FROM knj_kinerja_historis_alih_tugas kkat INNER JOIN
                (SELECT kkm.id_knj_master FROM knj_kinerja_master kkm
                WHERE kkm.periode_bln = $bln AND kkm.periode_thn = $thn AND kkm.id_pegawai_pelapor = AES_DECRYPT(UNHEX('$id_pegawai'),SHA2('keyloginekinerja',512))) a ON
                kkat.id_knj_master = a.id_knj_master)
                GROUP BY tgl";
        return $this->db->query($sql);
    }

    public function statistik_absensi_harian($id_pegawai, $bln, $thn){
        $sql = "SELECT DAY(ktnj.date_periode_knj) as tgl, ktnj.status_hari,
                ktnj.menit_terlambat_masuk as terlambat,
                ktnj.menit_pulang_lebih_cepat as pulang_cepat
                FROM knj_kinerja_tunjangan ktnj WHERE ktnj.idknj_hist_alih_tugas IN
                (SELECT kkat.idknj_hist_alih_tugas FROM knj_kinerja_historis_alih_tugas kkat INNER JOIN
                (SELECT kkm.id_knj_master FROM knj_kinerja_master kkm
                WHERE kkm.periode_bln = $bln AND kkm.periode_thn = $thn AND kkm.id_pegawai_pelapor = AES_DECRYPT(UNHEX('$id_pegawai'),SHA2('keyloginekinerja',512))) a ON
                kkat.id_knj_master = a.id_knj_master)";
        return $this->db->query($sql);
    }

    public function drh_biodata($id_pegawai){
        $sql = "SELECT p.*, uk.id_unit_kerja, uk.nama_baru AS unit, uk.id_skpd, pt.golongan, pt.tmt, g.pangkat FROM
                (SELECT p.id_pegawai, p.nip_baru, CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
                nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(' ',p.gelar_belakang) END) AS nama, p.tempat_lahir, p.tgl_lahir,
                CASE WHEN p.jenis_kelamin = 1 THEN 'Laki-laki' ELSE 'Perempuan' END AS jenis_kelamin, p.jenjab, p.agama, p.alamat, p.kota, p.id_j,
                CASE WHEN p.jenjab = 'Fungsional' THEN (jafung.kode_jabatan_jafung) ELSE
                CASE WHEN p.id_j IS NULL THEN (jfu.kode_jabatan_jfu) ELSE j.id_j END END AS kode_jabatan,
                CASE WHEN p.jenjab = 'Fungsional' THEN (jafung.kelas_jabatan_jafung) ELSE
                CASE WHEN p.id_j IS NULL THEN (jfu.kelas_jabatan_jfu) ELSE j.kelas_jabatan END END AS kelas_jabatan,
                CASE WHEN p.jenjab = 'Fungsional' THEN (jafung.nilai_jabatan_jafung) ELSE
                CASE WHEN p.id_j IS NULL THEN (jfu.nilai_jabatan_jfu) ELSE j.nilai_jabatan END END AS nilai_jabatan,
                CASE WHEN p.jenjab = 'Fungsional' THEN (CASE WHEN jafung.nama_jafung IS NULL THEN p.jabatan ELSE jafung.nama_jafung END) ELSE
                CASE WHEN p.id_j IS NULL THEN (jfu.nama_jfu) ELSE j.jabatan END END AS jabatan,
                CASE WHEN j.eselon IS NULL THEN 'Z' ELSE j.eselon END AS eselon
                FROM pegawai p
                LEFT JOIN jabatan j ON p.id_j = j.id_j
                LEFT JOIN (
                SELECT b.id_pegawai, jm.id_jfu as kode_jabatan_jfu, jm.kelas_jabatan as kelas_jabatan_jfu,
                jm.nilai_jabatan as nilai_jabatan_jfu, jm.nama_jfu
                FROM (SELECT a.*, jp.id_jfu FROM
                (SELECT jp.id_pegawai, MAX(jp.id) as id_jfu_pegawai FROM jfu_pegawai jp,
                (SELECT id_pegawai, MAX(tmt) as max_tmt FROM jfu_pegawai WHERE tmt IS NOT NULL GROUP BY id_pegawai) x
                WHERE jp.id_pegawai = x.id_pegawai AND jp.tmt = x.max_tmt
                GROUP BY jp.id_pegawai) a
                INNER JOIN jfu_pegawai jp ON a.id_jfu_pegawai = jp.id) b
                INNER JOIN jfu_master jm ON b.id_jfu = jm.id_jfu) jfu ON jfu.id_pegawai = p.id_pegawai
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
                WHERE p.id_pegawai = AES_DECRYPT(UNHEX('$id_pegawai'),SHA2('keyloginekinerja',512))) p
                INNER JOIN current_lokasi_kerja clk ON p.id_pegawai = clk.id_pegawai
                INNER JOIN unit_kerja uk ON clk.id_unit_kerja = uk.id_unit_kerja
                LEFT JOIN view_pangkat_terakhir pt ON p.id_pegawai = pt.id_pegawai
                LEFT JOIN golongan g ON pt.golongan = g.golongan";
        return $this->db->query($sql);
    }

    public function drh_pendidikan($id_pegawai){
        $sql = "SELECT p.lembaga_pendidikan, p.jurusan_pendidikan, p.tahun_lulus, kp.nama_pendidikan, bp.bidang, p.no_ijazah
                FROM pendidikan p
                LEFT JOIN kategori_pendidikan kp ON p.level_p = kp.level_p
                LEFT JOIN bidang_pendidikan bp ON p.id_bidang = bp.id
                WHERE p.id_pegawai = AES_DECRYPT(UNHEX('$id_pegawai'),SHA2('keyloginekinerja',512))";
        return $this->db->query($sql);
    }

    public function drh_diklat($id_pegawai){
        $sql = "SELECT dj.jenis_diklat, d.tgl_diklat, d.nama_diklat, d.jml_jam_diklat, d.penyelenggara_diklat, d.no_sttpl
                FROM diklat d LEFT JOIN diklat_jenis dj ON d.id_jenis_diklat = dj.id_jenis_diklat
                WHERE id_pegawai = AES_DECRYPT(UNHEX('$id_pegawai'),SHA2('keyloginekinerja',512))";
        return $this->db->query($sql);
    }

    public function drh_golongan($id_pegawai){
        $sql = "SELECT k.nama_sk, s.gol, g.pangkat, s.no_sk, s.tmt, s.tgl_sk
                FROM sk s LEFT JOIN kategori_sk k ON s.id_kategori_sk = k.id_kategori_sk
                LEFT JOIN golongan g ON s.gol = g.golongan
                WHERE (k.id_kategori_sk = 6 OR k.id_kategori_sk = 7 OR k.id_kategori_sk = 5) 
                AND s.id_pegawai = AES_DECRYPT(UNHEX('$id_pegawai'),SHA2('keyloginekinerja',512))";
        return $this->db->query($sql);
    }

    public function drh_jabatan($id_pegawai){
        $sql = "SELECT a.jenis, a.kode_jabatan, a.nama_jabatan,
                CASE WHEN a.no_sk IS NULL = 1 THEN '-' ELSE a.no_sk END AS no_sk,
                CASE WHEN a.tmt IS NULL = 1 THEN '-' ELSE a.tmt END AS tmt,
                CASE WHEN a.kelas_jabatan IS NULL = 1 THEN '-' ELSE a.kelas_jabatan END AS kelas_jabatan,
                CASE WHEN a.nilai_jabatan IS NULL = 1 THEN '-' ELSE a.nilai_jabatan END AS nilai_jabatan
                FROM (SELECT 'Fungsional Umum' AS jenis, jfu.id_jfu as kode_jabatan, jfu.nama_jfu as nama_jabatan, s.no_sk, j.tmt, jfu.kelas_jabatan, jfu.nilai_jabatan
                FROM jfu_pegawai j
                LEFT JOIN jfu_master jfu ON j.id_jfu = jfu.id_jfu
                LEFT JOIN sk s ON j.id_sk = s.id_sk
                WHERE j.id_pegawai = AES_DECRYPT(UNHEX('$id_pegawai'),SHA2('keyloginekinerja',512))
                UNION ALL
                SELECT 'Fungsional Tertentu' AS jenis, jf.id_jafung as kode_jabatan, jf.nama_jafung as nama_jabatan, s.no_sk, j.tmt, jf.kelas_jabatan, jf.nilai_jabatan
                FROM jafung_pegawai j
                LEFT JOIN jafung jf ON j.id_jafung = jf.id_jafung
                LEFT JOIN sk s ON j.id_sk = s.id_sk
                WHERE j.id_pegawai = AES_DECRYPT(UNHEX('$id_pegawai'),SHA2('keyloginekinerja',512))
                UNION ALL
                SELECT 'Struktural' AS jenis, j.id_j as kode_jabatan, j.jabatan as nama_jabatan, s.no_sk, s.tmt, j.kelas_jabatan, j.nilai_jabatan
                FROM sk s LEFT JOIN kategori_sk k ON s.id_kategori_sk = k.id_kategori_sk
                LEFT JOIN jabatan j ON s.id_j = j.id_j 
                LEFT JOIN golongan g ON s.gol = g.golongan 
                WHERE k.id_kategori_sk = 10 AND s.id_pegawai = AES_DECRYPT(UNHEX('$id_pegawai'),SHA2('keyloginekinerja',512))) a 
                ORDER BY a.tmt";
        return $this->db->query($sql);
    }

    public function drh_keluarga_istri_suami($id_pegawai){
        $sql = "SELECT k.nama, k.tempat_lahir, k.tgl_lahir, k.tgl_menikah, k.pekerjaan
                FROM keluarga k 
                WHERE k.id_pegawai = AES_DECRYPT(UNHEX('$id_pegawai'),SHA2('keyloginekinerja',512)) AND k.id_status = 9";
        return $this->db->query($sql);
    }

    public function drh_keluarga_anak($id_pegawai){
        $sql = "SELECT k.nama, CASE WHEN k.jk = 1 THEN 'Laki-laki' ELSE 'Perempuan' END AS jk, k.tempat_lahir, k.tgl_lahir, k.pekerjaan
                FROM keluarga k 
                WHERE k.id_pegawai = AES_DECRYPT(UNHEX('$id_pegawai'),SHA2('keyloginekinerja',512)) AND k.id_status = 10
                ORDER BY k.tgl_lahir";
        return $this->db->query($sql);
    }

    public function drh_alih_tugas($id_pegawai){
        $sql = "SELECT s.id_sk, k.nama_sk, s.no_sk, s.tmt, s.tgl_sk, uk.nama_baru as unit
                FROM sk s 
                LEFT JOIN riwayat_mutasi_kerja rmk ON s.id_sk = rmk.id_sk
                LEFT JOIN unit_kerja uk ON rmk.id_unit_kerja = uk.id_unit_kerja
                LEFT JOIN kategori_sk k ON s.id_kategori_sk = k.id_kategori_sk
                LEFT JOIN golongan g ON s.gol = g.golongan
                WHERE (k.id_kategori_sk = 1 OR k.id_kategori_sk = 6 OR k.id_kategori_sk = 7) 
                AND s.id_pegawai = AES_DECRYPT(UNHEX('$id_pegawai'),SHA2('keyloginekinerja',512)) 
                ORDER BY s.tmt";
        return $this->db->query($sql);
    }

    public function jumlah_aktifitas_by_id_paged($tgl, $status, $target, $keyword, $id_knj, $keyApps){
        $andKlausa = '';
        if($tgl!='0'){
            $andKlausa .= " AND DAY(kk.kegiatan_tanggal) = ".$tgl;
        }
        if($status!='0'){
            if($status==4){
                $andKlausa .= " AND kk.approved IS NULL ";
            }else{
                $andKlausa .= " AND kk.approved = ".$status;
            }
        }
        if($target!='0'){
            $andKlausa .= " AND kk.kegiatan_kategori_id = ".$target;
        }
        if (!(trim($keyword)== "") && !(trim($keyword)== "0")){
            $andKlausa .= " AND (kk.kegiatan_rincian LIKE '%".$keyword."%'
								OR kk.kegiatan_keterangan LIKE '%".$keyword."%'
								OR ss.uraian_tugas LIKE '%".$keyword."%')".$andKlausa;
        }
        $sql = "SELECT COUNT(*) AS jumlah FROM 
                (SELECT * FROM knj_kinerja_historis_alih_tugas kkat
                WHERE kkat.id_knj_master = AES_DECRYPT(UNHEX('$id_knj'), SHA2($keyApps,512))) a
                INNER JOIN knj_kinerja_kegiatan kk ON kk.idknj_hist_alih_tugas = a.idknj_hist_alih_tugas
                LEFT JOIN skp_target ss ON kk.kegiatan_kategori_id = ss.id_skp_target
                WHERE kk.id_knj_kegiatan IS NOT NULL $andKlausa";
        return $this->db->query($sql);
    }

    public function list_aktifitas_kegiatan_by_id_paged($row_number_start, $tgl, $status, $target, $keyword, $id_knj, $limit, $keyApps){
        $andKlausa = '';
        if($tgl!='0'){
            $andKlausa .= " AND DAY(kk.kegiatan_tanggal) = ".$tgl;
        }
        if($status!='0'){
            if($status==4){
                $andKlausa .= " AND kk.approved IS NULL ";
            }else{
                $andKlausa .= " AND kk.approved = ".$status;
            }
        }
        if($target!='0'){
            $andKlausa .= " AND kk.kegiatan_kategori_id = ".$target;
        }
        if (!(trim($keyword)== "") && !(trim($keyword)== "0")){
            $andKlausa .= " AND (kk.kegiatan_rincian LIKE '%".$keyword."%'
								OR kk.kegiatan_keterangan LIKE '%".$keyword."%'
								OR ss.uraian_tugas LIKE '%".$keyword."%')".$andKlausa;
        }
        $this->db->query("SET @row_number := $row_number_start");
        $sql = "SELECT HEX(AES_ENCRYPT(kk.id_knj_kegiatan,SHA2($keyApps,512))) as id_knj_kegiatan_enc,
                  HEX(AES_ENCRYPT(a.id_knj_master,SHA2($keyApps,512))) as id_knj_master_enc, 
                  kk.*, trim(replace(REPLACE(kk.kegiatan_rincian,CHAR(13),''),CHAR(10),' ')) as kegiatan_rincian2,
                  (CASE WHEN (ss.uraian_tugas = '' OR ss.uraian_tugas IS NULL) THEN 
                  (CASE WHEN kk.kegiatan_kategori_id = -1 THEN 'Tugas Tambahan' ELSE
                  (CASE WHEN kk.kegiatan_kategori_id = -4 THEN 'Tugas Tambahan Khusus' ELSE
                  (CASE WHEN kk.kegiatan_kategori_id = -2 THEN 'Instruksi Khusus Pimpinan (IKP) khusus JPT' ELSE
                  (CASE WHEN kk.kegiatan_kategori_id = -3 THEN 'Penyesuaian Target Baru' ELSE '' END) END) END) END) ELSE ss.uraian_tugas END) as kegiatan, DATE_FORMAT(kk.kegiatan_tanggal, '%d-%m-%Y %H:%i:%s') AS kegiatan_tanggal2,
                  DATE_FORMAT(kk.tgl_input, '%d-%m-%Y %H:%i:%s') AS tgl_input2,
                  DATE_FORMAT(kk.tgl_update, '%d-%m-%Y %H:%i:%s') AS tgl_update2,
                  DATE_FORMAT(kk.tgl_approved, '%d-%m-%Y %H:%i:%s') AS tgl_approved2, a.atsl_nama, a.atsl_nip, a.atsl_nama_plh FROM
                (SELECT * FROM knj_kinerja_historis_alih_tugas kkat
                WHERE kkat.id_knj_master = AES_DECRYPT(UNHEX('$id_knj'), SHA2($keyApps,512))) a
                INNER JOIN knj_kinerja_kegiatan kk ON kk.idknj_hist_alih_tugas = a.idknj_hist_alih_tugas
                LEFT JOIN skp_target ss ON kk.kegiatan_kategori_id = ss.id_skp_target
                WHERE kk.id_knj_kegiatan IS NOT NULL $andKlausa
                ORDER BY kk.kegiatan_tanggal DESC $limit";

        return $this->db->query($sql);
    }

    function jml_daftar_unit_kerja_sekunder_by_opd_paged($opd, $keyword){
        $andKlausa = '';
        if($opd!='0'){
            $andKlausa .= " AND uk.id_uk_primer = $opd";
        }

        if (!(trim($keyword)== "") && !(trim($keyword)== "0")){
            $andKlausa .= " AND (uk.nama LIKE '%".$keyword."%'
								OR uk.alamat LIKE '%".$keyword."%'
								OR p.nama LIKE '%".$keyword."%')".$andKlausa;
        }

        $sql = "SELECT COUNT(*) AS jumlah 
                FROM unit_kerja_sekunder uk 
                LEFT JOIN unit_kerja_sekunder uk2 ON uk.id_uk_induk = uk2.id_uk_sekunder
                LEFT JOIN unit_kerja uk3 ON uk.id_uk_primer = uk3.id_unit_kerja
                LEFT JOIN pegawai p ON uk.inputer = p.id_pegawai 
                WHERE uk.id_uk_primer IS NOT NULL".$andKlausa;

        return $this->db->query($sql);
    }

    function list_daftar_unit_kerja_sekunder_by_opd_paged($row_number_start, $opd, $keyword, $limit, $keyApps){
        $andKlausa = '';
        if($opd!='0'){
            $andKlausa .= " AND uk.id_uk_primer = $opd ";
        }

        if (!(trim($keyword)== "") && !(trim($keyword)== "0")){
            $andKlausa .= " AND (uk.nama LIKE '%".$keyword."%'
								OR uk.alamat LIKE '%".$keyword."%'
								OR p.nama LIKE '%".$keyword."%') ".$andKlausa;
        }

        $this->db->query("SET @row_number := $row_number_start");
        $sql = "SELECT uk.id_uk_sekunder, HEX(AES_ENCRYPT(uk.id_uk_sekunder,SHA2($keyApps,512))) AS id_uk_sekunder_enc, 
                uk.nama, uk.alamat, uk.telp, uk.email, uk.in_long, uk.in_lat, uk.out_long, uk.out_lat, uk.tipe_wilayah,
                uk2.nama as induk, uk3.nama_baru as utama, p.id_pegawai as idp_inputer, p.nama as inputer, DATE_FORMAT(uk.tgl_input, '%d-%m-%Y %H:%i:%s') AS tgl_input
                FROM unit_kerja_sekunder uk 
                LEFT JOIN unit_kerja_sekunder uk2 ON uk.id_uk_induk = uk2.id_uk_sekunder
                LEFT JOIN unit_kerja uk3 ON uk.id_uk_primer = uk3.id_unit_kerja
                LEFT JOIN pegawai p ON uk.inputer = p.id_pegawai 
                WHERE uk.id_uk_primer IS NOT NULL ".$andKlausa.$limit;

        return $this->db->query($sql);
    }

    public function get_hist_staf_plh($id_pegawai_enc){
        $sql = "SELECT a.*, HEX(AES_ENCRYPT(kkm.id_pegawai_pelapor,SHA2('keyloginekinerja',512))) AS id_pegawai_enc, 
                kkm.periode_thn, CUSTOM_MONTH_NAME(kkm.periode_bln) AS periode_bln, ksk.status_knj, kkm.flag_kalkulasi, kkm.tgl_update_kalkulasi, 
                p.nip_baru, CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END, nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(', ',p.gelar_belakang) END) AS nama, 
                g.pangkat, p.pangkat_gol, p.jenjab, 
                CASE WHEN j.eselon IS NULL THEN 'Z' ELSE j.eselon END AS eselon,
                CASE WHEN p.jenjab = 'Fungsional' THEN (jafung.kode_jabatan_jafung) ELSE
                CASE WHEN p.id_j IS NULL THEN (jfu.kode_jabatan_jfu) ELSE j.id_j END END AS kode_jabatan,
                CASE WHEN p.jenjab = 'Fungsional' THEN (jafung.kelas_jabatan_jafung) ELSE
                CASE WHEN p.id_j IS NULL THEN (jfu.kelas_jabatan_jfu) ELSE j.kelas_jabatan END END AS kelas_jabatan,
                CASE WHEN p.jenjab = 'Fungsional' THEN (jafung.nilai_jabatan_jafung) ELSE
                CASE WHEN p.id_j IS NULL THEN (jfu.nilai_jabatan_jfu) ELSE j.nilai_jabatan END END AS nilai_jabatan,
                CASE WHEN p.jenjab = 'Fungsional' THEN (CASE WHEN jafung.nama_jafung IS NULL THEN p.jabatan ELSE jafung.nama_jafung END) ELSE
                CASE WHEN p.id_j IS NULL THEN (jfu.nama_jfu) ELSE j.jabatan END END AS jabatan 
                FROM 
                (SELECT MAX(kkh.id_knj_master) AS  id_knj_master FROM knj_kinerja_historis_alih_tugas kkh 
                INNER JOIN knj_kinerja_master kkm ON kkh.id_knj_master = kkm.id_knj_master 
                WHERE kkh.atsl_idp_plh = AES_DECRYPT(UNHEX('$id_pegawai_enc'),SHA2('keyloginekinerja',512))
                GROUP BY kkm.id_pegawai_pelapor) a 
                INNER JOIN knj_kinerja_master kkm ON a.id_knj_master = kkm.id_knj_master
                INNER JOIN knj_status_kinerja ksk ON kkm.id_status_knj = ksk.id_status_knj
                INNER JOIN pegawai p ON kkm.id_pegawai_pelapor = p.id_pegawai AND p.flag_pensiun = 0
                LEFT JOIN jabatan j ON p.id_j = j.id_j
                LEFT JOIN golongan g ON p.pangkat_gol = g.golongan
                LEFT JOIN (
                SELECT b.id_pegawai, jm.id_jfu as kode_jabatan_jfu, jm.kelas_jabatan as kelas_jabatan_jfu,
                jm.nilai_jabatan as nilai_jabatan_jfu, jm.nama_jfu
                FROM (SELECT a.*, jp.id_jfu FROM
                (SELECT jp.id_pegawai, MAX(jp.id) as id_jfu_pegawai FROM jfu_pegawai jp,
                (SELECT id_pegawai, MAX(tmt) as max_tmt FROM jfu_pegawai WHERE tmt IS NOT NULL GROUP BY id_pegawai) x
                WHERE jp.id_pegawai = x.id_pegawai AND jp.tmt = x.max_tmt
                GROUP BY jp.id_pegawai) a
                INNER JOIN jfu_pegawai jp ON a.id_jfu_pegawai = jp.id) b
                INNER JOIN jfu_master jm ON b.id_jfu = jm.id_jfu) jfu ON jfu.id_pegawai = p.id_pegawai
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
                ORDER BY eselon ASC, p.pangkat_gol DESC, p.nama";
        return $this->db->query($sql);
    }

    public function listof_kinerja_master_staf_plh($id_pegawai, $idp_atsl_plh, $keyApps){
        $sql = "SELECT HEX(AES_ENCRYPT(a.id_knj_master,SHA2($keyApps,512))) as id_knj_master, a.atsl_idp_plh, kkm.periode_thn, CUSTOM_MONTH_NAME(kkm.periode_bln) AS periode_bln, 
                ksk.status_knj, kkm.flag_kalkulasi, 
                DATE_FORMAT(kkm.tgl_update_kalkulasi, '%d-%m-%Y %H:%i:%s') as tgl_update_kalkulasi,
                a.jumlah_kegiatan, a.tgl_input_kinerja  
                FROM (SELECT kkh.id_knj_master, DATE_FORMAT(knj.tgl_input_kinerja, '%d-%m-%Y %H:%i:%s') as tgl_input_kinerja,  
                kkh.atsl_idp_plh, COUNT(kkk.id_knj_kegiatan) AS jumlah_kegiatan 
                FROM knj_kinerja_master knj 
                INNER JOIN knj_kinerja_historis_alih_tugas kkh ON knj.id_knj_master = kkh.id_knj_master 
                INNER JOIN knj_kinerja_kegiatan kkk ON kkh.idknj_hist_alih_tugas = kkk.idknj_hist_alih_tugas
                WHERE knj.id_pegawai_pelapor = AES_DECRYPT(UNHEX('$id_pegawai'),SHA2('keyloginekinerja',512)) 
                AND kkh.atsl_idp_plh = AES_DECRYPT(UNHEX('$idp_atsl_plh'),SHA2('keyloginekinerja',512)) 
                GROUP BY kkh.id_knj_master) a INNER JOIN knj_kinerja_master kkm ON a.id_knj_master = kkm.id_knj_master
                INNER JOIN knj_status_kinerja ksk ON kkm.id_status_knj = ksk.id_status_knj";

        return $this->db->query($sql);
    }

    public function jumlah_peninjauan_kegiatan_staf_plh($idstatus, $txtKeyword, $id_knj_master, $id_pegawai_atsl_enc, $keyApps){
        $andKlausa = '';
        if($idstatus!='0'){
            if($idstatus==4){
                $andKlausa .= " AND kkk.approved IS NULL ";
            }else{
                $andKlausa .= " AND kkk.approved = " . $idstatus;
            }
        }

        if (!(trim($txtKeyword)== "") && !(trim($txtKeyword)== "0")){
            $andKlausa .= " AND (kkk.kegiatan_keterangan LIKE '%".$txtKeyword."%'
								OR kkk.kegiatan_rincian LIKE '%".$txtKeyword."%'
								OR kkk.satuan LIKE '%".$txtKeyword."%'
								OR st.uraian_tugas LIKE '%".$txtKeyword."%')";
        }

        $sql = "SELECT COUNT(*) AS jumlah 
                FROM (SELECT kkm.id_knj_master 
                FROM knj_kinerja_master kkm WHERE kkm.id_knj_master = AES_DECRYPT(UNHEX('$id_knj_master'), SHA2('$keyApps',512))) a 
                 INNER JOIN knj_kinerja_historis_alih_tugas kkh ON a.id_knj_master = kkh.id_knj_master AND kkh.atsl_idp_plh = AES_DECRYPT(UNHEX('$id_pegawai_atsl_enc'), SHA2('keyloginekinerja',512))
                INNER JOIN knj_kinerja_kegiatan kkk ON kkh.idknj_hist_alih_tugas = kkk.idknj_hist_alih_tugas
                LEFT JOIN skp_target st ON kkk.kegiatan_kategori_id = st.id_skp_target 
                $andKlausa ORDER BY kkk.kegiatan_tanggal DESC";
        return $this->db->query($sql);
    }

    public function list_peninjauan_kegiatan_staf_plh($row_number_start, $idstatus, $txtKeyword, $id_knj_master, $id_pegawai_atsl_enc, $limit, $keyApps){
        $andKlausa = '';
        if($idstatus!='0'){
            if($idstatus==4){
                $andKlausa .= " AND kkk.approved IS NULL ";
            }else {
                $andKlausa .= " AND kkk.approved = " . $idstatus;
            }
        }

        if (!(trim($txtKeyword)== "") && !(trim($txtKeyword)== "0")){
            $andKlausa .= " AND (kkk.kegiatan_keterangan LIKE '%".$txtKeyword."%'
								OR kkk.kegiatan_rincian LIKE '%".$txtKeyword."%'
								OR kkk.satuan LIKE '%".$txtKeyword."%'
								OR st.uraian_tugas LIKE '%".$txtKeyword."%')";
        }

        $this->db->query("SET @row_number := $row_number_start");
        $sql = "SELECT FCN_ROW_NUMBER() as no_urut, a.*, p.nip_baru, CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
                nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(' ',p.gelar_belakang) END) AS nama FROM (
                SELECT kkk.*, (CASE WHEN (st.uraian_tugas = '' OR st.uraian_tugas IS NULL) THEN 
                (CASE WHEN kkk.kegiatan_kategori_id = -1 THEN 'Tugas Tambahan' ELSE
                (CASE WHEN kkk.kegiatan_kategori_id = -4 THEN 'Tugas Tambahan Khusus' ELSE
                (CASE WHEN kkk.kegiatan_kategori_id = -2 THEN 'Instruksi Khusus Pimpinan (IKP) khusus JPT' ELSE
                (CASE WHEN kkk.kegiatan_kategori_id = -3 THEN 'Penyesuaian Target Baru' ELSE '' END) END) END) END) ELSE st.uraian_tugas END) as uraian_tugas, 
                DATE_FORMAT(kkk.kegiatan_tanggal, '%d-%m-%Y %H:%i:%s') AS tgl_kegiatan,
                DATE_FORMAT(kkk.tgl_input, '%d-%m-%Y %H:%i:%s') AS tgl_entri,
                (CASE WHEN approved IS NULL THEN NULL ELSE DATE_FORMAT(kkk.tgl_approved, '%d-%m-%Y %H:%i:%s') END) AS tgl_approved2, 
                HEX(AES_ENCRYPT(kkk.id_knj_kegiatan,SHA2($keyApps,512))) AS id_knj_kegiatan_enc, kkh.atsl_nip
                FROM (SELECT kkm.id_knj_master 
                FROM knj_kinerja_master kkm WHERE kkm.id_knj_master = AES_DECRYPT(UNHEX('$id_knj_master'), SHA2('$keyApps',512))) a 
                INNER JOIN knj_kinerja_historis_alih_tugas kkh ON a.id_knj_master = kkh.id_knj_master AND kkh.atsl_idp_plh = AES_DECRYPT(UNHEX('$id_pegawai_atsl_enc'), SHA2('keyloginekinerja',512))
                INNER JOIN knj_kinerja_kegiatan kkk ON kkh.idknj_hist_alih_tugas = kkk.idknj_hist_alih_tugas
                LEFT JOIN skp_target st ON kkk.kegiatan_kategori_id = st.id_skp_target 
                $andKlausa ORDER BY kkk.kegiatan_tanggal DESC) a
                LEFT JOIN pegawai p ON a.id_pegawai_approved = p.id_pegawai $limit";
        return $this->db->query($sql);
    }

    public function kinerjaHistAlihTugasById($id_knj, $id_knj_alih_tugas, $keyApps){
        $sql = "SELECT * FROM knj_kinerja_historis_alih_tugas kkh 
                WHERE kkh.id_knj_master = AES_DECRYPT(UNHEX('$id_knj'), SHA2($keyApps,512)) AND 
                kkh.idknj_hist_alih_tugas = AES_DECRYPT(UNHEX('$id_knj_alih_tugas'), SHA2($keyApps,512))";
        return $this->db->query($sql);
    }

}

?>