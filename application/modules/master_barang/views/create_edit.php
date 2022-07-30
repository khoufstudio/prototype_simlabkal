<!-- Content Header (Page header) -->
<?= page_header("Master Barang"); ?>

<!-- Main content -->
<section class="content">
  <div class="box">
    <!-- /.box-header -->
    <div class="box-header">
      <h3 class="box-title">
        <i class="fa fa-shopping-cart"></i>
        <?= ($action === 'edit') ? 'Edit' : 'Tambah'; ?> Master Barang      
      </h3>
    </div>
    <!-- form start -->
    <?php echo form_open($form_action,  array('id' => 'form', 'class' => 'form-horizontal')); ?>
      <div class="box-body">
        <?php if ($action === 'edit'):  ?>
          <input type="hidden" name="product_id" value="<?= $product['id'] ?? ''; ?>">
        <?php endif; ?>
        <?php if (isset($sellings['invoice_number'])) { ?>
          <input type="hidden" name="no_faktur" value="<?= $sellings['invoice_number'] ?? ''; ?>">
        <?php } ?>
        <div class="row px-15px">
          <div class="col-md-5">
            <?= input_text(['label' => 'Nama Barang *', 'name' => 'nama_barang', 'value' => $product['name'] ?? '', 'error' => form_error('nama_barang')],  false); ?>
          </div>
          <div class="col-md-1"></div>
          <div class="col-md-5">
            <?= input_text(['label' => 'No Batch', 'name' => 'no_batch', 'value' => $product['batch_number_product'] ?? ''],  false); ?>
          </div>
        </div>
        <div class="row px-15px">
          <div class="col-md-5">
            <?= input_select(['label' => 'Golongan *', 'name' => 'golongan', 'list' => $types, 'selected_value' => $product['type'] ?? '', 'error' => form_error('golongan')],  false); ?>
          </div>
          <div class="col-md-1"></div>
          <div class="col-md-5">
            <?= input_select(['label' => 'Kepemilikan *', 'name' => 'kepemilikan', 'list' => ['Sendiri', 'Titipan'], 'selected_value' => $product['ownership'] ?? '', 'error' => form_error('kepemilikan')],  false); ?>
          </div>
        </div>
        <div class="row px-15px">
          <div class="col-md-5">
            <?= input_text(['label' => 'Kode Barang (Barcode)', 'name' => 'kode_barang', 'value' => $product['product_barcode'] ?? ''],  false); ?>
          </div>
          <div class="col-md-1"></div>
        </div>

        <div id="size_container"></div>
        <?php if (form_error('sizes[]')): ?>
          <div class="alert alert-danger no-fade">
            <p><?= form_error('sizes[]'); ?></p>
          </div>
        <?php endif; ?>
        <div class="">
          <table id="table_sizes" class="table table-bordered">
            <thead>
              <tr>
                <th>No</th>
                <th>Ukuran</th>
                <th>Satuan</th>
                <th>Harga Beli</th>
                <th>Harga Jual</th>
              </tr>
            </thead>
            <tbody>
                <tr>
                  <td>1</td>
                  <td>Kecil</td>
                  <td>
                    <select id="select_satuan_1" class="form-control" name="ukuran_kecil">
                      <option value="">Pilih Satuan</option>
                        <?php foreach ($denominations_small as $ds): ?>
                            <?php if (isset($product_prices[0])): ?>
                              <option value="<?= $ds['id']; ?>" <?= ($ds['id'] == $product_prices[0]['denomination_id']) ? 'selected' : ''; ?>><?= $ds['name']; ?></option>
                            <?php else: ?>
                              <option value="<?= $ds['id']; ?>"><?= $ds['name']; ?></option>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </select>
                  </td>
                  <td>
                    <input class="form-control" name="harga-beli-1" type="text" placeholder="Harga Beli" value="<?= isset($product_prices[0]) ? intToRupiah($product_prices[0]['buying_price']) : ''; ?>">
                  </td>
                  <td>
                      <input class="form-control" name="harga-jual-1" type="text" placeholder="Harga Jual" value="<?= isset($product_prices[0]) ? intToRupiah($product_prices[0]['selling_price']) : ''; ?>">
                  </td>
                </tr>
                <tr>
                  <td>2</td>
                  <td>Besar</td>
                  <td>
                    <select id="select_satuan_2" class="form-control" name="ukuran_besar">
                      <option value="">Pilih Satuan</option>
                        <?php foreach ($denominations_large as $ds): ?>
                            <?php if (isset($product_prices[1])): ?>
                              <option value="<?= $ds['id']; ?>" <?= ($ds['id'] == $product_prices[1]['denomination_id']) ? 'selected' : ''; ?>><?= $ds['name']; ?></option>
                            <?php else: ?>
                              <option value="<?= $ds['id']; ?>"><?= $ds['name']; ?></option>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </select>
                  </td>
                  <td>
                    <input class="form-control" name="harga-beli-2" type="text" placeholder="Harga Beli" value="<?= isset($product_prices[1]) ? intToRupiah((int) $product_prices[1]['buying_price']) : ''; ?>">
                  </td>
                  <td>
                      <input class="form-control" name="harga-jual-2" type="text" placeholder="Harga Jual" value="<?= isset($product_prices[1]) ? intToRupiah((int) $product_prices[1]['selling_price']) : ''; ?>">
                  </td>
                </tr>
            </tbody>
          </table>
        </div>
        <div id="size_container2">
          <?php if (isset($denomination_conversions)): ?>
            <input type="hidden" id="sizes2" name="sizes2" value="<?= $denomination_conversions['conversion_small'] . '|*' . $denomination_conversions['conversion_large'] . '|*' . $denomination_conversions['count']; ?>">
          <?php else: ?>
            <input type="hidden" id="sizes2" name="sizes2" value="">
          <?php endif; ?>
        </div>
        <h4 class="text-bold">
          Konversi Satuan
        </h4>
        <?php if (form_error('sizes2')): ?>
          <div class="alert alert-danger no-fade">
            <p><?= form_error('sizes2'); ?></p>
          </div>
        <?php endif; ?>
        <div class="">
          <table id="table_sizes2" class="table table-bordered">
            <thead>
              <tr>
                <th style="width: 5%;">No</th>
                <th>Satuan Besar</th>
                <th>Satuan Kecil</th>
                <th>Jumlah (satuan kecil = 1 satuan besar)</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>
                  1
                </td>
                <td>
                    <input class="form-control" id="conversion_large" name="conversion_large" type="text" placeholder="Satuan Besar" value="<?= isset($denomination_conversions) ? $denomination_conversions['conversion_large_label'] : ''; ?>" readonly>
                </td>
                <td>
                    <input class="form-control" id="conversion_small" name="conversion_small" type="text" placeholder="Satuan Kecil" value="<?= isset($denomination_conversions) ? $denomination_conversions['conversion_small_label'] : ''; ?>" readonly>
                </td>
                <td>
                    <input class="form-control" id="jumlah" name="jumlah" type="number" placeholder="Jumlah" value="<?= isset($denomination_conversions) ? $denomination_conversions['count'] : ''; ?>">
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
      <div class="box-footer">
        <div class="pull-right">
          <a href="<?php echo site_url($base); ?>" class="btn btn-danger" style="margin-right:  10px;"><i class="fa fa-<?= (!$action == 'edit') ? 'ban' : 'angle-left'; ?>"></i> 
            &nbsp;<?= ($action != 'edit') ? 'Batal' : 'Kembali'; ?>
          </a>
          <button id="button_submit_form" type="submit" class="btn btn-primary"><i class="fa fa-<?php echo $action == 'add' ? 'plus' : 'pencil'; ?>" style="margin-right: 10px;"></i> Simpan</button>
        </div>
      </div> 
    <?php echo form_close(); ?>
  </div>
