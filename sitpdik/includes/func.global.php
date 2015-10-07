<?php
/************************************************************************************
File Name : func.global.php
Created by : Mohammad Syafiuddin - udhien (dev@dnet.net.id - http://www.udhien.net)
Date Modified : May 10, 2004
*************************************************************************************/

/*---------------------------------------------------------
function to convert month name into indonesian language

examples :
Month_Indo(date("d"), "longname"); -> output : Desember
Month_Indo(date("d"), "shortname"); -> output : Des
---------------------------------------------------------*/

function Month_Indo($month_int, $month_style) {
	if ($month_style == "shortname") {
		switch ($month_int) {
			case 1:
				$Bulan	= "Jan";
				break;
			case 2:
				$Bulan	= "Feb";
				break;
			case 3:
				$Bulan	= "Mar";
				break;
			case 4:
				$Bulan	= "Apr";
				break;
			case 5:
				$Bulan	= "Mei";
				break;
			case 6:
				$Bulan	= "Jun";
				break;
			case 7:
				$Bulan	= "Jul";
				break;
			case 8:
				$Bulan	= "Agu";
				break;
			case 9:
				$Bulan	= "Sep";
				break;
			case 10:
				$Bulan	= "Okt";
				break;
			case 11:
				$Bulan	= "Nov";
				break;
			case 12:
				$Bulan	= "Des";
				break;
		}
		
		return $Bulan;
	} elseif ($month_style == "longname") {
		switch ($month_int) {
			case 1:
				$Bulan	= "Januari";
				break;
			case 2:
				$Bulan	= "Februari";
				break;
			case 3:
				$Bulan	= "Maret";
				break;
			case 4:
				$Bulan	= "April";
				break;
			case 5:
				$Bulan	= "Mei";
				break;
			case 6:
				$Bulan	= "Juni";
				break;
			case 7:
				$Bulan	= "Juli";
				break;
			case 8:
				$Bulan	= "Agustus";
				break;
			case 9:
				$Bulan	= "September";
				break;
			case 10:
				$Bulan	= "Oktober";
				break;
			case 11:
				$Bulan	= "November";
				break;
			case 12:
				$Bulan	= "Desember";
				break;
		}
		
		return $Bulan;
	}
}


/*------------------------------------------------------------------------------
Create Date Drop Down List

format :
	Draw_Date_DropDownList ($variable, $value, $stylesheet);

example :
	Draw_Date_DropDownList("DateOfBirth", $DateOfBirth, "selectstyle");
-------------------------------------------------------------------------------*/

function Draw_Date_DropDownList ($datename, $datevalue = 0, $formstyle = "") {
	($datevalue == 0) ? $datevalue = intval(date("d")) : $datevalue = $datevalue;
	
	$date_dropdown	 = "<select name=\"".$datename."\" size=\"1\" class=\"".$formstyle."\">";
	//$date_dropdown	.= "<option value=\"\">DD</option>";

	for ($d = 1; $d <=31; $d++) {
		($datevalue == $d) ? $selected = "selected" : $selected = "";
		$date_dropdown	.= "<option value=\"".$d."\" ".$selected.">".$d."</option>\n";
	}

	$date_dropdown	.= "</select>";

	return $date_dropdown;
}

/*-------------------------------------------------------------------------------
Create Month Drop Down List

Depend :
	function Month_Indo()

format :
	Draw_Month_DropDownList ($variable, $value, $stylesheet);

example :
	Draw_Month_DropDownList("MonthOfBirth", $MonthOfBirth, "selectstyle");
--------------------------------------------------------------------------------*/

function Draw_Month_DropDownList($monthname, $monthvalue = 0, $formstyle = "") {
	($monthvalue == 0) ? $monthvalue = intval(date("m")) : $monthvalue = $monthvalue;

	$month_dropdown		 = "<select name=\"".$monthname."\" size=\"1\" class=\"".$formstyle."\">";
	//$month_dropdown		.= "<option value=\"\">MM</option>";

	for ($m = 1; $m <= 12; $m++) {
		($monthvalue == $m) ? $selected = "selected" : $selected = "";
		$month_dropdown		.= "<option value=\"".$m."\" ".$selected.">".Month_Indo($m, "longname")."</option>\n";
	}

	$month_dropdown	.= "</select>";

	return $month_dropdown;
}

/*-------------------------------------------------------------------------------------
Create Year Drop Down List

format :
	Draw_Year_DropDownList($variable, $value, $stylesheet, $startyearvalue);

example :
	Draw_Year_DropDownList("YearOfBirth", $YearOfBirth, "selectstyle", 1990);
-------------------------------------------------------------------------------------*/

