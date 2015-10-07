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

	$xmenu_p = xmenu_id($p);
	$p_next = $xmenu_p->parent;
		
	if (isset($form)) 
	{		
		if ($err != true) 
		{
			$tahun = $_REQUEST['tahun'];
			$bulan = bulan_data($_REQUEST['bulan']);
			$tgl_status = date ('Y-m-d') ;
			if ( $bulan == 13 )
			{
			$sql = "SELECT * FROM $table WHERE tahun = '$tahun' AND bulan = '06' AND kdsatker = '$xusername'"; 
			}else{
			$sql = "SELECT * FROM $table WHERE tahun = '$tahun' AND bulan = '$bulan' AND kdsatker = '$xusername'"; 
			}
			$qu = mysql_query($sql);
			while ($row = mysql_fetch_array($qu))
			{
				$nib = $row['nib'];
				$grade = $row['grade'];
				$status = $row['status'];
				$kdunitkerja = $row['kdunitkerja'];
				$kdunit = substr($row['kdunitkerja'],0,2) ;
				$kdpeg = kdpeg_mst_tk($nib,$tahun,$bulan) ;
				$tunker = tunker_mst_tk($nib,$tahun,$bulan,$grade,$kdunitkerja) ;
				
				$nilpot_01 = $row['kdpot_01'] * persen_pot('01') ;
				$nilpot_02 = $row['kdpot_02'] * persen_pot('02') ;
				$nilpot_03 = $row['kdpot_03'] * persen_pot('03') ;
				$nilpot_04 = $row['kdpot_04'] * persen_pot('04') ;
				$nilpot_05 = $row['kdpot_05'] * persen_pot('05') ;
				$nilpot_06 = $row['kdpot_06'] * persen_pot('06') ;
				$nilpot_07 = $row['kdpot_07'] * persen_pot('07') ;
				$nilpot_08 = $row['kdpot_08'] * persen_pot('08') ;
				
				$nilpot_31 = $row['kdpot_31'] * persen_pot('31') ;
				$nilpot_32 = $row['kdpot_32'] * persen_pot('32') ;
				$nilpot_33 = $row['kdpot_33'] * persen_pot('33') ;
				$nilpot_34 = $row['kdpot_34'] * persen_pot('34') ;

				$nilpot_10 = $row['kdpot_10'] * persen_pot('10') ;
				$nilpot_11 = $row['kdpot_11'] * persen_pot('11') ;
				$nilpot_12 = $row['kdpot_12'] * persen_pot('12') ;
				$nilpot_13 = $row['kdpot_13'] * persen_pot('13') ;
				$nilpot_14 = $row['kdpot_14'] * persen_pot('14') ;
				$nilpot_15 = $row['kdpot_15'] * persen_pot('15') ;
				$nilpot_16 = $row['kdpot_16'] * persen_pot('16') ;
				
				$nilpot_21 = $row['kdpot_21'] * persen_pot('21') ;
				$nilpot_22 = $row['kdpot_22'] * persen_pot('22') ;
				
				$nilpot_40 = $row['kdpot_40'] * persen_pot('40') ;

				$nilpot_tk = $row['kdpot_tk'] * persen_pot('tk') ;
				$nilpot_cm = $row['kdpot_cm'] * persen_pot('cm') ;

//				$selisih_nilpot_tk = $row['kdpot_tk'] * 2;
//				$selisih_nilpot_cm = $row['kdpot_cm'] * 1;
				
				$totpot = $nilpot_10 + $nilpot_11 + $nilpot_12 + $nilpot_13 + $nilpot_14 + $nilpot_15 + $nilpot_16 +
						  $nilpot_01 + $nilpot_02 + $nilpot_03 + $nilpot_04 + $nilpot_05 + $nilpot_06 + $nilpot_07 + $nilpot_08 +
						  $nilpot_31 + $nilpot_32 + $nilpot_33 + $nilpot_34 +
						  $nilpot_21 + $nilpot_22 +
						  $nilpot_40 + $nilpot_tk + $nilpot_cm ;
//						  $nilpot_40 -
//						  $selisih_nilpot_tk - selisih_nilpot_cm;

				$rp_grade = rp_grade($kdunit,$grade,$kdpeg) ;
				$rp_pot = ( $tunker) * ( $totpot/100 ) ;
				if ( $bulan <> 13 )    $nil_terima = $tunker - $rp_pot ;
				else $nil_terima = $tunker ;
//					if ( $status == '0' )
//					{
//							$_SESSION['errmsg'] = "Persetujuan dari KPPN belum diupdate ke sistem ";
//							exit();
					?>
							<meta http-equiv="refresh" content="0;URL=index.php?p=<?php echo $p_next ?>"><?php
//					}
if ( $bulan <> 13 )
{
					$sql_tk = "UPDATE mst_tk SET kurang = '$totpot', nil_terima = '$nil_terima' WHERE nib = '$nib' and tahun = '$tahun' AND bulan = '$bulan' and grade = '$grade' and kdsatker = '$xusername' and kdunitkerja = '$kdunitkerja' ";
}else{
					$sql_tk = "UPDATE mst_tk SET kurang = 0 , nil_terima = '$nil_terima' WHERE nib = '$nib' and tahun = '$tahun' AND bulan = '$bulan' and grade = '$grade' and kdsatker = '$xusername' and kdunitkerja = '$kdunitkerja' ";
}
					mysql_query($sql_tk);
				#}
				
			} 
			?>
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
      <td colspan="2"><span class="style1">Hitung Potongan/Faktor Pengurang Tunjangan Kinerja </span></td>
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
