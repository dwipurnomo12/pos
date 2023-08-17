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
    <h1>Menu Penjualan kasir</h1>
</div>

<div class="row">
    <div class="col-lg-4">
        <div class="card card-primary">
            <div class="card-header">
                <h6>Pilih Produk</h6>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label>Pilih Produk<span style="color: red">*</span></label>
                    <select class="select2" name="nm_produk[]" id="nm_produk" multiple="multiple" style="width: 100%">
                            @foreach ($produks as $produk)
                                <option value="{{ $produk->nm_produk }}" data-harga_jual="{{ $produk->harga_jual }}"> {{ $produk->nm_produk }}</option>
                            @endforeach
                        </select>
                    <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-nm_produk"></div>
                </div>
                <button type="button" class="btn btn-primary float-right" id="store">Lanjutkan</button>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="card card-primary">
            <div class="card-header">
                <h6>Keranjang Pembelian</h6>
            </div>
            <div class="card-body">
                <div class="alert alert-primary alert-has-icon">
                    <div class="alert-icon"><i class="fas fa-money-check"></i></div>
                    <div class="alert-body">
                        <div class="alert-title total-harga" id="totalHarga">Rp. 0</div>
                    </div>
                </div>

                <table class="table table-striped" >
                    <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">Produk</th>
                        <th scope="col">Harga</th>
                        <th scope="col">QTY</th>
                        <th scope="col">Hapus</th>
                      </tr>
                    </thead>
                    <tbody id="cart">
                    </tbody>
                </table>

                <hr>

                <div class="card-body">
                    <input type="hidden" id="id">
                    <div class="form-group">
                        <label for="jenis_pembayaran">Jenis Pembayaran <span style="color: red">*</span></label>
                        <select class="form-control" id="jenis_pembayaran">
                            <option value="cash">Cash</option>
                            <option value="utang">Utang</option>
                        </select>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="jumlah_pembayaran">Jumlah Pembayaran <span style="color: red">*</span></label>
                            <div class="input-group-prepend">
                                <div class="input-group-text">Rp</div>
                                <input type="number" class="form-control" id="jumlah_pembayaran">
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="uang_kembalian">Kembalian</label>
                            <div class="input-group-prepend">
                                <div class="input-group-text">Rp</div>
                                <input type="number" class="form-control" id="uang_kembalian" disabled>
                            </div>
                        </div>
                    </div>
                    <button type="button" class="btn btn-primary float-right" id="proses_pembayaran">Proses Pembayaran</button>
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



