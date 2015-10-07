<?php
	#@
	/*
		File 			: /source/presensi/potongan_ed.php
		Dibuat oleh 	: ABR
		Dibuat Tanggal	: 26 Nov 2014
		Selesai Tanggal : 26 Nov 2014
		Fungsi 			: mengubah potongan tunjangan kinerja khusus yang sifatnya bulanan.
		
		Revisi/Modifikasi :
		04 Des 2014		: Menambahkan Keterangan
		
	*/
	
	checkauthentication();
	
	$err = false;
	$p = $_GET['p'];
	$u = $_GET['u'];
	$q = $_GET['q'];
	
	$url = "m=".$_GET['m']."&y=".$_GET['y']."&u=".$_GET['u']."&b=".$_GET['b']."&s=".$_GET['s']."&r=475";
	
	if (@$_POST['xPotongan']) 
	{		
		if ($err != true)
		{
			if (isset($_POST['q']))
			{
				extract($_POST);
				
				$s_update = "UPDATE potongan SET CB = '".$CB."', CSRI = '".$CSRI."', CM = '".$CM."', CP = '".$CP."', DIS = '".$DIS."', 
				BS = '".$BS."', keterangan = '".$keterangan."' WHERE id = '".$q."'";
				
				$rs = mysql_query($s_update);
				
				if ($rs) 
				{	
					update_log("Ubah data potongan berhasil. NIP = ".$nip, "potongan", 1);
					$_SESSION['errmsg'] = "Ubah data potongan berhasil."; ?>
					
                    <meta http-equiv="refresh" content="0;URL=index.php?p=475&<?php echo $url; ?>"><?php
				}
				else 
				{
					update_log("Ubah data potongan gagal. NIP = ".$nip, "potongan", 0);
					$_SESSION['errmsg'] = "Ubah data potongan gagal."; ?>
					
                    <meta http-equiv="refresh" content="0;URL=index.php?p=475&<?php echo $url; ?>"><?php
				}
			}
		}
		else
		{ ?>
			<meta http-equiv="refresh" content="0;URL=index.php?p=475&<?php echo $url; ?>"><?php		
		}
	} 
	else if (isset($_GET["q"]))
	{
		$s_potongan = "SELECT * FROM potongan WHERE id = '".$_GET['q']."'";
		$q_potongan = mysql_query($s_potongan);
		$potongan = mysql_fetch_array($q_potongan);
		
		$s_pegawai = "SELECT * FROM m_idpegawai WHERE nip = '".$potongan['nip']."'";
		$q_pegawai = mysql_query($s_pegawai);
		$pegawai = mysql_fetch_array($q_pegawai);
	}
	else
	{
		$potongan = array();
		$pegawai = array();
	}
?>
<script language="javascript" src="lib/autocombo/autocombo.js"></script>
<script language="javascript">
	
	function HitungCB(val)
	{
		var res;
		
		if (val == 0) res = 0;
		else if (val == 1) res = 30;
		
		document.getElementById("CB").value = res;
	}
	
	function HitungCM(val)
	{
		var res;
		
		if (val == 0) res = 0;
		else if (val == 1) res = 40;
		else if (val == 2) res = 70;
		else if (val == 3) res = 80;
		
		document.getElementById("CM").value = res;
	}
	
	function HitungCP(val)
	{
		var res;
		
		if (val == 0) res = 0;
		else if (val == 1) res = 30;
		
		document.getElementById("CP").value = res;
	}
	
	function HitungDIS(val)
	{
		var res;
		
		if (val == 0) res = 0;
		else if (val == 1) res = 20;
		else if (val == 2) res = 30;
		else if (val == 3) res = 40;
		else if (val == 4) res = 40;
		else if (val == 5) res = 50;
		else if (val == 6) res = 60;
		else if (val == 7) res = 60;
		else if (val == 8) res = 70;
		else if (val == 9) res = 80;
		else if (val == 10) res = 100;
		
		document.getElementById("DIS").value = res;
	}
	
	function HitungBS(val)
	{
		var res;
		
		if (val == 0) res = 0;
		else if (val == 1) res = 100;
		
		document.getElementById("BS").value = res;
	}
	
</script>

<link href="css/general.css" rel="stylesheet" type="text/css" />
<div id="divResult" style="font-size:11px;text-align:center;display:none"></div>

