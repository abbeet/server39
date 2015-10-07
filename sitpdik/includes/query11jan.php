<?php
	#@
	
	function get_field($table) 
	{
		switch ($table) 
		{
			case "jenissurat"		: $field = array("IdJenisSurat", "NmJenisSurat"); break;
			case "sifatsurat"		: $field = array("IdSifat", "NmSifat"); break;
			case "kategorisurat"	: $field = array("IdKategori", "NmKategori"); break;
			case "klasifikasisurat"	: $field = array("IdKlasifikasi", "NmKlasifikasi"); break;
			case "unit"				: $field = array("kdunit", "nmunit", "sktunit"); break;
			case "pegawai"			: $field = array("nip", "nama", "unit", "eselon", "alamat", "telepon"); break;
			
			case "kawasan"			: $field = array("kode", "nama"); break;
			case "xconfig"			: $field = array("name", "content"); break;
			case "xhead"			: $field = array("id", "type", "src"); break;
			case "xlevel"			: $field = array("kode", "name", "ordering"); break;
			case "xlog"				: $field = array("id", "date", "description", "type", "modifiedby", "ipaddress", "success"); break;
			case "xmenu"			: $field = array("id", "name", "title", "parent", "published", "src", "ordering"); break;
			case "xmenulevel"		: $field = array("id", "menu", "level"); break;
			case "xmenutype"		: $field = array("id", "menu", "type"); break;
			case "xposition"		: $field = array("kode", "name", "published"); break;
			case "xuser"			: $field = array("username", "unit", "password", "email", "lastlogin", "aktif", "reset", "kunci"); break;
			case "xuserlevel"		: $field = array("id", "username", "level"); break;
			case "xuser_pegawai"	: $field = array("username", "nama", "level", "unit", "password", "email", "lastlogin", "aktif", "reset", "kunci"); 
									  break;
		}
		
		return $field;
	}
		
	function get_value($table, $field, $id) 
	{
		$sql = sql_select($table, $field, $id);
		$query = mysql_query($sql) or die(mysql_error());
		$rs = mysql_fetch_array($query);
		
		foreach ($field as $k=>$val) 
		{
			$value[$k] = $rs[$val];
		}
		
		return $value;
	}
		
	function get_values($table, $field, $id) 
	{
		$sql = sql_select($table, $field, $id);
		$query = mysql_query($sql) or die(mysql_error());
		$value = mysql_fetch_array($query);
		
		return $value;
	}
	
	#-=-=-=-=-=-=-=-=-=-=- Table kawasan -=-=-=-=-=-=-=-=-=-=-#
	
	function kawasan($field = "*", $where_clause = "", $sort_by = "") 
	{
		$sql = sql_select("kawasan", $field, $where_clause, $sort_by);
		$query = mysql_query($sql) or die(mysql_error());
	
		return $query;
	}
	
	#-=-=-=-=-=-=-=-=-=-=- Table unit -=-=-=-=-=-=-=-=-=-=-#
	
	function unit($field = "*", $where_clause = "", $sort_by = "") 
	{
		$sql = sql_select("unit", $field, $where_clause, $sort_by);
		$query = mysql_query($sql) or die(mysql_error());
	
		return $query;
	}
	
	#-=-=-=-=-=-=-=-=-=-=- Table xconfig -=-=-=-=-=-=-=-=-=-=-#
	
	function xconfig($field = "*", $where_clause = "", $sort_by = "") 
	{
		$sql = sql_select("xconfig", $field, $where_clause, $sort_by);
		$query = mysql_query($sql) or die(mysql_error());
	
		return $query;
	}
	
	function get_title() 
	{
		$rs = xconfig("content", "name = 'title'");
		$xconfig = mysql_fetch_array($rs);
		
		return $xconfig['content'];
	}
	
	function get_version() 
	{
		$rs = xconfig("content", "name = 'version'");
		$xconfig = mysql_fetch_array($rs);
		
		return $xconfig['content'];
	}
	
	function get_copyright() 
	{
		$rs = xconfig("content", "name = 'copyright'");
		$xconfig = mysql_fetch_array($rs);
		
		return $xconfig['content'];
	}
	
	#-=-=-=-=-=-=-=-=-=-=- Table xhead -=-=-=-=-=-=-=-=-=-=-#
	
	function xhead($field = "*", $where_clause = "", $sort_by = "") 
	{
		$sql = sql_select("xhead", $field, $where_clause, $sort_by);
		$query = mysql_query($sql) or die(mysql_error());
		
		return $query;
	}
	
	#-=-=-=-=-=-=-=-=-=-=- Table xlevel -=-=-=-=-=-=-=-=-=-=-#
	
	function xlevel($field = "*", $where_clause = "", $sort_by = "") 
	{
		$sql = sql_select("xlevel", $field, $where_clause, $sort_by);
		$query = mysql_query($sql) or die(mysql_error());
	
		return $query;
	}
	
	#-=-=-=-=-=-=-=-=-=-=- Table xlog -=-=-=-=-=-=-=-=-=-=-#
	
	function xlog($field = "*", $where_clause = "", $sort_by = "") 
	{
		$sql = sql_select("xlog", $field, $where_clause, $sort_by);
		$query = mysql_query($sql) or die(mysql_error());
	
		return $query;
	}
	
	function update_log($description, $type, $modifiedby, $is_success)
	{
		$sql = str_replace("'", "\'", $description);
		$table = "xlog";
		$field = get_field($table);
		$value = array('', now(), $sql, $type, $modifiedby, $_SERVER['REMOTE_ADDR'], $is_success);
		$log = sql_insert($table, $field, $value);
		$query = mysql_query($log) or die (mysql_error());
		
		return $query;
	}
	
	#-=-=-=-=-=-=-=-=-=-=- Table xmenu -=-=-=-=-=-=-=-=-=-=-#
	
	function xmenu($field = "*", $where_clause = "", $sort_by = "") 
	{
		$sql = sql_select("xmenu", $field, $where_clause, $sort_by);
		$query = mysql_query($sql) or die(mysql_error());
	
		return $query;
	}
	
	function menu($type, $parent = "") 
	{
		@session_start();
		$session_name = "Kh41r4";
		
		if ($parent == "") $parent = "m.parent IS NULL";
		else $parent = "m.parent = '".$parent."'";
		
		$sql = sql_select("xmenu m LEFT JOIN xmenutype mt ON m.id = mt.menu LEFT JOIN xmenulevel ml ON m.id = ml.menu", "m.id, m.name, m.parent", 
		"mt.type = '".$type."' AND ml.level = '".$_SESSION['xlevel_'.$session_name]."' AND m.published = '1' AND ".$parent, "ordering");
		
		$query = mysql_query($sql) or die(mysql_error());
		
		return $query;
	}
	
	function select_parent($type, $parent = "") 
	{
		if ($parent == "") $parent = "m.parent IS NULL";
		else $parent = "m.parent = '".$parent."'";
		
		$sql = sql_select("xmenu m LEFT JOIN xmenutype mt ON m.id = mt.menu", "m.id, m.name", "mt.type ".$type." AND ".$parent, "ordering");
		$query = mysql_query($sql) or die(mysql_error());
		
		return $query;
	}
	
	#-=-=-=-=-=-=-=-=-=-=- Table xmenulevel -=-=-=-=-=-=-=-=-=-=-#
	
	function xmenulevel($field = "*", $where_clause = "", $sort_by = "") 
	{
		$sql = sql_select("xmenulevel", $field, $where_clause, $sort_by);
		$query = mysql_query($sql) or die(mysql_error());
	
		return $query;
	}
	
	#-=-=-=-=-=-=-=-=-=-=- Table xmenutype -=-=-=-=-=-=-=-=-=-=-#
	
	function xmenutype($field = "*", $where_clause = "", $sort_by = "") 
	{
		$sql = sql_select("xmenutype", $field, $where_clause, $sort_by);
		$query = mysql_query($sql) or die(mysql_error());
	
		return $query;
	}
	
	#-=-=-=-=-=-=-=-=-=-=- Table xposition -=-=-=-=-=-=-=-=-=-=-#
	
	function xposition($field = "*", $where_clause = "", $sort_by = "") 
	{
		$sql = sql_select("xposition", $field, $where_clause, $sort_by);
		$query = mysql_query($sql) or die(mysql_error());
	
		return $query;
	}
	
	function is_published($kode) 
	{
		$oposition = xposition("published", "kode = '".$kode."'");
		$nposition = mysql_num_rows($oposition);
		
		if ($nposition > 0)
		{
			$position = mysql_fetch_array($oposition);
			$published = $position['published'];
			
			if ($published == "1") $is_published = true;
			else $is_published = false;
		}
		else $is_published = false;
	
		return $is_published;
	}
	
	#-=-=-=-=-=-=-=-=-=-=- Table xuser -=-=-=-=-=-=-=-=-=-=-#
	
	function xuser($field = "*", $where_clause = "", $sort_by = "") 
	{
		$sql = sql_select("xuser", $field, $where_clause, $sort_by);
		$query = mysql_query($sql) or die(mysql_error());
		
		return $query;
	}
	
	function last_login($username) 
	{
		$field = array("username", "lastlogin", "kunci");
		
		$lastlogin = now();
		$keys = base64_encode($lastlogin);
		
		$value = array($username, now(), $keys);
		$sql = sql_update("xuser_pegawai", $field, $value);
		$query = mysql_query($sql) or die(mysql_error());
		
		return $query;
	}
	#-=-=-=-=-=-=-=-=-=-=- Table xuserlevel -=-=-=-=-=-=-=-=-=-=-#
	
	function xuserlevel($field = "*", $where_clause = "", $sort_by = "") 
	{
		$sql = sql_select("xuserlevel", $field, $where_clause, $sort_by);
		$query = mysql_query($sql) or die(mysql_error());
		
		return $query;
	}
?>