<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<title>Tabs dengan Ajax</title>
<script type="text/javascript" 
        src="js/jquery-1.4.4.min.js"></script>
<script type="text/javascript" 
        src="js/jquery-ui-1.8.10.custom.min.js"></script>        
<link rel="stylesheet" type="text/css" 
        href="css/jquery-ui-1.8.10.custom.css" />                                
<script type="text/javascript">
   $(document).ready(function() {
      $("#star").tabs();
   });
</script>
<style type="text/css">
<!--
.style8 {
	color: #FF6600;
	font-weight: bold;
}
.style9 {color: #FF3300}
.style10 {
	color: #660000;
	font-weight: bold;
}
.style11 {color: #660000}

#simpan {
	padding: 3px;
	margin-bottom:3px;
	margin-top:3px;
	background: #339933 url(images/img_header_2.gif) repeat-x left bottom;
	border: none;
	font-size: 11px;
	color: #ffffff;
}

#simpan_1 {
	padding: 3px;
	margin-bottom:3px;
	margin-top:3px;
	background: #339933 url(images/img_header_2.gif) repeat-x left bottom;
	border: none;
	font-size: 11px;
	color: #ffffff;
}

#simpan_2 {
	padding: 3px;
	margin-bottom:3px;
	margin-top:3px;
	background: #339933 url(images/img_header_2.gif) repeat-x left bottom;
	border: none;
	font-size: 11px;
	color: #ffffff;
}
#simpan_3 {
	padding: 3px;
	margin-bottom:3px;
	margin-top:3px;
	background: #339933 url(images/img_header_2.gif) repeat-x left bottom;
	border: none;
	font-size: 11px;
	color: #ffffff;
}
#simpan_4 {
	padding: 3px;
	margin-bottom:3px;
	margin-top:3px;
	background: #339933 url(images/img_header_2.gif) repeat-x left bottom;
	border: none;
	font-size: 11px;
	color: #ffffff;
}
#simpan_5 {
	padding: 3px;
	margin-bottom:3px;
	margin-top:3px;
	background: #339933 url(images/img_header_2.gif) repeat-x left bottom;
	border: none;
	font-size: 11px;
	color: #ffffff;
}
#simpan_6 {
	padding: 3px;
	margin-bottom:3px;
	margin-top:3px;
	background: #339933 url(images/img_header_2.gif) repeat-x left bottom;
	border: none;
	font-size: 11px;
	color: #ffffff;
}
#simpan_7 {
	padding: 3px;
	margin-bottom:3px;
	margin-top:3px;
	background: #339933 url(images/img_header_2.gif) repeat-x left bottom;
	border: none;
	font-size: 11px;
	color: #ffffff;
}
#simpan_8 {
	padding: 3px;
	margin-bottom:3px;
	margin-top:3px;
	background: #339933 url(images/img_header_2.gif) repeat-x left bottom;
	border: none;
	font-size: 11px;
	color: #ffffff;
}
</style>
</head>
<body>
<div id="star">
   <ul>
 	  <li><a href="#Umum">Data Umum</a></li>
	  <li><a href="#Pangkat">Kepangkatan</a></li>
	  <li><a href="#JabStruktural">Unit & Jab.Struktural</a></li>
	  <li><a href="#JabFung">Jab. Fungsional</a></li>
	  <li><a href="#Pendidikan">Pendidikan</a></li>
	  <li><a href="#KGB">KGB</a></li>
	  <li><a href="#TBN">TBN</a></li>
	  <li><a href="#Keluarga">Keluarga</a></li>
   </ul>
  
<div id="forminduk">
  <table width="796">
  <?php 
  $foto = "foto/".$id.".jpg";
  ?>
  <tr>
    <td width="140" rowspan="6"><img src="<?php echo $foto ?>" alt="" width="105" height="116" class="left" /></td>
    <td width="119" height="25">&nbsp;</td>
    <td width="521">&nbsp;</td>
  </tr>
  
  <tr>
    <td height="20"><div align="left" class="style10">NIB</div></td>
    <td height="20"><div align="left" class="style10"><?php echo $id ?></div></td>
  </tr>
  <tr>
    <td height="20"><div align="left" class="style10">Nama</div></td>
    <td height="20"><div align="left" class="style10"><?php echo nama_peg($id) ?></div></td>
  </tr>
  <tr>
    <td height="20"><div align="left" class="style10">NIP</div></td>
    <td height="20"><div align="left" class="style10"><?php echo nip_peg($id) ?></div></td>
  </tr>
  <tr>
    <td height="20"><div align="left" class="style10">Golongan</div></td>
    <td height="20"><div align="left" class="style10"><?php echo nmgol(kdgol_peg($id)) ?></div></td>
  </tr>
  <tr>
    <td height="20"><div align="left" class="style10">Unit Kerja </div></td>
    <td height="20"><div align="left" class="style10"><?php echo nmunit_peg($id) ?></div></td>
  </tr>
</table>
</div>
   
   <div id="Umum">   
 <script language="JavaScript">
  function removeAlignment_Umum(){
	if(document.umum.umum_ed.value =="Ubah")
	{
		var read=document.getElementById("NamaLengkap").removeAttribute("disabled",0);
		var read=document.getElementById("Nip").removeAttribute("disabled",0);
		var read=document.getElementById("SexP").removeAttribute("disabled",0);
		var read=document.getElementById("SexL").removeAttribute("disabled",0);
		var read=document.getElementById("KdAgama").removeAttribute("disabled",0);
		var read=document.getElementById("KdStatusNikah").removeAttribute("disabled",0);
		var read=document.getElementById("TempatLahir").removeAttribute("disabled",0);
		var read=document.getElementById("TglLahir").removeAttribute("disabled",0);
		var read=document.getElementById("Alamat").removeAttribute("disabled",0);
		var read=document.getElementById("simpan").removeAttribute("disabled",0);
		var read=document.getElementById("nama_file").removeAttribute("disabled",0);
		var read=document.umum.TglLahirIMG.src="css/images/calbtn.gif";
	}
	else
	{
		document.getElementById("NamaLengkap").disabled = true;
		document.getElementById("Nip").disabled = true;
		document.getElementById("SexP").disabled = true;
		document.getElementById("SexL").disabled = true;
		document.getElementById("KdAgama").disabled = true;
		document.getElementById("KdStatusNikah").disabled = true;
		document.getElementById("TempatLahir").disabled = true;
		document.getElementById("TglLahir").disabled = true;
		document.getElementById("Alamat").disabled = true;
		document.getElementById("simpan").disabled = true;
		document.getElementById("nama_file").disabled = true;
	}
  }
</script> 
<?php	
	$title = "Umum";
	$table = "m_idpegawai";
	$pkey = "Nib";
	$field = array("Nip", "NamaLengkap", "TempatLahir", "TglLahir", "KdAgama", "KdStatusNikah", "Sex", "Alamat");
	
	$bError	= false;
	
	if (!isset($id)) {
		$pagetitle = "Tambah ".$title;
	}
	else {
		$pagetitle = "Ubah ".$title;
	}
	
	if (isset($_POST["umum_edit"])) {	
		if ($bError != true) {
			if (!isset($_GET["id"])) {
				//ADD NEW
				$sql = "insert into ".$table." (";
				
				$i = 1;
				foreach ($field as $val) {
					$sql .= $val;
					if ($i < count($field)) $sql .= ", ";
					$i++;
				}
				
				$sql .= ") values (";
				
				$i = 1;
				foreach ($field as $val) {
					$sql .= "'".$$val."'";
					if ($i < count($field)) $sql .= ", ";
					$i++;
				}
				
				$sql .= ")";
				
				mysql_query($sql) or die(mysql_error());
			
				$_SESSION['errmsg'] = "Update data ".$title." berhasil!";
				echo "<meta http-equiv=\"refresh\" content=\"0;URL=index.php?p=dtinduk_ed&id=$id&sw=$sw\">";
				exit();
			} 
			else {
				// UPDATE		
				//------ upload foto pegawai
					$file_name=$_FILES['nama_file']['name'];
					echo 'file foto '.$file_name;
					if($file_name<>''){
						$source=$_FILES['nama_file']['tmp_name'];
						$target = "foto/" . $file_name;
						move_uploaded_file($source, $target);
					}
				$sql = "update ".$table." set ";
				
				$i = 1;
				foreach ($field as $val) {
					$sql .= $val." = '".$$val."'";
					if ($i < count($field)) $sql .= ", ";
					$i++;
				}
				
				$sql .= " where ".$pkey." = '".$id."'";
				mysql_query($sql) or die(mysql_error());
				$_SESSION['errmsg'] = "Update data ".$title." berhasil!";
				echo "<meta http-equiv=\"refresh\" content=\"0;URL=index.php?p=dtinduk_ed&id=$id&sw=$sw\">";
				exit();
			}
		}
	} 
	else if (isset($_GET["id"])) {
		$oEdit = mysql_query("SELECT * FROM ".$table." WHERE ".$pkey." = '".$_GET["id"]."'") or die(mysql_error());
	
		if (mysql_num_rows($oEdit) == 0) {
			$bError		= true;
			$_SESSION['errmsg'] = "Invalid Request...!!";
		} 
		else {
			$Edit	= mysql_fetch_object($oEdit);
			
			foreach ($field as $val) {
				$$val = $Edit->$val;
			}
		}
	}
?>
<div id="forminduk">
	<form method="post" action="" name="umum" enctype="multipart/form-data">
		<table width="1088">
			    
			<tr>
			  <td width="216" height="20"><strong>Nama</strong></td>
		      <td colspan="3"><input name="NamaLengkap" type="text" id="NamaLengkap" value="<?php echo @$NamaLengkap ?>" size="60" disabled="true"/></td>
			</tr>
			<tr>
			  <td height="20"><strong>NIP</strong></td>
				<td colspan="3"><input name="Nip" type="text" id="Nip" value="<?php echo @$Nip ?>" size="30" disabled="true"></td>
			</tr>
			<tr>
			  <td>&nbsp;</td>
			  <td colspan="3">&nbsp;</td>
		  </tr>
			<tr>
			  <td>Jenis Kelamin </td>
			  <td colspan="3"><input name="Sex" type="radio"  id="SexL" value="L" <?php if(@$Sex=='L') { ?>checked <?php } ?> disabled="true"/>
        Laki-laki &nbsp;
		<input name="Sex" type="radio"  id="SexP" value="P" <?php if(@$Sex=='P') { ?>checked <?php }?> disabled="true"/>
        Perempuan</td>
		  </tr>
			<tr>
			  <td>Agama</td>
			  <td width="269" height="20"><select name="KdAgama" id="KdAgama" disabled="true">
			  			<?php if(@$KdAgama<>'') ?>
							  <option value="<?php echo @$KdAgama ?>"><?php echo nmagama(@$KdAgama) ?></option>	
					    <option value="">- Pilih Agama -</option><?php
							$query = mysql_query("select kd_agama, nm_agama from kd_agama order by kd_agama");
					
						while($row = mysql_fetch_array($query)) { ?>
						    <option value="<?php echo $row['kd_agama']; ?>"><?php echo $row['nm_agama']; ?></option><?php
						} ?>
			  </select></td>
		      <td width="87">Status</td>
		      <td width="496"><select name="KdStatusNikah" id="KdStatusNikah" disabled="true">
			  			<?php if(@$KdStatusNikah<>'') ?>
						<option value="<?php echo @$KdStatusNikah ?>"><?php echo nmstatusnikah(@$KdStatusNikah) ?></option>	
						<option value="">- Pilih Status -</option><?php
							$query = mysql_query("select kd_statusnikah, nm_statusnikah from kd_statusnikah ");
					
						while($row = mysql_fetch_array($query)) { ?>
							<option value="<?php echo $row['kd_statusnikah']; ?>"><?php echo $row['nm_statusnikah']; ?></option><?php
						} ?>
			  </select></td>
		  </tr>
			<tr>
			  <td>Lahir </td>
			  <td colspan="3" height="20"><input name="TempatLahir" type="text" id="TempatLahir" value="<?php echo @$TempatLahir ?>" size="20" disabled="true">&nbsp;/ &nbsp;<input name="TglLahir" type="text" class="form" id="TglLahir" size="10" value="<?php echo @$TglLahir ?>" disabled="true"/>
          &nbsp;<img src="" id="w_triggerIMG" hspace="5" title="Pilih Tanggal" name="TglLahirIMG"/>
          <script type="text/javascript">
				Calendar.setup({
					inputField		: "TglLahir",
					button			: "w_triggerIMG",
					align			: "BR",
					firstDay		: 1,
					weekNumbers		: false,
					singleClick		: true,
					showOthers		: true,
					ifFormat 		: "%Y-%m-%d"
				});
			</script></td>
		  </tr>
			<tr>
			  <td>Alamat</td>
			  <td colspan="3" height="20"><input name="Alamat" type="text" id="Alamat" value="<?php echo @$Alamat ?>" size="70" disabled="true"/></td>
		  </tr>
			<tr>
			  <td>Upload File Foto </td>
			  <td colspan="3" height="20"><input type="file" name="nama_file" size="60" value="" id="nama_file" disabled="disabled"></td>
		  </tr>
			<tr>
			  <td colspan="4"><input name="umum_ed" type="button" id="x" value="Ubah" onclick="removeAlignment_Umum()">
			  	  <input name="umum_edit" type="submit" id="simpan" value="Simpan" disabled="disabled">
   				  <input name="cancel" type="button" id="x" value="Keluar" onClick="Cancel('index.php?p=dtinduk_list&sw=<?php echo $sw ?>&cari=<?php echo $cari ?>')"></td>
		    </tr>
			<tr>
			  <td colspan="4">&nbsp;</td>
		  </tr>
	  </table>
	</form>
</div>
</div>

   <div id="Pangkat">
 <script language="JavaScript">
  function removeAlignment_Pangkat(){
	if(document.pangkat.pangkat_ed.value =="Ubah")
	{
		var read=document.getElementById("NoKarPeg").removeAttribute("disabled",0);
		var read=document.getElementById("KdStatusPeg").removeAttribute("disabled",0);
		var read=document.getElementById("KdKedudukan").removeAttribute("disabled",0);
		var read=document.getElementById("TMTCapeg").removeAttribute("disabled",0);
		var read=document.getElementById("TMTPNS").removeAttribute("disabled",0);
		var read=document.getElementById("TMTBatan").removeAttribute("disabled",0);
		var read=document.getElementById("KdGol").removeAttribute("disabled",0);
		var read=document.getElementById("TMTGol").removeAttribute("disabled",0);
		var read=document.getElementById("mkgth").removeAttribute("disabled",0);
		var read=document.getElementById("mkgbl").removeAttribute("disabled",0);
		var read=document.getElementById("NoSKKP").removeAttribute("disabled",0);
		var read=document.getElementById("TglSKKP").removeAttribute("disabled",0);
		var read=document.getElementById("GajiKP").removeAttribute("disabled",0);
		var read=document.getElementById("simpan_1").removeAttribute("disabled",0);
		var read=document.pangkat.TMTCapegIMG.src="css/images/calbtn.gif";
		var read=document.pangkat.TMTPNSIMG.src="css/images/calbtn.gif";
		var read=document.pangkat.TMTBatanIMG.src="css/images/calbtn.gif";
		var read=document.pangkat.TMTGolIMG.src="css/images/calbtn.gif";
		var read=document.pangkat.TglSKKPIMG.src="css/images/calbtn.gif";
	}
	else
	{
		document.getElementById("NoKarPeg").disabled = true;
		document.getElementById("KdStatusPeg").disabled = true;
		document.getElementById("KdKedudukan").disabled = true;
		document.getElementById("TMTCapeg").disabled = true;
		document.getElementById("TMTPNS").disabled = true;
		document.getElementById("TMTBatan").disabled = true;
		document.getElementById("KdGol").disabled = true;
		document.getElementById("TMTGol").disabled = true;
		document.getElementById("mkgth").disabled = true;
		document.getElementById("mkgbl").disabled = true;
		document.getElementById("NoSKKP").disabled = true;
		document.getElementById("TglSKKP").disabled = true;
		document.getElementById("GajiKP").disabled = true;
		document.getElementById("simpan_1").disabled = true;
	}
  }
