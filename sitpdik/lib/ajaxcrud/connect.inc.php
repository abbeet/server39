<?
	mysql_connect('localhost','root','bidsi') or die(mysql_error());
	mysql_select_db('test') or die(mysql_error());
	
	function getPost($name){
		if(isset($_POST[$name])) 
		  return (get_magic_quotes_gpc() ? $_POST[$name] : addslashes($_POST[$name]));
		else
		  return false;
	}
?>
