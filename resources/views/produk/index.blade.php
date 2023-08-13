@extends('layouts.app')

@include('produk.create')
@include('produk.edit')
@include('produk.show')

@section('content')

<div class="section-header">
    <h1>Daftar Produk</h1>
    <div class="ml-auto">
        <a href="javascript:void(0)" class="btn btn-primary" id="button_tambah_produk"><i class="fa fa-plus"></i> Tambah Produk</a>
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
                                <th>Kode Produk</th>
                                <th>Nama Produk</th>
                                <th>Harga Beli</th>
                                <th>Harga Jual</th>
                                <th>Stok</th>
                                <th>Opsi</th>
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

<!-- Fetch Data -->
<script>
    $.ajax({
        url: "/produk/get-data",
        type: "GET",
        dataType: 'JSON',
        success: function(response){
            let counter = 1;
            $('#table_id').DataTable().clear();
            $.each(response.data, function(key, value){
                let produk = `
                <tr class="barang-row" id="index_${value.id}">
                    <td>${counter++}</td>   
                    <td>${value.kd_produk}</td>
                    <td>${value.nm_produk}</td>
                    <td>Rp. ${value.harga_beli}</td>
                    <td>Rp. ${value.harga_jual}</td>>
                    <td>${value.stok}</td>
                    <td>
                        <a href="javascript:void(0)" id="button_detail_produk" data-id="${value.id}" class="btn btn-lg btn-success mb-2"><i class="far fa-eye"></i> </a>
                        <a href="javascript:void(0)" id="button_edit_produk" data-id="${value.id}" class="btn btn-lg btn-warning mb-2"><i class="far fa-edit"></i> </a>
                        <a href="javascript:void(0)" id="button_hapus_produk" data-id="${value.id}" class="btn btn-lg btn-danger mb-2"><i class="fas fa-trash"></i> </a>
                    </td>
                </tr>
            `;
            $('#table_id').DataTable().row.add($(produk)).draw(false);
            });
        }
    });
</script>

<!-- Show Modal Tambah & Function Store Data -->
<script>
    $('body').on('click', '#button_tambah_produk', function(){
        $('#modal_tambah_produk').modal('show');
        clearAlert();
    });

    function clearAlert(){
        $('#alert-nm_produk').removeClass('d-block').addClass('d-none');
        $('#alert-kategori_id').removeClass('d-block').addClass('d-none');
        $('#alert-supplier_id').removeClass('d-block').addClass('d-none');
        $('#alert-deskripsi').removeClass('d-block').addClass('d-none');
        $('#alert-satuan_id').removeClass('d-block').addClass('d-none');
    }

    $('#store').click(function(e){
        e.preventDefault();

        let nm_produk   = $('#nm_produk').val();
        let deskripsi   = $('#deskripsi').val();
        let kategori_id = $('#kategori_id').val();
        let supplier_id = $('#supplier_id').val();
        let satuan_id   = $('#satuan_id').val();
        let token       = $("meta[name='csrf-token']").attr("content");

        let formData = new FormData();
        formData.append('nm_produk', nm_produk);
        formData.append('deskripsi', deskripsi);
        formData.append('kategori_id', kategori_id);
        formData.append('supplier_id', supplier_id);
        formData.append('satuan_id', satuan_id);
        formData.append('_token', token);

        $.ajax({
            url : '/produk',
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
                    url : '/produk/get-data',
                    type: "GET",
                    cache: false,
                    success:function(response){
                        let counter = 1;
                        $('#table_id').DataTable().clear();
                        $.each(response.data, function(key, value){
                            let produk = `
                                <tr class="barang-row" id="index_${value.id}">
                                    <td>${counter++}</td>   
                                    <td>${value.kd_produk}</td>
                                    <td>${value.nm_produk}</td>
                                    <td>Rp. ${value.harga_beli}</td>
                                    <td>Rp. ${value.harga_jual}</td>
                                    <td>${value.stok}</td>
                                    <td>
                                        <a href="javascript:void(0)" id="button_detail_produk" data-id="${value.id}" class="btn btn-lg btn-success mb-2"><i class="far fa-eye"></i> </a>
                                        <a href="javascript:void(0)" id="button_edit_produk" data-id="${value.id}" class="btn btn-icon btn-warning btn-lg mb-2"><i class="far fa-edit"></i> </a>
                                        <a href="javascript:void(0)" id="button_hapus_produk" data-id="${value.id}" class="btn btn-icon btn-danger btn-lg mb-2"><i class="fas fa-trash"></i> </a>
                                    </td>
                                </tr>
                             `;
                        $('#table_id').DataTable().row.add($(produk)).draw(false);
                        });

                        $('#nm_produk').val('');
                        $('#deskripsi').val('');
                        $('#kategori_id').val('');
                        $('#supplier_id').val('');
                        $('#satuan_id').val('');
                        $('#modal_tambah_produk').modal('hide');

                        let table = $('#table_id').DataTable();
                        table.draw();
                    },
                    error:function(error){
                        console.log(error);
                    }
                })
            },

            error:function(error){
                if(error.responseJSON && error.responseJSON.nm_produk && error.responseJSON.nm_produk[0]){
                    $('#alert-nm_produk').removeClass('d-none');
                    $('#alert-nm_produk').addClass('d-block');

                    $('#alert-nm_produk').html(error.responseJSON.nm_produk[0]);
                }
                if(error.responseJSON && error.responseJSON.deskripsi && error.responseJSON.deskripsi[0]){
                    $('#alert-deskripsi').removeClass('d-none');
                    $('#alert-deskripsi').addClass('d-block');

                    $('#alert-deskripsi').html(error.responseJSON.deskripsi[0]);
                }
                if(error.responseJSON && error.responseJSON.kategori_id && error.responseJSON.kategori_id[0]){
                    $('#alert-kategori_id').removeClass('d-none');
                    $('#alert-kategori_id').addClass('d-block');

                    $('#alert-kategori_id').html(error.responseJSON.kategori_id[0]);
                }
                if(error.responseJSON && error.responseJSON.supplier_id && error.responseJSON.supplier_id[0]){
                    $('#alert-supplier_id').removeClass('d-none');
                    $('#alert-supplier_id').addClass('d-block');

                    $('#alert-supplier_id').html(error.responseJSON.supplier_id[0]);
                }
                if(error.responseJSON && error.responseJSON.satuan_id && error.responseJSON.satuan_id[0]){
                    $('#alert-satuan_id').removeClass('d-none');
                    $('#alert-satuan_id').addClass('d-block');

                    $('#alert-satuan_id').html(error.responseJSON.satuan_id[0]);
                }
            }
        });
    });
