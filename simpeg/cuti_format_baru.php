<style>
    .loader {
        position: absolute;
        /*left: 50%;
        top: 50%;*/
        z-index: 1;
        width: 150px;
        height: 150px;
        margin: -75px 0 0 -75px;
        border: 16px solid #f3f3f3;
        border-radius: 50%;
        border-top: 16px solid #3498db;
        width: 120px;
        height: 120px;
        -webkit-animation: spin 2s linear infinite;
        animation: spin 2s linear infinite;
    }

    @-webkit-keyframes spin {
        0% { -webkit-transform: rotate(0deg); }
        100% { -webkit-transform: rotate(360deg); }
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
</style>
<?php
//include(SYSTEM_DIR . "class/cls_koncil.php");
//$db = Database::getInstance();
//$mysqli = $db->getConnection();

include 'class/cls_cuti.php';
$oCuti = new Cuti();

include 'class/cls_rest_data.php';
$oRest = new RestData();

extract($_POST);
extract($_GET);

if(@$aktif==2)
{

    $sql = "SELECT cm.*, cs.*, cp.*
                FROM cuti_master cm
                LEFT JOIN cuti_sakit cs ON cm.id_cuti_master = cs.id_cuti_master
                LEFT JOIN cuti_persalinan cp ON cm.id_cuti_master = cp.id_cuti_master
                WHERE cm.id_cuti_master = $idcm";

    $qup=mysqli_query($mysqli, $sql);
    $up=mysqli_fetch_array($qup);

    $t3=substr($up['tmt_awal'],8,2);
    $b3=substr($up['tmt_awal'],5,2);
    $th3=substr($up['tmt_awal'],0,4);

    $t5=substr($up['tmt_akhir'],8,2);
    $b5=substr($up['tmt_akhir'],5,2);
    $th5=substr($up['tmt_akhir'],0,4);

    $upKeterangan = $up['keterangan'];
    $upAlasan = $up['alasan_cuti'];
    $idjeniscutinya = $up['id_jenis_cuti'];
    if($up['is_cuti_mundur']==1){
        $checked1 = '';
        $checked2 = 'checked';
    }else{
        $checked1 = 'checked';
        $checked2 = '';
    }
    if($up['is_kunjungan_luar_negeri']==1){
        $checked1 = '';
        $checked2 = 'checked';
    }else{
        $checked1 = 'checked';
        $checked2 = '';
    }
}else{
    $idjeniscutinya = 'C_TAHUNAN';
    $checked1 = 'checked';
    $checked2 = '';
    $checkedLuarNegeri1 = 'checked';
    $checkedLuarNegeri2 = '';
}

$sql_cek_unit = "SELECT a.*, uk.nama_baru as opd,
                    IF(uk.nama_baru LIKE '%Sekretariat Daerah%',0,
                    IF((uk.nama_baru LIKE '%Dinas Kesehatan%' OR uk.nama_baru LIKE '%Dinas Pendidikan%'),IF(a.id_unit_kerja=a.id_skpd,0,1),
                    IF((uk.nama_baru LIKE '%RSUD Kota Bogor%' AND a.jenjab = 'Fungsional'),1,0))) AS cek_unit FROM
                    (SELECT clk.id_unit_kerja, uk.id_skpd, p.nama, uk.nama_baru AS unit, p.jenjab
                    FROM pegawai p, current_lokasi_kerja clk, unit_kerja uk
                    WHERE p.id_pegawai = clk.id_pegawai AND p.flag_pensiun = 0 AND clk.id_unit_kerja = uk.id_unit_kerja
                    AND p.id_pegawai = ".@$_SESSION[id_pegawai]."
                    GROUP BY clk.id_unit_kerja, uk.id_skpd) a, unit_kerja uk
                    WHERE a.id_skpd = uk.id_unit_kerja";
$qrCekUnit = mysqli_query($mysqli, $sql_cek_unit);
$dataCekUnit = mysqli_fetch_array($qrCekUnit);


$sql_data = "SELECT data3.*, opd.nama_baru as opd, j.eselon as eselon_kepala, j.jabatan as jabatan_kepala, j.id_j as id_j_kepala, (data3.nilai_jabatan*4000) as tunjangan,
            p1.nip_baru as nip_baru_atsl_plh, CONCAT(CASE WHEN p1.gelar_depan = '' THEN '' ELSE CONCAT(p1.gelar_depan, ' ') END,
            p1.nama, CASE WHEN p1.gelar_belakang = '' THEN '' ELSE CONCAT(', ',p1.gelar_belakang) END) as nama_atsl_plh,
            CASE WHEN data3.jabatan_atsl LIKE 'Walikota Bogor%' THEN '-' ELSE p1.pangkat_gol END as gol_atsl_plh, p1.id_j as id_bos_atsl_plh,
            j1.jabatan as jabatan_atsl_plh,
            p2.nip_baru as nip_baru_pjbt_plh,
            CONCAT(CASE WHEN p2.gelar_depan = '' THEN '' ELSE CONCAT(p2.gelar_depan, ' ') END,
            p2.nama, CASE WHEN p2.gelar_belakang = '' THEN '' ELSE CONCAT(', ',p2.gelar_belakang) END) as nama_pjbt_plh,
            CASE WHEN data3.jabatan_pjbt LIKE 'Walikota Bogor%' THEN '-' ELSE p2.pangkat_gol END as gol_pjbt_plh, p2.id_j as id_bos_pjbt_plh,
            j2.jabatan as jabatan_pjbt_plh
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
                                      WHERE sk.id_pegawai = $_SESSION[id_pegawai] and riwayat_mutasi_kerja.id_pegawai = $_SESSION[id_pegawai]
                                      AND sk.id_kategori_sk = 18
                                      ORDER BY tmt DESC LIMIT 1) a ON rmk.id_riwayat = a.idriwayat)
                        ELSE  id_j_bos END AS id_j_bos
                        FROM riwayat_mutasi_kerja rmk INNER JOIN
                        (SELECT riwayat_mutasi_kerja.id_riwayat AS idriwayat
                        FROM riwayat_mutasi_kerja
                        INNER JOIN sk
                         ON sk.id_sk = riwayat_mutasi_kerja.id_sk
                        WHERE sk.id_pegawai = $_SESSION[id_pegawai] and riwayat_mutasi_kerja.id_pegawai = $_SESSION[id_pegawai]
                        AND (sk.id_kategori_sk = 52 OR sk.id_kategori_sk = 23)
                        ORDER BY tmt DESC LIMIT 1) a ON rmk.id_riwayat = a.idriwayat)
                    ELSE  id_j_bos END AS id_j_bos
                    FROM riwayat_mutasi_kerja rmk INNER JOIN
                    (SELECT riwayat_mutasi_kerja.id_riwayat AS idriwayat
                    FROM riwayat_mutasi_kerja
                    INNER JOIN sk
                     ON sk.id_sk = riwayat_mutasi_kerja.id_sk
                    WHERE sk.id_pegawai = $_SESSION[id_pegawai] and riwayat_mutasi_kerja.id_pegawai = $_SESSION[id_pegawai]
                    AND sk.id_kategori_sk = 55
                    ORDER BY tmt DESC LIMIT 1) a ON rmk.id_riwayat = a.idriwayat)
                ELSE  id_j_bos END AS id_j_bos
                FROM riwayat_mutasi_kerja rmk INNER JOIN
                (SELECT riwayat_mutasi_kerja.id_riwayat AS idriwayat
                FROM riwayat_mutasi_kerja
                INNER JOIN sk
                 ON sk.id_sk = riwayat_mutasi_kerja.id_sk
                WHERE sk.id_pegawai = $_SESSION[id_pegawai] and riwayat_mutasi_kerja.id_pegawai = $_SESSION[id_pegawai]
                AND sk.id_kategori_sk = 21
                ORDER BY tmt DESC LIMIT 1) a ON rmk.id_riwayat = a.idriwayat)
            ELSE  id_j_bos END AS id_j_bos
            FROM riwayat_mutasi_kerja rmk INNER JOIN
            (SELECT riwayat_mutasi_kerja.id_riwayat AS idriwayat
            FROM riwayat_mutasi_kerja
            INNER JOIN sk
             ON sk.id_sk = riwayat_mutasi_kerja.id_sk
            WHERE sk.id_pegawai = $_SESSION[id_pegawai] and riwayat_mutasi_kerja.id_pegawai = $_SESSION[id_pegawai]
            AND sk.id_kategori_sk = 12
            ORDER BY tmt DESC LIMIT 1) a ON rmk.id_riwayat = a.idriwayat)
            ELSE  id_j_bos END AS id_j_bos
            FROM riwayat_mutasi_kerja rmk INNER JOIN
            (SELECT riwayat_mutasi_kerja.id_riwayat AS idriwayat
            FROM riwayat_mutasi_kerja
            INNER JOIN sk
            ON sk.id_sk = riwayat_mutasi_kerja.id_sk
            WHERE sk.id_pegawai = $_SESSION[id_pegawai] and riwayat_mutasi_kerja.id_pegawai = $_SESSION[id_pegawai]
            AND sk.id_kategori_sk = 10
            ORDER BY tmt DESC LIMIT 1) a ON rmk.id_riwayat = a.idriwayat)
            ELSE  id_j_bos END AS id_j_bos
            FROM riwayat_mutasi_kerja rmk INNER JOIN
            (SELECT riwayat_mutasi_kerja.id_riwayat AS idriwayat
            FROM riwayat_mutasi_kerja
            INNER JOIN sk
            ON sk.id_sk = riwayat_mutasi_kerja.id_sk
            WHERE sk.id_pegawai = $_SESSION[id_pegawai] and riwayat_mutasi_kerja.id_pegawai = $_SESSION[id_pegawai]
            AND sk.id_kategori_sk = 9
            ORDER BY tmt DESC LIMIT 1) a ON rmk.id_riwayat = a.idriwayat)
            ELSE  id_j_bos END AS id_j_bos
            FROM riwayat_mutasi_kerja rmk INNER JOIN
            (SELECT riwayat_mutasi_kerja.id_riwayat AS idriwayat
            FROM riwayat_mutasi_kerja
            INNER JOIN sk
            ON sk.id_sk = riwayat_mutasi_kerja.id_sk
            WHERE sk.id_pegawai = $_SESSION[id_pegawai] and riwayat_mutasi_kerja.id_pegawai = $_SESSION[id_pegawai]
            AND sk.id_kategori_sk = 7
            ORDER BY tmt DESC LIMIT 1) a ON rmk.id_riwayat = a.idriwayat)
            ELSE  id_j_bos END AS id_j_bos
            FROM riwayat_mutasi_kerja rmk INNER JOIN
            (SELECT riwayat_mutasi_kerja.id_riwayat AS idriwayat
            FROM riwayat_mutasi_kerja
            INNER JOIN sk
            ON sk.id_sk = riwayat_mutasi_kerja.id_sk
            WHERE sk.id_pegawai = $_SESSION[id_pegawai] and riwayat_mutasi_kerja.id_pegawai = $_SESSION[id_pegawai]
            AND sk.id_kategori_sk = 6
            ORDER BY tmt DESC LIMIT 1) a ON rmk.id_riwayat = a.idriwayat)
            ELSE  id_j_bos END AS id_j_bos
            FROM riwayat_mutasi_kerja rmk INNER JOIN
            (SELECT riwayat_mutasi_kerja.id_riwayat AS idriwayat
            FROM riwayat_mutasi_kerja
            INNER JOIN sk
            ON sk.id_sk = riwayat_mutasi_kerja.id_sk
            WHERE sk.id_pegawai = $_SESSION[id_pegawai] and riwayat_mutasi_kerja.id_pegawai = $_SESSION[id_pegawai]
            AND sk.id_kategori_sk = 5
            ORDER BY tmt DESC LIMIT 1) a ON rmk.id_riwayat = a.idriwayat)
            ELSE  id_j_bos END AS id_j_bos
            FROM riwayat_mutasi_kerja rmk INNER JOIN
            (SELECT riwayat_mutasi_kerja.id_riwayat AS idriwayat
            FROM riwayat_mutasi_kerja
            INNER JOIN sk
            ON sk.id_sk = riwayat_mutasi_kerja.id_sk
            WHERE sk.id_pegawai = $_SESSION[id_pegawai] and riwayat_mutasi_kerja.id_pegawai = $_SESSION[id_pegawai]
            AND (sk.id_kategori_sk = 1)
            ORDER BY tmt DESC LIMIT 1) a ON rmk.id_riwayat = a.idriwayat
            )
            ELSE j.id_bos END as id_bos_atsl_ori,
            (SELECT id_bos FROM jabatan WHERE id_j = jplt.idj_plt_ybs) as id_bos_atsl_plt,
            ROUND(DATEDIFF(CURRENT_DATE, DATE_FORMAT(STR_TO_DATE(CONCAT(SUBSTRING(p.nip_baru,9,4),'/',SUBSTRING(p.nip_baru,13,2),'/','01'),
            '%Y/%m/%d'), '%Y-%m-%d'))/365,2) AS masa_kerja, p.alamat, p.is_kepsek, p.is_kapus, jplt.idj_plt_ybs, j2.jabatan as jabatan_plt_ybs, j2.eselon as eselon_plt_ybs
            FROM pegawai p
            LEFT JOIN jabatan j ON p.id_j = j.id_j
            LEFT JOIN (SELECT id_j as idj_plt_ybs, id_pegawai FROM jabatan_plt WHERE id_pegawai = $_SESSION[id_pegawai] ORDER BY tmt DESC LIMIT 1) jplt ON p.id_pegawai = jplt.id_pegawai
            LEFT JOIN jabatan j2 ON jplt.idj_plt_ybs = j2.id_j
            WHERE p.id_pegawai = $_SESSION[id_pegawai]) a LEFT JOIN
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
            WHERE sh.id_pegawai = $_SESSION[id_pegawai] AND YEAR(sh.periode_awal) = YEAR(NOW())
            AND sh.status_pengajuan IN (1,2,3,4,5,6,7)) AND sh.id_pegawai = $_SESSION[id_pegawai] AND YEAR(sh.periode_awal) = YEAR(NOW())
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
                       me_atsl.jabatan_atsl /*NOT*/ LIKE '%Kepala Dinas%' ELSE me_atsl.jabatan_atsl LIKE '%%' OR me_atsl.jabatan_atsl IS NULL END) ELSE
                  (CASE WHEN (me_atsl.jenjab = 'Fungsional' AND me_atsl.unit_kerja_me LIKE '%Dinas Tenaga Kerja%') THEN
                       me_atsl.jabatan_atsl LIKE '%Kepala Dinas%' ELSE me_atsl.jabatan_atsl LIKE '%%' OR me_atsl.jabatan_atsl IS NULL END)
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

