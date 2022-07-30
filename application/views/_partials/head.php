<!-- CSS File -->

<!-- Bootstrap 3.3.7 -->
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/bower_components/bootstrap/dist/css/bootstrap.min.css">
<!-- Font Awesome -->
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/bower_components/font-awesome/css/font-awesome.min.css">
<!-- Ionicons -->
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/bower_components/Ionicons/css/ionicons.min.css">
<!-- DataTables -->
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<!-- Select2 -->
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/bower_components/select2/dist/css/select2.min.css">

<!-- Daterangepicker -->
<link rel="stylesheet" type="text/css"  href="<?php echo base_url(); ?>assets/bower_components/bootstrap-daterangepicker/daterangepicker.css">

<!-- Bootstrap Datepicker -->
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">

<!-- Theme style -->
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/dist/css/AdminLTE.min.css">
<!-- AdminLTE Skins. Choose a skin from the css/skins
      folder instead of downloading all of them to reduce the load. -->
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/dist/css/skins/_all-skins.min.css">
<!-- Custom CSS -->
<link rel="stylesheet" href="<?php echo base_url('assets/dist/css/style.css?v=' . strtotime("now")); ?>">

<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->

<!-- include summernote css -->
<link href="<?= base_url('assets/plugins/summernote-0.8.18/summernote.min.css'); ?>" rel="stylesheet">

<!-- Google Font -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

<!-- JS File -->

<!-- jQuery 3 -->
<script src="<?php echo base_url(); ?>assets/bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="<?php echo base_url(); ?>assets/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- DataTables -->
<script src="<?php echo base_url(); ?>assets/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>assets/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<!-- SlimScroll -->
<script src="<?php echo base_url(); ?>assets/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="<?php echo base_url(); ?>assets/bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url(); ?>assets/dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?php echo base_url(); ?>assets/dist/js/demo.js"></script>
<!-- Moment js -->
<script src="<?php echo base_url(); ?>assets/bower_components/moment/min/moment.min.js"></script>
<script src="<?php echo base_url(); ?>assets/bower_components/moment/min/moment-with-locales.min.js"></script>

<!-- AdminLTE for daterangepicker -->
<script src="<?php echo base_url(); ?>assets/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>

<!-- AdminLTE for datepicker -->
<script src="<?php echo base_url(); ?>assets/bower_components/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>

<!-- Select2 -->
<script src="<?php echo base_url(); ?>assets/bower_components/select2/dist/js/select2.full.min.js"></script>
<!-- CKEDITOR -->
<script src="<?php echo base_url(); ?>assets/bower_components/ckeditor/ckeditor.js"></script>
<!-- Sweet Alert -->
<script src="<?php echo base_url(); ?>assets/dist/js/sweetalert2.all.min.js"></script>
<!-- TypeheadJS -->
<script src="<?php echo base_url(); ?>assets/dist/js/bootstrap3-typeahead.min.js"></script>

<!-- include summernote js -->
<script src="<?= base_url('assets/plugins/summernote-0.8.18/summernote.min.js'); ?>"></script>

<!-- Utils JS -->
<script src="<?php echo base_url(); ?>assets/dist/js/utils.js?v=<?= strtotime(date('Y-m-d H:i')); ?> "></script>

<script>
  moment.locale('id')
  const now = moment().format('DD/MM/YYYY HH:mm')
  const startOfMonth = moment().startOf('month').format('DD/MM/YYYY');
  const endOfMonth = moment().endOf('month').format('DD/MM/YYYY');

  $(document).ready(function () {
    $('.sidebar-menu').tree()
    $('.select2').select2()

    setTimeout(function(){
      $(".alert").not('.alert.no-fade').fadeOut();
    }, 3000);
  })

  $('.datepicker').datepicker({
    autoclose: true,
    format: "dd/mm/yy"
  })

  var baseUrl = '<?= base_url(); ?>'
</script>
