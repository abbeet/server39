<?php
	checkauthentication();
	$table = "thbp_kak_kegiatan";
	$field = get_field($table);
	$err = false;
	$p = $_GET['p'];
	extract($_POST);
	$th = $_SESSION['xth'] + 1;
	$xusername_sess = $_SESSION['xusername'];
	
	$xmenu_p = xmenu_id($p);
	$p_next = $xmenu_p->parent;
	
	if (isset($form)) 
	{		
		if ($err != true) 
		{
			$tahun 		= $_REQUEST['tahun'];

			$sql = "SELECT * FROM m_kegiatan ";
			$qu2 = mysql_query($sql);

			#hapus dulu datanya
			$sql = "DELETE FROM thbp_kak_kegiatan WHERE th = '".$th."'";
			mysql_query($sql);
			
			$sql = "DELETE FROM thbp_kak_output WHERE th = '".$th."'";
			mysql_query($sql);
			
			while($row2 = mysql_fetch_array($qu2))
			{	

			$sql = "SELECT KDSATKER, KDDEPT, KDUNIT, KDPROGRAM, KDGIAT, sum(JUMLAH) as anggaran_dipa FROM d_item WHERE THANG='$tahun' and KDGIAT = '$row2[kdgiat]' GROUP BY KDGIAT ORDER BY KDGIAT"; 
			$qu = mysql_query($sql);
			$row = mysql_fetch_array($qu);

					$sql = "INSERT INTO thbp_kak_kegiatan VALUES ('','".$th."','".$row2['kdunitkerja']."','".$row['KDDEPT']."','".$row['KDUNIT']."','".$row['KDPROGRAM']."','".$row2['kdgiat']."','','".$row['anggaran_dipa']."','".$row['anggaran_dipa']."','".$row['KDSATKER']."')";# echo $sql.";<br>";
					mysql_query($sql);
				#}
				
       			$sql4 = "SELECT KDOUTPUT, SUM(JUMLAH) as dipa_output FROM d_item WHERE THANG='$tahun' and KDGIAT='$row2[kdgiat]' and KDSATKER = '$row[KDSATKER]' GROUP BY KDOUTPUT ORDER BY KDOUTPUT"; 
				$qu4 = mysql_query($sql4);
								
				while ($row4 = mysql_fetch_array($qu4))
				{
					$sql5 = "SELECT KDOUTPUT, KDSATKER, VOL FROM d_output WHERE THANG='$tahun' and KDDEPT='$row[KDDEPT]' and KDUNIT='$row[KDUNIT]' and KDPROGRAM='$row[KDPROGRAM]' and KDGIAT='$row2[kdgiat]' and KDOUTPUT='$row4[KDOUTPUT]' AND KDSATKER = '$row[KDSATKER]'";
					$qu5 = mysql_query($sql5);
					$row5 = mysql_fetch_array($qu5);
//					echo "testing: " . $row5['KDOUTPUT'] . " -> " . $row5['VOL']; 
					
						$sql = "INSERT INTO thbp_kak_output VALUES ('','".$th."','".$row2['kdunitkerja']."','".$row['KDGIAT']."','".$row4['KDOUTPUT']."','".$row4['dipa_output']."','".$row5['VOL']."','','".$row['KDSATKER']."')"; #echo $sql.";<br>";
						mysql_query($sql);
					#}
				}
				}  # while qu
			?>
			
			<meta http-equiv="refresh" content="0;URL=index.php?p=<?php echo $p_next ?>&cari=<?php echo $tahun; ?>"><?php
		}
	} ?>

<form action="index.php?p=<?php echo $_GET['p'] ?>" method="post" name="form">
	
  <table width="721" cellspacing="1" class="admintable">
    <tr>
      <td width="131" class="key">DIPA Tahun  </td>
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