</script> 
<?php	
	$title = "Kepangkatan";
	$table = "m_idpegawai";
	$pkey = "Nib";
	$field = array("NoKarPeg", "KdGol","TMTGol", "TMTCapeg", "TMTPNS", "TMTBatan", "KdStatusPeg", "KdKedudukan", "MKGKP", "NoSKKP", "TglSKKP", "GajiKP");
	
	$bError	= false;
	
	if (!isset($id)) {
		$pagetitle = "Tambah ".$title;
	}
	else {
		$pagetitle = "Ubah ".$title;
	}
	
	if (isset($_POST["pangkat_edit"])) {	
		@$MKGKP = $mkgth.$mkgbl ;
		if ($bError != true) {
			if (!isset($_GET["id"])) {
				//ADD NEW
				$sql = "insert into ".$table." (";
				
				$i = 1;
				foreach ($field as $val) {
					$sql .= $val;
					if ($i < count($field)) $sql .= ", ";
					$i++;
				}
				
				$sql .= ") values (";
				
				$i = 1;
				foreach ($field as $val) {
					$sql .= "'".$$val."'";
					if ($i < count($field)) $sql .= ", ";
					$i++;
				}
				
				$sql .= ")";
				
				mysql_query($sql) or die(mysql_error());
			
				$_SESSION['errmsg'] = "Update data ".$title." berhasil!";
				echo "<meta http-equiv=\"refresh\" content=\"0;URL=index.php?p=dtinduk_ed&id=$id&sw=$sw\">";
				exit();
			} 
			else {
				// UPDATE				
				$sql = "update ".$table." set ";
				
				$i = 1;
				foreach ($field as $val) {
					$sql .= $val." = '".$$val."'";
					if ($i < count($field)) $sql .= ", ";
					$i++;
				}
				
				$sql .= " where ".$pkey." = '".$id."'";
				
				mysql_query($sql) or die(mysql_error());
//----- update riwayat
	$kdgol = @$KdGol;
	$tmtgol  = @$TMTGol ;
	$mkgkp	 = @$MKGKP ;
	$noskkp  = @$NoSKKP ;
	$tglskkp = @$TglSKKP ;
	$gajikp  = @$GajiKP ;
	$oEdit_riw = mysql_query("SELECT * FROM m_riwkp WHERE NIB='$id' and KdGol='$kdgol'") or die(mysql_error());
	$vEdit_riw = mysql_fetch_array($oEdit_riw);
	if(!empty($vEdit_riw)){
		mysql_query("UPDATE m_riwkp SET TMTGol='$tmtgol', NoSKKP='$noskkp', MKGKP='$mkgkp', TglSKKP='$tglskkp',GaPok='$gajikp' WHERE NIB='$id' and KdGol='$kdgol'");
	}else{
		mysql_query("INSERT INTO m_riwkp(NIB, KdGol,TMTGol, NoSKKP, MKGKP, TglSKKP, GaPok) VALUES('$id','$kdgol','$tmtkp','$noskkp', '$mkgkp', '$tglskkp', '$gajikp')");
	}
//--------------------------------				
				$_SESSION['errmsg'] = "Update data ".$title." berhasil!";
				echo "<meta http-equiv=\"refresh\" content=\"0;URL=index.php?p=dtinduk_ed&id=$id&sw=$sw\">";
				exit();
			}
		}
	} 
	else if (isset($_GET["id"])) {
		$oEdit = mysql_query("SELECT * FROM ".$table." WHERE ".$pkey." = '".$_GET["id"]."'") or die(mysql_error());
	
		if (mysql_num_rows($oEdit) == 0) {
			$bError		= true;
			$_SESSION['errmsg'] = "Invalid Request...!!";
		} 
		else {
			$Edit	= mysql_fetch_object($oEdit);
			foreach ($field as $val) {
				$$val = $Edit->$val;
			}
		}
	}
	$mkgth = substr(@$MKGKP,0,2);
	$mkgbl = substr(@$MKGKP,2,2);
?>

<div id="forminduk">
	<form method="post" action="" name="pangkat">
		<table width="1013">
			    
			<tr>
			  <td width="155" height="20">No. Karpeg </td>
			  <td width="846" height="20"><input name="NoKarPeg" type="text" id="NoKarPeg" value="<?php echo @$NoKarPeg ?>" size="20" disabled="true"></td>
		  </tr>
			
			<tr>
			  <td height="20">Status Pegawai </td>
			  <td height="20"><select name="KdStatusPeg" id="KdStatusPeg" disabled="true">
                <?php if(@$KdStatusPeg<>'') ?>
                <option value="<?php echo @$KdStatusPeg ?>"><?php echo nmstatuspeg(@$KdStatusPeg) ?></option>
                <option value="">- Pilih Status -</option>
			    <?php
							$query = mysql_query("select kd_statuspeg, nm_statuspeg from kd_stkepeg GROUP BY kd_statuspeg");
					
						while($row = mysql_fetch_array($query)) { ?>
                <option value="<?php echo $row['kd_statuspeg']; ?>"><?php echo $row['nm_statuspeg']; ?></option>
			    <?php
						} ?>
              </select>&nbsp;&nbsp;Kedudukan&nbsp;&nbsp;<select name="KdKedudukan" id="KdKedudukan" disabled="true">
                <?php if(@$KdKedudukan<>'') ?>
                <option value="<?php echo @$KdKedudukan ?>"><?php echo nmdudukpeg(@$KdKedudukan) ?></option>
                <option value="">- Pilih Kedudukan -</option>
			    <?php
							$query = mysql_query("select kduduk, ketduduk from kd_kedudukan GROUP BY kduduk");
					
						while($row = mysql_fetch_array($query)) { ?>
                <option value="<?php echo $row['kduduk']; ?>"><?php echo $row['ketduduk']; ?></option>
			    <?php
						} ?>
              </select></td></tr>
			
			<tr>
			  <td height="20">Tmt CPNS </td>
			  <td height="20"><input name="TMTCapeg" type="text" class="form" id="TMTCapeg" size="10" value="<?php echo @$TMTCapeg ?>" disabled="true"/>
          &nbsp;<img src="" id="b_triggerIMG" hspace="5" title="Pilih Tanggal" name="TMTCapegIMG"/>
          <script type="text/javascript">
				Calendar.setup({
					inputField		: "TMTCapeg",
					button			: "b_triggerIMG",
					align			: "BR",
					firstDay		: 1,
					weekNumbers		: false,
					singleClick		: true,
					showOthers		: true,
					ifFormat 		: "%Y-%m-%d"
				});
			</script>&nbsp;Tmt PNS&nbsp;<input name="TMTPNS" type="text" class="form" id="TMTPNS" size="10" value="<?php echo @$TMTPNS ?>" disabled="true"/>
          &nbsp;<img src="" id="c_triggerIMG" hspace="5" title="Pilih Tanggal" name="TMTPNSIMG"/>
          <script type="text/javascript">
				Calendar.setup({
					inputField		: "TMTPNS",
					button			: "c_triggerIMG",
					align			: "BR",
					firstDay		: 1,
					weekNumbers		: false,
					singleClick		: true,
					showOthers		: true,
					ifFormat 		: "%Y-%m-%d"
				});
			</script>&nbsp;Tmt Batan&nbsp;<input name="TMTBatan" type="text" class="form" id="TMTBatan" size="10" value="<?php echo @$TMTBatan ?>" disabled="true"/>
          &nbsp;<img src="" id="d_triggerIMG" hspace="5" title="Pilih Tanggal" name="TMTBatanIMG"/>
          <script type="text/javascript">
				Calendar.setup({
					inputField		: "TMTBatan",
					button			: "d_triggerIMG",
					align			: "BR",
					firstDay		: 1,
					weekNumbers		: false,
					singleClick		: true,
					showOthers		: true,
					ifFormat 		: "%Y-%m-%d"
				});
			</script></td>
		  </tr>
			<tr>
			  <td height="20" colspan="2" class="style8">Pangkat Terakhir</td>
		  </tr>
			<tr>
			  <td height="20">Golongan</td>
			  <td height="20"><select name="KdGol" id="KdGol" disabled="true" >
			  			<?php if(@$KdGol<>'') ?>
							  <option value="<?php echo @$KdGol ?>"><?php echo nmgol(@$KdGol) ?></option>	
					    <option value="">- Pilih Gol -</option><?php
							$query = mysql_query("select KdGol, NmGol from kd_gol ");
					
						while($row = mysql_fetch_array($query)) { ?>
						    <option value="<?php echo $row['KdGol']; ?>"><?php echo $row['NmGol']; ?></option><?php
						} ?>
			  </select>&nbsp;&nbsp;Tmt Gol. &nbsp;&nbsp;<input name="TMTGol" type="text" class="form" id="TMTGol" size="10" value="<?php echo @$TMTGol ?>" disabled="true"/>
          &nbsp;<img src="" id="e_triggerIMG" hspace="5" title="Pilih Tanggal" name="TMTGolIMG"/>
          <script type="text/javascript">
				Calendar.setup({
					inputField		: "TMTGol",
					button			: "e_triggerIMG",
					align			: "BR",
					firstDay		: 1,
					weekNumbers		: false,
					singleClick		: true,
					showOthers		: true,
					ifFormat 		: "%Y-%m-%d"
				});
			</script>&nbsp;&nbsp;MKG&nbsp;&nbsp;<input name="mkgth" type="text" id="mkgth" value="<?php echo $mkgth ?>" size="3" disabled="true">&nbsp;&nbsp;Th&nbsp;&nbsp;<input name="mkgbl" type="text" id="mkgbl" value="<?php echo $mkgbl ?>" size="3" disabled="true">&nbsp;&nbsp;Bl</td>
		  </tr>
			<tr>
			  <td height="20">Nomor SK</td>
			  <td height="20"><input name="NoSKKP" type="text" id="NoSKKP" value="<?php echo @$NoSKKP ?>" size="30" disabled="true" />			    &nbsp;&nbsp;Tanggal&nbsp;<input name="TglSKKP" type="text" class="form" id="TglSKKP" size="10" value="<?php echo @$TglSKKP ?>" disabled="true"/>
          &nbsp;<img src="" id="f_triggerIMG" hspace="5" title="Pilih Tanggal" name="TglSKKPIMG"/>
          <script type="text/javascript">
				Calendar.setup({
					inputField		: "TglSKKP",
					button			: "f_triggerIMG",
					align			: "BR",
					firstDay		: 1,
					weekNumbers		: false,
					singleClick		: true,
					showOthers		: true,
					ifFormat 		: "%Y-%m-%d"
				});
			</script></td>
		  </tr>
			<tr>
			  <td height="20">Gaji Pokok Sesuai SK</td>
			  <td height="20"><input name="GajiKP" type="text" id="GajiKP" value="<?php echo @$GajiKP ?>" size="30" disabled="true" /></td>
		  </tr>
			<tr>
			  <td height="21" colspan="2"><input name="pangkat_ed" type="button" id="x" value="Ubah" onclick="removeAlignment_Pangkat()">
			  	  <input name="pangkat_edit" type="submit" id="simpan_1" value="Simpan" disabled="true">
				<input name="cancel" type="button" id="x" value="Keluar" onClick="Cancel('index.php?p=dtinduk_list&sw=<?php echo $sw ?>&cari=<?php echo $cari ?>')"></td>
		  </tr>
			<tr>
			  <td height="21">&nbsp;</td>
			  <td height="21"></td>
		  </tr>
			<tr>
				<td colspan="2"></td>
			</tr>
			<tr>
			  <td colspan="2">
<?php //-------------------- Tabel Riwayat			  
	$table = "m_riwkp";
	$orderby = "TMTGol";
	$ncol = count($header)+2;
	
	if (!isset($cari)) $cari = "";
	$nRecord = 15;
	$Interval = 50;
	if (!isset($pg)) $pg = 1;
	$Limit = ($pg - 1) * $nRecord;
		
	$sql = "SELECT * from $table WHERE NIB='$id'";
	$oList	= mysql_query($sql) or die(mysql_error());
	$nlist = mysql_num_rows($oList);
	
	$paging = Paging($nRecord, $Interval, $nlist, $pg);
		
	$i	= $Limit + 1;
	$oList	= mysql_query($sql." ORDER BY $orderby"); 
	while($List = mysql_fetch_object($oList)) {
		$column[0][] = $i;
		$column[1][] = $List->KdGol;
		$column[2][] = $List->TMTGol;
		$column[3][] = $List->NoSKKP;
		$column[4][] = $List->TglSKKP;
		$column[5][] = $List->MKGKP;
		$column[6][] = $List->GaPok;
		$i++;
	}

?></td>
</tr>
</table>
	</form>	
    <span class="style9">Riwayat Kepangkatan</span>
<br />
<table width="1169">
	<tr>
	  <th width="4%">No.</th>
	  <th width="31%">Gol</th>
	  <th width="10%">Tmt</th>
	  <th width="24%">Nomor SK </th>
	  <th width="6%">Tgl. Sk </th>
      <th width="5%">Status</th>
      <th width="8%">MKG</th>
      <th width="4%">Gaji<br />
        Pokok</th>
      </tr>
	<?php
	
	if ($nlist == 0) { ?>
		<tr>
			<td align="center" colspan="<?php echo $ncol ?>">Tidak Ada Data</td>
		</tr><?php
	}
	else {
		foreach ($column[0] as $k => $v) { 
			if ($v % 2 == 1) { ?>
				<tr bgcolor="#dedede">
					<td align="center"><?php echo $column[0][$k] ?></td>
					<td align="left"><?php echo nmgol($column[1][$k]).' ('.nmpangkat($column[1][$k]).')' ?></td>
					<td align="center"><?php echo reformat_tgl($column[2][$k]) ?></td>
					<td align="left"><?php echo $column[3][$k] ?></td>
				    <td align="center"><?php echo reformat_tgl($column[4][$k]) ?></td>
			        <td align="center"><?php echo status_kp($id,$column[2][$k]) ?></td>
			        <td align="center"><?php if($column[5][$k]<>''){?><?php echo substr($column[5][$k],0,2).' Th '.substr($column[5][$k],2,2).' Bl' ?><?php }?></td>
			        <td align="center"><?php echo number_format($column[6][$k],"0",",",".") ?></td>
		        </tr><?php
			}
			else { ?>
				<tr bgcolor="#efefef">
					<td align="center"><?php echo $column[0][$k] ?></td>
					<td align="left"><?php echo nmgol($column[1][$k]).' ('.nmpangkat($column[1][$k]).')' ?></td>
					<td align="center"><?php echo reformat_tgl($column[2][$k]) ?></td>
					<td align="left"><?php echo $column[3][$k] ?></td>
				    <td align="center"><?php echo reformat_tgl($column[4][$k]) ?></td>
			        <td align="center"><?php echo status_kp($id,$column[2][$k]) ?></td>
			        <td align="center"><?php if($column[5][$k]<>''){?><?php echo substr($column[5][$k],0,2).' Th '.substr($column[5][$k],2,2).' Bl' ?><?php }?></td>
			        <td align="center"><?php echo number_format($column[6][$k],"0",",",".") ?></td>
		        </tr><?php
			}
		}
	} ?>
