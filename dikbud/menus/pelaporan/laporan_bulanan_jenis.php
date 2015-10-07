<?php
	checkauthentication();
	$p = $_GET['p'];
	$cari = $_GET['cari'];
	$table = "d_item";
	$field = get_field($table);
	$ed_link = "index.php?p=".get_edit_link($p);
	$del_link = "index.php?p=".get_delete_link($p);
	$kddept = setup_kddept_keu() ;
	$kdunit = setup_kdunit_keu() ;
	$xlevel = $_SESSION['xlevel'];
	$xkdunit = $_SESSION['xkdunit'];
	$xusername = $_SESSION['xusername'] ;
	$th = $_SESSION['xth'];

	if ( $xlevel == 3 or $xlevel == 4 or $xlevel == 5 or $xlevel == 6 or $xlevel == 7 or $xlevel == 8 )
	{
	$kdsatker = kd_satker($xkdunit) ;
	$sql = "select kdsatker from tb_unitkerja WHERE kdsatker = '$kdsatker' order by kdunit";
	}else{
	$sql = "select kdsatker from tb_unitkerja WHERE kdsatker <> '' order by kdunit";
	}
	
	$bl = date('m');
	if (substr($bl,0,1) == '0')  $bl = substr($bl,1,1);
	if (substr($bl,0,1) <> '0')  $bl = $bl;

	if($cari=='') $kdbulan = $bl;
	
	if($_REQUEST['cari']){
		$kdbulan = $_REQUEST['kdbulan'];
	}

if ( $xlevel <> 3 and $xlevel <> 4 and $xlevel <> 5 and $xlevel <> 6 and $xlevel <> 7 and $xlevel <> 8 )
	{
	$sql_menteri = "select sum(JUMLAH) as pagu_menteri from $table WHERE THANG='$th' AND KDDEPT = '023'";
	$aMenteri = mysql_query($sql_menteri);
	$Menteri = mysql_fetch_array($aMenteri);
	$pegawai = anggaran_belanja_menteri($th,'51');
	$barang = anggaran_belanja_menteri($th,'52');
	$modal = anggaran_belanja_menteri($th,'53');
	$perjalanan = anggaran_belanja_menteri($th,'524');
	$sosial = anggaran_belanja_menteri($th,'57');
	}
	
	$aSatker = mysql_query($sql);
	$count = mysql_num_rows($aSatker);
	$jmlh = 0;
	
	while ($Satker = mysql_fetch_array($aSatker))
	{
		$pagu_satker = pagu_satker($th,$Satker['kdsatker']) ;
		if ( $pagu_satker > 0 )
		{
		$col[1][] 	= $Satker['kdsatker'];
		$col[2][] 	= $pagu_satker ;
		}
	}

?>
	<form action="" method="get">
		<input type="hidden" name="p" value="<?php echo $p; ?>" />
		Sampai dengan Bulan : 
		<select name="kdbulan"><?php
									
					for ($i = 1; $i <= 12; $i++)
					{ ?>
						<option value="<?php echo $i; ?>" <?php if ($i == $kdbulan) echo "selected"; ?>><?php echo nama_bulan($i) ?></option><?php
					} ?>	
	  </select>
		<input type="submit" value="Tampilkan" name="cari"/>
	</form>
