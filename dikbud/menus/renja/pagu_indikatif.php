<?php
	checkauthentication();
	$p = $_GET['p'];
	$cari = $_GET['cari'];
	$xlevel = $_SESSION['xlevel'];
	$xusername = $_SESSION['xusername'];
	$xkdunit = $_SESSION['xkdunit'];
	$kddeputi = substr($xkdunit,0,3);
	$table = "thbp_kak_kegiatan";
	$field = get_field($table);
	$ed_link = "index.php?p=".get_edit_link($p);
	$del_link = "index.php?p=".get_delete_link($p);
	
	$th = $_SESSION['xth'] + 1;
//	if($cari=='') $cari = date('Y')+1;
	
	#Halaman yang akan ditampilkan untuk pertengahan?
	$adjacents = 1;
 
	switch ($xlevel)
	{
		case '3':
	$query = "SELECT COUNT(kdunitkerja) as num FROM $table WHERE th = '$th' and left(kdunitkerja,3) = '$kddeputi' GROUP BY left(kdunitkerja,3)";
			break;
		case '4':
	$query = "SELECT COUNT(kdunitkerja) as num FROM $table WHERE th = '$th' and left(kdunitkerja,3) = '$kddeputi' GROUP BY left(kdunitkerja,3)";
			break;
		case '5':
	$query = "SELECT COUNT(kdunitkerja) as num FROM $table WHERE left(kdunitkerja,3) = '$kddeputi' and th = '$th' GROUP BY left(kdunitkerja,3)";
			break;
		case '6':
	$query = "SELECT COUNT(kdunitkerja) as num FROM $table WHERE left(kdunitkerja,3) = '$kddeputi' and th = '$th' GROUP BY left(kdunitkerja,3)";
			break;
		default:
	$query = "SELECT COUNT(kdunitkerja) as num FROM $table WHERE th = '$th' GROUP BY left(kdunitkerja,3)";
			break;
	}
	$total_pages = mysql_fetch_array(mysql_query($query));
	$total_pages = $total_pages[num];
	
	#variabel query
	$targetpage = "index.php?p=$p&cari=$cari"; 	#nama file  (nama file ini)
	$limit = 1; 							#berapa yang akan ditampilkan setiap halaman
	$pagess = $_GET['pagess'];
	if($pagess) 
		$start = ($pagess - 1) * $limit; 			
	else
		$start = 0;							#halaman awal
		
	switch ($xlevel)
	{
		case '3':
	$oList = mysql_query("SELECT th,left(kdunitkerja,3) as deputi,sum(jml_anggaran_renstra) as jml_ang_renstra,
						sum(jml_anggaran_dipa) as jml_ang_dipa, sum(jml_anggaran_indikatif) as jml_ang_indikatif
						 FROM $table WHERE th = '$th' and left(kdunitkerja,3) = '$kddeputi' GROUP BY left(kdunitkerja,3) ORDER BY left(kdunitkerja,3)
						 LIMIT $start, $limit");
			break;
		case '4':
	$oList = mysql_query("SELECT th,left(kdunitkerja,3) as deputi,sum(jml_anggaran_renstra) as jml_ang_renstra,
						sum(jml_anggaran_dipa) as jml_ang_dipa, sum(jml_anggaran_indikatif) as jml_ang_indikatif
						 FROM $table WHERE th = '$th' and left(kdunitkerja,3) = '$kddeputi' GROUP BY left(kdunitkerja,3) ORDER BY left(kdunitkerja,3)
						 LIMIT $start, $limit");
			break;
		case '5':
	$oList = mysql_query("SELECT th,left(kdunitkerja,3) as deputi,sum(jml_anggaran_renstra) as jml_ang_renstra,
						sum(jml_anggaran_dipa) as jml_ang_dipa, sum(jml_anggaran_indikatif) as jml_ang_indikatif FROM $table WHERE left(kdunitkerja,3) = '$kddeputi' and th = '$th' GROUP BY left(kdunitkerja,3) ORDER BY kdunitkerja LIMIT $start, $limit");
			break;
		case '6':
	$oList = mysql_query("SELECT th,left(kdunitkerja,3) as deputi,sum(jml_anggaran_renstra) as jml_ang_renstra,
						sum(jml_anggaran_dipa) as jml_ang_dipa, sum(jml_anggaran_indikatif) as jml_ang_indikatif FROM $table WHERE left(kdunitkerja,3) = '$kddeputi' and th = '$th' GROUP BY left(kdunitkerja,3) ORDER BY kdunitkerja LIMIT $start, $limit");
			break;
		default:
	$oList = mysql_query("SELECT th,left(kdunitkerja,3) as deputi,sum(jml_anggaran_renstra) as jml_ang_renstra,
						sum(jml_anggaran_dipa) as jml_ang_dipa, sum(jml_anggaran_indikatif) as jml_ang_indikatif FROM $table WHERE th = '$th' GROUP BY left(kdunitkerja,3) ORDER BY left(kdunitkerja,3) LIMIT $start, $limit");
			break;
	}

	$count = mysql_num_rows($oList);
	
	while($List = mysql_fetch_object($oList)) {
		$col[0][] = $List->th;
		$col[1][] = $List->th;
		$col[2][] = $List->deputi;
		$col[3][] = $List->jml_ang_renstra;
		$col[4][] = $List->jml_ang_dipa;
		$col[5][] = $List->jml_ang_indikatif;
	}
	
	if ($pagess == 0) $pagess = 1;	#jika variabel kosong maka defaultnya halaman pertama.
	$prev = $pagess - 1;					#halaman sebelumnya
	$next = $pagess + 1;					#halaman berikutnya
	$lastpage = ceil($total_pages/$limit);		
	$lpm1 = $lastpage - 1;						
 
	$pagination = "";
	if($lastpage > 1)
	{	
		$pagination .= "<div class=\"pagination\">";
		#Link halaman sebelumnya
		if ($pagess > 1) 
			$pagination.= "<a href=\"$targetpage&pagess=$prev\"><< Sebelumnya</a>";
		else
			$pagination.= "<span class=\"disabled\"><< Sebelumnya</span>";	
 
		#halaman
		if ($lastpage < 7 + ($adjacents * 2))	
		{	
			for ($counter = 1; $counter <= $lastpage; $counter++)
			{
				if ($counter == $pagess)
					$pagination.= "<span class=\"current\">$counter</span>";
				else
					$pagination.= "<a href=\"$targetpage&pagess=$counter\">$counter</a>";					
			}
		}
		elseif($lastpage > 5 + ($adjacents * 2))	#enough pages to hide some
		{
 
			if($pagess < 1 + ($adjacents * 2))		
			{
				for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
				{
					if ($counter == $pagess)
						$pagination.= "<span class=\"current\">$counter</span>";
					else
						$pagination.= "<a href=\"$targetpage&pagess=$counter\">$counter</a>";					
				}
				$pagination.= "...";
				$pagination.= "<a href=\"$targetpage&pagess=$lpm1\">$lpm1</a>";
				$pagination.= "<a href=\"$targetpage&pagess=$lastpage\">$lastpage</a>";		
			}
 
			elseif($lastpage - ($adjacents * 2) > $pagess && $pagess > ($adjacents * 2))
			{
				$pagination.= "<a href=\"$targetpage&pagess=1\">1</a>";
				$pagination.= "<a href=\"$targetpage&pagess=2\">2</a>";
				$pagination.= "...";
				for ($counter = $pagess - $adjacents; $counter <= $pagess + $adjacents; $counter++)
				{
					if ($counter == $pagess)
						$pagination.= "<span class=\"current\">$counter</span>";
					else
						$pagination.= "<a href=\"$targetpage&pagess=$counter\">$counter</a>";					
				}
				$pagination.= "...";
				$pagination.= "<a href=\"$targetpage&pagess=$lpm1\">$lpm1</a>";
				$pagination.= "<a href=\"$targetpage&pagess=$lastpage\">$lastpage</a>";		
			}
 
			else
			{
				$pagination.= "<a href=\"$targetpage&pagess=1\">1</a>";
				$pagination.= "<a href=\"$targetpage&pagess=2\">2</a>";
				$pagination.= "...";
				for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
				{
					if ($counter == $pagess)
						$pagination.= "<span class=\"current\">$counter</span>";
					else
						$pagination.= "<a href=\"$targetpage&pagess=$counter\">$counter</a>";					
				}
			}
		}
 
		#link halaman selanjutnya
		if ($pagess < $counter - 1) 
			$pagination.= "<a href=\"$targetpage&pagess=$next\">Selanjutnya >></a>";
		else
			$pagination.= "<span class=\"disabled\">Selanjutnya >></span>";
		$pagination.= "</div>\n";		
	}
	
	echo $pagination;
?>
<style type="text/css">
<!--
.style1 {color: #CC0000}
-->
</style>

<strong><font size="2"><?php echo 'Perencanaan Tahun '.$th ?></font></strong><br />
<a href="menus/renja/baseline_anggaran_prn.php?th=<?php echo $th ?>&xlevel=
<?php echo $xlevel ?>&xkdunit=<?php echo $xkdunit ?>" title="Cetak Baseline Anggaran" target="_blank"> 
        <img src="css/images/menu/icon-16-print.png" border="0" width="16" height="16">Cetak PDF
</a>&nbsp;|&nbsp;
<a href="menus/renja/baseline_anggaran_xls.php?th=<?php echo $th ?>&xlevel=
<?php echo $xlevel ?>&xkdunit=<?php echo $xkdunit ?>" title="Cetak Baseline Anggaran" target="_blank"> EXCEL</a>
<table width="544" cellpadding="1" class="adminlist">
  <thead>
    <tr> 
      <th width="10%" rowspan="2">Satuan Kerja  </th>
      <th width="7%" rowspan="2">Kode<br>
        Giat</th>
      <th width="24%" rowspan="2">Kegiatan</th>
      <th colspan="2">Alokasi Anggaran</th>
      <th rowspan="2">Aksi</th>
    </tr>
    <tr> 
      <th width="12%">DIPA Tahun <?php echo $th - 1 ?></th>
      <th width="8%">Pagu<br>
      Indikatif<br /><?php echo $th ?></th>
    </tr>
  </thead>
  <tbody>
    <?php
		if ($count == 0) { ?>
    <tr> 
      <td align="center" colspan="6">Tidak ada data!</td>
    </tr>
    <?php
		}
		else {
			
			$sql = "SELECT SUM(jml_anggaran_renstra) as jml_anggaran_renstra, SUM(jml_anggaran_dipa) as jml_anggaran_dipa,
			               SUM(jml_anggaran_indikatif) as jml_anggaran_indikatif FROM thbp_kak_kegiatan WHERE th = '$th' ";
			$qu = mysql_query($sql);
			$row = mysql_fetch_array($qu);
		?>
    <tr> 
      <td colspan="3"><strong><?php echo nm_unit('480000') ?></strong></td>
      <td align="right"><strong><?php echo number_format($row['jml_anggaran_dipa'],"0",",","."); ?></strong></td>
      <td align="right"><strong>
        <?php if( renja_output_lembaga($th) <> $row['jml_anggaran_indikatif'] ){ ?>
        <font color="#FF0000"><?php echo number_format($row['jml_anggaran_indikatif'],"0",",","."); ?></font>
        <?php }else{ ?>
        <?php echo number_format($row['jml_anggaran_indikatif'],"0",",","."); ?>
        <?php } ?>
        </strong></td>
      <td><strong></strong></td>
    </tr>
    
    <?php
			foreach ($col[0] as $k=>$val) {
				$kddeputi_dt = substr($col[2][$k],0,3);
				$th = $col[1][$k];

				if ($k % 2 == 1) $class = "row0";
				else $class = "row1"; ?>
    <tr bgcolor="#B9EEFF"> 
      <td colspan="3" align="left" valign="top" class="row7"><?php echo ket_unit(substr($col[2][$k],0,3).'000') ?>      </td>
      <td align="right" valign="top" class="row7"><?php echo number_format($col[4][$k],"0",",",".") ?> </td>
      <td align="right" valign="top" class="row7">
	  <?php if( renja_output_deputi($th,substr($col[2][$k],0,3)) <> $col[5][$k] ){?>
	  <font color="#FF0000"><?php echo number_format($col[5][$k],"0",",",".") ?></font>
	  <?php }else{ ?><?php echo number_format($col[5][$k],"0",",",".") ?>
	  <?php } ?>	  </td>
      <td width="13%" align="center" valign="top" class="row7"> </td>
    </tr>
<?php 
	switch ($xlevel)
	{
		case '3':
	$sql = "SELECT * FROM thbp_kak_kegiatan WHERE th = '$th' and kdunitkerja = '$xkdunit' order by concat(kdunitkerja,kdgiat)";
			break;
		case '4':
	$sql = "SELECT * FROM thbp_kak_kegiatan WHERE th = '$th' and left(kdunitkerja,3) = '$kddeputi_dt' order by concat(kdunitkerja,kdgiat)";
			break;
		case '5':
	$sql = "SELECT * FROM thbp_kak_kegiatan WHERE th = '$th' and kdunitkerja = '$xkdunit' order by concat(kdunitkerja,kdgiat)";
			break;
		case '6':
	$sql = "SELECT * FROM thbp_kak_kegiatan WHERE th = '$th' and left(kdunitkerja,3) = '$kddeputi_dt' order by concat(kdunitkerja,kdgiat)";
			break;
		default:
	$sql = "SELECT * FROM thbp_kak_kegiatan WHERE th = '$th' and left(kdunitkerja,3) = '$kddeputi_dt' order by concat(kdunitkerja,kdgiat)";
			break;
	}	
	
	$oUnitkerja = mysql_query($sql);
	while($Unitkerja = mysql_fetch_array($oUnitkerja)){
?>	
	
    <tr class="<?php echo $class ?>">
      <td align="left" valign="top"><?php echo ket_unit($Unitkerja['kdunitkerja']) ?></td>
      <td align="center" valign="top"><?php echo $Unitkerja['kdgiat'] ?></td>
      <td align="left" valign="top"><?php echo nm_giat($Unitkerja['kdgiat']) ?></td>
      <td align="right" valign="top"><?php echo number_format($Unitkerja['jml_anggaran_dipa'],"0",",",".") ?></td>
      <td align="right" valign="top"><?php echo number_format($Unitkerja['jml_anggaran_indikatif'],"0",",",".") ?>
	  </td>
      <td align="center" valign="top"><a href="index.php?p=452&q=<?php echo $Unitkerja['id'] ?>" title="Edit Kegiatan"> 
        <img src="css/images/edit_f2.png" border="0" width="16" height="16"><font size="1">Kegiatan>></font></a><br />
	  <a href="index.php?p=453&u=<?php echo $Unitkerja['kdunitkerja'] ?>&g=<?php echo $Unitkerja['kdgiat'] ?>&t=<?php echo $Unitkerja['th'] ?>" title="Edit Output"><img src="css/images/edit_f2.png" border="0" width="16" height="16"><font size="1">Output>></font></a></td>
    </tr>
    <?php
			}
			}
		} ?>
  </tbody>
  <tfoot>
    <tr> 
      <td colspan="6">&nbsp;</td>
    </tr>
  </tfoot>
</table>
<?php 
	function renja_output_lembaga($th) {
		$data = mysql_query("select sum(jml_anggaran) as jumlah from thbp_kak_output where th = '$th' group by th ");
		$rdata = mysql_fetch_array($data);
		$result = $rdata['jumlah'];
		return $result;
	}

	function renja_output_deputi($th,$kddeputi) {
		$data = mysql_query("select sum(jml_anggaran) as jumlah from thbp_kak_output where th='$th' and left(kdunitkerja,3) = '$kddeputi' group by left(kdunitkerja,3) ");
		$rdata = mysql_fetch_array($data);
		$result = $rdata['jumlah'];
		return $result;
	}
	
	function renja_output_unit($th,$kdunit) {
		$data = mysql_query("select sum(jml_anggaran) as jumlah from thbp_kak_output where th='$th' and kdunitkerja = '$kdunit' group by kdunitkerja ");
		$rdata = mysql_fetch_array($data);
		$result = $rdata['jumlah'];
		return $result;
	}
?>