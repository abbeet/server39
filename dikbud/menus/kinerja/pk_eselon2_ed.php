<?php
	checkauthentication();
	$table = "dt_pk";
	$field = array("id","th","kdunitkerja","no_sasaran","nourut_pk","indikator","target","no_iku","anggaran");
	$err = false;
	$p = $_GET['p'];
	extract($_POST);
	$xusername = $_SESSION['xusername'];
	$xlevel = $_SESSION['xlevel'];
	$xkdunit = $_SESSION['xkdunit'];
	$th = $_SESSION['xth'];
    
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
				$th = $th ;
				$kdunitkerja = $value[2];
				$nourut_pk   = $value[4];
				$no_iku	     = $value[7];
				$target	     = $value[6];
				$anggaran	 = $_REQUEST['anggaran'];
				$anggaran    = str_replace('.','',$anggaran);
				$anggaran    = str_replace(',','.',$anggaran);
				$no_sasaran	 = no_sasaran($th,$kdunitkerja,$no_iku);
				$indikator   = nm_iku($th,$kdunitkerja,$no_sasaran,$no_iku);
				$sql = "INSERT INTO $table ( id, th, kdunitkerja, no_sasaran, nourut_pk, indikator, target, no_iku,anggaran)
						VALUES ('','$th','$kdunitkerja','$no_sasaran','$nourut_pk','$indikator','$target','$no_iku','$anggaran') ";
				//$sql = sql_insert($table,$field,$value);
				$rs = mysql_query($sql);
				
				if ($rs) {
					update_log($sql,$table,1);
					$_SESSION['errmsg'] = "Input data berhasil!";
				}
				else {
					update_log($sql,$table,0);
					$_SESSION['errmsg'] = "Input data gagal!";
				} ?>
				
				<meta http-equiv="refresh" content="0;URL=index.php?p=<?php echo $p_next ?>"><?php
				exit();
			} 
			else {
				// UPDATE
				$th = $th ;
				$kdunitkerja = $value[2];
				$nourut_pk   = $value[4];
				$no_iku	     = $value[7];
				$target	     = $value[6];
				$anggaran	 = $_REQUEST['anggaran'];
				$anggaran    = str_replace('.','',$anggaran);
				$anggaran    = str_replace(',','.',$anggaran);
				$no_sasaran	 = no_sasaran($th,$kdunitkerja,$no_iku);
				$indikator   = nm_iku($th,$kdunitkerja,$no_sasaran,$no_iku);
				$sql = "UPDATE $table SET nourut_pk  = '$nourut_pk',
										  indikator  = '$indikator',
										  target     = '$target',
										  no_iku     = '$no_iku',
										  no_sasaran = '$no_sasaran',
										  anggaran   = '$anggaran'
				 						 WHERE id = '$q'";
				//$sql = sql_update($table,$field,$value);
				$rs = mysql_query($sql);
				if ($rs) {	
					update_log($sql,$table,1);
					$_SESSION['errmsg'] = "Ubah data berhasil!";
				}
				else {
					update_log($sql,$table,0);
					$_SESSION['errmsg'] = "Ubah data gagal!";			
				} ?>
				
				<meta http-equiv="refresh" content="0;URL=index.php?p=<?php echo $p_next ?>"><?php
				exit();
			}
		}
		else {?>
			<meta http-equiv="refresh" content="0;URL=index.php?p=<?php echo $p_next ?>"><?php		
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
<script language="javascript" src="js/dikbud_combo.js"></script>
<form action="index.php?p=<?php echo $_GET['p'] ?>" method="post" name="form">
	
  <table cellspacing="1" class="admintable">
    
    <tr>
      <td class="key">Eselon II </td>
      <td><select name="<?php echo $field[2] ?>" onchange="get_ik(this.value,<?php echo $th ?>)">
                      <option value="<?php echo $value[2] ?>"><?php echo  nm_unit($value[2]) ?></option>
                      <option value="">- Pilih Eselon II -</option>
                    <?php
					if ( $xlevel == 6 )
					{
							$query = mysql_query("select * from tb_unitkerja where kdunit = '$xkdunit' order by kdunit");
					}else{
							$query = mysql_query("select * from tb_unitkerja where kdunit = '2320100' or kdunit = '2320200' or kdunit = '2320300' or kdunit = '2320400' or kdunit = '2320500' or kdunit = '2320600' order by kdunit");
					}
						while($row = mysql_fetch_array($query)) { ?>
                      <option value="<?php echo $row['kdunit'] ?>"><?php echo  trim($row['nmunit']); ?></option>
                    <?php
					} ?>	
	  </select></td>
    </tr>
    <tr> 
      <td class="key">No.Urut</td>
      <td><input type="text" name="<?php echo $field[4] ?>" size="5" value="<?php echo $value[4] ?>" /></td>
    </tr>
    

    <tr> 
      <td class="key">Indikator Kinerja </td>
      <td><div id="ik-view"><select name="<?php echo $field[7] ?>">
        <option value="<?php echo $value[7] ?>"><?php echo  nm_iku($value[1],$value[2],$value[3],$value[7]) ?></option>
        <option value="">- Pilih IKU -</option>
        <?php
			$query = mysql_query("select no_iku, nm_iku from m_iku_utama where ta = '$th' and kdunit = '2320000' order by no_iku");
					
						while($row = mysql_fetch_array($query)) { ?>
        <option value="<?php echo $row['no_iku'] ?>"><?php echo  trim($row['nm_iku']); ?></option>
        <?php
						} ?>
      </select></td>
    </tr>
    <tr>
      <td class="key">Target</td>
      <td><input type="text" name="<?php echo $field[6] ?>" size="40" value="<?php echo $value[6] ?>" /></td>
    </tr>
    <tr>
      <td class="key">Anggaran</td>
      <td><input type="text" name="anggaran" id="anggaran" onkeyup="this.value = numberFormat(this.value);" size="20" value="<?php echo number_format(@$value[8],"0",",",".") ?>" /></td>
    </tr>
    
    
    
    <tr> 
      <td>&nbsp;</td>
      <td> <div class="button2-right"> 
          <div class="prev"> <a onclick="Cancel('index.php?p=<?php echo $p_next ?>')">Batal</a>          </div>
        </div>
        <div class="button2-left"> 
          <div class="next"> <a onclick="form.submit();">Simpan</a> </div>
        </div>
        <div class="clr"></div>
        <input style="border: 0pt none ; margin: 0pt; padding: 0pt; width: 0px; height: 0px;" value="Simpan" type="submit"> 
        <input name="form" type="hidden" value="1" /> <input name="q" type="hidden" value="<?php echo $_GET['q'] ?>" />      </td>
    </tr>
  </table>
</form>
<?php 
	function no_sasaran($th,$kdunit,$no_iku) {
		$sql = "select no_sasaran from m_iku_utama where ta = '$th' and kdunit = '$kdunit' and no_iku = '$no_iku'"; #echo $sql."<br>";
		$data = mysql_query($sql);
		$rdata = mysql_fetch_array($data);
		$result = $rdata['no_sasaran'];
		return $result;
	}
	
?>