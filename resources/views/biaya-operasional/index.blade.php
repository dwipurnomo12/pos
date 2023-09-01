@extends('layouts.app')

@include('biaya-operasional.create')
@include('biaya-operasional.edit')

@section('content')

<div class="section-header">
    <h1>List Biaya Operasional</h1>
    <div class="ml-auto">
        <a href="javascript:void(0)" class="btn btn-primary" id="button_tambah_operasional"><i class="fa fa-plus"></i> Tambah</a>
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
                                <th>Operasional</th>
                                <th>Biaya</th>
                                <th>Rentang</th>
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

<script>
    function formatRupiah(angka) {
        var formatter = new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });

        return formatter.format(angka).replace(/\s/g, ''); 
    }
</script>

<!-- Datatables Jquery -->
<script>
    $(document).ready(function(){
        $('#table_id').DataTable();

        $.ajax({
            url: "/biaya-operasional/get-data",
            type: "GET",
            dataType: 'JSON',
            success: function(response){
                let counter = 1;
                $('#table_id').DataTable().clear();
                $.each(response.data, function(key, value){
                    let operasional = `
                    <tr class="barang-row" id="index_${value.id}">
                        <td>${counter++}</td>   
                        <td>${value.operasional}</td>
                        <td>${formatRupiah(value.biaya)}</td>
                        <td>${value.rentang.rentang_bayar}</td>
                        <td>
                            <a href="javascript:void(0)" id="button_edit_operasional" data-id="${value.id}" class="btn btn-lg btn-warning mb-2"><i class="far fa-edit"></i> </a>
                            <a href="javascript:void(0)" id="button_hapus_operasional" data-id="${value.id}" class="btn btn-lg btn-danger mb-2"><i class="fas fa-trash"></i> </a>
                        </td>
                    </tr>
                `;
                $('#table_id').DataTable().row.add($(operasional)).draw(false);
                });
            }
        });
    });
</script>

<!-- Show Modal Tambah & Function Store Data -->
<script>
    $('body').on('click', '#button_tambah_operasional', function(){
        $('#modal_tambah_operasional').modal('show');
        clearAlert();
    });

    function clearAlert(){
        $('#alert-operasional').removeClass('d-block').addClass('d-none');
        $('#alert-biaya').removeClass('d-block').addClass('d-none');
        $('#alert-rentang_id').removeClass('d-block').addClass('d-none');
    }
    
    $('#store').click(function(e){
        e.preventDefault();

        let operasional     = $('#operasional').val();
        let biaya           = $('#biaya').val();
        let rentang_id      = $('#rentang_id').val();
        let token           = $("meta[name='csrf-token']").attr("content");

        let formData = new FormData();
        formData.append('operasional', operasional);
        formData.append('biaya', biaya);
        formData.append('rentang_id', rentang_id);
        formData.append('_token', token);

        $.ajax({
            url : '/biaya-operasional',
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
                    url : '/biaya-operasional/get-data',
                    type: "GET",
                    cache: false,
                    success:function(response){
                        let counter = 1;
                        $('#table_id').DataTable().clear();
                        $.each(response.data, function(key, value){
                            let operasional = `
                            <tr class="barang-row" id="index_${value.id}">
                                <td>${counter++}</td>   
                                <td>${value.operasional}</td>
                                <td>${formatRupiah(value.biaya)}</td>
                                <td>${value.rentang.rentang_bayar}</td>
                                <td>
                                    <a href="javascript:void(0)" id="button_edit_operasional" data-id="${value.id}" class="btn btn-lg btn-warning mb-2"><i class="far fa-edit"></i> </a>
                                    <a href="javascript:void(0)" id="button_hapus_operasional" data-id="${value.id}" class="btn btn-lg btn-danger mb-2"><i class="fas fa-trash"></i> </a>
                                </td>
                            </tr>
                            `;
                            $('#table_id').DataTable().row.add($(operasional)).draw(false);
                        });

                        $('#operasional').val('');
                        $('#biaya').val('');
                        $('#rentang').val('');
                        $('#status').val('');
                        $('#modal_tambah_operasional').modal('hide');

                        let table = $('#table_id').DataTable();
                        table.draw();
                    },
                    error:function(error){
                        console.log(error);
                    }
                })
            },

            error:function(error){
                if(error.responseJSON && error.responseJSON.operasional && error.responseJSON.operasional[0]){
                    $('#alert-operasional').removeClass('d-none');
                    $('#alert-operasional').addClass('d-block');

                    $('#alert-operasional').html(error.responseJSON.operasional[0]);
                }

                if(error.responseJSON && error.responseJSON.biaya && error.responseJSON.biaya[0]){
                    $('#alert-biaya').removeClass('d-none');
                    $('#alert-biaya').addClass('d-block');

                    $('#alert-biaya').html(error.responseJSON.biaya[0]);
                }

                if(error.responseJSON && error.responseJSON.rentang_id && error.responseJSON.rentang_id[0]){
                    $('#alert-rentang_id').removeClass('d-none');
                    $('#alert-rentang_id').addClass('d-block');

                    $('#alert-rentang_id').html(error.responseJSON.rentang_id[0]);
                }
            }
        });
    });