<br />
<table width="787" cellpadding="1" class="adminlist">
  <thead>
    
    <tr>
      <th rowspan="2">Kode APBN</th>
      <th rowspan="2"><font color="#006600">Lembaga</font><br />Nama Satuan Kerja / <br>
        <font color="#0000FF">Nama Kegiatan</font> / <br /><font color="#993333">Output</font></th>
      <th rowspan="2">Pagu Anggaran</th>
      <th colspan="3">Belanja Pegawai </th>
      <th colspan="3">Belanja Barang </th>
      <th colspan="3">Belanja Modal</th>
      <th colspan="3">Belanja Perjalanan</th>
      <th colspan="3">Belanja Sosial</th>
      <th colspan="2">Realisasi Total </th>
      <th width="10%" rowspan="2">Sisa Anggaran</th>
    </tr>
    <tr>
      <th>Pagu</th>
      <th>Realisasi</th>
      <th>Sisa</th>
      <th>Pagu</th>
      <th>Realisasi</th>
      <th>Sisa</th>
      <th>Pagu</th>
      <th>Realisasi</th>
      <th>Sisa</th>
      <th>Pagu</th>
      <th>Realisasi</th>
      <th>Sisa</th>
      <th>Pagu</th>
      <th>Realisasi</th>
      <th>Sisa</th>
      <th width="5%">Rupiah</th>
      <th width="10%">(%)</th>
    </tr>
  </thead>
  <tbody>
  <?php 
