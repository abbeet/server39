<?php 
	session_start();
	include("../lib/sambung.php");
	include("../lib/sipl.php");
	CheckAuthentication();
	$kdunit=$_SESSION[kdunit];
	$ta=$_SESSION[ta];
	$sktunit=strtolower(sktunitkerja($kdunit,$ta));
	$level=$_SESSION[Level];
$kdsatkerunit=kdsatker($kdunit);
//--------------- koneksi 
 	odbc_close_all();
    $dsn = "Driver={Microsoft Visual FoxPro Driver}; SourceType=DBF; SourceDB=c:\\xampp\\htdocs\\SIPL\\DataDipa\\". $sktunit . "; Exclusive=No;";
	$sambung_dipa = odbc_connect( $dsn,"","");
    if ( $sambung_dipa != 0 )   
    {
        echo "Tersambung<br>";
        echo $sambung_dipa, "<br>";
	}
//----------------------------------
if($_REQUEST['ok'])
{
	mysql_query("delete from d_akun where ThAng='$ta' and KdSatker='$kdsatkerunit' ");
	$data="select * from d_akun.keu where thang='$ta' and kdsatker='$kdsatkerunit'";	
	$vdata=odbc_exec($sambung_dipa,$data);

	while($row = odbc_fetch_row($vdata)){		#1
		$thang=odbc_result($vdata,thang);
		$kdsatker=odbc_result($vdata,kdsatker);
		$kddept=odbc_result($vdata,kddept);
		$kdunit_dipa=odbc_result($vdata,kdunit);
		$kdprogram=odbc_result($vdata,kdprogram);
		$kdgiat=odbc_result($vdata,kdgiat);
		$kdoutput=odbc_result($vdata,kdoutput);
		$kdsoutput=odbc_result($vdata,kdsoutput);
		$kdkmpnen=odbc_result($vdata,kdkmpnen);
		$kdskmpnen=odbc_result($vdata,kdskmpnen);
		$kdmak=odbc_result($vdata,kdakun);
		if($thang==$ta and $kdsatker==$kdsatkerunit){
	mysql_query("insert into d_akun(THANG,KDSATKER,KDDEPT,KDUNIT,KDPROGRAM,KDGIAT,KDOUTPUT,KDSOUTPUT,KDKMPNEN,KDSKMPNEN,KDAKUN)
                 values('$ta','$kdsatker','$kddept','$kdunit_dipa','$kdprogram','$kdgiat','$kdoutput','$kdsoutput','$kdkmpnen','$kdskmpnen','$kdmak')");
		}
	$i++;
	}			#1
	
odbc_close_all();

$kdsatker=kdsatker($kdunit);
//---- otomatis input dtpagu_dipa
mysql_query("delete from dtpagu_dipa where TA='$ta' and KdSatker='$kdsatkerunit'");
$data_mak=mysql_query("select * from d_akun where THANG='$ta' and KDSATKER='$kdsatkerunit'");

while($vdata_mak=mysql_fetch_array($data_mak)){	#2
$kdsatker=$vdata_mak['KDSATKER'];
$kdunitkerja=kdunitkerja($kdsatker);
$kddept=$vdata_mak['KDDEPT'];
$kdunit_dipa=$vdata_mak['KDUNIT'];
$kdprogram=$vdata_mak['KDPROGRAM'];
$kdgiat=$vdata_mak['KDGIAT'];
$kdoutput=$vdata_mak['KDOUTPUT'];
$kdsoutput=$vdata_mak['KDSOUTPUT'];
$kdkmpnen=$vdata_mak['KDKMPNEN'];
$kdskmpnen=$vdata_mak['KDSKMPNEN'];
$kdmak=$vdata_mak['KDAKUN'];

$data_kmpnen=mysql_query("select * from d_kmpnen where THANG='$ta' and KDSATKER='$kdsatker' and KDDEPT='$kddept' and KDUNIT='$kdunit_dipa' and KDPROGRAM='$kdprogram' and KDOUTPUT='$kdoutput' and KDSOUTPUT='$kdsoutput' and KDKMPNEN='$kdkmpnen'");
$vdata_kmpnen=mysql_fetch_array($data_kmpnen);
$urkmpnen=$vdata_kmpnen['URKMPNEN'];
$datadipa_akun=mysql_query("select KdMak,sum(jumlah) as pagu from d_item where KdDept='$kddept' and KdUnit='$kdunit_dipa' and KdProgram='$kdprogram' and KdGiat='$kdgiat' and KdOutput='$kdoutput' and KdSOutput='$kdsoutput' and KdKmpnen='$kdkmpnen' and KdSKmpnen='$kdskmpnen' and KdMak='$kdmak' and ThAng='$ta' and KdSatker='$kdsatker' group by KdMak order by KdMak");
$vdatadipa_akun=mysql_fetch_array($datadipa_akun);
$jumlah=$vdatadipa_akun['pagu'];
$kdskeg=substr($urkmpnen,0,6);
if($kdskeg==0){
	$kdskeg='';
}else{
	$kdskeg=$kdskeg;
}		
mysql_query("insert into dtpagu_dipa(TA,KdSatker,KdUnitKerja,KdDept,KdUnit,KdProg,KdGiat,KdOutput,KdSOutput,KdKmpnen,KdSKmpnen,KdMak,Jumlah,KdSKeg)
             values('$ta','$kdsatker','$kdunitkerja','$kddept','$kdunit_dipa','$kdprogram','$kdgiat','$kdoutput','$kdsoutput','$kdkmpnen','$kdskmpnen','$kdmak','$jumlah','$kdskeg')");
$i++;
}		#2
	
//------ otomatis input dtpagu_dipa_detil
mysql_query("delete from dtpagu_dipa_item where TA='$ta' and KdSatker='$kdsatkerunit'");
$data_item=mysql_query("select * from d_item where ThAng='$ta' and KdSatker='$kdsatkerunit'");

while($vdata_item=mysql_fetch_array($data_item)){	#3
$kdsatker=$vdata_item['KdSatker'];
$kdunitkerja=kdunitkerja($kdsatker);
$kddept=$vdata_item['KdDept'];
$kdunit_dipa=$vdata_item['KdUnit'];
$kdprogram=$vdata_item['KdProgram'];
$kdgiat=$vdata_item['KdGiat'];
$kdoutput=$vdata_item['KdOutput'];
$kdsoutput=$vdata_item['KdSOutput'];
$kdkmpnen=$vdata_item['KdKmpnen'];
$kdskmpnen=$vdata_item['KdSKmpnen'];
$kdmak=$vdata_item['KdMak'];
$noitem=$vdata_item['noitem'];
$nmitem=addslashes($vdata_item['nmitem']);
$volkeg=$vdata_item['volkeg'];
$satkeg=$vdata_item['satkeg'];
$hargasat=$vdata_item['hargasat'];
$jumlah=$vdata_item['jumlah'];
$jan=$vdata_item['Jan'];
$peb=$vdata_item['Peb'];
$mar=$vdata_item['Mar'];
$apr=$vdata_item['Apr'];
$mei=$vdata_item['Mei'];
$jun=$vdata_item['Jun'];
$jul=$vdata_item['Jul'];
$agt=$vdata_item['Agt'];
$sep=$vdata_item['Sep'];
$okt=$vdata_item['Okt'];
$nop=$vdata_item['Nop'];
$des=$vdata_item['Des'];

$data_dipa=mysql_query("select * from dtpagu_dipa where TA='$ta' and KdSatker='$kdsatker' and KdUnitKerja='$kdunitkerja' and KdDept='$kddept' and KdUnit='$kdunit_dipa' and KdProg='$kdprogram' and KdGiat='$kdgiat' and KdOutput='$kdoutput' and KdSOutput='$kdsoutput' and KdKmpnen='$kdkmpnen' and KdSKmpnen='$kdskmpnen' and KdMak='$kdmak'");
$vdata_dipa=mysql_fetch_array($data_dipa);
$kdskeg=$vdata_dipa['KdSKeg'];

mysql_query("insert into dtpagu_dipa_item(TA,KdSatker,KdUnitKerja,KdDept,KdUnit,KdProg,KdGiat,KdOutput,KdSOutput,KdKmpnen,KdSKmpnen,KdMak,NoItem,NmItem,VolKeg,SatKeg,HargaSat,Jumlah,KdSKeg,Jan,Peb,Mar,Apr,Mei,Jun,Jul,Agt,Sep,Okt,Nop,Des) values('$ta','$kdsatker','$kdunitkerja','$kddept','$kdunit_dipa','$kdprogram','$kdgiat','$kdoutput','$kdsoutput','$kdkmpnen','$kdskmpnen','$kdmak','$noitem','$nmitem','$volkeg','$satkeg','$hargasat','$jumlah','$kdskeg','$jan','$peb','$mar','$apr','$mei','$jun','$jul','$agt','$sep','$okt','$nop','$des')");
$i++;
}				#3
	 
		echo "<script language='javascript'>alert('Proses selesai ')</script>";
?>
     <meta http-equiv="refresh" content="0;URL=<?php echo "Upload_Mak.php"?>">
<?
}

if($_REQUEST['batal'])
{
		header("location:Upload_Mak.php");
odbc_close_all();
}		
?> 
	<LINK href="../css/style.css" type=text/css rel=stylesheet>
<form name="form1" method="post" action="">
  <p>&nbsp;</p>
  <div class="pesan" align="center"> 
    <table width="431" height="157">
      <tr> 
        <td width="325"> <table width="403">
            <tr>
              <td>&nbsp;</td>
            </tr>
            <tr> 
              <td><div align="center"><font size="+1">Kode Satker <?php echo $kdsatkerunit ?></font></div></td>
            </tr>
            <tr align="center"> 
              <td> <h1><font size="+1">Import Data Kegiatan DIPA<br>Tahun <?php echo $ta; ?></font></h1></td>
            </tr>
            <tr align="center">
              <td>&nbsp;</td>
            </tr>
          </table></td>
      </tr>
      <tr> 
        <td align="center"> <input type="submit" name="ok" value="     OK     ">
          &nbsp; <input type="submit" name="batal" value="  BATAL  "></td>
      </tr>
    </table>
  </div>
</form>

<?php 
function pagu_mak($ta,$kdsatker,$kdfungsi,$kdsfung,$kdprogram,$kdgiat,$kdsgiat,$kdgroup,$kdmak)
{
$data=mysql_query("select sum(jumlah) as pagu from d_item where ThAng='$ta' and KdSatker='$kdsatker' and KdFungsi='$kdfungsi' and KdSFung='$kdsfung' and KdProgram='$kdprogram' and KdGiat='$kdgiat' and KdSGiat='$kdsgiat' and KdGroup='$kdgroup' and KdMak='$kdmak'");
$vdata=mysql_fetch_array($data);
$hasil=$vdata['pagu'];
return($hasil);
}

function kdunitkerja($kode) {
  	$cari=$kode;
  	$data=mysql_query("select * from tbsatker where KdSatker='$cari'");
  	$vdata=mysql_fetch_array($data);
  	$hasil=$vdata['KdUnitKerja'];
	return($hasil);
}

?>