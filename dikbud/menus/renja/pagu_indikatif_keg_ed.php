<?php
	checkauthentication();
	$table = "thbp_kak_kegiatan";
	$field = array("id","th","kdunitkerja","kdgiat","kddept","kdunit","kdprogram","jml_anggaran_dipa","jml_anggaran_indikatif");
	$err = false;
	$p = $_GET['p'];
	extract($_POST);
	$xusername_sess = $_SESSION['xusername'];
	
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
				$th = $_REQUEST['th'];
				$kdgiat = $_REQUEST['kdgiat'];
				$kdunitkerja = $_REQUEST['kdunitkerja'];
				$jml_anggaran_indikatif		= $_REQUEST['jml_anggaran_indikatif'];
				// replace
				$jml_anggaran_indikatif = str_replace('.','',$jml_anggaran_indikatif);
				$jml_anggaran_indikatif = str_replace(',','.',$jml_anggaran_indikatif);
				$value[8] = $jml_anggaran_indikatif ;
				$sql = "UPDATE $table SET jml_anggaran_indikatif = '$jml_anggaran_indikatif' WHERE id = '$q'" ;
				// end replace				
//				$sql = sql_update($table,$field,$value);
				$rs = mysql_query($sql);
				if ($rs) {	
					update_log($sql,$table,1);
					mysql_query(" update thbp_kak_output set kdunitkerja = '$kdunitkerja' WHERE th='$th' AND kdgiat = '$kdgiat'");
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

<script language="javascript" src="js/autocombo.js"></script>
<form action="index.php?p=<?php echo $_GET['p'] ?>" method="post" name="form">
	
  <table width="597" cellspacing="1" class="admintable">
    <tr> 
      <td width="215" class="key">Tahun</td>
      <td width="373"><label>
        <input type="text" size="10" name="<?php echo $field[1]?>" value="<?php echo $value[1] ?>" disabled="disabled"/>
      </label>       </td>
    </tr>
    <tr>
      <td class="key">Unit Kerja</td>
      <td><textarea cols="70" rows="1" disabled="disabled"><?php echo nm_unit($value[2]) ?></textarea></td>
    </tr>
    <tr> 
      <td class="key">Kegiatan</td>
      <td><textarea cols="70" rows="1" disabled="disabled"><?php echo nm_giat($value[3]) ?></textarea></td>
    </tr>
    <tr>
      <td class="key">Program</td>
      <td>
      <textarea cols="70" rows="1" disabled="disabled"><?php echo nm_program($value[1],$value[4].$value[5].$value[6]) ?></textarea></td></tr>
    
    <tr> 
      <td class="key">Anggaran DIPA <?php echo ($value[1] - 1)?></td>
      <td><input type="text" size="25" name="<?php echo $field[7]?>" value="<?php echo number_format($value[7],"0",",",".") ?>" disabled="disabled"/></td>
    </tr>
    <tr>
      <td class="key">Anggaran  <?php echo $value[1] ?></td>
      <td><input type="text" name="jml_anggaran_indikatif" 
	  		id="jml_anggaran_indikatif" onkeyup="this.value = numberFormat(this.value);"
	  		value="<?php echo number_format($value[8],"0",",",".") ?>" size="15" /></td>
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