<?php
	$title = get_title();
?>

<h2><?php echo $title ?></h2><br />
<h3>
	<p>Selamat datang <font color="#FF0000"> 
	<?php if ( substr($_SESSION['xusername'],0,1) == '1' ) { 
	          echo nama_peg($_SESSION['xusername']);
		  }else{
		      echo $_SESSION['xusername'];
		  }  ?>
	
	</font>.</p> 
	<p>
</h3>
