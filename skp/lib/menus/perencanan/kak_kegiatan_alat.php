<?php
	checkauthentication();
	$table = "thuk_kak_alat";
	$err = false;
	$p = $_GET['p'];
	$kdunitkerja = $_GET['u'];
	$kdgiat = $_GET['g'];
	$th = $_GET['t'];
	$u = $_GET['u'];
	extract($_POST);
	$xusername_sess = $_SESSION['xusername'];
	
	$xmenu_p = xmenu_id($p);
	$p_next = $xmenu_p->parent;
	
	if (isset($form)) 
	{		
		if ($err != true) 
		{	
			if ($q == "") 
			{
				//ADD NEW
				$sql = "INSERT INTO $table VALUE ('','$th','$kdunitkerja','$kdgiat','$nmalat','$volume','$satuan','$harga_satuan','$penempatan','$alasan_pengadaan','$status_alat')";
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
				
				<meta http-equiv="refresh" content="0;URL=index.php?p=133&u=<?php echo $kdunitkerja ?>&g=<?php echo $kdgiat ?>&t=<?php echo $th ?>"><?php
				exit();
			} 
			else {
				// UPDATE
				$sql = "UPDATE $table SET nmalat = '$nmalat', volume = '$volume', satuan = '$satuan' , harga_satuan = '$harga_satuan',
						penempatan = '$penempatan' , alasan_pengadaan = '$alasan_pengadaan' , status_alat = '$status_alat' WHERE id = '$q'";
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
				
				<meta http-equiv="refresh" content="0;URL=index.php?p=133&u=<?php echo $kdunitkerja ?>&g=<?php echo $kdgiat ?>&t=<?php echo $th ?>"><?php
				exit();
			}
		}
		else 
		{ ?>
			<meta http-equiv="refresh" content="0;URL=index.php?p=133&u=<?php echo $kdunitkerja ?>&g=<?php echo $kdgiat ?>&t=<?php echo $th ?>"><?php		
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

<form action="index.php?p=133&u=<?php echo $kdunitkerja ?>&g=<?php echo $kdgiat ?>&t=<?php echo $th ?>" method="post" name="form">
	
  <table cellspacing="1" class="admintable">
    <tr> 
      <td class="key">Tahun</td>
      <td><input type="text" size="10" value="<?php echo $th ?>" readonly/></td>
    </tr>
    <tr> 
      <td class="key">Unit Kerja </td>
      <td><input type="text" size="70" value="<?php echo nm_unit($kdunitkerja) ?>" readonly/></td>
    </tr>
    <tr> 
      <td class="key">Kegiatan</td>
      <td><input name="text" type="text" value="<?php echo nm_giat($kdgiat) ?>" size="70" readonly/></td>
    </tr>
    <tr> 
      <td class="key">Nama Alat</td>
      <td><textarea name="nmalat" cols="70" rows="2" ><?php echo @$value['nmalat'] ?></textarea></td>
    </tr>
    <tr> 
      <td class="key">Perkiraan Harga Satuan</td>
      <td><input type="text" name="harga_satuan" size="30" value="<?php echo @$value['harga_satuan'] ?>" /></td>
    </tr>
    <tr> 
      <td class="key">Volume</td>
      <td><input type="text" name="volume" size="10" value="<?php echo @$value['volume'] ?>"/>
        &nbsp;&nbsp;<input type="text" name="satuan" size="30" value="<?php echo @$value['satuan'] ?>" /></td>
    </tr>
    <tr> 
      <td class="key">Penempatan Alat</td>
      <td><input type="text" name="penempatan" size="70" value="<?php echo @$value['penempatan'] ?>" /></td>
    </tr>
    <tr>
      <td class="key">Alasan Pengadaan</td>
      <td><textarea name="alasan_pengadaan" cols="70" rows="2" ><?php echo @$value['alasan_pengadaan'] ?></textarea></td>
    </tr>
    <tr>
      <td class="key">Status Alat</td>
      <td><input type="radio" name="status_alat" value="1" <?php if (@$value['status_alat']=='1') echo "checked"; ?> >Dihibahkan<br>
	      <input type="radio" name="status_alat" value="0" <?php if (@$value['status_alat']=='0') echo "checked"; ?> >Dipakai sendiri</td>
    </tr>
    <tr> 
      <td>&nbsp;</td>
      <td> <div class="button2-right"> 
          <div class="prev"> <a onclick="Back('index.php?p=46&cari=<?php echo $th; ?>')">Kembali</a>	
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
<?php
	$sql = "SELECT * FROM $table WHERE th='$th' and kdunitkerja='$kdunitkerja' and kdgiat='$kdgiat' ORDER BY id";
	$aAlat = mysql_query($sql);
	$count = mysql_num_rows($aAlat);
	$jmlh = 0;
	
	while ($Alat = mysql_fetch_array($aAlat))
	{
		$col[0][] = $Alat['id'];
		$col[1][] = $Alat['nmalat'];
		$col[2][] = $Alat['volume'];
		$col[3][] = $Alat['satuan'];
		$col[4][] = $Alat['harga_satuan'];
		$col[5][] = $Alat['penempatan'];
		$col[6][] = $Alat['alasan_pengadaan'];
		if($Alat['status_alat']=='1') $col[7][] = "Dihibahkan" ;
		if($Alat['status_alat']=='0') $col[7][] = "Dipakai Sendiri" ;
		$jmlh += $Alat['volume'] * $Alat['harga_satuan'];
	}
?>
<table width="592" cellpadding="1" class="adminlist">
  <thead>
    <tr> 
      <th width="5%" height="61">No.</th>
      <th width="23%">Nama Alat</th>
      <th width="9%">Volume</th>
      <th width="12%">Perkiraan<br>
        Harga Satuan</th>
      <th width="8%">Harga</th>
      <th width="15%">Penempatan<br>
        Alat</th>
      <th width="13%">Alasan<br>
        Pengadaan</th>
      <th width="8%">Status</th>
      <th width="5%">Aksi</th>
      <th width="2%">&nbsp;</th>
    </tr>
  </thead>
  <tbody>
    <?php
		if ($count == 0) 
		{ ?>
    <tr> 
      <td align="center" colspan="10">Tidak ada data!</td>
    </tr>
    <?php
		}
		else {
			foreach ($col[0] as $k=>$val) {
				if ($k % 2 == 1) $class = "row0";
				else $class = "row1"; ?>
    <tr class="<?php echo $class ?>"> 
      <td align="center"><?php echo $k+1; ?></td>
      <td align="center"><?php echo $col[1][$k] ?></td>
      <td align="left"><?php echo $col[2][$k].' '.$col[3][$k] ?></td>
      <td align="right"><?php echo number_format($col[4][$k],"0",",",".") ?></td>
      <td align="right"><?php echo number_format(($col[2][$k] * $col[4][$k]),"0",",",".") ?></td>
      <td align="left"><?php echo $col[5][$k] ?></td>
      <td align="left"><?php echo $col[6][$k] ?></td>
      <td align="left"><?php echo $col[7][$k] ?></td>
      <td align="center"> <a href="index.php?p=133&u=<?php echo $u; ?>&g=<?php echo $kdgiat; ?>&t=<?php echo $th; ?>&q=<?php echo $col[0][$k]; ?>" title="Edit"> 
        <img src="css/images/edit_f2.png" border="0" width="16" height="16"> </a>	
      </td>
      <td align="center"><a href="index.php?p=134&u=<?php echo $u; ?>&g=<?php echo $kdgiat; ?>&t=<?php echo $th; ?>&q=<?php echo $col[0][$k]; ?>" title="Delete">
							<img src="css/images/stop_f2.png" border="0" width="16" height="16">						</a></td>
    </tr>
    <?php
			}
		} ?>
  </tbody>
  <tfoot>
    <tr> 
      <td colspan="4" align="right"><b>Jumlah</b></td>
      <td align="right"><b><?php echo number_format($jmlh,"0",",",".") ?></b></td>
      <td align="right">&nbsp;</td>
      <td align="right">&nbsp;</td>
      <td align="right">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
  </tfoot>
</table>
