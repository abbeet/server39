<?php
	checkauthentication();
	$table = "mst_potongan";
	$field = get_field($table);
	$err = false;
	$p = $_GET['p'];
	extract($_POST);
	$xusername_sess = $_SESSION['xusername'];
	$xusername = $_SESSION['xusername'];
	$xkdunit = $_SESSION['xkdunit'];
	$xlevel = $_SESSION['xlevel'];
	
	$xmenu_p = xmenu_id($p);
	$p_next = $xmenu_p->parent;
		
	if (isset($form)) 
	{		
		if ($err != true) 
		{
			$tahun = $_REQUEST['tahun'];
			$bulan = bulan_data($_REQUEST['bulan']);
			
			$sql_cek = "SELECT status FROM mst_potongan WHERE tahun = '$tahun' and bulan = '$bulan' and left(kdunitkerja,2) = '$xkdunit'";
			$data_cek = mysql_query($sql_cek);
            $rdata_cek = mysql_fetch_array($data_cek);
			if( $rdata_cek['status'] == '1' )
			{
				$_SESSION['errmsg'] = "Data Telah tersedia !"; ?>
			    <meta http-equiv="refresh" content="0;URL=index.php?p=<?php echo $p_next ?>">
				<?php			
				exit();
			}
			
			if ( $xkdunit == '13')
			{
			$sql = "SELECT tahun, bulan, nib, nip, kdsatker, kdunitkerja, kdgol, grade FROM mst_tk WHERE tahun = '$tahun' and bulan = '$bulan' and (left(kdunitkerja,2) = '$xkdunit' or right(kdunitkerja,3) = '000' ) "; 
			}else{
			$sql = "SELECT tahun, bulan, nib, nip, kdsatker, kdunitkerja, kdgol, grade FROM mst_tk WHERE tahun = '$tahun' and bulan = '$bulan' and left(kdunitkerja,2) = '$xkdunit' "; 
			}
			
			$qu = mysql_query($sql);
				
			#hapus dulu datanya
			$sql = "DELETE FROM mst_potongan WHERE tahun = '$tahun' and bulan = '$bulan' and left(kdunitkerja,2) = '$xkdunit'";
			mysql_query($sql);
						
			while ($row = mysql_fetch_array($qu))
			{
				
				$sql = "INSERT INTO mst_potongan (id,tahun, bulan, nib,nip, kdsatker, kdunitkerja, kdgol, grade ) VALUES ('','".$row['tahun']."','".$row['bulan']."','".$row['nib']."','".$row['nip']."','".$row['kdsatker']."','".$row['kdunitkerja']."','".$row['kdgol']."','".$row['grade']."')";# echo $sql.";<br>";
					mysql_query($sql);
				#}
				
			} ?>
			
			<meta http-equiv="refresh" content="0;URL=index.php?p=<?php echo $p_next ?>"><?php
		}
	} ?>

<form action="index.php?p=<?php echo $_GET['p'] ?>" method="post" name="form">
	
  <table width="721" cellspacing="1" class="admintable">
    <tr>
      <td colspan="2"><strong>Copy dari Daftar Nominatif </strong></td>
    </tr>
    <tr>
      <td colspan="2"><strong><?php echo 'Unit Kerja : '. nm_unitkerja($xkdunit.'00') ?></strong></td>
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
