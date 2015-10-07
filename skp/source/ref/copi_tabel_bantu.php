<?php
	checkauthentication();
	$err = false;
	$p = $_GET['p'];
	extract($_POST);
	$kdjab = $_REQUEST['kdjab'];

	$xmenu_p = xmenu_id($p);
	$p_next = $xmenu_p->parent;
	
	if (isset($form)) 
	{		
		if ($err != true) 
		{
			$kdjab_hasil = $_REQUEST['kdjab_copi'];
			//----- isi t_kelompok
			$query_kel = mysql_query("select kdkelompok,nmkelompok from t_kelompok where kdjab = '$kdjab_hasil' order by kdkelompok");
			while($row_kel = mysql_fetch_array($query_kel)) { 
			$kdkelompok = $row_kel['kdkelompok'];
			$nmkelompok = $row_kel['nmkelompok'];
			mysql_query("INSERT INTO t_kelompok(id,kdjab,kdkelompok,nmkelompok) VALUES('','$kdjab','$kdkelompok','$nmkelompok')");
			}
			//----- isi t_bantu
			$query_bantu = mysql_query("select * from t_bantu where kdjab = '$kdjab_hasil' order by kdkelompok,kditem");
			while($row_bantu = mysql_fetch_array($query_bantu)) 
			{ 
			$kdkelompok = $row_bantu['kdkelompok'];
			$kditem = $row_bantu['kditem'];
			$nmitem = $row_bantu['nmitem'];
			$satuan = $row_bantu['satuan'];
			$angka_kredit = $row_bantu['angka_kredit'];
			$min_target = $row_bantu['min_target'];
			$mak_target = $row_bantu['mak_target'];
			mysql_query("INSERT INTO t_bantu(id,kdjab,kdkelompok,kditem,nmitem,satuan,angka_kredit,min_target,mak_target) 
			VALUES('','$kdjab','$kdkelompok','$kditem','$nmitem','$satuan','$angka_kredit','$min_target','$mak_target')");
			}
			?>
			<meta http-equiv="refresh" content="0;URL=index.php?p=376&kdjab=<?php echo $kdjab ?>&pagess=<?php echo $_REQUEST['pagess'] ?>&cari=<?php echo $_REQUEST['cari'] ?>"><?php
		}
	} ?>

<script type="text/javascript">
	function form_submit()
	{
		document.forms['form'].submit();
	}
</script>
<form action="index.php?p=382&kdjab=<?php echo $kdjab ?>&pagess=<?php echo $_REQUEST['pagess'] ?>&cari=<?php echo $_REQUEST['cari'] ?>" method="post" name="form">
	
  <table width="721" cellspacing="1" class="admintable">
    <tr>
      <td width="131" class="key">Jabatan</td>
      <td width="581"><?php echo nm_jabatan_ij($kdjab) ?></td>
    </tr>
    <tr> 
      <td class="key">Copy dari Jabatan </td>
      <td> <select name="kdjab_copi">
                      <option value="">- Pilih Jabatan -</option>
                    <?php
							$kel_jab = substr($kdjab,0,3);
							$query = mysql_query("select kdjab from t_kelompok
							where left(kdjab,3) = '$kel_jab' GROUP BY kdjab order by kdjab");
					
						while($row = mysql_fetch_array($query)) { ?>
                      <option value="<?php echo $row['kdjab'] ?>"><?php echo  nm_jabatan_ij($row['kdjab']); ?></option>
                    <?php
						} ?>
                  </select> </td>
    </tr>
    <tr> 
      <td>&nbsp;</td>
      <td> <div class="button2-right"> 
          <div class="prev"> <a onclick="Cancel('index.php?p=376&kdjab=<?php echo $kdjab ?>&pagess=<?php echo $_REQUEST['pagess'] ?>&cari=<?php echo $_REQUEST['cari'] ?>')">Batal</a> 
          </div>
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
