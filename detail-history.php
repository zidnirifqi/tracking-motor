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
				<li><a href="history">History</a></li>
			</a></li>
			<li class="active">Detail History</li>
		</ol>
	</div><!--/.row-->
	<?php
	include_once 'config/dao.php';
	$dao = new Dao();
	$id = $_GET['id'];
	?>
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">Detail History</h1>
			<div class="panel">
				<div class="panel-body container-fluid">
					<form action="_crud_maps" method="post" id="input-data">
						<div class="row">
							<div class="col-md-12">
								<div id="maps" style="width:100%;height:380px;"></div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
<?php include_once 'template/js.php'; ?>	
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCuqp6YJymNF8Et7Xvd6SO3sBYqu2Bkc88&libraries=places"></script>
<script type="text/javascript">
	function initialize() {
		<?php 
		$dao = new Dao();
		$marker = $dao->getDetailHistory($id);
		echo 'var markers = '.json_encode($marker).';';
		?>
		var mapCanvas = document.getElementById('maps');
		var mapOptions = {
			mapTypeId: google.maps.MapTypeId.ROADMAP,
			center: {lat: -7.782894799999976, lng: 110.36702461349182},
			zoom: 13
		}     
		var map = new google.maps.Map(mapCanvas, mapOptions)

		var infowindow = new google.maps.InfoWindow({maxWidth: 400}), marker, i;
		var bounds = new google.maps.LatLngBounds(); 
		for (i = 0; i < markers.length; i++) {  
			var rad = markers[i][3];
			pos = new google.maps.LatLng(markers[i][1], markers[i][2]);
			bounds.extend(pos); 
			marker = new google.maps.Marker({
				position: pos,
				map: map,
			});

			var populationOptions = {
				strokeColor: '#6495ED',
				strokeOpacity: 0.8,
				strokeWeight: 1,
				fillColor: '#6495ED',
				fillOpacity: 0.15,
				map: map,
				center: pos,
				radius:  rad * 1000
			};
			cityCircle = new google.maps.Circle(populationOptions); 

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
</html>