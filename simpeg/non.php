<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title> Ubah Data Pegawai Non PNS</title>
	<link href="js/bootstrap-datetimepicker-master/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css" />
	<script src="js/moment.js"></script>
	<script src="js/bootstrap-datetimepicker-master/bootstrap-datetimepicker.min.js"></script>
</head>
<?php
session_start();
include("konek.php");
extract($_GET);
extract($_POST);
$q=mysqli_query($mysqli,"select *, DATE_FORMAT(tmt, '%d-%m-%Y') AS tmt_tkk, DATE_FORMAT(tgl_lahir, '%d-%m-%Y') AS tgl_lahir_tkk
			          from tkk where id_tkk=$id");
$peg=mysqli_fetch_array($q);

?>
<body>
<h2>Ubah Data Pegawai Non PNS</h2>
<form role="form" class="form-horizontal" action="index3.php?x=non.php&id=<?php echo $id?>" method="post"
	  enctype="multipart/form-data" name="frmUbahNonPNS" id="frmUbahNonPNS">
	<div class="row">
		<div class="col-sm-8">
			<div class="form-group">
				<label class="control-label col-sm-4" for="txtNama">Nama
					<input name="id" type="hidden" id="id" value="<?php echo $id; ?>" />
				</label>
				<div class="col-sm-4"><input type="text" class="form-control" id="txtNama" name="txtNama" value="<?php echo $peg[1];?>"></div>
			</div>

			<div class="form-group">
				<label class="control-label col-sm-4" for="ddStatusTkk">Status</label>
				<div class="col-sm-4">
					<select class="form-control" id="ddStatusTkk" name="ddStatusTkk">
						<option value="0">Silahkan Pilih</option>
						<?php
						$q2=mysqli_query($mysqli,"SELECT * FROM status_tkk;");
						while($dd=mysqli_fetch_array($q2))
							echo("<option value=\"$dd[0]\"".($dd[0]==$peg[3]?' selected':'').">$dd[1]</option>");
						?>
					</select>
				</div>
			</div>

			<div class="form-group">
				<label class="control-label col-sm-4" for="tglSK">TMT SK.</label>
				<div class="col-sm-4">
					<div class='input-group date' id='datetimepicker'>
						<input type="text" class="form-control" id="tmtSK" name="tmtSK" value="<?php echo $peg['tmt_tkk']; ?>" readonly="readonly">
						<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
					</div>
				</div>
			</div>

			<div class="form-group">
				<label class="control-label col-sm-4" for="txtTmptLahir">Tempat Lahir</label>
				<div class="col-sm-4"><input type="text" class="form-control" id="txtTmptLahir" name="txtTmptLahir" value="<?php echo $peg[5];?>"></div>
			</div>

			<div class="form-group">
				<label class="control-label col-sm-4" for="tglLahir">Tanggal Lahir</label>
				<div class="col-sm-4">
					<div class='input-group date' id='datetimepicker2'>
						<input type="text" class="form-control" id="tglLahir" name="tglLahir" value="<?php echo $peg['tgl_lahir_tkk']; ?>" readonly="readonly">
						<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
					</div>
				</div>
			</div>

			<div class="form-group">
				<label class="control-label col-sm-4" for="txtJabatan">Jabatan</label>
				<div class="col-sm-4"><input type="text" class="form-control" id="txtJabatan" name="txtJabatan" value="<?php echo $peg[7];?>"></div>
			</div>

			<div class="form-group">
				<label class="control-label col-sm-4" for="txtKtp">Nomor KTP</label>
				<div class="col-sm-4"><input type="text" class="form-control" id="txtKtp" name="txtKtp" value="<?php echo $peg[8];?>"></div>
			</div>

			<div class="form-group">
				<label class="control-label col-sm-4" for="txtKk">Nomor KK</label>
				<div class="col-sm-4"><input type="text" class="form-control" id="txtKk" name="txtKk" value="<?php echo $peg[9];?>"></div>
			</div>

			<div class="form-group">
				<label class="control-label col-sm-4" for="ddLevelP">Tingkat Pendidikan</label>
				<div class="col-sm-4">
					<select class="form-control" id="ddLevelP" name="ddLevelP">
						<option value="0">Silahkan Pilih</option>
						<?php
						$q2=mysqli_query($mysqli,"SELECT * FROM kategori_pendidikan;");
						while($dd=mysqli_fetch_array($q2))
							echo("<option value=\"$dd[0]\"".($dd[0]==$peg[10]?' selected':'').">$dd[1]</option>");
						?>
					</select>
				</div>
			</div>

			<div class="form-group">
				<label class="control-label col-sm-4" for="txtJurusan">Jurusan</label>
				<div class="col-sm-4"><input type="text" class="form-control" id="txtJurusan" name="txtJurusan" value="<?php echo $peg[11];?>"></div>
			</div>

			<div class="form-group">
				<label class="control-label col-sm-4" for="txtInstitusi">Institusi</label>
				<div class="col-sm-4"><input type="text" class="form-control" id="txtInstitusi" name="txtInstitusi" value="<?php echo $peg[12];?>"></div>
			</div>

			<div class="form-group">
				<label class="control-label col-sm-4" for="txtThnLulus">Tahun Lulus</label>
				<div class="col-sm-4"><input type="text" class="form-control" id="txtThnLulus" name="txtThnLulus" value="<?php echo $peg[13];?>"></div>
			</div>

			<div class="form-group">
				<label class="control-label col-sm-4" for="btnSubmit">&nbsp;</label>
				<div class="col-sm-4">
					<input id="issubmit" name="issubmit" type="hidden" value="true" />
                    <button id="btnKembali" type="button" class="btn btn-primary" style="margin-left: 0px;">
                        <span class="glyphicon glyphicon-arrow-left"></span> Kembali
                    </button>
					<button id="btnSubmit" type="submit" class="btn btn-primary">
                        <span class="glyphicon glyphicon-floppy-save"></span> Simpan</button>
                    <script>
                        $("#btnKembali").click(function(){
                            window.open("/simpeg/index3.php?x=list2_nonpns.php",'_self');
                        });
                    </script>
				</div>
			</div>
		</div>
		<div class="col-sm-4">

		</div>
	</div>
</form>
</body>