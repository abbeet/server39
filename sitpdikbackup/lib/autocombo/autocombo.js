var xmlhttp = false;

try 
{
	xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
} 
catch (e) 
{
	try 
	{
		xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	} 
	catch (E) 
	{
		xmlhttp = false;
	}
}

if (!xmlhttp && typeof XMLHttpRequest != 'undefined') 
{
	xmlhttp = new XMLHttpRequest();
}

function get_bidang(id)
{	
	var obj = document.getElementById("bidang-view");
	var url = 'lib/autocombo/bidang-view.php?';
	url = url+'id='+id
	
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

function get_subbidang(id)
{	
	var obj = document.getElementById("subbidang-view");
	var url = 'lib/autocombo/subbidang-view.php?';
	url = url + 'id=' + id;
	
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

function get_subbidang_2(id)
{	
	var obj = document.getElementById("subbidang-view");
	var url = 'lib/autocombo/subbidang-view-2.php?';
	url = url + 'id=' + id;
	
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

function get_pegawai(id)
{	
	var obj = document.getElementById("pegawai-view");
	var url = 'lib/autocombo/pegawai-view.php?';
	url = url+'id='+id
	
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

function get_regu(id)
{	
	var obj = document.getElementById("regu-view");
	var url = 'lib/autocombo/regu-view.php?';
	url = url+'id='+id
	
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

function get_pegawai_shift(id)
{	
	var obj = document.getElementById("pegawai-shift-view");
	var url = 'lib/autocombo/pegawai-shift-view.php?';
	url = url+'id='+id
	
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


