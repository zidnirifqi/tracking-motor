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
				<li class="active">History</li>
			</ol>
		</div><!--/.row-->
		
		<div class="row">
			<div class="col-lg-12">
				<h1 class="page-header">History</h1>
				<div class="panel">
					<div class="panel-body container-fluid">
						<table class="table table-striped">
							<thead style="background-color: #1E90FF; color:white;" class="text-center">
								<th><center>No</center></th>
								<th>Waktu</th>
								<th>Motor</th>
								<th>Pengguna</th>
								<th width="400px">Koordinat Awal</th>
								<th>Jarak Dari<br>Koordinat Awal</th>
								<th>Status</th>
								<th></th>
							</thead>
							<tbody>
								<?php 
								include_once 'config/dao.php'; 
								$dao = new Dao();
								$result = $dao->viewHistory();
								$no = 1;
								foreach ($result as $value) { ?>
									<tr>
										<td><?php echo $no; $no++; ?></td>
										<td><?php echo $value['waktu'] ?></td>
										<td><?php echo $value['merk'].' ('.$value['plat_nomor'].')' ?></td>
										<td><?php echo $value['pengguna'] ?></td>
										<td><?php echo $value['nama_lokasi'] ?></td>
										<td><?php echo $value['jarak_now'].' Km' ?></td>
										<?php if ($value['status'] == 'Di Izinkan'): ?>
											<td><span class="badge" style="background-color: blue;"><?php echo $value['status'] ?></span></td>
										<?php endif ?>
										<?php if ($value['status'] == 'Di Larang'): ?>
											<td><span class="badge" style="background-color: red;color:white;"><?php echo $value['status'] ?></span></td>
										<?php endif ?>
										<td><center><a href="detail-history?id=<?=$value['id']?>"><button class="btn btn-link btn-sm"><em class="fa fa-mail-forward">&nbsp;</em>Detail</button></a></center></td>
									</tr>
								<?php } ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div><!--/.row-->
	</div>
	<?php include_once 'template/js.php'; ?>	
</body>
</html>