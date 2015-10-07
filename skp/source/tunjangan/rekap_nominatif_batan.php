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
	
	// reset array
$cpenerima=array();
$ctk=array();
$cpajak=array();

// proses seluruhnya bulan
for($i=1;$i<=13;$i++)
{
	$kdbulan = $i;
	if ( $kdbulan <= 9 )    $kdbulan = '0'.$kdbulan ;

	$oList = mysql_query("SELECT grade, count(nib) as jumlah, sum(tunker) as jml_tunker, sum(pajak_tunker) as jml_pajak FROM $table WHERE tahun = '$th' and bulan = '$kdbulan' GROUP BY grade ORDER BY grade desc");

	$count = mysql_num_rows($oList);
	while ($List = mysql_fetch_array($oList))
	{
		$grade = $List['grade'];
		$cpenerima[$i][$grade] = $List['jumlah'];
		$ctk[$i][$grade] = $List['jml_tunker'];
		$cpajak[$i][$grade] = $List['jml_pajak'];
		// data rekap
		$total_tk[$i] += $List['jml_tunker'];
		$total_pj[$i] += $List['jml_pajak'];
		$total_pn[$i] += $List['jumlah'];	
	}
}	
?>
<br />
<a href="source/tunjangan/rekap_nominatif_batan_xls.php?th=<?php echo $th ?>" title="Cetak Rekap Daftar Nominatif BATAN" target="_blank">
			  <img src="css/images/menu/icon-16-print.png" border="0" width="16" height="16"><font size="1">Excel</font></a>
<table width="70%" cellpadding="1" class="adminlist">
	<thead>
		<tr>
			<th width="2%">No</th>
			<th width="3%">Kelas</th>
			<th width="5%">Nominal TK</th>
            <th width="5%">Jan<br />Rp.</th>
			<th width="5%">Feb<br />Rp.</th>
			<th width="5%">Mar<br />Rp.</th>
			<th width="5%">Apr<br />Rp.</th>
			<th width="5%">Mei<br />Rp.</th>
			<th width="5%">Jun<br />Rp.</th>
			<th width="5%">Jul<br />Rp.</th>
			<th width="5%">Ags<br />Rp.</th>
			<th width="5%">Sep<br />Rp.</th>
			<th width="5%">Okt<br />Rp.</th>
			<th width="5%">Nop<br />Rp.</th>
			<th width="5%">Des<br />Rp.</th>
			<th width="5%">Bln-13<br />Rp.</th>
            <th width="9%">Tunj.<br />Kinerja</th>
            <th width="8%">Tunj.<br />Pajak</th>
		    <th width="9%">Jumlah</th>
		</tr> 
	</thead>
	<tbody><?php
			for($k=17;$k>0;$k--) {
				if ($k % 2 == 1) $class = "row0";
				else $class = "row1"; ?>
				<tr class="<?php echo $class ?>">

					<!-- cetak rekap masing-masing grade -->
					<!-- cetak nomer -->
					<td align="center" valign="top"><?php echo (18-$k); ?></td>
					<!-- cetak grade -->
					<td align="center" valign="top"><?php echo $k; ?></td>
					<!-- cetak nominal -->
					<td align="right" valign="top"><?php echo number_format(rp_grade($cunit[$k],$k,1),"0",",",".") ?></td>
					
					<!-- cetak banyaknya penerima   -->
			        <!--td align="center" valign="top"><?php echo $cpenerima[1][$k] ?></td-->

					<?php
						//  cetak jumlah tunjangan kinerja
						$tk=0;
						for($b=1;$b<=13;$b++)
						{
							echo "<td align=right valign=top>";
							echo number_format($ctk[$b][$k],"0",",",".");
							echo "</td>";
							$tk += $ctk[$b][$k];
						}
						echo "<td align=right valign=top>";
						echo number_format($tk,"0",",",".");
						echo "</td>";
					?>
					<!-- cetak jumlah tunjangan pajak -->
					<?php
						$pajak=0;
						for($b=1;$b<=13;$b++)
						{
							$pajak += $cpajak[$b][$k];
						}
						echo "<td align=right valign=top>";
						echo number_format($pajak,"0",",",".");
						echo "</td>";
					?>
					<!-- cetak jumlah usulan tk -->
				    <td align="right" valign="top"><?php echo number_format(($tk+$pajak),"0",",",".") ?></td>
				</tr>
				<?php
			}
		?>
				<tr class="<?php echo $class ?>">
				  <td align="center" valign="top" colspan=3><strong>Jumlah</strong></td>
				  
				  <!-- jumlah total penerima -->
				  <!--td align="center" valign="top"><strong><?php echo $total_pn[1] ?></strong></td-->
				  
				<?php
				// grand total tunjangan kinerja
				$grand_tk=0;
				for($b=1;$b<=13;$b++)
				{
					echo "<td align=right valign=top><strong>";
					echo number_format($total_tk[$b],"0",",",".");
					echo "</strong></td>";
					$grand_tk+=$total_tk[$b];
				}
				echo "<td align=right valign=top><strong>";
				echo number_format($grand_tk,"0",",",".");
				echo "</strong></td>";
				// grand total tunjangan pajak
				$grand_pj=0;
				for($b=1;$b<=13;$b++)
				{
					$grand_pj+=$total_pj[$b];
				}
				echo "<td align=right valign=top><strong>";
				echo number_format($grand_pj,"0",",",".");
				echo "</strong></td>";
				// total usulan
				echo "<td align=right valign=top><strong>";
				echo number_format($grand_tk+$grand_pj,"0",",",".");
				echo "</strong></td>";
				?>
	  </tr>				
	</tbody>
	<tfoot>
		<tr>
			<td colspan=19>&nbsp;</td>
		</tr>
	</tfoot>
</table>
