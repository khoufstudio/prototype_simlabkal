<!-- Content Header (Page header) -->
<?= page_header("Pemesanan"); ?>

<!-- Main Content -->
<section class="content">
  <div class="box">
    <div class="box-header with-border" style="display: flex;justify-content: space-between;">
      <div class="input-group" style="width: 300px;margin-right: 10px;">
        <div class="input-group-addon">
          <i class="fa fa-calendar"></i>
        </div>
        <input type="text" class="form-control pull-right" id="tanggal_orders">
      </div>
      <div class="pull-right">
        <a href="<?= site_url('orders/create'); ?>" class="btn btn-success mr-2">
          <i class="fa fa-plus margin-right-lg"></i> 
          Tambah
        </a>
      </div>
    </div>
    <div class="box-body">
      <?= alert_message($form_message); ?>
      <table id="table" class="table table-bordered table-striped" style="width: 100%;">
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

<script>
  $('#tanggal_orders').daterangepicker({
    "startDate": startOfMonth,
    "endDate": endOfMonth
  });

  var tanggalOrders = $('#tanggal_orders').val();
  $('#periode').val(tanggalOrders);

  // setup for datatables
  var argDataTables = {
    url: "<?= base_url(); ?>/orders/get_datatables_json",
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
    date: tanggalOrders
  };

  var table = setupDatatable(argDataTables);

  $('#tanggal_orders').on('change', function(e) {
    $('#periode').val($(this).val());
    argDataTables.date = $(this).val();
    table.draw();
  })
</script>
