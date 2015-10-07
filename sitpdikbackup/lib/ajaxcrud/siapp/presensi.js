function EditRow(q, status, kekurangan, kode_alasan, tl_psw, keterangan, x)
{
	var element = '#tr'+q;
	
	if (x == 1)
	{
		if (status == "") status = "TIDAK HADIR";
		$(element+' td:nth-child(3)').text(status);
		$(element+' td:nth-child(5)').text(kekurangan);
		if (kekurangan != 0) $(element+' td:nth-child(5)').css({'color':'#FF0000'});
		$(element+' td:nth-child(6)').text(kode_alasan);
		$(element+' td:nth-child(7)').text(tl_psw);
		$(element+' td:nth-child(8)').text(keterangan);
	}
	else if (x == 0)
	{
		$(element+' td:nth-child(1)').text(status);
		$(element+' td:nth-child(3)').text(kekurangan);
		if (kekurangan != 0) $(element+' td:nth-child(3)').css({'color':'#FF0000'});
		$(element+' td:nth-child(4)').text(kode_alasan);
		$(element+' td:nth-child(5)').text(tl_psw);
		$(element+' td:nth-child(6)').text(keterangan);
	}
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
			else if (response.status == 3)
			{
				$('#divResult').text('Ubah data berhasil').css({'color':'#000000','background-color':'#FFFF00'}).fadeIn();				
				EditRow(
					$('input[@name=q]').val(),
					$('select[@name=status] option:selected').text(),
					response.kekurangan,
					response.kode_alasan,
					response.tl_psw,
					$('input[@name=keterangan]').val(),
					$('input[@name=x]').val()
				);
				tb_remove();
			}
		}, 
		dataType: 'json'
	});
	return false;
}