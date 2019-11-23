<?php $unit_kerja = new Unit_kerja; ?>


<h4>DAFTAR PEGAWAI NON-PNS <?php echo $unit_kerja->get_unit_kerja($unit['id_skpd'])->singkatan ?></h4>
<!--a href="#" class="btn btn-primary  hidden-print pull-right" onclick="window.print()">cetak</a></h4-->

<table id="list_pegawai" class="table table-bordered display" cellspacing="0" width="100%">
	<thead>
		<tr>
			<th>No</th>			
			<th>Nama</th>
			<th>Tanggal Lahir</th>
			<th>Jenis Pegawai</th>
			<!--th class="hidden-print">New Gol<span style="color:red">*</span></th-->
			     
            <th>TMT</th>
			<th>Jabatan</th>
			<th class="hidden-print">Aksi</th>
            <th class="hidden-print" style="width: 15%;">Berkas</th>
		</tr>
	</thead>
	<tbody>
		
		
        <?php
		$q=1;
		$sqltkk = ("select tkk.id_tkk, tkk.nama, tkk.tempat_lahir, tkk.tgl_lahir, tkk.tmt, tkk.jabatan, status_tkk.status as status
							from tkk 
							left join status_tkk on status_tkk.id = tkk.status
							where id_unit_kerja=$unit[id_skpd]");
		$qtkk=mysqli_query($mysqli,$sqltkk);				
		//echo $sqltkk;
		while($tkk=mysqli_fetch_array($qtkk)) { ?>
			<script type='text/javascript'>
			
				<?php echo "arr".$tkk['id']?> = ["<?php echo $tkk['id_tkk'] ?>",
												"<?php echo $tkk['nama'] ?>",
												"<?php echo $tkk['tempat_lahir'] ?>",
												"<?php echo $tkk['tgl_lahir'] ?>",
												"<?php echo $tkk['status'] ?>",
												"<?php echo $tkk['tmt'] ?>",
												"<?php echo $tkk['jabatan'] ?>"]
			</script>
			
			<tr>
				<td><?php echo $q++ ?></td>				
				<td><?php echo $tkk['nama'] ?></td>
				<td><?php echo $tkk['tgl_lahir'] ?> </td>
				<td><?php echo $tkk['status'] ?></td>
				<td><?php echo $tkk['tmt'] ?></td>
				<td><?php echo $tkk['jabatan'] ?></td>
				<td>       
					<a href='index3.php?x=deltkk.php&id=<?php echo $tkk['id_tkk'] ?>'  class='btn btn-danger'> Hapus </a>
					<a href='index3.php?x=non.php&id=<?php echo $tkk['id_tkk'] ?>'  class='btn btn-primary'>Edit Data</a>
					<?php if($_SESSION['id_pegawai'] == 11301){ ?>
					<a href='#' onclick="edit(<?php echo "arr".$tkk['id_tkk']?>)"  class='btn btn-primary'>Ubah Data</a>
					<?php } ?>
				</td>
                <td>
                    <?php
                    $sql = "select a.*, ib.file_name from 
                            (select st.id_sk, st.no_sk, st.tmt_mulai, st.tmt_akhir, st.id_berkas
                            from sk_tkk st where st.id_tkk = ".$tkk['id_tkk']." and st.id_kategori_sk = 37) a
                            left join berkas_tkk be on a.id_berkas = be.id_berkas left join isi_berkas_tkk ib on be.id_berkas = ib.id_berkas";
                    //echo $sql;
                    $qsk = mysqli_query($mysqli,$sql);
                    $x=1;
                    while($datask=mysqli_fetch_array($qsk)) {
                        $asli = basename($datask[5]);
                        if (file_exists(str_replace("\\", "/", getcwd()) . '/Berkas/' . trim($asli))) {
                            $ext[] = explode(".", $asli);
                            $linkBerkasUsulan = "<a href='./Berkas/$asli' target='_blank' class=\"btn-sm btn-success\"><strong>Lihat Berkas</strong></a>";
                            echo '<table><tr><td>' . $linkBerkasUsulan . '</td><td style="margin-left: -5px;">';
                            echo '</td></tr></table>';
                            unset($ext);
                        }
                    }
                    ?>
                </td>
			</tr>
		
		<?php 
		}
		?>
		
	</tbody>
</table>
<form name="formtkk" id="formtkk" action="index3.php" method="post" enctype="multipart/form-data">
<input type="hidden" value="tkk.php" name="x" id="x" /><input type="hidden" value="<?php echo $unit['id_skpd']; ?>" name="skpd" id="skpd" />
Tambah Tenaga Non PNS : <input type="text" name="tkk" /> <input type="submit" value="Tambahkan" /> 

</form>

<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ -->

<div class="modal fade" id="edit_tkk" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header text-primary">
				<h5><span class="glyphicon glyphicon-plus"></span> Edit Data TKK<h5>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-sm-11">
						<form role="form" class="form-horizontal" id="formTKK">							
							<div class="form-group">
								<label for="inputUraian" class="col-sm-3 control-label">NAMA</label>
								<div class="col-sm-9">
									<input type="txt" class="form-control" id="inputNama" name="inputNama" >
								</div>
							</div>
							<div class="form-group">
								<label for="inputTempatLahir" class="col-sm-3 control-label">Tempat Lahir</label>
								<div class="col-sm-9">
									<input type="txt" class="form-control" id="inputTempatLahir" name="inputTempatLahir" >
								</div>
							</div>
							<div class="form-group">
								<label for="inputUraian" class="col-sm-3 control-label">Tgl Lahir</label>
								<div class="col-sm-9">
									<input type="txt" class="form-control" id="inputTglLahir" name="inputTglLahir" placeholder="Kualitas" value="100">
								</div>
							</div>
							<div class="form-group">
								<label for="status" class="col-sm-3 control-label">Jenis Non PNS</label>
								<div class="col-sm-5">
									<select name="status" id="status" class="form-control">
									  <option value="1" <?php if($peg[3]==1) echo (" selected "); ?> >K2</option>
									  <option value="2" <?php if($peg[3]==2) echo (" selected "); ?> >TKK</option>
									  <option value="3" <?php if($peg[3]==3) echo (" selected "); ?> >Sukwan</option>
									  <option value="4" <?php if($peg[3]==4) echo (" selected "); ?> >Outsource</option>
									  <option value="5" <?php if($peg[3]==5) echo (" selected "); ?> >THL</option>
									</select>
								</div>								
							</div>
							<div class="form-group">
								<label for="tmt" class="col-sm-3 control-label">TMT</label>
								<div class="form-inline col-sm-9">
									<input type='text' name='tmt' id='tmt' data-format='DD-MM-YYYY' data-template='DD MMM YYYY' class='form-control tanggal' value='<?php ?>'> 
								</div>
							</div>
							<div class="form-group">
								<label for="inputUraian" class="col-sm-3 control-label">Jabatan</label>
								<div class="col-sm-5">
									<input type="txt" class="form-control" id="inputJabatan" name="inputJabatan">
								</div>								
							</div>
						</form>
					</div>
					<div class="col-sm-1">
						<div id="divImgPkg"></div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button class="btn btn-danger" data-dismiss="modal">BATAL</button>
			</div>
		</div>
	</div>
</div>
<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ -->

<script>
$(document).ready(function() {
	
	$(".tanggal").combodate({
			minYear: 1990,
			maxYear: <?php echo date('Y'); ?>
		});
	$(".day").addClass("form-control");
	$(".month").addClass("form-control");
	$(".year").addClass("form-control");
	$('#list_pegawai').dataTable({
       "dom": 'T<"clear">lfrtip',
        "tableTools": {
            "sSwfPath": "assets/DataTables/extensions/TableTools/swf/copy_csv_xls_pdf.swf" 
        }
    });
    
      
});
	
	function edit(id){
		$("#inputNama").val(id['1']);
		$("#inputTempatLahir").val(id['2']);		
		$("#inputTglLahir").val(id['3']);
		$("#inputJabatan").val(id['6']);
		//$("#status")
		$("#edit_tkk").modal("show");
	}
</script>
