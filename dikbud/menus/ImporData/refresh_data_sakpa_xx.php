<?php
	checkauthentication();
	$err = false;

	extract($_POST);
	$xmenu_p = xmenu_id($p);
	$p_next = $xmenu_p->parent;
	$th = $_SESSION['xth'];

	if (isset($form)) 
	{		
		if ($err != true) 
		{
		
			$kdsatker_input = $_REQUEST['kdsatker'];
						
			if( $kdsatker_input <> '' ) {

			$conn = new COM("ADODB.Connection");
			$dirData = "c:\\xampp\\htdocs\\sireva\\file_dipa\\".$kdsatker_input."\\";
			$conn->Open("Provider=vfpoledb.1;Data Source=$dirData;Collating Sequence=Machine");
			$Data= $conn->Execute("select THANG,KDSATKER,sum(TOTNILMAK) AS jml from M_SPMIND.DBF group by THANG,KDSATKER");	
			$th_file	= $Data->Fields(0);
			$kdsatker_data	= $Data->Fields(1);
			$jumlah		= $Data->Fields(2);
/*	 
       echo "<strong> Tersambung SAKPA Tahun ".$th." Satker ".$kdsatker_data." </strong></<br>";
        echo "<strong> Jumlah Realisasi ".$jumlah." </strong></<br>";

				if ($kdsatker_input <> $kdsatker_data ){
				
					$_SESSION['errmsg'] = "Pilihan Satker berbeda dengan Data yang tersedia"; ?>

					<meta http-equiv="refresh" content="0;URL=index.php?p=<?php echo $p_next ?>"><?php
					exit();
				
				}	# END CEK FOLDER DAN DATA
*/
			if ($_REQUEST['spmind'] == "1")
			{
				
				mysql_query("DELETE FROM m_spmind WHERE THANG = '".$th."' AND KDSATKER = '".$kdsatker_input."'");
				$Spmind = $conn->Execute( "select THANG,KDSATKER,KDDEPT,KDUNIT,KDPROGRAM,KDGIAT,KDOUTPUT,TOTNILMAK,TOTNILMAP,NOSPM,Tgspm,NOSP2D,Tgsp2d from M_SPMIND.DBF where THANG='$th' and KDSATKER='$kdsatker_input' ");	
				while (!$Spmind->EOF) {
					$THANG		= $Spmind->Fields(0);
					$KDSATKER	= $Spmind->Fields(1);
					$KDDEPT		= $Spmind->Fields(2);
					$KDUNIT		= $Spmind->Fields(3);
					$KDPROGRAM	= $Spmind->Fields(4);
					$KDGIAT		= $Spmind->Fields(5);
					$KDOUTPUT	= $Spmind->Fields(6);
					$TOTNILMAK	= $Spmind->Fields(7);
					$TOTNILMAP	= $Spmind->Fields(8);
					$NOSPM		= $Spmind->Fields(9);
					$TGSPM		= $Spmind->Fields(10);
					$NOSP2D		= $Spmind->Fields(11);
					$TGSP2D		= $Spmind->Fields(12);
					
					list( $bl_spm , $tg_spm , $th_spm ) = explode ( "/", $TGSPM );
					if ( strlen( $bl_spm ) == 1 )    $bl_spm = '0'.$bl_spm ;
					if ( strlen( $tg_spm ) == 1 )    $tg_spm = '0'.$tg_spm ;

					list( $bl_sp2d , $tg_sp2d , $th_sp2d ) = explode ( "/", $TGSP2D );
					if ( strlen( $bl_sp2d ) == 1 )    $bl_sp2d = '0'.$bl_sp2d ;
					if ( strlen( $tg_sp2d ) == 1 )    $tg_sp2d = '0'.$tg_sp2d ;

					$tg_spm = $th_spm.'-'.$bl_spm.'-'.$tg_spm;
					$tg_sp2d = $th_sp2d.'-'.$bl_sp2d.'-'.$tg_sp2d;
					
					$sql = "INSERT INTO m_spmind(THANG,KDSATKER,KDDEPT,KDUNIT,KDPROGRAM,KDGIAT,KDOUTPUT,TOTNILMAK,TOTNILMAP,NOSPM,TGSPM,NOSP2D,TGSP2D) VALUES ('$THANG', '$KDSATKER', '$KDDEPT', '$KDUNIT', '$KDPROGRAM', '$KDGIAT', '$KDOUTPUT', '$TOTNILMAK', '$TOTNILMAP', '$NOSPM', '$tg_spm', '$NOSP2D', '$tg_sp2d')";
//					$sql = "INSERT INTO m_spmind(THANG,KDSATKER,KDDEPT,KDUNIT,KDPROGRAM,KDGIAT,KDOUTPUT,TOTNILMAK,TOTNILMAP,NOSPM,TGSPM,NOSP2D,TGSP2D) VALUES ('$THANG', '$KDSATKER', '$KDDEPT', '$KDUNIT', '$KDPROGRAM', '$KDGIAT', '$KDOUTPUT', '$TOTNILMAK', '$TOTNILMAP', '$NOSPM', '$TGSPM', '$NOSP2D', '$TGSP2D')";
					mysql_query($sql);
    				$Spmind->MoveNext();
				}	# AND WHILE
				$Spmind->Close();
			}		# AND CEK FILE SPMMAK
				
			if ($_REQUEST['spmmak'] == "1")
			{
								
				mysql_query("DELETE FROM m_spmmak WHERE THANG = '".$th."' AND KDSATKER = '".$kdsatker_input."'");
				$Spmmak = $conn->Execute("select THANG,KDSATKER,KDAKUN,NILMAK,NOSPM,TGSPM,NOSP2D,TGSP2D from M_SPMMAK.DBF where THANG = '$th' and KDSATKER = '$kdsatker_input' ");	
				while (!$Spmmak->EOF) {
					$THANG		= $Spmmak->Fields(0);
					$KDSATKER	= $Spmmak->Fields(1);
					$KDAKUN		= $Spmmak->Fields(2);
					$NILMAK		= $Spmmak->Fields(3);
					$NOSPM		= $Spmmak->Fields(4);
					$TGSPM		= $Spmmak->Fields(5);
					$NOSP2D		= $Spmmak->Fields(6);
					$TGSP2D		= $Spmmak->Fields(7);
					
					list( $bl_spm , $tg_spm , $th_spm ) = explode ( "/", $TGSPM );
					if ( strlen( $bl_spm ) == 1 )    $bl_spm = '0'.$bl_spm ;
					if ( strlen( $tg_spm ) == 1 )    $tg_spm = '0'.$tg_spm ;

					list( $bl_sp2d , $tg_sp2d , $th_sp2d ) = explode ( "/", $TGSP2D );
					if ( strlen( $bl_sp2d ) == 1 )    $bl_sp2d = '0'.$bl_sp2d ;
					if ( strlen( $tg_sp2d ) == 1 )    $tg_sp2d = '0'.$tg_sp2d ;

					$tg_spm = $th_spm.'-'.$bl_spm.'-'.$tg_spm;
					$tg_sp2d = $th_sp2d.'-'.$bl_sp2d.'-'.$tg_sp2d;
                   
					$sql = "INSERT INTO m_spmmak(THANG,KDSATKER,KDAKUN,NILMAK,NOSPM,TGSPM,NOSP2D,TGSP2D) VALUES ('$THANG', '$KDSATKER', '$KDAKUN', '$NILMAK', '$NOSPM', '$tg_spm', '$NOSP2D', '$tg_sp2d')";
					mysql_query($sql);
    				$Spmmak->MoveNext();
				}	# AND WHILE
				$Spmmak->Close();
			}		# AND CEK FILE SPMMAK
			
			$_SESSION['errmsg'] = "Proses Refresh Data SAKPA Satker ".$kdsatker." berhasil"; ?>

					<meta http-equiv="refresh" content="0;URL=index.php?p=<?php echo $p_next ?>"><?php
					exit();

			}		# AND CEK SATKER
			
			$_SESSION['errmsg'] = "Anda Belum memilih Satker"; ?>

					<meta http-equiv="refresh" content="0;URL=index.php?p=<?php echo $p_next ?>"><?php
					exit();

		}
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
      <td width="144" class="key">Seting Tahun</td>
      <td width="311"><?php echo $th ?></td>
    </tr>
    <tr>
	  <td width="144" class="key">Data SAKPA Tahun</td>
      <td><?php echo $th_file ?></td>
    </tr>
    <tr>
      <td class="key">Satker</td>
      <td><select name="kdsatker">
            <option value="">- Pilih Satker -</option>
		    <?php
			$query = mysql_query("select KDSATKER, left(NMSATKER,60) as namasatker from t_satker order by KDSATKER");
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
      <td class="key">Data Realisasi Total</td>
      <td> &nbsp; <input type="checkbox" name="spmind" value="1" checked> <span class="style1">[ 
        File : M_SPMIND]</span> </td>
    </tr>
    <tr> 
      <td class="key">Data Realisasi Detil</td>
      <td> &nbsp;<span class="style1"> 
        <input type="checkbox" name="spmmak" value="1" checked>
        [ File : M_SPMMAK]</span> </td>
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