<?php
	checkauthentication();
	
	$p = $_GET['p'];
	$cari = $_GET['cari'];
	$xlevel = $_SESSION['xlevel'];
	$xkdunit = $_SESSION['xkdunit'];
	$kddeputi = substr($xkdunit,0,3);
	$kdunit_kerja = substr($xkdunit,0,4);
	$table = "v_item";
	$field = get_field($table);
	$ed_link = "index.php?p=".get_edit_link($p);
	$del_link = "index.php?p=".get_delete_link($p);
	$sw = $_REQUEST['sw'];
	
	$th = date('Y');
	
	$sql = "select KDDEPT, KDUNIT from setup_dept ";
	$aDept = mysql_query($sql);
	$Dept = mysql_fetch_array($aDept);
	$kddept = $Dept['KDDEPT'];
	$kdunit = $Dept['KDUNIT'];

	if($cari=='') $kdtriwulan = 1;
	
	if($_REQUEST['cari']){
		$kdtriwulan = $_REQUEST['kdtriwulan'];
	}

if($kdtriwulan == 1 ){	
	$sql = "select THANG,sum(JUMLAH) as pagu_dept, sum(JANUARI + PEBRUARI + MARET) as rencana_dept from $table WHERE THANG='$th' group by KDDEPT";
	
}elseif($kdtriwulan == 2 ){	
	$sql = "select THANG,sum(JUMLAH) as pagu_dept, sum(JANUARI + PEBRUARI + MARET + APRIL + MEI + JUNI) as rencana_dept from $table WHERE THANG='$th' group by KDDEPT";
 
}elseif($kdtriwulan == 3 ){	
	$sql = "select THANG,sum(JUMLAH) as pagu_dept, sum(JANUARI + PEBRUARI + MARET + APRIL + MEI + JUNI + JULI + AGUSTUS +
			SEPTEMBER) as rencana_dept from $table WHERE THANG='$th' group by KDDEPT";

}elseif($kdtriwulan == 4 ){	
	$sql = "select THANG,sum(JUMLAH) as pagu_dept, sum(JANUARI + PEBRUARI + MARET + APRIL + MEI + JUNI + JULI + AGUSTUS +
			SEPTEMBER + OKTOBER + NOPEMBER + DESEMBER) as rencana_dept from $table WHERE THANG='$th' group by KDDEPT";
}
 	$aDept = mysql_query($sql);
	$count = mysql_num_rows($aDept);
	
	while ($Dept = mysql_fetch_array($aDept))
	{
		$col[0][] 	= $Dept['THANG'];
		$col[2][] 	= $Dept['pagu_dept'];
		$col[3][] 	= $Dept['rencana_dept'];
	}

