<div class="row">
	<div class="col-md-12">
		<ul class="nav nav-tabs ">
		  <li role="presentation" class="active" id="list"><a href="<?php echo $BASE_URL."index3.php?x=ibe.php&y=l" ?>">Daftar Pengajuan Ijin Belajar</a></li>
		  <li role="presentation" id="add"><a href="<?php echo $BASE_URL."index3.php?x=ibe.php&y=a" ?>">Pengajuan Ijin Belajar Baru</a></li>
		  <li role="presentation" id="need"><a href="<?php echo $BASE_URL."index3.php?x=ibe.php&y=f" ?>">Kebutuhan Formasi</a></li>
		</ul>
	</div>
</div>
<br>

<?php

switch($_GET['y']){
	case 'l':
		include "modul/ijin_belajar/ijin_belajar_list.php";
		break;
	case 'a':
		include "modul/ijin_belajar/ijinbelajar_add.php";
		break;
	case 'f':
		include "modul/ijin_belajar/formasi.php";
		break;
	default:
		echo "PAGE NOT FOUND";
}