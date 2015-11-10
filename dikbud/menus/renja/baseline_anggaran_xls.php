<?php
	include_once "../../includes/includes.php";
	$xlevel = $_REQUEST['xlevel'];
	$xkdunit = $_REQUEST['xkdunit'];
	$kddeputi = substr($xkdunit,0,3);
	$table = "thbp_kak_kegiatan";
	$field = get_field($table);
	$ed_link = "index.php?p=".get_edit_link($p);
	$del_link = "index.php?p=".get_delete_link($p);
	$th = $_REQUEST['th'];
		
	switch ($xlevel)
	{
		case '3':
	$oList = mysql_query("SELECT th,left(kdunitkerja,3) as deputi,sum(jml_anggaran_renstra) as jml_ang_renstra,
						sum(jml_anggaran_dipa) as jml_ang_dipa, sum(jml_anggaran_indikatif) as jml_ang_indikatif
						 FROM $table WHERE th = '$th' and left(kdunitkerja,3) = '$kddeputi' GROUP BY left(kdunitkerja,3) ORDER BY left(kdunitkerja,3)");
			break;
		case '4':
	$oList = mysql_query("SELECT th,left(kdunitkerja,3) as deputi,sum(jml_anggaran_renstra) as jml_ang_renstra,
						sum(jml_anggaran_dipa) as jml_ang_dipa, sum(jml_anggaran_indikatif) as jml_ang_indikatif
						 FROM $table WHERE th = '$th' and left(kdunitkerja,3) = '$kddeputi' GROUP BY left(kdunitkerja,3) ORDER BY left(kdunitkerja,3)");
			break;
		case '5':
	$oList = mysql_query("SELECT th,left(kdunitkerja,3) as deputi,sum(jml_anggaran_renstra) as jml_ang_renstra,
						sum(jml_anggaran_dipa) as jml_ang_dipa, sum(jml_anggaran_indikatif) as jml_ang_indikatif FROM $table WHERE left(kdunitkerja,3) = '$kddeputi' and th = '$th' GROUP BY left(kdunitkerja,3) ORDER BY kdunitkerja ");
			break;
		case '6':
	$oList = mysql_query("SELECT th,left(kdunitkerja,3) as deputi,sum(jml_anggaran_renstra) as jml_ang_renstra,
						sum(jml_anggaran_dipa) as jml_ang_dipa, sum(jml_anggaran_indikatif) as jml_ang_indikatif FROM $table WHERE left(kdunitkerja,3) = '$kddeputi' and th = '$th' GROUP BY left(kdunitkerja,3) ORDER BY kdunitkerja ");
			break;
		default:
	$oList = mysql_query("SELECT th,left(kdunitkerja,3) as deputi,sum(jml_anggaran_renstra) as jml_ang_renstra,
						sum(jml_anggaran_dipa) as jml_ang_dipa, sum(jml_anggaran_indikatif) as jml_ang_indikatif FROM $table WHERE th = '$th' GROUP BY left(kdunitkerja,3) ORDER BY left(kdunitkerja,3) ");
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
	header("Content-type: application/octet-stream");
	$filename = "baseline_anggaran_" . $th . ".xls";
	header("Content-Disposition: attachment; filename=\"$filename\"");
	header("Pragma: no-cache");
	header("Expires: 0");
	print("<b>");
	print("<b>");
	print("BASELINE ANGGARAN KEGIATAN TAHUN " . $th . "<br><br>");
?>
<table width="544" cellpadding="1" class="adminlist">
  <thead>
    <tr> 
      <th width="10%" rowspan="2">Satuan Kerja  </th>
      <th width="7%" rowspan="2">Kode<br>
        Giat</th>
      <th width="24%" rowspan="2">Kegiatan</th>
      <th colspan="3">Alokasi Anggaran</th>
    </tr>
    <tr> 
      <th width="12%">DIPA Tahun <?php echo $th - 1 ?></th>
      <th width="8%">Pagu<br>
      Indikatif<br /><?php echo $th ?></th>
      <th width="9%">Usulan Satker </th>
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
			               SUM(jml_anggaran_indikatif) as jml_anggaran_indikatif FROM thbp_kak_kegiatan WHERE th LIKE '%".$th."%'";
			$qu = mysql_query($sql);
			$row = mysql_fetch_array($qu);
		?>
    <tr> 
      <td colspan="3"><strong><?php echo nm_unit('820000') ?></strong></td>
      <td align="right"><strong><?php echo $row['jml_anggaran_dipa'] ?></strong></td>
      <td align="right"><strong>
        <?php if( renja_output_lembaga($th) <> $row['jml_anggaran_indikatif'] ){ ?>
        <font color="#FF0000"><?php echo $row['jml_anggaran_indikatif'] ?></font>
        <?php }else{ ?>
        <?php echo $row['jml_anggaran_indikatif'] ?>
        <?php } ?>
        </strong></td>
      <td align="right"><strong>
      <?php if( renja_output_lembaga($th) <> $row['jml_anggaran_indikatif'] ){ ?>
	  <font color="#660033"><?php echo renja_output_lembaga($th) ?></font>
	  <?php }else{ ?>
	  <?php echo renja_output_lembaga($th) ?>
	  <?php }?></strong>	  </td>
    </tr>
    
    <?php
			foreach ($col[0] as $k=>$val) {
				$kddeputi_dt = substr($col[2][$k],0,3);
				$th = $col[1][$k];

				if ($k % 2 == 1) $class = "row0";
				else $class = "row1"; ?>
    <tr bgcolor="#B9EEFF"> 
      <td colspan="3" align="left" valign="top" class="row7"><?php echo ket_unit(substr($col[2][$k],0,3).'000') ?>      </td>
      <td align="right" valign="top" class="row7"><?php echo $col[4][$k] ?> </td>
      <td align="right" valign="top" class="row7">
	  <?php if( renja_output_deputi($th,substr($col[2][$k],0,3)) <> $col[5][$k] ){?>
	  <font color="#FF0000"><?php echo $col[5][$k] ?></font>
	  <?php }else{ ?><?php echo $col[5][$k] ?>
	  <?php } ?>	  </td>
      <td align="right" valign="top" class="row7">
	  <?php if( renja_output_deputi($th,substr($col[2][$k],0,3)) <> $col[5][$k] ){?>
	  <font color="#660033"><?php echo renja_output_deputi($th,substr($col[2][$k],0,3)) ?></font>
	  <?php }else{ ?>
	  <?php echo renja_output_deputi($th,substr($col[2][$k],0,3)) ?>
	  <?php } ?>	  </td>
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
      <td align="right" valign="top"><?php echo $Unitkerja['jml_anggaran_dipa'] ?></td>
      <td align="right" valign="top">
	  <?php if( renja_output_unit($th,$Unitkerja['kdunitkerja']) <> $Unitkerja['jml_anggaran_indikatif']) { ?>
	  <font color="#FF0000"><?php echo $Unitkerja['jml_anggaran_indikatif'] ?></font>
	  <?php }else{ ?>
	  <?php echo $Unitkerja['jml_anggaran_indikatif'] ?>
	  <?php } ?></td>
      <td align="right" valign="top">
	  <?php if( renja_output_unit($th,$Unitkerja['kdunitkerja']) <> $Unitkerja['jml_anggaran_indikatif']) { ?>
	  <font color="#660033"><?php echo renja_output_unit($th,$Unitkerja['kdunitkerja']) ?></font>
	  <?php }else{ ?>
	  <?php echo renja_output_unit($th,$Unitkerja['kdunitkerja']) ?>
	  <?php }?>	  </td>
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