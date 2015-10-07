<?php
	checkauthentication();
	$table = "mst_tk";
	$field = array("id","tahun","bulan","nip","kdunitkerja","kdjabatan","kdgol","kdstatuspeg","tmtjabatan","grade","tunker","pajak_tunker");
	$err = false;
	$p = $_GET['p'];
	$q = $_GET['q'];
	$pagess = $_REQUEST['pagess'];
	$kdbulan = $_REQUEST['kdbulan'];
	$sw = $_REQUEST['sw'];
	extract($_POST);
	$xlevel = $_SESSION['xlevel'];
	$xusername = $_SESSION['xusername'];
//	$xkdunit = $_SESSION['xkdunit'];
	$th = $_SESSION['xth'];;
	$xmenu_p = xmenu_id($p);
	$p_next = $xmenu_p->parent;
 	if ( $_REQUEST['kdunit'] <> '' )   $kdunit = $_REQUEST['kdunit'];
 	else   $kdunit = $_SESSION['xkdunit'];
	
	if (isset($form)) {		
		if ($err != true) {
			$lastmodified = now();
			$modifiedby = $xusername_sess;
			$id = $q;
			
			foreach ($field as $k=>$val) {
				$value[$k] = $$val;
			}
			
			if ($q == "") {
				//ADD NEW		
			} 
			else {
				$tahun = $value[1];
				$bulan = $value[2];
				$nip   = $value[3];
				$kdunitkerja   = $value[4];
				$kdjabatan     = $value[5];
				$tmtjabatan	  = $value[8];
				$kdgol = $value[6];
				$kdstatuspeg = $value[7];
				$grade = nil_grade($kdjabatan,$kdunitkerja);
				$gol = substr($kdgol,0,1) ;
				
				$sql_grade = "SELECT rp_grade FROM kd_grade WHERE kd_grade = '$grade'";
				$oGrade = mysql_query($sql_grade);
				$Grade  = mysql_fetch_array($oGrade);
				
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
				$sql = "UPDATE $table SET kdunitkerja = '$kdunitkerja' , kdjabatan = '$kdjabatan' , kdgol = '$kdgol' ,
						kdstatuspeg = '$kdstatuspeg' , kdgol = '$kdgol' , grade = '$grade' , tunker = '$tukin' , pajak_tunker = '$pajak_tukin'
						WHERE id = '$q'";
				//$sql = sql_update($table,$field,$value);
				$rs = mysql_query($sql);
				}
				
				if ($rs) {	
					update_log($sql,$table,1);
					$_SESSION['errmsg'] = "Ubah data berhasil!";
				}
				else {
					update_log($sql,$table,0);
					$_SESSION['errmsg'] = "Ubah data gagal!";			
				} ?>
				
				<meta http-equiv="refresh" content="0;URL=index.php?p=<?php echo $p_next ?>&pagess=<?php echo $pagess ?>
				&kdbulan=<?php echo $kdbulan ?>&kdunit=<?php echo $kdunit ?>"><?php
				exit();
			//}
		}
		else {?>
			<meta http-equiv="refresh" content="0;URL=index.php?p=<?php echo $p_next ?>&pagess=<?php echo $pagess ?>
			&kdbulan=<?php echo $kdbulan ?>&kdunit=<?php echo $kdunit ?>"><?php		
		}
	} 
	else if (isset($_GET["q"])) {
		$value = get_value($table,$field,"id='".$_GET['q']."'");
	}
	else {
		$value = "";
	} ?>

