<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<script language="javascript" src="js/jquery-1.4.2.min.js"></script>
 <script>
  $(document).ready(function() {
    setInterval(function() {
	     $('#jan').load('naikpangkat.php?bul=01&acak='+ Math.random());
    }, 1000);
  });
</script>

 <script>
  $(document).ready(function() {
    setInterval(function() {
	     $('#feb').load('naikpangkat2.php?bul=02&acak='+ Math.random());
    }, 1000);
  });
</script>

 <script>
  $(document).ready(function() {
    setInterval(function() {
	     $('#oct').load('naikpangkat3.php?bul=02&acak='+ Math.random());
    }, 1000);
  });
</script>
<script src="SpryAssets/SpryTabbedPanels.js" type="text/javascript"></script>
<link href="SpryAssets/SpryTabbedPanels.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div id="TabbedPanels1" class="TabbedPanels">
  <ul class="TabbedPanelsTabGroup">
    <li class="TabbedPanelsTab" tabindex="0"><h3>Periode April</h3></li>
    <li class="TabbedPanelsTab" tabindex="0"><h3>Periode Oktober versi Cunda</h3></li>
    <li class="TabbedPanelsTab" tabindex="0"><h3>Periode Oktober versi Tosan</h3></li>
   
  </ul>
  <div class="TabbedPanelsContentGroup">
    <div class="TabbedPanelsContent"><div id="jan"> </div></div>
    <div class="TabbedPanelsContent"><div id="feb"> </div></div>
    <div class="TabbedPanelsContent"><div id="oct"> </div></div>
  
    
  </div>
</div>
<script type="text/javascript">
var TabbedPanels1 = new Spry.Widget.TabbedPanels("TabbedPanels1");
</script>
</body>
</html>