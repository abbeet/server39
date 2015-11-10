<?php
	checkauthentication();
	$table = "dt_pk";
	$err = false;
	$p = $_GET['p'];
	$q = $_GET['q'];
	$kdtriwulan = $_REQUEST['kdtriwulan'];
	extract($_POST);
	$xusername_sess = $_SESSION['xusername'];
	$th = $_SESSION['xth'];

	$oPK = mysql_query("SELECT * FROM dt_pk WHERE  id = '$q' ");
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
				
				<meta http-equiv="refresh" content="0;URL=index.php?p=540&id_pk=<?php echo $id_pk ?>&kdunit=<?php echo $kdunit ?>"><?php
				exit();
			} 
			else {
				// UPDATE
				switch ( $kdtriwulan )
				{
				     case '1':
				$sql = "UPDATE $table SET realisasi_1 = '', hasil_1 = ''
					    WHERE id = '$q'";
					  break;
				     case '2':
				$sql = "UPDATE $table SET realisasi_2 = '', hasil_2 = ''
					    WHERE id = '$q'";
					  break;
				     case '3':
				$sql = "UPDATE $table SET realisasi_3 = '', hasil_3 = ''
					    WHERE id = '$q'";
					  break;
				     case '4':
				$sql = "UPDATE $table SET realisasi_4 = '', hasil_4 = ''
					    WHERE id = '$q'";
					  break;
				}	  
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
				} ?>
				
				<meta http-equiv="refresh" content="0;URL=index.php?p=540&kdtriwulan=<?php echo $kdtriwulan ?>"><?php
				exit();
			}
		}
		else 
		{ ?>
			<meta http-equiv="refresh" content="0;URL=index.php?p=540&kdtriwulan=<?php echo $kdtriwulan ?>"><?php		
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

<form action="" method="post" name="form">
	
  <table cellspacing="1" class="admintable">
    
    
    <tr> 
      <td width="109" class="key">Indikator Kinerja </td>
      <td><textarea name="nm_iku" cols="70" rows="3" readonly><?php echo $PK['indikator'] ?></textarea></td>
    </tr>

<?php 
switch ( $kdtriwulan )
{
    case '1':
?>   
    <tr>
      <td colspan="2" align="center"><strong>Capaian Kinerja Triwulan I </strong></td>
    </tr>
    <tr> 
      <td class="key">Realisasi  </td>
      <td><input type="text" name="realisasi_1" size="5" value="<?php echo @$value['realisasi_1'] ?>" readonly/>&nbsp;&nbsp;%</td>
    </tr>
    <tr> 
      <td class="key">Hasil </td>
      <td><textarea name="hasil_1" cols="70" rows="3" readonly><?php echo @$value['hasil_1'] ?></textarea></td>
    </tr>
 <?php 
	break;
	
	case '2':
 ?>  
    
    <tr>
      <td colspan="2" align="center"><strong>Capaian Kinerja Triwulan II </strong></td>
    </tr>
    <tr> 
      <td class="key">Realisasi  </td>
      <td><input type="text" name="realisasi_2" size="5" value="<?php echo @$value['realisasi_2'] ?>" readonly/>&nbsp;&nbsp;%</td>
    </tr>
    <tr> 
      <td class="key">Hasil </td>
      <td><textarea name="hasil_2" cols="70" rows="3" readonly><?php echo @$value['hasil_2'] ?></textarea></td>
    </tr>
 <?php 
	break;
	
	case '3':
 ?>  
    <tr>
      <td colspan="2" align="center"><strong>Capaian Kinerja Triwulan III </strong></td>
    </tr>
    <tr> 
      <td class="key">Realisasi  </td>
      <td><input type="text" name="realisasi_3" size="5" value="<?php echo @$value['realisasi_3'] ?>" readonly/>&nbsp;&nbsp;%</td>
    </tr>
    <tr> 
      <td class="key">Hasil </td>
      <td><textarea name="hasil_3" cols="70" rows="3" readonly><?php echo @$value['hasil_3'] ?></textarea></td>
    </tr>
 <?php 
	break;
	
	case '4':
 ?>  
    <tr>
      <td colspan="2" align="center"><strong>Capaian Kinerja TriwulanIV </strong></td>
    </tr>
    <tr> 
      <td class="key">Realisasi  </td>
      <td><input type="text" name="realisasi_4" size="5" value="<?php echo @$value['realisasi_4'] ?>" readonly/>&nbsp;&nbsp;%</td>
    </tr>
    <tr> 
      <td class="key">Hasil </td>
      <td><textarea name="hasil_4" cols="70" rows="3" readonly><?php echo @$value['hasil_4'] ?></textarea></td>
    </tr>
<?php 
    break;
}	
?>	
    <tr> 
      <td>&nbsp;</td>
      <td>
        <input name="form" type="hidden" value="1" /> <input name="q" type="hidden" value="<?php echo $_GET['q'] ?>" /> 
		<input type="button" onclick="Back('index.php?p=540&kdtriwulan=<?php echo $kdtriwulan ?>')" value="Batal" />
        <input value="Hapus" type="submit">      </td>
    </tr>
  </table>
</form>
