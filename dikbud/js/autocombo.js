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

function get_ikk(kdunitkerja,th)
{	
	var obj = document.getElementById("ikk-view");
	var url = 'js/ikk-view.php?';
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

function get_indikator(no_ikk,kdunitkerja,th)
{	
	var obj = document.getElementById("indikator-view");
	var url = 'js/indikator-view.php?';
	url = url+'no_ikk='+no_ikk+'&kdunitkerja='+kdunitkerja+'&th='+th
	
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

function get_iku_lapan(no_ikk,th)
{	
	var obj = document.getElementById("iku-view");
	var url = 'js/iku-view.php?';
	url = url+'no_ikk='+no_ikk+'&th='+th
	
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

function get_iku_deputi(kdunitkerja,th)
{	
	var obj = document.getElementById("iku-deputi-view");
	var url = 'js/iku-deputi-view.php?';
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

function get_indikator_deputi(no_ikk,kdunitkerja,th)
{	
	var obj = document.getElementById("indikator-deputi-view");
	var url = 'js/indikator-deputi-view.php?';
	url = url+'no_ikk='+no_ikk+'&kdunitkerja='+kdunitkerja+'&th='+th
	
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

function get_sasaran_renstra(kdunitkerja,th)
{	
	var obj = document.getElementById("sasaran-iku-view");
	var url = 'js/sasaran-iku-view.php?';
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
			obj.innerHTML = "<div align ='left'><img src='css/images/waiting.gif' alt='Loading' /></div>";
		}
	}
	xmlhttp.send(null);
}

function get_sasaran_unit(no_sasaran,renstra,kdunitkerja)
{	
	var obj = document.getElementById("iku-sasaran-view");
	var url = 'js/iku-sasaran-view.php?';
	url = url+'kdunitkerja='+kdunitkerja+'&renstra='+renstra+'&no_sasaran='+no_sasaran
	
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
