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
	
	if ( $xlevel == 3 or $xlevel == 4 or $xlevel == 5 or $xlevel == 6 or $xlevel == 7 or $xlevel == 8 )
	{
	$kdsatker = kd_satker($xkdunit) ;
	$sql = "select kdsatker from tb_unitkerja WHERE kdsatker = '$kdsatker' order by kdunit";
	}else{
	$sql = "select kdsatker from tb_unitkerja WHERE kdsatker <> '' order by kdunit";
	}
	
	$aSatker = mysql_query($sql);
	$count = mysql_num_rows($aSatker);
	$jmlh = 0;
	
	while ($Satker = mysql_fetch_array($aSatker))
	{
		$pagu_satker = pagu_satker($th,$Satker['kdsatker']) ;
		if ( $pagu_satker > 0 )
		{
		$col[0][] 	= $Satker['id'];
		$col[1][] 	= $Satker['kdsatker'];
		$col[2][] 	= $pagu_satker ;
		}
	}


?>
<table width="787" cellpadding="1" class="adminlist">
  <thead>
    <tr> 
      <th rowspan="2">Kode APBN</th>
      <th rowspan="2"><font color="#009900">Lembaga</font><br />Satuan Kerja / <br>
        <font color="#0033CC">Kegiatan</font> /<br /><font color="#990033">Output</font></th>
      <th>Total<br />Anggaran</th>
      <th colspan="5">Anggaran Belanja / Blokir </th>
    </tr>
    <tr>
      <th>Blokir</th>
      <th width="10%">Pegawai</th>
      <th width="10%">Barang</th>
      <th width="5%">Modal</th>
      <th width="5%">Perjalanan</th>
      <th width="5%">Sosial</th>
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
		if ($count == 0) 
		{ ?>
    <tr> 
      <td align="center" colspan="13">Tidak ada data!</td>
    </tr>
    <?php
		}
		else {
			foreach ($col[0] as $k=>$val) {
				if ($k % 2 == 1) $class = "row0";
				else $class = "row1"; 
				$kdsatker = $col[1][$k] ;
				?>
    <tr class="<?php echo $class ?>"> 
      <td width="8%" rowspan="2" align="center"><?php echo $col[1][$k] ?></td>
      <td rowspan="2" align="left"><?php echo nm_satker($col[1][$k]) ?></td>
      <td width="9%" align="right"><?php echo number_format($col[2][$k],"0",",",".") ?></td>
      <td align="right"><?php echo number_format(anggaran_belanja_satker($th,$kdsatker,'51'),"0",",",".") ?></td>
      <td align="right"><?php echo number_format(anggaran_belanja_satker($th,$kdsatker,'52'),"0",",",".") ?></td>
      <td align="right"><?php echo number_format(anggaran_belanja_satker($th,$kdsatker,'53'),"0",",",".") ?></td>
      <td align="right"><?php echo number_format(anggaran_belanja_satker($th,$kdsatker,'524'),"0",",",".") ?></td>
      <td align="right"><?php echo number_format(anggaran_belanja_satker($th,$kdsatker,'57'),"0",",",".") ?></td>
    </tr>
    <tr class="<?php echo $class ?>">
      <td align="right"><strong><?php echo number_format(blokir_satker($th,$kdsatker),"0",",",".") ?></strong></td>
      <td align="right"><strong><?php echo number_format(blokir_belanja_satker($th,$kdsatker,'51'),"0",",",".") ?></strong></td>
      <td align="right"><strong><?php echo number_format(blokir_belanja_satker($th,$kdsatker,'52'),"0",",",".") ?></strong></td>
      <td align="right"><strong><?php echo number_format(blokir_belanja_satker($th,$kdsatker,'53'),"0",",",".") ?></strong></td>
      <td align="right"><strong><?php echo number_format(blokir_belanja_satker($th,$kdsatker,'524'),"0",",",".") ?></strong></td>
      <td align="right"><strong><?php echo number_format(blokir_belanja_satker($th,$kdsatker,'57'),"0",",",".") ?></strong></td>
    </tr>
    
    <?php
		}
		} ?>
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

function blokir_satker($th,$kdsatker) {
		$sql = "select sum(RPHBLOKIR) as blokir_satker from d_item where THANG = '$th' and KDSATKER = '$kdsatker' group by KDSATKER"; 
		$data = mysql_query($sql);
		$rdata = mysql_fetch_array($data);
		$result = $rdata['blokir_satker'];
		return $result;
	}
?>