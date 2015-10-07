<?php
	checkauthentication();
	$p = $_GET['p'];
	$cari = $_GET['cari'];
	$table = "mst_tk";
	$field = get_field($table);
 	$th = $_SESSION['xth'];
	$xlevel = $_SESSION['xlevel'];
	$xusername = $_SESSION['xusername'];
	$xkdunit = $_SESSION['xkdunit'];
	$kdbidang = substr(kdunitkerja_peg($xusername),0,3);
	$kdsubbidang = kdunitkerja_peg($xusername);
	$kdbulan = $_REQUEST['kdbulan'];

if ( $_REQUEST['cari_satker'] )
{
     $kdsatker = $_REQUEST['kdsatker'];
     $kdbulan = $_REQUEST['kdbulan'];
}	
	
if ( $_REQUEST['cari'] )
{
     $kdsatker = $_REQUEST['kdsatker'];
     $kdbulan = $_REQUEST['kdbulan'];
}	

	switch ($xlevel)
	{
		case '7':
		$kdbulan = $_REQUEST['kdbulan'];
		if ( $kdbulan <= 9 )    $kdbulan = '0'.$kdbulan ;
		else $kdbulan = $kdbulan ;
	$oList = mysql_query("SELECT grade, count(nib) as jumlah, sum(tunker) as jml_tunker, sum(pajak_tunker) as jml_pajak, sum(nil_terima) as jml_terima FROM $table WHERE tahun = '$th' and kdsatker = '$xusername' and bulan = '$kdbulan' GROUP BY bulan, grade ORDER BY grade desc");
			break;
		case '2':
		$kdbulan = $_REQUEST['kdbulan'];
		if ( $kdbulan <= 9 )    $kdbulan = '0'.$kdbulan ;
	$oList = mysql_query("SELECT grade, count(nib) as jumlah, sum(tunker) as jml_tunker, sum(pajak_tunker) as jml_pajak, sum(nil_terima) as jml_terima FROM $table WHERE tahun = '$th' and left(kdunitkerja,2) = '$xkdunit' and bulan = '$kdbulan' GROUP BY grade ORDER BY grade desc");
			break;
		default:
		$kdsatker = $_REQUEST['kdsatker'];
		$kdbulan = $_REQUEST['kdbulan'];
		if ( $kdbulan <= 9 )    $kdbulan = '0'.$kdbulan ;
	$oList = mysql_query("SELECT grade, count(nib) as jumlah, sum(tunker) as jml_tunker, sum(pajak_tunker) as jml_pajak, sum(nil_terima) as jml_terima FROM $table WHERE tahun = '$th' and kdsatker = '$kdsatker' and bulan = '$kdbulan' GROUP BY bulan, grade ORDER BY grade desc");
			brek;
	} 
?>
<?php if ( $xlevel == 1 ) {?>
<div align="left">
	<form action="index.php?p=<?php echo $p ?>&kdsatker=<?php echo $kdsatker ?>&kdbulan=<?php echo $kdbulan ?>" method="post">
		<input type="hidden" name="p" value="<?php echo $p; ?>" />
		Satker : 
		<select name="kdsatker">
                      <option value="<?php echo $kdsatker ?>"><?php echo  substr(nm_satker($kdsatker),0,60) ?></option>
                      <option value="">- Pilih Satker -</option>
                    <?php
							$query = mysql_query("select left(nmsatker,60) as nama_satker, kdsatker from kd_satker group by kdsatker order by kdsatker");
					while( $row = mysql_fetch_array($query)) { ?>
                      <option value="<?php echo $row['kdsatker'] ?>"><?php echo  $row['nama_satker']; ?></option>
                    <?php
					} ?>	
	  </select>
		<input type="submit" value="Cari" name="cari_satker"/>
	</form>
</div>
<?php }?>
<div align="right">
	<form action="index.php?p=<?php echo $p ?>&kdsatker=<?php echo $kdsatker ?>&kdbulan=<?php echo $kdbulan ?>" method="post">
		<input type="hidden" name="p" value="<?php echo $p; ?>" />
		Pilih Bulan : 
		<select name="kdbulan"><?php
									
					for ($i = 1; $i <= 13; $i++)
					{ ?>
						<option value="<?php echo $i; ?>" <?php if ($i == $kdbulan) echo "selected"; ?>><?php echo nama_bulan($i) ?></option><?php
					} ?>	
	  </select>
		<input type="submit" value="Tampilkan" name="cari"/>
	</form>
</div>
<?php
if ( substr($kdbulan,0,1) == '0' )  $nama_bulan = nama_bulan(substr($kdbulan,1,1));
if ( substr($kdbulan,0,1) <> '0' )  $nama_bulan = nama_bulan($kdbulan);
echo '<strong>'.'Bulan '.$nama_bulan.' '.$th.'</strong>' ?><br />
<a href="source/tunjangan/rekap_penerima_prn.php?kdsatker=<?php echo $xusername ?>&kdbulan=<?php echo $kdbulan ?>&th=<?php echo $th ?>" title="Cetak Rekap Daftar Nominatif" target="_blank">
			  <img src="css/images/menu/icon-16-print.png" border="0" width="16" height="16"><font size="1">PDF</font></a><font size="1">&nbsp;&nbsp;|&nbsp;</font></a>
			  
