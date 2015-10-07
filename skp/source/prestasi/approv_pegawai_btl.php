<?php	
	checkauthentication();
	extract($_POST);
	$xusername_sess = $_SESSION['xusername'];
	$xmenu_p = xmenu_id($p);
	$p_next = $xmenu_p->parent;
	$id_skp = $_REQUEST['id_skp'];
	$sql = "SELECT pesan FROM mst_skp WHERE id = '$id_skp'";
	$qu = mysql_query($sql);
	$row = mysql_fetch_array($qu);
	$pesan = $row['pesan'];
?>

<div id="formtable">
	<form method="POST" action="index.php?p=390&sw=0&id_skp=<?php echo $id_skp ?>">
		<table width="194">
			<tr height="5">
				<td colspan="4"><div align="left"><strong>Pesan baru ke bawahan:<br />
				</strong></div></td>
			</tr>
			<tr height="29">
				<td colspan="4">
				<textarea name="pesan_baru" rows="3" cols="75"></textarea><br />
			</tr>
			<tr height="5">
				<td colspan="4"><div align="left"><strong>Histori pesan:<br />
				</strong></div></td>
			</tr>
			<tr height="29">
				<td colspan="4">
				<textarea name="pesan_lama" rows="5" cols="75"><?php echo $pesan; ?>
				</textarea><br />
			</tr>
			<tr height="30">
				<td>
				<!-- kode status kirim=1 batal=0 -->
				<input type="hidden" name="kode" value="0">
				<input type="hidden" name="p_next" value="<?php echo $p_next ?>">
				</td>
			<td colspan="3">			
					<input name="kirim" type="submit" id="k" value=" Kirim ke Pegawai ">
					<input name="cancel" type="button" id="c" value="  Kembali  " onClick="Cancel('index.php?p=<?php echo $p_next ?>&pagess=<?php echo $pagess ?>&cari=<?php echo $cari ?>')"></td>
				</td>
			</tr>
	  </table>
	</form>
</div>

<!--19 Juli 2010-->