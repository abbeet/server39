function EditRow(q, nip, tanggal, jam, jam2, kode_alasan, keterangan, u, m, y, nama, nip_baru, kekurangan, KS)
{
	var element = '#tr'+q;
	var nama = '<a href="index.php?p=29&m=' + m + '&y=' + y + '&u=' + u + '&r=82&q=' + nip + '">' + nama + '</a><br />';
	nama += nip_baru
	
	var dmy = tanggal.substr(8, 2) + '-' + tanggal.substr(5, 2) + '-' + tanggal.substr(0, 4);
	var jm = jam + ' s/d ' + jam2;
	
	$(element+' td:nth-child(2)').text('');
	$(element+' td:nth-child(2)').append(nama);
	$(element+' td:nth-child(3)').text(dmy);
	$(element+' td:nth-child(4)').text(jm);
	$(element+' td:nth-child(5)').text(kekurangan);
	$(element+' td:nth-child(6)').text(kode_alasan);
	$(element+' td:nth-child(7)').text(KS);
	$(element+' td:nth-child(8)').text(keterangan);
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
					$('select[@name=nip] option:selected').val(),
					$('input[@name=tanggal]').val(),
					$('input[@name=jam]').val(),
					$('input[@name=jam2]').val(),
					$('select[@name=kode_alasan] option:selected').val(),
					$('input[@name=keterangan]').val(),
					$('input[@name=u]').val(),
					$('input[@name=m]').val(),
					$('input[@name=y]').val(),
					response.nama,
					response.nip_baru,
					response.kekurangan,
					response.KS
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