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
					$oList = mysql_query("SELECT * FROM c ");
					while( $List = mysql_fetch_array($oList) )
					{
						$nmunit = trim($List['xx']);
						$id = $List['id'];
						$oList_unit = mysql_query("SELECT kdunitkerja FROM a WHERE xx LIKE '%$nmunit%' GROUP BY xx");
					    $List_unit  = mysql_fetch_array($oList_unit) ;
						if ( !empty($List_unit) )
						{
						     $kdunitkerja = $List_unit['kdunitkerja'];
						}else{
							 $kdunitkerja = '-';
						}
						echo 'nmunit '.$nmunit.'<br>';
						echo 'kode '.$kdunitkerja.'<br>';
							mysql_query("UPDATE c SET kdunitkerja = '$kdunitkerja'
										 WHERE id = '$id' ");
						
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
