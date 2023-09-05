<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan Penjualan</title>
    <style>
        .container {
            text-align: center;
            margin: auto;
        }

        .column {
            text-align: center;
        }

        .row:after {
            content: "";
            display: table;
            clear: both;
        }

        table {
            margin: auto;
            width: 100%;
        }

        tr {
            text-align: left;
        }

        table, th, td {
            border-collapse: collapse;
            border: 1px solid black;
        }

        th, td {
            padding: 5px;
        }

        th{
            background-color: gainsboro;
        }

    </style>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="column">
                <h2>Toko Kelontong Berkah</h2>
                <p>Jl. Mangkuyudan 1, Desa Karangmulyo Rt.01, Rw.02, Kecamatan Purwodadi <br> Kabupaten Purworejo, Jawa Tengah 54173</p>
                <hr style="width: 85%; text-align: center;">
                <h3 style="text-align: center;">Laporan Penjualan {{ 
                    ($tanggalMulai && $tanggalSelesai) ? 
                    date('d-m-Y', strtotime($tanggalMulai)) . ' - ' . date('d-m-Y', strtotime($tanggalSelesai)) : 
                    'Semua Range Tanggal' 
                }}
                </h3>
            </div>
            <div class="col">
                <table id="table_id" class="display">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tgl- transaksi</th>
                            <th>Kode Transaksi</th>
                            <th>Sub-total</th>
                            <th>Item Pembelian</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $totalHarga = 0; ?>
                        @foreach ($data as $produk)
                            <tr>
                                <td style="text-align: center">{{ $loop->iteration }}</td>
                                <td style="text-align: center">{{ date('d-m-Y', strtotime($produk->tgl_transaksi)) }}</td>
                                <td>{{ $produk->kd_pembelian }}</td>
                                <td>Rp. {{ number_format($produk->sub_total, 2, ',', '.') }}</td>
                                <td>
                                    @if($produk->detailPenjualans->count() > 0)
                                        @foreach ($produk->detailPenjualans as $list)
                                            {{ $list->nm_produk }} (X{{ $list->quantity }}),
                                        @endforeach
                                    @endif
                                </td>
                            </tr>  
                            <?php $totalHarga += $produk->sub_total; ?>
                        @endforeach                     
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="5"><strong>Pendapatan Kotor : Rp. {{ number_format($totalHarga, 2, ',', '.') }}</strong></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
