<?php
	checkauthentication();
	$p = $_GET['p'];
	$cari = $_GET['cari'];
	$table = "v_grade_skp";
	$field = get_field($table);
	$ed_link = "index.php?p=".get_edit_link($p);
	$del_link = "index.php?p=299";
	#Halaman yang akan ditampilkan untuk pertengahan?
	$adjacents = 3;
 	$th = $_SESSION['xth'];
	$xlevel = $_SESSION['xlevel'];
	$xusername = $_SESSION['xusername'];
	$xkdunit = $_SESSION['xkdunit'];

if ( $_REQUEST['cari'] )
{
	$xkdunit = $_REQUEST['xkdunit'];
}	
?>
	
<?php if ( $xlevel == '1' ) {?>
<div align="left">
	<form action="" method="post">
		<input type="hidden" name="p" value="<?php echo $p; ?>" />
		Unit Kerja : 
		<select name="xkdunit">
                      <option value="<?php echo $xkdunit ?>"><?php echo  skt_unitkerja($xkdunit) ?></option>
                      <option value="">- Pilih Unit Kerja -</option>
                    <?php
							$query = mysql_query("select left(kdunit,2) as kode_unit ,sktunit from kd_unitkerja where ( kdunit <> '0000' or kdunit <> '1000' or kdunit <> '2000' or kdunit <> '3000' or kdunit <> '4000' or kdunit <> '5000' ) group by left(kdunit,2) order by kdunit");
					
						while($row = mysql_fetch_array($query)) { ?>
                      <option value="<?php echo $row['kode_unit'] ?>"><?php echo  $row['sktunit']; ?></option>
                    <?php
					} ?>	
	  </select>
		<input type="submit" value="Cari" name="cari"/>
	</form>
</div>
<?php }?>
<br />
<table width="58%" cellpadding="1" class="adminlist">
	<thead>
		<tr>
			<th width="13%">No.</th>
			<th width="41%">Kelas Jabatan </th>
			<th width="26%">Jumlah</th>
        </tr>
	</thead>
	<tbody>
<?php 
	$no = 0 ;
	$oList = mysql_query("SELECT count(nib) as jumlah, klsjabatan FROM $table WHERE tahun = '$th' and left(kdunitkerja,2) = '$xkdunit' GROUP BY klsjabatan ORDER BY klsjabatan desc");
			brek;
	while($List = mysql_fetch_array($oList)) {
	$no += 1 ;
	$jumlah = $List['jumlah'] ;
	$total += $jumlah ;
?>
				<tr class="<?php echo $class ?>">
					<td align="center" valign="top"><?php echo $no.'.' ?></td>
					<td align="left" valign="top"><?php echo 'Kelas Jabatan '.$List['klsjabatan'] ?></td>
					<td align="center" valign="top"><?php echo $jumlah ?></td>
			    </tr>
<?php } ?>
				<tr class="<?php echo $class ?>">
				  <td align="center" valign="top">&nbsp;</td>
				  <td align="center" valign="top"><strong>Jumlah Pegawai</strong></td>
				  <td align="center" valign="top"><strong><?php echo $total ?></strong></td>
	  </tr>
	</tbody>
	<tfoot>
		<tr>
			<td colspan="3">&nbsp;</td>
		</tr>
	</tfoot>
</table>
