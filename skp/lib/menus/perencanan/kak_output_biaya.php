<?php
	checkauthentication();
	$table = "thuk_kak_akun";
	$err = false;
	$p = $_GET['p'];
	$q = $_GET['q'];
	$ka = $_GET['ka'];
	$id_o_uk = $_GET['o_uk'];
	$id_o_bp = $_GET['o_bp'];
	
	extract($_POST);
	$xusername_sess = $_SESSION['xusername'];
	
	$oOutput_bp = mysql_query("SELECT * FROM thbp_kak_output WHERE id = '$id_o_bp' ");
	$Output_bp = mysql_fetch_array($oOutput_bp);
	
	$oOutput_uk = mysql_query("SELECT * FROM thuk_kak_output WHERE id = '$id_o_uk' ");
	$Output_uk = mysql_fetch_array($oOutput_uk);

	$th 		= $Output_uk['th'];
	$kdgiat 	= $Output_uk['kdgiat'];
	$kdoutput 	= $Output_uk['kdoutput'];
	
	$xmenu_p = xmenu_id($p);
	$p_next = $xmenu_p->parent;
	
	if (isset($form)) 
	{		
		if ($err != true) 
		{	
			if ($q == "") 
			{
				//ADD NEW
				$th 		= $Output_uk['th'];
				$kdgiat 	= $Output_uk['kdgiat'];
				$kdoutput 	= $Output_uk['kdoutput'];
				$sql = "INSERT INTO $table (id,th,kdgiat,kdoutput,kdsuboutput,kdkomponen,kdakun,anggaran) VALUE ('','$th','$kdgiat','$kdoutput','$kdsuboutput','$kdkomponen,'$kdakun','$anggaran')";
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
				
				<meta http-equiv="refresh" content="0;URL=index.php?p=130&o_uk=<?php echo $id_o_uk ?>&o_bp=<?php echo $id_o_bp ?>"><?php
				exit();
			} 
			else {
				// UPDATE
				$sql = "UPDATE $table SET kdakun = '$kdakun', anggaran = '$anggaran' WHERE id = '$q'";
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
				
				<meta http-equiv="refresh" content="0;URL=index.php?p=130&o_uk=<?php echo $id_o_uk ?>&o_bp=<?php echo $id_o_bp ?>"><?php
				exit();
			}
		}
		else 
		{ ?>
			<meta http-equiv="refresh" content="0;URL=index.php?p=130&o_uk=<?php echo $id_o_uk ?>&o_bp=<?php echo $id_o_bp ?>"><?php		
		}
	}
	else if (isset($_GET["q"])) 
	{
		$sql = "SELECT * FROM $table WHERE id = '".$_GET['q']."'";
		$aFungsi = mysql_query($sql);
		$value = mysql_fetch_array($aFungsi);
	}
	else {
		$value = array();
	} ?>

<form action="index.php?p=130&o_uk=<?php echo $id_o_uk ?>&o_bp=<?php echo $id_o_bp ?>" method="post" name="form">
	
  <table cellspacing="1" class="admintable">
    <tr> 
      <td class="key">Tahun</td>
      <td><input type="text" name="th" size="10" value="<?php echo $Output_uk['th'] ?>" readonly/></td>
    </tr>
    <tr> 
      <td class="key">Kegiatan</td>
      <td><input name="kdgiat" type="text" value="<?php echo nm_giat($Output_uk['kdgiat']) ?>" size="70" readonly/></td>
    </tr>
    <tr> 
      <td class="key">Output</td>
      <td><textarea name="kdoutput" cols="70" rows="3" readonly><?php echo nm_output($Output_uk['kdgiat'].$Output_uk['kdoutput']) ?></textarea></td>
    </tr>
    <tr>
      <td class="key">Sub Output</td>
      <td><input type="text" name="kdsuboutput" size="5" value="<?php echo @$value['kdsuboutput'] ?>" readonly/>
	  	  <input type="text" name="" size="70" value="<?php echo nmdipa_suboutput($Output_uk['th'],$Output_uk['kdgiat'],$Output_uk['kdoutput'],@$value['kdsuboutput']) ?>" readonly/>
	  </td>
    </tr>
    <tr> 
      <td class="key">Komponen</td>
      <td><input type="text" name="kdkomponen" size="5" value="<?php echo @$value['kdkomponen'] ?>" readonly/>
   		<input type="text" name="" size="70" value="<?php echo nmdipa_komponen($Output_uk['th'],$Output_uk['kdgiat'],$Output_uk['kdoutput'],@$value['kdsuboutput'],@$value['kdkomponen']) ?>" readonly/>
	  </td>
    </tr>
    <tr> 
      <td class="key">Kode Akun</td>
      <td><input type="text" name="kdakun" size="10" value="<?php echo @$value['kdakun'] ?>"/></td>
    </tr>
    <tr> 
      <td class="key">Anggaran</td>
      <td><input type="text" name="anggaran" size="30" value="<?php echo @$value['anggaran'] ?>"/></td>
    </tr>
    <tr> 
      <td>&nbsp;</td>
      <td> <div class="button2-right"> 
          <div class="prev"> <a onclick="Back('index.php?p=73&o=<?php echo $id_o_bp ?>&q=<?php echo $id_o_uk ?>&k=<?php echo $ka ?>')">Kembali</a>	
          </div>
        </div>
        <div class="button2-left"> 
          <div class="next"> <a onclick="form.submit();">Simpan</a> </div>
        </div>
        <div class="clr"></div>
        <input style="border: 0pt none ; margin: 0pt; padding: 0pt; width: 0px; height: 0px;" value="Simpan" type="submit"> 
        <input name="form" type="hidden" value="1" /> <input name="q" type="hidden" value="<?php echo $_GET['q'] ?>" />	
      </td>
    </tr>
  </table>
