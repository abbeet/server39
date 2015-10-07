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

function get_jabatan(nip,th)
{	
	var obj = document.getElementById("jabatan-view");
	var url = 'js/jabatan-view.php?';
	url = url+'nip='+nip+'&th='+th
	
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

function get_atasan(kdjabatan,kdunit)
{	
	var obj = document.getElementById("atasan-view");
	var url = 'js/atasan-view.php?';
	url = url+'kdjabatan='+kdjabatan+'&kdunit='+kdunit
	
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

function get_nama_jabatan(kdunitkerja)
{	
	var obj = document.getElementById("nama_jabatan_view");
	var url = 'js/nama_jabatan_view.php?';
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

function get_info_jabatan(kdunitkerja)
{	
	var obj = document.getElementById("info_jabatan_view");
	var url = 'js/info_jabatan_view.php?';
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

function get_nmjabatan(kdunitkerja)
{	
	var obj = document.getElementById("nama_jabatan_view");
	var url = 'js/nmjabatan_view.php?';
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
