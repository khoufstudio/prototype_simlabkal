<?php $username = $this->session->user->username; ?>
<!-- Content Header -->
<div class="content-header">
  <h1><?= ucfirst($aksi); ?> Pengguna</h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i>Home</a></li>
    <li><a href="#">Setting</a></li>
    <li class="active"><a href="#">Edit Pengguna</a></li>
  </ol>
</div>

<!-- Main Content -->
<div class="content">

  <div class="box">
    <div class="box-header with-border">
      <h3 class="box-title"><?= ucfirst($aksi); ?> Pengguna</h3>
    </div>
    <form action="<?= ($aksi == 'tambah') ? base_url('users/store') : base_url('users/update/' . $user['id']);  ?>" id="form_user" class="form-horizontal" method="POST" autocomplete="off" enctype="multipart/form-data">
    <div class="box-body">
      <div class="row">
        <div class="col-sm-2 text-center">
          <?php 
            $profilePicture = $user['profile_picture'] ?? null;
            if ($profilePicture && $aksi == 'edit') {
              $urlPicture = base_url() . "uploads/images/" . $profilePicture;
            } else {
              $urlPicture = base_url() . "assets/dist/img/avatar.png";

            }
           ?>
          <img src="<?= $urlPicture; ?>" style="width: 150px;" class="img-circle" alt="User Image">
          <button type="button" class="btn btn-sm btn-success" style="margin-top: 16px;position: relative;">
            <i class="fa fa-upload" style="margin-right: 10px;"></i> Upload Foto
            <input type="file" name="profile_picture" class="profile_picture" style="position: absolute;right: 0;top: 0;opacity: 0;cursor: pointer;">
          </button>

          <p style="margin-top: 16px;visibility: hidden;" class="file-upload-name"><span></span> <i class="fa fa-fw fa-minus-circle" style="margin-left: 10px;color: red;cursor: pointer;"></i></p>
        </div>
        <div class="col-sm-10">
          <!-- menyembunyikan input -->
          <input class="hide-autofill" type="text" name="username">
          <input class="hide-autofill" type="password" name="password">
          <div class="form-group">
            <label for="nama" class="control-label col-sm-2">Nama</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" name="nama" id="modal_nama" required="" value="<?= $user['nama'] ?? ''; ?>">
            </div>
          </div>

          <div class="form-group">
            <label for="zz" class="control-label col-sm-2">Username</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" name="usernamex" required="" autocomplete="false" autofill="off" value="<?= $user['username'] ?? ''; ?>">
            </div>
          </div>

          <div class="form-group">
            <label for="passwordx" class="control-label col-sm-2">Password</label>
            <div class="col-sm-10">
              <input type="password" class="form-control" name="passwordx" minlength="5" <?= ($aksi == 'tambah') ? 'required=""' : ''; ?>>
              <?php if ($aksi == 'edit') { ?>
                <span class="help-block" style="font-weight: bold;">Isi jika ingin merubah password!</span>
              <?php } ?>
            </div>
          </div>
          <div class="form-group">
            <label for="password_confirm" class="control-label col-sm-2">Tulis Ulang Password</label>
            <div class="col-sm-10">
              <input type="password" class="form-control" name="password_confirm" id="modal_password_confirm" <?= ($aksi == 'tambah') ? 'required=""' : ''; ?>>
            </div>
          </div>

          <div class="form-group">
            <label for="role" class="control-label col-sm-2">Role</label>
            <div class="col-sm-10">
              <select name="role" id="role" class="form-control select2" required=""  <?= ($aksi == 'edit' && $username != 'admin') ? 'disabled=""' : ''; ?>>
                <option value="">Tidak ada</option>
                <?php for ($x = 0;$x < count($role); $x++) { ?>
                  <option value="<?= $role[$x]["id"]; ?>" <?= ($aksi == 'edit' && $user['role'] == $role[$x]["id"]) ? 'selected' : ''; ?>><?= $role[$x]["name"]; ?></option>
                <?php } ?>
              </select>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="box-footer">
      <div class="row">
        <div class="col-sm-12 text-right">
            <button class="btn btn-link">Batal</button>
            <button type="submit" id="btn_submit" class="btn btn-primary"  <?= ($aksi == 'tambah') ? 'disabled=""' : "";  ?>>
              <i class="fa fa-send"  style="margin-right: 10px;"></i> Simpan
            </button>
        </div>
      </div>
    </div>
    </form> 
  </div>
</div>

<script>  
  $('input[name=password_confirm]').keyup(function() {
    var passwordVal = $('input[name=passwordx]').val();
    if (this.value == passwordVal) {

      $('#btn_submit').prop('disabled', false)
    }

  })

  $('input[type=file]').change(function(e) {
    var fileName = e.target.files[0].name;
    $('.file-upload-name').css("visibility", "visible");

    $('.file-upload-name span').text(fileName)
  })

  $('.file-upload-name').on('click', function() {
    $('.profile_picture').val('')
    $('.file-upload-name').css("visibility", "hidden");
  })
</script>
