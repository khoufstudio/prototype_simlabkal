<!-- Content Header (Page header) -->
<?= page_header("Menu"); ?>

<!-- Main Content -->
<section class="content">
  <div class="box">
    <div class="box-body">
      <div class="clearfix">
        <button id="add_menu" class="btn btn-success pull-right"><i class="fa fa-plus margin-right-lg"></i> Tambah</button>
      </div>

      <?= alert_message($form_message, $this->session); ?>

      <table id="table" class="table table-bordered table-striped">
        <thead>
          <tr>
            <th class="text-center" width="5%">No</th>
            <th class="text-center">Menu</th>
            <th class="text-center">Urutan</th>
            <th class="text-center">Parent</th>
            <th class="text-center" width="20%"><i class="fa fa-cog"></i></th>
          </tr>
        </thead>
          <tbody>
            <tr> 
              <td colspan="5" class="text-center">
                Tidak ada data
              </td>
            </tr>        
          </tbody>
        </table>
    </div>
  </div>
</section>

<!-- Modal Menu-->
<div class="modal fade" id="modal_menu">
  <?= form_open('menus/store', 'id="form_menu"', 'method="POST"'); ?>
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header bg-green">
          <button class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Tambah Menu</h4>  
        </div>
        <div class="modal-body">
          <div id="alert_success" class="alert alert-success alert-dismissible d-none">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h4><i class="icon fa fa-check"></i> Success!</h4>
            Data telah disubmit, silahkan print menu.
          </div>
          <div class="container-input">
            <?= input_text(['label' => 'Nama Menu', 'name' => 'name']); ?>
            <?= input_select(['label' => 'Parent', 'name' => 'parent_id', 'list' => $menu_select_val], false); ?>
            <?= input_text(['label' => 'Link', 'name' => 'link']); ?>
            <?= input_text(['label' => 'Urutan', 'name' => 'order_number']); ?>
            <?= input_text(['label' => 'Icon', 'name' => 'icon']); ?>
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
    url: "<?= base_url(); ?>menus/get_datatables_json",
    columns: [                        
      {"data": "id"},
      {"data": "name"},
      {"data": "order_number"},
      {"data": "parent_name"},
      {"data": "edit_button"},
    ],
    custom_columns: [
      {"index": 0, "val": "index"}
    ]
  };

  var table = setupDatatable(argDataTables);

  // tombol edit
  $('#table tbody').on('click', '.item-edit', function(e) {
    e.preventDefault()
 		var url = $(this).attr('href');
    var formUrl = url.replace("edit", "update")

    $.ajax({
      url: url
    }).done(function(res) {
      $('#form_menu').attr('action', formUrl)
      $('#name').val(res.name)
      $('#link').val(res.link)
      $('#order_number').val(res.order_number)
      $('#parent_id').val(res.parent_id || 'root').trigger('change');
      $('#icon').val(res.icon)

      $('#modal_menu').modal('show')
    })
  })

  // tombol hapus
  $('#table tbody').on('click', '.btn-danger', function(e) {
    var hapus = confirm('Apakah anda ingin menghapus')

    return hapus
  })

  $('#add_menu').click(function() {
    $('#form_menu')[0].reset();
    var url = $('#form_menu').attr('action')
    var formUrl = url.replace(/update.*/g, "store")
    $('#form_menu').attr('action', formUrl)

    // clear
    $('#parent_id').val(null).trigger('change');
    $('#modal_menu').modal('show');
  })
</script>

