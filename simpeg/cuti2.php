<?php
session_start();
extract($_POST);
extract($_GET);

if($aktif==2)
{
    $sql = "SELECT cm.*, cs.*, cp.*
            FROM cuti_master cm
            LEFT JOIN cuti_sakit cs ON cm.id_cuti_master = cs.id_cuti_master
            LEFT JOIN cuti_persalinan cp ON cm.id_cuti_master = cp.id_cuti_master
            WHERE cm.id_cuti_master = $idcm";

    $qup=mysqli_query($mysqli,$sql);
    $up=mysqli_fetch_array($qup);

    $t3=substr($up['tmt_awal'],8,2);
    $b3=substr($up['tmt_awal'],5,2);
    $th3=substr($up['tmt_awal'],0,4);

    $t5=substr($up['tmt_akhir'],8,2);
    $b5=substr($up['tmt_akhir'],5,2);
    $th5=substr($up['tmt_akhir'],0,4);

    if($up['id_jenis_cuti']=='C_ALASAN_PENTING' or $up['id_jenis_cuti']=='C_BESAR'){
        $upKeterangan = substr($up['keterangan'],0,strpos($up['keterangan'],'Dengan Alasan')-2);
        $upAlasan = substr($up['keterangan'],strpos($up['keterangan'],'Dengan Alasan')+14,strlen($up['keterangan']));
    }else{
        $upKeterangan = $up['keterangan'];
    }
    $idjeniscutinya = $up['id_jenis_cuti'];
    if($up['is_cuti_mundur']==1){
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
}

include("konek.php");

$sql_cek_unit = "SELECT a.*, uk.nama_baru as opd,
                IF(uk.nama_baru LIKE '%Sekretariat Daerah%',0,
                IF((uk.nama_baru LIKE '%Dinas Kesehatan%' OR uk.nama_baru LIKE '%Dinas Pendidikan%'),IF(a.id_unit_kerja=a.id_skpd,0,1),0)) AS cek_unit FROM
                (SELECT clk.id_unit_kerja, uk.id_skpd, p.nama, uk.nama_baru AS unit
                FROM pegawai p, current_lokasi_kerja clk, unit_kerja uk
                WHERE p.id_pegawai = clk.id_pegawai AND p.flag_pensiun = 0 AND clk.id_unit_kerja = uk.id_unit_kerja
                AND p.id_pegawai = ".$_SESSION[id_pegawai]."
                GROUP BY clk.id_unit_kerja, uk.id_skpd) a, unit_kerja uk
                WHERE a.id_skpd = uk.id_unit_kerja";

$qrCekUnit = mysqli_query($mysqli,$sql_cek_unit);
$dataCekUnit = mysqli_fetch_array($qrCekUnit);

$sql_data = "SELECT cuti_peg.*, jp.id_pegawai as idp_plt_pjbt FROM
              (SELECT cuti_p.*, jp.id_pegawai as idp_plt_atsl FROM
                (SELECT me_atsl_pjbt_a.*, clk.id_unit_kerja as id_unit_kerja_pjbt, uk.id_skpd
                FROM(
                SELECT me_atsl_pjbt.*, clk.id_unit_kerja as id_unit_kerja_atsl
                FROM
                (SELECT me_atsl.*, CASE WHEN p.id_pegawai IS NULL = 1 THEN 0 ELSE p.id_pegawai END as id_pegawai_pjbt,
                p.nip_baru as nip_baru_pjbt, CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
                p.nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(', ',p.gelar_belakang) END) AS nama_pjbt, p.pangkat_gol AS gol_pjbt,
                CASE WHEN p.jenjab = 'Fungsional' THEN p.jabatan ELSE CASE WHEN p.id_j IS NULL THEN CASE WHEN (me_atsl.id_bos_pjbt = 0 OR p.id_pegawai IS NULL = 1) THEN NULL ELSE 'Fungsional Umum' END ELSE j.jabatan END END AS jabatan_pjbt
                FROM
                (SELECT me.*, CASE WHEN p.id_pegawai IS NULL = 1 THEN 0 ELSE p.id_pegawai END as id_pegawai_atsl,
                p.nip_baru as nip_baru_atsl, CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
                p.nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(', ',p.gelar_belakang) END) AS nama_atsl, p.pangkat_gol as gol_atsl,
                CASE WHEN p.jenjab = 'Fungsional' THEN p.jabatan ELSE CASE WHEN p.id_j IS NULL THEN CASE WHEN (me.id_bos_atsl = 0 OR p.id_pegawai IS NULL = 1) THEN NULL ELSE 'Fungsional Umum' END ELSE j.jabatan END END AS jabatan_atsl,
                CASE WHEN j.id_bos IS NULL = 1 THEN 0 ELSE CASE WHEN (me.unit_kerja_me = 'RSUD Kota Bogor' AND
        me.id_bos = (SELECT j.id_j FROM jabatan j WHERE j.tahun = (SELECT MAX(tahun) FROM jabatan)
        AND j.jabatan LIKE 'Walikota Bogor%')) THEN
        (SELECT j.id_j FROM jabatan j WHERE j.tahun = (SELECT MAX(tahun) FROM jabatan)
        AND j.jabatan LIKE '%Sekretaris Daerah%') ELSE
        CASE WHEN me.id_bos IS NULL = 1 THEN j.id_bos ELSE me.id_bos END END END AS id_bos_pjbt
                FROM
                (
                SELECT a.*, clk.id_unit_kerja as id_unit_kerja_me, uk.nama_baru as unit_kerja_me, j.id_bos as id_bos
                FROM(
                SELECT p.id_pegawai, p.nip_baru, CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
                nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(', ',p.gelar_belakang) END) AS nama, p.pangkat_gol, p.jenjab,
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
                                            WHERE sk.id_pegawai = $_SESSION[id_pegawai]
                                            AND sk.id_kategori_sk = 5
                                            GROUP BY riwayat_mutasi_kerja.id_pegawai
                                            ORDER BY tmt DESC LIMIT 1) a ON rmk.id_riwayat = a.idriwayat)
                                        ELSE  id_j_bos END AS id_j_bos
                                        FROM riwayat_mutasi_kerja rmk INNER JOIN
                                        (SELECT MAX(riwayat_mutasi_kerja.id_riwayat) AS idriwayat
                                        FROM riwayat_mutasi_kerja
                                        INNER JOIN sk
                                         ON sk.id_sk = riwayat_mutasi_kerja.id_sk
                                        WHERE sk.id_pegawai = $_SESSION[id_pegawai]
                                        AND sk.id_kategori_sk = 9
                                        GROUP BY riwayat_mutasi_kerja.id_pegawai
                                        ORDER BY tmt DESC LIMIT 1) a ON rmk.id_riwayat = a.idriwayat)
                                    ELSE  id_j_bos END AS id_j_bos
                                    FROM riwayat_mutasi_kerja rmk INNER JOIN
                                    (SELECT MAX(riwayat_mutasi_kerja.id_riwayat) AS idriwayat
                                    FROM riwayat_mutasi_kerja
                                    INNER JOIN sk
                                     ON sk.id_sk = riwayat_mutasi_kerja.id_sk
                                    WHERE sk.id_pegawai = $_SESSION[id_pegawai]
                                    AND sk.id_kategori_sk = 12
                                    GROUP BY riwayat_mutasi_kerja.id_pegawai
                                    ORDER BY tmt DESC LIMIT 1) a ON rmk.id_riwayat = a.idriwayat)
                                ELSE  id_j_bos END AS id_j_bos
                                FROM riwayat_mutasi_kerja rmk INNER JOIN
                                (SELECT MAX(riwayat_mutasi_kerja.id_riwayat) AS idriwayat
                                FROM riwayat_mutasi_kerja
                                INNER JOIN sk
                                 ON sk.id_sk = riwayat_mutasi_kerja.id_sk
                                WHERE sk.id_pegawai = $_SESSION[id_pegawai]
                                AND sk.id_kategori_sk = 10
                                GROUP BY riwayat_mutasi_kerja.id_pegawai
                                ORDER BY tmt DESC LIMIT 1) a ON rmk.id_riwayat = a.idriwayat)
                            ELSE  id_j_bos END AS id_j_bos
                            FROM riwayat_mutasi_kerja rmk INNER JOIN
                            (SELECT MAX(riwayat_mutasi_kerja.id_riwayat) AS idriwayat
                            FROM riwayat_mutasi_kerja
                            INNER JOIN sk
                             ON sk.id_sk = riwayat_mutasi_kerja.id_sk
                            WHERE sk.id_pegawai = $_SESSION[id_pegawai]
                            AND sk.id_kategori_sk = 7
                            GROUP BY riwayat_mutasi_kerja.id_pegawai
                            ORDER BY tmt DESC LIMIT 1) a ON rmk.id_riwayat = a.idriwayat)
                        ELSE  id_j_bos END AS id_j_bos
                        FROM riwayat_mutasi_kerja rmk INNER JOIN
                        (SELECT MAX(riwayat_mutasi_kerja.id_riwayat) AS idriwayat
                        FROM riwayat_mutasi_kerja
                        INNER JOIN sk
                         ON sk.id_sk = riwayat_mutasi_kerja.id_sk
                        WHERE sk.id_pegawai = $_SESSION[id_pegawai]
                        AND sk.id_kategori_sk = 6
                        GROUP BY riwayat_mutasi_kerja.id_pegawai
                        ORDER BY tmt DESC LIMIT 1) a ON rmk.id_riwayat = a.idriwayat)
                    ELSE  id_j_bos END AS id_j_bos
                    FROM riwayat_mutasi_kerja rmk INNER JOIN
                    (SELECT MAX(riwayat_mutasi_kerja.id_riwayat) AS idriwayat
                    FROM riwayat_mutasi_kerja
                    INNER JOIN sk
                     ON sk.id_sk = riwayat_mutasi_kerja.id_sk
                    WHERE sk.id_pegawai = $_SESSION[id_pegawai]
                    AND sk.id_kategori_sk = 1
                    GROUP BY riwayat_mutasi_kerja.id_pegawai
                    ORDER BY tmt DESC LIMIT 1) a ON rmk.id_riwayat = a.idriwayat
                )
                ELSE j.id_bos END as id_bos_atsl,
                ROUND(DATEDIFF(CURRENT_DATE, DATE_FORMAT(STR_TO_DATE(CONCAT(SUBSTRING(p.nip_baru,9,4),'/',SUBSTRING(p.nip_baru,13,2),'/','01'),
                '%Y/%m/%d'), '%Y-%m-%d'))/365,2) AS masa_kerja, p.alamat, p.is_kepsek, p.is_kapus
                FROM pegawai p LEFT JOIN jabatan j ON p.id_j = j.id_j
                WHERE p.id_pegawai = $_SESSION[id_pegawai]) AS a LEFT JOIN jabatan j ON a.id_bos_atsl = j.id_j, current_lokasi_kerja clk, unit_kerja uk 
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