//echo $sql_data;
$query = mysqli_query($mysqli, $sql_data);
$unitsama = false;
while($data2=mysqli_fetch_array($query)){
    if($data2['id_unit_kerja_atsl'] == $_SESSION['id_unit'] or $data2['id_unit_kerja_atsl'] == $data2['id_skpd_me']){
        $data = $data2;
        $unitsama = true;
    }else{
        if(sizeof($data2) == 1){
            $data = $data2;
        }else{
            if($unitsama==false) {
                $data = $data2;
            }
        }
    }

}

$nip = $data['nip_baru'];
$data['idj_atsl'] = $data['id_bos_atsl'];
$data['idj_pjbt'] = $data['id_bos_pjbt'];
$data['idp_atsl'] = $data['id_pegawai_atsl'];
$data['idp_pjbt'] = $data['id_pegawai_pjbt'];

/* Cek SKPD */
if(isset($data) and $data['id_unit_kerja_me']!=''){
    $sql = "SELECT b.*, j.eselon, j.jabatan, j.id_j FROM
     (SELECT a.*, uk.nama_baru as opd FROM (SELECT uk.id_unit_kerja, uk.id_skpd FROM unit_kerja uk WHERE uk.id_unit_kerja = ".$data['id_unit_kerja_me'].") a
     LEFT JOIN unit_kerja uk ON a.id_skpd = uk.id_unit_kerja) b LEFT JOIN jabatan j ON b.id_skpd = j.id_unit_kerja
     WHERE j.eselon = 'IIB'";

    $qPkm = mysqli_query($mysqli, $sql);
    $dataPkm = mysqli_fetch_array($qPkm);
    //echo "$dataPkm[0],$dataPkm[1]";
}

if($dataPkm[2]=='Dinas Kesehatan Kota Bogor'){
    if($dataPkm[0]<>$dataPkm[1]){
        $sql = "SELECT p.nip_baru, CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
                nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(' ',p.gelar_belakang) END) AS nama, p.pangkat_gol, p.id_pegawai
                FROM pegawai p, current_lokasi_kerja clk
                WHERE p.id_pegawai = clk.id_pegawai AND clk.id_unit_kerja = ".$data['id_unit_kerja_me']." AND p.is_kapus = true AND p.flag_pensiun = 0";
        $queryPkm = mysqli_query($mysqli,$sql);
        $dataPkm2 = mysqli_fetch_array($queryPkm);
        $data['nip_baru_atsl'] = $dataPkm2[0];
        
        if($data['nip_baru_atsl']==$data[1]){ //jika ia juga sbgai kapus

            $sql = "SELECT p.nip_baru, CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
            nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(' ',p.gelar_belakang) END) AS nama, g.golongan, p.id_pegawai
            FROM pegawai p, golongan g
            WHERE  p.pangkat_gol = g.golongan AND p.id_j = ".$dataPkm[5];

            $que = mysqli_query($mysqli, $sql);
            $dataQue = mysqli_fetch_array($que);
            $data['nip_baru_atsl'] = $dataQue[0];
            $data['nama_atsl'] = $dataQue[1];
            $data['gol_atsl'] = $dataQue[2];
            $data['jabatan_atsl'] = $dataPkm[4];
            $data['idj_atsl'] = $dataPkm[5];
            $data['idp_atsl'] = $dataQue[3];

            $sql = "SELECT p.nip_baru, CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
                    nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(' ',p.gelar_belakang) END) AS nama, g.golongan, j.jabatan, j.id_j, p.id_pegawai
                    FROM pegawai p, golongan g, jabatan j
                    WHERE  p.pangkat_gol = g.golongan AND p.id_j = (SELECT id_j FROM jabatan WHERE tahun =
                    (SELECT max(tahun) FROM jabatan) and jabatan LIKE '%Sekretaris Daerah%') AND p.id_j = j.id_j";

            $que = mysqli_query($mysqli,$sql);
            $dataQue = mysqli_fetch_array($que);
            $data['nip_baru_pjbt'] = $dataQue[0];
            $data['nama_pjbt'] = $dataQue[1];
            $data['gol_pjbt'] = $dataQue[2];
            $data['jabatan_pjbt'] = $dataQue[3];
            $data['idj_pjbt'] = $dataQue[4];
            $data['idp_pjbt'] = $dataQue[5];

        }else{
            $data['nama_atsl'] = $dataPkm2[1];
            $data['gol_atsl'] = $dataPkm2[2];
            if($data['nip_baru_atsl']!=''){
                $data['jabatan_atsl'] = 'Kepala Puskesmas '.$data['unit_kerja_me'];
            }else{
                $data['jabatan_atsl'] = '';
            }
            $data['idj_atsl'] = "NULL";
            $data['idp_atsl'] = $dataPkm2[3];

            $sql = "SELECT p.nip_baru, CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
            nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(' ',p.gelar_belakang) END) AS nama, g.golongan, p.id_pegawai
            FROM pegawai p, golongan g
            WHERE  p.pangkat_gol = g.golongan AND p.id_j = ".$dataPkm[5];

            $que = mysqli_query($mysqli,$sql);
            $dataQue = mysqli_fetch_array($que);
            $data['nip_baru_pjbt'] = $dataQue[0];
            $data['nama_pjbt'] = $dataQue[1];
            $data['gol_pjbt'] = $dataQue[2];
            $data['jabatan_pjbt'] = $dataPkm[4];
            $data['idj_pjbt'] = $dataPkm[5];
            $data['idp_pjbt'] = $dataQue[3];
        }
    }
}

if($data['idp_plt_atsl']!=''){
    $sql = "SELECT p.nip_baru, CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
                nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(' ',p.gelar_belakang) END) AS nama, g.golongan, j.jabatan, j.id_j, p.id_pegawai
                FROM pegawai p, golongan g, jabatan_plt jp, jabatan j
                WHERE p.id_pegawai = ".$data['idp_plt_atsl']." AND p.pangkat_gol = g.golongan AND p.id_pegawai = jp.id_pegawai AND jp.id_j = j.id_j ";
    $query2 = mysqli_query($mysqli, $sql);
    $data2 = mysqli_fetch_array($query2);
    $data['nip_baru_atsl'] = $data2[0];
    $data['nama_atsl'] = $data2[1];
    $data['gol_atsl'] = $data2[2];
    $data['jabatan_atsl'] = 'Plt. '.$data2[3];
    $data['idj_atsl'] = $data2[4];
    $data['idp_atsl'] = $data2[5];
}

if($data['idp_plt_pjbt']!=''){
    $sql = "SELECT p.nip_baru, CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
            nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(' ',p.gelar_belakang) END) AS nama,
            g.golongan, j.jabatan, j.id_j, p.id_pegawai, uk.id_skpd, clk.id_unit_kerja
            FROM pegawai p LEFT JOIN golongan g ON p.pangkat_gol = g.golongan
            LEFT JOIN jabatan_plt jp ON p.id_pegawai = jp.id_pegawai
            LEFT JOIN jabatan j ON jp.id_j = j.id_j
            LEFT JOIN current_lokasi_kerja clk ON p.id_pegawai = clk.id_pegawai
            LEFT JOIN unit_kerja uk ON clk.id_unit_kerja = uk.id_unit_kerja
            WHERE p.id_pegawai = ".$data['idp_plt_pjbt'];
    //echo $sql;
    $query2 = mysqli_query($mysqli, $sql);
    $data2 = mysqli_fetch_array($query2);

    if(is_numeric($data2[0])){
        $data['nip_baru_pjbt'] = $data2[0];
        $data['gol_pjbt'] = $data2[2];
    }else{
        $data['nip_baru_pjbt'] = '-';
        $data['gol_pjbt'] = '-';
    }

    $data['nama_pjbt'] = $data2[1];
    $data['jabatan_pjbt'] = 'Plt. '.$data2[3];
    $data['idj_pjbt'] = $data2[4];
    $data['idp_pjbt'] = $data2[5];
    //$data['id_skpd'] = $data2[6];
    $data['id_unit_kerja_pjbt'] = $data2[7];
}

if($dataPkm[2]=='Dinas Pendidikan Kota Bogor'){
    if($dataPkm[0]<>$dataPkm[1]) {
        $sql = "SELECT p.nip_baru, CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
                nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(' ',p.gelar_belakang) END) AS nama, p.pangkat_gol, p.id_j, p.id_pegawai
                FROM pegawai p, current_lokasi_kerja clk
                WHERE p.id_pegawai = clk.id_pegawai AND clk.id_unit_kerja = ".$data['id_unit_kerja_me']." AND p.is_kepsek = true AND p.flag_pensiun = 0";

        $queryPkm = mysqli_query($mysqli, $sql);
        $dataPkm2 = mysqli_fetch_array($queryPkm);
        $data['nip_baru_atsl'] = $dataPkm2[0];
        if($data['nip_baru_atsl']==$data[1]) { //jika ia juga sbgai kepsek
            $sql = "SELECT p.nip_baru, CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
            nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(' ',p.gelar_belakang) END) AS nama, g.golongan, p.id_j, p.id_pegawai
            FROM pegawai p, golongan g
            WHERE  p.pangkat_gol = g.golongan AND p.id_j = ".$dataPkm[5];
            $que = mysqli_query($mysqli,$sql);
            $dataQue = mysqli_fetch_array($que);
            $data['nip_baru_atsl'] = $dataQue[0];
            $data['nama_atsl'] = $dataQue[1];
            $data['gol_atsl'] = $dataQue[2];
            $data['jabatan_atsl'] = $dataPkm[4];
            $data['idj_atsl'] = $dataPkm[5];
            $data['idp_atsl'] = $dataQue[4];

            $sql = "SELECT p.nip_baru, CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
                    nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(' ',p.gelar_belakang) END) AS nama, g.golongan, j.jabatan, p.id_j, p.id_pegawai
                    FROM pegawai p, golongan g, jabatan j
                    WHERE  p.pangkat_gol = g.golongan AND p.id_j = (SELECT id_j FROM jabatan WHERE tahun =
                    (SELECT max(tahun) FROM jabatan) and jabatan LIKE '%Sekretaris Daerah%') AND p.id_j = j.id_j";
            $que = mysqli_query($mysqli, $sql);
            $dataQue = mysqli_fetch_array($que);
            $data['nip_baru_pjbt'] = $dataQue[0];
            $data['nama_pjbt'] = $dataQue[1];
            $data['gol_pjbt'] = $dataQue[2];
            $data['jabatan_pjbt'] = $dataQue[3];
            $data['idj_pjbt'] = $dataQue[4];
            $data['idp_pjbt'] = $dataQue[5];
        }else{
            if($data['jenjab']=='Fungsional' and $data['jabatan']=='Guru'){
                $data['nama_atsl'] = $dataPkm2[1];
                $data['gol_atsl'] = $dataPkm2[2];
                if($data['nip_baru_atsl']!=''){
                    $data['jabatan_atsl'] = 'Kepala Sekolah '.$data['unit_kerja_me'];
                }else{
                    $data['jabatan_atsl'] = '';
                }

                $data['idj_atsl'] = 'NULL';
                $data['idp_atsl'] = $dataPkm2[4];

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
                (SELECT '".$data['unit_kerja_me']."' AS sekolah) a) b ON p.id_j = b.id_j) c, jabatan j
                WHERE c.id_j = j.id_j";

                $query4 = mysqli_query($mysqli, $sql);
                $data4 = mysqli_fetch_array($query4);
                $data['nip_baru_pjbt'] = $data4[0];
                $data['nama_pjbt'] = $data4[1];
                $data['gol_pjbt'] = $data4[2];
                $data['jabatan_pjbt'] = $data4[3];
                $data['idj_pjbt'] = $data4[4];
                $data['idp_pjbt'] = $data4[5];
            }else{

                $sql = "SELECT p.nip_baru, CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
                    nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(' ',p.gelar_belakang) END) AS nama, g.golongan, j.jabatan, p.id_j, p.id_pegawai
                    FROM pegawai p, golongan g, jabatan j
                    WHERE  p.pangkat_gol = g.golongan AND p.id_j = (SELECT id_j FROM jabatan WHERE tahun =
                    (SELECT max(tahun) FROM jabatan) and jabatan LIKE '%Kasubag Umum dan Kepegawaian pada Dinas Pendidikan%') AND p.id_j = j.id_j";
                $que = mysqli_query($mysqli, $sql);
                $dataQue = mysqli_fetch_array($que);
                $data['nama_atsl'] = $dataQue[1];
                $data['gol_atsl'] = $dataQue[2];
                $data['jabatan_atsl'] = $dataQue[3];
                $data['idj_atsl'] = $dataQue[4];
                $data['idp_atsl'] = $dataQue[5];

                $sql = "SELECT p.nip_baru, CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
                    nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(' ',p.gelar_belakang) END) AS nama, g.golongan, j.jabatan, p.id_j, p.id_pegawai
                    FROM pegawai p, golongan g, jabatan j
                    WHERE  p.pangkat_gol = g.golongan AND p.id_j = (SELECT id_j FROM jabatan WHERE tahun =
                    (SELECT max(tahun) FROM jabatan) and jabatan LIKE '%Sekretaris Dinas Pendidikan%') AND p.id_j = j.id_j";

                $que = mysqli_query($mysqli, $sql);
                $dataQue = mysqli_fetch_array($que);
                $data['nip_baru_pjbt'] = $dataQue[0];
                $data['nama_pjbt'] = $dataQue[1];
                $data['gol_pjbt'] = $dataQue[2];
                $data['jabatan_pjbt'] = $dataQue[3];
                $data['idj_pjbt'] = $dataQue[4];
                $data['idp_pjbt'] = $dataQue[5];
            }
        }
    }
}

