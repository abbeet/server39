<?php
	checkauthentication();
	$p = $_GET['p'];
	$table = "dt_pk";
	$field = array("id","th","kdunitkerja","no_sasaran","nourut_pk","indikator","target","no_iku","anggaran",
					"rencana_1","rencana_2","rencana_3","rencana_4",
					"rencana_aksi_1","rencana_aksi_2","rencana_aksi_3","rencana_aksi_4",
					"realisasi_1","realisasi_2","realisasi_3","realisasi_4",
					"hasil_1","hasil_2","hasil_3","hasil_4");
	
	$ed_link = "index.php?p=".get_edit_link($p);
	$del_link = "index.php?p=".get_delete_link($p);
	$th = $_SESSION['xth'];
	$xkdunit = $_SESSION['xkdunit'];
	$xusername = $_SESSION['xusername'] ;
	$kdsatker = kd_satker($xkdunit) ;
	$xlevel = $_SESSION['xlevel'];
	$kdtriwulan = $_REQUEST['kdtriwulan'];
	
	if($_REQUEST['cari']){
		$kdtriwulan = $_REQUEST['kdtriwulan'];
	
		$xkdunit = $_REQUEST['kdunit'];
	}

	if ($kdtriwulan == ''){
		$bl = date('m');
		if ($bl <= 4 and $bl >=2 ) 		 $kdtriwulan = 1;
		if ($bl <= 7 and $bl >= 5 )  	 $kdtriwulan = 2;
		if ($bl <= 10 and $bl >= 8 )  	 $kdtriwulan = 3;
		if ( ($bl <= 12 and $bl >= 11) or $bl == 1)    $kdtriwulan = 4;
	}


	$oList = mysql_query("select * from $table WHERE th = '$th' and kdunitkerja = '$xkdunit' order by kdunitkerja,no_sasaran,nourut_pk");
	
	$count = mysql_num_rows($oList);
	
	while($List = mysql_fetch_object($oList)) {
		foreach ($field as $k=>$val) {
			$col[$k][] = $List->$val;
		}
		$ed[] = $ed_link."&q=".$List->$field[0];
		$del[] = $del_link."&q=".$List->$field[0];
	}
	
?>

<div align="right">
	<form action="index.php?p=540&kdtriwulan=<?php echo $kdtriwulan ?>&xkdunit=<?php echo $xkdunit ?>" method="post">
    
		<input type="hidden" name="p" value="<?php echo $p; ?>" />
		Satker Mandiri : 
		<select name="kdunit">
                      <option value="<?php echo $xkdunit ?>"><?php echo  nm_unit($xkdunit) ?></option>
                      <option value="">- Pilih Satker Mandiri -</option>
                    <?php
	switch ($xlevel)
	{
		case '1':
			$query = mysql_query("select * from tb_unitkerja where kdunit > '2320600' and kdsatker <> '' order by kdunit");
			break;
		case '3':
			$query = mysql_query("select * from tb_unitkerja where kdunit = '$xkdunit' order by kdunit");
			break;
		case '4':
			$query = mysql_query("select * from tb_unitkerja where kdunit = '$xkdunit' order by kdunit");
			break;
		case '5':
			$query = mysql_query("select * from tb_unitkerja where kdunit = '$xkdunit' order by kdunit");
			break;
		case '8':
			$query = mysql_query("select * from tb_unitkerja where kdunit = '$xkdunit' order by kdunit");
			break;
		default:
			$query = mysql_query("select * from tb_unitkerja where kdunit > '2320600' and kdsatker <> '' order by kdunit");
			break;
	}
						while($row = mysql_fetch_array($query)) { ?>
                      <option value="<?php echo $row['kdunit'] ?>"><?php echo  trim($row['nmunit']); ?></option>
                    <?php
					} ?>	
	  </select>
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
<!--a href="menus/PK/capaian_unit_prn.php?th=<?php echo $th ?>&kdtriwulan=<?php echo $kdtriwulan ?>&kdunit=<?php echo $xkdunit ?>" title="Cetak Capaian PK Unit Kerja" target="_blank">
			  <img src="css/images/menu/icon-16-print.png" border="0" width="16" height="16"><font size="1">Cetak Laporan </font></a-->&nbsp;&nbsp;
