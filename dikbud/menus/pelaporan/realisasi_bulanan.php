<?php
	checkauthentication();
	$p = $_GET['p'];
	$cari = $_GET['cari'];
	$table = "d_item";
	$field = get_field($table);
	$ed_link = "index.php?p=".get_edit_link($p);
	$del_link = "index.php?p=".get_delete_link($p);
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
      <th rowspan="3">Kode APBN</th>
      <th rowspan="3"><font color="#006600">Lembaga</font><br />Nama Satuan Kerja / <br>
        <font color="#0000FF">Nama Kegiatan</font> / <br /><font color="#993333">Output</font></th>
      <th rowspan="3">Pagu</th>
      <th colspan="14">Realisasi dan Rencana Penarikan<br />( Bulanan ) </th>
      <th width="5%" rowspan="3">Sisa Anggaran</th>
    </tr>
    <tr>
      <th rowspan="2">1</th>
      <th rowspan="2">2</th>
      <th rowspan="2">3 </th>
      <th rowspan="2">4 </th>
      <th rowspan="2">5</th>
      <th rowspan="2">6</th>
      <th rowspan="2">7</th>
      <th rowspan="2">8</th>
      <th rowspan="2">9</th>
      <th rowspan="2">10</th>
      <th rowspan="2">11</th>
      <th rowspan="2">12</th>
      <th colspan="2">Total Realisasi </th>
    </tr>
    <tr>
      <th width="3%">Rupiah</th>
      <th width="2%">(%)</th>
    </tr>
  </thead>
  <tbody>
  <?php 
