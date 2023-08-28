@extends('layouts.app')

@include('produk-keluar.create')

@section('content')

<style>
    .text-on-left {
        text-align: left !important;
        float: left !important;
        width: 100% !important;
    }
</style>

<div class="section-header">
    <h1>Daftar Produk Keluar</h1>
    <div class="ml-auto">
        <a href="javascript:void(0)" class="btn btn-primary mx-2" id="button_tambah_barangKeluar"><i class="fa fa-plus"></i> Tambah Produk Keluar</a>
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
                                <th>Tanggal Keluar</th>
                                <th>Stok Keluar</th>
                                <th>Deskripsi</th>
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
    $(document).ready(function(){
        $('#table_id').DataTable();
    })
</script>

<!-- Generate Tanggal Hari Ini -->
<script>
    var today   = new Date();
    var year    = today.getFullYear();
    var month   = (today.getMonth() + 1).toString().padStart(2, '0');
    var day     = today.getDate().toString().padStart(2, '0');

    var formattedDate = year + '-' + month + '-' + day;
    document.getElementById('tgl_keluar').value = formattedDate;
</script>

<!-- Select2 & Autocomplete -->
<script>
    $(document).ready(function(){
        setTimeout(function(){
            $('.select2').select2();

            $('#nm_produk').on('change', function(){
                var selectedOption = $(this).find('option:selected');
                var nm_produk      = selectedOption.text();

                $.ajax({
                    url: 'api/produk-keluar',
                    type: 'GET',
                    data: {
                        nm_produk: nm_produk,
                    },
                    success: function (response){
                        if(response.stok || response.stok === 0){
                            $('#stok').val(response.stok);
                            $('#harga_beli').val(response.harga_beli);
                        } else if (response && response.stok === 0){
                            $('#stok').val(0);
                            $('#harga_beli').val(0);
                        }
                    }
                });
            });
        }, 500);
    });
</script>

<!-- Fetch Data -->
<script>
    $.ajax({
        url: '/produk-keluar/get-data',
        type: "GET",
        dataType: 'JSON',
        success: function(response){
            let counter = 1;
            $('#table_id').DataTable().clear();
            $.each(response.data, function(key,value){
                let produkKeluar = `
                <tr class="barang-row" id="index_${value.id}">
                    <td>${counter++}</td>   
                    <td>${value.kd_transaksi}</td>
                    <td>${value.nm_produk}</td>
                    <td>${value.tgl_keluar}</td>
                    <td>${value.stok_keluar}</td>
                    <td>${value.deskripsi}</td>
                </tr>
                `;
            $('#table_id').DataTable().row.add($(produkKeluar)).draw(false);
            });
        }
    });
</script>

<!-- Show Modal Tambah & function Store Data -->
<script>
    $('body').on('click', '#button_tambah_barangKeluar', function(){
        $('#modal_tambah_barangKeluar').modal('show');
        clearAlert();
    });

    function clearAlert(){
        $('#alert-stok_keluar').removeClass('d-block').addClass('d-none');
        $('#alert-deskripsi').removeClass('d-block').addClass('d-none');
    }

    $('#store').click(function(e){
        e.preventDefault();

        let nm_produk   = $('#nm_produk').val();
        let tgl_keluar  = $('#tgl_keluar').val();
        let stok_keluar = $('#stok_keluar').val();
        let harga_beli  = $('#harga_beli ').val();
        let deskripsi   = $('#deskripsi').val();
        let token       = $("meta[name='csrf-token']").attr("content");

        let formData = new FormData();
        formData.append('nm_produk', nm_produk);
        formData.append('tgl_keluar', tgl_keluar);
        formData.append('stok_keluar', stok_keluar);
        formData.append('harga_beli', harga_beli);
        formData.append('deskripsi', deskripsi);
        formData.append('_token', token);

        $.ajax({
            url: '/produk-keluar',
            type: "POST",
            cache: false,
            data: formData,
            contentType: false,
            processData: false,

            success:function(response){
                Swal.fire({
                    type: 'success',
                    icon: 'success',
                    title: `${response.message}`,
                    showConfirmButton: true,
                    timer: 3000
                });

                $.ajax({
                    url: '/produk-keluar/get-data',
                    type: "GET",
                    cache: false,
                    success: function(response){
                        let counter = 1;
                        $('#table_id').DataTable().clear();
                        $.each(response.data, function(key,value){
                            let produkKeluar = `
                            <tr class="barang-row" id="index_${value.id}">
                                <td>${counter++}</td>   
                                <td>${value.kd_transaksi}</td>
                                <td>${value.nm_produk}</td>
                                <td>${value.tgl_keluar}</td>
                                <td>${value.stok_keluar}</td>
                                <td>${value.deskripsi}</td>
                            </tr>
                            `;
                        $('#table_id').DataTable().row.add($(produkKeluar)).draw(false);
                        });

                        $('#nm_produk').val('');
                        $('#stok_keluar').val('');
                        $('#harga_beli').val('');
                        $('#deskripsi').val('');

                        $('#modal_tambah_barangKeluar').modal('hide');

                        let table = $('#table_id').DataTable();
                        table.draw();
                    },
                    error:function(error){
                        console.log(error);
                    }
                });
            },
            error:function(error){
                if(error.responseJSON && error.responseJSON.nm_produk && error.responseJSON.nm_produk[0]){
                    $('#alert-nm_produk').removeClass('d-none');
                    $('#alert-nm_produk').addClass('d-block');

                    $('#alert-nm_produk').html(error.responseJSON.nm_produk[0]);
                }

                if(error.responseJSON && error.responseJSON.stok_keluar && error.responseJSON.stok_keluar[0]){
                    $('#alert-stok_keluar').removeClass('d-none');
                    $('#alert-stok_keluar').addClass('d-block');

                    $('#alert-stok_keluar').html(error.responseJSON.stok_keluar[0]);
                }

                if(error.responseJSON && error.responseJSON.deskripsi && error.responseJSON.deskripsi[0]){
                    $('#alert-deskripsi').removeClass('d-none');
                    $('#alert-deskripsi').addClass('d-block');

                    $('#alert-deskripsi').html(error.responseJSON.deskripsi[0]);
                }
            }
        });
    });
</script>

@endsection