</table>	
</div>
</div>

   <div id="JabStruktural">
 <script language="JavaScript">
  function removeAlignment_Struktural(){
	if(document.jabstruk.jabstruk_ed.value =="Ubah")
	{
		var read=document.getElementById("KdUnitKerja").removeAttribute("disabled",0);
		var read=document.getElementById("TMTUnit").removeAttribute("disabled",0);
		var read=document.getElementById("KdEselon").removeAttribute("disabled",0);
		var read=document.getElementById("TMTEselon").removeAttribute("disabled",0);
		var read=document.getElementById("NmJabatan").removeAttribute("disabled",0);
		var read=document.getElementById("TglAwal").removeAttribute("disabled",0);
		var read=document.getElementById("NmUnit").removeAttribute("disabled",0);
		var read=document.getElementById("NmInstansi").removeAttribute("disabled",0);
		var read=document.getElementById("NoSKJabStruk").removeAttribute("disabled",0);
		var read=document.getElementById("TglSKJabStruk").removeAttribute("disabled",0);
		var read=document.getElementById("simpan_2").removeAttribute("disabled",0);
		var read=document.jabstruk.TMTUnitIMG.src="css/images/calbtn.gif";
		var read=document.jabstruk.TMTEselonIMG.src="css/images/calbtn.gif";
		var read=document.jabstruk.TglAwalIMG.src="css/images/calbtn.gif";
		var read=document.jabstruk.TglSKJabStrukIMG.src="css/images/calbtn.gif";
	}
	else
	{
		document.getElementById("KdUnitKerja").disabled = true;
		document.getElementById("TMTUnit").disabled = true;
		document.getElementById("KdEselon").disabled = true;
		document.getElementById("TMTEselon").disabled = true;
		document.getElementById("NmJabatan").disabled = true;
		document.getElementById("TglAwal").disabled = true;
		document.getElementById("NmUnit").disabled = true;
		document.getElementById("NmInstansi").disabled = true;
		document.getElementById("NoSKJabStruk").disabled = true;
		document.getElementById("TglSKJabStruk").disabled = true;
		document.getElementById("simpan_2").disabled = true;
	}
  }
</script> 
<?php	
	$kdunit = substr($_SESSION['xxkdunit'],0,2);
	$title = "Unit Kerja & Jabatan Struktural";
	$table = "m_idpegawai";
	$pkey = "Nib";
	$field = array("KdUnitKerja", "KdEselon","TMTEselon", "TMTUnit");
	
	$bError	= false;
	
	if (!isset($id)) {
		$pagetitle = "Tambah ".$title;
	}
	else {
		$pagetitle = "Ubah ".$title;
	}
	
	if (isset($_POST["jabstruk_edit"])) {	
		
		if ($bError != true) {
			if (!isset($_GET["id"])) {
				//ADD NEW
				$sql = "insert into ".$table." (";
				
				$i = 1;
				foreach ($field as $val) {
					$sql .= $val;
					if ($i < count($field)) $sql .= ", ";
					$i++;
				}
				
				$sql .= ") values (";
				
				$i = 1;
				foreach ($field as $val) {
					$sql .= "'".$$val."'";
					if ($i < count($field)) $sql .= ", ";
					$i++;
				}
				
				$sql .= ")";
				
				mysql_query($sql) or die(mysql_error());
			
				$_SESSION['errmsg'] = "Update data ".$title." berhasil!";
				echo "<meta http-equiv=\"refresh\" content=\"0;URL=index.php?p=dtinduk_ed&id=$id&sw=$sw\">";
				exit();
			} 
			else {
				// UPDATE				
				$sql = "update ".$table." set ";
				
				$i = 1;
				foreach ($field as $val) {
					$sql .= $val." = '".$$val."'";
					if ($i < count($field)) $sql .= ", ";
					$i++;
				}
				
				$sql .= " where ".$pkey." = '".$id."'";
				
				mysql_query($sql) or die(mysql_error());
//----- update riwayat
	$kdeselon   = @$KdEselon;
	$tmteselon  = @$TMTEselon ;
	$nmjabatan	= $_REQUEST['NmJabatan'] ;
	$nmunit     = $_REQUEST['NmUnit'] ;
	$nminstansi = $_REQUEST['NmInstansi'] ;
	$tglawal    = $_REQUEST['TglAwal'] ;
	$nosk       = $_REQUEST['NoSKJabStruk'] ;
	$tglsk      = $_REQUEST['TglSKJabStruk'] ;
	$oEdit_riw = mysql_query("SELECT * FROM m_riwjabstruk WHERE NIB='$id' and KdEselon='$kdeselon' and TglAwal='$tglawal'") or die(mysql_error());
	$vEdit_riw = mysql_fetch_array($oEdit_riw);
	if(!empty($vEdit_riw)){
		mysql_query("UPDATE m_riwjabstruk SET NmJabatan='$nmjabatan', NmUnitKerja='$nmunit', NmInstansi='$nminstansi', NoSK='$nosk', TglSK='$tglsk' WHERE NIB='$id' and KdEselon='$kdeselon' and TglAwal='$tglawal'");
	}else{
		mysql_query("INSERT INTO m_riwjabstruk(NIB, KdEselon,TglAwal,NmJabatan,NmUnitKerja, NmInstansi, NoSK, TglSK) VALUES('$id','$kdeselon','$tglawal','$nmjabatan', '$nmunit', '$nminstansi', '$nosk', '$tglsk')");
	}
//--------------------------------				
				$_SESSION['errmsg'] = "Update data ".$title." berhasil!";
				echo "<meta http-equiv=\"refresh\" content=\"0;URL=index.php?p=dtinduk_ed&id=$id&sw=$sw\">";
				exit();
			}
		}
	} 
	else if (isset($_GET["id"])) {
		$oEdit = mysql_query("SELECT * FROM ".$table." WHERE ".$pkey." = '".$_GET["id"]."'") or die(mysql_error());
	
		if (mysql_num_rows($oEdit) == 0) {
			$bError		= true;
			$_SESSION['errmsg'] = "Invalid Request...!!";
		} 
		else {
			$Edit	= mysql_fetch_object($oEdit);
			
			foreach ($field as $val) {
				$$val = $Edit->$val;
			}
		}
	}
	
?>

<div id="forminduk">
	<form method="post" action="" name="jabstruk">
		<table width="959">
			<tr>
			  <td width="144" height="20">Unit Kerja  </td>
			  <td width="670" height="20"><select name="KdUnitKerja" id="KdUnitKerja" disabled="true">
			  			<?php if(@$KdUnitKerja<>'') ?>
							  <option value="<?php echo @$KdUnitKerja ?>"><?php echo nmunitkerja(@$KdUnitKerja) ?></option>	
					    <option value="">- Pilih Unit Kerja -</option><?php
							$query = mysql_query("select KdUnit, left(NmUnit,50) as namaunit from kd_unit WHERE left(KdUnit,2)='$kdunit'");
					
						while($row = mysql_fetch_array($query)) { ?>
						    <option value="<?php echo $row['KdUnit']; ?>"><?php echo $row['namaunit']; ?></option><?php
						} ?>
			  </select>&nbsp;&nbsp;Tmt &nbsp;&nbsp;<input name="TMTUnit" type="text" class="form" id="TMTUnit" size="10" value="<?php echo @$TMTUnit ?>" disabled="true"/>
          &nbsp;<img src="" id="g_triggerIMG" hspace="5" title="Pilih Tanggal" name="TMTUnitIMG"/>
          <script type="text/javascript">
				Calendar.setup({
					inputField		: "TMTUnit",
					button			: "g_triggerIMG",
					align			: "BR",
					firstDay		: 1,
					weekNumbers		: false,
					singleClick		: true,
					showOthers		: true,
					ifFormat 		: "%Y-%m-%d"
				});
			</script></td>
		  </tr>
			<tr>
			  <td height="20" colspan="2"><span class="style9">Jabatan Struktural saat ini</span></td>
	      </tr>
			<tr>
			  <td height="20">Eselon</td>
			  <td height="20"><select name="KdEselon" id="KdEselon" disabled="true">
                  <?php if(@$KdEselon<>'') ?>
                  <option value="<?php echo @$KdEselon ?>"><?php echo nmeselon(@$KdEselon) ?></option>
                  <option value="">- Pilih Eselon -</option>
			    <?php
							$query = mysql_query("select KdJab,NmJabatan from kd_jabatan where KdKel='001'");
					
						while($row = mysql_fetch_array($query)) { ?>
                  <option value="<?php echo $row['KdJab']; ?>"><?php echo $row['NmJabatan']; ?></option>
			    <?php
						} ?>
                </select>
			    &nbsp;&nbsp;Tmt &nbsp;&nbsp;
			    <input name="TMTEselon" type="text" class="form" id="TMTEselon" size="10" value="<?php echo @$TMTEselon ?>" disabled="true"/>
  &nbsp;<img src="" id="h_triggerIMG" hspace="5" title="Pilih Tanggal" name="TMTEselonIMG"/>
  <script type="text/javascript">
				Calendar.setup({
					inputField		: "TMTEselon",
					button			: "h_triggerIMG",
					align			: "BR",
					firstDay		: 1,
					weekNumbers		: false,
					singleClick		: true,
					showOthers		: true,
					ifFormat 		: "%Y-%m-%d"
				});
			</script></td>
		  </tr>
			<tr>
			  <td height="20">Jabatan</td>
			  <td height="20"><input name="NmJabatan" type="text" id="NmJabatan" value="<?php echo nmjabstruk_rwpeg($id,@$KdEselon,@$TMTUnit) ?>" size="50" disabled="true">&nbsp;&nbsp;Tmt&nbsp;&nbsp;<input name="TglAwal" type="text" class="form" id="TglAwal" size="10" value="<?php echo tmtjabatan_rwpeg($id,@$KdEselon,@$TMTUnit) ?>" disabled="true"/>
  &nbsp;<img src="" id="i_triggerIMG" hspace="5" title="Pilih Tanggal" name="TglAwalIMG"/>
  <script type="text/javascript">
				Calendar.setup({
					inputField		: "TglAwal",
					button			: "i_triggerIMG",
					align			: "BR",
					firstDay		: 1,
					weekNumbers		: false,
					singleClick		: true,
					showOthers		: true,
					ifFormat 		: "%Y-%m-%d"
				});
			</script></td>
		  </tr>
			<tr>
			  <td height="20">Unit / Instansi </td>
			  <td height="20"><input name="NmUnit" type="text" id="NmUnit" value="<?php echo nmunit_rwpeg($id,@$KdEselon,@$TMTUnit) ?>" size="20" disabled="true">&nbsp;&nbsp;
<input name="NmInstansi" type="text" id="NmInstansi" value="<?php echo nminstansi_rwpeg($id,@$KdEselon,@$TMTUnit) ?>" size="20" disabled="true">			  </td>
		  </tr>
			
			
			
			<tr>
			  <td height="20">Nomor SK </td>
			  <td height="20"><input name="NoSKJabStruk" type="text" id="NoSKJabStruk" value="<?php echo noskjabstruk_rwpeg($id,@$KdEselon,@$TMTUnit) ?>" size="30" disabled="true">&nbsp;&nbsp;Tanggal&nbsp;&nbsp;<input name="TglSKJabStruk" type="text" class="form" id="TglSKJabStruk" size="10" value="<?php echo tglskjabstruk_rwpeg($id,@$KdEselon,@$TMTUnit) ?>" disabled="true"/>
  &nbsp;<img src="" id="j_triggerIMG" hspace="5" title="Pilih Tanggal" name="TglSKJabStrukIMG"/>
  <script type="text/javascript">
				Calendar.setup({
					inputField		: "TglSKJabStruk",
					button			: "j_triggerIMG",
					align			: "BR",
					firstDay		: 1,
					weekNumbers		: false,
					singleClick		: true,
					showOthers		: true,
					ifFormat 		: "%Y-%m-%d"
				});
			</script></td>
		  </tr>
			
			<tr>
			  <td height="21" colspan="2"><input name="jabstruk_ed" type="button" id="x" value="Ubah" onclick="removeAlignment_Struktural()">
			  	  <input name="jabstruk_edit" type="submit" id="simpan_2" value="Simpan" disabled="true">	
				<input name="cancel" type="button" id="x" value="Keluar" onClick="Cancel('index.php?p=dtinduk_list&sw=<?php echo $sw ?>&cari=<?php echo $cari ?>')"></td>
		  </tr>
			<tr>
			  <td height="21">&nbsp;</td>
			  <td height="21"></td>
		  </tr>
			<tr>
				<td colspan="2">				</td>
			</tr>
			<tr>
			  <td colspan="2">
<?php //-------------------- Tabel Riwayat			  
	$table = "m_riwjabstruk";
	$orderby = "TglAwal";
	$ncol = count($header)+2;
	unset($column);
			
	if (!isset($cari)) $cari = "";
	$nRecord = 15;
	$Interval = 50;
	if (!isset($pg)) $pg = 1;
	$Limit = ($pg - 1) * $nRecord;
		
	$sql = "SELECT * from $table WHERE NIB='$id'";
	$oList	= mysql_query($sql) or die(mysql_error());
	$nlist = mysql_num_rows($oList);
	
	$paging = Paging($nRecord, $Interval, $nlist, $pg);
	$i	= $Limit + 1;
	$oList	= mysql_query($sql." ORDER BY $orderby"); 
	while($List = mysql_fetch_object($oList)) {
		$column[0][] = $i;
		$column[1][] = $List->NmJabatan;
		$column[2][] = $List->KdEselon;
		$column[3][] = $List->TglAwal;
		$column[4][] = $List->TglAkhir;
		$column[5][] = $List->NmUnitKerja;
		$column[6][] = $List->NmInstansi;
		$column[7][] = $List->NoSK;
		$column[8][] = $List->TglSK;
		$i++;
	}
?></td>
</tr>
</table>
	</form>	
    <span class="style9">Riwayat Jabatan Struktural </span>