//echo $sql_data;
$query = mysqli_query($mysqli,$sql_data);
$data = mysqli_fetch_array($query);

/* Cek Puskesmas */
$sql = "SELECT b.*, j.eselon, j.jabatan, j.id_j FROM
     (SELECT a.*, uk.nama_baru as opd FROM (SELECT uk.id_unit_kerja, uk.id_skpd FROM unit_kerja uk WHERE uk.id_unit_kerja = ".$data['id_unit_kerja_me'].") a 
     LEFT JOIN unit_kerja uk ON a.id_skpd = uk.id_unit_kerja) b LEFT JOIN jabatan j ON b.id_skpd = j.id_unit_kerja
     WHERE j.eselon = 'IIB'";
$qPkm = mysqli_query($mysqli,$sql);
$dataPkm = mysqli_fetch_array($qPkm);
//echo "$dataPkm[0],$dataPkm[1]";

if($dataPkm[2]=='Dinas Kesehatan Kota Bogor'){
    if($dataPkm[0]<>$dataPkm[1]){
        $sql = "SELECT p.nip_baru, CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
                nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(' ',p.gelar_belakang) END) AS nama, p.pangkat_gol
                FROM pegawai p, current_lokasi_kerja clk
                WHERE p.id_pegawai = clk.id_pegawai AND clk.id_unit_kerja = ".$data['id_unit_kerja_me']." AND p.is_kapus = true";
        $queryPkm = mysqli_query($mysqli,$sql);
        $dataPkm2 = mysqli_fetch_array($queryPkm);
        $data['nip_baru_atsl'] = $dataPkm2[0];

        if($data['nip_baru_atsl']==$data[1]){ //jika ia juga sbgai kapus

            $sql = "SELECT p.nip_baru, CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
            nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(' ',p.gelar_belakang) END) AS nama, g.golongan
            FROM pegawai p, golongan g
            WHERE  p.pangkat_gol = g.golongan AND p.id_j = ".$dataPkm[5];

            $que = mysqli_query($mysqli,$sql);
            $dataQue = mysqli_fetch_array($que);
            $data['nip_baru_atsl'] = $dataQue[0];
            $data['nama_atsl'] = $dataQue[1];
            $data['gol_atsl'] = $dataQue[2];
            $data['jabatan_atsl'] = $dataPkm[4];

            $sql = "SELECT p.nip_baru, CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
                    nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(' ',p.gelar_belakang) END) AS nama, g.golongan, j.jabatan
                    FROM pegawai p, golongan g, jabatan j
                    WHERE  p.pangkat_gol = g.golongan AND p.id_j = (SELECT id_j FROM jabatan WHERE tahun =
                    (SELECT max(tahun) FROM jabatan) and jabatan LIKE '%Sekretaris Daerah%') AND p.id_j = j.id_j";

            $que = mysqli_query($mysqli,$sql);
            $dataQue = mysqli_fetch_array($que);
            $data['nip_baru_pjbt'] = $dataQue[0];
            $data['nama_pjbt'] = $dataQue[1];
            $data['gol_pjbt'] = $dataQue[2];
            $data['jabatan_pjbt'] = $dataQue[3];

        }else{
            $data['nama_atsl'] = $dataPkm2[1];
            $data['gol_atsl'] = $dataPkm2[2];
            if($data['nip_baru_atsl']!=''){
                $data['jabatan_atsl'] = 'Kepala Puskesmas '.$data['unit_kerja_me'];
            }else{
                $data['jabatan_atsl'] = '';
            }

            $sql = "SELECT p.nip_baru, CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
            nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(' ',p.gelar_belakang) END) AS nama, g.golongan
            FROM pegawai p, golongan g
            WHERE  p.pangkat_gol = g.golongan AND p.id_j = ".$dataPkm[5];

            $que = mysqli_query($mysqli,$sql);
            $dataQue = mysqli_fetch_array($que);
            $data['nip_baru_pjbt'] = $dataQue[0];
            $data['nama_pjbt'] = $dataQue[1];
            $data['gol_pjbt'] = $dataQue[2];
            $data['jabatan_pjbt'] = $dataPkm[4];
        }
    }
}


if($data['idp_plt_atsl']!=''){
    $sql = "SELECT p.nip_baru, CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
            nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(' ',p.gelar_belakang) END) AS nama, g.golongan, j.jabatan
            FROM pegawai p, golongan g, jabatan_plt jp, jabatan j
            WHERE p.id_pegawai = ".$data['idp_plt_atsl']." AND p.pangkat_gol = g.golongan AND p.id_pegawai = jp.id_pegawai AND jp.id_j = j.id_j ";
    $query2 = mysqli_query($mysqli,$sql);
    $data2 = mysqli_fetch_array($query2);
    $data['nip_baru_atsl'] = $data2[0];
    $data['nama_atsl'] = $data2[1];
    $data['gol_atsl'] = $data2[2];
    $data['jabatan_atsl'] = 'Plt. '.$data2[3];
}

if($data['idp_plt_pjbt']!=''){
    $sql = "SELECT p.nip_baru, CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
            nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(' ',p.gelar_belakang) END) AS nama,
            g.golongan, j.jabatan, uk.id_skpd
            FROM pegawai p LEFT JOIN golongan g ON p.pangkat_gol = g.golongan
            LEFT JOIN jabatan_plt jp ON p.id_pegawai = jp.id_pegawai
            LEFT JOIN jabatan j ON jp.id_j = j.id_j
            LEFT JOIN current_lokasi_kerja clk ON p.id_pegawai = clk.id_pegawai
            LEFT JOIN unit_kerja uk ON clk.id_unit_kerja = uk.id_unit_kerja
            WHERE p.id_pegawai = ".$data['idp_plt_pjbt'];
    //echo $sql;
    $query2 = mysqli_query($mysqli,$sql);
    $data2 = mysqli_fetch_array($query2);

    if(is_numeric($data['nip_baru_pjbt']) or $data['nip_baru_pjbt']==''){
        $data['nip_baru_pjbt'] = $data2[0];
        $data['gol_pjbt'] = $data2[2];
    }else{
        $data['nip_baru_pjbt'] = '-';
        $data['gol_pjbt'] = '-';
    }
    $data['nama_pjbt'] = $data2[1];
    $data['jabatan_pjbt'] = 'Plt. '.$data2[3];
    $data['id_skpd'] = $data2[4];
}

