<?php
	checkauthentication();
	$p = $_GET['p'];
	$cari = $_GET['cari'];
	$table = "mst_tk";
	$field = array("id","tahun","bulan","nip","kdunitkerja","kdjabatan","kdgol","kdstatuspeg","tmtjabatan","grade","tunker","pajak_tunker");
 	$th = $_SESSION['xth'];
	$xlevel = $_SESSION['xlevel'];
	$xusername = $_SESSION['xusername'];
//	$kdunit = $_SESSION['xkdunit'] ;
	$kdbulan = $_REQUEST['kdbulan'];
 	if ( $_REQUEST['kdunit'] <> '' )   $kdunit = $_REQUEST['kdunit'];
 	else   $kdunit = $_SESSION['xkdunit'];
	
	if ( $_REQUEST['kdbulan'] == '' )  $kdbulan = date('m') - 1 ;
	else  $kdbulan = $_REQUEST['kdbulan'];
	
if ( $_REQUEST['cari'] )
{

if ( $xlevel == '4' )
{
	$kdbulan = $_REQUEST['kdbulan'];
}else{
	$kdunit = $_REQUEST['kdunit'];
	$kdbulan = $_REQUEST['kdbulan'];
}

}	
	$xkdunit = substr($kdunit,0,5) ;

if ( strlen($kdbulan) == 1 )    $kdbulan = '0'.$kdbulan ;
//--------------------------
$data_status = mysql_query("select * from proses_verifikasi where kdunitkerja = '$kdunit' 
				AND bulan = '$kdbulan' AND tahun = '$th'");
$rdata_status = mysql_fetch_array($data_status) ;
//--------------------------------

switch ($xlevel)
	{
		case '4':
		if ( $kdunit == '2320100' )
		{
		$sql = "SELECT grade, count(nip) as jumlah, sum(tunker) as jml_tunker, sum(pajak_tunker) as jml_pajak 
				FROM $table WHERE tahun = '$th' and bulan = '$kdbulan' and ( kdunitkerja LIKE '$xkdunit%' 
				OR kdunitkerja = '2320000' )
				GROUP BY grade ORDER BY grade desc";
		$oList = mysql_query($sql);
		}else{
		$sql = "SELECT grade, count(nip) as jumlah, sum(tunker) as jml_tunker, sum(pajak_tunker) as jml_pajak 
				FROM $table WHERE tahun = '$th' and bulan = '$kdbulan' and kdunitkerja LIKE '$xkdunit%' 
				GROUP BY grade ORDER BY grade desc";
		$oList = mysql_query($sql);
		}
		break;	
			
		default:
		if ( $kdunit == '2320100' )
		{
			$sql = "SELECT grade, count(nip) as jumlah, sum(tunker) as jml_tunker, sum(pajak_tunker) as jml_pajak 
					FROM $table WHERE tahun = '$th' and bulan = '$kdbulan' and ( kdunitkerja LIKE '$xkdunit%' 
					OR kdunitkerja = '2320000' )
					GROUP BY grade 
					ORDER BY grade desc";
			$oList = mysql_query($sql);
		}else{
			$sql = "SELECT grade, count(nip) as jumlah, sum(tunker) as jml_tunker, sum(pajak_tunker) as jml_pajak 
					FROM $table WHERE tahun = '$th' and bulan = '$kdbulan' and kdunitkerja LIKE '$xkdunit%' GROUP BY grade 
					ORDER BY grade desc";
			$oList = mysql_query($sql);
		}
		break;
	} 
	
	
	#echo $sql."<BR>";
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
		$total    +=  $List['jumlah'];
	}
	
?>
<div align="right">
	<form action="" method="post">
		<input type="hidden" name="p" value="<?php echo $p; ?>" />
<?php if ( $xlevel == 1 ) {?>
		Unit Kerja : 
		<select name="kdunit">
                      <option value="<?php echo $kdunit ?>"><?php echo  nm_unitkerja($kdunit) ?></option>
                      <option value="">- Pilih Unit Kerja -</option>
                    <?php
							$query = mysql_query("select * from kd_unitkerja WHERE kdsatker <> '' and left(nmunit,5) <> 'DINAS' order by kdunit");
					
						while($row = mysql_fetch_array($query)) { ?>
                      <option value="<?php echo $row['kdunit'] ?>"><?php echo  $row['nmunit']; ?></option>
                    <?php
					} ?>	
	  </select>
<?php }?>
		Pilih Bulan : 
		<select name="kdbulan"><?php
									
					for ($i = 1; $i <= 13; $i++)
					{ ?>
						<option value="<?php echo $i; ?>" <?php if ($i == $kdbulan ) echo "selected"; ?>><?php echo nama_bulan($i) ?></option><?php
					} ?>	
	  </select>
		<input type="submit" value="Tampilkan" name="cari"/>
	</form>
</div><font color="#0066CC" size="2">
<?php 
if ( substr($kdbulan,0,1) == '0' )  $nama_bulan = nama_bulan(substr($kdbulan,1,1));
if ( substr($kdbulan,0,1) <> '0' )  $nama_bulan = nama_bulan($kdbulan);
echo '<strong>'.nm_unitkerja($kdunit).'</strong><br>' ;
echo '<strong>'.'Bulan '.$nama_bulan.' '.$th.'</strong>' ;
?>
<br />
</font>
<a href="source/tunjangan/rekap_nominatif_prn.php?kdunit=<?php echo $kdunit ?>&kdbulan=<?php echo $kdbulan ?>&th=<?php echo $th ?>" title="Cetak Rekap Daftar Nominatif">
			  <img src="css/images/menu/icon-16-print.png" border="0" width="16" height="16"><font size="1">Lampiran II PDF</font></a><font size="1">&nbsp;&nbsp;|&nbsp;</font></a>
			  
<a href="source/tunjangan/rekap_nominatif_xls.php?kdunit=<?php echo $kdunit ?>&kdbulan=<?php echo $kdbulan ?>&th=<?php echo $th ?>" title="Export Rekap Daftar Nominatif" target="_blank"><font size="1">Excel</font></a>&nbsp;&nbsp;|&nbsp;
<?php if ( $rdata_status['status_verifikasi_nominatif'] == '1' ) { ?>
		&nbsp;&nbsp;<font color="#006600">[ Status Verifikasi : <?php echo status_nama($rdata_status['status_verifikasi_nominatif']).
		' tanggal '.reformat_tgl($rdata_status['tanggal_verifikasi_nominatif']) ?> ]</font>
<?php }elseif ( $rdata_status['status_verifikasi_nominatif'] == '0' ) { ?>
		&nbsp;&nbsp;<font color="#006600">[ Status Verifikasi : <?php echo status_nama($rdata_status['status_verifikasi_nominatif']) ?> ]</font>
<?php } ?>
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
			        <td rowspan="3" align="center" valign="top"><?php echo $col[1][$k] ?></td>
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
<?php 
function status_ver($kdunit,$th,$bulan) {
		$data = mysql_query("select * from proses_verifikasi where kdunitkerja = '$kdunit' 
				AND bulan = '$bulan' AND tahun = '$th'");
		$rdata = mysql_fetch_array($data) ;
		$status = $rdata['status_verifikasi_nominatif'] ;
		return $status;
	}
	
function status_nama($kode) {
	switch ( $kode )
	{
		case '0':
		   $nmstatus = 'Belum Diverifikasi' ;
		   break;
		   
		case '1':
		   $nmstatus = 'Telah Diverifikasi' ;
		   break;
		   
		 default:  
			$nmstatus = '' ;
			break;
	}		
		return $nmstatus;
	}
?>