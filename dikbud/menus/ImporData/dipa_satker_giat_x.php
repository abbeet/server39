<?php
	checkauthentication();
	$p = $_GET['p'];
	$cari = $_GET['cari'];
	$table = "d_item";
	$field = get_field($table);
	$ed_link = "index.php?p=".get_edit_link($p);
	$del_link = "index.php?p=".get_delete_link($p);
	$th = $_SESSION['xth'];
	$kddept = setup_kddept_keu() ;
	$kdmenteri = setup_kddept_unit().'20000';
	$xlevel = $_SESSION['xlevel'];
	$xkdunit = $_SESSION['xkdunit'];
	$xusername = $_SESSION['xusername'] ;
	
if (isset($_POST["cari"]))
{
   $xkdunit = $_REQUEST['kdunit'];
}
	
	if ( $xlevel <> 3 and $xlevel <> 4 and $xlevel <> 5 and $xlevel <> 6 and $xlevel <> 7 and $xlevel <> 8 )
	{
	//-----------------------------
	$sql_menteri = "select sum(JUMLAH) as pagu_menteri from $table WHERE THANG='$th' AND KDDEPT = '$kddept'";
	$aMenteri = mysql_query($sql_menteri);
	$Menteri = mysql_fetch_array($aMenteri);
	$pegawai = anggaran_belanja_menteri($th,'51');
	if ( $Menteri['pagu_menteri'] <> 0 )   $p_pegawai = ($pegawai/$Menteri['pagu_menteri'])*100 ;
	else   $p_pegawai = 0 ;
	$barang = anggaran_belanja_menteri($th,'52');
	if ( $Menteri['pagu_menteri'] <> 0 )   $p_barang = ($barang/$Menteri['pagu_menteri'])*100 ;
	else   $p_barang = 0 ;
	$modal = anggaran_belanja_menteri($th,'53');
	if ( $Menteri['pagu_menteri'] <> 0 )   $p_modal = ($modal/$Menteri['pagu_menteri'])*100 ;
	else   $p_modal = 0 ;
	$perjalanan = anggaran_belanja_menteri($th,'524');
	if ( $Menteri['pagu_menteri'] <> 0 )   $p_perjalanan = ($perjalanan/$Menteri['pagu_menteri'])*100 ;
	else   $p_perjalanan = 0 ;

	$sql_menteri_blokir = "select sum(RPHBLOKIR) as blokir_menteri from $table WHERE THANG='$th' AND KDDEPT = '$kddept'";
	$aMenteri_blokir = mysql_query($sql_menteri_blokir);
	$Menteri_blokir = mysql_fetch_array($aMenteri_blokir);
	
	} #---------------------------
	
	$kdsatker = kd_satker($xkdunit) ;
	$sql = "select kdsatker from tb_unitkerja WHERE kdsatker = '$kdsatker' group by kdsatker";
	
	$aSatker = mysql_query($sql);
	$count = 0;
	$count = mysql_num_rows($aSatker);
	
	
	while ($Satker = mysql_fetch_array($aSatker))
	{
		$pagu_satker = pagu_satker($th,$Satker['kdsatker']) ;
		//echo 'pagu-'.$pagu_satker ;
		//if ( $pagu_satker > 0 )
		//{
		$col[1][] 	= $Satker['kdsatker'];
		$col[2][] 	= $pagu_satker ;
		$col[3][] 	= blokir_satker($th,$Satker['kdsatker']) ;
		//}else{
		//$count = 0 ;
		//}
	}

?>
<div align="right">
	<form action="" method="post">
		<input type="hidden" name="p" value="<?php echo $p; ?>" />
		Satker : 
		<select name="kdunit">
                      <option value="<?php echo $xkdunit ?>"><?php echo  nm_unit($xkdunit) ?></option>
                      <option value="">- Pilih Satker Mandiri -</option>
                    <?php
	switch ($xlevel)
	{
		case '1':
			$query = mysql_query("select * from tb_unitkerja where kdsatker <> '' order by kdunit");
			break;
		case '3':
			$kdsatker = kd_satker($xkdunit) ;
			$query = mysql_query("select * from tb_unitkerja where kdunit = '$xkdunit' order by kdunit");
			break;
		case '4':
			$query = mysql_query("select * from tb_unitkerja where kdunit = '$xkdunit' order by kdunit");
			break;
		case '5':
			$query = mysql_query("select * from tb_unitkerja where kdunit = '$xkdunit' order by kdunit");
			break;
		case '6':
			$query = mysql_query("select * from tb_unitkerja where kdunit = '$xkdunit' order by kdunit");
			break;
		case '7':
			$query = mysql_query("select * from tb_unitkerja where kdunit = '$xkdunit' order by kdunit");
			break;
		case '8':
			$query = mysql_query("select * from tb_unitkerja where kdunit = '$xkdunit' order by kdunit");
			break;
		default:
			$query = mysql_query("select * from tb_unitkerja where kdsatker <> '' order by kdunit");
			break;
	}
						while($row = mysql_fetch_array($query)) { ?>
                      <option value="<?php echo $row['kdunit'] ?>"><?php echo  trim($row['nmunit']); ?></option>
                    <?php
					} ?>	
	  </select>
		<input type="submit" value="Tampilkan" name="cari"/>
	</form>
