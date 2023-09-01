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
    <h1>Laporan Laba bersih</h1>
    <div class="ml-auto">
        <a href="/laporan-laba-bersih/print-laba-bersih" class="btn btn-danger" id="print-laporan-penjualan"><i class="fa fa-sharp fa-light fa-print"></i> Print PDF</a>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="card card-primary">
            <div class="card-body">
                <div class="form-group">
                    <form id="filter_form" action="/laporan-laba-bersih" method="GET">
                        <div class="row">
                            <div class="col-md-10">
                                <label for="bulan_tahun">Pilih Bulan dan Tahun:</label>
                                <input class="form-control" type="month" id="bulan_tahun" name="bulan_tahun" value="{{ now()->format('Y-m') }}" required>
                            </div>
                            <div class="col-md-2 d-flex align-items-end my-2">
                                <button type="submit" class="btn btn-primary mx-2">Filter</button>
                                <button type="button" class="btn btn-danger" id="refresh_btn">Refresh</button>
                            </div>
                        </div>
                    </form>
                </div>
                <hr>
                @if ($totalPemasukan || $totalPengeluaran || $labaBersih)
                    <table class="table table-bordered" id="table">
                        <thead>
                            <tr>
                                <th colspan="3">Laba bersih Bulan : {{ \Carbon\Carbon::parse($bulanTahun)->locale('id')->isoFormat('MMMM Y') }}</th>
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
                                <td>Biaya Operasional</td>
                                <td>:</td>
                                <td>
                                    @foreach ($dataBiayaOperasional as $Operasional)
                                        <p> - {{ $Operasional->operasional }} : Rp. {{ number_format( $Operasional->biaya , 2, ',', '.') }} </p>
                                    @endforeach
                                </td>
                            </tr>
                            <tr>
                                <td class="table-success">Laba bersih</td>
                                <td class="table-success">:</td>
                                <td class="table-success">Rp. {{ number_format($labaBersih, 2, ',', '.') }}</td>
                            </tr>
                        </tbody>
                    </table>
                @else
                    <table class="table table-bordered" id="table">
                        <thead>
                            <tr>
                                <th colspan="3">Laba bersih Bulan : {{ $bulanTahun  }} </th>
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
        window.location.replace('/laporan-laba-bersih');
    });
</script>
@endsection