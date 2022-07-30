<!-- Content Header (Page header) -->
<?= page_header("Laporan Hutang"); ?>

<style>
  @media print {
    .box-footer
    , .main-footer  
    , #button_print
    { display: none; }
  }
</style>
<!-- Main Content -->
<section class="content">
  <div class="box">
    <div class="box-body">
      <?php if (isset($payment_debts)) { ?>
        <?php if (count($payment_debts) > 0) { ?>
          <h2 class="text-center">
             <?= $supplier['name']; ?>
          </h2>
          <h3 class="text-center">
            Rincian Hutang <?= $purchase['invoice_number']; ?>
          </h3>
          <br>
          <button id="button_print" class="btn btn-info pull-right" onclick="window.print()">
            <i class="fa fa-print"></i> Print
          </button>
          <table class="table">
            <thead>
              <tr>
                <th>No</th>
                <th>Jumlah Cicilan</th>
                <th>Sisa</th>
                <th>Tanggal Cicilan</th>
                <th>Keterangan</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($payment_debts as $index => $pd): ?>
                <tr>
                  <td><?= $index + 1; ?></td>
                  <td><?= intToRupiah((int) $pd['installment']); ?></td>
                  <td><?= intToRupiah((int) $pd['rest']); ?></td>
                  <td><?= ymdHisTodmyHis($pd['created_at']); ?></td>
                  <td><?= $pd['description'] ?? '-'; ?></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        <?php } else { ?>
          <p class="text-center">Tidak ada data</p>
        <?php } 
        } ?>
    </div>
    <div class="box-footer">
      <div class="pull-right">
        <a href="<?php echo site_url($base); ?>" class="btn btn-danger" style="margin-right:  10px;"><i class="fa fa-angle-left"></i>
           Kembali
        </a>
      </div>
    </div> 
  </div>
</section>