</script>

<!-- Show Modal Detail -->
<script>
    $('body').on('click', '#button_detail_produk', function(){
        let produk_id   = $(this).data('id');

        $.ajax({
            url: `/produk/${produk_id}/`,
            type: "GET",
            cache: false,
            success:function(response){
                $('#produk_id').val(response.data.id);
                $('#detail_nm_produk').val(response.data.nm_produk);
                $('#detail_kd_produk').val(response.data.kd_produk);
                $('#detail_deskripsi').val(response.data.deskripsi);
                $('#detail_harga_jual').val(response.data.harga_jual);
                $('#detail_harga_beli').val(response.data.harga_beli);
                $('#detail_kategori_id').val(response.data.kategori_id);
                $('#detail_supplier_id').val(response.data.supplier_id);
                $('#detail_satuan_id').val(response.data.satuan_id);
                $('#detail_stok').val(response.data.stok);

                $('#modal_detail_produk').modal('show');
            }
        });
    });
</script>

<!-- Show Modal Edit & Update Proccess -->
<script>
    $('body').on('click', '#button_edit_produk', function(){
        let produk_id = $(this).data('id');

        $.ajax({
            url: `/produk/${produk_id}/edit`,
            type: "GET",
            cache: false,
            success:function(response){
                $('#produk_id').val(response.data.id);
                $('#edit_nm_produk').val(response.data.nm_produk);
                $('#edit_harga_jual').val(response.data.harga_jual);
                $('#edit_deskripsi').val(response.data.deskripsi);
                $('#edit_kategori_id').val(response.data.kategori_id);
                $('#edit_supplier_id').val(response.data.supplier_id);
                $('#edit_satuan_id').val(response.data.satuan_id);

                $('#modal_edit_produk').modal('show');
            }
        });
    });

    $('#update').click(function(e){
        e.preventDefault();

        let produk_id     = $('#produk_id').val();
        let nm_produk     = $('#edit_nm_produk').val();
        let harga_jual    = $('#edit_harga_jual').val();
        let deskripsi     = $('#edit_deskripsi').val();
        let kategori_id   = $('#edit_kategori_id').val();
        let supplier_id   = $('#edit_supplier_id').val();
        let satuan_id     = $('#edit_satuan_id').val();
        let token         = $("meta[name='csrf-token']").attr('content');

        let formData = new FormData();
        formData.append('nm_produk', nm_produk);
        formData.append('harga_jual', harga_jual);
        formData.append('deskripsi', deskripsi);
        formData.append('kategori_id', kategori_id);
        formData.append('supplier_id', supplier_id);
        formData.append('satuan_id', satuan_id);
        formData.append('_token', token);
        formData.append('_method', 'PUT');

        $.ajax({
            url: `/produk/${produk_id}`,
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
                    timer:3000
                });

                let row = $(`#index_${response.data.id}`);
                let rowData = row.find('td');
                
                rowData.eq(1).text(response.data.kd_produk);
                rowData.eq(2).text(response.data.nm_produk);
                rowData.eq(3).text(`Rp. ${response.data.harga_beli}`);
                rowData.eq(4).text(`Rp. ${response.data.harga_jual}`);
                rowData.eq(5).text(response.data.stok);
        
                $('#modal_edit_produk').modal('hide');
            },
            
            error:function(error){
                if(error.responseJSON && error.responseJSON.nm_produk && error.responseJSON.nm_produk[0]){
                    $('#alert-nm_produk').removeClass('d-none');
                    $('#alert-nm_produk').addClass('d-block');

                    $('#alert-nm_produk').html(error.responseJSON.nm_produk[0]);
                }
                if(error.responseJSON && error.responseJSON.harga_jual && error.responseJSON.harga_jual[0]){
                    $('#alert-harga_jual').removeClass('d-none');
                    $('#alert-harga_jual').addClass('d-block');

                    $('#alert-harga_jual').html(error.responseJSON.harga_jual[0]);
                }
                if(error.responseJSON && error.responseJSON.deskripsi && error.responseJSON.deskripsi[0]){
                    $('#alert-deskripsi').removeClass('d-none');
                    $('#alert-deskripsi').addClass('d-block');

                    $('#alert-deskripsi').html(error.responseJSON.deskripsi[0]);
                }
                if(error.responseJSON && error.responseJSON.kategori_id && error.responseJSON.kategori_id[0]){
                    $('#alert-kategori_id').removeClass('d-none');
                    $('#alert-kategori_id').addClass('d-block');

                    $('#alert-kategori_id').html(error.responseJSON.kategori_id[0]);
                }
                if(error.responseJSON && error.responseJSON.supplier_id && error.responseJSON.supplier_id[0]){
                    $('#alert-supplier_id').removeClass('d-none');
                    $('#alert-supplier_id').addClass('d-block');

                    $('#alert-supplier_id').html(error.responseJSON.supplier_id[0]);
                }
                if(error.responseJSON && error.responseJSON.satuan_id && error.responseJSON.satuan_id[0]){
                    $('#alert-satuan_id').removeClass('d-none');
                    $('#alert-satuan_id').addClass('d-block');

                    $('#alert-satuan_id').html(error.responseJSON.satuan_id[0]);
                }
            }
        });
    });
