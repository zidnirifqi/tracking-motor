<!DOCTYPE html>
<html>
<?php include_once 'template/head.php'; ?>
<script>
	function del(id,nama_lokasi) {
		$('#aksi_del').val('delete');
		$('#id_del').val(id);
		$('#nama_lokasi').text(nama_lokasi);
		$('#delMaps').modal('show');
	}
</script>
<body>
	<?php include_once 'template/nav.php'; ?>
	<?php include_once 'template/sidebar.php'; ?>
	<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
		<div class="row">
			<ol class="breadcrumb">
				<li><a href="index">
					<em class="fa fa-home"></em>
				</a></li>
				<li class="active">Maps</li>
			</ol>
		</div><!--/.row-->
		
		<div class="row">
			<div class="col-lg-12">
				<h1 class="page-header">Maps</h1>
				<div class="panel">
					<div class="panel-body container-fluid">
						<a href="form-maps"><button class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> Tambah</button></a>
						<br><br>
						<table class="table table-striped">
							<thead style="background-color: #1E90FF; color:white;" class="text-center">
								<th>No</th>
								<th width="200px">Motor</th>
								<th>Pengguna</th>
								<th>Nama Lokasi</th>
								<th>Batas/Radius</th>
								<th>Aksi</th>
							</thead>
							<tbody>
								<?php 
								include_once 'config/dao.php';
								$dao = new Dao();
								$result = $dao->viewMaps();
								$no = 1;
								foreach ($result as $value) { 
									$del = "'".$value['id']."','".$value['nama_lokasi']."'";
									?>
									<tr>
										<td><?php echo $no; $no++; ?></td>
										<td><?php echo $value['merk'].' ('.$value['plat_nomor'].')' ?></td>
										<td><?php echo $value['pengguna'] ?></td>
										<td><?php echo $value['nama_lokasi'] ?></td>
										<td><?php echo $value['batas'].' Km' ?></td>
										<td nowrap="">
											<a href="form-maps?id=<?php echo $value['id'] ?>"><button class="btn btn-sm btn-warning"><i class="fa fa-edit"></i> Edit</button></a>
											<button class="btn btn-sm btn-danger" onclick="del(<?php echo $del ?>)"><i class="fa fa-trash"></i> Delete</button>
										</td>
									</tr>
								<?php } ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- Modal Delete-->
	<div class="modal fade" id="delMaps" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<h5 class="modal-title" id="exampleModalLabel"><center><strong>Delete Kendaraan</strong></center></h5>
				</div>
				<div class="modal-body">
					<form action="_crud_maps" method="post">
						<center><h4>Yakin Delete Data?</h4></center>
						<center><p class="" style="font-size: 20px; background-color: red;border-radius: 5px; color: white" id="nama_lokasi"></p></center>
						<input type="hidden" name="aksi" id="aksi_del">
						<input type="hidden" name="id_lokasi" id="id_del">
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-warning" data-dismiss="modal">Cancel</button>
						<button type="submit" class="btn btn-primary">Delete</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	<?php include_once 'template/js.php'; ?>	
</body>
</html>