<?php
	checkauthentication();
	$table = "mst_tk";
	$field = get_field($table);
	$err = false;
	$p = $_GET['p'];
	extract($_POST);
	$xusername_sess = $_SESSION['xusername'];
	$xusername = $_SESSION['xusername'];
	$kdunit = $_SESSION['xkdunit'] ;
	$xmenu_p = xmenu_id($p);
	$p_next = $xmenu_p->parent;
		
	if (isset($form)) 
	{		
		if ($err != true) 
		{
			$tahun_proses = $_REQUEST['tahun_proses'];
			$bulan_proses = bulan_data($_REQUEST['bulan_proses']);
			$kdunit = $_REQUEST['kdunit'];
			//------ cek status verifikasi
			$sql_status = "SELECT * FROM proses_verifikasi WHERE kdunitkerja = '$kdunit' 
							   AND tahun = '$tahun_proses' and bulan = '$bulan_proses'";
			$oList_status = mysql_query($sql_status) ;
			$List_status = mysql_fetch_array($oList_status) ;
			
			if ( $List_status['status_verifikasi_nominatif'] == '1' )
			{
					$_SESSION['errmsg'] = "Data Nominatif telah diverifikasi !"; ?>
					<meta http-equiv="refresh" content="0;URL=index.php?p=<?php echo $p_next ?>&kdbulan=<?php echo $bulan_proses ?>"><?php
					exit() ;
			}else{
				if ( empty($List_status) )
				{
					mysql_query("INSERT INTO proses_verifikasi(tahun,bulan,kdunitkerja,status_verifikasi_nominatif,
								tanggal_verifikasi_nominatif)
								VALUE ( '$tahun_proses' , '$bulan_proses' , '$kdunit' , '0' , '$tgl_status' )" );
				}else{
					mysql_query("UPDATE proses_verifikasi SET status_verifikasi_nominatif = '0' ,
								tanggal_verifikasi_nominatif = '$tgl_status' WHERE id = '$id_status' ") ;
				}
			}
			
			$id_status = $List_status['id'] ;
			$tgl_status = date("Y-m-d");	
			//--------------	
			#hapus dulu datanya
			$xkdunit = substr($kdunit,0,5) ;
			
			if ( $kdunit == '2320100' )
			{
				$sql = "DELETE FROM mst_tk WHERE tahun = '$tahun_proses' and bulan = '$bulan_proses' and ( kdunitkerja LIKE '$xkdunit%'
						OR kdunitkerja = '2320000' )";
			}else{
				$sql = "DELETE FROM mst_tk WHERE tahun = '$tahun_proses' and bulan = '$bulan_proses' and kdunitkerja LIKE '$xkdunit%'";
			}
			mysql_query($sql);
			
			if ( $kdunit == '2320100' )
			{
				$sql = "SELECT * FROM m_idpegawai WHERE kdunitkerja LIKE '$xkdunit%' OR kdunitkerja = '2320000'";	
			}else{
				$sql = "SELECT * FROM m_idpegawai WHERE kdunitkerja LIKE '$xkdunit%'";	
			}
				
			$qu  = mysql_query($sql);		
			while ($row = mysql_fetch_array($qu))
			{								
				$grade = nil_grade($row['kdjabatan'],$row['kdunitkerja']);
				
				$sql_grade = "SELECT rp_grade FROM kd_grade WHERE kd_grade = '$grade'";
				$oGrade = mysql_query($sql_grade);
				$Grade  = mysql_fetch_array($oGrade);
				$kdstatuspeg = $row['kdstatuspeg'];
				$gol = substr( $row['kdgol'] , 0 , 1 ) ;
				
				if ( $kdstatuspeg == '1' )    $tukin = $Grade['rp_grade'];
				else  $tukin = $Grade['rp_grade'] * 0.8;
				
				if ( $gol == 3 )
				{
				    $pajak_tukin = 0.05 * $tukin ;
				}elseif ( $gol == 4 ) 
				{
				   $pajak_tukin = 0.15 * $tukin ;
				}else{
				   $pajak_tukin = 0 ;
				}
				
				$sql = "INSERT INTO mst_tk(id,tahun,bulan,nip,kdunitkerja,kdgol,kdjabatan,tmtjabatan,grade,kdstatuspeg,tunker,pajak_tunker)
						VALUES ('','".$tahun_proses."','".$bulan_proses."','".$row['nip']."','".$row['kdunitkerja']."','".$row['kdgol']."','".$row['kdjabatan']."','".$row['tmtjabatan']."','".$grade."','".$row['kdstatuspeg']."','".$tukin."','".$pajak_tukin."')";# echo $sql.";<br>";
					mysql_query($sql);
				
				
				
				//-------
			} ?>
			
			<meta http-equiv="refresh" content="0;URL=index.php?p=<?php echo $p_next ?>&kdbulan=<?php echo $bulan_proses ?>"><?php
		}
	} ?>

<form action="index.php?p=<?php echo $_GET['p'] ?>" method="post" name="form">
	
  <table width="721" cellspacing="1" class="admintable">
    <tr>
      <td colspan="2"><strong>Buat Konsep Tunjangan Kinerja </strong><br />
	  <font color="#FF0000">[ Data Copy dari Pemegang Jabatan saat ini ]</font></td>
    </tr>
    <tr>
      <td width="131" align="right"><strong>Satker</strong></td>
      <td width="581">
		<select name="kdunit">
                      <option value="<?php echo $kdunit ?>"><?php echo  nm_unitkerja($kdunit) ?></option>
                      <option value="">- Pilih Unit Kerja -</option>
                    <?php
					if ( $xlevel == '1' )
					{
						$query = mysql_query("select * from kd_unitkerja WHERE kdsatker <> '' and left(nmunit,5) <> 'DINAS' order by kdunit");
					}else{
						$query = mysql_query("select * from kd_unitkerja WHERE kdunit = '$kdunit' order by kdunit");
					}
						while($row = mysql_fetch_array($query)) { ?>
                      <option value="<?php echo $row['kdunit'] ?>"><?php echo  $row['nmunit']; ?></option>
                    <?php
					} ?>	
	    </select>	 </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    
    <tr>
      <td class="key">Bulan</td>
      <td><select name="bulan_proses">
          <?php
					for ($i = 1; $i <= 13; $i++)
					{ ?>
          <option value="<?php echo $i; ?>" <?php if ($i == ( date ("m") - 1 ) ) echo "selected"; ?>><?php echo nama_bulan($i) ; ?></option>
          <?php
					} ?>
        </select>&nbsp;
		<select name="tahun_proses">
          <?php
					for ($i = date("Y")-5; $i <= date("Y")+5; $i++)
					{ ?>
          <option value="<?php echo $i; ?>" <?php if ($i == date ("Y") ) echo "selected"; ?>><?php echo $i ; ?></option>
          <?php
					} ?>
        </select>		</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
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
