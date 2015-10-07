<?php
	checkauthentication();
	$err = false;

	extract($_POST);
	$xmenu_p = xmenu_id($p);
	$p_next = $xmenu_p->parent;
	$th = $_SESSION['xth'];
	$xlevel = $_SESSION['xlevel'];
	$xkdunit = $_SESSION['xkdunit'];
	$xusername = $_SESSION['xusername'] ;
	$kdsatker = kd_satker($xkdunit) ;
	
	if (isset($form)) 
	{		
		if ($err != true) 
		{
		
			$kdsatker_input = $_REQUEST['kdsatker'];
						
			if( $kdsatker_input <> '' ) 
			{
		$tabel_1 = $kdsatker_input.'_d_spmind' ;
		$tabel_2 = $kdsatker_input.'_d_spmmak' ;
		$tabel_3 = $kdsatker_input.'_m_spmind' ;
		$tabel_4 = $kdsatker_input.'_m_spmmak' ;
		if ( mysql_num_rows(mysql_query("SHOW TABLES LIKE '".$tabel_1."'")) == 1 )
		{
		$sql_ind = "select * from $tabel_1 where thang = '$th' and kdsatker = '$kdsatker_input' and tgspm <> '0000-00-00' "; 
		$data_ind = mysql_query($sql_ind);
		while( $rdata_ind = mysql_fetch_array($data_ind))
		{
			$thang		= $rdata_ind['thang'] ;
			$kddept		= $rdata_ind['kddept'] ;
			$kdunit		= $rdata_ind['kdunit'] ;
			$kdsatker	= $rdata_ind['kdsatker'] ;
			$kdprogram	= $rdata_ind['kdprogram'] ;
			$kdgiat		= $rdata_ind['kdgiat'] ;
			$kdoutput	= $rdata_ind['kdoutput'] ;
			$totnilmak	= $rdata_ind['totnilmak'] ;
			$totnilmap	= $rdata_ind['totnilmap'] ;
			$nospm		= $rdata_ind['nospm'] ;
			$tgspm		= $rdata_ind['tgspm'] ;
			
			$sql_db = mysql_query("SELECT * FROM d_spmind WHERE THANG = '$thang' AND KDSATKER = '$kdsatker' AND NOSPM = '$nospm' AND TGSPM = '$tgspm' ");
			$rsql_db = mysql_fetch_array($sql_db);	
			if ( empty($rsql_db) )
				{	
					$sql = "INSERT INTO d_spmind(THANG,KDDEPT,KDUNIT,KDSATKER,KDPROGRAM,KDGIAT,KDOUTPUT,TOTNILMAK,TOTNILMAP,NOSPM,TGSPM)
									 VALUES ('$thang', '$kddept', '$kdunit', '$kdsatker', '$kdprogram', '$kdgiat', '$kdoutput', '$totnilmak' , '$totnilmap','$nospm','$tgspm')";
				}else{	
					$sql = "UPDATE d_spmind SET KDDEPT = '$kddept' , KDUNIT = '$kdunit' , KDPROGRAM = '$kdprogram' , KDGIAT = '$kdgiat' ,
					               KDOUTPUT = '$kdoutput' , TOTNILMAK = '$totnilmak' , TOTNILMAP = '$totnilmap'  
								   WHERE THANG = '$thang' AND KDSATKER = '$kdsatker' AND NOSPM = '$nospm' AND TGSPM = '$tgspm' ";
				}	
					mysql_query($sql);
		}	# AND WHILE
		}		# AND CEK FILE D_SPMIND
		
		if ( mysql_num_rows(mysql_query("SHOW TABLES LIKE '".$tabel_3."'")) == 1 )
		{
		$sql_ind = "select nospm from $tabel_3 where thang = '$th' and kdsatker = '$kdsatker_input' and tgspm <> '0000-00-00' "; 
		$data_ind = mysql_query($sql_ind);
		while( $rdata_ind = mysql_fetch_array($data_ind))
		{
			$thang		= $rdata_ind['thang'] ;
			$kddept		= $rdata_ind['kddept'] ;
			$kdunit		= $rdata_ind['kdunit'] ;
			$kdsatker	= $rdata_ind['kdsatker'] ;
			$kdprogram	= $rdata_ind['kdprogram'] ;
			$kdgiat		= $rdata_ind['kdgiat'] ;
			$kdoutput	= $rdata_ind['kdoutput'] ;
			$totnilmak	= $rdata_ind['totnilmak'] ;
			$totnilmap	= $rdata_ind['totnilmap'] ;
			$nospm		= $rdata_ind['nospm'] ;
			$tgspm		= $rdata_ind['tgspm'] ;
			
			$sql_db = mysql_query("SELECT * FROM d_spmind WHERE THANG = '$thang' AND KDSATKER = '$kdsatker' AND NOSPM = '$nospm' AND TGSPM = '$tgspm' ");
			$rsql_db = mysql_fetch_array($sql_db);	
			if ( empty($rsql_db) )
				{	
					$sql = "INSERT INTO d_spmind(THANG,KDDEPT,KDUNIT,KDSATKER,KDPROGRAM,KDGIAT,KDOUTPUT,TOTNILMAK,TOTNILMAP,NOSPM,TGSPM)
									 VALUES ('$thang', '$kddept', '$kdunit', '$kdsatker', '$kdprogram', '$kdgiat', '$kdoutput', '$totnilmak' , '$totnilmap','$nospm','$tgspm')";
				}else{	
					$sql = "UPDATE d_spmind SET KDDEPT = '$kddept' , KDUNIT = '$kdunit' , KDPROGRAM = '$kdprogram' , KDGIAT = '$kdgiat' ,
					               KDOUTPUT = '$kdoutput' , TOTNILMAK = '$totnilmak' , TOTNILMAP = '$totnilmap'  
								   WHERE THANG = '$thang' AND KDSATKER = '$kdsatker' AND NOSPM = '$nospm' AND TGSPM = '$tgspm' ";
				}	
					mysql_query($sql);
		}	# AND WHILE
		}		# AND CEK FILE M_SPMIND
			
		if ( mysql_num_rows(mysql_query("SHOW TABLES LIKE '".$tabel_2."'")) == 1 )
		{
		$sql_ind = "select * from $tabel_2 where thang = '$th' and kdsatker = '$kdsatker_input' and tgspm <> '0000-00-00' "; 
		$data_ind = mysql_query($sql_ind);
		while( $rdata_ind = mysql_fetch_array($data_ind))
		{
			$thang		= $rdata_ind['thang'] ;
			$kdsatker	= $rdata_ind['kdsatker'] ;
			$nospm		= $rdata_ind['nospm'] ;
			$tgspm		= $rdata_ind['tgspm'] ;
			$kdakun		= $rdata_ind['kdakun'] ;
			$nilmak		= $rdata_ind['nilmak'] ;
			
			$sql_db = mysql_query("SELECT * FROM d_spmmak WHERE THANG = '$thang' AND KDSATKER = '$kdsatker' AND NOSPM = '$nospm' AND TGSPM = '$tgspm' ");
			$rsql_db = mysql_fetch_array($sql_db);	
			if ( empty($rsql_db) )
				{	
					$sql = "INSERT INTO d_spmmak(THANG,KDSATKER,NOSPM,TGSPM,KDAKUN,NILMAK)
									 VALUES ('$thang', '$kdsatker', '$nospm','$tgspm' , '$kdakun' , '$nilmak' )";
				}else{	
					$sql = "UPDATE d_spmmak SET kdakun = '$kdakun' , nilmak = '$nilmak'   
								   WHERE THANG = '$thang' AND KDSATKER = '$kdsatker' AND NOSPM = '$nospm' AND TGSPM = '$tgspm' ";
				}	
					mysql_query($sql);
		}	# AND WHILE
		}		# AND CEK FILE D_SPMMAK
		
		if ( mysql_num_rows(mysql_query("SHOW TABLES LIKE '".$tabel_4."'")) == 1 )
		{
		$sql_ind = "select * from $tabel_4 where thang = '$th' and kdsatker = '$kdsatker_input' and tgspm <> '0000-00-00' "; 
		$data_ind = mysql_query($sql_ind);
		while( $rdata_ind = mysql_fetch_array($data_ind))
		{
			$thang		= $rdata_ind['thang'] ;
			$kdsatker	= $rdata_ind['kdsatker'] ;
			$nospm		= $rdata_ind['nospm'] ;
			$tgspm		= $rdata_ind['tgspm'] ;
			$kdakun		= $rdata_ind['kdakun'] ;
			$nilmak		= $rdata_ind['nilmak'] ;
			
			$sql_db = mysql_query("SELECT * FROM d_spmmak WHERE THANG = '$thang' AND KDSATKER = '$kdsatker' AND NOSPM = '$nospm' AND TGSPM = '$tgspm' ");
			$rsql_db = mysql_fetch_array($sql_db);	
			if ( empty($rsql_db) )
				{	
					$sql = "INSERT INTO d_spmmak(THANG,KDSATKER,NOSPM,TGSPM,KDAKUN,NILMAK)
									 VALUES ('$thang', '$kdsatker', '$nospm','$tgspm' , '$kdakun' , '$nilmak' )";
				}else{	
					$sql = "UPDATE d_spmmak SET kdakun = '$kdakun' , nilmak = '$nilmak'   
								   WHERE THANG = '$thang' AND KDSATKER = '$kdsatker' AND NOSPM = '$nospm' AND TGSPM = '$tgspm' ";
				}	
					mysql_query($sql);
		}	# AND WHILE
		}		# AND CEK FILE M_SPMMAK
			
				$_SESSION['errmsg'] = "Proses Refresh Data SPM Satker ".$kdsatker_input." berhasil"; ?>
<?php		}else{		# else pilih satker
			
				$_SESSION['errmsg'] = "Anda Belum memilih Satker"; 
			}         # AND CEK pilih satker  ?>

			<meta http-equiv="refresh" content="0;URL=index.php?p=<?php echo $p_next ?>"><?php
			exit();
		} # endif error
	} # endif form