</div> 
<br />
<table width="787" cellpadding="1" class="adminlist">
  <thead>
    <tr> 
      <th rowspan="2">Kode APBN</th>
      <th rowspan="2"><font color="#009900">Lembaga</font><br />Satuan Kerja / <br>
        <font color="#0033CC">Kegiatan</font> /<br /><font color="#990033">Output</font></th>
      <th>Total<br />Anggaran</th>
      <th colspan="5">Anggaran Belanja / Blokir </th>
      <th>Jml. Penarikan</th>
    </tr>
    <tr>
      <th>Blokir</th>
      <th>Pegawai</th>
      <th>Barang</th>
      <th>Modal</th>
      <th>Perjalanan</th>
      <th>Sosial</th>
      <th>Detil</th>
    </tr>
  </thead>
  <tbody>
    <tr class="row0"> 
	<?php
	if ( $xlevel <> 3 and $xlevel <> 4 and $xlevel <> 5 and $xlevel <> 6 and $xlevel <> 7 and $xlevel <> 8 )
	{
	//-----------------------------

	$sql = "select 	sum(RPHPAGU) as RPHPAGU,
					sum(JML01) as JML01,
					sum(JML01+JML02) as JML02,
					sum(JML01+JML02+JML03) as JML03,
					sum(JML01+JML02+JML03+JML04) as JML04,
					sum(JML01+JML02+JML03+JML04+JML05) as JML05,
					sum(JML01+JML02+JML03+JML04+JML05+JML06) as JML06,
					sum(JML01+JML02+JML03+JML04+JML05+JML06+JML07) as JML07,
					sum(JML01+JML02+JML03+JML04+JML05+JML06+JML07+JML08) as JML08,
					sum(JML01+JML02+JML03+JML04+JML05+JML06+JML07+JML08+JML09) as JML09,
					sum(JML01+JML02+JML03+JML04+JML05+JML06+JML07+JML08+JML09+JML10) as JML10,
					sum(JML01+JML02+JML03+JML04+JML05+JML06+JML07+JML08+JML09+JML10+JML11) as JML11,
					sum(JML01+JML02+JML03+JML04+JML05+JML06+JML07+JML08+JML09+JML10+JML11+JML12) as JML12
					from d_trktrm WHERE THANG='$th' group by THANG";
	$aTarik = mysql_query($sql);
	$Tarik = mysql_fetch_array($aTarik);
	
	$pagu_lembaga = $Menteri['pagu_menteri'] ;
	$pegawai = anggaran_belanja_menteri($th,'51') ;
	$barang = anggaran_belanja_menteri($th,'52') ;
	$modal = anggaran_belanja_menteri($th,'53') ;
	$perjalanan = anggaran_belanja_menteri($th,'524') ;
	$sosial = anggaran_belanja_menteri($th,'57') ;
	if ( $pagu_lembaga <> 0 )   $p_pegawai = $pegawai/$pagu_lembaga*100 ;
	else $p_pegawai = 0 ;
	if ( $pagu_lembaga <> 0 )   $p_barang = $barang/$pagu_lembaga*100 ;
	else $p_barang = 0 ;
	if ( $pagu_lembaga <> 0 )   $p_modal = $modal/$pagu_lembaga*100 ;
	else $p_modal = 0 ;
	if ( $pagu_lembaga <> 0 )   $p_perjalanan = $perjalanan/$pagu_lembaga*100 ;
	else $p_perjalanan = 0 ;
	if ( $pagu_lembaga <> 0 )   $p_sosial = $sosial/$pagu_lembaga*100 ;
	else $p_sosial = 0 ;
	?>
      <td width="8%" rowspan="2" align="center"><font color="#009900"><strong><?php echo $kddept ?></strong></font></td>
      <td rowspan="2" align="left"><font color="#009900"><strong><?php echo strtoupper(nm_unit($kdmenteri)) ?></strong></font></td>
      <td width="9%" align="right"><font color="#009900"><strong><?php echo number_format($Menteri['pagu_menteri'],"0",",",".") ?></strong></font></td>
      <td align="right"><font color="#009900"><strong><?php echo number_format($pegawai,"0",",",".") ?><br />
	  <?php echo number_format($p_pegawai,"2",",",".").' %' ?></strong></font></td>
      <td align="right"><font color="#009900"><strong><?php echo number_format($barang,"0",",",".") ?><br />
	  				<?php echo number_format($p_barang,"2",",",".").' %' ?></strong></font></td>
      <td align="right"><font color="#009900"><strong><?php echo number_format($modal,"0",",",".") ?><br />
	  				<?php echo number_format($p_modal,"2",",",".").' %' ?></strong></font></td>
      <td align="right"><font color="#009900"><strong><?php echo number_format($perjalanan,"0",",",".") ?><br />
	  				<?php echo number_format($p_perjalanan,"2",",",".").' %' ?></strong></font></td>
      <td align="right"><font color="#009900"><strong><?php echo number_format($sosial,"0",",",".") ?><br />
	  				<?php echo number_format($p_sosial,"2",",",".").' %' ?></strong></font></td>
      <td align="center" valign="top"><font color="#009900"><strong><?php echo number_format($Tarik['JML12'],"0",",",".") ?></strong></font>
	  <?php if ( $Menteri['pagu_menteri'] <> $Tarik['JML12'] )
	  {
	  		echo '<font color="#FF0000"><br>Tidak Valid</font>' ;
	  } ?>
	  </td>
    </tr>
    <tr class="row0">
      <td align="right" class="row7"><font color="#009900"><strong><?php echo number_format($Menteri_blokir['blokir_menteri'],"0",",",".") ?></strong></font></td>
      <td align="right"><font color="#009900"><strong><?php echo number_format(blokir_belanja_menteri($th,'51'),"0",",",".") ?></strong></font></td>
      <td align="right"><font color="#009900"><strong><?php echo number_format(blokir_belanja_menteri($th,'52'),"0",",",".") ?></strong></font></td>
      <td align="right"><font color="#009900"><strong><?php echo number_format(blokir_belanja_menteri($th,'53'),"0",",",".") ?></strong></font></td>
      <td align="right"><font color="#009900"><strong><?php echo number_format(blokir_belanja_menteri($th,'524'),"0",",",".") ?></strong></font></td>
      <td align="right"><font color="#009900"><strong><?php echo number_format(blokir_belanja_menteri($th,'57'),"0",",",".") ?></strong></font></td>
      <td align="center" valign="top"><a href="index.php?p=457&th=<?php echo $th ?>" title="Penarikan Detil"><font color="#009900" size="1">[Penarikan]</font></a>&nbsp;
	  <!--a href="menus/ImporData/penarikan_menteri_grafik.php?th=<?php echo $th ?>" title="Grafik Rencana Penarikan" target="_blank"><img src="css/images/chart.jpg" border="0" width="16" height="16"></a-->	  </td>
    </tr>
    <?php
		} #-------------------------------  AKHIR UNTUK SATKER
		if ($count == 0) 
		{ ?>
    <tr> 
      <td align="center" colspan="14">Tidak ada data!</td>
    </tr>
    <?php
		}
		else {
			foreach ($col[1] as $k=>$val) {
				if ($k % 2 == 1) $class = "row0";
				else $class = "row1"; ?>
    <tr class="<?php echo $class ?>"> 
      <td width="8%" rowspan="2" align="center"><strong><?php echo $col[1][$k] ?></strong></td>
      <td rowspan="2" align="left"><strong><?php echo nm_satker($col[1][$k]) ?></strong></td>
      <td width="9%" align="right"><strong><?php echo number_format($col[2][$k],"0",",",".") ?></strong></td>
      <td align="right"><strong><?php echo number_format(anggaran_belanja_satker($th,$col[1][$k],'51'),"0",",",".") ?></strong></td>
      <td align="right"><strong><?php echo number_format(anggaran_belanja_satker($th,$col[1][$k],'52'),"0",",",".") ?></strong></td>
      <td align="right"><strong><?php echo number_format(anggaran_belanja_satker($th,$col[1][$k],'53'),"0",",",".") ?></strong></td>
      <td align="right"><strong><?php echo number_format(anggaran_belanja_satker($th,$col[1][$k],'524'),"0",",",".") ?></strong></td>
      <td align="right"><strong><?php echo number_format(anggaran_belanja_satker($th,$col[1][$k],'57'),"0",",",".") ?></strong></td>
      <td rowspan="2" align="center" valign="top"><a href="index.php?p=461&kdsatker=<?php echo $col[1][$k] ?>&th=<?php echo $th ?>" title="Penarikan Detil"><strong><font color="#000000" size="1">[Penarikan]</font></strong>&nbsp;
	  <!--a href="menus/ImporData/penarikan_satker_grafik.php?th=<?php echo $th ?>&kdsatker=<?php echo $col[1][$k] ?>" title="Grafik Rencana Penarikan" target="_blank"><img src="css/images/chart.jpg" border="0" width="16" height="16"></a--></td>
    </tr>
    <tr class="<?php echo $class ?>">
      <td align="right"><strong><?php echo number_format($col[3][$k],"0",",",".") ?></strong></td>
      <td align="right"><strong><?php echo number_format(blokir_belanja_satker($th,$col[1][$k],'51'),"0",",",".") ?></strong></td>
      <td align="right"><strong><?php echo number_format(blokir_belanja_satker($th,$col[1][$k],'52'),"0",",",".") ?></strong></td>
      <td align="right"><strong><?php echo number_format(blokir_belanja_satker($th,$col[1][$k],'53'),"0",",",".") ?></strong></td>
      <td align="right"><strong><?php echo number_format(blokir_belanja_satker($th,$col[1][$k],'524'),"0",",",".") ?></strong></td>
      <td align="right"><strong><?php echo number_format(blokir_belanja_satker($th,$col[1][$k],'57'),"0",",",".") ?></strong></td>
    </tr>
    <?php 
	$kdsatker = $col[1][$k] ;
	$sql = "select KDGIAT, sum(JUMLAH) as pagu_giat, sum(RPHBLOKIR) as blokir_giat from $table WHERE THANG='$th' and KDSATKER='$kdsatker' group by KDGIAT";
	$aGiat = mysql_query($sql);
	while ($Giat = mysql_fetch_array($aGiat))
	{
?>
    <tr class="<?php echo $class ?>"> 
      <td rowspan="2" align="center" valign="top"><font color="#0033CC"><?php echo $Giat['KDGIAT'] ?></font></td>
      <td rowspan="2" align="left" valign="top"><font color="#0033CC"><?php echo nm_giat($Giat['KDGIAT']) ?></font></td>
      <td align="right" valign="top"><font color="#0033CC"><?php echo number_format($Giat['pagu_giat'],"0",",",".") ?></font></td>
      <td width="10%" align="right" valign="top"><font color="#0033CC"><?php echo number_format(anggaran_belanja_giat($th,$col[1][$k],$Giat['KDGIAT'],'51'),"0",",",".") ?></font></td>
      <td width="10%" align="right" valign="top"><font color="#0033CC"><?php echo number_format(anggaran_belanja_giat($th,$col[1][$k],$Giat['KDGIAT'],'52'),"0",",",".") ?></font></td>
      <td width="5%" align="right" valign="top"><font color="#0033CC"><?php echo number_format(anggaran_belanja_giat($th,$col[1][$k],$Giat['KDGIAT'],'53'),"0",",",".") ?></font></td>
      <td width="5%" align="right" valign="top"><font color="#0033CC"><?php echo number_format(anggaran_belanja_giat($th,$col[1][$k],$Giat['KDGIAT'],'524'),"0",",",".") ?></font></td>
      <td width="5%" align="right" valign="top"><font color="#0033CC"><?php echo number_format(anggaran_belanja_giat($th,$col[1][$k],$Giat['KDGIAT'],'57'),"0",",",".") ?></font></td>
      <td width="11%" rowspan="2" align="center" valign="top">
	  <a href="index.php?p=406&kdsatker=<?php echo $col[1][$k] ?>&th=<?php echo $th ?>&kdgiat=<?php echo $Giat['KDGIAT'] ?>" title="DIPA Detil"><font size="1">[DIPA Detil]</font></a>
	  <br /><a href="index.php?p=407&kdsatker=<?php echo $col[1][$k] ?>&th=<?php echo $th ?>&kdgiat=<?php echo $Giat['KDGIAT'] ?>" title="POK Detil"><font size="1">[POK Detil]</font></a>
	  <br /><a href="index.php?p=408&kdsatker=<?php echo $col[1][$k] ?>&th=<?php echo $th ?>&kdgiat=<?php echo $Giat['KDGIAT'] ?>" title="Penarikan Detil"><font size="1">[Penarikan]</font></a>&nbsp;
	  <!--a href="menus/ImporData/penarikan_giat_grafik.php?th=<?php echo $th ?>&kdgiat=<?php echo $Giat['KDGIAT'] ?>" title="Grafik Rencana Penarikan" target="_blank"><img src="css/images/chart.jpg" border="0" width="16" height="16"></a--></td>
    </tr>
    <tr class="<?php echo $class ?>">
      <td align="right" valign="top"><font color="#0033CC"><?php echo number_format($Giat['blokir_giat'],"0",",",".") ?></font></td>
      <td width="10%" align="right" valign="top"><font color="#0033CC"><?php echo number_format(blokir_belanja_giat($th,$col[1][$k],$Giat['KDGIAT'],'51'),"0",",",".") ?></font></td>
      <td width="10%" align="right" valign="top"><font color="#0033CC"><?php echo number_format(blokir_belanja_giat($th,$col[1][$k],$Giat['KDGIAT'],'52'),"0",",",".") ?></font></td>
      <td width="5%" align="right" valign="top"><font color="#0033CC"><?php echo number_format(blokir_belanja_giat($th,$col[1][$k],$Giat['KDGIAT'],'53'),"0",",",".") ?></font></td>
      <td width="5%" align="right" valign="top"><font color="#0033CC"><?php echo number_format(blokir_belanja_giat($th,$col[1][$k],$Giat['KDGIAT'],'524'),"0",",",".") ?></font></td>
      <td width="5%" align="right" valign="top"><font color="#0033CC"><?php echo number_format(blokir_belanja_giat($th,$col[1][$k],$Giat['KDGIAT'],'57'),"0",",",".") ?></font></td>
    </tr>
    <?php 
	$kdsatker = $col[1][$k] ;
	$sql = "select KDOUTPUT, sum(JUMLAH) as pagu_output, sum(RPHBLOKIR) as blokir_output from $table WHERE THANG='$th' and KDSATKER='$kdsatker' and KDGIAT = '$Giat[KDGIAT]' group by KDOUTPUT";
	$aOutput = mysql_query($sql);
	while ($Output = mysql_fetch_array($aOutput))
	{
?>
    <tr class="<?php echo $class ?>">
      <td rowspan="2" align="center" valign="top"><font color="#990033"><?php echo $Output['KDOUTPUT'] ?></font></td>
      <td rowspan="2" align="left" valign="top"><font color="#990033"><?php echo nm_output_th($th,$Giat['KDGIAT'].$Output['KDOUTPUT']) ?></font></td>
      <td align="right" valign="top"><font color="#990033"><?php echo number_format($Output['pagu_output'],"0",",",".") ?></font></td>
      <td align="right" valign="top"><font color="#990033"><?php echo number_format(anggaran_belanja_output($th,$col[1][$k],$Giat['KDGIAT'],$Output['KDOUTPUT'],'51'),"0",",",".") ?></font></td>
      <td align="right" valign="top"><font color="#990033"><?php echo number_format(anggaran_belanja_output($th,$col[1][$k],$Giat['KDGIAT'],$Output['KDOUTPUT'],'52'),"0",",",".") ?></font></td>
      <td align="right" valign="top"><font color="#990033"><?php echo number_format(anggaran_belanja_output($th,$col[1][$k],$Giat['KDGIAT'],$Output['KDOUTPUT'],'53'),"0",",",".") ?></font></td>
      <td align="right" valign="top"><font color="#990033"><?php echo number_format(anggaran_belanja_output($th,$col[1][$k],$Giat['KDGIAT'],$Output['KDOUTPUT'],'524'),"0",",",".") ?></font></td>
      <td align="right" valign="top"><font color="#990033"><?php echo number_format(anggaran_belanja_output($th,$col[1][$k],$Giat['KDGIAT'],$Output['KDOUTPUT'],'57'),"0",",",".") ?></font></td>
      <td rowspan="2" align="center" valign="top">
<a href="index.php?p=455&kdsatker=<?php echo $col[1][$k] ?>&th=<?php echo $th ?>&kdgiat=<?php echo $Giat['KDGIAT'] ?>&kdoutput=<?php echo $Output['KDOUTPUT'] ?>" title="DIPA Detil"><font size="1" color="#990033">[DIPA Detil]</font></a>
	  <br /><a href="index.php?p=456&kdsatker=<?php echo $col[1][$k] ?>&th=<?php echo $th ?>&kdgiat=<?php echo $Giat['KDGIAT'] ?>&kdoutput=<?php echo $Output['KDOUTPUT'] ?>" title="POK Detil"><font size="1" color="#990033">[POK Detil]</font></a>	 	  </td>
    </tr>
    <tr class="<?php echo $class ?>">
      <td align="right" valign="top"><font color="#990033"><?php echo number_format($Output['blokir_output'],"0",",",".") ?></font></td>
      <td align="right" valign="top"><font color="#990033"><?php echo number_format(blokir_belanja_output($th,$col[1][$k],$Giat['KDGIAT'],$Output['KDOUTPUT'],'51'),"0",",",".") ?></font></td>
      <td align="right" valign="top"><font color="#990033"><?php echo number_format(blokir_belanja_output($th,$col[1][$k],$Giat['KDGIAT'],$Output['KDOUTPUT'],'52'),"0",",",".") ?></font></td>
      <td align="right" valign="top"><font color="#990033"><?php echo number_format(blokir_belanja_output($th,$col[1][$k],$Giat['KDGIAT'],$Output['KDOUTPUT'],'53'),"0",",",".") ?></font></td>
      <td align="right" valign="top"><font color="#990033"><?php echo number_format(blokir_belanja_output($th,$col[1][$k],$Giat['KDGIAT'],$Output['KDOUTPUT'],'524'),"0",",",".") ?></font></td>
      <td align="right" valign="top"><font color="#990033"><?php echo number_format(blokir_belanja_output($th,$col[1][$k],$Giat['KDGIAT'],$Output['KDOUTPUT'],'57'),"0",",",".") ?></font></td>
    </tr>
    <?php
		} # Output
		} # GIAT
		}
		} ?>
  </tbody>
  <tfoot>
    <tr> 
      <td colspan="11">&nbsp;</td>
    </tr>
  </tfoot>
