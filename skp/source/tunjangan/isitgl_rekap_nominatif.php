<?php	
	checkauthentication();
	$kdsatker = $_REQUEST['kdsatker'];
	$kdbulan = $_REQUEST['kdbulan'];
	$th = $_REQUEST['th'];
?>
	<form method="post" action="source/tunjangan/rekap_nominatif_prn.php?kdsatker=<?php echo $kdsatker ?>&kdbulan=<?php echo $kdbulan ?>&th=<?php echo $th ?>" target="_blank">
		<table width="556"  class="admintable">
			
			<tr height="29">
				<td colspan="5"><strong><font size="+1">Update Tanggal Daftar Nominatif</font></strong></td>
			<tr height="29">
			  <td width="142">&nbsp;</td>
			  <td colspan="4">&nbsp;</td>
		  </tr>
			
			<tr height="29">
			  <td  class="key">Tanggal</td>
			  <td colspan="3"><input type="text" name="tgl" size="15" value="<?php echo date("Y-m-d") ?>"/>&nbsp;[Tahun-Bulan-Tanggal]</td>
		      <td width="1">&nbsp;</td>
		  </tr>
		  <tr height="29">
			  <td  class="key">Cetak ket (*) pada kolom jumlah penerima</td>
			  <td colspan="3">
			  <select name="ket">
			  	<option value="Y" selected>Ya
				<option value="T">Tidak
				</select>
			  </td>
		      <td width="1">&nbsp;</td>
		  </tr>
			
			<tr>
				<td>&nbsp;</td>
				<td width="137">	
					<input name="ok" type="submit" id="x" value="   OK  ">
					<input name="cancel" type="button" id="x" value="  Batal  " onClick="Cancel('index.php?p=302&kdsatker=<?php echo $kdsatker ?>&kdbulan=<?php echo $kdbulan ?>&th=<?php echo $th ?>')"></td>
			    <td width="254">&nbsp;</td>
			</tr>
	  </table>
	</form>
