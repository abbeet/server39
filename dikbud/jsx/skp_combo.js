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

function get_jabatan(nib)
{	
	var obj = document.getElementById("jabatan-view");
	var url = 'js/jabatan-view.php?';
	url = url+'nib='+nib
	
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
