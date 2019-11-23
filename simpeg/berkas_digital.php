<?php
include_once "konek.php";
?>
<html>
<head>
<title>
eArchieve - SIMPEG Kota Bogor
</title>

<link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/themes/base/jquery-ui.css" type="text/css" media="all" />
<link rel="stylesheet" href="http://static.jquery.com/ui/css/demo-docs-theme/ui.theme.css" type="text/css" media="all" />
<!--<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js" type="text/javascript"></script> -->
<script src="js/jquery.js" type="text/javascript"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.min.js" type="text/javascript"></script>


<link rel="stylesheet" type="text/css" href="http://extjs.cachefly.net/ext-4.0.2a/resources/css/ext-all.css"/>
<script type="text/javascript" src="http://extjs.cachefly.net/ext-4.0.2a/ext-all.js"></script>
</head>
<body>
<h2>
Berkas Digital
</h2>
<table>              
<tr>
  <td>
    <div style="border: 3px solid brown;
                min-width: 700px;
                max-width: 700px;
                min-height: 600px;
                max-height: 600px;
                overflow: auto;" id="pnlBerkas">    
      NO DATA
    </div>
  </td>
  <td style="vertical-align: top">  
  <div id="pnlGrid">
    <?php include "berkas_digital_grid.php"; ?>   
  </div>
  <br/>
  <div id="frmData">          
  </div>                    
  </td>
</tr>
</table>
</body>
</html>
