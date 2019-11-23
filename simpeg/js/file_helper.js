// CHECK The File Size
function checkFilesize()
{
	var iSize = ($("#fileInput1")[0].files[0].size / 1024); 
     /*if (iSize / 1024 > 1) 
     { 
        if (((iSize / 1024) / 1024) > 1) 
        { 
            iSize = (Math.round(((iSize / 1024) / 1024) * 100) / 100);
            //$("#lblSize").html( iSize + "Gb"); 
            //alert(iSize + "Gb");
        }
        else
        { 
            iSize = (Math.round((iSize / 1024) * 100) / 100)
            //$("#lblSize").html( iSize + "Mb");
            //alert(iSize + "Mb") 
        } 
     } 
     else 
     {
        iSize = (Math.round(iSize * 100) / 100)
        //$("#lblSize").html( iSize  + "kb");
        //alert(iSize + "kb"); 
     }*/
     return iSize;
 } // End of function checkFileSize 