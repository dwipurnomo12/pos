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
                @if ($totalPemasukan || $totalPengeluaran || $labaBersih)
                    <table class="table table-bordered" id="table">
                        <thead>
                            <tr>
                                <th colspan="2">Laba bersih Bulan : {{ \Carbon\Carbon::parse($bulanTahun)->locale('id')->isoFormat('MMMM Y') }}</th>
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
                                <td>Biaya Operasional</td>
                                <td>
                                    @foreach ($dataBiayaOperasional as $Operasional)
                                        <p> - {{ $Operasional->operasional }} : Rp. {{ number_format( $Operasional->biaya , 2, ',', '.') }} </p>
                                    @endforeach
                                </td>
                            </tr>
                            <tr>
                                <td style="background: green">Laba bersih</td>
                                <td style="background: green">Rp. {{ number_format($labaBersih, 2, ',', '.') }}</td>
                            </tr>
                        </tbody>
                    </table>
                @else
                    <table class="table table-bordered" id="table">
                        <thead>
                            <tr>
                                <th colspan="2">Laba bersih Bulan : {{ $bulanTahun  }} </th>
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
