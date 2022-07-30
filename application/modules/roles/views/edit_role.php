<!-- Content Header (Page header) -->
<?= page_header("Edit Role"); ?>

<!-- Main Content -->
<section class="content">
  <div class="box">
    <div class="box-header with-border">
      <h3 class="box-title">
        <i class="fa fa-lock"></i> 
        Edit Role
      </h3>
    </div>
    <div class="box-body">
      <table class="table table-bordered table-striped">
        <thead>
          <tr>
            <th class="text-center" width="5%">No</th>
            <th class="text-center">Role</th>
            <th class="text-center" width="20%"><i class="fa fa-cog"></i></th>
          </tr>
        </thead>
          <tbody>
            <?php foreach($list_menus as $index => $menu): ?>
                <tr>
                    <td><?= $index + 1; ?></td>
                    <td><?= $menu['name']; ?></td>
                    <td class="text-center">
                    <input class="checkbox-menu" type="checkbox" name="checkbox-menu" value="<?= $menu['id']; ?>" <?= (in_array($menu['id'], $menus_id)) ? 'checked' : ''; ?>>
                    </td>
                </tr>
            <?php endforeach; ?>
          </tbody>
        </table>

        <form method="POST" action="<?= base_url('roles/update_role/' . $role_id); ?>" style="margin-top: 20px;display: flex;justify-content: flex-end;">
            <input id="menus_id" type="hidden" name="menus_id" value="<?= implode(", ", $menus_id); ?>">

            <button style="margin-right: 10px;" class="btn btn-danger">Batal</button>
            <button class="btn btn-primary" type="submit">Simpan</button>
        </form>
    </div>
  </div>
</section>
<script>
  $('body').on('change', '.checkbox-menu', function() {
    let selectedValue = $(this).val()
    let menusId = $('#menus_id').val()

    if (menusId == '') {
      $('#menus_id').val(selectedValue)
    } else {
      let menuTemp = menusId.split(", ") 
      let menuFound = menuTemp.indexOf(selectedValue)

      if (menuFound != -1) {
        menuTemp.splice(menuFound, 1)
      } else {
        menuTemp.push(selectedValue)
      }

      $('#menus_id').val(menuTemp.join(", "))
    }
  })
</script>