</table>
<?php 
function anggaran_belanja_menteri($th,$jnsbel) {
		
		switch ( $jnsbel )
		{
			case '51' :
				$sql = "select sum(JUMLAH) as pagu_satker from d_item WHERE THANG='$th' AND
				left(KDAKUN,2) = '51' AND KDDEPT = '023' group by THANG";
				break;
			case '52' :
				$sql = "select sum(JUMLAH) as pagu_satker from d_item WHERE THANG='$th' AND left(KDAKUN,2) = '52' 
				AND left(KDAKUN,3) <> '524' AND KDDEPT = '023' group by THANG";
				break;
			case '53' :
				$sql = "select sum(JUMLAH) as pagu_satker from d_item WHERE THANG='$th' AND
				left(KDAKUN,2) = '53' AND KDDEPT = '023' group by THANG";
				break;
			case '524' :
				$sql = "select sum(JUMLAH) as pagu_satker from d_item WHERE THANG='$th' AND 
				left(KDAKUN,3) = '524' AND KDDEPT = '023' group by THANG";
				break;
			case '57' :
				$sql = "select sum(JUMLAH) as pagu_satker from d_item WHERE THANG='$th' AND
				left(KDAKUN,2) = '57' AND KDDEPT = '023' group by THANG";
				break;
		}	
		$data = mysql_query($sql);
		$rdata = mysql_fetch_array($data);
		$result = $rdata['pagu_satker'];
		return $result;
}

