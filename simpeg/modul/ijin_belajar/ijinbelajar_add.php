<?php
session_start();

extract($_GET);

include("konek.php");
require_once('class/pegawai.php');
require_once("library/format.php");

$format = new Format;
$obj_pegawai = new Pegawai;
$pegawai = $obj_pegawai->get_obj($_SESSION['id_pegawai']);	

if(isset($hapus))
    mysql_query("delete from ijin_belajar where id=$hapus");
if($edit>0)
{
    $qedit1=mysql_query("select * from ijin_belajar where id=$edit");
    $edit1=mysql_fetch_array($qedit1);

    $qtmt=mysql_query("select max(tmt) from sk where id_pegawai=$edit1[1] and id_kategori_sk=5");
    $tmt=mysql_fetch_array($qtmt);

    $t2=substr($tmt[0],8,2);
    $b2=substr($tmt[0],5,2);
    $th2=substr($tmt[0],0,4);

    $qbel=mysql_query("select * from pendidikan_terakhir where id_pegawai=$edit1[1]");
    $bel=mysql_fetch_array($qbel);


    $qedit2=mysql_query("select nama,nip_baru,pangkat_gol,nama_baru,id_j from pegawai inner join current_lokasi_kerja on pegawai.id_pegawai=current_lokasi_kerja.id_pegawai inner join unit_kerja on unit_kerja.id_unit_kerja=current_lokasi_kerja.id_unit_kerja where pegawai.id_pegawai=$edit1[1]");
    $edit2=mysql_fetch_array($qedit2);

    if(is_numeric($edit2[id_j]))
    {
        $qjab=mysql_query("select jabatan from jabatan where id_j=$edit2[id_j]");
        $jab=mysql_fetch_array($qjab);
        $jabatan=$jab[0];
    }
    else
    {
        $qjab=mysql_query("select nama_jfu from jfu_pegawai inner join jfu_master on jfu_pegawai.kode_jabatan=jfu_master.kode_jabatan where id_pegawai=$edit1[1]");
        $jab=mysql_fetch_array($qjab);
        $jabatan=$jab[0];
    }
}

$q=mysql_query("select nama,
					nip_baru,	
					pangkat_gol,
					jabatan,
					nama_baru,
					tingkat_pendidikan,
					jurusan,akreditasi,pegawai.id_pegawai,approve,ijin_belajar.keterangan as ket,ijin_belajar.id from ijin_belajar inner join pegawai on pegawai.id_pegawai =  ijin_belajar.id_pegawai inner join current_lokasi_kerja on current_lokasi_kerja.id_pegawai =  ijin_belajar.id_pegawai inner join unit_kerja on unit_kerja.id_unit_kerja=current_lokasi_kerja.id_unit_kerja where unit_kerja.id_skpd=$_SESSION[id_unit]  ");

?>
<style>
#ilanjutan_container {
    display: block; 
    position:relative
	} 
	.ui-autocomplete {
		position: absolute;
	}
</style>