if($dataPkm[2]=='Dinas Pendidikan Kota Bogor'){
    if($dataPkm[0]<>$dataPkm[1]) {
        $sql = "SELECT p.nip_baru, CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
                nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(' ',p.gelar_belakang) END) AS nama, p.pangkat_gol
                FROM pegawai p, current_lokasi_kerja clk
                WHERE p.id_pegawai = clk.id_pegawai AND clk.id_unit_kerja = ".$data['id_unit_kerja_me']." AND p.is_kepsek = true";
        $queryPkm = mysqli_query($mysqli,$sql);
        $dataPkm2 = mysqli_fetch_array($queryPkm);
        $data['nip_baru_atsl'] = $dataPkm2[0];
        if($data['nip_baru_atsl']==$data[1]) { //jika ia juga sbgai kepsek
            $sql = "SELECT p.nip_baru, CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
            nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(' ',p.gelar_belakang) END) AS nama, g.golongan
            FROM pegawai p, golongan g
            WHERE  p.pangkat_gol = g.golongan AND p.id_j = ".$dataPkm[5];
            $que = mysqli_query($mysqli,$sql);
            $dataQue = mysqli_fetch_array($que);
            $data['nip_baru_atsl'] = $dataQue[0];
            $data['nama_atsl'] = $dataQue[1];
            $data['gol_atsl'] = $dataQue[2];
            $data['jabatan_atsl'] = $dataPkm[4];
            $sql = "SELECT p.nip_baru, CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
                    nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(' ',p.gelar_belakang) END) AS nama, g.golongan, j.jabatan
                    FROM pegawai p, golongan g, jabatan j
                    WHERE  p.pangkat_gol = g.golongan AND p.id_j = (SELECT id_j FROM jabatan WHERE tahun =
                    (SELECT max(tahun) FROM jabatan) and jabatan LIKE '%Sekretaris Daerah%') AND p.id_j = j.id_j";
            $que = mysqli_query($mysqli,$sql);
            $dataQue = mysqli_fetch_array($que);
            $data['nip_baru_pjbt'] = $dataQue[0];
            $data['nama_pjbt'] = $dataQue[1];
            $data['gol_pjbt'] = $dataQue[2];
            $data['jabatan_pjbt'] = $dataQue[3];
        }else{
            if($data['jenjab']=='Fungsional' and $data['jabatan']=='Guru'){
                $data['nama_atsl'] = $dataPkm2[1];
                $data['gol_atsl'] = $dataPkm2[2];
                if($data['nip_baru_atsl']!=''){
                    $data['jabatan_atsl'] = 'Kepala Sekolah '.$data['unit_kerja_me'];
                }else{
                    $data['jabatan_atsl'] = '';
                }
                $sql = "SELECT c.nip_baru, c.nama, c.pangkat_gol, j.jabatan FROM 
                (SELECT p.nip_baru, CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
                nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(' ',p.gelar_belakang) END) AS nama, p.pangkat_gol, p.id_j
                FROM pegawai p INNER JOIN
                (SELECT CASE WHEN (LOWER(a.sekolah) LIKE 'tk%' OR  LOWER(a.sekolah) LIKE 'sdn%' OR LOWER(a.sekolah) LIKE 'smpn%') THEN
                  (SELECT j.id_j FROM jabatan j WHERE j.jabatan LIKE '%Kepala Bidang Sekolah Dasar%'
                  AND j.Tahun = (SELECT MAX(Tahun) FROM jabatan))
                ELSE (CASE WHEN (LOWER(a.sekolah) LIKE 'sman%' OR LOWER(a.sekolah) LIKE 'smkn%') THEN
                  (SELECT j.id_j FROM jabatan j WHERE j.jabatan LIKE '%Kepala Bidang Sekolah Menengah%'
                  AND j.Tahun = (SELECT MAX(Tahun) FROM jabatan))
                ELSE 0 END) END as id_j FROM
                (SELECT '".$data['unit_kerja_me']."' AS sekolah) a) b ON p.id_j = b.id_j) c, jabatan j
                WHERE c.id_j = j.id_j";
                $query4 = mysqli_query($mysqli,$sql);
                $data4 = mysqli_fetch_array($query4);
                $data['nip_baru_pjbt'] = $data4[0];
                $data['nama_pjbt'] = $data4[1];
                $data['gol_pjbt'] = $data4[2];
                $data['jabatan_pjbt'] = $data4[3];
            }else{
                $data['nama_atsl'] = $dataPkm2[1];
                $data['gol_atsl'] = $dataPkm2[2];
                if($data['nip_baru_atsl']!=''){
                    $data['jabatan_atsl'] = 'Kepala Sekolah '.$data['unit_kerja_me'];
                }else{
                    $data['jabatan_atsl'] = '';
                }

                $sql = "SELECT p.nip_baru, CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
                nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(' ',p.gelar_belakang) END) AS nama, g.golongan
                FROM pegawai p, golongan g
                WHERE  p.pangkat_gol = g.golongan AND p.id_j = ".$dataPkm[5];

                $que = mysqli_query($mysqli,$sql);
                $dataQue = mysqli_fetch_array($que);
                $data['nip_baru_pjbt'] = $dataQue[0];
                $data['nama_pjbt'] = $dataQue[1];
                $data['gol_pjbt'] = $dataQue[2];
                $data['jabatan_pjbt'] = $dataPkm[4];
            }
        }
    }
}

if($data['idp_plt_atsl']<>'' AND $data['idp_plt_pjbt']<>'') {
    if ($data['idp_plt_atsl'] == $data['idp_plt_pjbt']) {
        $sql = "SELECT id_skpd FROM unit_kerja WHERE id_unit_kerja = ".$data['id_unit_kerja_me'];
        $qry = mysqli_query($mysqli,$sql);
        $idskpd = mysqli_fetch_array($qry);
        $sql = "SELECT id_j FROM jabatan WHERE id_unit_kerja = $idskpd[0] AND eselon = 'IIIA'";
        $qry = mysqli_query($mysqli,$sql);
        $idj = mysqli_fetch_array($qry);

        $sql = "SELECT p.nip_baru, CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
                nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(' ',p.gelar_belakang) END) AS nama, p.pangkat_gol, j.jabatan
                FROM pegawai p, jabatan j
                WHERE p.id_j = j.id_j AND p.id_j = $idj[0]";
        $query = mysqli_query($mysqli,$sql);
        $data4 = mysqli_fetch_array($query);
        $data['nip_baru_pjbt'] = $data4[0];
        $data['nama_pjbt'] = $data4[1];
        $data['gol_pjbt'] = $data4[2];
        $data['jabatan_pjbt'] = $data4[3];
    }
}

$sql = "SELECT MAX(uk.id_unit_kerja) AS id_unit_kerja FROM unit_kerja uk
        WHERE uk.nama_baru LIKE '%Sekretariat Daerah%' AND uk.tahun = (SELECT MAX(tahun) FROM unit_kerja uk1)";
$query2 = mysqli_query($mysqli,$sql);
$data2 = mysqli_fetch_array($query2);

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

if($issubmit=='true'){

    if(isset($idup))
    {
        $t0=substr($txtTmtMulai,0,2);
        $b0=substr($txtTmtMulai,3,2);
        $th0=substr($txtTmtMulai,6,4);
        $t2=substr($txtTmtSelesai,0,2);
        $b2=substr($txtTmtSelesai,3,2);
        $th2=substr($txtTmtSelesai,6,4);

        if($cboIdJnsCuti=='C_BESAR' or $cboIdJnsCuti=='C_ALASAN_PENTING'){
            if($txtAlamatCuti[1] != ''){
                $txtAlamatCuti = $txtAlamatCuti[0].'. Dengan Alasan '.$txtAlamatCuti[1];
            }
        }else{
            $txtAlamatCuti = $txtAlamatCuti[0];
        }

        $date_now = date("Y-m-d");
        if ($date_now >= "$th0-$b0-$t0") {
            $rdb_cuti_mundur = $rdb_cuti_mundur;
        }else{
            $rdb_cuti_mundur = 'NULL';
        }

        $sql_update = "update cuti_master set tmt_awal='$th0-$b0-$t0',tmt_akhir='$th2-$b2-$t2',lama_cuti=$txtLamaCuti,
                        keterangan='$txtAlamatCuti',is_cuti_mundur=$rdb_cuti_mundur
                       where id_cuti_master=$idup";
        if (mysqli_query($mysqli,$sql_update) == TRUE) {
            echo("<div align=center style='background-color: #83c868;font-weight: bold;color: #ffffff; padding-top: 5px;padding-bottom: 5px;'> Pengajuan Cuti Berhasil Diubah </div>");
        }else{
            echo("<div align=center style='background-color:#c8271b;font-weight: bold;color: #ffffff; padding-top: 5px;padding-bottom: 5px;'> Error: Tidak dapat menyimpan data" . "<br>" . $conn->error . "</div>");
        }
    }else {
        $txtTglPengajuan = explode("-", $txtTglPengajuan);
        $txtTglPengajuan = $txtTglPengajuan[2] . '-' . $txtTglPengajuan[1] . '-' . $txtTglPengajuan[0];
        $txtTmtMulai = explode("-", $txtTmtMulai);
        $txtTmtMulai = $txtTmtMulai[2] . '-' . $txtTmtMulai[1] . '-' . $txtTmtMulai[0];
        $txtTmtSelesai = explode("-", $txtTmtSelesai);
        $txtTmtSelesai = $txtTmtSelesai[2] . '-' . $txtTmtSelesai[1] . '-' . $txtTmtSelesai[0];
        if($cboIdJnsCuti=='C_BESAR' or $cboIdJnsCuti=='C_ALASAN_PENTING' or $cboIdJnsCuti=='C_TAHUNAN'){
            if($txtAlamatCuti[1] != ''){
                $txtAlamatCuti = $txtAlamatCuti[0].'. Dengan Alasan '.$txtAlamatCuti[1];
            }
        }else{
            $txtAlamatCuti = $txtAlamatCuti[0];
        }

        $date_now = date("Y-m-d");
        if ($date_now >= $txtTmtMulai) {
            $rdb_cuti_mundur = $rdb_cuti_mundur;
        }else{
            $rdb_cuti_mundur = 'NULL';
        }

        $sql_insert = "INSERT INTO cuti_master(periode_thn, tgl_usulan_cuti, id_pegawai, last_jenjab, last_jabatan,
                  last_gol, last_id_unit_kerja, last_unit_kerja, last_masa_kerja, last_atsl_nip, last_atsl_nama, last_atsl_gol, last_atsl_jabatan,
                  last_pjbt_nip, last_pjbt_nama, last_pjbt_gol, last_pjbt_jabatan, flag_uk_atasan_sama, id_jenis_cuti,
                  no_keputusan, tmt_awal, tmt_akhir, lama_cuti, keterangan, id_status_cuti, tgl_approve_status, approved_by, approved_note,
                  flag_lapor_selesai, tgl_lapor_selesai, idberkas_surat_cuti, is_cuti_mundur)
                  VALUES ($txtPeriode, NOW(), $_SESSION[id_pegawai], '$last_jenjab', '$last_jabatan', '$last_gol', '$last_id_unit_kerja',
                  '$last_unit_kerja', $last_masa_kerja, '$last_atsl_nip', '".addslashes($last_atsl_nama)."', '$last_atsl_gol', '$last_atsl_jabatan',
                  '$last_pjbt_nip', '".addslashes($last_pjbt_nama)."', '$last_pjbt_gol', '$last_pjbt_jabatan', $flag_uk_atasan_sama,
                  '$cboIdJnsCuti', '-', '$txtTmtMulai', '$txtTmtSelesai', $txtLamaCuti, '$txtAlamatCuti', 1, NOW(), $_SESSION[id_pegawai], NULL,
                  0,NULL,0,$rdb_cuti_mundur);";

        //echo $sql_insert;

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
        } else {
            echo("<div align=center style='background-color:#c8271b;font-weight: bold;color: #ffffff; padding-top: 5px;padding-bottom: 5px;'> Error: Tidak dapat menyimpan data" . "<br>" . $conn->error . "</div>");
        }
    }
}

