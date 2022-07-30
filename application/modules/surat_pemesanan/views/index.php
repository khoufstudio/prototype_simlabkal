<!-- Content Header (Page header) -->
<?= page_header("Surat Pemesanan"); ?>

<!-- Main Content -->
<section class="content">
  <div class="box">
    <div class="box-header with-border" style="display: flex;justify-content: flex-end;">
      <div>
          <a class="btn btn-success" href="<?= site_url('surat_pemesanan/create'); ?>">SP Biasa</a>
          <a class="btn btn-success" href="<?= site_url('surat_pemesanan_obat/create?type_order=0'); ?>">Prekursor</a>
          <a class="btn btn-success" href="<?= site_url('surat_pemesanan_obat/create?type_order=1'); ?>">OTT</a>
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
            <th class="text-center">Pemesan</th>
            <th class="text-center">Jenis Surat</th>
            <th class="text-center">Tanggal Pemesanan</th>
            <th class="text-left"><i class="fa fa-cog"></i></th>
          </tr>
        </thead>
          <tbody>
            <tr> 
              <td colspan="5" class="text-center">
                Tidak ada data
              </td>
            </tr>        
          </tbody>
      </table>
    </div>
  </div>
</section>

<!-- Modal Supplier-->
<div class="modal fade" id="modal_pemesanan">
  <?= form_open('surat_pemesanan/store', 'id="form_pemesanan"'); ?>
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header bg-green">
          <button class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Tambah Supplier</h4>  
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label>Nama Supplier</label>
            <input type="text" class="form-control" name="nama" id="nama" placeholder="Nama Supplier">
          </div>
          <div class="form-group">
            <label>Alamat</label>
            <textarea class="form-control" name="alamat" id="alamat" placeholder="Alamat"></textarea>
          </div>
          <div class="form-group">
            <label>No Kontak</label>
            <input type="text" class="form-control" name="nomor_kontak" id="nomor_kontak" placeholder="No Kontak">
          </div>
          <div class="modal-footer">
            <button class="btn btn-link" data-dismiss="modal">Tutup</button>
            <button id="button_submit" class="btn btn-success"><i id="icon_submit" class="fa fa-send" style="margin-right: 10px;"></i> Simpan</button>
          </div>
        </div>
      </div>
    </div> 
  <?= form_close(); ?>
</div>

<script>
  // setup for datatables
  var argDataTables = {
    url: "<?= base_url(); ?>/surat_pemesanan/get_datatables_json",
    columns: [                        
      {"data": "id"},
      {"data": "customer_name"},
      {"data": "jenis_surat"},
      {"data": "order_date"},
      {"data": "action"}
    ],
    custom_columns: [
      {"index": 0, "val": "index"},
    ] 
  };

  setupDatatable(argDataTables);

  $('#table tbody').on('click', '.btn-delete', function(e) {
    e.preventDefault()

    show_sweet_alert({
      text: 'Apakah anda ingin menghapus?',
      type: 'warning',
      timer: 36000,
      showConfirmButton: true,
      showCancelButton: true
    }).then((result) => {
      if (result.value) {
        $(this).parent().submit()
      } 
    })
  })

</script>
