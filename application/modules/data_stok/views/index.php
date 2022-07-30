<!-- Content Header (Page header) -->
<?= page_header("Data Stok"); ?>

<!-- Main Content -->
<section class="content">
  <div class="box">
    <div class="box-header with-border">
      <div class="row">
        <div class="col-sm-4">
          <?= input_select(['label' => 'Golongan', 'name' => 'golongan', 'list' => $types, 'selected_value' => 'Semua'],  false); ?>
        </div>
        <div class="col-sm-4">
          <?= input_select(['label' => 'Kepemilikan', 'name' => 'kepemilikan', 'list' => ['Semua', 'Sendiri', 'Titipan'], 'selected_value' => 'Semua'],  false); ?>
        </div>
        <div class="col-sm-2">
          <button id="data_stok_filter" type="button" class="btn btn-success" style="margin-bottom: 0;margin-top: 24px;">
            <i class="fa fa-search"></i> Filter
          </button>
        </div>
      </div>
      <div style="display: flex;justify-content: space-between;"> 
        <div style="display: flex;">
          <div style="margin-right: 30px;font-size: 30px;"><strong>Harga Jual: </strong><span id="harga_jual_total">0</span></div>
          <div style="font-size: 30px;"><strong>Harga Beli: </strong><span id="harga_beli_total">0</span></div>
        </div>
        <div>
          <a id="button_print_stock_opname" href="<?= base_url('data_stok/print_data_stok'); ?>" class="btn btn-info">
            <i class="fa fa-print margin-right-lg"></i> Print
          </a>
        </div>
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
            <th>Nama Barang</th>
            <th>Satuan</th>
            <th>Kepemilikan</th>
            <th>Golongan</th>
            <th>Stok</th>
            <th>Harga Beli</th>
            <th>Harga Jual</th>
          </tr>
        </thead>
        <tbody>
          <tr> 
            <td colspan="6" class="text-center">
              Tidak ada data
            </td>
          </tr>        
        </tbody>
      </table>
    </div>
  </div>
</section>

<script>
  function getTotalHarga(golongan = null, kepemilikan = null) {
    $.get({
      url: baseUrl + 'data_stok/total_harga',
      data: { golongan, kepemilikan },
      success: function(data) {
        $('#harga_jual_total').text(data.harga_jual)
        $('#harga_beli_total').text(data.harga_beli)
      }
    })
  }

  $(function() {
    getTotalHarga()
  })

  // setup for datatables
  var argDataTables = {
    url: "<?= base_url(); ?>/data_stok/get_datatables_json",
    columns: [                        
      {"data": "name"},
      {"data": "name"},
      {"data": "denomination_name"},
      {"data": "ownership"},
      {"data": "product_type"},
      {"data": "stock"},
      {"data": "buying_price"},
      {"data": "selling_price"},
    ],
    custom_columns: [
      {"index": 0, "val": "index"},
    ],
    searching: false,
    search: {}
  };

  var table = setupDatatable(argDataTables);

  $('#data_stok_filter').click(function(e) {
    var golongan = $('#golongan').val()
    var kepemilikan = $('#kepemilikan').val()
    
    var printUrl = baseUrl + 'data_stok/print_data_stok'
    printUrl += `?golongan=${golongan}`
    printUrl += `&kepemilikan=${kepemilikan}`

    $('#button_print_stock_opname').attr('href', printUrl)

    getTotalHarga(golongan, kepemilikan)

    argDataTables.search = { golongan, kepemilikan }
    table.draw()
  })
</script>

