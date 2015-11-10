<?php
	checkauthentication();
//	$table = "t_output";
	$field = get_field($table);
	$err = false;
	$p = $_GET['p'];
	$kdgiat = $_REQUEST['kdgiat'];
	$kdoutput = $_REQUEST['kdoutput'];
	extract($_POST);
	$xusername_sess = $_SESSION['xusername'];
	$th = $_SESSION['xth'];
		switch ( $th )
	{
	    case 2012 :
		$table = "t_output2012";
		break;
	    case 2013 :
		$table = "t_output2013";
		break;
	    case 2014 :
		$table = "t_output2014";
		break;
	    default :
		$table = "t_output";
		break;
	}	
	
	$oList = mysql_query("select * from $table WHERE KDGIAT = '$kdgiat' AND KDOUTPUT = '$kdoutput'");
	$List = mysql_fetch_array($oList);

	$xmenu_p = xmenu_id($p);
	$p_next = $xmenu_p->parent;
	
	if (isset($form)) {		
		if ($err != true) {
			$lastmodified = now();
			$modifiedby = $xusername_sess;
			if ($kdgiat == "" and $kdoutput == "") {
				//ADD NEW	
				$kdgiatx = $_REQUEST['kdgiatx'];
				$kdoutputx = $_REQUEST['kdoutputx'];
				$nmoutput = $_REQUEST['nmoutput'];
				$sat = $_REQUEST['sat'];
				$sql = "INSERT INTO $table (KDGIAT,KDOUTPUT,NMOUTPUT,SAT) VALUES ('$kdgiatx','$kdoutputx','$nmoutput','$sat')";
	//			$sql = sql_insert($table,$field,$value);
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
				$nmoutput = $_REQUEST['nmoutput'];
				$sat = $_REQUEST['sat'];
				$sql = "UPDATE $table SET NMOUTPUT = '$nmoutput', SAT = '$sat' WHERE KDGIAT = '$kdgiat' AND KDOUTPUT = '$kdoutput'";
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
?>
<form action="index.php?p=<?php echo $_GET['p'] ?>&kdgiat=<?php echo $kdgiat ?>&kdoutput=<?php echo $kdoutput ?>" method="post" name="form">
	<table width="582" cellspacing="1" class="admintable">
		<tr>
		  <td class="key">Tahun</td>
		  <td><?php echo $th ?></td>
	  </tr>
		<tr>
		  <td class="key">Kode Kegiatan</td>
		  <td><input type="text" name="kdgiatx" size="5" value="<?php echo $List['KDGIAT'] ?>" /></td>
	  </tr>
		<tr>
			<td width="110" class="key">Kode Output </td>
			<td width="324"><input type="text" name="kdoutputx" size="5" value="<?php echo $List['KDOUTPUT'] ?>" /></td>
		</tr>
		<tr>
			<td class="key">Nama Output</td>
			<td><input type="text" name="nmoutput" size="70" value="<?php echo $List['NMOUTPUT'] ?>" /></td>
		</tr>
		<tr>
		  <td class="key">Satuan</td>
		  <td><input type="text" name="sat" size="50" value="<?php echo $List['SAT'] ?>" /></td>
	  </tr>
		
		<tr>
			<td>&nbsp;</td>
			<td>			
				<div class="button2-right">
					<div class="prev">
						<a onclick="Cancel('index.php?p=<?php echo $p_next ?>')">Batal</a>					</div>
				</div>
				<div class="button2-left">
					<div class="next">
						<a onclick="form.submit();">Simpan</a>					</div>
				</div>
				<div class="clr"></div>
				<input style="border: 0pt none ; margin: 0pt; padding: 0pt; width: 0px; height: 0px;" value="Simpan" type="submit">
				<input name="form" type="hidden" value="1" />
				<input name="q" type="hidden" value="<?php echo $_GET['q'] ?>" />			</td>
		</tr>
  </table>
</form>