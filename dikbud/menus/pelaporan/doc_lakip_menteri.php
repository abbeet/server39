<?php
	checkauthentication();
	$p = $_GET['p'];
	$table = "dt_fileupload";
	$field = get_field($table);
	$ed_link = "index.php?p=".get_edit_link($p);
	$del_link = "index.php?p=".get_delete_link($p);
	$th = $_SESSION['xth'];
	$renstra = th_renstra($th)-1;
	$th_mulai = substr($renstra,0,4) ;
	$th_selesai = substr($renstra,5,4) ;
	$kdunit = $_SESSION['xkdunit'];
	$xlevel = $_SESSION['xlevel'];
	$xusername = $_SESSION['xusername'];
?>
<form action="" method="post" name="form" enctype="multipart/form-data">
<table width="927" cellpadding="1">
  <thead>
    <tr>
      <th colspan="3" align="left"><font size="4" color="#009900">LAKIP<br /><?php echo nm_unit('480000').'<br>'.th_renstra($th) ?></font></th> 
      </tr>
  </thead>
  <tbody>
   

    <tr >
      <td width="24%" align="center" valign="top" class="row7"><img src="<?php echo 'file_lakip/480000/'.cover_renstra($th,'480000') ?>" border="1" width="220" height="300"><br />
        <br />
	  <div class="button2-left"> 
<div class="next"><a onclick="Back('index.php?p=531')">Update</a></div>
</div>	  </td> 
      <td width="25%" align="left" valign="top" class="row6"><p><font color="#009900"><strong><font color="#990033" size="4"></font></strong></font></p><br />
	  <font size="2" color="#660033"><?php 
	  	$oList = mysql_query("select * from $table where th = '$th' and nourut <> 0 and kdunitkerja = '480000' and keterangan = 'Lakip' order by nourut");	
	while($List = mysql_fetch_array($oList))
    { ?>
	  <a href= "index.php?p=532&kdunit=<?php  echo "480000" ?>&nourut=<?php echo "$List[nourut]" ?>&nama=<?php echo "$List[nama_file]" ?>" ><font size="2"><?php echo '=> '.$List['dafisi'] ?></font></a><br>
<?php	}  
	  ?></font>	  </td>
      <td width="51%" align="left" valign="top" class="row6"><br />
      <font color="#009900" size="3"><strong>Visi :</strong></font><br /><strong><?php echo visi_unit('480000') ?></strong><br /><br />
      <font color="#009900" size="3"><strong>Misi :</strong></font><br /><strong>
	  <?php 	
		$kode = '480000';	
		$sql = "select * from tb_unitkerja_misi WHERE kdunit = '$kode' order by kdmisi";
		$data = mysql_query($sql);
		while( $rdata = mysql_fetch_array($data) )
		{
			echo '<strong>'.$rdata['kdmisi'].'. '.$rdata['nmmisi'].'<br>'.'</strong>';
		}
		?>
	  </strong><br />
      <font color="#009900" size="3"><strong>Tugas Pokok:</strong></font><br /><strong>
	  <?php echo tusi_unit('480000') ?>
	  </strong><br />	  </td>
    </tr>
  </tbody>
  <tfoot>
    <tr> 
      <td colspan="4"><br />	  </td>
    </tr>
    
    <tr>
      <td colspan="4"></td>
    </tr>
  </tfoot>
</table>
</form>