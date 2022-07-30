<!-- Content Header (Page header) -->
<?= page_header("Pemesanan"); ?>

<!-- Main content -->
<section class="content">
  <div class="box">
    <!-- /.box-header -->
    <div class="box-header">
      <h3 class="box-title">
        <i class="fa fa-shopping-cart"></i> 
        Tambah Pemesanan
      </h3>
    </div>

    <!-- form start -->
    <?= form_open($form_action,  array('id' => 'form', 'class' => '')); ?>
      <div class="box-body">
        <div class="row">
          <div class="col-sm-6">
              <?= input_text(['label' => 'Nomer Order', 'name' => 'order_number', 'disabled' => true, 'value' => date('Ym'). strtoupper(substr(md5(microtime()),rand(0,26),3))], false); ?>
          </div>
          <div class="col-sm-6">
            <?= input_text(['label' => 'Tanggal Masuk', 'name' => 'order_date', 'type' => 'date', 'value' => '', 'disabled' => false], false); ?>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-6">
            <?= input_text(['label' => 'Kepada', 'name' => 'owner', 'value' => '', 'disabled' => false], false); ?>
          </div>
          <div class="col-sm-6">
            <?= input_text(['label' => 'Kontak Person', 'name' => 'contact_person', 'value' => '', 'disabled' => false], false); ?>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-6">
            <?= input_text(['label' => 'Alamat', 'name' => 'address', 'value' => '', 'disabled' => false], false); ?>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-12">
            <button class="btn btn-primary" type="submit">Simpan</button>
          </div>
        </div>
      </div>
    </form>
  </div>
</section>