function anggaran_belanja_satker($th,$kdsatker,$jnsbel) {
		
		switch ( $jnsbel )
		{
			case '51' :
				$sql = "select sum(JUMLAH) as pagu_satker from d_item WHERE THANG='$th' AND KDSATKER = '$kdsatker' AND 
				left(KDAKUN,2) = '51' group by KDSATKER";
				break;
			case '52' :
				$sql = "select sum(JUMLAH) as pagu_satker from d_item WHERE THANG='$th' AND KDSATKER = '$kdsatker' AND 
				left(KDAKUN,2) = '52' AND left(KDAKUN,3) <> '524' group by KDSATKER";
				break;
			case '53' :
				$sql = "select sum(JUMLAH) as pagu_satker from d_item WHERE THANG='$th' AND KDSATKER = '$kdsatker' AND 
				left(KDAKUN,2) = '53' group by KDSATKER";
				break;
			case '524' :
				$sql = "select sum(JUMLAH) as pagu_satker from d_item WHERE THANG='$th' AND KDSATKER = '$kdsatker' AND 
				left(KDAKUN,3) = '524' group by KDSATKER";
				break;
			case '57' :
				$sql = "select sum(JUMLAH) as pagu_satker from d_item WHERE THANG='$th' AND KDSATKER = '$kdsatker' AND 
				left(KDAKUN,2) = '57' group by KDSATKER";
				break;
		}	
		$data = mysql_query($sql);
		$rdata = mysql_fetch_array($data);
		$result = $rdata['pagu_satker'];
		return $result;
}
function anggaran_belanja_giat($th,$kdsatker,$kdgiat,$jnsbel) {
		
		switch ( $jnsbel )
		{
			case '51' :
				$sql = "select sum(JUMLAH) as pagu_satker from d_item WHERE THANG='$th' AND KDSATKER = '$kdsatker' 
				AND KDGIAT = '$kdgiat' AND left(KDAKUN,2) = '51' group by KDSATKER,KDGIAT";
				break;
			case '52' :
				$sql = "select sum(JUMLAH) as pagu_satker from d_item WHERE THANG='$th' AND KDSATKER = '$kdsatker' AND 
				KDGIAT = '$kdgiat' AND left(KDAKUN,2) = '52' AND left(KDAKUN,3) <> '524' group by KDSATKER,KDGIAT";
				break;
			case '53' :
				$sql = "select sum(JUMLAH) as pagu_satker from d_item WHERE THANG='$th' AND KDSATKER = '$kdsatker' AND 
				left(KDAKUN,2) = '53' AND KDGIAT = '$kdgiat' group by KDSATKER,KDGIAT";
				break;
			case '524' :
				$sql = "select sum(JUMLAH) as pagu_satker from d_item WHERE THANG='$th' AND KDSATKER = '$kdsatker' AND 
				left(KDAKUN,3) = '524' AND KDGIAT = '$kdgiat' group by KDSATKER,KDGIAT";
				break;
			case '57' :
				$sql = "select sum(JUMLAH) as pagu_satker from d_item WHERE THANG='$th' AND KDSATKER = '$kdsatker' AND 
				left(KDAKUN,2) = '57' AND KDGIAT = '$kdgiat' group by KDSATKER,KDGIAT";
				break;
		}	
		$data = mysql_query($sql);
		$rdata = mysql_fetch_array($data);
		$result = $rdata['pagu_satker'];
		return $result;
}