if ( $xlevel <> 3 and $xlevel <> 4 and $xlevel <> 5 and $xlevel <> 6 and $xlevel <> 7 and $xlevel <> 8 )
	{
	$pagu_menteri = pagu_menteri($th) ;
	$real_menteri_sdbulan_51 = real_menteri_sdbulan_jnsbel($th,$kdbulan,'51') ;
	$real_menteri_sdbulan_52 = real_menteri_sdbulan_jnsbel($th,$kdbulan,'52') ;
	$real_menteri_sdbulan_53 = real_menteri_sdbulan_jnsbel($th,$kdbulan,'53') ;
	$real_menteri_sdbulan_524 = real_menteri_sdbulan_jnsbel($th,$kdbulan,'524') ;
	$real_menteri_sdbulan_57 = real_menteri_sdbulan_jnsbel($th,$kdbulan,'57') ;
	$real_menteri = $real_menteri_sdbulan_51 + $real_menteri_sdbulan_52 + $real_menteri_sdbulan_53 + $real_menteri_sdbulan_524 + $real_menteri_sdbulan_57;
  ?>
    <tr>
      <td align="center" valign="top"><font color="#009900"><strong><?php echo '023' ?></strong></font></td>
      <td align="left"><font color="#009900"><strong><?php echo strtoupper(nm_unit('2320000')) ?></strong></font></td>
      <td align="right" valign="top"><font color="#009900"><strong><?php echo number_format($pagu_menteri,"0",",",".") ?></strong></font></td>
      <td align="right" valign="top"><font color="#009900"><strong><?php echo number_format($pegawai,"0",",",".") ?></strong></font></td>
      <td align="right" valign="top"><font color="#009900"><strong><?php echo number_format($real_menteri_sdbulan_51,"0",",",".") ?></strong></font></td>
      <td align="right" valign="top"><font color="#009900"><strong><?php echo number_format($pegawai-$real_menteri_sdbulan_51,"0",",",".") ?></strong></font></td>
      <td align="right" valign="top"><font color="#009900"><strong><?php echo number_format($barang,"0",",",".") ?></strong></font></td>
      <td align="right" valign="top"><font color="#009900"><strong><?php echo number_format($real_menteri_sdbulan_52,"0",",",".") ?></strong></font></td>
      <td align="right" valign="top"><font color="#009900"><strong><?php echo number_format($barang-$real_menteri_sdbulan_52,"0",",",".") ?></strong></font></td>
      <td align="right" valign="top"><font color="#009900"><strong><?php echo number_format($modal,"0",",",".") ?></strong></font></td>
      <td align="right" valign="top"><font color="#009900"><strong><?php echo number_format($real_menteri_sdbulan_53,"0",",",".") ?></td>
      <td align="right" valign="top"><font color="#009900"><strong><?php echo number_format($modal-$real_menteri_sdbulan_53,"0",",",".") ?></td>
      <td align="right" valign="top"><font color="#009900"><strong><?php echo number_format($perjalanan,"0",",",".") ?></strong></font></td>
      <td align="right" valign="top"><font color="#009900"><strong><?php echo number_format($real_menteri_sdbulan_524,"0",",",".") ?></td>
      <td align="right" valign="top"><font color="#009900"><strong><?php echo number_format($perjalanan-$real_menteri_sdbulan_524,"0",",",".") ?></td>
      <td align="right" valign="top"><font color="#009900"><strong><?php echo number_format($sosial,"0",",",".") ?></strong></font></td>
      <td align="right" valign="top"><font color="#009900"><strong><?php echo number_format($real_menteri_sdbulan_57,"0",",",".") ?></td>
      <td align="right" valign="top"><font color="#009900"><strong><?php echo number_format($sosial-$real_menteri_sdbulan_57,"0",",",".") ?></td>
      <td align="right" valign="top"><font color="#009900"><strong><?php echo number_format($real_menteri,"0",",",".") ?></strong></font></td>
      <td align="center" valign="top"><font color="#009900"><strong><?php echo number_format($real_menteri/$pagu_menteri*100,"2",",",".") ?></strong></font></td>
      <td align="right" valign="top"><font color="#009900"><strong><?php echo number_format($pagu_menteri-$real_menteri,"0",",",".") ?></td>
    </tr>
    <?php
	}  # endif satker
		if ($count == 0) 
		{ ?>
    <tr> 
      <td align="center" colspan="21">Tidak ada data!</td>
    </tr>
    <?php
		}
		else {
			foreach ($col[1] as $k=>$val) {
				if ($k % 2 == 1) $class = "row0";
				else $class = "row0"; ?>
    <tr class="<?php echo $class ?>">
      <?php 
	$pegawai_satker = anggaran_belanja_satker($th,$col[1][$k],'51') ;
	$barang_satker = anggaran_belanja_satker($th,$col[1][$k],'52') ;
	$modal_satker = anggaran_belanja_satker($th,$col[1][$k],'53') ;
	$perjalanan_satker = anggaran_belanja_satker($th,$col[1][$k],'524') ;
	$sosial_satker = anggaran_belanja_satker($th,$col[1][$k],'57') ;
	$real_satker_sdbulan_51 = real_satker_sdbulan_jnsbel($th,$col[1][$k],$kdbulan,'51') ;
	$real_satker_sdbulan_52 = real_satker_sdbulan_jnsbel($th,$col[1][$k],$kdbulan,'52') ;
	$real_satker_sdbulan_53 = real_satker_sdbulan_jnsbel($th,$col[1][$k],$kdbulan,'53') ;
	$real_satker_sdbulan_524 = real_satker_sdbulan_jnsbel($th,$col[1][$k],$kdbulan,'524') ;
	$real_satker_sdbulan_57 = real_satker_sdbulan_jnsbel($th,$col[1][$k],$kdbulan,'57') ;
	$real_satker = $real_satker_sdbulan_51+$real_satker_sdbulan_52+$real_satker_sdbulan_53+$real_satker_sdbulan_524+$real_satker_sdbulan_57;
	?>
      <td width="6%" align="center" valign="top"><strong><?php echo $col[1][$k] ?></strong></td>
      <td width="54%" align="left"><strong><?php echo nm_satker($col[1][$k]) ?></strong></td>
      <td width="12%" align="right" valign="top"><strong><?php echo number_format($col[2][$k],"0",",",".") ?></strong></td>
      <td width="6%" align="right" valign="top"><strong><?php echo number_format($pegawai_satker,"0",",",".") ?></strong></td>
      <td width="5%" align="right" valign="top"><strong><?php echo number_format($real_satker_sdbulan_51,"0",",",".") ?></strong></td>
      <td width="5%" align="right" valign="top"><strong><?php echo number_format($pegawai_satker-$real_satker_sdbulan_51,"0",",",".") ?></strong></td>
      <td width="6%" align="right" valign="top"><strong><?php echo number_format($barang_satker,"0",",",".") ?></strong></td>
      <td width="5%" align="right" valign="top"><strong><?php echo number_format($real_satker_sdbulan_52,"0",",",".") ?></strong></td>
      <td width="5%" align="right" valign="top"><strong><?php echo number_format($barang_satker-$real_satker_sdbulan_52,"0",",",".") ?></strong></td>
      <td width="2%" align="right" valign="top"><strong><?php echo number_format($modal_satker,"0",",",".") ?></strong></td>
      <td width="2%" align="right" valign="top"><strong><?php echo number_format($real_satker_sdbulan_53,"0",",",".") ?></strong></td>
      <td width="3%" align="right" valign="top"><strong><?php echo number_format($modal_satker-$real_satker_sdbulan_53,"0",",",".") ?></strong></td>
      <td width="2%" align="right" valign="top"><strong><?php echo number_format($perjalanan_satker,"0",",",".") ?></strong></td>
      <td width="2%" align="right" valign="top"><strong><?php echo number_format($real_satker_sdbulan_524,"0",",",".") ?></strong></td>
      <td width="3%" align="right" valign="top"><strong><?php echo number_format($perjalanan_satker-$real_satker_sdbulan_524,"0",",",".") ?></strong></td>
      <td width="3%" align="right" valign="top"><strong><?php echo number_format($sosial_satker,"0",",",".") ?></strong></td>
      <td width="3%" align="right" valign="top"><strong><?php echo number_format($real_satker_sdbulan_57,"0",",",".") ?></strong></td>
      <td width="3%" align="right" valign="top"><strong><?php echo number_format($sosial_satker-$real_satker_sdbulan_57,"0",",",".") ?></strong></td>
      <td align="right" valign="top"><strong><?php echo number_format($real_satker,"0",",",".") ?></strong></td>
      <td align="center" valign="top"><strong><?php echo number_format($real_satker/$col[2][$k]*100,"2",",",".") ?></strong></td>
      <td align="right" valign="top"><strong><?php echo number_format($col[2][$k]-$real_satker,"0",",",".") ?></strong></td>
    </tr>
    <?php 
	$kdsatker = $col[1][$k] ;
	$sql = "select KDGIAT, sum(jumlah) as pagu_giat from $table  WHERE THANG = '$th' and KDSATKER = '$kdsatker' group by KDGIAT order by KDGIAT";
	$aGiat = mysql_query($sql);
	while ($Giat = mysql_fetch_array($aGiat))
	{
	$pegawai_giat  = anggaran_belanja_giat($th,$col[1][$k],$Giat['KDGIAT'],'51') ;
	$barang_giat  = anggaran_belanja_giat($th,$col[1][$k],$Giat['KDGIAT'],'52') ;
	$modal_giat  = anggaran_belanja_giat($th,$col[1][$k],$Giat['KDGIAT'],'53') ;
	$perjalanan_giat  = anggaran_belanja_giat($th,$col[1][$k],$Giat['KDGIAT'],'524') ;
	$sosial_giat  = anggaran_belanja_giat($th,$col[1][$k],$Giat['KDGIAT'],'57') ;
	$real_giat_sdbulan_51 = real_giat_sdbulan_jnsbel($th,$kdsatker,$Giat['KDGIAT'],$kdbulan,'51') ;
	$real_giat_sdbulan_52 = real_giat_sdbulan_jnsbel($th,$kdsatker,$Giat['KDGIAT'],$kdbulan,'52') ;
	$real_giat_sdbulan_53 = real_giat_sdbulan_jnsbel($th,$kdsatker,$Giat['KDGIAT'],$kdbulan,'53') ;
	$real_giat_sdbulan_524 = real_giat_sdbulan_jnsbel($th,$kdsatker,$Giat['KDGIAT'],$kdbulan,'524') ;
	$real_giat_sdbulan_57 = real_giat_sdbulan_jnsbel($th,$kdsatker,$Giat['KDGIAT'],$kdbulan,'57') ;
	$real_giat = $real_giat_sdbulan_51+$real_giat_sdbulan_52+$real_giat_sdbulan_53+$real_giat_sdbulan_524+$real_giat_sdbulan_57;
?>
    <tr class="<?php echo $class ?>">
      <td align="center" valign="top"><font color="#0000FF"><?php echo $Giat['KDGIAT'] ?></font></td>
      <td align="left" valign="top"><font color="#0000FF"><?php echo nm_giat($Giat['KDGIAT']) ?></font></td>
      <td align="right" valign="top"><font color="#0000FF"><?php echo number_format($Giat['pagu_giat'],"0",",",".") ?></font></td>
      <td align="right" valign="top"><font color="#0033CC"><?php echo number_format($pegawai_giat,"0",",",".") ?></font></td>
      <td align="right" valign="top"><font color="#0033CC"><?php echo number_format($real_giat_sdbulan_51,"0",",",".") ?></font></td>
      <td align="right" valign="top"><font color="#0033CC"><?php echo number_format($pegawai_giat-$real_giat_sdbulan_51,"0",",",".") ?></font></td>
      <td align="right" valign="top"><font color="#0033CC"><?php echo number_format($barang_giat,"0",",",".") ?></font></td>
      <td align="right" valign="top"><font color="#0033CC"><?php echo number_format($real_giat_sdbulan_52,"0",",",".") ?></font></td>
      <td align="right" valign="top"><font color="#0033CC"><?php echo number_format($barang_giat-$real_giat_sdbulan_52,"0",",",".") ?></font></td>
      <td align="right" valign="top"><font color="#0033CC"><?php echo number_format($modal_giat,"0",",",".") ?></font></td>
      <td align="right" valign="top"><font color="#0033CC"><?php echo number_format($real_giat_sdbulan_53,"0",",",".") ?></font></td>
      <td align="right" valign="top"><font color="#0033CC"><?php echo number_format($modal_giat-$real_giat_sdbulan_53 ,"0",",",".") ?></font></td>
      <td align="right" valign="top"><font color="#0033CC"><?php echo number_format($perjalanan_giat,"0",",",".") ?></font></td>
      <td align="right" valign="top"><font color="#0033CC"><?php echo number_format($real_giat_sdbulan_524,"0",",",".") ?></font></td>
      <td align="right" valign="top"><font color="#0033CC"><?php echo number_format($perjalanan_giat-$real_giat_sdbulan_524,"0",",",".") ?></font></td>
      <td align="right" valign="top"><font color="#0033CC"><?php echo number_format($sosial_giat,"0",",",".") ?></font></td>
      <td align="right" valign="top"><font color="#0033CC"><?php echo number_format($real_giat_sdbulan_57,"0",",",".") ?></font></td>
      <td align="right" valign="top"><font color="#0033CC"><?php echo number_format($sosial_giat-$real_giat_sdbulan_57,"0",",",".") ?></font></td>
      <td align="right" valign="top"><font color="#0033CC"><?php echo number_format($real_giat,"0",",",".") ?></font></td>
      <td align="right" valign="top"><font color="#0033CC"><?php echo number_format($real_giat/$Giat['pagu_giat']*100,"2",",",".") ?></font></td>
      <td align="right" valign="top"><font color="#0033CC"><?php echo number_format($Giat['pagu_giat']-$real_giat,"0",",",".") ?></font></td>
    </tr>
    <?php 
	$sql = "select KDOUTPUT, sum(jumlah) as pagu_output from $table WHERE THANG='$th' and KDSATKER='$kdsatker' and KDGIAT = '$Giat[KDGIAT]' group by KDOUTPUT";
	$aOutput = mysql_query($sql);
	while ($Output = mysql_fetch_array($aOutput))
	{
	$pegawai_output = anggaran_belanja_output($th,$col[1][$k],$Giat['KDGIAT'],$Output['KDOUTPUT'],'51');
	$barang_output = anggaran_belanja_output($th,$col[1][$k],$Giat['KDGIAT'],$Output['KDOUTPUT'],'52');
	$modal_output = anggaran_belanja_output($th,$col[1][$k],$Giat['KDGIAT'],$Output['KDOUTPUT'],'53');
	$perjalanan_output = anggaran_belanja_output($th,$col[1][$k],$Giat['KDGIAT'],$Output['KDOUTPUT'],'524');
	$sosial_output = anggaran_belanja_output($th,$col[1][$k],$Giat['KDGIAT'],$Output['KDOUTPUT'],'57');
	$real_output_sdbulan_51 = real_output_sdbulan_jnsbel($th,$kdsatker,$Giat['KDGIAT'],$Output['KDOUTPUT'],$kdbulan,'51') ;
	$real_output_sdbulan_52 = real_output_sdbulan_jnsbel($th,$kdsatker,$Giat['KDGIAT'],$Output['KDOUTPUT'],$kdbulan,'52') ;
	$real_output_sdbulan_53 = real_output_sdbulan_jnsbel($th,$kdsatker,$Giat['KDGIAT'],$Output['KDOUTPUT'],$kdbulan,'53') ;
	$real_output_sdbulan_524 = real_output_sdbulan_jnsbel($th,$kdsatker,$Giat['KDGIAT'],$Output['KDOUTPUT'],$kdbulan,'524') ;
	$real_output_sdbulan_57 = real_output_sdbulan_jnsbel($th,$kdsatker,$Giat['KDGIAT'],$Output['KDOUTPUT'],$kdbulan,'57') ;
	$real_output = $real_output_sdbulan_51+$real_output_sdbulan_52+$real_output_sdbulan_53+$real_output_sdbulan_524+$real_output_sdbulan_57;
?>
    <tr class="<?php echo $class ?>">
      <td align="center" valign="top"><font color="#993333"><?php echo $Output['KDOUTPUT'] ?></font></td>
      <td align="left" valign="top"><font color="#993333"><?php echo nm_output_th($th,$Giat['KDGIAT'].$Output['KDOUTPUT']) ?></font></td>
      <td align="right" valign="top"><font color="#993333"><?php echo number_format($Output['pagu_output'],"0",",",".") ?></font></td>
      <td align="right" valign="top"><font color="#990033"><?php echo number_format($pegawai_output,"0",",",".") ?></font></td>
      <td align="right" valign="top"><font color="#990033"><?php echo number_format($real_output_sdbulan_51,"0",",",".") ?></font></td>
      <td align="right" valign="top"><font color="#990033"><?php echo number_format($pegawai_output-$real_output_sdbulan_51,"0",",",".") ?></font></td>
      <td align="right" valign="top"><font color="#990033"><?php echo number_format($barang_output,"0",",",".") ?></font></td>
      <td align="right" valign="top"><font color="#990033"><?php echo number_format($real_output_sdbulan_52,"0",",",".") ?></font></td>
      <td align="right" valign="top"><font color="#990033"><?php echo number_format($barang_output-$real_output_sdbulan_52,"0",",",".") ?></font></td>
      <td align="right" valign="top"><font color="#990033"><?php echo number_format($modal_output,"0",",",".") ?></font></td>
      <td align="right" valign="top"><font color="#990033"><?php echo number_format($real_output_sdbulan_53,"0",",",".") ?></font></td>
      <td align="right" valign="top"><font color="#990033"><?php echo number_format($modal_output-$real_output_sdbulan_53,"0",",",".") ?></font></td>
      <td align="right" valign="top"><font color="#990033"><?php echo number_format($perjalanan_output,"0",",",".") ?></font></td>
      <td align="right" valign="top"><font color="#990033"><?php echo number_format($real_output_sdbulan_524,"0",",",".") ?></font></td>
      <td align="right" valign="top"><font color="#990033"><?php echo number_format($perjalanan_output-$real_output_sdbulan_524,"0",",",".") ?></font></td>
      <td align="right" valign="top"><font color="#990033"><?php echo number_format($sosial_output,"0",",",".") ?></font></td>
      <td align="right" valign="top"><font color="#990033"><?php echo number_format($real_output_sdbulan_57,"0",",",".") ?></font></td>
      <td align="right" valign="top"><font color="#990033"><?php echo number_format($sosial_output-$real_output_sdbulan_57,"0",",",".") ?></font></td>
      <td align="right" valign="top"><font color="#990033"><?php echo number_format($real_output,"0",",",".") ?></font></td>
      <td align="center" valign="top"><font color="#990033"><?php echo number_format($real_output/$Output['pagu_output']*100,"2",",",".") ?></font></td>
      <td align="right" valign="top"><font color="#990033"><?php echo number_format($Output['pagu_output']-$real_output,"0",",",".") ?></font></td>
    </tr>
    <?php
		} # OUTPUT
		} # GIAT
		}
		} ?>
  </tbody>
  <tfoot>
    <tr> 
      <td colspan="21">&nbsp;</td>
    </tr>
  </tfoot>
