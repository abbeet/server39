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
    $kdbulan1 = $_REQUEST['kdbulan1'];
    $kdbulan2 = $_REQUEST['kdbulan2'];

if ( $_REQUEST['cari_satker'] )
{
     $kdsatker = $_REQUEST['kdsatker'];
     $kdbulan1 = $_REQUEST['kdbulan1'];
     $kdbulan2 = $_REQUEST['kdbulan2'];
}	
	
if ( $_REQUEST['cari'] )
{
     $kdsatker = $_REQUEST['kdsatker'];
     $kdbulan1 = $_REQUEST['kdbulan1'];
     $kdbulan2 = $_REQUEST['kdbulan2'];
}	
	$jml_peg = 0 ;
	$count = $kdbulan2 - $kdbulan1 + 1 ;
	for ($i = $kdbulan1 ; $i <= $kdbulan2 ; $i++)
	{
		if ( $i <= 9 )    $kdbulan = '0'.$i ;
		else $kdbulan = $i ;
		$oList = mysql_query("SELECT kdsatker, sum(tunker) as jml_tunker, sum(pajak_tunker) as jml_pajak FROM $table WHERE tahun = '$th' and kdsatker = '$xusername' and bulan = '$kdbulan' GROUP BY bulan ");
		$List = mysql_fetch_array($oList);
		$col[0][] 	= $i ;
		$col[1][] 	= jmlpeg_bulan($th,$kdbulan,$List['kdsatker']);
		$col[4][] 	= $List['jml_tunker'];
		$col[5][] 	= $List['jml_pajak'];
		$total_tk +=  $List['jml_tunker'];
		$total_pj +=  $List['jml_pajak'];
		$total    +=  jmlpeg_bulan($th,$kdbulan,$List['kdsatker']);
		if ( jmlpeg_bulan($th,$kdbulan,$List['kdsatker']) > $jml_peg )   $jml_peg = jmlpeg_bulan($th,$kdbulan,$List['kdsatker']) ;
	}
	