function anggaran_belanja_output($th,$kdsatker,$kdgiat,$kdoutput,$jnsbel) {
		
		switch ( $jnsbel )
		{
			case '51' :
				$sql = "select sum(JUMLAH) as pagu_satker from d_item WHERE THANG='$th' AND KDSATKER = '$kdsatker' 
				AND KDGIAT = '$kdgiat' AND left(KDAKUN,2) = '51' AND KDOUTPUT= '$kdoutput' group by KDSATKER,KDGIAT,KDOUTPUT";
				break;
			case '52' :
				$sql = "select sum(JUMLAH) as pagu_satker from d_item WHERE THANG='$th' AND KDSATKER = '$kdsatker' AND 
				KDGIAT = '$kdgiat' AND left(KDAKUN,2) = '52' AND left(KDAKUN,3) <> '524'  AND KDOUTPUT= '$kdoutput' 
				group by KDSATKER,KDGIAT,KDOUTPUT";
				break;
			case '53' :
				$sql = "select sum(JUMLAH) as pagu_satker from d_item WHERE THANG='$th' AND KDSATKER = '$kdsatker' AND 
				left(KDAKUN,2) = '53' AND KDGIAT = '$kdgiat'  AND KDOUTPUT= '$kdoutput' group by KDSATKER,KDGIAT,KDOUTPUT";
				break;
			case '524' :
				$sql = "select sum(JUMLAH) as pagu_satker from d_item WHERE THANG='$th' AND KDSATKER = '$kdsatker' AND 
				left(KDAKUN,3) = '524' AND KDGIAT = '$kdgiat'  AND KDOUTPUT= '$kdoutput' group by KDSATKER,KDGIAT,KDOUTPUT";
				break;
			case '57' :
				$sql = "select sum(JUMLAH) as pagu_satker from d_item WHERE THANG='$th' AND KDSATKER = '$kdsatker' AND 
				left(KDAKUN,2) = '57' AND KDGIAT = '$kdgiat'  AND KDOUTPUT= '$kdoutput' group by KDSATKER,KDGIAT,KDOUTPUT";
				break;
		}	
		$data = mysql_query($sql);
		$rdata = mysql_fetch_array($data);
		$result = $rdata['pagu_satker'];
		return $result;
}

