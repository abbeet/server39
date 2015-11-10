<?php
	checkauthentication();
	$p = $_GET['p'];
	$cari = $_GET['cari'];
	$table = "d_item";
	$field = get_field($table);
	$ed_link = "index.php?p=".get_edit_link($p);
	$del_link = "index.php?p=".get_delete_link($p);
	
	$th = $_SESSION['xth'];
	$bl = date('m');
	if (substr($bl,0,1) == '0')  $bl = substr($bl,1,1);
	if (substr($bl,0,1) <> '0')  $bl = $bl;
if (substr($bl,0,1) == '0')  $bl = substr($bl,1,1);
	if (substr($bl,0,1) <> '0')  $bl = $bl;
switch ( $bl )
	{
		case 1:
		$kdtriwulan = 1;
		break;
		case 2:
		$kdtriwulan = 1;
		break;
		case 3:
		$kdtriwulan = 1;
		break;
		case 4:
		$kdtriwulan = 2;
		break;
		case 5:
		$kdtriwulan = 2;
		break;
		case 6:
		$kdtriwulan = 2;
		break;
		case 7:
		$kdtriwulan = 3;
		break;
		case 8:
		$kdtriwulan = 3;
		break;
		case 9:
		$kdtriwulan = 3;
		break;
		case 10:
		$kdtriwulan = 4;
		break;
		case 11:
		$kdtriwulan = 4;
		break;
		case 12:
		$kdtriwulan = 4;
		break;
	}	
		
	if($cari=='') $kdtriwulan = $kdtriwulan;
	
	if($_REQUEST['cari']){
		$kdtriwulan = $_REQUEST['kdtriwulan'];
	}

	$sql_menteri = "select sum(JUMLAH) as pagu_menteri from $table WHERE THANG='$th' AND KDDEPT = '084'";
	$aMenteri = mysql_query($sql_menteri);
	$Menteri = mysql_fetch_array($aMenteri);
	$pegawai = anggaran_belanja_menteri($th,'51');
	$barang = anggaran_belanja_menteri($th,'52');
	$modal = anggaran_belanja_menteri($th,'53');
	$perjalanan = anggaran_belanja_menteri($th,'524');

	$sql = "select THANG, KDSATKER, sum(jumlah) as pagu_satker from $table  WHERE THANG = '$th' group by KDSATKER";
	$aSatker = mysql_query($sql);
	$count = mysql_num_rows($aSatker);
	$jmlh = 0;
	
	while ($Satker = mysql_fetch_array($aSatker))
	{
		$col[0][] 	= $Satker['THANG'];
		$col[1][] 	= $Satker['KDSATKER'];
		$col[2][] 	= $Satker['pagu_satker'];
		$jmlh 	   += $Satker['pagu_satker'];
	}

?>
	<form action="" method="get">
		<input type="hidden" name="p" value="<?php echo $p; ?>" />
		Sampai dengan Triwulan : 
		<select name="kdtriwulan"><?php
									
					for ($i = 1; $i <= 4; $i++)
					{ ?>
						<option value="<?php echo $i; ?>" <?php if ($i == $kdtriwulan) echo "selected"; ?>><?php echo 'Triwulan '.nmromawi($i) ?></option><?php
					} ?>	
	  </select>
		<input type="submit" value="Tampilkan" name="cari"/>
	</form>
