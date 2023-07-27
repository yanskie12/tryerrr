<html><head><title>Laporan Stock Barang</title></head><body>
    <style type="text/css">
        table {
            width: 100%;
            border-collapse: collapse;
        }

        table tr th,
        table tr td {
            border: 1px solid black;
            font-size: 11pt;
            padding: 10px;
        }

        .text-center {
            text-align: center;
        }

        h3 {
            text-transform: uppercase;
        }
    </style>

    <div class="text-center">
        <h3>Laporan Stock Barang Minimarket Damar</h3>
        <p class="desc"><?= $tanggal; ?></p>
    </div>
    
    <br />
    <br />
    <table>
            <tr>
                <th>No</th>
                <th>Kode Barang</th>
                <th>ID Kategori</th>
                <th>Nama Barang</th>
                <th>Harga</th>
                <th>Stok</th>
                <th>Asset</th>
                
                
            </tr>
            <?php
            $no = 1;
            $total_jum = 0;
            foreach ($barang as $row) :
            ?>
                <tr>
                    <td align="center"><?= $no++; ?></td>
                    <td align="center"><?= $row->kdBarang ?></td>
                    <td align="center"><?= $row->idKategori ?></td>
                    <td align="center"><?= $row->namaBarang ?></td>
                    <td align="center"><?= $row->harga ?></td>
                    <td align="center"><?= $row->stok ?></td>
                    <td align="center"><?= $total = $row->harga * $row->stok ?></td>   
                    
                </tr>
                <?php $total_jum += $total  ?>
            <?php endforeach; ?>
            
    </table>

    <div class="text-left">

        <h3>Total Asset</h3><br>
        Rp<?= number_format($total_jum)  ?>
    </div>

</body></html>