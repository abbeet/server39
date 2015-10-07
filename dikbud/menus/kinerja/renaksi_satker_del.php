<?php
	checkauthentication();
	$table = "dt_pk";
	$err = false;
	$p = $_GET['p'];
	$q = $_GET['q'];
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
				
				<meta http-equiv="refresh" content="0;URL=index.php?p=614"><?php
				exit();
			} 
			else {
				// UPDATE
				$sql = "UPDATE $table SET rencana_aksi_1 = '', rencana_aksi_2 = '',
										  rencana_aksi_3 = '', rencana_aksi_4 = '',
										  rencana_1 = 0 , rencana_2 = 0 ,
										  rencana_3 = 0 , rencana_4 = 0
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
				} ?>
				
				<meta http-equiv="refresh" content="0;URL=index.php?p=614"><?php
				exit();
			}
		}
		else 
		{ ?>
			<meta http-equiv="refresh" content="0;URL=index.php?p=614"><?php		
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
	
	<script type="text/javascript">
										function form_delete()
										{
											document.forms['xdelete'].submit();
										}
	</script>

<form action="" method="post" name="xdelete">
	
  <table cellspacing="1" class="admintable">
    
    
    <tr>
      <td class="key">Tahun</td>
      <td><input type="text" name="th" size="5" value="<?php echo $PK['th'] ?>" readonly/></td>
    </tr>
    
    <tr> 
      <td width="109" class="key">Indikator Kinerja </td>
      <td><textarea name="nm_iku" cols="70" rows="2" readonly><?php echo $PK['indikator'] ?></textarea></td>
    </tr>
    <tr>
      <td colspan="2" align="center"><strong>Rencana Aksi </strong></td>
    </tr>
    
    <tr> 
      <td class="key">Rencana Aksi<br />Triwulan I</td>
      <td><input type="text" name="rencana_1" size="5" value="<?php echo @$value['rencana_1'] ?>" readonly/>%<br /><textarea name="rencana_aksi_1" cols="70" rows="3" readonly><?php echo @$value['rencana_aksi_1'] ?></textarea></td>
    </tr>
    <tr> 
      <td class="key">Rencana Aksi<br />Triwulan II</td>
      <td><input type="text" name="rencana_2" size="5" value="<?php echo @$value['rencana_2'] ?>" readonly/>%<br /><textarea name="rencana_aksi_2" cols="70" rows="3" readonly><?php echo @$value['rencana_aksi_2'] ?></textarea></td>
    </tr>
    <tr> 
      <td class="key">Rencana Aksi<br />Triwulan III</td>
      <td><input type="text" name="rencana_3" size="5" value="<?php echo @$value['rencana_3'] ?>" readonly/>%<br /><textarea name="rencana_aksi_3" cols="70" rows="3" readonly><?php echo @$value['rencana_aksi_3'] ?></textarea></td>
    </tr>
    <tr> 
      <td class="key">Rencana Aksi<br />Triwulan I</td>
      <td><input type="text" name="rencana_4" size="5" value="<?php echo @$value['rencana_4'] ?>" readonly/>%<br /><textarea name="rencana_aksi_4" cols="70" rows="3" readonly><?php echo @$value['rencana_aksi_4'] ?></textarea></td>
    </tr>
    <tr> 
      <td>&nbsp;</td>
      <td> <div class="button2-right"> 
          <div class="prev"> <a onclick="Cancel('index.php?p=<?php echo $p_next ?>')">Batal</a>          </div>
        </div>
        <div class="button2-left"> 
          <div class="next"> <a onclick="form_delete();">Hapus</a> </div>
        </div>
        <div class="clr"></div>
        <input style="border: 0pt none ; margin: 0pt; padding: 0pt; width: 0px; height: 0px;" value="Simpan" type="submit"> 
        <input name="form" type="hidden" value="1" /> <input name="q" type="hidden" value="<?php echo $_GET['q'] ?>" />      </td>
    </tr>
  </table>
</form>
