<?php
	checkauthentication();
	$table = "m_outcome_indikator";
	$err = false;
	$p = $_GET['p'];
	$kdprogram = $_GET['kdprogram'];
	$kdoutcome = $_GET['kdoutcome'];
	$th = $_GET['th'];
	$renstra = th_renstra($th);
	$q = $_GET['q'];
	if ( $q == '' )   $simpan = 'Tambah';
	else  $simpan = 'Simpan';
	if ( $kdprog == '' )   $batal = 'Batal';
	else   $batal = 'Kembali';
	extract($_POST);
	$xusername_sess = $_SESSION['xusername'];
	
	$sql = "SELECT * FROM m_program_outcome WHERE ta = '$th' and kdprogram = '$kdprogram' and kdoutcome = '$kdoutcome'";
	$aOutcome = mysql_query($sql);
	$Outcome = mysql_fetch_array($aOutcome);
	
	$xmenu_p = xmenu_id($p);
	$p_next = $xmenu_p->parent;
	
	if (isset($form)) 
	{		
		if ($err != true) 
		{	
			if ($q == "") 
			{
				//ADD NEW	
				
				$sql = "INSERT INTO $table VALUE ('','$th','$kdprogram','$kdoutcome','$kd_indikator','$nm_indikator','$target_1','$target_2','$target_3','$target_4','$target_5','$jadi_iku_utama')";
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
				
				<meta http-equiv="refresh" content="0;URL=index.php?p=519&th=<?php echo $th ?>&kdprogram=<?php echo $kdprogram ?>&kdoutcome=<?php echo $kdoutcome ?>"><?php
				exit();
			} 
			else {
				// UPDATE
				$sql = "UPDATE $table SET kd_indikator = '$kd_indikator', nm_indikator = '$nm_indikator', target_1 = '$target_1', target_2 = '$target_2', target_3 = '$target_3',
						target_4 = '$target_4', target_5 = '$target_5',
						jadi_iku_utama = '$jadi_iku_utama' WHERE id = '$q'";
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
				<meta http-equiv="refresh" content="0;URL=index.php?p=519&th=<?php echo $th ?>&kdprogram=<?php echo $kdprogram ?>&kdoutcome=<?php echo $kdoutcome ?>"><?php
				}
				exit();
			}
		}
		else 
		{ ?>
			<meta http-equiv="refresh" content="0;URL=index.php?p=519&th=<?php echo $th ?>&kdprogram=<?php echo $kdprogram ?>&kdoutcome=<?php echo $kdoutcome ?>"><?php		
		}
	} 
	else if (isset($_GET["q"])) 
	{
		$sql = "SELECT * FROM $table WHERE id = '".$_GET['q']."'";
		$aGiat = mysql_query($sql);
		$value = mysql_fetch_array($aGiat);
		$th = $value['ta'] ;
		$renstra = th_renstra($th);
		$sql = "SELECT * FROM m_program_outcome WHERE ta = '".$value['ta']."'"." and kdprogram = '".$value['kdprogram']."'" ." and kdoutcome = '".$value['kdoutcome']."'";
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
	
<form action="index.php?p=<?php echo $_GET['p']; ?>&th=<?php echo $th ?>&kdprogram=<?php echo $kdprogram ?>&kdoutcome=<?php echo $kdoutcome ?>&q=<?php echo $q ?>" method="post" name="form">
	<table width="877" cellspacing="1" class="admintable">
		<tr>
		  <td width="132" class="key">Kode Program</td>
		  <td width="657">
		  <?php if ( $kdprogram <> '' ) { ?>
		  <input type="text" size="10" value="<?php echo $Outcome['kddept'].'.'.$Outcome['kdunit'].'.'.$Outcome['kdprogram'] ?>"  disabled="disabled">
		  <?php }else{ ?>
		  <input type="text" size="10" value="<?php echo $Prog['kddept'].'.'.$Prog['kdunit'].'.'.$Prog['kdprogram'] ?>"  disabled="disabled">
		  <?php } ?>		  </td>
	  </tr>
		<tr>
			<td class="key">Program</td>
			<td>
			<?php if ( $kdprogram <> '' ) { ?>
			<textarea  disabled="disabled" cols="70" rows="2"><?php echo nm_program($th,$Outcome['kddept'].$Outcome['kdunit'].$Outcome['kdprogram']) ?></textarea>
			<?php }else{ ?>
			<textarea  disabled="disabled" cols="70" rows="2"><?php echo nm_program($th,$Prog['kddept'].$Prog['kdunit'].$Prog['kdprogram']) ?></textarea>
			<?php } ?>			</td>
		</tr>
		
		<tr>
			<td class="key">Outcome</td>
			<td>
			<?php if ( $kdprogram <> '' ) { ?>
			<textarea name="nmoutcome" cols="70" rows="2" disabled="disabled"><?php echo $Outcome['nmoutcome'] ?></textarea>
			<?php }else{ ?>
			<textarea name="nmoutcome" cols="70" rows="2" disabled="disabled"><?php echo $Prog['nmoutcome'] ?></textarea>
			<?php } ?>			</td>
		</tr>
		
		<tr>
		  <td class="key">Nomor Urut Indikator </td>
		  <td><input type="text" name="kd_indikator" size="8" value="<?php echo @$value['kd_indikator'] ?>" /></td>
	  </tr>
		<tr>
			<td class="key">Indikator</td>
			<td><textarea name="nm_indikator" cols="70" rows="2"><?php echo @$value['nm_indikator'] ?></textarea></td>
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
      <td class="key">Menjadi Indikator Utama</td>
      <td>
	  	<input name="jadi_iku_utama" type="radio" value="1" <?php if( @$value['jadi_iku_utama'] == '1' ) echo 'checked="checked"' ?>/> 
        &nbsp;&nbsp;Ya&nbsp;&nbsp;
	  	<input name="jadi_iku_utama" type="radio" value="0" <?php if( @$value['jadi_iku_utama'] == '0' ) echo 'checked="checked"' ?>/> 
        &nbsp;&nbsp;Tidak&nbsp;&nbsp;		</td>
    </tr>
		<tr>
			<td>&nbsp;</td>
			<td>			
				<div class="button2-right">
					<div class="prev">
						<a onclick="Back('index.php?p=411')"><?php echo $batal ?></a>					</div>
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
<?php if ( $kdprogram <> '' ) { #----- Tambah data ------?>
<?php
	
	$sql = "SELECT * FROM $table WHERE ta = '$th' and kdprogram = '$kdprogram' and kdoutcome = '$kdoutcome' ORDER BY kd_indikator";
	$aIKK = mysql_query($sql);
	$count = mysql_num_rows($aIKK);
	
	while ($IKK = mysql_fetch_array($aIKK))
	{
		$col[0][] = $IKK['id'];
		$col[1][] = $IKK['kd_indikator'];
		$col[2][] = $IKK['nm_indikator'];
		$col[3][] = $IKK['target_1'];
		$col[4][] = $IKK['target_2'];
		$col[5][] = $IKK['target_3'];
		$col[6][] = $IKK['target_4'];
		$col[7][] = $IKK['target_5'];
	}
?>
<table width="514" cellpadding="1" class="adminlist">
	<thead>
		
		<tr>
		  <th width="13%" rowspan="2">Nomor</th>
		  <th width="54%" rowspan="2">Indikator Kinerja Kegiatan</th>
		  <th width="20%" colspan="5">Target</th>
          <th colspan="2" rowspan="2">Aksi</th>
	  </tr>
		<tr>
		  <th><?php echo substr($renstra,0,4) ?></th>
	      <th><?php echo substr($renstra,0,4) + 1 ?></th>
	      <th><?php echo substr($renstra,0,4) + 2 ?></th>
	      <th><?php echo substr($renstra,0,4) + 3 ?></th>
	      <th><?php echo substr($renstra,0,4) + 4 ?></th>
	  </tr>
	</thead>
	<tbody><?php
		if ($count == 0) 
		{ ?>
			<tr><td align="center" colspan="10">Tidak ada data!</td></tr><?php
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
					<td align="center"><?php echo $col[5][$k] ?></td>
					<td align="center"><?php echo $col[6][$k] ?></td>
					<td align="center"><?php echo $col[7][$k] ?></td>
					<td width="5%" align="center">
						<a href="index.php?p=519&th=<?php echo $th ?>&kdprogram=<?php echo $kdprogram ?>&kdoutcome=<?php echo $kdoutcome ?>&q=<?php echo $col[0][$k]; ?>" title="Edit">
							<img src="css/images/edit_f2.png" border="0" width="16" height="16">						</a>					</td>
					<td width="8%" align="center">
						<a href="index.php?p=520&th=<?php echo $th ?>&kdprogram=<?php echo $kdprogram ?>&kdoutcome=<?php echo $kdoutcome ?>&q=<?php echo $col[0][$k]; ?>" title="Delete">
							<img src="css/images/stop_f2.png" border="0" width="16" height="16">						</a>					</td>
				</tr><?php
			}
		} ?>
	</tbody>
	<tfoot>
		<tr>
			<td colspan="10">&nbsp;</td>
		</tr>
	</tfoot>
</table>
<?php } # ----- Akhir tambah data ----- ?>