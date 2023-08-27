@extends('layouts.app')

@section('content')

<div class="section-header">
    <h1>Stok Produk</h1>
    <div class="ml-auto">
        <a href="javascript:void(0)" class="btn btn-danger" id="print-stok-produk"><i class="fa fa-sharp fa-light fa-print"></i> Print PDF</a>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="card card-primary">
            <div class="card-body">
                <div class="form-group">
                    <label for="opsi-laporan-stok">Filter Stok Berdasarkan :</label>
                    <select class="form-control" name="opsi-laporan-stok" id="opsi-laporan-stok">
                        <option value="semua" selected>Semua</option>
                        <option value="minimum">Batas Minimum</option>
                        <option value="stok-habis">Stok Habis</option>
                    </select>
                </div>

                <hr>

                <div class="table-responsive">
                    <table id="table_id" class="table table-bordered table-hover table-striped table-condensed">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kode Produk</th>
                                <th>Nama Produk</th>
                                <th>Stok</th>
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

<!-- Fetch Data  -->
<script>
    $(document).ready(function(){
        let table = $('#table_id').DataTable();

        loadData('semua');

        $('#opsi-laporan-stok').on('change', function(){
            var selectedOption = $(this).val();
            loadData(selectedOption);
        })

        function loadData(selectedOption){
            $.ajax({
                url: '/stok-produk/get-data',
                type: "GET",
                data: { opsi: selectedOption }, // Pass selected option to the server
                dataType: 'JSON',
                success: function(response){
                    let counter = 1;
                    $('#table_id').DataTable().clear();
                    $.each(response, function(key, value){
                        let produk = `
                        <tr class="barang-row" id="index_${value.id}">
                            <td>${counter++}</td>   
                            <td>${value.kd_produk}</td>
                            <td>${value.nm_produk}</td>
                            <td><span class="badge badge-warning">${value.stok}</span></td>
                        </tr>
                    `;
                    $('#table_id').DataTable().row.add($(produk)).draw(false);
                    });
                }
            });
        }
        $('#print-stok-produk').on('click', function(){
            var selectedOption = $('#opsi-laporan-stok').val();
            window.location.href = '/stok-produk/laporan-stok?opsi=' + selectedOption;
        });
    });
</script>



@endsection