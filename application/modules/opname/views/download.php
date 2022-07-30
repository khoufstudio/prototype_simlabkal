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
				<td>Selisih</td>
				<td></td>
			</tr>
		</thead>
		<tbody>
        <?php
			foreach ($laporan_opname as $key => $lo) { ?>
				<tr>
					<td><?= ++$key; ?></td>
					<td><?= date('d/m/Y H:i', strtotime($lo['tanggal_buat'])); ?></td>
					<td><?= $lo['product_name']; ?></td>
					<td><?= $lo['stock_current']; ?></td>
					<td><?= $lo['stock_real_current']; ?></td>
					<td><?= $lo['reason']; ?></td>
					<td><?= $difference = $lo['stock_real_current'] - $lo['stock_current']; ?></td>
					<td><?= intToRupiah($difference * $lo['selling_price']); ?></td>
				</tr> 
        <?php } ?>
		</tbody>
</body>

<script>
  window.print()
</script>
</html>

