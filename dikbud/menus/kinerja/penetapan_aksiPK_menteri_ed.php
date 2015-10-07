<?php
	checkauthentication();
	$table = "th_pk";
	$field = array("id","th","kdunitkerja","no_pk","nm_pk","target","rencana_1","rencana_2","rencana_3","rencana_4","aksi_1","aksi_2","aksi_3","aksi_4");
	$err = false;
	$p = $_GET['p'];
	$q = $_GET['q'];
	extract($_POST);
	$xusername_sess = $_SESSION['xusername'];
	$xlevel = $_SESSION['xlevel'];
    $xkdunit = $_SESSION['xkdunit'];
	$th = $_SESSION['xth'];

	$xmenu_p = xmenu_id($p);
	$p_next = $xmenu_p->parent;
	
	$oList = mysql_query("select * from $table WHERE id = '$q' ");
	$List = mysql_fetch_array($oList);
	
	if (isset($form)) {		
		if ($err != true) {
			$lastmodified = now();
			$modifiedby = $xusername_sess;
			$id = $q;
			
			foreach ($field as $k=>$val) {
				$value[$k] = $$val;
			}
			
			if ($q == "") {
				//ADD NEW
			} 
			else {
				// UPDATE
				$rencana_1 = $_REQUEST['rencana_1'];
				$rencana_2 = $_REQUEST['rencana_2'];
				$rencana_3 = $_REQUEST['rencana_3'];
				$rencana_4 = $_REQUEST['rencana_4'];
				$aksi_1 = $_REQUEST['aksi_1'];
				$aksi_2 = $_REQUEST['aksi_2'];
				$aksi_3 = $_REQUEST['aksi_3'];
				$aksi_4 = $_REQUEST['aksi_4'];
				$sql = "UPDATE $table SET rencana_1 = '$rencana_1', rencana_2 = '$rencana_2', rencana_3 = '$rencana_3',
				        rencana_4 = '$rencana_4', aksi_1 = '$aksi_1', aksi_2 = '$aksi_2', aksi_3 = '$aksi_3',
						aksi_4 = '$aksi_4' WHERE id = '$q'";
//				$sql = sql_update($table,$field,$value);
				$rs = mysql_query($sql);
				if ($rs) {	
					update_log($sql,$table,1);
					$_SESSION['errmsg'] = "Ubah data berhasil!";
				}
				else {
					update_log($sql,$table,0);
					$_SESSION['errmsg'] = "Ubah data gagal!";			
				} ?>
				
				<meta http-equiv="refresh" content="0;URL=index.php?p=<?php echo $p_next ?>"><?php
				exit();
			}
		}
		else {?>
			<meta http-equiv="refresh" content="0;URL=index.php?p=<?php echo $p_next ?>"><?php		
		}
	} 
	else if (isset($_GET["q"])) {
		$value = get_value($table,$field,"id='".$_GET['q']."'");
	}
	else {
		$value = "";
	} ?>

<script language="javascript" src="js/autocombo.js"></script>
<form action="index.php?p=<?php echo $_GET['p'] ?>" method="post" name="form">
	
  <table width="693" cellspacing="1" class="admintable">
    

    <tr> 
      <td width="79" class="key">No. Urut </td>
      <td colspan="4"><input type="text" name="no_pk" size="5" value="<?php echo $List['no_pk'] ?>" disabled="disabled"/></td>
    </tr>
    <tr> 
      <td class="key">Kinerja</td>
      <td colspan="4"><textarea name="nm_pk" rows="3" cols="60" disabled="disabled"><?php echo $List['nm_pk'] ?></textarea></td>
    </tr>
    <tr>
      <td colspan="5" class="key" align="center"><strong>RENCANA AKSI:</strong></td>
    </tr>
    <tr>
      <td class="key" valign="top">Triwulan I</td>
      <td width="48" valign="top" align="right">Progres</td>
      <td width="84" valign="top"><input type="text" name="rencana_1" size="5" value="<?php echo $List['rencana_1'] ?>" />&nbsp;%	  </td>
      <td width="47" valign="top" align="right">Uraian</td>
      <td width="417" valign="top"><textarea name="aksi_1" rows="3" cols="60" ><?php echo $List['aksi_1'] ?></textarea></td>
    </tr>
    <tr>
      <td class="key" valign="top">Triwulan II</td>
      <td valign="top" align="right">Progres</td>
      <td valign="top"><input type="text" name="rencana_2" size="5" value="<?php echo $List['rencana_2'] ?>" />&nbsp;%	  </td>
      <td valign="top" align="right">Uraian</td>
      <td width="417" valign="top"><textarea name="aksi_2" rows="3" cols="60" ><?php echo $List['aksi_2'] ?></textarea></td>
    </tr>
    <tr>
      <td class="key" valign="top">Triwulan III</td>
      <td valign="top" align="right">Progres</td>
      <td valign="top"><input type="text" name="rencana_3" size="5" value="<?php echo $List['rencana_3'] ?>" />&nbsp;%	  </td>
      <td valign="top" align="right">Uraian</td>
      <td width="417" valign="top"><textarea name="aksi_3" rows="3" cols="60" ><?php echo $List['aksi_3'] ?></textarea></td>
    </tr>
    <tr>
      <td class="key" valign="top">Triwulan IV</td>
      <td valign="top" align="right">Progres</td>
      <td valign="top"><input type="text" name="rencana_4" size="5" value="<?php echo $List['rencana_4'] ?>" />&nbsp;%	  </td>
      <td valign="top" align="right">Uraian</td>
      <td width="417" valign="top"><textarea name="aksi_4" rows="3" cols="60" ><?php echo $List['aksi_4'] ?></textarea></td>
    </tr>
    
    <tr> 
      <td>&nbsp;</td>
      <td colspan="4"> <div class="button2-right"> 
          <div class="prev"> <a onclick="Cancel('index.php?p=<?php echo $p_next ?>')">Batal</a>          </div>
        </div>
        <div class="button2-left"> 
          <div class="next"> <a onclick="form.submit();">Simpan</a> </div>
        </div>
        <div class="clr"></div>
        <input style="border: 0pt none ; margin: 0pt; padding: 0pt; width: 0px; height: 0px;" value="Simpan" type="submit"> 
        <input name="form" type="hidden" value="1" /> <input name="q" type="hidden" value="<?php echo $_GET['q'] ?>" />      </td>
    </tr>
  </table>
</form>