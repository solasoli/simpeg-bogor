
var idp			= idp;
var idskp		= getUrlParameter('idskp');
var idtarget	= getUrlParameter('idtarget');
var t			= getUrlParameter('t');

$(document).ready(function(){
	
	
	$(".btn-skp").addClass("disabled");
	$(".btn-reviewtarget").addClass("disabled");
	$(".btn-real").addClass("disabled");	
	$(".btn-reviewreal").addClass("disabled");
	$(".btn-perilaku").addClass("disabled");
	if(idskp){
		$.post("skp.php",{aksi: "cekStatus", idskp: idskp})
		 .done(function(data){
			//alert(data);
						
			if(data < 2){
				$(".btn-review").addClass("hidden");	
							
			}
			if(data == '0' || data == '2'){				
				$(".btn-skp").removeClass("disabled");
				$("#btnAjukanSkp").removeClass("hide");
				$("#btnBatalAjukanSkp").addClass("hide");
				$("#btnBatalAjukanRealisasi").addClass("hide");
				
			}
			if(data == '1' ){
				$(".btn-reviewtarget").removeClass("disabled");
				$("#btnAjukanSkp").addClass("hide");
				$("#btnBatalAjukanSkp").removeClass("hide");
				$("#btnBatalAjukanRealisasi").addClass("hide");
				
			}
			if(data >= 3){
				$(".btn-skp").addClass("hide");
				//alert(data);	
				$(".btn-reviewtarget").addClass("hide");
				$("#drafttarget").addClass("hide");				
				$("#drafttarget").removeClass("visible-print");	
				$("#btn-cancelTarget").removeClass("hide");					
			}
			if(data == '3' || data == '5'){				
				$(".btn-real").removeClass("disabled");
				$("#btnBatalAjukanRealisasi").addClass("hide");
				
			}
			if(data == '4'){	
				$(".btn-real").addClass("hide");			
				$(".btn-reviewreal").removeClass("disabled");
				$("#btnBatalAjukanRealisasi").removeClass("hide");
				
			}
			if(data == '6'){
				//alert(data);
				$("#draftrealisasi").addClass("hide");
				$(".btn-revisi-toggle").addClass("hidden");
				$("#draftrealisasi").removeClass("visible-print");
				$(".btn-perilaku").removeClass("disabled");
				$("#btnBatalAjukanRealisasi").addClass("hide");
				$("#btn-cancelAcc").removeClass("hide");
			}
			if(data == '7'){
				//alert(data);
				$(".btn-real").addClass("hidden");
				$(".btn-revisi").removeClass("hidden");
				$(".btn-revisi-done").removeClass("hidden");				
				$(".btn-revisi-add").addClass("hidden");
				$("#btnBatalAjukanRealisasi").addClass("hide");
			}
		});
	}
	
	if(t){
		
		if(t == 'final'){
			$(".in").removeClass("in");
			$("#collapseThree").addClass("in");
		}
	}
});


function setStatus(kodeStatus){
		
		//alert(idskp);
		$.post("skp.php",{
			aksi:"setStatus",
			idskp: idskp,
			kodeStatus:kodeStatus
			})
		.done(function(data){
			//alert(data);			
			//$(".btn-skp").addClass("disabled");
			//$("html").append(data);
			window.location.reload();
		});
		
		
}

function getUrlParameter(sParam)
{
    var sPageURL = window.location.search.substring(1);
    var sURLVariables = sPageURL.split('&');
    for (var i = 0; i < sURLVariables.length; i++) 
    {
        var sParameterName = sURLVariables[i].split('=');
        if (sParameterName[0] == sParam) 
        {
            return sParameterName[1];
        }
    }
}       
