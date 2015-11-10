<?php
	checkauthentication();
	$p = $_GET['p'];
	$cari = $_GET['cari'];
	$table = "d_item";
	$field = get_field($table);
	$ed_link = "index.php?p=".get_edit_link($p);
	$del_link = "index.php?p=".get_delete_link($p);
	$kddept = setup_kddept_keu() ;
	$kdunit = setup_kdunit_keu() ;
	$xlevel = $_SESSION['xlevel'];
	$xkdunit = $_SESSION['xkdunit'];
	$xusername = $_SESSION['xusername'] ;
	$th = $_SESSION['xth'];

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
		$col[1][] 	= $Satker['kdsatker'];
		$col[2][] 	= $pagu_satker ;
		}
	}
	
?>
<table width="787" cellpadding="1" class="adminlist">
  <thead>
    <tr>
      <th rowspan="2">Unit Eselon II</th> 
      <th rowspan="2">Kode APBN</th>
      <th rowspan="2"><font color="#006600">Lembaga</font><br />Nama Satuan Kerja / <br>
        <font color="#0000FF">Nama Kegiatan</font> / <br /><font color="#993333">Output</font></th>
      <th rowspan="2">Pagu</th>
      <th colspan="13">Realisasi dan Rencana Penarikan (dalam juta rupiah)<br />
        ( s/d Bulan Ke ) </th>
      <th width="5%" rowspan="2">Sisa Anggaran</th>
    </tr>
    
    <tr>
      <th>1</th>
      <th>2</th>
      <th>3 </th>
      <th>4 </th>
      <th>5</th>
      <th>6</th>
      <th>7</th>
      <th>8</th>
      <th>9</th>
      <th>10</th>
      <th>11</th>
      <th>12</th>
      <th width="2%">(%)</th>
    </tr>
  </thead>
  <tbody>
  <?php 
