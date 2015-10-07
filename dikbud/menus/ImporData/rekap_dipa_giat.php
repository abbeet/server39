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
?>
<table width="787" cellpadding="1" class="adminlist">
  <thead>
    <tr> 
      <th rowspan="2">Kode APBN</th>
      <th rowspan="2"><font color="#009900">Lembaga</font><br>
        <font color="#0033CC">Kegiatan</font> /<br /><font color="#990033">Output</font></th>
      <th>Total<br />Anggaran</th>
      <th colspan="5">Anggaran Belanja / Blokir </th>
    </tr>
    <tr>
      <th>Blokir</th>
      <th>Pegawai</th>
      <th>Barang</th>
      <th>Modal</th>
      <th>Perjalanan</th>
      <th>Sosial</th>
    </tr>
  </thead>
  <tbody>
    <tr class="row0"> 
	<?php
	$pagu_lembaga = $Menteri['pagu_menteri'] ;
	$pegawai = anggaran_belanja_menteri($th,'51') ;
	$barang = anggaran_belanja_menteri($th,'52') ;
	$modal = anggaran_belanja_menteri($th,'53') ;
	$perjalanan = anggaran_belanja_menteri($th,'524') ;
	$sosial = anggaran_belanja_menteri($th,'57') ;
	$p_pegawai = $pegawai/$pagu_lembaga*100 ;
	$p_barang = $barang/$pagu_lembaga*100 ;
	$p_modal = $modal/$pagu_lembaga*100 ;
	$p_perjalanan = $perjalanan/$pagu_lembaga*100 ;
	$p_sosial = $sosial/$pagu_lembaga*100 ;
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
    </tr>
    <tr class="row0">
      <td align="right"><font color="#009900"><strong><?php echo number_format($Menteri_blokir['blokir_menteri'],"0",",",".") ?></strong></font></td>
      <td align="right"><font color="#009900"><strong><?php echo number_format(blokir_belanja_menteri($th,'51'),"0",",",".") ?></strong></font></td>
      <td align="right"><font color="#009900"><strong><?php echo number_format(blokir_belanja_menteri($th,'52'),"0",",",".") ?></strong></font></td>
      <td align="right"><font color="#009900"><strong><?php echo number_format(blokir_belanja_menteri($th,'53'),"0",",",".") ?></strong></font></td>
      <td align="right"><font color="#009900"><strong><?php echo number_format(blokir_belanja_menteri($th,'524'),"0",",",".") ?></strong></font></td>
      <td align="right"><font color="#009900"><strong><?php echo number_format(blokir_belanja_menteri($th,'57'),"0",",",".") ?></strong></font></td>
    </tr>
    <?php 
	$sql = "select KDGIAT, sum(JUMLAH) as pagu_giat, sum(RPHBLOKIR) as blokir_giat from $table WHERE THANG='$th' group by KDGIAT";
	$aGiat = mysql_query($sql);
	while ($Giat = mysql_fetch_array($aGiat))
	{
	?>
    <tr class="<?php echo $class ?>"> 
      <td rowspan="2" align="center" valign="top"><font color="#0033CC"><?php echo $Giat['KDGIAT'] ?></font></td>
      <td rowspan="2" align="left" valign="top"><font color="#0033CC"><?php echo nm_giat($Giat['KDGIAT']) ?></font></td>
      <td align="right" valign="top"><font color="#0033CC"><?php echo number_format($Giat['pagu_giat'],"0",",",".") ?></font></td>
      <td width="10%" align="right" valign="top"><font color="#0033CC"><?php echo number_format(anggaran_belanja_giat($th,$Giat['KDGIAT'],'51'),"0",",",".") ?></font></td>
      <td width="10%" align="right" valign="top"><font color="#0033CC"><?php echo number_format(anggaran_belanja_giat($th,$Giat['KDGIAT'],'52'),"0",",",".") ?></font></td>
      <td width="5%" align="right" valign="top"><font color="#0033CC"><?php echo number_format(anggaran_belanja_giat($th,$Giat['KDGIAT'],'53'),"0",",",".") ?></font></td>
      <td width="5%" align="right" valign="top"><font color="#0033CC"><?php echo number_format(anggaran_belanja_giat($th,$Giat['KDGIAT'],'524'),"0",",",".") ?></font></td>
      <td width="5%" align="right" valign="top"><font color="#0033CC"><?php echo number_format(anggaran_belanja_giat($th,$Giat['KDGIAT'],'57'),"0",",",".") ?></font></td>
    </tr>
    <tr class="<?php echo $class ?>">
      <td align="right" valign="top"><font color="#0033CC"><?php echo number_format($Giat['blokir_giat'],"0",",",".") ?></font></td>
      <td width="10%" align="right" valign="top"><font color="#0033CC"><?php echo number_format(blokir_belanja_giat($th,$Giat['KDGIAT'],'51'),"0",",",".") ?></font></td>
      <td width="10%" align="right" valign="top"><font color="#0033CC"><?php echo number_format(blokir_belanja_giat($th,$Giat['KDGIAT'],'52'),"0",",",".") ?></font></td>
      <td width="5%" align="right" valign="top"><font color="#0033CC"><?php echo number_format(blokir_belanja_giat($th,$Giat['KDGIAT'],'53'),"0",",",".") ?></font></td>
      <td width="5%" align="right" valign="top"><font color="#0033CC"><?php echo number_format(blokir_belanja_giat($th,$Giat['KDGIAT'],'524'),"0",",",".") ?></font></td>
      <td width="5%" align="right" valign="top"><font color="#0033CC"><?php echo number_format(blokir_belanja_giat($th,$Giat['KDGIAT'],'57'),"0",",",".") ?></font></td>
    </tr>
    <?php 
	$kdsatker = $col[1][$k] ;
	$sql = "select KDOUTPUT, sum(JUMLAH) as pagu_output, sum(RPHBLOKIR) as blokir_output from $table WHERE THANG='$th' and KDGIAT = '$Giat[KDGIAT]' group by KDOUTPUT";
	$aOutput = mysql_query($sql);
	while ($Output = mysql_fetch_array($aOutput))
	{
?>
    <tr class="<?php echo $class ?>">
      <td rowspan="2" align="center" valign="top"><font color="#990033"><?php echo $Output['KDOUTPUT'] ?></font></td>
      <td rowspan="2" align="left" valign="top"><font color="#990033"><?php echo nm_output_th($th,$Giat['KDGIAT'].$Output['KDOUTPUT']) ?></font></td>
      <td align="right" valign="top"><font color="#990033"><?php echo number_format($Output['pagu_output'],"0",",",".") ?></font></td>
      <td align="right" valign="top"><font color="#990033"><?php echo number_format(anggaran_belanja_output($th,$Giat['KDGIAT'],$Output['KDOUTPUT'],'51'),"0",",",".") ?></font></td>
      <td align="right" valign="top"><font color="#990033"><?php echo number_format(anggaran_belanja_output($th,$Giat['KDGIAT'],$Output['KDOUTPUT'],'52'),"0",",",".") ?></font></td>
      <td align="right" valign="top"><font color="#990033"><?php echo number_format(anggaran_belanja_output($th,$Giat['KDGIAT'],$Output['KDOUTPUT'],'53'),"0",",",".") ?></font></td>
      <td align="right" valign="top"><font color="#990033"><?php echo number_format(anggaran_belanja_output($th,$Giat['KDGIAT'],$Output['KDOUTPUT'],'524'),"0",",",".") ?></font></td>
      <td align="right" valign="top"><font color="#990033"><?php echo number_format(anggaran_belanja_output($th,$Giat['KDGIAT'],$Output['KDOUTPUT'],'57'),"0",",",".") ?></font></td>
    </tr>
    <tr class="<?php echo $class ?>">
      <td align="right" valign="top"><font color="#990033"><?php echo number_format($Output['blokir_output'],"0",",",".") ?></font></td>
      <td align="right" valign="top"><font color="#990033"><?php echo number_format(blokir_belanja_output($th,$Giat['KDGIAT'],$Output['KDOUTPUT'],'51'),"0",",",".") ?></font></td>
      <td align="right" valign="top"><font color="#990033"><?php echo number_format(blokir_belanja_output($th,$Giat['KDGIAT'],$Output['KDOUTPUT'],'52'),"0",",",".") ?></font></td>
      <td align="right" valign="top"><font color="#990033"><?php echo number_format(blokir_belanja_output($th,$Giat['KDGIAT'],$Output['KDOUTPUT'],'53'),"0",",",".") ?></font></td>
      <td align="right" valign="top"><font color="#990033"><?php echo number_format(blokir_belanja_output($th,$Giat['KDGIAT'],$Output['KDOUTPUT'],'524'),"0",",",".") ?></font></td>
      <td align="right" valign="top"><font color="#990033"><?php echo number_format(blokir_belanja_output($th,$Giat['KDGIAT'],$Output['KDOUTPUT'],'57'),"0",",",".") ?></font></td>
    </tr>
    <?php
		} # Output
		} # GIAT
		?>
  </tbody>
  <tfoot>
    <tr> 
      <td colspan="10">&nbsp;</td>
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

