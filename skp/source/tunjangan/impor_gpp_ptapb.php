<?php
//	checkauthentication();
	$table = "mst_tk";
	$field = get_field($table);
	$err = false;
	$p = $_GET['p'];
	extract($_POST);
	$xusername_sess = $_SESSION['xusername'];
	$xusername = $_SESSION['xusername'];
	$tahun = $_REQUEST['th'];
	$bulan = bulan_data($_REQUEST['kdbulan']);
			
	$xmenu_p = xmenu_id($p);
	$p_next = $xmenu_p->parent;
		
	if (isset($form)) 
	{		
		if ($err != true) 
		{
			
			$sql = "SELECT * FROM mst_tk WHERE tahun = '2013' and bulan = '11' and kdsatker = '017290' ";
			$data = mysql_query($sql);
						
			while ($row = mysql_fetch_array($data))
			{
				$no += 1 ;
				echo 'nomor '.$no.'<br>';
				echo 'nip   : '.$row['nip'].'<br>';
				echo 'gaji  : '.$row['gaji'].'<br>';
				echo 'pajak : '.$row['pajak_gaji'].'<br>';	
				echo 'iwp   : '.$row['iwp'].'<br>';	
				echo '----------------------'.'<br>';	
				
				$sql_satker = "SELECT * FROM gaji_ptapb_nov WHERE nip = '$row[nip]' ";
				$data_satker = mysql_query($sql_satker);
						
				$row_satker = mysql_fetch_array($data_satker);
				echo 'nip   : '.$row_satker['nip'].'<br>';
				echo 'gaji  : '.$row_satker['gaji_kotor']+$row_satker['pph'].'<br>';
				echo 'pajak : '.$row_satker['pph'].'<br>';	
				echo 'iwp   : '.$row_satker['iwp'].'<br>';	
				echo '----------------------'.'<br>';	
				$gaji_bruto = $row_satker['gaji_kotor']+$row_satker['pph'] ;
				$sql_ubah = "UPDATE mst_tk SET gaji = '$gaji_bruto',
												pajak_gaji = '$row_satker[pph]',
												iwp = '$row_satker[iwp]'
												WHERE tahun = '2013' and bulan = '11' and kdsatker = '017290' and nip = '$row[nip]' ";
				$data_ubah = mysql_query($sql_ubah);
			
			} 
			
	
		}
	} ?>

<form action="index.php?p=<?php echo $_GET['p'] ?>&tahun=<?php echo $tahun ?>&bulan =<?php echo $bulan ?>" method="post" name="form">
	
  <table width="721" cellspacing="1" class="admintable">
    <tr>
      <td colspan="2"><strong>Copy dari Daftar Gaji (GPP)</strong></td>
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
