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
    <h1>Laporan Arus Kas</h1>
    <div class="ml-auto">
        <a href="javascript:void(0)" class="btn btn-danger" id="print-arus-kas"><i class="fa fa-sharp fa-light fa-print"></i> Print PDF</a>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="card card-primary">
            <div class="card-body">
                <div class="form-group">
                    <form id="filter_form" action="/laporan-arus-kas/get-data" method="GET">
                        <div class="row">
                            <div class="col-md-5 my-2">
                                <label>Pilih Tanggal Mulai :</label>
                                <input type="date" class="form-control" name="tanggal_mulai" id="tanggal_mulai">
                            </div>
                            <div class="col-md-5 my-2">
                                <label>Pilih Tanggal Selesai :</label>
                                <input type="date" class="form-control" name="tanggal_selesai" id="tanggal_selesai">
                            </div>
                            <div class="col-md-2 d-flex align-items-end my-2">
                                <button type="submit" class="btn btn-primary mx-2">Filter</button>
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
                                <th>Tanggal</th>
                                <th>Saldo Tersisa</th>
                                <th>Pengeluaran</th>
                                <th>Pemasukan</th>
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

        $('#filter_form').submit(function (event){
            event.preventDefault();
            loadData();
        });

        $('#refresh_btn').on('click', function () { 
            refreshTable();
        });

        function loadData(){
            var tanggalMulai    = $('#tanggal_mulai').val();
            var tanggalSelesai  = $('#tanggal_selesai').val();

            $.ajax({
                url: '/laporan-arus-kas/get-data',
                type: "GET",
                dataType: 'JSON',
                data: {
                    tanggal_mulai: tanggalMulai,
                    tanggal_selesai: tanggalSelesai
                },
                success: function (response){
                    let counter = 1;
                    table.clear().draw();

                    if(response.length === 0){
                        $('#table_id tbody');
                    } else {
                        $.each(response, function (key, value){
                            let formattedSaldo       = parseFloat(value.saldo).toLocaleString('id-ID', { style: 'currency', currency: 'IDR' });
                            let formattedPengeluaran = parseFloat(value.pengeluaran).toLocaleString('id-ID', { style: 'currency', currency: 'IDR' });
                            let formattedPemasukan   = parseFloat(value.pemasukan).toLocaleString('id-ID', { style: 'currency', currency: 'IDR' });
                            let arusKas = `
                                <tr class="barang-row" id="index_${value.id}">
                                    <td>${counter++}</td>
                                    <td>${value.tanggal}</td>
                                    <td><span class="badge badge-light">${formattedSaldo}</span></td>
                                    <td><span class="badge badge-danger">${formattedPengeluaran}</span></td>
                                    <td><span class="badge badge-success">${formattedPemasukan}</span></td>
                                </tr>
                            `;
                            table.row.add($(arusKas)).draw(false);
                        });
                    }
                }
            });
        }

        function refreshTable(){
            $('#filter_form')[0].reset();
            loadData();
        }

        $('#print-arus-kas').on('click', function(){
            var tanggalMulai    = $('#tanggal_mulai').val();
            var tanggalSelesai  = $('#tanggal_selesai').val();

            var url = '/laporan-arus-kas/print-arus-kas';

            if(tanggalMulai && tanggalSelesai){
                url += '?tanggal_mulai=' + tanggalMulai + '&tanggal_selesai=' + tanggalSelesai;
            }

            window.location.href = url;
        });
    });
</script>





@endsection