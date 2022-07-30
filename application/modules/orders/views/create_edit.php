<!-- Content Header (Page header) -->
<?= page_header("Pembelian"); ?>

<!-- Main content -->
<section class="content">
  <div class="box">
    <!-- /.box-header -->
    <div class="box-header">
      <h3 class="box-title">
        <i class="fa fa-shopping-cart"></i> 
        <?= (isset($purchases)) ?  'Lihat': 'Tambah'; ?> Pembelian
      </h3>
    </div>
    <?php $form_error = form_error('products[]'); ?>
    <!-- form start -->
    <?php echo form_open($form_action,  array('id' => 'form', 'class' => 'form-horizontal')); ?>
      <div class="box-body">
        <input type="hidden" name="kode_pembelian" value="<?= $purchase_code; ?>">
        <input type="hidden" id="jumlah_pembelian" name="jumlah_pembelian" value="">
        <?= input_text(['label' => 'Kode Pembelian', 'name' => 'kode_pembelian', 'disabled' => true, 'value' => "PB" . $purchase_code], true); ?>
        <?= input_select(['label' => 'Supplier *', 'name' => 'supplier', 'list' => $supplier, 'selected_value' => $purchases['supplier_id'] ?? '', 'disabled' => (isset($purchases)) ? true : false, 'error' => form_error('supplier')], true); ?>
        <?= input_text(['label' => 'No. Faktur', 'name' => 'no_faktur', 'value' => $purchases['invoice_number'] ?? '', 'disabled' => (isset($purchases)) ? true : false], true); ?>
        <?= input_select(['label' => 'Pembayaran', 'name' => 'pembayaran', 'list' => ['Tunai', 'Kredit'], 'selected_value' => $purchases['payment'] ?? 'Tunai', 'disabled' => (isset($purchases)) ? true : false ], true); ?>
        <div id="due_date_container" class="d-none">
          <?= input_text(['label' => 'Jatuh Tempo', 'name' => 'due_date', 'class' => 'datepicker'], true); ?>
        </div>
        <?= input_text(['label' => 'Jumlah', 'name' => 'jumlah', 'disabled' => true, 'value' => isset($purchases) ?  intToRupiah((int) $purchases['total']) : 'Rp. 0'], true); ?>
        <div id="product_container"></div>
        <div class="">
          <?php if (!isset($purchases)) { ?>
            <div style="width: 100%;margin-bottom: 10px;">
              <button id="add_product" type="button" class="btn btn-success" style="display: block;margin-left: auto;">Tambah</button>
            </div>
          <?php } ?>
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
                <th>Tgl. Kadaluarsa</th>
                <th>Kuantiti</th>
                <th>Harga</th>
                <th>Jumlah</th>
                <?php if (!isset($purchases)) { ?>
                  <th><i class="fa fa-cog"></i></th>
                <?php } ?>
              </tr>
            </thead>
            <tbody>
              <?php if (isset($purchase_detail) && count($purchase_detail) > 0) { ?>
                <?php foreach($purchase_detail as $key => $pd) { ?>
                  <tr id="empty_data">
                    <td><?= ++$key; ?></td>
                    <td><?= $pd['name']; ?></td>
                    <td><?= $pd['batch_number']; ?></td>
                    <td><?= ymdtoDmy($pd['expired_date']); ?></td>
                    <td><?= $pd['quantity']; ?></td>
                    <td><?= intToRupiah((int) $pd['price']); ?></td>
                    <td><?= intToRupiah((int) $pd['price'] * (int) $pd['quantity']); ?></td>
                  </tr>
                <?php } ?>
              <?php } else { ?>
                <tr id="empty_data">
                  <td class="text-center" colspan="8">Belum ada data</td>
                </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
      <div class="box-footer">
        <div class="pull-right">
          <a href="<?php echo site_url($base); ?>" class="btn btn-danger" style="margin-right:  10px;"><i class="fa fa-<?= (!isset($purchases)) ? 'ban' : 'angle-left'; ?>"></i> 
            &nbsp;<?= (!isset($purchases)) ? 'Batal' : 'Kembali'; ?>
          </a>
          <?php if (!isset($purchases)) { ?>
              <button type="submit" class="btn btn-primary"><i class="fa fa-<?php echo $action == 'add' ? 'plus' : 'pencil'; ?>" style="margin-right: 10px;"></i> Simpan</button>
          <?php } ?>
        </div>
      </div> 
    <?php echo form_close(); ?>
  </div>
</div>

</section>
<!-- /.content -->

<div class="modal fade" id="modal_barang" >
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Tambah Barang</h4>
      </div>
      <div class="modal-body">
        <p>Scan atau masukan kode barcode dibawah ini!</p>
        <form id="form_search_barcode" class="form-horizontal" action="" autocomplete="off">
          <input id="barcode" type="hidden" name="barcode">
          <input id="satuan" type="hidden" name="satuan">
          <div class="form-group row">
          <div class="col-sm-8">
            <input id="input_barang" class="form-control typeahead" type="text" placeholder="Masukan Barcode atau Nama Barang" required="">
          </div>
          <button type="submit" class="btn btn-primary"><i class="icon-spin fa fa-search" style="margin-right: 10px;"></i>Cari</button>
          </div>
        </form>
        <p id="empty_product" class="d-none">Data yang dicari tidak ada, silahkan cari kembali atau tambahkan terlebih dahulu</p>
        <form id="form_add_barang" class="d-none" autocomplete="off">
          <input id="product_id" type="hidden" name="product_id">
          <input id="multiplier" type="hidden" name="multiplier">
          <?= input_text(['label' => 'Nama Barang', 'name' => 'nama_barang', 'disabled' => true]); ?>
          <?= input_text(['label' => 'No. Batch', 'name' => 'no_batch']); ?>
          <?= input_select(['label' => 'Ukuran *', 'name' => 'ukuran', 'list' => ['besar', 'kecil']], false); ?>
          <?= input_text(['label' => 'Kuantiti *', 'name' => 'quantity', 'type' => 'number']); ?>
          <?= input_text(['label' => 'Harga (Beli)', 'name' => 'price']); ?>
          <?= input_text(['label' => 'Tanggal Kadaluarsa', 'name' => 'expired_date', 'class' => 'datepicker'], false); ?>
          <div class="checkbox">
            <label for="ubah_harga_beli">
              <input type="checkbox" name="ubah_harga_beli" id="ubah_harga_beli">
                Ubah Harga Beli
            </label>
          </div>
          <div class="checkbox">
            <label for="ubah_harga_jual">
              <input type="checkbox" name="ubah_harga_jual" id="ubah_harga_jual">
                Ubah Harga Jual
            </label>
          </div>
          <div id="container_input_harga_jual" class="d-none">
            <?= input_text(['label' => 'Harga Jual', 'name' => 'selling_price']); ?>
          </div>
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
  'use strict'

  var products = []

  $('#price, #selling_price').keyup(function() {
    $(this).val(formatRupiah(this.value, "Rp. "));
  });

  $('.datepicker').datepicker({
    autoclose: true,
    format: "dd/mm/yyyy"
  })

  $('#form_search_barcode').on('submit', function(e) {
    e.preventDefault();
    var barcode = $('#barcode').val();
    var form = $('#form_search_barcode')

    // if barcode is null then get from input barang
    if (!barcode) {
      barcode = $('#input_barang').val()
    }

    form.find('.icon-spin').removeClass('fa-search');
    form.find('.icon-spin').addClass('fa-spinner fa-spin');
    form.find('button[type=submit]').prop('disabled', true)

    // clear input
    $('#no_batch').val('')
    $('#quantity').val('')

    $.ajax({
      url: baseUrl + 'master_barang/barang',
      data: { name: barcode }
    }).then(function(res) {
      products = res
      var result = res[0]
      form.find('.icon-spin').addClass('fa-search');
      form.find('.icon-spin').removeClass('fa-spinner fa-spin');
      form.find('button[type=submit]').prop('disabled', false)
      if (result) {
        $('form#form_add_barang').removeClass('d-none');
        $('#empty_product').hide()

        // clear item select
        $('#ukuran').empty().trigger('change')

        var newOption = new Option('Silahkan Pilih', 0, false, false)
        $('#ukuran').append(newOption).trigger('change')

        products.map(function(product) {
          var newOption = new Option(product.size, product.size, false, false)
          $('#ukuran').append(newOption).trigger('change')
        })

        $('#nama_barang').val(result.name)
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
      var product_id = $('#product_id').val()
      var satuan = $('#satuan').val()
      $('#empty_data').remove()

      // if harga jual is checked (update product price)
      if ($('#ubah_harga_jual').prop('checked') || $('#ubah_harga_beli').prop('checked')) {
        var form = $('#form_add_barang')[0]
        var formData = new FormData(form)
        formData.append('product_id', product_id);
        formData.append('satuan', satuan);

        $.ajax({
          method: 'POST',
          data: formData,
          processData:false,
          contentType:false,
          url: '<?= base_url(); ?>master_barang/update_product_price/',
          success: function(result) {
            console.log(result)
          }
        })
      }

      $('#modal_barang').modal('hide')
      var orderNumber = $('#table_products tr:last-child > td:nth-child(1)').text();
      orderNumber++;
      
      var namaBarang = $('#nama_barang').val()
      var price = rupiah_to_integer($('#price').val())
      var harga = formatRupiah(price, "Rp. ")
      var noBatch = $('#no_batch').val() || 0
      var quantity = $('#quantity').val() || 0
      var quantityReal = parseInt($('#quantity').val()) * parseInt($('#multiplier').val()) || 0
      var barcode = $('#barcode').val()
      var productId = $('#product_id').val()
      var expiredDate = $('#expired_date').val()
      var total = parseInt(price) * parseInt(quantity)
      var totalRp = formatRupiah(total, "Rp. ")

      // add data to table
      var newProduct = `<tr>
          <td>${orderNumber}</td>
          <td>${namaBarang}</td>
          <td>${noBatch}</td>
          <td>${expiredDate}</td>
          <td>${quantity}</td>
          <td>${harga}</td>
          <td>${totalRp}</td>
          <td>
            <button type="button" class="btn hapus-row btn-sm btn-danger" style="display: inline-block;">
              <i class="fa fa-fw fa-trash-o"></i>
            </button>
          </td>
        </tr>`
      var inputProduct = `<input type="hidden" name="products[]" value="${productId}|${noBatch}|${quantityReal}|${price}|${expiredDate}">`

      $('#table_products tbody').append(newProduct);
      $('#product_container').append(inputProduct);

      var jumlahSementara = $('#jumlah').val()
      jumlahSementara = rupiah_to_integer(jumlahSementara)
      var jumlahBaru = jumlahSementara + parseInt(total)
      var jumlahBaruRupiah = formatRupiah(jumlahBaru, "Rp. ")
      $('#jumlah').val(jumlahBaruRupiah)
      $('#jumlah_pembelian').val(jumlahBaru)
      setTimeout(function() {
        $('#no_batch').focus()
      }, 1)
      
      // clear input form
      $('#nama_barang').val('')
      $('#form_add_barang').find("input[type=text], select").val("")
      $('#satuan').trigger('change')
      $('#ukuran').trigger('change')
    }
  })

  $('#modal_barang').on('show.bs.modal', function (e) {
    var containerInputHargaJual = $('#container_input_harga_jual')
      
    if (!$('#form_add_barang').hasClass('d-none') && ($('#nama_barang').val() == "")) {
      $('#form_add_barang').addClass('d-none')
    }
    $('#ubah_harga_jual').prop('checked', false)

    if (!containerInputHargaJual.hasClass('d-none')) {
      containerInputHargaJual.addClass('d-none')
    }     

    if (!$('#empty_product').hasClass('d-none')) {
      $('#empty_product').addClass('d-none');
    }

    $('#barcode').val('')
    $('#input_barang').val('')
  })

  $('#table_products').on('click', '.hapus-row', function() {
    var indexValue = $(this).parent().parent().find('td')[0].innerHTML

    $(this).parent().parent().remove();
    var lastRow = $('#table_products tr:last-child > td:nth-child(1)').text();
    for (let i = 0; i < lastRow; i++) {
      $(`#table_products tr:nth-child(${i}) > td:nth-child(1)`).text(i);
    }

    // delete data in product_container
    $('#product_container input')[indexValue - 1].remove()
  });

  $('#ubah_harga_jual').on('change', function() {
    var containerInputHargaJual = $('#container_input_harga_jual')
    if ($(this).prop('checked')) {
      if (containerInputHargaJual.hasClass('d-none')) {
        containerInputHargaJual.removeClass('d-none')
      }     
    } else {
      if (!containerInputHargaJual.hasClass('d-none')) {
        containerInputHargaJual.addClass('d-none')
      }     
    }
  })

  $('#input_barang').typeahead({
    source: function (name, process) {
      $.ajax({
        url: baseUrl + 'master_barang/barang/?name=' + name,
        method: 'GET',
        async: true,
        dataType: 'JSON',
        success: function(data) {
           var resultTemp = []
           var resultList = []

           data.forEach(function (item) {
             if (resultTemp.indexOf(item.id) == -1) {
               var link = { id: item.id, name: item.name, product_barcode: item.product_barcode, denomination_id: item.denomination_id };

               resultTemp.push(item.id)
               resultList.push(link)
             }
           });

          return process(resultList)
        }
      })
    },
    afterSelect: function (data) {
      $('#input_barang').val(data.name)
      $('#product_id').val(data.id)
      $('#barcode').val(data.product_barcode)
      $('#satuan').val(data.denomination_id)
    }
  })

  $('#ukuran').on('change', function() {
    // cek di products
    if (this.value != 0) {
      var productSelected = products.filter(product => product.size == this.value)

      $('#selling_price').val(formatRupiah(productSelected[0].selling_price, "Rp. "));
      $('#price').val(formatRupiah(productSelected[0].buying_price, "Rp. "));
      $('#multiplier').val(productSelected[0].multiplier) 
    }
  })

  $('#pembayaran').change(function() {
    let value = $(this).val()
    if (value == 'kredit') {
      $('#due_date_container').removeClass('d-none')
    } else {
      if (!$('#due_date_container').hasClass('d-none')) {
        $('#due_date_container').addClass('d-none')
      }
    }
  })

  $('#add_product').click(function() {
    $('#form_add_barang')[0].reset();
    $('#form_add_barang').addClass('d-none');
    clearInputText('quantity')
    clearInputSelect('ukuran')

    $('#modal_barang').modal({backdrop: 'static', keyboard: false})  
    $('#modal_barang').modal('show');
    $('#save_button').prop('disabled', true)
  })

  function productValidation() {
    var ukuran = $('#ukuran').val()
    var quantity = $('#quantity').val()

    if (ukuran == '0') {
      errorInputSelect('ukuran', 'Ukuran wajib diisi')
    }

    if (quantity < 1) {
      errorInputText('quantity', 'Kuantiti wajib diisi lebih dari 0')
    }

    if (ukuran == '0' || quantity < 1) {
      return false
    }

    return true
  }
</script>