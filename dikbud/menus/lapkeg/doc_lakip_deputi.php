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
	$xkdunit = setup_kddept_unit($kode).'20000' ;
?>
<table width="1109" cellpadding="1">
  <thead>
    <tr>
      <th colspan="3" align="left"><font size="4" color="#FF9900">LAKIP<br />
          <?php echo nm_unit($xkdunit).'<br> Tahun '.($th-1) ?></font></th> 
    </tr>
  </thead>
  <tbody>
   

    <tr >
      <td width="32%" align="center" valign="top" class="row7"><img src="<?php echo 'file_lakip/'.$xkdunit.'/'.cover_lakip($th,$xkdunit) ?>" border="1" width="220" height="300"><br /><br />
	  <div class="button2-left"> 
<div class="next"><a onclick="Back('index.php?p=591&xkdunit=<?php echo $xkdunit ?>')">Update</a></div>
</div>	  </td> 
      <td width="23%" align="left" valign="top" class="row6"><p><font color="#009900"><strong><font color="#990033" size="4"></font></strong></font></p><br />
	  <font size="2" color="#660033"><font size="2" color="#660033">
	  <?php 
	  	$oList = mysql_query("select * from $table where nourut <> 0 and th = '$th' and kdunitkerja = '$xkdunit' and keterangan = 'Lakip' order by nourut");	
	while($List = mysql_fetch_array($oList))
    { ?>
	  </font><a href= "index.php?p=592&kdunit=<?php  echo "$List[kdunitkerja]" ?>&nourut=<?php echo "$List[nourut]" ?>&nama=<?php echo "$List[nama_file]" ?>" ><font size="2"><?php echo '=> '.$List['dafisi'] ?></font></a><br>
	<?php
	}  
	  ?></font>	  </td>
      <td width="45%" align="left" valign="top" class="row6"><br />
      <font color="#FF9900" size="3"><strong>Tugas Pokok :</strong></font><br /><strong><?php echo tusi_unit($xkdunit) ?></strong><br /><br />
      <font color="#FF9900" size="3"><strong>Fungsi :</strong></font><br />
	  <?php 	
		$sql = "select * from tb_unitkerja_fungsi WHERE kdunit = '$xkdunit' order by kdfungsi";
		$data = mysql_query($sql);
		while( $rdata = mysql_fetch_array($data) )
		{
			echo $rdata['kdfungsi'].'. '.$rdata['nmfungsi'].'<br>';
		}
		?><br />
		<font color="#FF9900" size="3"><strong>Sasaran Strategis :</strong></font><br />
	  <?php 	
		$sql = "select * from m_sasaran_utama WHERE kdunit = '$xkdunit' order by no_sasaran";
		$data = mysql_query($sql);
		while( $rdata = mysql_fetch_array($data) )
		{
			echo $rdata['no_sasaran'].'. '.$rdata['nm_sasaran'].'<br>';
		}
		?><br />	  </td>
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