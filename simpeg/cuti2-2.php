<?php
session_start();
extract($_POST);
extract($_GET);

if(isset($idup))
{
	$t0=substr($txtTmtMulai,0,2);
	$b0=substr($txtTmtMulai,3,2);
	$th0=substr($txtTmtMulai,6,4);
	$t2=substr($txtTmtSelesai,0,2);
	$b2=substr($txtTmtSelesai,3,2);
	$th2=substr($txtTmtSelesai,6,4);
mysqli_query($mysqli,"update cuti_master set (tmt_awal,tmt_akhir,lama_cuti,keterangan) values ('$th0-$b0-$t0','$th2-$b2-$t2,$txtLamaCuti,'$txtLamaCuti') where id_cuti_master=$idup ");	
}

if($aktif==2) 
{
$qup=mysqli_query($mysqli,"select * from cuti_master where id_cuti_master=$idcm");	
$up=mysqli_fetch_array($qup);	

$t3=substr($up['tmt_awal'],8,2);
$b3=substr($up['tmt_awal'],5,2);
$th3=substr($up['tmt_awal'],0,4);

$t5=substr($up['tmt_akhir'],8,2);
$b5=substr($up['tmt_akhir'],5,2);
$th5=substr($up['tmt_akhir'],0,4);

}

if(@$hapus==1)
{
mysqli_query($mysqli,"delete from cuti_master where id_cuti_master=$idcm");
echo("<div align=center>Berkas Cuti Telah Dihapus </div>");
}

if(@$batal==1)
{
mysqli_query($mysqli,"update  cuti_master set id_status_cuti=9 where id_cuti_master=$idcm");
echo("<div align=center>Status Cuti Telah Dibatalkan</div>");
}

include("konek.php");

$sql_data = "SELECT me_atsl_pjbt_a.*, clk.id_unit_kerja as id_unit_kerja_pjbt
                FROM(
                SELECT me_atsl_pjbt.*, clk.id_unit_kerja as id_unit_kerja_atsl
                FROM
                (SELECT me_atsl.*, CASE WHEN p.id_pegawai IS NULL = 1 THEN 0 ELSE p.id_pegawai END as id_pegawai_pjbt,
                p.nip_baru as nip_baru_pjbt, CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
                p.nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(' ',p.gelar_belakang) END) AS nama_pjbt, p.pangkat_gol AS gol_pjbt,
                CASE WHEN p.jenjab = 'Fungsional' THEN p.jabatan ELSE CASE WHEN p.id_j IS NULL THEN CASE WHEN me_atsl.id_bos_pjbt = 0 THEN NULL ELSE 'Fungsional Umum' END ELSE j.jabatan END END AS jabatan_pjbt
                FROM
                (SELECT me.*, CASE WHEN p.id_pegawai IS NULL = 1 THEN 0 ELSE p.id_pegawai END as id_pegawai_atsl,
                p.nip_baru as nip_baru_atsl, CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
                p.nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(' ',p.gelar_belakang) END) AS nama_atsl, p.pangkat_gol as gol_atsl,
                CASE WHEN p.jenjab = 'Fungsional' THEN p.jabatan ELSE CASE WHEN p.id_j IS NULL THEN CASE WHEN me.id_bos_atsl = 0 THEN NULL ELSE 'Fungsional Umum' END ELSE j.jabatan END END AS jabatan_atsl,
                CASE WHEN j.id_bos IS NULL = 1 THEN 0 ELSE j.id_bos END AS id_bos_pjbt
                FROM
                (
                SELECT a.*, clk.id_unit_kerja as id_unit_kerja_me, uk.nama_baru as unit_kerja_me
                FROM(
                SELECT p.id_pegawai, p.nip_baru, CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
                nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(' ',p.gelar_belakang) END) AS nama, p.pangkat_gol, p.jenjab,
                CASE WHEN p.jenjab = 'Fungsional' THEN p.jabatan ELSE CASE WHEN p.id_j IS NULL THEN 'Fungsional Umum' ELSE j.jabatan END END AS jabatan,
                CASE WHEN j.id_bos IS NULL = 1 THEN
                (SELECT rmk.id_j_bos as id_bos_atsl FROM riwayat_mutasi_kerja rmk WHERE rmk.id_pegawai = $_SESSION[id_pegawai]
                ORDER BY rmk.id_riwayat DESC LIMIT 1)
                ELSE j.id_bos END as id_bos_atsl,
                ROUND(DATEDIFF(CURRENT_DATE, DATE_FORMAT(STR_TO_DATE(CONCAT(SUBSTRING(p.nip_baru,9,4),'/',SUBSTRING(p.nip_baru,13,2),'/','01'),
                '%Y/%m/%d'), '%Y-%m-%d'))/365,2) AS masa_kerja, p.alamat
                FROM pegawai p LEFT JOIN jabatan j ON p.id_j = j.id_j
                WHERE p.id_pegawai = $_SESSION[id_pegawai]) AS a, current_lokasi_kerja clk, unit_kerja uk
                WHERE a.id_pegawai = clk.id_pegawai AND clk.id_unit_kerja = uk.id_unit_kerja
                ) AS me LEFT JOIN pegawai p ON me.id_bos_atsl = p.id_j LEFT JOIN jabatan j ON p.id_j = j.id_j
                ) AS me_atsl LEFT JOIN pegawai p ON me_atsl.id_bos_pjbt = p.id_j LEFT JOIN jabatan j ON p.id_j = j.id_j
                ) AS me_atsl_pjbt INNER JOIN current_lokasi_kerja clk ON me_atsl_pjbt.id_pegawai_atsl = clk.id_pegawai LEFT JOIN unit_kerja uk ON clk.id_unit_kerja = uk.id_unit_kerja
                ) AS me_atsl_pjbt_a INNER JOIN current_lokasi_kerja clk ON me_atsl_pjbt_a.id_pegawai_pjbt = clk.id_pegawai LEFT JOIN unit_kerja uk ON clk.id_unit_kerja = uk.id_unit_kerja;";

