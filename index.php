<!DOCTYPE html>
<html>
<?php include_once 'template/head.php'; ?>
<body>
	<?php include_once 'template/nav.php'; ?>
	<?php include_once 'template/sidebar.php'; ?>
	<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
		<div class="row">
			<ol class="breadcrumb">
				<li><a href="index">
					<em class="fa fa-home"></em>
				</a></li>
				<li class="active">Dashboard</li>
			</ol>
		</div><!--/.row-->

		<div class="row">
			<div class="col-lg-12">
				<h1 class="page-header">Dashboard</h1>
			</div>
		</div><!--/.row-->
		<?php 
		include_once 'config/dao.php';
		$dao = new Dao();
		$marker = $dao->getLokasi();
		?>
		<div class="panel panel-container">
			<div class="row">
				<div class="col-xs-6 col-md-3 col-lg-3 no-padding">
					<div class="panel panel-teal panel-widget border-right">
						<div class="row no-padding"><em class="fa fa-xl fa-motorcycle color-blue"></em>
							<div class="large"><?php echo $dao->total('kendaraan'); ?></div>
							<div class="text-muted">Kendaraan</div>
						</div>
					</div>
				</div>
				<div class="col-xs-6 col-md-3 col-lg-3 no-padding">
					<div class="panel panel-blue panel-widget border-right">
						<div class="row no-padding"><em class="fa fa-xl fa-map-marker color-orange"></em>
							<div class="large"><?php echo $dao->total('lokasi'); ?></div>
							<div class="text-muted">Lokasi</div>
						</div>
					</div>
				</div>
				<div class="col-xs-6 col-md-3 col-lg-3 no-padding">
					<div class="panel panel-orange panel-widget border-right">
						<div class="row no-padding"><em class="fa fa-xl fa-bar-chart color-teal"></em>
							<div class="large"><?php echo $dao->total('riwayat'); ?></div>
							<div class="text-muted">Riwayat</div>
						</div>
					</div>
				</div>
				<div class="col-xs-6 col-md-3 col-lg-3 no-padding">
					<div class="panel panel-red panel-widget ">
						<div class="row no-padding"><em class="fa fa-xl fa-users color-red"></em>
							<div class="large"><?php echo $dao->total('users'); ?></div>
							<div class="text-muted">Pengguna</div>
						</div>
					</div>
				</div>
			</div><!--/.row-->
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-default">
					<div class="panel-heading">
						Lokasi Motor Terkini
						<span class="pull-right clickable panel-toggle panel-button-tab-left"><em class="fa fa-toggle-up"></em></span></div>
						<div class="panel-body">
							<div class="canvas-wrapper">
								<div id="map"></div>
							</div>
						</div>
					</div>
				</div>
			</div><!--/.row-->
		</div>	<!--/.main-->

		<?php include_once 'template/js.php'; ?>
		<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCuqp6YJymNF8Et7Xvd6SO3sBYqu2Bkc88&libraries=places&callback=initMap"></script>
		<script type="text/javascript">
			function initialize() {
				<?php 
				$dao = new Dao();
				$marker = $dao->getLokasi();
				echo 'var markers = '.json_encode($marker).';';
				?>
				var mapCanvas = document.getElementById('map');
				var mapOptions = {
					mapTypeId: google.maps.MapTypeId.ROADMAP,
					center: {lat: -7.782894799999976, lng: 110.36702461349182},
					zoom: 13
				}     
				var map = new google.maps.Map(mapCanvas, mapOptions)

				var infowindow = new google.maps.InfoWindow({maxWidth: 400}), marker, i;
				var bounds = new google.maps.LatLngBounds(); 
				for (i = 0; i < markers.length; i++) {  
					pos = new google.maps.LatLng(markers[i][1], markers[i][2]);
					bounds.extend(pos); 
					marker = new google.maps.Marker({
						position: pos,
						map: map,
						animation: google.maps.Animation.BOUNCE
					});
					google.maps.event.addListener(marker, 'click', (function(marker, i) {
						return function() {
							infowindow.setContent(markers[i][0]);
							infowindow.open(map, marker);
						}
					})(marker, i));
					map.fitBounds(bounds); 
				}
			}
			google.maps.event.addDomListener(window, 'load', initialize);
		</script>
	</body>
	</html>