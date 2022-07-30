<!-- Content Header (Page header) -->
<?= page_header("Data Role"); ?>

<!-- Main Content -->
<section class="content">
  <div class="box">
    <div class="box-header with-border" style="display: flex;justify-content: flex-end;">
      <div>
        <button id="add_role" class="btn btn-success"><i class="fa fa-plus margin-right-lg"></i> Tambah</button>
      </div>
    </div>
    <div class="box-body">
      <?php if (isset($form_message)) { ?>
        <div class="alert alert-success alert-dismissible">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
          <h4><i class="icon fa fa-check"></i> Berhasil!</h4>
          <?php echo $form_message; ?>
        </div>
      <?php } ?>

      <table id="table" class="table table-bordered table-striped">
        <thead>
          <tr>
            <th class="text-center" width="5%">No</th>
            <th class="text-center">Role</th>
            <th class="text-center" width="20%"><i class="fa fa-cog"></i></th>
          </tr>
        </thead>
          <tbody>
            <tr> 
              <td colspan="3" class="text-center">
                Tidak ada data
              </td>
            </tr>	       
          </tbody>
        </table>
    </div>
  </div>
</section>

<!-- Modal Role-->
<div class="modal fade" id="modal_role">
  <?= form_open('roles/store', 'id="form_role"', 'method="POST"'); ?>
    <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header bg-green">
            <button class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Tambah Role</h4>  
          </div>
          <div class="modal-body">
            <div id="alert_success" class="alert alert-success alert-dismissible d-none">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
              <h4><i class="icon fa fa-check"></i> Success!</h4>
              Data telah disubmit, silahkan print role.
            </div>

            <div class="container-input">
              <div class="form-group">
              	<div class="form-group">
                  <label>Nama Role</label>
                  <input type="text" class="form-control" id="name" name="name"  placeholder="Nama Role" required="">
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
              <button data-dismiss="modal" class="btn btn-link">Tutup</button>
              <button id="button_submit" class="btn btn-success"><i id="icon_submit" class="fa fa-send" style="margin-right: 10px;"></i> Simpan</button>
          </div>
        </div>
    </div> 
  </form>
</div>


<script>
  // parameter url, kolumn, overide
  var argDataTables = {
    url: "<?= base_url(); ?>/roles/get_datatables_json",
    columns: [                        
      {"data": "id"},
      {"data": "name"},
      {"data": "edit_button"},
    ],
    custom_columns: [
      {"index": 0, "val": "index"}
    ]
  };

  setupDatatable(argDataTables);

  // tombol edit
  $('#table tbody').on('click', '.btn-edit', function() {
    var row = $(this).closest('tr')
    var column = row.find('td')
    var namaRole = column[1].innerHTML
    var id = $(this).val()

    url = '<?= base_url(); ?>roles/update/' + id
    $('#form_role').attr('action', url)
    $('#name').val(namaRole)

    $('#modal_role').modal('show')
  })


  // tombol hapus
  $('#table tbody').on('click', '.btn-danger', function(e) {
    var hapus = confirm('Apakah anda ingin menghapus')

    return hapus
  })

  $('#add_role').click(function() {
    $('#form_role')[0].reset();
    var url = $('#form_role').attr('action')
    var formUrl = url.replace(/update.*/g, "store")
    $('#form_role').attr('action', formUrl)

    $('#modal_role').modal('show');
  })
</script>

