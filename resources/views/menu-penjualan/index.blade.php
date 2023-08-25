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
    <div class="ml-auto">
        <button type="button" class="btn btn-danger float-right" id="refresh"><i class="fas fa-redo"></i>  Reset Form</button>
    </div>
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
                            @if ($produk->stok > 0) 
                                <option value="{{ $produk->nm_produk }}" data-harga_jual="{{ $produk->harga_jual }}"> {{ $produk->nm_produk }}</option>
                            @endif
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

                <div class="table-responsive">
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
                </div>

                <hr>

                <ul class="nav nav-tabs" id="tabPembayaran" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="cash-tab" data-toggle="tab" href="#cash" role="tab" aria-controls="cash" aria-selected="true">Pembayaran Cash</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="hutang-tab" data-toggle="tab" href="#hutang" role="tab" aria-controls="hutang" aria-selected="false">Proses Catat Hutang</a>
                    </li>
                </ul>

                <div class="tab-content" id="tabPembayaranContent">
                    <div class="tab-pane fade show active" id="cash" role="tabpanel" aria-labelledby="cash-tab">
                        <div class="card-body">
                            <div class="alert alert-success alert-dismissible show fade" id="alert-success" style="display:none">
                                <div class="alert-body">
                                  <button class="close" data-dismiss="alert">
                                    <span>&times;</span>
                                  </button>
                                  Pembayaran Sukses
                                </div>
                            </div>
                            <div class="alert alert-warning alert-dismissible show fade" id="alert-warning" style="display:none">
                                <div class="alert-body">
                                  <button class="close" data-dismiss="alert">
                                    <span>&times;</span>
                                  </button>
                                  Jumlah Uang Yang Dimasukkan Kurang
                                </div>
                            </div>
        
                            <input type="hidden" id="id">
                            <input type="hidden" name="status" id="status" value="2">
                                <div class="form-group">
                                    <label for="jumlah_pembayaran">Jumlah Pembayaran <span style="color: red">*</span></label>
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">Rp</div>
                                        <input type="number" class="form-control" id="jumlah_pembayaran" required>
                                    </div>
                                </div>
            
                                <div class="form-row">
                                    <div class="form-group col-md-4">
                                        <label for="diskon">Diskon</label>
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">%</div>
                                            <input type="number" class="form-control" name="diskon" id="diskon" value="{{ $diskon_enabled ? $diskonPresentase : 0 }}" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="ppn">PPn</label>
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">%</div>
                                            <input type="number" class="form-control" name="ppn" id="ppn" value="{{ $ppn_enabled ? $ppnPresentase : 0 }}" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-4">
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

                    <div class="tab-pane fade" id="hutang" role="tabpanel" aria-labelledby="hutang-tab">
                        <div class="card-body">

                            <div class="alert alert-success alert-dismissible show fade" id="alert-success" style="display:none">
                                <div class="alert-body">
                                  <button class="close" data-dismiss="alert">
                                    <span>&times;</span>
                                  </button>
                                  Transaksi Tersimpan Menjadi Hutang
                                </div>
                            </div>

                            <input type="hidden" id="id">
                            <input type="hidden" name="status" id="status" value="1">
                            <div class="form-group">
                                <label for="nm_pelanggan">Nama Pelanggan <span style="color: red">*</span></label>
                                <input type="text" class="form-control" name="nm_pelanggan" id="nm_pelanggan">
                            </div>
                            <div class="form-group">
                                <label for="jumlah_pembayaran">Jumlah Pembayaran <span style="color: red">*</span></label>
                                <div class="input-group-prepend">
                                    <div class="input-group-text">Rp</div>
                                    <input type="number" class="form-control" id="jumlah_pembayaran" name="jumlah_pembayaran" required>
                                </div>
                            </div>
        
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="diskon">Diskon</label>
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">%</div>
                                        <input type="number" class="form-control" name="diskon" id="diskon" value="{{ $diskon_enabled ? $diskonPresentase : 0 }}" disabled>
                                    </div>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="ppn">PPn</label>
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">%</div>
                                        <input type="number" class="form-control" name="ppn" id="ppn" value="{{ $ppn_enabled ? $ppnPresentase : 0 }}" disabled>
                                    </div>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="uang_kekurangam">Kekurangan</label>
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">Rp</div>
                                        <input type="number" class="form-control" id="uang_kekurangan" name="uang_kekurangan" disabled>
                                    </div>
                                </div>
                            </div>
                            <button type="button" class="btn btn-primary float-right" id="proses_pembayaran">Catat Hutang</button>
                        </div>
                    </div>
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
                var diskonPresentase    = parseFloat($('#diskon').val()); 
                var ppnPresentase       = parseFloat($('#ppn').val());

                var totalDiskon = (totalKeseluruhan * diskonPresentase) / 100;
                var totalPPn    = (totalKeseluruhan * ppnPresentase) / 100;

                var totalKeseluruhanFix = totalKeseluruhan - totalDiskon + totalPPn;

                $('#totalHarga').text('Rp. ' + totalKeseluruhanFix);
    
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
            var nm_produk           = $(this).closest('.cart-item').data('nm-produk');
            var quantityElement     = $(this).siblings('.quantity');
            var quantitySekarang    = parseInt(quantityElement.text());

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

        // Generate Kode Pembelian
        function generateKodePembelian() {
            var randomValue = Math.floor(Math.random() * 9999) + 1;
            var kodePembelian = 'INV-' + String(randomValue).padStart(4, '0');
            return kodePembelian;
        }

        // PrintStrukPembayaran
        function printStruk(kd_pembelian){
            var itemRows = $('#cart tr'); 
            
            var kodePembelian       = generateKodePembelian();
            var subTotal            = document.getElementById('totalHarga').innerHTML;
            var jumlahPembayaran    = parseFloat($('#jumlah_pembayaran').val());
            var uangKembalian       = parseFloat($('#uang_kembalian').val());
            var diskon              = parseFloat($('#diskon').val());
            var ppn                 = parseFloat($('#ppn').val());
            
            var item = ''; 
            itemRows.each(function() {
                var nm_produk    = $(this).data('nm-produk');
                var harga        = parseFloat($(this).find('td:eq(2)').text().replace('Rp. ', '')); 
                var jumlah       = parseInt($(this).find('.quantity').text());
                item += `
                    <tr>
                        <td>${nm_produk}</td>
                        <td>${jumlah}</td>
                        <td>${harga}</td>
                    </tr>`;
            });

            var currentDate   = new Date();
            var formattedData = currentDate.toLocaleString('id-ID', {
                day: 'numeric',
                month: 'long',
                year: 'numeric',
            });

            var kasir = '{{ Auth::user()->name }}';
            var receiptContent = `
                <div style="width: 300px; margin: 0 auto; text-align: center; border: 1px solid #000; padding: 10px;">
                    <div style="text-align: center;">
                        <h2>Toko Berkah</h2>
                        <p>Karangmulyo, Rt01/Rw.02, Purwodadi, Purworejo, Jawa Tengah</p>
                    </div>

                    <div style="float-left;">
                        Tanggal : ${formattedData} <br>
                        Kasir   : ${kasir}
                    </div>
                    
                    <p><strong>Kode Pembelian:</strong> ${kd_pembelian}</p>
                    <hr style="border-top: 1px dashed #000;">
                    <table style="width: 100%; text-align: left;">
                        <tr>
                            <th>Item</th>
                            <th>Jumlah</th>
                            <th>Harga</th>
                        </tr>
                        ${item}
                    </table>
                    <hr style="border-top: 1px dashed #000;">
                    <p><strong>Total:</strong> Rp. ${subTotal}</p>
                    <p><strong>Uang Masuk:</strong> Rp. ${jumlahPembayaran}</p>
                    <p><strong>Kembalian:</strong> Rp. ${uangKembalian}</p>
                    <p><strong>Diskon:</strong> ${diskon} %</p>
                    <p><strong>PPn:</strong> ${ppn} %</p>
                    <hr style="border-top: 1px dashed #000;">
                    <h5> LUNAS !! </h5>
                </div>
            `;
            
            var printWindow = window.open('', '_blank', 'height=500, width=500');
            printWindow.document.write(receiptContent);
            printWindow.document.close();
            printWindow.print();
        }



        // Proses pembayaran Cash
        $('#proses_pembayaran').on('click', function(){
            var status              = $('#status').val();
            var nm_pelanggan        = $('#nm_pelanggan').val();
            var jumlahPembayaran    = parseFloat($('#jumlah_pembayaran').val()); 
            var diskonPresentase    = parseFloat($('#diskon').val()); 
            var ppnPresentase       = parseFloat($('#ppn').val());
            var produkData          = [];
            var subTotal            = 0;

            $('.cart-item').each(function() {
                var nm_produk           = $(this).data('nm-produk');
                var harga_produk        = parseFloat($(this).find('td:eq(2)').text().replace('Rp. ', '')); 
                var quantity            = parseInt($(this).find('.quantity').text());
                var totalHargaProduk    = harga_produk * quantity;
                
                var totalDiskon = (totalHargaProduk * diskonPresentase) / 100;
                var totalPPn    = (totalHargaProduk * ppnPresentase) / 100;

                var totalPerItem = totalHargaProduk - totalDiskon + totalPPn;
                subTotal += totalPerItem;

                produkData.push({
                    nm_produk: nm_produk,
                    harga_produk: harga_produk,
                    quantity: quantity,
                    total_harga_produk: totalHargaProduk,
                });
            });

            var uangKembalian   = jumlahPembayaran - subTotal;
            var uangKekurangan  = subTotal - jumlahPembayaran;
            var dataPembelian = {
                jumlah_pembayaran: jumlahPembayaran,
                produk_item: produkData,
                subTotal: subTotal,
                uangKembalian: uangKembalian,
                uangKekurangan: uangKekurangan
            };
            
            $('#uang_kembalian').val(uangKembalian.toString());
            $('#uang_kekurangan').val(uangKekurangan.toString());
 
            if(uangKembalian < 0){
                $('#alert-warning').show();
            } else {
                $.ajax({
                    url: '/menu-penjualan',
                    method: 'POST',
                    data:{
                        _token: '{{ csrf_token() }}',
                        status: status,
                        nm_pelanggan: nm_pelanggan,
                        jumlah_pembayaran: jumlahPembayaran,
                        diskon: diskonPresentase,
                        ppn: ppnPresentase,
                        pembelian_item: dataPembelian.produk_item,
                        sub_total: dataPembelian.subTotal,
                        uang_kembalian: dataPembelian.uangKembalian || 0,
                        uang_kekurangan: dataPembelian.uangKekurangan || 0
                    },
                    
                    success: function(response){
                        $('#alert-success').show();
                        var kd_pembelian = response.kd_pembelian;
                        printStruk(kd_pembelian);
                    },
                    error: function(xhr, status, error) {
                        console.log('Error:', error);
                    }
                });
            }
        });


        // Refresh Form
        $('#refresh').on('click', function(){
            $('#jumlah_pembayaran').val('');
            $('#nm_produk').val([]).trigger('change');
            $('#alert-success').remove();

            $('#cart').empty();

            $('#totalHarga').text('Rp. 0');
            $('#uang_kembalian').val('0');
        });
    });
</script>


@endsection