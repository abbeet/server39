<?php 
checkauthentication();
$err = false;
$p = $_GET['p'];
$sw = $_REQUEST['kdjns'];
$id = $_REQUEST['id'];
extract($_POST);
$xusername_sess = $_SESSION['xusername'];
$xmenu_p = xmenu_id($p);
$p_next = $xmenu_p->parent;

	if (isset($form)) {		
		if ($err != true) {
			$lastmodified = now();
			$modifiedby = $xusername_sess;
			    
				$jml_nilai = $_REQUEST['total'];
				?>
				
				<meta http-equiv="refresh" content="0;URL=index.php?p=273&pagess=<?php echo $pagess ?>&cari=<?php echo $cari ?>&id=<?php echo $id ?>&sw=<?php echo $sw ?>&jml_nilai=<?php echo $jml_nilai ?>"><?php
				exit();
		}
		else {?>
			<meta http-equiv="refresh" content="0;URL=index.php?p=273&pagess=<?php echo $pagess ?>&cari=<?php echo $cari ?>&id=<?php echo $id ?>&sw=<?php echo $sw ?>&jml_nilai=<?php echo $jml_nilai ?>"><?php		
		}
	} 
	?>
<head>
<script type="text/javascript">

function hitungNilai(i,nilai)
{
	var hasil = document.getElementById('hasil'+i);
	var bobot = document.getElementById('bobot'+i);
	var total = document.getElementById('total');
	var n = document.getElementById('jmlData');
	hasil.value = nilai.value * bobot.value/100;
	var sum=0;
	for (var j=1;j<=n.value;j++)
	{
		hasil = document.getElementById('hasil'+j);
		sum = sum + parseFloat(hasil.value);
	}
	sum = sum*100/4;
	total.value = sum.toFixed(2);
}

</script> 
    </head>


    <form action="index.php?p=295&id=<?php echo $_REQUEST['id'] ?>&sw=<?php echo $sw ?>&pagess=<?php echo $pagess ?>&cari=<?php echo $cari ?>&kdjns=<?php echo $sw ?>" method="post" name="form" id="form">
	<table width="474" cellspacing="1" class="admintable">
		<tr>
		  <td width="599" colspan="4" class="key">
		  
		  <table width="137%" height="91" cellpadding="1" class="adminlist">
	<thead>
	
		<tr>
		  <th width="9%" rowspan="2">No.</th>
	      <th width="57%" rowspan="2">Indikator</th>
	      <th width="9%" rowspan="2">Bobot (%)</th>
	      <th colspan="5">Nilai</th>
		  <th width="6%" rowspan="2">Nilai x Bobot</th>
		</tr>
		<tr>
		  <th width="7%">0</th>
		  <th width="6%">1</th>
		  <th width="6%">2</th>
		  <th width="6%">3</th>
		  <th width="6%">4</th>
		  </tr>
	</thead>
	<tbody>
	<?php 

	switch ($sw)
	{
		case '1':
			$oList = mysql_query("SELECT id_ol as nomor ,unsur_ol as uraian ,bobot_ol as bobot FROM ref_layanan order by id_ol");
			break;
		case '2':
			$oList = mysql_query("SELECT id_it as nomor ,unsur_it as uraian ,bobot_it as bobot FROM ref_integritas order by id_it");
			break;
		case '3':
			$oList = mysql_query("SELECT id_km as nomor ,unsur_km as uraian ,bobot_km as bobot FROM ref_komitmen order by id_km");
			break;
		case '4':
			$oList = mysql_query("SELECT id_ds as nomor ,unsur_ds as uraian ,bobot_ds as bobot FROM ref_disiplin order by id_ds");
			break;
		case '5':
			$oList = mysql_query("SELECT id_ks as nomor ,unsur_ks as uraian ,bobot_ks as bobot FROM ref_kerjasama order by id_ks");
			break;
		case '6':
			$oList = mysql_query("SELECT id_kp as nomor ,unsur_kp as uraian ,bobot_kp as bobot FROM ref_kepemimpinan order by id_kp");
			break;
	}
	
	while($List = mysql_fetch_array($oList)) 
	{
	$no = $List['nomor'];
	$bobot = 'bobot'.$no;
	$nilai = 'nilai'.$no;
	$nama = 'nama'.$no;
	$hasil = 'hasil'.$no;
	?>
				<tr>
					<td align="center" valign="top"><?php echo $no ?></td>
                    <td align="left" valign="top"><?php echo $List['uraian'] ?></td>
                    <td align="center" valign="top"><input name="bobot" type="text" size="5" id="<?php echo $bobot ?>" value="<?php echo $List['bobot'] ?>" /></td>
                    <td align="center" valign="top"><input name="<?php echo $nama ?>[]" type="radio" id="<?php echo $nilai ?>" value="0" onChange="hitungNilai(<?php echo $no ?>,this)"  /></td>
		            <td align="left" valign="top"><input name="<?php echo $nama ?>[]" type="radio" id="<?php echo $nilai ?>" value="1" onChange="hitungNilai(<?php echo $no ?>,this)" /></td>
		            <td align="left" valign="top"><input name="<?php echo $nama ?>[]" type="radio" id="<?php echo $nilai ?>" value="2" onChange="hitungNilai(<?php echo $no ?>,this)" /></td>
		            <td align="left" valign="top"><input name="<?php echo $nama ?>[]" type="radio" id="<?php echo $nilai ?>" value="3" onChange="hitungNilai(<?php echo $no ?>,this)" /></td>
					<td align="left" valign="top"><input name="<?php echo $nama ?>[]" type="radio" id="<?php echo $nilai ?>" value="4" onChange="hitungNilai(<?php echo $no ?>,this)" /></td>
				    <td align="center" valign="top"><input name="<?php echo $hasil ?>" id="<?php echo $hasil ?>" type="text" value="0" size="8"/></td></tr>
	<?php } ?>
	</tbody>
	<tfoot>
	</tfoot>
<tr>
	<td colspan="8" class="key">Total</td><td align="right" valign="top">
	<input name="jmlData" type="hidden" id="jmlData" value="<?php echo $no ?>">
	<input name="total" type="text" id="total" value="0" size="8"></td>
</tr>
</table>		  
		  </td>
	    </tr>
<tr>
			<td>&nbsp;</td>
			<td>			
				<div class="button2-right">
					<div class="prev">
						<a onclick="Cancel('index.php?p=273&id=<?php echo $_REQUEST['id']; ?>&pagess=<?php echo $pagess ?>&cari=<?php echo $cari ?>')">Batal</a>					</div>
				</div>
				<div class="button2-left">
					<div class="next">
						<a onclick="form.submit();">Simpan</a></div>
				</div>
				<div class="clr"></div>
				<input style="border: 0pt none ; margin: 0pt; padding: 0pt; width: 0px; height: 0px;" value="Simpan" type="submit">
				<input name="form" type="hidden" value="1" />
				<input name="q" type="hidden" value="<?php echo $_GET['q'] ?>" />			</td>
		</tr>  </table>
</form>