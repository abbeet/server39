<table class="adminlist" cellpadding="1">
	<thead>
		<tr>
			<th width="4%">#</th>
			<th>Mata Pelajaran</th>
			<th width="15%">Jumlah Jam*</th>
			<th width="25%">Pengajar/Pembimbing/Asisten</th>
			<th width="4%">File</th>
			<th colspan="2" width="6%">Aksi</th>
		</tr>
	</thead>
	<tbody><?php
	
		if ($num_rows == 0)
		{ ?>
			<tr><td align="center" colspan="7">Tidak ada data!</td></tr><?php
		}
		else
		{
			$class = "row0";
			$l = 1;
			$total_jam = 0;
			$ed = 'index.php/'.$w.'/ed/'.$back.'/'.$id_diklat.'/';
			$del = 'index.php/'.$w.'/del/'.$back.'/'.$id_diklat.'/';
			
			if ($num_rows_dasar != 0)
			{ ?>
			
				<tr class="row1">
					<td>&nbsp;</td>
					<td><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Materi Dasar</b></td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td colspan="2">&nbsp;</td>
				</tr><?php
				
				foreach ($col_dasar['id'] as $k=>$val)
				{ ?>
					
					<tr class="<?php echo $class ?>">
						<td align="center"><?php echo $l++ ?></td>
						<td><?php echo $col_dasar['mata_pelajaran'][$k] ?></td>
						<td align="center"><?php echo $col_dasar['jumlah_jam'][$k] ?></td>
						<td><?php echo $col_dasar['pengajar'][$k] ?></td>
						<td align="center"><?php
						
							if ($col_dasar['file'][$k] != "")
							{ ?>
								<a href="<?php echo base_url().'materi/'.$col_dasar['file'][$k] ?>" title="Download Materi" target="_blank">
									<img src="css/images/upload.png" border="0" width="16" height="16">
								</a><?php
							
							} ?>
							
						</td><?php
						
						$Diklat = $this->DbQuery->t_diklat_id($id_diklat);
						
						if (in_array($this->session->userdata('xlevel'), $this->DbQuery->xmenu_edit($w)) and $Diklat->status_approval == 0)
						{ ?>
						
							<td align="center">
								<a href="<?php echo $ed.$col_dasar['id'][$k] ?>" title="Ubah">
									<img src="css/images/edit_f2.png" border="0" width="16" height="16">
								</a>
							</td><?php
							
						}
						else
						{ ?>
							
							<td>&nbsp;</td><?php
							
						}
						
						if (in_array($this->session->userdata('xlevel'), $this->DbQuery->xmenu_delete($w)) and $Diklat->status_approval == 0)
						{ ?>
						
							<td align="center">
								<a href="<?php echo $del.$col_dasar['id'][$k] ?>" title="Hapus">
									<img src="css/images/stop_f2.png" border="0" width="16" height="16">
								</a>
							</td><?php
							
						}
						else
						{ ?>
							
							<td>&nbsp;</td><?php
							
						} ?>
						
					</tr><?php
					
					$total_jam += $col_dasar['jumlah_jam'][$k];
				}
			}
			
			if ($num_rows_utama != 0)
			{ ?>
			
				<tr class="row1">
					<td>&nbsp;</td>
					<td><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Materi Utama</b></td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td colspan="2">&nbsp;</td>
				</tr><?php
				
				foreach ($col_utama['id'] as $k=>$val)
				{ ?>
					
					<tr class="<?php echo $class ?>">
						<td align="center"><?php echo $l++ ?></td>
						<td><?php echo $col_utama['mata_pelajaran'][$k] ?></td>
						<td align="center"><?php echo $col_utama['jumlah_jam'][$k] ?></td>
						<td><?php echo $col_utama['pengajar'][$k] ?></td>
						<td align="center"><?php
						
							if ($col_utama['file'][$k] != "")
							{ ?>
								<a href="<?php echo base_url().'materi/'.$col_utama['file'][$k] ?>" title="Download Materi" target="_blank">
									<img src="css/images/upload.png" border="0" width="16" height="16">
								</a><?php
							
							} ?>
							
						</td><?php
						
						if (in_array($this->session->userdata('xlevel'), $this->DbQuery->xmenu_edit($w)) and $Diklat->status_approval == 0)
						{ ?>
						
							<td align="center">
								<a href="<?php echo $ed.$col_utama['id'][$k] ?>" title="Ubah">
									<img src="css/images/edit_f2.png" border="0" width="16" height="16">
								</a>
							</td><?php
							
						}
						else
						{ ?>
							
							<td>&nbsp;</td><?php
							
						}
						
						if (in_array($this->session->userdata('xlevel'), $this->DbQuery->xmenu_delete($w)) and $Diklat->status_approval == 0)
						{ ?>
						
							<td align="center">
								<a href="<?php echo $del.$col_utama['id'][$k] ?>" title="Hapus">
									<img src="css/images/stop_f2.png" border="0" width="16" height="16">
								</a>
							</td><?php
							
						}
						else
						{ ?>
							
							<td>&nbsp;</td><?php
							
						} ?>
						
					</tr><?php
					
					$total_jam += $col_utama['jumlah_jam'][$k];
				}
			}
			
			if ($num_rows_praktikum != 0)
			{ ?>
			
				<tr class="row1">
					<td>&nbsp;</td>
					<td><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Praktikum</b></td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td colspan="2">&nbsp;</td>
				</tr><?php
				
				foreach ($col_praktikum['id'] as $k=>$val)
				{ ?>
					
					<tr class="<?php echo $class ?>">
						<td align="center"><?php echo $l++ ?></td>
						<td><?php echo $col_praktikum['mata_pelajaran'][$k] ?></td>
						<td align="center"><?php echo $col_praktikum['jumlah_jam'][$k] ?></td>
						<td><?php echo $col_praktikum['pengajar'][$k] ?></td>
						<td align="center"><?php
						
							if ($col_praktikum['file'][$k] != "")
							{ ?>
								<a href="<?php echo base_url().'materi/'.$col_praktikum['file'][$k] ?>" title="Download Materi" target="_blank">
									<img src="css/images/upload.png" border="0" width="16" height="16">
								</a><?php
							
							} ?>
							
						</td><?php
						
						if (in_array($this->session->userdata('xlevel'), $this->DbQuery->xmenu_edit($w)) and $Diklat->status_approval == 0)
						{ ?>
						
							<td align="center">
								<a href="<?php echo $ed.$col_praktikum['id'][$k] ?>" title="Ubah">
									<img src="css/images/edit_f2.png" border="0" width="16" height="16">
								</a>
							</td><?php
							
						}
						else
						{ ?>
							
							<td>&nbsp;</td><?php
							
						}
						
						if (in_array($this->session->userdata('xlevel'), $this->DbQuery->xmenu_delete($w)) and $Diklat->status_approval == 0)
						{ ?>
						
							<td align="center">
								<a href="<?php echo $del.$col_praktikum['id'][$k] ?>" title="Hapus">
									<img src="css/images/stop_f2.png" border="0" width="16" height="16">
								</a>
							</td><?php
							
						}
						else
						{ ?>
							
							<td>&nbsp;</td><?php
							
						} ?>
						
					</tr><?php
					
					$total_jam += $col_praktikum['jumlah_jam'][$k];
				}
			}
			
			if ($num_rows_mandiri != 0)
			{ ?>
			
				<tr class="row1">
					<td>&nbsp;</td>
					<td><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Tugas Mandiri</b></td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td colspan="2">&nbsp;</td>
				</tr><?php
				
				foreach ($col_mandiri['id'] as $k=>$val)
				{ ?>
					
					<tr class="<?php echo $class ?>">
						<td align="center"><?php echo $l++ ?></td>
						<td><?php echo $col_mandiri['mata_pelajaran'][$k] ?></td>
						<td align="center"><?php echo $col_mandiri['jumlah_jam'][$k] ?></td>
						<td><?php echo $col_mandiri['pengajar'][$k] ?></td>
						<td align="center"><?php
						
							if ($col_mandiri['file'][$k] != "")
							{ ?>
								<a href="<?php echo base_url().'materi/'.$col_mandiri['file'][$k] ?>" title="Download Materi" target="_blank">
									<img src="css/images/upload.png" border="0" width="16" height="16">
								</a><?php
							
							} ?>
							
						</td><?php
						
						if (in_array($this->session->userdata('xlevel'), $this->DbQuery->xmenu_edit($w)) and $Diklat->status_approval == 0)
						{ ?>
						
							<td align="center">
								<a href="<?php echo $ed.$col_mandiri['id'][$k] ?>" title="Ubah">
									<img src="css/images/edit_f2.png" border="0" width="16" height="16">
								</a>
							</td><?php
							
						}
						else
						{ ?>
							
							<td>&nbsp;</td><?php
							
						}
						
						if (in_array($this->session->userdata('xlevel'), $this->DbQuery->xmenu_delete($w)) and $Diklat->status_approval == 0)
						{ ?>
						
							<td align="center">
								<a href="<?php echo $del.$col_mandiri['id'][$k] ?>" title="Hapus">
									<img src="css/images/stop_f2.png" border="0" width="16" height="16">
								</a>
							</td><?php
							
						}
						else
						{ ?>
							
							<td>&nbsp;</td><?php
							
						} ?>
						
					</tr><?php
					
					$total_jam += $col_mandiri['jumlah_jam'][$k];
				}
			}
			
			if ($num_rows_penunjang != 0)
			{ ?>
			
				<tr class="row1">
					<td>&nbsp;</td>
					<td><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Materi Penunjang</b></td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td colspan="2">&nbsp;</td>
				</tr><?php
				
				foreach ($col_penunjang['id'] as $k=>$val)
				{ ?>
					
					<tr class="<?php echo $class ?>">
						<td align="center"><?php echo $l++ ?></td>
						<td><?php echo $col_penunjang['mata_pelajaran'][$k] ?></td>
						<td align="center"><?php echo $col_penunjang['jumlah_jam'][$k] ?></td>
						<td><?php echo $col_penunjang['pengajar'][$k] ?></td>
						<td align="center"><?php
						
							if ($col_penunjang['file'][$k] != "")
							{ ?>
								<a href="<?php echo base_url().'materi/'.$col_penunjang['file'][$k] ?>" title="Download Materi" target="_blank">
									<img src="css/images/upload.png" border="0" width="16" height="16">
								</a><?php
							
							} ?>
							
						</td><?php
						
						if (in_array($this->session->userdata('xlevel'), $this->DbQuery->xmenu_edit($w)) and $Diklat->status_approval == 0)
						{ ?>
						
							<td align="center">
								<a href="<?php echo $ed.$col_penunjang['id'][$k] ?>" title="Ubah">
									<img src="css/images/edit_f2.png" border="0" width="16" height="16">
								</a>
							</td><?php
							
						}
						else
						{ ?>
							
							<td>&nbsp;</td><?php
							
						}
						
						if (in_array($this->session->userdata('xlevel'), $this->DbQuery->xmenu_delete($w)) and $Diklat->status_approval == 0)
						{ ?>
						
							<td align="center">
								<a href="<?php echo $del.$col_penunjang['id'][$k] ?>" title="Hapus">
									<img src="css/images/stop_f2.png" border="0" width="16" height="16">
								</a>
							</td><?php
							
						}
						else
						{ ?>
							
							<td>&nbsp;</td><?php
							
						} ?>
						
					</tr><?php
					
					$total_jam += $col_penunjang['jumlah_jam'][$k];
				}
			}
			
			if ($num_rows_lain != 0)
			{ ?>
			
				<tr class="row1">
					<td>&nbsp;</td>
					<td><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Lain-Lain</b></td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td colspan="2">&nbsp;</td>
				</tr><?php
				
				foreach ($col_lain['id'] as $k=>$val)
				{ ?>
					
					<tr class="<?php echo $class ?>">
						<td align="center"><?php echo $l++ ?></td>
						<td><?php echo $col_lain['mata_pelajaran'][$k] ?></td>
						<td align="center"><?php echo $col_lain['jumlah_jam'][$k] ?></td>
						<td><?php echo $col_lain['pengajar'][$k] ?></td>
						<td align="center"><?php
						
							if ($col_lain['file'][$k] != "")
							{ ?>
								<a href="<?php echo base_url().'materi/'.$col_lain['file'][$k] ?>" title="Download Materi" target="_blank">
									<img src="css/images/upload.png" border="0" width="16" height="16">
								</a><?php
							
							} ?>
							
						</td><?php
						
						if (in_array($this->session->userdata('xlevel'), $this->DbQuery->xmenu_edit($w)) and $Diklat->status_approval == 0)
						{ ?>
						
							<td align="center">
								<a href="<?php echo $ed.$col_lain['id'][$k] ?>" title="Ubah">
									<img src="css/images/edit_f2.png" border="0" width="16" height="16">
								</a>
							</td><?php
							
						}
						else
						{ ?>
							
							<td>&nbsp;</td><?php
							
						}
						
						if (in_array($this->session->userdata('xlevel'), $this->DbQuery->xmenu_delete($w)) and $Diklat->status_approval == 0)
						{ ?>
						
							<td align="center">
								<a href="<?php echo $del.$col_lain['id'][$k] ?>" title="Hapus">
									<img src="css/images/stop_f2.png" border="0" width="16" height="16">
								</a>
							</td><?php
							
						}
						else
						{ ?>
							
							<td>&nbsp;</td><?php
							
						} ?>
						
					</tr><?php
					
					$total_jam += $col_lain['jumlah_jam'][$k];
				}
			}
		} ?>
	</tbody>
	<tfoot><?php
		if ($num_rows == 0)
		{ ?>
			<tr>
				<td colspan="7">&nbsp;</td>
			</tr><?php
		}
		else
		{ ?>
			<tr>
				<td colspan="2" align="right"><b>Total Jam</b></td>
				<td align="center"><b><?php echo $total_jam ?></b></td>
				<td>&nbsp;</td>
				<td colspan="3">&nbsp;</td>
			</tr><?php
			
		} ?>
		
	</tfoot>
</table>
<br>
<i>*) 1 jam pelajaran :<br>
&nbsp;&nbsp;- 45 menit untuk pelatihan reguler dan selingkung.<br>
&nbsp;&nbsp;- 60 menit untuk coaching.<br></i>
