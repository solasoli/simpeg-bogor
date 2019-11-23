<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<style type="text/css">
	
table#card-depan{
	background: url(<?php echo base_url('images/idcard.jpg');?>);
	-webkit-print-color-adjust:exact;
	align:center;
	padding-top:0px;
	width:100%;
	margin:0;
	position:relative;
	
}
table#card-belakang{
	background: url(<?php echo base_url('images/silver.png');?>);
	-webkit-print-color-adjust:exact;
	font-size: 7pt !important;
	align:center;
	padding-top:10px;
	width:100%;
	margin:0;
	position:relative;
	
}

@media print{
	
	
	table#card-depan{
		
		vertical-align: middle;
		margin:0;
		width:100%;
		position:absolute;
	}
	
	table#card-belakang{
		padding-top:10px;
	}
	
	#depan:after{
		content: url(<?php echo base_url('images/idcard.jpg');?>);
		position: absolute;
        z-index: -100;
		
	}
	table#card-belakang:before{
		content: url(<?php echo base_url('images/silver.png');?>);
		position: absolute;
        z-index: -1;
		
	}
	
}

</style>

<div id="card-layout" align="center">
    <div id="depan" align="center">
    <table  border="0" id="card-depan" >
        <tr>
			<td align="center"><img id="logo-card" src="<?php echo base_url('images/logo_kota.png');?>" style="width:18em !important;height:15em !important;"></img> <br /></td>
		</tr>  
		<tr>
			<td align="center"><strong>PEMERINTAH KOTA BOGOR</strong><br /></td>
		</tr>
		<tr>
			<td align="center"><img id="photo" class="rounded bd-black" src="<?php echo "http://".$_SERVER['HTTP_HOST']."/simpeg/foto/".$pegawai->id_pegawai.".jpg" ?>" ></img><br /></td></td>
			<br/>
		</tr>
		<tr>
			<td align="center"><strong> 
               <div style="font-size:0.8em"> <?php echo $pegawai->nama_lengkap."</strong><br/>" ?> </div></strong><br />
                <?php echo '<img  width="80%" id="barcode" src="'.base_url().'card/barcode/'.$pegawai->nip_baru.'" >'; ?><br />
                <div style="font-size:0.8em"> <?php echo $pegawai->nip_baru;  ?> </div>
            </td>
		</tr>
    </table>
    </div>
    <div class="page-break"></div>
	
    <div id="belakang">
        <table id="card-belakang" >
            <tr>
                <td width="25%">Nama</td>
                <td>:</td>
                <td><?php echo $pegawai->nama ?></td>
            </tr>
            <tr>
                <td>NIP</td>
                <td>:</td>
                <td><?php echo $pegawai->nip_baru ?></td>
            </tr>
            <tr>
                <td>TTL</td>
                <td>:</td>
                <td><?php echo $pegawai->tempat_lahir.", ".$this->format->date_dmy($pegawai->tgl_lahir) ?></td>
            </tr>
            <tr>
                <td>JK</td>
                <td>:</td>
                <td><?php echo $pegawai->jenis_kelamin == 1 ? 'Laki-laki' : 'Wanita' ?></td>
            </tr>
            <tr>
                <td>Agama</td>
                <td>:</td>
                <td><?php echo $pegawai->agama ?></td>
            </tr>
            <tr>
                <td>Gol. Darah</td>
                <td>:</td>
                <td><?php echo $pegawai->gol_darah ?></td>
            </tr>
            <tr valign="top">
                <td >Alamat</td>
                <td>:</td>
                <td><?php echo $pegawai->alamat ?></td>
            </tr>
            <tr>
                <td>Telp</td>
                <td>:</td>
                <td><?php echo $pegawai->telp ?></td>
            </tr>
            <tr>
                <td>Ponsel</td>
                <td>:</td>
                <td><?php echo $pegawai->ponsel ?></td>
            </tr> 
            <tr>
                <td></td>
                <td></td>
                <td align="center">
					<br/><br/>
                    Bogor,   Mei 2016</br>
                    a.n. Walikota Bogor</br>
                    Sekretaris Daerah
                    </br>
                    <img src="<?php echo base_url('images/tandatangansekda.png')?>" style="height:1.5cm"/> 
                    </br>
                    <span style="text-decoration:underline !important;">Drs. H. ADE SARIP HIDAYAT, M.Pd</span></br>
                    NIP. 19600910198003 1 003
                </td>
            </tr>
            <tr>
                <td align="center" colspan="3" style="padding-top:5px">
            
                <div align="center" style="font-size:0.6em">
                 Kartu tanda pengenal ini milik Pemerintah Kota Bogor</br>
                 bagi siapa yang menemukan kartu ini mohon untuk</br>
                 mengembalikan ke Pemerintah Kota Bogor
                                  </div>
                     
                 <div style="font-size:0.6em; font-style:italic; padding-top:3px">HANYA BERLAKU SELAMA PEMEGANG MENJADI PEGAWAI NEGERI SIPIL</div>
                 
                </td>
            </tr> 
        </table>
    </div>
</div>
