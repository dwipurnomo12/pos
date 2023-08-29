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
        <a href="javascript:void(0)" class="btn btn-danger" id="print-laporan-penjualan"><i class="fa fa-sharp fa-light fa-print"></i> Print PDF</a>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="card card-primary">
            <div class="card-body">
                <h4>Laporan Laba Kotor</h4>
                <form action="/laporan-laba-kotor" method="GET">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="tanggal_awal">Tanggal Awal:</label>
                            <input type="date" name="tanggal_awal" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label for="tanggal_akhir">Tanggal Akhir:</label>
                            <input type="date" name="tanggal_akhir" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-primary mt-4">Filter</button>
                        </div>
                    </div>
                </form>
                <hr>
                @if(isset($totalPendapatan))
                <p>Total Pendapatan Kotor: {{ number_format($totalPendapatan, 2) }}</p>
                <p>Total Biaya Barang yang Dijual: {{ number_format($totalBiayaProdukMasuk, 2) }}</p>
                <p>Total Kerugian Produk: {{ number_format($totalBiayaProdukKeluar, 2) }}</p>
                <h4>Laba Kotor: {{ number_format($labaKotor, 2) }}</h4>
                @endif
            </div>
        </div>
    </div>
</div>


@endsection