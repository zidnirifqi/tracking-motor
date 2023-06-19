<?php 
include_once 'dbconfig.php';

class Dao 
{
	var $link;
	public function __construct()
	{
			$this->link = new Dbconfig(); //object
		}

		public function login($username,$password) {
			$query = "SELECT * FROM `users` WHERE username='$username' and password = PASSWORD('$password')";
			return mysqli_query($this->link->conn, $query);
		}

		public function view($tabel)
		{
			$query = "SELECT * FROM $tabel";
			return mysqli_query($this->link->conn, $query);	
		}

		public function viewMaps()
		{
			$query = "SELECT `lokasi`.*, merk,plat_nomor,pengguna FROM `kendaraan`,`lokasi` WHERE `lokasi`.id_kendaraan = `kendaraan`.id";
			return mysqli_query($this->link->conn, $query);	
		}

		public function viewHistory()
		{
			$query = "SELECT `riwayat`.*, merk,plat_nomor,pengguna,latitude, longitude, nama_lokasi, batas FROM `kendaraan`,`lokasi`,`riwayat` WHERE `lokasi`.id_kendaraan = `kendaraan`.id AND `lokasi`.id = `riwayat`.id_lokasi";
			return mysqli_query($this->link->conn, $query);	
		}

		public function total($tabel) {
			$query = "SELECT count(*) as jml FROM `$tabel`";
			$result = mysqli_query($this->link->conn, $query);
			$result = $result->fetch_array();
			return $result['jml'];
		}

		public function getLokasi()
		{
			$query = "SELECT MAX(id) as id FROM riwayat GROUP BY id_lokasi ORDER BY waktu DESC";
			$id = mysqli_query($this->link->conn,$query);
			$all_id = '';
			$i = 0; 
			foreach ($id as $value) {
				if ($i == 0) 
					$all_id .= "'";
				$all_id .= $value['id'];
				if ($i != ($id->num_rows-1))
					$all_id .= "','";
				else 
					$all_id .="'";
				$i++;
			}
			// echo $all_id;die;
			$query = "SELECT `riwayat`.*, merk,plat_nomor,pengguna, latitude, longitude, batas, nama_lokasi FROM `kendaraan`,`lokasi`,`riwayat` WHERE `lokasi`.id_kendaraan = `kendaraan`.id AND `lokasi`.id = `riwayat`.id_lokasi AND `riwayat`.id IN ($all_id)";
			$lokasi = mysqli_query($this->link->conn,$query);
			$all_lokasi = array();
			$idx = 0;
			foreach ($lokasi as $value) {
				if ($value['status'] == 'Di Izinkan') 
					$color = 'blue';
				else
					$color = 'red';
				$all_lokasi[$idx][0] = '<table><tbody><tr><td colspan="3"><p style="text-align: center;"><h4><strong><center>Lokasi Terkini</center></strong></h4></p><p style="text-align: center;"><span>Status :</spa> <span class="badge" style="background-color: '.$color.';color:white;">'.$value['status'].'</span> <a href="#"> Detail</a></p></td></tr><tr><td width="100px">Pengguna</td><td>:</td><td width="200px">'.$value['pengguna'].'</td></tr><tr><td>Motor</td><td width="10px">:</td><td>'.$value['merk'].' ('.$value['plat_nomor'].')'.'</td></tr><tr><td>Lokasi Batas</td><td>:</td><td>'.$value['nama_lokasi'].'</td></tr><tr><td>Radius</td><td>:</td><td>'.$value['batas'].' Km</td></tr><tr><td>Lokasi Terkini</td><td>:</td><td>Janti</td></tr><tr><td>Jarak</td><td>:</td><td>'.$value['jarak_now'].' Km</td></tr></tbody></table>';
				$all_lokasi[$idx][1] = $value['latitude_now'];
				$all_lokasi[$idx][2] = $value['longitude_now'];
				$idx++;
			}
			return $all_lokasi;
		}

		public function getDetailHistory($id){
			$query = "SELECT `riwayat`.*, merk,plat_nomor,pengguna,latitude, longitude, nama_lokasi, batas FROM `kendaraan`,`lokasi`,`riwayat` WHERE `lokasi`.id_kendaraan = `kendaraan`.id AND `lokasi`.id = `riwayat`.id_lokasi AND `riwayat`.id = '$id'";
			$result = mysqli_query($this->link->conn, $query);
			$result = $result->fetch_array();	
			$riwayat = array();
			
			if ($result['status'] == 'Di Izinkan') 
				$color = 'blue';
			else
				$color = 'red';
			$riwayat[0][0] = '<table><tbody><tr><td colspan="3"><p><h4><strong><center>Lokasi Awal</center></strong></h4></p></td></tr><tr><td width="100px">Lokasi Batas</td><td>:</td><td>'.$result['nama_lokasi'].'</td></tr><tr><td>Radius</td><td>:</td><td>'.$result['batas'].' Km</td></tr></tbody></table>';
			$riwayat[0][1] = $result['latitude'];
			$riwayat[0][2] = $result['longitude'];
			$riwayat[0][3] = $result['batas'];
			$riwayat[1][0] = '<table><tbody><tr><td colspan="3"><p style="text-align: center;"><h4><strong><center>Lokasi Terkini</center></strong></h4></p><p style="text-align: center;"><span>Status :</spa> <span class="badge" style="background-color: '.$color.';color:white;">'.$result['status'].'</span></p></td></tr><tr><td width="100px">Waktu</td><td>:</td><td width="200px">'.$result['waktu'].'</td><tr><td width="100px">Pengguna</td><td>:</td><td width="200px">'.$result['pengguna'].'</td></tr><tr><td>Motor</td><td width="10px">:</td><td>'.$result['merk'].' ('.$result['plat_nomor'].')'.'</td></tr><tr><td>Jarak</td><td>:</td><td>'.$result['jarak_now'].' Km</td></tr></tbody></table>';
			$riwayat[1][1] = $result['latitude_now'];
			$riwayat[1][2] = $result['longitude_now'];
			$riwayat[1][3] = null;
			return $riwayat;
		}

		public function cekJarak($id, $latitude_now, $longitude_now)
		{
			$result = array();
			$query = "SELECT * FROM lokasi WHERE id = '$id'";
			$batas = mysqli_query($this->link->conn,$query);
			$batas = $batas->fetch_array();
			$result['jarak'] = $this->getDistance($batas['latitude'],$batas['longitude'],$latitude_now,$longitude_now);
			if ($result['jarak'] > $batas['batas'])
				$result['status'] = 'Di Larang';
			else
				$result['status'] = 'Di Izinkan';
			return $result;
		}

		public function getDistance($latitude1, $longitude1, $latitude2, $longitude2) 
		{ 
			$theta = $longitude1 - $longitude2; 
			$distance = (sin(deg2rad($latitude1)) * sin(deg2rad($latitude2)))  + (cos(deg2rad($latitude1)) * cos(deg2rad($latitude2)) * cos(deg2rad($theta))); 
			$distance = acos($distance); 
			$distance = rad2deg($distance); 
			$distance = $distance * 60 * 1.1515;  
			$distance = $distance * 1.609344;  
			return (round($distance,2)); 
		}

		public function execute($query)
		{
			$result = mysqli_query($this->link->conn, $query);
			if ($result) {
				return $result;
			}else{
				return mysqli_error($this->link->conn);
			}
		}
	}

	?>