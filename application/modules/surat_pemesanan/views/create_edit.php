<!-- Content Header (Page header) -->
<?= page_header("Pemesanan"); ?>

<!-- Main content -->
<section class="content">
  <div class="box">
    <!-- /.box-header -->
    <div class="box-header">
      <h3 class="box-title">
        <i class="fa fa-shopping-cart"></i> 
        <?= (isset($orders)) ?  'Lihat': 'Tambah'; ?> Pemesanan
      </h3>
    </div>
    <!-- form start -->
    <?php echo form_open($form_action,  array('id' => 'form', 'class' => 'form-horizontal')); ?>
      <div class="box-body">
        <?= input_select(['label' => 'Kepada', 'name' => 'kepada', 'list' => $supplier, 'selected_value' => $orders['customer_name'] ?? '', 'disabled' => (isset($orders)) ? true : false], true); ?>
        <?= input_text(['label' => 'Tanggal', 'name' => 'tanggal', 'value' => (isset($orders)) ? date('d/m/Y', strtotime($orders['order_date'])) : date('d/m/Y'), 'class' => 'datepicker disable-autocomplete', 'disabled' => (isset($orders)) ? true : false], true); ?>
        <div id="product_container"></div>
        <div class="">
          <?php if (!isset($orders)) { ?>
            <button id="add_product" type="button" class="btn btn-success pull-right clearfix">Tambah</button>
          <?php } ?>
          <table id="table_products" class="table table-bordered">
            <thead>
              <tr>
                <th>No</th>
                <th>Nama Barang</th>
                <th>Jumlah</th>
                <th>Keterangan</th>
                <?php if (!isset($orders)) { ?>
                  <th><i class="fa fa-cog"></i></th>
                <?php } ?>
              </tr>
            </thead>
            <tbody>
              <?php if (isset($order_detail) && count($order_detail) > 0) { ?>
                <?php foreach($order_detail as $key => $pd) { ?>
                  <tr id="empty_data">
                    <td><?= ++$key; ?></td>
                    <td><?= $pd['name']; ?></td>
                    <td><?= $pd['quantity']; ?></td>
                    <td><?= $pd['description']; ?></td>
                  </tr>
                <?php } ?>
              <?php } else { ?>
                <tr id="empty_data">
                  <td class="text-center" colspan="5">Belum ada data</td>
                </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
      <div class="box-footer">
        <div class="pull-right">
          <a href="<?php echo site_url($base); ?>" class="btn btn-danger" style="margin-right:  10px;"><i class="fa fa-<?= (!isset($orders)) ? 'ban' : 'angle-left'; ?>"></i> 
            &nbsp;<?= (!isset($orders)) ? 'Batal' : 'Kembali'; ?>
          </a>
          <?php if (!isset($orders)) { ?>
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
          <?= input_text(['label' => 'Kuantiti', 'name' => 'quantity', 'type' => 'number']); ?>
          <?= input_text(['label' => 'Keterangan', 'name' => 'keterangan', 'type' => 'text']); ?>
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
    $('#quantity').val('')

    $.ajax({
      url: '<?= base_url(); ?>master_barang/barang/',
      data: { name: barcode }
    }).then(function(res) {
      var result = res[0]
      form.find('.icon-spin').addClass('fa-search');
      form.find('.icon-spin').removeClass('fa-spinner fa-spin');
      form.find('button[type=submit]').prop('disabled', false)
      if (result) {
        $('form#form_add_barang').removeClass('d-none');
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
    var barcode = $('#barcode').val()
    $('#empty_data').remove()

    $('#modal_barang').modal('hide')
    var orderNumber = $('#table_products tr:last-child > td:nth-child(1)').text();
    orderNumber++;
    
    var namaBarang = $('#nama_barang').val()
    var quantity = $('#quantity').val() || 0
    var keterangan = $('#keterangan').val()
    var productId = $('#product_id').val()

    // add data to table
    var newProduct = `<tr>
        <td>${orderNumber}</td>
        <td>${namaBarang}</td>
        <td>${quantity}</td>
        <td>${keterangan}</td>
        <td>
          <button type="button" class="btn hapus-row btn-sm btn-danger" style="display: inline-block;">
            <i class="fa fa-fw fa-trash-o"></i>
          </button>
        </td>
      </tr>`
    var inputProduct = `<input type="hidden" name="products[]" value="${productId}|${quantity}|${keterangan}">`

    $('#table_products tbody').append(newProduct);
    $('#product_container').append(inputProduct);

    // clear input form
    $('#nama_barang').val('')
    $('#quantity').val('')
    $('#keterangan').val('')
  })

  $('#modal_barang').on('show.bs.modal', function (e) {
    var containerInputHargaJual = $('#container_input_harga_jual')
      
    if (!$('#form_add_barang').hasClass('d-none') && ($('#nama_barang').val() == "")) {
      $('#form_add_barang').addClass('d-none')
    }

    $('#barcode').val('')
    $('#input_barang').val('')
    $('#quantity').val('')
    $('#keterangan').val('')
  })

  $('#table_products').on('click', '.hapus-row', function() {
    var deleted_value = $(this).parents('tr').find("td:eq(4)").text();
    $(this).parent().parent().remove();
    var lastRow = $('#table_products tr:last-child > td:nth-child(1)').text();
    for (let i = 0; i < lastRow; i++) {
      $(`#table_products tr:nth-child(${i}) > td:nth-child(1)`).text(i);
    }
  });

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
      $('#barcode').val(data.product_barcode)
    }
  })


  $('#add_product').click(function() {
    $('#form_add_barang')[0].reset();
    $('#form_add_barang').addClass('d-none');
    $('#ukuran').val(null).trigger('change')
      
    $('#modal_barang').modal({backdrop: 'static', keyboard: false})  
    $('#modal_barang').modal('show');
  })
</script>