</script>

<!-- Show Modal Edit & Update Proccess -->
<script>
    $('body').on('click', '#button_edit_operasional', function(){
        let operasional_id = $(this).data('id');

        $.ajax({
            url: `/biaya-operasional/${operasional_id}/edit`,
            type: "GET",
            cache: false,
            success:function(response){
                $('#operasional_id').val(response.data.id);
                $('#edit_operasional').val(response.data.operasional);
                $('#edit_biaya').val(response.data.biaya);
                $('#edit_rentang_id').val(response.data.rentang_id);

                $('#modal_edit_operasional').modal('show');
            }
        });
    });

    $('#update').click(function(e){
        e.preventDefault();

        let operasional_id   = $('#operasional_id').val();
        let operasional      = $('#edit_operasional').val();
        let biaya            = $('#edit_biaya').val();
        let rentang_id       = $('#edit_rentang_id').val();
        let token            = $("meta[name='csrf-token']").attr('content');

        let formData = new FormData();
        formData.append('operasional', operasional);
        formData.append('biaya', biaya);
        formData.append('rentang_id', rentang_id);
        formData.append('_token', token);
        formData.append('_method', 'PUT');

        $.ajax({
            url: `/biaya-operasional/${operasional_id}`,
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

                $.ajax({
                    url: "/biaya-operasional/get-data",
                    type: "GET",
                    dataType: 'JSON',
                    success: function(response){
                        let counter = 1;
                        $('#table_id').DataTable().clear();
                        $.each(response.data, function(key, value){
                            let operasional = `
                            <tr class="barang-row" id="index_${value.id}">
                                <td>${counter++}</td>   
                                <td>${value.operasional}</td>
                                <td>${formatRupiah(value.biaya)}</td>
                                <td>${value.rentang.rentang_bayar}</td>
                                <td>
                                    <a href="javascript:void(0)" id="button_edit_operasional" data-id="${value.id}" class="btn btn-lg btn-warning mb-2"><i class="far fa-edit"></i> </a>
                                    <a href="javascript:void(0)" id="button_hapus_operasional" data-id="${value.id}" class="btn btn-lg btn-danger mb-2"><i class="fas fa-trash"></i> </a>
                                </td>
                            </tr>
                        `;
                        $('#table_id').DataTable().row.add($(operasional)).draw(false);
                        });
                    }
                });
                
                $('#modal_edit_operasional').modal('hide');
            },
            
            error:function(error){
                if(error.responseJSON && error.responseJSON.operasional && error.responseJSON.operasional[0]){
                    $('#alert-operasional').removeClass('d-none');
                    $('#alert-operasional').addClass('d-block');

                    $('#alert-operasional').html(error.responseJSON.operasional[0]);
                }

                if(error.responseJSON && error.responseJSON.biaya && error.responseJSON.biaya[0]){
                    $('#alert-biaya').removeClass('d-none');
                    $('#alert-biaya').addClass('d-block');

                    $('#alert-biaya').html(error.responseJSON.biaya[0]);
                }

                if(error.responseJSON && error.responseJSON.rentang_id && error.responseJSON.rentang_id[0]){
                    $('#alert-rentang_id').removeClass('d-none');
                    $('#alert-rentang_id').addClass('d-block');

                    $('#alert-rentang_id').html(error.responseJSON.rentang_id[0]);
                }
            }
        });
    });
</script>

<!-- Modal Delete Data -->
<script>
$('body').on('click', '#button_hapus_operasional', function(){
        let operasional_id = $(this).data('id');
        let token          = $("meta[name='csrf-token']").attr("content");

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
                        url: `/biaya-operasional/${operasional_id}`,
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
                                url: "/biaya-operasional/get-data",
                                type: "GET",
                                dataType: 'JSON',
                                success: function(response){
                                    let counter = 1;
                                    $('#table_id').DataTable().clear();
                                    $.each(response.data, function(key, value){
                                        let operasional = `
                                        <tr class="barang-row" id="index_${value.id}">
                                            <td>${counter++}</td>   
                                            <td>${value.operasional}</td>
                                            <td>${formatRupiah(value.biaya)}</td>
                                            <td>${value.rentang.rentang_bayar}</td>
                                            <td>
                                                <a href="javascript:void(0)" id="button_edit_operasional" data-id="${value.id}" class="btn btn-icon btn-warning btn-lg mb-2"><i class="far fa-edit"></i> </a>
                                                <a href="javascript:void(0)" id="button_hapus_operasional" data-id="${value.id}" class="btn btn-icon btn-danger btn-lg mb-2"><i class="fas fa-trash"></i> </a>
                                            </td>
                                        </tr>
                                    `;
                                    $('#table_id').DataTable().row.add($(operasional)).draw(false);
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