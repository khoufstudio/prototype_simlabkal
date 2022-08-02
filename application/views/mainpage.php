<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php $this->load->view('_partials/head'); ?>

  <title>SimLabKal</title>
</head>
<body style="background-color: #0891B2;padding-top: 200px;display: flex;justify-content: center;align-items: center;">
  <div style="width: 600px;">
    <h1 class="text-bold" style="color: white;">Lacak Kalibrasi</h1>
    <div id="error_message" class="alert alert-danger" style="display: none;">
      Resi Tidak ditemukan
    </div>
    <div class="input-group">
      <input id="no_resi" type="text" class="form-control" placeholder="Masukan No Resi Kalibrasi" style="padding: 30px;">
      <span class="input-group-btn">
        <button id="button_lacak" type="button" class="btn btn-primary btn-flat text-bold" style="padding: 18px;font-size: 18px;">Cari</button>
      </span>
    </div>
  </div>

  <div class="modal fade" id="modal_tracking">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header bg-primary">
          <button class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Update Pembayaran</h4>  
        </div>
        <div class="modal-body">
          <p>No RESI: <span id="no_resi_result text-bold text-blue"></span></p>
          <div>
            <ul class="timeline">

              <!-- timeline item -->
              <li>
                  <!-- timeline icon -->
                  <i class="fa fa-check bg-blue"></i>
                  <div class="timeline-item">
                      <h3 class="timeline-header">Persetujuan Pemesanan</h3>
                  </div>
              </li>
              <li>
                  <!-- timeline icon -->
                  <i class="fa fa-check bg-blue"></i>
                  <div class="timeline-item">
                      <h3 class="timeline-header">Proses Dokumen</h3>
                  </div>
              </li>
              <li>
                  <!-- timeline icon -->
                  <i class="fa fa-check bg-blue"></i>
                  <div class="timeline-item">
                      <h3 class="timeline-header">Konfirmasi Bayar</h3>
                  </div>
              </li>
              <li>
                  <!-- timeline icon -->
                  <i class="fa fa-check bg-blue"></i>
                  <div class="timeline-item">
                      <h3 class="timeline-header">Sertifikat Selesai</h3>
                  </div>
              </li>
              <!-- END timeline item -->
            </ul>

          </div>
          <div class="clearfix" style="margin-bottom: 0;">
            <a id="download_sertifikat" href="#" class="btn btn-danger pull-right" style="display: none;">Download Sertifikat</a>
          </div>
        </div>
      </div>
    </div> 
  </div>
</body>
<script>
  var baseUrl = '<?= base_url(); ?>'

  $('#button_lacak').click(function() {
    var noResi = $('#no_resi').val()
    var url = baseUrl + 'mainpage/tracking/' + noResi

    $('#no_resi_result').text(noResi)

    $.ajax({
      url,
      beforeSend: function() {
        $('#error_message').hide()
        $('#download_sertifikat').hide()
      },
      success: function({ tracking_number }) {
        if (tracking_number !== null) {
          $('#modal_tracking').modal('show');

          if (tracking_number == 4) {
            $('#download_sertifikat').show()
          }
        } else {
          // resi tidak ditemukan
          $('#error_message').show()
        }
      }
    })
  })

  $('#download_sertifikat').click(function(e) {
    e.preventDefault()
    alert('Mohon maaf, masih dalam tahap pengembangan')
  })
</script>
</html>
