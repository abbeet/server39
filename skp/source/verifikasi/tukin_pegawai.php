<?php
	checkauthentication();
	$p = $_GET['p'];
	$cari = $_GET['cari'];
	$table = "mst_tk";
	$field = array("id","tahun","bulan","nip","kdunitkerja","kdjabatan","kdgol","kdstatuspeg","tmtjabatan","grade","tunker","pajak_tunker");
	$ed_link = "index.php?p=".get_edit_link($p);
	$del_link = "index.php?p=316";
	#Halaman yang akan ditampilkan untuk pertengahan?
	$adjacents = 3;
 	$th = $_SESSION['xth'];
	$xlevel = $_SESSION['xlevel'];
	$xusername = $_SESSION['xusername'];
 	if ( $_REQUEST['kdunit'] <> '' )   $kdunit = $_REQUEST['kdunit'];
 	else   $kdunit = $_SESSION['xkdunit'];
	
	if ( $_REQUEST['kdbulan'] == '' )  $kdbulan = date('m') - 1 ;
	else  $kdbulan = $_REQUEST['kdbulan'];
	
//------------- Proses Verifikasi ----------------
$err = false;
if (isset($_POST['form'])) 
	{		
		if ($err != true) 
		{
				$verifikasi = $_POST['verifikasi'] ;
				$th = $_POST['th'] ;
				$kdbulan = $_POST['kdbulan'] ;
				
				$sql_status = "SELECT * FROM proses_verifikasi WHERE kdunitkerja = '$kdunit' 
							   AND tahun = '$th' and bulan = '$kdbulan'";
				#echo $sql_status."<BR>";
				
				$oList_status = mysql_query($sql_status) ;
				$List_status = mysql_fetch_array($oList_status) ;
				$id_status = $List_status['id'] ;
				$tgl_status = date("Y-m-d");
				
				#echo 'id '.$id_status .'<br>' ;
				
				if (!empty($List_status))
				{
					$sql = "UPDATE proses_verifikasi SET status_verifikasi_nominatif = '$verifikasi' ,
								tanggal_verifikasi_nominatif = '$tgl_status' WHERE id = '$id_status' ";
								
								#echo $sql."<BR>";
					$update = mysql_query($sql);
					
					if ($update)
					{
						$_SESSION['errmsg'] = "Verifikasi daftar nominatif berhasil";
					}
					else
					{
						$_SESSION['errmsg'] = "Verifikasi daftar nominatif gagal";
					}
				}
		?>
		<meta http-equiv="refresh" content="0;URL=index.php?p=<?php echo $p ?>&kdunit=<?php echo $kdunit ?>&kdbulan=<?php echo $kdbulan ?>"><?php
		}
	}	
//----------------------------
		
if ( $_REQUEST['cari'] )
{
	if ( $_REQUEST['kdunit'] <> '' )   $kdunit = $_REQUEST['kdunit'];
 	else   $kdunit = $_SESSION['xkdunit'];
	//$kdunit = $_REQUEST['kdunit'];
	$kdbulan = $_REQUEST['kdbulan'];
}	
	$xkdunit = substr($kdunit,0,5) ;
	
