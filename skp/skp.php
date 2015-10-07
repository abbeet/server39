<?php
	mysql_connect("localhost", "root", "bidsi");
	mysql_select_db("dbskp_batan");
	
	$sql = "SELECT * FROM dtl_skp ORDER BY id_skp";
	$query = mysql_query($sql); ?>
	
	<table border="1" cellpadding="0" cellspacing="0">
		<tr>
			<td>id</td>
			<td>id_skp</td>
			<td>no_tugas</td>
			<td>nama_tugas</td>
			<td>ak_target</td>
			<td>jumlah_target</td>
			<td>satuan_jumlah</td>
			<td>kualitas_target</td>
			<td>waktu_target</td>
			<td>satuan_waktu</td>
			<td>biaya_target</td>
			<td>ak_real</td>
			<td>jumlah_real</td>
			<td>kualitas_real</td>
			<td>waktu_real</td>
			<td>biaya_real</td>
			<td>id_if</td>
			<td>no_urut</td>
		</tr><?php
	
		while ($rows = mysql_fetch_object($query))
		{
			$sql2 = "SELECT * FROM mst_skp WHERE id = '".$rows->id_skp."'";
			$query2 = mysql_query($sql2);
			$num2 = mysql_num_rows($query2);
			
			if ($num2 == 0)
			{ 
				#echo $sql2."<BR>"; ?>
			
				<tr>
					<td><?php echo $rows->id; ?></td>
					<td><?php echo $rows->id_skp; ?></td>
					<td><?php echo $rows->no_tugas; ?></td>
					<td><?php echo $rows->nama_tugas; ?></td>
					<td><?php echo $rows->ak_target; ?></td>
					<td><?php echo $rows->jumlah_target; ?></td>
					<td><?php echo $rows->satuan_jumlah; ?></td>
					<td><?php echo $rows->kualitas_target; ?></td>
					<td><?php echo $rows->waktu_target; ?></td>
					<td><?php echo $rows->satuan_waktu; ?></td>
					<td><?php echo $rows->biaya_target; ?></td>
					<td><?php echo $rows->ak_real; ?></td>
					<td><?php echo $rows->jumlah_real; ?></td>
					<td><?php echo $rows->kualitas_real; ?></td>
					<td><?php echo $rows->waktu_real; ?></td>
					<td><?php echo $rows->biaya_real; ?></td>
					<td><?php echo $rows->id_if; ?></td>
					<td><?php echo $rows->no_urut; ?></td>
				</tr><?php
				
			}
		} ?>
	
	</table>
