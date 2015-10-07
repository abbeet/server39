function EditRow(q, year, month, day, keterangan)
{
	var element = '#tr'+q;
	var tanggal = day + ' ' + month + ' ' + year;
	
	$(element+' td:nth-child(2)').text(tanggal);
	$(element+' td:nth-child(3)').text(keterangan);
}

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
					$('input[@name=id]').val(),
					$('select[@name=year] option:selected').text(),
					$('select[@name=month] option:selected').text(),
					$('select[@name=day] option:selected').text(),
					$('input[@name=keterangan]').val()
				);
				tb_remove();
			}
			else if (response.status == 3)
			{
				$('#divResult').text('Ubah data berhasil').css({'color':'#000000','background-color':'#FFFF00'}).fadeIn();				
				EditRow(
					$('input[@name=q]').val(),
					$('select[@name=year] option:selected').text(),
					$('select[@name=month] option:selected').text(),
					$('select[@name=day] option:selected').text(),
					$('input[@name=keterangan]').val()
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
					var str = '<tr id="tr_empty"><td align="center" colspan="6">Tidak ada data!</td></tr>';
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

function AddRow(q, year, month, day, keterangan, status)
{
	var tanggal = day + ' ' + month + ' ' + year;
   	var str = '<tr id="tr'+q+'">';
   	var countLine = Object($('#tableBody tr')).length;
	
	if (countLine == 1)
	{
		$('#tr_empty').remove();
		countLine = 0;
	}
	
   	str += '<td align="center">'+(countLine+1)+'</td>';
   	str += '<td align="center">'+tanggal+'</td>';
   	str += '<td>'+keterangan+'</td>';
   	str += '<td align="center"><a class="thickbox" href="menus/siapp/presensi/upacara_ed.php?q='+q+'&width=600&height=200" title="Ubah Upacara">';
   	str += '<img src="css/images/edit_f2.png" border="0" width="16" height="16">&nbsp;Ubah</a></td>';
   	str += '<td align="center"><a class="thickbox" href="menus/siapp/presensi/upacara_del.php?q='+q+'&width=600&height=200" title="Hapus Upacara">';
   	str += '<img src="css/images/stop_f2.png" border="0" width="16" height="16">&nbsp;Hapus</a></td>';
	str += '<td align="center" nowrap="nowrap"><a href="index.php?p=84&y='+year+'&up='+q+' title="Pegawai Tidak Hadir Upacara">';
	str += '<img src="css/images/view.gif" border="0" width="16" height="16">&nbsp;Tidak Hadir</a></td>';
   	str += '</tr>';
   
   	$('#tableBody').append(str);

   	tb_init('#tr'+q+' td a.thickbox');
}