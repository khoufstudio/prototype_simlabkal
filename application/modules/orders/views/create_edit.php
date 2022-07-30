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
              <?= input_text(['label' => 'Nomer Order', 'name' => 'order_number', 'other_attributes' => 'readonly', 'value' => date('Ym'). strtoupper(substr(md5(microtime()),rand(0,26),3))], false); ?>
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
          <div class="col-sm-6">
            <div class="form-group">
              <label for="spm">SPM</label>
              <div
                style="
                  display: flex;
                  align-items: end;
                  gap: 10px;
              ">
                <div class="radio">
                  <label for="">
                    <input type="radio" name="spm" value="0">
                    Tidak Ditentukan
                  </label>
                </div>
                <div class="radio">
                  <label for="">
                    <input type="radio" name="spm" value="5">
                    5 hari
                  </label>
                </div>
                <div class="radio">
                  <label for="">
                    <input type="radio" name="spm" value="7">
                    7 hari
                  </label>
                </div>
              </div>
            </div>
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
