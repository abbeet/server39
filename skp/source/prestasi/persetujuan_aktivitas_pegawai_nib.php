
<?php
	checkauthentication();
	$table = "dtl_aktivitas";
	$field = array("id","id_skp","tgl","nib","aktivitas","hasil","id_dtl_skp","commit","approv");
	$err = false;
	$p = $_GET['p'];
	$id_skp = $_REQUEST['id_skp'];
	extract($_POST);
	$nib = $_REQUEST['nib'];
	$kdbulan = $_GET['kdbulan'];
	
	$xlevel = $_SESSION['xlevel'];
	$xmenu_p = xmenu_id($p);
	$p_next = $xmenu_p->parent;
	if( $q == '' )	$simpan = 'Tambah' ;
	if( $q <> '' )	$simpan = 'Simpan' ;
	
	if ($kdbulan == "") $kdbulan = date("m")+0;
	
	$sql = "SELECT * FROM mst_skp WHERE id = '$id_skp' ";

	$qu = mysql_query($sql);
	$row = mysql_fetch_array($qu);
	
	$commit = $_POST['commit'];
	
	$oList = mysql_query("SELECT * FROM dtl_aktivitas WHERE id_skp = '$id_skp' and Month(tgl) = '$kdbulan' and commit = '1' ORDER BY tgl");
	$count = mysql_num_rows($oList);
	
	while($List = mysql_fetch_object($oList)) {
		foreach ($field as $k=>$val) {
			$col[$k][] = $List->$val;
			$setuju[] = 'setuju_'.$val ;
		}
	}
	
	if ($commit) {		
		if ($err != true) {
			
			foreach ($col[0] as $k=>$val) {
				
				if ($col[8][$k] == null or $col[8][$k] == 0 or $col[8][$k] == 2 ) {  
				
				$radio= "cek_".$col[0][$k];
				
				$$radio = $_POST[$radio];
			//	echo $$radio. '<br>';
				
				if ( $$radio <> '3' )   #---- ditambah Ana tgl 24 Nop 2013 (ditambah kondisi batal persetujuan atasan, approv = 0 )
				{
				$sql = "update dtl_aktivitas SET  approv='".$$radio."' where id=".$col[0][$k];
				//	echo "hai ". $sql ."<br>"; 
				}else{
				$sql = "update dtl_aktivitas SET  commit = '0' , approv = '0' where id=".$col[0][$k];
				}
					
					$result = mysql_query($sql);
				} 
				}?>
		
			<meta http-equiv="refresh" content="0;URL=index.php?p=397&nib=<?php echo $nib ?>&id_skp=<?php echo $id_skp ?>&kdbulan=<?php echo $kdbulan+0 ?>"><?php
			exit();
		}
	
	} ?>
	
	<script type="text/javascript">
		function form_submit()
		{
			document.forms['form'].submit();
		}
	</script>
	
	<table width="755" cellspacing="1" class="admintable">
		
		<tr>
		  <td colspan="2" align="center"><strong>PEJABAT PENILAI</strong></td>
		  <td colspan="2" align="center"><strong>PNS YANG DINILAI</strong></td>
	  </tr>
		<tr>
		  <td class="key">Nama</td>
		  <td width="207"><?php echo nama_peg($row['nib_atasan']) ?></td>
	      <td width="131" class="key">Nama</td>
	      <td width="178"><?php echo nama_peg($row['nib']) ?></td>
      </tr>
		<tr>
		  <td class="key">NIP</td>
		  <td><?php echo reformat_nipbaru(nip_peg($row['nib_atasan'])) ?></td>
		  <td class="key">NIP</td>
		  <td><?php echo reformat_nipbaru(nip_peg($row['nib'])) ?></td>
	  </tr>
		<tr>
		  <td width="224" class="key">Pangkat/Gol.Ruang</td>
		  <td><?php echo nm_pangkat($row['kdgol_atasan']).' ('.nm_gol($row['kdgol_atasan']).')' ?></td>
		  <td class="key">Pangkat/Gol.Ruang</td>
		  <td><?php echo nm_pangkat($row['kdgol']).' ('.nm_gol($row['kdgol']).')' ?></td>
	    </tr>
		<tr>
			<td class="key"> Jabatan </td>
			<td><?php echo $row['jabatan_atasan'] ?></td>
		    <td class="key">Jabatan</td>
		    <td>
			<?php if( substr($row['kdunitkerja'],1,3) == '000' and substr($row['kdjabatan'],0,4) == '0011' ) 
				  {
					    echo nm_jabatan_eselon1($row['kdunitkerja']);
				  } 
				  elseif ( substr($row['kdunitkerja'],1,3) <> '000' and substr($row['kdjabatan'],0,3) == '001' )
				  {
						echo 'Kepala '.nm_unitkerja($row['kdunitkerja']);
				  }else{
						echo nm_jabatan_ij($row['kdjabatan']);
				  } ?>			</td>
	    </tr>
		<tr>
		  <td class="key">Unit Kerja </td>
		  <td>
		  <?php if ( kdunitkerja_peg($row['nib_atasan']) == '0000' ) 
		  		{
		  			echo 'BATAN';
				}else{
		        	echo trim(skt_unitkerja(substr(kdunitkerja_peg($row['nib_atasan']),0,2))).' - BATAN' ;
				}?>		  </td>
		  <td class="key">Unit Kerja</td>
		  <td><?php echo skt_unitkerja(substr($row['kdunitkerja'],0,2)).' - BATAN' ?></td>
	  </tr>
		<tr>
		  <td colspan="4" align="center" class="row7">&nbsp;</td>
	  </tr>
		<tr>
		  <td colspan="4" align="center" class="row7"><strong>CATATAN HARIAN PELAKSANAAN TUGAS </strong></td>
	  </tr>
  </table>

