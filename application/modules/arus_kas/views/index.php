
<!-- Content Header (Page header) -->
<?= page_header("Arus Kas"); ?>

<!-- Main Content -->
<section class="content">
  <div class="box">
    <div class="box-header with-border" style="display: flex;justify-content: space-between;">
      <div class="input-group" style="width: 300px;margin-right: 10px;">
        <div class="input-group-addon">
          <i class="fa fa-calendar"></i>
        </div>
        <input type="text" class="form-control" id="tanggal_kas">
      </div>
      <div>
        <h3 style="margin: 0px;">Total: <span id="total_kas">Rp. 1.000.000.000</span></h3>
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
            <th class="text-center">Keterangan</th>
            <th class="text-center">Jumlah</th>
          </tr>
        </thead>
          <tbody>
            <tr> 
              <td colspan="4" class="text-center">
                Tidak ada data
              </td>
            </tr>	       
          </tbody>
      </table>
    </div>
  </div>
</section>

<script>
  function getTotalKas(tanggal) {
    // get jumlah total
    $.get({ 
      url: baseUrl + '/arus_kas/total_arus_kas', 
      data: { tanggal }
    }).done(function(data) {
      $('#total_kas').text(data.trim())
    })
  }

  $('#tanggal_kas').daterangepicker({
    "startDate": startOfMonth,
    "endDate": endOfMonth
  });

  var tanggalKas = $('#tanggal_kas').val()

  $(function() {
    getTotalKas(tanggalKas)
  })

  // setup for datatables
  var argDataTables = {
    url: "<?= base_url(); ?>arus_kas/get_datatables_json",
    columns: [                        
      {"data": "tanggal"},
      {"data": "tanggal"},
      {"data": "keterangan"},
      {"data": "jumlah"}
    ],
    custom_columns: [
      {"index": 0, "val": "index"},
    ],
    date: tanggalKas,
    createdRow: function(row, data, index) {
      var keterangan = data.keterangan
      if (keterangan.includes('total penjualan')) {
        keterangan = keterangan.substr(0, 15)
        $(row).find('td').eq(2).html(keterangan)
      }

      if (data.status == 'pengeluaran') {
        $(row).addClass('text-red')
      }
    }
  };

  var table = setupDatatable(argDataTables);

  $('#tanggal_kas').on('change', function(e) {
    var tanggalKas = $(this).val()

    getTotalKas(tanggalKas)
    $('#periode').val(tanggalKas);
    argDataTables.date = tanggalKas;
    table.draw();
  })

</script>


