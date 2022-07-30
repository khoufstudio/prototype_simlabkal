<!-- Content Header (Page header) -->
<?= page_header("Master Golongan"); ?>

<!-- Main Content -->
<section class="content">
  <div class="box">
    <div class="box-header with-border" style="display: flex;justify-content: flex-end;">
      <div>
        <button id="add_golongan" class="btn btn-success"><i class="fa fa-plus margin-right-lg"></i> Tambah</button>
      </div>
    </div>
    <div class="box-body">
      <table id="table" class="table table-bordered table-striped" style="width: 100%;">
        <thead>
          <tr>
            <th class="text-center" width="5%">No</th>
            <th class="text-center">Nama Golongan</th>
            <th class="text-center" width="15%"><i class="fa fa-cog"></i></th>
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

<!-- Modal Golongan-->
<div class="modal fade" id="modal_master_golongan">
  <?= form_open('master_golongan/store', 'id="form_master_golongan"'); ?>
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header bg-green">
          <button class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Tambah Golongan</h4>  
        </div>
        <div class="modal-body">
          <?= input_text(array('name' => 'nama', 'label' => 'Nama Golongan *'));?>
          <div class="modal-footer">
            <button class="btn btn-link" data-dismiss="modal">Tutup</button>
            <button id="button_submit" class="btn btn-success"><i id="icon_submit" class="fa fa-send" style="margin-right: 10px;"></i> Simpan</button>
          </div>
        </div>
      </div>
    </div> 
  <?= form_close(); ?>
</div>

<script>
  // setup for datatables
  var argDataTables = {
    url: "<?= base_url(); ?>/master_golongan/get_datatables_json",
    columns: [                        
      {"data": "name"},
      {"data": "name"},
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
      $('#form_master_golongan').attr('action', formUrl)
      $('#nama').val(res.name);

       $('#modal_master_golongan').modal('show');
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

  $('#add_golongan').click(function() {
    $('#form_master_golongan')[0].reset();
    var url = $('#form_master_golongan').attr('action')
    var formUrl = url.replace(/update.*/g, "store")
    $('#form_master_golongan').attr('action', formUrl)

    $('#modal_master_golongan').modal('show');
  })

  $('#form_master_golongan').submit(function(e) {
    e.preventDefault()

    var form = $(this)
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
            $('#modal_master_golongan').modal('hide')
          })
        } else {
          var message = data.message
          if (message.includes('Nama')) {
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
  $('#modal_master_golongan').on('hidden.bs.modal', function() {
    // clear input
    clearInputText('nama')
  })
</script>