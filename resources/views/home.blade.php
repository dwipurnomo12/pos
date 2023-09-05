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
            Rp.{{ number_format($pemasukanHariIni, 2, ',', '.') }}
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
            Rp.{{ number_format($pengeluaranHariIni, 2, ',', '.') }}
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
            Rp.{{ number_format($penjualanHariIni, 2, ',', '.') }}
          </div>
        </div>
      </div>
    </div>
</div>

<div class="row">
  <div class="col-lg-6">
    <div class="card card-primary">
      <div class="card-header">
        Stok Produk Mencapai Batas Minimum
      </div>
      <div class="card-body">
        <div class="table-responsive">
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
  </div>

  <div class="col-lg-6">
    <div class="card card-primary">
      <div class="card-header">
        Jumlah Penjualan
      </div>
      <div class="card-body">
          <canvas id="myChart"></canvas>
      </div>
    </div>
  </div>
</div>

@endsection

@push('script')

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script>
    const ctx = document.getElementById('myChart');

    new Chart(ctx, {
      type: 'bar',
      data: {
        labels: [
          @foreach($chartPenjualan as $data)
            '{{ \Carbon\Carbon::parse($data->date)->locale('id')->dayName }}',
          @endforeach
        ],
        datasets: [{
          label: 'Jumlah Penjualam',
          data: [
            @foreach($chartPenjualan as $data)
              {{ $data->total }},
            @endforeach
          ],
          borderWidth: 1
        }]
      },
      options: {
        scales: {
          y: {
            beginAtZero: true,
            precision: 0,
            stepsize: 1,
            ticks: {
              callback: function(value){
                if(value % 1 === 0){
                  return value;
                }
              }
            }
          }
        }
      }
    });
  </script>
@endpush