</table>
<?php 
function anggaran_belanja_menteri($th,$jnsbel) {
		
		switch ( $jnsbel )
		{
			case '51' :
				$sql = "select sum(JUMLAH) as pagu_satker from d_item WHERE THANG='$th' AND
				left(KDAKUN,2) = '51' AND KDDEPT = '023' group by THANG";
				break;
			case '52' :
				$sql = "select sum(JUMLAH) as pagu_satker from d_item WHERE THANG='$th' AND left(KDAKUN,2) = '52' 
				AND left(KDAKUN,3) <> '524' AND KDDEPT = '023' group by THANG";
				break;
			case '53' :
				$sql = "select sum(JUMLAH) as pagu_satker from d_item WHERE THANG='$th' AND
				left(KDAKUN,2) = '53' AND KDDEPT = '023' group by THANG";
				break;
			case '57' :
				$sql = "select sum(JUMLAH) as pagu_satker from d_item WHERE THANG='$th' AND
				left(KDAKUN,2) = '57' AND KDDEPT = '023' group by THANG";
				break;	
			case '524' :
				$sql = "select sum(JUMLAH) as pagu_satker from d_item WHERE THANG='$th' AND 
				left(KDAKUN,3) = '524' AND KDDEPT = '023' group by THANG";
				break;
		}	
		$data = mysql_query($sql);
		$rdata = mysql_fetch_array($data);
		$result = $rdata['pagu_satker'];
		return $result;
}

