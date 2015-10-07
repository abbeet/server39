<?php
	#@
	/*
		File 			: /source/presensi/setting_unit.php
		Dibuat oleh 	: ABR
		Dibuat Tanggal	: 25 Nov 2014
		Selesai Tanggal : 25 Nov 2014
		Fungsi 			: Setting untuk mengubah unit kerja
		
		Revisi / Modifikasi :
		04 Des 2014		: Mengubah Query untuk unit kerja
	*/
	checkauthentication();
	set_time_limit(600);
	$err = false;
	$p = $_GET['p'];
		
	if (@$_POST['xSettingUnit'])
	{
		if ($err != true)
		{
			$u = @$_POST['u'];
			$_SESSION['xkdunit'] = $u;
			$_SESSION['errmsg'] = "Setting unit kerja berhasil!"; ?>
			
			<meta http-equiv="refresh" content="0;URL=index.php?p=<?php echo $p; ?>"><?php
			
			exit();
		}
		else
		{ ?>
		
			<meta http-equiv="refresh" content="0;URL=index.php?p=<?php echo $p; ?>"><?php		
		
		}
	} ?>

	<form action="index.php?p=<?php echo $p; ?>" method="post" name="xSettingUnit">
		<table class="admintable" cellspacing="1">
			<tr>
				<td class="key">Unit Kerja</td>
				<td>			
					<select name="u"><?php
					
						#$oUnit = unit_list();
						
						#$s_unit = "SELECT * FROM kd_unitkerja WHERE kdunit LIKE '%00' ORDER BY kdunit";
						$s_unit = "SELECT * FROM kd_unitkerja WHERE kdsatker <> '' AND LEFT(nmunit, 5) <> 'DINAS' ORDER BY kdunit";
						$q_unit = mysql_query($s_unit);
						
						while ($Unit = mysql_fetch_array($q_unit))
						{ ?>
						
							<option value="<?php echo $Unit['kdunit']; ?>" <?php if ($Unit['kdunit'] == $_SESSION['xkdunit']) 	echo "selected" ?>><?php 
								
								echo "[".$Unit['kdunit']."] ".$Unit['nmunit']; ?>
							
							</option><?php
							
						} ?>
						
					</select>
				</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>			
					<div class="button2-right">
						<div class="prev">
							<a onclick="Cancel('index.php')">Batal</a>
						</div>
					</div>
					<div class="button2-left">
						<div class="next">
							<a onclick="Btn_Submit('xSettingUnit');">Proses</a>
						</div>
					</div>
					<div class="clr"></div>
					<input type="submit" style="border: 0pt none ; margin: 0pt; padding: 0pt; width: 0px; height: 0px;" value="Simpan" />
					<input type="hidden" name="xSettingUnit" value="1" />
				</td>
			</tr>
		</table>
	</form>