<br />
<table width="1169">
	<tr>
	  <th width="6%">No.</th>
	  <th width="30%">Jabatan</th>
	  <th width="14%">Eselon</th>
	  <th width="9%">Waktu</th>
	  <th width="8%">Unit</th>
	  <th width="9%">Instansi</th>
	  <th width="19%">Nomor SK </th>
	  <th width="5%">Tgl. Sk </th>
      </tr>
	<?php
	
	if ($nlist == 0) { ?>
		<tr>
			<td align="center" colspan="<?php echo $ncol ?>">Tidak Ada Data</td>
		</tr><?php
	}
	else {
		foreach ($column[0] as $k => $v) { 
			if ($v % 2 == 1) { ?>
				<tr bgcolor="#dedede">
					<td align="center"><?php echo $column[0][$k] ?></td>
					<td align="left"><?php echo $column[1][$k] ?></td>
					<td align="center"><?php echo nmeselon($column[2][$k]) ?></td>
					<td align="center"><?php echo reformat_tgl($column[3][$k]) ?><br />s/d<br /><?php if($column[4][$k]<>'0000-00-00'){ ?><?php echo reformat_tgl($column[4][$k]) ?><?php }else{ ?><?php echo 'Sekarang' ?><?php } ?></td>
					<td align="center"><?php echo $column[5][$k] ?></td>
					<td align="center"><?php echo $column[6][$k] ?></td>
					<td align="left"><?php echo $column[7][$k] ?></td>
				    <td align="center"><?php echo reformat_tgl($column[8][$k]) ?></td>
		        </tr><?php
			}
			else { ?>
				<tr bgcolor="#efefef">
					<td align="center"><?php echo $column[0][$k] ?></td>
					<td align="left"><?php echo $column[1][$k] ?></td>
					<td align="center"><?php echo nmeselon($column[2][$k]) ?></td>
					<td align="center"><?php echo reformat_tgl($column[3][$k]) ?><br />s/d<br /><?php if($column[4][$k]<>'0000-00-00'){ ?><?php echo reformat_tgl($column[4][$k]) ?><?php }else{ ?><?php echo 'Sekarang' ?><?php } ?></td>
					<td align="center"><?php echo $column[5][$k] ?></td>
					<td align="center"><?php echo $column[6][$k] ?></td>
					<td align="left"><?php echo $column[7][$k] ?></td>
				    <td align="center"><?php echo reformat_tgl($column[8][$k]) ?></td>
		        </tr><?php
			}
		}
	} ?>
</table>	
</div>
</div>

   <div id="Pendidikan">
 <script language="JavaScript">
  function removeAlignment_Pendidikan(){
	if(document.pendidikan.pendidikan_ed.value =="Ubah")
	{
		var read=document.getElementById("KdTkPendidikan").removeAttribute("disabled",0);
		var read=document.getElementById("NmBdPendidikan").removeAttribute("disabled",0);
		var read=document.getElementById("AsalSekolah").removeAttribute("disabled",0);
		var read=document.getElementById("ThnLulus").removeAttribute("disabled",0);
		var read=document.getElementById("TglLulus").removeAttribute("disabled",0);
		var read=document.getElementById("simpan_4").removeAttribute("disabled",0);
		var read=document.pendidikan.TglLulusIMG.src="css/images/calbtn.gif";
	}
	else
	{
		document.getElementById("KdTkPendidikan").disabled = true;
		document.getElementById("NmBdPendidikan").disabled = true;
		document.getElementById("AsalSekolah").disabled = true;
		document.getElementById("ThnLulus").disabled = true;
		document.getElementById("TglLulus").disabled = true;
		document.getElementById("simpan_4").disabled = true;
	}
  }
  </script>
<?php	
	$kdunit = substr($_SESSION['xxkdunit'],0,2);
	$title = "Pendidikan";
	$table = "m_idpegawai";
	$pkey = "Nib";
	$field = array("KdTkPendidikan", "NmBdPendidikan");
	
	$bError	= false;
	
	if (!isset($id)) {
		$pagetitle = "Tambah ".$title;
	}
	else {
		$pagetitle = "Ubah ".$title;
	}
	
	if (isset($_POST["pendidikan_edit"])) {	
		
		if ($bError != true) {
			if (!isset($_GET["id"])) {
				//ADD NEW
				$sql = "insert into ".$table." (";
				
				$i = 1;
				foreach ($field as $val) {
					$sql .= $val;
					if ($i < count($field)) $sql .= ", ";
					$i++;
				}
				
				$sql .= ") values (";
				
				$i = 1;
				foreach ($field as $val) {
					$sql .= "'".$$val."'";
					if ($i < count($field)) $sql .= ", ";
					$i++;
				}
				
				$sql .= ")";
				
				mysql_query($sql) or die(mysql_error());
			
				$_SESSION['errmsg'] = "Update data ".$title." berhasil!";
				echo "<meta http-equiv=\"refresh\" content=\"0;URL=index.php?p=dtinduk_ed&id=$id&sw=$sw\">";
				exit();
			} 
			else {
				// UPDATE				
				$sql = "update ".$table." set ";
				
				$i = 1;
				foreach ($field as $val) {
					$sql .= $val." = '".$$val."'";
					if ($i < count($field)) $sql .= ", ";
					$i++;
				}
				
				$sql .= " where ".$pkey." = '".$id."'";
				
				mysql_query($sql) or die(mysql_error());
//----- update riwayat
	$kdtkpendidikan  = $_REQUEST['KdTkPendidikan'];
	$nmbdpendidikan	 = $_REQUEST['NmBdPendidikan'];
	$asalsekolah = $_REQUEST['AsalSekolah'] ;
	$tgllulus = $_REQUEST['TglLulus'] ;
	$thnlulus  = $_REQUEST['ThnLulus'];
	$oEdit_riw = mysql_query("SELECT * FROM m_riwpend WHERE NIB='$id' and KdTkPend='$kdtkpendidikan'") or die(mysql_error());
	$vEdit_riw = mysql_fetch_array($oEdit_riw);
	if(!empty($vEdit_riw)){
		mysql_query("UPDATE m_riwpend SET NmBidPend='$nmbdpendidikan', AsalSekolah='$asalsekolah', TglLulus='$tgllulus', ThnLulus='$thnlulus' WHERE NIB='$id' and KdTkPend='$kdtkpendidikan'");
	}else{
		mysql_query("INSERT INTO m_riwpend(NIB, KdTkPend, NmBidPend, AsalSekolah, TglLulus, ThnLulus) VALUES('$id', '$kdtkpendidikan', '$nmbdpendidikan', '$asalsekolah', '$tgllulus', '$thnlulus')");
	}
//--------------------------------				
				$_SESSION['errmsg'] = "Update data ".$title." berhasil!";
				echo "<meta http-equiv=\"refresh\" content=\"0;URL=index.php?p=dtinduk_ed&id=$id&sw=$sw\">";
				exit();
			}
		}
	} 
	else if (isset($_GET["id"])) {
		$oEdit = mysql_query("SELECT * FROM ".$table." WHERE ".$pkey." = '".$_GET["id"]."'") or die(mysql_error());
	
		if (mysql_num_rows($oEdit) == 0) {
			$bError		= true;
			$_SESSION['errmsg'] = "Invalid Request...!!";
		} 
		else {
			$Edit	= mysql_fetch_object($oEdit);
			
			foreach ($field as $val) {
				$$val = $Edit->$val;
			}
		}
	}
?>

<div id="forminduk">
	<form method="post" action="" name="pendidikan">
		<table width="1148">
			    
		    
			<tr>
			  <td width="157" height="20">Tingkat</td>
			  <td width="641" height="20"><select name="KdTkPendidikan" id="KdTkPendidikan" disabled="true">
			  			<?php if(@$KdTkPendidikan<>'') ?>
							  <option value="<?php echo @$KdTkPendidikan ?>"><?php echo nmtkpendidikan(@$KdTkPendidikan) ?></option>	
					    <option value="">- Pilih Tingkat Pendidikan -</option><?php
							$query = mysql_query("select Tingkat_Pd, left(NmTkPendik,50) as namatkpendik from kd_tkpen");
					
						while($row = mysql_fetch_array($query)) { ?>
						    <option value="<?php echo $row['Tingkat_Pd']; ?>"><?php echo $row['namatkpendik']; ?></option><?php
						} ?>
			  </select></td>
		  </tr>
			<tr>
			  <td height="20">Bidang</td>
			  <td height="20"><input name="NmBdPendidikan" type="text" id="NmBdPendidikan" value="<?php echo @$NmBdPendidikan ?>" size="60" disabled="true"></td>
		  </tr>
			

			
			<tr>
			  <td height="20">Asal Sekolah </td>
			  <td height="20"><input name="AsalSekolah" type="text" id="AsalSekolah" value="<?php echo asalsekolah_rwpeg($id,@$KdTkPendidikan) ?>" size="60" disabled="true"></td>
		  </tr>
			
			<tr>
			  <td height="20">Tahun Lulus </td>
			  <td height="20"><input name="ThnLulus" type="text" id="ThnLulus" value="<?php echo thlulus_rwpeg($id,@$KdTkPendidikan) ?>" size="15" disabled="true">&nbsp;&nbsp;Tanggal &nbsp;&nbsp;<input name="TglLulus" type="text" class="form" id="TglLulus" size="10" value="<?php echo tgllulus_rwpeg($id,@$KdTkPendidikan) ?>" disabled="true"/>
          &nbsp;<img src="" id="z_triggerIMG" hspace="5" title="Pilih Tanggal" name="TglLulusIMG"/>
          <script type="text/javascript">
				Calendar.setup({
					inputField		: "TglLulus",
					button			: "z_triggerIMG",
					align			: "BR",
					firstDay		: 1,
					weekNumbers		: false,
					singleClick		: true,
					showOthers		: true,
					ifFormat 		: "%Y-%m-%d"
				});
			</script></td>
		  </tr>
			<tr>
			  <td height="20" colspan="2"><input name="pendidikan_ed" type="button" id="x" value="Ubah" onclick="removeAlignment_Pendidikan()">
			  	  <input name="pendidikan_edit" type="submit" id="simpan_4" value="Simpan" disabled="disabled">
				<input name="cancel" type="button" id="x" value="Keluar" onClick="Cancel('index.php?p=dtinduk_list&sw= <?php echo $sw ?>&cari=<?php echo $cari ?>')"></td>
		  </tr>
			<tr>
			  <td height="20">&nbsp;</td>
			  <td height="20">&nbsp;</td>
		  </tr>
			<tr>
				<td colspan="2">				</td>
			</tr>
			<tr>
			  <td colspan="2">
<?php //-------------------- Tabel Riwayat			  
	$table = "m_riwpend";
	$orderby = "KdTkPend";
	$ncol = count($header)+2;
	unset($column);
			
	if (!isset($cari)) $cari = "";
	$nRecord = 15;
	$Interval = 50;
	if (!isset($pg)) $pg = 1;
	$Limit = ($pg - 1) * $nRecord;
		
	$sql = "SELECT * from $table WHERE NIB='$id'";
	$oList	= mysql_query($sql) or die(mysql_error());
	$nlist = mysql_num_rows($oList);
	
	$paging = Paging($nRecord, $Interval, $nlist, $pg);
	$i	= $Limit + 1;
	$oList	= mysql_query($sql." ORDER BY $orderby"); 
	while($List = mysql_fetch_object($oList)) {
		$column[0][] = $i;
		$column[1][] = $List->KdTkPend;
		$column[2][] = $List->NmBidPend;
		$column[3][] = $List->AsalSekolah;
		$column[4][] = $List->ThnLulus;
		$column[5][] = $List->TglLulus;
		$i++;
	}
?></td>
</tr>
</table>
	</form>	
    <span class="style9">Riwayat Pendidikan </span>
<br />
<table width="1169">
	<tr>
	  <th width="8%">No.</th>
	  <th width="17%">Tingkat</th>
	  <th width="22%">Bidang</th>
	  <th width="32%">Asal Sekolah </th>
	  <th width="10%">Tahun</th>
	  <th width="11%">Tanggal Lulus </th>
	  </tr>
	<?php
	
	if ($nlist == 0) { ?>
		<tr>
			<td align="center" colspan="<?php echo $ncol ?>">Tidak Ada Data</td>
		</tr><?php
	}
	else {
		foreach ($column[0] as $k => $v) { 
			if ($v % 2 == 1) { ?>
				<tr bgcolor="#dedede">
					<td align="center"><?php echo $column[0][$k] ?></td>
					<td align="left"><?php echo nmjenjangpen($column[1][$k]) ?></td>
					<td align="left"><?php echo $column[2][$k] ?></td>
					<td align="left"><?php echo $column[3][$k] ?></td>
					<td align="center"><?php echo $column[4][$k] ?></td>
					<td align="center"><?php echo reformat_tgl($column[5][$k]) ?></td>
			    </tr><?php
			}
			else { ?>
				<tr bgcolor="#efefef">
					<td align="center"><?php echo $column[0][$k] ?></td>
					<td align="left"><?php echo nmjenjangpen($column[1][$k]) ?></td>
					<td align="left"><?php echo $column[2][$k] ?></td>
					<td align="left"><?php echo $column[3][$k] ?></td>
					<td align="center"><?php echo $column[4][$k] ?></td>
					<td align="center"><?php echo reformat_tgl($column[5][$k]) ?></td>
			    </tr><?php
			}
		}
	} ?>
</table>	
</div>
</div>

   <div id="KGB">
 <script language="JavaScript">
  function removeAlignment_KGB(){
	if(document.kgb.kgb_ed.value =="Ubah")
	{
		var read=document.getElementById("TMTKGB").removeAttribute("disabled",0);
		var read=document.getElementById("mkgth_kgb").removeAttribute("disabled",0);
		var read=document.getElementById("mkgbl_kgb").removeAttribute("disabled",0);
		var read=document.getElementById("NoSKKGB").removeAttribute("disabled",0);
		var read=document.getElementById("TglSKKGB").removeAttribute("disabled",0);
		var read=document.getElementById("GajiKGB").removeAttribute("disabled",0);
		var read=document.getElementById("TTKGB").removeAttribute("disabled",0);
		var read=document.getElementById("simpan_5").removeAttribute("disabled",0);
		var read=document.kgb.TMTKGBIMG.src="css/images/calbtn.gif";
		var read=document.kgb.TglSKKGBIMG.src="css/images/calbtn.gif";
	}
	else
	{
		document.getElementById("TMTKGB").disabled = true;
		document.getElementById("mkgth_kgb").disabled = true;
		document.getElementById("mkgbl_kgb").disabled = true;
		document.getElementById("NoSKKGB").disabled = true;
		document.getElementById("TglSKKGB").disabled = true;
		document.getElementById("GajiKGB").disabled = true;
		document.getElementById("TTKGB").disabled = true;
		document.getElementById("simpan_5").disabled = true;
	}
  }
  </script>
