
<form class="form-horizontal" method="post" action="process_add_sk.php" enctype="multipart/form-data">	
		<input type="hidden" name="fallback_url" value="<?php echo $_REQUEST[fallback_url]; ?>" />
		<input type="hidden" name="upload_only" value="<?php echo $_REQUEST[upload_only]; ?>" />
		<input type="hidden" name="id_sk" value="<?php echo $_REQUEST[id_sk]; ?>" />		
		<?php 
		if(!$_REQUEST[upload_only])
		{
		 
		?>
		<div class="page-header">
		  <h1>
		  	SK Baru<br/>
		  	<small>Entri data SK baru dan upload berkas digital</small>
		  </h1>
		</div>
		
		<!-- DATA SK -->
		<strong>Data</strong>
		<div class="well">        
        <fieldset>
          <!-- KATEGORI SK -->
          <div class="control-group">
            <label class="control-label" for="id_kategori_sk">Kategori SK:</label>
            <div class="controls">
            <?php if($_REQUEST[id_kategori_sk]): ?>              					
              <select id="id_kategori_sk" name="id_kategori_sk">
            <?php else: ?>
            	<select name="id_kategori_sk" id="id_kategori_sk">
            <?php endif; ?>
          
          <?php
          	$qKategoriSk = "SELECT id_kategori_sk, nama_sk
          					FROM kategori_sk ORDER BY nama_sk ASC";
							
			$rsKategoriSk = mysql_query($qKategoriSk);
			while ($rKategoriSk = mysql_fetch_array($rsKategoriSk)) 
			{
				if($_REQUEST[id_kategori_sk] == $rKategoriSk[id_kategori_sk])
					echo "<option value='$rKategoriSk[id_kategori_sk]' selected>$rKategoriSk[nama_sk]</option>";
				else
					echo "<option value='$rKategoriSk[id_kategori_sk]'>$rKategoriSk[nama_sk]</option>";
			}							
          ?>         
              	              	 
              </select>
            </div>
          </div>
          
          <!-- NOMOR SK -->
          <div id="control_no_sk" class="control-group">
            <label class="control-label" for="no_sk">Nomor:</label>
            <div class="controls">
              <input type="text" name="no_sk" class="input-medium" id="no_sk">              
            </div>
          </div>	
        	
          <!-- Tanggal SK -->
          <div id="control_tgl_sk" class="control-group">
            <label class="control-label" for="tgl_sk">Tanggal:</label>
            <div class="controls">
              <input type="text" name="tgl_sk" id="tgl_sk"  class="tcal" />  
              <p class="help-block">
              	Isi dengan format <strong>tanggal-bulan-tahun</strong><br/>
              	Contoh: <i>31-04-2011</i>
              </p>           
            </div>
          </div>
          
          <!-- TMT SK -->
          <div class="control-group" id="control_tmt_sk">
            <label class="control-label" for="tmt_sk">TMT:</label>
            <div class="controls">
              <input type="text" name="tmt_sk" id="tmt_sk" class="tcal" />
              <p class="help-block">
              	Isi dengan format <strong>tanggal-bulan-tahun</strong><br/>
              	Contoh: <i>31-04-2011</i>
              </p>             
            </div>
          </div>
        	
          <!-- PEMBERI SK -->
          <div class="control-group" id="control_pemberi_sk">
            <label class="control-label" for="pemberi_sk">Pemberi:</label>
            <div class="controls">
              <input name="pemberi_sk" type="text" class="input-medium" id="pemberi_sk">
              <p class="help-block">
              	Pemberi SK adalah jabatan dari pejabat yang memberikan SK.<br/>
              	Misalkan: <i>Walikota Bogor</i>
              </p>              
            </div>
          </div>		
        	
          <!-- PENGESAH SK -->
          <div class="control-group" id="control_pengesah_sk">
            <label class="control-label" for="pengesah_sk">Pengesah:</label>            
            <div class="controls">
              <input name="pengesah_sk" type="text" class="input-medium" id="pengesah_sk">
              <p class="help-block">
              	Pengesah SK adalah nama dari pejabat yang menandatangani SK.<br/>
              	Misalkan: <i>Dra. Hj. Fetty Qondarsya, M.Si</i>
              </p>              
            </div>
          </div>
          
          <!-- GOLONGAN -->
          <div class="control-group" id="control_golongan">
            <label class="control-label" for="golongan">Golongan ruang:</label>            
            <div class="controls">
              <select name="golongan" id="golongan">
			  	<option value="I/a">I/a</option>
			  	<option value="I/b">I/b</option>
			  	<option value="I/c">I/c</option>
			  	<option value="I/d">I/d</option>
			  	<option value="II/a">II/a</option>
			  	<option value="II/b">II/b</option>
			  	<option value="II/c">II/c</option>
			  	<option value="III/d">III/d</option>
				<option value="III/a">III/a</option>
			  	<option value="III/b">III/b</option>
			  	<option value="III/c">III/c</option>
			  	<option value="III/d">III/d</option>
			  	<option value="IV/a">IV/a</option>
			  	<option value="IV/b">IV/b</option>
			  	<option value="IV/c">IV/c</option>
			  	<option value="IV/d">IV/d</option>
			  	<option value="IV/e">IV/e</option>			  				  
			  </select>                      
            </div>
          </div>
          
          <!--  MASA KERJA -->
          <div class="control-group" id="control_masa_kerja">
            <label class="control-label" for="masa_kerja">Masa kerja:</label>            
            <div class="controls">
              <input name="maker_tahun" type="text" class="input-medium" id="maker_tahun"> Tahun
              <input name="maker_bulan" type="text" class="input-medium" id="maker_bulan"> Bulan              
            </div>
          </div>			
       </div>
          
       <?php } ?>  
        
          			                           
        <!-- UPLOAD BERKAS -->
        <input type="hidden" name="id_kategori_berkas" value="<?php echo $_REQUEST[id_kategori_berkas]; ?>" />
        <input type="hidden" name="nm_berkas" value="<?php echo $_REQUEST[nm_berkas]; ?>" />
        <strong>Upload berkas hasil scan</strong>
        <div class="well">
        	<div class="control-group" id="control_fileInput1">
				<label class="control-label" for="fileInput">File yang akan diupload:</label>
				<div class="controls">
				  <input name="fileInput1" class="input-file" id="fileInput1" type="file">
				  <p class="help-block">
				  	Jika berkas yang akan anda upload lebih dari satu halaman, <br/>
				  	silahkan manfaatkan field di bawah.
				  </p>			  
				</div>
				<div class="controls">
				  <input name="fileInput2" class="input-file" id="fileInput2" type="file">			  
				</div>
				<div class="controls">
				  <input name="fileInput3" class="input-file" id="fileInput3" type="file">			  
				</div>
				<div class="controls">
				  <input name="fileInput4" class="input-file" id="fileInput4" type="file">			  
				</div>
				<div class="controls">
				  <input name="fileInput5" class="input-file" id="fileInput5" type="file">			  
				</div>
				<div class="controls">
				  <input name="fileInput6" class="input-file" id="fileInput6" type="file">			  				  
				</div>				
			</div>
        </div>  
          
          
          <div class="form-actions">
            <button id="btnSubmit" type="submit" class="btn btn-primary">Proses</button>
            <button class="btn">Batalkan</button>
          </div>
        </fieldset>
      </form>
      