function Draw_Year_DropDownList($yearname, $yearvalue = 0, $formstyle = "", $startyear = 1900) {
	$currentyear	= intval(date("Y"));

	($yearvalue == 0) ? $yearvalue = $currentyear : $yearvalue = $yearvalue;

	$year_dropdown		 = "<select name=\"".$yearname."\" size=\"1\" class=\"".$formstyle."\">";
	//$year_dropdown		.= "<option value=\"\">YY</option>";

	for ($y = $startyear; $y <= ($currentyear + 1); $y++) {
		($yearvalue == $y) ? $selected = "selected" : $selected = "";
		$year_dropdown		.= "<option value=\"".$y."\" ".$selected.">".$y."</option>\n";
	}

	$year_dropdown	.= "</select>";

	return $year_dropdown;
}

/*-----------------------------------------------------------------------------------
Create Hour Drop Down List

format :
	Draw_Hour_DropDownList($variable, $value, $stylesheet);

example :
	Draw_Hour_DropDownList("HourOfBirth", $HourOfBirth, "selectsytle");
-----------------------------------------------------------------------------------*/

function Draw_Hour_DropDownList($hourname, $hourvalue = "", $formstyle = "") {
	($hourvalue == "") ? $hourvalue = intval(date("H")) : $hourvalue = $hourvalue;

	$hour_dropdown		 = "<select name=\"".$hourname."\" size=\"1\" class=\"".$formstyle."\">";
	//$hour_dropdown		.= "<option value=\"\">HH</option>";

	for ($h = 0; $h <= 23; $h++) {
		($hourvalue == $h) ? $selected = "selected" : $selected = "";
		$hour_dropdown	 .= "<option value=\"".Pad_Digit($h)."\" ".$selected.">".Pad_Digit($h)."</option>\n";
	}

	$hour_dropdown	.= "</select>";

	return $hour_dropdown;
}

/*-----------------------------------------------------------------------------------
Create Minute Drop Down List

format :
	Draw_Minute_DropDownList($variable, $value, $stylesheet);

example :
	Draw_Minute_DropDownList("MinuteOfBirth", $MinuteOfBirth, "selectsytle");
-----------------------------------------------------------------------------------*/

function Draw_Minute_DropDownList($minutename, $minutevalue = "", $formstyle = "") {
	($minutevalue == "") ? $minutevalue = intval(date("i")) : $minutevalue = $minutevalue;

	$minute_dropdown		 = "<select name=\"".$minutename."\" size=\"1\" class=\"".$formstyle."\">";
	//$minute_dropdown		.= "<option value=\"\">MM</option>";

	for ($m = 0; $m <= 59; $m++) {
		($minutevalue == $m) ? $selected = "selected" : $selected = "";
		$minute_dropdown	 .= "<option value=\"".Pad_Digit($m)."\" ".$selected.">".Pad_Digit($m)."</option>\n";
	}

	$minute_dropdown	.= "</select>";

	return $minute_dropdown;
}

/*-----------------------------------------------------------------------------------
Create Second Drop Down List

format :
	Draw_Second_DropDownList($variable, $value, $stylesheet);

example :
	Draw_Second_DropDownList("SecondOfBirth", $SecondOfBirth, "selectsytle");
-----------------------------------------------------------------------------------*/

function Draw_Second_DropDownList($secondname, $secondvalue = "", $formstyle = "") {
	($secondvalue == "") ? $secondvalue = intval(date("s")) : $secondvalue = $secondvalue;

	$second_dropdown		 = "<select name=\"".$secondname."\" size=\"1\" class=\"".$formstyle."\">";
	//$second_dropdown		.= "<option value=\"\">SS</option>";

	for ($s = 0; $s <= 59; $s++) {
		($secondvalue == $s) ? $selected = "selected" : $selected = "";
		$second_dropdown	 .= "<option value=\"".Pad_Digit($s)."\" ".$selected.">".Pad_Digit($s)."</option>\n";
	}

	$second_dropdown	.= "</select>";

	return $second_dropdown;
}

