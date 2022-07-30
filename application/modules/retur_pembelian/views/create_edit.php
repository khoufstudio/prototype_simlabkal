<!-- Content Header (Page header) -->
<?= page_header("Tambah Retur Pembelian"); ?>

<!-- Main content -->
<section class="content">
  <div class="box">
    <!-- /.box-header -->
    <div class="box-header">
      <h3 class="box-title">
        <i class="fa fa-shopping-cart"></i> Tambah Retur Pembelian
      </h3>
    </div>
    <!-- form start -->
    <?= form_open($form_action,  array('id' => 'form')); ?>
      <div class="box-body">
        <div class="row">
            <div class="col-md-3">
                <?= input_select(['label' => 'Supplier', 'name' => 'supplier', 'list' => $supplier]); ?>
            </div>
            <div class="col-md-3">
                <?= input_text(['label' => 'No. Faktur', 'name' => 'no_faktur']); ?>
            </div>
            <div class="col-md-3">
                <?= input_text(['label' => 'No. Batch', 'name' => 'no_batch']); ?>
            </div>
            <div class="col-md-2">
                <button id="retur_pembelian_filter" type="button" class="btn btn-success"  style="margin-bottom: 0;margin-top: 24px;">
                    <i class="fa fa-search"></i> Filter
                </button>
            </div>
        </div>
        <div class="">
          <table id="table" class="table table-bordered" style="width: 100%">
            <thead>
              <tr>
                <th>No</th>
                <th>No Faktur</th>
                <th>Tanggal Beli</th>
                <th>Jatuh Tempo</th>
                <th>Nama Supplier</th>
                <th>Nama Barang</th>
                <th>No Batch</th>
                <th>Stok</th>
                <th>Harga</th>
                <th><i class="fa fa-cog"></i></th>
              </tr>
            </thead>
            <tbody>
              <tr id="empty_data">
                <td class="text-center" colspan="8">Belum ada data</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
      <div class="box-footer">
        <div class="pull-right">
          <a href="<?= site_url($base); ?>" class="btn btn-danger" style="margin-right:  10px;"><i class="fa fa-ban"></i> Batal</a>
          <button type="submit" class="btn btn-primary"><i class="fa fa-<?= $action == 'add' ? 'plus' : 'pencil'; ?>" style="margin-right: 10px;"></i> Simpan</button>
        </div>
      </div> 
    <?= form_close(); ?>
  </div>
</div>
<div class="modal fade" id="modal_retur_pembelian">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Retur Barang</h4>
      </div>
      <form id="form_search_jumlah_barang" action="<?= base_url('retur_pembelian/store') ?>" method="POST">
        <div class="modal-body">
          <p>Anda akan meretur barang - <strong id="nama_produk">Test</strong></p>
          <input type="hidden" name="id_detail_pembelian" id="id_detail_pembelian">
          <div class="form-group">
            <input id="jumlah_retur_barang" name="jumlah_retur_barang" class="form-control" type="number" placeholder="Jumlah" required="">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
          <button id="save_button" type="submit" class="btn btn-primary">Simpan</button>
        </div>
      </div>
    </form>
  </div>
</div>

</section>
<script>
  // setup for datatables
  var supplier = $('#supplier').val()
  var argDataTables = {
    url: "<?= base_url(); ?>/retur_pembelian/get_datatables_purchase_detail_json",
    columns: [                        
      {"data": "tanggal_beli"},
      {"data": "invoice_number"},
      {"data": "tanggal_beli"},
      {"data": "due_date"},
      {"data": "supplier_name"},
      {"data": "product_name"},
      {"data": "batch_number"},
      {"data": "current_stock"},
      {"data": "price"},
      {"data": "button"}
    ],
    custom_columns: [
      {"index": 0, "val": "index"},
    ],
    search: {}
  };
  
  var table = setupDatatable(argDataTables);

  $('#retur_pembelian_filter').click(function(e) {
    var supplier = $('#supplier').val()
    var no_faktur = $('#no_faktur').val()
    var no_batch = $('#no_batch').val()
    
    argDataTables.search = { supplier, no_faktur, no_batch }
    table.draw();
  })
  

  $(document).on('click', '.button-retur', function(e) {
    e.preventDefault()
    var idDetailPembelian = $(this).attr('id')
    var namaProduk = $('#' + idDetailPembelian).closest('td').prev('td').prev('td').prev('td').prev('td').text()
    var maxLengthProduct  = $('#' + idDetailPembelian).closest('td').prev('td').prev('td').text()

    $('#jumlah_retur_barang').attr('max', maxLengthProduct)
    $('#nama_produk').text(namaProduk)
    $('#modal_retur_pembelian').modal()
    $('#id_detail_pembelian').val(idDetailPembelian)
  })
</script>

