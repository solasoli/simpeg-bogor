<?php
class ipp_asn_model extends CI_Model
{
    public function __construct()
    {

    }

    public function getNamaSKPD($idskpd){
        $sql = "SELECT uk.nama_baru FROM unit_kerja uk WHERE uk.id_unit_kerja = ".$idskpd;
        $query = $this->db->query($sql);
        $nm = $query->row()->nama_baru;
        return $nm;
    }

    public function getNamaPejabat($idskpd){
        $sql = "SELECT j.id_j, uk.nama_baru, p.id_pegawai, j.eselon, p.nip_baru,
                CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
                nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(' ',p.gelar_belakang) END) AS nama
                FROM pegawai p, jabatan j, current_lokasi_kerja clk, unit_kerja uk
                WHERE p.flag_pensiun = 0 AND p.id_j = j.id_j AND p.id_pegawai = clk.id_pegawai AND
                clk.id_unit_kerja = uk.id_unit_kerja AND uk.id_skpd = ".$idskpd."
                ORDER BY j.eselon LIMIT 1";
        $query = $this->db->query($sql);
        $data['nip'] = $query->row()->nip_baru;
        $data['nama'] = $query->row()->nama;
        return $data;
    }

    public function getListPejabat($idskpd){
        $sql = "SELECT j.id_j, p.id_pegawai
                FROM pegawai p, jabatan j, current_lokasi_kerja clk, unit_kerja uk
                WHERE p.flag_pensiun = 0 AND p.id_j = j.id_j AND p.id_pegawai = clk.id_pegawai AND
                clk.id_unit_kerja = uk.id_unit_kerja AND uk.id_skpd = ".$idskpd;
        $query = $this->db->query($sql);
        $data = null;
        foreach ($query->result() as $row)
        {
            $data[] = $row;
        }
        return $data;
    }

    public function getKompetensiKinerja($idskpd, $idj, $idpegawai){
        $sql = "SELECT
                    kompetensi.*,
                    ik.flag_pendidikan,
                    ik.flag_pelatihan,
                    ik.flag_pengalaman,
                    ik.flag_administrasi,
                    ik.skor AS skor_gap_asn,
                    ns.nilai AS nilai_skp
                    FROM (SELECT
                    datax.*,
                    GROUP_CONCAT(DISTINCT tupok.tugas ORDER BY tupok.idf ASC SEPARATOR '\r\n') AS tugas,
                    GROUP_CONCAT(DISTINCT sekol.pendidikan ORDER BY sekol.level_p ASC SEPARATOR '\r\n') AS pendidikan,
                    GROUP_CONCAT(DISTINCT diklat.pelatihan ORDER BY diklat.tgl_diklat DESC SEPARATOR '\r\n') AS pelatihan,
                    GROUP_CONCAT(DISTINCT pengalaman.daftar_jab ORDER BY pengalaman.tgl_masuk DESC SEPARATOR '\r\n') AS pengalaman,
                    GROUP_CONCAT(DISTINCT administrasi.nama_diklat ORDER BY administrasi.tgl_diklat DESC SEPARATOR '\r\n') AS administrasi
                    FROM (SELECT
                    e.id_pegawai,
                    e.nip_baru,
                    e.nama,
                    e.pangkat_gol,
                    e.jabatan,
                    e.eselon,
                    e.unit_kerja,
                    e.id_j
                    FROM (SELECT
                    p.id_pegawai,
                    p.nip_baru,
                    CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
                    nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(' ', p.gelar_belakang) END) AS nama,
                    p.pangkat_gol,
                    a.jabatan,
                    a.eselon,
                    a.nama_baru AS unit_kerja,
                    a.id_j,
                    a.id_bos,
                    a.tahun,
                    a.id_skpd
                    FROM (SELECT
                    uk.id_unit_kerja,
                    uk.nama_baru,
                    j.jabatan,
                    j.eselon,
                    j.id_j,
                    j.id_bos,
                    j.tahun,
                    uk.id_skpd
                    FROM unit_kerja uk,
                    jabatan j
                    WHERE uk.tahun = 2017
                    AND uk.id_unit_kerja = j.id_unit_kerja
                    AND j.jabatan != 'Walikota Bogor'
                    AND j.jabatan != 'Wakil Walikota Bogor'
                    ORDER BY uk.nama_baru ASC) a
                    LEFT JOIN pegawai p
                    ON a.id_j = p.id_j
                    AND (p.flag_pensiun = 0)
                    ORDER BY a.id_unit_kerja ASC, a.eselon ASC) e
                    WHERE e.nip_baru IS NOT NULL
                    AND e.pangkat_gol IS NOT NULL
                    AND e.id_skpd = $idskpd
                    AND e.id_pegawai = $idpegawai
                    ORDER BY e.eselon ASC, e.pangkat_gol DESC, e.nama ASC) datax
                    LEFT JOIN (SELECT
                    task.id_j,
                    CONCAT(task.rank, ') ', task.tugas) AS tugas,
                    idf
                    FROM (SELECT
                    id_j,
                    CASE id_j WHEN @curIdj THEN @curRow2 := @curRow2 + 1 ELSE @curRow2 := 1 END AS rank,
                    t.tugas,
                    @curIdj := id_j AS idj,
                    idf
                    FROM (SELECT
                    id_j,
                    tugas,
                    id AS idf
                    FROM tupoksi
                    WHERE id_j = $idj) t
                    JOIN (SELECT
                    @curRow2 := 0,
                    @curIdj := 0) r2
                    ORDER BY idf) task) tupok
                    ON datax.id_j = tupok.id_j
                    AND tupok.id_j = datax.id_j
                    LEFT JOIN (SELECT
                    univ.id_pegawai,
                    CONCAT(univ.rank, ') ', univ.pendidikan) AS pendidikan,
                    univ.level_p
                    FROM (SELECT
                    id_pegawai,
                    CASE id_pegawai WHEN @curIdp THEN @curRow := @curRow + 1 ELSE @curRow := 1 END AS rank,
                    pnd.pendidikan,
                    @curIdp := id_pegawai AS idp,
                    pnd.level_p
                    FROM (SELECT
                    pend.id_pegawai,
                    pend.id_pendidikan,
                    CONCAT(kp.nama_pendidikan, ' ', pend.jurusan_pendidikan, ' Bidang ', bp.bidang, ' (', pend.tahun_lulus, ')') AS pendidikan,
                    kp.level_p
                    FROM pendidikan pend,
                    kategori_pendidikan kp,
                    bidang_pendidikan bp,
                    pegawai p
                    WHERE pend.level_p = kp.level_p
                    AND pend.id_bidang = bp.id
                    AND pend.id_pegawai = p.id_pegawai
                    AND p.flag_pensiun = 0
                    AND p.id_pegawai = $idpegawai
                    ORDER BY pend.id_pegawai, pend.level_p) pnd
                    JOIN (SELECT
                    @curRow := 0,
                    @curIdp := 0) r
                    ORDER BY level_p) univ) sekol
                    ON datax.id_pegawai = sekol.id_pegawai
                    LEFT JOIN (SELECT
                    pelat.id_pegawai,
                    CONCAT(pelat.rank, ') ', pelat.nama_diklat) AS pelatihan,
                    pelat.tgl_diklat
                    FROM (SELECT
                    id_pegawai,
                    CASE id_pegawai WHEN @curIdDik THEN @curRow3 := @curRow3 + 1 ELSE @curRow3 := 1 END AS rank,
                    dik.nama_diklat,
                    @curIdDik := id_pegawai AS idp,
                    tgl_diklat
                    FROM (SELECT
                    id_pegawai,
                    nama_diklat,
                    tgl_diklat
                    FROM diklat
                    WHERE id_jenis_diklat <> 2
                    AND id_pegawai = $idpegawai) dik
                    JOIN (SELECT
                    @curRow3 := 0,
                    @curIdDik := 0) r3
                    ORDER BY tgl_diklat DESC) pelat) diklat
                    ON datax.id_pegawai = diklat.id_pegawai
                    LEFT JOIN (SELECT
                    ljab.id_pegawai,
                    CONCAT(ljab.rank, ') ', ljab.daftar_jab) AS daftar_jab,
                    ljab.tgl_masuk
                    FROM (SELECT
                    id_pegawai,
                    CASE id_pegawai WHEN @curIdLisJab THEN @curRow4 := @curRow4 + 1 ELSE @curRow4 := 1 END AS rank,
                    list_jab.daftar_jab,
                    @curIdLisJab := id_pegawai AS idp,
                    tgl_masuk
                    FROM (SELECT
                    z.id_pegawai,
                    CONCAT(YEAR(z.tgl_masuk), ' - ', z.jabatan, ' pada ', z.unit_kerja) AS daftar_jab,
                    z.tgl_masuk
                    FROM (SELECT
                    sk.id_pegawai,
                    j.Jabatan AS Jabatan,
                    uk.nama_baru AS unit_kerja,
                    sk.no_sk,
                    sk.tmt AS tgl_masuk
                    FROM sk
                    INNER JOIN Jabatan j
                    ON j.id_j = sk.id_j
                    INNER JOIN unit_kerja uk
                    ON uk.id_unit_kerja = j.id_unit_kerja
                    WHERE id_kategori_sk = 10
                    AND sk.id_pegawai = $idpegawai
                    UNION
                    (SELECT
                    id_pegawai,
                    Jabatan AS Jabatan,
                    unit_kerja,
                    no_sk,
                    tgl_masuk
                    FROM `riwayat_kerja`
                    WHERE id_pegawai = $idpegawai
                    ORDER BY tgl_masuk DESC)) AS z
                    ORDER BY tgl_masuk DESC) list_jab
                    JOIN (SELECT
                    @curRow4 := 0,
                    @curIdLisJab := 0) r4
                    ORDER BY list_jab.tgl_masuk DESC) ljab) pengalaman
                    ON datax.id_pegawai = pengalaman.id_pegawai
                    LEFT JOIN (SELECT
                    admin.id_pegawai,
                    CONCAT(admin.rank, ') ', admin.nama_diklat) AS nama_diklat,
                    admin.tgl_diklat
                    FROM (SELECT
                        id_pegawai,
                        CASE id_pegawai WHEN @curIdDik2 THEN @curRow5 := @curRow5 + 1 ELSE @curRow5 := 1 END AS rank,
                        dik.nama_diklat,
                        @curIdDik2 := id_pegawai AS idp,
                        dik.tgl_diklat
                      FROM (SELECT
                          id_pegawai,
                          nama_diklat,
                          tgl_diklat
                        FROM diklat
                        WHERE id_jenis_diklat = 2
                        AND id_pegawai = $idpegawai) dik
                        JOIN (SELECT
                            @curRow5 := 0,
                            @curIdDik2 := 0) r3
                        ORDER BY dik.tgl_diklat DESC) admin) administrasi
                          ON datax.id_pegawai = administrasi.id_pegawai
                      GROUP BY datax.id_pegawai,
                               datax.nip_baru,
                               datax.nama,
                               datax.pangkat_gol,
                               datax.jabatan,
                               datax.eselon,
                               datax.unit_kerja,
                               datax.id_j) kompetensi
                        LEFT JOIN ipasn_kompetensi ik
                          ON kompetensi.id_j = ik.id_j
                        LEFT JOIN nilai_skp ns
                          ON kompetensi.id_pegawai = ns.id_pegawai;";
        $query = $this->db->query($sql);
        $data['id_pegawai'] = $query->row()->id_pegawai;
        $data['nip_baru'] = "'".$query->row()->nip_baru;
        $data['nama'] = $query->row()->nama;
        $data['pangkat_gol'] = $query->row()->pangkat_gol;
        $data['jabatan'] = $query->row()->jabatan;
        $data['eselon'] = $query->row()->eselon;
        $data['unit_kerja'] = $query->row()->unit_kerja;
        $data['id_j'] = $query->row()->id_j;
        $data['tugas'] = $query->row()->tugas;
        $data['pendidikan'] = $query->row()->pendidikan;
        $data['pelatihan'] = $query->row()->pelatihan;
        $data['pengalaman'] = $query->row()->pengalaman;
        $data['administrasi'] = $query->row()->administrasi;
        $data['flag_pendidikan'] = ($query->row()->flag_pendidikan == 0 ? 'N' : 'Y');
        $data['flag_pelatihan'] = ($query->row()->flag_pelatihan == 0 ? 'N' : 'Y');
        $data['flag_pengalaman'] = ($query->row()->flag_pengalaman == 0 ? 'N' : 'Y');
        $data['flag_administrasi'] = ($query->row()->flag_administrasi == 0 ? 'N' : 'Y');
        $data['skor_gap_asn'] = $query->row()->skor_gap_asn;
        $data['nilai_skp'] = $query->row()->nilai_skp;
        return $data;
    }

    public function getKompensasi($idskpd){
        $sql = "SELECT b.*, c.tertinggi, c.terendah, c.selisih, c.persentase FROM
        (SELECT a.id_skpd, a.eselon, COUNT(a.id_pegawai) jml_pegawai FROM
        (SELECT uk.id_skpd, IF(j.eselon='IIB','II',IF(j.eselon='IIIA' OR j.eselon='IIIB','III',
          IF(j.eselon='IVA' OR j.eselon='IVB','IV',''))) AS eselon, p.id_pegawai
        FROM pegawai p, jabatan j, current_lokasi_kerja clk, unit_kerja uk
        WHERE p.flag_pensiun = 0 AND p.id_j = j.id_j AND p.id_pegawai = clk.id_pegawai AND
        clk.id_unit_kerja = uk.id_unit_kerja AND uk.id_skpd = $idskpd) a
        GROUP BY a.id_skpd, a.eselon ORDER BY a.eselon) b LEFT JOIN
        (SELECT * FROM ipasn_kompensasi ik WHERE ik.id_unit_kerja = $idskpd) c ON b.eselon = c.eselon";
        $query = $this->db->query($sql);
        $data = null;
        foreach ($query->result() as $row)
        {
            $data[] = $row;
        }
        return $data;
    }

    public function getHukuman($idskpd){
        $sql = "SELECT * FROM ipasn_hukuman ih WHERE ih.id_unit_kerja = $idskpd";
        $query = $this->db->query($sql);
        return $query->row();
    }
	
	public function getJabatanKosong($idopd){
        $sql = "SELECT d.id_skpd, COUNT(d.eselon) AS jml,
                SUM(IF(d.eselon = 'IIA' OR d.eselon = 'IIB',1,0)) as eselon_2,
                SUM(IF(d.eselon = 'IIIA' OR d.eselon = 'IIIB',1,0)) as eselon_3,
                SUM(IF(d.eselon = 'IVA' OR d.eselon = 'IVB',1,0)) as eselon_4,
                SUM(IF(d.eselon = 'V',1,0)) as eselon_5 FROM
                (SELECT c.*, uk.id_skpd FROM
                (SELECT j.eselon, j.id_unit_kerja, j.id_j, p.id_j as p_idj
                FROM jabatan j LEFT JOIN pegawai p ON j.id_j = p.id_j
                WHERE j.Tahun = 2017 AND (j.eselon = 'IIA' OR j.eselon = 'IIB'
                OR j.eselon = 'IIIA' OR j.eselon = 'IIIB' OR j.eselon = 'IVA' OR j.eselon = 'IVB' OR j.eselon = 'V')
                AND p.id_j IS NULL) c INNER JOIN unit_kerja uk ON c.id_unit_kerja = uk.id_unit_kerja) d
                WHERE d.id_skpd = ".$idopd.
                " GROUP BY d.id_skpd";
        $query = $this->db->query($sql);
        return $query->row();
    }

    public function getNamaBulan($bln){
        switch ($bln) {
            case '01':
                $bln = 'Januari';
                break;
            case '02':
                $bln = 'Februari';
                break;
            case '03':
                $bln = 'Maret';
                break;
            case '04':
                $bln = 'April';
                break;
            case '05':
                $bln = 'Mei';
                break;
            case '06':
                $bln = 'Juni';
                break;
            case '07':
                $bln = 'Juli';
                break;
            case '08':
                $bln = 'Agustus';
                break;
            case '09':
                $bln = 'September';
                break;
            case '10':
                $bln = 'Oktober';
                break;
            case '11':
                $bln = 'Nopember';
                break;
            case '12':
                $bln = 'Desember';
                break;
        }
        return $bln;
    }

    public function listOPDforReport(){
        $sql = "SELECT uk.id_unit_kerja, uk.nama_baru, uk.tahun, uk.Alamat, uk.telp,
                ST_AsText(uk.long_lat) AS long_lat, ST_AsText(uk.long_lat_outer) AS long_lat_outer,
                uk.in_long, uk.in_lat, uk.out_long, uk.out_lat
                FROM unit_kerja uk
                WHERE uk.tahun = 2017 AND uk.id_unit_kerja = uk.id_skpd
                ORDER BY uk.nama_baru";

        $query = $this->db->query($sql);
        $data = null;
        foreach ($query->result() as $row)
        {
            $data[] = $row;
        }
        return $data;
    }

}