function anggaran_belanja_satker($th,$kdsatker,$jnsbel) {
		
		switch ( $jnsbel )
		{
			case '51' :
				$sql = "select sum(JUMLAH) as pagu_satker from d_item WHERE THANG='$th' AND KDSATKER = '$kdsatker' AND 
				left(KDAKUN,2) = '51' group by KDSATKER";
				break;
			case '52' :
				$sql = "select sum(JUMLAH) as pagu_satker from d_item WHERE THANG='$th' AND KDSATKER = '$kdsatker' AND 
				left(KDAKUN,2) = '52' AND left(KDAKUN,3) <> '524' group by KDSATKER";
				break;
			case '53' :
				$sql = "select sum(JUMLAH) as pagu_satker from d_item WHERE THANG='$th' AND KDSATKER = '$kdsatker' AND 
				left(KDAKUN,2) = '53' group by KDSATKER";
				break;
			case '57' :
				$sql = "select sum(JUMLAH) as pagu_satker from d_item WHERE THANG='$th' AND KDSATKER = '$kdsatker' AND 
				left(KDAKUN,2) = '57' group by KDSATKER";	
			case '524' :
				$sql = "select sum(JUMLAH) as pagu_satker from d_item WHERE THANG='$th' AND KDSATKER = '$kdsatker' AND 
				left(KDAKUN,3) = '524' group by KDSATKER";
				break;
		}	
		$data = mysql_query($sql);
		$rdata = mysql_fetch_array($data);
		$result = $rdata['pagu_satker'];
		return $result;
}
function anggaran_belanja_giat($th,$kdsatker,$kdgiat,$jnsbel) {
		
		switch ( $jnsbel )
		{
			case '51' :
				$sql = "select sum(JUMLAH) as pagu_satker from d_item WHERE THANG='$th' AND KDSATKER = '$kdsatker' 
				AND KDGIAT = '$kdgiat' AND left(KDAKUN,2) = '51' group by KDGIAT";
				break;
			case '52' :
				$sql = "select sum(JUMLAH) as pagu_satker from d_item WHERE THANG='$th' AND KDSATKER = '$kdsatker' AND 
				KDGIAT = '$kdgiat' AND left(KDAKUN,2) = '52' AND left(KDAKUN,3) <> '524' group by KDGIAT";
				break;
			case '53' :
				$sql = "select sum(JUMLAH) as pagu_satker from d_item WHERE THANG='$th' AND KDSATKER = '$kdsatker' AND 
				left(KDAKUN,2) = '53' AND KDGIAT = '$kdgiat' group by KDGIAT";
				break;
			case '57' :
				$sql = "select sum(JUMLAH) as pagu_satker from d_item WHERE THANG='$th' AND KDSATKER = '$kdsatker' AND 
				left(KDAKUN,2) = '57' AND KDGIAT = '$kdgiat' group by KDGIAT";
				break;	
			case '524' :
				$sql = "select sum(JUMLAH) as pagu_satker from d_item WHERE THANG='$th' AND KDSATKER = '$kdsatker' AND 
				left(KDAKUN,3) = '524' AND KDGIAT = '$kdgiat' group by KDGIAT";
				break;
		}	
		$data = mysql_query($sql);
		$rdata = mysql_fetch_array($data);
		$result = $rdata['pagu_satker'];
		return $result;
}