function anggaran_belanja_giat($th,$kdgiat,$jnsbel) {
		
		switch ( $jnsbel )
		{
			case '51' :
				$sql = "select sum(JUMLAH) as pagu_satker from d_item WHERE THANG='$th'
				AND KDGIAT = '$kdgiat' AND left(KDAKUN,2) = '51' group by KDGIAT";
				break;
			case '52' :
				$sql = "select sum(JUMLAH) as pagu_satker from d_item WHERE THANG='$th' AND 
				KDGIAT = '$kdgiat' AND left(KDAKUN,2) = '52' AND left(KDAKUN,3) <> '524' group by KDGIAT";
				break;
			case '53' :
				$sql = "select sum(JUMLAH) as pagu_satker from d_item WHERE THANG='$th' AND 
				left(KDAKUN,2) = '53' AND KDGIAT = '$kdgiat' group by KDGIAT";
				break;
			case '524' :
				$sql = "select sum(JUMLAH) as pagu_satker from d_item WHERE THANG='$th' AND 
				left(KDAKUN,3) = '524' AND KDGIAT = '$kdgiat' group by KDGIAT";
				break;
			case '57' :
				$sql = "select sum(JUMLAH) as pagu_satker from d_item WHERE THANG='$th' AND 
				left(KDAKUN,2) = '57' AND KDGIAT = '$kdgiat' group by KDGIAT";
				break;
		}	
		$data = mysql_query($sql);
		$rdata = mysql_fetch_array($data);
		$result = $rdata['pagu_satker'];
		return $result;
}

