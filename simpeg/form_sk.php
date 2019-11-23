<script type="text/javascript">
function Save(){
  if($("#nomorSk").val() != '' &&
     $("#tanggalSk").val() != '' &&
     $("#tmtk").val() != '' &&
     $("#pemberiSk").val() != '' &&
     $("#pengesahSk").val() != '' &&
     $("#makerTahun").val() != '' &&
     $("#makerBulan").val() != '' 
  )
  {
    var id_pegawai = $("#idPegawai").val();
    var no_sk = $("#nomorSk").val();
    var tmt_sk = $("#tmtSk").val();
    var tanggal_sk = $("#tanggalSk").val();
    var pemberi_sk = $("#pemberiSk").val(); 
    var pengesah_sk = $("#pengesahSk").val();
    var pangkat_gol = $("#golongan").val();
    var maker_tahun = $("#makerTahun").val();
    var maker_bulan = $("#makerBulan").val();
    var id_berkas = $("#idBerkas").val();
    
    $.post('insert_sk.php', {
      id_pegawai: id_pegawai,
      no_sk: no_sk,
      tmt_sk: tmt_sk,
      tanggal_sk: tanggal_sk,
      pemberi_sk: pemberi_sk,
      pengesah_sk: pengesah_sk,
      pangkat_gol: pangkat_gol,
      maker_tahun: maker_tahun,
      maker_bulan: maker_bulan,
      id_berkas: id_berkas
    }, function(data){
      
       Ext.Msg.alert('Informasi', data);
       $.post('lock_berkas.php', { status: '-', id_berkas: id_berkas });
       $("#pnlGrid").load('berkas_digital_grid.php');
       $("#pnlGrid").fadeIn();
       
       //$("#form").reset();
       //$("#pnlGrid").html(data);
    });  
  }
  else{
    Ext.Msg.alert('Warning', 'Semua field yang ada harus diisi.');
    //alert('Semua field harus terisi.');
  }  
}

function Cancel(id_berkas){
	$.post('lock_berkas.php', { status: '-', id_berkas: id_berkas })
	$("#pnlGrid").load('berkas_digital_grid.php');
	$("#pnlGrid").fadeIn();
}
</script>

<?php
include_once "konek.php";

extract($_POST);
?>
<form id="form" action="">
<input type="hidden" id="idPegawai" value="<?php echo $id_pegawai; ?>" />
<input type="hidden" id="idBerkas" value="<?php echo $id_berkas; ?>" />
<fieldset>
<legend>Data SK</legend>
<table>
  <tr>
    <td>Nomor SK
    </td>
    <td> : <input type="text" id="nomorSk" />
    </td>
  </tr>
  <tr>
    <td>TMT SK
    </td>
    <td>
        : <input type="text" id="tmtSk">
    </td>
  </tr>
  <tr>
    <td>Tanggal SK
    </td>
    <td>
        : <input type="text" id="tanggalSk" value="<?php echo $tgl_berkas; ?>"/>
    </td>
  </tr>
  <tr>
    <td>Pemberi SK
    </td>
    <td>
        : <input type="text" id="pemberiSk" value="Walikota Bogor">
    </td>
  </tr>
  <tr>
    <td>Pengesah SK
    </td>
    <td>
        : <input type="text" id="pengesahSk" value="Walikota Bogor">
    </td>
  </tr>
  <tr>
    <td>Golongan
    </td>
    <td>
        : <select id="golongan">
          <option value="I/a">I/a</option>
          <option value="I/b">I/b</option>
          <option value="I/c">I/c</option>
          <option value="I/d">I/d</option>
          <option value="II/a">II/a</option>
          <option value="II/b">II/b</option>
          <option value="II/c">II/c</option>
          <option value="II/d">II/d</option>
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
    </td>
  </tr>
  <tr>
    <td>Masa Kerja Golongan
    </td>
    <td>
        : <input type="text" id="makerTahun" size="5"> Tahun <input type="text" id="makerBulan" size="5"> Bulan
    </td>
  </tr>
  <tr>
    <td>
    </td>
    <td>
    <input type="button" id="btnInsert" value="Insert" onClick="Save()">
	<input type="button" id="btnCancel" value="Cancel" onClick="Cancel('<?php echo $id_berkas; ?>')" />
    </td>
  </tr>            
</table>
</fieldset>
</form>

<script type="text/javascript">
$(document).ready(function(){
  $("#tanggalSk").datepicker({
    dateFormat: 'yy-mm-dd'
  });
  
  $("#tmtSk").datepicker({
    dateFormat: 'yy-mm-dd'
  });
});
</script>