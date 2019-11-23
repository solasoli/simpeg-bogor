var xmlhttp 

function showHint(str)
{
	if (str.length == 0)
	{
		document.getElementById("txtHint").innerHTML=""; /* suggestionnya diset kosong */
		return;
	}
	
	xmlhttp = GetXmlHttpObject(); /* GetXmlHttpObject() merupakan fungsi untuk mendapatkan objek XmlHttpRequest */
	
	if (xmlhttp == null)
	{
		alert ("Browsernya tidak mendukung XMLHTTP! coba pake gogle chrome");
		return;
	}
	
	var url="gethint.php"; /* file php yang ada di server yang akan memproses suggestion berdasarkan karakter yang udah diketik */
	url=url+"?q="+str;
	url=url+"&sid="+Math.random(); /* buat cegah loading halaman yang sama dari cache */
	xmlhttp.onreadystatechange = stateChanged; /* stateChanged adalah fungsi yang akan dipanggil ketika data dari server sudah siap dikonsumsi kembali di client */
	
	/* dua methode ini digunakan untuk mengirim data ke server */
	xmlhttp.open("GET",url,true);
	xmlhttp.send(null);
}

function stateChanged()
{
	if (xmlhttp.readyState == 4) /* 4 artinya proses di server sudah selesai */
	{
		document.getElementById("txtHint").innerHTML = xmlhttp.responseText;
		//document.getElementById("lstSuggest").style.display = "none";
	}
}

/* fungsi ini digunakan untuk menghasilkan objek XmlHttpRequest berdasarkan browser yang dipakai */
function GetXmlHttpObject()
{
	if (window.XMLHttpRequest)
	{
		/* untuk IE7+, Firefox, Chrome, Opera, Safari */
		return new XMLHttpRequest();
	}
	
	if (window.ActiveXObject)
	{
		/* untuk for IE6, IE5 */
		return new ActiveXObject("Microsoft.XMLHTTP");
	}
	
	return null;
}