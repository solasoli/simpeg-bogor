<?php
session_start();

extract($_GET);
?>

<?php
include("listib.php");
//include("konek.php");
if(isset($hapus))
    mysqli_query($mysqli,"delete from ijin_belajar where id=$hapus");
if($edit>0)
{
    $qedit1=mysqli_query($mysqli,"select * from ijin_belajar where id=$edit");
    $edit1=mysqli_fetch_array($qedit1);

    $qtmt=mysqli_query($mysqli,"select max(tmt) from sk where id_pegawai=$edit1[1] and id_kategori_sk=5");
    $tmt=mysqli_fetch_array($qtmt);

    $t2=substr($tmt[0],8,2);
    $b2=substr($tmt[0],5,2);
    $th2=substr($tmt[0],0,4);

    $qbel=mysqli_query($mysqli,"select * from pendidikan_terakhir where id_pegawai=$edit1[1]");
    $bel=mysqli_fetch_array($qbel);


    $qedit2=mysqli_query($mysqli,"select nama,nip_baru,pangkat_gol,nama_baru,id_j from pegawai inner join current_lokasi_kerja on pegawai.id_pegawai=current_lokasi_kerja.id_pegawai inner join unit_kerja on unit_kerja.id_unit_kerja=current_lokasi_kerja.id_unit_kerja where pegawai.id_pegawai=$edit1[1]");
    $edit2=mysqli_fetch_array($qedit2);

    if(is_numeric($edit2[id_j]))
    {
        $qjab=mysqli_query($mysqli,"select jabatan from jabatan where id_j=$edit2[id_j]");
        $jab=mysqli_fetch_array($qjab);
        $jabatan=$jab[0];
    }
    else
    {
        $qjab=mysqli_query($mysqli,"select nama_jfu from jfu_pegawai inner join jfu_master on jfu_pegawai.kode_jabatan=jfu_master.kode_jabatan where id_pegawai=$edit1[1]");
        $jab=mysqli_fetch_array($qjab);
        $jabatan=$jab[0];
    }
}

echo("<br>");
?>
<form id="form1" name="form1" method="post" action="index3.php">
<input type="hidden" name="edit"id="edit" value="<?php if(isset($edit)) echo ($edit); else echo (0);   ?>">
<table width="500" border="0" align="center" >
<tr>
    <td colspan="3" style="padding-bottom:10px !important;">Form Pengajuan Ijin Belajar

        <?php
        echo ("$_SESSION[nama_skpd]");
        ?>
    </td>
</tr>
<tr>
    <td style="padding-bottom:10px !important;">Nama</td>
    <td style="padding-right:10px !important;">: </td>
    <td>
        <input name="nama" type="text" id="nama" size="50" <?php if(isset($edit)) echo("value='$edit2[0]'"); ?> />
    </td>
</tr>
<tr>
    <td style="padding-bottom:10px !important;">NIP</td>
    <td>: </td>
    <td><input name="nip" type="text" id="nip" size="30" <?php if($edit>0) echo("value='$edit2[1]'"); ?> /></td>
</tr>
<tr>
    <td nowrap="nowrap" style="padding-bottom:10px !important;">Pangkat-Gol / Ruang</td>
    <td>: </td>
    <td><input name="pg" type="text" id="pg" size="8" <?php if($edit>0) echo("value='$edit2[2]'"); ?> />
        <input type="hidden" name="idp" id="idp" <?php if($edit>0) echo("value='$edit1[1]'"); ?>  /></td>
</tr>
<tr>
    <td nowrap="nowrap" style="padding-bottom:10px !important;">TMT Pangkat</td>
    <td>: </td>
    <td><input name="tmt" type="text" id="tmt" size="20" <?php if($edit>0) echo("value='$t2-$b2-$th2'"); ?> />
        <input name="x" type="hidden" id="x" value="insertib.php"  /></td>
</tr>
<tr>
    <td nowrap="nowrap" style="padding-bottom:10px !important;">Jabatan</td>
    <td>: </td>
    <td><input name="jabatan" type="text" id="jabatan" size="50"
            <?php if($edit>0) { echo ("value='$jabatan'");
            }

            ?>


            /></td>
</tr>
<tr>
    <td nowrap="nowrap" style="padding-bottom:10px !important;">OPD</td>
    <td>: </td>
    <td><input name="opd" type="text" id="opd" size="50"  <?php if($edit>0) echo("value='$edit2[nama_baru]'"); ?> /></td>
</tr>
<tr>
    <td nowrap="nowrap" style="padding-bottom:10px !important;">Pendidikan Terakhir</td>
    <td>: </td>
    <td nowrap="nowrap"><input name="pt" type="text" id="pt" size="50" <?php if($edit>0) echo("value='$bel[tingkat_pendidikan]'"); ?>  />
        <span style="color:red;">[Perbaiki Jika Salah] </span></td>
</tr>
<tr>
    <td nowrap="nowrap" style="padding-bottom:10px !important;">Jurusan</td>
    <td>: </td>
    <td nowrap="nowrap"><input name="jurusan" type="text" id="jurusan" size="50" <?php if($edit>0) echo("value='$bel[jurusan_pendidikan]'"); ?>  />
        <span style="color:red;">[Perbaiki Jika Salah] </span></td>
</tr>
<tr>
    <td nowrap="nowrap" style="padding-bottom:10px !important;">Institusi</td>
    <td>:</td>
    <td><input name="institusi" type="text" id="institusi" size="50" <?php if($edit>0) echo("value='$bel[lembaga_pendidikan]'"); ?> /></td>
