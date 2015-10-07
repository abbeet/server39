<?php
	checkauthentication();
	$table = "m_ikk";
	$err = false;
	$p = $_GET['p'];
	$kdgiat = $_GET['kdgiat'];
	$th = $_GET['th'];
	$renstra = th_renstra($th);
	$q = $_GET['q'];
	if ( $q == '' )   $simpan = 'Tambah';
	else  $simpan = 'Simpan';
	if ( $kdprog == '' )   $batal = 'Batal';
	else   $batal = 'Kembali';
	extract($_POST);
	$xusername_sess = $_SESSION['xusername'];
	
	$sql = "SELECT * FROM m_kegiatan WHERE th = '$th' and kdgiat = '$kdgiat'";
	$aGiat = mysql_query($sql);
	$Giat = mysql_fetch_array($aGiat);
	
	$xmenu_p = xmenu_id($p);
	$p_next = $xmenu_p->parent;
	
	if (isset($form)) 
	{		
		if ($err != true) 
		{	
			if ($q == "") 
			{
				//ADD NEW	
				$sql = "SELECT * FROM m_kegiatan WHERE th = '$th' and kdgiat = '$kdgiat'";
				$aGiat = mysql_query($sql);
				$Giat = mysql_fetch_array($aGiat);
				$kdunitkerja = $Giat['kdunitkerja'];
				$sql = "INSERT INTO $table VALUE ('','$th','$kdunitkerja','$no_ikk','$nm_ikk','$kdgiat','$target_1','$target_2','$target_3','$target_4','$target_5','$jadi_ikk_program')";
				$rs = mysql_query($sql);
				
				if ($rs) 
				{
					update_log($sql,$table,1);
					$_SESSION['errmsg'] = "Input data berhasil!";
				}
				else 
				{
					update_log($sql,$table,0);
					$_SESSION['errmsg'] = "Input data gagal!";
				} ?>
				
				<meta http-equiv="refresh" content="0;URL=index.php?p=516&th=<?php echo $th ?>&kdgiat=<?php echo $kdgiat ?>"><?php
				exit();
			} 
			else {
				// UPDATE
				$sql = "UPDATE $table SET no_ikk = '$no_ikk', nm_ikk = '$nm_ikk', target_1 = '$target_1', target_2 = '$target_2', target_3 = '$target_3',
						target_4 = '$target_4', target_5 = '$target_5',
						jadi_ikk_program = '$jadi_ikk_program' WHERE id = '$q'";
				$rs = mysql_query($sql);
				
				if ($rs) 
				{	
					update_log($sql,$table,1);
					$_SESSION['errmsg'] = "Ubah data berhasil!";
				}
				else 
				{
					update_log($sql,$table,0);
					$_SESSION['errmsg'] = "Ubah data gagal!";			
				} ?>
				<?php if ( $kdgiat == '' ) { ?>
				<meta http-equiv="refresh" content="0;URL=index.php?p=<?php echo $p_next ?>"><?php
				}else{ ?>
				<meta http-equiv="refresh" content="0;URL=index.php?p=516&th=<?php echo $th ?>&kdgiat=<?php echo $kdgiat ?>"><?php
				}
				exit();
			}
		}
		else 
		{ ?>
			<meta http-equiv="refresh" content="0;URL=index.php?p=516&th=<?php echo $th ?>&kdgiat=<?php echo $kdgiat ?>"><?php		
		}
	} 
	else if (isset($_GET["q"])) 
	{
		$sql = "SELECT * FROM $table WHERE id = '".$_GET['q']."'";
		$aGiat = mysql_query($sql);
		$value = mysql_fetch_array($aGiat);
		$th = $value['th'] ;
		$renstra = th_renstra($th);
		$sql = "SELECT * FROM m_kegiatan WHERE th = '".$value['th']."'"." and kdgiat = '".$value['kdgiat']."'";
		$aProg = mysql_query($sql);
		$Prog = mysql_fetch_array($aProg);
	}
	else {
		$value = array();
	} ?>

<script type="text/javascript">
	function form_submit()
	{
		document.forms['form'].submit();
	}
