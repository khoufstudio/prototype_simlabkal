<!-- Content Header -->
<?= page_header("Pengguna"); ?>

<!-- Main Content -->
<div class="content">
	<div class="box">
		<div class="box-body">
			<div class="clearfix">
				<a href="<?= base_url('users/create');?>" class="btn btn-primary pull-right"><i class="fa fa-plus"></i> Tambah</a>
			</div>
			<?= alert_message($form_message, $this->session); ?>
			<table id="table" class="table table-bordered table-striped">
				<thead>
					<tr>
						<th width="5%">No</th>
						<th>Nama</th>
						<th>Username</th>
						<th class="text-center" width="15%"><i class="fa fa-cog"></i></th>
					</tr>
				</thead>
			</table>
		</div>
	</div>
</div>

<!-- Model -->
<div class="modal fade" id="modal_user">
	<form action="users/store" id="form_user" method="POST" autocomplete="off">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header bg-green">
					<button class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Tambah Pengguna</h4>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label for="nama">Nama</label>
						<input type="text" class="form-control" name="nama" id="modal_nama" required="">
					</div>
					<div class="form-group">
						<label for="username">Username</label>
						<input type="text" class="form-control" name="username" id="modal_username" required="">
					</div>
					<div class="form-group">
						<label for="password">Password</label>
						<input type="password" class="form-control" name="password" id="modal_password" required="">
					</div>
					<div class="form-group">
						<label for="password_confirm">Tulis Password</label>
						<input type="password" class="form-control" name="password_confirm" id="modal_password_confirm" required="">
					</div>
				</div>

				<div class="modal-footer">
					<button class="btn btn-link" data-dismiss="modal">Tutup</button>
					<button type="submit" class="btn btn-primary"><i class="fa fa-send"  style="margin-right: 10px;"></i> Simpan</button>
				</div>
			</div>
		</div>
	</form>
</div>

<script>
	
  // setup for datatables
  var argDataTables = {
    url: "<?= base_url().'users/get_datatables_json'?>", 
    columns: [
        {"data": "num"},
        {"data": "nama"},
        {"data": "username"},
        {"data": "view"}
    ],
    custom_columns: [
      {"index": 0, "val": "index"},
    ] 
  };

  setupDatatable(argDataTables);

  
  $("#table").on("click", ".item_hapus", function(e) {
    e.preventDefault();
    const href = $(this).attr('href');

    Swal({
      title: 'Apakah Anda yakin?',
      text: "Anda tidak bisa mengembalikan apa yang anda hapus!",
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Ya, hapus ini!'
    }).then((result) => {
      if (result.value) {
        document.location.href = href;
      }
  	})
 	});

 	$('#table').on("click", ".item_edit", function(e) {
 		e.preventDefault();
 		var url = $(this).attr('href');

 		$.ajax({
 			url: url
 		}).done(function(res) {
      $('#form_user').attr('action', '<?= base_url(); ?>users/update/' +  res.id)
 			$('#modal_nama').val(res.nama);
 			$('#modal_username').val(res.username);
 			$('#modal_password').val(res.password);
 			$('#modal_password_confirm').val(res.password);

 			$('#modal_user').modal('show');

 			// 
 		});
 	});

    // clear input modal
    $('#modal_user').on('hidden.bs.modal', function(e) {
        $(this).find("input, select").val('').end();
    });
</script>
