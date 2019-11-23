<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Alih Tugas PNS</title>
    <link href="js/bootstrap-datetimepicker-master/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css" />
    <script src="js/moment.js"></script>
    <script src="js/bootstrap-datetimepicker-master/bootstrap-datetimepicker.min.js"></script>
</head>
<?php
    extract($_GET);
    extract($_POST);

    if(@$issubmit=='true'){
        $tmp = $_FILES['fileSK']['tmp_name'];
        $info = pathinfo($tmp);
        if ($_FILES['fileSK']['type'] == 'image/jpeg' or $_FILES['fileSK']['type'] == 'image/jpg') {
            $tipe = "jpg";
        } else {
            $tipe = "pdf";
        }
        $tglSK = explode("-", $tglSK);
        $tglSK = $tglSK[2] . '-' . $tglSK[1] . '-' . $tglSK[0];

        $tmtSK = explode("-", $tmtSK);
        $tmtSK = $tmtSK[2] . '-' . $tmtSK[1] . '-' . $tmtSK[0];

        $sqlCek = "SELECT (CASE WHEN MAX(tmt) IS NULL THEN
			  (SELECT MAX(tmt) FROM sk WHERE id_pegawai = " . $od . " AND id_kategori_sk = 5)
			  ELSE MAX(tmt) END) AS tglsk_terakhir,
			  CASE WHEN (CASE WHEN MAX(tmt) IS NULL THEN
			  (SELECT MAX(tmt) FROM sk WHERE id_pegawai = " . $od . " AND id_kategori_sk = 5)
			  ELSE MAX(tmt) END) < '" . $tmtSK . "' THEN 1 ELSE 0 END AS cek
			  FROM sk WHERE id_pegawai = " . $od . " AND id_kategori_sk = 1";
        $qryCek = mysqli_query($mysqli, $sqlCek);
        while ($row = mysqli_fetch_array($qryCek)) {
            $arrCekCur[] = $row;
        }
        $hasilCekTMT = $arrCekCur[0]['cek'];

        $ketera = $selectGol . ',' . $thnMKG . ',' . $blnMKG;
        $query_insert_sk = "insert into sk (id_pegawai,id_kategori_sk,no_sk,tgl_sk,pemberi_sk,pengesah_sk,keterangan,tmt, gol, mk_tahun, mk_bulan)
		values ($od,1,'$txtNoSK','$tglSK','','','$ketera','$tmtSK','$selectGol',$thnMKG,$blnMKG)";

        if ($mysqli->query($query_insert_sk) === TRUE) {
            $idsk = $mysqli->insert_id;
            if ($_FILES["fileSK"]["error"] == 0) {
                $tu = date("Y-m-d");
                $tc = date("Y-m-d h:i:s");
                $mysqli->query("insert into berkas (id_pegawai,id_kat,tgl_upload,byk_hal,tgl_berkas,created_date,nm_berkas)
                values ($od,2,'$tu',1,'$tu','$tc','SK')");
                $idarsip = $mysqli->insert_id;
                $mysqli->query("insert into isi_berkas (id_berkas,hal_ke,file_name) values ($idarsip,1,'')");
                $idisi = $mysqli->insert_id;
                $namafile = $peg[0] . "-" . $idarsip . "-" . $idisi . "." . $info['extension'];
                $namafile = $peg[0] . "-" . $idarsip . "-" . $idisi . "." . $tipe;

                $mysqli->query("update isi_berkas set file_name='$namafile' where id_isi_berkas=$idisi");
                $mysqli->query("update sk set id_berkas=$idarsip where id_sk=$idsk");
                move_uploaded_file($tmp, "Berkas/$namafile");
            }
            $mysqli->query("insert into riwayat_mutasi_kerja (id_pegawai,id_sk,id_unit_kerja,id_j,jabatan,keterangan,pangkat_gol,jenjab,id_detail,eselonering,id_j_bos,jabatan_atasan,nama_atasan)
            values ($od,$idsk,$selectUnit,0,'-','-','','',0,'',$selectAtasanLgsg,'-','-')");
            $idrmk = $mysqli->insert_id;
            if($hasilCekTMT==1) {
                $mysqli->query("update current_lokasi_kerja set id_unit_kerja = $selectUnit where id_pegawai = $od");
            }
            echo("<div align=center style='background-color: #83c868;font-weight: bold;color: #ffffff; padding-top: 5px;padding-bottom: 5px;'> Data Alih Tugas Berhasil disimpan </div>");
        }else{
            echo("<div align=center style='background-color:#c8271b;font-weight: bold;color: #ffffff; padding-top: 5px;padding-bottom: 5px;'> Error: Tidak dapat menyimpan data" . "</div>");
        }
        $sql = "SELECT a.nip_baru, a.nama, a.jenis_kelamin, a.tgl_lahir, a.usia, a.jenjab,
            CASE WHEN a.jabatan IS NULL THEN 'Fungsional Umum' ELSE a.jabatan END AS jabatan,
            a.agama, a.pangkat_gol, a.nama_baru FROM
            (SELECT p.nip_baru, CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
            nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(' ',p.gelar_belakang) END) AS nama,
            CASE WHEN p.jenis_kelamin = 1 THEN 'Laki-laki' ELSE 'Perempuan' END AS jenis_kelamin,
            DATE_FORMAT(p.tgl_lahir,  '%d/%m/%Y') AS tgl_lahir,
            ROUND(DATEDIFF(CURRENT_DATE, DATE_FORMAT(p.tgl_lahir, '%Y/%m/%d'))/365,2) AS usia,
            p.jenjab, CASE WHEN p.jenjab = 'Fungsional' THEN p.jabatan ELSE CASE WHEN p.id_j IS NULL THEN
              (SELECT jm.nama_jfu AS jabatan
             FROM jfu_pegawai jp, jfu_master jm
             WHERE jp.kode_jabatan = jm.kode_jabatan AND jp.id_pegawai = p.id_pegawai LIMIT 1)
            ELSE j.jabatan END END AS jabatan, CASE WHEN j.eselon IS NULL THEN 'Z' ELSE j.eselon END AS eselon, p.agama, p.pangkat_gol, uk.nama_baru
            FROM pegawai p LEFT JOIN jabatan j ON p.id_j = j.id_j, current_lokasi_kerja clk, unit_kerja uk
            WHERE p.id_pegawai = clk.id_pegawai AND clk.id_unit_kerja = uk.id_unit_kerja AND p.flag_pensiun = 0
            AND uk.id_skpd = ".$_SESSION['id_skpd']." AND p.id_pegawai = ".$od.") a ORDER BY a.nama_baru ASC, a.pangkat_gol DESC";
        $qp=mysqli_query($mysqli, $sql);
        $peg=mysqli_fetch_array($qp);
    }else{
        $sql = "SELECT a.nip_baru, a.nama, a.jenis_kelamin, a.tgl_lahir, a.usia, a.jenjab,
            CASE WHEN a.jabatan IS NULL THEN 'Fungsional Umum' ELSE a.jabatan END AS jabatan,
            a.agama, a.pangkat_gol, a.nama_baru FROM
            (SELECT p.nip_baru, CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
            nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(' ',p.gelar_belakang) END) AS nama,
            CASE WHEN p.jenis_kelamin = 1 THEN 'Laki-laki' ELSE 'Perempuan' END AS jenis_kelamin,
            DATE_FORMAT(p.tgl_lahir,  '%d/%m/%Y') AS tgl_lahir,
            ROUND(DATEDIFF(CURRENT_DATE, DATE_FORMAT(p.tgl_lahir, '%Y/%m/%d'))/365,2) AS usia,
            p.jenjab, CASE WHEN p.jenjab = 'Fungsional' THEN p.jabatan ELSE CASE WHEN p.id_j IS NULL THEN
              (SELECT jm.nama_jfu AS jabatan
             FROM jfu_pegawai jp, jfu_master jm
             WHERE jp.kode_jabatan = jm.kode_jabatan AND jp.id_pegawai = p.id_pegawai LIMIT 1)
            ELSE j.jabatan END END AS jabatan, CASE WHEN j.eselon IS NULL THEN 'Z' ELSE j.eselon END AS eselon, p.agama, p.pangkat_gol, uk.nama_baru
            FROM pegawai p LEFT JOIN jabatan j ON p.id_j = j.id_j, current_lokasi_kerja clk, unit_kerja uk
            WHERE p.id_pegawai = clk.id_pegawai AND clk.id_unit_kerja = uk.id_unit_kerja AND p.flag_pensiun = 0
            AND uk.id_skpd = ".$_SESSION['id_skpd']." AND p.id_pegawai = ".$od.") a ORDER BY a.nama_baru ASC, a.pangkat_gol DESC";
        $qp=mysqli_query($mysqli, $sql);
        $peg=mysqli_fetch_array($qp);
    }

