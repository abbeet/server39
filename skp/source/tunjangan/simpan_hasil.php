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
			$tgl_status = date ('Y-m-d') ;
			$sql = "SELECT id,nib,grade,gaji,kdunitkerja,kdkawin,iwp,pajak_gaji,kdpeg,jml_hari,tfungsi FROM mst_tk WHERE tahun = '$tahun' AND bulan = '$bulan' AND kdsatker = '$xusername'"; 
			$qu = mysql_query($sql);
										
			while ($row = mysql_fetch_array($qu))
			{
					$id = $row['id'];
					if ( $row['jml_hari'] == 0 )  $tunker = rp_grade(substr($row['kdunitkerja'],0,2),$row['grade'],$row['kdpeg']);
					if ( $row['jml_hari'] <> 0 )  $tunker = rp_grade(substr($row['kdunitkerja'],0,2),$row['grade'],$row['kdpeg']) * ( $row['jml_hari']/hari_bulan($tahun,$bulan) ) ;
					
					if ( $xusename = '524334' )
					{
						$tunker = $tunker - $row['tfungsi'] ;
					}
					
					$gaji_bruto    = $row['gaji'] + $tunker ;
				    $pajak_total   = nil_pajak($gaji_bruto,$row['kdkawin'],$row['iwp']);
					$pajak_gaji    = $row['pajak_gaji'];
					$pajak_tunker  = $pajak_total - $pajak_gaji ;
					$sql_inp = "UPDATE mst_tk SET tunker = '$tunker' , pajak_tunker = '$pajak_tunker' WHERE id = '$id' ";
					mysql_query($sql_inp);
				#}
				
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
					for ($i = 1; $i <= 13; $i++)
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
