<?php
	checkauthentication();
	$table = "m_idpegawai";
	$field = array("id","nip","nama","kdunitkerja","kdgol","kdeselon","kdjabatan","kdstatuspeg","tmtjabatan");
	$err = false;
	$p = $_GET['p'];
	$pagess = $_REQUEST['pagess'];
	$cari = $_REQUEST['cari'];
	extract($_POST);
	$xusername_sess = $_SESSION['xusername'];
	$xlevel = $_SESSION['xlevel'];

	if ( $_REQUEST['kdunit'] <> '' )    $kdunit = $_REQUEST['kdunit'] ;
	else    $kdunit = $_SESSION['xkdunit'] ;

	$xmenu_p = xmenu_id($p);
	$p_next = $xmenu_p->parent;
	
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
				$xkdunit = substr($value[3],0,4) ;
				$sql = sql_insert($table,$field,$value);
				$rs = mysql_query($sql);
				
				if ($rs) {
					update_log($sql,$table,1);
					$_SESSION['errmsg'] = "Input data berhasil!";
				}
				else {
					update_log($sql,$table,0);
					$_SESSION['errmsg'] = "Input data gagal!";
				} ?>
				
				<meta http-equiv="refresh" content="0;URL=index.php?p=<?php echo $p_next ?>&pagess=<?php echo $pagess ?>&kdunit=<?php echo $_REQUEST['kdunit'] ?>"><?php			   
				exit();
			} 
			else {
				// UPDATE
				$sql = sql_update($table,$field,$value);
				$rs = mysql_query($sql);
				
				if ($rs) {	
					update_log($sql,$table,1);
					$_SESSION['errmsg'] = "Ubah data berhasil!";
				}
				else {
					update_log($sql,$table,0);
					$_SESSION['errmsg'] = "Ubah data gagal!";			
				} 
				?>
				
				<meta http-equiv="refresh" content="0;URL=index.php?p=<?php echo $p_next ?>&pagess=<?php echo $pagess ?>&kdunit=<?php echo $_REQUEST['kdunit'] ?>"><?php				   
				exit();
			}
		}
		else {?>
				<meta http-equiv="refresh" content="0;URL=index.php?p=<?php echo $p_next ?>&pagess=<?php echo $pagess ?>&kdunit=<?php echo $_REQUEST['kdunit'] ?>"><?php				   
		}
	} 
	else if (isset($_GET["q"])) {
		$value = get_value($table,$field,"id='".$_GET['q']."'");
	}
	else {
		$value = "";
	} ?>

<script type="text/javascript">
	function form_submit()
	{
		document.forms['form'].submit();
	}
</script>
<script language="javascript" src="js/skp_combo.js"></script>
<form action="index.php?p=<?php echo $_GET['p'] ?>&pagess=<?php echo $pagess ?>&kdunit=<?php echo $_REQUEST['kdunit'] ?>" method="post" name="form">
	<table width="675" cellspacing="1" class="admintable">
		
		<tr>
		  <td class="key">Nama Pegawai </td>
		  <td><input type="text" name="<?php echo $field[2] ?>" size="70" value="<?php echo $value[2] ?>"/></td>
	  </tr>
		<tr>
		  <td class="key">NIP</td>
		  <td><input type="text" name="<?php echo $field[1] ?>" size="35" value="<?php echo $value[1] ?>"/></td>
	  </tr>
		<tr>
		  <td width="125" class="key">Unit Kerja </td>
		  <td width="250">
					  <select name="<?php echo $field[3] ?>" onchange="get_info_jabatan(this.value)">
					  <option value="<?php echo $value[3] ?>"><?php echo  nm_unitkerja($value[3]) ?></option>
                      <option value="">- Pilih Unit Kerja -</option>
                    <?php
					if ( $xlevel == 1 or $xlevel == 2 )
					{
						$query = mysql_query("select * from kd_unitkerja where left(nmunit,5) <> 'DINAS' order by kdunit");
					}else{
						$kode = substr($kdunit,0,5) ;
						$query = mysql_query("select * from kd_unitkerja where kdunit LIKE '$kode%' order by kdunit");
					}
						while($row = mysql_fetch_array($query)) { ?>
                        <option value="<?php echo $row['kdunit'] ?>"><?php echo  $row['nmunit']; ?></option>
                    <?php
						} ?>
                  	</select>		   </td>
	  </tr>
		<tr>
		  <td class="key">Jabatan</td>
		  <td>
          		<div id="info_jabatan_view">
          		<select name="<?php echo $field[6] ?>">
					  <option value="<?php echo $value[6] ?>"><?php echo  nm_jabatan_ij($value[6],$value[3]) ?></option>
                      <option value="">- Pilih Nama Jabatan -</option>
                    <?php
						$kdunitkerja = $value[3] ;
						$query = mysql_query("select * from mst_info_jabatan where kdunitkerja = '$kdunitkerja' order by kdjabatan,grade");
						
						while($row = mysql_fetch_array($query)) { ?>
                        <option value="<?php echo $row['kdjabatan'] ?>"><?php echo  $row['kdjabatan'].' - '.nm_jabatan_ij($row['kdjabatan'],$kdunitkerja).' [ Grade'.$row['grade'].' ] '; ?></option>
                    <?php
						} ?>
                  	</select>
                   </div>             </td>
	  </tr>
		<tr>
			<td class="key">Eselon</td>
			<td>
			<select name="<?php echo $field[5] ?>">
					  <option value="<?php echo $value[5] ?>"><?php echo  nm_eselon($value[5]) ?></option>
                      <option value="">- Pilih Eselon -</option>
                    <?php
						
						$query = mysql_query("select * from kd_eselon order by Kdeselon");
						
						while($row = mysql_fetch_array($query)) { ?>
                        <option value="<?php echo $row['Kdeselon'] ?>"><?php echo  $row['Nmeselon']; ?></option>
                    <?php
						} ?>
           	  </select>			</td>
		</tr>
		<tr>
		  <td class="key">TMT Jabatan</td>
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
		  <td><select name="<?php echo $field[4] ?>">
					  <option value="<?php echo $value[4] ?>"><?php echo  nm_gol($value[4]) ?></option>
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
		  <td class="key">Status Kepegawaian </td>
		  <td>
		  <input name="<?php echo $field[7] ?>" type="radio" value="1" <?php if( $value[7] == '1' ) echo 'checked="checked"' ?>/> 
        &nbsp;&nbsp;PNS&nbsp;&nbsp;
	  	  <input name="<?php echo $field[7] ?>" type="radio" value="2" <?php if( $value[7] == '2' ) echo 'checked="checked"' ?>/> 
        &nbsp;&nbsp;CPNS&nbsp;&nbsp;
		  </td>
	  </tr>
		
		<tr>
			<td>&nbsp;</td>
			<td>			
				<div class="button2-right">
					<div class="prev">
						<a onclick="Cancel('index.php?p=<?php echo $p_next ?>&pagess=<?php echo $pagess ?>&kdunit=<?php echo $_REQUEST['kdunit'] ?>')">Kembali</a>					</div>
				</div>
				<div class="button2-left">
					<div class="next">
						<a onclick="form_submit();">Simpan</a>					</div>
				</div>
				<div class="clr"></div>
				<input style="border: 0pt none ; margin: 0pt; padding: 0pt; width: 0px; height: 0px;" value="Simpan" type="submit">
				<input name="form" type="hidden" value="1" />
				<input name="q" type="hidden" value="<?php echo $_GET['q'] ?>" />			</td>
		</tr>
  </table>
</form>