<?php 
include_once 'config/dao.php';
$dao = new Dao();
// var_dump($_POST);die;
if ($_POST['aksi'] == 'simpan') {
	$nama_lokasi = $_POST['nama_lokasi'];
	$kendaraan = $_POST['kendaraan'];
	$lat = $_POST['lat'];
	$lng = $_POST['lng'];
	$radius = $_POST['radius'];

	$query = "INSERT INTO `lokasi`(`id_kendaraan`, `nama_lokasi`, `latitude`, `longitude`, `batas`) VALUES ('$kendaraan','$nama_lokasi','$lat','$lng','$radius')";
}
elseif ($_POST['aksi'] == 'edit') { 
	$id = $_POST['id_lokasi'];
	$nama_lokasi = $_POST['nama_lokasi'];
	$kendaraan = $_POST['kendaraan'];
	$lat = $_POST['lat'];
	$lng = $_POST['lng'];
	$radius = $_POST['radius'];
	$query = "UPDATE `lokasi` SET `id_kendaraan`='$kendaraan',`nama_lokasi`='$nama_lokasi',`latitude`='$lat',`longitude`='$lng',`batas`='$radius' WHERE `id` = '$id'";
}
elseif ($_POST['aksi'] == 'delete') {
	$id = $_POST['id_lokasi'];
	$query = "DELETE FROM `lokasi` WHERE `id` = '$id'";
}
// var_dump($query);die;
$dao->execute($query);

header("location:maps");
?>