echo "<strong> Tahun Anggaran : ".$th. "</strong>". "<br />";
echo "<strong> Triwulan : ".nmromawi($kdtriwulan). "</strong>" ?>
<style type="text/css">
<!--
.style1 {color: #0000FF}
-->
</style>
<br />
<style type="text/css">
<!--
.style1 {color: #006633}
.style2 {color: #0066FF}
-->
</style>
<div align="right">
	<form action="" method="get">
		<input type="hidden" name="p" value="<?php echo $p; ?>" />
		Triwulan : 
		<select name="kdtriwulan"><?php
									
					for ($i = 1; $i <= 4; $i++)
					{ ?>
						<option value="<?php echo $i; ?>" <?php if ($i == $kdtriwulan) echo "selected"; ?>><?php echo nmromawi($i) ?></option><?php
					} ?>	
	  </select>
		<input type="submit" value="Cari" name="cari"/>
	</form>
</div>
<br />
<table width="741" cellpadding="1" class="adminlist">
  <thead>
    <tr> 
      <th rowspan="3">Kode APBN</th>
      <th rowspan="3">Nama Satker / <br>
        Nama Kegiatan<br /></th>
      <th colspan="5">Anggaran</th>
    </tr>
    <tr>
      <th rowspan="2">Total<br />
      Pagu</th>
      <th colspan="2">Rencana Penarikan s/d<br />
        Triwulan <?php echo nmromawi($kdtriwulan) ?></th>
      <th colspan="2">Realisasi s/d<br />Triwulan <?php echo nmromawi($kdtriwulan) ?></th>
    </tr>
    <tr>
      <th height="21">Rp.</th>
      <th>%</th>
      <th>Rp.</th>
      <th>%</th>
    </tr>
  </thead>
  <tbody>
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
				else $class = "row1"; ?>
    <tr class="<?php echo $class ?>"> 
      <td align="center"><strong><?php echo $kddept ?></strong></td>
      <td align="left"><strong><?php echo nm_unit(substr($kddept,1,2).'0000') ?></strong></td>
      <td width="9%" align="right"><strong><?php echo number_format($col[2][$k],"0",",",".") ?></strong></td>
      <td width="4%" align="right"><strong><?php echo number_format($col[3][$k],"0",",",".") ?></strong></td>
      <td width="11%" align="center"><strong><?php echo number_format(($col[3][$k]/$col[2][$k])*100,"2",",",".") ?></strong></td>
      <td width="4%" align="right"><strong><?php echo number_format(realisasi_dept_tw($col[0][$k],$kddept,$kdtriwulan),"0",",",".") ?></strong></td>
      <td width="11%" align="center"><strong><?php echo number_format((realisasi_dept_tw($col[0][$k],$kddept,$kdtriwulan)/$col[2][$k])*100,"2",",",".") ?></strong></td>
    </tr>
    
    <?php 
if($kdtriwulan == 1 ){	
	switch ($xlevel)
	{
		case '1':
	$sql = "select left(kdunitkerja,3) as kddeputi, sum(JUMLAH) as pagu_deputi, sum(JANUARI + PEBRUARI + MARET) as rencana_deputi from $table WHERE THANG='$th' and KDDEPT='$kddept' group by left(kdunitkerja,3) order by left(kdunitkerja,3)";
			break;
		case '4':
	$sql = "select left(kdunitkerja,3) as kddeputi, sum(JUMLAH) as pagu_deputi, sum(JANUARI + PEBRUARI + MARET) as rencana_deputi from $table WHERE THANG='$th' and KDDEPT='$kddept' and left(kdunitkerja,3) = '$kddeputi' group by left(kdunitkerja,3) order by left(kdunitkerja,3)";
			break;
		case '5':
	$sql = "select left(kdunitkerja,3) as kddeputi, sum(JUMLAH) as pagu_deputi, sum(JANUARI + PEBRUARI + MARET) as rencana_deputi from $table WHERE THANG='$th' and KDDEPT='$kddept' and left(kdunitkerja,3) = '$kddeputi' group by left(kdunitkerja,3) order by left(kdunitkerja,3)";
			break;
		default:
	$sql = "select left(kdunitkerja,3) as kddeputi, sum(JUMLAH) as pagu_deputi, sum(JANUARI + PEBRUARI + MARET) as rencana_deputi from $table WHERE THANG='$th' and KDDEPT='$kddept' group by left(kdunitkerja,3) order by left(kdunitkerja,3)";
			break;
	}
	
}elseif($kdtriwulan == 2 ){	

	switch ($xlevel)
	{
		case '1':
	$sql = "select left(kdunitkerja,3) as kddeputi, sum(JUMLAH) as pagu_deputi, sum(JANUARI + PEBRUARI + MARET + APRIL + MEI + JUNI) as rencana_deputi from $table WHERE THANG='$th' and KDDEPT='$kddept' group by left(kdunitkerja,3) order by left(kdunitkerja,3)";
			break;
		case '4':
	$sql = "select left(kdunitkerja,3) as kddeputi, sum(JUMLAH) as pagu_deputi, sum(JANUARI + PEBRUARI + MARET + APRIL + MEI + JUNI) as rencana_deputi from $table WHERE THANG='$th' and KDDEPT='$kddept' and left(kdunitkerja,3) = '$kddeputi' group by left(kdunitkerja,3) order by left(kdunitkerja,3)";
			break;
		case '5':
	$sql = "select left(kdunitkerja,3) as kddeputi, sum(JUMLAH) as pagu_deputi, sum(JANUARI + PEBRUARI + MARET + APRIL + MEI + JUNI) as rencana_deputi from $table WHERE THANG='$th' and KDDEPT='$kddept' and left(kdunitkerja,3) = '$kddeputi' group by left(kdunitkerja,3) order by left(kdunitkerja,3)";
			break;
		default:
	$sql = "select left(kdunitkerja,3) as kddeputi, sum(JUMLAH) as pagu_deputi, sum(JANUARI + PEBRUARI + MARET + APRIL + MEI + JUNI) as rencana_deputi from $table WHERE THANG='$th' and KDDEPT='$kddept' group by left(kdunitkerja,3) order by left(kdunitkerja,3)";
			break;
	}

}elseif($kdtriwulan == 3 ){	

	switch ($xlevel)
	{
		case '1':
	$sql = "select left(kdunitkerja,3) as kddeputi, sum(JUMLAH) as pagu_deputi, sum(JANUARI + PEBRUARI + MARET + APRIL + MEI + JUNI + JULI + AGUSTUS +
			SEPTEMBER) as rencana_deputi from $table WHERE THANG='$th' and KDDEPT='$kddept' group by left(kdunitkerja,3) order by left(kdunitkerja,3)";
			break;
		case '4':
	$sql = "select left(kdunitkerja,3) as kddeputi, sum(JUMLAH) as pagu_deputi, sum(JANUARI + PEBRUARI + MARET + APRIL + MEI + JUNI + JULI + AGUSTUS +
			SEPTEMBER) as rencana_deputi from $table WHERE THANG='$th' and KDDEPT='$kddept' and left(kdunitkerja,3) = '$kddeputi' group by left(kdunitkerja,3) order by left(kdunitkerja,3)";
			break;
		case '5':
	$sql = "select left(kdunitkerja,3) as kddeputi, sum(JUMLAH) as pagu_deputi, sum(JANUARI + PEBRUARI + MARET + APRIL + MEI + JUNI + JULI + AGUSTUS +
			SEPTEMBER) as rencana_deputi from $table WHERE THANG='$th' and KDDEPT='$kddept' and left(kdunitkerja,3) = '$kddeputi' group by left(kdunitkerja,3) order by left(kdunitkerja,3)";
			break;
		default:
	$sql = "select left(kdunitkerja,3) as kddeputi, sum(JUMLAH) as pagu_deputi, sum(JANUARI + PEBRUARI + MARET + APRIL + MEI + JUNI + JULI + AGUSTUS +
			SEPTEMBER) as rencana_deputi from $table WHERE THANG='$th' and KDDEPT='$kddept' group by left(kdunitkerja,3) order by left(kdunitkerja,3)";
			break;
	}

}elseif($kdtriwulan == 4 ){	

	switch ($xlevel)
	{
		case '1':
	$sql = "select left(kdunitkerja,3) as kddeputi, sum(JUMLAH) as pagu_deputi, sum(JANUARI + PEBRUARI + MARET + APRIL + MEI + JUNI + JULI + AGUSTUS +
			SEPTEMBER + OKTOBER + NOPEMBER + DESEMBER) as rencana_deputi from $table WHERE THANG='$th' and KDDEPT='$kddept' group by left(kdunitkerja,3) order by left(kdunitkerja,3)";
			break;
		case '4':
	$sql = "select left(kdunitkerja,3) as kddeputi, sum(JUMLAH) as pagu_deputi, sum(JANUARI + PEBRUARI + MARET + APRIL + MEI + JUNI + JULI + AGUSTUS +
			SEPTEMBER + OKTOBER + NOPEMBER + DESEMBER) as rencana_deputi from $table WHERE THANG='$th' and KDDEPT='$kddept' and left(kdunitkerja,3) = '$kddeputi' group by left(kdunitkerja,3) order by left(kdunitkerja,3)";
			break;
		case '5':
	$sql = "select left(kdunitkerja,3) as kddeputi, sum(JUMLAH) as pagu_deputi, sum(JANUARI + PEBRUARI + MARET + APRIL + MEI + JUNI + JULI + AGUSTUS +
			SEPTEMBER + OKTOBER + NOPEMBER + DESEMBER) as rencana_deputi from $table WHERE THANG='$th' and KDDEPT='$kddept' and left(kdunitkerja,3) = '$kddeputi' group by left(kdunitkerja,3) order by left(kdunitkerja,3)";
			break;
		default:
	$sql = "select left(kdunitkerja,3) as kddeputi, sum(JUMLAH) as pagu_deputi, sum(JANUARI + PEBRUARI + MARET + APRIL + MEI + JUNI + JULI + AGUSTUS +
			SEPTEMBER + OKTOBER + NOPEMBER + DESEMBER) as rencana_deputi from $table WHERE THANG='$th' and KDDEPT='$kddept' group by left(kdunitkerja,3) order by left(kdunitkerja,3)";
			break;
	}
}
	$aDeputi = mysql_query($sql);
	while ($Deputi = mysql_fetch_array($aDeputi))
	{
	$kddeputi =  $Deputi['kddeputi'] ;
	$real_deputi = realisasi_deputi_tw($th,$kddeputi,$kdtriwulan);
?>
    <tr bordercolor="#999999" class="<?php echo $class ?>"> 
      <td width="6%" align="center"><font color="#0000FF"><?php echo $kddeputi ?></font></td>
      <td width="24%" align="left"><font color="#0000FF"><?php echo nm_unit($kddeputi.'000') ?></font></td>
      <td align="right" valign="top"><font color="#0000FF"><?php echo number_format($Deputi['pagu_deputi'],"0",",",".") ?></font></td>
      <td align="right" valign="top"><font color="#0000FF"><?php echo number_format($Deputi['rencana_deputi'],"0",",",".") ?></font></td>
      <td align="center" valign="top"><font color="#0000FF"><?php echo number_format(($Deputi['rencana_deputi']/$Deputi['pagu_deputi'])*100,"2",",",".") ?></font></td>
      <td align="right" valign="top"><font color="#0000FF"><?php echo number_format($real_deputi,"0",",",".") ?></font></td>
      <td align="center" valign="top"><font color="#0000FF"><?php echo number_format(($real_deputi/$Deputi['pagu_deputi'])*100,"2",",",".") ?></font></td>
    </tr>
    <?php 
if($kdtriwulan == 1 ){	

	switch ($xlevel)
	{
		case '1':
	$sql = "select left(kdunitkerja,4) as kdunit_kerja, sum(JUMLAH) as pagu_unit, sum(JANUARI + PEBRUARI + MARET) as rencana_unit from $table WHERE THANG='$th' and left(kdunitkerja,3) = '$kddeputi' group by left(kdunitkerja,4) order by left(kdunitkerja,4)";
			break;
		case '4':
	$sql = "select left(kdunitkerja,4) as kdunit_kerja, sum(JUMLAH) as pagu_unit, sum(JANUARI + PEBRUARI + MARET) as rencana_unit from $table WHERE THANG='$th' and left(kdunitkerja,3) = '$kddeputi' group by left(kdunitkerja,4) order by left(kdunitkerja,4)";
			break;
		case '5':
	$sql = "select left(kdunitkerja,4) as kdunit_kerja, sum(JUMLAH) as pagu_unit, sum(JANUARI + PEBRUARI + MARET) as rencana_unit from $table WHERE THANG='$th' and left(kdunitkerja,4) = '$kdunit_kerja' group by left(kdunitkerja,4) order by left(kdunitkerja,4)";
			break;
		default:
	$sql = "select left(kdunitkerja,4) as kdunit_kerja, sum(JUMLAH) as pagu_unit, sum(JANUARI + PEBRUARI + MARET) as rencana_unit from $table WHERE THANG='$th' and left(kdunitkerja,3) = '$kddeputi' group by left(kdunitkerja,4) order by left(kdunitkerja,4)";
			break;
	}
	
}elseif($kdtriwulan == 2 ){	

	switch ($xlevel)
	{
		case '1':
	$sql = "select left(kdunitkerja,4) as kdunit_kerja, sum(JUMLAH) as pagu_unit, sum(JANUARI + PEBRUARI + MARET + APRIL + MEI + JUNI) as rencana_unit from $table WHERE THANG='$th' and left(kdunitkerja,3) = '$kddeputi' group by left(kdunitkerja,4) order by left(kdunitkerja,4)";
			break;
		case '4':
	$sql = "select left(kdunitkerja,4) as kdunit_kerja, sum(JUMLAH) as pagu_unit, sum(JANUARI + PEBRUARI + MARET + APRIL + MEI + JUNI) as rencana_unit from $table WHERE THANG='$th' and left(kdunitkerja,3) = '$kddeputi' group by left(kdunitkerja,4) order by left(kdunitkerja,4)";
			break;
		case '5':
	$sql = "select left(kdunitkerja,4) as kdunit_kerja, sum(JUMLAH) as pagu_unit, sum(JANUARI + PEBRUARI + MARET + APRIL + MEI + JUNI) as rencana_unit from $table WHERE THANG='$th' and left(kdunitkerja,4) = '$kdunit_kerja' group by left(kdunitkerja,4) order by left(kdunitkerja,4)";
			break;
		default:
	$sql = "select left(kdunitkerja,4) as kdunit_kerja, sum(JUMLAH) as pagu_unit, sum(JANUARI + PEBRUARI + MARET + APRIL + MEI + JUNI) as rencana_unit from $table WHERE THANG='$th' and left(kdunitkerja,3) = '$kddeputi' group by left(kdunitkerja,4) order by left(kdunitkerja,4)";
			break;
	}

}elseif($kdtriwulan == 3 ){	

	switch ($xlevel)
	{
		case '1':
	$sql = "select left(kdunitkerja,4) as kdunit_kerja, sum(JUMLAH) as pagu_unit, sum(JANUARI + PEBRUARI + MARET + APRIL + MEI + JUNI + JULI + AGUSTUS +
			SEPTEMBER) as rencana_unit from $table WHERE THANG='$th' and left(kdunitkerja,3) = '$kddeputi' group by left(kdunitkerja,4) order by left(kdunitkerja,4)";
			break;
		case '4':
	$sql = "select left(kdunitkerja,4) as kdunit_kerja, sum(JUMLAH) as pagu_unit, sum(JANUARI + PEBRUARI + MARET + APRIL + MEI + JUNI + JULI + AGUSTUS +
			SEPTEMBER) as rencana_unit from $table WHERE THANG='$th' and left(kdunitkerja,3) = '$kddeputi' group by left(kdunitkerja,4) order by left(kdunitkerja,4)";
			break;
		case '5':
	$sql = "select left(kdunitkerja,4) as kdunit_kerja, sum(JUMLAH) as pagu_unit, sum(JANUARI + PEBRUARI + MARET + APRIL + MEI + JUNI + JULI + AGUSTUS +
			SEPTEMBER) as rencana_unit from $table WHERE THANG='$th' and left(kdunitkerja,4) = '$kdunit_kerja' group by left(kdunitkerja,4) order by left(kdunitkerja,4)";
			break;
		default:
	$sql = "select left(kdunitkerja,4) as kdunit_kerja, sum(JUMLAH) as pagu_unit, sum(JANUARI + PEBRUARI + MARET + APRIL + MEI + JUNI + JULI + AGUSTUS +
			SEPTEMBER) as rencana_unit from $table WHERE THANG='$th' and left(kdunitkerja,3) = '$kddeputi' group by left(kdunitkerja,4) order by left(kdunitkerja,4)";
			break;
	}

}elseif($kdtriwulan == 4 ){	

	switch ($xlevel)
	{
		case '1':
	$sql = "select left(kdunitkerja,4) as kdunit_kerja, sum(JUMLAH) as pagu_unit, sum(JANUARI + PEBRUARI + MARET + APRIL + MEI + JUNI + JULI + AGUSTUS +
			SEPTEMBER + OKTOBER + NOPEMBER + DESEMBER) as rencana_unit from $table WHERE THANG='$th' and left(kdunitkerja,3) = '$kddeputi' group by left(kdunitkerja,4) order by left(kdunitkerja,4)";
			break;
		case '4':
	$sql = "select left(kdunitkerja,4) as kdunit_kerja, sum(JUMLAH) as pagu_unit, sum(JANUARI + PEBRUARI + MARET + APRIL + MEI + JUNI + JULI + AGUSTUS +
			SEPTEMBER + OKTOBER + NOPEMBER + DESEMBER) as rencana_unit from $table WHERE THANG='$th' and left(kdunitkerja,3) = '$kddeputi' group by left(kdunitkerja,4) order by left(kdunitkerja,4)";
			break;
		case '5':
	$sql = "select left(kdunitkerja,4) as kdunit_kerja, sum(JUMLAH) as pagu_unit, sum(JANUARI + PEBRUARI + MARET + APRIL + MEI + JUNI + JULI + AGUSTUS +
			SEPTEMBER + OKTOBER + NOPEMBER + DESEMBER) as rencana_unit from $table WHERE THANG='$th' and left(kdunitkerja,4) = '$kdunit_kerja' group by left(kdunitkerja,4) order by left(kdunitkerja,4)";
			break;
		default:
	$sql = "select left(kdunitkerja,4) as kdunit_kerja, sum(JUMLAH) as pagu_unit, sum(JANUARI + PEBRUARI + MARET + APRIL + MEI + JUNI + JULI + AGUSTUS +
			SEPTEMBER + OKTOBER + NOPEMBER + DESEMBER) as rencana_unit from $table WHERE THANG='$th' and left(kdunitkerja,3) = '$kddeputi' group by left(kdunitkerja,4) order by left(kdunitkerja,4)";
			break;
	}
}
	$aUnit = mysql_query($sql);
	while ($Unit = mysql_fetch_array($aUnit))
	{
	$kdunit_kerja =  $Unit['kdunit_kerja'] ;
	$real_unitkerja = realisasi_unitkerja_tw($th,$kdunit_kerja,$kdtriwulan);
?>
    <tr bordercolor="#999999" class="<?php echo $class ?>">
      <td align="center"><font color="#FF0000"><?php echo $kdunit_kerja ?></font></td>
      <td align="left"><font color="#FF0000"><?php echo nm_unit($kdunit_kerja.'00') ?></font></td>
      <td align="right" valign="top"><font color="#FF0000"><?php echo number_format($Unit['pagu_unit'],"0",",",".") ?></font></td>
      <td align="right" valign="top"><font color="#FF0000"><?php echo number_format($Unit['rencana_unit'],"0",",",".") ?></font></td>
      <td align="center" valign="top"><font color="#FF0000"><?php echo number_format(($Unit['rencana_unit']/$Unit['pagu_unit'])*100,"2",",",".") ?></font></td>
      <td align="right" valign="top"><font color="#FF0000"><?php echo number_format($real_unitkerja,"0",",",".") ?></font></td>
      <td align="center" valign="top"><font color="#FF0000"><?php echo number_format(($real_unitkerja/$Unit['pagu_unit'])*100,"2",",",".") ?></font></td>
    </tr>
    <?php 
if($kdtriwulan == 1 ){	
	$sql = "select KDSATKER, sum(JUMLAH) as pagu_satker, sum(JANUARI + PEBRUARI + MARET) as rencana_satker from $table WHERE THANG='$th' and left(kdunitkerja,4) = '$kdunit_kerja' group by KDSATKER order by KDSATKER";
	
}elseif($kdtriwulan == 2 ){	
	$sql = "select KDSATKER, sum(JUMLAH) as pagu_satker, sum(JANUARI + PEBRUARI + MARET + APRIL + MEI + JUNI) as rencana_satker from $table WHERE THANG='$th' and left(kdunitkerja,4) = '$kdunit_kerja' group by KDSATKER order by KDSATKER";

}elseif($kdtriwulan == 3 ){	
	$sql = "select KDSATKER, sum(JUMLAH) as pagu_satker, sum(JANUARI + PEBRUARI + MARET + APRIL + MEI + JUNI + JULI + AGUSTUS +
			SEPTEMBER) as rencana_satker from $table WHERE THANG='$th' and left(kdunitkerja,4) = '$kdunit_kerja' group by KDSATKER order by KDSATKER";

}elseif($kdtriwulan == 4 ){	
	$sql = "select KDSATKER, sum(JUMLAH) as pagu_satker, sum(JANUARI + PEBRUARI + MARET + APRIL + MEI + JUNI + JULI + AGUSTUS +
			SEPTEMBER + OKTOBER + NOPEMBER + DESEMBER) as rencana_satker from $table WHERE THANG='$th' and left(kdunitkerja,4) = '$kdunit_kerja' group by KDSATKER order by KDSATKER";
}
	$aSatker = mysql_query($sql);
	while ($Satker = mysql_fetch_array($aSatker))
	{
	$kdsatker =  $Satker['KDSATKER'] ;
	$real_satker = realisasi_satkerunit_tw($th,$kdunit_kerja,$kdsatker,$kdtriwulan);
	?>
    <tr class="<?php echo $class ?>"> 
      <td align="center" valign="top"><span class="style1"><?php echo $kdsatker ?></span></td>
      <td align="left" valign="top"><span class="style1"><?php echo nm_satker($kdsatker) ?></span></td>
      <td align="right" valign="top"><span class="style1"><?php echo number_format($Satker['pagu_satker'],"0",",",".") ?></span></td>
      <td align="right" valign="top"><span class="style1"><?php echo number_format($Satker['rencana_satker'],"0",",",".") ?></span></td>
      <td align="center" valign="top"><span class="style1"><?php echo number_format(($Satker['rencana_satker']/$Satker['pagu_satker'])*100,"2",",",".") ?></span></td>
      <td align="right" valign="top"><span class="style1"><?php echo number_format($real_satker,"0",",",".") ?></span></td>
      <td align="center" valign="top"><?php echo number_format(($real_satker/$Satker['pagu_satker'])*100,"2",",",".") ?></td>
    </tr>
    <?php
		} # SATKER
		} # UNIT KERJA
		} # DEPUTI
		} # KEMENTERIAN
		} ?>
  </tbody>
  <tfoot>
    <tr> 
      <td colspan="12">&nbsp;</td>
    </tr>
  </tfoot>
</table>
