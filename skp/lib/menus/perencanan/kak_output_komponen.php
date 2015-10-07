<?php
	checkauthentication();
	$table = "thuk_kak_komponen";
	$err = false;
	$p = $_GET['p'];
	$q = $_GET['q'];
	$ka = $_GET['ka'];
	$id_o_uk = $_GET['o_uk'];
	$id_o_bp = $_GET['o_bp'];
	
	extract($_POST);
	$xusername_sess = $_SESSION['xusername'];
	
	$oOutput_bp = mysql_query("SELECT * FROM thbp_kak_output WHERE id = '$id_o_bp' ");
	$Output_bp = mysql_fetch_array($oOutput_bp);
	
	$oOutput_uk = mysql_query("SELECT * FROM thuk_kak_output WHERE id = '$id_o_uk' ");
	$Output_uk = mysql_fetch_array($oOutput_uk);

	$th 		= $Output_uk['th'];
	$kdgiat 	= $Output_uk['kdgiat'];
	$kdoutput 	= $Output_uk['kdoutput'];
	
	$xmenu_p = xmenu_id($p);
	$p_next = $xmenu_p->parent;
	
	if (isset($form)) 
	{		
		if ($err != true) 
		{	
			if ($q == "") 
			{
				//ADD NEW
				$th 		= $Output_uk['th'];
				$kdgiat 	= $Output_uk['kdgiat'];
				$kdoutput 	= $Output_uk['kdoutput'];
				$sql = "INSERT INTO $table (id,th,kdgiat,kdoutput,kdkomponen,nmkomponen) VALUE ('','$th','$kdgiat','$kdoutput','$kdkomponen','$nmkomponen')";
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
				
				<meta http-equiv="refresh" content="0;URL=index.php?p=129&o_uk=<?php echo $id_o_uk ?>&o_bp=<?php echo $id_o_bp ?>"><?php
				exit();
			} 
			else {
				// UPDATE
				$sql = "UPDATE $table SET kdkomponen = '$kdkomponen', nmkomponen = '$nmkomponen' WHERE id = '$q'";
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
				
				<meta http-equiv="refresh" content="0;URL=index.php?p=129&o_uk=<?php echo $id_o_uk ?>&o_bp=<?php echo $id_o_bp ?>"><?php
				exit();
			}
		}
		else 
		{ ?>
			<meta http-equiv="refresh" content="0;URL=index.php?p=129&o_uk=<?php echo $id_o_uk ?>&o_bp=<?php echo $id_o_bp ?>"><?php		
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

<form action="index.php?p=129&o_uk=<?php echo $id_o_uk ?>&o_bp=<?php echo $id_o_bp ?>" method="post" name="form">
	
  <table cellspacing="1" class="admintable">
    <tr> 
      <td class="key">Tahun</td>
      <td><input type="text" name="th" size="10" value="<?php echo $Output_uk['th'] ?>" readonly/></td>
    </tr>
    <tr> 
      <td class="key">Kegiatan</td>
      <td><input name="kdgiat" type="text" value="<?php echo nm_giat($Output_uk['kdgiat']) ?>" size="70" readonly/></td>
    </tr>
    <tr> 
      <td class="key">Output</td>
      <td><textarea name="kdoutput" cols="70" rows="3" readonly><?php echo nm_output($Output_uk['kdgiat'].$Output_uk['kdoutput']) ?></textarea></td>
    </tr>
    <tr> 
      <td class="key">Kode Komponen</td>
      <td><input type="text" name="kdkomponen" size="10" value="<?php echo @$value['kdkomponen'] ?>"/></td>
    </tr>
    <tr> 
      <td class="key">Komponen</td>
      <td><textarea name="nmkomponen" cols="70" rows="3"><?php echo @$value['nmkomponen'] ?></textarea></td>
    </tr>
    <tr> 
      <td>&nbsp;</td>
      <td> <div class="button2-right"> 
          <div class="prev"> <a onclick="Back('index.php?p=73&o=<?php echo $id_o_bp ?>&q=<?php echo $id_o_uk ?>&k=<?php echo $ka ?>')">Kembali</a>	
          </div>
        </div>
        <div class="button2-left"> 
          <div class="next"> <a onclick="form.submit();">Simpan</a> </div>
        </div>
        <div class="clr"></div>
        <input style="border: 0pt none ; margin: 0pt; padding: 0pt; width: 0px; height: 0px;" value="Simpan" type="submit"> 
        <input name="form" type="hidden" value="1" /> <input name="q" type="hidden" value="<?php echo $_GET['q'] ?>" />	
      </td>
    </tr>
  </table>
</form>
<br />
<?php
	$sql = "SELECT id,kdkomponen,nmkomponen FROM $table WHERE th = '$th' AND kdgiat = '$kdgiat' AND kdoutput = '$kdoutput' ORDER BY kdsuboutput";
	$aSubOutput = mysql_query($sql);
	$count = mysql_num_rows($aSubOutput);

	while ($SubOutput = mysql_fetch_array($aSubOutput))
	{
		$col[0][] = $SubOutput['id'];
		$col[1][] = $SubOutput['kdkomponen'];
		$col[2][] = $SubOutput['nmkomponen'];
	}
?>
<table width="557" cellpadding="1" class="adminlist">
  <thead>
    <tr> 
      <th width="10%" height="61">No.</th>
      <th width="12%">Kode</th>
      <th width="67%">Komponen</th>
      <th colspan="2">Aksi</th>
    </tr>
  </thead>
  <tbody>
    <?php
		if ($count == 0) 
		{ ?>
    <tr> 
      <td align="center" colspan="5">Tidak ada data!</td>
    </tr>
    <?php
		}
		else {
			foreach ($col[0] as $k=>$val) {
				if ($k % 2 == 1) $class = "row0";
				else $class = "row1"; ?>
    <tr class="<?php echo $class ?>"> 
      <td height="21" align="center"><?php echo $k+1; ?></td>
      <td align="center"><?php echo $col[1][$k] ?></td>
      <td align="left"><?php echo $col[2][$k] ?></td>
      <td width="5%" align="center"> <a href="index.php?p=129&o_uk=<?php echo $id_o_uk ?>&o_bp=<?php echo $id_o_bp ?>&q=<?php echo $col[0][$k]; ?>" title="Edit"> 
        <img src="css/images/edit_f2.png" border="0" width="16" height="16"> </a>	
      </td>
      <td width="6%" align="center">&nbsp;</td>
    </tr>
    <?php
			}
		} ?>
  </tbody>
  <tfoot>
  </tfoot>
</table>
