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
		
					$oList = mysql_query("SELECT * FROM d ");
					while( $List = mysql_fetch_array($oList) )
					{
						$kdjabatan = $List['kdjabatan'];
						$nip = $List['nip'] ;
						$oList_peg = mysql_query("SELECT id FROM m_idpegawai WHERE nip = '$nip' ");
					    $List_peg  = mysql_fetch_array($oList_peg) ;
							mysql_query("UPDATE m_idpegawai SET kdjabatan = '$kdjabatan'
										 WHERE id = '$List_peg[id]' ");
						
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