<?php	
	$kdunit = substr($_SESSION['xxkdunit'],0,2);
	$title = "SK Gaji Berkala";
	$table = "m_idpegawai";
	$pkey = "Nib";
	$field = array("KdGol", "TMTGol", "TMTKGB", "MKGKGB", "NoSKKGB", "TglSKKGB", "GajiKGB", "TTKGB");
	
	$bError	= false;
	
	if (!isset($id)) {
		$pagetitle = "Tambah ".$title;
	}
	else {
		$pagetitle = "Ubah ".$title;
	}
	
	if (isset($_POST["kgb_edit"])) {	
		$mkgth = $_REQUEST['mkgth'];
		$mkgbl = $_REQUEST['mkgbl'];
		@$MKGKGB = $mkgth.$mkgbl ;
		if ($bError != true) {
			if (!isset($_GET["id"])) {
				//ADD NEW
				$sql = "insert into ".$table." (";
				
				$i = 1;
				foreach ($field as $val) {
					$sql .= $val;
					if ($i < count($field)) $sql .= ", ";
					$i++;
				}
				
				$sql .= ") values (";
				
				$i = 1;
				foreach ($field as $val) {
					$sql .= "'".$$val."'";
					if ($i < count($field)) $sql .= ", ";
					$i++;
				}
				
				$sql .= ")";
				
				mysql_query($sql) or die(mysql_error());
			
				$_SESSION['errmsg'] = "Update data ".$title." berhasil!";
				echo "<meta http-equiv=\"refresh\" content=\"0;URL=index.php?p=dtinduk_ed&id=$id&sw=$sw\">";
				exit();
			} 
			else {
				// UPDATE				
				$sql = "update ".$table." set ";
				
				$i = 1;
				foreach ($field as $val) {
					$sql .= $val." = '".$$val."'";
					if ($i < count($field)) $sql .= ", ";
					$i++;
				}
				
				$sql .= " where ".$pkey." = '".$id."'";
				
				mysql_query($sql) or die(mysql_error());
//----- update riwayat
	$kdgol = kdgol_peg($id);
	$tmtkgb  = @$TMTKGB ;
	$mkgkgb	 = @$MKGKGB ;
	$noskkgb = @$NoSKKGB ;
	$tglskkgb = @$TglSKKGB ;
	$gajikgb  = @$GajiKGB ;
	$oEdit_riw = mysql_query("SELECT * FROM m_riwkgb WHERE NIB='$id' and KdGol='$kdgol' and TMTKGB='$tmtkgb'") or die(mysql_error());
	$vEdit_riw = mysql_fetch_array($oEdit_riw);
	if(!empty($vEdit_riw)){
		mysql_query("UPDATE m_riwkgb SET NoSKKGB='$noskkgb', MKGKGB='$mkgkgb', TglSKKGB='$tglskkgb',GaPok='$gajikgb' WHERE NIB='$id' and KdGol='$kdgol' and TMTKGB='$tmtkgb'");
	}else{
		mysql_query("INSERT INTO m_riwkgb(NIB, KdGol,TMTKGB, NoSKKGB, MKGKGB, TglSKKGB, GaPok) VALUES('$id','$kdgol','$tmtkgb','$noskkgb', '$mkgkgb', '$tglskkgb', '$gajikgb')");
	}
//--------------------------------				
				$_SESSION['errmsg'] = "Update data ".$title." berhasil!";
				echo "<meta http-equiv=\"refresh\" content=\"0;URL=index.php?p=dtinduk_ed&id=$id&sw=$sw\">";
				exit();
			}
		}
	} 
	else if (isset($_GET["id"])) {
		$oEdit = mysql_query("SELECT * FROM ".$table." WHERE ".$pkey." = '".$_GET["id"]."'") or die(mysql_error());
	
		if (mysql_num_rows($oEdit) == 0) {
			$bError		= true;
			$_SESSION['errmsg'] = "Invalid Request...!!";
		} 
		else {
			$Edit	= mysql_fetch_object($oEdit);
			
			foreach ($field as $val) {
				$$val = $Edit->$val;
			}
		}
	}
	$mkgth = substr(@$MKGKGB,0,2);
	$mkgbl = substr(@$MKGKGB,2,2);
?>

<div id="forminduk">
	<form method="post" action="" name="kgb">
		<table width="1224">
			    
			<tr>
			  <td width="239" height="20">Tmt KGB </td>
			  <td width="973" height="20"><input name="TMTKGB" type="text" class="form" id="TMTKGB" size="10" value="<?php echo @$TMTKGB ?>" disabled="true"/>
          &nbsp;<img src="" id="k_triggerIMG" hspace="5" title="Pilih Tanggal" name="TMTKGBIMG" />
          <script type="text/javascript">
				Calendar.setup({
					inputField		: "TMTKGB",
					button			: "k_triggerIMG",
					align			: "BR",
					firstDay		: 1,
					weekNumbers		: false,
					singleClick		: true,
					showOthers		: true,
					ifFormat 		: "%Y-%m-%d"
				});
			</script>&nbsp;&nbsp;Masa Kerja &nbsp;&nbsp;<input name="mkgth" type="text" id="mkgth_kgb" value="<?php echo $mkgth ?>" size="3" disabled="true">&nbsp;Th&nbsp;<input name="mkgbl" type="text" id="mkgbl_kgb" value="<?php echo $mkgbl ?>" size="3" disabled="true">&nbsp;Bl</td>
		  </tr>
			

			
			<tr>
			  <td height="20">Nomor SK </td>
			  <td height="20"><input name="NoSKKGB" type="text" id="NoSKKGB" value="<?php echo @$NoSKKGB ?>" size="30" disabled="true">&nbsp;&nbsp;Tanggal&nbsp;&nbsp;<input name="TglSKKGB" type="text" class="form" id="TglSKKGB" size="10" value="<?php echo @$TglSKKGB ?>" disabled="true"/>
          &nbsp;<img src="" id="l_triggerIMG" hspace="5" title="Pilih Tanggal" name="TglSKKGBIMG"/>
          <script type="text/javascript">
				Calendar.setup({
					inputField		: "TglSKKGB",
					button			: "l_triggerIMG",
					align			: "BR",
					firstDay		: 1,
					weekNumbers		: false,
					singleClick		: true,
					showOthers		: true,
					ifFormat 		: "%Y-%m-%d"
				});
			</script></td>
		  </tr>
			<tr>
			  <td height="20">Gaji Pokok </td>
			  <td height="20"><input name="GajiKGB" type="text" id="GajiKGB" value="<?php echo @$GajiKGB ?>" size="20" disabled="true"/></td>
		  </tr>
			
			<tr>
			  <td height="20">Penanda Tangan SK </td>
			  <td height="20"><input name="TTKGB" type="text" id="TTKGB" value="<?php echo @$TTKGB ?>" size="50" disabled="true">&nbsp;</td>
			</tr>
			<tr>
			  <td height="20" colspan="2"><input name="kgb_ed" type="button" id="x" value="Ubah" onclick="removeAlignment_KGB();">
			  	  <input name="kgb_edit" type="submit" id="simpan_5" value="Simpan" disabled="disabled">
				<input name="cancel" type="button" id="x" value="Keluar" onClick="Cancel('index.php?p=dtinduk_list&sw= <?php echo $sw ?>&cari=<?php echo $cari ?>')"></td>
		  </tr>
			<tr>
			  <td height="20">&nbsp;</td>
			  <td height="20">&nbsp;</td>
		  </tr>	
			<tr>
				<td colspan="2">				</td>
			</tr>
			<tr>
			  <td colspan="2">
<?php //-------------------- Tabel Riwayat			  
	$table = "m_riwkgb";
	$orderby = "TMTKGB";
	$ncol = count($header)+2;
	unset($column);
			
	if (!isset($cari)) $cari = "";
	$nRecord = 15;
	$Interval = 50;
	if (!isset($pg)) $pg = 1;
	$Limit = ($pg - 1) * $nRecord;
		
	$sql = "SELECT * from $table WHERE NIB='$id'";
	$oList	= mysql_query($sql) or die(mysql_error());
	$nlist = mysql_num_rows($oList);
	
	$paging = Paging($nRecord, $Interval, $nlist, $pg);
	$i	= $Limit + 1;
	$oList	= mysql_query($sql." ORDER BY $orderby"); 
	while($List = mysql_fetch_object($oList)) {
		$column[0][] = $i;
		$column[1][] = $List->KdGol;
		$column[2][] = $List->TMTKGB;
		$column[3][] = $List->MKGKGB;
		$column[4][] = $List->GaPok;
		$column[5][] = $List->NoSKKGB;
		$column[6][] = $List->TglSKKGB;
		$i++;
	}
?></td>
</tr>
</table>
	</form>	
    <span class="style9">Riwayat SK Gaji Berkala </span>
<br />
<table width="1084">
	<tr>
	  <th width="8%">No.</th>
	  <th width="15%">Golongan</th>
	  <th width="12%">Tmt KGB </th>
	  <th width="14%">MKG KGB </th>
	  <th width="13%">Gaji Pokok </th>
	  <th width="20%">Nomor SK </th>
	  <th width="18%">Tgl. SK </th>
	  </tr>
	<?php
	
	if ($nlist == 0) { ?>
		<tr>
			<td align="center" colspan="<?php echo $ncol ?>">Tidak Ada Data</td>
		</tr><?php
	}
	else {
		foreach ($column[0] as $k => $v) { 
			if ($v % 2 == 1) { ?>
				<tr bgcolor="#dedede">
					<td align="center"><?php echo $column[0][$k] ?></td>
					<td align="center"><?php echo nmgol($column[1][$k]) ?></td>
					<td align="center"><?php echo reformat_tgl($column[2][$k]) ?></td>
					<td align="center"><?php if($column[3][$k]<>''){?><?php echo substr($column[3][$k],0,2).' Th '.substr($column[3][$k],2,2).' Bl ' ?><?php }?></td>
					<td align="center"><?php echo number_format($column[4][$k],"0",",",".") ?></td>
					<td align="left"><?php echo $column[5][$k] ?></td>
			        <td align="center"><?php echo reformat_tgl($column[6][$k]) ?></td>
		        </tr><?php
			}
			else { ?>
				<tr bgcolor="#efefef">
					<td align="center"><?php echo $column[0][$k] ?></td>
					<td align="center"><?php echo nmgol($column[1][$k]) ?></td>
					<td align="center"><?php echo reformat_tgl($column[2][$k]) ?></td>
					<td align="center"><?php if($column[3][$k]<>''){?><?php echo substr($column[3][$k],0,2).' Th '.substr($column[3][$k],2,2).' Bl ' ?><?php }?></td>
					<td align="center"><?php echo number_format($column[4][$k],"0",",",".") ?></td>
					<td align="left"><?php echo $column[5][$k] ?></td>
			        <td align="center"><?php echo reformat_tgl($column[6][$k]) ?></td>
		        </tr><?php
			}
		}
	} ?>
</table>	
</div>
</div>

   <div id="TBN">
 <script language="JavaScript">
  function removeAlignment_TBN(){
	if(document.tbn.tbn_ed.value =="Ubah")
	{
		var read=document.getElementById("KdStatusTBN_1").removeAttribute("disabled",0);
		var read=document.getElementById("KdStatusTBN_0").removeAttribute("disabled",0);
		var read=document.getElementById("TMTStatusTBN").removeAttribute("disabled",0);
		var read=document.getElementById("KdTkTBN").removeAttribute("disabled",0);
		var read=document.getElementById("TMTTBN").removeAttribute("disabled",0);
		var read=document.getElementById("NilTBN").removeAttribute("disabled",0);
		var read=document.getElementById("NoSKTBN").removeAttribute("disabled",0);
		var read=document.getElementById("TglSKTBN").removeAttribute("disabled",0);
		var read=document.getElementById("simpan_6").removeAttribute("disabled",0);
		var read=document.tbn.TMTStatusTBNIMG.src="css/images/calbtn.gif";
		var read=document.tbn.TMTTBNIMG.src="css/images/calbtn.gif";
		var read=document.tbn.TglSKTBNIMG.src="css/images/calbtn.gif";
	}
	else
	{
		document.getElementById("KdStatusTBN_1").disabled = true;
		document.getElementById("KdStatusTBN_0").disabled = true;
		document.getElementById("TMTStatusTBN").disabled = true;
		document.getElementById("KdTkTBN").disabled = true;
		document.getElementById("TMTTBN").disabled = true;
		document.getElementById("NilTBN").disabled = true;
		document.getElementById("NoSKTBN").disabled = true;
		document.getElementById("TglSKTBN").disabled = true;
		document.getElementById("simpan_6").disabled = true;	
	}
  }
</script> 
<?php	
	$kdunit = substr($_SESSION['xxkdunit'],0,2);
	$title = "Pegawai";
	$table = "m_idpegawai";
	$pkey = "Nib";
	$field = array("KdTkTBN", "TMTTBN", "KdStatusTBN", "TMTStatusTBN");
	
	$bError	= false;
	
	if (!isset($id)) {
		$pagetitle = "Tambah ".$title;
	}
	else {
		$pagetitle = "Ubah ".$title;
	}
	
	if (isset($_POST["tbn_edit"])) {	
		if ($bError != true) {
			if (!isset($_GET["id"])) {
				//ADD NEW
				$sql = "insert into ".$table." (";
				
				$i = 1;
				foreach ($field as $val) {
					$sql .= $val;
					if ($i < count($field)) $sql .= ", ";
					$i++;
				}
				
				$sql .= ") values (";
				
				$i = 1;
				foreach ($field as $val) {
					$sql .= "'".$$val."'";
					if ($i < count($field)) $sql .= ", ";
					$i++;
				}
				
				$sql .= ")";
				
				mysql_query($sql) or die(mysql_error());
			
				$_SESSION['errmsg'] = "Update data ".$title." berhasil!";
				echo "<meta http-equiv=\"refresh\" content=\"0;URL=index.php?p=dtinduk_ed&id=$id&sw=$sw\">";
				exit();
			} 
			else {
				// UPDATE				
				$sql = "update ".$table." set ";
				
				$i = 1;
				foreach ($field as $val) {
					$sql .= $val." = '".$$val."'";
					if ($i < count($field)) $sql .= ", ";
					$i++;
				}
				
				$sql .= " where ".$pkey." = '".$id."'";
				
				mysql_query($sql) or die(mysql_error());
//----- update riwayat
	$tabel_riw = "m_riwtbn";
	$pkey_riw = "Nib";
	$kdtktbn = @$KdTkTBN ;
	$tmttbn  = @$TMTTBN ;
	$niltbn = $_REQUEST['NilTBN'];
	$tunjtbn = tunjtbn($kdtktbn);
	$nosktbn = $_REQUEST['NoSKTBN'];
	$tglsktbn = $_REQUEST['TglSKTBN'];
	$oEdit_riw = mysql_query("SELECT * FROM m_riwtbn WHERE NIB='$id' and KdTkTBN='$kdtktbn' and TMTTBN='$tmttbn'") or die(mysql_error());
	$vEdit_riw = mysql_fetch_array($oEdit_riw);
	if(!empty($vEdit_riw)){
		mysql_query("UPDATE m_riwtbn SET NilaiTBN='$niltbn', JmlTunj='$tunjtbn', NoSKTBN='$nosktbn',TglSKTBN='$tglsktbn' WHERE NIB='$id' and KdTkTBN='$kdtktbn' and TMTTBN='$tmttbn'");
	}else{
		mysql_query("INSERT INTO m_riwtbn(NIB, KdTkTBN,TMTTBN, NilaiTBN, JmlTunj, NoSKTBN, TglSKTBN) VALUES('$id','$kdtktbn','$tmttbn','$niltbn', '$tunjtbn', '$nosktbn', '$tglsktbn')");
	}
//--------------------------------				
				$_SESSION['errmsg'] = "Update data ".$title." berhasil!";
				echo "<meta http-equiv=\"refresh\" content=\"0;URL=index.php?p=dtinduk_ed&id=$id&sw=$sw\">";
				exit();
			}
		}
	} 
	else if (isset($_GET["id"])) {
		$oEdit = mysql_query("SELECT * FROM ".$table." WHERE ".$pkey." = '".$_GET["id"]."'") or die(mysql_error());
	
		if (mysql_num_rows($oEdit) == 0) {
			$bError		= true;
			$_SESSION['errmsg'] = "Invalid Request...!!";
		} 
		else {
			$Edit	= mysql_fetch_object($oEdit);
			
			foreach ($field as $val) {
				$$val = $Edit->$val;
			}
		}
	}