function blokir_belanja_menteri($th,$jnsbel) {
		
		switch ( $jnsbel )
		{
			case '51' :
				$sql = "select sum(RPHBLOKIR) as blokir_satker from d_item WHERE THANG='$th' AND
				left(KDAKUN,2) = '51' AND KDDEPT = '023' group by THANG";
				break;
			case '52' :
				$sql = "select sum(RPHBLOKIR) as blokir_satker from d_item WHERE THANG='$th' AND left(KDAKUN,2) = '52' 
				AND left(KDAKUN,3) <> '524' AND KDDEPT = '023' group by THANG";
				break;
			case '53' :
				$sql = "select sum(RPHBLOKIR) as blokir_satker from d_item WHERE THANG='$th' AND
				left(KDAKUN,2) = '53' AND KDDEPT = '023' group by THANG";
				break;
			case '524' :
				$sql = "select sum(RPHBLOKIR) as blokir_satker from d_item WHERE THANG='$th' AND 
				left(KDAKUN,3) = '524' AND KDDEPT = '023' group by THANG";
				break;
			case '57' :
				$sql = "select sum(RPHBLOKIR) as blokir_satker from d_item WHERE THANG='$th' AND
				left(KDAKUN,2) = '57' AND KDDEPT = '023' group by THANG";
				break;
		}	
		$data = mysql_query($sql);
		$rdata = mysql_fetch_array($data);
		$result = $rdata['blokir_satker'];
		return $result;
}

