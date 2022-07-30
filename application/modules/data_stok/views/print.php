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
	<h2>Golongan: <?= ($golongan == 'semua' || $golongan == '') ? '-' : $golongan; ?></h2>
	<h2>Kepemilikan: <?= ($kepemilikan == 'semua' || $kepemilikan == '') ? '-' : $kepemilikan; ?></h2>
	<h2>Harga Jual: <?= intToRupiah($harga_jual); ?></h2>
	<h2>Harga Beli: <?= intToRupiah($harga_beli); ?></h2>

	<table>
		<thead>
			<tr>
				<td>No</td>
				<td>Nama Barang</td>
				<td>Satuan</td>
				<td>Kepemilikan</td>
				<td>Golongan</td>
				<td>Stok</td>
				<td>Harga Beli</td>
				<td>Harga Jual</td>
			</tr>
		</thead>
		<tbody>
    <?php if (isset($list_data_stok)): ?>
      <?php
        for ($i = 0; $i < count($list_data_stok); $i++): ?>
          <tr>
            <td><?= $i + 1; ?></td>
            <td><?= $list_data_stok[$i]['name']; ?></td>
            <td><?= $list_data_stok[$i]['denomination_name']; ?></td>
            <td><?= $list_data_stok[$i]['ownership']; ?></td>
            <td><?= $list_data_stok[$i]['product_type']; ?></td>
            <td><?= $list_data_stok[$i]['stock']; ?></td>
            <td><?= intToRupiah($list_data_stok[$i]['buying_price']); ?></td>
            <td><?= intToRupiah($list_data_stok[$i]['selling_price']); ?></td>
          </tr> 
        <?php endfor; ?>
      <?php endif; ?>
		</tbody>
</body>

<script>
  window.print()
</script>
</html>

