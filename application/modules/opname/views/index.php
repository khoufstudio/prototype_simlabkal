<!-- Content Header (Page header) -->
<?= page_header("Opname"); ?>

<!-- Main Content -->
<section class="content">
  <div class="box">
    <div class="box-header with-border" style="display: flex;justify-content: space-between;">
      <div class="input-group" style="width: 300px;margin-right: 10px;">
        <div class="input-group-addon">
          <i class="fa fa-calendar"></i>
        </div>
        <input type="text" class="form-control pull-right" id="tanggal_opname">
      </div>
      <div class="pull-right"> 
        <?= form_open('opname/print_opname', 'class="inline"'); ?>
          <input type="hidden" id="periode" name="periode" />
          <button class="btn btn-primary">
            <i class="fa fa-print margin-right-lg"></i> Print
          </button>
        <?= form_close(); ?>
        <button id="add_opname" class="btn btn-success"><i class="fa fa-plus margin-right-lg"></i> 
          Tambah
        </button>
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
            <th>Tanggal Opname</th>
            <th>Nama Barang</th>
            <th>Stok Barang</th>
            <th>Stok Barang Fisik</th>
            <th>Alasan</th>
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

<!-- Modal-->
<div class="modal fade" id="modal_opname">
  <?= form_open('opname/store', 'id="form_opname"'); ?>
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header bg-green">
          <button class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Tambah Opname</h4>  
        </div>
        <div class="modal-body">
          <div id="alert_success" class="alert alert-success alert-dismissible d-none">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h4><i class="icon fa fa-check"></i> Success!</h4>
            Data telah disubmit, silahkan print tiket.
          </div>
          <div class="form-group">
            <label>Nama Barang</label>
            <select id="barang" class="select2" name="barang" style="width: 100%">
              <option value="">Pilih Barang</option>
              <?php 
                foreach ($barang as $brg) {
                  echo '<option value=\''.$brg['id'].'|'.$brg['stock'].'\'>'. $brg['name'].'</option>';
                }
              ?>
            </select>
          </div>
          <div class="form-group">
            <label>Stok Barang Fisik</label>
            <div class="input-group">
              <input type="number" class="form-control" name="stok_barang" id="stok_barang" disabled="">
              <div class="input-group-btn">
                <button id="minus" type="button" class="btn btn-danger">
                  <i class="fa fa-minus"></i>
                </button>
                <button id="tambah" type="button" class="btn btn-primary">
                  <i class="fa fa-plus"></i>
                </button>
              </div>  
            </div>
          </div>
          <div class="form-group">
            <label>Alasan</label>
            <textarea name="alasan" class="form-control"></textarea> 
          </div> 
        </div>
        <input type="hidden" name="stok_asal" id="stok_asal" />
        <div class="modal-footer">
          <button class="btn btn-link" data-dismiss="modal">Tutup</button>
          <button id="button_submit" class="btn btn-success"><i id="icon_submit" class="fa fa-send" style="margin-right: 10px;"></i> Simpan</button>
        </div>
      </div>
    </div> 
  <?= form_close(); ?>
</div>

<script>
  $(function() {
    var tanggalOpname = $('#tanggal_opname').val()
    $('#periode').val(tanggalOpname);
  })
    
  $('#tanggal_opname').daterangepicker({
    "startDate": startOfMonth,
    "endDate": endOfMonth
  });
  
  var tanggalOpname = $('#tanggal_opname').val();

  $('#barang').change(function() {
    var currentValue = this.value
    var currentStock = currentValue.split('|')[1]

    $('#stok_barang').attr('disabled', false)
    $('#stok_barang').val(currentStock)
    $('#stok_asal').val(currentStock)
  })
  
  // setup for datatables
  var argDataTables = {
    url: "<?= base_url(); ?>/opname/get_datatables_json",
    columns: [                        
      {"data": "created_at"},
      {"data": "tanggal_buat"},
      {"data": "product_name"},
      {"data": "stock_current"},
      {"data": "stock_real_current"},
      {"data": "reason"},
    ],
    custom_columns: [
      {"index": 0, "val": "index"},
    ],
    date: tanggalOpname
  };

  var table = setupDatatable(argDataTables);

  $('#tanggal_opname').on('change', function(e) {
    $('#periode').val($(this).val());
    argDataTables.date = $(this).val();
    table.draw();
  })

  $('#minus').on('click', function() {
    if ($('#barang').val() != '' && $('#stok_barang').val() > 0) {
      var stockBarang = $('#stok_barang').val()
      $('#stok_barang').val(--stockBarang)
    }
  })
  
  $('#tambah').on('click', function() {
    if ($('#barang').val() != '') {
      var stockBarang = $('#stok_barang').val()
      $('#stok_barang').val(++stockBarang)
    }
  })

  $('#add_opname').click(function() {
    $('#form_opname')[0].reset();
    $('#barang').val(null).trigger('change')

    $('#modal_opname').modal({backdrop: 'static', keyboard: false})  
    $('#modal_opname').modal('show');
  })
</script>

