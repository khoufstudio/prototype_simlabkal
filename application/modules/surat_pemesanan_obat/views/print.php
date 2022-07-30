<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Print Surat Pemesanan Obat</title>
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

        .kop {
            text-align: center
        }

        .kop table {
            border: 1px solid #CCC;
            background: blue;
            border-collapse: collapse;
        }

        .kop table td {
            border: none;
        }

        .kop h1 {
            margin-bottom: 0px;
        }

        .kop h2 {
            margin-top: 0px;
            font-size: 18px;
        }


        .kop h3 {
            text-decoration: underline;
        }

        .kop hr {
            padding: 0;
            border: none;
            border-top: medium double #333;
            color: #333;
            text-align: center;
        }
	</style>
</head>
<body>
	<div class="kop">
        <?= $kop; ?>
        <hr>
        <h3 style="text-decoration: underline;">
          SURAT PESANAN <?= ($order['type_order'] == 1) ? 'TERTENTU' : 'PREKURSOR'; ?>
        </h3>
        <div style="
            display: flex;
            width: 100%;
            margin-bottom: 20px;
            text-align: left;
        ">
           <div style="width: 100%;">
              <strong>
                Yang bertanda tangan dibawah ini:
              </strong>
               <div>Nama : <?= $order['customer_name']; ?></div>
               <div>Kepada : <?= $order['position']; ?> </div>
               <div>No. SIPA : <?= $order['sipa']; ?> </div>
               <div>No. SIA : <?= $order['sia']; ?> </div>
              <strong>
                Mengajukan pesanan obat kepada:
              </strong>
               <div>Nama PBF: <?= $order['pbf_name']; ?></div>
               <div>Alamat : <?= $order['pbf_address']; ?> </div>
               <div>No. Telp : <?= $order['pbf_phone']; ?> </div>
           </div>
        </div>
	</div>
    
    <table>
		<thead>
			<tr>
				<td>No</td>
				<td>Nama Obat</td>
				<td>Zat aktif obat tertentu</td>
				<td>Sediaan</td>
				<td>Jumlah</td>
				<td>Keterangan</td>
			</tr>
		</thead>
		<tbody>
            <?php if (count($order_details) > 0):  ?>
                <?php foreach ($order_details as $key => $od):  ?>
                    <tr>
                        <td><?= ++$key; ?></td>
                        <td><?= $od->product_name; ?></td>
                        <td><?= $od->active_substance; ?></td>
                        <td><?= $od->preparation; ?></td>
                        <td><?= $od->quantity ?></td>
                        <td><?= $od->description ?></td>
                    </tr> 
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4" style="text-align: center;">Tidak ada barang</td>
                </tr>
            <?php endif; ?>
		</tbody>
</body>

<script>
  window.print()
</script>
</html>

