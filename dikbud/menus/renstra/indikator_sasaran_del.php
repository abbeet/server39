<?php
	checkauthentication();
	$table = "m_iku";
	$field =  array("id","ta","kdunitkerja","kdtujuan","no_sasaran","no_iku","nm_iku");
	$p = $_GET['p'];
	$form = $_POST['form'];
	$q = $_POST['q'];
	$kdunit = $_GET['kdunit'];
	$kdtujuan = $_GET['kdtujuan'];
	$no_sasaran = $_GET['no_sasaran'];
	$th = $_SESSION['xth'];
	$xmenu_p = xmenu_id($p);
	$p_next = $xmenu_p->parent;
		
	if (isset($form)) {
		$sql = sql_delete($table,$field[0],$q);
		$rs = mysql_query($sql);
		if ($rs) {
			update_log($sql,$table,1);
			$_SESSION['errmsg'] = "Hapus data berhasil.";
		}
		else {
			update_log($sql,$table,0);
			$_SESSION['errmsg'] = "Hapus data gagal!";
		} ?>
		<?php if ( $kdunit == '' ) { ?>
		<meta http-equiv="refresh" content="0;URL=index.php?p=<?php echo $p_next ?>"><?php
		}else{ ?>
		<meta http-equiv="refresh" content="0;URL=index.php?p=514&kdunit=<?php echo $kdunit ?>&kdtujuan=<?php echo $kdtujuan ?>&no_sasaran=<?php echo $no_sasaran ?>"><?php
		}
		exit();
	}
	else {
		$value = get_value($table,$field,"id='".$_GET['q']."'");
	}
?>

<script type="text/javascript">
	function form_submit()
	{
		document.forms['form'].submit();
	}
</script>

<table cellspacing="1" class="admintable">
  <tr>
    <td width="105" class="key">Id</td>
    <td width="446"><input type="text" size="5" readonly="readonly" value="<?php echo $value[0] ?>" /></td>
  </tr>
  

      <td class="key">Tujuan</td>
    <td>
	<?php if ( $kdunit == '' ) { ?>
	<textarea readonly="readonly" cols="70" rows="2"><?php echo renstra_tujuan($value[2],$value[3]) ?></textarea>
	<?php }else{ ?>
	<textarea readonly="readonly" cols="70" rows="2"><?php echo renstra_tujuan($kdunit,$kdtujuan) ?></textarea>
	<?php } ?>	</td>
  </tr>  <td class="key">Sasaran</td>
    <td>
	<?php if ( $kdunit == '' ) { ?>
	<textarea readonly="readonly" cols="70" rows="2"><?php echo renstra_sasaran($th,$value[2],$value[3],$value[4]) ?></textarea>
	<?php }else{ ?>
	<textarea readonly="readonly" cols="70" rows="2"><?php echo renstra_sasaran($th,$kdunit,$kdtujuan,$no_sasaran) ?></textarea>
	<?php } ?>	</td>
  </tr>
  <tr>
    <td class="key">Nomor Urut Indikator </td>
    <td><input name="text" type="text" value="<?php echo $value[5] ?>" size="10" readonly="readonly" /></td>
  </tr>
  <tr>
    <td class="key">Indikator Strategis  </td>
    <td><textarea readonly="readonly" cols="70" rows="2"><?php echo $value[6] ?></textarea></td>
  </tr>
  <tr>
    <td class="key">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr> 
    <td>&nbsp;</td>
    <td> <form name="form" method="post" action="index.php?p=<?php echo $_GET['p'] ?>&kdunit=<?php echo $kdunit ?>&kdtujuan=<?php echo $kdtujuan ?>&no_sasaran=<?php echo $no_sasaran ?>">
        <div class="button2-right"> 
          <div class="prev"> 
		  <?php if ( $kdunit == '' ) { ?>
		  <a onclick="Back('index.php?p=<?php echo $p_next ?>')">Batal</a>
		  <?php }else{ ?>
		  <a onclick="Back('index.php?p=514&kdunit=<?php echo $kdunit ?>&kdtujuan=<?php echo $kdtujuan ?>&no_sasaran=<?php echo $no_sasaran ?>')">Batal</a>
		  <?php } ?>
		  </div>
        </div>
        <div class="button2-left"> 
          <div class="next"> <a onclick="form.submit();">Hapus</a> </div>
        </div>
        <div class="clr"></div>
        <input style="border: 0pt none ; margin: 0pt; padding: 0pt; width: 0px; height: 0px;" value="Hapus" type="submit">
        <input name="form" type="hidden" value="1" />
        <input name="q" type="hidden" value="<?php echo $_GET['q'] ?>" />
      </form></td>
  </tr>
</table>
<?php 
function renstra_tujuan($kdunit,$kdtujuan) {
		$data = mysql_query("select nmtujuan from tb_unitkerja_tujuan where kdunit = '$kdunit' and kdtujuan = '$kdtujuan' ");
		$rdata = mysql_fetch_array($data);
		$result = $rdata['nmtujuan'];
		return $result;
}
function renstra_sasaran($th,$kdunit,$kdtujuan,$kdsasaran) {
		$data = mysql_query("select nm_sasaran from m_sasaran where ta = '$th' and kdunitkerja = '$kdunit' and kdtujuan = '$kdtujuan' and no_sasaran = '$kdsasaran' ");
		$rdata = mysql_fetch_array($data);
		$result = trim($rdata['nm_sasaran']);
		return $result;
}
?>