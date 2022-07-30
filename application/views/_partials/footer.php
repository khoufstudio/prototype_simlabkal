<script>
  // change tab to enter
  $('input, button, select').keydown(function(e) {
    if (e.keyCode == 13 || e.keyCode == 40) {
      var nextInput = $('input').index(this) + 1
      $('input:eq(' + nextInput + '), button:eq(' + nextInput + '), select:eq(' + nextInput + ')').focus()
    }
  })

  $('.disable-autocomplete').attr('autocomplete', 'off')

  $('.datepicker').datepicker({
    autoclose: true,
    format: "dd/mm/yyyy"
  })
</script>
<footer class="main-footer">
  <div class="pull-right hidden-xs">
    <b>Version</b> 1
  </div>
  <strong>Created By <a href="https://khoufstudio.com">KhoufStudio</a></strong> with AdminLTE Template.
</footer>
