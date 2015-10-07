function EditRow(q, year, month, day, keterangan, status)
{
	var element = '#tr'+q;
	var tanggal = day + ' ' + month + ' ' + year;
	
	$(element+' td:nth-child(2)').text(tanggal);
	$(element+' td:nth-child(3)').text(keterangan);
	$(element+' td:nth-child(4)').text(status);
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
					$('input[@name=keterangan]').val(),
					$('select[@name=status] option:selected').text()
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
					$('input[@name=keterangan]').val(),
					$('select[@name=status] option:selected').text()
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
   	str += '<td align="center">'+(countLine+1)+'</td>';
   	str += '<td align="center">'+tanggal+'</td>';
   	str += '<td>'+keterangan+'</td>';
   	str += '<td>'+status+'</td>';
   	str += '<td align="center"><a class="thickbox" href="menus/siapp/referensi/libur_ed.php?q='+q+'&width=600&height=200" title="Ubah Hari Libur">';
   	str += '<img src="css/images/edit_f2.png" border="0" width="16" height="16">&nbsp;Ubah</a></td>';
   	str += '<td align="center"><a class="thickbox" href="menus/siapp/referensi/libur_del.php?q='+q+'&width=600&height=200" title="Hapus Hari Libur">';
   	str += '<img src="css/images/stop_f2.png" border="0" width="16" height="16">&nbsp;Hapus</a></td>';
   	str += '</tr>';
   
   	$('#tableBody').append(str);

   	tb_init('#tr'+q+' td a.thickbox');
}