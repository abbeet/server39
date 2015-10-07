<?php
	checkauthentication();
	$p = $_GET['p'];
	$cari = $_GET['cari'];
	$xusername = $_SESSION['xusername'];
	$xlevel = $_SESSION['xlevel'];
	$table = "d_item";
	$field = get_field($table);
	$ed_link = "index.php?p=".get_edit_link($p);
	$del_link = "index.php?p=".get_delete_link($p);
	
	$th = date('Y');
	
	$sql = "select THANG,sum(JUMLAH) as pagu_dept from $table WHERE THANG='$th' group by KDDEPT";
	$aDept = mysql_query($sql);
	$count = mysql_num_rows($aDept);
	
	while ($Dept = mysql_fetch_array($aDept))
	{
		$col[0][] 	= $Dept['THANG'];
		$col[2][] 	= $Dept['pagu_dept'];
	}


echo "<strong> Tahun Anggaran : ".$th. "</strong>" ?>
<style type="text/css">
<!--
.style1 {color: #FF0000}
-->
</style>

<br />
<table width="319" cellpadding="1" class="adminlist">
  <thead>
    <tr> 
      <th rowspan="3">Kode APBN</th>
      <th rowspan="3">Nama Satuan Kerja</th>
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
      <td align="center"><strong><?php echo '082' ?></strong></td>
      <td align="left"><strong><?php echo nm_unit('820000') ?></strong></td>
      <td width="22%" align="right" class="row6"><strong><?php echo number_format($col[2][$k]/1000,"0",",",".") ?></strong></td>
      <td align="right" class="row6"><strong><?php echo number_format($pagu_51/1000,"0",",",".") ?></strong></td>
      <td align="right" class="row6"><strong><?php echo number_format($real_51/1000,"0",",",".") ?></strong></td>
      <td align="right" class="row6"><strong><?php if( $pagu_51 <> 0 ){ ?><?php echo number_format(($real_51/$pagu_51)*100,"2",",",".") ?><?php } ?></strong></td>
      <td align="right" class="row6"><strong><?php echo number_format($pagu_52/1000,"0",",",".") ?></strong></td>
      <td align="right" class="row6"><strong><?php echo number_format($real_52/1000,"0",",",".") ?></strong></td>
      <td align="right" class="row6"><strong><?php if( $pagu_52 <> 0 ){ ?><?php echo number_format(($real_52/$pagu_52)*100,"2",",",".") ?><?php } ?></strong></td>
      <td align="right" class="row6"><strong><?php echo number_format($pagu_53/1000,"0",",",".") ?></strong></td>
      <td align="right" class="row6"><strong><?php echo number_format($real_53/1000,"0",",",".") ?></strong></td>
      <td align="right" class="row6"><strong><?php if( $pagu_53 <> 0 ){ ?><?php echo number_format(($real_53/$pagu_53)*100,"2",",",".") ?><?php } ?></strong></td>
      <td align="right" class="row6"><strong><?php echo number_format($real_tot/1000,"0",",",".") ?></strong></td>
      <td align="right" class="row6"><strong><?php echo number_format(($real_tot/$col[2][$k])*100,"2",",",".") ?></strong></td>
      <td align="right" class="row6"><strong><?php echo number_format(($col[2][$k]-$real_tot)/1000,"0",",",".") ?></strong></td>
    </tr>
    
    <?php 
	
	switch ($xlevel)
	{
		case '1':
	$sql = "select THANG, KDSATKER, sum(JUMLAH) as pagu_satker from $table WHERE THANG='$th' and KDDEPT='082' group by KDSATKER order by KDSATKER";
			break;
		case '3':
	$sql = "select THANG, KDSATKER, sum(JUMLAH) as pagu_satker from $table WHERE THANG='$th' and KDDEPT='082' and KDSATKER = '$xusername' group by KDSATKER order by KDSATKER";
			break;
		case '4':
	$sql = "select THANG, KDSATKER, sum(JUMLAH) as pagu_satker from $table WHERE THANG='$th' and KDDEPT='082' group by KDSATKER order by KDSATKER";
			break;
		default:
	$sql = "select THANG, KDSATKER, sum(JUMLAH) as pagu_satker from $table WHERE THANG='$th' and KDDEPT='082' group by KDSATKER order by KDSATKER";
			break;
	}

	$aSatker = mysql_query($sql);
	while ($Satker = mysql_fetch_array($aSatker))
	{
	$kdsatker = $Satker['KDSATKER'] ;
	$pagu_51 = pagudipa_satker_jnsbel($th,'082',$kdsatker,51);
	$pagu_52 = pagudipa_satker_jnsbel($th,'082',$kdsatker,52);
	$pagu_53 = pagudipa_satker_jnsbel($th,'082',$kdsatker,53);
	$real_51 = realisasi_satker_jnsbel($th,$kdsatker,51);
	$real_52 = realisasi_satker_jnsbel($th,$kdsatker,52);
	$real_53 = realisasi_satker_jnsbel($th,$kdsatker,53);
	$real_tot = $real_51 + $real_52 + $real_53;
?>
    <tr bordercolor="#999999" class="row6"> 
      <td width="14%" align="center"><?php echo $kdsatker ?></td>
      <td width="64%" align="left"><?php echo nm_satker($kdsatker) ?></td>
      <td align="right" valign="top" class="row6"><?php echo number_format($Satker['pagu_satker']/1000,"0",",",".") ?></td>
      <td align="right" valign="top" class="row6"><?php echo number_format($pagu_51/1000,"0",",",".") ?></td>
      <td align="right" valign="top" class="row6"><?php echo number_format($real_51/1000,"0",",",".") ?></td>
      <td align="right" valign="top" class="row6"><?php if( $pagu_51 <> 0 ){?><?php echo number_format(($real_51/$pagu_51)*100,"2",",",".") ?><?php } ?></td>
      <td align="right" valign="top" class="row6"><?php echo number_format($pagu_52/1000,"0",",",".") ?></td>
      <td align="right" valign="top" class="row6"><?php echo number_format($real_52/1000,"0",",",".") ?></td>
      <td align="right" valign="top" class="row6"><?php if( $pagu_52 <> 0 ){?><?php echo number_format(($real_52/$pagu_52)*100,"2",",",".") ?><?php } ?></td>
      <td align="right" valign="top" class="row6"><?php echo number_format($pagu_53/1000,"0",",",".") ?></td>
      <td align="right" valign="top" class="row6"><?php echo number_format($real_53/1000,"0",",",".") ?></td>
      <td align="right" valign="top" class="row6"><?php if( $pagu_53 <> 0 ){?><?php echo number_format(($real_53/$pagu_53)*100,"2",",",".") ?><?php } ?></td>
      <td align="right" valign="top" class="row6"><?php echo number_format($real_tot/1000,"0",",",".") ?></td>
      <td align="right" valign="top" class="row6"><?php echo number_format(($real_tot/$Satker['pagu_satker'])*100,"2",",",".") ?></td>
      <td align="right" valign="top" class="row6"><?php echo number_format(($Satker['pagu_satker']-$real_tot)/1000,"0",",",".") ?></td>
    </tr>
    
    <?php
		} # SATKER
		} # KEMENTERIAN
		} ?>
  </tbody>
  <tfoot>
    <tr> 
      <td colspan="20">&nbsp;</td>
    </tr>
  </tfoot>
</table>
