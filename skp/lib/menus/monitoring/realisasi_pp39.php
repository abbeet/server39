<?php
	checkauthentication();
	
	$p = $_GET['p'];
	$cari = $_GET['cari'];
	$xusername = $_SESSION['xusername'];
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
<br />
<table width="741" cellpadding="1" class="adminlist">
  <thead>
    <tr> 
      <th rowspan="3">Kode APBN</th>
      <th rowspan="3">Nama Satuan Kerja / <br>
        Nama Kegiatan /<br />
		Output</th>
      <th colspan="5">Anggaran</th>
      <th colspan="3">Fisik</th>
    </tr>
    <tr>
      <th rowspan="2">Total<br />
      Pagu</th>
      <th colspan="2">Rencana Penarikan s/d<br />
        Triwulan <?php echo nmromawi($kdtriwulan) ?></th>
      <th colspan="2">Realisasi s/d<br />Triwulan <?php echo nmromawi($kdtriwulan) ?></th>
      <th rowspan="2">
      Keluaran</th>
      <th rowspan="2">Rencana s/d<br />Triwulan <?php echo nmromawi($kdtriwulan) ?></th>
      <th rowspan="2">Realisasi s/d<br />Triwulan <?php echo nmromawi($kdtriwulan) ?></th>
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
      <td align="center" colspan="16">Tidak ada data!</td>
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
      <td width="9%" align="right">&nbsp;</td>
      <td width="11%" align="right">&nbsp;</td>
      <td width="11%" align="right">&nbsp;</td>
    </tr>
    
    <?php 