<form name="xPotongan" method="post" action="">
	<table class="admintable" cellspacing="1">
		<tr>
			<td class="key">NIP</td>
			<td>
				<input type="text" name="nip_baru" size="20" value="<?php echo $potongan['nip']; ?>" readonly />
				<input type="hidden" name="nip" value="<?php echo $value['nip']; ?>" />
			</td>
		</tr>
		<tr>
			<td class="key">Nama</td>
			<td><input type="text" name="nama" size="40" value="<?php echo trim($pegawai['nama']); ?>" readonly /></td>
		</tr>
		<tr>
			<td class="key">TL2</td>
			<td><input type="text" name="TL2" size="5" value="<?php echo $potongan['TL2']; ?>" readonly /> &nbsp;%&nbsp;&nbsp;&nbsp;(1% / Hari)</td>
		</tr>
        <tr>
            <td class="key">TL3</td>
            <td><input type="text" name="TL3" size="5" value="<?php echo $potongan['TL3']; ?>" readonly /> &nbsp;%&nbsp;&nbsp;&nbsp;(1.5% / Hari)</td>
        </tr>
        <tr>
            <td class="key">PSW1</td>
            <td><input type="text" name="PSW1" size="5" value="<?php echo $potongan['PSW1']; ?>" readonly /> &nbsp;%&nbsp;&nbsp;&nbsp;(0.5% / Hari)</td>
        </tr>
        <tr>
            <td class="key">PSW2</td>
            <td><input type="text" name="PSW2" size="5" value="<?php echo $potongan['PSW2']; ?>" readonly /> &nbsp;%&nbsp;&nbsp;&nbsp;(1% / Hari)</td>
        </tr>
        <tr>
            <td class="key">PSW3</td>
            <td><input type="text" name="PSW3" size="5" value="<?php echo $potongan['PSW3']; ?>" readonly /> &nbsp;%&nbsp;&nbsp;&nbsp;(1.25% / Hari)</td>
        </tr>
        <tr>
            <td class="key">PSW4</td>
            <td><input type="text" name="PSW4" size="5" value="<?php echo $potongan['PSW4']; ?>" readonly /> &nbsp;%&nbsp;&nbsp;&nbsp;(1.5% / Hari)</td>
        </tr>
        <tr>
            <td class="key">Tanpa Keterangan</td>
            <td><input type="text" name="TK" size="5" value="<?php echo $potongan['TK']; ?>" readonly /> &nbsp;%&nbsp;&nbsp;&nbsp;(3% / Hari)</td>
        </tr>
        <tr>
            <td class="key">Dengan Keterangan</td>
            <td><input type="text" name="DK" size="5" value="<?php echo $potongan['DK']; ?>" readonly /> &nbsp;%&nbsp;&nbsp;&nbsp;(1.5% / Hari)</td>
        </tr>
        <tr>
            <td class="key">Cuti Sakit</td>
            <td>
                <input type="text" name="CSRI" size="5" value="<?php echo $potongan['CSRI']; ?>" readonly /> &nbsp;%
                &nbsp;&nbsp;&nbsp;(1-2H : 0%; 3-14H : 25%; 15-30H : 50%; 1-2B : 70%; 2-6B : 80%; 6-18B : 90%)
            </td>
        </tr>
	</table>
    <BR />
	<fieldset>
        <table class="admintable" cellspacing="1">
            <tr>
                <td class="key" rowspan="2">Cuti Besar</td>
                <td>
                	<select name="SelCB" onchange="HitungCB(this.value)">
                    	<option value="0" <?php if ($potongan['CB'] == 0) echo "SELECTED"; ?>>Tidak</option>
                        <option value="1" <?php if ($potongan['CB'] == 30) echo "SELECTED"; ?>>Ya</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>
                	<input type="text" name="CB" id="CB" size="5" value="<?php echo $potongan['CB']; ?>" readonly /> &nbsp;%
                    &nbsp;&nbsp;&nbsp;(30% / Bulan)
                </td>
            </tr>
            <tr>
                <td class="key" rowspan="2">Cuti Melahirkan</td>
                <td>
                	<select name="SelCM" onchange="HitungCM(this.value)">
                    	<option value="0" <?php if ($potongan['CM'] == 0) echo "SELECTED"; ?>>Tidak</option>
                        <option value="1" <?php if ($potongan['CM'] == 40) echo "SELECTED"; ?>>Anak Ke-3, Bulan Ke-1</option>
                        <option value="2" <?php if ($potongan['CM'] == 70) echo "SELECTED"; ?>>Anak Ke-3, Bulan Ke-2</option>
                        <option value="3" <?php if ($potongan['CM'] == 80) echo "SELECTED"; ?>>Anak Ke-3, Bulan Ke-3</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>
                	<input type="text" name="CM" id="CM" size="5" value="<?php echo $potongan['CM']; ?>" readonly /> &nbsp;%
                    &nbsp;&nbsp;&nbsp;(Anak Ke-1 atau Ke-2 : 0%; Anak Ke-3 : Bulan Ke-1 : 40%; Bulan Ke-2 : 70%; Bulan Ke-3 : 80%)
                </td>
            </tr>
        
            <tr>
                <td class="key" rowspan="2">Cuti Penting</td>
                <td>
                	<select name="SelCP" onchange="HitungCP(this.value)">
                    	<option value="0" <?php if ($potongan['CP'] == 0) echo "SELECTED"; ?>>Tidak</option>
                        <option value="1" <?php if ($potongan['CP'] == 30) echo "SELECTED"; ?>>Ya</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>
                	<input type="text" name="CP" id="CP" size="5" value="<?php echo $potongan['CP']; ?>" readonly /> &nbsp;%
                    &nbsp;&nbsp;&nbsp;(30% / Bulan)
                </td>
            </tr>
            <tr>
                <td class="key" rowspan="2">Hukuman Disiplin</td>
                <td>
                	<select name="SelDIS" onchange="HitungDIS(this.value)">
                    	<option value="0" <?php if ($potongan['DIS'] == 0) echo "SELECTED"; ?>>Tidak</option>
                        <option value="1" <?php if ($potongan['DIS'] == 20) echo "SELECTED"; ?>>Hukuman Disiplin Ringan Ke-1</option>
                        <option value="2" <?php if ($potongan['DIS'] == 30) echo "SELECTED"; ?>>Hukuman Disiplin Ringan Ke-2</option>
                        <option value="3" <?php if ($potongan['DIS'] == 40) echo "SELECTED"; ?>>Hukuman Disiplin Ringan Ke-3</option>
                        <option value="4" <?php if ($potongan['DIS'] == 40) echo "SELECTED"; ?>>Hukuman Disiplin Sedang Ke-1</option>
                        <option value="5" <?php if ($potongan['DIS'] == 50) echo "SELECTED"; ?>>Hukuman Disiplin Sedang Ke-2</option>
                        <option value="6" <?php if ($potongan['DIS'] == 60) echo "SELECTED"; ?>>Hukuman Disiplin Sedang Ke-3</option>
                        <option value="7" <?php if ($potongan['DIS'] == 60) echo "SELECTED"; ?>>Hukuman Disiplin Berat Ke-1</option>
                        <option value="8" <?php if ($potongan['DIS'] == 70) echo "SELECTED"; ?>>Hukuman Disiplin Berat Ke-2</option>
                        <option value="9" <?php if ($potongan['DIS'] == 80) echo "SELECTED"; ?>>Hukuman Disiplin Berat Ke-3</option>
                        <option value="10" <?php if ($potongan['DIS'] == 100) echo "SELECTED"; ?>>Hukuman Disiplin Berat Ke-4</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td><input type="text" name="DIS" id="DIS" size="5" value="<?php echo $potongan['DIS']; ?>" readonly /> &nbsp;%</td>
            </tr>
            <tr>
                <td class="key" rowspan="2">Diberhentikan Sementara</td>
                <td>
                	<select name="SelBS" onchange="HitungBS(this.value)">
                    	<option value="0" <?php if ($potongan['BS'] == 0) echo "SELECTED"; ?>>Tidak</option>
                        <option value="1" <?php if ($potongan['BS'] == 100) echo "SELECTED"; ?>>Ya</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>
                	<input type="text" name="BS" id="BS" size="5" value="<?php echo $potongan['BS']; ?>" readonly /> &nbsp;%
                    &nbsp;&nbsp;&nbsp;(100% / Bulan)
                </td>
            </tr>
            <tr>
                <td class="key">Keterangan</td>
                <td><textarea name="keterangan" cols="50" rows="3"><?php echo $potongan['keterangan']; ?></textarea></td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>
                    <div class="button2-right">
                        <div class="prev">
                            <a onclick="Cancel('index.php?p=475&<?php echo $url; ?>')">Batal</a>
                        </div>
                    </div>
                    <div class="button2-left">
                        <div class="next">
                            <a onclick="Btn_Submit('xPotongan');">Proses</a>
                        </div>
                    </div>
                    <div class="clr"></div>
                    <input style="border: 0pt none ; margin: 0pt; padding: 0pt; width: 0px; height: 0px;" value="Proses" type="submit">
                    <input name="xPotongan" type="hidden" value="1" />
                    <input name="q" type="hidden" value="<?php echo @$_GET['q']; ?>" />
                    <input name="u" type="hidden" value="<?php echo $_GET['u']; ?>" />
                    <input name="b" type="hidden" value="<?php echo $_GET['b']; ?>" />
                    <input name="s" type="hidden" value="<?php echo $_GET['s']; ?>" />
                </td>
            </tr>
        </table>
	</fieldset>
</form>