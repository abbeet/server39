<?php
	checkauthentication();
	$table = "thbp_kak_kegiatan";
	$field = get_field($table);
	$err = false;
	$p = $_GET['p'];
	extract($_POST);
	$xusername_sess = $_SESSION['xusername'];
	
	$xmenu_p = xmenu_id($p);
	$p_next = $xmenu_p->parent;
	
	if (isset($form)) 
	{		
		if ($err != true) 
		{
			$tahun 		= $_REQUEST['tahun'];
			$kdsatker   = $_REQUEST['kdsatker'];

			$sql = "SELECT KDDEPT, KDUNIT, KDGIAT, sum(JUMLAH) as anggaran_dipa FROM d_item WHERE THANG='$tahun' and KDSATKER = '$kdsatker' GROUP BY concat(KDDEPT,KDUNIT,KDGIAT) ORDER BY concat(KDDEPT,KDUNIT,KDGIAT)"; 
			$qu = mysql_query($sql);
				
			$sql = "SELECT KDUNITKERJA FROM t_satker WHERE KDSATKER = '$kdsatker'";
			$qu2 = mysql_query($sql);
			$row2 = mysql_fetch_array($qu2);
			$kdunitkerja = $row2['KDUNITKERJA'];
			#hapus dulu datanya
			$sql = "DELETE FROM thbp_kak_kegiatan WHERE th = '".$tahun."' and kdsatker = '".$kdsatker."'";
			mysql_query($sql);
			
			$sql = "DELETE FROM thbp_kak_output WHERE th = '".$tahun."' and kdsatker = '".$kdsatker."'";
			mysql_query($sql);
			
			$row = mysql_fetch_array($qu);
				
			$sql = "SELECT KDPROGRAM FROM t_giat WHERE KDGIAT = '".$row['KDGIAT']."'";
			$qu3 = mysql_query($sql);
			$row3 = mysql_fetch_array($qu3);

					$sql = "INSERT INTO thbp_kak_kegiatan VALUES ('','".$tahun."','".$row2['KDUNITKERJA']."','".$row['KDDEPT']."','".$row['KDUNIT']."','".$row3['KDPROGRAM']."','".$row['KDGIAT']."','','".$row['anggaran_dipa']."','','$kdsatker')";# echo $sql.";<br>";
					mysql_query($sql);
				#}
				
       			$sql = "SELECT KDOUTPUT, SUM(JUMLAH) as dipa_output FROM d_item WHERE THANG='$tahun' and KDGIAT='$row[KDGIAT]' and KDSATKER = '$kdsatker' GROUP BY KDOUTPUT ORDER BY KDOUTPUT"; 
				$qu4 = mysql_query($sql);
								
				while ($row4 = mysql_fetch_array($qu4))
				{
					$sql = "SELECT VOL FROM d_output WHERE THANG='$tahun' and KDDEPT='$row[KDDEPT]' and KDUNIT='$row[KDUNIT]' and KDPROGRAM='$row3[KDPROGRAM]' and KDGIAT='$row[KDGIAT]' and KDOUTPUT='$row4[KDOUTPUT]'";
					$qu5 = mysql_query($sql);
					$row5 = mysql_fetch_array($qu5);
					$sat_output = sat_output($row['KDGIAT'].$row4['KDOUTPUT']);
					
						$sql = "INSERT INTO thbp_kak_output VALUES ('','".$tahun."','".$row2['KDUNITKERJA']."','".$row['KDGIAT']."','".$row4['KDOUTPUT']."','".$row4['dipa_output']."','".$row5['VOL']."','$sat_output','$kdsatker')"; #echo $sql.";<br>";
						mysql_query($sql);
					#}
				}
			?>
			
			<meta http-equiv="refresh" content="0;URL=index.php?p=<?php echo $p_next ?>&cari=<?php echo $tahun; ?>"><?php
		}
	} ?>

<form action="index.php?p=<?php echo $_GET['p'] ?>" method="post" name="form">
	
  <table width="721" cellspacing="1" class="admintable">
    <tr>
      <td width="131" class="key">Tahun Anggaran </td>
      <td width="581"><select name="tahun">
          <?php
					for ($i = date("Y")-10; $i <= date("Y")+10; $i++)
					{ ?>
          <option value="<?php echo $i; ?>" <?php if ($i == date ("Y") ) echo "selected"; ?>><?php echo $i ; ?></option>
          <?php
					} ?>
        </select></td>
    </tr>
    <tr> 
      <td class="key">Satker</td>
      <td> <select name="kdsatker">
          <option value="">- Pilih Satker -</option>
          <?php
							$query = mysql_query("select KDSATKER,left(NMSATKER,70) as namasatker from t_satker order by KDSATKER");					
						while($row = mysql_fetch_array($query)) { ?>
          <option value="<?php echo $row['KDSATKER'] ?>"><?php echo  $row['KDSATKER'].' '.$row['namasatker']; ?></option>
          <?php
						} ?>
        </select> </td>
    </tr>
    <tr> 
      <td>&nbsp;</td>
      <td> <div class="button2-right"> 
          <div class="prev"> <a onclick="Cancel('index.php?p=<?php echo $p_next ?>')">Batal</a> 
          </div>
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
	function tahun_ke($tahun) {
		if( $tahun == 2010 ) $th_ke = 1 ;
		if( $tahun == 2011 ) $th_ke = 2 ;
		if( $tahun == 2012 ) $th_ke = 3 ;
		if( $tahun == 2013 ) $th_ke = 4 ;
		if( $tahun == 2014 ) $th_ke = 5 ;
		return $th_ke;
	}
?>
