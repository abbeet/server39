<?php
	checkauthentication();
	$err = false;
	$p = $_GET['p'];
	extract($_POST);
	$xth = $_SESSION['xth'];

	$xmenu_p = xmenu_id($p);
	$p_next = $xmenu_p->parent;
	
	if (isset($form)) 
	{		
		if ($err != true) 
		{
			$th = $_REQUEST['xth'];
			session_unregister('xth');
			@session_register('xth'); $_SESSION['xth'] = $th;
			?>
			<meta http-equiv="refresh" content="0;URL=index.php"><?php
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
      <td width="131" class="key">Seting Tahun </td>
      <td width="581"><?php echo $xth ?></td>
    </tr>
    <tr> 
      <td class="key">Ubah Seting Tahun </td>
      <td> <select name="xth">
          <?php
					for ($i = date("Y")-15; $i <= date("Y")+2; $i++)
					{ ?>
          <option value="<?php echo $i; ?>" <?php if ($i == $xth ) echo "selected"; ?>><?php echo $i ; ?></option>
          <?php
					} ?>
        </select> </td>
    </tr>
    <tr> 
      <td>&nbsp;</td>
      <td> <div class="button2-right"> 
          <div class="prev"> <a onclick="Cancel('index.php?p=<?php echo $p_next ?>')">Batal</a> 
          </div>
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