$query = mysqli_query($mysqli,$sql_data);
$data = mysqli_fetch_array($query);

IF ($data[9]==$data[22]) {
    IF($data[9]==$data[23]){
        $flag_uk_atasan_sama = 1;
    }else{
        $flag_uk_atasan_sama = 0;
    }
}else{
    $flag_uk_atasan_sama = 0;
}


if($issubmit=='true'){
    $txtTglPengajuan = explode("-",$txtTglPengajuan);
    $txtTglPengajuan = $txtTglPengajuan[2].'-'.$txtTglPengajuan[1].'-'.$txtTglPengajuan[0];
    $txtTmtMulai = explode("-",$txtTmtMulai);
    $txtTmtMulai = $txtTmtMulai[2].'-'.$txtTmtMulai[1].'-'.$txtTmtMulai[0];
    $txtTmtSelesai = explode("-",$txtTmtSelesai);
    $txtTmtSelesai = $txtTmtSelesai[2].'-'.$txtTmtSelesai[1].'-'.$txtTmtSelesai[0];

    $sql_insert = "INSERT INTO cuti_master(periode_thn, tgl_usulan_cuti, id_pegawai, last_jenjab, last_jabatan,
                  last_gol, last_id_unit_kerja, last_unit_kerja, last_masa_kerja, last_atsl_nip, last_atsl_nama, last_atsl_gol, last_atsl_jabatan,
                  last_pjbt_nip, last_pjbt_nama, last_pjbt_gol, last_pjbt_jabatan, flag_uk_atasan_sama, id_jenis_cuti,
                  no_keputusan, tmt_awal, tmt_akhir, lama_cuti, keterangan, id_status_cuti, tgl_approve_status, approved_by, approved_note,
                  flag_lapor_selesai, tgl_lapor_selesai, idberkas_surat_cuti)
                  VALUES ($txtPeriode, NOW(), $_SESSION[id_pegawai], '$last_jenjab', '$last_jabatan', '$last_gol', '$last_id_unit_kerja',
                  '$last_unit_kerja', $last_masa_kerja, '$last_atsl_nip', '$last_atsl_nama', '$last_atsl_gol', '$last_atsl_jabatan',
                  '$last_pjbt_nip', '$last_pjbt_nama', '$last_pjbt_gol', '$last_pjbt_jabatan', $flag_uk_atasan_sama,
                  '$cboIdJnsCuti', '-', '$txtTmtMulai', '$txtTmtSelesai', $txtLamaCuti, '$txtAlamatCuti', 1, NOW(), $_SESSION[id_pegawai], NULL,
                  0,NULL,0);";

    if ($mysqli->query($sql_insert) === TRUE) {
        $last_id_cuti = $mysqli->insert_id;
        echo("<div align=center style='background-color: #83c868;font-weight: bold;color: #ffffff; padding-top: 5px;padding-bottom: 5px;'> Data Pengajuan Cuti Berhasil disimpan </div>");
        if($cboIdJnsCuti=='C_BERSALIN'){
            $sql_insert_persalinan = "INSERT INTO cuti_persalinan(tgl_persalinan, tmt_awal_updated, tmt_akhir_updated, id_cuti_master)
                                  VALUES(NULL, NULL, NULL, $last_id_cuti);";
            $mysqli->query($sql_insert_persalinan);
        };
        if($cboIdJnsCuti=='C_SAKIT'){
            if($cboIdJnsCutiSakit==1){
                $flag_sakit = $rdb_flag_sakit_umum;
            }else{
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

?>

<link rel="stylesheet" type="text/css" href="tcal.css" />
<script type="text/javascript" src="tcal.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="SpryAssets/SpryValidationTextarea.js" type="text/javascript"></script>
<script type="text/javascript">

   function hapus() {
	   var cm = document.getElementById('cm').value;
	   location.href="index3.php?x=cuti2.php&hapus=1&idcm="+cm;
	   
   }
   
   function batal() {
	   
	     var cm = document.getElementById('cm').value;
	   location.href="index3.php?x=cuti2.php&batal=1&idcm="+cm;
   }
   
    function update() {
	   
	     var cm = document.getElementById('cm').value;
	   location.href="index3.php?x=cuti2.php&aktif=2&idcm="+cm;
   }


    function addTanggal(x){
        var awal = document.getElementById('txtTmtMulai').value;
        var startDate = new Date(awal.substr(3,2)+"/"+awal.substr(0,2)+"/"+awal.substr(6,4));
        Date.prototype.addDays = function(days) {
            var jmlHariFix = parseInt(days);
            var countKerja = 0;
            var jmlHari = parseInt(days);
            for (i = 1; i <= jmlHari; i++) {
                countKerja++;
                var tomorrow = new Date(startDate);
                tomorrow.setDate(startDate.getDate()+parseInt(i)-1);
                var dayOfWeek = tomorrow.getDay();
                if(dayOfWeek==6 || dayOfWeek==0){
                    jmlHari = jmlHari+1;
                    countKerja = countKerja-1;
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

<h2>REGISTRASI CUTI</h2>
<div role="tabpanel">
	<ul class="nav nav-tabs" role="tablist" id="myTab">
		<li role="presentation" <?php if(!isset($aktif) or $aktif==1) echo(" class=active"); ?>><a href="#data_dasar" aria-controls="data_dasar" role="tab" data-toggle="tab">Data Dasar</a></li>
		<li role="presentation" <?php if($aktif==2) echo(" class=active"); ?> ><a href="#form_cuti" aria-controls="form_cuti" role="tab" data-toggle="tab">Form Registrasi</a></li>
        <li role="presentation"><a href="#list_cuti" aria-controls="list_cuti" role="tab" data-toggle="tab">Status Pengajuan Cuti</a></li>
	</ul>
	<div class="tab-content">
		<div role="tabpanel" class="tab-pane <?php if(!isset($aktif) or $aktif==1) echo("  active"); ?>" id="data_dasar">
                <table width="95%" border="0" align="center" style="border-radius:5px;"
                       class="table table-bordered table-hover table-striped">
                    <tr>
                        <td style="width: 5%;">a.</td>
                        <td style="width: 20%;">NIP</td>
                        <td style="width: 75%;"><?php echo $data[1] ?></td>
                    </tr>
                    <tr>
                        <td style="width: 5%;">b.</td>
                        <td style="width: 20%;">Nama</td>
                        <td style="width: 75%;"><?php echo $data[2] ?></td>
                    </tr>
                    <tr>
                        <td style="width: 5%;">c.</td>
                        <td style="width: 20%;">Golongan</td>
                        <td style="width: 75%;"><?php echo $data[3] ?></td>
                    </tr>
                    <tr>
                        <td style="width: 5%;">d.</td>
                        <td style="width: 20%;">Jenjang</td>
                        <td style="width: 75%;"><?php echo $data[4] ?></td>
                    </tr>
                    <tr>
                        <td style="width: 5%;">e.</td>
                        <td style="width: 20%;">Jabatan</td>
                        <td style="width: 75%;"><?php echo $data[5] ?></td>
                    </tr>
                    <tr>
                        <td style="width: 5%;">f.</td>
                        <td style="width: 20%;">Masa Kerja</td>
                        <td style="width: 75%;"><?php echo $data[7] ?> Tahun</td>
                    </tr>
                    <tr>
                        <td style="width: 5%;">g.</td>
                        <td style="width: 20%;">Unit Kerja</td>
                        <td style="width: 75%;"><?php echo $data[10] ?></td>
                    </tr>
                    <tr>
                        <td style="width: 5%;"></td>
                        <td style="width: 20%;">Atasan Langsung</td>
                        <td style="width: 75%;"></td>
                    </tr>
                    <tr>
                        <td style="width: 5%;">a.</td>
                        <td style="width: 20%;">NIP</td>
                        <td style="width: 75%;"><?php echo ($data[12]==""?"Belum ada data":$data[12]); ?></td>
                    </tr>
                    <tr>
                        <td style="width: 5%;">b.</td>
                        <td style="width: 20%;">Nama</td>
                        <td style="width: 75%;"><?php echo ($data[13]==""?"Belum ada data":$data[13]); ?></td>
                    </tr>
                    <tr>
                        <td style="width: 5%;">c.</td>
                        <td style="width: 20%;">Golongan</td>
                        <td style="width: 75%;"><?php echo ($data[14]==""?"Belum ada data":$data[14]); ?></td>
                    </tr>
                    <tr>
                        <td style="width: 5%;">d.</td>
                        <td style="width: 20%;">Jabatan</td>
                        <td style="width: 75%;"><?php echo ($data[15]==""?"Belum ada data":$data[15]); ?></td>
                    </tr>
                    <tr>
                        <td style="width: 5%;"></td>
                        <td style="width: 20%;">Pejabat Berwenang</td>
                        <td style="width: 75%;"></td>
                    </tr>
                    <tr>
                        <td style="width: 5%;">a.</td>
                        <td style="width: 20%;">NIP</td>
                        <td style="width: 75%;"><?php echo ($data[18]==""?"Belum ada data":$data[18]); ?></td>
                    </tr>
                    <tr>
                        <td style="width: 5%;">b.</td>
                        <td style="width: 20%;">Nama</td>
                        <td style="width: 75%;"><?php echo ($data[19]==""?"Belum ada data":$data[19]); ?></td>
                    </tr>
                    <tr>
                        <td style="width: 5%;">c.</td>
                        <td style="width: 20%;">Golongan</td>
                        <td style="width: 75%;"><?php echo ($data[20]==""?"Belum ada data":$data[20]); ?></td>
                    </tr>
                    <tr>
                        <td style="width: 5%;">d.</td>
                        <td style="width: 20%;">Jabatan</td>
                        <td style="width: 75%;"><?php echo ($data[21]==""?"Belum ada data":$data[21]); ?></td>
                    </tr>
                </table>
		</div>

            <div role="tabpanel" class="tab-pane <?php if($aktif==2) echo("  active"); ?>" id="form_cuti">
                <?php
                    $sql_data = "SELECT * FROM cuti_jenis cj ORDER BY cj.id_jenis_cuti DESC;";
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
                    <table class="table">
                        <tr>
                            <td>
                                <table class="table">
                                    <tr>
                                        <td colspan="2"><i>Pastikan Data Dasar sudah lengkap</i></td>
                                    </tr>
                                    <tr>
                                        <td width="20%">
                                            Pilih Jenis Cuti
                                            <input id="last_gol" name="last_gol" type="hidden" value="<?php echo $data[3] ?>" />
                                            <input id="last_jenjab" name="last_jenjab" type="hidden" value="<?php echo $data[4] ?>" />
                                            <input id="last_jabatan" name="last_jabatan" type="hidden" value="<?php echo $data[5] ?>" />
                                            <input id="last_masa_kerja" name="last_masa_kerja" type="hidden" value="<?php echo $data[7] ?>" />
                                            <input id="last_id_unit_kerja" name="last_id_unit_kerja" type="hidden" value="<?php echo $data[9] ?>" />
                                            <input id="last_unit_kerja" name="last_unit_kerja" type="hidden" value="<?php echo $data[10] ?>" />
                                            <input id="last_atsl_nip" name="last_atsl_nip" type="hidden" value="<?php echo $data[12] ?>" />
                                            <input id="last_atsl_nama" name="last_atsl_nama" type="hidden" value="<?php echo $data[13] ?>" />
                                            <input id="last_atsl_gol" name="last_atsl_gol" type="hidden" value="<?php echo $data[14] ?>" />
                                            <input id="last_atsl_jabatan" name="last_atsl_jabatan" type="hidden" value="<?php echo $data[15] ?>" />
                                            <input id="last_pjbt_nip" name="last_pjbt_nip" type="hidden" value="<?php echo $data[18] ?>" />
                                            <input id="last_pjbt_nama" name="last_pjbt_nama" type="hidden" value="<?php echo $data[19] ?>" />
                                            <input id="last_pjbt_gol" name="last_pjbt_gol" type="hidden" value="<?php echo $data[20] ?>" />
                                            <input id="last_pjbt_jabatan" name="last_pjbt_jabatan" type="hidden" value="<?php echo $data[21] ?>" />
                                            <input id="flag_uk_atasan_sama" name="flag_uk_atasan_sama" type="hidden" value="<?php echo $flag_uk_atasan_sama; ?>" />
                                            <input id="issubmit" name="issubmit" type="hidden" value="true" />
                                        </td>
                                        <td width="30%">
                                            <select id="cboIdJnsCuti" name="cboIdJnsCuti" size="6" style="width:100%;" <?php if($aktif==2) echo(" disabled=disabled"); ?>>
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
                                                $sql = "SELECT * FROM cuti_jenis WHERE id_jenis_cuti = 'C_TAHUNAN'";
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

                                                $call_sp = "CALL PRCD_CUTI_COUNT_HIST_TAHUNAN(".$_SESSION[id_pegawai].");";
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
                                                <?php echo $quota_cuti; ?> Hari<br>
                                                Cuti yang sudah diambil : <?php echo $cuti_curr; ?> Hari
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
                                        <td>TMT. Mulai</td>
                                        <td>
                                <span class="input-control text">
                                    <input name="txtTmtMulai" id="txtTmtMulai" type="text" class="tcal"  value="<?php if ($aktif!=2) echo date("d-m-Y", strtotime(date("d-m-Y") . "+1 days"));
									else echo("$t3-$b3-$th3");
									?>" readonly="readonly"  />
                                </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Lama Cuti (Hari)</td>
                                        <td><span id="sprytextfield1">
                                        <input name="txtLamaCuti" type="text" id="txtLamaCuti" onkeyup="calculateDate()" <?php if(@$aktif!=2) echo(" value=1 "); else echo(" value=$up[lama_cuti] ");  ?> maxlength="4" />
                                        <span class="textfieldRequiredMsg">Harus diisi</span><span class="textfieldInvalidFormatMsg">Input harus angka</span></span></td>
                                    </tr>
                                    <tr>
                                        <td>TMT. Selesai *</td>
                                        <td>
                                <span class="input-control text">
                                    <input name="txtTmtSelesai" type="text" id="txtTmtSelesai" <?php if(@$aktif!=2) echo(date("d-m-Y")); else echo(" value=$t5-$b5-$th5 ");  ?> readonly="readonly" />
                                </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Alamat Ketika Cuti</td>
                                        <td><label for="txtAlamatCuti"></label>
                                          <span id="sprytextarea1">
                                          <textarea rows="4" cols="50" name="txtAlamatCuti" id="txtAlamatCuti"><?php if(@$aktif!=2) echo $data[8]; else echo $up['keterangan']; ?></textarea><br>
                                        <span class="textareaRequiredMsg">Harus diisi</span></span></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td><input type="submit" name="btnSimpanCuti" id="btnSimpanCuti" class="btn btn-primary" value="<?php if($aktif!=2) echo("simpan"); else echo("update perubahan");  ?>" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <i>* Tidak termasuk Cuti Bersama dan Libur Nasional serta Hari Sabtu dan Minggu</i>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                            <td style="background-color:#c6c6c6">
                                <?php
                                $sql_cuti_libur = "SELECT DATE_FORMAT(cb.tanggal,  '%d/%m/%Y') AS tanggal, hari, ket
                                            FROM cuti_bersama cb
                                            WHERE YEAR(cb.tanggal) = YEAR(NOW())";
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
                                            WHERE YEAR(cb.tanggal) = YEAR(NOW())";
                                $query_row = mysqli_query($mysqli,$sql_cuti_libur);
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
        <?php
            $sql_list_cuti = "SELECT cuti_pegawai.*, p.nama as nama_approved, p.nip_baru as nip_baru_approved FROM
                             (SELECT cm.*, rs.status_cuti FROM cuti_master cm, ref_status_cuti rs
                              WHERE cm.id_status_cuti = rs.idstatus_cuti AND cm.id_pegawai = $_SESSION[id_pegawai]) as cuti_pegawai, pegawai p
                              WHERE cuti_pegawai.approved_by = p.id_pegawai ORDER BY cuti_pegawai.tgl_usulan_cuti DESC";
            $query_row_cuti_master = mysqli_query($mysqli,$sql_list_cuti);
            $i = 0;
        ?>
            <div role="tabpanel" class="tab-pane" id="list_cuti">
                <table width="95%" border="0" align="center" style="border-radius:5px;"
                       class="table table-bordered table-hover table-striped">
                    <tr>
                        <td style="width: 5%;">No.</td>
                        <td style="width: 5%;">Periode</td>
                        <td style="width: 15%;">Tgl. Pengajuan</td>
                        <td style="width: 10%;">TMT. Awal</td>
                        <td style="width: 10%;">TMT. Akhir</td>
                        <td style="width: 5%;">Lama Cuti</td>
                        <td style="width: 30%;">Alamat Cuti</td>
                        <td style="width: 20%;">Status</td>
                    </tr>
                    <?php while($row_cuti = mysqli_fetch_array($query_row_cuti_master)){
                        if($issubmit_ajukan[$i]=='true'){
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
                                echo("<script type=\"text/javascript\">location.href='/simpeg/index3.php?x=cuti2.php';</script>");
                            } else {
                                echo("<div align=center style='background-color:#c8271b;font-weight: bold;color: #ffffff; padding-top: 5px;padding-bottom: 5px;'> Error: Tidak dapat menyimpan data" . "<br>" . $conn->error . "</div>");
                            }
                        }
                    ?>
                    <tr>
                        <td><?php echo $i+1; ?>.</td>
                        <td><?php echo $row_cuti['periode_thn']; ?></td>
                        <td><?php echo $row_cuti['tgl_usulan_cuti']; ?></td>
                        <td><?php echo $row_cuti['tmt_awal']; ?></td>
                        <td><?php echo $row_cuti['tmt_akhir']; ?></td>
                        <td><?php echo $row_cuti['lama_cuti']; ?></td>
                        <td><?php echo $row_cuti['keterangan']; ?></td>
                        <td><?php echo $row_cuti['status_cuti']; ?></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td colspan="7">
                            Unit Kerja : <?php echo $row_cuti['last_unit_kerja']; ?> <br>
                            <strong>Atasan  Langsung : </strong><br>
                            <?php echo $row_cuti['last_atsl_nama']." (".$row_cuti['last_atsl_nip'].")"; ?> <br>
                            Gol. <?php echo $row_cuti['last_atsl_gol']; ?>. Jabatan : <?php echo $row_cuti['last_atsl_jabatan']; ?> <br>
                            <strong>Pejabat Berwenang : </strong><br>
                            <?php echo $row_cuti['last_pjbt_nama']." (".$row_cuti['last_pjbt_nip'].")"; ?> <br>
                            Gol. <?php echo $row_cuti['last_pjbt_gol']; ?>. Jabatan : <?php echo $row_cuti['last_pjbt_jabatan']; ?> <br>
                            <strong>Tgl. Update Status : </strong><?php echo $row_cuti['tgl_approve_status']; ?> | Oleh : <?php echo $row_cuti['nama_approved']." (".$row_cuti['nip_baru_approved'].")"; ?> | Catatan Akhir : <?php echo ($row_cuti['approved_note']==""?"-":$row_cuti['approved_note']); ?><br />
                            Runut Status Pengajuan : <?php
							echo("<ul>");
							$qrun=mysqli_query($mysqli,"select nama,tgl_approve_hist,approved_note_hist,status_cuti from cuti_historis_approve inner join pegawai on cuti_historis_approve.approved_by_hist=pegawai.id_pegawai inner join ref_status_cuti on ref_status_cuti.idstatus_cuti = cuti_historis_approve.idstatus_cuti_hist  where id_cuti_master=$row_cuti[id_cuti_master] ");
							while($otoy=mysqli_fetch_array($qrun))
							{
								$t4=substr($otoy[1],8,2);$b4=substr($otoy[1],5,2);$th4=substr($otoy[1],0,4);
							echo("<li>Status : $otoy[3] Diproses oleh $otoy[0] tanggal $t4-$b4-$th4 catatan: $otoy[2] </li>");	
								
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
                                                echo "<span id='spnInfo' style='color: red'>Belum ada surat permohonan cuti yang diupload</span>";
                                            }else {
                                                $sqlCekBerkas = "SELECT ib.file_name, b.created_by, b.created_date, p.nip_baru, p.nama
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
                                    <td width="60%">
                                        <?php
                                            if ($row_cuti['idberkas_surat_cuti'] == 0){
                                                $jml_noberkas[$i] = $jml_noberkas[$i] + 1;
                                        ?>
                                        <span class="btn btn-primary btn-sm fileinput-button">
                                        <i class="glyphicon glyphicon-plus"></i>
                                        <span>Upload Baru Surat Permohonan (format file harus pdf)</span>
                                        <!-- The file input field used as target for the file upload widget -->
                                        <input id="file_cuti_<?php echo $row_cuti['id_cuti_master']; ?>"
                                               type="file" name="files[]" multiple/>
                                        <input type="hidden"
                                               name="surat_permohonan_cuti<?php echo $row_cuti['id_cuti_master']; ?>"
                                               id="surat_permohonan_cuti<?php echo $row_cuti['id_cuti_master']; ?>"/>
                                        </span>

                                        <div id="<?php echo 'progress_' . $row_cuti['id_cuti_master'] ?>"
                                             class="progress primary">
                                            <div class="progress-bar progress-bar-primary">
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
                                                                    location.href="/simpeg/index3.php?x=cuti2.php";
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
                                                        <span class="btn btn-primary btn-sm fileinput-button" <?php echo(($row_cuti['id_status_cuti']!=1 and $row_cuti['id_status_cuti']!=4)?"disabled":(($jml_noberkas[$i] > 0)?"disabled":"")); ?>>
                                                        <i class="glyphicon glyphicon-plus"></i>
                                                        <span>Upload Ulang</span>
                                                        <span>(format file harus pdf)</span>
                                                        <!-- The file input field used as target for the file upload widget -->
                                                        <input id="<?php echo 'file_cuti_' . $row_cuti['id_cuti_master'] ?>" type="file" name="files[]" multiple/>
                                                        <input type="hidden" name="<?php echo 'surat_permohonan_cuti' . $row_cuti['id_cuti_master'] ?>"
                                                               id="<?php echo 'surat_permohonan_cuti' . $row_cuti['id_cuti_master'] ?>"/>  </span>
                                                        <div id="<?php echo 'progress_' . $row_cuti['id_cuti_master'] ?>" class="progress primary">
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
                                                                                    location.href="/simpeg/index3.php?x=cuti2.php";
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
                                </tr>
                                <tr style="background-color: #c6c6c6;">
                                    <td>
                                        <input id="issubmit_ajukan[<?php echo $i; ?>]" name="issubmit_ajukan[<?php echo $i; ?>]" type="hidden" value="true" />
                                        <input type="button" name="btnUbahCuti_<?php echo $row_cuti['id_cuti_master']; ?>" id="btnUbahCuti_<?php echo $row_cuti['id_cuti_master']; ?>" class="btn btn-primary" value="Ubah" <?php if($row_cuti['id_status_cuti'] != 1 and $row_cuti['id_status_cuti'] != 4) echo 'disabled' ?> onclick="update()" />
                                        <input type="button" name="btnBatalkanCuti" id="btnBatalkanCuti" class="btn btn-warning" value="Batalkan" <?php echo(($row_cuti['id_status_cuti']!=1 and $row_cuti['id_status_cuti']!=2 and $row_cuti['id_status_cuti']!=3 and $row_cuti['id_status_cuti'] != 4)?"disabled":(($jml_noberkas[$i] > 0)?"":"")); ?> onclick="batal()" />
                                        <input type="button" name="btnHapusCuti" id="btnHapusCuti" class="btn btn-danger" value="Hapus" <?php if($row_cuti['id_status_cuti'] != 1) echo 'disabled' ?> onclick="hapus()" />
                                        <input name="cm" type="hidden" id="cm" value="<?php echo $row_cuti['id_cuti_master'] ; ?>" /> 
                                    </td>
                                    <td colspan="2">
                                        Catatan <input name="txtCatatan[<?php echo $i; ?>]" id="txtCatatan[<?php echo $i; ?>]" type="text" value="" style="width: 78%;" <?php echo(($row_cuti['id_status_cuti']!=1 and $row_cuti['id_status_cuti']!=4)?"disabled":(($jml_noberkas[$i] > 0)?"disabled":"")); ?>/>
                                        <input type="submit" name="btnAjukanCuti" id="btnAjukanCuti" class="btn btn-success" value="Kirim Usulan" <?php echo(($row_cuti['id_status_cuti']!=1 and $row_cuti['id_status_cuti']!=4)?"disabled":(($jml_noberkas[$i] > 0)?"disabled":"")); ?> />
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
             }
         });
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
             last_atsl_nip:{
                 feedbackIcons: "false",
                 validators: {notEmpty: {message: "NIP atasan tidak boleh kosong"}}
             },
             last_pjbt_nip:{
                 feedbackIcons: "false",
                 validators: {notEmpty: {message: "NIP pejabat tidak boleh kosong"}}
             },
             txtTmtMulai:{
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
                         callback: function(value, validator) {
                             var awal = document.getElementById('txtTmtMulai').value;
                             var startDateN = new Date(awal.substr(3,2)+"/"+awal.substr(0,2)+"/"+awal.substr(6,4));
                             var now = new Date();
                             if(startDateN <= now){
                                 return false;
                             }else{
                                 return true;
                             }
                         }
                     }
                 }
             },
             txtLamaCuti:{
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
             txtAlamatCuti: {
                 feedbackIcons: "false",
                 validators: {notEmpty: {message: "Alamat tidak boleh kosong"}}
             }
         }
     }).on("error.field.bv", function (b, a) {
         a.element.data("bv.messages").find('.help-block[data-bv-for="' + a.field + '"]').hide();
     }).on('success.form.bv', function(e) {
         var lama_cuti = document.getElementById('txtLamaCuti').value;
         var jml_jatah_cuti = document.getElementById('jml_jatah_cuti').value;
         if(parseInt(jml_jatah_cuti) >= -1){
             if(parseInt(jml_jatah_cuti) == -1){ //Tidak ada kuota maksimum
                return true;
             }else{
                 if(parseInt(lama_cuti) > parseInt(jml_jatah_cuti)){
                     alert('Jumlah lama cuti tidak boleh melebihi jumlah cuti yang dapat diambil');
                     return false;
                 }else{
                     var kuota_min_hari = document.getElementById('kuota_min_hari').value;
                     if(parseInt(lama_cuti) < parseInt(kuota_min_hari)){
                         alert('Jumlah lama cuti harus lebih dari jumlah minimal');
                         return false;
                     }else{
                         return true;
                     }
                 }
             }
         }else{
             if(parseInt(jml_jatah_cuti) == -2){
                 alert('Pengajuan Cuti terakhir anda bukan cuti sakit baru');
                 return false;
             }else if(parseInt(jml_jatah_cuti) == -3) {
                 alert('Pengajuan Cuti Sakit terakhir anda belum Disetujui BKPP');
                 return false;
             }else{
                 return true;
             }
         }
     });
     var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "integer", {validateOn:["change"]});
     var sprytextarea1 = new Spry.Widget.ValidationTextarea("sprytextarea1", {validateOn:["blur", "change"]});


 </script>