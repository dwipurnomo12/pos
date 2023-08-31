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
            width: 80%;
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
                </h3>
            </div>
            <div class="col">
                @if ($totalPemasukan || $totalPengeluaran || $labaKotor)
                    <table class="table table-bordered" id="table">
                        <thead>
                            <tr>
                                <th colspan="2">Laba Kotor Periode :  {{ ($tanggalMulai && $tanggalSelesai) ? date('d-m-Y', strtotime($tanggalMulai)) . ' - ' . date('d-m-Y', strtotime($tanggalSelesai)) : 'Hari Ini' }} </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Total Pemasukan</td>
                                <td>Rp. {{ number_format($totalPemasukan, 2, ',', '.') }}</td>
                            </tr>
                            <tr>
                                <td>Total Pengeluaran</td>
                                <td>Rp. {{ number_format($totalPengeluaran, 2, ',', '.') }}</td>
                            </tr>
                            <tr>
                                <td>Laba Kotor</td>
                                <td style="background: yellow">Rp. {{ number_format($labaKotor, 2, ',', '.') }}</td>
                            </tr>
                        </tbody>
                    </table>
                @else
                <table class="table table-bordered" id="table">
                    <thead>
                        <tr>
                            <th colspan="3">Laba Kotor Periode :  {{ ($tanggalMulai && $tanggalSelesai) ? date('d-m-Y', strtotime($tanggalMulai)) . ' - ' . date('d-m-Y', strtotime($tanggalSelesai)) : 'Hari Ini' }} </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Tidak Ada Data Yang Ditampilkan</td>
                        </tr>
                    </tbody>
                </table>
                @endif
            </div>
        </div>
    </div>
</body>
</html>
