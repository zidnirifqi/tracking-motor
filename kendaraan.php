<!DOCTYPE html>
<html>
<?php include_once 'template/head.php'; ?>
<script type="text/javascript">
	function add() {
		$('#aksi').val('simpan');
		$('#id_kendaraan').val('');
		$('#merk').val('');
		$('#plat_nomor').val('');
		$('#pengguna').val('');
		$('#tombol').text('Save');
		$('#ModalKendaraan').modal('show');
	}

	function edit(id,merk,plat,pengguna) {
		$('#aksi').val('edit');
		$('#id_kendaraan').val(id);
		$('#merk').val(merk);
		$('#plat_nomor').val(plat);
		$('#pengguna').val(pengguna);
		$('#tombol').text('Edit');
		$('#ModalKendaraan').modal('show');
	}

	function del(id,merk) {
		$('#aksi_del').val('delete');
		$('#id_del').val(id);
		$('#merk_del').text(merk);
		$('#delKendaraan').modal('show');
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
				<li class="active">Kendaraan</li>
			</ol>
		</div><!--/.row-->
		
		<div class="row">
			<div class="col-lg-12">
				<h1 class="page-header">Kendaraan</h1>
				<div class="panel">
					<div class="panel-body container-fluid">
						<button class="btn btn-sm btn-primary" onclick="add();"><i class="fa fa-plus"></i> Tambah</button>
						<br><br>
						<table class="table table-striped">
							<thead style="background-color: #1E90FF; color:white;" class="text-center">
								<th>No</th>
								<th>Merk</th>
								<th>Plat Nomor</th>
								<th>Pengguna</th>
								<th>Aksi</th>
							</thead>
							<tbody>
								<?php 
								include_once 'config/dao.php';
								$dao = new Dao();
								$result = $dao->view('kendaraan');
								$no = 1;
								foreach ($result as $value) { 
									$edit = "'".$value['id']."','".$value['merk']."','".$value['plat_nomor']."','".$value['pengguna']."'";
									$del = "'".$value['id']."','".$value['merk']."'";
									?>
									<tr>
										<td><?php echo $no; $no++; ?></td>
										<td><?php echo $value['merk'] ?></td>
										<td><?php echo $value['plat_nomor'] ?></td>
										<td><?php echo $value['pengguna'] ?></td>
										<td nowrap="">
											<button class="btn btn-sm btn-warning" onclick="edit(<?php echo $edit ?>)"><i class="fa fa-edit"></i> Edit</button>
											<button class="btn btn-sm btn-danger" onclick="del(<?php echo $del; ?>)"><i class="fa fa-trash"></i> Delete</button>
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

	<!-- Modal Add/edit-->
	<div class="modal fade" id="ModalKendaraan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<h5 class="modal-title"><center><strong>Data Kendaraan</strong></center></h5>
				</div>
				<div class="modal-body">
					<form action="_crud_kendaraan" method="post">
						<div class="row">
							<div class="col-md-12">
								<label>Merk</label>
								<input type="hidden" name="aksi" id="aksi">
								<input type="hidden" name="id_kendaraan" id="id_kendaraan">
								<input type="text" name="merk" required="yes" id="merk" class="form-control" placeholder="Merk Kendaraan">
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<label>Plat Nomor</label>
								<input type="text" name="plat_nomor" required="yes" id="plat_nomor" class="form-control" placeholder="Plat Nomor">
							</div>
							<div class="col-md-6">
								<label>Pengguna</label>
								<input type="text" name="pengguna" required="yes" id="pengguna" class="form-control" placeholder="Pengguna Motor">
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-warning" data-dismiss="modal">Cancel</button>
						<button type="submit" class="btn btn-primary"><span id="tombol"></span></button>
					</div>
				</form>
			</div>
		</div>
	</div>
	<!-- End Modal Add/Edit -->
	<!-- Modal Delete-->
	<div class="modal fade" id="delKendaraan" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<h5 class="modal-title" id="exampleModalLabel"><center><strong>Delete Kendaraan</strong></center></h5>
				</div>
				<div class="modal-body">
					<form action="_crud_kendaraan" method="post">
						<center><h4>Yakin Delete Data?</h4></center>
						<center><h2>Motor <span class="badge bg-red" style="font-size: 20px" id="merk_del"></span></h2></center>
						<input type="hidden" name="aksi" id="aksi_del">
						<input type="hidden" name="id_kendaraan" id="id_del">
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