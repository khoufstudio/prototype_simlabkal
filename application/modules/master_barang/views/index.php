<!-- Content Header (Page header) -->
<?= page_header("Master Barang"); ?>
<!-- Main Content -->
<section class="content">
  <div class="box">
    <div class="box-header with-border" style="display: flex;justify-content: space-between;">
      <form id="form_stok_barang" action="#" style="display: flex;">
        <input id="stok_barang" class="form-control" type="text" name="stok_barang" placeholder="Stok Barang" type="number">
        <select id="operasi" class="form-control" name="operasi">
            <option value="=">sama dengan</option>
            <option value=">=">lebih dari sama dengan</option>
            <option value<="<=">kurang dari sama dengan</option>
            <option value=">">lebih dari</option>
            <option value="<">kurang dari</option>
            <option value="!=">tidak sama dengan</option>
        </select>
        <button class="btn btn-success" style="margin-left: 10px;">Cari</button>
      </form>
      <div>
        <a href="<?= site_url('master_barang/download_csv'); ?>" class="btn btn-success"><i class="fa fa-file-excel-o margin-right-lg"></i> Download CSV</a>
        <a href="<?= site_url('master_barang/create'); ?>" class="btn btn-info"><i class="fa fa-plus margin-right-lg"></i> Tambah</a>
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
            <th class="text-center">Barcode</th>
            <th class="text-center">Nama Barang</th>
            <th class="text-center">Stok</th>
            <th class="text-center">Harga Beli</th> 
            <th class="text-center">Harga Jual</th>
            <th class="text-center">Kepemilikan</th>
            <th class="text-center">Golongan</th>
            <th class="text-center">ED</th>
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
  </div>
</section>

<script>
  var todayPlus6Months = moment()
  todayPlus6Months.add('months', 6)

  // setup for datatables
  var argDataTables = {
    url: "<?= base_url(); ?>/master_barang/get_datatables_json",
    columns: [                        
      {"data": "name"},
      {"data": "product_barcode"},
      {"data": "name"},
      {"data": "stock"},
      {"data": "buying_price"},
      {"data": "selling_price"},
      {"data": "ownership"},
      {"data": "product_type"},
      {"data": "expired_date"},
      {"data": "action"}
    ],
    custom_columns: [
      {"index": 0, "val": "index"},
    ], 
    createdRow: function(row, data, index) {
      var expiredDate = moment(data.expired_date, 'DD/MM/YYYY')
      if (expiredDate < todayPlus6Months) {
        $(row).addClass('bg-yellow')
      }
    },
    search: {}
  };

  var table = setupDatatable(argDataTables);

  $('#table tbody').on('click', '.btn-delete', function(e) {
    e.preventDefault()

    show_sweet_alert({
      text: 'Apakah anda ingin menghapus?',
      type: 'warning',
      timer: 36000,
      showConfirmButton: true,
      showCancelButton: true
    }).then((result) => {
      console.log(result)
      if (result.value) {
        $(this).parent().submit()
      } 
    })
  })

  $('#form_stok_barang').submit(function(e) {
    e.preventDefault()
    var stokBarang = $('#stok_barang').val()
    var operasi = $('#operasi').val()
    
    argDataTables.search = { stok: stokBarang, operasi }
    table.draw();
  })

</script>