?>
<script language="javascript" src="user/ajax.js"></script>
<div id="forminduk">
	<form method="post" action="" name="tbn">
		<table width="1224">
			    
			<tr>
			  <td width="200" height="20">Status TBN </td>
			  <td width="748" height="20"><input name="KdStatusTBN" type="radio" id="KdStatusTBN_1" value="1" <?php if(@$KdStatusTBN=='1') { ?>checked <?php } ?> disabled="true"/>
        Aktif &nbsp;
		<input name="KdStatusTBN" type="radio" id="KdStatusTBN_0" value="0" <?php if(@$KdStatusTBN=='0') { ?>checked <?php }?> disabled="true"/>
        Non Aktif&nbsp;&nbsp;&nbsp;&nbsp;Tmt&nbsp;&nbsp;<input name="TMTStatusTBN" type="text" class="form" id="TMTStatusTBN" size="10" value="<?php echo @$TMTStatusTBN ?>" disabled="true"/>
          &nbsp;<img src="" id="o_triggerIMG" hspace="5" title="Pilih Tanggal" name="TMTStatusTBNIMG" />
          <script type="text/javascript">
				Calendar.setup({
					inputField		: "TMTStatusTBN",
					button			: "o_triggerIMG",
					align			: "BR",
					firstDay		: 1,
					weekNumbers		: false,
					singleClick		: true,
					showOthers		: true,
					ifFormat 		: "%Y-%m-%d"
				});
			</script></td>
			</tr>
			<tr>
			  <td height="20">Tingkat TBN </td>
			  <td height="20"><select name="KdTkTBN" id="KdTkTBN" disabled="true">
			  			<?php if(@$KdTkTBN<>'') ?>
							  <option value="<?php echo @$KdTkTBN ?>"><?php echo nmtktbn(@$KdTkTBN) ?></option>	
					    <option value="">- Pilih Tingkat TBN -</option><?php
							$query = mysql_query("select * from kd_tktbn");
					
						while($row = mysql_fetch_array($query)) { ?>
						    <option value="<?php echo $row['KdTkTBN']; ?>"><?php echo $row['NmTkTBN']; ?></option><?php
						} ?>
			  </select>&nbsp;&nbsp;Tmt&nbsp;&nbsp;<input name="TMTTBN" type="text" class="form" id="TMTTBN" size="10" value="<?php echo @$TMTTBN ?>" disabled="true"/>
          &nbsp;<img src="" id="m_triggerIMG" hspace="5" title="Pilih Tanggal" name="TMTTBNIMG"/>
          <script type="text/javascript">
				Calendar.setup({
					inputField		: "TMTTBN",
					button			: "m_triggerIMG",
					align			: "BR",
					firstDay		: 1,
					weekNumbers		: false,
					singleClick		: true,
					showOthers		: true,
					ifFormat 		: "%Y-%m-%d"
				});
			</script></td>
		  </tr>
			<tr>
			  <td height="20">Nilai</td>
			  <td height="20"><input name="NilTBN" type="text" id="NilTBN" value="<?php echo niltbn_rwpeg($id,@$KdTkTBN,@$TMTTBN) ?>" size="20" disabled="true"/></td>
		  </tr>
			<tr>
			  <td height="20">Nomor SK </td>
			  <td height="20"><input name="NoSKTBN" type="text" id="NoSKTBN" value="<?php echo nosktbn_rwpeg($id,@$KdTkTBN,@$TMTTBN) ?>" size="30" disabled="true">&nbsp;&nbsp;Tanggal&nbsp;&nbsp;<input name="TglSKTBN" type="text" class="form" id="TglSKTBN" size="10" value="<?php echo tglsktbn_rwpeg($id,@$KdTkTBN,@$TMTTBN) ?>" disabled="true"/>
          &nbsp;<img src="" id="n_triggerIMG" hspace="5" title="Pilih Tanggal" name="TglSKTBNIMG"/>
          <script type="text/javascript">
				Calendar.setup({
					inputField		: "TglSKTBN",
					button			: "n_triggerIMG",
					align			: "BR",
					firstDay		: 1,
					weekNumbers		: false,
					singleClick		: true,
					showOthers		: true,
					ifFormat 		: "%Y-%m-%d"
				});
			</script></td>
		  </tr>
			
			
			<tr>
			  
			  <td height="20" colspan="2"><input name="tbn_ed" type="button" id="x" value="Ubah" onclick="removeAlignment_TBN()">
			  	  <input name="tbn_edit" type="submit" id="simpan_6" value="Simpan" disabled="true">
				<input name="cancel" type="button" id="x" value="Keluar" onClick="Cancel('index.php?p=dtinduk_list&sw= <?php echo $sw ?>&cari=<?php echo $cari ?>')"><td width="260"></td>
			</tr>
			<tr>
			  <td height="20">            
			  <td></td>
		  <td>		  </tr>	
			<tr>
				<td colspan="2">				</td>
			</tr>
			<tr>
			  <td colspan="2">
<?php //-------------------- Tabel Riwayat			  
	$table = "m_riwtbn";
	$orderby = "TMTTBN";
	$ncol = count($header)+2;
	unset($column);
			
	if (!isset($cari)) $cari = "";
	$nRecord = 15;
	$Interval = 50;
	if (!isset($pg)) $pg = 1;
	$Limit = ($pg - 1) * $nRecord;
		
	$sql = "SELECT * from $table WHERE NIB='$id'";
	$oList	= mysql_query($sql) or die(mysql_error());
	$nlist = mysql_num_rows($oList);
	
	$paging = Paging($nRecord, $Interval, $nlist, $pg);
	$i	= $Limit + 1;
	$oList	= mysql_query($sql." ORDER BY $orderby"); 
	while($List = mysql_fetch_object($oList)) {
		$column[0][] = $i;
		$column[1][] = $List->KdTkTBN;
		$column[2][] = $List->TMTTBN;
		$column[3][] = $List->NilaiTBN;
		$column[4][] = $List->JmlTunj;
		$column[5][] = $List->NoSKTBN;
		$column[6][] = $List->TglSKTBN;
		$i++;
	}
?></td>
</tr>
</table>
	</form>	
    <span class="style9">Riwayat SK TBN</span>
<br />
<table width="1084">
	<tr>
	  <th width="8%">No.</th>
	  <th width="15%">Tingkat</th>
	  <th width="12%">Tmt TBN </th>
	  <th width="14%">Nilai </th>
	  <th width="13%">Tunjangan</th>
	  <th width="20%">Nomor SK </th>
	  <th width="18%">Tgl. SK </th>
	  </tr>
	<?php
	
	if ($nlist == 0) { ?>
		<tr>
			<td align="center" colspan="<?php echo $ncol ?>">Tidak Ada Data</td>
		</tr><?php
	}
	else {
		foreach ($column[0] as $k => $v) { 
			if ($v % 2 == 1) { ?>
				<tr bgcolor="#dedede">
					<td align="center"><?php echo $column[0][$k] ?></td>
					<td align="center"><?php echo 'TBN Tk.'. keromawi($column[1][$k]) ?></td>
					<td align="center"><?php echo reformat_tgl($column[2][$k]) ?></td>
					<td align="center"><?php echo $column[3][$k] ?></td>
					<td align="center"><?php echo number_format($column[4][$k],"0",",",".") ?></td>
					<td align="left"><?php echo $column[5][$k] ?></td>
			        <td align="center"><?php echo reformat_tgl($column[6][$k]) ?></td>
		        </tr><?php
			}
			else { ?>
				<tr bgcolor="#efefef">
					<td align="center"><?php echo $column[0][$k] ?></td>
					<td align="center"><?php echo 'TBN Tk.'. keromawi($column[1][$k]) ?></td>
					<td align="center"><?php echo reformat_tgl($column[2][$k]) ?></td>
					<td align="center"><?php echo $column[3][$k] ?></td>
					<td align="center"><?php echo number_format($column[4][$k],"0",",",".") ?></td>
					<td align="left"><?php echo $column[5][$k] ?></td>
			        <td align="center"><?php echo reformat_tgl($column[6][$k]) ?></td>
		        </tr><?php
			}
		}
	} ?>
</table>	
</div>
</div>

   <div id="JabFung">
 <script language="JavaScript">
  function removeAlignment_JabFung(){
	if(document.jabfung.jabfung_ed.value =="Ubah")
	{
		var read=document.getElementById("KdKelJabatan").removeAttribute("disabled",0);
		var read=document.getElementById("KdFungsional").removeAttribute("disabled",0);
		var read=document.getElementById("BidPenelitian").removeAttribute("disabled",0);
		var read=document.getElementById("KdJnsSKFung").removeAttribute("disabled",0);
		var read=document.getElementById("NoSKFungsional").removeAttribute("disabled",0);
		var read=document.getElementById("NilPAK").removeAttribute("disabled",0);
		var read=document.getElementById("NoSKPAK").removeAttribute("disabled",0);
		var read=document.getElementById("TunjFungsional").removeAttribute("disabled",0);
		var read=document.getElementById("NoSKTunjFung").removeAttribute("disabled",0);
		var read=document.getElementById("TMTFungsional").removeAttribute("disabled",0);
		var read=document.getElementById("TglSKFungsional").removeAttribute("disabled",0);
		var read=document.getElementById("TMTJnsSKFung").removeAttribute("disabled",0);
		var read=document.getElementById("TMTPAK").removeAttribute("disabled",0);
		var read=document.getElementById("TglSKPAK").removeAttribute("disabled",0);
		var read=document.getElementById("TMTTunjFungsional").removeAttribute("disabled",0);
		var read=document.getElementById("TglSKTunjFung").removeAttribute("disabled",0);
		var read=document.getElementById("simpan_8").removeAttribute("disabled",0);
		var read=document.jabfung.TMTFungsionalIMG.src="css/images/calbtn.gif";
		var read=document.jabfung.TglSKFungsionalIMG.src="css/images/calbtn.gif";
		var read=document.jabfung.TMTJnsSKFungIMG.src="css/images/calbtn.gif";
		var read=document.jabfung.TMTPAKIMG.src="css/images/calbtn.gif";
		var read=document.jabfung.TglSKPAKIMG.src="css/images/calbtn.gif";
		var read=document.jabfung.TMTTunjFungsionalIMG.src="css/images/calbtn.gif";
		var read=document.jabfung.TglSKTunjFungIMG.src="css/images/calbtn.gif";
	}
	else
	{
		document.getElementById("KdKelJabatan").disabled = true;
		document.getElementById("KdFungsional").disabled = true;
		document.getElementById("NoSKFungsional").disabled = true;
		document.getElementById("KdJnsSKFung").disabled = true;
		document.getElementById("NilPAK").disabled = true;
		document.getElementById("NoSKPAK").disabled = true;
		document.getElementById("TunjFungsional").disabled = true;
		document.getElementById("NoSKTunjFungsional").disabled = true;
		document.getElementById("BidPenelitian").disabled = true;
		document.getElementById("TMTFungsional").disabled = true;
		document.getElementById("TglSKFungsional").disabled = true;
		document.getElementById("TMTJnsSKFung").disabled = true;
		document.getElementById("TMTPAK").disabled = true;
		document.getElementById("TglSKPAK").disabled = true;
		document.getElementById("TMTTunjFungsional").disabled = true;
		document.getElementById("TglSKTunjFung").disabled = true;
		document.getElementById("simpan_8").disabled = true;	
	}
  }
</script> 
<?php	
	$kdunit = substr($_SESSION['xxkdunit'],0,2);
	$title = "Data Induk Pegawai";
	$table = "m_idpegawai";
	$pkey = "Nib";
	$field = array("KdKelJabatan","KdFungsional", "TMTFungsional", "KdJnsSKFung" , "TMTJnsSKFung" , "NoSKFungsional", "TglSKFungsional", "BidPenelitian", "KdJenisPAK","NilPAK", "TMTPAK" , "NoSKPAK" , "TglSKPAK", "TunjFungsional" , "TMTTunjFungsional" , "NoSKTunjFung" , "TglSKTunjFung");
	
	$bError	= false;
	
	if (!isset($id)) {
		$pagetitle = "Tambah ".$title;
	}
	else {
		$pagetitle = "Ubah ".$title;
	}
	
	if (isset($_POST["jabfung_edit"])) {	
		
		if ($bError != true) {
			if (!isset($_GET["id"])) {
				//ADD NEW
				$sql = "insert into ".$table." (";
				
				$i = 1;
				foreach ($field as $val) {
					$sql .= $val;
					if ($i < count($field)) $sql .= ", ";
					$i++;
				}
				
				$sql .= ") values (";
				
				$i = 1;
				foreach ($field as $val) {
					$sql .= "'".$$val."'";
					if ($i < count($field)) $sql .= ", ";
					$i++;
				}
				
				$sql .= ")";
				
				mysql_query($sql) or die(mysql_error());
			
				$_SESSION['errmsg'] = "Update data ".$title." berhasil!";
				echo "<meta http-equiv=\"refresh\" content=\"0;URL=index.php?p=dtinduk_ed&id=$id&sw=$sw\">";
				exit();
			} 
			else {
				// UPDATE				
				$sql = "update ".$table." set ";
				
				$i = 1;
				foreach ($field as $val) {
					$sql .= $val." = '".$$val."'";
					if ($i < count($field)) $sql .= ", ";
					$i++;
				}
				
				$sql .= " where ".$pkey." = '".$id."'";
				
				mysql_query($sql) or die(mysql_error());
				$_SESSION['errmsg'] = "Update data ".$title." berhasil!";
				echo "<meta http-equiv=\"refresh\" content=\"0;URL=index.php?p=dtinduk_ed&id=$id&sw=$sw\">";
				exit();
			}
		}
	} 
	else if (isset($_GET["id"])) {
		$oEdit = mysql_query("SELECT * FROM ".$table." WHERE ".$pkey." = '".$_GET["id"]."'") or die(mysql_error());
	
		if (mysql_num_rows($oEdit) == 0) {
			$bError		= true;
			$_SESSION['errmsg'] = "Invalid Request...!!";
		} 
		else {
			$Edit	= mysql_fetch_object($oEdit);
			
			foreach ($field as $val) {
				$$val = $Edit->$val;
			}
		}
	}
