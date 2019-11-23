<html>
<head>
<script type="text/javascript" language="JavaScript">
<!-- Copyright 2006,2007 Bontrager Connection, LLC
// http://bontragerconnection.com/ and http://www.willmaster.com/
// Version: July 28, 2007
var cX = 0; var cY = 0; var rX = 0; var rY = 0;
function UpdateCursorPosition(e){ cX = e.pageX; cY = e.pageY;}
function UpdateCursorPositionDocAll(e){ cX = event.clientX; cY = event.clientY;}
if(document.all) { document.onmousemove = UpdateCursorPositionDocAll; }
else { document.onmousemove = UpdateCursorPosition; }
function AssignPosition(d) {
if(self.pageYOffset) {
	rX = self.pageXOffset;
	rY = self.pageYOffset;
	}
else if(document.documentElement && document.documentElement.scrollTop) {
	rX = document.documentElement.scrollLeft;
	rY = document.documentElement.scrollTop;
	}
else if(document.body) {
	rX = document.body.scrollLeft;
	rY = document.body.scrollTop;
	}
if(document.all) {
	cX += rX; 
	cY += rY;
	}
d.style.left = (cX+10) + "px";
d.style.top = (cY+10) + "px";
}
function HideContent(d) {
if(d.length < 1) { return; }
document.getElementById(d).style.display = "none";
}
function ShowContent(d) {
if(d.length < 1) { return; }
var dd = document.getElementById(d);
AssignPosition(dd);
dd.style.display = "block";
}
function ReverseContentDisplay(d) {
if(d.length < 1) { return; }
var dd = document.getElementById(d);
AssignPosition(dd);
if(dd.style.display == "none") { dd.style.display = "block"; }
else { dd.style.display = "none"; }
}
//-->
</script>

</head>
<body>
<a 
   onmouseover="ReverseContentDisplay('uniquename1'); return true;"
   href="javascript:ReverseContentDisplay('uniquename1')">
[show on mouseover, hide on mouse over - toggle]
</a>
<div 
   id="uniquename1" 
   style="display:none; 
      position:absolute; 
      border-style: solid; 
      background-color: white; 
      padding: 5px;">
Content goes here.
</div>
<br />
<a 
   onmouseover="ShowContent('uniquename2'); return true;"
   href="javascript:ShowContent('uniquename2')">
[show, content has "hide" link]
</a>
<div 
   id="uniquename2" 
   style="display:none; 
      position:absolute; 
      border-style: solid; 
      background-color: white; 
      padding: 5px;">
Content goes here. 
<a 
   onmouseover="HideContent('uniquename2'); return true;"
   href="javascript:HideContent('uniquename2')">
[hide]
</a>
</div>
<br />
<a 
   onmousemove="ShowContent('uniquename4'); return true;"
   onmouseover="ShowContent('uniquename4'); return true;"
   onmouseout="HideContent('uniquename4'); return true;"
   href="javascript:ShowContent('uniquename4')">
[show on mouseover, hide on mouseout]
</a>
<div 
   id="uniquename4" 
   style="display:none; 
      position:absolute; 
      border-style: solid; 
      background-color: white; 
      padding: 5px;">
Content goes here.
</div>


</body>
</html>