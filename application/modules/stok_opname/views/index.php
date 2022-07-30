<!-- Content Header (Page header) -->
<?= page_header("Stok Opname"); ?>

<!-- Main Content -->
<section class="content">
  <div class="box">
    <div class="box-header with-border">
      <div class="row">
        <div class="col-sm-4">
          <?= input_select(['label' => 'Golongan', 'name' => 'golongan', 'list' => $types],  false); ?>
        </div>
        <div class="col-sm-2">
          <button id="stok_opname_filter" type="button" class="btn btn-success" style="margin-bottom: 0;margin-top: 24px;">
            <i class="fa fa-search"></i> Filter
          </button>
        </div>
      </div>
      <div style="display: flex;justify-content: flex-end;"> 
        <a id="button_print_stock_opname" href="<?= base_url('stok_opname/print_stok_opname'); ?>" class="btn btn-info">
          <i class="fa fa-print margin-right-lg"></i> Print
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
            <th>Nama Barang</th>
            <th>Golongan</th>
            <th>Stok Barang</th>
            <th>Fisik</th>
            <th>ED</th>
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
    
  
  // setup for datatables
  var argDataTables = {
    url: "<?= base_url(); ?>/stok_opname/get_datatables_json",
    columns: [                        
      {"data": "created_at"},
      {"data": "product_name"},
      {"data": "type_name"},
      {"data": "stock"},
      {"data": "empty"},
      {"data": "expired_date"},
    ],
    custom_columns: [
      {"index": 0, "val": "index"},
    ],
    searching: false,
    search: {}
  };

  var table = setupDatatable(argDataTables);

  $('#stok_opname_filter').click(function(e) {
    var golongan = $('#golongan').val()
    
    var printUrl = baseUrl + 'stok_opname/print_stok_opname'
    printUrl += `?golongan=${golongan}`

    $('#button_print_stock_opname').attr('href', printUrl)

    argDataTables.search = { golongan }
    table.draw()
  })
</script>

