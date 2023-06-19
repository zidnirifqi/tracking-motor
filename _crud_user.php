<?php 
include_once 'config/dao.php';
$dao = new Dao();
// var_dump($_POST);die;

if ($_POST['aksi'] == 'simpan') {
	$id = $_POST['id_user'];
	$nama = $_POST['nama'];
	$username = $_POST['username'];
	$password = $_POST['password'];
	$query = "INSERT INTO `users`(`nama`, `username`, `password`, `roles`) VALUES ('$nama','$username',PASSWORD('$password'),'admin')";
}
elseif ($_POST['aksi'] == 'edit') {
	$id = $_POST['id_user'];
	$nama = $_POST['nama'];
	$username = $_POST['username'];
	$password = $_POST['password'];
	$query = "UPDATE `users` SET `nama`='$nama',`username`='$username',`password`=PASSWORD('$password') WHERE `id` = '$id'";
}
elseif ($_POST['aksi'] == 'delete') {
	$id = $_POST['id_user'];
	$query = "DELETE FROM `users` WHERE `id` = '$id'";
}
// var_dump($query);die;
$dao->execute($query);

header("location:user");
?>