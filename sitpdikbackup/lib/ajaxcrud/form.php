<?
	include 'connect.inc.php';
	$id = isset($_GET['id_pegawai']) ? intval($_GET['id_pegawai']) : false;
	
	if($id){
	   $query = mysql_query('SELECT * FROM master_pegawai WHERE ID = "'.$id.'"');
	   if($query && mysql_num_rows($query) == 1){
	      $data = mysql_fetch_object($query);
	   }else 
	      die('Data pegawai tidak ditemukan');
	}
?>
<div id="divResult" style="font-size:11px;text-align:center;display:none"></div>
<form action="process.php" method="post" id="formData" onSubmit="return submitForm();">
 <table>
   <tr>
	 <td>NIP</td>
	 <td>:</td>
	 <td><input type="text" name="NIP" size="6" maxlength="6" value="<?=@$data->NIP?>" onKeyUp="this.value = String(this.value).toUpperCase()" /></td>
   </tr>
   <tr>
	 <td>Nama Pegawai</td>
	 <td>:</td>
	 <td><input type="text" name="Name" size="30" value="<?=@$data->Name?>" /></td>
   </tr>
   <tr valign="top">
	 <td>Alamat</td>
	 <td>:</td>
	 <td><textarea name="Address" rows="6" cols="30"><?=@$data->Address?></textarea></td>
   </tr>
   <tr>
	 <td>Departement</td>
	 <td>:</td>
	 <td>
	    <select name="Department">
		<?
		   $query = mysql_query('SELECT * FROM master_department');
		   if($query && mysql_num_rows($query) > 0){
			  while($row = mysql_fetch_object($query)){
				 echo '<option value="'.$row->ID.'"';
				 if($row->ID == @$data->Department) echo ' selected';
				 echo '>'.$row->DepartmentName.'</option>';
			  }
		   }	   
		?>
		</select>
	 </td>
   </tr>
   <tr>
	 <td>&nbsp;</td>
	 <td>&nbsp;</td>
	 <td>
		<input type="hidden" name="ID" value="<?=@$data->ID?>" />
		<input type="submit" name="submit" value="Simpan" />
		<input type="button" value="Batal" onClick="tb_remove()" />
	 </td>
   </tr>
 </table>
</form>
