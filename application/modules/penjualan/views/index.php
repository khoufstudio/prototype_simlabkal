<!-- Content Header (Page header) -->
<?= page_header("Penjualan"); ?>

<!-- Main Content -->
<section class="content">
  <div class="box">
    <div class="box-header with-border" style="display: flex;justify-content: space-between;">
      <div class="input-group" style="width: 300px;margin-right: 10px;">
        <div class="input-group-addon">
          <i class="fa fa-calendar"></i>
        </div>
        <input type="text" class="form-control pull-right" id="tanggal_penjualan">
      </div>
      <div class="pull-right">
        <a href="<?= site_url('penjualan/create'); ?>" class="btn btn-success mr-2">
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
            <th class="text-center" width="5%">No</th>
            <th class="text-center">Tanggal</th>
            <th class="text-center">Kode Penjualan</th>
            <th class="text-center">Pelanggan</th>
            <th class="text-center">Pembayaran</th>
            <th class="text-center">Jumlah</th>
            <th class="text-center"><i class="fa fa-cog"></i></th>
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
  $('#tanggal_penjualan').daterangepicker({
    "startDate": startOfMonth,
    "endDate": endOfMonth
  });

  var tanggalPenjualan = $('#tanggal_penjualan').val();

  $('#periode').val(tanggalPenjualan);

  // setup for datatables
  var argDataTables = {
    url: "<?= base_url(); ?>/penjualan/get_datatables_json",
    columns: [                        
      {"data": "selling_code"},
      {"data": "tanggal_buat"},
      {"data": "selling_code"},
      {"data": "customer"},
      {"data": "payment"},
      {"data": "harga_total"},
      {"data": "aksi"}
    ],
    custom_columns: [
      {"index": 0, "val": "index"},
    ],
    date: tanggalPenjualan
  };

  var table = setupDatatable(argDataTables);

  $('#tanggal_penjualan').on('change', function(e) {
    $('#periode').val($(this).val());
    argDataTables.date = $(this).val();
    table.draw();
  })
</script>