<script>	
	function numberFormat(nStr){
  // change format first
  nStr = nStr.replace(/\./g,'');
  nStr = nStr.replace(/,/g,'.');
  // process
  nStr += '';
  x = nStr.split('.');
  x1 = x[0];
  x2 = x.length > 1 ? '.' + x[1] : '';
  var rgx = /(\d+)(\d{3})/;
  while (rgx.test(x1))
    x1 = x1.replace(rgx, '$1' + ',' + '$2');
  var result = x1 + x2;
  // change again
  result = result.replace(/,/g,';');
  result = result.replace(/\./g,',');
  result = result.replace(/;/g,'.');
  return result;
}
</script>
<script language="javascript" src="js/skp_combo.js"></script>
<form action="index.php?p=<?php echo $_GET['p'] ?>&pagess=<?php echo $pagess ?>
&kdbulan=<?php echo $kdbulan ?>&kdunit=<?php echo $kdunit ?>&q=<?php echo $q ?>" method="post" name="form">
	<table width="692" cellspacing="1" class="admintable">
		
		<tr>
		  <td width="158" class="key">Gaji Bulan </td>
		  <td width="525"><input type="text" name="<?php echo $field[2] ?>" size="5" value="<?php echo $value[2] ?>" disabled="disabled"/>&nbsp;<font color="#CC3333">[01,02,..dst]</font>&nbsp;&nbsp;Tahun&nbsp;<input type="text" name="<?php echo $field[1] ?>" size="10" value="<?php echo $value[1] ?>" disabled="disabled"/></td>
	  </tr>
		
		<tr>
		  <td class="key">Nama Pegawai</td>
		  <td>
		  <select name="<?php echo $field[3] ?>" disabled="disabled">
                      <option value="<?php echo $value[3] ?>"><?php echo  '['.$value[3].'] '.nama_peg($value[3]) ?></option>
                      <option value="">- Pilih Nama Pegawai -</option>
                    <?php
						$kdunitkerja = substr($kdunit,0,5) ;
						$query = mysql_query("select nip,nama from m_idpegawai where kdunitkerja LIKE '$kdunitkerja%' order by nama");
						while($row = mysql_fetch_array($query)) { ?>
                      <option value="<?php echo $row['nip'] ?>"><?php echo  '['.$row['nip'].'] '.$row['nama']; ?></option>
                    <?php
						} ?>
                  </select>		  </td>
	  </tr>
		<tr>
		  <td class="key">Unit Kerja </td>
		  <td><select name="<?php echo $field[4] ?>" onchange="get_info_jabatan(this.value)">
            <option value="<?php echo $value[4] ?>"><?php echo  '['.$value[4].'] '.nm_unitkerja($value[4]) ?></option>
            <option value="">- Pilih Unit Kerja -</option>
            <?php
					 		$kdunitkerja = substr($kdunit,0,5) ;		
							$query = mysql_query("select kdunit,nmunit from kd_unitkerja where kdunit LIKE '$kdunitkerja%' order by kdunit");
					
						while($row = mysql_fetch_array($query)) { ?>
            <option value="<?php echo $row['kdunit'] ?>"><?php echo  '['.$row['kdunit'].'] '.$row['nmunit']; ?></option>
            <?php
						} ?>
          </select></td>
	  </tr>
		<tr>
		  <td class="key">Jabatan</td>
		  <td><div id="info_jabatan_view"><select name="<?php echo $field[5] ?>">
					  <option value="<?php echo $value[5] ?>"><?php echo  nm_jabatan_ij($value[5],$value[4]) ?></option>
                      <option value="">- Pilih Nama Jabatan -</option>
                    <?php
						$kdunitkerja = $value[4] ;
						$query = mysql_query("select * from mst_info_jabatan where kdunitkerja = '$kdunitkerja' order by kdjabatan,grade");
						
						while($row = mysql_fetch_array($query)) { ?>
                        <option value="<?php echo $row['kdjabatan'] ?>"><?php echo  $row['kdjabatan'].' - '.nm_jabatan_ij($row['kdjabatan'],$kdunitkerja).' [ Grade'.$row['grade'].' ] '; ?></option>
                    <?php
						} ?>
                  	</select>
                   </div>                  </td>
	  </tr>
		<tr>
		  <td class="key">TMT Jabatan </td>
		  <td><input name="<?php echo $field[8] ?>" type="text" class="form" id="<?php echo $field[8] ?>" size="10" value="<?php echo $value[8] ?>"/>
                    &nbsp;<img src="css/images/calbtn.gif" id="a_triggerIMG" hspace="5" title="Pilih Tanggal"/>
                    <script type="text/javascript">
				Calendar.setup({
					inputField		: "<?php echo $field[8] ?>",
					button			: "a_triggerIMG",
					align			: "BR",
					firstDay		: 1,
					weekNumbers		: false,
					singleClick		: true,
					showOthers		: true,
					ifFormat 		: "%Y-%m-%d"
				});
			</script></td>
	  </tr>
		
		
		<tr>
		  <td class="key">Golongan</td>
		  <td><select name="<?php echo $field[6] ?>">
					  <option value="<?php echo $value[4] ?>"><?php echo  nm_gol($value[6]) ?></option>
                      <option value="">- Pilih Golongan -</option>
                    <?php
						
						$query = mysql_query("select * from kd_gol order by KdGol desc");
						
						while($row = mysql_fetch_array($query)) { ?>
                        <option value="<?php echo $row['KdGol'] ?>"><?php echo  $row['NmGol']; ?></option>
                    <?php
						} ?>
                  	</select></td>
	  </tr>
		<tr>
		  <td class="key">Status Pegawai</td>
		  <td>
		  <input name="<?php echo $field[7] ?>" type="radio" value="1" <?php if( $value[7] == '1' ) echo 'checked="checked"' ?>/> 
        &nbsp;&nbsp;PNS&nbsp;&nbsp;
	  	  <input name="<?php echo $field[7] ?>" type="radio" value="2" <?php if( $value[7] == '2' ) echo 'checked="checked"' ?>/> 
        &nbsp;&nbsp;CPNS&nbsp;&nbsp;		  </td>
	  </tr>
		<tr>
			<td>&nbsp;</td>
			<td>			
				<div class="button2-right">
					<div class="prev">
						<a onclick="Cancel('index.php?p=<?php echo $p_next ?>&pagess=<?php echo $pagess ?>
						&kdbulan=<?php echo $kdbulan ?>&kdunit=<?php echo $kdunit ?>')">Batal</a>					</div>
				</div>
				<div class="button2-left">
					<div class="next">
						<a onclick="form.submit();">Simpan</a>					</div>
				</div>
				<div class="clr"></div>
				<input style="border: 0pt none ; margin: 0pt; padding: 0pt; width: 0px; height: 0px;" value="Simpan" type="submit">
				<input name="form" type="hidden" value="1" />
				<input name="q" type="hidden" value="<?php echo $_GET['q'] ?>" />			</td>
		</tr>
  </table>
</form>