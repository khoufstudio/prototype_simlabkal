<!-- Content Header (Page header) -->
<?= page_header("Keuangan"); ?>

<!-- Main Content -->
<section class="content">
  <div class="box">
    <div class="box-header with-border" style="display: flex;justify-content: flex-end;">
      <div>
        <button id="add_finance" class="btn btn-success"><i class="fa fa-plus margin-right-lg"></i> Tambah</button>
      </div>
    </div>
    <div class="box-body">
      <?php if (isset($form_message)): ?>
        <?php if (isset($form_success) && !$form_success): ?>
          <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h4><i class="icon fa fa-close"></i> Gagal!</h4>
            <?php echo $form_message; ?>
          </div>
        <?php else: ?>
          <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h4><i class="icon fa fa-check"></i> Berhasil!</h4>
            <?php echo $form_message; ?>
          </div>
        <?php endif; ?>
      <?php endif; ?>
      <table id="table" class="table table-bordered table-striped">
        <thead>
          <tr>
            <th class="text-center" width="5%">No</th>
            <th class="text-center">Tanggal</th>
            <th class="text-center">Tipe</th>
            <th class="text-center">Pemasukan/Pengeluaran</th>
            <th class="text-center">Total</th>
            <th class="text-center">Keterangan</th>
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

<!-- Modal Keuangan-->
<div class="modal fade" id="modal_keuangan">
  <?= form_open('keuangan/store', 'id="form_finance"'); ?>
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header bg-green">
          <button class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Tambah Keuangan</h4>  
        </div>
        <div class="modal-body">
          <?= input_select(array('name' => 'finance_type', 'label' => 'Tipe *', 'list' => array('Pemasukan', 'Pengeluaran')));?>
          <?= input_select(array('name' => 'name_income_expense', 'label' => 'Nama Pemasukan / Pengeluaran *', 'list' => $transaction, 'disabled' => true));?>
          <?= input_text(array('name' => 'total', 'label' => 'Total *'));?>
          <div class="form-group">
            <label for="deskripsi">Keterangan</label>
            <textarea id="deskripsi" class="form-control" name="deskripsi" cols="30" rows="4"></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button class="btn btn-link" data-dismiss="modal">Tutup</button>
          <button id="button_submit" class="btn btn-success"><i id="icon_submit" class="fa fa-send" style="margin-right: 10px;"></i> Simpan</button>
        </div>
      </div>
    </div> 
  <?= form_close(); ?>
</div>

<script>
  // setup for datatables
  var argDataTables = {
    url: baseUrl + "keuangan/get_datatables_json",
    columns: [                        
      {"data": "id"},
      {"data": "created_at"},
      {"data": "finance_type"},
      {"data": "name_income_expense"},
      {"data": "total"},
      {"data": "description"},
    ],
    custom_columns: [
      {"index": 0, "val": "index"},
    ],
  };

  var dataTable = setupDatatable(argDataTables);

  $('#add_finance').click(function() {
    $('#form_finance')[0].reset();
    var url = $('#form_finance').attr('action')
    var formUrl = url.replace(/update.*/g, "store")
    $('#form_finance').attr('action', formUrl)

    openModal('modal_keuangan')
  })

  $('#form_finance').submit(function(e) {
      e.preventDefault()

      var form = $(this)
      var inputs = form.find('input, textarea')
      var data = new FormData(form[0])

      $.ajax({
        method: 'POST',
        data,
        processData: false,
        contentType: false,
        url: baseUrl + 'keuangan/store',
        beforeSend: function() {
          $('#button_submit').attr('disabled', true)
        },
        success: function(data) {
          if (data.success) {
            dataTable.draw()
            $('#modal_keuangan').modal('hide')
          } else {
            data.message.forEach(message => {
              if (message.indexOf('Tipe') != -1) {
                errorInputSelect('finance_type', 'Tipe wajib diisi')
              }

              if (message.indexOf('Nama Pemasukan') != -1) {
                errorInputSelect('name_income_expense', 'Wajib diisi')
              }

              if (message.indexOf('total') != -1) {
                errorInputText('total', 'Total wajib diisi')
              }
            })
          }
        },
        complete: function() {
          $('#button_submit').attr('disabled', false)
        }
      })
  })

  // on modal close clear 
  $('#modal_keuangan').on('hidden.bs.modal', function() {
    // clear input
    clearInputText('total')
    clearInputSelect('finance_type', 'name_income_expense')
    
    $('#name_income_expense').attr('disabled', true)
  })

  $('#finance_type').on('change', function() {
    $('#name_income_expense').attr('disabled', false)
    clearInputSelect('name_income_expense')
    $('#name_income_expense option').remove()

    const pemasukan = ['Sumbangan', 'Lainnya']
    const pengeluaran = ['Gaji', 'Listrik', 'Lainnya']

    let listOptions = ['']
    if (this.value == 'pemasukan') {
      listOptions = listOptions.concat(pemasukan)
    } else {
      listOptions = listOptions.concat(pengeluaran)
    }

    listOptions.forEach(option => {
      var id = option.toLowerCase()
      var text = (option == '') ? 'Silahkan Pilih' : option
      var newOption = new Option(text, id, false, false)

      $('#name_income_expense').append(newOption).trigger('change')      
    })
  })

  $('#total').keyup(function() {
    $('#total').val(formatRupiah(this.value, "Rp. "));
  });
</script>
