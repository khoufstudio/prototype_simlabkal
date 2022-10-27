<!-- Content Header (Page header) -->
<?= page_header("Keuangan"); ?>

<!-- Main Content -->
<section class="content">
  <div class="box">
    <div class="box-header with-border" style="display: flex;justify-content: space-between;">
      <div class="input-group" style="width: 300px;margin-right: 10px;">
        <div class="input-group-addon">
          <i class="fa fa-calendar"></i>
        </div>
        <input type="text" class="form-control pull-right" id="tanggal_finances">
      </div>
    </div>
    <div class="box-body">
      <?= alert_message($form_message, $this->session); ?>
      <table id="table" class="table table-border table-striped" style="width: 100%;">
        <thead>
          <tr>
            <th class="text-center" width="5%">No</th>
            <th class="text-center">No Order</th>
            <th class="text-center">Tanggal Masuk</th>
            <th class="text-center">SPM</th>
            <th class="text-center">Status</th>
            <th class="text-center"><i class="fa fa-cog"></i></th>
          </tr>
        </thead>
        <tbody>
          <tr> 
            <td colspan="8" class="text-center">
              Tidak ada data
            </td>
          </tr>	       
        </tbody>
      </table>
    </div>
  </div>
</section>

<!-- modal -->
<div class="modal fade" id="modal_modal_finance">
  <?= form_open('finances/store', 'id="form_modal_finance"'); ?>
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header bg-green">
          <button class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Update Pembayaran</h4>  
        </div>
        <div class="modal-body">
          <p>
            Data Pemesanan sudah dibayar oleh customer?
          </p>
          <div class="checkbox">
            <label>
              <input type="checkbox" id="setuju" name="setuju" value="1">
              Ya
            </label>
          </div>
        </div>
        <div class="modal-footer">
          <button class="btn btn-link" data-dismiss="modal">Tutup</button>
          <button id="button_submit" class="btn btn-success"><i id="icon_submit" class="fa fa-send" style="margin-right: 10px;"></i> Simpan</button>
        </div>
      </div>
    </div> 
  <?= form_close(); ?>
</div>
<!-- end modal -->

<script>
  $('#tanggal_finances').daterangepicker({
    "startDate": startOfMonth,
    "endDate": endOfMonth
  });

  var tanggalfinances = $('#tanggal_finances').val();
  $('#periode').val(tanggalfinances);

  // setup for datatables
  var argDataTables = {
    url: "<?= base_url(); ?>/finances/get_datatables_json",
    columns: [                        
      {"data": "order_number"},
      {"data": "order_number"},
      {"data": "order_date"},
      {"data": "spm"},
      {"data": "tracking_number"},
      {"data": "action"}
    ],
    custom_columns: [
      {"index": 0, "val": "index"},
    ],
    date: tanggalfinances
  };

  var table = setupDatatable(argDataTables);

  $('#tanggal_finances').on('change', function(e) {
    $('#periode').val($(this).val());
    argDataTables.date = $(this).val();
    table.draw();
  })

  $('#table').on("click", ".item-edit", function(e) {
    e.preventDefault();
    var url = $(this).attr('href');
    var formUrl = url.replace("edit", "update")
    $('#form_modal_finance').attr('action', formUrl)

    $('#modal_modal_finance').modal('show');
  });


  $('#form_modal_finance').submit(function(e) {
      e.preventDefault()

      var form = $(this)
      var inputs = form.find('checkbox')
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
              table.draw()
              $('#modal_modal_finance').modal('hide')
              $('#setuju').prop('checked', false)
            })
          } else {
            var message = data.message
          }
        },
        complete: function() {
          $('#button_submit').attr('disabled', false)
        }
      })
  })

  // on modal close clear 
  $('#modal_modal_finance').on('hidden.bs.modal', function() {
    $('#setuju').prop('checked', false)
  })
</script>
