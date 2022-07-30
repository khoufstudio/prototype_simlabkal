<!-- Content Header (Page header) -->
<?= page_header("Retur Penjualan"); ?>

<!-- Main Content -->
<section class="content">
  <div class="box">
    <div class="box-header with-border" style="display: flex;justify-content: space-between;">
      <div class="input-group" style="width: 300px;margin-right: 10px;">
        <div class="input-group-addon">
          <i class="fa fa-calendar"></i>
        </div>
        <input type="text" class="form-control pull-right" id="tanggal_retur">
      </div>
      <div class="pull-right">
        <a href="<?= site_url('retur_penjualan/create'); ?>" class="btn btn-success mr-2">
          <i class="fa fa-plus margin-right-lg"></i> 
          Tambah
        </a>
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
      <table id="table" class="table table-bordered table-striped" style="width: 100%;">
        <thead>
		  <tr>
			  <th>No</th>
			  <th>Tanggal Retur</th>
			  <th>Kode Retur</th>
			  <th>Nama Pelanggan</th>
			  <th>Nama Barang</th>
			  <th>No Batch</th>
			  <th>Kuantiti</th>
			  <th>Harga</th>
		  </tr>
        </thead>
        <tbody>
          <tr> 
            <td colspan="7" class="text-center">
              Tidak ada data
            </td>
          </tr>	       
        </tbody>
      </table>
    </div>
  </div>
</section>

<script>
  $('#tanggal_retur').daterangepicker({
    "startDate": startOfMonth,
    "endDate": endOfMonth
  });

  var tanggalRetur = $('#tanggal_retur').val();

  $('#periode').val(tanggalRetur);

  // setup for datatables
  var argDataTables = {
    url: "<?= base_url(); ?>/retur_penjualan/get_datatables_json",
    columns: [                        
      {"data": "tanggal_jual"},
      {"data": "tanggal_jual"},
      {"data": "selling_return_code"},
      {"data": "nama_customer"},
      {"data": "nama_barang"},
      {"data": "no_batch"},
      {"data": "kuantiti"},
      {"data": "harga"},
    ],
    custom_columns: [
      {"index": 0, "val": "index"},
    ],
    search: {tanggal_retur: tanggalRetur}
  };

  var table = setupDatatable(argDataTables);

  $('#tanggal_retur').on('change', function(e) {
    $('#periode').val($(this).val());
    argDataTables.date = $(this).val();
    table.draw();
  })
</script>

