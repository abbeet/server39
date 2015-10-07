<?php
	checkauthentication();
	$table = "mst_info_jabatan";
	$field = array("id","kdunitkerja","kdjabatan","jumlah","grade");
	$err = false;
	$p = $_GET['p'];
	$pagess = $_REQUEST['pagess'];
	$cari = $_REQUEST['cari'];
	extract($_POST);
	$xusername_sess = $_SESSION['xusername'];
	$xlevel = $_SESSION['xlevel'];
	$xmenu_p = xmenu_id($p);
	$p_next = $xmenu_p->parent;
	
	if ( $_REQUEST['kdunit'] <> '' )    $kdunit = $_REQUEST['kdunit'] ;
	else    $kdunit = $_SESSION['xkdunit'] ;
	
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
				//$kdunit = substr($value[1],0,5) ;
				$value[4] = nil_grade($value[2]) ;
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
				
				<meta http-equiv="refresh" content="0;URL=index.php?p=<?php echo $p_next ?>&pagess=<?php echo $pagess ?>&kdunit=<?php echo $kdunit ?>"><?php			   
				exit();
			} 
			else {
				// UPDATE
				$value[4] = nil_grade($value[2]) ;
				$sql = sql_update($table,$field,$value);
				$rs = mysql_query($sql);
				
				if ($rs) {	
					update_log($sql,$table,1);
					$_SESSION['errmsg'] = "Ubah data berhasil!";
				}
				else {
					update_log($sql,$table,0);
					$_SESSION['errmsg'] = "Ubah data gagal!";			
				} ?>
				
				<meta http-equiv="refresh" content="0;URL=index.php?p=<?php echo $p_next ?>&pagess=<?php echo $pagess ?>&kdunit=<?php echo $_REQUEST['kdunit'] ?>"><?php				   
				exit();
			}
		}
		else {?>
				<meta http-equiv="refresh" content="0;URL=index.php?p=<?php echo $p_next ?>&pagess=<?php echo $pagess ?>&kdunit=<?php echo $kdunit ?>"><?php				   
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
	<table width="742" cellspacing="1" class="admintable">
		
		<tr>
		  <td width="204" class="key">Unit Kerja </td>
		  <td width="529">
					  <select name="<?php echo $field[1] ?>" onchange="get_nama_jabatan(this.value)">
					  <option value="<?php echo $value[1] ?>"><?php echo  nm_unitkerja($value[1]) ?></option>
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
                  	</select>
	      </td>
	  </tr>
		<tr>
			<td class="key"> Nama Jabatan </td>
			<td><div id="nama_jabatan_view"><select name="<?php echo $field[2] ?>">
					  <option value="<?php echo $value[2] ?>"><?php echo  nm_jabatan_ij($value[2],$value[1]) ?></option>
                      <option value="">- Pilih Jabatan -</option>
                    <?php
						$kode = substr($kdunit,0,5) ;
						$query = mysql_query("select * from kd_jabatan where kdunitkerja LIKE '$kode%' order by nmjabatan");
						
						while($row = mysql_fetch_array($query)) { ?>
                        <option value="<?php echo $row['kode'] ?>"><?php echo  $row['kode'].' - '.$row['nmjabatan'].' [ Grade'.$row['klsjabatan'].' ] '; ?></option>
                    <?php
						} ?>
                  </select></div></td>
		</tr>
		<tr>
		  <td class="key">Jumlah</td>
		  <td><input type="text" name="<?php echo $field[3] ?>" size="5" value="<?php echo $value[3] ?>"/></td>
	  </tr>
		
		<tr>
			<td>&nbsp;</td>
			<td>			
				<div class="button2-right">
					<div class="prev">
						<a onclick="Cancel('index.php?p=<?php echo $p_next ?>&pagess=<?php echo $pagess ?>&kdunit=<?php echo $_REQUEST['kdunit'] ?>')">Kembali</a>
					</div>
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