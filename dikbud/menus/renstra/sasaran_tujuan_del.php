<?php
	checkauthentication();
	$table = "m_sasaran";
	$field =  array("id","ta","kdunitkerja","kdtujuan","no_sasaran","nm_sasaran");
	$p = $_GET['p'];
	$form = $_POST['form'];
	$q = $_POST['q'];
	$kdunit = $_GET['kdunit'];
	$kdtujuan = $_GET['kdtujuan'];
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
		<meta http-equiv="refresh" content="0;URL=index.php?p=512&kdunit=<?php echo $kdunit ?>&kdtujuan=<?php echo $kdtujuan ?>"><?php
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
  

    <td class="key">tujuan</td>
    <td>
	<?php if ( $kdunit == '' ) { ?>
	<textarea readonly="readonly" cols="70" rows="2"><?php echo renstra_tujuan($value[2],$value[3]) ?></textarea>
	<?php }else{ ?>
	<textarea readonly="readonly" cols="70" rows="2"><?php echo renstra_tujuan($kdunit,$kdtujuan) ?></textarea>
	<?php } ?>
	</td>
  </tr>
  <tr>
    <td class="key">Nomor Urut Indikator </td>
    <td><input name="text" type="text" value="<?php echo $value[4] ?>" size="10" readonly="readonly" /></td>
  </tr>
  <tr>
    <td class="key">Indikator  </td>
    <td><textarea readonly="readonly" cols="70" rows="2"><?php echo $value[5] ?></textarea></td>
  </tr>
  <tr>
    <td class="key">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr> 
    <td>&nbsp;</td>
    <td> <form name="form" method="post" action="index.php?p=<?php echo $_GET['p'] ?>&kdunit=<?php echo $kdunit ?>&kdtujuan=<?php echo $kdtujuan ?>">
        <div class="button2-right"> 
          <div class="prev"> 
		  <?php if ( $kdunit == '' ) { ?>
		  <a onclick="Back('index.php?p=<?php echo $p_next ?>')">Batal</a>
		  <?php }else{ ?>
		  <a onclick="Back('index.php?p=512&kdunit=<?php echo $kdunit ?>&kdtujuan=<?php echo $kdtujuan ?>')">Batal</a>
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
?>