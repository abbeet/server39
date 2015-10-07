{
		    var todayDate = new Date();
		    var day = todayDate.getDay();
		    var date = todayDate.getDate();
		    var year = todayDate.getYear();
			
		    
		    if (todayDate.getDay() == 0) { theDay = "<FONT COLOR=#ffcc00>Minggu,</FONT>"};
		    if (todayDate.getDay() == 1) { theDay = "<FONT COLOR=#ffcc00>Senin,</FONT>"};
		    if (todayDate.getDay() == 2) { theDay = "<FONT COLOR=#ffcc00>Selasa,</FONT>"};
		    if (todayDate.getDay() == 3) { theDay = "<FONT COLOR=#ffcc00>Rabu,</FONT>"};
		    if (todayDate.getDay() == 4) { theDay = "<FONT COLOR=#ffcc00>Kamis,</FONT>"};
		    if (todayDate.getDay() == 5) { theDay = "<FONT COLOR=#ffcc00>Jumat,</FONT>"};
		    if (todayDate.getDay() == 6) { theDay = "<FONT COLOR=#ffcc00>Sabtu,</FONT>"};

		    if (todayDate.getMonth() == 0)  { theMonth = 'Januari'};
		    if (todayDate.getMonth() == 1)  { theMonth = 'Februari'};
		    if (todayDate.getMonth() == 2)  { theMonth = 'Maret'};
		    if (todayDate.getMonth() == 3)  { theMonth = 'April'};
		    if (todayDate.getMonth() == 4)  { theMonth = 'Mei'};
		    if (todayDate.getMonth() == 5)  { theMonth = 'Juni'};
		    if (todayDate.getMonth() == 6)  { theMonth = 'Juli'};
		    if (todayDate.getMonth() == 7)  { theMonth = 'Agustus'};
		    if (todayDate.getMonth() == 8)  { theMonth = 'September'};
		    if (todayDate.getMonth() == 9)  { theMonth = 'Oktober'};
		    if (todayDate.getMonth() == 10) { theMonth = 'Nopember'};
		    if (todayDate.getMonth() == 11) { theMonth = 'Desember'};
			
			
			
          
			if (navigator.appName == "Microsoft Internet Explorer")
			{
				document.write('&nbsp;',theDay,' ',date,' ',theMonth,', ',year);
			}

			if (navigator.appName == "Netscape")
			{
				netsyear = 1900 + year
				document.write('&nbsp;',theDay,' ',date,' ',theMonth,', ',netsyear);
			}
		  }