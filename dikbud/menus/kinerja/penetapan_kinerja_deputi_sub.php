<?php
	checkauthentication();
	$table = "th_pk_sub";
	$err = false;
	$p = $_GET['p'];
	$q = $_GET['q'];
	$id = $_REQUEST['id'];
	$xkdunit = $_REQUEST['xkdunit'];
	extract($_POST);
	$xusername_sess = $_SESSION['xusername'];
	$th = $_SESSION['xth'];
	$renstra = th_renstra($th);
	if ( $q == '' )   $simpan = 'Tambah' ;
	else    $simpan = 'Simpan' ;
	$sw = $_REQUEST['sw'];
	
	$oPK = mysql_query("SELECT * FROM th_pk WHERE  id = '$id' ");
	$PK = mysql_fetch_array($oPK);

	$xmenu_p = xmenu_id($p);
	$p_next = $xmenu_p->parent;
	
	if (isset($form)) 
	{		
		if ($err != true) 
		{	
			if ($q == "") 
			{
				//ADD NEW
				$no_pk_sub = $_REQUEST['no_pk_sub'];
				$nm_pk_sub = $_REQUEST['nm_pk_sub'];
				$target = $_REQUEST['target'];
				$sql = "INSERT INTO $table (id,th,kdunitkerja,no_pk,no_pk_sub,nm_pk_sub,target) VALUE
				 ('','$th','$xkdunit','$PK[no_pk]','$no_pk_sub','$nm_pk_sub','$target')";
				$rs = mysql_query($sql);
				
				if ($rs) 
				{
					update_log($sql,$table,1);
					$_SESSION['errmsg'] = "Input data berhasil!";
				}
				else 
				{
					update_log($sql,$table,0);
					$_SESSION['errmsg'] = "Input data gagal!";
				} ?>
				
				<meta http-equiv="refresh" content="0;URL=index.php?p=349&id=<?php echo $id ?>&xkdunit=<?php echo $xkdunit ?>"><?php
				exit();
			} 
			else {
				// UPDATE
				$no_pk_sub = $_REQUEST['no_pk_sub'];
				$nm_pk_sub = $_REQUEST['nm_pk_sub'];
				$target = $_REQUEST['target'];
				$sql = "UPDATE $table SET no_pk_sub = '$no_pk_sub', nm_pk_sub = '$nm_pk_sub', target = '$target'
					    WHERE id = '$q'";
				$rs = mysql_query($sql);
				
				if ($rs) 
				{	
					update_log($sql,$table,1);
					$_SESSION['errmsg'] = "Ubah data berhasil!";
				}
				else 
				{
					update_log($sql,$table,0);
					$_SESSION['errmsg'] = "Ubah data gagal!";			
				} 
				
				if ( $sw == '' ) {
				?>
				<meta http-equiv="refresh" content="0;URL=index.php?p=349&id=<?php echo $id ?>&xkdunit=<?php echo $xkdunit ?>"><?php
				exit();
				}else{ ?>
				<meta http-equiv="refresh" content="0;URL=index.php?p=337&xkdunit=<?php echo $xkdunit ?>"><?php
				exit();
				}
			}
		}
		else 
		{ ?>
			<meta http-equiv="refresh" content="0;URL=index.php?p=349&id=<?php echo $id ?>&xkdunit=<?php echo $xkdunit ?>"><?php		
		}
	}
	else if (isset($_GET["q"])) 
	{
		$sql = "SELECT * FROM $table WHERE id = '".$_GET['q']."'";
		$aFungsi = mysql_query($sql);
		$value = mysql_fetch_array($aFungsi);
	}
	else {
		$value = array();
	} ?>