?>
<body>
<h2>Registrasi Alih Tugas Antar Unit dalam OPD</h2>
<form role="form" class="form-horizontal" action="index3.php?x=at2.php&od=<?php echo $od?>" method="post"
      enctype="multipart/form-data" name="frmAlihTugas" id="frmAlihTugas">
    <div class="form-group">
        <label class="control-label col-sm-2" for="txtNama">Foto</label>
        <div class="col-sm-3">
            <?php
            if (file_exists("foto/$od.jpg")) {
                echo "
							<div align=left>
								<img src='foto/$od.jpg'".time()." width='100px' style='border: solid 1px rgba(3, 2, 17, 0.95)' />
							</div>";
            }
            ?>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-sm-2" for="txtNama">Nama
            <input name="od" type="hidden" id="od" value="<?php echo $od; ?>" />
        </label>
        <div class="col-sm-3"><input type="text" class="form-control" id="txtNama" name="txtNama" value="<?php echo $peg[1];?>" readonly="readonly"></div>
    </div>
    <div class="form-group">
        <label class="control-label col-sm-2" for="txtNip">NIP</label>
        <div class="col-sm-3"><input type="text" class="form-control" id="txtNip" name="txtNip" value="<?php echo $peg[0];?>" readonly="readonly"></div>
    </div>
    <div class="form-group">
        <label class="control-label col-sm-2" for="txtUnit">Unit Kerja Saat Ini</label>
        <div class="col-sm-6"><input type="text" class="form-control" id="txtUnit" name="txtUnit" value="<?php echo $peg[9];?>" readonly="readonly"></div>
    </div>
    <div class="form-group">
        <label class="control-label col-sm-2" for="txtNoSK">Nomor SK.</label>
        <div class="col-sm-3"><input type="text" class="form-control" id="txtNoSK" name="txtNoSK"></div>
    </div>
    <div class="form-group">
        <label class="control-label col-sm-2" for="tglSK">Tanggal SK.</label>
        <div class="col-sm-3">
            <div class='input-group date' id='datetimepicker'>
                <input type="text" class="form-control" id="tglSK" name="tglSK" value="<?php echo date("d-m-Y"); ?>" readonly="readonly">
                <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
            </div>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-sm-2" for="tglSK">TMT SK.</label>
        <div class="col-sm-3">
            <div class='input-group date' id='datetimepicker2'>
                <input type="text" class="form-control" id="tmtSK" name="tmtSK" value="<?php echo date("d-m-Y"); ?>" readonly="readonly">
                <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
            </div>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-sm-2" for="selectGol">Golongan</label>
        <div class="col-sm-3">
            <select class="form-control" id="selectGol" name="selectGol">
                <?php
                $q=mysqli_query($mysqli, "SELECT g.id_golongan, CONCAT(g.golongan,' (', g.pangkat, ')') AS golongan  FROM golongan g WHERE g.golongan <> '-'");
                while($dGol=mysqli_fetch_array($q))
                    echo("<option value=$dGol[1]>$dGol[1]</option>");
                ?>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-sm-2" for="thnMKG">Tahun Masa Kerja Gol.</label>
        <div class="col-sm-3"><input type="text" class="form-control" id="thnMKG" name="thnMKG"></div>
    </div>
    <div class="form-group">
        <label class="control-label col-sm-2" for="blnMKG">Bulan Masa Kerja Gol.</label>
        <div class="col-sm-3"><input type="text" class="form-control" id="blnMKG" name="blnMKG"></div>
    </div>
    <div class="form-group">
        <label class="control-label col-sm-2" for="selectUnit">Unit Kerja Baru</label>
        <div class="col-sm-3">
            <select class="form-control" id="selectUnit" name="selectUnit">
                <?php
                    $qunit=mysqli_query($mysqli, "select id_unit_kerja,nama_baru from unit_kerja where tahun=(select max(tahun) from unit_kerja) and id_skpd=$_SESSION[id_skpd] order by nama_baru");
                    while($onit=mysqli_fetch_array($qunit))
                    echo("<option value=$onit[0]> $onit[1]</option>");
                ?>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-sm-2" for="fileSK">Berkas SK Alih Tugas</label>
        <div class="col-sm-5"><input type="file" name="fileSK" id="fileSK" /></div>
    </div>
    <div class="form-group">
        <label class="control-label col-sm-2" for="selectAtasanLgsg">Atasan Langsung</label>
        <div class="col-sm-6">
            <select class="form-control" id="selectAtasanLgsg" name="selectAtasanLgsg">
                <?php
                $sql = "SELECT a.*, CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
                        p.nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(', ',p.gelar_belakang) END) AS nama_atasan 
                        FROM (SELECT id_j, jabatan, eselon FROM jabatan WHERE id_unit_kerja = ".$_SESSION['id_skpd']." AND tahun = (SELECT MAX(tahun) FROM jabatan)
                        ORDER BY eselon, jabatan) a LEFT JOIN pegawai p ON p.id_j = a.id_j";
                $q=mysqli_query($mysqli, $sql);
                while($atsl=mysqli_fetch_array($q))
                    echo("<option value=$atsl[0]>$atsl[1] ($atsl[2]) - $atsl[3]</option>");
                ?>
            </select>
        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-sm-2" for="btnSubmit">&nbsp;</label>
        <div class="col-sm-5">
            <input id="issubmit" name="issubmit" type="hidden" value="true" />
            <button id="btnSubmit" type="submit" class="btn btn-primary">Simpan</button>
        </div>
    </div>

</form>

</body>
</html>

<script>
    $(function () {
        $('#datetimepicker').datetimepicker({
            format: 'DD-MM-YYYY',
            ignoreReadonly: true
        });
    });
    $(function () {
        $('#datetimepicker2').datetimepicker({
            format: 'DD-MM-YYYY',
            ignoreReadonly: true
        });
    });
</script>