<div class="row">
	<div class="col-md-8">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h5>Pengajuan Ijin Belajar <?php echo ("$_SESSION[nama_skpd]");?></h5>
			</div>
			<div class="panel-body">
				<form id="form_ibe" name="form_ibe" method="post" class="form-horizontal" >
					<div class="form-group">
						<label for="nip" class="col-sm-4 control-label">NIP</label>
						<div class="col-sm-8 form-inline">
							<input name="nip" type="text" class="form-control" id="nip" <?php if($edit>0) echo("value='$edit2[1]'"); ?> />
							<a id="btn_cari_pegawai" class="btn btn-info">CARI</a>
						</div>
					</div>
					<div class="form-group">
						<label for="nama" class="col-sm-4 control-label">Nama</label>
						<div class="col-sm-8">
							<input name="nama" readonly type="text" class="form-control" id="nama" size="50" <?php if(isset($edit)) echo("value='$edit2[0]'"); ?> />
						</div>
					</div>					
					<div class="form-group">
						<label for="nip" class="col-sm-4 control-label">Pangkat-Gol / Ruang</label>
						<div class="col-sm-8">
							<input name="pg" class="form-control" type="text" id="pg" size="8" <?php if($edit>0) echo("value='$edit2[2]'"); ?> />
							<input type="hidden" name="idp" id="idp" <?php if($edit>0) echo("value='$edit1[1]'"); ?>  />
						</div>
					</div>
					<div class="form-group">
						<label for="nip" class="col-sm-4 control-label">TMT Pangkat</label>
						<div class="col-sm-8">
							<input name="tmt" class="form-control" type="text" id="tmt" size="20" <?php if($edit>0) echo("value='$t2-$b2-$th2'"); ?> />
							<input name="x" type="hidden" id="x" value="insertib.php"  />						
						</div>
					</div>
					<div class="form-group">
						<label for="nip" class="col-sm-4 control-label">Jabatan</label>
						<div class="col-sm-8">
							<input name="jabatan" type="text" id="jabatan" class="form-control" size="50" <?php if($edit>0) { echo ("value='$jabatan'"); } ?> />
						</div>
					</div>
					<div class="form-group">
						<label for="nip" class="col-sm-4 control-label">OPD</label>
						<div class="col-sm-8">
							<input class="form-control" name="opd" type="text" id="opd" size="50"  <?php if($edit>0) echo("value='$edit2[nama_baru]'"); ?> />
						</div>
					</div>					
					<div class="form-group">
						<label for="nip" class="col-sm-4 control-label">Pendidikan Terakhir</label>
						<div class="col-sm-8">
							<input name="pt" class="form-control" type="text" id="pt" size="50" <?php if($edit>0) echo("value='$bel[tingkat_pendidikan]'"); ?>  />
							<span id="helpBlock" class="help-block">Perbaiki Jika Salah</span>
						</div>
					</div>					
					<div class="form-group">
						<label for="nip" class="col-sm-4 control-label">Jurusan</label>
						<div class="col-sm-8">
							<input name="jurusan" class="form-control" type="text" class="Perbaiki Jika Salah" id="jurusan" size="50" <?php if($edit>0) echo("value='$bel[jurusan_pendidikan]'"); ?>  />
							<span id="helpBlock" class="help-block">Perbaiki Jika Salah</span>
						</div>
					</div>				
					<div class="form-group">
						<label for="nip" class="col-sm-4 control-label">Institusi</label>
						<div class="col-sm-8">
							<input name="institusi" class="form-control" type="text" id="institusi" size="50" <?php if($edit>0) echo("value='$bel[lembaga_pendidikan]'"); ?> />
						</div>
					</div>
					<div class="form-group">
						<label for="nip" class="col-sm-4 control-label">Untuk Formasi</label>
						<div class="col-sm-8 form-inline">
							<input name="formasi" class="form-control " type="text" readonly id="formasi" <?php if($edit>0) echo("value='$bel[formasi]'"); ?> />
							<input name="id_formasi" id="id_formasi" type="hidden">
							<a id="btn_cari_formasi" class="btn btn-warning">CARI</a>
						</div>
					</div>
					<div class="form-group">
						<label for="nip" class="col-sm-4 control-label">Pendidikan Lanjutan</label>
						<div class="col-sm-8" id="pendidikan_lanjutan">
							<input type="text" readonly class="form-control" name="pl_name" id="pl_name">
							<input type="hidden" name="pl" id="pl">							
						</div>
					</div>					
					<div class="form-group">
						<label for="nip" class="col-sm-4 control-label">Jurusan Lanjutan</label>
						<div class="col-sm-8">
							<input name="jlanjutan" class="form-control" readonly type="text" id="jlanjutan" size="50" <?php if($edit>0) echo("value='$edit1[jurusan]'"); ?>  />
							<div id="jlanjutan_container"></div>
						</div>
					</div>
					<div class="form-group">
						<label for="nip" class="col-sm-4 control-label">Perguruan Tinggi Lanjutan</label>
						<div class="col-sm-8">
							<input name="ilanjutan" class="form-control" type="text" id="ilanjutan" size="50" <?php if($edit>0) echo("value='$edit1[institusi_lanjutan]'"); ?>  />
							<div id="ilanjutan_container"></div>
						</div>
					</div>	
					<div class="form-group form-inline">
						<label for="nip" class="col-sm-4 control-label">Akreditasi/tgl daluwarsa/status</label>
						<div class="col-sm-2 ">							
							<input name="akr" class="form-control" type="text" id="akr" size="5"  <?php if($edit>0) echo("value='$edit1[akreditasi]'"); ?> />
								
						</div>
						<div class="col-sm-2 ">							
							<input name="akr_tgl_daluwarsa" class="form-control" size="8" type="text" id="akr_tgl_daluwarsa" readonly />								
						</div>
						<div class="col-sm-2 ">							
							<input name="akr_status_daluwarsa" class="form-control" size="10" type="text" id="akr_status_daluwarsa" readonly />								
						</div>
					</div>
					untuk mengetahui akreditasi jurusan klik link berikut <a href="http://ban-pt.kemdiknas.go.id/direktori.php" target="_blank">[akreditasi]</a>
					<div class="form-group pull-right">
						<a class="btn btn-primary" name="button" onclick="edit_ib()" id="button"  />ajukan</a>
					</div>
				</form>
			</div>			
		</div>
	</div>	
	<div class="col-md-5">
		<?php //include $BASE_URL."modul/ijin_belajar/formasi.php" ?>
	</div>
