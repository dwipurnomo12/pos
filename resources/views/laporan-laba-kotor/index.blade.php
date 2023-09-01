@extends('layouts.app')

@section('content')

<style>
    .text-on-left {
        text-align: left !important;
        float: left !important;
        width: 100% !important;
    }
</style>

<div class="section-header">
    <h1>Laporan Laba Kotor</h1>
    <div class="ml-auto">
        <a href="/laporan-laba-kotor/print-laba-kotor" class="btn btn-danger" id="print-laporan-penjualan"><i class="fa fa-sharp fa-light fa-print"></i> Print PDF</a>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="card card-primary">
            <div class="card-body">
                <div class="form-group">
                    <form id="filter_form" action="/laporan-laba-kotor" method="GET">
                        <div class="row">
                            <div class="col-md-5 my-2">
                                <label>Pilih Tanggal Mulai :</label>
                                <input type="date" class="form-control" name="tanggal_mulai" id="tanggal_mulai" value="{{ $tanggalMulai }}">
                            </div>
                            <div class="col-md-5 my-2">
                                <label>Pilih Tanggal Selesai :</label>
                                <input type="date" class="form-control" name="tanggal_selesai" id="tanggal_selesai" value="{{ $tanggalSelesai }}">
                            </div>
                            <div class="col-md-2 d-flex align-items-end my-2">
                                <button type="submit" class="btn btn-primary mx-2">Filter</button>
                                <button type="button" class="btn btn-danger" id="refresh_btn">Refresh</button>
                            </div>
                        </div>
                    </form>                    
                </div>
                <hr>
                @if ($totalPemasukan || $totalPengeluaran || $labaKotor)
                    <table class="table table-bordered" id="table">
                        <thead>
                            <tr>
                                <th colspan="3">Laba Kotor Periode :  {{ ($tanggalMulai && $tanggalSelesai) ? date('d-m-Y', strtotime($tanggalMulai)) . ' - ' . date('d-m-Y', strtotime($tanggalSelesai)) : 'Hari Ini' }} </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Total Pemasukan</td>
                                <td>:</td>
                                <td>Rp. {{ number_format($totalPemasukan, 2, ',', '.') }}</td>
                            </tr>
                            <tr>
                                <td>Total Pengeluaran</td>
                                <td>:</td>
                                <td>Rp. {{ number_format($totalPengeluaran, 2, ',', '.') }}</td>
                            </tr>
                            <tr>
                                <td class="table-warning">Laba Kotor</td>
                                <td class="table-warning">:</td>
                                <td class="table-warning">Rp. {{ number_format($labaKotor, 2, ',', '.') }}</td>
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
</div>

<script>
    document.getElementById('refresh_btn').addEventListener('click', function() {
        window.location.replace('/laporan-laba-kotor');
    });
</script>
@endsection