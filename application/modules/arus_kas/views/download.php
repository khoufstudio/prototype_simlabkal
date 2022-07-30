<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<style>
		table {
			width: 100%;
			border: 1px solid black;
			border-collapse: collapse;
		}

		tr, td {
			border: 1px solid black;
		}

		thead td {
			font-weight: bold;
		}

	</style>
</head>
<body>
	<h1>Laporan Opanme</h1>
	<h2>Periode: <?= $periode; ?></h2>
	<table>
		<thead>
			<tr>
				<td>No</td>
				<td>Tanggal Opname</td>
				<td>Nama Barang</td>
				<td>Stok Barang</td>
				<td>Stok Barang Fisik</td>
				<td>Alasan</td>
			</tr>
		</thead>
		<tbody>
    <?php
			foreach ($laporan_opname as $key => $lo) { ?>
				<tr>
					<td><?= ++$key; ?></td>
					<td><?= date('d/m/Y H:i', strtotime($lo['created_at'])); ?></td>
					<td><?= $lo['product_id']; ?></td>
					<td><?= $lo['stock_current'] ?></td>
					<td><?= $lo['stock_real_current'] ?></td>
					<td><?= $lo['reason'] ?></td>
				</tr> 
			<?php } ?>
		</tbody>
</body>

<script>
  window.print()
</script>
</html>

