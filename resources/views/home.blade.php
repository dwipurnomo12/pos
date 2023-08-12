@extends('layouts.app')

@section('content')
<div class="section-header">
    <h1>Dashboard</h1>
</div>
<div class="row">
    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
      <div class="card card-statistic-1">
        <div class="card-icon bg-primary">
          <i class="fas fa-thin fa-cubes"></i>
        </div>
        <div class="card-wrap">
          <div class="card-header">
            <h4>Semua Barang</h4>
          </div>
          <div class="card-body">

          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
      <div class="card card-statistic-1">
        <div class="card-icon bg-danger">
          <i class="fas fa-file-import"></i>
        </div>
        <div class="card-wrap">
          <div class="card-header">
            <h4>Barang Masuk</h4>
          </div>
          <div class="card-body">
        
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
      <div class="card card-statistic-1">
        <div class="card-icon bg-warning">
          <i class="fas fa-file-export"></i>
        </div>
        <div class="card-wrap">
          <div class="card-header">
            <h4>Barang Keluar</h4>
          </div>
          <div class="card-body">

          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
      <div class="card card-statistic-1">
        <div class="card-icon bg-success">
          <i class="far fa-user"></i>
        </div>
        <div class="card-wrap">
          <div class="card-header">
            <h4>Pengguna</h4>
          </div>
          <div class="card-body">
            
          </div>
        </div>
      </div>
    </div>
</div>
@endsection
