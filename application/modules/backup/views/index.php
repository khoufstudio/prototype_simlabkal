<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>Backup Database</h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i>Home</a></li>
      <li class="active"><a href="#">Backup Database</a></li>
  </ol>
</section>

<!-- Main Content -->
<section class="content">
  <div class="box">
    <div class="box-header with-border">
      <div class="pull-right">
				<form action="<?= base_url('backup/download'); ?>">
					<button class="btn btn-success">
						<i class="fa fa-download" style="margin-right: 10px"></i>
						Backup
					</button>
				</form>
      </div>
    </div>
    <div class="box-body">
			<p>
				Silahkan klik tombol backup disebelah kanan atas, untuk melakukan backup database.
			</p>
    </div>
  </div>
</section>

<script>
</script>