function anggaran_belanja_output($th,$kdgiat,$kdoutput,$jnsbel) {
		
		switch ( $jnsbel )
		{
			case '51' :
				$sql = "select sum(JUMLAH) as pagu_satker from d_item WHERE THANG='$th'  
				AND KDGIAT = '$kdgiat' AND left(KDAKUN,2) = '51' AND KDOUTPUT= '$kdoutput' group by KDOUTPUT";
				break;
			case '52' :
				$sql = "select sum(JUMLAH) as pagu_satker from d_item WHERE THANG='$th' AND 
				KDGIAT = '$kdgiat' AND left(KDAKUN,2) = '52' AND left(KDAKUN,3) <> '524'  AND KDOUTPUT= '$kdoutput' 
				group by KDOUTPUT";
				break;
			case '53' :
				$sql = "select sum(JUMLAH) as pagu_satker from d_item WHERE THANG='$th' AND 
				left(KDAKUN,2) = '53' AND KDGIAT = '$kdgiat'  AND KDOUTPUT= '$kdoutput' group by KDOUTPUT";
				break;
			case '524' :
				$sql = "select sum(JUMLAH) as pagu_satker from d_item WHERE THANG='$th' AND 
				left(KDAKUN,3) = '524' AND KDGIAT = '$kdgiat'  AND KDOUTPUT= '$kdoutput' group by KDOUTPUT";
				break;
			case '57' :
				$sql = "select sum(JUMLAH) as pagu_satker from d_item WHERE THANG='$th' AND 
				left(KDAKUN,2) = '57' AND KDGIAT = '$kdgiat'  AND KDOUTPUT= '$kdoutput' group by KDOUTPUT";
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

function blokir_belanja_giat($th,$kdgiat,$jnsbel) {
		
		switch ( $jnsbel )
		{
			case '51' :
				$sql = "select sum(RPHBLOKIR) as blokir_satker from d_item WHERE THANG='$th'
				AND KDGIAT = '$kdgiat' AND left(KDAKUN,2) = '51' group by KDGIAT";
				break;
			case '52' :
				$sql = "select sum(RPHBLOKIR) as blokir_satker from d_item WHERE THANG='$th' AND 
				KDGIAT = '$kdgiat' AND left(KDAKUN,2) = '52' AND left(KDAKUN,3) <> '524' group by KDGIAT";
				break;
			case '53' :
				$sql = "select sum(RPHBLOKIR) as blokir_satker from d_item WHERE THANG='$th' AND 
				left(KDAKUN,2) = '53' AND KDGIAT = '$kdgiat' group by KDGIAT";
				break;
			case '524' :
				$sql = "select sum(RPHBLOKIR) as pagublokir_satker from d_item WHERE THANG='$th' AND 
				left(KDAKUN,3) = '524' AND KDGIAT = '$kdgiat' group by KDGIAT";
				break;
			case '57' :
				$sql = "select sum(RPHBLOKIR) as blokir_satker from d_item WHERE THANG='$th' AND 
				left(KDAKUN,2) = '57' AND KDGIAT = '$kdgiat' group by KDGIAT";
				break;
		}	
		$data = mysql_query($sql);
		$rdata = mysql_fetch_array($data);
		$result = $rdata['blokir_satker'];
		return $result;
}

function blokir_belanja_output($th,$kdgiat,$kdoutput,$jnsbel) {
		
		switch ( $jnsbel )
		{
			case '51' :
				$sql = "select sum(RPHBLOKIR) as blokir_satker from d_item WHERE THANG='$th'  
				AND KDGIAT = '$kdgiat' AND left(KDAKUN,2) = '51' AND KDOUTPUT= '$kdoutput' group by KDOUTPUT";
				break;
			case '52' :
				$sql = "select sum(RPHBLOKIR) as blokir_satker from d_item WHERE THANG='$th' AND 
				KDGIAT = '$kdgiat' AND left(KDAKUN,2) = '52' AND left(KDAKUN,3) <> '524'  AND KDOUTPUT= '$kdoutput' 
				group by KDOUTPUT";
				break;
			case '53' :
				$sql = "select sum(RPHBLOKIR) as blokir_satker from d_item WHERE THANG='$th' AND 
				left(KDAKUN,2) = '53' AND KDGIAT = '$kdgiat'  AND KDOUTPUT= '$kdoutput' group by KDOUTPUT";
				break;
			case '524' :
				$sql = "select sum(RPHBLOKIR) as blokir_satker from d_item WHERE THANG='$th' AND 
				left(KDAKUN,3) = '524' AND KDGIAT = '$kdgiat'  AND KDOUTPUT= '$kdoutput' group by KDOUTPUT";
				break;
			case '57' :
				$sql = "select sum(RPHBLOKIR) as blokir_satker from d_item WHERE THANG='$th' AND 
				left(KDAKUN,2) = '57' AND KDGIAT = '$kdgiat'  AND KDOUTPUT= '$kdoutput' group by KDOUTPUT";
				break;
		}	
		$data = mysql_query($sql);
		$rdata = mysql_fetch_array($data);
		$result = $rdata['blokir_satker'];
		return $result;
}
?>