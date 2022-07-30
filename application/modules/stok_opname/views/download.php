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
	<h1>Stok Opanme</h1>
	<table>
		<thead>
			<tr>
				<td>No</td>
				<td>Nama Barang</td>
				<td>Golongan</td>
				<td>Stok Barang</td>
				<td>Fisik</td>
				<td>ED</td>
			</tr>
		</thead>
		<tbody>
            <?php if (count($laporan_stok_opname) > 0) : ?>
                <?php for ($x = 0; $x < count($laporan_stok_opname); $x++) : ?>
                    <tr>
                        <td><?= $x + 1; ?></td>
                        <td><?= $laporan_stok_opname[$x]["product_name"]; ?></td>
                        <td><?= $laporan_stok_opname[$x]["type_name"]; ?></td>
                        <td><?= $laporan_stok_opname[$x]["stock"]; ?></td>
                        <td></td>
                        <td><?= ymdtoDmy($laporan_stok_opname[$x]["expired_date"]); ?></td>
                    </tr>
                <?php endfor; ?>
            <?php endif; ?>
		</tbody>
    </table>
</body>
</html>

<script>
  window.print()
</script>
