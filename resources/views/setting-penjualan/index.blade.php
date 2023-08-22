@extends('layouts.app')

@section('content')

<div class="section-header">
    <h1>Setting Penjualan (Diskon & PPn)</h1>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="card card-primary">
            <div class="card-body">
                <h5 class="card-title">Pengaturan Diskon</h5>
                <form id="updateDiskonForm" data-action="/setting-penjualan/update-diskon">
                    @csrf
                    <div class="form-group">
                        <label for="diskon_enabled">Aktifkan Diskon</label>
                        <input type="checkbox" name="diskon_enabled" id="diskon_enabled" value="1" @if($settingPenjualan->diskon_enabled) checked @endif>
                    </div>
                    <div class="form-group">
                        <label for="diskon_presentase">Persentase Diskon</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text"> % </div>
                            </div>
                            <input type="number" name="diskon_presentase" id="diskon_presentase" class="form-control" value="{{ $settingPenjualan->diskon_presentase ?? '' }}">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary updateButton">Simpan Pengaturan Diskon</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-lg-12">
        <div class="card card-primary">
            <div class="card-body">
                <h5 class="card-title">Pengaturan PPn</h5>
                <form id="updatePpnForm" data-action="/setting-penjualan/update-ppn">
                    @csrf
                    <div class="form-group">
                        <label for="ppn_enabled">Aktifkan PPn</label>
                        <input type="checkbox" name="ppn_enabled" id="ppn_enabled" value="1" @if($settingPenjualan->ppn_enabled) checked @endif>
                    </div>
                    <div class="form-group">
                        <label for="ppn_presentase">Persentase PPn</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text"> % </div>
                            </div>
                            <input type="number" name="ppn_presentase" id="ppn_presentase" class="form-control" value="{{ $settingPenjualan->ppn_presentase ?? '' }}">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary updateButton">Simpan Pengaturan PPn</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Function Update Diskon -->
<script>
    $(document).ready(function(){
        $('.updateButton').click(function(){
            event.preventDefault();

            var form = $(this).closest('form');
            $.ajax({
                url: form.data('action'),
                type: 'POST',
                data: form.serialize(),
                success: function(response) {
                    Swal.fire({
                        type: 'success',
                        icon: 'success',
                        title: `${response.message}`,
                        showConfirmButton: true,
                        timer: 3000
                    });
                },
                error: function(response) {
                    Swal.fire({
                        type: 'error',
                        icon: 'error',
                        title: `${response.message}`,
                        showConfirmButton: true,
                        timer: 3000
                    });
                }
            });
        });
    });
</script>

@endsection
