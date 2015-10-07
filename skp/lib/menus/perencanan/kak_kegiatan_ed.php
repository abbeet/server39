<?php
	checkauthentication();
	$table = "thuk_kak_kegiatan";
	$field = get_field($table);
	$err = false;
	$p = $_GET['p'];
	$id = $_GET['id'];
	$q = $_GET['q'];
	
	extract($_POST);
	$xusername_sess = $_SESSION['xusername'];
	
	$oKegiatan_bp = mysql_query("SELECT * FROM thbp_kak_kegiatan WHERE id = '$id' ");
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
				$value[1] = $Kegiatan_bp['th'];
				$value[2] = $Kegiatan_bp['kdunitkerja'];
				$value[3] = $Kegiatan_bp['kdgiat'];
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
				$value[1] = $Kegiatan_bp['th'];
				$value[2] = $Kegiatan_bp['kdunitkerja'];
				$value[3] = $Kegiatan_bp['kdgiat'];
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
      <td width="104" class="key">Tahun</td>
      <td width="608"><strong><?php echo $Kegiatan_bp['th'] ?></strong></td>
    </tr>
    <tr> 
      <td class="key">Unit Kerja </td>
      <td><strong><?php echo nm_unit($Kegiatan_bp['kdunitkerja']) ?></strong></td>
    </tr>
    <tr> 
      <td class="key">Tugas Pokok</td>
      <td><?php echo tugas_unit($Kegiatan_bp['kdunitkerja']) ?></td>
    </tr>
    <tr> 
      <td height="21" class="key">Fungsi</td>
      <td> 
        <?php
	$sql = "SELECT * FROM tb_unitkerja_fungsi WHERE kdunit = '".$Kegiatan_bp[kdunitkerja]."'";
	$oFungsi = mysql_query($sql);
	while ($Fungsi = mysql_fetch_array($oFungsi))
	{ 
	echo $Fungsi['kdfungsi'].". ".$Fungsi['nmfungsi']."<br>";
	}
	?>
      </td>
    </tr>
    <tr> 
      <td class="key">Program</td>
      <td><?php echo nm_program($Kegiatan_bp['kddept'].$Kegiatan_bp['kdunit'].$Kegiatan_bp['kdprogram']) ?></td>
    </tr>
    <tr> 
      <td class="key">Outcome</td>
      <td><?php echo outcome_program($Kegiatan_bp['kddept'].$Kegiatan_bp['kdunit'].$Kegiatan_bp['kdprogram']) ?></td>
    </tr>
    <tr> 
      <td class="key">Tujuan</td>
      <td> 
        <?php
	$sql = "SELECT alasan FROM m_iku_program WHERE kddeputi = '".substr($Kegiatan_bp[kdunitkerja],0,3).'000'."'";
	$oTujuan = mysql_query($sql);
	$n = 0 ;
	while ($Tujuan = mysql_fetch_array($oTujuan))
	{ 
	$n += 1 ;
	echo $n.". ".$Tujuan['alasan']."<br>";
	}
	?>
      </td>
    </tr>
    <tr> 
      <td class="key">Sasaran</td>
      <td><?php echo outcome_deputi(substr($Kegiatan_bp[kdunitkerja],0,3).'000') ?></td>
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
      <td class="key">Kegiatan</td>
      <td><strong><?php echo nm_giat($Kegiatan_bp['kdgiat']) ?></strong></td>
    </tr>
    <tr> 
      <td class="key">IKK</td>
      <td> 
        <?php
	$sql = "SELECT ikk FROM m_ikk_kegiatan WHERE kdgiat = '".$Kegiatan_bp[kdgiat]."'";
	$oIKK = mysql_query($sql);
	$n = 0 ;
	while ($IKK = mysql_fetch_array($oIKK))
	{ 
	$n += 1 ;
	echo $n.". ".$IKK['ikk']."<br>";
	}
	?>
      </td>
    </tr>
    <tr> 
      <td class="key">Pagu Indikatif Kegiatan</td>
      <td><?php echo 'Rp.  '.number_format($Kegiatan_bp['jml_anggaran'],"0",",",".") ?></td>
    </tr>
    <tr> 
      <td class="key">Output</td>
      <td><table width="100%" cellpadding="4" class="adminlist">
          <tr> 
            <td width="13%" align="center">Kode</td>
            <td width="47%" align="center">Output</td>
            <td width="16%" align="center">Volumen</td>
            <td width="24%" align="center">Anggaran</td>
            <td width="24%" align="center">Penanggung<br>
              Jawab</td>
          </tr>
          <?php
	$sql = "SELECT * FROM thbp_kak_output WHERE kdgiat = '".$Kegiatan_bp[kdgiat]."' and th = '". $Kegiatan_bp[th]."' order by kdoutput" ;
	$oOutput = mysql_query($sql);
	$n = 0 ;
	while ($Output = mysql_fetch_array($oOutput))
	{
?>
          <tr> 
            <td><?php echo $Output['kdoutput'] ?></td>
            <td><?php echo nm_output($Output['kdgiat'].$Output['kdoutput']) ?></td>
            <td align="center"><?php echo $Output['volume'].' '.nm_satuan($Output['kdsatuan']) ?></td>
            <td align="right"><?php echo number_format($Output['jml_anggaran'],"0",",",".") ?></td>
            <td align="left"><?php echo $Output['id_pjawab'] ?>&nbsp;</td>
          </tr>
          <?php }?>
        </table></td>
    </tr>
    <tr> 
      <td class="key">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr> 
      <td class="key">Jumlah SDM</td>
      <td><input type="text" name="<?php echo $field[4] ?>" value="<?php echo $value[4] ?>" size="10"> 
        &nbsp;&nbsp;Orang</td>
    </tr>
    <tr> 
      <td class="key">Penanggung Jawab</td>
      <td><input type="text" name="<?php echo $field[5] ?>" value="<?php echo $value[5] ?>" size="60"></td>
    </tr>
    <tr> 
      <td colspan="2" class="key"><div align="center"><strong>Metodologi Kegiatan</strong></div></td>
    </tr>
    <tr> 
      <td colspan="2" class="key"><div align="center"> 
          <textarea name="<?php echo $field[6] ?>" rows="5" cols="90"><?php echo $value[6] ?></textarea>
        </div></td>
    </tr>
    <tr> 
      <td colspan="2" class="key"><div align="center"><strong>Referensi</strong></div></td>
    </tr>
    <tr> 
      <td colspan="2" class="key"><div align="center"> 
          <textarea name="<?php echo $field[7] ?>" rows="5" cols="90"><?php echo $value[7] ?></textarea>
        </div></td>
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