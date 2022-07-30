<!-- Content Header (Page header) -->
<?= page_header("Hutang"); ?>

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
      <table id="table" class="table table-bordered table-striped" style="width: 100%;">
        <thead>
          <tr>
            <th class="text-center" width="5%">No</th>
            <th class="text-center">Tanggal</th>
            <th class="text-center">Supplier</th>
            <th class="text-center">No Faktur</th>
            <th class="text-center">Jumlah Hutang</th>
            <th class="text-center">Sisa</th>
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

<div class="modal fade" id="modal_hutang">
  <?= form_open('hutang/store', 'id="form_hutang"'); ?>
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header bg-green">
          <button class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Bayar Hutang</h4>  
        </div>
        <div class="modal-body">
          <input type="hidden" name="purchase_id">
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

  $('.datepicker').datepicker({
    autoclose: true,
    format: "dd/mm/yy"
  })

  $('#modal_hutang').on('show.bs.modal', function(e) {
    $('#tanggal').val(now);

    $('#alert_success').addClass('d-none');
    $('#button_print').addClass('d-none');
    $('.container-input').removeClass('d-none');
    $('#button_submit').removeClass('d-none');

    $('#total_bayar_val').val(0)
    $('#total_bayar strong').text(formatRupiah("0", "Rp. "));
  });

  // setup for datatables
  var argDataTables = {
    url: "<?= base_url(); ?>/hutang/get_datatables_json",
    columns: [                        
      {"data": "purchase_code"},
      {"data": "tanggal_buat"},
      {"data": "supplier"},
      {"data": "invoice_number"},
      {"data": "total"},
      {"data": "rest"},
      {"data": "edit_debt"}
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

	$(document).on('click', '.debt', function() {
		var parts = $(this).attr('id')
		var purchaseId = parts.split('-')[1]
		var rest = $('#' + parts).parent().prev().html()
		
		$('input[name=purchase_id]').val(purchaseId)
		$('#rest').val(rest)
		$('#rest_value').val(rest)
		$('#modal_hutang').modal()
	})
  
</script>

