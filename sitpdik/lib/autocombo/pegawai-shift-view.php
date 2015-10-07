<?php
	include "../../includes/includes.php";

	$id = @$_GET['id']; ?>
	
	<select name="nip">
		<option></option><?php
		
		$oReguShift = regu_shift("kode_shift = '".@$id."'","kode_shift");
		
		while ($ReguShift = mysql_fetch_array(@$oReguShift))
		{
			$oReguAnggota = regu_anggota("regu = '".@$ReguShift['id']."'","nip");
			
			while ($ReguAnggota = mysql_fetch_array(@$oReguAnggota)) 
			{
				if (@$ReguShift['id'] != @$regu)
				{ ?>
					
					<optgroup label="<?php echo @$ReguShift['nama']; ?>"></optgroup><?php
				
				}
				
				$Pegawai = pegawai_id(@$ReguAnggota['nip']); ?>
				
				<option value="<?php echo @$Pegawai->nip; ?>"><?php 
					
					echo "[".substr(@$Pegawai->nip, -4)."] ".trim(@$Pegawai->nama); ?>
				
				</option><?php
				
				$regu = @$ReguShift['id'];
			}
		} ?>
	
	</select>