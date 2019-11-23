<div class="row" style="margin: 10px;">
<?php
    include "konek.php";
    include "paginator.class.php";
    $pages = new Paginator;
    $pagePaging = $_POST['page'];
    if($pagePaging==0 or $pagePaging==""){
        $pagePaging = 1;
    }
    $ipp = $pages->items_per_page;
    $txtKeyword = $_POST['txtKeyword'];
    $stspegsimg = $_POST['stspegsimg'];
    $stsgol = $_POST['stsgol'];
    $stsnip = $_POST['stsnip'];
    $flagPensiun = $_POST['flagPensiun'];
    $jenjab = $_POST['jenjab'];
    $eselon = $_POST['eselon'];
    $ddStsJmlKeluarga = $_POST['ddStsJmlKeluarga'];
    $ddStsJmlPasangan = $_POST['ddStsJmlPasangan'];
    $ddStsJmlAnak = $_POST['ddStsJmlAnak'];
    $ddStsJmlPasanganDapat = $_POST['ddStsJmlPasanganDapat'];
    $ddStsJmlAnakDapat = $_POST['ddStsJmlAnakDapat'];

    $whereKlause1 = "";
    $whereKlause2 = "";
    $whereKlause3 = "";

    $whereKlause1 = " WHERE gm.KDSTAPEG = ".$stspegsimg;

    if($stsnip==0){
        $whereKlause2 = "WHERE p.nip_baru IS NOT NULL";
        if($stsgol==0){
            $whereKlause2 .= " AND xy.NMGOL = p.pangkat_gol";
        }elseif($stsgol==1){
            $whereKlause2 .= " AND xy.NMGOL > p.pangkat_gol";
        }else{
            $whereKlause2 .= " AND xy.NMGOL < p.pangkat_gol";
        }
        if($flagPensiun==0){
            $whereKlause2 .= " AND p.flag_pensiun = 0";
        }else{
            $whereKlause2 .= " AND p.flag_pensiun = 1";
        }
        if($jenjab=='Struktural'){
            $whereKlause2 .= " AND p.jenjab = 'Struktural' ";
        }else{
            $whereKlause2 .= " AND p.jenjab = 'Fungsional' ";
        }
        if($eselon!='0'){
            if($eselon=='Z'){
                $whereKlause2 .= " AND j.eselon IS NULL ";
            }else{
                $whereKlause2 .= " AND j.eselon = '".$eselon."' ";
            }
        }
        if($ddStsJmlKeluarga!='-1'){
            if($ddStsJmlKeluarga==1){
                $whereKlause3 .= " AND d.jml_keluarga_g = d.jml_keluarga ";
            }else{
                $whereKlause3 .= " AND d.jml_keluarga_g <> d.jml_keluarga ";
            }
        }
        if($ddStsJmlPasangan!='-1'){
            if($ddStsJmlPasangan==1){
                $whereKlause3 .= " AND d.jml_pasangan_g = d.jml_pasangan ";
            }else{
                $whereKlause3 .= " AND d.jml_pasangan_g <> d.jml_pasangan ";
            }
        }
        if($ddStsJmlAnak!='-1'){
            if($ddStsJmlAnak==1){
                $whereKlause3 .= " AND d.jml_anak_g = d.jml_anak ";
            }else{
                $whereKlause3 .= " AND d.jml_anak_g <> d.jml_anak ";
            }
        }
        if($ddStsJmlPasanganDapat!='-1'){
            if($ddStsJmlPasanganDapat==1){
                $whereKlause3 .= " AND d.jml_pasangan_tertunjang = d.pasangan_valid_dapat ";
            }else{
                $whereKlause3 .= " AND d.jml_pasangan_tertunjang <> d.pasangan_valid_dapat ";
            }
        }
        if($ddStsJmlAnakDapat!='-1'){
            if($ddStsJmlAnakDapat==1){
                $whereKlause3 .= " AND d.jml_anak_tertunjang = d.anak_valid_dapat ";
            }else{
                $whereKlause3 .= " AND d.jml_anak_tertunjang <> d.anak_valid_dapat ";
            }
        }
        if (!(trim($txtKeyword)== "") && !(trim($txtKeyword)== "0")) {
            $whereKlause2 .= " AND (p.nip_baru LIKE '%" . $txtKeyword . "%'
                                            OR p.nama LIKE '%" . $txtKeyword . "%'
                                            OR j.jabatan LIKE '%" . $txtKeyword . "%')";
        }
    }else{
        $whereKlause2 = "WHERE p.nip_baru IS NULL";
    }

    $sqlCountAll = "SELECT COUNT(*) as jumlah FROM
                (SELECT c.NIP, c.NAMAGAJI, c.TGLLHR, c.NMGOL, c.NMSTAPEG, c.TMTSTOP, c.jml_pasangan as jml_pasangan_g,
                c.jml_anak_kandung, c.jml_anak_tiri, c.jml_anak_angkat, c.jml_anak AS jml_anak_g, c.jml_lainnya as jml_lainnya_g,
                c.jml_keluarga as jml_keluarga_g, c.jml_pasangan_tertunjang, c.jml_anak_tertunjang,
                c.id_pegawai, c.nip_baru, c.nama_simpeg, c.nama_asli, c.tgl_lahir_p, c.pangkat_gol, c.flag_pensiun, c.status_aktif,
                c.tgl_pensiun_dini, c.jenjab, c.jabatan, c.eselon, c.unit, c.id_skpd,
                SUM(IF(c.id_status = 9,1,0)) as jml_pasangan, SUM(IF(c.id_status = 10,1,0)) as jml_anak,
                SUM(IF((c.id_status <> 9 AND c.id_status <> 10),1,0)) as jml_lainnya,
                COUNT(c.id_keluarga) AS jml_keluarga,
                SUM(IF(c.status_validasi = 'Valid',1,0)) as jml_valid,
                SUM(IF(c.status_validasi = 'Belum Valid / Tunjangan di Pasangan',1,0)) as jml_non_valid,
                SUM(IF(c.id_status = 9 AND c.status_validasi = 'Valid' AND c.status_tunjangan_skum = 'Dapat',1,0)) as pasangan_valid_dapat,
                SUM(IF(c.id_status = 10 AND c.status_validasi = 'Valid' AND c.status_tunjangan_skum = 'Dapat',1,0)) as anak_valid_dapat,
                CASE WHEN SUM(IF(c.status_validasi = 'Belum Valid / Tunjangan di Pasangan',1,0)) = 0 THEN
                1 ELSE (
                  CASE WHEN
                  (SUM(IF(c.id_status = 9 AND c.status_validasi = 'Valid' AND c.status_tunjangan_skum = 'Dapat',1,0)) +
                  SUM(IF(c.id_status = 10 AND c.status_validasi = 'Valid' AND c.status_tunjangan_skum = 'Dapat',1,0))) = 3
                  THEN 1 ELSE (CASE WHEN
                    (SUM(IF(c.id_status = 9 AND c.status_validasi = 'Valid' AND c.status_tunjangan_skum = 'Dapat',1,0)) +
                    SUM(IF(c.id_status = 10 AND c.status_validasi = 'Valid' AND c.status_tunjangan_skum = 'Dapat',1,0))) = 0
                  THEN 2 ELSE (CASE WHEN
                  (SUM(IF(c.id_status = 9 AND c.status_validasi = 'Valid' AND c.status_tunjangan_skum = 'Dapat',1,0)) <= 1 AND
                  SUM(IF(c.id_status = 10 AND c.status_validasi = 'Valid' AND c.status_tunjangan_skum = 'Dapat',1,0)) <= 2 AND
                  SUM(IF(c.id_status = 10,1,0)) > 2)
                  THEN 1 ELSE 3 END)END)
                  END)
                END as status_verifikasi
                FROM (
                SELECT b.*,
                  CASE WHEN b.status_tunjangan_skum = 'Dapat' AND (b.id_status_verifikasi = 1 OR b.id_status_verifikasi = 4
                  OR b.id_status_verifikasi = 5) THEN 'Valid' ELSE
                  (CASE WHEN b.status_tunjangan_skum = 'Tidak Dapat' AND (b.id_status_verifikasi = 2 OR b.id_status_verifikasi = 3
                  OR b.id_status_verifikasi = 6 OR b.id_status_verifikasi = 7 OR b.id_status_verifikasi = 8 OR b.id_status_verifikasi = 9
                  OR b.id_status_verifikasi = 10 OR b.id_status_verifikasi = 11)
                  THEN 'Valid' ELSE 'Belum Valid / Tunjangan di Pasangan' END)
                  END AS status_validasi
                  FROM (SELECT a.NIP, a.NAMAGAJI, a.TGLLHR, a.NMGOL, a.NMSTAPEG, a.TMTSTOP, a.jml_pasangan,
                 a.jml_anak_kandung, a.jml_anak_tiri, a.jml_anak_angkat, a.jml_anak, a.jml_lainnya,
                 a.jml_keluarga, a.jml_pasangan_tertunjang, a.jml_anak_tertunjang, a.id_pegawai, a.nip_baru,
                 a.nama_simpeg, a.nama_asli, a.tgl_lahir_p, a.pangkat_gol, a.flag_pensiun, a.status_aktif,
                 a.tgl_pensiun_dini, a.jenjab, a.jabatan, a.eselon, a.unit, a.id_skpd,
                 a.id_keluarga, a.id_status, a.status_keluarga, a.nama, a.tempat_lahir, a.tgl_lahir, a.pekerjaan,
                CASE WHEN a.jk = 1 THEN 'Laki-laki' ELSE 'Perempuan' END AS jenis_kelamin,
                CASE WHEN a.dapat_tunjangan = 0 THEN 'Tidak Dapat' ELSE 'Dapat' END AS status_tunjangan_skum, a.usia,
                CASE WHEN a.id_status = 9 THEN
                (CASE WHEN a.tgl_meninggal IS NOT NULL THEN 'Meninggal (Tidak Dapat)' ELSE
                  (CASE WHEN a.tgl_cerai IS NOT NULL THEN 'Cerai (Tidak Dapat)' ELSE
                    (CASE WHEN a.tgl_menikah IS NOT NULL THEN 'Menikah (Dapat)' ELSE 'Tgl. Menikah Blm Diisi' END) END) END)
                ELSE
                (CASE WHEN a.tgl_meninggal IS NOT NULL THEN 'Meninggal (Tidak Dapat)' ELSE
                  (CASE WHEN a.id_status = 10 THEN
                      (CASE WHEN a.usia < 21 THEN (CASE WHEN a.tgl_menikah IS NOT NULL THEN 'Anak < 21 Thn Menikah (Tidak Dapat)' ELSE
                  (CASE WHEN a.sudah_bekerja = 1 THEN 'Anak < 21 Thn Bekerja (Tidak Dapat)' ELSE 'Anak < 21 Thn (Dapat)' END) END) ELSE
                    (CASE WHEN (a.usia >= 21 AND a.usia < 25) THEN
                      (CASE WHEN a.kuliah = 1 THEN (CASE WHEN a.tgl_lulus IS NULL THEN 'Anak kuliah (Dapat)' ELSE 'Anak lulus kuliah (Tidak Dapat)' END) ELSE
                        'Anak tidak kuliah (Tidak Dapat)' END) ELSE 'Anak > 25 Thn (Tidak Dapat)' END) END)
                  ELSE 'Bukan Cakupan'END)
                 END)END AS status_verifikasi_data,
                CASE WHEN a.id_status = 9 THEN
                (CASE WHEN a.tgl_meninggal IS NOT NULL THEN DATE_FORMAT(a.tgl_meninggal, '%d/%m/%Y') ELSE
                  (CASE WHEN a.tgl_cerai IS NOT NULL THEN DATE_FORMAT(a.tgl_cerai, '%d/%m/%Y') ELSE
                    (CASE WHEN a.tgl_menikah IS NOT NULL THEN DATE_FORMAT(a.tgl_menikah, '%d/%m/%Y') ELSE NULL END) END) END)
                ELSE
                (CASE WHEN a.tgl_meninggal IS NOT NULL THEN DATE_FORMAT(a.tgl_meninggal, '%d/%m/%Y') ELSE
                  (CASE WHEN a.usia < 21 THEN (CASE WHEN a.tgl_menikah IS NOT NULL THEN a.tgl_menikah ELSE
                  (CASE WHEN a.sudah_bekerja = 1 THEN NULL ELSE NULL END) END) ELSE
                    (CASE WHEN (a.usia >= 21 AND a.usia < 25) THEN
                      (CASE WHEN a.kuliah = 1 THEN (CASE WHEN a.tgl_lulus IS NULL THEN NULL ELSE DATE_FORMAT(a.tgl_lulus, '%d/%m/%Y') END) ELSE
                        NULL END) ELSE NULL END) END) END)
                END AS ref_tanggal,
                CASE WHEN a.id_status = 9 THEN
                (CASE WHEN a.tgl_meninggal IS NOT NULL THEN a.akte_meninggal ELSE
                  (CASE WHEN a.tgl_cerai IS NOT NULL THEN a.akte_cerai ELSE
                    (CASE WHEN a.tgl_menikah IS NOT NULL THEN a.akte_menikah ELSE NULL END) END) END)
                ELSE
                (CASE WHEN a.tgl_meninggal IS NOT NULL THEN a.akte_meninggal ELSE
                  (CASE WHEN a.usia < 21 THEN (CASE WHEN a.tgl_menikah IS NOT NULL THEN a.akte_menikah ELSE
                  (CASE WHEN a.sudah_bekerja = 1 THEN a.akte_kerja ELSE NULL END) END) ELSE
                    (CASE WHEN (a.usia >= 21 AND a.usia < 25) THEN
                      (CASE WHEN a.kuliah = 1 THEN (CASE WHEN a.tgl_lulus IS NULL THEN NULL ELSE NULL END) ELSE
                        NULL END) ELSE NULL END) END) END)
                END AS ref_keterangan,
                CASE WHEN a.id_status = 9 THEN
                (CASE WHEN a.tgl_meninggal IS NOT NULL THEN 2 ELSE
                  (CASE WHEN a.tgl_cerai IS NOT NULL THEN 3 ELSE
                    (CASE WHEN a.tgl_menikah IS NOT NULL THEN 1 ELSE 0 END) END) END)
                ELSE
                (CASE WHEN a.tgl_meninggal IS NOT NULL THEN 6 ELSE
                  (CASE WHEN a.usia < 21 THEN (CASE WHEN a.tgl_menikah IS NOT NULL THEN 10 ELSE
                  (CASE WHEN a.sudah_bekerja = 1 THEN 11 ELSE 4 END) END) ELSE
                    (CASE WHEN (a.usia >= 21 AND a.usia < 25) THEN
                      (CASE WHEN a.kuliah = 1 THEN (CASE WHEN a.tgl_lulus IS NULL THEN 5 ELSE 7 END) ELSE
                        8 END) ELSE 9 END) END) END)
                END AS id_status_verifikasi
                FROM (SELECT xy.*, CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
                p.nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(' ',p.gelar_belakang) END) AS nama_simpeg,
                p.id_pegawai, p.nip_baru, p.nama as nama_asli, DATE_FORMAT(p.tgl_lahir, '%d-%m-%Y') AS tgl_lahir_p, p.pangkat_gol, p.flag_pensiun,
                p.status_aktif, DATE_FORMAT(p.tgl_pensiun_dini, '%d-%m-%Y') AS tgl_pensiun_dini,
                p.jenjab, CASE WHEN p.jenjab = 'Fungsional' THEN p.jabatan ELSE CASE WHEN p.id_j IS NULL THEN
                (SELECT jm.nama_jfu AS jabatan
                FROM jfu_pegawai jp, jfu_master jm
                WHERE jp.kode_jabatan = jm.kode_jabatan AND jp.id_pegawai = p.id_pegawai LIMIT 1)
                ELSE j.jabatan END END AS jabatan, j.eselon, uk.nama_baru as unit, uk.id_skpd,
                k.id_keluarga, k.id_status, sk.status_keluarga, k.nama, k.tempat_lahir, k.tgl_lahir, k.pekerjaan, k.jk, k.dapat_tunjangan,
                ROUND(DATEDIFF(CURRENT_DATE, DATE_FORMAT(k.tgl_lahir, '%Y/%m/%d'))/365,2) AS usia,
                k.tgl_menikah, k.akte_menikah, k.tgl_meninggal, k.akte_meninggal, k.tgl_cerai, k.akte_cerai,
                k.kuliah, k.tgl_lulus, k.sudah_bekerja, k.akte_kerja
                FROM
                (
                SELECT gm.NIP, gm.NAMA AS NAMAGAJI, DATE_FORMAT(gm.TGLLHR, '%d-%m-%Y') AS TGLLHR, gpt.NMGOL, gst.NMSTAPEG,
                DATE_FORMAT(gm.TMTSTOP, '%d-%m-%Y') AS TMTSTOP,
                COUNT(CASE WHEN (LOWER(ht.NMHUBKEL) LIKE 'isteri / suami%') THEN k.NMKEL END) AS jml_pasangan,
                COUNT(CASE WHEN (LOWER(ht.NMHUBKEL) REGEXP 'anak+$')
                  AND (LOWER(ht.NMHUBKEL) NOT LIKE '%tiri%')
                  AND (LOWER(ht.NMHUBKEL) NOT LIKE '%angkat%') THEN k.NMKEL END) AS jml_anak_kandung,
                COUNT(CASE WHEN (LOWER(ht.NMHUBKEL) LIKE 'anak tiri%') THEN k.NMKEL END) AS jml_anak_tiri,
                COUNT(CASE WHEN (LOWER(ht.NMHUBKEL) LIKE 'anak angkat%') THEN k.NMKEL END) AS jml_anak_angkat,
                (COUNT(CASE WHEN (LOWER(ht.NMHUBKEL) REGEXP 'anak+$')
                  AND (LOWER(ht.NMHUBKEL) NOT LIKE '%tiri%')
                  AND (LOWER(ht.NMHUBKEL) NOT LIKE '%angkat%') THEN k.NMKEL END) +
                COUNT(CASE WHEN (LOWER(ht.NMHUBKEL) LIKE 'anak tiri%') THEN k.NMKEL END) +
                COUNT(CASE WHEN (LOWER(ht.NMHUBKEL) LIKE 'anak angkat%') THEN k.NMKEL END)) AS jml_anak,
                COUNT(CASE WHEN (LOWER(ht.NMHUBKEL) LIKE '%lain-lain%') THEN k.NMKEL END) AS jml_lainnya,
                (
                  SUM(CASE WHEN (LOWER(ht.NMHUBKEL) LIKE 'isteri / suami%') THEN 1 ELSE 0 END) +
                  COUNT(CASE WHEN (LOWER(ht.NMHUBKEL) REGEXP 'anak+$')
                  AND (LOWER(ht.NMHUBKEL) NOT LIKE '%tiri%')
                  AND (LOWER(ht.NMHUBKEL) NOT LIKE '%angkat%') THEN k.NMKEL END) +
                  COUNT(CASE WHEN (LOWER(ht.NMHUBKEL) LIKE 'anak tiri%') THEN k.NMKEL END) +
                  COUNT(CASE WHEN (LOWER(ht.NMHUBKEL) LIKE 'anak angkat%') THEN k.NMKEL END) +
                  COUNT(CASE WHEN (LOWER(ht.NMHUBKEL) LIKE '%lain-lain%') THEN k.NMKEL END)
                ) AS jml_keluarga,
                SUM(CASE WHEN ((LOWER(ht.NMHUBKEL) LIKE 'isteri / suami%') AND k.KDTUNJANG = 2) THEN 1 ELSE 0 END) AS jml_pasangan_tertunjang,
                SUM(CASE WHEN ((LOWER(ht.NMHUBKEL) LIKE 'anak%') AND k.KDTUNJANG = 2) THEN 1 ELSE 0 END) AS jml_anak_tertunjang
                FROM gaji_mstpegawai gm
                LEFT JOIN gaji_keluarga k ON gm.NIP = k.NIP AND k.KDHUBKEL <> '00'
                LEFT JOIN gaji_hubkel_tbl ht ON k.KDHUBKEL = ht.KDHUBKEL
                LEFT JOIN gaji_pangkat_tbl gpt ON gm.KDPANGKAT = gpt.KDPANGKAT
                LEFT JOIN gaji_stapeg_tbl gst ON gm.KDSTAPEG = gst.KDSTAPEG
                $whereKlause1 AND gm.KDSTAPEG NOT IN (1,2,22,11)
                GROUP BY gm.NIP
                ) xy
                LEFT JOIN pegawai p ON xy.NIP = p.nip_baru
                LEFT JOIN jabatan j ON p.id_j = j.id_j
                LEFT JOIN current_lokasi_kerja clk ON p.id_pegawai = clk.id_pegawai
                LEFT JOIN unit_kerja uk ON clk.id_unit_kerja = uk.id_unit_kerja
                LEFT JOIN keluarga k ON p.id_pegawai = k.id_pegawai
                LEFT JOIN status_kel sk ON k.id_status = sk.id_status
                $whereKlause2) a) b ORDER BY b.id_status, b.tgl_lahir, b.nama) c
                GROUP BY c.NIP, c.NAMAGAJI, c.TGLLHR) d
                WHERE d.NIP IS NOT NULL $whereKlause3
                ORDER BY d.eselon, d.pangkat_gol DESC, d.nama_asli ASC";
    //echo $sqlCountAll;
    $query = $mysqli->query($sqlCountAll);
    if ($query->num_rows > 0) {
        while ($data = $query->fetch_array(MYSQLI_NUM)) {
            $jmlData = $data[0];
        }
    }

    if ($jmlData > 0) {
        $pages->items_total = $jmlData;
        $pages->paginate();
        $pgDisplay = $pages->display_pages();
        $itemPerPage = $pages->display_items_per_page();
        $curpage = $pages->current_page;
        $numpage = $pages->num_pages;
        $jumppage = $pages->display_jump_menu();
        $rowperpage = $pages->display_items_per_page();
    }else{
        $pgDisplay = '';
        $itemPerPage = '';
        $curpage = '';
        $numpage = '';
        $jumppage = '';
        $rowperpage = '';
    }

    if($pagePaging == 1){
        $start_number = 0;
    }else{
        $start_number = ($pagePaging * $ipp) - $ipp;
    }

    $sqlData = "SELECT d.* FROM
                (SELECT c.NIP, c.NAMAGAJI, c.TGLLHR, c.NMGOL, c.NMSTAPEG, c.TMTSTOP, c.jml_pasangan as jml_pasangan_g,
                c.jml_anak_kandung, c.jml_anak_tiri, c.jml_anak_angkat, c.jml_anak AS jml_anak_g, c.jml_lainnya as jml_lainnya_g,
                c.jml_keluarga as jml_keluarga_g, c.jml_pasangan_tertunjang, c.jml_anak_tertunjang,
                c.id_pegawai, c.nip_baru, c.nama_simpeg, c.nama_asli, c.tgl_lahir_p, c.pangkat_gol, c.flag_pensiun, c.status_aktif,
                c.tgl_pensiun_dini, c.jenjab, c.jabatan, c.eselon, c.unit, c.id_skpd,
                SUM(IF(c.id_status = 9,1,0)) as jml_pasangan, SUM(IF(c.id_status = 10,1,0)) as jml_anak,
                SUM(IF((c.id_status <> 9 AND c.id_status <> 10),1,0)) as jml_lainnya,
                COUNT(c.id_keluarga) AS jml_keluarga,
                SUM(IF(c.status_validasi = 'Valid',1,0)) as jml_valid,
                SUM(IF(c.status_validasi = 'Belum Valid / Tunjangan di Pasangan',1,0)) as jml_non_valid,
                SUM(IF(c.id_status = 9 AND c.status_validasi = 'Valid' AND c.status_tunjangan_skum = 'Dapat',1,0)) as pasangan_valid_dapat,
                SUM(IF(c.id_status = 10 AND c.status_validasi = 'Valid' AND c.status_tunjangan_skum = 'Dapat',1,0)) as anak_valid_dapat,
                CASE WHEN SUM(IF(c.status_validasi = 'Belum Valid / Tunjangan di Pasangan',1,0)) = 0 THEN
                1 ELSE (
                  CASE WHEN
                  (SUM(IF(c.id_status = 9 AND c.status_validasi = 'Valid' AND c.status_tunjangan_skum = 'Dapat',1,0)) +
                  SUM(IF(c.id_status = 10 AND c.status_validasi = 'Valid' AND c.status_tunjangan_skum = 'Dapat',1,0))) = 3
                  THEN 1 ELSE (CASE WHEN
                    (SUM(IF(c.id_status = 9 AND c.status_validasi = 'Valid' AND c.status_tunjangan_skum = 'Dapat',1,0)) +
                    SUM(IF(c.id_status = 10 AND c.status_validasi = 'Valid' AND c.status_tunjangan_skum = 'Dapat',1,0))) = 0
                  THEN 2 ELSE (CASE WHEN
                  (SUM(IF(c.id_status = 9 AND c.status_validasi = 'Valid' AND c.status_tunjangan_skum = 'Dapat',1,0)) <= 1 AND
                  SUM(IF(c.id_status = 10 AND c.status_validasi = 'Valid' AND c.status_tunjangan_skum = 'Dapat',1,0)) <= 2 AND
                  SUM(IF(c.id_status = 10,1,0)) > 2)
                  THEN 1 ELSE 3 END)END)
                  END)
                END as status_verifikasi, DATE_FORMAT(c.tmt, '%d-%m-%Y') AS tmt
                FROM (
                SELECT b.*,
                  CASE WHEN b.status_tunjangan_skum = 'Dapat' AND (b.id_status_verifikasi = 1 OR b.id_status_verifikasi = 4
                  OR b.id_status_verifikasi = 5) THEN 'Valid' ELSE
                  (CASE WHEN b.status_tunjangan_skum = 'Tidak Dapat' AND (b.id_status_verifikasi = 2 OR b.id_status_verifikasi = 3
                  OR b.id_status_verifikasi = 6 OR b.id_status_verifikasi = 7 OR b.id_status_verifikasi = 8 OR b.id_status_verifikasi = 9
                  OR b.id_status_verifikasi = 10 OR b.id_status_verifikasi = 11)
                  THEN 'Valid' ELSE 'Belum Valid / Tunjangan di Pasangan' END)
                  END AS status_validasi
                  FROM (SELECT a.NIP, a.NAMAGAJI, a.TGLLHR, a.NMGOL, a.NMSTAPEG, a.TMTSTOP, a.jml_pasangan,
                 a.jml_anak_kandung, a.jml_anak_tiri, a.jml_anak_angkat, a.jml_anak, a.jml_lainnya,
                 a.jml_keluarga, a.jml_pasangan_tertunjang, a.jml_anak_tertunjang, a.id_pegawai, a.nip_baru,
                 a.nama_simpeg, a.nama_asli, a.tgl_lahir_p, a.pangkat_gol, a.flag_pensiun, a.status_aktif,
                 a.tgl_pensiun_dini, a.jenjab, a.jabatan, a.eselon, a.unit, a.id_skpd,
                 a.id_keluarga, a.id_status, a.status_keluarga, a.nama, a.tempat_lahir, a.tgl_lahir, a.pekerjaan,
                CASE WHEN a.jk = 1 THEN 'Laki-laki' ELSE 'Perempuan' END AS jenis_kelamin,
                CASE WHEN a.dapat_tunjangan = 0 THEN 'Tidak Dapat' ELSE 'Dapat' END AS status_tunjangan_skum, a.usia,
                CASE WHEN a.id_status = 9 THEN
                (CASE WHEN a.tgl_meninggal IS NOT NULL THEN 'Meninggal (Tidak Dapat)' ELSE
                  (CASE WHEN a.tgl_cerai IS NOT NULL THEN 'Cerai (Tidak Dapat)' ELSE
                    (CASE WHEN a.tgl_menikah IS NOT NULL THEN 'Menikah (Dapat)' ELSE 'Tgl. Menikah Blm Diisi' END) END) END)
                ELSE
                (CASE WHEN a.tgl_meninggal IS NOT NULL THEN 'Meninggal (Tidak Dapat)' ELSE
                  (CASE WHEN a.id_status = 10 THEN
                      (CASE WHEN a.usia < 21 THEN (CASE WHEN a.tgl_menikah IS NOT NULL THEN 'Anak < 21 Thn Menikah (Tidak Dapat)' ELSE
                  (CASE WHEN a.sudah_bekerja = 1 THEN 'Anak < 21 Thn Bekerja (Tidak Dapat)' ELSE 'Anak < 21 Thn (Dapat)' END) END) ELSE
                    (CASE WHEN (a.usia >= 21 AND a.usia < 25) THEN
                      (CASE WHEN a.kuliah = 1 THEN (CASE WHEN a.tgl_lulus IS NULL THEN 'Anak kuliah (Dapat)' ELSE 'Anak lulus kuliah (Tidak Dapat)' END) ELSE
                        'Anak tidak kuliah (Tidak Dapat)' END) ELSE 'Anak > 25 Thn (Tidak Dapat)' END) END)
                  ELSE 'Bukan Cakupan'END)
                 END)END AS status_verifikasi_data,
                CASE WHEN a.id_status = 9 THEN
                (CASE WHEN a.tgl_meninggal IS NOT NULL THEN DATE_FORMAT(a.tgl_meninggal, '%d/%m/%Y') ELSE
                  (CASE WHEN a.tgl_cerai IS NOT NULL THEN DATE_FORMAT(a.tgl_cerai, '%d/%m/%Y') ELSE
                    (CASE WHEN a.tgl_menikah IS NOT NULL THEN DATE_FORMAT(a.tgl_menikah, '%d/%m/%Y') ELSE NULL END) END) END)
                ELSE
                (CASE WHEN a.tgl_meninggal IS NOT NULL THEN DATE_FORMAT(a.tgl_meninggal, '%d/%m/%Y') ELSE
                  (CASE WHEN a.usia < 21 THEN (CASE WHEN a.tgl_menikah IS NOT NULL THEN a.tgl_menikah ELSE
                  (CASE WHEN a.sudah_bekerja = 1 THEN NULL ELSE NULL END) END) ELSE
                    (CASE WHEN (a.usia >= 21 AND a.usia < 25) THEN
                      (CASE WHEN a.kuliah = 1 THEN (CASE WHEN a.tgl_lulus IS NULL THEN NULL ELSE DATE_FORMAT(a.tgl_lulus, '%d/%m/%Y') END) ELSE
                        NULL END) ELSE NULL END) END) END)
                END AS ref_tanggal,
                CASE WHEN a.id_status = 9 THEN
                (CASE WHEN a.tgl_meninggal IS NOT NULL THEN a.akte_meninggal ELSE
                  (CASE WHEN a.tgl_cerai IS NOT NULL THEN a.akte_cerai ELSE
                    (CASE WHEN a.tgl_menikah IS NOT NULL THEN a.akte_menikah ELSE NULL END) END) END)
                ELSE
                (CASE WHEN a.tgl_meninggal IS NOT NULL THEN a.akte_meninggal ELSE
                  (CASE WHEN a.usia < 21 THEN (CASE WHEN a.tgl_menikah IS NOT NULL THEN a.akte_menikah ELSE
                  (CASE WHEN a.sudah_bekerja = 1 THEN a.akte_kerja ELSE NULL END) END) ELSE
                    (CASE WHEN (a.usia >= 21 AND a.usia < 25) THEN
                      (CASE WHEN a.kuliah = 1 THEN (CASE WHEN a.tgl_lulus IS NULL THEN NULL ELSE NULL END) ELSE
                        NULL END) ELSE NULL END) END) END)
                END AS ref_keterangan,
                CASE WHEN a.id_status = 9 THEN
                (CASE WHEN a.tgl_meninggal IS NOT NULL THEN 2 ELSE
                  (CASE WHEN a.tgl_cerai IS NOT NULL THEN 3 ELSE
                    (CASE WHEN a.tgl_menikah IS NOT NULL THEN 1 ELSE 0 END) END) END)
                ELSE
                (CASE WHEN a.tgl_meninggal IS NOT NULL THEN 6 ELSE
                  (CASE WHEN a.usia < 21 THEN (CASE WHEN a.tgl_menikah IS NOT NULL THEN 10 ELSE
                  (CASE WHEN a.sudah_bekerja = 1 THEN 11 ELSE 4 END) END) ELSE
                    (CASE WHEN (a.usia >= 21 AND a.usia < 25) THEN
                      (CASE WHEN a.kuliah = 1 THEN (CASE WHEN a.tgl_lulus IS NULL THEN 5 ELSE 7 END) ELSE
                        8 END) ELSE 9 END) END) END)
                END AS id_status_verifikasi, a.tmt 
                FROM (
                SELECT z.* FROM (
                SELECT xy.*, CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
                p.nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(' ',p.gelar_belakang) END) AS nama_simpeg,
                p.id_pegawai, p.nip_baru, p.nama as nama_asli, DATE_FORMAT(p.tgl_lahir, '%d-%m-%Y') AS tgl_lahir_p, p.pangkat_gol, p.flag_pensiun,
                p.status_aktif, DATE_FORMAT(p.tgl_pensiun_dini, '%d-%m-%Y') AS tgl_pensiun_dini,
                p.jenjab, CASE WHEN p.jenjab = 'Fungsional' THEN p.jabatan ELSE CASE WHEN p.id_j IS NULL THEN
                (SELECT jm.nama_jfu AS jabatan
                FROM jfu_pegawai jp, jfu_master jm
                WHERE jp.kode_jabatan = jm.kode_jabatan AND jp.id_pegawai = p.id_pegawai LIMIT 1)
                ELSE j.jabatan END END AS jabatan, j.eselon, uk.nama_baru as unit, uk.id_skpd,
                k.id_keluarga, k.id_status, sk.status_keluarga, k.nama, k.tempat_lahir, k.tgl_lahir, k.pekerjaan, k.jk, k.dapat_tunjangan,
                ROUND(DATEDIFF(CURRENT_DATE, DATE_FORMAT(k.tgl_lahir, '%Y/%m/%d'))/365,2) AS usia,
                k.tgl_menikah, k.akte_menikah, k.tgl_meninggal, k.akte_meninggal, k.tgl_cerai, k.akte_cerai,
                k.kuliah, k.tgl_lulus, k.sudah_bekerja, k.akte_kerja, s.tmt 
                FROM
                (
                SELECT gm.NIP, gm.NAMA AS NAMAGAJI, DATE_FORMAT(gm.TGLLHR, '%d-%m-%Y') AS TGLLHR, gpt.NMGOL, gst.NMSTAPEG,
                DATE_FORMAT(gm.TMTSTOP, '%d-%m-%Y') AS TMTSTOP,
                COUNT(CASE WHEN (LOWER(ht.NMHUBKEL) LIKE 'isteri / suami%') THEN k.NMKEL END) AS jml_pasangan,
                COUNT(CASE WHEN (LOWER(ht.NMHUBKEL) REGEXP 'anak+$')
                  AND (LOWER(ht.NMHUBKEL) NOT LIKE '%tiri%')
                  AND (LOWER(ht.NMHUBKEL) NOT LIKE '%angkat%') THEN k.NMKEL END) AS jml_anak_kandung,
                COUNT(CASE WHEN (LOWER(ht.NMHUBKEL) LIKE 'anak tiri%') THEN k.NMKEL END) AS jml_anak_tiri,
                COUNT(CASE WHEN (LOWER(ht.NMHUBKEL) LIKE 'anak angkat%') THEN k.NMKEL END) AS jml_anak_angkat,
                (COUNT(CASE WHEN (LOWER(ht.NMHUBKEL) REGEXP 'anak+$')
                  AND (LOWER(ht.NMHUBKEL) NOT LIKE '%tiri%')
                  AND (LOWER(ht.NMHUBKEL) NOT LIKE '%angkat%') THEN k.NMKEL END) +
                COUNT(CASE WHEN (LOWER(ht.NMHUBKEL) LIKE 'anak tiri%') THEN k.NMKEL END) +
                COUNT(CASE WHEN (LOWER(ht.NMHUBKEL) LIKE 'anak angkat%') THEN k.NMKEL END)) AS jml_anak,
                COUNT(CASE WHEN (LOWER(ht.NMHUBKEL) LIKE '%lain-lain%') THEN k.NMKEL END) AS jml_lainnya,
                (
                  SUM(CASE WHEN (LOWER(ht.NMHUBKEL) LIKE 'isteri / suami%') THEN 1 ELSE 0 END) +
                  COUNT(CASE WHEN (LOWER(ht.NMHUBKEL) REGEXP 'anak+$')
                  AND (LOWER(ht.NMHUBKEL) NOT LIKE '%tiri%')
                  AND (LOWER(ht.NMHUBKEL) NOT LIKE '%angkat%') THEN k.NMKEL END) +
                  COUNT(CASE WHEN (LOWER(ht.NMHUBKEL) LIKE 'anak tiri%') THEN k.NMKEL END) +
                  COUNT(CASE WHEN (LOWER(ht.NMHUBKEL) LIKE 'anak angkat%') THEN k.NMKEL END) +
                  COUNT(CASE WHEN (LOWER(ht.NMHUBKEL) LIKE '%lain-lain%') THEN k.NMKEL END)
                ) AS jml_keluarga,
                SUM(CASE WHEN ((LOWER(ht.NMHUBKEL) LIKE 'isteri / suami%') AND k.KDTUNJANG = 2) THEN 1 ELSE 0 END) AS jml_pasangan_tertunjang,
                SUM(CASE WHEN ((LOWER(ht.NMHUBKEL) LIKE 'anak%') AND k.KDTUNJANG = 2) THEN 1 ELSE 0 END) AS jml_anak_tertunjang
                FROM gaji_mstpegawai gm
                LEFT JOIN gaji_keluarga k ON gm.NIP = k.NIP AND k.KDHUBKEL <> '00'
                LEFT JOIN gaji_hubkel_tbl ht ON k.KDHUBKEL = ht.KDHUBKEL
                LEFT JOIN gaji_pangkat_tbl gpt ON gm.KDPANGKAT = gpt.KDPANGKAT
                LEFT JOIN gaji_stapeg_tbl gst ON gm.KDSTAPEG = gst.KDSTAPEG
                $whereKlause1 AND gm.KDSTAPEG NOT IN (1,2,22,11)
                GROUP BY gm.NIP
                ) xy
                LEFT JOIN pegawai p ON xy.NIP = p.nip_baru
                LEFT JOIN jabatan j ON p.id_j = j.id_j
                LEFT JOIN current_lokasi_kerja clk ON p.id_pegawai = clk.id_pegawai
                LEFT JOIN unit_kerja uk ON clk.id_unit_kerja = uk.id_unit_kerja
                LEFT JOIN keluarga k ON p.id_pegawai = k.id_pegawai
                LEFT JOIN status_kel sk ON k.id_status = sk.id_status
                LEFT JOIN sk s ON p.pangkat_gol = s.gol AND p.id_pegawai = s.id_pegawai AND s.id_kategori_sk = 5
                $whereKlause2) z GROUP BY z.id_keluarga
                ) a) b ORDER BY b.id_status, b.tgl_lahir, b.nama) c
                GROUP BY c.NIP, c.NAMAGAJI, c.TGLLHR) d
                WHERE d.NIP IS NOT NULL $whereKlause3
                ORDER BY d.eselon, d.pangkat_gol DESC, d.nama_asli ASC ".$pages->limit;
    //echo $sqlData;
    $query = $mysqli->query($sqlData);

    if ($query->num_rows > 0) {
    if ($numpage > 0) {
        echo "Halaman ke $curpage dari $numpage | Jumlah Data : $jmlData | $jumppage | $rowperpage<br>";
        echo $pgDisplay;
    }
    $i = 0;
?>
    <table id="list_pegawai" cellspacing="0" width="100%" class="table" style="margin-top: 10px;">
        <thead>
        <tr style='border-top: solid 2px #000000;'>
            <td colspan="4"><span style="color:saddlebrown; font-weight: bold;">SIMGAJI</span></td>
            <td colspan="3" style="border-left: solid 1px #c0c2bb;color: #0000CC;"><strong>SIMPEG</strong></td>
        </tr>
        <tr style='border-bottom: solid 2px #2cc256;'>
            <td>No</td>
            <td style="text-align: center;">NIP</td>
            <td>Nama</td>
            <td>Status</td>
            <td style="border-left: solid 1px #c0c2bb">Nama</td>
            <td>Status</td>
            <td>Unit</td>
        </tr>
        </thead>
        <tbody>
        <?php
            while ($oto = $query->fetch_array(MYSQLI_BOTH)) {
                $i++;
                echo "<tr ".(($i%2)==0?"style='background-color:#FFFFFF'":"style='background-color: #F9F9F9'").">";
                echo "<td>".((int)$start_number+$i)."</td><td><strong>$oto[0]</strong>
                <br><a href=\"javascript:void(0);\" onclick=\"cekLebihLanjutSimGaji('$oto[0]', '$oto[1]',$oto[15]);\" class='btn btn-success btn-xs' style='margin-right:-10px;margin-top: 2px;'>Lihat Detail</a>
                </td><td>$oto[1]</td><td>$oto[4]</td>";
                echo "<td style=\"border-left: solid 1px #c0c2bb\">$oto[17]</td><td>$oto[22]</td><td>$oto[27]</td></tr>";
                echo "<tr ".(($i%2)==0?"style='background-color:#FFFFFF'":"style='background-color: #F9F9F9'").">";
                echo "<td style='border-top: 0px;'></td><td colspan='3' style='border-top: 0px;text-align: left;font-size: small;'>
                <div class='row' style='border: solid 1px #c0c2bb; background: #eff0e7;padding: 2px;width: 100%;margin-left: 0px;'>
                <div class='col-md-5'>Tgl. Lahir : $oto[2]<br>Gol. : <span style='color: red;font-weight: bold;'>$oto[3]</span>
                <br>Tgl. Pensiun : $oto[5]
                </div>
                <div class='col-md-7' style='text-align: left;'>
                    <span style='font-weight: bold; text-decoration: underline;'>Keluarga ($oto[12])</span> <br>
                    <ul style='margin-left: -20px;'>
                    <li>Pasangan: $oto[6]. Tertunjang: $oto[13]</li>
                    <li>Anak: $oto[10] (Kandung: $oto[7], Tiri: $oto[8], Angkat: $oto[9]). Tertunjang: $oto[14]</li>
                    <li>Lainnya: $oto[11]</li>
                    </ul>
                </div></div></td>
                <td colspan='3' style='border-top: 0px;text-align: left;font-size: small;border-left: solid 1px #c0c2bb'>
                <div class='row' style='border: solid 1px #c0c2bb; background: #eff0e7;padding: 2px;width: 100%;margin-left: 0px;'>".
                    ($oto[15]==''?'Tidak ditemukan<br>&nbsp;<br>&nbsp;<br>&nbsp;':"
                <div class='col-md-5'>Tgl. Lahir : $oto[19]<br>Gol. : <span style='color: red;font-weight: bold;'>$oto[20]</span> ($oto[tmt])<br>Tgl. Pensiun : $oto[23]
                </div>
                <div class='col-md-7'>
                    $oto[25]<br><span style='font-weight: bold; text-decoration: underline;'>Keluarga ($oto[32])</span> <br>
                    <ul style='margin-left: -20px;'>
                        <li>Pasangan: $oto[29]. Tertunjang: $oto[35]</li>
                        <li>Anak: $oto[30]. Tertunjang: $oto[36]</li>
                        <li>Lainnya: $oto[31]</li>
                    </ul>
                </div>").
                "</div></td></tr>";
            }
        ?>
        </tbody>
    </table>
<?php
        if($numpage > 0){
            echo "Halaman ke $curpage dari $numpage | Jumlah Data : $jmlData | $jumppage | $rowperpage<br>";
            echo $pgDisplay;
        }
    }else{
        echo '<div style="padding: 10px;">Tidak ada data</div>';
    }
?>
</div>

<div class="modal fade" id="modalInfoLanjut" role="dialog">
    <div class="modal-dialog modal-lg" style="max-height: 450px;">
        <div class="modal-content">
            <div class="modal-header" style="border-bottom: 2px solid darkolivegreen;">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 id="jdlTabel" class="modal-title" style="border: 0px;">Detail Informasi Pegawai</h4>
            </div>
            <div class="modal-body" style="height: 450px; width: 100%;">
                <div id="winInfoLanjut" style="margin-top: -10px;"></div>
            </div>
            <div class="modal-footer">
                <button id="btnClose" type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    function cekLebihLanjutSimGaji(nip,nama,idp){
        $("#winInfoLanjut").html("Loading...");
        var request = $.get("ptk_info_detail_pegawai.php?idpegawai="+idp+"&nip="+nip+"&nama_gaji="+nama);

        request.pipe(
            function( response ){
                if (response.success){
                    return( response );
                }else{
                    return(
                        $.Deferred().reject( response )
                    );
                }
            },
            function( response ){
                return({
                    success: false,
                    data: null,
                    errors: [ "Unexpected error: " + response.status + " " + response.statusText ]
                });
            }
        );
        request.then(
            function( response ){
                $("#winInfoLanjut").html(response);
            }
        );
        $("#modalInfoLanjut").modal('show');
    }


</script>