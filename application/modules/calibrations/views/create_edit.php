<!-- Content Header (Page header) -->
<?= page_header("Kalibrasi"); ?>

<!-- Main content -->
<section class="content">
  <div class="box">
    <!-- /.box-header -->
    <div class="box-header">
      <h3 class="box-title">
        <i class="fa fa-shopping-cart"></i> 
        Tambah Kalibrasi
      </h3>
    </div>

    <!-- form start -->
    <?= form_open($form_action,  array('id' => 'form', 'class' => '')); ?>
      <div class="box-body">
        <div class="row">
          <div class="col-sm-6">
              <?= input_text(['label' => 'Nomer Order', 'name' => 'order_number', 'other_attributes' => 'readonly', 'value' => $data['order_number']], false); ?>
          </div>
          <div class="col-sm-6">
            <?= input_text(['label' => 'Tanggal Masuk', 'name' => 'order_date', 'other_attributes' => 'readonly', 'value' => ymdToDmy($data['order_date'])], false); ?>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-6">
            <?= input_text(['label' => 'Kepada', 'name' => 'owner', 'value' => $data['owner'], 'other_attributes' => 'readonly'], false); ?>
          </div>
          <div class="col-sm-6">
            <?= input_text(['label' => 'Kontak Person', 'name' => 'contact_person', 'value' => $data['contact_person'], 'disabled' => true], false); ?>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-6">
            <?= input_text(['label' => 'Alamat', 'name' => 'address', 'value' => $data['address'], 'disabled' => true], false); ?>
          </div>
          <div class="col-sm-6">
            <div class="form-group">
              <?= input_text(['label' => 'SPM', 'name' => 'spm', 'value' => spm($data['spm']), 'disabled' => true], false); ?>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-12 container-form-button">
            <a href="<?= base_url(). 'calibrations'; ?>" class="btn btn-default">Kembali</a>
            <button class="btn btn-primary" type="submit">Simpan</button>
          </div>
        </div>
      </div>
    </form>
  </div>
</section>