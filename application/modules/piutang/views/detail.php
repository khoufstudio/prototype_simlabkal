<!-- Content Header (Page header) -->
<?= page_header("Piutang"); ?>

<!-- Main Content -->
<section class="content">
  <div class="box">
    <div class="box-body">
      <?php if (isset($payment_credits)) { ?>
        <?php if (count($payment_credits) > 0) { ?>
          <h3 class="text-center">
            Rincian Hutang <?= $selling['selling_code']; ?>
          </h3>
          <table class="table">
            <thead>
              <tr>
                <th>No</th>
                <th>Jumlah Cicilan</th>
                <th>Sisa</th>
                <th>Tanggal Cicilan</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($payment_credits as $index => $pd): ?>
                <tr>
                  <td><?= $index + 1; ?></td>
                  <td><?= intToRupiah((int) $pd['installment']); ?></td>
                  <td><?= intToRupiah((int) $pd['rest']); ?></td>
                  <td><?= ymdHisTodmyHis($pd['created_at']); ?></td>
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
