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
	<h1><?= $nama_barang; ?></h1>
	<h2>Periode: <?= $periode; ?></h2>
	<table>
		<thead>
			<tr>
				<td>Tgl</td>
				<td>No Dok. Jual/Beli</td>
				<td>Supplier / Pelanggan</td>
				<td>Qty</td>
				<td>Stok</td>
				<td>ED</td>
			</tr>
		</thead>
		<tbody>
    <?php
			foreach ($list_kartu_stok as $key => $kartu_stok) { ?>
				<tr>
					<td><?= date('d/m/Y H:i', strtotime($kartu_stok['created_at'])); ?></td>
					<td><?= $kartu_stok['transaction_code']; ?></td>
					<td><?= $kartu_stok['supplier_name'] ?></td>
					<td><?= $kartu_stok['quantity'] ?></td>
					<td><?= $kartu_stok['stock'] ?></td>
					<td><?= date('d/m/Y H:i', strtotime($kartu_stok['expired_date'])); ?></td>
				</tr> 
			<?php } ?>
		</tbody>
</body>

<script>
  window.print()
</script>
</html>

