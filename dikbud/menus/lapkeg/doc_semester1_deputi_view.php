<?php
	checkauthentication();
	$p = $_GET['p'];
	
	$kdunit = $_GET['kdunit'];
	$nourut = $_GET['nourut'];
	$nama = $_GET['nama_file'];
	
	$table = "dt_fileupload";
	$th = $_SESSION['xth'];
	$renstra = th_renstra($th);
	$th_mulai = substr($renstra,0,4) ;
	$th_selesai = substr($renstra,5,4) ;
	$xkdunit = $_REQUEST['kdunit'];
	$xlevel = $_SESSION['xlevel'];
	$xusername = $_SESSION['xusername'];
	$xmenu_p = xmenu_id($p);
	$p_next = $xmenu_p->parent;
	
	$oList = mysql_query("select * from $table where nourut ='$nourut' and th = '$th' and kdunitkerja = '$xkdunit' and keterangan = 'Semester1' order by nourut");
    $List = mysql_fetch_array($oList);
	
?>
<div class="button2-right"> 
 <div class="prev"><a onclick="Back('index.php?p=<?php echo $p_next ?>&xkdunit=<?php echo $xkdunit ?>&sw=1')">Kembali</a><br /></div>
        </div>

<iframe id="fred" style="border:1px solid #666CCC" title="PDF in an i-Frame" src="<?php echo 'file_semester1/'.$xkdunit.'/'.$List['nama_file']?>" frameborder="1" scrolling="auto" height="800" width="100%" ></iframe>