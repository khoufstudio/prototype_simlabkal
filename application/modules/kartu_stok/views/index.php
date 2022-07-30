<!-- Content Header (Page header) -->
<?= page_header("Kartu Stok"); ?>

<!-- Main Content -->
<section class="content">
  <div class="box">
    <div class="box-body">
        <form id="form_filter_kartu_stok" action="#">
          <div class="form-group">
            <label for="">Tanggal</label>
            <div class="input-group" style="width: 300px;margin-right: 10px;">
              <div class="input-group-addon">
                <i class="fa fa-calendar"></i>
              </div>
              <input type="text" class="form-control" name="periode" id="periode">
            </div>
          </div>
          <div style="width: 300px;">
            <?= input_select(['label' => 'Nama Barang', 'name' => 'nama_barang', 'list' => $barang, 'selected_value' => $barang_detail['id'] ?? ''], false); ?>
          </div>
          <div class="form-group">
            <button class="btn btn-primary"><i class="icon fa fa-search" style="margin-right: 10px;"></i> Cari</button>
          </div>
        </form>
      <div class="kartu-stock-container" style="display: none;">
        <a id="print_stok_button" href="<?= base_url('kartu_stok/print_kartu_stok'); ?>" class="btn btn-success pull-right"><i class="fa fa-print"></i> Print</a>
        <h3 id="nama_barang_text" class="text-center">
          test
        </h3>
        <p class="text-center">
          <strong>Periode:</strong> <span id="periode_text"></span>         
        </p>
        <table id="table" class="table">
          <thead>
            <tr>
              <th>Tgl</th>
              <th>No Dok. Jual/Beli</th>
              <th>Supplier / Pelanggan</th>
              <th>Qty</th>
              <th>Stok</th>
              <th>ED</th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</section>

<script>
  var productId = null
  var periode = null
  var table = null
  var productName = null
  var periode = null

  // setup for datatables
  var argDataTables = {
    url: "<?= base_url(); ?>/kartu_stok/get_datatables_json",
    columns: [                        
      {"data": "created_at"},
      {"data": "transaction_code"},
      {"data": "supplier_name"},
      {"data": "quantity"},
      {"data": "stock"},
      {"data": "expired_date"}
    ],
    search: {}
  }

  $('#periode').daterangepicker({
    "startDate": startOfMonth,
    "endDate": endOfMonth
  });

  $('#form_filter_kartu_stok').submit(function(e) {
    e.preventDefault()

    // print url
    var printUrl = baseUrl + 'kartu_stok/print_kartu_stok'

    periode = $('#periode').val()
    productId = $('#nama_barang').val()

    if (productId != null) {
      $('.kartu-stock-container').show()

      argDataTables.search.product_id = productId
      argDataTables.search.periode = periode

      printUrl += `?product_id=${productId}&periode='${periode}'`

      productName = $('#nama_barang option:selected').text()
      periode = $('#periode').val()

      $('#nama_barang_text').text(productName)
      $('#periode_text').text(periode)

      $('#print_stok_button').attr('href', printUrl)

      if (table == null) {
        table = setupDatatable(argDataTables);
      } else {
        table.draw()
      }
    }   
  })


  $('#barang').change(function() {
    var currentValue = this.value
    var currentStock = currentValue.split('|')[1]

    $('#stok_barang').attr('disabled', false)
    $('#stok_barang').val(currentStock)
    $('#stok_asal').val(currentStock)
  })
</script>

