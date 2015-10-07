<?php
	checkauthentication();
	$err = false;
	$xusername = $_SESSION['xusername'];
	$xlevel = $_SESSION['xlevel'];
	$ta = $_SESSION['xth'];
	$kdtahun_ke = $ta;
	$kdbulan_ke = date('m');
	extract($_POST);
	$xmenu_p = xmenu_id($p);
	$p_next = $xmenu_p->parent;
	
	if (isset($form)) 
	{		
		if ($err != true) 
		{
		    $kdtahun_dari = $_REQUEST['kdtahun_dari'];
		    $kdbulan_dari = $_REQUEST['kdbulan_dari'];
		    $kdtahun_ke = $_REQUEST['kdtahun_ke'];
		    $kdbulan_ke = $_REQUEST['kdbulan_ke'];
			if ( $kdbulan_dari <= 9 )    $kdbulan_dari = '0'.$kdbulan_dari ;
			if ( $kdbulan_ke <= 9 )    $kdbulan_ke = '0'.$kdbulan_ke ;

			$kdsatker_input = $_REQUEST['kdsatker'];
			
			if( $kdsatker_input <> '' ) {
				$sql = "SELECT id,nip from mst_tk WHERE bulan = '$kdbulan_ke' and tahun = '$kdtahun_ke' AND kdsatker = '$kdsatker_input'";
				$GPP = mysql_query($sql);
				while($row =mysql_fetch_array($GPP)){
					$nip = $row['nip'];
					$id = $row['id'];
					$norec = norec_lalu($nip,$kdsatker_input,$kdbulan_dari,$kdtahun_dari) ;
					$sql_update = "UPDATE mst_tk SET norec = '$norec' WHERE id = '$id'";
					mysql_query($sql_update);
						
				}	# AND WHILE
			}
			
		}
					?>
					<meta http-equiv="refresh" content="0;URL=index.php?p=<?php echo $p_next ?>"><?php
					exit();
	} 
?>
<?php 
	function norec_lalu($nip,$kdsatker,$kdbulan,$kdtahun) {
		$data = mysql_query("select norec from mst_tk where kdsatker = '$kdsatker' and nip = '$nip' and bulan = '$kdbulan' and tahun = '$kdtahun'");
		$rdata = mysql_fetch_array($data);
		$result = trim($rdata['norec']);
		return $result;
	}
?>
            <style type="text/css">
<!--
.style1 {color: #990000}
-->
            </style>
            <form action="" method="post" name="form" enctype="multipart/form-data">
	
  <table cellspacing="1" class="admintable">
    <tr>
      <td colspan="2">
	 <strong>Proses Copy Data Rekening Bank</strong></td>
    </tr>
    <tr>
      <td class="key">Dari : </td>
      <td class="key">&nbsp;</td>
    </tr>
    <tr>
      <td class="key">Tahun</td>
      <td><select name="kdtahun_dari">
        <?php
									
					for ($i = 2012; $i <= Date('Y'); $i++)
					{ ?>
          <option value="<?php echo $i; ?>" <?php if ($i == $kdtahun_dari) echo "selected"; ?>><?php echo $i ?></option>
        <?php
					} ?>
      </select></td>
    </tr>
    <tr>
      <td class="key">Bulan</td>
      <td><select name="kdbulan_dari">
        <?php
									
					for ($i = 1; $i <= 13; $i++)
					{ ?>
          <option value="<?php echo $i; ?>" <?php if ($i == $kdbulan_dari) echo "selected"; ?>><?php echo nama_bulan($i) ?></option>
        <?php
					} ?>
      </select></td>
    </tr>
    
    <tr>
      <td class="key">Ke : </td>
      <td class="key">&nbsp;</td>
    </tr>
    <tr> 
      <td width="120" class="key">Tahun</td>
      <td width="335"><select name="kdtahun_ke">
        <?php
									
					for ($i = 2012; $i <= Date('Y'); $i++)
					{ ?>
        <option value="<?php echo $i; ?>" <?php if ($i == $kdtahun_ke) echo "selected"; ?>><?php echo $i ?></option>
        <?php
					} ?>
      </select>      </td>
    </tr>
    <tr>
      <td class="key">Bulan</td>
      <td>		<select name="kdbulan_ke"><?php
									
					for ($i = 1; $i <= 13; $i++)
					{ ?>
						<option value="<?php echo $i; ?>" <?php if ($i == $kdbulan_ke) echo "selected"; ?>><?php echo nama_bulan($i) ?></option><?php
					} ?>	
	  </select></td>
    </tr>
    <tr>
      <td class="key">Satker</td>
      <td><select name="kdsatker">
            <option value="">- Pilih Satker -</option>
		    <?php
	switch ($xlevel)
	{
		case '1':
			$query = mysql_query("select kdsatker, left(nmsatker,60) as namasatker from kd_satker group bu kdsatker order by kdsatker");
			break;
		case '7':
			$query = mysql_query("select kdsatker, left(nmsatker,60) as namasatker from kd_satker WHERE kdsatker = '$xusername' order by kdsatker");
			break;
		default:
			$query = mysql_query("select kdsatker, left(nmsatker,60) as namasatker from t_satker order by kdsatker");
			break;
	}
			while($row = mysql_fetch_array($query)) { ?>
            <option value="<?php echo $row['kdsatker'] ?>"><?php echo  $row['kdsatker'].' '.$row['namasatker']; ?></option>
		    <?php
			} ?>
          </select></td>
    </tr>
    <tr>
      <td class="key">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    
    
    <tr> 
      <td>&nbsp;</td>
      <td> <div class="button2-right"> 
          <div class="prev"><a onclick="Back('index.php?p=<?php echo $p_next ?>&kdbulan=<?php echo $kdbulan_input ?>&kdsatker=<?php echo $kdsatker_input ?>')">Kembali</a></div>
        </div>
        <div class="button2-left"> 
          <div class="next"> <a onclick="form.submit();">Proses</a></div>
        </div>
        <div class="clr"></div>
        <input style="border: 0pt none ; margin: 0pt; padding: 0pt; width: 0px; height: 0px;" value="Simpan" type="submit"> 
        <input name="form" type="hidden" value="1" /> </td>
    </tr>
  </table>
</form>