</div>
<?php include $BASE_URL."modul/ijin_belajar/get_formasi.php" ?>
</body>
</html>
<!--script language="javascript" src="js/jquery-ui.min.js"></script-->	
<script type="text/javascript">
	
	
	
	function setStatus(status, id){
		
		//alert(status+" "+id);		
		$.post('ijinbelajar_update_status.php',{status:status,id:id})
		 .done(function(obj){
			alert(obj);			
		});
			
	}
	
	function edit_ib(){
		
		$.post("<?php echo BASE_URL.'modul/ijin_belajar/insertib.php' ?>", $("#form_ibe").serialize())
		 .done(function(data){
			 alert(data);
			 window.location.href = "<?php echo BASE_URL.'index3.php?x=ibe.php&y=l' ?>";
		 });
	}

	$(document).ready(function(){
		
		$("#add").addClass("active");
		$("#list").removeClass("active");
		$("#need").removeClass("active");
		
		$.curCSS = function (element, attrib, val) {
			$(element).css(attrib, val);
		};
				
		
		$("#btn_cari_formasi").on('click',function(){
			
			$('#modal_choose_formasi').modal('show');
		});
		
		$("#btn_cari_pegawai").on('click',function(){
			
			$.post('proses.php',{nip:$("#nip").val(),id_skpd: '<?php echo $_SESSION['id_skpd']; ?>'})
			 .done(function(obj){
				data = JSON.parse(obj);
					//alert(obj);
				if(data.id == 0){
					alert("Pegawai Tidak Ditemukan/NIP tidak dikenal");
				}else{
					//alert(data.nama);
					
					
					$("#nama").val(data.nama);
					$("#pg").val(data.golongan);
					$("#jabatan").val(data.jabatan);
					$("#opd").val(data.opd);
					$("#tmt").val(data.tmt);
					
					$("#pt").val(data.tingkat_pendidikan);
					$("#jurusan").val(data.jurusan);
					$("#institusi").val(data.institusi);
					$("#idp").val(data.id);	
					
				}				
			});
		});
		
		$("#btnAjukan").on('click',function(){
			$("#formpengajuan").modal('show');
		});
		$("#jlanjutan").autocomplete({	
			search:function(event,ui){
				var newUrl="prosesj.php?pl="+$("#pl_name")+"&ins="+ $("#ilanjutan").val();
				$(this).autocomplete("option","source",newUrl)
			},
			source: [],
			minLength: 3,
			appendTo: "#jlanjutan_container",
			select: function( event, ui ) {
                    console.log ( ui.item ? "Selected: " + ui.item.value + " aka " + ui.item.id :
                    "Nothing selected, input was " + this.value );
					//$("#id_unit_kerja_pegawai").val(ui.item.id);
                    //window.location.replace("index.php?page=monitoring&uk="+ui.item.id);
                                          
			}		
		});		
		
		$("#ilanjutan").autocomplete({	
			search:function(event,ui){
				var newUrl="prosesi.php?pl="+ $("#pl_name").val()+"&jurusan="+$("#jlanjutan").val();
				$(this).autocomplete("option","source",newUrl)
			},
			source: [],
			minLength: 3,
			appendTo: "#ilanjutan_container",
			select: function( event, ui ) {
                    console.log ( ui.item ? "tgl_daluwarsa: " + ui.item.tgl_daluwarsa + " status daluwarsa " + ui.item.status_daluwarsa :
                    "Nothing selected, input was " + this.value );
					$("#akr").val(ui.item.akreditasi);
					$("#akr_tgl_daluwarsa").val(ui.item.tgl_daluwarsa);
					$("#akr_status_daluwarsa").val(ui.item.status_daluwarsa);
					
                    //window.location.replace("index.php?page=monitoring&uk="+ui.item.id);
                                          
			}		
		});
		
		
		
	});
</script>