</form>
<br />
<table width="557" cellpadding="1" class="adminlist">
  <thead>
    <tr> 
      <th width="9%" height="61">No.</th>
      <th width="14%">Kode</th>
      <th width="44%">Sub Output / Komponen / Akun</th>
      <th width="18%">Anggaran</th>
      <th colspan="2">Aksi</th>
    </tr>
  </thead>
  <tbody>
    <tr> 
	<?php
	$sql = "SELECT kdsuboutput FROM $table WHERE th = '$th' AND kdgiat = '$kdgiat' AND kdoutput = '$kdoutput' GROUP BY kdsuboutput ORDER BY kdsuboutput";
	$aSubOutput = mysql_query($sql);
	while ($SubOutput = mysql_fetch_array($aSubOutput))
	{
	?>
      <td height="22" colspan="6" align="left"><strong><?php echo strtoupper(nmdipa_suboutput($th,$kdgiat,$kdoutput,$SubOutput['kdsuboutput'])) ?></strong></td>
    </tr>
	<?php
	$n = 0 ;
	$sql = "SELECT kdkomponen, sum(anggaran) as pagu  FROM $table WHERE th = '$th' AND kdgiat = '$kdgiat' AND kdoutput = '$kdoutput' and kdsuboutput = '$SubOutput[kdsuboutput]' GROUP BY kdkomponen ORDER BY kdkomponen";
	$aKomponen = mysql_query($sql);
	while ($Komponen = mysql_fetch_array($aKomponen))
	{
	$n += 1;
	?>
    <tr class="<?php echo $class ?>"> 
      <td align="center"><strong><?php echo $n ?></strong></td>
      <td align="center"><strong><?php echo $Komponen['kdkomponen'] ?></strong></td>
      <td align="left"><strong><?php echo nmdipa_komponen($th,$kdgiat,$kdoutput,$SubOutput['kdsuboutput'],$Komponen['kdkomponen']) ?></strong></td>
      <td align="right"><strong><?php echo number_format($col[3][$k],"0",",",".") ?></strong></td>
      <td width="8%" align="center"> <strong>	
        </strong></td>
      <td width="7%" align="center">&nbsp;</td>
    </tr>
    <?php 
	$sql = "SELECT id,kdakun,anggaran  FROM $table WHERE th = '$th' AND kdgiat = '$kdgiat' AND kdoutput = '$kdoutput' AND kdsuboutput = '$SubOutput[kdsuboutput]' AND kdkomponen = '$Komponen[kdkomponen]' ORDER BY kdakun";
	$aAkun = mysql_query($sql);
	while($Akun = mysql_fetch_array($aAkun))
	{
	?>
    <tr class="<?php echo $class ?>"> 
      <td align="center">&nbsp;</td>
      <td align="center"><?php echo $Akun['kdakun'] ?></td>
      <td align="left"><?php echo nm_akun($Akun['kdakun']) ?></td>
      <td align="right"><?php echo number_format($Akun['anggaran'],"0",",",".") ?></td>
      <td align="center"><a href="index.php?p=130&o_uk=<?php echo $id_o_uk ?>&o_bp=<?php echo $id_o_bp ?>&q=<?php echo $Akun['id'] ?>" title="Edit"> 
        <img src="css/images/edit_f2.png" border="0" width="16" height="16"> </a></td>
      <td align="center">&nbsp;</td>
    </tr>
    <?php
		}
		}
		} ?>
  </tbody>
  <tfoot>
  </tfoot>
</table>
