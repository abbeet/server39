<?php
	checkauthentication();
	
	$p = $_GET['p'];
	$cari = $_GET['cari'];
	$table = "d_item";
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
echo "<strong> Triwulan : ".nmromawi($kdtriwulan). "</strong>" ?><br />
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
<table width="741" cellpadding="1" class="adminlist">
  <thead>
    <tr> 
      <th rowspan="3">Kode APBN</th>
      <th rowspan="3">Nama Program</th>
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
	$sql = "select THANG, KDPROGRAM, sum(JUMLAH) as pagu_program, sum(JANUARI + PEBRUARI + MARET) as rencana_program from $table WHERE THANG='$th' and KDDEPT='$kddept' group by KDPROGRAM order by KDPROGRAM";
	
}elseif($kdtriwulan == 2 ){
	$sql = "select THANG, KDPROGRAM, sum(JUMLAH) as pagu_program, sum(JANUARI + PEBRUARI + MARET + APRIL + MEI + JUNI) as rencana_program from $table WHERE THANG='$th' and KDDEPT='$kddept' group by KDPROGRAM order by KDPROGRAM";

}elseif($kdtriwulan == 3 ){	
	$sql = "select THANG, KDPROGRAM, sum(JUMLAH) as pagu_program, sum(JANUARI + PEBRUARI + MARET + APRIL + MEI + JUNI + JULI + AGUSTUS +
			SEPTEMBER) as rencana_program from $table WHERE THANG='$th' and KDDEPT='$kddept' group by KDPROGRAM order by KDPROGRAM";

}elseif($kdtriwulan == 4 ){	
	$sql = "select THANG, KDPROGRAM, sum(JUMLAH) as pagu_program, sum(JANUARI + PEBRUARI + MARET + APRIL + MEI + JUNI + JULI + AGUSTUS +
			SEPTEMBER + OKTOBER + NOPEMBER + DESEMBER) as rencana_program from $table WHERE THANG='$th' and KDDEPT='$kddept' group by KDPROGRAM order by KDPROGRAM";
}	
	$aProgram = mysql_query($sql);
	while ($Program = mysql_fetch_array($aProgram))
	{
	$kdprogram = $Program['KDPROGRAM'] ;
	$real_program = realisasi_program_tw($th,$kdprogram,$kdtriwulan);
?>
    <tr bordercolor="#999999" class="<?php echo $class ?>"> 
      <td width="6%" align="center"><font color="#FF0000"><?php echo $kddept.'.'.$kdunit.'.'.$kdprogram ?></font></td>
      <td width="24%" align="left"><font color="#FF0000"><?php echo nm_program($kddept.$kdunit.$kdprogram) ?></font></td>
      <td align="right" valign="top"><font color="#FF0000"><?php echo number_format($Program['pagu_program'],"0",",",".") ?></font></td>
      <td align="right" valign="top"><font color="#FF0000"><?php echo number_format($Program['rencana_program'],"0",",",".") ?></font></td>
      <td align="center" valign="top"><font color="#FF0000"><?php echo number_format(($Program['rencana_program']/$Program['pagu_program'])*100,"2",",",".") ?></font></td>
      <td align="right" valign="top"><font color="#FF0000"><?php echo number_format($real_program,"0",",",".") ?></font></td>
      <td align="center" valign="top"><font color="#FF0000"><?php echo number_format(($real_program/$Program['pagu_program'])*100,"2",",",".") ?></font></td>
    </tr>
    <?php 
if($kdtriwulan == 1 ){	
	$sql = "select KDSATKER, sum(JUMLAH) as pagu_satker, sum(JANUARI + PEBRUARI + MARET) as rencana_satker from $table WHERE THANG='$th' and KDPROGRAM='$kdprogram' group by KDSATKER order by KDSATKER";
	
}elseif($kdtriwulan == 2 ){	
	$sql = "select KDSATKER, sum(JUMLAH) as pagu_satker, sum(JANUARI + PEBRUARI + MARET + APRIL + MEI + JUNI) as rencana_satker from $table WHERE THANG='$th' and KDPROGRAM='$kdprogram' group by KDSATKER order by KDSATKER";

}elseif($kdtriwulan == 3 ){	
	$sql = "select KDSATKER, sum(JUMLAH) as pagu_satker, sum(JANUARI + PEBRUARI + MARET + APRIL + MEI + JUNI + JULI + AGUSTUS +
			SEPTEMBER) as rencana_satker from $table WHERE THANG='$th' and KDPROGRAM='$kdprogram' group by KDSATKER order by KDSATKER";

}elseif($kdtriwulan == 4 ){	
	$sql = "select KDSATKER, sum(JUMLAH) as pagu_satker, sum(JANUARI + PEBRUARI + MARET + APRIL + MEI + JUNI + JULI + AGUSTUS +
			SEPTEMBER + OKTOBER + NOPEMBER + DESEMBER) as rencana_satker from $table WHERE THANG='$th' and KDPROGRAM='$kdprogram' group by KDSATKER order by KDSATKER";
}
	$aSatker = mysql_query($sql);
	while ($Satker = mysql_fetch_array($aSatker))
	{
	$kdsatker =  $Satker['KDSATKER'] ;
	$real_satker = realisasi_satker_tw($th,$kdsatker,$kdtriwulan);
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
		} # PROGRAM
		} # KEMENTERIAN
		} ?>
  </tbody>
  <tfoot>
    <tr> 
      <td colspan="12">&nbsp;</td>
    </tr>
  </tfoot>
</table>