if($data['idp_plt_atsl']<>'' AND $data['idp_plt_pjbt']<>'') {
    if ($data['idp_plt_atsl'] == $data['idp_plt_pjbt']) {
        $sql = "SELECT id_skpd FROM unit_kerja WHERE id_unit_kerja = ".$data['id_unit_kerja_me'];
        $qry = mysqli_query($mysqli, $sql);
        $idskpd = mysqli_fetch_array($qry);
        $sql = "SELECT id_j FROM jabatan WHERE id_unit_kerja = $idskpd[0] AND eselon = 'IIIA'";
        $qry = mysqli_query($mysqli, $sql);
        $idj = mysqli_fetch_array($qry);

        $sql = "SELECT p.nip_baru, CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
                    nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(' ',p.gelar_belakang) END) AS nama, p.pangkat_gol, j.jabatan, j.id_j, p.id_pegawai
                    FROM pegawai p, jabatan j
                    WHERE p.id_j = j.id_j AND p.id_j = $idj[0]";
        $query = mysqli_query($mysqli, $sql);
        $data4 = mysqli_fetch_array($query);
        $data['nip_baru_pjbt'] = $data4[0];
        $data['nama_pjbt'] = $data4[1];
        $data['gol_pjbt'] = $data4[2];
        $data['jabatan_pjbt'] = $data4[3];
        $data['idj_pjbt'] = $data4[4];
        $data['idp_pjbt'] = $data4[5];
    }
}

if($data['idp_plh_atsl']<>'') {
    $data['nip_baru_atsl'] = $data['nip_baru_atsl_plh'];
    $data['nama_atsl'] = $data['nama_atsl_plh'];
    $data['gol_atsl'] = $data['gol_atsl_plh'];
    $data['jabatan_atsl'] = $data['jabatan_atsl_plh'].' sebagai PLH. '.$data['jabatan_atsl'];
    $data['idj_atsl'] = $data['id_bos_atsl_plh'];
    $data['idp_atsl'] = $data['idp_plh_atsl'];
}

if($data['idp_plh_pjbt']<>'') {
    $data['nip_baru_pjbt'] = $data['nip_baru_pjbt_plh'];
    $data['nama_pjbt'] = $data['nama_pjbt_plh'];
    $data['gol_pjbt'] = $data['gol_pjbt_plh'];
    $data['jabatan_pjbt'] = $data['jabatan_pjbt_plh'].' sebagai PLH. '.$data['jabatan_pjbt'];
    $data['idj_pjbt'] = $data['id_bos_pjbt_plh'];
    $data['idp_pjbt'] = $data['idp_plh_pjbt'];
}

$sql = "SELECT MAX(uk.id_unit_kerja) AS id_unit_kerja FROM unit_kerja uk
            WHERE uk.nama_baru LIKE '%Sekretariat Daerah%' AND uk.tahun = (SELECT MAX(tahun) FROM unit_kerja uk1)";
$query2 = mysqli_query($mysqli, $sql);
$data2 = mysqli_fetch_array($query2);


//echo $data['id_unit_kerja_me'].'-'.$data['id_unit_kerja_atsl'].'-'.$data['id_unit_kerja_pjbt'];
//echo $data['id_skpd'].'-'.$data2[0];

if($data['id_skpd']==$data2[0] or $data['jabatan_atsl']=='Sekretaris Daerah Kota Bogor'){
    $flag_uk_atasan_sama = 1;
}else {
    if ($data['id_unit_kerja_me'] == $data['id_unit_kerja_atsl']) {
        if ($data['id_unit_kerja_me'] == $data['id_unit_kerja_pjbt']) {
            $flag_uk_atasan_sama = 1;
        } else {
            $flag_uk_atasan_sama = 0;
        }
    } else {
        $flag_uk_atasan_sama = 0;
    }
}

if(@$issubmit=='true'){
    $txtTmtMulai = explode("-", $txtTmtMulai);
    $txtTmtMulai = $txtTmtMulai[2] . '-' . $txtTmtMulai[1] . '-' . $txtTmtMulai[0];
    $txtTmtSelesai = explode("-", $txtTmtSelesai);
    $txtTmtSelesai = $txtTmtSelesai[2] . '-' . $txtTmtSelesai[1] . '-' . $txtTmtSelesai[0];

    $call_sp2 = "CALL PRCD_CUTI_CHEK_LAMA('".$txtTmtSelesai."','".$txtTmtMulai."',".$txtLamaCuti.");";
    $query_sp = $mysqli->query($call_sp2);
    $jml_lama=$query_sp->num_rows;
    if($jml_lama>0){
        $query_sp->data_seek(0);
        while ($row_lama_cuti = $query_sp->fetch_assoc()) {
            $lama_n = $row_lama_cuti['lama_cuti'];
            $lama_n1 = $row_lama_cuti['lama_cuti_n1'];
        }
        // Free result set
        $query_sp->close();
        $mysqli->next_result();
    }

    if(isset($idup)){
        $date_now = date("Y-m-d");
        if ($date_now >= $txtTmtMulai) {
            $rdb_cuti_mundur = $rdb_cuti_mundur;
        }else{
            $rdb_cuti_mundur = 'NULL';
        }

        $sql_update = "update cuti_master set tmt_awal='$txtTmtMulai',tmt_akhir='$txtTmtSelesai',lama_cuti=$txtLamaCuti,
                       keterangan='$txtAlamatCuti',alasan_cuti = '$txtKeteranganTambahan',is_cuti_mundur=$rdb_cuti_mundur
                       where id_cuti_master=$idup";
        if (mysqli_query($mysqli, $sql_update) == TRUE) {
            echo("<div align=center style='background-color: #83c868;font-weight: bold;color: #ffffff; padding-top: 5px;padding-bottom: 5px;'> Pengajuan Cuti Berhasil Diubah </div>");
        }else{
            echo("<div align=center style='background-color:#c8271b;font-weight: bold;color: #ffffff; padding-top: 5px;padding-bottom: 5px;'> Error: Tidak dapat menyimpan data</div>");
        }
    }else {
        $sqlPenangguhan = "SELECT cp.*,  NOW() as tgl_skrg,
                            CASE WHEN  NOW() <= cp.tgl_akhir_penangguhan THEN 0 ELSE 1 END as status_cuti,
                            DATE_FORMAT(cp.tgl_mulai_penangguhan, '%d/%m/%Y') as tgl_mulai,
                            DATE_FORMAT(cp.tgl_akhir_penangguhan, '%d/%m/%Y') as tgl_selesai
                            FROM cuti_penangguhan cp WHERE cp.id_cuti_master =
                            (SELECT MAX(cp.id_cuti_master) as id_cuti_master FROM cuti_penangguhan cp, cuti_master c
                            WHERE cp.id_cuti_master = c.id_cuti_master AND  c.id_pegawai = ".$_SESSION['id_pegawai'].")";
        $rsP = $mysqli->query($sqlPenangguhan);
        $jmlP=$rsP->num_rows;
        if($jmlP>0){
            while ($otoP = $rsP->fetch_array(MYSQLI_BOTH)) {
                $tglMulaiPenangguhan = $otoP['tgl_mulai'];
                $tglSelesaiPenangguhan = $otoP['tgl_selesai'];
                $lamaPenangguhan = $otoP['lama_penangguhan'];
                $stsCuti = $otoP['status_cuti'];
            }
            if($stsCuti==0){
                $canCuti = 0;
            }else{
                $canCuti = 1;
            }
        }else{
            $canCuti = 1;
        }

        if($canCuti==1){
            $txtTglPengajuan = explode("-", $txtTglPengajuan);
            $txtTglPengajuan = $txtTglPengajuan[2] . '-' . $txtTglPengajuan[1] . '-' . $txtTglPengajuan[0];

            switch ($cboIdJnsCuti) {
                case 'C_SAKIT':
                    $sub_jenis_cuti = $cboIdJnsCutiSakit;
                    break;
                case 'C_BESAR':
                    $sub_jenis_cuti = "'".$rdb_cut_besar."'";
                    break;
                case 'C_ALASAN_PENTING':
                    $sub_jenis_cuti = "'".$rdb_cut_penting."'";
                    break;
                case 'CLTN':
                    $sub_jenis_cuti = "'".$rdb_cut_cltn."'";
                    break;
                default:
                    $sub_jenis_cuti = 'NULL';
                    break;
            }

            $date_now = date("Y-m-d");
            if ($date_now >= $txtTmtMulai) {
                $rdb_cuti_mundur = $rdb_cuti_mundur;
            }else{
                $rdb_cuti_mundur = 'NULL';
            }

            if($data['idj_atsl'] == ''){
                $data['idj_atsl'] = 'NULL';
            }

            if($data['idj_pjbt'] == ''){
                $data['idj_pjbt'] = 'NULL';
            }

            $sql_insert = "INSERT INTO cuti_master(periode_thn, tgl_usulan_cuti, id_pegawai, last_jenjab, last_jabatan,
                  last_gol, last_id_unit_kerja, last_unit_kerja, last_masa_kerja, last_atsl_nip, last_atsl_nama, last_atsl_gol, last_atsl_jabatan,
                  last_pjbt_nip, last_pjbt_nama, last_pjbt_gol, last_pjbt_jabatan, flag_uk_atasan_sama, id_jenis_cuti,
                  no_keputusan, tmt_awal, tmt_akhir, lama_cuti, keterangan, id_status_cuti, tgl_approve_status, approved_by, approved_note,
                  flag_lapor_selesai, tgl_lapor_selesai, idberkas_surat_cuti, last_atsl_id_j, last_pjbt_id_j, lama_cuti_n1, alasan_cuti,
                  idp_atsl, idp_pjbt, sub_jenis_cuti, is_cuti_mundur, is_kunjungan_luar_negeri, last_masa_kerja_text)
                  VALUES ($txtPeriode, NOW(), $_SESSION[id_pegawai], '$last_jenjab', '$last_jabatan', '$last_gol', '$last_id_unit_kerja',
                  '$last_unit_kerja', $last_masa_kerja, '$last_atsl_nip', '".addslashes($last_atsl_nama)."', '$last_atsl_gol', '$last_atsl_jabatan',
                  '$last_pjbt_nip', '".addslashes($last_pjbt_nama)."', '$last_pjbt_gol', '$last_pjbt_jabatan', $flag_uk_atasan_sama,
                  '$cboIdJnsCuti', '-', '$txtTmtMulai', '$txtTmtSelesai', $lama_n, '$txtAlamatCuti', 1, NOW(), $_SESSION[id_pegawai], NULL,
                  0,NULL,0,".$data['idj_atsl'].",".$data['idj_pjbt'].",".$lama_n1.",'".$txtKeteranganTambahan."',".$data['idp_atsl'].",".$data['idp_pjbt'].",".$sub_jenis_cuti.", $rdb_cuti_mundur, @$rdb_kunjungan_luar_negeri, '$last_masa_kerja_text')";

            if ($mysqli->query($sql_insert) === TRUE) {
                $last_id_cuti = $mysqli->insert_id;
                echo("<div align=center style='background-color: #83c868;font-weight: bold;color: #ffffff; padding-top: 5px;padding-bottom: 5px;'> Data Pengajuan Cuti Berhasil disimpan </div>");
                if ($cboIdJnsCuti == 'C_BERSALIN') {
                    $sql_insert_persalinan = "INSERT INTO cuti_persalinan(tgl_persalinan, tmt_awal_updated, tmt_akhir_updated, id_cuti_master)
                                  VALUES(NULL, NULL, NULL, $last_id_cuti);";
                    $mysqli->query($sql_insert_persalinan);
                };
                if ($cboIdJnsCuti == 'C_SAKIT') {
                    if ($cboIdJnsCutiSakit == 1) {
                        $flag_sakit = $rdb_flag_sakit_umum;
                    } else {
                        $flag_sakit = 1;
                    };
                    $sql_insert_sakit = "INSERT INTO cuti_sakit(idjenis_cuti_sakit, flag_sakit_baru, id_cuti_master)
                                VALUES($cboIdJnsCutiSakit, $flag_sakit, $last_id_cuti)";
                    $mysqli->query($sql_insert_sakit);
                };
            }else{
                echo("<div align=center style='background-color:#c8271b;font-weight: bold;color: #ffffff; padding-top: 5px;padding-bottom: 5px;'> Error: Tidak dapat menyimpan data</div>");
            }
        }else{
            echo("<div align=center style='background-color:#c8271b;font-weight: bold;color: #ffffff; padding-top: 5px;padding-bottom: 5px;'> Masih dalam masa penangguhan cuti</div>");
        }
    }
}