</div>
</section>
<script>
  $('[name=harga-beli-1], [name=harga-beli-2], [name=harga-jual-1], [name=harga-jual-2]').keyup(function() {
    $(this).val(formatRupiah(this.value, "Rp. "));
  })

  $('#add_size').on('click', function() {
    $('#empty_data2').remove()

    var orderNumber = $('#table_sizes2 tr:last-child > td:nth-child(1)').text();
    orderNumber++;

    // add 
    $('#table_sizes2 tbody').append(`
      <tr>
        <td class="text-center">${orderNumber}</td>
        <td class="text-center">
          <select id="select_ukuran1_${orderNumber}" class="form-control" name="ukuran">
            <option value="">Pilih Ukuran</option>
            <?php foreach ($denominations as $ds): ?>
              <option value="<?= $ds['id']; ?>"><?= $ds['name']; ?></option>
            <?php endforeach; ?>
          </select>
        </td>
        <td class="text-center">
          <select id="select_ukuran2_${orderNumber}" class="form-control" name="ukuran">
            <option value="">Pilih Ukuran</option>
            <?php foreach ($denominations as $ds): ?>
              <option value="<?= $ds['id']; ?>"><?= $ds['name']; ?></option>
            <?php endforeach; ?>
          </select>
        </td>
        <td class="text-center">
          <input class="form-control jumlah-ukuran2-{orderNumber}" type="text" placeholder="Jumlah">
        </td>
        <td class="text-center">
          <button type="button" class="btn hapus-row data-${orderNumber} btn-sm btn-danger" style="display: inline-block;">
            <i class="fa fa-fw fa-trash-o"></i>
          </button>
        </td>
      </tr>
    `)
  })

  $('body').on('change', '[class*=harga-beli-], [class*=harga-jual-]', function() {
    var className = $(this).attr('class').split(' ')[1]
    var currentValue = this.value

    $('.' + className).val(formatRupiah(currentValue, "Rp. "));
  });

  $('#table_sizes2').on('click', '.hapus-row', function() {
    var classValue = $(this).attr('class')
    var rowNumber = classValue.match(/[0-9]/g).join()
    var deleted_value = $(this).parents('tr').find("td:eq(4)").text();
    
    $('#size_container2 > input').eq(rowNumber - 1).remove()
    $('.product-' + rowNumber).remove()
    $(this).parent().parent().remove();
    var lastRow = $('#table_sizes2 tr:last-child > td:nth-child(1)').text();
    if (lastRow != 0) {
      for (let i = 0; i < lastRow; i++) {
        $(`#table_sizes2 tr:nth-child(${i+1}) > td:nth-child(1)`).text(i + 1);
      }
    } else {
      $('#table_sizes2 tbody').append(`
        <tr id="empty_data">
          <td class="text-center" colspan="7">Belum ada data</td>
        </tr>
      `)
    }
  });

  $('body').on('change', '.size', function() {
    // ajax
    var idSize = $(this).attr('id')
    var regex = /\d+/
    var idDenomination = '#select_satuan_' + idSize.match(regex)[0]
    
    var size = $(this).val()
    $.ajax({
      url: '<?= base_url(); ?>master_satuan/satuan/',
      data: { 
        size,  
        select: 'id, name'
      }
    }).then(function(res) {
      var result = JSON.parse(res)

      $(idDenomination).removeAttr('disabled')
      $(idDenomination)
        .find('option')
        .remove()
        .end()

      for (rs in result) {
        $(idDenomination).append(`<option value='${result[rs].id}'>${result[rs].name}</option>`)
      }
    })
  })

  $('#button_submit_form').click(function(e) {
    e.preventDefault()
    // add input size before submit
    $('#table_sizes tbody tr').each(function(index, value) {
      order = index + 1
      var currentValue = []

      $(this).find('td').each(function(index, val) {
          var inputValue = $(this).find('input, select').val()
            currentValue.push(inputValue)
      })

      if (currentValue.length > 1) {
        var buyingPrice = rupiah_to_integer(currentValue[3])
        var sellingPrice = rupiah_to_integer(currentValue[4])
        var denominationId = currentValue[2]

        var inputSize = `<input type="hidden" name="sizes[]" value="${denominationId}|*${buyingPrice}|*${sellingPrice}">`
        // delete if there is same denomation 
        $('#size_container > input').each(function(index, val) {
          var valueTemp = val.value.split('|*')
          if (valueTemp[0] == denominationId) {
            $('#size_container > input').eq(index).remove()
          }
        })

        if (denominationId != '' && buyingPrice != 0 && sellingPrice != 0) {
          $('#size_container').append(inputSize);
        }
      }
    })
    
    var currentValue = []
    currentValue[1] = $('#select_satuan_1').val()
    currentValue[2] = $('#select_satuan_2').val()
    currentValue[3] = $('#jumlah').val()

    if ((currentValue[1] != '' && currentValue[1] != null) && (currentValue[2] != '' && currentValue[2] != null) && (currentValue[3] != '' && currentValue[3] != null)) {
      $('#sizes2').val(`${currentValue[1]}|*${currentValue[2]}|*${currentValue[3]}`)
    } else {
      if ($('#sizes2').length) {
        $('#sizes2').remove()
      }
    }

    $('#form').submit()
  })

  $('#select_satuan_1').change(function() {
    $('#conversion_small').val($('#select_satuan_1 option:selected').text())
  })

  $('#select_satuan_2').change(function() {
    $('#conversion_large').val($('#select_satuan_2 option:selected').text())
  })
</script>
