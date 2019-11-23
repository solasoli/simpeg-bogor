<style>
    .paginate {
        font-family: Arial, Helvetica, sans-serif;
        font-size: .7em;
    }

    a.paginate {
        border: 1px solid #000080;
        padding: 2px 6px 2px 6px;
        text-decoration: none;
        color: #000080;
    }

    a.paginate:hover {
        background-color: #000080;
        color: #FFF;
        text-decoration: underline;
    }

    a.current {
        border: 1px solid #000080;
        font: bold .7em Arial,Helvetica,sans-serif;
        padding: 2px 6px 2px 6px;
        cursor: default;
        background:#000080;
        color: #FFF;
        text-decoration: none;
    }

    span.inactive {
        border: 1px solid #999;
        font-family: Arial, Helvetica, sans-serif;
        font-size: .7em;
        padding: 2px 6px 2px 6px;
        color: #999;
        cursor: default;
    }
</style>

<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<br>
<div class="container">
    <strong>DAFTAR PROYEK PERUBAHAN</strong>
 
              <table class="table bordered striped" id="lst_cuti">
        <thead style="border-bottom: solid #a4c400 2px;">
        <tr>
            <th>No</th>
            <th> Nama </th>
            <th> Judul Proyek Perubahan </th>
            <th> Diklat Pim</th>
            <th> Tahun </th>
            <th> Approval </th>
            </tr>
                 </thead>
            <?php
			$i=1;
			foreach ($proper as $oper)
			{
			  echo ("<tr>
            <td>$i</td>
            <td> $oper->nama </td>
            <td> $oper->judul </td>
            <td> $oper->tingkat</td>
            <td> $oper->tahun </td>
            <td>"); 
			if($oper->cek==0)
			echo("<a href=".base_url()."diklat/approve/$oper->id class='button default'> Approve</a>");
			else
			echo("Approved"); 
			
			echo("</td>
            </tr>");
			
			$i++;
			}
			
			
			?>
       
    
</table>
</div>
