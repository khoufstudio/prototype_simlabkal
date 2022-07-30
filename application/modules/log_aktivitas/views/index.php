<!-- Content Header (Page header) -->
<?= page_header("Log Aktivitas"); ?>

<!-- Main Content -->
<section class="content">
  <div class="box">
    <div class="box-body">
      <div class="clearfix"></div>
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
            <th class="text-center">Pengguna</th>
            <th class="text-center">Aktivitas</th>
            <th class="text-center">Keterangan</th>
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

<script>
  // parameter url, kolumn, overide
  var argDataTables = {
    url: "<?= base_url(); ?>/log_aktivitas/get_datatables_json",
    columns: [                        
      {"data": "user"},
      {"data": "tanggal_buat"},
      {"data": "user"},
      {"data": "activity"},
      {"data": "description"},
    ],
    custom_columns: [
      {"index": 0, "val": "index"}
    ]
  };

  setupDatatable(argDataTables);
</script>

