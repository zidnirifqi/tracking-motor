<?php 
include_once '../config/dao.php';
$dao = new Dao();

if (!empty($_POST)) {
	$id_lokasi = $_POST['id_lokasi'];
	$latitude_now = $_POST['latitude'];
	$longitude_now = $_POST['longitude'];

	$data = $dao->cekJarak($id_lokasi, $latitude_now, $longitude_now);
	$jarak = $data['jarak'];
	$status = $data['status'];

	$query = "INSERT INTO `riwayat`(`id_lokasi`, `latitude_now`, `longitude_now`, `jarak_now`, `status`) VALUES ('$id_lokasi','$latitude_now','$longitude_now','$jarak','$status')";
	$dao->execute($query);
	echo $status;
}
else{
	echo "tidak ada data yang dikirim";
}