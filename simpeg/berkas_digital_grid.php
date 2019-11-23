<script type="text/javascript">
function loadForm(id_pegawai, nip ,id_berkas, tgl_berkas){
  // Load document
  $("#pnlBerkas").html("LOADING");
  $.post('berkas_digital_detail.php', 
    { 
      nip: nip,
      id_berkas: id_berkas  
    }, function(data){
    $("#pnlBerkas").html(data);
  });
  
  // Load form records
  $.post('form_sk.php', { 
      tgl_berkas: tgl_berkas,
      id_pegawai: id_pegawai,
      id_berkas: id_berkas 
    }, function(data){	
		$("#frmData").html(data);
		$("#pnlGrid").hide();
  });
  
  $.post('lock_berkas.php', { status: 'editing', id_berkas: id_berkas });
  
  $("#nomorSk").focus();  
}
</script>

<?php
include_once "konek.php";

$q = "SELECT *
      FROM berkas b
      INNER JOIN pegawai p
        ON b.id_pegawai = p.id_pegawai
      WHERE nm_berkas LIKE '%cpns%'";
      
$q = mysqli_query($mysqli,$q);
?>

<div style="height: 300px;
            max-height: 300px;
            overflow: auto;
            border: 1px solid grey;">
    <table border="1">
      <thead>
        <th>Nama</th>
        <th>NIP</th>
        <th>&nbsp;</th>
      </thead>
      <tbody>
      <?php while ($r = mysqli_fetch_array($q)): ?>
      <?php
        $qCount = "SELECT COUNT(*)
                   FROM sk s 
                   WHERE s.id_kategori_sk = 6
                    AND s.id_pegawai = $r[id_pegawai]";
        //echo $qCount;
        $rCount = mysqli_query($mysqli,$qCount);
        $rCount = mysqli_fetch_array($rCount);        
        if($rCount[0] == 0)
        {
      ?>
      <tr <? 
		if($r[status] == 'editing'){
			echo "style: background-color: yellow;";
		}
	  ?>>
        <td><?php echo $r[nama]; ?></td>
        <td><?php echo $r[nip_baru]; ?></td>
        <td><input type="button" value="Select" onClick="loadForm(<?php echo $r[id_pegawai]; ?>, <?php echo "'$r[nip_baru]'"; ?>, <?php echo $r[id_berkas]; ?>, <?php echo "'$r[tgl_berkas]'"; ?> )" /></td>
      </tr>
      <?php } ?>
      <?php endwhile; ?>
      </tbody>
    </table>    
</div>