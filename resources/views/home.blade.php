@extends('layouts.app')

@section('content')
<div class="section-header">
    <h1>Dashboard</h1>
</div>
<div class="row">
    <div class="col-lg-4 col-md-6 col-sm-6 col-12">
      <div class="card card-statistic-1">
        <div class="card-icon bg-danger">
          <i class="fas fa-file-import"></i>
        </div>
        <div class="card-wrap">
          <div class="card-header">
            <h4>Pemasukan Hari Ini</h4>
          </div>
          <div class="card-body">
           Rp. {{ $pemasukanHariIni }}
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-4 col-md-6 col-sm-6 col-12">
      <div class="card card-statistic-1">
        <div class="card-icon bg-warning">
          <i class="fas fa-file-export"></i>
        </div>
        <div class="card-wrap">
          <div class="card-header">
            <h4>Pengeluaran Hari Ini</h4>
          </div>
          <div class="card-body">
           Rp. {{ $pengeluaranHariIni }}
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-4 col-md-6 col-sm-6 col-12">
      <div class="card card-statistic-1">
        <div class="card-icon bg-success">
          <i class="fas fa-cart-plus"></i>
        </div>
        <div class="card-wrap">
          <div class="card-header">
            <h4>Penjualan Hari Ini</h4>
          </div>
          <div class="card-body">
           Rp. {{ $penjualanHariIni }}
          </div>
        </div>
      </div>
    </div>
</div>

<div class="row">
  <div class="col-lg-8">
    <div class="card card-primary">
      <div class="card-header">
        Stok Produk Mencapai Batas Minimum
      </div>
      <div class="card-body">
        <table class="table">
          <thead>
            <tr>
              <th scope="col">No</th>
              <th scope="col">Kode Produk</th>
              <th scope="col">Nama Produk</th>
              <th scope="col">Stok</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($stokMinimum as $produk)
              <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $produk->kd_produk }}</td>
                <td>{{ $produk->nm_produk }}</td>
                <td><span class="badge badge-warning"> {{ $produk->stok }}</span></td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <div class="col-lg-4">
    <div class="card card-primary">
      <div class="card-header">
        Produk Terlaris
      </div>
      <div class="card-body">
        
      </div>
    </div>
  </div>
</div>
@endsection
