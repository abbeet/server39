<?php
	checkauthentication();
	$table = "thbp_kak_kegiatan";
	$field = get_field($table);
	$err = false;
	$p = $_GET['p'];
	extract($_POST);
	$xusername_sess = $_SESSION['xusername'];
	
	$xmenu_p = xmenu_id($p);
	$p_next = $xmenu_p->parent;
	
	if (isset($form)) 
	{		
		if ($err != true) 
		{
			$sql = "SELECT kdgiat,kdunitkerja FROM m_ikk_kegiatan GROUP BY kdunitkerja,kdgiat ORDER BY kdunitkerja,kdgiat"; 
			$qu = mysql_query($sql);
				
			#hapus dulu datanya
			$sql = "DELETE FROM thbp_kak_kegiatan WHERE th = '".$tahun."'";
			mysql_query($sql);
			
			$sql = "DELETE FROM thbp_kak_output WHERE th = '".$tahun."'";
			mysql_query($sql);
			
			while ($row = mysql_fetch_array($qu))
			{
				$sql = "SELECT kdunitkerja, kddept, kdunit, kdprogram FROM tb_giat WHERE kdgiat = '".$row['kdgiat']."'";
				$qu2 = mysql_query($sql);
				$row2 = mysql_fetch_array($qu2);
				
				$sql = "SELECT dana_".tahun_ke($tahun)." as dana FROM m_aldana_kegiatan WHERE kdgiat = '".$row['kdgiat']."'";
				$qu3 = mysql_query($sql);
				$row3 = mysql_fetch_array($qu3);
				
				#$sql = "SELECT id FROM thbp_kak_kegiatan WHERE th = '".$tahun."' AND kdunitkerja = '".$row2['kdunitkerja']."' AND kdgiat = '".$row['kdgiat']."' AND kddept = '".$row2['kddept']."' AND kdunit = '".$row2['kdunit']."' AND kdprogram = '".$row2['kdprogram']."' AND jml_anggaran = '".$row3['dana']."'";
				#$cek = mysql_query($sql);
				
				
				## Mengisi tabel thbp_kak_kegiatan
				#if (mysql_num_rows($cek) == 0)
				#{
					$sql = "INSERT INTO thbp_kak_kegiatan VALUES ('','".$tahun."','".$row['kdunitkerja']."','".$row2['kddept']."','".$row2['kdunit']."','".$row2['kdprogram']."','".$row['kdgiat']."','".$row3['dana']."')";# echo $sql.";<br>";
					mysql_query($sql);
				#}
				
				$thnn = $tahun - 1;
				$sql = "SELECT kdoutput, target_".tahun_ke($thnn)." as volume1, target_".tahun_ke($tahun)." as volume2, masuk_renja FROM m_ikk_kegiatan WHERE kdgiat = '".$row['kdgiat']."' AND masuk_renja = '1' ORDER BY kdoutput";
				$qu4 = mysql_query($sql);
				
				
				while ($row4 = mysql_fetch_array($qu4))
				{
					$volume = $row4['volume2'] - $row4['volume1'];
					#$sql = "SELECT id FROM thbp_kak_output WHERE th = '".$tahun."' AND kdunitkerja = '".$row2['kdunitkerja']."' AND kdgiat = '".$row['kdgiat']."' AND kdoutput = '".$row4['kdoutput']."' AND volume = '".$volume."'";
					#$cek = mysql_query($sql);

					## Mengisi tabel thbp_kak_output
					#if (mysql_num_rows($cek) == 0)
					#{ 
						$thnn = $tahun - 1;
						$kodee = $row['kdgiat'].$row4['kdoutput'];
						$anggaran = anggaran_output($thnn, $kodee);
						$sql = "INSERT INTO thbp_kak_output VALUES ('','".$tahun."','".$row2['kdunitkerja']."','".$row['kdgiat']."','".$row4['kdoutput']."','".$anggaran."','".$row4['volume']."','')"; #echo $sql.";<br>";
						mysql_query($sql);
					#}
				}
			} ?>
			
			<meta http-equiv="refresh" content="0;URL=index.php?p=<?php echo $p_next ?>&cari=<?php echo $tahun; ?>"><?php
		}
	} ?>

<form action="index.php?p=<?php echo $_GET['p'] ?>" method="post" name="form">
	<table width="721" cellspacing="1" class="admintable">
		<tr>
		  	<td class="key">Tahun</td>
		  	<td>
		  		<select name="tahun"><?php
					for ($i = date("Y")-10; $i <= date("Y")+10; $i++)
					{ ?>
						<option value="<?php echo $i; ?>" <?php if ($i == date ("Y") + 1 ) echo "selected"; ?>><?php echo $i ; ?></option><?php
					} ?>
				</select>
		  	</td>
	  	</tr>
		<tr>
			<td>&nbsp;</td>
			<td>			
				<div class="button2-right">
					<div class="prev">
						<a onclick="Cancel('index.php?p=<?php echo $p_next ?>')">Batal</a>
					</div>
				</div>
				<div class="button2-left">
					<div class="next">
						<a onclick="form.submit();">Proses</a>
					</div>
				</div>
				<div class="clr"></div>
				<input style="border: 0pt none ; margin: 0pt; padding: 0pt; width: 0px; height: 0px;" value="Simpan" type="submit">
				<input name="form" type="hidden" value="1" />
			</td>
		</tr>
  </table>
</form>
<?php 
	function tahun_ke($tahun) {
		if( $tahun == 2010 ) $th_ke = 1 ;
		if( $tahun == 2011 ) $th_ke = 2 ;
		if( $tahun == 2012 ) $th_ke = 3 ;
		if( $tahun == 2013 ) $th_ke = 4 ;
		if( $tahun == 2014 ) $th_ke = 5 ;
		return $th_ke;
	}
?>