<!-- Select2 & Autocomplete -->
<script>
    $(document).ready(function() {
        $('.select2').select2();

        var selectedProducts = [];

        $('#store').on('click', function() {
            var selectedOptions = $('#nm_produk option:selected');
    
            if (selectedOptions && selectedOptions.length > 0) {
                selectedOptions.each(function(index, option) {
                    var value = $(option).val();
    
                    if (selectedProducts.indexOf(value) === -1) {
                        selectedProducts.push(value);
                        updateKeranjang();
                    }
                });
            }
        });

        // Menampilkan product yang dipilih kasir pada keranjang
        function updateKeranjang() {
            $('#cart').empty();
            selectedProducts.forEach(function (nm_produk, index) {
                var harga       = $(`#nm_produk option[value="${nm_produk}"]`).data('harga_jual');
                var quantity    = 1;

                $('#cart').append(`
                    <tr class="cart-item" data-nm-produk="${nm_produk}">
                        <td>${index + 1}</td>
                        <td>${nm_produk}</td>
                        <td>Rp. ${harga}</td>
                        <td>
                            <button class="btn btn-sm btn-primary pengurangan-quantity">-</button>
                            <span class="quantity">${quantity}</span>
                            <button class="btn btn-sm btn-primary penambahan-quantity">+</button>
                        </td>
                        <td><button class="btn btn-sm btn-danger remove-from-cart"><i class="fa fa-regular fa-times"></i></button></td>
                    </tr>
                `);
            });
            updateTotalHarga();
        }

        // Hitung total harga produk sesuai quantity
        function hitungTotalHarga(nm_produk, quantity) {
            var harga    = $(`#nm_produk option[value="${nm_produk}"]`).data('harga_jual');
            return harga * quantity;
        }

        // Hitung semua harga yang ada di keranjang
        function updateTotalHarga() {
            var totalKeseluruhan = 0;
                $('.cart-item').each(function() {
                    var nm_produk       = $(this).data('nm-produk');
                    var quantity        = parseInt($(this).find('.quantity').text());
                    var totalHarga      = hitungTotalHarga(nm_produk, quantity);
                    totalKeseluruhan   += totalHarga;
                });
            $('#totalHarga').text('Rp. ' + totalKeseluruhan);
        }

        // Kurangi Quantity pada keranjang 
        $('#cart').on('click', '.pengurangan-quantity', function () {
            var nm_produk       = $(this).closest('.cart-item').data('nm-produk');
            var quantityElement = $(this).siblings('.quantity');
            var quantitySekarang = parseInt(quantityElement.text());

            if (quantitySekarang > 1) {
                quantitySekarang--;
                quantityElement.text(quantitySekarang);
                updateTotalHarga(nm_produk, quantitySekarang); 
            }
        });

        // Tambah Quantity pada keranjang 
        $('#cart').on('click', '.penambahan-quantity', function () {
            var nm_produk        = $(this).closest('.cart-item').data('nm-produk');
            var quantityElement = $(this).siblings('.quantity');
            var quantitySekarang = parseInt(quantityElement.text());

            quantitySekarang++;
            quantityElement.text(quantitySekarang);
            updateTotalHarga(nm_produk, quantitySekarang); 
        });

        // Hapus List Produk Dari Keranjang
        $('#cart').on('click', '.remove-from-cart', function () {
            var nm_produk = $(this).closest('.cart-item').data('nm-produk');
            var index   = selectedProducts.indexOf(nm_produk);
            if (index !== -1) {
                selectedProducts.splice(index, 1);
                $(this).closest('.cart-item').remove();
                updateKeranjang();
            }
        });

        // Proses pembayaran
        $('#proses_pembayaran').on('click', function(){
            var jenisPembayaran     = $('#jenis_pembayaran').val();
            var jumlahPembayaran    = parseFloat($('#jumlah_pembayaran').val()); 

            var produkData = [];
            var subTotal   = 0;

            $('.cart-item').each(function() {
                var nm_produk           = $(this).data('nm-produk');
                var harga_produk        = parseFloat($(this).find('td:eq(2)').text().replace('Rp. ', '')); 
                var quantity            = parseInt($(this).find('.quantity').text());
                var totalHargaProduk    = harga_produk * quantity;
                subTotal += totalHargaProduk;

                produkData.push({
                    nm_produk: nm_produk,
                    harga_produk: harga_produk,
                    quantity: quantity,
                    total_harga_produk: totalHargaProduk,
                });
            });


            var uangKembalian = jumlahPembayaran - subTotal;
            var dataPembelian = {
                jenis_pembayaran: jenisPembayaran,
                jumlah_pembayaran: jumlahPembayaran,
                produk_item: produkData,
                subTotal: subTotal,
                uangKembalian: uangKembalian
            };
            
            $('#uang_kembalian').val(uangKembalian.toString());
 
            $.ajax({
                url: '/menu-penjualan',
                method: 'POST',
                data:{
                    _token: '{{ csrf_token() }}',
                    jenis_pembayaran: jenisPembayaran,
                    jumlah_pembayaran: jumlahPembayaran
                },
                success: function(response){
                    console.log('message:', response);
                },
                error: function(xhr, status, error) {
                    console.log('Error:', error);
                }
            });

        });


    });
</script>


@endsection