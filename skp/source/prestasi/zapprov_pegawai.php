<?php	

	checkauthentication();
	extract($_POST);
	$xusername_sess = $_SESSION['xusername'];
	$xmenu_p = xmenu_id($p);
	$p_next = $xmenu_p->parent;
	$id_skp = $_REQUEST['id_skp'];
	$sql = "SELECT is_approved_awal,tgl_approved_awal FROM mst_skp WHERE id = '$id_skp'";
	$qu = mysql_query($sql);
	$row = mysql_fetch_array($qu);
?>

<div id="formtable">
	<form method="post" action="source/prestasi/buat_skp_prn.php?id_skp=<?php echo $id_skp ?>&sw=<?php echo $_REQUEST['sw'] ?>" target="_blank">
		<table width="194">
			
			<tr height="29">
				<td colspan="4"><div align="left"><strong>Persetujuan SKP<br />
				</strong></div></td>
			<tr height="29">
			  <td width="13">&nbsp;</td>
			  <td colspan="3">&nbsp;</td>
		  </tr>
			<tr height="29">
				<td>&nbsp;</td>
				<td colspan="3">
				<input name="kode" type="radio"  value="0" <?php if( $row['is_approved_awal'] == 0 ) echo 'checked' ?> />&nbsp;Draf (belum final)&nbsp;<br />
				<input name="kode" type="radio"  value="1" <?php if( $row['is_approved_awal'] == 1 ) echo 'checked' ?> />&nbsp;Setuju
				</td>
			</tr>
			
			<tr height="29">
				<td>&nbsp;</td>
				<td colspan="3">&nbsp;				</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
			<td colspan="3">			
					<input name="ok" type="submit" id="x" value="   OK/Cetak  ">
					<input name="cancel" type="button" id="x" value="  Kembali  " onClick="Cancel('index.php?p=<?php echo $p_next ?>&pagess=<?php echo $pagess ?>&cari=<?php echo $cari ?>')"></td>
				</td>
			</tr>
	  </table>
	</form>
</div>

<!--19 Juli 2010-->