?>

<link rel="stylesheet" type="text/css" href="tcal.css" />
<link rel="stylesheet" href="js/jquery-confirm.min.css">
<script src="js/jquery-confirm.min.js"></script>
<script type="text/javascript" src="tcal.js"></script>
<script src="js/jquery-3.3.1.min.js"></script>
<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="SpryAssets/SpryValidationTextarea.js" type="text/javascript"></script>
<script type="text/javascript">
    function addTanggal(x){
        var e = document.getElementById("cboIdJnsCuti");
        var cekUnit = document.getElementById("txCekUnit").value;
        var jenis = e.options[e.selectedIndex].value;
        var awal = document.getElementById('txtTmtMulai').value;
        var startDate = new Date(awal.substr(3,2)+"/"+awal.substr(0,2)+"/"+awal.substr(6,4));
        Date.prototype.addDays = function(days) {
            var jmlHariFix = parseInt(days);
            var countKerja = 0;
            var jmlHari = parseInt(days);
            var jmlHariPengajuan = parseInt(days);
            for (i = 1; i <= jmlHari; i++) {
                countKerja++;
                var tomorrow = new Date(startDate);
                tomorrow.setDate(startDate.getDate()+parseInt(i)-1);
                var dayOfWeek = tomorrow.getDay();
                if(dayOfWeek==6 || dayOfWeek==0){
                    if(jenis=='C_TAHUNAN'){
                        if(dayOfWeek==6){
                            if(cekUnit==1){
                            }else{
                                jmlHari = jmlHari + 1;
                                countKerja = countKerja - 1;
                            }
                        }else{
                            jmlHari = jmlHari + 1;
                            countKerja = countKerja - 1;
                        }
                    }else {
                        if(jmlHariPengajuan < 60){
                            if(dayOfWeek==6){
                                if(cekUnit==1){
                                }else{
                                    jmlHari = jmlHari + 1;
                                    countKerja = countKerja - 1;
                                }
                            }else{
                                jmlHari = jmlHari + 1;
                                countKerja = countKerja - 1;
                            }
                        }
                    }
                }else{
                    var day = tomorrow.getDate();
                    var monthIndex = tomorrow.getMonth()+1;
                    var year = tomorrow.getFullYear();
                    var tgl = day.toString();
                    var bln = monthIndex.toString();
                    if(tgl.length==1){
                        tgl = "0" + tgl;
                    }
                    if(bln.length==1){
                        bln = "0" + bln;
                    }
                    var curDate = tgl+"/"+bln+"/"+year.toString();
                    if(jArrayCB.indexOf(curDate) > (-1)){
                        jmlHari = jmlHari+1;
                        countKerja = countKerja-1;
                    }
                    if(jArrayLN.indexOf(curDate) > (-1)){
                        jmlHari = jmlHari+1;
                        countKerja = countKerja-1;
                    }
                }
                if(countKerja == jmlHariFix){
                    break;
                }
            }
            var day = tomorrow.getDate();
            var monthIndex = tomorrow.getMonth()+1;
            var year = tomorrow.getFullYear();
            var tgl = day.toString();
            var bln = monthIndex.toString();
            if(tgl.length==1){
                tgl = "0" + tgl;
            }
            if(bln.length==1){
                bln = "0" + bln;
            }
            var tomorrow_new = tgl+"-"+bln+"-"+year.toString();
            $('#txtTmtSelesai').val(tomorrow_new);
        }
        var curDate = startDate;
        curDate.addDays(x);
    }

    function calculateDate(){
        var lama_cuti = document.getElementById('txtLamaCuti').value;
        if(isNaN(parseInt(lama_cuti)) == true){
            var lama_cuti = 1;
        }else{
            addTanggal(lama_cuti);
        }
        $('#frmCuti').data('bootstrapValidator').revalidateField('txtTmtMulai');
    }
</script>