</script>
	
	
<form action="index.php?p=<?php echo $_GET['p']; ?>&th=<?php echo $th ?>&kdgiat=<?php echo $kdgiat ?>&q=<?php echo $q ?>" method="post" name="form">
	<table width="877" cellspacing="1" class="admintable">
		<tr>
		  <td width="132" class="key">Kode Program</td>
		  <td width="657">
		  <?php if ( $kdgiat <> '' ) { ?>
		  <input type="text" size="10" value="<?php echo $Giat['kddept'].'.'.$Giat['kdunit'].'.'.$Giat['kdprogram'] ?>"  disabled="disabled">
		  <?php }else{ ?>
		  <input type="text" size="10" value="<?php echo $Prog['kddept'].'.'.$Prog['kdunit'].'.'.$Prog['kdprogram'] ?>"  disabled="disabled">
		  <?php } ?>		  </td>
	  </tr>
		<tr>
			<td class="key">Program</td>
			<td>
			<?php if ( $kdgiat <> '' ) { ?>
			<textarea  disabled="disabled" cols="70" rows="2"><?php echo nm_program($th,$Giat['kddept'].$Giat['kdunit'].$Giat['kdprogram']) ?></textarea>
			<?php }else{ ?>
			<textarea  disabled="disabled" cols="70" rows="2"><?php echo nm_program($th,$Prog['kddept'].$Prog['kdunit'].$Prog['kdprogram']) ?></textarea>
			<?php } ?>			</td>
		</tr>
		
		<tr>
		  <td class="key">Kode Kegiatan</td>
		  <td>
		  <?php if ( $kdgiat <> '' ) { ?>
		  <input type="text" name="kdgiat" size="8" value="<?php echo $Giat['kdgiat'] ?>" disabled="disabled" />
		  <?php }else{ ?>
		  <input type="text" name="kdgiat" size="8" value="<?php echo $Prog['kdgiat'] ?>" disabled="disabled" />
		  <?php } ?>		  </td>
	  </tr>
		<tr>
			<td class="key">Nama Kegiatan</td>
			<td>
			<?php if ( $kdgiat <> '' ) { ?>
			<textarea name="nmgiat" cols="70" rows="2" disabled="disabled"><?php echo $Giat['nmgiat'] ?></textarea>
			<?php }else{ ?>
			<textarea name="nmgiat" cols="70" rows="2" disabled="disabled"><?php echo $Prog['nmgiat'] ?></textarea>
			<?php } ?>			</td>
		</tr>
		<tr>
		  <td class="key">Unit Kerja</td>
		  <td>
		  <?php if ( $kdgiat <> '' ) { ?>
		  <textarea name="nmgiat" cols="70" rows="1" disabled="disabled"><?php echo nm_unit($Giat['kdunitkerja']) ?></textarea>
		  <?php }else{ ?>
		  <textarea name="nmgiat" cols="70" rows="1" disabled="disabled"><?php echo nm_unit($Prog['kdunitkerja']) ?></textarea>
		  <?php } ?>		  </td>
	  </tr>
		<tr>
		  <td class="key">Nomor Urut IKK</td>
		  <td><input type="text" name="no_ikk" size="8" value="<?php echo @$value['no_ikk'] ?>" /></td>
	  </tr>
		<tr>
			<td class="key">Indikator Kinerja Kegiatan</td>
			<td><textarea name="nm_ikk" cols="70" rows="2"><?php echo @$value['nm_ikk'] ?></textarea></td>
		</tr>
		<tr>
		  <td class="key">Target</td>
		  <td><strong>Tahun <?php echo substr($renstra,0,4) ?></strong>&nbsp;
		    <input type="text" name="target_1" size="8" value="<?php echo @$value['target_1'] ?>" />		    &nbsp;&nbsp;
		  	  <strong>Tahun <?php echo substr($renstra,0,4)+1 ?>&nbsp;<input type="text" name="target_2" size="8" value="<?php echo @$value['target_2'] ?>" /></strong>&nbsp;&nbsp;
			  <strong>Tahun <?php echo substr($renstra,0,4)+2 ?>&nbsp;<input type="text" name="target_3" size="8" value="<?php echo @$value['target_3'] ?>" /></strong><br /><br />
			  <strong>Tahun <?php echo substr($renstra,0,4)+3 ?>&nbsp;<input type="text" name="target_4" size="8" value="<?php echo @$value['target_4'] ?>" /></strong>&nbsp;&nbsp;
			  <strong>Tahun <?php echo substr($renstra,0,4)+4 ?>&nbsp;<input type="text" name="target_5" size="8" value="<?php echo @$value['target_5'] ?>" /></strong>&nbsp;&nbsp;		  </td>
	  </tr>
	  
	  <tr> 
      <td class="key">Menjadi Indikator Program</td>
      <td>
	  	<input name="jadi_ikk_program" type="radio" value="1" <?php if( @$value['jadi_ikk_program'] == '1' ) echo 'checked="checked"' ?>/> 
        &nbsp;&nbsp;Ya&nbsp;&nbsp;
	  	<input name="jadi_ikk_program" type="radio" value="0" <?php if( @$value['jadi_ikk_program'] == '0' ) echo 'checked="checked"' ?>/> 
        &nbsp;&nbsp;Tidak&nbsp;&nbsp;		</td>
    </tr>
		<tr>
			<td>&nbsp;</td>
			<td>			
				<div class="button2-right">
					<div class="prev">
						<a onclick="Back('index.php?p=371')"><?php echo $batal ?></a>					</div>
				</div>
				<div class="button2-left">
					<div class="next">
						<a onclick="form.submit();"><?php echo $simpan ?></a>					</div>
				</div>
				<div class="clr"></div>
				<input style="border: 0pt none ; margin: 0pt; padding: 0pt; width: 0px; height: 0px;" value="Simpan" type="submit">
				<input name="form" type="hidden" value="1" />
				<input name="q" type="hidden" value="<?php echo $_GET['q'] ?>" />			</td>
		</tr>
  </table>
