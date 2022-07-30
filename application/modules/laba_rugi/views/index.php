<!-- Content Header (Page header) -->
<?= page_header("Laba Rugi"); ?>

<!-- Main Content -->
<section class="content">
  <div class="box">
    <div class="box-body">
      <?= form_open('laba_rugi/find'); ?>
        <div class="form-group">
          <label for="">Tanggal</label>
          <div class="input-group" style="width: 300px;margin-right: 10px;">
            <div class="input-group-addon">
              <i class="fa fa-calendar"></i>
            </div>
            <input type="text" class="form-control pull-right" name="periode" id="periode">
          </div>
        </div>
      <?= form_close(); ?>
      <table>
        <tr>
          <td>
            Total Penjualan
          </td>
          <td style="padding-left: 30px;">
            <strong id="total_penjualan">Rp. 200.000</strong>
          </td>
        </tr>
        <tr>
          <td>
            Harga Beli
          </td>
          <td style="padding-left: 30px;">
            <strong id="total_pembelian">Rp. 200.000</strong>
          </td>
        </tr>
        <tr>
          <td>
            Total Retur Penjualan
          </td>
          <td style="padding-left: 30px;">
            <strong id="total_retur_penjualan">Rp. 200.000</strong>
          </td>
        </tr>
        <tr>
          <td colspan="2">------------------------------------------------------------ -</td>
        </tr>
        <tr>
          <td>
          </td>
          <td style="padding-left: 30px;">
            <strong id="total_harga_penjualan">Rp. 200.000</strong>
          </td>
        </tr>
        <tr>
          <td>
            Total Biaya Operasional
          </td>
          <td style="padding-left: 30px;">
            <strong id="total_biaya_operasional">Rp. 200.000</strong>
          </td>
        </tr>
        <tr>
          <td colspan="2">------------------------------------------------------------ -</td>
        </tr>
        <tr>
          <td>
          </td>
          <td style="padding-left: 30px;">
            <strong id="total_sementara">Rp. 200.000</strong>
          </td>
        </tr>
        <tr>
        <tr>
          <td>
            Pemasukan
          </td>
          <td style="padding-left: 30px;">
            <strong id="total_pemasukan">Rp. 200.000</strong>
          </td>
        </tr>
        <tr>
          <td colspan="2">------------------------------------------------------------ +</td>
        </tr>
        <tr>
          <td>
            Laba Bersih
          </td>
          <td style="padding-left: 30px;">
            <strong id="total_laba_rugi">Rp. 200.000</strong>
          </td>
        </tr>
      </table>
    </div>
  </div>
</section>

<script>
  function updateLabaRugi(tanggal) {
    var url = baseUrl + 'laba_rugi/find'
    $.ajax({
      url,
      method: 'GET',
      data: { tanggal },
      success: function(data) {
        data = JSON.parse(data)

        $('#total_penjualan').text(data.total_penjualan)
        $('#total_pembelian').text(data.total_pembelian)
        $('#total_retur_penjualan').text(data.total_retur_penjualan)
        $('#total_harga_penjualan').text(data.total_harga_penjualan)
        $('#total_biaya_operasional').text(data.total_pengeluaran)
        $('#total_pemasukan').text(data.total_pemasukan)
        $('#total_sementara').text(data.total_sementara)
        $('#total_laba_rugi').text(data.total_laba_rugi)
      }
    })
  }

  $(function() {
    var tanggalPenjualan = $('#periode').val();
    updateLabaRugi(tanggalPenjualan)
  })

  $('#periode').daterangepicker({
    "startDate": startOfMonth,
    "endDate": endOfMonth
  });

  $('#periode').on('change', function(e) {
    updateLabaRugi($(this).val());
  })
  </script>

