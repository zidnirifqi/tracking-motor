<?php 
include_once 'config/dao.php';
$dao = new Dao();
$user = $_POST['username'];
$pass = $_POST['password'];
$hasil = $dao->login($user, $pass);

if($hasil->num_rows == 1){  
	session_start();
	$_SESSION['login'] = '1';
	header('location:index');	
}
else{
	?>
	<script language="JavaScript">
		alert('Login gagal! Username atau Password tidak sesuai.');
		document.location='login';
	</script>
	<?php
}

?>