</form>
<br />
<?php if ( $kdgiat <> '' ) { #----- Tambah data ------?>
<?php
	
	$sql = "SELECT * FROM $table WHERE th = '$th' and kdgiat = '$kdgiat' ORDER BY no_ikk";
	$aIKK = mysql_query($sql);
	$count = mysql_num_rows($aIKK);
	
	while ($IKK = mysql_fetch_array($aIKK))
	{
		$col[0][] = $IKK['id'];
		$col[1][] = $IKK['no_ikk'];
		$col[2][] = $IKK['nm_ikk'];
		$col[3][] = $IKK['target_thawal'];
		$col[4][] = $IKK['target_thakhir'];
		$col[5][] = $IKK['jadi_ikk_program'];
	}
?>
<table width="376" cellpadding="1" class="adminlist">
	<thead>
		<tr>
			<th width="13%" rowspan="2">Nomor</th>
			<th width="28%" rowspan="2">Indikator Kinerja Kegiatan</th>
			<th colspan="2">Target</th>
			<th width="18%" rowspan="2">Menjadi Indikator Program</th>
			<th colspan="2" rowspan="2">Aksi</th>
		</tr>
		<tr>
		  <th width="15%">Awal</th>
	      <th width="18%">Akhir</th>
      </tr>
	</thead>
	<tbody><?php
		if ($count == 0) 
		{ ?>
			<tr><td align="center" colspan="8">Tidak ada data!</td></tr><?php
		}
		else {
			foreach ($col[0] as $k=>$val) {
				if ($k % 2 == 1) $class = "row0";
				else $class = "row1"; ?>
				<tr class="<?php echo $class ?>">
					<td align="center"><?php echo $col[1][$k] ?></td>
					<td align="left"><?php echo $col[2][$k] ?></td>
					<td align="center"><?php echo $col[3][$k] ?></td>
					<td align="center"><?php echo $col[4][$k] ?></td>
					<td align="center">
					<?php if ( $col[5][$k] == '1' ) { 
				  		echo "<font color='#0000FF'>Ya</font>";
						}else{
						echo "<font color='#FF0000'>Tidak</font>";
						}
				  ?>
					</td>
					<td width="18%" align="center">
						<a href="index.php?p=516&th=<?php echo $th ?>&kdgiat=<?php echo $kdgiat ?>&q=<?php echo $col[0][$k]; ?>" title="Edit">
							<img src="css/images/edit_f2.png" border="0" width="16" height="16">						</a>					</td>
					<td width="8%" align="center">
						<a href="index.php?p=517&th=<?php echo $th ?>&kdgiat=<?php echo $kdgiat ?>&q=<?php echo $col[0][$k]; ?>" title="Delete">
							<img src="css/images/stop_f2.png" border="0" width="16" height="16">						</a>					</td>
				</tr><?php
			}
		} ?>
	</tbody>
	<tfoot>
		<tr>
			<td colspan="8">&nbsp;</td>
		</tr>
	</tfoot>
</table>
<?php } # ----- Akhir tambah data ----- ?>