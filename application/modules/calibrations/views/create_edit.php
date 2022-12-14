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
      <!-- container input kalibrasi -->
      <div id="input_kalibrasi_container"></div>
      <input type="hidden" name="order_id" id="order_id" value="<?= $data['id'];?>">

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
          <div class="col-sm-12">
            <button id="button_tambah_kalibrasi" class="btn btn-success pull-right margin-bottom">Tambah</button>
            <table id="table_kalibrasi" class="table table-bordered">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Subjek</th>
                  <th>Merk</th>
                  <th>Petugas Kalibrasi</th>
                  <th>Tgl Selesai Kalibrasi</th>
                  <th>Keterangan</th>
                  <th>Typist</th>
                  <th><i class="fa fa-cog"></i></th>
                </tr>
              </thead>
              <tbody>
                <?php if (count($calibrations) > 0) : ?>
                  <?php
                  for ($i=0; $i < count($calibrations); $i++) { 
                    $number = $i + 1;
                    $subject = $calibrations[$i]['subject'];
                    $merk = $calibrations[$i]['brand'];
                    $petugas_kalibrasi = $calibrations[$i]['calibration_officer'];
                    $tanggal_selesai_kalibrasi = $calibrations[$i]['calibration_completion_date'];
                    $keterangan = $calibrations[$i]['description'];
                    $typist = $calibrations[$i]['typist'];

                    echo <<<HTML
                    <tr>
                      <td>$number</td>
                      <td>
                        <input type="text" class="form-control" name="subjek[]" value="$subject">
                      </td>
                      <td>
                        <input type="text" class="form-control" name="merk[]" value="$merk">
                      </td>
                      <td>
                        <input type="text" class="form-control" name="petugas_kalibrasi[]" value="$petugas_kalibrasi">
                      </td>
                      <td>
                        <input type="date" class="form-control" name="tanggal_selesai_kalibrasi[]" value="$tanggal_selesai_kalibrasi">
                      </td>
                      <td>
                        <input type="text" class="form-control" name="keterangan[]" value="$keterangan">
                      </td>
                      <td>
                        <input type="text" class="form-control" name="typist[]" value="$typist">
                      </td>
                      <td>
                        <button type="button" class="btn hapus-row btn-sm btn-danger" style="display: inline-block;">
                          <i class="fa fa-fw fa-trash-o"></i>
                        </button> 
                      </td>
                    </tr>
                    HTML;
                  }

                  ?>
                <?php else: ?>
                  <tr id="empty_data">
                    <td colspan="8" class="text-center">Belum ada data</td>
                  </tr>
                <?php endif; ?>
              </tbody>
            </table>
            </div>
        </div>
        <div class="row">
          <div class="col-sm-12 container-form-button">
            <a href="<?= base_url(). 'calibrations'; ?>" class="btn btn-default">Kembali</a>
            <button class="btn btn-success" name="submit" type="submit" value="save_as_draft">Simpan Sebagai Draft</button>
            <button class="btn btn-primary" type="submit">Simpan</button>
          </div>
        </div>
      </div>
    </form>
  </div>
</section>
<script>
  $('#button_tambah_kalibrasi').click(function(e) {
    e.preventDefault()
    $('#empty_data').remove()

    var calibrationNumber = $('#table_kalibrasi tr:last-child > td:nth-child(1)').text();
    calibrationNumber++; 

    $('#table_kalibrasi tbody').append(`
      <tr>
        <td>${calibrationNumber}</td>
        <td>
          <input type="text" class="form-control" name="subjek[]">
        </td>
        <td>
          <input type="text" class="form-control" name="merk[]">
        </td>
        <td>
          <input type="text" class="form-control" name="petugas_kalibrasi[]">
        </td>
        <td>
          <input type="date" class="form-control" name="tanggal_selesai_kalibrasi[]">
        </td>
        <td>
          <input type="text" class="form-control" name="keterangan[]">
        </td>
        <td>
          <input type="text" class="form-control" name="typist[]">
        </td>
        <td>
          <button type="button" class="btn hapus-row btn-sm btn-danger" style="display: inline-block;">
            <i class="fa fa-fw fa-trash-o"></i>
          </button> 
        </td>
      </tr>
    `)
  })


  $('#table_kalibrasi').on('click', '.hapus-row', function() {
    var indexValue = $(this).parent().parent().find('td')[0].innerHTML

    $(this).parent().parent().remove();
    var lastRow = $('#table_kalibrasi tr:last-child > td:nth-child(1)').text();
    for (let i = 0; i < lastRow; i++) {
      $(`#table_kalibrasi tr:nth-child(${i}) > td:nth-child(1)`).text(i);
    }
  });
</script>