<style>
    fieldset { border:0px solid #A6A6A6 }
    legend {
        padding: 0.2em 0.5em;
        border:1px solid #A6A6A6;
        color:black;
        font-size:100%;
        text-align:left;
    }
</style>
<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<link href="SpryAssets/SpryValidationTextarea.css" rel="stylesheet" type="text/css" />

<h2>Registrasi Cuti</h2> 

<div role="tabpanel">
    <ul class="nav nav-tabs" role="tablist" id="myTab">
        <?php
        if(isset($issubmit)){
            $issubmit = $issubmit;
        }else{
            $issubmit = '';
        }
        if(isset($ubahstatus)){
            $ubahstatus = $ubahstatus;
        }else{
            $ubahstatus = '';
        }
        if(isset($aktif)){
            $aktif = $aktif;
        }else{
            $aktif = 1;
        }
        ?>
        <li role="presentation" <?php echo($issubmit == 'true' ? '' : (($ubahstatus == 'true' ? '' : (!isset($aktif) or $aktif==1) ? " class=active" : '')));?>><a href="#data_dasar" aria-controls="data_dasar" role="tab" data-toggle="tab">Data Dasar</a></li>
        <li role="presentation" <?php echo($issubmit == 'true' ? '' : (($ubahstatus == 'true' ? '' : $aktif==2 ? " class=active" :''))); ?>><a href="#form_cuti" aria-controls="form_cuti" role="tab" data-toggle="tab">Form Registrasi</a></li>
        <li role="presentation" <?php echo(($issubmit == 'true' or $ubahstatus == 'true') ? " class=active" : ''); ?>><a href="#list_cuti" aria-controls="list_cuti" role="tab" data-toggle="tab">Status Pengajuan Cuti</a></li>
        <li role="presentation"><a href="#rekap" aria-controls="rekap" role="tab" data-toggle="tab">Rekapitulasi</a></li>
    </ul>
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane <?php echo($issubmit == 'true' ? '' : (($ubahstatus == 'true' ? '' : (!isset($aktif) or $aktif==1) ? "active" : '')));?>" id="data_dasar">
            <table width="95%" border="0" align="center" style="border-radius:5px;"
                   class="table table-bordered table-hover table-striped">
                <tr>
                    <td style="width: 5%;">a.</td>
                    <td style="width: 20%;">NIP</td>
                    <td style="width: 75%;"><?php echo $data['nip_baru'] ?></td>
                </tr>
                <tr>
                    <td style="width: 5%;">b.</td>
                    <td style="width: 20%;">Nama</td>
                    <td style="width: 75%;"><?php echo $data['nama'] ?></td>
                </tr>
                <tr>
                    <td style="width: 5%;">c.</td>
                    <td style="width: 20%;">Golongan</td>
                    <td style="width: 75%;"><?php echo $data['pangkat_gol'] ?></td>
                </tr>
                <tr>
                    <td style="width: 5%;">d.</td>
                    <td style="width: 20%;">Jenjang</td>
                    <td style="width: 75%;"><?php echo $data['jenjab'] ?></td>
                </tr>
                <tr>
                    <td style="width: 5%;">e.</td>
                    <td style="width: 20%;">Jabatan</td>
                    <td style="width: 75%;"><?php echo (($data['is_kepsek']==0 and $data['is_kapus']==0)?$data['jabatan']:($data['is_kepsek']==1?$data['jabatan'].' sebagai Kepala Sekolah':($data['is_kapus']==1?$data['jabatan'].' sebagai Kepala Puskesmas':$data['jabatan']))) ?></td>
                </tr>
                <tr>
                    <td style="width: 5%;">f.</td>
                    <td style="width: 20%;">Masa Kerja Keseluruhan</td>
                    <td style="width: 75%;">
                        <?php
                            //echo $data['masa_kerja'].' Tahun';
                            $masa_kerja = $oRest->masa_kerja_pegawai($_SESSION['id_pegawai']);
                            echo($masa_kerja->mk_tahun.' Tahun '.$masa_kerja->mk_bulan.' Bulan');
                        ?>
                    </td>
                </tr>
                <tr>
                    <td style="width: 5%;">g.</td>
                    <td style="width: 20%;">Unit Kerja</td>
                    <td style="width: 75%;"><?php echo $data['unit_kerja_me'] ?>
                        <input type="hidden" id="txCekUnit" name="txCekUnit" value="<?php echo $dataCekUnit[6] ?>">
                    </td>
                </tr>
                <tr>
                    <td style="width: 5%;"></td>
                    <td style="width: 20%;">Atasan Langsung</td>
                    <td style="width: 75%;"></td>
                </tr>
                <tr>
                    <td style="width: 5%;">a.</td>
                    <td style="width: 20%;">NIP</td>
                    <td style="width: 75%;"><?php echo ($data['nip_baru_atsl']==""?"Belum ada data":(is_numeric($data['nip_baru_atsl'])==true?$data['nip_baru_atsl']:'-')); ?></td>
                </tr>
                <tr>
                    <td style="width: 5%;">b.</td>
                    <td style="width: 20%;">Nama</td>
                    <td style="width: 75%;"><?php echo ($data['nama_atsl']==""?"Belum ada data":$data['nama_atsl']); ?></td>
                </tr>
                <tr>
                    <td style="width: 5%;">c.</td>
                    <td style="width: 20%;">Golongan</td>
                    <td style="width: 75%;"><?php echo ($data['gol_atsl']==""?(is_numeric($data['nip_baru_atsl'])==true?"Belum ada data":'-'):$data['gol_atsl']); ?></td>
                    <?php
                    if(is_numeric($data['nip_baru_atsl'])){
                        $data['gol_atsl'] = $data['gol_atsl'];
                    }else{
                        $data['gol_atsl'] = '-';
                    }
                    ?>
                </tr>
                <tr>
                    <td style="width: 5%;">d.</td>
                    <td style="width: 20%;">Jabatan</td>
                    <td style="width: 75%;"><?php echo ($data['jabatan_atsl']==""?"Belum ada data":$data['jabatan_atsl']); ?></td>
                </tr>
                <tr>
                    <td style="width: 5%;"></td>
                    <td style="width: 20%;">Pejabat Berwenang</td>
                    <td style="width: 75%;"></td>
                </tr>
                <tr>
                    <td style="width: 5%;">a.</td>
                    <td style="width: 20%;">NIP</td>
                    <td style="width: 75%;"><?php echo ($data['nip_baru_pjbt']==""?"Belum ada data":$data['nip_baru_pjbt']); ?></td>
                </tr>
                <tr>
                    <td style="width: 5%;">b.</td>
                    <td style="width: 20%;">Nama</td>
                    <td style="width: 75%;"><?php echo ($data['nama_pjbt']==""?"Belum ada data":$data['nama_pjbt']); ?></td>
                </tr>
                <tr>
                    <td style="width: 5%;">c.</td>
                    <td style="width: 20%;">Golongan</td>
                    <td style="width: 75%;"><?php echo ($data['gol_pjbt']==""?"Belum ada data":$data['gol_pjbt']); ?></td>
                </tr>
                <tr>
                    <td style="width: 5%;">d.</td>
                    <td style="width: 20%;">Jabatan</td>
                    <td style="width: 75%;"><?php echo ($data['jabatan_pjbt']==""?"Belum ada data":$data['jabatan_pjbt']); ?></td>
                </tr>
            </table><br>
            <div style="margin-top: -20px;">
                <strong>Keterangan :</strong><br>
                Jika data atasan belum tercantum silahkan <a href="<?php echo BASE_URL ?>index3.php?x=box.php&od=<?php echo $_SESSION['id_pegawai'];?>">Klik di sini</a>
                untuk mengubah Profil Pegawai. Pilihlah atasan langsungnya dan Simpan. <br>Atau terdapat data yang tidak lengkap. Jika masih belum muncul data atasannya harap hubungi Pengelola SIMPEG di OPD untuk melengkapi data <span style="color: blue;">Alih Tugas</span> terbaru.
            </div>
        </div>
        <div role="tabpanel" class="tab-pane <?php echo($issubmit == 'true' ? '' : ($ubahstatus == 'true' ? '' : ($aktif==2 ? "active" :''))); ?>" id="form_cuti">
            <?php
            if($aktif==2){
                $sql_data = "SELECT * FROM cuti_jenis cj
                        WHERE cj.id_jenis_cuti = '".$up['id_jenis_cuti']."'
                        ORDER BY cj.id_jenis_cuti DESC;";
            }else{
                $sql_data = "SELECT * FROM cuti_jenis cj ORDER BY cj.id_jenis_cuti DESC;";
            }
            $query = mysqli_query($mysqli, $sql_data);
            $array_data = array();
            while ($row = mysqli_fetch_array($query)) {
                $array_data[] = $row;
            }
            $array_data_length = count($array_data);
            $idjenis_cuti = $array_data[0]['id_jenis_cuti'];
            $jenis_cuti = $array_data[0]['deskripsi'];
            ?>
            <form action="index3.php?x=cuti_format_baru.php" method="post" enctype="multipart/form-data" name="frmCuti" id="frmCuti">
                <?php if(@$aktif==2) echo("<input type=hidden id=idup name=idup value=$idcm >"); ?>
                <fieldset onmouseover="calculateDate()">
                    <table class="table" id="tblFormCuti">
                        <tr>
                            <td>
                                <table class="table">
                                    <tr>
                                        <td colspan="2" style="border-top: 0px;"><i>Pastikan Data Dasar sudah lengkap</i></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <style>
                                                table#tbl_rekap {
                                                    width: 100%;
                                                    border: 2px solid black;
                                                    /*background-color: #f1f1c1;*/
                                                }
                                                table#tbl_rekap tr:nth-child(even) {
                                                    background-color: #eee;
                                                    text-align: center;
                                                    border: 1px solid black;
                                                }
                                                table#tbl_rekap tr:nth-child(odd) {
                                                    background-color:#fff;
                                                    text-align: center;
                                                    border: 1px solid black;
                                                }
                                                table#tbl_rekap th {
                                                    background-color: #474748;
                                                    color: white;
                                                    text-align: center;
                                                    border: 1px solid white;
                                                }
                                            </style>
                                            <span style="font-weight: bold">Rekapitulasi Cuti</span><br>
                                            <?php
                                            $call_sp = "CALL PRCD_CUTI_COUNT_HIST_GENERAL(".$_SESSION['id_pegawai'].");";
                                            $res_query_sp = $mysqli->query($call_sp);
                                            $rowcount=$res_query_sp->num_rows;
                                            if($rowcount>0){
                                                $sisa_cuti_tahunan = 0;
                                                $cuti_besar = 0;
                                                $jml_lama_cuti = 0;
                                                $jml_lama_cuti_n1 = 0;
                                                $jml_akumulasi_cuti = 0;
                                                $sisa_kuota_cuti_tahunan = 0;
                                                $jml_cuti_besar = 0;
                                                $jml_akumulasi_cuti_sakit_umum = 0;
                                                $jml_akumulasi_cuti_keguguran = 0;
                                                $jml_akumulasi_cuti_kecelakaan = 0;
                                                $jml_cuti_bersalin = 0;
                                                $jml_cuti_alasan_penting = 0;
                                                $jml_cuti_alasan_penting_n1 = 0;
                                                $jml_akumulasi_cuti_alasan_penting = 0;
                                                $jml_cuti_cltn = 0;

                                                $res_query_sp->data_seek(0);
                                                echo "<div><table id='tbl_rekap'><tr><th rowspan='2'>Tahun</th><th colspan='4' style='width: 20%'>Tahunan</th><th rowspan='2'>Besar</th>
                                                    <th colspan='3' style='width: 20%'>Sakit</th><th rowspan='2'>Bersalin</th><th colspan='3'>Alasan Penting</th><th rowspan='2'>CLTN</th></tr>
                                                    <tr><th style='width: 6%'>a</th><th style='width: 6%'>b</th>
                                                    <th style='width: 6%'>c</th><th style='width: 6%'>d</th>
                                                    <th style='width: 6%'>e</th><th style='width: 6%'>f</th><th style='width: 6%'>g</th>
                                                    <th style='width: 6%'>a</th><th style='width: 6%'>b</th><th style='width: 6%'>c</th></tr>";
                                                while ($row_hist_general = $res_query_sp->fetch_assoc()) {
                                                    echo "<tr><td>".$row_hist_general["periode_thn"]."</td>";
                                                    echo "<td>".$row_hist_general["jml_lama_cuti"]."</td>";
                                                    echo "<td>".$row_hist_general["jml_lama_cuti_n1"]."</td>";
                                                    echo "<td>".$row_hist_general["jml_akumulasi_cuti"]."</td>";
                                                    echo "<td>".$row_hist_general["sisa_kuota_cuti_tahunan"]."</td>";
                                                    echo "<td>".$row_hist_general["jml_cuti_besar"]."</td>";
                                                    echo "<td>".$row_hist_general["jml_akumulasi_cuti_sakit_umum"]."</td>";
                                                    echo "<td>".$row_hist_general["jml_akumulasi_cuti_keguguran"]."</td>";
                                                    echo "<td>".$row_hist_general["jml_akumulasi_cuti_kecelakaan"]."</td>";
                                                    echo "<td>".$row_hist_general["jml_cuti_bersalin"]."</td>";
                                                    echo "<td>".$row_hist_general["jml_cuti_alasan_penting"]."</td>";
                                                    echo "<td>".$row_hist_general["jml_cuti_alasan_penting_n1"]."</td>";
                                                    echo "<td>".$row_hist_general["jml_akumulasi_cuti_alasan_penting"]."</td>";
                                                    echo "<td>".$row_hist_general["jml_cuti_cltn"]."</td>";
                                                    echo "</tr>";

                                                    $jml_lama_cuti +=  $row_hist_general["jml_lama_cuti"] ;
                                                    $jml_lama_cuti_n1 +=  $row_hist_general["jml_lama_cuti_n1"] ;
                                                    $jml_akumulasi_cuti +=  $row_hist_general["jml_akumulasi_cuti"] ;
                                                    $sisa_kuota_cuti_tahunan +=  $row_hist_general["sisa_kuota_cuti_tahunan"] ;
                                                    $jml_cuti_besar +=  $row_hist_general["jml_cuti_besar"] ;
                                                    $jml_akumulasi_cuti_sakit_umum +=  $row_hist_general["jml_akumulasi_cuti_sakit_umum"] ;
                                                    $jml_akumulasi_cuti_keguguran +=  $row_hist_general["jml_akumulasi_cuti_keguguran"] ;
                                                    $jml_akumulasi_cuti_kecelakaan +=  $row_hist_general["jml_akumulasi_cuti_kecelakaan"] ;
                                                    $jml_cuti_bersalin +=  $row_hist_general["jml_cuti_bersalin"] ;
                                                    $jml_cuti_alasan_penting +=  $row_hist_general["jml_cuti_alasan_penting"] ;
                                                    $jml_cuti_alasan_penting_n1 +=  $row_hist_general["jml_cuti_alasan_penting_n1"] ;
                                                    $jml_akumulasi_cuti_alasan_penting +=  $row_hist_general["jml_akumulasi_cuti_alasan_penting"] ;
                                                    $jml_cuti_cltn +=  $row_hist_general["jml_cuti_cltn"] ;

                                                    if($row_hist_general["periode_thn"]==date("Y")){
                                                        $cuti_besar = $row_hist_general["jml_cuti_besar"];
                                                        if($cuti_besar>0){
                                                            $sisa_cuti_tahunan = 0;
                                                        }
                                                        $sisa_cur = $row_hist_general["sisa_kuota_cuti_tahunan"];
                                                        $akumulasi_cur = $row_hist_general["jml_akumulasi_cuti"];
                                                    }elseif($row_hist_general["periode_thn"]==date("Y")-1){
                                                        $sisa_cur_min_1 = $row_hist_general["sisa_kuota_cuti_tahunan"];
                                                        $sisa_cur_min_1_ori = $row_hist_general["sisa_kuota_cuti_tahunan"];
                                                    }elseif($row_hist_general["periode_thn"]==date("Y")-2){
                                                        $sisa_cur_min_2 = $row_hist_general["sisa_kuota_cuti_tahunan"];
                                                    }
                                                }
                                                $res_query_sp->close();
                                                $mysqli->next_result();

                                                if($sisa_cur_min_2 <0){
                                                    $sisa_cur_min_2 = 0;
                                                }else{
                                                    if(($sisa_cur_min_1+$sisa_cur_min_2)<0){
                                                        $sisa_cur_min_2 = 0;
                                                    }else{
                                                        if($sisa_cur_min_1 <0){
                                                            $sisa_cur_min_2 = ($sisa_cur_min_1+$sisa_cur_min_2);
                                                        }
                                                    }
                                                }

                                                if($sisa_cur_min_1 <0){
                                                    $sisa_cur_min_1 = 0;
                                                }

                                                $sisa_cuti_tahunan = $sisa_cur + $sisa_cur_min_1 + $sisa_cur_min_2;
                                                if($sisa_cuti_tahunan<0){
                                                    $sisa_cuti_tahunan = 0;
                                                }

                                                echo "<tr><td>Jumlah</td>";
                                                echo "<td>".$jml_lama_cuti."</td>";
                                                echo "<td>".$jml_lama_cuti_n1."</td>";
                                                echo "<td>".$jml_akumulasi_cuti."</td>";
                                                echo "<td>".$sisa_cuti_tahunan."</td>";
                                                echo "<td>".$jml_cuti_besar."</td>";
                                                echo "<td>".$jml_akumulasi_cuti_sakit_umum."</td>";
                                                echo "<td>".$jml_akumulasi_cuti_keguguran."</td>";
                                                echo "<td>".$jml_akumulasi_cuti_kecelakaan."</td>";
                                                echo "<td>".$jml_cuti_bersalin."</td>";
                                                echo "<td>".$jml_cuti_alasan_penting."</td>";
                                                echo "<td>".$jml_cuti_alasan_penting_n1."</td>";
                                                echo "<td>".$jml_akumulasi_cuti_alasan_penting."</td>";
                                                echo "<td>".$jml_cuti_cltn."</td>";
                                                echo "</tr>";

                                                echo "</table></div>";

                                                echo "Keterangan :<br>
                                                    a) Lama Cuti Tahun Berjalan (n),
                                                    b) Lama Cuti Tahun Berikutnya (n+1),
                                                    c) Akumulasi Cuti,
                                                    d) Sisa Cuti,
                                                    e) Umum,
                                                    f) Keguguran Kandungan,
                                                    g) Kecelakaan Kerja";
                                            }else{
                                                echo "Tidak ada data rekapitulasi";
                                            }

                                            echo "<br><strong>Detail sisa cuti tahunan ($sisa_cuti_tahunan hari)</strong> :<br>";
                                            echo (date("Y")-2).' : '.($sisa_cur_min_2<0?0:(($sisa_cur_min_1_ori+$sisa_cur_min_2)<0?0:(($sisa_cur+$sisa_cur_min_2)<0?0:$sisa_cur+$sisa_cur_min_2))).' hari <br>';
                                            echo (date("Y")-1).' : '.($sisa_cur_min_1_ori<0?0:(($sisa_cur+$sisa_cur_min_2+$sisa_cur_min_1_ori)<0?0:(($sisa_cur+$sisa_cur_min_2+$sisa_cur_min_1)>$sisa_cur_min_1?($sisa_cur_min_1_ori<0?0:$sisa_cur_min_1):(($sisa_cur+$sisa_cur_min_2+$sisa_cur_min_1)<0?0:($sisa_cur+$sisa_cur_min_2+$sisa_cur_min_1))))).' hari <br>';
                                            echo (date("Y")).' : '.($sisa_cur<0?0:$sisa_cur).' hari<br>';

                                            $sqlPenangguhan = "SELECT cp.*,  NOW() as tgl_skrg,
                                                                    CASE WHEN  NOW() <= cp.tgl_akhir_penangguhan THEN 0 ELSE 1 END as status_cuti,
                                                                    DATE_FORMAT(cp.tgl_mulai_penangguhan, '%d/%m/%Y') as tgl_mulai,
                                                                    DATE_FORMAT(cp.tgl_akhir_penangguhan, '%d/%m/%Y') as tgl_selesai
                                                                    FROM cuti_penangguhan cp WHERE cp.id_cuti_master =
                                                                    (SELECT MAX(cp.id_cuti_master) as id_cuti_master FROM cuti_penangguhan cp, cuti_master c
                                                                    WHERE cp.id_cuti_master = c.id_cuti_master AND  c.id_pegawai = ".$_SESSION['id_pegawai'].")";
                                            $rsP = $mysqli->query($sqlPenangguhan);
                                            $jmlP=$rsP->num_rows;
                                            if($jmlP>0){
                                                while ($otoP = $rsP->fetch_array(MYSQLI_BOTH)) {
                                                    $tglMulaiPenangguhan = $otoP['tgl_mulai'];
                                                    $tglSelesaiPenangguhan = $otoP['tgl_selesai'];
                                                    $lamaPenangguhan = $otoP['lama_penangguhan'];
                                                    $stsCuti = $otoP['status_cuti'];
                                                }
                                                if($stsCuti==0){
                                                    echo "<div id='spnInfo' style='color: red; font-weight: bold; padding: 3px; width: 100%; padding-left:0px;text-align: left;'>
                                                        Masih dalam masa penangguhan cuti : selama ".$lamaPenangguhan." hari (Dari ".$tglMulaiPenangguhan." s.d. ".$tglSelesaiPenangguhan.")</div>";
                                                    $canCuti = 0;
                                                }else{
                                                    $canCuti = 1;
                                                }
                                            }else{
                                                $canCuti = 1;
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="30%">
                                            Pilih Jenis Cuti
                                            <input id="last_gol" name="last_gol" type="hidden" value="<?php echo $data['pangkat_gol'] ?>" />
                                            <input id="last_jenjab" name="last_jenjab" type="hidden" value="<?php echo $data['jenjab'] ?>" />
                                            <input id="last_jabatan" name="last_jabatan" type="hidden" value="<?php echo (($data['is_kepsek']==0 and $data['is_kapus']==0)?$data['jabatan']:($data['is_kepsek']==1?$data['jabatan'].' sebagai Kepala Sekolah':($data['is_kapus']==1?$data['jabatan'].' sebagai Kepala Puskesmas':$data['jabatan']))); ?>" />
                                            <input id="last_masa_kerja" name="last_masa_kerja" type="hidden" value="<?php echo $data['masa_kerja'] ?>" />
                                            <input id="last_masa_kerja_text" name="last_masa_kerja_text" type="hidden" value="<?php echo($masa_kerja->mk_tahun.' Tahun '.$masa_kerja->mk_bulan.' Bulan'); ?>" />
                                            <input id="last_id_unit_kerja" name="last_id_unit_kerja" type="hidden" value="<?php echo $data['id_unit_kerja_me'] ?>" />
                                            <input id="last_unit_kerja" name="last_unit_kerja" type="hidden" value="<?php echo $data['unit_kerja_me'] ?>" />
                                            <input id="last_atsl_nip" name="last_atsl_nip" type="hidden" value="<?php echo $data['nip_baru_atsl'] ?>" />
                                            <input id="last_atsl_nama" name="last_atsl_nama" type="hidden" value="<?php echo $data['nama_atsl'] ?>" />
                                            <input id="last_atsl_gol" name="last_atsl_gol" type="hidden" value="<?php echo $data['gol_atsl'] ?>" />
                                            <input id="last_atsl_jabatan" name="last_atsl_jabatan" type="hidden" value="<?php echo $data['jabatan_atsl'] ?>" />
                                            <input id="last_pjbt_nip" name="last_pjbt_nip" type="hidden" value="<?php echo $data['nip_baru_pjbt'] ?>" />
                                            <input id="last_pjbt_nama" name="last_pjbt_nama" type="hidden" value="<?php echo $data['nama_pjbt'] ?>" />
                                            <input id="last_pjbt_gol" name="last_pjbt_gol" type="hidden" value="<?php echo $data['gol_pjbt'] ?>" />
                                            <input id="last_pjbt_jabatan" name="last_pjbt_jabatan" type="hidden" value="<?php echo $data['jabatan_pjbt']; ?>" />
                                            <input id="flag_uk_atasan_sama" name="flag_uk_atasan_sama" type="hidden" value="<?php echo $flag_uk_atasan_sama; ?>" />
                                            <input id="issubmit" name="issubmit" type="hidden" value="true" />
                                        </td>
                                        <td width="70%">
                                            <select id="cboIdJnsCuti" name="cboIdJnsCuti" size="6" style="width:100%; max-width: 350px;"
                                                <?php if($aktif==2) echo(" readonly=readonly"); ?>>
                                                <?php
                                                for($x = 0; $x < $array_data_length; $x++) {
                                                    echo "<option value='".$array_data[$x]['id_jenis_cuti']."' ";
                                                    if($array_data[$x]['id_jenis_cuti']==$idjenis_cuti) echo 'selected';
                                                    echo ">".$array_data[$x]['deskripsi']."</option>";
                                                }
                                                ?>
                                            </select><input id="txtIdJnsCuti" name="txtIdJnsCuti" type="hidden"/>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Detail Informasi Cuti</td>
                                        <td>
                                            <?php
                                            $sql = "SELECT * FROM cuti_jenis WHERE id_jenis_cuti = '".$idjeniscutinya."'"; //$idjeniscutinya
                                            $query = mysqli_query($mysqli,$sql);
                                            $array_data = array();
                                            while ($row = mysqli_fetch_array($query)) {
                                                $array_data[] = $row;
                                            }
                                            $desk = $array_data[0]['deskripsi'];
                                            $masa_kerja_min = $array_data[0]['masa_kerja_min'];
                                            $kuota_min_hari = $array_data[0]['kuota_min_hari'];
                                            $kuota_max_hari = $array_data[0]['kuota_max_hari'];
                                            $ket_kuota = $array_data[0]['ket_kuota'];
                                            $ket_lainnya = $array_data[0]['keterangan_lainnya'];
                                            ?>
                                            <div id="divInformasiCuti">
                                                <strong><?php echo $desk; ?></strong><br>
                                                Masa Kerja Minimal: <?php echo $masa_kerja_min.' Tahun';?><br>
                                                Kuota Cuti Per Tahun: <?php echo $ket_kuota;?><br> <input id="kuota_min_hari" name="kuota_min_hari" type="hidden" value="<?php echo $kuota_min_hari; ?>" />
                                                Keterangan Lain:<br><div style="margin-left: -25px;"><?php echo $ket_lainnya; ?></div>
                                                Cuti yang dapat diambil: <input id="jml_jatah_cuti" name="jml_jatah_cuti" type="hidden" value="<?php echo $sisa_cuti_tahunan; ?>" />
                                                <?php echo $sisa_cuti_tahunan; ?> Hari
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Periode</td>
                                        <td>
                                            <span class="input-control text">
                                                <input name="txtPeriode" id="txtPeriode" type="text"  value="<?php echo date("Y");?>" readonly="readonly" />
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Tgl. Pengajuan</td>
                                        <td>
                                            <span class="input-control text">
                                                <input name="txtTglPengajuan" id="txtTglPengajuan" type="text" value="<?php echo date("d-m-Y");?>" readonly="readonly" />
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Apakah untuk waktu cuti mundur?</td>
                                        <td>
                                            <input type="radio" id="rdb_cuti_mundur1"
                                                   name="rdb_cuti_mundur" value="0" <?php echo $checked1; ?>> Tidak
                                            &nbsp; &nbsp
                                            <input type="radio" id="rdb_cuti_mundur2"
                                                   name="rdb_cuti_mundur" value="1" <?php echo $checked2; ?>> Ya
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Apakah untuk kunjungan ke Luar Negeri?</td>
                                        <td>
                                            <input type="radio" id="rdb_kunjungan_luar_negeri1"
                                                   name="rdb_kunjungan_luar_negeri" value="0" <?php echo ((isset($checkedLuarNegeri1) and $checkedLuarNegeri1!='')?$checkedLuarNegeri1:''); ?>> Tidak
                                            &nbsp; &nbsp
                                            <input type="radio" id="rdb_kunjungan_luar_negeri2"
                                                   name="rdb_kunjungan_luar_negeri" value="1" <?php echo ((isset($checkedLuarNegeri2) and $checkedLuarNegeri2!='')?$checkedLuarNegeri2:''); ?>> Ya
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>TMT. Mulai</td>
                                        <td>
                                            <span class="input-control text">
                                                <input name="txtTmtMulai" id="txtTmtMulai" type="text" class="tcal"  value="<?php if ($aktif!=2) echo date("d-m-Y", strtotime(date("d-m-Y") . "+7 days"));
                                                else echo("$t3-$b3-$th3");
                                                ?>" readonly="readonly"  />
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Lama Cuti (Hari)</td>
                                        <td>
                                            <span id="sprytextfield1">
                                                <input name="txtLamaCuti" type="text" id="txtLamaCuti" onkeyup="calculateDate()" <?php if(@$aktif!=2) echo(" value=1 "); else echo(" value=$up[lama_cuti] ");  ?> maxlength="4" />
                                                <span class="textfieldRequiredMsg" style="border: 0px;">Harus diisi</span><span class="textfieldInvalidFormatMsg">Input harus angka</span>
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>TMT. Selesai</td>
                                        <td>
                                            <span class="input-control text">
                                                <input name="txtTmtSelesai" type="text" id="txtTmtSelesai" <?php if(@$aktif!=2) echo(date("d-m-Y")); else echo(" value=$t5-$b5-$th5 ");  ?> readonly="readonly" />
                                            </span>
                                        </td>
                                    </tr>
                                    <tr id="trAlamat">
                                        <td>Alamat Selama Cuti</td>
                                        <td><label for="txtAlamatCuti"></label>
                                            <span id="sprytextarea1"><textarea style="resize: none;" rows="4" cols="50" name="txtAlamatCuti" id="txtAlamatCuti"><?php if(@$aktif!=2) echo $data['alamat']; else echo $upKeterangan; ?></textarea><br>
                                                <span class="textareaRequiredMsg" style="border: 0px;">Harus diisi</span>
                                            </span>
                                        </td>
                                    </tr>
                                    <tr id="trKeteranganTambahan">
                                        <td>Keterangan Tambahan/Alasan</td>
                                        <td>
                                            <label for="txtKeteranganTambahan"></label>
                                            <span id="sprytextarea2"><textarea style="resize: none;" rows="4" cols="50" name="txtKeteranganTambahan" id="txtKeteranganTambahan"><?php if(@$aktif==2) echo $upAlasan; ?></textarea><br>
                                                <span class="textareaRequiredMsg" style="border: 0px;">Harus diisi</span>
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td>
                                            <input type="submit" name="btnSimpanCuti" id="btnSimpanCuti" class="btn btn-primary"
                                                   value="<?php if($aktif!=2) echo("Simpan"); else echo("Update Pengubahan");  ?>"/>
                                            <span style="color: red"><?php echo (($data['gol_atsl']=="" or $data['nip_baru_pjbt']=="")?"Data dasar belum lengkap":''); ?></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <strong>Keterangan</strong>
                                            <ul style="margin-left: -20px">
                                                <li>Semua jenis cuti : lama cuti tidak termasuk Cuti Bersama dan Libur Nasional</li>
                                                <li>Cuti tahunan : lama cuti tidak termasuk Hari Sabtu dan Minggu</li>
                                                <li>Selain cuti tahunan : jika lama cuti kurang dari 60 hari (2 bulan) maka hari sabtu dan minggu tidak masuk.
                                                    Sebaliknya, jika sama dengan atau lebih dari 60 hari maka hari sabtu dan minggu termasuk</li>
                                                <li>Bagi kantor dengan jumlah hari kerja 6 hari maka hari sabtu masuk dalam jumlah lama cuti</li>
                                                <li>TMT.Mulai cuti berlaku minimal setelah satu minggu (7 hari kalender) dari tanggal pengajuan,
                                                    kecuali cuti karena alasan penting dan cuti bersalin bisa 1 hari sebelumnya.</li>
                                                <li>Segera upload berkas usulan yang sudah ditandatangani atasan dan cek kembali berkas yang sudah terupload.
                                                    Ukuran file maksimal 2 MB </li>
                                                <li><span style="color: blue">Semua Cuti saat ini dapat dilakukan sehari sebelumnya</span></li>
                                            </ul>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                            <td style="border-left: 1px solid lightgrey;width: 40%;">
                                <?php
                                    $sql_cuti_libur = "SELECT DATE_FORMAT(cb.tanggal,  '%d/%m/%Y') AS tanggal, hari, ket
                                            FROM cuti_bersama cb
                                            WHERE YEAR(cb.tanggal) = YEAR(NOW())";
                                    $query_row = mysqli_query($mysqli, $sql_cuti_libur);
                                ?>
                                <strong>Cuti Bersama</strong>
                                <table class="table">
                                    <tr>
                                        <td>No</td>
                                        <td>Tanggal</td>
                                        <td>Hari</td>
                                        <td>Keterangan</td>
                                    </tr>
                                    <?php
                                    $arrCB = array();
                                    $i = 0;
                                    while($row = mysqli_fetch_array($query_row)){
                                        $arrCB[$i] = $row['tanggal'];
                                        ?>
                                        <tr>
                                            <td><?php echo $i+1; ?></td>
                                            <td><?php echo $row['tanggal'] ?></td>
                                            <td><?php echo $row['hari'] ?></td>
                                            <td><?php echo $row['ket'] ?></td>
                                        </tr>
                                        <?php
                                        $i++;
                                    }
                                    ?>
                                </table>
                                <script type="text/javascript">
                                    var jArrayCB = <?php echo json_encode($arrCB ); ?>;
                                </script>
                                <?php
                                $sql_cuti_libur = "SELECT DATE_FORMAT(cb.tanggal,  '%d/%m/%Y') AS tanggal, hari, ket
                                            FROM libur_nasional cb
                                            WHERE YEAR(cb.tanggal) = YEAR(NOW()) OR YEAR(cb.tanggal) = YEAR(NOW())+1";
                                $query_row = mysqli_query($mysqli, $sql_cuti_libur);
                                ?>
                                <strong>Libur Nasional</strong>
                                <table class="table">
                                    <tr>
                                        <td>Tanggal</td>
                                        <td>Hari</td>
                                        <td>Keterangan</td>
                                    </tr>
                                    <?php
                                    $arrLN = array();
                                    $i = 0;
                                    while($row = mysqli_fetch_array($query_row)){
                                        $arrLN[$i] = $row['tanggal'];
                                        ?>
                                        <tr>
                                            <td><?php echo $row['tanggal'] ?></td>
                                            <td><?php echo $row['hari'] ?></td>
                                            <td><?php echo $row['ket'] ?></td>
                                        </tr>
                                        <?php
                                        $i++;
                                    }
                                    ?>
                                </table>
                                <script type="text/javascript">
                                    var jArrayLN = <?php echo json_encode($arrLN ); ?>;
                                    //for(var i=0;i < <? //echo $i; ?> ;i++){
                                    //alert(jArrayLN[i]);
                                    //}
                                </script>
                            </td>
                        </tr>
                    </table>
                </fieldset>
            </form>
        </div>
        <div role="tabpanel" class="tab-pane <?php echo(($issubmit == 'true' or $ubahstatus == 'true') ? "active" : ''); ?>" id="list_cuti">
            <div style="margin-top: 10px; margin-bottom: 10px; font-style: italic;color: #0A246A;">
                Jika pegawai yang mengajukan cuti memiliki perbedaan lokasi unit kerja antara atasan langsung dengan atasan dari atasan langsung (pejabat berwenang) maka
                operator pengelola ada di OPD namun jika sebaliknya (sama) maka operator pengelola langsung ada di BKPP.
                Keterangan lebih lanjut hubungi Admin SIMPEG di OPD/BKPP.</div>
            <div class="row" style="margin-top: 10px;">
                <div class="col-md-2">
                    <input type="text" class="form-control" id="txtKataKunci" name="txtKataKunci" placeholder="Kata Kunci">
                </div>
                <div class="col-md-3" style="margin-left: -15px;">
                    <select class="form-control" id="ddJenisCuti">
                        <option value="0">Semua Jenis Cuti</option>
                        <?php
                        $sql = "SELECT * FROM cuti_jenis";
                        $query2 = $mysqli->query($sql);
                        while ($oto = $query2->fetch_array(MYSQLI_NUM)) {
                            echo("<option value='$oto[0]'>$oto[1]</option>");
                        }
                        ?>
                    </select>
                </div>
                <div class="col-md-3" style="margin-left: -15px;">
                    <select class="form-control" id="ddStatusCuti">
                        <option value="0">Semua Status Cuti</option>
                        <?php
                        $sql = "SELECT * FROM ref_status_cuti rsc
                                    WHERE label IS NOT NULL
                                    ORDER BY label ASC";
                        $query2 = $mysqli->query($sql);
                        while ($oto = $query2->fetch_array(MYSQLI_NUM)) {
                            echo("<option value=$oto[0]>$oto[1]</option>");
                        }
                        ?>
                    </select>
                </div>
                <div class="col-md-2" style="margin-left: -15px;">
                    <button type="button" class="btn btn-primary" id="btn_tampilkan" name="btn_tampilkan">Tampilkan</button>
                </div>
            </div><br>
            <div style="margin-top: -15px;margin-bottom: -15px;">
                <span style="font-size: small;">Kata Kunci : Nama Pegawai, NIP, Nama Atasan, Nama Pejabat, Alasan Cuti</span>
            </div><br>
            <div class="row">
                <div id="loader" class="loader"></div>
                <div id="divListUsulanCuti"></div>
            </div>
        </div>
        <div role="tabpanel" class="tab-pane" id="rekap">
            <div role="tabpanel" style="margin-top: 10px;">
                <ul class="nav nav-tabs" role="tablist" id="myTab2">
                    <li role="presentation" class="active" ><a href="#rekap_tahunan" aria-controls="rekap_tahunan" role="tab" data-toggle="tab">Rekapitulasi Tahunan</a></li>
                    <li role="presentation"><a href="#rekap_bulanan" aria-controls="rekap_bulanan" role="tab" data-toggle="tab">Rekapitulasi Bulanan</a></li>
                </ul>
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="rekap_tahunan">
                        <div style="font-weight: bold;margin-top: 10px; margin-bottom: 10px;">Rekapitulasi pada OPD</div>
                        <div class="row">
                            <div class="col-sm-1" style="text-align: right">Tahun</div>
                            <div class="col-sm-2">
                                <?php $listThn = $oCuti->listTahun(); ?>
                                <select id="ddTahun" class="form-control">
                                    <?php
                                    $i = 0;
                                    for ($x = 0; $x < sizeof($listThn); $x++) {
                                        if($listThn[$i]==date("Y")){
                                            echo "<option value=".$listThn[$i]." selected>".$listThn[$i]."</option>";
                                        }else{
                                            echo "<option value=".$listThn[$i].">".$listThn[$i]."</option>";
                                        }
                                        $i++;
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-sm-2">
                                <button id="btnRekapCutiPerOpd" type="button"
                                        class="btn btn-primary" style="margin-left: 0px;" onclick="viewRekapCutiPerOPD()">
                                    &nbsp;&nbsp;<span class="glyphicon glyphicon-search"></span> Tampilkan &nbsp;&nbsp;</button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-11">
                                <div id="divRekapCuti" style="margin-left: 15px;margin-top: 20px;"></div>
                            </div>
                        </div>
                        <div style="font-weight: bold;margin-top: 10px; margin-bottom: 10px;">Rekapitulasi Semua OPD</div>
                        <div class="row">
                            <div class="col-sm-1" style="text-align: right">Tahun</div>
                            <div class="col-sm-2">
                                <?php $listThn = $oCuti->listTahun(); ?>
                                <select id="ddTahun2" class="form-control">
                                    <?php
                                    $i = 0;
                                    for ($x = 0; $x < sizeof($listThn); $x++) {
                                        if($listThn[$i]==date("Y")){
                                            echo "<option value=".$listThn[$i]." selected>".$listThn[$i]."</option>";
                                        }else{
                                            echo "<option value=".$listThn[$i].">".$listThn[$i]."</option>";
                                        }
                                        $i++;
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-sm-3">
                                <select class="form-control" id="ddStatusCuti2">
                                    <option value="0">Semua Status Cuti</option>
                                    <?php
                                    $sql = "SELECT * FROM ref_status_cuti rsc
                                    WHERE label IS NOT NULL
                                    ORDER BY label ASC";
                                    $query2 = $mysqli->query($sql);
                                    while ($oto = $query2->fetch_array(MYSQLI_NUM)) {
                                        echo("<option value=$oto[0]>$oto[1]</option>");
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-sm-2">
                                <button id="btnRekapCutiAllOpd" type="button"
                                        class="btn btn-primary" style="margin-left: 0px;" onclick="viewRekapCutiAllOPD()">
                                    &nbsp;&nbsp;<span class="glyphicon glyphicon-search"></span> Tampilkan &nbsp;&nbsp;</button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-11">
                                <div id="divRekapCutiAllOpd" style="margin-left: 15px;margin-top: 20px;"></div>
                            </div>
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="rekap_bulanan">
                        <br>
                        <div class="row">
                            <div class="col-sm-1" style="text-align: right">Tahun</div>
                            <div class="col-sm-2">
                                <select id="ddTahun3" class="form-control">
                                    <?php
                                    $i = 0;
                                    for ($x = 0; $x < sizeof($listThn); $x++) {
                                        if($listThn[$i]==date("Y")){
                                            echo "<option value=".$listThn[$i]." selected>".$listThn[$i]."</option>";
                                        }else{
                                            echo "<option value=".$listThn[$i].">".$listThn[$i]."</option>";
                                        }
                                        $i++;
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="col-sm-3">
                                <select class="form-control" id="ddStatusCuti3">
                                    <option value="0">Semua Status Cuti</option>
                                    <?php
                                    $sql = "SELECT * FROM ref_status_cuti rsc
                                    WHERE label IS NOT NULL
                                    ORDER BY label ASC";
                                    $query2 = $mysqli->query($sql);
                                    while ($oto = $query2->fetch_array(MYSQLI_NUM)) {
                                        echo("<option value=$oto[0]>$oto[1]</option>");
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="col-sm-2">
                                <select class="form-control" id="ddOpd">
                                    <option value="0">Semua OPD</option>
                                    <?php
                                    $sql = "SELECT uk.id_unit_kerja, uk.nama_baru as opd 
                                            FROM unit_kerja uk 
                                            WHERE uk.id_unit_kerja = uk.id_skpd AND uk.tahun = (SELECT MAX(tahun) FROM unit_kerja) 
                                            ORDER BY uk.nama_baru ASC";
                                    $query2 = $mysqli->query($sql);
                                    while ($oto = $query2->fetch_array(MYSQLI_NUM)) {
                                        echo("<option value=$oto[0]>$oto[1]</option>");
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="col-sm-2">
                                <button id="btnRekapCutiBulanan" type="button"
                                        class="btn btn-primary" style="margin-left: 0px;" onclick="viewRekapCutiBulanan()">
                                    &nbsp;&nbsp;<span class="glyphicon glyphicon-search"></span> Tampilkan &nbsp;&nbsp;</button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-11">
                                <div id="divRekapBulanan" style="margin-left: 15px;margin-top: 20px;"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<!-- The jQuery UI widget factory, can be omitted if jQuery UI is already included -->
<script src="assets/js/vendor/jquery.ui.widget.js"></script>
<!-- The Iframe Transport is required for browsers without support for XHR file uploads -->
<script src="assets/js/jquery.iframe-transport.js"></script>
<!-- The basic File Upload plugin -->
<script src="assets/js/jquery.fileupload.js"></script>
<!-- Bootstrap JS is not required, but included for the responsive demo navigation -->
<!--script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script-->
<script src="js/moment.js"></script>
<script src="js/bootstrapValidator.js"></script>

<script type="text/javascript">
    $("#cboIdJnsCuti").click(function() {
        var idJnsCuti = ($("#cboIdJnsCuti").val());
        $("#divInformasiCuti").css("pointer-events", "none");
        $("#divInformasiCuti").css("opacity", "0.4");
        $("#btnSimpanCuti").css("pointer-events", "none");
        $("#btnSimpanCuti").css("opacity", "0.4");
        $("#cboIdJnsCuti").css("pointer-events", "none");
        $("#cboIdJnsCuti").css("opacity", "0.4");
        $.ajax({
            type: "GET",
            url: "/simpeg/cuti_get_detail_info.php?idJnsCuti="+idJnsCuti+"&nip=<?php echo $nip;?>",
            success: function (data) {
                $("#divInformasiCuti").html(data);
                $("#divInformasiCuti").css("pointer-events", "auto");
                $("#divInformasiCuti").css("opacity", "1");
                $("#btnSimpanCuti").css("pointer-events", "auto");
                $("#btnSimpanCuti").css("opacity", "1");
                $("#cboIdJnsCuti").css("pointer-events", "auto");
                $("#cboIdJnsCuti").css("opacity", "1");
                var $form = $('form[name="frmCuti"]');
                $form.bootstrapValidator('disableSubmitButtons', false);
            }
        });
    });

    $('input[type=radio][name=rdb_cuti_mundur]').change(function () {
        if (this.value == 0) {
            Date.prototype.addDays = function (days) {
                var dat = new Date(this.valueOf());
                dat.setDate(dat.getDate() + days);
                return dat;
            }
            var today = new Date();
            today = today.addDays(7);
            var dd = today.getDate();
            var mm = today.getMonth()+1; //January is 0!
            var yyyy = today.getFullYear();
            if(dd<10) {
                dd = '0'+dd
            }
            if(mm<10) {
                mm = '0'+mm
            }
            today = dd + '-' + mm + '-' + yyyy;
            $('#txtTmtMulai').val(today);
        }
    });

    $("#frmCuti").bootstrapValidator({

        message: "This value is not valid",
        excluded: ':disabled',
        feedbackIcons: {
            valid: "glyphicon glyphicon-ok",
            invalid: "glyphicon glyphicon-remove",
            validating: "glyphicon glyphicon-refresh"
        },
        fields: {
            last_atsl_nip: {
                feedbackIcons: "false",
                validators: {notEmpty: {message: "NIP atasan tidak boleh kosong"}}
            },
            last_pjbt_nip: {
                feedbackIcons: "false",
                validators: {notEmpty: {message: "NIP pejabat tidak boleh kosong"}}
            },
            txtTmtMulai: {
                feedbackIcons: "false",
                validators: {
                    notEmpty: {
                        message: 'TMT. Mulai tidak boleh kosong'
                    },
                    date: {
                        format: 'DD-MM-YYYY',
                        message: 'Format TMT. Mulai DD-MM-YYYY'
                    },
                    callback: {
                        message: 'TMT. Mulai harus lebih dari Tgl.Pengajuan',
                        callback: function (value, validator) {
                            var awal = document.getElementById('txtTmtMulai').value;
                            var startDateN = new Date(awal.substr(3, 2) + "/" + awal.substr(0, 2) + "/" + awal.substr(6, 4));
                            Date.prototype.addDays = function (days) {
                                var dat = new Date(this.valueOf());
                                dat.setDate(dat.getDate() + days);
                                return dat;
                            }
                            var now = new Date();
                            var xy = 0;
                            var idJnsCuti2 = ($("#cboIdJnsCuti").val());
                            if (idJnsCuti2 == 'C_ALASAN_PENTING' || idJnsCuti2 == 'C_BERSALIN') {
                                xy = 0;
                            } else {
                                xy = 0; //5
                            }
                            var isCutiMundur = $('input[name=rdb_cuti_mundur]:checked', '#frmCuti').val();
                            if (startDateN <= now.addDays(xy)) {
                                if(isCutiMundur ==1 /*idJnsCuti2 == 'C_ALASAN_PENTING' || idJnsCuti2 == 'C_TAHUNAN'*/){
                                    return true;
                                }else{
                                    return false;
                                }
                            } else {
                                return true;
                            }
                        }
                    }
                }
            },
            txtLamaCuti: {
                feedbackIcons: "false",
                validators: {
                    integer: {
                        message: 'Nilai lama cuti bukan integer'
                    },
                    between: {
                        min: 1,
                        max: 1095,
                        message: 'Lama cuti tidak valid'
                    },
                    notEmpty: {
                        message: "Lama cuti tidak boleh kosong"
                    }
                }
            },
            'txtAlamatCuti': {
                feedbackIcons: "false",
                validators: {notEmpty: {message: "Alamat tidak boleh kosong"}}
            },
            'txtKeteranganTambahan': {
                feedbackIcons: "false",
                validators: {notEmpty: {message: "Keterangan Tambahan/Alasan tidak boleh kosong"}}
            }
        }
    }).on("error.field.bv", function (b, a) {
        a.element.data("bv.messages").find('.help-block[data-bv-for="' + a.field + '"]').hide();
    }).on('success.form.bv', function (e) {
        var lama_cuti = document.getElementById('txtLamaCuti').value;
        var jml_jatah_cuti = document.getElementById('jml_jatah_cuti').value;
        var stsValid = true;
        var canCuti = <?php echo $canCuti; ?>;
        if (parseInt(jml_jatah_cuti) >= -1) {
            if (parseInt(jml_jatah_cuti) == -1) { //Tidak ada kuota maksimum
                stsValid = true;
                //return true;
            } else {
                if (parseInt(lama_cuti) > parseInt(jml_jatah_cuti)) {
                    alert('Jumlah lama cuti tidak boleh melebihi jumlah cuti yang dapat diambil');
                    var $form = $(e.target);
                    $form.bootstrapValidator('disableSubmitButtons', false);
                    stsValid = false;
                    //return false;
                } else {
                    var kuota_min_hari = document.getElementById('kuota_min_hari').value;
                    if (parseInt(lama_cuti) < parseInt(kuota_min_hari)) {
                        alert('Jumlah lama cuti harus lebih dari jumlah minimal');
                        var $form = $(e.target);
                        $form.bootstrapValidator('disableSubmitButtons', false);
                        stsValid = false;
                        //return false;
                    } else {
                        stsValid = true;
                        //return true;
                    }
                }
            }
        } else {
            if (parseInt(jml_jatah_cuti) == -2) {
                alert('Pengajuan Cuti terakhir anda bukan cuti sakit baru');
                var $form = $(e.target);
                $form.bootstrapValidator('disableSubmitButtons', false);
                stsValid = false;
                //return false;
            } else if (parseInt(jml_jatah_cuti) == -3) {
                alert('Pengajuan Cuti Sakit terakhir anda belum Disetujui BKPP');
                var $form = $(e.target);
                $form.bootstrapValidator('disableSubmitButtons', false);
                stsValid = false;
                //return false;
            } else {
                stsValid = true;
                //return true;
            }
        }
        console.log(<?php echo $canCuti; ?>);
        if(stsValid==true){
            if(canCuti==1){
                e.preventDefault();
                var $form = $(e.target);
                fv = $form.data('bootstrapValidator');
                $.confirm({
                    title: 'Informasi',
                    content: 'Anda yakin akan menyimpan permohonan ini?',
                    buttons: {
                        cancel: {
                            text: 'Tidak',
                            action: function () {
                                return true;
                            }
                        },
                        somethingElse: {
                            text: 'Ya',
                            btnClass: 'btn-blue',
                            keys: ['enter', 'shift'],
                            action: function () {
                                fv.defaultSubmit();
                            }
                        }
                    }
                });
            }else{
                alert('Masih dalam masa penangguhan cuti');
                return false;
            }
        }else{
            return false;
        }

    });
    var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "integer", {validateOn:["change"]});
    var sprytextarea1 = new Spry.Widget.ValidationTextarea("sprytextarea1", {validateOn:["blur", "change"]});
    var sprytextarea2 = new Spry.Widget.ValidationTextarea("sprytextarea2", {validateOn:["blur", "change"]});
</script>

<script type="text/javascript">
    $(document).ready(function(){
        document.getElementById("loader").style.display = "none";
        loadDefaultDataUsulanCuti();
    });

    function loadDefaultDataUsulanCuti(){
        loadDataUsulanCuti('',0,0);
    }

    function loadDataUsulanCuti(keywordCari, jenis, status, page, ipp){
        $("#btn_tampilkan").css("pointer-events", "none");
        $("#btn_tampilkan").css("opacity", "0.4");
        $("#divListUsulanCuti").css("pointer-events", "none");
        $("#divListUsulanCuti").css("opacity", "0.4");
        document.getElementById("loader").style.display = "block";

        $.ajax({
            type: "POST",
            dataType: "html",
            url: "cuti_drop_data_list.php",
            data: {
                txtKeyword: keywordCari,
                idp: <?php echo $_SESSION['id_pegawai']; ?>,
                jenis: jenis,
                status: status,
                page: page,
                ipp: ipp,
                tbl: ''}
        }).done(function(data){
            $("#divListUsulanCuti").html(data);
            $("#btn_tampilkan").css("pointer-events", "auto");
            $("#btn_tampilkan").css("opacity", "1");
            $("#divListUsulanCuti").css("pointer-events", "auto");
            $("#divListUsulanCuti").css("opacity", "1");
            document.getElementById("loader").style.display = "none";
        });

    }

    $("#btn_tampilkan").click(function(){
        var keywordCari = $("#txtKataKunci").val();
        var jenis = $('#ddJenisCuti').val();
        var status = $('#ddStatusCuti').val();
        loadDataUsulanCuti(keywordCari, jenis, status, '', '');
    });

    function pagingViewListLoad(parm,parm2,parm3){
        var keywordCari = $("#txtKataKunci").val();
        var jenis = $('#ddJenisCuti').val();
        var status = $('#ddStatusCuti').val();
        loadDataUsulanCuti(keywordCari, jenis, status, parm, parm2);
    }

    $(function () {
        viewRekapCutiPerOPD();
        viewRekapCutiAllOPD();
        viewRekapCutiBulanan();
    });

    function viewRekapCutiPerOPD(){
        $("#btnRekapCutiPerOpd").css("pointer-events", "none");
        $("#btnRekapCutiPerOpd").css("opacity", "0.4");
        $("#divRekapCuti").css("pointer-events", "none");
        $("#divRekapCuti").css("opacity", "0.4");
        var thn = $("#ddTahun").val();

        $.ajax({
            type: "POST",
            dataType: "html",
            url: "cuti_rekap_per_opd.php",
            data: {thn: thn}
        }).done(function(data){
            $("#divRekapCuti").html(data);
            $("#divRekapCuti").find("script").each(function(i) {
                //eval($(this).text());
            });
            $("#btnRekapCutiPerOpd").css("pointer-events", "auto");
            $("#btnRekapCutiPerOpd").css("opacity", "1");
            $("#divRekapCuti").css("pointer-events", "auto");
            $("#divRekapCuti").css("opacity", "1");
        });
    }

    function viewRekapCutiAllOPD(){
        $("#btnRekapCutiAllOpd").css("pointer-events", "none");
        $("#btnRekapCutiAllOpd").css("opacity", "0.4");
        $("#divRekapCutiAllOpd").css("pointer-events", "none");
        $("#divRekapCutiAllOpd").css("opacity", "0.4");
        var thn = $("#ddTahun2").val();
        var idstatus = $("#ddStatusCuti2").val();
        $.ajax({
            type: "POST",
            dataType: "html",
            url: "cuti_rekap_all_opd.php",
            data: {thn: thn, idstatus: idstatus}
        }).done(function(data){
            $("#divRekapCutiAllOpd").html(data);
            $("#divRekapCutiAllOpd").find("script").each(function(i) {
                //eval($(this).text());
            });
            $("#btnRekapCutiAllOpd").css("pointer-events", "auto");
            $("#btnRekapCutiAllOpd").css("opacity", "1");
            $("#divRekapCutiAllOpd").css("pointer-events", "auto");
            $("#divRekapCutiAllOpd").css("opacity", "1");
        });
    }

    function viewRekapCutiBulanan(){
        $("#btnRekapCutiBulanan").css("pointer-events", "none");
        $("#btnRekapCutiBulanan").css("opacity", "0.4");
        $("#divRekapBulanan").css("pointer-events", "none");
        $("#divRekapBulanan").css("opacity", "0.4");
        var thn = $("#ddTahun3").val();
        var idstatus = $("#ddStatusCuti3").val();
        var idopd = $("#ddOpd").val();
        $.ajax({
            type: "POST",
            dataType: "html",
            url: "cuti_rekap_bulanan.php",
            data: {thn: thn, idstatus: idstatus, idopd: idopd}
        }).done(function(data){
            $("#divRekapBulanan").html(data);
            $("#divRekapBulanan").find("script").each(function(i) {
                //eval($(this).text());
            });
            $("#btnRekapCutiBulanan").css("pointer-events", "auto");
            $("#btnRekapCutiBulanan").css("opacity", "1");
            $("#divRekapBulanan").css("pointer-events", "auto");
            $("#divRekapBulanan").css("opacity", "1");
        });
    }

</script>