if ( $xlevel <> 3 and $xlevel <> 4 and $xlevel <> 5 and $xlevel <> 6 and $xlevel <> 7 and $xlevel <> 8 )
	{
	$sql = "select 	sum(RPHPAGU) as RPHPAGU,
					sum(JML01) as JML01,
					sum(JML02) as JML02,
					sum(JML03) as JML03,
					sum(JML04) as JML04,
					sum(JML05) as JML05,
					sum(JML06) as JML06,
					sum(JML07) as JML07,
					sum(JML08) as JML08,
					sum(JML09) as JML09,
					sum(JML10) as JML10,
					sum(JML11) as JML11,
					sum(JML12) as JML12
					from d_trktrm WHERE THANG='$th' group by THANG";
	$aTarik = mysql_query($sql);
	$Tarik = mysql_fetch_array($aTarik);
	$pagu_menteri = pagu_menteri($th) ;
	$real_menteri_bulan_1 = real_menteri_bulan($th,1) ;
	$real_menteri_bulan_2 = real_menteri_bulan($th,2) ;
	$real_menteri_bulan_3 = real_menteri_bulan($th,3) ;
	$real_menteri_bulan_4 = real_menteri_bulan($th,4) ;
	$real_menteri_bulan_5 = real_menteri_bulan($th,5) ;
	$real_menteri_bulan_6 = real_menteri_bulan($th,6) ;
	$real_menteri_bulan_7 = real_menteri_bulan($th,7) ;
	$real_menteri_bulan_8 = real_menteri_bulan($th,8) ;
	$real_menteri_bulan_9 = real_menteri_bulan($th,9) ;
	$real_menteri_bulan_10 = real_menteri_bulan($th,10) ;
	$real_menteri_bulan_11 = real_menteri_bulan($th,11) ;
	$real_menteri_bulan_12 = real_menteri_bulan($th,12) ;
	$real_menteri_sdbulan = real_menteri_sdbulan($th,12) ;
  ?>
    <tr>
      <td rowspan="2" align="center"><font color="#009900"><strong><?php echo '023' ?></strong></font></td>
      <td rowspan="2" align="left"><font color="#009900"><strong><?php echo strtoupper(nm_unit('2320000')) ?></strong></font></td>
      <td rowspan="2" align="right"><font color="#009900"><strong><?php echo number_format($pagu_menteri,"0",",",".") ?></strong></font></td>
      <td align="right" valign="top"><font color="#009900"><strong><?php echo number_format($real_menteri_bulan_1,"0",",",".") ?></strong></font></td>
      <td align="right" valign="top"><font color="#009900"><strong><?php echo number_format($real_menteri_bulan_2,"0",",",".") ?></strong></font></td>
      <td align="right" valign="top"><font color="#009900"><strong><?php echo number_format($real_menteri_bulan_3,"0",",",".") ?></strong></font></td>
      <td align="right" valign="top"><font color="#009900"><strong><?php echo number_format($real_menteri_bulan_4,"0",",",".") ?></strong></font></td>
      <td align="right" valign="top"><font color="#009900"><strong><?php echo number_format($real_menteri_bulan_5,"0",",",".") ?></strong></font></td>
      <td align="right" valign="top"><font color="#009900"><strong><?php echo number_format($real_menteri_bulan_6,"0",",",".") ?></strong></font></td>
      <td align="right" valign="top"><font color="#009900"><strong><?php echo number_format($real_menteri_bulan_7,"0",",",".") ?></strong></font></td>
      <td align="right" valign="top"><font color="#009900"><strong><?php echo number_format($real_menteri_bulan_8,"0",",",".") ?></strong></font></td>
      <td align="right" valign="top"><font color="#009900"><strong><?php echo number_format($real_menteri_bulan_9,"0",",",".") ?></strong></font></td>
      <td align="right" valign="top"><font color="#009900"><strong><?php echo number_format($real_menteri_bulan_10,"0",",",".") ?></strong></font></td>
      <td align="right" valign="top"><font color="#009900"><strong><?php echo number_format($real_menteri_bulan_11,"0",",",".") ?></strong></font></td>
      <td align="right" valign="top"><font color="#009900"><strong><?php echo number_format($real_menteri_bulan_12,"0",",",".") ?></strong></font></td>
      <td align="right" valign="top"><font color="#009900"><strong><?php echo number_format($real_menteri_sdbulan,"0",",",".") ?></strong></font></td>
      <td rowspan="2" align="center"><?php if ( $pagu_menteri <> 0) { ?><font color="#009900"><strong><?php echo number_format($real_menteri_sdbulan/$pagu_menteri*100,"2",",",".") ?></strong></font><?php } ?></td>
      <td rowspan="2" align="right"><font color="#009900"><strong><?php echo number_format($pagu_menteri-$real_menteri_sdbulan,"0",",",".") ?></strong></font></td>
    </tr>
    <tr>
      <td align="right" valign="top" class="row6"><font color="#009900"><strong><?php echo number_format($Tarik['JML01'],"0",",",".") ?></strong></font></td>
      <td align="right" valign="top" class="row6"><font color="#009900"><strong><?php echo number_format($Tarik['JML02'],"0",",",".") ?></strong></font></td>
      <td align="right" valign="top" class="row6"><font color="#009900"><strong><?php echo number_format($Tarik['JML03'],"0",",",".") ?></strong></font></td>
      <td align="right" valign="top" class="row6"><font color="#009900"><strong><?php echo number_format($Tarik['JML04'],"0",",",".") ?></strong></font></td>
      <td align="right" valign="top" class="row6"><font color="#009900"><strong><?php echo number_format($Tarik['JML05'],"0",",",".") ?></strong></font></td>
      <td align="right" valign="top" class="row6"><font color="#009900"><strong><?php echo number_format($Tarik['JML06'],"0",",",".") ?></strong></font></td>
      <td align="right" valign="top" class="row6"><font color="#009900"><strong><?php echo number_format($Tarik['JML07'],"0",",",".") ?></strong></font></td>
      <td align="right" valign="top" class="row6"><font color="#009900"><strong><?php echo number_format($Tarik['JML08'],"0",",",".") ?></strong></font></td>
      <td align="right" valign="top" class="row6"><font color="#009900"><strong><?php echo number_format($Tarik['JML09'],"0",",",".") ?></strong></font></td>
      <td align="right" valign="top" class="row6"><font color="#009900"><strong><?php echo number_format($Tarik['JML10'],"0",",",".") ?></strong></font></td>
      <td align="right" valign="top" class="row6"><font color="#009900"><strong><?php echo number_format($Tarik['JML11'],"0",",",".") ?></strong></font></td>
      <td align="right" valign="top" class="row6"><font color="#009900"><strong><?php echo number_format($Tarik['JML12'],"0",",",".") ?></strong></font></td>
      <td align="right" valign="top" class="row6"><font color="#009900"><strong><?php echo number_format($Tarik['RPHPAGU'],"0",",",".") ?></strong></font></td>
    </tr>
    <?php
	}  # endif satker
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
      <?php 
	$kdsatker = $col[1][$k] ;
	$sql = "select 	sum(RPHPAGU) as RPHPAGU,
					sum(JML01) as JML01,
					sum(JML02) as JML02,
					sum(JML03) as JML03,
					sum(JML04) as JML04,
					sum(JML05) as JML05,
					sum(JML06) as JML06,
					sum(JML07) as JML07,
					sum(JML08) as JML08,
					sum(JML09) as JML09,
					sum(JML10) as JML10,
					sum(JML11) as JML11,
					sum(JML12) as JML12
					from d_trktrm WHERE THANG='$th' AND KDSATKER = '$kdsatker' group by KDSATKER";
	$aTarik = mysql_query($sql);
	$Tarik = mysql_fetch_array($aTarik);
	$real_satker_bulan_1 = real_satker_bulan($th,$col[1][$k],1) ;
	$real_satker_bulan_2 = real_satker_bulan($th,$col[1][$k],2) ;
	$real_satker_bulan_3 = real_satker_bulan($th,$col[1][$k],3) ;
	$real_satker_bulan_4 = real_satker_bulan($th,$col[1][$k],4) ;
	$real_satker_bulan_5 = real_satker_bulan($th,$col[1][$k],5) ;
	$real_satker_bulan_6 = real_satker_bulan($th,$col[1][$k],6) ;
	$real_satker_bulan_7 = real_satker_bulan($th,$col[1][$k],7) ;
	$real_satker_bulan_8 = real_satker_bulan($th,$col[1][$k],8) ;
	$real_satker_bulan_9 = real_satker_bulan($th,$col[1][$k],9) ;
	$real_satker_bulan_10 = real_satker_bulan($th,$col[1][$k],10) ;
	$real_satker_bulan_11 = real_satker_bulan($th,$col[1][$k],11) ;
	$real_satker_bulan_12 = real_satker_bulan($th,$col[1][$k],12) ;
	$real_satker_sdbulan = real_satker_sdbulan($th,$col[1][$k],12) ;
	?>
      <td width="6%" rowspan="2" align="center"><strong><?php echo $col[1][$k] ?></strong></td>
      <td width="54%" rowspan="2" align="left"><strong><?php echo nm_satker($col[1][$k]) ?></strong></td>
      <td width="12%" rowspan="2" align="right"><strong><?php echo number_format($col[2][$k],"0",",",".") ?></strong></td>
      <td width="11%" align="right" valign="top"><strong><?php echo number_format($real_satker_bulan_1,"0",",",".") ?></strong></td>
      <td width="11%" align="right" valign="top"><strong><?php echo number_format($real_satker_bulan_2,"0",",",".") ?></strong></td>
      <td width="7%" align="right" valign="top"><strong><?php echo number_format($real_satker_bulan_3,"0",",",".") ?></strong></td>
      <td width="7%" align="right" valign="top"><strong><?php echo number_format($real_satker_bulan_4,"0",",",".") ?></strong></td>
      <td width="7%" align="right" valign="top"><strong><?php echo number_format($real_satker_bulan_5,"0",",",".") ?></strong></td>
      <td width="7%" align="right" valign="top"><strong><?php echo number_format($real_satker_bulan_6,"0",",",".") ?></strong></td>
      <td width="7%" align="right" valign="top"><strong><?php echo number_format($real_satker_bulan_7,"0",",",".") ?></strong></td>
      <td width="7%" align="right" valign="top"><strong><?php echo number_format($real_satker_bulan_8,"0",",",".") ?></strong></td>
      <td width="7%" align="right" valign="top"><strong><?php echo number_format($real_satker_bulan_9,"0",",",".") ?></strong></td>
      <td width="7%" align="right" valign="top"><strong><?php echo number_format($real_satker_bulan_10,"0",",",".") ?></strong></td>
      <td width="7%" align="right" valign="top"><strong><?php echo number_format($real_satker_bulan_11,"0",",",".") ?></strong></td>
      <td width="7%" align="center" valign="top"><strong><?php echo number_format($real_satker_bulan_12,"0",",",".") ?></strong></td>
      <td align="right" valign="top"><strong><?php echo number_format($real_satker_sdbulan,"0",",",".") ?></strong></td>
      <td rowspan="2" align="center"><strong><?php echo number_format($real_satker_sdbulan/$col[2][$k]*100,"2",",",".") ?></strong></td>
      <td rowspan="2" align="right"><strong><?php echo number_format($col[2][$k]-$real_satker_sdbulan,"0",",",".") ?></strong></td>
    </tr>
    <tr>
      <td align="right" valign="top" class="row6"><strong><?php echo number_format($Tarik['JML01'],"0",",",".") ?></strong></td>
      <td width="11%" align="right" valign="top" class="row6"><strong><?php echo number_format($Tarik['JML02'],"0",",",".") ?></strong></td>
      <td width="7%" align="right" valign="top" class="row6"><strong><?php echo number_format($Tarik['JML03'],"0",",",".") ?></strong></td>
      <td width="7%" align="right" valign="top" class="row6"><strong><?php echo number_format($Tarik['JML04'],"0",",",".") ?></strong></td>
      <td width="7%" align="right" valign="top" class="row6"><strong><?php echo number_format($Tarik['JML05'],"0",",",".") ?></strong></td>
      <td width="7%" align="right" valign="top" class="row6"><strong><?php echo number_format($Tarik['JML06'],"0",",",".") ?></strong></td>
      <td width="7%" align="right" valign="top" class="row6"><strong><?php echo number_format($Tarik['JML07'],"0",",",".") ?></strong></td>
      <td width="7%" align="right" valign="top" class="row6"><strong><?php echo number_format($Tarik['JML08'],"0",",",".") ?></strong></td>
      <td width="7%" align="right" valign="top" class="row6"><strong><?php echo number_format($Tarik['JML09'],"0",",",".") ?></strong></td>
      <td width="7%" align="right" valign="top" class="row6"><strong><?php echo number_format($Tarik['JML10'],"0",",",".") ?></strong></td>
      <td width="7%" align="right" valign="top" class="row6"><strong><?php echo number_format($Tarik['JML11'],"0",",",".") ?></strong></td>
      <td width="7%" align="center" valign="top" class="row6"><strong><?php echo number_format($Tarik['JML12'],"0",",",".") ?></strong></td>
      <td align="right" valign="top" class="row6"><strong><?php echo number_format($Tarik['RPHPAGU'],"0",",",".") ?></strong></td>
    </tr>
    <?php 
	$kdsatker = $col[1][$k] ;
	$sql = "select KDGIAT, sum(JUMLAH) as pagu_giat from $table WHERE THANG = '$th' and KDSATKER = '$kdsatker' group by KDGIAT order by KDGIAT";
	$aGiat = mysql_query($sql);
	while ($Giat = mysql_fetch_array($aGiat))
	{
	$real_giat_bulan_1 = real_giat_bulan($th,$kdsatker,$Giat['KDGIAT'],1) ;
	$real_giat_bulan_2 = real_giat_bulan($th,$kdsatker,$Giat['KDGIAT'],2) ;
	$real_giat_bulan_3 = real_giat_bulan($th,$kdsatker,$Giat['KDGIAT'],3) ;
	$real_giat_bulan_4 = real_giat_bulan($th,$kdsatker,$Giat['KDGIAT'],4) ;
	$real_giat_bulan_5 = real_giat_bulan($th,$kdsatker,$Giat['KDGIAT'],5) ;
	$real_giat_bulan_6 = real_giat_bulan($th,$kdsatker,$Giat['KDGIAT'],6) ;
	$real_giat_bulan_7 = real_giat_bulan($th,$kdsatker,$Giat['KDGIAT'],7) ;
	$real_giat_bulan_8 = real_giat_bulan($th,$kdsatker,$Giat['KDGIAT'],8) ;
	$real_giat_bulan_9 = real_giat_bulan($th,$kdsatker,$Giat['KDGIAT'],9) ;
	$real_giat_bulan_10 = real_giat_bulan($th,$kdsatker,$Giat['KDGIAT'],10) ;
	$real_giat_bulan_11 = real_giat_bulan($th,$kdsatker,$Giat['KDGIAT'],11) ;
	$real_giat_bulan_12 = real_giat_bulan($th,$kdsatker,$Giat['KDGIAT'],12) ;
	$real_giat_sdbulan = real_giat_sdbulan($th,$kdsatker,$Giat['KDGIAT'],12) ;
	$kdgiat = $Giat['KDGIAT'] ;
	$sql = "select 	sum(RPHPAGU) as RPHPAGU,
					sum(JML01) as JML01,
					sum(JML02) as JML02,
					sum(JML03) as JML03,
					sum(JML04) as JML04,
					sum(JML05) as JML05,
					sum(JML06) as JML06,
					sum(JML07) as JML07,
					sum(JML08) as JML08,
					sum(JML09) as JML09,
					sum(JML10) as JML10,
					sum(JML11) as JML11,
					sum(JML12) as JML12
					from d_trktrm WHERE THANG='$th' AND KDSATKER = '$kdsatker' AND KDGIAT = '$kdgiat' group by KDGIAT";
	$aTarik = mysql_query($sql);
	$Tarik = mysql_fetch_array($aTarik);
?>
    <tr class="<?php echo $class ?>">
      <td rowspan="2" align="center"><font color="#0000FF"><?php echo $Giat['KDGIAT'] ?></font></td>
      <td rowspan="2" align="left" valign="top"><font color="#0000FF"><?php echo nm_giat($Giat['KDGIAT']) ?></font></td>
      <td rowspan="2" align="right"><font color="#0000FF"><?php echo number_format($Giat['pagu_giat'],"0",",",".") ?></font></td>
      <td align="right" valign="top"><font color="#0000FF"><?php echo number_format($real_giat_bulan_1,"0",",",".") ?></font></td>
      <td align="right" valign="top"><font color="#0000FF"><?php echo number_format($real_giat_bulan_2,"0",",",".") ?></font></td>
      <td align="right" valign="top"><font color="#0000FF"><?php echo number_format($real_giat_bulan_3,"0",",",".") ?></font></td>
      <td align="right" valign="top"><font color="#0000FF"><?php echo number_format($real_giat_bulan_4,"0",",",".") ?></font></td>
      <td align="right" valign="top"><font color="#0000FF"><?php echo number_format($real_giat_bulan_5,"0",",",".") ?></font></td>
      <td align="right" valign="top"><font color="#0000FF"><?php echo number_format($real_giat_bulan_6,"0",",",".") ?></font></td>
      <td align="right" valign="top"><font color="#0000FF"><?php echo number_format($real_giat_bulan_7,"0",",",".") ?></font></td>
      <td align="right" valign="top"><font color="#0000FF"><?php echo number_format($real_giat_bulan_8,"0",",",".") ?></font></td>
      <td align="right" valign="top"><font color="#0000FF"><?php echo number_format($real_giat_bulan_9,"0",",",".") ?></font></td>
      <td align="right" valign="top"><font color="#0000FF"><?php echo number_format($real_giat_bulan_10,"0",",",".") ?></font></td>
      <td align="right" valign="top"><font color="#0000FF"><?php echo number_format($real_giat_bulan_11,"0",",",".") ?></font></td>
      <td align="right" valign="top"><font color="#0000FF"><?php echo number_format($real_giat_bulan_12,"0",",",".") ?></font></td>
      <td align="right" valign="top"><font color="#0000FF"><?php echo number_format($real_giat_sdbulan,"0",",",".") ?></font></td>
      <td rowspan="2" align="center"><font color="#0000FF"><?php echo number_format($real_giat_sdbulan/$Giat['pagu_giat']*100,"2",",",".") ?></font></td>
      <td rowspan="2" align="right"><font color="#0000FF"><?php echo number_format($Giat['pagu_giat']-$real_giat_sdbulan,"0",",",".") ?></font></td>
    </tr>
    <tr>
      <td align="right" valign="top" class="row6"><font color="#0000FF"><?php echo number_format($Tarik['JML01'],"0",",",".") ?></font></td>
      <td align="right" valign="top" class="row6"><font color="#0000FF"><?php echo number_format($Tarik['JML02'],"0",",",".") ?></font></td>
      <td align="right" valign="top" class="row6"><font color="#0000FF"><?php echo number_format($Tarik['JML03'],"0",",",".") ?></font></td>
      <td align="right" valign="top" class="row6"><font color="#0000FF"><?php echo number_format($Tarik['JML04'],"0",",",".") ?></font></td>
      <td align="right" valign="top" class="row6"><font color="#0000FF"><?php echo number_format($Tarik['JML05'],"0",",",".") ?></font></td>
      <td align="right" valign="top" class="row6"><font color="#0000FF"><?php echo number_format($Tarik['JML06'],"0",",",".") ?></font></td>
      <td align="right" valign="top" class="row6"><font color="#0000FF"><?php echo number_format($Tarik['JML07'],"0",",",".") ?></font></td>
      <td align="right" valign="top" class="row6"><font color="#0000FF"><?php echo number_format($Tarik['JML08'],"0",",",".") ?></font></td>
      <td align="right" valign="top" class="row6"><font color="#0000FF"><?php echo number_format($Tarik['JML09'],"0",",",".") ?></font></td>
      <td align="right" valign="top" class="row6"><font color="#0000FF"><?php echo number_format($Tarik['JML10'],"0",",",".") ?></font></td>
      <td align="right" valign="top" class="row6"><font color="#0000FF"><?php echo number_format($Tarik['JML11'],"0",",",".") ?></font></td>
      <td align="right" valign="top" class="row6"><font color="#0000FF"><?php echo number_format($Tarik['JML12'],"0",",",".") ?></font></td>
      <td align="right" valign="top" class="row6"><font color="#0000FF"><?php echo number_format($Tarik['RPHPAGU'],"0",",",".") ?></font></td>
    </tr>
    <?php 
	$kdunitkerja = $Giat['kdunitkerja'] ;
	$sql = "select KDOUTPUT, sum(jumlah) as pagu_output from $table WHERE THANG='$th' and KDSATKER='$kdsatker' and KDGIAT = '$Giat[KDGIAT]' group by KDOUTPUT";
	$aOutput = mysql_query($sql);
	while ($Output = mysql_fetch_array($aOutput))
	{
	$real_output_bulan_1 = real_output_bulan($th,$kdsatker,$Giat['KDGIAT'],$Output['KDOUTPUT'],1) ;
	$real_output_bulan_2 = real_output_bulan($th,$kdsatker,$Giat['KDGIAT'],$Output['KDOUTPUT'],2) ;
	$real_output_bulan_3 = real_output_bulan($th,$kdsatker,$Giat['KDGIAT'],$Output['KDOUTPUT'],3) ;
	$real_output_bulan_4 = real_output_bulan($th,$kdsatker,$Giat['KDGIAT'],$Output['KDOUTPUT'],4) ;
	$real_output_bulan_5 = real_output_bulan($th,$kdsatker,$Giat['KDGIAT'],$Output['KDOUTPUT'],5) ;
	$real_output_bulan_6 = real_output_bulan($th,$kdsatker,$Giat['KDGIAT'],$Output['KDOUTPUT'],6) ;
	$real_output_bulan_7 = real_output_bulan($th,$kdsatker,$Giat['KDGIAT'],$Output['KDOUTPUT'],7) ;
	$real_output_bulan_8 = real_output_bulan($th,$kdsatker,$Giat['KDGIAT'],$Output['KDOUTPUT'],8) ;
	$real_output_bulan_9 = real_output_bulan($th,$kdsatker,$Giat['KDGIAT'],$Output['KDOUTPUT'],9) ;
	$real_output_bulan_10 = real_output_bulan($th,$kdsatker,$Giat['KDGIAT'],$Output['KDOUTPUT'],10) ;
	$real_output_bulan_11 = real_output_bulan($th,$kdsatker,$Giat['KDGIAT'],$Output['KDOUTPUT'],11) ;
	$real_output_bulan_12 = real_output_bulan($th,$kdsatker,$Giat['KDGIAT'],$Output['KDOUTPUT'],12) ;
	$real_output_sdbulan = real_output_sdbulan($th,$kdsatker,$Giat['KDGIAT'],$Output['KDOUTPUT'],12) ;
?>
    <tr class="<?php echo $class ?>">
      <td align="center" valign="top"><font color="#993333"><?php echo $Output['KDOUTPUT'] ?></font></td>
      <td align="left" valign="top"><font color="#993333"><?php echo nm_output_th($th,$Giat['KDGIAT'].$Output['KDOUTPUT']) ?></font></td>
      <td align="right" valign="top"><font color="#993333"><?php echo number_format($Output['pagu_output'],"0",",",".") ?></font></td>
      <td align="right" valign="top"><font color="#993333"><?php echo number_format($real_output_bulan_1,"0",",",".") ?></font></td>
      <td align="right" valign="top"><font color="#993333"><?php echo number_format($real_output_bulan_2,"0",",",".") ?></font></td>
      <td align="right" valign="top"><font color="#993333"><?php echo number_format($real_output_bulan_3,"0",",",".") ?></font></td>
      <td align="right" valign="top"><font color="#993333"><?php echo number_format($real_output_bulan_4,"0",",",".") ?></font></td>
      <td align="right" valign="top"><font color="#993333"><?php echo number_format($real_output_bulan_5,"0",",",".") ?></font></td>
      <td align="right" valign="top"><font color="#993333"><?php echo number_format($real_output_bulan_6,"0",",",".") ?></font></td>
      <td align="right" valign="top"><font color="#993333"><?php echo number_format($real_output_bulan_7,"0",",",".") ?></font></td>
      <td align="right" valign="top"><font color="#993333"><?php echo number_format($real_output_bulan_8,"0",",",".") ?></font></td>
      <td align="right" valign="top"><font color="#993333"><?php echo number_format($real_output_bulan_9,"0",",",".") ?></font></td>
      <td align="right" valign="top"><font color="#993333"><?php echo number_format($real_output_bulan_10,"0",",",".") ?></font></td>
      <td align="right" valign="top"><font color="#993333"><?php echo number_format($real_output_bulan_11,"0",",",".") ?></font></td>
      <td align="right" valign="top"><font color="#993333"><?php echo number_format($real_output_bulan_12,"0",",",".") ?></font></td>
      <td align="right" valign="top"><font color="#993333"><?php echo number_format($real_output_sdbulan,"0",",",".") ?></font></td>
      <td align="center" valign="top"><font color="#993333"><?php echo number_format($real_output_sdbulan/$Output['pagu_output']*100,"2",",",".") ?></font></td>
      <td align="right" valign="top"><font color="#993333"><?php echo number_format($Output['pagu_output']-$real_output_sdbulan,"0",",",".") ?></font></td>
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
