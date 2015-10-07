<?php
	checkauthentication();
	$table = "thuk_kak_output";
	$field = get_field($table);
	$err = false;
	$p = $_GET['p'];
	$k = $_GET['k'];
	$q = $_GET['q'];
	$o = $_GET['o'];

	extract($_POST);
	$xusername_sess = $_SESSION['xusername'];
	
	$oOutput_bp = mysql_query("SELECT * FROM thbp_kak_output WHERE id = '$o' ");
	$Output_bp = mysql_fetch_array($oOutput_bp);

	$oKegiatan_bp = mysql_query("SELECT * FROM thbp_kak_kegiatan WHERE id = '$k' ");
	$Kegiatan_bp = mysql_fetch_array($oKegiatan_bp);
	
	

	$xmenu_p = xmenu_id($p);
	$p_next = $xmenu_p->parent;
	
	if (isset($form)) {		
		if ($err != true) {
			$lastmodified = now();
			$modifiedby = $xusername_sess;
			$id = $q;
			
			foreach ($field as $k=>$val) {
				$value[$k] = $$val;
			}
			
			if ($q == "") {
				//ADD NEW
				$value[1] = $Output_bp['th'];
				$value[2] = $Output_bp['kdunitkerja'];
				$value[3] = $Output_bp['kdgiat'];
				$value[4] = $Output_bp['kdoutput'];
				$sql = sql_insert($table,$field,$value);
				$rs = mysql_query($sql);
				
				if ($rs) {
					update_log($sql,$table,1);
					$_SESSION['errmsg'] = "Input data berhasil!";
				}
				else {
					update_log($sql,$table,0);
					$_SESSION['errmsg'] = "Input data gagal!";
				} ?>
				
				<meta http-equiv="refresh" content="0;URL=index.php?p=<?php echo $p_next ?>"><?php
				exit();
			} 
			else {
				// UPDATE
				$value[1] = $Output_bp['th'];
				$value[2] = $Output_bp['kdunitkerja'];
				$value[3] = $Output_bp['kdgiat'];
				$value[4] = $Output_bp['kdoutput'];
				$sql = sql_update($table,$field,$value);
				$rs = mysql_query($sql);
				if ($rs) {	
					update_log($sql,$table,1);
					$_SESSION['errmsg'] = "Ubah data berhasil!";
				}
				else {
					update_log($sql,$table,0);
					$_SESSION['errmsg'] = "Ubah data gagal!";			
				} ?>
				
				<meta http-equiv="refresh" content="0;URL=index.php?p=<?php echo $p_next ?>"><?php
				exit();
			}
		}
		else {?>
			<meta http-equiv="refresh" content="0;URL=index.php?p=<?php echo $p_next ?>"><?php		
		}
	} 
	else if (isset($_GET["q"])) {
		$value = get_value($table,$field,"id='".$_GET['q']."'");
	}
	else {
		$value = "";
	} ?>

