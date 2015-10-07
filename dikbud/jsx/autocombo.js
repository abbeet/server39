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

function get_giat(kdgiat)
{	
	var obj = document.getElementById("output-view");
	var url = 'js/output-view.php?';
	url = url+'kdgiat='+kdgiat
	
	xmlhttp.open("GET", url);
	
	xmlhttp.onreadystatechange = function() 
	{
		if ( xmlhttp.readyState == 4 && xmlhttp.status == 200 ) 
		{
			obj.innerHTML = xmlhttp.responseText;
		} 
		else 
		{
			obj.innerHTML = "<div align ='left'><img src='css/images/waiting.gif' alt='Loading' /></div>";
		}
	}
	xmlhttp.send(null);
}

function get_unitkerja(kdunitkerja)
{	
	var obj = document.getElementById("kegiatan-view");
	var url = 'js/kegiatan-view.php?';
	url = url+'kdunitkerja='+kdunitkerja
	
	xmlhttp.open("GET", url);
	
	xmlhttp.onreadystatechange = function() 
	{
		if ( xmlhttp.readyState == 4 && xmlhttp.status == 200 ) 
		{
			obj.innerHTML = xmlhttp.responseText;
		} 
		else 
		{
			obj.innerHTML = "<div align ='left'><img src='css/images/waiting.gif' alt='Loading' /></div>";
		}
	}
	xmlhttp.send(null);
}

