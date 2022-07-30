<!-- Content Header (Page header) -->
<?= page_header("Penjualan"); ?>

<!-- Main content -->
<section class="content">
  <div class="box">
    <!-- /.box-header -->
    <div class="box-header">
      <h3 class="box-title">
        <i class="fa fa-shopping-cart"></i>
        <?= (isset($sellings)) ? 'Lihat' : 'Tambah'; ?> Penjualan      
      </h3>
    </div>
    <!-- form start -->
    <?php echo form_open($form_action,  array('id' => 'form', 'class' => 'form-horizontal')); ?>
      <div class="box-body" style="display: flex;width: 100%;">
        <div>
            <table id="table" class="table table-bordered">
              <thead>
                <tr>
                  <th class="text-center" width="5%">No</th>
                  <th class="text-center">Barcode</th>
                  <th class="text-center">Nama</th>
                  <th class="text-center">Stok</th>
                  <th class="text-center">Harga</th>
                  <th class="text-left"><i class="fa fa-cog"></i></th>
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
        <div style="width: 100%;padding: 0 30px 0 50px;">
          <input type="hidden" name="kode_penjualan" value="<?= $selling_code; ?>">
          <?php if (isset($sellings['invoice_number'])) { ?>
            <input type="hidden" name="no_faktur" value="<?= $sellings['invoice_number'] ?? ''; ?>">
          <?php } ?>
          <input type="hidden" id="jumlah_penjualan" name="jumlah_penjualan" value="">
          <input type="hidden" id="jumlah_pembelian" name="jumlah_pembelian" value="">
          <input type="hidden" id="nama_kasir" name="nama_kasir" value="<?= $cashier_name; ?>">
          <?= input_text(['label' => 'Kode Penjualan', 'name' => 'kode_penjualan', 'disabled' => true, 'value' => "PJ" . $selling_code], false); ?>
          <?= input_select(['label' => 'Pelanggan', 'name' => 'pelanggan', 'list' => $customers, 'selected_value' => $sellings['customer_id'] ?? '60604ce8db05f', 'disabled' => isset($sellings) ? false : false ], false); ?>
          <?= input_select(['label' => 'Pembayaran', 'name' => 'pembayaran', 'list' => ['Tunai', 'Kredit'], 'selected_value' => $sellings['payment'] ?? 'Tunai', 'disabled' => isset($sellings) ? false : false ], false); ?>
          <?= input_text(['label' => 'Jumlah', 'name' => 'jumlah', 'disabled' => false, 'value' => isset($sellings) ?  intToRupiah((int) $sellings['total']) : 'Rp. 0'], false); ?>
          <div id="product_container"></div>
          <div class="">
            <?php if (form_error('products[]')): ?>
              <div class="alert alert-danger no-fade">
                <p><?= form_error('products[]'); ?></p>
              </div>
            <?php endif; ?>
            <table id="table_products" class="table table-bordered">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Nama Barang</th>
                  <th>No Batch</th>
                  <th>Kuantiti</th>
                  <th>Harga</th>
                  <th>Jumlah</th>
                  <?php if (!isset($sellings)) { ?>
                    <th><i class="fa fa-cog"></i></th>
                  <?php } ?>
                </tr>
              </thead>
              <tbody>
                <?php if (isset($selling_detail) && count($selling_detail) > 0) { ?>
                  <?php foreach($selling_detail as $key => $sd) { ?>
                    <tr id="empty_data">
                      <td><?= ++$key; ?></td>
                      <td><?= $sd['name']; ?></td>
                      <td><?= $sd['batch_number']; ?></td>
                      <td><?= $sd['quantity']; ?></td>
                      <td><?= intToRupiah((int) $sd['price']); ?></td>
                      <td><?= intToRupiah((int) $sd['price'] * (int) $sd['quantity']); ?></td>
                    </tr>
                  <?php } ?>
                <?php } else { ?>
                  <tr id="empty_data">
                    <td class="text-center" colspan="7">Belum ada data</td>
                  </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div class="box-footer">
        <div class="pull-right">
          <a href="<?php echo site_url($base); ?>" class="btn btn-danger" style="margin-right:  10px;"><i class="fa fa-<?= (!isset($sellings)) ? 'ban' : 'angle-left'; ?>"></i> 
            &nbsp;<?= (!isset($sellings)) ? 'Batal' : 'Kembali'; ?>
          </a>
          <?php if (!isset($sellings)) { ?>
            <button id="button_submit_form" type="submit" class="btn btn-primary"><i class="fa fa-<?php echo $action == 'add' ? 'plus' : 'pencil'; ?>" style="margin-right: 10px;"></i> Simpan</button>
          <?php } ?>
        </div>
      </div> 
    <?php echo form_close(); ?>
  </div>
</section>

<!-- /.content -->
<div class="modal fade" id="modal_barang">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Tambah Barang</h4>
      </div>
      <div class="modal-body">
        <p>Scan atau masukan kode barcode dibawah ini!</p>
        <form id="form_search_barang" class="form-horizontal" action="" autocomplete="off">
          <input id="barcode" type="hidden" name="barcode">
          <div class="form-group row">
            <div class="col-sm-12" style="display: flex;gap: 10px;">
              <input id="input_barang" class="form-control" type="text" placeholder="Masukan Barcode" required="">
              <button type="submit" class="btn btn-primary"><i class="icon-spin fa fa-search" style="margin-right: 10px;"></i>Cari</button>
            </div>
          </div>
        </form>
        <p id="empty_product" class="d-none">Data yang dicari tidak ada, silahkan cari kembali atau tambahkan terlebih dahulu</p>
        <form id="form_add_barang" class="d-none" autocomplete="off">
          <input id="product_id" type="hidden" name="product_id">
          <?= input_text(['label' => 'Nama Barang', 'name' => 'nama_barang', 'disabled' => true]); ?>
          <?= input_text(['label' => 'No. Batch', 'name' => 'no_batch', 'disabled' => true]); ?>
          <?= input_text(['label' => 'Kuantiti *', 'name' => 'quantity', 'type' => 'number']); ?>
          <?= input_text(['label' => 'Harga', 'name' => 'price']); ?>
          <input id="buying_price" type="hidden" name="buying_price">
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
        <button id="save_button" type="button" class="btn btn-primary" disabled="">Simpan</button>
      </div>
    </div>
  </div>
</div>

<script>
  $('#btn_add_barang').click(function() {
    $('#save_button').prop('disabled', true)
    $('#form_add_barang')[0].reset();
    clearInputText('quantity')

    openModal('modal_barang')
  })

  $('#price').keyup(function() {
    $('#price').val(formatRupiah(this.value, "Rp. "));
  });

  $('#form_search_barang').on('submit', function(e) {
    e.preventDefault();
    var productId = $('#product_id').val();
    var form = $('#form_search_barang')

    form.find('.icon-spin').removeClass('fa-search');
    form.find('.icon-spin').addClass('fa-spinner fa-spin');
    form.find('button[type=submit]').prop('disabled', true)

    // clear input
    $('#quantity').val('')

    $.ajax({
      url: '<?= base_url(); ?>master_barang/barang/',
      data: { product_id: productId }
    }).then(function(res) {
      var result = res[0]
      form.find('.icon-spin').addClass('fa-search');
      form.find('.icon-spin').removeClass('fa-spinner fa-spin');
      form.find('button[type=submit]').prop('disabled', false)

      if (result) {
        $('form#form_add_barang').removeClass('d-none');
        $('#nama_barang').val(result.name)
        $('#no_batch').val(result.batch_number_product)
        $('#price').val(formatRupiah(result.selling_price, "Rp. "))
        $('#buying_price').val(result.buying_price)
        $('#save_button').prop('disabled', false)
      } else {
        $('#empty_product').removeClass('d-none');
        if (!$('form#form_add_barang').hasClass('d-none')) {
          $('form#form_add_barang').addClass('d-none');
        }
      }
    })
  });

  $('#save_button').click(function(e) {
    var validation = productValidation()

    if (validation) {
      $('#empty_data').remove()
      $('#modal_barang').modal('hide')
      var orderNumber = $('#table_products tr:last-child > td:nth-child(1)').text();
      orderNumber++;
      
      var namaBarang = $('#nama_barang').val()
      var price = rupiah_to_integer($('#price').val())
      var buyingPrice = $('#buying_price').val()
      var harga = formatRupiah(price, "Rp. ")
      var noBatch = $('#no_batch').val() || 0
      var quantity = $('#quantity').val() || 0
      var barcode = $('#input_barang').val()
      var productId = $('#product_id').val()
      var total = parseInt(price) * parseInt(quantity)
      totalRp = formatRupiah(total, "Rp. ")
      var totalBeli = parseInt(buyingPrice) * parseInt(quantity)

      // add data to table
      var newProduct = `<tr>
          <td>${orderNumber}</td>
          <td>${namaBarang}</td>
          <td>${noBatch}</td>
          <td>${quantity}</td>
          <td>${harga}</td>
          <td>${totalRp}</td>
          <td>
            <button type="button" class="btn hapus-row data-${orderNumber} btn-sm btn-danger" style="display: inline-block;">
              <i class="fa fa-fw fa-trash-o"></i>
            </button>
          </td>
        </tr>`

      var inputProduct = `<input type="hidden" class="product-${orderNumber}" name="products[]" value="${productId}|${noBatch}|${quantity}|${harga}|${namaBarang}|${buyingPrice}">`
      var jumlahSementara = rupiah_to_integer($('#jumlah').val())
      var jumlahBaru = parseInt(jumlahSementara) + parseInt(total)
      var jumlahBaruRupiah = formatRupiah(jumlahBaru, "Rp. ")

      var jumlahBeliSementara = Number($('#jumlah_pembelian').val())
      var jumlahBeliBaru = parseInt(jumlahBeliSementara) + parseInt(totalBeli)
      var jumlahBeliBaruRupiah = jumlahBeliBaru

      $('#table_products tbody').append(newProduct);
      $('#product_container').append(inputProduct);

      $('#jumlah').val(jumlahBaruRupiah)
      $('#jumlah_penjualan').val(jumlahBaruRupiah)
      $('#jumlah_pembelian').val(jumlahBeliBaruRupiah)

      // clear input form
      $('#nama_barang').val('')
      $('#form_add_barang').find("input[type=text], select").val("")
    }
  })

  $('#modal_barang').on('show.bs.modal', function (e) {
    // clear input
    if (!$('#form_add_barang').hasClass('d-none')) {
      $('#form_add_barang').addClass('d-none')
    }

    if (!$('#empty_product').hasClass('d-none')) {
      $('#empty_product').addClass('d-none');
    }
    $('#input_barang').val('')
  })

  $('#table_products').on('click', '.hapus-row', function() {
    var classValue = $(this).attr('class')
    var rowNumber = classValue.match(/[0-9]/g).join()
    var deleted_value = $(this).parents('tr').find("td:eq(4)").text();
    
    $('.product-' + rowNumber).remove()
    $(this).parent().parent().remove();
    var lastRow = $('#table_products tr:last-child > td:nth-child(1)').text();
    if (lastRow != 0) {
      for (let i = 1; i < lastRow; i++) {
        $(`#table_products tr:nth-child(${i+1}) > td:nth-child(1)`).text(i);
      }
    } else {
      $('#table_products tbody').append(`
        <tr id="empty_data">
          <td class="text-center" colspan="7">Belum ada data</td>
        </tr>
      `)
    }
  });

  $('#button_submit_form').click(function(e) {
    e.preventDefault()
    show_sweet_alert({
      title: 'Konfirmasi !',
      text: 'Akan mencetak struk?',
      type: 'question',
      timer: 36000,
      showConfirmButton: true,
      showCancelButton: true
    }).then((result) => {
      if (result.value) {
        $('<input type="hidden" name="print" value="1">').appendTo('#form')
        $('#form').submit()
      } else if (result.dismiss == 'cancel') {
        $('#form').submit()
      }
    })
  })

  $('#input_barang').typeahead({
    source: function (name, process) {
      $.ajax({
        url: '<?= base_url(); ?>master_barang/barang/?name=' + name,
        method: 'GET',
        async: true,
        dataType: 'JSON',
        success: function(data) {
           var resultList = data.map(function (item) {
             var link = { id: item.id, name: item.name, product_barcode: item.product_barcode };
             return link
           });
          return process(resultList)
        }
      })
    },
    afterSelect: function (data) {
      $('#input_barang').val(data.name)
      $('#product_id').val(data.id)
    }
  })

  function productValidation() {
    var quantity = $('#quantity').val()

    if (quantity < 1) {
      errorInputText('quantity', 'Kuantiti wajib diisi lebih dari 0')

      return false
    }

    return true
  }

  // setup for datatables
  var argDataTables = {
    url: "<?= base_url(); ?>/master_barang/get_datatables_json_penjualan",
    columns: [                        
      {"data": "name"},
      {"data": "product_barcode"},
      {"data": "name"},
      {"data": "stock"},
      {"data": "selling_price"},
      {"data": "action"}
    ],
    custom_columns: [
      {"index": 0, "val": "index"},
    ], 
    search: {}
  };

  var table = setupDatatable(argDataTables);
</script>