?>
<?php if ( $xlevel == 1 ) {?>
<div align="left">
	<form action="index.php?p=<?php echo $p ?>&kdbulan1=<?php echo $kdbulan1 ?>&kdbulan2=<?php echo $kdbulan2 ?>" method="post">
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
	<form action="index.php?p=<?php echo $p ?>&kdbulan1=<?php echo $kdbulan1 ?>&kdbulan2=<?php echo $kdbulan2 ?>" method="post">
		<input type="hidden" name="p" value="<?php echo $p; ?>" />
		Bulan : 
		<select name="kdbulan1"><?php
									
					for ($i = 1; $i <= 13; $i++)
					{ ?>
						<option value="<?php echo $i; ?>" <?php if ($i == $kdbulan1) echo "selected"; ?>><?php echo nama_bulan($i) ?></option><?php
					} ?>	
	  </select>&nbsp;&nbsp;s/d&nbsp;&nbsp;
	  <select name="kdbulan2"><?php
									
					for ($i = 1; $i <= 13; $i++)
					{ ?>
						<option value="<?php echo $i; ?>" <?php if ($i == $kdbulan2) echo "selected"; ?>><?php echo nama_bulan($i) ?></option><?php
					} ?>	
	  </select>
		<input type="submit" value="Cari" name="cari"/>
	</form>
</div>
<?php 
if ( substr($kdbulan1,0,1) == '0' )  $nama_bulan1 = nama_bulan(substr($kdbulan1,1,1));
else $nama_bulan1 = nama_bulan($kdbulan1);
if ( substr($kdbulan2,0,1) == '0' )  $nama_bulan2 = nama_bulan(substr($kdbulan2,1,1));
else $nama_bulan2 = nama_bulan($kdbulan2);
echo '<strong>'.'Bulan '.$nama_bulan1.' s/d '.$nama_bulan2.' '.$th.'</strong>' ?><br />
<a href="index.php?p=370&kdsatker=<?php echo $xusername ?>&kdbulan1=<?php echo $kdbulan1 ?>&kdbulan2=<?php echo $kdbulan2 ?>&th=<?php echo $th ?>" title="Cetak Rekap Daftar Nominatif">
			  <img src="css/images/menu/icon-16-print.png" border="0" width="16" height="16"><font size="1">PDF(1)</font></a><font size="1">&nbsp;&nbsp;|&nbsp;</font>		  
<a href="index.php?p=371&kdsatker=<?php echo $xusername ?>&kdbulan1=<?php echo $kdbulan1 ?>&kdbulan2=<?php echo $kdbulan2 ?>&th=<?php echo $th ?>" title="Export Rekap Daftar Nominatif"><font size="1">PDF(2)</font></a>			 <font size="1">&nbsp;&nbsp;|&nbsp;</font>		   
<a href="source/tunjangan/rapel_nominatif_xls.php?kdsatker=<?php echo $xusername ?>&kdbulan1=<?php echo $kdbulan1 ?>&kdbulan2=<?php echo $kdbulan2 ?>&th=<?php echo $th ?>" title="Export Rekap Daftar Nominatif" target="_blank"><font size="1">Excel(1)</font></a>
			 <font size="1">&nbsp;&nbsp;|&nbsp;</font>		   
<a href="source/tunjangan/rapel_nominatif_total_xls.php?kdsatker=<?php echo $xusername ?>&kdbulan1=<?php echo $kdbulan1 ?>&kdbulan2=<?php echo $kdbulan2 ?>&th=<?php echo $th ?>" title="Export Rekap Daftar Nominatif" target="_blank"><font size="1">Excel(2)</font></a><table width="91%" cellpadding="1" class="adminlist">
	<thead>
		<tr>
			<th width="12%">No.</th>
			<th width="27%">Bulan</th>
            <th width="19%">Jumlah<br />
          Penerima</th>
            <th width="21%">1. Tunjangan Kinerja<br />
          2. Pajak<br />3. Jumlah</th>
            <th width="21%">1. Faktor Pengurang<br />
	      2. Potongan Pajak<br />3. Jumlah Netto</th>
		</tr>
	</thead>
	<tbody><?php
		if ($count == 0) { ?>
			<tr><td align="center" colspan="5">Tidak ada data!</td></tr><?php
		}
		else {
			foreach ($col[0] as $k=>$val) {
				if ($k % 2 == 1) $class = "row0";
				else $class = "row1"; ?>
				<tr class="<?php echo $class ?>">
					<td rowspan="3" align="center" valign="top"><?php echo $limit*($pagess-1)+($k+1); ?></td>
					<td rowspan="3" align="left" valign="top"><?php echo strtoupper(nama_bulan($col[0][$k])) ?></td>
			        <td rowspan="3" align="center" valign="top"><?php echo $col[1][$k] ?></td>
			        <td align="right" valign="top"><?php echo number_format($col[4][$k],"0",",",".") ?></td>
			        <td align="right" valign="top"><?php echo number_format(0,"0",",",".") ?></td>
				</tr>
				<tr class="<?php echo $class ?>">
				  <td align="right" valign="top"><?php echo number_format($col[5][$k],"0",",",".") ?></td>
				  <td align="right" valign="top"><?php echo number_format($col[5][$k],"0",",",".") ?></td>
	  </tr>
				<tr class="<?php echo $class ?>">
				  <td align="right" valign="top"><?php echo number_format(($col[4][$k] + $col[5][$k]),"0",",",".") ?></td>
				  <td align="right" valign="top"><?php echo number_format($col[4][$k],"0",",",".") ?></td>
	  </tr>
				<?php
			}
		} ?>
				<tr class="<?php echo $class ?>">
				  <td rowspan="3" align="center" valign="top">&nbsp;</td>
				  <td rowspan="3" align="center" valign="top"><strong>Jumlah</strong></td>
				  <td rowspan="3" align="center" valign="top"><strong><?php echo $jml_peg ?></strong></td>
				  <td align="right" valign="top"><strong><?php echo number_format($total_tk,"0",",",".") ?></strong></td>
				  <td align="right" valign="top"><strong><?php echo number_format(0,"0",",",".") ?></strong></td>
	  </tr>
				<tr class="<?php echo $class ?>">
				  <td align="right" valign="top"><strong><?php echo number_format($total_pj,"0",",",".") ?></strong></td>
				  <td align="right" valign="top"><strong><?php echo number_format($total_pj,"0",",",".") ?></strong></td>
	  </tr>
				<tr class="<?php echo $class ?>">
				  <td align="right" valign="top"><strong><?php echo number_format($total_tk + $total_pj,"0",",",".") ?></strong></td>
				  <td align="right" valign="top"><strong><?php echo number_format($total_tk,"0",",",".") ?></strong></td>
	  </tr>
	</tbody>
	<tfoot>
		<tr>
			<td colspan="5"></td>
		</tr>
	</tfoot>
</table>
