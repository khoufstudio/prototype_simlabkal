<!-- Content Header (Page header) -->
<?= page_header("Master Supplier"); ?>

<!-- Main Content -->
<section class="content">
  <div class="box">
    <div class="box-header with-border" style="display: flex;justify-content: flex-end;">
      <div>
        <button id="add_supplier" class="btn btn-success"><i class="fa fa-plus margin-right-lg"></i> Tambah</button>
      </div>
    </div>
    <div class="box-body">
      <table id="table" class="table table-bordered table-striped">
        <thead>
          <tr>
            <th class="text-center" width="5%">No</th>
            <th class="text-center">Nama Supplier</th>
            <th class="text-center">Alamat</th>
            <th class="text-center">Kontak</th>
            <th class="text-left"><i class="fa fa-cog"></i></th>
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

<!-- Modal Supplier-->
<div class="modal fade" id="modal_master_supplier">
  <?= form_open('master_supplier/store', 'id="form_master_supplier"'); ?>
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header bg-green">
          <button class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Tambah Supplier</h4>  
        </div>
        <div class="modal-body">
          <?= input_text(array('name' => 'nama', 'label' => 'Nama Supplier *')); ?>
          <?= input_text(array('name' => 'alamat', 'label' => 'Alamat'));?>
          <?= input_text(array('name' => 'nomor_kontak', 'label' => 'No Kontak', 'type' => 'number'));?>
        </div>
        <div class="modal-footer">
          <button class="btn btn-link" data-dismiss="modal">Tutup</button>
          <button id="button_submit" class="btn btn-success"><i id="icon_submit" class="fa fa-send" style="margin-right: 10px;"></i> Simpan</button>
        </div>
      </div>
    </div> 
  <?= form_close(); ?>
</div>

<script>
  // setup for datatables
  var argDataTables = {
    url: "<?= base_url(); ?>/master_supplier/get_datatables_json",
    columns: [                        
      {"data": "name"},
      {"data": "name"},
      {"data": "address"},
      {"data": "contact"},
      {"data": "action"}
    ],
    custom_columns: [
      {"index": 0, "val": "index"},
    ] 
  };

  var dataTable = setupDatatable(argDataTables);

  $('#table').on("click", ".item-edit", function(e) {
    e.preventDefault();
    var url = $(this).attr('href');
    var formUrl = url.replace("edit", "update")

    $.ajax({
      url: url
    }).done(function(res) {
      $('#form_master_supplier').attr('action', formUrl)
      $('#nama').val(res.name);
      $('#alamat').val(res.address);
      $('#nomor_kontak').val(res.contact);

       $('#modal_master_supplier').modal('show');
    });
  });

  $('#table tbody').on('click', '.btn-delete', function(e) {
    e.preventDefault()

    show_sweet_alert({
      text: 'Apakah anda ingin menghapus?',
      type: 'warning',
      timer: 36000,
      showConfirmButton: true,
      showCancelButton: true
    }).then((result) => {
      if (result.value) {
        $(this).parent().submit()
      } 
    })
  })

  $('#add_supplier').click(function() {
    $('#form_master_supplier')[0].reset();
    var url = $('#form_master_supplier').attr('action')
    var formUrl = url.replace(/update.*/g, "store")
    $('#form_master_supplier').attr('action', formUrl)

    $('#modal_master_supplier').modal({backdrop: 'static', keyboard: false});
  })

  $('#form_master_supplier').submit(function(e) {
      e.preventDefault()

      var form = $(this)
      var inputs = form.find('input, textarea')
      var data = new FormData(form[0])
      var url = form.attr('action')

      $.ajax({
        method: 'POST',
        data,
        processData: false,
        contentType: false,
        url,
        beforeSend: function() {
          $('#button_submit').attr('disabled', true)
        },
        success: function(data) {
          if (data.success) {
            show_sweet_alert({
              text: 'Alhamdulillah data ' + data.message,
              type: 'success',
              timer: 3600
            }).then((result) => {
              dataTable.draw()
              $('#modal_master_supplier').modal('hide')
            })
          } else {
            var message = data.message
            if (message.includes('Nama Supplier')) {
              errorInputText('nama', message)              
            }
          }
        },
        complete: function() {
          $('#button_submit').attr('disabled', false)
        }
      })
  })

  // on modal close clear 
  $('#modal_master_supplier').on('hidden.bs.modal', function() {
    clearInputText('nama')
  })
</script>