if ( strlen($kdbulan) == 1 )    $kdbulan = '0'.$kdbulan ;
if ( $kdunit == '2320100' )
{
	$sql  = mysql_query("SELECT nip FROM $table WHERE tahun = '$th' and bulan = '$kdbulan' AND 
							(kdunitkerja LIKE '$xkdunit%' OR kdunitkerja = '2320000') ");
}else{
	$sql  = mysql_query("SELECT nip FROM $table WHERE tahun = '$th' and bulan = '$kdbulan' AND kdunitkerja LIKE '$xkdunit%' ");
}
$jml_pegawai = mysql_num_rows($sql) ;

switch ($xlevel)
	{
		case '4':
		if ( $kdunit == '2320100' )
		{
			$query = "SELECT COUNT(*) as num FROM $table WHERE tahun = '$th' and bulan = '$kdbulan' 
					and ( kdunitkerja LIKE '$xkdunit%' OR kdunitkerja = '2320000')";
		}else{
			$query = "SELECT COUNT(*) as num FROM $table WHERE tahun = '$th' and bulan = '$kdbulan' 
					and kdunitkerja LIKE '$xkdunit%' ";
		}
		break;
		
		default:
		if ( $kdunit == '2320100' )
		{
			$query = "SELECT COUNT(*) as num FROM $table WHERE tahun = '$th' and bulan = '$kdbulan' and 
					  (kdunitkerja LIKE '$xkdunit%' OR kdunitkerja = '2320000')";
		}else{
			$query = "SELECT COUNT(*) as num FROM $table WHERE tahun = '$th' and bulan = '$kdbulan' and kdunitkerja LIKE '$xkdunit%'";
		}
		break;
	} 
	
	$total_pages = mysql_fetch_array(mysql_query($query));
	$total_pages = $total_pages[num];
	
	#variabel query
	$targetpage = "index.php?p=$p&kdunit=$kdunit&kdbulan=$kdbulan"; 	#nama file  (nama file ini)
	$limit = 20; 							#berapa yang akan ditampilkan setiap halaman
	$pagess = $_GET['pagess'];
	if($pagess) 
		$start = ($pagess - 1) * $limit; 			
	else
		$start = 0;							#halaman awal

switch ($xlevel)
	{
		case '4':
		if ( $kdunit == '2320100' )
		{
				$oList = mysql_query("SELECT * FROM $table WHERE tahun = '$th' and bulan = '$kdbulan' and 
									( kdunitkerja LIKE '$xkdunit%' OR kdunitkerja = '2320000' ) 
									ORDER BY grade desc,kdgol,kdjabatan LIMIT $start, $limit");
		}else{
				$oList = mysql_query("SELECT * FROM $table WHERE tahun = '$th' and bulan = '$kdbulan' and 
									kdunitkerja LIKE '$xkdunit%' 
									ORDER BY grade desc,kdgol,kdjabatan LIMIT $start, $limit");
		}
		break;
		
		default:
		if ( $kdunit == '2320100' )
		{
				$oList = mysql_query("SELECT * FROM $table WHERE tahun = '$th' and bulan = '$kdbulan' and 
									 ( kdunitkerja LIKE '$xkdunit%' OR kdunitkerja = '2320000' )
									  ORDER BY grade desc,kdgol,kdjabatan LIMIT $start, $limit");
		}else{
				$oList = mysql_query("SELECT * FROM $table WHERE tahun = '$th' and bulan = '$kdbulan'  
										and kdunitkerja LIKE '$xkdunit%' 
										ORDER BY grade desc,kdgol,kdjabatan LIMIT $start, $limit");
		}
		break;
	} 

	$count = mysql_num_rows($oList);
	
	while($List = mysql_fetch_object($oList)) {
		foreach ($field as $k=>$val) {
			$col[$k][] = $List->$val;
		}
		$ed[] = $ed_link."&q=".$List->$field[0];
		$del[] = $del_link."&q=".$List->$field[0];
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
<div align="right">
	<form action="<?php echo $targetpage ?>&pagess=<?php echo $pagess ?>" method="post">
		<input type="hidden" name="p" value="<?php echo $p; ?>" />
<?php if ( $xlevel == 1 ) {?>
		Unit Kerja : 
		<select name="kdunit">
                      <option value="<?php echo $kdunit ?>"><?php echo  nm_unitkerja($kdunit) ?></option>
                      <option value="">- Pilih Unit Kerja -</option>
                    <?php
							$query = mysql_query("select * from kd_unitkerja WHERE kdsatker <> '' and left(nmunit,5) <> 'DINAS' 
												  order by kdunit");
					
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
					<?php if ( $pagess == '' ) {?>
						<option value="<?php echo $i; ?>" <?php if ($i == date("m") ) echo "selected"; ?>><?php echo nama_bulan($i) ?></option><?php
					}else{ ?>
						<option value="<?php echo $i; ?>" <?php if ($i == $kdbulan ) echo "selected"; ?>><?php echo nama_bulan($i) ?></option><?php
					}
					} ?>	
	  </select>
		<input type="submit" value="Tampilkan" name="cari"/>
	</form>
</div><font color="#0066CC" size="2">
<?php 
if ( substr($kdbulan,0,1) == '0' )  $nama_bulan = nama_bulan(substr($kdbulan,1,1));
if ( substr($kdbulan,0,1) <> '0' )  $nama_bulan = nama_bulan($kdbulan);
echo '<strong>'.nm_unitkerja($kdunit).'</strong><br>' ;
//echo '<strong>'.'Bulan '.$nama_bulan.' '.$th.'</strong>' ;
?>
<br />
<font color="#FF0000">Jumlah Pegawai : <?php echo $jml_pegawai ?></font>
<table width="58%" cellpadding="1" class="adminlist">
	<thead>
		
		<tr>
		  <th width="3%" rowspan="2">No.</th>
		  <th rowspan="2">Nama Pegawai / NIP </th>
		  <th colspan="3" >Daftar Nominatif Tukin <?php echo 'Bulan '.$nama_bulan.' '.$th ?></th>
          <th colspan="3">Data Kepegawaian</th>
	  </tr>
		<tr>
		  <th width="10%">Gol/<br />Status</th>
	      <th width="20%">Nama Jabatan/<br />TMT</th>
	      <th width="5%">Grade</th>
	      <th width="5%">Gol/<br />Status</th>
	      <th width="20%">Nama Jabatan/<br />TMT</th>
	      <th width="5%">Grade</th>
	  </tr>
		<tr>
		  <th>(1)</th>
		  <th>(2)</th>
		  <th>(3)</th>
		  <th>(4)</th>
		  <th>(5)</th>
		  <th>(6)</th>
		  <th>(7)</th>
		  <th>(8)</th>
	  </tr>
	</thead>
	<tbody><?php
		if ($count == 0) { ?>
			<tr><td align="center" colspan="8">Tidak ada data!</td></tr><?php
		}
		else {
			foreach ($col[0] as $k=>$val) {
				if ($k % 2 == 1) $class = "row0";
				else $class = "row1"; 
				$nip = $col[3][$k] ;
				$sql = "SELECT * FROM m_idpegawai WHERE nip = '$nip'";
				$query = mysql_query($sql);
				$row = mysql_fetch_array($query);
?>
				<tr class="<?php echo $class ?>">
					<td align="center" valign="top"><?php echo $limit*($pagess-1)+($k+1); ?></td>
					<td align="left" valign="top"><?php echo nama_peg($col[3][$k]) ?><br /><?php echo 'NIP. '.reformat_nipbaru($col[3][$k]) ?></td>
					<td align="center" valign="top">
					<?php if ( $col[6][$k] <> $row['kdgol'] ) { ?>
					<font color="#CC3300"><?php echo nm_gol($col[6][$k]) ?></font>
					<?php }else{ ?>
					<?php echo nm_gol($col[6][$k]) ?>
					<?php } ?>
					<br />
					<?php if ( $col[7][$k] <> $row['kdstatuspeg'] ) { ?>
					<font color="#CC3300"><?php echo nm_status_peg($col[7][$k]) ?></font>
					<?php }else{ ?>
					<?php echo nm_status_peg($col[7][$k]) ?>
					<?php } ?>					</td>
					
					<td align="left" valign="top">
					<?php if ( $col[5][$k] <> $row['kdjabatan'] ) { ?>
					<font color="#CC3300"><?php echo nm_jabatan_ij($col[5][$k],$col[4][$k]) ?></font>
					<?php }else{ ?>
					<?php echo nm_jabatan_ij($col[5][$k],$col[4][$k]) ?>
					<?php } ?>
					<br />
					<?php if ( $col[8][$k] <> $row['tmtjabatan'] ) { ?>
					<font color="#CC3300"><?php echo '['.reformat_tgl($col[8][$k]).']' ?></font>
					<?php }else{ ?>
					<?php echo '['.reformat_tgl($col[8][$k]).']' ?>
					<?php } ?>					</td>
					
					<td align="center" valign="top">
					<?php if ( $col[9][$k] <> grade_jabatan_ij($row['kdjabatan'],$row['kdunitkerja']) ) { ?>
					<font color="#CC3300"><?php echo $col[9][$k] ?></font>
					<?php }else{ ?>
					<?php echo $col[9][$k] ?>
					<?php } ?>					</td>
					
			        <td align="center" valign="top">
					<?php if ( $col[6][$k] <> $row['kdgol'] ) { ?>
					<font color="#CC3300"><?php echo nm_gol($row['kdgol']) ?></font>
					<?php }else{ ?>
					<?php echo nm_gol($col[6][$k]) ?>
					<?php } ?>
					<br />
					<?php if ( $col[7][$k] <> $row['kdstatuspeg'] ) { ?>
					<font color="#CC3300"><?php echo nm_status_peg($row['kdstatuspeg']) ?></font>
					<?php }else{ ?>
					<?php echo nm_status_peg($row['kdstatuspeg']) ?>
					<?php } ?>					</td>
			        <td align="left" valign="top">
					<?php if ( $col[5][$k] <> $row['kdjabatan'] ) { ?>
					<font color="#CC3300"><?php echo nm_jabatan_ij($row['kdjabatan'],$row['kdunitkerja']) ?></font>
					<?php }else{ ?>
					<?php echo nm_jabatan_ij($row['kdjabatan'],$row['kdunitkerja']) ?>
					<?php } ?>
					<br />
					<?php if ( $col[8][$k] <> $row['tmtjabatan'] ) { ?>
					<font color="#CC3300"><?php echo '['.reformat_tgl($row['tmtjabatan']).']' ?></font>
					<?php }else{ ?>
					<?php echo '['.reformat_tgl($row['tmtjabatan']).']' ?>
					<?php } ?>					</td>
					
				    <td align="center" valign="top">
					<?php if ( $col[9][$k] <> grade_jabatan_ij($row['kdjabatan'],$row['kdunitkerja']) ) { ?>
					<font color="#CC3300"><?php echo grade_jabatan_ij($row['kdjabatan'],$row['kdunitkerja']) ?></font>
					<?php }else{ ?>
					<?php echo grade_jabatan_ij($row['kdjabatan'],$row['kdunitkerja']) ?>
					<?php } ?>					</td>
			    </tr>
				
				<?php
			}
		} ?>
	</tbody>
	<tfoot>
		<tr>
			<td colspan="8">
			
<form name="form" method="post" action="">	
			
<table width="779" cellspacing="1" class="admintable">
    

<?php 
$sql = "SELECT * FROM proses_verifikasi WHERE tahun = '$th' AND bulan = '$kdbulan' AND kdunitkerja = '$kdunit'" ;
#echo $sql."<BR>";
$query = mysql_query($sql) ;
$row = mysql_fetch_array($query) ;
?>	
	
    <tr>
      <td width="131" align="right">Status</td>
      <td width="581">
	    <input name="verifikasi" type="radio" value="0" <?php if( $row['status_verifikasi_nominatif'] == '0' ) echo 'checked="checked"' ?>/> 
        &nbsp;&nbsp;Batal&nbsp;&nbsp;
	  	  <input name="verifikasi" type="radio" value="1" <?php if( $row['status_verifikasi_nominatif'] == '1' ) echo 'checked="checked"' ?>/> 
        &nbsp;&nbsp;Verifikasi&nbsp;&nbsp;	  </td>
    </tr>
    
    <tr> 
      <td>&nbsp;</td>
      <td>
        <div class="button2-left"> 
          <div class="next"> <a onclick="form.submit();">Proses</a> </div>
        </div>
        <div class="clr"></div>
        <input style="border: 0pt none ; margin: 0pt; padding: 0pt; width: 0px; height: 0px;" value="Proses" type="submit"> 
        <input name="form" type="hidden" value="1" />
        <input name="kdbulan" type="hidden" value="<?php echo $kdbulan; ?>" />
        <input name="th" type="hidden" value="<?php echo $th; ?>" /> </td>
    </tr>
  </table>			
			</form>				
			</td>
		</tr>
	</tfoot>
</table>