<form action="" method="post" name="form">
	
  <table width="721" cellspacing="1" class="admintable">
    <tr> 
      <td width="150" class="key">TAHUN</td>
      <td width="562"><strong><?php echo $Kegiatan_bp['th'] ?></strong></td>
    </tr>
    <tr> 
      <td class="key">KEMENTERIAN / LEMBAGA</td>
      <td><strong><?php echo nm_unit('420000') ?></strong></td>
    </tr>
    <tr> 
      <td class="key">UNIT ESELON</td>
      <td><?php echo nm_unit($Kegiatan_bp['kdunitkerja']) ?></td>
    </tr>
    <tr> 
      <td height="21" class="key">PROGRAM</td>
      <td><?php echo nm_program($Kegiatan_bp['kddept'].$Kegiatan_bp['kdunit'].$Kegiatan_bp['kdprogram']) ?></td>
    </tr>
    <tr> 
      <td class="key">OUTCOME</td>
      <td><?php echo outcome_program($Kegiatan_bp['kddept'].$Kegiatan_bp['kdunit'].$Kegiatan_bp['kdprogram']) ?></td>
    </tr>
    <tr> 
      <td class="key">KEGIATAN</td>
      <td><?php echo nm_giat($Kegiatan_bp['kdgiat']) ?></td>
    </tr>
    <tr> 
      <td class="key">OUTPUT</td>
      <td><?php echo nm_output($Output_bp['kdgiat'].$Output_bp['kdoutput']) ?></td>
    </tr>
    <tr> 
      <td class="key">IKU</td>
      <td> 
        <?php
	$sql = "SELECT iku FROM m_iku_program WHERE kddeputi = '".substr($Kegiatan_bp[kdunitkerja],0,3).'000'."'";
	$oIKU = mysql_query($sql);
	$n = 0 ;
	while ($IKU = mysql_fetch_array($oIKU))
	{ 
	$n += 1 ;
	echo $n.". ".$IKU['iku']."<br>";
	}
	?>
      </td>
    </tr>
    <tr> 
      <td class="key">KOORDINATOR</td>
      <td><?php echo $Output_bp['id_pjawab']?></td>
    </tr>
    <tr> 
      <td class="key">SUB OUTPUT<br> <a href="index.php?p=127&o_uk=<?php echo $q ?>&o_bp=<?php echo $o ?>&q=<?php echo '' ?>&ka=<?php echo $k ?>" title="Edit Sub Output"> 
        Edit >> </a> </td>
      <td> 
        <?php 
			$sql = "SELECT kdsuboutput,nmsuboutput FROM thuk_kak_suboutput WHERE th = '$Output_bp[th]' AND kdgiat = '$Output_bp[kdgiat]' AND kdoutput = '$Output_bp[kdoutput]' ORDER BY kdsuboutput";
			$aSubOutput = mysql_query($sql);
			while ($SubOutput = mysql_fetch_array($aSubOutput))
			{
				echo $SubOutput['kdsuboutput'].'  '.$SubOutput['nmsuboutput'].'<br>';
			}
		?>
      </td>
    </tr>
    <tr> 
      <td colspan="2" class="key"><div align="center">Latar Belakang</div></td>
    </tr>
    <tr> 
      <td class="key">Dasar Hukum</td>
      <td><textarea name="<?php echo $field[6] ?>" rows="5" cols="80"><?php echo $value[6] ?></textarea></td>
    </tr>
    <tr> 
      <td class="key">Gambaran Umum</td>
      <td><textarea name="<?php echo $field[7] ?>" rows="5" cols="80"><?php echo $value[7] ?></textarea></td>
    </tr>
    <tr> 
      <td class="key">Keterkaitan Output dengan IKU</td>
      <td><textarea name="<?php echo $field[8] ?>" rows="5" cols="80"><?php echo $value[8] ?></textarea></td>
    </tr>
    <tr> 
      <td colspan="2" class="key"><div align="center"><strong>Maksud dan Tujuan</strong></div></td>
    </tr>
    <tr> 
      <td class="key">Maksud</td>
      <td><textarea name="<?php echo $field[9] ?>" rows="5" cols="80"><?php echo $value[9] ?></textarea></td>
    </tr>
    <tr> 
      <td class="key">Tujuan</td>
      <td><textarea name="<?php echo $field[10] ?>" rows="5" cols="80"><?php echo $value[10] ?></textarea></td>
    </tr>
    <tr> 
      <td colspan="2" class="key"><div align="center"><strong>Kegiatan yang Dilaksanakan</strong></div></td>
    </tr>
    <tr> 
      <td colspan="2" class="key"><div align="center"> 
          <textarea name="<?php echo $field[11] ?>" rows="5" cols="90"><?php echo $value[11] ?></textarea>
        </div></td>
    </tr>
    <tr> 
      <td colspan="2" class="key"><div align="center"><strong>Cara Pelaksanaan 
          Kegiatan</strong></div></td>
    </tr>
    <tr> 
      <td class="key">Metode Pelaksanaan</td>
      <td class="key"><textarea name="<?php echo $field[13] ?>" rows="5" cols="80"><?php echo $value[13] ?></textarea></td>
    </tr>
    <tr> 
      <td class="key">Tahapan Pelaksanaan / Komponen<br> <a href="index.php?p=129&o_uk=<?php echo $q ?>&o_bp=<?php echo $o ?>&q=<?php echo '' ?>&ka=<?php echo $k ?>" title="Edit Tahapan Pelaksanaan"> 
        Edit >> </a> </td>
      <td> 
        <?php 
			$sql = "SELECT kdkomponen,nmkomponen FROM thuk_kak_komponen WHERE th = '$Output_bp[th]' AND kdgiat = '$Output_bp[kdgiat]' AND kdoutput = '$Output_bp[kdoutput]' ORDER BY kdkomponen";
			$aKomponen = mysql_query($sql);
			while ($Komponen = mysql_fetch_array($aKomponen))
			{
				echo $Komponen['kdkomponen'].'. '.$Komponen['nmkomponen'] .'<br>';
			}
		?>
      </td>
    </tr>
    <tr> 
      <td class="key">Tempat Pelaksanaan</td>
      <td><input type="text" name="<?php echo $field[12] ?>" value="<?php echo $value[12] ?>" size="80"></td>
    </tr>
    <tr> 
      <td height="59" class="key">Pelaksana Kegiatan</td>
      <td> <a href="index.php?p=129&k=<?php echo $k ?>&q=<?php echo $q ?>&o=<?php echo $o ?>" title="Edit Tahapan Pelaksanaan"> 
        Personil Pelaksana >> </a><br> <a href="index.php?p=130&k=<?php echo $k ?>&q=<?php echo $q ?>&o=<?php echo $o ?>" title="Edit Tahapan Pelaksanaan"> 
        Mitra Kerja Sama >> </a><br> <a href="index.php?p=131&k=<?php echo $k ?>&q=<?php echo $q ?>&o=<?php echo $o ?>" title="Edit Tahapan Pelaksanaan"> 
        Penerima Manfaat >> </a> </td>
    </tr>
    <tr> 
      <td height="59" class="key">Jadwal Kegiatan</td>
      <td>Waktu Pelaksanaan&nbsp;&nbsp; <input type="text" name="<?php echo $field[14] ?>" value="<?php echo $value[14] ?>" size="5"> 
        &nbsp;&nbsp;Bulan<br> <a href="index.php?p=132&k=<?php echo $k ?>&q=<?php echo $q ?>&o=<?php echo $o ?>" title="Edit Tahapan Pelaksanaan"> 
        Jadwal Pelaksanaan >> </a><br> <a href="index.php?p=133&k=<?php echo $k ?>&q=<?php echo $q ?>&o=<?php echo $o ?>" title="Edit Tahapan Pelaksanaan"> 
        Ukuran Keberhasilan >> </a></td>
    </tr>
    <tr> 
      <td height="21" colspan="2" class="key"><div align="center"><strong>Biaya</strong></div></td>
    </tr>
    <tr> 
      <td height="24" class="key">Total Anggaran Rp.</td>
      <td><input type="text" name="" value="<?php echo number_format($Output_bp['jml_anggaran'],"0",",",".") ?>" size="30" readonly> </td>
    </tr>
    <tr> 
      <td height="21" class="key">Rincian Biaya</td>
      <td><a href="index.php?p=130&o_uk=<?php echo $q ?>&o_bp=<?php echo $o ?>&q=<?php echo '' ?>&ka=<?php echo $k ?>" title="Edit Rincian Biaya"> 
        Rincian Detil >> </a></td>
    </tr>
    <tr> 
      <td height="59" class="key">Rencana Penarikan</td>
      <td><a href="index.php?p=131&k=<?php echo $k ?>&q=<?php echo $q ?>&o=<?php echo $o ?>" title="Edit Rencana Penarikan"> 
        <font color="#99FF33"></font> Rencana Detil >> </a></td>
    </tr>
    <tr> 
      <td>&nbsp;</td>
      <td> <div class="button2-right"> 
          <div class="prev"> <a onclick="Cancel('index.php?p=<?php echo $p_next ?>')">Batal</a> 
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