?>

<div id="forminduk">
	<form method="post" action="" name="jabfung">
		<table width="959">
			    
			<tr>
			  <td width="150" height="20">Jabatan</td>
			  <td width="797" height="20"><select name="KdKelJabatan" id="KdKelJabatan" disabled="true">
			  			<?php if(@$KdKelJabatan<>'') ?>
							  <option value="<?php echo @$KdKelJabatan ?>"><?php echo nmkeljabatan(@$KdKelJabatan) ?></option>	
					    <option value="">- Pilih Jenis Fungsional -</option><?php
							$query = mysql_query("select KdKel, left(NmKel,30) as nmkel from kd_keljabatan");
					
						while($row = mysql_fetch_array($query)) { ?>
						    <option value="<?php echo $row['KdKel']; ?>"><?php echo $row['nmkel']; ?></option><?php
						} ?>
			  </select>&nbsp;&nbsp;
<select name="KdFungsional" id="KdFungsional" disabled="true">
			  			<?php if(@$KdFungsional<>'') ?>
							  <option value="<?php echo @$KdFungsional ?>"><?php echo jenjang_fung(@$KdFungsional) ?></option>	
					    <option value="">- Pilih Jenjang -</option>
					    <option value="01">	01 Utama </option>
					    <option value="02"> 02 Madya </option>
					    <option value="03">	03 Muda </option>
					    <option value="04"> 04 Pertama </option>
					    <option value="05">	05 Penyelia </option>
					    <option value="06"> 06 Pelaksana Lanjutan </option>
					    <option value="07">	07 Pelaksana </option>
					    <option value="08"> 08 Pelaksana Pemula </option>
			  </select>&nbsp;&nbsp;			  Tmt&nbsp;&nbsp;<input name="TMTFungsional" type="text" class="form" id="TMTFungsional" size="10" value="<?php echo @$TMTFungsional ?>" disabled="true"/>
          &nbsp;<img src="" id="r_triggerIMG" hspace="5" title="Pilih Tanggal" name="TMTFungsionalIMG"/>
          <script type="text/javascript">
				Calendar.setup({
					inputField		: "TMTFungsional",
					button			: "r_triggerIMG",
					align			: "BR",
					firstDay		: 1,
					weekNumbers		: false,
					singleClick		: true,
					showOthers		: true,
					ifFormat 		: "%Y-%m-%d"
				});
			</script></td></tr>
			<tr>
			  <td height="20">Bidang Penelitian </td>
			  <td height="20"><input name="BidPenelitian" type="text" id="BidPenelitian" value="<?php echo @$BidPenelitian ?>" size="50" disabled="true"></td>
		  </tr>
			

			<tr>
			  <td height="20">Jenis SK Jabatan </td>
			  <td height="20"><select name="KdJnsSKFung" id="KdJnsSKFung" disabled="true">
			  			<?php if(@$KdJnsSKFung<>'') ?>
							  <option value="<?php echo @$KdJnsSKFung ?>"><?php echo nmstatusfung(@$KdJnsSKFung) ?></option>	
					    <option value="">- Pilih Jenis SK Fungsional -</option><?php
							$query = mysql_query("select * from kd_jenisskfung where kd_jenis_skfung<>''");
					
						while($row = mysql_fetch_array($query)) { ?>
						    <option value="<?php echo $row['kd_jenis_skfung']; ?>"><?php echo $row['nm_jenis_skfung']; ?></option><?php
						} ?>
			  </select>&nbsp;&nbsp;
Tmt&nbsp;&nbsp;<input name="TMTJnsSKFung" type="text" class="form" id="TMTJnsSKFung" size="10" value="<?php echo @$TMTJnsSKFung ?>" disabled="true"/>
          &nbsp;<img src="" id="s_triggerIMG" hspace="5" title="Pilih Tanggal" name="TMTJnsSKFungIMG"/>
          <script type="text/javascript">
				Calendar.setup({
					inputField		: "TMTJnsSKFung",
					button			: "s_triggerIMG",
					align			: "BR",
					firstDay		: 1,
					weekNumbers		: false,
					singleClick		: true,
					showOthers		: true,
					ifFormat 		: "%Y-%m-%d"
				});
			</script>			  </td></tr>
			<tr>
			  <td height="20">Nomor SK Jab </td>
			  <td height="20"><input name="NoSKFungsional" type="text" id="NoSKFungsional" value="<?php echo @$NoSKFungsional ?>" size="30" disabled="true">&nbsp;&nbsp;Tanggal&nbsp;&nbsp;<input name="TglSKFungsional" type="text" class="form" id="TglSKFungsional" size="10" value="<?php echo @$TglSKFungsional ?>" disabled="true"/>
  &nbsp;<img src="" id="t_triggerIMG" hspace="5" title="Pilih Tanggal" name="TglSKFungsionalIMG"/>
  <script type="text/javascript">
				Calendar.setup({
					inputField		: "TglSKFungsional",
					button			: "t_triggerIMG",
					align			: "BR",
					firstDay		: 1,
					weekNumbers		: false,
					singleClick		: true,
					showOthers		: true,
					ifFormat 		: "%Y-%m-%d"
				});
			</script></td>
		  </tr>
			<tr>
			  <td height="20">PAK</td>
			  <td height="20"><input name="NilPAK" type="text" id="NilPAK" value="<?php echo @$NilPAK ?>" size="10" disabled="true">&nbsp;&nbsp;Tmt&nbsp;&nbsp;<input name="TMTPAK" type="text" class="form" id="TMTPAK" size="10" value="<?php echo @$TMTPAK ?>" disabled="true"/>
  &nbsp;<img src="" id="u_triggerIMG" hspace="5" title="Pilih Tanggal" name="TMTPAKIMG"/>
  <script type="text/javascript">
				Calendar.setup({
					inputField		: "TMTPAK",
					button			: "u_triggerIMG",
					align			: "BR",
					firstDay		: 1,
					weekNumbers		: false,
					singleClick		: true,
					showOthers		: true,
					ifFormat 		: "%Y-%m-%d"
				});
			</script></td>
		  </tr>
			<tr>
			  <td height="20">Nomor SK PAK </td>
			  <td height="20"><input name="NoSKPAK" type="text" id="NoSKPAK" value="<?php echo @$NoSKPAK ?>" size="30" disabled="true">&nbsp;&nbsp;Tanggal&nbsp;&nbsp;<input name="TglSKPAK" type="text" class="form" id="TglSKPAK" size="10" value="<?php echo @$TglSKPAK ?>" disabled="true"/>
  &nbsp;<img src="" id="v_triggerIMG" hspace="5" title="Pilih Tanggal" name="TglSKPAKIMG"/>
  <script type="text/javascript">
				Calendar.setup({
					inputField		: "TglSKPAK",
					button			: "v_triggerIMG",
					align			: "BR",
					firstDay		: 1,
					weekNumbers		: false,
					singleClick		: true,
					showOthers		: true,
					ifFormat 		: "%Y-%m-%d"
				});
			</script></td>
		  </tr>
			<tr>
			  <td height="20">Tunjangan</td>
			  <td height="20"><input name="TunjFungsional" type="text" id="TunjFungsional" value="<?php echo @$TunjFungsional ?>" size="20" disabled="true">&nbsp;&nbsp;Tmt&nbsp;&nbsp;<input name="TMTTunjFungsional" type="text" class="form" id="TMTTunjFungsional" size="10" value="<?php echo @$TMTTunjFungsional ?>" disabled="true"/>
  &nbsp;<img src="" id="x_triggerIMG" hspace="5" title="Pilih Tanggal" name="TMTTunjFungsionalIMG"/>
  <script type="text/javascript">
				Calendar.setup({
					inputField		: "TMTTunjFungsional",
					button			: "x_triggerIMG",
					align			: "BR",
					firstDay		: 1,
					weekNumbers		: false,
					singleClick		: true,
					showOthers		: true,
					ifFormat 		: "%Y-%m-%d"
				});
			</script></td>
		  </tr>
			<tr>
			  <td height="20">Nomor SK Tunj. </td>
			  <td height="20"><input name="NoSKTunjFung" type="text" id="NoSKTunjFung" value="<?php echo @$NoSKTunjFung ?>" size="30" disabled="true">&nbsp;&nbsp;Tanggal&nbsp;&nbsp;<input name="TglSKTunjFung" type="text" class="form" id="TglSKTunjFung" size="10" value="<?php echo @$TglSKTunjFung ?>" disabled="true"/>
  &nbsp;<img src="" id="y_triggerIMG" hspace="5" title="Pilih Tanggal" name="TglSKTunjFungIMG"/>
  <script type="text/javascript">
				Calendar.setup({
					inputField		: "TglSKTunjFung",
					button			: "y_triggerIMG",
					align			: "BR",
					firstDay		: 1,
					weekNumbers		: false,
					singleClick		: true,
					showOthers		: true,
					ifFormat 		: "%Y-%m-%d"
				});
			</script></td>
		  </tr>
			
			<tr>
			  <td height="20" colspan="2"><input name="jabfung_ed" type="button" id="x" value="Ubah" onclick="removeAlignment_JabFung()">
			  	  <input name="jabfung_edit" type="submit" id="simpan_8" value="Simpan" disabled="disabled">
				<input name="cancel" type="button" id="x" value="Keluar" onClick="Cancel('index.php?p=dtinduk_list&sw= <?php echo $sw ?>&cari=<?php echo $cari ?>')"></td>
		  </tr>
			<tr>
			  <td height="21">&nbsp;</td>
			  <td height="21"></td>
		  </tr>
			<tr>
				<td colspan="2">				</td>
			</tr>
			<tr>
			  <td colspan="2">
<?php //-------------------- Tabel Riwayat			  
	$table = "m_riwjabfung";
	$id1 = "NIB";
	$id2 = "TglSK";
	$orderby = "NilPAK,TglSK";
	$addlink = "index.php?p=dtinduk_ed";
	$addtext = "Tambah Data";
	$ncol = count($header)+2;
	unset($column);
			
	if (!isset($cari)) $cari = "";
	$nRecord = 15;
	$Interval = 50;
	if (!isset($pg)) $pg = 1;
	$Limit = ($pg - 1) * $nRecord;
		
	$sql = "SELECT * from $table WHERE NIB='$id'";
	$oList	= mysql_query($sql) or die(mysql_error());
	$nlist = mysql_num_rows($oList);
	
	$paging = Paging($nRecord, $Interval, $nlist, $pg);
	$i	= $Limit + 1;
	$oList	= mysql_query($sql." ORDER BY $orderby"); 
	while($List = mysql_fetch_object($oList)) {
		$column[0][] = $i;
		$column[1][] = $List->NmJabFung;
		$column[2][] = nmgol($List->KdGol);
		$column[3][] = $List->TMTJabFung;
		$column[4][] = $List->NilPAK;
		$column[5][] = nmstatusfung($List->KdJnsSKFung);
		$column[6][] = $List->TMTJnsSKFung;
		$column[7][] = $List->NoSK;
		$column[8][] = $List->TglSK;
		$column[9][] = $List->Ket;
		$editlink[] = $addlink."&sw=1"."&id=".$id."&id1=".$List->$id1."&id2=".$List->$id2."#JabFung";
		$deletelink[] = "index.php?p=dtinduk_del&id=".$List->$id;
		$i++;
	}
?></td>
</tr>
</table>
	</form>	

    <span class="style9">Riwayat Jabatan Fungsional </span>
<br />
<table width="1169">
	<tr>
	  <th width="4%" rowspan="2">No.</th>
	  <th width="16%" rowspan="2">Jabatan</th>
	  <th width="5%" rowspan="2">Tmt</th>
	  <th width="4%" rowspan="2">Gol.</th>
	  <th width="4%" rowspan="2">PAK</th>
	  <th colspan="4">SK</th>
	  <th width="18%" rowspan="2">Keterangan</th>
	  </tr>
	<tr>
	  <th width="18%">Jenis SK </th>
	  <th width="9%">Tmt</th>
	  <th width="11%">Nomor</th>
	  <th width="11%">Tanggal</th>
	  </tr>
	<?php
	
	if ($nlist == 0) { ?>
		<tr>
			<td align="center" colspan="<?php echo $ncol ?>">Tidak Ada Data</td>
		</tr><?php
	}
	else {
		foreach ($column[0] as $k => $v) { 
			if ($v % 2 == 1) { ?>
				<tr bgcolor="#dedede">
					<td align="center"><?php echo $column[0][$k] ?></td>
					<td align="left"><?php echo $column[1][$k] ?></td>
					<td align="center"><?php echo reformat_tgl($column[3][$k]) ?></td>
					<td align="center"><?php echo $column[2][$k] ?></td>
					<td align="center"><?php echo number_format($column[4][$k],"3",",",".") ?></td>
					<td align="left"><?php echo $column[5][$k] ?></td>
					<td align="center"><?php echo reformat_tgl($column[6][$k]) ?></td>
					<td align="left"><?php echo $column[7][$k] ?></td>
					<td align="center"><?php echo reformat_tgl($column[8][$k]) ?></td>
					<td align="left"><?php echo $column[9][$k] ?></td>
			    </tr><?php
			}
			else { ?>
				<tr bgcolor="#efefef">
					<td align="center"><?php echo $column[0][$k] ?></td>
					<td align="left"><?php echo $column[1][$k] ?></td>
					<td align="center"><?php echo reformat_tgl($column[3][$k]) ?></td>
					<td align="center"><?php echo $column[2][$k] ?></td>
					<td align="center"><?php echo number_format($column[4][$k],"3",",",".") ?></td>
					<td align="left"><?php echo $column[5][$k] ?></td>
					<td align="center"><?php echo reformat_tgl($column[6][$k]) ?></td>
					<td align="left"><?php echo $column[7][$k] ?></td>
					<td align="center"><?php echo reformat_tgl($column[8][$k]) ?></td>
					<td align="left"><?php echo $column[9][$k] ?></td>
			    </tr><?php
			}
		}
	} ?>
</table>	
</div>
</div>

   <div id="Keluarga">
 <script language="JavaScript">
  function removeAlignment_Keluarga(){
	if(document.keluarga.keluarga_ed.value =="Ubah")
	{
		var read=document.getElementById("NmPas").removeAttribute("disabled",0);
		var read=document.getElementById("NoKarsuKaris").removeAttribute("disabled",0);
		var read=document.getElementById("TmpLahirPas").removeAttribute("disabled",0);
		var read=document.getElementById("TglLahirPas").removeAttribute("disabled",0);
		var read=document.getElementById("KerjaPas").removeAttribute("disabled",0);
		var read=document.getElementById("PasanganKe").removeAttribute("disabled",0);
		var read=document.getElementById("TglNikah").removeAttribute("disabled",0);
		var read=document.getElementById("simpan_7").removeAttribute("disabled",0);
		var read=document.keluarga.TglLahirPasIMG.src="css/images/calbtn.gif";
		var read=document.keluarga.TglNikahIMG.src="css/images/calbtn.gif";
	}
	else
	{
		document.getElementById("NmPas").disabled = true;
		document.getElementById("NoKarsuKaris").disabled = true;
		document.getElementById("TmpLahirPas").disabled = true;
		document.getElementById("TglLahirPas").disabled = true;
		document.getElementById("KerjaPas").disabled = true;
		document.getElementById("PasanganKe").disabled = true;
		document.getElementById("TglNikah").disabled = true;
		document.getElementById("simpan_7").disabled = true;
	}
  }