<script type="text/javascript">
	function validateForm()
	{
		var isValid = true;
		
		if($("#no_sk").val() == "")
		{
			$("#control_no_sk").addClass('control-group error');
			isValid = false;
		}
		else
		{
			$("#control_no_sk").addClass('control-group success');
		}
		
		if($("#tgl_sk").val() == "")
		{
			$("#control_tgl_sk").addClass('control-group error');
			isValid = false;
		}
		else
		{
			$("#control_tgl_sk").addClass('control-group success');
		}
		
		if($("#tmt_sk").val() == "")
		{
			$("#control_tmt_sk").addClass('control-group error');
			isValid = false;
		}
		else
		{
			$("#control_tmt_sk").addClass('control-group success');
		}
		
		if($("#pemberi_sk").val() == "")
		{
			$("#control_pemberi_sk").addClass('control-group error');
			isValid = false;
		}
		else
		{
			$("#control_pemberi_sk").addClass('control-group success');
		}
		
		if($("#pengesah_sk").val() == "")
		{
			$("#control_pengesah_sk").addClass('control-group error');
			isValid = false;
		}
		else
		{
			$("#control_pengesah_sk").addClass('control-group success');
		}			
		
		if($("#fileInput1").val() == "")
		{
			$("#control_fileInput1").addClass('control-group error');
			isValid = false;
		}
		else
		{
			$("#control_fileInput1").addClass('control-group success');
		}
		
		if($("#golongan").val() == "")
		{
			$("#control_golongan").addClass('control-group error');
			isValid = false;
		}
		else
		{
			$("#control_golongan").addClass('control-group success');
		}
		
		if($("#maker_tahun").val() == "" || $("#maker_bulan").val() == "")
		{
			$("#control_masa_kerja").addClass('control-group error');
			isValid = false;
		}
		else
		{
			$("#control_masa_kerja").addClass('control-group success');
		}
		
		return isValid;
	}
	
</script>


<script type="text/javascript" src="js/file_helper.js"></script>

<script type="text/javascript">
	$(document).ready(function(){
		$("#btnSubmit").click(function(){
			if(validateForm())
			{
				fileSize = checkFilesize();
				alert("ukuran file: " + fileSize);
				if(fileSize < 501)
				{
					return true
				}	
							
			}
			return false;
		})						
	});
</script>