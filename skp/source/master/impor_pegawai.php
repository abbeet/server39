<?php
	checkauthentication();
	$err = false;
	$p = $_GET['p'];
	extract($_POST);
	$xkdunit = $_SESSION['xkdunit'];

	$xmenu_p = xmenu_id($p);
	$p_next = $xmenu_p->parent;
	
	if (isset($form)) 
	{		
		if ($err != true) 
		{
		// Baca SIK
					@mysql_select_db("dbpak");
					$oList = mysql_query("SELECT Nib,Nip,NamaLengkap,KdGol,TMTGol,KdUnitKerja,KdStatusPeg, KdJnsSKFung, KdEselon, TMTEselon, TMTUnit, KdKelJabatan, KdFungsional FROM m_idpegawai WHERE left(KdUnitKerja,2) = '$xkdunit'");
					while( $List = mysql_fetch_array($oList) )
					{
						$col[0][] = $List['Nib'];
						$col[1][] = $List['Nip'];
						$col[2][] = $List['NamaLengkap'];
						$col[3][] = $List['KdGol'];
						$col[4][] = $List['TMTGol'];
						$col[5][] = $List['KdUnitKerja'];
						$col[6][] = $List['KdStatusPeg'];
						$col[7][] = $List['KdJnsSKFung'];
						$col[8][] = $List['KdEselon'];
						$col[9][] = $List['TMTEselon'];
						$col[10][] = $List['TMTUnit'];
						$col[11][] = $List['KdKelJabatan'];
						$col[12][] = $List['KdFungsional'];
					}
					@mysql_select_db("dbskp_batan");
					foreach ($col[0] as $k=>$val) {
						$nib 		= $col[0][$k] ;
						$nip 		= $col[1][$k] ;
						$nama 		= $col[2][$k] ;
						$kdgol		= $col[3][$k] ;
						$tmtgol 	= $col[4][$k] ;
						$kdunitkerja = $col[5][$k] ;
						$kdstatuspeg = $col[6][$k] ;
						$kdjnsskfung = $col[7][$k] ;
						$kdeselon 	 = $col[8][$k] ;
						$tmteselon	 = $col[9][$k] ;
						$tmtunit	 = $col[10][$k] ;
						$kdkeljabatan = $col[11][$k] ;
						$kdfungsional = $col[12][$k] ;
						$oList_skp = mysql_query("SELECT Nib FROM m_idpegawai WHERE Nib = '$nib' ");
						$List_skp = mysql_fetch_array($oList_skp) ;
						if ( !empty($List_skp) )
						{
							mysql_query("UPDATE m_idpegawai SET Nip = '$nip', NamaLengkap = '$nama', KdGol = '$kdgol',
									 	TMTGol = '$tmtgol', KdUnitKerja = '$kdunitkerja', KdStatusPeg = '$kdstatuspeg',
										KdJnsSKFung = '$kdjnsskfung', KdEselon = '$kdeselon', TMTEselon = '$tmteselon',
										 TMTUnit = '$tmtunit', KdKelJabatan = '$kdkeljabatan', KdFungsional = '$kdfungsional' 
										 WHERE Nib = '$nib' ");
						}else{
							mysql_query("INSERT INTO m_idpegawai(Nib,Nip,NamaLengkap, KdGol, TMTGol, KdUnitKerja, KdStatusPeg,
										KdJnsSKFung, KdEselon, TMTEselon, TMTUnit, KdKelJabatan, KdFungsional) 
										VALUES('$nib','$nip','$nama', '$kdgol', '$tmtgol', '$kdunitkerja', '$kdstatuspeg',
										'$kdjnsskfung', '$kdeselon', '$tmteselon', '$tmtunit', '$kdkeljabatan', '$kdfungsional')");
						}
					}
					$_SESSION['errmsg'] = "Proses impor berhasil!";
			?>
				<meta http-equiv="refresh" content="0;URL=index.php?p=<?php echo $p_next ?>"><?php
				exit();
		}
	} ?>

<script type="text/javascript">
	function form_submit()
	{
		document.forms['form'].submit();
	}
</script>
<form action="index.php?p=<?php echo $_GET['p'] ?>" method="post" name="form">
	
  <table width="721" cellspacing="1" class="admintable">
    <tr>
      <td colspan="2" align="left">Anda yakin akan Impor Data Pegawai</td>
    </tr>
    
    <tr> 
      <td width="131">&nbsp;</td>
      <td width="581"> <div class="button2-right"> 
          <div class="prev"> <a onclick="Cancel('index.php?p=<?php echo $p_next ?>')">Batal</a>          </div>
        </div>
        <div class="button2-left"> 
          <div class="next"> <a onclick="form_submit();">Proses</a> </div>
        </div>
        <div class="clr"></div>
        <input style="border: 0pt none ; margin: 0pt; padding: 0pt; width: 0px; height: 0px;" value="Simpan" type="submit"> 
        <input name="form" type="hidden" value="1" /> </td>
    </tr>
  </table>
</form>
