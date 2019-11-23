<?php
    include 'konek.php';
    $idp = $_GET['idpegawai'];
    $sql = "SELECT
            a.*, GROUP_CONCAT(' ',a.tingkat_pendidikan,'-',a.jurusan_pendidikan,' (',a.tahun_lulus,')') AS sekolah
            FROM
            (SELECT p.id_pegawai, p.nip_baru, CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
            nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(' ',p.gelar_belakang) END) AS nama, p.pangkat_gol,
            CASE WHEN p.jenjab = 'Fungsional' THEN p.jabatan ELSE CASE WHEN p.id_j IS NULL THEN
            (SELECT jm.nama_jfu AS jabatan
             FROM jfu_pegawai jp, jfu_master jm
             WHERE jp.kode_jabatan = jm.kode_jabatan AND jp.id_pegawai = p.id_pegawai LIMIT 1)
            ELSE j.jabatan END END AS jabatan, uk.nama_baru as unit, p.tempat_lahir,
            DATE_FORMAT(p.tgl_lahir,  '%d/%m/%Y') AS tgl_lahir, p.telepon, p.ponsel, p.email, pend.tingkat_pendidikan, pend.jurusan_pendidikan, pend.tahun_lulus
            FROM pegawai p LEFT JOIN jabatan j ON p.id_j = j.id_j,
            current_lokasi_kerja clk, unit_kerja uk, pendidikan pend
            WHERE p.id_pegawai = clk.id_pegawai AND clk.id_unit_kerja = uk.id_unit_kerja
            AND p.id_pegawai = pend.id_pegawai
            AND p.flag_pensiun = 0 AND p.id_pegawai = ".$idp.") a
            GROUP BY a.id_pegawai";
    $query_row = mysqli_query($mysqli,$sql);
    $row = mysqli_fetch_array($query_row)

?>

<div class="row">
    <div class="col-sm-4">
        <div class="panel panel-primary" style="width: 108%">
            <div class="panel-heading">Biodata</div>
            <div class="panel-body">
                <img style='float:left;width:70px;height:90px; margin-right:10px;' src="foto/<?php echo $row['id_pegawai'] ?>.jpg" />
                <p>
                    <?php echo '<strong>'.$row['nip_baru'].'</strong><br>Nama '.$row['nama'].' Lahir di '.$row['tempat_lahir'].', '.$row['tgl_lahir'].
                    ' Gol. '.$row['pangkat_gol'].'. Jabatan '.$row['jabatan'].' di Unit '.$row['unit'].
                    '. Riwayat sekolah '.$row['sekolah'].'<br><strong>Kontak:</strong><br>Telp : '.$row['telepon'].
                    '<br>Ponsel : '.$row['ponsel'].'<br>Email : '.$row['email']; ?>
                </p>
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="panel panel-success" style="width: 108%">
            <div class="panel-heading">Riwayat Jabatan</div>
            <div class="panel-body">
                <?php
                    $sql = "select * from
                            (select j.jabatan as Jabatan,  uk.nama_baru as unit_kerja, sk.no_sk, sk.tmt as tgl_masuk
                            from sk
                            inner join jabatan j on j.id_j = sk.id_j
                            inner join unit_kerja uk on uk.id_unit_kerja = j.id_unit_kerja
                            where id_kategori_sk = 10 and sk.id_pegawai = $idp
                            union (SELECT jabatan as Jabatan, unit_kerja, no_sk, tgl_masuk
                            FROM  `riwayat_kerja`
                            WHERE id_pegawai = $idp
                            ORDER BY tgl_masuk DESC)) as z order by tgl_masuk DESC";
                    $query_row = mysqli_query($mysqli,$sql);
                ?>
                <ol style="margin-left: -30px;">
                <?php
                    while($row = mysqli_fetch_array($query_row)){
                        echo '<li>'.$row['Jabatan'].'</li>';
                    }
                ?>
                </ol>
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="panel panel-info" style="width: 106%">
            <div class="panel-heading">Riwayat Diklat</div>
            <div class="panel-body">
                <?php
                    $sql = "SELECT dj.jenis_diklat, DATE_FORMAT(d.tgl_diklat, '%d/%m/%Y') as tgl_diklat, d.nama_diklat, d.jml_jam_diklat,
                            d.keterangan_diklat, d.penyelenggara_diklat
                            FROM diklat d, diklat_jenis dj WHERE id_pegawai = $idp AND d.id_jenis_diklat = dj.id_jenis_diklat;";
                    $query_row = mysqli_query($mysqli,$sql);
                ?>
                <ol style="margin-left: -30px;">
                    <?php
                    while($row = mysqli_fetch_array($query_row)){
                        echo '<li><strong>Diklat '.$row['jenis_diklat'].'</strong><br>'.
                            '<span style=\'color: saddlebrown;\'>Judul: '.$row['nama_diklat'].'</span><br>'.
                            '<i><span style=\'color: black;font-size: small;\'>Tgl. '.$row['tgl_diklat'].' Jml Jam: '.$row['jml_jam_diklat'].' Penyelenggara: '.$row['penyelenggara_diklat'].
                            ' Ket. '.$row['keterangan_diklat'].'</span></i></li>';
                    }
                    ?>
                </ol>
            </div>
        </div>
    </div>
</div>