<br />
<table width="787" cellpadding="1" class="adminlist">
  <thead>
    
    <tr>
      <th rowspan="2">Unit Eselon II</th>
      <th rowspan="2">Kode APBN</th>
      <th rowspan="2"><font color="#006600">Lembaga</font><br />Nama Satuan Kerja / <br>
        <font color="#0000FF">Nama Kegiatan</font> / <br /><font color="#993333">Output</font></th>
      <th rowspan="2">Pagu Anggaran</th>
      <th colspan="3">Belanja Pegawai </th>
      <th colspan="3">Belanja Barang </th>
      <th colspan="3">Belanja Modal</th>
      <th colspan="3">Belanja Perjalanan</th>
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
      <th width="5%">Rupiah</th>
      <th width="10%">(%)</th>
    </tr>
  </thead>
  <tbody>
  <?php 
	$pagu_menteri = pagu_menteri($th) ;
	$real_menteri_sdtriwulan_51 = real_menteri_sdtriwulan_jnsbel($th,$kdtriwulan,'51') ;
	$real_menteri_sdtriwulan_52 = real_menteri_sdtriwulan_jnsbel($th,$kdtriwulan,'52') ;
	$real_menteri_sdtriwulan_53 = real_menteri_sdtriwulan_jnsbel($th,$kdtriwulan,'53') ;
	$real_menteri_sdtriwulan_524 = real_menteri_sdtriwulan_jnsbel($th,$kdtriwulan,'524') ;
	$real_menteri = $real_menteri_sdtriwulan_51 + $real_menteri_sdtriwulan_52 + $real_menteri_sdtriwulan_53 + $real_menteri_sdtriwulan_524 ;
  ?>
    <tr>
      <td align="center">&nbsp;</td>
      <td align="center" valign="top"><font color="#009900"><strong><?php echo '084' ?></strong></font></td>
      <td align="left"><font color="#009900"><strong><?php echo strtoupper(nm_unit('840000')) ?></strong></font></td>
      <td align="right" valign="top"><font color="#009900"><strong><?php echo number_format($pagu_menteri,"0",",",".") ?></strong></font></td>
      <td align="right" valign="top"><font color="#009900"><strong><?php echo number_format($pegawai,"0",",",".") ?></strong></font></td>
      <td align="right" valign="top"><font color="#009900"><strong><?php echo number_format($real_menteri_sdtriwulan_51,"0",",",".") ?></strong></font></td>
      <td align="right" valign="top"><font color="#009900"><strong><?php echo number_format($pegawai-$real_menteri_sdtriwulan_51,"0",",",".") ?></strong></font></td>
      <td align="right" valign="top"><font color="#009900"><strong><?php echo number_format($barang,"0",",",".") ?></strong></font></td>
      <td align="right" valign="top"><font color="#009900"><strong><?php echo number_format($real_menteri_sdtriwulan_52,"0",",",".") ?></strong></font></td>
      <td align="right" valign="top"><font color="#009900"><strong><?php echo number_format($barang-$real_menteri_sdtriwulan_52,"0",",",".") ?></strong></font></td>
      <td align="right" valign="top"><font color="#009900"><strong><?php echo number_format($modal,"0",",",".") ?></strong></font></td>
      <td align="right" valign="top"><font color="#009900"><strong><?php echo number_format($real_menteri_sdtriwulan_53,"0",",",".") ?></td>
      <td align="right" valign="top"><font color="#009900"><strong><?php echo number_format($modal-$real_menteri_sdtriwulan_53,"0",",",".") ?></td>
      <td align="right" valign="top"><font color="#009900"><strong><?php echo number_format($perjalanan,"0",",",".") ?></strong></font></td>
      <td align="right" valign="top"><font color="#009900"><strong><?php echo number_format($real_menteri_sdtriwulan_524,"0",",",".") ?></td>
      <td align="right" valign="top"><font color="#009900"><strong><?php echo number_format($perjalanan-$real_menteri_sdtriwulan_524,"0",",",".") ?></td>
      <td align="right" valign="top"><font color="#009900"><strong><?php echo number_format($real_menteri,"0",",",".") ?></strong></font></td>
      <td align="center" valign="top"><font color="#009900"><strong><?php echo number_format($real_menteri/$pagu_menteri*100,"2",",",".") ?></strong></font></td>
      <td align="right" valign="top"><font color="#009900"><strong><?php echo number_format($pagu_menteri-$real_menteri,"0",",",".") ?></td>
    </tr>
    <?php
		if ($count == 0) 
		{ ?>
    <tr> 
      <td align="center" colspan="19">Tidak ada data!</td>
    </tr>
    <?php
		}
		else {
			foreach ($col[0] as $k=>$val) {
				if ($k % 2 == 1) $class = "row0";
				else $class = "row0"; ?>
    <tr class="<?php echo $class ?>">
      <td width="6%" align="center">&nbsp;</td> 
	<?php 
	$pegawai_satker = anggaran_belanja_satker($col[0][$k],$col[1][$k],'51') ;
	$barang_satker = anggaran_belanja_satker($col[0][$k],$col[1][$k],'52') ;
	$modal_satker = anggaran_belanja_satker($col[0][$k],$col[1][$k],'53') ;
	$perjalanan_satker = anggaran_belanja_satker($col[0][$k],$col[1][$k],'524') ;
	$real_satker_sdtriwulan_51 = real_satker_sdtriwulan_jnsbel($th,$col[1][$k],$kdtriwulan,'51') ;
	$real_satker_sdtriwulan_52 = real_satker_sdtriwulan_jnsbel($th,$col[1][$k],$kdtriwulan,'52') ;
	$real_satker_sdtriwulan_53 = real_satker_sdtriwulan_jnsbel($th,$col[1][$k],$kdtriwulan,'53') ;
	$real_satker_sdtriwulan_524 = real_satker_sdtriwulan_jnsbel($th,$col[1][$k],$kdtriwulan,'524') ;
	$real_satker = $real_satker_sdtriwulan_51+$real_satker_sdtriwulan_52+$real_satker_sdtriwulan_53+$real_satker_sdtriwulan_524;
	?>
      <td width="6%" align="center" valign="top"><strong><?php echo $col[1][$k] ?></strong></td>
      <td width="54%" align="left"><strong><?php echo nm_satker($col[1][$k]) ?></strong></td>
      <td width="12%" align="right" valign="top"><strong><?php echo number_format($col[2][$k],"0",",",".") ?></strong></td>
      <td width="6%" align="right" valign="top"><strong><?php echo number_format($pegawai_satker,"0",",",".") ?></strong></td>
      <td width="5%" align="right" valign="top"><strong><?php echo number_format($real_satker_sdtriwulan_51,"0",",",".") ?></strong></td>
      <td width="5%" align="right" valign="top"><strong><?php echo number_format($pegawai_satker-$real_satker_sdtriwulan_51,"0",",",".") ?></strong></td>
      <td width="6%" align="right" valign="top"><strong><?php echo number_format($barang_satker,"0",",",".") ?></strong></td>
      <td width="5%" align="right" valign="top"><strong><?php echo number_format($real_satker_sdtriwulan_52,"0",",",".") ?></strong></td>
      <td width="5%" align="right" valign="top"><strong><?php echo number_format($barang_satker-$real_satker_sdtriwulan_52,"0",",",".") ?></strong></td>
      <td width="2%" align="right" valign="top"><strong><?php echo number_format($modal_satker,"0",",",".") ?></strong></td>
      <td width="2%" align="right" valign="top"><strong><?php echo number_format($real_satker_sdtriwulan_53,"0",",",".") ?></strong></td>
      <td width="3%" align="right" valign="top"><strong><?php echo number_format($modal_satker-$real_satker_sdtriwulan_53,"0",",",".") ?></strong></td>
      <td width="2%" align="right" valign="top"><strong><?php echo number_format($perjalanan_satker,"0",",",".") ?></strong></td>
      <td width="2%" align="right" valign="top"><strong><?php echo number_format($real_satker_sdtriwulan_524,"0",",",".") ?></strong></td>
      <td width="3%" align="right" valign="top"><strong><?php echo number_format($perjalanan_satker-$real_satker_sdtriwulan_524,"0",",",".") ?></strong></td>
      <td align="right" valign="top"><strong><?php echo number_format($real_satker,"0",",",".") ?></strong></td>
      <td align="center" valign="top"><strong><?php echo number_format($real_satker/$col[2][$k]*100,"2",",",".") ?></strong></td>
      <td align="right" valign="top"><strong><?php echo number_format($col[2][$k]-$real_satker,"0",",",".") ?></strong></td>
    </tr>
    <?php 
	$kdsatker = $col[1][$k] ;
	$sql = "select a.THANG, a.KDGIAT, sum(a.jumlah) as pagu_giat, b.kdunitkerja from $table a LEFT OUTER JOIN m_kegiatan b ON ( a.KDGIAT = b.kdgiat and a.THANG = b.th )  WHERE a.THANG = '$th' and a.KDSATKER = '$kdsatker' group by a.KDGIAT order by b.kdunitkerja";
	$aGiat = mysql_query($sql);
	while ($Giat = mysql_fetch_array($aGiat))
	{
	$pegawai_giat  = anggaran_belanja_giat($col[0][$k],$col[1][$k],$Giat['KDGIAT'],'51') ;
	$barang_giat  = anggaran_belanja_giat($col[0][$k],$col[1][$k],$Giat['KDGIAT'],'52') ;
	$modal_giat  = anggaran_belanja_giat($col[0][$k],$col[1][$k],$Giat['KDGIAT'],'53') ;
	$perjalanan_giat  = anggaran_belanja_giat($col[0][$k],$col[1][$k],$Giat['KDGIAT'],'524') ;
	$real_giat_sdtriwulan_51 = real_giat_sdtriwulan_jnsbel($th,$kdsatker,$Giat['KDGIAT'],$kdtriwulan,'51') ;
	$real_giat_sdtriwulan_52 = real_giat_sdtriwulan_jnsbel($th,$kdsatker,$Giat['KDGIAT'],$kdtriwulan,'52') ;
	$real_giat_sdtriwulan_53 = real_giat_sdtriwulan_jnsbel($th,$kdsatker,$Giat['KDGIAT'],$kdtriwulan,'53') ;
	$real_giat_sdtriwulan_524 = real_giat_sdtriwulan_jnsbel($th,$kdsatker,$Giat['KDGIAT'],$kdtriwulan,'524') ;
	$real_giat = $real_giat_sdtriwulan_51+$real_giat_sdtriwulan_52+$real_giat_sdtriwulan_53+$real_giat_sdtriwulan_524;
?>
    <tr class="<?php echo $class ?>">
      <td align="left" valign="top"><?php if ( $Giat['kdunitkerja'] <> $kdunitkerja ) { ?><font color="#0000FF"><?php echo strtoupper(nm_unit($Giat['kdunitkerja'])) ?></font><?php }?></td> 
      <td align="center" valign="top"><font color="#0000FF"><?php echo $Giat['KDGIAT'] ?></font></td>
      <td align="left" valign="top"><font color="#0000FF"><?php echo nm_giat($Giat['KDGIAT']) ?></font></td>
      <td align="right" valign="top"><font color="#0000FF"><?php echo number_format($Giat['pagu_giat'],"0",",",".") ?></font></td>
      <td align="right" valign="top"><font color="#0033CC"><?php echo number_format($pegawai_giat,"0",",",".") ?></font></td>
      <td align="right" valign="top"><font color="#0033CC"><?php echo number_format($real_giat_sdtriwulan_51,"0",",",".") ?></font></td>
      <td align="right" valign="top"><font color="#0033CC"><?php echo number_format($pegawai_giat-$real_giat_sdtriwulan_51,"0",",",".") ?></font></td>
      <td align="right" valign="top"><font color="#0033CC"><?php echo number_format($barang_giat,"0",",",".") ?></font></td>
      <td align="right" valign="top"><font color="#0033CC"><?php echo number_format($real_giat_sdtriwulan_52,"0",",",".") ?></font></td>
      <td align="right" valign="top"><font color="#0033CC"><?php echo number_format($barang_giat-$real_giat_sdtriwulan_52,"0",",",".") ?></font></td>
      <td align="right" valign="top"><font color="#0033CC"><?php echo number_format($modal_giat,"0",",",".") ?></font></td>
      <td align="right" valign="top"><font color="#0033CC"><?php echo number_format($real_giat_sdtriwulan_53,"0",",",".") ?></font></td>
      <td align="right" valign="top"><font color="#0033CC"><?php echo number_format($modal_giat-$real_giat_sdtriwulan_53 ,"0",",",".") ?></font></td>
      <td align="right" valign="top"><font color="#0033CC"><?php echo number_format($perjalanan_giat,"0",",",".") ?></font></td>
      <td align="right" valign="top"><font color="#0033CC"><?php echo number_format($real_giat_sdtriwulan_524,"0",",",".") ?></font></td>
      <td align="right" valign="top"><font color="#0033CC"><?php echo number_format($perjalanan_giat-$real_giat_sdtriwulan_524,"0",",",".") ?></font></td>
      <td align="right" valign="top"><font color="#0033CC"><?php echo number_format($real_giat,"0",",",".") ?></font></td>
      <td align="right" valign="top"><font color="#0033CC"><?php echo number_format($real_giat/$Giat['pagu_giat']*100,"2",",",".") ?></font></td>
      <td align="right" valign="top"><font color="#0033CC"><?php echo number_format($Giat['pagu_giat']-$real_giat,"0",",",".") ?></font></td>
    </tr>
    <?php 
	$kdunitkerja = $Giat['kdunitkerja'] ;
	$sql = "select KDOUTPUT, sum(jumlah) as pagu_output from $table WHERE THANG='$th' and KDSATKER='$kdsatker' and KDGIAT = '$Giat[KDGIAT]' group by KDOUTPUT";
	$aOutput = mysql_query($sql);
	while ($Output = mysql_fetch_array($aOutput))
	{
	$pegawai_output = anggaran_belanja_output($col[0][$k],$col[1][$k],$Giat['KDGIAT'],$Output['KDOUTPUT'],'51');
	$barang_output = anggaran_belanja_output($col[0][$k],$col[1][$k],$Giat['KDGIAT'],$Output['KDOUTPUT'],'52');
	$modal_output = anggaran_belanja_output($col[0][$k],$col[1][$k],$Giat['KDGIAT'],$Output['KDOUTPUT'],'53');
	$perjalanan_output = anggaran_belanja_output($col[0][$k],$col[1][$k],$Giat['KDGIAT'],$Output['KDOUTPUT'],'524');
	$real_output_sdtriwulan_51 = real_output_sdtriwulan_jnsbel($th,$kdsatker,$Giat['KDGIAT'],$Output['KDOUTPUT'],$kdtriwulan,'51') ;
	$real_output_sdtriwulan_52 = real_output_sdtriwulan_jnsbel($th,$kdsatker,$Giat['KDGIAT'],$Output['KDOUTPUT'],$kdtriwulan,'52') ;
	$real_output_sdtriwulan_53 = real_output_sdtriwulan_jnsbel($th,$kdsatker,$Giat['KDGIAT'],$Output['KDOUTPUT'],$kdtriwulan,'53') ;
	$real_output_sdtriwulan_524 = real_output_sdtriwulan_jnsbel($th,$kdsatker,$Giat['KDGIAT'],$Output['KDOUTPUT'],$kdtriwulan,'524') ;
	$real_output = $real_output_sdtriwulan_51+$real_output_sdtriwulan_52+$real_output_sdtriwulan_53+$real_output_sdtriwulan_524;
?>
    <tr class="<?php echo $class ?>">
      <td align="center" valign="top">&nbsp;</td>
      <td align="center" valign="top"><font color="#993333"><?php echo $Output['KDOUTPUT'] ?></font></td>
      <td align="left" valign="top"><font color="#993333"><?php echo nm_output_th($th,$Giat['KDGIAT'].$Output['KDOUTPUT']) ?></font></td>
      <td align="right" valign="top"><font color="#993333"><?php echo number_format($Output['pagu_output'],"0",",",".") ?></font></td>
      <td align="right" valign="top"><font color="#990033"><?php echo number_format($pegawai_output,"0",",",".") ?></font></td>
      <td align="right" valign="top"><font color="#990033"><?php echo number_format($real_output_sdtriwulan_51,"0",",",".") ?></font></td>
      <td align="right" valign="top"><font color="#990033"><?php echo number_format($pegawai_output-$real_output_sdtriwulan_51,"0",",",".") ?></font></td>
      <td align="right" valign="top"><font color="#990033"><?php echo number_format($barang_output,"0",",",".") ?></font></td>
      <td align="right" valign="top"><font color="#990033"><?php echo number_format($real_output_sdtriwulan_52,"0",",",".") ?></font></td>
      <td align="right" valign="top"><font color="#990033"><?php echo number_format($barang_output-$real_output_sdtriwulan_52,"0",",",".") ?></font></td>
      <td align="right" valign="top"><font color="#990033"><?php echo number_format($modal_output,"0",",",".") ?></font></td>
      <td align="right" valign="top"><font color="#990033"><?php echo number_format($real_output_sdtriwulan_53,"0",",",".") ?></font></td>
      <td align="right" valign="top"><font color="#990033"><?php echo number_format($modal_output-$real_output_sdtriwulan_53,"0",",",".") ?></font></td>
      <td align="right" valign="top"><font color="#990033"><?php echo number_format($perjalanan_output,"0",",",".") ?></font></td>
      <td align="right" valign="top"><font color="#990033"><?php echo number_format($real_output_sdtriwulan_524,"0",",",".") ?></font></td>
      <td align="right" valign="top"><font color="#990033"><?php echo number_format($perjalanan_output-$real_output_sdtriwulan_524,"0",",",".") ?></font></td>
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
      <td colspan="19">&nbsp;</td>
    </tr>
  </tfoot>
</table>
<?php 
function anggaran_belanja_menteri($th,$jnsbel) {
		
		switch ( $jnsbel )
		{
			case '51' :
				$sql = "select sum(JUMLAH) as pagu_satker from d_item WHERE THANG='$th' AND
				left(KDAKUN,2) = '51' AND KDDEPT = '048' group by THANG";
				break;
			case '52' :
				$sql = "select sum(JUMLAH) as pagu_satker from d_item WHERE THANG='$th' AND left(KDAKUN,2) = '52' 
				AND left(KDAKUN,3) <> '524' AND KDDEPT = '048' group by THANG";
				break;
			case '53' :
				$sql = "select sum(JUMLAH) as pagu_satker from d_item WHERE THANG='$th' AND
				left(KDAKUN,2) = '53' AND KDDEPT = '048' group by THANG";
				break;
			case '524' :
				$sql = "select sum(JUMLAH) as pagu_satker from d_item WHERE THANG='$th' AND 
				left(KDAKUN,3) = '524' AND KDDEPT = '048' group by THANG";
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
				AND KDGIAT = '$kdgiat' AND left(KDAKUN,2) = '51' group by KDSATKER";
				break;
			case '52' :
				$sql = "select sum(JUMLAH) as pagu_satker from d_item WHERE THANG='$th' AND KDSATKER = '$kdsatker' AND 
				KDGIAT = '$kdgiat' AND left(KDAKUN,2) = '52' AND left(KDAKUN,3) <> '524' group by KDSATKER";
				break;
			case '53' :
				$sql = "select sum(JUMLAH) as pagu_satker from d_item WHERE THANG='$th' AND KDSATKER = '$kdsatker' AND 
				left(KDAKUN,2) = '53' AND KDGIAT = '$kdgiat' group by KDSATKER";
				break;
			case '524' :
				$sql = "select sum(JUMLAH) as pagu_satker from d_item WHERE THANG='$th' AND KDSATKER = '$kdsatker' AND 
				left(KDAKUN,3) = '524' AND KDGIAT = '$kdgiat' group by KDSATKER";
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
				AND KDGIAT = '$kdgiat' AND left(KDAKUN,2) = '51' AND KDOUTPUT= '$kdoutput' group by KDSATKER";
				break;
			case '52' :
				$sql = "select sum(JUMLAH) as pagu_satker from d_item WHERE THANG='$th' AND KDSATKER = '$kdsatker' AND 
				KDGIAT = '$kdgiat' AND left(KDAKUN,2) = '52' AND left(KDAKUN,3) <> '524'  AND KDOUTPUT= '$kdoutput' 
				group by KDSATKER";
				break;
			case '53' :
				$sql = "select sum(JUMLAH) as pagu_satker from d_item WHERE THANG='$th' AND KDSATKER = '$kdsatker' AND 
				left(KDAKUN,2) = '53' AND KDGIAT = '$kdgiat'  AND KDOUTPUT= '$kdoutput' group by KDSATKER";
				break;
			case '524' :
				$sql = "select sum(JUMLAH) as pagu_satker from d_item WHERE THANG='$th' AND KDSATKER = '$kdsatker' AND 
				left(KDAKUN,3) = '524' AND KDGIAT = '$kdgiat'  AND KDOUTPUT= '$kdoutput' group by KDSATKER";
				break;
		}	
		$data = mysql_query($sql);
		$rdata = mysql_fetch_array($data);
		$result = $rdata['pagu_satker'];
		return $result;
}

?>