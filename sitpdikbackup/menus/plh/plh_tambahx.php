<?php
	#@
	checkauthentication();
	set_time_limit(6000);
	$err = false;
	$p = $_GET['p'];
	$form = @$_POST['form'];
	$date_from = @$_POST['date_from'];
	$date_until = @$_POST['date_until'];
	$unit_kerja = $_SESSION['unit_kerja'];
	$Session['xusername'] = $_SESSION['xusername'];
	
	?>

	<blockquote>
	  <form action="index.php?p=<?php echo $_GET['p']; ?>" method="post" name="xImport" enctype="multipart/form-data">
	    <table class="admintable" cellspacing="1">
	      
	      <tr>
	        <td class="key">Pimpinan</td>
	        <td>
	          <input name="nama_kapus" type="text" class="formAll" id="nama_kapus" size="50" readonly value="<?php echo $nama_kapus , $nip_kapus?>"/> 
	          </td>
	        </tr>
	      <tr>
	        <td class="key">PLH</td>
	        <td>
	          <select id="IdPenerima" name="IdPenerima">
	            <?php
			{
            $xuser=$user[Nama];
			$xuserx=$user[IdUser];
                echo "<option value='$xuserx'>
                    $xuser
                </option>";
            
            }
			?>
              </select>
            </td>
	        </tr>
	      
	      <tr>
	        <td class="key">Tanggal</td>
	        <td>
	          <input name="date_from" type="text" class="form" id="date_from" size="10" value=""/>&nbsp;
	          <img src="css/images/calbtn.gif" id="a_triggerIMG" hspace="5" title="Pilih Tanggal" /> 
	          <script type="text/javascript">
						Calendar.setup({
							inputField : "date_from",
							button : "a_triggerIMG",
							align : "BR",
							firstDay : 1,
							weekNumbers : false,
							singleClick : true,
							showOthers : true,
							ifFormat : "%Y-%m-%d"
						});
					</script>
	          
	          &nbsp; s.d &nbsp;
	          
	          <input name="date_until" type="text" class="form" id="date_until" size="10" value=""/>&nbsp;
	          <img src="css/images/calbtn.gif" id="b_triggerIMG" hspace="5" title="Pilih Tanggal" /> 
	          <script type="text/javascript">
						Calendar.setup({
							inputField : "date_until",
							button : "b_triggerIMG",
							align : "BR",
							firstDay : 1,
							weekNumbers : false,
							singleClick : true,
							showOthers : true,
							ifFormat : "%Y-%m-%d"
						});
					</script>
	          </td>
	        </tr>
	      
          <tr>
	        <td class="key">Status Delegasi</td>
	        <td>
	          <p>
                  <label>
                    <input type="radio" name="status" value="1" id="status1">
                    Wewenang Penuh</label>
                  <br>
                  <label>
                    <input type="radio" name="status" value="2" id="status2">
                    Wewenang Tidak Penuh</label>
                  <br>
              </p> 
	          </td>
	        </tr>
          
	      <tr>
	        <td>&nbsp;</td>
	        <td>
	          <div class="button2-right">
	            <div class="prev">
	              <a onclick="Cancel('index.php?p=1')">Batal</a>
	              </div>
	            </div>
	          <div class="button2-left">
	            <div class="next">
	              <a onclick="Btn_Submit('xImport');">Proses</a>
	              </div>
	            </div>
	          <div class="clr"></div>
	          <input style="border: 0pt none ; margin: 0pt; padding: 0pt; width: 0px; height: 0px;" value="Proses" type="submit">
	          <input name="xImport" type="hidden" value="1" />
	          <input name="q" type="hidden" value="<?php echo @$_GET['q']; ?>" />
	          </td>
	        </tr>
	      </table>
	    </form>
</blockquote>
