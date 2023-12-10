@extends('layouts.app')

@include('karyawan.create')
@include('karyawan.edit')

@section('content')
    <div class="section-header">
        <h1>Karyawan</h1>
        <div class="ml-auto">
            <a href="javascript:void(0)" class="btn btn-primary" id="button_tambah_karyawan"><i class="fa fa-plus"></i> Tambah
                Karyawan</a>
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
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Jabatan</th>
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


    <!-- Fetch Data -->
    <script>
        $(document).ready(function() {
            $('#table_id').DataTable();
            $.ajax({
                url: "/karyawan/get-data",
                type: "GET",
                dataType: 'JSON',
                success: function(response) {
                    let counter = 1;
                    $('#table_id').DataTable().clear();
                    $.each(response.data, function(key, value) {
                        let karyawan = `
                        <tr class="barang-row" id="index_${value.id}">
                            <td>${counter++}</td>   
                            <td>${value.name}</td>
                            <td>${value.email}</td>
                            <td>${value.role.role}</td>
                            <td>
                                <a href="javascript:void(0)" id="button_edit_karyawan" data-id="${value.id}" class="btn btn-lg btn-warning mb-2"><i class="far fa-edit"></i> </a>
                                <a href="javascript:void(0)" id="button_hapus_karyawan" data-id="${value.id}" class="btn btn-lg btn-danger mb-2"><i class="fas fa-trash"></i> </a>
                            </td>
                        </tr>
                    `;
                        $('#table_id').DataTable().row.add($(karyawan)).draw(false);
                    });
                }
            });
        });
    </script>

    <!-- Show Modal Tambah & Function Store Data -->
    <script>
        $('body').on('click', '#button_tambah_karyawan', function() {
            $('#modal_tambah_karyawan').modal('show');
            clearAlert();
        });

        function clearAlert() {
            $('#alert-name').removeClass('d-block').addClass('d-none');
            $('#alert-email').removeClass('d-block').addClass('d-none');
            $('#alert-password').removeClass('d-block').addClass('d-none');
            $('#alert-role_id').removeClass('d-block').addClass('d-none');
        }

        $('#store').click(function(e) {
            e.preventDefault();

            let name = $('#name').val();
            let email = $('#email').val();
            let password = $('#password').val();
            let role_id = $('#role_id').val();
            let token = $("meta[name='csrf-token']").attr("content");

            let formData = new FormData();
            formData.append('name', name);
            formData.append('email', email);
            formData.append('password', password);
            formData.append('role_id', role_id);
            formData.append('_token', token);

            $.ajax({
                url: '/karyawan',
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
                        url: '/karyawan/get-data',
                        type: "GET",
                        cache: false,
                        success: function(response) {

                            let counter = 1;
                            $('#table_id').DataTable().clear();
                            $.each(response.data, function(key, value) {
                                let karyawan = `
                                <tr class="barang-row" id="index_${value.id}">
                                    <td>${counter++}</td>   
                                    <td>${value.name}</td>
                                    <td>${value.email}</td>
                                    <td>${value.role.role}</td>
                                    <td>
                                        <a href="javascript:void(0)" id="button_edit_karyawan" data-id="${value.id}" class="btn btn-lg btn-warning mb-2"><i class="far fa-edit"></i> </a>
                                        <a href="javascript:void(0)" id="button_hapus_karyawan" data-id="${value.id}" class="btn btn-lg btn-danger mb-2"><i class="fas fa-trash"></i> </a>
                                    </td>
                                </tr>
                             `;
                                $('#table_id').DataTable().row.add($(karyawan))
                                    .draw(false);
                            });

                            $('#name').val('');
                            $('#email').val('');
                            $('#password').val('');
                            $('#role_id').val('');

                            $('#modal_tambah_karyawan').modal('hide');

                            let table = $('#table_id').DataTable();
                            table.draw();
                        },
                        error: function(error) {
                            console.log(error);
                        }
                    })
                },

                error: function(error) {
                    if (error.responseJSON && error.responseJSON.name && error.responseJSON.name[0]) {
                        $('#alert-name').removeClass('d-none');
                        $('#alert-name').addClass('d-block');

                        $('#alert-name').html(error.responseJSON.name[0]);
                    }

                    if (error.responseJSON && error.responseJSON.email && error.responseJSON.email[0]) {
                        $('#alert-email').removeClass('d-none');
                        $('#alert-email').addClass('d-block');

                        $('#alert-email').html(error.responseJSON.email[0]);
                    }

                    if (error.responseJSON && error.responseJSON.password && error.responseJSON
                        .password[0]) {
                        $('#alert-password').removeClass('d-none');
                        $('#alert-password').addClass('d-block');

                        $('#alert-password').html(error.responseJSON.password[0]);
                    }

                    if (error.responseJSON && error.responseJSON.role_id && error.responseJSON.role_id[
                            0]) {
                        $('#alert-role_id').removeClass('d-none');
                        $('#alert-role_id').addClass('d-block');

                        $('#alert-role_id').html(error.responseJSON.role_id[0]);
                    }
                }
            });
        });
    </script>

    <!-- Show Modal Edit & Update Proccess -->
    <script>
        $('body').on('click', '#button_edit_karyawan', function() {
            let karyawan_id = $(this).data('id');
            clearAlert();

            $.ajax({
                url: `/karyawan/${karyawan_id}/edit`,
                type: "GET",
                cache: false,
                success: function(response) {
                    $('#karyawan_id').val(response.data.id);
                    $('#edit_name').val(response.data.name);
                    $('#edit_email').val(response.data.email);
                    $('#edit_password').val(response.data.password);
                    $('#edit_role_id').val(response.data.role_id);

                    $('#modal_edit_karyawan').modal('show');
                }
            });
        });

        function clearAlert() {
            $('#alert-karyawan').removeClass('d-block').addClass('d-none');
        }

        $('#update').click(function(e) {
            e.preventDefault();

            let karyawan_id = $('#karyawan_id').val();
            let name = $('#edit_name').val();
            let email = $('#edit_email').val();
            let password = $('#edit_password').val();
            let role_id = $('#edit_role_id').val();
            let token = $("meta[name='csrf-token']").attr('content');

            let formData = new FormData();
            formData.append('name', name);
            formData.append('email', email);
            formData.append('role_id', role_id);
            formData.append('_token', token);
            formData.append('_method', 'PUT');

            if (password !== '') {
                formData.append('password', password);
            }

            $.ajax({
                url: `/karyawan/${karyawan_id}`,
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
                        url: "/karyawan/get-data",
                        type: "GET",
                        dataType: 'JSON',
                        success: function(response) {
                            let counter = 1;
                            $('#table_id').DataTable().clear();
                            $.each(response.data, function(key, value) {
                                let karyawan = `
                            <tr class="barang-row" id="index_${value.id}">
                                <td>${counter++}</td>   
                                <td>${value.name}</td>
                                <td>${value.email}</td>
                                <td>${value.role.role}</td>
                                <td>
                                    <a href="javascript:void(0)" id="button_edit_karyawan" data-id="${value.id}" class="btn btn-lg btn-warning mb-2"><i class="far fa-edit"></i> </a>
                                    <a href="javascript:void(0)" id="button_hapus_karyawan" data-id="${value.id}" class="btn btn-lg btn-danger mb-2"><i class="fas fa-trash"></i> </a>
                                </td>
                            </tr>
                        `;
                                $('#table_id').DataTable().row.add($(karyawan))
                                    .draw(false);
                            });
                        }
                    });

                    $('#modal_edit_karyawan').modal('hide');
                },

                error: function(error) {
                    if (error.responseJSON && error.responseJSON.edit_karyawan && error.responseJSON
                        .edit_karyawan[0]) {
                        $('#alert-edit_karyawan').removeClass('d-none');
                        $('#alert-edit_karyawan').addClass('d-block');

                        $('#alert-edit_karyawan').html(error.responseJSON.edit_karyawan[0]);
                    }
                }
            });
        });
    </script>

    <!-- Modal Delete Data -->
    <script>
        $('body').on('click', '#button_hapus_karyawan', function() {
            let karyawan_id = $(this).data('id');
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
                        url: `/karyawan/${karyawan_id}`,
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
                                url: "/karyawan/get-data",
                                type: "GET",
                                dataType: 'JSON',
                                success: function(response) {
                                    let counter = 1;
                                    $('#table_id').DataTable().clear();
                                    $.each(response.data, function(key, value) {
                                        let karyawan = `
                                        <tr class="barang-row" id="index_${value.id}">
                                            <td>${counter++}</td>   
                                            <td>${value.name}</td>
                                            <td>${value.email}</td>
                                            <td>${value.role.role}</td>
                                            <td>
                                                <a href="javascript:void(0)" id="button_edit_karyawan" data-id="${value.id}" class="btn btn-lg btn-warning mb-2"><i class="far fa-edit"></i> </a>
                                                <a href="javascript:void(0)" id="button_hapus_karyawan" data-id="${value.id}" class="btn btn-lg btn-danger mb-2"><i class="fas fa-trash"></i> </a>
                                            </td>
                                        </tr>
                                    `;
                                        $('#table_id').DataTable().row.add(
                                            $(karyawan)).draw(false);
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
