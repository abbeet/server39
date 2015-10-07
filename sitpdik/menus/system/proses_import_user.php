
   <?php $p = 110; ?>
<h1>Import User dari SKP</h1>
<br />
<form method="post" name="xuser" action="index.php?p=<?php echo enkripsi($p); ?>">
	<table class="admintable" cellspacing="1">
    <tr>
    <td colspan="2">
    <h1>Perhatian data User akan di Import dari aplikasi SKP....!!!!</h1>
    </td>
    </tr>
        <tr>
			<td></td>
			<td>			
				<div class="button2-right">
					
				</div>
				<div class="button2-left">
					<div class="next">
						<a onclick="Btn_Submit('xuser')">Proses</a>
					</div>
				</div>
				<div class="clr"></div>
				<input type="submit" style="border: 0pt none ; margin: 0pt; padding: 0pt; width: 0px; height: 0px;" value="Proses" />
				
			</td>
		</tr>
        
	</table>
</form>