function blokir_belanja_satker($th,$kdsatker,$jnsbel) {
		
		switch ( $jnsbel )
		{
			case '51' :
				$sql = "select sum(RPHBLOKIR) as blokir_satker from d_item WHERE THANG='$th' AND KDSATKER = '$kdsatker' AND 
				left(KDAKUN,2) = '51' group by KDSATKER";
				break;
			case '52' :
				$sql = "select sum(RPHBLOKIR) as blokir_satker from d_item WHERE THANG='$th' AND KDSATKER = '$kdsatker' AND 
				left(KDAKUN,2) = '52' AND left(KDAKUN,3) <> '524' group by KDSATKER";
				break;
			case '53' :
				$sql = "select sum(RPHBLOKIR) as blokir_satker from d_item WHERE THANG='$th' AND KDSATKER = '$kdsatker' AND 
				left(KDAKUN,2) = '53' group by KDSATKER";
				break;
			case '524' :
				$sql = "select sum(RPHBLOKIR) as blokir_satker from d_item WHERE THANG='$th' AND KDSATKER = '$kdsatker' AND 
				left(KDAKUN,3) = '524' group by KDSATKER";
				break;
			case '57' :
				$sql = "select sum(RPHBLOKIR) as blokir_satker from d_item WHERE THANG='$th' AND KDSATKER = '$kdsatker' AND 
				left(KDAKUN,2) = '57' group by KDSATKER";
				break;
		}	
		$data = mysql_query($sql);
		$rdata = mysql_fetch_array($data);
		$result = $rdata['blokir_satker'];
		return $result;
}
function blokir_belanja_giat($th,$kdsatker,$kdgiat,$jnsbel) {
		
		switch ( $jnsbel )
		{
			case '51' :
				$sql = "select sum(RPHBLOKIR) as blokir_satker from d_item WHERE THANG='$th' AND KDSATKER = '$kdsatker' 
				AND KDGIAT = '$kdgiat' AND left(KDAKUN,2) = '51' group by KDSATKER,KDGIAT";
				break;
			case '52' :
				$sql = "select sum(RPHBLOKIR) as blokir_satker from d_item WHERE THANG='$th' AND KDSATKER = '$kdsatker' AND 
				KDGIAT = '$kdgiat' AND left(KDAKUN,2) = '52' AND left(KDAKUN,3) <> '524' group by KDSATKER,KDGIAT";
				break;
			case '53' :
				$sql = "select sum(RPHBLOKIR) as blokir_satker from d_item WHERE THANG='$th' AND KDSATKER = '$kdsatker' AND 
				left(KDAKUN,2) = '53' AND KDGIAT = '$kdgiat' group by KDSATKER,KDGIAT";
				break;
			case '524' :
				$sql = "select sum(RPHBLOKIR) as blokir_satker from d_item WHERE THANG='$th' AND KDSATKER = '$kdsatker' AND 
				left(KDAKUN,3) = '524' AND KDGIAT = '$kdgiat' group by KDSATKER,KDGIAT";
				break;
			case '57' :
				$sql = "select sum(RPHBLOKIR) as blokir_satker from d_item WHERE THANG='$th' AND KDSATKER = '$kdsatker' AND 
				left(KDAKUN,2) = '57' AND KDGIAT = '$kdgiat' group by KDSATKER,KDGIAT";
				break;
		}	
		$data = mysql_query($sql);
		$rdata = mysql_fetch_array($data);
		$result = $rdata['blokir_satker'];
		return $result;
}

