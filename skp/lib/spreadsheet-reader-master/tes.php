<?php
	
	#header('Content-Type: text/plain');
	
	error_reporting('E_NONE');
	
	$Filepath = "juni.xlsx";

	require('php-excel-reader/excel_reader2.php');
	require('SpreadsheetReader.php');

	try
	{
		$Spreadsheet = new SpreadsheetReader($Filepath);

		$Sheets = $Spreadsheet -> Sheets();

		foreach ($Sheets as $Index => $Name)
		{
			echo $Name."<BR>";
			
			#$Spreadsheet -> ChangeSheet($Index);
			
			foreach ($Spreadsheet as $Key => $Row)
			{
				echo $Row[0]."<BR>";
			}
		}
		
	}
	catch (Exception $E)
	{
		echo $E -> getMessage();
	}
?>
