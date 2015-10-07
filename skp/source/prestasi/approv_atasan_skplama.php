<?php	
	checkauthentication();
	extract($_POST);
	$xusername_sess = $_SESSION['xusername'];
	$xmenu_p = xmenu_id($p);
	$p_next = $xmenu_p->parent;
	$id_skp = $_REQUEST['id_skp'];
?>

<div id="formtable">
	<form method="post" action="index.php?p=449&sw=1&id_skp=<?php echo $id_skp ?>">
		<table width="300">
			<tr height="30">
				<td>
				<!-- kode kirim=1 batal=0 -->
				<input type="hidden" name="kode" value="1">
				<input type="hidden" name="p_next" value="<?php echo $p_next ?>">
				</td>
			<td colspan="3">			
					<input name="kirim" type="submit" id="k" value="  Setuju  ">
					<input name="cetak" type="button" id="c" value="  Cetak  " onClick="window.open('source/prestasi/buat_skp_prn.php?id_skp=<?php echo $id_skp ?>&sw=1','_blank')">
					<input name="cancel" type="button" id="c" value="  Kembali  " onClick="Cancel('index.php?p=<?php echo $p_next ?>&pagess=<?php echo $pagess ?>&cari=<?php echo $cari ?>')">
				</td>
			</tr>
	  </table>
	</form>
</div>