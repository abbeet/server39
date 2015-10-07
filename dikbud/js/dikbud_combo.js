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

function get_ik(kdunitkerja,th)
{	
	var obj = document.getElementById("ik-view");
	var url = 'js/ik-view.php?';
	url = url+'kdunitkerja='+kdunitkerja+'&th='+th
	
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


