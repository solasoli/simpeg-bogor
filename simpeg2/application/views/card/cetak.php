<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<script>
panjul(x)
{
alert(x);

}

</script>
<style type="text/css">

table#card-depan{
	background: url(<?php echo base_url('images/idcard.jpg');?>) !important;
	-webkit-print-color-adjust:exact;
	align:center;
	padding:0px;
	width:100%;
	margin:0;
	position:relative;
	
}
table#card-belakang{
	background: url(<?php echo base_url('images/silver.png');?>) !important;
	-webkit-print-color-adjust:exact;
	font-size: 5pt !important;
	align:center;
    margin-left:2px !important;
	width:98%;
	position:relative;
	font-family: Arial;
    font-weight: bold;
}

.crop {
    width: 180px;
    overflow: hidden;
    margin-bottom: 15px;
    margin-top: 5px;
}

img#barcode {
    width:200px !important;
    margin-left: -100px;
    position: absolute;
    clip: rect(0px,192px,100px,7px); /* top,right,bottom,left */
}

</style>

    <table  border="0" id="card-depan" >
        <tr>
			<td align="center"><br>
                <img style="width: 45px !important;" id="logo-card" src="<?php echo base_url('images/logo_kota.png');?>" >
                <br />
            </td>
		</tr>  
		<tr>
			<td align="center">
                <div style="font-family: Impact !important;font-size: medium;
			    height: 15px !important; margin-top: 5px;">PEMERINTAH KOTA BOGOR</div><br /></td>
		</tr>
		<tr>
			<td align="center">
                <img id="photo" style="width: 100px !important; height: 130px !important;" class="rounded bd-black"
                     src="<?php echo "http://".$_SERVER['HTTP_HOST']."/simpeg/foto/".$id_pegawai.".jpg" ?>" >
                <br />
            </td>
		</tr>
		<tr>
			<td align="center">
               <div style="margin-top: 10px; font-size:<?php echo strlen($pegawai->nama_lengkap)>20?'x-small':'small'; ?> !important; font-weight: bold; font-family: Arial !important;"> <?php echo strtoupper($pegawai->nama_lengkap)."<br/>" ?> </div>
                <div class="crop"><img id="barcode" src="<?php echo base_url().'card/barcode/'.$pegawai->nip_baru; ?>"/></div>
                <div style="font-size:0.8em; margin-bottom: 30px !important;">NIP. <?php echo $pegawai->nip_baru;  ?> <br></div>
            </td>
		</tr>
    </table>

        <table id="card-belakang" >
            <tr>
                <td width="25%" style="padding-left: 10px;padding-top: 20px;">Nama</td>
                <td style="padding-top: 20px;">:</td>
                <td style="padding-top: 20px;"><?php echo strtoupper($pegawai->nama_lengkap) ?></td>
            </tr>
            <tr>
                <td style="padding-left: 10px;">NIP</td>
                <td>:</td>
                <td><?php echo $pegawai->nip_baru ?></td>
            </tr>
            <tr>
                <td style="padding-left: 10px;">TTL</td>
                <td>:</td>
                <td><?php echo $pegawai->tempat_lahir.", ".$this->format->date_dmy($pegawai->tgl_lahir) ?></td>
            </tr>
            <tr>
                <td style="padding-left: 10px;">JK</td>
                <td>:</td>
                <td><?php echo $pegawai->jenis_kelamin == 1 ? 'Laki-laki' : 'Wanita' ?></td>
            </tr>
            <tr>
                <td style="padding-left: 10px;">Agama</td>
                <td>:</td>
                <td><?php echo $pegawai->agama ?></td>
            </tr>
            <tr>
                <td style="padding-left: 10px;">Gol. Darah</td>
                <td>:</td>
                <td><?php echo $pegawai->gol_darah ?></td>
            </tr>
            <tr valign="top">
                <td style="padding-left: 10px;">Alamat</td>
                <td>:</td>
                <td><?php echo $pegawai->alamat ?></td>
            </tr>
            <tr>
                <td style="padding-left: 10px;">Telp</td>
                <td>:</td>
                <td><?php echo $pegawai->telepon ?></td>
            </tr>
            <tr>
                <td style="padding-left: 10px;">Ponsel</td>
                <td>:</td>
                <td><?php echo $pegawai->ponsel ?></td>
            </tr> 
            <tr>
                <td></td>
                <td></td>
                <td align="center">
                    <div style="margin-top: 14px; font-weight:bold;">
                    Bogor, <?php echo $today; ?></br>
                    a.n. Walikota Bogor</br>
                    Sekretaris Daerah
                    </br>
                    <img src="<?php echo base_url('images/tandatangansekda.png')?>" style="height:1.5cm"/>
                    </br>
                    <span style="text-decoration:underline !important;font-weight: bold;">
                        Drs. H. ADE SARIP HIDAYAT, M.Pd</span></br>
                    NIP. 196009101980031003</div>
                </td>
            </tr>
            <tr>
                <td align="center" colspan="3" style="padding-top:5px">
                <hr style="height:2px !important; color: #000 !important; width: 100% !important;
                background-color: #000 !important; margin-bottom: <?php echo strlen($pegawai->nama_lengkap)>29?'0px':'10px'; ?> !important;
                margin-top: 0px !important;">
                <div align="center" style="font-size:0.9em; font-weight: bold;">
                 Kartu tanda pengenal ini milik Pemerintah Kota Bogor</br>
                 bagi siapa yang menemukan kartu ini mohon untuk</br>
                 mengembalikan ke Pemerintah Kota Bogor</div>
                     
                 <div style="font-size:0.9em; font-style:italic; padding-top:3px;font-weight: bold;">
                     HANYA BERLAKU SELAMA PEMEGANG <br>MENJADI PEGAWAI NEGERI SIPIL</div><br>
                <br>
                </td>
            </tr> 
        </table>