function blokir_belanja_output($th,$kdsatker,$kdgiat,$kdoutput,$jnsbel) {
		
		switch ( $jnsbel )
		{
			case '51' :
				$sql = "select sum(RPHBLOKIR) as blokir_satker from d_item WHERE THANG='$th' AND KDSATKER = '$kdsatker' 
				AND KDGIAT = '$kdgiat' AND left(KDAKUN,2) = '51' AND KDOUTPUT= '$kdoutput' group by KDSATKER,KDGIAT,KDOUTPUT";
				break;
			case '52' :
				$sql = "select sum(RPHBLOKIR) as blokir_satker from d_item WHERE THANG='$th' AND KDSATKER = '$kdsatker' AND 
				KDGIAT = '$kdgiat' AND left(KDAKUN,2) = '52' AND left(KDAKUN,3) <> '524'  AND KDOUTPUT= '$kdoutput' 
				group by KDSATKER,KDGIAT,KDOUTPUT";
				break;
			case '53' :
				$sql = "select sum(RPHBLOKIR) as blokir_satker from d_item WHERE THANG='$th' AND KDSATKER = '$kdsatker' AND 
				left(KDAKUN,2) = '53' AND KDGIAT = '$kdgiat'  AND KDOUTPUT= '$kdoutput' group by KDSATKER,KDGIAT,KDOUTPUT";
				break;
			case '524' :
				$sql = "select sum(RPHBLOKIR) as blokir_satker from d_item WHERE THANG='$th' AND KDSATKER = '$kdsatker' AND 
				left(KDAKUN,3) = '524' AND KDGIAT = '$kdgiat'  AND KDOUTPUT= '$kdoutput' group by KDSATKER,KDGIAT,KDOUTPUT";
				break;
			case '57' :
				$sql = "select sum(RPHBLOKIR) as blokir_satker from d_item WHERE THANG='$th' AND KDSATKER = '$kdsatker' AND 
				left(KDAKUN,2) = '57' AND KDGIAT = '$kdgiat'  AND KDOUTPUT= '$kdoutput' group by KDSATKER,KDGIAT,KDOUTPUT";
				break;
		}	
		$data = mysql_query($sql);
		$rdata = mysql_fetch_array($data);
		$result = $rdata['blokir_satker'];
		return $result;
}

	function blokir_satker($th,$kdsatker) {
		$sql = "select sum(RPHBLOKIR) as blokir_satker from d_item where THANG = '$th' and KDSATKER = '$kdsatker' group by KDSATKER"; 
		$data = mysql_query($sql);
		$rdata = mysql_fetch_array($data);
		$result = $rdata['blokir_satker'];
		return $result;
	}
?>