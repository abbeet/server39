<?php
	checkauthentication();
	$err = false;
	$p = $_GET['p'];
	
	extract($_POST);
	
	$xusername_sess = $_SESSION['xusername'];
	$xusername = $_SESSION['xusername'];
	$xkdunit = $_SESSION['xkdunit'];
	$xlevel = $_SESSION['xlevel'];
	
	$xmenu_p = xmenu_id($p);
	$p_next = $xmenu_p->parent;
		
	if (isset($xImport))
	{		
		if ($err != true) 
		{
			if ($m <= 9) $m = "0".$m;
			
			$bulan = $y."-".$m;
			
			$connect = mysql_connect("183.91.67.8", "sikap", "sik4p") or die(mysql_error());
			$db = mysql_select_db("siapp", $connect);
			
			$sql = "
				SELECT 
					nip, bulan, TL1, TL2, TL3, TL4, KS1, KS2, KS3, KS4, PSW1, PSW2, PSW3, PSW4, CT, CB, CSRI, CSRJ, CM, CP, 
					CLTN, TK, TBmin, TBplus, UP 
				FROM rekapitulasi_".$xkdunit." 
				WHERE bulan = '".$bulan."'
			";
			
			$oRekapitulasi = mysql_query($sql);
			$nRekapitulasi = mysql_num_rows($oRekapitulasi);
			
			@mysql_connect("localhost", "root", "bidsi");
			@mysql_select_db("dbskp_batan");
				
			if ($nRekapitulasi > 0)
			{
				while ($Rekapitulasi = mysql_fetch_object($oRekapitulasi))
				{
					$update = "UPDATE mst_potongan SET ";
					
					$sql = "SELECT kdpot, kdsiapp FROM ref_potongan ORDER BY kdpot";
					$oRef = mysql_query($sql);
					
					$i = 1;
					
					while ($Ref = mysql_fetch_object($oRef))
					{
						$kdsiapp = $Ref->kdsiapp;
						
						if ( $Ref->kdpot != 'tk' and $Ref->kdpot != 'cm' )
						{
						
						if ($i == 1) $update .= "kdpot_".$Ref->kdpot." = '".$Rekapitulasi->$kdsiapp."'";
						else $update .= ", kdpot_".$Ref->kdpot." = '".$Rekapitulasi->$kdsiapp."'";
						
						}
						$i++;
					}
					
					$update .= " WHERE nib = '".$Rekapitulasi->nip."' AND bulan = '".substr($Rekapitulasi->bulan, 5, 2)."' AND 
					tahun = '".substr($Rekapitulasi->bulan, 0, 4)."'";
					
					$query = mysql_query($update);
								
					if (($m == "01" or $m == "02") and $y == "2013")
					{
						$sql = "
							UPDATE mst_potongan 
							SET 
								kdpot_10 = '0',
								kdpot_15 = '0',
								kdpot_tk = '".$Rekapitulasi->TK."', 
								kdpot_cm = '".$Rekapitulasi->CM."' 
							WHERE 
								nib = '".$Rekapitulasi->nip."' AND 
								bulan = '".substr($Rekapitulasi->bulan, 5, 2)."' AND 
								tahun = '".substr($Rekapitulasi->bulan, 0, 4)."'
						";
						
						$query = mysql_query($sql);
					}
				}
			}
			
			if ($m == "03" and $y == "2013")
			{
				$connect = mysql_connect("183.91.67.8", "sikap", "sik4p") or die(mysql_error());
				$db = mysql_select_db("siapp", $connect);
				
				$sql = "
					SELECT 
						nip, LEFT(tanggal, 7) as tanggal, sum(TK) as TK, sum(CM) as CM
					FROM presensi_".$xkdunit." 
					WHERE tanggal >= '2013-03-01' AND tanggal <= '2013-03-06'
					GROUP BY nip
				";
				
				$oRekapitulasi = mysql_query($sql);
				$nRekapitulasi = mysql_num_rows($oRekapitulasi);
				
				@mysql_connect("localhost", "root", "bidsi");
				@mysql_select_db("dbskp_batan");
					
				if ($nRekapitulasi > 0)
				{
					while ($Rekapitulasi = mysql_fetch_object($oRekapitulasi))
					{
						$sql = "
							SELECT id, kdpot_10, kdpot_15 
							FROM mst_potongan 	
							WHERE 
								nib = '".$Rekapitulasi->nip."' AND 
								bulan = '".substr($Rekapitulasi->tanggal, 5, 2)."' AND 
								tahun = '".substr($Rekapitulasi->tanggal, 0, 4)."'
						";
						
						$query = mysql_query($sql);
						$rows = mysql_fetch_object($query);
						
						$selisih_tk = $rows->kdpot_10 - $Rekapitulasi->TK;
						$selisih_cm = $rows->kdpot_15 - $Rekapitulasi->CM;
					
						$update = "
							UPDATE mst_potongan 
							SET 
								kdpot_10 = '".$selisih_tk."',
								kdpot_15 = '".$selisih_cm."',
								kdpot_tk = '".$Rekapitulasi->TK."', 
								kdpot_cm = '".$Rekapitulasi->CM."' 
							WHERE 
								nib = '".$Rekapitulasi->nip."' AND 
								bulan = '".substr($Rekapitulasi->tanggal, 5, 2)."' AND 
								tahun = '".substr($Rekapitulasi->tanggal, 0, 4)."'
						";
						
						$query = mysql_query($update);
					}
				}
			}
			
			
			if ($query) $_SESSION['errmsq'] = "Import Data Potongan dari SIAPP berhasil";
			else $_SESSION['errmsq'] = "Import Data Potongan dari SIAPP gagal"; ?>
			
			<meta http-equiv="refresh" content="0;URL=index.php?p=<?php echo $p_next; ?>"><?php
		}
	} ?>

