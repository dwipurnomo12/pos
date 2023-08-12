<div class="modal fade" role="dialog" id="modal_tambah_barangMasuk">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Produk</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Pilih Barang Masuk <span style="color: red">*</span></label>
                                <select class="select2" name="nm_produk" id="nm_produk" style="width: 100%">
                                <option selected>Pilih Barang</option>
                                    @foreach ($produks as $produk)
                                        <option value="{{ $produk->nm_produk }}">{{ $produk->nm_produk }}</option>
                                    @endforeach
                                </select>
                                <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-nm_produk"></div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>Tetapkan Harga Beli <span style="color: red">*</span></label>
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">Rp</div>
                                        <input type="number" class="form-control" name="harga_beli" id="harga_beli">  
                                    </div>
                                    <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-harga_beli"></div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Tetapkan Harga Jual <span style="color: red">*</span></label>
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">Rp</div>
                                        <input type="number" class="form-control" name="harga_jual" id="harga_jual">  
                                    </div>
                                    <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-harga_jual"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Tanggal Produk Masuk</label>
                                <input type="text" class="form-control" name="tgl_masuk" id="tgl_masuk" disabled>  
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>Stok Masuk <span style="color: red">*</span></label>
                                    <input type="number" class="form-control" name="stok_masuk" id="stok_masuk">  
                                    <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-stok_masuk"></div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Stok Saat Ini</label>
                                    <input type="number" class="form-control" name="stok" id="stok" disabled>  
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="modal-footer bg-whitesmoke br">
                    <p class="text-on-left"><span style="color: red">*</span> Artinya form wajib di isi !</p>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Keluar</button>
                    <button type="button" class="btn btn-primary" id="store">Tambah</button>
                </div>
            </form>
        </div>
    </div>
</div>
