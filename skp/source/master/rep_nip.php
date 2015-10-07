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
			
			$sql = "SELECT * FROM mst_skp"; 
			$qu = mysql_query($sql);
										
			while ($row = mysql_fetch_array($qu))
			{
					if ( substr($row['nip'],8,1) == ' ' )
					{
						$id = $row['id'] ;
						$nip = $row['nip'] ;
						$no += 1 ;
						$lahir = substr($row['nip'],0,8) ;
						
						$sql_user = "SELECT * FROM xuser where left(username,8) = '$lahir' "; 
						$qu_user = mysql_query($sql_user);
						while ($row_user = mysql_fetch_array($qu_user))
						{
							 $nip_user = $row_user['username'] ;
							 
							if ( substr($nip,9,6) == substr($nip_user,8,6) )
							{
								echo $no.'. '.$nip .' diganti '.$nip_user.'<br>' ;
								$sql_inp = "UPDATE mst_skp SET nip = '$nip_user' WHERE id = '$id' ";
								mysql_query($sql_inp);
							}
						}
						
				    }
				
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
      <td colspan="2"><span class="style1">Simpan Data Tunjangan Kinerja </span></td>
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
