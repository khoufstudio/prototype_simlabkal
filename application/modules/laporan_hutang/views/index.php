<!-- Content Header (Page header) -->
<?= page_header("Laporan Hutang"); ?>

<!-- Main Content -->
<section class="content">
  <div class="box">
    <div class="box-header with-border">
      <div class="row">
        <form action="#">
          <div class="col-sm-4">
            <div class="form-group">
              <label>Periode</label>
              <div class="input-group" style="width: 300px;margin-right: 10px;">
                <div class="input-group-addon">
                  <i class="fa fa-calendar"></i>
                </div>
                <input type="text" class="form-control pull-right" id="periode_laporan">
              </div>
            </div>
          </div>
          <div class="col-sm-4">
            <?= input_select(['label' => 'Supplier', 'name' => 'supplier', 'list' => $supplier, 'selected_value' => $purchases['supplier_id'] ?? '', 'disabled' => (isset($purchases)) ? true : false], false); ?>
          </div>
          <div class="col-sm-2">
            <button id="laporan_hutang_filter" type="button" class="btn btn-success" style="margin-bottom: 0;margin-top: 24px;">
              <i class="fa fa-search"></i> Filter
            </button>
          </div>
        </form>
      </div>
      <div class="row">
          <div class="col-sm-12">
            <a id="laporan_hutang_print" href="<?= base_url("laporan_hutang/print_laporan_hutang"); ?>" class="btn btn-info" style="margin-bottom: 0;float: right;">
              <i class="fa fa-print"></i> Print
            </a>
          </div>
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

<script>
  $(function() {
    var periodeLaporan = $('#periode_laporan').val()
    var printUrl = baseUrl + 'laporan_hutang/print_laporan_hutang'

    printUrl += `?periode='${periodeLaporan}'`

    $('#laporan_hutang_print').attr('href', printUrl)
  })

  $('#periode_laporan').daterangepicker({
    "startDate": startOfMonth,
    "endDate": endOfMonth
  });
  var tanggalPembelian = $('#periode_laporan').val();

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
    url: "<?= base_url(); ?>/laporan_hutang/get_datatables_json",
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
  };

  var table = setupDatatable(argDataTables);

	$(document).on('click', '.debt', function() {
		var parts = $(this).attr('id')
		var purchaseId = parts.split('-')[1]
		var rest = $('#' + parts).parent().prev().html()
		
		$('input[name=purchase_id]').val(purchaseId)
		$('#rest').val(rest)
		$('#rest_value').val(rest)
		$('#modal_hutang').modal()
	})
  
  $('#laporan_hutang_filter').click(function(e) {
    var supplier = $('#supplier').val()
    var periodeLaporan = $('#periode_laporan').val()
    
    var printUrl = baseUrl + 'laporan_hutang/print_laporan_hutang'
    printUrl += `?supplier=${supplier}&periode='${periodeLaporan}'`

    $('#laporan_hutang_print').attr('href', printUrl)

    argDataTables.search = { supplier }
    argDataTables.date = periodeLaporan
    table.draw()
  })
</script>

