var xmlhttp = false;

try {
	xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
} catch (e) {
	try {
		xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	} catch (E) {
		xmlhttp = false;
	}
}

if (!xmlhttp && typeof XMLHttpRequest != 'undefined') {
	xmlhttp = new XMLHttpRequest();
}

function get_bidang_phlin(kdbidang)
{	
	var obj = document.getElementById("subbidang-view");
	var url = 'js/subbidang-view.php?';
	url = url+'kdbidang='+kdbidang
	
	xmlhttp.open("GET", url);
	
	xmlhttp.onreadystatechange = function() 
	{
		if ( xmlhttp.readyState == 4 && xmlhttp.status == 200 ) 
		{
			obj.innerHTML = xmlhttp.responseText;
		} 
		else 
		{
//			obj.innerHTML = "<div align ='left'><img src='css/images/waiting.gif' alt='Loading' /></div>";
		}
	}
	xmlhttp.send(null);
}

function get_kabupaten(kdprov)
{	
	var obj = document.getElementById("kabupaten-view");
	var url = 'js/kabupaten-view.php?';
	url = url+'kdprov='+kdprov
	
	xmlhttp.open("GET", url);
	
	xmlhttp.onreadystatechange = function() 
	{
		if ( xmlhttp.readyState == 4 && xmlhttp.status == 200 ) 
		{
			obj.innerHTML = xmlhttp.responseText;
		} 
		else 
		{
//			obj.innerHTML = "<div align ='left'><img src='css/images/waiting.gif' alt='Loading' /></div>";
		}
	}
	xmlhttp.send(null);
}

function get_subbidang_phlin(kdsubbidang,kdbidang)
{	
	var obj = document.getElementById("jenis-view");
	var url = 'js/jenis-view.php?';
	url = url+'kdbidang='+kdbidang+'&kdsubbidang='+kdsubbidang
	
	xmlhttp.open("GET", url);
	
	xmlhttp.onreadystatechange = function() 
	{
		if ( xmlhttp.readyState == 4 && xmlhttp.status == 200 ) 
		{
			obj.innerHTML = xmlhttp.responseText;
		} 
		else 
		{
//			obj.innerHTML = "<div align ='left'><img src='css/images/waiting.gif' alt='Loading' /></div>";
		}
	}
	xmlhttp.send(null);
}
