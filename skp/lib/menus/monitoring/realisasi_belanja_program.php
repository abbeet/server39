<?php
	checkauthentication();
	$p = $_GET['p'];
	$cari = $_GET['cari'];
	$table = "d_item";
	$field = get_field($table);
	$ed_link = "index.php?p=".get_edit_link($p);
	$del_link = "index.php?p=".get_delete_link($p);
	
	$sql = "select KDDEPT, KDUNIT from setup_dept ";
	$aDept = mysql_query($sql);
	$Dept = mysql_fetch_array($aDept);
	$kddept = $Dept['KDDEPT'];
	$kdunit = $Dept['KDUNIT'];

	$th = date('Y');
	
	$sql = "select KDDEPT,KDUNIT,THANG,sum(JUMLAH) as pagu_dept from $table WHERE THANG='$th' group by KDDEPT";
	$aDept = mysql_query($sql);
	$count = mysql_num_rows($aDept);
	
	while ($Dept = mysql_fetch_array($aDept))
	{
		$col[0][] 	= $Dept['THANG'];
		$col[2][] 	= $Dept['pagu_dept'];
		$col[15][] 	= $Dept['KDDEPT'];
		$col[16][] 	= $Dept['KDUNIT'];
	}


echo "<strong> Tahun Anggaran : ".$th. "</strong>" ?>
<style type="text/css">
<!--
.style1 {color: #00a}
.style2 {color: #FF0000}
-->
</style>

<br />
<table width="319" cellpadding="1" class="adminlist">
  <thead>
    <tr> 
      <th rowspan="3">Kode APBN</th>
      <th rowspan="3">Nama Program/ <br />Nama Satker</th>
      <th rowspan="3">Pagu<br>
        Anggaran</th>
      <th colspan="12">Realisasi Anggaran<br>
        ( dalam ribuan rupiah )</th>
    </tr>
    <tr> 
      <th colspan="3">Belanja Pegawai </th>
      <th colspan="3">Belanja Barang </th>
      <th colspan="3">Belanja Modal </th>
      <th rowspan="2">Jumlah<br />Realisasi</th>
      <th rowspan="2">%</th>
      <th rowspan="2">Sisa</th>
    </tr>
    <tr>
      <th>DIPA</th>
      <th>Realisasi</th>
      <th>%</th>
      <th>DIPA</th>
      <th>Realisasi</th>
      <th>%</th>
      <th>DIPA</th>
      <th>Realisasi</th>
      <th>%</th>
    </tr>
  </thead>
  <tbody>
    <?php
		if ($count == 0) 
		{ ?>
    <tr> 
      <td align="center" colspan="21">Tidak ada data!</td>
    </tr>
    <?php
		}
		else {
			foreach ($col[0] as $k=>$val) {
				if ($k % 2 == 1) $class = "row0";
				else $class = "row1"; ?>
    <tr class="row6"> 
    <?php 
	$pagu_51 = pagudipa_lembaga_jnsbel($th,51);
	$pagu_52 = pagudipa_lembaga_jnsbel($th,52);
	$pagu_53 = pagudipa_lembaga_jnsbel($th,53);
	$real_51 = realisasi_lembaga_jnsbel($th,51);
	$real_52 = realisasi_lembaga_jnsbel($th,52);
	$real_53 = realisasi_lembaga_jnsbel($th,53);
	$real_tot = $real_51 + $real_52 + $real_53;
	?>
      <td align="center"><strong><?php echo $kddept.'.'.$kdunit ?></strong></td>
      <td align="left"><strong><?php echo nm_unit(substr($kddept,1,2).'0000') ?></strong></td>
      <td align="right" class="row6"><strong><?php echo number_format($col[2][$k]/1000,"0",",",".") ?></strong></td>
      <td align="right" class="row6"><strong><?php echo number_format($pagu_51/1000,"0",",",".") ?></strong></td>
      <td align="right" class="row6"><strong><?php echo number_format($real_51/1000,"0",",",".") ?></strong></td>
      <td align="right" class="row6"><strong><?php echo number_format(($real_51/$pagu_51)*100,"2",",",".") ?></strong></td>
      <td align="right" class="row6"><strong><?php echo number_format($pagu_52/1000,"0",",",".") ?></strong></td>
      <td align="right" class="row6"><strong><?php echo number_format($real_52/1000,"0",",",".") ?></strong></td>
      <td align="right" class="row6"><strong><?php echo number_format(($real_52/$pagu_52)*100,"2",",",".") ?></strong></td>
      <td align="right" class="row6"><strong><?php echo number_format($pagu_53/1000,"0",",",".") ?></strong></td>
      <td align="right" class="row6"><strong><?php echo number_format($real_53/1000,"0",",",".") ?></strong></td>
      <td align="right" class="row6"><strong><?php echo number_format(($real_53/$pagu_53)*100,"2",",",".") ?></strong></td>
      <td align="right" class="row6"><strong><?php echo number_format($real_tot/1000,"0",",",".") ?></strong></td>
      <td align="right" class="row6"><strong><?php echo number_format(($real_tot/$col[2][$k])*100,"2",",",".") ?></strong></td>
      <td align="right" class="row6"><strong><?php echo number_format(($col[2][$k]-$real_tot)/1000,"0",",",".") ?></strong></td>
    </tr>
    
    <?php 
	$kddept 		= $col[15][$k] ;
	$kdunit_dipa 	= $col[16][$k] ;
	$sql = "select KDPROGRAM, sum(JUMLAH) as pagu_program from $table WHERE THANG='$th' and KDDEPT='$kddept' and KDUNIT='$kdunit_dipa' group by KDPROGRAM order by KDPROGRAM";
	$aProgram = mysql_query($sql);
	while ($Program = mysql_fetch_array($aProgram))
	{
	$kdprogram = $Program['KDPROGRAM'] ;
	$pagu_51 = pagudipa_program_jnsbel($th,$kddept,$kdunit_dipa,$kdprogram,51);
	$pagu_52 = pagudipa_program_jnsbel($th,$kddept,$kdunit_dipa,$kdprogram,52);
	$pagu_53 = pagudipa_program_jnsbel($th,$kddept,$kdunit_dipa,$kdprogram,53);
	$real_51 = realisasi_program_jnsbel($th,$kddept,$kdunit_dipa,$kdprogram,51);
	$real_52 = realisasi_program_jnsbel($th,$kddept,$kdunit_dipa,$kdprogram,52);
	$real_53 = realisasi_program_jnsbel($th,$kddept,$kdunit_dipa,$kdprogram,53);
	$real_tot = $real_51 + $real_52 + $real_53;
?>
    <tr> 
      <td align="center"><?php echo $kddept.'.'.$kdunit_dipa.'.'.$kdprogram ?></td>
      <td align="left"><?php echo nm_program($kddept.$kdunit_dipa.$kdprogram) ?></td>
      <td align="right" class="row6"><?php echo number_format($Program['pagu_program']/1000,"0",",",".") ?></td>
      <td align="right" class="row6"><?php echo number_format($pagu_51/1000,"0",",",".") ?></td>
      <td align="right" class="row6"><?php echo number_format($real_51/1000,"0",",",".") ?></td>
      <td align="right" class="row6"><?php echo number_format(($real_51/$pagu_51)*100,"2",",",".") ?></td>
      <td align="right" class="row6"><?php echo number_format($pagu_52/1000,"0",",",".") ?></td>
      <td align="right" class="row6"><?php echo number_format($real_52/1000,"0",",",".") ?></td>
      <td align="right" class="row6"><?php echo number_format(($real_52/$pagu_52)*100,"2",",",".") ?></td>
      <td align="right" class="row6"><?php echo number_format($pagu_53/1000,"0",",",".") ?></td>
      <td align="right" class="row6"><?php echo number_format($real_53/1000,"0",",",".") ?></td>
      <td align="right" class="row6"><?php echo number_format(($real_53/$pagu_53)*100,"2",",",".") ?></td>
      <td align="right" class="row6"><?php echo number_format($real_tot/1000,"0",",",".") ?></td>
      <td align="right" class="row6"><?php echo number_format(($real_tot/$Program['pagu_program'])*100,"2",",",".") ?></td>
      <td align="right" class="row6"><?php echo number_format(($Program['pagu_program']-$real_tot)/1000,"0",",",".") ?></td>
    </tr>
    
    <?php
		} # PROGRAM
		} # KEMENTERIAN
		} ?>
  </tbody>
  <tfoot>
    <tr> 
      <td colspan="20">&nbsp;</td>
    </tr>
  </tfoot>
</table>
