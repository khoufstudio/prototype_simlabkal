<!-- Content Header (Page header) -->
<?= page_header("Kalibrasi"); ?>

<!-- Main Content -->
<section class="content">
  <div class="box">
    <div class="box-header with-border" style="display: flex;justify-content: space-between;">
      <div class="input-group" style="width: 300px;margin-right: 10px;">
        <div class="input-group-addon">
          <i class="fa fa-calendar"></i>
        </div>
        <input type="text" class="form-control pull-right" id="tanggal_calibrations">
      </div>
    </div>
    <div class="box-body">
      <?= alert_message($form_message, $this->session); ?>
      <table id="table" class="table table-border table-striped" style="width: 100%;">
        <thead>
          <tr>
            <th class="text-center" width="5%">No</th>
            <th class="text-center">No kalibrasi</th>
            <th class="text-center">Tanggal Masuk</th>
            <th class="text-center">SPM</th>
            <th class="text-center">Status</th>
            <th class="text-center"><i class="fa fa-cog"></i></th>
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

<!-- modal -->
<div class="modal fade" id="modal_modal_calibration">
  <?= form_open('calibrations/store', 'id="form_modal_calibration"'); ?>
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header bg-green">
          <button class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Update Pemesanan</h4>  
        </div>
        <div class="modal-body">
          <p>
            Data Pemesanan sudah disetujui oleh customer?
          </p>
          <div class="checkbox">
            <label>
              <input type="checkbox" id="setuju" name="setuju" value="1">
              Ya
            </label>
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
<!-- end modal -->

<script>
  $('#tanggal_calibrations').daterangepicker({
    "startDate": startOfMonth,
    "endDate": endOfMonth
  });

  var tanggalcalibrations = $('#tanggal_calibrations').val();
  $('#periode').val(tanggalcalibrations);

  // setup for datatables
  var argDataTables = {
    url: "<?= base_url(); ?>/calibrations/get_datatables_json",
    columns: [                        
      {"data": "order_number"},
      {"data": "order_number"},
      {"data": "order_date"},
      {"data": "spm"},
      {"data": "tracking_number"},
      {"data": "action"}
    ],
    custom_columns: [
      {"index": 0, "val": "index"},
    ],
    date: tanggalcalibrations
  };

  var table = setupDatatable(argDataTables);

  $('#tanggal_calibrations').on('change', function(e) {
    $('#periode').val($(this).val());
    argDataTables.date = $(this).val();
    table.draw();
  })
</script>
