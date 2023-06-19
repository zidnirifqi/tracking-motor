<?php 
include_once 'config/dao.php';
$dao = new Dao();
// var_dump($_POST);die;
if ($_POST['aksi'] == 'simpan') {
	$id = $_POST['id_kendaraan'];
	$merk = $_POST['merk'];
	$plat_nomor = $_POST['plat_nomor'];
	$pengguna = $_POST['pengguna'];

	$query = "INSERT INTO `kendaraan`(`merk`, `plat_nomor`, `pengguna`) VALUES ('$merk','$plat_nomor','$pengguna')";
}
elseif ($_POST['aksi'] == 'edit') {
	$id = $_POST['id_kendaraan'];
	$merk = $_POST['merk'];
	$plat_nomor = $_POST['plat_nomor'];
	$pengguna = $_POST['pengguna'];
	$query = "UPDATE `kendaraan` SET `merk`='$merk',`plat_nomor`='$plat_nomor',`pengguna`='$pengguna' WHERE `id` = '$id'";
}
elseif ($_POST['aksi'] == 'delete') {
	$id = $_POST['id_kendaraan'];
	$query = "DELETE FROM `kendaraan` WHERE `id` = '$id'";
}
// var_dump($query);die;
$dao->execute($query);

header("location:kendaraan");
?>