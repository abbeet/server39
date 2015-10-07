function Edit()
{
	$('#divResult').text('loading...').fadeIn();
	$('#formData').ajaxSubmit(
	{
		success: function(response)
		{
			$('#divResult').hide();
			if (response.status == 1)
			{
				$('#divResult').text(response.text).css({'color':'#FFFFFF','background-color':'#FF0000'}).fadeIn();				
			}
			else if (response.status == 2)
			{
				$('#divResult').text('Ubah data berhasil').css({'color':'#000000','background-color':'#FFFF00'}).fadeIn();				
				AddRow(
					response.q,
					response.nip_baru,
					response.nama,
					$('input[@name=u]').val(),
					$('input[@name=y]').val(),
					$('select[@name=up] option:selected').val()
				);
				tb_remove();
			}
		}, 
		dataType: 'json'
	});
	return false;
}

function Delete()
{
	$('#divResult').text('loading...').fadeIn();
	$('#formData').ajaxSubmit(
	{
		success: function(response)
		{
			$('#divResult').hide();
			if (response.status == 1)
			{
				$('#divResult').text(response.text).css({'color':'#FFFFFF','background-color':'#FF0000'}).fadeIn();				
			}
			else if (response.status == 3)
			{
				var countLine = Object($('#tableBody tr')).length;
				
				if (countLine == 1)
				{
					var str = '<tr id="tr_empty"><td align="center" colspan="10">Tidak ada data!</td></tr>';
					$('#tableBody').append(str);
				}
				
				$('#tr'+response.q).remove();
				tb_remove();
			}
		}, 
		dataType: 'json'
	});
	return false;
}

function AddRow(q, nip_baru, nama, u, y, up)
{
   	var str = '<tr id="tr'+q+'">';
   	var countLine = Object($('#tableBody tr')).length;
	
	if (countLine == 1)
	{
		$('#tr_empty').remove();
		countLine = 0;
	}
	
   	str += '<td align="center">'+(countLine+1)+'</td>';
	str += '<td nowrap="nowrap">'+nama+'<br />'+nip_baru+'</td>';
	str += '<td align="center">UP</td>';
	str += '<td align="center" nowrap="nowrap"><a class="thickbox" href="menus/siapp/presensi/tidak_hadir_upacara_del.php?q='+q+'&u='+u+'&y='+y;
	str += '&up='+up+'&width=600&height=200" title="Hapus"><img src="css/images/stop_f2.png" border="0" width="16" height="16">&nbsp;Hapus</a></td>';
   	str += '</tr>';
   
   	$('#tableBody').append(str);

   	tb_init('#tr'+q+' td a.thickbox');
}