</tr>
<tr>
    <td nowrap="nowrap" style="padding-bottom:10px !important;">Pendidikan Lanjutan</td>
    <td>: </td>
    <td><label for="pl"></label>
        <select name="pl" id="pl">
            <option value="8" <?php if($edit1[4]==8) echo("selected=selected"); ?>>SMP</option>
            <option value="7" <?php if($edit1[4]==7) echo("selected=selected"); ?>>SMA</option>
            <option value="6" <?php if($edit1[4]==6) echo("selected=selected"); ?>>D1</option>
            <option value="5" <?php if($edit1[4]==5) echo("selected=selected"); ?>>D2</option>
            <option value="4" <?php if($edit1[4]==4) echo("selected=selected"); ?>>D3</option>
            <option value="3" <?php if($edit1[4]==3) echo("selected=selected"); ?>>S1</option>
            <option value="2" <?php if($edit1[4]==2) echo("selected=selected"); ?>>Sekolah Profesi</option>
            <option value="2" <?php if($edit1[4]==2) echo("selected=selected"); ?>>S2</option>
            <option value="1" <?php if($edit1[4]==1) echo("selected=selected"); ?>>S3</option>
        </select></td>
</tr>
<tr>
    <td nowrap="nowrap" style="padding-bottom:10px !important;">Institusi Lanjutan</td>
    <td>:</td>
    <td><input name="ilanjutan" type="text" id="ilanjutan" size="50" <?php if($edit>0) echo("value='$edit1[institusi_lanjutan]'"); ?>  /></td>
</tr>
<tr>
    <td nowrap="nowrap" style="padding-bottom:10px !important;">Jurusan Lanjutan</td>
    <td>: </td>
    <td><input name="jlanjutan" type="text" id="jlanjutan" size="50" <?php if($edit>0) echo("value='$edit1[jurusan]'"); ?>  /></td>
</tr>
<tr>
    <td nowrap="nowrap" style="padding-bottom:10px !important;">Akreditasi Jurusan PT</td>
    <td>: </td>
    <td nowrap="nowrap"><label for="akr"></label>
        <label for="akr"></label>
        <input name="akr" type="text" id="akr" size="5"  <?php if($edit>0) echo("value='$edit1[akreditasi]'"); ?> />
        untuk mengetahui akreditasi jurusan klik link berikut <a href="http://ban-pt.kemdiknas.go.id/direktori.php" target="_blank">[akreditasi]</a></td>
</tr>
<tr>
    <td nowrap="nowrap" style="padding-bottom:10px !important;">&nbsp;</td>
    <td>&nbsp;</td>
    <td><input type="submit" name="button" id="button" value="Ajukan" /></td>
</tr>
</table>
</form>

<script type="text/javascript">
	$(document).ready(function(){
		$( "#nama" ).autocomplete({
			source: function( request, response ) {
				$.ajax({
					url: "proses.php",
					dataType: "json",
					data: {
						q: request.term,
						skpd: '<?php echo $_SESSION['id_skpd']; ?>',
						kategori: $("#nama").val()
					},
					success: function( data ) {
						response( data );

					}
				});
			},

			minLength: 1,
			select: function(event, ui) {
				var origEvent = event;
				while (origEvent.originalEvent !== undefined)
					origEvent = origEvent.originalEvent;
				if (origEvent.type == 'keydown' || origEvent.type == 'click')
				{ $("#nama").click();
					$("#nip").val(ui.item.nip);
					$("#pg").val(ui.item.pg);
					$("#jabatan").val(ui.item.jab);
					$("#opd").val(ui.item.opd);
					$("#tmt").val(ui.item.tmt);
					$("#pt").val(ui.item.pen);
					$("#jurusan").val(ui.item.jur);
					$("#institusi").val(ui.item.ip);
					$("#idp").val(ui.item.idp);

					if(ui.item.pen=='S1')
						$("#pl").val(2);
					else if(ui.item.pen=='S2')
						$("#pl").val(1);
					else if(ui.item.pen=='D3' || ui.item.pen=='D2' || ui.item.pen=='D1' || ui.item.pen=='SMA/SEDERAJAT')
						$("#pl").val(3);

				}
			}

		});


		$( "#jlanjutan" ).autocomplete({
			source: function( request, response ) {
				$.ajax({
					url: "prosesj.php",
					dataType: "json",
					data: {
						q: request.term,
						ins: document.getElementById('ilanjutan').value,
						kategori: $("#jlanjutan").val()
					},
					success: function( data,ui ) {
						response( data );

					}
				});
			},

			minLength: 1,
			select: function(event, ui) {
				var origEvent = event;
				while (origEvent.originalEvent !== undefined)
					origEvent = origEvent.originalEvent;
				if (origEvent.type == 'keydown')
				{ $("#jlanjutan").click();
					$("#akr").val(ui.item.akre);


				}
			}

		});


		$( "#ilanjutan" ).autocomplete({
			source: function( request, response ) {
				$.ajax({
					url: "prosesi.php",
					dataType: "json",
					data: {
						q: request.term,
						kategori: $("#ilanjutan").val()
					},
					success: function( data ) {
						response( data );
					}
				});
			},

			minLength: 1,
			select: function(event, ui) {
				var origEvent = event;
				while (origEvent.originalEvent !== undefined)
					origEvent = origEvent.originalEvent;
				if (origEvent.type == 'keydown')
				{ $("#ilanjutan").click();


				}
			}

		});

	});
</script>