<table width="806" cellpadding="1" class="adminlist">
  <thead>
    
    <tr>
      <th width="18%" rowspan="2">Satker Mandiri</th>
      <th width="18%" rowspan="2">Sasaran Strategis</th>
      <th width="3%" rowspan="2">No.</th>
      <th width="20%" rowspan="2">Indikator Kinerja </th>
      <th width="7%" rowspan="2">Target</th>
      <th width="7%" colspan="2">Rencana Aksi s/d Triwulan <?php echo nmromawi($kdtriwulan) ?></th>
      <th colspan="2">Capaian Kinerja s/d Triwulan <?php echo nmromawi($kdtriwulan) ?></th>
      <th width="10%" rowspan="2">Anggaran</th>
      <th colspan="2" rowspan="2">Aksi</th>
    </tr>
    <tr>
      <th width="7%">(%)</th>
      <th width="7%">Uraian Target</th>
      <th width="5%">(%)</th>
      <th width="27%">Uraian Hasil </th>
    </tr>
  </thead>
  <tbody>
    <?php
		if ($count == 0) { ?>
    <tr>
      <td align="center" colspan="12">Tidak ada data!</td>
    </tr>
    <?php
		}
		else {
			foreach ($col[0] as $k=>$val) {
				if ($k % 2 == 1) $class = "row0";
				else $class = "row1"; ?>
    <tr class="<?php echo $class ?>">
      <td align="left" valign="top"><?php if( $col[2][$k] <> $col[2][$k-1] ){  ?><?php echo nm_unit($col[2][$k]) ?><?php } ?></td> 
      <td align="left" valign="top"><?php if( $col[3][$k] <> $col[3][$k-1] ){  ?><?php echo nm_sasaran($col[1][$k],$col[2][$k],$col[3][$k]) ?><?php } ?></td>
      <td align="center" valign="top"><?php echo $col[4][$k] ?></td>
      <td align="left" valign="top"><?php echo $col[5][$k] ?></td>
      <td align="center" valign="top"><?php echo $col[6][$k] ?></td>
      <td align="center" valign="top">
<?php 
	  switch ( $kdtriwulan )
	  {
	   case '1':
	      if ( $col[9][$k] <> 0 ) echo $col[9][$k];
	      if ( $col[9][$k] == 0 ) echo '';
		  break;
	   case '2':
	      if ( $col[10][$k] <> 0 ) echo $col[10][$k];
	      if ( $col[10][$k] == 0 ) echo '';
		  break;
	   case '3':
	      if ( $col[11][$k] <> 0 ) echo $col[11][$k];
	      if ( $col[11][$k] == 0 ) echo '';
		  break;
	   case '4':
	      if ( $col[12][$k] <> 0 ) echo $col[12][$k];
	      if ( $col[12][$k] == 0 ) echo '';
		  break;
	  }
	  ?>	  </td>
      <td align="left" valign="top">
	  <?php 
	  switch ( $kdtriwulan )
	  {
	   case '1':
	      echo $col[13][$k];
		  break;
	   case '2':
	      echo $col[14][$k];
		  break;
	   case '3':
	      echo $col[15][$k];
		  break;
	   case '4':
	      echo $col[16][$k];
		  break;
	  }
	  ?></td>
      <td align="center" valign="top">
	  <?php 
	  switch ( $kdtriwulan )
	  {
	   case '1':
	      if ( $col[17][$k] <> 0 ) echo $col[17][$k];
	      if ( $col[17][$k] == 0 ) echo '';
		  break;
	   case '2':
	      if ( $col[18][$k] <> 0 ) echo $col[18][$k];
	      if ( $col[18][$k] == 0 ) echo '';
		  break;
	   case '3':
	      if ( $col[19][$k] <> 0 ) echo $col[19][$k];
	      if ( $col[19][$k] == 0 ) echo '';
		  break;
	   case '4':
	      if ( $col[20][$k] <> 0 ) echo $col[20][$k];
	      if ( $col[20][$k] == 0 ) echo '';
		  break;
	  }
	  ?>	  </td>
      <td align="left" valign="top">
        <?php 
	  switch ( $kdtriwulan )
	  {
	   case '1':
	      echo $col[21][$k];
		  break;
	   case '2':
	      echo $col[22][$k];
		  break;
	   case '3':
	      echo $col[23][$k];
		  break;
	   case '4':
	      echo $col[24][$k];
		  break;
	  }
	  ?>	  </td>
      <td align="left" valign="top"><?php echo number_format($col[8][$k],"0",",",".") ?></td>
      <td width="3%" align="center" valign="top"><a href="index.php?p=625&q=<?php echo $col[0][$k] ?>&kdtriwulan=<?php echo $kdtriwulan ?>" title="Edit"> 
        <img src="css/images/edit_f2.png" border="0" width="16" height="16"> </a></td>
      <td width="7%" align="center" valign="top"><a href="index.php?p=626&q=<?php echo $col[0][$k] ?>&kdtriwulan=<?php echo $kdtriwulan ?>" title="Delete"> 
        <img src="css/images/stop_f2.png" border="0" width="16" height="16"> </a></td>
    </tr>
    <?php
			}
		} ?>
  </tbody>
  <tfoot>
    <tr> 
      <td colspan="12">&nbsp;</td>
    </tr>
  </tfoot>
</table>
<?php 
	function nm_status_kirim($th,$kdunitkerja,$kdtriwulan) {
		$sql = "select * from dt_pk_kirim where th = '$th' and kdunitkerja = '$kdunitkerja' ";
		$row = mysql_fetch_array($sql);
		if ( empty($row) )   $kode = '0';
		if ( $kdtriwulan == 1 ) $kode = $row['status_1'];
		if ( $kdtriwulan == 2 ) $kode = $row['status_2'];
		if ( $kdtriwulan == 3 ) $kode = $row['status_3'];
		if ( $kdtriwulan == 4 ) $kode = $row['status_4'];
		if ($kode == '0') $hasil = 'Kosong';
		if ($kode == '1') $hasil = 'Draf';
		if ($kode == '2') $hasil = 'Kirim';
		return $hasil;
	}
?>