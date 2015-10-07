<?php 
include "../../includes/includes.php";
$th = $_SESSION['xth'];
//$bl = date('m');
//$kdsatker = $_REQUEST['kdsatker'];
//if ( substr($bl,0,1)== '0' )   $bl = substr($bl,1,1) ;
//if ( substr($bl,0,1)<> '0' )   $bl = $bl ;
$bl = 7 ;
?>
<graph bgColor='FCFCFC'  xaxisname='Bulan' yaxisname='Realisasi' canvasBorderColor='333333'
numdivlines='9' divLineColor='333333' yAxisMaxValue='100' decimalPrecision='1' numberPrefix='% '>
	<categories font='Arial' fontSize='10' fontColor='000000'>
		<category name='Jan' />
		<category name='Feb' />
		<category name='Mar' />
		<category name='Apr' />
		<category name='Mei' />
		<category name='Jun' />
		<category name='Jul' />
		<category name='Ags' />
		<category name='Sep' />
		<category name='Okt' />
		<category name='Nov' />
		<category name='Des' />
	</categories>
    <?php 
	$kdsatker = '017063' ;
	$real_1 = 0 ; $real_2 = 0 ; $real_3 = 0; $real_4 = 0 ; $real_5 = 0 ; $real_6 = 0 ;
	$real_7 = 0 ; $real_8 = 0 ; $real_9 = 0; $real_10 = 0 ; $real_11 = 0 ; $real_12 = 0 ;
	$pagu = pagudipa_satker($th,$kdsatker);
	if( $bl >= 1 ) $real_1 = realisasi_satker_sdbl($th,$kdsatker,1)/$pagu*100;
	if( $bl >= 2 ) $real_2 = realisasi_satker_sdbl($th,$kdsatker,2)/$pagu*100;
	if( $bl >= 3 ) $real_3 = realisasi_satker_sdbl($th,$kdsatker,3)/$pagu*100;
	if( $bl >= 4 ) $real_4 = realisasi_satker_sdbl($th,$kdsatker,4)/$pagu*100;
	if( $bl >= 5 ) $real_5 = realisasi_satker_sdbl($th,$kdsatker,5)/$pagu*100;
	if( $bl >= 6 ) $real_6 = realisasi_satker_sdbl($th,$kdsatker,6)/$pagu*100;
	if( $bl >= 7 ) $real_7 = realisasi_satker_sdbl($th,$kdsatker,7)/$pagu*100;
	if( $bl >= 8 ) $real_8 = realisasi_satker_sdbl($th,$kdsatker,8)/$pagu*100;
	if( $bl >= 9 ) $real_9 = realisasi_satker_sdbl($th,$kdsatker,9)/$pagu*100;
	if( $bl >= 10 ) $real_10 = realisasi_satker_sdbl($th,$kdsatker,10)/$pagu*100;
	if( $bl >= 11 ) $real_11 = realisasi_satker_sdbl($th,$kdsatker,11)/$pagu*100;
	if( $bl >= 12 ) $real_12 = realisasi_satker_sdbl($th,$kdsatker,12)/$pagu*100;
	?>
	<dataset seriesname='Realisasi Anggaran' color='00FFFF' showValues='1'>
		<set value='<?php echo $real_1; ?>' />
		<set value='<?php echo $real_2; ?>' />
		<set value='<?php echo $real_3; ?>' />
		<set value='<?php echo $real_4; ?>' />
		<set value='<?php echo $real_5; ?>' />
		<set value='<?php echo $real_6; ?>' />
		<set value='<?php echo $real_7; ?>' />
		<set value='<?php echo $real_8; ?>' />
		<set value='<?php echo $real_9; ?>' />
		<set value='<?php echo $real_10; ?>' />
		<set value='<?php echo $real_11; ?>' />
		<set value='<?php echo $real_12; ?>' />
	</dataset>
	<trendLines>
		<line startValue='45' endValue='55' color='8BBA00' thickness='1' alpha='20' showOnTop='1' displayValue='Perkiraan' isTrendZone='1'/>
	</trendLines>
</graph>