function GetAdministratorName($iOperatorID) {
	global $Tb_Administrator;

	$SQLQuery	= mysql_query("SELECT FullName FROM $Tb_Administrator WHERE AdminID = '".$iOperatorID."'") or die(mysql_errno()." : ".mysql_error());

	if ($Query	= mysql_fetch_object($SQLQuery)) {
		$sOutput	= "<em>By : </em>".$Query->FullName;
	} else {
		$sOutput	= "";
	}

	return $sOutput;
}
function DrawCategory($FormName, $FormValue = "", $FormStyle) {
	global $Tb_Kategori;

	$DropDown	 = "<select name=\"".$FormName."\" id=\"".$FormName."\" size=\"1\" class=\"".$FormStyle."\">\r\n";

	$SQL	= mysql_query("SELECT IdKat, NmKategori FROM $Tb_Kategori ORDER BY IdKat ASC") or die(mysql_errno()." : ".mysql_error());

	while ($Query = mysql_fetch_object($SQL)) {
		($FormValue == $Query->CID) ? $Selected = "selected" : $Selected = "";
		$DropDown	.= "<option value=\"".$Query->IdKat."\" ".$Selected.">".$Query->NmKategori."</option>\n";
	}

	$DropDown	.= "</select>";

	unset($SQL);

	return $DropDown;
}

function GetUserName($IdUser) {

	$SQL	= mysql_query("SELECT nama FROM xuser_pegawai WHERE username = '".$IdUser."'") or die(mysql_errno()." : ".mysql_error());

	$List	= mysql_fetch_object($SQL);

	return $List->nama;

	unset($SQL);
}

function GetRole($IdUser) {

	$SQL	= mysql_query("SELECT Role FROM User WHERE IdUser = '".$IdUser."'") or die(mysql_errno()." : ".mysql_error());

	$List	= mysql_fetch_object($SQL);

	return $List->Role;

	unset($SQL);
}

function GetNama($IdUser) {

	$SQL	= mysql_query("SELECT Nama FROM xuser_pegawai WHERE username = '".$IdUser."'") or die(mysql_errno()." : ".mysql_error());

	$List	= mysql_fetch_object($SQL);

	return $List->Nama;

	unset($SQL);
}

function GetEmail($IdUser) {

	$SQL	= mysql_query("SELECT Email FROM User WHERE IdUser = '".$IdUser."'") or die(mysql_errno()." : ".mysql_error());

	$List	= mysql_fetch_object($SQL);

	return $List->Email;

	unset($SQL);
}

function GetSifatSurat($IdSifat) {
	global $Tb_Sifat_Surat;

	$SQL	= mysql_query("SELECT * FROM sifatsurat WHERE IdSifat = '".$IdSifat."'") or die(mysql_errno()." : ".mysql_error());

	$List	= mysql_fetch_object($SQL);

	return $List->NmSifat;

	unset($SQL);
}

function GetKategoriSurat($IdKategori) {

	global $Tb_Kategori_Surat;
	$SQL	= mysql_query("SELECT NmKategori FROM kategorisurat WHERE IdKategori = '".$IdKategori."'") or die(mysql_errno()." : ".mysql_error());

	$List	= mysql_fetch_object($SQL);

	return $List->NmKategori;

	unset($SQL);
}

function GetKlasifikasiSurat($IdKlasifikasi) {

	global $Tb_Klasifikasi_Surat;
	$SQL	= mysql_query("SELECT NmKlasifikasi FROM klasifikasisurat WHERE IdKlasifikasi = '".$IdKlasifikasi."'") or die(mysql_errno()." : ".mysql_error());

	$List	= mysql_fetch_object($SQL);

	return $List->NmKlasifikasi;

	unset($SQL);
}

function GetNmSatker($KdUnitKerja) {

	global $Tb_Klasifikasi_Surat;
	$SQL	= mysql_query("SELECT NmSatker FROM satker WHERE KdUnitKerja = '".$KdUnitKerja."'") or die(mysql_errno()." : ".mysql_error());

	$List	= mysql_fetch_object($SQL);

	return $List->NmSatker;

	unset($SQL);
}

function GetNmUnit($KdUnit) {

	global $Tb_Klasifikasi_Surat;
	$SQL	= mysql_query("SELECT NmUnit FROM kdunit WHERE KdUnit = '".$KdUnit."'") or die(mysql_errno()." : ".mysql_error());

	$List	= mysql_fetch_object($SQL);

	return $List->NmUnit;

	unset($SQL);
}

function GetNmSifatSurat($IdSifat) {

	global $Tb_Klasifikasi_Surat;
	$SQL	= mysql_query("SELECT NmSifat FROM sifatsurat WHERE IdSifat = '".$IdSifat."'") or die(mysql_errno()." : ".mysql_error());

	$List	= mysql_fetch_object($SQL);

	return $List->NmSifat;

	unset($SQL);
}
?>