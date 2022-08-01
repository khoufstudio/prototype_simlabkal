<!-- Content Header (Page header) -->
<?= page_header("Pemesanan"); ?>

<!-- Main content -->
<section class="content">
  <div class="box">
    <!-- /.box-header -->
    <div class="box-header">
      <h3 class="box-title">
        <i class="fa fa-shopping-cart"></i> 
        <?= "$action Pemesanan"; ?>
      </h3>
    </div>

    <!-- form start -->
    <?= form_open($form_action,  array('id' => 'form', 'class' => '')); ?>
      <input type="hidden" name="aksi" id="aksi" value="<?= $action; ?>">
      <div class="box-body">
        <div class="row">
          <div class="col-sm-6">
              <?= input_text(['label' => 'Nomer Order', 'name' => 'order_number', 'other_attributes' => 'readonly', 'value' => $id], false); ?>
          </div>
          <div class="col-sm-6">
            <?= input_text(['label' => 'Tanggal Masuk', 'name' => 'order_date', 'type' => 'date', 'value' => $data['order_date'] ?? ''], false); ?>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-6">
            <?= input_text(['label' => 'Kepada', 'name' => 'owner', 'value' => $data['owner'] ?? ''], false); ?>
          </div>
          <div class="col-sm-6">
            <?= input_text(['label' => 'Kontak Person', 'name' => 'contact_person', 'value' => $data['contact_person'] ?? ''], false); ?>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-6">
            <?= input_text(['label' => 'Alamat', 'name' => 'address', 'value' => $data['address'] ?? ''], false); ?>
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
                <?php foreach (array('0' => 'Tidak Ditentukan', '5' => '5 hari', '7' => '7 hari') as $key => $value) : ?>
                  <div class="radio">
                    <label>
                      <input type="radio" name="spm" value="<?= $key; ?>" <?= isset($data['spm']) && $data['spm'] == $key ? 'checked' : ''; ?>>
                      <?= $value; ?>
                    </label>
                  </div>
                <?php endforeach; ?>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-12">
            <button id="button_submit" class="btn btn-primary" type="submit">Simpan</button>
          </div>
        </div>
      </div>
    </form>
  </div>
</section>

<script>
  $('#button_submit').click(function(e) {
    e.preventDefault()

    if ($('#aksi').val() == 'Edit') {
      var form = $('#form')
      var data = new FormData(form[0])
      var url = form.attr('action')
      
      $.ajax({
        method: 'POST',
        data,
        processData: false,
        contentType: false,
        url,
        beforeSend: function() {
          $('#button_submit').attr('disabled', true)
        },
        success: function(data) {
          if (data.success) {
            show_sweet_alert({
              text: 'Alhamdulillah data ' + data.message,
              type: 'success',
              timer: 3600
            }).then((result) => {
              window.location = baseUrl + 'orders'
            })
          } else {
            var message = data.message
          }
        },
        complete: function() {
          $('#button_submit').attr('disabled', false)
        }
      })
    } else {
      $('#form').submit()
    }
  })
</script>