if($kdtriwulan == 1 ){	

	switch ($xlevel)
	{
		case '1':
	$sql = "select THANG, KDSATKER, sum(JUMLAH) as pagu_satker, sum(JANUARI + PEBRUARI + MARET) as rencana_satker from $table WHERE THANG='$th' and KDDEPT='$kddept' group by KDSATKER order by KDSATKER";
			break;
		case '3':
	$sql = "select THANG, KDSATKER, sum(JUMLAH) as pagu_satker, sum(JANUARI + PEBRUARI + MARET) as rencana_satker from $table WHERE THANG='$th' and KDDEPT='$kddept' AND kdsatker = '$xusername' group by KDSATKER order by KDSATKER";
			break;
		case '4':
	$sql = "select THANG, KDSATKER, sum(JUMLAH) as pagu_satker, sum(JANUARI + PEBRUARI + MARET) as rencana_satker from $table WHERE THANG='$th' and KDDEPT='$kddept' AND left(kdunitkerja,3) = '$kddeputi' group by KDSATKER order by KDSATKER";
			break;
		case '5':
	$sql = "select THANG, KDSATKER, sum(JUMLAH) as pagu_satker, sum(JANUARI + PEBRUARI + MARET) as rencana_satker from $table WHERE THANG='$th' and KDDEPT='$kddept' AND left(kdunitkerja,4) = '$kdunit_kerja' group by KDSATKER order by KDSATKER";
			break;
		default:
	$sql = "select THANG, KDSATKER, sum(JUMLAH) as pagu_satker, sum(JANUARI + PEBRUARI + MARET) as rencana_satker from $table WHERE THANG='$th' and KDDEPT='$kddept' group by KDSATKER order by KDSATKER";
			break;
	}
	
}elseif($kdtriwulan == 2 ){

	switch ($xlevel)
	{
		case '1':
	$sql = "select THANG, KDSATKER, sum(JUMLAH) as pagu_satker, sum(JANUARI + PEBRUARI + MARET + APRIL + MEI + JUNI) as rencana_satker from $table WHERE THANG='$th' and KDDEPT='$kddept' group by KDSATKER order by KDSATKER";
			break;
		case '3':
	$sql = "select THANG, KDSATKER, sum(JUMLAH) as pagu_satker, sum(JANUARI + PEBRUARI + MARET + APRIL + MEI + JUNI) as rencana_satker from $table WHERE THANG='$th' and KDDEPT='$kddept' AND kdsatker = '$xusername' group by KDSATKER order by KDSATKER";
			break;
		case '4':
	$sql = "select THANG, KDSATKER, sum(JUMLAH) as pagu_satker, sum(JANUARI + PEBRUARI + MARET + APRIL + MEI + JUNI) as rencana_satker from $table WHERE THANG='$th' and KDDEPT='$kddept' AND left(kdunitkerja,3) = '$kddeputi' group by KDSATKER order by KDSATKER";
			break;
		case '5':
	$sql = "select THANG, KDSATKER, sum(JUMLAH) as pagu_satker, sum(JANUARI + PEBRUARI + MARET + APRIL + MEI + JUNI) as rencana_satker from $table WHERE THANG='$th' and KDDEPT='$kddept' AND left(kdunitkerja,4) = '$kdunit_kerja' group by KDSATKER order by KDSATKER";
			break;
		default:
	$sql = "select THANG, KDSATKER, sum(JUMLAH) as pagu_satker, sum(JANUARI + PEBRUARI + MARET + APRIL + MEI + JUNI) as rencana_satker from $table WHERE THANG='$th' and KDDEPT='$kddept' group by KDSATKER order by KDSATKER";
			break;
	}

}elseif($kdtriwulan == 3 ){	

	switch ($xlevel)
	{
		case '1':
	$sql = "select THANG, KDSATKER, sum(JUMLAH) as pagu_satker, sum(JANUARI + PEBRUARI + MARET + APRIL + MEI + JUNI + JULI + AGUSTUS +
			SEPTEMBER) as rencana_satker from $table WHERE THANG='$th' and KDDEPT='$kddept' group by KDSATKER order by KDSATKER";
			break;
		case '3':
	$sql = "select THANG, KDSATKER, sum(JUMLAH) as pagu_satker, sum(JANUARI + PEBRUARI + MARET + APRIL + MEI + JUNI + JULI + AGUSTUS +
			SEPTEMBER) as rencana_satker from $table WHERE THANG='$th' and KDDEPT='$kddept' AND kdsatker = '$xusername' group by KDSATKER order by KDSATKER";
			break;
		case '4':
	$sql = "select THANG, KDSATKER, sum(JUMLAH) as pagu_satker, sum(JANUARI + PEBRUARI + MARET + APRIL + MEI + JUNI + JULI + AGUSTUS +
			SEPTEMBER) as rencana_satker from $table WHERE THANG='$th' and KDDEPT='$kddept' AND left(kdunitkerja,3) = '$kddeputi' group by KDSATKER order by KDSATKER";
			break;
		case '5':
	$sql = "select THANG, KDSATKER, sum(JUMLAH) as pagu_satker, sum(JANUARI + PEBRUARI + MARET + APRIL + MEI + JUNI + JULI + AGUSTUS +
			SEPTEMBER) as rencana_satker from $table WHERE THANG='$th' and KDDEPT='$kddept' AND left(kdunitkerja,4) = '$kdunit_kerja' group by KDSATKER order by KDSATKER";
			break;
		default:
	$sql = "select THANG, KDSATKER, sum(JUMLAH) as pagu_satker, sum(JANUARI + PEBRUARI + MARET + APRIL + MEI + JUNI + JULI + AGUSTUS +
			SEPTEMBER) as rencana_satker from $table WHERE THANG='$th' and KDDEPT='$kddept' group by KDSATKER order by KDSATKER";
			break;
	}

}elseif($kdtriwulan == 4 ){	

	switch ($xlevel)
	{
		case '1':
	$sql = "select THANG, KDSATKER, sum(JUMLAH) as pagu_satker, sum(JANUARI + PEBRUARI + MARET + APRIL + MEI + JUNI + JULI + AGUSTUS +
			SEPTEMBER + OKTOBER + NOPEMBER + DESEMBER) as rencana_satker from $table WHERE THANG='$th' and KDDEPT='$kddept' group by KDSATKER order by KDSATKER";
			break;
		case '3':
	$sql = "select THANG, KDSATKER, sum(JUMLAH) as pagu_satker, sum(JANUARI + PEBRUARI + MARET + APRIL + MEI + JUNI + JULI + AGUSTUS +
			SEPTEMBER + OKTOBER + NOPEMBER + DESEMBER) as rencana_satker from $table WHERE THANG='$th' and KDDEPT='$kddept' AND kdsatker = '$xusername'  group by KDSATKER order by KDSATKER";
			break;
		case '4':
	$sql = "select THANG, KDSATKER, sum(JUMLAH) as pagu_satker, sum(JANUARI + PEBRUARI + MARET + APRIL + MEI + JUNI + JULI + AGUSTUS +
			SEPTEMBER + OKTOBER + NOPEMBER + DESEMBER) as rencana_satker from $table WHERE THANG='$th' and KDDEPT='$kddept' AND left(kdunitkerja,3) = '$kddeputi' group by KDSATKER order by KDSATKER";
			break;
		case '5':
	$sql = "select THANG, KDSATKER, sum(JUMLAH) as pagu_satker, sum(JANUARI + PEBRUARI + MARET + APRIL + MEI + JUNI + JULI + AGUSTUS +
			SEPTEMBER + OKTOBER + NOPEMBER + DESEMBER) as rencana_satker from $table WHERE THANG='$th' and KDDEPT='$kddept' AND left(kdunitkerja,4) = '$kdunit_kerja' group by KDSATKER order by KDSATKER";
			break;
		default:
	$sql = "select THANG, KDSATKER, sum(JUMLAH) as pagu_satker, sum(JANUARI + PEBRUARI + MARET + APRIL + MEI + JUNI + JULI + AGUSTUS +
			SEPTEMBER + OKTOBER + NOPEMBER + DESEMBER) as rencana_satker from $table WHERE THANG='$th' and KDDEPT='$kddept' group by KDSATKER order by KDSATKER";
			break;
	}

}	
	$aSatker = mysql_query($sql);
	while ($Satker = mysql_fetch_array($aSatker))
	{
	$kdsatker = $Satker['KDSATKER'] ;
	$real_satker = realisasi_satker_tw($th,$kdsatker,$kdtriwulan);
?>
    <tr bordercolor="#999999" class="<?php echo $class ?>"> 
      <td width="6%" align="center"><font color="#FF0000"><?php echo $kdsatker ?></font></td>
      <td width="24%" align="left"><font color="#FF0000"><?php echo nm_satker($kdsatker) ?></font></td>
      <td align="right" valign="top"><font color="#FF0000"><?php echo number_format($Satker['pagu_satker'],"0",",",".") ?></font></td>
      <td align="right" valign="top"><font color="#FF0000"><?php echo number_format($Satker['rencana_satker'],"0",",",".") ?></font></td>
      <td align="center" valign="top"><font color="#FF0000"><?php echo number_format(($Satker['rencana_satker']/$Satker['pagu_satker'])*100,"2",",",".") ?></font></td>
      <td align="right" valign="top"><font color="#FF0000"><?php echo number_format($real_satker,"0",",",".") ?></font></td>
      <td align="center" valign="top"><font color="#FF0000"><?php echo number_format(($real_satker/$Satker['pagu_satker'])*100,"2",",",".") ?></font></td>
      <td align="right" valign="top">&nbsp;</td>
      <td align="right" valign="top">&nbsp;</td>
      <td align="right" valign="top">&nbsp;</td>
    </tr>
    <?php 
if($kdtriwulan == 1 ){	
	$sql = "select KDGIAT, sum(JUMLAH) as pagu_giat, sum(JANUARI + PEBRUARI + MARET) as rencana_giat from $table WHERE THANG='$th' and KDSATKER='$kdsatker' group by KDGIAT order by KDGIAT";
	
}elseif($kdtriwulan == 2 ){	
	$sql = "select KDGIAT, sum(JUMLAH) as pagu_giat, sum(JANUARI + PEBRUARI + MARET + APRIL + MEI + JUNI) as rencana_giat from $table WHERE THANG='$th' and KDSATKER='$kdsatker' group by KDGIAT order by KDGIAT";

}elseif($kdtriwulan == 3 ){	
	$sql = "select KDGIAT, sum(JUMLAH) as pagu_giat, sum(JANUARI + PEBRUARI + MARET + APRIL + MEI + JUNI + JULI + AGUSTUS +
			SEPTEMBER) as rencana_giat from $table WHERE THANG='$th' and KDSATKER='$kdsatker' group by KDGIAT order by KDGIAT";

}elseif($kdtriwulan == 4 ){	
	$sql = "select KDGIAT, sum(JUMLAH) as pagu_giat, sum(JANUARI + PEBRUARI + MARET + APRIL + MEI + JUNI + JULI + AGUSTUS +
			SEPTEMBER + OKTOBER + NOPEMBER + DESEMBER) as rencana_giat from $table WHERE THANG='$th' and KDSATKER='$kdsatker' group by KDGIAT order by KDGIAT";
}
	$aGiat = mysql_query($sql);
	while ($Giat = mysql_fetch_array($aGiat))
	{
	$kdgiat =  $Giat['KDGIAT'] ;
	$real_giat = realisasi_giat_tw($th,$kdsatker,$kdgiat,$kdtriwulan);
	?>
    <tr class="<?php echo $class ?>"> 
      <td align="center" valign="top"><span class="style1"><?php echo $Giat['KDGIAT'] ?></span></td>
      <td align="left" valign="top"><span class="style1"><?php echo nm_giat($Giat['KDGIAT']) ?></span></td>
      <td align="right" valign="top"><span class="style1"><?php echo number_format($Giat['pagu_giat'],"0",",",".") ?></span></td>
      <td align="right" valign="top"><span class="style1"><?php echo number_format($Giat['rencana_giat'],"0",",",".") ?></span></td>
      <td align="center" valign="top"><span class="style1"><?php echo number_format(($Giat['rencana_giat']/$Giat['pagu_giat'])*100,"2",",",".") ?></span></td>
      <td align="right" valign="top"><span class="style1"><?php echo number_format($real_giat,"0",",",".") ?></span></td>
      <td align="center" valign="top"><?php echo number_format(($real_giat/$Giat['pagu_giat'])*100,"2",",",".") ?></td>
      <td align="right" valign="top">&nbsp;</td>
      <td align="right" valign="top">&nbsp;</td>
      <td align="right" valign="top">&nbsp;</td>
    </tr>
    <?php 
if($kdtriwulan == 1 ){	
	$sql = "select KDOUTPUT, sum(JUMLAH) as pagu_output, sum(JANUARI + PEBRUARI + MARET) as rencana_output from $table WHERE THANG='$th' and KDSATKER='$kdsatker' and KDGIAT='$kdgiat' group by KDOUTPUT order by KDOUTPUT";
	
}elseif($kdtriwulan == 2 ){	
	$sql = "select KDOUTPUT, sum(JUMLAH) as pagu_output, sum(JANUARI + PEBRUARI + MARET + APRIL + MEI + JUNI) as rencana_output from $table WHERE THANG='$th' and KDSATKER='$kdsatker' and KDGIAT='$kdgiat' group by KDOUTPUT order by KDOUTPUT";

}elseif($kdtriwulan == 3 ){	
	$sql = "select KDOUTPUT, sum(JUMLAH) as pagu_output, sum(JANUARI + PEBRUARI + MARET + APRIL + MEI + JUNI + JULI + AGUSTUS +
			SEPTEMBER) as rencana_output from $table WHERE THANG='$th' and KDSATKER='$kdsatker' and KDGIAT='$kdgiat' group by KDOUTPUT order by KDOUTPUT";

}elseif($kdtriwulan == 4 ){	
	$sql = "select KDOUTPUT, sum(JUMLAH) as pagu_output, sum(JANUARI + PEBRUARI + MARET + APRIL + MEI + JUNI + JULI + AGUSTUS +
			SEPTEMBER + OKTOBER + NOPEMBER + DESEMBER) as rencana_output from $table WHERE THANG='$th' and KDSATKER='$kdsatker' and KDGIAT='$kdgiat' group by KDOUTPUT order by KDOUTPUT";
}
	$aOutput = mysql_query($sql);
	while ($Output = mysql_fetch_array($aOutput))
	{
	$kdoutput =  $Output['KDOUTPUT'] ;
	$real_output = realisasi_output_tw($th,$kdsatker,$kdgiat,$kdoutput,$kdtriwulan);
	$sql = "select VOL from d_output WHERE THANG='$th' and KDSATKER='$kdsatker' and KDGIAT='$kdgiat' and KDOUTPUT='$kdoutput'";
	$aOutput_vol = mysql_query($sql);
	$Output_vol = mysql_fetch_array($aOutput_vol);
	$rencana_fisik = rencana_fisik($th,$kdgiat,$kdoutput,$kdtriwulan) ;
	$realisasi_fisik = realisasi_fisik($th,$kdgiat,$kdoutput,$kdtriwulan) ;
	?>
    <tr class="<?php echo $class ?>">
      <td align="center" valign="top"><span class="style2"><?php echo $kdoutput?></span></td>
      <td align="left" valign="top"><span class="style2"><?php echo nm_output($kdgiat.$kdoutput) ?></span></td>
      <td align="right" valign="top"><span class="style2"><?php echo number_format($Output['pagu_output'],"0",",",".") ?></span></td>
      <td align="right" valign="top"><span class="style2"><?php echo number_format($Output['rencana_output'],"0",",",".") ?></span></td>
      <td align="center" valign="top"><span class="style2"><?php echo number_format(($Output['rencana_output']/$Output['pagu_output'])*100,"2",",",".") ?></span></td>
      <td align="right" valign="top"><span class="style2"><?php echo number_format($real_output,"0",",",".") ?></span></td>
      <td align="center" valign="top"><span class="style2"><?php echo number_format(($real_output/$Output['pagu_output'])*100,"2",",",".") ?></span></td>
      <td align="center" valign="top"><?php echo $Output_vol['VOL'].' '.sat_output($kdgiat.$kdoutput) ?></td>
      <td align="center" valign="top"><?php if( $rencana_fisik > 0 ) {?><?php echo $rencana_fisik.' %' ?><?php }?></span></td>
      <td align="center" valign="top"><?php if( $realisasi_fisik > 0 ) {?><?php echo $realisasi_fisik.' %' ?><?php }?></span></td>
    </tr>
    
    <?php
		} # OUTPUT
		} # GIAT
		} # SATKER
		} # KEMENTERIAN
		} ?>
  </tbody>
  <tfoot>
    <tr> 
      <td colspan="15">&nbsp;</td>
    </tr>
  </tfoot>
</table>
