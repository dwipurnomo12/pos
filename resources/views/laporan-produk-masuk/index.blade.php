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
    <h1>Laporan Produk Masuk / Pembelian</h1>
    <div class="ml-auto">
        <a href="javascript:void(0)" class="btn btn-danger" id="print-laporan-produk-masuk"><i class="fa fa-sharp fa-light fa-print"></i> Print PDF</a>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="card card-primary">
            <div class="card-body">
                <div class="form-group">
                    <form id="filter_form" action="/laporan-produk-masuk/get-data" method="GET">
                        <div class="row">
                            <div class="col-md-5">
                                <label>Pilih Tanggal Mulai :</label>
                                <input type="date" class="form-control" name="tanggal_mulai" id="tanggal_mulai">
                            </div>
                            <div class="col-md-5">
                                <label>Pilih Tanggal Selesai :</label>
                                <input type="date" class="form-control" name="tanggal_selesai" id="tanggal_selesai">
                            </div>
                            <div class="col-md-2 d-flex align-items-end">
                                <button type="submit" class="btn btn-primary">Filter</button>
                                <button type="button" class="btn btn-danger" id="refresh_btn">Refresh</button>
                            </div>
                        </div>
                    </form>
                </div>
                <hr>
                <div class="table-responsive">
                    <table id="table_id" class="table table-bordered table-hover table-striped table-condensed">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal Masuk</th>
                                <th>Kode Transaksi</th>
                                <th>Nama Produk</th>
                                <th>Stok Masuk</th>
                                <th>Harga Per-tem</th>
                                <th>Total Harga</th>
                                <th>Supplier</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Datatables Jquery -->
<script>
    $(document).ready(function () {
        let table = $('#table_id').DataTable();

        loadData();

        $('#filter_form').submit(function (event) {
            event.preventDefault();
            loadData();
        });

        $('#refresh_btn').on('click', function () { 
            refreshTable();
        });

        var suppliers = {}; 
        $(document).ready(function () {
            $.getJSON('{{ url('api/supplier') }}', function (data) {
                suppliers = data.reduce(function (acc, supplier) {
                    acc[supplier.id] = supplier.supplier;
                    return acc;
                }, {});
                loadData();
            });
        });

        function loadData() {
            var tanggalMulai = $('#tanggal_mulai').val();
            var tanggalSelesai = $('#tanggal_selesai').val();

            $.ajax({
                url: '/laporan-produk-masuk/get-data',
                type: "GET",
                dataType: 'JSON',
                data: {
                    tanggal_mulai: tanggalMulai,
                    tanggal_selesai: tanggalSelesai
                },
                success: function (response) {
                    let counter = 1;
                    table.clear().draw();

                    if(response.length === 0){
                        $('#table_id tbody');
                    } else {
                        $.each(response, function (key, value) {
                            let supplier = suppliers[value.supplier_id];
                            let produkMasuk = `
                                <tr class="barang-row" id="index_${value.id}">
                                    <td>${counter++}</td>
                                    <td>${value.tgl_masuk}</td>
                                    <td>${value.kd_transaksi}</td>
                                    <td>${value.nm_produk}</td>
                                    <td>${value.stok_masuk}</td>
                                    <td>Rp. ${value.harga_beli}</td>
                                    <td>Rp. ${value.total_harga}</td>
                                    <td>${supplier}</td>
                                </tr>
                            `;
                            table.row.add($(produkMasuk)).draw(false);
                    });
                    }
                }
            });
        }

        function refreshTable(){
            $('#filter_form')[0].reset();
            loadData();
        }

        $('#print-laporan-produk-masuk').on('click', function(){
            var tanggalMulai    = $('#tanggal_mulai').val();
            var tanggalSelesai  = $('#tanggal_selesai').val();

            var url = '/laporan-produk-masuk/print-produk-masuk';

            if(tanggalMulai && tanggalSelesai){
                url += '?tanggal_mulai=' + tanggalMulai + '&tanggal_selesai=' + tanggalSelesai;
            }

            window.location.href = url;
        });
    });
</script>





@endsection