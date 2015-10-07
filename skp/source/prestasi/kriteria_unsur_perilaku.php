<!-- ini nyoba ----------------------------------------- -->
<?php 
$err = false;
$p = $_GET['p'];
$sw = $_REQUEST['kdjns'];
$id = $_REQUEST['id'];
$q = $_REQUEST['q'];
extract($_POST);
$xusername_sess = $_SESSION['xusername'];
$xmenu_p = xmenu_id($p);
$p_next = $xmenu_p->parent;
	$sql = "SELECT * FROM dtl_penilaian_perilaku WHERE id = '$q'";
	$qu = mysql_query($sql);
	$row = mysql_fetch_array($qu);
	
	if (isset($form)) {		
		if ($err != true) {
			$lastmodified = now();
			$modifiedby = $xusername_sess;
			    $sw = $_REQUEST['sw'];
				$jml_nilai = $_REQUEST['nilai'];
				?>
				
				<meta http-equiv="refresh" content="0;URL=index.php?p=273&pagess=<?php echo $pagess ?>&cari=<?php echo $cari ?>&id=<?php echo $id ?>&sw=<?php echo $sw ?>&jml_nilai=<?php echo $jml_nilai ?>"><?php
				exit();
		}
		else {?>
			<meta http-equiv="refresh" content="0;URL=index.php?p=273&pagess=<?php echo $pagess ?>&cari=<?php echo $cari ?>&id=<?php echo $id ?>&sw=<?php echo $sw ?>&jml_nilai=<?php echo $jml_nilai ?>"><?php		
		}
	} 
	?>
    <form action="index.php?p=438&id=<?php echo $id ?>&q=<?php echo $q ?>&pagess=<?php echo $pagess ?>&cari=<?php echo $cari ?>&sw=<?php echo $sw ?>" method="post" name="form">
	<table width="474" cellspacing="1" class="admintable">
		<tr>
		  <td width="599" colspan="4" class="key">
		  <table width="137%" height="91" cellpadding="1" class="adminlist">
	<thead>
	
		<tr>
		  <th width="9%">No.</th>
	      <th width="57%">Indikator</th>
	      <th width="9%">Nilai Acuan</th>
	      </tr>
	</thead>
	<tbody>
	<?php 

	switch ($sw)
	{
		case '1':
			$oList = mysql_query("SELECT * FROM ref_aspek_perilaku WHERE kdaspek = 1 order by kdunsur");
			break;
		case '2':
			$oList = mysql_query("SELECT * FROM ref_aspek_perilaku WHERE kdaspek = 2 order by kdunsur");
			break;
		case '3':
			$oList = mysql_query("SELECT * FROM ref_aspek_perilaku WHERE kdaspek = 3 order by kdunsur");
			break;
		case '4':
			$oList = mysql_query("SELECT * FROM ref_aspek_perilaku WHERE kdaspek = 4 order by kdunsur");
			break;
		case '5':
			$oList = mysql_query("SELECT * FROM ref_aspek_perilaku WHERE kdaspek = 5 order by kdunsur");
			break;
		case '6':
			$oList = mysql_query("SELECT * FROM ref_aspek_perilaku WHERE kdaspek = 6 order by kdunsur");
			break;
	}
	
	while($List = mysql_fetch_array($oList)) 
	{
	?>
				<tr>
					<td align="center" valign="top"><?php echo $List['kdunsur'] ?></td>
                    <td align="left" valign="top"><?php echo $List['nmunsur'] ?></td>
                    <td align="center" valign="top"><?php echo nm_angka($List['kdunsur']) ?></td>
                </tr>
	<?php } ?>
				<tr>
				  <td align="center" valign="top">&nbsp;</td>
				  <td align="right" valign="top"><strong>Nilai</strong><input name="sw" type="hidden" value="<?php echo $sw ?>" size="3"></td>
				  <td align="center" valign="top">
<?php 
switch ($sw)
	{
		case '1': ?>
			<input name="nilai" type="text" value="<?php echo $row['nilai_1'] ?>" size="8">
		<?php 	break;
		case '2': ?>
			<input name="nilai" type="text" value="<?php echo $row['nilai_2'] ?>" size="8">
		<?php 	break;
		case '3': ?>
			<input name="nilai" type="text" value="<?php echo $row['nilai_3'] ?>" size="8">
		<?php 	break;
		case '4': ?>
			<input name="nilai" type="text" value="<?php echo $row['nilai_4'] ?>" size="8">
		<?php 	break;
		case '5': ?>
			<input name="nilai" type="text" value="<?php echo $row['nilai_5'] ?>" size="8">
		<?php 	break;
		case '6': ?>
			<input name="nilai" type="text" value="<?php echo $row['nilai_6'] ?>" size="8">
		<?php 	break;
	}
?></td>
		    </tr>
				<tr>
			<td>&nbsp;</td>
			<td>			
				<div class="button2-right">
					<div class="prev">
						<a onclick="Cancel('index.php?p=273&id=<?php echo $_REQUEST['id']; ?>&pagess=<?php echo $pagess ?>&cari=<?php echo $cari ?>')">Batal</a></div>
				</div>
				<div class="button2-left">
					<div class="next">
						<a onclick="form.submit();">Simpan</a></div>
				</div>
				<div class="clr"></div>
				<input style="border: 0pt none ; margin: 0pt; padding: 0pt; width: 0px; height: 0px;" value="Simpan" type="submit">
				<input name="form" type="hidden" value="1" />
				<input name="q" type="hidden" value="<?php echo $_GET['q'] ?>" />			</td>
		</tr>
	</tbody>
	<tfoot>
	</tfoot>
</table>		  
		  </td>
	    </tr>
		
		
  </table>
</form>
<?php 
	function nm_angka($kode) {
		if ($kode == 1 ) $hasil = '91 - 100';
		if ($kode == 2 ) $hasil = '76 - 90';
		if ($kode == 3 ) $hasil = '61 - 75';
		if ($kode == 4 ) $hasil = '51 - 60';
		if ($kode == 5 ) $hasil = '50 kebawah';
	return $hasil;
	}
?>