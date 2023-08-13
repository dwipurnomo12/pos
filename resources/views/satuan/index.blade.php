@extends('layouts.app')

@include('satuan.create')
@include('satuan.edit')

@section('content')

<div class="section-header">
    <h1>Satuan Produk</h1>
    <div class="ml-auto">
        <a href="javascript:void(0)" class="btn btn-primary" id="button_tambah_satuan"><i class="fa fa-plus"></i> Tambah Satuan</a>
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
                                <th>Satuan</th>
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
        url: "/satuan/get-data",
        type: "GET",
        dataType: 'JSON',
        success: function(response){
            let counter = 1;
            $('#table_id').DataTable().clear();
            $.each(response.data, function(key, value){
                let satuan = `
                <tr class="barang-row" id="index_${value.id}">
                    <td>${counter++}</td>   
                    <td>${value.satuan}</td>
                    <td>
                        <a href="javascript:void(0)" id="button_edit_satuan" data-id="${value.id}" class="btn btn-lg btn-warning mb-2"><i class="far fa-edit"></i> </a>
                        <a href="javascript:void(0)" id="button_hapus_satuan" data-id="${value.id}" class="btn btn-lg btn-danger mb-2"><i class="fas fa-trash"></i> </a>
                    </td>
                </tr>
            `;
            $('#table_id').DataTable().row.add($(satuan)).draw(false);
            });
        }
    });
</script>

<!-- Show Modal Tambah & Function Store Data -->
<script>
    $('body').on('click', '#button_tambah_satuan', function(){
        $('#modal_tambah_satuan').modal('show');
        clearAlert();
    });

    function clearAlert(){
        $('#alert-satuan').removeClass('d-block').addClass('d-none');
    }
    
    $('#store').click(function(e){
        e.preventDefault();

        let satuan   = $('#satuan').val();
        let token    = $("meta[name='csrf-token']").attr("content");

        let formData = new FormData();
        formData.append('satuan', satuan);
        formData.append('_token', token);

        $.ajax({
            url : '/satuan',
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
                    url : '/satuan/get-data',
                    type: "GET",
                    cache: false,
                    success:function(response){

                        let counter = 1;
                        $('#table_id').DataTable().clear();
                        $.each(response.data, function(key, value){
                            let satuan = `
                                <tr class="barang-row" id="index_${value.id}">
                                    <td>${counter++}</td>   
                                    <td>${value.satuan}</td>
                                    <td>
                                        <a href="javascript:void(0)" id="button_edit_satuan" data-id="${value.id}" class="btn btn-icon btn-warning btn-lg mb-2"><i class="far fa-edit"></i> </a>
                                        <a href="javascript:void(0)" id="button_hapus_satuan" data-id="${value.id}" class="btn btn-icon btn-danger btn-lg mb-2"><i class="fas fa-trash"></i> </a>
                                    </td>
                                </tr>
                             `;
                        $('#table_id').DataTable().row.add($(satuan)).draw(false);
                        });

                        $('#satuan').val('');
                        $('#modal_tambah_satuan').modal('hide');

                        let table = $('#table_id').DataTable();
                        table.draw();
                    },
                    error:function(error){
                        console.log(error);
                    }
                })
            },

            error:function(error){
                if(error.responseJSON && error.responseJSON.satuan && error.responseJSON.satuan[0]){
                    $('#alert-satuan').removeClass('d-none');
                    $('#alert-satuan').addClass('d-block');

                    $('#alert-satuan').html(error.responseJSON.satuan[0]);
                }
            }
        });
    });
</script>

<!-- Show Modal Edit & Update Proccess -->
<script>
    $('body').on('click', '#button_edit_satuan', function(){
        let satuan_id = $(this).data('id');

        $.ajax({
            url: `/satuan/${satuan_id}/edit`,
            type: "GET",
            cache: false,
            success:function(response){
                $('#satuan_id').val(response.data.id);
                $('#edit_satuan').val(response.data.satuan);

                $('#modal_edit_satuan').modal('show');
            }
        });
    });

    $('#update').click(function(e){
        e.preventDefault();

        let satuan_id   = $('#satuan_id').val();
        let satuan      = $('#edit_satuan').val();
        let token        = $("meta[name='csrf-token']").attr('content');

        let formData = new FormData();
        formData.append('satuan', satuan);
        formData.append('_token', token);
        formData.append('_method', 'PUT');

        $.ajax({
            url: `/satuan/${satuan_id}`,
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
                rowData.eq(1).text(response.data.satuan);
                
                $('#modal_edit_satuan').modal('hide');
            },
            
            error:function(error){
                if(error.responseJSON && error.responseJSON.satuan && error.responseJSON.satuan[0]){
                    $('#alert-satuan').removeClass('d-none');
                    $('#alert-satuan').addClass('d-block');

                    $('#alert-satuan').html(error.responseJSON.satuan[0]);
                }
            }
        });
    });
</script>

<!-- Modal Delete Data -->
<script>
$('body').on('click', '#button_hapus_satuan', function(){
        let satuan_id = $(this).data('id');
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
                        url: `/satuan/${satuan_id}`,
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
                                url: "/satuan/get-data",
                                type: "GET",
                                dataType: 'JSON',
                                success: function(response){
                                    let counter = 1;
                                    $('#table_id').DataTable().clear();
                                    $.each(response.data, function(key, value){
                                        let satuan = `
                                        <tr class="barang-row" id="index_${value.id}">
                                            <td>${counter++}</td>   
                                            <td>${value.satuan}</td>
                                            <td>
                                                <a href="javascript:void(0)" id="button_edit_satuan" data-id="${value.id}" class="btn btn-icon btn-warning btn-lg mb-2"><i class="far fa-edit"></i> </a>
                                                <a href="javascript:void(0)" id="button_hapus_satuan" data-id="${value.id}" class="btn btn-icon btn-danger btn-lg mb-2"><i class="fas fa-trash"></i> </a>
                                            </td>
                                        </tr>
                                    `;
                                    $('#table_id').DataTable().row.add($(satuan)).draw(false);
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