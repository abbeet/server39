<?php
	checkauthentication();
	$table = "mst_rekening";
	$field = array("id","nip","bank","no_rek","penerima");
	$err = false;
	$p = $_GET['p'];
	$id_peg = $_REQUEST['id'];
	$pagess = $_REQUEST['pagess'];
	$cari = $_REQUEST['cari'];
	extract($_POST);
	$xusername_sess = $_SESSION['xusername'];
	$xlevel = $_SESSION['xlevel'];

	$sql_peg = "SELECT * FROM m_idpegawai WHERE id = '$id_peg'";
	$oList = mysql_query($sql_peg) ;
	$List  = mysql_fetch_array($oList) ;

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
				$id_peg = $_REQUEST['id_peg'];
				$sql_peg = "SELECT * FROM m_idpegawai WHERE id = '$id_peg'";
				$oList = mysql_query($sql_peg) ;
				$List  = mysql_fetch_array($oList) ;
				
				$value[1] = $List['nip'] ;
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
				$id_peg = $_REQUEST['id_peg'];
				$sql_peg = "SELECT * FROM m_idpegawai WHERE id = '$id_peg'";
				$oList = mysql_query($sql_peg) ;
				$List  = mysql_fetch_array($oList) ;
				
				$value[1] = $List['nip'] ;
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
<form action="index.php?p=<?php echo $_GET['p'] ?>&id_peg=<?php echo $id_peg ?>&q=<?php echo $q ?>&pagess=<?php echo $pagess ?>&kdunit=<?php echo $_REQUEST['kdunit'] ?>" method="post" name="form">
	<table width="675" cellspacing="1" class="admintable">
		
		<tr>
		  <td class="key">Nama Pegawai </td>
		  <td><input type="text" size="70" value="<?php echo $List['nama'] ?>" disabled="disabled"/></td>
	  </tr>
		<tr>
		  <td class="key">NIP</td>
		  <td><input type="text" size="35" value="<?php echo $List['nip'] ?>" disabled="disabled"/></td>
	  </tr>
		<tr>
		  <td width="125" class="key">Unit Kerja </td>
		  <td width="250">
					  <select disabled="disabled">
					  <option value="<?php echo $List['kdunitkerja'] ?>"><?php echo  nm_unitkerja($List['kdunitkerja']) ?></option>
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
		  <td class="key">&nbsp;</td>
		  <td>&nbsp;</td>
	  </tr>
		<tr>
		  <td class="key">Nama Bank </td>
		  <td>
          		<div id="nama_jabatan_view">
          		  <input type="text" name="<?php echo $field[2] ?>" size="70" value="<?php echo $value[2] ?>"/>
          		</div>             </td>
	  </tr>
		<tr>
			<td class="key">Nomor Rekening </td>
			<td><input type="text" name="<?php echo $field[3] ?>" size="30" value="<?php echo $value[3] ?>"/></td>
		</tr>
		
		<tr>
		  <td class="key">Penerima</td>
		  <td><input type="text" name="<?php echo $field[4] ?>" size="70" value="<?php echo $value[4] ?>"/></td>
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