function anggaran_belanja_output($th,$kdsatker,$kdgiat,$kdoutput,$jnsbel) {
		
		switch ( $jnsbel )
		{
			case '51' :
				$sql = "select sum(JUMLAH) as pagu_satker from d_item WHERE THANG='$th' AND KDSATKER = '$kdsatker' 
				AND KDGIAT = '$kdgiat' AND left(KDAKUN,2) = '51' AND KDOUTPUT= '$kdoutput' group by KDOUTPUT";
				break;
			case '52' :
				$sql = "select sum(JUMLAH) as pagu_satker from d_item WHERE THANG='$th' AND KDSATKER = '$kdsatker' AND 
				KDGIAT = '$kdgiat' AND left(KDAKUN,2) = '52' AND left(KDAKUN,3) <> '524'  AND KDOUTPUT= '$kdoutput' 
				group by KDOUTPUT";
				break;
			case '53' :
				$sql = "select sum(JUMLAH) as pagu_satker from d_item WHERE THANG='$th' AND KDSATKER = '$kdsatker' AND 
				left(KDAKUN,2) = '53' AND KDGIAT = '$kdgiat'  AND KDOUTPUT= '$kdoutput' group by KDOUTPUT";
				break;
			case '57' :
				$sql = "select sum(JUMLAH) as pagu_satker from d_item WHERE THANG='$th' AND KDSATKER = '$kdsatker' AND 
				left(KDAKUN,2) = '57' AND KDGIAT = '$kdgiat'  AND KDOUTPUT= '$kdoutput' group by KDOUTPUT";
				break;	
			case '524' :
				$sql = "select sum(JUMLAH) as pagu_satker from d_item WHERE THANG='$th' AND KDSATKER = '$kdsatker' AND 
				left(KDAKUN,3) = '524' AND KDGIAT = '$kdgiat'  AND KDOUTPUT= '$kdoutput' group by KDOUTPUT";
				break;
		}	
		$data = mysql_query($sql);
		$rdata = mysql_fetch_array($data);
		$result = $rdata['pagu_satker'];
		return $result;
}

?>