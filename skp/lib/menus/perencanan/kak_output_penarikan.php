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
				$sql = "INSERT INTO $table (id,th,kdgiat,kdoutput,kdsuboutput,kdkomponen,kdakun,anggaran,jan,peb,mar,apr,mei,jun,jul,agt,sep,okt,nop,des)
									 VALUE ('','$th','$kdgiat','$kdoutput','$kdsuboutput','$kdkomponen','$kdakun','$jan','$peb','$mar','$apr','$mei','$jun','$jul',
									 		'$agt','$sep','$okt','$nop','$des')";
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
				
				<meta http-equiv="refresh" content="0;URL=index.php?p=131&o_uk=<?php echo $id_o_uk ?>&o_bp=<?php echo $id_o_bp ?>"><?php
				exit();
			} 
			else {
				// UPDATE
				$sql = "UPDATE $table SET jan = '$jan', peb = '$peb', mar = '$mar', apr = '$apr', mei = '$mei', jun = '$jun', jul = '$jul',
										  agt = '$agt', sep = '$sep', okt = '$okt', nop = '$nop', des = '$des' WHERE id = '$q'";
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
				
				<meta http-equiv="refresh" content="0;URL=index.php?p=131&o_uk=<?php echo $id_o_uk ?>&o_bp=<?php echo $id_o_bp ?>"><?php
				exit();
			}
		}
		else 
		{ ?>
			<meta http-equiv="refresh" content="0;URL=index.php?p=131&o_uk=<?php echo $id_o_uk ?>&o_bp=<?php echo $id_o_bp ?>"><?php		
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

<form action="index.php?p=131&o_uk=<?php echo $id_o_uk ?>&o_bp=<?php echo $id_o_bp ?>" method="post" name="form">
  <table cellspacing="1" class="admintable">
    <tr> 
      <td width="72" class="key">Tahun</td>
      <td width="616"><input type="text" name="th" size="10" value="<?php echo $Output_uk['th'] ?>" readonly/></td>
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
        <input type="text" name="Input" size="70" value="<?php echo nmdipa_suboutput($Output_uk['th'],$Output_uk['kdgiat'],$Output_uk['kdoutput'],@$value['kdsuboutput']) ?>" readonly/> 
      </td>
    </tr>
    <tr> 
      <td class="key">Komponen</td>
      <td><input type="text" name="kdkomponen" size="5" value="<?php echo @$value['kdkomponen'] ?>" readonly/> 
        <input type="text" name="Input" size="70" value="<?php echo nmdipa_komponen($Output_uk['th'],$Output_uk['kdgiat'],$Output_uk['kdoutput'],@$value['kdsuboutput'],@$value['kdkomponen']) ?>" readonly/> 
      </td>
    </tr>
    <tr> 
      <td class="key">Kode Akun</td>
      <td><input type="text" name="kdakun" size="10" value="<?php echo @$value['kdakun'] ?>" readonly/> 
        <input type="text" name="nmakun" size="60" value="<?php echo nm_akun(@$value['kdakun']) ?>" readonly/> 
      </td>
    </tr>
    <tr> 
      <td class="key">Anggaran</td>
      <td><input type="text" name="anggaran" size="30" value="<?php echo @$value['anggaran'] ?>" readonly/></td>
    </tr>
    <tr> 
      <td colspan="2" class="key"><div align="center"><strong>Rencana Penarikan</strong></div></td>
    </tr>
    <tr> 
      <td class="key">Januari</td>
      <td><input type="text" name="jan" size="30" value="<?php echo @$value['jan'] ?>" /></td>
    </tr>
    <tr> 
      <td class="key">Februari</td>
      <td><input type="text" name="peb" size="30" value="<?php echo @$value['peb'] ?>" /></td>
    </tr>
    <tr> 
      <td class="key">Maret</td>
      <td><input type="text" name="mar" size="30" value="<?php echo @$value['mar'] ?>" /></td>
    </tr>
    <tr> 
      <td class="key">April</td>
      <td><input type="text" name="apr" size="30" value="<?php echo @$value['apr'] ?>" /></td>
    </tr>
    <tr> 
      <td class="key">Mei</td>
      <td><input type="text" name="mei" size="30" value="<?php echo @$value['mei'] ?>" /></td>
    </tr>
    <tr> 
      <td class="key">Juni</td>
      <td><input type="text" name="jun" size="30" value="<?php echo @$value['jun'] ?>" /></td>
    </tr>
    <tr> 
      <td class="key">Juli</td>
      <td><input type="text" name="jul" size="30" value="<?php echo @$value['jul'] ?>" /></td>
    </tr>
    <tr> 
      <td class="key">Agustus</td>
      <td><input type="text" name="agt" size="30" value="<?php echo @$value['agt'] ?>" /></td>
    </tr>
    <tr> 
      <td class="key">September</td>
      <td><input type="text" name="sep" size="30" value="<?php echo @$value['sep'] ?>" /></td>
    </tr>
    <tr> 
      <td class="key">Oktober</td>
      <td><input type="text" name="okt" size="30" value="<?php echo @$value['okt'] ?>" /></td>
    </tr>
    <tr> 
      <td class="key">Nopember</td>
      <td><input type="text" name="nop" size="30" value="<?php echo @$value['nop'] ?>" /></td>
    </tr>
    <tr> 
      <td class="key">Desember</td>
      <td><input type="text" name="des" size="30" value="<?php echo @$value['des'] ?>" /></td>
    </tr>
    <tr> 
      <td>&nbsp;</td>
      <td> <div class="button2-right"> 
          <div class="prev"> <a onClick="Back('index.php?p=73&o=<?php echo $id_o_bp ?>&q=<?php echo $id_o_uk ?>&k=<?php echo $ka ?>')">Kembali</a>	
          </div>
        </div>
        <div class="button2-left"> 
          <div class="next"> <a onClick="form.submit();">Simpan</a> </div>
        </div>
        <div class="clr"></div>
        <input name="submit" type="submit" style="border: 0pt none ; margin: 0pt; padding: 0pt; width: 0px; height: 0px;" value="Simpan"> 
        <input name="form" type="hidden" value="1" /> <input name="q" type="hidden" value="<?php echo $_GET['q'] ?>" />	
      </td>
    </tr>
  </table>
</form>
<br />
<table width="509" cellpadding="1" class="adminlist">
  <thead>
    <tr> 
      <th width="8%" height="61" rowspan="2">Kode</th>
      <th width="16%" rowspan="2">Sub Output / Komponen / Akun</th>
      <th width="14%" rowspan="2">Anggaran</th>
      <th colspan="12">Bulan</th>
      <th colspan="2" rowspan="2">Aksi</th>
    </tr>
    <tr> 
      <th width="4%">1</th>
      <th width="4%">2</th>
      <th width="4%">3</th>
      <th width="4%">4</th>
      <th width="4%">5</th>
      <th width="4%">6</th>
      <th width="4%">7</th>
      <th width="4%">8</th>
      <th width="4%">9</th>
      <th width="4%">10</th>
      <th width="4%">11</th>
      <th width="4%">12</th>
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
      <td height="22" colspan="17" align="left"><strong><?php echo strtoupper(nmdipa_suboutput($th,$kdgiat,$kdoutput,$SubOutput['kdsuboutput'])) ?></strong></td>
    </tr>
    <?php
	$n = 0 ;
	$sql = "SELECT kdkomponen, sum(anggaran) as pagu FROM $table WHERE th = '$th' AND kdgiat = '$kdgiat' AND kdoutput = '$kdoutput' and kdsuboutput = '$SubOutput[kdsuboutput]' GROUP BY kdkomponen ORDER BY kdkomponen";
	$aKomponen = mysql_query($sql);
	while ($Komponen = mysql_fetch_array($aKomponen))
	{
	$n += 1;
	?>
    <tr class="<?php echo $class ?>"> 
      <td align="center"><strong><?php echo $Komponen['kdkomponen'] ?></strong></td>
      <td align="left"><strong><?php echo nmdipa_komponen($th,$kdgiat,$kdoutput,$SubOutput['kdsuboutput'],$Komponen['kdkomponen']) ?></strong></td>
      <td align="right"><strong><?php echo number_format($Komponen['pagu'],"0",",",".") ?></strong></td>
      <td align="right">&nbsp;</td>
      <td align="right">&nbsp;</td>
      <td align="right">&nbsp;</td>
      <td align="right">&nbsp;</td>
      <td align="right">&nbsp;</td>
      <td align="right">&nbsp;</td>
      <td align="right">&nbsp;</td>
      <td align="right">&nbsp;</td>
      <td align="right">&nbsp;</td>
      <td align="right">&nbsp;</td>
      <td align="right">&nbsp;</td>
      <td align="right">&nbsp;</td>
      <td width="11%" align="center"> <strong> </strong></td>
      <td width="3%" align="center">&nbsp;</td>
    </tr>
    <?php 
	$sql = "SELECT *  FROM $table WHERE th = '$th' AND kdgiat = '$kdgiat' AND kdoutput = '$kdoutput' AND kdsuboutput = '$SubOutput[kdsuboutput]' AND kdkomponen = '$Komponen[kdkomponen]' ORDER BY kdakun";
	$aAkun = mysql_query($sql);
	while($Akun = mysql_fetch_array($aAkun))
	{
	?>
    <tr class="<?php echo $class ?>"> 
      <td align="center"><?php echo $Akun['kdakun'] ?></td>
      <td align="left"><?php echo nm_akun($Akun['kdakun']) ?></td>
      <td align="right"><?php echo number_format($Akun['jan'],"0",",",".") ?></td>
      <td align="right"><?php echo number_format($Akun['peb'],"0",",",".") ?></td>
      <td align="right"><?php echo number_format($Akun['mar'],"0",",",".") ?></td>
      <td align="right"><?php echo number_format($Akun['apr'],"0",",",".") ?></td>
      <td align="right"><?php echo number_format($Akun['mei'],"0",",",".") ?></td>
      <td align="right"><?php echo number_format($Akun['jun'],"0",",",".") ?></td>
      <td align="right"><?php echo number_format($Akun['jul'],"0",",",".") ?></td>
      <td align="right"><?php echo number_format($Akun['agt'],"0",",",".") ?></td>
      <td align="right"><?php echo number_format($Akun['sep'],"0",",",".") ?></td>
      <td align="right"><?php echo number_format($Akun['okt'],"0",",",".") ?></td>
      <td align="right"><?php echo number_format($Akun['nop'],"0",",",".") ?></td>
      <td align="right"><?php echo number_format($Akun['des'],"0",",",".") ?></td>
      <td align="right"><?php echo number_format($Akun['anggaran'],"0",",",".") ?></td>
      <td align="center"><a href="index.php?p=131&o_uk=<?php echo $id_o_uk ?>&o_bp=<?php echo $id_o_bp ?>&q=<?php echo $Akun['id'] ?>" title="Edit"> 
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
