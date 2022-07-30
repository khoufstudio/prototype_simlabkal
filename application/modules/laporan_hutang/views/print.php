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
	<h1>Laporan Hutang</h1>
	<h2>Periode: <?= $periode; ?></h2>
    <?php if ($supplier) :  ?>
        <h2>Supplier: <?= $list_laporan_hutang[0]['supplier']; ?></h2>
    <?php endif; ?>
	<table>
		<thead>
			<tr>
				<td>Tanggal</td>
				<td>Supplier</td>
				<td>No Faktur</td>
				<td>Jumlah Hutang</td>
				<td>Sisa</td>
			</tr>
		</thead>
		<tbody>
            <?php 
                for($x = 0; $x < count($list_laporan_hutang); $x++) :
            ?>
                <tr>
                    <td><?= ymdHisTodmyHis($list_laporan_hutang[$x]['tanggal_buat']); ?></td>
                    <td><?= $list_laporan_hutang[$x]['supplier']; ?></td>
                    <td><?= $list_laporan_hutang[$x]['invoice_number']; ?></td>
                    <td><?= intToRupiah($list_laporan_hutang[$x]['total']); ?></td>
                    <td><?= rest_count($list_laporan_hutang[$x]['debt_rest'], $list_laporan_hutang[$x]['total']); ?></td>
                </tr>
            <?php endfor; ?>
		</tbody>
    </table>
</body>

<script>
  window.print()
</script>
</html>