</script> 
<?php	
	$kdunit = substr($_SESSION['xxkdunit'],0,2);
	$title = "Keluarga";
	$table = "m_idpegawai";
	$pkey = "Nib";
	$field = array("KdStatusNikah","PasanganKe");
	
	$bError	= false;
	
	if (!isset($id)) {
		$pagetitle = "Tambah ".$title;
	}
	else {
		$pagetitle = "Ubah ".$title;
	}
	
	if (isset($_POST["keluarga_edit"])) {	
		
		if ($bError != true) {
			if (!isset($_GET["id"])) {
				//ADD NEW
				$sql = "insert into ".$table." (";
				
				$i = 1;
				foreach ($field as $val) {
					$sql .= $val;
					if ($i < count($field)) $sql .= ", ";
					$i++;
				}
				
				$sql .= ") values (";
				
				$i = 1;
				foreach ($field as $val) {
					$sql .= "'".$$val."'";
					if ($i < count($field)) $sql .= ", ";
					$i++;
				}
				
				$sql .= ")";
				
				mysql_query($sql) or die(mysql_error());
			
				$_SESSION['errmsg'] = "Update data ".$title." berhasil!";
				echo "<meta http-equiv=\"refresh\" content=\"0;URL=index.php?p=dtinduk_ed&id=$id&sw=$sw\">";
				exit();
			} 
			else {
				// UPDATE				
				$sql = "update ".$table." set ";
				
				$i = 1;
				foreach ($field as $val) {
					$sql .= $val." = '".$$val."'";
					if ($i < count($field)) $sql .= ", ";
					$i++;
				}
				
				$sql .= " where ".$pkey." = '".$id."'";
				
				mysql_query($sql) or die(mysql_error());
//----- update riwayat
	$pasanganke  = $_REQUEST['PasanganKe'];
	$nmpas	 = $_REQUEST['NmPas'];
	$tmplahirpas = $_REQUEST['TmpLahirPas'] ;
	$tgllahirpas = $_REQUEST['TglLahirPas'] ;
	$pekerjaan = $_REQUEST['KerjaPas'] ;
	$tglnikah  = $_REQUEST['TglNikah'];
	$nokarsukaris  = $_REQUEST['NoKarsuKaris'];
	$oEdit_riw = mysql_query("SELECT * FROM m_riwpernikahan WHERE NIB='$id' and PasanganKe='$pasanganke'") or die(mysql_error());
	$vEdit_riw = mysql_fetch_array($oEdit_riw);
	if(!empty($vEdit_riw)){
		mysql_query("UPDATE m_riwpernikahan SET NmPas='$nmpas',TempatLahir='$tmplahirpas', TglLahir='$tgllahirpas', Pekerjaan='$pekerjaan', TglNikah='$tglnikah', NoKarsuKaris='$nokarsukaris' WHERE NIB='$id' and PasanganKe='$pasanganke'");
	}else{
		mysql_query("INSERT INTO m_riwpernikahan(NIB, PasanganKe, NmPas, TempatLahir, TglLahir, Pekerjaan, TglNikah,NoKarsuKaris ) VALUES('$id', '$pasanganke', '$nmpas', '$tmplahirpas', '$tgllahirpas', '$pekerjaan', '$tglnikah', '$nokarsukaris')");
	}
//--------------------------------				
				$_SESSION['errmsg'] = "Update data ".$title." berhasil!";
				echo "<meta http-equiv=\"refresh\" content=\"0;URL=index.php?p=dtinduk_ed&id=$id&sw=$sw\">";
				exit();
			}
		}
	} 
	else if (isset($_GET["id"])) {
		$oEdit = mysql_query("SELECT * FROM ".$table." WHERE ".$pkey." = '".$_GET["id"]."'") or die(mysql_error());
	
		if (mysql_num_rows($oEdit) == 0) {
			$bError		= true;
			$_SESSION['errmsg'] = "Invalid Request...!!";
		} 
		else {
			$Edit	= mysql_fetch_object($oEdit);
			
			foreach ($field as $val) {
				$$val = $Edit->$val;
			}
		}
	}
?>

<div id="forminduk">
	<form method="post" action="" name="keluarga">
		<table width="959">
			    
			<tr>
			  <td width="181" height="20">Status</td>
			  <td width="766" height="20"><?php echo nmstatusnikah(@$KdStatusNikah) ?></td></tr>
			<tr>
<?php if(@$KdStatusNikah=='2'){ ?>			
			  <td height="20">Nama Pasangan </td>
			  <td height="20"><input name="NmPas" type="text" id="NmPas" value="<?php echo nmpasangan_rwpeg($id,@$PasanganKe) ?>" size="50" disabled="true"></td>
		  </tr>
			<tr>
			  <td height="20">Nomor Karsu/Karis</td>
			  <td height="20"><input name="NoKarsuKaris" type="text" id="NoKarsuKaris" value="<?php echo nokarsukaris_rwpeg($id,@$PasanganKe) ?>" size="20" disabled="true"></td>
		  </tr>
			<tr>
			  <td height="20">Lahir</td>
			  <td height="20"><input name="TmpLahirPas" type="text" id="TmpLahirPas" value="<?php echo tmplhrpas_rwpeg($id,@$PasanganKe) ?>" size="30" disabled="true">&nbsp;&nbsp;Tanggal&nbsp;&nbsp;<input name="TglLahirPas" type="text" class="form" id="TglLahirPas" size="10" value="<?php echo tgllhrpas_rwpeg($id,@$PasanganKe) ?>" disabled="true"/>
          &nbsp;<img src="" id="p_triggerIMG" hspace="5" title="Pilih Tanggal" name="TglLahirPasIMG"/>
          <script type="text/javascript">
				Calendar.setup({
					inputField		: "TglLahirPas",
					button			: "p_triggerIMG",
					align			: "BR",
					firstDay		: 1,
					weekNumbers		: false,
					singleClick		: true,
					showOthers		: true,
					ifFormat 		: "%Y-%m-%d"
				});
			</script></td>
		  </tr>
			<tr>
			  <td height="20">Pekerjaan</td>
			  <td height="20"><input name="KerjaPas" type="text" id="KerjaPas" value="<?php echo kerjapas_rwpeg($id,@$PasanganKe) ?>" size="40" disabled="true"></td>
		  </tr>
			<tr>
			  <td> Perkawinan Ke </td>
			  <td><input name="PasanganKe" type="text" id="PasanganKe" value="<?php echo @$PasanganKe ?>" size="5" disabled="true">&nbsp;&nbsp;Tanggal Perkawinan&nbsp;&nbsp;<input name="TglNikah" type="text" class="form" id="TglNikah" size="10" value="<?php echo tglnikah_rwpeg($id,@$PasanganKe) ?>" disabled="true"/>
          &nbsp;<img src="" id="q_triggerIMG" hspace="5" title="Pilih Tanggal" name="TglNikahIMG" />
          <script type="text/javascript">
				Calendar.setup({
					inputField		: "TglNikah",
					button			: "q_triggerIMG",
					align			: "BR",
					firstDay		: 1,
					weekNumbers		: false,
					singleClick		: true,
					showOthers		: true,
					ifFormat 		: "%Y-%m-%d"
				});
			</script></td>
<?php } ?>			
		  </tr>
			
			<tr>
			  <td height="20" colspan="2"><input name="keluarga_ed" type="button" id="x" value="Ubah" onclick="removeAlignment_Keluarga()">
										  <input name="keluarga_edit" type="submit" id="simpan_7" value="Simpan" disabled="true">
										  <input name="cancel" type="button" id="x" value="Keluar" onClick="Cancel('index.php?p=dtinduk_list&sw= <?php echo $sw ?>&cari=<?php echo $cari ?>')"></td>
		  </tr>
			<tr>
			  <td height="21">&nbsp;</td>
			  <td height="21"></td>
		  </tr>
			<tr>
				<td colspan="2">				</td>
			</tr>
			<tr>
			  <td colspan="2">
<?php //-------------------- Tabel Riwayat			  
	$table = "m_riwpernikahan";
	$orderby = "PasanganKe";
	$ncol = count($header)+2;
	unset($column);
			
	if (!isset($cari)) $cari = "";
	$nRecord = 15;
	$Interval = 50;
	if (!isset($pg)) $pg = 1;
	$Limit = ($pg - 1) * $nRecord;
		
	$sql = "SELECT * from $table WHERE NIB='$id'";
	$oList	= mysql_query($sql) or die(mysql_error());
	$nlist = mysql_num_rows($oList);
	
	$paging = Paging($nRecord, $Interval, $nlist, $pg);
	$i	= $Limit + 1;
	$oList	= mysql_query($sql." ORDER BY $orderby"); 
	while($List = mysql_fetch_object($oList)) {
		$column[0][] = $i;
		$column[1][] = $List->NmPas;
		$column[2][] = $List->TempatLahir;
		$column[3][] = $List->TglLahir;
		$column[4][] = $List->NoKarsuKaris;
		$column[5][] = $List->TglNikah;
		$column[6][] = $List->Pekerjaan;
		$column[7][] = $List->PasanganKe;
		$i++;
	}
?></td>
</tr>
</table>
</form>	

<span class="style9">Nama Pasangan</span>
<br />
<table width="882">
	<tr>
	  <th width="6%">No.</th>
	  <th width="27%">Nama</th>
	  <th width="11%">Lahir</th>
	  <th width="11%">Karis/Karsu</th>
	  <th width="17%">Pekerjaan</th>
	  <th width="17%">Tgl. Nikah </th>
	  <th width="14%">Pasangan Ke</th>
	  </tr>
	<?php
	
	if ($nlist == 0) { ?>
		<tr>
			<td align="center" colspan="<?php echo $ncol ?>">Tidak Ada Data</td>
		</tr><?php
	}
	else {
		foreach ($column[0] as $k => $v) { 
			if ($v % 2 == 1) { ?>
				<tr bgcolor="#dedede">
					<td align="center"><?php echo $column[0][$k] ?></td>
					<td align="left"><?php echo $column[1][$k] ?></td>
					<td align="center"><?php echo $column[2][$k] ?><br /><?php echo reformat_tgl($column[3][$k]) ?></td>
					<td align="center"><?php echo $column[4][$k] ?></td>
					<td align="center"><?php echo $column[6][$k] ?></td>
					<td align="center"><?php echo reformat_tgl($column[5][$k]) ?></td>
					<td align="center"><?php echo $column[7][$k] ?></td>
			    </tr><?php
			}
			else { ?>
				<tr bgcolor="#efefef">
					<td align="center"><?php echo $column[0][$k] ?></td>
					<td align="left"><?php echo $column[1][$k] ?></td>
					<td align="center"><?php echo $column[2][$k] ?><br /><?php echo reformat_tgl($column[3][$k]) ?></td>
					<td align="center"><?php echo $column[4][$k] ?></td>
					<td align="center"><?php echo $column[6][$k] ?></td>
					<td align="center"><?php echo reformat_tgl($column[5][$k]) ?></td>
					<td align="center"><?php echo $column[7][$k] ?></td>
			    </tr><?php
			}
		}
	} ?>
</table>	

<?php //-------------------- Tabel Riwayat			  
	$table = "m_anak";
	$orderby = "TglLahir";
	$ncol = count($header)+2;
	unset($column);
			
	if (!isset($cari)) $cari = "";
	$nRecord = 15;
	$Interval = 50;
	if (!isset($pg)) $pg = 1;
	$Limit = ($pg - 1) * $nRecord;
		
	$sql = "SELECT * from $table WHERE NIB='$id'";
	$oList	= mysql_query($sql) or die(mysql_error());
	$nlist = mysql_num_rows($oList);
	
	$paging = Paging($nRecord, $Interval, $nlist, $pg);
	$i	= $Limit + 1;
	$oList	= mysql_query($sql." ORDER BY $orderby"); 
	while($List = mysql_fetch_object($oList)) {
		$column[0][] = $i;
		$column[1][] = $List->NmAnak;
		$column[2][] = $List->Sex;
		$column[3][] = $List->TglLahir;
		$column[4][] = $List->TmpLahir;
		$column[5][] = $List->Pekerjaa;
		$column[6][] = $List->NoAkte;
		$column[7][] = $List->KdStatusAnak;
		$column[8][] = $List->KP4;
		$column[8][] = $List->AnakKe;
		$i++;
	}
?></td>
</tr>
</table>
</form>	
    <span class="style9"><br />Nama Anak</span>
<br />
<table width="882">
	<tr>
	  <th width="6%">No.</th>
	  <th width="27%">Nama</th>
	  <th width="8%">Jenis<br />
	    Kelamin</th>
	  <th width="11%">Lahir</th>
	  <th width="17%">Nomor Akte<br />Pekerjaan</th>
	  <th width="17%">Status<br />Masuk KP4</th>
	  <th width="14%">Anak Ke</th>
	  </tr>
	<?php
	
	if ($nlist == 0) { ?>
		<tr>
			<td align="center" colspan="<?php echo $ncol ?>">Tidak Ada Data</td>
		</tr><?php
	}
	else {
		foreach ($column[0] as $k => $v) { 
			if ($v % 2 == 1) { ?>
				<tr bgcolor="#dedede">
					<td align="center"><?php echo $column[0][$k] ?></td>
					<td align="left"><?php echo $column[1][$k] ?></td>
					<td align="center"><?php echo $column[2][$k] ?></td>
					<td align="center"><?php echo $column[4][$k] ?><br /><?php echo reformat_tgl($column[3][$k]) ?></td>
					<td align="center"><?php echo $column[6][$k] ?><br /><?php echo $column[5][$k] ?></td>
					<td align="center"><?php echo $column[7][$k] ?><br /><?php if($column[8][$k]=='1'){?><?php echo 'Ya' ?><?php }else{ ?><?php echo 'Tidak' ?><?php } ?></td>
					<td align="center"><?php echo $column[9][$k] ?></td>
			    </tr><?php
			}
			else { ?>
				<tr bgcolor="#efefef">
					<td align="center"><?php echo $column[0][$k] ?></td>
					<td align="left"><?php echo $column[1][$k] ?></td>
					<td align="center"><?php echo $column[2][$k] ?></td>
					<td align="center"><?php echo $column[4][$k] ?><br /><?php echo reformat_tgl($column[3][$k]) ?></td>
					<td align="center"><?php echo $column[6][$k] ?><br /><?php echo $column[5][$k] ?></td>
					<td align="center"><?php echo $column[7][$k] ?><br /><?php echo $column[8][$k] ?></td>
					<td align="center"><?php echo $column[9][$k] ?></td>
			    </tr><?php
			}
		}
	} ?>
</table>	
</div>
</div>

</div>
</body>
</html>
