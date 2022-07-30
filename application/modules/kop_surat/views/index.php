<!-- Content Header (Page header) -->
<?= page_header("Kop Surat"); ?>

<!-- Main Content -->
<section class="content">
  <div class="box">
    <form action="<?= base_url("kop_surat/update/$id_kop"); ?>" method="POST">
      <div class="box-body">
        <?php if (isset($form_message)) { ?>
          <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h4><i class="icon fa fa-check"></i> Berhasil!</h4>
            <?php echo $form_message; ?>
          </div>
        <?php } ?>
        <textarea id="summernote" name="content">
          <?= $content; ?>
        </textarea>
      </div>
      <div class="box-footer">
        <button type="submit" class="btn btn-success pull-right">Simpan</button>
      </div>
    </form>
  </div>
</section>

<script>
  $(function() {
    $('#summernote').summernote({
      height: '200px'
    })
  })
</script>