?>

<link rel="stylesheet" type="text/css" href="tcal.css" />
<script type="text/javascript" src="tcal.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="SpryAssets/SpryValidationTextarea.js" type="text/javascript"></script>
<script type="text/javascript">


    function update(cm) {
        //var cm = document.getElementById('cm').value;
        location.href="index3.php?x=cuti2.php&aktif=2&idcm="+cm;
    }


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
        <li role="presentation" <?php echo($issubmit == 'true' ? '' : (($ubahstatus == 'true' ? '' : (!isset($aktif) or $aktif==1) ? " class=active" : '')));?>><a href="#data_dasar" aria-controls="data_dasar" role="tab" data-toggle="tab">Data Dasar</a></li>
        <li role="presentation" <?php echo($issubmit == 'true' ? '' : (($ubahstatus == 'true' ? '' : $aktif==2 ? " class=active" :''))); ?>><a href="#form_cuti" aria-controls="form_cuti" role="tab" data-toggle="tab">Form Registrasi</a></li>
        <li role="presentation" <?php echo(($issubmit == 'true' or $ubahstatus == 'true') ? " class=active" : ''); ?>><a href="#list_cuti" aria-controls="list_cuti" role="tab" data-toggle="tab">Status Pengajuan Cuti Saya</a></li>
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
                    <td style="width: 20%;">Masa Kerja</td>
                    <td style="width: 75%;"><?php echo $data['masa_kerja'] ?> Tahun</td>
                </tr>
                <tr>
                    <td style="width: 5%;">g.</td>
                    <td style="width: 20%;">Unit Kerja</td>
                    <td style="width: 75%;"><?php echo $data['unit_kerja_me'] ?>
                        <input type="hidden" id="txCekUnit" name="txCekUnit" value="<?php echo $dataCekUnit[5] ?>">
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
                Jika data atasan belum tercantum silahkan <a href="<?php echo BASE_URL ?>index3.php?x=box.php&od=<?php echo $_SESSION[id_pegawai];?>">Klik di sini</a>
                untuk mengubah Profil Pegawai. Pilihlah atasan langsungnya dan Simpan. <br>Atau terdapat data yang tidak lengkap.
            </div>
        </div>

        <div role="tabpanel" class="tab-pane <?php echo($issubmit == 'true' ? '' : ($ubahstatus == 'true' ? '' : ($aktif==2 ? "active" :''))); ?>" id="form_cuti">
            <?php
            if($aktif==2){
                $sql_data = "SELECT * FROM cuti_jenis cj WHERE cj.id_jenis_cuti = '".$up['id_jenis_cuti']."'
                    ORDER BY cj.id_jenis_cuti DESC;";
            }else{
                $sql_data = "SELECT * FROM cuti_jenis cj ORDER BY cj.id_jenis_cuti DESC;";
            }
            $query = mysqli_query($mysqli,$sql_data);
            $array_data = array();
            while ($row = mysqli_fetch_array($query)) {
                $array_data[] = $row;
            }
            $array_data_length = count($array_data);
            $idjenis_cuti = $array_data[0]['id_jenis_cuti'];
            $jenis_cuti = $array_data[0]['deskripsi'];
            ?>
            <form action="index3.php?x=cuti2.php" method="post" enctype="multipart/form-data" name="frmCuti" id="frmCuti">

                <?php
                if(@$aktif==2)
                    echo("<input type=hidden id=idup name=idup value=$idcm >")

                ?>

                <fieldset onmouseover="calculateDate()">
                    <table class="table" id="tblFormCuti">
                        <tr>
                            <td>
                                <table class="table">
                                    <tr>
                                        <td colspan="2" style="border-top: 0px;"><i>Pastikan Data Dasar sudah lengkap</i></td>
                                    </tr>
                                    <tr>
                                        <td width="20%">
                                            Pilih Jenis Cuti
                                            <input id="last_gol" name="last_gol" type="hidden" value="<?php echo $data['pangkat_gol'] ?>" />
                                            <input id="last_jenjab" name="last_jenjab" type="hidden" value="<?php echo $data['jenjab'] ?>" />
                                            <input id="last_jabatan" name="last_jabatan" type="hidden" value="<?php echo (($data['is_kepsek']==0 and $data['is_kapus']==0)?$data['jabatan']:($data['is_kepsek']==1?$data['jabatan'].' sebagai Kepala Sekolah':($data['is_kapus']==1?$data['jabatan'].' sebagai Kepala Puskesmas':$data['jabatan']))); ?>" />
                                            <input id="last_masa_kerja" name="last_masa_kerja" type="hidden" value="<?php echo $data['masa_kerja'] ?>" />
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
                                        <td width="30%">
                                            <select id="cboIdJnsCuti" name="cboIdJnsCuti" size="6" style="width:100%;max-width: 350px;" <?php if($aktif==2) echo(" readonly=readonly"); ?>>
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
                                        <td width="20%">Detail Informasi Cuti</td>
                                        <td width="30%">
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

                                            switch ($idjeniscutinya) {
                                                case 'C_TAHUNAN':
                                                    $call_sp = "CALL PRCD_CUTI_COUNT_HIST_TAHUNAN(".$_SESSION[id_pegawai].");";
                                                    break;
                                                case 'C_BESAR':
                                                    $call_sp = "CALL PRCD_CUTI_COUNT_HIST_BESAR(".$_SESSION[id_pegawai].");";
                                                    break;
                                                case 'C_ALASAN_PENTING':
                                                    $call_sp = "CALL PRCD_CUTI_COUNT_HIST_ALASAN_PENTING(".$_SESSION[id_pegawai].");";
                                                    break;
                                                case 'C_SAKIT':
                                                    $qjk=mysqli_query($mysqli,"SELECT p.jenis_kelamin FROM pegawai p WHERE p.id_pegawai = ".$up['id_pegawai']);
                                                    $ujk=mysqli_fetch_array($qjk);
                                                    $call_sp = "CALL PRCD_CUTI_COUNT_HIST_SAKIT(".$_SESSION[id_pegawai].",".$up['idjenis_cuti_sakit'].",".$ujk['jenis_kelamin'].",".$up['flag_sakit_baru'].");";
                                                    break;
                                                case 'C_BERSALIN':
                                                    $qjk=mysqli_query($mysqli,"SELECT p.jenis_kelamin FROM pegawai p WHERE p.id_pegawai = ".$up['id_pegawai']);
                                                    $ujk=mysqli_fetch_array($qjk);
                                                    $call_sp = "CALL PRCD_CUTI_COUNT_HIST_BERSALIN(".$_SESSION[id_pegawai].",".$ujk['jenis_kelamin'].");";
                                                    break;
                                                case 'CLTN':
                                                    $call_sp = "CALL PRCD_CUTI_COUNT_HIST_CLTN(".$_SESSION[id_pegawai].");";
                                                    break;
                                            }

                                            $res_query_sp = $mysqli->query($call_sp);
                                            $array_data = array();
                                            $res_query_sp->data_seek(0);
                                            while ($row = $res_query_sp->fetch_assoc()) {
                                                $array_data[] = $row;
                                            }
                                            $jml_max = $array_data[0]['kuota_max_cuti'];
                                            $quota_cuti = $array_data[0]['kuota_cuti'];
                                            $cuti_curr = $array_data[0]['jml_cuti_curr'];
                                            ?>
                                            <div id="divInformasiCuti">
                                                <strong><?php echo $desk; ?></strong><br>
                                                Masa Kerja Minimal : <?php echo $masa_kerja_min.' Tahun';?><br>
                                                Kuota Cuti Per Tahun: <?php echo $ket_kuota;?><br> <input id="kuota_min_hari" name="kuota_min_hari" type="hidden" value="<?php echo $kuota_min_hari; ?>" />
                                                Jumlah Kuota Cuti Per Tahun: <?php echo $jml_max; ?> Hari<br>
                                                Cuti yang dapat diambil :
                                                <input id="jml_jatah_cuti" name="jml_jatah_cuti" type="hidden" value="<?php echo $quota_cuti; ?>" />
                                                <?php echo $quota_cuti; ?> Hari
                                                <?php
                                                if($up['id_jenis_cuti']=='C_TAHUNAN' or $idjeniscutinya=='C_TAHUNAN') {
                                                    $sqlcb = "SELECT SUM(cm.lama_cuti) as jumlah FROM cuti_master cm WHERE cm.id_pegawai = " . $_SESSION[id_pegawai] . " AND 
                                                              cm.id_jenis_cuti = 'C_BESAR' AND cm.periode_thn = YEAR(NOW()) AND 
                                                              (cm.id_status_cuti = 6 OR cm.id_status_cuti = 10)";
                                                    $rs = mysqli_query($mysqli,$sqlcb);
                                                    while ($row = mysqli_fetch_array($rs)) {
                                                        $jmlcb = $row['jumlah'];
                                                    }
                                                    if ($jmlcb > 0) {
                                                        echo "<span style=\"color: darkred;\"><small>(Tahun ini telah Cuti Besar selama $jmlcb hari)</small></span>";
                                                    }
                                                }
                                                ?>
                                                <br>Cuti yang sudah diambil : <?php echo $cuti_curr; ?> Hari
                                                <?php
                                                switch ($up['id_jenis_cuti']) {
                                                    case 'C_BESAR':
                                                        echo '<br><span style="color: #8a6d3b;"><small>Berlaku untuk alasan keagamaan seperti Haji atau Umroh. <br> Cuti Besar yang sudah diambil pada tahun berjalan
                                                        akan menghapus Cuti Tahunan</small></span>';
                                                        break;
                                                    case 'C_ALASAN_PENTING':
                                                        echo '<br><span style="color: #8a6d3b;"><small>Berlaku untuk alasan Menikah, merawat keluarga yang Sakit atau Meninggal.</small></span>';
                                                        break;
                                                }
                                                ?>
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
                                        <td><span id="sprytextfield1">
                                        <input name="txtLamaCuti" type="text" id="txtLamaCuti" onkeyup="calculateDate()" <?php if(@$aktif!=2) echo(" value=1 "); else echo(" value=$up[lama_cuti] ");  ?> maxlength="4" />
                                        <span class="textfieldRequiredMsg" style="border: 0px;">Harus diisi</span><span class="textfieldInvalidFormatMsg">Input harus angka</span></span></td>
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
                                        <td><label for="txtAlamatCuti"></label><span id="sprytextarea1"><textarea style="resize: none;" rows="4" cols="50" name="txtAlamatCuti[]" id="txtAlamatCuti[]"><?php if(@$aktif!=2) echo $data['alamat']; else echo $upKeterangan; ?></textarea><br>
                                        <span class="textareaRequiredMsg" style="border: 0px;">Harus diisi</span></span></td>
                                    </tr>

                                    <?php if((@$aktif==2) and ($up['id_jenis_cuti']=='C_ALASAN_PENTING' or $up['id_jenis_cuti']=='C_BESAR' or $up['id_jenis_cuti']=='C_TAHUNAN')): ?>
                                        <tr id="trKeteranganTambahan">
                                            <td>Keterangan Tambahan/Alasan</td>
                                            <td><label for="txtKeteranganTambahan"></label><span id="sprytextarea2"><textarea style="resize: none;" rows="4" cols="50" name="txtAlamatCuti[]" id="txtAlamatCuti[]"><?php if(@$aktif==2) echo $upAlasan; ?></textarea><br>
                                                <span class="textareaRequiredMsg" style="border: 0px;">Harus diisi</span></span>
                                            </td>
                                        </tr>
                                    <?php else: ?>
                                        <?php if($idjeniscutinya=='C_TAHUNAN'): ?>
                                            <tr id="trKeteranganTambahan">
                                                <td>Keterangan Tambahan/Alasan</td>
                                                <td><label for="txtKeteranganTambahan"></label><span id="sprytextarea2"><textarea style="resize: none;" rows="4" cols="50" name="txtAlamatCuti[]" id="txtAlamatCuti[]"><?php if(@$aktif==2) echo $upAlasan; ?></textarea><br>
                                                <span class="textareaRequiredMsg" style="border: 0px;">Harus diisi</span></span>
                                                </td>
                                            </tr>
                                        <?php endif; ?>
                                    <?php endif; ?>

                                    <tr>
                                        <td></td>
                                        <td>
                                            <input type="submit" onclick="return confirm('Anda yakin akan menyimpan permohonan ini?');" name="btnSimpanCuti" id="btnSimpanCuti" class="btn btn-primary" value="<?php if($aktif!=2) echo("Simpan"); else echo("Update Pengubahan");  ?>" />
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
                            <td style="background-color:#c6c6c6; width: 40%;">
                                <?php
                                $sql_cuti_libur = "SELECT DATE_FORMAT(cb.tanggal,  '%d/%m/%Y') AS tanggal, hari, ket
                                            FROM cuti_bersama cb
                                            WHERE YEAR(cb.tanggal) = YEAR(NOW()) ORDER BY cb.tanggal";
                                $query_row = mysqli_query($mysqli,$sql_cuti_libur);
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
                                            <td><?php echo ($i+1).')'; ?></td>
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
                                            WHERE YEAR(cb.tanggal) = YEAR(NOW()) ORDER BY cb.tanggal";
                                $query_row = mysqli_query($mysqli,$sql_cuti_libur);
                                ?>
                                <strong>Libur Nasional</strong>
                                <table class="table">
                                    <tr>
                                        <td>No</td>
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
                                            <td><?php echo ($i+1).')';?></td>
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
        <?php
        $sql_list_cuti = "SELECT cuti_pegawai.*, p.nama as nama_approved, p.nip_baru as nip_baru_approved,
                              DATE_FORMAT(cuti_pegawai.tmt_awal,  '%d/%m/%Y') AS tmt_awal_cuti,
                              DATE_FORMAT(cuti_pegawai.tmt_akhir,  '%d/%m/%Y') AS tmt_akhir_cuti,
                              DATE_FORMAT(cuti_pegawai.tgl_usulan_cuti,  '%d/%m/%Y %H:%m:%s') AS tgl_usulan_cuti2,
                              DATE_FORMAT(cuti_pegawai.tgl_approve_status,  '%d/%m/%Y %H:%m:%s') AS tgl_approve_status2
                              FROM
                             (SELECT cm.*, rs.status_cuti, cj.deskripsi FROM cuti_master cm, ref_status_cuti rs, cuti_jenis cj
                              WHERE cm.id_status_cuti = rs.idstatus_cuti AND cm.id_pegawai = $_SESSION[id_pegawai] AND
                              cm.id_jenis_cuti = cj.id_jenis_cuti) as cuti_pegawai, pegawai p
                              WHERE cuti_pegawai.approved_by = p.id_pegawai ORDER BY cuti_pegawai.tgl_usulan_cuti DESC";
        $query_row_cuti_master = mysqli_query($mysqli,$sql_list_cuti);
        $i = 0;
        ?>
        <div role="tabpanel" class="tab-pane <?php echo(($issubmit == 'true' or $ubahstatus == 'true') ? "active" : ''); ?>" id="list_cuti">
            <div style="margin-top: 10px; margin-bottom: 10px; font-style: italic;color: #0A246A;">
                Pastikan berkas surat cuti yang terupload dikirimkan dengan cara mengklik tombol <strong>Kirim Usulan</strong>,
                untuk pemrosesan administrasi cuti oleh operator pengelola. <br>
                Jika pegawai yang mengajukan cuti memiliki perbedaan lokasi unit kerja antara atasan langsung dengan atasan dari atasan langsung (pejabat berwenang) maka
                operator pengelola ada di OPD namun jika sebaliknya (sama) maka operator pengelola langsung ada di BKPP. <br>
                Keterangan lebih lanjut hubungi Admin SIMPEG di OPD/BKPP.
            </div>
            <table width="95%" border="0" align="center" style="border-radius:5px;"
                   class="table table-bordered table-hover table-striped">
                <tr>
                    <td style="width: 5%;">No.</td>
                    <td style="width: 5%;">Periode</td>
                    <td style="width: 15%;">Tgl. Pengajuan</td>
                    <td style="width: 10%;">TMT. Awal</td>
                    <td style="width: 10%;">TMT. Akhir</td>
                    <td style="width: 5%;">Lama Cuti</td>
                    <td style="width: 30%;">Alamat Selama Cuti</td>
                    <td style="width: 20%;">Status</td>
                </tr>
                <?php while($row_cuti = mysqli_fetch_array($query_row_cuti_master)){
                    if (isset($btnAjukanCuti[$i])) {
                        if($row_cuti['flag_uk_atasan_sama']==1){
                            $idstatus_cuti_hist = 3;
                        }else{
                            $idstatus_cuti_hist = 2;
                        }
                        $sqlInsert_Approved_Hist = "INSERT INTO cuti_historis_approve(tgl_approve_hist, approved_by_hist, idstatus_cuti_hist, approved_note_hist, id_cuti_master)
                            VALUES (NOW(),".$_SESSION[id_pegawai].",$idstatus_cuti_hist,'".$txtCatatan[$i]."',".$row_cuti['id_cuti_master'].")";
                        if (mysqli_query($mysqli,$sqlInsert_Approved_Hist) == TRUE) {
                            echo("<div align=center style='background-color: #83c868;font-weight: bold;color: #ffffff; padding-top: 5px;padding-bottom: 5px;'> Pengajuan Cuti Berhasil Terkirim </div>");
                            $sqlUpdateCuti = "UPDATE cuti_master set id_status_cuti=$idstatus_cuti_hist, tgl_approve_status=NOW(),
                                approved_by=".$_SESSION[id_pegawai].",approved_note= '".$txtCatatan[$i]."'
                                where id_cuti_master=".$row_cuti['id_cuti_master'];
                            mysqli_query($mysqli,$sqlUpdateCuti);
                            $url = "/simpeg/index3.php?x=cuti2.php";
                            echo("<script type=\"text/javascript\">location.href='/simpeg/index3.php?x=cuti2.php&ubahstatus=true';</script>");
                        } else {
                            echo("<div align=center style='background-color:#c8271b;font-weight: bold;color: #ffffff; padding-top: 5px;padding-bottom: 5px;'> Error: Tidak dapat menyimpan data" . "<br>" . $conn->error . "</div>");
                        }
                    }

                    if (isset($btnBatalkanCuti[$i])) {
                        $sqlUpdate = "update cuti_master set id_status_cuti=9, tgl_approve_status=NOW(),
                                approved_by=".$_SESSION[id_pegawai].",approved_note= '".$txtCatatan[$i]."'
                                where id_cuti_master=".$row_cuti['id_cuti_master'];
                        if (mysqli_query($mysqli,$sqlUpdate) == TRUE) {
                            echo("<div align=center style='background-color: #83c868;font-weight: bold;color: #ffffff; padding-top: 5px;padding-bottom: 5px;'> Pengajuan Cuti Berhasil Dibatalkan </div>");
                            $sqlInsert_Approved_Hist = "INSERT INTO cuti_historis_approve(tgl_approve_hist, approved_by_hist, idstatus_cuti_hist, approved_note_hist, id_cuti_master)
                                VALUES (NOW(),".$_SESSION[id_pegawai].",9,'".$txtCatatan[$i]."',".$row_cuti['id_cuti_master'].")";
                            mysqli_query($mysqli,$sqlInsert_Approved_Hist);
                            $url = "/simpeg/index3.php?x=cuti2.php";
                            echo("<script type=\"text/javascript\">location.href='/simpeg/index3.php?x=cuti2.php&ubahstatus=true';</script>");
                        }else{
                            echo("<div align=center style='background-color:#c8271b;font-weight: bold;color: #ffffff; padding-top: 5px;padding-bottom: 5px;'> Error: Tidak dapat mengubah data" . "<br>" . $conn->error . "</div>");
                        }
                    }

                    if (isset($btnHapusCuti[$i])) {
                        $sqlDelete = "delete from cuti_master where id_cuti_master=".$row_cuti['id_cuti_master'];
                        if (mysqli_query($mysqli,$sqlDelete) == TRUE) {
                            echo("<div align=center style='background-color: #83c868;font-weight: bold;color: #ffffff; padding-top: 5px;padding-bottom: 5px;'> Pengajuan Cuti Berhasil Dihapus </div>");
                            $url = "/simpeg/index3.php?x=cuti2.php";
                            echo("<script type=\"text/javascript\">location.href='/simpeg/index3.php?x=cuti2.php&ubahstatus=true';</script>");
                        }else{
                            echo("<div align=center style='background-color:#c8271b;font-weight: bold;color: #ffffff; padding-top: 5px;padding-bottom: 5px;'> Error: Tidak dapat menghapus data" . "<br>" . $conn->error . "</div>");
                        }
                    }
                    ?>
                    <tr>
                        <td><?php echo $i+1; ?>.</td>
                        <td><?php echo $row_cuti['periode_thn']; ?></td>
                        <td><?php echo $row_cuti['tgl_usulan_cuti2']; ?></td>
                        <td><?php echo $row_cuti['tmt_awal_cuti']; ?></td>
                        <td><?php echo $row_cuti['tmt_akhir_cuti']; ?></td>
                        <td><?php echo $row_cuti['lama_cuti']; ?></td>
                        <td><?php echo $row_cuti['keterangan']; ?></td>
                        <td><?php echo $row_cuti['status_cuti']; ?></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td colspan="7">
                            <span style="color: #002a80; font-size: x-large; font-weight: bold"> <?php echo $row_cuti['deskripsi']; ?></span> <span style="font-weight: bold; color: darkorange;"><?php echo($row_cuti['is_cuti_mundur']==1?' (Cuti Mundur)':'');?></span><br>
                            Unit Kerja : <?php echo $row_cuti['last_unit_kerja']; ?> <br>
                            <strong>Atasan  Langsung : </strong><br>
                            <?php echo $row_cuti['last_atsl_nama']." (".$row_cuti['last_atsl_nip'].")"; ?> <br>
                            Gol. <?php echo $row_cuti['last_atsl_gol']; ?>. Jabatan : <?php echo $row_cuti['last_atsl_jabatan']; ?> <br>
                            <strong>Pejabat Berwenang : </strong><br>
                            <?php echo $row_cuti['last_pjbt_nama']." (".$row_cuti['last_pjbt_nip'].")"; ?> <br>
                            Gol. <?php echo $row_cuti['last_pjbt_gol']; ?>. Jabatan : <?php echo $row_cuti['last_pjbt_jabatan']; ?> <br>
                            <strong>Tgl. Update Status : </strong><?php echo $row_cuti['tgl_approve_status2']; ?> | Oleh : <?php echo $row_cuti['nama_approved']." (".$row_cuti['nip_baru_approved'].")"; ?> | Catatan Akhir : <?php echo ($row_cuti['approved_note']==""?"-":$row_cuti['approved_note']); ?><br />
                            Runut Status Pengajuan : <?php
                            echo("<ul>");
                            $qrun=mysqli_query($mysqli,"select nama,DATE_FORMAT(tgl_approve_hist,  '%d/%m/%Y %H:%m:%s') as tgl_approve_hist,approved_note_hist,status_cuti from cuti_historis_approve inner join pegawai on cuti_historis_approve.approved_by_hist=pegawai.id_pegawai inner join ref_status_cuti on ref_status_cuti.idstatus_cuti = cuti_historis_approve.idstatus_cuti_hist  where id_cuti_master=$row_cuti[id_cuti_master] ");
                            while($otoy=mysqli_fetch_array($qrun))
                            {
                                echo("<li>Status : $otoy[3] Diproses oleh $otoy[0] tanggal $otoy[1] catatan: $otoy[2] </li>");
                            }


                            echo("</ul>");
                            ?>
                            <form action="index3.php?x=cuti2.php" method="post" enctype="multipart/form-data" name="frmAjukanCuti" id="frmAjukanCuti">
                                <table width="100%" border="0" align="center" style="border-radius:5px;"
                                       class="table table-bordered table-striped">
                                    <tr>
                                        <td width="20%">
                                            <input type="button" name="btnCetakSuratCuti<?php echo $row_cuti['id_cuti_master']; ?>" id="btnCetakSuratCuti<?php echo $row_cuti['id_cuti_master']; ?>" class="btn btn-success btn-sm" value="Download Surat Permohonan Baru" />
                                            <script type="text/javascript">
                                                $("#btnCetakSuratCuti<?php echo $row_cuti['id_cuti_master']; ?>").click(function () {
                                                    window.open('/simpeg/cuti_surat.php?idcm=<?php echo $row_cuti['id_cuti_master']; ?>','_blank');
                                                });
                                            </script>
                                        </td>
                                        <td width="20%">
                                            <?php
                                            if ($row_cuti['idberkas_surat_cuti'] == 0) {
                                                $jml_noberkas[$i] = $jml_noberkas[$i] + 1;
                                                echo "<div id='spnInfo' style='color: white; background-color: #b12318; font-weight: bold; padding: 3px; width: 100%; text-align: center;'>Belum ada surat permohonan cuti yang diupload</div>";
                                            }else {
                                                $sqlCekBerkas = "SELECT ib.file_name, b.created_by, DATE_FORMAT(b.created_date,  '%d/%m/%Y %H:%m:%s') as created_date, p.nip_baru, p.nama
                                                FROM berkas b, isi_berkas ib, pegawai p
                                                WHERE b.id_berkas = ib.id_berkas AND b.id_berkas = " . $row_cuti['idberkas_surat_cuti'] .
                                                    " AND b.created_by = p.id_pegawai";
                                                $queryCek = mysqli_query($mysqli,$sqlCekBerkas);
                                                $data = mysqli_fetch_array($queryCek);
                                                $fname = pathinfo($data['file_name']);
                                                ?>
                                                <input type="button" name="btnCetakSuratCutiUploaded<?php echo $row_cuti['id_cuti_master']; ?>" id="btnCetakSuratCutiUploaded<?php echo $row_cuti['id_cuti_master']; ?>" class="btn btn-primary btn-sm" value="Lihat Surat Permohonan Terupload" />
                                                <script type="text/javascript">
                                                    $("#btnCetakSuratCutiUploaded<?php echo $row_cuti['id_cuti_master']; ?>").click(function () {
                                                        window.open('/simpeg/berkas/<?php echo $data['file_name'] ?>','_blank');
                                                    });
                                                </script>
                                                Tgl.Upload: <?php echo $data['created_date']; ?> <br>
                                                Oleh : <?php echo $data['nama']; ?>
                                                <?php
                                            }
                                            ?>
                                        </td>
                                        <td width="30%">
                                            <?php
                                            if ($row_cuti['idberkas_surat_cuti'] == 0){
                                            $jml_noberkas[$i] = $jml_noberkas[$i] + 1;
                                            ?>
                                            <span class="btn btn-primary btn-sm fileinput-button" <?php if($row_cuti['id_status_cuti'] == 9) echo 'disabled' ?>>
                                        <i class="glyphicon glyphicon-plus"></i>
                                        <span>Upload Baru Surat Cuti (format pdf maks.2MB)</span>
                                                <!-- The file input field used as target for the file upload widget -->
                                        <input id="file_cuti_<?php echo $row_cuti['id_cuti_master']; ?>"
                                               type="file" name="files[]" multiple/>
                                        <input type="hidden"
                                               name="surat_permohonan_cuti<?php echo $row_cuti['id_cuti_master']; ?>"
                                               id="surat_permohonan_cuti<?php echo $row_cuti['id_cuti_master']; ?>"/>
                                        </span><br><br>
                                            <div id="<?php echo 'progress_' . $row_cuti['id_cuti_master'] ?>"
                                                 class="progress primary" style="margin-top: -5px;">
                                                <div class="progress-bar progress-bar-primary"">
                                                <script type="text/javascript">
                                                    $(function () {
                                                        var <?php echo 'url_'.$row_cuti['id_cuti_master'] ?> =
                                                        window.location.hostname === 'blueimp.github.io' ?
                                                            '//jquery-file-upload.appspot.com/' : 'uploadercuti.php?idkat=37&nm_berkas=Surat Permohonan Cuti&ket_berkas=<?php echo $row_cuti['id_cuti_master']; ?>&idp_uploader=<?php echo($_SESSION[id_pegawai]); ?>&idp_cutier=<?php echo($row_cuti['id_pegawai']); ?>';
                                                        $('#<?php echo 'file_cuti_'.$row_cuti['id_cuti_master'] ?>').fileupload({
                                                                url: <?php echo 'url_'.$row_cuti['id_cuti_master'] ?>,
                                                                dataType: 'json',
                                                                paramName: 'files[]',
                                                                done: function (e, data) {
                                                                    $.each(data.result.files, function (index, file) {
                                                                        $('<p/>').text(file.name).appendTo('#files');
                                                                        location.href="/simpeg/index3.php?x=cuti2.php&ubahstatus=true";
                                                                        /*jml_noberkas = jml_noberkas - 1;
                                                                         if (jml_noberkas == 0) {
                                                                         $("#btnAjukanCuti").attr("disabled", false);
                                                                         $("#spnInfo").html('Anda sudah dapat mengajukan cuti');
                                                                         $("#spnInfo").css('color', '#008000');
                                                                         }*/
                                                                    });
                                                                },
                                                                progressall: function (e, data) {
                                                                    var progress = parseInt(data.loaded / data.total * 100, 10);
                                                                    $('#<?php echo 'progress_'.$row_cuti['id_cuti_master'] ?> .progress-bar').css(
                                                                        'width',
                                                                        progress + '%'
                                                                    );
                                                                }
                                                            })
                                                            .prop('disabled', !$.support.fileInput)
                                                            .parent().addClass($.support.fileInput ? undefined : 'disabled');
                                                    });
                                                </script>
                                                <?php
                                                }else{
                                                ?>
                                                <span class="btn btn-primary btn-sm fileinput-button" <?php echo(($row_cuti['id_status_cuti']!=1 and $row_cuti['id_status_cuti']!=4)?"disabled":(($jml_noberkas[$i] > 0)?"disabled":"")); ?> style="width: 100%;">
                                                        <i class="glyphicon glyphicon-plus"></i>
                                                        <span>Upload Ulang Surat Cuti</span>
                                                        <span>(format pdf maks.2MB)</span>
                                                    <!-- The file input field used as target for the file upload widget -->
                                                        <input id="<?php echo 'file_cuti_' . $row_cuti['id_cuti_master'] ?>" type="file" name="files[]" multiple/>
                                                        <input type="hidden" name="<?php echo 'surat_permohonan_cuti' . $row_cuti['id_cuti_master'] ?>"
                                                               id="<?php echo 'surat_permohonan_cuti' . $row_cuti['id_cuti_master'] ?>"/></span><br><br>
                                                <div id="<?php echo 'progress_' . $row_cuti['id_cuti_master'] ?>" class="progress primary" style="margin-top: -5px;">
                                                    <div class="progress-bar progress-bar-primary">
                                                        <script type="text/javascript">
                                                            $(function () {
                                                                var <?php echo 'url_'.$row_cuti['id_cuti_master'] ?> =
                                                                window.location.hostname === 'blueimp.github.io' ?
                                                                    '//jquery-file-upload.appspot.com/' : 'uploadercuti.php?idkat=37&nm_berkas=Surat Permohonan Cuti&ket_berkas=<?php echo $row_cuti['id_cuti_master']; ?>&idp_uploader=<?php echo($_SESSION[id_pegawai]); ?>&idp_cutier=<?php echo($row_cuti['id_pegawai']); ?>&upload_ulang=1&id_berkas=<?php echo $row_cuti['idberkas_surat_cuti']; ?>';
                                                                $('#<?php echo 'file_cuti_'.$row_cuti['id_cuti_master'] ?>').fileupload({
                                                                        url: <?php echo 'url_'.$row_cuti['id_cuti_master'] ?>,
                                                                        dataType: 'json',
                                                                        paramName: 'files[]',
                                                                        done: function (e, data) {
                                                                            $.each(data.result.files, function (index, file) {
                                                                                $('<p/>').text(file.name).appendTo('#files');
                                                                                location.href="/simpeg/index3.php?x=cuti2.php&ubahstatus=true";
                                                                                /*if (jml_noberkas == 0) {
                                                                                 $("#btnAjukanCuti").attr("disabled", false);
                                                                                 $("#spnInfo").html('Anda sudah dapat mengajukan cuti');
                                                                                 $("#spnInfo").css('color', '#008000');
                                                                                 }*/
                                                                            });
                                                                        },
                                                                        progressall: function (e, data) {
                                                                            var progress = parseInt(data.loaded / data.total * 100, 10);
                                                                            $('#<?php echo 'progress_'.$row_cuti['id_cuti_master'] ?> .progress-bar').css(
                                                                                'width',
                                                                                progress + '%'
                                                                            );
                                                                        }
                                                                    })
                                                                    .prop('disabled', !$.support.fileInput)
                                                                    .parent().addClass($.support.fileInput ? undefined : 'disabled');
                                                            });
                                                        </script>
                                                        <?php } ?>
                                        </td>
                                        <td width="30%">
                                            <?php
                                            if ($row_cuti['id_status_cuti'] == 6) {
                                                echo "<div id='spnInfo' style='color: white; background-color: #b12318; font-weight: bold; padding: 3px; width: 100%; text-align: center;'>SK Cuti belum diterbitkan</div>";
                                            }
                                            if ($row_cuti['id_status_cuti'] == 10) {
                                                if ($row_cuti['idberkas_sk_cuti'] == 0) {
                                                    echo "<div id='spnInfo' style='color: white; background-color: #b12318; font-weight: bold; padding: 3px; width: 100%; text-align: center;'>Belum ada SK Cuti yang diupload</div>";
                                                }else {
                                                    $sqlCekBerkas = "SELECT ib.file_name, b.created_by, DATE_FORMAT(b.created_date,  '%d/%m/%Y %H:%m:%s') as created_date, p.nip_baru, p.nama
                                                    FROM berkas b, isi_berkas ib, pegawai p
                                                    WHERE b.id_berkas = ib.id_berkas AND b.id_berkas = " . $row_cuti['idberkas_sk_cuti'] .
                                                        " AND b.created_by = p.id_pegawai";
                                                    $queryCek = mysqli_query($mysqli,$sqlCekBerkas);
                                                    $data = mysqli_fetch_array($queryCek);
                                                    $fname = pathinfo($data['file_name']);
                                                    ?>
                                                    <input type="button" name="btnCetakSKCutiUploaded<?php echo $row_cuti['id_cuti_master']; ?>" id="btnCetakSKCutiUploaded<?php echo $row_cuti['id_cuti_master']; ?>" class="btn btn-danger btn-sm" value="Download SK Cuti" style="width: 100%;" /><br>
                                                    <script type="text/javascript">
                                                        $("#btnCetakSKCutiUploaded<?php echo $row_cuti['id_cuti_master']; ?>").click(function () {
                                                            window.open('/simpeg2/Berkas/<?php echo $data['file_name'] ?>','_blank');
                                                        });
                                                    </script>
                                                    Tgl.Upload: <?php echo $data['created_date']; ?> <br>
                                                    Oleh : <?php echo $data['nama']; ?>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                    <tr style="background-color: #c6c6c6;">
                                        <td align="center">
                                            <input type="button" style="width: 45%;" name="btnUbahCuti_<?php echo $row_cuti['id_cuti_master']; ?>" id="btnUbahCuti_<?php echo $row_cuti['id_cuti_master']; ?>" class="btn btn-primary" value="Ubah" <?php if($row_cuti['id_status_cuti'] != 1 and $row_cuti['id_status_cuti'] != 4) echo 'disabled' ?> onclick="update(<?php echo $row_cuti['id_cuti_master']; ?>)" />
                                            <input type="submit" onclick="return confirm('Anda yakin akan menghapus permohonan ini?');" style="width: 45%;" name="btnHapusCuti[<?php echo $i; ?>]" id="btnHapusCuti[<?php echo $i; ?>]" class="btn btn-danger" value="Hapus" <?php if($row_cuti['id_status_cuti'] != 1) echo 'disabled' ?>  />
                                            <input name="cm" type="hidden" id="cm" value="<?php echo $row_cuti['id_cuti_master'] ; ?>" />
                                        </td>
                                        <td colspan="3">
                                            Catatan <input name="txtCatatan[<?php echo $i; ?>]" id="txtCatatan[<?php echo $i; ?>]" type="text" value="" style="width: 50%;" <?php echo(($row_cuti['id_status_cuti']!=1 and $row_cuti['id_status_cuti']!=2 and $row_cuti['id_status_cuti']!=3 and $row_cuti['id_status_cuti']!=4)?"disabled":(($jml_noberkas[$i] > 0)?"":"")); ?>/>
                                            <input type="submit" onclick="return confirm('Anda yakin akan mengirim usulan ini?');" name="btnAjukanCuti[<?php echo $i; ?>]" id="btnAjukanCuti[<?php echo $i; ?>]" class="btn btn-success" value="Kirim Usulan" <?php echo(($row_cuti['id_status_cuti']!=1 and $row_cuti['id_status_cuti']!=4)?"disabled":(($jml_noberkas[$i] > 0)?"disabled":"")); ?> />
                                            <input type="submit" onclick="return confirm('Anda yakin akan membatalkan permohonan ini?');" name="btnBatalkanCuti[<?php echo $i; ?>]" id="btnBatalkanCuti[<?php echo $i; ?>]" class="btn btn-warning" value="Batalkan" <?php echo(($row_cuti['id_status_cuti']!=1 and $row_cuti['id_status_cuti']!=2 and $row_cuti['id_status_cuti']!=3 and $row_cuti['id_status_cuti'] != 4)?"disabled":(($jml_noberkas[$i] > 0)?"":"")); ?> />
                                        </td>
                                    </tr>
                                </table>
                            </form>
                        </td>
                    </tr>
                    <?php
                    $i++;
                }
                ?>
            </table>
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
            url: "/simpeg/cuti_get_info_cuti.php?idJnsCuti="+idJnsCuti,
            success: function (data) {
                $("#divInformasiCuti").html(data);
                $("#divInformasiCuti").css("pointer-events", "auto");
                $("#divInformasiCuti").css("opacity", "1");
                $("#btnSimpanCuti").css("pointer-events", "auto");
                $("#btnSimpanCuti").css("opacity", "1");
                $("#cboIdJnsCuti").css("pointer-events", "auto");
                $("#cboIdJnsCuti").css("opacity", "1");
                if(idJnsCuti=='C_ALASAN_PENTING' || idJnsCuti=='C_BESAR' || idJnsCuti=='C_TAHUNAN'){
                    if ( $( "#trKeteranganTambahan" ).length ) {
                    }else{
                        jQuery("#trAlamat").after('<tr id="trKeteranganTambahan"><td>Keterangan Tambahan/Alasan</td><td><label for="txtKeteranganTambahan"></label><span id="sprytextarea2"><textarea style="resize: none;" rows="4" cols="50" name="txtAlamatCuti[]" id="txtAlamatCuti[]"></textarea><br><span class="textareaRequiredMsg" style="border: 0px;">Harus diisi</span></span></td></tr>');
                        $('#frmCuti').bootstrapValidator('addField',  $('#sprytextarea2').find('[name="txtAlamatCuti[]"]'));
                        var sprytextarea2 = new Spry.Widget.ValidationTextarea("sprytextarea2", {validateOn:["blur", "change"]});
                    }
                }else{
                    $('#frmCuti').bootstrapValidator('removeField',  $('#sprytextarea2').find('[name="txtAlamatCuti[]"]'));
                    if ( $( "#trKeteranganTambahan" ).length ) {
                        $('#trKeteranganTambahan').remove();
                    }
                }
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
            'txtAlamatCuti[]': {
                feedbackIcons: "false",
                validators: {notEmpty: {message: "Alamat tidak boleh kosong"}}
            }
        }
    }).on("error.field.bv", function (b, a) {
        a.element.data("bv.messages").find('.help-block[data-bv-for="' + a.field + '"]').hide();
    }).on('success.form.bv', function (e) {
        var lama_cuti = document.getElementById('txtLamaCuti').value;
        var jml_jatah_cuti = document.getElementById('jml_jatah_cuti').value;
        if (parseInt(jml_jatah_cuti) >= -1) {
            if (parseInt(jml_jatah_cuti) == -1) { //Tidak ada kuota maksimum
                return true;
            } else {
                if (parseInt(lama_cuti) > parseInt(jml_jatah_cuti)) {
                    alert('Jumlah lama cuti tidak boleh melebihi jumlah cuti yang dapat diambil');
                    var $form = $(e.target);
                    $form.bootstrapValidator('disableSubmitButtons', false);
                    return false;
                } else {
                    var kuota_min_hari = document.getElementById('kuota_min_hari').value;
                    if (parseInt(lama_cuti) < parseInt(kuota_min_hari)) {
                        alert('Jumlah lama cuti harus lebih dari jumlah minimal');
                        var $form = $(e.target);
                        $form.bootstrapValidator('disableSubmitButtons', false);
                        return false;
                    } else {
                        return true;
                    }
                }
            }
        } else {
            if (parseInt(jml_jatah_cuti) == -2) {
                alert('Pengajuan Cuti terakhir anda bukan cuti sakit baru');
                var $form = $(e.target);
                $form.bootstrapValidator('disableSubmitButtons', false);
                return false;
            } else if (parseInt(jml_jatah_cuti) == -3) {
                alert('Pengajuan Cuti Sakit terakhir anda belum Disetujui BKPP');
                var $form = $(e.target);
                $form.bootstrapValidator('disableSubmitButtons', false);
                return false;
            } else {
                return true;
            }
        }
    });

    var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "integer", {validateOn:["change"]});
    var sprytextarea1 = new Spry.Widget.ValidationTextarea("sprytextarea1", {validateOn:["blur", "change"]});
    var sprytextarea2 = new Spry.Widget.ValidationTextarea("sprytextarea2", {validateOn:["blur", "change"]});

</script>