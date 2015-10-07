<?php
	$id_skp = $_GET['id_skp'];
	$form = $_POST['form'];
	
	if ($form == 1)
	{
		extract($_POST);
		
		$Sql = "SELECT no_tugas FROM dtl_skp WHERE id_skp = '".$id_skp."' ORDER BY no_tugas DESC";
		$Query3 = mysql_query($Sql);
		$Rows3 = mysql_fetch_array($Query3);
		$j = $Rows3['no_tugas'] + 1;
		
		for ($i = 1; $i < $nData; $i++)
		{
			$nama_tugas = "nama_" . $i;
			$ak_target = "AK_" . $i;
			$jumlah_target = "target_" . $i;
			$satuan_jumlah = "satuan_" . $i;
			$kualitas_target = "kualitas_" . $i;
			$waktu_target = "waktu_target_" . $i;
			$satuan_waktu = "satuan_waktu_" . $i;
			$prakiraan = "prakiraan_" . $i;
			$total_waktu = $$waktu_target * $$jumlah_target;
			$total_ak = $$ak_target * $$jumlah_target;
			
			if ($$prakiraan != "")
			{
				$Sql = "INSERT INTO dtl_skp (id_skp, no_tugas, nama_tugas, ak_target, jumlah_target, satuan_jumlah, kualitas_target, waktu_target, 
					satuan_waktu) VALUES ('".$id_skp."', '".$j."', '".$$nama_tugas."', '".$total_ak."', '".$$jumlah_target."', 
					'".$$satuan_jumlah."', '".$$kualitas_target."', '".$total_waktu."', '".$$satuan_waktu."')";
				
				$Query = mysql_query($Sql);
				
				$j++;
			}
		} 
				
		if ($Query) $_SESSION['errmsg'] = "Input data berhasil!";
		else $_SESSION['errmsg'] = "Input data gagal!";?>
		
		<meta http-equiv="refresh" content="0;URL=index.php?p=264&id_skp=<?php echo $id_skp; ?>&pagess=<?php echo $_POST['pagess']; ?>&cari=<?php echo $_POST['cari']; ?>"><?php
		
		exit;
	}
?>

<script type="text/javascript">
	
	function hitungNilai(i, nilai)
	{
		var prakiraan = document.getElementById('prakiraan_' + i);
		var AK = document.getElementById('AK_' + i);
		var nData = document.getElementById('nData');
		
		prakiraan.value = nilai.value * AK.value;
		
		var sum = 0;
		var x;
		for (var j = 1; j < nData.value; j++)
		{
			x = document.getElementById('prakiraan_' + j);
			
			y = x.value || 0;
			sum = sum + parseFloat(y);
			
		}
		
		var total_prakiraan = document.getElementById('total_prakiraan');
		total_prakiraan.value = sum;
	}

</script> 

