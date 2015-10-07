<?php
	checkauthentication();
	$p = $_GET['p'];
	$cari = $_GET['cari'];
	$table = "mst_tk";
	$field = array("id","tahun","bulan","nip","kdunitkerja","kdjabatan","kdgol","kdstatuspeg","tmtjabatan","grade","tunker","pajak_tunker");
 	$th = $_SESSION['xth'];
	$xlevel = $_SESSION['xlevel'];
	$xusername = $_SESSION['xusername'];

	if ( $_REQUEST['kdbulan1'] == '' )  $kdbulan1 =  1 ;
	else  $kdbulan1 = $_REQUEST['kdbulan1'];
	
	if ( $_REQUEST['kdbulan2'] == '' )  $kdbulan2 = date('m') - 1 ;
	else  $kdbulan2 = $_REQUEST['kdbulan2'];

	
if ( $_REQUEST['cari'] )
{
	$kdbulan1 = $_REQUEST['kdbulan1'];
	$kdbulan2 = $_REQUEST['kdbulan2'];
}	
if ( strlen($kdbulan1) == 1 )    $kdbulan1 = '0'.$kdbulan1 ;
if ( strlen($kdbulan2) == 1 )    $kdbulan2 = '0'.$kdbulan2 ;

	$oList = mysql_query("SELECT grade, count(nip) as jumlah, sum(tunker) as jml_tunker, sum(pajak_tunker) as jml_pajak 
					FROM $table WHERE tahun = '$th' and bulan >= '$kdbulan1' and bulan <= '$kdbulan2'
					GROUP BY grade 
					ORDER BY grade desc");
	$count = mysql_num_rows($oList);
	$xx = 0 ;
	while ($List = mysql_fetch_array($oList))
	{
		$col[0][] 	= $List['grade'];
		$col[1][] 	= $List['jumlah'];
		$col[2][] 	= $List['jml_tunker'];
		$col[3][] 	= $List['jml_pajak'];
		$total_tk +=  $List['jml_tunker'];
		$total_pj +=  $List['jml_pajak'];
		$total    +=  jmlpeg_bulan_grade_ditjen($th,$kdbulan2,$List['grade']);
	}
	
?>
<div align="right">
	<form action="" method="post">
		<input type="hidden" name="p" value="<?php echo $p; ?>" />
		Pilih Bulan : 
		<select name="kdbulan1"><?php
									
					for ($i = 1; $i <= 13; $i++)
					{ ?>
						<option value="<?php echo $i; ?>" <?php if ($i == $kdbulan1 ) echo "selected"; ?>><?php echo nama_bulan($i) ?></option><?php
					} ?>	
	  </select>&nbsp;s/d&nbsp;
	  <select name="kdbulan2"><?php
									
					for ($i = 1; $i <= 13; $i++)
					{ ?>
						<option value="<?php echo $i; ?>" <?php if ($i == $kdbulan2 ) echo "selected"; ?>><?php echo nama_bulan($i) ?></option><?php
					} ?>	
	  </select>
		<input type="submit" value="Tampilkan" name="cari"/>
	</form>
</div><font color="#0066CC" size="2">
<?php 
if ( substr($kdbulan1,0,1) == '0' )  $nama_bulan1 = nama_bulan(substr($kdbulan1,1,1));
if ( substr($kdbulan1,0,1) <> '0' )  $nama_bulan1 = nama_bulan($kdbulan1);
if ( substr($kdbulan2,0,1) == '0' )  $nama_bulan2 = nama_bulan(substr($kdbulan2,1,1));
if ( substr($kdbulan2,0,1) <> '0' )  $nama_bulan2 = nama_bulan($kdbulan2);
echo '<strong>'.nm_unitkerja($kdunit).'</strong><br>' ;
echo '<strong>'.'Bulan '.$nama_bulan1.' s/d '.$nama_bulan2.' '.$th.'</strong>' ;
?>
<br />
</font>
<a href="source/tunjangan/rapel_nominatif_ditjen_prn.php?kdbulan1=<?php echo $kdbulan1 ?>&kdbulan2=<?php echo $kdbulan2 ?>&th=<?php echo $th ?>" title="Cetak Rekap Daftar Nominatif">
			  <img src="css/images/menu/icon-16-print.png" border="0" width="16" height="16"><font size="1">Lampiran II PDF</font></a><font size="1">&nbsp;&nbsp;|&nbsp;</font></a>
			  
<a href="source/tunjangan/rapel_nominatif_ditjen_xls.php?kdbulan1=<?php echo $kdbulan1 ?>&kdbulan2=<?php echo $kdbulan2 ?>&th=<?php echo $th ?>" title="Export Rekap Daftar Nominatif" target="_blank"><font size="1">Excel</font></a>&nbsp;&nbsp;|&nbsp;
<table width="93%" cellpadding="1" class="adminlist">
	<thead>
		<tr>
			<th width="8%">No.</th>
			<th width="22%">Kelas Jabatan </th>
            <th width="10%">Jumlah<br />Penerima</th>
            <th width="17%">Tunjangan Kinerja<br />Per Kelas Jabatan</th>
            <th width="22%">1. Tunjangan Kinerja<br /> 
            2. Pajak<br />3. Jumlah</th>
          <th width="21%">
          1. Potongan Pajak<br />2. Jumlah Netto</th>
		</tr>
	</thead>
	<tbody><?php
		if ($count == 0) { ?>
			<tr><td align="center" colspan="6">Tidak ada data!</td></tr><?php
		}
		else {
			foreach ($col[0] as $k=>$val) {
				if ($k % 2 == 1) $class = "row0";
				else $class = "row1"; ?>
				<tr class="<?php echo $class ?>">
					<td rowspan="3" align="center" valign="top"><?php echo $limit*($pagess-1)+($k+1); ?></td>
					<td rowspan="3" align="left" valign="top"><?php echo 'Kelas Jabatan '.$col[0][$k] ?></td>
			        <td rowspan="3" align="center" valign="top"><?php echo jmlpeg_bulan_grade_ditjen($th,$kdbulan2,$col[0][$k]) ?></td>
			        <td rowspan="3" align="right" valign="top"><?php echo number_format(rp_grade($col[0][$k]),"0",",",".") ?></td>
			        <td align="right" valign="top"><?php echo number_format($col[2][$k],"0",",",".") ?></td>
			        <td align="right" valign="top"><?php echo number_format($col[3][$k],"0",",",".") ?></td>
				</tr>
				<tr class="<?php echo $class ?>">
				  <td align="right" valign="top"><?php echo number_format($col[3][$k],"0",",",".") ?></td>
				  <td align="right" valign="top"><?php echo number_format($col[2][$k],"0",",",".") ?></td>
	  </tr>
				<tr class="<?php echo $class ?>">
				  <td align="right" valign="top"><?php echo number_format(($col[2][$k] + $col[3][$k]),"0",",",".") ?></td>
				  <td align="right" valign="top">&nbsp;</td>
	  </tr>
				<?php
			}
		} ?>
				<tr class="<?php echo $class ?>">
				  <td rowspan="3" align="center" valign="top">&nbsp;</td>
				  <td rowspan="3" align="center" valign="top"><strong>Jumlah</strong></td>
				  <td rowspan="3" align="center" valign="top"><strong><?php echo $total ?></strong></td>
				  <td rowspan="3" align="center" valign="top">&nbsp;</td>
				  <td align="right" valign="top"><strong><?php echo number_format($total_tk,"0",",",".") ?></strong></td>
				  <td align="right" valign="top"><strong><?php echo number_format($total_pj,"0",",",".") ?></strong></td>
	  </tr>
				<tr class="<?php echo $class ?>">
				  <td align="right" valign="top"><strong><?php echo number_format($total_pj,"0",",",".") ?></td>
				  <td align="right" valign="top"><strong><?php echo number_format($total_tk,"0",",",".") ?></td>
	  </tr>
				<tr class="<?php echo $class ?>">
				  <td align="right" valign="top"><strong><?php echo number_format(($total_tk + $total_pj),"0",",",".") ?></td>
				  <td align="right" valign="top"><strong></td>
	  </tr>
	</tbody>
	<tfoot>
	</tfoot>
</table>