?>

            <style type="text/css">
<!--
.style1 {color: #990000}
-->
            </style>
            <form action="" method="post" name="form" enctype="multipart/form-data">
	
  <table cellspacing="1" class="admintable">
    <tr> 
      <td width="144" class="key">Seting Tahun</td>
      <td width="311"><?php echo $th ?></td>
    </tr>
    
    <tr>
      <td class="key">Satker</td>
      <td><select name="kdsatker">
            <option value="">- Pilih Satker -</option>
		    <?php
		switch ($xlevel)
	{
		case '1':
			$query = mysql_query("select KDSATKER, left(NMSATKER,60) as namasatker from t_satker WHERE KDDEPT = '023' AND KDUNIT = '15' order by KDSATKER");
			break;
		case '4':
			$query = mysql_query("select KDSATKER, left(NMSATKER,60) as namasatker from t_satker WHERE KDSATKER = '$kdsatker' order by KDSATKER");
			break;	
		case '7':
			$query = mysql_query("select KDSATKER, left(NMSATKER,60) as namasatker from t_satker WHERE KDSATKER = '$kdsatker' order by KDSATKER");
			break;	
		default:
			$query = mysql_query("select KDSATKER, left(NMSATKER,60) as namasatker from t_satker WHERE KDDEPT = '023' AND KDUNIT = '15' order by KDSATKER");
			break;
	}	
			while($row = mysql_fetch_array($query)) { ?>
            <option value="<?php echo $row['KDSATKER'] ?>"><?php echo  $row['KDSATKER'].' '.$row['namasatker']; ?></option>
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
          <div class="prev"><a onclick="Back('index.php?p=<?php echo $p_next ?>')">Kembali</a></div>
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