<br />
<div class="button2-right">
	<div class="prev">
	<a href="index.php?p=393">Kembali</a></div>
</div>
<div align="right">
	<form action="" method="get">
		<input type="hidden" name="p" value="<?php echo $p; ?>" />
        <input type="hidden" name="nib" value="<?php echo $$nib; ?>" />
        <input type="hidden" name="id_skp" value="<?php echo $id_skp; ?>" />
		Pilih Bulan : 
		<select name="kdbulan"><?php
									
					for ($i = 1; $i <= 12; $i++)
					{ ?>
						<option value="<?php echo $i; ?>" <?php if ($i == $kdbulan ) echo "selected"; ?>><?php echo nama_bulan($i); ?></option><?php
					} ?>	
	  </select>
		<input type="submit" value="Tampilkan"/>
	</form>
</div><br />
<form action="index.php?p=397&nib=<?php echo $nib ?>&id_skp=<?php echo $id_skp ?>&kdbulan=<?php echo $kdbulan+0 ?>" method="post" name="form1">
<table width="65%" cellpadding="1" class="adminlist">
	<thead>
	  <tr><td align="right" colspan="9"><input name="commit" type="submit" id="commit" value="Persetujuan"></td></tr>		<tr>
		  <th width="5%" rowspan="2">No.</th>
		  <th width="10%" rowspan="2">Tanggal</th>
		  <th width="21%" rowspan="2">Uraian Kegiatan/Kejadian</th>
		  <th width="6%" rowspan="2">Hasil</th>
		  <th width="22%" rowspan="2">Keterkaitan dengan SKP </th>
	      <th colspan="4">Status</th>
      </tr>
		<tr>
		  <!--th width="14%">Persetujuan<br />
	      Pegawai</th-->
		  <th colspan="3">
          
		Persetujuan<br />Atasan</th>
	  </tr>
		<tr>
		  <th align="center">1</th>
		  <th align="center">2</th>
		  <th align="center">3</th>
		  <th align="center">4</th>
		  <th align="center">5</th>
		  <!--th align="center">6</th-->
		  <th colspan="3" align="center">7</th>
	  </tr>
	</thead>
    
	<tbody><?php
		if ($count == 0) { ?>
			<tr><td align="center" colspan="9">Tidak ada data!</td></tr><?php
		}
		else {
			foreach ($col[0] as $k=>$val) {
				if ($k % 2 == 1) $class = "row0";
				else $class = "row1"; ?>
				<tr class="<?php echo $class ?>">
				  <td height="37" align="center" valign="top"><?php echo $k+1 ?></td>
					<td align="center" valign="top"><?php echo reformat_tgl($col[2][$k]) ?></td>
					<td align="left" valign="top"><?php echo $col[4][$k] ?></td>
					<td align="left" valign="top"><?php echo $col[5][$k] ?></td>
					<td align="left" valign="top"><?php echo nm_skp($col[6][$k]) ?></td>
				    <!--td align="center" valign="top">
					<?php 
					//	$cek = "cek".$col[0][$k];
					switch ( $col[7][$k] )
					{
						case '1':
						//echo "<font color='#0000FF'>Setuju</font>";
						break;
					
						default:
						//echo "<font color='#FF0000'>Draft</font>";
						break;
					} ?>					</td-->
			      <td width="8%" align="center" valign="top">
				  <?php if ( $col[8][$k] == '1') { ?>
				  <font color="#006633">Setuju</font>
				  <?php }elseif ( $col[8][$k] <> '2' ) { ?>
				  <input name="cek_<?php echo $col[0][$k] ?>" id="cek[]" type="radio" value="1" /><br />
				  <font color="#006633">Setuju</font>
				  <?php } ?></td>
				  <td width="8%" align="center" valign="top">	
				  <?php if ( $col[8][$k] == '2') { ?>
				  <font color="#FF9933">Tidak Setuju</font>
				  <?php }elseif ( $col[8][$k] <> '1' ) { ?>
				  	<input name="cek_<?php echo $col[0][$k] ?>" id="cek[]" type="radio" value="2"  /><br />
					<font color="#FF9933">Tidak Setuju</font>
					<?php } ?>					</td>
				  <td width="8%" align="center" valign="top">
				  <?php if ( $col[8][$k] == '2' ) { ?>
				  	<input name="cek_<?php echo $col[0][$k] ?>" id="cek[]" type="checkbox" value="3"  /><br />
					<font color="#FF0000">Kembali ke Pegawai</font>
					<?php } ?>
				  </td>
				</tr>
<?php } 
	  } ?>
	</tbody>
	<tfoot>
	</tfoot>
</table>

</form>
<?php 
	function nm_skp($id) {
		$data = mysql_query("select nama_tugas from dtl_skp where id='$id'");
		$rdata = mysql_fetch_array($data);
		$result = trim($rdata['nama_tugas']);
		return $result;
	}
?>