</script>

<!-- Modal Delete Data -->
<script>
$('body').on('click', '#button_hapus_produk', function(){
        let produk_id = $(this).data('id');
        let token       = $("meta[name='csrf-token']").attr("content");

        Swal.fire({
                title: 'Apakah Kamu Yakin?',
                text: "ingin menghapus data ini !",
                icon: 'warning',
                showCancelButton: true,
                cancelButtonText: 'TIDAK',
                confirmButtonText: 'YA, HAPUS!'
            }).then((result) => {
                if(result.isConfirmed){
                    $.ajax({
                        url: `/produk/${produk_id}`,
                        type: "DELETE",
                        cache: false,
                        data: {
                            "_token": token
                        },
                        success:function(response){
                            Swal.fire({
                                type: 'success',
                                icon: 'success',
                                title: `${response.message}`,
                                showConfirmButton: true,
                                timer: 3000
                            });
                            $('#table_id').DataTable().clear().draw();

                            $.ajax({
                                url: "/produk/get-data",
                                type: "GET",
                                dataType: 'JSON',
                                success: function(response){
                                    let counter = 1;
                                    $('#table_id').DataTable().clear();
                                    $.each(response.data, function(key, value){
                                        let produk = `
                                        <tr class="barang-row" id="index_${value.id}">
                                            <td>${counter++}</td>   
                                            <td>${value.kd_produk}</td>
                                            <td>${value.nm_produk}</td>
                                            <td>Rp. ${value.harga_beli}</td>
                                            <td>Rp. ${value.harga_jual}</td>
                                            <td>${value.stok}</td>
                                            <td>
                                                <a href="javascript:void(0)" id="button_detail_produk" data-id="${value.id}" class="btn btn-lg btn-success mb-2"><i class="far fa-eye"></i> </a>
                                                <a href="javascript:void(0)" id="button_edit_produk" data-id="${value.id}" class="btn btn-icon btn-warning btn-lg mb-2"><i class="far fa-edit"></i> </a>
                                                <a href="javascript:void(0)" id="button_hapus_produk" data-id="${value.id}" class="btn btn-icon btn-danger btn-lg mb-2"><i class="fas fa-trash"></i> </a>
                                            </td>
                                        </tr>
                                    `;
                                    $('#table_id').DataTable().row.add($(produk)).draw(false);
                                    });
                                }
                            });
                        }
                    })
                }
            });
        });
</script>

@endsection