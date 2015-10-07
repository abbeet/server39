<?php
	checkauthentication();
	$table = "mst_tk";
	$field = get_field($table);
	$err = false;
	$p = $_GET['p'];
	extract($_POST);
	$xusername_sess = $_SESSION['xusername'];
	$xusername = $_SESSION['xusername'];
	$th = $_SESSION['xth'] ;
	$th_lalu = $th - 1 ;
	
	$xmenu_p = xmenu_id($p);
	$p_next = $xmenu_p->parent;
		
	if (isset($form)) 
	{		
		if ($err != true) 
		{
			
			$sql = "SELECT * FROM mst_skp WHERE tahun = '$th_lalu' "; 
			$qu = mysql_query($sql);
										
			while ($row = mysql_fetch_array($qu))
			{
					$nip 			= $row['nip'] ;
					$kdunitkerja 	= $row['kdunitkerja'] ;
					$kdgol		 	= $row['kdgol'] ;
					$kdjabatan	 	= $row['kdjabatan'] ;
					$nib_atasan 	= $row['nib_atasan'] ;

						$sql_ini = "SELECT * FROM mst_skp WHERE tahun = '$th' AND nip = '$nip' AND kdunitkerja = '$kdunitkerja' AND kdjabatan = '$kdjabatan' "; 
						$qu_ini = mysql_query($sql_ini);
						$row_ini = mysql_fetch_array($qu_ini) ;

							if ( !empty($row_ini) )
							{
								$id  =  $row_ini['id'] ;
								$sql_copi = "UPDATE mst_skp SET nib_atasan = '$nip_user' WHERE id = '$id' ";
							}else{
								$sql_copi = "INSERT INTO mst_skp (tahun,nip,kdunitkerja,kdgol,kdjabatan,nib_atasan)
													VALUES ('$th' , '$nip' , '$kdunitkerja' , '$kdgol' , '$kdjabatan' , '$nib_atasan') ";
							}
							mysql_query($sql_copi);
			} ?>
			
			<meta http-equiv="refresh" content="0;URL=index.php?p=<?php echo $p_next ?>"><?php
		}
	} ?>

            <style type="text/css">
<!--
.style1 {
	font-size: 18px;
	font-weight: bold;
}
-->
            </style>
            <form action="index.php?p=<?php echo $_GET['p'] ?>" method="post" name="form">
	
  <table width="721" cellspacing="1" class="admintable">
    <tr>
      <td colspan="2"><span class="style1">Copy Data Pemegang Jabatan dari Tahun N-1</span></td>
    </tr>
    <tr>
      <td colspan="2">&nbsp;</td>
    </tr>
    
    <tr> 
      <td width="131">&nbsp;</td>
      <td width="581"> <div class="button2-right"> 
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
