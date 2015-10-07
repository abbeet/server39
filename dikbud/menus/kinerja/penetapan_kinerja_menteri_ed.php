<?php
	checkauthentication();
	$table = "th_pk";
	$field = array("id","th","kdunitkerja","no_pk","nm_pk","no_ikk","no_sasaran","target","sub_pk");
	$err = false;
	$p = $_GET['p'];
	$q = $_GET['q'];
	extract($_POST);
	$xusername_sess = $_SESSION['xusername'];
	$xlevel = $_SESSION['xlevel'];
	$xkdunit = $_SESSION['xkdunit'];
	$th = $_SESSION['xth'];
	$renstra = th_renstra($th);

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
				$th = $th ;
				$kdunitkerja = '480000';
				$no_ikk = $_REQUEST['no_ikk'];
				$no_pk = $_REQUEST['no_pk'];
				$nm_pk = $_REQUEST['nm_pk'];
				$target = $_REQUEST['target'];
				$sub_pk = $_REQUEST['sub_pk'];
				$no_sasaran = nosasaran_iku($th,$kdunitkerja,$no_ikk);
				$sql = "INSERT INTO $table ( id, th, kdunitkerja, no_ikk, no_pk, nm_pk, target, no_sasaran,sub_pk)
						VALUES ('','$th','$kdunitkerja','$no_ikk','$no_pk','$nm_pk','$target','$no_sasaran','$sub_pk') ";
//				$sql = sql_insert($table,$field,$value);
				$rs = mysql_query($sql);
				
				if ($rs) {
					update_log($sql,$table,1);
					$_SESSION['errmsg'] = "Input data berhasil!";
				}
				else {
					update_log($sql,$table,0);
					$_SESSION['errmsg'] = "Input data gagal!";
				} ?>
				
				<meta http-equiv="refresh" content="0;URL=index.php?p=<?php echo $p_next ?>"><?php
				exit();
			} 
			else {
				// UPDATE
				$th = $th ;
				$kdunitkerja = '480000';
				$no_ikk = $_REQUEST['no_ikk'];
				$no_pk = $_REQUEST['no_pk'];
				$nm_pk = $_REQUEST['nm_pk'];
				$target = $_REQUEST['target'];
				$sub_pk = $_REQUEST['sub_pk'];
				$no_sasaran = nosasaran_iku($th,$kdunitkerja,$no_ikk);
				$sql = "UPDATE $table SET th = '$th', kdunitkerja = '$kdunitkerja', no_ikk = '$no_ikk', no_pk = '$no_pk', nm_pk = '$nm_pk', target = '$target', no_sasaran = '$no_sasaran', sub_pk = '$sub_pk' WHERE id = '$q'";
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
	
  <table width="985" cellspacing="1" class="admintable">
    <tr> 
      <td class="key">Tahun</td>
      <td><input type="text" name="th" size="10" value="<?php echo $th ?>" /></td>
    </tr>
    
    <tr> 
      <td class="key">IKU</td>
      <td><select name="no_ikk">
          <option value="">-- Pilih IKU --</option>
          <?php
	  				$sql = "SELECT * FROM m_iku WHERE ta = '$th' AND kdunitkerja = '480000' ORDER BY no_sasaran,no_iku";
					$oIKK = mysql_query($sql);
					while ($IKK = mysql_fetch_array($oIKK))
					{ ?>
          <option value="<?php echo $IKK['no_iku']; ?>" <?php if ($IKK['no_iku'] == $List['no_ikk']) echo "selected"; ?>><?php echo $IKK['no_iku'].' '.substr($IKK['nm_iku'],0,70) ?></option>
          <?php
					} ?>
        </select></td>
    </tr>
    
    <tr> 
      <td class="key">No. Urut </td>
      <td><input type="text" name="no_pk" size="5" value="<?php echo $List['no_pk'] ?>" /></td>
    </tr>
    <tr> 
      <td class="key">Kinerja</td>
      <td><textarea name="nm_pk" rows="3" cols="50"><?php echo $List['nm_pk'] ?></textarea></div></td>
    </tr>
    <tr>
      <td class="key">Target</td>
      <td><input type="text" name="target" size="30" value="<?php echo $List['target'] ?>" /></td>
    </tr>
    <tr>
      <td class="key">Ada Sub Kinerja</td>
      <td>
	  <input name="sub_pk" type="radio" value="0" <?php if( $List['sub_pk'] == 0 ) echo 'checked="checked"' ?>/> 
        &nbsp;&nbsp;Tidak&nbsp;&nbsp;
	  	<input name="sub_pk" type="radio" value="1" <?php if( $List['sub_pk'] == 1 ) echo 'checked="checked"' ?>/> 
        &nbsp;&nbsp;Ya&nbsp;&nbsp;
	  </td>
    </tr>
    
    <tr> 
      <td>&nbsp;</td>
      <td> <div class="button2-right"> 
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