<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan Produk Keluar</title>
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
                <h3 style="text-align: center;">Laporan Arus Kas {{ ($tanggalMulai && $tanggalSelesai) ? $tanggalMulai . ' - ' . $tanggalSelesai : 'Semua Range Tanggal' }}
                </h3>
            </div>
            <div class="col">
                <table id="table_id" class="display">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Saldo Tersisa</th>
                            <th>Pengeluaran</th>
                            <th>Pemasukan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $kas)
                            <tr>
                                <td style="text-align: center">{{ $loop->iteration }}</td>
                                <td style="text-align: center">{{ date('d-m-Y', strtotime($kas->tanggal)) }}</td>
                                <td style="text-align: center">Rp. {{ number_format($kas->saldo, 2, ',', '.') }}</td>
                                <td style="text-align: center">Rp. {{ number_format($kas->pengeluaran, 2, ',', '.') }}</td>
                                <td style="text-align: center">Rp. {{ number_format($kas->pemasukan, 2, ',', '.') }}</td>
                            </tr>  
                        @endforeach                     
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
