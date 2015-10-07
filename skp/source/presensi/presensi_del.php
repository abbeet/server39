<?php
	#@
	/*
		File 			: /source/presensi/presensi_del.php
		Dibuat oleh 	: ABR
		Dibuat Tanggal	: 04 Des 2014
		Selesai Tanggal : 
		Fungsi 			: Menghapus data presensi dalam satu bulan
		
		Revisi/Modifikasi :
		
	*/
	
	checkauthentication();
	
	$m = date("n");
	$y = date("Y");
	$kdunit = $_SESSION['xkdunit'];
	
	if (@$_POST['xPresensi']) 
	{
		extract($_POST);
		
		if ($m < 10) $m = "0".$m;
		
		$s_verifikasi = "SELECT * FROM proses_verifikasi WHERE tahun = '".$y."' AND bulan = '".$m."' AND kdunitkerja = '".$kdunit."'";
		$q_verifikasi = mysql_query($s_verifikasi);
		$n_verifikasi = mysql_num_rows($q_verifikasi);
		$ver = mysql_fetch_array($q_verifikasi);
		
		if ($ver['status_verifikasi_potongan'] == "0" or $ver['status_verifikasi_potongan'] == "" or $n_verifikasi == 0)
		{
			$s_delete = "DELETE FROM presensi WHERE kdunit = '".$kdunit."' AND tanggal LIKE '".$y."-".$m."%'";
			$q_delete = mysql_query($s_delete);
			
			if ($q_delete) 
			{
				$s_delete_rekap = "DELETE FROM rekapitulasi WHERE kdunit = '".$kdunit."' AND bulan = '".$y."-".$m."'";
				$q_delete_rekap = mysql_query($s_delete_rekap);
				
				$s_delete_pot = "DELETE FROM potongan WHERE kdunit = '".$kdunit."' AND bulan = '".$y."-".$m."'";
				$q_delete_pot = mysql_query($s_delete_pot);
				
				update_log("Hapus presensi bulan ".nama_bulan($m+0)." ".$y." berhasil.", "presensi", 1);
				$_SESSION['errmsg'] = "Hapus presensi bulan ".nama_bulan($m+0)." ".$y." berhasil."; ?>
				
				<meta http-equiv="refresh" content="0;URL=index.php?p=468"><?php
			}
			else 
			{
				update_log("Hapus presensi bulan ".nama_bulan($m+0)." ".$y." gagal.", "presensi", 0);
				$_SESSION['errmsg'] = "Hapus presensi bulan ".nama_bulan($m+0)." ".$y." gagal."; ?>
				
				<meta http-equiv="refresh" content="0;URL=index.php?p=468"><?php
			}
		}
		else
		{
			update_log("Hapus presensi bulan ".nama_bulan($m+0)." ".$y." gagal. Data sudah diverifikasi", "presensi", 0);
			$_SESSION['errmsg'] = "Hapus presensi bulan ".nama_bulan($m+0)." ".$y." gagal. Data sudah diverifikasi"; ?>
			
			<meta http-equiv="refresh" content="0;URL=index.php?p=468"><?php
		}
	}
?>

	<form action="" method="post" name="xPresensi">
		<fieldset>
			<table class="admintable" cellspacing="1">
				<tr>
					<td class="key">&nbsp;</td>
					<td><font color="red">*Hati-hati!! Semua data pada bulan terpilih akan dihapus!!</font></td>
				</tr>
				<tr>
					<td class="key">Bulan</td>
					<td>
						<select name="m">
							<option></option><?php
							
							for ($month = 1; $month <= 12; $month++) 
							{ ?>
							
								<option value="<?php echo $month; ?>" <?php if ($month == $m) echo "selected"; ?>><?php 
									
									echo nama_bulan($month); ?>
									
								</option><?php
								
							} ?>
						
						</select>
						
						<select name="y">
							<option></option><?php
							
							for ($year = date("Y") - 10; $year <= date("Y") + 10; $year++) 
							{ ?>
							
								<option value="<?php echo $year; ?>" <?php if ($year == $y) echo "selected"; ?>><?php 
							
									echo $year ?>
							
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
								<a onclick="Back('index.php?p=468')">Kembali</a>
							</div>
						</div>
						<div class="button2-left">
							<div class="next">
								<a onclick="Btn_Submit('xPresensi');">OK</a>
							</div>
						</div>
						<div class="clr"></div>
						<input style="border: 0pt none ; margin: 0pt; padding: 0pt; width: 0px; height: 0px;" value="OK" type="submit">
                        <input name="xPresensi" type="hidden" value="1">
					</td>
				</tr>
			</table>
		</fieldset>
	</form>