<a href="source/tunjangan/rekap_penerima_xls.php?kdsatker=<?php echo $xusername ?>&kdbulan=<?php echo $kdbulan ?>&th=<?php echo $th ?>" title="Export Rekap Daftar Nominatif" target="_blank"><font size="1">Excel</font></a>
<table width="70%" cellpadding="1" class="adminlist">
	<thead>
		<tr>
			<th width="7%" rowspan="2">No.</th>
			<th width="37%" rowspan="2">Kelas Jabatan </th>
            <th width="10%" rowspan="2">Jumlah<br />Penerima</th>
            <th width="12%" rowspan="2">Tunjangan Kinerja<br />Per Kelas Jabatan</th>
            <th width="11%" rowspan="2">Tunjangan<br />Kinerja<br />Sebelum Pajak</th>
            <th width="11%" rowspan="2">Tunjangan<br />Pajak</th>
		    <th width="12%" rowspan="2">Jumlah Bruto</th>
		    <th colspan="3">Potongan</th>
		    <th width="12%" rowspan="2">Tunjangan Kinerja<br />Dibayarkan</th>
	    </tr>
		<tr>
		  <th width="12%">Pajak </th>
	      <th width="12%">Faktor<br />Pengurang</th>
	      <th width="12%">Jumlah<br />Potongan</th>
	  </tr>
	</thead>
	<tbody>
<?php 
	$xx = 0 ;
	$no = 0 ;
	while ($List = mysql_fetch_array($oList))
	{
		$no += 1 ;
		$col_1 	= $List['grade'];
		$col_2 	= $List['jumlah'];
		$col_3 	= $List['tj_pajak'];
		$col_4 	= $List['kdunit'];
		$col_5 	= $List['jml_tunker'];
		$col_6 	= $List['jml_pajak'];
		$col_7   = $List['jml_terima'];
		$col_8   = $List['jml_tunker'] - $List['jml_terima'];
		$col_9   = $List['jml_tunker'] - $List['jml_terima'] + $List['jml_pajak'];
		$total_tk +=  $List['jml_tunker'];
		$total_pj +=  $List['jml_pajak'];
		$total    +=  $List['jumlah'];
		$total_pot += $List['jml_tunker'] - $List['jml_terima'];
		$total_trm    +=  $List['jml_terima'];
		$tunker = rp_grade($List['kdunit'],$List['grade'],1) ;
		if ( $tunker * $List['jumlah'] <> $List['jml_tunker'] ) 
		{
		    $col_10 = '(*)';
			$xx = 1 ;
		}else{
		    $col_10 = ' ';
		}
?>	
				<tr class="<?php echo $class ?>">
					<td align="center" valign="top"><?php echo $no.'.' ?></td>
					<td align="left" valign="top"><?php echo 'Kelas Jabatan '.$col_1 ?></td>
			        <td align="center" valign="top"><?php echo $col_2.' '.$col_10 ?></td>
			        <td align="right" valign="top"><?php echo number_format(rp_grade($col_4,$col_1,1),"0",",",".") ?></td>
			        <td align="right" valign="top"><?php echo number_format($col_5,"0",",",".") ?></td>
			        <td align="right" valign="top"><?php echo number_format($col_6,"0",",",".") ?></td>
				    <td align="right" valign="top"><?php echo number_format(($col_5 + $col_6),"0",",",".") ?></td>
				    <td align="right" valign="top"><?php echo number_format($col_6,"0",",",".") ?></td>
				    <td align="right" valign="top"><?php echo number_format($col_8,"0",",",".") ?></td>
				    <td align="right" valign="top"><?php echo number_format($col_6 + $col_8,"0",",",".") ?></td>
				    <td align="right" valign="top"><?php echo number_format($col_7,"0",",",".") ?></td>
			    </tr>
<?php } ?>
				<tr class="<?php echo $class ?>">
				  <td align="center" valign="top">&nbsp;</td>
				  <td align="center" valign="top"><strong>Jumlah</strong></td>
				  <td align="center" valign="top"><strong><?php echo $total ?></strong></td>
				  <td align="center" valign="top">&nbsp;</td>
				  <td align="right" valign="top"><strong><?php echo number_format($total_tk,"0",",",".") ?></strong></td>
				  <td align="right" valign="top"><strong><?php echo number_format($total_pj,"0",",",".") ?></strong></td>
				  <td align="right" valign="top"><strong><?php echo number_format(($total_tk + $total_pj),"0",",",".") ?></strong></td>
	              <td align="right" valign="top"><strong><?php echo number_format($total_pj,"0",",",".") ?></strong></td>
	              <td align="right" valign="top"><strong><?php echo number_format($total_pot,"0",",",".") ?></strong></td>
	              <td align="right" valign="top"><strong><?php echo number_format($total_pot + $total_pj,"0",",",".") ?></strong></td>
	              <td align="right" valign="top"><strong><?php echo number_format($total_trm,"0",",",".") ?></strong></td>
      </tr>				
	</tbody>
	<tfoot>
		<tr>
			<td colspan="11">
			<?php if ( $xx == 1 )
				  { 
				  echo 'Catatan :<br />(*) Jumlah penerima yang tertera pada isian ini, beberapa pegawai tidak menerima Tunjangan Kinerja 1 bulan penuh';
				  }else{ echo '';
			      } ?>			</td>
		</tr>
	</tfoot>
</table>