<script language="javascript" type="text/javascript">
	function Btn_Submit(FormName)
	{
		document.forms[FormName].submit();
	}
</script>

<form action="index.php?p=<?php echo $_GET['p']; ?>" method="post" name="xImport">
	<table width="721" cellspacing="1" class="admintable">
		<tr>
			<td colspan="2"><strong>Import Data Potongan dari Aplikasi SIAPP</strong></td>
		</tr>
		<tr>
			<td colspan="2"><strong><?php echo 'Unit Kerja : '. nm_unitkerja($xkdunit.'00') ?></strong></td>
		</tr>
		<tr>
			<td class="key">Bulan</td>
			<td>
				<select name="m"><?php

					for ($i = 1; $i <= 12; $i++)
					{ ?>
		
						<option value="<?php echo $i; ?>" <?php if ($i == date ("m") ) echo "selected"; ?>><?php echo nama_bulan($i); ?></option><?php
						
					} ?>
				</select> 
				<select name="y"><?php
				
					for ($i = date("Y") - 5; $i <= date("Y") + 5; $i++)
					{ ?>
					
						<option value="<?php echo $i; ?>" <?php if ($i == date ("Y") ) echo "selected"; ?>><?php echo $i ; ?></option><?php
					
					} ?>

				</select>
			</td>
		</tr>
		<tr> 
		<td>&nbsp;</td>
		<td>
			<div class="button2-right"> 
				<div class="prev"> <a onclick="Cancel('index.php?p=<?php echo $p_next; ?>')">Batal</a></div>
			</div>
			<div class="button2-left"> 
				<div class="next"> <a onclick="Btn_Submit('xImport');">Proses</a></div>
			</div>
			<div class="clr"></div>
			<input style="border: 0pt none ; margin: 0pt; padding: 0pt; width: 0px; height: 0px;" value="Simpan" type="submit"> 
			<input name="xImport" type="hidden" value="1" /> </td>
		</tr>
	</table>
</form>
