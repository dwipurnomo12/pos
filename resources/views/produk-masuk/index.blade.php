@extends('layouts.app')

@include('produk-masuk.create')

@section('content')
    <style>
        .text-on-left {
            text-align: left !important;
            float: left !important;
            width: 100% !important;
        }
    </style>

    <div class="section-header">
        <h1>Daftar Produk Masuk</h1>
        <div class="ml-auto">
            <a href="javascript:void(0)" class="btn btn-primary mx-2" id="button_tambah_barangMasuk"><i class="fa fa-plus"></i>
                Tambah Produk Masuk</a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card card-primary">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="table_id" class="table table-bordered table-hover table-striped table-condensed">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kode Transaksi</th>
                                    <th>Nama Produk</th>
                                    <th>Tanggal Masuk</th>
                                    <th>Stok Masuk</th>
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
        $(document).ready(function() {
            $('#table_id').DataTable();

            $.ajax({
                url: '/produk-masuk/get-data',
                type: "GET",
                dataType: 'JSON',
                success: function(response) {
                    let counter = 1;
                    $('#table_id').DataTable().clear();
                    $.each(response.data, function(key, value) {
                        let produkMasuk = `
                            <tr class="barang-row" id="index_${value.id}">
                                <td>${counter++}</td>   
                                <td>${value.kd_transaksi}</td>
                                <td>${value.nm_produk}</td>
                                <td>${value.tgl_masuk}</td>
                                <td>${value.stok_masuk}</td>
                                <td>${value.supplier.supplier}</td>
                            </tr>
                            `;
                        $('#table_id').DataTable().row.add($(produkMasuk)).draw(false);
                    });
                }
            });
        });
    </script>

    <!-- Generate Tanggal Hari Ini -->
    <script>
        var today = new Date();
        var year = today.getFullYear();
        var month = (today.getMonth() + 1).toString().padStart(2, '0');
        var day = today.getDate().toString().padStart(2, '0');

        var formattedDate = year + '-' + month + '-' + day;
        document.getElementById('tgl_masuk').value = formattedDate;
    </script>

    <!-- Select2 & Autocomplete -->
    <script>
        $(document).ready(function() {
            setTimeout(function() {
                $('.select2').select2();

                $('#nm_produk').on('change', function() {
                    var selectedOption = $(this).find('option:selected');
                    var nm_produk = selectedOption.text();

                    $.ajax({
                        url: 'api/produk-masuk',
                        type: 'GET',
                        data: {
                            nm_produk: nm_produk,
                        },
                        success: function(response) {
                            if (response.stok || response.stok === 0) {
                                $('#stok').val(response.stok);
                                $('#harga_beli').val(response.harga_beli);
                                $('#harga_jual').val(response.harga_jual);
                            } else if (response && response.stok === 0) {
                                $('#stok').val(0);
                                $('#harga_beli').val(0);
                                $('#harga_jual').val(0);
                            }
                        }
                    });
                });
            }, 500);
        });
    </script>

    <!-- Show Modal Tambah & function Store Data -->
    <script>
        $('body').on('click', '#button_tambah_barangMasuk', function() {
            $('#modal_tambah_barangMasuk').modal('show');
            clearAlert();
        });

        function clearAlert() {
            $('#alert-harga_beli').removeClass('d-block').addClass('d-none');
            $('#alert-harga_jual').removeClass('d-block').addClass('d-none');
            $('#alert-stok_masuk').removeClass('d-block').addClass('d-none');
            $('#alert-supplier_id').removeClass('d-block').addClass('d-none');
        }

        $('#store').click(function(e) {
            e.preventDefault();

            let nm_produk = $('#nm_produk').val();
            let tgl_masuk = $('#tgl_masuk').val();
            let harga_beli = $('#harga_beli').val();
            let harga_jual = $('#harga_jual').val();
            let stok_masuk = $('#stok_masuk').val();
            let supplier_id = $('#supplier_id').val();
            let token = $("meta[name='csrf-token']").attr("content");

            let formData = new FormData();
            formData.append('nm_produk', nm_produk);
            formData.append('tgl_masuk', tgl_masuk);
            formData.append('harga_beli', harga_beli);
            formData.append('harga_jual', harga_jual);
            formData.append('stok_masuk', stok_masuk);
            formData.append('nm_produk', nm_produk);
            formData.append('supplier_id', supplier_id);
            formData.append('_token', token);

            $.ajax({
                url: '/produk-masuk',
                type: "POST",
                cache: false,
                data: formData,
                contentType: false,
                processData: false,

                success: function(response) {
                    Swal.fire({
                        type: 'success',
                        icon: 'success',
                        title: `${response.message}`,
                        showConfirmButton: true,
                        timer: 3000
                    });

                    $.ajax({
                        url: '/produk-masuk/get-data',
                        type: "GET",
                        cache: false,
                        success: function(response) {
                            let counter = 1;
                            $('#table_id').DataTable().clear();
                            $.each(response.data, function(key, value) {
                                let supplier = getSupplierName(response.supplier,
                                    value.supplier_id);
                                let produkMasuk = `
                            <tr class="barang-row" id="index_${value.id}">
                                <td>${counter++}</td>   
                                <td>${value.kd_transaksi}</td>
                                <td>${value.nm_produk}</td>
                                <td>${value.tgl_masuk}</td>
                                <td>${value.stok_masuk}</td>
                                <td>${supplier}</td>
                            </tr>
                            `;
                                $('#table_id').DataTable().row.add($(produkMasuk))
                                    .draw(false);
                            });

                            $('#nm_produk').val('');
                            $('#harga_jual').val('');
                            $('#harga_beli').val('');
                            $('#stok_masuk').val('');
                            $('#supplier_id').val('');

                            $('#modal_tambah_barangMasuk').modal('hide');

                            let table = $('#table_id').DataTable();
                            table.draw();

                            function getSupplierName(suppliers, supplierId) {
                                let supplier = suppliers.find(s => s.id === supplierId);
                                return supplier ? supplier.supplier : '';
                            }
                        },
                        error: function(error) {
                            console.log(error);
                        }
                    });
                },
                error: function(error) {
                    if (error.responseJSON && error.responseJSON.nm_produk && error.responseJSON
                        .nm_produk[0]) {
                        $('#alert-nm_produk').removeClass('d-none');
                        $('#alert-nm_produk').addClass('d-block');

                        $('#alert-nm_produk').html(error.responseJSON.nm_produk[0]);
                    }

                    if (error.responseJSON && error.responseJSON.harga_beli && error.responseJSON
                        .harga_beli[0]) {
                        $('#alert-harga_beli').removeClass('d-none');
                        $('#alert-harga_beli').addClass('d-block');

                        $('#alert-harga_beli').html(error.responseJSON.harga_beli[0]);
                    }

                    if (error.responseJSON && error.responseJSON.harga_jual && error.responseJSON
                        .harga_jual[0]) {
                        $('#alert-harga_jual').removeClass('d-none');
                        $('#alert-harga_jual').addClass('d-block');

                        $('#alert-harga_jual').html(error.responseJSON.harga_jual[0]);
                    }

                    if (error.responseJSON && error.responseJSON.stok_masuk && error.responseJSON
                        .stok_masuk[0]) {
                        $('#alert-stok_masuk').removeClass('d-none');
                        $('#alert-stok_masuk').addClass('d-block');

                        $('#alert-stok_masuk').html(error.responseJSON.stok_masuk[0]);
                    }

                    if (error.responseJSON && error.responseJSON.supplier_id && error.responseJSON
                        .supplier_id[0]) {
                        $('#alert-supplier_id').removeClass('d-none');
                        $('#alert-supplier_id').addClass('d-block');

                        $('#alert-supplier_id').html(error.responseJSON.supplier_id[0]);
                    }
                }
            });
        });
    </script>
@endsection
