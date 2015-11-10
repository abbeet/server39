<?php
	checkauthentication();
	$p = $_GET['p'];
	$table = "dt_fileupload";
	$field = get_field($table);
	$ed_link = "index.php?p=".get_edit_link($p);
	$del_link = "index.php?p=".get_delete_link($p);
	$th = $_SESSION['xth'];
//	$xkdunit = $_SESSION['xkdunit'];
	$renstra = th_renstra($th);
	$th_mulai = substr($renstra,0,4) ;
	$th_selesai = substr($renstra,5,4) ;
	$xlevel = $_SESSION['xlevel'];
	$xusername = $_SESSION['xusername'];
	$sw = $_REQUEST['sw'];
	
if ( $sw == '' )   $xkdunit = $_SESSION['xkdunit'] ;
if ( $sw == 1 )    $xkdunit = $_REQUEST['xkdunit'];

if (isset($_POST["cari"]))
{
   $xkdunit = $_REQUEST['kdunit'];
}

?>
<div align="left">
	<form action="" method="post">
		<input type="hidden" name="p" value="<?php echo $p; ?>" />
		Pilih Eselon II : 
		<select name="kdunit">
                      <option value="<?php echo $xkdunit ?>"><?php echo  nm_unit($xkdunit) ?></option>
                      <option value="">- Pilih Eselon II -</option>
                    <?php
switch ( $xlevel )
{
	case 6 :
	$query = mysql_query("select * from tb_unitkerja WHERE kdunit = '$xkdunit' order by kdunit");
	break ;
	
	default :
	$query = mysql_query("select * from tb_unitkerja where ( kdunit = '2320100' or kdunit = '2320200' or kdunit = '2320300' or kdunit = '2320400' or kdunit = '2320500' or kdunit = '2320600') order by kdunit");
	break ;
}					
						while($row = mysql_fetch_array($query)) { ?>
                      <option value="<?php echo $row['kdunit'] ?>"><?php echo  trim($row['nmunit']); ?></option>
                    <?php
					} ?>	
	  </select>
		<input type="submit" value="Tampilkan" name="cari"/>
	</form>
</div> 
<form action="" method="post" name="form" enctype="multipart/form-data">
<table width="884" cellpadding="1">
  <thead>
    <tr>
      <th colspan="3" align="left"><font size="4" color="#009900">RENSTRA<br /><?php echo nm_unit($xkdunit).'<br>'.th_renstra($th) ?></font></th> 
      </tr>
  </thead>
  <tbody>
   

    <tr >
      <td width="32%" align="center" valign="top" class="row7"><img src="<?php echo 'file_renstra/'.$xkdunit.'/'.cover_renstra($th,$xkdunit) ?>" border="1" width="220" height="300"><br /><br />
	  <div class="button2-left"> 
<div class="next"><a onclick="Back('index.php?p=449&xkdunit=<?php echo $xkdunit ?>')">Update</a></div>
</div>	  </td> 
      <td width="28%" align="left" valign="top" class="row6"><p><font color="#009900"><strong><font color="#990033" size="4"></font></strong></font></p><br />
	  <font size="2" color="#660033"><?php 
	  	$oList = mysql_query("select * from $table where nourut <> 0 and th = '$th' and kdunitkerja = '$xkdunit' and keterangan = 'Renstra' order by nourut");	
	while($List = mysql_fetch_array($oList))
    { ?>
	  <a href= "index.php?p=450&kdunit=<?php  echo "$List[kdunitkerja]" ?>&nourut=<?php echo "$List[nourut]" ?>&nama=<?php echo "$List[nama_file]" ?>" ><font size="2"><?php echo '=> '.$List['dafisi'] ?></font></a><br>
	<?php
	}  
	  ?></font>	  </td>
      <td width="40%" align="left" valign="top" class="row6"><br />
      <font color="#009900" size="3"><strong>Visi :</strong></font><br /><strong><?php echo visi_unit($xkdunit) ?></strong><br /><br />
      <font color="#009900" size="3"><strong>Misi :</strong></font><br /><strong>
	  <?php 	
		$sql = "select * from tb_unitkerja_misi WHERE kdunit = '$xkdunit' order by kdmisi";
		$data = mysql_query($sql);
		while( $rdata = mysql_fetch_array($data) )
		{
			echo '<strong>'.$rdata['kdmisi'].'. '.$rdata['nmmisi'].'<br>'.'</strong>';
		}
		?>
	  <br />
      <font color="#009900" size="3"><strong>Tugas Pokok :</strong></font><br /><strong>
	 <?php echo tusi_unit($xkdunit) ?>
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