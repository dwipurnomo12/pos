@extends('layouts.app')

@include('kategori.create')
@include('kategori.edit')

@section('content')
    <div class="section-header">
        <h1>Kategori Produk</h1>
        <div class="ml-auto">
            <a href="javascript:void(0)" class="btn btn-primary" id="button_tambah_kategori"><i class="fa fa-plus"></i> Tambah
                Kategori</a>
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
                                    <th>Kategori</th>
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
        $(document).ready(function() {
            $('#table_id').DataTable();

            $.ajax({
                url: "/kategori/get-data",
                type: "GET",
                dataType: 'JSON',
                success: function(response) {
                    let counter = 1;
                    $('#table_id').DataTable().clear();
                    $.each(response.data, function(key, value) {
                        let kategori = `
                        <tr class="barang-row" id="index_${value.id}">
                            <td>${counter++}</td>   
                            <td>${value.kategori}</td>
                            <td>
                                <a href="javascript:void(0)" id="button_edit_kategori" data-id="${value.id}" class="btn btn-lg btn-warning mb-2"><i class="far fa-edit"></i> </a>
                                <a href="javascript:void(0)" id="button_hapus_kategori" data-id="${value.id}" class="btn btn-lg btn-danger mb-2"><i class="fas fa-trash"></i> </a>
                            </td>
                        </tr>
                    `;
                        $('#table_id').DataTable().row.add($(kategori)).draw(false);
                    });
                }
            });
        });
    </script>

    <!-- Show Modal Tambah & Function Store Data -->
    <script>
        $('body').on('click', '#button_tambah_kategori', function() {
            $('#modal_tambah_kategori').modal('show');
            clearAlert();
        });

        function clearAlert() {
            $('#alert-kategori').removeClass('d-block').addClass('d-none');
        }

        $('#store').click(function(e) {
            e.preventDefault();

            let kategori = $('#kategori').val();
            let token = $("meta[name='csrf-token']").attr("content");

            let formData = new FormData();
            formData.append('kategori', kategori);
            formData.append('_token', token);

            $.ajax({
                url: '/kategori',
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
                        url: '/kategori/get-data',
                        type: "GET",
                        cache: false,
                        success: function(response) {

                            let counter = 1;
                            $('#table_id').DataTable().clear();
                            $.each(response.data, function(key, value) {
                                let kategori = `
                                <tr class="barang-row" id="index_${value.id}">
                                    <td>${counter++}</td>   
                                    <td>${value.kategori}</td>
                                    <td>
                                        <a href="javascript:void(0)" id="button_edit_kategori" data-id="${value.id}" class="btn btn-icon btn-warning btn-lg mb-2"><i class="far fa-edit"></i> </a>
                                        <a href="javascript:void(0)" id="button_hapus_kategori" data-id="${value.id}" class="btn btn-icon btn-danger btn-lg mb-2"><i class="fas fa-trash"></i> </a>
                                    </td>
                                </tr>
                             `;
                                $('#table_id').DataTable().row.add($(kategori))
                                    .draw(false);
                            });

                            $('#kategori').val('');
                            $('#modal_tambah_kategori').modal('hide');

                            let table = $('#table_id').DataTable();
                            table.draw();
                        },
                        error: function(error) {
                            console.log(error);
                        }
                    })
                },

                error: function(error) {
                    if (error.responseJSON && error.responseJSON.kategori && error.responseJSON
                        .kategori[0]) {
                        $('#alert-kategori').removeClass('d-none');
                        $('#alert-kategori').addClass('d-block');

                        $('#alert-kategori').html(error.responseJSON.kategori[0]);
                    }
                }
            });
        });
    </script>

    <!-- Show Modal Edit & Update Proccess -->
    <script>
        $('body').on('click', '#button_edit_kategori', function() {
            let kategori_id = $(this).data('id');
            clearAlert();

            $.ajax({
                url: `/kategori/${kategori_id}/edit`,
                type: "GET",
                cache: false,
                success: function(response) {
                    $('#kategori_id').val(response.data.id);
                    $('#edit_kategori').val(response.data.kategori);

                    $('#modal_edit_kategori').modal('show');
                }
            });
        });

        function clearAlert() {
            $('#alert-kategori').removeClass('d-block').addClass('d-none');
        }

        $('#update').click(function(e) {
            e.preventDefault();

            let kategori_id = $('#kategori_id').val();
            let kategori = $('#edit_kategori').val();
            let token = $("meta[name='csrf-token']").attr('content');

            let formData = new FormData();
            formData.append('kategori', kategori);
            formData.append('_token', token);
            formData.append('_method', 'PUT');

            $.ajax({
                url: `/kategori/${kategori_id}`,
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

                    let row = $(`#index_${response.data.id}`);
                    let rowData = row.find('td');
                    rowData.eq(1).text(response.data.kategori);

                    $('#modal_edit_kategori').modal('hide');
                },

                error: function(error) {
                    if (error.responseJSON && error.responseJSON.edit_kategori && error.responseJSON
                        .edit_kategori[0]) {
                        $('#alert-edit_kategori').removeClass('d-none');
                        $('#alert-edit_kategori').addClass('d-block');

                        $('#alert-edit_kategori').html(error.responseJSON.edit_kategori[0]);
                    }
                }
            });
        });
    </script>

    <!-- Modal Delete Data -->
    <script>
        $('body').on('click', '#button_hapus_kategori', function() {
            let kategori_id = $(this).data('id');
            let token = $("meta[name='csrf-token']").attr("content");

            Swal.fire({
                title: 'Apakah Kamu Yakin?',
                text: "ingin menghapus data ini !",
                icon: 'warning',
                showCancelButton: true,
                cancelButtonText: 'TIDAK',
                confirmButtonText: 'YA, HAPUS!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `/kategori/${kategori_id}`,
                        type: "DELETE",
                        cache: false,
                        data: {
                            "_token": token
                        },
                        success: function(response) {
                            Swal.fire({
                                type: 'success',
                                icon: 'success',
                                title: `${response.message}`,
                                showConfirmButton: true,
                                timer: 3000
                            });
                            $('#table_id').DataTable().clear().draw();

                            $.ajax({
                                url: "/kategori/get-data",
                                type: "GET",
                                dataType: 'JSON',
                                success: function(response) {
                                    let counter = 1;
                                    $('#table_id').DataTable().clear();
                                    $.each(response.data, function(key, value) {
                                        let kategori = `
                                        <tr class="barang-row" id="index_${value.id}">
                                            <td>${counter++}</td>   
                                            <td>${value.kategori}</td>
                                            <td>
                                                <a href="javascript:void(0)" id="button_edit_kategori" data-id="${value.id}" class="btn btn-icon btn-warning btn-lg mb-2"><i class="far fa-edit"></i> </a>
                                                <a href="javascript:void(0)" id="button_hapus_kategori" data-id="${value.id}" class="btn btn-icon btn-danger btn-lg mb-2"><i class="fas fa-trash"></i> </a>
                                            </td>
                                        </tr>
                                    `;
                                        $('#table_id').DataTable().row.add(
                                            $(kategori)).draw(false);
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