<form action="index.php?p=349&id=<?php echo $id ?>&xkdunit=<?php echo $xkdunit ?>&sw=<?php echo $sw ?>" method="post" name="form">
	
  <table cellspacing="1" class="admintable">
    <tr> 
      <td width="109" class="key">Tahun</td>
      <td width="204"><input type="text" name="th" size="15" value="<?php echo $PK['th'] ?>" disabled="disabled"/></td>
      <td width="232" align="right"></td>
    </tr>
    <tr>
      <td class="key">Eselon I</td>
      <td colspan="2"><textarea name="nm_unit" cols="70" rows="2" disabled="disabled"><?php echo nm_unit($xkdunit) ?></textarea></td>
    </tr>
    <tr>
      <td class="key">Sasaran</td>
      <td colspan="2"><textarea name="nm_sasaran" cols="70" rows="2" disabled="disabled"><?php echo nm_sasaran($renstra,$xkdunit,$PK['no_sasaran']) ?></textarea></td>
    </tr>
    
    <tr> 
      <td class="key">Kinerja</td>
      <td colspan="2"><textarea name="nm_pk" cols="70" rows="2" disabled="disabled"><?php echo $PK['nm_pk'] ?></textarea></td>
    </tr>
    <tr>
      <td colspan="3" align="center"><strong>Sub Kinerja</strong></td>
    </tr>
    <tr> 
      <td class="key">No.urut</td>
      <td colspan="2"><input type="text" name="no_pk_sub" size="5" value="<?php echo @$value['no_pk_sub'] ?>"/>&nbsp;&nbsp;<font color="#FF66CC">[isi : 1,2,3,...dst sesuai urutan yang diinginkan]</font></td>
    </tr>
    <tr> 
      <td class="key">Sub Kinerja </td>
      <td colspan="2"><textarea name="nm_pk_sub" cols="70" rows="2" ><?php echo @$value['nm_pk_sub'] ?></textarea></td>
    </tr>
    <tr>
      <td class="key">Target</td>
      <td colspan="2"><input type="text" name="target" size="50" value="<?php echo @$value['target'] ?>"/></td>
    </tr>
    
    <tr> 
      <td>&nbsp;</td>
      <td colspan="2">
        <input name="form" type="hidden" value="1" /> <input name="q" type="hidden" value="<?php echo $_GET['q'] ?>" /> 
		<input type="button" onclick="Back('index.php?p=337&xkdunit=<?php echo $xkdunit ?>')" value="Kembali" />
        <input value="<?php echo $simpan ?>" type="submit">      </td>
    </tr>
  </table>
</form>
<br />
<?php if ( $sw == '' ) { ?>
<table width="557" cellpadding="1" class="adminlist">
  <thead>
    <tr> 
      <th 		
width="5%" height="61">No.</th>
      <th width="63%">Sub Kinerja </th>
      <th width="22%">Target</th>
      <th colspan="2">Aksi</th>
    </tr>
  </thead>
  <tbody>
<?php
	$sql = "SELECT * FROM $table WHERE th = '$th' AND kdunitkerja = '$xkdunit' and no_pk = '$PK[no_pk]' ORDER BY no_pk_sub";
	$aSubPK = mysql_query($sql);
	$count = mysql_num_rows($aSubPK);

	while ($SubPK = mysql_fetch_array($aSubPK))
	{
?>
    <tr class="<?php echo $class ?>"> 
      <td align="center"><?php echo $SubPK['no_pk_sub'] ?></td>
      <td align="left"><?php echo $SubPK['nm_pk_sub'] ?></td>
      <td align="center"><?php echo $SubPK['target'] ?></td>
      <td width="4%" align="center"> <a href="index.php?p=349&id=<?php echo $id ?>&q=<?php echo $SubPK['id'] ?>&xkdunit=<?php echo $xkdunit ?>" title="Edit"> 
        <img src="css/images/edit_f2.png" border="0" width="16" height="16"> </a>      </td>
      <td width="6%" align="center"><a href="index.php?p=350&id=<?php echo $id ?>&q=<?php echo $SubPK['id'] ?>&xkdunit=<?php echo $xkdunit ?>" title="Delete"> 
        <img src="css/images/stop_f2.png" border="0" width="16" height="16"> </a>      </td>
    </tr>
    <?php
		} ?>
  </tbody>
  <tfoot>
  </tfoot>
</table>
<?php }?>