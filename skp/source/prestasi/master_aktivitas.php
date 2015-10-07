<?php
	checkauthentication();
	$table = "mst_tk";
	$field = get_field($table);
	$err = false;
	$p = $_GET['p'];
	extract($_POST);
	$xusername_sess = $_SESSION['xusername'];
	$xusername = $_SESSION['xusername'];

	$xmenu_p = xmenu_id($p);
	$p_next = $xmenu_p->parent;
		
	if (isset($form)) 
	{		
		if ($err != true) 
		{
			$tahun = $_REQUEST['tahun'];
			$bulan = bulan_data($_REQUEST['bulan']);
			
			$sql = "SELECT * FROM mst_skp WHERE tahun = '$tahun' and nib = '$xusername' "; 
			$qu = mysql_query($sql);
			$row = mysql_fetch_array($qu);
				
			#hapus dulu datanya
			$sql = "DELETE FROM mst_aktivitas WHERE tahun = '$tahun' and bulan = '$bulan' and nib = '$xusername'";
			mysql_query($sql);
						
					$sql_mst = "INSERT INTO mst_aktivitas(id,tahun,bulan,nib,kdunitkerja,kdjabatan,kdgol,nib_atasan,jabatan_atasan,kdgol_atasan) VALUES ('','$row[tahun]','$bulan','$row[nib]','$row[kdunitkerja]','$row[kdjabatan]','$row[kdgol]','$row[nib_atasan]','$row[jabatan_atasan]','$row[kdgol_atasan]')";  # echo $sql.";<br>";
					mysql_query($sql_mst);
					
			for ($i = 1 ; $i <= days_in_month($tahun, $bulan) ; $i++)
					{ 
					
					if ( strlen ( $i ) == 1 )  $tgl = '0'.$i ;
					if ( strlen ( $i ) == 2 )  $tgl = $i ;
					$tanggal = $tahun.'-'.$bulan.'-'.$tgl ; 
					$namahari = nama_hari($tanggal);
					echo 'nama hari '.$namahari.'<br>';
					$ket = '0' ;
					if ( $namahari == 'Sabtu' ) $ket = '1';
					if ( $namahari == 'Minggu' ) $ket = '2';
					if ( status_libur($tanggal) == 'L' )  $ket = '3';
					$sql_dtl = "INSERT INTO dtl_aktivitas(id,tahun,bulan,tgl,nib,ket) VALUES ('','$tahun','$bulan','$tgl','$row[nib]','$ket')";  # echo $sql.";<br>";
					mysql_query($sql_dtl);
					} 
			?>
			
			<!--meta http-equiv="refresh" content="0;URL=index.php?p=<?php echo $p_next ?>"><?php
		}
	} ?><form action="index.php?p=<?php echo $_GET['p'] ?>" method="post" name="form">
	
  <table width="721" cellspacing="1" class="admintable">
    <tr>
      <td colspan="2"><strong>Buat Agenda Aktivitas </strong></td>
    </tr>
    <tr>
      <td width="131" class="key">Tahun</td>
      <td width="581"><select name="tahun">
          <?php
					for ($i = date("Y")-5; $i <= date("Y")+5; $i++)
					{ ?>
          <option value="<?php echo $i; ?>" <?php if ($i == date ("Y") ) echo "selected"; ?>><?php echo $i ; ?></option>
          <?php
					} ?>
        </select></td>
    </tr>
    <tr> 
      <td class="key">Bulan</td>
      <td> <select name="bulan">
          <?php
					for ($i = 1; $i <= 12; $i++)
					{ ?>
          <option value="<?php echo $i; ?>" <?php if ($i == date ("m") ) echo "selected"; ?>><?php echo $i ; ?></option>
          <?php
					} ?>
        </select> </td>
    </tr>
    <tr> 
      <td>&nbsp;</td>
      <td> <div class="button2-right"> 
          <div class="prev"> <a onclick="Cancel('index.php?p=<?php echo $p_next ?>')">Batal</a>          </div>
        </div>
        <div class="button2-left"> 
          <div class="next"> <a onclick="form.submit();">Proses</a> </div>
        </div>
        <div class="clr"></div>
        <input style="border: 0pt none ; margin: 0pt; padding: 0pt; width: 0px; height: 0px;" value="Simpan" type="submit"> 
        <input name="form" type="hidden" value="1" /> </td>
    </tr>
  </table>
</form>
<?php 
	function bulan_data($bulan) {
	    if ( $bulan <= 9 )  $bulan = '0'.$bulan;
		if( $bulan >= 10 )  $bulan = $bulan ;
		return $bulan;
	}
?>
