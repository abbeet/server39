<?php 
/* Lihat Hasl Upload Data DIPA
   update terakhir tgl. 04-02-2009
   Ana
	update terakhir tgl. .............. -abrarhedar-
   ------------------------------------------------------
*/   
	session_start();
	include("../lib/sambung.php");
	include("../lib/sipl.php");
	CheckAuthentication();
	$kdunit=$_SESSION[kdunit];
	$sktunit=strtolower(sktunitkerja($kdunit,$ta));
	$ta=$_SESSION[ta];
$filedata='../DataDipa/'.$sktunit.'/d_item.dbf';
if(file_exists($filedata))
{
echo 'file '.$filedata.' ada';
$data=dbase_open($filedata,2);
dbase_pack($data);
$jml=dbase_numrecords($data);
$vdataawal=dbase_get_record_with_names($data,1);
$tahun=$vdataawal["THANG"];
$kodesatker=$vdataawal["KDSATKER"];
//dbase_pack($data);
$kdsatkerunit=kdsatker($kdunit);
echo 'tahun anggaran '.$tahun.' satker data '.$kodesatker;
echo 'kode unit '.$kdunit.' satker unit '.$kdsatkerunit;
if($_REQUEST['ok'])
{
mysql_query("delete from d_item where ThAng='$ta' and kdsatker='$kdsatkerunit' ");
$i=0;
$no==0;
while($i<=$jml)
{
$vdata=dbase_get_record_with_names($data,$i);
$thang=$vdata["THANG"];
$kdsatker=$vdata["KDSATKER"];
$jumlah=$vdata['JUMLAH'];
if($kdsatker==$kdsatkerunit and $thang==$ta)
{
echo 'kode satker sesuia';
$no==$no+1;
mysql_query("insert into d_item(ThAng,kdsatker,jumlah)
                         values('$ta','$kdsatker','$jumlah')");
}
$i++;
}
dbase_close($data);
$datadipa=mysql_query("select * from d_item where ThAng='$ta' and kdsatker='$kodesatker'");
$jumlahdata=mysql_num_rows($datadipa);
if($jumlahdata=0)
{
}
}else{
//		header("location:../setup/logup2.php");
}
//		header("location:Upload_Dipa.php");
}

if($_REQUEST['batal'])
{
		header("location:Upload_Dipa.php");
}		
?> 
	<LINK href="../css/style.css" type=text/css rel=stylesheet>
<form name="form1" method="post" action="">
  <p>&nbsp;</p>
  <div class="pesan" align="center"> 
    <table width="387">
      <tr> 
        <td> <table width="100%">
            <tr> 
              <td><div align="center"><font size="+1">Kode Satker <?php echo $kodesatker; ?></font></div></td>
            </tr>
            <tr align="center"> 
              <td> <h1><font size="+1">Import Data DIPA Tahun <?php echo $tahun; ?></font></h1></td>
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
