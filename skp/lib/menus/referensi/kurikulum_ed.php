<?php
	$Diklat = $this->DbQuery->t_diklat_id($id_diklat);
	
	if (in_array($this->session->userdata('xlevel'), $this->DbQuery->xmenu_edit($w)) and $Diklat->status_approval == 0)
	{ ?>
	
		<form name="<?php echo $w.'_ed' ?>" method="post" action="<?php echo base_url().'index.php/'.$w.'/ed/'.$back.'/'.$id_diklat.'/'.$q ?>" enctype="multipart/form-data">
			<input name="<?php echo $w.'_ed' ?>" type="hidden" value="1" />
			
			<table class="admintable" cellspacing="1">
				<tr>
					<td class="key">Mata Pelajaran</td>
					<td><input name="mata_pelajaran" type="text" size="65" value="<?php echo @$value['mata_pelajaran'] ?>" /></td>
				</tr>
				<tr>
					<td class="key">Materi</td>
					<td>
						<input type="radio" name="jenis" value="dasar" <?php if (@$value['jenis'] == 'dasar') echo 'checked="checked"' ?> /> Materi Dasar&nbsp;&nbsp;
						<input type="radio" name="jenis" value="utama" <?php if (@$value['jenis'] == 'utama') echo 'checked="checked"' ?> /> Materi Utama&nbsp;&nbsp;
						<input type="radio" name="jenis" value="praktikum" <?php if (@$value['jenis'] == 'praktikum') echo 'checked="checked"' ?> /> Praktikum&nbsp;&nbsp;
						<input type="radio" name="jenis" value="mandiri" <?php if (@$value['jenis'] == 'mandiri') echo 'checked="checked"' ?> /> Tugas Mandiri&nbsp;&nbsp;
						<input type="radio" name="jenis" value="penunjang" <?php if (@$value['jenis'] == 'penunjang') echo 'checked="checked"' ?> /> Materi Penunjang&nbsp;&nbsp;
						<input type="radio" name="jenis" value="lain-lain" <?php if (@$value['jenis'] == 'lain-lain') echo 'checked="checked"' ?> /> Lain-Lain&nbsp;&nbsp;
					</td>
				</tr>
				<tr>
					<td class="key">Jumlah Jam*</td>
					<td><input name="jumlah_jam" type="text" size="10" value="<?php echo @$value['jumlah_jam'] ?>" /></td>
				</tr>
				<tr>
					<td class="key">Pengajar/Pembimbing/Asisten</td>
					<td><input name="pengajar" type="text" size="65" value="<?php echo @$value['pengajar'] ?>" /></td>
				</tr>
				<tr>
					<td class="key">File</td>
					<td><input name="file" type="file" size="65" /></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>
						<input name="<?php echo $w.'_ed' ?>" type="submit" value="Simpan" style="border: 0pt none; margin: 0pt; padding: 0pt; width: 0px; height: 0px;" />
						<div class="button2-right">
							<div class="prev">
								<a onclick="Back('<?php echo $b ?>')">Kembali</a>
							</div>
						</div>
						<div class="button2-left">
							<div class="next">
								<a onclick="<?php echo $w ?>_ed.submit();">Simpan</a>
							</div>
						</div>
						<div class="clr"></div>
					</td>
				</tr>
			</table>
		</form>

		<br />
		<br /><?php
	}
	else
	{ ?>
	
		<table class="admintable" cellspacing="1">
			<tr>
				<td>&nbsp;</td>
				<td>
					<input name="<?php echo $w.'_ed' ?>" type="submit" value="Simpan" style="border: 0pt none; margin: 0pt; padding: 0pt; width: 0px; height: 0px;" />
					<div class="button2-right">
						<div class="prev">
							<a onclick="Back('<?php echo $b ?>')">Kembali</a>
						</div>
					</div>
					<div class="clr"></div>
				</td>
			</tr>
		</table><?php
	
	}

	$this->load->view('perencanaan/kurikulum', $page); ?>