<!-- Content Header (Page header) -->
<?= page_header("Piutang"); ?>

<!-- Main Content -->
<section class="content">
  <div class="box">
    <div class="box-header with-border">
      <div class="input-group" style="width: 300px;margin-right: 10px;">
        <div class="input-group-addon">
          <i class="fa fa-calendar"></i>
        </div>
        <input type="text" class="form-control pull-right" id="tanggal_pembelian">
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
      <table id="table" class="table table-bordered table-striped">
        <thead>
          <tr>
            <th class="text-center" width="5%">No</th>
            <th class="text-center">Tanggal</th>
            <th class="text-center">Pelanggan</th>
            <th class="text-center">Jumlah Piutang</th>
            <th class="text-center">Sisa</th>
            <th class="text-center"><i class="fa fa-cog"></i></th>
          </tr>
        </thead>
          <tbody>
            <tr> 
              <td colspan="7" class="text-center">
                Tidak ada data
              </td>
            </tr>	       
          </tbody>
      </table>
    </div>
  </div>
</section>

<div class="modal fade" id="modal_piutang">
  <?= form_open('piutang/store', 'id="form_piutang"'); ?>
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header bg-green">
          <button class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Bayar Hutang</h4>  
        </div>
        <div class="modal-body">
          <input type="hidden" name="selling_id">
          <?= input_text(array('name' => 'rest_value', 'label' => 'Sisa', 'disabled' => true));?>
          <?= input_hidden('rest');?>
          <?= input_text(array('name' => 'installment', 'label' => 'Cicilan'));?>
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
  $('#tanggal_pembelian').daterangepicker({
    "startDate": startOfMonth,
    "endDate": endOfMonth
  });
  var tanggalPembelian = $('#tanggal_pembelian').val();

  // setup for datatables
  var argDataTables = {
    url: "<?= base_url(); ?>/piutang/get_datatables_json",
    columns: [                        
      {"data": "selling_code"},
      {"data": "tanggal_buat"},
      {"data": "customer"},
      {"data": "total"},
      {"data": "rest"},
      {"data": "edit_credit"}
    ],
    custom_columns: [
      {"index": 0, "val": "index"},
    ],
    date: tanggalPembelian
  };

  var table = setupDatatable(argDataTables);

  $('#tanggal_pembelian').on('change', function(e) {
    $('#periode').val($(this).val());
    argDataTables.date = $(this).val();
    table.draw();
  })

  $(document).on('click', '.credit', function() {
	  var parts = $(this).attr('id')
	  var sellingId = parts.split('-')[1]
	  var rest = $('#' + parts).parent().prev().html()
	  
	  $('input[name=selling_id]').val(sellingId)
	  $('#rest').val(rest)
	  $('#rest_value').val(rest)
	  $('#modal_piutang').modal()
  })
</script>