<form action="" method="post" name="form" id="form">
	<table cellspacing="1" class="adminlist">
		<thead>
			<tr>
				<th width="4%" rowspan="2">No.</th>
				<th rowspan="2">Butir Kegiatan Pokok</th>
				<th width="5%" rowspan="2">AK Satuan</th>
				<th width="10%" colspan="2">Target Output (T)</th>
				<th width="5%" rowspan="2">Prakiraan AK</th>
				<th width="8%" rowspan="2">Indikator</th>
				<th width="5%" rowspan="2">Waktu Penyelesaian Per Output</th>
				<th width="5%" rowspan="2">Kualitas / Mutu</th>
			</tr>
			<tr>
				<th>Batasan</th>
				<th>T</th>
			</tr>
		</thead>
		
		<tbody><?php 
	
			$Sql = "SELECT kdjabatan FROM mst_skp WHERE id = '".$id_skp."'";
			$Query = mysql_query($Sql);
			$MasterSkp = mysql_fetch_array($Query);
			$kdjab = $MasterSkp['kdjabatan'];
			
			$Sql = "SELECT * FROM t_kelompok WHERE kdjab = '".$kdjab."' ORDER BY kdkelompok";
			$Query = mysql_query($Sql);
			
			if (mysql_num_rows($Query) == 0)
			{ ?>
				
				<tr>
					<td colspan="9" align="center">Form Bantu Belum Tersedia</td>
				</tr><?php
				
			}
			else
			{
				$i = 1;
				
				while ($Kelompok = mysql_fetch_array($Query)) 
				{ ?>
					
					<tr>
						<td align="center">&nbsp;</td>
						<td><b><?php echo $Kelompok['nmkelompok']; ?></b></td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr><?php 
					
					$Sql = "SELECT * FROM t_bantu WHERE kdjab = '".$kdjab."' AND kdkelompok = '".$Kelompok['kdkelompok']."' ORDER BY kditem";
					$Query2 = mysql_query($Sql);
					
					while ($Bantu = mysql_fetch_array($Query2))
					{ ?>
						<tr>
							<td align="center"><?php echo $i; ?></td>
							<td><?php 
							
								echo $Bantu['nmitem']; ?>
								<input type="hidden" name="nama_<?php echo $i; ?>" id="nama_<?php echo $i; ?>" 
									value="<?php echo $Bantu['nmitem']; ?>" />
									
							</td>
							<td align="center"><?php 
							
								echo $Bantu['angka_kredit']; ?>
								<input type="hidden" name="AK_<?php echo $i; ?>" id="AK_<?php echo $i; ?>" 
									value="<?php echo $Bantu['angka_kredit']; ?>" />
									
							</td>
							
							<td align="center" nowrap="nowrap"><?php echo $Bantu['min_target'] . " <= T <= " . $Bantu['mak_target']; ?></td>
							
							<td><input type="text" name="target_<?php echo $i; ?>" id="target_<?php echo $i; ?>" size="5" 
								value="" onchange="hitungNilai(<?php echo $i; ?>, this)" /></td>
							
							<td><input type="text" name="prakiraan_<?php echo $i; ?>" id="prakiraan_<?php echo $i; ?>" 
								size="5" readonly="1" value="" /></td>
							
							<td><?php 
							
								echo $Bantu['satuan']; ?>
								<input type="hidden" name="satuan_<?php echo $i; ?>" id="satuan_<?php echo $i; ?>" 
									value="<?php echo $Bantu['satuan']; ?>" />
								
							</td>
							
							<td nowrap="nowrap">
								<input type="text" name="waktu_target_<?php echo $i; ?>" id="waktu_target_<?php echo $i; ?>" size="5" value="" />
								<select name="satuan_waktu_<?php echo $i; ?>">
									<option value="menit">menit</option>			
									<option value="jam">jam</option>
									<option value="hari">hari</option>
									<option value="minggu">minggu</option>
									<option value="bulan">bulan</option>
									<option value="tahun">tahun</option>
					 	 		</select>
							</td>
							
							<td nowrap="nowrap"><input type="text" name="kualitas_<?php echo $i; ?>" id="kualitas_<?php echo $i; ?>" 
								size="2" value="100" />&nbsp;%</td>
						</tr><?php
						
						$i++;
					}
				}
			} ?>
			
		</tbody>
		
		<tfoot>
			<tr>
				<td colspan="5" align="right"><b>Total Prakiraan Angka Kredit</b></td>
				<td>
					<input type="hidden" name="nData" id="nData" value="<?php echo $i; ?>" />
					<input type="text" name="total_prakiraan" id="total_prakiraan" size="5" readonly="1" value="0" />
				</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
		</tfoot>			
	</table>
	
	<br />
	<div class="button2-right">
		<div class="prev">
			<a onclick="Cancel('index.php?p=264&id_skp=<?php echo $_GET['id_skp']; ?>&pagess=<?php echo $_GET['pagess']; ?>&cari=<?php echo $_GET['cari']; ?>')">Batal</a>							
		</div>
	</div>
	<div class="button2-left">
		<div class="next">
			<a onclick="form.submit();">Simpan</a>
		</div>
	</div>
	<div class="clr"></div>
	
	<input style="border: 0pt none ; margin: 0pt; padding: 0pt; width: 0px; height: 0px;" value="Simpan" type="submit">
	<input name="form" type="hidden" value="1" />
	<input name="id_skp" type="hidden" value="<?php echo $_GET['id_skp']; ?>" />
	<input name="pagess" type="hidden" value="<?php echo $_GET['pagess']; ?>" />
	<input name="cari" type="hidden" value="<?php echo $_GET['cari']; ?>" />
</form>