<?php
	checkauthentication();
	$p = $_GET['p'];
	$cari = $_GET['cari'];
	$field = get_field($table);
	$ed_link = "index.php?p=".get_edit_link($p);
	$del_link = "index.php?p=".get_delete_link($p);
	$kddept = setup_kddept_keu() ;
	$kdunit = setup_kdunit_keu() ;
	$kdmenteri = setup_kddept_unit().'20000';
	$xlevel = $_SESSION['xlevel'];
	$xkdunit = $_SESSION['xkdunit'];
	$xusername = $_SESSION['xusername'] ;
	$th = $_SESSION['xth'];
	
	if ( $xlevel == 3 or $xlevel == 4 or $xlevel == 5 or $xlevel == 6 or $xlevel == 7 or $xlevel == 8 )
	{
	$kdsatker = kd_satker($xkdunit) ;
	$sql = "select KDSATKER, sum(JUMLAH) as pagu_satker from d_item WHERE THANG = '$th' AND KDDEPT = '$kddept' AND KDUNIT = '$kdunit' AND KDSATKER = '$kdsatker' GROUP BY KDSATKER ORDER BY KDSATKER";
	}else{
	$sql = "select KDSATKER, sum(JUMLAH) as pagu_satker from d_item WHERE THANG = '$th' AND KDDEPT = '$kddept' AND KDUNIT = '$kdunit' GROUP BY KDSATKER ORDER BY KDSATKER";
	}
	$aSatker = mysql_query($sql);
	$count = mysql_num_rows($aSatker);
	$jmlh = 0;
	
	while ($Satker = mysql_fetch_array($aSatker))
	{
		$col[0][] 	= $Satker['KDSATKER'];
		$col[1][] 	= $Satker['pagu_satker'];
	}

?>
<br />
<table width="787" cellpadding="1" class="adminlist">
  <thead>
    <tr> 
      <th rowspan="2">Kode APBN</th>
      <th rowspan="2">Nama Satuan Kerja / <br>
        <font color="#0000FF">Nama Kegiatan</font> / <br /><font color="#993333">Output</font></th>
      <th rowspan="2">Pagu<br />Anggaran</th>
      <th colspan="2">Realisasi<br />
        Anggaran SP2D </th>
      <th colspan="3">File ADK  Terakhir </th>
      <th width="9%" rowspan="2">Data Detil</th>
    </tr>
    <tr>
      <th>Rupiah</th>
      <th>%</th>
      <th width="12%">Download</th>
      <th width="7%">User</th>
      <th width="12%">Waktu</th>
    </tr>
  </thead>
  <tbody>
	<?php 
	if ( $xlevel <> 3 and $xlevel <> 4 and $xlevel <> 5 and $xlevel <> 6 and $xlevel <> 7 and $xlevel <> 8 )
	{
	//-----------------------------
	$pagu_menteri = pagu_menteri($th) ;
	$sql = "select sum(NILMAK) as real_menteri from m_spmmak WHERE THANG='$th' AND left(KDAKUN,1) = '5' group by THANG";
	$aMenteri = mysql_query($sql);
	$Menteri = mysql_fetch_array($aMenteri);
	$real_menteri_sp2d = $Menteri['real_menteri'] ;
	?>
    
<?php
		}  # AKHIR IF
		if ($count == 0) 
		{ ?>    <tr> 
      <td align="center" colspan="9">Tidak ada data!</td>
    </tr>
    <?php
		}
		else {
			foreach ($col[0] as $k=>$val) {
				if ($k % 2 == 1) $class = "row0";
				else $class = "row1"; 
				$real_satker_sp2d = real_satker_sp2d($th,$col[0][$k]) ;
				$kdsatker = $col[0][$k] ;
			$sql = "select * from dt_fileupload_keu WHERE type = 'adk' and kdsatker = '$kdsatker' order by nama_file desc";
			$aSatker = mysql_query($sql);
			$Satker = mysql_fetch_array($aSatker);
				?>
    <tr class="<?php echo $class ?>"> 
      <td width="6%" align="center"><?php echo $col[0][$k] ?></td>
      <td width="27%" align="left"><?php echo nm_satker($col[0][$k]) ?></td>
      <td width="9%" align="right"><?php echo number_format($col[1][$k],"0",",",".") ?></td>
      <td width="10%" align="right"><?php echo number_format($real_satker_sp2d,"0",",",".") ?></td>
      <td width="8%" align="center"><?php echo number_format($real_satker_sp2d/$col[1][$k]*100,"2",",",".") ?></td>
      <td align="center"><a href="file_dipa/<?php echo $col[0][$k]."/".$Satker['nama_file'] ?>" title="Download ADK"><font size="1"> 
        <?php echo $Satker['nama_file'] ?></font></a></td>
      <td align="center"><?php echo $Satker['user_upload'] ?></td>
      <td align="center"><?php echo reformat_tanggal(substr($Satker['tgl_upload'],0,10)) ?><br><?php echo substr($Satker['tgl_upload'],10,9) ?></td>
      <td align="center">
	  <a href="index.php?p=563&kdsatker=<?php echo $col[0][$k] ?>&th=<?php echo $th ?>" title="Data ADK SP2D Detil"><font size="1"> 
        ADK>></font></a>	  </td>
    </tr>
    <?php
		}
		} ?>
  </tbody>
  <tfoot>
    <tr> 
      <td colspan="9">&nbsp;</td>
    </tr>
  </tfoot>
</table>