if ( $xlevel <> 3 and $xlevel <> 4 and $xlevel <> 5 and $xlevel <> 6 and $xlevel <> 7 and $xlevel <> 8 )
	{
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
	$pagu_menteri = pagu_menteri($th)/1000000 ;
	$real_menteri_bulan_1 = real_menteri_spm_sdbulan($th,$kddept,$kdunit,1)/1000000 ;
	$real_menteri_bulan_2 = real_menteri_spm_sdbulan($th,$kddept,$kdunit,2)/1000000 ;
	$real_menteri_bulan_3 = real_menteri_spm_sdbulan($th,$kddept,$kdunit,3)/1000000 ;
	$real_menteri_bulan_4 = real_menteri_spm_sdbulan($th,$kddept,$kdunit,4)/1000000 ;
	$real_menteri_bulan_5 = real_menteri_spm_sdbulan($th,$kddept,$kdunit,5)/1000000 ;
	$real_menteri_bulan_6 = real_menteri_spm_sdbulan($th,$kddept,$kdunit,6)/1000000 ;
	$real_menteri_bulan_7 = real_menteri_spm_sdbulan($th,$kddept,$kdunit,7)/1000000 ;
	$real_menteri_bulan_8 = real_menteri_spm_sdbulan($th,$kddept,$kdunit,8)/1000000 ;
	$real_menteri_bulan_9 = real_menteri_spm_sdbulan($th,$kddept,$kdunit,9)/1000000 ;
	$real_menteri_bulan_10 = real_menteri_spm_sdbulan($th,$kddept,$kdunit,10)/1000000 ;
	$real_menteri_bulan_11 = real_menteri_spm_sdbulan($th,$kddept,$kdunit,11)/1000000 ;
	$real_menteri_bulan_12 = real_menteri_spm_sdbulan($th,$kddept,$kdunit,12)/1000000 ;
  ?>
    <tr>
      <td rowspan="2" align="center">&nbsp;</td>
      <td rowspan="2" align="center"><font color="#009900"><strong><?php echo '023' ?></strong></font></td>
      <td rowspan="2" align="left"><font color="#009900"><strong><?php echo strtoupper(nm_unit('2320000')) ?></strong></font></td>
      <td rowspan="2" align="right"><font color="#009900"><strong><?php echo number_format($pagu_menteri,"0",",",".") ?></strong></font></td>
      <td align="right" valign="top"><font color="#009900"><strong><?php echo number_format($real_menteri_bulan_1,"0",",",".") ?></strong></font></td>
      <td align="right" valign="top"><?php if ( $real_menteri_bulan_2 <> $real_menteri_bulan_1 ) { ?><font color="#009900"><strong><?php echo number_format($real_menteri_bulan_2,"0",",",".") ?></strong></font><?php } ?></td>
      <td align="right" valign="top"><?php if ( $real_menteri_bulan_3 <> $real_menteri_bulan_2 ) { ?><font color="#009900"><strong><?php echo number_format($real_menteri_bulan_3,"0",",",".") ?></strong></font><?php } ?></td>
      <td align="right" valign="top"><?php if ( $real_menteri_bulan_4 <> $real_menteri_bulan_3 ) { ?><font color="#009900"><strong><?php echo number_format($real_menteri_bulan_4,"0",",",".") ?></strong></font><?php } ?></td>
      <td align="right" valign="top"><?php if ( $real_menteri_bulan_5 <> $real_menteri_bulan_4 ) { ?><font color="#009900"><strong><?php echo number_format($real_menteri_bulan_5,"0",",",".") ?></strong></font><?php } ?></td>
      <td align="right" valign="top"><?php if ( $real_menteri_bulan_6 <> $real_menteri_bulan_5 ) { ?><font color="#009900"><strong><?php echo number_format($real_menteri_bulan_6,"0",",",".") ?></strong></font><?php } ?></td>
      <td align="right" valign="top"><?php if ( $real_menteri_bulan_7 <> $real_menteri_bulan_6 ) { ?><font color="#009900"><strong><?php echo number_format($real_menteri_bulan_7,"0",",",".") ?></strong></font><?php } ?></td>
      <td align="right" valign="top"><?php if ( $real_menteri_bulan_8 <> $real_menteri_bulan_7 ) { ?><font color="#009900"><strong><?php echo number_format($real_menteri_bulan_8,"0",",",".") ?></strong></font><?php } ?></td>
      <td align="right" valign="top"><?php if ( $real_menteri_bulan_9 <> $real_menteri_bulan_8 ) { ?><font color="#009900"><strong><?php echo number_format($real_menteri_bulan_9,"0",",",".") ?></strong></font><?php } ?></td>
      <td align="right" valign="top"><?php if ( $real_menteri_bulan_10 <> $real_menteri_bulan_9 ) { ?><font color="#009900"><strong><?php echo number_format($real_menteri_bulan_10,"0",",",".") ?></strong></font><?php } ?></td>
      <td align="right" valign="top"><?php if ( $real_menteri_bulan_11 <> $real_menteri_bulan_10 ) { ?><font color="#009900"><strong><?php echo number_format($real_menteri_bulan_11,"0",",",".") ?></strong></font><?php } ?></td>
      <td align="right" valign="top"><?php if ( $real_menteri_bulan_12 <> $real_menteri_bulan_11 ) { ?><font color="#009900"><strong><?php echo number_format($real_menteri_bulan_12,"0",",",".") ?></strong></font><?php } ?></td>
      <td rowspan="2" align="center"><font color="#009900"><strong><?php echo number_format($real_menteri_bulan_12/$pagu_menteri*100,"2",",",".") ?></strong></font></td>
      <td rowspan="2" align="right"><font color="#009900"><strong><?php echo number_format($pagu_menteri-$real_menteri_bulan_12,"0",",",".") ?></strong></font></td>
    </tr>
    <tr>
      <td align="right" valign="top" class="row6"><font color="#009900"><strong><?php echo number_format($Tarik['JML01']/1000000,"0",",",".") ?></strong></font></td>
      <td align="right" valign="top" class="row6"><font color="#009900"><strong><?php echo number_format($Tarik['JML02']/1000000,"0",",",".") ?></strong></font></td>
      <td align="right" valign="top" class="row6"><font color="#009900"><strong><?php echo number_format($Tarik['JML03']/1000000,"0",",",".") ?></strong></font></td>
      <td align="right" valign="top" class="row6"><font color="#009900"><strong><?php echo number_format($Tarik['JML04']/1000000,"0",",",".") ?></strong></font></td>
      <td align="right" valign="top" class="row6"><font color="#009900"><strong><?php echo number_format($Tarik['JML05']/1000000,"0",",",".") ?></strong></font></td>
      <td align="right" valign="top" class="row6"><font color="#009900"><strong><?php echo number_format($Tarik['JML06']/1000000,"0",",",".") ?></strong></font></td>
      <td align="right" valign="top" class="row6"><font color="#009900"><strong><?php echo number_format($Tarik['JML07']/1000000,"0",",",".") ?></strong></font></td>
      <td align="right" valign="top" class="row6"><font color="#009900"><strong><?php echo number_format($Tarik['JML08']/1000000,"0",",",".") ?></strong></font></td>
      <td align="right" valign="top" class="row6"><font color="#009900"><strong><?php echo number_format($Tarik['JML09']/1000000,"0",",",".") ?></strong></font></td>
      <td align="right" valign="top" class="row6"><font color="#009900"><strong><?php echo number_format($Tarik['JML10']/1000000,"0",",",".") ?></strong></font></td>
      <td align="right" valign="top" class="row6"><font color="#009900"><strong><?php echo number_format($Tarik['JML11']/1000000,"0",",",".") ?></strong></font></td>
      <td align="right" valign="top" class="row6"><font color="#009900"><strong><?php echo number_format($Tarik['JML12']/1000000,"0",",",".") ?></strong></font></td>
    </tr>
    <?php
	} # endif satker
		if ($count == 0) 
		{ ?>
    <tr> 
      <td align="center" colspan="18">Tidak ada data!</td>
    </tr>
    <?php
		}
		else {
			foreach ($col[1] as $k=>$val) {
				if ($k % 2 == 1) $class = "row0";
				else $class = "row0"; ?>
    <tr class="<?php echo $class ?>">
      <td width="6%" rowspan="2" align="center">&nbsp;</td> 
	<?php 
	$kdsatker = $col[1][$k] ;
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
					from d_trktrm WHERE THANG='$th' AND KDSATKER = '$kdsatker' group by KDSATKER";
	$aTarik = mysql_query($sql);
	$Tarik = mysql_fetch_array($aTarik);
	$real_satker_bulan_1 = real_satker_spm_sdbulan($th,$col[1][$k],1)/1000000 ;
	$real_satker_bulan_2 = real_satker_spm_sdbulan($th,$col[1][$k],2)/1000000 ;
	$real_satker_bulan_3 = real_satker_spm_sdbulan($th,$col[1][$k],3)/1000000 ;
	$real_satker_bulan_4 = real_satker_spm_sdbulan($th,$col[1][$k],4)/1000000 ;
	$real_satker_bulan_5 = real_satker_spm_sdbulan($th,$col[1][$k],5)/1000000 ;
	$real_satker_bulan_6 = real_satker_spm_sdbulan($th,$col[1][$k],6)/1000000 ;
	$real_satker_bulan_7 = real_satker_spm_sdbulan($th,$col[1][$k],7)/1000000 ;
	$real_satker_bulan_8 = real_satker_spm_sdbulan($th,$col[1][$k],8)/1000000 ;
	$real_satker_bulan_9 = real_satker_spm_sdbulan($th,$col[1][$k],9)/1000000 ;
	$real_satker_bulan_10 = real_satker_spm_sdbulan($th,$col[1][$k],10)/1000000 ;
	$real_satker_bulan_11 = real_satker_spm_sdbulan($th,$col[1][$k],11)/1000000 ;
	$real_satker_bulan_12 = real_satker_spm_sdbulan($th,$col[1][$k],12)/1000000;
	?>
      <td width="6%" rowspan="2" align="center"><strong><?php echo $col[1][$k] ?></strong></td>
      <td width="54%" rowspan="2" align="left"><strong><?php echo nm_satker($col[1][$k]) ?></strong></td>
      <td width="12%" rowspan="2" align="right"><strong><?php echo number_format($col[2][$k]/1000000,"0",",",".") ?></strong></td>
      <td width="11%" align="right" valign="top"><strong><?php echo number_format($real_satker_bulan_1,"0",",",".") ?></strong></td>
      <td width="11%" align="right" valign="top"><?php if ( $real_satker_bulan_2 <> $real_satker_bulan_1 ) { ?><strong><?php echo number_format($real_satker_bulan_2,"0",",",".") ?></strong><?php } ?></td>
      <td width="7%" align="right" valign="top"><?php if ( $real_satker_bulan_3 <> $real_satker_bulan_2 ) { ?><strong><?php echo number_format($real_satker_bulan_3,"0",",",".") ?></strong><?php } ?></td>
      <td width="7%" align="right" valign="top"><?php if ( $real_satker_bulan_4 <> $real_satker_bulan_3 ) { ?><strong><?php echo number_format($real_satker_bulan_4,"0",",",".") ?></strong><?php } ?></td>
      <td width="7%" align="right" valign="top"><?php if ( $real_satker_bulan_5 <> $real_satker_bulan_4 ) { ?><strong><?php echo number_format($real_satker_bulan_5,"0",",",".") ?></strong><?php } ?></td>
      <td width="7%" align="right" valign="top"><?php if ( $real_satker_bulan_6 <> $real_satker_bulan_5 ) { ?><strong><?php echo number_format($real_satker_bulan_6,"0",",",".") ?></strong><?php } ?></td>
      <td width="7%" align="right" valign="top"><?php if ( $real_satker_bulan_7 <> $real_satker_bulan_6 ) { ?><strong><?php echo number_format($real_satker_bulan_7,"0",",",".") ?></strong><?php } ?></td>
      <td width="7%" align="right" valign="top"><?php if ( $real_satker_bulan_8 <> $real_satker_bulan_7 ) { ?><strong><?php echo number_format($real_satker_bulan_8,"0",",",".") ?></strong><?php } ?></td>
      <td width="7%" align="right" valign="top"><?php if ( $real_satker_bulan_9 <> $real_satker_bulan_8 ) { ?><strong><?php echo number_format($real_satker_bulan_9,"0",",",".") ?></strong><?php } ?></td>
      <td width="7%" align="right" valign="top"><?php if ( $real_satker_bulan_10 <> $real_satker_bulan_9 ) { ?><strong><?php echo number_format($real_satker_bulan_10,"0",",",".") ?></strong><?php } ?></td>
      <td width="7%" align="right" valign="top"><?php if ( $real_satker_bulan_11 <> $real_satker_bulan_10 ) { ?><strong><?php echo number_format($real_satker_bulan_11,"0",",",".") ?></strong><?php } ?></td>
      <td width="7%" align="center" valign="top"><?php if ( $real_satker_bulan_12 <> $real_satker_bulan_11 ) { ?><strong><?php echo number_format($real_satker_bulan_12,"0",",",".") ?></strong><?php } ?></td>
      <td rowspan="2" align="center"><strong><?php echo number_format($real_satker_bulan_12/($col[2][$k]/1000000)*100,"2",",",".") ?></strong></td>
      <td rowspan="2" align="right"><strong><?php echo number_format(($col[2][$k]/1000000)-$real_satker_bulan_12,"0",",",".") ?></strong></td>
    </tr>
    <tr>
      <td align="right" valign="top" class="row6"><strong><?php echo number_format($Tarik['JML01']/1000000,"0",",",".") ?></strong></td>
      <td width="11%" align="right" valign="top" class="row6"><strong><?php echo number_format($Tarik['JML02']/1000000,"0",",",".") ?></strong></td>
      <td width="7%" align="right" valign="top" class="row6"><strong><?php echo number_format($Tarik['JML03']/1000000,"0",",",".") ?></strong></td>
      <td width="7%" align="right" valign="top" class="row6"><strong><?php echo number_format($Tarik['JML04']/1000000,"0",",",".") ?></strong></td>
      <td width="7%" align="right" valign="top" class="row6"><strong><?php echo number_format($Tarik['JML05']/1000000,"0",",",".") ?></strong></td>
      <td width="7%" align="right" valign="top" class="row6"><strong><?php echo number_format($Tarik['JML06']/1000000,"0",",",".") ?></strong></td>
      <td width="7%" align="right" valign="top" class="row6"><strong><?php echo number_format($Tarik['JML07']/1000000,"0",",",".") ?></strong></td>
      <td width="7%" align="right" valign="top" class="row6"><strong><?php echo number_format($Tarik['JML08']/1000000,"0",",",".") ?></strong></td>
      <td width="7%" align="right" valign="top" class="row6"><strong><?php echo number_format($Tarik['JML09']/1000000,"0",",",".") ?></strong></td>
      <td width="7%" align="right" valign="top" class="row6"><strong><?php echo number_format($Tarik['JML10']/1000000,"0",",",".") ?></strong></td>
      <td width="7%" align="right" valign="top" class="row6"><strong><?php echo number_format($Tarik['JML11']/1000000,"0",",",".") ?></strong></td>
      <td width="7%" align="center" valign="top" class="row6"><strong><?php echo number_format($Tarik['JML12']/1000000,"0",",",".") ?></strong></td>
    </tr>
    <?php 
	$kdsatker = $col[1][$k] ;
	$sql = "select KDGIAT,sum(JUMLAH) as pagu_giat from $table WHERE THANG = '$th' and KDSATKER = '$kdsatker' group by KDGIAT order by KDGIAT";
	$aGiat = mysql_query($sql);
	while ($Giat = mysql_fetch_array($aGiat))
	{
	$real_giat_bulan_1 = real_giat_spm_sdbulan($th,$kdsatker,$Giat['KDGIAT'],1)/1000000 ;
	$real_giat_bulan_2 = real_giat_spm_sdbulan($th,$kdsatker,$Giat['KDGIAT'],2)/1000000 ;
	$real_giat_bulan_3 = real_giat_spm_sdbulan($th,$kdsatker,$Giat['KDGIAT'],3)/1000000 ;
	$real_giat_bulan_4 = real_giat_spm_sdbulan($th,$kdsatker,$Giat['KDGIAT'],4)/1000000 ;
	$real_giat_bulan_5 = real_giat_spm_sdbulan($th,$kdsatker,$Giat['KDGIAT'],5)/1000000 ;
	$real_giat_bulan_6 = real_giat_spm_sdbulan($th,$kdsatker,$Giat['KDGIAT'],6)/1000000 ;
	$real_giat_bulan_7 = real_giat_spm_sdbulan($th,$kdsatker,$Giat['KDGIAT'],7)/1000000 ;
	$real_giat_bulan_8 = real_giat_spm_sdbulan($th,$kdsatker,$Giat['KDGIAT'],8)/1000000 ;
	$real_giat_bulan_9 = real_giat_spm_sdbulan($th,$kdsatker,$Giat['KDGIAT'],9)/1000000 ;
	$real_giat_bulan_10 = real_giat_spm_sdbulan($th,$kdsatker,$Giat['KDGIAT'],10)/1000000 ;
	$real_giat_bulan_11 = real_giat_spm_sdbulan($th,$kdsatker,$Giat['KDGIAT'],11)/1000000 ;
	$real_giat_bulan_12 = real_giat_spm_sdbulan($th,$kdsatker,$Giat['KDGIAT'],12)/1000000 ;
	$kdgiat = $Giat['KDGIAT'] ;
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
					from d_trktrm WHERE THANG='$th' AND KDSATKER = '$kdsatker' AND KDGIAT = '$kdgiat' group by KDGIAT";
	$aTarik = mysql_query($sql);
	$Tarik = mysql_fetch_array($aTarik);
?>
    <tr class="<?php echo $class ?>">
      <td rowspan="2" align="left" valign="top"><?php if ( $Giat['kdunitkerja'] <> $kdunitkerja ) { ?><font color="#0000FF"><?php echo strtoupper(nm_unit($Giat['kdunitkerja'])) ?></font><?php }?></td> 
      <td rowspan="2" align="center"><font color="#0000FF"><?php echo $Giat['KDGIAT'] ?></font></td>
      <td rowspan="2" align="left" valign="top"><font color="#0000FF"><?php echo nm_giat($Giat['KDGIAT']) ?></font></td>
      <td rowspan="2" align="right"><font color="#0000FF"><?php echo number_format($Giat['pagu_giat']/1000000,"0",",",".") ?></font></td>
      <td align="right" valign="top"><font color="#0000FF"><?php echo number_format($real_giat_bulan_1,"0",",",".") ?></font></td>
      <td align="right" valign="top"><?php if ( $real_giat_bulan_2 <> $real_giat_bulan_1 ) { ?><font color="#0000FF"><?php echo number_format($real_giat_bulan_2,"0",",",".") ?></font><?php } ?></td>
      <td align="right" valign="top"><?php if ( $real_giat_bulan_3 <> $real_giat_bulan_2 ) { ?><font color="#0000FF"><?php echo number_format($real_giat_bulan_3,"0",",",".") ?></font><?php } ?></td>
      <td align="right" valign="top"><?php if ( $real_giat_bulan_4 <> $real_giat_bulan_3 ) { ?><font color="#0000FF"><?php echo number_format($real_giat_bulan_4,"0",",",".") ?></font><?php } ?></td>
      <td align="right" valign="top"><?php if ( $real_giat_bulan_5 <> $real_giat_bulan_4 ) { ?><font color="#0000FF"><?php echo number_format($real_giat_bulan_5,"0",",",".") ?></font><?php } ?></td>
      <td align="right" valign="top"><?php if ( $real_giat_bulan_6 <> $real_giat_bulan_5 ) { ?><font color="#0000FF"><?php echo number_format($real_giat_bulan_6,"0",",",".") ?></font><?php } ?></td>
      <td align="right" valign="top"><?php if ( $real_giat_bulan_7 <> $real_giat_bulan_6 ) { ?><font color="#0000FF"><?php echo number_format($real_giat_bulan_7,"0",",",".") ?></font><?php } ?></td>
      <td align="right" valign="top"><?php if ( $real_giat_bulan_8 <> $real_giat_bulan_7 ) { ?><font color="#0000FF"><?php echo number_format($real_giat_bulan_8,"0",",",".") ?></font><?php } ?></td>
      <td align="right" valign="top"><?php if ( $real_giat_bulan_9 <> $real_giat_bulan_8 ) { ?><font color="#0000FF"><?php echo number_format($real_giat_bulan_9,"0",",",".") ?></font><?php } ?></td>
      <td align="right" valign="top"><?php if ( $real_giat_bulan_10 <> $real_giat_bulan_9 ) { ?><font color="#0000FF"><?php echo number_format($real_giat_bulan_10,"0",",",".") ?></font><?php } ?></td>
      <td align="right" valign="top"><?php if ( $real_giat_bulan_11 <> $real_giat_bulan_10 ) { ?><font color="#0000FF"><?php echo number_format($real_giat_bulan_11,"0",",",".") ?></font><?php } ?></td>
      <td align="right" valign="top"><?php if ( $real_giat_bulan_12 <> $real_giat_bulan_11 ) { ?><font color="#0000FF"><?php echo number_format($real_giat_bulan_12,"0",",",".") ?></font><?php } ?></td>
      <td rowspan="2" align="center"><font color="#0000FF"><?php echo number_format($real_giat_bulan_12/($Giat['pagu_giat']/1000000)*100,"2",",",".") ?></font></td>
      <td rowspan="2" align="right"><font color="#0000FF"><?php echo number_format(($Giat['pagu_giat']/1000000)-$real_giat_bulan_12,"0",",",".") ?></font></td>
    </tr>
    <tr>
      <td align="right" valign="top" class="row6"><font color="#0000FF"><?php echo number_format($Tarik['JML01']/1000000,"0",",",".") ?></font></td>
      <td align="right" valign="top" class="row6"><font color="#0000FF"><?php echo number_format($Tarik['JML02']/1000000,"0",",",".") ?></font></td>
      <td align="right" valign="top" class="row6"><font color="#0000FF"><?php echo number_format($Tarik['JML03']/1000000,"0",",",".") ?></font></td>
      <td align="right" valign="top" class="row6"><font color="#0000FF"><?php echo number_format($Tarik['JML04']/1000000,"0",",",".") ?></font></td>
      <td align="right" valign="top" class="row6"><font color="#0000FF"><?php echo number_format($Tarik['JML05']/1000000,"0",",",".") ?></font></td>
      <td align="right" valign="top" class="row6"><font color="#0000FF"><?php echo number_format($Tarik['JML06']/1000000,"0",",",".") ?></font></td>
      <td align="right" valign="top" class="row6"><font color="#0000FF"><?php echo number_format($Tarik['JML07']/1000000,"0",",",".") ?></font></td>
      <td align="right" valign="top" class="row6"><font color="#0000FF"><?php echo number_format($Tarik['JML08']/1000000,"0",",",".") ?></font></td>
      <td align="right" valign="top" class="row6"><font color="#0000FF"><?php echo number_format($Tarik['JML09']/1000000,"0",",",".") ?></font></td>
      <td align="right" valign="top" class="row6"><font color="#0000FF"><?php echo number_format($Tarik['JML10']/1000000,"0",",",".") ?></font></td>
      <td align="right" valign="top" class="row6"><font color="#0000FF"><?php echo number_format($Tarik['JML11']/1000000,"0",",",".") ?></font></td>
      <td align="right" valign="top" class="row6"><font color="#0000FF"><?php echo number_format($Tarik['JML12']/1000000,"0",",",".") ?></font></td>
    </tr>
    <?php 
	$kdunitkerja = $Giat['kdunitkerja'] ;
	$sql = "select KDOUTPUT, sum(jumlah) as pagu_output from $table WHERE THANG='$th' and KDSATKER='$kdsatker' and KDGIAT = '$Giat[KDGIAT]' group by KDOUTPUT";
	$aOutput = mysql_query($sql);
	while ($Output = mysql_fetch_array($aOutput))
	{
	$real_output_bulan_1 = real_output_spm_sdbulan($th,$kdsatker,$Giat['KDGIAT'],$Output['KDOUTPUT'],1)/1000000 ;
	$real_output_bulan_2 = real_output_spm_sdbulan($th,$kdsatker,$Giat['KDGIAT'],$Output['KDOUTPUT'],2)/1000000 ;
	$real_output_bulan_3 = real_output_spm_sdbulan($th,$kdsatker,$Giat['KDGIAT'],$Output['KDOUTPUT'],3)/1000000 ;
	$real_output_bulan_4 = real_output_spm_sdbulan($th,$kdsatker,$Giat['KDGIAT'],$Output['KDOUTPUT'],4)/1000000 ;
	$real_output_bulan_5 = real_output_spm_sdbulan($th,$kdsatker,$Giat['KDGIAT'],$Output['KDOUTPUT'],5)/1000000 ;
	$real_output_bulan_6 = real_output_spm_sdbulan($th,$kdsatker,$Giat['KDGIAT'],$Output['KDOUTPUT'],6)/1000000 ;
	$real_output_bulan_7 = real_output_spm_sdbulan($th,$kdsatker,$Giat['KDGIAT'],$Output['KDOUTPUT'],7)/1000000 ;
	$real_output_bulan_8 = real_output_spm_sdbulan($th,$kdsatker,$Giat['KDGIAT'],$Output['KDOUTPUT'],8)/1000000 ;
	$real_output_bulan_9 = real_output_spm_sdbulan($th,$kdsatker,$Giat['KDGIAT'],$Output['KDOUTPUT'],9)/1000000 ;
	$real_output_bulan_10 = real_output_spm_sdbulan($th,$kdsatker,$Giat['KDGIAT'],$Output['KDOUTPUT'],10)/1000000 ;
	$real_output_bulan_11 = real_output_spm_sdbulan($th,$kdsatker,$Giat['KDGIAT'],$Output['KDOUTPUT'],11)/1000000 ;
	$real_output_bulan_12 = real_output_spm_sdbulan($th,$kdsatker,$Giat['KDGIAT'],$Output['KDOUTPUT'],12)/1000000 ;
?>
    <tr class="<?php echo $class ?>">
      <td align="center" valign="top">&nbsp;</td>
      <td align="center" valign="top"><font color="#993333"><?php echo $Output['KDOUTPUT'] ?></font></td>
      <td align="left" valign="top"><font color="#993333"><?php echo nm_output_th($th,$Giat['KDGIAT'].$Output['KDOUTPUT']) ?></font></td>
      <td align="right" valign="top"><font color="#993333"><?php echo number_format($Output['pagu_output']/1000000,"0",",",".") ?></font></td>
      <td align="right" valign="top"><font color="#993333"><?php echo number_format($real_output_bulan_1,"0",",",".") ?></font></td>
      <td align="right" valign="top"><?php if ( $real_output_bulan_2 <> $real_output_bulan_1 ) { ?><font color="#993333"><?php echo number_format($real_output_bulan_2,"0",",",".") ?></font><?php } ?></td>
      <td align="right" valign="top"><?php if ( $real_output_bulan_3 <> $real_output_bulan_2 ) { ?><font color="#993333"><?php echo number_format($real_output_bulan_3,"0",",",".") ?></font><?php } ?></td>
      <td align="right" valign="top"><?php if ( $real_output_bulan_4 <> $real_output_bulan_3 ) { ?><font color="#993333"><?php echo number_format($real_output_bulan_4,"0",",",".") ?></font><?php } ?></td>
      <td align="right" valign="top"><?php if ( $real_output_bulan_5 <> $real_output_bulan_4 ) { ?><font color="#993333"><?php echo number_format($real_output_bulan_5,"0",",",".") ?></font><?php } ?></td>
      <td align="right" valign="top"><?php if ( $real_output_bulan_6 <> $real_output_bulan_5 ) { ?><font color="#993333"><?php echo number_format($real_output_bulan_6,"0",",",".") ?></font><?php } ?></td>
      <td align="right" valign="top"><?php if ( $real_output_bulan_7 <> $real_output_bulan_6 ) { ?><font color="#993333"><?php echo number_format($real_output_bulan_7,"0",",",".") ?></font><?php } ?></td>
      <td align="right" valign="top"><?php if ( $real_output_bulan_8 <> $real_output_bulan_7 ) { ?><font color="#993333"><?php echo number_format($real_output_bulan_8,"0",",",".") ?></font><?php } ?></td>
      <td align="right" valign="top"><?php if ( $real_output_bulan_9 <> $real_output_bulan_8 ) { ?><font color="#993333"><?php echo number_format($real_output_bulan_9,"0",",",".") ?></font><?php } ?></td>
      <td align="right" valign="top"><?php if ( $real_output_bulan_10 <> $real_output_bulan_9 ) { ?><font color="#993333"><?php echo number_format($real_output_bulan_10,"0",",",".") ?></font><?php } ?></td>
      <td align="right" valign="top"><?php if ( $real_output_bulan_11 <> $real_output_bulan_10 ) { ?><font color="#993333"><?php echo number_format($real_output_bulan_11,"0",",",".") ?></font><?php } ?></td>
      <td align="right" valign="top"><?php if ( $real_output_bulan_12 <> $real_output_bulan_11 ) { ?><font color="#993333"><?php echo number_format($real_output_bulan_12,"0",",",".") ?></font><?php } ?></td>
      <td align="center" valign="top"><font color="#993333"><?php echo number_format($real_output_bulan_12/($Output['pagu_output']/1000000)*100,"2",",",".") ?></font></td>
      <td align="right" valign="top"><font color="#993333"><?php echo number_format(($Output['pagu_output']/1000000)-$real_output_bulan_12,"0",",",".") ?></font></td>
    </tr>
    <?php
		} # OUTPUT
		} # GIAT
		}
		} ?>
  </tbody>
  <tfoot>
    <tr> 
      <td colspan="18">&nbsp;</td>
    </tr>
  </tfoot>
</table>
